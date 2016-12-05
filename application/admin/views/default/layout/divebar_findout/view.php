<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="<?php echo base_url().getThemeName();?>/js/tiny_mce/tiny_mce.js" type="text/javascript"></script>


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
</script>

<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($dictionary_id==""){ echo 'dictionary'; } else { echo 'dictionary'; }?></h3>
					
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
							<div class="caption"></div>
						</div>
						<div class="portlet-body form">
							<div class="content ">
								<?php
									$attributes = array('id'=>'usualValidate','name'=>'frm_addmessage','class'=>'main');
									echo form_open_multipart('dictionary/view/'.$dictionary_id.'/'.$redirect_page.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset,$attributes);
								?>
			  						
									<div class="control_group">
										<label class="control_label">  <h3> Dictionary Name : </h3>  </label>
										<div class="controls">
											<?php echo $dictionary_title; ?>
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
									
									
									<!-- <div class="control_group">
										<label class="control_label">  <h3> Author Name : </h3>  </label>
										<div class="controls">
											<?php echo $first_name .' '. $last_name;  ?>
										</div>										
										<div class="clear"></div>
									</div> -->
									
									<div class="control_group">
										<label class="control_label"> <h3> Dictionary Description : </h3>  </label>
										<div class="controls">
											 <?php echo $dictionary_description;?>
											<!--<input type="hidden" id="topic_description" name="topic_description" value="<?php echo $topic_description;?>" class="m_wrap wid360" />-->
										</div>										
										<div class="clear"></div>
									</div>
							</div>
							
							<!--<input type="hidden" name="from_user_id" id="from_user_id" value="<?php echo $to_user_id;?>" />-->
							
							
							<input type="hidden" name="message_id" id="message_id" value="<?php if($master_id==0){echo $dictionary_id;}else{echo $master_id;} ?>" />
							<input type="hidden" name="master_id" id="master_id" value="<?php echo $dictionary_id; ?>" />
							<input type="hidden" name="admin_id" id="admin_id" value="<?php echo get_authenticateadminID(); ?>" />
							<input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
							<input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
							<input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
							<input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
							
							<input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
							<input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
							<input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							
							
						</div>
						
					</div>
				</div>
			</div>
		</div>
</div>