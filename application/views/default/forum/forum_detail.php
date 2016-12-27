<!-- ########################################################################################### -->
<?php
$theme_url =  base_url().getThemeName();
//$category_videoes = get_forum_category_wise($forum_detail["forum_id"],$forum_detail["forum_category_id"],3);
?>
<style type="text/css">
	/*//.rating {margin: 0em !important;width:100px;}*/
</style>

<script type="text/javascript">
	 $(document).ready(function () {
    	
//for rating//
	
	
	// newsletter submit//
	$("#add-comment").validate({
        rules: {
            comment_title: { required: true },
            comment: { required: true },
           
        },
       
        submitHandler: function(form) {
           <?php if($this->session->userdata('user_type')=='taxi_owner'){?>
  	    	  $.growlUI('<?php echo NO_RIGHT; ?>');
  	    	   $(".growlUI strong").empty();
  	    	  return false;
  	    <?php } ?> 
           $.ajax({
        type: "POST",
        
        url: "<?php echo base_url(); ?>forum/add_comment",         //the script to call to get data          
	    data: $("#add-comment").serialize(),
       dataType : 'json',
       beforeSend : function(){
			      $('#dvLoading').fadeIn('slow');
			   },
			   complete: function(){
			     $('#dvLoading').fadeOut('slow');
			    },      
        success: function(json)          //on receive of reply
            {
			 
			    $("#comtmsg").html(json);   
			    $("#comtmsg").show();
				$('#dvLoading').fadeOut('slow');
				$("#cm-err-main").html("");
				$.growlUI('<?php echo "Your Comment Add successfully ."; ?>');
				var data = '';
				
				data += '<li><div class="media"><a href="<?php echo site_url('user/profile/'.base64_encode(get_authenticateUserID()))?>" class="user_img_link">';
				if(json.profile_image!='')
				{
				 data += '<img src="<?php echo base_url(); ?>/upload/user_thumb/'+json.profile_image+'" class="img-responsive br_green_yellow"></a>';
				}
				else
				{ 
				 data += '<img src="<?php echo base_url()?>/upload/no-image.png" class="img-responsive br_green_yellow"></a>';
				} 
				data += '<div class="media-body"><div><h4 class="media-heading"><a class="bar_title" href="<?php echo site_url('user/profile/'.base64_encode(get_authenticateUserID()))?>">'+json.first_name+' '+ json.last_name +'</a></h4></div>';
				data += '<div class="result_desc">'+json.comment+'</div>';
				data += '<div class="mar_top5"><div class="reviewlabel pull-left">'+json.date_added+'</div>';
				data +=  '</div></div></div><div class="clearfix"></div></li>';
				$('.bottom_box:last').append(data);
				
				// data += '<li>';
				// data +='<div class="reult_sub_title "><a class="bar_title">'+json.comment_title+'</a></div>';
				// data +='<div class="rating_box">'+ json.date_duration +'</div><div class="clearfix"></div>';
				// data +='<p class="result_desc">'+json.comment+'</p>';
				// data +='<div class="reult_sub_title"><p class="review_light pull-left">'+json.first_name+' '+ json.last_name +'</p></div>';
				// data +='<div class="rating_box starrating'+json.bar_rating+'"><a href="javascript://"></a></div><div class="clearfix"></div></li>';
				// $('.bottom_box').prepend(data);
	       		 $(':input','#add-comment')
			  .not(':button, :submit, :reset, :hidden')
			  .val('')
			  .removeAttr('checked')
			  .removeAttr('selected');
			   $('#dvLoading').fadeOut('slow');
            } 
		
        });
        }
    }); //end validate
	// end of newsletter submit//
});
</script>
<script>
	$(document).ready(function() {
		
	var showChar = 600;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more";
    var lesstext = "Show less";
    
    $('.more').each(function() {
        var content = $(this).html();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="javascript://;" class="morelink more pull-right"><i class="strip arrow_down"></i>' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
      $(".morelink").click(function(){
         $("#myModalnew_open").modal('show');
    });
     }); 
</script>
<div class="wrapper row4">
   		<div class="container clearfix">
   			<div class="carousel slide" id="slider-fixed-banner">
        	<div class="carousel-inner">
          	<div class="active item">
            	 <?php $getimagename = getimagenamebanner();?>	
          	  <?php 
									if($getimagename->forum!="" && is_file(base_path().'upload/bar_pages_banner_orig/'.$getimagename->forum)){ ?>
										<img src="<?php echo base_url().'upload/bar_pages_banner/'.$getimagename->forum; ?>"   />
									<?php
									} else {?>
            	<img src="<?php echo base_url(); ?>/default/images/smallbanner1.png" alt="American Bars"/>
            	<?php } ?>
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
     		<div class="result_search">
     			<div class="col-sm-8">
	     			<div class="result_search_text pull-left">Forum</div>
	            </div>
	            <div class="clearfix"></div>
     		</div>
     		<div>
     			
     		</div>
     		<div class="mar_top20">
	     		<div class="left_block">
		     		<div class="padtb10 pad_lr10">
     					<div class="img_wid95 ">
     						<div>
     							<div class="event_bar_img">
     									<?php
				if($forum_detail['user_id']>0){
								  
								 	
		          		if($forum_detail['profile_image']!="" && file_exists(base_path().'upload/user_thumb/'.$forum_detail['profile_image']))
					{
						?>
		            	    <img class="img-responsive" src="<?php echo base_url()?>/upload/user_thumb/<?php echo $forum_detail['profile_image']; ?>" alt="American Bars"/>
		            	<?php } else {
		            		?>
		            		<img class="img-responsive" src="<?php echo base_url()?>/upload/no-image.png" alt="American Bars"/>	
		            			<?php } } else {
		            		?>
		            		<img class="img-responsive" src="<?php echo base_url()?>/upload/no-image.png" alt="American Bars"/>	
		            			<?php } ?>
     							</div>
     							<div class="event_bar_desc">
     								<ul class="beerdirectory">
     									<li><p class="yellow_title"><?php echo ucwords($forum_detail["topic_name"]); ?></p></li>
     									<li>Posted By : <?php if($forum_detail["user_id"]>0){ echo $forum_detail["first_name"]." ".$forum_detail["last_name"];}else { echo "AB"; } ?></li>
     									<li>Total Comments : <?php echo count_forum_comment($forum_detail["forum_id"]); ?></li>
     								</ul>
     							</div>
     							<div class="clearfix"></div>
     						</div>
     						<div class="result_desc padtb10">
								
								<?php if(strip_tags(strlen($forum_detail['forum_decription'])>350)){ echo substr(strip_tags($forum_detail['forum_decription']),0,350).'...<a class="morelink more pull-right" href="javascript://"><i class="strip arrow_down"></i>Show more</a>' ; } else { echo strip_tags($forum_detail['forum_decription']); } ?> 
     						</div>
     					</div>
     				</div>
     				<div class="result_search">
	     				<div class="result_search_text">Comments</div>
     				</div>
     				<div class="mar_top20">
     				<div id="responsecomment">	
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
								       <div><h4 class="media-heading"><a href="<?php echo site_url('user/profile/'.base64_encode($arcm->user_id))?>" class="bar_title"><?php echo ucwords($arcm->first_name)." ".ucwords($arcm->last_name); ?></a></h4></div>
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
     				</div><div class="clearfix"></div>
			         	</div>
					</div>
					
	     			<div class="result_search mar_top20">
	     				<div class="result_search_text">Add Comment</div>
     				</div>
     				<div class="mar_top20">
     					<?php 
		  				if($this->session->userdata("user_id") == "" || $this->session->userdata("user_id") == 0 )
						{
		  				?>
		  				<label class="cheklabel">You must be <a href="#" class="red text-trans">logged</a> in to post comments. Take a minute to <a href="#" class="red text-trans">sign up</a> if you don't yet have an account.</label>
		  				<?php }
		  				else {?>
     				<form class="form-horizontal" id="add-comment" name="add-comment">
     						<div class="">
     							<label class="label-control"> Comment : </label>
     							<textarea  name="comment" id="comment" class="form-control mart10" rows="4" placeholder="Description"></textarea>
     						</div><div class="clearfix"></div>
     						<div class="mar_top20">
     							<button type="submit" name="" class="btn btn-lg btn-primary more_btn">Save</button>
     							<input type="hidden" name="forum_id" id="forum_id" value="<?php echo $forum_id; ?>" />
     						</div>
     					</form>
     					<?php } ?>
     				</div>
	     		</div>
	     		<div class="right_block_releated">
	     			<div class="text-left padtb10 ">
	     				<h1 class="productbar_title">Popular Topics</h1>
	     				<div class="clearfix"></div>
	     				<ul class="review_block">
	     					
		     					<?php
	  		if($popular_forum)
	  		{
	  			foreach($popular_forum as $rs)
	  			{
	  				?>
		     				<li>
		     					<div class="pull-left marr_10">
		     							<?php
				if($rs->user_id>0){
								      	
		          		if($rs->profile_image!="" && file_exists(base_path().'upload/user_thumb/'.$rs->profile_image))
					{
						?>
		            	    <img style="width: 50p; height: 57px;" class="img-responsive" src="<?php echo base_url()?>/upload/user_thumb/<?php echo $rs->profile_image; ?>" alt="American Bars"/>
		            	<?php } else {
		            		?>
		            		<img style="width: 50p; height: 57px;" class="img-responsive" src="<?php echo base_url()?>/upload/no-image.png" alt="American Bars"/>	
		            			<?php } } else {
		            		?>
		            		<img style="width: 50p; height: 57px;" class="img-responsive" src="<?php echo base_url()?>/upload/no-image.png" alt="American Bars"/>	
		            			<?php } ?>
		     					</div>
		     					<div class="related_beer_block">
			     					<div><a class="bar_title" href="<?php echo site_url("forum/detail/".base64_encode($rs->forum_id));?>"><?php echo ucwords($rs->topic_name); ?></a></div>
			     					<p class="result_desc">Posted By <?php if($rs->user_id>0){ echo $rs->first_name." ".$rs->last_name;}else { echo "AB"; } ?></p>
			     					<p class="result_desc pull-left mar_r5">Total Views : <?php echo $rs->view; ?></p>
			     					<p class="result_desc pull-left">Total Comments : <?php echo count_forum_comment($rs->forum_id); ?></p>
			     					<div class="clearfix"></div>
		     					</div>
		     					<div class="clearfix"></div>
		     				</li>
		     				<?php } } ?>
		     				
		     			</ul>
	     			</div>
	     			
	     		</div>
	     		<div class="clearfix"></div>
     		</div>
     		
   		</div>
   	</div>
   	
<div class="modal fade" id="myModalnew_open" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Description</div>
     				</div>
     				<div class="pad20">
     						<label class="control-label" style="color: #fff;"><?php echo nl2br($forum_detail['forum_decription']); ?></label>	
     				</div>		
     			</div>
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
			$("#responsecomment").html(res);
			
			return false;
			
		});
</script>