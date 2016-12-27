<script>

$(document).ready(function(){	
	
	$("#usualValidate").validate({
		
		rules: {
			country_name:'required',
			country_iso_Code:'required',
			
		},
		messages: {
			country_iso_Code:"Country ISO Code is required.",
			country_name:"Country name is required.",
			
			
		}
	});
	
	
	
});	
	


</script>
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($country_id==""){ echo 'Add Country'; } else { echo 'Edit Country'; }?></h3>
					
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
				$attributes = array('id'=>'usualValidate','name'=>'frm_addcountry','class'=>'main');
				echo form_open_multipart('country/add_country',$attributes);
			  ?>
			  						<div class="control_group">
										<label class="control_label">Country Name:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Country Name...." class="m_wrap wid360" name="country_name" id="country_name" value="<?php echo $country_name; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">Country ISO Code:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Country ISO Code...." class="m_wrap wid360" name="country_iso_Code" id="country_iso_Code" value="<?php echo $country_iso_Code; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<div class="controls">
											<label class="checkbox">
											<span><label class="control_label">Active ?<input type="checkbox" class="marL10" value="n" <?php echo ($is_delete=='n')?'checked="checked"':''; ?> name="is_delete" id="is_delete"></label></span>
											</label>
										</div>										
										<div class="clear"></div>
									</div>
									
									
									
									
								
							</div>	
							<input type="hidden" name="country_id" id="country_id" value="<?php echo $country_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php if($country_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_country')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>country/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>country/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_country')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>country/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>country/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
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