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
                            <?php if($getbar['bar_type']=='half_mug'){?>
                                    <div class="pull-right marr_10">
                                            <!-- <a href="#" class="review">Upgrade to Full Mug</a> -->
                                            <a class="review" name="" href="<?php echo site_url('home/registration_step3_upgrade/'.base64_encode($getbar['bar_id']).'/fullmug');?>">Upgrade to Full Mug</a>
                                    </div>
                            <?php } ?>

                            <?php if(($getbar['bar_type']=='half_mug' || $getbar['bar_type']=='full_mug' && $getbar['is_managed']=='no') ){?>
                                    <div class="pull-right marr_10">
                                        <!-- <a href="#" class="review">Upgrade to Full Mug</a> -->
                                        <a class="review" name="" href="<?php echo site_url('home/registration_step3_upgrade/'.base64_encode($getbar['bar_id']).'/managed');?>">Upgrade to  Managed Account</a>
                                    </div>
                           <?php } ?>
                                <div class="clear"></div>
                            </div>
                            <div class="dashboard_subblock">
                                <?php if($getbar['bar_type']=='full_mug'){?>
                                <div>
                                    <div class="mug_block parrot margin-right-25">
                                        <div class="">
                                            <a href="<?php echo site_url('bar/list_message')?>">Messages</a>
                                                <p class="mug_count">
                                                    <a href="<?php echo site_url('bar/list_message')?>"><?php echo $this->home_model->getmessagecount();?></a></p>
                                                <a href="<?php echo site_url('bar/postcard')?>">Post Cards</a>
                                                <p class="mug_count">
                                                    <a href="<?php echo site_url('bar/postcard')?>"><?php echo $this->home_model->get_bar_postcard_count(@$getbar['bar_id']); ?></a></p>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div id="list_show">	
                                    <div class="wrapper row6 padtb10 has-js">
                                        <div class="container">
                                            <div class='pull-left' style="text-align: center;"><div class="result_search_text">Select a settings function.</div></div>
                                                <div class="margin-top-50 bg_brown" style="text-align: center;">
                                                    <a class="btn btn-lg btn-primary marr_10"  href="<?php echo site_url('/home/changepassword');?>">Change Password</a>
                                                    <a class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('/home/domainmanagement');?>">Domain Management</a>
                                                    <a class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('/home/barlistings');?>">Bar Listings</a>
                                                    <a class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('/home/updatebanner');?>">Update Banner</a>
                                                    <a class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('/home/updatecard');?>">Update Credit Card</a>
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
    function getData()
    {
    	var id = '<?php echo @$getbar['bar_id']; ?>';
    	 $.ajax({
	       type: "POST",
		   url: "<?php echo site_url('bar/getbardata')?>",
		   data : {id:id},
		     beforeSend : function() {
		   		$('#dvLoading').fadeIn('slow');
		   },
		    complete : function() {
		   		$('#dvLoading').fadeOut('slow');
		   },		
		   success: function(response) {
		   	//alert('response');
		   	//alert(response);
		   	 $('#list_hide').empty();
		   	 $("#list_hide").slideDown();
		     $('#list_hide').html(response);
		    
		     initialize_map();
		  }
	   });
    }
</script>
