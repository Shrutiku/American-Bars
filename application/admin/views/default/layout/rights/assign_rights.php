<?php /*?><!-- Custom Scrollbars Below-->
    <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.mousewheel.js"></script>
    <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/mwheelIntent.js"></script>
    <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.em.js"></script>
    <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jScrollPane.js"></script>

    <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/colorpicker/js/colorpicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/onmediaquery.min.js"></script>
  
    <!-- Custom app scripts and functions inside application.js and responsive.js file linked below. -->
    
    <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/application-widgets.js"></script>
    <!--[if !IE]><!-->
    <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/responsive-other-pages.js"></script>
    <!--<![endif]-->

    <!--[if lte IE 10]><script language="javascript" type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/responsive-other-pages-IE.js"></script><![endif]--><?php */?>
   
  <style type="text/css">
  	.table_rights tbody td {
		border-collapse: collapse;
		border-left: medium none;
		border-right: medium none;
		vertical-align: bottom;
	}
  </style>
   
   <script type="text/javascript">
   function setchecked(elemName,t){
	elem = document.getElementsByName(elemName);
	if(t == '1')
	{
		for(i=0;i<elem.length;i++){
			elem[i].checked=1;
		}
	}
	else
	{
		for(i=0;i<elem.length;i++){
			elem[i].checked=0;
		}
	}
}
   </script>
    
	<!-- Content begins -->
	
	
	<div id="content" class="page_content">
	 <div class="container_fluid">
	 	
	 	
	   <div class="row_fluid">
						<div class="span12">
							<!-- BEGIN PAGE TITLE & BREADCRUMB-->
							<h3 class="page_title"> Assign Rights
 </h3>
							
							<!-- END PAGE TITLE & BREADCRUMB-->
						</div>
					</div>
					
					
		<!-- Main content -->   
			<?php
				if(isset($error)){
					if($error != "") {
						if($error == 'insert') {?>
							<div class="success_msg"> <p><?php echo META_SETTING_UPDATE;?></p> </div>
			
					<?php }
						if($error != "insert"){	
						?>
							<div class="error_red">
								
									<?php echo $error;?>
							</div>
						<?php  }
					}
				}
			?>		
			
			
				<div class="row_fluid">
						<div class="span12">
							<!-- BEGIN SAMPLE FORM PORTLET-->   
							<div class="portlet box blue tabbable">
	
							<div class="portlet-title">
									<div class="caption">
										<i class="icon-reorder"></i>
										<span class="hidden-480">Assign Rights</span>
									</div>
								</div>
								
								
								<div class="portlet-body form">
									<div class="tabbable portlet-tabs">
										<div class="tab-content">
											<div id="portlet_tab1" class="tab-pane active">
											 <?php
												$attributes = array('name'=>'frm_assignrights');
												echo form_open('rights/add_rights/'.$admin_id,$attributes);
											?>
											
											
							  						
												  <div class="fl_left">
																	<a href="javascript:void(0)" onclick="javascript:setchecked('rights_id[]',1);" class="btn blue fl_left mar_r_5" >Check All</a>
																	<a href="javascript:void(0)" onclick="setchecked('rights_id[]',0);" class="btn red fl_left" >Clear All</a>
																	<div class="clear"></div>
														</div><div class="clear"></div>
													
													
												<div  class="checbox-listing-block">
													
			 <?php												
																	if($rights){
																		$i = 0; 
																		foreach($rights as $rig)
																		{
																																
															?>											
			<div class="row_fluid">
				<h3 class="page_newtitle"><?php echo ucwords(str_replace('_',' ',$rig->module_name)); ?></h3>
			</div>
			<div class="row_fluid">
				<div>
					<ul class="checkbox-listing">
						<?php $getfeatture = getfeaturename($rig->module_id);
															 if($getfeatture){
															 foreach($getfeatture as $v){
															?>							
						<li>
							
							<input type="checkbox" class="chk" name="rights_id[]" value="<?php echo $v->rights_id; ?>"  <?php if($assign_rights) { if(in_array($v->rights_id,$assign_rights)) { ?> checked="checked" <?php } } ?> /> <?php echo ucwords(str_replace('_',' ',$v->rights_name)); ?></li>
							<?php } } ?>
						
					</ul>
				</div><div class="clear"></div>
			</div>
			<div class="clear"></div>
			
			<?php } } ?>
		</div>
		
			
															
													  
											 <label class="form-label">&nbsp;</label> 
											 <input type="hidden" name="admin_id" id="admin_id" value="<?php echo $admin_id; ?>" />													 									 				
											 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
											 <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
											
											<div class="form_action">
												<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
												<input type="button" name="Cancel" value="Cancel" class="btn red fl_left" onClick="location.href='<?php echo base_url(); ?>admin/list_admin'" />
											</div>
													
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
	
    <div class="ui-layout-south footer">
      
    </div> <!-- END Layout South -->
    
 <!-- END Layout East -->