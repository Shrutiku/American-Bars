<?php
$theme_url = base_url() . getThemeName();
$data = array(
    'facebook' => $this->fb_connect->fb,
    'fbSession' => $this->fb_connect->fbSession,
    'user' => $this->fb_connect->user,
    'uid' => $this->fb_connect->user_id,
    'fbLogoutURL' => $this->fb_connect->fbLogoutURL,
    'fbLoginURL' => $this->fb_connect->fbLoginURL,
    'base_url' => site_url('home/facebook'),
    'appkey' => $this->fb_connect->appkey,
);
?>

<script src="<?php echo base_url() . getThemeName(); ?>/js/jquery.oauthpopup.js"></script>
<script src="//connect.facebook.net/en_US/all.js"></script>  

<div id="fb-root"></div>
<!-- <script>
//$.oauthpopup({path:'<?php //echo site_url('home/twitter')    ?>'});


  window.fbAsyncInit = function() {
    FB.init({
      appId      : '322878041237170', // Set YOUR APP ID
      channelUrl : 'http://hayageek.com/examples/oauth/facebook/oauth-javascript/channel.html', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });
 
    // FB.Event.subscribe('auth.authResponseChange', function(response) 
    // {
     // if (response.status === 'connected') 
    // {
        // //document.getElementById("message").innerHTML +=  "<br>Connected to Facebook";
        // //SUCCESS
//  
    // }    
    // else if (response.status === 'not_authorized') 
    // {
        // document.getElementById("message").innerHTML +=  "<br>Failed to Connect";
//  
        // //FAILED
    // } else 
    // {
        // document.getElementById("message").innerHTML +=  "<br>Logged Out";
//  
        // //UNKNOWN ERROR
    // }
    // }); 
 
    };
 
    function Login()
    {
 
        FB.login(function(response) {
           if (response.authResponse) 
           {
                getUserInfo();
               $('#shareonfacebook').modal('show');
            } else 
            {
             console.log('User cancelled login or did not fully authorize.');
            }
         },{scope: 'user_photos,publish_actions'});
 
    }
 
  function getUserInfo() {
        FB.api('/me', function(response) {
                        $('#shareonfacebook').modal('show');
                        //$("#fbname").va(response.username);
          
         // str +="<b>Link: </b>"+response.link+"<br>";
          // str +=""+response.username+"<br>";
          // str +="<b>id: </b>"+response.id+"<br>";
          // str +="<b>Email:</b> "+response.email+"<br>";
          // str +="<input type='button' value='Get Photo' onclick='getPhoto();'/>";
          // str +="<input type='button' value='Logout' onclick='Logout();'/>";
          document.getElementById("fbname").innerHTML=response.username;
 
    });
    }
    function getPhoto()
    {
      FB.api('/me/picture?type=normal', function(response) {
 
          var str="<br/><b>Pic</b> : <img src='"+response.data.url+"'/>";
          document.getElementById("status").innerHTML+=str;
 
    });
 
    }
    function LogoutFB()
    {
        FB.logout(function(){
                
          window.location = '<?php echo site_url('home/socialshare/logout'); ?>';
        });
    }
 
  // Load the SDK asynchronously
  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
    // js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));
 
</script> -->
<?php
$config = array(
    'appId' => '322878041237170',
    'secret' => '90f2a242f65cd83c3fb2a581dd778f92',
    'fileUpload' => true,
    'allowSignedRequest' => false // optional but should be set to false for non-canvas apps
);


$facebook = new Facebook($config);




