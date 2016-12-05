
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/datepicker/jquery.datetimepicker.css" />
<script src="<?php echo base_url().getThemeName();?>/datepicker/jquery.datetimepicker.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css"/>

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
	$(document).ready(function() {
		$('#ui_date_picker_range_from').datetimepicker({
	//mask:'9999/19/39 29:59'
});
$('#ui_date_picker_range_to').datetimepicker({
	//mask:'9999/19/39 29:59'
});
	bindJquery();	
	// $()
    // $('#frm_search').live('submit', function(event) {
        // var $form = $(this);
        // var $target = $($form.attr('data-target'));
//  
        // $.ajax({
            // type: $form.attr('method'),
            // url: $form.attr('action'),
            // cache: false,
            // data: $form.serialize(),
            // beforeSend : function() {
				// blockUI('.portlet-body');
			// },success: function(data, status) {
                // $target.html(data);
                // bindJquery();	
            // },complete : function() {
				// unblockUI('.portlet-body');
			// },
        // });
//  
        // event.preventDefault();
    // });
    



	});
function gomain(x)
	{
		
		if(x == 'all')
		{
			window.location.href= '<?php echo site_url('order/orderlist');?>';
		}
		
	}	
function bindJquery()
{
	
	//jQuery('input').uniform();
	jQuery('.group-checkable').change(function () {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).attr("checked", true);
                    } else {
                        $(this).attr("checked", false);
                    }
                });
                jQuery.uniform.update(set);
            });
            
      $('#frm_search').on('submit', function(event) {
        var $form = $(this);
        var $target = $($form.attr('data-target'));
 
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            cache: false,
            data: $form.serialize(),
            beforeSend : function() {$query
			},success: function(data, status) {
                $target.html(data);
                bindJquery();	
            },complete : function() {
			},
        });
 
        event.preventDefault();
    });
    
}
function getData(limit,offset)
{
	/*var limit=($('#limit').val()!='')?$('#limit').val():'<?php //echo $limit ?>';*/
	var redirect_page=$('#redirect_page').val();
	if(redirect_page=='orderlist'){ 
	var url='<?php echo site_url('order') ?>/'+redirect_page+'/'+limit+'/'+offset;
	}else{
		var url='<?php echo site_url('order/') ?>/'+redirect_page+'/'+limit+'/<?php echo $option.'/'.$keyword.'/'; ?>'+offset;
	 } 
	// alert(url);
	
	
	$.ajax({
			url : url,
			cache: false,
			beforeSend : function() {
			},
			success : function(response) {
				// alert(response);
				$('#content').html('');
				$('#content').html(response);
				bindJquery();
			},
			complete : function() {
			},
	});
	
}
function delete_rec(id,redirectpage,option,keyword,from_date,to_date,limit,offset)
	{
		var ans = confirm("Are you sure, you want to delete  order?");
		if(ans)
		{
			location.href = "<?php echo base_url(); ?>order/deleteOrder/"+id+"/"+redirectpage+"/"+option+"/"+keyword+"/"+from_date+"/"+to_date+"/"+limit+"/"+offset;
		
			
		}else{
			return false;
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
			//document.getElementById('action').value=actionval;	
			$('#frm_listlogin').submit();
		
		}		
		
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
			/*window.location.href='<?php //echo base_url();?>user/list_user/'+limit;*/
			
			$.ajax({
			url : '<?php echo site_url('order/orderlist/') ?>/'+limit,
			beforeSend : function() {
			},
			success : function(data) {
				$('#content').html(data);
				bindJquery();
			},
			complete : function() {
			}
		});
			
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
			window.location.href='<?php echo base_url();?>order/searchOrderlist/'+limit+'/<?php echo $option.'/'.$keyword.'/'.@$from_date.'/'.@$to_date; ?>';
		}
	
	}
	function displayCal(x){
		if(x=='date')
		{
			$("#key_date").show();
			$("#keyword").hide();
		}
		else{
			$("#key_date").hide();
			$("#keyword").show();	
		}
	}
	function statusChange(order_id,order_status){
		$.ajax({
			url : '<?php echo site_url('order/statusChange');?>/'+order_id+'/'+order_status+'/',
			beforeSend : function() {
			},
			success : function(data) {
				if(data=='done'){
					$.growlUI('<?php echo 'Status Change Successfully'; ?>'); 
					// if(order_status=="Canceled")
				// {
					// $("#remove_"+order_id).hide();
					// $("#add_"+order_id).html("Canceled");
				// }
					
				}
			},
			complete : function() {
				
			}
		});
		}5

</script>
<style type="text/css">
	#key_date{
		display: none;
	}
	#ui_date_picker_range_from,#ui_date_picker_range_to{
		margin-left: 15px;
		border: 1px solid #E5E5E5 !important;
	}
	#frm_search_date{
		float: right;
	}
</style>
<!-- BEGIN CONTAINER -->

