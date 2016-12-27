<?php if($result){
				  			foreach($result as $rs)
	  				{?>
	                    	<li>
	                    		<div class="taxi-image">
	                    			<a class="pull-left" href="<?php echo site_url("taxiowner/details/".base64_encode($rs->taxi_id));?>">
							<?php 
									if($rs->taxi_image!="" && is_file(base_path().'upload/user_thumb/'.$rs->taxi_image)){ ?>
										<img style="height: 50px; width: 50px"  src="<?php echo base_url().'upload/user_thumb/'.$rs->taxi_image; ?>"  />
									<?php
									}
									else{?>
									<img style="height: 50px; width: 50px" src="<?php echo base_url().'upload/barlogo/no_image.png'; ?>" />
							<?php } ?>
						    </a>
                            
	                    		</div>
	                    		<div class="taxi-detail-block">
	                    			<div class="taxi-title"><a href="<?php echo site_url("taxiowner/details/".base64_encode($rs->taxi_id));?>" class="first_name"><?php echo ucwords($rs->taxi_company); ?></a></div>
	                    			<p class="result_date pull-left"><?php echo $rs->address.", ".$rs->city.", ".$rs->state." ".$rs->cmpn_zipcode; ?></p>
	                    		</div>
	                    		<div class="clearfix"></div>
	                    	</li>
	                    	<?php } } ?>