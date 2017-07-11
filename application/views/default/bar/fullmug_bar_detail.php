<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/pgwslideshow.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/css/pgwslideshow.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/css/pgwslideshow_light.css" /><style>
	.ps-current
	{
		max-height:470px !important;
	}
</style>
<?php
		          		if($bar_detail['bar_logo']!="" && file_exists(base_path().'upload/barlogo_thumb/'.@$bar_detail['bar_logo']))
					{?>
		            	<?php $img =  base_url().'/upload/barlogo_thumb/'.$bar_detail['bar_logo']; ?>
		            	<?php }  else { ?>
		            		<?php $img =  base_url().'upload/barlogo/no_image.png'; ?>
		            		<?php } ?>

<title>buy</title><input type="hidden" name="sess_id" id="sess_id" value="<?php echo check_user_authentication()==""? '0':'1';?>" />
<input type="hidden" name="beerval" id="beerval" value="0" />
<input type="hidden" name="cocktailval" id="cocktailval" value="0" />
<input type="hidden" name="liquorval" id="liquorval" value="0" />
<!-- ########################################################################################### -->
    <div class="wrapper row4">
   		<div class="container clearfix">
   			<div id="slider-fixed-banner" class="carousel slide1">
	        	<div class="carousel-inner">
		          	<div class="active item">
		          		<?php
		          		if($bar_detail['bar_banner']!="" && file_exists(base_path().'upload/banner_drag/'.@$bar_detail['bar_banner']))
					{?>
		            	<img src="<?php echo base_url()?>/upload/banner_drag/<?php echo $bar_detail['bar_banner']; ?>" alt="American Dive Bars"/>
		            	<?php }  else if($bar_detail['bar_banner']!="" && file_exists(base_path().'upload/banner_drag_without/'.@$bar_detail['bar_banner']))
					{?>
						<img src="<?php echo base_url()?>/upload/banner_without_drag/<?php echo $bar_detail['bar_banner']; ?>" alt="American Dive Bars"/>

		            		<?php } else {?>
		            		<img src="<?php echo base_url().'default'?>/images/smallbanner1.png" alt="American Dive Bars"/>
		            			<?php } ?>

		          	</div>

	            </div>
   	  		</div>
       </div>
   </div>
       <div class="wrapper row5">
     	<div class="container">
     		<div class="result_search">
     			<div class="pull-left">
                            <div class="result_search_text">
                                <?php echo "Welcome to " .$bar_detail['bar_title'];?>
                                <b style="padding-left:1em;"></b>
                                <!--<img src ="<?php //echo base_url().'default';?>/images/Team_icon_-_noun_project_20586.svg.png" style="width: 1.5%;height: 1.5%;padding:0px 0px 0px 0px">-->
                                <b style="color:black;font-weight: normal;font-size:18px;"><?php echo ($bar_detail['followers'] + count($bar_liker))." Followers";?></b>
                            </div>
	            </div>

     			<div class="newrightblock">
                	<!-- <a href="javascript://" class="review text-center full-icon marr_10">Like This Bar</a> -->
                	 <?php $cnt_like = like_checker_bar($bar_detail['bar_id'],$this->session->userdata('user_id'));

								if($cnt_like==2 && get_authenticateUserID()!=''){
								?>
								<a id="total-like" href="javascript:void(0);" name="2" class="review text-center full-icon marr_10">Like This Bar</i></a>
								<?php
											} elseif(get_authenticateUserID()!='') {?>
											<a id="total-like" href="javascript:void(0);" name="<?php if($cnt_like==1){ echo $cnt_like=0;} else{ echo $cnt_like=1; } ?>" class="review text-center full-icon marr_10">
											<?php if($cnt_like==1){ echo 'Like This Bar'; } else{ echo 'Already Liked'; } ?></i></a>
											<?php } else { ?>
											<a id="total-like" href="javascript:void(0);" name="1" class="review text-center full-icon marr_10">
											Like This Bar</a>
								<?php  } ?>

     				<div class="result_search_text full-icon marr_10">Full Mug Bar</div>
     				<div class="full-icon"><i class="strip fullmug"></i></div>
     				<div class="clearfix"></div>
	             </div>
	             <div class="clearfix"></div>
     		</div>
     		<div class="br_bott_yellow">
     			<div>
     			<div class="bar_details lol1">
     				<div class="media">
     					<div class="pull-left left-img">
						    <a class="widheig120 mar_bot10" href="#">
						      	<?php
		          		if($bar_detail['bar_logo']!="" && file_exists(base_path().'upload/barlogo_thumb/'.@$bar_detail['bar_logo']))
					{?>
		            	<img src="<?php echo base_url()?>/upload/barlogo_thumb/<?php echo $bar_detail['bar_logo']; ?>" alt="American Dive Bars"/>
		            	<?php }  else { ?>
		            			<img style="width: 120px; height: 120px;" src="<?php echo base_url()?>/upload/barlogo/no_image.png" alt="American Dive Bars"/>
		            		<?php } ?>
						    </a><div class="clearfix"></div>
						   <?php
						    		 if($this->session->userdata('user_type')!='bar_owner')
		{
						    		 $cnt_fav = fav_checker_bar($bar_detail['bar_id'],$this->session->userdata('user_id'));


											if($cnt_fav==2 && get_authenticateUserID()!=''){
											?>
											<a id="total-fav" href="javascript:void(0);" name="2" class="btn btn-lg btn-primary full-btn mart10">Add to My List</a>
											<?php
											} elseif(get_authenticateUserID()!=''){?>

											<a id="total-fav" href="javascript:void(0);" name="<?php if($cnt_fav==1){ echo $cnt_fav=0;} else{ echo $cnt_fav=1; } ?>" class="btn btn-lg btn-primary full-btn mart10">
											 <?php if($cnt_fav==1){ echo 'Add to My List'; } else{ echo 'Remove Favorite'; } ?></a>
											<?php } else { ?>
												<a id="total-fav" class="btn btn-lg btn-primary full-btn mart10" href="javascript:void(0);" name="1" >Add to My List</a>
											<?php } }?>

								 <div>
								 	<div class="clearfix"></div>
						         	<div class="website-rating rating-new mart10">
						         		<?php echo getReviewRating($bar_id);?>
						         		<div class="mart10"><a  class="btn btn-lg btn-primary full-btn mart10" onclick="show_popup();">Write a Review</a></div>
						         		<div class="clearfix"></div>
						         	</div>
						         	<div class="clearfix"></div>
						         	<!-- <div>
						         		<ul class="social_icon">
							         		<?php if($bar_detail['facebook_link']!='' && $bar_detail['facebook_link']!='0'){?>
							    		 		<li><a href="<?php echo $bar_detail['facebook_link']; ?>" target="_blank" ><img src="<?php echo base_url().'default'?>/images/result_fb.png" /></a></li>
							    		 	<?php } ?>
							    		 	<?php if($bar_detail['twitter_link']!='' && $bar_detail['twitter_link']!='0'){?>
							    		 		<li><a target="_blank" href="<?php echo $bar_detail['twitter_link']; ?>" ><img src="<?php echo base_url().'default'?>/images/result_twitt.png" /></a></li>
							    		 	<?php } ?>
							    		 	<?php if($bar_detail['linkedin_link']!='' && $bar_detail['linkedin_link']!='0'){?>
							    		 		<li><a target="_blank" href="<?php echo $bar_detail['linkedin_link']; ?>"><img src="<?php echo base_url().'default'?>/images/result_linkln.png" /></a></li>
							    		 	<?php } ?>
							    		 	<?php if($bar_detail['google_plus_link']!='' && $bar_detail['google_plus_link']!='0'){?>
							    		 		<li><a target="_blank" href="<?php echo $bar_detail['google_plus_link']; ?>" "><img src="<?php echo base_url().'default'?>/images/result_google.png" /></a></li>
							    		 	<?php } ?>
							    		 	<?php if($bar_detail['pinterest_link']!='' && $bar_detail['pinterest_link']!='0'){?>
							    		 		<li><a target="_blank" href="<?php echo $bar_detail['pinterest_link']; ?>"><img src="<?php echo base_url().'default'?>/images/result_p.png" /></a></li>
							    		 	<?php } ?>
							    		 	<?php if($bar_detail['dribble_link']!='' && $bar_detail['dribble_link']!='0'){?>
							    		 		<li><a target="_blank" href="<?php echo $bar_detail['dribble_link']; ?>"><img src="<?php echo base_url().'default'?>/images/result_circle.png" /></a></li>
							    		 	<?php } ?>
		    		 					</ul>
		    		 				</div> -->
		    		 				<div class="clearfix"></div>
						         </div>
							</div>

						    <div class="media-body favourite-box">
						       <div class="barnew-title"><h4 class="media-heading"><a href="" class="bar_title"><i class="strip fullmug"></i> <?php echo ucwords(@$bar_detail['bar_title']); ?></a></h4></div>
                                                        <div class="taxi-right">
<!--                                                            <ul class="social_icon">
                                                                <?php
                                                                if($bar_detail['facebook_link']!='' && $bar_detail['facebook_link']!='0'){?>
                                                                        <li><a href="<?php echo $bar_detail['facebook_link']; ?>" target="_blank" ><img src="<?php echo base_url().'default'?>/images/result_fb.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_fb-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_fb.png'" /></a></li>
                                                                <?php } ?>
                                                                <?php if($bar_detail['twitter_link']!='' && $bar_detail['twitter_link']!='0'){?>
                                                                        <li><a target="_blank" href="<?php echo $bar_detail['twitter_link']; ?>" ><img src="<?php echo base_url().'default'?>/images/result_twitt.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_twitt-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_twitt.png'" /></a></li>
                                                                <?php } ?>
                                                                <?php if($bar_detail['linkedin_link']!='' && $bar_detail['linkedin_link']!='0'){?>
                                                                        <li><a target="_blank" href="<?php echo $bar_detail['linkedin_link']; ?>"><img src="<?php echo base_url().'default'?>/images/result_linkln.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_linkln-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_linkln.png'" /></a></li>
                                                                <?php } ?>
                                                                <?php if($bar_detail['google_plus_link']!='' && $bar_detail['google_plus_link']!='0'){?>
                                                                        <li><a target="_blank" href="<?php echo $bar_detail['google_plus_link']; ?>" "><img src="<?php echo base_url().'default'?>/images/result_google.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_google-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_google.png'" /></a></li>
                                                                <?php } ?>
                                                                <?php if($bar_detail['pinterest_link']!='' && $bar_detail['pinterest_link']!='0'){?>
                                                                        <li><a target="_blank" href="<?php echo $bar_detail['pinterest_link']; ?>"><img src="<?php echo base_url().'default'?>/images/result_p.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_p-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_p.png'" /></a></li>
                                                                <?php } ?>
                                                                <?php if($bar_detail['dribble_link']!='' && $bar_detail['dribble_link']!='0'){?>
                                                                        <li><a target="_blank" href="<?php echo $bar_detail['dribble_link']; ?>"><img src="<?php echo base_url().'default'?>/images/result_circle_white.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_circle-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_circle.png'" /></a></li>
                                                                <?php } ?>
                                                                <?php if($bar_detail['instagram_link']!='' && $bar_detail['instagram_link']!='0'){?>
                                                                        <li><a target="_blank" href="<?php echo $bar_detail['instagram_link']; ?>"><img src="<?php echo base_url().'default'?>/images/instagram2.png" onmouseover="this.src='<?php echo base_url();?>default/images/instagram2_hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/instagram2.png'" /></a></li>
                                                                <?php } ?>
                                                                <div class="clearfix"></div>
                                                            </ul>-->
                                                        </div>
						       		<div class="clearfix"></div>

						       <!-- <div class="rating_box"><a href="#"><img src="images/rating.png"/></a></div> -->
						       <!-- <div class="rating_box">
						       	<?php
