<?php $method = $this->uri->segment(1);
      $function = $this->uri->segment(2); ?>
      <script  type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script  type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/additional-methods.js"></script>

<script  type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.html5-placeholder-shim.js"></script>
<script>
$(function(){
	$.placeholder.shim();
});
</script>
<div class="modal fade" id="helpfindbar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<?php //echo $this->load->view(getThemeName().'/bar/bar_suggest');?>
</div>
<div class="modal fade login_pop2" id="loginmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
					   <?php echo $this->load->view(getThemeName().'/home/login_ajax');?>
</div>


<?php $theme_url = $urls= base_url().getThemeName(); ?>

<div class="wrapper row1">
  		<!-- <div  class="top-header">  -->
  			  <!-- Fixed navbar -->
    <div class="navbar navbar-default" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#b-menu-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

          <!-- <a class="navbar-brand" href="https://www.facebook.com/AmericanBars" target="_blank"><i class="strip event_fb"> </i> <?php /*?><img src="<?php echo $theme_url; ?>/images/fb_icon.png"  /><?php */?></a>
          <div class="fb-like" data-href="https://www.facebook.com/AmericanBars" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>
          <a class="navbar-brand" href="https://twitter.com/American_Bars" target="_blank"><i class="strip event_twitter"> </i> <?php /*?><img src="<?php echo $theme_url; ?>/images/twitt_icon.png"/><?php */?></a>
          <a class="navbar-brand" href="#"><i class="strip linkdn"> </i> <?php /*?><img src="<?php echo $theme_url; ?>/images/linked_icon.png" /><?php */?></a>
          <a class="navbar-brand" href="https://plus.google.com/+AmericanDiveBars" target="_blank"><i class="strip event_google"> </i> <?php /*?><img src="<?php echo $theme_url; ?>/images/google_icon.png"/><?php */?></a> -->
          <!-- <div class="g-plusone" data-size="small" data-annotation="inline" data-width="120" data-href="https://plus.google.com/+AmericanDiveBars"></div> -->
          <!-- <a class="navbar-brand" href="https://in.pinterest.com/americandivebar/" target="_blank"><i class="strip event_pint"> </i> <?php /*?><img src="<?php echo $theme_url; ?>/images/p_icon.png"/><?php */?></a>
          <a class="navbar-brand" href="https://instagram.com/americanbars/" target="_blank"><i class="instagram-icon"> </i> <?php /*?><img src="<?php echo $theme_url; ?>/images/p_icon.png"/><?php */?></a>
          <a class="navbar-brand" href="http://www.youtube.com/channel/UCWMZID-7tH4Ft1VjG6jWACg" target="_blank"><img src="https://americanbars.com/default/images/youtube.png" alt="Youtube Page" /></a> -->

        </div>
        <div class="navbar-collapse collapse" id="b-menu-1">
          <ul class="nav navbar-nav">
          	  <?php
		  if(check_user_authentication ()== ''){ ?>
            <!--<li><a href="<?php // echo site_url('home/bar_owner_register')?>" class="yellowlink">Submit Your Bar</a></li>-->
            <?php } ?>

            <div class="clearfix"></div>
          </ul>
          <ul class="nav navbar-nav navbar-right" id="dis_none">

          	 <?php
		  if(check_user_authentication ()!= ''){ $uinfo = get_user_info(get_authenticateUserID()); ?>
		  	<li class="user-name"><a href="<?php echo site_url('home/user_dashboard')?>" class="normal"><?php echo "Welcome,&nbsp&nbsp" . $uinfo->first_name; ?></a> </li>
		  	 <?php if($this->session->userdata('user_type')=='bar_owner' && check_user_authentication()){?>
            <li><a href="<?php echo site_url('home/dashboard')?>" class="yellowlink">My Profile</a></li>
            <?php }  elseif(check_user_authentication()) {?>
            <li><a href="<?php echo site_url('home/user_dashboard')?>" class="yellowlink">My Profile</a></li>
            <?php } ?>
		  	<?php } ?>
		  	 <?php
		  if(check_user_authentication ()!= ''){ ?>
          	<li><a href="<?php echo site_url('shopping/cart');?>" class="adjcarticon"><img src="<?php echo base_url().'default'?>/images/cart.png"/><span id="cartcount">
			           				<?php
			           					$cartcount =  count($this->cart->contents());
										if($cartcount >0){ echo '<span class="itemcart">'.$cartcount.'</span>';}
			           				?>
			           				</span></a> </li>

			           				<?php } ?>
		  <?php
		  if(check_user_authentication ()!= ''){ ?>

	        <li><a href="<?php echo site_url("home/logout"); ?>" class="yellowlink">Logout</a></li>
			<?php
			}else{ ?>
			<li ><a href="https://play.google.com/store/apps/details?id=com.spaculus.americanbars&hl=en" class="padding-top-bpttom"><img src="<?php echo $theme_url; ?>/images/google_play_button.png" /></a></li>
		  <li><a href="https://itunes.apple.com/in/app/american-bars/id1090377977?mt=8" class="padding-top-bpttom"><img src="<?php echo $theme_url; ?>/images/app-store-logo.png" /></a></li>
             <li><a href="#loginmodal" data-toggle='modal' class="yellowlink">Login OR Register</a></li>
			<?php } ?>
			<?php if(check_user_authentication ()== '' or check_user_authentication()== 0){ ?>
            <!-- <li class="active"><a href="<?php echo site_url("home/signup"); ?>" class="yellow_white">Register</a></li> -->
			<?php } ?>
			<div class="clearfix"></div>
          </ul>

          <ul class="nav navbar-nav navbar-right" id="dis_block" style="display: none;">
	        <li><a href="<?php echo site_url("home/logout"); ?>" class="yellowlink">Logout</a></li>
          </ul>

        </div><!--/.nav-collapse -->
      </div>
    </div>
  </div>
  <div class="wrapper row2">
    	<div class="header clearfix">
    		 <!-- <div class="container-fluid"> -->
    		 	<div class="container">
        			<div class="logo">
            			<a href="<?php echo site_url("home"); ?>"><img height="115"  width="489" src="<?php echo $theme_url; ?>/images/americanbars.png" alt="American Bars" class="logo_img"/></a>
            		</div>
            		<!-- <div class="row"> -->
                		<div  class="search_box ">
                			<form class=""  role="form" action="<?php echo site_url("bar/lists") ?>" method="post">
                				<div class="pull-left mar_r10"><input type="text" name="bar_title_new" id="bar_title_new" value="<?php echo @base64_decode($bar_title_new); ?>" class="form-control bar_title_new" placeholder="Name, City Or Zip"></div>
                				<input type="hidden" name="limit" id="limit" value="20" />
                    			<div class="pull-left"><button class="btn btn-lg btn-primary btn-block " type="submit"><span class="glyphicon glyphicon-search"></span></button></div>
                    		</form>
                            <!-- <a href="#helpfindbar" data-toggle="modal" class="btn btn-lg btn-primary text-center suggest-btn">Can't Find a Bar? Suggest One Now!</a> -->
                            <!-- <div class="clearfix"></div> -->
                            <!-- <a href="javascript://" onclick="openSug()" class="btn btn-lg btn-primary text-center suggest-btn">Can't Find a Bar? Suggest One Now!</a> -->
                		</div>
            		<!-- </div> -->
        		</div>
       		<!-- </div> -->
 		</div>
  </div>
  <div class="wrapper row3">


    <div class="navbar navbar-default" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#b-menu-2">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- <a href="#" class="navbar-brand">Home <span>/</span></a> -->
          <!-- <a href="#" class="navbar-brand">find A bar <span>/</span></a> -->
          <!-- <a href="#" class="navbar-brand">beer directory <span>/</span></a> -->
        </div>
        <div class="navbar-collapse collapse" id="b-menu-2">
          <ul class="nav navbar-nav">
          	<!--<li><a href="<?php // echo site_url("home"); ?>" class="<?php // if($method=='home' && $function==''){?>active<?php // } ?>">Home</a></li>-->
          	<li><a onclick="searchmodal()" href="javascript://"  class="<?php if($method=='bar' && ($function=='lists' || $function=='details')){?>active<?php } ?>">Find a Bar</a></li>
			<!-- <li><a href="<?php echo site_url("beer"); ?>" class="<?php if($method=='beer' && ($function=='lists' || $function=='detail')){?>active<?php } ?>">beer directory </a></li> -->
          	<li class="dropdown">
          		<a href="javascript://" class="<?php if($method=='taxiowner' || $method=='beer' || $method=='cocktail' || $method=='liquor' && ($function=='lists' || $function=='detail')){?>active<?php } ?>">Directories <b class="caret"></b></a>
          		<ul class="sub-menu">
          			<li><a href="<?php echo site_url('beer')?>">Beer Directory</a></li>
          			<li><a href="<?php echo site_url('cocktail')?>">Cocktail Recipes</a></li>
          			<li><a href="<?php echo site_url('liquor')?>">Liquor Directory</a></li>
          			<!--<li><a href="<?php echo site_url('taxiowner')?>">Taxi Directory</a></li>-->
                    <li><a href="<?php echo site_url('bar/gallery')?>">Photo Gallery</a></li>
          		</ul>
          	</li>

          <li><a href="<?php echo site_url("trivia"); ?>" class="<?php if($method=='trivia' && ($function=='' || $function=='start')){?>active<?php } ?>">Bar Trivia Game</a></li>

          	<li class="dropdown">
          		 <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Education<b class="caret"></b></a>
          		  <ul class="sub-menu">
                  <li><a href="<?php echo site_url("article"); ?>" class="active">Articles</a></li>
                  <!--<li><a href="<?php // echo site_url('bar/dictionary')?>">Dictionary</a></li>-->
                  <!--<li><a href="<?php // echo site_url('home/barcriteria')?>">In A Dive Bar?</a></li>-->
                  <li><a href="<?php echo site_url('resource')?>">Resources</a></li>
                </ul>

          	</li>

