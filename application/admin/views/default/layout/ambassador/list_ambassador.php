<!--<h1>test</h1>-->

<style>
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
		 styles needed by jScrollPane - include in your own sites 

		<link href="<?php echo $theam_url; ?>/assets/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
		
<script src="<?php echo $theam_url; ?>/assets/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript" ></script>

<script src="<?php echo $theam_url; ?>/assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript" ></script>
<script type="text/javascript" language="javascript">
//
//	function delete_rec(id,redirectpage,option,keyword,limit,offset)
//	{
//		var ans = confirm("Are you sure, you want to delete this ambassador?");
//		if(ans)
//		{
//			location.href = "<?php echo base_url(); ?>bar/delete_bar/<?php echo $bar_type; ?>/"+id+"/"+redirectpage+"/"+option+"/"+keyword+"/"+limit+"/"+offset;
//		}else{
//			return false;
//		}
//	}
//	
//	function getlimit(limit)
//	{
//		
//		if(limit ==='0')
//		{
//		return false;
//		}
//		else
//		{
//			window.location.href='<?php echo base_url();?>bar/list_ambassador/<?php echo $bar_type;?>/'+limit+'/';
//		}
//	
//	}	
//	
//	function getsearchlimit(limit)
//	{
//		if(limit ==='0')
//		{
//		return false;
//		}
//		else
//		{
//			
//			window.location.href='<?php echo base_url();?>bar/search_list_bar/<?php echo $bar_type; ?>/'+limit+'/<?php echo $option.'/'.$keyword; ?>';
//		}
//	
//	}
//	
//	function gomain(x)
//	{
//		
//		if(x === 'all')
//		{
//			window.location.href= '<?php echo base_url();?>bar/list_bar/<?php echo $bar_type; ?>';
//		}
//		
//	}
//	
//	
//function setchecked(elemName){
//	elem = document.getElementsByName(elemName);
//	if(document.getElementById("titleCheck").checked === true)
//	{
//		for(i=0;i<elem.length;i++){
//			elem[i].checked=1;
//		}
//	}
//	else
//	{
//		for(i=0;i<elem.length;i++){
//			elem[i].checked=0;
//		}
//	}
//}
//
//function setaction(elename, actionval, actionmsg, formname) {
//
//	vchkcnt=0;
//	elem = document.getElementsByName(elename);
//	
//	for(i=0;i<elem.length;i++){
//		if(elem[i].checked) vchkcnt++;	
//	}
//	if(vchkcnt === 0) {
//		alert('Please select a record')
//	} else {
//		
//		if(confirm(actionmsg))
//		{
//			document.getElementById('action').value=actionval;	
//			document.frm_listlogin.submit();
//		}		
//		
//	}
//}
//
//	function reply_message(id,redirectpage,option,keyword,limit){
//		location.href = "<?php echo base_url(); ?>bar/comment/<?php echo $bar_type; ?>/"+id+"/"+redirectpage+"/"+option+"/"+keyword+"/"+limit;
//	}
</script>

