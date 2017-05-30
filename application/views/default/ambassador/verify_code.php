<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin/default/assets/plugins/select2/select2_metro.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>admin/default/assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>admin/default/assets/plugins/select2/select2.min.js"></script>
<style>
    .select2-container-multi.select2-dropdown-open .select2-choices, .select2-container-multi.select2-container-active .select2-choices
    {
        border: 0px;
    }
    .select2-container-multi .select2-choices, .select2-container-multi.select2-dropdown-open .select2-choices, .select2-container-multi.select2-container-active .select2-choices

    {
        background:none !important;
        border: none !important;
    }
</style>

<?php } ?>
<div class="wrapper row5 beer-list" style="border:<?php echo $v == 0 ? 'none' : ''; ?>">
    <div class="container">
        <div class="result_box clearfix mar_top30bot20">
            <div class="login_block br_green_yellow">
                <div class="result_search">
                    <i class="strip login_icon"></i><div class="result_search_text">Registration</div>
                </div>
                <div>
                    <h1 class="yellow_title padb10 br_bott_gray text-center padding-bottom-15">Verify Your Phone Number</h1>
                    
                    <div class="pad20">
<?php
if ($error != "") {
    echo "<div class='error1 text-center'>" . $error . "</div>";
}
?>
                        <form class="form-horizontal" role="form" name="verify_code" id="verify_code" action="<?php echo site_url("ambassador/verify_code/"); ?>" method="post">
                            <div class="padtb" style="text-align: left">
                                <p class="bar_add">Please enter the code sent to your mobile phone:</p>
                                <div class="clearfix"></div>
                                <div class="col-sm-3" style="text-align: left;">
                                    </div>
                                    <div class="input_box col-sm-3">
                                        <input type="text" class="form-control form-pad" id="code" name="code" style="width:150px">
                                    </div>    
                                    <button class="btn btn-lg btn-primary"  type="submit" name="submit"  id="submit" />Verify</button>
                                    <!-- </div> -->
                                    <div class="clearfix"></div>  
                            </div>
                            <div class="padtb8">    
                                <!-- <div class="col-sm-3"></div> -->
                                <!-- <div class="col-sm-7 mart10"> -->

                                <a class="btn btn-lg btn-primary btn-next pull-left" href="<?php echo site_url('home'); ?>"><i class="previous-arrow-icon"></i> Cancel</a>
                                <!-- </div> -->
                                <div class="clearfix"></div>
                            </div>

                            <!--<input type="hidden" name="temp_id" id="temp_id" value="<?php// echo @$getbardata['temp_id'] ?>" />-->
                            <!--<input type="hidden" name="user_id" id="user_id" value="" />-->
                            <!--<input type="hidden" name="bar_id" id="bar_id" value="<?php// echo @$bar_id; ?>" />-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ************************************************************************ -->
?>