<!--          		<li class="dropdown">
          		 <a href="javascript://" class="dropdown-toggle" data-toggle="dropdown">Discussions<b class="caret"></b></a>
          		  <ul class="sub-menu">
          		  		<?php
//          		  		$category = get_category();
//          		  		if($category){
//     								   foreach($category as $cat){?>
     							 <li><a href="<?php // echo site_url('forum/forums/'.$cat->forum_category_id);?>"><?php // echo $cat->forum_category_name;?></a></li>
     					<?php // } } ?>


                </ul>

          	</li>-->
          	<li><a class="<?php if($method=='home' && $function=='contact_us'){?>active<?php } ?>" href="<?php echo site_url('home/contact_us')?>">contact us</a></li>
          </ul>
          <!-- <ul class="nav navbar-nav navbar-right">
            <li><a href="#" class="yellowlink">Login</a></li>
            <li class="active"><a href="#" class="yellow">Register</a></li>
          </ul> -->
        </div><!--/.nav-collapse -->
      </div>
    </div>

    </div>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/jquery.tagsinput.css" />
<script src="<?php echo base_url().getThemeName();?>/js/jquery.tagsinput.js" type="text/javascript"></script>


<div class="modal fade login_pop2" id="searchmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	  <?php echo $this->load->view(getThemeName().'/home/searchbox');?>
</div>
<div id="side-subscribe">
    <a id="side-link" title="Subscribe to American Bars" href="javascript:void(0);"><div class="side2">SUBSCRIBE NOW</div></a>
    <!--<iframe id="iframeform" src="https://secure.campaigner.com/CSB/Public/Form.aspx?fid=1154755" height="340" width="510" scrolling="no" frameborder="0">If you can see this, your browser does not support IFRAME.  Please use supported browser</iframe>-->
    <!-- Begin MailChimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/slim-081711.css" rel="stylesheet" type="text/css">
