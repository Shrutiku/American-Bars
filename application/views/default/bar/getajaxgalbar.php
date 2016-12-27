



<style>
	/*.ps-list .ps-prev
	{
		display: none !important;
	}
	.ps-list .ps-next
	{
		display: none !important;
	}*/
	/*.ps-current{
		height: 470px !important;
	}*/
</style>
<div class="login_block gallery-popup">
	
<div><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button></div>
	<div class="result_search">
		<div class="col-sm-8">
 			<div class="result_search_text pull-left"><?php echo ucwords($bar_one_gallery->title);?></div>
        </div>
        <?php 
        $myArray = $bar_gallery;
$arrayKeys = array_keys($myArray);
        
           
		   
		   if($myArray[$arrayKeys[0]]->bar_image_name!="" && file_exists(base_path().'upload/bar_gallery_thumb_big650by470/'.@$myArray[$arrayKeys[0]]->bar_image_name))
					{?>
		            	<?php $img =  base_url().'/upload/bar_gallery_thumb_big650by470/'.$myArray[$arrayKeys[0]]->bar_image_name; ?>
		            	<?php }  else { ?>
		            		<?php $img =  base_url().'/upload/barlogo/no_image.png'; ?>
		            		<?php } ?>

			<!-- <form class="form-horizontal" id="bar-search-frm" method="post" role="form" action="http://192.168.1.27/ADB/bar/lists"> -->
               <!-- <div class="form-group pull-right"> -->
               	<ul class="social_icon pull-right">
     						<li class="white_text">Share : </li>
						   <li><a href="javascript://" onclick="fbShare1()"><img src="<?php echo base_url().'default'?>/images/result_fb.png"></a></li>
						    <li><a onclick="twShare1()" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_twitt.png"></a></li>
						    <li><a onclick="gPlusShare12('<?php echo site_url('bar/details/'.$bar_detail['bar_slug']); ?>','john deo')" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_google.png"></a></li>
						     <li><a  href="javascript://" onclick="piShare1()"><img src="<?php echo base_url().'default'?>/images/result_p.png" /></a></li>
						    
						    <div class="clearfix"></div>
		    	</ul>
              <!-- </div> -->      
            <!-- </form> -->
        <div class="clearfix"></div>
	</div>
<ul class="pgwSlideshow">
	
	<?php if($bar_gallery){
		 foreach($bar_gallery as $row){
		 	
		 	?>
    <li><a target="_blank" href="<?php echo $row->image_link; ?>"><img data-description="<?php echo strlen($row->image_title)>85 ? substr($row->image_title,0,85)."...":$row->image_title;?>" src="<?php echo base_url().'upload/bar_gallery_thumb_big650by470/'.$row->bar_image_name;?>"  ></a>
   	
    </li>
    <?php } } ?>
    <div class="clearfix"></div>
   
</ul>
</div>
<script>
	function fbShare1(){
		
	window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('<?php echo site_url('bar/details/'.$bar_detail['bar_slug']); ?>'),'facebook-share-dialog','width=626,height=436');
            return false;
}

function twShare1()
{
	var width  = 575,
        height = 400,
        left   = ($(window).width()  - width)  / 2,
        top    = ($(window).height() - height) / 2,
        url    = 'http://twitter.com/share?url=<?php echo site_url('bar/details/'.$bar_detail['bar_slug']); ?>',
        opts   = 'status=1' +
                 ',width='  + width  +
                 ',height=' + height +
                 ',top='    + top    +
                 ',left='   + left;
    
    window.open(url, 'twitter', opts);
 
    return false;
}
function gPlusShare12(url,name)
    		{
		var w=480;var h=380;
		var x=Number((window.screen.width-w)/2);
		var y=Number((window.screen.height-h)/2);
		window.open('https://plus.google.com/share?url='+encodeURIComponent(url)+'&title='+encodeURIComponent(name),'','width='+w+',height='+h+',left='+x+',top='+y+',scrollbars=no');
		  
    	}
    	
    	
function piShare1()
{
	var width  = 600,
        height = 500,
         left   = ($(window).width()  - width)  / 2,
         top    = ($(window).height() - height) / 2,
        url    = 'http://www.pinterest.com/pin/create/button/?url=<?php echo site_url('bar/details/'.$bar_detail['bar_slug']); ?>&media=<?php echo $img; ?>&description=<?php //echo $bar_detail['bar_desc']; ?>',
        opts   = 'status=1' +
                 ',width='  + width  +
                 ',height=' + height +
                 ',top='    + top    +
                 ',left='   + left;
    
    window.open(url, 'Pinterest', opts);
 
    return false;
}
	
</script>