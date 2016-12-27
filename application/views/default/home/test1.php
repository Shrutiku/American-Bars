

<script src="https://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<div style="padding-bottom:10px;"><input type="text" id="address" name="address" value="O. J. Brochs g 16a, Bergen" style="width:400px;border:1px solid black"><input type="button" name="search" value="Geocode"></div>
<div id="coords"></div>
<div id="gmap" style="width:570px; height:500px;"></div>
<input type="hidden" name="id" value="" id="id" />
<script>



//jQuery(document).ready(function() {
function get()
{
	// Load google map
	var map = new google.maps.Map( document.getElementById("gmap"),  {
		center: new google.maps.LatLng(0,0),
		zoom: 3,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		panControl: false,
		streetViewControl: false,
		mapTypeControl: false
	});



		var geocoder = new google.maps.Geocoder(); 
		geocoder.geocode({
				address : jQuery('input[name=address]').val(), 
				region: 'no' 
			},
		    function(results, status) {
		    	if (status.toLowerCase() == 'ok') {
					// Get center
					var coords = new google.maps.LatLng(
						results[0]['geometry']['location'].lat(),
						results[0]['geometry']['location'].lng()
					);
					//jQuery('#coords').html('Latitute: ' + coords.lat() + '    Longitude: ' + coords.lng() );
					
					
					$.ajax({
		url:'<?php echo site_url('bar/insertlat1123'); ?>',
		type:'POST',
		data: {id:$("#id").val(),lat:coords.lat(),lng:coords.lng()},
		dataType:'json',
		success:function()
		{
			//alert(data.address);
			
		}
	})
					
					
					map.setCenter(coords);
					map.setZoom(18);
					
					// Set marker also
					marker = new google.maps.Marker({
						position: coords, 
						map: map, 
						title: jQuery('input[name=address]').val(),
					});
							    	
		    	}
			}
		);
	
}

</script>

<script>
	window.setInterval(function(){
	//alert();
	
	$.ajax({
		url:'<?php echo site_url('bar/insertlat11'); ?>',
		type:'POST',
		data: '',
		dataType:'json',
	
		success:function(data)
		{
			//alert(data.address);
			$("#address").val(data.address);
			$("#id").val(data.bar_id);
			 setTimeout(function() {
		     				 get();
						}, 400);
			
			//alert(data.status);
		}
	})
	
  /// call your function here
}, 4000);
</script>