userid=0;
accessToken='';
function applicationLoaded()
{
    FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            userid = response.authResponse.userID;
            accessToken = response.authResponse.accessToken;
            loadActions();
        } else if (response.status === 'not_authorized') {
            FB.login(function(response) {
                if (response.authResponse) {
                    loadActions();
                } else {
                    alert('User cancelled login or did not fully authorize.');
                }
            });
        } else {
            FB.login(function(response) {
                if (response.authResponse) {
                    loadActions();
                } else {
                    alert('User cancelled login or did not fully authorize.');
                }
            });
        }
    });
 
}
function loadActions()
{
    ente.loadFriends();
}
var ente={
    loadFriends:function()
    {
        FB.api('/me/friends', function(response) {
            for(var i=0;i<response.data.length;i++)
            {
                $('#friends-dropdown').append('<li><div style="display:table-cell;"><img src="https://graph.facebook.com/'+response.data[i].id+'/picture" /></div><div style="display:table-cell; vertical-align:middle;">'+response.data[i].name+'</div></li>');
            }
        });
    }
};