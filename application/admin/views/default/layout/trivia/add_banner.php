<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/bootstrap-fileupload.css" />
<script src="<?php echo base_url().getThemeName();?>/js/jquery-migrate-1.0.0.js"></script>
<script src="<?php echo base_url().getThemeName();?>/js/bootstrap-fileupload.js" type="text/javascript"></script>
<style type="text/css">
	#cke_83_label{display: none !important;}
</style>
<script src="<?php echo base_url().getThemeName(); ?>/js/ui/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/js/ui/jquery-ui.css" />
<link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/css/drag_style.css" />
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/image_script.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery_form.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery-ui.min.js"></script>
 <script src="<?php echo base_url().getThemeName(); ?>/js/jquery.form.min.js"></script>
 <script type="text/javascript">
function repositionCover(id) {
    //$('.cover-wrapper').hide();.
    
    $('.cover-resize-wrapper_'+id).show();
    $('.cover-resize-buttons').show();
    $('.default-buttons').hide();
    $('.screen-width').val($('.cover-resize-wrapper_'+id).width());
    $('.cover-resize-wrapper_'+id+' img')
    .css('cursor', 's-resize')
    .draggable({
        scroll: false,
        
        axis: "y",
        
        cursor: "s-resize",
        
        drag: function (event, ui) {
            y1 = $('.timeline-header-wrapper_'+id).height();
            y2 = $('.cover-resize-wrapper_'+id).find('img').height();
            
            
            if (ui.position.top >= 0) {
            	
                ui.position.top = 0;
            }
            else if (ui.position.top <= (y1-y2)) {
            	
                ui.position.top = y1-y2;
            }
        },
        
        stop: function(event, ui) {
            $('input.cover-position_'+id).val(ui.position.top);
        }
    });
}

// function saveReposition() {
//     
    // if ($('input.cover-position').length == 1) {
        // posY = $('input.cover-position').val();
        // $('form.cover-position-form').submit();
    // }
// }

// function cancelReposition() {
    // $('.cover-wrapper').show();
    // $('.cover-resize-wrapper_1').hide();
    // $('.cover-resize-buttons').hide();
    // $('.default-buttons').show();
    // $('input.cover-position').val(0);
    // $('.cover-resize-wrapper_1 img').draggable('destroy').css('cursor','default');
// }


 $(document).ready(function(){	
    $('.cover-resize-wrapper_1').height($('.cover-resize-wrapper_1').width()*0.176);
    $('.cover-resize-wrapper_2').height($('.cover-resize-wrapper_2').width()*0.176);
    $('.cover-resize-wrapper_11').height($('.cover-resize-wrapper_11').width()*0.176);
    $('.cover-resize-wrapper_3').height($('.cover-resize-wrapper_3').width()*0.176);
    $('.cover-resize-wrapper_4').height($('.cover-resize-wrapper_4').width()*0.176);
    $('.cover-resize-wrapper_5').height($('.cover-resize-wrapper_5').width()*0.176);
    $('.cover-resize-wrapper_6').height($('.cover-resize-wrapper_6').width()*0.176);
    $('.cover-resize-wrapper_7').height($('.cover-resize-wrapper_7').width()*0.176);
    $('.cover-resize-wrapper_8').height($('.cover-resize-wrapper_8').width()*0.176);
    $('.cover-resize-wrapper_9').height($('.cover-resize-wrapper_9').width()*0.176);
    $('.cover-resize-wrapper_10').height($('.cover-resize-wrapper_10').width()*0.176);
    $('.cover-resize-wrapper_12').height($('.cover-resize-wrapper_12').width()*0.176);
    $('.cover-resize-wrapper_13').height($('.cover-resize-wrapper_13').width()*0.176);

});  


</script>

