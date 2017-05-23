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
                    <div class="fullmug_block">
                        <?php // if($getbar['bar_type']=='full_mug'){?>
                        <?php // } ?>
                        <div class="col-md-4 coctail-new col-sm-12 padb20">
     				<div class="bar_bg">
     					<h1 class="box_title">Beers</h1>
     					<ul class="bottom_box" id="infinite-list">
     					
	         		<div class="clear"></div></ul><div class="clear"></div>
     				</div>
     			</div>
     			<div class="col-md-4 coctail-newright col-sm-12 padb20">
     				<div class="bar_bg">
     					<h1 class="box_title">Cocktails</h1>
     					<ul class="bottom_box" id="infinite-list-cocktail">
     					
	         		<div class="clear"></div></ul><div class="clear"></div>
     				</div>
     			</div>     		
     			<div class="col-md-4 coctail-newright col-sm-12 padb20">
     				<div class="bar_bg">
     					<h1 class="box_title">Liquors</h1>
     					<ul class="bottom_box" id="infinite-list-liquor">
     					
	         		<div class="clear"></div></ul><div class="clear"></div>
     				</div>
     			</div>	
                    </div>
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
                     
<link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/css/prettify.css">
<script src="<?php echo base_url().getThemeName(); ?>/js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url().getThemeName(); ?>/js/prettify.js"></script>
<script type="text/javascript">
    $(function(){
        $('#infinite-list').slimscroll({
          alwaysVisible: true,
          height: 410,
          color: '#f19d12',
          opacity: .8
        });

          $('#infinite-list-cocktail').slimscroll({
          alwaysVisible: true,
          height: 410,
          color: '#f19d12',
          opacity: .8
        });

        $('#infinite-list-liquor').slimscroll({
          alwaysVisible: true,
          height: 410,
          color: '#f19d12',
          opacity: .8
        });
      });
</script>
<!--------------End Scroll ------------------->
<style>
    #gmap_marker {
        height: 322px;
        width: 100%;
    }
    .gm-style-iw {
        color:#000000;
    }
    #infinite-list {
        height: 410px;
        width: 95%;
        margin-left: auto;
        margin-right: auto;
        overflow-x: hidden;
        overflow-y: scroll;
    }
    #infinite-list-cocktail {
        height: 410px;
        width: 95%;
        margin-left: auto;
        margin-right: auto;
        overflow-x: hidden;
        overflow-y: scroll;
    }
    #infinite-list-liquor {
        height: 410px;
        width: 95%;
        margin-left: auto;
        margin-right: auto;
        overflow-x: hidden;
        overflow-y: scroll;
    }
</style>
<?php $theme_url = $urls= base_url().getThemeName();?>
<script>
//	var base_url = '<?php // echo site_url('bar/getmorebeer/?bar_id='.$bar_detail['bar_id']); ?>';
//	var base_url_cocktail = '<?php // echo site_url('bar/getmorecocktail/?bar_id='.$bar_detail['bar_id']); ?>';
//	var base_url_liquor = '<?php // echo site_url('bar/getmoreliquor/?bar_id='.$bar_detail['bar_id']); ?>';
        var base_url = '<?php echo site_url('bar/getmorebeer/?bar_id='.$getbar['bar_id']); ?>';
	var base_url_cocktail = '<?php echo site_url('bar/getmorecocktail/?bar_id='.$getbar['bar_id']); ?>';
	var base_url_liquor = '<?php echo site_url('bar/getmoreliquor/?bar_id='.$getbar['bar_id']); ?>';
</script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/css/jquery.bxslider.css" />
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/infiniteScroll.js"></script>
<script type="text/javascript">InfiniteList.loadData(0,15); InfiniteList.loadData_cocktail(0,15);InfiniteList.loadData_liquor(0,15);</script>
