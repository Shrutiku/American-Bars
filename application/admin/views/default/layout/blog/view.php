<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="<?php echo base_url().getThemeName();?>/js/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<link href="<?php echo base_url().getThemeName();?>/css/blog.css" rel="stylesheet" type="text/css"/>



<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "simple"
	});
	
	$(document).ready(function(){
		/*$("#usualValidate").validate({
			rules: {
				doctor_id:'required',
				description:'required',
			},
			messages: {
				doctor_id:"Doctor is required.",
				description:"Description name is required.",	
			}
		});*/
		
		
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
	
		function conform_delete(cid,cmid)
	{
		var t = confirm("Are you Sure ?");
		
		if(t == true)
		{
			document.location.href = '<?php echo site_url("article/delete_comment") ?>/'+cid+'/'+cmid;
		}
		
		return false;
		
	}
</script>

<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title fl_left"><?php if($blog_id==""){ echo 'Article'; } else { echo 'Article'; }?></h3>
					
					
					
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
							<div class="caption fl_left"></div>
							<div class="fl_right">
                        
						<a id="" class="btn black  fl_left mar_r_5" href="<?php echo site_url('article'); ?>">Back</a>
                    </div>
                    <div class="clear"></div>
						</div><div class="clearfix"></div>
						<div class="portlet-body form blog-page">
							<div class="content ">
								<?php
									$attributes = array('id'=>'usualValidate','name'=>'frm_addmessage','class'=>'main');
									echo form_open_multipart('article/view/'.$blog_id.'/'.$redirect_page.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset,$attributes);
								?>
			  						
			  						<input type="hidden" name="blog_id" id="blog_id" value="<?php echo $blog_id; ?>" />
									<div class="control_group">
										<label class="control_label">  <h3> Article Name : </h3>  </label>
										<div class="controls">
											<?php echo $blog_title; ?>
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
											<?php echo $first_name .' '. $last_name;  ?>
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label"> <h3> Blog Description : </h3>  </label>
										<div class="controls">
											 <?php echo $blog_description;?>
											<!--<input type="hidden" id="topic_description" name="topic_description" value="<?php echo $topic_description;?>" class="m_wrap wid360" />-->
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="row-fluid">
									
									<div class="span6">
										<div class="portlet blue">
											<div class="portlet-title line">
												<div class="caption"><i class="icon-comments"></i>Article <span style="float: right"> Total Comment : <?php echo $total_comment; ?> </span> 
											</div>
											</div>
											<div class="portlet-body" id="chats">
												<div class="scroller" style="height:auto" data-always-visible="1" data-rail-visible1="1">
													<?php
								if($reply)
								{
									foreach($reply as $re)
									{?>
										<div class="media">
								
									<a href="#" class="pull-left">
										<?php
										if($re->profile_image != "" && is_file(base_path()."upload/user_thumb/".$re->profile_image))
										{?>
											<img alt="" src="<?php echo front_base_url()."/upload/user_thumb/".$re->profile_image; ?>" class="media-object">
										<?php }
										else{
										?>
									<img alt="" src="<?php echo front_base_url()."/upload/no_img.png"; ?>" class="media-object">
								  <?php }?>
									</a>
									<div class="media-body">
										<h4 class="media-heading"><?php echo $re->comment_title; ?> <span><?php echo getDuration($re->date_added); ?> / 
											<a href="javascript:void(0);" onclick="return conform_delete('<?php echo $blog_id ?>','<?php echo $re->blog_comment_id ?>')">Delete</a></span></h4>
										<p>
											<?php echo $re->comment; ?>
										 </p>
										<hr>
										
										<?php 
										$sub_comment = $this->blog_model->get_blog_subcomment_result($re->blog_comment_id); 
										if($sub_comment)
										{
										   foreach($sub_comment as $sb)
										   {?>
									<!-- Nested media object -->
										<div class="media">
											<a href="#" class="pull-left">
											<?php
										if($sb->profile_image != "" && is_file(base_path()."upload/user_thumb/".$sb->profile_image))
										{?>
											<img alt="" src="<?php echo front_base_url()."/upload/user_thumb/".$sb->profile_image; ?>" class="media-object">
										<?php }
										else{
										?>
									<img alt="" src="<?php echo front_base_url()."/upload/no_img.png"; ?>" class="media-object">
								  <?php }?>
											</a>
											<div class="media-body">
												<h4 class="media-heading"><?php echo $sb->comment_title; ?>  <span><?php echo getDuration($re->date_added); ?> / <a href="#">Delete</a></span></h4>
												<p>
											<?php echo $sb->comment; ?>
										 </p>
											</div>
										</div>
										<hr>
											<!-- end Nested media object -->
									 <?php }	
										}
										?>
										
										
									</div>
								</div>
							  <?php }
								}
								?>
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
							
							<!--<input type="hidden" name="from_user_id" id="from_user_id" value="<?php echo $to_user_id;?>" />-->
							
							
							<input type="hidden" name="message_id" id="message_id" value="<?php if($master_id==0){echo $blog_id;}else{echo $master_id;} ?>" />
							<input type="hidden" name="master_id" id="master_id" value="<?php echo $blog_id; ?>" />
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