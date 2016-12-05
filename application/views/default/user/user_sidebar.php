<?php 
$cont = $this->uri->segment(1);
$fun = $this->uri->segment(2);
$user_type=$this->session->userdata("user_type");
?>
<div class="videolist_left_block mart70">
		  			<ul class="videoside_menu">
		  				<li><a href="<?php echo site_url("user/myprofile"); ?>" <?php if($fun=="myprofile"){ ?>class="active" <?php }?>>My Profile</a></li>
		    			<?php if($user_type=='poker_coach' || $user_type=='poker_expert' ){ ?> <li><a href="<?php echo site_url("myvideo"); ?>" <?php if($cont=="myvideo"){ ?>class="active" <?php }?>>My Videos</a></li> <?php } ?>
		    			<li><a href="<?php echo site_url("myblog/myblog_list"); ?>" <?php if($cont=="myblog"){ ?>class="active" <?php }?> >My Blog</a></li>
		    			<?php if($user_type=='poker_coach' || $user_type=='poker_expert' || $user_type=='grinder' ){ ?> <li><a href="<?php echo site_url("myarticle/myarticle_list"); ?>" <?php if($cont=="myarticle"){ ?>class="active" <?php }?>>My Articles</a></li> <?php } ?>
		    			<li><a href="#">My Earnings</a></li>
		    			<?php if($user_type=='poker_coach' || $user_type=='poker_expert' ){ ?> <li><a href="<?php echo site_url("membership_plan"); ?>" <?php if($cont=="membership_plan"){ ?>class="active" <?php }?> >Membership Plan</a></li> <?php } ?>
		    		</ul>
  				</div>