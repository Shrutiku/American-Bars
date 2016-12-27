<!-- ########################################################################################### -->
<?php
$theme_url =  base_url().getThemeName();
//$category_videoes = get_forum_category_wise($forum_detail["forum_id"],$forum_detail["forum_category_id"],3);
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
		var vid = '<?php echo $forum_detail["forum_id"]; ?>';
		var uid = '<?php echo $this->session->userdata("user_id"); ?>';
		      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>forum/add_rating",         //the script to call to get data          
        data: {forum_rating: rat,forum_id: vid, user_id: uid},
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
        url: "<?php echo base_url(); ?>forum/add_comment",         //the script to call to get data          
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
<!-- content -->
<div class="wrapper row3 padtb20">
  <div id="container" class="clear">
  	<div class="row">
  		<h1 class="maintitle">Forums</h1>
  		
  	</div>
  	<div class="row">
  		<div class="left_block">
	  		<div class="videodetail_block">
	  			<div class="forum_title_block">
	  				<h2 class="smalltitle"><?php echo $forum_detail["topic_name"]; ?></h2>
	  			</div>
	  			<div class="fl_right mart20">
	  				<ul class="videodata">
	  					<li class="rating_label">Ratings :</li>
	  					<?php if($check_already_retade ==1)
	  								{?>
	  										<li id="ratedli"><?php echo get_forum_rating($forum_detail["forum_id"]); ?></li>
	  								<?php }
									else
										{?>
											<li id="ratingli"><div id="star1" class="rating">&nbsp;
	  									<input type="hidden" name="rating" id="rating" value="" />
	  									</div></li>
	  									
	  									<li id="ratedli" class="hide1"><?php echo get_forum_rating($forum_detail["forum_id"]); ?></li>
										<?php }
	  								?>
	  							
	  					<div class="clear"></div>
	  				</ul>
	  			</div>
	  			<div class="clear"></div>
	  				<div>
	  					<div class="fl_left">
	  						<ul class="videodata">
	  							<li>Date: <label class="red"><?php echo date($site_setting->date_format,strtotime($forum_detail["date_created"])); ?></label></li>
	  							<li>By : <label class="red"><?php if($forum_detail["user_id"]>0){ echo $forum_detail["first_name"]." ".$forum_detail["last_name"];}else { echo "Administrator"; } ?></label></li>
	  							<!--<li>Category : <label class="red"><?php echo $forum_detail["category_name"]; ?></label></li>-->
	  							<!--<li>View: <label class="red"><?php echo $forum_detail["total_views"]; ?></label></li>-->
		  						<li>Comments : <label class="red"><?php echo count_forum_comment($forum_detail["forum_id"]); ?></label></li>
		  						<div class="clear"></div>
	  						</ul>
	  						<ul class="videodata mart7">
	  							<!-- <li>Type : <label class="red">Paid</label></li> -->
		  						<!-- <li>Price : <label class="red">$100</label></li> -->
		  						<div class="clear"></div>
		  					</ul>
		  				</div>
			  			<div class="fl_right">
		  						<?php $url_share = base_url()."forum/detail/".base64_encode($forum_detail["forum_id"]);  ?>
	  						<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url_share;?>" target= "_blank"><i class="strip fb"></i></a>
	  						<a href="http://twitter.com/home?status=<?php echo $url_share;?>" target= "_blank"><i class="strip twitter"></i></a>
	  						<a href="#"><i class="strip google1"></i></a>
	  					</div>
	  					<div class="clear"></div>
	  				</div>
	  				<div class="mart20">
	  					
	  					
	  					
	  							<div class="mart7">
	  					<!--<?php
	  						if($forum_detail["forum_image"] != "" && is_file(base_path()."upload/forum_image/".$forum_detail["forum_image"]))
							{?>
									<img class="artimg" src="<?php echo base_url()."upload/forum_image/".$forum_detail["forum_image"] ?>" width="337" height="232"/>
							<?php }
							else{?>
									<img class="artimg" src="<?php echo base_url()."upload/no_img.png/"?>" width="337" height="232"/>
							<?php }
	  						?>-->
	  						<?php echo $forum_detail["forum_decription"]; ?>
	  				</div> 	
	  						
	  						
	  					
	  					<div class="clear"></div>
	  				</div>
	  				
	  				
	  			
	  			</div>
	  			<div>
	  				<!--<h2 class="smalltitle">Most Related Article</h2>
	  				
	  				<?php
	  				if($category_videoes)
					{
						foreach($category_videoes as $cv)
						{?>
	  				<div class="relatedvideo">
	  					<a href="<?php echo site_url("forum/detail/".base64_encode($cv->forum_id)); ?>">
	  				
	  						<?php
	  						if($cv->forum_image != "" && is_file(base_path()."upload/forum_image/".$cv->forum_image))
							{?>
									<img src="<?php echo base_url().'upload/forum_image/'.$cv->forum_image; ?>" width="215" height="130"/>
							<?php }
							else{?>
								<img src="<?php echo base_url().'upload/no_img.png'; ?>" width="215" height="130"/>
							<?php }
	  						?>
	  						
	  						</a>
	  					<div class="mart7">
	  						<a href="<?php echo $url_share; ?>"><label class="smalltitle disp_block point"><?php echo substr($cv->forum_title,0,12).".."; ?></label></a>
	  						<div>	  						
	  						<label class="rating_label fl_left">Ratings :</label><?php echo get_forum_rating($cv->forum_id); ?>
	  						</div>

	  					</div>
	  				</div>
	  				
	  				<?php }
					}
					?>-->
	  				
	  				<div class="clear"></div>
	  			</div>
	  			<div class="comment_block">
	  				<div>
		  				<h2 class="smalltitle">Comments</h2>
		  				<div class="success text-center" id="comtmsg"></div>
		  				<ul class="comments">
		  					<?php 
		  					if($forum_comment)
							{
								foreach($forum_comment as $arcm)
								{?>
									<li>
		  						<div class="fl_left marr10">
		  							<?php
		  							if($arcm->profile_image != "" && is_file(base_path()."upload/user_thumb/".$arcm->profile_image))
									{
		  							?>
		  							<img src="<?php echo base_url() ; ?>/upload/user_thumb/<?php echo $arcm->profile_image; ?>" />
		  				  		  <?php }
									else {
		  				  		  ?>
		  				  		  <img src="<?php echo base_url() ; ?>/upload/no_img.png" />
		  				  		  <?php }?>
		  				  		</div>
		  						<div class="comment_desc_block">
			  						<label class="rating_label"><?php echo $arcm->first_name." ".$arcm->last_name; ?></label>
			  						<p class="video_desc "><strong><?php echo date($site_setting->date_time_format,strtotime($arcm->date_added)); ?></strong></p>
			  						<p class="video_desc"><?php echo $arcm->comment; ?></p>
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
  							<input type="hidden" name="forum_id" id="forum_id" value="<?php echo $forum_id; ?>" />
  							<button type="submit" class="button text-center marr156">Submit</button>
  						</div>
  						</form>
  						
  						<?php }?>		  						
	  				</div>
	  			</div>
  		</div>
  		<div class="right_block">
  			<h2 class="smalltitle">Advertisement</h2>
  			<div class="mart7"><img src="<?php echo $theme_url; ?>/images/adv1.png"/></div>
  		</div>
  		<div class="clear"></div>
  	</div>

  </div>
</div>
<!-- ########################################################################################### -->