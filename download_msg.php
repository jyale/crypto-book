<?php
    $code = $_REQUEST["msg"];
	$filename = $_REQUEST["filename"];
 if(empty($filename )) {
//header('Content-type: application/crypto-book');
header('Content-Disposition: attachment; filename="message.cryptobook"');
}else{
header('Content-Disposition: attachment; filename=' . $filename);

}
	echo $code;
?>