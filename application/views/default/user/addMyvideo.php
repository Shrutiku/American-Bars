<?php
	$theme_url = $urls= base_url().getThemeName();
?>
<!--<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.validate.js"></script>-->
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/validate/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/validate/additional-methods.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
//===== Usual validation engine=====//
 var vid = $("#video_id").val();
 //alert(vid);
	$("#frm_video_add").validate({

		rules: {
			
			video_title: {
				required: true,
			},
			video_category_id: {
				required: true,
			},
			/*membership_paln_id: {
				required: true,
				
			},*/
			video_desc: {
				required: true,
			},
			video_price:{
				required: true,
				number:true,
			},
			video_type: {
				required: true,
			},
			video_status: {
				required: true,
			},
			
			video_image: {
				required: true,
				 accept :"png|jpeg|jpg",
			},
			video_file_name: {
				required: true,
				 accept :"mp4|mpg|wmv|avi|3gp",
			},
			video_preview_names: {
				required: true,
				 accept :"mp4|mpg|wmv|avi|3gp",
			},
			
	
			
			
		  	errorClass:'error fl_right'
			
		}
	});
	
	
	
	//////////// second for edit////////////////
		$("#frm_video_edit").validate({

		rules: {
			
			video_title: {
				required: true,
			},
			video_category_id: {
				required: true,
			},
			/*membership_paln_id: {
				required: true,
				
			},*/
			video_desc: {
				required: true,
			},
			video_price:{
				required: true,
				number:true,
			},
			video_type: {
				required: true,
			},
			video_status: {
				required: true,
			},
		
		  	errorClass:'error fl_right'
			
		}
	});
	
	////second for edot////////////////////////////
	
	});
</script>
<script type="text/javascript">
	function upload_image_name(value){
		$("#file_name").val(value)
	}
	function upload_video_name(value){
		$("#video_file_names").val(value)
	}
	function upload_video_preview_name(value){
		$("#video_preview_names").val(value)
	}
	
	function checkfiles()
{
	var fup = document.getElementById('video_image');
	var video = document.getElementById('video_file_names');
	
	var fileName = fup.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	if(ext != '')
	{
		//alert(ext);
		//if(ext != "gif" || ext != "jpeg" || ext != "png" || ext != "jpg" || ext != "JPEG" || ext != "JPG" || ext != "GIF" || ext != "bmp" || ext != "png" || ext != "PNG")
		if(ext == 'jpeg' || ext == "png" || ext == "jpg")
		{
			jQuery(".uValidate").validationEngine();
			
		}else{
			alert('Please select valid image format.');
			return false;
			
		}
		
	}
	else{
		//alert('Please select image.');
		$("#file_name").val('Please select image.')
			return false;
	}
	
	
	
}
function check_video_files()
{
	//alert("hello");
	var video = document.getElementById('video_file_names');
	
	//alert(video);
	
	var fileName = video.value;
	var ext_video = fileName.substring(fileName.lastIndexOf('.') + 1);
	if(ext_video != '')
	{
		//avi|wmv|mpeg|mpg|mp4
		if(ext_video == 'mp4' || ext_video == "avi" || ext_video == "wmv" || ext_video == "mpg")
		{
			jQuery(".uValidate").validationEngine();
			
		}else{
			//alert('Please select valid video format.');
			$("#video_file_names").val('Please select valid video format.')
			return false;
			
		}
		
	}
	else{
		$("#video_file_names").val('Please select video.')
			return false;
	}
	
	
	var video_preview =document.getElementById('video_preview_names');
	alert("video preview");
	var file_Name = video_preview.value;
	var ext_video_preview = file_Name.substring(file_Name.lastIndexOf('.') + 1);
	
	if(ext_video_preview != '')
	{
		alert("good");
		//avi|wmv|mpeg|mpg|mp4
		if(ext_video_preview == 'mp4' || ext_video_preview == "avi" || ext_video_preview == "wmv" || ext_video_preview == "mpg")
		{
			jQuery(".uValidate").validationEngine();
			
		}else{
			alert('Please select valid video format.');
			return false;
			
		}
		
	}
	else{
		alert("no");
		$("#video_file_names").val('Please select video.')
			return false;
	}
	
	
}


