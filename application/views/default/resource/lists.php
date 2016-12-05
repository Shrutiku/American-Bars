<?php
$theme_url = $urls= base_url().getThemeName();
?>

<!-- <script type="text/javascript" src="<?php echo base_url(); ?>jwplayer/jwplayer.js"></script> -->
<script type="text/javascript">

    function blank()
    {
    	$("#resource_suggest").find('input,textarea,select').val('');
    	CKEDITOR.instances['resource_desc'].setData('');
    }
	function set_orderby(limit,alpha,option,keyword,offset)
	{
	$('#resource-search-frm').submit();
	}
	function limitsubmit(){	
		$('#resource-search-frm').submit();
	}
</script>

<!-- content -->
<div class="wrapper row4">
   		<div class="container clearfix">
   			<div id="slider-fixed-banner" class="carousel slide">
        	<div class="carousel-inner">
          	<div class="active item">
            	 <?php $v=0; /* $getimagename = getimagenamebanner();
									if($getimagename->resource_directory!="" && is_file(base_path().'upload/bar_pages_banner_orig/'.$getimagename->resource_directory)){ ?>
										<img src="<?php echo base_url().'upload/bar_pages_banner/'.$getimagename->resource_directory; ?>"   />
									<?php
									} else {?>
            	<img src="<?php echo base_url(); ?>/default/images/smallbanner1.png" alt="American Dive Bars"/>
            	<?php } */ 
  $getad_banner = '';
            	$getad_banner = getadvertisementBannerSearchBar('find_resource'); 
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
       
   	</div>
	</div>
  </div>
  
  


	<div class="wrapper row5">
		<div class="container">
			<form class="form-horizontal" id="resource-search-frm" method="post" role="form" action="<?php echo site_url("resource/lists"); ?>">
			  <div class="">
				<div class="result_search full-width">
					<div class="drop-box-left">
						<div class="result_search_text pull-left"><?php echo $total_rows;?> Results Found</div>
					</div>
					<div class="drop-box">
						<div class="form-group pull-left">
								<label for="inputEmail3" class="control-label">Filter By :</label>
								<select id="resource_category" class="select_box marr_10" onchange="limitsubmit()" name="resource_category">
												<option value="">-Select-</option>
												<option value="beer" <?php if(@$resource_category =='beer'){?> selected="selected" <?php } ?>> Beer</option>
												<option value="cocktails" <?php if(@$resource_category =='cocktails'){?> selected="selected" <?php } ?>> Cocktails</option>												
												<option value="education" <?php if(@$resource_category =='education'){?> selected="selected" <?php } ?>> Education</option>												
												<option value="health" <?php if(@$resource_category =='health'){?> selected="selected" <?php } ?>> Health </option>												
												<option value="hangovers" <?php if(@$resource_category =='hangovers'){?> selected="selected" <?php } ?>> Hangovers </option>												
												<option value="government" <?php if(@$resource_category =='government'){?> selected="selected" <?php } ?>> Government </option>												
												<option value="local_lists" <?php if(@$resource_category =='local_lists'){?> selected="selected" <?php } ?>> Local Lists </option>												
												<option value="science" <?php if(@$resource_category =='science'){?> selected="selected" <?php } ?>> Science </option>												
												<option value="other" <?php if(@$resource_category =='other'){?> selected="selected" <?php } ?>> Other </option>												
												<option value="recreation" <?php if(@$resource_category =='recreation'){?> selected="selected" <?php } ?>> Recreation </option>												
												<option value="video_links" <?php if(@$resource_category =='video_links'){?> selected="selected" <?php } ?>> Video Links </option>
												<option value="video_links" <?php if(@$resource_category =='bands_and_musicians'){?> selected="selected" <?php } ?>> Bands and Musicians </option>
												<option value="annual_events" <?php if(@$resource_category =='annual_events'){?> selected="selected" <?php } ?>> Annual Events</option>
												
											</select>
						   </div>
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
									<option value="resource_title#ASC" <?php if($order_by == "resource_title#ASC"){ ?> selected="selected" <?php } ?>>Name A-Z</option>
									<option value="resource_title#DESC"<?php if($order_by == "resource_title#DESC"){ ?> selected="selected" <?php } ?>>Name Z-A</option>
								 </select>
						   </div>
						   <div class="clearfix"></div>
					  </div>
					  <div class="clearfix"></div>
				</div>
				<div class="alphabate_block">
					<ul class="alphabate_list wid-60">
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("a"))."/".$options; ?>" <?php if($alpha == "a"){ ?> class="active" <?php }?>>a</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("b"))."/".$options; ?>" <?php if($alpha == "b"){ ?> class="active" <?php }?>>b</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("c"))."/".$options; ?>" <?php if($alpha == "c"){ ?> class="active" <?php }?>>c</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("d"))."/".$options; ?>" <?php if($alpha == "d"){ ?> class="active" <?php }?>>d</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("e"))."/".$options; ?>" <?php if($alpha == "e"){ ?> class="active" <?php }?>>e</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("f"))."/".$options; ?>" <?php if($alpha == "f"){ ?> class="active" <?php }?>>f</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("g"))."/".$options; ?>" <?php if($alpha == "g"){ ?> class="active" <?php }?>>g</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("h"))."/".$options; ?>" <?php if($alpha == "h"){ ?> class="active" <?php }?>>h</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("i"))."/".$options; ?>" <?php if($alpha == "i"){ ?> class="active" <?php }?>>i</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("j"))."/".$options; ?>" <?php if($alpha == "j"){ ?> class="active" <?php }?>>j</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("k"))."/".$options; ?>" <?php if($alpha == "k"){ ?> class="active" <?php }?>>k</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("l"))."/".$options; ?>" <?php if($alpha == "l"){ ?> class="active" <?php }?>>l</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("m"))."/".$options; ?>" <?php if($alpha == "m"){ ?> class="active" <?php }?>>m</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("n"))."/".$options; ?>" <?php if($alpha == "n"){ ?> class="active" <?php }?>>n</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("o"))."/".$options; ?>" <?php if($alpha == "o"){ ?> class="active" <?php }?>>o</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("p"))."/".$options; ?>" <?php if($alpha == "p"){ ?> class="active" <?php }?>>p</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("q"))."/".$options; ?>" <?php if($alpha == "q"){ ?> class="active" <?php }?>>q</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("r"))."/".$options; ?>" <?php if($alpha == "r"){ ?> class="active" <?php }?>>r</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("s"))."/".$options; ?>" <?php if($alpha == "s"){ ?> class="active" <?php }?>>s</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("t"))."/".$options; ?>" <?php if($alpha == "t"){ ?> class="active" <?php }?>>t</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("u"))."/".$options; ?>" <?php if($alpha == "u"){ ?> class="active" <?php }?>>u</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("v"))."/".$options; ?>" <?php if($alpha == "v"){ ?> class="active" <?php }?>>v</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("w"))."/".$options; ?>" <?php if($alpha == "w"){ ?> class="active" <?php }?>>w</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("x"))."/".$options; ?>" <?php if($alpha == "x"){ ?> class="active" <?php }?>>x</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("y"))."/".$options; ?>" <?php if($alpha == "y"){ ?> class="active" <?php }?>>y</a></li>
						<li><a href="<?php echo site_url("resource/lists/".$limit."/".base64_encode("z"))."/".$options; ?>" <?php if($alpha == "z"){ ?> class="active" <?php }?>>z</a></li>
						<div class="clearfix"></div>
					</ul>
					
				</div>
				<div class="forum-listing">
					<div class="pull-left padt10">
						   <div class="form-group">
							   <div class="col-sm-10 input_box pull-left">
								   <input type="text" class="form-control form-pad tags" id="keyword" name="keyword" placeholder="Resource Name Here" value="<?php echo $keyword; ?>">
								   <input type="hidden" name="alpha" id="alpha" value="<?php echo $alpha; ?>" />
							   </div>
							   <div class="col-sm-2 input_box pull-left">
									<button class="btn btn-lg btn-primary"><i class="strip search"></i></button>
							   </div>
							   <div class="clearfix"></div>
							</div>
					</div>
					<div class="pagination mart20">
			  			<ul class="pagination">
							<?php echo $page_link; ?>
						</ul>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			</form>
				<div class="result_box clearfix">
					<ul class="result_sub_box">
					<?php if($result){
				  			foreach($result as $rs)
	  					{?>
	  						
	  						<li class="active">
	         			<h1><a class="pull-left listing-title" href="<?php echo site_url("resource/detail/".base64_encode($rs->resource_id));?>"><?php echo $rs->resource_title; ?></a></h1>
	         			<div class="clearfix"></div>
	         				<div class="padt10">
						       <div class="result_desc">
						       	<?php  if(strip_tags(strlen($rs->resource_desc))>200){ echo substr(strip_tags($rs->resource_desc),0,200).'...' ; } else { echo strip_tags($rs->resource_desc); } ?></div> 
						        <div class="padt8">
						        	<div class="reult_sub_title">
							        	<div class="pull-left yellow_text marr_10">Category : </div>
			         					<div class="pull-left">
			         					<?php echo ucfirst(str_replace("_"," ",$rs->resource_category)); ?>
										</div>
										<div class="clearfix"></div>
									</div>
						        	<div class="reult_sub_title">
							        	<div class="pull-left yellow_text marr_10">Website : </div>
			         					<div class="pull-left">
			         						<a class="website-url" href="javascript:void(0);" onclick="window.open('<?php echo $rs->website; ?>', '_blank', 'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0');"><?php echo $rs->website; ?></a>
										</div>
										<div class="clearfix"></div>
									</div>
						        	<div class="rating_box"><a class="more" href="<?php echo site_url('resource/detail/'.base64_encode($rs->resource_id))?>">More Details</a></div>
		    		 				<div class="clearfix"></div>
						        </div>
							</div>
				  
				    	<div class="clearfix"></div>
	         		</li>
						
						<div class="clearfix"></div>
						<?php
							}
						}else {
						?>
							<li class="active">
							No Records Found.
							</li>
                     <?php }?>
					</ul>
				</div>
				<div>
					
					<div class="pagination mart20">
			  			<ul class="pagination">
							<?php echo $page_link; ?>
						</ul>
					</div>
					<div class="clearfix"></div>
				</div>
				</div>
				
	</div>
<script>
	function add_click(id)
		{
		 //  window.location.href = '<?php //echo site_url('resource/lists');?>'; 
		   $.ajax({
	       type: "POST",
		   url: "<?php echo site_url('home/add_clcik')?>",
		   data : {id:id},
		   dataType : 'JSON',
		   success: function(response) {
		    
		     
		  }
	   });
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
<!-- ########################################################################################### -->