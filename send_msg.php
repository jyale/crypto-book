<!DOCTYPE html>   
<html lang="en">   
<head>   
<meta charset="utf-8">   
<title>Twitter Bootstrap Version2.0 horizontal form layout example</title>   
<meta name="description" content="weak">   
<link href="assets/css/bootstrap.css" rel="stylesheet">  

</head>  
<body>  

<?php
$token = $_REQUEST["token"];
//echo $token;
echo("<form class='form-horizontal' action='encrypt.php?token=" . $token . "' method='post'>");
?>
        <fieldset>  
          <legend>Send secure Facebook message</legend>  
       
	   <div class="control-group">  
            <label class="control-label" for="area">Friend's Facebook homepage:</label>  
            <div class="controls">  
              <input class="input-xlarge" id="area" rows="5" name="fname"></input>  
            </div>  
          </div>  
		  
          <div class="control-group">  
		
	     <label class="control-label" for="area">Enter your message:</label>  
            <div class="controls">  
              <input class="input-xlarge" id="area" rows="5" name="age"></input>  
            </div>  
          </div>  
          <div class="form-actions">  
            <button type="submit" class="btn btn-primary">Send message through Facebook</button>  
            <!--<button class="btn">Cancel</button>  
			-->
          </div>  
        </fieldset>  
</form>  
</body>  
</html>  