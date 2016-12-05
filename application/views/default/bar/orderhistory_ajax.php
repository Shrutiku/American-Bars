
     			<?php			 
					$attributes = array('name'=>'actionevent','id'=>'actionevent','data-target'=>'.content');
					echo form_open('bar/actionevent',$attributes);?> 
					<input type="hidden" name="action" id="action" />
					    					<div class="table-responsive">
     						<div id="responsecomment">
     							<div class="pagination" id="at_ajax">
	     				<?php echo $page_link;?>
     				</div><div class="clearfix"></div>
							<table class="table">
								<thead>
									<th>Order ID</th>
									<!-- <th>First Name</th>
									<th>Last Name</th> -->
									<th>Amount</th>
									<th>Date</th>
									<th>Status</th>
									<th>Action</th>
								</thead>
								<tbody>
								<?php
								
								if($result)
								{
									$i=1;
									foreach($result as $event){								
								
								if ($i % 2 == 0)
										  {
										    $dark =  "dark";
										  }
										  else
										  {
										    $dark =  "light";
										  }?>	
									<tr class="<?php echo $dark; ?>" id='remove_event_<?php echo $event->order_id; ?>'>
										<td><?php echo $event->order_number ;?></td>
										<!-- <td><?php echo $event->first_name;?></td>
										<td><?php echo $event->last_name;?></td> -->
										<td><?php echo $site_setting->currency_symbol." ".$event->total;?></td>
										<td><?php echo date($site_setting->date_format,strtotime($event->order_date ));?></td>
										<td><?php echo ucfirst($event->status);?></td>
										<td>
											<a onclick="view('<?php echo $event->order_id; ?>')"><i class="strip expand"></i></a>
										</td>
										
										
									</tr>
									
								
									
									<tr id="view_det_<?php echo $event->order_id; ?>" class='close_all' style='display: none;'>
										<td colspan="8">
											<div class="text-right">
												<a onclick="view_close();"><span class="glyphicon glyphicon-remove mar_r5"></span></a>
											</div>
											<div>
													<div class="review_mainblock mar_r30 padt10">
													<h1 class="productbar_title mart10">Order Details</h1>
													<div>
						     							<ul class="beerdirectory">
											        		<li>
											        			<div class="pull-left  wid25">Order No : </div>
											        			<div class="pull-left white_text wid75"><?php echo $event->order_number ;?></div>
											        			<div class="clearfix"></div>
											        		</li>
											        		<li>
											        			<div class="pull-left wid25">Order Date : </div>
											        			<div class="pull-left white_text wid75"><?php echo date($site_setting->date_format,strtotime($event->order_date ));?></div>
											        			<div class="clearfix"></div>
											        		</li>
											        		<li>
											        			<div class="pull-left wid25">Order Status : </div>
											        			<div class="pull-left white_text wid75"><?php echo ucfirst($event->status);?></div>
											        			<div class="clearfix"></div>
											        		</li>
											        		<li>
											        			<div class="pull-left wid25">Grand Total : </div>
											        			<div class="pull-left white_text wid75"><?php echo $site_setting->currency_symbol." ".$event->total;?></div>
											        			<div class="clearfix"></div>
											        		</li>
											        	</ul>
						     						</div>
					     						</div>
					     							<div class="review_mainblock padt10">
					     							<h1 class="productbar_title mart10">Customer Information</h1>
													<div>
						     							<ul class="beerdirectory">
											        		<li>
											        			<div class="pull-left  wid25">Customer Name : </div>
											        			<div class="pull-left white_text wid75"><?php echo $event->first_name.' '.$event->last_name; ?></div>
											        			<div class="clearfix"></div>
											        		</li>
											        		<li>
											        			<div class="pull-left wid25">Email : </div>
											        			<div class="pull-left white_text wid75"><?php echo $event->email;?></div>
											        			<div class="clearfix"></div>
											        		</li>
											        		<li>
											        			<div class="pull-left wid25">Phone Number : </div>
											        			<div class="pull-left white_text wid75"><?php echo $event->mobile_no;?></div>
											        			<div class="clearfix"></div>
											        		</li>
											        	</ul>
						     						</div>
					     						</div>
					     						<div class="clearfix"></div>
				     						</div>
				     						<div>
				     							<div class="review_mainblock mar_r30 padt10">
												<h1 class="productbar_title mart10">Customer Address</h1>
												
												<?php echo $event->address!='' ? $event->address.', ':''.$event->user_city!='' ? $event->user_city.', ':''.$event->user_state!='' ? $event->user_state.', ':''.$event->user_zip; ?> <br/> 
					     						</div>
					     						<div class="review_mainblock padt10">
					     							<h1 class="productbar_title mart10">Shipping Address</h1>
													<?php echo $event->address1.", ".$event->address2.', '.$event->country.', '.$event->city.', '.$event->state.' '.$event->zipcode; ?>  <br/>
					     						</div>
					     						<div class="clearfix"></div>
				     						</div>
				     						<div>
				     							<h1 class="productbar_title mart10">Shopping Cart</h1>
				     							<?php $get_order_detatis = $this->bar_model->AllOrderDet($event->order_id);?>
				     							<div>
				     								<table class="table">
												<thead>
													<th>
																Product	 Image
																</th>
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
												</thead>
												<tbody>
								<?php $sum = 0;
																if($get_order_detatis)
																
																{
																	
																	foreach($get_order_detatis as $row){?>					
													<tr class="light" >
														<td><?php $getimage = getsingleimage($row->store_id);?>
     									<?php 
									if($getimage!="" && is_file(base_path().'upload/product_thumb_80/'.$getimage)){ ?>
										<img src="<?php echo base_url().'upload/product_thumb_80/'.$getimage; ?>"  />
									<?php
									}
									else{?>
									<img class="img-responsive" src="<?php echo base_url().getThemeName().'images/video1.png'; ?>" />
							<?php } ?></td>
						  		<td><a href="<?php echo $row->bslug !='' ? site_url('bar/details/'.$row->bslug):site_url('bar/details/'.$row->bar_slug); ?>"><?php echo $row->barname=='' ? ucwords($row->bname):ucwords($row->barname); ?></a></td>
						  		<td>
																		<a target="_blank" href="<?php echo base_url().'shopping/details/'.$row->product_slug; ?>"><?php echo  $row->product_name; ?></a>
																</td>
																<td>
																		<?php echo  $row->colname; ?>
																</td>
																<td>
																		<?php echo  $row->sizename; ?>
																</td>
																<td>
																		 <?php echo $site_setting->currency_symbol." ".number_format($row->price,2) ;?>
																	</td>
																	<td>
																		 <?php echo $row->quantity ;?>
																	</td>
																	
																	<td>
																		 <?php echo $site_setting->currency_symbol." ".number_format($row->total,2); 
																		      $sum +=  $row->total;?>
																	</td>
																</tr>
									<?php } } ?>				
													<tr>
														<td colspan="8" align="right" class="table-total_bg">
															<p class="table-total-text">Total :   <?php  echo $site_setting->currency_symbol." ". number_format($sum,2); ?></p>
														</td>
													</tr>
												</tbody>
											</table>
											
											<?php $i++; } } else { ?>
									<tr>
										<td colspan="7">No any order found .</td>
									</tr>	
										
									<?php } ?>	
									
				     							</div>
				     						</div>
										</td>
										
									</tr>
								
									
									
									
									
								</tbody>
							</table>
							</div>
							<input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
					<input type="hidden" name="offset" id="offset" value="<?php echo ($offset!='')?$offset:0; ?>" />
					<input type="hidden" name="limit" id="limit" value="<?php echo ($limit>0)?$limit:10; ?>" />
						</div>
						</form>
    
   

<script>

	 $(".pagination li a").click(function() {
		  //alert("Handler for .click() called.");
		  var res = $.ajax(
	        {						
			   type: 'POST',
			   url: $(this).attr("href"),
			   dataType: 'post', 
			   cache: false,
			   async: false,
			   beforeSend : function(){
			      $('#dvLoading').fadeIn('slow');
			   },
			   complete: function(){
			   
			     $('#dvLoading').fadeOut('slow');
			     
			    }
			}).responseText;
			
			$("#list_hide").html(res);
			return false;
			
		});

 
</script>
