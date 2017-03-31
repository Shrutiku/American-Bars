<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<div class="wrapper row6 padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow" style="width: 90%;">
     				<div class="result_search">
	     				<div class="result_search_text">Ambassador Signup</div>
     				</div>
				
                        
                     
     				<div class="pad20">
                                    <h1 align="center" class="yellow_title padb10 br_bott_gray">Welcome to American Bars. Verify your phone number to complete your ambassador registration.</h1>
                                    <?php $attributes = array('id'=>'frm_login','name'=>'frm_login','class'=>'form-horizontal','rolde'=>'form');
                                                    echo form_open('ambassador/',$attributes); ?>
                                                    <br><br>
                                    <?php if($error!=""){ ?>
                                    <div class="error1 text-center"><a class="closemsg" data-dismiss="alert"></a><span><?php echo $error; ?></span></div>
                                    <?php }?>
   
                                    <div class="padtb8">
                                           <div class="col-sm-3">
                                                   <label class="control-label">Phone Number :</label>
                                           </div>
                                    <div class="input_box col-sm-7">
                                            <input type="text" class="form-control form-pad" id="phone_num" placeholder="310 555 1234" name="phone_num">
                                    </div>
                                    <div class="clearfix"></div>
                                    </div>
                                    <div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7">
		                       		
                                            <div class="mar_top4">
                                                <button class="btn btn-lg btn-primary"  type="submit" name="submit"  id="submit" onclick="showDiv()">Enter</button>
                                            </div>
                                            <div class="clearfix"></div>
		        		</div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div id="showdiv" class="padtb8" style="display:none;">
                                           <div class="col-sm-3">
                                                   <label class="control-label">Phone Number :</label>
                                           </div>
                                    <div class="input_box col-sm-7">
                                            <input type="text" class="form-control form-pad" id="phone_num" placeholder="310 555 1234" name="phone_num">
                                    </div>
                                    <div class="clearfix"></div>
                                    </div>
	        		</div>
     			</div>
     		</div>
   		</div>
   	</div>
<script>
function showDiv() {
   document.getElementById('welcomeDiv').style.display = "block";
}
    </script>