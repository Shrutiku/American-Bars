
<?php $method = $this->uri->segment(1);
      $function = $this->uri->segment(2); ?>
<script  type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script   type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/additional-methods.js"></script>

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

<?php $method = $this->uri->segment(1);
      $function = $this->uri->segment(2); ?>
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
         
          <a class="navbar-brand" href="https://www.facebook.com/AmericanBars" target="_blank"><i class="strip event_fb"> </i> <?php /*?><img src="<?php echo $theme_url; ?>/images/fb_icon.png"  /><?php */?></a>
          <div class="fb-like" data-href="https://www.facebook.com/AmericanBars" data-layout="button" data-action="like" data-show-faces="true" data-share="true"></div>
          <a class="navbar-brand" href="https://twitter.com/American_Bars" target="_blank"><i class="strip event_twitter"> </i> <?php /*?><img src="<?php echo $theme_url; ?>/images/twitt_icon.png"/><?php */?></a>
          <a class="navbar-brand" href="#"><i class="strip linkdn"> </i> <?php /*?><img src="<?php echo $theme_url; ?>/images/linked_icon.png" /><?php */?></a>
          <a class="navbar-brand" href="https://plus.google.com/+AmericanDiveBars" target="_blank"><i class="strip event_google"> </i> <?php /*?><img src="<?php echo $theme_url; ?>/images/google_icon.png"/><?php */?></a>
          <!-- <div class="g-plusone" data-size="small" data-annotation="inline"  data-href="https://plus.google.com/+AmericanDiveBars"></div> -->
          <a class="navbar-brand" href="https://in.pinterest.com/americandivebar/" target="_blank"><i class="strip event_pint"> </i> <?php /*?><img src="<?php echo $theme_url; ?>/images/p_icon.png"/><?php */?></a>
          <a class="navbar-brand" href="https://instagram.com/americanbars/" target="_blank"><i class="instagram-icon"> </i> <?php /*?><img src="<?php echo $theme_url; ?>/images/p_icon.png"/><?php */?></a>
          <a class="navbar-brand" href="http://www.youtube.com/channel/UCWMZID-7tH4Ft1VjG6jWACg" target="_blank"><img src="https://americanbars.com/default/images/youtube.png" alt="Youtube Page" /></a>
        </div>
        
        <div class="navbar-collapse collapse" id="b-menu-1">
        	
          <ul class="nav navbar-nav">
          	  <?php 
		  if(check_user_authentication ()== ''){ ?>
            <li><a href="<?php echo site_url('home/bar_owner_register')?>" class="yellowlink">Bar Owner? Add or Claim Your Bar Now!</a></li>
            <?php } ?>
            <?php if($this->session->userdata('user_type')=='bar_owner' && check_user_authentication()){?>
            <li><a href="<?php echo site_url('home/dashboard')?>" class="yellowlink">Profile</a></li>
            <?php }  elseif(check_user_authentication()) {?>
            <li><a href="<?php echo site_url('home/user_dashboard')?>" class="yellowlink">Profile</a></li>
            <?php } ?>
            
          </ul>
          <ul class="nav navbar-nav navbar-right">
          	  <?php 
		  if(check_user_authentication ()!= ''){ $uinfo = get_user_info(get_authenticateUserID()); ?>
		  <li class="user-name"><?php echo "Welcome,&nbsp&nbsp" . $uinfo->first_name; ?> </li>
		  	
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
                <li ><a href="https://play.google.com/store/apps/details?id=com.spaculus.americanbars&hl=en" class="padding-top-bpttom"><img src="<?php echo $theme_url; ?>/images/google_play_button.png" style="max-width:100%;max-height:100%;"/></a></li>
		  <li><a href="https://itunes.apple.com/in/app/american-bars/id1090377977?mt=8" class="padding-top-bpttom"><img src="<?php echo $theme_url; ?>/images/app-store-logo.png" /></a></li>
            <li><a href="#loginmodal" data-toggle='modal' class="yellowlink">Login or Register</a></li>
			<?php } ?>
			<?php if(check_user_authentication ()== '' or check_user_authentication()== 0){ ?>
            <!-- <li class="active"><a href="<?php echo site_url("home/signup"); ?>" class="yellow_white">Register</a></li> -->
			<?php } ?>
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
            			<a href="<?php echo site_url("home"); ?>"><img height="115"  width="489"  src="<?php echo $theme_url; ?>/images/americanbars.png" alt="American Bars" class="logo_img"/></a>
            		</div>
            		<!-- <div class="row"> -->
                		<div  class="search_box">	
                			<form class=""  role="form" action="<?php echo site_url("bar/lists") ?>" method="post">
                				<div class="pull-left mar_r10"><input type="text" name="bar_title_new" id="bar_title_new" value="<?php echo @base64_decode($bar_title_new); ?>" class="form-control bar_title_new" placeholder="By Name, City Or Zip"></div>
                				<input type="hidden" name="limit" id="limit" value="20" />
                    			<div class="pull-left"><button class="btn btn-lg btn-primary btn-block " type="submit">Bar Search</button></div>
                    			<div class="clearfix"></div>
                    		</form>
                    		<!-- <div class="clearfix"></div> -->
                            <!-- <a href="#helpfindbar" data-toggle="modal" class="btn btn-lg btn-primary text-center suggest-btn">Can't Find a Bar? Suggest One Now!</a> -->
                             <a href="javascript://" onclick="openSug()" class="btn btn-lg btn-primary text-center suggest-btn">Can't Find a Bar? Suggest One Now!</a>
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
          <!-- <a href="#" class="navbar-brand">Find Bar<span>/</span></a> -->
          <!-- <a href="#" class="navbar-brand">Beer Directory <span>/</span></a> -->
        </div>
        <div class="navbar-collapse collapse" id="b-menu-2">
          <ul class="nav navbar-nav">
          	
          	<li><a href="<?php echo site_url("home"); ?>" class="<?php if($method=='home' && $function==''){?>active<?php } ?>">Home</a></li>
          	<li><a onclick="searchmodal()" href="javascript://"  class="<?php if($method=='bar' && ($function=='lists' || $function=='details')){?>active<?php } ?>">Find a Bar</a></li>
			<!-- <li><a href="<?php echo site_url("beer"); ?>" class="<?php if($method=='beer' && ($function=='lists' || $function=='detail')){?>active<?php } ?>">beer directory </a></li> -->
          	<li class="dropdown">
          		<a href="javascript://" class="<?php if($method=='taxiowner' || $method=='beer' || $method=='cocktail' || $method=='liquor' && ($function=='lists' || $function=='detail')){?>active<?php } ?>">Directories <b class="caret"></b></a>
          		<ul class="sub-menu">
          			<li><a href="<?php echo site_url('beer')?>">Beer Directory</a></li>
          			<li><a href="<?php echo site_url('cocktail')?>">Cocktail Recipes</a></li>
          			<li><a href="<?php echo site_url('liquor')?>">Liquor Directory</a></li>
          			<li><a href="<?php echo site_url('taxiowner')?>">Taxi Directory</a></li>
                    <li><a href="<?php echo site_url('bar/gallery')?>">Photo Gallery</a></li>
          		</ul>
          	</li>
          	
          		<li><a href="<?php echo site_url("trivia"); ?>" class="<?php if($method=='trivia' && ($function=='' || $function=='start')){?>active<?php } ?>">Bar Trivia Game</a></li>
          	<!-- <li><a href="javascript:void(0);">Media <span class="menu_slash">/</span class="menu_slash"></a></li> -->
          		<li class="dropdown">
          		 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Education<b class="caret"></b></a>
          		  <ul class="sub-menu">
                 <li><a href="<?php echo site_url("article"); ?>" class="active">Articles</a></li>
                  <li><a href="<?php echo site_url('bar/dictionary')?>">Dictionary</a></li>
                  <li><a href="<?php echo site_url('home/barcriteria')?>">In a Dive Bar? Fun Quiz</a></li>
                  <li><a href="<?php echo site_url('resource')?>">Resources</a></li>
                  <!-- <li><a href="<?php echo site_url('forum')?>">Groups</a></li> -->
                </ul>
          			
          	</li>
          	<!-- <li><a href="javascript:void(0);">Forum <span class="menu_slash">/</span class="menu_slash"></a></li> -->
          		<li class="dropdown">
          		 <a href="javascript://" class="dropdown-toggle" data-toggle="dropdown">Groups<b class="caret"></b></a>
          		  <ul class="sub-menu">
          		  		<?php 
          		  		$category = get_category();
          		  		if($category){
     								   foreach($category as $cat){?>
     							 <li><a href="<?php echo site_url('forum/forums/'.$cat->forum_category_id);?>"><?php echo $cat->forum_category_name;?></a></li>	   	
     					<?php } } ?>			   	
                 
                 
                </ul>
          			
          	</li>
          	<li><a class="<?php if($method=='home' && $function=='contact_us'){?>active<?php } ?>" href="<?php echo site_url('home/contact_us')?>">Contact Us</a></li>
          </ul>
          <!-- <ul class="nav navbar-nav navbar-right">
            <li><a href="#" class="yellowlink">Login</a></li>
            <li class="active"><a href="#" class="yellow">Register</a></li>
          </ul> -->
        </div><!--/.nav-collapse -->
      </div>
    </div> 
     
    </div>

<div class="modal fade login_pop2" id="searchmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	  <?php echo $this->load->view(getThemeName().'/home/searchbox');?>	
</div>
<div id="side-subscribe">
    <a id="side-link" title="Subscribe to American Bars" href="javascript:void(0);"><div class="side2">SUBSCRIBE NOW</div></a>
    <iframe id="iframeform" src="https://secure.campaigner.com/CSB/Public/Form.aspx?fid=1154755" height="340" width="510" scrolling="no" frameborder="0">If you can see this, your browser does not support IFRAME.  Please use supported browser</iframe>
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