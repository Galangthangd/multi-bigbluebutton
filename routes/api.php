<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('checkbbbtoken')->group(function() {
    Route::get('join', 'BBB\BBBController@join');
    Route::get('create', 'BBB\BBBController@create');
    Route::get('', 'BBB\BBBController@index');
    Route::get('end', 'BBB\BBBController@end');
    Route::get('deleteRecordings', 'BBB\BBBController@deleteRecordings');
    Route::get('updateRecordings', 'BBB\BBBController@updateRecordings');
    Route::get('getDefaultConfigXML', 'BBB\BBBController@getDefaultConfigXML');
    Route::get('setConfigXML', 'BBB\BBBController@setConfigXML');
    Route::get('getRecordings', 'BBB\BBBController@getRecordings');
    Route::get('getRecordingTextTracks', 'BBB\BBBController@getRecordingTextTracks');
    Route::get('publishRecordings', 'BBB\BBBController@publishRecordings');
    Route::get('getMeetings', 'BBB\BBBController@getMeetings');
    Route::get('getMeetingInfo', 'BBB\BBBController@getMeetingInfo');
    Route::get('isMeetingRunning', 'BBB\BBBController@checkMeetingRunning');
    Route::get('putRecordingTextTrack', 'BBB\BBBController@putRecordingTextTrack');
});


