<script type="text/javascript" language="javascript">

	function delete_rec(id,redirectpage,option,keyword,sort_by,sort_type,limit,offset)
	{
		var ans = confirm("Are you sure to delete pages?");
		if(ans)
		{
			location.href = "<?php echo base_url(); ?>pages/delete_pages/"+id+"/"+redirectpage+"/"+option+"/"+keyword+"/"+sort_type+"/"+sort_by+"/"+limit+"/"+offset;
		}else{
			return false;
		}
	}
	
	function getlimit(limit)
	{
		if(limit=='0')
		{
		return false;
		}
		else
		{
			window.location.href='<?php echo base_url();?>pages/list_pages/'+limit;
		}
	
	}	
	
	function getsearchlimit(limit)
	{
		if(limit=='0')
		{
		return false;
		}
		else
		{
			
			window.location.href='<?php echo base_url();?>pages/search_list_pages/'+limit+'/<?php echo $option.'/'.$keyword; ?>';
		}
	
	}
	
	function gomain(x)
	{
		
		if(x == 'all')
		{
			window.location.href= '<?php echo base_url();?>pages/list_pages';
		}
		
	}
	
	
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
							List Pages
						</h3>
					
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
                <div class="row_fluid">
					<div class="span12">
	<?php 

		if($msg != ""){
	     if($msg == "insert"){ $error = ADD_NEW_RECORD;}
            if($msg == "update"){ $error = UPDATE_RECORD;}
            if($msg == "delete"){ $error = DELETE_RECORD;}
			if($msg == "active") {  $error = ACTIVE_RECORD;}
			if($msg == "inactive"){ $error = INACTIVE_RECORD;}
			if($msg == "rights"){ $error = ASSIGN_RIGHTS;}
    ?>
        <div class="success_msg">
							
							<p>	<?php echo $error;?></p>
						</div>
    <?php } ?>
	
	<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<div class="caption fl_left"><i class="icon-globe"></i><!-- Manage Pages --></div>
								<div class="fl_right">
                                        	<span>Show</span>
                                            <?php if($search_type=='normal') { ?>
                        	<select class="layout-option m-wrap small"  name="limit" id="limit" onchange="getlimit(this.value)" style="width:80px;">
                        <?php } if($search_type=='search') { ?>
                          	<select class="layout-option m-wrap small"  name="limit" id="limit" onchange="getsearchlimit(this.value)" style="width:80px;">
                        <?php } ?>
                                <option value="0">Per Page</option>
                                <option value="5" <?php if($limit==5){?> selected="selected"<?php }?>>5</option>
                                <option value="10"  <?php if($limit==10){?> selected="selected"<?php }?>>10</option>
                                <option value="15"  <?php if($limit==15){?> selected="selected"<?php }?>>15</option>
                                <option value="25"  <?php if($limit==25){?> selected="selected"<?php }?>>25</option>
                                <option value="50"  <?php if($limit==50){?> selected="selected"<?php }?>>50</option>
                                <option value="75"  <?php if($limit==75){?> selected="selected"<?php }?>>75</option>
                                <option value="100"  <?php if($limit==100){?> selected="selected"<?php }?>>100</option>     
                       	   </select>
                            </div>
                            <div class="clear"></div>
							</div>
							<div class="portlet-body">
								<div clas="table-toolbar">
                                	<div class="row_fluid">
                                <div class="fl_left">
                                         <?php			 
					$attributes = array('name'=>'frm_search','id'=>'frm_search');
					echo form_open('pages/search_list_pages/'.$limit,$attributes);?>
					<div class="sdrop fl_left wid228">
                    <span class="sspan fl_left ">Search By</span> 
                     <select name="option"  id="option" onchange="gomain(this.value)" class="m_wrap fl_left mar0" style="width: 120px;padding:6px;">
                            	<option value="">All</option> 
                                <option value="pages_title" <?php if($option=='pages_title'){?> selected="selected"<?php }?>>Title</option>  
                               
                            </select>
							
							<?php 
							if($keyword != '1V1')
							{
								$keyword_data = $keyword;
							}
							else
							{
								$keyword_data ='';
							}
							?>
							
						 </div>
						 	<input type="text" name="keyword" id="keyword" value="<?php echo $keyword_data;?>" class="search_key mar0" placeholder="Enter keyword" />                
                            <input type="submit" name="submit" id="submit" value="Search" class="fl_left btn blue mar10"  /> 
                
                <input type="button" name="refresh" id="submit" value="Refresh" class="btn blue  fl_left mar10" onclick="document.location.href ='<?php echo site_url("pages/list_pages/"); ?>'" />
                	</form>
                   
                  </div>
                                	<div class="fl_right">
									
                                    
					<!--<a href="<?php echo site_url('pages/add_pages');?>" class="btn blue  fl_left mar_r_5">Add New</a>
					 <a class="btn purple fl_left mar_r_5" href="javascript:void(0)" onclick="setaction('chk[]','active', 'Are you sure, you want to active selected record(s)?', 'frm_listlogin');">Active <i class="icon-thumbs-up"></i></a>
                	<a class="btn yellow  fl_left mar_r_5" href="javascript:void(0)" onclick="setaction('chk[]','inactive', 'Are you sure, you want to inactive selected record(s)?', 'frm_listlogin');">Inactive <i class="icon-thumbs-down"></i></a> -->
					<!-- <a class="btn black  fl_left"  href="javascript:void(0)" onclick="setaction('chk[]','delete', 'Are you sure, you want to delete selected record(s)?', 'frm_listlogin');">Delete <i class="icon-minus"></i></a>
									 -->
                                   
                                    </div>
							
                            </div>
					<form name="frm_listlogin" id="frm_listlogin" action="<?php echo base_url();?>pages/action_pages" method="post"	>
					<input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
									<input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
									<input type="hidden" name="serach_keyword" id="serach_keyword" value="<?php echo $keyword_data; ?>" />
									<input type="hidden" name="serach_option" id="serach_option" value="<?php echo $option; ?>" />
									<input type="hidden" name="action_sorttype" id="action_sorttype" value="<?php echo $sort_type; ?>" />
									<input type="hidden" name="action_sortby" id="action_sortby" value="<?php echo $sort_by; ?>" />
								   <input type="hidden" name="action" id="action" />
								   <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
			<div class="clear"></div>	  
			<div class="scroll-pane horizontal-only" ><table class="table table-striped table-bordered table-hover" id="sample_1">
                <thead>
                    <tr>
					   <!-- 
					   	Future enhancement for multiple delete option
					   	<th width="10" align="center">
					   	<input type="checkbox" id="titleCheck" name="titleCheck"  onclick="setchecked('chk[]')" />	
					   	</th> -->
					    <th style="width: 80%">Pages Title
                        	<?php if($sort_type == 'ASC' && $sort_by == 'pages_title'){?>
								<a href="<?php echo site_url('pages/'.$redirect_page.'/'.$limit.'/DESC/pages_title/'.$offset);?>">
									<span class="srtup"></span>
								</a>
							<?php }else if($sort_type == 'DESC'&& $sort_by == 'pages_title')
							{?>
								<a href="<?php echo site_url('pages/'.$redirect_page.'/'.$limit.'/ASC/pages_title/'.$offset);?>">
									<span class="srtdown"></span>
								</a>
							<?php }
							else
							{?>
							<a href="<?php echo site_url('pages/'.$redirect_page.'/'.$limit.'/ASC/pages_title/'.$offset);?>">
									<span class="sort"></span>
								</a>
							<?php }?>
                        </th>
                    
                    
						<th width="60">Status</th>
						<th style="width: 8%;">Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($result)
                    {
						$i=0;
                        foreach($result as $row)
                        {
						?>
					<tr>
						<?php /*?><td align="center"> <input type="checkbox" name="chk[]" value="<?php echo $row->pages_id ?>" class="chk"  /> </td><?php */?>
						
                   		<td><?php echo $row->pages_title; ?></td>
						
                      
						<td class="center hidden-480" style="text-align:center;">
							<?php
								$cls = ($row->active=='1')?'purple':'yellow';
								$status = ($row->active=="1")?'Active':'Inactive';
							?>
							<span class="<?php echo $cls;?>"><?php echo ucfirst($status); ?></span>
						</td>                            
                        
                      	
						<td align="center">
                        	<?php echo anchor('pages/edit_pages/'.$row->pages_id.'/'.$redirect_page.'/'.$sort_type.'/'.$sort_by.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset,'<i class="comon_icon edit_icon"></i>','class="table_icon btn blue" id="admin_'.$row->pages_id.'" title="Edit Admin"'); ?>
					   		<a href="javascript://" onClick="delete_rec('<?php echo $row->pages_id; ?>','<?php echo $redirect_page;?>','<?php echo $option?>','<?php echo $keyword?>','<?php echo $sort_by;?>','<?php echo $sort_type;?>','<?php echo $limit?>','<?php echo $offset; ?>')" title="Delete" class="table_icon btn red"><i class="comon_icon delete_icon"></i></a>
                       </td>
                    </tr>
				<?php
							$i++;
							}
						} else { ?>
					<tr><td colspan="4" align="center" style=" text-align: center"><strong>No Records Found</strong></td></tr>	
						<?php }?>	
                   
                </tbody>
                <?php if(strlen($page_link)>0){ ?>
								<tr class="odd">
										<td class=" sorting_1" colspan="3" style="text-align:center!important;"><div class="fg-toolbar tableFooter">
				<div class="dataTables_paginate paging_full_numbers" style="float:right"> <ul class="pagination_new"><?php echo $page_link; ?></ul></div>
			</div></td>
														
													</tr>				
								<?php } ?>				
            </table>
			</div>
			</form>
		
								<div class="clearfix"></div>
							</div>
							
						</div>
						
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
				</div>
				<!-- END PAGE CONTENT-->
			</div>
			<!-- END PAGE CONTAINER-->
		</div>
		<!-- END PAGE -->
	</div>