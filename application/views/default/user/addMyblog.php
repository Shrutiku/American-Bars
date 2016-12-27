<?php
	$theme_url = $urls= base_url().getThemeName();
?>
<style type="text/css">
	#cke_83_label{display: none !important;}
</style>
<script type="text/javascript" src="<?php echo base_url()?>admin/ckeditor/ckeditor.js"></script>
<script type="text/javascript">$(document).ready(function(){
	
$('#cke_83_label').hide();		
  
 CKEDITOR.replace("blog_description", 
  {width: "500", height: "300", language: "en", stylesCombo_stylesSet: "my_styles", startupOutlineBlocks: true, entities: false, entities_latin: false, entities_greek: false, 		forcePasteAsPlainText: false, 
  filebrowserImageUploadUrl : "<?php echo base_url()."myblog/editorimage" ?>", 
  filebrowserImageBrowseUrl : "<?php echo base_url()."myblog/editorimage1" ?>", 
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
	$("#frm_blog_add").validate({
		rules: {
			
			blog_title: {
				required: true,
			},
			blog_description: {
				required: true,
			},
			status: {
				required: true,
				
			},
		  	errorClass:'error fl_right'
			
		}
	});
	
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
  		<h1 class="maintitle">Add Blog</h1>
  		<!-- <div class="form-control-group">
  			<div class="fl_left">
	  			<label class="fl_left search_label mart7 marr10">Search By :</label>
	  			<select class="select wrap small br_silver fl_left marr10">
	  				<option>-- Select --</option>
	  			</select>
	  			<input type="text" name="textbox1" class="input wrap small br_silver fl_left marr10" placeholder="Keyword"/>
	  			<button type="submit" class="button fl_left">Search</button>
	  			<div class="clear"></divblog_description>
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
			$attributes = array('id'=>'frm_blog_add','name'=>'frm_blog_add','class'=>'form_horizontal');
			echo form_open_multipart('myblog/add_myblog',$attributes); 
	?>
  	<div class="row">
  		<div class="left_block">
  			<div class="form-control-group">
  				<label class="comment_form_label search_label mart7 marr10">Title :</label>
	  			<div class="form-control">
	  			<input type="text" name="blog_title" id="blog_title" value="<?php if(isset($blog_title)) {  echo $blog_title; }  ?>" class="input wrap large br_silver"/>
	  			</div>
	  			<div class="clear"></div>
  			</div>
  			<div class="form-control-group">
  				<label class="comment_form_label search_label mart20 marr10 ">Description :</label>
	  			<div class="form-control">
	  			<textarea name="blog_description" id="blog_description" class="textarea wrap large br_silver" rows="8"> <?php if(isset($blog_description)) {  echo $blog_description; }  ?> </textarea>
	  			</div>
	  			<div class="clear"></div>
  			</div>
  			
  			<div class="form-control-group">
  				<label class="comment_form_label search_label mart7 marr10">Status :</label>
  				<div class="form-control">
	  			<select name="status" id="status" class="select wrap large br_silver">
	  				<option value="">-- Select --</option>
	  				<option value="active"<?php echo ($status=='active')?'selected="selected"':''; ?>>Active</option>
	  				<option value="inactive"<?php echo ($status=='inactive')?'selected="selected"':''; ?>>Inactive</option>
	  			</select>
	  			</div>
	  			<div class="clear"></div>
  			</div>
  			
  			<input type="hidden" name="blog_id" id="blog_id" value="<?php echo $blog_id; ?>" />
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
