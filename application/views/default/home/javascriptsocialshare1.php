<script src="//connect.facebook.net/en_US/all.js"></script>
<div id="fb-root"></div>
<script>
var url='<?php echo base_url(); ?>home/shareonfacebook';
$(document).ready(function (e){
$("#posttofacebook").on('submit',(function(e){
e.preventDefault();
$.ajax({
url: url,
type: "POST",
dataType:'JSON',
data:  new FormData(this),
contentType: false,
cache: false,
processData:false,
success: function(data){
	
	FB.login(function(response)
    {
    	
    	 if (response.authResponse)
        {
        var opts = {
                message : document.getElementById('fb_message').value,
                link : 'https://americanbars.com',
                description :  document.getElementById('comment_facebook').value,
                picture : data
            };
 
            FB.api('/me/feed', 'post', opts, function(response)
            {
                window.location = '<?php echo site_url('home/socialshare1/success')?>'
            });

}
else
{
	alert("You have not login.");
}	
}, { scope : 'user_photos,publish_actions' });
},
error: function(){} 	        
});

}));
});

function post_on_wall()
{
    FB.login(function(response)
    {
        if (response.authResponse)
        {
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
                if (!response || response.error)
                {
                    alert(response.error.message);
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
    }, { scope : 'user_photos,publish_actions' });
}
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '322878041237170', // Set YOUR APP ID
      channelUrl : 'http://hayageek.com/examples/oauth/facebook/oauth-javascript/channel.html', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });
 
    FB.Event.subscribe('auth.authResponseChange', function(response) 
    {
     if (response.status === 'connected') 
    {
        document.getElementById("message").innerHTML +=  "<br>Connected to Facebook";
        //SUCCESS
 
    }    
    else if (response.status === 'not_authorized') 
    {
        document.getElementById("message").innerHTML +=  "<br>Failed to Connect";
 
        //FAILED
    } else 
    {
        document.getElementById("message").innerHTML +=  "<br>Logged Out";
 
        //UNKNOWN ERROR
    }
    }); 
 
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
    function Logout()
    {
        FB.logout(function(){document.location.reload();});
    }
 
  // Load the SDK asynchronously
  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
    // js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));
 
</script>
<div id="status">
 Click on Below Image to start the demo: <br/>
<img src="http://hayageek.com/examples/oauth/facebook/oauth-javascript/LoginWithFacebook.png" style="cursor:pointer;" onclick="Login()"/>
</div>
 
<br/><br/><br/><br/><br/>
 
<div id="message">
Logs:<br/>
</div>
 
</div>
<div id="fb_div">
    <h3>Post to your Facebook wall:</h3> <br />
    <textarea id="fb_message" name="fb_message" cols="70" rows="7"></textarea> <br />
    <input type="button" value="Post on Wall" onClick="post_on_wall();" />
</div>
<?php //echo $google_plus_link;?>