//						    		 if($this->session->userdata('user_type')!='bar_owner')
//									{
//						    		 $cnt_fav = fav_checker_bar($bar_detail['bar_id'],$this->session->userdata('user_id'));
//
//
//											if($cnt_fav==2 && get_authenticateUserID()!=''){
											?>
											<a id="total-fav" href="javascript:void(0);" name="2" class="favourite_text"><i class="glyphicon glyphicon-heart"></i> Add To My Favorites</a>
											<a id="total-like" href="javascript:void(0);" name="2" class="btn btn-lg btn-primary">Like</i></a>
											<?php
//											} elseif(get_authenticateUserID()!=''){?>

											<a id="total-fav" href="javascript:void(0);" name="<?php // if($cnt_fav==1){ echo $cnt_fav=0;} else{ echo $cnt_fav=1; } ?>" class="favourite_text <?php // if($cnt_fav==1){ echo ''; } else{ echo 'active'; } ?>">
											<i class="glyphicon glyphicon-heart"></i> <?php // if($cnt_fav==1){ echo 'Add To My Favorites'; } else{ echo 'Remove From My Favorites'; } ?></a>
											<?php // } else { ?>
												<a id="total-fav" class="favourite_text" href="javascript:void(0);" name="1" ><i class="glyphicon glyphicon-heart"></i> Add To My Favorites</a>
											<?php // } }?>
						       	</div> -->
						       <div class="clearfix"></div>

						        <div class="mart10 min-height125">
						        	<?php // if($bar_detail['bar_category']){?>
<!--						        	<div class="socialicon-right">


                                         <h4 class="bar_add mar_bot10">Bar Type :</h4>-->


                                         	<?php
//
//
//													 $getin1 = explode(',',strip_tags($bar_detail['bar_category']));
//
//													$getin = array_slice($getin1, 0, 3);
//													$getin12 = array_slice($getin1, 3);
//					     							  foreach($getin as $r)
//													  {
//													  	  echo '<p>'.'&#149; '.getCatname($r).'</p>';
//													} ?>



<!--                                         <div class="clear"></div>
                                    <a  href="#opencategory" data-toggle='modal' class="mar_top5 pull-right">View All </a>-->

                                        <!--</div>-->
                                       <?php // } ?>

						        	<div class="bar_add" style="margin-bottom: 5px">
						        		<i class="strip address"></i>
						        		<div class="address-strip">
						        			<a href="javascript://" onclick="loadMap()"><?php echo @$bar_detail['address']."<br>";?>

						        			<?php echo  @$bar_detail['city'].", ".@$bar_detail['state']." ".@$bar_detail['zipcode'];?></a>
						        		</div>
						        	</div>
						        	<p class="bar_add">
						        		<?php if($bar_detail['website']!='' && $bar_detail['website']!='0'){?>
						        		<i class="strip url"></i><a onclick="window.open('<?php echo @$bar_detail['website'];?>', '_blank', 'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0');" href="javascript:void(0);"><?php echo @$bar_detail['website'];?></a>

                                                                        <?php }?>
                                                                </p>


						        		<!-- <a  href="<?php // echo @$bar_detail['website'];?>" class="bar_title">  <?php // echo @$bar_detail['website'];?></a></p> -->
						        	<!-- <p class="bar_add"><?php // echo @$bar_detail['address'].", ".@$bar_detail['city'].", ".@$bar_detail['zipcode'].", ".@$bar_detail['state'];?></p> -->
						        	<div>
						        		<div class="bar_phone pull-left reult_sub_title min-height25" style="width: 60%;"><?php echo $bar_detail['phone']!='' ? '<i class="strip smallphone"></i>'.$bar_detail['phone']:'' ;?></div>

		    		 					<div class="clearfix"></div>
						        	</div>
                                                                <div style="margin-top:5px; margin-left: 5px;">
                                                                    <ul class="social_icon">
                                                                        <?php
                                                                        if($bar_detail['facebook_link']!='' && $bar_detail['facebook_link']!='0'){?>
                                                                                <li><a href="<?php echo $bar_detail['facebook_link']; ?>" target="_blank" ><img src="<?php echo base_url().'default'?>/images/result_fb.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_fb-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_fb.png'" /></a></li>
                                                                        <?php } ?>
                                                                        <?php if($bar_detail['twitter_link']!='' && $bar_detail['twitter_link']!='0'){?>
                                                                                <li><a target="_blank" href="<?php echo $bar_detail['twitter_link']; ?>" ><img src="<?php echo base_url().'default'?>/images/result_twitt.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_twitt-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_twitt.png'" /></a></li>
                                                                        <?php } ?>
                                                                        <?php if($bar_detail['linkedin_link']!='' && $bar_detail['linkedin_link']!='0'){?>
                                                                                <li><a target="_blank" href="<?php echo $bar_detail['linkedin_link']; ?>"><img src="<?php echo base_url().'default'?>/images/result_linkln.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_linkln-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_linkln.png'" /></a></li>
                                                                        <?php } ?>
                                                                        <?php if($bar_detail['google_plus_link']!='' && $bar_detail['google_plus_link']!='0'){?>
                                                                                <li><a target="_blank" href="<?php echo $bar_detail['google_plus_link']; ?>" "><img src="<?php echo base_url().'default'?>/images/result_google.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_google-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_google.png'" /></a></li>
                                                                        <?php } ?>
                                                                        <?php if($bar_detail['pinterest_link']!='' && $bar_detail['pinterest_link']!='0'){?>
                                                                                <li><a target="_blank" href="<?php echo $bar_detail['pinterest_link']; ?>"><img src="<?php echo base_url().'default'?>/images/result_p.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_p-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_p.png'" /></a></li>
                                                                        <?php } ?>
                                                                        <?php if($bar_detail['dribble_link']!='' && $bar_detail['dribble_link']!='0'){?>
                                                                                <li><a target="_blank" href="<?php echo $bar_detail['dribble_link']; ?>"><img src="<?php echo base_url().'default'?>/images/result_circle_white.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_circle-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_circle.png'" /></a></li>
                                                                        <?php } ?>
                                                                        <?php if($bar_detail['instagram_link']!='' && $bar_detail['instagram_link']!='0'){?>
                                                                                <li><a target="_blank" href="<?php echo $bar_detail['instagram_link']; ?>"><img src="<?php echo base_url().'default'?>/images/instagram2.png" onmouseover="this.src='<?php echo base_url();?>default/images/instagram2_hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/instagram2.png'" /></a></li>
                                                                        <?php } ?>
                                                                        <div class="clearfix"></div>
                                                                    </ul>
                                                                </div>
						         </div>

						       <div class="result_desc mar_top5 margin-left-5">

						       	  <?php if(strip_tags(strlen($bar_detail['bar_desc'])>350)){ echo substr(strip_tags($bar_detail['bar_desc']),0,350).'...<a class="morelink more pull-right" href="javascript://"><i class="strip arrow_down"></i>Show more</a>' ; } else { echo strip_tags($bar_detail['bar_desc']); } ?>
						       	   <!-- <?php
						       	   $text=str_ireplace('<p>','',strip_tags($bar_detail['bar_desc']));
									$text=str_ireplace('</p>','',$text);
								echo $text;

								if(strlen($text>400)){ echo "Dsad"; die; }?> -->
						       </div> <div class="clear"></div>
						    </div>
						    <div class="clearfix"></div>
				    	</div>
				    	<div class="clearfix"></div>
				    	<div class="mobile-rating">
				    		<div class="rating-new mart10">
						         		<?php echo getReviewRating($bar_id);?>
						         		<div class="mart10"><a  class="btn btn-lg btn-primary full-btn mart10" onclick="show_popup();">Write a Review</a></div>
						         		<div class="clearfix"></div>
						         	</div>
						     <div class="clearfix"></div>
				    	</div>

				    	<div>
                                            <div class="mar_top20 like-block wid50 mar_r15 text-right" style="width: 47%; height:250px">
				    		 	 <!-- <?php // $cnt_like = like_checker_bar($bar_detail['bar_id'],$this->session->userdata('user_id'));

//								if($cnt_like==2 && get_authenticateUserID()!=''){
								?>
								<a id="total-like" href="javascript:void(0);" name="2" class="btn btn-lg btn-primary full-btn pull-left">Like This Bar</i></a>
								<?php
