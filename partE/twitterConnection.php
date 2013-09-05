<?php
  require_once('twitter.php');
  require_once('twitteroauth.php');

  function connectTwitter() {
    $conn = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
    return $conn;
  }

  function closeTwitter($conn) {
    $conn = null;
  }

  function sendTwitter($message) {
    $conn = connectTwitter();
    //var_dump($conn);
    $response = $conn->post('statuses/update', array('status' => 'Hello!!'));
    //var_dump($response);
    closeTwitter($conn);
  }

?>
