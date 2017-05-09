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
                    <h1 align="center" class="yellow_title padb10 br_bott_gray">Welcome to American Bars. <br>Verify your phone number to complete your ambassador registration.</h1>
                    <?php $attributes = array('id'=>'frm_login','name'=>'frm_login','class'=>'form-horizontal','rolde'=>'form'); echo form_open('ambassador/',$attributes); ?>
                    <br><br>
                    <?php if($error!=""){ ?>
                    <div class="error1 text-center"><a class="closemsg" data-dismiss="alert"></a><span>////<?php echo $error; ?></span></div>
                    <?php }?>
                    <div>
<!--                    <h1 class="yellow_title padb10 br_bott_gray text-center padding-bottom-15">Verify Your Phone Number</h1>-->
                    
                    <div class="pad20">
                        <form class="form-horizontal" role="form" name="register" id="register" action="<?php //echo site_url("home/claim_bar_owner_register/" . $new_bar_id); ?>" method="post">
                            <div class="padtb" style="text-align:center; ">
                                
                                <p class="bar_add yellow_title">We'll send an activation code via SMS to your mobile phone.</p>

                                <div class="clearfix"></div>
                                <div class="input box col-sm-4" style="text-align: center;"></div>
                                <div class="input box col-sm-2" style="text-align: center;">
                                    <input type="text" class="form-control form-pad" id="phone_number" name="phone_number" style="width:150px">
                                </div>
                                <div class="col-sm-2" style="text-align: center"> 
                                    <button class="btn btn-lg btn-primary"  type="submit" name="submit"  id="submit" />Verify</button>
                                </div>
                                <div class="input box col-sm-4" style="text-align: left;"></div>
                                    <div class="clearfix"></div>  
                                </div>
                            </div>
                            <div class="col-sm-2 col-sm-offset-5" style="text-align:center; ">

                                <a class="btn btn-lg btn-primary btn-next" href="<?php echo site_url('home'); ?>"><i class="previous-arrow-icon"></i> Cancel</a>
                                <div class="clearfix"></div>
                            </div>

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