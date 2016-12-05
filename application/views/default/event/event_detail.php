
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>

<style>
.happy-list li p{
	color: #FFFFFF;
}
#gmap_marker {
    height: 400px;
    width: 100%;
}
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



		            		
		            		
		            		
<?php $theme_url = $urls= base_url().getThemeName();?>
<input type="hidden" name="sess_id" id="sess_id" value="<?php echo check_user_authentication()=="" ? '0':'1';?>" />
<style type="text/css">
	/*//.rating {margin: 0em !important;width:100px;} */
</style>
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
<!-- content -->
<div class="wrapper row5" style="border:<?php echo $v==0 ? 'none':'';?>">
     	<div class="container">
     	<div class="beer_details">
     		<div class="mar_top20 event-sub">
     			<div class="result_search">
	     			<div class="result_search_text"><?php echo ucwords($event_detail['event_title']);?></div>
     			</div>
     			<div class="mar_top15">
		     		<div class="product-img">
		     			
		     			<?php
		     			
		     			$img = getimagename($event_detail['event_id']); 
						if($event_detail['event_upload_type']=='image')
						{ 
		     			  if($bar_gallery){ ?><ul class="bxslider">
	     					    
     					  	   <?php   foreach($bar_gallery as $rows){
     					  	    	?>
									  <li class="br_green_yellow">
									  	<img class=" gallery_img" src="<?php echo base_url().'upload/bar_eventgallery_thumb_big/'.$rows->event_image_name;?>" /></li>
								<?php } }?>	  
									</ul>
									
									
									 <?php if($bar_gallery){ ?>
									 	<ul id="bx-pager" class="bxslider123">
     					  	    <?php $i=0; foreach($bar_gallery as $rows){
     					  	    	?>	
									  <li class=""><a data-slide-index="<?php echo $i;?>" href=""><img class="thumb_img" src="<?php echo base_url().'upload/bar_eventgallery_thumb/'.$rows->event_image_name;?>" /></a></li>
									<?php $i++; } ?>  </ul> <?php } } elseif($event_detail['event_upload_type']=='video' && $event_detail['event_video_link']!='') {  ?>
										
					<?php
            //print_r($site_setting);
            if($event_detail['event_video_link']!=''){
            $url	=	$event_detail['event_video_link'];
				if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',$url,$matches)) {
					//echo $url;
				      //preg_match('/[\\?\\&]v=([^\\?\\&]+)/',$url,$matches);
				      //preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',$url,$matches);
							if(isset($matches[1])){
							$id = $matches[1];
								echo '<iframe class="" width="100%" height="290" src="//www.youtube.com/embed/'.$id.'?rel=0" frameborder="0" allowfullscreen></iframe>';
							}else{
								echo $url;
							}
				    } elseif (strpos($url, 'vimeo') > 0) {
				    	preg_match('~^http://(?:www\.)?vimeo\.com/(?:clip:)?(\d+)~',$url,$matches);
				//	$parsed = parse_url($url);
					//print_r($parsed);
				       if(isset($matches[1])){
							$id = $matches[1];
							echo '<iframe width="397" height="290" src="//player.vimeo.com/video/'.$id.'" class="" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> ';	
								
							}else{
								$a=json_decode(file_get_contents('http://vimeo.com/api/oembed.json?url='.$url));
								
								if(isset($a->video_id) && $a->video_id!=''){
								$id=$a->video_id;
									echo '<iframe width="397" height="290" src="//player.vimeo.com/video/'.$id.'" class="" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> ';	
								}
							}
				    }
				    }
            ?>
				   <?php } else { ?>
				   	
				   	<!-- <img src="<?php echo base_url().'default'?>/images/cocktail-default.png" alt="American Dive Bars" /> -->
				   	<div class="gallery-default">
				   		No Event image or Video Available
				   	</div>
				   	<?php } ?>		
		     			
		     			<!-- <div class="mar_top15">
		     				<div class="map_block img_br_yellow" id="gmap_marker">
		     						
		     					</div>
		     			</div> -->
		     		</div>
		     		<div class="product-detail">
		     			<div>
		     				<p class="eventdesc-title newevent-desc">Event Name</p>
		     				<p class="colon-block margin-top-8">:</p>
		     				<p style="margin-left: 0px; width: 55%; float: left;" class="newevent-desc"><?php echo ucwords($event_detail['event_title']);?></p>
		     				<div class="taxi-right">	
		     					
						       <ul class="social_icon">
						       	<li>Share : </li>
						    <li><a href="javascript://" onclick="fbShare()" ><img src="<?php echo base_url().'default'?>/images/result_fb.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_fb-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_fb.png'" /></a></li>
						    <li><a onclick="twShare()" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_twitt.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_twitt-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_twitt.png'" /></a></li>
						    <li><a onclick="gPlusShare1('<?php echo site_url().'event/detail/'.base64_encode($event_detail['event_id']); ?>','<?php echo $event_detail['event_title']; ?>')" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_google.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_google-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_google.png'" /></a></li>
						    <li><a  href="javascript://" onclick="piShare()"><img src="<?php echo base_url().'default'?>/images/result_p.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_p-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_p.png'" /></a></li>
						    
							         		
							    		 	<div class="clearfix"></div>
		    		 					</ul>
		    		 				</div>	
		     				<div class="clearfix"></div>
		     			</div>
		     			
		     			
		     			
		     			<div>
		     				<p class="eventdesc-title">Organized by</p>
		     				<p class="colon-block">:</p>
		     				<p class="event-desc mar_top5"><?php if($event_detail['bar_id']>0){ echo getBarName($event_detail['bar_id']);  } else if($event_detail['organizer']!='') { echo $event_detail['organizer']; } else { echo "American Bars"; }?></p>
		     				<div class="clearfix"></div>
		     			</div>
		     			<div>
		     				<p class="eventdesc-title">Address</p>
		     				<p class="colon-block">:</p>
		     				<p class="event-desc"><?php echo $event_detail['address'].', '.$event_detail['city'].', '.$event_detail['state'].' '.$event_detail['zipcode'];?></p>
		     				<div class="clearfix"></div>
		     			</div>
		     			<div>
		     				<p class="eventdesc-title">Venue</p>
		     				<p class="colon-block">:</p>
		     				<p class="event-desc"><?php echo $event_detail['venue'];?></p>
		     				<div class="clearfix"></div>
		     			</div>
		     			
		     			
		     			<div>
		     				<p class="eventdesc-title">Event Date</p>
		     				<p class="colon-block">:</p>
		     				
		     				<?php if($eventtime){
		     					
								
								   foreach($eventtime as $t)
								   {
								   	 
		     					  ?>
		     					
		     				<p class="event-desc"><b>Date :</b> <?php echo date('l, F j, Y',strtotime($t->eventdate)) ."<br> <b>Time :</b> ". $t->eventstarttime." - ".$t->eventendtime; ?></p>
		     				 
		     				<?php } } ?>	
		     			
		     				<div class="clearfix"></div>
		     			</div>
		     			
		     			<div>
		     				<p class="eventdesc-title">Event Category</p>
		     				<p class="colon-block">:</p>
		     				<p><?php
					     							
													$cat = '';
													 $getin1 = explode(',',strip_tags($event_detail['event_category']));
					     							
					     							  foreach($getin1 as $r)
													  {
													  	  $cat .=  getEventCatname($r).', ';
													}
													 
													echo substr($cat,0,-2);  
													   ?></p>
		     				<div class="clearfix"></div>
		     			</div>
		     			<?php if($event_detail['admission']){?>
		     			<div>
		     				<p class="eventdesc-title">Admission starting at</p>
		     				<p class="colon-block">:</p>
		     				<p class="event-desc"><?php echo $site_setting->currency_symbol ."". $event_detail['admission'];?></p>
		     				<div class="clearfix"></div>
		     			</div>
		     			<?php } ?>
		     			
		     			<?php if($event_detail['website']){?>
		     			<div>
		     				<p class="eventdesc-title">Website</p>
		     				<p class="colon-block">:</p>
		     				<p class="event-desc"><a href="<?php echo $event_detail['website'];?>"><?php echo $event_detail['website'];?></a></p>
		     				<div class="clearfix"></div>
		     			</div>
		     			<?php } ?>
		     			<?php if($event_detail['buy_ticket']){?>
		     			<div>
		     				<p class="eventdesc-title">Buy Ticket</p>
		     				<p class="colon-block">:</p>
		     				<p class="event-desc"><a target="_blank" class=" white review marr_10" href="<?php echo $event_detail['buy_ticket'];?>">Buy Tickets</a></p>
		     				<div class="clearfix"></div>
		     			</div>
		     			<?php } ?>
		     			<div>
		     				<p class="eventdesc-title">Description</p>
		     				<p class="colon-block">:</p>
		     				<p class="event-desc event-desc-height">
		     					
		     					<?php if(strip_tags(strlen($event_detail['event_desc'])>350)){ echo substr(strip_tags($event_detail['event_desc']),0,350).'...<a class="morelink1 more pull-right" href="javascript://"><i class="strip arrow_down"></i>Show more</a>' ; } else { echo strip_tags($event_detail['event_desc']); } ?>
		     						</p>
		     				<div class="clearfix"></div>
		     			</div>
		     			
		     			<?php
		     				$getevent = $this->event_model->checkeventalreadyattend($event_detail['event_id'],'y',get_authenticateUserID());
							
						
		     				?>
		     			<div>
		     				<p class="eventdesc-title">Will you be attending?</p>
		     				<p class="colon-block">:</p>
		     				<?php if($getevent){ ?>
		     					
		     				<p class="event-desc"><a id="at_y" href="javascript://" disabled="disabled" <?php if(@$getevent['is_attend']=='no') { ?>onclick="attend('<?php echo $event_detail['event_id']?>','yes');"<?php } ?>  class="<?php echo @$getevent['is_attend']=='yes' ? 'active':'';?> white review marr_10">Yes</a> <a id="at_n" <?php if(@$getevent['is_attend']=='yes') { ?>onclick="attend('<?php echo $event_detail['event_id']?>','no');"<?php } ?>  href="javascript://" class="<?php echo @$getevent['is_attend']=='no' ? 'active':'';?> white review">No</a></p>
		     					
		     					<?php } else {?>
		     				<p class="event-desc"><a id="at_y" href="javascript://" disabled="disabled" onclick="attend('<?php echo $event_detail['event_id']?>','yes');"  class="<?php echo @$getevent['is_attend']=='yes' ? 'active':'';?> white review marr_10">Yes</a> <a id="at_n" onclick="attend('<?php echo $event_detail['event_id']?>','no');"  href="javascript://" class="<?php echo @$getevent['is_attend']=='no' ? 'active':'';?> white review">No</a></p>		
		     						<?php } ?>
		     				<div class="clearfix"></div>
		     			</div>
		     		</div>
	     		</div>
	     		<div class="clearfix"></div>
	     	</div>
	     	<div class="fullmug_block event-detailblock">
	     		<div class="col-md-5 col-sm-5 first-event newevent-block1">
	     			<h1 class="productbar_title">
     					<div class="pull-left mar_top5">Map</div>
     					<a href="javascript://" class="white pull-right review" onclick="loadMap(<?php echo $event_detail['event_id']; ?>)">Get Directions</a>
     					<div class="clearfix"></div>
     				</h1>
     				<div class="mar_top20">
     					 <div>
		     				<div class="map_block img_br_yellow" id="gmap_marker"></div>
		     				<div class="clearfix"></div>
		     			</div>
     				</div>
	     		</div>
	     		<div class="col-md-5 col-sm-5 newevent-block">
	     			<h1 class="productbar_title"><div class="mar_top5">Upcoming Events</div></h1>
	     			<div class="mar_top20">
	     				<div class="min-height-380">
	     				<ul class="upcooming-eventlist">
	     					
	     						<?php if($latest_event){
	         				 $i=0; foreach($latest_event as $news){
	         				 	
								
	         				 		$getimage = getimagename($news->event_id);?>
	         			<li>
	         				<div class="upcooming-eventimg">
	     							<a href="<?php echo site_url('event/detail/'.base64_encode($news->event_id));?>"><img src="<?php echo $getimage; ?>" class="img-responsive"></a>
	     						</div>
	         				<div class="upcooming-eventdetail">
	     							<a href="<?php echo site_url('event/detail/'.base64_encode($news->event_id));?>" class="newevent-desc"><?php if(strip_tags(strlen($news->event_title)>20)){ echo substr(strip_tags($news->event_title),0,20).'...' ; } else { echo strip_tags($news->event_title); } ?></a>
	     							<p class="event-desc"><?php if(strip_tags(strlen($news->event_desc)>55)){ echo substr(strip_tags($news->event_desc),0,55).'...' ; } else { echo strip_tags($news->event_desc); } ?></p>
	     							<p class="event-desc"> <?php echo date('l, F j, Y',strtotime($news->eventdate)); ?></p>
	     						</div>
	     						
	         			</li>
	         			<?php if($i!=2){?>
	         			<?php } ?>
	         			<?php $i++;} } ?>
	     					
	     				</ul>
	     				</div>
	     				<?php if($event_detail['bar_id']){?>
	     				<div class="text-right"><a class="more" id="view-alla" href="<?php echo site_url().'event/lists/'.getBarsl($event_detail['bar_id']);?>">View All </a></div>
	     				<?php } else {?>
	     				<div class="text-right"><a class="more" id="view-alla" href="<?php echo site_url().'event/lists';?>">View All </a></div>	
	     					<?php } ?>
	     			</div>
	     		</div>
	     		<div class="col-md-2 col-sm-5 newevent-smallblock">
	     			<h1 class="productbar_title"><div class="mar_top5">People attending</div></h1>
	     			<div class="mar_top20">
	     				<div class="min-height-380 people-say">
	     				<ul class="likeduser marl_0">
	     					<?php 
							if(count($beer_liker) > 0){
							$j=1;
							foreach($beer_liker as $bl){
								 
							if($j<=10){
							?>							
	     					<li id="user_<?php echo $bl->user_id;?>" class="active"><a href="<?php echo site_url('user/profile/'.base64_encode($bl->user_id));?>"><img src="<?php echo base_url();?>upload/user_thumb/<?php if($bl->profile_image!="" && is_file(base_path().'upload/user_thumb/'.$bl->profile_image)){ echo $bl->profile_image; } else{ echo 'no_img.png';}?>" class="user_img"/></a></li>
							<?php
							}
							$j++;
							 } 
							}?>    	
			     			
			     		</ul><div class="clearfix"></div>
			     		</div>
			     		<div class="text-right"><a class="more" onclick="viewall()" href="javascript://">View All </a></div>
	     			</div>
	     		</div>
	     		<div class="clearfix"></div>
	     	</div>
     	</div>	
   		</div>
   	</div>
  <div class="modal fade" id="myModalnew_open1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Event Description</div>
     				</div>
     				<div class="pad20">
     						<label class="control-label" style="color: #fff;"><?php echo $event_detail['event_desc']; ?></label>	
     				</div>		
     			</div>
     		</div>
     	</div>
     </div>
	
