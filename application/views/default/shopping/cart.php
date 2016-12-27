<?php //pr($this->cart->contents());
$carts = $this->cart->contents();
$site_setting = site_setting();
 ?>
 <script type="text/javascript">
function update_cart(id,rowid,price,type,bar_id,color_id,size_id,id1){	
	var qty = $('#total_qty_'+id1).val(); 
	 if(type=='Minus')
	 {
	 	 var qt1 = parseInt(qty)-1;
	 	 if(qt1<1)
	 	 {
	 	 	return false;
	 	 }
	 }
	
	 $.ajax({ type: "POST",  
         url: "<?php echo site_url('shopping/update_cart')?>",
         data:{id:id,rowid:rowid,type:type,qty:qty,bar_id:bar_id,color_id:color_id,size_id:size_id,id1:id1}, 
         async: false,
         success : function(data)
         {
         	if(data==0)
         	{
         		$.growlUI('<?php echo "Item Not available"; ?>'); 
         	}
         	else
         	{
         			$('#cart_'+id1).html(data); 
         			 var num =  parseFloat(($('#total_price').html().replace(/\,/g,'')) - ((parseFloat(price.replace(/\,/g,'')) * parseFloat(qty.replace(/\,/g,'')))) + parseFloat($('#price_'+id1).html().replace(/\,/g,'')));
         			 $('#total_price').html(num.toFixed(2));
        
         	}
          }
    });
}	
function update_color(id,rowid,price,type,bar_id,color_id,size_id,id1){	
	var qty = $('#total_qty_'+id1).val(); 
	
	 $.ajax({ type: "POST",  
         url: "<?php echo site_url('shopping/update_cart_color')?>",
         data:{id:id,rowid:rowid,type:type,qty:qty,bar_id:bar_id,color_id:color_id,size_id:size_id,id1:id1}, 
         async: false,
         success : function(data)
         {
         	//$('#cart_'+id).html(data); 
         	//$('#total_price').html(parseFloat($('#total_price').html() - (parseFloat(price) * parseFloat(qty)) + parseFloat($('#price_'+id).html())));
         	//$.growlUI('<?php //echo "Cart Update Successfully."; ?>'); 
         	window.location.href = '<?php echo current_url();?>';
         }
    });
}	
function removecart(id,rowid,price,type,bar_id,color_id,size_id,id1)
{
	var qty = 0;
	
	var pricetotal = parseFloat($('#total_qty_'+id1).val())*parseFloat(price); 
	
	 $.ajax({ type: "POST",  
         url: "<?php echo site_url('shopping/remove_cart')?>",
         data:{id:id,rowid:rowid,type:type,qty:qty,bar_id:bar_id,color_id:color_id,size_id:size_id,id1:id1}, 
         async: false,
         dataType:"JSON",
         success : function(data)
         {
         	        if(data.total==0)
         	        {
         	        	window.location.href = '<?php echo site_url('shopping/products');?>';
         	        }
         			 var num =  parseFloat($('#total_price').html() - parseFloat(pricetotal));
         			 $('#total_price').html(num.toFixed(2));
         			  $('#cart_'+id1).remove(); 
         			 $.growlUI('<?php echo "Item Remove Successfully."; ?>'); 
        
          }
    });
}
function update_size(id,rowid,price,type,bar_id,color_id,size_id,id1){	
	var qty = $('#total_qty_'+id1).val(); 
	 $.ajax({ type: "POST",  
         url: "<?php echo site_url('shopping/update_cart_size')?>",
        data:{id:id,rowid:rowid,type:type,qty:qty,bar_id:bar_id,color_id:color_id,size_id:size_id,id1:id1}, 
         async: false,
         success : function(data)
         {
         	window.location.href = '<?php echo current_url();?>';
         	//$.growlUI('<?php //echo "Cart Update Successfully."; ?>'); 
         }
    });
}	
</script>

 <div class="wrapper row5 forum-listing">
     	<div class="container">
     		<div class="result_search">
     			<div class="col-sm-8">
	     			<div class="result_search_text pull-left">Check Out</div>
	            </div>
	            <div class="clearfix"></div>
     		</div>
     		
     		<div class="table-responsive mar_top20">
							<table class="table">
								<thead>
									<th>Item Description</th>
									<th>Bar Name</th>
									<th>Price</th>
									<th class="tablewid20">Quantity </th>
									<!-- <th>Color </th>
									<th>Size </th> -->
									<th>Total</th>
									<th>Action</th>
								</thead>
								<tbody>
							<?php 
							
							
							$i=1;
				  				$total = 0;
								$count = count($carts);
								
								//print_r($carts);
				  				if($carts){
				  					
				  					foreach($carts as $cart){ $i++;
				  						$price = $cart['price'] * $cart['qty'];
										$total = $total + $price;
							 
							  $storeinfo = getstoreinfo($cart['id']);
							
							if ($i % 2 == 0)
										  {
										    $dark =  "dark";
										  }
										  else
										  {
										    $dark =  "light";
										  }?>		
									<tr id="cart_<?php echo $i;?>" class="<?php echo $dark; ?>">
										<td><a href="<?php echo site_url('shopping/details/'.$storeinfo->product_slug);?>"><?php echo get_product_name($cart['id']);?></a></td>
										<td><?php echo getBarName($cart['options']['bar_id']);?></td>
										<input type="hidden" name="total_qty_<?php echo $i;?>" id="total_qty_<?php echo $i;?>" value="<?php echo $cart['qty'];?>" >
										<td><?php echo $site_setting->currency_symbol.' '.number_format($cart['price'],2); ?></td>
										<td valign="top" class="tablewid20"><a href="javascript://" class="margin-right-10 keep_title plusbtn " onclick="update_cart('<?php echo $cart['id'];?>','<?php echo $cart['rowid'];?>','<?php echo $cart['price'];?>','Add','<?php echo $cart['options']['bar_id'];?>','<?php echo $cart['options']['color_id'];?>','<?php echo $cart['options']['size_id'];?>','<?php echo $i;?>');"> + </a>
						  				<div class="table_quantity margin-top-15 margin-right-10 plus-minustext" id="qty_<?php echo $cart['id'];?>"><?php echo $cart['qty'];?></div>
						  				<a href="javascript://" class="blog_title plusbtn" onclick="update_cart('<?php echo $cart['id'];?>','<?php echo $cart['rowid'];?>','<?php echo $cart['price'];?>','Minus','<?php echo $cart['options']['bar_id'];?>','<?php echo $cart['options']['color_id'];?>','<?php echo $cart['options']['size_id'];?>','<?php echo $i;?>');"> - </a>
						  			</td>
						  			   <!-- <td>
						  			   	<?php  $col = explode(',', $storeinfo->color);
						  			   	$size = explode(',', $storeinfo->size);?>
						  			   	<select data-placeholder="Select Color" onchange="update_color('<?php echo $cart['id'];?>','<?php echo $cart['rowid'];?>','<?php echo $cart['price'];?>','Add','<?php echo $cart['options']['bar_id'];?>',this.value,'<?php echo $cart['options']['size_id']; ?>','<?php echo $i;?>');" class="m_wrap select_box wid360"  id="color" name="color">
                                             
                                                 
                                                  <?php 
                                                if($col!=''){
                                                 foreach($col as $cl){?>
                                                 	 <option value="<?php echo $cl; ?>" <?php  echo $cl==$cart['options']['color_id'] ?'selected':''; ?> ><?php echo ucwords($cl); ?></option>
                                                 <?php } }  ?>        	
                                           </select>      
                                                 </td> -->
						  			   <!-- <td>
						  			   	<select data-placeholder="Select Size" onchange="update_size('<?php echo $cart['id'];?>','<?php echo $cart['rowid'];?>','<?php echo $cart['price'];?>','Add','<?php echo $cart['options']['bar_id'];?>','<?php echo $cart['options']['color_id']; ?>',this.value,'<?php echo $i;?>');" class="m_wrap select_box wid360 "  id="size" name="size">
						  			   		
                                            <?php  if($size!=''){
                                                 foreach($size as $s){?>
                                                    <option value="<?php echo $s ?>" <?php  echo $s==$cart['options']['size_id'] ?'selected':''; ?>><?php echo ucwords($s); ?></option>
                                            <?php   }} ?>	
                                           </select>
						  			   </td> -->
										<td><?php echo $site_setting->currency_symbol; ?> <span id="price_<?php echo $i;?>"  ><?php echo number_format($price,2);?></span></td>
										<td>
											<!-- <a href="#"><i class="glyphicon glyphicon-plus-sign"></i></a> -->
							       			<a href="javascript://" onclick="removecart('<?php echo $cart['id'];?>','<?php echo $cart['rowid'];?>','<?php echo $cart['price'];?>','Minus','<?php echo $cart['options']['bar_id'];?>','<?php echo $cart['options']['color_id'];?>','<?php echo $cart['options']['size_id'];?>','<?php echo $i;?>')"><i class="glyphicon glyphicon-trash"></i></a>
							       		</td>
									</tr>
							<?php } } ?>	
							
							      	
									
								</tbody>
							</table>
						</div>
							<?php if($carts){ ?>
						<div class="br_bott_yellow">
							<div class=" text-right">
								<p class="subtottal-text">Total : <?php echo $site_setting->currency_symbol; ?> <span id="total_price" style="display: inline;"><?php echo number_format($total,2);?></span></p>
							<input type="hidden" name="total_qty_input" id="total_qty_input" value="<?php echo $total;?>" />
							</div>
							<div class="clearfix"></div>
						</div>
						<?php } ?>
						<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
							<?php
							 	$attributes = array('name'=>'frmPayNow','id'=>'frmPayNow','class'=>'form-vertical');
								echo form_open('shopping/cart',$attributes);
							?>
						<div class="mar_top20">
							<div class="result_search">
				     			<div class="col-sm-8">
					     			<div class="result_search_text pull-left">Payment Method</div>
					            </div>
					            <div class="clearfix"></div>
				     		</div>
				     		<div class="payment-block mart10">
				     			<div class="mar_top20">
					     			<label class="control-label">Card :</label>
									<ul class="card-type">
										<li><a href="#"><img src="<?php echo base_url().getThemeName(); ?>/images/visa.png" alt="" class="img-responsive" /></a></li>
										<li><a href="#"><img src="<?php echo base_url().getThemeName(); ?>/images/master.png" alt="" class="img-responsive" /></a></li>
										<li><a href="#"><img src="<?php echo base_url().getThemeName(); ?>/images/amex.png" alt="" class="img-responsive" /></a></li>
										<li><a href="#"><img src="<?php echo base_url().getThemeName(); ?>/images/discover.png" alt="" class="img-responsive" /></a></li>
										<div class="clearfix"></div>
									</ul>
								</div>	
								<form class="form-horizontal">
									<div class="padtb">
	        				 		<label class="control-label">Credit Card Type : <span class="aestrick"> * </span></label>
	                       		<div class="control-group" >
	                           		<select class="form-control form-pad select" name="cc_type" id="cc_type">
		                           		<option value="">SELECT CARD TYPE...</option>
							            <option value="MasterCard">MasterCard</option>
							            <option value="Visa" >Visa</option>
										<option value="Amex" >American Express</option>
				                        <option value="Discover" >Discover</option>
		                         	</select>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
									
		                       		<div class="padtb">
			        				 	<label class="control-label">Credit Card Number : <span class="aestrick"> * </span></label>
			                       		<div class="control-group">
			                           		<input type="text" name="card_number" maxlength="40" class="form-control form-pad" id="card_number" placeholder="Credit Card Number" value="">
			                       		</div>
			                       		<div class="clearfix"></div>
		                       		</div>
		                       		<div class="padtb8">
	        				 		<label class="control-label">Expiration Date : <span class="aestrick"> * </span></label>
	                       		<div class="col-sm-4" style="padding-left: 0;">
	                       			<select class="form-control form-pad select"  id="ex_month" name="ex_month">
	                       				<option value="">Month</option>
	                       				<option value="01">January</option>
	                       				<option value="02">February</option>
	                       				<option value="03">March</option>
	                       				<option value="04">April</option>
	                       				<option value="05">May</option>
	                       				<option value="06">June</option>
	                       				<option value="07">July</option>
	                       				<option value="08">August</option>
	                       				<option value="09">September</option>
	                       				<option value="10">October</option>
	                       				<option value="11">November</option>
	                       				<option value="12">December</option>
	                       			</select>
	                       		</div>
	                       		<div class="col-sm-4" style="padding-left: 0;">	
	                       			<select class="form-control form-pad select" id="ex_year" name="ex_year">
	                       				<option value="">Day</option>
	                       				 <?php $dt=date('Y');
							for ($i=$dt; $i <$dt+10 ; $i++) {?> 
							<option value="<?php echo $i ?>"><?php echo $i ?></option>
							<?php } ?></select>
	                       		</div>	
	                       			<div class="clearfix"></div>
	        				 		<!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value=""> -->
	        				 	</div>
		                       		
		                       		<div class="padtb">
			        				 	<label class="control-label">CVV : <span class="aestrick"> * </span></label>
			                       		<div class="control-group">
			                           		<input type="text" name="cvv" maxlength="40" class="form-control form-pad" id="cvv" placeholder="CVV" value="">
			                       		</div>
			                       		<div class="clearfix"></div>
		                       		</div> 
							   </form>
							   
							  </div>
							   
							   <div class="result_search mar_top20">
				     			<div class="col-sm-8">
					     			<div class="result_search_text pull-left">Billing Information</div>
					            </div>
					            <div class="clearfix"></div>
				     			</div>
				     		<div class="payment-block mar_top20">
							   
		                       	<div class="padtb">
			        				 	<label class="control-label">Address1 : <span class="aestrick"> * </span></label>
			                       		<div class="control-group">
			                           		<input type="text" name="address1" maxlength="40" class="form-control form-pad" id="address1" placeholder="Address1" value="">
			                       		</div>
			                       		<div class="clearfix"></div>
		                       	</div>
		                       	
		                       	<div class="padtb">
			        				 	<label class="control-label">Address2 : <span class="aestrick"> * </span></label>
			                       		<div class="control-group">
			                           		<input type="text" name="address2" maxlength="40" class="form-control form-pad" id="address2" placeholder="Address2" value="">
			                       		</div>
			                       		<div class="clearfix"></div>
		                       	</div>
		                       	
		                       	<div class="padtb">
			        				 	<label class="control-label">City : <span class="aestrick"> * </span></label>
			                       		<div class="control-group">
			                           		<input type="text" name="city" maxlength="40" class="form-control form-pad" id="city" placeholder="City" value="">
			                       		</div>
			                       		<div class="clearfix"></div>
		                       	</div>
		                       	
		                       	<div class="padtb">
			        				 	<label class="control-label">State : <span class="aestrick"> * </span></label>
			                       		<div class="control-group">
			                           		<input type="text" name="state" maxlength="40" class="form-control form-pad" id="state" placeholder="State" value="">
			                       		</div>
			                       		<div class="clearfix"></div>
		                       	</div>
		                       	
		                       		<div class="padtb">
			        				 	<label class="control-label">Zipcode : <span class="aestrick"> * </span></label>
			                       		<div class="control-group">
			                           		<input type="text" name="zipcode" maxlength="40" class="form-control form-pad" id="zipcode" placeholder="Zipcode" value="">
			                       		</div>
			                       		<div class="clearfix"></div>
		                       	</div>
		                       	
		                       	<div class="padtb">
			        				 	<label class="control-label">Country : <span class="aestrick"> * </span></label>
			                       		<div class="control-group">
			                           		<input type="text" name="country" maxlength="40" class="form-control form-pad" id="country" placeholder="Country" value="">
			                       		</div>
			                       		<div class="clearfix"></div>
		                       	</div>
		                       	
		                       	<div class="mar_top20 text-center"><button type="submit" name="" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#myModal">CheckOut Now</button></div>
							   
							</div>
						</div>
						
   		</div>
   	</div>
   	