//											} elseif(get_authenticateUserID()!='') {?>
											<a id="total-like" href="javascript:void(0);" name="<?php // if($cnt_like==1){ echo $cnt_like=0;} else{ echo $cnt_like=1; } ?>" class="btn btn-lg btn-primary full-btn pull-left">
											<?php // if($cnt_like==1){ echo 'Like This Bar'; } else{ echo 'Already Liked'; } ?></i></a>
											<?php // } else { ?>
											<a id="total-like" href="javascript:void(0);" name="1" class="btn btn-lg btn-primary full-btn pull-left">
											Like This Bar</a>
								<?php //  } ?>
		     					<div class="bar_add mar_bot10 pull-right">We Liked This Bar</div> -->
		     					<div class="clearfix"></div>
		     					<?php

                                		if($barhours){ ?>
                                <div class="text-left">
                                	<div class="bar_add mar_bot10">Hours We Are Open :</div>
                                	<ul class="new-hours">
                                		<?php

                                		if($barhours){
                                		$get =	array_slice($barhours, 0, 7);
     							  foreach($get as $r){ ?>
     							<li>
     								<div class="schedule-text"><?php echo $r->days;?></div>
     								<?php if($r->is_closed!='yes'){ ?>
     								<div class="schedule-text"><?php if($r->is_closed!='yes'){  print( date("g:i a", strtotime($r->start_from)) ); } else { echo "test"; }?></div>
     									<div class="schedule-text dash">-</div>
     								<div class="schedule-text"><?php if($r->is_closed!='yes'){ print( date("g:i a", strtotime($r->start_to)) ); } else { echo "Closed"; }?></div>
     								<?php } else {?>
     									<div class="schedule-text">Closed</div>
     							<?php } ?>
     								<div class="clearfix"></div>
     							</li>
     						<?php } } else { ?>
     							No bar open hours available.
     						<?php } ?>


                                    </ul>
                                </div>
                            <?php } ?>
			     				<div class="clearfix"></div>
			     				<?php
									if($barhours){ ?>
			     				<!--<a  href="#openhour" data-toggle='modal' class="mar_top5">View All </a>-->
			     				<?php } ?>
		     				</div>
                                            <?php if($bar_detail['bar_category']){?>
                                                <div class="mar_top20 wid50 like-block" style="width:34%; height: 250px">
                                                    <h4 class="bar_add mar_bot10">Bar Type :</h4>
                                                        <?php
                                                        $getin1 = explode(',',strip_tags($bar_detail['bar_category']));
                                                        $getin = array_slice($getin1, 0, 5);
                                                        $getin12 = array_slice($getin1, 3);
                                                        foreach($getin as $r)
                                                        {
                                                            echo '<p>'.'&#149; '.getCatname($r).'</p>';
                                                        } ?>
                                                    <div class="clear"></div>
                                                    <a  href="#opencategory" data-toggle='modal' class="mar_top5 pull-right">View All </a>
                                                </div>
                                            <?php } ?>
		     					<?php if($bar_detail['cash_p']==1 || $bar_detail['visa_p']==1 || $bar_detail['bitcoin_p']==1 ||
								         $bar_detail['master_p']==1 || $bar_detail['paypal_p']==1 || $bar_detail['apple_p']==1 ||
										 $bar_detail['american_p']==1){ ?>
                                            <div class="mar_top20 wid50 like-block pull-right" style="width: 15%; text-align: center; height: 250px;">
		     					<!--<div class="bar_add mar_bot10">Payment Type Accepted :</div>-->
		     					<ul class="cashicon-list">
		     						<?php if($bar_detail['cash_p']==1){?>
		     						<li><i class="strip cash"></i></li>
                                                                        <?php } ?>
                                                                <?php if($bar_detail['visa_p']==1){?>
		     						<li><i class="strip visa"></i></li>
		     							<?php } ?>
		     						<?php if($bar_detail['master_p']==1){?>
		     						<li><i class="strip master-card"></i></li>
		     							<?php } ?>
		     						<?php if($bar_detail['american_p']==1){?>
		     						<li><i class="strip american-express"></i></li>
		     							<?php } ?>
		     						<?php if($bar_detail['paypal_p']==1){?>
		     						<li><i class="strip payapl"></i></li>
		     							<?php } ?>
		     						<?php if($bar_detail['bitcoin_p']==1){?>
		     						<li><i class="strip bit-coin"></i></li>
		     							<?php } ?>
		     						<?php if($bar_detail['apple_p']==1){?>
		     						<li><i class="strip apple-pay"></i></li>
                                                                        <?php } ?>
		     					</ul>

	     				  </div>
	     				  	<?php } ?>
				    	</div>
     			</div>
     			<div class="modal fade login_pop2" id="openhour" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
						<div class="padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Hours We Are Open :</div>
     				</div>
     				<div class="pad20">
     					<ul class="happy-list">
     					<?php

                                		if($barhours){
     							  foreach($barhours as $r){ ?>
     							<li>
     								<p class="happy-title"><?php echo $r->days;?></p>
     								<?php if($r->is_closed!='yes'){ ?>
     								<p class="happy-text"><?php if($r->is_closed!='yes'){  print( date("g:i a", strtotime($r->start_from)) ); } else { echo "Closed"; }?>
     									-
     								<?php if($r->is_closed!='yes'){ print( date("g:i a", strtotime($r->start_to)) ); } else { echo "Closed"; }?></p>
     								<?php } else {?>
     									-
     									<p class="happy-text">Closed.</p>
     							<?php } ?>
     								<div class="clearfix"></div>
     							</li>
     						<?php } } else { ?>
     							No bar open hours available.
     						<?php } ?>

                        </ul>


     				</div>
     			</div>
     		</div>
     	</div>
     </div>
     			</div>

     			<div class="modal fade login_pop2" id="hourmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
                            <div class="padtb10">
                                <div class="container">
                                        <div class="result_box clearfix mar_top30bot20">
                                                <div class="login_block br_green_yellow">
                                                        <div class="result_search">
                                                                 <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                                <i class="strip login_icon"></i><div class="result_search_text">Happy Hours & Specials</div>
                                                        </div>
                                                        <div class="pad20">
                                                                <ul class="happy-list">
                                                                <div id="displayhours"></div>
                                                                </li>
                                                                </ul>


                                                        </div>
                                                </div>
                                        </div>
                                </div>
                            </div>
     			</div>
                            
                        <div class="modal fade login_pop2" id="hhmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
                            <div class="padtb10">
                                <div class="container">
                                        <div class="result_box clearfix mar_top30bot20">
                                                <div class="login_block br_green_yellow">
                                                        <div class="result_search">
                                                                 <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                                <i class="strip login_icon"></i><div class="result_search_text">New Happy Hours & Specials</div>
                                                        </div>
                                                        <div class="pad20">
                                                                <ul class="happy-list">
                                                                <div id="displayhappyhours"></div>
                                                                </li>
                                                                </ul>


                                                        </div>
                                                </div>
                                        </div>
                                </div>
                            </div>
     			</div>
                            
                            
     			<div class="right_gallery_block newadded">
				<div>
                                    <!--<a title="OLD Happy Hours & Specials" href="#hourmodal" onclick="callhour()" data-toggle='modal'  class="btn-lg btn-primary pull-left" style="margin-right:5px; margin-bottom: 10px"><i class="glyphicon glyphicon-glass"></i></a>-->
                                    <a title="Happy Hours & Specials" href="#hhmodal" onclick="callhhour()" data-toggle='modal'  class="btn-lg btn-primary pull-left" style="margin-right:5px; margin-bottom: 10px"><i class="glyphicon glyphicon-glass"></i></a>
                                    <a title="Get Directions" href="javascript://" class="btn-lg btn-primary text-center mar_top5 pull-left" onclick="loadMap()" style="margin-right:5px;"><i class="glyphicon glyphicon-map-marker"></i></a>
                                        <?php if($bar_gallery){ ?>
					   <div class="pull-left view-gallery">
						  <a title="View More Galleries" href="javascript://"  onclick="see_gal();" class="btn btn-lg btn-primary btn-block" style="margin-right:5px;"><i class="glyphicon glyphicon-picture"></i></a>
						  <!-- <div class="pull-left"><button class="btn btn-lg btn-primary btn-block " type="submit"><span class="glyphicon glyphicon-search"></span></button></div> -->
					   </div>
				   <?php } ?>
     				<!--<a href="javascript://" class="btn-lg btn-primary text-center mar_top5" onclick="loadTaxi()">Call a Taxi</a>-->
		    		<!-- <a href="javascript://" class="btn-lg btn-primary text-center mar_top5 marl_10" onclick="loadTaxi()">Yelp Reviews</a> -->
					<ul class="social_icon pull-right">
						<li>Share : </li>
						<li><a href="javascript://" onclick="fbShare()" ><img src="<?php echo base_url().'default'?>/images/result_fb.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_fb-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_fb.png'" /></a></li>
						<li><a onclick="twShare()" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_twitt.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_twitt-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_twitt.png'" /></a></li>
						<li><a onclick="gPlusShare1('<?php echo site_url().'bar/details/'.$bar_detail['bar_id']; ?>','<?php echo $bar_detail['bar_title']; ?>')" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_google.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_google-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_google.png'" /></a></li>
						<li><a  href="javascript://" onclick="piShare()"><img src="<?php echo base_url().'default'?>/images/result_p.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_p-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_p.png'" /></a></li>

						<div class="clearfix"></div>
					</ul>
				</div>
                            <div class="text-center mar_top15" id="gallerywrapper" style="margin-top:30px;">

	     				 <?php if($bar_gallery){ ?><ul class="bxslider">

     					  	   <?php   foreach($bar_gallery as $rows){
     					  	    	?>
									  <li class="br_green_yellow">
									  	<span class="image_title"><?php echo ucfirst($rows->title); ?></span>
									  	<img class=" gallery_img" src="<?php echo base_url().'upload/bar_gallery_thumb_big/'.$rows->bar_image_name;?>" /></li>
								<?php } }?>
									</ul>


									 <?php if($bar_gallery){ ?>
									 	<ul id="bx-pager" class="bxslider1">
     					  	    <?php $i=0; foreach($bar_gallery as $rows){
     					  	    	?>
									  <li class=""><a data-slide-index="<?php echo $i;?>" href=""><img class="thumb_img" src="<?php echo base_url().'upload/bar_gallery_thumb/'.$rows->bar_image_name;?>" /></a></li>
									<?php $i++; } ?>  </ul> <?php } else {?>

										<div class="gallery-default ">
     					No Gallery Available
     				</div>
     				<?php } ?>

     				</div>
     				<div class="margin-top-80">
     				 <?php if($bar_gallery){ ?>
     					<!-- <div class="pull-left view-gallery">
						   <a href="javascript://"  onclick="see_gal();" class="btn btn-lg btn-primary btn-block"><i class="glyphicon glyphicon-picture"></i></a> -->
						   <!-- <div class="pull-left"><button class="btn btn-lg btn-primary btn-block " type="submit"><span class="glyphicon glyphicon-search"></span></button></div> -->
						<!-- </div> -->
					<?php } ?>