<!-- BEGIN PAGE -->
<div class="page_content">

			<div class="container_fluid">
		
				<div class="row_fluid"> 
					<h3 class="page_title">Bar Products Order List</h3>
					
					
				</div>
					<?php 

		if($msg != ""){
	     if($msg == "insert"){ $error = ADD_NEW_RECORD;}
            if($msg == "update"){ $error = UPDATE_RECORD;}
            if($msg == "delete"){ $error = DELETE_RECORD;}
			if($msg == "active") {  $error = ACTIVE_RECORD;}
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
                                <option value="1" <?php if($limit==5){?> selected="selected"<?php }?>>5</option>
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
						<div class="portlet-body form ">
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
					echo form_open('order/searchOrderlist/'.$limit,$attributes);?>
					<div class="fl_left">
					<div class="sdrop fl_left wid228">
					<span class="sspan fl_left ">&nbsp;&nbsp;&nbsp;Search By</span>&nbsp;
                            <select name="option" id="option" onchange="gomain(this.value)"  class="m_wrap fl_left mar0" style="padding:6px;">
                            		
								<option value="">--Please Select--</option>
                                 <option value="first_name" <?php if($option=='first_name'){?> selected="selected"<?php }?>>Username</option>
                           	 <option value="status" <?php if($option=='status'){?> selected="selected"<?php }?>>Status</option>
                           
                                                   
                           </select>
					</div>
							<input type="text" name="keyword" id="keyword" value="<?php echo $keyword_data;?>"  class="search_key mar0" placeholder="Enter keyword" /> 
							</div>          
							<input class="search_key mar0 date" size="16" type="text" id="ui_date_picker_range_from" name="from_date" value="<?php echo @$from_date=='1V1' ? '':@$from_date;?>" placeholder="From"/>
						<input class="search_key mar0 date" size="16" type="text" id="ui_date_picker_range_to" name="to_date" value="<?php echo @$to_date=='1V1' ? '':@$to_date;?>" placeholder="To"/>
						 
						
					
                            <input type="submit" name="submit" id="submit" value="Search" class="btn blue  fl_left mar10" />
                              <input type="button" name="refresh" id="submit" value="Refresh" class="btn blue  fl_left mar10" onclick="document.location.href = '<?php echo site_url("order/orderlist/"); ?>'" /> 
								</form>
								</div>
									<div class="fl_right">
					<a href="javascript:void(0)" onclick="setaction('chk[]','delete', 'Are you sure, you want to delete selected record(s)?', 'frm_listlogin');" class="btn black  fl_left" >Delete</a>
					
					<div class="clear"></div>		
										
										
										<div class="clear"></div>
									</div>
									<div class="clear"></div>
			<form name="frm_listlogin" id="frm_listlogin" action="<?php echo base_url();?>order/actionOrder" method="post">
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
												<th class="sorting_disabled" style="width: 20%;">Order No.</th>
												<th class="sorting_disabled" style="width: 10%;">Username</th>
												
												<th class="sorting_disabled" style="width: 20%;">Email</th>
												<th class="sorting" style="width: 10%;">Order Date</th>
												<th class="sorting" style="width: 5%;">Total</th>
												<th class="sorting" style="width: 5%;">Status</th>
												<th class="sorting" style="width: 5%;">Print</th>
												
												<th class="sorting" style="width:2%;">Action</th>
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
									<td  style="width: 30px;"><input type="checkbox" name="chk[]" value="<?php echo $row->order_id ?>" class="chk"  /></td>
														<td class=" sorting_1"><?php echo $row->order_number; ?></td>
														<td class=" sorting_1"><?php echo ucfirst($row->first_name); ?></td>
														<td class=" sorting_1"><?php echo $row->email; ?></td>
														<td class=" sorting_1"><?php echo date($site_setting->date_format, strtotime($row->order_date)); ?></td>
														<td class=" sorting_1"><?php echo $site_setting->currency_symbol.' '.$row->total; ?></td>
														
														<td id="remove_<?php echo $row->order_id; ?>">
						<?php if($row->status!='Canceled'){ ?>
						<select name="status" class="m_wrap fl_left mar0" onchange="statusChange(<?php echo $row->order_id;?>,this.value);">
							<option value="Pending" <?php if($row->status=="Pending"){ echo 'selected="selected"';}else{echo"";} ?>>Pending</option>
							<option value="Shipped" <?php if($row->status=="Shipped"){ echo 'selected="selected"';}else{echo"";} ?>>Shipped</option>
							<option value="Completed" <?php if($row->status=="Completed"){ echo 'selected="selected"';}else{echo"";} ?>>Completed</option>
							<option value="Canceled" <?php if($row->status=="Canceled"){ echo 'selected="selected"';}else{echo "";} ?>>Canceled</option>
							<option value="Closed" <?php if($row->status=="Closed"){ echo 'selected="selected"';}else{echo"";} ?>>Closed</option>
						</select>
						<?php } else { ?>
							Canceled
						<?php } ?>	
					</td>
														<td><a target="_blank" href="<?php echo base_url().'order/print_order/'.$row->order_id ?>">Print</a></td>
														
														<td>
														
														 <a title="View" class="table_icon btn blue" href="<?php echo site_url('order/orderDetails/'.$row->order_id.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset); ?>" ><i class="comon_icon view_icon"></i></a>
														<a class="table_icon btn red" href="javascript://" onClick="delete_rec('<?php echo $row->order_id; ?>','<?php echo $redirect_page;?>','<?php echo $option?>','<?php echo $keyword?>','<?php echo @$from_date?>','<?php echo @$to_date?>','<?php echo $limit?>','<?php echo $offset; ?>')" title="Delete"><i class="comon_icon delete_icon"></i></a>
														</td>
													</tr>
								<?php $i++;} }else{ ?>
								
												
													<tr class="odd">
														<td class=" sorting_1" colspan="9" style="text-align:center!important;">No Records Found</td>
														
													</tr>
								<?php } ?>
								
											
								<?php if(strlen($page_link)>0){ ?>
								<tr class="odd">
										<td class=" sorting_1" colspan="110" style="text-align:center!important;"><div class="fg-toolbar tableFooter">
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
<!-- END CONTAINER -->