<script>
  var img_width = 1140;
  var img_height = 237;
 function checkImageValidation(){
		var _URL = window.URL;
			$("#find_bar").change(function (e) {
				//$("#see_hide").css("display", "block");
				var file, img;
				if ((file = this.files[0])) {
				
					img = new Image();
					img.onload = function () {
					//alert('width:'+this.width+'Height'+this.height);
					
					img_width = parseInt(this.width);
					img_height = parseInt(this.height);
					};
					img.src = _URL.createObjectURL(file);
				}
			});
			
			$("#find_trivia").change(function (e) {
				//$("#see_hide").css("display", "block");
				var file, img;
				if ((file = this.files[0])) {
				
					img = new Image();
					img.onload = function () {
					//alert('width:'+this.width+'Height'+this.height);
					
					img_width = parseInt(this.width);
					img_height = parseInt(this.height);
					};
					img.src = _URL.createObjectURL(file);
				}
			});
			
			$("#find_trivia_app").change(function (e) {
				//$("#see_hide").css("display", "block");
				var file, img;
				if ((file = this.files[0])) {
				
					img = new Image();
					img.onload = function () {
					//alert('width:'+this.width+'Height'+this.height);
					
					img_width = parseInt(this.width);
					img_height = parseInt(this.height);
					};
					img.src = _URL.createObjectURL(file);
				}
			});
			
			$("#find_article").change(function (e) {
				//$("#see_hide").css("display", "block");
				var file, img;
				if ((file = this.files[0])) {
				
					img = new Image();
					img.onload = function () {
					//alert('width:'+this.width+'Height'+this.height);
					
					img_width = parseInt(this.width);
					img_height = parseInt(this.height);
					};
					img.src = _URL.createObjectURL(file);
				}
			});
			
			$("#find_taxi").change(function (e) {
				//$("#see_hide").css("display", "block");
				var file, img;
				if ((file = this.files[0])) {
				
					img = new Image();
					img.onload = function () {
					//alert('width:'+this.width+'Height'+this.height);
					
					img_width = parseInt(this.width);
					img_height = parseInt(this.height);
					};
					img.src = _URL.createObjectURL(file);
				}
			});
			
			$("#find_resource").change(function (e) {
				//$("#see_hide").css("display", "block");
				var file, img;
				if ((file = this.files[0])) {
				
					img = new Image();
					img.onload = function () {
					//alert('width:'+this.width+'Height'+this.height);
					
					img_width = parseInt(this.width);
					img_height = parseInt(this.height);
					};
					img.src = _URL.createObjectURL(file);
				}
			});
			
			$("#find_beer").change(function (e) {
				//$("#see_hide").css("display", "block");
				var file, img;
				if ((file = this.files[0])) {
				
					img = new Image();
					img.onload = function () {
					//alert('width:'+this.width+'Height'+this.height);
					
					img_width = parseInt(this.width);
					img_height = parseInt(this.height);
					};
					img.src = _URL.createObjectURL(file);
				}
			});
			
			$("#find_liquor").change(function (e) {
				//$("#see_hide").css("display", "block");
				var file, img;
				if ((file = this.files[0])) {
				
					img = new Image();
					img.onload = function () {
					//alert('width:'+this.width+'Height'+this.height);
					
					img_width = parseInt(this.width);
					img_height = parseInt(this.height);
					};
					img.src = _URL.createObjectURL(file);
				}
			});
			
			$("#find_cocktail").change(function (e) {
				//$("#see_hide").css("display", "block");
				var file, img;
				if ((file = this.files[0])) {
				
					img = new Image();
					img.onload = function () {
					//alert('width:'+this.width+'Height'+this.height);
					
					img_width = parseInt(this.width);
					img_height = parseInt(this.height);
					};
					img.src = _URL.createObjectURL(file);
				}
			});
			
			$("#find_suggest_bar").change(function (e) {
				//$("#see_hide").css("display", "block");
				var file, img;
				if ((file = this.files[0])) {
				
					img = new Image();
					img.onload = function () {
					//alert('width:'+this.width+'Height'+this.height);
					
					img_width = parseInt(this.width);
					img_height = parseInt(this.height);
					};
					img.src = _URL.createObjectURL(file);
				}
			});
			
			$("#find_contact_us").change(function (e) {
				//$("#see_hide").css("display", "block");
				var file, img;
				if ((file = this.files[0])) {
				
					img = new Image();
					img.onload = function () {
					//alert('width:'+this.width+'Height'+this.height);
					
					img_width = parseInt(this.width);
					img_height = parseInt(this.height);
					};
					img.src = _URL.createObjectURL(file);
				}
			});
			
			$("#find_gallery").change(function (e) {
				//$("#see_hide").css("display", "block");
				var file, img;
				if ((file = this.files[0])) {
				
					img = new Image();
					img.onload = function () {
					//alert('width:'+this.width+'Height'+this.height);
					
					img_width = parseInt(this.width);
					img_height = parseInt(this.height);
					};
					img.src = _URL.createObjectURL(file);
				}
			});
			
			$("#find_media").change(function (e) {
				//$("#see_hide").css("display", "block");
				var file, img;
				if ((file = this.files[0])) {
				
					img = new Image();
					img.onload = function () {
					//alert('width:'+this.width+'Height'+this.height);
					
					img_width = parseInt(this.width);
					img_height = parseInt(this.height);
					};
					img.src = _URL.createObjectURL(file);
				}
			});
			
			$("#find_forum").change(function (e) {
				//$("#see_hide").css("display", "block");
				var file, img;
				if ((file = this.files[0])) {
				
					img = new Image();
					img.onload = function () {
					//alert('width:'+this.width+'Height'+this.height);
					
					img_width = parseInt(this.width);
					img_height = parseInt(this.height);
					};
					img.src = _URL.createObjectURL(file);
				}
			});
	}

