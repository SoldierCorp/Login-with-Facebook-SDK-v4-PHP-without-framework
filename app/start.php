<?php

session_start();

require '/config/facebook.php';
require '/vendor/autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\GraphUser;
use Facebook\GraphObject;
use Facebook\FacebookRequestException;

FacebookSession::setDefaultApplication($config['app_id'], $config['app_secret']);
$helper = new FacebookRedirectLoginHelper('http://localhost/snippets_codes/php_facebook_sdk4/index.php');

try {
	$session = $helper->getSessionFromRedirect();

	if ($session):
		$_SESSION['facebook'] = $session->getToken();
		header('Location: index.php');
	endif;

	if (isset($_SESSION['facebook'])):
		$session = new FacebookSession($_SESSION['facebook']);

		$request = new FacebookRequest($session, 'GET', '/me');
		$response = $request->execute();
		$graphObjectClass = $response->getGraphObject(GraphUser::className());

		$facebook_user = $graphObjectClass;
	endif;
} catch(FacebookRequestException $ex) {
  // When Facebook returns an error
} catch(\Exception $ex) {
  // When validation fails or other local issues
}