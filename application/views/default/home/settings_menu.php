<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/plugin/Tokenize/jquery.tokenize.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/plugin/Tokenize/jquery.tokenize.css" />


<!--<script>
    var test = '<a href="#suggestmodal" data-toggle="modal" class="yellowlink">Select a settings function</a>';
	
</script>-->

<!--<div class="modal fade login_pop2" id="suggestmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <?php //echo $this->load->view(getThemeName().'/bar/cocktail_suggest');?>
</div>	-->
<?php $theme_url = $urls= base_url().getThemeName();?>
<div class="wrapper row6 padtb10 has-js">
    <div class="container">
        <div class="margin-top-50 bg_brown">
                <?php echo $this->load->view(getThemeName().'/home/dashboard_menu'); ?>

                <div class="dashboard_detail">
                    <div class="result_search">
                            <div class='pull-left'><div class="result_search_text">Account Settings</div></div>
                        <div class="clear"></div>
                    </div>
                    <div class="dashboard_subblock">
                        <?php // if($getbar['bar_type']=='full_mug'){?>
                        <?php // } ?>
                        <div id="list_show">	
                            <div class="wrapper row6 padtb10 has-js">
                                <!--<div class="container">-->
                                    <div class='pull-left' style="text-align: center;"><div class="result_search_text">Select a settings function.</div></div>
                                        <div class="margin-top-50" style="text-align: center;">
                                            <a class="btn btn-lg btn-primary marr_10"  href="<?php echo site_url('/home/changepassword');?>">Change Password</a>
                                            <a class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('/home/domainmanagement');?>">Domain Management</a>
                                            <a class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('/home/barlistings');?>">Bar Listings</a>
                                            <a class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('/home/updatebanner');?>">Update Banner</a>
                                            <a class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('/home/updatecard');?>">Update Credit Card</a>
                                        </div>
<!--                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<script>
</script>
