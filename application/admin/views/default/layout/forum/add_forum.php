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
  
 CKEDITOR.replace("forum_description", 
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
	
	$("#frm_addforum").validate({
		rules: {
			topic_name:'required',
			forum_description:'required',
			
			forum_category : 'required',
			status : 'required'
		},
		
	});
	
	});
	
	 $('#frm_addforum').on('submit', function() {
                    CKEDITOR.instances[instanceName].updateElement();
            });
</script>		
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($forum_id==""){ echo 'Add Forum'; } else { echo 'Edit Forum'; }?></h3>
					
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
							<div class="content">
								<?php
				$attributes = array('id'=>'frm_addforum','name'=>'frm_addforum','class'=>'main');
				echo form_open_multipart('forum/add_forum',$attributes);
			  ?>
			
			  
			  						<div class="control_group">
										<label class="control_label">Topic Name:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Form Name...." class="m_wrap wid360" name="topic_name" id="topic_name" value="<?php echo $topic_name; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									 <div class="control_group">
					                 <label class="control_label">Topic Description:<span class="req">*</span></label>
                                      <div class="controls"> 
                                       <textarea id="forum_description" cols="10" rows="4" name="forum_decription" class="wid360 wysihtml5 m_wrap required"><?php echo $forum_decription; ?></textarea>
                                  </div>
							     <div class="clear"></div>
							     	<label for="forum_description" class="error pad134" style="display: none;">This field is required.</label>
                             </div>
                             
                             
                             <div class="control_group">
										<label class="control_label">Forum category:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="forum_category" id="forum_category"> 
												<option value="">--Select--</option>
												<?php 
												if($forum_category_list)
												{
													foreach($forum_category_list as $fc)
													{?>
												<option value="<?php echo $fc->forum_category_id; ?>" <?php if($fc->forum_category_id == $forum_category) {?> selected = "selected" <?php }?>><?php echo $fc->forum_category_name; ?></option>		
											  <?php }
												}
												?>
											</select>
										</div>										
										<div class="clear"></div>
									</div>
                        
									<div class="control_group">
										<label class="control_label">Meta Title: </label>
										<div class="controls">
											<input type="text" placeholder="Meta Title" class="m_wrap wid360" name="forum_meta_title" id="forum_meta_title" value="<?php echo $forum_meta_title; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Meta Keyword: </label>
										<div class="controls">
											<input type="text" placeholder="Meta Keyword" class="m_wrap wid360" name="forum_meta_keyword" id="forum_meta_keyword" value="<?php echo $forum_meta_keyword; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Meta Description: </label>
										<div class="controls">
											<textarea id="forum_meta_description" cols="10" rows="4" name="forum_meta_description" class="wid360 m_wrap"><?php echo $forum_meta_description; ?></textarea>
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Status:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="status" id="status"> 
												<option value="">--Select--</option>
												<option value="active" <?php echo ($status=='active')?'selected="selected"':''; ?> >Active</option>
												<option value="inactive" <?php echo ($status=='inactive')?'selected="selected"':''; ?> >Inactive</option>
											</select>
										</div>										
										<div class="clear"></div>
									</div>
								
							</div>	
							<input type="hidden" name="forum_id" id="forum_id" value="<?php echo $forum_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
					
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php if($forum_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_form_category')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>forum/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>forum/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_forum')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>forum/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>forum/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
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