<!DOCTYPE html>
<html lang="en">
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
  
  
<?php

function println($text) {
  echo $text . "<BR>";
}
// do the URL shortening for the public key
require 'googl.class.php';

$_INTS = '' . exec('../../../../usr/java/jdk1.6/bin/java CreateMyKey');
//echo $_INTS;
echo('<BR>');

$array = str_split($_INTS);
$ispub = 0;
$pub = '';
$priv = '';
foreach($array as $char) {
if($ispub == 0){
if ($char === 'X') {
  $ispub = 1;
}else{
	$pub .= $char;
}
}else{
	$priv .= $char;
}

}
$pub = 'http://www.crypto-book.com/key?val=' . $pub;

$googl = new Googl();
$short = $googl->shorten($pub);

?>

  <body>

<?php
include("header.html");
?>

    <div class="container">

      <!-- Example row of columns -->
      <div class="row">
		<div class="span4">
          <h2>Step 1</h2>
          <p><B><?php println($short); ?></B></p>
		<p>This is your personal Crypto-Book link. <b>Post it on your Facebook</b> on your "About Me" page under your list of "websites". 
		Make sure it's <b>public</b> or <b>visible to friends</b>.
		You must post it on your Facebook before your friends can message you through Crypto-Book.</p>
		<p>It should look something like this:</p>
		<p><img src="link.PNG" ></p>
		
          <p><!--<a class="btn" href="#">View details &raquo;</a>--></p>
		  
        </div>
        <div class="span4">
          <h2>Step 2</h2>
		<p>Save your <b>unique</b> secret code in your <b>Downloads</b> folder.
		</p>
          <p><?php
		println("<a class='btn' href='http://www.crypto-book.com/download_msg.php?msg=" . $priv . "&filename=mysecret.txt'>Get my secret code&raquo;</a>"); 
		?></p>
		<p>
		<p>
		<b>Now get the decrypter app:</b>
		</p>
		<b>Windows:</b> It's an easy one click installer.
		</p>
		<p><a class='btn' href='http://www.crypto-book.com/download/crypto-book-setup.exe'>Windows app&raquo;</a></p>
		<p><b>Mac/Linux:</b> Save the Mac/Linux decrypter app in your Downloads folder.
		<p><a class='btn' href='http://www.crypto-book.com/Decrypter.zip'>Mac/Linux app&raquo;</a></p>
		<p>Mac/Linux instructions: When you download a message, it is temporarily saved in your Downloads folder as message.cryptobook.</p>
		<p>To decrypt your message, from command line run the following command: </p>
		<p><b>java -jar Decrypter.jar message.cryptobook</b></p>
		</p>
        </div>
        <div class="span4">
          <h2>Step 3</h2>
          <p><b>You're done!</b></p>
		<p>Your friends can now message you through <a href='index.html'>Crypto-Book</a>!</p>
		<p>Remember your personal link on your Facebook and your secret code go together. If you make a new personal link, make sure to save the new secret too.</p>
		<p>You can only use the decrypt messages you receive (not send). When you send a message it is encrypted and only your friend can read it.</p>
		<!--<p>The first time you receive a Crypto-Book message through Facebook, choose to open the message with Decrypter-script.bat and after that should be automatic.
		-->
		<!--
		<a href="setup_instructions.pdf">View detailed instructions on this</a></p>
		-->
          <!--<p><a class="btn" href="#">View details &raquo;</a></p>-->

        </div>
      </div>

      <hr>

<?php
include("footer.html");
?>
    </div> <!-- /container -->

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




