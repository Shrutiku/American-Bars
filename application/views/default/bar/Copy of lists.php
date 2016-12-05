<!-- ########################################################################################### -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/jquery.tagsinput.css" />
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="<?php echo base_url().getThemeName();?>/js/jquery.tagsinput.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>

<script type="text/javascript">
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
	
		$('.tags').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('bar/auto_suggest_bar/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									label: item.label,
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		      
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
          	  <?php $getimagename = getimagenamebanner();?>	
          	  <?php 
									if($getimagename->find_bar!="" && is_file(base_path().'upload/bar_pages_banner_orig/'.$getimagename->find_bar)){ ?>
										<img src="<?php echo base_url().'upload/bar_pages_banner/'.$getimagename->find_bar; ?>"   />
									<?php
									} else {?>
            	<img src="<?php echo base_url(); ?>/default/images/smallbanner1.png" alt="American Dive Bars"/>
            	<?php } ?>
          </div>
        </div>
        <!-- <a class="left carousel-control" href="#slider-fixed-banner" data-slide="prev">&lsaquo;</a>
        <a class="right carousel-control" href="#slider-fixed-banner" data-slide="next">&rsaquo;</a> -->
       
        <div class="barbox_horizontal clearfix">
              <form class="form-horizontal" id="bar_form" role="form" action="<?php echo site_url("bar/lists") ?>" method="post">
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
                       <!-- <div class="col-sm-2 input_box">
                           <input type="text" class="form-control form-pad" id="zipcode" name="zipcode" value="<?php echo $zipcode; ?>" placeholder="Type Zip Code Here">
                       </div> -->
                        <div class="col-sm-2 input_box">
                        	<!-- <a href="#" class="btn btn-lg btn-primary"><i class="strip search"></i></a> -->
                        	
                        	<button type="submit" class="btn btn-lg btn-primary" value="Search" /><i class="strip search"></i></button>
                       </div>
                   </div>
              
   	</div>
   	</div>
	</div>
  </div>
     <div class="wrapper row5">
     	<div class="container">
     		<div class="result_search">
     			<div class="col-sm-4">
	     			<div class="result_search_text pull-left"><?php echo $total_rows;?> Results Found</div>
	     			
	            </div>
     			<div class="col-sm">
     				<!-- <form class="form-horizontal" id="bar-search-frm" method="post" role="form" action="<?php echo site_url("bar/lists"); ?>"> -->
	                   <div class="form-group pull-right">
	                   	<a class="review text-center" data-toggle="modal" href="#helpfindbar">Help Us Find Bars!</a>
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
	                   		 <select class="select_box" name="order_by" id="order_by" onchange="set_orderby('<?php echo $limit;?>','<?php echo $alpha;?>','<?php echo $options;?>','<?php echo $keyword;?>','<?php echo $offset; ?>')">
	                           	<option value="bar_title#ASC" <?php if($order_by == "bar_title#ASC"){ ?> selected="selected" <?php } ?>>Name ASC</option>
	                           	<option value="bar_title#DESC" <?php if($order_by == "bar_title#DESC"){ ?> selected="selected" <?php } ?> >Name DESC</option>
	                           	<option value="city#ASC" <?php if($order_by == "city#ASC"){ ?> selected="selected" <?php } ?>>City ASC</option>
	                           	<option value="city#DESC" <?php if($order_by == "city#DESC"){ ?> selected="selected" <?php } ?>>City DESC</option>
	                           	<option value="state#ASC" <?php if($order_by == "state#ASC"){ ?> selected="selected" <?php } ?>>State ASC</option>
	                           	<option value="state#DESC" <?php if($order_by == "state#DESC"){ ?> selected="selected" <?php } ?>>State DESC</option>
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
     		<div class="result_box clearfix">
     			<ul class="result_sub_box">
					<?php if($result){
				  			foreach($result as $rs)
	  				{?>
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
						       <div class="reult_sub_title"><h4 class="media-heading"><a href="<?php echo site_url("bar/details/".$rs->bar_slug);?>" class="bar_title"><?php echo $rs->bar_title; ?></a> </h4><a href="javascript://" class="white pull-right review" onclick="loadMap('<?php echo $rs->bar_id;?>')">Get Directions</a></div>
						       <div class="rating_box">
						       	        <p class="result_date pull-left marr_10"><?php if($rs->phone!=''){?><i class="strip phone-gray"></i> <?php }?><?php echo $rs->phone;?></p>
	  									<div class="pull-left" id="ratedli-<?php echo $rs->bar_id; ?>"><?php echo getReviewRating($rs->bar_id); ?></div>
	  									<div class="clearfix"></div>
							   </div>
						       <div class="clearfix"></div>
						       <div class="result_desc mar_top20">
						       	<div class="bar-listnew">
						       		
						       		<?php if(strip_tags(strlen($rs->bar_desc)>350)){ echo substr(strip_tags($rs->bar_desc),0,350).'...' ; } else { echo strip_tags($rs->bar_desc); } ?>
						       	</div>
						       <div class="mug-img">
						       	<?php if($rs->bar_type=='full_mug'){ ?> 
						        		<img title="Full Mug Bar" src="<?php echo base_url().'default/images/full-mug.png'; ?>" />
						        		<?php } else {  ?> 
									   <img title="Half Mug Bar" src="<?php echo base_url().'default/images/half-mug.png'; ?>" />
                                   <?php }?>
                </div>  <div class='clear'></div>
						       </div> 
						        <div class="padt8">
						        	<div class="reult_sub_title"><p class="result_date pull-left"><i class="strip address-gray"></i> <?php echo $rs->address.', '.$rs->city.', '.$rs->state.', '.$rs->zipcode; ?></p></div>
						        	
						        	<ul class="social_icon">
									<?php
									$url_share = site_url("upload/barlogo/".base64_encode($rs->bar_logo)) ;
									$url=urlencode($url_share);
									$image=urlencode(base_url().'upload/barlogo/no_image.png');
									if($rs->bar_logo != "" && is_file(base_path()."upload/barlogo/".$rs->bar_logo))
									{
										$image=urlencode(base_url().'upload/barlogo/'.$rs->bar_logo); 
									}?> 					
										<li><a onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $rs->bar_title;?>&amp;p[summary]=<?php echo mysql_real_escape_string($rs->bar_desc);?>&amp;p[url]=<?php echo $url; ?>&amp;p[images][0]=<?php echo $image;?>','sharer','toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)"><img src="<?php echo base_url();?>default/images/result_fb.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_fb-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_fb.png'"/></a></li>
			  							<li><a href="javascript:void(0)" onclick="window.open('http://twitter.com/home?status=<?php echo $url_share;?>','sharer','toolbar=0,status=0,width=548,height=325')"><img src="<?php echo base_url();?>default/images/result_twitt.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_twitt-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_twitt.png'"/></a></li>
	  									<li><a href="javascript:void(0)" onclick="window.open('https://plusone.google.com/_/+1/confirm?hl=en&url=<?php echo $url_share;?>','sharer','toolbar=0,status=0,width=548,height=325')"><img src="<?php echo base_url();?>default/images/result_google.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_google-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_google.png'" /></a></li>
	  									<li><a  href="javascript://" onclick="piShare('<?php echo $image;?>','<?php echo $rs->bar_slug;?>')"><img src="<?php echo base_url().'default'?>/images/result_p.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_p-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_p.png'"></a></li>
		    		 				</ul>
		    		 				<div class="clearfix"></div>
						        </div>
						        <div class="padt8 pull-right">
						        	<?php if($rs->owner_id==0 && get_authenticateUserID()==''){?>
						        		<a href="<?php echo site_url('home/bar_owner_register/'.base64_encode('1V1').'/1V1/'.base64_encode($rs->bar_id));?>" class="btn btn-lg btn-primary">Claim This Bar</a>
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
						
		  //	errorClass:'error fl_right'			
		}
	});	
});
</script>


