<style>
	.dropdown-menu {
    background-clip: padding-box;
    background-color: #fff;
    border: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 4px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.176);
    display: none;
    float: left;
    left: 0;
    list-style: outside none none;
    margin: 2px 0 0;
    min-width: 160px;
    padding: 5px 0;
    position: absolute;
    top: 100%;
    z-index: 1000;
}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/assets/plugins/select2/select2_metro.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/bootstrap-fileupload.css" />
<script src="<?php echo base_url().getThemeName();?>/js/jquery-migrate-1.0.0.js"></script>
<script src="<?php echo base_url().getThemeName();?>/js/bootstrap-fileupload.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/assets/plugins/font-awesome/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/assets/plugins/bootstrap-datepicker/css/datepicker.css" />
<script src="<?php echo base_url().getThemeName();?>/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/new-timepicker.css" />
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js" ></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/new-bootstrap-timepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/assets/plugins/select2/select2.min.js"></script>
<script>
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
	 $('#event_category').select2({
            placeholder: "Select Category",
            allowClear: true
        });
	   $("#phone").inputmask("(999) 999-9999");
	 var date = new Date();
<?php if($event_id==""){	?>
	getbardata(<?php echo $bars_id;?>);
	<?php } ?>
	$(".chosen").each(function () 
		   	{
	            $(this).chosen({
	                allow_single_deselect: $(this).attr("data-with-deselect") == "1" ? true : false
	            });
        	});
$('#start_date').datepicker({
			        format : 'yyyy/mm/dd',
			        startDate: date
			//mask:'9999/19/39 29:59'
		});
		$('#end_date').datepicker({
			 format : 'yyyy/mm/dd',
			 startDate: date
			//mask:'9999/19/39 29:59'
		});
		
		 $('.timepicker-default').timepicker({
        maxMinutes: 15,
               // defaultTime : false

            });
$("#usualValidate").validate({
		
		rules: {
			'eventdate[]' : 'required',
			'eventstarttime[]' : 'required',
			'eventendtime[]' : 'required',
			event_title:'required',
			event_desc:'required',
			start_date:'required',
			event_video_link: {
				 url:true,
			},
			website: {
				 url:true,
			},
			// event_fb_link: {
				 // url:true,
			// },
			// event_twitter_link: {
				 // url:true,
			// },
			// event_google_plus_link: {
				 // url:true,
			// },
			// event_pinterest_link: {
				 // url:true,
			// },
			buy_ticket: {
				 url:true,
			},
			//end_date: { greaterThan: "#start_date" },
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
			//phone:{required : true},			
			
			zipcode: {
				required: true,
				digits: true
			},
			admission: {
				number: true,
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
		        return new Date(value) >= new Date($(params).val());
		    }
		
		    return isNaN(value) && isNaN($(params).val()) 
		        || (Number(value) >= Number($(params).val())); 
		},'Must be greater than start date.');

	
});	
	


