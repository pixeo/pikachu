<?php

namespace App\Commands;

use App\Services\Checker;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use LaravelZero\Framework\Commands\Command;
use Symfony\Component\DomCrawler\Crawler;

class CheckSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check {sitemap}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks your site';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $client = new Client();
        $response = $client->request('GET', $this->argument('sitemap'));

        $crawler = new Crawler($response->getBody()->getContents());
        $locations = $crawler->filterXPath('//loc');

        $maxLength = collect($locations)->max(function ($location) {
            return strlen((new Uri($location->textContent))->getPath());
        });

        foreach ($locations as $location) {
            $path = (new Uri($location->textContent))->getPath();

            $results = collect(app(Checker::class)->validate($location->textContent));

            $message = sprintf(
                "%s%s\xf0\x9f\x91\x8d  %d | \xF0\x9F\x91\x8E  %d",
                $path,
                str_repeat(" ", ($maxLength - strlen($path)) + 5),
                $results->where('passed', true)->count(),
                $results->where('passed', false)->count()
            );

            $this->info($message);
            $this->output->writeln("");

            $results->where('passed', false)->each(function ($result) {
                $this->warn("\t" . $result['message']);
            });

            $this->output->writeln("");
            $this->output->writeln("");
        }

    }
}
