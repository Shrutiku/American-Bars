<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/colorbox.css" />
<script src="<?php echo base_url().getThemeName();?>/js/jquery.colorbox.js" type="text/javascript"></script>

<script type="text/javascript" language="javascript">

	$(document).ready(function(){
		$('.view_message').click(function(){
			var msg_id = $(this).attr('data-id');
			$(this).colorbox({href:"<?php echo base_url();?>message/get_message_view?message_id="+msg_id+"&msg_type=sentbox", title:'View Message Detail'});
		});
	});

	function delete_rec(id,redirectpage,option,keyword,limit,offset) {
		var ans = confirm("Are you sure, you want to delete message?");
		if(ans) {
			location.href = "<?php echo base_url(); ?>message/delete_sent_message/"+id+"/"+redirectpage+"/"+option+"/"+keyword+"/"+limit+"/"+offset;
		}else{
			return false;
		}
	}
	
	function reply_message(id,redirectpage,option,keyword,limit,offset){
		location.href = "<?php echo base_url(); ?>message/reply_message/"+id+"/"+redirectpage+"/"+option+"/"+keyword+"/"+limit+"/"+offset;
	}
	
	function getlimit(limit) {
		
		if(limit=='0'){
			return false;
		} else {
			window.location.href='<?php echo base_url();?>message/sent_message/'+limit+'/';
		}
	}	
	
	function getsearchlimit(limit) {
		if(limit=='0') {
			return false;
		} else {	
			window.location.href='<?php echo base_url();?>message/search_sent_message/'+limit+'/<?php echo $option.'/'.$keyword; ?>';
		}
	
	}
	
	function gomain(x) {
		if(x == 'all')
		{
			window.location.href= '<?php echo base_url();?>message/sent_message';
		}
	}
	
	
