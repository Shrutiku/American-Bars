


<link href="<?php echo base_url().getThemeName(); ?>/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<script src="<?php echo base_url().getThemeName(); ?>/assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>   
<script src="<?php echo base_url().getThemeName(); ?>/assets/scripts/app.js"></script>  
<script src="<?php echo base_url().getThemeName(); ?>/assets/scripts/gallery.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.bxslider.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/css/jquery.bxslider.css" />


<script>
	
		jQuery(document).ready(function() {  
			
			$(".fancybox")
    .attr('rel', 'gallery')
    .fancybox({
        beforeShow: function () {
             {
                // New line
                this.title += '<ul class="social_icon pull-right"><li>Share Image: </li>';
                this.title += '<li><a href="javascript://" onclick="fbShare()" ><img src="<?php echo base_url().'default'?>/images/gallery-social/result_fb.png"></a></li>';
                this.title += ' <li><a onclick="twShare()" href="javascript://"><img src="<?php echo base_url().'default'?>/images/gallery-social/result_twitt.png"></a></li>';
                this.title += '<li><a onclick="gPlusShare1("<?php echo site_url('user/profile/'.base64_encode($getalldata->user_id)); ?>","<?php echo $getalldata->first_name." ".$getalldata->last_name; ?>")" href="javascript://"><img src="<?php echo base_url().'default'?>/images/gallery-social/result_google.png"></a></li>';
                this.title += ' <li><a onclick="inShare()" href="javascript://"><img src="<?php echo base_url().'default'?>/images/gallery-social/result_linkln.png"></a></li>';
                this.title += '</ul><div class="clear"></div>';
                
            }
        },
        afterShow: function() {
            // Render tweet button
           // twttr.widgets.load();
            //fbshare_popup();
        },
        helpers : {
            title : {
                type: 'inside'
            }
        }  
    });     
			
		
				$('.bxslider').bxSlider({

				    auto: false,
                    autoControls: true,
  minSlides: 3,
  maxSlides: 3,
  slideWidth: 300,
  slideMargin: 10
});
		   // initiate layout and plugins
		   Gallery.init();
		});
	</script>
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
		width: 40%;
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
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/image_script.js"></script>
<script type="text/javascript" src="<?php echo  base_url().getThemeName(); ?>/js/jquery_form.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/ckeditor/ckeditor.js"></script>
<script>
	
	$(document).ready(function() {
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
 $('#form').on('submit', function() {
        	
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances['about_user'].updateElement();
                }
            });

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
<div class="wrapper row6 user-page">
     	<div class="container">
     		<?php  if($this->session->userdata('user_type')!='bar_owner'){ ?><div class="wrapper row4">
   			<div class="carousel slide" id="slider-fixed-banner">
        	<div class="carousel-inner">
          	<div class="active item">
          	  	
          	  									<?php
          	  									
          	  									$userinfo_new = get_user_info(get_authenticateUserID());
          	  									
		          		if($userinfo_new->user_banner!="" && file_exists(base_path().'upload/banner_drag/'.@$userinfo_new->user_banner))
					{?>
		            	<img src="<?php echo base_url()?>/upload/banner_drag/<?php echo $userinfo_new->user_banner; ?>" alt="American Dive Bars"/>
		            	<?php }  else if($userinfo_new->user_banner!="" && file_exists(base_path().'upload/banner_drag_without/'.@$userinfo_new->user_banner))
					{?>
						<img src="<?php echo base_url()?>/upload/banner_without_drag/<?php echo $userinfo_new->user_banner; ?>" alt="American Dive Bars"/>
		            		
		            		<?php } else {?>
		            		<img src="<?php echo base_url().'default'?>/images/smallbanner1.png" alt="American Dive Bars"/>	
		            			<?php } ?>
         </div>
        </div>
   	</div>
	</div>
  <!-- </div> -->
  <?php }  ?>
  
  </div>
  
  
<div class="modal fade" id="userguide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<?php echo $this->load->view(getThemeName().'/home/userguide_u');?>
</div>	

  <div class="user-top-border">
  		<div class="container">
     		<div class="bg_brown">
     			<?php echo $this->load->view($theme.'/home/dashboard_menu'); ?>
     			
     			<div class="dashboard_detail">
     				<div class="result_search">
			     		<div class='pull-left'><div class="result_search_text">Enthusiast Dashboard</div></div>
			     		<div class='pull-right'><div class="result_search_text"><a href="#userguide" data-toggle="modal" href="javascript://"  class="review mar_r15" >User Guide</a></div></div>
			     
			       <div class="clear"></div>
		     		</div>
		     		<div class="dashboard_subblock">
		     			
		     			<div class="result_search margin-top-20">
		     				<h1 class="dashboard_smalltitle pull-left">Enthusiast Information</h1>
		     				<a href="<?php echo site_url('user/profile/'.base64_encode(get_authenticateUserID()));?>" class="review pull-right" target="_blank">Preview My Profile</a>
		     				 <a href="javascript://" class="review pull-right mar_r15"  onclick="editbarinfo()">Edit Enthusiast Information</a>
		     				<div class="clearfix"></div>
		     			</div>
		     			<div>
		     			<div id="list_hide">	
		     				<div class="logo_block">
		     					<div id='preview'>

		     					<?php
		          		if($getalldata->profile_image!="" && file_exists(base_path().'upload/user_thumb/'.@$getalldata->profile_image))
					{?>
		            	<img class="img-responsive" src="<?php echo base_url()?>/upload/user_thumb/<?php echo $getalldata->profile_image; ?>" alt="American Dive Bars"/>
		            	<?php }  else {?>
		            		<img class="img-responsive" src="<?php echo base_url()?>/upload/no-image.png" alt="American Dive Bars"/>	
		            			<?php } ?>
		     					</div><div class="clear"></div>
		     							     					
		     						
		     					<form id="imageform" method="post" enctype="multipart/form-data" action='<?php echo site_url('user/changeuserlogo')?>'>
		     					<div id='imageloadstatus' style='display:none'><img src="<?php echo base_url().getThemeName(); ?>/images/ajax-loader-new.gif" alt="Uploading...."/></div>
								<div id='imageloadbutton'>
								<!-- <input type="file" name="photoimg" id="photoimg" /> -->
								<div class="browse2" id="upload">
									<input type="file" id="photoimg" accept="image/*" class="browse" value="Upload Image" name="photoimg">
								</div>
								
								<input type="hidden" id="prev_bar_logo" name="prev_bar_logo" value="<?php echo @$getalldata->profile_image; ?>" />
								</div>	
		     					</form><div class="clear"></div>
		     					<a class="btn btn-lg btn-primary-2 mar_top15" href="<?php echo site_url('home/changepassword')?>">Change Password</a>
		     					<!-- <a href="#" class="change_text"><i class="strip edit"></i> Change</a> -->
		     				</div>
		     					
		     				
		     				<div class="map_mainblock">
		     					<div><!--class="dashboard_beer_detail" -->
		     						<ul class="dashboard_list">
		     							<li><span class="marr_10">First Name : </span> <?php echo @$getalldata->first_name; ?></li>
		     							<li><span class="marr_10">Last Name : </span> <?php echo @$getalldata->last_name; ?></li>
		     							<li><span class="marr_10">Email : </span> <?php echo @$getalldata->email; ?></li>
		     							<li><span class="marr_10">Gender : </span> <span style="text-transform: capitalize;"><?php echo @$getalldata->gender; ?></span></li>
		     							<li><span class="marr_10">Address : </span> <?php echo $getalldata->address.'<br><span class="pull-left" style="margin-left:69px;">'.$getalldata->user_city. '  '.$getalldata->user_state.'  '.$getalldata->user_zip; ?></span><div class="clearfix"></div></li>
		     							<li><span class="marr_10">Mobile Number : </span> <?php echo @$getalldata->mobile_no; ?></li>
		     							<li><span class="marr_10">About User : </span> 
		     									<?php if(strip_tags(strlen($getalldata->about_user)>350)){ echo substr(strip_tags($getalldata->about_user),0,350).'...<a class="morelink more pull-right" href="javascript://"><i class="strip arrow_down"></i>Show more</a>' ; } else { echo strip_tags($getalldata->about_user); } ?>
		     								</li>		
		     						</ul>
		     					</div>
		     					
		     					<div class="clearfix"></div>
		     				</div></div><div class="clearfix"></div>
		     				
		     				
		     				</div>
		     				<div class="clearfix"></div>
		     				
		     				<div id="list_show" style="display: none;" >	
					<div class="text-right" >
     							<a onclick="goto_main()" href="javascript://"  class="btn btn-lg btn-primary marr_10">Back</a>
     						</div>
					<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
					<form name="add_event" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('user/editinfo'); ?>">
		     			<div class=" pad_t15b20">
	                       	 <input type="hidden" name="user_id" id="user_id" value="<?php echo get_authenticateUserID(); ?>" />
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">First Name : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" name="first_name" id="first_name" value="<?php echo @$getalldata->first_name; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Last Name : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="last_name" name="last_name" value="<?php echo @$getalldata->last_name; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Username : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="nick_name" name="nick_name" value="<?php echo @$getalldata->nick_name; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Gender : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7 text-left padt5">
	                           		<label for="radio-01" class="radio-checkbox label_radio marr_10 r_on"><input type="radio" value="male" <?php if($getalldata->gender=='male'){ echo "checked"; }?> name="gender" id="genderm" > Male</label>
	                           		<label for="radio-02" class="radio-checkbox label_radio"><input type="radio" value="female"  <?php if($getalldata->gender=='female'){ echo "checked"; }?> name="gender" id="genderf" > Female</label>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Email : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="email" name="email" value="<?php echo @$getalldata->email; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">About User : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<textarea rows="5" placeholder="Description" name="about_user" id="about_user" class="ckeditor form-control form-pad"><?php echo @$getalldata->about_user; ?></textarea>
	                           		<span for="about_user" style="display: none" class="help-inline">This field is required.</span>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Address : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<textarea rows="5" placeholder="Address" name="address" id="address" class="form-control form-pad"><?php echo @$getalldata->address; ?></textarea>
	                           		<div>
	        					<label>(Please fill in your address information only if your want to receive American Dive Bars Newsletters and promotional items in the mail)</label>
	        				</div>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">City : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="user_city" name="user_city" value="<?php echo @$getalldata->user_city; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">State : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="user_state" name="user_state" value="<?php echo @$getalldata->user_state; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Zipcode : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="user_zip" name="user_zip" value="<?php echo @$getalldata->user_zip; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Mobile Number : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="mobile_no1" name="mobile_no" value="<?php echo @$getalldata->mobile_no; ?>">
	                           		
	                           		<label>( Please provide your mobile phone information only if you want to receive promotional information via text from American Dive Bars and bars listed in your favorite section.)</label>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Facebook Link : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="fb_link" name="fb_link" value="<?php echo @$getalldata->fb_link; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Google Plus Link : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="gplus_link" name="gplus_link" value="<?php echo @$getalldata->gplus_link; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Twitter Link : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="twitter_link" name="twitter_link" value="<?php echo @$getalldata->twitter_link; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Linked In Link : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="linkedin_link" name="linkedin_link" value="<?php echo @$getalldata->linkedin_link; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Pinterest Link : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="pinterest_link" name="pinterest_link" value="<?php echo @$getalldata->pinterest_link; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Instagram Link : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="instagram_link" name="instagram_link" value="<?php echo @$getalldata->instagram_link; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	<div class="padtb8">
	                       		<div class="col-sm-3 text-right"></div>
	                       		<div class="col-sm-7 mart10 text-left">
	                       			<button type="submit" class="btn btn-lg btn-primary marr_10" >Save</button> 
	                       			<a  class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('home/dashboard');?>" >Cancel</a>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="clearfix"></div>
     		</div>
     			</form>
		     			
		     		</div>
		     		<a href="<?php echo site_url('user/album')?>"  class="btn btn-lg btn-primary  pull-right">Create New Album</a><div class="clear"></div>
		     		<?php if($albumgallery){
		     			foreach($albumgallery as $album){	?>	
		     		 <div class="result_search margin-top-20">
		     				<h1 class="dashboard_smalltitle pull-left">ALBUM : <?php echo $album->title;?></h1>
		     				
		     					<ul class="social_icon pull-right">
     						<li>Share : </li>
						   <li><a href="javascript://" onclick="fbShare()" ><img src="<?php echo base_url().'default'?>/images/result_fb.png"></a></li>
						    <li><a onclick="twShare()" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_twitt.png"></a></li>
						    <li><a onclick="gPlusShare1('<?php echo site_url('user/profile/'.base64_encode($getalldata->user_id)); ?>','<?php echo $getalldata->first_name." ".$getalldata->last_name; ?>')" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_google.png"></a></li>
						    <li><a onclick="inShare()" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_linkln.png"></a></li>
						    
						    <div class="clearfix"></div>
		    		 	</ul>
     						
     					
		     				 <!-- <a href="javascript://"  onclick="editbarinfo()"><i class="strip edit pull-right"></i></a> -->
		     				<div class="clearfix"></div>
		     		</div>		
		     		<ul class="bxslider">
		     		<?php $getimages = getalbumimage($album->bar_gallery_id);
						if($getimages){
						foreach($getimages as $rows){
						?>	
		     			<li>
		     					<a title="<?php echo $rows->image_title;?>" class="fancybox" href="<?php echo base_url().'upload/bar_gallery_orig/'.$rows->bar_image_name;?>"><img src="<?php echo base_url().'upload/bar_gallery_thumb_big/'.$rows->bar_image_name;?>" /></a>
                       </li>
					  	<?php } }  ?>
					  </ul>	<div class="clearfix"></div>
					<?php } } ?>
     			</div>
     			<div class="clearfix"></div>
     		</div>
   				<div class="clearfix"></div>
   		</div>
   		</div>
   	</div>
 
   	<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js" ></script>
   	<script type="text/javascript">
 
  function editbarinfo()
  {
  		$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
 		  $("#list_hide").slideUp();
	    	$("#list_hide_m").slideUp();
	    	$("#hd_del").slideUp();
	    	$("#hs_del").slideDown();
	    	
	    	$('#list_show').slideDown();
 }
 $(document).ready(function() { 
		   $("#mobile_no1").inputmask("(999) 999-9999");
	});
 
   $(document).ready(function(){
        $('#form').validate(
		{
			ignore:false,
		rules: {
					
					
					first_name: {
						required: true,
					},
					nick_name: {
						required: true,
					},
					// address: {
						// required: true,
					// },
					
					last_name: {
						required: true,
					},
					email: { required: true },
					fb_link: { url: true },
					gplus_link: { url: true },
					twitter_link: { url: true },
					linkedin_link: { url: true },
					pinterest_link: { url: true },
					instagram_link: { url: true },
					// user_zip: { phoneUS: true },
					// mobile_no: { required: true },
				//	about_user: { required: true },
					
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
						scrollToDiv('cm-err-main1');
						$("#cm-err-main1").show();
						$("#cm-err-main1").html(json.comment_error);
						 scrollToDivmore('dashboard_subblock');
						$('#dvLoading').fadeOut('slow');
			    		//$('#dvLoading').fadeOut('slow')
				  		
					return false;
					}
			
					else
					{
						
						
						$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
						
						$.growlUI('Your profile updated successfully .');
						
					 	// $("#list_hide").slideDown();
					 	 $("#list_hide_m").slideDown();
					     $("#hd_del").slideDown();
					     $("#hs_del").slideUp();
					     $('#list_show').slideUp();
					     $("#at_ajax").remove();
					     getData();
					     $("#cm-err-main1").fadeOut('slow');
					     scrollToDivmore('dashboard_subblock');
					}
					$('#dvLoading').fadeOut('slow');
		   		 }
		    });
		  }
		})
		
		
    });
  
    
    function goto_main()
    {
    		$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
    	$("#event_id").val('');
    	// $(':input','#form')
					 	// .not(':button, :submit, :reset, :hidden')
					 	// .val('')
					 	// //.removeAttr('checked')
					 	// .removeAttr('selected');
		$("#img_here").removeAttr('src');			 	
    	$("#list_hide").slideDown();
    	$("#list_hide_m").slideDown();
    	$("#hd_del").slideDown();
    	$("#hs_del").slideUp();
    	$('#list_show').slideUp();
    }
    
     function getData()
    {
    	 $.ajax({
	       type: "POST",
		   url: "<?php echo site_url('user/getuserdata')?>",
		      beforeSend : function() {
		   		$('#dvLoading').fadeIn('slow');
		   },
		    complete : function() {
		   		$('#dvLoading').fadeOut('slow');
		   },	
		   success: function(response) {
		   	//alert('response');
		   	//alert(response);
		   	$('#list_hide').empty();
		   	 $("#list_hide").slideDown();
		     $('#list_hide').html(response);
		    
		  }
	   });
    }
