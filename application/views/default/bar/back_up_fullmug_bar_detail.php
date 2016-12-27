<style>
.morecontent span {
    display: none;
}
.morelink {
    display: block;
}
span.required {
    color: #B31010;
    vertical-align: -4px;
}
</style>
<style>
	#gmap_marker {
    height: 322px;
    width: 541px;
}
 .gm-style-iw
 {
 	color:#000000;
 }
</style>		
<!-- <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> -->
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>

<?php $theme_url = $urls= base_url().getThemeName();?>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/rating.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/image_script.js"></script>
<script type="text/javascript" src="<?php echo $theme_url; ?>/js/jquery_form.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/js/rating.css" />
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script>
	$(document).ready(function() {
    // Configure/customize these variables.
    var showChar = 600;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more";
    var lesstext = "Show less";
    
    $('.more').each(function() {
        var content = $(this).html();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink more pull-right"><i class="strip arrow_down"></i>' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
 
    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
            $(".morelink").html("<i class='strip arrow_down more'></i>View More..");
        } else {
            $(this).addClass("less");
            $(this).html("<i class='strip arrow_up more'></i>View Less..");
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
});
</script>

<script type="text/javascript">
$('#comment_title').live('click', function(e){
    e.preventDefault();
 });
   $(document).ready(function()
   {
	  initialize_map();
	  $('#menu').click(function() {
		   $('.profile_menu').slideToggle("slow");
	  });
		        
	  // $('#comment_title').click(function() 
	  // {
			// var uid = '<?php echo $this->session->userdata("user_id"); ?>';
			// if(uid!="")
			// {
				// $('.profile_menu').slideDown("slow");
			// }
			// else
			// {
				// window.location.href='<?php echo site_url("home/login"); ?>';
			// }
	  // });
	  
	  $('.sp_reply').live('click',function() 
	  {
			var uid = '<?php echo $this->session->userdata("user_id"); ?>';
			if(uid!="")
			{
				var pr = $(this).parent();
		        $('.post_block1',pr).slideDown("slow");
			}
			else
			{
				window.location.href='<?php echo site_url("home/login"); ?>';
			}
	 });
  });
</script>

<script type="text/javascript">
	 $(document).ready(function () 
	 {
		$('#star1').rating('www.url.php', {maxvalue:5});
		$(".cancel").hide();
	 });
</script>

<script language="javascript" type="text/javascript">
	function limitText(limitField, limitCount, limitNum) 
	{
			$("#paste_cont").html(limitField.value);
	}

	function gettitle(val)
	{
		$("#title").html(val);
	}
</script>
<input type="hidden" name="sess_id" id="sess_id" value="<?php echo check_user_authentication()==""? '0':'1';?>" />

<!-- ########################################################################################### -->
    <div class="wrapper row4">
   		<div class="container clearfix">
   			<div id="slider-fixed-banner" class="carousel slide">
	        	<div class="carousel-inner">
		          	<div class="active item">
		            	<img src="<?php echo base_url().'default'?>/images/smallbanner1.png" alt="American Dive Bars"/>
		          	</div>
	            </div>
   	  		</div>
       </div>
   </div>
       <div class="wrapper row5">
     	<div class="container">
     		<div class="result_search">
     			<div class="pull-left">
	     			<div class="result_search_text">Dive Bar Details</div>
	            </div>
     			<div class="pull-right">
     				<div class="result_search_text pull-left marr_10">Full Mug Bar</div>
     				<div class="pull-right"><i class="strip fullmug"></i></div>
     				<div class="clearfix"></div>
	             </div>
	             <div class="clearfix"></div>
     		</div>
     		<div class="br_bott_yellow">
     			<div class="bar_details">
     				<div class="media">
						    <a class="pull-left widheig120" href="#">
						      	<img src="<?php echo base_url().'default'?>/images/120x120_img.png" />
						    </a>
						    <div class="media-body">
						       <div class="reult_sub_title"><h4 class="media-heading"><a href="" class="bar_title"><?php echo ucwords(@$bar_detail['bar_title']); ?></a></h4></div>
						       <!-- <div class="rating_box"><a href="#"><img src="images/rating.png"/></a></div> -->
						       <div class="clearfix"></div>
						       <div class="result_desc more">
						       	   <?php echo @strip_tags($bar_detail['bar_desc']);?>
						       </div> 
						        <div class="mar_top20">
						        	<p class="bar_add">URL :<a href="<?php echo @$bar_detail['website'];?>" class="bar_title">  <?php echo @$bar_detail['website'];?></a></p>
						        	<p class="bar_add"><?php echo @$bar_detail['address'].", ".@$bar_detail['city'].", ".@$bar_detail['zipcode'].", ".@$bar_detail['state'];?></p>
						        	<div>
						        		<div class="bar_phone pull-left"><?php echo @$bar_detail['phone'];?></div>
						        		<ul class="social_icon pull-right">
						    		 		<li><a href="#"><img src="<?php echo base_url().'default'?>/images/result_fb.png"</a></li>
						    		 		<li><a href="#"><img src="<?php echo base_url().'default'?>/images/result_twitt.png"</a></li>
						    		 		<li><a href="#"><img src="<?php echo base_url().'default'?>/images/result_linkln.png"</a></li>
						    		 		<li><a href="#"><img src="<?php echo base_url().'default'?>/images/result_google.png"</a></li>
						    		 		<li><a href="#"><img src="<?php echo base_url().'default'?>/images/result_p.png"/></a></li>
						    		 		<li><a href="#"><img src="<?php echo base_url().'default'?>/images/result_circle.png"</a></li>
						    		 		<li><a href="#"><img src="<?php echo base_url().'default'?>/images/result_dot.png"</a></li>
		    		 					</ul>
		    		 					<div class="clearfix"></div>
						        	</div>
						         </div>
						         <div>
						         	<div class="pull-left">
						         		<a href="#" class="pull-left mar_right20"><img src="<?php echo base_url().'default'?>/images/rating.png"/></a>
						         		<a  class="pull-left more" onclick="show_popup()">Write a Review</a>
						         		<div class="clearfix"></div>
						         	</div>
		    		 				<div class="clearfix"></div>
						       </div>
						    </div>
				    	</div>
				    	<div class="clearfix"></div>
     			</div>
     			<div class="right_gallery_block">
     				<div><img src="<?php echo base_url().'default'?>/images/1.jpg" class="br_green_yellow gallery_img"/></div>
     				<div class="mar_top20 text-center">
	     				<ul class="galleryimg">
	     					<a href="#" class="pull-left marr_10"><img src="<?php echo base_url().'default'?>/images/previous.png"/></a>
	     					<li class="active"><a href="#"><img src="<?php echo base_url().'default'?>/images/thumbs/1.jpg" class="thumb_img"/></a></li>
	     					<li><a href="#"><img src="<?php echo base_url().'default'?>/images/thumbs/1.jpg" class="thumb_img"/></a></li>
	     					<li><a href="#"><img src="<?php echo base_url().'default'?>/images/thumbs/1.jpg" class="thumb_img"/></a></li>
	     					<li><a href="#"><img src="<?php echo base_url().'default'?>/images/thumbs/1.jpg" class="thumb_img"/></a></li>
	     					<li><a href="#"><img src="<?php echo base_url().'default'?>/images/thumbs/1.jpg" class="thumb_img"/></a></li>
	     					<a href="#" class="pull-left"><img src="<?php echo base_url().'default'?>/images/next.png"/></a>
	     					<div class="clearfix"></div>
	     				</ul>
     				</div>
     			</div>
     			<div class="clearfix"></div>
     		</div>
     		
     		<div class="fullmug_block">
     			<div class="col-md-4 col-sm-5 padb20">
     				<div class="bar_bg">
     					<h1 class="box_title">Bar Events</h1>
     					<ul class="bottom_box">
	         			<li>
	         				<div class="fourm_label"><a href="#" class="newsyellow">Lorem ipsum dolor sit amet</a></div>
	         				<div class="result_desc">ipsum dolor sit amet, con sectetur elit.ipsum dolor sit amet, con sectetur elit</div>
	         				<p class="datelabel">13/08/2013</p>
	         			</li>
	         			<hr>
	         			<li>
	         				<div class="fourm_label"><a href="#" class="newsyellow">Lorem ipsum dolor sit amet</a></div>
	         				<div class="result_desc">ipsum dolor sit amet, con sectetur elit.</div>
	         				<p class="datelabel">13/08/2013</p>
	         			</li>
	         			<hr>
	         			<li>
	         				<div class="fourm_label"><a href="#" class="newsyellow">Lorem ipsum dolor sit amet</a></div>
	         				<div class="result_desc">ipsum dolor sit amet, con sectetur elit.</div>
	         				<p class="datelabel">13/08/2013</p>
	         				<a href="#" class="pull-right more">View More</a>
	         				<div class="clearfix"></div>
	         			</li>
	         		</ul>
     				</div>
     			</div>
     			
     			<div class="col-md-4 col-sm-5 padb20">
     				<div class="bar_bg">
     					<h1 class="box_title">Beers Served at Bar</h1>
     					<ul class="bottom_box">
	         			<li>
	         				<div class="fourm_label"><a href="#" class="newsyellow">Lorem ipsum dolor sit amet</a></div>
	         			</li>
	         			<hr>
	         			<li>
	         				<div class="fourm_label"><a href="#" class="newsyellow">Lorem ipsum dolor sit amet</a></div>
	         			</li>
	         			<hr>
	         			<li>
	         				<div class="fourm_label"><a href="#" class="newsyellow">Lorem ipsum dolor sit amet</a></div>
	         			</li>
	         			<hr>
	         			<li>
	         				<div class="fourm_label"><a href="#" class="newsyellow">Lorem ipsum dolor sit amet</a></div>
	         			</li>
	         			<hr>
	         			<li>
	         				<div class="fourm_label"><a href="#" class="newsyellow">Lorem ipsum dolor sit amet</a></div>
	         			</li>
	         			<hr>
	         			<li>
	         				<div class="fourm_label"><a href="#" class="newsyellow">Lorem ipsum dolor sit amet</a></div>
	         				<a href="#" class="pull-right more">View More</a>
	         				<div class="clearfix"></div>
	         			</li>
	         		</ul>
     				</div>
     			</div>
     			<div class="col-md-4 col-sm-5 padb20">
     				<div class="bar_bg">
     					<h1 class="box_title">Cocktails Served at Bar</h1>
     					<ul class="bottom_box">
	         			<li>
	         				<div class="fourm_label"><a href="#" class="newsyellow">Lorem ipsum dolor sit amet</a></div>
	         			</li>
	         			<hr>
	         			<li>
	         				<div class="fourm_label"><a href="#" class="newsyellow">Lorem ipsum dolor sit amet</a></div>
	         			</li>
	         			<hr>
	         			<li>
	         				<div class="fourm_label"><a href="#" class="newsyellow">Lorem ipsum dolor sit amet</a></div>
	         			</li>
	         			<hr>
	         			<li>
	         				<div class="fourm_label"><a href="#" class="newsyellow">Lorem ipsum dolor sit amet</a></div>
	         			</li>
	         			<hr>
	         			<li>
	         				<div class="fourm_label"><a href="#" class="newsyellow">Lorem ipsum dolor sit amet</a></div>
	         			</li>
	         			
	         			<hr>
	         			<li>
	         				<div class="fourm_label"><a href="#" class="newsyellow">Lorem ipsum dolor sit amet</a></div>
	         				<a href="#" class="pull-right more">View More</a>
	         				<div class="clearfix"></div>
	         			</li>
	         			
	         		</ul>
     				</div>
     			</div>
     			<div class="clearfix"></div>
     		</div>
     		<div>
     			<div class="review_mainblock marr4 padt10">
     				<h1 class="br_bott_gray"><div class="review">Directions</div>
     					<a href="javascript://" class="white pull-right review" onclick="loadMap()">Search Direction</a>
     				</h1>
		     			
		     			<div class="br_map mar_top20">
		     				<!-- <img src="<?php echo base_url().'default'?>/images/map.png" class="map_img"/> -->
		     				<div class="portlet-body">
								<div id="gmap_marker" class="map_img"></div>
							</div>
		     			</div>
     			</div>
     			<div class="review_mainblock">
     				<div class="products_block">
     					<h1 class="br_bott_gray"><div class="review">View Products</div></h1>
	     				<div class="products marr_10 mar_top20">
	     					<a href="#">
	     						<img src="<?php echo base_url().'default'?>/images/tshirt.png" class="prodt_img"/>
	     						<div class="prod">
	     							<div class="pull-left">
	     								<h1 class="prodct">T-shirt <span class="marl_10">24.29</span></h1>
	     								<!-- <p>$24.29</p> -->
	     							</div>
	     							<div class="pull-right">
	     								<img src="images/cart.png"/>
	     							</div>
	     							<div class="clearfix"></div>
	     						</div>
	     					</a>
	     				</div>
	     				<div class="products marr_10 mar_top20">
	     					<a href="#">
	     						<img src="<?php echo base_url().'default'?>/images/tshirt.png" class="prodt_img"/>
	     						<div class="prod">
	     							<div class="pull-left">
	     								<h1 class="prodct">T-shirt <span class="marl_10">24.29</span></h1>
	     								<!-- <p>$24.29</p> -->
	     							</div>
	     							<div class="pull-right">
	     								<img src="images/cart.png"/>
	     							</div>
	     							<div class="clearfix"></div>
	     						</div>
	     					</a>
	     				</div>
	     				<div class="clearfix"></div>
	     			</div>
     			</div>
     			<div class="clearfix"></div>
     		</div>
     		<div class="padt10">
     			<div class="review_mainblock marr4 padt10">
     				<h1 class="br_bott_gray"><div class="review">Send A Bar A Real Post Card</div>
     				</h1>
     				<div class="error hide1 center" id="cm-err-main1">&nbsp;</div>
					<form name="add_post" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('bar/post_card_send/'.base64_encode($bar_id))?>">		
     					<div class="pull-left marr_10"> 
     						<div class="checkbox">
	     						 <label>
	          							<input type="radio" name="sel_title" onclick="gettitle(this.value)" value="Your Bar is Awesome" checked> Your Bar is Awesome !
	        					</label>
        					</div>
     					</div>
     					<div class="pull-left"> 
     						<div class="checkbox">
	     						 <label>
	          							<input type="radio" name="sel_title" onclick="gettitle(this.value)" value="Your Bar is Sucks"> Your Bar Sucks!
	        					</label>
        					</div>
     					</div>
     					<div class="clearfix"></div>
 
     					<textarea name="desc_post_card"  onKeyDown="limitText(this.form.desc_post_card,this.form.countdown,300);" 
onKeyUp="limitText(this.form.desc_post_card,this.form.countdown,300);" id="desc_post_card" class="form-control form-pad mart10" rows="3" placeholder="Write Here"></textarea>
     					
     					
     					<!-- <div class="padtb10 pull-right">
							<font size="1">(Maximum characters: 300)<br>
							You have <input readonly type="text" name="countdown" id="countdown" size="3" value="300"> characters left.</font>
     					</div> -->
     					<div class="clearfix"></div>
     					<div class="post_card_block mar_top15">
	     					<div class="post_left br_r">
	     						<h1 class="post_label padb10">Dear Bar Owner,</h1>
	     						<div class="result_desc padb10" >I recently Visited your Bar And I have Concluded: <div id="paste_cont" class="sp_tag"></div>  </div>
	     						 <label id="title">
	                                    Your Bar is Awesome          							
	        					</label>
	        					<!-- <div class="mar_top20">
	        						<a href="#" class="btn btn-lg btn-primary">Upload Image</a>
	        					</div> -->
	        					<div id="upload">
                            		<input type="file" name="file" id="file"/>
                        		</div>
                        		
                        		<div class="stamp_image" id="preview" style="padding: 0;">
	     							<img id="previewimg" src="" height="100" width="95"/>
	     						</div>
	     					</div>
	     					<div class="post_left">
	     						<img src="images/post.png" class="pull-left"/>
	     					
	     						<div class="stamp" >
	     							Place Stamp Here
	     							<img id="previewimg" src="" height="100" width="95"/>
	     						</div>
	     						<div class="clearfix"></div>
	     						<div class="post_add">
	     							<?php echo $bar_detail['address']." ".$bar_detail['city']." ".$bar_detail['zipcode']." ".$bar_detail['state'];?>
	     						</div>
	     						
	     					</div>
	     					<div class="clearfix"></div>
	     				</div>
	     				<div class="pull-right padtb10">
	     							<input type="submit" name="send" id="send" onclick="checkauth()" value="Send a Post Card" class="btn btn-lg btn-primary" />
	     						</div>
	     				
	     				</form>
	     				
     				</div>
					<div class="modal fade login_pop2" id="loginmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
					   <?php echo $this->load->view($theme.'/home/login_ajax');?>
					</div>	

					<div class="modal fade login_pop2" id="mapmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
					   <?php echo $this->load->view($theme.'/home/map');?>
					</div>	


<div class="modal fade login_pop2" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	<div class="wrapper row6 padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Write a Review</div>
     				</div>
     				<div class="pad20">
     						<div id="ajax_msg_error_reg"></div>
     						<div class="error hide1" id="cm-err-main" style="text-align: center;">&nbsp;</div>
     						<form name="frm_add_review" id="frm_add_review" method="post" class="form-horizontal" action="<?php echo site_url("bar/add_bar_comment"); ?>">
     						<div class="error hide1 center" id="cm-err-main">&nbsp;</div>
     							<input type="hidden" name="bar_id" id="bar_id" value="<?php echo $bar_id;?>" />
     						<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Review Title :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="comment_title" name="comment_title" >
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Review Description :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		 <textarea name="comment" id="comment" class="form-control form-pad" ></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Rating :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		 <div id="star1" class="rating">&nbsp;<input type="hidden" name="rating" id="rating" value="" /></div>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	 <div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10">
									<button class="btn btn-lg btn-primary" type="submit">Post</button>									
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	</form>	
     				</div>		
     			</div>
     		</div>
     	</div>
     </div>	
</div>
     			<div class="review_mainblock padt10">
     				<h1 class="br_bott_gray"><div class="review">Review</div> <div class="pull-right review"><a href="javascript://" onclick="show_popup()" >Write a Review</a></div>
     				</h1>
     				<input type="hidden" name="offset" id="offset" value="<?php echo ($offset!='')?$offset:0; ?>" />
					<input type="hidden" name="limit" id="limit" value="<?php echo ($limit>0)?$limit:2; ?>" />
	     			<div id="responsecomment">
	     			<ul class="review_block" >
	     				<?php if($result){
	     					  foreach($result as $comment){?>
		     				<li>
		     					<div class="reult_sub_title"><a class="bar_title"><?php echo $comment->comment_title; ?></a></div>
		     					<div class="rating_box"><a class="bar_title"><?php echo getDuration($comment->date_added); ?></a></div>
		     					<div class="clearfix"></div>
		     					<p class="result_desc"><?php echo $comment->comment;?></p>
		     					<div class="reult_sub_title"><p class="review_light pull-left"><?php echo $comment->first_name." ".$comment->last_name;?></p></div>
		     					<div class="rating_box starrating<?php echo $comment->bar_rating; ?>"><a href="javascript"></a></div>
		     					<div class="clearfix"></div>
		     				</li>
	     				<?php } }?>	  	
	     			</ul>
	     			
	     			<div class="pagination">
	     				<?php echo $page_link;?>
     				</div>
     				<div class="clearfix"></div>
     			</div>
     		</div>
     		<div class="clearfix"></div>
     		</div>
     		
     		
     		<div class="padtb10">
     			<div class="review_mainblock marr4">
     					<h1 class="br_bott_gray"><div class="review">Video</div>
     				</h1>
     				<div class="mar_top20 pos_rel">
	     				<img src="<?php echo base_url().'default'?>/images/video1.png" class="gallery_img"/>
	     				<a href="#"><i class="strip play"></i></a>
	     			</div>
     			</div>
     			
     			<div class="review_mainblock">
     					<h1 class="br_bott_gray"><div class="review">Contact</div>
     				</h1>
	     				<form class="form-horizontal mar_top20" role="form" name="contact" id="contact" method="post" action="<?php echo site_url('bar/contact_bar_owner/'.base64_encode($bar_id))?>">
	     					<div class="error hide1 center" id="cm-err-main_contact">&nbsp;</div>
                   <div class="form-group">
                       <label for="inputEmail3" class="col-sm-3 control-label">Name :</label>
                       <div class="col-sm-8 input_box">
                           <input type="text" class="form-control form-pad" name="name" id="name" placeholder="Name">
                       </div>
                       <div class="clearfix"></div>
                   </div>
                   <div class="form-group">
                       <label for="inputEmail3" class="col-sm-3 control-label">Phone :</label>
                       <div class="col-sm-8 input_box">
                           <input type="text" class="form-control form-pad" id="phone" name="phone" placeholder="Phone">
                       </div>
                       <div class="clearfix"></div>
                   </div>
                    <div class="form-group">
                       <label for="inputEmail3" class="col-sm-3 control-label">Email :</label>
                       <div class="col-sm-8 input_box">
                           <input type="text" class="form-control form-pad" name="email_new" id="email_new" placeholder="Email">
                       </div>
                       <div class="clearfix"></div>
                   </div>
                   <div class="form-group">
                       <label for="inputEmail3" class="col-sm-3 control-label">Query :</label>
                       <div class="col-sm-8 input_box">
                           <!-- <input type="text" class="form-control form-pad" id="inputEmail3" placeholder="State"> -->
                           <textarea class="form-control form-pad" name="desc" id="desc"  placeholder="Type Your Query Here" rows="5"></textarea>
                       </div>
                       <div class="clearfix"></div>
                   </div>
                   <div class="col-sm-8 pull-right mar_top20">
                   	    <input type="submit" name="sub" id="sub" value="Submit" class="btn btn-lg btn-primary pull-left marr_10" />
                  		<div class="clearfix"></div>
                  </div>
                  <div class="clearfix"></div>		
             
              </form>
     			</div>
     			<div class="clearfix"></div>
     		</div>
   		</div>
   	</div>

           
<script type="text/javascript">

	 var autocomplete = new google.maps.places.Autocomplete($("#start")[0], {});

            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();
                console.log(place.address_components);
     });
            	
	function show_popup()
	{
		$(".star").removeClass("on");
		$("#postcard").val(0);
		$('#dvLoading').fadeIn('slow')
		setTimeout(function () 
		{
			$('#dvLoading').fadeOut('slow')
		}, 500);
		
		if($('#sess_id').val()==1)
		{
			$('#myModal1').modal('show');
		}
		else
		{
			$('#loginmodal').modal('show');
		}
	} 
    
    
		$('document').ready(function()
		{
		$('#form').validate(
		{
		rules: {
					file: {
						required: true,
					},
					desc_post_card: {
						required: true,
					},
						errorClass:'error fl_right'
				},
		submitHandler: function(form){
		$(form).ajaxSubmit({
		type: "POST",
		   		 dataType : 'json',
				 beforeSubmit: function() 
				 {
		        	$("#form").validate(
		        	{
					     rules: {
						   desc_post_card: {required: true},
					   	 }		  
		            });	   
		       		$('#dvLoading').fadeIn('slow');
		    	 },
		    	
		    	uploadProgress: function ( event, position, total, percentComplete ) {	
		        },
		    
		    	success : function ( json ) 
		    	{
					if(json.status == "fail")
					{
						$("#cm-err-main1").show();
						$("#cm-err-main1").html(json.comment_error);
			    		$('#dvLoading').fadeOut('slow')
				  		setTimeout(function () 
						{
						      $("#cm-err-main").fadeOut('slow');
						}, 3000);
					return false;
					}
			
					else
					{
						$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
						$("#desc_post_card").val("");
						$("#countdown").val(300);
						$("#paste_cont").empty();
						$("#preview").empty();
						$.growlUI('Your post card send successfully .');
					}
		     
					$('#dvLoading').fadeOut('slow');
					$('.profile_menu').fadeOut('slow');
								  
		   		 }
		    });
		  }
		})
	  });
    
    
    
    jQuery(document).ready(function() 
    {  
	$("#add_post").validate({
		rules: {
			file: {
				required: true,
			},
			desc_post_card: {
				required: true,
			},
				errorClass:'error fl_right'
		},
		});
		
	});	
     
     $('#add_post').ajaxForm({
		 type: "POST",
   		 dataType : 'json',
		 beforeSubmit: function() 
		 {
        	$("#frm_add_review").validate(
        	{
			     rules: {
				   desc_post_card: {required: true},
			   	 }		  
            });	   
       		$('#dvLoading').fadeIn('slow');
    	 },
    	
    	uploadProgress: function ( event, position, total, percentComplete ) {	
        },
    
    	success : function ( json ) 
    	{
			if(json.status == "fail")
			{
				$("#cm-err-main1").show();
				$("#cm-err-main1").html(json.comment_error);
	    		$('#dvLoading').fadeOut('slow')
		  		setTimeout(function () 
				{
				      $("#cm-err-main").fadeOut('slow');
				}, 3000);
			return false;
			}
	
			else
			{
				$("#cm-err-main1").hide();
				$("#cm-err-main1").html("");
				$("#desc_post_card").val("");
				$("#countdown").val(300);
				$("#paste_cont").empty();
				$.growlUI('Your post card send successfully .');
			}
     
			$('#dvLoading').fadeOut('slow');
			$('.profile_menu').fadeOut('slow');
						  
   		 }
      });

     $('#contact').ajaxForm(
     {
	 	type: "POST",
     	dataType : 'json',
		beforeSubmit: function() 
		{
       		$('#dvLoading').fadeIn('slow');
    	},
    	uploadProgress: function ( event, position, total, percentComplete ) { 	},
    	success : function ( json ) 
    	{
			if(json.status == "fail")
			{
				$("#cm-err-main_contact").show();
				$("#cm-err-main_contact").html(json.comment_error);
			    $('#dvLoading').fadeOut('slow')
				  setTimeout(function () 
						 {
						      $("#cm-err-main_contact").fadeOut('slow');
						}, 3000);
				return false;
			}
			
			else
			{
				$("#cm-err-main_contact").hide();
				$("#name").val("");
				$("#phone").val("");
				$("#email_new").val("");
				$("#desc").val("");
				$.growlUI('<?php echo "Your Inquiry send successfully to bar owner ."; ?>');
			}
			$('#dvLoading').fadeOut('slow');
			$('.profile_menu').fadeOut('slow');
   		 }
	 });
	
	 $('#frm_add_review').ajaxForm(
	 {
	 	type: "POST",
    	dataType : 'json',
		beforeSubmit: function() 
		{
        	$("#frm_add_review").validate(
        	{
		   	rules: 
		   	{
			   comment_title: {required: true},
               comment: {required: true},
               rating: {required: true}	  
		   	}		  
       		});	   
       		$('#dvLoading').fadeIn('slow');
   		 },
   
    	 uploadProgress: function ( event, position, total, percentComplete ) { },
    	  
    	 success : function ( json ) 
    	 {
			if(json.status == "fail")
			{
				$("#cm-err-main").show();
				$("#cm-err-main").html(json.comment_error);
			    $('#dvLoading').fadeOut('slow')
				  setTimeout(function () 
						 {
						      $("#cm-err-main").fadeOut('slow');
						}, 3000);
				return false;
			}
			
			else
			{
				$("#cm-err-main").hide();
				$("#comment_title").val("");
				$("#comment").val("");
				$("#rating").val("");
				$("#desc_post_card").val("");
				$("#cm-err-main").html("");
					$.growlUI('<?php echo "Your Review add successfully ."; ?>');
			}
			var data = '';
			data += '<li>';
			data +='<div class="reult_sub_title "><a class="bar_title">'+json.comment_title+'</a></div>';
			data +='<div class="rating_box">'+ json.date_duration +'</div><div class="clearfix"></div>';
			data +='<p class="result_desc">'+json.comment+'</p>';
			data +='<div class="reult_sub_title"><p class="review_light pull-left">'+json.first_name+' '+ json.last_name +'</p></div>';
			data +='<div class="rating_box starrating'+json.bar_rating+'"><a href="javascript://"></a></div><div class="clearfix"></div></li>';
			$('.review_block').prepend(data);
			$('#test').val(json.testdd);
			$('#myModal1').modal('hide');
	     
	        $(':input','#add-comment')
			  .not(':button, :submit, :reset, :hidden')
			  .val('')
			  .removeAttr('checked')
			  .removeAttr('selected');
			   $('#dvLoading').fadeOut('slow');
			   $('.profile_menu').fadeOut('slow');
	    	}
		});