</script>
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($event_id==""){ echo 'Add Event'; } else { echo 'Edit Event'; }?></h3>
					
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
						<?php
				$attributes = array('id'=>'usualValidate','name'=>'frm_addevent','class'=>'main');
				echo form_open_multipart('event/add_event/'.$bars_id,$attributes);
			  ?>
						<div class="portlet-body form">
							<div class="content">
								
			  <input type="hidden" name="event_id" id="event_id" value="<?php echo $event_id; ?>" />
						 <!-- <input type="hidden" name="bars_id" id="bars_id" value="<?php echo $bars_id; ?>" /> -->
						 
				 	     <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
				 	     <input type="hidden" name="date" id="date" value="<?php echo $date; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						 <input type="hidden" name="bar_id" id="bar_id" value="<?php echo $bar_id; ?>" />
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
					
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
			                
			                      	<select data-placeholder="Select Bar" name="bars_id" id="bars_id" class="m_wrap wid360" onchange="getbardata(this.value);">
			                      		<option value="0">AB Event</option>
			                      		<?php if($bars_id!=0 && $bars_id!='' && is_numeric($bars_id)){?>
												<?php if($getallbar)
												      { foreach($getallbar as $rows)
														  {
														  	?>
														     <option value="<?php echo $rows->bar_id; ?>" <?php if($bars_id==$rows->bar_id){ echo "selected"; }?>><?php echo $rows->bar_title; ?></option>
														       	
														  <?php } 
												      }?>
											
										<?php } ?>	
			                     </select>
			  
			  <?php if($bars_id==0 || $bars_id==''){?>
			  	<div class="control_group">
										<label class="control_label">Event Organizer:</label>
										<div class="controls">
											<input maxlength="100" type="text" placeholder="Organizer Name...." class="m_wrap wid360" name="organizer" id="organizer" value="<?php echo $organizer; ?>">
										</div>										
										<div class="clear"></div>
									</div>
			  	
			  	<?php } ?>
			  	
			  	<div class="control_group">
										<label class="control_label">Venue:</label>
										<div class="controls">
											<input  type="text" placeholder="Venue...." class="m_wrap wid360" name="venue" id="venue" value="<?php echo $venue; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
			  						<div class="control_group">
										<label class="control_label">Event Title:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input maxlength="100" type="text" placeholder="Event Title...." class="m_wrap wid360" name="event_title" id="event_title" value="<?php echo $event_title; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control-group">
										<?php //print_r($bar_category); ?>
															<label class="control-label">Event Category :</label>
															<div class="controls">
																<select id="event_category" name="event_category[]" class="m_wrap wid360 span12 select2" multiple>
																	
																	<?php 
																	
																	if($get_cat)
																	       {
																	       	  foreach($get_cat as $row)
																			  {  
																			  	if(!empty($event_category))
																				{ ?>
																				<option <?php echo in_array($row->event_category_id, $event_category) ? 'selected':''; ?> value="<?php echo $row->event_category_id; ?>"><?php echo $row->event_category_name; ?></option>	
																			<?php	}
																				else { 																			  	?>
																			  	 <option value="<?php echo $row->event_category_id; ?>"><?php echo $row->event_category_name; ?></option>
																			  	 
																			  	<?php } ?>  
																			<?php  }
																	       }
																	       ?>	
																</select>
															</div><div class="clear"></div>
														</div>
									<div class="control_group">
										<label class="control_label">Description:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<textarea name="event_desc" id="event_desc" placeholder="Description..." class="m_wrap span9 wid360" rows="20" cols="100" data-error-container="#editor1_error"><?php  echo $event_desc ;?></textarea>
											<div id="editor1_error"></div>
										</div>										
										<div class="clear"></div>
							  </div>
							  
							
									
									<div class="control_group">
										<label class="control_label">Address:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Address...." class="m_wrap wid360" name="address" id="address" value="<?php echo $address; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									
									
									<div class="control_group">
										<label class="control_label">City:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="City...." class="m_wrap wid360" name="city" id="city" value="<?php echo $city; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									
									<div class="control_group">
										<label class="control_label">State:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="State...." class="m_wrap wid360" name="state" id="state" value="<?php echo $state; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Zipcode:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Zipcode...." class="m_wrap wid360" name="zipcode" id="zipcode" value="<?php echo $zipcode; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
										<div class="control_group">
										<label class="control_label">Phone Number:</label>
										<div class="controls">
											<input type="text" placeholder="Phone Number...." class="m_wrap wid360" name="phone" id="phone" value="<?php echo $phone; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group" id="upload_video_type" >
													<label class="control_label">Upload Type : </label>
													<div class="controls">
														<label class="radio">
															<input type="radio" name="event_upload_type"   id="image" value="image" <?php echo $event_upload_type=='image'?'checked="checked"':''; ?> />Image 
														</label>
														<label class="radio">
															<input type="radio" name="event_upload_type" id="video" value="video" <?php echo $event_upload_type=='video'?'checked="checked"':''; ?> />Video
														</label>
													</div>
													<div class="clear"></div>
													<label style="display: none;" for="event_upload_type" generated="true" class="error">This field is required.</label>
								   </div>
								   
								<div class="control-group" style="display: <?php if($event_upload_type=='image'){?>block<?php } else {?>none<?php } ?>;" id="see_image">
												<label class="control-label">Event Images : </label>
												
												<?php // print_r($imageGallery);die;
												if($imageGallery!=''){
													
													$i=0;?>
													<input type="hidden" name="image_count" id="image_count" value="<?php echo count($imageGallery);?>" />
												<div class="" id="inner">
													<?php foreach($imageGallery as $im){
														
													//if($im->image_name!='' && file_exists(base_path().'/upload/Product/'.$im->image_name)){	
													?>
													
												<div class="controls" id="pi_<?php echo $im->event_image_id ?>">
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
											<div class="controls">
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
															<span class="btn btn-file">
															<span class="fileupload-new">Select Image</span>
															<span class="fileupload-exists">Change</span><input  accept="image/*" type="file" class="default" name="photo_image[]" id="photo_image" /></span>
															
															<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>
														
														<span for="profile_image" class="help-inline" style="display: none">This field is required.</span>
													</div>
												<input type="hidden" name="prev_photo_image" id="prev_photo_image" value="<?php echo @$prev_photo_image; ?>" />
												<div class="clear"></div>
											</div>
											<div class="controls">
												 <div class="span1">
											<a href="javascript:void(0);"  id="add_row" name="add_row" class="btn blue table_icon margin-left-10 margin-top-10"><i class="comon_icon addmore_icon"></i></a>
											    </div>
											</div>
											<div class="clear"></div>
											
											
									</div>	
									<div class="clear"></div>
									</div>
											
												</div>
										<?php } ?>
									</div>
									
									<div class="clear"></div>
									
									<div class="control_group" style="display: <?php if($event_upload_type=='video'){?>block<?php } else {?>none<?php } ?>;" id="see_video">
										<label class="control_label">Video Link:</label>
										<div class="controls">
											<input type="text" placeholder="Video Link...." class="m_wrap wid360" name="event_video_link" id="event_video_link" value="<?php echo $event_video_link; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
										<div class="clear"></div>

									
									<div class="clear"></div>		
									
									<div class="control_group">
										<label class="control_label">Admission: </label>
										<div class="controls">
<input type="text" placeholder="Admission Fees...." class="m_wrap wid360" name="admission" id="admission" value="<?php echo $admission; ?>">										</div>										
										<div class="clear"></div>
							  </div>
							  
							  <div class="control_group">
										<label class="control_label">Buy Tickets: </label>
										<div class="controls">
								<input type="text" placeholder="Buy Ticket...." class="m_wrap wid360" name="buy_ticket" id="buy_ticket" value="<?php echo $buy_ticket; ?>">										</div>										
										<div class="clear"></div>
							  </div>
							  
							  <div class="control_group">
										<label class="control_label">Website: </label>
										<div class="controls">
<input type="text" placeholder="Website Url...." class="m_wrap wid360" name="website" id="website" value="<?php echo $website; ?>">										</div>										
										<div class="clear"></div>
							  </div>
							  
								
									
									<div class="control_group">
										<label class="control_label">Meta Title: </label>
										<div class="controls">
											<input type="text" placeholder="Meta Title" class="m_wrap wid360" name="event_meta_title" id="event_meta_title" value="<?php echo $event_meta_title; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Meta Keyword: </label>
										<div class="controls">
											<input type="text" placeholder="Meta Keyword" class="m_wrap wid360" name="event_meta_keyword" id="event_meta_keyword" value="<?php echo $event_meta_keyword; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Meta Description: </label>
										<div class="controls">
											<textarea id="event_meta_description" cols="10" rows="4" name="event_meta_description" class="wid360 m_wrap"><?php echo $event_meta_description; ?></textarea>
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">Status:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="status" required id="status"> 
												<option value="">--Select--</option>
												<option value="active" <?php echo ($status=='active')?'selected="selected"':''; ?> >Active</option>
												<option value="inactive" <?php echo ($status=='inactive')?'selected="selected"':''; ?> >Inactive</option>
											</select>											
										</div>			
										
										<div class="clear"></div>
									</div>								
								
							  <?php	if($bareventtime!=''){
													
													$i=0;?>
												<div class="" id="inner1">
													<?php foreach($bareventtime as $im){
														
													//if($im->image_name!='' && file_exists(base_path().'/upload/Product/'.$im->image_name)){	
													?>
													
												<div class="padtb8" id="pi1_<?php echo $im->sss_event_time_id ?>">
													
	                       		<div class="control_group">
	                       		<div class="pull-left">
	                       		<label class="control_label">Date :</label>
	                       		<div class="controls">
	                       			<input type="text" class="m_wrap wid125 eventdate" id="eventdate" readonly="readonly" name="eventdate[]" value="<?php echo $im->eventdate; ?>">
	                       		</div>
	                       		</div>
	                       		<div class="pull-left marL10">
	        				 		<label class="control_label">Start Time :</label>
	                       		<div class="controls">	
	                       			<input type="text" class="m_wrap wid125  timepicker-default" id="eventstarttime" readonly="readonly" name="eventstarttime[]" value="<?php echo $im->eventstarttime; ?>">
	                       		</div>	
	                       		</div>
	                       		<div class="pull-left marL10">
	        				 		<label class="control_label">End Time :</label>
	                       		<div class="controls">	
	                       			<input type="text" class="m_wrap wid125  timepicker-default" id="eventendtime" readonly="readonly" name="eventendtime[]" value="<?php echo $im->eventendtime; ?>">
	                       		</div>	
	                       		</div>
	                       		
	                       		
	                       			<div class="clearfix"></div>
	        				 		<!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
	        				 		
	        				 		
	        				 	</div>
															
												<input type="hidden" name="image_id1[]" value="<?php echo $im->sss_event_time_id ?>" />
												
												
												<?php if($i==0){ ?>
													<a href="javascript:void(0);" id="add_row1" name="add_row" class="btn blue table_icon margin-left-10" style="margin-top: 30px;"><i class="comon_icon addmore_icon"></i></a>
												<?php }else{ ?>
												<a href="javascript://" style="margin-left: 10px; margin-top: 30px;" class="table_icon btn red margin-top-10"  onclick="removeImageDiveAjax1('<?php echo $im->sss_event_time_id ?>')"><i class="comon_icon delete_icon"></i></a>
												<?php } ?>
											</div><div class="clear"></div>
											
											
												
												<?php $i++;  /*}*/ } ?>
												</div>
												<input type="hidden" name="cntpro1" id="cntpro1" value="<?php echo $i; ?>" />
												<?php  } else {  ?>
													
													<input type="hidden" name="cntpro1" id="cntpro1" value="0" />
													<div id="inner1">  	
	                       	<div class="control_group">
	                       		<div class="pull-left">
	                       		<label class="control_label">Date :</label>
	                       		<div class="controls">
	                       			<input type="text" class="m_wrap wid125 eventdate" id="eventdate" readonly="readonly" name="eventdate[]" value="">
	                       		</div>
	                       		</div>
	                       		<div class="pull-left marL10">
	        				 		<label class="control_label">Start Time :</label>
	                       		<div class="controls">	
	                       			<input type="text" class="m_wrap wid125  timepicker-default" id="eventstarttime" readonly="readonly" name="eventstarttime[]" value="">
	                       		</div>	
	                       		</div>
	                       		<div class="pull-left marL10">
	        				 		<label class="control_label">End Time :</label>
	                       		<div class="controls">	
	                       			<input type="text" class="m_wrap wid125  timepicker-default" id="eventendtime" readonly="readonly" name="eventendtime[]" value="">
	                       		</div>	
	                       		</div>
	                       		
	                       		<a href="javascript:void(0);" id="add_row1" name="add_row" class="btn blue table_icon margin-left-10" style="margin-top: 30px;"><i class="comon_icon addmore_icon"></i></a>
	                       			<div class="clearfix"></div>
	        				 		<!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
	        				 		
	        				 		
	        				 	</div><div class="clear"></div>
	                       	</div>
													<?php }           ?>
						 
							<div class="form_action">
								
								<?php if($event_id==""){ ?>
					
						<input  id="submit" type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_event')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>event/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>event/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input  id="submit" type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_event')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>event/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>event/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
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
		$('#inner').append('<div class="row-fluid  margin-top-10" id="img_'+cnt+'" style="display:none;"><div class=""><div class="fileupload fileupload-new pull-left" data-provides="fileupload"><div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" class="default"  accept="image/*" name="photo_image[]" id="photo_image_'+cnt+'" /></span><a href="javascript://" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a></div><a href="javascript://" class="table_icon btn red margin-top-10 margin-left-10" onclick="removeImageDive(\''+cnt+'\')"><i class="comon_icon delete_icon"></i></a></div></div></div><div class="clear"></div>');
		$('#img_'+cnt).slideDown();
		//}else{
		//$('#cantADD').show();	
		//}
			
		});
		
		
		$('#add_row1').click(function(){
			var date = new Date();
	  //if(parseInt($('#cntpro').val())<7){
		//	$('#cantADD').hide();
		var cnt=parseInt($('#cntpro1').val())+1;
		if($('#cntpro1').val() =='NaN')
		{
		    $('#cntpro1').val('1');
		    cnt = 1;
		}
		$('#cntpro1').val(cnt);
		
		var html = '';
		html += '<div class="row-fluid  margin-top-10" id="img1_'+cnt+'"><div class="control_group">';
	    html +=  '<div class="pull-left"><label class="control_label">Date :</label>';
	    html +=  '<div class="controls"><input type="text" class="m_wrap wid125 eventdate" id="eventdate_'+cnt+'" readonly="readonly" name="eventdate[]" value="" required="required" ><label for="eventdate[]" generated="true" class="error" style="display: none;">This field is required.</label></div>';
	    html +=   '</div>';
	     html +=  '<div class="pull-left marL10"><label class="control_label">Start Time :</label>';
	   html +=    '<div class="controls"><input type="text" class="m_wrap wid125  timepicker-default" id="eventstarttime_'+cnt+'" readonly="readonly" name="eventstarttime[]" value=""></div>	';
	   html +=    '</div>';
        html +=   '<div class="pull-left marL10"><label class="control_label">End Time :</label><div class="controls">';
	   html +=    '<input type="text" class="m_wrap wid125  timepicker-default" id="eventendtime_'+cnt+'" readonly="readonly" name="eventendtime[]" value=""></div></div>';
	   html +=   	'<a style="margin-top:30px;" href="javascript://" class="table_icon btn red margin-top-10 margin-left-10"  onclick="removeImageDive1(\''+cnt+'\')"><i class="comon_icon delete_icon"></i></a><div class="clearfix"></div>';
	   html +=            '</div><div class="clear"></div>';	
	     html +=   '</div>';
	     
		$('#inner1').append(html);
		$('.eventdate').datepicker({
			 format : 'yyyy/mm/dd',
			 startDate: date
			//mask:'9999/19/39 29:59'
		});
		
		 $('.timepicker-default').timepicker({
        maxMinutes: 15,
               // defaultTime : false

            });
		$('#img1_'+cnt).slideDown();
		//}else{
		//$('#cantADD').show();	
		//}
			
		});
		
	                       		
	                       		
	                       		
	        				 		
	          				 		
	        				 		
	        				 	
