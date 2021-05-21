<?php
include 'EBApiClient.php';

$apiConnect = 'https://iaabc.edubrite.com';

//First step is to get the session id,
$init = EBApiClient::init();
$session_id = $init['session_id'];

//Next step is to login as the API user and get the session info
$result = EBApiClient::connect($session_id);
$session_info = $result['session_info'];

//print($result['session_id'] . "\n");
//print($result['session_info'] . "\n");
//Now we can make calls to other APIs. Second parameter indicates the application user (effective user) which is making the API calls.

$userList = EBApiClient::getUserList($result['session_id'], $result['session_info']);
print_r($userList);

//Create user session for user dev1,
//$userSessionVars = EBApiClient::createUserSession($apiConnect, "dev1");
//We can use $userSessionVars["session_id"] and $userSessionVars["session_info"] to construct the iframe url of the course player for this user

// iframe_url = "coursePlayer.do?id=course_id&&dispatch=embed&sessionId=" . $userSessionVars["session_id"] . "&sInfo=" . $userSessionVars["session_info"]

// iframe_url = "coursePlayer.do?courseSessionId=course_session_id&&dispatch=embed&sessionId=" . $userSessionVars["session_id"] . "&sInfo=" . $userSessionVars["session_info"]