<!--     					<ul class="social_icon pull-right">
     						<li>Share : </li>
						    <li><a href="javascript://" onclick="fbShare()" ><img src="<?php echo base_url().'default'?>/images/result_fb.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_fb-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_fb.png'" /></a></li>
						    <li><a onclick="twShare()" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_twitt.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_twitt-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_twitt.png'" /></a></li>
						    <li><a onclick="gPlusShare1('<?php echo site_url().'bar/details/'.$bar_detail['bar_id']; ?>','<?php echo $bar_detail['bar_title']; ?>')" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_google.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_google-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_google.png'" /></a></li>
						    <li><a  href="javascript://" onclick="piShare()"><img src="<?php echo base_url().'default'?>/images/result_p.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_p-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_p.png'" /></a></li>

						    <div class="clearfix"></div>
		    		 	</ul><div class="clear"></div>-->
     				</div>

     			</div>

     			<div class="clearfix"></div>

     			<div id="see_gal" style="display: none;" class="padtb10 pad_lr10 mug-gallery mar_top20">
     				<div class="result_search">
		     			<div class="result_search_text"><?php echo $bar_detail['bar_title']; ?> Bar Gallery <a onclick="hide_gal()" class="white pull-right review" href="javascript://">Close</a></div>
		             	<div class="clearfix"></div>
     				</div>
     				<div class="mar_top20">
     					<ul class="event-listing">
     					<?php if($bar_gallery_all){
     						foreach($bar_gallery_all as $bg){

     					?>
     						<a href="javascript://" onclick="opengallery('<?php echo $bg->bar_gallery_id; ?>')" ><li>
     							<div class="event-img">
     									<img class=" img-responsive" src="<?php echo base_url().'upload/bar_gallery_thumb_big/'.$bg->bar_image_name;?>" />
     							</div>
     							<div class="event-detail">
     								<h1 class="event-title"><?php echo ucwords($bg->title); ?></h1>
     							</div>
     						</li></a>
     						<?php } } ?>

     						<div class="clearfix"></div>
     					</ul>
     				  </div>
     				</div>




     		</div>

     		<div class="fullmug_block mart10">
     			<div class="col-md-3 padb20">
     				<div class="bar_bg">
     					<h1 class="box_title">Bar Events</h1>
     					<ul class="bottom_box">
     					<?php if($bar_event){
     						  foreach($bar_event as $row){

     						  	$getimage = geteventimagethumb($row->event_id);?>
	         			<li>
	         				<div class="media">
	         				<a class="pull-left widheig70" href="<?php echo site_url('event/detail/'.base64_encode($row->event_id));?>">
						        <!-- <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCI+PHJlY3Qgd2lkdGg9IjY0IiBoZWlnaHQ9IjY0IiBmaWxsPSIjZWVlIj48L3JlY3Q+PHRleHQgdGV4dC1hbmNob3I9Im1pZGRsZSIgeD0iMzIiIHk9IjMyIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjEycHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+NjR4NjQ8L3RleHQ+PC9zdmc+" style="width: 64px; height: 64px;"> -->
						      <img src="<?php echo $getimage; ?>" class="img-responsive" />
						      </a>
						     <div class="media-body">
	         				<div class="fourm_label"><a href="<?php echo site_url().'event/detail/'.base64_encode($row->event_id);?>" class="newsyellow"><?php if(strlen($row->event_title)>20){ echo substr($row->event_title,0,20).".."; } else { echo $row->event_title; }  ?></a></div>
	         				<div class="result_desc"><?php if(strlen($row->event_desc)>50){ echo substr($row->event_desc,0,50).".."; } else { echo $row->event_desc; }  ?></div>

	         				</div>
	         				</div>
	         			</li>
	         			<hr>
	         			<?php } if(count($bar_event)>4){?>
	         			<li>
	         				<a href="<?php echo site_url().'event/lists/'.$bar_detail['bar_slug'];?>" class="pull-right more">View More</a>
	         			</li>
	         			<?php } } else { ?>
	         				<li class='mart10'>No Record Founds.</li>
	         			<?php } ?>
	         		<div class="clear"></div></ul><div class="clear"></div>
     				</div>
     			</div>

     			<div class="col-md-3 padb20">
     				<div class="bar_bg">
     					<h1 class="box_title">Beers Served at Bar</h1>
     					<ul class="bottom_box" id="infinite-list">

	         		<div class="clear"></div></ul><div class="clear"></div>
     				</div>
     			</div>
     		<?php // if($bar_detail['serve_as']=='cocktail'){?>
     			<div class="col-md-3 padb20">
     				<div class="bar_bg">
     					<h1 class="box_title">Cocktails Served at Bar</h1>
     					<ul class="bottom_box" id="infinite-list-cocktail">

	         		<div class="clear"></div></ul><div class="clear"></div>
     				</div>
     			</div>
     		<?php // } ?>

     		<?php // if($bar_detail['serve_as']=='liquor'){?>
     			<div class="col-md-3 padb20">
     				<div class="bar_bg">
     					<h1 class="box_title">Liquors Served at Bar</h1>
     					<ul class="bottom_box" id="infinite-list-liquor">

	         		<div class="clear"></div></ul><divbeer_state class="clear"></div>
     				</div>
     			</div>
     		<?php // } ?>
     			<div class="clearfix"></div>
     		</div>
     		<div>
     			<div class="review_mainblock marr4 padt10 new_review">
     				<h1 class="productbar_title">
     					<div class="pull-left mar_top5">How To Find Us</div>
     					<a href="javascript://" class="white pull-right review" onclick="loadMap()">Get Directions</a>
     					<div class="clearfix"></div>
     				</h1>

		     			<div class="br_map mar_top20">
		     				<!-- <img src="<?php echo base_url().'default'?>/images/map.png" class="map_img"/> -->
		     				<div class="portlet-body">
								<div id="gmap_marker" class="map_img"></div>
							</div>
		     			</div>
     			</div>
     			<div class="review_mainblock">

     				<h1 class="productbar_title" style="margin-top: 10px;"><div>Take a Look Inside</div>
     				</h1>
     				<div class="mar_top20 pos_rel">
     					<?php
            //print_r($site_setting);
            if($bar_detail['bar_video_link']!=''){
            $url	=	$bar_detail['bar_video_link'];
				if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',$url,$matches)) {
					//echo $url;
				      //preg_match('/[\\?\\&]v=([^\\?\\&]+)/',$url,$matches);
				      //preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',$url,$matches);
							if(isset($matches[1])){
							$id = $matches[1];
								echo '<iframe class="gallery_img" style="height:357px;"  src="//www.youtube.com/embed/'.$id.'?rel=0" frameborder="0" allowfullscreen></iframe>';
							}else{
								echo $url;
							}
				    } elseif (strpos($url, 'vimeo') > 0) {
				    	preg_match('~^http://(?:www\.)?vimeo\.com/(?:clip:)?(\d+)~',$url,$matches);
				//	$parsed = parse_url($url);
					//print_r($parsed);
				       if(isset($matches[1])){
							$id = $matches[1];
							echo '<iframe style="height:357px;" src="//player.vimeo.com/video/'.$id.'" class="gallery_img" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> ';

							}else{
								$a=json_decode(file_get_contents('http://vimeo.com/api/oembed.json?url='.$url));

								if(isset($a->video_id) && $a->video_id!=''){
								$id=$a->video_id;
									echo '<iframe style="height:357px;" src="//player.vimeo.com/video/'.$id.'" class="gallery_img" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> ';
								}
							}
				    }
				    }
else {
            ?>
            <div class="gallery-default mar_top20">
     					No Video Available
     				</div>
     				<?php } ?>
	     			</div>






     			</div>
     			<div class="clearfix"></div>
     		</div>
     		<div class="padt10">
     			<div class="review_mainblock marr4 padt10">
     				<h1 class="productbar_title"><div>Send a Bar a Real Post Card</div>
     				</h1>
     			<div id="crd_not_send">
     				<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
     			<?php if($get_post_card == 0){?>
					<form name="add_post" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('bar/post_card_send/'.base64_encode($bar_id))?>">
     					<div class="pull-left marr_10">
     						<div class="checkbox">
	     						 <label>
	          							<input type="radio" name="sel_title" onclick="gettitle(this.value)" value="Your Bar is Awesome" checked> Your Bar is Awesome !
	        					</label>
        					</div>
     					</div>
     					<div class="pull-left">
     						<div class="checkbox">
	     						 <label>
	          							<input type="radio" name="sel_title" onclick="gettitle(this.value)" value="Your Bar Needs Work"> Your Bar Needs Work!
	        					</label>
        					</div>
     					</div>
     					<div class="clearfix"></div>

     					<textarea name="desc_post_card"  onKeyDown="limitText(event,this.form.desc_post_card,this.form.countdown,700 );"
onKeyUp="limitText(event,this.form.desc_post_card,this.form.countdown,700 );" id="desc_post_card" class="form-control form-pad mart10" rows="3" placeholder="Write Here"></textarea>


     					<!-- <div class="padtb10 pull-right">
							<font size="1">(Maximum characters: 700)<br>
							You have <input readonly type="text" style="background-color:transparent; border: 0; font-weight: bold;" name="countdown" id="countdown" size="3" value="700">Characters left.</font>
							Lines used: <span id="linesUsed">0</span>
     					</div> -->
     					<div class="clearfix"></div>
     					<div class="post_card_block mar_top15">
	     					<div class="post_left br_r">
	     						<h1 class="post_label ">Dear Bar Owner,</h1>
	     						<div class="result_desc padb10" >I recently Visited your Bar And I have Concluded: <div id="paste_cont" class="sp_tag"></div>  </div>

	     						<div class="">
	     						 <label id="title">
	                                    Your Bar is Awesome!
	        					</label><div class="clearfix"></div>
	        					<!-- <div class="mar_top20">
	        						<a href="#" class="btn btn-lg btn-primary">Upload Image</a>
	        					</div> -->



									<div class="browse1"  id="upload">
										<input type="file" name="file" id="file" class="browse" value="Upload Image">
									</div>
	        						<!--<a href="#" class="btn btn-lg btn-primary">Upload Image</a>-->
	        						<div class="stamp_image" id="preview" style="padding: 0;">
	     							<img id="previewimg" src="" height="50" width="40"/>
	     						</div>
	        					</div>


	     					</div>
	     					<div class="post_left">
	     						<img src="<?php echo base_url().getThemeName(); ?>/images/post.png" class="pull-left"/>

	     						<div class="stamp" >
	     							Place Stamp Here
	     						</div>
	     						<div class="clearfix"></div>
	     						<div class="post_add">
	     							<?php echo $bar_detail['bar_title'];?><div class="clearfix"></div>
	     							<?php echo $bar_detail['address']."<br/>".$bar_detail['city'].", ".$bar_detail['state']." ".$bar_detail['zipcode'];?>
	     						</div>

	     					</div>
	     					<div class="clearfix"></div>
	     				</div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 margin-top-10">
                                <img src="<?php echo base_url();?>captcha/captcha.php" id="captcha" class="img-responsive"/><br/>

                                <a href="javascript://" onclick="

                                document.getElementById('captcha').src='<?php echo base_url();?>captcha/captcha.php?'+Math.random();

                                document.getElementById('captcha-form');"

                                id="change-image" class="lable_title text-right">Not readable? Change text.</a>
                           </div>
                           <div class="col-md-6 col-sm-6" id="r_captcha">
                            	<input type="text" name="captcha" id="captcha-form" class="form-control" />
                                <div class="text-right">
                            		<input type="submit" name="send" id="send" onclick="checkauth()" value="Send a Post Card" class="btn btn-lg btn-primary" />
                        		</div>
                            </div>
                        </div>

	     				</form>
	     				<?php } else {?>
	     					<div  class="error mar_top20  center"> Hello user now you can send another post card after <?php echo 24-number_format($time,2);?> Hours .</div>
	     				<?php } ?>
	     				</div>
     				</div>


					<div class="modal fade login_pop2" id="mapmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
					     <?php //echo $this->load->view($theme.'/home/map');?>
					</div>