function setchecked(elemName){
	elem = document.getElementsByName(elemName);
	if(document.getElementById("titleCheck").checked == true) {
		for(i=0;i<elem.length;i++){
			elem[i].checked=1;
		}
	} else {
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
		
		if(confirm(actionmsg)) {
			document.getElementById('action').value=actionval;	
			document.frm_listlogin.submit();
		}		
	}
}
</script>
<div class="page_content">

			<div class="container_fluid">
		
				<div class="row_fluid"> 
					<h3 class="page_title">Sentbox</h3>
				</div>
					<?php
						if($msg != ""){
						 	if($msg == "insert"){ $error = ADD_NEW_RECORD;}
							if($msg == "update"){ $error = UPDATE_RECORD;}
							if($msg == "delete"){ $error = DELETE_RECORD;}
							if($msg == "active") {  $error = ACTIVE_RECORD;}
							if($msg == "inactive"){ $error = INACTIVE_RECORD;}
							if($msg == "rights"){ $error = ASSIGN_RIGHTS;}
					?>
						<div class="success_msg"><?php echo '<p>'.$error.'</p>';?></div>
					<?php } ?>
				<div class="row_fluid"> 
					<div class="portlet blue">
						<div class="portlet-title">
							<div class="caption fl_left">Sentbox</div>
							<div class="fl_right">
                        
						<span class="sspan fl_left ">Show</span>
					    <?php if($search_type=='normal') { ?>
                        	<select name="limit" id="limit" onChange="getlimit(this.value)" style="width:80px; margin-top:5px;">
                        <?php } if($search_type=='search') { ?>
                          	<select name="limit" id="limit" onchange="getsearchlimit(this.value)" style="width:80px; margin-top:5px;">
                        <?php } ?>
                                <option value="0">Per Page</option>
                                <option value="5" <?php if($limit==5){?> selected="selected"<?php }?>>5</option>
                                <option value="10" <?php if($limit==10){?> selected="selected"<?php }?>>10</option>
                                <option value="15" <?php if($limit==15){?> selected="selected"<?php }?>>15</option>
                                <option value="25" <?php if($limit==25){?> selected="selected"<?php }?>>25</option>
                                <option value="50" <?php if($limit==50){?> selected="selected"<?php }?>>50</option>
                                <option value="75" <?php if($limit==75){?> selected="selected"<?php }?>>75</option>
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
							
							<?php /*?><div class="fl_left">
								 <?php			 
									$attributes = array('name'=>'frm_search','id'=>'frm_search');
									echo form_open('message/search_sent_message/'.$limit,$attributes);?>
									<div class="fl_left">
									<div class="sdrop fl_left wid228">
									<span class="sspan fl_left ">&nbsp;&nbsp;&nbsp;Search By</span>&nbsp;
											<select name="option" id="option" onChange="gomain(this.value)"  class="m_wrap fl_left mar0" style="padding:6px;">
												<option value="">--Please Select--</option>
												<option value="all">All</option>
												<option value="status" <?php if($option=='status'){?> selected="selected"<?php }?>>Status</option>  
																   
											</select>
									</div>
											<input type="text" name="keyword" id="keyword" value="<?php echo $keyword_data;?>"  class="search_key mar0" placeholder="Enter keyword" /> 
											</div>               
											<input type="submit" name="submit" id="submit" value="Search" class="btn blue  fl_left mar0" /> 
												</form>
												</div><?php */?>
							
							<div class="fl_right">
									<?php echo anchor('message/add_message','compose message', 'class="btn blue  fl_left mar_r_5" id="addmessage"'); ?>
									<?php /*?><a href="javascript:void(0)" onClick="setaction('chk[]','active', 'Are you sure, you want to activate selected record(s)?', 'frm_listlogin');" class="btn purple fl_left mar_r_5" >Active</a>
									<a href="javascript:void(0)" onClick="setaction('chk[]','inactive', 'Are you sure, you want to inactivate selected record(s)?', 'frm_listlogin');" class="btn yellow  fl_left mar_r_5" >Inactive</a><?php */?>
									<a href="javascript:void(0)" onClick="setaction('chk[]','delete', 'Are you sure, you want to delete selected record(s)?', 'frm_listlogin');" class="btn black  fl_left" >Delete</a>
										<div class="clear"></div>
									</div>
									<div class="clear"></div>
								<form name="frm_listlogin" id="frm_listlogin" action="<?php echo base_url();?>message/action_message" method="post">
									<input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
									<input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
									<input type="hidden" name="serach_keyword" id="serach_keyword" value="<?php echo $keyword_data; ?>" />
									<input type="hidden" name="serach_option" id="serach_option" value="<?php echo $option; ?>" />
									<input type="hidden" name="action" id="action" />
									<input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
									
									<table class="table border" >
										<thead>
											<tr>
											<th class="sorting_disabled" style="width: 0.1%;"> <input type="checkbox" id="titleCheck" name="titleCheck"  onclick="setchecked('chk[]')" /></th>
											<th class="sorting" style="width: 15%;">From</th>
											<th class="sorting" style="width: 15%;">To</th>
											<th class="sorting" style="width: 20%;">Subject</th>
											<th class="sorting" style="width: 5%;">View</th>
											<th class="sorting" style="width: 5%;">Action</th>
											</tr>
										</thead>
										<tbody role="alert" aria-live="polite" aria-relevant="all">	
											<?php
											if($result)
											{
												$i=1;
												foreach($result as $row){
													$cls=($i%2==0)?'even':'odd';
												?>
												<tr class="<?php echo $cls ?>">
													<td  style="width: 30px;"><input type="checkbox" name="chk[]" value="<?php echo $row->message_id; ?>" class="chk"  /></td>
													<td class=" sorting_1"><?php echo get_user_detail($row->from_user_id, $row->from_user_type ) ;?></td>
													<td><?php echo get_user_detail($row->to_user_id, $row->to_user_type )." (".ucfirst($row->to_user_type)." )"; ?></td>
													<td><?php echo $row->subject; ?></td>
													<td align="center" style="text-align:center;">
														<a class="table_icon btn blue view_message" data-id="<?php echo $row->message_id;?>" href="javascript://" title="View"><i class="comon_icon view_icon"></i></a>
													</td>
													<td>
														<?php //echo anchor('message/edit_message/'.$row->message_id.'/'.$redirect_page.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset,'<i class="comon_icon edit_icon"></i>','class="table_icon btn blue" id="message_'.$row->message_id.'" title="Edit message"'); ?>
														<a class="table_icon btn red" href="javascript://" onClick="delete_rec('<?php echo $row->message_id; ?>','<?php echo $redirect_page;?>','<?php echo $option?>','<?php echo $keyword?>','<?php echo $limit?>','<?php echo $offset; ?>')" title="Delete"><i class="comon_icon delete_icon"></i></a>
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
													<div class="dataTables_paginate paging_full_numbers" style="float:right"> <ul class="pagination_new"><?php echo $page_link; ?></ul></div></div>
												</td>						
											</tr>				
											<?php } ?>					
										</tbody>				
									</table>
								</form>
								
								
						</div>
						
						
					</div>
				</div>
			</div>
		</div>
	</div>