<div class="wrapper row6 padtb10 has-js">
     	<div class="container">
     		<div class="margin-top-50 bg_brown">
     			<?php echo $this->load->view(getThemeName().'/home/dashboard_menu'); ?>
     			<div class="dashboard_detail">
     				<div class="result_search event"><div class="result_search_text"><i class="strip social_url"></i> Social Share</div></div>
		     		<div class="dashboard_subblock">
					<div class="social-icons-new">
					<?php //if($user_id){?>
					<a href="javascript://" onclick="Login();"><img src="<?php echo base_url().'default'?>/images/fb-new.png" /></a>
					<?php //} else {?>
					<!-- <a href="<?php echo site_url('home/postfb')?>" ><img src="<?php echo base_url().'default'?>/images/fb-new.png" /></a> -->	
					<?php //} ?>	
					<a href="#"><img src="<?php echo base_url().'default'?>/images/gplus-new.png" /></a>
					<a href="javascript://" onclick="showinstagram();"><img src="<?php echo base_url().'default'?>/images/instagram-new.png" /></a>
					<a href="<?php echo site_url('home/twitter');?>"><img src="<?php echo base_url().'default'?>/images/twitter-new.png" /></a>
					
					</div>
		     		<div>
     					
					
					
					<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
					<!-- <form name="add_event" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('bar/add_event/'.base64_encode($getbar['bar_id'])); ?>"> -->
						
     			
		     	</div>
     		</div>
     	<div class="clearfix"></div>
     </div>
   </div>
 </div>
    
 <div class="modal fade login_pop2" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	<div class="padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button  onclick="change_url()" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Post To Twitter</div>
     				</div>
     				<a href="javascript://" onclick="openpost()" id="hide_this" class="btn btn-lg btn-primary marr_10 pull-right" >Create New Post</a><div class="clearfix"></div>
     				<div class="pad20" style="display: none;" id="open_this">
     						<div id="ajax_msg_error_reg"></div>
     						<div class="error1 hide1" id="cm-err-main" style="text-align: center;">&nbsp;</div>
     						<form name="frm_add_review" enctype="multipart/form-data" id="frm_add_review" method="post" class="form-horizontal" action="<?php echo site_url("home/shareontwitter"); ?>">
     						<div class="error1 hide1 center" id="cm-err-main">&nbsp;</div>
	                       	
	                       	<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Description :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		 <textarea name="comment" maxLength='110' id="comment" class="form-control form-pad" ></textarea>
	                           		 <span>This textarea has a limit of 110 characters.</span>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       		
	                       		
	                       	</div>
	                       	
	                       	<input type="hidden" name="fbid" id="fbid" value="" />
	                       	
	                       	 <div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10">
									<button class="btn btn-lg btn-primary" type="submit">Post</button>									
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	</form>	
	                       	
	                       	
	                       		
     				</div>		
     				
     				<div class="pad20">
     					<div class="reult_sub_title"><h4 class="media-heading"><a class="pull-left listing-title">Posts List</a></h4></div><div class="clearfix"></div>
     					<ul class="happy-list" id="infinite-list">
     						
     						<div class="clearfix"></div><?php
     						
     						 if($getpost){
     							  foreach($getpost as $r){?>
                        	<li>
                            	<p class="happy-title"><?php echo $r->comment;?></p>
                                <p class="happy-text"><?php echo $r->date;?></p>
                            </li>
                            <?php } } else {?>
                            	<h3>No any post founds.</h3>
                            <?php } ?>	
                            </li>
                        </ul>	
     						
     						
     				</div>	
     			</div>
     		</div>
     	</div>
     </div>	
</div>


<div class="modal fade login_pop2" id="shareoninstagram" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	<div class="padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button  onclick="change_url()" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Post To Instagram</div>
     				</div>
     				<div class="pad20">
     				<h2><?php echo $this->session->userdata("insta_username")!='' ? 'Welcome '.$this->session->userdata("insta_username"):''?> <a class="listing-title" href="javascript://"  onclick="Logout();">Logout</a></h5>
     				</div>
     				<a href="javascript://" onclick="openpost_insta()" id="hide_this_insta" class="btn btn-lg btn-primary marr_10 pull-right" >Create New Post</a><div class="clearfix"></div>
     				<div class="pad20" style="display: none;" id="open_this_insta">
     						<div id="ajax_msg_error_reg"></div>
     						<div class="error1 hide1" id="cm-err-main" style="text-align: center;">&nbsp;</div>
     						<form name="posttoinstagram" enctype="multipart/form-data" id="frm_add_review" method="post" class="form-horizontal" action="<?php echo site_url("home/shareoninstagram"); ?>">
     						<div class="error1 hide1 center" id="cm-err-main">&nbsp;</div>
	                       	
	                       	<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Description :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		 <textarea name="comment_insta"  id="comment_insta" class="form-control form-pad" ></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       		
	                       		
	                       	</div>
	                       	
	                       	<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Image :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		 <input name="image_insta" type="file"  id="image_insta" class="form-control form-pad" accept="image/jpeg" >
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
     				
     				<div class="pad20">
     					<div class="reult_sub_title"><h4 class="media-heading"><a class="pull-left listing-title">Posts List</a></h4></div><div class="clearfix"></div>
     					<ul class="happy-list" id="infinite-list">
     						
     						<div class="clearfix"></div><?php
     						
     						 if($getpost){
     							  foreach($getpost as $r){?>
                        	<li>
                            	<p class="happy-title"><?php echo $r->comment;?></p>
                                <p class="happy-text"><?php echo $r->date;?></p>
                            </li>
                            <?php } } else {?>
                            	<h3>No any post founds.</h3>
                            <?php } ?>	
                            </li>
                        </ul>	
     						
     						
     				</div>	
     			</div>
     		</div>
     	</div>
     </div>	
