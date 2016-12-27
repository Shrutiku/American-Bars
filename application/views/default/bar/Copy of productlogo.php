
<div class="wrapper row6 padtb10 has-js">
     	<div class="container">
     		<div class="margin-top-50 bg_brown">
     		<?php if($this->session->userdata('user_type')!='taxi_owner'){?>	
     			<?php echo $this->load->view(getThemeName().'/home/dashboard_menu'); ?>
     		<?php } else {?>
     			<?php echo $this->load->view(getThemeName().'/home/dashboard_menu_taxi_owner'); ?>
     			<?php } ?>	
     			<div class="dashboard_detail">
     				<div class="result_search event"><div class="result_search_text"><i class="strip prod_logo"></i> Product Logo</div></div>
		     		<div class="dashboard_subblock">
		     			<div>
     						
     					
     					
					
				<div id="list_show" style="display: block;" >	
					<div class="error hide1 center" id="cm-err-main1">&nbsp;</div>
					<form name="add_event" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('bar/product_logo'); ?>">
     				<input type="hidden" name="b_id" id="b_id" value="<?php echo @$getbar['bar_id'];?>" />
		     			<div class=" pad_t15b20" id="chng_this">
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Cap Logo : </label>
	        				 	</div>
	                       		<div class="input_box upload_btn">
	                           		<input accept="image/*" type="file" class="form-control form-pad" id="cap_image" name="cap_image">
	                           		<input type="hidden" name="prev_cap_image" id="prev_cap_image" value="<?php echo @$getbar['cap_logo']; ?>" />
	                       		</div>
	                       		
	                       		<div class="input_box upload_user">
	                           			<?php
		          		if($getbar['cap_logo']!="" && file_exists(base_path().'upload/product_logo_thumb/'.@$getbar['cap_logo']))
					{?>
		            	<img height="60" width="60" class="img-responsive" src="<?php echo base_url()?>/upload/product_logo_thumb/<?php echo $getbar['cap_logo']; ?>" alt="American Dive Bars"/>
		            	<?php } ?>
	                       		</div>
	                       		<!-- <div class="input_box pull-left">
	                           		<button type="submit" class="btn btn-lg btn-primary " href="#">Upload</button> 
	                       		</div> -->
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Tshirt Logo : </label>
	        				 	</div>
	                       		<div class="input_box upload_btn">
	                           		<input accept="image/*" type="file" class="form-control form-pad" id="tshirt_image" name="tshirt_image">
	                           		<input type="hidden" name="prev_tshirt_image" id="prev_tshirt_image" value="<?php echo @$getbar['tshirt_logo']; ?>" />
	                       		</div>
	                       		
	                       		<div class="input_box upload_user">
	                       				<?php
		          		if($getbar['tshirt_logo']!="" && file_exists(base_path().'upload/product_logo_thumb/'.@$getbar['tshirt_logo']))
					{?>
		            	<img height="60" width="60" class="img-responsive" src="<?php echo base_url()?>/upload/product_logo_thumb/<?php echo $getbar['tshirt_logo']; ?>" alt="American Dive Bars"/>
		            	<?php } ?>
	                       		</div>
	                       		<!-- <div class="input_box pull-left">
	                           		<button type="submit" class="btn btn-lg btn-primary " href="#">Upload</button> 
	                       		</div> -->
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	
	                       	
	                       	<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10 text-left">
	                       			<button type="submit" class="btn btn-lg btn-primary marr_10" >Submit</button> 
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
     function getData()
	{
	//var keyword=($('#keyword').val()!='')?$('#keyword').val().split(' ').join('-'):'1V1';
	var url='<?php echo site_url('bar/product_logo'); ?>';
	$.ajax({
			url : url,
			cache: false,
			success : function(response) {
				// alert(response);
				$('#chng_this').html(response);
			},
	});
	
	}
    $(document).ready(function(){
    	      
        $('#form').validate(
		{
		rules: {
			
				  cap_image:
			      {
			      		image_validation : true,
			      },
			      tshirt_image:
			      {
			      		image_validation : true,
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
						$("#cm-err-main1").show();
						$("#cm-err-main1").html(json.comment_error);
			    		$('#dvLoading').fadeOut('slow')
				  		setTimeout(function () 
						{
						      $("#cm-err-main1").fadeOut('slow');
						}, 3000);
					return false;
					}
			
					else
					{
						//alert("sdsa");
						$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
						$.growlUI('Your product logo change successfully .');
						$(':input','#form')
					 	.not(':button, :submit, :reset, :hidden')
					 	.val('')
					 	//.removeAttr('checked')
					 	.removeAttr('selected');
					 	getData()
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
