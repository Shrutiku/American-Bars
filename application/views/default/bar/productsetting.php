
<div class="wrapper row6 padtb10 has-js">
     	<div class="container">
     		<div class="margin-top-50 bg_brown">
     		<?php if($this->session->userdata('user_type')!='taxi_owner'){?>	
     			<?php echo $this->load->view(getThemeName().'/home/dashboard_menu'); ?>
     		<?php } else {?>
     			<?php echo $this->load->view(getThemeName().'/home/dashboard_menu_taxi_owner'); ?>
     			<?php } ?>	
     			<div class="dashboard_detail">
     				<div class="result_search event"><div class="result_search_text"><i class="strip prod_logo"></i> Product Settings</div></div>
		     		<div class="dashboard_subblock">
		     			<div>
                        	<ul class="order-option-list">
                            	<li ><a href="<?php echo site_url('bar/all_orders');?>"><i class="strip all_orders"></i>
                                	<p>My Orders</p>
                                </a></li>
                                <li ><a href="<?php echo site_url('bar/product_logo');?>"><i class="strip prod_logo"></i>
                                	<p>Product Logo</p>
                                </a></li>
                                <li class="active"><a href="<?php echo site_url('bar/product_setting');?>"><i class="strip prod_setting"></i>
                                	<p>Product Setting</p>
                                </a></li>
                                <li><a href="<?php echo site_url('bar/paypal_setting');?>"><i class="strip paypal-setting"></i>
                                	<p>Paypal Setting</p>
                                </a></li>
                                <li><a href="<?php echo site_url('bar/myproduct');?>"><i class="strip my-products"></i>
                                	<p>My Products</p>
                                </a></li>
                                <div class="clearfix"></div>
                            </ul>
                        </div>
		     			<div>
     						
     					
     					
					
				<div id="list_show" style="display: block;" >	
					<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
					<form name="add_event" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('bar/product_setting'); ?>">
     				<input type="hidden" name="b_id" id="b_id" value="<?php echo @$getbar['bar_id'];?>" />
		     			<div class=" pad_t15b20" id="chng_this">
	                       	
	                       	<?php 
	                       	
	           
	                       	
	                       	
	                       //	print_r($result);
	                       	
	                       	if($result){ 
	                       		
	                       		if(multi_in_array('Trucker Hat', $result)) 

								{
	                       		?>
	                       		
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Trucker Hat : </label>
	        				 	</div>
	                       		<div class="padb10 col-sm-7">
				     				<div class="radio pull-left" style="margin-top: -4px;">
					     				<label>
					          				<input type="radio" <?php if(@$getbar['prcap']=='enable'){?>checked<?php } ?> id="prcap" name="prcap" value="enable"> Enable 
					        			</label>
				        			</div>
				        			<div class="radio pull-left">
					     				<label>
					          				<input type="radio" <?php if(@$getbar['prcap']=='disable'){?>checked<?php } ?> id="prcap" name="prcap" value="disable"> Disable
					        			</label>
				        			</div>
			        				<div class="clearfix"></div>
	        					</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       <?php } 
	                       
	                       if(multi_in_array('Tshirt', $result)) 

								{?>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Tshirt : </label>
	        				 	</div>
	                       		<div class="padb10 col-sm-7">
				     				<div class="radio pull-left" style="margin-top: -4px;">
					     				<label>
					          				<input type="radio" <?php if(@$getbar['prtshirt']=='enable'){?>checked<?php } ?> id="prtshirt" name="prtshirt" value="enable"> Enable 
					        			</label>
				        			</div>
				        			<div class="radio pull-left">
					     				<label>
					          				<input type="radio" <?php if(@$getbar['prtshirt']=='disable'){?>checked<?php } ?> id="prtshirt" name="prtshirt" value="disable"> Disable
					        			</label>
				        			</div>
			        				<div class="clearfix"></div>
	        					</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       		<?php  } } else {?>
	                       			 
	                       			 No any products founds.
	                       			 
	                       			<?php } ?>
	                       	
	                       	
	                       	
	                       	
	                       	<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10 text-left">
	                       			<button type="submit" class="btn btn-lg btn-primary marr_10" >Save</button> 
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="clearfix"></div>
     		</div>
     			</form>
     			</div>
     			
		     	</div>
     		</div>
     	<div class="clearfix"></div>
     </div>
   </div>
 </div>
<link href="<?php echo base_url().getThemeName(); ?>/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/js/jquery_form.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.easing.1.3.js"></script>
 <script>
  var img_width = 120;
  var img_height = 120;
  var image1 = 0;
  var image2 = 0;
 function checkImageValidation(){
		var _URL = window.URL;
			$("#cap_image").change(function (e) {
				//$("#see_hide").css("display", "block");
				var file, img;
				if ((file = this.files[0])) {
				
					img = new Image();
					img.onload = function () {
					//alert('width:'+this.width+'Height'+this.height);
					
					img_width = parseInt(this.width);
					img_height = parseInt(this.height);
					if(img_width >= 120 && img_height >=120 && img_width==img_height){
						image1=1;
					}
					};
					img.src = _URL.createObjectURL(file);
				}
			});
			
			$("#tshirt_image").change(function (e) {
				//$("#see_hide").css("display", "block");
				var file, img;
				if ((file = this.files[0])) {
				
					img = new Image();
					img.onload = function () {
					//alert('width:'+this.width+'Height'+this.height);
					
					img_width = parseInt(this.width);
					img_height = parseInt(this.height);
					if(img_width >= 120 && img_height >=120 && img_width==img_height){
						image2=1;
					}	
					};
					img.src = _URL.createObjectURL(file);
				}
			});
			
			
	}

$(document).ready(function(){	
	checkImageValidation();

	jQuery.validator.addMethod("image_validation", function(value, element) {
		if(img_width >= 120 && img_height >=120 && img_width==img_height && image1==1 && image2==1){
			return true;
		}	
		return false;
    //var test = null; //Perform your test here        
   // return this.optional(element) || test;
}, 'Image size must be greater than 120px by 120px and in square.');
});	
</script>   
    <script>
    
    $(document).ready(function(){
    	      
        $('#form').validate(
		{
		rules: {
				
			      
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
						$("#cm-err-main1").show();
						$("#cm-err-main1").html(json.comment_error);
			    		$('#dvLoading').fadeOut('slow');
			    		scrollToDiv('cm-err-main1');
				  		// setTimeout(function () 
						// {
						      // $("#cm-err-main1").fadeOut('slow');
						// }, 3000);
					return false;
					}
			
					else
					{
						//alert("sdsa");
						$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
						$.growlUI('Your product setting change successfully .');
					
					}
					$('#dvLoading').fadeOut('slow');
		   		 }
		    });
		  }
		})
		
		 $.validator.addMethod("loginRegex", function(value, element) {
		        return this.optional(element) || /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,16}$/.test(value);
		    }, "Provide atleast 1 Number, 1 Special character,1 Alphabet and between 8 to 16 characters.");
    });
   
</script>
