<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Log;
use Closure;

class CheckBBBToken {
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $reqType = basename($request->url());
        $params = http_build_query($request->all());
        Log::info("request type: " . $reqType);
        Log::info("Request: ");
        Log::info($request);
        $result = $this->checkChecksum($reqType, $request['checksum'], $params);
        if ($result || $reqType == 'create' || $reqType == 'api') return $next($request);
        else {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
        }
    }

    public function checkChecksum($api, $checksum, $queryString) {
       /* $secret = 'ACeAz74AoTxcj4PLKlcFSijPDE16OHY3xATdNVLc8';
        $queryString = str_replace("&checksum=" . $checksum, "", $queryString);
        $queryString = str_replace("checksum=" . $checksum . "&", "", $queryString);
        $queryString = str_replace("checksum=" . $checksum, "", $queryString);
        if ($api == 'api') $api = "";
        $token = $api . $queryString . $secret;
        $encrypted = sha1($token);
        Log::info("Checksum: " . $checksum);
        Log::info("encrypted: " . $encrypted);
        return $encrypted == $checksum; */
		return true;
    }
}
