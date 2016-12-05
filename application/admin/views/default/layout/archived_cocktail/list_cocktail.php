<script type="text/javascript" language="javascript">

$(document).ready(function(){
		
		
		
	});
	
	function delete_rec(id,redirectpage,option,keyword,limit,offset)
	{
		var ans = confirm("Are you sure, you want to delete cocktail?");
		if(ans)
		{
			location.href = "<?php echo base_url(); ?>archived_cocktail/delete_archived_cocktail/"+id+"/"+redirectpage+"/"+option+"/"+keyword+"/"+limit+"/"+offset;
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
			window.location.href='<?php echo base_url();?>archived_cocktail/list_archived_cocktail/'+limit+'/<?php echo $bars_id ?>';
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
			
			window.location.href='<?php echo base_url();?>archived_cocktail/search_list_archived_cocktail/'+limit+'/<?php echo $bars_id.'/'.$option.'/'.$keyword; ?>';
		}
	
	}
	
	function gomain(x)
	{
		
		if(x == 'all')
		{
			window.location.href= '<?php echo base_url();?>archived_cocktail/list_archived_cocktail/<?php echo $bars_id ?>';
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

function donwloadCSV(){
   //alert($('#fd').val());
        $('#downloadCSV #opt').val($('#option').val());
        $('#downloadCSV #key').val($('#keyword').val());
        $('#downloadCSV #typ').val($('#b_type').val());
        $('#downloadCSV').submit();
    }
</script>
<?php $att=array('id'=>'downloadCSV','name'=>'downloadCSV','class'=>'no-margin');
                                        echo form_open('cocktail/download',$att) ?>
                                        <input type="hidden" value="" id="opt" name="opt" />
                                        <input type="hidden" value="" id="key" name="key" />
                                        <input type="hidden" value="" id="typ" name="typ" />
                                    </form>
                                    
                                    <input type="hidden" name="b_type" id="b_type" value="<?php echo @$bars_id; ?>" />
<div class="page_content">

			<div class="container_fluid">
		
				<div class="row_fluid"> 
					<h3 class="page_title">Archived Cocktail Directory</h3>
					
				</div>
					<?php 
   if($er!='')
		   {
		  $tags = explode('*',  base64_decode($er));
		  
		 // print_r(array_filter($tags));
		 
		 // die;
		 if(isset($tags[1])){
		   	 $error =  "<p>Total Uploaded = ".(base64_decode($er1)-count(array_filter($tags)))." Records</p><p>Total Failed = ".count(array_filter($tags))." Records</p><p>Failed row  :<b> ".substr(str_replace('*', ', ', base64_decode($er)),0,-2)." </b></p>" ;
		   }
		 else {
			 $error =  "<p>Total Uploaded = ".(base64_decode($er1)-1)." Records</p><p>Total Failed = 0 Records</p><p>Failed row  :<b> ".substr(str_replace('*', ', ', base64_decode($er)),0,-2)." </b></p>" ;
		 }
		   }
		   else if($msg != "") {
			   if($msg == "Successfully"){ $error = "Import Data Successfully";}
		   }
		if($msg != ""){
	     if($msg == "insert"){ $error = ADD_NEW_RECORD;}
            if($msg == "update"){ $error = UPDATE_RECORD;}
            if($msg == "delete"){ $error = DELETE_RECORD;}
			 if($msg == "Success"){ $error = ADD_NEW_RECORD;}
			if($msg == "active") {  $error = ACTIVE_RECORD;}
			if($msg == "inactive"){ $error = INACTIVE_RECORD;}
			if($msg == "rights"){ $error = ASSIGN_RIGHTS;}
			
    ?>
        <div class="success_msg"><?php echo '<p>'.$error.'</p>';?></div>
    <?php } ?>
				<div class="row_fluid"> 
					<div class="portlet blue">
						<div class="portlet-title">
							<div class="caption fl_left">Archived Cocktail  Directory</div>
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
					echo form_open('archived_cocktail/search_list_archived_cocktail/'.$limit,$attributes);?>
					<div class="fl_left">
					<div class="sdrop fl_left wid140">
					<!-- <span class="sspan fl_left ">&nbsp;&nbsp;&nbsp;Search By</span>&nbsp; -->
                            <select name="option" id="option" onchange="gomain(this.value)"  class="m_wrap fl_left mar0" style="padding:6px;">
                            
								<option value="">--Please Select--</option>
                                <option value="cocktail_name" <?php if($option=='cocktail_name'){?> selected="selected"<?php }?>>Cocktail Name</option>
                                <option value="base_spirit" <?php if($option=='base_spirit'){?> selected="selected"<?php }?>>Base Spirit</option>  
                                                          
                            </select>
					</div>
					<input type="hidden" name="bars_id" id="bars_id" value="<?php echo $bars_id; ?>" />
							<input type="text" name="keyword" id="keyword" value="<?php echo $keyword_data;?>"  class="search_key mar0" placeholder="Enter keyword" /> 
							</div>               
                            <input type="submit" name="submit" id="submit" value="Search" class="btn blue  fl_left mar10" /> 
                            <input type="button" name="refresh" id="refresh" value="Refresh" class="btn blue  fl_left mar10" onclick="document.location.href = '<?php echo site_url("archived_cocktail/list_archived_cocktail/20/".$bars_id); ?>'" /> 
								</form>
								</div>
					<div class="fl_right">	
					<a href="javascript:void(0)" onclick="setaction('chk[]','active', 'Are you sure, you want to activate selected record(s)?', 'frm_listlogin');" class="btn purple fl_left mar_r_5" >Active</a>
					<a href="javascript:void(0)" onclick="setaction('chk[]','inactive', 'Are you sure, you want to inactivate selected record(s)?', 'frm_listlogin');" class="btn yellow  fl_left mar_r_5" >Inactive</a>
					<a href="javascript:void(0)" onclick="setaction('chk[]','delete', 'Are you sure, you want to delete selected record(s)?', 'frm_listlogin');" class="btn black  fl_left" >Delete</a>
					<div class="clear"></div>
					</div>
									<div class="clear"></div>
								<form name="frm_listlogin" id="frm_listlogin" action="<?php echo base_url();?>archived_cocktail/action_archived_cocktail" method="post">
									<input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
									<input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
									<input type="hidden" name="serach_keyword" id="serach_keyword" value="<?php echo $keyword_data; ?>" />
									<input type="hidden" name="serach_option" id="serach_option" value="<?php echo $option; ?>" />
									
									<input type="hidden" name="bars_id" id="bars_id" value="<?php echo $bars_id; ?>" />
								   <input type="hidden" name="action" id="action" />
								   <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
								<div class="scroll-pane horizontal-only" >	<table class="table border" >
												<thead>
												<tr>
												<th class="sorting_disabled" style="width: 0.1%;">
												<input type="checkbox" id="titleCheck" name="titleCheck"  onclick="setchecked('chk[]')" />
												</th>
												<th class="sorting_disabled" style="width: 6%;">Cocktail Name</th>
												<th class="sorting_disabled" style="width: 6%;">Bar Name</th>
												<th class="sorting" style="width: 5%;">Images</th>
												<!-- <th class="sorting" style="width: 5%;">Ingredients</th> -->
												<!-- <th class="sorting" style="width: 5%;">How to make it</th> -->
												
												<th class="sorting" style="width: 5%;">Base Spirit</th>
												<th class="sorting" style="width: 5%;">Type</th>
												<th class="sorting" style="width: 5%;">Served</th>
												<!-- <th class="sorting" style="width: 5%;">Preparation</th> -->												<th class="sorting" style="width: 5%;">Strength</th>
												<th class="sorting" style="width: 5%;">Difficulty</th>
												<!-- <th class="sorting" style="width: 5%;">Flavor Profile</th> -->
												<!-- <th class="sorting" style="width: 5%;">Rating</th> -->
												
												<th class="sorting" style="width: 5%;">Status</th>
												<th class="sorting" style="width: 5%;">Comments</th>
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
									<td  style="width: 30px;"><input type="checkbox" name="chk[]" value="<?php echo $row->cocktail_id ?>" class="chk"  /></td>
														<td class="sorting_1"><?php echo $row->cocktail_name; ?></td>
														<td class="sorting_1"><?php echo $row->bar_title; ?></td>
														
														<td><?php if($row->cocktail_image!='' && file_exists(base_path().'upload/cocktail_thumb/'.$row->cocktail_image)){?>
												<img src="<?php echo front_base_url().'upload/cocktail_thumb/'.$row->cocktail_image ?>"  width="50"  height="50"/>
											<?php } else { ?>
												<img src="<?php echo front_base_url().'upload/no_img.png'; ?>"  width="50"  height="50"/>
												<?php }?>
											</td>
														<!-- <td><?php echo $row->ingredients; ?></td> -->
														<!-- <td><?php echo $row->how_to_make_it; ?></td> -->
														
														<td><?php echo $row->base_spirit; ?></td>
														<td><?php echo $row->type; ?></td>
														<td><?php echo $row->served; ?></td>
														<!-- <td><?php echo $row->preparation; ?></td> -->
														<td><?php echo $row->strength; ?></td>
														<td><?php echo $row->difficulty; ?></td>
														<!-- <td><?php echo $row->flavor_profile; ?></td> -->
												
														<!-- <td><?php echo get_cocktail_rating($row->cocktail_id); ?></td> -->
														<td class="center">
															<?php $cls = ($row->status=='active')?'purple':'yellow';?>
															<span class="<?php echo $cls;?>"><?php echo ucfirst($row->status); ?></span>
														</td>
														<td class="center">
															<!-- <a class="table_icon btn blue" href="<?php echo site_url("cocktail/view_cocktail_comment/".$row->cocktail_id); ?>" title="View"><i class="comon_icon view_icon"></i></a> -->
															(<?php echo totalcocktailcomment($row->cocktail_id);?>)
														</td>
														<td style="text-align: center;">
														<?php 
							//FUTURE 
							// 	echo anchor('cocktail/edit_cocktail/'.$row->cocktail_id.'/'.$redirect_page.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset,'<i class="comon_icon edit_icon"></i>','class="table_icon btn blue" id="cocktail_'.$row->cocktail_id.'" title="Edit cocktail"'); 
						?>
														<!--Futture enhancement															
															<a class="btn green table_icon" href="javascript:;"><i class="comon_icon view_icon"></i></a>-->
														<a class="table_icon btn red" href="javascript://" onClick="delete_rec('<?php echo $row->cocktail_id; ?>','<?php echo $redirect_page;?>','<?php echo $option?>','<?php echo $keyword?>','<?php echo $bars_id ?>','<?php echo $limit?>','<?php echo $offset; ?>')" title="Delete"><i class="comon_icon delete_icon"></i></a>
														</td>
													</tr>
								<?php $i++;} }else{ ?>
								
												
													<tr class="odd">
														<td class="sorting_1" colspan="17" style="text-align:center!important;">No Records Found</td>
														
													</tr>
								<?php } ?>
								
											
								<?php if(strlen($page_link)>0){ ?>
								<tr class="odd">
										<td class="sorting_1" colspan="15" style="text-align:center!important;"><div class="fg-toolbar tableFooter">
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