<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script src="https://maps.google.com/maps/api/js?v=3&sensor=false" type="text/javascript"></script>
<style>
	#map-canvas
	{
		/*width: 500px;*/
		height: 500px;
	}
</style>
<script type="text/javascript">

	$(document).ready(function(){
		initialize();
		codeAddress();
		
 	
  var geocoder;
  var map;
  function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var mapOptions = {
      zoom: 8,
      center: latlng
    }
    map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
  }

  function codeAddress() {
    var address = '<?php echo mysql_real_escape_string($site_setting->site_address);?>';
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }
});

/*===== Usual validation engine=====//
	$("#frm_cnt").validate({
		rules: {			
			name: {
				required: true,
			},			
			email: {
				required: true,
			},	
			subject: {
				required: true,
			},	
			message: {
				required: true,
			},
		  	errorClass:'error fl_right'			
		}
	});	
});*/
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
									if($getimagename->contact_us_state==1 && $getimagename->contact_us!="" && is_file(base_path().'upload/bar_pages_banner_orig/'.$getimagename->contact_us)){ ?>
										<img src="<?php echo base_url().'upload/bar_pages_banner/'.$getimagename->contact_us; ?>"   />
									<?php
									} else {?>
            	<?php } */ 
            		$v=0;
          $getad_banner = '';
            	$getad_banner = getadvertisementBannerSearchBar('find_contact_us'); 
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
<div class="wrapper row5"  style="border:<?php echo $v==0 ? 'none':'';?>">
     	<div class="container">
     	<div class="beer_details">
     		<div class="result_search">
	     		<div class="result_search_text">Contact Us</div>
     		</div>
     		<div class="contact">
     			<div class="text-center cont_desc pad_lr10 pad_t15b20">
     				Looking to spend some time at the American Bars? We’d love to hear from you! Feel free to contact us at any of the links below, and we will get back to you as soon as possible.
     			</div>
     			<div class="col-md-3 col-sm-4 padb20">
			        <div class="cont_block">
			        	<div class="cont_circle"><i class="strip location"></i></div>
			        	<div class="send_label">
			        		Address
			        	</div>
			        	<div class="cont_desc" style="font-size: 19px;">
			        		<?php echo $site_setting->site_address;?>
			        		<!-- <p style="margin-bottom: 0px;">249 East Ocean Blvd., Suite 670</p>
			        		<p style="margin-bottom: 0px;">Long Beach, California 90802</p> -->
			        	</div>
			        </div>
			   	</div><!-- /.col-lg-3 -->
			   	<div class="col-md-3 col-sm-4 padb20">
			        <div class="cont_block">
			        	<div class="cont_circle"><i class="strip phone"></i></div>
			        	<div class="send_label">
			        		Phone
			        	</div>
			        	<div class="cont_desc">
			        		<div>800.303.8803</div>
							
			        	</div>
			        </div>
			   	</div><!-- /.col-lg-3 -->
			   	<div class="col-md-3 col-sm-4 padb20">
			        <div class="cont_block">
			        	<div class="cont_circle"><i class="strip email"></i></div>
			        	<div class="send_label">
			        		E-Mail
			        	</div>
			        	<div class="cont_desc">
			        		<div><?php echo $site_setting->site_email;?></div>
			        		<!-- <div>
			        			Follow Us : 
			        			<a href="#" class="mar_r5"><img src="<?php echo base_url().getThemeName(); ?>/images/fb_icon.png"/></a>
			        			<a href="#" class="mar_r5"><img src="<?php echo base_url().getThemeName(); ?>/images/twitt_icon.png"/></a>
			        			<a href="#" class="mar_r5"><img src="<?php echo base_url().getThemeName(); ?>/images/linked_icon.png"/></a>
			        			<a href="#"><img src="<?php echo base_url().getThemeName(); ?>/images/google_icon.png"/></a>
			        			
			        		</div> -->
			        		
			        	</div>
			        </div>
			   	</div><!-- /.col-lg-3 -->
			   	<div class="col-md-3 col-sm-4 padb20">
			        <div class="cont_block">
			        	<div class="cont_circle"><i class="strip website"></i></div>
			        	<div class="send_label">
			        		Connect with us
			        	</div>
			        	<div class="cont_desc">
                        	<ul class="social_icon">
							         									    		 		<li><a href="https://www.facebook.com/AmericanDiveBars" target="_blank"><img src="<?php echo base_url().getThemeName(); ?>/images/result_fb.png" onmouseover="this.src='<?php echo base_url().getThemeName(); ?>/images/result_fb-hover.png'" onmouseout="this.src='<?php echo base_url().getThemeName(); ?>/images/result_fb.png'"></a></li>
							    		 		
							    		 								    		 		<li><a target="_blank" href="https://twitter.com/American_Bars"><img src="<?php echo base_url().getThemeName(); ?>/images/result_twitt.png" onmouseover="this.src='<?php echo base_url().getThemeName(); ?>/images/result_twitt-hover.png'" onmouseout="this.src='<?php echo base_url().getThemeName(); ?>/images/result_twitt.png'"></a></li>
							    		 								    		 		
							    		 		<li><a target="_blank" href="https://www.linkedin.com"><img src="<?php echo base_url().getThemeName(); ?>/images/result_linkln.png" onmouseover="this.src='<?php echo base_url().getThemeName(); ?>/images/result_linkln-hover.png'" onmouseout="this.src='<?php echo base_url().getThemeName(); ?>/images/result_linkln.png'"></a></li>
							    		 								    		 		
							    		 		<li><a https://plus.google.com/+AmericanDiveBars" target="_blank"><img src="<?php echo base_url().getThemeName(); ?>/images/result_google.png" onmouseover="this.src='<?php echo base_url().getThemeName(); ?>/images/result_google-hover.png'" onmouseout="this.src='<?php echo base_url().getThemeName(); ?>/images/result_google.png'"></a></li>
							    		 								    		 		
							    		 		<li><a href="https://in.pinterest.com/americandivebar/" target="_blank"><img src="<?php echo base_url().getThemeName(); ?>/images/result_p.png" onmouseover="this.src='<?php echo base_url().getThemeName(); ?>/images/result_p-hover.png'" onmouseout="this.src='<?php echo base_url().getThemeName(); ?>/images/result_p.png'"></a></li>
							    		 								    		 		
							    		 		<li><a target="_blank" href="https://instagram.com/americanbars/"><img src="<?php echo base_url().getThemeName(); ?>/images/result_instagram.png" onmouseover="this.src='<?php echo base_url().getThemeName(); ?>/images/result_instagram_hover.png'" onmouseout="this.src='<?php echo base_url().getThemeName(); ?>/images/result_instagram.png'"></a></li>
							    		 		
							    		 	
							    		 	<div class="clearfix"></div>
		    		 					</ul>
			        		<div><?php // echo "www.americanbars.com";?></div>
			        	</div>
			        </div>
			   	</div><!-- /.col-lg-3 -->
     			<div class="clearfix"></div>
     		  <div class="mar_left15">
     			<div class="review_mainblock img_br_yellow mar_r30">
     				<div class="result_search"><h1 class="result_search_text">Contact Form</h1></div>
     				<?php  
     				$msg = $this->session->flashdata('msg');
     				if($msg != "") {
						
						if($msg == 'success') {
						
							echo '<div class="success center"><p>Your inquiry send successfully .</p></div>';
							
						}
					
					}
					
					if($error != "") {
						
						if($error == 'insert') {
							echo '<div class="success center"><p>Record has been updated Successfully.</p></div>';
						}
					
						if($error != "insert"){	
							echo '<div class="error1">'.$error.'</div>';	
						}
					}
				?>	
     			 <div class="padtb20 pad_lr10">
     			 	<?php
				$attributes = array('id'=>'frm_cnt','name'=>'frm_cnt','class'=>'form-horizontal');
				echo form_open_multipart('home/contact_us/',$attributes);
			  ?>
			  	<div class="clearfix"></div>
     					
                   <div class="form-group">
                       <label for="inputEmail3" class="col-sm-3 control-label">Your Name : <span class="aestrick"> * </span></label>
                       <div class="col-sm-8 input_box">
                           <input type="text" class="form-control form-pad" id="name" name="name"  placeholder="Name" value="<?php echo @$name; ?>">
                       </div>
                       <div class="clearfix"></div>
                   </div>
                   <div class="form-group">
                       <label for="inputEmail3" class="col-sm-3 control-label">Your Email : <span class="aestrick"> * </span></label>
                       <div class="col-sm-8 input_box">
                           <input type="text" class="form-control form-pad" id="email" name="email" placeholder="Email" value="<?php echo @$email; ?>">
                       </div>
                       <div class="clearfix"></div>
                   </div>
                    <div class="form-group">
                       <label for="inputEmail3" class="col-sm-3 control-label">Subject : <span class="aestrick"> * </span></label>
                       <div class="col-sm-8 input_box">
                           <input type="text" class="form-control form-pad" id="subject" name="subject" placeholder="Subject" value="<?php echo @$subject; ?>">
                       </div>
                       <div class="clearfix"></div>
                   </div>
                   <div class="form-group">
                       <label for="inputEmail3" class="col-sm-3 control-label">Message : <span class="aestrick"> * </span></label>
                       <div class="col-sm-8 input_box">
                           <!-- <input type="text" class="form-control form-pad" id="inputEmail3" placeholder="State"> -->
                           <textarea class="form-control form-pad" id="message" name="message"  placeholder="Type Your Query Here" rows="5"><?php echo @$message; ?></textarea>
                       </div>
                       <div class="clearfix"></div>
                   </div>
                   
                   <div class="form-group">
	        				 <div class="col-sm-3 control-label">		 	</div>
	                       		<div class="input_box col-sm-8 captcha-block">
	                           		<div id="captcha_img2"></div><div class="clearfix"></div>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       		
	                       	</div>
                   <div class="form-group">
                       <label for="inputEmail3" class="col-sm-3 control-label mar_r15"></label>
                       <!-- <a href="#" class="btn btn-lg btn-primary pull-left marr_10">Send</a> -->
                       <input type="submit" name="submit" id="submit" class="btn btn-lg btn-primary pull-left marr_10" value="Submit" />
                  	   <!-- <a href="#" class="btn btn-lg btn-primary pull-left">Cancel</a> -->
                       <div class="clearfix"></div>
                   </div>
                  <div class="clearfix"></div>		
              	  </form>
              	</div>
     			</div>
     			<div class="review_mainblock img_br_yellow text-center">
     				<div id="map-canvas">
	     				<div class="result_search"><h1 class="result_search_text">Location</h1></div>
	     				
     				</div>
     			</div>
     			<div class="clearfix"></div>
     		</div>
     		</div>
     	</div>	
   		</div>
   	</div>
    <div class="modal fade" id="helpfindbar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <?php echo $this->load->view(getThemeName().'/bar/bar_suggest');?>
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