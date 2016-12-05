
<?php  $theme_url = base_url().getThemeName(); ?>
    <link href="<?php echo $theme_url;?>/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" /> 
        <script type="text/javascript" src="<?php echo $theme_url;?>/assets/plugins/fancybox/source/jquery.fancybox.js"></script>                     
    <div class="wrapper row4">
   		<div class="container clearfix">
   			<div id="slider-fixed-banner" class="carousel slide">
        	<div class="carousel-inner">
         <?php if($gallery){
         	 $i=1;  foreach($gallery as $gal){ ?>
          	<div class="item <?php if($i==1){ echo "active"; }?>">
          		<?php
          		if($gal->upload_type=="image"){
          		 if($gal->photo_image!='' && file_exists(base_path().'upload/gallery_drag/'.$gal->photo_image)){?>
            	<img src="<?php echo base_url(); ?>/upload/gallery_drag/<?php echo $gal->photo_image;?>" alt="<?php echo $gal->photo_title; ?>"/>
            	 <?php } else {  ?>
           	<img alt="<?php echo $gal->photo_title; ?>" src="<?php echo base_url().getThemeName(); ?>/images/banner2.png">
           <?php } ?>	 
            
            <?php  }  elseif($gal->upload_type=="video"  && $gal->custom_url==""){ ?>
            	<img alt="<?php echo $gal->photo_title; ?>" src="<?php echo base_url() ?>upload/banner-default.jpg">
            	<a href="<?php echo base_url(); ?>upload/video_orig/<?php echo $gal->upload_video;?>" class="fancybox-video"><i class="play-img"></i></a>
            	<?php }  else if($gal->custom_url!=''){
           			 $url	=	$gal->custom_url;
				if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',$url,$matches)) {
					//echo $url;
				      //preg_match('/[\\?\\&]v=([^\\?\\&]+)/',$url,$matches);
				      //preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',$url,$matches);
							if(isset($matches[1])){
							$id = $matches[1]; 
							echo '<iframe class="br_red img-responsive max-height embed_vid_height"  src="//www.youtube.com/embed/'.$id.'?rel=0" frameborder="0" allowfullscreen></iframe>';
							?>
								
								<a href="<?php echo '//www.youtube.com/embed/'.$id.'?rel=0'; ?>" class="fancybox-video"><i class="play-img"></i></a>
							<?php }else{ ?>
								<a href="<?php echo $url; ?>" class="fancybox-video"><i class="play-img"></i></a>
						<?php	}
				    } elseif (strpos($url, 'vimeo') > 0) {
				    	preg_match('~^http://(?:www\.)?vimeo\.com/(?:clip:)?(\d+)~',$url,$matches);
				//	$parsed = parse_url($url);
					//print_r($parsed);
				       if(isset($matches[1])){
							$id = $matches[1];
							 ?>	
							<a href="<?php echo '//player.vimeo.com/video/'.$id; ?>" class="fancybox-video"><i class="play-img"></i></a>	
						<?php	}else{
								$a=json_decode(file_get_contents('http://vimeo.com/api/oembed.json?url='.$url));
								
								if(isset($a->video_id) && $a->video_id!=''){
								$id=$a->video_id;
									 ?>
									
									<a href="<?php echo '//player.vimeo.com/video/'.$id; ?>" class="fancybox-video"><i class="play-img"></i></a>	
								<?php }
							}
				    }
				    } ?>
           </div>
           <?php $i++; } }?>
           
        </div>
      
        <a class="left carousel-control" href="#slider-fixed-banner" data-slide="prev">&lsaquo;</a>
        <a class="right carousel-control" href="#slider-fixed-banner" data-slide="next">&rsaquo;</a>
        
        <div class="barbox clearfix">
        	<h1 class="box_title">find a dive here</h1>
          
              	 <form class="form-horizontal mart10" id="bar_form" role="form" action="<?php echo site_url("bar/lists") ?>" method="post">
                   <div class="form-group">
                       <label for="inputEmail3" class="col-sm-3 control-label">Name :</label>
                       <div class="col-sm-8 input_box">
                           <input type="text" name="bar_title" id="bar_title" class="form-control form-pad"  placeholder="Name">
                       </div>
                   </div>
                   <div class="form-group">
                       <label for="inputEmail3" class="col-sm-3 control-label">State :</label>
                       <div class="col-sm-8 input_box">
                           <input type="text" name="state" id="state" class="form-control form-pad"  placeholder="State">
                       </div>
                   </div>
                   <div class="form-group">
                       <label for="inputEmail3" class="col-sm-3 control-label">City :</label>
                       <div class="col-sm-8 input_box clearfix">
                       	<div class="pull-left col-sm-6">
                           <input type="text" class="form-control form-pad" name="city" id="city" placeholder="City"></div>
                           <div class="pull-left cityboxpad col-sm-6">
                           	<label for="inputEmail3" class="col-sm-3 control-label ziplabel">Zip Code :</label>
                           	<input type="text" class="form-control form-pad" name="zipcode" id="zipcode" placeholder="Zip Code">
                           </div>
                       </div>
                   </div>
                  
                   <div class="form-group">
                   		<div class="buttongroup">
	                   		<!-- <div class="col-sm-7"> -->
	                   		<input type="hidden" name="limit" id="limit" value="10" />
	                       		<button class="btn btn-lg btn-primary text-center" type="submit">Search Your Bar</button>      
	                       <!-- </div> -->
                       </div> 
                       <!-- <div class="text-center padt5"><a href="#" class="white">Submit a bar to the Directory</a></div> -->
                  </div>
                   	<!-- <div class="pull-left marl30r10">
                       <button class="btn btn-lg btn-primary btn-block text-center" type="submit">Search Your Bar</button>        
                   </div>
                   <div class="pull-left padt5"><a href="#">Submit A Bar To Directory</a></div>
                  </div> -->
              </form>
   	</div>
   	</div>
      </div>
   		

    </div>
     <div class="wrapper row5">
     	<div class="container">
      <!-- Three columns of text below the carousel -->
      <div class="text-center clearfix">
      	<!-- <div class="col-md-3 padb20">
        	<div class="directory_box">
        		<div class="simple_box">
		          <img src="<?php echo $theme_url; ?>/images/icon_1.png"/>
		          
		        </div>
		        <h2 class="directory-item">Bar directory</h2>
          	</div>
        </div> --><!-- /.col-lg-3 -->
        <a href="<?php echo site_url('beer'); ?>">
        <div class="col-md-3 col-sm-4 padb20">
         <div class="directory_box active">
        		<div class="simple_box">
		          <img src="<?php echo $theme_url; ?>/images/icon_1.png"/>
		          <!-- <i class="strip bardir"></i> -->
		        </div>
		        <h2 class="directory-item">beer directory</h2>
          </div>
        </div><!-- /.col-lg-3 -->
        </a>
        <!-- <div class="col-md-3 col-sm-4 padb20">
        	
         <div class="directory_box">
        		<div class="simple_box">
		          <img src="<?php echo $theme_url; ?>/images/beer_icon.png"/>
		        </div>
		        <h2 class="directory-item">beer directory</h2>
          </div>
        </div> -->
         <a href="<?php echo site_url('cocktail'); ?>">
        <div class="col-md-3 col-sm-4 padb20">
        	<div class="directory_box">
        		<div class="simple_box">
		          <img src="<?php echo $theme_url; ?>/images/cock_icon.png"/>
		        </div>
		        <h2 class="directory-item">cocktail directory</h2>
          	</div>
        </div><!-- /.col-lg-3 -->
        </a>
        <div class="col-md-3 col-sm-4 padb20">
          <div class="directory_box">
        		<div class="simple_box">
		          <img src="<?php echo $theme_url; ?>/images/forum_icon.png"/>
		        </div>
		        <h2 class="directory-item">Forum</h2>
          	</div>
        </div><!-- /.col-lg-3 -->
      <!-- </div> --><!-- /.row -->
      
       <!-- <div class="text-center clearfix "> -->
       <a href="#"><div class="col-md-3 col-sm-4 padb20 clearfix">
        	<div class="directory_box">
        		<div class="simple_box">
		          <img src="<?php echo $theme_url; ?>/images/claim_icon.png"/>
		          <!-- <i class="strip bardir"></i> -->
		        </div>
		        <h2 class="directory-item">claim your bar</h2>
          	</div>
        </div></a><!-- /.col-lg-3 -->
        <div class="col-md-3 col-sm-4 padb20">
        	<!-- <div class="directory_box">
          <img src="<?php echo $theme_url; ?>/images/icon_box.png"/>
          <h2 class="directory-item">beer directory</h2>
         </div> -->
         <div class="directory_box">
        		<div class="simple_box">
		          <img src="<?php echo $theme_url; ?>/images/taxi_icon.png"/>
		          <!-- <i class="strip bardir"></i> -->
		        </div>
		        <h2 class="directory-item">taxi directory</h2>
          </div>
        </div><!-- /.col-lg-3 -->
        <div class="col-md-3 col-sm-4 padb20">
        	<div class="directory_box">
        		<div class="simple_box">
		          <img src="<?php echo $theme_url; ?>/images/products_icon.png"/>
		          <!-- <i class="strip bardir"></i> -->
		        </div>
		        <h2 class="directory-item">Products</h2>
          	</div>
        </div><!-- /.col-lg-3 -->
          <a href="<?php echo site_url('bar/gallery'); ?>">
        <div class="col-md-3 col-sm-4 padb20">
          <div class="directory_box">
        		<div class="simple_box">
		          <img src="<?php echo $theme_url; ?>/images/gallery_icon.png"/>
		          <!-- <i class="strip bardir"></i> -->
		        </div>
		        <h2 class="directory-item">photo gallery</h2>
          	</div>
        </div><!-- /.col-lg-3 -->
        </a>
      <!-- </div> --><!-- /.row -->
      
      
     	
     </div>
   </div>
   
    <div class="wrapper row6">
    	<div class="container">
	        <!-- <div class="col-md-4 padb20">
	        	<div class="bott_box_bg">
	        	<h1 class="box_title">Latest News And Events</h1>
	         		<ul class="bottom_box">
	         			<li>Lorem ipsum dolor sit amet</li>
	         			<li>Lorem ipsum dolor sit amet, con sectetur elit. </li>
	         			<li class="datelabel">13/08/2013</li>
	         		</ul>
	         		<hr>
	         		<ul class="bottom_box">
	         			<li>Lorem ipsum dolor sit amet</li>
	         			<li>Lorem ipsum dolor sit amet, con sectetur elit. </li>
	         			<li class="datelabel">13/08/2013</li>
	         		</ul>
	         		<hr>
	         		<ul class="bottom_box">
	         			<li>Lorem ipsum dolor sit amet</li>
	         			<li>Lorem ipsum dolor sit amet, con sectetur elit. </li>
	         			<li class="datelabel">13/08/2013</li>
	         		</ul>
	         		<hr>
	         		<ul class="bottom_box">
	         			<li>Lorem ipsum dolor sit amet</li>
	         			<li>Lorem ipsum dolor sit amet, con sectetur elit. </li>
	         			<li class="datelabel">13/08/2013</li>
	         		</ul>
	         </div>
	        </div> --><!-- /.col-lg-4 -->
	        
        <div class="row">
        <div class="col-lg-4">
         	<div class="bott_box_bg">
	        	<h1 class="box_title">Latest News And Events</h1>
	         		<ul class="bottom_box">
	         			<li>
	         				<div class="fourm_label"><a href="#" class="newsyellow">Lorem ipsum dolor sit amet</a></div>
	         				<p class="fourm_label">ipsum dolor sit amet, con sectetur elit.</p>
	         				<p class="datelabel">13/08/2013</p>
	         			</li>
	         			<hr>
	         			<li>
	         				<div class="fourm_label"><a href="#" class="newsyellow">Lorem ipsum dolor sit amet</a></div>
	         				<p class="fourm_label">ipsum dolor sit amet, con sectetur elit.</p>
	         				<p class="datelabel">13/08/2013</p>
	         			</li>
	         			<hr>
	         			<li>
	         				<div class="fourm_label"><a href="#" class="newsyellow">Lorem ipsum dolor sit amet</a></div>
	         				<p class="fourm_label">ipsum dolor sit amet, con sectetur elit.</p>
	         				<p class="datelabel">13/08/2013</p>
	         			</li>
	         			<hr>
	         			<li>
	         				<div class="fourm_label"><a href="#" class="newsyellow">Lorem ipsum dolor sit amet</a></div>
	         				<p class="fourm_label">ipsum dolor sit amet, con sectetur elit.</p>
	         				<p class="datelabel">13/08/2013</p>
	         			</li>
	         		</ul>
	         		
	         		
	         </div>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
         	<div class="bott_box_bg">
	        	<h1 class="box_title">latest forum</h1>
	         		
	         		<!-- <ul class="bottom_box">
	         			<li class="col-sm-12">
	         				
	         					<img src="<?php echo $theme_url; ?>/images/70x70_img1.png" class="col-sm-3"/>
	         				
	         				<label class="col-sm-9">Lorem ipsum dolor sit amet, con sectetur elit.</label>
	         				<label class="col-sm-5 datelabel">13/08/2013</label>
	         				<label class="col-sm-3 datelabel">13/08/2013</label>
	         				<div class="clearfix"></div>
	         				
	         			</li>
	         			<div class="clearfix"></div>
	         			
	         		</ul> -->
	         		 <ul class="bottom_box">
	         			<li class="mart10">
	         				<div class="media">
						      <a class="pull-left widheig70" href="#">
						        <!-- <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCI+PHJlY3Qgd2lkdGg9IjY0IiBoZWlnaHQ9IjY0IiBmaWxsPSIjZWVlIj48L3JlY3Q+PHRleHQgdGV4dC1hbmNob3I9Im1pZGRsZSIgeD0iMzIiIHk9IjMyIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjEycHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+NjR4NjQ8L3RleHQ+PC9zdmc+" style="width: 64px; height: 64px;"> -->
						      	<img src="<?php echo $theme_url; ?>/images/70x70_img1.png" />
						      </a>
						      <div class="media-body">
						        <h4 class="media-heading"><a href="#" class="newsyellow">User</a></h4>
						        <div class="fourm_label">ipsum dolor sit amet, con sectetur elit.</div> 
						        <div class="padt8">
						        	<p class="datelabel pull-left">By User 1 day Ago</p>
						        	<img src="<?php echo $theme_url; ?>/images/comment_icon.png" class="pull-right">
						        	<div class="clearfix"></div>
						        </div>
						      </div>
				    		</div>
	         			</li>
	         			<hr>
	         			<li>
	         				<div class="media">
						      <a class="pull-left" href="#">
						        <!-- <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCI+PHJlY3Qgd2lkdGg9IjY0IiBoZWlnaHQ9IjY0IiBmaWxsPSIjZWVlIj48L3JlY3Q+PHRleHQgdGV4dC1hbmNob3I9Im1pZGRsZSIgeD0iMzIiIHk9IjMyIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjEycHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+NjR4NjQ8L3RleHQ+PC9zdmc+" style="width: 64px; height: 64px;"> -->
						      	<img src="<?php echo $theme_url; ?>/images/70x70_img1.png" />
						      </a>
						      <div class="media-body">
						        <h4 class="media-heading"><a href="#" class="newsyellow">User</a></h4>
						        <div class="fourm_label">ipsum dolor sit amet, con sectetur elit.</div> 
						        <div class="padt8">
						        	<p class="datelabel pull-left">By User 1 day Ago</p>
						        	<img src="<?php echo $theme_url; ?>/images/comment_icon.png" class="pull-right">
						        	<div class="clearfix"></div>
						        </div>
						      </div>
				    		</div>
	         			</li>
	         			<hr>
	         			<li>
	         				<div class="media">
						      <a class="pull-left" href="#">
						        <!-- <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCI+PHJlY3Qgd2lkdGg9IjY0IiBoZWlnaHQ9IjY0IiBmaWxsPSIjZWVlIj48L3JlY3Q+PHRleHQgdGV4dC1hbmNob3I9Im1pZGRsZSIgeD0iMzIiIHk9IjMyIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjEycHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+NjR4NjQ8L3RleHQ+PC9zdmc+" style="width: 64px; height: 64px;"> -->
						      	<img src="<?php echo $theme_url; ?>/images/70x70_img1.png" />
						      </a>
						      <div class="media-body">
						        <h4 class="media-heading"><a href="#" class="newsyellow">User</a></h4>
						        <div class="fourm_label">ipsum dolor sit amet, con sectetur elit.</div> 
						        <div class="padt8">
						        	<p class="datelabel pull-left">By User 1 day Ago</p>
						        	<img src="<?php echo $theme_url; ?>/images/comment_icon.png" class="pull-right">
						        	<div class="clearfix"></div>
						        </div>
						      </div>
				    		</div>
	         			</li>
	         			<hr>
	         			<li>
	         				<div class="media">
						      <a class="pull-left" href="#">
						        <!-- <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCI+PHJlY3Qgd2lkdGg9IjY0IiBoZWlnaHQ9IjY0IiBmaWxsPSIjZWVlIj48L3JlY3Q+PHRleHQgdGV4dC1hbmNob3I9Im1pZGRsZSIgeD0iMzIiIHk9IjMyIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjEycHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+NjR4NjQ8L3RleHQ+PC9zdmc+" style="width: 64px; height: 64px;"> -->
						      	<img src="<?php echo $theme_url; ?>/images/70x70_img1.png" />
						      </a>
						      <div class="media-body">
						        <h4 class="media-heading"><a href="#" class="newsyellow">User</a></h4>
						        <div class="fourm_label">ipsum dolor sit amet, con sectetur elit.</div> 
						      	<div class="padt8">
						        	<p class="datelabel pull-left">By User 1 day Ago</p>
						        	<img src="<?php echo $theme_url; ?>/images/comment_icon.png" class="pull-right">
						        	<div class="clearfix"></div>
						        </div>
						      </div>
				    		</div>
	         			</li>
	         			</ul>
	         		
	         		
	         </div>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
         	<div class="bott_box_bg">
	        	<!-- <h1 class="box_title">Latest News And Events</h1> -->
	         		<ul class="bottom_box3">
	         			<a class="box_yellow"><li  class="active">What is a dive bar</li></a>
	         			<a href="<?php echo site_url('bar')?>" class="box_yellow"><li>Find is a dive bar</li></a>
	         			<a href="<?php echo site_url('bar/suggest_bar')?>" class="box_yellow"><li>suggest a dive bar</li></a>
	         			<a href="<?php echo site_url('bar/lists')?>" class="box_yellow"><li>list a dive bar</li></a>
	         			<a href="#" class="box_yellow"><li>dive bar forum</li></a>
	         			<a href="#" class="box_yellow"><li>in a dive bar find out</li></a>
	         			<a href="<?php echo site_url('home/newsletterevent')?>" class="box_yellow"><li>dive bar news</li></a>
	         			<a href="<?php echo site_url('home/statistics')?>" class="box_yellow"><li>dive bar terms and  Statistics</li></a>
	         			<a href="<?php echo site_url('bar/gallery')?>" class="box_yellow"><li>dive bar gallery</li></a>
	         			
	         		</ul>
	         		
	         		
	         </div>
        </div><!-- /.col-lg-4 -->
        
      </div><!-- /.row -->
      </div><!-- /.row -->
    		
    	</div>
    	<script>
    	 $(document).ready(function(){
    	 	 $('.fancybox-video').fancybox({type: 'iframe'});
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