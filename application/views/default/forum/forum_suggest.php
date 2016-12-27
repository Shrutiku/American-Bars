<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/ckeditor/ckeditor.js"></script>
	

<div class="padtb10">
     	<div>
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				
	        			<div id="signup-form" class="signup">
	        				<div class="result_search">
	        					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	     				<i class="strip login_icon"></i><div class="result_search_text" >Forum Topic</div>
     				</div> 
     				<div class="pad20">
					<!-- <h1 class="yellow_title padb10 br_bott_gray text-center">Sign Up</h1> -->
					<?php $attributes = array('id'=>'beer_suggest','name'=>'beer_suggest','class'=>'form-horizontal','rolde'=>'form');
							echo form_open('forum/forumsuggest',$attributes); ?>	
							
	     				<div class="error1 hide1 center" id="cm-err-main1_sug">&nbsp;</div>
	        				<div id="ajax_msg_error_reg1_sug"></div>
	        				<div class="">
	        				 <div class="padtb8">
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Category : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<select  id="forum_category" name="forum_category" class="form-control form-pad">
	                           			<option value="">--Select Category--</option>
	                           			<?php if($category){
     								   foreach($category as $cat){?>
     							
     							<option value="<?php echo $cat->forum_category_id;?>" <?php if($type==$cat->forum_category_id){ echo "selected"; }?>><?php echo $cat->forum_category_name;?></option> 
     							<?php } } ?>
	                           		</select>	
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	
	                       	
	                       	<div class="padtb8">
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Topic Name : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<input type="text" value="" id="topic_name" name="topic_name" class="form-control form-pad">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	 	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Description :  <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="col-sm-7">
	                           		<textarea rows="5" name="forum_decription" id="forum_decription" placeholder="Desription" class="form-control form-pad ckeditor"></textarea>
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
   	

<script>
$(document).ready(function() {
	  
		    var form1 = $('#beer_suggest');
		    form1.on('submit', function() {
                    CKEDITOR.instances['forum_decription'].updateElement();
            });
		    var base = '<?php echo base_url();?>';
            var error1 = $('.alert-error', form1);
            var success1 = $('.alert-success', form1);
            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-inline', // default input error message class
                focusInvalid: '', // do not focus the last invalid input
                ignore: "",
                rules: {
                	topic_name: {required: true},
                	forum_category: {required: true},
                	 
                	forum_decription: {
                        required: true,
                   }, 
                  
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
						$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
							$.growlUI('Your forum topic send successfully please wait for AB approval.');
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