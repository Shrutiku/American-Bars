<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery_form.js"></script>
<div class="modal fade login_pop2" id="suggestmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
					   <?php echo $this->load->view(getThemeName().'/forum/forum_suggest');?>
</div>

<div class="wrapper row4">
   		<div class="container clearfix">
   			<div class="carousel slide" id="slider-fixed-banner">
        	<div class="carousel-inner">
          	<div class="active item">
            	 <?php /* $getimagename = getimagenamebanner();?>	
          	  <?php 
									if($getimagename->forum!="" && is_file(base_path().'upload/bar_pages_banner_orig/'.$getimagename->forum)){ ?>
										<img src="<?php echo base_url().'upload/bar_pages_banner/'.$getimagename->forum; ?>"   />
									<?php
									} else {?>
            	<img src="<?php echo base_url(); ?>/default/images/smallbanner1.png" alt="American Bars"/>
            	<?php } */ 
            			$v=0;
          $getad_banner = '';
            	$getad_banner = getadvertisementBannerSearchBar('find_forum'); 
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
        <!-- <a class="left carousel-control" href="#slider-fixed-banner" data-slide="prev">&lsaquo;</a>
        <a class="right carousel-control" href="#slider-fixed-banner" data-slide="next">&rsaquo;</a> -->
        <!-- <div class="submit_bar"><a href="#" class="btn btn-lg btn-primary">Submit Your Bar</i></a></div> -->
        
   	</div>
	</div>
  </div>
  <div class="wrapper row5 forum-listing">
     	<div class="container">
     		<div class="result_search">
     			<div class="col-sm-8">
	     			<div class="result_search_text pull-left">Forum Listing</div>
	            </div>
	            <div class="col-sm">
     				<!-- <form class="form-horizontal" id="bar-search-frm" method="post" role="form" action="<?php echo site_url("bar/lists"); ?>"> -->
	                   <div class="form-group pull-right">
	                   	<!-- <a class="review text-center" data-toggle="modal" href="#helpfindbar">Help Us Find Bars!</a> -->
	                    </div>      
	                <!-- </form> -->
	              </div>
	            <div class="clearfix"></div>
     		</div>
     		<div>
     			<div class="forum-searchblock">
     				<form method="post" id="video-search" name="video-search" action="<?php echo site_url("forum/forums"); ?>">
     					<div class="form-group pull-left">
     						<select name="type" id="type"  class="form-control">
     							<option value=""> -- Category --</option>
     							<?php if($category){
     								   foreach($category as $cat){?>
     							
     							<option value="<?php echo $cat->forum_category_id;?>" <?php if($type==$cat->forum_category_id){ echo "selected"; }?>><?php echo $cat->forum_category_name;?></option> 
     							<?php } } ?>
     						</select>
     					</div>
     					<div class="form-group pull-left">
     						<input type="text" name="keyword" class="form-control" value="<?php echo $keyword; ?>" placeholder="Keyword"/>
     					</div>
     					<button class="btn btn-lg btn-primary" name="" type="submit"><i class="strip search"></i></button>
     					<!-- <div class="input_box pull-left "> -->
				                        		<a type="submit" class="btn btn-lg btn-primary search" href="<?php echo site_url('forum')?>"><i class="strip refresh"></i>
				                       	   </a>
				        <!-- </div> -->
				         <div class="clearfix"></div>
     				</form>
     			</div>
     		</div>
     		<div class="mar_top20">
	     		<div class="left_block">
	     			<!-- <h1 class="yellow_title padb25">Forum Category : Test Category</h1> -->
		     		<div class="result_box clearfix">
		     			<ul class="result_sub_box">
		     				<?php
	  		if($result)
	  		{
	  			foreach($result as $rs)
	  			{
	  				?>
			         		<li >
			         			<div class="media">
								    <a href="<?php echo site_url("forum/detail/".base64_encode($rs->forum_id));?>" class="pull-left widheig120">
								      	<?php
				if($rs->user_id>0){
								      	
		          		if($rs->profile_image!="" && file_exists(base_path().'upload/user_thumb/'.$rs->profile_image))
					{
						?>
		            	    <img class="img-responsive" src="<?php echo base_url()?>/upload/user_thumb/<?php echo $rs->profile_image; ?>" alt="American Bars"/>
		            	<?php } else {
		            		?>
		            		<img class="img-responsive" src="<?php echo base_url()?>/upload/no-image.png" alt="American Bars"/>	
		            			<?php } } else {
		            		?>
		            		<img class="img-responsive" src="<?php echo base_url()?>/upload/no-image.png" alt="American Bars"/>	
		            			<?php } ?>
								    </a>
								    <div class="media-body">
								       <div class="reult_sub_title"><h4 class="media-heading"><a class="bar_title" href="<?php echo site_url("forum/detail/".base64_encode($rs->forum_id));?>"><?php echo ucwords($rs->topic_name); ?></a></h4></div>
								       <div class="rating_box"><?php echo date($site_setting->date_format,strtotime($rs->date_created)); ?></div>
								       <div class="clearfix"></div>
								       <ul class="beerdirectory">
								        <li>Posted By : <?php if($rs->user_id>0){ echo $rs->first_name." ".$rs->last_name;}else { echo "AB"; } ?></li>
								        <li>Total Views : <?php echo $rs->view; ?></li>
								        <li>Total Comments : <?php echo count_forum_comment($rs->forum_id); ?></li>
								       </ul>
								       <div class="result_desc mart10"><?php 
								       if(strlen($rs->forum_decription>0)){
	  						$content = preg_replace("/<img[^>]+\>/i", " ", $rs->forum_decription); 
	  							$content = preg_replace("/<p[^>]+\>/i", " ", $rs->forum_decription); 
	  						echo  strip_tags(substr($content,0,200)).'...';
									   }
							 ?></div>
								       <div class="text-right mart10"><a class="more" href="<?php echo site_url("forum/detail/".base64_encode($rs->forum_id));?>">View More</a></div> 
								    </div>
						    	</div>
						    	<div class="clearfix"></div>
			         		</li>
			         		<?php } } else {?>
			         			<li>No Forum Founds.</li>
			         		<?php } ?>	
			         		
			         	</ul>
		     		</div>
		     		<div class="pagination">
		     			<ul class="pagination">
		     				<?php 
	  				echo $page_link;
	  				?>
		     				<div class="clearfix"></div>
		     			</ul>
		     		</div>
		     		<div class="clearfix"></div>
	     		</div>
	     		<div class="right_block_releated">
	     			<?php 
		  				if($this->session->userdata("user_id") != "" &&  $this->session->userdata("user_id") != 0 )
						{ ?>
	     			<div class="text-right">
	     			  	 <button href="#suggestmodal"  data-toggle="modal"class="btn btn-lg btn-primary" name="" type="submit">Add New Topic</button>
	     			  </div>
	     			  
	     			  <?php } ?>
	     			<div class="text-left mar_top15">
	     				<h1 class="productbar_title">Popular Topics</h1>
	     				<div class="clearfix"></div>
	     				<ul class="review_block">
	     					<?php
	  		if($popular_forum)
	  		{
	  			foreach($popular_forum as $rs)
	  			{
	  				?>
		     				<li>
		     					<div class="pull-left marr_10">
		     							<?php
				if($rs->user_id>0){
								      	
		          		if($rs->profile_image!="" && file_exists(base_path().'upload/user_thumb/'.$rs->profile_image))
					{
						?>
		            	    <img style="width: 50p; height: 57px;" class="img-responsive" src="<?php echo base_url()?>/upload/user_thumb/<?php echo $rs->profile_image; ?>" alt="American Bars"/>
		            	<?php } else {
		            		?>
		            		<img style="width: 50p; height: 57px;" class="img-responsive" src="<?php echo base_url()?>/upload/no-image.png" alt="American Bars"/>	
		            			<?php } } else {
		            		?>
		            		<img style="width: 50p; height: 57px;" class="img-responsive" src="<?php echo base_url()?>/upload/no-image.png" alt="American Bars"/>	
		            			<?php } ?>
		     					</div>
		     					<div class="related_beer_block">
			     					<div><a class="bar_title" href="<?php echo site_url("forum/detail/".base64_encode($rs->forum_id));?>"><?php echo ucwords($rs->topic_name); ?></a></div>
			     					<p class="result_desc">Posted By <?php if($rs->user_id>0){ echo $rs->first_name." ".$rs->last_name;}else { echo "AB"; } ?></p>
			     					<p class="result_desc pull-left mar_r5">Total Views : <?php echo $rs->view; ?></p>
			     					<p class="result_desc pull-left">Total Comments : <?php echo count_forum_comment($rs->forum_id); ?></p>
			     					<div class="clearfix"></div>
		     					</div>
		     					<div class="clearfix"></div>
		     				</li>
		     				<?php } }  else {?>
			         			<li>No Any Popular Forum Founds.</li>
			         		<?php } ?>	
		     				
		     				
		     			</ul>
	     			</div>
	     			
	     		</div>
	     		<div class="clearfix"></div>
     		</div>
     		
   		</div>
   	</div>
   	
<div class="modal fade" id="helpfindbar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <?php echo $this->load->view(getThemeName().'/bar/bar_suggest');?>
    </div>	
    
<script>
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