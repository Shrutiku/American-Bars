<script>$(document).ready(function(){
	$("#validate").validate({
		rules:{
			title:'required',
			meta_keyword:'required',
			meta_description:'required',
		}
	});

});</script>
<!-- Content begins -->
<div id="content" class="page_content">
 <div class="container_fluid">
   <div class="row_fluid">
					<div class="span12">
                    	<!-- BEGIN PAGE TITLE & BREADCRUMB-->
						<h3 class="page_title">
							Default Meta Settings
							
						</h3>
						
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
    <!-- Main content -->   
		<?php  
		if($error != "") {
			if($error == 'insert') {?>
				<div class="success_msg">
					
						<p><?php echo META_SETTING_UPDATE;?></p>
				</div>

			<?php }
		
			if($error != "insert"){	
			?>
				<div class="error_red">
					
						<?php echo $error;?>
				</div>
			<?php  }
		}
	?>		
            <div class="row_fluid">
					<div class="span12">
						<!-- BEGIN SAMPLE FORM PORTLET-->   
						<div class="portlet box blue tabbable">

				
               
                        <div class="portlet-title">
								<div class="caption">
									<i class="icon-reorder"></i>
									<span class="hidden-480">Default Meta Setting</span>
								</div>
							</div>
                            <div class="portlet-body form">
								<div class="tabbable portlet-tabs">
									
                                    <div class="tab-content">
										<div id="portlet_tab1" class="tab-pane active">
                                         <?php
				$attributes = array('name'=>'frm_meta_setting','class'=>'form-horizontal','id'=>'validate');
				echo form_open('meta_setting/add_meta_setting',$attributes);
			  ?>
                       <div class="control_group">
													<label class="control-label">Title<span class="req">*</span></label>
                            <div class="controls"><input type="text" name="title" id="title" value="<?php echo $title; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                        </div>

                       <div class="control_group">
													<label class="control-label">Meta Keyword</label>
                            <div class="controls"><input type="text" name="meta_keyword" id="meta_keyword" value="<?php echo $meta_keyword; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                        </div>

                        <div class="control_group">
													<label class="control-label">Meta Description </label>
							<div class="controls">
							 <textarea name="meta_description" cols="" rows="" id="meta_description" class="required m_wrap wid360"><?php echo $meta_description; ?></textarea>
							</div>
							<div class="clear"></div>
                        </div>

               	
												
                                                											
						<input type="hidden" name="meta_setting_id" id="meta_setting_id" value="<?php echo $meta_setting_id; ?>" />
				 		
							<div class="form_action">
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="document.location.href='<?php echo base_url(); ?>admin/list_admin'" />
						    </form>
                        </div>
  
                    </div>
               
           
        </div>
    </div>
    </div>
 
     </div>
     </div>
     </div>
     </div>
</div>
<!-- Content ends -->    