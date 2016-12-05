<style>
	.dropdown-menu{
		background-color: #fff;
	}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/assets/plugins/bootstrap-daterangepicker/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/assets/plugins/font-awesome/css/font-awesome.min.css" />
<script src="<?php echo base_url().getThemeName();?>/assets/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url().getThemeName();?>/assets/plugins/bootstrap-daterangepicker/date.js" type="text/javascript"></script>
<?php
$theme_url = $urls= base_url().getThemeName();
?>

<!-- <script type="text/javascript" src="<?php echo base_url(); ?>jwplayer/jwplayer.js"></script> -->
<script type="text/javascript">
$(document).ready(function(){	
	 var date = new Date();
		$('#event_date').daterangepicker({
			      
			       
			//mask:'9999/19/39 29:59'
		});
	 });
    function blank()
    {
    	$("#beer_suggest").find('input,textarea,select').val('');
    	CKEDITOR.instances['beer_desc'].setData('');
    }
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
            	<?php  /* $getimagename = getimagenamebanner();?>	
          	  <?php 
									if($getimagename->beer_directory_state==1 && $getimagename->beer_directory!="" && is_file(base_path().'upload/bar_pages_banner_orig/'.$getimagename->beer_directory)){ ?>
										<img src="<?php echo base_url().'upload/bar_pages_banner/'.$getimagename->beer_directory; ?>"   />
									<?php
									} else {?>
            	<!-- <img src="<?php echo base_url(); ?>/default/images/smallbanner1.png" alt="American Bars"/> -->
            	<?php } */ 
            	$v=0;
          $getad_banner = '';
            	$getad_banner = getadvertisementBannerSearchBar('find_event'); 
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
		     			  ?>
		     			  <!-- <img src="<?php echo base_url(); ?>/default/images/smallbanner1.png" alt="American Dive Bars"/> -->
		     			  	<?php } ?>
          </div>
        </div>
        <!-- <a class="left carousel-control" href="#slider-fixed-banner" data-slide="prev">&lsaquo;</a>
        <a class="right carousel-control" href="#slider-fixed-banner" data-slide="next">&rsaquo;</a> -->
       
   	</div>
	</div>
  </div>
  
	<div class="wrapper row5" style="border:<?php echo $v==0 ? 'none':'';?>">
		<div class="container ">
			<form class="form-horizontal" id="beer-search-frm" method="post" role="form" action="<?php echo site_url("event/lists"); ?>">
			  <div class="left_block">
			  	<div class="beer-list">
					<div class="result_search beer-search">
						<div class="col-sm-6">
							<div class="result_search_text pull-left"><?php echo $total_rows;?> Results Found</div>
						</div>
						<input type="hidden" name="bar_id" id="bar_id" value="<?php echo $bar_id;?>"   />
						<div class="col-sm-5 navbar-collapse">
							   <div class="form-group pull-left">
									<label for="inputEmail3" class="control-label">Results Per Page :</label>
									<select class="select_box" name="limit" id="limit" onchange="limitsubmit();">
										<option value="6"<?php if($limit==6){ ?> selected="selected"<?php } ?>>6</option>
										<option value="12"<?php if($limit==12){ ?> selected="selected"<?php } ?>>12</option>
										<option value="18"<?php if($limit==18){ ?> selected="selected"<?php } ?>>18</option>
										<option value="24"<?php if($limit==24){ ?> selected="selected"<?php } ?>>24</option>
										<option value="30"<?php if($limit==30){ ?> selected="selected"<?php } ?>>30</option>
											<option value="60" <?php if($limit == "60"){?> selected= "selected" <?php } ?>>60</option> 
									 </select>
							   </div>
							   <!-- <div class="form-group  pull-right">						  
									<label for="inputEmail3" class="control-label">Sort By :</label>
									 <select class="select_box" name="order_by" id="order_by" onchange="set_orderby('<?php echo $limit;?>','<?php echo $alpha;?>','<?php echo $options;?>','<?php echo $keyword;?>','<?php echo $offset; ?>')">
										<option value="event_title#ASC" <?php if($order_by == "event_title#ASC"){ ?> selected="selected" <?php } ?>>Name A-Z</option>
										<option value="event_title#DESC"<?php if($order_by == "event_title#DESC"){ ?> selected="selected" <?php } ?>>Name Z-A</option>
									 </select>
							   </div> -->
							   <div class="clearfix"></div>
						  </div>
						  <div class="clearfix"></div>
					  </div>
				</div>
				<div class="alphabate_block">
					<ul class="alphabate_list" style="width: 85%;">
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("a")); ?>" <?php if($alpha == "a"){ ?> class="active" <?php }?>>a</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("b")); ?>" <?php if($alpha == "b"){ ?> class="active" <?php }?>>b</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("c")); ?>" <?php if($alpha == "c"){ ?> class="active" <?php }?>>c</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("d")); ?>" <?php if($alpha == "d"){ ?> class="active" <?php }?>>d</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("e")); ?>" <?php if($alpha == "e"){ ?> class="active" <?php }?>>e</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("f")); ?>" <?php if($alpha == "f"){ ?> class="active" <?php }?>>f</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("g")); ?>" <?php if($alpha == "g"){ ?> class="active" <?php }?>>g</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("h")); ?>" <?php if($alpha == "h"){ ?> class="active" <?php }?>>h</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("i")); ?>" <?php if($alpha == "i"){ ?> class="active" <?php }?>>i</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("j")); ?>" <?php if($alpha == "j"){ ?> class="active" <?php }?>>j</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("k")); ?>" <?php if($alpha == "k"){ ?> class="active" <?php }?>>k</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("l")); ?>" <?php if($alpha == "l"){ ?> class="active" <?php }?>>l</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("m")); ?>" <?php if($alpha == "m"){ ?> class="active" <?php }?>>m</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("n")); ?>" <?php if($alpha == "n"){ ?> class="active" <?php }?>>n</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("o")); ?>" <?php if($alpha == "o"){ ?> class="active" <?php }?>>o</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("p")); ?>" <?php if($alpha == "p"){ ?> class="active" <?php }?>>p</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("q")); ?>" <?php if($alpha == "q"){ ?> class="active" <?php }?>>q</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("r")); ?>" <?php if($alpha == "r"){ ?> class="active" <?php }?>>r</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("s")); ?>" <?php if($alpha == "s"){ ?> class="active" <?php }?>>s</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("t")); ?>" <?php if($alpha == "t"){ ?> class="active" <?php }?>>t</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("u")); ?>" <?php if($alpha == "u"){ ?> class="active" <?php }?>>u</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("v")); ?>" <?php if($alpha == "v"){ ?> class="active" <?php }?>>v</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("w")); ?>" <?php if($alpha == "w"){ ?> class="active" <?php }?>>w</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("x")); ?>" <?php if($alpha == "x"){ ?> class="active" <?php }?>>x</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("y")); ?>" <?php if($alpha == "y"){ ?> class="active" <?php }?>>y</a></li>
						<li><a href="<?php echo site_url("event/lists/".$bar_sulg.'/'.$limit."/".base64_encode("z")); ?>" <?php if($alpha == "z"){ ?> class="active" <?php }?>>z</a></li>
						<div class="clearfix"></div>
					</ul>
					
				</div>
				<div>
					<div class="padt10">
						   <div class="form-group">
							   <div class="input_box pull-left event-new-textbox">
								   <input  type="text"  class="form-control pull-left  form-pad tags margin-right-10" id="keyword" name="keyword" placeholder="Search By name, zipcode " value="<?php echo $keyword; ?>">
								   <input type="text"  class="form-control pull-left form-pad tags" id="event_date" name="event_date" placeholder="Event Date" value="<?php echo @$event_date; ?>">
								   <input type="hidden" name="alpha" id="alpha" value="<?php echo $alpha; ?>" />
							   </div>
							   <div class="col-sm-1 input_box pull-left">
									<button class="btn btn-lg btn-primary small-search"><i class="strip search"></i></button>
							   </div>
                               <div class="view-btn-new">
									<a href="<?php echo site_url('event/lists/'.$bar_sulg."/".$totalevent)?>" class="btn btn-lg btn-primary">View All</a>
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
					<ul class="event-listing">
                     
					<?php if($result){
				  			foreach($result as $rs)
	  					{?>
	  						
	  						<li>
     							<div class="event-img">
     								<a href="<?php echo site_url("event/detail/".base64_encode($rs->event_id));?>">
								<?php $getimage = getsingleimage_event($rs->event_id);
								?>
     									<?php 
									if($rs->event_upload_type=="image" && $getimage!="" && is_file(base_path().'upload/bar_eventgallery_thumb_250by150/'.$getimage)){ ?>
										<img src="<?php echo base_url().'upload/bar_eventgallery_thumb_250by150/'.$getimage; ?>"  />
									<?php
									}
									else if($rs->event_upload_type=="video"  && $rs->event_video_link!='')
									{
										
										$url = $rs->event_video_link;
										if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id)) {
										  $values = $id[1];
										} else if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $id)) {
										  $values = $id[1];
										} else if (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $id)) {
										  $values = $id[1];
										} else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
										  $values = $id[1];
										}
										else if (preg_match('/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/', $url, $id)) {
										    $values = $id[1];
										} else {
											$values = '';   
										// not an youtube video
										}
										
										
										 ?>
										<img style="width: 240px; height: 150px;"   src="http://img.youtube.com/vi/<?php echo $values; ?>/0.jpg" />
								<?php	}
									else {?>
									<img class="img-responsive" src="<?php echo base_url().'upload/event_thumb/no_image.png'; ?>" />
							<?php } 
							$getevent = $this->event_model->checkeventalreadyattend($rs->event_id,'y',get_authenticateUserID());
							
							?>
							     </a>
     							</div>
     							<div class="event-detail">
     								<a href="<?php echo site_url("event/detail/".base64_encode($rs->event_id));?>"><h1 class="event-title"><?php echo strlen($rs->event_title)>30 ? substr($rs->event_title,0,30)."...":$rs->event_title;?></h1></a>
     								<div class="mart10">
	     								<p><b>Organized By :</b> <?php if($rs->bar_id >0){ echo getBarName($rs->bar_id);  } else if($rs->organizer!='') { echo strlen($rs->organizer)>18 ?  substr($rs->organizer,0,18)."...":$rs->organizer; } else { echo "American Bars"; }?></p>
                                        <!-- <p><b>Date :</b> <?php echo date($site_setting->date_format,strtotime($rs->start_date));?> To <?php echo date($site_setting->date_format,strtotime($rs->end_date));?></p>
                                        <p><b>Time :</b> <?php echo date('h:i A', strtotime($rs->start_date));?> To <?php echo date('h:i A', strtotime($rs->end_date));?></p> -->
                                        <p><b>Location :</b> <?php echo $rs->city.', '.$rs->state;?></p>
                                        <p><?php $t = getEventDate($rs->event_id);?> <?php echo date('l, F j, Y',strtotime($t->eventdate)); ?></p>
	     								<p class="text-right"><a href="<?php echo site_url("event/detail/".base64_encode($rs->event_id));?>" class="readmore">Read More</a></p>
     								</div>
     							</div>
     						</li>
						
						<?php
							}
						}else {
						?>
							No Records Found.
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
				
				
				<div class="right_block_releated latest-event">
	     			<div>
	     				<h1 class="productbar_title text-left">Latest Events</h1>
	     				<div class="clearfix"></div>
	     				
	     				<?php if($latest_event){
				  			foreach($latest_event as $rs)
	  					{?>
	     				<div>
		     				<div>
		     					<a   href="<?php echo site_url("event/detail/".base64_encode($rs->event_id));?>">
								<?php $getimage = getsingleimage_event($rs->event_id);
								?>
     									<?php 
									if($getimage!="" && is_file(base_path().'upload/bar_eventgallery_thumb_304by201/'.$getimage)){ ?>
										<img class="br_gray img-responsive" src="<?php echo base_url().'upload/bar_eventgallery_thumb_304by201/'.$getimage; ?>"  />
									<?php
									}
									else{?>
									<img class="br_gray img-responsive" style="width: 301px; height: 204px;" src="<?php echo base_url().'upload/event_thumb/no_image.png'; ?>" />
							<?php } ?>
							     </a>
		     				</div>
		     				<div class="result_desc padtb">
	     						<a href="<?php echo site_url("event/detail/".base64_encode($rs->event_id));?>"><?php echo $rs->event_title;?></a> 
	     					</div>
     					</div>
     					<?php } } ?>
     					
	     			</div>
	     			
	     			
	     			
	     		</div>
				
				
				
				
				
				
				
				
	</div>
<script>
	function add_click(id)
		{
		   //window.location.href = '<?php //echo site_url('beer/lists');?>'; 
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