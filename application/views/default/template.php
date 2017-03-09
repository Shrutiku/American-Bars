
<?php
$theme_url = base_url().getThemeName();
$site_setting=site_setting();  
$meta_setting=meta_setting();  
$uri = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        
if($uri == 'https://americanbars.com/'){
    $img = "http://americanbars.com/images/ab-fb-og.jpg";
}
else if(strpos($uri,'https://americanbars.com/beer/detail/') !== false){
    $img = base_url().'upload/beer_thumb/'.$beer_detail['beer_image'];
}
else if(strpos($uri,'https://americanbars.com/cocktail/detail/') !== false){
    $img = base_url().'upload/cocktail_thumb/'.$cocktail_detail['cocktail_image'];
}  
else if(strpos($uri,'https://americanbars.com/liquor/detail/') !== false){
    $img = base_url().'/upload/liquor_thumb/'.$liquor_detail['liquor_image'];
}      
else if(strpos($uri,'https://americanbars.com/article/detail/') !== false){
    $img = base_url().'upload/blog_thumb_50by50/'.$blog_detail['blog_image'];
}      
else{
    $img = "http://americanbars.com/upload/blog_thumb/blog_image67364.jpg";
}
 
 
// Turn off all error reporting
//$site_timezone=tzOffsetToName($site_setting->site_timezone);
//date_default_timezone_set($site_timezone);
 header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public");
   
?>

<!DOCTYPE html>
<html lang="en">  
<head>
        <meta name="apple-itunes-app" content="app-id=1090377977">
    <meta name="google-play-app" content="app-id=com.spaculus.americanbars">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?php echo app_bower_url();?>/jquery.smartbanner/jquery.smartbanner.css" type="text/css" media="screen">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?php 	if($metaDescription=="" || $metaKeyword=="" || $pageTitle=='' || $metaDescription=='0' || $metaKeyword=='0' || $pageTitle=='0'){
    	 ?>
	<meta name="description" content="<?php echo $meta_setting->meta_description;?>" />
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta name="keyword" content="<?php echo $meta_setting->meta_keyword;?>"  />
		<title><?php echo $meta_setting->title;?></title>
<?php } else {
	?>		
	<meta name="description" content="<?php echo $metaDescription;?>" />
	<meta name="keyword" content="<?php echo $metaKeyword;?>" />
	<title><?php echo $pageTitle;?></title>
	
	<?php } ?>
    
 	 <!-- Bootstrap -->
    <!-- Bootstrap core CSS -->
    <meta property="og:title" content="<?php echo $pageTitle ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />
    <meta property="og:description" content="<?php echo $metaDescription; ?>" />
    <?php if($uri == "https://americanbars.com/bar/gallery/60"){?>
    <meta property="og:image" content="https://americanbars.com/upload/bar_gallery_thumb_big650by470/34421business.jpg" />
    <?php }else{ ?>
    <meta property="og:image" content="<?php echo $img; ?>" />
    
    <?php } ?>
    <link href="<?php echo $theme_url; ?>/css/bootstrap.min.css" rel="stylesheet">

    <link href="<?php echo $theme_url; ?>/css/style.css" rel="stylesheet">
	<link href="<?php echo $theme_url; ?>/css/developer.css" rel="stylesheet">
	<!-- <link href="<?php echo $theme_url; ?>/css/adb-new-style.css" rel="stylesheet"> -->
    <link href="<?php echo $theme_url; ?>/css/media.css" rel="stylesheet">
    <!-- <link href="<?php echo $theme_url; ?>/css/bootslider.css" rel="stylesheet"> -->
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script  src="<?php echo $theme_url; ?>/js/jquery.min.js"></script>
    <script  src="<?php echo $theme_url; ?>/js/bootstrap.min.js"></script>
    <!-- <script src="<?php echo $theme_url; ?>/js/bootslider.js"></script> -->
    <script  src="https://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>
    <script  src="<?php echo $theme_url; ?>/js/jquery.blockui.min.js" type="text/javascript"></script>  
    <script  type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/alertify.min.js"></script>
<link href="<?php echo base_url().getThemeName(); ?>/css/alertify.default.css" rel="stylesheet" />
<link href="<?php echo base_url().getThemeName(); ?>/css/alertify.core.css" rel="stylesheet" />
<link href="<?php echo base_url().getThemeName(); ?>/css/jquery-ui.css" rel="stylesheet" />
<!-- Getresponse Analytics -->
<script type="text/javascript" src="https://ga.getresponse.com/script/ga.js?grid=sBDcDWE1ZdXsIAg%3D%3D" async></script>
<!-- End Getresponse Analytics -->
   <!-- Social-feed css -->
    <link href="<?php echo app_bower_url();?>/social-feed/css/jquery.socialfeed.css" rel="stylesheet" type="text/css">
    <!-- font-awesome for social network icons -->
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">


	<script type="application/javascript">
		var baseUrl='<?php echo base_url(); ?>';
		
		var baseThemeUrl='<?php echo base_url().getThemeName(); ?>';
	function scrollToDiv (div)
    {
    	$('html,body').animate({ scrollTop: $('#'+div).offset().top }, 500);
    }
    function scrollToDivmore(div)
    {
    	$('html,body').animate({ scrollTop: $('.'+div).offset().top }, 500);
    	
    }
	</script>
    <script language='javascript' type='text/javascript'>
    function PopWindow (url) { 
    var prams = 'menubar=0,location=0,resizable=1,scrollbars=1,width=520,height=350,border=0';
    newWin = window.open(url,'',prams);
    newWin.focus();
    return;
    }
    </script>   
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-66318905-1', 'auto');
      ga('send', 'pageview');
    
    </script>
