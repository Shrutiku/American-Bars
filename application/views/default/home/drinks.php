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
                            <div class='pull-left'><div class="result_search_text"><i class="strip cocktails"></i>Drinks on Your Menu</div></div>
                        <div class="clear"></div>
                    </div>
                    <div class="fullmug_block" style="width: 100%; padding-left: 3%">
                        <?php // if($getbar['bar_type']=='full_mug'){?>
                        <?php // } ?>
                        <div class="col-md-4 coctail-new col-sm-12 padb20">
                            <h2  style="align: center;">Beers
                                <a class="btn btn-lg btn-primary marr_10 pull-right" id="drink-btn" href="<?php echo site_url('/bar/bar_beer');?>">Edit</a>
                                <a class="btn btn-lg btn-primary marr_10 pull-right" id="drink-btn" href="<?php echo site_url('/bar/choose_beer');?>">Add</a>
                            </h2>
                                <div class="bar_bg">
     					<!--<h1 class="box_title">Beers</h1>-->
     					<ul class="bottom_box" id="infinite-list">
     					
	         		<div class="clear"></div></ul><div class="clear"></div>
     				</div>
     			</div>
     			<div class="col-md-4 coctail-newright col-sm-12 padb20">
                            <h2  style="align: center;">Cocktails
                                <a class="btn btn-lg btn-primary marr_10 pull-right" id="drink-btn" href="<?php echo site_url('/bar/bar_cocktail');?>">Edit</a>
                                <a class="btn btn-lg btn-primary marr_10 pull-right" id="drink-btn" href="<?php echo site_url('/bar/choose_cocktail');?>">Add</a>
                            </h2>
                                <div class="bar_bg">
     					<!--<h1 class="box_title">Cocktails</h1>-->
     					<ul class="bottom_box" id="infinite-list-cocktail">
     					
	         		<div class="clear"></div></ul><div class="clear"></div>
     				</div>
     			</div>     		
     			<div class="col-md-4 coctail-newright col-sm-12 padb20">
                            <h2  style="align: center;">Liquors
                                <a class="btn btn-lg btn-primary marr_10 pull-right" id="drink-btn" href="<?php echo site_url('/bar/bar_liquor');?>">Edit</a>
                                <a class="btn btn-lg btn-primary marr_10 pull-right" id="drink-btn" href="<?php echo site_url('/bar/choose_liquor');?>">Add</a>
                            </h2>
                                <div class="bar_bg">
     					<!--<h1 class="box_title">Liquors</h1>-->
     					<ul class="bottom_box" id="infinite-list-liquor">
     					
	         		<div class="clear"></div></ul><div class="clear"></div>
     				</div>
     			</div>	
                    </div>
<!--                                <div class="container">
                                    <div class='pull-left' style="text-align: center;"><div class="result_search_text">What kind of drink would you like to add?</div></div>
                                        <div class="margin-top-50 bg_brown" style="text-align: center;">
                                            <a class="btn btn-lg btn-primary marr_10"  href="<?php echo site_url('/bar/choose_cocktail');?>">Cocktail</a>
                                            <a class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('/bar/choose_beer');?>">Beer</a>
                                            <a class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('/bar/bar_liquor');?>">Liquor</a>
                                        </div>
                                </div>-->
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
        margin-left: auto;
        margin-right: auto;
        overflow-x: hidden;
        overflow-y: scroll;
    }
    #infinite-list-cocktail {
        height: 410px;
        background: '#222018',
        margin-left: auto;
        margin-right: auto;
        overflow-x: hidden;
        overflow-y: scroll;
    }
    #infinite-list-liquor {
        height: 410px;
        margin-left: auto;
        margin-right: auto;
        overflow-x: hidden;
        overflow-y: scroll;
    }
    #drink-btn {
        padding: auto;
        padding-top: 1%;
        padding-bottom: 1%;
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
        var limit = 100;
</script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/css/jquery.bxslider.css" />
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/infiniteScroll.js"></script>
<script type="text/javascript">InfiniteList.loadData(0,15); InfiniteList.loadData_cocktail(0,15);InfiniteList.loadData_liquor(0,15);</script>