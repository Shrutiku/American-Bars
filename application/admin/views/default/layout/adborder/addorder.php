<script>
	function getState(id)
{
	$.ajax({
		url:'<?php echo site_url('order/GetStateAjax') ?>/'+id,
		beforeSend:function(){ $('#stateLoad').fadeIn();},
		success:function(res){ 
			$('#state_id').html(res);
			$('#city_id').html('<option value="">Select City</option>');
			},
		complete:function(){ $('#stateLoad').fadeOut();},
	});
}


function getCity(id)
{
	$.ajax({
		url:'<?php echo site_url('order/GetCityAjax') ?>/'+id,
		beforeSend:function(){ $('#cityLoad').fadeIn();},
		success:function(res){ 
			$('#city_id').html(res);
			},
		complete:function(){ $('#cityLoad').fadeOut();},
	});
}

	
</script>



<div class="page-content">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div class="modal hide" id="portlet-config">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"></button>
				</div>
				<div class="modal-body">
				</div>
			</div>
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->   
				<div class="row-fluid">
					<div class="span12">
						
						<h3 class="page-title">
						<?php
							if ($order_id == "") { echo 'Add Order';
							} else { echo 'Edit Order';
							}
						?> 				
						</h3>
						
					</div>
				</div>
				<?php
				if($error != ""){	?>
			<div class="alert alert-error">
					<button data-dismiss="alert" class="close"></button>
						<?php echo $error; ?>
			</div>	
			<?php } ?>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<div class="portlet box blue">
										<div class="portlet-title">
											<div class="caption"><i class="icon-reorder"></i>
												<?php
												if ($order_id == "") { echo 'Add Order';
												} 
												else { echo 'Edit Order';
												}
												?>
											 </div>
										</div>
										<div class="portlet-body form">
												<!-- BEGIN FORM-->
												<?php // Change the css classes to suit your needs
												$attributes = array('class' => 'form-horizontal', 'id' => 'order', 'name' => 'order');
												echo form_open_multipart('order/addOrder', $attributes); ?>
										<div class="alert alert-error hide" style="display: none !important;">
										<button class="close" data-dismiss="alert"></button>
												You have some form errors. Please check below.
										</div>
												<div class="control-group">
													<label class="control-label">First Name<span class="required">*</span></label>
													<div class="controls">
														<input type="text" class="m-wrap medium"  name="first_name" id="first_name" placeholder="" value="<?php echo $first_name; ?>">
													</div>
												</div>
												<div class="control-group">
													<label class="control-label">Last Name<span class="required">*</span></label>
													<div class="controls">
														<input type="text" class="m-wrap medium"  name="last_name" id="last_name" placeholder="" value="<?php echo $last_name; ?>">
													</div>
												</div>
												<div class="control-group">
													<label class="control-label">Email<span class="required">*</span></label>
													<div class="controls">
														<input type="text" class="m-wrap medium"  name="email" id="email" placeholder="" value="<?php echo $email; ?>">
													</div>
												</div>
												<?php if($order_id==''){?>
												<div class="control-group">
													<label class="control-label">Password<span class="required">*</span></label>
													<div class="controls">
														<input type="password" class="m-wrap medium"  name="password" id="password" placeholder="" value="<?php echo $password; ?>">
													</div>
												</div>
												<div class="control-group">
													<label class="control-label">Confirm Password<span class="required">*</span></label>
													<div class="controls">
														<input type="password" class="m-wrap medium"  name="passconf" id="passconf" placeholder="" value="<?php echo $passconf; ?>">
													</div>
												</div>
												<?php } ?>
												<div class="control-group">
													<label class="control-label">Address<span class="required">*</span></label>
													<div class="controls">
														<textarea name="address"><?php echo $address; ?></textarea>
														
													</div>
												</div>
												<div class="control-group">
													<label class="control-label">Country<span class="required">*</span></label>
													<div class="controls">
														<select onchange="getState(this.value)" class="small l-wrap" name="country_id" id="country_id"  >
				           									  <option value="">Select Country</option>
				             									<?php
				            										 if($allCountry!=''){
				            										 	print_r($allCountry);
				             											foreach ($allCountry as $ac) {
				             												?>
																			 <option value="<?php echo $ac->country_id; ?>" <?php echo ($country_id==$ac->country_id)?'selected="selected"':''; ?>><?php echo $ac->country_name ?></option>
																 	<?php }
				           											  } 
				             										?>
				          								 </select>
													</div>
												</div>
												<div class="control-group">
													<label class="control-label">State<span class="required">*</span></label>
													<div class="controls">
														<select onchange="getCity(this.value)" class="small l-wrap" name="state_id" id="state_id"  >
				            							 <option value="">Select State...</option>
											            	<?php if($allstate!=''){
											            	foreach ($allstate as $s) {?>
																<option value="<?php echo $s->state_id; ?>" <?php echo ($state_id==$s->state_id)?'selected="selected"':''; ?>><?php echo $s->state_name ?></option>
															<?php }
											            } ?>
											           </select>
													</div>
												</div>
												<div class="control-group">
													<label class="control-label">City<span class="required">*</span></label>
													<div class="controls">
														<input type="text" class="m-wrap medium"  name="city" id="city" placeholder="" value="<?php echo $city; ?>">
													</div>
												</div>
												<div class="control-group">
													<label class="control-label">Zipcode<span class="required">*</span></label>
													<div class="controls">
														<input type="text" class="m-wrap medium"  name="zipcode" id="zipcode" placeholder="" value="<?php echo $zipcode; ?>">
													</div>
												</div>
												<div class="control-group">
													<label class="control-label">Mobile No.<span class="required">*</span></label>
													<div class="controls">
														<input type="text" class="m-wrap medium"  name="mobile_no" id="mobile_no" placeholder="" value="<?php echo $mobile_no; ?>" maxlength="13">
													</div>
												</div>
												<div class="control-group">
													<label class="control-label">Status<span class="required">*</span></label>
													<div class="controls">
														<select tabindex="1" name="status" id="status" class="small l-wrap">
															<option value="">Select</option>
															<option value="Active" <?php if($status=='Active'){ ?> selected="selected"<?php } ?>>Active</option>
															<option value="Inactive" <?php if($status=='Inactive'){ ?> selected="selected"<?php } ?>>Inactive</option>
														</select>
													</div>
												</div>
												<div class="form-actions">
													<input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
													<input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
													<input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id; ?>" />
													<input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
													<input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
													<input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
													<input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
													<input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
													<button class="btn blue" type="submit"><i class="icon-ok"></i> <?php echo ($order_id!='')?'Update':'Submit' ?></button>
													
													<?php if($redirect_page == 'orderlist')
														{?>
														<input type="button" name="Cancel" value="Cancel" class="btn" onClick="location.href='<?php echo base_url(); ?>order/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
														<?php }else
															{
														?>
														<input type="button" name="Cancel" value="Cancel" class="btn" onClick="location.href='<?php echo base_url(); ?>order/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
														
														<?php } ?>
												</div>
											</form>
											<!-- END FORM--> 
										</div>
									</div>
						<!-- BEGIN SAMPLE FORM PORTLET-->   
						
						<!-- END SAMPLE FORM PORTLET-->
					</div>
				</div>
				<!-- END PAGE CONTENT-->         
			</div>
