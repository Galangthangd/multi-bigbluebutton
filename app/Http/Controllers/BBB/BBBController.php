<?php


namespace App\Http\Controllers\BBB;

use App\Models\BBBServerInfo;
use BigBlueButton\Parameters\CreateMeetingParameters;
use BigBlueButton\Parameters\DeleteRecordingsParameters;
use BigBlueButton\Parameters\EndMeetingParameters;
use BigBlueButton\Parameters\GetMeetingInfoParameters;
use BigBlueButton\Parameters\GetRecordingsParameters;
use BigBlueButton\Parameters\IsMeetingRunningParameters;
use BigBlueButton\Parameters\JoinMeetingParameters;
use BigBlueButton\Parameters\PublishRecordingsParameters;
use BigBlueButton\Parameters\SetConfigXMLParameters;
use BigBlueButton\Parameters\UpdateRecordingsParameters;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use BigBlueButton\BigBlueButton;

class BBBController extends Controller
{
	protected $maxAttempts = 3000000000; // Default is 5
    protected $decayMinutes = 0; // Default is 1

    public function index(Request $request)
    {
        //Log::error("==============Get API Version Request==============");

        $suitableServer = getSuitableBBBServerInfo();
        $bbb = new BigBlueButton();
        $bbb->setBBBServerInfo($suitableServer->base_url, $suitableServer->sec_secret);
        $response = $bbb->getApiVersion();
        if ($response->getReturnCode() == 'FAILED') {
           // Log::error("==============Get API Version Error==============");
	   //Log::error($response->getRawXml()->asXML());
            return response($response->getRawXml()->asXML(), 503);
        } else {
            return response($response->getRawXml()->asXML(), 200);
        }
    }

    public function join(Request $request)
    {
        Log::info('==============Join request==============');
        //Log::info('Request params: ');
        //Log::info(print_r($request->all(), true));


        $serverInfo = getServerForTheMeeting($request->meetingID);
        $bbb = new BigBlueButton();
        $bbb->setBBBServerInfo($serverInfo->base_url, $serverInfo->sec_secret);

        $joinMeetingParams = new JoinMeetingParameters($request->meetingID, $request->fullName, $request->password);
        $joinMeetingParams->setUserId($request->userID);
        $joinMeetingParams->setRedirect(true);
		$joinMeetingParams->setJoinViaHtml5(true);
        $url = $bbb->getJoinMeetingURL($joinMeetingParams);
        $meetingID = $request->meetingID;
        meetingJoined($meetingID);
        header('Location: ' . $url);
    }

    public function create(Request $request)
    {
        Log::info('==============Create request==============');
        //Log::info(print_r($request->all(), true));

        meetingCreated($request->meetingID, $request->name);

        $serverInfo = getServerForTheMeeting($request->meetingID);
        $bbb = new BigBlueButton();
        $bbb->setBBBServerInfo($serverInfo->base_url, $serverInfo->sec_secret);

        $createMeetingParams = new CreateMeetingParameters($request->meetingID, $request->name);
        $createMeetingParams->setAttendeePassword($request->attendeePW);
        $createMeetingParams->setAutoStartRecording(true);
        $createMeetingParams->setModeratorPassword($request->moderatorPW);
        $createMeetingParams->setLogoutUrl($request->logoutURL);
        $createMeetingParams->setRecord($request->record);
        $createMeetingParams->setAllowStartStopRecording(true);
		$createMeetingParams->setWebcamsOnlyForModerator(true);
		$createMeetingParams->setLockSettingsDisableCam(true);
		$createMeetingParams->setLockSettingsDisableMic(true);
		$createMeetingParams->setLockSettingsDisablePrivateChat(true);
		$createMeetingParams->setBreakout(false);
		//$createMeetingParams->setLockSettingsLockOnJoin(true);
        $createMeetingParams->setWelcomeMessage($request->welcome);
        $createMeetingParams->addMeta('bbb-origin', $request['meta_bbb-origin']);
        $createMeetingParams->addMeta('bbb-origin-version', $request['meta_bbb-origin-version']);
        $createMeetingParams->addMeta('bbb-origin-server-name', $request['meta_bbb-origin-server-name']);
        $createMeetingParams->addMeta('bbb-origin-server-common-name', $request['meta_bbb-origin-server-common-name']);
        $createMeetingParams->addMeta('bbb-origin-tag', $request['meta_bbb-origin-tag']);
        $createMeetingParams->addMeta('bbb-context', $request['meta_bbb-context']);
        $createMeetingParams->addMeta('bbb-recording-name', $request['meta_bbb-recording-name']);
        $createMeetingParams->addMeta('bbb-recording-description', $request['meta_bbb-recording-description']);
        $createMeetingParams->addMeta('bbb-recording-tags', $request['meta_bbb-recording-tags']);

        $response = $bbb->createMeeting($createMeetingParams);
        if ($response->getReturnCode() == 'FAILED') {
            Log::error("Create meeting failed ");
            Log::error($response->getRawXml()->asXML());
            return response($response->getRawXml()->asXML(), 503);
        } else {
            $meetingID = $response->getMeetingId();

            return response($response->getRawXml()->asXML(), 200);
        }
    }

