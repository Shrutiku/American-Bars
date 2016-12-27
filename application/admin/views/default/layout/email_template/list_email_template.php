	<script>
			
function setchecked(elemName){
	elem = document.getElementsByName(elemName);
	if(document.getElementById("titleCheck").checked == true)
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

function setaction(elename, actionval, actionmsg, formname) {


	vchkcnt=0;
	elem = document.getElementsByName(elename);
	
	for(i=0;i<elem.length;i++){
		if(elem[i].checked) vchkcnt++;	
	}
	if(vchkcnt==0) {
		alert('Please select a record')
	} else {
		
		if(confirm(actionmsg))
		{
			document.getElementById('action').value=actionval;	
			document.frm_listlogin.submit();
		}		
		
	}
}
	</script>
		<!-- BEGIN PAGE -->
	
		<div class="page_content">
			<!-- BEGIN PAGE CONTAINER-->        
			<div class="container_fluid">
				<!-- BEGIN PAGE HEADER-->
				<div class="row_fluid">
					<div class="span12">
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->
						<h3 class="page_title">
							 Manage Email Template
						</h3>
						
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>		
                
              
	<?php 
					if($msg != ""){
						 if($msg == "insert"){ $error = ADD_NEW_VEHICLE_MAKE;}
							if($msg == "update"){ $error = UPDATE_VEHICLE_MAKE;}
							if($msg == "delete"){ $error = DELETE_VEHICLE_MAKE;}
							if($msg == "active") {  $error = ACTIVE_VEHICLE_MAKE;}
							if($msg == "inactive"){ $error = INACTIVE_VEHICLE_MAKE;}
					?>
						<div class="success_msg">
							
								<p><?php echo $error;?></p>
						</div>
					<?php } ?>
	<div class="portlet box blue">
							<div class="portlet-title">
								<div class="caption"><i class="icon-globe"></i>Email template list</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
								<a href="<?php echo site_url('email_template/list_email_template');?>" class="reload"></a>
								</div>
							</div><div class="clear"></div>	
							
						
           <div class="portlet-body">           
           	<div class="fl_right">	
					<a href="javascript:void(0)" onclick="setaction('chk[]','active', 'Are you sure, you want to activate selected record(s)?', 'frm_listlogin');" class="btn purple fl_left mar_r_5" >Active</a>
					<a href="javascript:void(0)" onclick="setaction('chk[]','inactive', 'Are you sure, you want to inactivate selected record(s)?', 'frm_listlogin');" class="btn yellow  fl_left mar_r_5" >Inactive</a>
					<div class="clear"></div>
					</div><div class="clear"></div>	   
					<form name="frm_listlogin" id="frm_listlogin" action="<?php echo base_url();?>email_template/action_email_template" method="post">
						
							<input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
									<input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
								   <input type="hidden" name="action" id="action" />
								   <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
 <div class="scroll-pane horizontal-only" ><table class="table table-striped table-bordered table-hover" id="sample_1">
                <thead>
                	
                    <tr>
                    	<th class="sorting_disabled" style="width: 0.1%;">
												<input type="checkbox" id="titleCheck" name="titleCheck"  onclick="setchecked('chk[]')" />
												</th>
                        <th class="sortCol">Email Template Name
                        		<?php if($sort_type == 'ASC' && $sort_by == 'task'){?>
													<a href="<?php echo site_url('email_template/'.$redirect_page.'/'.$limit.'/DESC/task/'.$offset);?>">
														<span class="srtup"></span>
													</a>
												<?php }else if($sort_type == 'DESC'&& $sort_by == 'email_template')
												{?>
													<a href="<?php echo site_url('email_template/'.$redirect_page.'/'.$limit.'/ASC/task/'.$offset);?>">
														<span class="srtdown"></span>
													</a>
												<?php }
												else
												{?>
												<a href="<?php echo site_url('email_template/'.$redirect_page.'/'.$limit.'/ASC/task/'.$offset);?>">
														<span class="sort"></span>
													</a>
												<?php }?>
                        </th>
                        <th class="sorting" style="width: 5%;">Status</th>
                        <th style="width:60px;">Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($template)
                    {
						$i=1;
                        foreach($template as $row)
                        {
						?>
					<tr>
						<td  style="width: 30px;"><input type="checkbox" name="chk[]" value="<?php echo $row->email_template_id ?>" class="chk"  /></td>
                        <td align="center" valign="middle"><?php echo $row->task;?></td>
                        <td class="center">
															<?php $cls = ($row->status=='active')?'purple':'yellow';?>
															<span class="<?php echo $cls;?>"><?php echo ucfirst($row->status); ?></span>
														</td>
                       <td align="center" width="60" valign="center" align="center">
                        <?php echo anchor('email_template/add_email_template/'.$row->email_template_id.'/'.$redirect_page.'/'.$sort_type.'/'.$sort_by.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset,'<i class="comon_icon edit_icon"></i>','class="table_icon btn blue"  title="Edit Email Template" class="tablectrl_small bBlue tipS" id="editTemplate_'.$row->email_template_id.'" ');?>
                        
                     
	                   </td>
                    </tr>
				<?php
							$i++;
							}
						} else { ?>
					<tr><td colspan="9" align="center"><strong>No Records Found</strong></td></tr>	
						<?php }?>	
                   
                </tbody>
                <?php if($page_link){ ?>
                <tr class="odd"><td colspan="10" align="center" >	
                	<div class="dataTables_paginate paging_full_numbers" style="float:right; padding-bottom:5px;">
			<ul class="pagination_new">
											<?php echo $page_link; ?>
							</ul>
									</div></td></tr>
			<?php } ?>	
            </table>
            </div>
            </form>
			</div>
					
					</div>
			
	
								<div class="clearfix"></div>
	
							</div>
							
	</div>
    </div>
    
    </div>					