<script type="text/javascript">
	function statusChange(order_id,order_status){
		$.ajax({
			url : '<?php echo site_url('order/statusChange');?>/'+order_id+'/'+order_status+'/',
			beforeSend : function() {
				blockUI('.portlet-body');
			},
			success : function(data) {
				if(data=='done'){
					$.growlUI('<?php echo UPDATE_MAKE; ?>'); 
					// if(order_status=="Canceled")
				// {
					// $("#remove_"+order_id).hide();
					// $("#add_"+order_id).html("Canceled");
				// }
					
				}
			},
			complete : function() {
				unblockUI('.portlet-body');
				
			}
		});
		}
		function displayCal(x){
		if(x=='date')
		{
			$("#ui_date_picker").show();
			$("#keyword").hide();
		}
		else{
			$("#ui_date_picker").hide();
			$("#keyword").show();	
		}
	}
</script>
<?php $keyword_data=($keyword != '1V1')?str_replace('-',' ',$keyword):'';?>

<?php			 
					$attributes = array('name'=>'frm_order','id'=>'frm_order','data-target'=>'#content');
					echo form_open('order/actionOrder',$attributes);?>
			
				<input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
				<input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
            	<input type="hidden" name="serach_keyword" id="serach_keyword" value="<?php echo $keyword_data; ?>" />
				<input type="hidden" name="serach_option" id="serach_option" value="<?php echo $option; ?>" />
				
            	   <input type="hidden" name="action" id="action" />
				   <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
					<table class="table table-bordered table-striped table-condensed flip-content" id="s2">
					<thead class="flip-content">
					<tr>
					<th width="10" align="center"><input type="checkbox" data-set=".table .checkboxes" class="group-checkable"></th>
					<th >Order No.</th>
					<th >Username</th>
					<th >Email</th>
					<th >Order Date</th>
					<th>Total</th>
					<th>Status</th>
					<th >Action</th>
					</tr>
					</thead>
					<tbody>

					<?php
				if($result!=''){
					//print_r($result);die;
				foreach($result as $row) {
					?>
					<tr>
					<td> <input type="checkbox"  class="checkboxes" name="chk[]" id="titleCheck<?php echo  $row->order_id;?>" value="<?php echo $row->order_id;?>"></td>
					<td><?php echo $row->order_number; ?></td>
					<td><?php echo ucfirst($row->first_name); ?></td>
					<td><a href="mailto:<?php echo $row->email; ?>"><?php echo $row->email; ?></td>
					<td><?php echo date("m-d-Y", strtotime($row->order_date)); ?></td>
					<td>$<?php echo $row->total; ?></td>
					<td id="remove_<?php echo $row->order_id; ?>">
						<?php if($row->status!='Canceled'){ ?>
						<select name="status" style="height: 26px;" class="small span6 no-margin" onchange="statusChange(<?php echo $row->order_id;?>,this.value);">
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
					
					<div id="add_<?php echo $row->order_id; ?>"></div>
					<td class="numeric">
						<p>
						<a class="btn blue icn-only mini" href="<?php echo site_url('order/orderDetails/'.$row->order_id.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset); ?>" st><i class="icon-search"></i></a>
						<a href="javascript:void(0);" onClick="delete_rec('<?php echo $row->order_id; ?>','<?php echo $redirect_page;?>','<?php echo $option?>','<?php echo $keyword?>','<?php echo $limit?>','<?php echo $offset; ?>')" title="Delete" class="btn red icn-only mini"><i class="icon-remove icon-white"></i></a>
						</p>
					</td>

					</tr>
					<?php }} else{ ?>
					<tr>
					<td align="center" colspan="8" style="color: red;">No Records Found. </td>
					</tr>
					<?php }
					?>
					</tbody>
					</table>
				</form>
								<div class="row-fluid">
									<?php echo $page_link ?>
							
						</div>

<script>

	$(document).ready(function() {
		<?php if($msg!=''){
            if($msg == "update"){ $m = UPDATE_MAKE;}
            if($msg == "delete"){ $m = DELETE_MAKE;}
    ?> 
    
       $.growlUI('<?php echo $m; ?>'); 
     
   <?php } ?>
   
   
    
});
</script>