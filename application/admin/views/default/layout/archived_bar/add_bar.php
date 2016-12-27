<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/bootstrap-fileupload.css" />
<script src="<?php echo base_url().getThemeName();?>/js/jquery-migrate-1.0.0.js"></script>
<script src="<?php echo base_url().getThemeName();?>/js/bootstrap-fileupload.js" type="text/javascript"></script>
<style type="text/css">
	#cke_83_label{display: none !important;}
</style>
<script src="<?php echo base_url().getThemeName(); ?>/js/ui/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/js/ui/jquery-ui.css" />
<link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/css/drag_style.css" />
<script type="text/javascript" src="<?php echo base_url()?>/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/image_script.js"></script>
<script type="text/javascript" src="<?php echo front_base_url().getThemeName(); ?>/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js" ></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery_form.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery-ui.min.js"></script>
 <script src="<?php echo base_url().getThemeName(); ?>/js/jquery.form.min.js"></script>
 <script type="text/javascript">
 $(document).ready(function() { 
 	
		   $("#phone").inputmask("(999) 999-9999");
	});
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

    // $('form.cover-position-form').ajaxForm({
        // url:  'c.php',
        // dataType:  'json', 
        // beforeSend: function() {
            // $('.cover-progress').html('Repositioning...').fadeIn('fast').removeClass('hidden');
        // },
//         
        // success: function(responseText) {
            // if ((responseText.status) == 200) {
                // $('.cover-wrapper img')
                    // .attr('src', responseText.url + '?' + new Date().getTime())
                    // .load(function () {
                        // $('.cover-progress').fadeOut('fast').addClass('hidden').html('');
                        // $('.cover-wrapper').show();
                        // $('.cover-resize-wrapper')
                            // .hide()
                            // .find('img').css('top', 0);
                        // $('.cover-resize-buttons').hide();
                        // $('.default-buttons').show();
                        // $('input.cover-position').val(0);
                        // $('.cover-resize-wrapper img').draggable('destroy').css('cursor','default');
                    // });
            // }
        // }
    // });
});  


</script>
<script>

$(document).ready(function(){
	
	
	/// file upload size validation///
	// $('#bar_video_file').change(function() {
            // //$(this).removeClass('input-validation-error').next('span').text('');
            // if (this.files[0].size > 2621440) {
                  // //$(this).addClass('input-validation-error').
                      // //  next('span').text('Filesize must 2.5mb or below');
//                       
                      // alert("filesize must be 2.5mb or below");
                      // $("#testsd").show();
            // }
      // });
	// end of file uplaod size validation//
	
	
	//////// editor code/////////
	$('#cke_83_label').hide();		
  
 CKEDITOR.replace("bar_desc", 
  {width: "500", height: "300", language: "en", stylesCombo_stylesSet: "my_styles", startupOutlineBlocks: true, entities: false, entities_latin: false, entities_greek: false, 		forcePasteAsPlainText: false, 
  filebrowserImageUploadUrl : "<?php echo base_url()."pages/editorimage" ?>", 
  filebrowserImageBrowseUrl : "<?php echo front_base_url()."pages/editorimage1" ?>", 
 filebrowserImageWindowWidth : "80%", 
  filebrowserImageWindowHeight : "80%", 
  toolbar :[ ["Source","-","FitWindow","ShowBlocks","-","Preview"], 
  ["Undo","Redo","-","Find","Replace","-","SelectAll","RemoveFormat"], 
 ["Cut","Copy","Paste","PasteText","PasteWord","-","Print","SpellCheck"], 
  ["Form","Checkbox","Radio","TextField","Textarea","Select",
  "Button","ImageButton","HiddenField"], ["About"], "/", ["Bold","Italic","Underline"], ["OrderedList","UnorderedList","-","Blockquote","CreateDiv"], ["Image","Flash","Table"],   ["","Unlink","Anchor"], 
  ["Rule","SpecialChar"], ["Styles"] ] ,
  
 removeDialogTabs: 'link:target;link:upload;link:advanced;image:Link;image:advanced',

  
  });
	/// end of editor code///////
	
	
	
	$("#frm_addbar").validate({
		
		rules: {
			bar_title:'required',
			status : 'required',
			facebook_link : {url:true},
			bar_type:'required',
			serve_as : 'required',
			address : 'required',
			city : 'required',
			email:{email:true},
			phone : {required:true},
			website:{url:true},
			
			twitter_link : {url:true},
			linkedin_link : {url:true},
			google_plus_link : {url:true},
			instagram_link : {url:true},
			dribble_link : {url:true},
			pinterest_link : {url:true},
			bar_logo_file: {
				  extension: "jpg|jpeg|gif|png"
			},
			bar_banner_file: {
				  extension: "jpg|jpeg|gif|png"
			},
			bar_video_file: {
				  extension: "mp4|flv|mov|wmv|mpeg|mpg"				
			},
			state:
			{
				required: true,
			},
			zipcode: {
			required: true,
			digits: true,
			maxlength:6,
			}
		},
		
	});
	
	});
	
	
	// file size validation//
	function GetFileSize(fileid) {
 try {
		 var fileSize = 0;
		 //for IE
		 if ($.browser.msie) {
		 //before making an object of ActiveXObject, 
		 //please make sure ActiveX is enabled in your IE browser
		 var objFSO = new ActiveXObject("Scripting.FileSystemObject"); var filePath = $("#" + fileid)[0].value;
		 var objFile = objFSO.getFile(filePath);
		 var fileSize = objFile.size; //size in kb
		 fileSize = fileSize / 1048576; 
		 }
		 //for FF, Safari, Opeara and Others
		 else {
		 fileSize = $("#" + fileid)[0].files[0].size; //size in kb
		// alert(fileSize);
		 fileSize = fileSize / 1048576;   
		 //alert(parseFloat(fileSize));
		 
		   if(parseFloat(fileSize) > 5)  
		   {
		      //alert("video size can not greater than 5MB");
		      $("#video_size_err").html("video size can not greater than 5MB");
		      $("#video_size_err").show();
		      return false;	
		   }
		   
		   else
		   {
		   	  $("#video_size_err").html("");
		      $("#video_size_err").hide();
		   	  return true;
		   }
		 }
		 
		 //alert("Uploaded File Size is" + fileSize + "MB");
		 
		 
		 }
		 catch (e) {
		 //alert("Error is :" + e);
		 return true;
		 }
 
   return false;
}

