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
$splt_str = explode("|", $tweetContent);
if ( is_array($splt_str) ) {
    $tweet_text = $splt_str[0];
    $tweet_img = $splt_str[1];
} else {
    $tweet_text = $tweetContent;
    $tweet_img = null;
}

if ( $tweet_img ) {
    // Encode the image string data into base64
    $data = base64_encode( file_get_contents($tweet_img) );
      
    $tweet_img_param = array(
        'media_data' => $data,
        'media_category' => 'tweet_image'
    );

    $connection = new TwitterOAuth ($consumer_key ,$consumer_secret , $access_key , $access_secret );
 
    $resultArray = $connection->upload('media/upload', $tweet_img_param);

    if ($connection->http_code == 200) {

        echo "media_id: " . $resultArray->media_id;
        $tweet = array(
            'status' => $tweet_text,
            'media_ids' => $resultArray->media_id
        );
        $resultArray = $connection->post('statuses/update', $tweet);

        if ($connection->http_code == 200) {
            error_log('Tweeted: '.$tweetContent." on ".$tweetContentDate."\n", 3, "tweeterErrors.log");
        } else {
            error_log('Error posting to Twitter: '.$resultArray->http_code." on ".$tweetContentDate."\n", 3, "tweeterErrors.log");
        }

    } else {
        error_log('Error uploading media to Twitter: '.$resultArray->http_code." on ".$tweetContentDate."\n", 3, "tweeterErrors.log");
    }
} else {
    $tweet = array('status' => $tweet_text);

    if ($tweetContent) {
     
        $connection = new TwitterOAuth ($consumer_key ,$consumer_secret , $access_key , $access_secret );
     
        $resultArray = $connection->post('statuses/update', $tweet);

        if ($connection->http_code == 200) {
            error_log('Tweeted: '.$tweetContent." on ".$tweetContentDate."\n", 3, "tweeterErrors.log");
        } else {
            error_log('Error posting to Twitter: '.$resultArray->http_code." on ".$tweetContentDate."\n", 3, "tweeterErrors.log");
        }

    echo $tweetContent;

    }
}


