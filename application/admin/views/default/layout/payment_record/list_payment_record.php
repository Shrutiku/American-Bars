
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/datepicker/jquery.datetimepicker.css" />
<script src="<?php echo base_url().getThemeName();?>/datepicker/jquery.datetimepicker.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css"/>

<script type="text/javascript" language="javascript">
$(document).ready(function() {
		$('#ui_date_picker_range_from').datetimepicker({
	//mask:'9999/19/39 29:59'
});
$('#ui_date_picker_range_to').datetimepicker({
	//mask:'9999/19/39 29:59'
});
});
function donwloadCSV(){
		$('#downloadCSV #opt').val($('#option').val());
		$('#downloadCSV #key').val($('input[name=keyword]:checked').val());
		
		$('#downloadCSV').submit();
	}
	function delete_rec(id,redirectpage,option,keyword,limit,offset,from_date,to_date)
	{
		var ans = confirm("Are you sure, you want to delete payment_record?");
		if(ans)
		{
			location.href = "<?php echo base_url(); ?>payment_record/delete_payment_record/"+id+"/"+redirectpage+"/"+option+"/"+keyword+"/"+from_date+"/"+to_date+"/"+limit+"/"+offset;
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
			window.location.href='<?php echo base_url();?>payment_record/list_payment_record/'+limit+'/';
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
			
			window.location.href='<?php echo base_url();?>payment_record/search_list_payment_record/'+limit+'/<?php echo $option.'/'.$keyword.'/'.@$from_date.'/'.@$to_date; ?>';
		}
	
	}
	
	function gomain(x)
	{
		
		if(x == 'all')
		{
			window.location.href= '<?php echo base_url();?>payment_record/list_payment_record/';
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
					<h3 class="page_title">Bar Owner Payment Report </h3>
					
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
							<div class="caption fl_left"> Bar Owner Payment Report </div>
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
							<?php $att=array('id'=>'downloadCSV','name'=>'downloadCSV','class'=>'no-margin');
										echo form_open('payment_record/downloadPaymentRecord',$att) ?>
										<input type="hidden" value="" id="opt" name="opt" />
										<input type="hidden" value="" id="key" name="key" />
										
									</form>
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
					echo form_open('payment_record/search_list_payment_record/'.$limit,$attributes);?>
					<div class="fl_left">
					<div class="sdrop fl_left wid228">
					<span class="sspan fl_left ">&nbsp;&nbsp;&nbsp;Search By</span>&nbsp;
                            <select name="option" id="option" onchange="gomain(this.value)"  class="m_wrap fl_left mar0" style="padding:6px;">
                            
								<option value="">--Please Select--</option>
								<option value="name" <?php if($option=='name'){?> selected="selected"<?php }?>>User Name</option>
								  
<?php /*?>                                <option value="type" <?php if($option=='type'){?> selected="selected"<?php }?>>Type</option>                 
                                <option value="producer" <?php if($option=='producer'){?> selected="selected"<?php }?>>Producer</option>
                                 <option value="city_produced" <?php if($option=='city_produced'){?> selected="selected"<?php }?>>City Produced</option><?php */?>
                            </select>
					</div>
							<input type="text" name="keyword" id="keyword" value="<?php echo $keyword_data;?>"  class="search_key mar0" placeholder="Enter keyword" /> 
							</div>       
							<input class="search_key mar0 date" size="16" type="text" id="ui_date_picker_range_from" name="from_date" value="<?php echo @$from_date=='1V1' ? '':@$from_date;?>" placeholder="From"/>
						<input class="search_key mar0 date" size="16" type="text" id="ui_date_picker_range_to" name="to_date" value="<?php echo @$to_date=='1V1' ? '':@$to_date;?>" placeholder="To"/>
						         
                            <input type="submit" name="submit" id="submit" value="Search" class="btn blue  fl_left mar10" /> 
                          
                             <input type="button" name="refresh" id="refresh" value="Refresh" class="btn blue  fl_left mar10" onclick="document.location.href = '<?php echo site_url("payment_record"); ?>'" /> 
								</form>
								</div>
									<div class="fl_right">
										
						<a href="javascript://" onclick="donwloadCSV()" class="btn blue  fl_left mar_r_5 btn black"><i class="icon-download"></i> download</a>
										<a href="javascript:void(0)" onclick="setaction('chk[]','delete', 'Are you sure, you want to delete selected record(s)?', 'frm_listlogin');" class="btn black  fl_left" >Delete</a>
					<?php //echo anchor('payment_record/add_payment_record','Add New', 'class="btn blue  fl_left mar_r_5" id="addpayment_record"'); ?>
					<!-- <a href="javascript:void(0)" onclick="setaction('chk[]','active', 'Are you sure, you want to activate selected record(s)?', 'frm_listlogin');" class="btn purple fl_left mar_r_5" >Active</a>
					<a href="javascript:void(0)" onclick="setaction('chk[]','inactive', 'Are you sure, you want to inactivate selected record(s)?', 'frm_listlogin');" class="btn yellow  fl_left mar_r_5" >Inactive</a>
					<a href="javascript:void(0)" onclick="setaction('chk[]','pending', 'Are you sure, you want to pending selected record(s)?', 'frm_listlogin');" class="btn red fl_left mar_r_5" >pending</a>
					<a href="javascript:void(0)" onclick="setaction('chk[]','deliver', 'Are you sure, you want to Delivered selected record(s)?', 'frm_listlogin');" class="btn green fl_left mar_r_5" >Deliver</a>
					
					<div class="btn-group">
						<a href="javascript://" onclick="donwloadCSV()" class="btn black"><i class="icon-download"></i> download</a>
					</div>
					<div class="clear"></div>	 -->	
										
										
										<div class="clear"></div>
									</div>
									<div class="clear"></div>
					<form name="frm_listlogin" id="frm_listlogin" action="<?php echo base_url();?>payment_record/action_payment_record" method="post">
					<input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
					<input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
					<input type="hidden" name="serach_keyword" id="serach_keyword" value="<?php echo $keyword_data; ?>" />
					<input type="hidden" name="serach_option" id="serach_option" value="<?php echo $option; ?>" />
					
					
            	   <input type="hidden" name="action" id="action" />
				   <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
								<div class="scroll-pane horizontal-only" >	<table class="table border" >
												<thead>
												<tr>
												<th class="sorting_disabled" style="width: 0.1%;">
												<input type="checkbox" id="titleCheck" name="titleCheck"  onclick="setchecked('chk[]')" />
												</th>
												
												<th class="sorting" style="width: 5%;">User Name</th>
												<th class="sorting" style="width: 5%;">Bar Name</th>
												<th class="sorting" style="width: 5%;">User Email</th>
												<th class="sorting_disabled" style="width: 6%;">Price</th>
												<th class="sorting_disabled" style="width: 6%;">Transaction ID</th>
												<th class="sorting" style="width: 5%;">Date</th>
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
									<td  style="width: 30px;"><input type="checkbox" name="chk[]" value="<?php echo $row->transaction_id ?>" class="chk"  /></td>
													
														<td><?php echo $row->first_name.' '.$row->last_name; ?></td>
														<td><a target="_blank" href="<?php echo front_base_url().'bar/details/'.$row->bar_slug;?>"> <?php echo $row->bar_title; ?></a></td>
														<td><?php echo $row->email; ?></td>
														<td class=" sorting_1"><?php echo $row->price; ?></td>
														<td><?php echo $row->txn_id; ?></td>
														<td><?php echo date($site_setting->date_format,strtotime($row->transaction_date)); ?></td>
														
														<td>
														<?php 
							
																//echo anchor('transaction/edit_transaction/'.$row->transaction_id.'/'.$redirect_page.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset,'<i class="comon_icon edit_icon"></i>','class="table_icon btn blue" id="transaction_'.$row->transaction_id.'" title="Edit Admin"'); 
														?>
														
														<a class="table_icon btn red" href="javascript://" onClick="delete_rec('<?php echo $row->transaction_id; ?>','<?php echo $redirect_page;?>','<?php echo $option?>','<?php echo $keyword?>','<?php echo $limit?>','<?php echo $offset; ?>','<?php echo @$from_date; ?>','<?php echo @$to_date; ?>')" title="Delete"><i class="comon_icon delete_icon"></i></a>
														</td>
													</tr>
								<?php $i++;} }else{ ?>
								
												
													<tr class="odd">
														<td class=" sorting_1" colspan="8" style="text-align:center!important;">No Records Found</td>
														
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
								</form>
								</div>
								
						</div>
						
						
					</div>
				</div>
			</div>
		</div>
	</div>