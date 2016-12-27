<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="<?php echo base_url().getThemeName();?>/js/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<link href="<?php echo base_url().getThemeName();?>/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url().getThemeName();?>/css/blog.css" rel="stylesheet" type="text/css"/>

<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($postcard_id==""){ echo 'View'; } else { echo 'View'; }?></h3>
					
					         <div class="clearfix"></div>
				</div> <div class="clearfix"></div>
				
		          <div class="row_fluid"> 
						
					<div class="portlet blue">
						<div class="portlet-title">
							<div class="caption"><i class="icon-comments"></i><span style="float: right"><a href="<?php echo site_url('postcard/list_postcard')?>" class="btn black ">Back</a></span></div>
							</div>
						<div class="portlet-body form">
							<div class="content ">
								<form enctype="multipart/form-data" class="main" name="frm_addmessage" id="usualValidate" accept-charset="utf-8" method="post" action="http://192.168.1.27/ADB/admin/forum/view/53/list_forum/1V1/1V1/20/0" novalidate="novalidate">			  						
									<div class="control_group">
										<label class="control_label">  <h3> Username : </h3>  </label>
										<div class="controls">
											<?php echo $one_postcard['first_name']." ".$one_postcard['last_name']; ?>									</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">  <h3> Email : </h3>  </label>
										<div class="controls">
											<?php echo $one_postcard['email']; ?>									</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">  <h3> Postcard Title : </h3>  </label>
										<div class="controls">
											<?php echo $one_postcard['post_title']; ?>									</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">  <h3>Bar Address : </h3>  </label>
										<div class="controls">
											<?php echo $one_postcard['address']." ".$one_postcard['city']." ".$one_postcard['state']." ".$one_postcard['zipcode']; ?>											</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">  <h3> Message : </h3>  </label>
										<div class="controls">
											<?php echo $one_postcard['post_message']; ?>										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">  <h3> Card Type : </h3>  </label>
										<div class="controls">
											<?php echo $one_postcard['card_type']=="full_mug" ? 'Full Mug':'Half Mug'; ?>											</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">  <h3> Date : </h3>  </label>
										<div class="controls">
											<?php echo date($site_setting->date_format,strtotime($one_postcard['date_added'])); ?>											</div>										
										<div class="clear"></div>
									</div>
									
									
									
									<div class="row-fluid">
									
									
									
									
									
									</div>
							</form></div>
							
						</div>
						
					</div>
				</div>  
			</div>
		</div>
</div>