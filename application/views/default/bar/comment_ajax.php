<div id="responsecomment">
	     			<ul class="review_block" >
	     				<?php if($result){
	     					  foreach($result as $comment){?>
	     				<li>
		     					<div class="reult_sub_title"><a class="bar_title"><?php echo $comment->comment_title; ?></a></div>
		     					<div class="rating_box"><a class="bar_title"><?php echo getDuration($comment->date_added); ?></a></div>
		     					<div class="clearfix"></div>
		     					<p class="result_desc"><?php if(strlen($comment->comment)>300) { echo substr($comment->comment,0,300)."..."; } else { echo $comment->comment; }?></p>
		     					<div class="reult_sub_title"><p class="review_light pull-left"><?php echo $comment->first_name." ".$comment->last_name;?></p></div>
		     					<div class="rating_box starrating<?php echo $comment->bar_rating; ?>"><a href="javascript"></a></div>
		     					<div class="clearfix"></div>
		     				</li>
	     				<?php } }?>	  	
	     				
	     			</ul>
	     			
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
			   	//alert("fds");
			       $('#dvLoading').fadeOut('slow');
			    }
			}).responseText;	
			//alert(res);
			$("#responsecomment").html(res);
			
			return false;
			
		});
		
</script>
     </script>					