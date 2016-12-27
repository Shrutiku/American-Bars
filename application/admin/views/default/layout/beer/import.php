<script>
	function progressbar()
	{
		
		$("#dvLoading").show();
	}
</script>
<style>
	#dvLoading {
    opacity: 1 !important;
}
#dvLoading {
    background: url("<?php echo base_url().getThemeName();?>/images/black_bg.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
    display: none;
    height: 100%;
    position: fixed;
    width: 100%;
    z-index: 1000000;
}
.dvLoading {
    background: url("<?php echo base_url().getThemeName();?>/images/page_loader2.gif") no-repeat scroll center center rgba(0, 0, 0, 0);
    height: 55px;
    margin: 10% 50%;
    width: 54px;
}
</style>

<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/bootstrap-fileupload.css" />
<script src="<?php echo base_url().getThemeName();?>/js/jquery-migrate-1.0.0.js"></script>
<script src="<?php echo base_url().getThemeName();?>/js/bootstrap-fileupload.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/jquery.tagsinput.css" />

<script src="<?php echo base_url().getThemeName();?>/js/jquery.tagsinput.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>
<script>

jQuery(document).ready(function(){
	
	var form1 = $('#import');
    var error1 = $('.alert-error', form1);
    var success1 = $('.alert-success', form1);

    form1.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-inline', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",
        rules:{
            csv: {required: true,  extension: "xls"}
            
        },
       
       submitHandler: function (form) {
                    success1.show();
                    error1.hide();
                    $("button[type=submit]").prop("disabled",true);
                    form.submit();
                }
            });
            $.validator.addMethod("alphanumeric", function(value, element) {
		        return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
		    }, "Please provide only alpha numeric.");
});

</script>

<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title">Import Beers</h3>					
				</div>
				<div class="row_fluid"> 
				<?php  
				if($msg != "") {
				
						$msg= explode('-',$msg);
						//echo $msg[0]; 
						$c = $msg[1]-12;
						if($msg[0] == 'xls_not_valid') {
							echo '<div class="error_red"><p>Xls File Not Valid. You have '.$c.' blank column please remove it and ty again.</p></div>';
		}
		}		
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
						<div class="portlet-body form">
							<div class="content">
								<?php
				$attributes = array('id'=>'import','name'=>'import','class'=>'main','onsubmit'=>'progressbar()');
				echo form_open_multipart('beer/import_csv',$attributes);
			  ?>
			<div class="control-group">
											<label class="control-label">Select File:</label>
											<div class="controls">
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
															<span class="btn btn-file">
															<span class="fileupload-new">Select File</span>
															<span class="fileupload-exists">Change</span>
															<input  type="file"   class="default" name="csv" id="csv" /></span>
															<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
															<div class="clearfix"></div>
															<span for="csv" style="display: none;" generated="true" class="help-inline">Please select file with csv extension.</span>
														</div>														
													</div>
												</div>
										
										<div class="clear"></div>
									</div>
								
							<div class="form_action">
								
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
					
					
					</form>		
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
</div>