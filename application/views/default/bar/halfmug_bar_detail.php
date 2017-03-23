<?php
		          		if($bar_detail['bar_logo']!="" && file_exists(base_path().'upload/barlogo_thumb/'.@$bar_detail['bar_logo']))
					{?>
		            	<?php $img =  base_url().'/upload/barlogo_thumb/'.$bar_detail['bar_logo']; ?>
		            	<?php }  else { ?>
		            		<?php $img =  base_url().'upload/barlogo/no_image.png'; ?>
		            		<?php } ?>
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
    width: 100%;
}
 .gm-style-iw
 {
 	color:#000000;
 }
</style>		
<!-- <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> -->


<?php $theme_url = $urls= base_url().getThemeName();?>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/rating.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/image_script.js"></script>
<script type="text/javascript" src="<?php echo $theme_url; ?>/js/jquery_form.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/js/rating.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/css/jquery.bxslider.css" />
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>

<script>
	$(document).ready(function() {
		
		 $('#total-fav').click(function(){
  	<?php if($this->session->userdata('user_type')=='taxi_owner'){?>
  	    	  $.growlUI('<?php echo NO_RIGHT; ?>');
  	    	   $(".growlUI strong").empty();
  	    	  return false;
  	    <?php } ?> 
		var flag = this.name;
		var bid = '<?php echo $bar_detail["bar_id"]; ?>';
		var uid = '<?php echo get_authenticateUserID(); ?>';
		
		// if(uid=="")
		// {
			// //window.location.href='<?php //echo site_url("beer/beer_likes/".$beer_detail["beer_id"]); ?>';
			// //return false;
		// }
		
	//	alert($('#sess_id').val())
		if($('#sess_id').val()==0)
		{
			<?php $this->session->set_userdata("REDIRECT_PAGE","bar/details/".$bar_detail["bar_slug"]); ?>
			$('#loginmodal').modal('show');
			return false;
		}
		
		$.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>bar/bar_fav",         //the script to call to get data          
        data: {bar_id: bid, user_id: uid, fav_flag:flag},
	    dataType: '',                //data format      
        success: function(data)          //on receive of reply		
            {  
			var main = data.split('*');
			   if(main[0]==1){
				  $('#total-fav').attr('name','0');
				   $('#total-fav').html('Remove Favorite');
				   $( "#total-fav" ).addClass( "active" );
			   }
			   else{
				  $('#total-fav').attr('name','1');
				   $('#total-fav').html('Add to My Bar List');
				   $( "#total-fav" ).removeClass( "active" );
				}
		    } 
		
        });
	});
	$("#preview").hide();
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
         $("#myModalnew_open").modal('show');
    });
    // $(".morelink").click(function(){
        // if($(this).hasClass("less")) {
            // $(this).removeClass("less");
            // $(this).html(moretext);
            // $(".morelink").html("<i class='strip arrow_down more'></i>View More..");
        // } else {
            // $(this).addClass("less");
            // $(this).html("<i class='strip arrow_up more'></i>View Less..");
        // }
        // $(this).parent().prev().toggle();
        // $(this).prev().toggle();
        // return false;
    // });
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
		content = document.getElementById('desc_post_card').value.replace(/\n/g, '<br>');
  document.getElementById('paste_cont').innerHTML = content; 

		
			//$("#paste_cont").html(limitField.value);
	}

	function gettitle(val)
	{
		$("#title").html(val+'!');
	}
	
	
function fbShare(){
	window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('<?php echo site_url('bar/details/'.$bar_detail['bar_slug']); ?>'),'facebook-share-dialog','width=626,height=436');
            return false;
}

function twShare()
{
	var width  = 575,
        height = 400,
        left   = ($(window).width()  - width)  / 2,
        top    = ($(window).height() - height) / 2,
        url    = 'http://twitter.com/share?url=<?php echo site_url('bar/details/'.$bar_detail['bar_slug']); ?>',
        opts   = 'status=1' +
                 ',width='  + width  +
                 ',height=' + height +
                 ',top='    + top    +
                 ',left='   + left;
    
    window.open(url, 'twitter', opts);
 
    return false;
}
function gPlusShare1(url,name)
    		{
		var w=480;var h=380;
		var x=Number((window.screen.width-w)/2);
		var y=Number((window.screen.height-h)/2);
		window.open('https://plus.google.com/share?url='+encodeURIComponent(url)+'&title='+encodeURIComponent(name),'','width='+w+',height='+h+',left='+x+',top='+y+',scrollbars=no');
		  
    	}
    	
    	
function piShare()
{
	var width  = 600,
        height = 500,
         left   = ($(window).width()  - width)  / 2,
         top    = ($(window).height() - height) / 2,
        url    = 'http://www.pinterest.com/pin/create/button/?url=<?php echo site_url('bar/details/'.$bar_detail['bar_slug']); ?>&media=<?php echo $img; ?>&description=<?php //echo $bar_detail['bar_desc']; ?>',
        opts   = 'status=1' +
                 ',width='  + width  +
                 ',height=' + height +
                 ',top='    + top    +
                 ',left='   + left;
    
    window.open(url, 'Pinterest', opts);
 
    return false;
}
</script>
<input type="hidden" name="sess_id" id="sess_id" value="<?php echo check_user_authentication()==""? '0':'1';?>" />
<input type="hidden" name="beerval" id="beerval" value="0" />
<input type="hidden" name="cocktailval" id="cocktailval" value="0" />
<input type="hidden" name="liquorval" id="liquorval" value="0" />