<div class="modal fade" id="helpfindbar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Help Us Find Bar</div>
     				</div>
     				<div class="pad20">
     						<p class="white">We need your help!</p>

                           <p class="white">American Dive Bars is on a mission to find every small and independently owned bar in America. We are a crowd sourcing website that needs you help to seek out every local watering hole we can find. So, if you can’t find a small bar or pub in our database, please take the time to go to our suggest a dive bar form and let us know about it. If we list the bar, we will give you credit as the person who helped.</p>

<p class="white">Thanks for all your help!</p>

<a  href="<?php echo site_url('bar/suggest_bar')?>" class="btn btn-lg btn-primary text-center">suggest a Dive Bar</a>	
     				</div>		
     			</div>
     		</div>
     	</div>
     </div>
	
</div>  
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>

<div class="modal fade login_pop2" id="mapmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
					   
					</div>	
<script>
	function loadMap(id)
	{
		 $.ajax({
	       type: "POST",
		   url: "<?php  echo site_url('bar/getmapajax')?>",
		   data: {id:id},
		   dataType : 'html',
		   success: function(response) {
		   	$("#mapmodal").html(response);
		    //$('#mapmodal').one('show.bs.modal', function (e) {
		    	$('#mapmodal').on('show.bs.modal', function() {
		    		
                         alert("fdsa");
                         initialize();
                           google.maps.event.trigger(map, 'resize');
                           
			  //$('#mapmodal').one('shown.bs.modal', function (e) {          	 	
			           	 	
    						}).modal();
		     
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