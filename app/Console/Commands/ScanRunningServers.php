<?php

namespace App\Console\Commands;

use App\Models\BBBServerMeeting;
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\IsMeetingRunningParameters;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ScanRunningServers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronjob:scanrunningservers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will change BBB meeting to stopped state if needed';

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
    public function handle()
    {
        Log::info("==========CRON JOB: Scanning for running meeting========");
        $meetingServers = BBBServerMeeting::where('status', config('constants.status.running'))->get();
        foreach ($meetingServers as $meetingServer) {
            try {
                $meetingId = $meetingServer->meeting_id;
                $meetingName = $meetingServer->meeting_name;
                $serverInfo = getServerForTheMeeting($meetingId);
                $bbb = new BigBlueButton();
                $bbb->setBBBServerInfo($serverInfo->base_url, $serverInfo->sec_secret);

                $isMeetingRunningParams = new IsMeetingRunningParameters($meetingId);
                $response = $bbb->isMeetingRunning($isMeetingRunningParams);
                if ($response->getReturnCode() != 'FAILED') {
                    if (!$response->isRunning()) {
                        Log::info("Changed state of meeting with name ".$meetingName." to stopped");
                        $meetingServer->status = config('constants.status.stopped');
                        $meetingServer->save();
                    }
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }

        }
    }
}
