<script type="text/javascript" src="<?php echo base_url()?>/ckeditor/ckeditor.js"></script>
<?php
    header('X-Frame-Options: GOFORIT'); 
?>
<script type="text/javascript">$(document).ready(function(){
	
$('#cke_83_label').hide();		
  
 CKEDITOR.replace("enthusiast_user_guide", 
  {width: "500", height: "300", language: "en", stylesCombo_stylesSet: "my_styles", startupOutlineBlocks: true, entities: false, entities_latin: false, entities_greek: false, 		forcePasteAsPlainText: false, 
  filebrowserImageUploadUrl : "<?php echo base_url()."pages/editorimage" ?>", 
  filebrowserImageBrowseUrl : "<?php echo front_base_url()."pages/editorimage1" ?>", 
 filebrowserImageWindowWidth : "80%", 
  filebrowserImageWindowHeight : "80%", 
  toolbar :[ ["Source","-","FitWindow","ShowBlocks","-","Preview"], 
  ["Undo","Redo","-","Find","Replace","-","SelectAll","RemoveFormat"], 
 ["Cut","Copy","Paste","PasteText","PasteWord","-","Print","SpellCheck"], 
  ["Form","Checkbox","Radio","TextField","Textarea","Select",
  "Button","ImageButton","HiddenField"], ["About"], "/", ["Bold","Italic","Underline"], ["OrderedList","UnorderedList","-","Blockquote","CreateDiv"], ["Image","Flash","Table"],   ["Youtube","Unlink","Anchor"], 
  ["Rule","SpecialChar"], ["Styles"] ] ,
  
 removeDialogTabs: 'link:target;link:upload;link:advanced;image:Link;image:advanced',
 // extraPlugins :'youtube'
  
  });
  
  CKEDITOR.replace("halfmug_user_guide", 
  {width: "500", height: "300", language: "en", stylesCombo_stylesSet: "my_styles", startupOutlineBlocks: true, entities: false, entities_latin: false, entities_greek: false, 		forcePasteAsPlainText: false, 
  filebrowserImageUploadUrl : "<?php echo base_url()."pages/editorimage" ?>", 
  filebrowserImageBrowseUrl : "<?php echo front_base_url()."pages/editorimage1" ?>", 
 filebrowserImageWindowWidth : "80%", 
  filebrowserImageWindowHeight : "80%", 
  toolbar :[ ["Source","-","FitWindow","ShowBlocks","-","Preview"], 
  ["Undo","Redo","-","Find","Replace","-","SelectAll","RemoveFormat"], 
 ["Cut","Copy","Paste","PasteText","PasteWord","-","Print","SpellCheck"], 
  ["Form","Checkbox","Radio","TextField","Textarea","Select",
  "Button","ImageButton","HiddenField"], ["About"], "/", ["Bold","Italic","Underline"], ["OrderedList","UnorderedList","-","Blockquote","CreateDiv"], ["Image","Flash","Table"],   ["Youtube","Unlink","Anchor"], 
  ["Rule","SpecialChar"], ["Styles"] ] ,
  
 removeDialogTabs: 'link:target;link:upload;link:advanced;image:Link;image:advanced',

  
  });
  
   CKEDITOR.replace("fullmug_user_guide", 
  {width: "500", height: "300", language: "en", stylesCombo_stylesSet: "my_styles", startupOutlineBlocks: true, entities: false, entities_latin: false, entities_greek: false, 		forcePasteAsPlainText: false, 
  filebrowserImageUploadUrl : "<?php echo base_url()."pages/editorimage" ?>", 
  filebrowserImageBrowseUrl : "<?php echo front_base_url()."pages/editorimage1" ?>", 
 filebrowserImageWindowWidth : "80%", 
  filebrowserImageWindowHeight : "80%", 
  toolbar :[ ["Source","-","FitWindow","ShowBlocks","-","Preview"], 
  ["Undo","Redo","-","Find","Replace","-","SelectAll","RemoveFormat"], 
 ["Cut","Copy","Paste","PasteText","PasteWord","-","Print","SpellCheck"], 
  ["Form","Checkbox","Radio","TextField","Textarea","Select",
  "Button","ImageButton","HiddenField"], ["About"], "/", ["Bold","Italic","Underline"], ["OrderedList","UnorderedList","-","Blockquote","CreateDiv"], ["Image","Flash","Table"],   ["Youtube","Unlink","Anchor"], 
  ["Rule","SpecialChar"], ["Styles"] ] ,
  
 removeDialogTabs: 'link:target;link:upload;link:advanced;image:Link;image:advanced',

  
  });
	$("#usualValidate").validate();

});</script>
<script>$(document).ready(function(){
	$("#usualValidate").validate({
		rules:{
			enthusiast_user_guide:'required',
			halfmug_user_guide:'required',
			fullmug_user_guide:'required',

		}
	});

});</script>
<!-- Content begins -->
<div id="content" class="page_content">
    <!-- Main content -->
    <div class="container_fluid">
	<div class="row_fluid">
					<div class="span12">
						<h3 class="page_title">
							User Guide
							
						</h3>
						
					</div>
		</div>
		<?php  
	
		if($error != "") {
			if($error == "update") {?>
				<div class="success_msg">
					
						<p><?php echo "User guide updated successfully";?>.</p>
				</div>
			<?php }
		
			if($error != "update"){	?>
			<div class="error_red">
					
						<?php echo $error;?>
				</div>
			<?php }
		}
	?>		
     <div class="row_fluid">
					<div class="span12">
						<!-- BEGIN SAMPLE FORM PORTLET-->   
						<div class="portlet box blue tabbable">
				
                   
                        <div class="portlet-title">
								<div class="caption">
									<i class="icon-reorder"></i>
									<span class="hidden-480">User Guide</span>
								</div>
							</div>
                            <div class="portlet-body form">
								<div class="tabbable portlet-tabs">
								
                       <div class="tab-content" style="margin:0 !important">
										<div id="portlet_tab1" class="tab-pane active">
											<!-- BEGIN FORM-->
											<?php
				$attributes = array('id'=>'usualValidate','name'=>'frm_addadmin','class'=>'form-horizontal');
				echo form_open('site_setting/add_user_guide',$attributes);
			  ?>
			  <input type="hidden" name="h" id="h" value="hh" />
			  
			   <div class="control_group">
					<label class="control_label">Enthusiast User Guide:<span class="req">*</span></label>
                           <div class="controls"> 
                            
                             <textarea id="enthusiast_user_guide" cols="10" rows="4" name="enthusiast_user_guide" class="wid360 wysihtml5 m_wrap required"><?php echo $enthusiast_user_guide; ?></textarea>
                           
							 
							</div>
							<div class="clear"></div>
                        </div>
						
						
						 <div class="control_group">
					<label class="control_label">Halfmug User Guide:<span class="req">*</span></label>
                           <div class="controls"> 
                            
                             <textarea id="halfmug_user_guide" cols="10" rows="4" name="halfmug_user_guide" class="wid360 wysihtml5 m_wrap required"><?php echo $halfmug_user_guide; ?></textarea>
                           
							 
							</div>
							<div class="clear"></div>
                        </div>
						
						
						 <div class="control_group">
					<label class="control_label">Fullmug User Guide:<span class="req">*</span></label>
                           <div class="controls"> 
                            
                             <textarea id="fullmug_user_guide" cols="10" rows="4" name="fullmug_user_guide" class="wid360 wysihtml5 m_wrap required"><?php echo $fullmug_user_guide; ?></textarea>
                           
							 
							</div>
							<div class="clear"></div>
                        </div>
						
			         
									
                      <input type="hidden" name="site_setting_id" id="site_setting_id" value="<?php echo $site_setting_id; ?>" />
				 		
						<div class="form_action">
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="document.location.href='<?php echo base_url(); ?>admin/list_admin'" />
						</div>
                        </form>
       </div>
       
       </div>
                    </div>
</div>

            
</div>
</div>
</div>
</div>
</div>

<!-- Content ends -->    