<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="<?php echo base_url().getThemeName();?>/js/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<script>

$(document).ready(function(){	

	tinyMCE.init({
		mode : "textareas",
		theme : "simple"
	});


	
	$("#usualValidate").validate({
			ignore: [],
	             debug: false,	
			rules: {
			category:'required',
			status : 'required',
			question:{
                        required: function() 
                        {
                           tinyMCE.get('question').getContent();
						   tinyMCE.triggerSave();
                        },
                        minlength:3
                   },
			answer:{
                        required: function() 
                        {
                           tinyMCE.get('answer').getContent();
						   tinyMCE.triggerSave();
                        },
                        minlength:3
                   }				   		
		},		
	});
});	
</script>
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($bar_statistic_id==""){ echo 'Add Barstatistic'; } else { echo 'Edit Barstatistic'; }?></h3>
					
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
				$attributes = array('id'=>'usualValidate','name'=>'frm_addbarstatistic','class'=>'main');
				echo form_open_multipart('barstatistic/add_barstatistic',$attributes);
			  ?> 
			  					
									<div class="control_group">
										<label class="control_label">Question:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<textarea name="question" id="question" placeholder="Description..." class="m_wrap span9 wid360" rows="20" cols="100" data-error-container="#editor1_error">
												<?php  echo $question ;?>
											</textarea>
											<label for="question" generated="true" class="error" style="display: none;">This field is required.</label>
										</div>										
										<div class="clear"></div>
							  </div>
									
									<div class="control_group">
										<label class="control_label">Category:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<select id="category" class="m_wrap wid360" name="category">
												<option value="">-Select-</option>
												<option value="dive_bars" <?php if($category =='latest_barstatistic_and_event'){?> selected="selected" <?php } ?>> Dive Bars</option>
												<option value="food" <?php if($category =='food'){?> selected="selected" <?php } ?>> Food</option>
												<option value="drink" <?php if($category =='drink'){?> selected="selected" <?php } ?>> Drink </option>
												<option value="hangovers" <?php if($category =='hangovers'){?> selected="selected" <?php } ?>> Hang Overs </option>
												<option value="countries" <?php if($category =='countries'){?> selected="selected" <?php } ?>> Countries </option>
												<option value="records" <?php if($category =='records'){?> selected="selected" <?php } ?>> Records </option>
											</select>
										</div>										
										<div class="clear"></div>
									</div>			
									
									<div class="control_group">
										<label class="control_label">Answer:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<textarea name="answer" id="answer" placeholder="Description..." class="m_wrap span9 wid360" rows="20" cols="100" data-error-container="#editor1_error">
												<?php  echo $answer; ?>
											</textarea>
											<label for="answer" generated="true" class="error" style="display: none;">This field is required.</label>
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
									
									
									
									
								
							
							<input type="hidden" name="bar_statistic_id" id="bar_statistic_id" value="<?php echo $bar_statistic_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
					
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php if($bar_statistic_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_barstatistic')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>barstatistic/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>barstatistic/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_barstatistic')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>barstatistic/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>barstatistic/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
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