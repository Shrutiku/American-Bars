

<link rel="stylesheet" type="text/css" href="<?php echo front_base_url(); ?>/default/new-timepicker.css" />
				<link href="<?php echo base_url().getThemeName(); ?>/assets/plugins/bootstrap-timepicker/compiled/timepicker.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script><script>



function getbardata(id)
{
	 $.ajax({
			         type: "POST",
			         url: "<?php echo site_url('bar/getbadetail')?>",
			         dataType:'Json',
			         data : {id:id},
			       
			         success: function(response) {
			           	 $("#address").val(response.address);
			           	 $("#city").val(response.city);
			           	 $("#state").val(response.state);
			           	 $("#zipcode").val(response.zipcode);
			           	 $("#phone").val(response.phone);
			        }
			    });
}
$(document).ready(function(){	

	
	$(".chosen").each(function () 
		   	{
	            $(this).chosen({
	                allow_single_deselect: $(this).attr("data-with-deselect") == "1" ? true : false
	            });
        	});
$("#usualValidate").validate({
		
		rules: {
			event_title:'required',
			event_desc:'required',
			start_date:'required',
			end_date: { greaterThan: "#start_date" },
			address:'required',
			city:'required',
			state:'required',
			event_image: {
				  extension: "jpg|jpeg|gif|png"
			},
			event_video: {
				  extension: "mp4|flv|mov|wmv|mpeg|mpg"				
			},
			status : 'required',
			phone:{required : true, digits : true},			
			
			zipcode: {
				required: true,
				digits: true
			}			
		},
		
		 submitHandler: function (form) {
		 	$('#submit').attr('disabled','disabled') ;
		 	$('#submit').val('Processing...') ;
    usualValidate.submit();
		 }		
		
	});
	
	
	jQuery.validator.addMethod("greaterThan", 
		function(value, element, params) {
		
		    if (!/Invalid|NaN/.test(new Date(value))) {
		        return new Date(value) > new Date($(params).val());
		    }
		
		    return isNaN(value) && isNaN($(params).val()) 
		        || (Number(value) > Number($(params).val())); 
		},'Must be greater than start date.');

	
});	
	


</script>

<div class="page_content">
			<div class="container_fluid">
				<div class="input-append bootstrap-timepicker-component">
												<input type="text" class="m-wrap m-ctrl-small timepicker-default">
												<span class="add-on"><i class="icon-time"></i></span>
											</div>
				<div class="row_fluid"> 
					<h3 class="page_title">Add Bar Happy Hours</h3>
					
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
				$attributes = array('id'=>'usualValidate','name'=>'frm_addevent','class'=>'main');
				echo form_open_multipart('happy_hours/add_happy_hours/'.$bars_id,$attributes);
			  ?>
									
								<div class="control-group">
												<label class="control-label">Event Images <i style="color: #7D2A1C;">*</i></label>
												
												<?php // print_r($imageGallery);die;
												if($getbar_hour!=''){
													
													$i=0;?>
													<input type="hidden" name="image_count" id="image_count" value="<?php echo count($imageGallery);?>" />
												<div class="" id="inner">
													<?php foreach($getbar_hour as $im){
														
													//if($im->image_name!='' && file_exists(base_path().'/upload/Product/'.$im->image_name)){	
													?>
													
												<div class="controls" id="pi_<?php echo $im->bar_hour_id ?>">
													
												
											<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
															<span class="btn btn-file">
															<span class="fileupload-new">Select Image</span>
															<span class="fileupload-exists">Change</span><input accept="image/*" type="file" class="default" name="photo_image[]" id="photo_image" /></span>
															
															<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>
													</div>
											   </div>
											 <div class="controls">  
											<div class="span1" >
												<input type="hidden" name="pre_img[]" value="<?php echo $im->event_image_name ?>" />
												<input type="hidden" name="image_id[]" value="<?php echo $im->event_image_id ?>" />
												<img src="<?php echo front_base_url().'upload/bar_eventgallery_thumb/'.$im->event_image_name ?>" />
											</div>
											<div class="span2">
												<?php if($i==0){ ?>
												<a href="javascript:void(0);" id="add_row" name="add_row" class="btn blue table_icon margin-left-10 margin-top-10"><i class="comon_icon addmore_icon"></i></a>
												<?php }else{ ?>
												<a href="javascript://" style="margin-left: 10px;" class="table_icon btn red margin-top-10" onclick="removeImageDiveAjax('<?php echo $im->event_image_id ?>')"><i class="comon_icon delete_icon"></i></a>
												<?php } ?>
												
											</div>
											</div><div class="clear"></div>
											
											
												
												<?php $i++;  /*}*/ } ?>
												</div>
												<input type="hidden" name="cntpro" id="cntpro" value="<?php echo $i; ?>" />
												<span class="controls" style="display: none;color: #B94A48;" class="help-inline" id="cantADD">You can upload maximim 7 images.</span>
												<?php  }else{ ?>
													<input type="hidden" name="image_count" id="image_count" value="0" />
														<input type="hidden" name="cntpro" id="cntpro" value="0" />	
												<div class="controls" id="main">
												<div class="control-group">
											<div id="inner">
												
												<div class="control_group">
										<label class="control_label">Days: <i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<select id="days" name="days[]" class="m_wrap wid360"> 
												<option value="">-- Select Day-- </option>
	                       				<option value="Monday">Monday</option>
	                       				<option value="Tuesday">Tuesday</option>
	                       				<option value="Wednesday">Wednesday</option>
	                       				<option value="Thursday">Thursday</option>
	                       				<option value="Friday">Friday</option>
	                       				<option value="Saturday">Saturday</option>
	                       				<option value="Sunday">Sunday</option>
											</select>
										</div>										
										<div class="controls">
												 <div class="span1">
											<a href="javascript:void(0);"  id="add_row" name="add_row" class="btn blue table_icon margin-left-10 margin-top-10"><i class="comon_icon addmore_icon"></i></a>
											    </div>
											</div>
									</div>	
											<div class="clear"></div>
										
										
										<div class="control_group">
										<label class="control_label">Slect Hours: <i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
												<input maxlength="100" type="text" placeholder="Add From Time.." class="timepicker-default m_wrap wid100" name="hour_from[]" id="hour_from" value="">
										</div>										
										<div class="controls" style="float:right; margin-right: 35px;">
												 <div class="span1">
											<input maxlength="100" type="text" placeholder="Add To Time.." class="timepicker-default m_wrap wid100" name="hour_to[]" id="hour_to" value="">
											    </div>
											</div>
									</div>		
											
											<div class="control_group">
										<label class="control_label">Price:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="price...." class="m_wrap wid360" name="price[]" id="price" value="">
											<div id="editor1_error"></div>
										</div>										
										<div class="clear"></div>
							  </div>
							  
							  <div class="control_group">
										<label class="control_label">Speciality:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="speciality...." class="m_wrap wid360" name="speciality[]" id="speciality" value="">
											<div id="editor1_error"></div>
										</div>										
										<div class="clear"></div>
							  </div>
									</div>	
									<div class="clear"></div>
									</div>
											
												</div>
										<?php } ?>
									</div>
									
									<div class="clear"></div>
									

						 
							<div class="form_action">
								
						
						<input  id="submit" type="submit" name="submit" value="Add" class="btn green fl_left mar_r_5" />
						
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>/bar/list_bar/full_mug'" />
					
					
					
					</form>		
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
</div>

