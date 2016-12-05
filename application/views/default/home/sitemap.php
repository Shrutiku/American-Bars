<div class="wrapper row4">
   		<div class="container clearfix">
   			<div class="carousel slide" id="slider-fixed-banner">
        	<div class="carousel-inner">
          	<div class="active item">
            	<img alt="American Dive Bars" src="<?php echo base_url().getthemename()?>/images/smallbanner1.png">
          </div>
        </div>
        <!-- <a class="left carousel-control" href="#slider-fixed-banner" data-slide="prev">&lsaquo;</a>
        <a class="right carousel-control" href="#slider-fixed-banner" data-slide="next">&rsaquo;</a> -->
        <!-- <div class="submit_bar"><a href="#" class="btn btn-lg btn-primary">Submit Your Bar</i></a></div> -->
        
   	</div>
	</div>
  </div>
  <div class="wrapper row5 forum-listing">
     	<div class="container">
     		
     		<div class="mar_top20"> 
	     		<div class="result_search">
	     			<div class="col-sm-8">
		     			<div class="result_search_text pull-left">Find Bar</div>
		            </div>
		            <div class="clearfix"></div>
	     		</div>
	     		<div>
		     		<div class="sitemap-block">
		     			<ul>
		     		<?php 
		     		   $getbars = getbarsite();
		     		if($getbars){
		     	    foreach($getbars as $row){?>	
		     			
		     					<li><a href="<?php echo site_url('bar/details/'.$row->bar_slug)?>">- <?php echo ucwords($row->bar_title);?></a></li>
		     					</li>
		     		
		     			<?php } }  ?><div class="clear"></div>
		     				</ul>
		     		</div>
	     		</div>
     		</div>
     		
     		<div class="mar_top20"> 
	     		<div class="result_search">
	     			<div class="col-sm-8">
		     			<div class="result_search_text pull-left">Find Beers</div>
		            </div>
		            <div class="clearfix"></div>
	     		</div>
	     		<div>
		     		<div class="sitemap-block">
		     			<ul>
		     		<?php 
		     		   $getbars = getbeersite();
		     		if($getbars){
		     	    foreach($getbars as $row){?>	
		     			
		     					<li><a href="<?php echo site_url('beer/detail/'.$row->beer_slug)?>">- <?php echo ucwords($row->beer_name);?></a></li>
		     					</li>
		     		
		     			<?php } }  ?><div class="clear"></div>
		     				</ul>
		     		</div>
	     		</div>
     		</div>
     		
     		<div class="mar_top20"> 
	     		<div class="result_search">
	     			<div class="col-sm-8">
		     			<div class="result_search_text pull-left">Find Cocktails</div>
		            </div>
		            <div class="clearfix"></div>
	     		</div>
	     		<div>
		     		<div class="sitemap-block">
		     			<ul>
		     		<?php 
		     		   $getbars = getcocktailsite();
		     		if($getbars){
		     	    foreach($getbars as $row){?>	
		     			
		     					<li><a href="<?php echo site_url('cocktail/detail/'.$row->cocktail_slug)?>">- <?php echo ucwords($row->cocktail_name);?></a></li>
		     					</li>
		     		
		     			<?php } }  ?><div class="clear"></div>
		     				</ul>
		     		</div>
	     		</div>
     		</div>
     		
     		
     		<div class="mar_top20"> 
	     		<div class="result_search">
	     			<div class="col-sm-8">
		     			<div class="result_search_text pull-left">Find Liquors</div>
		            </div>
		            <div class="clearfix"></div>
	     		</div>
	     		<div>
		     		<div class="sitemap-block">
		     			<ul>
		     		<?php 
		     		   $getbars = getliquorsite();
		     		if($getbars){
		     	    foreach($getbars as $row){?>	
		     			
		     					<li><a href="<?php echo site_url('liquor/detail/'.$row->liquor_slug)?>">- <?php echo ucwords($row->liquor_title);?></a></li>
		     					</li>
		     		
		     			<?php } }  ?><div class="clear"></div>
		     				</ul>
		     		</div>
	     		</div>
     		</div>
     		
     		<div class="mar_top20"> 
	     		<div class="result_search">
	     			<div class="col-sm-8">
		     			<div class="result_search_text pull-left">Find Events</div>
		            </div>
		            <div class="clearfix"></div>
	     		</div>
	     		<div>
		     		<div class="sitemap-block">
		     			<ul>
		     		<?php 
		     		   $getbars = geteventsite();
		     		if($getbars){
		     	    foreach($getbars as $row){?>	
		     			
		     					<li><a href="<?php echo site_url('event/detail/'.base64_encode($row->event_id))?>">- <?php echo ucwords($row->event_title);?></a></li>
		     					</li>
		     		
		     			<?php } }  ?><div class="clear"></div>
		     				</ul>
		     		</div>
	     		</div>
     		</div>
     		
     		<div class="mar_top20"> 
	     		<div class="result_search">
	     			<div class="col-sm-8">
		     			<div class="result_search_text pull-left">Find Forums</div>
		            </div>
		            <div class="clearfix"></div>
	     		</div>
	     		<div>
		     		<div class="sitemap-block">
		     			<ul>
		     		<?php 
		     		   $getbars = getforumsite();
		     		if($getbars){
		     	    foreach($getbars as $row){?>	
		     			
		     					<li><a href="<?php echo site_url('forum/detail/'.base64_encode($row->forum_id))?>">- <?php echo ucwords($row->topic_name);?></a></li>
		     					</li>
		     		
		     			<?php } }  ?><div class="clear"></div>
		     				</ul>
		     		</div>
	     		</div>
     		</div>
     		
     		<div class="mar_top20"> 
	     		<div class="result_search">
	     			<div class="col-sm-8">
		     			<div class="result_search_text pull-left">Find Articles</div>
		            </div>
		            <div class="clearfix"></div>
	     		</div>
	     		<div>
		     		<div class="sitemap-block">
		     			<ul>
		     		<?php 
		     		   $getbars = getarcticlesite();
		     		if($getbars){
		     	    foreach($getbars as $row){?>	
		     			
		     					<li><a href="<?php echo site_url('article/detail/'.base64_encode($row->blog_id))?>">- <?php echo ucwords($row->blog_title);?></a></li>
		     					</li>
		     		
		     			<?php } }  ?><div class="clear"></div>
		     				</ul>
		     		</div>
	     		</div>
     		</div>
     		
     		
     		
     		
     		
   		</div>
   	</div>