$(document).ready(function(){	
	checkImageValidation();

$("#usualValidate1").validate({
		
		rules: {
			find_bar: {
				 <?php if($prev_bar_banner_find==''){?>
				  image_validation : true,
				 <?php } ?>
			},
			find_trivia: {
				 <?php if($prev_trivia_banner_find==''){?>
				  image_validation1 : true,
				 <?php } ?>
			},
			find_trivia_app: {
				 <?php if($prev_trivia_app_banner_find==''){?>
				  image_validation12 : true,
				 <?php } ?>
			},
			find_article: {
				 <?php if($prev_article_banner_find==''){?>
				  image_validation : true,
				 <?php } ?>
			},
			find_resource: {
				 <?php if($prev_resource_banner_find==''){?>
				  image_validation : true,
				 <?php } ?>
			},
			find_beer: {
				 <?php //if($prev_beer_banner_find==''){?>
				  image_validation : true,
				 <?php //} ?>
			},
			find_taxi: {
				 <?php //if($prev_beer_banner_find==''){?>
				  image_validation : true,
				 <?php //} ?>
			},
			find_cocktail: {
				 <?php //if($prev_cocktail_banner_find==''){?>
				  image_validation : true,
				 <?php //} ?>
			},
			find_suggest_bar: {
				 <?php //if($prev_suggest_bar_banner_find==''){?>
				  image_validation : true,
				 <?php //} ?>
			},
			find_contact_us: {
				 <?php //if($prev_contact_us_banner_find==''){?>
				  image_validation : true,
				 <?php //} ?>
			},
			find_gallery: {
				 <?php //if($prev_gallery_banner_find==''){?>
				  image_validation : true,
				 <?php //} ?>
			},
			find_liquor: {
				 <?php //if($prev_gallery_banner_find==''){?>
				  image_validation : true,
				 <?php //} ?>
			},
			find_media: {
				 <?php //if($prev_media_banner_find==''){?>
				  image_validation : true,
				 <?php //} ?>
			},
			find_forum: {
				 <?php //if($prev_forum_banner_find==''){?>
				  image_validation : true,
				 <?php //} ?>
			},
			status:'required',
		},		
	});	
	
	jQuery.validator.addMethod("image_validation", function(value, element) {
		if(img_width >= 1140 && img_height >=237){
			return true
		}	
		return false;
    //var test = null; //Perform your test here        
   // return this.optional(element) || test;
}, 'Image size must be 1140px by 237px.');

jQuery.validator.addMethod("image_validation1", function(value, element) {
		if(img_width >= 1140 && img_height >=415){
			return true
		}	
		return false;
    //var test = null; //Perform your test here        
   // return this.optional(element) || test;
}, 'Image size must be 1140px by 402px.');

jQuery.validator.addMethod("image_validation1", function(value, element) {
		if(img_width >= 1920 && img_height >=1080){
			return true
		}	
		return false;
    //var test = null; //Perform your test here        
   // return this.optional(element) || test;
}, 'Image size must be 1920px by 1080px.');
});	
</script>

