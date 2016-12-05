<?php
$theme_url = $urls= base_url().getThemeName();
?>
<style>
	.related_beer_block {
    float: left;
    width: 222px;
}
</style>
<script type="text/javascript">
	function set_orderby(v)
	{
		//alert(v);
		$("#video-search").submit();
	}
	function limitsubmit(){	
		$('#video-search').submit();
	}
	
	  function add_click_banner(id)
		{
			
		  // window.location.href = '<?php echo current_url();?>'; 
		   $.ajax({
	       type: "POST",
		   url: "<?php echo site_url('home/add_clcik_banner')?>",
		   data : {id:id},
		   dataType : 'JSON',
		   success: function(response) {
		    
		     
		  }
	   });
	  }
</script>
<div class="wrapper row4">
   		<div class="container clearfix">
   			<div id="slider-fixed-banner" class="carousel slide">
        	<div class="carousel-inner">
          <div class="active item">
            	 <?php $v = 0;/* $getimagename = getimagenamebanner();?>	
          	  <?php 
									if($getimagename->find_article_state==1 && $getimagename->article!="" && is_file(base_path().'upload/bar_pages_banner_orig/'.$getimagename->article)){ ?>
										<img src="<?php echo base_url().'upload/bar_pages_banner/'.$getimagename->article; ?>"   />
									<?php
									} else {?>
            	<!-- <img src="<?php echo base_url(); ?>/default/images/smallbanner1.png" alt="American Dive Bars"/> -->
            	<?php } */ 
				   $getad_banner = '';
            	$getad_banner = getadvertisementBannerSearchBar('find_article'); 
				if($getad_banner){
					
						 ?>
							<?php 
	     				$count = getadvertisementBannerByIDCount(@$getad_banner['banner_pages_id'],$getad_banner['type']);
						if($getad_banner['type']=='click')
						{
							$cnt = $getad_banner['number_click'];
						}
						else
						{
							$cnt = $getad_banner['number_visit'];
						}
						
						$getad_new = getadvertisementByID_banner(@$getad_banner['banner_pages_id'],'visit');
		
						if(($getad_new==0 || $getad_new<5) && $count<$cnt && $getad_banner['type']=='visit' && $getad_banner['type']!='')
						{
							$array = array('ip'=>$_SERVER['REMOTE_ADDR'],'datetime'=>date('Y-m-d H:i:s'),'banner_pages_id'=>$getad_banner['banner_pages_id'],'click_type'=>'visit');
							$this->db->insert('count_clcik_advertisement_banner',$array);
							
							$array1 = array('total_visit'=>$getad_banner['total_visit']+1);
							$this->db->where('banner_pages_id',$getad_banner['banner_pages_id']);
							$this->db->update('banner_pages_master',$array1);
						}
						
						$v= 1;
	     				if($getad_banner && $count<$cnt){ ?>
	     					<?php if(($getad_banner['banner_pages_image']!='' && file_exists(base_path().'upload/banner_pages_thumb/'.$getad_banner['banner_pages_image']))){ ?>
	     						<a target="_blank" <?php if($getad_banner['type']=='click'){?>onclick="add_click_banner('<?php echo $getad_banner['banner_pages_id'];?>');"<?php } ?> href="<?php echo $getad_banner['url']; ?>"><img src="<?php echo base_url().'upload/banner_pages_thumb/'.$getad_banner['banner_pages_image']; ?>" class="img-responsive"/></a>
	     					<?php } ?>	
	     					<?php } else { ?>
		     		 <img src="<?php echo base_url().'upload/banner_pages_thumb/'.$getad_banner['banner_pages_image']; ?>" class="img-responsive"/>
		     			
		     			  <?php } }  else { 
		     			  	$v= 0;?>
		     			  <!-- <img src="<?php echo base_url(); ?>/default/images/smallbanner1.png" alt="American Dive Bars"/> -->
		     			  	<?php } ?>
							
						
				<div class="clearfix"></div>
          </div>
        </div>
   	</div>
	</div>
  </div> 

