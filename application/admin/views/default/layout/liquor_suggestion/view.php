<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="<?php echo base_url().getThemeName();?>/js/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<link href="<?php echo base_url().getThemeName();?>/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url().getThemeName();?>/css/blog.css" rel="stylesheet" type="text/css"/>



<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($one_liquor_suggestion_detail['liquor_id']==""){ echo 'View'; } else { echo 'View'; }?></h3>
					
				</div>
				<div class="row_fluid"> 
						
					<div class="portlet blue">
						<div class="portlet-title">
							<div class="caption"><i class="icon-comments"></i><span style="float: right"><a href="<?php echo site_url('liquor_suggestion/list_liquor_suggestion');?>"  class="btn black ">Back</a></span></div>
							</div>
						<div class="portlet-body form">
							<div class="content ">
								<form enctype="multipart/form-data" class="main" name="frm_addmessage" id="usualValidate" accept-charset="utf-8" method="post" action="http://192.168.1.27/ADB/admin/forum/view/53/list_forum/1V1/1V1/20/0" novalidate="novalidate">			  						
									<div class="control_group">
										<label class="control_label">  <h3> Name : </h3>  </label>
										<div class="controls">
											<?php echo $one_liquor_suggestion_detail['liquor_title']; ?>									</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">  <h3> Type : </h3>  </label>
										<div class="controls">
											<?php echo $one_liquor_suggestion_detail['type']; ?>										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">  <h3> Proof : </h3>  </label>
										<div class="controls">
											<?php echo $one_liquor_suggestion_detail['proof']; ?>											</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">  <h3> Producer : </h3>  </label>
										<div class="controls">
											<?php echo $one_liquor_suggestion_detail['producer']; ?>											</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">  <h3> Country : </h3>  </label>
										<div class="controls">
											<?php echo $one_liquor_suggestion_detail['country']; ?>											</div>										
										<div class="clear"></div>
									</div>
									
									
							</form></div>
							
						</div>
						
					</div>
				</div>  
		          <div class="row-fluid">
					<div class="span12 blog-page">
						<div class="row-fluid">
							<div class="span9 article-block">
								
								
							
								
							</div>
							<!--end span9-->
						
							<!--end span3-->
						</div>
					</div>
				</div>       
			</div>
		</div>
</div>