<!-- ########################################################################################### -->
    
    <div class="wrapper row5">
      <div class="container">
      	<div class="full_mug">
     		<div class="result_search">
     			<div class="pull-left">
                                    <div class="result_search_text"><?php echo "Welcome to " .$bar_detail['bar_title'];?>
                                        <b style="padding-left:1em;"></b>
                                        <img src ="<?php echo base_url().'default';?>/images/Team_icon_-_noun_project_20586.svg.png" style="max-width: 5%;max-height: 5%;">
                                <b style="color:black;font-weight: normal;font-size:14px;"><?php echo ($bar_detail['followers'] + count($bar_liker))." Followers";?></b>
                            </div>
	            </div>
     			<div class="pull-right">
     				<div class="result_search_text full-icon marr_10"><?php if($bar_detail['claim']=='unclaimed'  && get_authenticateUserID()==''){?>
                                    <a href="<?php echo site_url('home/claim_bar_owner_register/'.base64_encode('1V1').'/1V1/'.base64_encode($bar_detail['bar_id']));?>" style="background-color: #4CAF50;" class="review text-center"><b>Register This Bar</b></a>
						        	<?php } ?>Half Mug Bar</div>
     				<div class="full-icon"><i class="strip halfmug"></i></div>
                                
	             </div>
	             <div class="clearfix"></div>
     		</div>
     		<div class="br_bott_yellow">
     			<div class="bar_details">
     				<div class="media">
						    <div class="pull-left left-img">
						    <a class="widheig120 mar_bot10" href="#">
						      	<?php
		          		if($bar_detail['bar_logo']!="" && file_exists(base_path().'upload/barlogo_thumb/'.@$bar_detail['bar_logo']))
					{?>
		            	<img src="<?php echo base_url()?>/upload/barlogo_thumb/<?php echo $bar_detail['bar_logo']; ?>" alt="American Dive Bars"/>
		            	<?php }  else { ?>
		            			<img style="width: 120px; height: 120px;" src="<?php echo base_url()?>/upload/barlogo/no_image.png" alt="American Dive Bars"/>
		            		<?php } ?>
						    </a><div class="clearfix"></div>

                                                
						    <!-- <?php $cnt_like = like_checker_bar($bar_detail['bar_id'],$this->session->userdata('user_id')); 
											
								if($cnt_like==2 && get_authenticateUserID()!=''){
								?>
								<a id="total-like" href="javascript:void(0);" name="2" class="btn mar_top15 btn-lg btn-primary">Like This Bar</i></a>
								<?php
											} elseif(get_authenticateUserID()!='') {?>
											<a id="total-like" href="javascript:void(0);" name="<?php if($cnt_like==1){ echo $cnt_like=0;} else{ echo $cnt_like=1; } ?>" class="btn mar_top15 btn-lg btn-primary">
											<?php if($cnt_like==1){ echo 'Like This Bar'; } else{ echo 'Already Liked'; } ?></i></a>
											<?php } else { ?> 
											<a id="total-like" href="javascript:void(0);" name="1" class="btn mar_top15 btn-lg btn-primary">
											Like This Bar</a>
								<?php  } ?> -->
								<!-- <a id="total-fav" href="javascript:void(0);" name="2" class="btn btn-lg btn-primary full-btn mart10">Add To Favoritess</a> -->
								
									<?php
                                                                        		if(($bar_detail['claim']=='unclaimed')  && get_authenticateUserID()==''){?>
                                                                <p></p>
                                                                <div>
                                    <a href="<?php echo site_url('home/claim_bar_owner_register/'.base64_encode('1V1').'/1V1/'.base64_encode($bar_detail['bar_id']));?>" style="background-color: #4CAF50;" class="review text-center"><b>Claim This Bar</b></a>
						        	 	</div><?php }
                                                                
						    		 if($this->session->userdata('user_type')!='bar_owner')
                                                                            {
						    		 $cnt_fav = fav_checker_bar($bar_detail['bar_id'],$this->session->userdata('user_id')); 
	
											if($cnt_fav==2 && get_authenticateUserID()!=''){
											?>
											<a id="total-fav" href="javascript:void(0);" name="2" class="btn btn-lg btn-primary full-btn mart10">Add to My Bar List</a>
											<?php
											} elseif(get_authenticateUserID()!=''){?>
                                                   
											<a id="total-fav" href="javascript:void(0);" name="<?php if($cnt_fav==1){ echo $cnt_fav=0;} else{ echo $cnt_fav=1; } ?>" class="btn btn-lg btn-primary full-btn mart10">
											 <?php if($cnt_fav==1){ echo 'Add to My Bar List'; } else{ echo 'Remove Favorite'; } ?></a>
											<?php } else { ?>
												<a id="total-fav" class="btn btn-lg btn-primary full-btn mart10" href="javascript:void(0);" name="1" >Add to My Bar List</a>
											<?php } }?>	
											<div class="clearfix"></div>
                                                                 
								<div class="rating-new mart10">
						         		<?php echo getReviewRating($bar_id);?>
						         		<div class="mart10"><a  class="btn btn-lg btn-primary full-btn mart10" onclick="show_popup()">Write a Review</a></div>
						         		<div class="clearfix"></div>
						         	</div>
						         	<div class="clearfix"></div>
						         <!-- <div>
						         	<ul class="social_icon pull-right">
						         		<?php if($bar_detail['facebook_link']!='' && $bar_detail['facebook_link']!='0'){?>
						    		 		<li><a href="<?php echo $bar_detail['facebook_link']; ?>" target="_blank" ><img src="<?php echo base_url().'default'?>/images/result_fb.png" /></a></li>
						    		 	<?php } ?>	
						    		 	<?php if($bar_detail['twitter_link']!='' && $bar_detail['twitter_link']!='0'){?>
						    		 		<li><a target="_blank" href="<?php echo $bar_detail['twitter_link']; ?>" ><img src="<?php echo base_url().'default'?>/images/result_twitt.png" /></a></li>
						    		 	<?php } ?>
						    		 	<?php if($bar_detail['linkedin_link']!='' && $bar_detail['linkedin_link']!='0'){?>	
						    		 		<li><a target="_blank" href="<?php echo $bar_detail['linkedin_link']; ?>"><img src="<?php echo base_url().'default'?>/images/result_linkln.png" /></a></li>
						    		 	<?php } ?>
						    		 	<?php if($bar_detail['google_plus_link']!='' && $bar_detail['google_plus_link']!='0'){?>	
						    		 		<li><a target="_blank" href="<?php echo $bar_detail['google_plus_link']; ?>" "><img src="<?php echo base_url().'default'?>/images/result_google.png" /></a></li>
						    		 	<?php } ?>
						    		 	<?php if($bar_detail['pinterest_link']!='' && $bar_detail['pinterest_link']!='0'){?>	
						    		 		<li><a target="_blank" href="<?php echo $bar_detail['pinterest_link']; ?>"><img src="<?php echo base_url().'default'?>/images/result_p.png" /></a></li>
						    		 	<?php } ?>
						    		 	<?php if($bar_detail['dribble_link']!='' && $bar_detail['dribble_link']!='0'){?>	
						    		 		<li><a target="_blank" href="<?php echo $bar_detail['dribble_link']; ?>"><img src="<?php echo base_url().'default'?>/images/result_circle.png" /></a></li>
						    		 	<?php } ?>	
		    		 					</ul>
		    		 				<div class="clearfix"></div>
		    		 			</div> -->
								</div>
						    <div class="media-body favourite_div favourite-box">
						         <div class="barnew-title"><h4 class="media-heading"><a href="" class="bar_title"><i class="strip fullmug"></i> <?php echo ucwords(@$bar_detail['bar_title']); ?></a></h4></div>
						       
						       <div class="taxi-right">	
						       <ul class="social_icon">
							         		<?php 
							         		
							         		
							         		if($bar_detail['facebook_link']!='' && $bar_detail['facebook_link']!='0'){?>
							    		 		<li><a href="<?php echo $bar_detail['facebook_link']; ?>" target="_blank" ><img src="<?php echo base_url().'default'?>/images/result_fb.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_fb-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_fb.png'" /></a></li>
							    		 	<?php } ?>	
							    		 	<?php if($bar_detail['twitter_link']!='' && $bar_detail['twitter_link']!='0'){?>
							    		 		<li><a target="_blank" href="<?php echo $bar_detail['twitter_link']; ?>" ><img src="<?php echo base_url().'default'?>/images/result_twitt.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_twitt-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_twitt.png'" /></a></li>
							    		 	<?php } ?>
							    		 	<?php if($bar_detail['linkedin_link']!='' && $bar_detail['linkedin_link']!='0'){?>	
							    		 		<li><a target="_blank" href="<?php echo $bar_detail['linkedin_link']; ?>"><img src="<?php echo base_url().'default'?>/images/result_linkln.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_linkln-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_linkln.png'" /></a></li>
							    		 	<?php } ?>
							    		 	<?php if($bar_detail['google_plus_link']!='' && $bar_detail['google_plus_link']!='0'){?>	
							    		 		<li><a target="_blank" href="<?php echo $bar_detail['google_plus_link']; ?>" "><img src="<?php echo base_url().'default'?>/images/result_google.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_google-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_google.png'" /></a></li>
							    		 	<?php } ?>
							    		 	<?php if($bar_detail['pinterest_link']!='' && $bar_detail['pinterest_link']!='0'){?>	
							    		 		<li><a target="_blank" href="<?php echo $bar_detail['pinterest_link']; ?>"><img src="<?php echo base_url().'default'?>/images/result_p.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_p-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_p.png'" /></a></li>
							    		 	<?php } ?>
							    		 	<?php if($bar_detail['dribble_link']!='' && $bar_detail['dribble_link']!='0'){?>	
							    		 		<li><a target="_blank" href="<?php echo $bar_detail['dribble_link']; ?>"><img src="<?php echo base_url().'default'?>/images/result_circle_white.png" onmouseover="this.src='<?php echo base_url();?>default/images/result_circle-hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/result_circle.png'" /></a></li>
							    		 	<?php } ?>	
							    		 	<?php if($bar_detail['instagram_link']!='' && $bar_detail['instagram_link']!='0'){?>	
							    		 		<li><a target="_blank" href="<?php echo $bar_detail['instagram_link']; ?>"><img src="<?php echo base_url().'default'?>/images/instagram2.png" onmouseover="this.src='<?php echo base_url();?>default/images/instagram2_hover.png'" onmouseout="this.src='<?php echo base_url();?>default/images/instagram2.png'" /></a></li>
							    		 	<?php } ?>	
							    		 	<div class="clearfix"></div>
		    		 					</ul>
		    		 				</div>	
						       		<div class="clearfix"></div>
						       <!-- <div class="rating_box">
						       	<?php
						    		 if($this->session->userdata('user_type')!='bar_owner')
		{
						    		 $cnt_fav = fav_checker_bar($bar_detail['bar_id'],$this->session->userdata('user_id')); 
									 
									
											if($cnt_fav==2 && get_authenticateUserID()!=''){
											?>
											<a id="total-fav" href="javascript:void(0);" name="2" class="favourite_text"><i class="glyphicon glyphicon-heart"></i> Add To My Favorites</a>
											<?php
											} elseif(get_authenticateUserID()!=''){?>
												
											<a id="total-fav" href="javascript:void(0);" name="<?php if($cnt_fav==1){ echo $cnt_fav=0;} else{ echo $cnt_fav=1; } ?>" class="favourite_text <?php if($cnt_fav==1){ echo ''; } else{ echo 'active'; } ?>">
											<i class="glyphicon glyphicon-heart"></i> <?php if($cnt_fav==1){ echo 'Add To My Favorites'; } else{ echo 'Remove From My Favorites'; } ?></a>
											<?php } else { ?>
												<a id="total-fav" class="favourite_text" href="javascript:void(0);" name="1" ><i class="glyphicon glyphicon-heart"></i> Add To My Favorites</a>
											<?php } }?>	
						       	</div> -->
						       <div class="clearfix"></div>
						    
						       
						        <div class="mart10 min-height125">
						       
						        	<!-- <p class="bar_add">Website :
						        		<?php if($bar_detail['website']!='' && $bar_detail['website']!='0'){?>
						        		<a onclick="window.open('<?php echo @$bar_detail['website'];?>', '_blank', 'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0');" href="javascript:void(0);"><?php echo @$bar_detail['website'];?></a>
						        		
						        <?php } else {?> -
						        	<?php } ?>		</p> -->
						        	
						        <?php if($bar_detail['bar_category']){?>	
						        	<div class="socialicon-right">
						        		
						        		
                                         <h4 class="bar_add mar_bot10">Bar Type :</h4>
                                         
                                         
                                         	<?php
					     							
													
													 $getin1 = explode(',',strip_tags($bar_detail['bar_category']));
					     							
													$getin = array_slice($getin1, 0, 3);
													$getin12 = array_slice($getin1, 3);
					     							  foreach($getin as $r)
													  {
													  	  echo '<p>'.'&#149; '.getCatname($r).'</p>';
													} ?>
													
													  
													
                                         <div class="clear"></div>
                                    <a  href="#opencategory" data-toggle='modal' class="mar_top5 pull-right">View All </a>
		    		 									       
                                        </div>
                                       <?php } ?> 
						        	<div class="bar_add">
						        		<i class="strip address"></i>
						        		<div class="address-strip">
						        			<?php echo @$bar_detail['address']."<br>";?>
						        			<p><?php echo  @$bar_detail['city'].", ".@$bar_detail['state']." ".@$bar_detail['zipcode'];?></p>
						        		</div>
						        	</div>
						        	
						        	<div>
						        		<div class="bar_phone pull-left reult_sub_title min-height25"><?php echo $bar_detail['phone']!='' ? '<i class="strip smallphone"></i>'.$bar_detail['phone']:'' ;?></div>
						        		
                                        
		    		 					<div class="clearfix"></div>
                                        
                                         
						        	</div>
						        	
						         </div>
						         <div>
						         	 
		    		 				
		    		 				<div class="result_desc more ">
		    		 					<?php if(strip_tags(strlen($bar_detail['bar_desc'])>350)){ echo substr(strip_tags($bar_detail['bar_desc']),0,350).'...<a class="morelink more pull-right" href="javascript://"><i class="strip arrow_down"></i>Show more</a>' ; } else { echo strip_tags($bar_detail['bar_desc']); } ?>
						       	   
						       </div>
                                  
						        <div class="clear"></div>
						      
     				</div>
						       </div>
						    </div>
						    <div class="clearfix"></div>
                              
						    <div class="mar_top20 like-block wid50 mar_r15 text-right">
						    	
						    	
						    	   <?php $cnt_like = like_checker_bar($bar_detail['bar_id'],$this->session->userdata('user_id')); 
											
								if($cnt_like==2 && get_authenticateUserID()!=''){
								?>
								<a id="total-like" href="javascript:void(0);" name="2" class="btn btn-lg btn-primary full-btn pull-left">Like This Bar</i></a>
								<?php
											} elseif(get_authenticateUserID()!='') {?>
											<a id="total-like" href="javascript:void(0);" name="<?php if($cnt_like==1){ echo $cnt_like=0;} else{ echo $cnt_like=1; } ?>" class="btn btn-lg btn-primary full-btn pull-left">
											<?php if($cnt_like==1){ echo 'Like This Bar'; } else{ echo 'Already Liked'; } ?></i></a>
											<?php } else { ?> 
											<a id="total-like" href="javascript:void(0);" name="1" class="btn btn-lg btn-primary full-btn pull-left">
											Like This Bar</a>
								<?php  } ?>
		     					<div class="bar_add mar_bot10 pull-right">We Liked This Bar</div>
		     					<div class="clearfix"></div>
			     				<ul class="likeduser marl_0 mart10">
									<?php 
									if(count($bar_liker) > 0){
									$j=1;
									foreach($bar_liker as $bl){
										 
									if($j<=10){
									?>							
			     					<li id="user_<?php echo $bl->user_id;?>" class="active"><a href="<?php echo site_url('user/profile/'.base64_encode($bl->user_id));?>"><img src="<?php echo base_url();?>upload/user_thumb/<?php if($bl->profile_image!="" && is_file(base_path().'upload/user_thumb/'.$bl->profile_image)){ echo $bl->profile_image; } else{ echo 'no_img.png';}?>" class="user_img"/></a></li>
									<?php
									}
									$j++;
									 } ?> 
								<?php 	}?>    					
			     				</ul><div class="clearfix"></div>
			     				<?php 
									if(count($bar_liker) > 0){ ?>
			     				<a class="more" href="javascript://" id="view-all">View All </a>
			     				<?php } ?>
						    </div>
				    		<div class="clearfix"></div>
     			</div>
     			<div class="right_gallery_block">
     				<a href="javascript://" class="btn-lg btn-primary" onclick="loadMap()">Get Directions</a>
     				<a href="javascript://" class="btn-lg btn-primary" onclick="loadTaxi()">Find a Taxi</a><div class="clearfix"></div>
		     			<div class="br_map mart10 ">
		     				
		     				<div class="portlet-body">
		     					
								<div id="gmap_marker" class="map_img"></div>
								
							</div>
							
		     			</div>
		     			
		     			<div class="" style="margin-top: 20px;">
     					<ul class="social_icon">
     						<li>Share : </li>
						    <li><a href="javascript://" onclick="fbShare()" ><img src="<?php echo base_url().'default'?>/images/result_fb.png"></a></li>
						    <li><a onclick="twShare()" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_twitt.png"></a></li>
						    <li><a onclick="gPlusShare1('<?php echo site_url().'bar/details/'.$bar_detail['bar_id']; ?>','<?php echo $bar_detail['bar_title']; ?>')" href="javascript://"><img src="<?php echo base_url().'default'?>/images/result_google.png"></a></li>
						    <li><a  href="javascript://" onclick="piShare()"><img src="<?php echo base_url().'default'?>/images/result_p.png"></a></li>
						    
						    <div class="clearfix"></div>
		    		 	</ul><div class="clear"></div>
     				</div>
     			</div>
     			
     			<div class="clearfix"></div>
     		</div>
     		<?php if($barhours){ ?>
     		<div class="pad_lr10">
     			<h1 class="productbar_title mar_top20"><div>Hours We Are Open</div></h1>
     			</div>
     			<div class="fullmug-scheduleblock mar_top20">
     				
     				<!-- <h1 class="reg-title">Opening Hours</h1> -->
     				<div class="mart10">
     					<div class="full-scheduleleft">
     						<ul>
     						
     						<?php	  foreach($barhours as $r){?>	
     							<li>
     								<div class="schedule-text"><?php echo $r->days;?></div>
     								<?php if($r->is_closed!='yes'){ ?>
     								<div class="schedule-text"><?php if($r->is_closed!='yes'){  print( date("g:i a", strtotime($r->start_from)) ); } else { echo "Closed"; }?></div>
     									<div class="pull-left" style="width: 50px;">-</div>
     								<div class="schedule-text"><?php if($r->is_closed!='yes'){ print( date("g:i a", strtotime($r->start_to)) ); } else { echo "Closed"; }?></div>
     								<?php } else {?>
     									<!-- <div class="schedule-text">-</div> -->
     									<div class="schedule-text">Closed.</div>
     							<?php } ?>		
     								<div class="clearfix"></div>
     							</li>
     						<?php  } ?>	
     							
     							<div class="clearfix"></div>
     						</ul>
     					</div>
     					
     					<div class="clearfix"></div>
     				</div>
     				
     			</div>
     		 <?php } ?>
     		 
     		
     		<div class="padt10">
     			<div class="review_mainblock marr4 padt10">
     				<h1 class="productbar_title"><div>Send a Bar a Real Post Card</div>
     				</h1>
     			<div id="crd_not_send">
     				<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
     			<?php if($get_post_card == 0){?>	
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
	          							<input type="radio" name="sel_title" onclick="gettitle(this.value)" value="Your Bar Needs Work"> Your Bar Needs Work!
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
	     						<h1 class="post_label ">Dear Bar Owner,</h1>
	     						<div class="result_desc padb10" >I recently Visited your Bar And I have Concluded: <div id="paste_cont" class="sp_tag"></div>  </div>
	     						
	     						<div class="">
	     						 <label id="title">
	                                    Your Bar is Awesome!         							
	        					</label><div class="clearfix"></div>
	        					<!-- <div class="mar_top20">
	        						<a href="#" class="btn btn-lg btn-primary">Upload Image</a>
	        					</div> -->
	        					
                        		
                        		
									<div class="browse1"  id="upload">
										<input type="file" name="file" id="file" class="browse" value="Upload Image">
									</div>
	        						<!--<a href="#" class="btn btn-lg btn-primary">Upload Image</a>-->
	        						<div class="stamp_image" id="preview" style="padding: 0;">
	     							<img id="previewimg" src="" height="50" width="40"/>
	     						</div>
	        					</div>
	        					
                        		
	     					</div>
	     					<div class="post_left">
	     						<img src="<?php echo base_url().getThemeName(); ?>/images/post.png" class="pull-left"/>
	     					
	     						<div class="stamp" >
	     							Place Stamp Here
	     						</div>
	     						<div class="clearfix"></div>
	     						
	     						<div class="post_add">
	     							<?php echo $bar_detail['bar_title'];?><div class="clearfix"></div>
	     							<?php echo $bar_detail['address']."<br/>".$bar_detail['city'].", ".$bar_detail['state']." ".$bar_detail['zipcode'];?>
	     						</div>
	     						
	     					</div>
	     					<div class="clearfix"></div>
	     				</div>
	     				<div class="pull-right padtb10">
	     							<input type="submit" name="send" id="send" onclick="checkauth()" value="Send a Post Card" class="btn btn-lg btn-primary" />
	     						</div>
	     				
	     				</form>
	     				<?php } else {?>
	     					<div  class="error mar_top20  center"> Hello user now you can send another post card after <?php echo 24-number_format($time,2);?> Hours .</div>
	     				<?php } ?>	
	     				</div>
     				</div>
					<div class="modal fade login_pop2" id="loginmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
					   <?php echo $this->load->view($theme.'/home/login_ajax');?>
					</div>	

					<div class="modal fade login_pop2" id="mapmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
					</div>	
					
					<div class="modal fade login_pop2" id="taximodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
					</div>	