<div class="wrapper row5 forum-listing" style="border:<?php echo $v==0 ? 'none':'';?>">
     	<div class="container">
     		<form method="post" id="video-search" name="video-search" action="<?php echo site_url("article/listarticle"); ?>">
     		<div class="result_search">
     			<div class="col-sm-8">
	     			<div class="result_search_text">Articles</div>
	            </div>
     			<div class="col-sm-4 text-right">
     				
	                   <div class="form-group">
	                   		<label for="inputEmail3" class="control-label">Results Per Page :</label>
	                   		 <select class="select_box" name="limit" id="limit" onchange="limitsubmit();">
									<option value="10"<?php if($limit==10){ ?> selected="selected"<?php } ?>>10</option>
									<option value="20"<?php if($limit==20){ ?> selected="selected"<?php } ?>>20</option>
									<option value="30"<?php if($limit==30){ ?> selected="selected"<?php } ?>>30</option>
									<option value="40"<?php if($limit==40){ ?> selected="selected"<?php } ?>>40</option>
									<option value="50"<?php if($limit==50){ ?> selected="selected"<?php } ?>>50</option>
										<option value="100" <?php if($limit == "100"){?> selected= "selected" <?php } ?>>100</option> 
								 </select>
	                   </div><div class="clearfix"></div>
	                   
	                   
	              </div>
	              <div class="clearfix"></div>
     		</div>
     		
     		<div class="pull-left padt10">
						   <div class="form-group">
							   <div class="input_box pull-left marr_10" style="padding-left: 0px;">
								   <input type="text" class="form-control form-pad tags" id="keyword" name="keyword" placeholder="Beer Name Here" value="<?php echo $keyword; ?>">
							   </div>
							   <div class="input_box pull-left">
									<button class="btn btn-lg btn-primary"><i class="strip search"></i></button>
							   </div>
							   <div class="clearfix"></div>
							</div>
					</div>
     		</form><div class="clearfix"></div>
     		<div class="mar_top20">
	     		<div class="left_block">
	     			<!-- <h1 class="yellow_title padb25">Forum Category : Test Category</h1> -->
	     			<div class="blog-mainblock">
	     				<ul>
	     					<?php
	  		if($result)
	  		{
	  			foreach($result as $rs)
	  			{?>
	     					<li>
				     			<div class="blog-block">
		     						<h1 class="yellow_title"> <a class="beer_title" href="<?php echo site_url("article/detail/".base64_encode($rs->blog_id));?>"> <?php echo strlen($rs->blog_title)>40 ?  substr($rs->blog_title,0,40)."...":ucwords($rs->blog_title); ?> </a>
		     							<ul class="social_icon pull-right"><span style="float: left; margin-top: 7px; ; color: #fff; font-size: 14px;">Share :</span>
									<?php
									$u = base_url().'article/detail/'.base64_encode($rs->blog_id);
									$url_share = site_url("upload/blog_orig/".base64_encode($rs->blog_image));
									$url=urlencode($url_share);
									$image=urlencode(base_url().'upload/blog_orig/no_image.png');
									if($rs->blog_image != "" && is_file(base_path()."upload/blog_orig/".$rs->blog_image))
									{
										$image=urlencode(base_url().'upload/blog_orig/'.$rs->blog_image); 
									}
									
									$content = preg_replace("/<img[^>]+\>/i", " ", $rs->blog_description); 
	  							$content = preg_replace("/<p[^>]+\>/i", " ", $rs->blog_description); ?> 					
										<li><a onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo mysql_real_escape_string(addslashes($rs->blog_title));?>&amp;p[summary]=<?php echo mysql_real_escape_string(strip_tags(substr($content,0,200)));?>&amp;p[url]=<?php echo $u; ?>&amp;p[images][0]=<?php echo $image;?>','sharer','toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)"><img src="<?php echo base_url();?>default/images/result_fb.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_fb-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_fb.png'"/></a></li>
			  							<li><a href="javascript:void(0)" onclick="window.open('http://twitter.com/home?status=<?php echo $u;?>','sharer','toolbar=0,status=0,width=548,height=325')"><img src="<?php echo base_url();?>default/images/result_twitt.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_twitt-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_twitt.png'"/></a></li>
	  									<li><a href="javascript:void(0)" onclick="window.open('https://plusone.google.com/_/+1/confirm?hl=en&url=<?php echo $u;?>','sharer','toolbar=0,status=0,width=548,height=325')"><img src="<?php echo base_url();?>default/images/result_google.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_google-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_google.png'" /></a></li>
	  									<li><a  href="javascript://" onclick="piShare('<?php echo $image;?>','<?php echo $rs->blog_id;?>')"><img src="<?php echo base_url().'default'?>/images/result_p.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_p-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_p.png'"></a></li>
		    		 				</ul>
		     						</h1>
		     						<div class="bloguser-strip">
		     							<ul class="usericon-list">
		     								<li><i class="glyphicon glyphicon-time"></i><?php echo date($site_setting->date_format,strtotime($rs->date_added)); ?></li>
		     								<li><a href="#"><i class="glyphicon glyphicon-tags"></i><?php if($rs->user_id>0){ echo $rs->first_name." ".$rs->last_name;}else { echo "ADB"; } ?></a></li>
		     								<li><a href="#"><i class="glyphicon glyphicon-comment"></i><?php echo count_blog_comment($rs->blog_id); ?> Comments</a></li>
		     								<li><?php  echo get_blog_rating($rs->blog_id);?></li>
		     								
		     								<div class="clearfix"></div>
		     							</ul>
		     						</div>
		     						<div>
		     							 <?php 
										if($rs->blog_image!="" && is_file(base_path().'upload/blog_thumb/'.$rs->blog_image)){ ?>
											<img src="<?php echo base_url().'upload/blog_thumb/'.$rs->blog_image; ?>" class="img-responsive" />
										<?php
										}
										else{?>
										<img class="img-responsive"  src="<?php echo $theme_url.'/images/smallbanner1.png'; ?>" />
								<?php } ?>
		     						</div>
		     						<div class="result_desc mart10">
						       			<p><?php 
	  						
	  						echo  strip_tags(substr($content,0,200));
							 ?></p>
						       			<div class="text-right">
						       				<a href="<?php echo site_url("article/detail/".base64_encode($rs->blog_id));?>" class="blog-readmore">Read More</a>
						       			</div>
						       		</div>
		     					</div>
		     					<div class="clearfix"></div>
	     					</li>
	     					
	     				<?php } } else { ?>
	     					 <li>No Records Found.</li>
	     					<?php } ?>	
	     				</ul>
	     			</div>
		     		
		     		<div class="pagination">
		     			<ul class="pagination">
		     				<?php 
	  				echo $page_link;
	  				?>
		     			</ul>
		     		</div>
		     		<div class="clearfix"></div>
	     		</div>
	     		<div class="right_block_releated">
	     			
	     			<div class="text-left ">
	     				<h1 class="productbar_title">Recent</h1>
	     				<div class="clearfix"></div>
	     				<ul class="review_block">
	     					<?php
	  		if($recent_blog)
	  		{
	  			foreach($recent_blog as $rs)
	  			{?>
		     				<li>
		     					<div class="pull-left marr_10">
		     						
		            			
		            			<?php 
										if($rs->blog_image!="" && is_file(base_path().'upload/blog_thumb_50by50/'.$rs->blog_image)){ ?>
											<img style="width: 75px; height: 75px;"  src="<?php echo base_url().'upload/blog_thumb_50by50/'.$rs->blog_image; ?>" class="img-responsive" />
										<?php
										}
										else{?>
										<img style="width: 75px; height: 75px;" class="img-responsive" src="<?php echo base_url()?>/upload/no-image.png" alt="American Dive Bars"/>
								<?php } ?>
		     					</div>
		     					<div class="related_beer_block">
			     					<div><a class="bar_title" href="<?php echo site_url("article/detail/".base64_encode($rs->blog_id));?>"> <?php echo $rs->blog_title; ?> </a></div>
			     					<p class="result_desc"><?php 
	  							$content = preg_replace("/<p[^>]+\>/i", " ", $rs->blog_description); 
	  								echo  strip_tags(substr($content,0,50))."...";
							 ?></p>
			     					<div class="clearfix"></div>
		     					</div>
		     					<div class="clearfix"></div>
		     				</li><div class="clearfix"></div>
		     				<?php } } ?>
		     			
		     				
		     			</ul>
	     			</div>
	     		</div>
	     		<div class="clearfix"></div>
     		</div>
     		
   		</div>
   	</div>
  
	<script>
  	
function piShare(img,slug)
{
	var width  = 600,
        height = 500,
         left   = ($(window).width()  - width)  / 2,
         top    = ($(window).height() - height) / 2,
        url    = 'http://www.pinterest.com/pin/create/button/?url=<?php echo site_url('article/detail/'); ?>/'+btoa(slug)+'&media='+img+'&description=<?php //echo $bar_detail['bar_desc']; ?>',
        opts   = 'status=1' +
                 ',width='  + width  +
                 ',height=' + height +
                 ',top='    + top    +
                 ',left='   + left;
    
    window.open(url, 'Pinterest', opts);
 
    return false;
}
</script>