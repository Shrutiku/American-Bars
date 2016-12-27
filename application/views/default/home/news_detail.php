

<div class="wrapper row5">
     	<div class="container">
     	<div class="beer_details">
     		<div class="mar_top20">
	     		<div class="left_block">
	     			<div class="result_search">
	     				<div class="result_search_text">News Details</div>
     				</div>
     		<div id="list_hide">		
     				<div class="padtb10 pad_lr10 br_bott_gray ">
     					<a href="<?php echo site_url('home/news_details/'.$result->slug); ?>" class="beer_title"><?php echo ucfirst($result->news_title);?></a>
     					<div class="result_desc" style="font-size: 11px; font-style: italic;">Published By <?php echo $result->author_name; ?> on <?php echo getDuration($result->date_added); ?> <!-- | Category | <a href="#" class="newsyellow">Hits (1)</a> --></div>
     					<div class="img_wid95 ">
     						
     						<div class="result_desc padtb10">
     							
     							 <?php  echo $result->news_desc; ?>
     						</div>
     					</div>
     					
     				</div>
     				
     			
     			<div class="clearfix"></div>	
     				
				</div>	
	     		</div>
	     		<!-- <div class="clearfix"></div> -->
	     		<div class="right_block_releated">
	     			<div class="text-left">
	     				<h1 class="productbar_title">Latest News</h1>
	     				<div class="clearfix"></div>
	     				<?php if($latest_mews){
	     					
	     					  foreach($latest_mews as $rows_new){
	     					  	
							//die;?>
	     				<div>
	     					
	     					
		     				<div>
		     					<a href="<?php echo site_url('home/news_details/'.$rows_new->slug); ?>" class="beer_title"><?php echo ucfirst($rows_new->news_title);    ?></a>
		     				</div>
		     				<div class="result_desc padtb">
	     						<?php if(strlen(strip_tags($rows_new->news_desc)) > 200){ echo substr(strip_tags($rows_new->news_desc), 0 , 400)."..."; } else { echo strip_tags($rows_new->news_desc).""; }  ?> 
	     					</div>
     					</div>
     					<?php } } ?>
     					
	     			</div>
	     			
	     			
	     			
	     			
	     		</div>
	     		<div class="clearfix"></div>
	     	</div>
     	</div>	
   		</div>
   	</div>
   	
   	
   	<div itemscope itemtype="http://schema.org/LocalBusiness" style="display:none;">
   	

		<span itemprop="name"><?php echo $result->news_title;?></span>
		<div itemprop="description"> <?php echo  $result->news_desc;?></div>
			
			
			
			
	</div>
 	