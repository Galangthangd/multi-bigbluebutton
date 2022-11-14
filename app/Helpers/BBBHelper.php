<?php

use App\Models\BBBServerInfo;
use App\Models\BBBServerMeeting;
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\EndMeetingParameters;
use BigBlueButton\Parameters\GetMeetingInfoParameters;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * Calculate to get the most suitable server for the meeting
 *
 * @return \Illuminate\Database\Eloquent\Model|mixed
 * @throws Exception
 */
function getSuitableBBBServerInfo() {
    $servers = BBBServerInfo::where('enabled', true)->orderBy('weight', 'desc')->get();
    if (count($servers) == 0) {
        Log::error("No server found!!");
        //throw new Exception('No server found');
        return null;
    }
    $chosenServer = null;
    $runningMeetingOnChosenServer = 100000000;
    foreach ($servers as $server) {
        $runningMeetingOnCurrentServer = countNumberOfRunningMeeting($server->id);
        if ($runningMeetingOnCurrentServer < $runningMeetingOnChosenServer && $runningMeetingOnCurrentServer < $server->weight) {
            $chosenServer = $server;
            $runningMeetingOnChosenServer = $runningMeetingOnCurrentServer;
        }
    }
    return $chosenServer;
    /* Old
    $servers = BBBServerInfo::where('enabled', true)->orderBy('weight', 'desc')->get();
    if (count($servers) == 0) {
        throw new Exception('No server found');
    }
    $choosenServer = null;
    $mn = 100000000;
    foreach ($servers as $server) {
        $tmp = countNumberOfRunningMeeting($server->id);
        if ($tmp < $mn) {
            $choosenServer = $server;
            $mn = $tmp;
        }
    }
    return $choosenServer;
    */
}
/**
 * Get the server that host the meeting with $meetingID
 *
 * @param $meetingID
 * @return mixed
 */
function getServerForTheMeeting($meetingID) {
    $bbbMeetingSecret = BBBServerMeeting::where('meeting_id', $meetingID)->first();
    if (is_null($bbbMeetingSecret)) {
        $bbbServerInfo = BBBServerInfo::where('id', getSuitableBBBServerInfo()->id)->first();
    } else {
        $bbbServerInfo = BBBServerInfo::where('id', $bbbMeetingSecret->server_id)->first();
    }
    return $bbbServerInfo;
}

function endMeeting($meetingId) {
    Log::info("==========Ending meeting========");
    $meetingServer = BBBServerMeeting::where(['status' => config('constants.status.running'), 'meeting_id' => $meetingId])->firstOrFail();
    if ($meetingServer == null) {
        Log::info('Meeting with id '.$meetingId.' is not running ');
    } else {
        $meetingName = $meetingServer->meeting_name;
        $serverInfo = getServerForTheMeeting($meetingId);
        if ($serverInfo->enabled == 0) {
            return;
        }
        $bbb = new BigBlueButton();
        $bbb->setBBBServerInfo($serverInfo->base_url, $serverInfo->sec_secret);

        $getMeetingInfoParams = new GetMeetingInfoParameters($meetingId, 123);
        $response = $bbb->getMeetingInfo($getMeetingInfoParams);
        if ($response->getReturnCode() !== 'FAILED') {

            $modPw = $response->getMeeting()->getModeratorPassword();

            $endMeetingParams = new EndMeetingParameters($meetingId, $modPw);
            $response = $bbb->endMeeting($endMeetingParams);
            if ($response->getReturnCode() == 'FAILED') {
                Log::error("Failed to stop the server with name ".$meetingName);
                Log::error($response->getRawXml()->asXML());
            } else {
                Log::info("Unused meeting with name ".$meetingName." has been stopped");
//                    meetingEnded($meetingId);
            }
        }
    }
}

/**
 * Data manipulation when meeting is created
 *
 * @param $meetingID
 * @param $meetingName
 * @throws Exception
 */
function meetingCreated($meetingID, $meetingName) {
    $bbbServerMeeting = BBBServerMeeting::where('meeting_id', $meetingID)->first();
    if (is_null($bbbServerMeeting)) {
        $bbbServerMeeting = new BBBServerMeeting();
        $bbbServerMeeting->server_id = getSuitableBBBServerInfo()->id;
        $bbbServerMeeting->meeting_id = $meetingID;
        $bbbServerMeeting->meeting_name = $meetingName;
        $bbbServerMeeting->status = config('constants.status.stopped');
        $bbbServerMeeting->start_time = Carbon::now();
        $bbbServerMeeting->save();
    } else {
        $bbbServerMeeting->server_id = getSuitableBBBServerInfo()->id;
        $bbbServerMeeting->start_time = Carbon::now();
        $bbbServerMeeting->save();
    }
}

/**
 * Data manipulation when meeting is ended
 *
 * @param $meetingID
 */
function meetingEnded($meetingID) {
    $bbbServerMeeting = BBBServerMeeting::where('meeting_id', $meetingID)->first();
    $bbbServerMeeting->status = config('constants.status.stopped');
    $bbbServerMeeting->save();
}

/**
 * Count number of running meeting of server specified by $serverID
 *
 * @param $serverID
 * @return mixed
 */
function countNumberOfRunningMeeting($serverID) {
    $numberOfRunningMeetings = BBBServerMeeting::where('server_id', $serverID)->where('status', config('constants.status.running'))->count();
    return $numberOfRunningMeetings;
}

function countNumberOfMeeting($serverID) {
    $numberOfMeetings = BBBServerMeeting::where('server_id', $serverID)->count();
    return $numberOfMeetings;
}

/**
 * Data manipulation when meeting is started
 *
 * @param $meetingID
 */
function meetingJoined($meetingID) {
    $bbbServerMeeting = BBBServerMeeting::where('meeting_id', $meetingID)->first();
    if ($bbbServerMeeting && !empty($bbbServerMeeting->status) && $bbbServerMeeting->status == config('constants.status.running')) {
        return;
    }
    $bbbServerMeeting->status = config('constants.status.running');
    $bbbServerMeeting->save();
}

/**
 * LB after call getRecordings API to BBB server will get response include many nodes.
 * This function extract only the recordings nodes from it.
 *
 * @param $response
 * @return false|string
 */
function getOnlyRecordingNodesFromGetRecordingsAPIResponse($response) {
    $xmlString = $response->getRawXml()->asXML();
    $pos1 =  strpos($xmlString,"<recordings>");
    $pos2 =  strpos($xmlString,"</recordings>");
    return substr($xmlString, $pos1+12, $pos2-$pos1-12);
}
