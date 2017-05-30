
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.bxslider.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/css/jquery.bxslider.css" />

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>admin/default/assets/plugins/select2/select2_metro.css" />
	<script type="text/javascript" src="<?php echo base_url();?>admin/default/assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>admin/default/assets/plugins/select2/select2.min.js"></script>

<input type="hidden" name="offset" id="offset" value="0" />
<input type="hidden" name="limit" id="limit" value="4" />
<style>
.select2-container-multi .select2-choices
{
	background-color: none;
	border: none;
}
.cke_source
{
	color: #000000;
}
.morecontent span {
    display: none;
}
.morelink {
    display: block;
}
span.required {
    color: #B31010;
    vertical-align: -4px;
}
	#gmap_marker
	{
		width: 40%;
		height: 250px;
	}
	.gm-style-iw
	{
		color: #000000;
	}
	
</style>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/image_script.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery_form.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/ckeditor/ckeditor.js"></script>
<script>
	$(document).ready(function() {
		$('#bar_category').select2({
            placeholder: "Select Category",
            allowClear: true
        });

		// CKEDITOR.replace( 'desc', {
	// toolbar: [
		// { name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
		// [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],			// Defines toolbar group without name.
		// '/',																					// Line break - next group will be placed in new line.
		// { name: 'basicstyles', items: [ 'Bold', 'Italic' ] }
	// ]
// });
	  initialize_map();
    var showChar = 600;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more";
    var lesstext = "Show less";
    
    $('.more').each(function() {
        var content = $(this).html();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink more pull-right"><i class="strip arrow_down"></i>' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
   $(".morelink").click(function(){
         $("#myModalnew_open").modal('show');
    });
    // $(".morelink").click(function(){
        // if($(this).hasClass("less")) {
            // $(this).removeClass("less");
            // $(this).html(moretext);
            // $(".morelink").html("<i class='strip arrow_down more'></i>View More..");
        // } else {
            // $(this).addClass("less");
            // $(this).html("<i class='strip arrow_up more'></i>View Less..");
        // }
        // $(this).parent().prev().toggle();
        // $(this).prev().toggle();
        // return false;
    // });
});
</script>
<script type="text/javascript">
$(document).ready(function()
{


$('body').on('change','#photoimg', function()
 {
var A=$("#imageloadstatus");
var B=$("#imageloadbutton");

$("#imageform").ajaxForm({target: '#preview',
beforeSubmit:function(){
A.show();
B.hide();
},
success:function(){
A.hide();
B.show();
},
error:function(){
	
A.hide();
B.show();
} }).submit();
});

});
</script>

<?php if($getbar['bar_type']=="full_mug"){?>
<div class="modal fade" id="userguide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<?php echo $this->load->view(getThemeName().'/home/userguide_f');?>
</div>	
<?php } else { ?>
	<div class="modal fade" id="userguide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<?php echo $this->load->view(getThemeName().'/home/userguide_h');?>
</div>	
	
<?php } ?>
<div class="wrapper row6 padtb10">
     	<div class="container">
     		<div class="margin-top-50 bg_brown">
     			<?php echo $this->load->view($theme.'/home/dashboard_menu'); ?>
     			
     			<div class="dashboard_detail">
     				<div class="result_search">
			     		<div class='pull-left'><div class="result_search_text">Bar Owner Dashboard</div></div>
			     		<!--<div class='pull-right'><div class="result_search_text"><a href="#userguide" data-toggle="modal" href="javascript://"  class="review mar_r15" >User Guide</a></div></div>-->
			     	<?php if($getbar['bar_type']=='half_mug'){?>
			     		<div class="pull-right marr_10">
		     				<!-- <a href="#" class="review">Upgrade to Full Mug</a> -->
		     				<a class="review" name="" href="<?php echo site_url('home/registration_step3_upgrade/'.base64_encode($getbar['bar_id']).'/fullmug');?>">Upgrade to Full Mug</a>
			       </div>
			       <?php } ?>
			       
			       <?php if(($getbar['bar_type']=='half_mug' || $getbar['bar_type']=='full_mug' && $getbar['is_managed']=='no') ){?>
			     		<div class="pull-right marr_10">
		     				<!-- <a href="#" class="review">Upgrade to Full Mug</a> -->
		     				<a class="review" name="" href="<?php echo site_url('home/registration_step3_upgrade/'.base64_encode($getbar['bar_id']).'/managed');?>">Upgrade to  Managed Account</a>
			       </div>
			       <?php } ?>
			       <div class="clear"></div>
		     		</div>
		     		<div class="dashboard_subblock">
		     			<?php if($getbar['bar_type']=='full_mug'){?>
		     			<div>
		     				<div class="mug_block parrot margin-right-30" style="height: 217px;">
		     					<div class="">
                                                            <a href="<?php echo site_url('bar/list_message')?>">Messages</a>
                                                            <p class="mug_count">
                                                                <a href="<?php echo site_url('bar/list_message')?>"><?php echo $this->home_model->getmessagecount();?></a>
                                                            </p>
<!--                                                            <a href="<?php // echo site_url('bar/comments')?>">Comments</a>
                                                            <p class="mug_count">
                                                                <a href="<?php // echo site_url('bar/comments')?>"><?php // echo '0'; //$this->home_model->getcommentcount();?></a>
                                                            </p>-->
                                                            <a href="<?php echo site_url('bar/postcard')?>">Post Cards</a>
                                                            <p class="mug_count">
                                                                    <a href="<?php echo site_url('bar/postcard')?>"><?php echo $this->home_model->get_bar_postcard_count(@$getbar['bar_id']); ?></a>
                                                            </p>
		     					</div>
		     				</div>
		     				
                                            <div class="mug_block green margin-right-30">
                                                    <a href="<?php echo site_url('bar/bar_beer')?>">Beers</a>
		     					<p class="mug_count">
		     						<a href="<?php echo site_url('bar/bar_beer')?>"><?php echo $this->home_model->countbeer(@$getbar['bar_id']);?></a></p>
		     			<?php // if($getbar['serve_as']=='cocktail'){?>		
                                                        <a href="<?php echo site_url('bar/bar_cocktail')?>">Cocktails</a>
		     					<p class="mug_count">
		     						<a href="<?php echo site_url('bar/bar_cocktail')?>"><?php echo $this->home_model->countcocktail(@$getbar['bar_id']); ?></a></p>
		     			<?php // } ?>		
		     			<?php // if($getbar['serve_as']=='liquor'){?>
                                                        <a href="<?php echo site_url('bar/bar_liquor')?>">Liquors</a>
		     					<p class="mug_count">
		     						<a href="<?php echo site_url('bar/bar_liquor')?>"><?php echo $this->home_model->countliquor(@$getbar['bar_id']); ?></a></p>
		     			<?php // } ?>		
		     				</div>
                                            
		     				<div class="mug_block brown" style="height: 217px;">
		     					<div class="">
		     						Total Visitors
		     						<p class="mug_count"><?php if(get_count_impression(@$getbar['bar_id'])>0) { echo get_count_impression(@$getbar['bar_id']); } else { echo '0'; } ?></p>
		     						Total Impressions
		     						<p class="mug_count"><?php if(get_count_visit(@$getbar['bar_id'])>0) { echo get_count_visit(@$getbar['bar_id']); } else { echo '0'; } ?></p>
		     					
		     					</div>
		     				</div>
		     				<div class="clearfix"></div>
		     			</div> 
		     					     			
		     			<?php } ?>
		     			
		     			<!--<a style="left-padding: 10px;" href="<?php echo site_url('/bar/add_drink')?>" class="btn btn-lg btn-primary marr_10" >Add A Drink To Your Menu</a>--> 	
		     					     			
		     			<div class="result_search margin-top-20">
		     				<h1 class="dashboard_smalltitle pull-left">Bar Information</h1>
		     				 <a href="<?php echo site_url('user/profile/'.base64_encode(get_authenticateUserID()));?>" class="review pull-right" target="_blank">Preview My Profile</a>
		     				 <a href="javascript://" class="review pull-right mar_r15"  onclick="editbarinfo()">Edit Bar Information</a>
		     				
		     				<div class="clearfix"></div>
		     			</div>
		     			<div>
		     			<div id="list_hide">	
		     				<div class="logo_block">
		     					<div id='preview'>

		     					<?php
		          		if($getbar['bar_logo']!="" && file_exists(base_path().'upload/barlogo_thumb/'.@$getbar['bar_logo']))
					{?>
		            	<img class="img-responsive" src="<?php echo base_url()?>/upload/barlogo_thumb/<?php echo $getbar['bar_logo']; ?>" alt="American Dive Bars"/>
		            	<?php }  else {?>
		            		<img class="img-responsive" src="<?php echo base_url()?>upload/barlogo/no_image.png" alt="American Dive Bars"/>	
		            			<?php } ?>
		     					</div>		     					
		     						
		     					<form id="imageform" method="post" enctype="multipart/form-data" action='<?php echo site_url('bar/changebarlogo')?>'>
		     					<div id='imageloadstatus' style='display:none'><img src="<?php echo base_url().getThemeName(); ?>/images/ajax-loader-new.gif" alt="Uploading...."/></div>
								<div id='imageloadbutton'>
								<!-- <input type="file" name="photoimg" id="photoimg" /> -->
								<div class="browse2" id="upload">
									<input type="file" id="photoimg" accept="image/*" class="browse" value="Upload Image" name="photoimg">
								</div>
								
								<input type="hidden" id="prev_bar_logo" name="prev_bar_logo" value="<?php echo @$getbar['bar_logo']; ?>" />
								<input type="hidden" id="bar_id" name="bar_id" value="<?php echo @$getbar['bar_id']; ?>" />
								</div>	
		     					</form>
		     					<div class="clear"></div>
		     					<a class="btn btn-lg btn-primary-2 mar_top15" href="<?php echo site_url('home/changepassword')?>">Change Password</a>
		     					<!-- <a href="#" class="change_text"><i class="strip edit"></i> Change</a> -->
		     				</div>
		     					
		     				
		     				<div class="map_mainblock">
		     					<div class="dashboard_beer_detail">
		     						<ul class="dashboard_list">
		     							<li><span class="marr_10">Bar Type: </span>
		     								 <?php if(@$getbar['bar_type']=='half_mug'){
		     								 	   echo "Half Mug Bar";
		     								 } else if(@$getbar['bar_type']=='full_mug' && $getbar['is_managed']=='no'){
		     								 	    echo "Full Mug Bar";
		     								 } else if(@$getbar['bar_type']=='full_mug' && $getbar['is_managed']=='yes'){
		     								 	echo "Managed Account";
		     								 }?></li>
                                                                        <?php $name = @$getbar['first_name']." ".@$getbar['last_name'];?>
		     							<li><span class="marr_10">Bar Name: </span> <?php echo @$getbar['bar_title']; ?></li>
		     							<li><span class="marr_10">Bar Owner: </span> <?php echo $name; ?></li>
		     							<!--<li><span class="marr_10">Bar Owner First Name: </span> <?php //echo @$getbar['first_name']; ?></li>-->
		     							<!--<li><span class="marr_10">Bar Owner Last Name: </span> <?php //echo @$getbar['last_name']; ?></li>-->
		     							<li><span class="marr_10">Owner Email: </span> <?php echo @$getbar['email']; ?></li>
		     							 									
		     							<!--<li><span class="marr_10">Gender : </span> <?php echo @$getbar['gender']; ?></li>-->
		     							<!-- <li><span class="marr_10">Address : </span> <?php echo @$getbar['address']; ?></li>
		     							<li><span class="marr_10">City : </span> <?php echo @$getbar['city']; ?></li>
		     							<li><span class="marr_10">State : </span> <?php echo @$getbar['state']; ?></li>
		     							<li><span class="marr_10">Zip Code : </span> <?php echo @$getbar['zipcode']; ?></li> -->
		     							
		     							
		     							<!--<li><span class="marr_10">Address: </span> <?php // echo @$getbar['address'].'<br><span class="pull-left" style="margin-left:69px;">'.@$getbar['city'].' , '.@$getbar['state'].' '.@$getbar['zipcode']; ?></span><div class="clearfix"></div></li>-->
		     							<li><span class="marr_10">Address: </span> <?php echo @$getbar['address'].' '.@$getbar['city'].', '.@$getbar['state'].' '.@$getbar['zipcode']; ?></span><div class="clearfix"></div></li>
		     							
		     							<?php if($getbar['phone']){?>
		     							<li><span class="marr_10">Phone: </span> <?php echo @$getbar['phone']; ?></li>
		  								<?php } ?>   
		  									<?php if($getbar['website']){?>
		     							<li><span class="marr_10">Web Site: </span> <?php echo @$getbar['website']; ?></li>
		  								<?php } ?>  
                                                                        <li class="marr_10"><span class="marr_10" style="height: 114px;">Description:</span><p><?php if(strip_tags(strlen($getbar['bar_desc'])>350)){ echo substr(strip_tags($getbar['bar_desc']),0,350).'...<a class="morelink more pull-right" href="javascript://"><i class="strip arrow_down"></i>Show more</a>' ; } else { echo strip_tags($getbar['bar_desc']); } ?></p></li> 
		     						</ul>
		     					</div>
		     					<div class="map_block" id="gmap_marker">
		     						
		     					</div>
		     					<div class="clearfix"></div>
<!--		     					<p class="dashboard_title">Description:</p>
		     					<p class="dashboard_desc"> 
		     						<?php // if(strip_tags(strlen($getbar['bar_desc'])>350)){ echo substr(strip_tags($getbar['bar_desc']),0,350).'...<a class="morelink more pull-right" href="javascript://"><i class="strip arrow_down"></i>Show more</a>' ; } else { echo strip_tags($getbar['bar_desc']); } ?>
		     						</p>-->
		     				</div></div></div>
		     				<div class="clearfix"></div>
		     				
		     				<div id="list_show" style="display: none;" >	
					<div class="text-right" >
     							<a onclick="goto_main()" href="javascript://"  class="btn btn-lg btn-primary marr_10">Back</a>
     						</div>
					<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
					<form name="add_event" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('bar/editinfo'); ?>">
     				<input type="hidden" name="b_id" id="b_id" value="<?php echo @$getbar['bar_id'];?>" />
     				<input type="hidden" name="user_id" id="user_id" value="<?php echo get_authenticateUserID(); ?>" />
	                     <div id="hd_t">
	                     	<div class="padtb mar_top20">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Account #: </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<?php echo @$getalldata->bar_id; ?>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	 <div class="padtb mar_top20">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Bar Name : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" name="bar_title"  class="form-control form-pad" id="bar_title" placeholder="" value="<?php echo @$getalldata->bar_title; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb mar_top20">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Bar Type :  </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<select class="m_wrap wid360 span12 select2 select_box" multiple name="bar_category[]" id="bar_category">
		                           		
																	<?php 
																	
																	//echo $getbar['bar_category'];
																	$bar_category = explode(',', @$getbar['bar_category']);
																	if($get_cat)
																	       {
																	       	  foreach($get_cat as $row)
																			  {  
																			  	if(!empty($bar_category))
																				{ ?>
																				<option <?php echo in_array($row->bar_category_id, $bar_category) ? 'selected':''; ?> value="<?php echo $row->bar_category_id; ?>"><?php echo $row->bar_category_name; ?></option>	
																			<?php	}
																				else { 																			  	?>
																			  	 <option value="<?php echo $row->bar_category_id; ?>"><?php echo $row->bar_category_name; ?></option>
																			  	 
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
	        				 		<label class="control-label">First Name : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" name="first_name" id="first_name" value="<?php echo @$getalldata->first_name; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Last Name : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="last_name" name="last_name" value="<?php echo @$getalldata->last_name; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Email : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="email" name="email" value="<?php echo @$getalldata->email; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Address : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<textarea rows="3" placeholder="Address" name="address" id="address" class="form-control form-pad"><?php echo @$getalldata->address; ?></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Description :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<textarea rows="10" placeholder="Description" name="desc" id="desc" class="form-control form-pad"><?php echo @$getalldata->bar_desc; ?></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">City : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="city" name="city" value="<?php echo @$getalldata->city; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">State : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7" >
	                           		<input type="text" class="form-control form-pad" id="state" name="state" value="<?php echo @$getalldata->state; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Zip Code : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="zip" name="zip" value="<?php echo @$getalldata->zipcode; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Phone  : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7" >
	                           		<input type="text" class="form-control form-pad" id="phone" name="phone" value="<?php echo @$getalldata->phone; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Website : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7" >
	                           		<input type="text" class="form-control form-pad" id="website" name="website" value="<?php echo @$getalldata->website; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<?php if($getbar['bar_type']=='full_mug'){?>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Bar Video Link : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7" >
	                           		<input type="text" class="form-control form-pad" id="bar_video_link" name="bar_video_link" value="<?php echo @$getalldata->bar_video_link; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<?php } ?>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">User Image : </label>
	        				 	</div>
	                       		<div class="input_box upload_btn">
	                           		<input type="file" class="form-control form-pad" id="user_image" name="user_image">
	                           		<input type="hidden" name="prev_user_image" id="prev_user_image" value="<?php echo @$getalldata->profile_image; ?>" />
	                       		</div>
	                       		
	                       		<div class="input_box upload_user">
	                           		<img src="" id="img_here" alt="" class="img-responsive" height="60" width="60"/>
	                       		</div>
	                       		<!-- <div class="input_box pull-left">
	                           		<button type="submit" class="btn btn-lg btn-primary " href="#">Upload</button> 
	                       		</div> -->
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Payment Types : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7 text-left padt5">
	                           		<label for="checkbox-01" class="radio-checkbox label_radio marr_10 r_on"><input type="checkbox" value="1" <?php if($getalldata->cash_p==1){ echo "checked"; }?> name="cash_p" id="cash_p" > <i class="strip small-cash"></i></label>
	                           		<label for="checkbox-02" class="radio-checkbox label_radio"><input type="checkbox" value="1"  <?php if($getalldata->master_p==1){ echo "checked"; }?> name="master_p" id="master_p" > <i class="strip small-master-card"></i></label>
	                           		<label for="checkbox-03" class="radio-checkbox label_radio"><input type="checkbox" value="1"  <?php if($getalldata->american_p==1){ echo "checked"; }?> name="american_p" id="american_p" > <i class="strip small-american-express"></i></label>
	                           		<label for="checkbox-04" class="radio-checkbox label_radio"><input type="checkbox" value="1"  <?php if($getalldata->visa_p==1){ echo "checked"; }?> name="visa_p" id="visa_p" > <i class="strip small-visa"></i></label>
	                           		<label for="checkbox-05" class="radio-checkbox label_radio"><input type="checkbox" value="1"  <?php if($getalldata->paypal_p==1){ echo "checked"; }?> name="paypal_p" id="paypal_p" > <i class="strip small-payapl"></i></label>
	                           		<label for="checkbox-06" class="radio-checkbox label_radio"><input type="checkbox" value="1"  <?php if($getalldata->bitcoin_p==1){ echo "checked"; }?> name="bitcoin_p" id="bitcoin_p" > <i class="strip small-bit-coin"></i></label>
	                           		<label for="checkbox-07" class="radio-checkbox label_radio"><input type="checkbox" value="1"  <?php if($getalldata->apple_p==1){ echo "checked"; }?> name="apple_p" id="apple_p" > <i class="strip small-apple-pay"></i></label>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
<!--	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Serve As : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7 text-left padt5">
	                           		<label style="font-size: 20px;" for="radio-01" class="radio-checkbox label_radio marr_10 r_on"><input type="radio" value="cocktail" <?php // if($getalldata->serve_as=='cocktail'){ echo "checked"; }?> name="serve_as" id="serve_as_c" > Cocktail</label>
	                           		<label style="font-size: 20px;" for="radio-02" class="radio-checkbox label_radio"><input type="radio" value="liquor"  <?php // if($getalldata->serve_as=='liquor'){ echo "checked"; }?> name="serve_as" id="serve_as_l" > Liquor</label>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div> -->
	                       	
	                       	
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Meta Title : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		 <input type="text" class="form-control form-pad" id="bar_meta_title" name="bar_meta_title" value="<?php echo @$getalldata->bar_meta_title!='' && @$getalldata->bar_meta_title!='0' ? @$getalldata->bar_meta_title:'' ; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Meta Keyword : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="bar_meta_keyword" name="bar_meta_keyword" value="<?php echo @$getalldata->bar_meta_keyword!='' && @$getalldata->bar_meta_keyword!='0' ? @$getalldata->bar_meta_keyword:'' ; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Meta Description :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<textarea rows="5" placeholder="Description" name="bar_meta_description" id="bar_meta_description" class="form-control form-pad"><?php echo @$getalldata->bar_meta_description!='' && @$getalldata->bar_meta_description!='0' ? @$getalldata->bar_meta_description:'' ; ?></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
                                 <div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Facebook Account (ex. "americanbars"):</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="facebook_link" name="facebook_link" value="<?php echo @$getalldata->facebook_link;?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Twitter Account (ex. "americanbars"):</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="twitter_link" name="twitter_link" value="<?php echo @$getalldata->twitter_link;?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Instagram Account (e.x americanbars) :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="instagram_link" name="instagram_link" value="<?php echo @$getalldata->instagram_link;?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       </div>	
	                       		
	                       		<div class="padtb bar-timeblock">
	                       		<div class="table-responsive margin-top-30">
									<table cellspacing="10" class="table">
		                       			<thead>
		                       				<tr><th>Day</th>
		                       				<th width="25%;">Bar Open Time</th>
		                       				<!-- <th></th> -->
		                       				<th width="25%;">Bar close Time</th>
		                       				<!-- <th></th> -->
		                       				<th>Action</th>
		                       			</tr></thead>
		                       			<tbody>
		                       			<?php $i = 1;
								if($one_user){
								foreach($one_user as $os){
									?>	
		                       				
		                       				<tr>
		                       					<input type="hidden" name="pre_img[]" value="<?php echo $os->days ?>" />
												<input type="hidden" name="image_id[]" value="<?php echo $os->days_id ?>" />
		                       					<td><?php echo $os->days;?></td>
		                       					<input type="hidden" name="days_id[]" id="days_id<?php echo $i; ?>" value="<?php echo $os->days_id; ?>" />
		                       					<td><input type="text" value="<?php echo $os->start_from; ?>" style="width: 80%;" class="timepicker-default  form-control" name="from_<?php echo $i; ?>" id="from_<?php echo $i; ?>"> <i class="icon-time add-on"></i>
		                       						<span for="from_<?php echo $i; ?>" style="display: none;" class="help-inline">To must be greater than from</span>
		                       					</td>
		                       					<!-- <td><i class="icon-time add-on"></i></td> -->
		                       					<td><input value="<?php echo $os->start_to; ?>" type="text" style="width: 80%;" class="timepicker-default form-control" name="to_<?php echo $i; ?>" id="to_<?php echo $i; ?>"> <i class="icon-time add-on"></i>
		                       						<span for="to_<?php echo $i; ?>" style="display: none;" class="help-inline">To must be greater than from</span>
		                       					</td>
		                       					
												
		                       					<!-- <td><i class="icon-time add-on"></i></td> -->
		                       					
		                       					<td>
		                       						<label for="checkbox-03" class="radio-checkbox label_check padr5"><input type="checkbox" value="yes" id="closed_<?php echo $i; ?>" name="closed_<?php echo $i; ?>" <?php if($os->is_closed == 'yes'){ ?> checked = "chedked"<?php }?>>Closed</label>
		                       						<?php
										if($i==1){?>
		                       						<label for="checkbox-04" class="radio-checkbox label_check"><input type="checkbox"  id="aply_to_all" name="aply_to_all">Apply To All</label>
		                       						<?php } ?>
		                       					</td>
		                       				</tr>
		                       		<?php $i++;}
								}else{
		                       		$first_h = first_hours();
								$i=1;
								foreach($first_h as $os){ ?>		
		                       				
		                       				<tr>
		                       					<td><?php echo $os->days;?></td>
		                       					<input type="hidden" name="days_id[]" id="days_id<?php echo $i; ?>" value="<?php echo $os->days_id; ?>" />
		                       					<td><input type="text" style="width: 80%;" class="timepicker-default  form-control" name="from_<?php echo $i; ?>" id="from_<?php echo $i; ?>"> <i class="icon-time add-on"></i>
		                       						<span for="from_<?php echo $i; ?>" style="display: none;" class="help-inline">To must be greater than from</span>
		                       					</td>
		                       					<!-- <td><i class="icon-time add-on"></i></td> -->
		                       					<td><input type="text" style="width: 80%;" class="timepicker-default form-control" name="to_<?php echo $i; ?>" id="to_<?php echo $i; ?>"> <i class="icon-time add-on"></i>
		                       						<span for="to_<?php echo $i; ?>" style="display: none;" class="help-inline">To must be greater than from</span>
		                       					</td>
		                       					<!-- <td><i class="icon-time add-on"></i></td> -->
		                       					
		                       					<td>
		                       						<label for="checkbox-03" class="radio-checkbox label_check padr5"><input type="checkbox" value="yes" id="closed_<?php echo $i; ?>" name="closed_<?php echo $i; ?>">Closed</label>
		                       						<?php
										if($i==1){?>
		                       						<label for="checkbox-04" class="radio-checkbox label_check"><input type="checkbox"  id="aply_to_all" name="aply_to_all">Apply To All</label>
		                       						<?php } ?>
		                       					</td>
		                       				</tr>
		                       	<?php $i = $i + 1;	} } ?>			
		                       				
		                       			</tbody>
		                       		</table>
		                       		
		                       		<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10 text-left">
	                       			<br>
	                       			<button type="submit" class="btn btn-lg btn-primary marr_10" >Save Changes</button>
	                       			<a href="<?php echo site_url('home/dashboard')?>" class="btn btn-lg btn-primary marr_10" >Cancel Changes</a> 
	                       			<!-- <a class="btn btn-lg btn-primary marr_10" onclick="goto_main();">Cancel</a> -->
	                       			<!-- <a  class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('home/dashboard');?>" >Cancel</a> -->
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       		</div>
	                       	</div>
	                       		
	                       	
	                       	<div class="clearfix"></div>
	        			</form>
     			</div>
     			
                        <?php if($getbar['bar_type'] == 'half_mug') { ?>
                            <!--<a href="<?php // echo site_url('bar/bar_gallery')?>"  class="btn btn-lg btn-primary pull-right disabled">Create New Album</a><div class="clear"></div>-->

                        <?php } else { ?>
                                                <a href="<?php echo site_url('bar/bar_gallery')?>"  class="btn btn-lg btn-primary pull-right padtb10">Create New Album</a><div class="clear"></div>

                        <?php } ?>
		     		<?php if($albumgallery){
		     			foreach($albumgallery as $album){	?>	
		     		 <div class="result_search margin-top-20">
		     				<h1 class="dashboard_smalltitle pull-left">Album : <?php echo $album->title;?></h1>
		     				<div class="pull-right">
		     					<ul class="social_icon pull-left">
     						<li>Share : </li>
						   <li><a href="javascript://" onclick="fbShare()" ><img src="<?php echo base_url().'default'?>/images/result_fb.png"></a></li>
						    <li><a onclick="twShare()" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_twitt.png"></a></li>
						    <li><a onclick="gPlusShare1('<?php echo site_url('user/profile/'.base64_encode($getalldata->user_id)); ?>','<?php echo $getalldata->first_name." ".$getalldata->last_name; ?>')" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_google.png"></a></li>
						    <li><a onclick="inShare()" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_linkln.png"></a></li>
						    
						    <div class="clearfix"></div>
		    		 	</ul>
     						
     					</div>
		     				 <!-- <a href="javascript://"  onclick="editbarinfo()"><i class="strip edit pull-right"></i></a> -->
		     				<div class="clearfix"></div>
		     		</div>		
		     		<ul class="bxslider">
		     		<?php $getimages = getalbumimage1($album->bar_gallery_id);
						if($getimages){
						foreach($getimages as $rows){
						?>	
		     			<li>
		     					<a title="<?php echo $album->title;?>" class="fancybox" href="<?php echo base_url().'upload/bar_gallery_orig/'.$rows->bar_image_name;?>"><img src="<?php echo base_url().'upload/bar_gallery_thumb_big/'.$rows->bar_image_name;?>" /></a>
                       </li>
					  	<?php } }  ?>
					  </ul>	<div class="clearfix"></div>
					<?php } } ?>
		     			<div class="margin-top-30">
                                            <div class="full_mugblock margin-right-30">
                                                    <div class="img_br_yellow height-515">
                                                        <h1 class="productbar_title">Latest Comments
                                                            <small><a class="pull-right" href="<?php echo site_url('bar/comments')?>">See All</a></small>
                                                        </h1>

                                                        <ul class="latest_block_list" >
                                                                <?php if($result){
                                                          foreach($result as $comment){?>
                                                        <li>
                                                                <div class="reult_sub_title "><a target="_blank" href="<?php echo site_url('user/profile/'.base64_encode($comment->user_id))?>" class="bar_title"><?php echo $comment->comment_title; ?></a></div>
                                                                <div class="rating_box"><a class="bar_title"><?php echo getDuration($comment->date_added); ?></a></div>
                                                                <div class="clearfix"></div>
                                                                <p class="result_desc"><?php if(strlen($comment->comment)>55) { echo substr($comment->comment,0,55)."..."; } else { echo $comment->comment; }?></p>
                                                                <div class="reult_sub_title wdth-74"><p class="review_light pull-left"><?php echo $comment->first_name." ".$comment->last_name;?></p></div>
                                                                <div class="rating_box starrating<?php echo $comment->bar_rating; ?>"><a href="javascript"></a></div>
                                                                <div class="clearfix"></div>
                                                        </li>
                                                <?php } ?>
                                                                        <?php if($result){ ?>	<div class="text-right pad_lr10 padtb10">
                                                                        <a href="<?php echo site_url('bar/comments');?>" class="">View More</a>
                                                                </div>
                                                  <?php } ?>	
                                                                        <?php } else {?>

                                                                                <li>
                                                                                        No comments found.
                                                                                </li>
                                                                <?php } ?>			  
                                                        </ul>

                                                    </div>
                                            </div>
                                            <?php if ($getbar['bar_type']=='full_mug') {?>
                                            <div class="full_mugblock">
			     				<div class="img_br_yellow height-515">
		     						<h1 class="productbar_title">Latest Messages
                                                                    <small><a class="pull-right" href="<?php echo site_url('bar/list_message')?>">See All</a></small>
                                                                </h1>
		     						<ul class="latest_block_list">
		     							<?php if($resultmessage){
			     					  foreach($resultmessage as $msg){?>
				     				<li>
				     					<div class="reult_sub_title "><a target="_blank" href="<?php echo site_url('bar/viewconversation/'.base64_encode($msg->master_message_id))?>" class="bar_title"><?php if(strlen($msg->subject)>35) { echo substr($msg->subject,0,35).'...'; } else { echo $msg->subject;} ?></a></div>
				     					<div class="rating_box"><a class="bar_title"><?php echo getDuration($msg->date_added); ?></a></div>
				     					<div class="clearfix"></div>
				     					<div class="clearfix"></div>
				     					<p class="result_desc"><?php if(strlen($msg->description)>197) { echo substr($msg->description,0,197)."..."; } else { echo $msg->description; }?></p>
				     					
				     				</li>
			     				<?php } ?>
										<?php if($result){ ?>	<div class="text-right pad_lr10 padtb10">
		     								<a href="<?php echo site_url('bar/list_message');?>" class="">View More</a>
		     							</div>
		     					  <?php } ?>	
										<?php } else  {?>
											
											<li>
												No messages found.
											</li>
									<?php } ?>	
		     							
		     						</ul>
								</div>
			     			</div>
                                        <?php } ?>
			     			<div class="clearfix"></div>
		     			</div>
		     			<div class="margin-top-30">
		     			<?php if ($getbar['bar_type']=='full_mug') {?>
		     				<div class="full_mugblock margin-right-30">
			     				<div class="img_br_yellow height-515">
		     						<h1 class="productbar_title">Latest Post Cards
                                                                    <small><a class="pull-right" href="<?php echo site_url('bar/postcard')?>">See All</a></small>
                                                                </h1>
		     						<ul class="latest_block_list">
		     							<?php if($getpostcard){
		     								   foreach($getpostcard as $card) { ?>
		     							<li>
		     								<a href="<?php echo site_url('bar/postcard');?>"><?php echo ucfirst($card->post_title); ?></a>
		     								<p class="latest_date"><?php echo date("j F",strtotime($card->date_added));?></p>
		     								<div class="clearfix"></div>
		     								<?php if(strlen($card->post_message)>197){ echo substr($card->post_message,0,197).'...';  } else { echo $card->post_message; }  ?>
		     							</li>
		     							<?php } } else {?>
		     								<li>
		     								No postcards found.
		     								</li>
		     								<?php }?>
		     							
		     						<?php if($getpostcard){ ?>	<div class="text-right pad_lr10 padtb10">
		     								<a href="<?php echo site_url('bar/postcard');?>" class="">View More</a>
		     							</div>
		     					  <?php } ?>		
		     						</ul>
								</div>
			     			</div>
                                            <?php } ?>
			     			<div class="clearfix"></div>
		     			</div>
		     		</div>
     			</div>
     			<div class="clearfix"></div>
     		</div>
   		</div>
   	</div>
<!--------------Scroll ------------------->
	<link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/css/prettify.css">
	<script src="<?php echo base_url().getThemeName(); ?>/js/jquery.slimscroll.js"></script>
	<script src="<?php echo base_url().getThemeName(); ?>/js/prettify.js"></script>
	<script type="text/javascript">
		$(function(){
		      $('#infinite-list-comment').slimscroll({
		        alwaysVisible: true,
		        height: 380,
		        color: '#f19d12',
		        opacity: .8
		      });
		      
		
		  });
	</script>
	<!--------------End Scroll ------------------->
<style>
 #infinite-list-comment {
    height: 380px;
    margin-left: auto;
    margin-right: auto;
    overflow-x: hidden;
    overflow-y: scroll;
}
</style>	

	
<!-- <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> -->
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>

<?php $theme_url = $urls= base_url().getThemeName();?>
<script>
	var base_url_comment = '<?php echo site_url('home/getmorecomment/?bar_id='.$getbar['bar_id']); ?>';
</script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/rating.js"></script>

<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.easing.1.3.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/js/rating.css" />
 <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/infiniteScroll.js"></script>
 
 <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js" ></script>
<link href="<?php echo base_url().getThemeName(); ?>/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<script src="<?php echo base_url().getThemeName(); ?>/assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>   
<script src="<?php echo base_url().getThemeName(); ?>/assets/scripts/app.js"></script>  
<script src="<?php echo base_url().getThemeName(); ?>/assets/scripts/gallery.js"></script>

 <script type="text/javascript"> InfiniteList.loadData_comment(0,15);</script>
   	<script type="text/javascript">
   	 $(document).ready(function() { 
		   $("#phone").inputmask("(999) 999-9999");
	});
  var geocoder;
  var map;
  var address ="<?php echo @mysql_real_escape_string($getbar['address'])." ".@$getbar['city']." ".@$getbar['zipcode']." ".@$getbar['state'];?>";
  function initialize_map() 
  {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var myOptions = {
      zoom: 17,
      center: latlng,
    mapTypeControl: true,
    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
    navigationControl: true,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("gmap_marker"), myOptions);
    if (geocoder) {
      geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
          map.setCenter(results[0].geometry.location);

            var infowindow = new google.maps.InfoWindow(
                { content: '<b>'+address+'</b>',
                  size: new google.maps.Size(150,50)
                });

            var marker = new google.maps.Marker({
                position: results[0].geometry.location,
                map: map, 
                title:address
            }); 
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map,marker);
            });

          } 
         }
      });
    }
    
  // }
    function editbarevent(id)
 {
 		
 	 $.ajax({
	       type: "POST",
		   url: "<?php echo site_url('bar/bareventdetail')?>",
		   data : {id:id},
		   dataType : 'JSON',
		   success: function(response) {
		   
		      $("#event_id").val(response.event_id);
		      $("#event_title").val(response.event_title);
		      $("#event_desc").val(response.event_desc);
		      $("#start_date").val(response.start_date);
		      $("#end_date").val(response.end_date);
		      $("#address").val(response.address);
		      $("#city").val(response.city);
		      $("#state").val(response.state);
		      $("#phone").val(response.phone);
		      $("#zipcode").val(response.zipcode);
		      $("#event_video_link").val(response.event_video_link);
		      $("#is_power_boost_event").val(response.is_power_boost_event);
		      $("#status").val(response.status);
		      $("#prev_event_image").val(response.event_image);
		      $("#prev_event_video").val(response.event_video);
		      
		      if(response.event_video!='')
		      {
		      		 var src_vid = '<?php echo base_url().'upload/event_video/'?>';
		      	     var htm = '<a href="'+src_vid+response.event_video+'" id="video_add" class="image_play fancybox-video">'+response.event_video+'</a>';
		      	   //  $("#video_add").attr("href", src_vid+response.event_video);
		      		 $("#prev_event_video_htm").html(htm);
			  }
		     
		      if(response.event_image!='')
		      {
		      		var src1 = '<?php echo base_url().'upload/event_thumb/'?>';
					$("#img_here").attr("src", src1+response.event_image);
			 }
		      $("#list_hide").slideUp();
	    	$("#list_hide_m").slideUp();
	    	$("#hd_del").slideUp();
	    	$("#hs_del").slideDown();
	    	
	    	$('#list_show').slideDown();
	    	bindJquery();
		     
		  }
	   });
 }
  }
  
  function go_next()
  {
  	// $('#see_time').animate({scrollTop: 0});
  	
  	 $("#see_time").slideDown('slow',function(){ scrollToDiv('see_time'); });
  	 $("#hd_t").slideUp();
  }
   function go_prev()
  {
  	 $("#see_time").slideUp();
  	 $("#hd_t").slideDown();
  }
  function editbarinfo()
  {  
  	$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
  	  	$("#hd_t").slideDown();
	    	$("#see_time").hide();
  		
 		  $("#list_hide").slideUp();
	    	$("#list_hide_m").slideUp();
	    	$("#hd_del").slideUp();
	    	
	    	$("#hs_del").slideDown();
	    	
	    	$('#list_show').slideDown();
 	 $.ajax({
	       type: "POST",
		   url: "<?php  echo site_url('bar/getbarinfo')?>",
		   dataType : 'JSON',
		   beforeSend : function() {
		   		$('#dvLoading').fadeIn('slow');
		   },
		    complete : function() {
		   		$('#dvLoading').fadeOut('slow');
		   },		
		   success: function(response) {
		   	CKEDITOR.config.forcePasteAsPlainText = true;
		     if(response.profile_image!='')
		      {
		      		var src1 = '<?php echo base_url().'upload/user_thumb/'?>';
					$("#img_here").attr("src", src1+response.profile_image);
					
			  }
		     
		  }
	   });
 }
 
   $(document).ready(function(){
    
   		$('.').bxSlider({
   		    auto: false,
            autoControls: true
            //infiniteLoop: false,
            //hideControlOnEnd: true,
            //minSlides: 1,
            //maxSlides: 3,
            //slideWidth: 300,
            //slideMargin: 10
        });
		   // initiate layout and plugins
		   Gallery.init();
   	 $('#form').on('submit', function() {
        	
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            });
        $('#form').validate(
		{
		rules: {
			
			      user_image:
			      {
			      		accept: "jpg|jpeg|png|bmp",
			      },
					
					bar_title: {
						required: true,
					},
					first_name: {
						required: true,
					},
					address: {
						required: true,
					},
					city: {
						required: true,
					},
					zipcode: {
						required: true,
						number: true,
					},
					last_name: {
						required: true,
					},
					website: {
						url:true,
					},
					bar_video_link: {
						url:true,
					},
					
					email: { required: true },
					desc: { required: true },
					/*to_1: {required: function(){  return $('#closed_1').is(":checked")==true?false:true;  }},

                    from_1: {required: function(){ return (!$('#closed_1').is(":checked")); }},

                    to_2: {required: function(){ return (!$('#closed_2').is(":checked")); }},

                    from_2: {required: function(){ return (!$('#closed_2').is(":checked")); }},

                    to_3: {required: function(){ return (!$('#closed_3').is(":checked")); }},

                    from_3: {required: function(){ return (!$('#closed_3').is(":checked")); }},

                    to_4: {required: function(){ return (!$('#closed_4').is(":checked")); }},

                    from_4: {required: function(){ return (!$('#closed_4').is(":checked")); }},

                    to_5: {required: function(){ return (!$('#closed_5').is(":checked")); }},

                    from_5: {required: function(){ return (!$('#closed_5').is(":checked")); }},

                    to_6: {required: function(){ return (!$('#closed_6').is(":checked")); }},

                    from_6: {required: function(){ return (!$('#closed_6').is(":checked")); }},

                    to_7: {required: function(){ return (!$('#closed_7').is(":checked")); }},

                    from_7: {required: function(){ return (!$('#closed_7').is(":checked")); }},
					
					// to_1: {						
						// required: function(){ return (!$('#closed_1').is(":checked")); },
						// greaterThan: '#from_1'
					// },
					// to_2: {
						// required: function(){ return (!$('#closed_2').is(":checked")); },
					  	// greaterThan: '#from_2'
					// },
					// to_3: {
						// required: function(){ return (!$('#closed_3').is(":checked")); },
					  	// greaterThan: '#from_3'
					// },
					// to_4: {
						// required: function(){ return (!$('#closed_4').is(":checked")); },
					  	// greaterThan: '#from_4'
					// },
					// to_5: {
						// required: function(){ return (!$('#closed_5').is(":checked")); },
					  	// greaterThan: '#from_5'
					// },
					// to_6: {
						// required: function(){ return (!$('#closed_6').is(":checked")); },
					  	// greaterThan: '#from_6'
					// },
					// to_7: {
						// required: function(){ return (!$('#closed_7').is(":checked")); },
					  	// greaterThan: '#from_7'
					// },*/
					state: {
						required: true,
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
						$("#cm-err-main1").html(json.comment_error);
			    		$('#dvLoading').fadeOut('slow');
			    		scrollToDivmore('dashboard_subblock');
				  		// setTimeout(function () 
						// {
						      // $("#cm-err-main1").fadeOut('slow');
						// }, 3000);
					return false;
					}
			
					else
					{
						if($("#cash_p").val()==0)
						{
							$("#cash_p").val(1)
						}
						else
						{
							$("#cash_p").val(0)
						}
						
						if($("#master_p").val()==0)
						{
							$("#master_p").val(1)
						}
						else
						{
							$("#master_p").val(0)
						}
						
						if($("#american_p").val()==0)
						{
							$("#american_p").val(1)
						}
						else
						{
							$("#american_p").val(0)
						}
						if($("#visa_p").val()==0)
						{
							$("#visa_p").val(1)
						}
						else
						{
							$("#visa_p").val(0)
						}
						if($("#paypal_p").val()==0)
						{
							$("#paypal_p").val(1)
						}
						else
						{
							$("#paypal_p").val(0)
						}
						
						if($("#bitcoin_p").val()==0)
						{
							$("#bitcoin_p").val(1)
						}
						else
						{
							$("#bitcoin_p").val(0)
						}
						if($("#apple_p").val()==0)
						{
							$("#apple_p").val(1)
						}
						else
						{
							$("#apple_p").val(0)
						}
						//alert("sdsa");
						$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
						
						$.growlUI('Your profile updated successfully .');
						//alert($('#serve_as').val());
						if($('#serve_as_l').is(":checked")==true)
					{
						$("#ck_hide").addClass("gray_bg");
						$("#lq_hide").removeClass("gray_bg");
					}
					else
					{
						$("#ck_hide").removeClass("gray_bg");
						$("#lq_hide").addClass("gray_bg");
					}
					 	// $("#list_hide").slideDown();
					 	 $("#list_hide_m").slideDown();
					     $("#hd_del").slideDown();
					     $("#hs_del").slideUp();
					     $('#list_show').slideUp();
					     $("#at_ajax").remove();
					     getData();
					     scrollToDivmore('dashboard_subblock');
					}
					$('#dvLoading').fadeOut('slow');
		   		 }
		    });
		  }
		})
		
		
    });
  
    function getData()
    {
    	var id = '<?php echo @$getbar['bar_id']; ?>';
    	 $.ajax({
	       type: "POST",
		   url: "<?php echo site_url('bar/getbardata')?>",
		   data : {id:id},
		     beforeSend : function() {
		   		$('#dvLoading').fadeIn('slow');
		   },
		    complete : function() {
		   		$('#dvLoading').fadeOut('slow');
		   },		
		   success: function(response) {
		   	//alert('response');
		   	//alert(response);
		   	 $('#list_hide').empty();
		   	 $("#list_hide").slideDown();
		     $('#list_hide').html(response);
		    
		     initialize_map();
		  }
	   });
    }
    function goto_main()
    {   
    	
    	
    	$("#event_id").val('');
    	// $(':input','#form')
					 	// .not(':button, :submit, :reset, :hidden')
					 	// .val('')
					 	// //.removeAttr('checked')
					 	// .removeAttr('selected');
		$("#img_here").removeAttr('src');			 	
    	$("#list_hide").slideDown();
    	$("#list_hide_m").slideDown();
    	$("#hd_t").slideDown();
    	$("#see_time").slideUp();
    	$("#hd_del").slideDown();
    	$("#hs_del").slideUp();
    	$('#list_show').slideUp();
    }