<div class="modal fade login_pop2" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	<div class="padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Write a Review</div>
     				</div>
     				<div class="pad20">
     						<div id="ajax_msg_error_reg"></div>
     						<div class="error1 hide1" id="cm-err-main" style="text-align: center;">&nbsp;</div>
     						<form name="frm_add_review" id="frm_add_review" method="post" class="form-horizontal" action="<?php echo site_url("bar/add_bar_comment"); ?>">
     						<div class="error1 hide1 center" id="cm-err-main">&nbsp;</div>
     							<input type="hidden" name="bar_id" id="bar_id" value="<?php echo $bar_id;?>" />
     						<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Review Title :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" maxlength="40" id="comment_title" name="comment_title" >
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
     			<div class="review_mainblock padt10 new_review">
     				<h1 class="productbar_title">
     					<div class="pull-left mar_top5">Raves and Rants</div> 
     					<div class="pull-right">
     						<a href="javascript://" onclick="show_popup()" class="review">Write a Review</a>
     					</div>
     					<div class="clearfix"></div>
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
		     					<p class="result_desc"><?php if(strlen($comment->comment)>300) { echo substr($comment->comment,0,300)."..."; } else { echo $comment->comment; }?></p>
		     					<div class="reult_sub_title"><p class="review_light pull-left"><?php echo $comment->first_name." ".$comment->last_name;?></p></div>
		     					<div class="rating_box starrating<?php echo $comment->bar_rating; ?>"><a href="javascript"></a></div>
		     					<div class="clearfix"></div>
		     				</li>
	     				<?php } } else {?>
	     					<div class="gallery-default reviewdefault mar_top20">
     					No Review Available
     				</div>
	     					<?php } ?>		  	
	     			</ul>
	     			
	     			<div class="pagination">
	     				<?php echo $page_link;?>
     				</div>
     				<div class="clearfix"></div>
     			</div>
     		</div>
     		
     		
     		<div class="clearfix"></div>
     		</div>
     		
     		
     		 <div class="fullmug_block">
     			
     			
     			<div class="col-md-6 coctail-new col-sm-5 padb20">
     				<div class="bar_bg">
     					<h1 class="box_title">Beers Served at Bar</h1>
     					<ul class="bottom_box" id="infinite-list">
     					
	         		<div class="clear"></div></ul><div class="clear"></div>
     				</div>
     			</div>
     		<?php if($bar_detail['serve_as']=='cocktail'){?>
     			<div class="col-md-6 coctail-newright col-sm-5 padb20">
     				<div class="bar_bg">
     					<h1 class="box_title">Cocktails Served at Bar</h1>
     					<ul class="bottom_box" id="infinite-list-cocktail">
     					
	         		<div class="clear"></div></ul><div class="clear"></div>
     				</div>
     			</div>
     		<?php } ?>	
     		
     		<?php if($bar_detail['serve_as']=='liquor'){?>
     			<div class="col-md-6 coctail-newright col-sm-5 padb20">
     				<div class="bar_bg">
     					<h1 class="box_title">Liquors Served at Bar</h1>
     					<ul class="bottom_box" id="infinite-list-liquor">
     					
	         		<div class="clear"></div></ul><div class="clear"></div>
     				</div>
     			</div>
     		<?php } ?>	
     			<div class="clearfix"></div>
     		</div>
     		
     		
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
     						<label class="control-label" style="color: #fff;"><?php echo $bar_detail['bar_desc']; ?></label>	
     				</div>		
     			</div>
     		</div>
     	</div>
     </div>
	