</script>
<div class="wrapper row3 padtb20">
  <div id="container" class="clear">
  	<div class="row">
  		<h1 class="maintitle">Add Video</h1>
  		<!-- <div class="form-control-group">
  			<div class="fl_left">
	  			<label class="fl_left search_label mart7 marr10">Search By :</label>
	  			<select class="select wrap small br_silver fl_left marr10">
	  				<option>-- Select --</option>
	  			</select>
	  			<input type="text" name="textbox1" class="input wrap small br_silver fl_left marr10" placeholder="Keyword"/>
	  			<button type="submit" class="button fl_left">Search</button>
	  			<div class="clear"></div>
  			</div>
  			<div class="fl_right">
	  			<label class="fl_left search_label mart7 marr10">Sort By :</label>
	  			<select class="select wrap small br_silver fl_left marr10">
	  				<option>-- Select --</option>
	  			</select>
	  			<div class="clear"></div>
  			</div>
  			<div class="clear"></div>
  		</div> -->
  	</div>
  		<?php 
  		if($video_id > 0 && is_numeric($video_id))
		{
			$attributes = array('id'=>'frm_video_edit','name'=>'frm_video_edit','class'=>'form_horizontal');
		}
		else
		{
			$attributes = array('id'=>'frm_video_add','name'=>'frm_video_add','class'=>'form_horizontal');
		}
  		
  		
							echo form_open_multipart('myvideo/add_myvideo',$attributes); ?>
  	<div class="row">
  		<div class="left_block">
  			<div check_video_filesclass="form-control-grouvideo_idp">
  				<label class="comment_form_label search_label mart7 marr10">Title :</label>
  				<div class="form-control">
	  			<input type="text" name="video_title" id="video_title" value="<?php if(isset($video_title)){ echo $video_title; } ?>" class="input wrap large br_silver"/>
	  			</div>
	  			<div class="clear"></div>
  			</div>
  			<div check_video_filesclass="form-control-group">
  				<label class="comment_form_label search_label mart7 marr10">Video Price :</label>
  				<div class="form-control">
	  			<input type="text" name="video_price" id="video_price" value="<?php if(isset($video_price)){ echo $video_price; } ?>" class="input wrap large br_silver"/>
	  			</div>
	  			<div class="clear"></div>
  			</div>
  			<div class="form-control-group">
  				<label class="comment_form_label search_label mart7 marr10">Category :</label>
	  			<div class="form-control">
	  			<select name="video_category_id" id="video_category_id" class="select wrap large br_silver">
	  				<option value="">-- Select --</option>
	  				<?php if($category){
						foreach ($category as $cat) {
						?>
						<option value="<?php echo $cat->category_id; ?>"  <?php echo ($video_category_id==$cat->category_id)?'selected="selected"':''; ?> ><?php echo $cat->category_name; ?></option>
						<?php		
						}
						} ?>
	  			</select>
	  			</div>
	  			<div class="clear"></div>
  			</div>
  			<div class="form-control-group">
  				<label class="comment_form_label search_label mart7 marr10">Membership Plan :</label>
	  			<div class="form-control">
	  			<select id="membership_paln_id" name="membership_paln_id" class="select wrap large br_silver">
	  				<option value="">-- Select --</option>
	  				<?php if($membership){
						foreach ($membership as $mam) {
						?>
						<option value="<?php echo $mam->membership_plan_id; ?>" <?php echo ($membership_paln_id==$mam->membership_plan_id)?'selected="selected"':''; ?>  ><?php echo $mam->plan_title; ?></option>
						<?php		
						}
						} ?>
	  			</select>
	  			</div>
	  			<div class="clear"></div>
  			</div>
  			<div class="form-control-group">
  				<label class="comment_form_label search_label mart20 marr10 ">Description :</label>
	  			<div class="form-control">
	  			<textarea name="video_desc" id="video_desc" class="textarea wrap large br_silver" rows="8"><?php if(isset($video_desc)) { echo  $video_desc; } ?></textarea>
	  			</div>
	  			<div class="clear"></div>
  			</div>
  			<!-- <div class="form-control-group">
  				<label class="comment_form_label search_label mart20 marr10">Upload Video :</label>
  				<div class="form-control">
	  			<input type="file" name="video_file_name" id="video_file_name" class="input wrap medium br_silver mart15"/>
	  			<button type="submit" name="btnupload" class="button fl_left mart15 marr10">Upload</button>
	  			<!--<img src="<?php echo $theme_url; ?>/images/up_img1.png" class="upload_img fl_left"/>
	  			</div>
	  			<div class="clear"></div>
  			</div> -->
  			
			<div class="form-control-group">
  				<label class="comment_form_label search_label marr10">Video Image :</label>
  				<div class="fl_left">
	  				<input type="text" id="file_name" value="" class="wrap medium br_silver wid265"/>
	  				<label for="video_image" class="error" style="display: none;"></label>
  				</div>
  				<div class="browse1">
  					<input type="file" name="video_image" onchange="upload_image_name(this.value)" id="video_image" value="" class="browse"/>
  					<input type="hidden" name="pre_video_image" id="pre_video_image" value="<?php if(isset($video_image)) { echo $video_image; } ?>" />
  				</div>
	  			<div class="fl_left mart5">
	  				<?php if(isset($video_image)){
	  					if($video_image !="" && file_exists(base_path()."upload/video_image/".$video_image)){?>
	  					<img src="<?php echo base_url();?>upload/video_image/<?php echo $video_image; ?>" hight="80" width="80" class="upload_img fl_left"/>
	  				<?php }
					else {
						?> <img src="<?php echo base_url();?>upload/no-image.png" hight="80" width="80" class="upload_img fl_left"/>
					<?php }	
	  				} 
	  				 ?>	
	  				<!--<img src="images/up_img1.png" class="upload_img fl_left"/>-->
	  			</div>
	  			<div class="clear"></div>
  			</div>
			<div class="form-control-group">
  				<label class="comment_form_label search_label marr10">Video:</label>
  				<div class="fl_left">
	  				<input type="text" id="video_file_names" value="<?php if(isset($video_file_name)) { echo  $video_file_name; } ?>" class="wrap medium br_silver wid265 val_video15"/>
	  				<label for="video_file_name" class="error" style="display: none;"></label>
	  			</div>
  				<div class="browse1">
  					<input type="file" name="video_file_name" onchange="upload_video_name(this.value)" id="video_file_name" value="<?php if(isset($video_file_name)) { echo  $video_file_name; } ?>" class="browse"/>
  					<input type="hidden" name="pre_file_up_video" id="pre_file_up_video" value="<?php if(isset($video_file_name)) { echo  $video_file_name; } ?>" />
  				</div>
	  			<div class="fl_left mart5">
	  				<!--<img src="images/up_img1.png" class="upload_img fl_left"/>-->
	  			</div>
	  			<div class="clear"></div>
  			</div>
  			
  			<div class="form-control-group">
  				<label class="comment_form_label search_label marr10">Video Preview:</label>
  				<div class="fl_left">
	  				<input type="text" id="video_preview_names" value="<?php if(isset($video_preview)) { echo  $video_preview; } ?>" class="wrap medium br_silver wid265"/>
	  				<label for="video_preview_names" class="error" style="display: none;"></label>
  				</div>
  				<div class="browse1">
  					<input type="file" name="video_preview_names" onchange="upload_video_preview_name(this.value)" id="video_preview_names" value="loremipsum" class="browse"/>
  					<input type="hidden" name="pre_video_preview" id="pre_video_preview" value="<?php if(isset($video_preview)) { echo  $video_preview; } ?>" />
  				</div>
	  			<div class="fl_left mart5">
	  				<!--<img src="images/up_img1.png" class="upload_img fl_left"/>-->
	  			</div>
	  			<div class="clear"></div>
  			</div> 
			
  			<div class="form-control-group">
  				<label class="comment_form_label search_label mart7 marr10"> Video Type :</label>
	  			<div class="form-control">
	  			<select name="video_type" id="video_type" class="select wrap large br_silver">
	  				<option value="">-- Select --</option>
	  				<option value="free"<?php echo ($video_type=='free')?'selected="selected"':''; ?>>Free</option>
	  				<option value="paid"<?php echo ($video_type=='paid')?'selected="selected"':''; ?>>Paid</option>
	  			</select>
	  			</div>
	  			<div class="clear"></div>
  			</div>
  			<div class="form-control-group">
  				<label class="comment_form_label search_label mart7 marr10">Status :</label>
	  			<div class="form-control">
	  			<select name="video_status" id="video_status" class="select wrap large br_silver">
	  				<option value="">-- Select --</option>
	  				<option value="active"<?php echo ($video_status=='active')?'selected="selected"':''; ?>>Active</option>
	  				<option value="inactive"<?php echo ($video_status=='inactive')?'selected="selected"':''; ?>>Inactive</option>
	  			</select>
	  			</div>
	  			<div class="clear"></div>
  			</div>
  				<input type="hidden" name="video_id" id="video_id" value="<?php echo $video_id; ?>" />
  			<div class="form-control-div text-center mart20">
				<button type="submit" name="b1" <?php if($video_id !='' || $video_id !=0 ) { ?> onclick="return check_video_files();"  <?php } ?>  class="button marr10">Submit</button>
				<button type="submit" name="b1" class="button">Cancel</button>
			</div>

  		</div>
  		<div class="right_block">
  			<h2 class="smalltitle">Advertisement</h2>
  			<div class="mart7"><img src="<?php echo $theme_url; ?>/images/adv1.png"/></div>
  		</div>
  		<div class="clear"></div>
  	</div>
		</form>
  </div>
</div>