<div id="ajax-modal" class="modal fade" tabindex="-1" data-width="400" style="display: none;"></div>	
<script>
//function changePassword(id,limit,offset)
//{
//	
//		var $modal = $('#ajax-modal');
//		 $('body').modalmanager('loading');
//		 //alert(this.href);
//		 var url='<?php echo base_url(); ?>bar/setNewPassword/'+id+'/';
//		// return false;
//		  setTimeout(function(){
//		     $modal.load(url, '', function(){
//		      $modal.modal().on("hidden", function() {
//              	$modal.empty();
//              })
//              .one('shown.bs.modal', function(){
//              		
//              		$('#submitSet').click(function()
//              		{
//              			//alert('fdsa');
//              			$('#noteerror').fadeOut();
//              			
//              				
//              				 $.ajax({
//				            type: 'POST',
//				            dataType:'Json',
//				            url: url,
//				            data: $('#setPstat').serialize(),
//				            beforeSend : function() {
//								blockUI('#setPstat');
//							},success: function(data) {
//				                if(data.error.length>0){
//				                	$('#errorDiv').html(function(){
//				                		$(this).html(data.error);
//				                		$(this).fadeIn();
//				                	});
//				                	//$.growlUI(data.msg); 
//				                	//$modal.modal('toggle');
//				                	//getData(limit,offset);	
//				                	
//				                	
//				                }else{
//				                	window.reload();
//				                		
//				                }
//				               // $.growlUI(data.msg); 
//				            },complete : function() {
//								unblockUI('#setPstat');
//								
//							},
//				        });
//              				
//              			
//              		});
//              		
//              		
//              }).modal();;
//		    });
//		  }, 1000);
//		  return false;
//	
//	
//}
//	$(document).ready(function() {
//		
//		   
//   
//    
//});
//
//function donwloadCSV(){
//   //alert($('#fd').val());
//        $('#downloadCSV #opt').val($('#option').val());
//        $('#downloadCSV #key').val($('#keyword').val());
//        $('#downloadCSV #typ').val($('#b_type').val());
//        $('#downloadCSV').submit();
//    }
</script>
 User For Rating  

  Rating End 
 
 <?php //$att=array('id'=>'downloadCSV','name'=>'downloadCSV','class'=>'no-margin');
            //                            echo form_open('bar/download',$att) ?>
<!--                                        <input type="hidden" value="" id="opt" name="opt" />
                                        <input type="hidden" value="" id="key" name="key" />
                                        <input type="hidden" value="" id="typ" name="typ" />
                                    </form>-->
                                    
                                    <!--<input name="b_type" id="b_type" type="hidden" value="<?php echo $bar_type; ?>"  />-->
<div class="page_content">

			<div class="container_fluid">
		
				<div class="row_fluid"> 
					<h3 class="page_title">Ambassadors</h3>	
				</div>
<?php 
//   if($er!='')
//		   {
//		  $tags = explode('*',  base64_decode($er));
//		  
//		 // print_r(array_filter($tags));
//		 
//		 // die;
//		 if(isset($tags[1])){
//		   	 $error =  "<p>Total Uploaded = ".(base64_decode($er1)-count(array_filter($tags)))." Records</p><p>Total Failed = ".count(array_filter($tags))." Records</p><p>Failed row  :<b> ".substr(str_replace('*', ', ', base64_decode($er)),0,-2)." </b></p>" ;
//		   }
//		 else {
//			 $error =  "<p>Total Uploaded = ".(base64_decode($er1)-1)." Records</p><p>Total Failed = 0 Records</p><p>Failed row  :<b> ".substr(str_replace('*', ', ', base64_decode($er)),0,-2)." </b></p>" ;
//		 }
//		   }
//		   else if($msg != "") {
//			   if($msg == "Successfully"){ $error = "Import Data Successfully";}
//		   }
//		if($msg != ""){
//	     if($msg == "insert"){ $error = ADD_NEW_RECORD;}
//		 if($msg == "claimed"){ $error = CLAIM_RECORD;}
//		 if($msg == "unclaimed"){ $error = UNCLAIM_RECORD;}
//            if($msg == "update"){ $error = UPDATE_RECORD;}
//            if($msg == "delete"){ $error = DELETE_RECORD;}
//			 if($msg == "Success"){ $error = ADD_NEW_RECORD;}
//			if($msg == "active") {  $error = ACTIVE_RECORD;}
//			if($msg == "inactive"){ $error = INACTIVE_RECORD;}
//			if($msg == "archived"){ $error = ARCHIVED_RECORD;}
//			if($msg == "rights"){ $error = ASSIGN_RIGHTS;}			
?>
        <!--<div class="success_msg"><?php// echo '<p>'.$error.'</p>';?></div>-->
    <?php //} ?>
				<div class="row_fluid"> 
					<div class="portlet blue">
						<div class="portlet-title">
							<div class="caption fl_left"></div>
							<div class="fl_right">
                        
						<span class="sspan fl_left ">Show</span>
					    <?php// if($search_type=='normal') { ?>
                        	<!--<select name="limit" id="limit" onchange="getlimit(this.value)" style="width:80px; margin-top:5px;">-->
                        <?php //} if($search_type=='search') { ?>
                          	<!--<select name="limit" id="limit" onchange="getsearchlimit(this.value)" style="width:80px; margin-top:5px;">-->
                        <?php //} ?>