function removeImageDive1(id)
	{
	   // alert("removeImageDive");    
	   // alert(id);
		var cnt=parseInt($('#cntpro1').val())-1;
		$('#cntpro1').val(cnt);
		$('#img1_'+id).slideUp('normal',function(){	$(this).remove(); });
	}                     		
	                       		
	                       			
	                       		
	        				 		
	        				 		
	        				 	
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

function removeImageDiveAjax1(id)
{
     //   alert("removeImageDiveAjax");
      //  alert(id);
	var r=confirm('Are you sure ,you want to delete this event ?');
	if(r==true)
	{
		$.ajax({
			url:'<?php echo site_url('event/removeTimeAjax') ?>/'+id,
			success:function(res){
			var cnt=parseInt($('#cnt1').val())-1;
           // alert(cnt);
			$('#cntpro1').val(cnt);
			$('#pi1_'+id).slideUp('normal',function(){	$(this).remove(); });	 
			}
		});	
	}else{
		return false;
	}
	
}	

$(document).ready(function() {
	var date = new Date();
	$('.eventdate').datepicker({
			 format : 'yyyy/mm/dd',
			 startDate: date
			//mask:'9999/19/39 29:59'
		});
		$("input[name=event_upload_type]").change(function(){
			
			if($(this).val()=='image')
			{
				//$("#see_hide").css("display", "none");
				$("#see_image").slideDown();
				$("#see_video").slideUp();
				//$("#imagedisp").css("display", "none");
					
			}
			else
			{
				$("#see_video").slideDown();
				$("#see_image").slideUp();
				// $("#upload_video_type").slideUp('normal',function(){$("#upload_image_type").slideDown('normal')});
// 				
// 				
					// $("input[name=video_type]").attr('checked', false);
					// $("#custom_url").val('');
					// $("#prev_upload_video").val('');
					// $("#video_upload").css("display", "none");
					// $("#see_hide").css("display", "block");
					// $("#custom_type").css("display", "none");
				
				
			}
			
});
});
</script>