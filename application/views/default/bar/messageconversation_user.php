
<script src="<?php echo base_url().getThemeName(); ?>/js/jquery.timeago.js"></script>
<script>

    function bottomscroll()
    {
    	$('.conver_block').slimscroll({
        alwaysVisible: true,
        height: 700,
        color: '#f19d12',
        opacity: 0.8,
        start: 'bottom',
        scrollBy: '100px',
       // destroy:true
        
      });
    }
    
	function setTimeago(id,dt)
	{
		$(".timeago").timeago();
	}
</script>
<div class="wrapper row6 padtb10 has-js">
     	<div class="container">
     		<div class="margin-top-50 bg_brown">
     			<?php echo $this->load->view(getThemeName().'/home/dashboard_menu'); ?>
     			<div class="dashboard_detail">
     				<div class="result_search event"><div class="result_search_text pull-left"><i class="strip events"></i> Message Subject : <?php echo @ucfirst($subject);?></div><div class="pull-right">
     					<a href="<?php echo site_url('message/list_user_message')?>" class="white pull-right review">Back</a></div><div class="clearfix"></div></div>
     						
     						
     					
     					<div id="list_hide" class="content">	
		     		<div class="dashboard_subblock">
		     			<div class="conver_block">
		     			<div class="pad_t15b20 ">
		     				<div class="chats">
		     				<?php $user_info = get_user_info($from_user_id);
																	//print_r($user_info);
																	$name1 = @$user_info->first_name." ".@$user_info->last_name;
																	$profile_image1 = $user_info -> profile_image;
																	if($profile_image1 != "" && file_exists(base_path()."/upload/user_thumb/".$profile_image1))
																	{
																		$profile_image1 = 'upload/user_thumb/'.$profile_image1;
																	}
																	else
																	{
																		$profile_image1 = 'upload/no-image.png';
																	}	?>
		     			<?php if($from_user_id==get_authenticateUserID()){?> 	
		     					<div class="mar_top20 ">
     							<div class="msg_img marr_10 ">
     							<img class="img-responsive" alt="" src="<?php echo base_url();?><?php echo $profile_image1; ?>" />
     								<i class="strip msg_arrow"></i>
     							</div>
     							<div class="msg_content">
     								<h1 class="msg_username"><?php echo $name1; ?></h1>
     								<p class="dashboard_desc">
     									<?php echo $description;?> 
     								</p>
     								<p class="msg_date"><?php echo getDuration($date_added);?></p>
     							</div>
     							<div class="clearfix"></div>
     						</div>
     						<?php } else {?>
     							<div class="mar_top20">
     							<div class="msg_content reply_bg">
     								<h1 class="msg_username"><?php echo $name1; ?></h1>
     								
     								<p class="dashboard_desc">
     									<?php echo $description;?> 
     								</p>
     								<p class="msg_date"><?php echo getDuration($date_added);?></p>
     							</div>
     							<div class="msg_img marl_10">
     								<img class="img-responsive" alt="" src="<?php echo base_url();?><?php echo $profile_image1; ?>" />
     								<i class="strip msg_reply"></i>
     							</div>
     							<div class="clearfix"></div>
     						</div>
     						<?php } ?>	
     						<?php if($result){
																
																
															foreach($result as $val){
																//$to_user_types = "admin";		
																if($val->from_user_id == get_authenticateUserID()){
																	
																	
																	$user_info = get_user_info($val->from_user_id);
																	
																	$name = @$user_info->first_name." ".@$user_info->last_name;
																	$profile_image = $user_info -> profile_image;
																	if($profile_image != "" && file_exists(base_path()."/upload/user_thumb/".$profile_image))
																	{
																		$profile_image = 'upload/user_thumb/'.$profile_image;
																	}
																	else
																	{
																		$profile_image = 'upload/no-image.png';
																	}	
																
																		
														?>
     						
     						<div class="mar_top20">
     							<div class="msg_img marr_10">
     							<img class="img-responsive" alt="" src="<?php echo base_url();?><?php echo $profile_image; ?>" />
     								<i class="strip msg_arrow"></i>
     							</div>
     							<div class="msg_content">
     								<h1 class="msg_username"><?php echo $name; ?></h1>
     								<p class="dashboard_desc">
     									<?php echo $val->description;?> 
     								</p>
     								<p class="msg_date"><?php echo getDuration($val->date_added);?></p>
     							</div>
     							<div class="clearfix"></div>
     						</div>
     						<?php } else {
     							
     							$user_info = get_user_info($val->from_user_id);
								//print_r($user_info);
																	
																	$name = @$user_info->first_name." ".@$user_info->last_name;
																	$profile_image = $user_info -> profile_image;
																	if($profile_image != "" && file_exists(base_path()."/upload/user_thumb/".$profile_image))
																	{
																		$profile_image = 'upload/user_thumb/'.$profile_image;
																	}
																	else
																	{
																		$profile_image = 'upload/no-image.png';
																	}	
     							?>
     						<div class="mar_top20">
     							<div class="msg_content reply_bg">
     								<h1 class="msg_username"><?php echo $name; ?></h1>
     								
     								<p class="dashboard_desc">
     									<?php echo $val->description;?> 
     								</p>
     								<p class="msg_date"><?php echo getDuration($val->date_added);?></p>
     							</div>
     							<div class="msg_img marl_10">
     								<img class="img-responsive" alt="" src="<?php echo base_url();?><?php echo $profile_image; ?>" />
     								<i class="strip msg_reply"></i>
     							</div>
     							<div class="clearfix"></div>
     						</div>
     						
     						<?php } }
     						} ?>
     						</div>
     						 
     					</div>
     					</div>
     					<div class="msg_textarea">
     						<input type="hidden" name="from_user_id" id="from_user_id" value="<?php echo $from_user_id;?>" />
											<input type="hidden" name="to_user_id" id="to_user_id" value="<?php echo $to_user_id;?>" />
											<input type="hidden" name="user_id" id="user_id" value="<?php echo $to_user_id;?>" />
											
											<input type="hidden" name="Tickets_id" id="Tickets_id" value="<?php echo $message_id ?>" />
										
     							<textarea onkeydown="if (event.keyCode == 13) { $('#post').trigger('click'); return false; }" name="comment" id='comment' class="form-control" rows="5" placeholder="Type your Message here"></textarea>
     							<button class="btn btn-lg btn-primary mart10" id="post" type="submit">Send</button>
     						</div>
		     		</div>
     			<div class="clearfix"></div>
					</div>	
					
     			
     	<div class="clearfix"></div>
     </div>
   </div>
 </div>
