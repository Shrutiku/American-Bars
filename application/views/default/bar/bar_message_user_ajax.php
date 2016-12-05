<div class="dashboard_subblock">
		     			<div class="pad_t15b20">
		     				<div class="br-green">
		     					<?php
								
								if($result)
								{
									$i=1;
									foreach($result as $msg){								
								
								if ($i % 2 == 0)
										  {
										    $dark =  "reply_bg";
										  }
										  else
										  {
										    $dark =  "";
										  }
										  
										  if($msg->from_user_type=='sender'){			  
								$user_info = get_user_info($msg->from_user_id);
							}
							else {
								$user_info = get_user_info($msg->to_user_id);
							}
							
							
								$profile_image = @$user_info->profile_image;
																	if($profile_image != "" && file_exists(base_path()."/upload/user_thumb/".$profile_image))
																	{
																		$profile_image = 'upload/user_thumb/'.$profile_image;
																	}
																	else
																	{
																		$profile_image = 'upload/no-image.png';
																	}	
								//print_r($user_info);		  ?>	
								
	     						<div  class="pos_rel br-bottom-green <?php echo $dark;?>" id="remove_message_<?php echo $msg->message_id; ?>">
	     							<div class="msg_img marr_10">
	     								<img class="img-responsive" alt="" src="<?php echo base_url();?><?php echo $profile_image; ?>" />
	     							</div>
	     							<div class="message_listblock">
	     								<h1 class="msg_username pull-left"><a class="msg_username" href="<?php echo site_url('message/viewconversation_user/'.base64_encode($msg->message_id))?>"><?php echo get_user_detail($msg->from_user_id); ?></a>
	     									<?php 
	     									$chek1 = readmsg_user_1($msg->message_id);
	     									$chek = readmsg_user($msg->message_id);
											//echo $chek;
											 
	     									if($chek != 0 || $chek1 != 0){?>
	     									 <i class="strip msg_new"></i>
	     									 <?php } ?></h1>
	     								<p class="msg_date pull-right"><?php echo date('M d, Y g:i A',strtotime($msg->date_added));?></p>
	     								<div class="clearfix"></div>
	     								<a href="javascript://" onclick="remove_message('<?php echo $msg->message_id;?>')" class="strip msg_close mar_top15"></a>
	     								
	     								<p class="dashboard_desc">
	     									<?php echo $msg->description;?>
	     								</p>
	     							</div>
	     							<div class="clearfix"></div>
	     						</div>
	     						<?php $i++;} } else {?>
	     							 No message Founds.
	     							<?php } ?>
	     						<div class="pagination" id="at_ajax">
	     				<?php echo $page_link;?>
     				</div>
					     		<div class="clearfix"></div>
     						</div>
     					</div>
		     		</div>
     			<div class="clearfix"></div>
     			<input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
					<input type="hidden" name="offset" id="offset" value="<?php echo ($offset!='')?$offset:0; ?>" />
					<input type="hidden" name="limit" id="limit" value="<?php echo ($limit>0)?$limit:10; ?>" />
    
    <script>
   function setupLabel() {
        if ($('.label_check input').length) {
            $('.label_check').each(function(){ 
                $(this).removeClass('c_on');
            });
            $('.label_check input:checked').each(function(){ 
                $(this).parent('label').addClass('c_on');
            });                
        };
        if ($('.label_radio input').length) {
            $('.label_radio').each(function(){ 
                $(this).removeClass('r_on');
            });
            $('.label_radio input:checked').each(function(){ 
                $(this).parent('label').addClass('r_on');
            });
        };
    };
    $(document).ready(function(){
    	
    	        $('.label_check, .label_radio').click(function(){
    	        	
            setupLabel();
        });
        
    });
    
   
</script>

<script>

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
			
			$("#list_hide").html(res);
			setupLabel();	
			bindJquery();
			return false;
			
		});

 
</script>
