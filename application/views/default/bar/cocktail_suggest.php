 <script src="//www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit" async defer></script>
	<script type="text/javascript">
    var CaptchaCallback = function(){
        grecaptcha.render('captcha_img', {'sitekey' : '6LcjQAoTAAAAAMeqHoabD3bRBJuuQciyIbnaZFkU'});
        grecaptcha.render('captcha_img2', {'sitekey' : '6LcjQAoTAAAAAMeqHoabD3bRBJuuQciyIbnaZFkU'});
    };
    </script>
<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/js/jquery_form.js"></script>
<script>
jQuery(document).ready(function() {
	
		    var form1 = $('#cocktail_suggest');
		    var base = '<?php echo base_url();?>';
            var error1 = $('.alert-error', form1);
            var success1 = $('.alert-success', form1);
            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-inline', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                	cocktail_name: {required: true},
                	//ingredients: {required: true},
                	 
                	//how_to_make_it: {
                  //      required: true,
                  // },                   
                   // base_spirit: {                        
                  //      required: true,
                   // },
                    
                	//type: {
                	//	required: true,
                	//	},
                	
                	//served: {
                	//	required: true,
                	//},
                	//preparation: {
                	////	required: true,
                	//},
                //	strength: {
                	//	required: true,
                //	},
                //	difficulty: {
                //		required: true,
                //	},
                //	flavor_profile: {
                //		required: true,
                //	},
                	
                	beer_image: {
                	//	required: true,
                		 accept: "jpg|jpeg|png|bmp"
                	},
                	recaptcha_response_field: {
				required: true,
			},
                	
                	// cocktail_meta_title: {
						// required: true,
					// },
					// cocktail_meta_keyword: {
						// required: true,
					// },
					// cocktail_meta_description: {
						// required: true,
					// },	
                
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
						//	$.growlUI('Your seggestion send successfully please wait for ADB approval.');
						$("#suggest_message").html("<div style='width:100%' class='error1 text-center'><a class='closemsg' data-dismiss='alert'></a><span>Your cocktail suggestion sent successfully. Please wait for admin approval.</span></div>");
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
	     				<i class="strip login_icon"></i><div class="result_search_text" >Cocktail Suggest</div>
     				</div> 
     				<div class="pad20">
					<!-- <h1 class="yellow_title padb10 br_bott_gray text-center">Sign Up</h1> -->
					<?php $attributes = array('id'=>'cocktail_suggest','name'=>'cocktail_suggest','class'=>'form-horizontal','rolde'=>'form');
							echo form_open_multipart('bar/cocktailsuggest',$attributes); ?>	
							
	     				<div class="error1 hide1 center" id="cm-err-main1_sug">&nbsp;</div>
	        				<div id="ajax_msg_error_reg1_sug"></div>
	        				<div class="">
	        				 <div class="padtb8">
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Cocktail Name : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<input maxlength="100" type="text" value="" id="cocktail_name" name="cocktail_name" class="form-control form-pad">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	
	                       	 	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Ingredients :  </label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<textarea rows="5" name="ingredients" id="ingredients" placeholder="Ingredients" class="form-control form-pad"></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">How To Make It :  </label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<textarea rows="5" name="how_to_make_it" id="how_to_make_it" placeholder="Description" class="form-control form-pad"></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb8">
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Base Spirit : </label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<input type="text" value="" id="base_spirit" name="base_spirit" class="form-control form-pad">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	<div class="padtb8">
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Type : </label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<input type="text" value="" id="type" name="type" class="form-control form-pad">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb8">
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Served : </label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<input type="text" value="" id="served" name="served" class="form-control form-pad">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb8">
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Preparation : </label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<input type="text" value="" id="preparation" name="preparation" class="form-control form-pad">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb8">
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Strength : </label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<input type="text" value="" id="strength" name="strength" class="form-control form-pad">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb8">
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Difficulty : </label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<input type="text" value="" id="difficulty" name="difficulty" class="form-control form-pad">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb8">
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Flavor Profile : </label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<input type="text" value="" id="flavor_profile" name="flavor_profile" class="form-control form-pad">
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
	                           		<input type="text" class="form-control form-pad" id="cocktail_meta_title" name="cocktail_meta_title" value="<?php echo @$cocktail_meta_title; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       		<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Meta Keyword : </label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="cocktail_meta_keyword" name="cocktail_meta_keyword" value="<?php echo @$cocktail_meta_keyword; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Meta Description : </label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<textarea rows="5" placeholder="Meta Description" name="cocktail_meta_description" id="cocktail_meta_description" class="form-control form-pad"><?php echo @$cocktail_meta_description; ?></textarea>
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