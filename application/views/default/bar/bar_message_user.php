
<script>

$(document).ready(function(){
	
	$('.tags').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('message/get_user_list/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
							 	  
								return {
									label: item.label,
							        value: item.value,
							        id: item.id,
								}
							}));
						}
		      		});
		      	},
		      	select: function(event, ui) {
		      		//alert('dsa');
		      		
        $("#to_user_id1").val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		      
		      
	
});	
	


</script>
<div class="wrapper row6 padtb10 has-js">
     	<div class="container">
     		<?php  if($this->session->userdata('user_type')!='bar_owner'){ ?><div class="wrapper row4">
   			<div class="carousel slide" id="slider-fixed-banner">
        	<div class="carousel-inner">
          	<div class="active item">
          	  	
          	  									<?php
          	  									
          	  									$userinfo_new = get_user_info(get_authenticateUserID());
          	  									
		          		if($userinfo_new->user_banner!="" && file_exists(base_path().'upload/banner_drag/'.@$userinfo_new->user_banner))
					{?>
		            	<img src="<?php echo base_url()?>/upload/banner_drag/<?php echo $userinfo_new->user_banner; ?>" alt="American Dive Bars"/>
		            	<?php }  else if($userinfo_new->user_banner!="" && file_exists(base_path().'upload/banner_drag_without/'.@$userinfo_new->user_banner))
					{?>
						<img src="<?php echo base_url()?>/upload/banner_without_drag/<?php echo $userinfo_new->user_banner; ?>" alt="American Dive Bars"/>
		            		
		            		<?php } else {?>
		            		<img src="<?php echo base_url().'default'?>/images/smallbanner1.png" alt="American Dive Bars"/>	
		            			<?php } ?>
         </div>
        </div>
   	</div>
	</div>
  <!-- </div> -->
  <?php }  ?>
  </div><div class="<?php if($this->session->userdata('user_type')=='user'){?>user-top-border<?php } else {?>margin-top-50<?php } ?>">
  		<div class="container">
     		<div class="bg_brown">
     			<?php echo $this->load->view(getThemeName().'/home/dashboard_menu'); ?>
     			<div class="dashboard_detail">
     				<div class="result_search event"><div class="result_search_text"><i class="strip message"></i> Message</div></div>
     						
     						<div class="text-right" id="hd_del">
     							<button type="submit" class="btn btn-lg btn-primary marr_10" onclick="list_add()">Compose New Message</button>
     						</div>
     					<div class="text-right" id="hs_del" style="display: none;">
     							<a onclick="goto_main()" href="javascript://"  class="btn btn-lg btn-primary marr_10">Back</a>
     						</div>
     					<div id="list_hide" class="content">	
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
								
	     						<div style="cursor: pointer;" onclick="window.open('<?php echo site_url('message/viewconversation_user/'.base64_encode($msg->message_id))?>')" class="pos_rel br-bottom-green <?php echo $dark;?>" id="remove_message_<?php echo $msg->message_id; ?>">
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
	     							 No messages found.
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
					</div>	
					
					
					
					<div id="list_show" style="display: none;" >	
					<input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
					<input type="hidden" name="offset" id="offset" value="<?php echo ($offset!='')?$offset:0; ?>" />
					<input type="hidden" name="limit" id="limit" value="<?php echo ($limit>0)?$limit:10; ?>" />
					
					<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
					<form name="add_event" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('message/send_new_message/'.base64_encode(@$getbar['bar_id'])); ?>">
     				<input type="hidden" name="to_user_id1" id="to_user_id1" value="" />
		     			<div class="text-center pad_t15b20">
		     				
		     				<div class="padtb">
		     					<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Select User : <span class="aestrick"> * </span></label>
	        				 	</div>
										<div class="input_box col-sm-7">
											<input type="text" name="to_user_id" id="to_user_id" class="form-control form-pad tags" />
											
										</div><div class="clearfix"></div>
									</div>
									
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Subject : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="subject" name="subject" value="">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Description :  <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<textarea rows="5" name="description" id="description" placeholder="Description" class="form-control form-pad"></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	
	                       	<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10 text-left">
	                       			<button type="submit" class="btn btn-lg btn-primary marr_10" >Send</button> 
	                       			<a  class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('message/sss_message_user');?>" >Cancel</a>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="clearfix"></div>
     		</div>
     			</form>
     			</div>
					
					
					
     			
     	<div class="clearfix"></div>
     </div>
   </div>
   </div>
 </div>
<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/js/jquery_form.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.easing.1.3.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/js/rating.css" />
 <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/rating.js"></script>

    <script>
   
    
