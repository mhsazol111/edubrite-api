<?php
include 'EBCommon.php';

class EBApiClient {

    public static function init() {
        $result = EBCommon::call(null, null, null, "connect.do", null);
        return $result;
    }

    public static function connect($sessionId){
        $apiUsername = "api_382d6464-51f7-11e7-a6ac-0cc47a352510";
        $apiPassword = "UXLzvtFhFcgbpsGZ684YsrwHLS-HVj9u8t_8Y2HTQxRlJcYv5XKxuHhaxtZqPwx9JPclbCU8DQSCJaXGv4OcTW1uGPPnWJGeIfRySEs0Chc*|672146724741";

        $parameters = array(
            "username" => $apiUsername,
            "password" => $apiPassword,
            "dispatch" => "connect"
        );
        $result = EBCommon::call($sessionId, null, null, "connect.do", $parameters);
        return $result;
    }

    public static function getUserList($session_id, $session_info) {
        $parameters = array(
            "dispatch" => "listPrograms",
            'xml' => true,
        );
        $result  = EBCommon::call($session_id, $session_info, 'iaabccourses', 'catalogService.do', $parameters );
        if($result['body'] != null){
            $xmlStr = $result['body'];
            //print($xmlStr);
//            $simpleXml = simplexml_load_string($xmlStr);
//            $attrs = $simpleXml->attributes();
            return $xmlStr;
        }
    }


    public static function getTestHistory($connection, $userName){
        if($connection["session_id"] == null && $connection["session_info"] == null && $userName == null){
            return null;
        }
        $parameters = array(
            "pageSize" => 10,
            "xml" => true,
            "dispatch" => "list"
        );
        $result = EBCommon::call($connection["session_id"], $connection["session_info"], $userName, "testhistory.do", $parameters);
        //print($result['body'] . "\n");
        if($result['body'] != null){
            $xmlStr = $result['body'];
            //print($xmlStr);
            $simpleXml = simplexml_load_string($xmlStr);
            $attrs = $simpleXml->attributes();
            print("Total test records = " . $attrs[numItems] . "\n");
        }
    }


    public static function createUserSession( $connection, $userName ) {
        if($connection["session_id"] == null && $connection["session_info"] == null && $userName == null){
            return null;
        }
        $parameters = array(
            "pageSize" => 10,
            "xml" => true,
            "dispatch" => "createSessionApi"
        );
        $result = EBCommon::call($connection["session_id"], $connection["session_info"], $userName, "signinService.do", $parameters);
        //print($result['body'] . "\n");
        if($result['body'] != null){
            $xmlStr = $result['body'];
            //print($xmlStr);
            $simpleXml = simplexml_load_string($xmlStr);
            print("\nUser session id = " . $simpleXml->data->session->sessionId . "\n");
            print("\nUser session info = " . $simpleXml->data->session->sessionInfo . "\n");
            $userSessionVars = array(
                "session_id" => $simpleXml->data->session->sessionId,
                "session_info" => $simpleXml->data->session->sessionInfo,
            );
            return $userSessionVars;
        }
    }
}