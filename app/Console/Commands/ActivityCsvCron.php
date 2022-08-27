<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ActivityCsvCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activity_csv:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get list of activities from db and write to csv';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->info('Fetching activity from table');
        $activities = DB::table('activities')
            ->select('type',
                DB::raw('MAX(price) as "max_price"'),
                DB::raw('ROUND(AVG(price), 2) as "average_price"'),
                DB::raw('SUM(participants) as "total_participants"')
            )
            ->groupBy('type')
            ->get()->toArray();

        $filename = "activities_record_" . time() . ".csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Type', 'Max Price', 'Average Price', 'Total Participants']);

        foreach ($activities as $row) {
            fputcsv($handle, [$row->type, $row->max_price, $row->average_price, $row->total_participants]);
        }

        fclose($handle);

        $this->info('Writing activity into CSV file');
    }
}
