<style type="text/css">
	#cke_83_label{display: none !important;}
</style>
<script type="text/javascript" src="<?php echo front_base_url().getThemeName(); ?>/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js" ></script>
 <script type="text/javascript">
 $(document).ready(function() { 
 	
		   $("#phone").inputmask("(999) 999-9999");
	});

</script>
<script>

function setaction(elename, actionval, actionmsg, formname) {
	if(confirm(actionmsg))
		{
			document.getElementById('action').value=actionval;	
			document.frm_listlogin.submit();
	  }		
}

$(document).ready(function(){
	
	
	
	
	
	$("#frm_addbar").validate({
		
		rules: {
			bar_name:'required',
			address : 'required',
			city : 'required',
			state : 'required',
			phone : {required:true},
			zipcode: {
			required: true,
			digits: true,
			
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
					<h3 class="page_title fl_left"><?php if($suggest_bar_id==""){ echo 'Add Suggest Bar'; } else { echo 'Edit Suggest Bar'; }?></h3>
					<a style="margin-top: 20px;" href="javascript:oid(0)" onclick="setaction('chk[]','pending', 'Are you sure, you want to app selected record(s)?', 'frm_listlogin');" class="btn purple fl_right mar_r_5" >Approved</a>
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
				echo form_open_multipart('suggest_bar/add_suggest_bar/',$attributes);
			  ?>
		
									
		                	
			  <div class="control_group">
										<label class="control_label">Bar Title:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" maxlength="200" placeholder="Bar title...." class="m_wrap wid360" name="bar_name" id="bar_name" value="<?php echo $bar_name; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Address :<i style="color: #7D2A1C;">*</i></label>
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
										<label class="control_label">Phone No :<i style="color: #7D2A1C;">*</i> </label>
										<div class="controls">
											<input type="text" placeholder="Phone No...." class="m_wrap wid360" name="phone" id="phone" autocomplete="off" value="<?php echo $phone_number; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									
									
									
									
									<div class="control_group">
										<label class="control_label">Zip code: <i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Zipcode" class="m_wrap wid360" name="zipcode" id="zipcode" value="<?php echo $zip_code; ?>">
										</div>										
										<div class="clear"></div>
									</div>
			  						
								
							<!-- </div> -->	
							<input type="hidden" name="suggest_bar_id" id="suggest_bar_id" value="<?php echo $suggest_bar_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
					
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php if($suggest_bar_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" onclick="return GetFileSize('bar_video_file');"/>
						<?php if($redirect_page == 'list_bar')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>bar/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>bar/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" onclick="return GetFileSize('bar_video_file');" />
						
						<?php if($redirect_page == 'list_bar')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>bar/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>bar/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
					<?php } ?>
					
					
					
					</form>		
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>



<form name="frm_listlogin" id="frm_listlogin" action="<?php echo base_url();?>suggest_bar/action_suggest_bar" method="post">
					<input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
					<input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
					<input type="hidden" name="serach_keyword" id="serach_keyword" value="<?php echo $keyword; ?>" />
					<input type="hidden" name="serach_option" id="serach_option" value="<?php echo $option; ?>" />
            	   <input type="hidden" name="chk[]" id="chk" value="<?php echo $suggest_bar_id; ?>" />
            	     <input type="hidden" name="action" id="action" />
				   <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>

								</form>