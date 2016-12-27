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
<div class="wrapper row6 padtb10">
     	<div class="container">
     		<div class="new-reg-step">
     					<ul class="registration_steplist">
     						<!-- <li class="active"><a href="<?php echo site_url('home/bar_owner_register')?>">Step 1</a></li>
     						<li ><a href="<?php echo site_url('home/claimbar_registration_step2/'.$new_bar_id)?>">Step 2</a></li>
     						<li><a href="<?php echo site_url('home/claimbar_registration_step3')?>">Step 3</a></li>
     						<li class="last"><a href="<?php echo site_url('home/claimbar_registration_step4')?>">Step 4</a></li> -->
     						
     						<li ><a>Step 1</a></li>
     						<li class="active"><a>Step 2</a></li>
     						<li><a>Step 3</a></li>
     						<li class="last"><a>Step 4</a></li>
     						<div class="clearfix"></div>
     					</ul>
     				</div>
     		<div class="result_box clearfix mar_top30bot20">
             <?php $attributes = array('id'=>'frm_login','name'=>'frm_login','class'=>'form-horizontal','rolde'=>'form');
							echo form_open('home/claimbar_registration_step2/'.$new_bar_id."/".base64_encode($bar_id),$attributes); ?>	
							
                <!-- <div class="promo-left">
                    <div class="<?php echo @$getbardatafeature['feature_id']==1 ? 'active':'';?>" onclick="changeblock('full');">
                        <img src="<?php echo base_url()."default/images/promo6.jpg"?>" alt="Upgrade to a Full Mug Today" />
                    </div>
                </div> -->
                
                
     			<div class="float-left  br_green_yellow">
     				<div class="result_search">
	     				<i class="strip login_icon"></i><div class="result_search_text">Registration</div>
     				</div>
     				
     				<div>
     				<h1 class="yellow_title padb10 br_bott_gray text-center">Bar Owner Registration Step 2</h1>
     				
					<?php if($error!=""){ ?>
                        <div class="error text-center" style="color: #f4264a;"><?php echo $error; ?></div>
                        <?php }?>
                        
                      
     				<div class="pad20">
     				
					
							
	     					<input type="text" style="border: none; background-color:#2E2C26; color: #2E2C26; " name="btype" id="btype" value="<?php echo @$getbardatafeature['feature_id']!='' ? @$getbardatafeature['feature_id']:'';?>">
     					     <div class="register-newblock mar_top18 <?php  if(@$getbardatafeature['feature_id']==0){ echo "active";  } ;?>" id="half" onclick="changeblock('half');">
		        				<div>
				     				<label class="register-newtitle marr_10 pull-left">Free Listing</label><img src="<?php echo base_url().getThemeName(); ?>/images/true.png" class="true-sign pull-left mart10" />
				     				<div class="clearfix"></div>
		        				</div>
                                <div class="paragraph-listing">
                                    <p>Free bar listing with the bare minimum to get started.</p>
                                </div>
                                <div class="text-right bottom-right">
                                    <a href="javascript:void(0);" id="halfmug-button" class="btn-primary learn full-button">Half Mug Details</a>
                                </div>
		        				<div class="padtb8_checkbox">
		        					<ul>
		        						<?php $gethalf = gethalmugfeature('halfmug');
		        						if($gethalf){
		        							foreach($gethalf as $r){		        						?>
		        						<li><?php echo $r->halfmug;?></li>
		        						<?php } } ?>
		        						
		        					</ul>
		        					
		        				</div>
		        				<div class="clearfix"></div>
		                    </div>
     					     
     					      <div class="register-newblock  <?php if(isset($getbardatafeature['feature_id'])){ echo $getbardatafeature['feature_id'] ==1 ? 'active':'';}?>" id="full" onclick="changeblock('full');">
		        				<div>
				     				<label class="register-newtitle marr_10 pull-left">Full Mug (Paid) Listing</label> <img src="<?php echo base_url().getThemeName(); ?>/images/true.png" class="true-sign pull-left mart10" />
				     				<div class="clearfix"></div>
		        				</div>
                                <div class="paragraph-listing">
                                    <p>Paid bar listing that has no limitations, which allows you to customize your bar advertisement, listing, manage reviews/posts and much more. <br/><br/>For a low cost of $35 per month.</p>
                                </div>
                                <div class="text-right">
		        				 	<a href="javascript:void(0);" id="fullmug-button" class="btn-primary learn full-button">Benefits of a Full Mug Listing</a>
		        				 </div>
		        				<div class="padtb8_checkbox">
		        					<ul>
		        						<?php $getfull = gethalmugfeature('fullmug');
		        						if($getfull){
		        							foreach($getfull as $r){		        						?>
		        						<li><?php echo $r->fullmug;?></li>
		        						<?php } } ?>
		        						
		        					</ul>
		        				</div>
		        				<div class="clearfix"></div>
		        			</div>
	        				
		                    
		        			
		        			<span for="btype" style="display: none;" class="help-inline">This field is required.</span>
	                      
	                       		
	        				
	        				<input type="hidden" name="new_bar_id" id="new_bar_id" value="<?php echo @$new_bar_id; ?>" />
	                       	<input type="hidden" name="bar_id" id="bar_id" value="<?php echo @$bar_id; ?>" />
	                       	<input type="hidden" name="bar_feature_id" id="bar_feature_id" value="<?php echo @$getbardatafeature['bar_feature_id'];?>" />
	                       	<div class="padtb8">
	                       		<div class="col-sm-12 padding5 mart10">
	                       			<input type="submit" name="step2" id="step2" value="Next" class="btn btn-lg btn-primary pull-right"/>
	                       			<a class="btn btn-lg btn-primary" href="<?php echo site_url('home/claim_bar_owner_register/'.base64_encode('1V1').'/1V1/'.$new_bar_id)?>">Back</a>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	        			</form>
	        		</div>
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
        $('#halfmug-button').click(function(){
            $("#halfmugtext").modal('show');
        });
    });
</script>

				<link href="<?php echo base_url().getThemeName(); ?>/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
