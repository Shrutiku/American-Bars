 <script src="//www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit" async defer></script>
	<script type="text/javascript">
    var CaptchaCallback = function(){
        grecaptcha.render('captcha_img', {'sitekey' : '6LcjQAoTAAAAAMeqHoabD3bRBJuuQciyIbnaZFkU'});
        grecaptcha.render('captcha_img2', {'sitekey' : '6LcjQAoTAAAAAMeqHoabD3bRBJuuQciyIbnaZFkU'});
    };
    </script>

<script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'white'
 };
 </script>
 <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js" ></script>
<script type="text/javascript">
 $(document).ready(function() { 
		   $("#phone_number").inputmask("(999) 999-9999");
	});
	$(document).ready(function(){
//===== Usual validation engine=====//
	$("#beer_suggest").validate({
		rules: {			
			bar_name: {
				required: true,
			},			
			address: {
				required: true,
			},	
			state: {
				required: true,
			},	
			city: {
				required: true,
			},	
			phone_number: {
				required: true,
               
			},
			description:{
			    required: true,
			},
			zip_code: {
				required: true,
				number:true,
			},
				
		  	errorClass:'error fl_right'			
		}
	});	
});
</script>
<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/ckeditor/ckeditor.js"></script>
<script>
	$(document).ready(function() {
		 $('#frm_sug').on('submit', function() {
        	
                    CKEDITOR.instances[instanceName].updateElement();
            });
		
});
</script>
<!-- ########################################################################################### -->
<!-- content -->

<div class="wrapper row4">
   		<div class="container clearfix">
   			<div id="slider-fixed-banner" class="carousel slide">
        	<div class="carousel-inner">
          	<div class="active item">
            	 <?php /* $getimagename = getimagenamebanner();?>	
          	  <?php 
									if($getimagename->suggest_bar!="" && is_file(base_path().'upload/bar_pages_banner_orig/'.$getimagename->suggest_bar)){ ?>
										<img src="<?php echo base_url().'upload/bar_pages_banner/'.$getimagename->suggest_bar; ?>"   />
									<?php
									} else {?>
            	<img src="<?php echo base_url(); ?>/default/images/smallbanner1.png" alt="American Bars"/>
            	<?php } */
            	$v=0;
          $getad_banner = '';
            	$getad_banner = getadvertisementBannerSearchBar('find_suggest_bar'); 
				if($getad_banner){
					
						 ?>
							<?php 
	     				$count = getadvertisementBannerByIDCount(@$getad_banner['banner_pages_id'],$getad_banner['type']);
						if($getad_banner['type']=='click')
						{
							$cnt = $getad_banner['number_click'];
						}
						else
						{
							$cnt = $getad_banner['number_visit'];
						}
						
						$getad_new = getadvertisementByID_banner(@$getad_banner['banner_pages_id'],'visit');
		
						if(($getad_new==0 || $getad_new<5) && $count<$cnt && $getad_banner['type']=='visit' && $getad_banner['type']!='')
						{
							$array = array('ip'=>$_SERVER['REMOTE_ADDR'],'datetime'=>date('Y-m-d H:i:s'),'banner_pages_id'=>$getad_banner['banner_pages_id'],'click_type'=>'visit');
							$this->db->insert('count_clcik_advertisement_banner',$array);
							
							$array1 = array('total_visit'=>$getad_banner['total_visit']+1);
							$this->db->where('banner_pages_id',$getad_banner['banner_pages_id']);
							$this->db->update('banner_pages_master',$array1);
						}
						
						$v= 1;
	     				if($getad_banner && $count<$cnt){ ?>
	     					<?php if(($getad_banner['banner_pages_image']!='' && file_exists(base_path().'upload/banner_pages_thumb/'.$getad_banner['banner_pages_image']))){ ?>
	     						<a target="_blank" <?php if($getad_banner['type']=='click'){?>onclick="add_click_banner('<?php echo $getad_banner['banner_pages_id'];?>');"<?php } ?> href="<?php echo $getad_banner['url']; ?>"><img src="<?php echo base_url().'upload/banner_pages_thumb/'.$getad_banner['banner_pages_image']; ?>" class="img-responsive"/></a>
	     					<?php } ?>	
	     					<?php } else { ?>
		     		 <img src="<?php echo base_url().'upload/banner_pages_thumb/'.$getad_banner['banner_pages_image']; ?>" class="img-responsive"/>
		     			
		     			  <?php } }  else { 
		     			  	$v= 0;?>
		     			  <!-- <img src="<?php echo base_url(); ?>/default/images/smallbanner1.png" alt="American Dive Bars"/> -->
		     			  	<?php } ?>
							
						
				<div class="clearfix"></div>  
          </div>
        </div>
        <!-- <a class="left carousel-control" href="#slider-fixed-banner" data-slide="prev">&lsaquo;</a>
        <a class="right carousel-control" href="#slider-fixed-banner" data-slide="next">&rsaquo;</a> -->
       
   	</div>
	</div>
  </div>
<div class="wrapper row5">
     	<div class="container">
     	  <div class="">
     	   <div class="textbox_block">
     		<div class="result_search">
	     		<div class="result_search_text">Suggest A Bar</div>
     		</div>
     		<div class="text-center pad_t15b20">
     			<?php  
     				$msg = $this->session->flashdata('msg');
     				if($msg != "") {
						
						if($msg == 'success') {
						
							echo '<div class="success"><p>Your bar suggestion was sent. We will be reviewing it as soon as possible. Allow for up to 72 hours in order for us to approve or deny it, then if it is approved it will then be searchable in our database.</p></div>';
							
						}
					
					}
					
					if($error != "") {
						
						if($error == 'insert') {
							echo '<div class="success"><p>Record has been updated Successfully.</p></div>';
						}
					
						if($error != "insert"){	
							echo '<div class="error1">'.$error.'</div>';	
						}
					}
				?>		
				
     			<?php $attributes = array('id'=>'beer_suggest','name'=>'beer_suggest','class'=>'form-horizontal','rolde'=>'form');
							echo form_open_multipart('bar/suggest_bar/',$attributes); ?>
			  <input type="hidden" name="url" id="url" value="<?php echo @$_SERVER['HTTP_REFERER']; ?>">
	            	
							
	     				<div class="error1 hide1 center" id="cm-err-main1_sug">&nbsp;</div>
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
	        				 		<label class="control-label">Address : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class=" col-sm-7">
	                           		<textarea rows="5" placeholder="Address" class="form-control form-pad" name="address"  id="address"><?php echo @$address; ?></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">City : <span class="aestrick"> * </span></label>
	        				 	</div>
	        				 	<div class=" col-sm-7">
	                       		<input type="text" class="form-control form-pad" value="<?php echo @$city; ?>" id="city" name="city">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">State : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class=" col-sm-7">
	                           		<input type="text" class="form-control form-pad" value="<?php echo @$state; ?>" id="state" name="state">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Phone Number : <span class="aestrick"> * </span></label>
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
	                           		<div id="captcha_img"></div><div class="clearfix"></div>
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
     		
     		<div class="clearfix"></div>
   		</div>
   	</div>
<script>
		 function add_click_banner(id)
		{
			
		  // window.location.href = '<?php echo current_url();?>'; 
		   $.ajax({
	       type: "POST",
		   url: "<?php echo site_url('home/add_clcik_banner')?>",
		   data : {id:id},
		   dataType : 'JSON',
		   success: function(response) {
		    
		     
		  }
	   });
	  }
</script>