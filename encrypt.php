<html>
<body>
<?php
$token = $_REQUEST["token"];
$url = $_POST["fname"];
$url = 'http://www.facebook.com/profile.php?id=' . $url;
//$url = 'http://www.facebook.com/profile.php?id=100005332951012';
$msg = $_POST["age"];

	//echo exec('../../../usr/java/jdk1.6/bin/java Messenger ' . $url . ' ' . $token . ' ' . $msg);
	//echo exec('../../../usr/java/jdk1.6/bin/java Test ' . $url . ' ' . $token . ' ' . $msg);
	$_RECEPID = exec('../../../usr/java/jdk1.6/bin/java GetUsername ' . $url);
//echo ('../../../usr/java/jdk1.6/bin/java Messenger ' . $url . ' ' . $token . ' ' . $msg);
//echo('<BR>');
	$_INTS = exec('../../../usr/java/jdk1.6/bin/java Messenger ' . $url . ' ' . $token . ' ' . $msg);

	//echo $_INTS;
//	$_REDIRURL = 'https://www.facebook.com/dialog/feed?%20%20%20app_id=131686000339117&link=http://www.crypto-book.com/download_msg.php?msg=' . $_INTS . '&%20%20%20picture=http://fbrell.com/f8.jpg&%20%20%20name=Download Crypto-Book.com message&%20%20%20caption=Encrypted%20message:&%20%20%20description=' . '&%20%20%20redirect_uri=http://www.facebook.com&to=' . $_RECEPID . '&caption=Click the link to download your message';
// 	&picture=http://fbrell.com/f8.jpg
	// do the URL shortening for the public key
	require 'googl.class.php';
	$pub = 'http://www.crypto-book.com/download_msg.php?msg=' . $_INTS;
	$googl = new Googl();
	// uncomment this to do url shortening
	//$short = $googl->shorten($pub);
	$short = $pub;

	$_REDIRURL = 'https://www.facebook.com/dialog/send?app_id=131686000339117&name=View Crypto-book message&link=' . $short . '&redirect_uri=https://www.facebook.com&to=' . $_RECEPID;
	//$_REDIRURL = 'https://www.facebook.com/dialog/send?app_id=131686000339117&name=Download Crypto-book message&link=http://www.crypto-book.com/download_msg.php?msg=' . $_INTS . '&redirect_uri=https://www.facebook.com&to=' . $_RECEPID;
	echo("<script> top.location.href='" . $_REDIRURL . "'</script>");

?>
</body>
</html> 