<?php

require 'php-sdk/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '131686000339117',
  'secret' => 'bda3a9ca0d385c804d42ecd7beb91c65',
));

// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
$params = array(
  'scope' => 'email,offline_access,user_website,friends_website,publish_stream'
);
  $loginUrl = $facebook->getLoginUrl($params);

}
 
	$_RECP = 'http://www.facebook.com/profile.php?id=100005332951012 ';
	//$_RECEPID = '' . exec('../../../usr/java/jdk1.6/bin/java GetUsername ' . $_RECP);
	
	$_RECEPID = $user_profile[id];

	//$_INTS = exec('../../../usr/java/jdk1.6/bin/java Messenger ' . $_RECP . $_SESSION['access_token'] . ' Weak code you are a fool');

	//$_REDIRURL = 'https://www.facebook.com/dialog/feed?%20%20%20app_id=131686000339117&link=http://www.crypto-book.com/download_msg.php?msg=' . $_INTS . '&%20%20%20picture=http://fbrell.com/f8.jpg&%20%20%20name=Download Crypto-Book message&%20%20%20caption=Encrypted%20message:&%20%20%20description=' . '&%20%20%20redirect_uri=http://www.crypto-book.com&to=' . $_RECEPID . '&caption=Click the link to download your message';
	//echo("<script> top.location.href='" . $_REDIRURL . "'</script>");
	
	$weak = ('' . exec('../../../usr/java/jdk1.6/bin/java -jar ibe/IBEdecrypt.jar ' . $_RECEPID . ' ' . $msg));
  
 ?>
 
 <!doctype html> 
<html xmlns:fb="http://www.facebook.com/2008/fbml" lang="en">
 <head>
    <meta charset="utf-8">
    <title>Crypto-Book</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="assets/ico/favicon.png">


  </head>
  
<body>
<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="../index.php">Crypto-Book</a>
          <div class="nav-collapse collapse">
		  </div>
		</div>
	  </div> 
	</div>
<div class="container">
      <div class="row">
	 <div class="span4">
          <p>
           <?php
		echo $weak;
	?></p>
		  <p><a class="btn" href="http://www.facebook.com">Go back to Facebook&raquo;</a></p>
        </div>
</div></div>


	  <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>

	
</body>
 
 
 