<script type="text/javascript">

 $(document).ready(function(){
 	
 	
 	///////////commment ajax pagination...//////
 $("#pagination a").click('click', function(){
       $('#dvLoading').fadeIn('slow');
        $.ajax({
            type: "POST",          
            url: this.href,
            success: function(html) {//alert(html);
                 $('#beer-comment-box').html(html);
               $('#dvLoading').fadeOut('slow');
               testsub();
                  just_here();
             }
        });
        return false;      
    });
/// end of comment ajax pagination/////////////
 });
</script>
<ul class="bottom_box">
							<?php 
							if(count($beer_comment)>0){ 
							foreach($beer_comment as $bc){?>
			         		<li id="comment_<?php echo $bc->beer_comment_id; ?>">
			         			<div class="media">
								    <a class="user_img_link" href="<?php echo site_url('user/profile/'.base64_encode($bc->user_id)); ?>">
										<img src="<?php echo base_url();?>upload/user_thumb/<?php if($bc->profile_image!="" && is_file(base_path().'upload/user_thumb/'.$bc->profile_image)){ echo $bc->profile_image; } else{ echo 'no_img.png';}?>" class="img-responsive br_green_yellow"/>
								    </a>
								    <div class="media-body">
								       <div><h4 class="media-heading">
								       	 <?php if($bc->user_id!=0){?><a href="<?php echo site_url('user/profile/'.base64_encode($bc->user_id));?>" class="bar_title"><?php echo $bc->first_name.' '.$bc->last_name; ?><?php } else {?><a href="javascript://" class="bar_title">ADB<?php } ?></a></h4></div>
								       <div id="f_<?php echo $bc->beer_comment_id; ?>" class="result_desc wid100 more"><?php echo $bc->comment_title; ?></div>
								       <div id="f_<?php echo $bc->beer_comment_id; ?>" class="result_desc wid100 more"><?php echo $bc->comment; ?></div>
								       <div class="reviewlabel mar_top5"><?php echo date('d M',strtotime($bc->date_added)); ?> By <?php echo $bc->first_name.' '.$bc->last_name; ?> <?php echo getDuration($bc->date_added); ?></div>
								       <div class="mar_top20">
										   <?php if($bc->comment_image!="" && is_file(base_path().'upload/comment_image/'.$bc->comment_image)){ ?>
											<div class="pos_rel wid100">
												<img src="<?php echo base_url();?>upload/comment_image/<?php echo $bc->comment_image; ?>" class="photo_img br_green_yellow"/>
											</div>
											<?php } ?>
											<?php if($bc->comment_video!=""){ ?>
											<br />
											<div class="pos_rel wid100">
												<div width="640" height="246" controls>
													<!-- <object width="640" height="246" id="vpalyobj<?php echo $bc->comment_video; ?>" name="vpalyobj<?php echo $bc->comment_video; ?>" data="http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf" type="application/x-shockwave-flash">
													<param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf" />
													<param name="allowfullscreen" value="true" />
													<param name="allowscriptaccess" value="true" />
													<param name="flashvars" value='config={"playlist":[{"url":"<?php echo base_url().'upload/comment_video/'.$bc->comment_video; ?>","autoPlay":false}]}' />
													 -->
												<?php	 if($bc->comment_video!=''){
            $url	=	$bc->comment_video;
				if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',$url,$matches)) {
					//echo $url;
				      //preg_match('/[\\?\\&]v=([^\\?\\&]+)/',$url,$matches);
				      //preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',$url,$matches);
							if(isset($matches[1])){
							$id = $matches[1];
								echo  '<iframe  style="width:640px; height:250px;" class="br_red img-responsive max-height embed_vid_height"  src="//www.youtube.com/embed/'.$id.'?rel=0" frameborder="0" allowfullscreen></iframe>';
							}else{
								echo $url;
							}
				    } elseif (strpos($url, 'vimeo') > 0) {
				    	preg_match('~^http://(?:www\.)?vimeo\.com/(?:clip:)?(\d+)~',$url,$matches);
				//	$parsed = parse_url($url);
					//print_r($parsed);
				       if(isset($matches[1])){
							$id = $matches[1];
							echo  '<iframe style="width:640px; height:250px;" src="//player.vimeo.com/video/'.$id.'" class="br_red img-responsive max-height embed_vid_height" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> ';	
								
							}else{
								$a=json_decode(file_get_contents('http://vimeo.com/api/oembed.json?url='.$url));
								
								if(isset($a->video_id) && $a->video_id!=''){
								$id=$a->video_id;
									echo '<iframe style="width:640px; height:250px;" src="//player.vimeo.com/video/'.$id.'" class="br_red img-responsive max-height embed_vid_height" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> ';	
								}
							}
				    }
				    } ?>
													 </object>
												</div>
											</div>										
										<?php } ?>
										<form class="mysubadb" id="add-subcomment-<?php echo $bc->beer_comment_id; ?>" name="add-subcomment-<?php echo $bc->beer_comment_id; ?>" enctype="multipart/form-data" method="post" action="<?php echo site_url("beer/add_subcomment"); ?>">
								    
								    		<div class="mart10">
								    			<?php
												$comment_like = comment_like_checker($beer_detail['beer_id'],$this->session->userdata('user_id'),$bc->beer_comment_id);
											//if($this->session->userdata("user_id")!=""){
												if($comment_like==2){
												?>
												<a href="javascript:void(0);" id="comment_like_<?php echo $bc->beer_comment_id; ?>" name="2#<?php echo $bc->beer_comment_id; ?>" class="comment_like"><i class="strip like"></i></a>
												<?php }	else{ ?>												
												<a href="javascript:void(0);" id="comment_like_<?php echo $bc->beer_comment_id; ?>" name="<?php if($comment_like==1){ echo $comment_like=0;} else{ echo $comment_like=1; } ?>#<?php echo $bc->beer_comment_id; ?>" class="comment_like"><i class="strip <?php if($comment_like==0){ ?>dislike<?php } else{ ?>like<?php } ?>"></i></a>
												<?php }	
											//}?>
												<p id="total_comment_likes_<?php echo $bc->beer_comment_id; ?>" class="result_desc pull-left mar_right20"><?php $total_k2 = flag_return($bc->beer_id,$bc->beer_comment_id); if($total_k2<=1){ echo $total_k2.' Like';} else{ echo $total_k2.' Likes'; } ?></p>
												<!-- <a href="javascript://" id="status" class="bar_title pull-left">Reply</a> -->
											<?php //if($this->session->userdata("user_id")!=""){?>
								    			<a id="status<?php echo $bc->beer_comment_id; ?>" class="bar_title sp_reply sprp_<?php echo $bc->beer_comment_id; ?>">Reply</a>
											<?php //} ?>
								    			<div class="post_block1 wid82" style="display: none;">
								    					<div class="error1" style="display: none;" id="cmsub-err-main<?php echo $bc->beer_comment_id; ?>"></div>
								  					<div>
									  					<textarea id="comment" name="comment" class="status form-control form-pad" placeholder="Write Here" rows="4"></textarea>
									  				</div>
									  				<div class="mart10">
									  							  						
															<input accept="image/*" type="file" class="wid215 form-control wid60" id="comment_image" name="comment_image" value="">
														</div>
														
														<input type="hidden" class="beer_id" id="beer_id" name="beer_id" value="<?php echo $bc->beer_id; ?>">
														<input type="hidden" class="master_comment_id" id="master_comment_id" name="master_comment_id" value="<?php echo $bc->beer_comment_id; ?>">
													<div class="mart10">
														<button type="submit" class="btn btn-lg btn-primary">Post</button>
													</div>	
								  						<div class="clearfix"></div>
									  				<div class="clearfix"></div>													
  												</div>												
								    			<div class="clearfix"></div>
								    		</div>
							    		</form>
								    		
								      </div>
								     
								      <div class="wid100" id="beer-comment-list">
								      	<ul id="innersub<?php echo $bc->beer_comment_id; ?>" class="result_sub_box mart10">
											<?php
											//echo $bc->beer_comment_id;
											//echo '<pre>';
											if(isset($beer_subcomment[$bc->beer_comment_id])){
											//print_r($beer_subcomment);
											foreach($beer_subcomment[$bc->beer_comment_id] as $subcm){											
											?>
											
							         		<li id="<?php echo $subcm->beer_comment_id; ?>" class="active pos_rel">
							         			<div class="media">
												    <a class="pull-left" href="<?php echo site_url('user/profile/'.base64_encode($subcm->user_id)); ?>">
												    	
														<img src="<?php echo base_url();?>upload/user_thumb/<?php if($subcm->profile_image!="" && is_file(base_path()."upload/user_thumb/".$subcm->profile_image)){ echo $subcm->profile_image; } else{ echo 'no_img.png';}?>" class="user_img"/>
												    
												    
												    </a>
												    <div class="media-body">
														<?php
														$dlt_status = comment_rights($this->session->userdata("user_id"),$subcm->beer_comment_id);
														if($dlt_status=='yes'){
														?>
												    	<a href="javascript:void(0);" class="remove_subcomment" name="<?php echo $subcm->beer_comment_id; ?>"><i class="strip close_icon"></i></a>
														<?php } ?>
												        <div><h4 class="media-heading"><a href="<?php echo site_url('user/profile/'.base64_encode($subcm->user_id)); ?>" class="bar_title"><?php echo $subcm->first_name.' '.$subcm->last_name; ?></a></h4></div>
												        <div id="g_<?php echo $bc->beer_comment_id; ?>"  class="result_desc more"><?php echo $subcm->comment; ?></div> 
												        <div class="reviewlabel mar_top5"><?php echo date('d M',strtotime($subcm->date_added)); ?> By <?php echo $subcm->first_name.' '.$subcm->last_name; ?> <?php echo getDuration($subcm->date_added); ?></div>
												    
														<div class="mar_top20">
														<?php if($subcm->comment_image!="" && is_file(base_path().'upload/comment_image/'.$subcm->comment_image)){ ?>
														<div class="pos_rel">
															<img src="<?php echo base_url();?>upload/comment_image/<?php echo $subcm->comment_image; ?>" class="photo_img br_green_yellow"/>
														</div>
														<?php } ?>
														<?php 
													
														if($subcm->comment_video !="" && is_file(base_path().'upload/comment_video/'.$subcm->comment_video)){ ?>
														<br />
														<div class="pos_rel wid100">
															<div width="640" height="246" controls>
																<object width="640" height="246" id="vpalyobj<?php echo $subcm->comment_video; ?>" name="vpalyobj<?php echo $subcm->comment_video; ?>" data="http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf" type="application/x-shockwave-flash">
																<param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf" />
																<param name="allowfullscreen" value="true" />
																<param name="allowscriptaccess" value="true" />
																<param name="flashvars" value='config={"playlist":[{"url":"<?php echo base_url().'upload/comment_video/'.$subcm->comment_video; ?>","autoPlay":false}]}' />
																</object>
															</div>
														</div>
													</div>								
													<?php } ?>
													</div>
										    	</div>
										    	<!-- <div class="clearfix"></div> -->
							         		</li>							         		
							         		<?php } }?>
							         	</ul>
								      </div>
								    </div>
						    	</div>
						    	<div class="clearfix"></div>
			         		</li>
							<?php
							}
						}
							?>
			         	</ul>
			         		<div class="pagination mart20" id="pagination">
			  			<ul class="pagination">
							<?php echo $page_link; ?>
						</ul>
					</div>
					<div class="clearfix"></div>