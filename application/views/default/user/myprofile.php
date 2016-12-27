<?php
  $theme_url = $urls= base_url().getThemeName();
?>
<!-- content -->
<script type="text/javascript" src="<?php echo $theme_url; ?>/js/jquery_form.js"></script>
 <!-- ************************************************************************ -->
<script type="text/javascript">
   $('#imageform').ajaxForm( {
    dataType : 'json',
    beforeSubmit: function() {
        $(this).addClass('loading');
     //   $('#uploadBox').html('<div class="progbar"></div>');
         $("#uploadBox1").attr("src",'<?php echo $theme_url; ?>/images/loading_new.gif');
    },
    uploadProgress: function ( event, position, total, percentComplete ) {
    	
    	 $('#progressBar').css('width',percentComplete+'%').html('Processing...');
    	  $('#progressBar').css('width',percentComplete+'%').html(percentComplete+'%');
    	  
      //  if (percentComplete != 100) {
        //    $('#progressBar').css('width',percentComplete+'%').html('Processing...');
       // } else {
          //  $('#progressBar').css('width',percentComplete+'%').html(percentComplete+'%');
       // }
    },
    success : function ( json ) {
        
       if(json.status=="success")
       {
        $("#uploadBox1").attr("src",'<?php echo site_url("upload/user_thumb"); ?>/'+json.msg)
         $("#uploadBox2").attr("src",'<?php echo site_url("upload/user_thumb"); ?>/'+json.msg)
        $("#prev_img").val(json.msg);
        $('#uploadBox').html("");
       }
       
       else
       {
       	   $("#uploadBox1").attr("src",'<?php echo site_url("upload/user_thumb"); ?>/'+json.msg)
       	   $("#prev_img").val(json.msg);
       	   $('#uploadBox').html("");
       	   alert('<?php echo 'INVALID_IMAGE'; ?>');
       	   
       	   return false;
       }
    }
});



	
  </script>