</script>




<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/new-timepicker.css" />
				<link href="<?php echo base_url().getThemeName(); ?>/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/new-bootstrap-timepicker.js"></script>
<script>
		jQuery(document).ready(function() {       
		   // initiate layout and plugins
		   	
			$('#aply_to_all').click(function(){
				var apy2all = $('#aply_to_all').prop('checked');
				if(apy2all==true){
				// APPLY FROM TIME TO ALL
					$('#from_2').val($('#from_1').val());
					$('#from_3').val($('#from_1').val());
					$('#from_4').val($('#from_1').val());
					$('#from_5').val($('#from_1').val());
					$('#from_6').val($('#from_1').val());
					$('#from_7').val($('#from_1').val());
					
				// APPLY TO TIME TO ALL
					$('#to_2').val($('#to_1').val());
					$('#to_3').val($('#to_1').val());
					$('#to_4').val($('#to_1').val());
					$('#to_5').val($('#to_1').val());
					$('#to_6').val($('#to_1').val());
					$('#to_7').val($('#to_1').val());
					
					var k =2;
					for(k=2;k<=7;k++){
						var chck = $('#closed_'+k);
						var flg =chck.prop('checked');
						if(flg==true){
							chck.attr('checked', false);
							chck.parent('label').removeClass('c_on');
						}
					}
				}
				else{
					$('#from_2').val('');
					$('#from_3').val('');
					$('#from_4').val('');
					$('#from_5').val('');
					$('#from_6').val('');
					$('#from_7').val('');
					
				// APPLY TO TIME TO ALL
					$('#to_2').val('');
					$('#to_3').val('');
					$('#to_4').val('');
					$('#to_5').val('');
					$('#to_6').val('');
					$('#to_7').val('');
					
					$('#closed_2').prop('checked', true);
					$('#closed_3').prop('checked', true);
					$('#closed_4').prop('checked', true);
					$('#closed_5').prop('checked', true);
					$('#closed_6').prop('checked', true);
					$('#closed_7').prop('checked', true);
				}				
			});
			
			
		//	$('#closed_6').prop('checked', true);
		//	$('#closed_7').prop('checked', true);
		 for(var i=1;i<=7;i++){
		   		jQuery('#from_'+i).change(function(){
					//alert($(this).parent().html());
					var cb = $(this).attr('id').split('_');
					var fchker = $(this).attr('id');
					
					/*if(fchker =='from_1'){
						$('#from_2').val($(this).val());
						$('#from_3').val($(this).val());
						$('#from_4').val($(this).val());
						$('#from_5').val($(this).val());
					}*/
					var chck = $('#closed_'+cb[1]);
					var flg =chck.prop('checked');
					if(flg==true){
						chck.attr('checked', false);
						chck.parent('label').removeClass('c_on');
					}
				  /*var cnts = $('#closed_2').prop('checked');
					if(cnts == true){
						$('#closed_2').attr('checked', false);
						$('#closed_2').parent('label').removeClass('c_on');
					}*/
				});
				jQuery('#to_'+i).change(function(){
					//alert($(this).parent().html());
					var cb = $(this).attr('id').split('_');
					var fchker2 = $(this).attr('id');
					
					/*if(fchker2 =='to_1'){
						$('#to_2').val($(this).val());
						$('#to_3').val($(this).val());
						$('#to_4').val($(this).val());
						$('#to_5').val($(this).val());
					}*/
					var chck = $('#closed_'+cb[1]);
					var flg =chck.prop('checked');
					if(flg==true){
						chck.attr('checked', false);
						chck.parent('label').removeClass('c_on');
					}				  
				});
		}
	
		  // App.init();
		  // FormComponents.init();
		       $('.timepicker-default').timepicker({
        maxMinutes: 15,
               // defaultTime : false

            });
		});
	</script>
	