</div>    	
   	<div class="modal fade" id="myModalnew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
   	
<div class="modal fade login_pop2" id="mapmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
					   
					</div>	
   	
<div class="modal fade login_pop2" id="hourmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
						<div class="padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Event Time</div>
     				</div>
     				<div class="pad20">
     					<ul class="happy-list">
     						<?php
     						
     						 if($eventtime){
     							  foreach($eventtime as $r){?>
                        	<li>
                        		<p class="happy-title"><b>Date :</b> <?php echo date('l, F j, Y',strtotime($r->eventdate)) ."<br> <b>Time :</b> ". $r->eventstarttime." - ".$r->eventendtime; ?></p>
                            </li>
                            <?php } } else {?>
                            	<h3>No record founds.</h3>
                            <?php } ?>	
                            </li>
                        </ul>	
     						
     						
     				</div>		
     			</div>
     		</div>
     	</div>
     </div>
     			</div>	

<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.bxslider.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/css/jquery.bxslider.css" />


<script>
	function loadMap(id)
	{
		 $.ajax({
	       type: "POST",
		   url: "<?php  echo site_url('event/getmapajaxevent')?>",
		   data: {id:id},
		   dataType : 'html',
		     beforeSend : function() {
		   		$('#dvLoading').fadeIn('slow');
		   },
		    complete : function() {
		   		$('#dvLoading').fadeOut('slow');
		   },		
		   success: function(response) {
		   	$("#mapmodal").html(function(){
		   		$(this).html(response);
		   		$('#mapmodal').on('show.bs.modal', function() {
                         initialize();
			           	 	
    						}).modal();
    						
    						 setTimeout(function() {
					       initialize();
						}, 200);
		   	});
		    //$('#mapmodal').one('show.bs.modal', function (e) {
		    	//$('#myModalnew').one('shown.bs.modal', function (e) {
		    	
		     
		  }
	   });
	}

	
