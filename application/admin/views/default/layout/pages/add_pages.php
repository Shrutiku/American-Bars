<!-- <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	tinymce.init({
    selector: "#description",
	//element: "#description",
	 theme: "modern",
	 //plugins: "image,link,media,textcolor",
	 plugins: [
        "advlist autolink lists link image charmap print preview anchor textcolor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste","gsynuhimgupload"
    ],

   

    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    toolbar2: "print preview media | forecolor backcolor emoticons ",
    image_advtab: true,

    templates: [
        {title: 'Test template 1', content: 'Test 1'},
        {title: 'Test template 2', content: 'Test 2'}
    ],
	height:"400px",
   
   relative_urls: false,
remove_script_host: false
});








});
	
</script> -->
<style type="text/css">
	#cke_83_label{display: none !important;}
</style>
<script src="<?php echo base_url().getThemeName(); ?>/js/ui/jquery-ui.js"></script>

<link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/js/ui/jquery-ui.css" />
<script type="text/javascript" src="<?php echo base_url()?>/ckeditor/ckeditor.js"></script>


<script type="text/javascript">$(document).ready(function(){
	
$('#cke_83_label').hide();		
  
 CKEDITOR.replace("description", 
  {width: "500", height: "300", language: "en", stylesCombo_stylesSet: "my_styles", startupOutlineBlocks: true, entities: false, entities_latin: false, entities_greek: false, 		forcePasteAsPlainText: false, 
  filebrowserImageUploadUrl : "<?php echo base_url()."pages/editorimage" ?>", 
  filebrowserImageBrowseUrl : "<?php echo front_base_url()."pages/editorimage1" ?>", 
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
  
  CKEDITOR.replace("description1", 
  {width: "500", height: "300", language: "en", stylesCombo_stylesSet: "my_styles", startupOutlineBlocks: true, entities: false, entities_latin: false, entities_greek: false, 		forcePasteAsPlainText: false, 
  filebrowserImageUploadUrl : "<?php echo base_url()."pages/editorimage" ?>", 
  filebrowserImageBrowseUrl : "<?php echo front_base_url()."pages/editorimage1" ?>", 
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
<!-- Content begins -->
<div id="content" class="page_content">
    <!-- Main content -->
    <div class="container_fluid">
	<div class="row_fluid">
					<div class="span12">
						<h3 class="page_title">
							Pages							
						</h3>
						
					</div>
		</div>
        		<?php  
		if($error != "") {
			
			if($error == 'insert') {?>
			<div class="success_msg">
					
					<p>	<?php echo UPDATE_RECORD;?>.</p>
				</div>
			<?php }
		
			if($error != "insert"){	?>
				<div class="error_red">
						<?php echo $error;?>
			</div>	
		<?php	}
		}
	?>		
                  <div class="row_fluid">
					<div class="span12">
						<!-- BEGIN SAMPLE FORM PORTLET-->   
						<div class="portlet box blue tabbable">
				   
                        <div class="portlet-title">
								<div class="caption">
									<i class="icon-reorder"></i>
									<span class="hidden-480"><?php if($pages_id ==""){ echo 'Add Page'; } else { echo 'Edit Page'; }?></span>
								</div>
							</div>
                            <div class="portlet-body form">
								<div class="tabbable portlet-tabs">
	                   <div class="tab-content">
										<div id="portlet_tab1" class="tab-pane active">
											<!-- BEGIN FORM-->
			<?php
				$attributes = array('id'=>'usualValidate','name'=>'frm_addpages','class'=>'form-horizontal');
				echo form_open('pages/add_pages',$attributes);
			  ?>
			  <div class="control_group">
					<label class="control_label">Pages Title:<span class="req">*</span></label>
                            <div class="controls"> <input type="text" name="pages_title" id="pages_title" value="<?php echo $pages_title; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                        </div>
			  <?php if($pages_title!='Registration Step2'){?>
                
                        

        
						 <div class="control_group">
					<label class="control_label">Description:<span class="req">*</span></label>
                           <div class="controls"> 
                            
                             <textarea id="description" cols="10" rows="4" name="description" class="wid360 wysihtml5 m_wrap required"><?php echo $description; ?></textarea>
                           
							 
							</div>
							<div class="clear"></div>
                        </div>
						
                         <div class="control_group">
					<label class="control_label">Slug:</label>
                          <div class="controls"> 
							<input type="text" name="slug" id="slug" value="<?php echo $slug; ?>" class="m_wrap wid360"/>
						</div>
						<div class="clear"></div>
                        </div>
                        
                         <div class="control_group">
					<label class="control_label">Meta Keyword:</label>
                          <div class="controls"> 
							<input type="text" name="meta_keyword" id="meta_keyword" value="<?php echo $meta_keyword; ?>" class=" m_wrap wid360	"/>
						</div>
						<div class="clear"></div>
                        </div>
                        
                         <div class="control_group">
					<label class="control_label">Meta Description:</label>
                            <div class="controls"> 
							<input type="text" name="meta_description" id="meta_description" value="<?php echo $meta_description; ?>" class="m_wrap wid360"/>
						</div>
						<div class="clear"></div>
                        </div>
                <?php } else {?>
                	 <div class="control_group">
					<label class="control_label">Free Listing Learn More:<span class="req">*</span></label>
                           <div class="controls"> 
                            
                             <textarea id="description" cols="10" rows="4" name="description" class="wid360 wysihtml5 m_wrap required"><?php echo $description; ?></textarea>
                           
							 
							</div>
							<div class="clear"></div>
                        </div>
                        
                         <div class="control_group">
					<label class="control_label">Full Mug (Paid) Listing Learn More :<span class="req">*</span></label>
                           <div class="controls"> 
                            
                             <textarea id="description1" cols="10" rows="4" name="description1" class="wid360 wysihtml5 m_wrap required"><?php echo $description1; ?></textarea>
                           
							 
							</div>
							<div class="clear"></div>
                        </div>
                	<?php } ?>

				
						
						  <div class="control_group">
					<label class="control_label">Status:</label>
                          <div class="controls"> 
							 <select name="active" id="active" class="required m_wrap">
									<option value="0" <?php if($active=='0'){ echo "selected"; } ?>>Inactive</option>
									<option value="1" <?php if($active=='1'){ echo "selected"; } ?>>Active</option>														
							  </select>
							</div>
							<div class="clear"></div>
                        </div>
                        
                        
						<input type="hidden" name="pages_id" id="pages_id" value="<?php echo $pages_id; ?>" />
				 	     <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
						 
						  <input type="hidden" name="sort_type" id="sort_type" value="<?php echo $sort_type; ?>" />
						  <input type="hidden" name="sort_by" id="sort_by" value="<?php echo $sort_by; ?>" />
						<?php if($pages_id==""){ ?>
						<div class="form_actions">
						<input type="submit" name="submit" value="Submit" class="btn blue" />
						<input type="button" name="Cancel" value="Cancel" class="btn" onClick="location.href='<?php echo base_url(); ?>pages/list_pages'" />
						
						
						</div>
					<?php }else { ?>
						<div class="form_action"> 
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						<input type="button" name="Cancel" value="Cancel" class="btn red fl_left" onClick="location.href='<?php echo base_url(); ?>pages/list_pages'" />
						
						</div>
					<?php } ?>
					
					  
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>

<!-- Content ends -->    