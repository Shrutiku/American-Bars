<?php
$theme_url = $urls= base_url().getThemeName();
?>
<script type="text/javascript">
		  $(document).ready(function() {
		       
		       $('#faqs ul li').click(function() {
		       
				 var id = this.id;
				var cl =$("#"+this.id).attr('class');
				
				if(cl =="active")
				{
					 $("#"+id).removeClass("active");
				}
				else
				{
					
				     $("#"+id).addClass("active");
				 
				} 
				 $("#ans"+id).slideToggle();
				 
				
				
				});
		        
		        
		        
		     });
		    
		    

</script>

<script type="text/javascript">
	$("#accordion").tabs("#accordion div.pane", {
    tabs: 'h2',
    effect: 'slide'
  }); 
</script>
<!-- content -->
<div class="wrapper row3 padtb20">
  <div id="container" class="clear">
  	<div class="row">
  		<h1 class="maintitle">FAQ</h1>
  		<div class="form-control-group">
  			<div>
  				<?php 
  				   $attributes = array('id'=>'search_faq','name'=>'search_faq');
					echo form_open_multipart('home/faq',$attributes); 
					
					?>
	  			<input type="text" name="keyword" id= "keyword" value="<?php if($keyword != "1v1"){echo $keyword;} ?>" class="input wrap extralarge br_silver fl_left marr10" placeholder="Type Your Question Here"/>
	  			<button type="submit" class="button fl_left">Search</button>
	  			
	  		</form>
	  			<div class="clear"></div>
  			</div>
  		</div>
  	</div>
  	<div class="row">
  		<div class="left_block" >
  			<h2>Top Frequently Asked Questions</h2>
	  		<div class="faq_block" id="faqs">
	  			<ul class="faqdiv">
	  				
	  				<?php
	  				if($all_faq)
					{
						$i =1;
						foreach($all_faq  as $af)
						{?>
							<li id="<?php echo $i; ?>" <?php if($i==1){?> class= "active" <?php } ?> >
	  					<div class="fl_left">Question<?php echo $i; ?> : </div>
	  					<div class="fl_right wid580"><?php echo $af->faq_question; ?></div>
	  					<div class="clear"></div>
	  				</li>
	  				<li <?php if($i==1){?> class="ansblock" <?php } else {?> class="ansblock hide1" <?php } ?>  id="ans<?php echo $i; ?>">
	  					<div class="fl_left">Answer1 : </div>
	  					<div class="fl_right wid580"><?php echo $af->faq_question; ?></div>
	  					<div class="clear"></div>
	  				</li>
				 <?php 
						$i++;
						}
						
					}else
						{
	  				?>     <li>Faq Not found</li>
	  				
	  				<?php }?>
	  				

	  			</ul>
	  			
	  			
	  			
	  			
	  		</div>
	  		
	  		
	  		
	  		
  			
  		</div>
  		<div class="right_block">
  			<h2 class="smalltitle">Advertisement</h2>
  			<div class="mart7"><img src="<?php  echo $theme_url ;?>/images//adv1.png"/></div>
  		</div>
  		<div class="clear"></div>
  	</div>

  </div>
</div>
<!-- ########################################################################################### -->