</script>


	

	<script type="text/javascript">
  var image =    $(".fancybox-image").attr('src');
function fbShare(){
	    window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('<?php echo site_url('user/profile/'.base64_encode($getalldata->user_id)); ?>'),'facebook-share-dialog','width=626,height=436');
        return false;
}

function fbshare_popup()
{
	  var image = $(".fancybox-image").attr('src');
	   alert(image);
	    window.open('http://www.facebook.com/sharer.php?s=100&amp;p[url]=<?php echo site_url('user/profile/'.base64_encode($getalldata->user_id)); ?>&amp;&p[images][1]='+image, 'facebook-share-dialog', 'toolbar=0,status=0,width=548,height=325');
        return false;
}
function twShare()
{
	var width  = 575,
        height = 400,
        left   = ($(window).width()  - width)  / 2,
        top    = ($(window).height() - height) / 2,
        url    = 'http://twitter.com/share?url=<?php echo site_url('user/profile/'.base64_encode($getalldata->user_id)); ?>',
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
        url    = 'https://www.linkedin.com/cws/share?url=<?php echo site_url('user/profile/'.base64_encode($getalldata->user_id)); ?>',
        opts   = 'status=1' +
                 ',width='  + width  +
                 ',height=' + height +
                 ',top='    + top    +
                 ',left='   + left;
    
    window.open(url, 'Linkedin', opts);
 
    return false;
}
   
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
     						<label class="control-label" style="color: #fff;"><?php echo $getalldata->about_user; ?></label>	
     				</div>		
     			</div>
     		</div>
     	</div>
     </div>
	
</div>     

