<?php

namespace App\Commands;

use App\Services\Checker;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Support\Collection;
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
        $this->getLocations()
            ->each(function ($location) {
                $path = (new Uri($location->textContent))->getPath();

                $results = collect(app(Checker::class)->validate($location->textContent));

                $this->info($this->buildMessage(
                    $path,
                    $results->where('passed', true)->count(),
                    $results->where('passed', false)->count()
                ));

                $this->output->writeln("");

                $results->where('passed', false)->each(function ($result) {
                    $this->warn("\t" . $result['message']);
                });

                $this->output->writeln("");
                $this->output->writeln("");
            });
    }

    /**
     * @return Collection
     */
    protected function getLocations(): Collection
    {
        $client = new Client();
        $response = $client->request('GET', $this->argument('sitemap'));

        $crawler = new Crawler($response->getBody()->getContents());
        return collect($crawler->filterXPath('//loc'));
    }

    /**
     * @param $path
     * @param $passed
     * @param $failed
     * @return string
     */
    protected function buildMessage($path, $passed, $failed): string
    {
        return sprintf("\xf0\x9f\x91\x8d  %d | \xF0\x9F\x91\x8E  %d\t%s", $passed, $failed, $path);
    }
}