$linkToOauthDialog = $this->facebook->getLoginUrl(
        array(
            'redirect_uri' => site_url("/home/fbreturn/")
        )
);
?>
<script>

    function googleplusbtn(url) {
        sharelink = "https://plus.google.com/share?url=" + url;
        newwindow = window.open(sharelink, 'name', 'height=400,width=600');
        if (window.focus) {
            newwindow.focus()
        }
        return false;
    }

    $(document).ready(function () {


        $('#facebook').oauthpopup({
            //$loginUrl='https://graph.facebook.com/oauth/authorize?type=user_agent&client_id=195571338990&redirect_uri=http%3A%2F%2Fwww.facebook.com/citynumbers?sk=app_195571338990&scope=publish_stream,status_update';

            path: '<?php echo $linkToOauthDialog . '&scope=user_photos,user_photos,publish_actions,email,user_friends, manage_pages, public_profile'; ?>',
            width: 600,
            height: 300,
            callback: function ()
            {
                window.location = '<?php echo site_url('home/facebookpost'); ?>';
            }
        });

        $('#connect2').oauthpopup({
            path: '<?php echo site_url('home/twitter'); ?>',
            callback: function ()
            {
                window.location = '<?php echo site_url('home/twitterpost'); ?>';
            }
        });
        // }
    });

    $.oauthpopup = function (options)
    {
        options.windowName = options.windowName || 'ConnectWithOAuth'; // should not include space for IE
        options.windowOptions = options.windowOptions || 'location=0,status=0,width=800,height=400';
        options.callback = options.callback || function () {
            window.location.reload();
        };
        var that = this;
        //log(options.path);
        that._oauthWindow = window.open(options.path, options.windowName, options.windowOptions);
        // window.close();
        that._oauthInterval = window.setInterval(function () {
            if (that._oauthWindow.closed) {
                window.clearInterval(that._oauthInterval);
                options.callback();
            }
        }, 1000);
    };
</script>
<script type="text/javascript">
    //window.close();
</script>

<form class="form-horizontal" role="form" name="info" id="info" action="<?php echo site_url("hauth/postall"); ?>" method="post">
    <div class="wrapper row6 padtb10 has-js">
        <div class="container">
            <div class="margin-top-50 bg_brown">
                <?php echo $this->load->view(getThemeName() . '/home/dashboard_menu'); ?>
                <div class="dashboard_detail">
                    <div class="result_search event"><div class="result_search_text"><i class="strip social_share"></i> Social Media</div></div>
                    <div id="container" style="display : inline-block; text-align: center;">

                        <h1>Login to your Social Media:</h1>

                        <div id="body" style="display : inline-block; text-align: center;">
                            <?php
                            if (@$error != "") {
                                echo "<div class='error1 text-center'>" . $error . "</div>";
                            }
                            if (@$msg != "" && $msg != "1V1") {
                                echo "<div class='success text-center'>" . $msg . "</div>";
                            }
                            ?>
                            <p>Select a service to authenticate with. If you have previously authenticated, it will be denoted below.</p>
                            <ul id="provider-list" style="text-align: center;">
