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
                    <?php $attributes = array('id'=>'frm_login','name'=>'frm_login','class'=>'form-horizontal','rolde'=>'form'); echo form_open('ambassador/',$attributes); ?>
                    <br><br>
                    <?php if($error!=""){ ?>
                    <div class="error1 text-center"><a class="closemsg" data-dismiss="alert"></a><span>////<?php echo $error; ?></span></div>
                    <?php }?>
                    <div>
                    <h1 class="yellow_title padb10 br_bott_gray text-center padding-bottom-15">Verify Your Phone Number</h1>
                    
                    <div class="pad20">
<?php
if ($error != "") {
    echo "<div class='error1 text-center'>" . $error . "</div>";
}
if ($msg != "" && $msg != "1V1" && !is_numeric($msg)) {
    echo "<div class='success text-center'>" . $msg . "</div>";
}
?>
                        <form class="form-horizontal" role="form" name="register" id="register" action="<?php echo site_url("home/claim_bar_owner_register/" . $new_bar_id); ?>" method="post">
                            <div class="padtb" style="text-align: left">
                                    <p class="bar_add">Bar Name : <?php echo @$bar_title; ?></p>
                                <div class="clearfix"></div>
                                    <p class="bar_add">Bar Address : <?php echo @$address; ?></p>
                                    <p class="bar_add">City : <?php echo @$city; ?></p>
                                <div class="clearfix"></div>
                                    <p class="bar_add">State : <?php echo @$state; ?></p>
                                <div class="clearfix"></div>
                                    <p class="bar_add">Zip Code : <?php echo @$zip; ?></p>                               
                                <p class="bar_add col-sm-12"</p>
                                
                                <p class="bar_add yellow_title">We'll send an activation code via SMS to your mobile phone.</p>

                                <div class="clearfix"></div>
                                <div class="col-sm-3" style="text-align: left;">
                                    <label class="control-label">Phone Number: <span class="aestrick"> * </span></label>
                                    </div>
                                    <div class="input_box col-sm-3">
                                        <input type="text" class="form-control form-pad" id="phone_number" name="phone_number" style="width:150px">
                                    </div>    
                                    <button class="btn btn-lg btn-primary"  type="submit" name="submit"  id="submit" />Verify</button>
                                    <!-- </div> -->
                                    <div class="clearfix"></div>  
                                </div>
                            </div>
                            <div class="padtb8">
                                <!-- <div class="col-sm-3"></div> -->
                                <!-- <div class="col-sm-7 mart10"> -->

                                <a class="btn btn-lg btn-primary btn-next pull-left" href="<?php echo site_url('home'); ?>"><i class="previous-arrow-icon"></i> Cancel</a>
                                <!-- </div> -->
                                <div class="clearfix"></div>
                            </div>

                            <input type="hidden" name="temp_id" id="temp_id" value="<?php echo @$getbardata['temp_id'] ?>" />
                            <input type="hidden" name="user_id" id="user_id" value="" />
                            <input type="hidden" name="bar_id" id="bar_id" value="<?php echo @$bar_id; ?>" />
                            <input type="hidden" name="new_bar_id" id="new_bar_id" value="<?php echo $new_bar_id; ?>" />

                        </form>
                    </div>
                    <!--<div class="padtb8">
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
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    
    </script>