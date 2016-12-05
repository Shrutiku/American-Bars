<style type="text/css">
	#cke_83_label{display: none !important;}
</style>
<script src="<?php echo base_url().getThemeName(); ?>/js/ui/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/js/ui/jquery-ui.css" />
<script type="text/javascript" src="<?php echo base_url()?>/ckeditor/ckeditor.js"></script>
<script>

$(document).ready(function(){	
	
	
	
	
	
	$("#usualValidate").validate({
		 ignore: [],
              debug: false,
		rules: {
			
			question: {
				required: true,
			},
			question1: {
				required: true,
			},
			question2: {
				required: true,
			},
			question3: {
				required: true,
			},
			question4: {
				required: true,
			},
			answer: {
				required: true,
			}
			
		
		  
			
		},
		 messages: {
			answer: 'Please select one radio button which is correctr answer.',
		}
	});
	
});	
</script>

<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($trivia_id==""){ echo 'Add Trivia'; } else { echo 'Edit Trivia'; }?></h3>
					
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
				$attributes = array('id'=>'usualValidate','name'=>'frm_addtrivia','class'=>'main');
				echo form_open_multipart('trivia/add_trivia',$attributes);
			  ?> 
			  						<div class="control_group">
										<label class="control_label">Question :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Question...." class="m_wrap wid360" name="question" id="question" value="<?php echo $question; ?>">
										</div>										
										<div class="clear"></div>
									</div>
			  	
			  						<div class="control_group">
										<label class="control_label">Answer :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="radio" <?php echo $answer=='1' ? 'checked':''; ?>  class="fl_left mar_top5 mar_r5" style="margin-right: 10px; margin-top: 10px;" value="1" id="answer" name="answer" >
											<input type="text" name="question1" id="question1" value="<?php echo $question1; ?>" class="m_wrap wid360" />
											<label for="question1" style="display: none; padding-left: 26px;" generated="true" class="error">This field is required.</label>
										</div>										
										<div class="clear"></div>
										<div class="controls mar_top15">
											<input type="radio" <?php echo $answer=='2' ? 'checked':''; ?> class="fl_left mar_top5 mar_r5" style="margin-right: 10px; margin-top: 10px;" value="2" id="answer" name="answer" >
											<input type="text" name="question2" id="question2" value="<?php echo $question2; ?>" class="m_wrap wid360" />
											<label for="question2" style="display: none; padding-left: 26px;" generated="true" class="error">This field is required.</label>
										</div>										
										<div class="clear"></div>
										<div class="controls mar_top15">
											<input type="radio" <?php echo $answer=='3' ? 'checked':''; ?> class="fl_left mar_top5 mar_r5" style="margin-right: 10px; margin-top: 10px;" value="3" id="answer" name="answer" >
											<input type="text" name="question3" id="question3" value="<?php echo $question3; ?>" class="m_wrap wid360" />
											<label for="question3" style="display: none; padding-left: 26px;" generated="true" class="error">This field is required.</label>
										</div>										
										<div class="clear"></div>
										<div class="controls mar_top15">
											<input type="radio" <?php echo $answer=='4' ? 'checked':''; ?> class="fl_left mar_top5 mar_r5" style="margin-right: 10px; margin-top: 10px;" value="4" id="answer" name="answer" >
											<input type="text" name="question4" id="question4" value="<?php echo $question4; ?>" class="m_wrap wid360" />
											<label for="question4" style="display: none; padding-left: 26px;" generated="true" class="error">This field is required.</label>
										</div>										
										<div class="clear"></div>
										<label for="answer" generated="true" style="display: none" class="error"></label>
									</div> 
						
									
									<div class="control_group ">
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
						<input type="hidden" name="trivia_id" id="trivia_id" value="<?php echo $trivia_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php
								if($trivia_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_trivia')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>trivia/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>trivia/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_trivia')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>trivia/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>trivia/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
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