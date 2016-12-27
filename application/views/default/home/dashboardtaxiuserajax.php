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
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/image_script.js"></script>
<script type="text/javascript" src="<?php echo  base_url().getThemeName(); ?>/js/jquery_form.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script>
	$(document).ready(function() {
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
});
</script>
<script type="text/javascript">
$(document).ready(function()
{


$('body').on('change','#photoimg', function()
 {
var A=$("#imageloadstatus");
var B=$("#imageloadbutton");

$("#imageform").ajaxForm({target: '#preview',
beforeSubmit:function(){
A.show();
B.hide();
},
success:function(){
A.hide();
B.show();
},
error:function(){
	
A.hide();
B.show();
} }).submit();
});

});
</script>
	
		     				<div class="logo_block">
		     					<div id='preview'>

		     					<?php
		          		if($getalldata->taxi_image!="" && file_exists(base_path().'upload/user_thumb/'.@$getalldata->taxi_image))
					{?>
		            	<img class="img-responsive" src="<?php echo base_url()?>/upload/user_thumb/<?php echo $getalldata->taxi_image; ?>" alt="American Dive Bars"/>
		            	<?php }  else {?>
		            		<img class="img-responsive" src="<?php echo base_url()?>/upload/no-image.png" alt="American Dive Bars"/>	
		            			<?php } ?>
		     					</div><div class="clear"></div>
		     							     					
		     						
		     					<form id="imageform" method="post" enctype="multipart/form-data" action='<?php echo site_url('user/changeuserlogo')?>'>
		     					<div id='imageloadstatus' style='display:none'><img src="loader.gif" alt="Uploading...."/></div>
								<div id='imageloadbutton'>
								<!-- <input type="file" name="photoimg" id="photoimg" /> -->
								<div class="browse2" id="upload">
									<input type="file" id="photoimg" accept="image/*" class="browse" value="Upload Image" name="photoimg">
								</div>
								
								<input type="hidden" id="prev_bar_logo" name="prev_bar_logo" value="<?php echo @$getalldata->taxi_image; ?>" />
								</div>	
		     					</form><div class="clear"></div>
		     					<a class="btn btn-lg btn-primary-2 mar_top15  pull-left" href="<?php echo site_url('home/changepassword')?>">Change Password</a>
		     					<!-- <a href="#" class="change_text"><i class="strip edit"></i> Change</a> -->
		     				</div>
		     					
		     				<div class="map_mainblock">
		     					<div class="dashboard_beer_detail">
		     						<ul class="dashboard_list">
		     							<li><span class="marr_10">First Name : </span> <?php echo @$getalldata->first_name; ?></li>
		     							<li><span class="marr_10">Last Name : </span> <?php echo @$getalldata->last_name; ?></li>
		     							<li><span class="marr_10">Email : </span> <?php echo @$getalldata->email; ?></li>
		     							<li><span class="marr_10">Mobile Number : </span> <?php echo @$getalldata->mobile_no; ?></li>
		     						</ul>
		     					</div>
		     					
		     					<div class="clearfix"></div>
		     				</div><div class="clearfix"></div>
		     				<div class="result_search margin-top-20">
		     				<h1 class="dashboard_smalltitle pull-left">Taxi Company Information</h1>
		     				<div class="clearfix"></div>
		     			</div>
		     			<div class="map_mainblock">
		     					<div class="dashboard_beer_detail">
		     						<ul class="dashboard_list">
		     							<li><span class="marr_10">Company Name : </span> <?php echo @$getalldata->taxi_company; ?></li>
		     							<li><span class="marr_10">Company Address : </span> <?php echo @$getalldata->address.", ".$getalldata->city.", ".$getalldata->state." ".$getalldata->cmpn_zipcode; ?></li>
		     							<li><span class="marr_10">Company Phone Number : </span> <?php echo @$getalldata->phone_number; ?></li>
		     							<li><span class="marr_10">Company Website : </span> <?php echo @$getalldata->cmpn_website; ?></li>
		     							<li><span class="marr_10">Description : </span> 
		     								<div class="dashboard_desc">
		     									<?php if(strip_tags(strlen($getalldata->taxi_desc)>350)){ echo substr(strip_tags($getalldata->taxi_desc),0,350).'...<a class="morelink more pull-right" href="javascript://"><i class="strip arrow_down"></i>Show more</a>' ; } else { echo strip_tags($getalldata->taxi_desc); } ?>
		     									</div></li>
		     							
		     							<!-- <li><span class="marr_10">Description : </span> Erich</li> -->
		     						</ul>
		     					</div>
		     					
		     					<div class="clearfix"></div>
		     				</div><div class="clearfix"></div>
		     				</div></div>
		     				<div class="clearfix"></div>
		     				
		     				
		     


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
     						<label class="control-label" style="color: #fff;"><?php echo $getalldata->taxi_desc; ?></label>	
     				</div>		
     			</div>
     		</div>
     	</div>
     </div>
	
</div>   