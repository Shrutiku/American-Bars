<?php //$ut=(get_authenticateType()=='stylist'?'stylist':'user'); ?>
							<?php
							if($ticketConv!='')
							{
								foreach ($ticketConv as $c) {
										$user_info = get_user_info($c->from_user_id);
																	
																	$name = @$user_info->first_name." ".@$user_info->last_name;
																	$profile_image = $user_info -> profile_image;
																	if($profile_image != "" && file_exists(base_path()."/upload/user_thumb/".$profile_image))
																	{
																		$profile_image = 'upload/user_thumb/'.$profile_image;
																	}
																	else
																	{
																		$profile_image = 'upload/no-image.png';
																	}	
								//	echo $tc->replyBy;die;
								//	switch ($tc->replyBy) {
										//case 'user': ?>
											
											<div class="mar_top20">
     							<div class="msg_content reply_bg">
     								<h1 class="msg_username"><?php echo ucwords($name) ?></h1>
     								
     								<p class="dashboard_desc">
     										<?php echo $c->description; ?>
     								</p>
     								<p class="msg_date"><?php echo getDuration($c->date_added);?></p>
     							</div>
     							<div class="msg_img marl_10">
     								<img class="img-responsive" alt="" src="<?php echo base_url();?><?php echo $profile_image; ?>" />
     								<i class="strip msg_reply"></i>
     							</div>
     							<div class="clearfix"></div>
     						</div>
     						
							
									
									
											
										<?php //	break;
									//}
								}
							} 
							?>
							
						