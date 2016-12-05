
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