

     			

<div class="vertical_menu">
     				<ul>
     					<?php if($this->session->userdata('user_type')=='bar_owner'){ 
     						$getbarinfo = getBarInfoByUserID(get_authenticateUserID());
							//echo $getbarinfo->serve_as;
     						?>
     					<li class="<?php echo $this->uri->segment(2)=='dashboard' ? 'active':'';?> ">
     						<a href="<?php echo site_url('home/dashboard')?>">
     							<i class="strip bar_profile"></i>
     							My Profile
     						</a>
     					</li>
                                        <li class="<?php echo $this->uri->segment(2)=='dashboard' ? 'active':'';?>">
     						<a href="<?php echo site_url('home/drink_menu')?>">
     							<i class="strip cocktails"></i>
     							Drinks
     						</a>
     					</li>
                                        
                                        
                                            <?php if ($getbarinfo->bar_type=='full_mug') { // fullmug dashboard menu ?>
                                            <li title="Add your bar's happy hours here." class="active">
                                                    <a href="<?php echo site_url('bar/bar_special_hours')?>">
                                                            <i class="strip bar-special"></i>
                                                            Happy Hours
                                                    </a>
                                            </li>
                                            <li title="Notify your fans of events." class="<?php echo $this->uri->segment(2)=='socialshare' || $this->uri->segment(2)=='twitterpost' || $this->uri->segment(2)=='facebookpost' || $this->uri->segment(2)=='instagrampost' ? 'active':'';?>">
                                                    <a href="<?php echo site_url('home/socialshare')?>">
                                                            <i class="strip social_share"></i>
                                                            Be Social
                                                    </a>
                                            </li>
                                            <li title="Add events." class="<?php echo $this->uri->segment(2)=='bar_events' ? 'active':'';?>">
                                                    <a href="<?php echo site_url('bar/bar_events')?>">
                                                            <i class="strip events"></i>
                                                            Events
                                                    </a>
                                            </li>

                                            <li title="View/add photos." class="<?php echo $this->uri->segment(2)=='bar_gallery' ? 'active':'';?>">
                                                    <a href="<?php echo site_url('bar/bar_gallery')?>">
                                                            <i class="strip gallery"></i>
                                                            My Albums
                                                    </a>
                                            </li>
                                            <li title="View comments." class="<?php echo $this->uri->segment(2)=='comments' ? 'active':'';?>">
                                                    <a href="<?php echo site_url('bar/comments')?>">
                                                            <i class="strip comments"></i>
                                                            Comments
                                                    </a>
                                            </li>
    <!--                                        <li style="position: relative;" class="<?php //echo $this->uri->segment(2)=='barlistings' ? 'active':'';?>">
                                                    <a href="<?php // echo site_url('home/barlistings')?>">
                                                            <p>
                                                                    <i class="bar-listings"></i>
                                                            </p>
                                                            Bar Listings
                                                    </a>
                                            </li>-->

    <!--                                        <li style="position: relative;" class="<?php // echo $this->uri->segment(2)=='domainmanagement' ? 'active':'';?>">
                                                    <a href="<?php // echo site_url('home/domainmanagement')?>">
                                                            <p>
                                                                    <i class="domain-settings"></i>
                                                            </p>
                                                            Domain Management 
                                                    </a>
                                            </li>-->

    <!--     					<li class="<?php // echo $this->uri->segment(2)=='updatecard' ? 'active':'';?>">
                                                    <a href="<?php // echo site_url('home/updatecard')?>">
                                                            <i class="strip update_creditcard"></i>
                                                            Update Credit Card
                                                    </a>
                                            </li>-->




                                            <!-- <li title="<?php // if($getbarinfo->bar_type=='half_mug'){ ?>Please upgrade your account half mug To full mug bar for access this feature.<?php // } ?>" class="<?php // echo $this->uri->segment(2)=='product_logo' ? 'active':'';?> <?php // if($getbarinfo->bar_type=='half_mug'){ echo "gray_bg"; }?>">
                                                    <a href="<?php // echo site_url('bar/product_logo')?>">
                                                            <i class="strip prod_logo"></i>
                                                            Product Logo
                                                    </a>
                                            </li> -->

                                            <!-- <li title="<?php // if($getbarinfo->bar_type=='half_mug'){ ?>Please upgrade your account half mug To full mug bar for access this feature.<?php // } ?>" class="<?php // echo $this->uri->segment(2)=='product_setting' ? 'active':'';?> <?php // if($getbarinfo->bar_type=='half_mug'){ echo "gray_bg"; }?>">
                                                    <a href="<?php // echo site_url('bar/product_setting')?>">
                                                            <i class="strip prod_setting"></i>
                                                            Product Setting
                                                    </a>
                                            </li>

                                            <li title="<?php // if($getbarinfo->bar_type=='half_mug'){ ?>Please upgrade your account half mug To full mug bar for access this feature.<?php // } ?>" class="<?php // echo $this->uri->segment(2)=='paypal_setting' ? 'active':'';?> <?php // if($getbarinfo->bar_type=='half_mug'){ echo "gray_bg"; }?>">
                                                    <a href="<?php // echo site_url('bar/paypal_setting')?>">
                                                            <i class="strip paypal-setting"></i>
                                                            Paypal Setting
                                                    </a>
                                            </li> 

                                            <li title="<?php // if($getbarinfo->bar_type=='half_mug'){ ?>Please upgrade your account half mug To full mug bar for access this feature.<?php // } ?>" class="<?php // echo $this->uri->segment(2)=='myproduct' ? 'active':'';?> <?php // if($getbarinfo->bar_type=='half_mug'){ echo "gray_bg"; }?>">
                                                    <a href="<?php // echo site_url('bar/myproduct')?>">
                                                            <i class="strip my-products"></i>
                                                            My Products
                                                    </a>
                                            </li>

                                                    <li title="<?php // if($getbarinfo->bar_type=='half_mug'){ ?>Please upgrade your account half mug To full mug bar for access this feature.<?php // } ?>" class="<?php // echo $this->uri->segment(2)=='all_orders' ? 'active':'';?> <?php // if($getbarinfo->bar_type=='half_mug'){ echo "gray_bg"; }?> ">
                                                    <a href="<?php // echo site_url('bar/all_orders')?>">
                                                            <i class="strip all_orders"></i>
                                                            All Orders
                                                    </a>
                                            </li>-->
                        
                                                
                                                
                                                
                                            <?php } else { // halfmug disabled buttons ?>
                                            <li title="<?php if($getbarinfo->bar_type=='half_mug'){ ?>Please upgrade your account from Half Mug to Full Mug bar for access to this feature.<?php } ?>" class="<?php echo $this->uri->segment(2)=='bar_special_hours' ? 'active':'';?> <?php if($getbarinfo->bar_type=='half_mug'){ echo "gray_bg"; }?>">
                                                <a href="<?php echo site_url('bar/bar_special_hours')?>">
                                                        <i class="strip bar-special"></i>
                                                        Happy Hours
                                                </a>
                                            </li>
                                            <li title="<?php if($getbarinfo->bar_type=='half_mug'){ ?>Please upgrade your account from Half Mug to Full Mug bar for access to this feature.<?php } ?>" class="<?php echo $this->uri->segment(2)=='socialshare' || $this->uri->segment(2)=='twitterpost' || $this->uri->segment(2)=='facebookpost' || $this->uri->segment(2)=='instagrampost' ? 'active':'';?> <?php if($getbarinfo->bar_type=='half_mug'){ echo "gray_bg"; }?>">
                                                    <a href="<?php echo site_url('home/socialshare')?>">
                                                            <i class="strip social_share"></i>
                                                            Be Social
                                                    </a>
                                            </li>
                                            <li title="<?php if($getbarinfo->bar_type=='half_mug'){ ?>Please upgrade your account from Half Mug to Full Mug bar for access to this feature.<?php } ?>" class="<?php echo $this->uri->segment(2)=='bar_events' ? 'active':'';?> <?php if($getbarinfo->bar_type=='half_mug'){ echo "gray_bg"; }?>">
                                                    <a href="<?php echo site_url('bar/bar_events')?>">
                                                            <i class="strip events"></i>
                                                            Events
                                                    </a>
                                            </li>

                                            <li title="<?php if($getbarinfo->bar_type=='half_mug'){ ?>Please upgrade your account from Half Mug to Full Mug bar for access to this feature.<?php } ?>" class="<?php echo $this->uri->segment(2)=='bar_gallery' ? 'active':'';?> <?php if($getbarinfo->bar_type=='half_mug'){ echo "gray_bg"; }?>">
                                                    <a href="<?php echo site_url('bar/bar_gallery')?>">
                                                            <i class="strip gallery"></i>
                                                            My Albums
                                                    </a>
                                            </li>
                                            <li title="<?php if($getbarinfo->bar_type=='half_mug'){ ?>Please upgrade your account from Half Mug to Full Mug bar for access to this feature.<?php } ?>" class="<?php echo $this->uri->segment(2)=='comments' ? 'active':'';?> <?php if($getbarinfo->bar_type=='half_mug'){ echo "gray_bg"; }?>">
                                                    <a href="<?php echo site_url('bar/comments')?>">
                                                            <i class="strip comments"></i>
                                                            Comments
                                                    </a>
                                            </li>
                                            <?php } ?>
                                            
                                            
                                            
                                            
                                            
                                            
                                            
     					<?php } else {?>
     						<li class="<?php echo $this->uri->segment(2)=='user_dashboard' ? 'active':'';?>">
     						<a href="<?php echo site_url('home/user_dashboard')?>">
     							<i class="strip bar_profile"></i>
     							My Profile
     						</a>
     					</li>
     					
     					<li class="<?php echo $this->uri->segment(2)=='favoritebar' ? 'active':'';?>">
     						<a href="<?php echo site_url('user/favoritebar')?>">
     							<i class="strip bar"></i>
     							My Bar List
     						</a>
     					</li>
     					
     					<li class="<?php echo $this->uri->segment(2)=='favoritebeer' ? 'active':'';?>">
     						<a href="<?php echo site_url('user/favoritebeer')?>">
     							<i class="strip beers"></i>
     							My Beer List
     						</a>
     					</li>
     					
     					<li class="<?php echo $this->uri->segment(2)=='favoritecocktail' ? 'active':'';?>">
     						<a href="<?php echo site_url('user/favoritecocktail')?>">
     							<i class="strip cocktails"></i>
     							My Cocktail List
     						</a>
     					</li>
     					
     					<li class="<?php echo $this->uri->segment(2)=='favoriteliquor' ? 'active':'';?>">
     						<a href="<?php echo site_url('user/favoriteliquor')?>">
     							<i class="strip liquor"></i>
     							 My Liquor List 
     						</a>
     					</li>
     					
     					<li class="<?php echo $this->uri->segment(2)=='album' ? 'active':'';?>">
     						<a href="<?php echo site_url('user/album')?>">
     							<i class="strip gallery"></i>
     							 My Albums
     						</a>
     					</li>
     					
     					<li class="<?php echo $this->uri->segment(2)=='settings' ? 'active':'';?>">
     						<a href="<?php echo site_url('user/settings')?>">
     							<i class="strip change_pwd"></i>
     							Privacy Settings
     						</a>
     					</li>
     					<li class="<?php echo $this->uri->segment(2)=='orderhistory' ? 'active':'';?>">
     						<a href="<?php echo site_url('bar/orderhistory')?>">
     							<i class="strip all_orders"></i>
     							My Orders
     						</a>
     					</li>
     						<?php } ?> 											
<!--     						<li class="<?php echo $this->uri->segment(2)=='changepassword' ? 'active':'';?>">
     						<a href="<?php //echo site_url('home/changepassword')?>">
     							<i class="strip change_pwd"></i>
     						<li class="<?php //echo $this->uri->segment(2)=='changepassword' ? 'active':'';?>">
     							Change Password
     						</a>
     					</li>-->
     					
<!--     					<li class="<?php echo $this->uri->segment(2)=='updatebanner' ? 'active':'';?>">
     						<a href="<?php //echo site_url('home/updatebanner')?>">
     							<i class="strip update_banner"></i>
     							Update Banner
     						</a>
     					</li>-->
                                        
                                        <li class="<?php echo $this->uri->segment(2)=='updatebanner' ? 'active':'';?>">
     						<a href="<?php echo site_url('home/settings_menu')?>">
     							<i class="strip update_banner"></i>
     							Account Settings
     						</a>
     					</li>
     							
     				</ul>
     			</div>
