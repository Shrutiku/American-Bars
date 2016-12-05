<style>
.morecontent span {
    display: none;
}
.morelink {
    display: block;
}
span.required {
    color: #B31010;
    vertical-align: -4px;
}
</style>

<script>
function incrementValue()
{
	
	var n1 = Number(document.getElementById("qn").value);
	var n2 = Number(document.getElementById("avl_q").value);
	
	
    var value = parseInt(document.getElementById('qn').value, 10);
    value = isNaN(value) ? 0 : value;
    value++;
    if(value>n2)
	{
		return false;
	}
    document.getElementById('qn').value = value;
}
function descrementValue()
{
	if(parseInt(document.getElementById('qn').value)<=1)
	{
		return false;
	}
	
    var value = parseInt(document.getElementById('qn').value, 10);
    value = isNaN(value) ? 0 : value;
    value--;
    document.getElementById('qn').value = value;
}
function addToCart(iid,bar_id)
	{
		<?php if($this->session->userdata('user_type')=='taxi_owner'){?>
  	    	  $.growlUI('<?php echo NO_RIGHT; ?>');
  	    	   $(".growlUI strong").empty();
  	    	  return false;
  	    <?php } ?> 
		        	
		var color_id = $("#color").val();
		var size_id = $("#size").val();
		var qnty = $("#qn").val();
		$.ajax({
			url:'<?php echo site_url('shopping/addTocart') ?>',
			type:'POST',
			dataType:'json',
			data:{id:iid,bar_id:bar_id,color_id:color_id,size_id:size_id,qnty:qnty},
			success:function(data){
			    
			    
				if(data.count>0 && data.status=="success")
				{	
					$("#disable_btn").attr('disabled','disabled');
					$("#cartcount").html('<span class="itemcart">'+data.count+'</span>');
					$("#cartcount_2").html('<span class="itemcart">'+data.count+'</span>');
					//alertify.alert("Item has been added to cart Successfully");
					$.growlUI('<?php echo "Item has been added to cart Successfully"; ?>'); 
				}
				
				if(data.count==0 && data.status=="fail")
				{	
					$.growlUI('<?php echo "Item Not available"; ?>'); 
				}
				else if(data.status=="fail")
				{	
					$.growlUI('<?php echo "You cannot buy bar product and ADB product at the same time. Please complete your current order"; ?>'); 
				}
				
			}
		})
	}
	$(document).ready(function() {
		
	var showChar = 600;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more";
    var lesstext = "Show less";
    
    $('.more').each(function() {
        var content = $(this).html();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="javascript://;" class="morelink more pull-right"><i class="strip arrow_down"></i>' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
      $(".morelink").click(function(){
         $("#myModalnew_open").modal('show');
    });
     }); 
</script>

		            		
		            		
		            		
<?php $theme_url = $urls= base_url().getThemeName();?>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/rating.js"></script>
<script type="text/javascript" src="<?php echo $theme_url; ?>/js/jquery_form.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/js/rating.css" />

<div class="wrapper row5">
     	<div class="container">
     	<div class="beer_details">
     		<div class="mar_top20">
	     		<div>
	     			<div class="result_search">
	     				<div class="result_search_text"><?php echo $product['product_name'];?></div>
     				</div>
     				<div  class="text-right">
     							<a class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('shopping/products')?>" >Back</a>
     						</div>
     				<div class="pad_t15b20 pad_lr10 br-bott-gray">
     					<div class="product-img">
     					<?php if($product['product_name']=='Cap' || $product['product_name']=='Tshirt'){ ?>
     						<?php 
										if($product['product_image']!="" && is_file(base_path().'upload/product_thumb_big/'.$product['product_image'])){ ?>
											<img src="<?php echo base_url().'upload/product_thumb_big/'.$product['product_image']; ?>" class="img-responsive" />
										<?php
										}
										else{?>
										<img height="200" width="200" src="<?php echo base_url().'upload/beer_thumb/no_image.png'; ?>" />
								<?php } ?>
     				   <?php } else {?>			
     						<ul class="bxslider">
	     					     <?php if($product_gallery){
     					  	    foreach($product_gallery as $rows){
     					  	    	?>
									  <li class="br_green_yellow">
									  	<img class=" gallery_img" src="<?php echo base_url().'upload/product_thumb_big/'.$rows->product_image_name;?>" /></li>
								<?php } }?>	  
									</ul>
									
									
									 <?php if($product_gallery){ ?>
									 	<ul id="bx-pager" class="bxslider1">
     					  	    <?php $i=0; foreach($product_gallery as $rows){
     					  	    	?>	
									  <li ><a  data-slide-index="<?php echo $i;?>" href=""><img class="thumb_img" src="<?php echo base_url().'upload/product_thumb_80/'.$rows->product_image_name;?>" /></a></li>
									<?php $i++; } ?>  </ul> <?php }?>
						<?php } ?>			
     						  
     					</div>
     					<div class="product-detail">
     						<h1 class="productdetail-title"><?php echo ucfirst($product['product_name']);?></h1>
     						<div class="mart10">
     							<p class="price-text"><?php echo $site_setting->currency_symbol." ".number_format($product['price'],2);?></p>
	   	 						<div class="mart10">
	   	 							<?php  $col = explode(',', $product['color']);
						  			   	$size = explode(',', $product['size']);?>
     								<p class="quantity-text">Color :</p>
			   	 					<select class="form-control pull-left" name="color" id="color">
			   	 					<?php /*$colorlist = getColor($col);
                                                if($colorlist!=''){
                                                 foreach($colorlist as $cl){?>
                                                 	 <option value="<?php echo $cl->Color_id ?>" ><?php echo ucwords($cl->color_name); ?></option>
                                                 <?php } } */ ?>
                                                 
                                       <?php 
                                                if($col!=''){
                                                 foreach($col as $cl){?>
                                                 	 <option value="<?php echo $cl; ?>" ><?php echo ucwords($cl); ?></option>
                                                 <?php } }  ?>          	
			   	 					</select>
			   	 					<div class="clearfix"></div>
	   	 						</div>
	   	 						<div class="mart10">
     								<p class="quantity-text">Size :</p>
			   	 					<select class="form-control pull-left" name="size" id="size">
			   	 						 <?php /* $sizelist = getSize($size);
                                                if($sizelist!=''){
                                                 foreach($sizelist as $s){?>
                                                    <option value="<?php echo $s->Size_id ?>"><?php echo ucwords($s->size_name); ?></option>
                                            <?php   }} */ ?>
                                            
                                            
                                            <?php  if($size!=''){
                                                 foreach($size as $s){?>
                                                    <option value="<?php echo $s ?>"><?php echo ucwords($s); ?></option>
                                            <?php   }} ?>	
			   	 					</select>
			   	 					<div class="clearfix"></div>
	   	 						</div>
	   	 						<div class="mar_top20">
     								<p class="quantity-text pull-left">Quantity :</p>
     								<input type="hidden" name="avl_q" id="avl_q" value="<?php echo $product['quantity']; ?>" />
			   	 					<button onclick="descrementValue()"  type="submit" name="" class="plusbtn"> - </button><input style="color: #ffffff; text-align: center;" readonly="readonly" type="text" name="qn" id="qn" class="form-control pull-left" value="1"><button type="submit" name="" class="plusbtn  margin-right-10" onclick="incrementValue()" > + </button>
			   	 					<div class="clearfix"></div>
	   	 						</div>
     							
     							<!-- <div class="starrating pull-left mar_right20">  <a href="javascript://"></a> </div>						         		
     							<a class="pull-left more" onclick="show_popup()">Write a Review</a>
						         <div class="clearfix"></div> -->
     						</div>
     						<div class="mar_top20">
			    		 	<?php $c=''; 
			    		 	if($this->cart->contents())
			    		 	{
			    		 		foreach($this->cart->contents() as $crt)
								{
									
									if($crt['id']== $product['store_id'])
									{
										//$c = 'disabled=disabled alt="Product already saved in cart."';
									}
								}
			    		 	}?>	
     							<a <?php echo $c; ?> id="disable_btn"  onclick="addToCart('<?php echo $product['store_id']; ?>','0');" class="btn btn-lg btn-primary">Add To Cart</a>
     						</div>
     					</div>
     					<div class="clearfix"></div>
     				</div>
     				<div class="padtb10 pad_lr10 br-bott-gray">
     					<h1 class="description-title">Description : </h1>
     					<p class="bar_add">	<?php echo $product['description']; //if(strip_tags(strlen($product['description'])>1000)){ echo substr(strip_tags($product['description']),0,1000).'...<a class="morelink more pull-right" href="javascript://"><i class="strip arrow_down"></i>Show more</a>' ; } else { echo strip_tags($product['description']); } ?></p>
     					<div class="clearfix"></div>
     					<!-- <div class="result_search">
	     					<div class="result_search_text">Product Detail</div>
     					</div> -->
     					<!-- <h3 class="br_bott_yellow detail-title">Product Detail</h3> -->
     					<!-- <ul class="beerdirectory">
						    <li>
						    	<div class="pull-left yellow_text marr_10">Price : </div>
						        <div class="pull-left white_text"><?php echo $site_setting->currency_symbol." ".$product['price']; ?></div>
						        <div class="clearfix"></div>
						    </li>
						    <li>
						    	<div class="pull-left yellow_text marr_10">Quantity : </div>
						        <div class="pull-left white_text"><?php echo $product['quantity'];?></div>
						        <div class="clearfix"></div>
						    </li>
						    <li>
						    	<div class="pull-left yellow_text marr_10">Color : </div>
						        <div class="pull-left white_text"><?php //echo  $product['color'];
						        	//$getcol = getcolor($product['store_id']);
						        	$servicename = "";
						        	$exp = explode(",",$product['color']);
									foreach($exp as $val)
									{
										$servicename .= getcolorname($val).' , ';
									}
									
									echo substr($servicename, 0 , -3);
									
						        	
						        	?></div>
						        <div class="clearfix"></div>
						    </li>
						    
						     <li>
						    	<div class="pull-left yellow_text marr_10">Size : </div>
						        <div class="pull-left white_text"><?php //echo  $product['color'];
						        	//$getcol = getcolor($product['store_id']);
						        	$sizename = "";
						        	$exp = explode(",",$product['size']);
									foreach($exp as $val)
									{
										$sizename .= getsizename($val).' , ';
									}
									
									echo substr($sizename, 0 , -3);
									
						        	
						        	?></div>
						        <div class="clearfix"></div>
						    </li>
						</ul> -->
     					
     					
     				
     				</div>
     				<div>
     					<h1 class="description-title padt10 pad_lr10">Related Products : </h1>
     					<div class="related-product">
     						<ul class="product-listing">
     								<?php 
							$related_beer = toprelatedproduct($product['store_id'],$product['product_name']);
							if(count($related_beer)>0){ 
							foreach($related_beer as $rs){?>
     							<li>
     							<div class="productlis-img">
     								<?php $getimage = getsingleimage($rs->store_id);?>
     								<a href="<?php echo site_url('shopping/details/'.$rs->product_slug); ?>">
     									<?php 
									if($getimage!="" && is_file(base_path().'upload/product_thumb/'.$getimage)){ ?>
										<img src="<?php echo base_url().'upload/product_thumb/'.$getimage; ?>"  />
									<?php
									}
									else{?>
									<img class="img-responsive" src="<?php echo base_url().getThemeName().'images/video1.png'; ?>" />
							<?php } ?>
     									</a>
     							</div>
     							<div class="productlist-detail">
     								<h1 class="prduct-title"><a href="<?php echo site_url('shopping/details/'.$rs->product_slug); ?>"> <?php echo strlen($rs->product_name)>40? ucfirst(substr($rs->product_name, 0,40)).'...':ucfirst($rs->product_name);?> </a></h1>
     								<div class="mart10">
     									<div class="prod-price">
     										<p><?php echo $site_setting->currency_symbol." ".number_format($rs->price,2);?></p>
     									</div>
     									<div class="prod-price">
     										<a href="<?php echo site_url('shopping/details/'.$rs->product_slug); ?>" class="btn btn-lg btn-primary btn-block ">Read More</a>
     									</div>
     									<div class="clearfix"></div>
	     								<!-- <p class="text-right"><a href="<?php echo site_url('shopping/details/'.$rs->product_slug); ?>" class="readmore">Read More</a></p> -->
     								</div>
     							</div>
     						</li>
     						 <?php } } else { ?>
     						 	   No Any Related Products Found.
     						 	<?php }?>
     						 
     						  <div class="clearfix"></div>
     						</ul>
     						<?php if(count($related_beer)>0){  ?>
     						<div class="text-right">
     							<a href="<?php echo site_url('shopping/products')?>" class="more">View more</a>
     						</div>
     						<?php } ?>
     					</div>
     				</div>
	     		</div>
	     	</div>
     	</div>	
   		</div>
   	</div>
   	<div class="modal fade" id="myModalnew_open" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Description</div>
     				</div>
     				<div class="pad20">
     						<label class="control-label" style="color: #fff;"><?php echo $product['description']; ?></label>	
     				</div>		
     			</div>
     		</div>
     	</div>
     </div>
	
</div>  	
   	
   <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.bxslider.min.js"></script>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/css/jquery.bxslider.css" />
   
<script>

	$(document).ready(function(e) {
   
   
  
 $('.bxslider').bxSlider({
		mode: 'horizontal',
		infiniteLoop:false,
	   pagerCustom: '#bx-pager',
	   controls:false,
	   useCSS: false,
	   preloadImages:'all',
	   speed: 1500,
	   auto:true,
	});
	
	 $('.bxslider1').bxSlider({
	 	useCSS: false,
	 	infiniteLoop:false,
	 	mode: 'horizontal',
	 	preloadImages:'all',
	 	controls:true,
	 	
		minSlides: 4,
	  	maxSlides: 4,
	  	slideWidth: 65,
	 	pager: false,
});

 
 //$('#soom_0').elevateZoom({zoomType: "inner",cursor: "crosshair",easing : true,});
    
 
});

</script>

<style>

	.bxslider1 li a img:hover
	{
		border:0px;
		height: auto;
	}
	
</style>