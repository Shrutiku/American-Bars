<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/assets/plugins/bootstrap-daterangepicker/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/assets/plugins/font-awesome/css/font-awesome.min.css" />

<script src="<?php echo base_url().getThemeName();?>/assets/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url().getThemeName();?>/assets/plugins/bootstrap-daterangepicker/date.js" type="text/javascript"></script>
<style>
.daterangepicker
{
	display: none;
}
.uneditable-input, textarea.m-wrap, input.m-wrap[type="text"], input.m-wrap[type="password"], input.m-wrap[type="datetime"], input.m-wrap[type="datetime-local"], input.m-wrap[type="date"], input.m-wrap[type="month"], input.m-wrap[type="time"], input.m-wrap[type="week"], input.m-wrap[type="number"], input.m-wrap[type="email"], input.m-wrap[type="url"], input.m-wrap[type="search"], input.m-wrap[type="tel"], input.m-wrap[type="color"] {
    background-attachment: scroll;
    background-clip: border-box;
    background-color: transparent;
    background-image: none !important;
    background-origin: padding-box;
    background-position: 0 0;
    background-repeat: repeat;
    background-size: auto auto;
    border-radius: 0;
    box-shadow: none !important;
    color: #333333;
    filter: none !important;
    font-size: 11px;
    margin-bottom:10px;
    font-weight: normal;
    height: 20px;
    line-height: 20px;
    outline: 0 none;
    padding: 6px !important;
    vertical-align: top;
}
input[disabled], select[disabled], textarea[disabled] {
    background-color: #f4f4f4 !important;
    cursor: not-allowed;
}
input.m-wrap {
    border: 1px solid #e5e5e5;
}
input.m-wrap, button.m-wrap, select.m-wrap, textarea.m-wrap {
    font-family: "Segoe UI","Helvetica Neue",Helvetica,Arial,sans-serif;
}
label.m-wrap, input.m-wrap, button.m-wrap, select.m-wrap, textarea.m-wrap {
    font-size: 14px;
    font-weight: normal;
    line-height: 20px;
}
.m-wrap{
	width: 60px;
	font-size: 13px;
}
.dropdown-menu {
    border: 1px solid #ddd;
    box-shadow: 0 1px 8px rgba(0, 0, 0, 0.1);
    display: none;
    float: left;
    font-family: "Segoe UI",Helvetica,Arial,sans-serif;
    font-size: 14px;
    left: 0;
    list-style: outside none none;
    margin: 0;
    padding: 0;
    position: absolute;
    text-shadow: none;
    top: 100%;
    z-index: 1000;
}
	.modal {
    background-clip: padding-box;
    background-color: #FFFFFF;
    border: 1px solid rgba(0, 0, 0, 0.3);
    border-radius: 6px;
    box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
    left: 50%;
    margin-left: -280px;
    outline: 0 none;
    position: fixed;
    top: 10%;
    width: 560px;
    z-index: 1050;
}
.modal-header {
    border-bottom: 1px solid #EEEEEE;
    padding: 9px 15px;
}
button.close {
    background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
    border: 0 none;
    cursor: pointer;
    padding: 0;
}
.modal-header h3 {
    line-height: 30px;
    margin: 0;
}
.modal-body {
    max-height: 400px;
    overflow-y: auto;
    padding: 15px;
    position: relative;
}
.modal-backdrop, .modal-backdrop.fade.in {
    background-color: #333333 !important;
}
.modal-backdrop {
    background-color: #000000;
    bottom: 0;
    left: 0;
    position: fixed;
    right: 0;
    top: 0;
    z-index: 1040;
}
.alert-danger, .alert-error {
    background-color: #F2DEDE;
    border-color: #EED3D7;
    color: #B94A48;
    padding: 10px;
}
.modal-footer {
    background-color: #F5F5F5;
    border-radius: 0 0 6px 6px;
    border-top: 1px solid #DDDDDD;
    box-shadow: 0 1px 0 #FFFFFF inset;
    margin-bottom: 0;
    padding: 14px 15px 15px;
    text-align: right;
}
</style>
<?php $theam_url = base_url().getThemeName(); ?>
		<!-- styles needed by jScrollPane - include in your own sites -->

		<link href="<?php echo $theam_url; ?>/assets/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
		
<script src="<?php echo $theam_url; ?>/assets/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript" ></script>

