
<style>
	.pac-container
	{
		z-index: 111111;
	}
</style>

<script>
var routeBounds = false;


var overlayWidth = 200; // Width of the overlay DIV
var leftMargin = 30; // Grace margin to avoid too close fits on the edge of the overlay
var rightMargin = 80; // Grace margin to avoid too close fits on the right and leave space for the controls

overlayWidth += leftMargin;


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
	var address ="<?php echo @$bar_detail['address']." ".@$bar_detail['city']."  ".@$bar_detail['state'];?>";
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
	  directionsService.route(request, function (response, status) {

        if (status == google.maps.DirectionsStatus.OK) {

            directionsDisplay.setDirections(response);

            // Define route bounds for use in offsetMap function
            routeBounds = response.routes[0].bounds;

            // Write directions steps
            writeDirectionsSteps(response.routes[0].legs[0].steps);

            // Wait for map to be idle before calling offsetMap function
            google.maps.event.addListener(map, 'idle', function () {

                // Offset map
                offsetMap();
            });

            // Listen for directions changes to update bounds and reapply offset
            google.maps.event.addListener(directionsDisplay, 'directions_changed', function () {

                // Get the updated route directions response
                var updatedResponse = directionsDisplay.getDirections();

                // Update route bounds
                routeBounds = updatedResponse.routes[0].bounds;

                // Fit updated bounds
                map.fitBounds(routeBounds);

                // Write directions steps
                writeDirectionsSteps(updatedResponse.routes[0].legs[0].steps);

                // Offset map
                offsetMap();
            });
        }
    });
			
			
		}
		
		
function fromLatLngToPoint(latLng) {

    var scale = Math.pow(2, map.getZoom());
    var nw = new google.maps.LatLng(map.getBounds().getNorthEast().lat(), map.getBounds().getSouthWest().lng());
    var worldCoordinateNW = map.getProjection().fromLatLngToPoint(nw);
    var worldCoordinate = map.getProjection().fromLatLngToPoint(latLng);

    return new google.maps.Point(Math.floor((worldCoordinate.x - worldCoordinateNW.x) * scale), Math.floor((worldCoordinate.y - worldCoordinateNW.y) * scale));
}
		
		function writeDirectionsSteps(steps) {

    var overlayContent = document.getElementById("overlayContent");
    overlayContent.innerHTML = '<div class="mart10 result_search pop-subtitle">Driving Direction List</div>';
     
    for (var i = 0; i < steps.length; i++) {

        overlayContent.innerHTML += '<p class="direction-text"> => ' + steps[i].instructions + '</p><small class="mar_left15">' + steps[i].distance.text + '</small>';
    }
}

function offsetMap() {

    if (routeBounds !== false) {

        // Clear listener defined in directions results
        google.maps.event.clearListeners(map, 'idle');

        // Top right corner
        var topRightCorner = new google.maps.LatLng(map.getBounds().getNorthEast().lat(), map.getBounds().getNorthEast().lng());

        // Top right point
        var topRightPoint = fromLatLngToPoint(topRightCorner).x;

        // Get pixel position of leftmost and rightmost points
        var leftCoords = routeBounds.getSouthWest();
        var leftMost = fromLatLngToPoint(leftCoords).x;
        var rightMost = fromLatLngToPoint(routeBounds.getNorthEast()).x;

        // Calculate left and right offsets
        var leftOffset = (overlayWidth - leftMost);
        var rightOffset = ((topRightPoint - rightMargin) - rightMost);

        // Only if left offset is needed
        if (leftOffset >= 0) {

            if (leftOffset < rightOffset) {

                var mapOffset = Math.round((rightOffset - leftOffset) / 2);

                // Pan the map by the offset calculated on the x axis
                map.panBy(-mapOffset, 0);

                // Get the new left point after pan
                var newLeftPoint = fromLatLngToPoint(leftCoords).x;

                if (newLeftPoint <= overlayWidth) {

                    // Leftmost point is still under the overlay
                    // Offset map again
                    offsetMap();
                }

            } else {

                // Cannot offset map at this zoom level otherwise both leftmost and rightmost points will not fit
                // Zoom out and offset map again
                map.setZoom(map.getZoom() - 1);
                offsetMap();
            }
        }
    }
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
	     				<i class="glyphicon glyphicon-map-marker"></i><div class="result_search_text" >Get Directions</div>
	     				
     				</div>
     				
     				<div class="pad20" style="color: #ffffff;">
     					<div class="error1 hide1 center" id="cm-err-main-map">&nbsp;</div>
     					
	                       	
     				<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Enter Start Location :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="start" placeholder="Starting Location" name="start" >
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Bar Location :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<label class="control-label"> <?php echo @$bar_detail['address']."<br> ".@$bar_detail['city'].", ".@$bar_detail['state']." ".@$bar_detail['zipcode'];?></label>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                   
	                           		<input type="hidden" class="form-control form-pad" id="end" placeholder="end" value="<?php echo @$bar_detail['address']." ".@$bar_detail['city']." ".@$bar_detail['state'];?>" name="end">
	                       		 
	                       	
	                       		<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10">
									<button class="btn btn-lg btn-primary"  onclick="calcRoute()">Search</button>									
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div> 		
     				<div id="map_canvas" style="width: 100%; height: 400px;"></div>
     				
     				<div id="overlayContent"></div>
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


