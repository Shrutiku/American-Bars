<style>
.morecontent span {
    display: none;
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

<script>
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
	$(document).ready(function() {
		
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
      $(".morelink").click(function(){
         $("#myModalnew_open").modal('show');
    });
     }); 
</script>

<?php
		          		if($beer_detail['beer_image']!="" && file_exists(base_path().'upload/beer_thumb/'.@$beer_detail['beer_image']))
					{?>
		            	<?php $img =  base_url().'/upload/beer_thumb/'.$beer_detail['beer_image']; ?>
		            	<?php }  else { ?>
		            		<?php $img =  base_url().'/upload/beer_thumb/no_image.png'; ?>
		            		<?php } ?>
		            		
		            			            		
<?php $theme_url = $urls= base_url().getThemeName();?>
<input type="hidden" name="sess_id" id="sess_id" value="<?php echo check_user_authentication()=="" ? '0':'1';?>" />
<style type="text/css">
	/*//.rating {margin: 0em !important;width:100px;} */
</style>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/rating.js"></script>
<script type="text/javascript" src="<?php echo $theme_url; ?>/js/jquery_form.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/js/rating.css" />
<script type="text/javascript">
	
function piShare()
{
	var width  = 600,
        height = 500,
         left   = ($(window).width()  - width)  / 2,
         top    = ($(window).height() - height) / 2,
        url    = 'http://www.pinterest.com/pin/create/button/?url=<?php echo site_url('beer/detail/'.$beer_detail['beer_slug']); ?>&media=<?php echo $img; ?>&description=<?php //echo $bar_detail['bar_desc']; ?>',
        opts   = 'status=1' +
                 ',width='  + width  +
                 ',height=' + height +
                 ',top='    + top    +
                 ',left='   + left;
    
    window.open(url, 'Pinterest', opts);
 
    return false;
}
		  $(document).ready(function() {
		  	
		        $('#menu').click(function() {
		                $('.profile_menu').slideToggle("slow");
		        });
		        
		        $('#comment_title').click(function() {
		        	<?php if($this->session->userdata('user_type')=='taxi_owner'){?>
  	    	  $.growlUI('<?php echo NO_RIGHT; ?>');
  	    	   $(".growlUI strong").empty();
  	    	  return false;
  	    <?php } ?> 
					// var uid = '<?php //echo $this->session->userdata("user_id"); ?>';
					// if(uid!=""){
						// $('.profile_menu').slideDown("slow");
					// }
					// else{					
						// window.location.href='<?php //echo site_url("beer/add_subcomment/".$beer_detail["beer_id"]); ?>';
			           	// return false;
					// }
					
					if($('#sess_id').val()==0)
					{
						<?php $this->session->set_userdata("REDIRECT_PAGE","beer/beer_detail/".$beer_detail["beer_slug"]); ?>
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
		        	<?php if($this->session->userdata('user_type')=='taxi_owner'){?>
  	    	  $.growlUI('<?php echo NO_RIGHT; ?>');
  	    	   $(".growlUI strong").empty();
  	    	  return false;
  	    <?php } ?> 
		        	
		        	if($('#sess_id').val()==0)
					{
						<?php $this->session->set_userdata("REDIRECT_PAGE","beer/beer_detail/".$beer_detail["beer_slug"]); ?>
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
						// window.location.href='<?php //echo site_url("beer/add_comment/".$beer_detail["beer_id"]); ?>';
			           // return false;
					// }
		        });
		         // $('#status2').click(function() {
		                // $('.post_block').toggle("slow");
		        // });
		    });
	</script>
<script type="text/javascript">
	 $(document).ready(function () {
    	
    	testsub();
//for rating//
	$('#star1').rating('www.url.php', {maxvalue:5});
	$(".cancel").hide();
// end of for ratting////	
	$(".star").click(function(){
		var rat = $("#rating").val();
		var bid = '<?php echo $beer_detail["beer_id"]; ?>';
		var uid = '<?php echo $this->session->userdata("user_id"); ?>';
		      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>beer/add_rating",         //the script to call to get data          
        data: {beer_rating: rat,beer_id: bid, user_id: uid},
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
	

	 setTimeout(function () 
	 {
	      $("#wathcv").slideToggle('slow');
     }, 4000);
	 
/* =========================================== REMOVE SUB COMMENT =================================================*/					  
	$('.remove_subcomment').live('click',function(){
		var remove = this.name;
		$.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>beer/remove_subcomment",         //the script to call to get data          
        data: {beer_comment_id:remove},
	    dataType: '',                //data format      
        success: function(data)          //on receive of reply		
            { 
				$('.result_sub_box #'+data).remove();
		    } 
		
        });
	});
/* =========================================== REMOVE SUB COMMENT =================================================*/					  
	 
	 
/* =========================================== LIKE COMMENT =================================================*/					  
	$('.comment_like').live('click',function(){
		<?php if($this->session->userdata('user_type')=='taxi_owner'){?>
  	    	  $.growlUI('<?php echo NO_RIGHT; ?>');
  	    	   $(".growlUI strong").empty();
  	    	  return false;
  	    <?php } ?> 
		var d_cnt = this.name;
		var full_flag = d_cnt.split('#');
		var flag = full_flag[0];
		var bid = '<?php echo $beer_detail["beer_id"]; ?>';
		var uid = '<?php echo $this->session->userdata("user_id"); ?>';
		if($('#sess_id').val()==0)
					{
						<?php $this->session->set_userdata("REDIRECT_PAGE","beer/beer_detail/".$beer_detail["beer_slug"]); ?>
						$('#loginmodal').modal('show');
						return false;
					}
				
		var bcid = full_flag[1];

		$.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>beer/beer_comment_likes",         //the script to call to get data          
        data: {beer_id: bid, user_id: uid,like_flag: flag, beer_comment_id:bcid},
	    dataType: '',                //data format      
        success: function(data)          //on receive of reply		
            { 
				var most_like = data.split('*');
				var flags = most_like[0];
				var total_like = most_like[1];
				if(total_like<=1){
					if(total_like>0){
						total_like =total_like+' Like';
					}
					else{
						total_like ='0 Like';
					}
				}
				else{
					total_like= total_like+' Likes';
				}
				if(flags==0){
					$('#comment_like_'+bcid+' i').removeClass();
					$('#comment_like_'+bcid+' i').addClass('strip dislike');
				}
				else{
					$('#comment_like_'+bcid+' i').removeClass();
					$('#comment_like_'+bcid+' i').addClass('strip like');
				}
				$('#comment_like_'+bcid).attr('name',flags+'#'+bcid);
				$('#total_comment_likes_'+bcid).html(total_like);
		    } 
		
        });
	});
/* =========================================== LIKE COMMENT =================================================*/					  
	 
/* =========================================== LIKE AJAX =================================================*/					  
	$('#total-like').click(function(){
		<?php if($this->session->userdata('user_type')=='taxi_owner'){?>
  	    	  $.growlUI('<?php echo NO_RIGHT; ?>');
  	    	   $(".growlUI strong").empty();
  	    	  return false;
  	    <?php } ?> 
		var flag = this.name;
		var bid = '<?php echo $beer_detail["beer_id"]; ?>';
		var uid = '<?php echo get_authenticateUserID(); ?>';
		
		// if(uid=="")
		// {
			// //window.location.href='<?php //echo site_url("beer/beer_likes/".$beer_detail["beer_id"]); ?>';
			// //return false;
		// }
		
	//	alert($('#sess_id').val())
		if($('#sess_id').val()==0)
		{
			<?php $this->session->set_userdata("REDIRECT_PAGE","beer/detail/".$beer_detail["beer_slug"]); ?>
			$('#loginmodal').modal('show');
			return false;
		}
		
		$.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>beer/beer_likes",         //the script to call to get data          
        data: {beer_id: bid, user_id: uid, like_flag:flag},
	    dataType: '',                //data format      
        success: function(data)          //on receive of reply		
            {  
			var main = data.split('*');
			//alert(main[0]);
			   if(main[0]==1){
				   $('#total-like').attr('name','0');
				   $('#total-like').html('Disike This Beer');
				   $('.likeduser').append(main[1]);	
			   }
			   else{
				   $('#total-like').attr('name','1');
				   $('#total-like').html('Like This Beer');
				   $('#'+main[1]).remove();
				}
		    } 
		
        });
	});
	
	$('#total-fav').click(function(){
		<?php if($this->session->userdata('user_type')=='taxi_owner'){?>
  	    	  $.growlUI('<?php echo NO_RIGHT; ?>');
  	    	   $(".growlUI strong").empty();
  	    	  return false;
  	    <?php } ?> 
		var flag = this.name;
		var bid = '<?php echo $beer_detail["beer_id"]; ?>';
		var uid = '<?php echo get_authenticateUserID(); ?>';
		
		// if(uid=="")
		// {
			// //window.location.href='<?php //echo site_url("beer/beer_likes/".$beer_detail["beer_id"]); ?>';
			// //return false;
		// }
		
	//	alert($('#sess_id').val())
		if($('#sess_id').val()==0)
		{
			<?php $this->session->set_userdata("REDIRECT_PAGE","beer/detail/".$beer_detail["beer_slug"]); ?>
			$('#loginmodal').modal('show');
			return false;
		}
		
		$.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>beer/beer_fav",         //the script to call to get data          
        data: {beer_id: bid, user_id: uid, fav_flag:flag},
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
				   $('#total-fav').html('Add to My Beer List');
				   $( "#total-fav" ).removeClass( "active" );
				}
		    } 
		
        });
	});
	
	
	$("#add-comment222").validate({
        rules: {
            comment_title: { required: true },
            comment: { required: true },
           
        },
       
        submitHandler: function(form) {
           
			     $("#add-comment").ajaxForm({
        type: "POST",
     ////   url: "<?php //echo base_url(); ?>beer/add_comment",   
		 ///data: $("#add-comment").serialize(),  
        dataType: 'json',                //data format      
        success: function(data)          //on receive of reply
            {
			  
			     $("#comtmsg").html(data);   
			    $("#comtmsg").show();
			    
			  // setTimeout(function () 
			//	 {
				      $("#comtmsg").fadeOut('slow');
				     
				      
				      $(':input','#add-comment')
						 .not(':button, :submit, :reset, :hidden')
						 .val('')
						 .removeAttr('checked')
						 .removeAttr('selected');
						 
						location.reload(true);
												 
				//}, 2000);
				
				
            } 
		
        });
          
        }
    }); //end validate
	///////////// comment......///////////////
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
  
    success : function ( json ) {
	
	
	
	if(json.status == "fail")
	{
		$("#cm-err-main").show();
		$("#cm-err-main").html(json.comment_error);
	    $('#dvLoading').fadeOut('slow')
		 // setTimeout(function () 
			//	 {
				    //  $("#cm-err-main").fadeOut('slow');
												 
			//	}, 3000);
				
		 
		return false;
	}
	
	else
	{
		
		$("#cm-err-main").hide();
		$("#cm-err-main").html("");
	}
	var cmdt = formatDate(json.date_added);
	var data = '';
	data ='<li id="comment_'+json.beer_comment_id+'"><div class="media"><a class="user_img_link" href="<?php echo site_url("user/profile/".@base64_encode(get_authenticateUserID())); ?>">';
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
	data +='<div class="result_desc wid100">'+json.comment_title+'</div><div class="reviewlabel mar_top5">';
	data +='<div class="result_desc wid100">'+json.comment+'</div><div class="reviewlabel mar_top5">';
	data +='<div class="reviewlabel mar_top5">'+json.cust_date+' By '+ json.first_name+' '+ json.last_name +' '+json.date_duration +'</div>';

	if(json.comment_image!='')
	{
	     data += '<div class="mar_top20"><div class="pos_rel wid100"><img src="<?php echo base_url(); ?>upload/comment_image/'+json.comment_image+'" class="photo_img br_green_yellow" /></div></div>'
	}
		if(json.comment_video!='')
		{
			// data += '<br /><div class="pos_rel wid100"><div width="640" height="246" controls><object width="640" height="246" id="vpalyobj'+json.comment_video+'" name="vpalyobj'+json.comment_video+'" data="http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf" type="application/x-shockwave-flash"><param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf" /><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="true" />';
			// data += '<param name="flashvars" value="" id="test" />';
			// data += '</object></div></div>';
			data += '<div class="mar_top20">'+json.testdd+'</div>';
		}		
		data +='<form id="add-subcomment-'+json.beer_comment_id+'" class="mysubadb" name="add-subcomment-'+json.beer_comment_id+'" enctype="multipart/form-data" method="post" action="<?php echo site_url("beer/add_subcomment"); ?>"><div class="mart10">';
		data +='<a href="javascript:void(0);" id="comment_like_'+json.beer_comment_id+'" class="comment_like" name="2#'+json.beer_comment_id+'"><i class="strip like"></i></a><p class="result_desc pull-left mar_right20" id="total_comment_likes_'+json.beer_comment_id+'">0 Like</p><a id="status'+json.beer_comment_id+'" class="bar_title sp_reply sprp_'+json.beer_comment_id+'">Reply</a><div class="post_block1 wid82" style="display: none;"><div><textarea id="comment" name="comment" class="status form-control form-pad" placeholder="Write Here" rows="4"></textarea></div><div class="mart10"><input type="file" class="wid215 form-control wid60" id="comment_image" name="comment_image" value=""><input type="hidden" class="beer_id" id="beer_id" name="beer_id" value="'+json.beer_id+'"><input type="hidden" class="master_comment_id" id="master_comment_id" name="master_comment_id" value="'+json.beer_comment_id+'"><div class="mart10"><button type="submit" class="btn btn-lg btn-primary">Post</button></div><div class="clearfix"></div></div><div class="clearfix"></div></div><div class="clearfix"></div></div></form>';
		data +='<div class="wid100"><ul id="innersub'+json.beer_comment_id+'" class="result_sub_box mart10"></ul></div>';
		
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

	/// end of cooment/////////////////////

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
		//  setTimeout(function () 
		//		 {
				      $("#cmsub-err-main"+json.master_comment).show('slow');
				      
				      $(':input','.mysubadb')
						 .not(':button, :submit, :reset, :hidden,:text')
						 .val('')
						 .removeAttr('checked')
						 .removeAttr('selected');
												 
		//		}, 3000);
				
		 
		return false;
	}
	
	else
	{
		
		//$("#cmsub-err-main"+json.master_comment).remove();
		$("#cmsub-err-main"+json.master_comment_id).hide();
		$("#cmsub-err-main"+json.master_comment_id).html("");
		
	}
	
	//validation end//
	var forsplit = $('.mysubadb').attr('id');
	
	//var mainid =forsplit.split('-');
	//var appendli = mainid[2];
	var cmdt = "";
	var data = '';
	data ='<li class="active pos_rel" id="'+json.beer_comment_id+'"><div class="media"><a class="pull-left" href="<?php echo site_url("user/profile/".@base64_encode(get_authenticateUserID())); ?>">';
	if(json.profile_image!='')
	{
	     data += '<img src="<?php echo base_url(); ?>upload/user_thumb/'+json.profile_image+'" class="user_img" />';
	}
	else
	{
	    data += '<img src="<?php echo base_url(); ?>upload/user_thumb/no_img.png" class="user_img" />';
	}
	
	data += '</a>';
	data +='<div class="media-body"><a href="javascript:void(0);" class="remove_subcomment" name="'+json.beer_comment_id+'"><i class="strip close_icon"></i></a><h4 class="media-heading"><a href="<?php echo site_url("user/profile/".@base64_encode(get_authenticateUserID())); ?>" class="bar_title">'+json.first_name+' '+ json.last_name +'</a></h4>';
	data +='<div class="result_desc wid100">'+json.comment+'</div><div class="reviewlabel mar_top5">';
	data +='<div class="reviewlabel mar_top5">'+json.cust_date+' By '+ json.first_name+' '+ json.last_name +' '+json.date_duration +'</div>';

		if(json.comment_image!='')
		{
			 data += '<div class="mar_top20"><div class="pos_rel wid100"><img src="<?php echo base_url(); ?>upload/comment_image/'+json.comment_image+'" class="photo_img br_green_yellow" /></div></div>';
		}
		if(json.comment_video!='')
		{
		//alert('<param name="flashvars" value="config='+JSON.stringify(json.testdd)+'" />');
			 data += '<div class="pos_rel wid100"><div width="640" height="246" controls><object width="640" height="246" id="vpalyobj'+json.comment_video+'" name="vpalyobj'+json.comment_video+'" data="http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf" type="application/x-shockwave-flash"><param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf" /><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="true" />';
			//data += '<param name="flashvars" value="config={playlist:[{"url":"<?php //echo base_url(); ?>upload/comment_video/'+json.comment_video+'","autoPlay":false}]}" />';
			 data += '<param name="flashvars" value="" id="subtest" />';
			 data += '</object></div></div>';
		}
		

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

