<?php
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
$theme_url = base_url() . getThemeName();
?>

<script src="<?php echo base_url() . getThemeName(); ?>/js/jquery.oauthpopup.js"></script>
<script src="//connect.facebook.net/en_US/all.js"></script>  

<div id="fb-root"></div>
<?php
$config = array(
    'appId' => '322878041237170',
    'secret' => '90f2a242f65cd83c3fb2a581dd778f92',
    'fileUpload' => true,
    'allowSignedRequest' => false // optional but should be set to false for non-canvas apps
);
?>

<form class="form-horizontal" role="form" name="info" id="info" action="<?php echo site_url("hauth/postall"); ?>" method="post">
    <div class="wrapper row6 padtb10 has-js">
        <div class="container">
            <div class="margin-top-50 bg_brown">
                <?php echo $this->load->view(getThemeName() . '/home/dashboard_menu'); ?>
                <div class="dashboard_detail">
                    <div class="result_search event"><div class="result_search_text"><i class="strip social_share"></i> Social Media</div></div>
                    <div id="container" style="display:inline-block; text-align: center;">

                        <h1>Login to your Social Media:</h1>

                        <div id="body" style="display: inline-block; text-align: center;">
                            <?php
                            /*if (@$error != "") {
                                echo "<div class='error1 text-center'>" . $error . "</div>";
                            }
                            if (@$msg != "" && $msg != "1V1") {
                                echo "<div class='success text-center'>" . $msg . "</div>";
                            }*/
                            ?>
                            <ul id="provider-list" style="text-align: center;">
<?php
// Output the enabled services and change link/button if the user is authenticated.
//$this->load->helper('url');
/*foreach ($providers as $provider => $data) {
    if ($data['connected']) {        
        echo anchor('hauth/logout/' . $provider, img(array('src'=>"$theme_url/images/logout_$provider.png",'border'=>'0','alt'=>'$provider', 'style'=>'max-width:10%;
   max-height:10%;padding-right: 5px;', 'class' => 'connected')));
    } else {
        echo anchor('hauth/login/' . $provider, img(array('src'=>"$theme_url/images/login_$provider.png",'border'=>'0','alt'=>'$provider', 'style'=>'max-width:10%;
   max-height:10%;padding-right: 5px;', 'class' => 'login')));
    }
}*/
?>
                            </ul>
                            <br style="clear: both;"/>

                        </div>
                        <p class="footer">       
<?php
// Output the profiles of each logged in service
/*foreach ($providers as $provider => $d) {
    if ($d && !empty($d['user_profile'])) {
        $profile[$provider] = (array) $d['user_profile'];
        ?>
                                <fieldset>
                                    <legend><strong><?php echo $provider; ?></strong> Profile</legend>
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
                                                                <td class="pItem"><strong><?php echo ucfirst($key); ?>:</strong> <?php echo (filter_var($value, FILTER_VALIDATE_URL) !== false) ? '<a href="' . $value . '" target="_blank">' . $value . '</a>' : $value; ?></td>
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
}*/
?>
                    </div>                
                    <!--<div class="dashboard_subblock">              
                        <div class="padtb" style="text-align: center;">
                            <div class="input_box text-center">                               
                                <textarea class="form-control form-pad" id="message" name="message" style="width: 400px ; height: 100px;display: block; margin-left: auto; margin-right: auto;" placeholder="What's on your mind?"></textarea>
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
                    </div>-->                                                                        
                    <div class="clearfix"></div>
                </div>

            </div>             
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
<?php if ($msg == 'success') { ?>
            $.growlUI('<?php echo "Post sent successfully."; ?>');

<?php } ?>

<?php if ($msg == 'logout') { ?>
            $.growlUI('<?php echo "You have successfully log out."; ?>');

<?php } ?>
<?php if ($msg == 'login') { ?>
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
    /*$(document).ready(function () {
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
            // INSTAGRAM
             instagram:{
             accounts: ['<?php echo!empty($providers['Instagram']['account']) ? "#" . $providers['Instagram']['account'] : ''; ?>'],  //Array: Specify a list of accounts from which to pull posts
             limit: 10,                                   //Integer: max number of posts to load
             client_id: '3089866516',       //String: Instagram client id (option if using access token)
             access_token: '' //String: Instagram access token
             },

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
    });*/
</script>



<!--------------Scroll ------------------->
<link rel="stylesheet" href="<?php echo base_url() . getThemeName(); ?>/css/prettify.css">
<script src="<?php echo base_url() . getThemeName(); ?>/js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url() . getThemeName(); ?>/js/prettify.js"></script>
<script type="text/javascript">
    /*$(function () {
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
        window.location = '<?php echo site_url('home/socialshare/'); ?>';
    }*/
</script>
<!--------------End Scroll ------------------->
<style>
    /*#infinite-list {
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
    }*/
</style>	