$(document).ready(function() {
		$('.bxsaslider1').bxSlider({
	  pagerCustom: '#bx-pager'
	});
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
	
	 $('.bxslider123').bxSlider({
	 	useCSS: false,
	 	infiniteLoop:false,
	 	mode: 'horizontal',
	 	preloadImages:'all',
	 	controls:true,
	 	
		minSlides: 5,
	  	maxSlides: 5,
	  	slideWidth: 65,
	 	pager: false,
});
});

</script>








<script>


  	function attend(id,type)
  {
  	  
	<?php if(check_user_authentication()){?>	
  	 $.ajax({
			type: "POST",
			url: "<?php  echo site_url('event/changestatus')?>",
			data: {id:id,type:type},
			dataType : '',
			beforeSend : function() {
		
			$('#loading').fadeIn('slow');
			},
			complete : function() {
			$('#loading').fadeOut('slow');
			},
			success: function(data) {
				var main = data.split('*');
				
				if(type=='yes')
				{
					 $("#at_y").addClass("active");
					 $("#at_y").attr("onclick","");
					 $("#at_n").attr("onclick","attend("+id+",'no')");
			    	  $("#at_n").removeClass("active");
				}
				else
				{
					$("#at_n").addClass("active");
			    	  $("#at_y").removeClass("active");
			    	  $("#at_y").attr("onclick","attend("+id+",'yes')");
			    	  $("#at_n").attr("disabled","disabled");
				}
			   if(main[0]==1 || main[0]==2){
			   	
				   $('.likeduser').append(main[1]);	
				  
			   }
			   else{
				    $("#user_"+<?php echo @get_authenticateUserID();?>).remove();
				    
				}
		    } 
		    
		
			});
			<?php } else {?>
				$('#loginmodal').modal('show');
			<?php } ?>	
			return false;
	}
	$(document).ready(function() {
		 $(".morelink1").click(function(){
         $("#myModalnew_open1").modal('show');
    });
    
	initialize_map();
	var showChar = 600;  
  // How many characters are shown by default
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
     
     
      var geocoder;
  var map;
     var address ="<?php echo @mysql_real_escape_string($event_detail['address'])." ".@$event_detail['city']." ".@$event_detail['state'];?>";
     
    // var address = 'Welcome Hotel Swimming Pool, Vadiwadi, Vadodara, Gujarat, India';
  function initialize_map() 
  {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var myOptions = {
      zoom: 18,
      center: latlng,
    mapTypeControl: true,
    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
    navigationControl: true,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("gmap_marker"), myOptions);
    if (geocoder) {
      geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
          map.setCenter(results[0].geometry.location);

            var infowindow = new google.maps.InfoWindow(
                { content: '<b>'+address+'</b>',
                  size: new google.maps.Size(150,50)
                });

            var marker = new google.maps.Marker({
                position: results[0].geometry.location,
                map: map, 
                title:address
            }); 
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map,marker);
            });

          } 
         }
      });
    }
   }
