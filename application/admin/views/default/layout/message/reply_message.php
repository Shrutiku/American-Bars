
<script src="<?php echo front_base_url().getThemeName(); ?>/js/jquery.timeago.js"></script>
<script>
	function setTimeago(id,dt)
	{
		$(".timeago").timeago();
	}
</script>

<?php
  
 $admin_name=get_admin_name(get_authenticateadminID());
     
	// print_r($oneTickets);
	$userDetail= get_user_name($oneTickets['to_user_id']);
	
	$pim=(isset($userDetail->profile_image) && $userDetail->profile_image!='' && file_exists(base_path().'upload/user/'.$userDetail->profile_image))?front_base_url().'upload/user/'.$userDetail->profile_image:front_base_url().'upload/user/no_image.png';
	 ?>
	
	
<div class="page_content">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container_fluid">
				<!-- BEGIN PAGE HEADER-->   
				<div class="row_fluid">
					<div class="span12">
						
						<h3 class="page_title">
							Conversation for <strong><?php echo $oneTickets['subject'] ?></strong>			
						</h3>
						
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row_fluid">
					<div class="span12">
						<div class="portlet blue">
										<div class="portlet-title">
											 <div class="caption fl_left">&nbsp;</div> 
											
											<div class="fl_right">
												<?php if($redirect_page=='listTickets'){?>
												<a href="<?php echo site_url('message/list_message') ?>" class="btn black mini mar_top15"><i class="icon-circle-arrow-left"></i> Back</a>
												<?php }else{ ?>
													<a href="<?php echo site_url('message/'.$redirect_page) ?>" class="btn black mini mar_top15 pad_5"><i class="icon-circle-arrow-left"></i> Back</a>
												<?php } ?>
												</div><div class="clear"></div>
											<!-- <div class="tools">
												<a class="collapse" href="javascript:;"></a>
												<a class="config" data-toggle="modal" href="#portlet-config"></a>
												<a class="reload" href="javascript:;"></a>
												<a class="remove" href="javascript:;"></a>
											</div> -->
										</div>
										<div class="portlet-body" id="chats">
									<div class="scroller" style="height:435px" data-always-visible="1" data-rail-visible="1">
										<ul class="chats">
											
											<?php if($ticketConversation){
																																
															foreach($ticketConversation as $val){
																$to_user_types = "admin";		
																if($val['from_user_type'] != $to_user_types){

																
																	$user_info = get_member_single_detail($val['from_user_id']);
																	
																	$name = $user_info -> first_name." ".$user_info->last_name;
																	$profile_image = $user_info -> profile_image;
																	if($profile_image != "" && file_exists(base_path()."/upload/user_thumb/".$profile_image))
																	{
																		$profile_image = 'user_thumb/'.$profile_image;
																	}
																	else
																	{
																		$profile_image = 'no-image.png';
																	}	
														?>
																	<li class="in">
																		<img class="avatar" alt="" src="<?php echo front_base_url();?>/upload/<?php echo $profile_image; ?>" />
																		
																		<div class="message">
																			<span class="arrow"></span>
																			<a href="#" class="name"><?php echo get_user_detail($val['from_user_id'], $val['from_user_type'] ); ?></a>
																			<span class="datetime">at <?php echo date('M d, Y g:i A',strtotime($val['date_added']));?></span>
																			<span class="body">
																			<?php echo html_entity_decode(stripslashes ($val['description']));?>
																			
																			
																			</span>
																		</div>
																	</li>
																<?php } 
																
																else {
																	
																$user_info = get_admin_single_detail($val['from_user_id']);
																	 ?>
																	
																	<li class="out">
																	<img class="avatar" alt="" src="<?php echo front_base_url();?>/upload/admin/<?php echo $user_info->image; ?>" />
																		<div class="message">
																			<span class="arrow"></span>
																			<a href="#" class="name"><?php echo get_admin_detail($val['from_user_id']); ?></a>
																			<span class="datetime">at <?php echo date($site_setting->date_format,strtotime($val['date_added']));?></span>
																			<span class="body">
																			<?php echo html_entity_decode($val['description']);?>
																			</span>
																		</div>
																	</li>
																	
																<?php } ?>
															
														<?php }
															}  ?>
											
											
											
										</ul>
									</div><div class="clear"></div>
									<div class="chat-form">
										<div class="input-cont">  
											
											<input type="hidden" name="master_message_id" id="master_message_id" value="<?php echo $message_id;?>" />
											<?php if($from_user_type=='admin'){?> 
											<input type="hidden" name="from_user_id" id="from_user_id" value="<?php echo $from_user_id;?>" />
											<input type="hidden" name="to_user_id" id="to_user_id" value="<?php echo $to_user_id;?>" />
											<?php } else {?>
												<input type="hidden" name="from_user_id" id="from_user_id" value="<?php echo $to_user_id;?>" />
											<input type="hidden" name="to_user_id" id="to_user_id" value="<?php echo $from_user_id;?>" />
												<?php } ?>
											<input class="m-wrap" type="text" name="comment" id="comment" placeholder="Type a message here..." onkeydown="if (event.keyCode == 13) { $('#post').trigger('click'); return false; }" />
											<input type="hidden" name="Tickets_id" id="Tickets_id" value="<?php echo $message_id ?>" />
										</div>
										<div class="btn-cont"> 
											<span class="arrow"></span>
											<a href="javascript://" class="btn blue icn-only" id="post"><i class="icon-ok icon-white"></i></a>
										</div>
									</div>
								</div>
									</div>
									
						<!-- BEGIN SAMPLE FORM PORTLET-->   
						
						<!-- END SAMPLE FORM PORTLET-->
					</div>
				</div>
				<!-- END PAGE CONTENT-->    

