<div class="wrapper row5 quiz">
     	<div class="container">
     		<div class="result_search">
     			<div class="col-sm-8">
	     			<div class="result_search_text pull-left">Quiz</div>
	            </div>
	            <div class="clearfix"></div>
     		</div>
     		<div class="mar_top20 congo-block">
 				<h1 class="congo-text text-center">Congratulation! Your Quiz is Completed.</h1>
 				<div class="margin-top-30">
 					<div class="score-block mar_right20">
 						<h1 class="score-text">Great! here is Your Score Summary</h1>
 						<div class="que-block margin-top-20">
		 					<p><?php echo $result['pt'];?>/20</p>
		 					<div class="que-title">
		 						Your Score
		 					</div>
		 				</div>
		 				<div class="clearfix"></div>
 					</div>
 					<div class="score-block">
 						<h1 class="score-text">Check Your Total Time Taken</h1>
 						<div class="que-block margin-top-20">
		 					<p><?php echo gmdate("H:i:s", (int)$count['time']); # 0:02:22;?></p>
		 					<div class="que-title">
		 						Time Taken
		 					</div>
		 				</div>
		 				<div class="clearfix"></div>
 					</div>
 					<div class="clearfix"></div>
 				</div>
 				<div>
 					
 					<div class="margin-top-50 text-center">
     				 	
     					<ul class="social_icon">
     						<li>Share this Quiz :</li>
     						<li><a href="javascript://" onclick="fbShare()" ><i class="strip event_fb"></i></a></li>
     						<li><a onclick="twShare()" href="javascript://"><i class="strip event_twitter"></i></a></li>
     						<li><a onclick="gPlusShare1('<?php echo site_url().'trivia'; ?>','<?php echo 'Trivia'; ?>')" href="javascript://"><i class="strip event_google"></i></a></li>
     						<li><a  href="javascript://" onclick="piShare()"><i class="strip event_pint"></i></a></li>
						    <!-- <li><a href="javascript://" onclick="fbShare()"><img src="http://192.168.1.27/ADB/default/images/result_fb.png" onmouseover="this.src='http://192.168.1.27/ADB/default/images/result_fb-hover.png'" onmouseout="this.src='http://192.168.1.27/ADB/default/images/result_fb.png'"></a></li>
						    <li><a onclick="twShare()" href="javascript://"><img src="http://192.168.1.27/ADB/default/images/result_twitt.png" onmouseover="this.src='http://192.168.1.27/ADB/default/images/result_twitt-hover.png'" onmouseout="this.src='http://192.168.1.27/ADB/default/images/result_twitt.png'"></a></li>
						    <li><a onclick="gPlusShare1('http://192.168.1.27/ADB/bar/details/315','dsad')" href="javascript://"><img src="http://192.168.1.27/ADB/default/images/result_google.png" onmouseover="this.src='http://192.168.1.27/ADB/default/images/result_google-hover.png'" onmouseout="this.src='http://192.168.1.27/ADB/default/images/result_google.png'"></a></li>
						    <li><a href="javascript://" onclick="piShare()"><img src="http://192.168.1.27/ADB/default/images/result_p.png" onmouseover="this.src='http://192.168.1.27/ADB/default/images/result_p-hover.png'" onmouseout="this.src='http://192.168.1.27/ADB/default/images/result_p.png'"></a></li> -->
						    
						    <div class="clearfix"></div>
		    		 	</ul><div class="clear"></div>
     				</div>
 				</div>
     		</div>
     		
     		<div class="margin-top-30 text-center congo-block">
     			<a href="<?php echo site_url('trivia');?>" class="white review mar_right20">Not Satisfied? Try Again!</a>
     		</div>
     	</div>
   	</div>
   	<?php $img =  base_url().getThemeName().'/images/bar-bg.jpg'; ?>
		            		<?php ?>
   	<script>
   		function fbShare(){
	window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('<?php echo site_url('trivia'); ?>'),'facebook-share-dialog','width=626,height=436');
            return false;
}
// 
 function twShare()
 {
	var width  = 575,
        height = 400,
        left   = ($(window).width()  - width)  / 2,
        top    = ($(window).height() - height) / 2,
        url    = 'http://twitter.com/share?url=<?php echo site_url('trivia'); ?>',
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
    	
    	
function piShare()
{
	var width  = 600,
        height = 500,
         left   = ($(window).width()  - width)  / 2,
         top    = ($(window).height() - height) / 2,
        url    = 'http://www.pinterest.com/pin/create/button/?url=<?php echo site_url('trivia'); ?>&media=<?php echo $img; ?>&description=<?php echo "Trivia"; ?>',
        opts   = 'status=1' +
                 ',width='  + width  +
                 ',height=' + height +
                 ',top='    + top    +
                 ',left='   + left;
    
    window.open(url, 'Pinterest', opts);
 
    return false;
}
var delete_cookie = function() {
    document.cookie = 'sitename' + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
};
$(document).ready(function () {
delete_cookie();
});
   	</script>
