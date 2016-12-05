
		            		<script type="text/javascript">
		            		
function fbShare(){
	window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('<?php echo site_url('article/detail/'.base64_encode($blog_detail['blog_id'])); ?>'),'facebook-share-dialog','width=626,height=436');
            return false;
}
		            	</script>	
<style>
.result_desc p img
{
	width: 100% !important;
	height: 100% !important;
}
iframe
{
	 width: 100%;
}
.morecontent span {
    display: none;
}
.related_beer_block {
    float: left;
    width: 222px;
}
.morelink {
    display: block;
}
.morelink1 {
    display: block;
}
span.required {
    color: #B31010;
    vertical-align: -4px;
}
</style>
<!-- ########################################################################################### -->
<?php
$theme_url =  base_url().getThemeName();
//$category_videoes = get_blog_category_wise($blog_detail["blog_id"],$blog_detail["blog_category_id"],3);
?>
<style type="text/css">
	/*//.rating {margin: 0em !important;width:100px;}*/
</style>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/rating.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/js/rating.css" />
<?php
		          		if($blog_detail['blog_image']!="" && file_exists(base_path().'upload/blog_orig/'.@$blog_detail['blog_image']))
					{?>
		            	<?php $img =  base_url().'/upload/blog_thumb_50by50/'.$blog_detail['blog_image']; ?>
		            	<?php }  else { ?>
		            		<?php $img =  base_url().'/upload/beer_thumb/no_image.png'; ?>
		            		<?php } 
		            		
		            		//echo $img;
		            		?>
