<script type="text/javascript" language="javascript">
	
	function delete_rec(id,redirectpage,option,keyword,limit,offset)
	{
		var ans = confirm("Are you sure, you want to delete trivia?");
		if(ans)
		{
			location.href = "<?php echo base_url(); ?>trivia/delete_trivia/"+id+"/"+redirectpage+"/"+option+"/"+keyword+"/"+limit+"/"+offset;
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
			window.location.href='<?php echo base_url();?>trivia/list_trivia/'+limit+'/';
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
			
			window.location.href='<?php echo base_url();?>trivia/search_list_trivia/'+limit+'/<?php echo $option.'/'.$keyword; ?>';
		}
	
	}
	
	function gomain(x)
	{
		
		if(x == 'all')
		{
			window.location.href= '<?php echo base_url();?>trivia/list_trivia/';
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

	function reply_message(id,redirectpage,option,keyword,limit,offset){
		location.href = "<?php echo base_url(); ?>trivia/view/"+id+"/"+redirectpage+"/"+option+"/"+keyword+"/"+limit+"/"+offset;
	}

</script>
<div class="page_content">

			<div class="container_fluid">
		
				<div class="row_fluid"> 
					<h3 class="page_title">Trivia Listing</h3>
					
					
				</div>
					<?php 

		if($msg != ""){
	     if($msg == "insert"){ $error = ADD_NEW_RECORD;}
            if($msg == "update"){ $error = UPDATE_RECORD;}
            if($msg == "delete"){ $error = DELETE_RECORD;}
			if($msg == "active") {  $error = ACTIVE_RECORD;}
			 if($msg == "Success"){ $error = ADD_NEW_RECORD;}
			if($msg == "inactive"){ $error = INACTIVE_RECORD;}
			if($msg == "rights"){ $error = ASSIGN_RIGHTS;}
			if($msg == "no_rights"){ $error = NO_RIGHTS;}
			
    ?>
        <div class="success_msg"><?php echo '<p>'.$error.'</p>';?></div>
    <?php } ?>
				<div class="row_fluid"> 
					<div class="portlet blue">
						<div class="portlet-title">
							<div class="caption fl_left"></div>
							<div class="fl_right">
                        
						<span class="sspan fl_left ">Show</span>
					    <?php if($search_type=='normal') { ?>
                        	<select name="limit" id="limit" onchange="getlimit(this.value)" style="width:80px; margin-top:5px;">
                        <?php } if($search_type=='search') { ?>
                          	<select name="limit" id="limit" onchange="getsearchlimit(this.value)" style="width:80px; margin-top:5px;">
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
							<div class="fl_left">
								 <?php			 
					$attributes = array('name'=>'frm_search','id'=>'frm_search');
					echo form_open('trivia/search_list_trivia/'.$limit,$attributes);?>
					<div class="fl_left">
					
							<input type="text" name="keyword" id="keyword" value="<?php echo $keyword_data;?>"  class="search_key mar0" placeholder="Enter keyword" /> 
							</div>           
                            <input type="submit" name="submit" id="submit" value="Search" class="btn blue  fl_left mar10" />
                              <input type="button" name="refresh" id="submit" value="Refresh" class="btn blue  fl_left mar10" onclick="document.location.href = '<?php echo site_url("trivia/list_trivia/"); ?>'" /> 
								</form>
								</div>
									<div class="fl_right">	
					<?php echo anchor(site_url("trivia/add_trivia/"),'Add New', 'class="btn blue  fl_left mar_r_5" id="addadmin"'); ?>
					<a href="javascript:void(0)" onclick="setaction('chk[]','active', 'Are you sure, you want to activate selected record(s)?', 'frm_listlogin');" class="btn purple fl_left mar_r_5" >Active</a>
					<a href="javascript:void(0)" onclick="setaction('chk[]','inactive', 'Are you sure, you want to inactivate selected record(s)?', 'frm_listlogin');" class="btn yellow  fl_left mar_r_5" >Inactive</a>
					<a href="javascript:void(0)" onclick="setaction('chk[]','delete', 'Are you sure, you want to delete selected record(s)?', 'frm_listlogin');" class="btn black  fl_left" >Delete</a>
										
					<div class="clear"></div>																					
										<div class="clear"></div>
									</div>
									<div class="clear"></div>
			<form name="frm_listlogin" id="frm_listlogin" action="<?php echo base_url();?>trivia/action_trivia" method="post">
	               <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
					<input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
					<input type="hidden" name="serach_keyword" id="serach_keyword" value="<?php echo $keyword_data; ?>" />
					<input type="hidden" name="serach_option" id="serach_option" value="<?php echo $option; ?>" />
					
            	   <input type="hidden" name="action" id="action" />
				   <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
				  
				   <div class="scroll-pane horizontal-only" >
				   
									<table class="table border" >
												<thead>
												<tr>
												<th class="sorting_disabled" style="width: 0.1%;">
												<input type="checkbox" id="titleCheck" name="titleCheck"  onclick="setchecked('chk[]')" />
												</th>
												<th class="sorting_disabled">Question</th>
												<th class="sorting" style="width:7%;">Status</th>
												<th class="sorting" style="width:7%;">Action</th>
												</tr>

												</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">	
									<?php
								if($result)
								{
									$i=1;
									foreach($result as $row)
									{    $cls=($i%2==0)?'even':'odd';
									 ?>
									<tr class="<?php echo $cls ?>">
									<td  style="width: 30px;"><input type="checkbox" name="chk[]" value="<?php echo $row->trivia_id ?>" class="chk"  /></td>
										<td class=" sorting_1"><?php echo $row->question; ?></td>
										
										<td class="center">
                                            <?php $cls = ($row->status=='active')?'purple':'yellow';?>
                                            <span class="<?php echo $cls;?>"><?php echo ucfirst($row->status); ?></span>
                                        </td>
										<td>
										<?php 
												echo anchor('trivia/edit_trivia/'.$row->trivia_id.'/'.$redirect_page.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset,'<i class="comon_icon edit_icon"></i>','class="table_icon btn blue" id="trivia_'.$row->trivia_id.'" title="Edit Admin"'); 
										?>
										<a class="table_icon btn red" href="javascript://" onClick="delete_rec('<?php echo $row->trivia_id;?>','<?php echo $redirect_page;?>','<?php echo $option?>','<?php echo $keyword?>','<?php echo $limit?>','<?php echo $offset; ?>')" title="Delete"><i class="comon_icon delete_icon"></i></a>
										</td>
														
									</tr>
								<?php $i++;} }else{ ?>
									<tr class="odd">
										<td class=" sorting_1" colspan="6" style="text-align:center!important;">No Records Found</td>
										
									</tr>
								<?php } ?>
								
											
								<?php if(strlen($page_link)>0){ ?>
								<tr class="odd">
										<td class=" sorting_1" colspan="6" style="text-align:center!important;"><div class="fg-toolbar tableFooter">
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