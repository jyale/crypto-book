function displayFormConfirm(title, message,form) {
    var dialogFormConfirm=new Dialog().showChoice(title, message, 'OK', 'Cancel');
    dialogFormConfirm.onconfirm = function() {form.submit()};
    return false;
} 

function imposeMaxLength(element, maxlimit) {
    fieldlength = element.getValue().length; 
    if (fieldlength > maxlimit) {
        element.setValue(element.getValue().substring(0, maxlimit));
    }
}

var submit_filters = {};
var fs_typing_timeout = null;
var fs_selected_friends = [];
var fs_tabs = ['facebook'];
var fs_current_tab = null;

		var sml = {};
 
		sml.facebook_people_dict = {};
		sml.facebook_friend_list = [];
		sml.loaded = null;	

		sml.lib = {};
	
		sml.lib.getElem = function(element) {
			if (typeof(element) == "string") {
				element = document.getElementById(element);
			}
			return element;
		};
 
		sml.lib.hasClass = function(ele, cls) {	
			ele = sml.lib.getElem(ele);
			return ele.hasClassName(cls);
		};
		
		sml.lib.removeClass = function(ele,cls) {	
			ele = sml.lib.getElem(ele);
			if (ele.hasClassName(cls)) {    	
				ele.removeClassName(cls);
			}
		};
 
		sml.lib.addClass = function(ele, cls) {	
			ele = sml.lib.getElem(ele);
			if (!ele.hasClassName(cls)) {
				ele.addClassName(cls);
			}
		};
 
		sml.lib.setClass = function(ele, cls) {	
			ele = sml.lib.getElem(ele);
			ele.setClassName(cls);
		};
		
		sml.lib.setStyle = function(ele, obj) {	
			ele = sml.lib.getElem(ele);
			ele.setStyle(obj);
		};
 
		sml.lib.getStyle = function(ele, name) {	
			ele = sml.lib.getElem(ele);
			return ele.getStyle(name);
		};
 
		sml.lib.setAction = function(ele, val) {
			ele = sml.lib.getElem(ele);
			ele.setAction(val);
		}
 
		sml.lib.setChecked = function(ele, checked) {
			ele = sml.lib.getElem(ele);
			ele.setChecked(checked);
		};
 
		sml.lib.getChecked = function(ele) {
			ele = sml.lib.getElem(ele);
			return ele.getChecked();
		};
 
		sml.lib.getValue = function(element) {
			element = sml.lib.getElem(element);
			return element.getValue();
		};
 
		sml.lib.setValue = function(ele, val) {
			ele = sml.lib.getElem(ele);
			ele.setValue(val);
		};
 
		sml.lib.focusElem = function(ele, val) {
			ele = sml.lib.getElem(ele);
			ele.focus();
		};
 
		sml.lib.getId = function(ele) {
			ele = sml.lib.getElem(ele);
			return ele.getId();
		};
 
		sml.lib.getChildren = function(ele) {
			ele = sml.lib.getElem(ele);
			var children = ele.getChildNodes();
			return children;
		};
 
		sml.lib.getParent = function(ele) {
			ele = sml.lib.getElem(ele);
			return ele.getParentNode();
		};
 
		sml.lib.getLastChild = function(ele) {
			ele = sml.lib.getElem(ele);
			var children = sml.lib.getChildren(ele);
			return children[children.length-1];
		};
		var getLastChild = sml.lib.getLastChild;
 
		sml.lib.appendChild = function(par, ele) {
			par = sml.lib.getElem(par);
			par.appendChild(ele);
		};
 
		sml.lib.createElement = function(type) {
			var ele = document.createElement(type);
			return ele;
		};
 
		sml.lib.createSWF  = function(parent_elem, src, width, height, flash_vars, flash_params, flash_attributes) {
			var ele = sml.lib.createElement('fb:swf');
 
			ele.setSWFSrc(src);
			ele.setWidth(width);
			ele.setHeight(height);
 
			sml.lib.appendChild(parent_elem, ele);
		};
 
		sml.lib.createIMG = function(parent_elem, attrs, bindables) {
			var img = sml.lib.createElement('img');
 
			img.setSrc(attrs.src);
 
			for (var k in bindables) {
				if (bindables[k]) {
					img.addEventListener('click', bindables[k]);
				}
			}
 
			sml.lib.appendChild(parent_elem, img);
 
			return img;
		};
 
		sml.lib.removeSWF = function(unbind_id) {
		};
 
		sml.lib.serialize_form = function(ele) {
			ele = sml.lib.getElem(ele);
			return ele.serialize();
		};
 
		sml.lib.setLocation = function(loc) {
			document.setLocation(loc);
		};
  
		
		sml.show_element = function(ele, style) {
			style = style || 'block';
			ele = sml.lib.getElem(ele);
			ele.setStyle({display: style});
		};
 
		sml.hide_element = function(ele) {
			ele = sml.lib.getElem(ele);
			ele.setStyle({display: 'none'});
		};
 
		sml.toggle_element = function(ele, style) {
			style = style || 'block';
			ele= sml.lib.getElem(ele);
			if (ele.getStyle('display') == 'none') {
				ele.setStyle({display: style});
			} else {
				ele.setStyle({display: 'none'});
			}
		};
		var toggle_element = sml.toggle_element;
 
		sml.set_element_text = function(ele, text) {
			ele = sml.lib.getElem(ele);
			if (text == "") {
				ele.setInnerFBML(emptyfbml);
			} else {
				ele.setInnerFBML(text);
			}
		};
 
		sml.set_text_value = function(ele, text) {
			ele = sml.lib.getElem(ele);
			ele.setTextValue(text);
		}
 
		sml.set_element_html = function(ele, html) {
			ele = sml.lib.getElem(ele);
			ele.setInnerXHTML(html);
		}
 
		sml.myDialog = null;
		sml.draw_dialog = function(e, title, body, buttons, onsetup, options) {
			sml.myDialog = new Dialog(Dialog.DIALOG_POP);
			if (buttons.length == 1) {
				if (buttons[0].callback) {
					sml.myDialog.onconfirm = buttons[0].callback;
					if (options.width){
						sml.myDialog.setStyle('width' , options.width);
					}
				}
				sml.myDialog.showMessage(title, body, buttons[0].text);
			} else {
				if (buttons[0].callback) {
					sml.myDialog.onconfirm = buttons[0].callback;
				}
				if (buttons[1].callback) {
					sml.myDialog.oncancel = buttons[1].callback;
				}
				sml.myDialog.showChoice(title, body, buttons[0].text, buttons[1].text);
			}
 
			if (onsetup) {
				onsetup();
			}
		}
 
		sml.destroy_popup = function() {
			if (sml.myDialog) {
				sml.myDialog.hide();
			}
		};