<!--                                <option value="0">Per Page</option>
                                <option value="5" <?php //if($limit==5){?> selected="selected"<?php //}?>>5</option>
                                <option value="10"  <?php //if($limit==10){?> selected="selected"<?php //}?>>10</option>
                                <option value="15"  <?php //if($limit==15){?> selected="selected"<?php //}?>>15</option>
                                <option value="25"  <?php //if($limit==25){?> selected="selected"<?php //}?>>25</option>
                                <option value="50"  <?php //if($limit==50){?> selected="selected"<?php //}?>>50</option>
                                <option value="75"  <?php //if($limit==75){?> selected="selected"<?php //}?>>75</option>
                                <option value="100"  <?php //if($limit==100){?> selected="selected"<?php //}?>>100</option>     -->
                       	   <!--</select>-->
                                                        </div>
					<div class="clear"></div>
							</div>
						<div class="portlet-body form ">
							<?php 
//							if($keyword != '1V1')
//							{
//								$keyword_data = str_replace('-',' ',$keyword);
//							}
//							else
//							{
//								$keyword_data ='';
//							}
							?>
							
							
							<div class="fl_left">
								 <?php			 
					// $attributes = array('name'=>'frm_search','id'=>'frm_search');
					// echo form_open('bar/search_list_bar/'.$bar_type."/".$limit,$attributes);?>
					<div class="fl_left">
					<div class="sdrop fl_left wid140">
<!--                            <select name="option" id="option" onchange="gomain(this.value)"  class="m_wrap fl_left mar0" style="padding:6px;">
                            		
                                <option value="bar_title" <?php //if($option=='bar_title'){?> selected="selected"<?php //}?>>Bar Title</option>
                                <option value="city" <?php //if($option=='city'){?> selected="selected"<?php //}?>>City</option>
                                <option value="state" <?php //if($option=='state'){?> selected="selected"<?php //}?>>State</option>
                                <option value="cust_num" <?php //if($option=='cust_num'){?> selected="selected"<?php //}?>>Customer #</option>
                                 <option value="email" <?php //if($option=='email'){?> selected="selected"<?php //}?>>Email</option> 
                                 <option value="zipcode" <?php //if($option=='zipcode'){?> selected="selected"<?php //}?>>Zipcode</option>
                                <option value="phone" <?php //if($option=='phone'){?> selected="selected"<?php //}?>>phone</option>
                             
                                                   
                           </select>-->
					</div>
							<input type="text" name="keyword" id="keyword" value="<?php //echo $keyword_data;?>"  class="search_key mar0" placeholder="Enter keyword" /> 
							</div>           
                            <input type="submit" name="submit" id="submit" value="Search" class="btn blue  fl_left mar10" />
                              <input type="button" name="refresh" id="submit" value="Refresh" class="btn blue  fl_left mar10" onclick="document.location.href = '<?php // echo site_url("bar/list_bar/".$bar_type); ?>'" /> 
								</form>
								</div>
									<div class="fl_right">
					<?php //echo anchor('bar/add_bar/'.$bar_type,'Add New', 'class="btn blue  fl_left mar_r_5" id="addbar"'); ?>
					<?php //echo anchor('bar/import_bar','Import 	xls', 'class="btn blue  fl_left mar_r_5" id="addbeer"'); ?>
