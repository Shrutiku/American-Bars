<style>
.morecontent span {
    display: none;
}
.morelink {
    display: block;
}
.morecontent1 span {
    display: none;
}
.morelink1 {
    display: block;
}
span.required {
    color: #B31010;
    vertical-align: -4px;
}
</style>
<script>
	$(document).ready(function() {
		
	var showChar = 200;  // How many characters are shown by default
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
    
    $('.more1').each(function() {
        var content = $(this).html();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses1">' + ellipsestext+ '&nbsp;</span><span class="morecontent1"><span>' + h + '</span>&nbsp;&nbsp;<a href="javascript://;" class="morelink1 more pull-right"><i class="strip arrow_down"></i>' + moretext + '</a></span>';
 
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
//     
    $(".morelink1").click(function(){
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
<?php
		          		if($user_detail['profile_image']!="" && file_exists(base_path().'upload/user_thumb/'.@$user_detail['profile_image']))
					{?>
		            	<?php $img =  base_url().'/upload/user_thumb/'.$user_detail['profile_image']; ?>
		            	<?php }  else { ?>
		            		<?php $img =  base_url().'/upload/beer_thumb/no_image.png'; ?>
		            		<?php } ?>

<?php $theme_url = $urls= base_url().getThemeName();?>
<input type="hidden" name="sess_id" id="sess_id" value="<?php echo check_user_authentication()=="" ? '0':'1';?>" />
<!-- <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.validate.js"></script> -->
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/rating.js"></script>
<!-- <script type="text/javascript" src="<?php echo $theme_url; ?>/js/jquery_form.js"></script> -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/js/rating.css" />
<script type="text/javascript">

		  $(document).ready(function() {
		        $('#menu').click(function() {
		                $('.profile_menu').slideToggle("slow");
		        });
		        
		      
		    });
	</script>

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
     	<div class="user_details">
     		<div class="result_search">
	     		<div class="result_search_text">Taxi Owner Details</div>
     		</div>
     		<div class="br_bott_yellow">
     			<div>
     				<div class="media taxi-new">
     					 <div class="pull-left mar_top15">
						    <a  href="<?php echo site_url("taxiowner/details/".base64_encode($user_detail['taxi_id']));?>">
							<?php 
							if($user_detail['taxi_image']!="" && is_file(base_path().'upload/user_thumb/'.$user_detail['taxi_image'])){ ?>
									<img src="<?php echo base_url().'upload/user_thumb/'.$user_detail['taxi_image']; ?>" class="br_green_yellow " />
								<?php
								} else{?>
									<img height="120" width="120" src="<?php echo base_url().'upload/taxi_thumb/no_image.png'; ?>" class="br_green_yellow " />
									<?php } ?>
						    </a>
						    
						 </div>
						    <div class="media-body">
						       <div class="clearfix"></div>
						        <div class="mart10">
								
								
								<ul class="dashboard_list-new">
		     							<li>
		     								<p class="marr_10 dashboard_newtitle min-215 first-div"><span>Company Name </span></p><p class="colon-new first-div"> : </p> <p class="msg_username-new  address-new add pera"> <?php echo $user_detail['taxi_company']; ?></p>
		     								<div class="clearfix"></div>
		     								<p class="marr_10 dashboard_newtitle min-215"><span>Company Address </span></p><p class="colon-new"> : </p><p class="address-new add pera"><span><?php echo $user_detail['address'].", ".$user_detail['city'].", ".$user_detail['state']." ".$user_detail['cmpn_zipcode']; ?></span></p>
		     								<div class="clearfix"></div> 
		     								<p class="marr_10 dashboard_newtitle min-215"><span>Company Website Address  </span></p><p class="colon-new"> : </p><p class="address-new add"><span><?php echo $user_detail['cmpn_website']; ?></span></p>
											
		     								<div class="clearfix"></div> 
		     								<p class="marr_10 dashboard_newtitle min-215"><span>Company Mobile Number  </span></p><p class="colon-new"> : </p><p class="address-new add"><span><?php echo $user_detail['phone_number']; ?></span></p>
		     								<div class="clearfix"></div> 
		     								<p class="marr_10 dashboard_newtitle min-215">Owner Name </p> <p class="colon-new padt5"> : </p>  <p class="address-new add"><?php if($user_detail['first_name']!=''){ echo ucfirst($user_detail['first_name'])." ".ucfirst($user_detail['last_name']); } else { echo "ADB"; } ?></p>
		     								<div class="clearfix"></div>
		     								<p class="marr_10 dashboard_newtitle min-215"><span>Owner Mobile Number  </span></p><p class="colon-new"> : </p><p class="address-new add"><span><?php echo $user_detail['mobile_no']; ?></span></p>
		     								
		     								
		     										     								<!--<p class="marr_10 dashboard_newtitle min-120"><span>Gender </span></p><p class="colon-new"> : </p><p class="address-new pera"> male</p>
		     								<div class="clearfix"></div> 		     					-->			
		     								<div class="clearfix"></div> 		     								
											
											<div class="clearfix"></div> 		     								
											
											
											<div class="clearfix"></div> 		     								
		     							</li>
		     							<li>
		     								<p class="pera pull-left padt5"><span class="dashboard_newtitle">About Company : </span> </p>
			     							<p class="about-new pera width100">
			     									<?php if(strip_tags(strlen($user_detail['taxi_desc'])>350)){  echo substr(strip_tags($user_detail['taxi_desc']),0,350).'...<a class="morelink more pull-right" href="javascript://"><i class="strip arrow_down"></i>Show more</a>' ; } 
				     						else { echo strip_tags($user_detail['taxi_desc']); } ?>			     								</p>				     								<div class="clearfix"></div>
			     								<div>
					     							<!--<ul class="social_icon">
					     				
					     						<li class="dashboard_newtitle">Links : </li>
					     											     																	   <li><a target="_blank" href="http://americandivebars.com/"><img src="http://192.168.1.27/ADB/default/images/fb.png"></a></li>
											   											   											    <li><a target="_blank" href="http://americandivebars.com/"><img src="http://192.168.1.27/ADB/default/images/twitter.png"></a></li>
											     											   											    <li><a target="_blank" href="http://americandivebars.com/"><img src="http://192.168.1.27/ADB/default/images/google.png"></a></li>
											     											    											    <li><a target="_blank" href="http://americandivebars.com/"><img src="http://192.168.1.27/ADB/default/images/linkedin.png"></a></li>
											     											    											    <li><a target="_blank" href="http://americandivebars.com/"><img src="http://192.168.1.27/ADB/default/images/pintrest.png"></a></li>
											     											    											    <li><a target="_blank" href="http://americandivebars.com/"><img src="http://192.168.1.27/ADB/default/images/instagram.png"></a></li>
											     											    <div class="clearfix"></div>
							    		 	</ul>--><div class="clearfix"></div>
							     				
					     					</div>
		     							</li>
		     									     							<!-- <li><span class="marr_10 dashboard_newtitle">Name : </span> Robert</li> -->
		     							<!-- <li><span class="marr_10 dashboard_newtitle">Last Name : </span> Deo</li> -->
		     							<!-- <li><span class="marr_10">Email : </span> ravi.mansuriya@spaculus.com</li> -->
		     							<!-- <li><span class="marr_10 dashboard_newtitle">Gender : </span> male</li> -->
		     							<!-- <li><p class="marr_10 dashboard_newtitle pull-left">Address : </p> <p class="address-new">voluptates totam<br><span>vadodara  gujarat  390023</span></p><div class="clearfix"></div></li> -->
		     							<!-- <li><span class="marr_10">Mobile Number : </span> (546) 546-5465</li> -->
		     							<!-- <li><span class="dashboard_newtitle"><a href="#" title="E-Mail"><i class="strip mail_white"></i></a> <a href="#" title="SMS"><i class="strip msg"></i></a></li> -->
		     							<!--<li><span class="dashboard_newtitle"><a href="#" title="Message"><i class="strip msg"></i></a>  Mobile Number :  <a href="javascript://" class="msg_username" onclick="show_popup_new()" > Send a Text Message </a> </span>  </li>-->
		     								<div class="clearfix"></div>
		     							</ul>
								
								
								
								
						        	<!--<ul class="beerdirectory">
						        		<li>
						        			<div class="pull-left yellow_text marr_10 wid25">Owner Name : </div>
						        			<div class="pull-left white_text wid75"><?php if($user_detail['first_name']!=''){ echo ucfirst($user_detail['first_name'])." ".ucfirst($user_detail['last_name']); } else { echo "ADB"; } ?></div>
						        			<div class="clearfix"></div>
						        		</li>
						        		<li>
						        			<div class="pull-left yellow_text marr_10 wid25">Company Name : </div>
						        			<div class="pull-left white_text wid75"><?php echo $user_detail['taxi_company']; ?></div>
						        			<div class="clearfix"></div>
						        		</li>
						        		<li>
						        			<div class="pull-left yellow_text marr_10 wid25">Company Address : </div>
						        			<div class="pull-left white_text wid75"><?php echo $user_detail['address'].", ".$user_detail['city'].", ".$user_detail['state'].", ".$user_detail['cmpn_zipcode']; ?></div>
						        			<div class="clearfix"></div>
						        		</li>
						        		<?php if($user_detail['mobile_no']!=''){ ?>
						        		<li>
						        			<div class="pull-left yellow_text marr_10 wid25">Owner Mobile Number : </div>
						        			<div class="pull-left white_text wid75"><?php echo $user_detail['mobile_no']; ?></div>
						        			<div class="clearfix"></div>
						        		</li>
						        		<?php } ?>
						        		<?php if($user_detail['phone_number']!=''){ ?>
						        		<li>
						        			<div class="pull-left yellow_text marr_10 wid25">Company Mobile Number : </div>
						        			<div class="pull-left white_text wid75"><?php echo $user_detail['phone_number']; ?></div>
						        			<div class="clearfix"></div>
						        		</li>
						        		<?php } ?>
						        		<?php if($user_detail['cmpn_website']!=''){ ?>
						        		<li>
						        			<div class="pull-left yellow_text marr_10 wid25">Company Website Address : </div>
						        			<div class="pull-left white_text wid75"><?php echo $user_detail['cmpn_website']; ?></div>
						        			<div class="clearfix"></div>
						        		</li>
						        		<?php } ?>
						        		
						        	</ul>-->						        	
						         </div>	
						         
						         <!--<div class="margin-top-20">
				     				<div class="yellow_title"> Company Description:</div>
				     				<div class="result_desc ">
				     						<?php if(strip_tags(strlen($user_detail['taxi_desc']>350))){ echo substr(strip_tags($user_detail['taxi_desc']),0,350).'...<a class="morelink more pull-right" href="javascript://"><i class="strip arrow_down"></i>Show more</a>' ; } 
				     						else { echo strip_tags($user_detail['taxi_desc']); } ?>
				     					<?php //echo $user_detail['reciew'];?></div>
			     				</div>-->
     									        
						    </div>
				    	</div>
				    	<div class="clearfix"></div>
				    	<div>
     				<!-- <div class="pull-right desc_wid80">
	     				<div class="yellow_title"> Company Description:</div>
	     				<div class="result_desc ">
	     						<?php if(strip_tags(strlen($user_detail['taxi_desc']>350))){ echo substr(strip_tags($user_detail['taxi_desc']),0,350).'...<a class="morelink more pull-right" href="javascript://"><i class="strip arrow_down"></i>Show more</a>' ; } 
	     						else { echo strip_tags($user_detail['taxi_desc']); } ?>
	     					<?php //echo $user_detail['reciew'];?></div>
     				</div> -->
     				<div class="clearfix"></div>
     			</div>
     			</div>
     			
     			
     			<div class="clearfix"></div>
     			
     			
     			
     			
     			
     		</div>
     		
     	</div>	
   		</div>
   		   		
   	</div>
<!-- ########################################################################################### -->
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
     						<label class="control-label" style="color: #fff;"><?php echo $user_detail['taxi_desc']; ?></label>	
     				</div>		
     			</div>
     		</div>
     	</div>
     </div>
	
</div>     

