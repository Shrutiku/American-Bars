<div class="wrapper row5">
     	<div class="container">
     	<div class="beer_details">
     		<div class="mar_top20">
	     		<div class="left_block">
	     			<div class="result_search">
	     				<div class="result_search_text">Latest News and Trends</div>
     				</div>
     				
     		<div id="list_hide">		
     		<?php if($result){
     			
     			   foreach($result as $row){?>		
     				<div class="padtb10 pad_lr10 br_bott_gray ">
     					<a href="<?php echo site_url('home/news_details/'.$row->slug); ?>" class="beer_title"><?php echo ucfirst($row->news_title);?></a>
     					<div class="result_desc" style="font-size: 11px; font-style: italic;">Published By <?php echo $row->author_name; ?> on <?php echo getDuration($row->date_added); ?> <!-- | Category | <a href="#" class="newsyellow">Hits (1)</a> --></div>
     					<div class="img_wid95 ">
     						
     						<div class="result_desc padtb10">
     							 <?php if(strip_tags(strlen($row->news_desc)>350)){ echo substr(strip_tags($row->news_desc),0,350).'...' ; } else { echo strip_tags($row->news_desc); } ?>
     						</div>
     					</div>
     					
     				</div>
     				
     			<?php } } ?> 
     			
     			<div class="pagination" >
	     				<?php echo $page_link;?>
     				</div><div class="clearfix"></div>	
     				
     				<input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
					<input type="hidden" name="offset" id="offset" value="<?php echo ($offset!='')?$offset:0; ?>" />
					<input type="hidden" name="limit" id="limit" value="<?php echo ($limit>0)?$limit:10; ?>" />
				</div>	
	     		</div>
	     		<!-- <div class="clearfix"></div> -->
	     		<div class="right_block_releated">
	     			<div class="text-left">
	     				<h1 class="productbar_title">Other News</h1>
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
 <script>
 	 $(".pagination li a").click(function() {
 	 	
		  //alert("Handler for .click() called.");
		  var res = $.ajax(
	        {						
			   type: 'POST',
			   url: $(this).attr("href"),
			   dataType: 'post', 
			   cache: false,
			   async: false,
			   beforeSend : function(){
			      $('#dvLoading').fadeIn('slow');
			   },
			   complete: function(){
			   
			     $('#dvLoading').fadeOut('slow');
			     
			    }
			}).responseText;
			
			$("#list_hide").html(res);
			return false;
			
		});
 </script>  	