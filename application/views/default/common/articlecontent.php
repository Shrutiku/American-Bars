<?php
$theme_url = $urls= base_url().getThemeName();

?>
<style>
.result_desc p img {
    height: 100% !important;
    width: 100% !important;
}
	body{
		background-color: #2E2C26;
	}
</style>

<!-- ########################################################################################### -->
<!-- content -->
	     		<div class="">
	     			<!-- <h1 class="yellow_title padb25">Forum Category : Test Category</h1> -->
	     			<div class="blog-mainblock" >
	     				<ul>
	     					<li>
				     			<div class="blog-block" style="border: none;">
		     						<div>
		     							 <?php 
										if($blog_detail->blog_image!="" && is_file(base_path().'upload/blog_thumb/'.$blog_detail->blog_image)){ ?>
											<img src="<?php echo base_url().'upload/blog_thumb/'.$blog_detail->blog_image; ?>" class="img-responsive" />
										<?php
										}
										else{?>
										<img class="img-responsive"  src="<?php echo $theme_url.'/images/smallbanner1.png'; ?>" />
								<?php } ?>
		     						</div>
		     						<div class="result_desc mart10" style="color: #ffffff">
		     							
						       			<?php echo $blog_detail->blog_description; ?>
						       		</div>
		     					</div>
		     					<div class="clearfix"></div>
	     					</li>
	     				</ul>
	     				<div>
	     				
						
						
						
						<div class="clearfix"></div>
						<!-- <div class="review pull-left marr_10"><a href="#">Upload</a></div>
						<div class="review pull-left"><a href="#">Add Post</a></div>
						<div class="clearfix"></div> -->
					</div>
					
					
     				
	     			
	     			</div>
	     			
		     		<div class="clearfix"></div>
	     		</div>
	     		