<style type="text/css">
	#mc_embed_signup{background:#000; clear:left;color: #fff;text-align: center; top: 66px;position: relative;}
    #mc_embed_signup form {display: block;position: relative;text-align: left;padding: 0px;}
    #side-subscribe {width: 494px;}
    #mc_embed_signup label {display: block;font-size: 16px;padding-bottom: 10px;font-weight: bold;text-align: center;}
    #mc_embed_signup input.email {display: block;padding: 8px 0;margin: 0 4% 10px 102px;color: #000;}

#mc_embed_signup .button {word-break: break-all;border: none;border-radius: 2px;text-transform: capitalize;-ms-border-radius: 3px;font-size: 16px;font-family: 'open_sansregular';padding: 1px 19px;font-weight: bold;text-decoration: none;display: inline-block;text-shadow: -1px -1px 0 rgba(0,0,0,0.2);    color: #FFF;    background-color: #C57B00;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#C57B00 ), to(#D3A103));
    background-image: -webkit-linear-gradient(top, #C57B00 , #D3A103);
    background-image: -moz-linear-gradient(top, #C57B00 , #D3A103);
    background-image: -ms-linear-gradient(top, #C57B00 , #D3A103);
    background-image: -o-linear-gradient(top, #C57B00 , #D3A103);
    background-image: linear-gradient(to bottom, #C57B00 , #D3A103);
    filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#C57B00 , endColorstr=#D3A103);margin-left: 155px;}
      #mc_embed_signup input.button {
    margin-left: 153px;    margin-bottom: 14px;
}
	/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
	   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
</style>
<div id="mc_embed_signup">
<form action="//theadauditor.us11.list-manage.com/subscribe/post?u=094543d3335f8c5c013b92020&amp;id=a13ac76997" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
    <div id="mc_embed_signup_scroll">
    <img width="400"  src="<?php echo $theme_url; ?>/images/americanbars.png" alt="American Bars" class="logo_img"/>
	<label for="mce-EMAIL">Join the American Bars Mailing List</label>
	<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    <div style="position: absolute; left: -5000px;"><input type="text" name="b_094543d3335f8c5c013b92020_a13ac76997" tabindex="-1" value=""></div>
    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
    </div>
</form>
</div>

<!--End mc_embed_signup-->
</div>
<?php if(check_user_authentication ()== '' or check_user_authentication()== 0){ ?>
<a href="#loginmodal" data-toggle="modal" class="yellowlink"><div class="side">Become An Enthusiast</div></a>
<?php } ?>
<script>

    function openSug()
    {
    	$.ajax({
	       type: "POST",
		   url: "<?php  echo site_url('home/getsugbar')?>",
		   data: '',
		   dataType : 'html',
		     beforeSend : function() {
		   		$('#dvLoading').fadeIn('slow');
		   },
		    complete : function() {
		   		$('#dvLoading').fadeOut('slow');
		   },
		   success: function(response) {
		   	   $("#searchmodal").modal('hide');
		    	$("#helpfindbar").html(function(){
		   		$(this).html(response);
		   		$('#helpfindbar').one('shown.bs.modal', function() {

    						}).modal();

		   	});
		    //$('#mapmodal').one('show.bs.modal', function (e) {
		    	//$('#myModalnew').one('shown.bs.modal', function (e) {


		  }
	   });
    }
	function searchmodal()
	{
		$("#searchmodal").modal('show');

	}
</script>
<script>
    $(function(){
        $('#side-link').click(function(){
            $('#side-subscribe').toggleClass('margin-left-none');
        });
    });
</script>
