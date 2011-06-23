<?php
require_once('twitteroauth.php');

$consumer_key = "from http://dev.twitter.com/";
$consumer_secret = "from http://dev.twitter.com/";
$access_key = "from http://dev.twitter.com/";
$access_secret = "from http://dev.twitter.com/";

$lines = file ("path/to/.txt/file/containing/posts");

date_default_timezone_set('America/New_York');
$tweetContentDate = date('m/d/Y h:i:s a', time());

srand ((double)microtime()*1000000);

$tweetContent = $lines[array_rand ($lines)];

$tweet = array('status' => $tweetContent);

$status = $tweetContent;

if ($status) {
 
	$connection = new TwitterOAuth ($consumer_key ,$consumer_secret , $access_key , $access_secret );
 
	$resultArray = $connection->post('statuses/update', $tweet);

	if ($connection->http_code == 200) {
		error_log('Tweeted: '.$tweetContent." on ".$tweetContentDate."\n", 3, "tweeterErrors.log");
	} else {
		error_log('Error posting to Twitter: '.$resultArray->http_code." on ".$tweetContentDate."\n", 3, "tweeterErrors.log");
	}

echo $tweetContent;

}

?>


