<?php
clear_cache();
$site_setting=site_setting();  
$uriseg=uri_string();
$uri=explode('/',$uriseg);
header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header ("Pragma: no-cache"); // HTTP/1.0
//header('Cache-Control: no cache'); //no cache
//session_cache_limiter('private_no_expire'); // works
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" > 
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>:: Administration ::</title>
		
		<script type="application/javascript">
			var baseUrl='<?php echo base_url(); ?>';
			var baseThemeUrl='<?php echo base_url().getThemeName(); ?>';
		</script>
		
	<link href="<?php echo base_url().getThemeName(); ?>/css/default.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url().getThemeName(); ?>/css/developer.css" rel="stylesheet" type="text/css" />
	
	<!--[if IE]> <link href="<?php echo base_url().getThemeName(); ?>/css/ie.css" rel="stylesheet" type="text/css"> <![endif]-->	
	
	<script src="<?php echo base_url().getThemeName(); ?>/js/jquery-1.9.1.min.js"></script>
<!--	<script src="<?php echo base_url().getThemeName(); ?>/js/jquery-browsercheck.js"></script>-->
	<script src="<?php echo base_url().getThemeName(); ?>/js/jquery-defaultvalue.js"></script>
	<script src="<?php echo base_url().getThemeName(); ?>/js/jquery.validate.js"></script>
	<script src="<?php echo base_url().getThemeName(); ?>/js/additional-validation-methods.js"></script>
	<script src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
	<link type="text/css" href="<?php echo base_url().getThemeName(); ?>/scroll/jquery.jscrollpane.css" rel="stylesheet" media="all" />
						<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/scroll/jquery.jscrollpane.min.js"></script>
<script type="text/javascript" id="sourcecode">
			$(function()
			{
				$('.scroll-pane').jScrollPane();
			});
</script>
	<script>
	$(document).ready(function(e) {
		$("#validate").validate();
		$('.success_msg').click(function(){
			$(this).slideUp('slow',function(){
				$(this).remove();
			})
		});
	});
	</script>	
	</head>
	
<body class="<?php echo ($uri[0]=='home' || $uri[0]=='')?'body_bg':''; ?>">
	<div id="dvLoading"><div class="dvLoading"></div></div>
	<?php echo $header; ?>
	<?php echo $header_menu; ?>
	
<div class="wrapper row1 row2">	
	<?php echo $left; ?>
		<?php echo $center; ?>
	</div>
	

<?php echo $footer; ?>
	
</body>
</html>