    public function checkMeetingRunning(Request $request)
    {
        Log::info('==============Check meeting running request==============');
        //Log::info('Meeting ID: '.$request->meetingID);

        $serverInfo = getServerForTheMeeting($request->meetingID);
        $bbb = new BigBlueButton();
        $bbb->setBBBServerInfo($serverInfo->base_url, $serverInfo->sec_secret);

        $isMeetingRunningParams = new IsMeetingRunningParameters($request->meetingID);
        $response = $bbb->isMeetingRunning($isMeetingRunningParams);
        if ($response->getReturnCode() == 'FAILED') {
            Log::error("Check meeting running status failed ");
            Log::error($response->getRawXml()->asXML());
            return response($response->getRawXml()->asXML(), 503);
        } else {
            return response($response->getRawXml()->asXML(), 200);
        }
    }

    public function end(Request $request)
    {
        Log::info('==============End meeting request==============');
        //Log::info('Request param');
        //Log::info(print_r($request->all(), true));

        $serverInfo = getServerForTheMeeting($request->meetingID);
        $bbb = new BigBlueButton();
        $bbb->setBBBServerInfo($serverInfo->base_url, $serverInfo->sec_secret);

        $meetingID = $request->meetingID;
        $endMeetingParams = new EndMeetingParameters($request->meetingID, $request->password);
        $response = $bbb->endMeeting($endMeetingParams);
        if ($response->getReturnCode() == 'FAILED') {
            Log::error("Join meeting error");
            Log::error($response->getRawXml()->asXML());
            return response($response->getRawXml()->asXML(), 503);
        } else {
            meetingEnded($meetingID);
            return response($response->getRawXml()->asXML(), 200);
        }
    }

    public function getMeetingInfo(Request $request)
    {
        //Log::info('==============Get meeting info==============');
        //Log::info('Meeting ID: '.$request->meetingID);

        $serverInfo = getServerForTheMeeting($request->meetingID);
        $bbb = new BigBlueButton();
        $bbb->setBBBServerInfo($serverInfo->base_url, $serverInfo->sec_secret);

        $getMeetingInfoParams = new GetMeetingInfoParameters($request->meetingID, $request->password);
        $response = $bbb->getMeetingInfo($getMeetingInfoParams);
        if ($response->getReturnCode() == 'FAILED') {
           // Log::error("Get meeting info error");
           // Log::error($response->getRawXml()->asXML());
            return response($response->getRawXml()->asXML(), 503);
        } else {
            return response($response->getRawXml()->asXML(), 200);
        }
    }

    public function getMeetings(Request $request)
    {
        Log::info('==============Get meetings==============');

        $suitableServer = getSuitableBBBServerInfo();
        $bbb = new BigBlueButton();
        $bbb->setBBBServerInfo($suitableServer->base_url, $suitableServer->sec_secret);

        $response = $bbb->getMeetings();
        if ($response->getReturnCode() == 'FAILED') {
            //Log::error("Get meetings error");
            //Log::error($response->getRawXml()->asXML());
            return response($response->getRawXml()->asXML(), 503);
        } else {
            return response($response->getRawXml()->asXML(), 200);
        }
    }

    public function getRecordings(Request $request)
    {
        Log::info('==============Get recordings request==============');
        //Log::info('Request param');
        //Log::info(print_r($request->all(), true));

        $servers = BBBServerInfo::where('enabled', true)->get();

        $response = '';
        $response .= '<response><returncode>SUCCESS</returncode><recordings>';
        foreach ($servers as $server) {
            $bbb = new BigBlueButton();
            $bbb->setBBBServerInfo($server->base_url, $server->sec_secret);
            $recordingParams = new GetRecordingsParameters();
            $recordingParams->setMeetingId($request->meetingID);
            $resp = $bbb->getRecordings($recordingParams);	
            if ($resp->getMessageKey() == 'noRecordings') {
                continue;
            }
			$response .= getOnlyRecordingNodesFromGetRecordingsAPIResponse($resp);
        }
        $response .= '</recordings></response>';
        return response($response, 200);
    }

