<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/bootstrap-fileupload.css" />
<script src="<?php echo base_url().getThemeName();?>/js/jquery-migrate-1.0.0.js"></script>
<script src="<?php echo base_url().getThemeName();?>/js/bootstrap-fileupload.js" type="text/javascript"></script>
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
  
 CKEDITOR.replace("blog_description", 
  {width: "500", height: "300", language: "en", stylesCombo_stylesSet: "my_styles", startupOutlineBlocks: true, entities: false, entities_latin: false, entities_greek: false, 		forcePasteAsPlainText: false, 
  filebrowserImageUploadUrl : "<?php echo base_url()."pages/editorimage" ?>", 
  filebrowserImageBrowseUrl : "<?php echo front_base_url()."pages/editorimage1" ?>", 
 filebrowserImageWindowWidth : "80%", 
  filebrowserImageWindowHeight : "80%", 
  toolbar :[ ["Source","-","FitWindow","ShowBlocks","-","Preview"], 
  ["Undo","Redo","-","Find","Replace","-","SelectAll","RemoveFormat"], 
 ["Cut","Copy","Paste","PasteText","PasteWord","-","Print","SpellCheck"], 
  ["Form","Checkbox","Radio","TextField","Textarea","Select",
  "Button","ImageButton","HiddenField"], ["About"], "/", ["Bold","Italic","Underline"], ["OrderedList","UnorderedList","-","Blockquote","CreateDiv"], ["Image","Flash","Table"],   ["Link","Unlink","Anchor"], 
  ["Rule","SpecialChar"], ["Styles"] ] ,
  
 removeDialogTabs: 'link:target;link:upload;link:advanced;image:Link;image:advanced',

  
  });
	/// end of editor code///////
	
	
	
	$("#usualValidate").validate({
		 ignore: [],
              debug: false,
		rules: {
			
			blog_title: {
				required: true,
			},
			
			blog_image: {
				  extension: "jpg|jpeg|gif|png",
				  <?php if($blog_id==''){?>
				  required:true,
				  <?php } ?>
			},
			
			blog_description:{
                         required: function() 
                        {
                         CKEDITOR.instances.blog_description.updateElement();
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
    selector: "#blog_description",
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
					<h3 class="page_title"><?php if($blog_id==""){ echo 'Add Article'; } else { echo 'Edit Article'; }?></h3>
					
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
				$attributes = array('id'=>'usualValidate','name'=>'frm_addblog','class'=>'main');
				echo form_open_multipart('article/add_article',$attributes);
			  ?>
			  						<div class="control_group">
										<label class="control_label">Article Title:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Article Title...." class="m_wrap wid360" name="blog_title" id="blog_title" value="<?php echo $blog_title; ?>">
										</div>										
										<div class="clear"></div>
									</div>
			  	
			  						 <div class="control_group">
                                    <label class="control_label">Description:<span class="req">*</span></label>
                                           <div class="controls"> 
                                            
                                             <textarea id="blog_description" cols="10" rows="4" name="blog_description" class="wid360 wysihtml5 m_wrap required"><?php echo $blog_description; ?></textarea>
                                           
                                             
                                            </div>
                                            <div class="clear"></div>
                                            <label for="blog_description" class="error pad134" style="display: none;">This field is required.</label>
                                        </div>
						
						<div class="control-group">
											<label class="control-label">Article Image: <i style="color: #7D2A1C;">*</i></label>
											<div class="controls">
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
															<span class="btn btn-file">
															<span class="fileupload-new">Select Image</span>
															<span class="fileupload-exists">Change</span><input  accept="image/*" type="file" class="default" name="blog_image" id="blog_image" /></span>
															<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>
														<div class="clearfix"></div>
													
													</div>
													<label for="blog_image" generated="true" class="error" style="display: none;">This field is required.</label>
												<input type="hidden" name="prev_blog_image" id="prev_blog_image" value="<?php echo $pre_blog_image; ?>" />
												</div>
												<div class="controls">
										<?php if(($pre_blog_image!='' && file_exists(base_path().'upload/blog_thumb/'.$pre_blog_image))){ ?>
											<!-- <div class="control-group" style="clear:both">
												<label class="control-label"></label> -->
												<div class="controls">
													<div class="span2">
														<img src="<?php echo front_base_url().'upload/blog_thumb/'.$pre_blog_image; ?>" width="50"  height="50" />
													</div>
												</div>
											<!-- </div> -->
										<?php } ?>
										</div>
										<div class="clear"></div>
									</div>
									<label class="help-inline"><b>(Image required 800x350)</b></label>
										<div class="control_group">
										<label class="control_label">Meta Title: </label>
										<div class="controls">
											<input type="text" placeholder="Meta Title" class="m_wrap wid360" name="blog_meta_title" id="blog_meta_title" value="<?php echo $blog_meta_title; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Meta Keyword: </label>
										<div class="controls">
											<input type="text" placeholder="Meta Keyword" class="m_wrap wid360" name="blog_meta_keyword" id="blog_meta_keyword" value="<?php echo $blog_meta_keyword; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Meta Description: </label>
										<div class="controls">
											<textarea id="blog_meta_description" cols="10" rows="4" name="blog_meta_description" class="wid360 m_wrap "><?php echo $blog_meta_description; ?></textarea>
										</div>										
										<div class="clear"></div>
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
						<input type="hidden" name="blog_id" id="blog_id" value="<?php echo $blog_id; ?>" />
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
								if($blog_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_blog')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>article/<?php echo $redirect_page.'/'.$user_id.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>article/<?php echo $redirect_page.'/'.$user_id.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_blog')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>article/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>article/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
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