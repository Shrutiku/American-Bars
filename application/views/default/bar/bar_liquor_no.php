<script>
	 var test = '<a href="#suggestmodal" data-toggle="modal" class="yellowlink">Suggest New Liquor</a>';
	
</script>
<div class="modal fade login_pop2" id="suggestmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
					   <?php echo $this->load->view(getThemeName().'/bar/liquor_suggest');?>
</div>	
<div class="wrapper row6 padtb10 has-js">
     	<div class="container">
     		<div class="margin-top-50 bg_brown">
     			<?php echo $this->load->view(getThemeName().'/home/dashboard_menu'); ?>
     			<div class="dashboard_detail">
     				<div class="result_search event"><div class="result_search_text"><i class="strip cocktails"></i> Liquors</div></div>
		     		<div class="dashboard_subblock">
		     		  <h3>Liquor is not Activated .</h3>
		     		</div>
     	<div class="clearfix"></div>
     </div>
   </div>
 </div>
