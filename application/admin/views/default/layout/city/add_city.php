<script>

$(document).ready(function(){		
	$("#usualValidate").validate({
		
		rules: {
			country_id:'required',
			city_name:'required',
			state_id:'required',
			lat:'required',
			lng:'required',
			
		},
		messages: {
			first_name:"Country  is required.",
			state_id:"State is required.",
			city_name:"State is required.",
			lat:'Latitude is required',
			lng:'Longitude is required',
						
		}
	});
	
	
	 $.validator.addMethod("loginRegex", function(value, element) {
		
        return this.optional(element) || /^\w{5,}$/i.test(value);
    }, "Username must contain only letters, numbers, or underscore.");
	

	
});	
	
function get_state()
{

	var country_id = document.getElementById('country_id').value;
	$.ajax({
			type:'POST',
			url:"<?php echo site_url('city/get_state_ajax');?>",
			data:'country_id='+country_id,
				success: function(data){
					
					 $('#state_id').html('');
					
					 $('#state_id').html(data);
					
				}
			});
}	

</script>
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($city_id==""){ echo 'Add City'; } else { echo 'Edit City'; }?></h3>
					
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
				$attributes = array('id'=>'usualValidate','name'=>'frm_addcity','class'=>'main');
				echo form_open_multipart('city/add_city',$attributes);
			  ?>
			  						<div class="control_group">
										<label class="control_label">Country:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="country_id" id="country_id" onchange="get_state()"> 
												<option value="">--Select--</option>
												<?php if($all_countries!=''){
													foreach ($all_countries as $ac) {?>
														<option value="<?php echo $ac->Country_ID ?>" <?php echo ($country_id==$ac->Country_ID)?'selected="selected"':'' ?>><?php echo $ac->Country_Name ?></option>
													<?php }
												} ?>
											</select>
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">State:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="state_id" id="state_id"> 
												<option value="">--Select--</option>
												<?php if($states!=''){
													foreach ($states as $as) {?>
														<option value="<?php echo $as->state_id ?>" <?php echo ($state_id==$as->state_id)?'selected="selected"':'' ?>><?php echo $as->state_name ?></option>
													<?php }
												} ?>
											</select>
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">City Name:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="city Name...." class="m_wrap wid360" name="city_name" id="city_name" value="<?php echo $city_name; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">Zipcode:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="city Name...." class="m_wrap wid360" name="zipcode" id="zipcode" value="<?php echo $zipcode; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">Latitude:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Latitude...." class="m_wrap wid360" name="lat" id="lat" value="<?php echo $lat; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">Longitude:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Longitude...." class="m_wrap wid360" name="lng" id="lng" value="<?php echo $lng; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
								
							</div>	
							<input type="hidden" name="city_id" id="city_id" value="<?php echo $city_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php if($city_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_city')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>city/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>city/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_city')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>city/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>city/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
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
