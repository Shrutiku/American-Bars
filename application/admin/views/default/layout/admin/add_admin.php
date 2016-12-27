<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/bootstrap-fileupload.css" />
<script src="<?php echo base_url().getThemeName();?>/js/jquery-migrate-1.0.0.js"></script>
<script src="<?php echo base_url().getThemeName();?>/js/bootstrap-fileupload.js" type="text/javascript"></script>
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
			minlength:8,
			maxlength:15,
			alphaNumeric:true,
			
			},
  			cpassword: {
			required:true,
			alphaNumeric:true,
			minlength:8,
			maxlength:15,
			equalTo: "#password"
			},
			file_up: {
				  extension: "jpg|jpeg|gif|png"
			},
			
			
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
				// minlength:'User name must have minimum 5 charctor long',
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
					<h3 class="page_title"><?php if($admin_id==""){ echo 'Add Admin'; } else { echo 'Edit Admin'; }?></h3>
					
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
				$attributes = array('id'=>'usualValidate','name'=>'frm_addadmin','class'=>'main');
				echo form_open_multipart('admin/add_admin',$attributes);
			  ?>
			  						<div class="control_group">
										<label class="control_label">First Name:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="First Name...." class="m_wrap wid360" name="first_name" id="first_name" value="<?php echo $first_name; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">Last Name:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Last Name...." class="m_wrap wid360" name="last_name" id="last_name" value="<?php echo $last_name; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">User Name:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="User Name...." class="m_wrap wid360" name="username" id="username" value="<?php echo $username; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Email :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Email...." class="m_wrap wid360" name="emailField" id="emailField" value="<?php echo $email; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">Password :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="password" name="password" id="password" value="<?php echo $password; ?>" placeholder="Password..." class="m_wrap wid360" >
										</div>										
										<div class="clear"></div>
										<input type="hidden" name="pre_pass" value="<?php echo $password; ?>" />
									</div>
									
									<div class="control_group">
										<label class="control_label">Confirm Password:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="password" placeholder="Confirm Password...." class="m_wrap wid360" value="<?php echo $password; ?>" id="cpassword" name="cpassword">
										</div>										
										<div class="clear"></div>
									</div>
									<?php /*?><div class="control_group">
										<label class="control_label">Image :</label>
										<div class="controls wid400">
											<input type="file" name="file_up" id="file_up" />
											<input type="hidden" name="pre_profile_image" id="pre_profile_image" value="<?php echo $image ?>" />
										</div>
										<div class="controls wid400">
											<?php if($image!='' && file_exists(base_path().'upload/admin/'.$image)){?>
												<img src="<?php echo front_base_url().'upload/admin/'.$image ?>"  width="50"  height="50"/>
											<?php } ?>
										</div>										
										<div class="clear"></div>
									</div><?php */?>
									
									<div class="control-group">
											<label class="control-label">Image</label>
											<div class="controls">
												<div class="fileupload fileupload-new"  data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
															<span class="btn btn-file">
															<span class="fileupload-new">Select Image</span>
															<span class="fileupload-exists">Change</span><input type="file" accept="image/*" class="default" name="file_up" id="file_up" /></span>
															<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>
														<span for="profile_image" class="help-inline" style="display: none">This field is required.</span>
													</div>
												<input type="hidden" name="pre_profile_image" id="pre_profile_image" value="<?php echo $image ?>" />
												</div>
											<!-- </div>  -->
										<?php if(($image!='' && file_exists(base_path().'upload/admin/'.$image))){ ?>
											<!-- <br /><br />
											<div class="control-group">
												<label class="control-label"></label> -->
												<div class="controls">
													<div class="span2 position-relative">
														<img src="<?php echo front_base_url().'upload/admin/'.$image ?>" width="50"  height="50" />
														<a href="<?php echo base_url(); ?>admin/removeimage/<?php echo $admin_id.'/'.$image.'/'.$limit.'/'.$offset.'/'.$redirect_page.'/'.$option.'/'.$keyword; ?>" id="remove" name="remove"><i class="comon_icon remove_icon"></i></a>
													</div>
												</div>
											<!-- </div> -->
										<?php } ?>
										<div class="clear"></div>
										</div>
									</div>
								<?php if($this->session->userdata('admin_type')=='1'){?>		
									<div class="control_group">
										<label class="control_label">Status:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="active" id="active"> 
												<option value="active" <?php echo ($active=='Active')?'selected="selected"':''; ?> >Active</option>
												<option value="inactive" <?php echo ($active=='Inactive')?'selected="selected"':''; ?> >Inactive</option>
											</select>
										</div>										
										<div class="clear"></div>
									</div>
									
								<?php } else { ?>
									<input type="hidden" name="active" id="active" value="<?php echo $active; ?>" />
									<?php } ?>	
								
							
							<input type="hidden" name="admin_id" id="admin_id" value="<?php echo $admin_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php if($admin_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_admin')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>admin/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>admin/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_admin')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>admin/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>admin/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
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
</div>