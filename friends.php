
<?php

###############################################################################

// USE FULL PATH OF THE JAVASCRIPTT FILE IN LINE PrepareJs() LIKE http://yourdomain.com/javascript.js


#############################################################################




require_once('php-sdk/facebook.php');



class FriendSelector{

	

	const APIKEY = '131686000339117';  // your FB APPLICATION API KEY

	const SECRETKEY = 'bda3a9ca0d385c804d42ecd7beb91c65'; // your FB Application SECRET KEY

	

	var $FB;

	var $friends;

	var $userid;

	

	function FriendSelector(){

		$this->FB      = new Facebook(self::APIKEY , self::SECRETKEY );

		$this->userid  = $this->FB->require_login();

		$this->friends = $this->FB->api_client->friends_get();

		//print_r($this->friends);

		$this->StyleSheet();

		$this->PrepareJs();

		$this->PrePareHTML();

		$this->PrePareforUserList();
		
		$this->SubmitForm();

	}

	

	

	

	function PrepareJs(){
		echo '<script src="http://www.crypto-book.com/javascript.js"></script>';


	}

	

	

	function StyleSheet(){

		 echo '<style>';

		 echo 'body { direction: ltr; font-family: "lucida grande",tahoma,verdana,arial,sans-serif; font-size: 11px; text-align: left; width: 760px; }';

         echo 'a.tab-bold { border-right: 1px solid #c0c0c0; padding: 0px; background: transparent url("http://img527.imageshack.us/img527/7862/glossytabselected.gif") repeat scroll 0% 0%; height: 20px; line-height: 20px; text-decoration: none; cursor: pointer; color: black; display: block; float: left; position: relative; top: 1px; }';

         echo 'a.tab-unbold { border-right: 1px solid #c0c0c0; padding: 0px; background: transparent url("http://img527.imageshack.us/img527/6089/glossytab.gif") repeat scroll 0% 0%; height: 20px; line-height: 20px; text-decoration: none; color: black; cursor: pointer; display: block; float: left; position: relative; top: 1px; }';

         echo 'a.xtab-bold { border-right: 1px solid #c0c0c0; padding: 0px 8px; background: transparent url("http://img527.imageshack.us/img527/7862/glossytabselected.gif") repeat scroll 0% 0%; height: 20px; line-height: 20px; text-decoration: none; cursor: pointer; color: black; display: block; float: left; position: relative; top: 1px; }';

         echo 'a.xtab-unbold { border-right: 1px solid #c0c0c0; padding: 0px 8px; background: transparent url("http://img527.imageshack.us/img527/6089/glossytab.gif") repeat scroll 0% 0%; height: 20px; line-height: 20px; text-decoration: none; color: black; cursor: pointer; display: block; float: left; position: relative; top: 1px; }';

         echo 'h1, h2, h3, h4, h5 { margin: 0px; padding: 0px; color: #333333; font-size: 13px; }';

         echo '.binvite-container { border: 1px solid #c0c0c0; background: #ffffff none repeat scroll 0% 0%; overflow: auto; padding-top: 5px; height: 150px; font-family: "lucida grande",tahoma,verdana,arial,sans-serif; }';

         echo '.biuser { float: left; width: 140px; height: 17px; margin-bottom: 6px; }';

         echo '.fscb { display: block; float: left; margin-right: 5px; }';

         echo '.fsna { overflow: hidden; display: block; width: 110px; height: 17px; line-height: 18px; float: left; font-weight: normal; white-space: nowrap; }';

         echo '.invite-container { border: 1px solid #c0c0c0; padding: 0px; overflow: auto; height: 350px; font-family: "lucida grande",tahoma,verdana,arial,sans-serif; }';

         echo '.iuser { padding: 0px; float: left; width: 175px; margin-bottom: 8px; }';

         echo '</style>';

	}

	

	