<?php
// Output the enabled services and change link/button if the user is authenticated.
$this->load->helper('url');
$theme_url = $urls= base_url().getThemeName();
foreach ($providers as $provider => $data) {
    if ($data['connected']) {        
        echo anchor('hauth/logout/' . $provider, img(array('src'=>"$theme_url/images/logout_$provider.png",'border'=>'0','alt'=>'$provider', 'style'=>'max-width:10%;
   max-height:10%;padding-top: 5px;')), array('class' => 'connected'));
    } else {
        echo anchor('hauth/login/' . $provider, img(array('src'=>"$theme_url/images/login_$provider.png",'border'=>'0','alt'=>'$provider', 'style'=>'max-width:10%;
   max-height:10%;padding-top: 5px;')), array('class' => 'login'));
    }
}
?>
                            </ul>
                            <br style="clear: both;"/>

                        </div>
                        <p class="footer">       
<?php
// Output the profiles of each logged in service
foreach ($providers as $provider => $d) {
    if ($d && !empty($d['user_profile'])) {
        $profile[$provider] = (array) $d['user_profile'];
        ?>
                                <fieldset>
                                    <legend><strong><?= $provider ?></strong> Profile</legend>
                                    <table width="100%">
                                        <tr>
                                            <td width="150" valign="top" align="center">
        <?php
        if (!empty($d['user_profile']->profileURL)) {
            ?>
                                                    <a href="<?php echo $d['user_profile']->profileURL; ?>"><img src="<?php echo $d['user_profile']->photoURL; ?>" title="<?php echo $d['user_profile']->displayName; ?>" border="0" style="height: 120px;"></a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <img src="public/avatar.png" title="<?php echo $d['user_profile']->displayName; ?>" border="0" >
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td align="left"><table width="100%" cellspacing="0" cellpadding="3" border="0">
                                                    <tbody>
        <?php
        foreach ($d['user_profile'] as $key => $value) {
            if ($value == "") {
                continue;
            }
            ?>
                                                            <tr>
                                                                <td class="pItem"><strong><?= ucfirst($key) ?>:</strong> <?= (filter_var($value, FILTER_VALIDATE_URL) !== false) ? '<a href="' . $value . '" target="_blank">' . $value . '</a>' : $value; ?></td>
                                                            </tr>
    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </fieldset>
        <?php
    }
}
?>
                        </p>
                    </div>                
                    <div class="dashboard_subblock">              
                        <p class="bar_add" style="text-align: center;">Click Here to Post:</p>
                        <div class="padtb">
                            <div class="col-sm-3 text-right">
                                <label class="control-label">Message :</label>
                            </div>
                            <div class="input_box col-sm-7">                               
                                <input type="text" class="form-control form-pad" id="message" name="message" style="height: 100px;">
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="padtb">
                            <div class="col-sm-3 text-right">
                                <label class="control-label">Webpage Link :</label>
                            </div>
                            <div class="input_box col-sm-7">
                                <input type="text" class="form-control form-pad" id="link" name="link">
                            </div>
                            <div class="clearfix"></div> 
                        </div>

                        <div class="padtb">
                            <div class="col-sm-3 text-right">
                                <label class="control-label">Picture Link :</label>
                            </div>
                            <div class="input_box col-sm-7">
                                <input type="text" class="form-control form-pad" id="picture" name="picture">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="padtb" style="text-align: center;">

                            <button type="submit" class="btn btn-lg btn-primary marr_10" >Post</button>
                        </div>

                        <div class="container" style="max-width: 60%; padding-top: 5px">
                            <div class="social-feed-container"></div>
                        </div>
                    </div>                                                                        
                    <div class="clearfix"></div>
                </div>

            </div>             
        </div>
</form>

<script>

    $(document).ready(function () {
        var form1 = $('#posttoinstagram');
        var base = '<?php echo base_url(); ?>';
        var error1 = $('.alert-error', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-inline', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                comment_insta: {required: true},
                image_insta: {required: true, }
            },
            submitHandler: function (form) {
                success1.show();
                error1.hide();
                // var mydata = $("form#posttoinstagram").serialize();
                // $.ajax({
                // type: "POST",
                // url: "<?php //echo site_url('home/shareoninstagram')    ?>",
                // data: mydata,
                // dataType: 'json',
                // success: function(response, textStatus, xhr) {
                // if(response.error!="")
                // {
                // $("#ajax_msg_insta").html("<div class='error1 text-center'><a class='closemsg' data-dismiss='alert'></a><span>"+response.error+"</span></div>");
                // return false;
                // }
                // else if(response.msg=="success")
                // {
                // 				        		
                // }
                // }
                // });

                $.ajax({
                    url: "<?php echo site_url('home/shareoninstagram') ?>",
                    type: "POST",
                    dataType: 'JSON',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        if (response.error != "")
                        {
                            $("#ajax_msg_insta").html("<div class='error1 text-center'><a class='closemsg' data-dismiss='alert'></a><span>" + response.error + "</span></div>");
                            return false;
                        } else if (response.msg == "success")
                        {

                        }
                    },
                    error: function () {}
                });
            }
        });
    });
    $(document).ready(function () {
        var form1 = $('#instagram_login');
        var base = '<?php echo base_url(); ?>';
        var error1 = $('.alert-error', form1);
        var success1 = $('.alert-success', form1);
        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-inline', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                insta_password: {required: true},
                insta_username: {required: true, }
            },
            submitHandler: function (form) {
                success1.show();
                error1.hide();
                var mydata = $("form#instagram_login").serialize();
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('home/instagramlogin_ajax') ?>",
                    data: mydata,
                    dataType: 'json',
                    success: function (response, textStatus, xhr) {
                        if (response.error != "")
                        {
                            $("#ajax_msg_insta").html("<div class='error1 text-center'><a class='closemsg' data-dismiss='alert'></a><span>" + response.error + "</span></div>");
                            return false;
                        } else if (response.msg == "success")
                        {
                            window.location = '<?php echo site_url('home/instagrampost/') ?>';
                            //$("#shareoninstagram").modal('show');
                            //$("#instagramlogin").modal('hide');
                        }
                    }
                });
            }
        });
    });
    function showinstagram()
    {
<?php if (@$this->session->userdata("insta_username")) { ?>

            window.location = '<?php echo site_url('home/instagrampost') ?>';
<?php } else { ?>
            $('#instagramlogin').modal('show');

<?php } ?>

    }

    function appendPostParams()
    {
        document.getElementById('post').href = document.getElementById('post').href
                + "/\"" + document.getElementById('message').value + "\""
                + "/\"" + document.getElementById('link').value + "\""
                + "/\"" + document.getElementById('picture').value + "\"";
    }

    function showfacebook()
    {
        $('#shareonfacebook').modal('show');

    }



    function openpost()
    {

        $("#open_this").fadeIn();
        $("#hide_this").fadeOut();
    }

    function openpost_insta()
    {

        $("#open_this_insta").fadeIn();
        $("#hide_this_insta").fadeOut();
    }
    function openpost_facebook()
    {

        $("#open_this_facebook").fadeIn();
        $("#hide_this_facebook").fadeOut();
    }
    $(document).ready(function () {
<?php if ($msg == 'success') { ?>
            $.growlUI('<?php echo "Post send successfully."; ?>');

<?php } ?>

<?php if ($msg == 'logout') { ?>
            $.growlUI('<?php echo "You have successfully log out."; ?>');

<?php } ?>
<?php if ($msg == 'tw_wrong') { ?>
            $.growlUI('<?php echo "Somehing wrong with twitter. Please try again."; ?>');

<?php } ?>
<?php if ($screener_name) {
    ?>
            $('#myModal1').modal('show');
<?php } ?>
<?php if ($msg == 'twerror') { ?>
            $.growlUI('<?php echo "Somehing wrong with twitter. Please try again."; ?>');

<?php } ?>


    });
