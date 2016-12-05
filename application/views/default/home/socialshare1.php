<?php
$theme_url = base_url().getThemeName(); 
$data = array(
		'facebook'		=> $this->fb_connect->fb,
		'fbSession'		=> $this->fb_connect->fbSession,
		'user'			=> $this->fb_connect->user,
		'uid'			=> $this->fb_connect->user_id,
		'fbLogoutURL'	=> $this->fb_connect->fbLogoutURL,
		'fbLoginURL'	=> $this->fb_connect->fbLoginURL,	
		'base_url'		=> site_url('home/facebook'),
		'appkey'		=> $this->fb_connect->appkey,
	);
?>

<script src="<?php echo base_url().getThemeName(); ?>/js/jquery.oauthpopup.js"></script>
<script src="//connect.facebook.net/en_US/all.js"></script>


<div id="fb-root"></div>
<!-- <script>
//$.oauthpopup({path:'<?php //echo site_url('home/twitter')?>'});


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
        	
          window.location = '<?php echo site_url('home/socialshare/logout');?>';
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
     'redirect_uri'  =>  site_url("/home/fbreturn/")
  )

);

   
   
   
?>
<script>

function googleplusbtn(url) {
  sharelink = "https://plus.google.com/share?url="+url;
  newwindow=window.open(sharelink,'name','height=400,width=600');
  if (window.focus) {newwindow.focus()}                                                                                                                                
  return false;
}   

 $(document).ready(function(){
 	
 	
 	$('#facebook').oauthpopup({
 		//$loginUrl='https://graph.facebook.com/oauth/authorize?type=user_agent&client_id=195571338990&redirect_uri=http%3A%2F%2Fwww.facebook.com/citynumbers?sk=app_195571338990&scope=publish_stream,status_update';

		path: '<?php echo $linkToOauthDialog . '&scope=user_photos,user_photos,publish_actions,email,user_friends, manage_pages, public_profile';?>',
		width:600,
		height:300,
		callback: function()
    {
    	window.location = '<?php echo site_url('home/facebookpost');?>';
    }
   });
   
 	$('#connect2').oauthpopup({
    path: '<?php echo site_url('home/twitter');?>',
    callback: function()
    {
    	window.location = '<?php echo site_url('home/twitterpost');?>';
    }
});
  // }
  });
  
  $.oauthpopup = function(options)
{
    options.windowName = options.windowName ||  'ConnectWithOAuth'; // should not include space for IE
    options.windowOptions = options.windowOptions || 'location=0,status=0,width=800,height=400';
    options.callback = options.callback || function(){ window.location.reload(); };
    var that = this;
    //log(options.path);
    that._oauthWindow = window.open(options.path, options.windowName, options.windowOptions);
   // window.close();
    that._oauthInterval = window.setInterval(function(){
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


<div class="wrapper row6 padtb10 has-js">
     	<div class="container">
     		<div class="margin-top-50 bg_brown">
     			<?php echo $this->load->view(getThemeName().'/home/dashboard_menu'); ?>
     			<div class="dashboard_detail">
     				<div class="result_search event"><div class="result_search_text"><i class="strip social_share"></i> Social Share</div></div>
		     		<div class="dashboard_subblock">
					<div class="social-icons-new">
					<?php //if($user_id){?>
					<!-- <a href="javascript://" onclick="showfacebook();"><img src="<?php echo base_url().'default'?>/images/fb-new.png" /></a> -->
					<?php //} else {?>
					<a id="facebook" href="javascript://<?php //echo site_url('home/postfb')?>" ><img src="<?php echo base_url().'default'?>/images/fb-new.png" /></a> 	
					<?php // } ?>	
					

					<!-- <span style="cursor: pointer" id="myBtn" class="demo g-interactivepost"
   data-clientid="459810837189-okrp7mfgns7nfjjb5nekbevs4qrlsv11.apps.googleusercontent.com"
    data-contenturl="https://americanbars.com/home/jay"
    data-calltoactionlabel=""
    data-calltoactionurl="https://americanbars.com"
    data-cookiepolicy="single_host_origin"
    data-prefilltext="">
 <img src="<?php echo base_url().'default'?>/images/gplus-new.png" />
</span> -->
					<a href="javascript://" onclick="showinstagram();"><img src="<?php echo base_url().'default'?>/images/instagram-new.png" /></a>
					<a href="javascript://" id="connect2"  ><img src="<?php echo base_url().'default'?>/images/twitter-new.png" /></a>
					
					</div>
		     		<div>
     					
					





<!-- Place this asynchronous JavaScript just before your </body> tag -->
<script type="text/javascript">
(function() {
  var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
  po.src = 'https://apis.google.com/js/client:plusone.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
</script>
					
					<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
					<!-- <form name="add_event" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('bar/add_event/'.base64_encode($getbar['bar_id'])); ?>"> -->
						
     			
		     	</div>
     		</div>
     	<div class="clearfix"></div>
     </div>
   </div>
 </div>
    




<div class="modal fade login_pop2" id="instagramlogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	<div class="padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button  onclick="change_url()" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Instagram Login</div>
     				</div>
     				<?php if($this->session->userdata("insta_username")){?>
     				<a href="javascript://" onclick="openpost()" id="hide_this" class="btn btn-lg btn-primary marr_10 pull-right" >Create New Post</a><div class="clearfix"></div><br>
     				<?php } ?>
     				<div class="pad20">
     						<div id="ajax_msg_insta"></div>
     						<div class="error1 hide1" id="cm-err-main" style="text-align: center;">&nbsp;</div>
     						<form name="instagram_login" enctype="multipart/form-data" id="instagram_login" method="post" class="form-horizontal" action="<?php echo site_url("home/instagramlogin_ajax"); ?>">
     						<div class="error1 hide1 center" id="cm-err-main">&nbsp;</div>
	                       	
	                       	<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Username :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		 <input type="text" name="insta_username" required  id="insta_username" class="form-control form-pad" >
	                       		</div>
	                       		<div class="clearfix"></div>
	                       		
	                       		
	                       	</div>
	                       	
	                       	<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Password :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		 <input type="password" name="insta_password" required  id="insta_password" class="form-control form-pad" >
	                       		</div>
	                       		<div class="clearfix"></div>
	                       		
	                       		
	                       	</div>
	                       	
	                       	
	                       	 <div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10">
									<button class="btn btn-lg btn-primary" type="submit">Post</button>									
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	</form>	
	                       	
	                       	
	                       		
     				</div>		
     			</div>
     		</div>
     	</div>
     </div>	
</div>


<script>

$(document).ready(function () {
			    var form1 = $('#posttoinstagram');
		    var base = '<?php echo base_url();?>';
            var error1 = $('.alert-error', form1);
            var success1 = $('.alert-success', form1);
            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-inline', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                       comment_insta: {required: true},
                      	image_insta: { required:true,}
                },
                submitHandler: function (form) {
                    success1.show();
                    error1.hide();
                    // var mydata = $("form#posttoinstagram").serialize();
				    // $.ajax({
				        // type: "POST",
				        // url: "<?php //echo site_url('home/shareoninstagram')?>",
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
						url: "<?php echo site_url('home/shareoninstagram')?>",
						type: "POST",
						dataType:'JSON',
						data:  new FormData(this),
						contentType: false,
						cache: false,
						processData:false,
						success: function(data){
							if(response.error!="")
						        	{
						        		$("#ajax_msg_insta").html("<div class='error1 text-center'><a class='closemsg' data-dismiss='alert'></a><span>"+response.error+"</span></div>");
						        		return false;
						        	}
						        	else if(response.msg=="success")
						        	{
						        		
						        	}
						},
						error: function(){} 	        
						});
                }
            });
		});
