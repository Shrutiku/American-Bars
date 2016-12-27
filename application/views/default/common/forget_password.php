<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/developer_js/login.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
//===== Usual validation engine=====//
	$("#frm_forget").validate({
		rules: {
			
			username: {
				required: true,
				email: true
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
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
	     				<div class="result_search_text">Forget Password</div>
     				</div>
					<?php if($error!=""){ ?>
                        <div class="error text-center"><?php echo $error; ?></div>
                        <?php }?>
                       <div class="pad20">
                      
		  			<div class="padtb15">
		  				<?php $attributes = array('id'=>'frm_forget','name'=>'frm_forget');
							echo form_open('home/forget_password',$attributes); ?>	
		  					 <div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Email :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="inputEmail3" placeholder="Email" id="email" name="email">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
							
							<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10">
									<button type="submit" name="b1" class="btn btn-lg btn-primary button">Save</button>
									<a href="<?php echo site_url("login"); ?>" class="btn btn-lg btn-primary red fl_right" >Back</a>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
		  				</form>
		  			</div>
     			</div>
     		</div>
   		</div>
   	</div>
<!-- ########################################################################################### -->
<!-- ************************************************************************ -->