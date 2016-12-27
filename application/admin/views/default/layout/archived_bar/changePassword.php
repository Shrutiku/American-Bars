<script>
 var url='<?php echo base_url(); ?>bar/setNewPassword/<?php echo $bar_id;?>/';
	$('#submitSet').click(function()
              		{
              			$('#noteerror').fadeOut();
              			
              				
              				 $.ajax({
				            type: 'POST',
				            dataType:'Json',
				            url: url,
				            data: $('#setPstat').serialize(),
				            success: function(data) {
				                if(data.error.length>0){
				                	$('#errorDiv').html(function(){
				                		$(this).html(data.error);
				                		$(this).fadeIn();
				                	});
				                	//$.growlUI(data.msg); 
				                	//$modal.modal('toggle');
				                	//getData(limit,offset);	
				                	
				                	
				                }else{
				                  window.location.href='';
				                		
				                }
				               // $.growlUI(data.msg); 
				            }
				        });
              				
              			
              		});
</script>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h3>Change Password</h3>
</div>
<form id="setPstat" name="setPstat" class="form-horizontal no-margin">
<div class="modal-body">
<div class="row-fluid">
		<div class="alert alert-error" id="errorDiv" style="display: none;"></div>
	<div class="control_group">
										<label class="control_label">Password:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="password" id="password" name="password" class="m_wrap wid360" >
											<span for="note" id="noteerror" class="help-inline no-margin" style="display: none;color: #B94A48;">This field is required.</span>
										</div>										
										<div class="clear"></div>
									</div>
									
									
									<div class="control_group">
										<label class="control_label">Confirm Password:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="password" id="cpassword" name="cpassword" class="m_wrap wid360">
											<span for="note" id="noteerror" class="help-inline no-margin" style="display: none;color: #B94A48;">This field is required.</span>
										</div>										
										<div class="clear"></div>
									</div>
		
</div>
</div>
<div class="modal-footer">
	<button type="button" data-dismiss="modal" class="btn">Close</button>
	<input type="hidden" id="business_id" name="business_id" value="<?php echo @$bar_id ?>" />
	<button type="button" class="btn blue" id="submitSet"><i class="icon-ok"></i> Submit</button>
	
</div>
</form>

