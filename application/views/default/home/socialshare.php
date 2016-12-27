<!DOCTYPE html>
<html>
<head>
<title>Facebook Login JavaScript Example</title>
<meta charset="UTF-8">
</head>
<body>
<script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
    	

                FB.api('/me/feed', 'post', { message: "FDsafsdfsdaf" }, function (response1) {
                    //debugger;
                    if (!response1 || response1.error) {
                        alert(response1.error.message);
                    } else {
                        alert('Post ID: ' + response1.id);
                    }
                });
      // Logged into your app and Facebook.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '322878041237170',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.5' // use graph api version 2.5
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
    	$("#fbid").val(response.id);
       //$('#myModal1').modal('show');	
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });
  }
  function post_on_wall()
{
    FB.getLoginStatus(function(response)
    {
    	alert(response);
        if (response.authResponse)
        {
        	alert(response.id);
            alert('Logged in!');
 
            // Post message to your wall
 
            var opts = {
                message : document.getElementById('fb_message').value,
                name : 'Post Title',
                link : 'www.postlink.com',
                description : 'post description',
                picture : 'http://2.gravatar.com/avatar/8a13ef9d2ad87de23c6962b216f8e9f4?s=128&amp;d=mm&amp;r=G'
            };
 
            FB.api('/me/feed', 'post', opts, function(response)
            {
            	alert(response.error.message);
                if (!response || response.error)
                {
                    alert('Posting error occured');
                }
                else
                {
                    alert('Success - Post ID: ' + response.id);
                }
            });
        }
        else
        {
            alert('Not logged in');
        }
    }, { scope : 'public_profile,email,publish_actions' });
}
</script>

<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->

<fb:login-button scope="public_profile,email,manage_pages,publish_actions,publish_stream" onlogin="checkLoginState();">
</fb:login-button>

<div id="status">
</div>
<div id="fb_div">
    <h3>Post to your Facebook wall:</h3> <br />
    <textarea id="fb_message" name="fb_message" cols="70" rows="7"></textarea> <br />
    <input type="button" value="Post on Wall" onClick="post_on_wall();" />
</div>
</body>
</html>
