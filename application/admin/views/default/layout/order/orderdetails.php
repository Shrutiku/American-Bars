<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="<?php echo base_url().getThemeName();?>/js/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<link href="<?php echo base_url().getThemeName();?>/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url().getThemeName();?>/css/blog.css" rel="stylesheet" type="text/css"/>
<style type="text/css">
	.page_title h2{ font-family: 'open_sanslight'; font-size: 20px; font-weight:bold; color:#888; }
	.br_bottom { border-bottom: 1px solid #888; margin-bottom: 10px; }
	.pad10 { padding: 20px; }
	.app_text { color: #747373; font-family: 'open_sanslight'; font-size: 13px; margin: 0 0 10px; }
	.app_text span.app_title { color: #4A4A4A; display: inline-block; font-family: 'open_sanslight'; font-size: 14px; font-weight: 500; margin-right: 10px; width: 120px;}

	.mesg_left { float:left;  font-weight:bold; margin-right:5px; padding:5px; width:120px;}
	.mesg_right { float:right; width:265px;  padding:5px;}
	.row_flue { display:block; margin-bottom:5px; clear:both;}
	.row_flue p {margin:0; padding:0;}
</style>
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title">Order Details</h3>
					
					         <div class="clearfix"></div>
				</div> <div class="clearfix"></div>
				
		          <div class="row_fluid"> 
						
					<div class="portlet blue">
						<div class="portlet-title">
							<div class="caption"><i class="icon-comments"></i><span style="float: right"><a href="<?php echo site_url('order/orderlist')?>" class="btn black ">Back</a></span></div>
							</div>
							
							
						<div class="portlet-body form">
							<div class="content ">
							<div class="row">
											<div class="wid525 fl_left" style="margin-right: 10px;">
												<div class="portlet yellow box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Order Details
														</div>
														<div class="actions">
															
														</div>
													</div>
													<div class="portlet-body">
														<div class="row static-info">
															<div class="col-md-5 mesg_left name fl_left">
																 Order No : 
															</div>
															<div class="col-md-7 value">
																 <?php echo $order_number; ?>															<span style="display: none;" class="label label-info label-sm">
																</span>
															</div>
														</div><div class="clear"></div>
														<div class="row static-info ">
															<div class="col-md-5 mesg_left name fl_left">
																Order Date :
															</div>
															<div class="col-md-7 value">
																<?php echo date($site_setting->date_format,strtotime($order_date)); ?>													</div>
														</div><div class="clear"></div>
														<div class="row static-info">
															<div class="col-md-5  mesg_left name fl_left">
																 Order Status:
															</div>
															<div class="col-md-7 value">
																<span class="label label-success">
																	 <?php echo $status; ?>																		</span>
															</div>
														</div><div class="clear"></div>
														<div class="row static-info">
															<div class="col-md-5 mesg_left name fl_left">
																 Grand Total:
															</div>
															<div class="col-md-7 value">
																 <?php echo $site_setting->currency_symbol.' '.$total;?>													</div>
														</div><div class="clear"></div>
														
													</div>
												</div>
											</div>
											<div class="wid525 fl_left">
												<div class="portlet blue box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Customer Information
														</div>
														<div class="actions">
															
														</div>
													</div>
													<div class="portlet-body">
														<div class="row static-info">
															<div class="col-md-5 mesg_left name fl_left">
																 Customer Name:
															</div>
															<div class="col-md-7 value">
																 <?php echo $first_name.' '.$last_name;?>														</div>
														</div><div class="clear"></div>
														<div class="row static-info">
															<div class="col-md-5 mesg_left name fl_left">
																 Email:
															</div>
															<div class="col-md-7 value">
																<?php echo $email;?>															</div>
														</div><div class="clear"></div>
														
														<div class="row static-info">
															<div class="col-md-5 mesg_left name fl_left">
																 Phone Number:
															</div>
															<div class="col-md-7 value">
																 <?php echo $mobile_no;?>																</div>
														</div><div class="clear"></div>
													</div>
												</div>
											</div><div class="clear"></div>
										</div>	
										
										
										
										
										<div class="row">
											<div class="wid525 fl_left" style="margin-right: 10px;">
												<div class="portlet green box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Shipping Details
														</div>
														<div class="actions">
															
														</div>
													</div>
													<div class="portlet-body">
														<div class="row static-info">
															<div class="col-md-5 mesg_left name fl_left">
																 Address Line1 : 
															</div>
															<div class="col-md-7 value">
																 <?php echo $address1; ?>															<span style="display: none;" class="label label-info label-sm">
																</span>
															</div>
														</div><div class="clear"></div>
														<div class="row static-info ">
															<div class="col-md-5 mesg_left name fl_left">
																Address Line2
															</div>
															<div class="col-md-7 value">
																<?php echo $address2; ?>													</div>
														</div><div class="clear"></div>
														<div class="row static-info">
															<div class="col-md-5  mesg_left name fl_left">
																 Country :
															</div>
															<div class="col-md-7 value">
																	 <?php echo $country; ?>																		</span>
															</div>
														</div><div class="clear"></div>
														<div class="row static-info">
															<div class="col-md-5 mesg_left name fl_left">
																 State :
															</div>
															<div class="col-md-7 value">
																 <?php echo $state;?>													</div>
														</div><div class="clear"></div>
														
														<div class="row static-info">
															<div class="col-md-5 mesg_left name fl_left">
																 City :
															</div>
															<div class="col-md-7 value">
																 <?php echo $city;?>													</div>
														</div><div class="clear"></div>
														
														<div class="row static-info">
															<div class="col-md-5 mesg_left name fl_left">
																 Zipcode :
															</div>
															<div class="col-md-7 value">
																 <?php echo $zipcode;?>													</div>
														</div><div class="clear"></div>
														
													</div>
												</div>
											</div>
											<div class="wid525 fl_left">
												<div class="portlet red box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Customer Address
														</div>
														<div class="actions">
															
														</div>
													</div>
													<div class="portlet-body">
														<div class="row static-info">
															<div class="col-md-5 mesg_left name fl_left">
																 Address : 
															</div>
															<div class="col-md-7 value">
																 <?php echo $getuserinf->address; ?>															<span style="display: none;" class="label label-info label-sm">
																</span>
															</div>
														</div><div class="clear"></div>
														<div class="row static-info">
															<div class="col-md-5 mesg_left name fl_left">
																 City :
															</div>
															<div class="col-md-7 value">
																 <?php echo $getuserinf->user_city; ?>																</div>
														</div><div class="clear"></div>
														
														<div class="row static-info">
															<div class="col-md-5 mesg_left name fl_left">
																 State :
															</div>
															<div class="col-md-7 value">
																 <?php echo $getuserinf->user_state;?>																</div>
														</div><div class="clear"></div>
														
														<div class="row static-info">
															<div class="col-md-5 mesg_left name fl_left">
																 Zipcode :
															</div>
															<div class="col-md-7 value">
																 <?php echo $getuserinf->user_zip;?>																</div>
														</div><div class="clear"></div>
													</div>
												</div>
											</div><div class="clear"></div>
										</div>	
										
										
					<div class="row">
											<div class="col-md-12 col-sm-12">
												<div class="portlet purple box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Shopping Cart
														</div>
														<div class="actions">
															
														</div>
													</div>
													<div class="portlet-body">
														<div class="table-responsive">
															<?php $get_order_detatis = $this->order_model->AllOrderDet($order_id);
															
															// echo "<pre>";
															// print_r($get_order_detatis);
															// die;
															?>
															<table class="table table-hover table-bordered table-striped">
															<thead>
															<tr>
																<th>
																	 Barname
																</th>
																<th>
																	 Product
																</th>
																<th>
																	 Color
																</th>
																<th>
																	 Size
																</th>
															<th>
																	 Price
																</th>
																<th>
																	 Quantity
																</th>
																
																<th>
																	 Total
																</th>
															</tr>
															</thead>
															<tbody>
																<?php $sum = 0;
																if($get_order_detatis)
																
																{
																	foreach($get_order_detatis as $row){?>
																	<tr >
						  		<td><?php echo $row->barname?></td>
						  		<td>
																		<a target="_blank" href="<?php echo front_base_url().'shopping/details/'.$row->product_slug; ?>"><?php echo  $row->product_name; ?></a>
																</td>
																<td>
																		<?php echo  $row->colname; ?>
																</td>
																<td>
																		<?php echo  $row->sizename; ?>
																</td>
																<td>
																		 <?php echo $site_setting->currency_symbol."".$row->price ;?>
																	</td>
																	<td>
																		 <?php echo $row->quantity ;?>
																	</td>
																	
																	<td>
																		 <?php echo $site_setting->currency_symbol."".$row->total; 
																		      $sum +=  $row->total;?>
																	</td>
																</tr>
																<?php } } else { ?> 
																  No Order Found.
																<?php } ?>
																<tr>
																	<td colspan="7" style="text-align: right">  <h1><b><?php  echo $site_setting->currency_symbol."".$sum; ?></b></h1></td>
																</tr>
																			</tbody>
																			
																			</table>
																		</div>
																	</div>
																</div>
															</div>
														</div>					
										
										
										
							</div>
							
						</div>
						
					</div>
				</div>  
			</div>
		</div>
</div>