<script>
	jQuery(document).ready(function() {       
		  // FormComponents.init();
		       $('.timepicker-default').timepicker({

               // defaultTime : false

            });
		});
		
	$('#add_row').click(function(){
	  //if(parseInt($('#cntpro').val())<7){
		//	$('#cantADD').hide();
		var cnt=parseInt($('#cntpro').val())+1;
		if($('#cntpro').val() =='NaN')
		{
		    $('#cntpro').val('1');
		    cnt = 1;
		}
		$('#cntpro').val(cnt)
		$('#inner').append('<div class="row-fluid  margin-top-10" id="img_'+cnt+'" style="display:none;"><div class="control_group"><label class="control_label">Days: <i style="color: #7D2A1C;">*</i></label><div class="controls"><select id="days'+cnt+'" name="days[]" class="m_wrap wid360"><option value="">-- Select Day-- </option><option value="Monday">Monday</option><option value="Tuesday">Tuesday</option><option value="Wednesday">Wednesday</option><option value="Thursday">Thursday</option><option value="Friday">Friday</option><option value="Saturday">Saturday</option><option value="Sunday">Sunday</option></select></div><a href="javascript://" class="table_icon btn red margin-top-10 margin-left-10" onclick="removeImageDive(\''+cnt+'\')"><i class="comon_icon delete_icon"></i></a></div><div class="clear"></div><div class="control_group"><label class="control_label">Slect Hours: <i style="color: #7D2A1C;">*</i></label><div class="controls"><input maxlength="100" type="text" placeholder="Event Title...." class="m_wrap wid100" name="hour_from[]" id="hour_from'+cnt+'" value=""></div><div class="controls" style="float:right; margin-right: 35px;"><div class="span1"><input maxlength="100" type="text" placeholder="Event Title...." class="m_wrap wid100" name="hour_to[]" id="hour_to'+cnt+'" value=""></div></div></div><div class="control_group"><label class="control_label">Price:<i style="color: #7D2A1C;">*</i></label><div class="controls"><input type="text" placeholder="price...." class="m_wrap wid360" name="price[]" id="price'+cnt+'" value=""><div id="editor1_error"></div></div><div class="clear"></div></div><div class="control_group"><label class="control_label">Speciality:<i style="color: #7D2A1C;">*</i></label><div class="controls"><input type="text" placeholder="speciality...." class="m_wrap wid360" name="speciality[]" id="speciality'+cnt+'" value=""><div id="editor1_error"></div></div><div class="clear"></div></div></div><div class="clear"></div>');
		$('#img_'+cnt).slideDown();
		//}else{
		//$('#cantADD').show();	
		//}
			
		});
function removeImageDive(id)
	{
	   // alert("removeImageDive");    
	   // alert(id);
		var cnt=parseInt($('#cntpro').val())-1;
	(parseInt(cnt)<7)?$('#cantADD').hide():'';
		$('#cntpro').val(cnt);
		$('#img_'+id).slideUp('normal',function(){	$(this).remove(); });
	}
function removeImageDiveAjax(id)
{
     //   alert("removeImageDiveAjax");
      //  alert(id);
	var r=confirm('Are you sure ,you want to delete this image ?');
	if(r==true)
	{
		$.ajax({
			url:'<?php echo site_url('event/removeImageAjax') ?>/'+id,
			success:function(res){
			var cnt=parseInt($('#cnt').val())-1;
           // alert(cnt);
			$('#cntpro').val(cnt);
			$('#pi_'+id).slideUp('normal',function(){	$(this).remove(); });	 
			}
		});	
	}else{
		return false;
	}
	
}	
</script>



