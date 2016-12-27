<!-- ########################################################################################### -->


<script type="text/javascript">
	function set_orderby(limit,alpha,option,keyword,offset)
	{
	$('#beer-search-frm').submit();
	}
	function limitsubmit(){	
		$('#beer-search-frm').submit();
	}
	function searchmodal_taxi()
	{
		$("#searchmodal_taxi").modal('show');
		 
	}
</script>
<?php
$theme_url = $urls= base_url().getThemeName();
?>
<!-- <script type="text/javascript" src="<?php echo base_url(); ?>jwplayer/jwplayer.js"></script> -->
<script type="text/javascript">

$(document).ready(function(){
	$("#limit").change(function(){
			$("#bar_form").submit();
	});
	
	$("#order_by").change(function(){
			$("#bar_form").submit();
	});
	
	
});
	
</script>
<div class="modal fade login_pop2" id="searchmodal_taxi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	  <?php echo $this->load->view(getThemeName().'/home/searchbox_taxi');?>	
</div>
<!-- content -->
<div class="wrapper row4">
   		<div class="container clearfix">
   			<div id="" class="carousel slide">
        	<div class="carousel-inner">
          	<div class="active item">
          	  <?php /* $getimagename = getimagenamebanner();?>	
          	  <?php 
									if($getimagename->taxi_directory_state==1 && $getimagename->taxi_directory!="" && is_file(base_path().'upload/bar_pages_banner_orig/'.$getimagename->taxi_directory)){ ?>
										<img src="<?php echo base_url().'upload/bar_pages_banner/'.$getimagename->taxi_directory; ?>"   />
									<?php
									} else {?>
            	<?php } */
            	$v=0;
          $getad_banner = '';
            	$getad_banner = getadvertisementBannerSearchBar('find_taxi'); 
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
       
        <!-- <div class="barbox_horizontal clearfix">
              <form class="form-horizontal" id="bar_form" role="form" action="<?php echo site_url("taxiowner/lists") ?>" method="post">
                   <div class="form-group">
                       <div class="col-sm-2 input_box">
                           <input type="text" class="form-control form-pad" id="first_name" name="first_name" value="<?php echo $first_name; ?>" placeholder="Type Name Here">
                       </div>
                        <div class="col-sm-2 input_box">
                        	<button type="submit" class="btn btn-lg btn-primary" value="Search" /><i class="strip search"></i></button>
                       </div>
                   </div>
              
   	</div> -->
   	</div>
	</div>
  </div>
     <div class="wrapper row5 taxi-list"  style="border:<?php echo $v==0 ? 'none':'';?>">
     	<div class="container">
     		<?php 
							$getad = '';
							$getadnew = '';
							$classnew = '-full';
							if($keyword!='' && $keyword!='1V1' && $keyword!='0')
							
							{
								
						$getad = getadvertisementSearch('taxilist','top',$keyword); 
						$getadnew = getadvertisementSearch('taxilist','bottom',$keyword); 
					if($getad || $getadnew){
						
						$classnew = '';
						
					}
							}
							
						 ?>
						 
     		<div class="left_block<?php echo $classnew;?> beer-list">
     		<form class="form-horizontal" id="beer-search-frm" method="post" role="form" action="<?php echo site_url("taxiowner/lists"); ?>">
     		<div class="result_search beer-search">
     			<div class="col-sm-7">
	     			<?php if($keyword!='' && $keyword!='0'){?>
						<div class="result_search_text pull-left">Search Result for <?php echo htmlentities($keyword); ?></div>
						<?php }  ?>
						<?php  if($taxi_title !='' || $city_taxi !='' || $state_taxi !='' || $zipcode_taxi !=''){ ?>
	     			<div class="result_search_text pull-left">Search Result for <?php if($taxi_title !=''){ echo $taxi_title; } if($taxi_title!='' && ($state_taxi!='' || $city_taxi!='' || $zipcode_taxi!='')){ echo ", "; } if($state_taxi !=''){ echo $state_taxi; }; if($state_taxi!='' && $city_taxi && ($city_taxi!='' || $taxi_title!='' || $zipcode_taxi!='')){ echo ", "; } if($city_taxi !=''){ echo $city_taxi; }; if($city_taxi!='' && $zipcode_taxi && ($state_taxi!='' || $taxi_title!='' || $zipcode_taxi!='')){ echo ", "; } if($zipcode_taxi !=''){ echo $zipcode_taxi; } ?></div>
	     			<?php } ?>
	            </div>
     			<div class="col-sm-5">
     				<!-- <form class="form-horizontal" id="bar-search-frm" method="post" role="form" action="<?php echo site_url("bar/lists"); ?>"> -->
	                   <div class="form-group pull-left">
	                   		<label for="inputEmail3" class="control-label">Results Per Page :</label>
	                   		<select class="select_box" name="limit" id="limit" onchange="limitsubmit();">
								
								<option value="20" <?php if($limit == "20"){?> selected= "selected" <?php } ?>>20</option>
		                       	<option value="30" <?php if($limit == "30"){?> selected= "selected" <?php } ?>>30</option>
		                       	<option value="10" <?php if($limit == "40"){?> selected= "selected" <?php } ?>>40</option>
		                       		<option value="50" <?php if($limit == "50"){?> selected= "selected" <?php } ?>>50</option> 
		                       		<option value="100" <?php if($limit == "100"){?> selected= "selected" <?php } ?>>100</option> 
	                        </select>
	                   </div>
	                   <div class="form-group  pull-right">
	                   		<label for="inputEmail3" class="control-label">Sort By :</label>
	                   		 <select class="select_box" name="order_by" id="order_by" onchange="set_orderby('<?php echo $limit;?>','<?php echo $offset; ?>')">
	                           	<option value="" >-- Select By --</option>
	                           	<option value="taxi_company#ASC" <?php if($order_by == "taxi_company#ASC"){ ?> selected="selected" <?php } ?>>Company Name A-Z</option>
	                           	<option value="taxi_company#DESC" <?php if($order_by == "taxi_company#DESC"){ ?> selected="selected" <?php } ?> >Company Name z-A</option>
	                         </select>
	                   </div>
	                <!-- </form> -->
	              </div>
	              <div class="clearfix"></div>
	             </div> 
	              <!-- <div class="alphabate_block">
					<ul class="alphabate_list">
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("a")); ?>" <?php if($alpha == "a"){ ?> class="active" <?php }?>>a</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("b")); ?>" <?php if($alpha == "b"){ ?> class="active" <?php }?>>b</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("c")); ?>" <?php if($alpha == "c"){ ?> class="active" <?php }?>>c</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("d")); ?>" <?php if($alpha == "d"){ ?> class="active" <?php }?>>d</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("e")); ?>" <?php if($alpha == "e"){ ?> class="active" <?php }?>>e</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("f")); ?>" <?php if($alpha == "f"){ ?> class="active" <?php }?>>f</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("g")); ?>" <?php if($alpha == "g"){ ?> class="active" <?php }?>>g</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("h")); ?>" <?php if($alpha == "h"){ ?> class="active" <?php }?>>h</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("i")); ?>" <?php if($alpha == "i"){ ?> class="active" <?php }?>>i</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("j")); ?>" <?php if($alpha == "j"){ ?> class="active" <?php }?>>j</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("k")); ?>" <?php if($alpha == "k"){ ?> class="active" <?php }?>>k</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("l")); ?>" <?php if($alpha == "l"){ ?> class="active" <?php }?>>l</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("m")); ?>" <?php if($alpha == "m"){ ?> class="active" <?php }?>>m</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("n")); ?>" <?php if($alpha == "n"){ ?> class="active" <?php }?>>n</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("o")); ?>" <?php if($alpha == "o"){ ?> class="active" <?php }?>>o</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("p")); ?>" <?php if($alpha == "p"){ ?> class="active" <?php }?>>p</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("q")); ?>" <?php if($alpha == "q"){ ?> class="active" <?php }?>>q</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("r")); ?>" <?php if($alpha == "r"){ ?> class="active" <?php }?>>r</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("s")); ?>" <?php if($alpha == "s"){ ?> class="active" <?php }?>>s</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("t")); ?>" <?php if($alpha == "t"){ ?> class="active" <?php }?>>t</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("u")); ?>" <?php if($alpha == "u"){ ?> class="active" <?php }?>>u</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("v")); ?>" <?php if($alpha == "v"){ ?> class="active" <?php }?>>v</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("w")); ?>" <?php if($alpha == "w"){ ?> class="active" <?php }?>>w</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("x")); ?>" <?php if($alpha == "x"){ ?> class="active" <?php }?>>x</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("y")); ?>" <?php if($alpha == "y"){ ?> class="active" <?php }?>>y</a></li>
						<li><a href="<?php echo site_url("taxiowner/lists/".$limit."/".base64_encode("z")); ?>" <?php if($alpha == "z"){ ?> class="active" <?php }?>>z</a></li>
						<div class="clearfix"></div>
					</ul>
					
				</div><div class="clearfix"></div> -->
     		<div class="advance-block padt10">
						   <div class="form-group">
							   <div class="col-sm-5 padding-right-0 input_box pull-left">
								   <input type="text" class="form-control form-pad" id="keyword" name="keyword" placeholder="Search by company name, city, state and zipcode" value="<?php echo $keyword; ?>">
								   <input type="hidden" name="alpha" id="alpha" value="<?php echo $alpha; ?>" />
							   </div>
							   <div class="col-sm-2 input_box pull-left">
									<button class="btn btn-lg small btn-primary small-search"><i class="strip search"></i></button>
							   </div>
							   <a class="btn btn-lg btn-primary pull-left advance-search" onclick="searchmodal_taxi()" href="javascript://">Advanced Search</a>
							   <div class="clearfix"></div>
							</div>
					</div>
     		</form>
     		
     		
     		<div class="pagination">
				<ul class="pagination">
					<?php echo $page_link; ?>
				</ul>
     		</div>
     		<div class="clearfix"></div>
     		<div class="result_box liquor-box clearfix">
     			<ul class="result_sub_box">
					<?php if($result){
				  			foreach($result as $rs)
	  				{?>
	         			<li class="active">
	         			<div class="media">
						    <a class="pull-left" href="<?php echo site_url("taxiowner/details/".base64_encode($rs->taxi_id));?>">
							<?php 
									if($rs->taxi_image!="" && is_file(base_path().'upload/user_thumb/'.$rs->taxi_image)){ ?>
										<img src="<?php echo base_url().'upload/user_thumb/'.$rs->taxi_image; ?>"  />
									<?php
									}
									else{?>
									<img height="119" width="120" src="<?php echo base_url().'upload/taxi_thumb/no_image.png'; ?>" />
							<?php } ?>
						    </a>
                            <div class="pull-left btn btn-lg btn-primary text-center full-detail-btn"><a href="<?php echo site_url("taxiowner/details/".base64_encode($rs->taxi_id));?>">Full Details</a></div>
						    <div class="media-body">
						       <div class="reult_sub_title"><h4 class="media-heading"><a href="<?php echo site_url("taxiowner/details/".base64_encode($rs->taxi_id));?>" class="listing-title first_name"><?php echo ucwords($rs->taxi_company); ?></a> </h4></div>
						       <!-- <div class="rating_box">
	  									<div id="ratedli-<?php echo $rs->bar_id; ?>"><?php echo getReviewRating($rs->bar_id); ?></div>
							   </div> -->
						       <div class="clearfix"></div>
						       <div class="result_desc" >
						       	<div class="pull-left" >
						       			<?php if(strip_tags(strlen($rs->taxi_desc)>350)){ echo substr(strip_tags($rs->taxi_desc),0,350).'...' ; } else { echo strip_tags($rs->taxi_desc); } ?>
						       	</div>
						         <div class='clear'></div>
						       </div> 
						        <div class="padt8">
						        	<div class="reult_sub_title"><p class="result_date pull-left"><?php echo $rs->address."<br> ".$rs->city.", ".$rs->state." ".$rs->cmpn_zipcode; ?></p></div>
		    		 				<div class="clearfix"></div>
						        </div>
						        
						         <div class="padt8 new-btngroup newtaxi-btn">
						        	<a href="javascript://" onclick="getreportbar('<?php echo $rs->taxi_id; ?>')" class="btn btn-lg btn-primary">Report This Taxi Company</a>
						        </div> 	
						        
						        
						    </div>
				    	</div>
				    	<div class="clearfix"></div>
	         		</li>
					<?php
						}
					}?>
	         	</ul>
     		</div>
     		<div>
     			<!-- <div class="pull-left padt15">
     				<a href="#" class="btn btn-lg btn-primary">Submit Your Bar</a>
     			</div> -->
     			<div class="pagination">
	     			<ul class="pagination">
						<?php echo $page_link; ?>
					</ul>
     			</div>
     			<div class="clearfix"></div>
     		</div>
     		</div>
     		<?php 
							$getad = '';
							$getadnew = '';
							if($keyword!='' && $keyword!='1V1' && $keyword!='0')
							
							{
						$getad = getadvertisementSearch('taxilist','top',$keyword); 
						$getadnew = getadvertisementSearch('taxilist','bottom',$keyword); 
					if($getad || $getadnew){
						 ?>
     		<div class="right_block">
					    
						<div class="advertise-div">
							<?php 
							$getad = '';
							if($keyword!='' && $keyword!='1V1' && $keyword!='0')
							{
						$getad = getadvertisementSearch('taxilist','top',$keyword); 
							}
						if($getad){
	     				$count = getadvertisementByIDCount(@$getad['advertisement_id'],$getad['type']);
						if($getad['type']=='click')
						{
							$cnt = $getad['number_click'];
						}
						else
						{
							$cnt = $getad['number_visit'];
						}
						$getad_new = getadvertisementByID(@$getad['advertisement_id'],'visit');
		
						if(($getad_new==0 || $getad_new<5) && $count<$cnt && $getad['type']=='visit')
						{
							$array = array('ip'=>$_SERVER['REMOTE_ADDR'],'datetime'=>date('Y-m-d H:i:s'),'advertisement_id'=>$getad['advertisement_id'],'click_type'=>'visit');
							$this->db->insert('count_clcik_advertisement',$array);
							
							$array1 = array('total_visit'=>$getad['total_visit']+1);
							$this->db->where('advertisement_id',$getad['advertisement_id']);
							$this->db->update('advertisement_master',$array1);
						}
	     				if($getad && $count<$cnt){ ?>
	     					<?php if(($getad['advertisement_image']!='' && file_exists(base_path().'upload/advertisement_thumb/'.$getad['advertisement_image']))){ ?>
	     						<a target="_blank" <?php if($getad['type']=='click'){?>onclick="add_click('<?php echo $getad['advertisement_id'];?>');"<?php } ?> href="<?php echo $getad['url']; ?>"><img src="<?php echo base_url().'upload/advertisement_thumb/'.$getad['advertisement_image']; ?>" class="img-responsive"/></a>
	     					<?php } ?>	
	     					<?php } else {?>
		     		<img src="<?php echo base_url(); ?>/upload/adv.png" class="img-responsive"/>
		     			
		     			  <?php } } else { ?>
		     			  	
		     			  	<!-- <img src="<?php echo base_url(); ?>/upload/adv.png" class="img-responsive"/> -->
		     			  	
		     			  	<?php } ?>
							
				</div>
				
				<div class="advertise-div-right mar_top20">
							<?php 
							$getadnew = '';
							if($keyword!='' && $keyword!='1V1' && $keyword!='0')
							{
						$getadnew = getadvertisementSearch('taxilist','bottom',$keyword); 
							}
						if($getadnew){
	     				$countsec = getadvertisementByIDCount(@$getadnew['advertisement_id'],$getadnew['type']);
						if($getadnew['type']=='click')
						{
							$cntsec = $getadnew['number_click'];
						}
						else
						{
							$cntsec = $getadnew['number_visit'];
						}
						$getad_newsec = getadvertisementByID(@$getadnew['advertisement_id'],'visit');
		
		   
						if(($getad_newsec==0 || $getad_newsec<5) && $countsec<$cntsec && $getadnew['type']=='visit')
						{
							$array = array('ip'=>$_SERVER['REMOTE_ADDR'],'datetime'=>date('Y-m-d H:i:s'),'advertisement_id'=>$getadnew['advertisement_id'],'click_type'=>'visit');
							$this->db->insert('count_clcik_advertisement',$array);
							
							$array1 = array('total_visit'=>$getadnew['total_visit']+1);
							$this->db->where('advertisement_id',$getadnew['advertisement_id']);
							$this->db->update('advertisement_master',$array1);
						}
	     				if($getadnew && $countsec<$cntsec){ ?>
	     					<?php if(($getadnew['advertisement_image']!='' && file_exists(base_path().'upload/advertisement_thumb/'.$getadnew['advertisement_image']))){ ?>
	     						<a target="_blank" <?php if($getadnew['type']=='click'){?>onclick="add_click('<?php echo $getadnew['advertisement_id'];?>');"<?php } ?> href="<?php echo $getadnew['url']; ?>"><img src="<?php echo base_url().'upload/advertisement_thumb/'.$getadnew['advertisement_image']; ?>" class="img-responsive"/></a>
	     					<?php } ?>	
	     					<?php } else {?>
		     		<img src="<?php echo base_url(); ?>/upload/adv.png" class="img-responsive"/>
		     			
		     			  <?php } } else { ?>
		     			  	<!-- <img src="<?php echo base_url(); ?>/upload/adv.png" class="img-responsive"/> -->
		     			  	<?php } ?>
							
				</div>
				<div class="clearfix"></div>
			</div>
			<?php } } ?>
   		</div>
   	</div>
<!-- ########################################################################################### -->
<div class="modal fade login_pop2" id="getreportbar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
					   
					</div>

<script type="text/javascript">

 function getreportbar(id)
	{
		 $.ajax({
	       type: "POST",
		   url: "<?php  echo site_url('taxiowner/gettaxireportajax')?>",
		   data: {id:id},
		   dataType : 'html',
		     beforeSend : function() {
		   		$('#dvLoading').fadeIn('slow');
		   },
		    complete : function() {
		   		$('#dvLoading').fadeOut('slow');
		   },		
		   success: function(response) {
		   	     $("#getreportbar").modal('show');
		   		$("#getreportbar").html(response);
		   		
						}
		   	
		    //$('#mapmodal').one('show.bs.modal', function (e) {
		    	//$('#myModalnew').one('shown.bs.modal', function (e) {
		    	
		     
	   });
	}
	$(document).ready(function(){
	$("#bar_form").validate({
		rules: {			
			state: {
				lettersspaceonly:true,
			},	
			
			city: {
				lettersspaceonly:true,
				
			},	
						
		  //	errorClass:'error fl_right'			
		}
	});	
});
</script>

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