</div>

<div class="modal fade login_pop2" id="opencategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
						<div class="padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Bar Type :</div>
     				</div>
     				<div class="pad20">
     					<ul class="happy-list">
     						
     						<?php
					     							
													
													 $getin1 = explode(',',strip_tags($bar_detail['bar_category']));
					     							
					     							  foreach($getin1 as $r)
													  { 
													  	  echo '<li><p style="color:#fff;">'.'&#149; '.getCatname($r).'</p></li>';
													} ?>
     					
                        	
                        </ul>	
     						
     						
     				</div>		
     			</div>
     		</div>
     	</div>
     </div>
     			</div>	
<div class="modal fade" id="myModalnew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>

<?php $var = '';
		if($bar_detail_map)
		{
			foreach($bar_detail_map as $r)
			{
				$contentstring = '<html><body><div><p><b>Bar Name :</b>'.mysql_real_escape_string($r->bar_title).'</p><p><b>Bar Address :</b> '.$r->address.", ".$r->state." ".$r->zipcode.'</p></div></body></html>'	;
				 $var .= '['.$r->lat.','.$r->lang.',"'.$contentstring.'"],'; 
			}
		}
		
		$var = "[".$var."]";
		
		$contentstring1 = '<html><body><div><p><b>Bar Name :</b>'.mysql_real_escape_string($bar_detail['bar_title']).'</p><p><b>Bar Address :</b> '.$bar_detail['address'].", ".$bar_detail['state']." ".$bar_detail['zipcode'].'</p></div></body></html>'	;
		
		?>
   <script src="https://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>        
