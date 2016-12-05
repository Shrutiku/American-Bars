<?php
	$theme_url = $urls= base_url().getThemeName();
?>
<style type="text/css">
	#cke_83_label{display: none !important;}
</style>
<script type="text/javascript" src="<?php echo base_url()?>admin/ckeditor/ckeditor.js"></script>
<script type="text/javascript">$(document).ready(function(){
	
$('#cke_83_label').hide();		
  
 CKEDITOR.replace("article_desc", 
  {width: "500", height: "300", language: "en", stylesCombo_stylesSet: "my_styles", startupOutlineBlocks: true, entities: false, entities_latin: false, entities_greek: false, 		forcePasteAsPlainText: false, 
  filebrowserImageUploadUrl : "<?php echo base_url()."myarticle/editorimage" ?>", 
  filebrowserImageBrowseUrl : "<?php echo base_url()."myarticle/editorimage1" ?>", 
 filebrowserImageWindowWidth : "80%", 
  filebrowserImageWindowHeight : "80%", 
  toolbar :[ ["Source","-","FitWindow","ShowBlocks","-","Preview"], 
  ["Undo","Redo","-","Find","Replace","-","SelectAll","RemoveFormat"], 
 ["Cut","Copy","Paste","PasteText","PasteWord","-","Print","SpellCheck"], 
  ["Form","Checkbox","Radio","TextField","Textarea","Select",
  "Button","ImageButton","HiddenField"], ["About"], "/", ["Bold","Italic","Underline"], ["OrderedList","UnorderedList","-","Blockquote","CreateDiv"], ["Image","Flash","Table"],   ["","Unlink","Anchor"], 
  ["Rule","SpecialChar"], ["Styles"] ] ,
  
 removeDialogTabs: 'link:target;link:upload;link:advanced;image:Link;image:advanced',

  
  });
	$("#usualValidate").validate();

});</script>

<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/validate/jquery.validate.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/validate/additional-methods.js"></script>-->

<script type="text/javascript">
	$(document).ready(function(){
//===== Usual validation engine=====//
 var vid = $("#video_id").val();
 //alert(vid);
	$("#frm_article_add").validate({

		rules: {
			article_title: {
				required: true,
			},
			article_category_id:{
				required: true,
				number:true,
			},
			article_type: {
				required: true,
			},
			/*article_image: {
				required: true,
				 accept :"png|jpeg|jpg",
			},*/
			article_status: {
				required: true,
			},
			/* membership_paln_id: {
				required: true,
			},*/
			article_desc: {
				required: true,
				
			},		
	
			
			
		  	errorClass:'error fl_right'
			
		}
	});
	
	
	
	//////////// second for edit////////////////
		$("#frm_video_edit").validate({

		rules: {
			
			video_tfrm_article_additle: {
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

</script>
<div class="wrapper row3 padtb20">
  <div id="container" class="clear">
  	<div class="row">
  		<h1 class="maintitle">Add Article</h1>
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
			$attributes = array('id'=>'frm_article_add','name'=>'frm_article_add','class'=>'form_horizontal');
			echo form_open_multipart('myarticle/add_myarticle',$attributes); 
	?>
  	<div class="row">
  		<div class="left_block">
  			<div class="form-control-group">
  				<label class="comment_form_label search_label mart7 marr10">Title :</label>
	  			<div class="form-control">
	  			<input type="text" name="article_title" id="article_title" value="<?php if(isset($article_title)) {  echo $article_title; }  ?>" class="input wrap large br_silver"/>
	  			</div>
	  			<div class="clear"></div>
  			</div>
  			<div class="form-control-group">
  				<label class="comment_form_label search_label mart7 marr10">Category :</label>
	  			<div class="form-control">
	  			<?php //echo $article_category_id ?>
	  			<select id="article_category_id" name="article_category_id" class="select wrap large br_silver">
	  				<option value="">-- Select --</option>
	  				<?php if($category){
						foreach ($category as $cat) {
						?>
						<option value="<?php echo $cat->category_id; ?>"  <?php echo ($article_category_id==$cat->category_id)?'selected="selected"':''; ?> ><?php echo $cat->category_name; ?></option>
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
	  			<textarea name="article_desc" id="article_desc" class="textarea wrap large br_silver" rows="8"> <?php if(isset($article_desc)) {  echo $article_desc; }  ?> </textarea>
	  			</div>
	  			<div class="clear"></div>
  			</div>
  			<div class="form-control-group">
  				<label class="comment_form_label search_label marr10">Ariticle Image :</label>
  				<div class="fl_left">
	  				<input type="text" id="file_name" value="" class="wrap medium br_silver wid265"/>
	  				<label for="article_image" class="error" style="display: none;"></label>
  				</div>
  				<div class="browse1">
  					<input type="file" name="article_image" value="<?php if(isset($article_image)) { echo $article_image; } ?>" onchange="upload_image_name(this.value)" id="article_image" value="" class="browse"/>
  					<input type="hidden" name="pre_article_image" id="pre_article_image" value="<?php if(isset($article_image)) { echo $article_image; } ?>" />
  				</div>
	  			<div class="fl_left mart5">
	  				<?php if(isset($article_image)){
	  					if($article_image !="" && file_exists(base_path()."upload/article_image/".$article_image)){?>
	  					<img src="<?php echo base_url();?>upload/article_image/<?php echo $article_image; ?>" hight="80" width="80" class="upload_img fl_left"/>
	  				<?php }
					else {
						?> <img src="<?php echo base_url();?>upload/no-image.png" hight="80" width="80" class="upload_img fl_left"/>
					<?php }	
	  				} 
	  				 ?>	
	  				
	  			</div>
	  			<div class="clear"></div>
  			</div>
  			<div class="form-control-group">
  				<label class="comment_form_label search_label mart7 marr10">Type :</label>
	  			<div class="form-control">
	  			<select name="article_type" id="article_type" class="select wrap large br_silver">
	  				<option value="">-- Select --</option>
	  				<option value="free"<?php echo ($article_type=='free')?'selected="selected"':''; ?>>Free</option>
	  				<option value="paid"<?php echo ($article_type=='paid')?'selected="selected"':''; ?>>Paid</option>
	  			</select>
	  			</div>
	  			<div class="clear"></div>
  			</div>
  			<div class="form-control-group">
  				<label class="comment_form_label search_label mart7 marr10">Price :</label>
	  			<div class="form-control">
	  			<input type="text" name="article_price" id="article_price" value="<?php if(isset($article_price)) {  echo $article_price; }  ?>" class="input wrap large br_silver"/>
	  			</div>
	  			<div class="clear"></div>
  			</div>
  			
  			<div class="form-control-group">
  				<label class="comment_form_label search_label mart7 marr10">Membership Plan :</label>
	  			<div class="form-control">
	  			<select name="membership_paln_id" id="membership_paln_id" class="select wrap large br_silver">
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
  				<label class="comment_form_label search_label mart7 marr10">Status :</label>
  				<div class="form-control">
	  			<select name="article_status" id="article_status" class="select wrap large br_silver">
	  				<option value="">-- Select --</option>
	  				<option value="active"<?php echo ($article_status=='active')?'selected="selected"':''; ?>>Active</option>
	  				<option value="inactive"<?php echo ($article_status=='inactive')?'selected="selected"':''; ?>>Inactive</option>
	  			</select>
	  			</div>
	  			<div class="clear"></div>
  			</div>
  			<input type="hidden" name="article_id" id="article_id" value="<?php echo $article_id; ?>" />
  			<div class="form-control-div text-center mart20">
				<button type="submit" name="b1" class="button marr10">Save</button>
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
