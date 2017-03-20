<script type="text/javascript">
	$(document).ready(function(){
//===== Usual validation engine=====//
	$("#frm_login").validate({
		rules: {			
			cc_type: {
				required: true,
			},			
			card_number: {
				required: true,
			},
			ex_month: {
				required: true,
			},
			ex_year: {
				required: true,
			},
			cvv: {
				required: true,
			},
				billing_address1: {
				required: true,
			},
			// billing_address2: {
				// required: true,
			// },	
			billing_country: {
				required: true,
			},	
			billing_zipcode: {
				required: true,
			},	
			billing_state: {
				required: true,
			},	
			billing_city: {
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
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
	     				<i class="strip login_icon"></i><div class="result_search_text">Registration</div>
     				</div>
     				
     				<div>
     					<div>
     				<h1 class="yellow_title padb10 br_bott_gray text-center">Bar Owner Registration Step2 - Payment </h1>
     				<div>
     					<ul class="registration_steplist">
     						<!-- <li><a href="<?php echo site_url('home/bar_owner_register')?>">Step 1</a></li> -->
     						<!-- <li class=""><a href="<?php echo site_url('home/upgrade')?>">Step 1</a></li> -->
     						<li><a href="<?php echo site_url('home/registration_step3_upgrade/'.$bar_id)?>">Step 1</a></li>
     						<li class="last active"  href="<?php echo site_url('home/registration_step4_upgrade/'.$bar_id)?>"><a >Step 2</a></li>
     						<div class="clearfix"></div>
     					</ul>
     				</div>
					<?php if($error!=""){ ?>
                        <div class="error1 text-center"><?php echo $error; ?></div>
                        <?php }?>
                        
                      
     				<div class="pad20">
					<?php $attributes = array('id'=>'frm_login','name'=>'frm_login','class'=>'form-horizontal','rolde'=>'form');
							echo form_open('home/registration_step4_upgrade/'.$bar_id."/$type/$coupon",$attributes); ?>	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Credit Card Type : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<select class="select_box" name="cc_type" id="cc_type">
		                           		<option value="">SELECT CARD TYPE...</option>
							            <option <?php echo @$cc_type=='MasterCard' ? 'selected':''; ?> value="MasterCard">MasterCard</option>
							            <option <?php echo @$cc_type=='Visa' ? 'selected':''; ?> value="Visa" >Visa</option>
										<option <?php echo @$cc_type=='Amex' ? 'selected':''; ?> value="Amex" >American Express</option>
				                        <option <?php echo @$cc_type=='Discover' ? 'selected':''; ?> value="Discover" >Discover</option>
		                         	</select>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       
	                      <div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Credit Card Number : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="card_number" name="card_number" value="<?php echo @$card_number; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	<div class="padtb8">
	                       		<div class="col-sm-3">
	        				 		<label class="control-label">Expiration Date : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="col-sm-4">
	                       			<select class="form-control form-pad select" id="ex_month" name="ex_month">
	                       				<option  value="">Month</option>
	                       				<option <?php echo @$ex_month=='01' ? 'selected':''; ?> value="01">January</option>
	                       				<option <?php echo @$ex_month=='02' ? 'selected':''; ?> value="02">February</option>
	                       				<option <?php echo @$ex_month=='03' ? 'selected':''; ?> value="03">March</option>
	                       				<option <?php echo @$ex_month=='04' ? 'selected':''; ?> value="04">April</option>
	                       				<option <?php echo @$ex_month=='05' ? 'selected':''; ?> value="05">May</option>
	                       				<option <?php echo @$ex_month=='06' ? 'selected':''; ?> value="06">June</option>
	                       				<option <?php echo @$ex_month=='07' ? 'selected':''; ?> value="07">July</option>
	                       				<option <?php echo @$ex_month=='08' ? 'selected':''; ?> value="08">August</option>
	                       				<option <?php echo @$ex_month=='09' ? 'selected':''; ?> value="09">September</option>
	                       				<option <?php echo @$ex_month=='10' ? 'selected':''; ?> value="10">October</option>
	                       				<option <?php echo @$ex_month=='11' ? 'selected':''; ?> value="11">November</option>
	                       				<option <?php echo @$ex_month=='12' ? 'selected':''; ?> value="12">December</option>
	                       			</select>
	                       		</div>
	                       		<div class="col-sm-3">	
	                       			<select class="form-control form-pad select"  id="ex_year" name="ex_year">
	                       				<option value="">Year</option>
	                       				<?php $dt=date('Y');
										for ($i=$dt; $i <$dt+10 ; $i++) {?> 
										<option <?php echo @$ex_year==$i ? 'selected':''; ?> value="<?php echo $i ?>"><?php echo $i ?></option>
										<?php } ?>
	                       			</select>
	                       		</div>	
	                       			<div class="clearfix"></div>
	        				 		<!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
	        				 	</div>
	        				 	<div class="clearfix"></div>
	        				 	
	        				<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">CVV/CVC: <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="cvv" name="cvv" value="<?php echo @$cvv; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div> 	
	                       	
	                       	  <div class="result_search mar_top20">
				     			<div class="col-sm-8">
					     			<div class="result_search_text pull-left">Billing Information</div>
					            </div>
					            <div class="clearfix"></div>
				     			</div>
							   
		                       	<div class="padtb">
		                       		<div class="col-sm-3">
			        				 	<label class="control-label">Address1 : <span class="aestrick"> * </span></label>
			        				</div> 	
			        				
			                       		<div class="input_box col-sm-7">
			                           		<input type="text" name="billing_address1" maxlength="40" class="form-control form-pad" id="billing_address1" placeholder="Address1" value="<?php echo @$billing_address1; ?>">
			                       		</div>
			                       		<div class="clearfix"></div>
		                       	</div>
		                       	
		                       	<div class="padtb">
		                       		<div class="col-sm-3">
			        				 	<label class="control-label">Address2 : </label>
			        				 </div>	
			                       		<div class="input_box col-sm-7">
			                           		<input type="text" name="billing_address2" maxlength="40" class="form-control form-pad" id="billing_address2" placeholder="Address2" value="<?php echo @$billing_address2; ?>">
			                       		</div>
			                       		<div class="clearfix"></div>
		                       	</div>
		                       	
		                       	<div class="padtb">
		                       		<div class="col-sm-3">
			        				 	<label class="control-label">City : <span class="aestrick"> * </span></label>
			        				</div> 	
			                       		<div class="input_box col-sm-7">
			                           		
			                           		<input type="text" name="billing_city" maxlength="40" class="form-control form-pad" id="billing_city" placeholder="City" value="<?php echo @$billing_city; ?>">
			                       		</div>
			                       		<div class="clearfix"></div>
		                       	</div>
		                       	
		                       	<div class="padtb">
		                       		<div class="col-sm-3">
			        				 	<label class="control-label">State : <span class="aestrick"> * </span></label>
			        				 </div>
			        				 	
			                       		<div class="input_box col-sm-7">
			                           		
			                           		<input type="text" name="billing_state" maxlength="40" class="form-control form-pad" id="billing_state" placeholder="State" value="<?php echo @$billing_state; ?>">
			                       		</div>
			                       		<div class="clearfix"></div>
		                       	</div>
		                       	
		                       		<div class="padtb">
		                       			<div class="col-sm-3">
			        				 	<label class="control-label">Zipcode : <span class="aestrick"> * </span></label>
			        				 	</div>
			                       		<div class="input_box col-sm-7">
			                           		<input type="text" name="billing_zipcode" maxlength="40" class="form-control form-pad" id="billing_zipcode" placeholder="Zipcode" value="<?php echo @$billing_zipcode; ?>">
			                       		</div>
			                       		<div class="clearfix"></div>
		                       	</div>
		                       	
		                       	<div class="padtb">
		                       		<div class="col-sm-3">
			        				 	<label class="control-label">Country : <span class="aestrick"> * </span></label>
			        				 </div>	
			                       		<div class="input_box col-sm-7">
			                           		<input type="text" name="billing_country" maxlength="40" class="form-control form-pad" id="billing_country" placeholder="Country" value="<?php echo @$billing_country; ?>">
			                       		</div>
			                       		<div class="clearfix"></div>
		                       	</div>
	                       	</div>
	                       	<input type="hidden" name="bar_id" id="bar_id" value="<?php echo $bar_id; ?>" />
	                       	<div class="padtb8">
	                       		<!-- <div class="col-sm-3"></div> -->
	                       		<div class="col-sm-12 mart10">
	                       			
	                       			<a class="btn btn-lg btn-primary btn-next pull-left" href="<?php echo site_url('home/registration_step3_upgrade/'.$bar_id."/$type")?>"><i class="previous-arrow-icon"></i> Back</a>
	                       			<button type="submit" name="step2" id="step2"  class="btn btn-lg btn-primary btn-next next-right"/>Next <i class="next-arrow-icon"></i></button>
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