<div class="modal fade login_pop2" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	<div class="padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Write a Review</div>
     				</div>
     				<div class="pad20">
     						<div id="ajax_msg_error_reg"></div>
     						<div class="error1 hide1" id="cm-err-main" style="text-align: center;">&nbsp;</div>
     						<form name="frm_add_review" id="frm_add_review" method="post" class="form-horizontal" action="<?php echo site_url("bar/add_bar_comment"); ?>">
     						<div class="error1 hide1 center" id="cm-err-main">&nbsp;</div>
     							<input type="hidden" name="bar_id" id="bar_id" value="<?php echo $bar_id;?>" />
     						<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Review Title :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" maxlength="40" id="comment_title" name="comment_title" >
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>

	                       	<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Review Description :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		 <textarea name="comment" id="comment" class="form-control form-pad" ></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>

	                       	<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Rating :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		 <div id="star1" class="rating">&nbsp;<input type="hidden" name="rating" id="rating" value="" /></div>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>

	                       	 <div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10">
									<button class="btn btn-lg btn-primary" type="submit">Post</button>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	</form>
     				</div>
     			</div>
     		</div>
     	</div>
     </div>
</div>
 
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/css/google-places.css" />
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/google-places.js"></script>              
<!--<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>-->

     			<div class="review_mainblock padt10 new_review">
     				<h1 class="productbar_title">
     					<div class="pull-left mar_top5">Raves and Rants</div>
     					<div class="pull-right">
     						<a href="javascript://" onclick="show_popup()" class="review">Write a Review</a>
     					</div>
     					<div class="clearfix"></div>
     				</h1>
     				<input type="hidden" name="offset" id="offset" value="<?php echo ($offset!='')?$offset:0; ?>" />
					<input type="hidden" name="limit" id="limit" value="<?php echo ($limit>0)?$limit:5; ?>" />
	     			<div id="responsecomment">
	     			<ul class="review_block" >
                                    <br>
	     				<?php if($result){
	     					  foreach($result as $comment){?>
		     				<li>
		     					<div class="reult_sub_title"><a class="bar_title"><?php echo $comment->comment_title; ?></a></div>
		     					<div class="rating_box"><a class="bar_title"><?php echo getDuration($comment->date_added); ?></a></div>
		     					<div class="clearfix"></div>
		     					<p class="result_desc"><?php if(strlen($comment->comment)>150) { echo substr($comment->comment,0,150)."..."; } else { echo $comment->comment; }?></p>
		     					<div class="reult_sub_title"><p class="review_light pull-left"><?php echo $comment->first_name!='' || $comment->last_name!='' ? $comment->first_name." ".$comment->last_name:'AB';?></p></div>
		     					<div class="rating_box starrating<?php echo $comment->bar_rating; ?>"><a href="javascript"></a></div>
		     					<div class="clearfix"></div>
		     				</li>
	     				<?php } } else {?>
                                                <h4 style="margin-bottom: 3px">Reviews from Google</h4><hr style="border-color: grey;">
                                                <!--<div class="gallery-default reviewdefault mar_top20" style="font-size:12px; text-align: left; max-height: 574px; vertical-align: top;">--> 
                                                <div id="google-reviews" style="font-size:14px; text-align: left; max-height: 465px;overflow-y:scroll;padding: 3px; "><br><br></div>

     				<!--</div>-->
	     					<?php } ?>
	     			</ul>

	     			<div class="pagination">
	     				<?php echo $page_link;?>
     				</div>
     				<div class="clearfix"></div>

     			</div>
     		</div>
     		<div class="clearfix"></div>
     		</div>


            <div class="padtb10">
     			<div class="review_mainblock">
     					<h1 class="productbar_title"><div>Get in Touch!</div>
     				</h1>
	     				<form class="form-horizontal mar_top20" role="form" name="contact" id="contact" method="post" action="<?php echo site_url('bar/contact_bar_owner/'.base64_encode($bar_id))?>">
	     					<div class="error1 hide1 center" id="cm-err-main_contact">&nbsp;</div>
                   <div class="form-group">
                       <label for="inputEmail3" class="col-sm-3 control-label">Name :</label>
                       <div class="col-sm-8 input_box">
                           <input type="text" class="form-control form-pad" name="name" id="name" value="<?php echo @ucwords($user_detail->first_name." ".$user_detail->last_name); ?>" placeholder="Name">
                       </div>
                       <div class="clearfix"></div>
                   </div>
                   <?php //print_r($user_detail);?>
                   <div class="form-group">
                       <label for="inputEmail3" class="col-sm-3 control-label">Phone :</label>
                       <div class="col-sm-8 input_box">
                           <input type="text" class="form-control form-pad" id="phone" name="phone" value="<?php echo @$user_detail->mobile_no;?>" placeholder="Phone">
                       </div>
                       <div class="clearfix"></div>
                   </div>
                    <div class="form-group">
                       <label for="inputEmail3" class="col-sm-3 control-label">Email :</label>
                       <div class="col-sm-8 input_box">
                           <input type="text" class="form-control form-pad" name="email_new" value="<?php echo @$user_detail->email;?>" id="email_new" placeholder="Email">
                       </div>
                       <div class="clearfix"></div>
                   </div>
                   <div class="form-group">
                       <label for="inputEmail3" class="col-sm-3 control-label">What do you want? :</label>
                       <div class="col-sm-8 input_box">
                            <input type="text" class="form-control form-pad" id="inputEmail3" placeholder="State">
                           <textarea class="form-control form-pad" name="desc" id="desc"  placeholder="Insert comment here..." rows="5"></textarea>
                       </div>
                       <div class="clearfix"></div>
                   </div>

                   <div class="form-group" id="r_captcha">
                   	 <label for="inputEmail3" class="col-sm-3 control-label"></label>
 <div class="col-sm-8 input_box">
 									 <input type="text" placeholder="Captcha " name="captcha2" id="captcha-form1" class="form-control" />
									<img src="<?php echo base_url();?>captcha/captcha.php" id="captcha2" /><br/>

                                    <a href="javascript://" onclick="

                                    document.getElementById('captcha2').src='<?php echo base_url();?>captcha/captcha.php?'+Math.random();

                                    document.getElementById('captcha-form1');"

                                    id="change-image1" class="lable_title text-right">Not readable? Change text.</a>


</div>
								</div>
                   <div class="col-sm-8 pull-right mar_top20">
                   	    <input type="submit" name="sub" id="sub" value="Submit" class="btn btn-lg btn-primary pull-right marr_10" />
                  		<div class="clearfix"></div>
                  </div>
                  <div class="clearfix"></div>

              </form>
     			</div>
     			<div class="clearfix"></div>
     		</div>

   		</div>
   	</div>

<div class="modal fade login_pop2" id="opencategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
						<div class="padtb10">
     	<div class="container">
            <div class="result_box clearfix mar_top30bot20" style="margin-top: ">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Bar Type :</div>
     				</div>
     				<div class="pad20">
     					<ul class="happy-list">

     						<?php


													 $getin1 = explode(',',strip_tags($bar_detail['bar_category']));

					     							  foreach($getin1 as $r)
													  {
													  	  echo '<li><p style="color:#fff;">'.'&#149; '.getCatname($r).'</p></li>';
													} ?>


                        </ul>


     				</div>
     			</div>
     		</div>
     	</div>
     </div>
     			</div>
<div class="modal fade" id="myModalnew_ajax" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
<div class="modal fade" id="myModalnew_open" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Description</div>
     				</div>
     				<div class="pad20">
     						<label class="control-label" style="color: #fff;"><?php echo $bar_detail['bar_desc']; ?></label>
     				</div>
     			</div>
     		</div>
     	</div>
     </div>

</div>
<div class="modal fade" id="myModalnew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
	<div class="modal fade login_pop2" id="taximodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
					</div>
<style>
.morecontent span {
    display: none;
}
.morelink {
    display: block;
}
span.required {
    color: #B31010;
    vertical-align: -4px;
}
</style>
 <!--------------Scroll ------------------->
	<link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/css/prettify.css">
	<!--<script src="<?php // echo base_url().getThemeName(); ?>/js/jquery.slimscroll.js"></script>-->
	<script src="<?php echo base_url().getThemeName(); ?>/js/prettify.js"></script>
	<script type="text/javascript">
//		$(function(){
//		      $('#infinite-list').slimscroll({
//		        alwaysVisible: true,
//		        height: 410,
//		        color: '#f19d12',
//		        opacity: .8
//		      });
//
//		        $('#infinite-list-cocktail').slimscroll({
//		        alwaysVisible: true,
//		        height: 410,
//		        color: '#f19d12',
//		        opacity: .8
//		      });
//
//		      $('#infinite-list-liquor').slimscroll({
//		        alwaysVisible: true,
//		        height: 410,
//		        color: '#f19d12',
//		        opacity: .8
//		      });
//
//		  });
	</script>
	<!--------------End Scroll ------------------->

        <?php $theme_url = $urls= base_url().getThemeName();?>
