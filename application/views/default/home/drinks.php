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
                            <div class='pull-left'><div class="result_search_text">Bar Owner Dashboard</div></div>
                            <div class='pull-right'><div class="result_search_text"><a href="#userguide" data-toggle="modal" href="javascript://"  class="review mar_r15" >User Guide</a></div></div>
                    <?php // if($getbar['bar_type']=='half_mug'){?>
                            <div class="pull-right marr_10">
                                    <!-- <a href="#" class="review">Upgrade to Full Mug</a> -->
                                    <a class="review" name="" href="<?php // echo site_url('home/registration_step3_upgrade/'.base64_encode($getbar['bar_id']).'/fullmug');?>">Upgrade to Full Mug</a>
                            </div>
                    <?php // } ?>

                    <?php // if(($getbar['bar_type']=='half_mug' || $getbar['bar_type']=='full_mug' && $getbar['is_managed']=='no') ){?>
                            <div class="pull-right marr_10">
                                <!-- <a href="#" class="review">Upgrade to Full Mug</a> -->
                                <a class="review" name="" href="<?php // echo site_url('home/registration_step3_upgrade/'.base64_encode($getbar['bar_id']).'/managed');?>">Upgrade to  Managed Account</a>
                            </div>
                   <?php // } ?>
                        <div class="clear"></div>
                    </div>
                    <div class="dashboard_subblock">
                        <?php // if($getbar['bar_type']=='full_mug'){?>
                        <?php // } ?>
     			<div class="col-md-6 coctail-newright col-sm-5 padb20">
     				<div class="bar_bg">
     					<h1 class="box_title">Cocktails Served at Bar</h1>
     					<ul class="bottom_box" id="infinite-list-cocktail">
     					
	         		<div class="clear"></div></ul><div class="clear"></div>
     				</div>
     			</div>     		
     			<div class="col-md-6 coctail-newright col-sm-5 padb20">
     				<div class="bar_bg">
     					<h1 class="box_title">Liquors Served at Bar</h1>
     					<ul class="bottom_box" id="infinite-list-liquor">
     					
	         		<div class="clear"></div></ul><div class="clear"></div>
     				</div>
     			</div>
                        <div id="list_show">	
                            <div class="wrapper row6 padtb10 has-js">
                                <div class="container">
                                    <div class='pull-left' style="text-align: center;"><div class="result_search_text">What kind of drink would you like to add?</div></div>
                                        <div class="margin-top-50 bg_brown" style="text-align: center;">
                                            <a class="btn btn-lg btn-primary marr_10"  href="<?php echo site_url('/bar/choose_cocktail');?>">Cocktail</a>
                                            <a class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('/bar/choose_beer');?>">Beer</a>
                                            <a class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('/bar/bar_liquor');?>">Liquor</a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<script>
</script>
