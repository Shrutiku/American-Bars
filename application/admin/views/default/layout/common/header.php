<!--HEADER-->
<?php
$this->lang->load('admin', $this->session->userdata('site_lang'));

$them_url = base_url().getThemeName();
?>
<div class="wrapper row1">
  <div id="header">
  	<div class="navbar_inner">
		<div class="fl_left">
			<div class="inner_page_logo"> <a href="<?php echo site_url('home');?>"> <img class="admin-panel-logo" src="<?php echo site_url().'../default/images/americanbars.png';?>"> </a> </div>
			<!--<div class="inner_page_logo"> <a href="<?php echo site_url('home');?>"> <img src="<?php  echo $them_url; ?>/images/PokaTalk Logo.png" height="50" width="50"> </a> </div>-->
		</div>
		<div class="fl_right">
			<!--	<meta name="google-translate-customization" content="80af9f181981cb2a-730b0761a2b0abee-gb80eef4c8a286f8c-14"></meta>-->

</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
			<?php if(check_admin_authentication())
					{?>
				<p class="User_name fl_left"><?php echo $this->lang->line("admin.welcome");?>, <?php echo get_admin_login_name(get_authenticateadminID()); ?></p>
				
			<div class="fl_left">
			<a  href="<?php echo site_url('home/logout');?>" class="btn black btn_height2"><i class="logout_icon"> </i><?php echo $this->lang->line("admin.logout");?></a>
			</div>
			<?php }?>	
			
			
			<!--<a href='<?php echo site_url('langswitch/switchlanguage/english');?>'><img alt="" src="<?php echo base_url().getThemeName(); ?>/images/english.png"> </a>
			<a href='<?php echo site_url('langswitch/switchlanguage/french');?>'><img alt="" src="<?php echo base_url().getThemeName(); ?>/images/french.png"> </a>-->

			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
  </div>
</div>
<!--HEADER FINISH-->