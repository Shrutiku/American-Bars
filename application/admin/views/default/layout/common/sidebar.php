<!-- Left Content -->
<?php $uriseg=uri_string();
$uri=explode('/',$uriseg); 
 
?>
<script>
$(document).ready(function(){
	$('#drop_nav li').click(function(){
	
		if($(this).find('div').is(':hidden')){
			$(this).addClass("active").siblings().removeClass("active");
			$('.in_div').slideUp('fast');
				$(this).find('div.in_div').slideDown('fast');
			}
			
	});
});
</script>

<div id="container" >
<!-- Sidebar begins -->
		<div class="page-sidebar nav-collapse collapse">
			<ul class="sidebar_menu" id="drop_nav">
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='admin')?'active':''; ?>">
					<a href="<?php echo site_url('admin/list_admin') ?>">
						<i class="halflings-icon user white"></i>
						<span class="title">Admin</span>
					</a>
					<div style="display:<?php echo (isset($uri[0]) && $uri[0]=='admin')?'block':'none'; ?>;" class="in_div">
					<ul>
					<li><a href="<?php echo site_url('admin/list_admin') ?>" <?php echo (isset($uri[1]) && ($uri[1]=='list_admin' || $uri[1]=='add_admin' || $uri[1]=='edit_admin'))?'class="active"':''; ?>>List Admin</a></li>
					<?php /*?><li><?php echo anchor('home/logout','Logout') ?></li><?php */?>
					
					</ul>
					</div>
				</li>
				
				<!--<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='user')?'active':''; ?>">
					<a href="<?php echo site_url('user/list_user') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_user')?'class="active"':''; ?>>
						<i class="halflings-icon th-list white"></i>
						<span class="title">User</span>
					</a>
				</li>-->
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='user')?'active':''; ?>">
					<a href="javascript://">
						<i class="halflings-icon user  white"> </i> <span class="title"> Users </span>
					</a>
					<div style="display:<?php echo (isset($uri[0]) && ($uri[0]=='user' || $uri[0]=='bar_user'  || $uri[0]=='taxi_owner'))?'block':'none'; ?>;" class="in_div">
					<ul class="sub-menu">
						<li>
							<a href="javascript:;" class="<?php echo (isset($uri[0]) && $uri[0]=='user' && ($uri[1]=='list_enthusiast_user' || $uri[1]=='edit_user' || $uri[1]=='search_list_user') && (@$uri[2]=='inactive' || @$uri[2]=='active'))?'active':''; ?>" >
					  <span class="title">Enthusiast Users</span>
							<span class="arrow"></span>
							</a>
							<ul class="sub-menu" style="margin-top: 0; display:<?php echo (isset($uri[0]) && $uri[0]=='user' && ($uri[1]=='list_enthusiast_user' || $uri[1]=='edit_user' || $uri[1]=='search_list_user'))?'block':'none'; ?>;">
								<li ><a class="<?php echo (isset($uri[0]) && $uri[0]=='user' && ($uri[1]=='list_enthusiast_user' ||   $uri[1]=='search_list_user' || $uri[1]=='edit_user') && @$uri[2]=='active')?'active':''; ?>" href="<?php echo site_url('user/list_enthusiast_user/active/')?>">Active Enthusiast</a></li>
								<li><a  class="<?php echo (isset($uri[0]) && $uri[0]=='user' && $uri[1]=='list_enthusiast_user'&& @$uri[2]=='inactive')?'active':''; ?>" href="<?php echo site_url('user/list_enthusiast_user/inactive/')?>">Inactive Enthusiast</a></li>
							</ul>
						</li>
						<li>
						<a href="javascript:;" class="<?php echo (isset($uri[0]) && $uri[0]=='bar_user' && ($uri[1]=='list_bar_user' || $uri[1]=='search_list_bar_user' || $uri[1]=='edit_bar_user') && (@$uri[2]=='inactive' || @$uri[2]=='active'))?'active':''; ?>" >
							<span class="title">Bar Owner Users</span>
							<span class="arrow"></span>
							</a>
							<ul class="sub-menu" style="margin-top: 0; display:<?php echo (isset($uri[0]) && $uri[0]=='bar_user' && ($uri[1]=='list_bar_user' || $uri[1]=='search_list_bar_user' || $uri[1]=='edit_bar_user'))?'block':'none'; ?>;">
								<li><a  class="<?php echo (isset($uri[0]) && $uri[0]=='bar_user' && ($uri[1]=='list_bar_user' || $uri[1]=='search_list_bar_user' || $uri[1]=='edit_bar_user') && @$uri[2]=='active')?'active':''; ?>" href="<?php echo site_url('bar_user/list_bar_user/active/')?>">Active Bar Owners</a></li>
								<li><a class="<?php echo (isset($uri[0]) && $uri[0]=='bar_user' && ($uri[1]=='list_bar_user' || $uri[1]=='search_list_bar_user' || $uri[1]=='edit_bar_user') && @$uri[2]=='inactive')?'active':''; ?>" href="<?php echo site_url('bar_user/list_bar_user/inactive/')?>">Inactive Bar Owners</a></li>
							</ul>
						</li>
						<li>
							<a href="javascript:;" class="<?php echo (isset($uri[0]) && $uri[0]=='taxi_owner' && ($uri[1]=='list_taxi_owner' || $uri[1]=='search_list_taxi_owner' || $uri[1]=='edit_taxi_owner') && (@$uri[2]=='inactive' || @$uri[2]=='active'))?'active':''; ?>" >
							<span class="title">Taxi Owner Users</span>
							<span class="arrow"></span>
							</a>
							<ul class="sub-menu" style="margin-top: 0; display:<?php echo (isset($uri[0]) && $uri[0]=='taxi_owner' && ($uri[1]=='list_taxi_owner' || $uri[1]=='search_list_taxi_owner' || $uri[1]=='edit_taxi_owner'))?'block':'none'; ?>;">
								<li><a  class="<?php echo (isset($uri[0]) && $uri[0]=='taxi_owner' && ($uri[1]=='list_taxi_owner' || $uri[1]=='search_list_taxi_owner' || $uri[1]=='edit_taxi_owner') && @$uri[2]=='active')?'active':''; ?>" href="<?php echo site_url('taxi_owner/list_taxi_owner/active/')?>">Active Taxi Owners</a></li>
								<li><a class="<?php echo (isset($uri[0]) && $uri[0]=='taxi_owner' && ($uri[1]=='list_taxi_owner' || $uri[1]=='search_list_taxi_owner' || $uri[1]=='edit_taxi_owner') && @$uri[2]=='inactive')?'active':''; ?>" href="<?php echo site_url('taxi_owner/list_taxi_owner/inactive/')?>">Inactive Taxi Owners</a></li>
							</ul>
						</li>
					</ul>
					</div>
				</li>
                                
                                <li class="menu_tag <?php echo '';//echo ($uri[1]=='list_suggest_bar' || $uri[1]=='edit_suggest_bar' ||  $uri[1]=='search_list_suggest_bar' || $uri[1]=='view_suggest_bar')?'active':''; ?>">
					<a href="<?php echo site_url('ambassador') ?>" <?php echo '';// echo (isset($uri[1]) && ($uri[1]=='list_suggest_bar' || $uri[1]=='view_suggest_bar' || $uri[1]=='search_list_suggest_bar'))?'class="active"':''; ?>><!--<span class="badge badge-info"><?php // echo get_unread_sugbar();?></span>-->
						<i class="halflings-icon user white"></i>
						<span class="title"> Ambassadors </span>
					</a>
				</li>
                                
				<!-- <li class="menu_tag <?php echo (isset($uri[0]) && ($uri[0]=='user' || $uri[0]=='taxi_owner'  ))?'active':''; ?>">
					<a href="javascript://">
						<i class="halflings-icon user  white"> </i> <span class="title"> Users </span>
					</a>
					<div style="display:<?php echo (isset($uri[0]) && ($uri[1]=='list_user' || $uri[1]=='list_taxi_owner'   || $uri[1]=='add_taxi_owner' || $uri[1]=='edit_taxi_owner' ||  $uri[1]=='list_enthusiast_user' || @$uri[3]=='list_enthusiast_user' || @$uri[3]=='list_bar_user' || $uri[1]=='list_bar_user' || $uri[1]=='list_poker' || $uri[1]=='list_album' || $uri[1]=='add_album' || $uri[1]=='edit_album' ) )?'block':'none'; ?>;" class="in_div">
						<ul>
							
							<li>
								<a href="<?php echo site_url('user/list_enthusiast_user') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_enthusiast_user' ||  $uri[1]=='list_album' || @$uri[3]=='list_enthusiast_user' || $uri[1]=='add_album' || $uri[1]=='edit_album')?'class="active"':''; ?>>
									<span class="title">Enthusiast Users</span>
								</a>			
							</li>
							
							<li>
								<a href="<?php echo site_url('bar_user/list_bar_user') ?>" <?php echo (isset($uri[1]) && (@$uri[3]=='list_bar_user' || $uri[1]=='list_bar_user'))?'class="active"':''; ?>>
									<span class="title">Bar Owner Users</span>
								</a>			
							</li>
							
							<li>
								<a href="<?php echo site_url('taxi_owner/list_taxi_owner') ?>" <?php echo (isset($uri[1]) && (@$uri[3]=='list_taxi_owner' || $uri[1]=='list_taxi_owner' || $uri[1]=='add_taxi_owner'))?'class="active"':''; ?>>
									<span class="title">Taxi Owner Users</span>
								</a>			
							</li>
							
						</ul>
					</div>
					
				</li> -->
				
				
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='bar')?'active':''; ?>">
					<a href="javascript://">
						<i class="sidebar_icon bar_icon"> </i> <span class="title"> Bars </span>
					</a>
					<?php //echo $uri[0]; die;?>
					
					<?php if($uri[0]=="bar_gallery"){?>
						<div style="display:<?php echo (isset($uri[0]) && ($uri[0]=='bar_gallery' ) )?'block':'none'; ?>;" class="in_div">
						<?php } else {?>
					<div style="display:<?php echo (isset($uri[0]) && ($uri[1]=='list_bar' || $uri[1]=='list_bar' ) )?'block':'none'; ?>;" class="in_div">
						<?php } ?>
						<ul>
							<li>
								<a href="<?php echo site_url('bar/list_bar/all') ?>" <?php echo (isset($uri[2]) && $uri[2]=='all')?'class="active"':''; ?>>
									<span class="title">All Bars</span>
								</a>			
							</li>
							<li>
								<?php if($uri[0]=="bar_gallery"){?>
									<a href="<?php echo site_url('bar/list_bar/full_mug') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_gallery' ||  $uri[1]=='add_gallery' ||$uri[1]=='search_list_gallery' || @$uri[2]=='add_gallery' || @$uri[2]=='edit_gallery')?'class="active"':''; ?>>
									<?php } else {?>
								<a href="<?php echo site_url('bar/list_bar/full_mug') ?>" <?php echo (isset($uri[2]) && $uri[2]=='full_mug')?'class="active"':''; ?>>
									<?php } ?>
									<span class="title">Full Mug bars</span>
								</a>			
							</li>
							<li>
								<a href="<?php echo site_url('bar/list_bar/managed_bar') ?>" <?php echo (isset($uri[2]) && $uri[2]=='managed_bar')?'class="active"':''; ?>>
									<span class="title">Managed Full Mugs</span>
								</a>			
							</li>
							<li>
								<a href="<?php echo site_url('bar/list_bar/half_mug') ?>" <?php echo (isset($uri[2]) && $uri[2]=='half_mug')?'class="active"':''; ?>>
									<span class="title">Half Mug bars</span>
								</a>			
							</li>
                                                        <li>
								<a href="<?php echo site_url('bar/list_bar/half_mug_claimed_bar') ?>" <?php echo (isset($uri[2]) && $uri[2]=='claimed_bar')?'class="active"':''; ?>>
									<span class="title">Half Mug Claimed bars</span>
								</a>			
							</li>
                                                                                        <li>
								<a href="<?php echo site_url('bar/list_bar/half_mug_unclaimed_bar') ?>" <?php echo (isset($uri[2]) && $uri[2]=='claimed_bar')?'class="active"':''; ?>>
									<span class="title">Half Mug Unclaimed bars</span>
								</a>			
							</li>
							
							<!-- <li>
								<a href="<?php echo site_url('user/list_poker') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_poker')?'class="active"':''; ?>>
									<span class="title">Poker List</span>
								</a>			
							</li> -->
						</ul>
					</div>
				</li>
				
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='archived_bar')?'active':''; ?>">
					<a href="javascript://">
						<i class="sidebar_icon bar_icon"> </i> <span class="title">Archived Bars </span>
					</a>
					<?php //echo $uri[0]; die;?>
					
					<?php if($uri[0]=="bar_gallery"){?>
						<div style="display:<?php echo (isset($uri[0]) && ($uri[0]=='bar_gallery' ) )?'block':'none'; ?>;" class="in_div">
						<?php } else {?>
					<div style="display:<?php echo (isset($uri[0]) && ($uri[1]=='list_archived_bar' || $uri[1]=='search_list_archived_bar' || $uri[1]=='list_archived_bar' ) )?'block':'none'; ?>;" class="in_div">
						<?php } ?>
						<ul>
							<li>
								<a href="<?php echo site_url('archived_bar/list_archived_bar/all') ?>" <?php echo (isset($uri[2]) && $uri[2]=='all')?'class="active"':''; ?>>
									<span class="title">All Archived Bars</span>
								</a>			
							</li>
							<li>
								<?php if($uri[0]=="bar_gallery"){?>
									<a href="<?php echo site_url('archived_bar/list_archived_bar/full_mug') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_gallery' ||  $uri[1]=='add_gallery' ||$uri[1]=='search_list_gallery' || @$uri[2]=='add_gallery' || @$uri[2]=='edit_gallery')?'class="active"':''; ?>>
									<?php } else {?>
								<a href="<?php echo site_url('archived_bar/list_archived_bar/full_mug') ?>" <?php echo (isset($uri[2]) && $uri[2]=='full_mug')?'class="active"':''; ?>>
									<?php } ?>
									<span class="title">Full Mug Archived Bars</span>
								</a>			
							</li>
							
							<li>
								<a href="<?php echo site_url('archived_bar/list_archived_bar/half_mug') ?>" <?php echo (isset($uri[2]) && $uri[2]=='half_mug')?'class="active"':''; ?>>
									<span class="title">Half Mug Archived bars</span>
								</a>			
							</li>
							<!-- <li>
								<a href="<?php echo site_url('user/list_poker') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_poker')?'class="active"':''; ?>>
									<span class="title">Poker List</span>
								</a>			
							</li> -->
						</ul>
					</div>
					
				</li>
				
				
				
				<li class="menu_tag <?php echo ($uri[1]=='list_suggest_bar' || $uri[1]=='edit_suggest_bar' ||  $uri[1]=='search_list_suggest_bar' || $uri[1]=='view_suggest_bar')?'active':''; ?>">
					<a href="<?php echo site_url('suggest_bar/list_suggest_bar') ?>" <?php echo (isset($uri[1]) && ($uri[1]=='list_suggest_bar' || $uri[1]=='view_suggest_bar' || $uri[1]=='search_list_suggest_bar'))?'class="active"':''; ?>><span class="badge badge-info"><?php echo get_unread_sugbar();?></span>
						<i class="sidebar_icon suggest_icon"></i>
						<span class="title"> Suggested Bars</span>
					</a>
				</li>
			
				<li class="menu_tag <?php echo (isset($uri[0]) && ($uri[0]=='bar_category' || $uri[0]=='event_category' ))?'active':''; ?>">
					<a href="javascript://">
						<i class="sidebar_icon cocktail_icon"> </i> <span class="title"> Category Management </span>
					</a>
					<div style="display:<?php echo (isset($uri[0]) && ($uri[1]=='search_list_bar_category' || $uri[1]=='search_list_event_category' || $uri[1]=='add_bar_category'  || $uri[1]=='add_event_category' || $uri[1]=='edit_bar_category'  || $uri[1]=='edit_event_category' || $uri[1]=='list_bar_category' || $uri[1]=='list_event_category'))?'block':'none'; ?>;" class="in_div">
					<ul>
					<li><a href="<?php echo site_url('bar_category/list_bar_category') ?>" <?php echo (isset($uri[1]) && ($uri[1]=='add_bar_category' || $uri[1]=='search_list_bar_category' || $uri[1]=='edit_bar_category' || $uri[1]=='list_bar_category'))?'class="active"':''; ?>>Bar Category</a></li>
					<li><a href="<?php echo site_url('event_category/list_event_category') ?>" <?php echo (isset($uri[1]) &&  ($uri[1]=='edit_bar_category'  || $uri[1]=='add_event_category' || $uri[1]=='search_list_event_category' || $uri[1]=='edit_event_category' || $uri[1]=='list_event_category'))?'class="active"':''; ?>>Event Category</a></li>
					<!--<li><a href="<?php echo site_url('site_setting/yahoo_setting') ?>" <?php echo (isset($uri[1]) && $uri[1]=='yahoo_setting')?'class="active"':''; ?>>Yahoo Setting</a></li>-->
					</ul>
					</div>
				</li>
							
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]!='postcard' && ($uri[0]=='beer' || $uri[0]=='beer_suggestion')  && ($uri[1]=='list_beer' || $uri[1]=='view_beer_comment'  || $uri[1]=='add_beer'  || $uri[1]=='edit_beer' || $uri[1]=='search_list_beer_suggestion' ||  $uri[1]=='view' ||  $uri[1]=='search_list_beer' || $uri[1]=='list_beer_suggestion'))?'active':''; ?>">
					<a href="javascript://">
						<i class="sidebar_icon beer_icon"> </i> <span class="title"> Beer Directory </span>
					</a>
					<div style="display:<?php echo (isset($uri[0]) && $uri[0]!='postcard'  && ($uri[1]=='list_beer' || $uri[1]=='view1' || $uri[1]=='view_beer_comment' || $uri[1]=='list_beer_suggestion' || $uri[1]=='edit_beer' || $uri[1]=='add_beer' || $uri[1]=='search_list_beer' || $uri[1]=='search_list_beer_suggestion'))?'block':'none'; ?>;" class="in_div">
					<ul>
					<li><a href="<?php echo site_url('beer/list_beer') ?>" <?php echo (isset($uri[1]) && ($uri[1]=='list_beer' || $uri[1]=='add_beer' || $uri[1]=='view_beer_comment'  || $uri[1]=='edit_beer' ||  $uri[1]=='search_list_beer' ))?'class="active"':''; ?>>Lists Beer</a></li>
					<li><a href="<?php echo site_url('beer_suggestion/list_beer_suggestion') ?>" <?php echo (isset($uri[1]) && $uri[0]!='postcard'  && ($uri[1]=='list_beer_suggestion' || $uri[1]=='search_list_beer_suggestion' || $uri[1]=='view'))?'class="active"':''; ?>><span class="badge badge-info"><?php echo get_unread_beer();?></span>Beers Suggestion List</a></li>
					<!--<li><a href="<?php echo site_url('site_setting/yahoo_setting') ?>" <?php echo (isset($uri[1]) && $uri[1]=='yahoo_setting')?'class="active"':''; ?>>Yahoo Setting</a></li>-->
					</ul>
					</div>
				</li>	
				
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='archived_beer')?'active':''; ?>">
					<a href="<?php echo site_url('archived_beer/list_archived_beer') ?>" <?php echo (isset($uri[1]) && $uri[1]=='archived_beer')?'class="active"':''; ?>>
						<i class="sidebar_icon beer_icon"></i>
						<span class="title">Archived Beers</span>
					</a>
				</li>
				
				
				
				<li class="menu_tag <?php echo (isset($uri[0]) && ($uri[0]=='cocktail' || $uri[0]=='cocktail_suggestion'  || $uri[0]=='beer_cocktail') && ($uri[1]=='list_cocktail' || $uri[1]=='view_cocktail_comment' || $uri[1]=='edit_cocktail' || $uri[1]=='list_cocktail_suggestion' || $uri[1]=='viewcoktail'|| $uri[1]=='add_cocktail' || $uri[1]=='search_list_cocktail_suggestion' ||  $uri[1]=='search_list_beer' || $uri[1]=='list_beer_suggestion'))?'active':''; ?>">
					<a href="javascript://">
						<i class="sidebar_icon cocktail_icon"> </i> <span class="title"> Cocktail Directory </span>
					</a>
					<div style="display:<?php echo (isset($uri[0]) && ($uri[1]=='list_cocktail' || $uri[1]=='viewcoktail' || $uri[1]=='list_cocktail_suggestion' || $uri[1]=='view_cocktail_comment' || $uri[1]=='edit_cocktail' || $uri[1]=='add_cocktail' || $uri[1]=='search_list_cocktail' || $uri[1]=='search_list_cocktail_suggestion'))?'block':'none'; ?>;" class="in_div">
					<ul>
					<li><a href="<?php echo site_url('cocktail/list_cocktail') ?>" <?php echo (isset($uri[1]) && ($uri[1]=='list_cocktail' || $uri[1]=='view_cocktail_comment' || $uri[1]=='add_cocktail' || $uri[1]=='edit_cocktail' ||   $uri[1]=='search_list_cocktail' ))?'class="active"':''; ?>>List Cocktails</a></li>
					<li><a href="<?php echo site_url('cocktail_suggestion/list_cocktail_suggestion') ?>" <?php echo (isset($uri[1]) &&  $uri[1]=='viewcoktail' || $uri[1]=='list_cocktail_suggestion' || $uri[1]=='search_list_cocktail_suggestion')?'class="active"':''; ?>><span class="badge badge-info"><?php echo get_unread_cocktail();?></span>Cocktails Suggestion List</a></li>
					<!--<li><a href="<?php echo site_url('site_setting/yahoo_setting') ?>" <?php echo (isset($uri[1]) && $uri[1]=='yahoo_setting')?'class="active"':''; ?>>Yahoo Setting</a></li>-->
					</ul>
					</div>
				</li>
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='archived_cocktail')?'active':''; ?>">
					<a href="<?php echo site_url('archived_cocktail/list_archived_cocktail') ?>" <?php echo (isset($uri[1]) && $uri[1]=='archived_cocktail')?'class="active"':''; ?>>
						<i class="sidebar_icon cocktail_icon"></i>
						<span class="title">Archived Cocktails</span>
					</a>
				</li>
				<li class="menu_tag <?php echo (isset($uri[0]) && ($uri[0]=='liquor' || $uri[0]=='liquor_suggestion'|| $uri[0]=='beer_cocktail') && ($uri[1]=='list_liquor' || $uri[1]=='view_liquor_comment' || $uri[1]=='edit_liquor' || $uri[1]=='viewliquor' || $uri[1]=='add_liquor' || $uri[1]=='search_list_liquor_suggestion' || $uri[1]=='list_liquor_suggestion' ||  $uri[1]=='search_list_beer' || $uri[1]=='list_beer_suggestion'))?'active':''; ?>">
					<a href="javascript://">
						<i class="sidebar_icon liquor_icon"> </i> <span class="title"> Liquor Directory </span>
					</a>
					<div style="display:<?php echo (isset($uri[0]) && ($uri[1]=='list_liquor'  || $uri[1]=='viewliquor'  || $uri[1]=='list_liquor_suggestion' || $uri[1]=='view_liquor_comment' || $uri[1]=='edit_liquor' || $uri[1]=='add_liquor' || $uri[1]=='search_list_liquor' || $uri[1]=='search_list_liquor_suggestion'))?'block':'none'; ?>;" class="in_div">
					<ul>
					<li><a href="<?php echo site_url('liquor/list_liquor') ?>" <?php echo (isset($uri[1]) && ($uri[1]=='list_liquor' || $uri[1]=='add_liquor' || $uri[1]=='view_liquor_comment' || $uri[1]=='edit_liquor' ||  $uri[1]=='search_list_liquor' ))?'class="active"':''; ?>>List Liquors</a></li>
					<li><a href="<?php echo site_url('liquor_suggestion/list_liquor_suggestion') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_liquor_suggestion' || $uri[1]=='viewliquor'  ||  $uri[1]=='search_list_liquor_suggestion')?'class="active"':''; ?>><span class="badge badge-info"><?php echo get_unread_liquor();?></span>Liquors Suggestion List</a></li>
					<!--<li><a href="<?php echo site_url('site_setting/yahoo_setting') ?>" <?php echo (isset($uri[1]) && $uri[1]=='yahoo_setting')?'class="active"':''; ?>>Yahoo Setting</a></li>-->
					</ul>
					</div>
				</li>	
				
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='archived_liquor')?'active':''; ?>">
					<a href="<?php echo site_url('archived_liquor/list_archived_liquor') ?>" <?php echo (isset($uri[1]) && $uri[1]=='archived_liquor')?'class="active"':''; ?>>
						<i class="sidebar_icon liquor_icon"></i>
						<span class="title">Archived Liquors</span>
					</a>
				</li>
				
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='taxi')?'active':''; ?>">
					<a href="<?php echo site_url('taxi/list_taxi') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_taxi')?'class="active"':''; ?>>
						<i class="sidebar_icon event_icon"></i>
						<span class="title">Taxi Directory</span>
					</a>
				</li>
				
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='archived_taxi')?'active':''; ?>">
					<a href="<?php echo site_url('archived_taxi/list_archived_taxi') ?>" <?php echo (isset($uri[1]) && $uri[1]=='archived_taxi')?'class="active"':''; ?>>
						<i class="sidebar_icon event_icon"></i>
						<span class="title">Archived Taxis</span>
					</a>
				</li>
				<!-- <li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='liquor')?'active':''; ?>">
					<a href="<?php echo site_url('liquor/list_liquor') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_liquor')?'class="active"':''; ?>>
						<i class="halflings-icon th-list white"></i>
						<span class="title">Liquors</span>
					</a>
				</li> -->
				
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='event')?'active':''; ?>">
					<a href="<?php echo site_url('event/list_event') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_event')?'class="active"':''; ?>>
						<i class="sidebar_icon event_icon"></i>
						<span class="title">Events</span>
					</a>
				</li>
				
				
				
				<li class="menu_tag <?php echo (isset($uri[0]) && ($uri[0]=='site_setting' || $uri[0]=='feature' || $uri[0]=='meta_setting' || $uri[0]=='message_setting' || $uri[0]=='email_setting' || $uri[0]=='image_setting' || $uri[0]=='email_template' || $uri[0]=='pages') && ($uri[1]=='add_meta_setting' || $uri[1]=='add_user_guide' || $uri[1]=='add_feature' || $uri[1]=='add_email_setting' || $uri[1]=='add_image_setting'  || $uri[1]=='paypal_setting' || $uri[1]=='add_site_setting'))?'active':''; ?>">
					<a href="javascript://">
						<i class="halflings-icon cog white"> </i> <span class="title"> Settings </span>
					</a>
					<div style="display:<?php echo (isset($uri[0]) && ($uri[1]=='paypal_setting'  || $uri[0]=='feature' || $uri[1]=='message_setting' || $uri[1]=='add_site_setting' || $uri[1]=='add_meta_setting' || $uri[1]=='add_email_setting' || $uri[0]=='meta_setting' ||  $uri[1]=='add_user_guide' || $uri[0]=='email_setting' || $uri[0]=='image_setting' || $uri[0]=='email_template' || $uri[0]=='pages') )?'block':'none'; ?>;" class="in_div">
					<ul>
					<li><a href="<?php echo site_url('site_setting/add_site_setting') ?>" <?php echo (isset($uri[1]) && $uri[1]=='add_site_setting')?'class="active"':''; ?>>Site Setting</a></li>
					<li><a href="<?php echo site_url('meta_setting/add_meta_setting') ?>" <?php echo (isset($uri[1]) && $uri[1]=='add_meta_setting')?'class="active"':''; ?>>Meta Setting</a></li>
					<!-- <li><a href="<?php echo site_url('email_setting/add_email_setting') ?>" <?php echo (isset($uri[1]) && $uri[1]=='add_email_setting')?'class="active"':''; ?>>Email Setting</a></li> -->
					<!-- <li><a href="<?php echo site_url('image_setting/add_image_setting') ?>" <?php echo (isset($uri[1]) && $uri[1]=='add_image_setting')?'class="active"':''; ?>>Image Setting</a></li> -->
					<li><a href="<?php echo site_url('email_template/list_email_template') ?>" <?php echo (isset($uri[0]) && $uri[0]=='email_template')?'class="active"':''; ?>>Email Template</a></li>
					<li><a href="<?php echo site_url('site_setting/paypal_setting') ?>" <?php echo (isset($uri[1]) && $uri[1]=='paypal_setting')?'class="active"':''; ?>>Paypal Setting</a></li>
					<li><a href="<?php echo site_url('site_setting/message_setting') ?>" <?php echo (isset($uri[1]) && $uri[1]=='message_setting')?'class="active"':''; ?>>Message Setting</a></li>
					<li><a href="<?php echo site_url('pages/') ?>" <?php echo (isset($uri[0]) && $uri[0]=='pages')?'class="active"':''; ?>>Pages</a></li>
					<li><a href="<?php echo site_url('feature') ?>" <?php echo (isset($uri[0]) && $uri[0]=='feature')?'class="active"':''; ?>> Registration Step2</a></li>
					<li><a href="<?php echo site_url('site_setting/add_user_guide') ?>" <?php echo (isset($uri[1]) && $uri[1]=='add_user_guide')?'class="active"':''; ?>>User Guide</a></li>
					</ul>
					</div>
				</li>
				
				<!-- <li class="menu_tag <?php echo (isset($uri[0]) && ($uri[0]=='site_setting') && ($uri[1]=='google_setting' || $uri[1]=='facebook_setting' || $uri[1]=='yahoo_setting' ))?'active':''; ?>">
					<a href="javascript://">
						<i class="halflings-icon cog white"> </i> <span class="title"> Social Settings </span>
					</a>
					<div style="display:<?php echo (isset($uri[0]) && ($uri[1]=='google_setting' || $uri[1]=='facebook_setting' || $uri[1]=='yahoo_setting'))?'block':'none'; ?>;" class="in_div">
					<ul>
					<li><a href="<?php echo site_url('site_setting/google_setting') ?>" <?php echo (isset($uri[1]) && $uri[1]=='google_setting')?'class="active"':''; ?>>Google Setting</a></li>
					<li><a href="<?php echo site_url('site_setting/facebook_setting') ?>" <?php echo (isset($uri[1]) && $uri[1]=='facebook_setting')?'class="active"':''; ?>>Facebook Setting</a></li>
					</ul>
					</div>
				</li>		 -->		
				
				<?php /*<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='testimonial')?'active':''; ?>">
					<a href="<?php echo site_url('testimonial/list_testimonial') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_testimonial')?'class="active"':''; ?>>
						<i class="halflings-icon comments white"></i>
						<span class="title">Testimonial</span>
					</a>
				</li>*/?>			
				
				<!-- <li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='faq')?'active':''; ?>">
					<a href="<?php echo site_url('faq/list_faq') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_faq')?'class="active"':''; ?>>
						<i class="halflings-icon th-list white"></i>
						<span class="title">FAQ</span>
					</a>
				</li> -->
				
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='message')?'active':''; ?>">
					<?php /*?><a href="<?php echo site_url('message/list_message') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_message')?'class="active"':''; ?>>
						<i class="halflings-icon white envelope"></i>
						<span class="title">Message</span>
					</a><?php */?>
					
					<a href="javascript://">
						<i class="halflings-icon white envelope"></i>
						<span class="title">Messages <span class="badge badge-info"><?php echo get_unread_message();?></span></span>
					</a>
					
					<div style="display:<?php echo (isset($uri[0]) && ($uri[0]=='message' || $uri[0]=='sent_message'))?'block':'none'; ?>;" class="in_div">
						<ul>
							<li><a href="<?php echo site_url('message/list_broadcast_message') ?>" <?php echo (isset($uri[1]) && ($uri[1]=='add_broadcast_message' || $uri[1]=='list_broadcast_message') )?'class="active"':''; ?>>Broadcast Message</a></li>
							<li><a href="<?php echo site_url('message/list_message') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_message')?'class="active"':''; ?>>Inbox</a></li>
							<li><a href="<?php echo site_url('message/sent_message') ?>" <?php echo (isset($uri[1]) && $uri[1]=='sent_message')?'class="active"':''; ?>>Sentbox</a></li>
							<li><a href="<?php echo site_url('message/list_push_notification') ?>" <?php echo (isset($uri[1]) && ($uri[1]=='list_push_notification' || $uri[1]=='send_push_notification'))?'class="active"':''; ?>>Push Notification</a></li>	
						</ul>	
					</div>
					
				</li>
				
				
				<!-- <li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='blog')?'active':''; ?>">
					<a href="<?php echo site_url('blog/list_blog') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_blog')?'class="active"':''; ?>>
						<i class="halflings-icon th-list white"></i>
						<span class="title">Blog</span>
					</a>
				</li> -->
				
				<!--<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='video')?'active':''; ?>">
					<a href="<?php echo site_url('video/list_video') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_video')?'class="active"':''; ?>>
						<i class="halflings-icon th-list white"></i>
						<span class="title">Video</span>
					</a>
				</li>-->
				
				
				
				
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='article')?'active':''; ?>">
					<a href="<?php echo site_url('article/list_article') ?>" <?php echo (isset($uri[1]) && $uri[1]=='article')?'class="active"':''; ?>>
						<i class="sidebar_icon article_icon"></i>
						<span class="title">Article</span>
					</a>
				</li>
				
				
				
				
				
				
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='form_category')?'active':''; ?>">
					<a href="<?php echo site_url('form_category/list_form_category') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_form_category')?'class="active"':''; ?>>
						<i class="sidebar_icon forum_icon"></i>
						<span class="title">Forum Category</span>
					</a>
				</li> 
				
				
				
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]!='postcard' && ($uri[0]=='forum' || $uri[0]=='forum_suggestion')  && ($uri[1]=='list_beer' || $uri[1]=='view_forum_comment'  || $uri[1]=='add_forum'  || $uri[1]=='edit_forum' || $uri[1]=='search_list_forum_suggestion' ||  $uri[1]=='view_forum' ||  $uri[1]=='search_list_forum' || $uri[1]=='list_forum_suggestion'))?'active':''; ?>">
					<a href="javascript://">
						<i class="sidebar_icon forum_icon"></i> <span class="title"> Forum </span>
					</a>
					<div style="display:<?php echo (isset($uri[0]) && $uri[0]!='postcard'  && ($uri[1]=='list_forum' || $uri[1]=='view_forum' || $uri[1]=='view_forum_comment' || $uri[1]=='list_forum_suggestion' || $uri[1]=='edit_forum' || $uri[1]=='add_forum' || $uri[1]=='search_list_forum' || $uri[1]=='search_list_forum_suggestion'))?'block':'none'; ?>;" class="in_div">
					<ul>
					<li><a href="<?php echo site_url('forum/list_forum') ?>" <?php echo (isset($uri[1]) && ($uri[1]=='list_forum' || $uri[1]=='add_forum' || $uri[1]=='view_forum_comment'  || $uri[1]=='edit_forum' ||  $uri[1]=='search_list_forum' ))?'class="active"':''; ?>>List Forum</a></li>
					<li><a href="<?php echo site_url('forum_suggestion/list_forum_suggestion') ?>" <?php echo (isset($uri[1]) && $uri[0]!='postcard'  && ($uri[1]=='list_forum_suggestion' || $uri[1]=='search_list_forum_suggestion' || $uri[1]=='view'))?'class="active"':''; ?>><span class="badge badge-info"><?php echo get_unread_forum();?></span>Forum Suggestion List</a></li>
					<!--<li><a href="<?php echo site_url('site_setting/yahoo_setting') ?>" <?php echo (isset($uri[1]) && $uri[1]=='yahoo_setting')?'class="active"':''; ?>>Yahoo Setting</a></li>-->
					</ul>
					</div>
				</li>	
				
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='news')?'active':''; ?>">
					<a href="<?php echo site_url('news/list_news') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_news')?'class="active"':''; ?>>
						<i class="sidebar_icon news_icon"></i>
						<span class="title">News</span>
					</a>
				</li>			
				
				<!-- <li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='barstatistic')?'active':''; ?>">
					<a href="<?php echo site_url('barstatistic/list_barstatistic') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_barstatistic')?'class="active"':''; ?>>
						<i class="sidebar_icon statistics_icon"></i>
						<span class="title">Bar Statistics</span>
					</a>
				</li> -->
				
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='gallery')?'active':''; ?>">
					<a href="<?php echo site_url('gallery/list_gallery') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_gallery')?'class="active"':''; ?>>
						<i class="sidebar_icon photo_icon"></i>
						<span class="title"> Photo Gallery </span>
					</a>
				</li>
				
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='advertisement')?'active':''; ?>">
					<a href="<?php echo site_url('advertisement/list_advertisement') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_advertisement')?'class="active"':''; ?>>
						<i class="sidebar_icon advertise_icon"></i>
						<span class="title"> Advertisement </span>
					</a>
				</li>
				
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='store')?'active':''; ?>">
					<a href="<?php echo site_url('store/list_store/') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_store')?'class="active"':''; ?>>
						<i class="sidebar_icon store_icon"></i>
						<span class="title">Bar Store Products </span>
					</a>
				</li>
				
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='order')?'active':''; ?>">
					<a href="<?php echo site_url('order/orderlist') ?>" <?php echo (isset($uri[1]) && $uri[1]=='orderlist')?'class="active"':''; ?>>
						<i class="sidebar_icon order_icon"></i>
						<span class="title">Bar Store Order and Shipping</span>
					</a>
				</li> 
			<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='adbstore')?'active':''; ?>">
					<a href="<?php echo site_url('adbstore/list_store/') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_store')?'class="active"':''; ?>>
						<i class="sidebar_icon store_icon"></i>
						<span class="title"> Store Products</span>
					</a>
				</li>
				
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='adborder')?'active':''; ?>">
					<a href="<?php echo site_url('adborder/orderlist') ?>" <?php echo (isset($uri[1]) && $uri[1]=='orderlist')?'class="active"':''; ?>>
						<i class="sidebar_icon order_icon"></i>
						<span class="title">Order And Shipping</span>
					</a>
				</li> 
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='postcard')?'active':''; ?>">
					<a href="<?php echo site_url('postcard/list_postcard/') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_postcard')?'class="active"':''; ?>>
						<i class="sidebar_icon postcard_icon"></i>
						<span class="title"> Postcard </span>
					</a>
				</li>
				
			<?php ?><li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='resource')?'active':''; ?>">
					<a href="<?php echo site_url('resource/list_resource') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_resource')?'class="active"':''; ?>>
						<i class="sidebar_icon resource_icon"></i>
						<span class="title"> Resource </span>
					</a>
				</li>				
				
				<!-- 	<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='job')?'active':''; ?>">
					<a href="<?php echo site_url('job/list_job') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_job')?'class="active"':''; ?>>
						<i class="halflings-icon th-list white"></i>
						<span class="title"> Jobs </span>
					</a>
				</li> -->
				
				<!-- <li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='term')?'active':''; ?>">
					<a href="<?php echo site_url('term/list_term') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_term')?'class="active"':''; ?>>
						<i class="halflings-icon th-list white"></i>
						<span class="title"> Bar Term </span>
					</a>
				</li><?php ?>	 -->
				<!-- <li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='country')?'active':''; ?>">
				<a href="javascript://">
						<i class="home_icon"></i>
						<span class="title">Location</span>
					</a>
					<div style="display:<?php echo (isset($uri[0]) && ($uri[0]=='country' || $uri[0]=='state' || $uri[0]=='city'))?'block':'none'; ?>;" class="in_div">
					<ul>
					<li><a href="<?php echo site_url('country/list_country') ?>" <?php echo (isset($uri[0]) && $uri[0]=='country')?'class="active"':''; ?>>Country</a></li>
					<li><a href="<?php echo site_url('state/list_state') ?>" <?php echo (isset($uri[0]) && $uri[0]=='state')?'class="active"':''; ?>>State</a></li>
					<li><a href="<?php echo site_url('city/list_city') ?>" <?php echo (isset($uri[0]) && $uri[0]=='city')?'class="active"':''; ?>>City</a></li>
					</ul>
					</div>	
				</li> -->
				<li class="menu_tag <?php echo (isset($uri[0]) && ($uri[0]=='transaction' || $uri[0]=='payment_record')  && ($uri[1]=='list_transaction' || $uri[1]=='search_list_transaction' || $uri[1]=='list_payment_record' || $uri[1]=='search_list_payment_record'))?'active':''; ?>">
					<a href="javascript://">
						<i class="sidebar_icon reports_icon"></i> <span class="title"> Reports </span>
					</a>
					<div style="display:<?php echo (isset($uri[0]) && ($uri[0]=='transaction' || $uri[0]=='payment_record')  && ($uri[1]=='list_transaction' || $uri[1]=='search_list_transaction' || $uri[1]=='list_payment_record' || $uri[1]=='search_list_payment_record'))?'active':'none'; ?>"  class="in_div">
					<ul>
					<li><a href="<?php echo site_url('transaction/list_transaction') ?>" <?php echo (isset($uri[1]) && ($uri[1]=='list_transaction' || $uri[1]=='search_list_transaction'  ))?'class="active"':''; ?>>Product Order Payment Report</a></li>
					<li><a href="<?php echo site_url('payment_record/list_payment_record') ?>" <?php echo (isset($uri[1]) && $uri[0]!='postcard'  && ($uri[1]=='list_payment_record' || $uri[1]=='search_list_payment_record' ))?'class="active"':''; ?>>Bar Owner Payment Report</a></li>
					</ul>
					</div>
				</li>	
				
				<!-- <li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='transaction')?'active':''; ?>">
					<a href="<?php echo site_url('transaction/list_transaction') ?>" <?php echo (isset($uri[1]) && $uri[1]=='transaction')?'class="active"':''; ?>>
						<i class="halflings-icon th-list white"></i>
						<span class="title">Product Order Payment report</span>
					</a>
				</li>
				
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='payment_record')?'active':''; ?>">
					<a href="<?php echo site_url('payment_record/list_payment_record') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_payment_fail_record')?'class="active"':''; ?>>
						<i class="halflings-icon th-list white"></i>
						<span class="title">Bar Owner Payment Report</span>
					</a>
				</li> -->
				
				
				
				<!-- <li class="menu_tag <?php echo ($uri[1]=='suggest_advertise_list' || $uri[1]=='search_list_suggest_bar' || $uri[1]=='view_suggest_bar')?'active':''; ?>">
					<a href="<?php echo site_url('suggest_bar/list_suggest_bar') ?>" <?php echo (isset($uri[1]) && ($uri[1]=='list_suggest_bar' || $uri[1]=='view_suggest_bar' || $uri[1]=='search_list_suggest_bar'))?'class="active"':''; ?>>
						<i class="halflings-icon th-list white"></i>
						<span class="title"> Suggest Bars</span>
					</a>
				</li> -->
				
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='dictionary')?'active':''; ?>">
					<a href="<?php echo site_url('dictionary/list_dictionary') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_dictionary')?'class="active"':''; ?>>
						<i class="sidebar_icon dictionary_icon"></i>
						<span class="title">Dictionary</span>
					</a>
				</li>
				
						
				<li class="menu_tag <?php echo (isset($uri[0]) && ($uri[0]=='banner_pages' || $uri[0]=='edit_banner_pages' || $uri[0]=='add_banner_pages'))?'active':''; ?>">
					<a href="<?php echo site_url('banner_pages') ?>" <?php echo (isset($uri[1]) && ($uri[1]=='add_banner_pages' || $uri[0]=='edit_banner_pages' || $uri[0]=='add_banner_pages'))?'class="active"':''; ?>>
						<i class="sidebar_icon banner_icon"></i>
						<span class="title">Banner Pages</span>
					</a>
				</li>
				
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='divebar_findout')?'active':''; ?>">
					<a href="<?php echo site_url('divebar_findout/list_divebar_findout') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_divebar_findout')?'class="active"':''; ?>>
						<i class="sidebar_icon find_icon"></i>
						<span class="title">In a Dive Bar? Find Out</span>
					</a>
				</li>
				<!-- <li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='trivia')?'active':''; ?>">
					<a href="<?php echo site_url('trivia/list_trivia') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_trivia')?'class="active"':''; ?>>
						<i class="sidebar_icon dictionary_icon"></i>
						<span class="title">Trivia</span>
					</a>
				</li> -->
				<li class="menu_tag <?php echo (isset($uri[0]) &&  ($uri[1]=='list_trivia' || $uri[1]=='add_trivia' || $uri[1]=='edit_trivia' || $uri[1]=='trivia_banner'))?'active':''; ?>">
					<a href="javascript://">
						<i class="sidebar_icon find_icon"> </i> <span class="title"> Trivia </span>
					</a>
					<div style="display:<?php echo (isset($uri[0])  && ($uri[1]=='list_trivia' || $uri[1]=='add_trivia' || $uri[1]=='edit_trivia' || $uri[1]=='trivia_banner'))?'block':'none'; ?>;" class="in_div">
					<ul>
					<li><a href="<?php echo site_url('trivia/list_trivia') ?>" <?php echo (isset($uri[1]) && ($uri[1]=='list_trivia' || $uri[1]=='add_trivia' || $uri[1]=='edit_trivia' ||  $uri[1]=='search_list_trivia' ))?'class="active"':''; ?>>Lists Trivia</a></li>
					<li><a href="<?php echo site_url('trivia/trivia_banner') ?>" <?php echo (isset($uri[1])  && ($uri[1]=='trivia_banner'))?'class="active"':''; ?>>Trivia Banner</a></li>
					<!--<li><a href="<?php echo site_url('site_setting/yahoo_setting') ?>" <?php echo (isset($uri[1]) && $uri[1]=='yahoo_setting')?'class="active"':''; ?>>Yahoo Setting</a></li>-->
					</ul>
					</div>
				</li>	
				
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='report' && ($uri[1]=='list_bar_report' || $uri[1]=='search_list_bar_report'))?'active':''; ?>">
					<a href="<?php echo site_url('report/list_bar_report') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_bar_report')?'class="active"':''; ?>>
						<span class="badge badge-info"><?php echo get_unread_reportbar();?></span><i class="sidebar_icon reports_icon"></i>
						<span class="title">Reported Bars</span>
					</a>
				</li>
				
				<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='report' && ($uri[1]=='list_taxi_company_report' || $uri[1]=='search_list_taxi_company_report'|| $uri[1]=='view_taxi_company_report'))?'active':''; ?>">
					<a href="<?php echo site_url('report/list_taxi_company_report') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_taxi_report')?'class="active"':''; ?>>
						<span class="badge badge-info"><?php echo get_unread_reporttaxi();?></span><i class="sidebar_icon reports_icon"></i>
						<span class="title">Reported Taxi Company</span>
					</a>
				</li>
				<li class="menu_tag">
					<a href="<?php echo site_url('domain_bar/list_domain_bar'); ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_domain_bar')?'class="active"':''; ?>>
						<span class="badge badge-info"><?php echo get_unread_agreed();?></span><i class="sidebar_icon reports_icon"></i>
						<span class="title">Domain Managment Bars</span>
					</a>
				</li>
					<!-- <li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='color')?'active':''; ?>">
					<a href="<?php echo site_url('color/list_color') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_color')?'class="active"':''; ?>>
						<i class="halflings-icon th-list white"></i>
						<span class="title">Color</span>
					</a>
				</li> 
				
					<li class="menu_tag <?php echo (isset($uri[0]) && $uri[0]=='size')?'active':''; ?>">
					<a href="<?php echo site_url('size/list_size') ?>" <?php echo (isset($uri[1]) && $uri[1]=='list_size')?'class="active"':''; ?>>
						<i class="halflings-icon th-list white"></i>
						<span class="title">Size</span>
					</a>
				</li>  -->
				
				
				
			</ul>
		</div>
	<!-- Sidebar ends -->
		<div class="clear"></div>


	<script src="<?php echo base_url().getThemeName(); ?>/assets/scripts/app.js" type="text/javascript"></script>
	
	<script>
		jQuery(document).ready(function() {    
		  // App.init(); // initlayout and core plugins
		   jQuery('.page-sidebar').on('click', 'li > a', function (e) {
                if ($(this).next().hasClass('sub-menu') == false) {
                    if ($('.btn-navbar').hasClass('collapsed') == false) {
                        $('.btn-navbar').click();
                    }
                    return;
                }

                var parent = $(this).parent().parent();
                var the = $(this);

                parent.children('li.open').children('a').children('.arrow').removeClass('open');
                parent.children('li.open').children('.sub-menu').slideUp(200);
                parent.children('li.open').removeClass('open');

                var sub = jQuery(this).next();
                var slideOffeset = -200;
                var slideSpeed = 200;

                if (sub.is(":visible")) {
                    jQuery('.arrow', jQuery(this)).removeClass("open");
                    jQuery(this).parent().removeClass("open");
                    sub.slideUp(slideSpeed, function () {
                        if ($('body').hasClass('page-sidebar-fixed') == false && $('body').hasClass('page-sidebar-closed') == false) {
                            App.scrollTo(the, slideOffeset);
                        }                       
                      //  handleSidebarAndContentHeight();
                    });
                } else {
                    jQuery('.arrow', jQuery(this)).addClass("open");
                    jQuery(this).parent().addClass("open");
                    sub.slideDown(slideSpeed, function () {
                        if ($('body').hasClass('page-sidebar-fixed') == false && $('body').hasClass('page-sidebar-closed') == false) {
                            App.scrollTo(the, slideOffeset);
                        }
                      //  handleSidebarAndContentHeight();
                    });
                }

                e.preventDefault();
            });
		});
	</script>
