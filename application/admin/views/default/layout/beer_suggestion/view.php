<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="<?php echo base_url().getThemeName();?>/js/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<link href="<?php echo base_url().getThemeName();?>/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url().getThemeName();?>/css/blog.css" rel="stylesheet" type="text/css"/>



<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($one_beer_suggestion_detail['beer_id']==""){ echo 'View'; } else { echo 'View'; }?></h3>
					
				</div>
				<div class="row_fluid"> 
						
					<div class="portlet blue">
						<div class="portlet-title">
							<div class="caption"><i class="icon-comments"></i><span style="float: right"><a href="<?php echo site_url('beer_suggestion/list_beer_suggestion');?>"  class="btn black ">Back</a></span></div>
							</div>
						<div class="portlet-body form">
							<div class="content ">
								<form enctype="multipart/form-data" class="main" name="frm_addmessage" id="usualValidate" accept-charset="utf-8" method="post" action="http://192.168.1.27/ADB/admin/forum/view/53/list_forum/1V1/1V1/20/0" novalidate="novalidate">			  						
									<div class="control_group">
										<label class="control_label">  <h3> Name : </h3>  </label>
										<div class="controls">
											<?php echo $one_beer_suggestion_detail['beer_name']; ?>									</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">  <h3> Beer Type : </h3>  </label>
										<div class="controls">
											<?php echo $one_beer_suggestion_detail['beer_type']; ?>										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">  <h3> Producer : </h3>  </label>
										<div class="controls">
											<?php echo $one_beer_suggestion_detail['producer']; ?>											</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">  <h3> City Produced : </h3>  </label>
										<div class="controls">
											<?php echo $one_beer_suggestion_detail['city_produced']; ?>											</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">  <h3> Description : </h3>  </label>
										<div class="controls">
											<?php echo $one_beer_suggestion_detail['beer_desc']; ?>											</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">  <h3> Website : </h3>  </label>
										<div class="controls">
											<?php echo $one_beer_suggestion_detail['beer_website']; ?>											</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">  <h3> ABV : </h3>  </label>
										<div class="controls">
											<?php echo $one_beer_suggestion_detail['abv']; ?>											</div>										
										<div class="clear"></div>
									</div>
									
								
								
									
									<div class="row-fluid">
									
									
									
									
									
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