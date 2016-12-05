
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title">View</h3>
					
				</div>
				<div class="row_fluid"> 
			
					<div class="portlet blue">
						<div class="portlet-title">
							<div class="caption"></div>
						</div>
						<div class="portlet-body form">
							<div class="fl_right">
										<!-- <a href="javascript:void(0)" onclick="setaction('chk[]','active', 'Are you sure, you want to activate selected record(s)?', 'frm_listlogin');" class="btn purple fl_left mar_r_5" >Active</a>
					<a href="javascript:void(0)" onclick="setaction('chk[]','inactive', 'Are you sure, you want to inactivate selected record(s)?', 'frm_listlogin');" class="btn yellow  fl_left mar_r_5" >Inactive</a>
					 -->
					 
					 <a class="btn yellow  fl_left" href="<?php echo site_url('report')?>">Back</a>
					
					<div class="clear"></div>		
										
										
										<div class="clear"></div>
									</div><div class="clear"></div>
							<div class="content ">
									<div class="control_group">
										<label class="control_label">  <h3> Status : </h3>  </label>
										<div class="controls">
											<?php echo $status; ?>
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">  <h3> Bar Name : </h3>  </label>
										<div class="controls">
											<?php echo $bar_title; ?>
										</div>										
										<div class="clear"></div>
									</div>
									
									
									<div class="control_group">
										<label class="control_label">  <h3> Reported By : </h3>  </label>
										<div class="controls">
											<?php echo $reported_by; ?>
										</div>										
										<div class="clear"></div>
									</div>
								<?php if($status=='Other'){?>	
									<div class="control_group">
										<label class="control_label">  <h3> Description : </h3>  </label>
										<div class="controls">
											<?php echo $desc; ?>
										</div>										
										<div class="clear"></div>
									</div>
									<?php } ?>
									
									
									
							</div>
							
							
						</div>
						
					</div>
				</div>
			</div>
		</div>
</div>