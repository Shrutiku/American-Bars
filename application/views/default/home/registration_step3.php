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
<?php 	$v=0;
          $getad_banner = '';
            	$getad_banner = getadvertisementBannerSearchBar('bar_owner_register');
				
				if($getad_banner){ ?>
<div class="wrapper row4">
   		<div class="container clearfix">
   			<div id="slider-fixed-banner" class="carousel slide">
        	<div class="carousel-inner">
          	<div class="active item">
            	 <?php  /* $getimagename = getimagenamebanner();?>	
          	  <?php 
									if($getimagename->beer_directory_state==1 && $getimagename->beer_directory!="" && is_file(base_path().'upload/bar_pages_banner_orig/'.$getimagename->beer_directory)){ ?>
										<img src="<?php echo base_url().'upload/bar_pages_banner/'.$getimagename->beer_directory; ?>"   />
									<?php
									} else {?>
            	<!-- <img src="<?php echo base_url(); ?>/default/images/smallbanner1.png" alt="American Bars"/> -->
            	<?php } */ 
            
					
						 ?>
							<?php 
	     				$count1 = getadvertisementBannerByIDCount(@$getad_banner['banner_pages_id'],$getad_banner['type']);
						if($getad_banner['type']=='click')
						{
							$cnt = $getad_banner['number_click'];
						}
						else
						{
							$cnt = $getad_banner['number_visit'];
						}
						
						$getad_new = getadvertisementByID_banner(@$getad_banner['banner_pages_id'],'visit');
		
						if(($getad_new==0 || $getad_new<5) && $count1<$cnt && $getad_banner['type']=='visit' && $getad_banner['type']!='')
						{
							$array = array('ip'=>$_SERVER['REMOTE_ADDR'],'datetime'=>date('Y-m-d H:i:s'),'banner_pages_id'=>$getad_banner['banner_pages_id'],'click_type'=>'visit');
							$this->db->insert('count_clcik_advertisement_banner',$array);
							
							$array1 = array('total_visit'=>$getad_banner['total_visit']+1);
							$this->db->where('banner_pages_id',$getad_banner['banner_pages_id']);
							$this->db->update('banner_pages_master',$array1);
						}
						
						$v= 1;
	     				if($getad_banner && $count1<$cnt){ ?>
	     					<?php if(($getad_banner['banner_pages_image']!='' && file_exists(base_path().'upload/banner_pages_thumb/'.$getad_banner['banner_pages_image']))){ ?>
	     						<a target="_blank" <?php if($getad_banner['type']=='click'){?>onclick="add_click_banner('<?php echo $getad_banner['banner_pages_id'];?>');"<?php } ?> href="<?php echo $getad_banner['url']; ?>"><img src="<?php echo base_url().'upload/banner_pages_thumb/'.$getad_banner['banner_pages_image']; ?>" class="img-responsive"/></a>
	     					<?php } ?>	
	     					<?php } else { ?>
		     		 <img src="<?php echo base_url().'upload/banner_pages_thumb/'.$getad_banner['banner_pages_image']; ?>" class="img-responsive"/>
		     			
		     			  <?php }  ?>
							
						
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
     			<div class="login_block br_green_yellow" style="width:870px">
     				<div class="result_search">
	     				<i class="strip login_icon"></i><div class="result_search_text">Registration</div>
     				</div>
     				
     				<div>
     					<div>
     				<h1 class="yellow_title padb10 br_bott_gray text-center">Bar Details Verification</h1>
     				<div>
     					<ul class="registration_steplist">
     						<li><a >Step 1</a></li>
     						<li ><a>Step 2</a></li>
     						<li><a>Step Test</a></li>
     						<li class="active"><a>Step 3</a></li>
     						<li class="last" ><a>Step 4</a></li>
     						<div class="clearfix"></div>
     					</ul>
     				</div>
					<?php if($error!=""){ ?>
                        <div class="error text-center"><?php echo $error; ?></div>
                        <?php }?>
                        
                      
     				<div class="pad20">
					<?php $attributes = array('id'=>'frm_login','name'=>'frm_login','class'=>'form-horizontal','rolde'=>'form');
							echo form_open('home/registration_step3/'.base64_encode($bar_id).'/'.$type,$attributes); ?>	
	     					
	                       	<div class="padtb">
	                       		<!-- <h1 class="step_title">You have Selected a Full Mug Bar</h1> -->
	                       	<?php //print_r($getbardata);?>
	                       		<p class="bar_add">Bar Owner Name : <?php echo @$getbardata['first_name']." ".$getbardata['last_name']; ?></p>
	                       		<p class="bar_add">Bar Owner Email : <?php echo @$getbardata['email']; ?></p>
	                       		<p class="bar_add">Bar Type : <b><?php  if(base64_decode($type)==0){ echo "Half Mug Bar"; } else if(base64_decode($type)==1) { echo "Full Mug Bar"; } else if(base64_decode($type)==2){  echo "Managed Account"; }?> </b></p>
	                       		<p class="bar_add">Bar Name : <?php echo @$getbardata['bar_title']; ?></p>
	                       		<p class="bar_add">Bar Address : <?php echo @$getbardata['address']; ?></p>
	                       		
	        				 	<p class="bar_add">Bar Description :<?php echo @$getbardata['desc']; ?></p>
	        				 	<?php 
	        				 	
	        				
	        				 	if(base64_decode($type)>0){
	        				 		 ?>
	        				 	<h1 class="step_title mar_top20">Total Payment : $ <?php $site_seting = site_setting(); if(base64_decode($type)==1){ echo $site_seting->amount;} else if(base64_decode($type)==2){ echo $site_seting->managed_account_amount; } ?></h1>
	        				 	<?php } ?>
	                       	</div>
	                       
	                       
	                       	<input type="hidden" name="bar_id" id="bar_id" value="<?php echo $bar_id; ?>" />
	                       	<div class="padtb8">
	                       		<div class="col-sm-12 padding5 mart10">
                                <a class="btn btn-lg btn-primary btn-next pull-left" href="<?php echo site_url('home/registration_step2/'.$type.'/'.base64_encode($bar_id))?>"><i class="previous-arrow-icon"></i> Back</a>
	                       			<button type="submit" name="step2" id="step2" class="btn btn-lg btn-primary btn-next next-right">Next <i class="next-arrow-icon"></i></button>
	                       			
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