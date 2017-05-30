
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>admin/default/assets/plugins/select2/select2_metro.css" />
	<script type="text/javascript" src="<?php echo base_url();?>admin/default/assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>admin/default/assets/plugins/select2/select2.min.js"></script>

<style>
.radio + .radio, .checkbox + .checkbox
{
	margin-top: 10px;
}
	.dropdown-menu{
		background-color: #fff;
	}
</style>
<div class="wrapper row6 padtb10 has-js">
     	<div class="container">
     		<div class="margin-top-50 bg_brown">
     			<?php echo $this->load->view(getThemeName().'/home/dashboard_menu'); ?>
     			<div class="dashboard_detail">
     				<div class="result_search event"><div class="result_search_text"><i class='glyphicon glyphicon-calendar' style="color:'#FFF'; margin-left: 5px; padding-bottom: 5px; font-size: 42px; vertical-align: middle; margin: auto;"></i> Events</div></div>
		     		<div class="dashboard_subblock">
		     			<div>
		     				<div class="dash-btngroup">
	     						<div id="hd_del">
	     							<button type="submit" class="btn btn-lg btn-primary marr_10" onclick="list_add()">Add</button>
		                       		<a class="btn btn-lg btn-primary marr_10" href="javascript:void(0)" onclick="setaction('chk[]','delete',   'frm_event');">Delete</a>
		                       		
	     						</div>
	     						<div id="hs_del" style="display: none;">
	     							<a onclick="goto_main()" href="javascript://"  class="btn btn-lg btn-primary marr_10">Back</a>
	     						</div>
     						</div>
     					<div id="list_hide_m">
     						<?php			 
					$attributes = array('name'=>'frm_search','id'=>'frm_search','data-async'=>'','data-target'=>'.content');
					echo form_open('admin/search_bar_events/'.$limit,$attributes);?>
					<div class="search_block">
						<input type="hidden" name="limit" id="search-limit" value="<?php echo ($limit>0)?$limit:10; ?>" />
				     			<div class="search-strip">
				     				<form class="form-horizontal" role="form">
					                   <div class="form-group">
					                       <div class="col-sm-7 input_box pull-left" style="padding-left: 0;">
					                           <input type="text" name="event_keyword" id="event_keyword" class="form-control form-pad" id="inputEmail3" placeholder="Search By Title" onkeydown="if (event.keyCode == 13) { get_search_event(); return false; }" />
					                       </div>
					                       <div class="col-sm-2 input_box pull-left">
				                        		<button type="button" onclick="get_search_event()" id="search" class="btn btn-lg btn-primary search"><i class="strip search"></i></button>
				                       	   </div>
				                       	   <div class="col-sm-2 input_box pull-left">
				                        		<a href="<?php echo site_url('bar/bar_events')?>" class="btn btn-lg btn-primary search" type="submit"><i class="strip refresh"></i>
				                       	   </a></div>
				                       	   <div class="clearfix"></div>
					                    </div>
				                    </form>
				     			</div>
					     		
					     		<div class="clearfix"></div>
					     		</form>
					     	</div>
					     	</div>
     					<div id="list_hide" class="content">	
     						<?php			 
					$attributes = array('name'=>'actionevent','id'=>'actionevent','data-target'=>'.content');
					echo form_open('bar/actionevent',$attributes);?> 
					<input type="hidden" name="action" id="action" />
					    					<div class="table-responsive">
     						<div id="responsecomment">
     							<div class="pagination" id="at_ajax">
	     				<?php echo $page_link;?>
     				</div><div class="clearfix"></div>
							<table class="table">
								<thead>
									<th><label  class="radio-checkbox label_check c_on group-checkable" for="checkbox-00"><input type="checkbox" data-set=".checkboxes" name="sample-checkbox-00" id="checkbox-00" value="1"></label></th>
									<th>Event Title</th>
									<th>Location</th>
                                                                        <!--<th>Date</th>-->
									<th>Status</th>
									<th>Action</th>
								</thead>
								<tbody>
								<?php
								
								if($result)
								{
									$i=1;
									foreach($result as $event){								
								
								if ($i % 2 == 0)
										  {
										    $dark =  "dark";
										  }
										  else
										  {
										    $dark =  "light";
										  }?>	
									<tr class="<?php echo $dark; ?>" id='remove_event_<?php echo $event->event_id; ?>'>
										<td><label class="radio-checkbox label_check c_on" for="checkbox-<?php echo  $event->event_id;?>">
											<input type="checkbox"  class="checkboxes" name="chk[]" id="checkbox-<?php echo  $event->event_id;?>" value="<?php echo $event->event_id;?>"></label></td>
										<td><?php echo $event->event_title;?></td>
										<td><?php echo $event->address;?></td>
										<td><?php echo ucfirst($event->status);?></td>
										<td>
											<a href="javascript://" onclick="editbarevent('<?php echo $event->event_id; ?>')"><i class="strip edit_table"></i></a>
											<a href="javascript://" onclick="deleteevent('<?php echo $event->event_id; ?>')" ><i class="strip delete"></i></a>
										</td>
									</tr>
								<?php $i++; } } else { ?>
									<tr>
										<td colspan="6">No events were found at your bar.</td>
									</tr>	
										
									<?php } ?>	
								</tbody>
							</table>
							</div>
							<input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
					<input type="hidden" name="offset" id="offset" value="<?php echo ($offset!='')?$offset:0; ?>" />
					<input type="hidden" name="limit" id="limit" value="<?php echo ($limit>0)?$limit:10; ?>" />
						</div>
						</form>
					</div>	
					
				<div id="list_show" style="display: none;" >	
					<input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
					<input type="hidden" name="offset" id="offset" value="<?php echo ($offset!='')?$offset:0; ?>" />
					<input type="hidden" name="limit" id="limit" value="<?php echo ($limit>0)?$limit:10; ?>" />
					
					<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
					<!-- <form name="add_event" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('bar/add_event/'.base64_encode($getbar['bar_id'])); ?>"> -->
						
						 <?php 
                       $attributes = array('id'=>'form','name'=>'add_event');
                       echo form_open_multipart('bar/add_event/'.base64_encode($getbar['bar_id']),$attributes);
                  ?>
						<input type="hidden" name="event_id" id="event_id" value="" />
     				
     					<form class="form-horizontal" role="form">
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Event Title : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="event_title" name="event_title" value="">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Venue : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="venue" name="venue" value="<?php echo $getbar['bar_title'];?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb mar_top20">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Event Category :  </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<select class="m_wrap wid360 span12 select2 select_box" multiple name="event_category[]" id="event_category">
		                           		
																	<?php 
																	
																	//echo $getbar['bar_category'];
																	$event_category = explode(',', @$getbar['event_category']);
																	
																	//print_r($event_category);
																	if($get_cat)
																	       {
																	       	  foreach($get_cat as $row)
																			  {  
																			  	if(!empty($bar_category))
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
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Description :  <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<textarea rows="5" name="event_desc" id="event_desc" placeholder="Description" class="form-control form-pad"></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       		<input type="hidden" name="cntpro1" id="cntpro1" value="0" />
	                       <div id="conttime">
	                       <div id="inner1" >	
								
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
	        				 	
	        				 	</div>
	        				 	
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Address : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="address" name="address" value="<?php echo $getbar['address'];?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">City : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="city1" name="city" value="<?php echo $getbar['city'];?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">State : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="state1" name="state" value="<?php echo $getbar['state'];?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Zipcode : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="zipcode1" name="zipcode" value="<?php echo $getbar['zipcode'];?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Phone Number :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="phone" name="phone" value="">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	<!-- <div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Event Image : </label>
	        				 	</div>
	                       		<div class="input_box upload_btn">
	                           		<input type="file" class="form-control form-pad" id="event_image" name="event_image">
	                           		<input type="hidden" name="prev_event_image" id="prev_event_image" value="" />
	                       		</div>
	                       		
	                       		<div class="input_box upload_user">
	                           		<img src="" id="img_here" alt="" class="img-responsive"/>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div> -->
	                       	
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Upload Type : </label>
	        				 	</div>
	                       		<div class="radio pull-left">
				     				<label>
				          				<input type="radio" value="image" onclick="seeimage('image')" name="event_upload_type" id="typeimage"> Image
				        			</label>
			        			</div>
			        			<div class="radio pull-left">
				     				<label>
				          				<input type="radio" value="video" onclick="seeimage('video')"  name="event_upload_type" id="typevideo"> Video
				        			</label><div class="clearfix"></div>
			        			</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	<div id="hide_edit" style="display: none;">
	                     	<div id="inner">  	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Event Image : </label>
	        				 	</div>
	        					        				 	
	                       		<div class="input_box upload_btn">
	                           		<input type="file" accept="image/*" class="form-control form-pad" id="photo_image" name="photo_image[]">
	                           		<input type="hidden" name="prev_event_image" id="prev_event_image" value="" />
	                           		<input type="hidden" name="image_count" id="image_count" value="0" />
									<input type="hidden" name="cntpro" id="cntpro" value="0" />
														<input type="hidden" name="prev_photo_image" id="prev_photo_image" value="" />	
														
	                       		</div>
	                       		
	                       		<!-- <div class="input_box upload_user">
	                           		<img src="" id="img_here" alt="" class="img-responsive"/>
	                       		</div> -->
	                       			<a href="javascript://;" id="add_row" name="add_row" class="btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>
	                       		<!-- <div class="input_box pull-left">
	                           		<button type="submit" class="btn btn-lg btn-primary " href="#">Upload</button> 
	                       		</div> -->
	                       		<div class="clearfix"></div>
	                       		</div>
	                       	</div>
	                      </div> 	
	                       	
	                       		<!-- <div id="hide_edit1" style="display: none;">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Event Video : </label>
	        				 	</div>
	                       		<div class="input_box upload_btn">
	                           		<input type="file" accept="video/*" class="form-control form-pad" id="event_video" name="event_video">
	                       		</div>
	                       		<div id="prev_event_video_htm">
	                       			
	                       		</div>
	                       		<input type="hidden" name="prev_event_video" id="prev_event_video" value="" />
	                       		<div class="clearfix"></div>
	                       	</div> -->
	                       	
	                       	<div class="padtb" id="hide_edit1" style="display: none;">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Video Link : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="event_video_link" name="event_video_link" value="">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Admission : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="admission" name="admission" value="">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Buy Ticket : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="buy_ticket" name="buy_ticket" value="">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Website : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="website" name="website" value="">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<!-- <div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Facebook Link :  </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="event_fb_link" name="event_fb_link" value="">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Twitter Link :  </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="event_twitter_link" name="event_twitter_link" value="">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Google Plus Link :  </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="event_google_plus_link" name="event_google_plus_link" value="">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Pinterest Link :  </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="event_pinterest_link" name="event_pinterest_link" value="">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div> -->
	                       <!-- <div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Is this power Boost Event :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<select class="select_box" name="is_power_boost_event" id="is_power_boost_event">
		                           		<option value="0">No</option>
		                           		<option value="1">Yes</option>
		                         	</select>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div> -->
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Status :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<select class="select_box" name="status" id="status">
		                           		<option value="active">Active</option>
		                           		<option value="inactive">Inactive</option>
		                         	</select>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10 text-left">
	                       			<button type="submit" class="btn btn-lg btn-primary marr_10" >Save</button> 
	                       			<a  class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('bar/bar_events');?>" >Cancel</a>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="clearfix"></div>
	        			</form>
     			</form>
     			</div>
     			
		     	</div>
     		</div>
     	<div class="clearfix"></div>
     </div>
   </div>
 </div>
 
<link href="<?php echo base_url().getThemeName(); ?>/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/assets/plugins/bootstrap-datepicker/css/datepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/assets/plugins/font-awesome/css/font-awesome.min.css" />
<script src="<?php echo base_url().getThemeName();?>/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/js/jquery_form.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/new-timepicker.css" />
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/new-bootstrap-timepicker.js"></script> 
    <script>
     $(document).ready(function() { 
		   $("#phone").inputmask("(999) 999-9999");
	});
   $("form#form").submit(function(){

    var formData = new FormData($(this)[0]);
   
    $.ajax({
        url: '<?php echo site_url('bar/add_event/'.base64_encode($getbar['bar_id']));?>',
        type: 'POST',
        data: formData,
        async: false,
         dataType : 'json',
         beforeSend: function() 
				 {
				 	
		       		$('#dvLoading').fadeIn('slow');
		    	 },
		    
		    	success : function ( json ) 
		    	{
		    		
		    		
					if(json.status == "fail")
					{
						
						$("#cm-err-main1").show();
						$("#cm-err-main1").html(json.comment_error);
						scrollToDiv("cm-err-main1");
			    		$('#dvLoading').fadeOut('slow');
			    		scrollToDiv('cm-err-main1');
				  		// setTimeout(function () 
						// {
						      // $("#cm-err-main1").fadeOut('slow');
						// }, 3000);
					   return false;
					}
			
					else
					{
						//alert("sdsa");
						$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
						if($('#event_id').val()=='')
						{
							$.growlUI('Your event was added successfully .');
						}
						else
						{
							$.growlUI('Your event was updated successfully .');
						}
						$(':input','#form')
					 	.not(':button, :submit, :reset, :hidden')
					 	.val('')
					 	//.removeAttr('checked')
					 	.removeAttr('selected');
					 	
					 	 $("#typeimage").val("image");
					 	$("#typevideo").val("video");
					 	 $("#list_hide").slideDown();
					 	 $("#list_hide_m").slideDown();
					     $("#hd_del").slideDown();
					     $("#hs_del").slideUp();
					     $('#list_show').slideUp();
					     $("#at_ajax").remove();
					     getData();
					}
					$('#dvLoading').fadeOut('slow');
		   		},
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
});
    $(document).ready(function(){
    	
    	 $('.timepicker-default').timepicker({
        maxMinutes: 15,
               // defaultTime : false

            });
    	        $('.label_check, .label_radio').click(function(){
    	        	
            setupLabel();
        });
        setupLabel(); 
        
        $('#form1').validate({
		rules: {
					'photo_image[]':{
						 required: function() { return $("#image_count").val() == 0 ? true:false; },
						 accept: "jpg|jpeg|png|bmp"
						},
					event_title: {
						required: true,
					},
					event_desc: {
						required: true,
					},
					address: {
						required: true,
					},
					city1: {
						required: true,
					},
					zipcode1: {
						required: true,
						number: true,
					},
					admission: {
						number : true,
					},
					end_date: { greaterThan: "#start_date" },
					state1: {
						required: true,
					},
					event_video_link: {
				 url:true,
					},
					website: {
						 url:true,
					},
					event_fb_link: {
						 url:true,
					},
					event_twitter_link: {
						 url:true,
					},
					event_google_plus_link: {
						 url:true,
					},
					event_pinterest_link: {
						 url:true,
					},
					buy_ticket: {
						 url:true,
					},
						errorClass:'error fl_right'
				},
				
		submitHandler: function(form){
			
		$(form).ajaxSubmit({
			
		type: "POST",
		   		 dataType : 'json',
				 beforeSubmit: function() 
				 {
		       		$('#dvLoading').fadeIn('slow');
		    	 },
		    	
		    	uploadProgress: function ( event, position, total, percentComplete ) {	
		        },
		    
		    	success : function ( json ) 
		    	{
		    		
					if(json.status == "fail")
					{
						
						$("#cm-err-main1").show();
						
						//$('html,body').animate({ scrollTop: $('#'+div).offset().top }, 500);
						$("#cm-err-main1").html(json.comment_error);
						
			    		$('#dvLoading').fadeOut('slow');
			    		scrollToDiv('cm-err-main1');
				  		// setTimeout(function () 
						// {
						      // $("#cm-err-main1").fadeOut('slow');
						// }, 3000);
						
						
					return false;
					}
			
					else
					{
						//alert("sdsa");
						$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
						if($('#event_id').val()=='')
						{
							$.growlUI('Your event add successfully .');
						}
						else
						{
							$.growlUI('Your event update successfully .');
						}
						$(':input','#form')
					 	.not(':button, :submit, :reset, :hidden')
					 	.val('')
					 	//.removeAttr('checked')
					 	.removeAttr('selected');
					 	$("#typeimage").val("image");
					 	$("#typevideo").val("video");
					 	 $("#list_hide").slideDown();
					 	 $("#list_hide_m").slideDown();
					     $("#hd_del").slideDown();
					     $("#hs_del").slideUp();
					     $('#list_show').slideUp();
					     $("#at_ajax").remove();
					     getData();
					}
					$('#dvLoading').fadeOut('slow');
		   		 }
		    });
		  }
		})
		
		jQuery.validator.addMethod("greaterThan", 
		function(value, element, params) {
		
		    if (!/Invalid|NaN/.test(new Date(value))) {
		        return new Date(value) > new Date($(params).val());
		    }
		
		    return isNaN(value) && isNaN($(params).val()) 
		        || (Number(value) > Number($(params).val())); 
		},'Must be greater than start date.');
    });
    
    function getData()
	{
	//var keyword=($('#keyword').val()!='')?$('#keyword').val().split(' ').join('-'):'1V1';
	var limit = $('#limit').val();
    var keyword = $("#event_keyword").val();
    if(keyword=='')
    {
    	var keyword = '1V1';
    }
	var offset = $('#offset').val();
	var redirect_page=$('#redirect_page').val();
	var url='<?php echo site_url('bar/') ?>/'+redirect_page+'/'+limit+'/'+keyword+'/'+offset;
	
	
	$.ajax({
			url : url,
			cache: false,
			// beforeSend : function() {
				// blockUI('.portlet-body');
			// },
			success : function(response) {
				// alert(response);
				$('.content').html('');
				$('.content').html(response);
				setupLabel();
				bindJquery();
				
				//bindJquery();
			},
			// complete : function() {
				// unblockUI('.portlet-body');
			// },
	});
	
	}
    function list_add()
    {
    	var date = new Date();
    	$('#event_category').select2({
            placeholder: "Select Category",
            allowClear: true
        });
    		$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
    	$("#event_id").val('');
    	$("#prev_event_video_htm").empty();
    	$(':input','#form')
					 	.not(':button, :submit, :reset, :hidden')
					 	.val('')
					 	//.removeAttr('checked')
					 	.removeAttr('selected');
    	$("#list_hide").slideUp();
    	$("#list_hide_m").slideUp();
    	$("#hd_del").slideUp();
    	$("#hs_del").slideDown();
    	$('#list_show').slideDown();
    	$("#typeimage").val("image");
					 	$("#typevideo").val("video");
    	
		var html = '';
		html += '<div class="padtb8">';
	    html +=  '<div class="col-sm-3 text-right">';
	    html +=  '<label class="control-label">Date : <span class="aestrick"> * </span></label>';
	    html +=   '</div>';
	     html +=         		'<div class="col-sm-2" style="padding-left: 13px;">';
	   html +=                   			'<input type="text" class="form-control form-pad eventdate" id="eventdatename="eventdate[]"" readonly="readonly" name="eventdate[]" value="">';
	   html +=                   		'</div>';
        html +=                       '<div class="col-sm-2" style="width: 10%; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label " style="font-size: 16px;">Start Time</label>';
	   html +=    				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;">';	
	  html +=                    			'<input type="text" class="form-control form-pad timepicker-default" id="eventstarttimename="eventdate[]"" readonly="readonly" name="eventstarttime[]" value="">';
	   html +=                   		'</div>'	;
	     html +=                 		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;; padding-left: 5px; padding-right: 5px;">';
	   html +=    				 		'<label class="control-label" style="font-size: 16px;">End Time</label>';
	    html +=   				 	'</div>';
	   html +=                   		'<div class="col-sm-2" style="width: 10%;  padding-left: 5px; padding-right: 5px;">';	
	     html +=                 			'<input type="text" class="form-control form-pad timepicker-default" id="eventendtimename="eventdate[]"" readonly="readonly" name="eventendtime[]" value="">';
	    html +=                  		'</div>'	;
	     html +=                 		'<a href="javascript://;" id="add_row1" name="add_row1" class="btn btn-lg btn-primary search marr_10 pull-left"><span class="glyphicon glyphicon-plus "></span></a>';
	     html +=                 			'<div class="clearfix"></div>';
	     html +=   '</div>';
		
		$('#inner1').html(html);
    	$('.eventdate').datepicker({
			        format : 'mm/dd/yyyy',
			        startDate: date
			//mask:'9999/19/39 29:59'
		});
			 $('.timepicker-default').timepicker({
        maxMinutes: 15,
               // defaultTime : false

            });
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
           
            
            
    }
    
    function goto_main()
    {
    	$("#event_id").val('');
    	$("#prev_event_video_htm").empty();
    	$(':input','#form')
					 	.not(':button, :submit, :reset, :hidden')
					 	.val('')
					 	//.removeAttr('checked')
					 	.removeAttr('selected');
					 	$.ajax({
			       type: "POST",
				   url: "<?php echo site_url('bar/bareventgalleryimages')?>",
				   data : {id:$("#event_id").val()},
				   dataType : 'html',
				   success: function(responsenew) {
				   	$("#hide_edit").html(responsenew);
				  }
			   });	
		$("#img_here").removeAttr('src');			 	
    	$("#list_hide").slideDown();
    	$("#list_hide_m").slideDown();
    	$("#hd_del").slideDown();
    	$("#hs_del").slideUp();
    	$('#list_show').slideUp();
    	$("#typeimage").val("image");
					 	$("#typevideo").val("video");
    }
</script>
<script>
function format(inputDate) {
    var date = new Date(inputDate);
    if (!isNaN(date.getTime())) {
        // Months use 0 index.
        return date.getMonth() + 1 + '/' + date.getDate() + '/' + date.getFullYear();
    }
}
$(document).ready(function(){	
		$('#event_category').select2({
            placeholder: "Select Category",
            allowClear: true
        });
	 var date = new Date();
	  bindJquery();	
	  $('.fancybox-video').fancybox({type: 'iframe'});
		$('.eventdate').datepicker({
			        format : 'mm/dd/yyyy',
			        startDate: date
			//mask:'9999/19/39 29:59'
		});
	
	 });	
	 $(".pagination li a").click(function() {
		  //alert("Handler for .click() called.");
		  var res = $.ajax(
	        {						
			   type: 'POST',
			   url: $(this).attr("href"),
			   dataType: 'post', 
			   cache: false,
			   async: false,
			   beforeSend : function(){
			      $('#dvLoading').fadeIn('slow');
			   },
			   complete: function(){
			   
			     $('#dvLoading').fadeOut('slow');
			     
			    }
			}).responseText;
			
			$("#list_hide").html(res);
			bindJquery();
			setupLabel();	
			
			return false;
			
		});
		
 function editbarevent(id)
 {
 	// $("#event_category").select2({
                 // tags: ['Black', 'Blue', 'Green', 'Orange', 'Red', 'Yellow', 'White']
// 
// });




 			$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
 	 $.ajax({
	       type: "POST",
		   url: "<?php echo site_url('bar/bareventdetail')?>",
		   data : {id:id},
		   dataType : 'JSON',
		   success: function(response) {
		      //alert(response.city);
		      
		      $("#event_id").val(response.event_id);
		      $("#event_title").val(response.event_title);
		      $("#event_desc").val(response.event_desc);
		      $("#start_date").val(format(response.start_date));
		      $("#end_date").val(format(response.end_date));
		      
		      
		      $("#start_time").val(response.start_time);
		      $("#end_time").val(response.end_time);
		      $("#address").val(response.address);
		      $("#city1").val(response.city);
		      $("#state1").val(response.state);
		      $("#phone").val(response.phone);
		      $("#zipcode1").val(response.zipcode);
		      $("#event_video_link").val(response.event_video_link);
		      $("#is_power_boost_event").val(response.is_power_boost_event);
		      $("#status").val(response.status);
		      $("#admission").val(response.admission);
		      $("#buy_ticket").val(response.buy_ticket);
		      $("#website").val(response.website);
		      $("#venue").val(response.venue);
		      // $("#event_fb_link").val(response.event_fb_link);
		      // $("#event_twitter_link").val(response.event_twitter_link);
		      // $("#event_google_plus_link").val(response.event_google_plus_link);
		      // $("#event_pinterest_link").val(response.event_pinterest_link);
		      $("#prev_event_image").val(response.event_image);
		      $("#prev_event_video").val(response.event_video);
		     
		      if(response.event_upload_type=='image')
		      {
		      	$('#typeimage').prop('checked', true);
		      	$("#hide_edit").show();
		      }
		      else if(response.event_upload_type=='video')
		      {
		      	$('#typevideo').prop('checked', true);
		      	$("#hide_edit1").hide();
		      }
		      if(response.event_video!='')
		      {
		      		 var src_vid = '<?php echo base_url().'upload/event_video/'?>';
		      	     var htm = '<a href="'+src_vid+response.event_video+'" id="video_add" class="image_play fancybox-video">'+response.event_video+'</a>';
		      	   //  $("#video_add").attr("href", src_vid+response.event_video);
		      		 $("#prev_event_video_htm").html(htm);
			  }
		     
		      // if(response.event_image!='')
		      // {
		      		// var src1 = '<?php //echo base_url().'upload/event_thumb/'?>';
					// $("#img_here").attr("src", src1+response.event_image);
			 // }
			 
			 
		    $("#list_hide").slideUp();
	    	$("#list_hide_m").slideUp();
	    	$("#hd_del").slideUp();
	    	$("#hs_del").slideDown();
	    	
	    	$('#list_show').slideDown();
	    	bindJquery();
	    	 $.ajax({
			       type: "POST",
				   url: "<?php echo site_url('bar/bareventgalleryimages')?>",
				   data : {id:response.event_id},
				   success: function(responsenew) {
				   	//alert(responsenew);
				   	$("#hide_edit").html(responsenew);
				  }
			   });
			   
			   $.ajax({
			       type: "POST",
				   url: "<?php echo site_url('bar/bareventtime')?>",
				   data : {id:response.event_id},
				   success: function(responsenew) {
				   	//alert(responsenew);
				   	$("#conttime").html(responsenew);
				  }
			   });
			   
			   $.ajax({
			       type: "POST",
				   url: "<?php echo site_url('bar/geteventcategory')?>",
				   dataType:'JSON',
				   data : {id:response.event_category},
				   success: function(responsenew) {
				   //	alert(responsenew);
				   
				   	$(".select2-choices").html(responsenew.result1);
				   	$("#event_category").html(responsenew.result2);
				   	$('#event_category').select2({
            placeholder: "Select Category",
            allowClear: true
        });
				  }
			   });
			   
			   
		     
		  }
	   });
	   
	    $("#typeimage").val("image");
					 	$("#typevideo").val("video");
					 	
 }
 function get_search_event()
 {
 	  var event_keyword = $("#event_keyword").val();
 	  var limit = $("#limit").val();
 	  var offset = 0; 
 	  var res = $.ajax(
	        {						
			   type: 'POST',
			   url: '<?php echo site_url('bar/bar_events/')?>',
			   dataType: 'post', 
			   data : {event_keyword:event_keyword,limit:limit,offset:offset},
			   cache: false,
			   async: false,
			   beforeSend : function(){
			      $('#dvLoading').fadeIn('slow');
			   },
			   complete: function(){
			   
			     $('#dvLoading').fadeOut('slow');
			     
			    }
			}).responseText;
			
			$("#list_hide").html(res);
			//bindJquery();
			 $('.label_check').removeClass('c_on');
                    $('.checkboxes').removeAttr('Checked'); 
                    bindJquery();
 }
 
 
 function deleteevent(id)
 {
 	 
			alertify.confirm("Are you sure you want to delete this event?", function (e) {
				if (e) {
					 var res = $.ajax(
	        {						
			   type: 'POST',
			   url: '<?php echo site_url('bar/bareventdelete/')?>',
			   dataType: 'post', 
			   data : {id:id},
			   cache: false,
			   async: false,
			   beforeSend : function(){
			      $('#dvLoading').fadeIn('slow');
			   },
				complete: function(){
				     $('#dvLoading').fadeOut('slow');
				     getData();
				     $("#remove_event_"+id).remove();
				     $.growlUI('Your event deleted successfully .');
				    }
				}).responseText;
				bindJquery();
			}
			return false;
			
 });
 }
 
 function bindJquery()
	{
		
		
		jQuery('.group-checkable').change(function () {
			
	                if ($('.label_check input').length) {
			            $('.label_check').each(function(){ 
			                $(this).removeClass('c_on');
			                            $('.checkboxes').removeAttr('Checked'); 
			            });
			            $('.label_check input:checked').each(function(){ 
			            	
			               // $(this).parent('label').addClass('c_on');
			                $( ".radio-checkbox" ).addClass( "c_on" ); 
			                            $('.checkboxes').attr('Checked','Checked'); 
			                  //  $('#states').find('span').addClass('checked');        
			            });                
			        };
	            });
	
	}
function setupLabel() {
        if ($('.label_check input').length) {
            $('.label_check').each(function(){ 
                $(this).removeClass('c_on');
            });
            $('.label_check input:checked').each(function(){ 
                $(this).parent('label').addClass('c_on');
            });                
        };
        if ($('.label_radio input').length) {
            $('.label_radio').each(function(){ 
                $(this).removeClass('r_on');
            });
            $('.label_radio input:checked').each(function(){ 
                $(this).parent('label').addClass('r_on');
            });
        };
    };
 
    
    function setaction(elename, actionval, formname) {

	vchkcnt=0;
	elem = document.getElementsByName(elename);
	
	
	for(i=0;i<elem.length;i++){
		if(elem[i].checked) vchkcnt++;
		//vchkcnt++;
			
	}
	if(vchkcnt==0) {
			alertify.alert("Please select a record .");
			return false;
	} else {
		
		alertify.confirm("Are you sure you want to delete this event?", function (e) {
				if (e) {
			document.getElementById('action').value=actionval;	
			//$('#frm_admin').submit();
		var $form = $('#actionevent');
        var $target = $($form.attr('data-target'));
 		var limit=$('#limit').val();
 		var offset=$('#offset').val();
 		var keyword=$('#event_keyword').val();
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            cache: false,
            dataType:'json',
            data: $form.serialize(),
            beforeSend : function() {
				$('#dvLoading').fadeIn('slow');
			},success: function(res, status) {
				// alert(res);
                if(res.status=='done'){
                	$.growlUI('Your events deleted successfully .'); 
                	getData();	
                }
                
            },complete : function() {
				$('#dvLoading').fadeOut('slow');
			},
        });
		}		
		else
		{
			return false;
		}
		});
	}
}

  $('#add_row').click(function(){
	
		var cnt=parseInt($('#cntpro').val())+1;
		if($('#cntpro').val() =='NaN')
		{
		    $('#cntpro').val('1');
		    cnt = 1;
		}
		$('#cntpro').val(cnt)
		$('#inner').append('<div class="padtb" id="img_'+cnt+'" style="display:none;"><div class="col-sm-3 text-right"><label class="control-label"></label></div><div class="input_box upload_btn" data-provides="fileupload"><div class="uneditable-input"><span class="fileupload-preview"></span></div><div class="input_box upload_btn"><span class="fileupload-exists"></div><input type="file" class="form-control form-pad" name="photo_image[]" id="photo_image_'+cnt+'" /></span></div><a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDive(\''+cnt+'\')"><span class="glyphicon glyphicon-minus"></span></a></div></div><div class="clear"></div>');
		$('#img_'+cnt).slideDown();
			
		});
		
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
		
		function removeImageDiveAjax(id)
	{
	     //   alert("removeImageDiveAjax");
	      //  alert(id);
		alertify.confirm("Are you sure you want to delete this event image?", function (e) {
			if (e) {
			$.ajax({
				url:'<?php echo site_url('bar/removeImageAjaxEvent') ?>/'+id,
				success:function(res){
				var cnt=parseInt($('#cnt').val())-1;
	           // alert(cnt);
				$('#cntpro').val(cnt);
				$('#pi_'+id).slideUp('normal',function(){	$(this).remove(); });	 
					$.growlUI('Your event image deleted successfully .'); 
				}
			});	
		}else{
			return false;
		}
		
	});	
	}
	
	
	function removeTimeDiveAjax(id)
	{
	     //   alert("removeImageDiveAjax");
	      //  alert(id);
		alertify.confirm("Are you sure you want to delete this event time?", function (e) {
			if (e) {
			$.ajax({
				url:'<?php echo site_url('bar/removeTimeAjaxEvent') ?>/'+id,
				success:function(res){
				var cnt=parseInt($('#cnt1').val())-1;
	           // alert(cnt);
				$('#cntpro1').val(cnt);
				$('#pi1_'+id).slideUp('normal',function(){	$(this).remove(); });	 
					$.growlUI('Your event time deleted successfully .'); 
				}
			});	
		}else{
			return false;
		}
		
	});	
	}
	
	function removeImageDive(id)
	{
		var cnt=parseInt($('#cntpro').val())-1;
		$('#cntpro').val(cnt);
		$('#img_'+id).slideUp('normal',function(){	$(this).remove(); });
	}
	function removeImageDive1(id)
	{
		var cnt=parseInt($('#cntpro1').val())-1;
		$('#cntpro1').val(cnt);
		$('#img1_'+id).slideUp('normal',function(){	$(this).remove(); });
	}
	
	   function seeimage(image)
	   {
	   	  
	   	  if(image=='image')
	   	  {
	  		 	$("#hide_edit").show();
				$("#hide_edit1").hide();
		  }
		  if(image=='video')
	   	  {
	  		 	$("#hide_edit").hide();
				$("#hide_edit1").show();
		  }	
	   	
	   }
	
</script>

