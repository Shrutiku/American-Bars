 <script src="//www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit" async defer></script>
	<script type="text/javascript">
    var CaptchaCallback = function(){
        grecaptcha.render('captcha_img', {'sitekey' : '6LcjQAoTAAAAAMeqHoabD3bRBJuuQciyIbnaZFkU'});
        grecaptcha.render('captcha_img2', {'sitekey' : '6LcjQAoTAAAAAMeqHoabD3bRBJuuQciyIbnaZFkU'});
    };
    </script>
<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/js/jquery_form.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js" ></script>
<script>
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
                	beer_name: {required: true},
                	beer_country: {required: true},
                	//bar_desc: {required: true},
                	 
                	//beer_type: {
                        //required: true,
                   //}, 
                   //beer_desc: {
                   //     required: true,
                   //},                   
                   // abv: {                        
                   //     required: true,
                   // },
                    
                	//producer: {
                	//	required: true,
                	//	},
                	
                	//city_produced: {
                	//	required: true,
                	//},
                	//beer_state: {
                	//	required: true,
                	//},
                	//beer_website: {
                	//	required: true,
                	//	url:true,
                	//},
                	beer_image: {
                		
                		 accept: "jpg|jpeg|png|bmp"
                	},
                	recaptcha_response_field: {
				required: true,
			},
                	// beer_meta_title: {
						// required: true,
					// },
					// beer_meta_keyword: {
						// required: true,
					// },
					// beer_meta_description: {
						// required: true,
					// },	
                	// phone_no: {
                		// required: true,
                		// number:true
                		// }
                	//question: {required: true}
                    
                      
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
						
						$("#cm-err-main1_sug").show();
						$("#cm-err-main1_sug").html(json.comment_error);
			    		$('#dvLoading').fadeOut('slow')
				  		setTimeout(function () 
						{
						      $("#cm-err-main1_sug").fadeOut('slow');
						}, 3000);
					return false;
					}
			
					else
					{
						grecaptcha.reset();
						$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
						//$("#suggest_message").html("Your beer suggestion send successfully. Please wait for admin approval.");
						$("#suggest_message").html("<div style='width:100%' class='error1 text-center'><a class='closemsg' data-dismiss='alert'></a><span>Your beer suggestion sent successfully. Please wait for admin approval.</span></div>");
						$(':input','#form')
					 	.not(':button, :submit, :reset, :hidden')
					 	.val('')
					 	//.removeAttr('checked')
					 	.removeAttr('selected');
					 	setTimeout(function () 
						{
						      $("#cm-err-main1_sug").fadeOut('slow');
						}, 3000);
						$('#suggestmodal').modal('hide');
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
	     				<i class="strip login_icon"></i><div class="result_search_text" >Beer Suggest</div>
     				</div> 
     				<div class="pad20">
					<!-- <h1 class="yellow_title padb10 br_bott_gray text-center">Sign Up</h1> -->
					<?php $attributes = array('id'=>'beer_suggest','name'=>'beer_suggest','class'=>'form-horizontal','rolde'=>'form');
							echo form_open_multipart('bar/beersuggest',$attributes); ?>	
							
	     				<div class="error1  center" style="display: none;" id="cm-err-main1_sug">&nbsp;</div>
	        				<div id="ajax_msg_error_reg1_sug"></div>
	        				<div class="">
	        				 <div class="padtb8">
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Beer Title : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<input maxlength="100" type="text" value="" id="beer_name" name="beer_name" class="form-control form-pad">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	
	                       	 	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Description :  </label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<textarea rows="5" name="beer_desc" id="beer_desc" placeholder="Description" class="form-control form-pad"></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb8">
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Type : </label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<input type="text" value="" id="beer_type" name="beer_type" class="form-control form-pad">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	<div class="padtb8">
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">ABV : </label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<input type="text" value="" id="abv" name="abv" class="form-control form-pad">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb8">
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Brewed by : </label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<input type="text" value="" id="producer" name="producer" class="form-control form-pad">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	
	                       
	                       	
	                       	<div class="padtb8">
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">City Produced : </label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<input type="text" value="" id="city_produced" name="city_produced" class="form-control form-pad">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb8">
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">State : </label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<input type="text" value="" id="beer_state" name="beer_state" class="form-control form-pad">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       		<div class="padtb8">
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Country : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<input type="text" value="" id="beer_country" name="beer_country" class="form-control form-pad">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb8">
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Website : </label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<input type="text" value="" id="beer_website" name="beer_website" class="form-control form-pad">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<!-- <div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Meta Title : </label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="beer_meta_title" name="beer_meta_title" value="<?php echo @$beer_meta_title; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       		<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Meta Keyword : </label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="beer_meta_keyword" name="beer_meta_keyword" value="<?php echo @$beer_meta_keyword; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Meta Description : </label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<textarea rows="5" placeholder="Meta Description" name="beer_meta_description" id="beer_meta_description" class="form-control form-pad"><?php echo @$beer_meta_description; ?></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div> -->
	                       	
	                       	<div class="padtb8">
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Image : </label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<input accept="image/*" type="file" value="" id="beer_image" name="beer_image" class="form-control form-pad">
	                       		</div>
	                       		<div class="clearfix"></div>
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
	                       		<div class="col-sm-3 text-right">
	        				 		<label class="control-label"></label>
	        				 	</div>
	                       		<div class="col-sm-7">
									<button class="btn btn-lg btn-primary">Save</button>									
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                      </div> 	
	                      
	                     
	        			</form>
	        			</div>
	        			
	        			
	        		</div>
     			</div>
     		</div>
   		</div>
   	</div>