</script>

<!-- Codebird.js - required for TWITTER -->
<script src="<?php echo app_bower_url(); ?>/codebird-js/codebird.js"></script>
<!-- doT.js for rendering templates -->
<script src="<?php echo app_bower_url(); ?>/doT/doT.min.js"></script>
<!-- Moment.js for showing "time ago" and/or "date"-->
<script src="<?php echo app_bower_url(); ?>/moment/min/moment.min.js"></script>
<!-- Moment Locale to format the date to your language (eg. italian lang)-->
<script src="<?php echo app_bower_url(); ?>/moment/locale/en.js"></script>
<!-- Social-feed js -->
<script src="<?php echo app_bower_url(); ?>/social-feed/js/jquery.socialfeed.js"></script>

<script>
    $(document).ready(function () {
        $('.social-feed-container').socialfeed({
            // FACEBOOK
            facebook: {
                accounts: ["<?php echo!empty($providers['Facebook']['account']) ? "@" . $providers['Facebook']['account'] : ''; ?>"], //Array: Specify a list of accounts from which to pull wall posts
                limit: 20, //Integer: max number of posts to load
                access_token: <?php echo json_encode($config['appId'] . "|" . $config['secret']); ?>  //String: "APP_ID|APP_SECRET"
            },
            // TWITTER
            twitter: {
                accounts: ['<?php echo!empty($providers['Twitter']['account']) ? "@" . $providers['Twitter']['account'] : ''; ?>'], //Array: Specify a list of accounts from which to pull tweets
                limit: 20, //Integer: max number of tweets to load
                consumer_key: 'cu7KN3VKR9fqyPzVxaPpUEaVi', //String: consumer key. make sure to have your app read-only
                consumer_secret: '3B6uwOEyAMeCEXcKA0lIJCyhwCdQrvM0aSIATeWkUSPtAtXofZ' //String: consumer secret key. make sure to have your app read-only
            },
            /*// INSTAGRAM
             instagram:{
             accounts: ['<?php echo!empty($providers['Instagram']['account']) ? "#" . $providers['Instagram']['account'] : ''; ?>'],  //Array: Specify a list of accounts from which to pull posts
             limit: 10,                                   //Integer: max number of posts to load
             client_id: '3089866516',       //String: Instagram client id (option if using access token)
             access_token: '' //String: Instagram access token
             },*/

            // GENERAL SETTINGS
            length: 400, //Integer: For posts with text longer than this length, show an ellipsis.
            show_media: true, //Boolean: if false, doesn't display any post images
            media_min_width: 0, //Integer: Only get posts with images larger than this value
            update_period: 100, //Integer: Number of seconds before social-feed will attempt to load new posts.
            template: "<?php echo app_bower_url(); ?>/social-feed/template.html", //String: Filename used to get the post template.
            date_format: "ll", //String: Display format of the date attribute (see http://momentjs.com/docs/#/displaying/format/)
            date_locale: "en", //String: The locale of the date (see: http://momentjs.com/docs/#/i18n/changing-locale/)
            moderation: function (content) {                 //Function: if returns false, template will have class hidden
                return  (content.text) ? content.text.indexOf('fuck') == -1 : true;
            },
            callback: function () {                          //Function: This is a callback function which is evoked when all the posts are collected and displayed
                console.log("All posts collected!");
            }
        });
    });
