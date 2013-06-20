<!DOCTYPE html>   
<html lang="en">   
<head>   
<meta charset="utf-8">   
<title>Twitter Bootstrap Version2.0 horizontal form layout example</title>   
<meta name="description" content="Twitter Bootstrap Version2.0 horizontal form layout example from w3resource.com.">   
<link href="../assets/css/bootstrap.css" rel="stylesheet">  
</head>  
<body>  


<?php
$token = $_REQUEST["token"];
//echo $token;


echo("<form action='encrypt.php?token=" . $token . "' method='post'>");
?>

Message to send: <input type="text" size="2000" name="age"><BR><BR>
<br><br>
<input type="submit">
</form>

<?php
$token = $_REQUEST["token"];
//echo $token;
echo("<form class='form-horizontal' action='encrypt.php?token=" . $token . "' method='post'>");
?>
        <fieldset>  
          <legend>Send encrypted Facebook message</legend>  
		  
          <div class="control-group">  
            <label class="control-label" for="textarea">Enter your message:</label>  
            <div class="controls">  
              <input class="input-xlarge" id="textarea" rows="3" name="age"></textarea>  
            </div>  
          </div>  
          <div class="form-actions">  
            <button type="submit" class="btn btn-primary">Choose friend to send message to</button>  
            <!--<button class="btn">Cancel</button>  
			-->
          </div>  
        </fieldset>  
</form>  
</body>  
</html>  