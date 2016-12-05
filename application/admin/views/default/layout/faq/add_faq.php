<script src="<?php echo base_url().getThemeName();?>/js/tiny_mce/tiny_mce.js" type="text/javascript"></script>

<script type="text/javascript">
	
	tinyMCE.init({
		mode : "textareas",
		theme : "simple"
	});
	
	//$(document).ready(function(){
		//$('.wysihtml5').tiny_mce({
		//	"stylesheets": ["<?php echo base_url().getThemeName(); ?>/js/bootstrap-wysihtml5/wysiwyg-color.css"]
		//});
	//});
</script>

<script>
$(document).ready(function(){
	$("#usualValidate").validate({
		rules: {
			doctor_id:'required',
			description:'required',
		},
		messages: {
			doctor_id:"Doctor is required.",
			description:"Description name is required.",	
		}
	});
});	
</script>

<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($faq_id==""){ echo 'Add FAQ'; } else { echo 'Edit FAQ'; }?></h3>
					
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
									$attributes = array('id'=>'usualValidate','name'=>'frm_addfaq','class'=>'main');
									echo form_open_multipart('faq/add_faq',$attributes);
								?>
			  						
									<div class="control_group">
										<label class="control_label">Question :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" id="faq_question" name="faq_question" class="m_wrap wid360 wysihtml5" value="<?php echo $faq_question;?>" />
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Answer :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<textarea id="faq_answer" name="faq_answer" class="m_wrap wid360 wysihtml5"><?php echo $faq_answer;?></textarea>
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<div class="controls">
											<label class="checkbox">
											<span><label class="control_label">Active ?<input type="checkbox" id="status" name="status" class="marL10" value="Active" <?php echo ($status=='Active')?'checked="checked"':''; ?>></label></span>
											</label>
										</div>										
										<div class="clear"></div>
									</div>
							</div>	
							
							<input type="hidden" name="faq_id" id="faq_id" value="<?php echo $faq_id; ?>" />
							<input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
							<input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
							<input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
							<input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
							<input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
							<input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
							<input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							
							<div class="form_action">
								
								<?php if($faq_id==""){ ?>
					
									<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
									<?php if($redirect_page == 'list_faq')
									{?>
									<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>faq/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
									<?php }else
									{?>
									<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>faq/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
									
									<?php }?>
									
									
									
								<?php }else { ?>
									
									<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
									
									<?php if($redirect_page == 'list_faq')
									{?>
									<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>faq/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
									<?php } else
									{?>
									<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>faq/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
									
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