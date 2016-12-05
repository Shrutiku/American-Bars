<?php
$site_setting=site_setting(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $site_setting->site_name ?></title>
</head>
<link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/css/default.css" type="text/css">
<body class="bg_none">
<section id="listing_block">
<div class="plan_box">
		
        	<div class="premium_top">
            <div class="logo_two center"> <img src="http://192.168.1.106/yellowicons/default/images/logo_two.png" alt=""> </div>
            	<!--<div class="premium_top_lf">
				                	<div class="pad10">
                    	
                    	<div class="prem_top_title"> <h1><?php //echo $heading; ?></h1> </div>
                        
                        <div class="clear"> </div>
                        </div>
				 </div>-->
                
            	<div class="clear"></div>
            </div>
			
        	<div class="pad25">
            
           <h3 style="color:#F00; text-align:center;"><?php echo $message; ?></h3>
             <div class="clear"></div>
            </div>
            <div class="clear"> </div>
      </div>
 </section>
 </body>
 </html>