<script>
//$oneTickets['user_id']
var ctime='<?php echo date('Y-m-d H:i:s') ?>';
window.setInterval(function(){
	
	
	var ticketId='<?php echo $oneTickets['master_message_id'] ?>';
	var user_type='<?php echo $oneTickets['from_user_type'] ?>';
	var user_id='<?php echo $oneTickets['from_user_id'] ?>';
	var to_user_id='<?php echo $oneTickets['to_user_id'] ?>';
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
				list.append(data.html);
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
            var list = $('.chats', cont);
            var form = $('.chat-form', cont);
            var input = $('#comment', form);
            var btn = $('.btn', form);
		    var text = input.val(); 
	$('#post').click(function(){
		//alert('dsadsa');
		 var text = input.val(); 
             if(text!=''){   
				$.ajax({
					url:'<?php echo site_url('message/postConversationReply'); ?>',
					type:'post',
					dataType:'Json',
					data:form.find('input').serialize(),
					//beforeSend:function(){ blockUI('.portlet-body'); },
					success:function(data){
						//alert(data.date_added);
						var tpl = '';
		                tpl += '<li class="out">';
		                tpl += '<img class="avatar" alt="" src="<?php echo base_url().getThemeName() ?>/assets/img/adminIcon.png"/>';
		                tpl += '<div class="message">';
		                tpl += '<span class="arrow"></span>';
		                tpl += '<a href="javascript://" class="name"><?php echo $admin_name; ?></a>&nbsp;';
		                tpl += '<span class="datetime ">at <i class="timeago" title"'+data.date_added+'">0 minute ago</i></span>';
		                tpl += '<span class="body">';
		                tpl += text;
		                tpl += '</span>';
		                tpl += '</div>';
		                tpl += '</li>';
		
		                var msg = list.append(tpl);
		                input.val("");
		                setTimeago();
		                $('.scroller', cont).slimScroll({
		                    scrollTo: list.height()
		                });
		                
		                $.growlUI('Message successfully posted.'); 
		                
					},
					//complete:function(){  unblockUI('.portlet-body'); }
				});
                
           }else{
           	input.val("");
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
		   				     
			</div>
		</div>