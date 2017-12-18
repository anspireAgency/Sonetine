<?php
include('init.php');

$arr = array('message' => 'Testing Sha3rawys app 3');

try {
$res = $fb->post('154863205145891/feed/', $arr,	'EAAMZBpmriLogBALg3EwRKnyC0bE8VR0fbC6y0B86nrC3kk8FCi8k2Rzgonn4BWIh04QxohFQix5ARKqP74hVwQiUkTTzlqHwKUMYm3tdS6ncd8Dcpg9RM2KnDt2lQrXSNxwPSZCyzaia8lCaW2LpG6EmtcSFYe2ZBDwVpdmTgZDZD');
} catch(Facebook\Exceptions\FacebookResponseException $e) {

  echo 'Graph returned an error: ' . $e->getMessage();
  exit;

} catch(Facebook\Exceptions\FacebookSDKException $e) {

  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;

}



 ?>