</script>



<!--------------Scroll ------------------->
<link rel="stylesheet" href="<?php echo base_url() . getThemeName(); ?>/css/prettify.css">
<script src="<?php echo base_url() . getThemeName(); ?>/js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url() . getThemeName(); ?>/js/prettify.js"></script>
<script type="text/javascript">
    $(function () {
        $('#infinite-list').slimscroll({
            alwaysVisible: true,
            height: 410,
            color: '#f19d12',
            wheelStep: 1,
            opacity: .8
        });

        $('#infinite-list-fb').slimscroll({
            alwaysVisible: true,
            height: 410,
            color: '#f19d12',
            wheelStep: 1,
            opacity: .8
        });
        $('#infinite-list-in').slimscroll({
            alwaysVisible: true,
            height: 410,
            color: '#f19d12',
            wheelStep: 1,
            opacity: .8
        });

    });

    function change_url()
    {
        window.location = '<?php echo site_url('home/socialshare/'); ?>'
    }
</script>
<!--------------End Scroll ------------------->
<style>
    #infinite-list {
        height: 410px;
        margin-left: auto;
        margin-right: auto;
        overflow-x: hidden;
        overflow-y: scroll;
    }
    #infinite-list-fb {
        height: 410px;
        margin-left: auto;
        margin-right: auto;
        overflow-x: hidden;
        overflow-y: scroll;
    }
    #infinite-list-in {
        height: 410px;
        margin-left: auto;
        margin-right: auto;
        overflow-x: hidden;
        overflow-y: scroll;
    }
</style>	