<!--					<a href="<?php //echo front_base_url().'upload/bar.xls';?>" class='btn purple fl_left mar_r_5'>Demo xls</a>
					<a href="javascript:void(0)" onclick="setaction('chk[]','active', 'Are you sure, you want to activate selected record(s)?', 'frm_listlogin');" class="btn purple fl_left mar_r_5" >Active</a>
					<a href="javascript:void(0)" onclick="setaction('chk[]','inactive', 'Are you sure, you want to inactivate selected record(s)?', 'frm_listlogin');" class="btn yellow  fl_left mar_r_5" >Inactive</a>
					-->
					<?php //if($this->session->userdata('admin_type')==1){?>
						  <!--<a href="javascript:void(0)" onclick="donwloadCSV();" class="btn black mar_r_5  fl_left" >Download</a>-->
					<?php// } ?>	
<!--					<a href="javascript:void(0)" onclick="setaction('chk[]','delete', 'Are you sure, you want to delete selected record(s)?', 'frm_listlogin');" class="btn black  fl_left mar_r_5" >Delete</a>
					
					<a href="javascript:void(0)" onclick="setaction('chk[]','claimed', 'Are you sure, you want to claimed selected record(s)?', 'frm_listlogin');" class="btn blue  fl_left mar_r_5" >Claimed</a>
					<a href="javascript:void(0)" onclick="setaction('chk[]','unclaimed', 'Are you sure, you want to unclaimed selected record(s)?', 'frm_listlogin');" class="btn blue  fl_left mar_r_5" >Unclaimed</a>
					<a href="javascript:void(0)" onclick="setaction('chk[]','archived', 'Are you sure, you want to archived selected record(s)?', 'frm_listlogin');" class="btn blue  fl_left mar_r_5" >Archived</a>
					-->
					<div class="clear"></div>		
										
										
										<div class="clear"></div>
									</div>
									<div class="clear"></div>
			<form name="frm_listlogin" id="frm_listlogin" action="<?php // echo base_url();?>bar/action_bar/<?php // echo $bar_type; ?>" method="post">
	<input type="hidden" name="offset" id="offset" value="<?php // echo $offset; ?>" />
					<input type="hidden" name="limit" id="limit" value="<?php // echo $limit; ?>" />
					<input type="hidden" name="serach_keyword" id="serach_keyword" value="<?php // echo $keyword_data; ?>" />
					<input type="hidden" name="serach_option" id="serach_option" value="<?php // echo $option; ?>" />
					
            	   <input type="hidden" name="action" id="action" />
				   <input type="hidden" name="redirect_page" id="redirect_page" value="<?php // echo $redirect_page;?>"/>
				   <div class="scroll-pane horizontal-only" >
									<table class="table border" >
										
												<thead>
												<tr>
												<th class="sorting_disabled" style="width: 0.1%;">
												<input type="checkbox" id="titleCheck" name="titleCheck"  onclick="setchecked('chk[]')" />
												</th>
												<th class="sorting_disabled" style="width: 5%;">Customer#</th>
												<th class="sorting_disabled" style="width: 5%;">Bar Title</th>
												<th class="sorting_disabled" style="width: 5%;">Username</th>
												<?php // if($bar_type=='all'){?>
												<th class="sorting_disabled" style="width: 5%;">Bar Type</th>
												<?php // } ?>	
												 <th class="sorting_disabled" style="width: 6%;">Email</th> 
												<th class="sorting" style="width: 5%;">City</th>
												<th class="sorting" style="width: 4%;">State</th>
												
												 <th class="sorting" style="width: 5%;">zipcode</th> 
												 <th class="sorting" style="width: 5%;">Phone Number</th> 
												<th class="sorting" style="width: 10%;">Reviews And Ratings</th><?php 
												//echo $bar_type;
