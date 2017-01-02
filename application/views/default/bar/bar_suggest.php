 <script src="//www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit" async defer></script>
	<script type="text/javascript">
    var CaptchaCallback = function(){
        grecaptcha.render('captcha_img', {'sitekey' : '6LcjQAoTAAAAAMeqHoabD3bRBJuuQciyIbnaZFkU'});
        grecaptcha.render('captcha_img2', {'sitekey' : '6LcjQAoTAAAAAMeqHoabD3bRBJuuQciyIbnaZFkU'});
    };
    </script>
        <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery_form.js"></script>

<script>
$(document).ready(function() { 
		   $("#phone_number").inputmask("(999) 999-9999");
	});
jQuery(document).ready(function() { 
	
		    var form1 = $('#beer_suggest');
		    // form1.on('submit', function() {
                    // CKEDITOR.instances['beer_desc'].updateElement();
            // });
		    var base = '<?php echo base_url();?>';
            var error1 = $('.alert-error', form1);
            var success1 = $('.alert-success', form1);
            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-inline', // default input error message class
                focusInvalid: '', // do not focus the last invalid input
                ignore: "",
                rules: {			
			bar_name: {
				required: true,
			},	
			address: {
				required: false,
			},	
			state: {
				required: false,
			},	
			city: {
				required: false,
			},	
			phone_number: {
				required: false,
			},
			// description:{
			    // required: true,
			// },
			zip_code: {
				required: false,
				number:true,
			},
			recaptcha_response_field: {
				required: true,
			},				
		  	errorClass:'error fl_right'			
		},
                
            submitHandler: function(form){   
                $(form).ajaxSubmit({
			
		type: "POST",
		   		 dataType : 'json',
				 beforeSubmit: function() 
				 {
		       		$('#dvLoading').fadeIn('slow');
		    	 },
		    	
		    	uploadProgress: function ( event, position, total, percentComplete ) {	
		        },
		    
		    	success : function ( json ) 
		    	{
		    		
					if(json.status == "fail")
					{
						$("#cm-err-main1_sug123").show();
						$("#cm-err-main1_sug123").html(json.comment_error);
			    		$('#dvLoading').fadeOut('slow')
				  		
					return false;
					}
			
					else
					{
						$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
							$.growlUI('Your suggestion send successfully please wait for ADB approval.');
						$(':input','#form')
					 	.not(':button, :submit, :reset, :hidden')
					 	.val('')
					 	//.removeAttr('checked')
					 	.removeAttr('selected');
					 	
						$('#helpfindbar').modal('hide');
					}
					$('#dvLoading').fadeOut('slow');
		   		 }
		    });
         }
         
		});	
		
		});		
		
	</script>
	

<div class="padtb10">
     	<div>
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				
	        			<div id="signup-form" class="signup">
	        				<div class="result_search">
	        					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	     				<i class="strip login_icon"></i><div class="result_search_text" >Help Us Find Bars</div>
     				</div> 
     				<div class="pad20">
     						<p style="color: #fff;">We need your help!</p>

                           <p style="color: #fff;">American Bars is on a mission to find every small and independently owned bar in America. We are a crowd sourcing website that needs you help to seek out every local watering hole we can find. So, if you can’t find a small bar or pub in our database, please take the time to go to our suggest a bar form and let us know about it. If we list the bar, we will give you credit as the person who helped.</p>
<p></p>

					<!-- <h1 class="yellow_title padb10 br_bott_gray text-center">Sign Up</h1> -->
					
			
					<?php $attributes = array('id'=>'beer_suggest','name'=>'beer_suggest','class'=>'form-horizontal','rolde'=>'form');
							echo form_open_multipart('bar/suggest_bar_ajax',$attributes); ?>	
							
	     				<div class="error1  center" style="display: none;" id="cm-err-main1_sug123">&nbsp;</div>
	        				<div id="ajax_msg_error_reg1_sug"></div>
	        				<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Bar Name : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class=" col-sm-7">
	                           		<input maxlength="200" type="text" class="form-control form-pad" id="bar_name" name="bar_name" value="<?php echo @$bar_name; ?>" >
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<!-- <div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Description : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class=" col-sm-7">
	                           		<textarea rows="5" placeholder="Description" name="description" id="description" class="form-control ckeditor form-pad"><?php echo @$description; ?></textarea>
	                           		<div class="clearfix"></div>
	                           		<span for="description" style="display: none" class="help-inline">This field is required.</span>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div> -->
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Street :</label>
	        				 	</div>
	                       		<div class=" col-sm-7">
	                           		<textarea rows="5" placeholder="Address" class="form-control form-pad" name="address"  id="address"><?php echo @$address; ?></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">City :</label>
	        				 	</div>
	        				 	<div class=" col-sm-7">
	                       		<input type="text" class="form-control form-pad" value="<?php echo @$city; ?>" id="city" name="city">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">State :</label>
	        				 	</div>
	                       		<div class=" col-sm-7">
	                           		<input type="text" class="form-control form-pad" value="<?php echo @$state; ?>" id="state" name="state">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Phone Number :</label>
	        				 	</div>
	                       		<div class=" col-sm-7">
	                           		<input type="text" class="form-control form-pad" value="<?php echo @$phone_number; ?>" id="phone_number" name="phone_number">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Zip Code : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class=" col-sm-7">
	                           		<input type="text" class="form-control form-pad" value="<?php echo @$zip_code; ?>" id="zip_code" name="zip_code" >
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 <div class="col-sm-3 text-right">
	        				 	</div>
	                       		<div class=" col-sm-7">
	                           		<?php //echo $captcha_img ?><div id="captcha_img"></div><div class="clearfix"></div>
	                           		<span style="display:none;" for="recaptcha_response_field" class="help-inline">This field is required.</span>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       		
	                       	</div>
	                       	<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10 text-left">
	                       			<input type="submit" name="submit" id="submit" value="Save" class="btn btn-lg btn-primary marr_10" />
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="clearfix"></div>
	                      
	                     
	        			</form>
	        			</div>
	        			
	        			
	        		</div>
     			</div>
     		</div>
   		</div>
   	</div>