</form>
<input type="hidden" name="sess_id" id="sess_id" value="<?php echo check_user_authentication()=="" ? '0':'1';?>" />
<script type="text/javascript" src="<?php echo  base_url().getThemeName(); ?>/js/jquery_form.js"></script>
<script>
  
    $(document).ready(function(){
        $('#frmPayNow').validate({
		rules: {			
			cc_type: {
				required: true,
			},			
			card_number: {
				required: true,
			},
			ex_month: {
				required: true,
			},
			ex_year: {
				required: true,
			},
			cvv: {
				required: true,
			},	
			address1: {
				required: true,
			},
			address2: {
				required: true,
			},	
			country: {
				required: true,
			},	
			zipcode: {
				required: true,
			},	
			state: {
				required: true,
			},	
			city: {
				required: true,
			},	
			
						
		  	//errorClass:'error fl_right'			
		},
				
		submitHandler: function(form){
			
		$(form).ajaxSubmit({
			
		type: "POST",
		   		 dataType : 'json',
				 beforeSubmit: function() 
				 {
				 	if($('#sess_id').val()==0)
					{
						$('#loginmodal').modal('show');
						return false;
					}
		       		$('#dvLoading').fadeIn('slow');
		    	 },
		    	
		    	uploadProgress: function ( event, position, total, percentComplete ) {	
		        },
		    
		    	success : function ( json ) 
		    	{
		    		
					if(json.status == "fail")
					{
						$("#cm-err-main1").show();
						$("#cm-err-main1").html(json.comment_error);
			    		$('#dvLoading').fadeOut('slow');
			    		scrollToDiv('cm-err-main1');
			    		
				  		// setTimeout(function () 
						// {
						      // $("#cm-err-main1").fadeOut('slow');
						// }, 3000);
					return false;
					}
			
					else
					{
						window.location.href = '<?php echo site_url('home/index/'.base64_encode('ordersuccess'));?>';
					}
					$('#dvLoading').fadeOut('slow');
		   		 }
		    });
		  }
		})
		
    });
    
    
  
</script>