$(document).ready(function(){
	 $('.label_check, .label_radio').click(function(){
    	        	
            setupLabel();
        });
        setupLabel(); 	
	  bindJquery();	
	 });
        
        $('#form').validate(
		{
		rules: {
					subject: {
							required: true,
					},
					to_user_id: {
							required: true,
					},
					description: {
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
			    		$('#dvLoading').fadeOut('slow');
			    		scrollToDiv('cm-err-main1');
				  		// setTimeout(function () 
						// {
						      // $("#cm-err-main1").fadeOut('slow');
						// }, 3000);
					return false;
					}
			
					else
					{
						//alert("sdsa");
						$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
						$.growlUI('Your Message Send successfully .');
						$(':input','#form')
					 	.not(':button, :submit, :reset, :hidden')
					 	.val('')
					 	.removeAttr('selected');
					 	 $("#list_hide").slideDown();
					 	 $("#list_hide_m").slideDown();
					     $("#hd_del").slideDown();
					     $("#hs_del").slideUp();
					     $('#list_show').slideUp();
					     $("#at_ajax").remove();
					     getData();
					}
					$('#dvLoading').fadeOut('slow');
		   		 }
		    });
		  }
		})
		
		
    function getData()
	{
	//var keyword=($('#keyword').val()!='')?$('#keyword').val().split(' ').join('-'):'1V1';
	var limit = $('#limit').val();
    var keyword = $("#event_keyword").val();
    if(keyword=='')
    {
    	var keyword = '1V1';
    }
	var offset = $('#offset').val();
	var redirect_page=$('#redirect_page').val();
	var url='<?php echo site_url('message/') ?>/'+redirect_page+'/'+limit+'/'+keyword+'/'+offset;
	
	
	$.ajax({
			url : url,
			cache: false,
			// beforeSend : function() {
				// blockUI('.portlet-body');
			// },
			success : function(response) {
				// alert(response);
				$('.content').html('');
				$('.content').html(response);
				setupLabel();
				bindJquery();
				
				//bindJquery();
			},
			// complete : function() {
				// unblockUI('.portlet-body');
			// },
	});
	
	}
    function list_add()
    {
    	$(':input','#form')
		.not(':button, :submit, :reset, :hidden')
		.val('')
		.removeAttr('selected');
		$("#cocktail_id").val('');
		$("#cocktail_id_tagsinput span").remove();			 	
    	$("#list_hide").slideUp();
    	$("#list_hide_m").slideUp();
    	$("#hd_del").slideUp();
    	$("#hs_del").slideDown();
    	$('#list_show').slideDown();
    	
    }
    
    function goto_main()
    {
    	$("#event_id").val('');
    	$(':input','#form')
					 	.not(':button, :submit, :reset, :hidden')
					 	.val('')
					 	//.removeAttr('checked')
					 	.removeAttr('selected');
		$("#img_here").removeAttr('src');			 	
    	$("#list_hide").slideDown();
    	$("#list_hide_m").slideDown();
    	$("#hd_del").slideDown();
    	$("#hs_del").slideUp();
    	$('#list_show').slideUp();
    }
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
			bindJquery();
			setupLabel();	
			
			return false;
			
		});


 
 function remove_message(id)
 {

			alertify.confirm("Are you sure you want to delete this message?", function (e) {
				if (e) {
					 var res = $.ajax(
	        {						
			   type: 'POST',
			   url: '<?php echo site_url('message/removemessage/')?>',
			   dataType: 'post', 
			   data : {id:id},
			   cache: false,
			   async: false,
			   beforeSend : function(){
			      $('#dvLoading').fadeIn('slow');
			   },
				complete: function(){
				     $('#dvLoading').fadeOut('slow');
				     getData();
				     $("#remove_message_"+id).remove();
				     $.growlUI('Your message deleted successfully .');
				    }
				}).responseText;
				bindJquery();
			}
			return false;
			
 });
 }
 
 function bindJquery()
	{
		
		
		jQuery('.group-checkable').change(function () {
			
	                if ($('.label_check input').length) {
			            $('.label_check').each(function(){ 
			                $(this).removeClass('c_on');
			                            $('.checkboxes').removeAttr('Checked'); 
			            });
			            $('.label_check input:checked').each(function(){ 
			            	
			               // $(this).parent('label').addClass('c_on');
			                $( ".radio-checkbox" ).addClass( "c_on" ); 
			                            $('.checkboxes').attr('Checked','Checked'); 
			                  //  $('#states').find('span').addClass('checked');        
			            });                
			        };
	            });
	
	}

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
    
    function setaction(elename, actionval, formname) {

	vchkcnt=0;
	elem = document.getElementsByName(elename);
	
	
	for(i=0;i<elem.length;i++){
		if(elem[i].checked) vchkcnt++;
		//vchkcnt++;
			
	}
	if(vchkcnt==0) {
			alertify.alert("Please select a record .");
			return false;
	} else {
		
		alertify.confirm("Are you sure you want to delete this comment?", function (e) {
				if (e) {
			document.getElementById('action').value=actionval;	
			//$('#frm_admin').submit();
		var $form = $('#actionevent');
        var $target = $($form.attr('data-target'));
 		var limit=$('#limit').val();
 		var offset=$('#offset').val();
 		var keyword=$('#event_keyword').val();
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            cache: false,
            dataType:'json',
            data: $form.serialize(),
            beforeSend : function() {
				$('#dvLoading').fadeIn('slow');
			},success: function(res, status) {
				// alert(res);
                if(res.status=='done'){
                	$.growlUI('Your comment deleted successfully .'); 
                	getData();	
                }
                
            },complete : function() {
				$('#dvLoading').fadeOut('slow');
			},
        });
		}		
		else
		{
			return false;
		}
		});
	}
}
</script>

