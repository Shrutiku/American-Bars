

<?php
$theme_url = $urls= base_url().getThemeName();
?>

<!-- <script type="text/javascript" src="<?php echo base_url(); ?>jwplayer/jwplayer.js"></script> -->
<script type="text/javascript">
   
	function set_orderby(limit,alpha,option,keyword,offset)
	{
	$('#beer-search-frm').submit();
	}
	function limitsubmit(){	
		$('#beer-search-frm').submit();
	}
</script>

<!-- content -->
<div class="wrapper row4">
   		<div class="container clearfix">
   			<div id="slider-fixed-banner" class="carousel slide">
        	<div class="carousel-inner">
          	<div class="active item">
            	 <?php $getimagename = getimagenamebanner();?>	
          	  <?php 
									if($getimagename->beer_directory!="" && is_file(base_path().'upload/bar_pages_banner_orig/'.$getimagename->beer_directory)){ ?>
										<img src="<?php echo base_url().'upload/bar_pages_banner/'.$getimagename->beer_directory; ?>"   />
									<?php
									} else {?>
            	<img src="<?php echo base_url(); ?>/default/images/smallbanner1.png" alt="American Dive Bars"/>
            	<?php } ?>
          </div>
        </div>
        <!-- <a class="left carousel-control" href="#slider-fixed-banner" data-slide="prev">&lsaquo;</a>
        <a class="right carousel-control" href="#slider-fixed-banner" data-slide="next">&rsaquo;</a> -->
       
   	</div>
	</div>
  </div>
  

	<div class="wrapper row5">
		<div class="container">
		   <div>
			<form class="form-horizontal" id="beer-search-frm" method="post" role="form" action="<?php echo site_url("shopping/products"); ?>">
			  <div class="">
				<div class="result_search">
					<div class="col-sm-6 product-search">
						<div class="result_search_text pull-left"><?php echo $total_rows;?> Results Found</div>
					</div>
					<div class="col-sm-4 product-search">
						   <div class="form-group pull-left">
								<label for="inputEmail3" class="control-label">Results Per Page :</label>
								<select class="select_box marr_10" name="limit" id="limit" onchange="limitsubmit();">
									<option value="10"<?php if($limit==10){ ?> selected="selected"<?php } ?>>10</option>
									<option value="20"<?php if($limit==20){ ?> selected="selected"<?php } ?>>20</option>
									<option value="30"<?php if($limit==30){ ?> selected="selected"<?php } ?>>30</option>
									<option value="40"<?php if($limit==40){ ?> selected="selected"<?php } ?>>40</option>
									<option value="50"<?php if($limit==50){ ?> selected="selected"<?php } ?>>50</option>
										<option value="100" <?php if($limit == "100"){?> selected= "selected" <?php } ?>>100</option> 
								 </select>
						   </div>
						   <div class="form-group  pull-left">						  
								<label for="inputEmail3" class="control-label">Sort By :</label>
								 <select class="select_box" name="order_by" id="order_by" onchange="set_orderby('<?php echo $limit;?>','<?php echo $alpha;?>','<?php echo $options;?>','<?php echo $keyword;?>','<?php echo $offset; ?>')">
									<option value="product_name#ASC" <?php if($order_by == "product_name#ASC"){ ?> selected="selected" <?php } ?>>Name ASC</option>
									<option value="product_name#DESC"<?php if($order_by == "product_name#DESC"){ ?> selected="selected" <?php } ?>>Name DESC</option>
								 </select>
						   </div>
						   <div class="clearfix"></div>
					  </div>
					  <div class="clearfix"></div>
				</div>
				<div class="alphabate_block">
					<ul class="alphabate_list">
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("a")); ?>" <?php if($alpha == "a"){ ?> class="active" <?php }?>>a</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("b")); ?>" <?php if($alpha == "b"){ ?> class="active" <?php }?>>b</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("c")); ?>" <?php if($alpha == "c"){ ?> class="active" <?php }?>>c</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("d")); ?>" <?php if($alpha == "d"){ ?> class="active" <?php }?>>d</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("e")); ?>" <?php if($alpha == "e"){ ?> class="active" <?php }?>>e</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("f")); ?>" <?php if($alpha == "f"){ ?> class="active" <?php }?>>f</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("g")); ?>" <?php if($alpha == "g"){ ?> class="active" <?php }?>>g</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("h")); ?>" <?php if($alpha == "h"){ ?> class="active" <?php }?>>h</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("i")); ?>" <?php if($alpha == "i"){ ?> class="active" <?php }?>>i</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("j")); ?>" <?php if($alpha == "j"){ ?> class="active" <?php }?>>j</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("k")); ?>" <?php if($alpha == "k"){ ?> class="active" <?php }?>>k</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("l")); ?>" <?php if($alpha == "l"){ ?> class="active" <?php }?>>l</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("m")); ?>" <?php if($alpha == "m"){ ?> class="active" <?php }?>>m</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("n")); ?>" <?php if($alpha == "n"){ ?> class="active" <?php }?>>n</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("o")); ?>" <?php if($alpha == "o"){ ?> class="active" <?php }?>>o</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("p")); ?>" <?php if($alpha == "p"){ ?> class="active" <?php }?>>p</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("q")); ?>" <?php if($alpha == "q"){ ?> class="active" <?php }?>>q</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("r")); ?>" <?php if($alpha == "r"){ ?> class="active" <?php }?>>r</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("s")); ?>" <?php if($alpha == "s"){ ?> class="active" <?php }?>>s</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("t")); ?>" <?php if($alpha == "t"){ ?> class="active" <?php }?>>t</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("u")); ?>" <?php if($alpha == "u"){ ?> class="active" <?php }?>>u</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("v")); ?>" <?php if($alpha == "v"){ ?> class="active" <?php }?>>v</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("w")); ?>" <?php if($alpha == "w"){ ?> class="active" <?php }?>>w</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("x")); ?>" <?php if($alpha == "x"){ ?> class="active" <?php }?>>x</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("y")); ?>" <?php if($alpha == "y"){ ?> class="active" <?php }?>>y</a></li>
						<li><a href="<?php echo site_url("shopping/products/".$limit."/".base64_encode("z")); ?>" <?php if($alpha == "z"){ ?> class="active" <?php }?>>z</a></li>
						<div class="clearfix"></div>
					</ul>
					
				</div>
				<div>
					<div class="pull-left padt10 prod-btn">
						   <div class="form-group">
							   <div class="col-sm-7 input_box pull-left">
								   <input type="text" class="form-control form-pad tags" id="keyword" name="keyword" placeholder="Product Name..." value="<?php echo $keyword; ?>">
								   <input type="hidden" name="alpha" id="alpha" value="<?php echo $alpha; ?>" />
							   </div>
							   <div class="pull-left">
									<button class="btn btn-lg btn-primary"><i class="strip search"></i></button>
									
							   <!-- </div> -->
							    <!-- <div class="col-sm-2 input_box pull-left"> -->
							   <a href="<?php echo site_url('shopping/products')?>" class="btn btn-lg btn-primary "><i class="strip refresh"></i></a>
							   </div>
							   <div class="clearfix"></div>
							</div>
					</div>
					
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			</form><div class="clearfix"></div>
     	<div class="beer_details">
     		<div class="mar_top20">
	     		<div class="br-bott-gray">
	     			
     				<div class="padtb10 pad_lr10">
     					<ul class="product-listing">
     						<?php if($result){
				  			foreach($result as $rs)
	  					{?>
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
     								<h1 class="prduct-title"><a href="<?php echo site_url('shopping/details/'.$rs->product_slug); ?>"> <?php if(strlen($rs->product_name) > 40){ echo ucfirst(substr($rs->product_name,0,40).'...'); } else { echo ucfirst($rs->product_name); }?> </a></h1>
     								<div class="mart10">
     									<div class="prod-price">
     										<p><?php echo  $rs->price!='' ? $site_setting->currency_symbol." ".number_format($rs->price,2):$site_setting->currency_symbol." ".$rs->price;?></p>
     									</div>
     									<div class="prod-price text-right">
     										<a href="<?php echo site_url('shopping/details/'.$rs->product_slug); ?>" class="btn btn-lg btn-primary btn-block ">Read More</a>
     									</div>
     									<div class="clearfix"></div>
	     								<!-- <p class="text-right"><a href="<?php echo site_url('shopping/details/'.$rs->product_slug); ?>" class="readmore">Read More</a></p> -->
     								</div>
     							</div>
     						</li>
     						<?php } } ?>
     						
     						<div class="clearfix"></div>
     					</ul>
     					
     					</div> 
     				</div>
     				
     				<div class="pagination mart20">
			  			<ul class="pagination">
							<?php echo $page_link; ?>
						</ul>
					</div>
	     		</div>
	     		<!-- <div class="clearfix"></div> -->
	     	</div>
     	</div>	
       </div>
	</div>

<!-- ########################################################################################### -->