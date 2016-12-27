<script src="<?php echo base_url().getThemeName(); ?>/js/jquery.min.js"></script>
<link href="<?php echo base_url().getThemeName(); ?>/assets/css/style1.css" rel="stylesheet" type="text/css"/>
<script>
$(document).ready(function() {
	document.body.style.background="white";
});
 	function PrintElem()
    {	
    	$(".ff").hide();
	   	window.print(); 	  
	   	$(".ff").show();
   }
   
   function back_invoice()
    {	
    	
	   	window.location.href="<?php echo base_url().'adborder/list_order';?>";   
	   
   }
   
    function send_email(id)
	{
		$.ajax({
			url : "<?php echo site_url('invoice/send_email_to_customer') ?>",
			cache: false,
			type: 'POST',
			//dataType: 'json',
			data:{ id:id },
			/*beforeSend : function(){
				blockUI('.portlet-body');
			},*/
			success : function(data){				
				if(data=='done'){						
					window.location.href='<?php echo base_url().'invoice/list_invoice/20/0/sent';?>';
				}
			},
			/*complete : function(){
				unblockUI('.portlet-body');
			}*/
		});
	}

</script>

<table class="t1">
  <tr>
  	<td width="50%">
  		<h1 class="h1">Order Details</h1>
  		<table>
  			<tr>
  				<td class="pad3">Order No :</td>
  				<td class="pad3"> <?php echo $order_number; ?>	</td>
  			</tr>
  			<tr>
  				<td class="pad3">Order Date :</td>
  				<td class="pad3"><?php echo date($site_setting->date_format,strtotime($order_date)); ?></td>
  			</tr>
  			<tr>
  				<td class="pad3">Status :</td>
  				<td class="pad3"> <?php echo $status; ?></td>
  			</tr>
  			<tr>
  				<td class="pad3">Grand Total :</td>
  				<td class="pad3"><?php echo $site_setting->currency_symbol.' '.$total; ?></td>
  			</tr>
  		</table>
  	</td>
  	<td>
  		<h1 class="h1">Customer Information</h1>
  		<table style="">
  			<tr>
  				<td class="pad3"> Customer Name :</td>
  				<td class="pad3"><?php echo $first_name.' '.$last_name;?></td>
  			</tr>
  			<tr>
  				<td class="pad3">Email :</td>
  				<td class="pad3"><?php echo $email;?>			</td>
  			</tr>
  			<tr>
  				<td class="pad3">Phone Number :</td>
  				<td class="pad3"><?php echo $mobile_no;?>			</td>
  			</tr>
  			<tr>
  				<td class="pad3">&nbsp;</td>
  				<td class="pad3">&nbsp;</td>
  			</tr>
  		</table>
  	</td>
  </tr>
  <tr>
  	<td>
  		<h1 class="h1">Shipping Details</h1>
  		<table style="">
  			<tr>
  				<td class="pad3">Address :</td>
  				<td class="pad3"><?php echo $address1.', '.$address2.' , '.$city.' , '.$state.' , '.$zipcode.' , '.$country; ?>			</td>
  			</tr>
  			
  		</table>
  	</td>
  	<td>
  		<h1 class="h1">Customer Address</h1>
  		<table>
  			<tr>
  				<td class="pad3">Address :</td>
  				<td class="pad3"><?php echo $getuserinf->address.', '.$getuserinf->user_city.' , '.$getuserinf->user_state.' , '.$getuserinf->user_zip; ?>			</td>
  			</tr>
  		</table>
  	</td>
  </tr>
  

  <tr>
  	<td colspan="2">
  		<h1 class="h1">Shopping Cart</h1>
  		<table  cellpadding="4" cellspacing="4" width="100%" style="border-collapse: collapse; border: 1px solid #000; text-align: left;margin-top: 20px;" >
  			<thead>
  				<th class="fnt-siz" style="background-color: #4c4129;  border-bottom: solid 1px #816f46;   font-weight: bold;  padding: 5px 10px; color: #fff;">Image</th>
  				<th class="fnt-siz"  style="background-color: #4c4129; border-bottom: solid 1px #816f46;   font-weight: bold;  padding: 5px 10px; color: #fff;">Product</th>
  				<th class="fnt-siz" style="background-color: #4c4129; border-bottom: solid 1px #816f46;   font-weight: bold;  padding: 5px 10px; color: #fff;">Color</th>
  				<th class="fnt-siz" style="background-color: #4c4129; border-bottom: solid 1px #816f46;   font-weight: bold;  padding: 5px 10px; color: #fff;">Size</th>
  				<th class="fnt-siz" style="background-color: #4c4129; border-bottom: solid 1px #816f46;   font-weight: bold;  padding: 5px 10px; color: #fff;">Price</th>
  				<th class="fnt-siz" style="background-color: #4c4129; border-bottom: solid 1px #816f46;   font-weight: bold;  padding: 5px 10px; color: #fff;">Quantity</th>
  				<th class="fnt-siz" style="background-color: #4c4129; border-bottom: solid 1px #816f46;   font-weight: bold;  padding: 5px 10px; color: #fff;">Total</th>
  			</thead>
  			<tbody>
  				<?php $get_order_detatis = $this->adborder_model->AllOrderDet($order_id);
															
															// echo "<pre>";
															// print_r($get_order_detatis);
															// die;
															?>
  				<?php $sum = 0;
																if($get_order_detatis)
																
																{
																	foreach($get_order_detatis as $row){?>
  				<tr style="border-bottom: double 4px #816f46;">
  					<td class="fnt-siz"  style="padding: 10px 5px;"><?php $getimage = getsingleimage($row->store_id);?>
     									<?php 
									if($getimage!="" && is_file(base_path().'upload/product_thumb_80/'.$getimage)){ ?>
										<img src="<?php echo front_base_url().'upload/product_thumb_80/'.$getimage; ?>"  />
									<?php
									}
									else{?>
									<img class="img-responsive" src="<?php echo base_url().getThemeName().'images/video1.png'; ?>" />
							<?php } ?></td>
  					<td class="fnt-siz" >
																		<?php echo  $row->product_name; ?>
																</td>
																<td class="fnt-siz" >
																		<?php echo  $row->colname; ?>
																</td>
																<td class="fnt-siz" >
																		<?php echo  $row->sizename; ?>
																</td>
																<td class="fnt-siz" >
																		 <?php echo $site_setting->currency_symbol."".$row->price ;?>
																	</td>
																	<td class="fnt-siz" >
																		 <?php echo $row->quantity ;?>
																	</td>
																	
																	<td class="fnt-siz" >
																		 <?php echo $site_setting->currency_symbol."".$row->total; 
																		      $sum +=  $row->total;?>
																	</td>
  				</tr>
  				<?php } }?>
  				<tr style="background-color: #816f46; color: #fff;">
  					<td colspan="7" align="right" style="padding: 10px 5px;">
  						Total: <?php  echo $site_setting->currency_symbol."".$sum; ?>
  					</td>
  				</tr>
  				
  			</tbody>
  		</table>
  	</td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr>
  	<td colspan="2" align="center" style="font-size: 25px;  font-weight: bold; letter-spacing: 0.8px; padding: 15px 0;">Thank You For Your Business!</td>
  </tr>
   <tr><td>&nbsp;</td></tr>
  
</table>

<table>
	<tr>
  	<td>
  		<a class="ff" href="javascript://" onclick="back_invoice();" style="background-color: #f19d12; padding: 5px 15px; text-shadow: .5px 0px .5px #333232; color: #fff; font-size: 21px;  font-weight: normal; letter-spacing: 0.8px; text-decoration: none;">Back</a>
  		<a class="ff" href="javascript://" onclick="PrintElem();" style="background-color: #f19d12; padding: 5px 15px; text-shadow: .5px 0px .5px #333232; color: #fff; font-size: 21px;  font-weight: normal; letter-spacing: 0.8px; text-decoration: none;">Print</a>
  	</td>
  </tr>
  
</table>