<script type="text/javascript">
function just_here()
{
	var showChar = 400;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more";
    var lesstext = "Show less";
    
    $('.more').each(function() {
    	
        var content = $(this).html();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="javascript://;" id="'+this.id+'" class="morelink1 more pull-right"><i class="strip arrow_down"></i>' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
    $(".morelink1").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
             
            scrollToDiv(this.id);
            $(".morelink1").html("<i class='strip arrow_down more'></i>View More..");
        } else {
            $(this).addClass("less");
            $(this).html("<i class='strip arrow_up more'></i>View Less..");
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
}
	 $(document).ready(function () {
    	
//for rating//
	$('#star1').rating('www.url.php', {maxvalue:5});
	$(".cancel").hide();
// end of for ratting////	
	$(".star").click(function(){
		var rat = $("#rating").val();
		var vid = '<?php echo $blog_detail["blog_id"]; ?>';
		var uid = '<?php echo $this->session->userdata("user_id"); ?>';
		      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>article/add_rating",         //the script to call to get data          
        data: {blog_rating: rat,blog_id: vid, user_id: uid},
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

     //end validate
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
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="javascript://;" id="'+this.id+'" class="morelink1 more pull-right"><i class="strip arrow_down"></i>' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
    $(".morelink1").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
             
            scrollToDiv(this.id);
            $(".morelink1").html("<i class='strip arrow_down more'></i>View More..");
        } else {
            $(this).addClass("less");
            $(this).html("<i class='strip arrow_up more'></i>View Less..");
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
      $(".morelink").click(function(){
         $("#myModalnew_open").modal('show');
    });
     }); 
</script>

		            		
		            		
		            		
<?php $theme_url = $urls= base_url().getThemeName();?>
<input type="hidden" name="sess_id" id="sess_id" value="<?php echo check_user_authentication()=="" ? '0':'1';?>" />
<style type="text/css">
	/*//.rating {margin: 0em !important;width:100px;} */
</style>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo $theme_url; ?>/js/jquery_form.js"></script>
<script type="text/javascript">
	
		  $(document).ready(function() {
		  	
		        $('#menu').click(function() {
		                $('.profile_menu').slideToggle("slow");
		        });
		        
		        $('#comment_title').click(function() {
					// var uid = '<?php //echo $this->session->userdata("user_id"); ?>';
					// if(uid!=""){
						// $('.profile_menu').slideDown("slow");
					// }
					// else{					
						// window.location.href='<?php //echo site_url("beer/add_subcomment/".$blog_detail["beer_id"]); ?>';
			           	// return false;
					// }
					
					if($('#sess_id').val()==0)
					{
						$('#loginmodal').modal('show');
						return false;
					}
					else
					{
						 $('.profile_menu').slideDown("slow");
					}
// 					
		        });
		        $('.sp_reply').live('click',function() {
		        	
		        	if($('#sess_id').val()==0)
					{
						$('#loginmodal').modal('show');
						return false;
					}
					else
					{
						var pr = $(this).parent();
		                $('.post_block1',pr).slideDown("slow");
					}
					
					// var uid = '<?php //echo $this->session->userdata("user_id"); ?>';
					// if(uid!=""){
						// var pr = $(this).parent();
		                // $('.post_block1',pr).slideDown("slow");
					// }
					// else{
						// window.location.href='<?php //echo site_url("beer/add_comment/".$blog_detail["beer_id"]); ?>';
			           // return false;
					// }
		        });
		         // $('#status2').click(function() {
		                // $('.post_block').toggle("slow");
		        // });
		    });
	</script>
<script type="text/javascript">

function formatDate(d)
{
	var d = new Date();
	var month2 = new Array();
	month2[0] = "January";
	month2[1] = "February";
	month2[2] = "March";
	month2[3] = "April";
	month2[4] = "May";
	month2[5] = "June";
	month2[6] = "July";
	month2[7] = "August";
	month2[8] = "September";
	month2[9] = "October";
	month2[10] = "November";
	month2[11] = "December";
	var n = month2[d.getMonth()];

	var month = d.getMonth();
   	var day = d.getDate();
   	month = month + 1;

   	month = month + "";
   	if (month.length == 1)
   	{
    	month = "0" + month;
   	}
   	day = day + "";
   	if (day.length == 1)
   	{
    	day = "0" + day;
   	}
   	return n + ' ' + day;
}
	 $(document).ready(function () {
	 	
    	
    	testsub();
	 setTimeout(function () 
	 {
	      $("#wathcv").slideToggle('slow');
     }, 4000);
	 
/* =========================================== REMOVE SUB COMMENT =================================================*/					  
	$('.remove_subcomment').live('click',function(){
		var remove = this.name;
		$.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>article/remove_subcomment",         //the script to call to get data          
        data: {blog_comment_id:remove},
	    dataType: '',                //data format      
        success: function(data)          //on receive of reply		
            { 
				$('.result_sub_box #'+data).remove();
		    } 
		
        });
	});
/* =========================================== REMOVE SUB COMMENT =================================================*/					  

$('#add-comment').ajaxForm( {
	 type: "POST",
    dataType : 'json',
	beforeSubmit: function() {
        $("#add-comment").validate({
		   rules: {
			   comment_title: { required: true },
			   //comment: { required: true }			  
		   }		  
       });	   
       
       $('#dvLoading').fadeIn('slow');
    },
    uploadProgress: function ( event, position, total, percentComplete ) {	
    },
    success : function ( json ) {
	
	
	
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
		$("#cm-err-main").html("");
	}
	var cmdt = formatDate(json.date_added);
	var data = '';
	data ='<li id="comment_'+json.blog_comment_id+'"><div class="media"><a class="user_img_link" href="<?php echo site_url("user/profile/".@base64_encode(get_authenticateUserID())); ?>">';
	if(json.profile_image!='')
	{
	     data += '<img src="<?php echo base_url(); ?>upload/user_thumb/'+json.profile_image+'" class="img-responsive br_green_yellow" />'
	}
	else
	{
	    data += '<img src="<?php echo base_url(); ?>upload/user_thumb/no_img.png" class="img-responsive br_green_yellow" />';
	}
	
	data += '</a>';
	data +='<div class="media-body"><div><h4 class="media-heading"><a href="<?php echo site_url("user/profile/".@base64_encode(get_authenticateUserID())); ?>" class="bar_title">'+json.first_name+' '+ json.last_name +'</a></h4></div>';
	data +='<div class="result_desc wid100">'+json.comment+'</div><div class="reviewlabel mar_top5">';
	data +='<div class="reviewlabel mar_top5">'+json.cust_date+' By '+ json.first_name+' '+ json.last_name +' '+json.date_duration +'</div>';

				
		data +='<form id="add-subcomment-'+json.blog_comment_id+'" class="mysubadb" name="add-subcomment-'+json.blog_comment_id+'" enctype="multipart/form-data" method="post" action="<?php echo site_url("beer/add_subcomment"); ?>"><div class="mart10">';
		data +='<a id="status'+json.blog_comment_id+'" class="bar_title sp_reply sprp_'+json.blog_comment_id+'">Reply</a><div class="post_block1 wid82" style="display: none;"><div><textarea id="comment" name="comment" class="status form-control form-pad" placeholder="Write Here" rows="4"></textarea></div><div class="mart10"><input type="hidden" class="beer_id" id="beer_id" name="beer_id" value="'+json.beer_id+'"><input type="hidden" class="master_comment_id" id="master_comment_id" name="master_comment_id" value="'+json.blog_comment_id+'"><div class="mart10"><button type="submit" class="btn btn-lg btn-primary">Post</button></div><div class="clearfix"></div></div><div class="clearfix"></div></div><div class="clearfix"></div></div></form>';
		data +='<div class="wid100"><ul id="innersub'+json.blog_comment_id+'" class="result_sub_box mart10"></ul></div>';
		data +='</div><div class="clearfix"></div></li>';
		$('.bottom_box').prepend(data);
		$('#test').val(json.testdd);
		testsub();
           $(':input','#add-comment')
						 .not(':button, :submit, :reset, :hidden')
						 .val('')
						 .removeAttr('checked')
						 .removeAttr('selected');
						  $('#dvLoading').fadeOut('slow');
						  $('.profile_menu').fadeOut('slow');
						  
    }
});

/// end of comment ajax pagination/////////////

});


function testsub()
{
	$('.mysubadb').ajaxForm({
	
	type: "POST",
    dataType : 'json',
	beforeSubmit: function() {
	//alert('dddFFF');
        $("#add-subcomment").validate({
		   rules: {
			   comment_title: { required: true },
			   comment: { required: true }			  
		   }		  
       });	   
       
        $('#dvLoading').fadeIn('slow');
    },
    uploadProgress: function ( event, position, total, percentComplete ) {
	},
    success : function ( json ) {
	//alert('ddd');
	//alert(json);
	//alert(this.id);
	
	
	//alert(forsplit);
	
	//var mainid =forsplit.split('-');
	//var appendli = mainid[2];
	
	/// validation
	if(json.status == "fail")
	{
		$("#cmsub-err-main"+json.master_comment).show();
		$("#cmsub-err-main"+json.master_comment).html(json.comment_error);
	    $('#dvLoading').fadeOut('slow')
		  setTimeout(function () 
				 {
				      $("#cmsub-err-main"+json.master_comment).fadeOut('slow');
				      
				      $(':input','.mysubadb')
						 .not(':button, :submit, :reset, :hidden,:text')
						 .val('')
						 .removeAttr('checked')
						 .removeAttr('selected');
												 
				}, 3000);
				
		 
		return false;
	}
	
	else
	{
		$("#cmsub-err-main"+json.master_comment).hide();
		$("cmsub-err-main"+json.master_comment).html("");
	}
	
	//validation end//
	var forsplit = $('.mysubadb').attr('id');
	
	//var mainid =forsplit.split('-');
	//var appendli = mainid[2];
	var cmdt = "";
	var data = '';
	data ='<li class="active pos_rel" id="'+json.blog_comment_id+'"><div class="media"><a class="pull-left" href="<?php echo site_url("user/profile/".@base64_encode(get_authenticateUserID())); ?>">';
	if(json.profile_image!='')
	{
	     data += '<img src="<?php echo base_url(); ?>upload/user_thumb/'+json.profile_image+'" class="user_img" />';
	}
	else
	{
	    data += '<img src="<?php echo base_url(); ?>upload/user_thumb/no_img.png" class="user_img" />';
	}
	
	data += '</a>';
	data +='<div class="media-body"><a href="javascript:void(0);" class="remove_subcomment" name="'+json.blog_comment_id+'"><i class="strip close_icon"></i></a><h4 class="media-heading"><a href="<?php echo site_url("user/profile/".@base64_encode(get_authenticateUserID())); ?>" class="bar_title">'+json.first_name+' '+ json.last_name +'</a></h4>';
	data +='<div class="result_desc wid100">'+json.comment+'</div><div class="reviewlabel mar_top5">';
	data +='<div class="reviewlabel mar_top5">'+json.cust_date+' By '+ json.first_name+' '+ json.last_name +' '+json.date_duration +'</div>';

	
		

		data +='</div></li>';
		$('#innersub'+json.master_comment_id).prepend(data);
		$('#subtest').val(json.testdd);
		 $(':input','.mysubadb')
						 .not(':button, :submit, :reset, :hidden')
						 .val('')
						 .removeAttr('checked')
						 .removeAttr('selected');
						 
		 $('#dvLoading').fadeOut('slow');
		  $('.post_block1').fadeOut('slow');
		 
    }
});
}

</script>
<!-- content -->
<div class="wrapper row4">
   		<div class="container clearfix">
   			<div id="slider-fixed-banner" class="carousel slide">
        	<div class="carousel-inner">
          	<div class="active item">
            	 <?php $getimagename = getimagenamebanner();?>	
          	  <?php 
									if($getimagename->find_article_state==1 && $getimagename->article!="" && is_file(base_path().'upload/bar_pages_banner_orig/'.$getimagename->article)){ ?>
										<img src="<?php echo base_url().'upload/bar_pages_banner/'.$getimagename->article; ?>"   />
									<?php
									} else {?>
            	<!-- <img src="<?php echo base_url(); ?>/default/images/smallbanner1.png" alt="American Dive Bars"/> -->
            	<?php } ?>
          </div>
        </div>
   	</div>
	</div>
  </div>
 
 
 <div class="wrapper row5 forum-listing" style="border:<?php echo $getimagename->find_article_state==0 ? 'none':'';?>">
     	<div class="container">
     		<div class="result_search">
     			<div>
	     			<div class="result_search_text pull-left">Articles</div>
	            </div>
	            <div class="clearfix"></div>
     		</div>
     		
     		<div class="mar_top20">
	     		<div class="left_block">
	     			<!-- <h1 class="yellow_title padb25">Forum Category : Test Category</h1> -->
	     			<div class="blog-mainblock">
	     				<ul>
	     					<li>
				     			<div class="blog-block">
		     						<h1 class="yellow_title"><?php echo $blog_detail["blog_title"]; ?>
		     							<ul class="social_icon pull-right">
						<li><span style="float: left; margin-top: 7px; font-size: 14px; color: #fff;"> Share:</span></li>
					<?php 
						 $url_share = site_url("article/detail/".base64_encode($blog_detail["blog_id"])) ;
						 $title=urlencode($blog_detail["blog_title"]);
						 $url=urlencode($url_share);
						 $summary=urlencode($blog_detail["blog_description"]);
						// $image=urlencode(base_url().'upload/video_image/'.$video_title["video_image"]); 
						 $image=urlencode(base_url().'upload/no_img.jpg'); 
						 if($blog_detail["blog_image"] != "" && is_file(base_path()."upload/blog_orig/".$blog_detail["blog_image"]))
						 {
						   $image=urlencode(base_url().'upload/blog_orig/'.$blog_detail["blog_image"]); 
						 }
						 
					?>
						
		  				<!-- <li><a onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $title;?>&amp;p[summary]=<?php echo $summary;?>&amp;p[url]=<?php echo $url; ?>&amp;p[images][0]=<?php echo $image;?>','sharer','toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)"><img src="<?php echo base_url();?>default/images/result_fb.png"/></a></li> -->
		  				<li><a onClick="fbShare();" data-image='<?php echo $img; ?>' href="javascript: void(0)"><img src="<?php echo base_url();?>default/images/result_fb.png"/></a></li>
	  					<li><a href="javascript:void(0)" onclick="window.open('http://twitter.com/home?status=<?php echo $url_share;?>','sharer','toolbar=0,status=0,width=548,height=325')"><img src="<?php echo base_url();?>default/images/result_twitt.png"/></a></li>
	  					<li><a href="javascript:void(0)" onclick="window.open('https://plusone.google.com/_/+1/confirm?hl=en&url=<?php echo $url_share;?>','sharer','toolbar=0,status=0,width=548,height=325')"><img src="<?php echo base_url();?>default/images/result_google.png"/></a></li>
	  					 <li><a  href="javascript://" onclick="piShare()"><img src="<?php echo base_url().'default'?>/images/result_p.png"></a></li>
					    <div class="clearfix"></div>
		    		 </ul>
		     						</h1>
		     						<div class="bloguser-strip">
		     							<ul class="usericon-list">
		     								<li><i class="glyphicon glyphicon-time"></i><?php echo date($site_setting->date_format,strtotime($blog_detail["date_added"])); ?></li>
		     								<li><i class="glyphicon glyphicon-tags"></i><?php if($blog_detail["user_id"]>0){ echo $blog_detail["first_name"]." ".$blog_detail["last_name"];}else { echo "ADB"; } ?></li>
		     								<li><i class="glyphicon glyphicon-comment"></i><?php echo count_blog_comment($blog_detail["blog_id"]); ?> Comments</li>
		     								<?php if(get_authenticateUserID()){?>
		     								<li id="ratedli"><?php if($check_already_retade ==1)
	  								{?>
	  										<?php echo get_blog_rating($blog_detail["blog_id"]); ?></li>
	  								<?php }
									else
										{?>
											<div id="star1" class="rating">&nbsp;
	  									<input type="hidden" name="rating" id="rating" value="" />
	  									</div>
	  									
	  									<?php //echo get_blog_rating($blog_detail["blog_id"]); ?></li>
										<?php } }
	  								?>
		     								<div class="clearfix"></div>
		     							</ul>
		     						</div>
		     						<div>
		     							 <?php 
										if($blog_detail['blog_image']!="" && is_file(base_path().'upload/blog_thumb/'.$blog_detail['blog_image'])){ ?>
											<img src="<?php echo base_url().'upload/blog_thumb/'.$blog_detail['blog_image']; ?>" class="img-responsive" />
										<?php
										}
										else{?>
										<img class="img-responsive"  src="<?php echo $theme_url.'/images/smallbanner1.png'; ?>" />
								<?php } ?>
		     						</div>
		     						<div class="result_desc mart10">
						       			<?php echo $blog_detail["blog_description"]; ?>
						       		</div>
		     					</div>
		     					<div class="clearfix"></div>
	     					</li>
	     				</ul>
	     				<div>
	     				
						
						
						
						<div class="clearfix"></div>
						<!-- <div class="review pull-left marr_10"><a href="#">Upload</a></div>
						<div class="review pull-left"><a href="#">Add Post</a></div>
						<div class="clearfix"></div> -->
					</div>
					<div  class="br_bott_gray padb25"></div>
					<div class="result_search">
	     				<div class="result_search_text">Comments</div>
     				</div>
     				
     				<div class="mar_top20">
	     		<div class="">
	     			<div class="error hide1" id="cm-err-main">&nbsp;</div>
					<form id="add-comment" name="add-comment" enctype="multipart/form-data" method="post" action="<?php echo site_url("article/add_comment"); ?>">
		     			<div>
							<input type="text" class="wid215 form-control form-pad wid60" id="comment_title" placeholder="Tell us what you think!" name="comment_title" />							
							<div class="profile_menu" style="display: none;">
		  					<!-- <div> -->
			  					<textarea id="comment" name="comment" class="form-control wid60 form-pad" placeholder="Write Here" rows="4"></textarea>
			  			
			  			
			  				<!-- </div> -->
			  				<div class="mart10">
								
		  						<!-- <div class="browse_photo pull-left">
									<input type="file" id="comment_image" name="comment_image" class="browse" value="">
									<div class="clearfix"></div>
								</div> -->
															
								<input type="hidden" class="blog_id" id="blog_id" name="blog_id" value="<?php echo $blog_detail["blog_id"]; ?>">
								<input type="hidden" class="user_id" id="user_id" name="user_id" value="<?php echo $this->session->userdata("user_id"); ?>">
								<button type="submit" class="btn btn-lg btn-primary">Post</button>
		  						<div class="clearfix"></div>
		  						
			  				</div>
			  				<div class="clearfix"></div>
  						</div>
						
						
						<div class="clearfix"></div>
						
					</div>
					</form>
				<?php //} ?>
					<div  class="br_bott_gray padb25"></div>
					<div class="mar_top20" id="beer-comment-box">
						<ul class="bottom_box">
							<?php 
							if($blog_comment>0){ 
							foreach($blog_comment as $bc){?>
			         		<li id="comment_<?php echo $bc->blog_comment_id; ?>">
			         			<div class="media">
								    <a class="user_img_link" href="<?php echo site_url('user/profile/'.base64_encode($bc->user_id)); ?>">
										<img src="<?php echo base_url();?>upload/user_thumb/<?php if($bc->profile_image!="" && is_file(base_path().'upload/user_thumb/'.$bc->profile_image)){ echo $bc->profile_image; } else{ echo 'no_img.png';}?>" class="img-responsive br_green_yellow"/>
								    </a>
								    <div class="media-body">
								       <div><h4 class="media-heading">
								       	 <?php if($bc->user_id!=0){?><a href="<?php echo site_url('user/profile/'.base64_encode($bc->user_id));?>" class="bar_title"><?php echo $bc->first_name.' '.$bc->last_name; ?><?php } else {?><a href="javascript://" class="bar_title">ADB<?php } ?></a></h4></div>
								       <div id="f_<?php echo $bc->blog_comment_id; ?>" class="result_desc wid100 more"><?php echo $bc->comment; ?></div>
								       <div class="reviewlabel mar_top5"><?php echo date('d M',strtotime($bc->date_added)); ?> By <?php echo $bc->first_name.' '.$bc->last_name; ?> <?php echo getDuration($bc->date_added); ?></div>
											
										<form class="mysubadb" id="add-subcomment-<?php echo $bc->blog_comment_id; ?>" name="add-subcomment-<?php echo $bc->blog_comment_id; ?>" enctype="multipart/form-data" method="post" action="<?php echo site_url("article/add_subcomment"); ?>">
								    
								    		<div class="mart10">
											<?php //if($this->session->userdata("user_id")!=""){?>
								    			<a id="status<?php echo $bc->blog_comment_id; ?>" class="bar_title sp_reply sprp_<?php echo $bc->blog_comment_id; ?>">Reply</a>
											<?php //} ?>
								    			<div class="post_block1 wid82" style="display: none;">
								    					<div class="error" id="cmsub-err-main<?php echo $bc->blog_comment_id; ?>"></div>
								  					<div>
									  					<textarea id="comment" name="comment" class="status form-control form-pad" placeholder="Write Here" rows="4"></textarea>
									  				</div>
									  				
														<input type="hidden" class="blog_id" id="blog_id" name="blog_id" value="<?php echo $bc->blog_id; ?>">
														<input type="hidden" class="master_comment_id" id="master_comment_id" name="master_comment_id" value="<?php echo $bc->blog_comment_id; ?>">
													<div class="mart10">
														<button type="submit" class="btn btn-lg btn-primary">Post</button>
													</div>	
								  						<div class="clearfix"></div>
									  				<div class="clearfix"></div>													
  												</div>												
								    			<div class="clearfix"></div>
								    		</div>
							    		</form>
								    		
								     
								      <div class="wid100" id="beer-comment-list">
								      	<ul id="innersub<?php echo $bc->blog_comment_id; ?>" class="result_sub_box mart10">
											<?php
											//echo $bc->blog_comment_id;
											//echo '<pre>';
											if(isset($blog_subcomment[$bc->blog_comment_id])){
											//print_r($blog_subcomment);
											foreach($blog_subcomment[$bc->blog_comment_id] as $subcm){											
											?>
											
							         		<li id="<?php echo $subcm->blog_comment_id; ?>" class="active pos_rel">
							         			<div class="media">
												    <a class="pull-left" href="<?php echo site_url('user/profile/'.base64_encode($subcm->user_id)); ?>">
												    	
														<img src="<?php echo base_url();?>upload/user_thumb/<?php if($subcm->profile_image!="" && is_file(base_path()."upload/user_thumb/".$subcm->profile_image)){ echo $subcm->profile_image; } else{ echo 'no_img.png';}?>" class="user_img"/>
												    
												    
												    </a>
												    <div class="media-body">
														<?php
														$dlt_status = comment_blog_rights($this->session->userdata("user_id"),$subcm->blog_comment_id);
														if($dlt_status=='yes'){
														?>
												    	<a href="javascript:void(0);" class="remove_subcomment" name="<?php echo $subcm->blog_comment_id; ?>"><i class="strip close_icon"></i></a>
														<?php } ?>
												        <div><h4 class="media-heading"><a href="<?php echo site_url('user/profile/'.base64_encode($subcm->user_id)); ?>" class="bar_title"><?php echo $subcm->first_name.' '.$subcm->last_name; ?></a></h4></div>
												        <div id="g_<?php echo $bc->blog_comment_id; ?>"  class="result_desc more"><?php echo $subcm->comment; ?></div> 
												        <div class="reviewlabel mar_top5"><?php echo date('d M',strtotime($subcm->date_added)); ?> By <?php echo $subcm->first_name.' '.$subcm->last_name; ?> <?php echo getDuration($subcm->date_added); ?></div>
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
					</div>
	     			
	     		</div>
	     		<!-- <div class="clearfix"></div> -->
	     		
	     		<div class="clearfix"></div>
	     	</div>
	     			
	     			</div>
	     			
		     		<div class="clearfix"></div>
	     		</div>
	     		<div class="right_block_releated">
	     			
	     			<div class="text-left ">
	     				<h1 class="productbar_title">Recent</h1>
	     				<div class="clearfix"></div>
	     				<ul class="review_block">
	     					<?php
	  		if($recent_blog)
	  		{
	  			foreach($recent_blog as $rs)
	  			{?>
		     				<li>
		     					<div class="pull-left marr_10">
		     						
		            			
		            			<?php 
										if($rs->blog_image!="" && is_file(base_path().'upload/blog_thumb_50by50/'.$rs->blog_image)){ ?>
											<img style="width: 75px; height: 75px;"  src="<?php echo base_url().'upload/blog_thumb_50by50/'.$rs->blog_image; ?>" class="img-responsive" />
										<?php
										}
										else{?>
										<img style="width: 75px; height: 75px;" class="img-responsive" src="<?php echo base_url()?>/upload/no-image.png" alt="American Dive Bars"/>
								<?php } ?>
		     					</div>
		     					<div class="related_beer_block">
			     					<div><a class="bar_title" href="<?php echo site_url("article/detail/".base64_encode($rs->blog_id));?>"> <?php echo $rs->blog_title; ?> </a></div>
			     					<p class="result_desc"><?php 
	  							$content = preg_replace("/<p[^>]+\>/i", " ", $rs->blog_description); 
	  								echo  strip_tags(substr($content,0,50))."...";
							 ?></p>
			     					<div class="clearfix"></div>
		     					</div>
		     					<div class="clearfix"></div>
		     				</li><div class="clearfix"></div>
		     				<?php } } ?>
		     			
		     				
		     			</ul>
	     			</div>
	     		</div>
	     		<div class="clearfix"></div>
     		</div>
     		
   		</div>
   	</div> 

<!-- ########################################################################################### -->
<script type="text/javascript">

function piShare()
{
	var width  = 600,
        height = 500,
         left   = ($(window).width()  - width)  / 2,
         top    = ($(window).height() - height) / 2,
        url    = 'http://www.pinterest.com/pin/create/button/?url=<?php echo site_url('article/detail/'.base64_encode($blog_detail['blog_id'])); ?>&media=<?php echo $img; ?>&description=<?php //echo $bar_detail['bar_desc']; ?>',
        opts   = 'status=1' +
                 ',width='  + width  +
                 ',height=' + height +
                 ',top='    + top    +
                 ',left='   + left;
    
    window.open(url, 'Pinterest', opts);
 
    return false;
}
	 $(document).ready(function () {
    	
//for rating//
	
	
	// newsletter submit//
	$("#add-commendt").validate({
        rules: {
            comment_title: { required: true },
            comment: { required: true },
           
        },
       
        submitHandler: function(form) {
           
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
</script>



 <div itemscope itemtype="http://schema.org/LocalBusiness" style="display:none;">
   	

		<span itemprop="name"><?php echo $blog_detail["blog_title"];?></span>
		<div itemprop="description"><?php echo $blog_detail["blog_description"]; ?></div>
			<span itemprop="ratingCount"><?php echo get_blog_rating_count($blog_detail["blog_id"]); ?></span>

			
			
			
			
	</div>
	
