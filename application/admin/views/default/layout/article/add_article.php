<style type="text/css">
	#cke_83_label{display: none !important;}
</style>
<script src="<?php echo base_url().getThemeName(); ?>/js/ui/jquery-ui.js"></script>

<link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/js/ui/jquery-ui.css" />
<script type="text/javascript" src="<?php echo base_url()?>/ckeditor/ckeditor.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	$('#cke_83_label').hide();		
  
 


	$("#usualValidate").validate({
		
		rules: {
			article_title:'required',
			article_desc:'required',
			article_category_id:'required',
			article_price:'required',
			article_type:'required',
			pre_file_up_article:'required',
			status : 'required'
			
			
		},
		
	});
	});
</script>		
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($article_id==""){ echo 'Add Article'; } else { echo 'Edit Article'; }?></h3>
					
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
				$attributes = array('id'=>'usualValidate','name'=>'frm_addarticle','class'=>'main');
				echo form_open_multipart('article/add_article',$attributes);
			  ?>
			
			  
			  						<div class="control_group">
										<label class="control_label">Article Title:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Article Title...." class="m_wrap wid360" name="article_title" id="article_title" value="<?php echo htmlentities($article_title); ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Article Description :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<textarea name="article_desc"  id="article_desc" placeholder="Article Description..." class="m_wrap wid360 "><?php echo $article_desc; ?></textarea> 
										
										
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Category:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="article_category_id" id="article_category_id"> 
												<option value="">--Select--</option>
												<?php if($category){
													foreach ($category as $cat) {
												?>
													<option value="<?php echo $cat->category_id; ?>" <?php echo ($cat->category_id==$article_category_id)?'selected="selected"':''; ?> ><?php echo $cat->category_name; ?></option>
												<?php		
													}
												} ?>
												
											</select>
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">Article Price :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Article Price...." class="m_wrap wid360" name="article_price" id="article_price" autocomplete="off" value="<?php echo $article_price; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Article Type:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="article_type" id="article_type"> 
												<option value="">--Select--</option>
												<option value="free" <?php echo ($article_type=='free')?'selected="selected"':''; ?> >Free</option>
												<option value="paid" <?php echo ($article_type=='paid')?'selected="selected"':''; ?> >Paid</option>
												<!--<option value="membership_plan" <?php echo ($article_type=='membership_plan')?'selected="selected"':''; ?> > Membership Plan</option>-->
											</select>
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">Article Image :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls wid400">
											<input type="file" name="file_up" id="file_up" />
											<input type="hidden" name="pre_article_image" id="pre_article_image" value="<?php echo $image ?>" />
										</div>
										<div class="controls wid400">
											<?php if($image!='' && file_exists(base_path().'upload/article_image/'.$image)){?>
												<img src="<?php echo front_base_url().'upload/article_image/'.$image ?>"  width="50"  height="50"/>
											<?php } ?>
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">Article :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls wid400">
											<input type="file" name="file_up_article" id="file_up_article" />
											<input type="hidden" name="pre_file_up_article" id="pre_file_up_article" value="<?php echo $article_file_name ?>" />
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
								
							</div>	
							<input type="hidden" name="article_id" id="article_id" value="<?php echo $article_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
					
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php if($article_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_article')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>article/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>article/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_article')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>article/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>article/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
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