<script>
	var base_url = '<?php echo site_url('bar/getmorebeer/?bar_id='.$bar_detail['bar_id']); ?>';
	var base_url_cocktail = '<?php echo site_url('bar/getmorecocktail/?bar_id='.$bar_detail['bar_id']); ?>';
	var base_url_liquor = '<?php echo site_url('bar/getmoreliquor/?bar_id='.$bar_detail['bar_id']); ?>';
</script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/rating.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/image_script.js"></script>
<script type="text/javascript" src="<?php echo $theme_url; ?>/js/jquery_form.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/js/rating.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/css/jquery.bxslider.css" />
 <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/infiniteScroll.js"></script>
 <script type="text/javascript">InfiniteList.loadData(0,100); InfiniteList.loadData_cocktail(0,100);InfiniteList.loadData_liquor(0,100);</script>








        <style>
	#gmap_marker {
    height: 370px;
    width: 100%;
}
 .gm-style-iw
 {
 	color:#000000;
 }
 #infinite-list {
    height: 410px;
    margin-left: auto;
    margin-right: auto;
    overflow-x: hidden;
    overflow-y: scroll;
}
#infinite-list-cocktail {
    height: 410px;
    margin-left: auto;
    margin-right: auto;
    overflow-x: hidden;
    overflow-y: scroll;
}
#infinite-list-liquor {
    height: 410px;
    margin-left: auto;
    margin-right: auto;
    overflow-x: hidden;
    overflow-y: scroll;
}
</style>


<!-- <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> -->
<script src="https://maps.googleapis.com/maps/api/js?&amp;libraries=places"></script>

<script>
$(window).load(function(){
//  $(".loading").fadeOut("slow");
//  $("#gallerywrapper").fadeIn(2000);
});
    
    $(document).ready(function () {
//        $("#gallerywrapper").hide();
	$('#total-like').click(function(){
		 <?php if($this->session->userdata('user_type')=='taxi_owner'){?>
  	    	  $.growlUI('<?php echo NO_RIGHT; ?>');
  	    	   $(".growlUI strong").empty();
  	    	  return false;
  	    <?php } ?>
		var flag = this.name;
		var bid = '<?php echo $bar_detail["bar_id"]; ?>';
		var uid = '<?php echo get_authenticateUserID(); ?>';

		if($('#sess_id').val()==0)
		{
			<?php $this->session->set_userdata("REDIRECT_PAGE","bar/details/".$bar_detail["bar_slug"]); ?>
			$('#loginmodal').modal('show');
			return false;
		}

		$.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>bar/bar_likes",         //the script to call to get data
        data: {bar_id: bid, user_id: uid, like_flag:flag},
	    dataType: '',                //data format
        success: function(data)          //on receive of reply
            {

			var main = data.split('*');
			   if(main[0]==1){
				   $('#total-like').attr('name','0');
				   $('#total-like').html('Already Liked');
				  // $('.likeduser').append(main[1]);
			   }
			   else{
				   $('#total-like').attr('name','1');
				   $('#total-like').html('Like This Bar');
				  // $('#'+main[1]).remove();
				}
		    }

        });
	});
});
</script>
<script>

	$(document).ready(function(e) {


    $('#total-fav').click(function(){


  	    <?php if($this->session->userdata('user_type')=='taxi_owner'){?>
  	    	  $.growlUI('<?php echo NO_RIGHT; ?>');
  	    	   $(".growlUI strong").empty();
  	    	  return false;
  	    <?php } ?>
		var flag = this.name;
		var bid = '<?php echo $bar_detail["bar_id"]; ?>';
		var uid = '<?php echo get_authenticateUserID(); ?>';

		// if(uid=="")
		// {
			// //window.location.href='<?php //echo site_url("beer/beer_likes/".$beer_detail["beer_id"]); ?>';
			// //return false;
		// }

	//	alert($('#sess_id').val())
		if($('#sess_id').val()==0)
		{
			<?php $this->session->set_userdata("REDIRECT_PAGE","bar/details/".$bar_detail["bar_slug"]); ?>
			$('#loginmodal').modal('show');
			return false;
		}

		$.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>bar/bar_fav",         //the script to call to get data
        data: {bar_id: bid, user_id: uid, fav_flag:flag},
	    dataType: '',                //data format
        success: function(data)          //on receive of reply
            {

			var main = data.split('*');
			   if(main[0]==1){
				  $('#total-fav').attr('name','0');
				   $('#total-fav').html('Remove Favorite');
				   $( "#total-fav" ).addClass( "active" );
			   }
			   else{
				  $('#total-fav').attr('name','1');
				   $('#total-fav').html('Add to My List');
				   $( "#total-fav" ).removeClass( "active" );
				}
		    }

        });
	});
	$('.bxslider').bxSlider({
		mode: 'horizontal',
		infiniteLoop:true,
                pagerCustom: '#bx-pager',
                controls:false,
                useCSS: false,
                preloadImages:'visible',
                speed: 1500,
                auto:true,
                captions: false,
	});
	$('.bxsliderp').bxSlider({
		// mode: 'horizontal',
		// infiniteLoop:true,
	   // pagerCustom: '#bx-pager',
	   // controls:false,
	   // useCSS: false,
	   // preloadImages:'all',
	   // speed: 1500,
	   // minSlides: 2,
	  	// maxSlides: 2,
	  	// slideWidth: 300,
	   // auto:false,.

	    minSlides: 2,
  maxSlides: 4,
  slideWidth: 300,
	});

	 $('.bxslider1').bxSlider({
	 	useCSS: false,
	 	infiniteLoop:false,
	 	mode: 'horizontal',
	 	preloadImages:'visible',
	 	controls:true,

		minSlides: 5,
	  	maxSlides: 5,
	  	slideWidth: 65,
	 	pager: false,
                captions:false,

});


 //$('#soom_0').elevateZoom({zoomType: "inner",cursor: "crosshair",easing : true,});


});
	$(document).ready(function() {
		$('.bxsaslider1').bxSlider({
	  pagerCustom: '#bx-pager'
	});
	$("#preview").hide();
    // Configure/customize these variables.
    var showChar = 300;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more";
    var lesstext = "Show less";

    $('.more').each(function() {
        var content = $(this).html();

        if(content.length > showChar) {

            var c = content.substr(0, showChar);
            var h = '';

             //alert(h);
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="javascript://" class="morelink more pull-right"><i class="strip arrow_down"></i>' + moretext + '</a></span>';

            $(this).html(html);
        }

    });


    $("#view-all").click(function(){
    	$.ajax({
			         type: "POST",
			         url: "<?php echo site_url('bar/view_all_likers')?>",
			         data : {id:<?php echo $bar_detail['bar_id']; ?>},
			         success: function(response) {
			        	 //$('#myModalnew').modal('show');
			        	  $("#myModalnew").html(response);
			        	   $('#myModalnew').one('shown.bs.modal', function (e) {
    						}).modal();
			           // alert(response);
			        }
			    });
    }) ;
    // $(".morelink").click(function(){
        // if($(this).hasClass("less")) {
            // $(this).removeClass("less");
            // $(this).html(moretext);
            // $(".morelink").html("<i class='strip arrow_down more'></i>View More..");
        // } else {
            // $(this).addClass("less");
            // $(this).html("<i class='strip arrow_up more'></i>View Less..");
        // }
        // $(this).parent().prev().toggle();
        // $(this).prev().toggle();
        // return false;
    // });

    $(".morelink").click(function(){
         $("#myModalnew_open").modal('show');
    });
});
</script>

<script type="text/javascript">
$('#comment_title').live('click', function(e){
    e.preventDefault();
 });
   $(document).ready(function()
   {
   	$('#change-image1').trigger('click');
   	  var lines = 16;
    var linesUsed = $('#linesUsed');
	  initialize_map();
	  $('#menu').click(function() {
		   $('.profile_menu').slideToggle("slow");
	  });


  });
</script>

<script type="text/javascript">
	 $(document).ready(function ()
	 {
		$('#star1').rating('www.url.php', {maxvalue:5});
		$(".cancel").hide();
	 });
</script>
<?php //echo strlen("dsfdsfffffff fdsafdsfds fdsafdsa fdsfds fsdfsdf dsfds fdsf sadfdsa fadsf dsafsda f sdfds f"); die;?>
<script language="javascript" type="text/javascript">
var textarea = document.getElementById("desc_post_card");
textarea.onkeyup = function() {
  var lines = textarea.value.split("\n");
  for (var i = 0; i < lines.length; i++) {
    if (lines[i].length <= 92) continue;
    var j = 0; space = 92;
    while (j++ <= 92) {
      if (lines[i].charAt(j) === " ") space = j;
    }
    lines[i + 1] = lines[i].substring(space + 1) + (lines[i + 1] || "");
    lines[i] = lines[i].substring(0, space);
  }
  textarea.value = lines.slice(0, 10).join("\n");
};

$(document).ready(function(){
    var lines = 16;
    var linesUsed = $('#linesUsed');

    $('#desc_post_card').keyup(function(e) {


        newLines = $(this).val().split("\n").length;


        linesUsed.text(newLines);
        content = document.getElementById('desc_post_card').value.replace(/\n/g, '<br>');

        var num = content.length;
        var rem = $("#countdown").val();

        if((e.keyCode == 13 && newLines >= lines) || num>700) {
            //linesUsed.css('color', 'red');
           // alert('You cannot enter more text.');
            return false;
        }
        else {
        	content = document.getElementById('desc_post_card').value.replace(/\n/g, '<br>');
        	document.getElementById('paste_cont').innerHTML = content;
        	$("#countdown").val(700-parseInt(num));
        }
    });
});

	function limitText(e,limitField, limitCount, limitNum)
	{

		// content = document.getElementById('desc_post_card').value.replace(/\n/g, '<br>');
		   // newLines = limitField.value.split("\n").length;
//
//
		 // if (limitField.value.length > limitNum || (e.keyCode != 13 && newLines>=16)) {
//
		// limitField.value = limitField.value.substring(0, limitNum);
		// return false;
	// } else {
//
		  // $("#linesUsed").html(newLines);
		// limitCount.value = limitNum - limitField.value.length;
		// document.getElementById('paste_cont').innerHTML = content;
		  // limitField.selected = false;
	// }
	}

	function gettitle(val)
	{
		$("#title").html(val+'!');
	}
