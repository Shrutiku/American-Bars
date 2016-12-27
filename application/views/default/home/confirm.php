<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
//===== Usual validation engine=====//
	$("#frm_login").validate({
		rules: {			
			email: {
				required: true,
				email: true
			},			
			password: {
				required: true,
				
			},				
		  	errorClass:'error fl_right'			
		}
	});	
});
</script>
<!-- ########################################################################################### -->
<!-- content -->
 <?php  /* $getimagename = getimagenamebanner();?>	
          	  <?php 
									if($getimagename->beer_directory_state==1 && $getimagename->beer_directory!="" && is_file(base_path().'upload/bar_pages_banner_orig/'.$getimagename->beer_directory)){ ?>
										<img src="<?php echo base_url().'upload/bar_pages_banner/'.$getimagename->beer_directory; ?>"   />
									<?php
									} else {?>
            	<!-- <img src="<?php echo base_url(); ?>/default/images/smallbanner1.png" alt="American Bars"/> -->
            	<?php } */ 
            	$v=0;
          $getad_banner = '';
            	$getad_banner = getadvertisementBannerSearchBar('bar_owner_register');
				
				if($getad_banner){
					
						 ?>
<div class="wrapper row4">
   		<div class="container clearfix">
   			<div id="slider-fixed-banner" class="carousel slide">
        	<div class="carousel-inner">
          	<div class="active item">
            	
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
		     			
		     			  <?php }   
		     			  ?>
		     			  <!-- <img src="<?php echo base_url(); ?>/default/images/smallbanner1.png" alt="American Dive Bars"/> -->
							
						
				<div class="clearfix"></div>    
          </div>
        </div>
        <!-- <a class="left carousel-control" href="#slider-fixed-banner" data-slide="prev">&lsaquo;</a>
        <a class="right carousel-control" href="#slider-fixed-banner" data-slide="next">&rsaquo;</a> -->
       
   	</div>
	</div>
  </div>
  <?php } ?>
	<div class="wrapper row5 beer-list" style="border:<?php echo $v==0 ? 'none':'';?>">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<?php 
     			
     			if($get_user_info->user_type=='bar_owner'){
     				$get_bar_info = get_bar_info($get_user_info->user_id);
     				if($get_bar_info->bar_type=='full_mug'){
     				?>
	        				 <p style="text-align: center; margin-bottom: 10px; font-size: 20px; color: green;">Congratulations! Your Payment is Successful</p>	
	        				 <?php } } ?>
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
	     				<i class="strip login_icon"></i><div class="result_search_text">Registration</div>
     				</div>
     				
     				<div>
     					
     					
     				</div>
					<?php if($error!=""){ ?>
                        <div class="error text-center"><?php echo $error; ?></div>
                        <?php }?>
                        
                      
     				<div class="pad20">
					<?php $attributes = array('id'=>'frm_login','name'=>'frm_login','class'=>'form-horizontal text-center','rolde'=>'form');
							echo form_open('home/registration_step5/'.base64_encode($user_id),$attributes); ?>	
	     					
	                       
	                       
	                       <div class="padtb con_detail marlr25">
	                       	<?php if($get_user_info->user_type=='bar_owner'){?>
	        				 	Please check your email for confirmation code.
	        				 <?php } else {?>
	        				 	Please check your email for confirmation code.
	        				 <?php } ?>		
	                       	</div>
	                       	
	                       	
	                       	<input type="hidden" name="user_id" id="user_id" value="<?php echo $get_user_info->user_id; ?>" />
	                       	<div class="padtb mar_top20">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Confirmation Code :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="code" name="code" placeholder="Enter Code">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10">
	                       			<input type="submit" name="submit" id="submit" value="Check"  class="btn btn-lg btn-primary"/>
	                       			<!-- <a class="btn btn-lg btn-primary" href="#">Cancel</a> -->
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	        			</form>
	        		</div>
     			</div>
     		</div>
   		</div>
   	</div>
<!-- ************************************************************************ -->