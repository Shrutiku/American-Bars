
<style>
	.pad20 p{
		color:#ffffff;
		
	}
</style>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script>
	function changeblock(type)
	{
		//alert(type);
		if(type=='half')
		{
			 $("#full").removeClass('active');
			 $("#half").addClass('active');
			 $("#btype").val(0);
		}
		else
		{
			 $("#half").removeClass('active');
			 $("#full").addClass('active');
			 $("#btype").val(1);
		}
		
	}
</script>
<!-- ########################################################################################### -->
<!-- content -->
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
            	$v=0;
          $getad_banner = '';
            	$getad_banner = getadvertisementBannerSearchBar('bar_owner_register');
				
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
		     			  ?>
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
	<div class="wrapper row5 beer-list" style="border:<?php echo $v==0 ? 'none':'';?>">

     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
                <?php $attributes = array('id'=>'frm_login','name'=>'frm_login','class'=>'form-horizontal','rolde'=>'form');
							echo form_open('home/registration_step2',$attributes); ?>	
                <div class="promo-left">
                    <div class="<?php echo @$getbardatafeature['feature_id']==1 ? 'active':'';?>" onclick="changeblock('full');">
                        <img src="<?php echo base_url()."default/images/promo6.jpg"?>" alt="Upgrade to a Full Mug Today" />
                    </div>
                </div>
     			<div class="float-left login_block br_green_yellow">
     				<div class="result_search">
	     				<i class="strip login_icon"></i><div class="result_search_text">Registration</div>
     				</div>
     				
     				<div>
     				<h1 class="yellow_title padb10 br_bott_gray text-center">Bar Owner Registration Step 2</h1>
     				<div>
     					<ul class="registration_steplist">
     						<li class="active"><a href="<?php echo site_url('home/bar_owner_register')?>">Step 1</a></li>
     						<li><a href="<?php echo site_url('home/registration_step2')?>">Step 2 test</a></li>
     						<li><a href="<?php echo site_url('home/registration_step3')?>">Step 3</a></li>
     						<li class="last"><a href="<?php echo site_url('home/registration_step4')?>">Step 4</a></li>
     						<div class="clearfix"></div>
     					</ul>
     				</div>
					<?php if($error!=""){ ?>
                        <div class="error text-center"><?php echo $error; ?></div>
                        <?php }?>
                        
                      
     				<div class="pad20">
     				
					
							
	     					<input type="text" style="border: none; background-color:#2E2C26; color: #2E2C26; " name="btype" id="btype" value="<?php echo @$getbardatafeature['feature_id']!='' ? @$getbardatafeature['feature_id']:'';?>">
     					      <div class="register-newblock mar_top15 <?php echo @$getbardatafeature['feature_id']==1 ? 'active':'';?>" id="full" onclick="changeblock('full');">
		        				<div>
				     				<label class="register-newtitle marr_10 pull-left">Full Mug (Paid) Listing</label> <img src="<?php echo base_url().getThemeName(); ?>/images/true.png" class="true-sign pull-left mart10" />
				     				<div class="clearfix"></div>
		        				</div>
		        				<div class="padtb8_checkbox">
		        					<ul>
		        						<?php $getfull = gethalmugfeature('fullmug');
		        						if($getfull){
		        							foreach($getfull as $r){		        						?>
		        						<li><?php echo $r->fullmug;?></li>
		        						<?php } } ?>
		        						<div class="clearfix"></div>
		        					</ul>
		        				</div>
		        				<div class="text-right">
		        				 	<a href="javascript:void(0);" id="fullmug-button" class="btn-primary learn">Benefits of a Full Mug Listing</a>
		        				 </div>
		        			</div>
                            <br />
	        				<div class="register-newblock <?php if(isset($getbardatafeature['feature_id'])){ echo $getbardatafeature['feature_id'] ==0 ? 'active':'';}?>" id="half" onclick="changeblock('half');">
		        				<div>
				     				<label class="register-newtitle marr_10 pull-left">Free Listing</label><img src="<?php echo base_url().getThemeName(); ?>/images/true.png" class="true-sign pull-left mart10" />
				     				<div class="clearfix"></div>
		        				</div>
		        				<div class="padtb8_checkbox">
		        					<ul>
		        						<?php $gethalf = gethalmugfeature('halfmug');
		        						if($gethalf){
		        							foreach($gethalf as $r){		        						?>
		        						<li><?php echo $r->halfmug;?></li>
		        						<?php } } ?>
		        						<div class="clearfix"></div>
		        					</ul>
		        					
		        				</div>
		        				<div class="text-right">
		        				 <a href="javascript:void(0);" id="halfmug-button" class="btn-primary learn">Half Mug Details</a>
		        				 </div>
		                    </div>
		                    
		        			
		        			<span for="btype" style="display: none;" class="help-inline">This field is required.</span>
	                       	<!-- <div class="padtb8_checkbox">

	                       		<div class="padb10 mart10">
			     				<div class="col-sm-10"><label class="control-label reg-title">Half Mug Bar Features :</label></div>
			     				<div class="clearfix"></div>
	        				</div>
	                       		<div class="col-sm-4">
	        				 		<div class="checkbox">
			     						 <label>
			     						 	<?php // print_r($getbardatafeature_new);
											
											//print_r(explode(',',$getbardatafeature_new)); die;?>
			          							<input type="checkbox" value="5" name="choise_bar[]" <?php if($getbardatafeature!=''){if(in_array(5,explode(',',$getbardatafeature_new))){ echo "checked"; }} ?>> Social Media Link
			        					</label>
		        					</div>
	        				 	</div>
	        				 	<div class="col-sm-4">
	                           		<div class="checkbox">
			     						 <label>
			          							<input type="checkbox" value="6" name="choise_bar[]" <?php if($getbardatafeature!=''){if(in_array(6,explode(',',$getbardatafeature_new))){ echo "checked"; }} ?>> Bar Logo
			        					</label>
		        					</div>
	                       		</div>
	                       		
	                       	
	                      
	        				 	<div class="col-sm-4">
	        				 		<div class="checkbox">
			     						 <label>
			          							<input type="checkbox" value="7" name="choise_bar[]" <?php if($getbardatafeature!=''){if(in_array(7,explode(',',$getbardatafeature_new))){ echo "checked"; }} ?>> Url
			        					</label>
		        					</div>
	        				 	</div>
	        				 	<div class="clearfix"></div>
	                       	</div> -->
	        				 	 	<!--<div class="padtb8_checkbox">
	                       		<div class="col-sm-4">
	                           		<div class="checkbox">
			     						 <label>
			          							<input type="checkbox" value="8" name="choise_bar[]" <?php if($getbardatafeature!=''){if(in_array(8,explode(',',$getbardatafeature_new))){ echo "checked"; }} ?>> Image Gallery
			        					</label>
		        					</div>
	                       		</div>
	                       		<div class="col-sm-4">
	        				 		<div class="checkbox">
			     						 <label>
			          							<input type="checkbox" value="9" name="choise_bar[]" <?php if($getbardatafeature!=''){if(in_array(9,explode(',',$getbardatafeature_new))){ echo "checked"; }} ?>> Events
			        					</label>
		        					</div>
	        				 	</div>
	                       		
	        				 	
	                       		<div class="col-sm-4">
	                           		<div class="checkbox">
			     						 <label>
			          							<input type="checkbox" value="10" name="choise_bar[]" <?php if($getbardatafeature!=''){if(in_array(10,explode(',',$getbardatafeature_new))){ echo "checked"; }} ?>> Beers Served
			        					</label>
		        					</div>
	                       		</div>
	                       			<div class="clearfix"></div>
	                       	</div> -->
	                       	
	        				 	 	<!--<div  class="padtb8_checkbox">
	                       		<div class="col-sm-4">
	        				 		<div class="checkbox">
			     						 <label>
			          							<input type="checkbox" value="11" name="choise_bar[]" <?php if($getbardatafeature!=''){if(in_array(11,explode(',',$getbardatafeature_new))){ echo "checked"; }} ?>> Cocktail Served
			        					</label>
		        					</div>
	        				 	</div>
	        				 
	        				 	<div class="col-sm-4">
	                           		<div class="checkbox">
			     						 <label>
			          							<input type="checkbox" value="12" name="choise_bar[]" <?php if($getbardatafeature!=''){if(in_array(12,explode(',',$getbardatafeature_new))){ echo "checked"; }} ?>> Video
			        					</label>
		        					</div>
	                       		</div>
	                       		
	                       	
	        				 	<div class="col-sm-4">
	        				 		<div class="checkbox">
			     						 <label>
			          							<input type="checkbox" value="13" name="choise_bar[]"> Contact Form Email ID
			        					</label>
		        					</div>
	        				 	</div>
	                       		
	                       		<div class="clearfix"></div>
	                       	</div> -->
	                       	
	                       
	        				
	        				
	        					
	                       	
	                       		
	        				
	        				
	                       	<!--<input type="hidden" name="bar_id" id="bar_id" value="<?php echo $bar_id; ?>" />
	                       	<input type="hidden" name="bar_feature_id" id="bar_feature_id" value="<?php echo @$getbardatafeature['bar_feature_id'];?>" />-->
	                       	<div class="padtb8">
	                       		<div class="col-sm-7 mart10">
	                       			<input type="submit" name="step2" id="step2" value="Next" class="btn btn-lg btn-primary"/>
	                       			<a class="btn btn-lg btn-primary" href="<?php echo site_url('home/bar_owner_register')?>">Back</a>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	        			</form>
	        		</div>
     			</div>
     		</div>
            <div class="promo-left">
                <div class="<?php echo @$getbardatafeature['feature_id']==1 ? 'active':'';?>" onclick="changeblock('full');">
                    <img src="<?php echo base_url()."default/images/promo7.jpg"?>" alt="Upgrade to a Full Mug Today" />
                </div>
            </div>
   		</div>
   	</div>
<!-- ************************************************************************ -->


<div class="modal fade login_pop2" id="halfmugtext" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	  <?php echo $this->load->view(getThemeName().'/home/halfmugtext');?>	
</div>

<div class="modal fade login_pop2" id="fullmugtext" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	  <?php echo $this->load->view(getThemeName().'/home/fullmugtext');?>	
</div>

<script>
    $(document).ready(function(){
        $('#fullmug-button').hover(function(){
            $("#fullmugtext").modal('show');
        });
        $('#halfmug-button').hover(function(){
            $("#halfmugtext").modal('show');
        });
    });
</script>

				<link href="<?php echo base_url().getThemeName(); ?>/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
