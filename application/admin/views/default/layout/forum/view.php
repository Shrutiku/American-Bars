<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="<?php echo base_url().getThemeName();?>/js/tiny_mce/tiny_mce.js" type="text/javascript"></script>


<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "simple"
	});
	
	$(document).ready(function(){
		
		$(function() {
		var validator = $("#usualValidate").submit(function() {
			// update underlying textarea before submit validation
			tinyMCE.triggerSave();
		}).validate({
			ignore: "",
			rules: {
				doctor_id: "required",
				description: "required"
			},
			errorPlacement: function(label, element) {
				// position error label after generated textarea
				if (element.is("textarea")) {
					label.insertAfter(element.next());
				} else {
					label.insertAfter(element)
				}
			}
		});
		validator.focusInvalid = function() {
			// put focus on tinymce on submit validation
			if( this.settings.focusInvalid ) {
				try {
					var toFocus = $(this.findLastActive() || this.errorList.length && this.errorList[0].element || []);
					if (toFocus.is("textarea")) {
						tinyMCE.get(toFocus.attr("id")).focus();
					} else {
						toFocus.filter(":visible").focus();
					}
				} catch(e) {
					// ignore IE throwing errors when focusing hidden elements
				}
			}
		}
	})
	});
</script>

<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($topic_id==""){ echo 'View'; } else { echo 'View'; }?></h3>
					
						
				</div>
				<div class="row_fluid"> 
				<?php  
					if($error != "") {
						
						if($error == 'insert') {
							echo '<div class="success_msg"><p>Record has been updated Successfully.</p></div>';
						}
					
						if($error != "insert"){	
							echo '<div class="error_red">'.$error.'</div>';	
						}
					}
				?>		
					<div class="portlet blue">
						<div class="portlet-title">
							<div class="caption"><i class="icon-comments"></i><span style="float: right"><a class="btn black " href="<?php echo site_url('forum');?>">Back</a></span></div>
							</div>
						<div class="portlet-body form">
							<div class="content ">
								<?php
									$attributes = array('id'=>'usualValidate','name'=>'frm_addmessage','class'=>'main');
									echo form_open_multipart('forum/view/'.$topic_id.'/'.$redirect_page.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset,$attributes);
								?>
			  						
									<div class="control_group">
										<label class="control_label">  <h3> Topic Name : </h3>  </label>
										<div class="controls">
											<?php echo $topic_name; ?>
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">  <h3> Date : </h3>  </label>
										<div class="controls">
											<?php echo $date_created; ?>
										</div>										
										<div class="clear"></div>
									</div>
									
									
									<div class="control_group">
										<label class="control_label">  <h3> Author Name : </h3>  </label>
										<div class="controls">
											<?php if($first_name != ""){echo $first_name .' '. $last_name;} else { echo "Administrator"; }  ?>
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label"> <h3> Topic Description : </h3>  </label>
										<div class="controls">
											 <?php echo $forum_decription;?>
											<!--<input type="hidden" id="topic_description" name="topic_description" value="<?php echo $topic_description;?>" class="m_wrap wid360" />-->
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="row-fluid">
									
									<div class="span6">
										<div class="portlet blue">
											<div class="portlet-title line">
												<div class="caption"><i class="icon-comments"></i>View<span style="float: right"> Total Comment : <?php echo $total_comment; ?> </span></div>
											</div>
											<div class="portlet-body" id="chats">
												<div class="scroller" style="height:auto" data-always-visible="1" data-rail-visible1="1">
													<ul class="chats">
														<?php
															if($reply){
																
																
															foreach($reply as $val){
																//print_r($val); die;
																//echo $val['user_id']; die;
																if($val['user_id']!='' && $val['user_id']!=0 ){
																	$user_info = get_single_detail($val['user_id']);
																?>
																	<li class="in">
																	<?php  
																		 if($user_info->profile_image !='' ){
																		 ?><img class="avatar" alt="" src="<?php echo front_base_url();?>/upload/user_thumb/<?php echo $user_info->profile_image; ?>" />
																		 <?php }
																		 else {
																			?> <img class="avatar" alt="" src="<?php echo front_base_url();?>/upload/user_thumb/no_image.png" />
																		 <?php }
																	 ?>
																	
																		
																		<div class="message">
																			<span class="arrow"></span>
																			<a href="#" class="name"><?php echo get_user_detail($val['user_id']); ?></a>
																			<span class="datetime">at <?php echo date('M d, Y g:i A',strtotime($val['date_created']));?></span>
																			<span class="body">
																			<?php echo html_entity_decode($val['forum_decription']);?>
																			</span>
																		</div>
																</li>		
															<?php	}
																elseif($val['admin_id']!='' && $val['admin_id']!=0) {
																	$user_info = get_single_admin_detail($val['admin_id']);
															    ?> <li class="in">
																	<?php  
																		 if($user_info->image !='' ){
																		 ?><img class="avatar" alt="" src="<?php echo front_base_url();?>/upload/admin/<?php echo $user_info->image; ?>" />
																		 <?php }
																		 else {
																			?> <img class="avatar" alt="" src="<?php echo front_base_url();?>/upload/user_thumb/no_image.png" />
																		 <?php }
																	 ?>
																	
																		
																		<div class="message">
																			<span class="arrow"></span>
																			<a href="#" class="name"><?php echo get_admin_detail($val['admin_id']); ?></a>
																			<span class="datetime">at <?php echo date('M d, Y g:i A',strtotime($val['date_created']));?></span>
																			<span class="body">
																			<?php echo html_entity_decode($val['forum_decription']);?>
																			</span>
																		</div>
																</li> 
															<?php	}
																//print_r($user_info); die;
															?> 
																
															
																
														<?php }
															}
														 ?>
													</ul>
												</div>
												
												<div class="clear"></div>
												
												<!--<div class="chat-form">
													<div class="input-cont">   
														<input class="m-wrap" type="text" placeholder="Type a message here..." />
													</div>
													<div class="btn-cont"> 
														<span class="arrow"></span>
														<a href="" class="btn blue icn-only"><i class="halflings-icon white ok"></i></a>
													</div>
												</div>-->
											</div>
										</div>
										<!-- END PORTLET-->
									</div>
									
									
									<div class="control_group">
										<label class="control_label">Comment:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<textarea name="description" id="description" placeholder="Description..." class="m_wrap span9 wysihtml5" rows="20" cols="100" data-error-container="#editor1_error"></textarea>
											<div id="editor1_error"></div>
										</div>										
										<div class="clear"></div>
									</div>
									</div>
							</div>
							
							<input type="hidden" name="message_id" id="message_id" value="<?php if($master_id==0){echo $topic_id;}else{echo $master_id;} ?>" />
							<input type="hidden" name="master_id" id="master_id" value="<?php echo $topic_id; ?>" />
							<input type="hidden" name="admin_id" id="admin_id" value="<?php echo get_authenticateadminID(); ?>" />
							<input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
							<input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
							<input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
							<input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
							
							<input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
							<input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
							<input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							
							<div class="form_action">
									<input type="submit" name="submit" value="Comment" class="btn green fl_left mar_r_5" />
									<!--<?php if($redirect_page == 'list_message') {?>
										<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>message/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
									<?php }else {?>
										<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>message/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
									<?php }?>-->	
								</form>		
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
</div>