<script type="text/javascript">

	
     
     function checkauth()
{
	
	
}
            	
	function show_popup()
	{
		<?php if($this->session->userdata('user_type')=='taxi_owner'){?>
  	    	  $.growlUI('<?php echo NO_RIGHT; ?>');
  	    	   $(".growlUI strong").empty();
  	    	  return false;
  	    <?php } ?> 
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
    
    
		$(document).ready(function()
		{
		$('#form').validate(
		{
		rules: {
					file: {
						accept: "jpg|jpeg|png|bmp",
					},
					desc_post_card: {
						required: true,
					},
						errorClass:'error fl_right'
				},
				
		submitHandler: function(form){
			$("#postcard").val(1);
			if($("#sess_id").val()==0)
			{
				$('#loginmodal').modal('show');
				//return false;
			}
			else
			{
				<?php if($this->session->userdata('user_type')=='taxi_owner'){?>
  	    	  $.growlUI('<?php echo NO_RIGHT; ?>');
  	    	   $(".growlUI strong").empty();
  	    	  return false;
  	    <?php } ?> 
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
		       		
		       		if($("#sess_id").val()==1)
		       		{
		       		 var retVal = confirm("Are you want to Send Postcard ?");
					   if( retVal == true ){
					      //alert("User wants to continue!");
						  return true;
					   }else{
					    //  alert("User does not want to continue!");
						  return false;
					   }
					  } 
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
						$("#crd_not_send").empty();
						$("#crd_not_send").html("<div  class='error mar_top20  center'>Hello user now you can send another post card after 24 hours</div>");
						$("#preview").empty();
						$.growlUI('Your post card send successfully . You can send another postcard after 24 hours');
					}
		     
					$('#dvLoading').fadeOut('slow');
					$('.profile_menu').fadeOut('slow');
								  
		   		 }
		    });
		    }
		  }
		})
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
		
	var directionDisplay;
	var directionsService = new google.maps.DirectionsService();
	var map;
		var LocationData = <?php echo $var; ?>;
	function initialize() {
	var iconBase = '<?php echo base_url().getThemeName(); ?>/images/marker.png';
    var map = 
        new google.maps.Map(document.getElementById('gmap_marker'));
    var bounds = new google.maps.LatLngBounds();
    var infowindow = new google.maps.InfoWindow();
     directionsDisplay = new google.maps.DirectionsRenderer();
     marker = new google.maps.Marker({
    map:map,
    // draggable:true,
    // animation: google.maps.Animation.DROP,
    position: new google.maps.LatLng(<?php echo $bar_detail['lat']!="" ? $bar_detail['lat']:59.32522 ?>, <?php echo $bar_detail['lang']!="" ? $bar_detail['lang']:18.07002; ?>),
    icon: iconBase
  });
  
        var latlng = new google.maps.LatLng(<?php echo $bar_detail['lat']!="" ? $bar_detail['lat']:59.32522 ?>, <?php echo $bar_detail['lang']!="" ? $bar_detail['lang']:18.07002; ?>);
        bounds.extend(latlng);
         
        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            title: '<?php echo mysql_real_escape_string($bar_detail['bar_title']);?>'
        });
     
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent("this.title");
            infowindow.open(map, this);
        });
        
    for (var i in LocationData)
    {
        var p = LocationData[i];
        var latlng = new google.maps.LatLng(p[0], p[1]);
        bounds.extend(latlng);
         
        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            title: p[2]
        });
     
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent(this.title);
            infowindow.open(map, this);
        });
    }
    
    
     
    map.fitBounds(bounds);
    	directionsDisplay.setMap(map);
		google.maps.event.trigger(map, 'resize');
	}
	