</script>



<script>
	
	
    function viewall()
    {
        	$.ajax({
			         type: "POST",
			         url: "<?php echo site_url('event/view_all_likers')?>",
			         data : {id:<?php echo $event_detail['event_id']; ?>},
			         success: function(response) {
			        	 //$('#myModalnew').modal('show');
			        	  $("#myModalnew").html(response);
			        	   $('#myModalnew').on('show.bs.modal', function (e) {
    						}).modal();
			           // alert(response);
			        }
			    });
   } 
   
   
function fbShare(){
	window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('<?php echo site_url('event/detail/'.base64_encode($event_detail['event_id'])); ?>'),'facebook-share-dialog','width=626,height=436');
            return false;
}

function twShare()
{
	var width  = 575,
        height = 400,
        left   = ($(window).width()  - width)  / 2,
        top    = ($(window).height() - height) / 2,
        url    = 'http://twitter.com/share?url=<?php echo site_url('event/detail/'.base64_encode($event_detail['event_id'])); ?>',
        opts   = 'status=1' +
                 ',width='  + width  +
                 ',height=' + height +
                 ',top='    + top    +
                 ',left='   + left;
    
    window.open(url, 'twitter', opts);
 
    return false;
}
function gPlusShare1(url,name)
    		{
		var w=480;var h=380;
		var x=Number((window.screen.width-w)/2);
		var y=Number((window.screen.height-h)/2);
		window.open('https://plus.google.com/share?url='+encodeURIComponent(url)+'&title='+encodeURIComponent(name),'','width='+w+',height='+h+',left='+x+',top='+y+',scrollbars=no');
		  
    	}
    	
    	function piShare()
{
	var width  = 600,
        height = 500,
         left   = ($(window).width()  - width)  / 2,
         top    = ($(window).height() - height) / 2,
        url    = 'http://www.pinterest.com/pin/create/button/?url=<?php echo site_url('event/detail/'.base64_encode($event_detail['event_id'])); ?>&media=<?php echo $img; ?>&description=<?php //echo $bar_detail['bar_desc']; ?>',
        opts   = 'status=1' +
                 ',width='  + width  +
                 ',height=' + height +
                 ',top='    + top    +
                 ',left='   + left;
    
    window.open(url, 'Pinterest', opts);
 
    return false;
}
</script>
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