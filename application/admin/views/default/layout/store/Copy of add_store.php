<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="<?php echo base_url().getThemeName();?>/js/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<script>

$(document).ready(function(){	
$("#color").chosen();
	tinyMCE.init({
		mode : "textareas",
		theme : "simple"
	});


	
	$("#usualValidate").validate({
		
		rules: {
			news_title:'required',
			news_category:'required',
			status : 'required'
			
			
		},
		
	});
	
	
	

	
});	
	


</script>
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($store_id_id==""){ echo 'Add Store'; } else { echo 'Edit Store'; }?></h3>
					
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
				$attributes = array('id'=>'usualValidate','name'=>'frm_addnews','class'=>'main');
				echo form_open_multipart('store/add_store',$attributes);
			  ?>
			
			  
			  						<div class="control_group">
										<label class="control_label">Product Name :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Product Name...." class="m_wrap wid360" name="product_name" id="product_name" value="<?php echo $product_name; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Quantity :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Quantity...." class="m_wrap wid360" name="quantity" id="quantity" value="<?php echo $quantity; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Color:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select data-placeholder="Select Color" class="m_wrap wid360 chosen" multiple="multiple" id="color" tabindex="6" name="color[]">
                                                <option value="">&nbsp;</option>
                                                <?php
                                                //$c=($color!='')?explode('-',$color):array();
                                                if($colorlist!=''){
                                                 foreach($colorlist as $cl){?>
                                                    <option value="<?php echo $cl->Color_id ?>" <?php // echo (in_array($cl->Color_id,$color)?'selected':'') ?>><?php echo ucwords($cl->color_name); ?></option>
                                            <?php   }} ?>
                                            </select>
											
										</div>										
										<div class="clear"></div>
									</div>						
									
									<div class="control_group">
										<label class="control_label">Status:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="status" id="status"> 
												<option value="">--Select--</option>
												<option value="active" <?php echo ($status=='active')?'selected="selected"':''; ?> >Active</option>
												<option value="inactive" <?php echo ($status=='inactive')?'selected="selected"':''; ?> >Inactive</option>
											</select>
										</div>										
										<div class="clear"></div>
									</div>
									
									
									
									
								
							
							<input type="hidden" name="news_id" id="news_id" value="<?php echo $news_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
					
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php if($news_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_news')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>news/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>news/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_news')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>news/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>news/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
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
<!-- END PAGE CONTAINER-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/assets/plugins/chosen-bootstrap/chosen/chosen.css" />
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/chosen-bootstrap/chosen/chosen.jquery.js"></script>
	  
<script>

$(document).ready(function(){	
	  $(".chosen").each(function () {
            $(this).chosen({
                allow_single_deselect: $(this).attr("data-with-deselect") == "1" ? true : false
            });
        });
});