function loadMap()
{
	$.ajax({
	       type: "POST",
		   url: "<?php  echo site_url('bar/getmapajax')?>",
		   data: {id:<?php echo $bar_detail["bar_id"]; ?>},
		   dataType : 'html',
		     beforeSend : function() {
		   		$('#dvLoading').fadeIn('slow');
		   },
		    complete : function() {
		   		$('#dvLoading').fadeOut('slow');
		   },		
		   success: function(response) {
		   	$("#mapmodal").html(function(){
		   		$(this).html(response);
		   		$('#mapmodal').on('show.bs.modal', function() {
		    		
                         initialize();
			           	 	
    						}).modal();
    						
    						 setTimeout(function() {
					       initialize();
						}, 200);
		   	});
		    //$('#mapmodal').one('show.bs.modal', function (e) {
		    	//$('#myModalnew').one('shown.bs.modal', function (e) {
		    	
		     
		  }
	   });
}	

function loadTaxi()
{
	$.ajax({
	       type: "POST",
		   url: "<?php  echo site_url('taxiowner/gettaxiajax')?>",
		   data: {id:<?php echo $bar_detail["bar_id"]; ?>},
		   dataType : 'html',
		     beforeSend : function() {
		   		$('#dvLoading').fadeIn('slow');
		   },
		    complete : function() {
		   		$('#dvLoading').fadeOut('slow');
		   },		
		   success: function(response) {
		    	$("#taximodal").html(function(){
		   		$(this).html(response);
		   		$('#taximodal').one('shown.bs.modal', function() {
			           	 	
    						}).modal();
    						
    						 setTimeout(function() {
					       loadData_taxi(0,15);
					       check();
					       $('#infinite-favorite-taxi').slimscroll({
		        alwaysVisible: true,
		        height: 200,
		        color: '#f19d12',
		        opacity: .8
		      });
						}, 200);
		   	});
		    //$('#mapmodal').one('show.bs.modal', function (e) {
		    	//$('#myModalnew').one('shown.bs.modal', function (e) {
		    	
		     
		  }
	   });
}	

