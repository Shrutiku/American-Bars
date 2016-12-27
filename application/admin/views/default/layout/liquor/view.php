<style>
	.modal {
    background-clip: padding-box;
    background-color: #FFFFFF;
    border: 1px solid rgba(0, 0, 0, 0.3);
    border-radius: 6px;
    box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
    left: 50%;
    margin-left: -280px;
    outline: 0 none;
    position: fixed;
    top: 10%;
    width: 560px;
    z-index: 1050;
}
.modal-header {
    border-bottom: 1px solid #EEEEEE;
    padding: 9px 15px;
}
button.close {
    background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
    border: 0 none;
    cursor: pointer;
    padding: 0;
}
.modal-header h3 {
    line-height: 30px;
    margin: 0;
}
.modal-body {
    max-height: 400px;
    overflow-y: auto;
    padding: 15px;
    position: relative;
}
.modal-backdrop, .modal-backdrop.fade.in {
    background-color: #333333 !important;
}
.modal-backdrop {
    background-color: #000000;
    bottom: 0;
    left: 0;
    position: fixed;
    right: 0;
    top: 0;
    z-index: 1040;
}
.alert-danger, .alert-error {
    background-color: #F2DEDE;
    border-color: #EED3D7;
    color: #B94A48;
    padding: 10px;
}
.modal-footer {
    background-color: #F5F5F5;
    border-radius: 0 0 6px 6px;
    border-top: 1px solid #DDDDDD;
    box-shadow: 0 1px 0 #FFFFFF inset;
    margin-bottom: 0;
    padding: 14px 15px 15px;
    text-align: right;
}
</style>
<?php $theam_url = base_url().getThemeName(); ?>
		<!-- styles needed by jScrollPane - include in your own sites -->

		<link href="<?php echo $theam_url; ?>/assets/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
		
<script src="<?php echo $theam_url; ?>/assets/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript" ></script>

<script src="<?php echo $theam_url; ?>/assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript" ></script><link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
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
	
	function Editliquor(id,liquor_id)
{

	
		var $modal = $('#ajax-modal');
		 $('body').modalmanager('loading');
		 //alert(this.href);
		 var url='<?php echo base_url(); ?>liquor/Editliquorcomment/'+id+'/'+liquor_id+'/';
		// return false;
		
		  setTimeout(function(){
		     $modal.load(url, '', function(){
		      $modal.modal().on("hidden", function() {
              	$modal.empty();
              })
              .one('shown.bs.modal', function(){
              		
              		$('#submitSet').click(function()
              		{
              			//alert('fdsa');
              			$('#noteerror').fadeOut();
              			
              				
              				 $.ajax({
				            type: 'POST',
				            dataType:'Json',
				            url: url,
				            data: $('#setPstat').serialize(),
				            beforeSend : function() {
								blockUI('#setPstat');
							},success: function(data) {
				                if(data.error.length>0){
				                	$('#errorDiv').html(function(){
				                		$(this).html(data.error);
				                		$(this).fadeIn();
				                	});
				                	//$.growlUI(data.msg); 
				                	//$modal.modal('toggle');
				                	//getData(limit,offset);	
				                	
				                	
				                }else{
				                	window.reload();
				                		
				                }
				               // $.growlUI(data.msg); 
				            },complete : function() {
								unblockUI('#setPstat');
								
							},
				        });
              				
              			
              		});
              		
              		
              }).modal();;
		    });
		  }, 1000);
		  return false;
	
	
}
</script>
<div id="ajax-modal" class="modal fade" tabindex="-1" data-width="400" style="display: none;"></div>
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
											<a onclick="Editliquor('<?php echo $re->liquor_comment_id;?>','<?php echo $one_liquor_detail["liquor_id"]?>')" href="javascript://">Edit   </a> / 
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
													<a onclick="Editliquor('<?php echo $re->liquor_comment_id;?>','<?php echo $one_liquor_detail["liquor_id"]?>')" href="javascript://">Edit   </a>  /
											<a href="javascript:void(0);" onclick="return conform_delete('<?php echo $one_liquor_detail["liquor_id"] ?>','<?php echo $re->liquor_comment_id ?>')">Delete</a> fdsfsdf
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