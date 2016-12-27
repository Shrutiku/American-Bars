<style>
	.signup .input_box {
    float: left;
    width: 280px;
}
</style>
<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/js/jquery_form.js"></script>
<input type="hidden" name="sess_id" id="sess_id" value="<?php echo check_user_authentication()=="" ? '0':'1';?>" />
	

<div class="padtb10">
     	<div>
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				
	        			<div id="signup-form" class="signup">
	        				<div class="result_search">
	        					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	     				<i class="strip login_icon"></i><div class="result_search_text" >Report This Bar</div>
     				</div> 
     				<div class="pad20">

					<!-- <h1 class="yellow_title padb10 br_bott_gray text-center">Sign Up</h1> -->
					
			
					<?php $attributes = array('id'=>'report_bars','name'=>'report_bars','class'=>'form-horizontal','rolde'=>'form');
							echo form_open_multipart('bar/add_report_bar',$attributes); ?>	
							<input type="hidden" name="bar_id" id="bar_id" value="<?php echo $bar_detail['bar_id'];?>" />
	     				<div class="error1 hide1 center" id="cm-err-main1_sug">&nbsp;</div>
	        				<div id="ajax_msg_error_reg1_sug"></div>
	        				<div class="radio_block text-left">
		        				<div class="padtb">
		        				 	<div>
		        				 		<h2 class="sign-title"><?php echo ucwords($bar_detail['bar_title']); ?> Bar Is : </h2>
		        				 	</div>
		                       		<div class="clearfix"></div>
		                       	</div>
		                       	
		                       	<div class="padtb">
	        				 	<div class="pull-left">
	        				 		<label class="control-label">Email : <span class="aestrick"> * </span></label>
	        				 	</div>
	        				 	
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" value="<?php echo $this->session->userdata('email'); ?>" id="email" name="email">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
		                       	<div class="padtb">
		        				 	<div>
		        				 		<div class="radio">
		        				 			<p><label><input checked="checked" type="radio" name="report_type" id="report_type1" value="Closed" onclick="hidetextbox()" />Closed</label></p>
		        				 			<p><label><input type="radio" name="report_type" id="report_type1" value="Has the Wrong Address" onclick="hidetextbox()" />Has the Wrong Address</label></p>
		        				 			<p><label><input type="radio" name="report_type" id="report_type1" value="Is not a Bar" onclick="hidetextbox()" />Is not a Bar</label></p>
		        				 			<p><label><input type="radio" name="report_type" id="report_type1" value="Other" onclick="opentextbox()" />Other</label></p>
		        				 			
		        				 		</div>
		        				 	</div>
		                       		<div class="clearfix"></div>
		                       	</div>
		                       	
		                       	<div class="padtb8" id="open" style="display: none">
		        				 	
		                       		<div>
		                           		<textarea class="form-control form-pad" id="desc" placeholder="Write description here...." name="desc" ></textarea>
		                       		</div>
		                       		<div class="clearfix"></div>
		                       	</div>
		                       	
		                       	<div class="padtb8">
		                       		<div class="col-sm-3"></div>
		                       		<div class="col-sm-7 mart10 text-left">
		                       			<!-- <input type="button" onclick="submitbar()" name="submit" id="submit" value="Save" class="btn btn-lg btn-primary marr_10" /> -->
		                       			<input type="submit"  name="submit" id="submit" value="Submit" class="btn btn-lg btn-primary marr_10" />
		                       		</div>
		                       		<div class="clearfix"></div>
		                       	</div>
		                       	<div class="clearfix"></div>
		                    </div>
	                     
	        			</form>
	        			</div>
	        			
	        			
	        		</div>
     			</div>
     		</div>
   		</div>
   	</div>
   	
<script>

$('document').ready(function()
		{
		$('#report_bars').validate(
		{
		rules: {
					email: {
						required: true,
						email:true,
					},
					desc: {
						required: true,
					},
						errorClass:'error fl_right'
				},
				
		submitHandler: function(form){
		$(form).ajaxSubmit({
		type: "POST",
		    	  beforeSend : function(){
			      $('#dvLoading').fadeIn('slow');
			   },
			   complete: function(){
			     $('#dvLoading').fadeOut('slow');
			    },      
        success: function(json)          //on receive of reply
            {
            	$('#getreportbar').modal('hide');
            	 $(':input','#add-comment')
			  .not(':button, :submit, :reset, :hidden')
			  .val('')
			  .removeAttr('checked')
			  .removeAttr('selected');
			  $.growlUI('<?php echo "Your bar report send successfully ."; ?>');
			  setTimeout(function() {
					      window.location.href = "<?php echo site_url('bar/lists');?>";
						}, 1000);
            	
			     
            } 
		    });
		  }
		});
		
});		
function opentextbox()
{
	$("#open").slideDown();
}
function hidetextbox()
{
	$("#open").slideUp();
}
function submitbar1()
{
if($('#sess_id').val()==0)
					{
						$('#loginmodal').modal('show');
						$('#getreportbar').modal('hide');
						return false;
					}
		else
		{	
			//$('#getreportbar').modal('show');		
			
		 $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>bar/add_report_bar",         //the script to call to get data          
	    data: $("#report_bars").serialize(),
        beforeSend : function(){
			      $('#dvLoading').fadeIn('slow');
			   },
			   complete: function(){
			     $('#dvLoading').fadeOut('slow');
			    },      
        success: function(json)          //on receive of reply
            {
            	$('#getreportbar').modal('hide');
            	 $(':input','#add-comment')
			  .not(':button, :submit, :reset, :hidden')
			  .val('')
			  .removeAttr('checked')
			  .removeAttr('selected');
			  $.growlUI('<?php echo "Your bar report send successfully ."; ?>');
			  setTimeout(function() {
					      window.location.href = "<?php echo site_url('bar/lists');?>";
						}, 1000);
            	
			     
            } 
		
        });
       }
  }      
</script>