</script>

<script type="text/javascript">
  var geocoder;
  var map;
  var address ="<?php echo @$bar_detail['address']." ".@$bar_detail['city']." ".@$bar_detail['zipcode']." ".@$bar_detail['state'];?>";
  function initialize_map() 
  {
    var iconBase = '<?php echo base_url().getThemeName(); ?>/images/marker.png';
    var map = 
        new google.maps.Map(document.getElementById('gmap_marker'));
    var bounds = new google.maps.LatLngBounds();
    var infowindow = new google.maps.InfoWindow();
     directionsDisplay = new google.maps.DirectionsRenderer();
     marker = new google.maps.Marker({
    map:map,
    // draggable:true,
    // animation: google.maps.Animation.DROP,
    
    position: new google.maps.LatLng(<?php echo $bar_detail['lat']!="" ? $bar_detail['lat']:59.32522 ?>, <?php echo $bar_detail['lang']!="" ? $bar_detail['lang']:18.07002; ?>),
    icon: iconBase
  });
  
  //var latlng = new google.maps.LatLng(<?php //echo $bar_detail['lat']?>, <?php //echo $bar_detail['lang']?>);
      //  bounds.extend(latlng);
         
     //   var marker = new google.maps.Marker({
     //       position: latlng,
      //      map: map,
     //       title: '<?php //echo $bar_detail['bar_title']?>'
     //   });
     //
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent('<?php echo $contentstring1;?>');
            infowindow.open(map, this);
        });
        
    for (var i in LocationData)
    {  
        var p = LocationData[i];
        var latlng = new google.maps.LatLng(p[0], p[1]);
        bounds.extend(latlng);
         
        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            title: p[2]
        });
     
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent(this.title);
            infowindow.open(map, this);
        });
    }
    
    
     
    map.fitBounds(bounds);
    	directionsDisplay.setMap(map);
		google.maps.event.trigger(map, 'resize');
  }
</script>

<script>
 $(document).ready(function () {
	$('#total-like').click(function(){
		<?php if($this->session->userdata('user_type')=='taxi_owner'){?>
  	    	  $.growlUI('<?php echo NO_RIGHT; ?>');
  	    	   $(".growlUI strong").empty();
  	    	  return false;
  	    <?php } ?> 
		var flag = this.name;
		var bid = '<?php echo $bar_detail["bar_id"]; ?>';
		var uid = '<?php echo get_authenticateUserID(); ?>';
		
		if($('#sess_id').val()==0)
		{
			<?php $this->session->set_userdata("REDIRECT_PAGE","bar/details/".$bar_detail["bar_slug"]); ?>
			$('#loginmodal').modal('show');
			return false;
		}
		
		$.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>bar/bar_likes",         //the script to call to get data          
        data: {bar_id: bid, user_id: uid, like_flag:flag},
	    dataType: '',                //data format      
        success: function(data)          //on receive of reply		
            {  
            	
			var main = data.split('*');
			   if(main[0]==1){
				   $('#total-like').attr('name','0');
				   $('#total-like').html('Already Liked');
				   $('.likeduser').append(main[1]);	
			   }
			   else{
				   $('#total-like').attr('name','1');
				   $('#total-like').html('Like This Bar');
				   $('#'+main[1]).remove();
				}
		    } 
		
        });
	});
	
	 $("#view-all").click(function(){
    	$.ajax({
			         type: "POST",
			         url: "<?php echo site_url('bar/view_all_likers')?>",
			         data : {id:<?php echo $bar_detail['bar_id']; ?>},
			         success: function(response) {
			        	 //$('#myModalnew').modal('show');
			        	  $("#myModalnew").html(response);
			        	   $('#myModalnew').one('shown.bs.modal', function (e) {
    						}).modal();
			           // alert(response);
			        }
			    });
    }) ;
});	
</script>





   <div itemscope itemtype="http://schema.org/LocalBusiness" style="display:none;">
   	

