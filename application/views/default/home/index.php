<style>
	.bx-wrapper .bx-controls-direction a {
    width: 16px !important;
}
</style>
<script src="<?php echo base_url().getThemeName();?>/js/jquery.tagsinput.js" type="text/javascript"></script>
    <script>
    	 $(document).ready(function(){
    	 	$("#city11").val('');
    	 	$("#state11").val('');
    	 	$("#zipcode11").val('');
    	 	    	 });
    </script>
    <?php
?>
<?php 
 $theme_url = base_url().getThemeName(); ?>
    <div class="wrapper row4 banner-block">
   		<div class="clearfix">
   			<div id="" class="carousel slide">
   				
   				<div id="container">
        <section>
            <video style="width: 100%; height: 100%;" autoplay="true" class="video">
                <source src="<?php echo base_url()?>upload/1.mp4" type="video/mp4">
            </video>
            <div class="preloader">
                <p id="intro-scroll-button">
                    <a class="scroll-down" href="#below-video">
           	        <h1 class="sony"></h1>
                    <span class="scroll-message">SCROLL DOWN TO EXPLORE</span>
                    <i class="glyphicon glyphicon-menu-down"></i></a>
                </p>
            </div>
        </section>
    </div>
        	
        <div class="barbox clearfix">
        	<h1 class="box_title">Find a Bar! &nbsp;&nbsp; Search by any field below ! </h1>
          
     				<span id="clickall123" for="zipcode" class="help-inline" style="display: none; text-align: center;">Please fill atleast one field .</span>
     				
     				<form method="post" action="<?php echo site_url('bar/lists/');?>" role="form" id="bar_form" class="form-horizontal mart10">
                   <div class="form-group">
                       <label class="col-sm-3 control-label" for="inputEmail3">Search By Name :</label>
                       <div class="col-sm-8 input_box">
                           <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input onkeydown="if (event.keyCode == 13) { click11('one'); return false; }" type="text" placeholder="Start typing name..." class="form-control form-pad tags2222 search-control ui-autocomplete-input" id="bar_title11" name="bar_title" autocomplete="off">
                           <!-- <a onclick="click11('one')" class="btn btn-lg btn-primary search-icon" name="" ><i class="glyphicon glyphicon-search"></i></a> -->
                           <div class="clearfix"></div>
                       <span id="click11" for="bar_title11" class="help-inline" style="display: none;">This field is required.</span>
                       </div>
                   </div>
                   <div class="form-group">
                       <label class="col-sm-3 control-label" for="inputEmail3">Search By State :</label>
                       <div class="col-sm-8 input_box">
                           <input type="text" onkeydown="if (event.keyCode == 13) { click11('two'); return false; }" placeholder="State" class="form-control form-pad search-control" id="state11" name="state">
                           <!-- <a  onclick="click11('two')" class="btn btn-lg btn-primary search-icon" name="" ><i class="glyphicon glyphicon-search"></i></a> -->
                           <div class="clearfix"></div>
                       <span id="click22" for="state" class="help-inline" style="display: none;">This field is required.</span>
                       </div>
                   </div>
                    <div class="form-group">
                       <label class="col-sm-3 control-label" for="inputEmail3">Search By City :</label>
                       <div class="col-sm-8 input_box">
                           <input type="text" onkeydown="if (event.keyCode == 13) { click11('three'); return false; }" placeholder="City" id="city11" name="city" class="form-control form-pad search-control">
                           <!-- <a onclick="click11('three')" class="btn btn-lg btn-primary search-icon" name="" ><i class="glyphicon glyphicon-search"></i></a> -->
                           <div class="clearfix"></div>
                       <span id="click33" for="city11" class="help-inline" style="display: none;">This field is required.</span>
                       </div>
                  	</div>
                   <div class="form-group">
                       <label class="col-sm-3 control-label" for="inputEmail3">Search By Zip Code :</label>
                       <div class="col-sm-8 input_box">
                           <input type="text" placeholder="Zip Code" onkeydown="if (event.keyCode == 13) { click11('four'); return false; }" id="zipcode11" name="zipcode" class="form-control form-pad search-control">
                           <!-- <a onclick="click11('four')" class="btn btn-lg btn-primary search-icon" name="" ><i class="glyphicon glyphicon-search"></i></a> -->
                           <div class="clearfix"></div>
                       <span id="click44" for="zipcode11" class="help-inline" style="display: none;">This field is required.</span>
                       </div>
                   </div>
                 
                  
                   <div class="form-group">
                    <label class="col-sm-3 control-label" for="inputEmail3"></label>
                   		<div class="text-left col-sm-9 button-text ">
	                   		<input type="hidden" value="10" id="limit" name="limit">
	                       		<a onclick="click11('five')"  class="btn btn-lg btn-primary text-center  marr_10">Start Your Search</a>
	                       		<a class="btn btn-lg btn-primary text-center" onclick="openSug()" href="javascript://">Help Us Find Every Bar!</a>   
	                       		<div class="clearfix"></div>
                       </div> 
                       
                       
                  </div>
                   
              </form>
	        			
   	</div>
    <div class="barbox1">
    <h1 class="box_title">Search for Local Happy Hours</h1>
    	<form method="post" action="<?php echo site_url('bar/lists/');?>" role="form" id="bar_form" class="form-horizontal mart10">
                   <div class="form-group">
                       <div class="wid-30 input_box">
                           <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input type="text" placeholder="Name of Bar" class="form-control form-pad tags2222 search-control ui-autocomplete-input" id="bar_title12" name="bar_title_j" autocomplete="off">
                           <!-- <a onclick="click11('one')" class="btn btn-lg btn-primary search-icon" name="" ><i class="glyphicon glyphicon-search"></i></a> -->
                           <div class="clearfix"></div>
                       </div>
                        <div class="wid-30 input_box">
                           <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input  type="text" placeholder="Address, City, State, Zip" class="form-control form-pad tags2222 search-control ui-autocomplete-input" id="address_j" name="address_j" autocomplete="off">
                           <!-- <a onclick="click11('one')" class="btn btn-lg btn-primary search-icon" name="" ><i class="glyphicon glyphicon-search"></i></a> -->
                           <div class="clearfix"></div>
                       </div>
                        <div class="wid-30 input_box">
                           <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                           <select name="days" id="name="days" class="form-control form-pad tags2222 search-control">
                            <option <?php echo date('l')=="Monday" ? "selected":''?> value="Monday">Monday</option>
                            <option <?php echo date('l')=="Tuesday" ? "selected":''?> value="Tuesday">Tuesday</option>
                            <option <?php echo date('l')=="Wednesday" ? "selected":''?> value="Wednesday">Wednesday</option>
                            <option <?php echo date('l')=="Thursday" ? "selected":''?> value="Thursday">Thursday</option>
                            <option <?php echo date('l')=="Friday" ? "selected":''?> value="Friday">Friday</option>
                            <option <?php echo date('l')=="Saturday" ? "selected":''?> value="Saturday">Saturday</option>
                            <option <?php echo date('l')=="Sunday" ? "selected":''?> value="Sunday">Sunday</option>
                           </select>
                           <!-- <a onclick="click11('one')" class="btn btn-lg btn-primary search-icon" name="" ><i class="glyphicon glyphicon-search"></i></a> -->
                           <div class="clearfix"></div>
                       </div>
                   </div>
                    <div class="form-group">
                   		<div class="text-right search-right">
	                       		<input type="submit" name="Submit" value="Search" class="btn btn-lg btn-primary text-center" />
	                       		<div class="clearfix"></div>
                       </div> 
                       
                       
                  </div>
                  </form>
    </div>
    
    
   	</div>
      </div>
   		

    </div>
    <a class="anchor" id="below-video"></a>
     <div class="wrapper row5">
     	<div class="container">
      <div class="text-center clearfix">
      
       <a class="" href="javascript://" onclick="searchmodal()"><div class="col-md-3 col-sm-4 padb20 ">
        	<div class="directory_box">
        		<div class="simple_box">
		          <img src="<?php echo $theme_url; ?>/images/bar-icon.png"/>
		        </div>
		        <h2 class="directory-item">Bar Search</h2>
          	</div>
        </div></a><!-- /.col-lg-3 -->
        
        <a href="<?php echo site_url('beer'); ?>">
        <div class="col-md-3 col-sm-4 padb20">
         <div class="directory_box">
        		<div class="simple_box">
		          <img src="<?php echo $theme_url; ?>/images/beer_icon.png"/>
		          <!-- <i class="strip bardir"></i> -->
		        </div>
		        <h2 class="directory-item">beer directory</h2>
          </div>
        </div><!-- /.col-lg-3 -->
        </a>
        
         <a href="<?php echo site_url('cocktail'); ?>">
        <div class="col-md-3 col-sm-4 padb20">
        	<div class="directory_box">
        		<div class="simple_box">
		          <img src="<?php echo $theme_url; ?>/images/cocktail-icon.png"/>
		        </div>
		        <h2 class="directory-item">Cocktail Recipes</h2>
          	</div>
        </div><!-- /.col-lg-3 -->
        </a>
        
         <a href="<?php echo site_url('liquor'); ?>">
        <div class="col-md-3 col-sm-4 padb20 ">
          <div class="directory_box">
        		<div class="simple_box">
		          <img src="<?php echo $theme_url; ?>/images/liquor.png"/>
		          <!-- <i class="strip bardir"></i> -->
		        </div>
		        <h2 class="directory-item">Liquor Directory</h2>
          	</div>
        </div><!-- /.col-lg-3 -->
        </a>
        
      
        <div class="col-md-3 col-sm-4 padb20">
          <a href="<?php echo site_url('taxiowner/lists'); ?>">
         <div class="directory_box">
        		<div class="simple_box">
		          <img src="<?php echo $theme_url; ?>/images/taxi_icon.png"/>
		        </div>
		        <h2 class="directory-item">Taxi Directory</h2>
          </div>
        </div><!-- /.col-lg-3 -->
        </a>
        
         <a href="<?php echo site_url('bar/gallery'); ?>">
        <div class="col-md-3 col-sm-4 padb20">
          <div class="directory_box">
        		<div class="simple_box">
		          <img src="<?php echo $theme_url; ?>/images/gallery_icon.png"/>
		        </div>
		        <h2 class="directory-item">Photo Gallery</h2>
          	</div>
        </div><!-- /.col-lg-3 -->
        </a>
        
         <a href="<?php echo site_url('forum'); ?>">
        <div class="col-md-3 col-sm-4 padb20 ">
          <div class="directory_box">
        		<div class="simple_box">
		          <img src="<?php echo $theme_url; ?>/images/forum_icon.png"/>
		        </div>
		        <h2 class="directory-item">Groups</h2>
          	</div>
        </div>
        </a>
        
         <a href="<?php echo site_url('home/news'); ?>">
        <div class="col-md-3 col-sm-4 padb20">
          <div class="directory_box">
        		<div class="simple_box">
		          <img src="<?php echo $theme_url; ?>/images/news-development.png"/>
		        </div>
		        <h2 class="directory-item">AB News</h2>
          	</div>
        </div>
        </a>
        
        <a href="<?php echo site_url('shopping/products'); ?>">
        <div class="col-md-3 col-sm-4 padb20">
        	<div class="directory_box">
        		<div class="simple_box">
		          <img src="<?php echo $theme_url; ?>/images/products_icon.png"/>
		          <!-- <i class="strip bardir"></i> -->
		        </div>
		        <h2 class="directory-item">Products</h2>
          	</div>
        </div><!-- /.col-lg-3 -->
         </a>
         
         <a href="<?php echo site_url('event'); ?>">
        <div class="col-md-3 col-sm-4 padb20">
          <div class="directory_box">
        		<div class="simple_box">
		          <img src="<?php echo $theme_url; ?>/images/events-development.png"/>
		          <!-- <i class="strip bardir"></i> -->
		        </div>
		        <h2 class="directory-item">Events & Festivals</h2>
          	</div>
        </div><!-- /.col-lg-3 -->
        </a>
        
        <a href="<?php echo site_url('home/barcriteria'); ?>">
        <div class="col-md-3 col-sm-4 padb20">
          <div class="directory_box">
        		<div class="simple_box">
		          <img src="<?php echo $theme_url; ?>/images/dive-bar.png"/>
		          <!-- <i class="strip bardir"></i> -->
		        </div>
		        <h2 class="directory-item">In a Dive Bar</h2>
          	</div>
        </div><!-- /.col-lg-3 -->
        </a>
        
         <a href="<?php echo site_url('trivia'); ?>">
        <div class="col-md-3 col-sm-4 padb20">
          <div class="directory_box">
        		<div class="simple_box">
		          <img src="<?php echo $theme_url; ?>/images/bar-statistcs.png"/>
		          <!-- <i class="strip bardir"></i> -->
		        </div>
		        <h2 class="directory-item">Bar Trivia</h2>
          	</div>
        </div><!-- /.col-lg-3 -->
        </a>
       
     	
     </div>
   </div>
     </div>
	 
    <div class="wrapper row6">
    	<div class="container">
	      
	        
        <div class="row">
        <div class="col-lg-4 col-sm-4">
         	<div class="bott_box_bg new_review">
	        	<h1 class="productbar_title">
	        		<div class="pull-left mar_top5">Latest News</div>
     					<a href="<?php echo site_url('home/news'); ?>" class="white pull-right review" onclick="loadMap()">View All</a>
     					<div class="clearfix"></div>
	        	</h1>
	         		<ul class="bottom_box" id="infinite-list">
	         			<?php if($latest_news){
	         				  foreach($latest_news as $news){?>
	         			<li>
	         				<div class="fourm_label"><a href="<?php echo site_url('home/news_details/'.$news->slug); ?>" class="newsyellow"><?php if(strlen(strip_tags($news->news_title))>30){ echo substr(strip_tags($news->news_title),0,30).'...' ; } else { echo strip_tags($news->news_title); } ?></a></div>
	         				<p class="fourm_label">	<?php if(strlen(strip_tags($news->news_desc))>55){ echo substr(strip_tags($news->news_desc),0,55).'...' ; } else { echo strip_tags($news->news_desc); } ?></p>
	         				<p class="datelabel"><?php echo date($site_setting->date_format,strtotime($news->date_added)); ?></p>
	         			</li>
	         			<hr>
	         			<?php } } else { ?>
	         				
	         			<li>
	         				No Records Founds.
	         			</li>	
	         			<?php } ?>
	         		
	         			
	         		</ul>
	         </div>
	         
	         
        </div> <!-- /.col-lg-4 -->
        <div class="col-lg-4 col-sm-4">
         	<div class="bott_box_bg new_review">
	         		<h1 class="productbar_title">
	        		<div class="pull-left mar_top5">Events & Festivals</div>
     					<a href="<?php echo site_url('event'); ?>" class="white pull-right review">View All</a>
     					<div class="clearfix"></div>
	        	</h1>
	         		
	         		 <ul class="bottom_box" id="infinite-list-cocktail">
	         		 		<?php if($latest_event){
	         				 foreach($latest_event as $news){?>
	         			<li>
	         				<div class="fourm_label"><a href="<?php echo site_url('event/detail/'.base64_encode($news->event_id));?>" class="newsyellow"><?php if(strlen(strip_tags($news->event_title))>30){ echo substr(strip_tags($news->event_title),0,30).'...' ; } else { echo strip_tags($news->event_title); } ?></a></div>
	         				<p class="fourm_label">	<?php echo $news->city.", ".$news->state;?></p>
	         				   <p class="fourm_label"><?php $t = getEventDate($news->event_id);?> <?php echo date('l, F j, Y',strtotime($t->eventdate)) ; ?></p>
	         				<!-- <p class="datelabel"><?php echo date($site_setting->date_format,strtotime($news->start_date))." To ".date($site_setting->date_format,strtotime($news->end_date)); ?></p> -->
	         			</li>
	         			<?php ?>
	         			<hr>
	         			<?php } ?>
	         			<?php } else { ?>
	         				<li>
	         				No Records Founds.
	         				</li>
	         				<?php } ?>
	         			
	         			</ul>
	         		
	         		
	         </div>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4 col-sm-4">
         	<div class="bott_box_bg">
	        	<!-- <h1 class="box_title">Latest News And Events</h1> -->
	         		<ul class="bottom_box3">
	         			<a class="box_yellow"><li  class="active">Shortcuts</li></a>
	         			 <a  class="box_yellow" href="javascript://" onclick="searchmodal()"><li>Find a Bar!  &nbsp;Search Here!</li></a>
	         			<a href="<?php echo site_url('bar/suggest_bar')?>" class="box_yellow"><li>Suggest a Bar</li></a>
	         			<a href="<?php echo site_url('forum')?>" class="box_yellow"><li>Group Discussions</li></a>
	         			<a href="<?php echo site_url('home/barcriteria')?>" class="box_yellow"><li>In a Dive Bar? Fun Quiz</li></a>
	         			<a href="<?php echo site_url('home/news')?>" class="box_yellow"><li>Bar News</li></a>
	         			<a href="<?php echo site_url('trivia')?>" class="box_yellow"><li>Bar Trivia Game</li></a>
	         			<a href="<?php echo site_url('bar/gallery')?>" class="box_yellow"><li>American Bars Gallery</li></a>
	         			<a href="<?php echo site_url('event'); ?>" class="box_yellow"><li>American Bars Events</li></a>
	         			<a href="<?php echo site_url('shopping/products'); ?>" class="box_yellow"><li>American Bars Products</li></a>
	         			
         
	         		</ul>         		
	         		
	         </div>
        </div><!-- /.col-lg-4 -->
        
      </div><!-- /.row -->
      </div><!-- /.row -->    		
    	</div>
		<!--add html-->
		
		<div class="wrapper row6 padding-top-20">
			
    	<div class="container">
    		<h1 class="productbar_title">
	        		<div class="pull-left mar_top5">Latest Articles</div>
     					<a  class="white pull-right review" href="<?php echo site_url('article')?>">View All</a>
     					<div class="clearfix"></div>
	        	</h1>
    		<div class="row">
    			<ul class="bxslider"> 
		<?php if($recent_blog){
			foreach($recent_blog as $rs){
		?>
		<li>
		<div class="bott_box_bg padding-10 min-height200">
		<ul class="desc-list">
		<li><div class="image-left">
			<a href="<?php echo site_url('article/detail/'.base64_encode($rs->blog_id))?>">
			<?php 
										if($rs->blog_image!="" && is_file(base_path().'upload/blog_thumb_130by130/'.$rs->blog_image)){ ?>
											<img   src="<?php echo base_url().'upload/blog_thumb_130by130/'.$rs->blog_image; ?>" class="img-responsive" />
										<?php
										}
										else{?>
										<img style="width: 130px; height: 130px;" class="img-responsive" src="<?php echo base_url()?>/upload/no-image.png" alt="American Dive Bars"/>
								<?php } ?></a>
								
								
			</div></li>
		<li class="fix-width">
			<div>	<a  class="pull-left listing-title" style="font-size: 20px;" href="<?php echo site_url('article/detail/'.base64_encode($rs->blog_id))?>"><?php if(strip_tags(strlen($rs->blog_title)>20)){ echo substr(strip_tags($rs->blog_title),0,20).'...' ; } else { echo strip_tags($rs->blog_title); } ?></a><div class="clearfix"></div></div>
			<p class="result_desc"><?php if(strip_tags(strlen($rs->blog_description)>350)){ echo substr(strip_tags($rs->blog_description),0,350).'...' ; } else { echo strip_tags($rs->blog_description); } ?></p></li>
		</ul>
		</div>
		
		</li>
		      	
		
		<?php } }?>	
		</ul>
		</div>	
		</div>
		</div>
		<!---->
		
    	<script>
    	 $(document).ready(function(){
    	 	
    	 	
    	 	 <?php  if($ms=='ordersuccess'){?>
    	 	   $.growlUI('Your order payment successfully .');
    	 <?php } ?>		
		$('.tags2222').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('bar/auto_suggest_bar/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									label: item.label,
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		      
    	 	 var video = document.getElementById("video");
    	 	//video.removeAttribute("controls");
    	
    	 <?php if($ms=='reset')   { ?>
                 $.growlUI('Your password reset successfully .');
         <?php   } ?>
         
          <?php if($ms=='activate')   { ?>
                 $.growlUI('Your account active successfully .');
         <?php   } ?>
         
         <?php if($ms=='expired')   { ?>
                 $.growlUI('Your link expired .');
         <?php   } ?>
    	 });
    </script>	
    





	

<script type="text/javascript">
  
  function click11(ty)
  {
  	
  	 if(ty=='one')
  	 {
  	 	if($("#bar_title11").val()=='')
  	 	{
  	 		
  	 		$("#click11").show();
  	 		return false;
  	 	}
  	 	else
  	 	{
  	 		$("#state11").val('');
  	 		$("#city11").val('');
  	 		$("#zipcode11").val('');
  	 		
  	 			$('#bar_form').submit();
  	 		return true;
  	 	}
  	 }
  	 if(ty=='two')
  	 {
  	 	
  	 	
  	 	if($("#state11").val()=='')
  	 	{
  	 		$("#click22").show();
  	 		return false;
  	 	}
  	 	else
  	 	{
  	 		
  	 		$('#bar_form').submit();
  	 		return true;
  	 	}
  	 }
  	  if(ty=='three')
  	 {
  	 	if($("#city11").val()=='')
  	 	{
  	 		$("#click33").show();
  	 		return false;
  	 	}
  	 	else
  	 	{
  	 			$("#bar_title11").val('');
  	 		$("#state11").val('');
  	 		$("#zipcode11").val('');
  	 			$('#bar_form').submit();
  	 		return true;
  	 	}
  	 }
  	 if(ty=='four')
  	 {
  	 	if($("#zipcode11").val()=='')
  	 	{
  	 		$("#click44").show();
  	 		return false;
  	 	}
  	 	else
  	 	{
  	 			$("#bar_title11").val('');
  	 		$("#city11").val('');
  	 		$("#state11").val('');
  	 			$('#bar_form').submit();
  	 		return true;
  	 	}
  	 } 
  	  if(ty=='five')
  	 {
  	 	
  	 	if($("#bar_title11").val()=='' && $("#state11").val()=='' && $("#city11").val()=='' && $("#zipcode11").val()=='')
  	 	{
  	 		
  	 		$("#clickall123").show();
  	 		return false;
  	 	}
  	 	
  	 	else
  	 	{
  	 			$('#bar_form').submit();
  	 		    return true;
  	 	}
  	 }
  	 return false;
  	 
  }
	$(document).ready(function(){
//===== Usual validation engine=====//
	$("#bar_form123").validate({
		rules: {			
			bar_title: {
				required: true,
			},			
			state: {
				required: true,
				
			},		
			city11: {
				required: true,
				
			},		
			zipcode11: {
				required: true,
				
			},				
		  	errorClass:'error fl_right'			
		}
	});	
});
</script>

<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.bxslider.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/css/jquery.bxslider.css" />
 <link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/css/prettify.css">
	<script src="<?php echo base_url().getThemeName(); ?>/js/jquery.slimscroll.js"></script>
	<script src="<?php echo base_url().getThemeName(); ?>/js/prettify.js"></script>
	<script type="text/javascript">
		$(function(){
			$('.bxslider').bxSlider({
  minSlides: 2,
  maxSlides: 2,
  slideWidth: 540,
  slideMargin: 20
});
		      $('#infinite-list').slimscroll({
		        alwaysVisible: true,
		        height: 370,
		        wheelSpeed:1,
		        color: '#f19d12',
		        opacity: .8
		      });
		      
		        $('#infinite-list-cocktail').slimscroll({
		        alwaysVisible: true,
		        wheelSpeed:1,
		        height: 370,
		        color: '#f19d12',
		        opacity: .8
		      });
		      
		      $('#infinite-list-liquor').slimscroll({
		        alwaysVisible: true,
		        height: 370,
		        wheelSpeed:1,
		        color: '#f19d12',
		        opacity: .8
		      });
		
		  });
	</script>
	<!--------------End Scroll ------------------->
<style>
	#gmap_marker {
    height: 370px;
    width: 100%;
}
 .gm-style-iw
 {
 	color:#000000;
 }
 #infinite-list {
    height: 370px;
    margin-left: auto;
    margin-right: auto;
    overflow-x: hidden;
    overflow-y: scroll;
}
#infinite-list-cocktail {
    height: 370px;
    margin-left: auto;
    margin-right: auto;
    overflow-x: hidden;
    overflow-y: scroll;
}
</style>	