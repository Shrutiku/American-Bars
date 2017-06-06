<style>
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
	#gmap_marker
	{
		width: 330px;
		height: 250px;
	}
	.gm-style-iw
	{
		color: #000000;
	}
	
</style>
<script>
	$(document).ready(function() {
	  initialize_map();
    var showChar = 600;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more";
    var lesstext = "Show less";
    
    $('.more').each(function() {
        var content = $(this).html();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink more pull-right"><i class="strip arrow_down"></i>' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
 $(".morelink").click(function(){
         $("#myModalnew_open").modal('show');
    });
    // $(".morelink").click(function(){
        // if($(this).hasClass("less")) {
            // $(this).removeClass("less");
            // $(this).html(moretext);
            // $(".morelink").html("<i class='strip arrow_down more'></i>View More..");
        // } else {
            // $(this).addClass("less");
            // $(this).html("<i class='strip arrow_up more'></i>View Less..");
        // }
        // $(this).parent().prev().toggle();
        // $(this).prev().toggle();
        // return false;
    // });
});
</script>

	
		     				<div class="logo_block">
		     					<div id='preview'>

		     					<?php
		          		if($getbar['bar_logo']!="" && file_exists(base_path().'upload/barlogo_thumb/'.@$getbar['bar_logo']))
					{?>
		            	<img class="img-responsive" src="<?php echo base_url()?>/upload/barlogo_thumb/<?php echo $getbar['bar_logo']; ?>" alt="American Dive Bars"/>
		            	<?php }  else {?>
		            		<img class="img-responsive" src="<?php echo base_url()?>upload/barlogo/no_image.png" alt="American Dive Bars"/>	
		            			<?php } ?>
		     					</div>		     					
		     						
		     					<form id="imageform" method="post" enctype="multipart/form-data" action='<?php echo site_url('bar/changebarlogo')?>'>
		     					<div id='imageloadstatus' style='display:none'><img src="loader.gif" alt="Uploading...."/></div>
								<div id='imageloadbutton'>
								<!-- <input type="file" name="photoimg" id="photoimg" /> -->
								<div class="browse2" id="upload">
									<input type="file" id="photoimg" accept="image/*" class="browse" value="Upload Image" name="photoimg">
								</div>
								
								<input type="hidden" id="prev_bar_logo" name="prev_bar_logo" value="<?php echo @$getbar['bar_logo']; ?>" />
								<input type="hidden" id="bar_id" name="bar_id" value="<?php echo @$getbar['bar_id']; ?>" />
								</div>	
		     					</form>
		     					<div class="clear"></div>
		     					<a class="btn btn-lg btn-primary-2 mar_top15" href="<?php echo site_url('home/changepassword')?>">Change Password</a>
		     					<!-- <a href="#" class="change_text"><i class="strip edit"></i> Change</a> -->
		     				</div>
		     					
		     				
		     				<div class="map_mainblock">
		     					<div class="dashboard_beer_detail">
		     						<ul class="dashboard_list">
                                                                    <?php $name = @$getbar['first_name']." ".@$getbar['last_name'];?>
                                                                    <li><span class="marr_10">Bar Name: </span> <?php echo @$getbar['bar_title']; ?></li>
                                                                    <li><span class="marr_10">Bar Owner: </span> <?php echo $name; ?></li>
                                                                    <!--<li><span class="marr_10">Bar Owner First Name: </span> <?php //echo @$getbar['first_name']; ?></li>-->
                                                                    <!--<li><span class="marr_10">Bar Owner Last Name: </span> <?php //echo @$getbar['last_name']; ?></li>-->
                                                                    <li><span class="marr_10">Owner Email: </span> <?php echo @$getbar['email']; ?></li>

                                                                    <!--<li><span class="marr_10">Gender : </span> <?php// echo @$getbar['gender']; ?></li>-->
                                                                    <!-- <li><span class="marr_10">Address : </span> <?php echo @$getbar['address']; ?></li>
                                                                    <li><span class="marr_10">City : </span> <?php echo @$getbar['city']; ?></li>
                                                                    <li><span class="marr_10">State : </span> <?php echo @$getbar['state']; ?></li>
                                                                    <li><span class="marr_10">Zip Code : </span> <?php echo @$getbar['zipcode']; ?></li> -->


                                                                    <!--<li><span class="marr_10">Address: </span> <?php // echo @$getbar['address'].'<br><span class="pull-left" style="margin-left:69px;">'.@$getbar['city'].' , '.@$getbar['state'].' '.@$getbar['zipcode']; ?></span><div class="clearfix"></div></li>-->
                                                                    <li><span class="marr_10">Address: </span> <?php echo @$getbar['address'].' '.@$getbar['city'].', '.@$getbar['state'].' '.@$getbar['zipcode']; ?></span><div class="clearfix"></div></li>

                                                                    <?php if($getbar['phone']){?>
                                                                    <li><span class="marr_10">Phone: </span> <?php echo @$getbar['phone']; ?></li>
                                                                            <?php } ?>   
                                                                                    <?php if($getbar['website']){?>
                                                                    <li><span class="marr_10">Web Site: </span> <?php echo @$getbar['website']; ?></li>
                                                                            <?php } ?>  
                                                                    <li class="marr_10"><span class="marr_10" style="height: 114px;">Description:</span><p><?php if(strip_tags(strlen($getbar['bar_desc'])>350)){ echo substr(strip_tags($getbar['bar_desc']),0,350).'...<a class="morelink more pull-right" href="javascript://"><i class="strip arrow_down"></i>Show more</a>' ; } else { echo strip_tags($getbar['bar_desc']); } ?></p></li> 
		     						
<!--		     							<li><span class="marr_10">Bar Name : </span> <?php // echo @$getbar['bar_title']; ?></li>
		     							<li><span class="marr_10">Bar Owner First Name  : </span> <?php // echo @$getbar['first_name']; ?></li>
		     							<li><span class="marr_10">Bar Owner Last Name  : </span> <?php // echo @$getbar['last_name']; ?></li>
		     							<li><span class="marr_10">Bar Owner Email : </span> <?php // echo @$getbar['email']; ?></li>
		     							 									
		     							<li><span class="marr_10">Gender : </span> <?php // echo @$getbar['gender']; ?></li>
		     							 <li><span class="marr_10">Address : </span> <?php // echo @$getbar['address']; ?></li>
		     							<li><span class="marr_10">City : </span> <?php // echo @$getbar['city']; ?></li>
		     							<li><span class="marr_10">State : </span> <?php // echo @$getbar['state']; ?></li>
		     							<li><span class="marr_10">Zip Code : </span> <?php // echo @$getbar['zipcode']; ?></li> 
		     							
		     							
		     							<li><span class="marr_10">Address : </span> <?php // echo @$getbar['address'].'<br><span class="pull-left" style="margin-left:69px;">'.@$getbar['city'].' , '.@$getbar['state'].' '.@$getbar['zipcode']; ?></span><div class="clearfix"></div></li>
		     							
		     							<?php // if($getbar['phone']){?>
		     							<li><span class="marr_10">Phone : </span> <?php // echo @$getbar['phone']; ?></li>
		  								<?php // } ?>   
		  									<?php // if($getbar['website']){?>
		     							<li><span class="marr_10">Website : </span> <?php // echo @$getbar['website']; ?></li>
		  								<?php // } ?>  -->
		     							<!-- <li><span class="marr_10">Description : </span> Erich</li> -->
		     						</ul>
		     					</div>
		     					<div class="map_block" id="gmap_marker">
		     						
		     					</div>
		     					<div class="clearfix"></div>
		     					<p class="dashboard_title">Description :</p>
<!--		     					<p class="dashboard_desc"> 
		     						<?php // if(strip_tags(strlen($getbar['bar_desc'])>350)){ echo substr(strip_tags($getbar['bar_desc']),0,350).'...<a class="morelink more pull-right" href="javascript://"><i class="strip arrow_down"></i>Show more</a>' ; } else { echo strip_tags($getbar['bar_desc']); } ?>
		     						</p>-->
		     				</div></div></div>
		     				<div class="clearfix"></div>
		     				
		     				
		     			
		     			
   	<script type="text/javascript">
  var geocoder;
  var map;
  var address ="<?php echo @mysql_real_escape_string($getbar['address'])." ".@$getbar['city']." ".@$getbar['zipcode']." ".@$getbar['state'];?>";
  function initialize_map() 
  {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var myOptions = {
      zoom: 8,
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



<div class="modal fade" id="myModalnew_open" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Description</div>
     				</div>
     				<div class="pad20">
     						<label class="control-label" style="color: #fff;"><?php echo $getbar['bar_desc']; ?></label>	
     				</div>		
     			</div>
     		</div>
     	</div>
     </div>
	
</div>     