	function PrePareHTML(){

		echo '<form id="GiftForm" method="post" action="post.php" content="Select Friends" type="gifts" invite="false">';

		echo '<div id="friend-checkboxes" >';

		echo '<div id="tabs_wrapper" style="display: block;" > ';

		echo '<div id="friendview_tabs" style="height: 20px; color: rgb(102, 102, 102); display: inline;" >';

		echo '<a id="selected_tab" class="xtab-unbold" style="float: right;" onclick="fs_select_tab(\'selected\')" >Selected</a>';


		echo '</div>';

		echo '<div id="friend_tabs" style="height: 20px; color: rgb(102, 102, 102); display: inline;" >';

		echo '<a id="facebook_tab" class="xtab-bold" onclick="fs_select_tab(\'facebook\')" > Friends</a>';

		echo '</div>';

		echo '</div>';

		echo '<br clear="all">';

		echo '<div id="friend_selector_tools_container" style="border-style: solid solid none; border-color: rgb(204, 204, 204) rgb(204, 204, 204) rgb(255, 255, 255); border-width: 1px 1px 0px; padding: 5px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" >';

		echo '<div style="border: 0pt none rgb(255, 255, 255); margin: 0pt; padding: 0pt; float: right;">';

		echo '<div id="fb_select_controls" style="padding: 5px 5px 0pt 0pt; margin-bottom: 0pt;" >';

		echo '<b><a id="id_select_all" href="#" onclick="fs_select_all_friends(); return false;" >Select All</a></b> |&nbsp;';

		echo '<b><a id="id_random_set" href="#" onclick="fs_select_lucky(30); return false" >Lucky 30</a></b> |&nbsp;';

		echo '<div id="clear_link" style="display: inline;" >';

		echo '<b><a href="#" onclick="fs_clear_friends(); return false">Clear</a></b>';

		echo '</div>';

		echo '</div>';

		echo '</div>';

		echo '<div id="friend_selector_search_box" style="height: 24px;" >';

		echo '<input id="fs_search_input" style="border: 1px solid rgb(204, 204, 204); padding: 3px; width: 270px; font-size: 12px; color: rgb(102, 102, 102);" value="Start Typing a Friend\'s Name" onfocus="fs_search_input_focus();" onblur="fs_search_input_blur();" onkeypress="fs_search_input_changed(event);" onkeyup="fs_search_input_keyup(event);"  type="text">';

		echo '</div>';

		echo '</div>';

		echo '<div id="all_friends_container" class="binvite-container" style="color: rgb(102, 102, 102);" >';

		for ($i = 0; $i < count($this->friends); $i++){

			$t = $i+1;

			echo '<div class="biuser" id="fbfriend_'.$this->friends[$i].'" style="display: block;" >';

            echo '<input class="fscb" id="selectUsers_'.$t.'" name="selectUsers[]" value="'.$this->friends[$i].'" onclick="fs_user_onclick(this)"  type="checkbox">';

            echo '<fb:tag name="label"><fb:tag_attribute name="for">selectUsers_'.$t.'</fb:tag_attribute>';

            echo '<fb:tag_attribute name="id">friendName_'.$this->friends[$i].'</fb:tag_attribute>';

            echo '<fb:tag_attribute name="title"><fb:name linked="false" uid="'.$this->friends[$i].'"/>::'.$this->friends[$i].'</fb:tag_attribute>';

            echo '<fb:tag_body><fb:name linked="false" uid="'.$this->friends[$i].'"/></fb:tag_body>';

            echo '</fb:tag>';

            echo '</div>';

	    }

	         		 

		echo '</div>'; 

		echo '</div>';
		
		echo '<a href="#" class="inputbutton" onclick="showconfirmpopup();return(false);"> POST ALL </a>';
        echo '<A href="#" class="inputbutton" onclick="submitForm();return(false);"> POST SELECTED </a>';

		echo '</form>';

	}

	

	

	

	function PrePareforUserList(){

		echo '<script>';	

		echo 'var fs_default_text = "Start Typing a Friend\'s Name";';

	    echo 'var friend_words=[], names, i, app_users = {};';

	    echo 'fs_tabs.push("selected");';

	    echo 'app_users["1true"] = true;';

	    echo 'var all_friend_uids = ['.implode(",",$this->friends).'];';

	    echo 'var friendNames = [];';

	    echo 'for (var i=0; i < all_friend_uids.length; i++) {';

	    echo 'friendNames.push(document.getElementById(\'friendName_\' + all_friend_uids[i]).getTitle());'; 

        echo '}';

        echo 'friendNames.sort();';

        echo 'for (var i=friendNames.length - 1; i >= 0; i--) {';

        echo 'var uid = friendNames[i].split(\'::\')[1];';

        echo 'var friendDiv = document.getElementById(\'fbfriend_\' + uid);';

        echo 'var name=friendNames[i].split(\'::\')[0];';

        echo 'document.getElementById(\'friendName_\' + uid).setTitle(name);';

        echo 'friendDiv.getParentNode().insertBefore(friendDiv, friendDiv.getParentNode().getFirstChild());';

        echo 'names=name.toLowerCase().split(" ");';

        echo ' for (var j = 0; j < names.length; j++) if (names[j].length) friend_words.push([names[j], uid, true]);';

        echo '}';

        echo 'fs_current_tab = "facebook";';

        echo '</script>';
        
        echo '<fb:js_string var="confirm_dialog_title">';
        echo 'POST ALL';
        echo '</fb:js_string>';
        
        echo '<fb:js_string var="confirm_dialog_text">';
        echo 'POST ALL';
        echo '</fb:js_string>';
           



	}
	
	
	function SubmitForm(){
		 echo '<script>';
		 echo 'function submitForm()';
         echo '{';
         echo ' document.getElementById(\'GiftForm\').submit();';
         echo '}';
         echo 'function showconfirmpopup()';
         echo '{';
         echo 'var dialog = new Dialog().showChoice(confirm_dialog_title, confirm_dialog_text, \'Ok\', \'Cancel\'); ';
         echo 'dialog.onconfirm = function() {fs_select_all_friends();submitForm()};';
         echo '}';
         echo '</script>';
	}

		

	

}



$FriendSelector = new FriendSelector();



?>
