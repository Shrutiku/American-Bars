<?php
$theme_url = $urls= base_url().getThemeName();
$category_videoes = get_video_category_wise($video_title["video_id"],$video_title["video_category_id"],3);

?>
<style type="text/css">
	/*//.rating {margin: 0em !important;width:100px;}*/
</style>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/rating.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/js/rating.css" />

<script type="text/javascript">
	 $(document).ready(function () {
    	
//for rating//
	$('#star1').rating('www.url.php', {maxvalue:5});
	$(".cancel").hide();
// end of for ratting////	
	$(".star").click(function(){
		var rat = $("#rating").val();
		var vid = '<?php echo $video_title["video_id"]; ?>';
		var uid = '<?php echo $this->session->userdata("user_id"); ?>';
		      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>video/add_rating",         //the script to call to get data          
        data: {video_rating: rat,video_id: vid, user_id: uid},
	    dataType: '',                //data format      
        success: function(data)          //on receive of reply
            {
			  
			   // alert(data);
			    //var rt = '';
			   // alert(rt);
			    $("#ratedli").html(data);
			    $("#ratedli").show();
			    $("#ratingli").hide();
		    } 
		
        });
		
	});
	
	// newsletter submit//
	$("#add-comment").validate({
        rules: {
            comment_title: { required: true },
            comment: { required: true },
           
        },
       
        submitHandler: function(form) {
           
           $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>video/add_comment",         //the script to call to get data          
      //  data: {sendtoid: send_to_id, sendtotype: send_to_type, msg: message, msg_id: message_id},
	    data: $("#add-comment").serialize(),
        dataType: '',                //data format      
        success: function(data)          //on receive of reply
            {
			  
			     $("#comtmsg").html(data);   
			    $("#comtmsg").show();
			    
			   setTimeout(function () 
				 {
				      $("#comtmsg").fadeOut('slow');
				     
				      
				      $(':input','#add-comment')
						 .not(':button, :submit, :reset, :hidden')
						 .val('')
						 .removeAttr('checked')
						 .removeAttr('selected');
						 
						location.reload(true);
												 
				}, 2000);
				
				
            } 
		
        });
        }
    }); //end validate
	// end of newsletter submit//
});
</script>
<!-- ########################################################################################### -->
<!-- content -->
<div class="wrapper row3 padtb20">
  <div id="container" class="clear">
  	<div class="row">
  		<h1 class="maintitle">Poker Video</h1>
  	
  	</div>
  	<div class="row">
  		<div class="left_block">
	  		<div class="videodetail_block">
	  				<h2 class="smalltitle"><?php echo $video_title["video_title"]; ?></h2>
	  				<div>
	  					
	  					<?php 
	  					if($video_title["video_type"] == "paid")
						{
						   $video_play = "video_preview/".$video_title["video_preview"];	
						}
						
						else {
							$video_play = "video/".$video_title["video_file_name"];	
						}
						
	  					?>
	  					<!-- <img src="<?php echo $theme_url ; ?>/images/videobig1.png"/> -->
	  					<object width="685" height="320" id="undefined" name="undefined" data="http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf" type="application/x-shockwave-flash">
<param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf" />
<param name="allowfullscreen" value="true" />
<param name="allowscriptaccess" value="always" />
<param name="flashvars" value='config={"playlist":[{"url":"<?php echo base_url().'upload/video_image/'.$video_title["video_image"]; ?>", "autoPlay":true},
{"url":"<?php echo base_url().'upload/'.$video_play; ?>","autoPlay":false}]}' />
</object>


	 <!-- <object width="515" height="390" id="undefined" name="undefined" data="http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf" type="application/x-shockwave-flash">
