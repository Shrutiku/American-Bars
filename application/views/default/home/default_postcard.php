<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
//===== Usual validation engine=====//
	$("#frm_login").validate({
		rules: {			
			code: {
				required: true,
			},								
		  	errorClass:'error fl_right'			
		}
	});	
});
</script>

<!-- ########################################################################################### -->
<!-- content -->
<div class="wrapper row6 padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow" style="width: 90%;">
     				<div class="result_search">
	     				<div class="result_search_text">Post Card Login Page</div>
     				</div>
				
                        
                     
     				<div class="pad20">
     				<h1 class="yellow_title padb10 br_bott_gray">Congratulations, you have received a Post Card from American Bars. Please enter the code printed on your postcard.  </h1>
					<?php $attributes = array('id'=>'frm_login','name'=>'frm_login','class'=>'form-horizontal','rolde'=>'form');
							echo form_open('postcard/',$attributes); ?>	
	     						<input type="hidden" name="type" value="bar_owner" id="type" />
	     						<input type="hidden" name="postcardid" id="postcardid" />
	     						<br><br>
	     							<?php if($error!=""){ ?>
                        <div class="error1 text-center"><a class="closemsg" data-dismiss="alert"></a><span><?php echo $error; ?></span></div>
                        <?php }?>
   
	        				 <div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Code :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="code" placeholder="Your Code" name="code">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
                        	<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7">
		                       		
		        					<div class="mar_top4">
                                    <button class="btn btn-lg btn-primary"  type="submit" name="submit"  id="submit" />Enter</button>
		        					</div>
		        					<div class="clearfix"></div>
		        				</div>
		        				<div class="clearfix"></div>
	                       	</div>	                       
	        			</form>
	        		</div>
     			</div>
     		</div>
   		</div>
   	</div>
<!-- ************************************************************************ -->
