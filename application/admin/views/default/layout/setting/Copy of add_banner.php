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
function repositionCover() {
    $('.cover-wrapper').hide();
    $('.cover-resize-wrapper').show();
    $('.cover-resize-buttons').show();
    $('.default-buttons').hide();
    $('.screen-width').val($('.cover-resize-wrapper').width());
    $('.cover-resize-wrapper img')
    .css('cursor', 's-resize')
    .draggable({
        scroll: false,
        
        axis: "y",
        
        cursor: "s-resize",
        
        drag: function (event, ui) {
            y1 = $('.timeline-header-wrapper').height();
            y2 = $('.cover-resize-wrapper').find('img').height();
            
            if (ui.position.top >= 0) {
                ui.position.top = 0;
            }
            else
            if (ui.position.top <= (y1-y2)) {
                ui.position.top = y1-y2;
            }
        },
        
        stop: function(event, ui) {
            $('input.cover-position').val(ui.position.top);
        }
    });
}

function saveReposition() {
    
    if ($('input.cover-position').length == 1) {
        posY = $('input.cover-position').val();
        $('form.cover-position-form').submit();
    }
}

function cancelReposition() {
    $('.cover-wrapper').show();
    $('.cover-resize-wrapper').hide();
    $('.cover-resize-buttons').hide();
    $('.default-buttons').show();
    $('input.cover-position').val(0);
    $('.cover-resize-wrapper img').draggable('destroy').css('cursor','default');
}


 $(function(){
    $('.cover-resize-wrapper').height($('.cover-resize-wrapper').width()*0.3);

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
				echo form_open('banner_pages/add_banner_pages',$attributes);
			  ?>
					   <div class="control-group">
											<label class="control-label">Find Bar Banner:</label>
											<div class="controls">
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
															<span class="btn btn-file">
															<span class="fileupload-new">Select Image</span>
															<span class="fileupload-exists">Change</span><input type="file" accept="image/*" class="default" name="find_bar" id="find_bar" /></span>
															<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>														
													</div>
												<input type="hidden" name="prev_bar_banner_find" id="prev_bar_banner_find" value="<?php echo $prev_bar_banner_find; ?>" />												
												</div>
												<label for="profile_image" generated="true" style="display:none" class="error">Please enter a value with a valid extension.</label>
										<?php if(($prev_bar_banner_find!='' && file_exists(base_path().'upload/bar_pages_banner/'.$prev_bar_banner_find))){ ?>
											<br /><br />
											<div class="control-group" style="clear:both">
												<label class="control-label"></label>
												<div class="controls">
													<div class="span2">
														<img src="<?php echo front_base_url().'upload/bar_pages_banner/'.$prev_bar_banner_find ?>" width="50"  height="50" />
														<!-- <a href="<?php echo base_url(); ?>bar/removeimage/<?php echo $bar_id.'/'.$prev_bar_banner.'/'.$limit.'/'.$offset.'/'.$redirect_page.'/'.$option.'/'.$keyword;?>" id="remove" name="remove">Remove image</a> -->
													</div>
												</div>
											</div>
										<?php } ?>
										<div class="clear"></div>
									</div>
									 
									
	        						<!--<a href="#" class="btn btn-lg btn-primary">Upload Image</a>-->
	        				<div class="timeline-header-wrapper">	
	        						<div class="stamp_image cover-resize-wrapper"  id="preview"">
	        							<?php if((@$prev_bar_banner_find!='' && file_exists(base_path().'upload/bar_pages_banner/'.@$prev_bar_banner_find))){ ?>
	        								<img src="<?php echo front_base_url().'upload/bar_pages_banner_orig/'.$prev_bar_banner_find ?>" />
	        								<?php } ?>
	     							<img id="previewimg" src="" />
	     						</div>
	     					</div>	
	     						 <a onclick="repositionCover();" class="control-label" style="font-size: 16px;  font-weight: bold; cursor: pointer;" >Reposition cover</a><div class="clear"></div>
	     						 
	     						 
	     						 
	     						 
	     						 
	     						 
	     						 
	     						 
	     						 
	     						  <div class="control-group">
											<label class="control-label">Beer Directory Banner:</label>
											<div class="controls">
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
															<span class="btn btn-file">
															<span class="fileupload-new">Select Image</span>
															<span class="fileupload-exists">Change</span><input type="file" accept="image/*" class="default" name="find_beer" id="find_beer" /></span>
															<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>														
													</div>
												<input type="hidden" name="prev_beer_banner_find" id="prev_beer_banner_find" value="<?php echo $prev_beer_banner_find; ?>" />												
												</div>
												<label for="profile_image" generated="true" style="display:none" class="error">Please enter a value with a valid extension.</label>
										<?php if(($prev_beer_banner_find!='' && file_exists(base_path().'upload/bar_pages_banner/'.$prev_beer_banner_find))){ ?>
											<br /><br />
											<div class="control-group" style="clear:both">
												<label class="control-label"></label>
												<div class="controls">
													<div class="span2">
														<img src="<?php echo front_base_url().'upload/bar_pages_banner/'.$prev_beer_banner_find ?>" width="50"  height="50" />
														<!-- <a href="<?php echo base_url(); ?>bar/removeimage/<?php echo $bar_id.'/'.$prev_bar_banner.'/'.$limit.'/'.$offset.'/'.$redirect_page.'/'.$option.'/'.$keyword;?>" id="remove" name="remove">Remove image</a> -->
													</div>
												</div>
											</div>
										<?php } ?>
										<div class="clear"></div>
									</div>
									 
									
	        						<!--<a href="#" class="btn btn-lg btn-primary">Upload Image</a>-->
	        				<div class="timeline-header-wrapper">	
	        						<div class="stamp_image cover-resize-wrapper"  id="preview"">
	        							<?php if((@$prev_beer_banner_find!='' && file_exists(base_path().'upload/bar_pages_banner/'.@$prev_beer_banner_find))){ ?>
	        								<img src="<?php echo front_base_url().'upload/bar_pages_banner_orig/'.$prev_beer_banner_find ?>" />
	        								<?php } ?>
	     							<img id="previewimg" src="" />
	     						</div>
	     					</div>	
	     						 <a onclick="repositionCover();" class="control-label" style="font-size: 16px;  font-weight: bold; cursor: pointer;" >Reposition cover</a><div class="clear"></div>
								
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