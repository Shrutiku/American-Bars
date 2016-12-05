<?php
$theme_url = $urls= base_url().getThemeName();

?>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.validate.js"></script>
<script type="text/javascript">
	 $(document).ready(function () {
    	

	
	
	// newsletter submit//
	$("#add-contact").validate({
        rules: {
            name: { required: true },
            email: { required: true ,email:true},
            subject: { required: true },
            message: { required: true },
           
        },
       
        submitHandler: function(form) {
           
           $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>home/add_contact",         //the script to call to get data          
      //  data: {sendtoid: send_to_id, sendtotype: send_to_type, msg: message, msg_id: message_id},
	    data: $("#add-contact").serialize(),
        dataType: '',                //data format      
        success: function(data)          //on receive of reply
            {
			  
			     $("#comtmsg").html(data);   
			    $("#comtmsg").show();
			    
			   setTimeout(function () 
				 {
				      $("#comtmsg").fadeOut('slow');
				     
				      
				      $(':input','#add-contact')
						 .not(':button, :submit, :reset, :hidden')
						 .val('')
						 .removeAttr('checked')
						 .removeAttr('selected');
						 
						
												 
				}, 2000);
				
				
            } 
		
        });
        }
    }); //end validate
	// end of newsletter submit//
});
</script>

  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script type="text/javascript">
function initialize() {
  var myLatlng = new google.maps.LatLng(<?php echo $site_setting->default_latitude ?>,<?php echo $site_setting->default_longitude; ?>);
  var mapOptions = {
    zoom: 4,
    center: myLatlng
  }
  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: 'Hello World!'
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
    
<!-- ########################################################################################### -->
<!-- content -->
<div class="wrapper row3 padtb20">
  <div id="container" class="clear">
  	<div class="row">
  		<h1 class="maintitle">Contact Us</h1>
  	
  	</div>
  	<div class="row">
  		<div class="map" id="map-canvas">
  			<h1>Map</h1>
  		</div>
  	</div>
  	
  	
  	
  	<div class="row">
  		<div class="left_block">
	  	
	  			
		  				<h2 class="smalltitle">Contact Us</h2>
		  				<div class="success text-center" id="comtmsg"></div>
		  				
		  					<form id="add-contact" name="add-contact">
		  				<div class="form-control-group">
				  			<label class="comment_form_label search_label mart7 marr10">Name :</label>
				  			<div class="form-control">
				  			<input type="text" name="name" id="name" class="input wrap large br_silver marr10" placeholder="Name"/>
				  		
				  			</div>
				  			<div class="clear"></div>
  						</div>
  						
  						<div class="form-control-group">
				  			<label class="comment_form_label search_label mart7 marr10">Email :</label>
				  			<div class="form-control">
				  			<input type="text" name="email" id="email" class="input wrap large br_silver marr10" placeholder="Email"/>
				  		
				  			</div>
				  			<div class="clear"></div>
  						</div>
  						
  						<div class="form-control-group">
				  			<label class="comment_form_label search_label mart7 marr10">Subject :</label>
				  			<div class="form-control">
				  			<input type="text" name="subject" id="subject" class="input wrap large br_silver marr10" placeholder="Subject"/>
				  		
				  			</div>
				  			<div class="clear"></div>
  						</div>
  						
  						<div class="form-control-group">
				  			<label class="comment_form_label search_label mart7 marr10">Message :</label>
				  			<div class="form-control">
				  			<textarea class="textarea wrap large br_silver" name="message" id="message" rows="8" placeholder="Message"></textarea>
				  				</div>
				  			 <div class="clear"></div>
  						</div>
  						<div class="form-control-group">
				  			<label class="comment_form_label search_label mart7 marr10"> </label>
				  			<div class="form-control">
				  			<button type="submit" class="button text-center ">Save</button>
				  				</div>
				  			 
  						</div>
  						
  						 
  						</form>
  						
  								
	  				</div>
	  			
  		<div class="right_block">
  			<h2 class="smalltitle">Address</h2>
  	        <address>
  	        	<?php echo $site_setting->site_address; ?>
  	        	
  	        	
  	        </address>
  		</div>
  		<div class="clear"></div>
  	</div>

  </div>
</div>
<!-- ########################################################################################### -->