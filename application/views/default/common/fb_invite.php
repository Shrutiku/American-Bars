<?php $theme_url = base_url().getThemeName(); ?>


<?php
$data = array(
		'facebook'		=> $this->fb_connect->fb,
		'fbSession'		=> $this->fb_connect->fbSession,
		'user'			=> $this->fb_connect->user,
		'uid'			=> $this->fb_connect->user_id,
		'fbLogoutURL'	=> $this->fb_connect->fbLogoutURL,
		'fbLoginURL'	=> $this->fb_connect->fbLoginURL,	
		'base_url'		=> site_url('home/invite'),
		'appkey'		=> $this->fb_connect->appkey,
	);
?>
  <!-- ************************************************************************ -->
  <div class="main-container">
    <div class="container">
        <div class="jumbotron">
        	<img src="<?php echo $theme_url; ?>/images/invite_facebook.png" id="facebook"  style="cursor:pointer;float:left;margin-left:460px;" />
        	
        	
        	<a href="<?php echo $data['fbLoginURL'];?>">ffb</a>

<div id="fb-root"></div>
   
   </script>
   <script type="text/javascript">
  window.fbAsyncInit = function() {
     FB.init({ 
       appId:'428176620608507', cookie:true, 
       status:true, xfbml:true,oauth : true 
     });
   };
   (function(d){
           var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
           if (d.getElementById(id)) {return;}
           js = d.createElement('script'); js.id = id; js.async = true;
           js.src = "//connect.facebook.net/en_US/all.js";
           ref.parentNode.insertBefore(js, ref);
         }(document));
 $('#facebook').click(function(e) {
    FB.login(function(response) {
	  if(response.authResponse) {
	  	alert("ram");
		  parent.location ='<?php echo site_url("home/invite"); ?>';
	  }
 },{scope: 'email,read_stream,publish_stream,user_birthday,user_location,user_work_history,user_hometown,user_photos'});
});
   </script>
         
      
         
       </div><!---->
      </div> <!-- /container -->
  </div>
  
  
  
  <script src="http://connect.facebook.net/en_US/all.js"></script> 
  <script> FB.init({ appId:'428176620608507', cookie:true, status:true, xfbml:true }); function FacebookInviteFriends() { FB.ui({ method: 'apprequests', message: 'Your Message diaolog' }); } </script> 
  //HTML Code <div id="fb-root"></div> 
  <a href='#' onclick="FacebookInviteFriends();"> Facebook Invite Friends Link </a> - 
 
<!-- ************************************************************************ -->