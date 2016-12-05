<script>

$(document).ready(function(){	

	$("#usualValidate").validate({
		
		rules: {
			first_name:'required',
			last_name:'required',
			emailField: {
				required: true,
				email: true
			},
			username:{
			required:true,
			minlength:5,
			loginRegex:true
			},
			password: {
			required:true,
			minlength:5,
			maxlength:12,
			},
  			cpassword: {
			required:true,
			minlength:5,
			maxlength:12,
			equalTo: "#password"
			}
			
			
		},
		messages: {
			first_name:"First name is required.",
			last_name:"Last name is required.",
			emailField: {
				required: "Email is required.",
				email: 'Enter valid email'
			},
			username:{
				 required: "User name is required.",
				
            },
			password: {
			required:"Password is required."
			},
  			cpassword: {
			required:"Confirm password is required.",
			equalTo: "Confirm password is not equal to password."
			}
			
		}
	});
	
	
	 $.validator.addMethod("loginRegex", function(value, element) {
		
        return this.optional(element) || /^\w{5,}$/i.test(value);
    }, "Username must contain only letters, numbers, or underscore.");
	

	
});	
	


</script>
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($state_id==""){ echo 'Add state'; } else { echo 'Edit state'; }?></h3>
					
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
				$attributes = array('id'=>'usualValidate','name'=>'frm_addstate','class'=>'main');
				echo form_open_multipart('state/add_state',$attributes);
			  ?>
			  						<div class="control_group">
										<label class="control_label">Country:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="country_id" id="country_id"> 
												<option value="">--Select--</option>
												<?php if($all_countries!=''){
													foreach ($all_countries as $ac) {?>
														<option value="<?php echo $ac->Country_ID ?>" <?php echo ($country_id==$ac->Country_ID)?'selected="selected"':'' ?>><?php echo $ac->Country_Name ?></option>
													<?php }
												} ?>
											</select>
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">State Name:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="State Name...." class="m_wrap wid360" name="state_name" id="state_name" value="<?php echo $state_name; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<div class="controls">
											<label class="checkbox">
											<span><label class="control_label">Active ?<input type="checkbox" class="marL10" value="n" <?php echo ($is_delete=='n')?'checked="checked"':''; ?> name="is_delete" id="is_delete"></label></span>
											</label>
										</div>										
										<div class="clear"></div>
									</div>
									
								
							</div>	
							<input type="hidden" name="state_id" id="state_id" value="<?php echo $state_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php if($state_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_state')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>state/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>state/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_state')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>state/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>state/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
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