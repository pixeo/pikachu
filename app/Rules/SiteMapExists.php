<?php

namespace App\Rules;

use App\Crawler;
use App\Services\RobotsFile;
use App\Services\UrlHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class SiteMapExists extends Rule
{
    private $failedMsg;
    private $passedMsg;

    /**
     * {@inheritdoc}
     */
    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri)
    {
        /** @var \RobotsTxtParser $parser */
        $parser = app(RobotsFile::class)->getParser();
        if (!$maps = $parser->getSitemaps()) {
            $maps = [app(UrlHelper::class)->getDefaultSiteMapUrl((string) $uri)];
        }

        $validMaps = [];
        $invalidMaps = [];

        foreach ($maps as $map) {
            $map = app(UrlHelper::class)->absolutize($map, $uri);
            if (app(UrlHelper::class)->exists($map)) {
                $validMaps[] = "`$map`";
            } else {
                $invalidMaps[] = "`$map`";
            }
        }

        if ($invalidMaps) {
            $this->failedMsg = 'Site map(s) not found at '.implode(', ', $invalidMaps).'.';

            return false;
        }

        $this->passedMsg = 'Site map(s) found at '.implode(', ', $validMaps).'.';

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function passedMessage()
    {
        return $this->passedMsg;
    }

    /**
     * {@inheritdoc}
     */
    public function failedMessage()
    {
        return $this->failedMsg;
    }

    /**
     * {@inheritdoc}
     */
    public function helpMessage()
    {
        return <<<'MSG'
An [XML Sitemap](https://en.wikipedia.org/wiki/Site_map#XML_Sitemaps) is a structured format that a user doesn’t need to see, but it tells the search engine about the pages in a site, their relative importance to each other, and how often they are updated. Having a proper, up-to-date sitemap can greatly benefit your site’s SEO result, thus is highly recommended, kupo!  
MSG;
    }
}
