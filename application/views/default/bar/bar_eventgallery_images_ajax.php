
<script>
	$('#add_row').click(function(){
	
		var cnt=parseInt($('#cntpro').val())+1;
		if($('#cntpro').val() =='NaN')
		{
		    $('#cntpro').val('1');
		    cnt = 1;
		}
		$('#cntpro').val(cnt)
		$('#inner').append('<div class="padtb" id="img_'+cnt+'" style="display:none;"><div class="col-sm-3 text-right"><label class="control-label"></label></div><div class="input_box upload_btn" data-provides="fileupload"><div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div><div class="input_box upload_btn"><span class="fileupload-exists"></div><input type="file" class="form-control form-pad" name="photo_image[]" id="photo_image_'+cnt+'" /></span></div><a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDive(\''+cnt+'\')"><span class="glyphicon glyphicon-minus"></span></a></div></div><div class="clear"></div>');
		$('#img_'+cnt).slideDown();
			
		});
</script>
<?php 
												if($imageGallery!=''){
													
													$i=0;?>
													<input type="hidden" name="image_count" id="image_count" value="<?php echo count($imageGallery);?>" />
												<div class="" id="inner">
													<?php foreach($imageGallery as $im){
														
													//if($im->image_name!='' && file_exists(base_path().'/upload/Product/'.$im->image_name)){	
													?>
													
												<div class="padtb" id="pi_<?php echo $im->event_image_id ?>">
													<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Event Image <?php echo $i+1;?></label>
	        				 	</div>
											<div class="input_box upload_btn" data-provides="fileupload">
														<input type="file" accept="image/*" class="form-control form-pad" value="<?php echo $im->event_image_name; ?>" id="photo_image" name="photo_image[]">
															</div>
															
												<input type="hidden" name="pre_img[]" value="<?php echo $im->event_image_name ?>" />
												<input type="hidden" name="image_id[]" value="<?php echo $im->event_image_id ?>" />
												
												
												<?php if($i==0){ ?>
												<a href="javascript://"  id="add_row" name="add_row" class="btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
												<?php }else{ ?>
												<a href="javascript://"  class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDiveAjax('<?php echo $im->event_image_id ?>')"><span class="glyphicon glyphicon-minus"></span></a>
												<?php } ?>
												<div class="input_box upload_user">
	                           								<img class="img-responsive" src="<?php echo base_url().'upload/bar_eventgallery_thumb/'.$im->event_image_name ?>" />
	                       						</div>
											</div><div class="clear"></div>
											
											
												
												<?php $i++;  /*}*/ } ?>
												</div>
												<input type="hidden" name="cntpro" id="cntpro" value="<?php echo $i; ?>" />
												<?php  } else {  ?>
													
													<div id="inner">  	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Event Image : <span class="aestrick"> * </span></label>
	        				 	</div>
	        					        				 	
	                       		<div class="input_box upload_btn">
	                           		<input type="file" class="form-control form-pad" id="photo_image" name="photo_image[]">
	                           		<input type="hidden" name="prev_event_image" id="prev_event_image" value="" />
	                           		<input type="hidden" name="image_count" id="image_count" value="0" />
														<input type="hidden" name="cntpro" id="cntpro" value="0" />
														<input type="hidden" name="prev_photo_image" id="prev_photo_image" value="" />	
														
	                       		</div>
	                       		
	                       		<!-- <div class="input_box upload_user">
	                           		<img src="" id="img_here" alt="" class="img-responsive"/>
	                       		</div> -->
	                       			<a href="javascript://" id="add_row" name="add_row" class="btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
	                       		<!-- <div class="input_box pull-left">
	                           		<button type="submit" class="btn btn-lg btn-primary " href="#">Upload</button> 
	                       		</div> -->
	                       		<div class="clearfix"></div>
	                       		</div>
	                       	</div>
													<?php }           ?>
													