//												if($bar_type=='full_mug' || $bar_type=='managed_bar' ){?>
												
												 <th class="sorting" style="width: 5%;">Happy Hours</th> 
												<th class="sorting" style="width: 5%;">Event</th>
												<th class="sorting" style="width: 5%;">Gallery</th>
												<th class="sorting" style="width: 5%;">Beers</th>
												<th class="sorting" style="width: 5%;">Cocktail / Liquor</th>
												<th class="sorting" style="width: 5%;">Postcard</th>
												<th class="sorting" style="width: 4%;">Cap Logo</th>
												<th class="sorting" style="width: 4%;">Tshirt Logo</th><?php// } ?>
												<th class="sorting" style="width: 5%;">Date Time</th>
												 <th class="sorting" style="width: 5%;">Change Password</th> 
												<th class="sorting" style="width: 5%;">Status</th>
												<th class="sorting" style="width: 5%;">Domain AB</th>
												<th class="sorting" style="width:7%;">Action</th>
																<th class="sorting" style="width:7%;">Claimed</th>
												
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
									<td  style="width: 30px;"><input type="checkbox" name="chk[]" value="<?php echo $row->bar_id ?>" class="chk"  /></td>
														<td class=" sorting_1 break-column"><?php echo $row->bar_id; ?></td>								
														<td class=" sorting_1 break-column"><a target="_blank" href="<?php echo front_base_url().'bar/details/'.$row->bar_slug;?>"><?php echo ucwords($row->bar_title); ?></a></td>
														<?php $getbar = $this->bar_model->get_one_bar($row->bar_id);?>
														<td class=" sorting_1 break-column"><?php echo $getbar['first_name']!='' ? $getbar['first_name']." ".$getbar['last_name']:'ADB'; ?></td>
														 <td class=" sorting_1"><?php echo $row->email; ?></td> 
														<?php if($bar_type=='all'){?>
														<td><?php if($row->bar_type=='half_mug'){ echo "Half Mug"; } else  { echo "Full Mug" ;} ?></td>
														<?php } ?>
														<td class=" sorting_1"><?php echo $row->city; ?></td>
														<td class=" sorting_1"><?php echo $row->state; ?></td>
														 <td class=" sorting_1"><?php echo $row->zipcode; ?></td> 
														 <td class=" sorting_1"><?php echo $row->phone; ?></td> 
													
														<td class=" sorting_1"><div class="pull-left"><?php echo getReviewRating($row->bar_id); ?></div><a class="btn blue table_icon pull-left" href="javascript://" onclick="reply_message('<?php echo $row->bar_id; ?>','<?php echo $redirect_page;?>','<?php echo $option?>','<?php echo $keyword?>','<?php echo $limit?>');" title="View"><i class="comon_icon view_icon"></i></a>
															(<?php echo totalbarcomment($row->bar_id);?>)
															<div class="clearfix"></div>
														</td>														
														<?php if($bar_type=='full_mug' || $bar_type=='managed_bar' ){?>
															 <td class=" sorting_1" style="text-align:center;"><a class="btn red mini" href="<?php echo site_url("bar/add_happy_hours/".$row->bar_id); ?>">Add </a></td> 
														<td class=" sorting_1" style="text-align:center;"><a class="btn red mini" href="<?php echo site_url("event/list_event/".$limit."/".$row->bar_id); ?>">Events</a></td>
														<td class=" sorting_1" style="text-align:center;"><a class="btn red mini" href="<?php echo site_url("bar_gallery/list_gallery/".$limit."/".$row->bar_id); ?>">Gallery</a></td>
														<td class=" sorting_1" style="text-align:center;"><a class="btn red mini" href="<?php echo site_url("beer/list_beer/".$limit."/".$row->bar_id); ?>">Beer</a></td>
														<td class=" sorting_1" style="text-align:center;">
															<?php if($row->serve_as=='cocktail'){?>
															<a class="btn red mini" href="<?php echo site_url("cocktail/list_cocktail/".$limit."/".$row->bar_id); ?>">Cocktail</a>
														   <?php } else { ?>
														   <a class="btn red mini" href="<?php echo site_url("liquor/list_liquor/".$limit."/".$row->bar_id); ?>">Liquor</a>
														   	<?php } ?>	
														</td>
														
														<td class=" sorting_1" style="text-align:center;"><a class="btn red mini" href="<?php echo site_url("postcard/list_postcard/".$limit."/".$row->bar_id); ?>">View <?php echo $this->bar_model->get_bar_postcard_count($row->bar_id); ?></a>
														
														</td>
														
														
														<td class=" sorting_1" style="text-align:center;">
																	<?php
																	
		          		if($row->cap_logo!="" && file_exists(base_path().'upload/product_logo_thumb/'.@$row->cap_logo))
					{?>
						<a target="_blank" class="btn blue table_icon" href="<?php echo front_base_url()?>/upload/product_logo_thumb/<?php echo $row->cap_logo; ?>"><i class="comon_icon download_icon"></i></a>
		            	<?php } ?>
																
														
														</td>
														
														<td class=" sorting_1" style="text-align:center;">
																	<?php
		          		if($row->tshirt_logo!="" && file_exists(base_path().'upload/product_logo_thumb/'.@$row->tshirt_logo))
					{?>
						<a target="_blank" class="btn blue table_icon" href="<?php echo front_base_url()?>/upload/product_logo_thumb/<?php echo $row->tshirt_logo; ?>"><i class="comon_icon download_icon"></i></a>
		            	<?php } ?>
																
														
														</td>
														<?php } ?>
														<td class=" sorting_1" style="text-align:center;"> <?php echo date($site_setting->date_format .' h:i:s',strtotime($row->date_added)); ?>
														</td>
														 <td class="center">
															<?php if($row->owner_id==0 || $row->owner_id==""){?>
															<a onclick="changePassword('<?php echo $row->bar_id;?>','<?php echo $limit;?>','<?php echo $offset;?>')" href="javascript://" class="btn black table_icon"><i class="comon_icon change_icon"></i></a>
															<?php } ?>
														</td> 
														<td class="center">
															<?php $cls = ($row->status=='active')?'purple':'yellow';?>
															<span class="<?php echo $cls;?>"><?php echo ucfirst($row->status); ?></span>
														</td>
														<td class="center">

															<input type="checkbox" disabled="disabled" <?php echo (isset($row->agree) && $row->agree=='1')?'checked':'';?>>
														</td>
															
														<td>
														<?php 
							
																echo anchor('bar/edit_bar/'.$bar_type.'/'.$row->bar_id.'/'.$redirect_page.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset,'<i class="comon_icon edit_icon"></i>','class="table_icon btn blue" id="bar_'.$row->bar_id.'" title="Edit Admin"'); 
														?>
														
														<a class="table_icon btn red" href="javascript://" onClick="delete_rec('<?php echo $row->bar_id; ?>','<?php echo $redirect_page;?>','<?php echo $option?>','<?php echo $keyword?>','<?php echo $limit?>','<?php echo $offset; ?>')" title="Delete"><i class="comon_icon delete_icon"></i></a>
														<?php if($row->ustatus=='active'){?>	
														<?php echo  anchor('user/viewUserFrontProfile/'.$row->user_id,'<i class="comon_icon view_icon"></i>','class="table_icon btn blue" target="_blank" id="user_'.$row->user_id.'" title="View"');  ?>
													<?php } ?>	
														</td>
														<td>
															<?php 
															
															//echo $bar_type;
															//if($row->bar_type=='half_mug'){
																
																?>
																<?php
																$getowner = get_user_info($row->owner_id);
																if($row->owner_id!='' && $row->owner_id!=0 && @$getowner->status=='active')
																{ ?>
															<span class="purple"><?php echo "claimed"; ?></span>
															<?php } else { 
																 $cls = ($row->claim=='claimed')?'purple':'yellow';?>
															<span class="<?php echo $cls;?>"><?php echo ucfirst($row->claim); ?></span>
																
															<?php } ?>		
														</td>
													</tr>
								<?php $i++;} }else{ ?>
								
												
													<tr class="odd">
														<td class=" sorting_1" colspan="18" style="text-align:center!important;">No Records Found</td>
														
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
	</div>