<!-- Content begins -->
<div id="content" class="page_content">
    <!-- Main content -->
    <div class="container_fluid">
	<div class="row_fluid">
					<div class="span12">
						<h3 class="page_title">
							Banner Pages
							
						</h3>
						
					</div>
		</div>
		<?php  
		if($error != "") {
			if($error == "update") {?>
				<div class="success_msg">
					
						<p><?php echo SITE_SETTING_UPDATE;?>.</p>
				</div>
			<?php }
		
			if($error != "update"){	?>
			<div class="error_red">
					
						<?php echo $error;?>
				</div>
			<?php }
		}
	?>		
     <div class="row_fluid">
					<div class="span12">
						<!-- BEGIN SAMPLE FORM PORTLET-->   
						<div class="portlet box blue tabbable">
				
                   
                        <div class="portlet-title">
								<div class="caption">
									<i class="icon-reorder"></i>
									<span class="hidden-480">Banner Pages</span>
								</div>
							</div>
                            <div class="portlet-body form">
								<div class="tabbable portlet-tabs">
								
                       <div class="tab-content" style="margin:0 !important">
										<div id="portlet_tab1" class="tab-pane active">
											<!-- BEGIN FORM-->
											<?php
				$attributes = array('id'=>'usualValidate','name'=>'frm_addadmin','class'=>'form-horizontal');
				echo form_open_multipart('trivia/trivia_banner',$attributes);
			  ?>
			   <input class="cover-position_1" name="pos" value="0" type="hidden">
			   <input class="cover-position_2" name="pos_beer" value="0" type="hidden">
			   <input class="cover-position_3" name="pos_cocktail" value="0" type="hidden">
			   <input class="cover-position_4" name="pos_suggest_bar" value="0" type="hidden">
			   <input class="cover-position_5" name="pos_contact_us" value="0" type="hidden">
			   <input class="cover-position_6" name="pos_gallery" value="0" type="hidden">
			   <input class="cover-position_7" name="pos_nedia" value="0" type="hidden">
			   <input class="cover-position_8" name="pos_forum" value="0" type="hidden">
			   <input class="cover-position_9" name="pos_liquor" value="0" type="hidden">
			   <input class="cover-position_10" name="pos_taxi" value="0" type="hidden">
			   <input class="cover-position_11" name="pos_resource" value="0" type="hidden">
			   <input class="cover-position_12" name="pos_article" value="0" type="hidden" />
			   <input class="cover-position_13" name="pos_trivia" value="0" type="hidden" />
			   <input class="cover-position_14" name="pos_trivia_app" value="0" type="hidden" />
			   
									
									 <div class="control-group">
											<label class="control-label">Trivia Banner:</label>
											<div class="controls">
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
															<span class="btn btn-file">
															<span class="fileupload-new">Select Image</span>
															<span class="fileupload-exists">Change</span><input type="file" accept="image/*" class="default" name="find_trivia" id="find_trivia" /></span>
															<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>														
													</div>
												<input type="hidden" name="prev_trivia_banner_find" id="prev_trivia_banner_find" value="<?php echo $prev_trivia_banner_find; ?>" />												
												</div>
												
												<div class="controls">
												<label for="profile_image" generated="true" style="display:none" class="error">Please enter a value with a valid extension.</label>
										<?php if(($prev_trivia_banner_find!='' && file_exists(base_path().'upload/bar_pages_banner/'.$prev_trivia_banner_find))){ ?>
											<!-- <br /><br />
											<div class="control-group" style="clear:both">
												<label class="control-label"></label> -->
												<div class="controls">
													<div class="span2">
														<img src="<?php echo front_base_url().'upload/bar_pages_banner/'.$prev_trivia_banner_find ?>" width="50"  height="50" />
														<!-- <a href="<?php echo base_url(); ?>bar/removeimage/<?php echo $bar_id.'/'.$prev_bar_banner.'/'.$limit.'/'.$offset.'/'.$redirect_page.'/'.$option.'/'.$keyword;?>" id="remove" name="remove">Remove image</a> -->
													</div>
												</div>
											<!-- </div> -->
										<?php } ?>
										</div>
										
										<div class="controls">
												<label class="pull-left" style="font-size: 14px; margin-top: 10px; margin-left: 17px; font-weight: bold;">Show</label>
														<input style="font-size: 14px; margin-top: 10px; margin-left:14px; font-weight: bold;" class="pull-left" type="checkbox" name="find_trivia_state" id="find_trivia_state" value="1" <?php echo $find_trivia_state==1 ? 'checked':'';?> />
										</div>
										<div class="clear"></div>
									</div>
								<label class="help-inline"><b>(Image required 1140x415)</b></label>	 
									
	        						<!--<a href="#" class="btn btn-lg btn-primary">Upload Image</a>-->
	        				<div class="timeline-header-wrapper timeline-header-wrapper_13">	
	        						<div class="stamp_image cover-resize-wrapper_13 cover-resize-wrapper122"  id="preview_trivia"">
	        							<?php if((@$prev_trivia_banner_find!='' && file_exists(base_path().'upload/bar_pages_banner/'.@$prev_trivia_banner_find))){ ?>
	        								<img id="previewimg_trivia" src="<?php echo front_base_url().'upload/bar_pages_banner_orig/'.$prev_trivia_banner_find ?>" />
	        								<?php } else {?>
	     							<img id="previewimg_trivia" src="" />
	     							<?php } ?>
	     						</div>
	     					</div>	
	     						 <!-- <a onclick="repositionCover('13');" class="control-label cover-btn" >Reposition cover</a><div class="clear"></div> -->
	     						  			
	     						  			
	     						  			
	     					
									 <div class="control-group">
											<label class="control-label">Trivia App Banner:</label>
											<div class="controls">
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
															<span class="btn btn-file">
															<span class="fileupload-new">Select Image</span>
															<span class="fileupload-exists">Change</span><input type="file" accept="image/*" class="default" name="find_trivia_app" id="find_trivia_app" /></span>
															<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>														
													</div>
												<input type="hidden" name="prev_trivia_app_banner_find" id="prev_app_trivia_banner_find" value="<?php echo $prev_trivia_app_banner_find; ?>" />												
												</div>
												
												<div class="controls">
												<label for="profile_image" generated="true" style="display:none" class="error">Please enter a value with a valid extension.</label>
										<?php if(($prev_trivia_app_banner_find!='' && file_exists(base_path().'upload/bar_pages_banner/'.$prev_trivia_app_banner_find))){ ?>
											<!-- <br /><br />
											<div class="control-group" style="clear:both">
												<label class="control-label"></label> -->
												<div class="controls">
													<div class="span2">
														<img src="<?php echo front_base_url().'upload/bar_pages_banner/'.$prev_trivia_app_banner_find ?>" width="50"  height="50" />
														<!-- <a href="<?php echo base_url(); ?>bar/removeimage/<?php echo $bar_id.'/'.$prev_bar_banner.'/'.$limit.'/'.$offset.'/'.$redirect_page.'/'.$option.'/'.$keyword;?>" id="remove" name="remove">Remove image</a> -->
													</div>
												</div>
											<!-- </div> -->
										<?php } ?>
										</div>
										
										<div class="controls">
												<label class="pull-left" style="font-size: 14px; margin-top: 10px; margin-left: 17px; font-weight: bold;">Show</label>
														<input style="font-size: 14px; margin-top: 10px; margin-left:14px; font-weight: bold;" class="pull-left" type="checkbox" name="find_trivia_app_state" id="find_trivia_app_state" value="1" <?php echo $find_trivia_app_state==1 ? 'checked':'';?> />
										</div>
										<div class="clear"></div>
									</div>
								<label class="help-inline"><b>(Image required 1920x1080)</b></label>	 
									
	        						<!--<a href="#" class="btn btn-lg btn-primary">Upload Image</a>-->
	        				<div class="timeline-header-wrapper timeline-header-wrapper_13">	
	        						<div class="stamp_image cover-resize-wrapper_13 cover-resize-wrapper122"  id="preview_trivia_app">
	        							<?php if((@$prev_trivia_app_banner_find!='' && file_exists(base_path().'upload/bar_pages_banner/'.@$prev_trivia_app_banner_find))){ ?>
	        								<img id="previewimg_trivia_app" src="<?php echo front_base_url().'upload/bar_pages_banner_orig/'.$prev_trivia_app_banner_find ?>" />
	        								<?php } else {?>
	     							<img id="previewimg_trivia_app" src="" />
	     							<?php } ?>
	     						</div>
	     					</div>	
	     						 <!-- <a onclick="repositionCover('14');" class="control-label cover-btn" >Reposition cover</a><div class="clear"></div> -->
	     						  				  				
                      <input type="hidden" name="banner_pages_id" id="banner_pages_id" value="<?php echo $banner_pages_id; ?>" />
				 		
				 		
				 		
				 		
						<div class="form_action">
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="document.location.href='<?php echo base_url(); ?>admin/list_admin'" />
						</div>
                        </form>
       </div>
       
       </div>
                    </div>
</div>

            
</div>
</div>
</div>
</div>
</div>

<!-- Content ends -->    