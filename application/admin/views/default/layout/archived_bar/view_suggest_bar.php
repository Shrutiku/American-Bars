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
					<h3 class="page_title">View</h3>
					
						
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
							<div class="caption"><i class="icon-comments"></i><span style="float: right"><a class="btn black " href="<?php echo site_url('suggest_bar/list_suggest_bar')?>">Back</a></span></div>
							</div>
						<div class="portlet-body form">
							<div class="content view-suggest">
								
			  						
									<div class="control_group">
										<h3 class="view-title"> Bar Name : </h3>
										<div class="controls">
											<?php echo $bar_name; ?>
										</div>										
										<div class="clear"></div>
									</div>
									
									 
									 
									<div class="control_group">
										<h3 class="view-title"> Address : </h3>  
										<div class="controls">
											<?php echo $address; ?>
										</div>										
										<div class="clear"></div>
									</div>
									
									
									<div class="control_group">
										<h3 class="view-title"> State : </h3>
										<div class="controls">
											<?php echo $state; ?>
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<h3 class="view-title"> City : </h3>
										<div class="controls">
											 <?php echo $city;?>
											<!--<input type="hidden" id="topic_description" name="topic_description" value="<?php echo $topic_description;?>" class="m_wrap wid360" />-->
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<h3 class="view-title"> Phone Number : </h3>
										<div class="controls">
											 <?php echo $phone_number;?>
											<!--<input type="hidden" id="topic_description" name="topic_description" value="<?php echo $topic_description;?>" class="m_wrap wid360" />-->
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<h3 class="view-title"> Zip Code : </h3>
										<div class="controls">
											 <?php echo $zip_code;?>
											<!--<input type="hidden" id="topic_description" name="topic_description" value="<?php echo $topic_description;?>" class="m_wrap wid360" />-->
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<h3 class="view-title"> Date : </h3>
										<div class="controls">
											 <?php echo date($site_setting->date_format,strtotime($date));
											 ?>
											<!--<input type="hidden" id="topic_description" name="topic_description" value="<?php echo $topic_description;?>" class="m_wrap wid360" />-->
										</div>										
										<div class="clear"></div>
									</div>
									
									
									
							</div>
							
							<input type="hidden" name="suggest_bar_id" id="suggest_bar_id" value="<?php echo $suggest_bar_id; ?>" />
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