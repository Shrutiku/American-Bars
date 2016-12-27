<?php if($bar_comment){
     						  foreach($bar_comment as $comment){?>	
	         						<li>
				     					<div class="reult_sub_title "><a class="bar_title"><?php echo $comment->comment_title; ?></a></div>
				     					<div class="rating_box"><a class="bar_title"><?php echo getDuration($comment->date_added); ?></a></div>
				     					<div class="clearfix"></div>
				     					<p class="result_desc"><?php if(strlen($comment->comment)>300) { echo substr($comment->comment,0,300)."..."; } else { echo $comment->comment; }?></p>
				     					<div class="reult_sub_title wdth-74"><p class="review_light pull-left"><?php echo $comment->first_name." ".$comment->last_name;?></p></div>
				     					<div class="rating_box starrating<?php echo $comment->bar_rating; ?>"><a href="javascript"></a></div>
				     					<div class="clearfix"></div>
				     				</li>
	         			<hr style="border: 0px; padding: 0; margin: 0;">
	         			<?php } ?>
	         			
	         			<?php } else { ?>
<?php }?>