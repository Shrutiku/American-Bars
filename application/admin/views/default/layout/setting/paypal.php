<script>$(document).ready(function(){
	$("#usualValidate").validate({
		rules:{
			site_status:'required',
			paypal_username:'required',
			partner_name:'required',
			paypal_password:'required',
			vendor:'required',
}
	});

});

// function getval(val)
// {
	// if(val=="sandbox")
	// {
		// $("#client_id").val("AbgtMracMJiiyDF_IJS3pOG1ZzLKkPTQIE618Ps1SpU2z84v2CoiO_EikMSED0sffHlUJBjs4gdkHctq");
		// $("#secret_key").val("EMEiXHzrfghGPpcdfgVwHfsm5nFVNJlyLtPjhXKP5REZkS0Cf8uGV1tvPuiIFKTrd45pQVG8_75URGFO");
	// }
	// else if(val=="live")
	// {
		// $("#client_id").val("AVZ3e2ifc56lwo85lYGxxY32uoIVHg1sRZzLoCRufUFpRcl23p5uF5S9ashZKvVUXm0iWQbpoiYagI02");
		// $("#secret_key").val("EIlrAR4Y9sABd7I2Vm7Iyz95uYFAn-O492R9U1bghyg77a-I74ibz1SgeL0aIKM3cP4Ih7dGjDkSVnC8");
	// }
// }
</script>
<!-- Content begins -->
<div id="content" class="page_content">
    <!-- Main content -->
    <div class="container_fluid">
	<div class="row_fluid">
					<div class="span12">
						<h3 class="page_title">
							Paypal Settings
							
						</h3>
						
					</div>
		</div>
		<?php  
		if($error != "") {
			if($error == "update") {?>
				<div class="success_msg">
					
						<p><?php echo SITE_PAYPAL_UPDATE;?>.</p>
				</div>
			<?php }
		
			if($error != "update"){	?>
			<div class="error_red">
					
						<?php echo $error;?>
				</div>
			<?php }
		}
	?>		
     <div class="row_fluid">
					<div class="span12">
						<!-- BEGIN SAMPLE FORM PORTLET-->   
						<div class="portlet box blue tabbable">
				
                   
                        <div class="portlet-title">
								<div class="caption">
									<i class="icon-reorder"></i>
									<span class="hidden-480">Paypal Setting</span>
								</div>
							</div>
                            <div class="portlet-body form">
								<div class="tabbable portlet-tabs">
								
                       <div class="tab-content" style="margin:0 !important">
										<div id="portlet_tab1" class="tab-pane active">
											<!-- BEGIN FORM-->
											<?php
				$attributes = array('id'=>'usualValidate','name'=>'frm_addadmin','class'=>'form-horizontal');
				echo form_open('site_setting/paypal_setting',$attributes);
			  ?>
					<div class="control_group">
										<label class="control_label">Paypal Status:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="site_status" onchange="getval(this.value)" id="site_status"> 
												<option value="">--Select--</option>
												 <option  value="test" <?php if($site_status=="test"){ ?> selected="selected"<?php }?>>sand box</option>
						   						 <option value="live" <?php if($site_status=="live"){ ?> selected="selected"<?php }?>>live</option>
											</select>
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
							<label class="control_label"> Partner Name  <span class="req">*</span></label>
                            <div class="controls"> <input type="text" name="partner_name" id="partner_name" value="<?php echo $partner_name; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
							</div>
                       <div class="control_group">
							<label class="control_label"> Vendor Name  <span class="req">*</span></label>
                            <div class="controls"> <input type="text" name="vendor" id="vendor" value="<?php echo $vendor; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
							</div>
                        <div class="control_group">
							<label class="control_label">Username<span class="req">*</span></label>
                            <div class="controls"> <input type="text" name="paypal_username" id="paypal_username" value="<?php echo $paypal_username; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
							</div>
							
							<div class="control_group">
							<label class="control_label">Password<span class="req">*</span></label>
                            <div class="controls"> <input type="text" name="paypal_password" id="paypal_password" value="<?php echo $paypal_password; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
							</div>
                    	<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
				 		<div class="form_action">
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						</div>
                        </form>
       </div>
       
       </div>
                    </div>
</div>

            
</div>
</div>
</div>
</div>
</div>

<!-- Content ends -->    