</script>

<script type="text/javascript">



     function checkauth()
{
	//$('#myModal').modal('show');


}

	function show_popup()
	{
		 <?php if($this->session->userdata('user_type')=='taxi_owner'){?>
  	    	  $.growlUI('<?php echo NO_RIGHT; ?>');
  	    	   $(".growlUI strong").empty();
  	    	  return false;
  	    <?php } ?>
		$(".star").removeClass("on");
		$("#postcard").val(0);
		$('#dvLoading').fadeIn('slow')
		setTimeout(function ()
		{
			$('#dvLoading').fadeOut('slow')
		}, 500);

		if($('#sess_id').val()==1)
		{
			$('#myModal1').modal('show');
		}
		else
		{

			$('#loginmodal').modal('show');
		}
	}


		$('document').ready(function()
		{
		$('#form').validate(
		{

		rules: {
					file: {
						accept: "jpg|jpeg|png|bmp"
					},
					desc_post_card: {
						required: true,
					},
					captcha: {
						required: true,
					},
						errorClass:'error fl_right'
				},

		submitHandler: function(form){
			$("#postcard").val(1);
			if($("#sess_id").val()==0)
			{
				$('#loginmodal').modal('show');
				//return false;
			}
			else
			{
				 <?php if($this->session->userdata('user_type')=='taxi_owner'){?>
  	    	  $.growlUI('<?php echo NO_RIGHT; ?>');
  	    	   $(".growlUI strong").empty();
  	    	  return false;
  	    <?php } ?>
		$(form).ajaxSubmit({
		type: "POST",
		   		 dataType : 'json',
				 beforeSubmit: function()
				 {
		       		$('#dvLoading').fadeIn('slow');

		       		if($("#sess_id").val()==1)
		       		{
		       		 var retVal = confirm("Do you want to send this postcard?");
					   if( retVal == true ){
					      //alert("User wants to continue!");
						  return true;
					   }else{
					    //  alert("User does not want to continue!");
						  return false;
					   }
					}
		    	 },

		    	uploadProgress: function ( event, position, total, percentComplete ) {
		        },

		    	success : function ( json )
		    	{

					if(json.status == "fail")
					{
						$('#change-image').trigger('click');
						$("#cm-err-main1").show();
						$("#cm-err-main1").html(json.comment_error);
			    		$('#dvLoading').fadeOut('slow')
				  		setTimeout(function ()
						{
						      $("#cm-err-main").fadeOut('slow');
						}, 3000);
						return false;
					}

					else
					{
						$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
						$("#desc_post_card").val("");
						$("#countdown").val(300);
						$("#paste_cont").empty();
						$("#crd_not_send").empty();
						$("#crd_not_send").html("<div  class='error mar_top20  center'>Hello user now you can send another post card after 24 hours</div>");
						$("#preview").empty();
						$.growlUI('Your post card send successfully . You can send another postcard after 24 hours');
					}

					$('#dvLoading').fadeOut('slow');
					$('.profile_menu').fadeOut('slow');

		   		 }
		    });
		    }
		  }
		})


		$('#contact').validate(
		{
		rules: {
					name: {
						required: true,
					},
						captcha2: {
						required: true,
					},
					email_new: {
						required: true,
						email: true
					},
					// phone: {
						// required: true,
					// },
					desc: {
						required: true,
					},

						errorClass:'error fl_right'
				},

		submitHandler: function(form){
		$(form).ajaxSubmit({
				type: "POST",
		     	dataType : 'json',
				beforeSubmit: function()
				{
		       		$('#dvLoading').fadeIn('slow');
		    	},
		    	uploadProgress: function ( event, position, total, percentComplete ) { 	},
		    	success : function ( json )
		    	{
					if(json.status == "fail")
					{
						$('#change-image1').trigger('click');
						$("#cm-err-main_contact").show();
						$("#cm-err-main_contact").html(json.comment_error);
					    $('#dvLoading').fadeOut('slow')
						  setTimeout(function ()
								 {
								      $("#cm-err-main_contact").fadeOut('slow');
								}, 3000);
						return false;
					}

					else
					{
						$('#change-image1').trigger('click');
						$("#cm-err-main_contact").hide();
						$("#name").val("");
						$("#captcha-form1").val("");
						$("#phone").val("");
						$("#email_new").val("");
						$("#desc").val("");
						$.growlUI('<?php echo "Your Inquiry send successfully to bar owner ."; ?>');
					}
					$('#dvLoading').fadeOut('slow');
					$('.profile_menu').fadeOut('slow');
		   		 }
		    });
		  }
		})
	  });


	 $('#frm_add_review').ajaxForm(
	 {

	 	type: "POST",
    	dataType : 'json',
		beforeSubmit: function()
		{
        	$("#frm_add_review").validate(
        	{
		   	rules:
		   	{
			   comment_title: {required: true},
               comment: {required: true},
               rating: {required: true}
		   	}
       		});
       		$('#dvLoading').fadeIn('slow');
   		 },

    	 uploadProgress: function ( event, position, total, percentComplete ) { },

    	 success : function ( json )
    	 {
			if(json.status == "fail")
			{
				$("#cm-err-main").show();
				$("#cm-err-main").html(json.comment_error);
			    $('#dvLoading').fadeOut('slow')
				  setTimeout(function ()
						 {
						      $("#cm-err-main").fadeOut('slow');
						}, 3000);
				return false;
			}

			else
			{
				$("#cm-err-main").hide();
				$("#comment_title").val("");
				$("#comment").val("");
				$("#rating").val("");
				$("#desc_post_card").val("");
				$("#cm-err-main").html("");
				$.growlUI('<?php echo "Your review was added successfully ."; ?>');
			}
			var data = '';
			data += '<li>';
			data +='<div class="reult_sub_title "><a class="bar_title">'+json.comment_title+'</a></div>';
			data +='<div class="rating_box">'+ json.date_duration +'</div><div class="clearfix"></div>';
			data +='<p class="result_desc">'+json.comment+'</p>';
			data +='<div class="reult_sub_title"><p class="review_light pull-left">'+json.first_name+' '+ json.last_name +'</p></div>';
			data +='<div class="rating_box starrating'+json.bar_rating+'"><a href="javascript://"></a></div><div class="clearfix"></div></li>';
			$('.review_block').prepend(data);
			$('#test').val(json.testdd);
			$('#myModal1').modal('hide');

	        $(':input','#add-comment')
			  .not(':button, :submit, :reset, :hidden')
			  .val('')
			  .removeAttr('checked')
			  .removeAttr('selected');
			   $('#dvLoading').fadeOut('slow');
			   $('.profile_menu').fadeOut('slow');
	    	}
		});



$(".pagination li a").click(function() {
		  //alert("Handler for .click() called.");
		  var res = $.ajax(
	        {
			   type: 'POST',
			   url: $(this).attr("href"),
			   dataType: 'post',
			   cache: false,
			   async: false,
			   beforeSend : function(){
			      $('#dvLoading').fadeIn('slow');
			   },
			   complete: function(){
			     $('#dvLoading').fadeOut('slow');
			    }
			}).responseText;
			$("#responsecomment").html(res);

			return false;

		});

	var directionDisplay;
	var directionsService = new google.maps.DirectionsService();
	var map;
        var service;

	function initialize() {
	var address ="<?php echo @$bar_detail['address']." ".@$bar_detail['city']." ".@$bar_detail['state']." ".@$bar_detail['zipcode'];?>";
			directionsDisplay = new google.maps.DirectionsRenderer();
			var melbourne = new google.maps.LatLng(-37.813187, 144.96298);
			var myOptions = {
				zoom:12,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				center: melbourne
			}

			map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
			if (geocoder) {
                            geocoder.geocode( { 'address': address}, function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
                                map.setCenter(results[0].geometry.location);

                                        var infowindow = new google.maps.InfoWindow(
                                            { content: '<b>'+address+'</b>',
                                              size: new google.maps.Size(150,50)
                                            });

                                        var marker = new google.maps.Marker({
                                            position: results[0].geometry.location,
                                            map: map,
                                            title:address
                                        });
                                        google.maps.event.addListener(marker, 'click', function() {
                                            infowindow.open(map,marker);
                                        });
                                       
                                  }
                            }
                          });
		google.maps.event.trigger(map, 'resize');
		directionsDisplay.setMap(map);
	}
    }
        
        

function loadMap()
{
	$.ajax({
	       type: "POST",
		   url: "<?php  echo site_url('bar/getmapajax')?>",
		   data: {id:<?php echo $bar_detail["bar_id"]; ?>},
		   dataType : 'html',
		     beforeSend : function() {
		   		$('#dvLoading').fadeIn('slow');
		   },
		    complete : function() {
		   		$('#dvLoading').fadeOut('slow');
		   },
		   success: function(response) {
		   	$("#mapmodal").html(function(){
		   		$(this).html(response);
		   		$('#mapmodal').on('show.bs.modal', function() {

                         initialize();

    						}).modal();

    						 setTimeout(function() {
					       initialize();
						}, 200);
		   	});
		    //$('#mapmodal').one('show.bs.modal', function (e) {
		    	//$('#myModalnew').one('shown.bs.modal', function (e) {


		  }
	   });
}

</script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js" ></script>
<script type="text/javascript">
 $(document).ready(function() {

		   $("#phone").inputmask("(999) 999-9999");
	});
  var geocoder;
  var map;
  var address ="<?php echo @mysql_real_escape_string($bar_detail['address'])." ".@$bar_detail['city']." ".@$bar_detail['state']." ".@$bar_detail['zipcode'];?>";
//  var id = "";
  function initialize_map()
  {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var myOptions = {
      zoom: 17,
      center: latlng,
    mapTypeControl: true,
    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
    navigationControl: true,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("gmap_marker"), myOptions);
    if (geocoder) {
      geocoder.geocode( { 'address': address}, function(results, status) {
//      id = results[0].place_id;
//      loadGoogRev(id);
        if (status == google.maps.GeocoderStatus.OK) {
          if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
          map.setCenter(results[0].geometry.location);
       
            var infowindow = new google.maps.InfoWindow(
                { content: '<b>'+address+'</b>',
                  size: new google.maps.Size(150,50)
                });

            var marker = new google.maps.Marker({
                position: results[0].geometry.location,
                map: map,
                title:address
            });
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map,marker);
            });

          }
            var request = {
                location: results[0].geometry.location,
                //radius: '50',
                keyword: "<?php echo $bar_detail['bar_title'];?>",
                rankBy: google.maps.places.RankBy.DISTANCE,
                //type: ['bar'],
                };

                service = new google.maps.places.PlacesService(map);
                service.nearbySearch(request, callback);
        }
      });
    }
  }
  
