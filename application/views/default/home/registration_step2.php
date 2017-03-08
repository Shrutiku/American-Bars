
<style>
	.pad20 p{
		color:#ffffff;
		
	}
	.register-newblock:hover, .register-newblock.active {
    background-color: rgba(5,109,0,.4) !important;
    cursor: pointer;
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
			  $("#manage").removeClass('active');
			 $("#half").addClass('active');
			 $("#btype").val(0);
		}
		else if(type=='full')
		{
			 $("#half").removeClass('active');
			  $("#manage").removeClass('active');
			 $("#full").addClass('active');
			 $("#btype").val(1);
		}
		else
		{
			$("#half").removeClass('active');
			 $("#full").removeClass('active');
			 $("#manage").addClass('active');
			 $("#btype").val(2);
			
		}
		
	}
</script>
<!-- ########################################################################################### -->
<!-- content -->
<?php $v=0;
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
		     			
		     			  <?php } }  else { 
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
     		<div class="result_box clearfix mar_top15 margin-bottom-20">
                <?php $attributes = array('id'=>'frm_login','name'=>'frm_login','class'=>'form-horizontal','rolde'=>'form');
							echo form_open('home/claimbar_type/' . $bar_id,$attributes); ?>	
                <!-- <div class="promo-left">
                    <div class="<?php echo @$getbardatafeature['feature_id']==1 ? 'active':'';?>" onclick="changeblock('full');">
                        <img src="<?php echo base_url()."default/images/promo6.jpg"?>" alt="Upgrade to a Full Mug Today" />
                    </div>
                </div> -->
                
                
     			
     				
     				<div>
     				<h1 class="yellow_title padb10 br_bott_gray text-center_new">Select Bar Type</h1>
     				
					<?php if($error!=""){ ?>
                        <div class="error text-center_new" style="color: #f4264a;"><?php echo $error; ?></div>
                        <?php }?>
                        
                      
     				<div><!--class="pad20"-->
     				
					
							
	     					<input type="hidden" style="border: none; background-color:#2E2C26; color: #2E2C26; " name="btype" id="btype" value="<?php echo $type;?>">
                            <button type="submit" name="step2" id="step2" value="Next" class="btn btn-lg btn-primary btn-next pull-right mar_top30bot20">Next <i class="next-arrow-icon"></i></button>
                            <div class="clearfix"></div>
                            <div class="col-md-12">
                            
                            	<div class="col-md-4 col-md-12">
                                
                                	<div class="register-newblock mar_top18 <?php  if(base64_decode($type)==0 && $type!=''){ echo "active";  } ;?>" id="half" onclick="changeblock('half');">
                                    <i class="true-icon"></i>
		        				<div>
				     				<label class="register-newtitle marr_10 pull-left ">Half Mug</label>
				     				<div class="clearfix"></div>
		        				</div>
                                <P></P>
                                <div class="bottom-right">
                                <div class="price-section">
                                
                                		<div class="price">
                                        <span class="pretty-currency zero-subunits"><span class="currency-symbol"></span><span class="currency-units">Free</span></div>
                                		
                                        <aside><br></aside>
                                        
                                </div>
                                                               
                                </div>
                                
                                <div class="clearfix"></div>
                                <aside class="bars_value">Over 27,500 Bars</aside>
                                
                                <div class="clearfix"></div>
                                
                                <!-- <div class="btn-center bottom-right yield-wrapper"> -->
                                	 <div class="btn-center bottom-right yield-wrapper mar_top15">
                                    <a href="javascript:void(0);" id="halfmug-button" class="btn-primary learn "><img src="<?php echo base_url().getThemeName(); ?>/images/true3.png" />&nbsp;What Is Half Mug?</a>
                                </div>
                                <div class="clearfix"></div>
                                	        				
		        					
                                <div class="paragraph-listing">
                                    <!-- <h4 class="sentence">A great basic shaver, for guys who dig simplicity and precision.</h4> -->
                                    <?php $gethalf = gethalmugfeature('halfmug');
		        						if($gethalf){
		        							foreach($gethalf as $r){			?>
                                    <p class="text-center_new"><img src="<?php echo base_url().getThemeName(); ?>/images/true2.png" />&nbsp;<?php echo $r->halfmug;?></p>
                                    	<?php } } ?>
                                    
                                </div>
                                
                                <div class="clearfix"></div>
                                <div class="text-center_new">
                                <a href="javascript:void(0);" class="btn-primary learn " id="halfmug-button" href=""><img src="<?php echo base_url().getThemeName(); ?>/images/true3.png">&nbsp;Select</a>
                                <!--<a href="javascript:void(0);" id="halfmug-button" class="beer_title learmore" href="">LEARN MORE</a>-->
                                </div>
                                
		        				<!--<div class="padtb8_checkbox">
		        					<ul>
		        						<?php $gethalf = gethalmugfeature('halfmug');
		        						if($gethalf){
		        							foreach($gethalf as $r){		        						?>
		        						<li><?php echo $r->halfmug;?></li>
		        						<?php } } ?>
		        						
		        					</ul>
		        					
		        				</div>-->
                                
                                
		        				<div class="clearfix"></div>
		                    </div>
                                
                                
                                </div>
                                
                                
                                
                                
                                
                                <div class="col-md-4 col-md-12">
                                	<div class="register-newblock mar_top18 active_new <?php  if(base64_decode($type)==1 && $type!=''){ echo "active";  } ;?>" id="full" onclick="changeblock('full');">
                                    
                                    <i class="true-icon"></i>
                                    
                                    <img src="<?php echo base_url().getThemeName(); ?>/images/best_value.png" class="best_value_img" />
		        				<div>
				     				<label class="register-newtitle marr_10 pull-left ">Full Mug</label>
				     				<div class="clearfix"></div>
		        				</div>
                                <P></P>
                                <div class="bottom-right">
                                <div class="price-section">
                                
                                		<div class="price">
                                        <span class="pretty-currency zero-subunits"><span class="currency-symbol">$</span><span class="currency-units"><?php echo $site_setting->amount;?></span></div>
                                		
                                        <aside>Every<br>Month</aside>
                                        
                                </div>
                                                               
                                </div>
                                <div class="clearfix"></div>
                                <aside class="bars_value">Over 16,000 Bars</aside>
                                
                                <div class="clearfix"></div>
                                
                                <div class="btn-center bottom-right yield-wrapper mar_top15">
                                    <a href="javascript:void(0);" id="fullmug-button" class="btn-primary learn "><img src="<?php echo base_url().getThemeName(); ?>/images/true3.png" />&nbsp;What Is Full Mug?</a>
                                </div>
                                <div class="clearfix"></div>
                                <div class="paragraph-listing">
                                    <!-- <h4 class="sentence">A great basic shaver, for guys who dig simplicity and precision.</h4> -->
                                    
                                     <?php $gethalf = gethalmugfeature('fullmug');
		        						if($gethalf){
		        							foreach($gethalf as $r){			?>
                                    <p class="text-center_new"><img src="<?php echo base_url().getThemeName(); ?>/images/true2.png" />&nbsp;<?php echo $r->fullmug;?></p>
                                    	<?php } } ?>
                                </div>
                                
                                <div class="clearfix"></div>
                                <div class="text-center_new">
                                  <a href="javascript:void(0);" class="btn-primary learn " id="fullmug-button" href=""><img src="<?php echo base_url().getThemeName(); ?>/images/true3.png">&nbsp;Select</a>
                                  <!--<a href="javascript:void(0);" id="fullmug-button" class="beer_title learmore" href="">LEARN MORE</a>-->
                                </div>
                                
                                
		        				<!--<div class="padtb8_checkbox">
		        					<ul>
		        						<?php $gethalf = gethalmugfeature('halfmug');
		        						if($gethalf){
		        							foreach($gethalf as $r){		        						?>
		        						<li><?php echo $r->halfmug;?></li>
		        						<?php } } ?>
		        						
		        					</ul>
		        					
		        				</div>-->
                                
                                
		        				<div class="clearfix"></div>
		                    </div>
                                
                                
                                </div>
                                
                                
                                
                                
                                
                                
                                
                                <div class="col-md-4 col-md-12">
                                	
                                	<div class="register-newblock mar_top18 <?php  if(base64_decode($type)==2 && $type!=''){ echo "active";  } ;?>" id="manage" onclick="changeblock('manage');">
                                    <i class="true-icon"></i>
		        				<div>
				     				<label class="register-newtitle marr_10 pull-left ">Managed Account</label>
				     				<div class="clearfix"></div>
		        				</div>
                                <P></P>
                                <div class="bottom-right">
                                <div class="price-section">
                                
                                		<div class="price">
                                        <span class="pretty-currency zero-subunits"><span class="currency-symbol">$</span><span class="currency-units"><?php echo $site_setting->managed_account_amount;?></span></div>
                                		
                                        <aside>Every<br>Month</aside>
                                        
                                </div>
                                                               
                                </div>
                               <div class="clearfix"></div>
                                <aside class="bars_value">Over 5,000 Bars</aside>
                                
                                <div class="clearfix"></div>
                                
                                <div class="btn-center bottom-right yield-wrapper mar_top15">
                                    <a href="javascript:void(0);" id="managed-button" class="btn-primary learn "><img src="<?php echo base_url().getThemeName(); ?>/images/true3.png" />&nbsp;What Is Managed Account?</a>
                                </div>
                                <div class="clearfix"></div>
                                <div class="paragraph-listing">
                                    <!-- <h4 class="sentence">A great basic shaver, for guys who dig simplicity and precision.</h4> -->
                                    
                                     <?php $gethalf = gethalmugfeature('managedmug');
		        						if($gethalf){
		        							foreach($gethalf as $r){			?>
                                    <p class="text-center_new"><img src="<?php echo base_url().getThemeName(); ?>/images/true2.png" />&nbsp;<?php echo $r->managedmug;?></p>
                                    	<?php } } ?>
                                    
                                </div>
                                
                                <div class="clearfix"></div>
                                <div class="text-center_new">
                                <a href="javascript:void(0);" class="btn-primary learn " id="managed-button" href=""><img src="http://192.168.1.27/ADB/default/images/true3.png">&nbsp;Select</a>
                                  <!--<a href="javascript:void(0);" id="managed-button" class="beer_title learmore" href="">LEARN MORE</a>-->
                                </div>
                                
                                
		        				<!--<div class="padtb8_checkbox">
		        					<ul>
		        						<?php $gethalf = gethalmugfeature('halfmug');
		        						if($gethalf){
		        							foreach($gethalf as $r){		        						?>
		        						<li><?php echo $r->halfmug;?></li>
		        						<?php } } ?>
		        						
		        					</ul>
		        					
		        				</div>-->
                                
                                
		        				<div class="clearfix"></div>
		                    </div>
                                </div>
                            </div>
		        			
		        			<span for="btype" style="display: none;" class="help-inline">This field is required.</span>
	        				
	                       	<input type="hidden" name="bar_id" id="bar_id" value="<?php echo @$bar_id; ?>" />
	                       	<input type="hidden" name="bar_feature_id" id="bar_feature_id" value="<?php echo @$getbardatafeature['bar_feature_id'];?>" />
	                       	<div class="padtb8">
	                       		<div class="col-sm-12 padding5 mart10">
	                       			<!--<input type="submit" name="step2" id="step2" value="Next" class="btn btn-lg btn-primary btn-next pull-right"/>-->
                                            <button type="submit" name="step2" id="step2" value="Next" class="btn btn-lg btn-primary btn-next pull-right margin-top-30">Next <i class="next-arrow-icon"></i></button>
	                       			<!-- <a class="btn btn-lg btn-primary" href="<?php echo site_url('home/claimbar_type') . $bar_id?>">Back</a> -->
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	        			</form>
	        		</div>
     			</div>
     	
            <!-- <div class="promo-left">
                <div class="<?php echo @$getbardatafeature['feature_id']==1 ? 'active':'';?>" onclick="changeblock('full');">
                    <img src="<?php echo base_url()."default/images/promo7.jpg"?>" alt="Upgrade to a Full Mug Today" />
                </div>
            </div> -->
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
        $('#fullmug-button').click(function(){
            $("#fullmugtext").modal('show');
        });
          $('#managed-button').click(function(){
            $("#fullmugtext").modal('show');
        });
        $('#halfmug-button').click(function(){
            $("#halfmugtext").modal('show');
        });
        
        changeblock("fullmug");
    });
</script>

				<link href="<?php echo base_url().getThemeName(); ?>/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
