<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/bootstrap-fileupload.css" />
<script src="<?php echo base_url().getThemeName();?>/js/jquery-migrate-1.0.0.js"></script>
<script src="<?php echo base_url().getThemeName();?>/js/bootstrap-fileupload.js" type="text/javascript"></script>
<!--<script src="<?php echo front_base_url(); ?>editornew/jmorrigan-jquery-editor.js"></script>-->						
<script type="text/javascript">

$(document).ready(function(){
	

	$("#usualValidate").validate({
		
		rules: {
			advertisement_title:'required',
			status : 'required',
			advertisement_image:{
						  required: function() { return $("#prev_beer_image").val() == '' ? true:false; },
						 accept: "jpg|jpeg|png|bmp"
						},
			size : 'required',
			'allow_pages[]':{
						  required: true,
						},
			position : 'required',
			link : {required:true, url:true,},
			number_click : {required:true, number:true,},
			number_visit : {required:true, number:true,},
				
		},
		
	});
	});
</script>		
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($advertisement_id==""){ echo 'Add Advertisement'; } else { echo 'Edit Advertisement'; }?></h3>					
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
				$attributes = array('id'=>'usualValidate','name'=>'frm_addadvertisement','class'=>'main');
				echo form_open_multipart('advertisement/add_advertisement',$attributes);
			  ?>
			
			  
			  						<div class="control_group">
										<label class="control_label">Advertisement Title:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Advertisement Title...." class="m_wrap wid360" name="advertisement_title" id="advertisement_title" value="<?php echo $advertisement_title; ?>">
										</div>										
										<div class="clear"></div>
									</div>								
	
									<script>
										function open_big()
										{
											$(".allow_pages").val('');
											$("#open_big").fadeIn();
											$("#open_big_pos").fadeIn();
											$("#open_small").fadeOut();
										}
										function open_small()
										{   $(".allow_pages").val('');
											$("#open_small").fadeIn();
											$("#open_big_pos").fadeOut();
											$("#open_big").fadeOut();
										} 
										
										function open_big_t()
										{
											$("#open_big_t").fadeIn();
											$("#open_small_t").fadeOut();
										}
										function open_small_t()
										{
											$("#open_small_t").fadeIn();
											$("#open_big_t").fadeOut();
										}
									</script>
									
									<div class="control_group">
										<label class="control_label">Size: <i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input onclick="open_big()" type="radio" name="size" id="size" value="300x625" <?php if($size=='300x625'){?> checked="checked" <?php } ?> />300x625
											<input onclick="open_small()" type="radio" name="size" id="size" value="309x244" <?php if($size=='309x244'){?> checked="checked" <?php } ?>/>309x244
										</div>
										&nbsp;<label for="size" generated="true" class="error" style="display: none;">This field is required.</label>
										<div class="clear"></div>
									</div>
								<?php if(isset($pages)){
										$allow_pages = explode(",",$pages);	
									} ?>	
									<!-- <div class="control_group" id="open_small" style="display: none;">
										<label class="control_label"> Select Pages : <i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="allow_pages[]" id="allow_pages" multiple="multiple"> 
												<option value="">--Select--</option>
												<option <?php if(isset($allow_pages)){ if(in_array("newsletter",$allow_pages,true)){?>Selected<?php } } ?> value="newsletter" >News Letter</option>
												<option value="dictionary" <?php if(isset($allow_pages)){ if(in_array("dictionary",$allow_pages,true)){?>Selected<?php } } ?> >Dictionary</option>
											</select>
										</div>										
										<div class="clear"></div>
									</div> -->
									
									<div class="control_group" >
										<label class="control_label"> Select Pages : <i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<div id="open_small" style="display: <?php if($size=='309x244'){ echo "block"; } else { echo "none"; }?>">
												<select class="allow_pages m_wrap wid360" name="allow_pages[]" id="allow_pages" multiple="multiple"> 
												<option value="">--Select--</option>
												<!-- <option <?php if(isset($allow_pages)){ if(in_array("newsletter",$allow_pages,true)){?>Selected<?php } } ?> value="newsletter" >News Letter</option> -->
												<option value="dictionary" <?php if(isset($allow_pages)){ if(in_array("dictionary",$allow_pages,true)){?>Selected<?php } } ?> >Dictionary</option>
												<option value="trivia" <?php if(isset($allow_pages)){ if(in_array("trivia",$allow_pages,true)){?>Selected<?php } } ?> >Trivia</option>
											</select>
											</div>
											<div id="open_big" style="display: <?php if($size=='300x625'){ echo "block"; } else { echo "none"; }?>">	
											<select class="allow_pages m_wrap wid360" name="allow_pages[]" id="allow_pages" multiple="multiple"> 
												<option value="">--Select--</option>
												<option <?php if(isset($allow_pages)){ if(in_array("beerlist",$allow_pages,true)){?>Selected<?php } } ?> value="beerlist" >Beer List</option>
												<option value="cocktaillist" <?php if(isset($allow_pages)){ if(in_array("cocktaillist",$allow_pages,true)){?>Selected<?php } } ?> >Cocktail List</option>
												<option value="liquorlist" <?php if(isset($allow_pages)){ if(in_array("liquorlist",$allow_pages,true)){?>Selected<?php } } ?> >Liquor List</option>
												
											</select>
											</div><div class="clear"></div>
										</div>	<div class="clear"></div>
										<label for="allow_pages" generated="true" class="error" style="display: none;">This field is required.</label>									
										<div class="clear"></div>
									</div>
									
									<div class="control_group" id="open_big_pos" style="display: <?php if($size=='300x625'){ echo "block"; } else { echo "none"; }?>;">
										<label class="control_label">Position:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input checked="checked" type="radio" name="position" id="position" value="top" <?php if($position=='top'){?> checked="checked" <?php } ?>/>Top
											<input type="radio" name="position" id="position" value="bottom" <?php if($position=='bottom'){?> checked="checked" <?php } ?>/>Bottom
										</div>
										&nbsp;<label for="position" generated="true" class="error" style="display: none;">This field is required.</label>
										<div class="clear"></div>
									</div>
									
									<?php /*?><div class="control_group">
										<label class="control_label">Banner Image:</label>
										<div class="controls">
											<input type="file" name="advertisement_image" id="advertisement_image" />
										</div>			
										<?php if($pre_advertisement_image!='' && file_exists(base_path().'upload/advertisement_thumb/'.$pre_advertisement_image)){?>
												<img src="<?php echo front_base_url().'upload/advertisement_thumb/'.$pre_advertisement_image ?>"  width="50"  height="50"/>
											<?php } ?>
											<input type="hidden" name="pre_advertisement_image" id="pre_advertisement_image" value="<?php echo $pre_advertisement_image ?>" />							
										<div class="clear"></div>
									</div><?php */?>
									
									<div class="control-group">
											<label class="control-label">Advertisement Image: <i style="color: #7D2A1C;">*</i></label>
											<div class="controls">
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
															<span class="btn btn-file">
															<span class="fileupload-new">Select Image</span>
															<span class="fileupload-exists">Change</span><input  accept="image/*" type="file" class="default" name="advertisement_image" id="advertisement_image" /></span>
															<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>
														<div class="clearfix"></div>
													
													</div>
													<label for="advertisement_image" generated="true" class="error" style="display: none;">This field is required.</label>
												<input type="hidden" name="prev_beer_image" id="prev_beer_image" value="<?php echo $pre_advertisement_image; ?>" />
												</div>
										<div class="controls">		
										<?php if(($pre_advertisement_image!='' && file_exists(base_path().'upload/advertisement_thumb/'.$pre_advertisement_image))){ ?>
											<div class="control-group" style="clear:both">
												<label class="control-label"></label>
												<div class="controls">
													<div class="span2 position-relative">
														<img src="<?php echo front_base_url().'upload/advertisement_thumb/'.$pre_advertisement_image; ?>" width="50"  height="50" />
														<a href="<?php echo base_url(); ?>advertisement/removeimage/<?php echo $advertisement_id.'/'.$pre_advertisement_image.'/'.$limit.'/'.$offset.'/'.$redirect_page.'/'.$option.'/'.$keyword; ?>" id="remove" name="remove"><i class="comon_icon remove_icon"></i></a>
													</div>
												</div>
											</div>
										<?php } ?>
										</div>
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Link : <i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Advertisement Link" class="m_wrap wid360" name="link" id="link" value="<?php echo $link; ?>">
										</div>										
										<div class="clear"></div>
										<label class="help-inline"><b>( Ex. https://google.com )</b></label>
									</div>
									
									
									<div class="control_group">
										<label class="control_label">Select Visit Type : <i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input onclick="open_big_t()" type="radio" name="type" id="type" value="click" <?php if($type=='click'){?> checked="checked" <?php } ?> />By Clicks
											<input onclick="open_small_t()" type="radio" name="type" id="type" value="visit" <?php if($type=='visit'){?> checked="checked" <?php } ?>/>By Visits
										</div>
										&nbsp;<label for="size" generated="true" class="error" style="display: none;">This field is required.</label>
										<div class="clear"></div>
									</div>
									
									<div class="control_group" id="open_big_t" style="display:<?php if($type=='click'){ echo "block"; } else { echo "none"; }?>">
										<label class="control_label">Number of Clicks: <i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Number of Clicks" class="m_wrap wid360" name="number_click" id="number_click" value="<?php echo $number_click; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group" id="open_small_t" style="display:<?php if($type=='visit'){ echo "block"; } else { echo "none"; }?>">
										<label class="control_label">Number of Visits: <i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Number of Visits" class="m_wrap wid360" name="number_visit" id="number_visit" value="<?php echo $number_visit; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									
									
									<?php //if(isset($pages)){
										//$allow_pages = explode(",",$pages);	
									//} 
									?>
									<!-- <div class="control_group">
										<label class="control_label">Pages:</label>
										<div class="controls">
											<input type="checkbox"  name="allow_pages[]" value="myvideo" <?php if(isset($allow_pages)){ if(in_array("myvideo",$allow_pages,true)){?> checked = "checked" <?php }} ?>>Video
											<input type="checkbox"  name="allow_pages[]" value="myarticle" <?php if(isset($allow_pages)){ if(in_array("myarticle",$allow_pages,true)){?> checked = "checked" <?php }} ?>>Article
											<input type="checkbox"  name="allow_pages[]" value="membership_plan" <?php if(isset($allow_pages)){ if(in_array("membership_plan",$allow_pages,true)){?> checked = "checked" <?php }} ?>>Membership Plan
											
										</div>										
										<div class="clear"></div>
									</div> -->
									
									
									
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
								
							</div>	
							<input type="hidden" name="advertisement_id" id="advertisement_id" value="<?php echo $advertisement_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
					
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php if($advertisement_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_advertisement')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>advertisement/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>advertisement/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_advertisement')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>advertisement/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>advertisement/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
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