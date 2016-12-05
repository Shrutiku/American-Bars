<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="<?php echo base_url().getThemeName();?>/js/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<link href="<?php echo base_url().getThemeName();?>/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url().getThemeName();?>/css/blog.css" rel="stylesheet" type="text/css"/>


<script type="text/javascript">
function changestatus(cmnt_id,status)
   { 
   	    var res = $.ajax(
	        {						
			   type: 'POST',
			   url: '<?php echo site_url('liquor/changeliquorstatus/')?>',
			   dataType: 'post', 
			   data : {cmnt_id:cmnt_id,status:status},
			   complete: function(){
				     $.growlUI('Comment status changed successfully .');
				    }
				}).responseText;
   }
	tinyMCE.init({
		mode : "textareas",
		theme : "simple"
	});
	
	$(document).ready(function(){
		
		$("#admincomment").validate({		
		rules: {
			comment_title:'required',
			commnent:'required',		
			},
		
	});
	
	});
	
	
	function conform_delete(cid,cmid)
	{
		var t = confirm("Are you Sure want to remove this comment?");
		
		if(t == true)
		{
			alert("Yes");
			
			document.location.href = '<?php echo site_url("liquor/delete_comment") ?>/'+cid+'/'+cmid;
		}
		
		return false;
		
	}
</script>

<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($liquor_id==""){ echo 'View'; } else { echo 'View'; }?></h3>
					<div class="fl_right">	
								<?php echo anchor('liquor','Back', 'class="btn blue  fl_left mar_r_5" '); ?>
					         </div>
					         <div class="clearfix"></div>
				</div>
		          <div class="row-fluid">
					<div class="span12 blog-page">
						<div class="row-fluid">
							<div class="span9 article-block">
								<h1><?php echo $one_liquor_detail["liquor_title"]; ?></h1>
								<a class="brand" href="index.html">
			<?php if($one_liquor_detail["liquor_image"]!='' && file_exists(base_path().'upload/liquor_thumb/'.$one_liquor_detail["liquor_image"])){?>
												<img src="<?php echo front_base_url().'upload/liquor_thumb/'.$one_liquor_detail["liquor_image"]; ?>" />
											<?php } ?>
				</a>
								
								<!--end news-tag-data-->
								<div>
									<p><?php echo $one_liquor_detail["type"]; ?></p>
								
								</div>
								<hr>
									<h3>Comments</h3>
								<?php
								if($reply)
								{
									foreach($reply as $re)
									{?>
										<div class="media">
								
									<a href="#" class="pull-left">
										<?php
										if($re->profile_image != "" && is_file(base_path()."upload/user_thumb/".$re->profile_image))
										{?>
											<img alt="" src="<?php echo front_base_url()."/upload/user_thumb/".$re->profile_image; ?>" class="media-object">
										<?php }
										else{
										?>
									<img alt="" src="<?php echo front_base_url()."/upload/no_img.png"; ?>" class="media-object">
								  <?php }?>
									</a>
									<div class="media-body">
										<h4 class="media-heading"><?php echo $re->comment_title; ?> <span><?php echo getDuration($re->date_added); ?> / 
											<a href="javascript:void(0);" onclick="return conform_delete('<?php echo $one_liquor_detail["liquor_id"] ?>','<?php echo $re->liquor_comment_id ?>')">Delete</a>
											<input type="radio" id="status_<?php echo $re->liquor_comment_id ?>" name="status_<?php echo $re->liquor_comment_id ?>" onclick="changestatus('<?php echo $re->liquor_comment_id ?>','active')"  value="active" <?php echo $re->status=='active'? 'checked=checked':'';?> />Show
											<input type="radio" id="status_<?php echo $re->liquor_comment_id ?>" name="status_<?php echo $re->liquor_comment_id ?>" onclick="changestatus('<?php echo $re->liquor_comment_id ?>','inactive')" value="inactive"  <?php echo $re->status=='inactive'? 'checked=checked':'';?> />Hide</span></h4>
										<p>
											<?php echo $re->comment; ?>
										 </p>
										<hr>
										
										<?php 
										$sub_comment = $this->liquor_model->get_liquor_subcomment_result($re->liquor_comment_id); 
										if($sub_comment)
										{
										   foreach($sub_comment as $sb)
										   {?>
									<!-- Nested media object -->
										<div class="media">
											<a href="#" class="pull-left">
											<?php
										if($sb->profile_image != "" && is_file(base_path()."upload/user_thumb/".$sb->profile_image))
										{?>
											<img alt="" src="<?php echo front_base_url()."/upload/user_thumb/".$sb->profile_image; ?>" class="media-object">
										<?php }
										else{
										?>
									<img alt="" src="<?php echo front_base_url()."/upload/no_img.png"; ?>" class="media-object">
								  <?php }?>
											</a>
											<div class="media-body">
												<h4 class="media-heading"><?php echo $re->comment_title; ?> <span><?php echo getDuration($re->date_added); ?> / 
											<a href="javascript:void(0);" onclick="return conform_delete('<?php echo $one_cocktail_detail["cocktail_id"] ?>','<?php echo $re->cocktail_comment_id ?>')">Delete</a> fdsfsdf
											</span>
											</span></h4>
												<p>
											<?php echo $sb->comment; ?>
										 </p>
											</div>
										</div>
										<hr>
											<!-- end Nested media object -->
									 <?php }	
										}
										?>
										
										
									</div>
								</div>
							  <?php }
								}
								?>
								
								
								<hr>
								<div class="post-comment">
									<h3>Leave a Comment</h3>
								<?php
									$attributes = array('id'=>'admincomment','name'=>'admincomment','class'=>'main');
									echo form_open_multipart('liquor/view_liquor_comment/'.$liquor_id,$attributes);
								?>	
									<div class="control_group">
										<label class="control_label">Comment Title:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
												<input type="text" placeholder="Comment Title...." class="m_wrap wid360" name="comment_title" id="comment_title" >
											
										</div>										
										<div class="clear"></div>
									</div>
										
										<div class="control_group">
										<label class="control_label">Comment:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<textarea name="comment" id="comment" placeholder="Description..." class="m_wrap span9 wysihtml5" rows="20" cols="100" data-error-container="#editor1_error"></textarea>
											<div id="editor1_error"></div>
										</div>										
										<div class="clear"></div>
									</div>
									<input type="hidden" name="liquor_id" id="liquor_id" value="<?php echo $liquor_id; ?>" />
										<p><button class="btn blue" type="submit">Post a Comment</button></p>
									</form>
								</div>
							</div>
							<!--end span9-->
						
							<!--end span3-->
						</div>
					</div>
				</div>       
			</div>
		</div>
</div>