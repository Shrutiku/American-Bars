<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/ckeditor/ckeditor.js"></script>
<script>
	$(document).ready(function() {
		 $('#frm_sug').on('submit', function() {
        	
                for(var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            });
            
		CKEDITOR.replace( 'description', {
	toolbar: [
		{ name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
		[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],			// Defines toolbar group without name.
		'/',																					// Line break - next group will be placed in new line.
		{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] }
	]
});
});
</script>
 <script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'white'
 };
 </script>
<script type="text/javascript">
	$(document).ready(function(){
//===== Usual validation engine=====//
	$("#frm_sug").validate({
		rules: {			
			type: {
				required: true,
			},			
			text: {
				required: true,
			},	
			remarks: {
				required: true,
			},	
			description: {
				required: true,
			},	
			number: {
				required: true,
				number:true,
			},
			name:{
			    required: true,
			},
			email: {
				required: true,
				email:true,
			},
						
		  	errorClass:'error fl_right'			
		}
	});	
});
</script>

<!-- ########################################################################################### -->
<!-- content -->

<div class="wrapper row4">
   		<div class="container clearfix">
   			<div id="" class="carousel slide">
        	<div class="carousel-inner">
          	<div class="active item">
            	<img src="<?php echo base_url().getThemeName(); ?>/images/smallbanner1.png" alt="American Bars"/>
          </div>
          <div class="item">
            <img src="<?php echo base_url().getThemeName(); ?>images/smallbanner1.png" alt="American Bars"/>
          </div>
        </div>
        
   	</div>
	</div>
  </div>
<div class="wrapper row5">
     	<div class="container">
     	  <div class="">
     	   <div class="textbox_block">
     		<div class="result_search">
	     		<div class="result_search_text">Suggest Adverstisement</div>
     		</div>
     		<div class="text-center pad_t15b20">
     			<?php  
     				$msg = $this->session->flashdata('msg');
     				if($msg != "") {
						
						if($msg == 'success') {
						
							echo '<div class="success"><p>Your advertisement suggestion send successfully . AB will contact you as soon as possible .</p></div>';
							
						}
					
					}
					
					if($error != "") {
						
						if($error == 'insert') {
							echo '<div class="success"><p>Record has been updated Successfully.</p></div>';
						}
					
						if($error != "insert"){	
							echo '<div class="error1">'.$error.'</div>';	
						}
					}
				?>		
				<div class="clearfix"></div>
     			<?php
				$attributes = array('id'=>'frm_sug','name'=>'frm_sug','class'=>'main');
				echo form_open_multipart('home/suggest_advertise/',$attributes);
			  ?>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Advertisement Type : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="type" name="type" value="<?php echo @$type; ?>" >
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Advertisement Text : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="text" name="text" value="<?php echo @$text; ?>" >
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Remarks : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="remarks" name="remarks" value="<?php echo @$remarks; ?>" >
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Description : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<textarea rows="5" placeholder="Description" name="description" id="description" class="form-control ckeditor form-pad"><?php echo @$description; ?></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Contact Person : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" value="<?php echo @$name; ?>" id="name" name="name">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Number : <span class="aestrick"> * </span></label>
	        				 	</div>
	        				 	<div class="input_box col-sm-7">
	                       		<input type="text" class="form-control form-pad" value="<?php echo @$number; ?>" id="number" name="number">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Email : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" value="<?php echo @$email; ?>" id="email" name="email">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10 text-left">
	                       			<input type="submit" name="submit" id="submit" value="Submit" class="btn btn-lg btn-primary marr_10" />
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="clearfix"></div>
	        			</form>
     		</div>
     	 </div>
     	 </div>
     		
     		<div class="clearfix"></div>
   		</div>
   	</div>