<script type="text/javascript">

jQuery(document).ready(function() {

	$.validator.addMethod("greaterThan",
	function (value, element, param) {
	  var $min = $(param);
	  var cb = $($min).attr('id').split('_');
	  var chck = $('#closed_'+cb[1]);
    var flg =chck.prop('checked');
//alert('to_'+cb[1]+' =>'+'from_'+cb[1])
var starttime =  $("#from_"+cb[1]).val();
var endtime = $("#to_"+cb[1]).val();
//alert(starttime+' '+endtime);

	 if (this.settings.onfocusout) {
		$min.off(".validate-greaterThan").on("blur.validate-greaterThan", function () {
		  $(element).valid();
		});
	  }
	  if(flg==true){	 
	  	return true;
	  }
	  else{
	if(starttime!="" && endtime!=""){
		//alert("Dsad");
							var time1 = starttime;
							var hrs1 = Number(time1.match(/^(\d+)/)[1]);		
							var mnts1 = Number(time1.match(/:(\d+)/)[1]);
							var res1 = time1.split(" ");		
							var splitstr1=res1[1];					
							var format1 = splitstr1;					
							if (format1 == "PM" && hrs1 < 12) hrs1 = hrs1 + 12;
							if (format1 == "AM" && hrs1 == 12) hrs1 = hrs1 - 12;
							var hours1 = hrs1.toString();
							var minutes1 = mnts1.toString();
							if (hrs1 < 10) hours1 = "0" + hours1;
							if (mnts1 < 10) minutes1 = "0" + minutes1;							
													
//To Time
								var time = endtime;
								var hrs = Number(time.match(/^(\d+)/)[1]);		
								var mnts = Number(time.match(/:(\d+)/)[1]);
								var res = time.split(" ");		
								var splitstr=res[1];					
								var format = splitstr;					
								if (format == "PM" && hrs < 12) hrs = hrs + 12;
								if (format == "AM" && hrs == 12) hrs = hrs - 12;
								var hours = hrs.toString();
								var minutes = mnts.toString();
								if (hrs < 10) hours = "0" + hours;
								if (mnts < 10) minutes = "0" + minutes;
								if(hours1 != hours)
								{
									if(hours1 >= hours && format1 == format)
									{
										return false;
									}
								}
								else
								{
									if(minutes1 >= minutes)
									{
										return false;
									}
									
								}
		return true;
	}
	else{
		return false;
	}
			
		
		
	  	/* if(starttime < endtime){
		 	return true;
		 }
		 else{
		 	return false;
		 }*/
	 // return parseInt(value) > parseInt($min.val());
	  }
	 // alert(parseInt(value) > parseInt($min.val()))
	}, "To must be greater than from");



	
	$("input[type=checkbox]").click(function(){
		var get_ckid = $(this).attr('id');
		var curchk_val = $('#'+get_ckid).is(':checked');
		var imgchk = get_ckid.split("_");
		if(curchk_val == true){
			$('#from_'+imgchk[1]).val("");
			$('#to_'+imgchk[1]).val("");
		}		
	});
});		

