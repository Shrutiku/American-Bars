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
<div class="wrapper row3 padtb20">
	<form method="post" id="video-search" name="video-search" action="<?php echo site_url("forum/forums"); ?>">
  <div id="container" class="clear">
  	<div class="row">
  		<h1 class="maintitle">Forums</h1>
  		<div class="form-control-group">
  			<div class="fl_left">
	  			<label class="fl_left search_label mart7 marr10">Search By :</label>
	  			<select name="type" id="type" class="select wrap small br_silver fl_left marr10">
	  				<option value="">-- Select --</option>
	  				<option value="author" <?php if($type == "author"){?> selected = "selected" <?php }?> >Author</option>
	  				<option value="forum_title" <?php if($type == "forum_title"){?> selected = "selected" <?php }?>>Forum Title</option>
	  			</select>
	  			<input type="text" name="keyword" class="input wrap small br_silver fl_left marr10" value="<?php echo $keyword; ?>" placeholder="Keyword"/>
	  			<button type="submit" id="froum_search" name="froum_search" class="button fl_left">Search</button>
	  			<div class="clear"></div>
  			</div>
  			<div class="fl_right">
	  			<label class="fl_left search_label mart7 marr10">Sort By :</label>
	  			<select name="order_by" class="select wrap small br_silver fl_left marr10" onchange="set_orderby(this.value);">
	  				<option>-- Select --</option>
	  				<option value="first_name#ASC" <?php if($order_by == "first_name#ASC") {?> selected = "selected" <?php }?>> Author ↓ </option>
	  				<option value="first_name#DESC" <?php if($order_by == "first_name#DESC") {?> selected = "selected" <?php }?>> Author ↑ </option>
	  				<option value="topic_name#ASC" <?php if($order_by == "topic_name#ASC") {?> selected = "selected" <?php }?>>Forum Title ↓</option>
	  				<option value="topic_name#DESC" <?php if($order_by == "topic_name#DESC") {?> selected = "selected" <?php }?>>Forum Title ↑</option>
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
	  				<!--<img src="images/coach.png" class="post_img"/>-->
	  			</div>
	  			<div class="fl_left wid500">
	  				<div class="fl_left">
		  						<ul class="videodata">
		  							<li><i class="strip date"></i> <label class="light_gray"><?php echo date($site_setting->date_format,strtotime($rs->date_created)); ?></label></li>
		  							<li><i class="strip user"></i> <label class="light_gray"><?php if($rs->user_id>0){ echo $rs->first_name." ".$rs->last_name;}else { echo "administrator"; } ?></label></li>
		  							<li><i class="strip comment"></i> <label class="light_gray"><label class="red"><?php echo count_forum_comment($rs->forum_id); ?> comments</label></li>
		  							<div class="clear"></div>
		  						</ul>
		  				</div>
		  				<div class="clear"></div>
	  					<div class="fl_right">
	  						<a href="#"><i class="strip fb"></i></a>
	  						<a href="#"><i class="strip twitter"></i></a>
	  						<a href="#"><i class="strip google1"></i></a>	  						
	  					</div>
	  				<div class="video_label"> <a href="<?php echo site_url("forum/detail/".base64_encode($rs->forum_id));?>"> <?php echo $rs->topic_name; ?> </a> </div>
		  				
		  			<div class="small_label lightblack"><?php 
	  						$content = preg_replace("/<img[^>]+\>/i", " ", $rs->forum_decription); 
	  							$content = preg_replace("/<p[^>]+\>/i", " ", $rs->forum_decription); 
	  						echo  strip_tags(substr($content,0,200));
							 ?> </div>
	  				<div class="clear"></div>
	  				<div class="mart15">
		  				
	  					<div class="fl_right">
	  					<a href="<?php echo site_url("forum/detail/".base64_encode($rs->forum_id));?>" class="buttonread">Read More</a>
	  					</div>
	  					<div class="clear"></div>
	  			 	</div>
	  				
	  				<div class="mart15">
	  					<div class="clear"></div>
	  				</div>
	  			</div>
	  			<div class="clear"></div>
	  		</div>
	  		<?php 
	  			}
	  				}
	  		?>
	  		<!--<div class="video_block mart20">
	  			<div class="fl_left marr10">
	  				<img src="images/coach.png" class="post_img"/>
	  			</div>
	  			<div class="fl_left wid500">
	  				<div class="video_label">Lorem Ipsum is simply dummy</div>
		  			<div class="small_label lightblack">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.Lorem ipsum dolor sit amet, consectetuer  Lorem ipsum dolor sit amet, consectetuer </div>
	  				<div class="clear"></div>
	  				<div class="mart15">
		  				<div class="fl_left">
		  						<ul class="videodata">
		  							<li><i class="strip date"></i> <label class="light_gray">02-03-2014</label></li>
		  							<li><i class="strip user"></i> <label class="light_gray">Lorem Ipsum</label></li>
		  							<li><i class="strip comment"></i> <label class="light_gray">5 comments</label></li>
		  							<div class="clear"></div>
		  						</ul>
		  				</div>
	  					<div class="fl_right">
	  					<a href="#" class="buttonread">Read More</a>
	  					</div>
	  					<div class="clear"></div>
	  			 	</div>
	  				
	  				<div class="mart15">
	  					
	  					<div class="fl_right">
	  						<a href="#"><i class="strip fb"></i></a>
	  						<a href="#"><i class="strip twitter"></i></a>
	  						<a href="#"><i class="strip google1"></i></a>	  						
	  					</div>
	  					<div class="clear"></div>
	  				</div>
	  			</div>
	  			<div class="clear"></div>
	  		</div>-->
	  		
	  		<div class="pagination mart20">
	  			<ul class="pagination">
	  				<?php 
	  				echo $page_link;
	  				?>
	  				<div class="clear"></div>
	  			</ul>
	  		</div>
  			
  		</div>
  		
  		<div class="right_block mart20">
  			<!--<ul class="forum_side">
  				<li class="title">Category</li>
  				<li><a href="#"><i class="strip ul_arrow"></i>Lorem Ipsum</a></li>
  				<li><a href="#"><i class="strip ul_arrow"></i>Lorem Ipsum</a></li>
  				<li><a href="#"><i class="strip ul_arrow"></i>Lorem Ipsum</a></li>
  				<li><a href="#"><i class="strip ul_arrow"></i>Lorem Ipsum</a></li>
  				<li><a href="#"><i class="strip ul_arrow"></i>Lorem Ipsum</a></li>
  			</ul>-->
  			
  			<div>
	  			<h2 class="smalltitle mart20">Latest Post</h2>
	  			<ul class="comments">
			  		<li>
			  			<div class="fl_left marr10">
			  				<a href="#"><img src="images/post_img.png" class="post_img"/></a>
			  			</div>
			  			<div class="post_desc_block">
				  			<a href="#" class="post_label">lorem ipsum</a>
				  			<p class="post_desc">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</p>
			  			</div>
			  			<div class="clear"></div>
			  		</li>
			  		<li>
			  			<div class="fl_left marr10">
			  				<a href="#"><img src="images/post_img.png" class="post_img"/></a>
			  			</div>
			  			<div class="post_desc_block">
				  			<a href="#" class="post_label">lorem ipsum</a>
				  			<p class="post_desc">Lorem Ipsum is simply dummy text of the printing .</p>
			  			</div>
			  			<div class="clear"></div>
			  		</li>
			  		<li>
			  			<div class="fl_left marr10">
			  				<a href="#"><img src="images/post_img.png" class="post_img"/></a>
			  			</div>
			  			<div class="post_desc_block">
				  			<a href="#" class="post_label">lorem ipsum</a>
				  			<p class="post_desc">Lorem Ipsum is simply dummy text of the printing .</p>
			  			</div>
			  			<div class="clear"></div>
			  		</li>
			  		<li>
			  			<div class="fl_left marr10">
			  				<a href="#"><img src="images/post_img.png" class="post_img"/></a>
			  			</div>
			  			<div class="post_desc_block">
				  			<a href="#" class="post_label">lorem ipsum</a>
				  			<p class="post_desc">Lorem Ipsum is simply dummy text of the printing .</p>
			  			</div>
			  			<div class="clear"></div>
			  		</li>
			  	</ul>
		  	</div>
		  	<!--<div class="mart20">
			  	<ul class="forum_side">
	  				<li class="title">Archives</li>
	  				<li><a href="#"><i class="strip ul_arrow"></i>May 2014</a></li>
	  				<li><a href="#"><i class="strip ul_arrow"></i>April 2014</a></li>
	  				<li><a href="#"><i class="strip ul_arrow"></i>March 2014</a></li>
	  				<li><a href="#"><i class="strip ul_arrow"></i>January 2014</a></li>
	  				<li><a href="#"><i class="strip ul_arrow"></i>January 2014</a></li>
	  				
	  			</ul>
  			</div>-->
  			
  			<!-- <h2 class="smalltitle">Advertisement</h2> -->
  			<!-- <div class="mart7"><img src="images/adv1.png"/></div> -->
  		</div>
  		<div class="clear"></div>
  	</div>

  </div>
</div>
