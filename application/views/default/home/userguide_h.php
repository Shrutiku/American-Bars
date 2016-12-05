
	<style>
		.pad20 p{
			color: #fff;
		}
	</style>

<div class="padtb10">
     	<div>
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				
	        			<div id="signup-form" class="signup">
	        				<div class="result_search">
	        					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	     				<i class="strip login_icon"></i><div class="result_search_text" >Half-Mug Bar User Guide</div>
     				</div> 
     				<div class="pad20">
     						
                            <?php //echo $site_setting->halfmug_user_guide;?>
                            <?php echo $site_setting->halfmug_user_guide!='' ? $site_setting->halfmug_user_guide:'<p>No User Guide Available.</p>';?>
	        			</div>
	        			
	        			
	        		</div>
     			</div>
     		</div>
   		</div>
   	</div>