
<script>
	$('#add_row1').click(function(){
	   var date = new Date();
		var cnt=parseInt($('#cntpro1').val())+1;
		if($('#cntpro1').val() =='NaN')
		{
		    $('#cntpro1').val('1');
		    cnt = 1;
		}
		$('#cntpro1').val(cnt);
		var html = '';
		html += '<div class="padtb" id="img1_'+cnt+'" style="display:none;"><div class="padtb8">';
	    html +=  '<div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label">Date : <span class="aestrick"> * </span></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-2" style="padding-left: 13px;">';
	   html +=                   			'<input type="text" class="form-control form-pad eventdate" id="eventdate_'+cnt+'" readonly="readonly" name="eventdate[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-2" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Start Time</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;">';	
	  html +=                    			'<input type="text" class="form-control form-pad timepicker-default" id="eventstarttime_'+cnt+'" readonly="readonly" name="eventstarttime[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label" style="font-size: 16px;">End Time</label>';
	    html +=   				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;">';	
	     html +=                 			'<input type="text" class="form-control form-pad timepicker-default" id="eventendtime_'+cnt+'" readonly="readonly" name="eventendtime[]" value="">';
	    html +=                  		'</div>'	;
	     html +=                 		'<a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDive1(\''+cnt+'\')"><span class="glyphicon glyphicon-minus"></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div></div>';
	     
		$('#inner1').append(html);
		$('.eventdate').datepicker({
			        format : 'mm/dd/yyyy',
			        startDate: date
			//mask:'9999/19/39 29:59'
		});
			 $('.timepicker-default').timepicker({
        maxMinutes: 15,
               // defaultTime : false

            });
		$('#img1_'+cnt).slideDown();
			
		});
</script>
<?php 
												if($bareventtime!=''){
													
													$i=0;?>
												<div class="" id="inner1">
													<?php foreach($bareventtime as $im){
														
													//if($im->image_name!='' && file_exists(base_path().'/upload/Product/'.$im->image_name)){	
													?>
													
												<div class="padtb8" id="pi1_<?php echo $im->sss_event_time_id ?>">
													
	                       		<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Date : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="col-sm-2" style="padding-left: 13px;">
	                       			<input type="text" class="form-control form-pad eventdate" id="eventdate" readonly="readonly" name="eventdate[]" value="<?php echo $im->eventdate?>">
	                       		</div>
                                <div class="col-sm-2" style="width: 10%; padding-left: 5px; padding-right: 5px;">
	        				 		<label class="control-label " style="font-size: 16px;">Start Time</label>
	        				 	</div>
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;">	
	                       			<input type="text" class="form-control form-pad timepicker-default" id="eventstarttime" readonly="readonly" name="eventstarttime[]" value="<?php echo $im->eventstarttime;?>">
	                       		</div>	
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">
	        				 		<label class="control-label" style="font-size: 16px;">End Time</label>
	        				 	</div>
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;">	
	                       			<input type="text" class="form-control form-pad timepicker-default" id="eventendtime" readonly="readonly" name="eventendtime[]" value="<?php echo $im->eventendtime;?>">
	                       		</div>	
															
												<input type="hidden" name="image_id1[]" value="<?php echo $im->sss_event_time_id ?>" />
												
												
												<?php if($i==0){ ?>
												<a href="javascript://"  id="add_row1" name="add_row" class="btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
												<?php }else{ ?>
												<a href="javascript://"  class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeTimeDiveAjax('<?php echo $im->sss_event_time_id ?>')"><span class="glyphicon glyphicon-minus"></span></a>
												<?php } ?>
											</div><div class="clear"></div>
											
											
												
												<?php $i++;  /*}*/ } ?>
												</div>
												<input type="hidden" name="cntpro1" id="cntpro1" value="<?php echo $i; ?>" />
												<?php  } else {  ?>
													
													<div id="inner1">  	
	                       	<div class="padtb8">
	                       		<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Date : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="col-sm-2" style="padding-left: 13px;">
	                       			<input type="text" class="form-control form-pad eventdate" id="eventdate" readonly="readonly" name="eventdate[]" value="">
	                       		</div>
                                <div class="col-sm-2" style="width: 10%; padding-left: 5px; padding-right: 5px;">
	        				 		<label class="control-label " style="font-size: 16px;">Start Time</label>
	        				 	</div>
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;">	
	                       			<input type="text" class="form-control form-pad timepicker-default" id="eventstarttime" readonly="readonly" name="eventstarttime[]" value="">
	                       		</div>	
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">
	        				 		<label class="control-label" style="font-size: 16px;">End Time</label>
	        				 	</div>
	                       		<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;">	
	                       			<input type="text" class="form-control form-pad timepicker-default" id="eventendtime" readonly="readonly" name="eventendtime[]" value="">
	                       		</div>	
	                       		<a href="javascript://;" id="add_row1" name="add_row1" class="btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
	                       			<div class="clearfix"></div>
	        				 		<!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
	        				 		
	        				 		
	        				 	</div>
	                       	</div>
													<?php }           ?>
													
