<?php

require_once(dirname(dirname(__FILE__)) . '/system/common.inc.php');
require_once(dirname(dirname(__FILE__)) . '/system/twitteroauth/twitteroauth.php');
define('CONSUMER_KEY', 'H2uI7VbrPZniS7gSrJHROw');
define('CONSUMER_SECRET', 'XdejrdAIDeD3PFxiXBx1s7umeFlbOrCSk5hqyq4aA');

session_start();
if (!($_SESSION['access_token'] && $_SESSION['access_token_secret'])) {
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
	$token = $connection->getAccessToken($_GET['oauth_verifier']);

	$_SESSION['access_token'] = $token['oauth_token'];
	$_SESSION['access_token_secret'] = $token['oauth_token_secret'];
}
if (($_SESSION['access_token'] && $_SESSION['access_token_secret'])) {
	$client = new TwitterOAuth(
		CONSUMER_KEY, CONSUMER_SECRET,
		$_SESSION['access_token'], $_SESSION['access_token_secret']
		);
	$my_fav = $client->get('favorites');
	/*
	print '<pre>';
	var_dump($my_fav);
	print '</pre>';
    exit;
    */
}

//$my_fav = $connection->get('statuses/show');
//var_dump($my_fav);

$Twig->assign('my_fav', $my_fav);
echo $Twig->fetch('fav.html');