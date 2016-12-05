<?php
		          		if($bar_detail['bar_logo']!="" && file_exists(base_path().'upload/barlogo_thumb/'.@$bar_detail['bar_logo']))
					{?>
		            	<?php $img =  base_url().'/upload/barlogo_thumb/'.$bar_detail['bar_logo']; ?>
		            	<?php }  else { ?>
		            		<?php $img =  base_url().'/upload/barlogo/no_image.png'; ?>
		            		<?php } ?>
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
</style>
<style>
	#gmap_marker {
    height: 322px;
    width: 100%;
}
 .gm-style-iw
 {
 	color:#000000;
 }
</style>		
<!-- <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> -->
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>

<?php $theme_url = $urls= base_url().getThemeName();?>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/rating.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/image_script.js"></script>
<script type="text/javascript" src="<?php echo $theme_url; ?>/js/jquery_form.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/js/rating.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/css/jquery.bxslider.css" />
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>

<script>
	$(document).ready(function() {
		
		 $('#total-fav').click(function(){
  	
		var flag = this.name;
		var bid = '<?php echo $bar_detail["bar_id"]; ?>';
		var uid = '<?php echo get_authenticateUserID(); ?>';
		
		// if(uid=="")
		// {
			// //window.location.href='<?php //echo site_url("beer/beer_likes/".$beer_detail["beer_id"]); ?>';
			// //return false;
		// }
		
	//	alert($('#sess_id').val())
		if($('#sess_id').val()==0)
		{
			<?php $this->session->set_userdata("REDIRECT_PAGE","bar/details/".$bar_detail["bar_slug"]); ?>
			$('#loginmodal').modal('show');
			return false;
		}
		
		$.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>bar/bar_fav",         //the script to call to get data          
        data: {bar_id: bid, user_id: uid, fav_flag:flag},
	    dataType: '',                //data format      
        success: function(data)          //on 