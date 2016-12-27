<style>
	#gmap_marker {
    height: 322px;
    width: 100%;
}
 .gm-style-iw
 {
 	color:#000000;
 }
 #infinite-list {
    height: 350px;
    margin-left: auto;
    margin-right: auto;
    overflow-x: hidden;
    overflow-y: scroll;
}
#infinite-favorite-beer {
    height: 350px;
    margin-left: auto;
    margin-right: auto;
    overflow-x: hidden;
    overflow-y: scroll;
}

#infinite-favorite-cocktail {
    height: 350px;
    margin-left: auto;
    margin-right: auto;
    overflow-x: hidden;
    overflow-y: scroll;
}
#infinite-favorite-bar {
    height: 350px;
    margin-left: auto;
    margin-right: auto;
    overflow-x: hidden;
    overflow-y: scroll;
}
#infinite-favorite-liquor {
    height: 350px;
    margin-left: auto;
    margin-right: auto;
    overflow-x: hidden;
    overflow-y: scroll;
}
</style>	
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/pgwslideshow.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/css/pgwslideshow.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/css/pgwslideshow_light.css" /><style>
	.ps-current 
	{
		max-height:470px !important; 
	}
</style>
<input type="hidden" name="sess_id" id="sess_id" value="<?php echo check_user_authentication()==""? '0':'1';?>" />
<style>
.morecontent span {
    display: none;
}
.morelink {
    display: block;
}
span.required {
    color: #B31010;
    vertical-align: -4px;
}
	#gmap_marker
	{
		width: 330px;
		height: 250px;
	}
	.gm-style-iw
	{
		color: #000000;
	}
	
	.bx-wrapper .bx-controls-direction a
	{
		width: 23px !important;
	}
	