<div class="wrapper row3 padtb20">
  <div id="container" class="clear">
  	<div class="row">
  		<h1 class="maintitle">My Profile</h1>
  	</div>
  	<div class="row">
  		<div class="left_block">
  			<div class="videodetail_block">
	  				<div class="coach_mainblock">
	  					<div class="fl_left marr10">
	  						<?php ?>
	  						<!--<img src="<?php echo $theme_url; ?>/images/profile_pic.png" class="post_img"/>-->
	  						<?php if($profile_image !="" && file_exists(base_path()."upload/user_thumb/".$profile_image)){?>
                                     		 <img width="100" height="100" id="uploadBox1" class="img-circle" src="<?php echo base_url();?>upload/user_thumb/<?php echo $profile_image; ?>" alt="" onClick="$('#photoimg').click();">
                                     	
                                     		<?php }else{?>
                                     			 <img  id="uploadBox1" width="100" height="100" class="img-circle" src="<?php echo base_url();?>upload/no-image.png" alt="" onClick="$('#photoimg').click();">
                                     		
                                     			<?php } ?>
	  					</div>
	  					<div class="coach_desc">
	  						<!-- <h2 class="coachuser">Profile Status</h2> -->
	  							<ul class="coachdetail">
		  							<li>Profile Status</li>
		  							<li><?php echo $first_name.' '.$last_name; ?></li>
		  						</ul>
		  						<a href="#" onClick="$('#photoimg').click();" class="button mart20">Change Pic</a>
	  					</div>
	  					<div class="clear"></div>
	  				</div>
	  			</div>
	  			
	  			<!-- <div class="videolist_left_block mart70">
		  			<ul class="videoside_menu">
		    			<li><a href="#" class="active">My Videos</a></li>
		    			<li><a href="#">My Contents</a></li>
		    			<li><a href="#">My Articles</a></li>
		    			<li><a href="#">My Earnings</a></li>
		    			<li><a href="#">Membership Plan</a></li>
		    		</ul>
  				</div> -->
  				<?php $this->load->view(getThemeName ().'/user/user_sidebar'); ?>
  				<div class="fl_right mart70">
  						<?php  
					if($msg != "") {
						echo '<div class="success text-center"><p>Record has been updated Successfully.</p></div>';
					}
				?>
  					<h1 class="editprofile">Edit Profile</h1>
  					<?php //echo $msg; die; ?>
  					<h2 class="profile_sub_title">Personal Information</h2>
  					<?php $attributes = array('id'=>'frm_update','name'=>'frm_update','class'=>'form_horizontal');
							echo form_open('user/myprofile',$attributes); ?>
  					<div class="form-control-group">
		  				<label class="profile_form_label search_label mart7 marr10">First Name :<span class="aestrik">*</span></label>
			  			<input type="text" name="first_name" id="first_name" value="<?php echo $first_name; ?>" class="input wrap medium br_silver fl_left"/>
			  			<div class="clear"></div>
  					</div>
  					<div class="form-control-group">
		  				<label class="profile_form_label search_label mart7 marr10">Last Name :<span class="aestrik">*</span></label>
			  			<input type="text" name="last_name" id="last_name" value="<?php echo $last_name; ?>" class="input wrap medium br_silver fl_left"/>
			  			<div class="clear"></div>
  					</div>
  					<div class="form-control-group">
		  				<label class="profile_form_label search_label mart7 marr10">Address :<span class="aestrik">*</span></label>
			  			<textarea name="address" id="address" class="textarea wrap medium br_silver" rows="8"><?php echo $address; ?></textarea>
			  			<div class="clear"></div>
  					</div>
  					<div class="form-control-group">
		  				<label class="profile_form_label search_label mart7 marr10">About User :<span class="aestrik">*</span></label>
			  			<textarea name="about_user" id="about_user" class="textarea wrap medium br_silver" rows="8"><?php echo $about_user; ?></textarea>
			  			<div class="clear"></div>
  					</div>
  					<div class="form-control-group">
		  				<label class="profile_form_label search_label mart7 marr10">Gender :<span class="aestrik">*</span></label>
			  			<select name="gender" id="gender" class="select wrap medium br_silver fl_left marr10">
	  						<option value="">-- Select --</option>
	  						
	  						<option value="male" <?php echo ($gender=='male')?'selected="selected"':''; ?>>Male</option>
	  						<option value="female" <?php echo ($gender=='female')?'selected="selected"':''; ?> >Female</option>
	  					</select>
			  			<div class="clear"></div>
  					</div>
  				
  					<div class="form-control-group">
		  				<label class="profile_form_label search_label mart7 marr10">Email :<span class="aestrik">*</span></label>
			  			<input type="text" name="email" id="email" value="<?php echo $email; ?>" class="input wrap medium br_silver fl_left"/>
			  			<div class="clear"></div>
  					</div>
  					<div class="form-control-group">
		  				<label class="profile_form_label search_label mart7 marr10">Phone No :<span class="aestrik">*</span></label>
			  			<input type="text" name="phone_no" id="phone_no" value="<?php echo $phone_no; ?>" class="input wrap medium br_silver fl_left"/>
			  			<div class="clear"></div>
  					</div>
  					
  					
  					<div class="form-control-div text-center mart20">
						<button type="submit" name="b1" class="button marr10">Update</button>
						<!--<button type="submit" name="b1" class="button">Cancel</button>-->
					</div>
  					</form>
  					
             <form id="imageform" method="post" enctype="multipart/form-data" action="<?php echo base_url("user/upload_file") ?>">	
             
             
             	<span class="hidden">
             	<input type="file" name="photoimg" id="photoimg" onchange="$(this.form).submit();"/>
             </span>		
             <?php if($profile_image !=""){?>
                  <input type="hidden" name="prev_img" id="prev_img" value="<?php echo $profile_image; ?>" />
                  <?php }else{?>
                 <input type="hidden" name="prev_img" id="prev_img" value="no-image.png" />
            <?php } ?>
             </form>
  					
  				</div>
	  			<div class="clear"></div>
	  		
	  		
	  		
	  		
  			
  		</div>
  		<div class="right_block">
  			<h2 class="smalltitle">Advertisement</h2>
  			<div class="mart7"><img src="<?php echo $theme_url; ?>/images/adv1.png"/></div>
  		</div>
  		<div class="clear"></div>
  	</div>

  </div>
</div>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.validate.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
//===== Usual validation engine=====//
	$("#frm_update").validate({
		rules: {
			
			first_name: {
				required: true,
			},
			
			last_name: {
				required: true,
				
			},
			address: {
				required: true,
			},
			about_user: {
				required: true,
			},
			gender: {
				required: true,
			},
			phone_no: {
				required: true,
			},
			email: {
				required: true,
				email: true
			},
			
				
		  	errorClass:'error fl_right'
			
		}
	});
	
	});
</script>