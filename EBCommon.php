<?php
class EBCommon {
    public static function call($sessionId, $sessionInfo, $realUser, $url, $parameters)
    {
        $apiUrl = "https://iaabc.edubrite.com/oltpublish/site/";
        $curl_request = curl_init();

        curl_setopt($curl_request, CURLOPT_URL, $apiUrl . $url);
        curl_setopt($curl_request, CURLOPT_HEADER, 1);
        curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_request, CURLOPT_POSTFIELDS, $parameters);

        if($sessionId != null){
            $cookieStr = "SESSION_ID=" . $sessionId;
            if($sessionInfo != null){
                $cookieStr .= "; SESSION_INFO=" . $sessionInfo;
            }
            //print($cookieStr . "\n");
            curl_setopt($curl_request, CURLOPT_COOKIE, $cookieStr);

            if($realUser != null){
                $headerStr = array("REAL_UNAME: ".$realUser);
                curl_setopt($curl_request, CURLOPT_HTTPHEADER, $headerStr);
            }
        }

        $response = curl_exec($curl_request);
        //print($response);
        $error = curl_error($curl_request);
        $result = array(
            'body' => '',
            'error' => '',
            'http_code' => '',
            'session_info' => '',
            'session_id' => ''
        );
        if ( $error != "" )
        {
            $result['error'] = $error;
            return $result;
        }

        $header_size = curl_getinfo($curl_request,CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $result['body'] = substr( $response, $header_size );
        $result['http_code'] = curl_getinfo($curl_request,CURLINFO_HTTP_CODE);
        curl_close($curl_request);

        preg_match_all('/Set-Cookie:\s{0,}(?P<name>[^=]*)=(?P<value>[^;]*).*?$/im', $header, $cookies, PREG_SET_ORDER);
        foreach ($cookies as $match) {
            if($match["name"] == "SESSION_ID"){
                $result['session_id'] = $match["value"];
            }
            if($match["name"] == "SESSION_INFO"){
                $result['session_info'] = $match["value"];
            }
        }
        return $result;
    }
}