</style>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.bxslider.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/css/jquery.bxslider.css" />
<script>
	
	$(document).ready(function() {
		
		$("#cocktailval").val(0);
		$("#liquorval").val(0);
		$("#beerval").val(0);
		$("#barval").val(0);
		
		$('.bxslider').bxSlider({
  minSlides: 4,
  maxSlides: 4,
  slideWidth: 265,
  slideMargin: 10
});


    var showChar = 600;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more";
    var lesstext = "Show less";
    
    $('.more').each(function() {
        var content = $(this).html();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink more pull-right"><i class="strip arrow_down"></i>' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
 
    $(".morelink").click(function(){
         $("#myModalnew_open").modal('show');
    });
});
</script>
<script type="text/javascript">
$(document).ready(function()
{


$('body').on('change','#photoimg', function()
 {
var A=$("#imageloadstatus");
var B=$("#imageloadbutton");

$("#imageform").ajaxForm({target: '#preview',
beforeSubmit:function(){
A.show();
B.hide();
},
success:function(){
A.hide();
B.show();
},
error:function(){
	
A.hide();
B.show();
} }).submit();
});

});
</script>

<!--------------Scroll ------------------->
	<link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/css/prettify.css">
	<script src="<?php echo base_url().getThemeName(); ?>/js/jquery.slimscroll.js"></script>
	<script src="<?php echo base_url().getThemeName(); ?>/js/prettify.js"></script>
	<script type="text/javascript">
		$(function(){
		      $('.full-new').slimscroll({
		        alwaysVisible: true,
		        height: 351,
		        color: '#C57B00',
		        opacity: 1,
		      });
		
		  });
	</script>
	<!--------------End Scroll ------------------->


<div class="wrapper row6">
     	<div class="container">
     		
     		<div>
     			<?php  if($getalldata['user_type']!='bar_owner'){ ?><div class="wrapper row4">
   			<div class="carousel slide" id="">
        	<div class="carousel-inner">
          	<div class="">
          	  	
          	  									<?php
          	  									
          	  									$userinfo_new = get_user_info($getalldata['user_id']);
          	  									
		          		if($userinfo_new->user_banner!="" && file_exists(base_path().'upload/banner_drag/'.@$userinfo_new->user_banner))
					{?>
		            	<img src="<?php echo base_url()?>/upload/banner_drag/<?php echo $userinfo_new->user_banner; ?>" alt="American Bars"/>
		            	<?php }  else if($userinfo_new->user_banner!="" && file_exists(base_path().'upload/banner_drag_without/'.@$userinfo_new->user_banner))
					{?>
						<img src="<?php echo base_url()?>/upload/banner_without_drag/<?php echo $userinfo_new->user_banner; ?>" alt="American Bars"/>
		            		
		            		<?php } else {?>
		            		<img src="<?php echo base_url().'default'?>/images/smallbanner1.png" alt="American Bars"/>	
		            			<?php } ?>
         </div>
        </div>
   	</div>
	</div>
  </div>
  
  <?php }  ?>
  </div>
  </div>
     			<div class="user-profile row5">
     			  <div class="container">
		     		<div class="dashboard_subblock">
		     			
		     			<div class="result_search">
		     				<h1 class="dashboard_smalltitle pull-left"><?php if($getalldata['user_type']=='user'){?>Welcome to <?php echo ucwords($getalldata['nick_name']);?>'s Profile<?php }  else { ?>Bar Information<?php } ?></h1>
		     				
                            <ul class="social_icon pull-right padt5">
		     					<li>Share Profile: </li>
							    <li><a href="javascript://" onclick="fbShare()"><img src="<?php echo base_url().'default'?>/images/result_fb.png" /></a></li>
							    <li><a onclick="twShare()" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_twitt.png" /></a></li>
							    <li><a onclick="gPlusShare1('http://www.americanbars.com/ADBCI/bar/details/314','Yukon Bar')" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_google.png" /></a></li>
							    <li><a href="javascript://" onclick="piShare()"><img src="<?php echo base_url().'default'?>/images/result_p.png" /></a></li>
							    
							    <div class="clearfix"></div>
					    	</ul>
                            <ul class="nav navbar-nav pull-right padright">
                             <li><a href="<?php echo site_url('home/user_dashboard')?>">Edit Profile</a></li>
                            </ul>
		     				 <!-- <a href="javascript://"  onclick="editbarinfo()"><i class="strip edit pull-right"></i></a> -->
		     				<div class="clearfix"></div>
		     			</div>
		     			<div>
		     			<div id="list_hide">	
		     				<div class="logo_block">
		     					<div id='preview'>

		     					<?php
		     				
		          		if($getalldata['profile_image']!="" && file_exists(base_path().'upload/user_thumb/'.@$getalldata['profile_image']))
					{?>
		            	<img class="img-responsive" src="<?php echo base_url()?>/upload/user_thumb/<?php echo $getalldata['profile_image']; ?>" alt="American Dive Bars"/>
		            	<?php }  else {?>
		            		<img class="img-responsive" src="<?php echo base_url()?>/upload/no-image.png" alt="American Dive Bars"/>	
		            			<?php  } ?>
		            			
		     					</div>		     					
		     						
		     					
		     					<!-- <a href="#" class="change_text"><i class="strip edit"></i> Change</a> -->
		     					
		     				</div>
		     					
		     				
		     				<div class="map_mainblock">
		     					<div>
		     						<ul class="dashboard_list-new">
		     							<li>
		     								<p class="marr_10 dashboard_newtitle padt5 min-120">Username</p> <p class="colon-new padt5"> : </p>  <p class="msg_username-new address-new"><?php echo ucwords(@$getalldata['nick_name']); ?></p>
		     								<div class="clearfix"></div>
		     								<?php if($getsetting=='' || $getsetting->fname==1){ ?><p class="marr_10 dashboard_newtitle min-120"><span>Name</p><p class="colon-new"> : </p> <p class="address-new pera"> <?php if($getsetting=='' || $getsetting->fname==1){ echo @$getalldata['first_name']; } else { echo "No First Name info to show ."; } ?></p>
		     								<div class="clearfix"></div><?php } ?>
		     								<?php if($getsetting=='' || $getsetting->gender1==1){ ?><p class="marr_10 dashboard_newtitle min-120"><span>Gender </span></p><p class="colon-new"> : </p><p class="address-new pera"> <?php if($getsetting=='' || $getsetting->gender1==1){ echo @$getalldata['gender']; }  else { echo "No Gender info to show ."; } ?></p>
		     								<div class="clearfix"></div> <?php } ?>
		     								<?php if(($getsetting=='' || $getsetting->address1==1) && ($getalldata['address']!='' && $getalldata['user_zip']!='' && $getalldata['user_city']!='' && $getalldata['user_state']!='')){ ?><p class="marr_10 dashboard_newtitle min-120"><span>Address </span></p><p class="colon-new"> : </p><p class="address-new pera"><?php if($getsetting=='' || $getsetting->address1==1){ echo @$getalldata['address'].'<br><span>'.$getalldata['user_city'].'  '.$getalldata['user_state'].'  '.$getalldata['user_zip']; } else { echo "No address info to show ."; } ?></span></p>
		     								<div class="clearfix"></div> <?php } ?>
		     								<p class="marr_10 dashboard_newtitle min-120"><span>Contact </span></p><p class="colon-new"> : </p><p class="address-new"><a href="javascript://" onclick="show_popup();" ><i class="strip mail_white"></i></a> <?php if($getalldata['mobile_no']!='' || $getalldata['mobile_no']!=''){?><a href="javascript://"  onclick="show_popup_new();" title="SMS"><i class="strip msg"></i></a><?php } ?></p>
		     								<div class="clearfix"></div> 
		     							</li>
		     							<li>
		     								<?php if($getsetting=='' || $getsetting->abt==1){ ?><p class="pera pull-left min-120 padt5"><span class="dashboard_newtitle">About Me : </span> </p>
			     							<p class="about-new pera">
			     									<?php 
			     									
			     								 if($getsetting=='' || $getsetting->abt==1){	
			     									if(strip_tags(strlen($getalldata['about_user'])>350)){ echo substr(strip_tags($getalldata['about_user']),0,350).'...<a class="morelink more pull-right mart10" href="javascript://"><i class="strip arrow_down"></i>Show more</a>' ; } else { echo strip_tags($getalldata['about_user']); }
	
												 } else {
												 	
													echo "No About User info to show.";
												 } ?>
			     								</p>	<?php } ?>
			     								<div class="clearfix"></div>
			     								<div>
					     						<?php if($getalldata['user_type']=='user'){?>	<ul class="social_icon">
					     				
					     					<?php if($getalldata['fb_link']!='' ||
												$getalldata['twitter_link']!='' ||
												$getalldata['gplus_link']!='' ||
												$getalldata['linkedin_link']!='' ||
												$getalldata['pinterest_link']!='' ||
												$getalldata['instagram_link']!=''){?>	<li class="dashboard_newtitle">Links : </li>
					     						<?php if($getalldata['fb_link']=='' &&
												$getalldata['twitter_link']=='' &&
												$getalldata['gplus_link']=='' &&
												$getalldata['linkedin_link']=='' &&
												$getalldata['pinterest_link']=='' &&
												$getalldata['instagram_link']==''){?>
													<li>No Social Media Link Available.</li>
													<?php } ?>
					     						<?php if($getalldata['fb_link']!=''){?>
											   <li><a target="_blank" href="<?php echo $getalldata['fb_link'];?>" ><img src="<?php echo base_url().'default'?>/images/fb.png"></a></li>
											   <?php } ?>
											   <?php if($getalldata['twitter_link']!=''){?>
											    <li><a target="_blank" href="<?php echo $getalldata['twitter_link'];?>"><img src="<?php echo base_url().'default'?>/images/twitter.png"></a></li>
											     <?php } ?>
											   <?php if($getalldata['gplus_link']!=''){?>
											    <li><a target="_blank" href="<?php echo $getalldata['gplus_link'];?>"><img src="<?php echo base_url().'default'?>/images/google.png"></a></li>
											     <?php } ?>
											    <?php if($getalldata['linkedin_link']!=''){?>
											    <li><a target="_blank" href="<?php echo $getalldata['linkedin_link'];?>"><img src="<?php echo base_url().'default'?>/images/linkedin.png"></a></li>
											     <?php } ?>
											    <?php if($getalldata['pinterest_link']!=''){?>
											    <li><a target="_blank" href="<?php echo $getalldata['pinterest_link'];?>"><img src="<?php echo base_url().'default'?>/images/pintrest.png"></a></li>
											     <?php } ?>
											    <?php if($getalldata['instagram_link']!=''){?>
											    <li><a target="_blank" href="<?php echo $getalldata['instagram_link'];?>"><img src="<?php echo base_url().'default'?>/images/instagram.png"></a></li>
											     <?php } ?>
											    <div class="clearfix"></div>
							    		 	</ul><div class="clearfix"></div>
							     			<?php } ?>	
					     					</div>
		     							</li>
		     							<?php } ?>
		     							<!-- <li><span class="marr_10 dashboard_newtitle">Name : </span> <?php if($getsetting=='' || $getsetting->fname==1){ echo @$getalldata['first_name']; } else { echo "No First Name info to show ."; } ?></li> -->
		     							<!-- <li><span class="marr_10 dashboard_newtitle">Last Name : </span> <?php if($getsetting=='' || $getsetting->lname==1){ echo @$getalldata['last_name']; }  else { echo "No Last Name info to show ."; } ?></li> -->
		     							<!-- <li><span class="marr_10">Email : </span> <?php if($getsetting=='' || $getsetting->email1==1){ echo @$getalldata['email']; }  else { echo "No Email info to show ."; } ?></li> -->
		     							<!-- <li><span class="marr_10 dashboard_newtitle">Gender : </span> <?php if($getsetting=='' || $getsetting->gender1==1){ echo @$getalldata['gender']; }  else { echo "No Gender info to show ."; } ?></li> -->
		     							<!-- <li><p class="marr_10 dashboard_newtitle pull-left">Address : </p> <p class="address-new"><?php if($getsetting=='' || $getsetting->address1==1){ echo @$getalldata['address'].'<br><span>'.$getalldata['user_city'].'  '.$getalldata['user_state'].'  '.$getalldata['user_zip']; } else { echo "No address info to show ."; } ?></span></p><div class="clearfix"></div></li> -->
		     							<!-- <li><span class="marr_10">Mobile Number : </span> <?php if($getsetting=='' || $getsetting->mnum==1){ echo @$getalldata['mobile_no']; }  else { echo "No Mobile Number info to show ."; } ?></li> -->
		     							<!-- <li><span class="dashboard_newtitle"><a href="#" title="E-Mail"><i class="strip mail_white"></i></a> <a href="#" title="SMS"><i class="strip msg"></i></a></li> -->
		     							<!--<li><span class="dashboard_newtitle"><a href="#" title="Message"><i class="strip msg"></i></a>  Mobile Number : <?php  if($getalldata['mobile_no']!='') {?> <a href="javascript://" class="msg_username" onclick="show_popup_new()" > Send a Text Message </a> <?php } else {?>Not available .<?php } ?></span>  </li>-->
		     								<div class="clearfix"></div>
		     							</ul>
		     							<!-- <p class="pera pull-left min-120"><span class="dashboard_newtitle">About User : </span> </p>
		     							<p class="about-new pera">
		     									<?php 
		     									
		     								 if($getsetting=='' || $getsetting->abt==1){	
		     									if(strip_tags(strlen($getalldata['about_user'])>350)){ echo substr(strip_tags($getalldata['about_user']),0,350).'...<a class="morelink more pull-right mart10" href="javascript://"><i class="strip arrow_down"></i>Show more</a>' ; } else { echo strip_tags($getalldata['about_user']); }

											 } else {
											 	
												echo "No About User info to show.";
											 } ?>
		     								</p>	
		     								<div class="clearfix"></div> -->
		     							<!-- <li><span class="marr_10">Description : </span> Erich</li> -->
		     						
		     					</div>
		     					<div class="clearfix"></div>
		     					
		     					
		     				
		     				</div>
							
							</div></div>
		     				<div class="clearfix"></div>
		     				
		     			<!-- <?php if($getalldata['user_type']=='user'){?>	<ul class="social_icon">
		     				
     						<li>Social Media link: </li>
     						<?php if($getalldata['fb_link']=='' &&
							$getalldata['twitter_link']=='' &&
							$getalldata['gplus_link']=='' &&
							$getalldata['linkedin_link']=='' &&
							$getalldata['pinterest_link']=='' &&
							$getalldata['instagram_link']==''){?>
								<li>No Social Media Link Available.</li>
								<?php } ?>
     						<?php if($getalldata['fb_link']!=''){?>
						   <li><a target="_blank" href="<?php echo $getalldata['fb_link'];?>" ><img src="<?php echo base_url().'default'?>/images/fb.png"></a></li>
						   <?php } ?>
						   <?php if($getalldata['twitter_link']!=''){?>
						    <li><a target="_blank" href="<?php echo $getalldata['twitter_link'];?>"><img src="<?php echo base_url().'default'?>/images/twitter.png"></a></li>
						     <?php } ?>
						   <?php if($getalldata['gplus_link']!=''){?>
						    <li><a target="_blank" href="<?php echo $getalldata['gplus_link'];?>"><img src="<?php echo base_url().'default'?>/images/google.png"></a></li>
						     <?php } ?>
						    <?php if($getalldata['linkedin_link']!=''){?>
						    <li><a target="_blank" href="<?php echo $getalldata['linkedin_link'];?>"><img src="<?php echo base_url().'default'?>/images/linkedin.png"></a></li>
						     <?php } ?>
						    <?php if($getalldata['pinterest_link']!=''){?>
						    <li><a target="_blank" href="<?php echo $getalldata['pinterest_link'];?>"><img src="<?php echo base_url().'default'?>/images/pintrest.png"></a></li>
						     <?php } ?>
						    <?php if($getalldata['instagram_link']!=''){?>
						    <li><a target="_blank" href="<?php echo $getalldata['instagram_link'];?>"><img src="<?php echo base_url().'default'?>/images/instagram.png"></a></li>
						     <?php } ?>
						    
						    
						    <div class="clearfix"></div>
		    		 	</ul><div class="clearfix"></div>
		     			<?php } ?>	 -->
		     				<div class="modal fade login_pop2" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	<div class="padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Send Message</div>
     				</div>
     				<div class="pad20">
     						<div id="ajax_msg_error_reg"></div>
     						<div class="error1 hide1" id="cm-err-main" style="text-align: center;">&nbsp;</div>
     						<form name="form" id="form" method="post" class="form-horizontal" action="<?php echo site_url("message/send_new_message"); ?>">
     						<div class="error1 hide1 center" id="cm-err-main">&nbsp;</div>
     							<input type="hidden" name="to_user_id" id="to_user_id" value="<?php echo $getalldata['user_id'];?>" />
     						<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Subject :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="subject" name="subject" >
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Message :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		 <textarea name="description" id="description" class="form-control form-pad" ></textarea>
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


<div class="modal fade login_pop2" id="myModal_msg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	<div class="padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Send Text Message</div>
     				</div>
     				<div class="pad20">
     						<div id="ajax_msg_error_reg"></div>
     						<div class="error hide1" id="cm-err-main" style="text-align: center;">&nbsp;</div>
     						<form name="form_msg" id="form_msg" method="post" class="form-horizontal" action="<?php echo site_url("user/send_text_message"); ?>">
     						<div class="error hide1 center" id="cm-err-main">&nbsp;</div>
     							<input type="hidden" name="name" id="name" value="<?php echo $getalldata['first_name']." ".$getalldata['last_name'];?>" />
     							<input type="hidden" name="number" id="number" value="<?php echo "+91".$getalldata['mobile_no'];?>" />
	                       	
	                       	<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Message :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		 <textarea name="description_msg" id="description_msg" class="form-control form-pad" ></textarea>
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
		     		<?php if($getsetting=='' || $getsetting->album==1){  if($albumgallery){
		     				// echo	count($albumgallery);
		     				
		     			
		     		$i=1;	foreach($albumgallery as $album){	?>	
		     		
		     		<?php if($i==1){?>
		     		 <div class="result_search margin-top-20">
		     				<h1 class="dashboard_smalltitle pull-left">ALBUM : <?php echo $album->title;?></h1>
		     				<?php if($getsetting=='' || $getsetting->album==1){  if($albumgallery){ ?>
		     			<ul class="social_icon pull-right">
     						<li>Share Album: </li>
						   <li><a href="javascript://" onclick="fbShare()" ><img src="<?php echo base_url().'default'?>/images/result_fb.png"></a></li>
						    <li><a onclick="twShare()" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_twitt.png"></a></li>
						    <li><a onclick="gPlusShare1('<?php echo site_url('user/profile/'.base64_encode($getalldata['user_id'])); ?>','<?php echo $getalldata['first_name']." ".$getalldata['last_name']; ?>')" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_google.png"></a></li>
						    <li><a onclick="inShare()" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_linkln.png"></a></li>
						    
						    <div class="clearfix"></div>
		    		 	</ul>
		    		 	<?php } } ?>
		     				 <!-- <a href="javascript://"  onclick="editbarinfo()"><i class="strip edit pull-right"></i></a> -->
		     				<div class="clearfix"></div>
		     				
		     		</div>	
		     		<div class="clearfix"></div>
		     		
		     			
		     		<ul class="bxslider">
		     		<?php $getimages = getalbumimageuser($album->bar_gallery_id);
						if($getimages){
						foreach($getimages as $rows){
						?>	
		     			<li>
		     					<a title="<?php echo $rows->image_title;?>" class="" onclick="opengallery('<?php echo $album->bar_gallery_id;?>')" href="javascript://"><img src="<?php echo base_url().'upload/bar_gallery_thumb_big/'.$rows->bar_image_name;?>" /></a>
                       </li>
					  	<?php } }  ?>
					  </ul>	<div class="clearfix"></div>
					<?php } $i++; } } ?>
				<?php if(count($albumgallery)>1){?>	
					<a class="pull-right btn-lg btn-primary"  href="javascript://"  onclick="see_gal();"><i class="strip arrow_down"></i>View All Galleries</a>
				<?php } } ?><div class="clearfix"></div>
				
				<div id="see_gal" style="display: none;" class="padtb10 pad_lr10 mug-gallery mar_top20">
     				<div class="result_search">
		     			<div class="result_search_text">All Albums <a onclick="hide_gal()" class="white pull-right review" href="javascript://">Close</a></div>
		             	<div class="clearfix"></div>
     				</div>
     				<div class="mar_top20">
     					<ul class="event-listing">
     					<?php if($bar_gallery_all){
     						foreach($bar_gallery_all as $bg){
     							
     					?>	
     						<a href="javascript://" onclick="opengallery('<?php echo $bg->bar_gallery_id; ?>')" >
     						<li  style="height: 240px;">
     							<div class="">
     									<img class=" img-responsive" src="<?php echo base_url().'upload/bar_gallery_thumb_big/'.$bg->bar_image_name;?>" />
     							</div>
     							<div class="event-detail">
     								<h1 class="event-title"><?php echo ucwords($bg->title); ?></h1>
     							</div>
     						</li></a>
     						<?php } } ?>
     						
     						<div class="clearfix"></div>
     					</ul>
     				  </div>
     				</div>
     					
					<div class="fullmug_block  margin-top-20">
						<!-- <div class="result_search margin-top-20">
		     				<h1 class="dashboard_smalltitle">Favorites</h1>
		     			</div> -->
						<div class="full-subblock margin-top-20">
			     			<div class="col-md-3 col-sm-3 padb20">
			     				<div class="bar_bg">
			     					<h1 class="box_title">Favorite Bars</h1>
			     					<ul class="bottom_box" id="infinite-favorite-bar">
     					
	         		<div class="clear"></div></ul><div class="clear"></div>
				     					
			     				</div>
			     			</div>
			     			<div class="col-md-3 col-sm-3 padb20">
			     				<div class="bar_bg">
			     					<h1 class="box_title">Favorite Beers</h1>
				     					<ul class="bottom_box" id="infinite-favorite-beer">
     					
	         		<div class="clear"></div></ul><div class="clear"></div>
			     				</div>
			     			</div>
			     			<div class="col-md-3 col-sm-3 padb20">
			     				<div class="bar_bg">
			     					<h1 class="box_title">Favorite Cocktails</h1>
				     					<ul class="bottom_box" id="infinite-favorite-cocktail">
     					
	         		<div class="clear"></div></ul><div class="clear"></div>
			     				</div>
			     			</div>
			     			<div class="col-md-3 col-sm-3 last padb20">
			     				<div class="bar_bg">
			     					<h1 class="box_title">Favorite Liquors</h1>
				     					<ul class="bottom_box" id="infinite-favorite-liquor">
     					
	         		<div class="clear"></div></ul><div class="clear"></div>
			     				</div>
			     			</div>
		     			
		     		     			
		     			
		     			<div class="clearfix"></div>	
		     			</div>
		     			<div class="clearfix"></div>
     			   </div>
					
					
     			</div>
     			<div class="clearfix"></div>
     		</div>
   		</div>
   	<input type="hidden" name="offset" id="offset" value="0" />
   	<input type="hidden" name="cocktailval" id="cocktailval" value="0" />
   	<input type="hidden" name="barval" id="barval" value="0" />
   	<input type="hidden" name="beerval" id="beerval" value="0" />
   	<input type="hidden" name="liquorval" id="liquorval" value="0" />
					<input type="hidden" name="limit" id="limit" value="5" />

<div class="modal fade" id="myModalnew_ajax" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
	<script>
	var base_url_favorite_bar = '<?php echo site_url('user/getAllFavoriteBar/?user_id='.$getalldata['user_id']); ?>';
	var base_url_favorite_beer = '<?php echo site_url('user/getAllFavoriteBeer/?user_id='.$getalldata['user_id']); ?>';
	var base_url_favorite_cocktail = '<?php echo site_url('user/getAllFavoriteCocktail/?user_id='.$getalldata['user_id']); ?>';
	var base_url_favorite_liquor = '<?php echo site_url('user/getAllFavoriteLiquor/?user_id='.$getalldata['user_id']); ?>';
</script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/infiniteScroll.js"></script>
<script type="text/javascript">InfiniteList.loadData_favorite_liquor(0,15);InfiniteList.loadData_favorite_bar(0,15);InfiniteList.loadData_favorite_beer(0,15);InfiniteList.loadData_favorite_cocktail(0,15);</script>
   
   	<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js" ></script>
   	<script type="text/javascript">
		$(function(){
		      
		      
		       $('#infinite-favorite-bar').slimscroll({
		        alwaysVisible: true,
		        height: 350,
		        color: '#f19d12',
		        opacity: .8
		      });
		      
		        $('#infinite-favorite-cocktail').slimscroll({
		        alwaysVisible: true,
		        height: 350,
		        color: '#f19d12',
		        opacity: .8
		      });
		      
		       $('#infinite-favorite-beer').slimscroll({
		        alwaysVisible: true,
		        height: 350,
		        color: '#f19d12',
		        opacity: .8
		      });
		      $('#infinite-favorite-liquor').slimscroll({
		        alwaysVisible: true,
		        height: 350,
		        color: '#f19d12',
		        opacity: .8
		      });
		      
		  });
function fbShare(){
	window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('<?php echo site_url('user/profile/'.base64_encode($getalldata['user_id'])); ?>'),'facebook-share-dialog','width=626,height=436');
            return false;
}

function twShare()
{
	var width  = 575,
        height = 400,
        left   = ($(window).width()  - width)  / 2,
        top    = ($(window).height() - height) / 2,
        url    = 'http://twitter.com/share?url=<?php echo site_url('user/profile/'.base64_encode($getalldata['user_id'])); ?>',
        opts   = 'status=1' +
                 ',width='  + width  +
                 ',height=' + height +
                 ',top='    + top    +
                 ',left='   + left;
    
    window.open(url, 'twitter', opts);
 
    return false;
}
function gPlusShare1(url,name)
    		{
		var w=480;var h=380;
		var x=Number((window.screen.width-w)/2);
		var y=Number((window.screen.height-h)/2);
		window.open('https://plus.google.com/share?url='+encodeURIComponent(url)+'&title='+encodeURIComponent(name),'','width='+w+',height='+h+',left='+x+',top='+y+',scrollbars=no');
		  
    	}
    	
    	function inShare()
{
	var width  = 600,
        height = 500,
        left   = ($(window).width()  - width)  / 2,
        top    = ($(window).height() - height) / 2,
        url    = 'https://www.linkedin.com/cws/share?url=<?php echo site_url('user/profile/'.base64_encode($getalldata['user_id'])); ?>',
        opts   = 'status=1' +
                 ',width='  + width  +
                 ',height=' + height +
                 ',top='    + top    +
                 ',left='   + left;
    
    window.open(url, 'Linkedin', opts);
 
    return false;
}
   
</script>


<link href="<?php echo base_url().getThemeName(); ?>/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<script src="<?php echo base_url().getThemeName(); ?>/assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>   
<script src="<?php echo base_url().getThemeName(); ?>/assets/scripts/app.js"></script>  
<script src="<?php echo base_url().getThemeName(); ?>/assets/scripts/gallery.js"></script>


<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/js/jquery_form.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.easing.1.3.js"></script>

<script>

function opengallery(id)
{
	  $.ajax({
			         type: "POST",
			         url: "<?php echo site_url('user/getAllGalAjax')?>",
			         data : {id:id},
			         beforeSend : function(){
			      $('#dvLoading').fadeIn('slow');
			   },
			   complete: function(){
			     $('#dvLoading').fadeOut('slow');
			   },
			         success: function(response) {
			           
			           			           	 //$('#myModalnew_ajax').on('show.bs.modal', function (e) {
			           	 $('#myModalnew_ajax').one('show.bs.modal', function (e) {
			           	 	$("#myModalnew_ajax").empty();
			           	 	$("#myModalnew_ajax").html(response);
			           	 	    $('.pgwSlideshow').pgwSlideshow(); 
    						 }).modal();
			           	 
			           	 
			           // alert(response);
			        }
			    });
			    
			   
	
}
 function see_gal()
  {
  	 
  	  $("#see_gal").slideDown();
  	   scrollToDiv('see_gal');
  }
  function hide_gal()
  {
  	$("#see_gal").slideUp();
  }
function show_popup()
	{
		$(".star").removeClass("on");
		$("#postcard").val(0);
		$('#dvLoading').fadeIn('slow')
		setTimeout(function () 
		{
			$('#dvLoading').fadeOut('slow')
		}, 500);
		
		if($('#sess_id').val()==1)
		{
			$('#myModal1').modal('show');
		}
		else
		{
			$('#loginmodal').modal('show');
		}
	} 
	
	function show_popup_new()
	{
		$(".star").removeClass("on");
		$("#postcard").val(0);
		$('#dvLoading').fadeIn('slow')
		setTimeout(function () 
		{
			$('#dvLoading').fadeOut('slow')
		}, 500);
		
		if($('#sess_id').val()==1)
		{
			$('#myModal_msg').modal('show');
		}
		else
		{
			$('#loginmodal').modal('show');
		}
	} 
		jQuery(document).ready(function() {    
			
		$('#form_msg').validate(
		{
		rules: {
					description_msg: {
							required: true,
					},
					
						errorClass:'error fl_right'
				},
				
		submitHandler: function(form){
		$(form_msg).ajaxSubmit({
		type: "POST",
		   		 dataType : 'json',
				 beforeSubmit: function() 
				 {
		       		$('#dvLoading').fadeIn('slow');
		    	 },
		    	
		    	uploadProgress: function ( event, position, total, percentComplete ) {	
		        },
		    
		    	success : function ( json ) 
		    	{
		    		
					if(json.status == "fail")
					{
						$("#cm-err-main1").show();
						$("#cm-err-main1").html(json.comment_error);
			    		$('#dvLoading').fadeOut('slow');
			    		scrollToDiv('cm-err-main1');
				  		// setTimeout(function () 
						// {
						      // $("#cm-err-main1").fadeOut('slow');
						// }, 3000);
					return false;
					}
			
					else
					{
						//alert("sdsa");
						$("#cm-err-main1").hide();
						$("#description_msg").val('');
						$("#cm-err-main1").html("");
						
						$(':input','#form')
					 	.not(':button, :submit, :reset, :hidden')
					 	.val('')
					 	.removeAttr('selected');
					 	$('#myModal_msg').modal('hide');
					 	$.growlUI('Your Message Send successfully .');
					 	
					}
					$('#dvLoading').fadeOut('slow');
		   		 }
		    });
		  }
		});	
			
	 $('#form').validate(
		{
		rules: {
					subject: {
							required: true,
					},
					description: {
							required: true,
					},
					
						errorClass:'error fl_right'
				},
				
		submitHandler: function(form){
		$(form).ajaxSubmit({
		type: "POST",
		   		 dataType : 'json',
				 beforeSubmit: function() 
				 {
		       		$('#dvLoading').fadeIn('slow');
		    	 },
		    	
		    	uploadProgress: function ( event, position, total, percentComplete ) {	
		        },
		    
		    	success : function ( json ) 
		    	{
		    		
					if(json.status == "fail")
					{
						$("#cm-err-main1").show();
						$("#cm-err-main1").html(json.comment_error);
			    		$('#dvLoading').fadeOut('slow');
			    		scrollToDiv('cm-err-main1');
				  		// setTimeout(function () 
						// {
						      // $("#cm-err-main1").fadeOut('slow');
						// }, 3000);
					return false;
					}
			
					else
					{
						//alert("sdsa");
						$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
						$.growlUI('Your Message Send successfully .');
						$(':input','#form')
					 	.not(':button, :submit, :reset, :hidden')
					 	.val('')
					 	.removeAttr('selected');
					 	$('#myModal1').modal('hide');
					 	
					}
					$('#dvLoading').fadeOut('slow');
		   		 }
		    });
		  }
		});
			
				$(".fancybox")
    .attr('rel', 'gallery')
    .fancybox({
        beforeShow: function () {
            if (this.title) {
                // New line
                this.title += '<ul class="social_icon pull-right"><li>Share Image: </li>';
                this.title += '<li><a href="javascript://" onclick="fbShare()" ><img src="<?php echo base_url().'default'?>/images/result_fb.png"></a></li>';
                this.title += ' <li><a onclick="twShare()" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_twitt.png"></a></li>';
                this.title += '<li><a onclick="gPlusShare1("<?php echo site_url('user/profile/'.base64_encode($getalldata['user_id'])); ?>","<?php echo $getalldata['first_name']." ".$getalldata['last_name']; ?>")" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_google.png"></a></li>';
                this.title += ' <li><a onclick="inShare()" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_linkln.png"></a></li>';
                this.title += '</ul><div class="clear"></div>';
                
            }
        },
        afterShow: function() {
            // Render tweet button
            twttr.widgets.load();
        },
        helpers : {
            title : {
                type: 'inside'
            }
        }  
    });     
			   
		   // initiate layout and plugins
		   Gallery.init();
		});
	</script>
	

<div class="modal fade" id="myModalnew_open" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Description</div>
     				</div>
     				<div class="pad20">
     						<label class="control-label" style="color: #fff;"><?php echo $getalldata['about_user']; ?></label>	
     				</div>		
     			</div>
     		</div>
     	</div>
     </div>
	
</div>   