function fbShare(){
	window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('<?php echo site_url('beer/detail/'.$beer_detail['beer_slug']); ?>'),'facebook-share-dialog','width=626,height=436');
            return false;
}
</script>
<!-- ########################################################################################### -->
<!-- content -->
<div class="wrapper row5">
     	<div class="container">
     	<div class="beer_details">
     		<div class="pull-left">
     			<?php if(isset($prevbeer->beer_slug)){?>
     			<a href="<?php echo site_url('beer/detail/'.$prevbeer->beer_slug);?>" class="btn btn-lg btn-primary btn-block mar_bot10 ">Back</a>
     				<?php } ?>
     			</div>
     		<div class="pull-right">
     			<?php if(isset($nextbeer->beer_slug)){?>
     			<a href="<?php echo site_url('beer/detail/'.$nextbeer->beer_slug);?>" class="btn btn-lg btn-primary btn-block mar_bot10 ">Next</a>
     			<?php } ?>
     							
     			</div><div class="clear"></div>
     		<div class="result_search">
	     		<div class="result_search_text">Beer Details</div>
     		</div>
     		<div class="br_bott_yellow">
     			<div class="bar_details lol4">
     				<div class="media">
     						<div class="pull-left wid215">
							    <a  href="javascript:void(0);">
							     <?php 
										if($beer_detail['beer_image']!="" && is_file(base_path().'upload/beer_thumb/'.$beer_detail['beer_image'])){ ?>
											<img src="<?php echo base_url().'upload/beer_thumb/'.$beer_detail['beer_image']; ?>" id="beer-image" class="img-responsive" />
										<?php
										}
										else{?>
										<img  src="<?php echo base_url().'upload/beer_thumb/no_image1.png'; ?>" id="beer-image"/>
								<?php } ?>
							    </a>
							    <div class="mart10 text-center">
						    		<?php
						    		// if($this->session->userdata('user_type')!='bar_owner')
		//{
						    		 $cnt_fav = fav_checker($beer_detail['beer_id'],$this->session->userdata('user_id')); 
											if($cnt_fav==2 && get_authenticateUserID()!=''){
											?>
											<a id="total-fav" href="javascript:void(0);" name="2" class="btn btn-lg btn-primary mart10"> Add to My Beer List</a>
											<!-- <a id="total-like" href="javascript:void(0);" name="2" class="btn btn-lg btn-primary">Like</i></a> -->
											<?php
											} elseif(get_authenticateUserID()!=''){?>
												
											<a id="total-fav" href="javascript:void(0);" name="<?php if($cnt_fav==1){ echo $cnt_fav=0;} else{ echo $cnt_fav=1; } ?>" class="btn btn-lg btn-primary mart10">
											<?php if($cnt_fav==1){ echo 'Add to My Beer List'; } else{ echo 'Remove Favorite'; } ?></a>
											<?php } else { ?>
												<a id="total-fav" class="btn btn-lg btn-primary" href="javascript:void(0);" name="1" >Add to My Beer List</a>
												  
											<?php } //}?>	
											
											
											<?php $cnt_like = like_checker($beer_detail['beer_id'],$this->session->userdata('user_id')); 
											
											if($cnt_like==2 && get_authenticateUserID()!=''){
											?>
											<a id="total-like" href="javascript:void(0);" name="2" class="btn btn-lg btn-primary mart10">Like This Beer</i></a>
											<?php
											} elseif(get_authenticateUserID()!='') {?>
											<a id="total-like" href="javascript:void(0);" name="<?php if($cnt_like==1){ echo $cnt_like=0;} else{ echo $cnt_like=1; } ?>" class="btn btn-lg btn-primary mart10">
											<?php if($cnt_like==1){ echo 'Like This Beer'; } else{ echo 'Dislike This Beer'; } ?></i></a>
											<?php } else { ?> 
											<a id="total-like" href="javascript:void(0);" name="1" class="btn btn-lg btn-primary mart10">
											Like This Beer</a>
											<?php  } ?>
						    	</div>
						    </div> 
						    <div class="media-body">
						       <div class="reult_sub_title"><h4 class="media-heading"><a href="javascript:void(0);" class="bar_title"><?php echo $beer_detail['beer_name']; ?></a></h4></div>
						       <div class="clearfix"></div>
							      <div class="mart10">
						        	<ul class="beerdirectory">
						        		<li>
						        			<div class="pull-left yellow_text marr_10 wid25">Brewed by : </div>
						        			<div class="pull-left white_text wid75"><?php echo $beer_detail['producer']; ?></div>
						        			<div class="clearfix"></div>
						        		</li>
						        		<li>
											<div class="pull-left yellow_text marr_10 wid25">City Produced : </div>
											<div class="pull-left white_text wid75"><?php echo $beer_detail['city_produced']; ?></div>
											<div class="clearfix"></div>
										</li>
						        		<li>
						        			<div class="pull-left yellow_text marr_10 wid25">Type : </div>
						        			<div class="pull-left white_text wid75"><?php echo $beer_detail['beer_type']; ?></div>
						        			<div class="clearfix"></div>
						        		</li>
						        		<li>
						        			<div class="pull-left yellow_text marr_10 wid25">Website : </div>
						        			<div class="pull-left white_text wid75"><a onclick="window.open('<?php echo $beer_detail['beer_website']; ?>', '_blank', 'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0');" href="javascript:void(0);"><?php echo $beer_detail['beer_website']; ?></a></div>
						        			<div class="clearfix"></div>
						        		</li>
						        		<li>
						        			<div class="pull-left yellow_text marr_10 wid25">ABV : </div>
						        			<div class="pull-left white_text wid75"><?php echo $beer_detail['abv']; ?></div>
						        			<div class="clearfix"></div>
						        		</li>
						        		<li><?php $site_setting = site_setting();
						        			
						        			?>
						        			<!-- <div class="white_text">Beer was Added on a <?php echo date($site_setting->date_format,strtotime(str_replace('-','/',$beer_detail['date_added']))); ?> by <span class="yellow_text"><?php echo $beer_detail['producer']; ?></span> </div> -->
						        		</li>
										<?php //if($this->session->userdata("user_id")!=""){?>
						        		
						        		
						        		<li>
						        			<!-- <div class="result_desc more">
						        				 <?php 
						       	   $text=str_ireplace('<p>','',$beer_detail['beer_desc']);
									$text=str_ireplace('</p>','',$text); 
								echo $text;?>
						       	   
						       </div>  -->
						       <div class="yellow_title">Description:</div>
						       <div class="result_desc">
						       	<?php if(strip_tags(strlen($beer_detail['beer_desc'])>350)){ echo substr(strip_tags($beer_detail['beer_desc']),0,350).'...<a class="morelink more pull-right" href="javascript://"><i class="strip arrow_down"></i>Show more</a>' ; } else { echo strip_tags($beer_detail['beer_desc']); } ?>
						       	   						       	  <?php  
						       	  // $text=str_ireplace('<p>','',$beer_detail['beer_desc']);
									//$text=str_ireplace('</p>','',$text); 
								//echo $text;?> 
						       </div>
						        		</li>
						        		
										<?php //} ?>
						        	</ul>
						         </div>
						        
						    </div>
				    	</div>
				    	<div class="clearfix"></div>
     			</div>
     			<div class="right_gallery_block">
					<div class="mar_top20">
						<?php 
						if($beer_detail['upload_type']=='image')
						{
							
							if($beer_detail['image_default']!="" && is_file(base_path().'upload/beer_thumb/'.$beer_detail['image_default'])){ ?>
									<img src="<?php echo base_url().'upload/beer_thumb/'.$beer_detail['image_default']; ?>" class="br_green_yellow img-responsive" />
								<?php
								}
							
							 else{?>
									<img src="<?php echo base_url().'default'?>/images/cocktail-default.png" alt="American Dive Bars" />
									<?php } } elseif($beer_detail['upload_type']=='video' && $beer_detail['video_link']!='') {  ?>
										
					<?php
            //print_r($site_setting);
            if($beer_detail['video_link']!=''){
            $url	=	$beer_detail['video_link'];
				if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',$url,$matches)) {
					//echo $url;
				      //preg_match('/[\\?\\&]v=([^\\?\\&]+)/',$url,$matches);
				      //preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',$url,$matches);
							if(isset($matches[1])){
							$id = $matches[1];
								echo '<iframe class="" width="100%" height="222" src="//www.youtube.com/embed/'.$id.'?rel=0" frameborder="0" allowfullscreen></iframe>';
							}else{
								echo $url;
							}
				    } elseif (strpos($url, 'vimeo') > 0) {
				    	preg_match('~^http://(?:www\.)?vimeo\.com/(?:clip:)?(\d+)~',$url,$matches);
				//	$parsed = parse_url($url);
					//print_r($parsed);
				       if(isset($matches[1])){
							$id = $matches[1];
							echo '<iframe width="397" height="222" src="//player.vimeo.com/video/'.$id.'" class="" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> ';	
								
							}else{
								$a=json_decode(file_get_contents('http://vimeo.com/api/oembed.json?url='.$url));
								
								if(isset($a->video_id) && $a->video_id!=''){
								$id=$a->video_id;
									echo '<iframe width="397" height="222" src="//player.vimeo.com/video/'.$id.'" class="" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> ';	
								}
							}
				    }
				    }
            ?>
				   <?php } else { ?>
				   	
				   	<!-- <img src="<?php echo base_url().'default'?>/images/cocktail-default.png" alt="American Dive Bars" /> -->
				   	<div class="gallery-default">
				   		No Beer image or Video Available
				   	</div>
				   	<?php } ?>						
						
					</div>
						<div class="clearfix"></div>
					
				
     				<div class="like-block mar_top20 text-right min-height265">
     					<div class="bar_add mar_bot10">We Liked This Beer : </div>
	     				<ul class="likeduser marl_0">
							<?php 
							if(count($beer_liker) > 0){
							$j=1;
							foreach($beer_liker as $bl){
								 
							if($j<=10){
							?>							
	     					<li id="user_<?php echo $bl->user_id;?>" class="active"><a href="<?php echo site_url('user/profile/'.base64_encode($bl->user_id));?>"><img src="<?php echo base_url();?>upload/user_thumb/<?php if($bl->profile_image!="" && is_file(base_path().'upload/user_thumb/'.$bl->profile_image)){ echo $bl->profile_image; } else{ echo 'no_img.png';}?>" class="user_img"/></a></li>
							<?php
							}
							$j++;
							 } 
							}?>    					
	     				</ul><div class="clearfix"></div>
	     				<?php 
							if(count($beer_liker) > 0){ ?>
	     				<a class="bar_title" href="javascript://" id="view-all">View All </a>
	     				<?php } ?>
	     				
     				</div>
     				
     				<div class="mar_top20">
     					<ul class="social_icon mart10">
						<li>Share : </li>
					<?php 
						 $url_share = site_url("beer/beer_detail/".$beer_detail["beer_slug"]) ;
						 $title=urlencode($beer_detail["beer_name"]);
						 $url=urlencode($url_share);
						 $summary=urlencode($beer_detail["beer_desc"]);
						// $image=urlencode(base_url().'upload/video_image/'.$video_title["video_image"]); 
						 $image=urlencode(base_url().'upload/no_img.jpg'); 
						 if($beer_detail["beer_image"] != "" && is_file(base_path()."upload/beer_thumb/".$beer_detail["beer_image"]))
						 {
						   $image=urlencode(base_url().'upload/beer_thumb/'.$beer_detail["beer_image"]); 
						 }
						 
					?>
						
		  				<!-- <li><a onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $title;?>&amp;p[summary]=<?php echo $summary;?>&amp;p[url]=<?php echo $url; ?>&amp;p[images][0]=<?php echo $image;?>','sharer','toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)"><img src="<?php echo base_url();?>default/images/result_fb.png"/></a></li> -->
		  				<li><a onClick="fbShare();" href="javascript: void(0)"><img src="<?php echo base_url();?>default/images/result_fb.png"/></a></li>
	  					<li><a href="javascript:void(0)" onclick="window.open('http://twitter.com/home?status=<?php echo $url_share;?>','sharer','toolbar=0,status=0,width=548,height=325')"><img src="<?php echo base_url();?>default/images/result_twitt.png"/></a></li>
	  					<li><a href="javascript:void(0)" onclick="window.open('https://plusone.google.com/_/+1/confirm?hl=en&url=<?php echo $url_share;?>','sharer','toolbar=0,status=0,width=548,height=325')"><img src="<?php echo base_url();?>default/images/result_google.png"/></a></li>
	  					 <li><a  href="javascript://" onclick="piShare()"><img src="<?php echo base_url().'default'?>/images/result_p.png"></a></li>
					    <div class="clearfix"></div>
		    		 </ul>
     				</div>
     			</div>
     			
     			<div class="clearfix"></div>
     		</div>
     		
     		
     		<div class="mar_top20">
	     		<div class="left_block">
                    <h1 class="productbar_title">Leave a Comment</h1>
	     			<div class="error1 hide1" id="cm-err-main">&nbsp;</div><div class="clearfix"></div>
					<form id="add-comment" name="add-comment" enctype="multipart/form-data" method="post" action="<?php echo site_url("beer/add_comment"); ?>">
		     			<div>
							<input type="text" class="wid215 form-control form-pad wid60" id="comment_title" placeholder="Tell us what you think!" name="comment_title" />							
							<div class="profile_menu" style="display: none;">
		  					<!-- <div> -->
			  					<textarea id="comment" name="comment" class="form-control wid60 form-pad" placeholder="Write Here" rows="4"></textarea>
			  			<div class="mart10">
			  					<input type="text" class="wid215 form-control form-pad wid60" id="comment_video" placeholder="Copy Paste a Video Link" name="comment_video" />
			  			</div>	
			  			
			  			<div class="mart10">
			  				<input  accept="image/*"  type="file" name="comment_image" id="comment_image" class="wid215 form-control wid60" />
			  			</div>	
			  				<!-- </div> -->
			  				<div class="mart10">
								
		  						<!-- <div class="browse_photo pull-left">
									<input type="file" id="comment_image" name="comment_image" class="browse" value="">
									<div class="clearfix"></div>
								</div> -->
															
								<input type="hidden" class="beer_id" id="beer_id" name="beer_id" value="<?php echo $beer_detail["beer_id"]; ?>">
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
					<div id="beer-comment-box">
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
								echo  '<iframe  style="width:702px; height:250px;" class="br_red img-responsive max-height embed_vid_height"  src="//www.youtube.com/embed/'.$id.'?rel=0" frameborder="0" allowfullscreen></iframe>';
							}else{
								echo $url;
							}
				    } elseif (strpos($url, 'vimeo') > 0) {
				    	preg_match('~^http://(?:www\.)?vimeo\.com/(?:clip:)?(\d+)~',$url,$matches);
				//	$parsed = parse_url($url);
					//print_r($parsed);
				       if(isset($matches[1])){
							$id = $matches[1];
							echo  '<iframe style="width:702px; height:250px;" src="//player.vimeo.com/video/'.$id.'" class="br_red img-responsive max-height embed_vid_height" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> ';	
								
							}else{
								$a=json_decode(file_get_contents('http://vimeo.com/api/oembed.json?url='.$url));
								
								if(isset($a->video_id) && $a->video_id!=''){
								$id=$a->video_id;
									echo '<iframe style="width:702px; height:250px;" src="//player.vimeo.com/video/'.$id.'" class="br_red img-responsive max-height embed_vid_height" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> ';	
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
			         	<div class="pagination mart10" id="pagination">
			  			<ul class="pagination">
							<?php echo $page_link; ?>
						</ul>
					</div>
					<div class="clearfix"></div>
					</div>
	     			
	     		</div>
	     		<!-- <div class="clearfix"></div> -->
	     		<div class="right_block_releated">
	     			<div class="text-left">
	     				<h1 class="productbar_title">Related Beers</h1>
	     				<div class="clearfix"></div>
	     				<ul class="review_block">						
						<?php 
							$related_beer = toprelatedbeer($beer_detail['beer_id'],$beer_detail['beer_type'],$beer_detail['producer']);
							if(count($related_beer)>0){ 
							foreach($related_beer as $rb){?>
		     				<li>
		     					<div class="pull-left marr_10">
									<a href="<?php echo site_url("beer/detail/".$rb->beer_slug);?>">
									<?php if ($rb->beer_image!="" && is_file(base_path().'upload/beer_thumb/'.$rb->beer_image)) { ?>
		     						<img src="<?php echo base_url().'upload/beer_thumb/'.$rb->beer_image; ?>" width="50px" height="57px" class=""/>
									<?php }else{ ?>
									<img src="<?php echo base_url();?>upload/beer_thumb/no_image.png" width="50px" height="57px" class=""/>
									<?php } ?>
									</a>
		     					</div>
		     					<div class="related_beer_block">
			     					<div><a href="<?php echo site_url("beer/detail/".$rb->beer_slug);?>" class="bar_title"><?php echo $rb->beer_name; ?></a></div>
			     					<p class="result_desc"><?php if(strlen(strip_tags($rb->beer_desc)>30)){ echo strip_tags($rb->beer_desc).'...'; } else { echo strip_tags($rb->beer_desc); }  ?></p>
			     					<div class="clearfix"></div>
		     					</div>
		     					<div class="clearfix"></div>
		     				</li><div class="clearfix"></div>
							<?php } } 
							else{?>
								<li>Record(s) not found</li>
								
								<?php }?>
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
     						<label class="control-label" style="color: #fff;"><?php echo $beer_detail['beer_desc']; ?></label>	
     				</div>		
     			</div>
     		</div>
     	</div>
     </div>
	
</div>  		
<div class="modal fade" id="myModalnew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
   	</div>
   	
   	
   	
<!-- ########################################################################################### -->
<script>
	
	
    $("#view-all").click(function(){
    	$.ajax({
			         type: "POST",
			         url: "<?php echo site_url('beer/view_all_likers')?>",
			         data : {id:<?php echo $beer_detail['beer_id']; ?>},
			         success: function(response) {
			        	 //$('#myModalnew').modal('show');
			        	  $("#myModalnew").html(response);
			        	   $('#myModalnew').one('shown.bs.modal', function (e) {
    						}).modal();
			           // alert(response);
			        }
			    });
    }) ;
</script>
