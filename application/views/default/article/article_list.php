<?php
$theme_url = $urls= base_url().getThemeName();
?>
<script type="text/javascript">
	function set_orderby(v)
	{
		//alert(v);
		$("#video-search").submit();
	}
</script>

<!-- ########################################################################################### -->
<!-- content -->
<div class="wrapper row3 padtb20">
  <div id="container" class="clear">
  	<div class="row">
  		<h1 class="maintitle">Poker Article</h1>
  		<form method="post" id="video-search" name="video-search" action="<?php echo site_url("article/articles"); ?>">
  		<div class="form-control-group">
  			<div class="fl_left">
	  			<label class="fl_left search_label mart7 marr10">Search By :</label>
	  			<select class="select wrap small br_silver fl_left marr10" name="type" id="type">
	  				<option value="">-- Select --</option>
	  				<option value="author" <?php if($type == "author"){?> selected = "selected" <?php }?> >Author</option>
	  				<option value="article_title" <?php if($type == "article_title"){?> selected = "selected" <?php }?>>Article</option>
	  				<option value="category" <?php if($type == "category"){?> selected = "selected" <?php }?>>Category</option>
	  			</select>
	  			<input type="text" class="input wrap small br_silver fl_left marr10" placeholder="keyword" name="keyword" id="keyword" value="<?php echo $keyword; ?>"/>
	  			<button type="submit" class="button fl_left mar2" id="video-search">Search</button>
	  			<button type="button" class="button fl_left" id="video-search" onclick="document.location.href = '<?php echo site_url("article"); ?>'">Refresh</button>
	  			<div class="clear"></div>
  			</div>
  			<div class="fl_right">
	  			<label class="fl_left search_label mart7 marr10">Sort By :</label>
	  					<select class="select wrap small br_silver fl_left marr10" id="order_by" name="order_by" onchange="set_orderby(this.value);">
	  			<option value="">-- Select --</option>
	  				<option value="first_name#ASC" <?php if($order_by == "first_name#ASC") {?> selected = "selected" <?php }?>> Author ↓ </option>
	  				<option value="first_name#DESC" <?php if($order_by == "first_name#DESC") {?> selected = "selected" <?php }?>> Author ↑ </option>
	  				<option value="article_title#ASC" <?php if($order_by == "article_title#ASC") {?> selected = "selected" <?php }?>>Article Title ↓</option>
	  				<option value="article_title#DESC" <?php if($order_by == "article_title#DESC") {?> selected = "selected" <?php }?>>Article Title ↑</option>
	  				<option value="category_name#ASC" <?php if($order_by == "category_name#ASC") {?> selected = "selected" <?php }?>>Category ↓</option>
	  				<option value="category_name#DESC" <?php if($order_by == "category_name#DESC") {?> selected = "selected" <?php }?>>Category ↑</option>
	  			</select>
	  			<div class="clear"></div>
  			</div>
  			<div class="clear"></div>
  		</div>
  	</div>
  	<div class="row">
  		<div class="left_block">
  			<div class="pagination">
	  			<ul class="pagination">
	  				<?php 
	  				echo $page_link;
	  				?>
	  				<div class="clear"></div>
	  			</ul>
	  		</div>
	  		
	  		<?php
	  		if($result)
	  		{
	  			foreach($result as $rs)
	  			{?>
	  		<div class="video_block mart20">
	  			<div class="fl_left marr10">
	  				<div class="video_img">
	  					<a class="point" href="<?php echo site_url("article/detail/".base64_encode($rs->article_id));?>">
	  					<?php 
	  					if($rs->article_image != "" && is_file(base_path()."upload/article_image/".$rs->article_image))
						{
	  					?>
	  					<img src="<?php echo base_url().'upload/article_image/'.$rs->article_image; ?>"  width="300px" height= "200px;" />
	  					
	  					<?php 
						}else
							{?>
								<img src="<?php echo base_url().'upload/no_img.png'; ?>"  width="300px" height= "200px;" />		
							<?php }
						
						?>
	  					
	  					</a>
       					<?php
       					if($rs->article_type == "free")
						{
       					?>
       					<div class="ribbon-wrapper-red"><div class="ribbon-red">Free</div></div>
       					
       					<?php }?>
       					
       					<?php
       					if($rs->article_type != "free")
						{
       					?>
       					<div class="price_block"><?php echo $site_setting->currency_symbol.$rs->article_price; ?></div>
       					<?php }?>
					</div>
	  			</div>
	  			<div class="fl_left wid365">
	  				<div>
	  				<a class="point" href="<?php echo site_url("article/detail/".base64_encode($rs->article_id));?>"><h3 class="video_label"><?php echo $rs->article_title; ?></h3></a>
		  				<ul class="videodata">
	  							<li>Date: <label class="red"><?php echo date($site_setting->date_format,strtotime($rs->date_created)); ?></label></li>
	  							<li>By : <label class="red"><?php if($rs->user_id>0){ echo $rs->first_name." ".$rs->last_name;}else { echo "AB"; } ?></label></li>
	  							<li>Category : <label class="red"><?php echo $rs->category_name; ?></label></li>
	  							<div class="clear"></div>
	  						</ul>
	  				</div>
	  				<div class="mart7">
		  				<ul class="videodata">
		  							<li>View: <label class="red"><?php echo $rs->total_views; ?></label></li>
		  							<li>Comments : <label class="red"><?php echo count_article_comment($rs->article_id); ?></label></li>
		  							<div class="clear"></div>
	  							</ul>

	  				</div>
	  				<div class="h90">
	  					<p class="small_label lightblack">
	  						<?php 
	  						$content = preg_replace("/<img[^>]+\>/i", " ", $rs->article_desc); 
	  							$content = preg_replace("/<p[^>]+\>/i", " ", $rs->article_desc); 
	  						echo  strip_tags(substr($content,0,200));
							 ?>
	  					</p>
	  				</div>
	  				<div>
	  					<div class="fl_left">
	  						<label class="rating_label fl_left">Ratings :</label>
	  						<?php echo get_article_rating($rs->article_id); ?>
	  					</div>
	  					<div class="fl_right">
	  							<?php $url_share = base_url()."article/detail/".base64_encode($rs->article_id);  ?>
	  						<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url_share;?>" target= "_blank"><i class="strip fb"></i></a>
	  						<a href="http://twitter.com/home?status=<?php echo $url_share;?>" target= "_blank"><i class="strip twitter"></i></a>
	  						<a href="#"><i class="strip google1"></i></a>
	  					</div>
	  				</div>
	  			</div>
	  			<div class="clear"></div>
	  		</div>
	  	<?php 
	       	  }
	  		}
	  		
	  	?>
	  		<div class="pagination mart20">
	  			<ul class="pagination">
	  				<?php 
	  				echo $page_link;
	  				?>
	  				<div class="clear"></div>
	  			</ul>
	  		</div>
  			
  		</div>
  		<div class="right_block">
  			<h2 class="smalltitle">Advertisement</h2>
  			<div class="mart7"><img src="<?php  echo $theme_url ;?>/images/adv1.png"/></div>
  		</div>
  		<div class="clear"></div>
  	</div>

  </div>
  
</div>
<!-- ########################################################################################### -->
