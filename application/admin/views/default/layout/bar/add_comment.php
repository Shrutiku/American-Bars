<script src="<?php echo base_url().getThemeName();?>/js/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo front_base_url().getThemeName(); ?>/js/rating.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo front_base_url().getThemeName(); ?>/js/rating.css" />
<script type="text/javascript">
$(document).ready(function(){
	
	
	tinyMCE.init({
		mode : "textareas",
		theme : "simple"
	});
	/// end of editor code///////
	
	$("#frm_addbar").validate({
		
		rules: {
			comment_title:'required',
			coomment : 'required'
			// status : 'required'
			
		},
		
	});
	
	});
</script>		
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($bar_id==""){ echo 'Add Review'; } else { echo 'Edit Review'; }?></h3>
					
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
				$attributes = array('id'=>'frm_addbar','name'=>'frm_addbar','class'=>'main');
				echo form_open_multipart('bar/edit_comment/'.$bartype,$attributes);
			  ?>
		                	
			                    <div class="control_group">
										<label class="control_label">Review Title:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Owner Name...." class="m_wrap wid360" name="comment_title" id="comment_title" value="<?php echo $comment_title; ?>">
										</div>										
										<div class="clear"></div>
									</div>
			             
									
									 <div class="control_group">
					                 <label class="control_label">Review:<span class="req">*</span></label>
                                      <div class="controls"> 
                                       <textarea id="bar_desc" cols="10" rows="4" name="comment" class="wid360 wysihtml5 m_wrap required"><?php echo $comment; ?></textarea>
                                  </div>
							     <div class="clear"></div>
                             </div>
                             
                             <div class="control_group">
					                 <label class="control_label">Rating:<span class="req">*</span></label>
                                      <div class="controls"> 
                                        <div id="star1" class="rating">&nbsp;<input type="hidden" name="rating" id="rating" value="<?php echo $rating; ?>" /></div>
                                  </div>
							     <div class="clear"></div>
                             </div>
                             
                               
									
									<!-- <div class="control_group">
										<label class="control_label">Status:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="status" id="status"> 
												<option value="">--Select--</option>
												<option value="active" <?php echo ($status=='active')?'selected="selected"':''; ?> >Active</option>
												<option value="inactive" <?php echo ($status=='inactive')?'selected="selected"':''; ?> >Inactive</option>
											</select>
										</div>										
										<div class="clear"></div>
									</div> -->
								
							</div>	
							<input type="hidden" name="bar_comment_id" id="bar_comment_id" value="<?php echo $bar_comment_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						<input type="hidden" name="bar_id" id="bar_id" value="<?php echo $bar_id; ?>" />
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
					
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php if($bar_comment_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'comment')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>bar/<?php echo $redirect_page.'/'.$bartype.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>bar/<?php echo $redirect_page.'/'.$bartype.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'comment')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>bar/<?php echo $redirect_page.'/'.$bartype.'/'.$bar_id.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>bar/<?php echo $redirect_page.'/'.$bartype.'/'.$bar_id.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
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

<script>
	 $(document).ready(function () 
	 {
		$('#star1').rating('www.url.php', {maxvalue:5,<?php if($rating>0) {?>curvalue:<?php echo $rating; }?>});
		$(".cancel").hide();
	 });
</script>