function checkauth()
{
	$("#postcard").val(1);
	if($("#sess_id").val()==0)
	{
		$('#loginmodal').modal('show');
	}
	
}

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
			       $("#show_loader").show();
			   },
			   complete: function(){
			       $("#show_loader").hide();
			    }
			}).responseText;	
			$("#responsecomment").html(res);
			
			return false;
			
		});
		
	var directionDisplay;
	var directionsService = new google.maps.DirectionsService();
	var map;
		
	function initialize() {
	var address ="<?php echo @$bar_detail['address']." ".@$bar_detail['city']." ".@$bar_detail['zipcode']." ".@$bar_detail['state'];?>";
			directionsDisplay = new google.maps.DirectionsRenderer();
			var melbourne = new google.maps.LatLng(-37.813187, 144.96298);
			var myOptions = {
				zoom:12,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				center: melbourne
			}

			map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
			if (geocoder) {
      		geocoder.geocode( { 'address': address}, function(results, status) {
	        if (status == google.maps.GeocoderStatus.OK) {
	          if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
	          map.setCenter(results[0].geometry.location);
	
	            var infowindow = new google.maps.InfoWindow(
	                { content: '<b>'+address+'</b>',
	                  size: new google.maps.Size(150,50)
	                });
	
	            var marker = new google.maps.Marker({
	                position: results[0].geometry.location,
	                map: map, 
	                title:address
	            }); 
	            google.maps.event.addListener(marker, 'click', function() {
	                infowindow.open(map,marker);
	            });
	
	          } 
	         }
          });
        }
		google.maps.event.trigger(map, 'resize');
		directionsDisplay.setMap(map);
	}
	
function loadMap()
{
	 $("#start").val("");
	 $("#cm-err-main-map").empty("");
     $("#mapmodal").modal('show');
     setTimeout(function() {
       initialize();
	}, 200);
}	

</script>

<script type="text/javascript">
  var geocoder;
  var map;
  var address ="<?php echo @$bar_detail['address']." ".@$bar_detail['city']." ".@$bar_detail['zipcode']." ".@$bar_detail['state'];?>";
  function initialize_map() 
  {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var myOptions = {
      zoom: 8,
      center: latlng,
    mapTypeControl: true,
    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
    navigationControl: true,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("gmap_marker"), myOptions);
    if (geocoder) {
      geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
          map.setCenter(results[0].geometry.location);

            var infowindow = new google.maps.InfoWindow(
                { content: '<b>'+address+'</b>',
                  size: new google.maps.Size(150,50)
                });

            var marker = new google.maps.Marker({
                position: results[0].geometry.location,
                map: map, 
                title:address
            }); 
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map,marker);
            });

          } 
         }
      });
    }
  }
</script>