<script src="<?php echo $theam_url; ?>/assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript" ></script>

<script type="text/javascript" language="javascript">

$(document).ready(function(){
		
		
		
	});
	
	function delete_rec(id,redirectpage,option,keyword,bar_id,limit,offset)
	{
		var ans = confirm("Are you sure, you want to delete event?");
		if(ans)
		{
			location.href = "<?php echo base_url(); ?>event/delete_event/"+id+"/"+redirectpage+"/"+option+"/"+keyword+"/"+bar_id+"/"+limit+"/"+offset;
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
		 window.location.href= '<?php echo base_url();?>event/list_event/'+limit+'/<?php echo $bars_id ?>';
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
			
			window.location.href='<?php echo base_url();?>event/search_list_event/'+limit+'/<?php echo $option.'/'.$keyword."/".$date; ?>';
		}
	
	}
	
	function gomain(x)
	{
		
		if(x == 'all')
		{
			window.location.href= '<?php echo base_url();?>event/list_event/'+limit+'/<?php echo $bars_id ?>';
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


<div id="ajax-modal" class="modal fade" tabindex="-1" data-width="400" style="display: none;"></div>	
<script>
function getAllEventDate(id)
{
	
		var $modal = $('#ajax-modal');
		 $('body').modalmanager('loading');
		 //alert(this.href);
		 var url='<?php echo base_url(); ?>event/getEventDate/'+id+'/';
		// return false;
		  setTimeout(function(){
		     $modal.load(url, '', function(){
		      $modal.modal().on("hidden", function() {
              	$modal.empty();
              })
              .one('shown.bs.modal', function(){
              		
              		
              }).modal();;
		    });
		  }, 1000);
		  return false;
	
	
}
	$(document).ready(function() {
		
		   
   
    
});
$(document).ready(function(){	
	$('#date').daterangepicker({
		format : 'yyyy-MM-dd',
		separator: 'to',});
	 });
</script>
<div class="page_content">

			<div class="container_fluid">
		
				<div class="row_fluid"> 
					<h3 class="page_title">Event Listing</h3>
					
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
							<div class="caption fl_left">Event Listing</div>
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
					echo form_open('event/search_list_event/'.$limit,$attributes);?>
					<div class="fl_left">
					<div class="sdrop fl_left wid228">
					<span class="sspan fl_left ">&nbsp;&nbsp;&nbsp;Search By</span>&nbsp;
                            <select name="option" id="option" onchange="gomain(this.value)"  class="m_wrap fl_left mar0" style="padding:6px;">
                            
								<option value="">--Please Select--</option>
                                <option value="event_title" <?php if($option=='event_title'){?> selected="selected"<?php }?>>Event Title</option> 
                                <option value="city" <?php if($option=='city'){?> selected="selected"<?php }?>>City</option>
                                <option value="zipcode" <?php if($option=='zipcode'){?> selected="selected"<?php }?>>Zipcode</option>
                                <?php /*?><option value="phone_number" <?php if($option=='phone_number'){?> selected="selected"<?php }?>>Phone Number</option> <?php */?>
                                                          
                            </select>
					</div>	<input type="hidden" name="bars_id" id="bars_id" value="<?php echo $bars_id; ?>" />
							<input type="text" name="keyword" id="keyword" value="<?php echo $keyword_data;?>"  class="search_key mar0" placeholder="Enter keyword" />
							<input type="text" name="date" id="date" value="<?php echo $date!='' && $date!='1V1' ? $date:'';?>"  class="search_key mar0" placeholder="" /> 
							</div>               
                            <input type="submit" name="submit" id="submit" value="Search" class="btn blue  fl_left mar10" /> 
                          
                             <input type="button" name="refresh" id="refresh" value="Refresh" class="btn blue  fl_left mar10" onclick="document.location.href = '<?php echo site_url("event/list_event/".$limit.'/'.$bars_id); ?>'" /> 
								</form>
								</div>
									<div class="fl_right">
										
										
										
					<?php echo anchor('event/add_event/'.$bars_id,'Add New', 'class="btn blue  fl_left mar_r_5" id="addevent"'); ?>
					<a href="javascript:void(0)" onclick="setaction('chk[]','active', 'Are you sure, you want to activate selected record(s)?', 'frm_listlogin');" class="btn purple fl_left mar_r_5" >Active</a>
					<a href="javascript:void(0)" onclick="setaction('chk[]','inactive', 'Are you sure, you want to inactivate selected record(s)?', 'frm_listlogin');" class="btn yellow  fl_left mar_r_5" >Inactive</a>
					<a href="javascript:void(0)" onclick="setaction('chk[]','delete', 'Are you sure, you want to delete selected record(s)?', 'frm_listlogin');" class="btn black  fl_left" >Delete</a>
					
					<div class="clear"></div>		
										
										
										<div class="clear"></div>
									</div>
									<div class="clear"></div>
			<form name="frm_listlogin" id="frm_listlogin" action="<?php echo base_url();?>event/action_event" method="post">
	<input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
					<input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
					<input type="hidden" name="serach_keyword" id="serach_keyword" value="<?php echo $keyword_data; ?>" />
					<input type="hidden" name="serach_option" id="serach_option" value="<?php echo $option; ?>" />
					<input type="hidden" name="search_date" id="search_date" value="<?php echo $date!='' && $date!='1V1' ? $date:'';?>"  />
					<input type="hidden" name="bars_id" id="bars_id" value="<?php echo $bars_id; ?>" />
					
            	   <input type="hidden" name="action" id="action" />
				   <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
							<div class="scroll-pane horizontal-only" >		<table class="table border" >
												<thead>
												<tr>
												<th class="sorting_disabled" style="width: 0.1%;">
												<input type="checkbox" id="titleCheck" name="titleCheck"  onclick="setchecked('chk[]')" />
												</th>
												<th class="sorting_disabled" style="width: 6%;">Event Title</th>
												<th class="sorting_disabled" style="width: 6%;">Date</th>
												<th class="sorting_disabled"style="width: 6%;">Bar Name</th>
												<th class="sorting" style="width: 5%;">Address</th>
												<th class="sorting" style="width: 5%;">City</th>
												<th class="sorting" style="width: 5%;">State</th>
										    	<th class="sorting" style="width: 5%;">Power boost event</th>
												<th class="sorting" style="width: 5%;">status</th>
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
									<td  style="width: 30px;"><input type="checkbox" name="chk[]" value="<?php echo $row->event_id ?>" class="chk"  /></td>
														
														
														
														<td><?php echo $row->event_title; ?></td>
														<td><?php echo date('m/d/Y',strtotime($row->eventdate)); ?>
															 <a href="javascript://" onclick="getAllEventDate(<?php echo $row->event_id?>)">View All</a>
														</td>
														<td><?php echo $row->bar_title; ?></td>
														
													
														<td><?php echo $row->address; ?></td>
														<td><?php echo $row->city; ?></td>
														<td><?php echo $row->state; ?></td>
														<td><?php if($row->is_power_boost_event=="1"){echo "Yes";} else {echo "No";}?></td>
												
														
														<td class="center">
															<?php $cls = ($row->status=='active')?'purple':'yellow';?>
															<span class="<?php echo $cls;?>"><?php echo ucfirst($row->status); ?></span>
														</td>
														
														<td style="text-align: center;">
														
														<!--Futture enhancement															
															<a class="btn green table_icon" href="javascript:;"><i class="comon_icon view_icon"></i></a>-->
														<?php echo  anchor('event/edit_event/'.$row->event_id.'/'.$redirect_page.'/'.$option.'/'.$keyword.'/'.$date.'/'.$limit.'/'.$offset."/".$bars_id,'<i class="comon_icon edit_icon"></i>','class="table_icon btn blue" id="event_'.$row->event_id.'" title="Edit event"');  ?>
														<a class="table_icon btn red" href="javascript://" onClick="delete_rec('<?php echo $row->event_id; ?>','<?php echo $redirect_page;?>','<?php echo $option?>','<?php echo $keyword?>','<?php echo $bars_id ?>','<?php echo $limit ;?>','<?php echo $offset; ?>')" title="Delete"><i class="comon_icon delete_icon"></i></a>
														</td>
													</tr>
								<?php $i++;} }else{ ?>
								
												
													<tr class="odd">
														<td class="sorting_1" colspan="12" style="text-align:center!important;">No Records Found</td>
														
													</tr>
								<?php } ?>
								
											
								<?php if(strlen($page_link)>0){ ?>
								<tr class="odd">
										<td class="sorting_1" colspan="12" style="text-align:center!important;"><div class="fg-toolbar tableFooter">
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