</head>  
<?php $getlastmessage = getLatestMessage();?>
	<body class="<?php if($getlastmessage){ echo "modal-open" ;}?>">
            <script src="<?php echo app_bower_url();?>/jquery.smartbanner/jquery.smartbanner.js"></script>
            <script type="text/javascript">
              $(function() { $.smartbanner(); } );
            </script>
            <script>
                $.smartbanner({
                    title: null, // What the title of the app should be in the banner (defaults to <title>)
                    author: null, // What the author of the app should be in the banner (defaults to <meta name="author"> or hostname)
                    price: 'FREE', // Price of the app
                    appStoreLanguage: 'us', // Language code for App Store
                    inAppStore: 'On the App Store', // Text of price for iOS
                    inGooglePlay: 'In Google Play', // Text of price for Android
                    inAmazonAppStore: 'In the Amazon Appstore',
                    inWindowsStore: 'In the Windows Store', // Text of price for Windows
                    GooglePlayParams: null, // Aditional parameters for the market
                    icon: null, // The URL of the icon (defaults to <meta name="apple-touch-icon">)
                    iconGloss: null, // Force gloss effect for iOS even for precomposed
                    url: null, // The URL for the button. Keep null if you want the button to link to the app store.
                    button: 'VIEW', // Text for the install button
                    scale: 'auto', // Scale based on viewport size (set to 1 to disable)
                    speedIn: 300, // Show animation speed of the banner
                    speedOut: 400, // Close animation speed of the banner
                    daysHidden: 15, // Duration to hide the banner after being closed (0 = always show banner)
                    daysReminder: 90, // Duration to hide the banner after "VIEW" is clicked *separate from when the close button is clicked* (0 = always show banner)
                    force: null, // Choose 'ios', 'android' or 'windows'. Don't do a browser check, just always show this banner
                    hideOnInstall: true, // Hide the banner after "VIEW" is clicked.
                    layer: false, // Display as overlay layer or slide down the page
                    iOSUniversalApp: true, // If the iOS App is a universal app for both iPad and iPhone, display Smart Banner to iPad users, too.      
                    appendToSelector: 'body', //Append the banner to a specific selector
                    onInstall: function() {
                      // alert('Click install');
                    },
                    onClose: function() {
                      // alert('Click close');
                    }
                  });
            </script>
		<?php 
		      //print_r($getlastmessage);
		      if($getlastmessage){?>
		      	<script>
		      		
		      		 function change_state(id)
		      		 {
		      		 	$.ajax({
				        type: "POST",
				        url: "<?php echo base_url(); ?>home/changestate",         //the script to call to get data          
				        data: {id: id},
					    dataType: '',                //data format      
				        success: function(data)          //on receive of reply		
				            {  
								window.location = '<?php echo current_url();?>';
						    } 
						
				        });
		      		 }
		      	</script>
		      	<div class="modal-backdrop fade in"></div>
		      	<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="userguide123" class="modal fade in" style="display: block;">
   
	<div class="padtb10">
     	<div>
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				
	        			<div id="signup-form" class="signup">
	        				<div class="result_search">
	        					<button type="button" onclick="change_state(<?php echo $getlastmessage->message_id;?>)" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	     				<i class="strip login_icon"></i><div class="result_search_text" >Important News from AmericanBars.com</div>
     				</div> 
     				<div class="pad20" style="color: #ffffff;">
     						
                            <h2 class="result_search_text"><?php echo ucwords($getlastmessage->subject);?></h2>
                            <p class="mar_top18"><?php echo $getlastmessage->description;?></p>
	        			</div>
	        			
	        			
	        		</div>
     			</div>
     		</div>
   		</div>
   	</div>
	</div>	      	
		      <?php } ?>	
        <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
              
		<div id="dvLoading"><div class="dvLoading"></div></div>
		<?php echo $header;  ?>
		<?php //echo $content_side; ?>
		<?php echo $content_center; ?>
		<?php echo $footer; ?>
    <script type="text/javascript">
      (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = 'https://apis.google.com/js/platform.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
      })();
    </script>
</html>