    public function publishRecordings(Request $request)
    {
        Log::info('==============Publish recordings request==============');

        $servers = BBBServerInfo::where('enabled', true)->get();
        foreach ($servers as $server) {
            $bbb = new BigBlueButton();
            $bbb->setBBBServerInfo($server->base_url, $server->sec_secret);
            $publishRecordingsParams = new PublishRecordingsParameters($request->recordID, $request->publish || true);
            $response = $bbb->publishRecordings($publishRecordingsParams);
            if ($response->getReturnCode() != 'FAILED') {
                Log::info("Published recording with id ".$request->recordingID." from server ".$server->base_url);
            }
        }
        return '<response><returncode>SUCCESS</returncode><deleted>true</deleted></response>';
    }

    public function deleteRecordings(Request $request)
    {
        Log::info('==============Delete recordings request==============');
        Log::info(print_r($request->all(), true));

        $servers = BBBServerInfo::where('enabled', true)->get();
        foreach ($servers as $server) {
            $bbb = new BigBlueButton();
            $bbb->setBBBServerInfo($server->base_url, $server->sec_secret);
            $deleteRecordingsParams = new DeleteRecordingsParameters($request->recordID);
            $response = $bbb->deleteRecordings($deleteRecordingsParams);
            if ($response->getReturnCode() != 'FAILED') {
                Log::info("Deleted recording with id ".$request->recordingID." from server ".$server->base_url);
            }
        }
        return '<response><returncode>SUCCESS</returncode><deleted>true</deleted></response>';

    }

    public function updateRecordings(Request $request)
    {
        Log::info('==============Update recordings request==============');
        Log::info(print_r($request->all(), true));

        $servers = BBBServerInfo::where('enabled', true)->get();
        foreach ($servers as $server) {
            $bbb = new BigBlueButton();
            $bbb->setBBBServerInfo($server->base_url, $server->sec_secret);
            $updateRecordingsParams = new UpdateRecordingsParameters($request->recordID);
            $response = $bbb->updateRecordings($updateRecordingsParams);
            if ($response->getReturnCode() != 'FAILED') {
                Log::info("Updated recording with id ".$request->recordingID." from server ".$server->base_url);
            }
        }
        return '<response><returncode>SUCCESS</returncode><deleted>true</deleted></response>';
    }

    public function getDefaultConfigXML(Request $request)
    {
        Log::info('==============Get Default Config XML request==============');

        $suitableServer = getSuitableBBBServerInfo();
        $bbb = new BigBlueButton();
        $bbb->setBBBServerInfo($suitableServer->base_url, $suitableServer->sec_secret);

        $response = $bbb->getDefaultConfigXML();
        return response($response->getRawXml()->asXML(), 200);
    }

    public function setConfigXML(Request $request)
    {
        Log::info('==============Set Config XML request==============');

        $suitableServer = getSuitableBBBServerInfo();
        $bbb = new BigBlueButton();
        $bbb->setBBBServerInfo($suitableServer->base_url, $suitableServer->sec_secret);

        $setConfigXMLParams = new SetConfigXMLParameters($request->meetingID);
        $response = $bbb->setConfigXML($setConfigXMLParams);
        if ($response->getReturnCode() == 'FAILED') {
            Log::error("Set config XML error");
            Log::error($response->getRawXml()->asXML());
            return response($response->getRawXml()->asXML(), 503);
        } else {
            return response($response->getRawXml()->asXML(), 200);
        }
    }

//    public function getRecordingTextTracks(Request $request) {
//        Log::info('Get recording request: '.$request);
//        $bbb = new BigBlueButton();
//$bbb->setBBBServerInfo($suitableServer->base_url, $suitableServer->sec_secret);
//        $recordingTextTracks = new GetRecordingsTextTracksParameters();
//        return response()->json($request, 200);
//
//    }
//
//
//    public function putRecordingTextTrack(Request $request) {
//        Log::info('Get recording request: '.$request);
//        return response()->json($request, 200);
//    }
//
}
