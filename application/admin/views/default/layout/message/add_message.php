<style>
	.ui-widget{
		max-height:250px;
		overflow-x: scroll;
	}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/jquery.tagsinput.css" />
<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

<script src="<?php echo base_url().getThemeName();?>/js/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<script src="<?php echo base_url().getThemeName();?>/js/jquery.tagsinput.js" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>

<script type="text/javascript">
	
$(document).ready(function(){
	$("#usualValidate").validate({
                ignore: "",
		rules: {
			subject:'required',
			to_user_id:'required',
			description:'required',
			
		},
		
	});
	});
</script>

<!-- <style type="text/css">
	div.tagsinput input{ width:auto !important; }
</style> -->

<script>

$(document).ready(function(){
	var arrVal = new Array();
	var t = $("[class=user_type]").val();
	$('.tags').tagsInput({
		autocomplete_url:'<?php echo site_url('message/get_user_list/');?>',
		itemValue: 'value',
		itemText: 'text',
		autocomplete:{
		   source: function(request, response) {
		  var t = $('input[type="radio"]:checked').val();
			  $.ajax({
				 url: "<?php echo site_url('message/get_user_list');?>",
				 dataType: "json",
				 data: {
				   utype : t,
					em: request.term,
					
				 },
				 success: function(data) {
					response( $.map( data, function( item ) {
						return {
							label: item.label,
							value: item.value
						}
					}));
				}
			  })
		   },
		}
	});
	
	
});	
	


</script>

<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($message_id==""){ echo 'Add Message'; } else { echo 'Edit Message'; }?></h3>
					
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
									echo form_open_multipart('message/add_message',$attributes);
								?>
			  						
									<div class="control_group">
										<label class="control_label">Select type :</label>
										<div class="controls">
											<input type="radio" name="to_user_type[]" class="user_type" value="user" checked="checked" /> user
											<input type="radio" name="to_user_type[]" class="user_type" value="bar_owner" /> Bar Owner
											<input type="radio" name="to_user_type[]" class="user_type" value="taxi_owner" /> Taxi_Owner
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Select user :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" name="to_user_id" id="to_user_id" class="m_wrap wid360 tags" />
											<label for="to_user_id" generated="true" class="error" style="display: none;">This field is required.</label>
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Subject :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" id="subject" name="subject" class="m_wrap wid360" />
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Description :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<textarea name="description" id="description" placeholder="Description..." class="m_wrap span9" rows="20" cols="100"  ><?php echo $description; ?></textarea>
											<label for="description" generated="true" class="error" style="display: none;">This field is required.</label>
										</div>										
										<div class="clear"></div>
									</div>
							</div>
							
							<input type="hidden" name="from_user_id" id="from_user_id" value="<?php echo $admin_id;?>" />
							<input type="hidden" name="from_user_type" id="from_user_type" value="<?php echo ($admin_type=='1')?'admin':'';?>" />	
							
							<input type="hidden" name="message_id" id="message_id" value="<?php echo $message_id; ?>" />
							<input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
							<input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
							<input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
							<input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
							
							<input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
							<input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
							<input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							
							<div class="form_action">
								
								<?php if($message_id==""){ ?>
					
									<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
									<?php if($redirect_page == 'list_message') {?>
										<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>message/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
									<?php }else {?>
										<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>message/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
									<?php }?>
									
								<?php }else { ?>
									
									<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
									
									<?php if($redirect_page == 'list_message') {?>
										<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>message/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
									<?php } else {?>
										<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>message/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
									<?php }?>								
								<?php } ?>
								</form>		
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
</div>