//2
 
function select_all_friends(setCheck) {
	clear_lucky_tabs();
	if (setCheck === true) {
		elem = document.getElementById('id_select_all');
		if (elem) {
			sml.lib.setClass(elem, "friend_tab_bold");
		}
	}
	for (i = 1; true; i++) {
		single_checkbox = document.getElementById('selectUsers_' + i);
		if (single_checkbox) {
			sml.lib.setChecked(single_checkbox, setCheck);
			single_checkbox = document.getElementById('all_selectUsers_' + i);
			if (single_checkbox) {
				sml.lib.setChecked(single_checkbox, setCheck);
			}
		} else {
			return i;
		}
	}
}
 
function is_inside(value, arr) {
	for (x = 0; x < arr.length; x++) {
		if (arr[x] == value) {
			return true;
		}
	}
	return false;
}
 
function show_checkbox_input() {
	var clear_link = document.getElementById('clear_link');
	if (clear_link) {
		sml.lib.setStyle(clear_link, {'display': 'inline'});
	}
 
	sml.show_element('friend_checkboxes');
}
 
function select_random_set(num) {
	show_checkbox_input();
	total = select_all_friends(false);
	sml.lib.setClass('id_random_set', "friend_tab_bold");
	already_selected = [];
	for (i = 1; i <= num && i < total; i++) {
		rand_select = Math.floor(Math.random() * total);
		single_checkbox = document.getElementById('selectUsers_' + rand_select);
		if (single_checkbox && is_inside(rand_select, already_selected) === false) {
			already_selected.push(rand_select);
			sml.lib.setChecked(single_checkbox, true);
			single_checkbox = document.getElementById('all_selectUsers_' + rand_select);
			if (single_checkbox) {
				sml.lib.setChecked(single_checkbox, true);
			}
		} else {
			i--;
		}
	}
 
	sml.hide_element('cheer_desc');
}
 