//end of file size validation///
</script>		

<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($bar_id==""){ echo 'Add Bar'; } else { echo 'Edit Bar'; }?></h3>
					
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
					<div class="portlet blue ">
						<div class="portlet-title">
							<div class="caption"></div>
						</div>
						<div class="portlet-body form">
							<div class="content">
								
								<?php
				$attributes = array('id'=>'frm_addbar','name'=>'frm_addbar','class'=>'main cover-position-form');
				echo form_open_multipart('bar/add_bar/'.$bartype,$attributes);
			  ?>
			  <input type="hidden" name="uid" id="uid" value="<?php echo @$uid?>" />
			  <input class="cover-position" name="pos" value="0" type="hidden">
			  <?php if($bar_id!=""){ ?>
			  <div class="control_group">
										<div class="controls"><h1 style="font-weight: bold; float: left;"> Customer Number :  </h1></div>
										<div class="controls"><h1 style="font-weight: bold; float: left;"> <?php echo $bar_id;?> </h1></div>
										<div class="clear"></div>
									</div>
									
									
									
									<?php } ?>
									
									<input type="hidden" name="bar_slug" id="bar_slug" value="<?php echo @$bar_slug; ?>" />
		                	<div class="control_group">
										<label class="control_label">Bar Type: <i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="bar_type" id="bar_type"> 
												<option value="">--Select--</option>
												<option value="half_mug" <?php echo ($bar_type=='half_mug')?'selected="selected"':''; ?> >Half Mug</option>
												<option value="full_mug" <?php echo ($bar_type=='full_mug')?'selected="selected"':''; ?> >Full Mug</option>
											</select>
										</div>										
										<div class="clear"></div>
									</div>
			  <div class="control_group">
										<label class="control_label">Bar Title:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" maxlength="200" placeholder="Bar title...." class="m_wrap wid360" name="bar_title" id="bar_title" value="<?php echo $bar_title; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
			                    <div class="control_group">
										<label class="control_label">First Name: </label>
										<div class="controls">
											<input type="text" maxlength="40" placeholder="First Name...." class="m_wrap wid360" name="bar_first_name" id="bar_first_name" value="<?php echo $bar_first_name; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									 <div class="control_group">
										<label class="control_label">Last Name: </label>
										<div class="controls">
											<input type="text" maxlength="40" placeholder="Last Name...." class="m_wrap wid360" name="bar_last_name" id="bar_last_name" value="<?php echo $bar_last_name; ?>">
										</div>										
										<div class="clear"></div>
									</div>
			             <div class="control_group">
										<label class="control_label">Email :</label>
										<div class="controls">
											<input type="text" placeholder="Email...." class="m_wrap wid360" name="email" id="email" value="<?php echo $email; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Phone No :<i style="color: #7D2A1C;">*</i> </label>
										<div class="controls">
											<input type="text" placeholder="Phone No...." class="m_wrap wid360" name="phone" id="phone" autocomplete="off" value="<?php echo $phone; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Street :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Address...." class="m_wrap wid360" name="address" id="address" value="<?php echo $address; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">City: <i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="City" class="m_wrap wid360" name="city" id="city" value="<?php echo $city; ?>">
										</div>										
										<div class="clear"></div>
									</div>
										<div class="control_group">
										<label class="control_label">State: <i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="State" class="m_wrap wid360" name="state" id="state" value="<?php echo $state; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Zip code: <i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Zipcode" class="m_wrap wid360" name="zipcode" id="zipcode" value="<?php echo $zipcode; ?>">
										</div>										
										<div class="clear"></div>
									</div>
			  						
									 <div class="control_group">
					                 <label class="control_label">Bar Description: </label>
                                      <div class="controls"> 
                                       <textarea id="bar_desc" cols="10" rows="4" name="bar_desc" class="wid360 wysihtml5 m_wrap required"><?php echo $bar_desc; ?></textarea>
                                  </div>
							     <div class="clear"></div>
                             </div>
                             
                               
								
                             
										<div class="control_group">
										<label class="control_label">Serve as: <i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input onclick="open_big()" type="radio" name="serve_as" id="serve_as" value="cocktail" <?php if($serve_as=='cocktail'){?> checked="checked" <?php } ?> />Cocktail
											<input onclick="open_small()" type="radio" name="serve_as" id="serve_as" value="liquor" <?php if($serve_as=='liquor'){?> checked="checked" <?php } ?>/>Liquor
										</div>
										&nbsp;<label for="serve_as" generated="true" class="error" style="display: none;">This field is required.</label>
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Website:</label>
										<div class="controls">
											<input type="text" placeholder="Website" class="m_wrap wid360" name="website" id="website" value="<?php echo $website; ?>">
										</div>										
										<div class="clear"></div>
									</div>
								
									
									
									
									
									<?php /*?><div class="control_group">
										<label class="control_label">Bar Logo:</label>
										<div class="controls">
										<input type="file" name="bar_logo_file"  id="bar_logo_file" />
										</div>	
										
										<?php 
										if($prev_bar_logo != "" && is_file(base_path()."upload/barlogo/".$prev_bar_logo))
										{?>
											<img src="<?php echo front_base_url()."upload/barlogo/".$prev_bar_logo; ?>" width="50" height="50">
										<?php }
										?>			
										
										<input type="hidden" name="prev_bar_logo" id="prev_bar_logo" value="<?php echo $prev_bar_logo; ?>" />						
										<div class="clear"></div>
									</div><?php */?>
									
									<div class="control-group">
											<label class="control-label">Bar Logo:</label>
											<div class="controls">
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
															<span class="btn btn-file">
															<span class="fileupload-new">Select Image</span>
															<span class="fileupload-exists">Change</span><input type="file" accept="image/*" class="default" name="bar_logo_file" id="bar_logo_file" /></span>
															<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>				
													</div>
												<input type="hidden" name="prev_bar_logo" id="prev_bar_logo" value="<?php echo $prev_bar_logo ?>" />												
												</div>
											
											
										<?php if(($prev_bar_logo!='' && file_exists(base_path().'upload/barlogo/'.$prev_bar_logo))){ ?>
											<!-- <br /><br /> -->
											<!-- <div class="control-group">
												<label class="control-label"></label> -->
												<div class="controls">
													<div class="span2 position-relative">
														<img src="<?php echo front_base_url().'upload/barlogo/'.$prev_bar_logo ?>" width="50"  height="50" />
														<a href="<?php echo base_url(); ?>bar/removeimage/<?php echo $bar_id.'/'.$prev_bar_logo.'/'.$limit.'/'.$offset.'/'.$redirect_page.'/'.$option.'/'.$keyword; ?>" id="remove" name="remove"><i class="comon_icon remove_icon"></i></a>
													</div>
												<!-- </div>
											</div> -->
											
										<?php } ?>
										
										<div class="clear"></div>
									</div> 
									<div class="clear"></div>
									</div>
									<?php /*?><div class="control_group">
										<label class="control_label">Bar Banner:</label>
										<div class="controls">
										<input type="file" name="bar_banner_file"  id="bar_banner_file" />
										</div>				
											<?php 
										if($prev_bar_banner != "" && is_file(base_path()."upload/barlogo/".$prev_bar_banner))
										{?>
											<img src="<?php echo front_base_url()."upload/barlogo/".$prev_bar_banner; ?>" width="50" height="50">
										<?php }
										?>			
												<input type="hidden" name="prev_bar_banner" id="prev_bar_banner" value="<?php echo $prev_bar_banner; ?>" />									
										<div class="clear"></div>
									</div><?php */?>
									
									<div class="control-group">
											<label class="control-label">Bar Banner:</label>
											<div class="controls">
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
															<span class="btn btn-file">
															<span class="fileupload-new">Select Image</span>
															<span class="fileupload-exists">Change</span><input type="file" accept="image/*" class="default" name="bar_banner_file" id="bar_banner_file" /></span>
															<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>														
													</div>
												<input type="hidden" name="prev_bar_banner" id="prev_bar_banner" value="<?php echo $prev_bar_banner; ?>" />												
												</div>
												<label for="profile_image" generated="true" style="display:none" class="error">Please enter a value with a valid extension.</label>
										<?php if(($prev_bar_banner!='' && file_exists(base_path().'upload/barlogo/'.$prev_bar_banner))){ ?>
											<!-- <br /><br /> -->
											<!-- <div class="control-group" style="clear:both">
												<label class="control-label"></label> -->
												<div class="controls">
													<div class="span2 position-relative">
														<img src="<?php echo front_base_url().'upload/barlogo/'.$prev_bar_banner ?>" width="50"  height="50" />
														<a href="<?php echo base_url(); ?>bar/removeimage/<?php echo $bar_id.'/'.$prev_bar_banner.'/'.$limit.'/'.$offset.'/'.$redirect_page.'/'.$option.'/'.$keyword;?>" id="remove" name="remove"><i class="comon_icon remove_icon"></i></a>
													</div>
													<div class="clear"></div>
												</div>
											<!-- </div> -->
										<?php } ?>
										<div class="clear"></div>
									</div>
									 
									
	        						<!--<a href="#" class="btn btn-lg btn-primary">Upload Image</a>-->
	        				<div class="timeline-header-wrapper">	
	        						<div class="stamp_image cover-resize-wrapper"  id="preview"">
	        							<?php $src='' ; if((@$prev_bar_banner!='' && file_exists(base_path().'upload/barlogo/'.@$prev_bar_banner))){ ?>
	        								<img src="<?php echo front_base_url().'upload/barlogo_orig/'.$prev_bar_banner ?>" />
	        								<?php } ?>
	        								<?php if((@$prev_bar_banner!='' && file_exists(base_path().'upload/barlogo/'.@$prev_bar_banner))){ 
	        								   $src = front_base_url().'upload/barlogo_orig/'.$prev_bar_banner;
	        								 } ?>
	     							<img id="previewimg" src="<?php echo $src; ?>" />
	     						</div>
	     					</div>	
	     					<div class="clear"></div>
	     						 <a onclick="repositionCover();" class="control-label cover-btn">Reposition cover</a>
	     						 <div class="clear"></div>
									<div class="control-group">
											<label class="control-label">Bar Video:</label>
											<div class="controls">
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
															<span class="btn btn-file">
															<span class="fileupload-new">Select Video</span>
															<span class="fileupload-exists">Change</span><input type="file" accept="video/*" class="default" name="bar_video_file" id="bar_video_file" /></span>
															<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
															&nbsp;<?php  echo $prev_bar_video ;?>	
														</div>
													</div>
													
												<input type="hidden" name="prev_bar_video" id="prev_bar_video" value="<?php echo $prev_bar_video ?>" />												
												</div>
											</div>		
									<div class="clear"></div>
									
									<div class="control_group">
										<label class="control_label">Bar Video Link:</label>
										<div class="controls">
											<input type="text" placeholder="Video Link" class="m_wrap wid360" name="bar_video_link" id="bar_video_link" value="<?php echo $bar_video_link; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Facebook Link:</label>
										<div class="controls">
											<input type="text" placeholder="Facebook Link" class="m_wrap wid360" name="facebook_link" id="facebook_link" value="<?php echo $facebook_link; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Twitter Link:</label>
										<div class="controls">
											<input type="text" placeholder="Twitter Link" class="m_wrap wid360" name="twitter_link" id="twitter_link" value="<?php echo $twitter_link; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Linkedin Link:</label>
										<div class="controls">
											<input type="text" placeholder="Linkedin Link" class="m_wrap wid360" name="linkedin_link" id="linkedin_link" value="<?php echo $linkedin_link; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Instagram Link:</label>
										<div class="controls">
											<input type="text" placeholder="Instagram Link" class="m_wrap wid360" name="instagram_link" id="instagram_link" value="<?php echo $instagram_link; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Google Plus Link:</label>
										<div class="controls">
											<input type="text" placeholder="Google Plus Link" class="m_wrap wid360" name="google_plus_link" id="google_plus_link" value="<?php echo $google_plus_link; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Dribble Link:</label>
										<div class="controls">
											<input type="text" placeholder="Dribble Link" class="m_wrap wid360" name="dribble_link" id="dribble_link" value="<?php echo $dribble_link; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Pinterest Link:</label>
										<div class="controls">
											<input type="text" placeholder="Pinterest Link" class="m_wrap wid360" name="pinterest_link" id="pinterest_link" value="<?php echo $pinterest_link; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Status:<i style="color: #7D2A1C;">*</i></label>
										
										
										<div class="controls" >
											
											<select class="m_wrap wid360" name="status" id="status"> 
												<option value="active" <?php echo ($status=='active')?'selected="selected"':''; ?> >Active</option>
												<option value="inactive" <?php echo ($status=='inactive')?'selected="selected"':''; ?> >Inactive</option>
											</select>
										</div>										
										<div class="clear"></div>
									</div>
								
								
										<div class="control_group">
										<label class="control_label">Payment Types: </label>
										<div class="controls">
											<input type="checkbox" value="1" <?php if($cash_p==1){ echo "checked"; }?> name="cash_p" id="cash_p" > <i class="strip small-cash"></i>
											<input type="checkbox" value="1"  <?php if($master_p==1){ echo "checked"; }?> name="master_p" id="master_p" > <i class="strip small-master-card"></i>
											<input type="checkbox" value="1"  <?php if($american_p==1){ echo "checked"; }?> name="american_p" id="american_p" > <i class="strip small-american-express"></i>
											<input type="checkbox" value="1"  <?php if($visa_p==1){ echo "checked"; }?> name="visa_p" id="visa_p" > <i class="strip small-visa"></i>
											<input type="checkbox" value="1"  <?php if($paypal_p==1){ echo "checked"; }?> name="paypal_p" id="paypal_p" > <i class="strip small-payapl"></i>
											<input type="checkbox" value="1"  <?php if($bitcoin_p==1){ echo "checked"; }?> name="bitcoin_p" id="bitcoin_p" > <i class="strip small-bit-coin"></i>
											<input type="checkbox" value="1"  <?php if($apple_p==1){ echo "checked"; }?> name="apple_p" id="apple_p" > <i class="strip small-apple-pay"></i>
											
										</div>
										&nbsp;<label for="size" generated="true" class="error" style="display: none;">This field is required.</label>
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">Meta Title: </label>
										<div class="controls">
											<input type="text" placeholder="Meta Title" class="m_wrap wid360" name="bar_meta_title" id="bar_meta_title" value="<?php echo $bar_meta_title; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Meta Keyword: </label>
										<div class="controls">
											<input type="text" placeholder="Meta Keyword" class="m_wrap wid360" name="bar_meta_keyword" id="bar_meta_keyword" value="<?php echo $bar_meta_keyword; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Meta Description: </label>
										<div class="controls">
											<textarea id="bar_meta_description" cols="10" rows="4" name="bar_meta_description" class="wid360 m_wrap "><?php echo $bar_meta_description; ?></textarea>
										</div>										
										<div class="clear"></div>
									</div>
								
							<!-- </div> -->	
							<input type="hidden" name="bar_id" id="bar_id" value="<?php echo $bar_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
					
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php if($bar_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" onclick="return GetFileSize('bar_video_file');"/>
						<?php if($redirect_page == 'list_bar')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>bar/<?php echo $redirect_page.'/'.$bartype.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>bar/<?php echo $redirect_page.'/'.$bartype.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" onclick="return GetFileSize('bar_video_file');" />
						
						<?php if($redirect_page == 'list_bar')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>bar/<?php echo $redirect_page.'/'.$bartype.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>bar/<?php echo $redirect_page.'/'.$bartype.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
					<?php } ?>
					
					
					
					</form>		
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