$(document).ready(function () {
			    var form1 = $('#instagram_login');
		    var base = '<?php echo base_url();?>';
            var error1 = $('.alert-error', form1);
            var success1 = $('.alert-success', form1);
            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-inline', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                       insta_password: {required: true},
                      insta_username: { required:true,}
                },
                submitHandler: function (form) {
                    success1.show();
                    error1.hide();
                    var mydata = $("form#instagram_login").serialize();
				    $.ajax({
				        type: "POST",
				        url: "<?php echo site_url('home/instagramlogin_ajax')?>",
				        data: mydata,
				        dataType: 'json',
				        success: function(response, textStatus, xhr) {
				        	if(response.error!="")
				        	{
				        		$("#ajax_msg_insta").html("<div class='error1 text-center'><a class='closemsg' data-dismiss='alert'></a><span>"+response.error+"</span></div>");
				        		return false;
				        	}
				        	else if(response.msg=="success")
				        	{
				        		window.location = '<?php echo site_url('home/instagrampost/')?>';
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
	<?php if(@$this->session->userdata("insta_username")){?>
	
	    window.location = '<?php echo site_url('home/instagrampost')?>';
	<?php } else {?>
	$('#instagramlogin').modal('show');	
		
   <?php } ?>		
	
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
 	<?php if($msg=='success'){?>
 		$.growlUI('<?php echo "Post send successfully."; ?>'); 
 		
 	<?php } ?>	
 	
 	<?php if($msg=='logout'){?>
 		$.growlUI('<?php echo "You have successfully log out."; ?>'); 
 		
 	<?php } ?>
 	<?php if($msg=='tw_wrong'){?>
 		$.growlUI('<?php echo "Somehing wrong with twitter. Please try again."; ?>'); 
 		
 	<?php } ?>
 	<?php if($screener_name)
 	{ ?>
 		$('#myModal1').modal('show');
 	<?php }?>
 	<?php if($msg=='twerror'){?>
 		$.growlUI('<?php echo "Somehing wrong with twitter. Please try again."; ?>'); 
 		
 	<?php } ?>
 	

 });
</script>



<!--------------Scroll ------------------->
	<link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/css/prettify.css">
	<script src="<?php echo base_url().getThemeName(); ?>/js/jquery.slimscroll.js"></script>
	<script src="<?php echo base_url().getThemeName(); ?>/js/prettify.js"></script>
	<script type="text/javascript">
		$(function(){
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
 	window.location = '<?php echo site_url('home/socialshare/');?>'
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

