<?php 

   $app_id = "131686000339117";
   $app_secret = "bda3a9ca0d385c804d42ecd7beb91c65";
   $my_url = "http://www.crypto-book.com/login.php";

   session_start();

    $code = $_REQUEST["code"];

   if(empty($code)) {
     $_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
     $dialog_url = "https://www.facebook.com/dialog/oauth?client_id=" 
       . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
       . $_SESSION['state'] . "&scope=email,offline_access,user_website,friends_website,publish_stream";

     echo("<script> top.location.href='" . $dialog_url . "'</script>");
   }

   if($_SESSION['state'] && ($_SESSION['state'] === $_REQUEST['state'])) {
     $token_url = "https://graph.facebook.com/oauth/access_token?"
       . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
       . "&client_secret=" . $app_secret . "&code=" . $code;

     $response = file_get_contents($token_url);
     $params = null;
     parse_str($response, $params);

     $_SESSION['access_token'] = $params['access_token'];

     $graph_url = "https://graph.facebook.com/me?access_token=" 
       . $params['access_token'];
$user = json_decode(file_get_contents($graph_url));
     echo("Hello " . $user->name);
	echo("<br>");
	echo("Thanks for linking your Facebook to Crypto-Book!");
	echo("<br>");
	echo("Please save the following in the folder where you installed Crypto-Book in a text file called token.txt");
	echo("<br>");	echo("<br>");
       echo $_SESSION['access_token'];
	echo("<br>");	echo("<br>");
	echo("You can then use <a href=\"http://www.crypto-book.com\">Crypto-Book</a>!");	
	echo("<br>");
	$_RECP = 'http://www.facebook.com/profile.php?id=100005332951012 ';
	$_RECEPID = '' . exec('../../../usr/java/jdk1.6/bin/java GetUsername ' . $_RECP);
	echo($_RECEPID);
	echo('<br>');


	//$_INTS = exec('../../../usr/java/jdk1.6/bin/java Messenger ' . $_RECP . $_SESSION['access_token'] . ' Weak code you are a fool');

	//$_REDIRURL = 'https://www.facebook.com/dialog/feed?%20%20%20app_id=131686000339117&link=http://www.crypto-book.com/download_msg.php?msg=' . $_INTS . '&%20%20%20picture=http://fbrell.com/f8.jpg&%20%20%20name=Download Crypto-Book message&%20%20%20caption=Encrypted%20message:&%20%20%20description=' . '&%20%20%20redirect_uri=http://www.crypto-book.com&to=' . $_RECEPID . '&caption=Click the link to download your message';

	//echo("<script> top.location.href='" . $_REDIRURL . "'</script>");
	echo("<script> top.location.href='" . "http://www.crypto-book.com/send_msg.php?token=" . $_SESSION['access_token'] . "'</script>");


   }
   else {
     echo("The state does not match. You may be a victim of CSRF.");
   }
 ?>