function select_lonely_set(lonely_friends) {
	show_checkbox_input();
	total = select_all_friends(false);
	sml.lib.setClass('id_lonely_set', 'friend_tab_bold');
	lonely_friends = lonely_friends.split(",");
	for (i = 1; i < total; i++) {
		single_checkbox = document.getElementById('selectUsers_' + i);
		if (single_checkbox) {
			for (x = 0; x < lonely_friends.length; x++) {
				if (sml.lib.getValue(single_checkbox) == lonely_friends[x]) {
					sml.lib.setChecked(single_checkbox, true);
					single_checkbox = document.getElementById('all_selectUsers_' + i);
					if (single_checkbox) {
						sml.lib.setChecked(single_checkbox, true);
					}
					break;
				}
			}
		} else {
			return i;
		}
 
	}
	sml.show_element('cheer_desc');
}
 
function clear_all_input() {
	for (i = 1; true; i++) {
		single_checkbox = document.getElementById('selectUsers_' + i);
		if (single_checkbox) {
			sml.lib.setChecked(single_checkbox, false);
			single_checkbox = document.getElementById('all_selectUsers_' + i);
			if (single_checkbox) {
				sml.lib.setChecked(single_checkbox, false);
			}
		} else {
			return i;
		}
	}
}
 
function show_multi_input() {
	sml.hide_element('nav_link_show_multi');
	sml.show_element('nav_link_show_checkbox');
	sml.hide_element('clear_link');
	sml.hide_element('friend_checkboxes');
	
	clear_lucky_tabs();
	clear_all_input();
}
 
function popup_warning(error) {
	sml.draw_dialog({clientY : 500}, 'Ooops!', error, [{'text' : 'OK', 'classes' : ['sml-inputbutton'], 'callback' : sml.destroy_popup}], function(){}, {type:'error'}); 
	return false;
}
 
function get_selectUsers(total) {
	var checkboxes = [];
	for (i = 1; i <= total; i++) {
		checkbox = document.getElementById('selectUsers_' + i);
		if (checkbox) {
			checkboxes.push(checkbox);
		}
	}
	return checkboxes;
}
 
function getCheckedUsers(total) {
  var selected = [], users = get_selectUsers(total);
  for (i = 0; i < users.length; i++) {
    if (users[i].checked) selected.push(users[i]);
  }
  return selected;
};
 
 
function selectUsers_clicked(total) {
	var users = get_selectUsers(total);
	var checked_user = false;
	for (i = 0; i < users.length; i++) {
		if (sml.lib.getChecked(users[i])) {
			checked_user = true;
		}
	}
	wrap_setPublishStatus(checked_user);
	return true;
}
 
 
function smartParseInt(str) {
	if (!str) {
		return 0;
	}
	if (str.match((new RegExp('^\\d+$','')))) {
		return parseInt(str);
	} else {
		return 0;
	}
}

 
function fs_search_input_focus() {
	var fs_input_box = document.getElementById("fs_search_input");
	if (fs_input_box && sml.lib.getValue(fs_input_box) === fs_default_text) {
		sml.lib.setValue(fs_input_box, "");
	}
};
 
function fs_search_input_blur() {
	var fs_input_box = document.getElementById("fs_search_input");
	if (fs_input_box) {
		var val = sml.lib.getValue(fs_input_box);
		if (!val) {
			sml.lib.setValue(fs_input_box, fs_default_text);
		}
	}
};
 
function fs_search_input_changed(e) {
	if (e && e.keyCode == 13) {
		e.preventDefault();
		return;
	}
	if (e && e.keyCode == 8) return;
	if (fs_typing_timeout !== null) clearTimeout(fs_typing_timeout);
	fs_typing_timeout = setTimeout(fs_search_delayed, 500);
};
 
function fs_search_input_keyup(e) {
	if (e && e.keyCode == 8)
		fs_search_delayed();
};
 
