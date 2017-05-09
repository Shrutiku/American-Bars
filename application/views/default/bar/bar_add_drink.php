<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/plugin/Tokenize/jquery.tokenize.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/plugin/Tokenize/jquery.tokenize.css" />


<script>
	 var test = '<a href="#suggestmodal" data-toggle="modal" class="yellowlink">Suggest New Cocktail</a>';
	
</script>
<div class="modal fade login_pop2" id="suggestmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
					   <?php echo $this->load->view(getThemeName().'/bar/cocktail_suggest');?>
</div>	
<div class="wrapper row6 padtb10 has-js">
<div class="container">	
<div id="list_show">	
<div class="wrapper row6 padtb10 has-js">
     	<div class="container">
            <div class='pull-left' style="text-align: center;"><div class="result_search_text">What kind of drink you want to add?</div></div>
     		<div class="margin-top-50 bg_brown" style="text-align: center;">
                    <a class="btn btn-lg btn-primary marr_10"  href="<?php echo site_url('/bar/bar_cocktail');?>">Cocktail</a>
                    <a class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('/bar/bar_beer');?>">Beer</a>
                    <a class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('/bar/bar_liquor');?>">Liquor</a>
                </div>
        </div>
</div>
            </div>
</div>
