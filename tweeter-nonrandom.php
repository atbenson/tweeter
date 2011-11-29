<?php
require_once('twitteroauth.php');

$consumer_key = "from http://dev.twitter.com/";
$consumer_secret = "from http://dev.twitter.com/";
$access_key = "from http://dev.twitter.com/";
$access_secret = "from http://dev.twitter.com/";

$f_status = "path/to/.txt/file/containing/posts";
$lines = file($f_status);

date_default_timezone_set('America/New_York');
$tweetContentDate = date('m/d/Y h:i:s a', time());

$tweetContent = $lines[0];

$tweet = array('status' => $tweetContent);

$status = $tweetContent;

if ($status) {

	$connection = new TwitterOAuth ($consumer_key ,$consumer_secret , $access_key , $access_secret );
 
	$resultArray = $connection->post('statuses/update', $tweet);

	if ($connection->http_code == 200) {
		error_log('Tweeted: '.$status."\n", 3, "tweeterErrors.log");
		unset($lines[0]);
		$fp = fopen( $f_status, "wa+");
		fwrite($fp, implode($lines));
		fclose($fp);
	} else {
		error_log('Error posting to twitter: '.$resultArray->http_code."\n", 3, "tweeterErrors.log");
	}
	
echo $tweetContent;

}

?>
