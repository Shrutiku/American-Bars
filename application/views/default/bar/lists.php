<!-- ########################################################################################### -->



<script type="text/javascript">
    function removetitle()
    {
    	$('.bar_title_new').val('');
    }
	function set_orderby(limit,alpha,option,keyword,offset)
	{
	$('#bar_form').submit();
	}
	function limitsubmit(limit){	
		//window.location.href = '<?php // echo site_url('bar/lists');?>';
		//$('#beer-search-frm').submit();
		 document.getElementById("bar_form").submit();
		
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

<!-- content -->
<div class="wrapper row4">
   		<div class="container clearfix">
   			<div id="" class="carousel slide">
        	<div class="carousel-inner">
          	<div class="active item">
          	  <?php 
          	  
          	  
          	  /* $getimagename = getimagenamebanner();?>	
          	  <?php 
									if($getimagename->find_bar_state==1 && $getimagename->find_bar!="" && is_file(base_path().'upload/bar_pages_banner_orig/'.$getimagename->find_bar)){ ?>
										<img src="<?php echo base_url().'upload/bar_pages_banner/'.$getimagename->find_bar; ?>"   />
									<?php
									} else {?>
            	<img src="<?php echo base_url(); ?>/default/images/smallbanner1.png" alt="American Dive Bars"/>
            	<?php } */ 
            	$getad_banner = '';
            	$getad_banner = getadvertisementBannerSearchBar('find_bar'); 
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
						
						
	     				if($getad_banner && $count<$cnt){ ?>
	     					<?php if(($getad_banner['banner_pages_image']!='' && file_exists(base_path().'upload/banner_pages_thumb/'.$getad_banner['banner_pages_image']))){ ?>
	     						<a target="_blank" <?php if($getad_banner['type']=='click'){?>onclick="add_click_banner('<?php echo $getad_banner['banner_pages_id'];?>');"<?php } ?> href="<?php echo $getad_banner['url']; ?>"><img src="<?php echo base_url().'upload/banner_pages_thumb/'.$getad_banner['banner_pages_image']; ?>" class="img-responsive"/></a>
	     					<?php } ?>	
	     					<?php } else { ?>
		     		 <img src="<?php echo base_url().'upload/banner_pages_thumb/'.$getad_banner['banner_pages_image']; ?>" class="img-responsive"/>
		     			
		     			  <?php } }  else { ?>
		     			  <img src="<?php echo base_url(); ?>/default/images/smallbanner1.png" alt="American Dive Bars"/>
		     			  	<?php } ?>
							
						
				<div class="clearfix"></div>
          </div>
        </div>
        <!-- <a class="left carousel-control" href="#slider-fixed-banner" data-slide="prev">&lsaquo;</a>
        <a class="right carousel-control" href="#slider-fixed-banner" data-slide="next">&rsaquo;</a> -->
       
        <div class="barbox_horizontal clearfix">
              <form class="form-horizontal" id="bar_form" role="form" action="<?php echo site_url("bar/lists") ?>" method="post">
              	   <input type="hidden" value="<?php echo @base64_decode($bar_title_new); ?>" name="bar_title_new" class="bar_title_new" id="bar_title_new" />
                   <div class="form-group">
                       <div class="col-sm-2 input_box">
                           <input type="text" class="form-control form-pad tags" id="bar_title" name="bar_title" value="<?php echo $bar_title; ?>" placeholder="Type Name Here">
                       </div>
                       <div class="col-sm-2 input_box">
                           <input type="text" class="form-control form-pad" id="state" name="state" value="<?php echo $state; ?>" placeholder="Type State Here">
                       </div>
                        <div class="col-sm-2 input_box">
                           <input type="text" class="form-control form-pad" id="city" name="city" value="<?php echo $city; ?>" placeholder="Type City Here">
                       </div>
                       <div class="col-sm-2 input_box">
                           <input type="text" class="form-control form-pad" id="zipcode" name="zipcode" value="<?php echo $zipcode; ?>" placeholder="Type Zip Code Here">
                       </div>
                        <div class="col-sm-2 input_box">
                        	<!-- <a href="#" class="btn btn-lg btn-primary"><i class="strip search"></i></a> -->
                        	
                        	<button type="submit" onclick="removetitle()" class="btn btn-lg btn-primary small-search" value="Search" /><i class="strip search"></i></button>
                       </div>
                   </div>
              
   	</div>
   	</div>
	</div>
  </div>
     <div class="wrapper row5 bar-list">
     	<div class="container">
     		<?php 
     		$getad ='';
			$getadnew = '';
							$classnew = '-full';
							if(($city!='' && $city!='1V1' && $city!='0') || ($zipcode!='' && $zipcode!='1V1' && $zipcode!='0'))
							
							{
						$getad = getadvertisementSearchBar('barlist','top',$city,$zipcode); 
						$getadnew = getadvertisementSearchBar('barlist','bottom',$city,$zipcode);
					if($getad || $getadnew){
						$classnew = '';
					}
							}
					?>
     	   <div class="left_block<?php echo $classnew; ?> new-search">
     		<div class="result_search">
     			<div class="col-sm-4">
	     			<!-- <div class="result_search_text pull-left"><?php echo $total_rows;?> Results Found</div> -->
	     			<?php  if(($bar_title_new !='' && $bar_title_new !='1V1') || $bar_title !='' || $city !='' || $state !='' || $zipcode !=''){ ?>
	     			<div class="result_search_text pull-left">Search Result for <?php if($bar_title !=''){ echo $bar_title; } if($bar_title!='' && ($state!='' || $city!='' || $zipcode!='')){ echo ", "; } if($state !=''){ echo $state; }; if($state!='' && $city && ($city!='' || $bar_title!='' || $zipcode!='')){ echo ", "; } if($city !=''){ echo $city; }; if(($state!='' && $zipcode) || ($city!='' && $zipcode) && ($state!='' || $bar_title!='' || $zipcode!='')){ echo ", "; } if($zipcode !=''){ echo $zipcode; } if($bar_title_new!=''){ echo base64_decode($bar_title_new);};?></div>
	     			<?php } ?>
	            </div>
     			<div class="col-sm-8">
     				<!-- <form class="form-horizontal" id="bar-search-frm" method="post" role="form" action="<?php echo site_url("bar/lists"); ?>"> -->
	                   <div class="form-group pull-right">
	                   	<a class="review text-center" data-toggle="modal" href="javascript://" onclick="openSug()">Help Us Find Bars!</a>
	                   		<label for="inputEmail3" class="control-label">Results Per Page :</label>
	                   		<select class="select_box" name="limit" id="limit" onchange="limitsubmit('<?php echo $limit ?>')">
								<option value="10" <?php if($limit == "10"){?> selected= "selected" <?php } ?>>10</option>
								<option value="20" <?php if($limit == "20"){?> selected= "selected" <?php } ?>>20</option>
		                       	<option value="30" <?php if($limit == "30"){?> selected= "selected" <?php } ?>>30</option>
		                       	<option value="50" <?php if($limit == "50"){?> selected= "selected" <?php } ?>>50</option>
		                       	<option value="100" <?php if($limit == "100"){?> selected= "selected" <?php } ?>>100</option>  	<!-- <option value="1">fds</option>
		                       	<option value="2">dsadfds</option> -->
	                        </select>
	                  
	                   		<label for="inputEmail3" class="control-label">Sort By :</label>
	                   		 <select class="select_box" name="order_by" id="order_by" onchange="set_orderby('<?php echo $limit;?>','<?php echo @$alpha;?>','<?php echo $options;?>','<?php echo @$keyword;?>','<?php echo $offset; ?>')">
	                           	<option value="" >Sort By:</option>
	                           	<option value="bar_title#ASC" <?php if($order_by == "bar_title#ASC"){ ?> selected="selected" <?php } ?>>Name A-Z</option>
	                           	<option value="bar_title#DESC" <?php if($order_by == "bar_title#DESC"){ ?> selected="selected" <?php } ?> >Name Z-A</option>
	                           	<option value="city#ASC" <?php if($order_by == "city#ASC"){ ?> selected="selected" <?php } ?>>City A-Z</option>
	                           	<option value="city#DESC" <?php if($order_by == "city#DESC"){ ?> selected="selected" <?php } ?>>City Z-A</option>
	                           	<option value="state#ASC" <?php if($order_by == "state#ASC"){ ?> selected="selected" <?php } ?>>State A-Z</option>
	                           	<option value="state#DESC" <?php if($order_by == "state#DESC"){ ?> selected="selected" <?php } ?>>State Z-A</option>
	                         </select>
	                    </div>      
	                <!-- </form> -->
	              </div>
	              <div class="clearfix"></div>
     		</div>
     		</form>
     		<div class="pagination">
				<ul class="pagination">
					<?php echo $page_link; ?>
				</ul>
     		</div>
     		<div class="clearfix"></div>
     		<div class="result_box clearfix bar_list">
     			<ul class="result_sub_box">
					<?php if($result){
				  			foreach($result as $rs)
	  				{
	  					
	  					
	  					?>
	         			<li class="active  <?php if($rs->bar_type=='full_mug'){ ?>fullmug-bg<?php } ?>">
	         			<div class="media">
						    <a class="pull-left" href="<?php echo site_url("bar/details/".$rs->bar_slug);?>">
							<?php 
									if($rs->bar_logo!="" && is_file(base_path().'upload/barlogo_thumb/'.$rs->bar_logo)){ ?>
										<img src="<?php echo base_url().'upload/barlogo_thumb/'.$rs->bar_logo; ?>"  />
									<?php
									}
									else{?>
									<img height="119" width="120" src="<?php echo base_url().'upload/barlogo/no_image.png'; ?>" />
							<?php } ?>
						    </a>
						    <div class="media-body">
						       <div class="reult_sub_title"><h4 class="media-heading bar-newname"><p><a href="<?php echo site_url("bar/details/".$rs->bar_slug);?>" class="listing-title mar_r5"><?php echo $rs->bar_title; ?></a> <a href="javascript://" class="btn btn-lg btn-primary" onclick="loadMap('<?php echo $rs->bar_id;?>')">Get Directions</a></p></h4>
						       	<div class="clearfix"></div>
							       	<div class="result_desc mar_top5">
							       	<div> <!-- class="bar-listnew" -->
							       		
							       		<?php if(strip_tags(strlen($rs->bar_desc)>115)){ echo substr(strip_tags($rs->bar_desc),0,115).'...' ; } else { echo strip_tags($rs->bar_desc); } ?>
							       	</div>
							       	 <div class="clearfix"></div>
							       </div> 
							       <div class="clearfix"></div>
							       <div class="padt8">
						        	<div><p class="result_date"><i class="strip address-gray"></i> <?php echo $rs->address.', '.$rs->city.', '.$rs->state.' '.$rs->zipcode; ?></p></div>
						        	<p class="result_date"><?php if($rs->phone!=''){?><i class="strip phone-gray"></i> <?php }?><?php echo $rs->phone;?></p>
		    		 				<div class="clearfix"></div>
						        </div>
						       	
						       </div>
						       <div class="rating_box text-right">
						       	        <div class="fullmug-img"><!-- class="mug-img" -->
						       	<?php if($rs->bar_type=='full_mug'){ ?> 
						        		<img title="Full Mug Bar" src="<?php echo base_url().'default/images/full-mug.png'; ?>" />
						        		<?php } else {  ?> 
									   <img title="Half Mug Bar" src="<?php echo base_url().'default/images/half-mug.png'; ?>" />
                                   <?php }?>
                </div>  
                <!-- <div class='clear'></div> -->
						       	        <!-- <p class="result_date pull-left marr_10"><?php if($rs->phone!=''){?><i class="strip phone-gray"></i> <?php }?><?php echo $rs->phone;?></p> -->
	  									<div class="rating_img"><div  id="ratedli-<?php echo $rs->bar_id; ?>"><?php echo getReviewRating($rs->bar_id); ?></div></div>
	  									<ul class="social_icon"><span style="float: left; margin-top: 7px; font-size: 14px;">Share Bar:</span>
									<?php
									$u = base_url().'bar/details/'.$rs->bar_slug;
									$url_share = site_url("upload/barlogo/".base64_encode($rs->bar_logo)) ;
									$url=urlencode($url_share);
									$image=urlencode(base_url().'upload/barlogo/no_image.png');
									if($rs->bar_logo != "" && is_file(base_path()."upload/barlogo/".$rs->bar_logo))
									{
										$image=urlencode(base_url().'upload/barlogo/'.$rs->bar_logo); 
									}?> 					
										<li><a onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo mysql_real_escape_string($rs->bar_title);?>&amp;p[summary]=<?php echo mysql_real_escape_string(strip_tags($rs->bar_desc));?>&amp;p[url]=<?php echo $u; ?>&amp;p[images][0]=<?php echo $image;?>','sharer','toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)"><img src="<?php echo base_url();?>default/images/result_fb.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_fb-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_fb.png'"/></a></li>
			  							<li><a href="javascript:void(0)" onclick="window.open('http://twitter.com/home?status=<?php echo $u;?>','sharer','toolbar=0,status=0,width=548,height=325')"><img src="<?php echo base_url();?>default/images/result_twitt.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_twitt-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_twitt.png'"/></a></li>
	  									<li><a href="javascript:void(0)" onclick="window.open('https://plusone.google.com/_/+1/confirm?hl=en&url=<?php echo $u;?>','sharer','toolbar=0,status=0,width=548,height=325')"><img src="<?php echo base_url();?>default/images/result_google.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_google-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_google.png'" /></a></li>
	  									<li><a  href="javascript://" onclick="piShare('<?php echo $image;?>','<?php echo $rs->bar_slug;?>')"><img src="<?php echo base_url().'default'?>/images/result_p.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_p-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_p.png'"></a></li>
		    		 				</ul>
		    		 				
	  									<div class="clearfix"></div>
							   </div>
						       <div class="clearfix"></div>
						      
						        <div class="padt8 pull-right new-btngroup">
						        	<a href="javascript://" onclick="getreportbar('<?php echo $rs->bar_id; ?>')" class="btn btn-lg btn-primary">Wrong Address/Closed? : REPORT</a>
						        	<?php 
						        	
						        	if(($rs->owner_id=='' || $rs->owner_id==0) && $rs->claim=='unclaimed'  && get_authenticateUserID()==''){?>
                                                                <a href="<?php echo site_url('home/claim_bar_owner_register/'.base64_encode('1V1').'/1V1/'.base64_encode($rs->bar_id));?>" style="background-color: #4CAF50;" class="btn"><b>Claim This Bar</b></a>
						        	<?php } ?>	
						        	
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
							if(($city!='' && $city!='1V1' && $city!='0') || ($zipcode!='' && $zipcode!='1V1' && $zipcode!='0'))
							
							{
						$getad = getadvertisementSearchBar('barlist','top',$city,$zipcode); 
						$getadnew = getadvertisementSearchBar('barlist','bottom',$city,$zipcode);
					if($getad || $getadnew){
						 ?>
     		<div class="right_block coctail-new">
     			<div class="mar_top20 advertise-div">
							<?php 
							$getad = '';
							if(($city!='' && $city!='1V1' && $city!='0') || ($zipcode!='' && $zipcode!='1V1' && $zipcode!='0'))
							
							{
						$getad = getadvertisementSearchBar('barlist','top',$city,$zipcode); 
						//print_r($getad);
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
						<div class="mar_top20 advertise-div-right">
							<?php 
							$getadnew = '';
							if(($city!='' && $city!='1V1' && $city!='0') || ($zipcode!='' && $zipcode!='1V1' && $zipcode!='0'))
							{
						$getadnew = getadvertisementSearchBar('barlist','bottom',$city,$zipcode); 
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
							
							$array1 = array('total_visit'=>$getad_newsec['total_visit']+1);
							$this->db->where('advertisement_id',$getad_newsec['advertisement_id']);
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


<script type="text/javascript">
	$(document).ready(function(){
	$("#bar_form").validate({
		rules: {			
			state: {
				lettersspaceonly:true,
			},	
			
			city: {
				lettersspaceonly:true,
				
			},	
			zipcode:
			{
				number:true,
			}
						
		  //	errorClass:'error fl_right'			
		}
	});	
});
</script>



<script src="https://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
<div class="modal fade login_pop2" id="getreportbar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
					</div>
<div class="modal fade login_pop2" id="mapmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
					</div>	
					
					
<script>
 
    function getreportbar(id)
	{
		 $.ajax({
	       type: "POST",
		   url: "<?php  echo site_url('bar/getbarreportajax')?>",
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
		   	
		    	
		     
	   });
	}
	
	function loadMap(id)
	{
		 $.ajax({
	       type: "POST",
		   url: "<?php  echo site_url('bar/getmapajax')?>",
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
</script>
  	<script>
  	
function piShare(img,slug)
{
	var width  = 600,
        height = 500,
         left   = ($(window).width()  - width)  / 2,
         top    = ($(window).height() - height) / 2,
        url    = 'http://www.pinterest.com/pin/create/button/?url=<?php echo site_url('bar/lists/'); ?>'+slug+'&media='+img+'&description=<?php //echo $bar_detail['bar_desc']; ?>',
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
			
		  // window.location.href = '<?php echo current_url();?>'; 
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