<param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf" />
<param name="allowfullscreen" value="true" />
<param name="allowscriptaccess" value="always" />
<param name="flashvars" value='config={"playlist":[{"url":"<?php echo base_url().'upload/video_image/'.$video_title["video_file_name"]; ?>","autoPlay":false}]}' />
</object> -->
	  				</div>
	  				<div class="mart20">
	  					<div class="fl_left">
	  						<ul class="videodata">
	  							<li>Date: <label class="red"><?php echo date($site_setting->date_format,strtotime($video_title["date_created"])); ?></label></li>
	  							<li>By : <label class="red"><?php if($video_title["user_id"]>0){ echo $video_title["first_name"]." ".$video_title["last_name"];}else { echo "Administrator"; } ?></label></li>
	  							<li>Category : <label class="red"><?php echo $video_title["category_name"]; ?></label></li>
	  							<div class="clear"></div>
	  						</ul>
			  				<div class="mart7">
			  					<ul class="videodata">
		  							<li>View: <label class="red"><?php echo $video_title["total_views"]; ?></label></li>
		  							<li>Comments : <label class="red"><?php echo count_video_comment($video_title["video_id"]); ?></label></li>
		  							<li>Type : <label class="red"><?php echo $video_title["video_type"]; ?></label></li>
		  							<li>  <!-- <label class="red">$100</label> -->
		  								
		  								<?php
				       					if($video_title["video_type"] != "free")
										{
				       					?>
				       					Price : <label class="red"><?php echo $site_setting->currency_symbol.$video_title["video_price"]; ?></label>
				       					
				       					<?php }?>
		  							</li>
		  							<div class="clear"></div>
	  							</ul>
	  						</div>
	  						<div class="mart7">
	  							<ul class="videodata">
	  								<li class="rating_label">Ratings :</li>
	  								<?php if($check_already_retade ==1 || $this->session->userdata("user_id") == "" || $this->session->userdata("user_id") == "0")
	  								{?>
	  										<li id="ratedli"><?php echo get_video_rating($video_title["video_id"]); ?></li>
	  								<?php }
									else
										{?>
											<li id="ratingli"><div id="star1" class="rating">&nbsp;
	  									<input type="hidden" name="rating" id="rating" value="" />
	  									</div></li>
	  									
	  									<li id="ratedli" class="hide1"><?php echo get_video_rating($video_title["video_id"]); ?></li>
										<?php }
	  								?>
	  							
	  								
	  						</div>
			  			</div>
			  			<div class="fl_right">
			  				<div>
			  					<?php 
								     $url_share = site_url("video/video_detail/".base64_encode($video_title["video_id"])) ; ?>
		  					<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url_share;?>" target= "_blank"><i class="strip fb"></i></a>
	  						<a href="http://twitter.com/home?status=<?php echo $url_share;?>" target= "_blank"><i class="strip twitter"></i></a>
	  						<a href="#"><i class="strip google1"></i></a>
	  						</div>
	  						<div class="mart7">
	  							
	  							<?php
				       					if($video_title["video_type"] != "free")
										{
				       					?>
				       					<button type="submit" name="btn1" class="button">Buy Now</button>
				       					
				       					<?php }?>
	  						</div>
	  					</div>
	  					<div class="clear"></div>
	  				</div>
	  				<div>
	  					<p class="video_desc"><?php echo $video_title["video_desc"]; ?></p>
	  				</div> 			
	  			</div>
	  			<div>
	  				<h2 class="smalltitle">Most Related Videos</h2>
	  				<?php
	  				if($category_videoes)
					{
						foreach($category_videoes as $cv)
						{?>
							<div class="relatedvideo">
	  					<a href="<?php echo site_url("video/video_detail/".base64_encode($cv->video_id)); ?>">
	  						<?php
	  						if($cv->video_image != "" && is_file(base_path()."upload/video_image/".$cv->video_image))
							{?>
									<img src="<?php echo base_url().'upload/video_image/'.$cv->video_image; ?>" width="215" height="130"/>
							<?php }
							else{?>
								<img src="<?php echo base_url().'upload/no_img.png'; ?>" width="215" height="130"/>
							<?php }
	  						?>
	  						
	  					
	  						</a>
	  					<div class="mart7">
	  						<a href="<?php echo $url_share; ?>"><label class="smalltitle disp_block point"><?php echo substr($cv->video_title,0,12).".."; ?></label></a>
	  						<div>	  						
	  						<label class="rating_label fl_left">Ratings :</label><?php echo get_video_rating($cv->video_id); ?>
	  						</div>

	  					</div>
	  				</div>
	  				
					<?php 	}
					}	
	  				?>
	  				
	  				<!-- <div class="relatedvideo">
	  					<img src="<?php echo $theme_url ; ?>/images/related_video.png"/>
	  					<div class="mart7">
	  						<label class="smalltitle disp_block">Poker Video 1</label>
	  						<label class="rating_label">Ratings :<img src="<?php echo $theme_url ; ?>/images/rating.png"/></label>
	  					</div>
	  				</div>
	  				<div class="relatedvideo">
	  					<img src="<?php echo $theme_url ; ?>/images/related_video.png"/>
	  					<div class="mart7">
	  						<label class="smalltitle disp_block">Poker Video 2</label>
	  						<label class="rating_label">Ratings :<img src="<?php echo $theme_url ; ?>/images/rating.png"/></label>
	  					</div>
	  				</div>
	  				<div class="relatedvideo">
	  					<img src="<?php echo $theme_url ; ?>/images/related_video.png"/>
	  					<div class="mart7">
	  						<label class="smalltitle disp_block">Poker Video 3</label>
	  						<label class="rating_label">Ratings :<img src="<?php echo $theme_url ; ?>/images/rating.png"/></label>
	  					</div>
	  				</div> -->
	  				<div class="clear"></div>
	  			</div>
	  			<div class="comment_block">
	  				<div>
		  				<h2 class="smalltitle">Comments</h2>
		  				<ul class="comments">
		  					<?php 
		  					if($video_comment)
							{
								foreach($video_comment as $vcm)
								{?>
									<li>
		  						<div class="fl_left marr10">
		  							<?php
		  							if($vcm->profile_image != "" && is_file(base_path()."upload/user_thumb/".$vcm->profile_image))
									{
		  							?>
		  							<img src="<?php echo base_url() ; ?>/upload/user_thumb/<?php echo $vcm->profile_image; ?>" />
		  				  		  <?php }
									else {
		  				  		  ?>
		  				  		  <img src="<?php echo base_url() ; ?>/upload/no_img.png" />
		  				  		  <?php }?>
		  				  		</div>
		  						<div class="comment_desc_block">
			  						<label class="rating_label"><?php echo $vcm->first_name." ".$vcm->last_name; ?></label>
			  						<p class="video_desc "><strong><?php echo date($site_setting->date_time_format,strtotime($vcm->date_added)); ?></strong></p>
			  						<p class="video_desc"><?php echo $vcm->comment; ?></p>
		  						</div>
		  						<div class="clear"></div>
		  					</li>
						 <?php }
							}
							else {
								echo "<li>No Comment</li>";
							}
		  					?>
		  					
		  					
		  				</ul>
		  			</div>
		  			<div>
		  				<h2 class="smalltitle">Add Comments</h2>
		  				<div class="success text-center" id="comtmsg"></div>
		  				<?php 
		  				if($this->session->userdata("user_id") == "" || $this->session->userdata("user_id") == 0 )
						{
		  				?>
		  				<label class="cheklabel">You must be <a href="#" class="red text-trans">logged</a> in to post comments. Take a minute to <a href="#" class="red text-trans">sign up</a> if you don't yet have an account.</label>
		  				<?php }
		  				else {?>
		  					<form id="add-comment" name="add-comment">
		  				<div class="form-control-group">
				  			<label class="comment_form_label search_label mart7 marr10">Title :</label>
				  			<div class="form-control">
				  			<input type="text" name="comment_title" id="comment_title" class="input wrap large br_silver marr10" placeholder="Comment Title"/>
				  		
				  			</div>
				  			<div class="clear"></div>
  						</div>
  						
  						<div class="form-control-group">
				  			<label class="comment_form_label search_label mart7 marr10">Comments :</label>
				  			<div class="form-control">
				  			<textarea class="textarea wrap large br_silver" name="comment" id="comment" rows="8" placeholder="Comment"></textarea>
				  				</div>
				  			<div class="clear"></div>
  						</div>
  						<div class="fl_right clear">
  							<input type="hidden" name="video_id" id="video_id" value="<?php echo $video_id ?>" />
  							<button type="submit" class="button text-center marr156">Submit</button>
  						</div>
  						</form>
  						
  						<?php }?>		  			
	  				</div>
	  			</div>
  		</div>
  		<div class="right_block">
  			<h2 class="smalltitle">Advertisement</h2>
  			<div class="mart7"><img src="<?php echo $theme_url ; ?>/images/adv1.png"/></div>
  		</div>
  		<div class="clear"></div>
  	</div>

  </div>
</div>
<!-- ########################################################################################### -->