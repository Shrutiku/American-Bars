<!-- ########################################################################################### -->
<?php
$theme_url =  base_url().getThemeName();
//$category_videoes = get_article_category_wise($article_detail["article_id"],$article_detail["article_category_id"],3);
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
		var vid = '<?php echo $article_detail["article_id"]; ?>';
		var uid = '<?php echo $this->session->userdata("user_id"); ?>';
		      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>article/add_rating",         //the script to call to get data          
        data: {article_rating: rat,article_id: vid, user_id: uid},
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
        url: "<?php echo base_url(); ?>article/add_comment",         //the script to call to get data          
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