<!-- END PAGE CONTAINER-->
<script type="text/javascript" src="<?php echo base_url() . getThemeName(); ?>/assets/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>  
<script type="text/javascript" src="<?php echo base_url() . getThemeName(); ?>/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url() . getThemeName(); ?>/assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() . getThemeName(); ?>/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() . getThemeName(); ?>/assets/plugins/jquery.input-ip-address-control-1.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() . getThemeName(); ?>/assets/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?php echo base_url() . getThemeName(); ?>/assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() . getThemeName(); ?>/assets/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
<script src="<?php echo base_url() . getThemeName(); ?>/assets/plugins/jquery.pwstrength.bootstrap/src/pwstrength.js" type="text/javascript" ></script>
<script src="<?php echo base_url() . getThemeName(); ?>/assets/plugins/bootstrap-switch/static/js/bootstrap-switch.js" type="text/javascript" ></script>
<script src="<?php echo base_url() . getThemeName(); ?>/assets/plugins/jquery-tags-input/jquery.tagsinput.min.js" type="text/javascript" ></script>   
 
<script type="text/javascript" src="<?php echo base_url() . getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() . getThemeName(); ?>/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<!-- <script src="<?php echo base_url().getThemeName(); ?>/assets/scripts/form-components.js"></script> -->
<script src="<?php echo base_url() . getThemeName(); ?>/assets/scripts/form-validation.js"></script>	    

<script>
	jQuery(document).ready(function() {
		var form1 = $('#order');
		var error1 = $('.alert-error', form1);
		var success1 = $('.alert-success', form1);

		form1.validate({
			errorElement : 'span', //default input error message container
			errorClass : 'help-inline', // default input error message class
			focusInvalid : false, // do not focus the last invalid input
			ignore : "",
			rules : {
				first_name : {
					required : true,
					minlength : 2
				},
				last_name : {
					required : true,
					minlength : 2
				},
				email : {
					required : true,
					email : true
				},
				password : {
					required : true,
					minlength : 5
				},
				passconf : {
					required : true,
					minlength : 5,
					equalTo : "#password"
				},
				address : {
					required : true
				},
				country_id : {
					required : true
				},
				state_id : {
					required : true
				},
				city : {
					required : true
				},
				zipcode : {
					required : true,
					minlength : 3
				},
				mobile_no : {
					required : true,
					number: true,
					minlength : 10
				},
				status : {
					required : true
				},
			},
			invalidHandler : function(event, validator) {//display error alert on form submit
				success1.hide();
				error1.hide();
				App.scrollTo(error1, -200);
			},
			submitHandler : function(form) {
				$(".controls span").hide();
				$('.control-group').removeClass('success');
				success1.hide();
				error1.hide();
				form.submit();
			}
		});
	});
	</script>
	</div>