<style type="text/css">
	#cke_83_label{display: none !important;}
</style>
<script src="<?php echo base_url().getThemeName(); ?>/js/ui/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/js/ui/jquery-ui.css" />
<script type="text/javascript" src="<?php echo base_url()?>/ckeditor/ckeditor.js"></script>
<script>

$(document).ready(function(){	
	
	
	//////// editor code/////////
	$('#cke_83_label').hide();		
  
 CKEDITOR.replace("dictionary_description", 
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
	/// end of editor code///////
	
	
	
	$("#usualValidate").validate({
		 ignore: [],
              debug: false,
		rules: {
			
			dictionary_title: {
				required: true,
			},
			
			dictionary_description:{
                         required: function() 
                        {
                         CKEDITOR.instances.dictionary_description.updateElement();
                        },

                         minlength:4
                   },
		  
			
		}
	});
	
});	
</script>
<script type="text/javascript">
$(document).ready(function(){
    tinymce.init({
    selector: "#dictionary_description",
    menubar:false,
    //element: "#description",
     theme: "modern",
     //plugins: "image,link,media,textcolor",
     plugins: [
        "advlist autolink lists link image charmap print preview anchor textcolor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
    image_advtab: true,

    templates: [
        {title: 'Test template 1', content: 'Test 1'},
        {title: 'Test template 2', content: 'Test 2'}
    ],
    height:"400px",

});
});
    
</script>
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($dictionary_id==""){ echo 'Add Dictionary'; } else { echo 'Edit Dictionary'; }?></h3>
					
				</div>
				<div class="row_fluid"> 
				<?php  
					if($error != "") {
						
						if($error == 'insert') {
							echo '<div class="success_msg"><p>Record has been updated Successfully.</p></div>';
						}
					
						if($error != "insert"){	
							echo '<div class="error_red">'.$error.'</div>';	
						}
					}
				?>		
					<div class="portlet blue">
						<div class="portlet-title">
							<div class="caption"></div>
						</div>
						<div class="portlet-body form">
							<div class="content ">
								<?php
				$attributes = array('id'=>'usualValidate','name'=>'frm_adddictionary','class'=>'main');
				echo form_open_multipart('dictionary/add_dictionary',$attributes);
			  ?>
			  						<div class="control_group">
										<label class="control_label">Dictionary Title:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Dictionary Title...." class="m_wrap wid360" name="dictionary_title" id="dictionary_title" value="<?php echo $dictionary_title; ?>">
										</div>										
										<div class="clear"></div>
									</div>
			  	
			  						 <div class="control_group">
                                    <label class="control_label">Description:<span class="req">*</span></label>
                                           <div class="controls"> 
                                            
                                             <textarea id="dictionary_description" cols="10" rows="4" name="dictionary_description" class="wid360 wysihtml5 m_wrap required"><?php echo $dictionary_description; ?></textarea>
                                           
                                             
                                            </div>
                                            <div class="clear"></div>
                                            <label for="dictionary_description" class="error pad134" style="display: none;">This field is required.</label>
                                        </div>
						
									
									<div class="control_group">
										<label class="control_label">Status:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="active" id="active"> 
												<option value="active" <?php echo ($active=='active')?'selected="selected"':''; ?> >Active</option>
												<option value="inactive" <?php echo ($active=='inactive')?'selected="selected"':''; ?> >Inactive</option>
											</select>
										</div>										
										<div class="clear"></div>
									</div>
								
							</div>	
						<input type="hidden" name="dictionary_id" id="dictionary_id" value="<?php echo $dictionary_id; ?>" />
						<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php
								if($dictionary_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_dictionary')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>dictionary/<?php echo $redirect_page.'/'.$user_id.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>dictionary/<?php echo $redirect_page.'/'.$user_id.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_dictionary')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>dictionary/<?php echo $redirect_page.'/'.$user_id.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>dictionary/<?php echo $redirect_page.'/'.$user_id.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
					<?php } ?>
					
					
					
					</form>		
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
</div>