function callback(results, status) {
    if (status == google.maps.places.PlacesServiceStatus.OK) {
        var barname = "<?php echo $bar_detail['bar_title'];?>";
        if (barname == results[1].name) {
            var placeid = results[1].place_id;
            loadGoogRev(placeid);
        }   else {
            var placeid = results[0].place_id;
            loadGoogRev(placeid);
        }
    }
}

function loadGoogRev(pid) {
//    console.log(pid);
    $("#google-reviews").googlePlaces({
                  placeId: pid
                , render: ['reviews']
                , min_rating: 3
                , max_rows: 5
          });
}

function fbShare(){
	window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('<?php echo site_url('bar/details/'.$bar_detail['bar_slug']); ?>'),'facebook-share-dialog','width=626,height=436');
            return false;
}

function twShare()
{
	var width  = 575,
        height = 400,
        left   = ($(window).width()  - width)  / 2,
        top    = ($(window).height() - height) / 2,
        url    = 'http://twitter.com/share?url=<?php echo site_url('bar/details/'.$bar_detail['bar_slug']); ?>',
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
        url    = 'http://www.pinterest.com/pin/create/button/?url=<?php echo site_url('bar/details/'.$bar_detail['bar_slug']); ?>&media=<?php echo $img; ?>&description=<?php //echo $bar_detail['bar_desc']; ?>',
        opts   = 'status=1' +
                 ',width='  + width  +
                 ',height=' + height +
                 ',top='    + top    +
                 ',left='   + left;

    window.open(url, 'Pinterest', opts);

    return false;
}

function addToCart(iid,bar_id)
	{
		$.ajax({
			url:'<?php echo site_url('shopping/addTocart') ?>',
			type:'POST',
			dataType:'json',
			data:{id:iid,bar_id:bar_id},
			success:function(data){

				if(data.count>0)
				{
					$("#cartcount").html('<span class="itemcart">'+data.count+'</span>');
					$("#cartcount_2").html('<span class="itemcart">'+data.count+'</span>');
					//alertify.alert("Item has been added to cart Successfully");
					$.growlUI('<?php echo "Item has been added to cart Successfully"; ?>');
				}

				if(data.count==0)
				{
					$.growlUI('<?php echo "Item Not available"; ?>');
				}
			}
		})
	}


function opengallery(id)
{
	  $.ajax({
			         type: "POST",
			         url: "<?php echo site_url('bar/getAllGalAjaxbar')?>",
			         data : {id:id,id1:<?php echo $bar_detail['bar_id']?>},
			         beforeSend : function(){
			      $('#dvLoading').fadeIn('slow');
			   },
			   complete: function(){
			     $('#dvLoading').fadeOut('slow');
			   },
			         success: function(response) {

			           			           	 //$('#myModalnew_ajax').on('show.bs.modal', function (e) {
			           	 $('#myModalnew_ajax').one('show.bs.modal', function (e) {
			           	 	$("#myModalnew_ajax").empty();
			           	 	$("#myModalnew_ajax").html(response);
			           	 	    $('.pgwSlideshow').pgwSlideshow();
    						 }).modal();


			           // alert(response);
			        }
			    });



}

  function see_gal()
  {

  	  $("#see_gal").slideDown();
  	   scrollToDiv('see_gal');
  }
  function hide_gal()
  {
  	$("#see_gal").slideUp();
  }

function loadTaxi()
{
	$.ajax({
	       type: "POST",
		   url: "<?php  echo site_url('taxiowner/gettaxiajax')?>",
		   data: {id:<?php echo $bar_detail["bar_id"]; ?>},
		   dataType : 'html',
		     beforeSend : function() {
		   		$('#dvLoading').fadeIn('slow');
		   },
		    complete : function() {
		   		$('#dvLoading').fadeOut('slow');
		   },
		   success: function(response) {
		   	$("#taximodal").html(function(){
		   		$(this).html(response);
		   		$('#taximodal').one('shown.bs.modal', function() {

    						}).modal();

    						 setTimeout(function() {
					       loadData_taxi(0,15);
					       check();
					       $('#infinite-favorite-taxi').slimscroll({
		        alwaysVisible: true,
		        height: 200,
		        color: '#f19d12',
		        opacity: .8
		      });
						}, 200);
		   	});
		    //$('#mapmodal').one('show.bs.modal', function (e) {
		    	//$('#myModalnew').one('shown.bs.modal', function (e) {


		  }
	   });
}

function callhour()
{
	 getBarSpecialHours('<?php echo date('l'); ?>');
}

function callhhour()
{
	 getBarHappyHours();
}

function getBarSpecialHours(day)
{
	$.ajax({
	       type: "POST",
		   url: "<?php  echo site_url('bar/getBarSpecialHoursByID')?>",
		   data: {id:<?php echo $bar_detail["bar_id"]; ?>,day:day},
		   dataType : 'html',
		     beforeSend : function() {
		   		$('#dvLoading').fadeIn('slow');
		   },
		    complete : function() {
		   		$('#dvLoading').fadeOut('slow');
		   },
		   success: function(response) {
		   	$('#displayhours').html(response);
		    //$('#mapmodal').one('show.bs.modal', function (e) {
		    	//$('#myModalnew').one('shown.bs.modal', function (e) {


		  }
	   });
	   }
           
           
function getBarHappyHours()
{
	$.ajax({
	       type: "POST",
		   url: "<?php  echo site_url('bar/getBarHappyHoursByID')?>",
		   data: {id:<?php echo $bar_detail["bar_id"]; ?>},
		   dataType : 'html',
		     beforeSend : function() {
		   		$('#dvLoading').fadeIn('slow');
		   },
		    complete : function() {
		   		$('#dvLoading').fadeOut('slow');
		   },
		   success: function(response) {
		   	$('#displayhappyhours').html(response);
		    //$('#mapmodal').one('show.bs.modal', function (e) {
		    	//$('#myModalnew').one('shown.bs.modal', function (e) {


		  }
	   });
	   }

</script>
    
    <script>
    </script>

<!--

<div itemscope itemtype="http://schema.org/LocalBusiness" style="display:none;>
<a itemprop="url" href="<?php // echo site_url('bar/bar/'.$bar_detail['bar_slug']);?>"><div itemprop="name"><strong><?php // echo $bar_detail['bar_title']; ?></strong></div>
</a>
<div itemprop="description"> Get a free consultation with an experienced Scottsdale attorney, Adam Davis. Speak directly to Adam Davis (480) 421-1000! No fee unless you get paid!
</div>
<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" style="display:none;>
<span itemprop="streetAddress">10729 N 75th Pl
</span><br>
<span itemprop="addressLocality">Scottsdale</span><br>
<span itemprop="addressRegion">Arizona</span><br>
<span itemprop="postalCode">85260</span><br>
<span itemprop="addressCountry">USA</span><br>
</div>  -->







   <div itemscope itemtype="http://schema.org/LocalBusiness" style="display:none;">


<?php
		          		if($bar_detail['bar_banner']!="" && file_exists(base_path().'upload/banner_drag/'.@$bar_detail['bar_banner']))
					{?>
		            	  $img =    <?php echo base_url()?>/upload/banner_drag/<?php echo $bar_detail['bar_banner']; ?>;
		            	<?php }  else if($bar_detail['bar_banner']!="" && file_exists(base_path().'upload/banner_drag_without/'.@$bar_detail['bar_banner']))
					{?>
						$img = <?php echo base_url()?>/upload/banner_without_drag/<?php echo $bar_detail['bar_banner']; ?>;

		            		<?php } else {?>
		            		$img = <?php echo base_url().'default'?>/images/smallbanner1.png";
		            			<?php } ?>
		<span itemprop="name"><?php echo $bar_detail['bar_title'];?></span>
		<div itemprop="description"> <?php echo $bar_detail['bar_desc'];?></div>
			<span  itemprop="email"><?php echo $bar_detail['email'];?></span>

			<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" class="mart10">
			<p itemprop="streetAddress" class="bar_add">
				<?php echo $bar_detail['address'];?>
			</p>

		</div>

			<span id="_telephone3" itemprop="telephone"><?php echo $bar_detail['phone'];?></span>,
			<img  itemprop="image" src="<?php echo $img; ?>" alt="American Dive Bars"/>
			<span itemprop="ratingCount"><?php echo getReviewRating($bar_id);?></span>
			<label itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" id="title">
				 <span itemprop="postalCode"><?php echo $bar_detail['zipcode'];?></span>
				 <span itemprop="addressRegion"><?php echo $bar_detail['state'];?></span>
				 <span itemprop="addressLocality"><?php echo $bar_detail['city'];?></span>! </label>






			<ul itemscope itemtype="http://schema.org/LocalBusiness">
				<?php if($barhours){
     							  foreach($barhours as $r){?>
			<li itemprop="openingHoursSpecification" itemscope itemtype="http://schema.org/OpeningHoursSpecification">
				<span itemprop="dayOfWeek" itemscope itemtype="http://schema.org/DayOfWeek">
					<div itemprop="name" class="schedule-text">
						<?php echo $r->days;?>
					</div></span>
					<?php if($r->is_closed!='yes'){ ?>
					<meta itemprop="opens" content="<?php echo date("g:i a", strtotime($r->start_from));?>">
					<?php if($r->is_closed!='yes'){  print( date("g:i a", strtotime($r->start_from)) ); } else { echo "Closed"; }?>
					<meta itemprop="closes" content="<?php echo  date("g:i a", strtotime($r->start_to));?>">
					<?php if($r->is_closed!='yes'){ print( date("g:i a", strtotime($r->start_to)) ); } else { echo "Closed"; }?>
					<?php } else {?>
						<meta itemprop="closes" content="Please insert valid ISO 8601 date/time here. Examples: 2015-07-27 or 2015-07-27T15:30">Closed
					<?php } ?>
			</li>
			<?php } } ?>
		</ul>



	</div>
