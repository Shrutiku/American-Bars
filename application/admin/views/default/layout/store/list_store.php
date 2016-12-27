<script type="text/javascript" language="javascript">
	function delete_rec(id,redirectpage,option,keyword,limit,offset)
	{
		var ans = confirm("Are you sure, you want to delete store?");
		if(ans)
		{
			location.href = "<?php echo base_url(); ?>store/delete_store/"+id+"/"+redirectpage+"/"+option+"/"+keyword+"/"+limit+"/"+offset;
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
			window.location.href='<?php echo base_url();?>store/list_store/'+limit+'/';
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
			
			window.location.href='<?php echo base_url();?>store/search_list_store/'+limit+'/<?php echo $option.'/'.$keyword; ?>';
		}
	
	}
	
	function gomain(x)
	{
		
		if(x == 'all')
		{
			window.location.href= '<?php echo base_url();?>store/list_store/';
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
<div class="page_content">

			<div class="container_fluid">
		
				<div class="row_fluid"> 
					<h3 class="page_title">Bar Store Product</h3>
					
				</div>
					<?php 

		if($msg != ""){
	     if($msg == "insert"){ $error = ADD_NEW_RECORD;}
            if($msg == "update"){ $error = UPDATE_RECORD;}
            if($msg == "delete"){ $error = DELETE_RECORD;}
			if($msg == "active") {  $error = ACTIVE_RECORD;}
			if($msg == "inactive"){ $error = INACTIVE_RECORD;}
			if($msg == "pending") {  $error = ACTIVE_RECORD;}
			if($msg == "deliver") {  $error = ACTIVE_RECORD;}
			if($msg == "rights"){ $error = ASSIGN_RIGHTS;}
    ?>
        <div class="success_msg"><?php echo '<p>'.$error.'</p>';?></div>
    <?php } ?>
				<div class="row_fluid"> 
					<div class="portlet blue">
						<div class="portlet-title">
							<div class="caption fl_left"> Bar Store Product </div>
							
					<div class="clear"></div>
							</div>
						<div class="portlet-body form">
							<?php 
							if($keyword != '1V1')
							{
								$keyword_data = str_replace('-',' ',$keyword);
							}
							else
							{
								$keyword_data ='';
							}
							?>
							
									<div class="fl_right">
										
										
										
					<?php //echo anchor('store/add_store','Add New', 'class="btn blue  fl_left mar_r_5" id="addstore"'); ?>
					<a href="javascript:void(0)" onclick="setaction('chk[]','active', 'Are you sure, you want to activate selected record(s)?', 'frm_listlogin');" class="btn purple fl_left mar_r_5" >Active</a>
					<a href="javascript:void(0)" onclick="setaction('chk[]','inactive', 'Are you sure, you want to inactivate selected record(s)?', 'frm_listlogin');" class="btn yellow  fl_left mar_r_5" >Inactive</a>
<!--					<a href="javascript:void(0)" onclick="setaction('chk[]','pending', 'Are you sure, you want to pending selected record(s)?', 'frm_listlogin');" class="btn red fl_left mar_r_5" >pending</a>-->
					<!--<a href="javascript:void(0)" onclick="setaction('chk[]','deliver', 'Are you sure, you want to Delivered selected record(s)?', 'frm_listlogin');" class="btn green fl_left mar_r_5" >Deliver</a>-->
					<a href="javascript:void(0)" onclick="setaction('chk[]','delete', 'Are you sure, you want to delete selected record(s)?', 'frm_listlogin');" class="btn black  fl_left" >Delete</a>
					
					<div class="clear"></div>		
										
										
										<div class="clear"></div>
									</div>
									<div class="clear"></div>
					<form name="frm_listlogin" id="frm_listlogin" action="<?php echo base_url();?>store/action_store" method="post">
					<input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
					<input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
					<input type="hidden" name="serach_keyword" id="serach_keyword" value="<?php echo $keyword_data; ?>" />
					<input type="hidden" name="serach_option" id="serach_option" value="<?php echo $option; ?>" />
					
					
            	   <input type="hidden" name="action" id="action" />
				   <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
							<div class="scroll-pane horizontal-only" >		<table class="table border" >
												<thead>
												<tr>
												<th class="sorting_disabled" style="width: 0.1%;">
												<input type="checkbox" id="titleCheck" name="titleCheck"  onclick="setchecked('chk[]')" />
												</th>
												<th class="sorting" style="width: 5%;">Product Name</th>
												<th class="sorting" style="width: 5%;">Status</th>
												<th class="sorting" style="width: 5%;">Action</th>
												</tr>

												</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">	
									<?php
								if($result)
								{
									$i=1;
									foreach($result as $row)
									{    $cls=($i%2==0)?'even':'odd';
									//print_r($row); ?>
									<tr class="<?php echo $cls ?>">
									<td  style="width: 30px;"><input type="checkbox" name="chk[]" value="<?php echo $row->store_id ?>" class="chk"  /></td>
														<td><?php echo ucfirst($row->product_name); ?></td>
													
														<td class="center">
															<?php 
															if($row->status=='active'){
															$cls= 'purple';
															}
															else if($row->status=='inactive'){
															$cls= 'yellow';
															}
															else if($row->status=='pending'){
															$cls= 'red';
															}
															else{
																$cls= 'green';
															}?>
															<span class="<?php echo $cls;?>"><?php echo ucfirst($row->status); ?></span>
														</td>
														
														<td style="text-align: center;">
														<?php 
							//FUTURE 
							 	echo anchor('store/edit_store/'.$row->store_id.'/'.$redirect_page.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset,'<i class="comon_icon edit_icon"></i>','class="table_icon btn blue" id="store_'.$row->store_id.'" title="Edit store"'); 
						?>
														<!--Futture enhancement															
															<a class="btn green table_icon" href="javascript:;"><i class="comon_icon view_icon"></i></a>-->
														<?php //echo  anchor('store/edit_store/'.$row->store_id.'/'.$redirect_page.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset,'<i class="comon_icon edit_icon"></i>','class="table_icon btn blue" id="store_'.$row->store_id.'" title="Edit store"');  ?>
														<a class="table_icon btn red" href="javascript://" onClick="delete_rec('<?php echo $row->store_id; ?>','<?php echo $redirect_page;?>','<?php echo $option?>','<?php echo $keyword?>','<?php echo $limit?>','<?php echo $offset; ?>')" title="Delete"><i class="comon_icon delete_icon"></i></a>
														</td>
													</tr>
								<?php $i++;} }else{ ?>
								
												
													<tr class="odd">
														<td class=" sorting_1" colspan="10" style="text-align:center!important;">No Records Found</td>
														
													</tr>
								<?php } ?>
								
											
								<?php if(strlen($page_link)>0){ ?>
								<tr class="odd">
										<td class=" sorting_1" colspan="10" style="text-align:center!important;"><div class="fg-toolbar tableFooter">
				<div class="dataTables_paginate paging_full_numbers" style="float:right"> <ul class="pagination_new"><?php echo $page_link; ?></ul></div>
			</div></td>
														
													</tr>				
								<?php } ?>					
								</tbody>				
											</table>
										</div>	
								</form>
								
								
						</div>
						
						
					</div>
				</div>
			</div>
		</div>
	</div>