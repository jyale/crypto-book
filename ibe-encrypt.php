<html>
<body>
<?php
$token = $_REQUEST["token"];
$url = $_POST["fname"];
$url = 'http://www.facebook.com/profile.php?id=' . $url;
$msg = $_POST["age"];

	$_RECEPID = exec('../../../usr/java/jdk1.6/bin/java GetUsername ' . $url);
	echo $_RECEPID;
	echo('<br>');
	$_INTS = exec('../../../usr/java/jdk1.6/bin/java -jar ibe/IBEencrypt.jar ' . $_RECEPID . ' ' . $msg);
	echo $_INTS;
	$short = 'http://www.crypto-book.com/ibe-decrypt.php?msg=' . $_INTS;
	
	$_REDIRURL = 'https://www.facebook.com/dialog/send?app_id=131686000339117&name=View IBE Crypto-book message&link=' . $short . '&redirect_uri=https://www.facebook.com&to=' . $_RECEPID;
	echo("<script> top.location.href='" . $_REDIRURL . "'</script>");
	
?>
</body>
</html> 