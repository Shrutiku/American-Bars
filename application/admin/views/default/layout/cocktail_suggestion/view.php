<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="<?php echo base_url().getThemeName();?>/js/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<link href="<?php echo base_url().getThemeName();?>/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url().getThemeName();?>/css/blog.css" rel="stylesheet" type="text/css"/>



<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($one_cocktail_suggestion_detail['cocktail_id']==""){ echo 'View'; } else { echo 'View'; }?></h3>
					
				</div>
				<div class="row_fluid"> 
						
					<div class="portlet blue">
						<div class="portlet-title">
							<div class="caption"><i class="icon-comments"></i><span style="float: right"><a href="<?php echo site_url('cocktail_suggestion/list_cocktail_suggestion');?>"  class="btn black ">Back</a></span></div>
							</div>
						<div class="portlet-body form">
							<div class="content ">
								<form enctype="multipart/form-data" class="main" name="frm_addmessage" id="usualValidate" accept-charset="utf-8" method="post" action="http://192.168.1.27/ADB/admin/forum/view/53/list_forum/1V1/1V1/20/0" novalidate="novalidate">			  						
									<div class="control_group">
										<label class="control_label">  <h3> Name : </h3>  </label>
										<div class="controls">
											<?php echo $one_cocktail_suggestion_detail['cocktail_name']; ?>									</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">  <h3> Ingredients : </h3>  </label>
										<div class="controls">
											<?php echo $one_cocktail_suggestion_detail['ingredients']; ?>										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">  <h3> How to make it : </h3>  </label>
										<div class="controls">
											<?php echo $one_cocktail_suggestion_detail['how_to_make_it']; ?>											</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">  <h3> Base Spirit : </h3>  </label>
										<div class="controls">
											<?php echo $one_cocktail_suggestion_detail['base_spirit']; ?>											</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">  <h3> Type : </h3>  </label>
										<div class="controls">
											<?php echo $one_cocktail_suggestion_detail['type']; ?>											</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">  <h3> Served : </h3>  </label>
										<div class="controls">
											<?php echo $one_cocktail_suggestion_detail['served']; ?>											</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">  <h3> Strength : </h3>  </label>
										<div class="controls">
											<?php echo $one_cocktail_suggestion_detail['strength']; ?>											</div>										
										<div class="clear"></div>
									</div>
									
								<div class="control_group">
										<label class="control_label">  <h3> Difficulty : </h3>  </label>
										<div class="controls">
											<?php echo $one_cocktail_suggestion_detail['difficulty']; ?>											</div>										
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