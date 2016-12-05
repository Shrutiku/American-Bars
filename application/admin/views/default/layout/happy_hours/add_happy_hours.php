	<!-- <link href="<?php echo base_url().getThemeName(); ?>/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/> -->
	
	<style>
	.dropdown-menu > li > a:hover > [class^="icon-"],
.dropdown-menu > li > a:focus > [class^="icon-"],
.dropdown-menu > li > a:hover > [class*=" icon-"],
.dropdown-menu > li > a:focus > [class*=" icon-"],
.dropdown-menu > .active > a > [class^="icon-"],
.dropdown-menu > .active > a > [class*=" icon-"],
		.dropdown-menu {
    background-clip: padding-box;
    background-color: #fff;
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 6px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
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
	</style>
	
	<link href="<?php echo base_url().getThemeName(); ?>/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<div class="page_content">
			<div class="container_fluid">
				
				<div class="row_fluid"> 
					<h3 class="page_title">Add Bar Happy Hours</h3>
					
				</div>
				<div class="row_fluid"> 
				<?php  
					if($msg != "") {
						
						if($msg == 'update') {
							echo '<div class="success_msg"><p>Record has been updated Successfully.</p></div>';
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
				echo form_open_multipart('bar/add_happy_hours/'.$bars_id,$attributes);
			  ?>
									
								<div class="control-group">
												
												<?php // print_r($imageGallery);die;
												if($getbar_hour!=''){
													
													$i=0;?>
													<input type="hidden" name="image_count" id="image_count" value="<?php echo count($getbar_hour);?>" />
												<div class="" id="inner">
													<?php foreach($getbar_hour as $im){
														
													//if($im->image_name!='' && file_exists(base_path().'/upload/Product/'.$im->image_name)){	
													?>
													
												<div class="controls" id="pi_<?php echo $im->bar_hour_id ?>">
													
													<input type="hidden" name="bar_hour_id[]" id="bar_hour_id" value="<?php echo $im->bar_hour_id; ?>" />
												
												<div class="control_group">
										<label class="control_label">Days: <i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<select required="required"  id="days<?php echo $im->bar_hour_id; ?>" name="days[]" class="m_wrap wid360"> 
												
													<option value="">-- Select Day-- </option>
	                       				<option value="Monday" <?php echo $im->days=="Monday" ? 'selected':'';?>>Monday</option>
	                       				<option value="Tuesday" <?php echo $im->days=="Tuesday" ? 'selected':'';?>>Tuesday</option>
	                       				<option value="Wednesday" <?php echo $im->days=="Wednesday" ? 'selected':'';?>>Wednesday</option>
	                       				<option value="Thursday" <?php echo $im->days=="Thursday" ? 'selected':'';?>>Thursday</option>
	                       				<option value="Friday" <?php echo $im->days=="Friday" ? 'selected':'';?>>Friday</option>
	                       				<option value="Saturday" <?php echo $im->days=="Saturday" ? 'selected':'';?>>Saturday</option>
	                       				<option value="Sunday" <?php echo $im->days=="Sunday" ? 'selected':'';?>>Sunday</option>
											</select>
										</div>										
										<div class="controls">
												 <div class="span1">
												 	<?php if($i==0){ ?>
											<a href="javascript:void(0);"  id="add_row" name="add_row" class="btn blue table_icon margin-left-10 margin-top-10"><i class="comon_icon addmore_icon"></i></a>
											<?php }else{ ?>
											<a href="javascript://" class="table_icon btn red margin-top-10 margin-left-10" onclick="removeImageDive('<?php echo $im->bar_hour_id ?>')"><i class="comon_icon delete_icon"></i></a>	
												<?php } ?>
											    </div>
											</div><div class="clear"></div>
									</div>	
											<div class="clear"></div>
										
										
										<div class="control_group">
										<label class="control_label">select Hours: <i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											
												<input value="<?php echo $im->hour_from; ?>" required="required" maxlength="100" type="text" placeholder="Add From Time.." class="timepicker-default m_wrap wid100" name="hour_from[]" id="hour_from" >
										</div>										
										<div class="controls" style="float:right; margin-right: 35px;">
												 <div class="span1">
											<input required="required" maxlength="100" type="text" placeholder="Add To Time.." class="timepicker-default m_wrap wid100" name="hour_to[]" id="hour_to" value="<?php echo $im->hour_to; ?>">
											    </div>
											</div><div class="clear"></div>
									</div>		
											
											<div class="control_group">
										<label class="control_label">Price:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input required="required" type="text" placeholder="price...." class="m_wrap wid360" name="price[]" id="price" value="<?php echo $im->price; ?>">
											<div id="editor1_error"></div>
										</div>										
										<div class="clear"></div>
							  </div>
							  
							  <div class="control_group">
										<label class="control_label">Speciality:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input required="required" type="text" placeholder="speciality...." class="m_wrap wid360" name="speciality[]" id="speciality" value="<?php echo $im->speciality; ?>">
											<div id="editor1_error"></div>
										</div>										
										<div class="clear"></div>
							  </div><div class="clear"></div>
											
											
												</div><div class="clear"></div>
												<?php  $i++;  /*}*/ } ?>
												</div>
												<input type="hidden" name="cntpro" id="cntpro" value="<?php echo $i; ?>" />
												<span class="controls" style="display: none;color: #B94A48;" class="help-inline" id="cantADD">You can upload maximim 7 images.</span>
												<?php  }else{ ?>
														<input type="hidden" name="bar_hour_id[]" id="bar_hour_id" value="" />
													<input type="hidden" name="image_count" id="image_count" value="0" />
														<input type="hidden" name="cntpro" id="cntpro" value="0" />	
												<div class="controls" id="main">
												<div class="control-group">
											<div id="inner">
												
												<div class="control_group">
										<label class="control_label">Days: <i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<select required="required" id="days" name="days[]" class="m_wrap wid360"> 
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
											</div><div class="clear"></div>
									</div>	
											<div class="clear"></div>
										
										
										<div class="control_group">
										<label class="control_label">select Hours: <i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
												<input required="required" maxlength="100" type="text" placeholder="Add From Time.." class="timepicker-default m_wrap wid100" name="hour_from[]" id="hour_from" value="">
										</div>										
										<div class="controls" style="float:right; margin-right: 35px;">
												 <div class="span1">
											<input required="required" maxlength="100" type="text" placeholder="Add To Time.." class="timepicker-default m_wrap wid100" name="hour_to[]" id="hour_to" value="">
											    </div>
											</div><div class="clear"></div>
									</div>		
											
											<div class="control_group">
										<label class="control_label">Price:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input required="required" type="text" placeholder="price...." class="m_wrap wid360" name="price[]" id="price" value="">
											<div id="editor1_error"></div>
										</div>										
										<div class="clear"></div>
							  </div>
							  <div class="clear"></div>
							  <div class="control_group">
										<label class="control_label">Speciality:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input required="required" type="text" placeholder="speciality...." class="m_wrap wid360" name="speciality[]" id="speciality" value="">
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
						
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>bar/list_bar/full_mug'" />
					
					
					
					</form>		
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
</div>
	

				<link href="<?php echo base_url().getThemeName(); ?>/assets/plugins/bootstrap-timepicker/compiled/timepicker.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>


	<!-- END PAGE LEVEL SCRIPTS -->
	<script>
	jQuery(document).ready(function() {       
		  // FormComponents.init();
		       $('.timepicker-default').timepicker({

                defaultTime : false

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
		$('#inner').append('<div class="controls" id="img_'+cnt+'" style="display:none;"><div class="control_group"><label class="control_label">Days: <i style="color: #7D2A1C;">*</i></label><div class="controls"><select id="days'+cnt+'" name="days[]" class="m_wrap wid360" required="required"><option value="">-- Select Day-- </option><option value="Monday">Monday</option><option value="Tuesday">Tuesday</option><option value="Wednesday">Wednesday</option><option value="Thursday">Thursday</option><option value="Friday">Friday</option><option value="Saturday">Saturday</option><option value="Sunday">Sunday</option></select></div><div class="controls"><div class="span1"><a href="javascript://" class="table_icon btn red margin-top-10 margin-left-10" onclick="removeImageDive1(\''+cnt+'\')"><i class="comon_icon delete_icon"></i></a></div></div></div><div class="clear"></div><div class="control_group"><label class="control_label">select Hours: <i style="color: #7D2A1C;">*</i></label><div class="controls"><input required="required" maxlength="100" type="text" placeholder="From Hour......" class="timepicker-default m_wrap wid100" name="hour_from[]" id="hour_from'+cnt+'" value=""></div><div class="controls" style="float:right; margin-right: 35px;"><div class="span1"><input required="required" maxlength="100" type="text" placeholder="To Hour......" class="timepicker-default m_wrap wid100" name="hour_to[]" id="hour_to'+cnt+'" value=""></div></div><div class="clear"></div></div><div class="clear"></div><div class="control_group"><label class="control_label">Price:<i style="color: #7D2A1C;">*</i></label><div class="controls"><input required="required" type="text" placeholder="price...." class="m_wrap wid360" name="price[]" id="price'+cnt+'" value=""><div id="editor1_error"></div></div><div class="clear"></div></div><div class="control_group"><label class="control_label">Speciality:<i style="color: #7D2A1C;">*</i></label><div class="controls"><input type="text" required="required" placeholder="speciality...." class="m_wrap wid360" name="speciality[]" id="speciality'+cnt+'" value=""><div id="editor1_error"></div></div><div class="clear"></div></div><div class="clear"></div></div><div class="clear"></div>');
			$('.timepicker-default').timepicker({

            });
		$('#img_'+cnt).slideDown();
	
			
		//}else{
		//$('#cantADD').show();	
		//}
			
		});
function removeImageDive(id)
	{
		
	   // alert("removeImageDive");    
	   // alert(id);
		// var cnt=parseInt($('#cntpro').val())-1;
		// //alert(cnt);
	// (parseInt(cnt)<7)?$('#cantADD').hide():'';
		// $('#cntpro').val(cnt);
// 		
		// $('#pi_'+id).slideUp('normal',function(){	$(this).remove(); });
		
		
		   //  alert(id);
		   var r = confirm("Are you sure you want to delete this bar hours?");
if (r == true) {
    	$.ajax({
				url:'<?php echo site_url('happy_hours/removebarhours') ?>/'+id,
				success:function(res){
				var cnt=parseInt($('#cnt').val())-1;
				$('#cntpro').val(cnt);
				$('#pi_'+id).slideUp('normal',function(){	$(this).remove(); });	 
					$.growlUI('Your bar hour deleted successfully .'); 
				}
			});	
} else {
    return false;
}
	
	}
	
	function removeImageDive1(id)
	{
		
	   // alert("removeImageDive");    
	   // alert(id);
		var cnt=parseInt($('#cntpro').val())-1;
		//alert(cnt);
		$('#cntpro').val(cnt);
		
		$('#img_'+id).slideUp('normal',function(){	$(this).remove(); });
		
		
		   //  alert(id);
		
	
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
	<!-- END JAVASCRIPTS -->   