</script>

<div class="modal fade" id="myModalnew_open" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Description</div>
     				</div>
     				<div class="pad20">
     						<label class="control-label" style="color: #fff;"><?php echo $getbar['bar_desc']; ?></label>	
     				</div>		
     			</div>
     		</div>
     	</div>
     </div>
	
</div>     

<script type="text/javascript">
  var image =    $(".fancybox-image").attr('src');
function fbShare(){
	    window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('<?php echo site_url('user/profile/'.base64_encode($getalldata->user_id)); ?>'),'facebook-share-dialog','width=626,height=436');
        return false;
}

function fbshare_popup()
{
	  var image = $(".fancybox-image").attr('src');
	   alert(image);
	    window.open('http://www.facebook.com/sharer.php?s=100&amp;p[url]=<?php echo site_url('user/profile/'.base64_encode($getalldata->user_id)); ?>&amp;&p[images][1]='+image, 'facebook-share-dialog', 'toolbar=0,status=0,width=548,height=325');
        return false;
}
function twShare()
{
	var width  = 575,
        height = 400,
        left   = ($(window).width()  - width)  / 2,
        top    = ($(window).height() - height) / 2,
        url    = 'http://twitter.com/share?url=<?php echo site_url('user/profile/'.base64_encode($getalldata->user_id)); ?>',
        opts   = 'status=1' +
                 ',width='  + width  +
                 ',height=' + height +
                 ',top='    + top    +
                 ',left='   + left;
    
    window.open(url, 'twitter', opts);
 
    return false;
}
function gPlusShare1(url,name)
    		{
		var w=480;var h=380;
		var x=Number((window.screen.width-w)/2);
		var y=Number((window.screen.height-h)/2);
		window.open('https://plus.google.com/share?url='+encodeURIComponent(url)+'&title='+encodeURIComponent(name),'','width='+w+',height='+h+',left='+x+',top='+y+',scrollbars=no');
		  
    	}
    	
    	function inShare()
{
	var width  = 600,
        height = 500,
        left   = ($(window).width()  - width)  / 2,
        top    = ($(window).height() - height) / 2,
        url    = 'https://www.linkedin.com/cws/share?url=<?php echo site_url('user/profile/'.base64_encode($getalldata->user_id)); ?>',
        opts   = 'status=1' +
                 ',width='  + width  +
                 ',height=' + height +
                 ',top='    + top    +
                 ',left='   + left;
    
    window.open(url, 'Linkedin', opts);
 
    return false;
}
jQuery(document).ready(function() {  
   	$(".fancybox")
    .attr('rel', 'gallery')
    .fancybox({
    	
        beforeShow: function () {
            if (this.title) {
            	
            	
                // New line
                this.title += '<ul class="social_icon pull-right"><li>Share Image: </li>';
                this.title += '<li><a href="javascript://" onclick="fbShare()" ><img src="<?php echo base_url().'default'?>/images/result_fb.png"></a></li>';
                this.title += ' <li><a onclick="twShare()" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_twitt.png"></a></li>';
                this.title += '<li><a onclick="gPlusShare1("<?php echo site_url('user/profile/'.base64_encode($getalldata->user_id)); ?>","<?php echo $getalldata->first_name." ".$getalldata->last_name; ?>")" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_google.png"></a></li>';
                this.title += ' <li><a onclick="inShare()" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_linkln.png"></a></li>';
                this.title += '</ul><div class="clear"></div>';
                
            }
        },
        afterShow: function() {
            // Render tweet button
           // twttr.widgets.load();
            //fbshare_popup();
        },
        helpers : {
            title : {
                type: 'inside'
            }
        }  
    });  });   
</script>

<script>
  	
function piShare(img)
{
	var width  = 600,
        height = 500,
         left   = ($(window).width()  - width)  / 2,
         top    = ($(window).height() - height) / 2,
        url    = 'http://www.pinterest.com/pin/create/button/?url=https://americanbars.com'+'&media='+img+'&description=Posted through american bars',
        opts   = 'status=1' +
                 ',width='  + width  +
                 ',height=' + height +
                 ',top='    + top    +
                 ',left='   + left;
    
    window.open(url, 'Pinterest', opts);
 
    return false;
}
</script>