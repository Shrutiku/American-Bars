<!-- ########################################################################################### -->
<?php
$theme_url = $urls= base_url().getThemeName();
?>
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>jwplayer/jwplayer.js"></script> -->
<script type="text/javascript">
	function set_orderby(v)
	{
		//alert(v);
		$("#video-search").submit();
	}
</script>

<!-- content -->
<div class="wrapper row3 padtb20">
  <div id="container" class="clear">
  	<div class="row">
  		<h1 class="maintitle">Poker Video</h1>
  		<form method="post" id="video-search" name="video-search" action="<?php echo site_url("video/videoes"); ?>">
  		<div class="form-control-group">
  			<div class="fl_left">
	  			<label class="fl_left search_label mart7 marr10">Search By :</label>
	  			<select class="select wrap small br_silver fl_left marr10" name="type" id="type">
	  				<option value="">-- Select --</option>
	  				<option value="author" <?php if($type == "author"){?> selected = "selected" <?php }?> >Author</option>
	  				<option value="video_title" <?php if($type == "video_title"){?> selected = "selected" <?php }?>>Video_title</option>
	  				<option value="category" <?php if($type == "category"){?> selected = "selected" <?php }?>>Category</option>
	  			</select>
	  			<input type="text" class="input wrap small br_silver fl_left marr10" placeholder="keyword" name="keyword" id="keyword" value="<?php echo $keyword; ?>"/>
	  			<button type="submit" class="button fl_left mar2" id="video-search">Search</button>
	  			<button type="button" class="button fl_left" id="video-search" onclick="document.location.href = '<?php echo site_url("video"); ?>'">Refresh</button>
	  			
	  			<div class="clear"></div>
  			</div>
  			<div class="fl_right">
	  			<label class="fl_left search_label mart7 marr10">Sort By :</label>
	  			<select class="select wrap small br_silver fl_left marr10" id="order_by" name="order_by" onchange="set_orderby(this.value);">
	  				<option value="">-- Select --</option>
	  				<option value="first_name#ASC" <?php if($order_by == "first_name#ASC") {?> selected = "selected" <?php }?>> Author ↓ </option>
	  				<option value="first_name#DESC" <?php if($order_by == "first_name#DESC") {?> selected = "selected" <?php }?>> Author ↑ </option>
	  				<option value="video_title#ASC" <?php if($order_by == "video_title#ASC") {?> selected = "selected" <?php }?>>Video Title ↓</option>
	  				<option value="video_title#DESC" <?php if($order_by == "video_title#DESC") {?> selected = "selected" <?php }?>>Video Title ↑</option>
	  				<option value="category_name#ASC" <?php if($order_by == "category_name#ASC") {?> selected = "selected" <?php }?>>Category ↓</option>
	  				<option value="category_name#DESC" <?php if($order_by == "category_name#DESC") {?> selected = "selected" <?php }?>>Category ↑</option>
	  				
	  			</select>
	  			<div class="clear"></div>
  			</div>
  			<div class="clear"></div>
  		</div>
  		</form>
  	</div>
  	<div class="row">
  		<div class="left_block">
  			<div class="pagination">
	  			<ul class="pagination">
	  				<!-- <li class="first"> < </li>
	  				<li class="active"> 1 </li>
	  				<li> 2 </li>
	  				<li> 3 </li>
	  				<label class="fl_left marlr10"> ... </label>
	  				<li> 8 </li>
	  				<li class="last"> > </li> -->
	  				
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
	  			<div class="fl_left ">
	  				<div class="video_img">
	  				<a class="point" href="<?php echo site_url("video/video_detail/".base64_encode($rs->video_id));?>">
	  					<img src="<?php echo base_url().'upload/video_image/'.$rs->video_image; ?>"  width="300px" height= "200px;" />
	  					
	  					</a>
       					
       					<?php
       					if($rs->video_type == "free")
						{
       					?>
       					<div class="ribbon-wrapper-red"><div class="ribbon-red">Free</div></div>
       					
       					<?php }?>
       					
       					<?php
       					if($rs->video_type != "free")
						{
       					?>
       					<div class="price_block"><?php echo $site_setting->currency_symbol.$rs->video_price; ?></div>
       					
       					<?php }?>
       					
       					<i class="strip play_video"></i>
					</div>
	  			</div>
	  			<div class="fl_right wid410">
	  				<div>
	  					<a class="point" href="<?php echo site_url("video/video_detail/".base64_encode($rs->video_id));?>"><h3 class="video_label"><?php echo $rs->video_title; ?></h3></a>
		  				<ul class="videodata">
	  							<li>Date: <label class="red"><?php echo date($site_setting->date_format,strtotime($rs->date_created)); ?></label></li>
	  							<li>By : <label class="red"><?php if($rs->user_id>0){ echo $rs->first_name." ".$rs->last_name;}else { echo "administrator"; } ?></label></li>
	  							<li>Category : <label class="red"><?php echo $rs->category_name; ?></label></li>
	  							<div class="clear"></div>
	  						</ul>
	  				</div>
	  				<div class="mart7">
		  				<ul class="videodata">
		  							<li>View: <label class="red"><?php echo $rs->total_views; ?></label></li>
		  							<li>Comments : <label class="red"><?php echo count_video_comment($rs->video_id); ?></label></li>
		  							<div class="clear"></div>
	  							</ul>

	  				</div>
	  				<div class="h90">
	  					<div class="small_label lightblack">
	  						<?php echo substr($rs->video_desc,0,80); ?>
	  					</div>
	  				</div>
	  				<div>
	  					<div class="fl_left">
	  						<label class="rating_label fl_left">Ratings :</label>
	  						<?php echo get_video_rating($rs->video_id); ?>
	  					</div>
	  					<?php $url_share = base_url()."video/video_detail/".base64_encode($rs->video_id);  ?>
	  					<div class="fl_right">
	  					
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
	  				<!-- <li class="first"> < </li>
	  				<li class="active"> 1 </li>
	  				<li> 2 </li>
	  				<li> 3 </li>
	  				<label class="fl_left marlr10"> ... </label>
	  				<li> 8 </li>
	  				<li class="last"> > </li> -->
	  					<?php 
	  				echo $page_link;
	  				?>
	  				<div class="clear"></div>
	  			</ul>
	  		</div>
  			
  		</div>
  		<div class="right_block">
  			<h2 class="smalltitle">Advertisement</h2>
  			<div class="mart7"><img src="<?php echo $theme_url ;?>/images/adv1.png"/></div>
  		</div>
  		<div class="clear"></div>
  	</div>

  </div>
</div>
<!-- ########################################################################################### -->