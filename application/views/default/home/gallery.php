<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/pgwslideshow.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/css/pgwslideshow.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/css/pgwslideshow_light.css" />
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<style>
	.ps-current 
	{
		/*max-height:470px !important; */
	}
</style>
<script type="text/javascript">
	$(document).ready(function(){
//===== Usual validation engine=====//
	$("#frm_login").validate({
		rules: {			
			email: {
				required: true,
				email: true
			},			
			password: {
				required: true,
				
			},				
		  	errorClass:'error fl_right'			
		}
	});	
});
</script>
<!-- ########################################################################################### -->
<!-- content -->
<div class="wrapper row4">
   		<div class="container clearfix">
   			<div id="slider-fixed-banner" class="carousel slide">
        	<div class="carousel-inner">
          	<div class="active item">
            	 <?php /* $getimagename = getimagenamebanner();?>	
          	  <?php 
									if($getimagename->photo_gallery_state==1 && $getimagename->photo_gallery!="" && is_file(base_path().'upload/bar_pages_banner_orig/'.$getimagename->photo_gallery)){ ?>
										<img src="<?php echo base_url().'upload/bar_pages_banner/'.$getimagename->photo_gallery; ?>"   />
									<?php
									} else {?>
            	<?php } */ 
            			$v=0;
          $getad_banner = '';
            	$getad_banner = getadvertisementBannerSearchBar('find_gallery'); 
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
<div class="wrapper row5"  style="border:<?php echo $v==0 ? 'none':'';?>">
     	<div class="container">
     		<div class="gallery_block">
     		<div class="result_search">
     			<div class="col-sm-8">
	     			<div class="result_search_text pull-left">Photo Gallery</div>
	            </div>
	            <div class="col-sm">
     				<!-- <form class="form-horizontal" id="bar-search-frm" method="post" role="form" action="<?php echo site_url("bar/lists"); ?>"> -->
	                   <div class="form-group pull-right">
	                   	<a class="review text-center" data-toggle="modal" href="javascript://" onclick="openSug()">Help Us Find Bars!</a>
	                    </div>      
	                <!-- </form> -->
	              </div>
	            <div class="clearfix"></div>
     		</div>
     		
     		
     		
     		
     		
     		<div class="pad20 br_bott_yellow">
     			<div class="padtb10">
     				<?php if($gallery)
     				      {
     				      foreach($gallery as $row){
     				     $getimagename123 = getimagename_gal($row->bar_gallery_id);
							$getimagenameorig123 = getimagenameorig_gal($row->bar_gallery_id); 	
							   ?>
				<a href="javascript://" onclick="opengallery('<?php echo $row->bar_gallery_id; ?>')">
												
													
     				<div class="col-md-3 col-sm-4 padb20">
				       <div class="gallery_br_white">
				       		<i class="strip zoom"></i>
				       		<img src="<?php echo $getimagename123; ?>" class="img-responsive" />
				       		<div class="gallery_img_caption">
				       			<div><?php echo ucwords($row->title);?></div>
				       			<!-- <div><?php echo $row->event_desc; if(strlen($row->event_desc > 40)){
									 echo substr($row->event_desc, 0 ,40) ; } else { echo $row->event_desc; }?></div> -->
							<!-- <div><?php if(strlen(strip_tags($row->event_desc)) > 30) { echo substr($row->event_desc, 0 ,30);  }?></div>	 -->	 
				       		</div>
				       </div> 
        			</div><!-- /.col-lg-3 -->
        			</a>	
        			<?php } } else {?>
        				 No events found .
        			<?php } ?>
        			<div class="clearfix"></div>
     			</div>
     		</div>
     		
     		<div class="pad20 br_bott_yellow">
     			<h1 class="cont_desc mar_left13">Bar Postcards</h1>
     			<div class="padtb10">
     				<?php if($barpostcard)
     				      {
     				      foreach($barpostcard as $row){
     				      	$getimagename = getimagenamegal($row->bar_gallery_id);
							$getimagenameorig = getimagenameoriggal($row->bar_gallery_id);
     				      	  ?>
				<a href="<?php echo $getimagenameorig; ?>" title="<?php echo $row->title;?>" data-rel="fancybox-button" class="fancybox-button">
												
													
     				<div class="col-md-3 col-sm-4 padb20">
				       <div class="gallery_br_white">
				       		<i class="strip zoom"></i>
				       		<img src="<?php echo $getimagename; ?>" class="img-responsive" />
				       		<div class="gallery_img_caption">
				       			<div><?php echo $row->title;?></div>
				       			<!-- <div><?php if(strlen($row->description > 40)){ echo substr($row->description, 0 ,40) ; } else { echo $row->description; }?></div> -->
				       		</div>
				       </div> 
        			</div><!-- /.col-lg-3 -->
        			</a>	
        			<?php } } else {?>
        				 No postcard found .
        			<?php } ?>
        			<div class="clearfix"></div>
     			</div>
     		</div>
     		</div>
   		</div>
   	</div>
   	

<div class="modal fade" id="myModalnew_ajax" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
<!-- ************************************************************************ -->
<script src="<?php echo base_url().getThemeName(); ?>/assets/scripts/gallery.js"></script>
<script>
		$(document).ready(function(){
			<?php if($id!=''){?>
			opengallery(<?php echo $id; ?>)
			<?php } ?>	
			
			});
function opengallery(id)
{
	  $.ajax({
			         type: "POST",
			         url: "<?php echo site_url('bar/getAllGalAjax')?>",
			         data : {id:id},
			         beforeSend : function(){
			      $('#dvLoading').fadeIn('slow');
			   },
			   complete: function(){
			     $('#dvLoading').fadeOut('slow');
			   },
			         success: function(response) {
			           
			           			           	 //$('#myModalnew_ajax').on('show.bs.modal', function (e) {
			           	 $('#myModalnew_ajax').one('show.bs.modal', function (e) {
			           	 	$("#myModalnew_ajax").empty();
			           	 	$("#myModalnew_ajax").html(response);
			           	 	    $('.pgwSlideshow').pgwSlideshow(); 
    						 }).modal();
			           	 
			           	 
			           // alert(response);
			        }
			    });
			    
			   
	
}

	</script>


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