function fs_search_delayed() {
	var fs_input_box = document.getElementById("fs_search_input");
	var i, id, matches, triple, val = sml.lib.getValue(fs_input_box), friendlist;
 
	if (val === null || val === fs_default_text) return;
 
	fs_show_all();
	friendlist = fs_filter_current_tab(friend_words.slice());
	if (val.length) fs_filter_search(friendlist);
 
	fs_search_typing_timeout = null;
};
 
function fs_hide_all() {
	var i, id, prev, triple;
	for (i = 0; i < friend_words.length; i++) {
		triple = friend_words[i]; //
		if ("" + triple.slice(1,3) !== "" + prev) { //
			id = get_name.apply(null, triple.slice(1));
			if (id) {
				sml.lib.setChecked(id, false);
				sml.hide_element(id);
			}
		}
		prev = triple.slice(1, 3);
	}
};
 
function fs_show_all() {
	var i, id, prev, triple;
	for (i = 0; i < friend_words.length; i++) {
		triple = friend_words[i]; //
		if ("" + triple.slice(1,3) !== "" + prev) { //
			id = get_name.apply(null, triple.slice(1));
			if (id) sml.show_element(id);
		}
		prev = triple.slice(1, 3);
	}
};
 
function fs_show_selected() {
	var i, id, domobj, results = []; 
 
	for (i = 0; i < friend_words.length; i++) {
		id = get_name(friend_words[i][1], friend_words[i][2]);
		if (domobj = sml.lib.getElem(id))
			if (sml.lib.getChecked(domobj)) sml.show_element(domobj);
	}
};
 
function fs_filter_current_tab(friends) {
	var i, prev, triple;
 
	i = 0;
	prev = "never match the first one";
	while (i < friends.length) {
		triple = friends[i];
		if ("" + triple.slice(1) === prev) {
			prev = "" + triple.slice(1);
			i++;
			continue;
		}
		prev = "" + triple.slice(1);
 
		if (!fs_selector_funcs[fs_current_tab].apply(null, triple.slice(1))) {
			sml.hide_element(get_name.apply(null, triple.slice(1)));
			friends.splice(i--, 1);
		}
 
		i++;
	}
 
	return friends;
};
 
function fs_filter_search(friends) {
	var fs_input_box = document.getElementById("fs_search_input");
	var i, j, triple, word, words = sml.lib.getValue(fs_input_box).toLowerCase().split(" "), matches = [];
 
	i = 0;
	while (i < friends.length) {
		triple = friends[i];
		for (j = 0; j < words.length; j++) {
			word = words[j];
			if (word.length && word === triple[0].slice(0, word.length)) {
				friends.splice(i--, 1);
				matches.push("" + triple[1] + triple[2]);
				break;
			}
		}
		i++;
	}
 
	for (i = 0; i < friends.length; i++) {
		triple = friends[i];
		if (matches.indexOf("" + triple[1] + triple[2]) < 0)
			sml.hide_element(get_name(triple[1], triple[2]));
	}
 
	return matches;
};
 
var fs_tab_actions = {
	all: function() {
		var elem = sml.lib.getElem("friend_selector_tools_container");
		if (elem) {
			sml.show_element(elem);
			sml.lib.setStyle("all_friends_container", {height: "150px"});
		}
		sml.lib.setStyle("id_app_users", {display: "inline"});
	},
	selected: function() {
		var elem = sml.lib.getElem("friend_selector_tools_container");
		if (elem) {
			sml.hide_element(elem);
			sml.lib.setStyle("all_friends_container", {height: "185px"});
		}
	},
	email: function() {
		var elem = sml.lib.getElem("friend_selector_tools_container");
		if (elem) {
			sml.show_element(elem);
			sml.lib.setStyle("all_friends_container", {height: "150px"});
		}
		sml.lib.setStyle("id_app_users", {display: "none"});
	},
	facebook: function() {
		var elem = sml.lib.getElem("friend_selector_tools_container");
		if (elem) {
			sml.show_element(elem);
			sml.lib.setStyle("all_friends_container", {height: "150px"});
		}
		sml.lib.setStyle("id_app_users", {display: "inline"});
	}
};
 
