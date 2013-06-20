<head>

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

</head>
<body>

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

//echo $pub;
echo("<BR>");
//echo $priv;
echo("<BR>");
println("<a href='http://www.crypto-book.com/download_msg.php?msg=" . $priv . "&filename=mysecret.txt'>Download decrypter</a>"); 
$googl = new Googl();
$short = $googl->shorten($pub);
println("Post this on Facebook:");
println($short);
?>

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