</div>


<div class="modal fade login_pop2" id="shareonfacebook" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	<div class="padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button  onclick="change_url()" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Post To Facebook</div>
     				</div>
     				<div class="pad20">
     				<h2> Welcome <span id="fbname"></span> <a class="listing-title" href="<?php echo site_url('home/fblogout')?>">Logout</a></h5>
     				</div>
     				<a href="javascript://" onclick="openpost_facebook()" id="hide_this_facebook" class="btn btn-lg btn-primary marr_10 pull-right" >Create New Post</a><div class="clearfix"></div>
     				<div class="pad20" style="display: none;" id="open_this_facebook">
     						<div id="ajax_msg_error_reg"></div>
     						<div class="error1 hide1" id="cm-err-main" style="text-align: center;">&nbsp;</div>
     							<form id="posttofacebook" method="post" action="" enctype="multipart/form-data"> 
     						<div class="error1 hide1 center" id="cm-err-main">&nbsp;</div>
	                       	
	                       	<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Description :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		 <textarea name="comment_facebook"  id="comment_facebook" class="form-control form-pad" ></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       		
	                       		
	                       	</div>
	                       	
	                       	<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Image :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		 <input name="image_facebook" type="file"  id="image_facebook" class="form-control form-pad" accept="image\*" >
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
     				
     				<div class="pad20">
     					<div class="reult_sub_title"><h4 class="media-heading"><a class="pull-left listing-title">Posts List</a></h4></div><div class="clearfix"></div>
     					<ul class="happy-list" id="infinite-list">
     						
     						<div class="clearfix"></div><?php
     						
     						 if($getpost){
     							  foreach($getpost as $r){?>
                        	<li>
                            	<p class="happy-title"><?php echo $r->comment;?></p>
                                <p class="happy-text"><?php echo $r->date;?></p>
                            </li>
                            <?php } } else {?>
                            	<h3>No any post founds.</h3>
                            <?php } ?>	
                            </li>
                        </ul>	
     						
     						
     				</div>	
     			</div>
     		</div>
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
     				<a href="javascript://" onclick="openpost()" id="hide_this" class="btn btn-lg btn-primary marr_10 pull-right" >Create New Post</a><div class="clearfix"></div><br>
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
	                           		 <input type="text" name="insta_username"  id="insta_username" class="form-control form-pad" >
	                       		</div>
	                       		<div class="clearfix"></div>
	                       		
	                       		
	                       	</div>
	                       	
	                       	<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Password :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		 <input type="text" name="insta_password"  id="insta_password" class="form-control form-pad" >
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
				        		$("#shareoninstagram").modal('show');
				        		$("#instagramlogin").modal('hide');
				        	}
				        }
				    });
                }
            });
		});
function showinstagram()
{
	<?php if(@$this->session->userdata("insta_username")){?>
	
	$('#shareoninstagram').modal('show');
	<?php } else {?>
	$('#instagramlogin').modal('show');	
		
   <?php } ?>		
	
}

function showfacebook()
{
	$('#shareonfacebook').modal('show');
	
}
function maxLength(el) {	
	if (!('maxLength' in el)) {
		var max = el.attributes.maxLength.value;
		el.onkeypress = function () {
			if (this.value.length >= max) return false;
		};
	}
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
 	maxLength(document.getElementById("comment"));
 	<?php if($msg=='success'){?>
 		$.growlUI('<?php echo "Post send successfully."; ?>'); 
 		
 	<?php } ?>	
 	
 	<?php if($msg=='logout'){?>
 		$.growlUI('<?php echo "You have successfully log out."; ?>'); 
 		
 	<?php } ?>
 	<?php if($screener_name)
 	{ ?>
 		$('#myModal1').modal('show');
 	<?php }?>

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
		      
		  });
		  
		   function change_url()
 {
 	window.location = '<?php echo site_url('home/socialshare1/');?>'
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
</style>	
