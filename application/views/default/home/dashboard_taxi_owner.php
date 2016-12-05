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
		width: 40%;
		height: 250px;
	}
	.gm-style-iw
	{
		color: #000000;
	}
	.bx-wrapper .bx-controls-direction a
	{
		width: 23px !important;
	}	
</style>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/image_script.js"></script>
<script type="text/javascript" src="<?php echo  base_url().getThemeName(); ?>/js/jquery_form.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>

<script>
	
	$(document).ready(function() {
    var showChar = 200;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more";
    var lesstext = "Show less";
    
    $('.more').each(function() {
        var content = $(this).html();
        
       // alert(content.length);
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink more pull-right"><i class="strip arrow_down"></i>' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
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
<div class="wrapper row6 padtb10">
     	<div class="container">
     		
     		<div class="margin-top-50 bg_brown">
     			<?php echo $this->load->view($theme.'/home/dashboard_menu_taxi_owner'); ?>
     			
     			<div class="dashboard_detail">
     				<div class="result_search">
			     		<div class='pull-left'><div class="result_search_text">Taxi Owner Dashboard</div></div>
			     
			       <div class="clear"></div>
		     		</div>
		     		<div class="dashboard_subblock">
		     			
		     			<div class="result_search margin-top-20">
		     				<h1 class="dashboard_smalltitle pull-left">Personal Information</h1>
		     				 <a href="javascript://" class="review pull-right mar_r15"  onclick="editbarinfo()">Edit Taxi Owner Information</a>
		     				<div class="clearfix"></div>
		     			</div>
		     			<div>
		     			<div id="list_hide">	
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
		     				
		     				</div><div class="clearfix"></div>
		     				
		     				
		     				</div>
		     				<div class="clearfix"></div>
		     				
		     				<div id="list_show" style="display: none;" >	
					<div class="text-right" >
     							<a onclick="goto_main()" href="javascript://"  class="btn btn-lg btn-primary marr_10">Back</a>
     						</div>
					<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
					<form name="add_event" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('user/editinfo_taxi_owner'); ?>">
		     			<div class=" pad_t15b20">
	                       	 <input type="hidden" name="user_id" id="user_id" value="<?php echo get_authenticateUserID(); ?>" />
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">First Name : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" name="first_name" id="first_name" value="<?php echo @$getalldata->first_name; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Last Name : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="last_name" name="last_name" value="<?php echo @$getalldata->last_name; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Email : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="email" name="email" value="<?php echo @$getalldata->email; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Mobile Number : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="mobile_no1" name="mobile_no" value="<?php echo @$getalldata->mobile_no; ?>">
	                           		
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="result_search margin-top-20">
		     				<h1 class="dashboard_smalltitle pull-left">Taxi Company Information</h1>
		     				<div class="clearfix"></div>
		     			</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Company Name : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="taxi_company" name="taxi_company" value="<?php echo @$getalldata->taxi_company; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Company Address : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<textarea rows="5" placeholder="Description" name="address" id="address" class="form-control form-pad"><?php echo @$getalldata->address; ?></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">City : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="city" name="city" value="<?php echo @$getalldata->city; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">State : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="state" name="state" value="<?php echo @$getalldata->state; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Zipcode : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="cmpn_zipcode" name="cmpn_zipcode" value="<?php echo @$getalldata->cmpn_zipcode; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label"> Company Phone Number : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="phone_number" name="phone_number" value="<?php echo @$getalldata->phone_number; ?>">
	                           		
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Company Website Address :  </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="cmpn_website" name="cmpn_website" value="<?php echo @$getalldata->cmpn_website; ?>">
	                           		
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Company Description :   </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<textarea rows="5" placeholder="Description" name="reciew" id="reciew" class="form-control form-pad ckeditor"><?php echo @$getalldata->reciew; ?></textarea>
	                           		<div>
	        				</div>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	<div class="padtb8">
	                       		<div class="col-sm-3 text-right"></div>
	                       		<div class="col-sm-7 mart10 text-left">
	                       			<button type="submit" class="btn btn-lg btn-primary marr_10" >Save</button> 
	                       			<a  class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('home/dashboard');?>" >Cancel</a>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="clearfix"></div>
     		</div>
     			</form>
		     			
		     		</div>
		     		
     			</div>
     			<div class="clearfix"></div>
     		</div>
   		</div>
   	</div>
 <script type="text/javascript" src="<?php echo base_url().getThemeName();?>/ckeditor/ckeditor.js"></script>
   	<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js" ></script>
   	<script type="text/javascript">
 
  function editbarinfo()
  {
 		  $("#list_hide").slideUp();
	    	$("#list_hide_m").slideUp();
	    	$("#hd_del").slideUp();
	    	$("#hs_del").slideDown();
	    	
	    	$('#list_show').slideDown();
 }
 $(document).ready(function() { 
 	// CKEDITOR.replace( 'reciew', {
	// toolbar: [
		// { name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
		// [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],			// Defines toolbar group without name.
		// '/',																					// Line break - next group will be placed in new line.
		// { name: 'basicstyles', items: [ 'Bold', 'Italic' ] }
	// ]
// });
		   $("#mobile_no1").inputmask("(999) 999-9999");
		   $("#phone_number").inputmask("(999) 999-9999");
	});
 
   $(document).ready(function(){
   	 $('#form').on('submit', function() {
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances['reciew'].updateElement();
                }
            });
        $('#form').validate(
		{
		rules: {
					
					
					first_name: {
						required: true,
					},
					last_name: {
						required: true,
					},
					email: { required: true },
					taxi_company: { required: true },
					address: { required: true },
					city: { required: true },
					state: { required: true },
					cmpn_zipcode: { required: true },
					
					//texi_company_phone_number: { required: true },
					cmpn_website:{url:true},
					//reciew:{required:true},
						errorClass:'error fl_right'
				},
				
		submitHandler: function(form){
		$(form).ajaxSubmit({
		type: "POST",
		   		 dataType : 'json',
				 beforeSubmit: function() 
				 {
		       		$('#dvLoading').fadeIn('slow');
		    	 },
		    	
		    	uploadProgress: function ( event, position, total, percentComplete ) {	
		        },
		    
		    	success : function ( json ) 
		    	{
		    		
					if(json.status == "fail")
					{
						$("#cm-err-main1").show();
						$("#cm-err-main1").html(json.comment_error);
			    		$('#dvLoading').fadeOut('slow');
			    		scrollToDiv('cm-err-main1');
				  		// setTimeout(function () 
						// {
						      // $("#cm-err-main1").fadeOut('slow');
						// }, 3000);
					return false;
					}
			
					else
					{
						//alert("sdsa");
						$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
						
						$.growlUI('Your profile update successfully .');
						
					 	// $("#list_hide").slideDown();
					 	 $("#list_hide_m").slideDown();
					     $("#hd_del").slideDown();
					     $("#hs_del").slideUp();
					     $('#list_show').slideUp();
					     $("#at_ajax").remove();
					     getData();
					}
					$('#dvLoading').fadeOut('slow');
		   		 }
		    });
		  }
		})
		
		
    });
  
    
    function goto_main()
    {
    	$("#event_id").val('');
    	// $(':input','#form')
					 	// .not(':button, :submit, :reset, :hidden')
					 	// .val('')
					 	// //.removeAttr('checked')
					 	// .removeAttr('selected');
		$("#img_here").removeAttr('src');			 	
    	$("#list_hide").slideDown();
    	$("#list_hide_m").slideDown();
    	$("#hd_del").slideDown();
    	$("#hs_del").slideUp();
    	$('#list_show').slideUp();
    }
    
     function getData()
    {
    	 $.ajax({
		   url: "<?php echo site_url('user/gettaxiuserdata')?>",
		   success: function(response) {
		   	//alert('response');
		   	//alert(response);
		   	$('#list_hide').empty();
		   	 $("#list_hide").slideDown();
		     $('#list_hide').html(response);
		    
		  }
	   });
    }
</script>


<link href="<?php echo base_url().getThemeName(); ?>/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<script src="<?php echo base_url().getThemeName(); ?>/assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>   
<script src="<?php echo base_url().getThemeName(); ?>/assets/scripts/app.js"></script>  
<script src="<?php echo base_url().getThemeName(); ?>/assets/scripts/gallery.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.bxslider.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/css/jquery.bxslider.css" />

<script>
	
		jQuery(document).ready(function() {  
			
			$(".fancybox")
    .attr('rel', 'gallery')
    .fancybox({
        beforeShow: function () {
            if (this.title) {
            	
            	
                // New line
                this.title += '<ul class="social_icon pull-right"><li>Share Image: </li>';
                this.title += '<li><a href="javascript://" onclick="fbShare()" ><img src="<?php echo base_url().'default'?>/images/result_fb.png"></a></li>';
                this.title += ' <li><a onclick="twShare()" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_twitt.png"></a></li>';
                this.title += '<li><a onclick="gPlusShare1("<?php echo site_url('user/profile/'.base64_encode($getalldata->user_id)); ?>","<?php echo $getalldata->first_name." ".$getalldata->last_name; ?>")" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_google.png"></a></li>';
                this.title += ' <li><a onclick="inShare()" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_linkln.png"></a></li>';
                this.title += '</ul><div class="clear"></div>';
                
            }
        },
        afterShow: function() {
            // Render tweet button
           // twttr.widgets.load();
            //fbshare_popup();
        },
        helpers : {
            title : {
                type: 'inside'
            }
        }  
    });     
			
		
				$('.bxslider').bxSlider({
  minSlides: 3,
  maxSlides: 3,
  slideWidth: 300,
  slideMargin: 10
});
		   // initiate layout and plugins
		   Gallery.init();
		});
	</script>
	

	<script type="text/javascript">
  var image =    $(".fancybox-image").attr('src');
function fbShare(){
	    window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('<?php echo site_url('user/profile/'.base64_encode($getalldata->user_id)); ?>'),'facebook-share-dialog','width=626,height=436');
        return false;
}

function fbshare_popup()
{
	  var image = $(".fancybox-image").attr('src');
	   alert(image);
	    window.open('http://www.facebook.com/sharer.php?s=100&amp;p[url]=<?php echo site_url('user/profile/'.base64_encode($getalldata->user_id)); ?>&amp;&p[images][1]='+image, 'facebook-share-dialog', 'toolbar=0,status=0,width=548,height=325');
        return false;
}
function twShare()
{
	var width  = 575,
        height = 400,
        left   = ($(window).width()  - width)  / 2,
        top    = ($(window).height() - height) / 2,
        url    = 'http://twitter.com/share?url=<?php echo site_url('user/profile/'.base64_encode($getalldata->user_id)); ?>',
        opts   = 'status=1' +
                 ',width='  + width  +
                 ',height=' + height +
                 ',top='    + top    +
                 ',left='   + left;
    
    window.open(url, 'twitter', opts);
 
    return false;
}
function gPlusShare1(url,name)
    		{
		var w=480;var h=380;
		var x=Number((window.screen.width-w)/2);
		var y=Number((window.screen.height-h)/2);
		window.open('https://plus.google.com/share?url='+encodeURIComponent(url)+'&title='+encodeURIComponent(name),'','width='+w+',height='+h+',left='+x+',top='+y+',scrollbars=no');
		  
    	}
    	
    	function inShare()
{
	var width  = 600,
        height = 500,
        left   = ($(window).width()  - width)  / 2,
        top    = ($(window).height() - height) / 2,
        url    = 'https://www.linkedin.com/cws/share?url=<?php echo site_url('user/profile/'.base64_encode($getalldata->user_id)); ?>',
        opts   = 'status=1' +
                 ',width='  + width  +
                 ',height=' + height +
                 ',top='    + top    +
                 ',left='   + left;
    
    window.open(url, 'Linkedin', opts);
 
    return false;
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
     						<label class="control-label" style="color: #fff;"><?php echo $getalldata->taxi_desc; ?></label>	
     				</div>		
     			</div>
     		</div>
     	</div>
     </div>
	
</div>     
