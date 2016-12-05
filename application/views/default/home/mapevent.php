<style>
	.pac-container
	{
		z-index: 111111;
	}
</style>

<script>
var autocomplete = new google.maps.places.Autocomplete($("#start")[0], {});

            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();
                console.log(place.address_components);
     });
  function viral()
  {
  	initialize();
  }
 var geocoder;
    var directionDisplay;
	var directionsService = new google.maps.DirectionsService();
	var map;
		
	function initialize() {
		 geocoder = new google.maps.Geocoder();
	var address ="<?php echo @$bar_detail['address']." ".@$bar_detail['city']." ".@$bar_detail['zipcode']." ".@$bar_detail['state'];?>";
			directionsDisplay = new google.maps.DirectionsRenderer();
			var melbourne = new google.maps.LatLng(-37.813187, 144.96298);
			var myOptions = {
				zoom:18,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				center: melbourne
			}

			map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
			
			if (geocoder) {
			//alert(geocoder);
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
		
		directionsDisplay.setMap(map);
		google.maps.event.trigger(map, 'resize');
		
		
	}
	function calcRoute_old() {
		$("#mapmodal").focus();
			var start = document.getElementById("start").value;
			var end = document.getElementById("end").value;
			var distanceInput = document.getElementById("distance");
			
			var request = {
				origin:start, 
				destination:end,
				travelMode: google.maps.DirectionsTravelMode.DRIVING
			};
			
			directionsService.route(request, function(response, status) {
				
				if (status == google.maps.DirectionsStatus.OK) {
					directionsDisplay.setDirections(response);
					$('#cm-err-main-map').empty();
				}
				else
				{
					$('#cm-err-main-map').html("No address found");
					$('.hide1').show();
				}
			});
		}
		
		function calcRoute() {
		$("#mapmodal").focus();
			var start = document.getElementById("start").value;
			var end = document.getElementById("end").value;
			var distanceInput = document.getElementById("distance");
			
			//alert(start);
			var request = {
				origin:start, 
				destination:end,
				
				travelMode: google.maps.DirectionsTravelMode.DRIVING
			};
			
			
			
			directionsService = new google.maps.DirectionsService();
	directionsService.route(request, function(response, status) {
				if (status == google.maps.DirectionsStatus.OK) {
					directionsDisplay.setDirections(response);
				}
				else
					alert ('failed to get directions');
			});
		}
		
		function removemapdata()
		{
			$('#mapmodal').on('hide.bs.modal', function(e) {
					$(this).removeData('bs.modal');
					$("#mapmodal").empty();
});
		}
</script>

<div class="padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     			 	<div class="result_search">
     					 <button type="button" onclick="removemapdata()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	     				<i class="strip login_icon"></i><div class="result_search_text" >Search Direction</div>
	     				
     				</div>
     				
     				<div class="pad20" style="color: #ffffff;">
     					<div class="error1 hide1 center" id="cm-err-main-map">&nbsp;</div>
     					<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Bar Location :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<label class="control-label"> <?php echo @$bar_detail['address']." ".@$bar_detail['city']." ".@$bar_detail['zipcode']." ".@$bar_detail['state'];?></label>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
     				<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Enter Location :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="start" placeholder="start" name="start" >
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                   
	                           		<input type="hidden" class="form-control form-pad" id="end" placeholder="end" value="<?php echo @$bar_detail['address']." ".@$bar_detail['city']." ".@$bar_detail['zipcode']." ".@$bar_detail['state'];?>" name="end">
	                       		 
	                       	
	                       		<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10">
									<button class="btn btn-lg btn-primary"  onclick="calcRoute()">Search</button>									
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div> 		
     				<div id="map_canvas" style="width: 640px; height: 400px;"></div>
     				</div> 
     			</div>
     		</div>
     	</div>
 </div>    				
<!-- <div>
			<p>
				<label for="start">Start: </label>
				<input type="text" name="start" id="start" />
				
				<label for="end">End: </label>
				<input type="text" name="end" id="end" />
				
				<input type="submit" value="Calculate Route" onclick="calcRoute()" />
			</p>
			<p>
				<label for="distance">Distance (km): </label>
				<input type="text" name="distance" id="distance" readonly="true" />
			</p>
		</div>
		-->
