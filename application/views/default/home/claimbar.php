<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>

<!-- ########################################################################################### -->
<!-- content -->
<div class="wrapper row6 padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow" style="width: 90%;">
     				<div class="result_search">
	     				<div class="result_search_text">Claim Your Bar in 3 Easy Steps</div>
     				</div>
				<img src="<?php echo base_url() . getThemeName(); ?>/images/claimbar.jpg" border="0" style="max-width:100%;max-height:40%;">
                            
                                                      				<h1 class="yellow_title padb10 br_bott_gray" style="text-align: center;">Step 1:</h1>
                                                                                <p style="text-align: center">Search Your Bar Profile</p>
                                                                                <h1 class="yellow_title padb10 br_bott_gray" style="text-align: center;">Step 2:</h1>
                                                                                <p style="text-align: center;">Click on 'Claim This Bar' Button</p>
                                                                                <img src="<?php echo base_url() . getThemeName(); ?>/images/claimbar_search_result_ex.png" border="0" style="max-width:100%;max-height:20%;">
                                                                                <h1 class="yellow_title padb10 br_bott_gray" style="text-align: center;">Step 3:</h1>
                                                                                <p style="text-align: center;">Finish the Easy and Quick Claim Process</p>

     				<div class="pad20">
     				<h1 class="yellow_title padb10 br_bott_gray" style="text-align: center;">Start Here With Step 1 </h1>
					<form class=""  role="form" action="<?php echo site_url("bar/lists") ?>" method="post">
                			<div class="center pull-left padding-left-10"><input type="text" name="bar_title_new"  id="bar_title_new" class="form-control bar_title_new" placeholder="By Name, City Or Zip"></div>
                    			<div class="center pull-left"><button class="btn btn-lg btn-primary btn-block yellowlink" type="submit">Claim Your Bar Now!</button></div>
              </form>
     			</div>
     		</div>
   		</div>
   	</div>
<!-- ************************************************************************ -->