<?php     
		          		if($bar_detail['bar_banner']!="" && file_exists(base_path().'upload/banner_drag/'.@$bar_detail['bar_banner']))
					{?>
		            	  $img =    <?php echo base_url()?>/upload/banner_drag/<?php echo $bar_detail['bar_banner']; ?>;
		            	<?php }  else if($bar_detail['bar_banner']!="" && file_exists(base_path().'upload/banner_drag_without/'.@$bar_detail['bar_banner']))
					{?>
						$img = <?php echo base_url()?>/upload/banner_without_drag/<?php echo $bar_detail['bar_banner']; ?>;
		            		
		            		<?php } else {?>
		            		$img = <?php echo base_url().'default'?>/images/smallbanner1.png";	
		            			<?php } ?>
		<span itemprop="name"><?php echo $bar_detail['bar_title'];?></span>
		<div itemprop="description"> <?php echo $bar_detail['bar_desc'];?></div>
			<span  itemprop="email"><?php echo $bar_detail['email'];?></span>
			
			<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" class="mart10">
			<p itemprop="streetAddress" class="bar_add">
				<?php echo $bar_detail['address'];?>
			</p>
			
		</div>
			
			<span id="_telephone3" itemprop="telephone"><?php echo $bar_detail['phone'];?></span>,
			<img  itemprop="image" src="<?php echo $img; ?>" alt="American Dive Bars"/> 
			<span itemprop="ratingCount"><?php echo getReviewRating($bar_id);?></span>
			<label itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" id="title"> 
				 <span itemprop="postalCode"><?php echo $bar_detail['zipcode'];?></span>
				 <span itemprop="addressRegion"><?php echo $bar_detail['state'];?></span>
				 <span itemprop="addressLocality"><?php echo $bar_detail['city'];?></span>! </label>

			
			
			
			

			<!-- <ul itemscope itemtype="http://schema.org/LocalBusiness">
				<?php if($barhours){
     							  foreach($barhours as $r){?>	
			<li itemprop="openingHoursSpecification" itemscope itemtype="http://schema.org/OpeningHoursSpecification">
				<span itemprop="dayOfWeek" itemscope itemtype="http://schema.org/DayOfWeek">
					<div itemprop="name" class="schedule-text">
						<?php echo $r->days;?>
					</div></span>
					<?php if($r->is_closed!='yes'){ ?>
					<meta itemprop="opens" content="<?php echo date("g:i a", strtotime($r->start_from));?>">
					<?php if($r->is_closed!='yes'){  print( date("g:i a", strtotime($r->start_from)) ); } else { echo "Closed"; }?>
					<meta itemprop="closes" content="<?php echo  date("g:i a", strtotime($r->start_to));?>">
					<?php if($r->is_closed!='yes'){ print( date("g:i a", strtotime($r->start_to)) ); } else { echo "Closed"; }?>
					<?php } else {?>
						<meta itemprop="closes" content="Please insert valid ISO 8601 date/time here. Examples: 2015-07-27 or 2015-07-27T15:30">Closed
					<?php } ?>	
			</li>
			<?php } } ?>
		</ul>
			 -->
			
			
	</div>
	
<link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/css/prettify.css">
	<script src="<?php echo base_url().getThemeName(); ?>/js/jquery.slimscroll.js"></script>
	<script src="<?php echo base_url().getThemeName(); ?>/js/prettify.js"></script>
	<script type="text/javascript">
		$(function(){
		      $('#infinite-list').slimscroll({
		        alwaysVisible: true,
		        height: 410,
		        color: '#f19d12',
		        opacity: .8
		      });
		      
		        $('#infinite-list-cocktail').slimscroll({
		        alwaysVisible: true,
		        height: 410,
		        color: '#f19d12',
		        opacity: .8
		      });
		      
		      $('#infinite-list-liquor').slimscroll({
		        alwaysVisible: true,
		        height: 410,
		        color: '#f19d12',
		        opacity: .8
		      });
		
		  });
	</script>
	<!--------------End Scroll ------------------->
<style>
	#gmap_marker {
    height: 322px;
    width: 100%;
}
 .gm-style-iw
 {
 	color:#000000;
 }
 #infinite-list {
    height: 410px;
    margin-left: auto;
    margin-right: auto;
    overflow-x: hidden;
    overflow-y: scroll;
}
#infinite-list-cocktail {
    height: 410px;
    margin-left: auto;
    margin-right: auto;
    overflow-x: hidden;
    overflow-y: scroll;
}
</style>	

	

<?php $theme_url = $urls= base_url().getThemeName();?>
<script>
	var base_url = '<?php echo site_url('bar/getmorebeer/?bar_id='.$bar_detail['bar_id']); ?>';
	var base_url_cocktail = '<?php echo site_url('bar/getmorecocktail/?bar_id='.$bar_detail['bar_id']); ?>';
	var base_url_liquor = '<?php echo site_url('bar/getmoreliquor/?bar_id='.$bar_detail['bar_id']); ?>';
</script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/rating.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/image_script.js"></script>
<script type="text/javascript" src="<?php echo $theme_url; ?>/js/jquery_form.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/js/rating.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/css/jquery.bxslider.css" />
 <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/infiniteScroll.js"></script>
 <script type="text/javascript">InfiniteList.loadData(0,15); InfiniteList.loadData_cocktail(0,15);InfiniteList.loadData_liquor(0,15);</script>




