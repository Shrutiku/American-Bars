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
		<!-- styles needed by jScrollPane - include in your own sites -->

            <link href="<?php echo $theam_url; ?>/assets/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
		
<script src="<?php echo $theam_url; ?>/assets/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript" ></script>

<script src="<?php echo $theam_url; ?>/assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript" ></script>
<script type="text/javascript" language="javascript">

$(document).ready(function(){});
	
	function delete_rec(id,redirectpage,option,keyword,limit,offset,state)
	{
            var ans = confirm("Are you sure, you want to delete user?");
            if(ans) {
                location.href = "<?php echo base_url(); ?>bar_user/delete_bar_user/"+id+"/"+redirectpage+"/"+option+"/"+keyword+"/"+limit+"/"+offset+"/"+state;
            } else {
                return false;
            }
	}
	
	function getlimit(limit)
	{
		
            if(limit ==='0') {
                return false;
            }
            else {
                window.location.href='<?php echo base_url();?>bar_user/list_bar_user/<?php echo $state; ?>/'+limit+'/';
            }
	
	}	
	
	function getsearchlimit(limit)
	{
            if(limit ==='0') {
                return false;
            }
            else {
                window.location.href='<?php echo base_url();?>bar_user/search_list_bar_user/<?php echo $state; ?>/'+limit+'/<?php echo $option.'/'.$keyword; ?>';
            }
	
	}
	
	function gomain(x)
	{
            if(x === 'all') {
                window.location.href= '<?php echo base_url();?>bar_user/list_bar_user/';
            }	
	}
	
	
function setchecked(elemName){
    elem = document.getElementsByName(elemName);
    if(document.getElementById("titleCheck").checked === true) {
        for(i=0; i<elem.length; i++){
            elem[i].checked=1;
        }
    } else {
        for(i=0; i<elem.length; i++){
            elem[i].checked=0;
        }
    }
}

