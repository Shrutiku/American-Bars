	     			<ul class="bottom_box">
							<?php 
		  					if($forum_comment)
							{
								foreach($forum_comment as $arcm)
								{?>
			         		<li>
			         			<div class="media">
								    <a class="user_img_link" href="<?php echo site_url('user/profile/'.base64_encode($arcm->user_id))?>">
								      	<?php
		  							if($arcm->profile_image != "" && is_file(base_path()."upload/user_thumb/".$arcm->profile_image))
									{
		  							?>
		  							<img class="img-responsive br_green_yellow" src="<?php echo base_url() ; ?>/upload/user_thumb/<?php echo $arcm->profile_image; ?>" />
		  				  		  <?php }
									else {
		  				  		  ?>
		  				  		  <img src="<?php echo base_url() ; ?>/upload/no_img.png" />
		  				  		  <?php }?>
								    </a>
								    <div class="media-body">
								       <div><h4 class="media-heading"><a href="<?php echo site_url('user/profile/'.base64_encode($arcm->user_id))?>" class="bar_title"><?php echo $arcm->first_name." ".$arcm->last_name; ?></a></h4></div>
								       <div class="result_desc"><?php echo $arcm->comment; ?></div>
								       <div class="mar_top5">
								       	  <div class="reviewlabel pull-left"><?php 
								       	  
								       	  echo  date($site_setting->date_format. " h:i:s",strtotime($arcm->date_added)); ?></div>
								       	  <!-- <div class="pull-right"><a href="#" class="more">View More</a></div> -->
								       </div>
								    </div>
						    	</div>
						    	<div class="clearfix"></div>
			         		</li>
			         		<?php }
							}
							else {
								echo "<li>No Comment</li>";
							}
		  					?>
			         	</ul><div class="clearfix"></div>
	     			
	     			<div class="pagination">
	     				<?php echo $page_link;?>
		     			<!-- <ul class="pagination">
		     				<li><a href="#">Prev</a></li>
		     				<li class="active"><a href="#">1</a></li>
		     				<li><a href="#">2</a></li>
		     				<li><a href="#">3</a></li>
		     				<li><a href="#">4</a></li>
		     				<li><a href="#">5</a></li>
		     				<li><a href="#">Next</a></li>
		     				<div class="clearfix"></div>
		     			</ul> -->
     				</div>
     				<div class="clearfix"></div>
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
			   	//alert("fds");
			       $('#dvLoading').fadeOut('slow');
			    }
			}).responseText;	
			//alert(res);
			$("#responsecomment").html(res);
			
			return false;
			
		});
		
</script>
