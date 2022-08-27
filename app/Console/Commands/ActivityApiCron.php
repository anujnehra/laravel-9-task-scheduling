<?php

namespace App\Console\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class ActivityApiCron extends Command
{
    const BASE_URL = ['base_uri' => 'http://www.boredapi.com/'];
    const ACTIVITY_URL = 'api/activity';

    /**
     * GuzzleHttp Client.
     *
     * @var Client
     */
    protected Client $httpClient;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activity_api:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get list of activities from boredapi';

    /**
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->httpClient = new Client(self::BASE_URL);
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws GuzzleException
     */
    public function handle(): void
    {
        while (true) {
            try {
                $request = $this->httpClient->get(self::ACTIVITY_URL);
                $response = $request->getBody()->getContents();
                $activity = json_decode($response, true);
                $this->info('Getting activity from API');
                DB::table('activities')->insert($activity);
                $this->info('Inserting activity into table');
            } catch (\Exception $e) {
                Log::debug('Error Method: ' . __METHOD__);
                Log::error('Error Message: ' . $e->getMessage());
            }
            //running every 10 sec this way because cron only has a resolution of 1 min
            sleep(intval(10));
        }
    }
}
