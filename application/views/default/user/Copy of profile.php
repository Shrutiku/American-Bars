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
	
	.bx-wrapper .bx-controls-direction a
	{
		width: 23px !important;
	}
	
</style>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.bxslider.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/css/jquery.bxslider.css" />
<script>
	
	$(document).ready(function() {
		
		$('.bxslider').bxSlider({
  minSlides: 4,
  maxSlides: 4,
  slideWidth: 265,
  slideMargin: 10
});


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
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
            $(".morelink").html("<i class='strip arrow_down more'></i>View More..");
        } else {
            $(this).addClass("less");
            $(this).html("<i class='strip arrow_up more'></i>View Less..");
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
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
     			
     			<div class="">
     				<div class="result_search">
			     		<div class='pull-left'><div class="result_search_text">User Dashboard</div></div>
			     
			       <div class="clear"></div>
		     		</div>
		     		<div class="dashboard_subblock">
		     			
		     			<div class="result_search margin-top-20">
		     				<h1 class="dashboard_smalltitle pull-left">Personal Information</h1>
		     				 <!-- <a href="javascript://"  onclick="editbarinfo()"><i class="strip edit pull-right"></i></a> -->
		     				<div class="clearfix"></div>
		     			</div>
		     			<div>
		     			<div id="list_hide">	
		     				<div class="logo_block">
		     					<div id='preview'>

		     					<?php
		     					
		          		if($getalldata['profile_image']!="" && file_exists(base_path().'upload/user_thumb/'.@$getalldata['profile_image']))
					{?>
		            	<img class="img-responsive" src="<?php echo base_url()?>/upload/user_thumb/<?php echo $getalldata['profile_image']; ?>" alt="American Dive Bars"/>
		            	<?php }  else {?>
		            		<img class="img-responsive" src="<?php echo base_url()?>/upload/no-image.png" alt="American Dive Bars"/>	
		            			<?php } ?>
		     					</div>		     					
		     						
		     					
		     					<!-- <a href="#" class="change_text"><i class="strip edit"></i> Change</a> -->
		     				</div>
		     					
		     				
		     				<div class="map_mainblock">
		     					<div class="dashboard_beer_detail">
		     						<ul class="dashboard_list">
		     							<li><span class="marr_10">First Name : </span> <?php echo @$getalldata['first_name']; ?></li>
		     							<li><span class="marr_10">Last Name : </span> <?php echo @$getalldata['last_name']; ?></li>
		     							<li><span class="marr_10">Email : </span> <?php echo @$getalldata['email']; ?></li>
		     							<li><span class="marr_10">Gender : </span> <?php echo @$getalldata['gender']; ?></li>
		     							<li><span class="marr_10">Address : </span> <?php echo $getalldata['address'].'<br><span class="pull-left" style="margin-left:69px;">'.$getalldata['user_city'].' , '.$getalldata['user_state'].' , '.$getalldata['user_zip']; ?></span><div class="clearfix"></div></li>
		     							<li><span class="marr_10">Mobile Number : </span> <?php echo @$getalldata['mobile_no']; ?></li>
		     							<li><span class="marr_10">About User : </span> <?php echo @$getalldata['about_user']; ?></li>
		     							<!-- <li><span class="marr_10">Description : </span> Erich</li> -->
		     						</ul>
		     					</div>
		     					
		     					<div class="clearfix"></div>
		     				</div></div></div>
		     				<div class="clearfix"></div>
		     				
		     		<?php if($albumgallery){ 
		     			
		     			//print_r($albumgallery);?>
		     		    <div class="result_search margin-top-20">
		     				<h1 class="dashboard_smalltitle pull-left">ALBUM : <?php echo $albumgallery->title;?></h1>
		     				 <!-- <a href="javascript://"  onclick="editbarinfo()"><i class="strip edit pull-right"></i></a> -->
		     				<div class="clearfix"></div>
		     			</div>
		     			<div class="">
     			<div>
     					<ul class="social_icon">
     						<li>Share Album: </li>
						   <li><a href="javascript://" onclick="fbShare()" ><img src="<?php echo base_url().'default'?>/images/result_fb.png"></a></li>
						    <li><a onclick="twShare()" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_twitt.png"></a></li>
						    <li><a onclick="gPlusShare1('<?php echo site_url('user/profile/'.base64_encode($getalldata['user_id'])); ?>','<?php echo $getalldata['first_name']." ".$getalldata['last_name']; ?>')" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_google.png"></a></li>
						    
						    <div class="clearfix"></div>
		    		 	</ul>
     				</div>
     				
     			</div><div class="clear"></div>
					<?php } ?>			
					<ul class="bxslider">
					<?php if($albumgallery){
						
						$getimages = getalbumimage($albumgallery->bar_gallery_id);
						if($getimages){
						foreach($getimages as $rows){
						?>	
					  <li><img src="<?php echo base_url().'upload/bar_gallery_thumb_big/'.$rows->bar_image_name;?>" /></li>
					  <?php } } } ?>
					</ul>
     			</div>
     			<div class="clearfix"></div>
     		</div>
   		</div>
   	</div>
   	<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js" ></script>
   	<script type="text/javascript">
 
function fbShare(){
	window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('<?php echo site_url('user/profile/'.base64_encode($getalldata['user_id'])); ?>'),'facebook-share-dialog','width=626,height=436');
            return false;
}

function twShare()
{
	var width  = 575,
        height = 400,
        left   = ($(window).width()  - width)  / 2,
        top    = ($(window).height() - height) / 2,
        url    = 'http://twitter.com/share?url=<?php echo site_url('user/profile/'.base64_encode($getalldata['user_id'])); ?>',
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
   
</script>

