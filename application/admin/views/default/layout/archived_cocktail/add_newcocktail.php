
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/bootstrap-fileupload.css" />
<script src="<?php echo base_url().getThemeName();?>/js/jquery-migrate-1.0.0.js"></script>
<script src="<?php echo base_url().getThemeName();?>/js/bootstrap-fileupload.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/jquery.tagsinput.css" />

<script src="<?php echo base_url().getThemeName();?>/js/jquery.tagsinput.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/assets/plugins/chosen-bootstrap/chosen/chosen.css" />
<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<script>

$(document).ready(function(){	
	
	  $(".chosen").each(function () 
		   	{
	            $(this).chosen({
	                allow_single_deselect: $(this).attr("data-with-deselect") == "1" ? true : false
	            });
        	});
	
	var arrVal = new Array();
	var t = $("[class=user_type]").val();
	$('.tags').tagsInput({
		autocomplete_url:'<?php echo site_url('cocktail/getallcocktailbybar/');?>',
		itemValue: 'value',
		itemText: 'text',
		autocomplete:{
		   source: function(request, response) {
		  var t = <?php echo $bars_id; ?>;
			  $.ajax({
				 url: "<?php echo site_url('cocktail/getallcocktailbybar');?>",
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
	
	

	
	
	$("#usualValidate").validate({
		ignore: [],
	             debug: false,
		rules: {
			'cocktail_id[]':'required',
		},		
	});	
	

});	
</script>
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($cocktail_id==""){ echo 'Add Cocktail'; } else { echo 'Edit Cocktail'; }?></h3>					
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
							<div class="content">
								<?php
				$attributes = array('id'=>'usualValidate','name'=>'frm_addcocktail','class'=>'main');
				echo form_open_multipart('cocktail/add_newcocktail/'.$bars_id,$attributes);
			  ?>
			<div class="control_group">
										<label class="control_label">Select Cocktail Name :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<!-- <input type="text" name="cocktail_id" id="cocktail_id" class="m_wrap wid360 tags" /> -->
											<!-- <label for="cocktail_id" generated="true" class="error" style="display: none;">This field is required.</label> -->
											<select data-placeholder="Add Cocktail" name="cocktail_id[]" id="cocktail_id" style="width:600px; height: 100px;" class="m_wrap wid360 chosen" multiple="multiple" tabindex="6">
												<?php if($getallcocktail)
												      { foreach($getallcocktail as $rows)
														  {
														  	$chckexist = checkcocktailbarexist($rows->cocktail_id,$bars_id);
															if($chckexist==0)
														    {
														  	?>
														     <option value="<?php echo $rows->cocktail_id; ?>"><?php echo $rows->cocktail_name; ?></option>
														       	
														  <?php } }
												      }?>
											</select>
										</div>										
										<div class="clear"></div>
									</div>
			  
									
								
							<input type="hidden" name="bars_id" id="bars_id" value="<?php echo $bars_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
					
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
					
					
					<?php if($redirect_page == 'list_cocktail')
						{
							?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>cocktail/<?php echo $redirect_page.'/'.$limit.'/'.$bars_id.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>cocktail/<?php echo $redirect_page.'/'.$limit.'/'.$bars_id.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
					<?php } ?>
					
					
					
					</form>		
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
</div>