var fs_selector_funcs = {
	all: function() { return true; },
	selected: function(id, is_fb) { return sml.lib.getChecked(sml.lib.getChildren(get_name(id, is_fb))[0]); },
	email: function(id, is_fb) { return !is_fb; },
	facebook: function(id, is_fb) { return is_fb; }
};
 
function get_name(id, is_fb) {
	return sml.lib.getElem((is_fb ? "fbfriend" : "emfriend") + "_" + id);
};
 
function fs_select_tab(tab) {
	var i, elem, prev, triple, searchbox;
	var fs_input_box = document.getElementById("fs_search_input");
	fs_current_tab = tab;
 
	for (i = 0; i < fs_tabs.length; i++) {
		elem = sml.lib.getElem(fs_tabs[i] + "_tab");
		if (elem) {
			sml.lib.removeClass(elem, 'xtab_bold');
			sml.lib.addClass(elem, 'xtab_unbold');
		}
	}
 
	if (fs_input_box) {
		sml.lib.setValue(fs_input_box, "");
		fs_search_input_blur();
	}
 
	elem = sml.lib.getElem(tab + "_tab");
	if (elem) {
		sml.lib.removeClass(elem, 'xtab_unbold');
		sml.lib.addClass(elem, 'xtab_bold');
	}
 
	fs_show_all();
	fs_filter_current_tab(friend_words.slice());
 
	if (fs_tab_actions[tab]) fs_tab_actions[tab]();
};
 
function fs_user_onclick(elem) {
	var id = sml.lib.getId(elem);
	if (typeof fs_selected_friends == "undefined")
		var fs_selected_friends = [];
	index = fs_selected_friends.indexOf(id);
	if (index + 1) {
		fs_selected_friends.splice(index, 1);
	} else {
		fs_selected_friends.push(id);
	}
};
 
function fs_clear_friends(checked) {
	var i, triple, prev, current, container, name;
 
	if (typeof(checked) == "undefined") {
		checked = false;
	}
 
	prev = "never match the first one";
	for (i = 0; i < friend_words.length; i++) {
		triple = friend_words[i];
		current = "" + triple[1] + triple[2];
		if (prev == current) {
			prev = current;
			continue;
		}
		prev = current;
 
		name = get_name(triple[1], triple[2]);
		if (sml.lib.getStyle(name, "display") != "none") {
			container = sml.lib.getElem(name);
			sml.lib.setChecked(sml.lib.getChildren(container)[0], checked);
		}
	}
};
 
function fs_select_all_friends() {
	return fs_clear_friends(true);
};
 
function fs_select_lucky(num) {
	var i, triple, prev, current, friend_list = [], lucky = [], luckynum, name;
	fs_clear_friends();
 
	prev = "never match the first one";
	for (i = 0; i < friend_words.length; i++) {
		triple = friend_words[i];
		current = "" + triple[1] + triple[2];
		if (prev == current) {
			continue;
		}
		prev = current;
 
		name = get_name(triple[1], triple[2]);
		if (sml.lib.getStyle(name, "display") != "none" &&
				!sml.lib.getChecked(sml.lib.getChildren(name)[0]))
			friend_list.push(triple.slice(1));
	}
 
	for (i = 0; i < num; i++) {
		luckynum = Math.floor(Math.random() * (friend_list.length + 1));
		lucky.push(friend_list.splice(luckynum, 1)[0]);
	}
 
	for (i = 0; i < lucky.length; i++) {
		if (lucky[i])
			sml.lib.setChecked(sml.lib.getChildren(get_name(lucky[i][0], lucky[i][1]))[0], true);
	}
};
 
function fs_select_userfriends() {
	var i, len, triple, prev, current, name;
 
	fs_clear_friends();
	prev = "never match the first one";
	for (i = 0, len = friend_words.length; i < len; i++) {
		triple = friend_words[i];
		current = "" + triple[1] + triple[2];
		if (prev == current) continue;
		prev = current;
 
		name = get_name(triple[1], triple[2]);
		if (sml.lib.getStyle(name, "display") != "none")
			if (app_users[current] && !sml.lib.getChecked(sml.lib.getChildren(name)[0])) {
				sml.lib.setChecked(sml.lib.getChildren(name)[0], true);
		}
	}
};
