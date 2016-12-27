<!-- <form id="uploadconversation" method="post" action="" enctype="multipart/form-data">  
  <input style="text-align: center;margin-left:8%; " type="file" id="uploadfile" name="uploadfile"/> 
<input style="border-radius: 5px;" type="submit" value="Load file" />           
 </form> --> 
<script type="text/javascript">
var url='<?php echo base_url(); ?>liquor/Editliquorcomment/<?php echo $liquor_comment_id;?>/';
var url1='<?php echo base_url(); ?>liquor/view_liquor_comment/<?php echo $liquor_id;?>';
$(document).ready(function (e){
$("#uploadconversation").on('submit',(function(e){
e.preventDefault();
$.ajax({
url: url,
type: "POST",
dataType:'JSON',
data:  new FormData(this),
contentType: false,
cache: false,
processData:false,
success: function(data){
				            	
				                if(data.error.length>0){
				                	$('#errorDiv').html(function(){
				                		$(this).html(data.error);
				                		$(this).fadeIn();
				                	});
				                	//$.growlUI(data.msg); 
				                	//$modal.modal('toggle');
				                	//getData(limit,offset);	
				                	
				                	
				                }else{
				                  window.location.href= url1+'/success';
				                		
				                }
				               // $.growlUI(data.msg); 
},
error: function(){} 	        
});
}));
});
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/bootstrap-fileupload.css" />
<script src="<?php echo base_url().getThemeName();?>/js/bootstrap-fileupload.js" type="text/javascript"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h3>Edit Commment</h3>
</div>
<form id="uploadconversation" method="post" action="" enctype="multipart/form-data">  
<div class="modal-body">
<div class="row-fluid">
		<div class="alert alert-error" id="errorDiv" style="display: none;"></div>
	<div class="control_group">
										<label class="control_label">Title:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" id="comment_title" name="comment_title" value="<?php echo $comment->comment_title;?>" class="m_wrap wid360" >
										</div>										
										<div class="clear"></div>
									</div>
									
									
									<div class="control_group">
										<label class="control_label">Description:</label>
										<div class="controls">
											<textarea  id="comment" name="comment" class="m_wrap wid360"><?php echo $comment->comment;?></textarea>
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Video Link:</label>
										<div class="controls">
											<input type="text" id="comment_video" name="comment_video" value="<?php echo $comment->comment_video;?>" class="m_wrap wid360" >
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
											<label class="control_label">Image</label>
											<div class="controls">
												<div class="fileupload fileupload-new"  data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
															<span class="btn btn-file">
															<span class="fileupload-new">Select Image</span>
															<span class="fileupload-exists">Change</span><input type="file" accept="image/*" class="default" name="comment_image" id="comment_image" /></span>
															<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>
														<span for="profile_image" class="help-inline" style="display: none">This field is required.</span>
													</div>
												<input type="hidden" name="pre_profile_image" id="pre_profile_image" value="<?php echo $comment->comment_image; ?>" />
												</div>
											<!-- </div>  -->
										<?php if(($comment->comment_image!='' && file_exists(base_path().'upload/comment_image/'.$comment->comment_image))){ ?>
											<!-- <br /><br />
											<div class="control-group">
												<label class="control-label"></label> -->
												<div class="controls">
													<div class="span2 position-relative">
														<img src="<?php echo front_base_url().'upload/comment_image/'.$comment->comment_image ?>" width="50"  height="50" />
													</div>
												</div>
											<!-- </div> -->
										<?php } ?>
										<div class="clear"></div>
										</div>
		
</div>
</div>
<div class="modal-footer">
	<button type="button" data-dismiss="modal" class="btn">Close</button>
	<input type="hidden" id="business_id" name="business_id" value="<?php echo @$bar_id ?>" />
	<button type="submit" class="btn blue" id="submitSet"><i class="icon-ok"></i> Submit</button>
	
</div>
</form>