<?php $uinfo =   get_user_info(get_authenticateUserID());
$name = $uinfo->first_name." ".$uinfo->last_name;
																	$profile_image = $uinfo -> profile_image;
																	if($profile_image != "" && file_exists(base_path()."/upload/user_thumb/".$profile_image))
																	{
																		$profile_image = 'user_thumb/'.$profile_image;
																	}
																	else
																	{
																		$profile_image = 'no-image.png';
																	}	?> 
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.easing.1.3.js"></script>
  <!--------------Scroll ------------------->
	<link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/css/prettify.css">
	<script src="<?php echo base_url().getThemeName(); ?>/js/jquery.slimscroll.js"></script>
	<script src="<?php echo base_url().getThemeName(); ?>/js/prettify.js"></script>
	<script type="text/javascript">
		$(function(){
		      $('.conver_block').slimscroll({
		        alwaysVisible: true,
		        height: 700,
		        color: '#f19d12',
		        opacity: .8
		      });
		
		  });
	</script>
	<!--------------End Scroll ------------------->
  
    <script>
//$oneTickets['user_id']
var ctime='<?php echo date('Y-m-d H:i:s') ?>';
window.setInterval(function(){
	
	
	var ticketId='<?php echo $message_id ?>';
	var user_type='<?php echo $from_user_type ?>';
	var user_id='<?php echo $from_user_id ?>';
	var to_user_id='<?php echo $to_user_id; ?>';
	var cont = $('#chats');
   var list = $('.chats', cont);
	$.ajax({
		url:'<?php echo site_url('message/getTicketCommentAjax'); ?>',
		type:'POST',
		data:{ctime:ctime,ticket_id:ticketId,replyBy:user_type,user_id:user_id,to_user_id:to_user_id},
		dataType:'json',
		success:function(data)
		{
			//alert(data.status);
			if(data.status=='success')
			{
				 $( ".chats" ).append(data.html);
				setTimeago();
			}else{
				console.log('Old time :'+ctime+'\n New time :'+data.ntime);
			}
			//alert('Old time :'+ctime+'\n New time :'+data.ntime);
			ctime=data.ntime;
		}
	})
	
  /// call your function here
}, 10000);

		jQuery(document).ready(function() {   
		setTimeago()	
			var cont = $('#chats');
			var comment = $("#comment").val();
            var list = $('.chats', cont);
            var form = $('.chat-form', cont);
            var input = $('#comment', form);
            var btn = $('.btn', form);
           var ticketId='<?php echo $message_id ?>';
	var user_type='<?php echo $from_user_type ?>';
	var user_id= $("#from_user_id").val();
	var to_user_id='<?php echo $to_user_id; ?>';
		    var text = input.val(); 
	$('#post').click(function(){
		
		 var text = $('#comment').val(); 
		 
             if(text!=''){   
				$.ajax({
					url:'<?php echo site_url('message/postConversationReply'); ?>',
					type:'post',
					dataType:'Json',
					data:{ticket_id:ticketId,replyBy:user_type,user_id:user_id,to_user_id:to_user_id,comment:text},
				 beforeSend : function() {
				$('#dvLoading').fadeIn('slow');
			},
					success:function(data){
						//alert(data.date_added);
						var tpl = '';
						
		                // tpl += '<div class="mar_top20"><div class="msg_content">';
		                // tpl += '<h1 class="msg_username"><?php //echo $name; ?>';
		                // tpl += '</h1>';
		                // tpl += '<p class="dashboard_desc">'+text;
		                // tpl += '</p>';
		                // tpl +=  '<p class="msg_date"><i class="timeago" title"'+data.date_added+'">0 minute ago</i></p></div>';
		                // tpl += '<div class="msg_img marl_10">'
		                // tpl += '<img class="img-responsive" alt="" src="<?php //echo base_url() ?>upload/<?php //echo $profile_image;?>"/>';
		                // tpl += '<i class="strip msg_reply"></i>';
		                // tpl += '</div><div class="clearfix"></div></div>';
		                
		                tpl += '<div class="mar_top20">';
		                tpl += '<div class="msg_img  marr_10">'
		                tpl += '<img class="img-responsive" alt="" src="<?php echo base_url() ?>upload/<?php echo $profile_image;?>"/>';
		                tpl += '<i class="strip msg_arrow"></i>';
		                tpl += '</div>';
		                tpl += '<div class="msg_content"><h1 class="msg_username"><?php echo $name; ?>';
		                tpl += '</h1>';
		                tpl += '<p class="dashboard_desc">'+text;
		                tpl += '</p>';
		                tpl +=  '<p class="msg_date"><i class="timeago" title"'+data.date_added+'">0 minute ago</i></p></div>';
		                tpl += '</div><div class="clearfix"></div></div>';
		               
		              // alert(tpl);
		               // var msg = list.append(tpl);
		                $( ".chats" ).append(tpl);
		                input.val("");
		                	$("#comment").val("");
		                setTimeago();
		                
		               
		                
		                $.growlUI('Message successfully posted.'); 
		                bottomscroll();
		                
					},
					complete : function() {
				$('#dvLoading').fadeOut('slow');
			}
				});
                
           }else{
           	$("#comment").val("");
           	input.css('color','#B94A48');
           	input.attr('placeholder','Please enter comment...');
           }
          
        });
        
        input.on('focus',function(){
        		input.removeAttr('style');
           		input.attr('placeholder','Type a message here...');
        })
        
		});
</script>		   