function setaction(elename, actionval, actionmsg, formname) {
    vchkcnt=0;
    elem = document.getElementsByName(elename);

    for(i=0; i<elem.length; i++){
        if(elem[i].checked) vchkcnt++;	
    }
    if(vchkcnt === 0) {
        alert('Please select a record');
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
        $('#downloadCSV').submit();
}

function changePassword(id,limit,offset)
{
	
    var $modal = $('#ajax-modal');
    $('body').modalmanager('loading');
    //alert(this.href);
    var url='<?php echo base_url(); ?>user/setNewPassword/'+id+'/';
    // return false;
    setTimeout(function(){
        $modal.load(url, '', function(){
            $modal.modal().on("hidden", function() {
                $modal.empty();
            })
            .one('shown.bs.modal', function(){
                $('#submitSet').click(function() {
                    $('#noteerror').fadeOut();		
                        $.ajax({
                            type: 'POST',
                            dataType:'Json',
                            url: url,
                            data: $('#setPstat').serialize(),
                            beforeSend: function() {
                                            blockUI('#setPstat');
                                        },
                            success: function(data) {
                                if(data.error.length>0){
                                    $('#errorDiv').html(function(){
                                            $(this).html(data.error);
                                            $(this).fadeIn();
                                    });
                                    //$.growlUI(data.msg); 
                                    //$modal.modal('toggle');
                                    //getData(limit,offset);
                                }else {
                                    window.reload();
                                }
                               // $.growlUI(data.msg); 
                            },
                            complete : function() {
                                unblockUI('#setPstat');
                            }
                        });		
                });   		
            }).modal();;
        });
    }, 1000);
    
    return false;	
}
</script>

<div id="ajax-modal" class="modal fade" tabindex="-1" data-width="400" style="display: none;"></div>	

<?php $att=array('id'=>'downloadCSV','name'=>'downloadCSV','class'=>'no-margin');
    echo form_open('user/bar_user_download/'.$state,$att) ?>
<input type="hidden" value="" id="opt" name="opt" />
<input type="hidden" value="" id="key" name="key" />
<input type="hidden" value="euser" id="typ" name="typ" />
    </form>
<div class="page_content">
    <div class="container_fluid">
        <div class="row_fluid"> 
            <h3 class="page_title">List Bar Owner</h3>
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
                    <div class="caption fl_left">List Bar Owner</div>
                            <div class="fl_right">
                                <span class="sspan fl_left ">Show</span>
                                    <?php 
                                        if($search_type=='normal') { ?>
                                            <select name="limit" id="limit" onchange="getlimit(this.value)" style="width:80px; margin-top:5px;"></select> <?php 
                                        } if($search_type=='search') { ?>
                                            <select name="limit" id="limit" onchange="getsearchlimit(this.value)" style="width:80px; margin-top:5px;"> <?php 
                                        } ?>
                                                <option value="0">Per Page</option>
                                                <option value="5" <?php if($limit==5){?> selected="selected"<?php }?>>5</option>
                                                <option value="10" <?php if($limit==10){?> selected="selected"<?php }?>>10</option>
                                                <option value="15" <?php if($limit==15){?> selected="selected"<?php }?>>15</option>
                                                <option value="25" <?php if($limit==25){?> selected="selected"<?php }?>>25</option>
                                                <option value="50" <?php if($limit==50){?> selected="selected"<?php }?>>50</option>
                                                <option value="75" <?php if($limit==75){?> selected="selected"<?php }?>>75</option>
                                                <option value="100" <?php if($limit==100){?> selected="selected"<?php }?>>100</option>     
                                            </select>
                                    <div class="clear"></div>
                            </div>
                            <div class="portlet-body form">
                                <?php 
                                if($keyword !== '1V1') {
                                    $keyword_data = str_replace('-',' ',$keyword);
                                } else {
                                    $keyword_data ='';
                                }
                                ?>
                                <div class="fl_left">
                                    <?php			 
					$attributes = array('name'=>'frm_search','id'=>'frm_search');
					echo form_open('bar_user/search_list_bar_user/'.$state."/".$limit,$attributes);?>
					<div class="fl_left">
                                            <div class="sdrop fl_left wid228">
                                                <span class="sspan fl_left ">&nbsp;&nbsp;&nbsp;Search By</span>&nbsp;
                                                    <select name="option" id="option" onchange="gomain(this.value)"  class="m_wrap fl_left mar0" style="padding:6px;">
                                                        <option value="">--Please Select--</option>
                                                        <option value="full_name" <?php if($option=='full_name'){?> selected="selected"<?php }?>>First / Last Name</option>  
                                                        <option value="email" <?php if($option=='email'){?> selected="selected"<?php }?>>E-mail</option>                   
                                                    </select>
                                            </div>
                                            <input type="text" name="keyword" id="keyword" value="<?php echo $keyword_data;?>"  class="search_key mar0" placeholder="Enter keyword" /> 
                                        </div>               
                                    <input type="submit" name="submit" id="submit" value="Search" class="btn blue  fl_left mar10" /> 
                                    <input type="button" name="refresh" id="submit" value="Refresh" class="btn blue  fl_left mar10" onclick="document.location.href ='<?php echo site_url("bar_user/list_bar_user/active"); ?>'" />
				</form>
                                </div>
				<div class="fl_right"><a href="javascript:void(0)" onclick="setaction('chk[]','active', 'Are you sure, you want to activate selected record(s)?', 'frm_listlogin');" class="btn purple fl_left mar_r_5" >Active</a>
                                    <a href="javascript:void(0)" onclick="setaction('chk[]','inactive', 'Are you sure, you want to inactivate selected record(s)?', 'frm_listlogin');" class="btn yellow  fl_left mar_r_5" >Inactive</a>
                                    <a href="javascript:void(0)" onclick="setaction('chk[]','delete', 'Are you sure, you want to delete selected record(s)?', 'frm_listlogin');" class="btn black mar_r_5 fl_left" >Delete</a>
                                    <?php if($this->session->userdata('admin_type')==1){?>
                                        <a href="javascript:void(0)" onclick="donwloadCSV();" class="btn black mar_r_5  fl_left" >Download</a>
                                    <?php } ?>	
                                    <div class="clear"></div>					
                                        <div class="clear"></div>
                                </div>
                                <div class="clear"></div>
                                <form name="frm_listlogin" id="frm_listlogin" action="<?php echo base_url();?>bar_user/action_user" method="post">
                                    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
                                    <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
                                    <input type="hidden" name="serach_keyword" id="serach_keyword" value="<?php echo $keyword_data; ?>" />
                                    <input type="hidden" name="serach_option" id="serach_option" value="<?php echo $option; ?>" />
                                    <input type="hidden" name="state" id="state" value="<?php echo $state; ?>" />
                                    <input type="hidden" name="action" id="action" />
                                    <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
                                    <div class="scroll-pane horizontal-only" >
                                    <table class="table border" >
                                        <thead>
                                            <tr>
                                                <th class="sorting_disabled" style="width: 0.1%;">
                                                    <input type="checkbox" id="titleCheck" name="titleCheck"  onclick="setchecked('chk[]')" />
                                                </th>					
                                                <th class="sorting_disabled" style="width: 6%;">First Name</th>
                                                <th class="sorting_disabled" style="width: 6%;">Last Name</th>
                                                <th class="sorting_disabled" style="width: 6%;">Bar Name</th>
                                                <th class="sorting_disabled" style="width: 6%;">Address</th>
                                                <th class="sorting_disabled" style="width: 6%;">City</th>
                                                <th class="sorting_disabled" style="width: 6%;">State</th>
                                                <th class="sorting_disabled" style="width: 6%;">Zipcode</th>
                                                <th class="sorting" style="width: 5%;">Bar Type</th>
                                                <th class="sorting" style="width: 5%;">Date Time</th>
                                                <th class="sorting" style="width: 5%;">Last Login Date</th>
                                                <th class="sorting" style="width: 5%;">Change Password</th>
                                                <th class="sorting" style="width: 5%;">Status</th>
                                                <th class="sorting" style="width: 3%;">Action</th>
                                                <th class="sorting" style="width: 5%;">View Bar</th>
                                            </tr>
                                        </thead>
                                        <tbody role="alert" aria-live="polite" aria-relevant="all">	
                                            <?php
                                                if($result) {
                                                    $i=1;
                                                    foreach($result as $row) {
                                                        $cls=($i%2==0)?'even':'odd';
                                                        //print_r($row); ?>
                                                        <tr class="<?php echo $cls ?>">
                                                            <td  style="width: 30px;"><input type="checkbox" name="chk[]" value="<?php echo $row->user_id ?>" class="chk"  /></td>
                                                            <td class=" sorting_1"><?php echo $row->first_name; ?></td>
                                                            <td class=" sorting_1"><?php echo $row->last_name; ?></td>
                                                            <td class=" sorting_1 break-column"><a target="_blank" href="<?php echo front_base_url().'bar/details/'.$row->bar_slug;?>"><?php echo ucwords($row->bar_title); ?></a></td>
                                                            <td><?php echo $row->address; ?></td>
                                                            <td><?php echo $row->city; ?></td>
                                                            <td><?php echo $row->state; ?></td>
                                                            <td><?php echo $row->zipcode; ?></td>
                                                            <td><?php if($row->bar_type=='half_mug'){ echo "Half Mug"; } else  { echo "Full Mug" ;} ?></td>
                                                            <td><?php echo date($site_setting->date_format .' h:i:s',strtotime($row->date_added)); ?></td>
                                                            <td>
                                                                <?php $new = getlastlogindate($row->user_id);?>
                                                                <?php echo $new!='' ? date($site_setting->date_format ." h:i:s",strtotime($new)):'';?>
                                                            </td>
                                                            <td class="center">
                                                                <?php //if($row->owner_id==0 || $row->owner_id==""){?>
                                                                <a onclick="changePassword('<?php echo $row->user_id;?>','<?php echo $limit;?>','<?php echo $offset;?>')" href="javascript://" class="btn black table_icon"><i class="comon_icon change_icon"></i></a>
                                                                <?php //} ?>
                                                            </td>
                                                            <td class="center">
                                                                <?php $cls = ($row->status=='active')?'purple':'yellow';?>
                                                                <span class="<?php echo $cls;?>"><?php echo ucfirst($row->status); ?></span>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <?php 
                                                            //FUTURE 
                                                            // 	echo anchor('bar_user/edit_bar_user/'.$row->user_id.'/'.$redirect_page.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset,'<i class="comon_icon edit_icon"></i>','class="table_icon btn blue" id="user_'.$row->user_id.'" title="Edit user"'); 
                                                                ?>
                                                                <!--Futture enhancement															
                                                                        <a class="btn green table_icon" href="javascript:;"><i class="comon_icon view_icon"></i></a>-->
                                                                <?php echo  anchor('bar_user/edit_bar_user/'.$state."/".$row->user_id.'/'.$redirect_page.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset,'<i class="comon_icon edit_icon"></i>','class="table_icon btn blue" id="user_'.$row->user_id.'" title="Edit user"');  ?>
                                                                <a class="table_icon btn red" href="javascript://" onClick="delete_rec('<?php echo $row->user_id; ?>','<?php echo $redirect_page;?>','<?php echo $option?>','<?php echo $keyword?>','<?php echo $limit?>','<?php echo $offset; ?>','<?php echo $state; ?>')" title="Delete"><i class="comon_icon delete_icon"></i></a>
                                                                <?php if($row->status=='active'){?>	
                                                                <?php echo  anchor('user/viewUserFrontProfile/'.$row->user_id,'<i class="comon_icon view_icon"></i>','class="table_icon btn blue" target="_blank" id="user_'.$row->user_id.'" title="View"');  ?>
                                                                <?php } ?>	
                                                                </td>
                                                                <td class=" sorting_1" style="text-align:center;"><a class="table_icon btn red" href="<?php echo site_url("bar/edit_bar/".$row->bar_type."/".$row->bar_id.'/list_bar/1V1/1V1/20/0/'.$state.''); ?>"><i class="comon_icon view_icon"></i></a></td>
							</tr>
                                                    <?php $i++;} } else{ ?>			
                                                        <tr class="odd">
                                                            <td class=" sorting_1" colspan="14" style="text-align:center!important;">No Records Found</td>
                                                        </tr>
                                                    <?php } ?>				
                                                        <?php if(strlen($page_link)>0){ ?>
                                                            <tr class="odd">
                                                                <td class=" sorting_1" colspan="15" style="text-align:center!important;"><div class="fg-toolbar tableFooter">
                                                                    <div class="dataTables_paginate paging_full_numbers" style="float:right"> <ul class="pagination_new"><?php echo $page_link; ?></ul></div>
                                                                </div>
                                                                </td>				
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