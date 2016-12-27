<?php //$ut=(get_authenticateType()=='stylist'?'stylist':'user'); ?>
							<?php
							if($ticketConv!='')
							{
								foreach ($ticketConv as $c) {
									
								//	echo $tc->replyBy;die;
								//	switch ($tc->replyBy) {
										//case 'user': ?>
											
								<li class="in">										
									<img class="avatar" alt="" src="<?php echo $pim; ?>" />
									<div class="message">
										<span class="arrow"></span>
										<a href="#" class="name"><?php echo ucwords($userInfo->first_name.' '.$userInfo->last_name) ?></a>
										<span class="datetime">at <i class="timeago" title=""><?php echo getDuration($c->date_added) ?></i></span>
										<span class="body"><?php echo $c->description; ?></span>
									</div>
								</li><div class="clear"></div>
											
										<?php //	break;
									//}
								}
							} 
							?>
							
						