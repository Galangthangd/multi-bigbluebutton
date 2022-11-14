<?php

namespace App\Console\Commands;

use App\Models\BBBServerMeeting;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class StopUnusedMeeting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronjob:stopunusedmeeting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will stop all meeting unused';

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
        Log::info("==========CRON JOB: Scanning for unused running server========");
        $meetingServers = BBBServerMeeting::where('status', config('constants.status.running'))->get();
        foreach ($meetingServers as $meetingServer) {
            try {
                $meetingId = $meetingServer->meeting_id;
                endMeeting($meetingId);
            } catch(Exception $e) {
                Log::error($e->getMessage());
            }

//            $meetingName = $meetingServer->meeting_name;
//            $serverInfo = getServerForTheMeeting($meetingId);
//            $bbb = new BigBlueButton();
//            $bbb->setBBBServerInfo($serverInfo->base_url, $serverInfo->sec_secret);
//
//            $getMeetingInfoParams = new GetMeetingInfoParameters($meetingId, 123);
//            $response = $bbb->getMeetingInfo($getMeetingInfoParams);
//            if ($response->getReturnCode() !== 'FAILED') {
//
//                $modPw = $response->getMeeting()->getModeratorPassword();
//
//                $endMeetingParams = new EndMeetingParameters($meetingId, $modPw);
//                $response = $bbb->endMeeting($endMeetingParams);
//                if ($response->getReturnCode() == 'FAILED') {
//                    Log::error("Failed to stop the server with name ".$meetingName);
//                    Log::error($response->getRawXml()->asXML());
//                } else {
//                    Log::info("Unused meeting with name ".$meetingName." has been stopped");
////                    meetingEnded($meetingId);
//                }
//            }
        }
    }
}
