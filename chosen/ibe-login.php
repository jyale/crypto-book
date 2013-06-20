<?php

require '../php-sdk/facebook.php';

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

// This call will always work since we are fetching public data.
$naitik = $facebook->api('/naitik');

?>


<!doctype html> 
<html xmlns:fb="http://www.facebook.com/2008/fbml" lang="en">

<head>
  <style>
    /* RESET */
    html, body, div, span, h1, h2, h3, h4, h5, h6, p, blockquote, a,
    font, img, dl, dt, dd, ol, ul, li, legend, table, tbody, tr, th, td 
    {margin:0px;padding:0px;border:0;outline:0;font-weight:inherit;font-style:inherit;font-size:100%;font-family:inherit;list-style:none;}
    a img {border: none;}
    ol li {list-style: decimal outside;}
    fieldset {border:0;padding:0;}
    
    body { font-family: sans-serif; font-size: 1em; }
    
    div#container { width: 780px; margin: 0 auto; padding: 1em 0;  }
    p { margin: 1em 0; max-width: 700px; }
    h1 + p { margin-top: 0; }
    
    h1, h2 { font-family: Georgia, Times, serif; }
    h1 { font-size: 2em; margin-bottom: .75em; }
    h2 { font-size: 1.5em; margin: 2.5em 0 .5em; border-bottom: 1px solid #999; padding-bottom: 5px; }
    h3 { font-weight: bold; }
    
    ul li { list-style: disc; margin-left: 1em; }
    ol li { margin-left: 1.25em; }
    
    div.side-by-side { width: 100%; margin-bottom: 1em; }
    div.side-by-side > div { float: left; width: 50%; }
    div.side-by-side > div > em { margin-bottom: 10px; display: block; }
    
    a { color: orange; text-decoration: underline; }
    
    .faqs em { display: block; }
    
    .clearfix:after {
      content: "\0020";
      display: block;
      height: 0;
      clear: both;
      overflow: hidden;
      visibility: hidden;
    }
    
    footer {
      margin-top: 2em;
      border-top: 1px solid #666;
      padding-top: 5px;
    }
  </style>
  <link rel="stylesheet" href="chosen/chosen.css" />
  <link href="../assets/css/bootstrap.css" rel="stylesheet">  

</head>

  <body>
	<!--<h1>php-sdk</h1>
	-->
    <?php if ($user): ?>
      <!--
	  <a href="<?php echo $logoutUrl; ?>">Logout</a>
	  -->
    <?php else: ?>
      <div>
        <!--Login using OAuth 2.0 handled by the PHP SDK:
        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
		-->
		<?php
		echo("<script> top.location.href='" . $loginUrl . "'</script>");
		?>
      </div>
    <?php endif ?>
<!--
    <h3>PHP Session</h3>
    <pre><?php print_r($_SESSION); ?></pre>

    <?php if ($user): ?>
      <h3>You</h3>
      <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">
	-->  
	<?php
	// get the list of friends
	$friends = $facebook->api('/me/friends');
           // echo '<img src="https://graph.facebook.com/' . $value["id"] . '/picture"/>';
	?>
<!---
      <h3>Your User Object (/me)</h3>
      <pre><?php print_r($user_profile); ?></pre>
    <?php else: ?>
      <strong><em>You are not Connected.</em></strong>
    <?php endif ?>
---->



<?php
	$token = $facebook->getAccessToken();;
	// echo $token;
	echo("<form class='form-horizontal' action='../ibe-encrypt.php?token=" . $token . "' method='post'>");
?>


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

<!---
  <form action="receive.php" method="post">
  --->
  <fieldset>  
      <legend>Send secure Facebook message</legend>  
	  <div class="control-group">  
	   <label class="control-label" for="area">Facebook friend:</label>  
	    <div class="controls">  
        <select data-placeholder="Choose friend..." class="chzn-select" style="width:350px;" tabindex="2" name="fname">
		<?php
			foreach ($friends["data"] as $value) {
				echo '<option value="' . $value["id"] . '">' . $value["name"] . '</option> ';
			}
		?>
        </select>
		</div>
      </div>
	  
	  <div class="control-group">  
	  <label class="control-label" for="area">Enter your message:</label>  
            <div class="controls">  
              <input class="input-xlarge" id="area" rows="5" name="age" style="width:345px;" tabindex="3"></input>  
            </div>  
          </div>  
	  
	  <div class="form-actions">  
            <button type="submit" class="btn btn-primary" tabindex="4">Encrypt message&raquo</button>  
       </div>
	   
   
  </fieldset>  
  </form>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
  <script src="chosen/chosen.jquery.js" type="text/javascript"></script>
  <script type="text/javascript"> $(".chzn-select").chosen(); $(".chzn-select-deselect").chosen({allow_single_deselect:true}); </script>
  
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

</html>
