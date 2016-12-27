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
     				<div class="result_search event"><div class="result_search_text"><i class="strip postcards"></i> Postcards</div></div>
		     		<div class="dashboard_subblock">
		     			<div>
		     				<div class="dash-btngroup">
	     						<div id="hd_del">
	     							<!-- <button type="submit" class="btn btn-lg btn-primary marr_10" onclick="list_add()">Add</button> -->
	     							<?php 	if($this->session->userdata('user_type')=='bar_owner')
											 { ?>
		                       		<a class="btn btn-lg btn-primary marr_10" href="javascript:void(0)" onclick="setaction('chk[]','delete',   'frm_event');">Delete</a>
		                       		<?php } ?>
		                       		
	     						</div>
	     						<div id="hs_del" style="display: none;">
	     							<a onclick="goto_main()" href="javascript://"  class="btn btn-lg btn-primary marr_10">Back</a>
	     						</div>
     						</div>
     					<div id="list_hide_m">
     						<?php			 
					$attributes = array('name'=>'frm_search','id'=>'frm_search','data-async'=>'','data-target'=>'.content');
					echo form_open('admin/search_bar_events/'.$limit,$attributes);?>
					<div class="search_block">
						<input type="hidden" name="limit" id="search-limit" value="<?php echo ($limit>0)?$limit:10; ?>" />
				     			<div class="search-strip">
				     				<form class="form-horizontal" role="form">
					                   <div class="form-group">
					                       <div class="col-sm-7 input_box pull-left" style="padding-left: 0;">
					                       	<?php 	if($this->session->userdata('user_type')=='bar_owner')
										 { ?>
					                           <input type="text" name="event_keyword" id="event_keyword" class="form-control form-pad" id="inputEmail3" placeholder="By First Or Last Name" onkeydown="if (event.keyCode == 13) { get_search_event(); return false; }" />
					                           <?php } else { ?>
					                           <input type="text" name="event_keyword" id="event_keyword" class="form-control form-pad" id="inputEmail3" placeholder="By Bar Name" onkeydown="if (event.keyCode == 13) { get_search_event(); return false; }" />	
					                           	<?php } ?>
					                           
					                           
					                       </div>
					                       <div class="col-sm-2 input_box pull-left">
				                        		<button type="button" onclick="get_search_event()" id="search" class="btn btn-lg btn-primary search"><i class="strip search"></i></button>
				                       	   </div>
				                       	   <div class="col-sm-2 input_box pull-left">
				                        		<a href="<?php echo site_url('bar/postcard')?>" class="btn btn-lg btn-primary search" type="submit"><i class="strip refresh"></i>
				                       	   </a></div>
				                       	   <div class="clearfix"></div>
					                    </div>
				                    </form>
				     			</div>
					     		
					     		<div class="clearfix"></div>
					     		</form>
					     	</div>
					     	</div>
     					<div id="list_hide" class="content">	
     						<?php			 
					$attributes = array('name'=>'actionevent','id'=>'actionevent','data-target'=>'.content');
					echo form_open('bar/actionpostcard',$attributes);?> 
					<input type="hidden" name="action" id="action" />
					    					<div class="table-responsive">
     						<div id="responsecomment">
     							<div class="pagination" id="at_ajax">
	     				<?php echo $page_link;?>
     				</div><div class="clearfix"></div>
							<table class="table">
								<thead>
									<?php 	if($this->session->userdata('user_type')=='bar_owner')
										 { ?>
									<th><label  class="radio-checkbox label_check c_on group-checkable" for="checkbox-00"><input type="checkbox" data-set=".checkboxes" name="sample-checkbox-00" id="checkbox-00" value="1"></label></th>
									<th>Title</th>
									<th>Description</th>
									<th>First Name</th>
									<th>Last Name</th>
									<!-- <th>Barname</th> -->
									<!-- <th>Email</th> -->
									<th>Download</th>
									<th>Action</th>
									<?php } else { ?>
									<th>Title</th>
									<th>Bar Name</th>
									<th>Description</th>
									
									<th>Download</th>
										<?php } ?>
								</thead>
								<tbody>
								<?php
								
								if($result)
								{
									$i=1;
									foreach($result as $event){								
								
								if ($i % 2 == 0)
										  {
										    $dark =  "dark";
										  }
										  else
										  {
										    $dark =  "light";
										  }?>	
									<tr class="<?php echo $dark; ?>" id='remove_event_<?php echo $event->postcard_id; ?>'>
								<?php 	if($this->session->userdata('user_type')=='bar_owner')
										 { ?>
										<td><label class="radio-checkbox label_check c_on" for="checkbox-<?php echo  $event->postcard_id;?>">
											<input type="checkbox"  class="checkboxes" name="chk[]" id="checkbox-<?php echo  $event->postcard_id;?>" value="<?php echo $event->postcard_id;?>"></label></td>
										<td><?php if($event->post_title=='Your Bar is Awesome'){ echo "Awesome"; } else { echo "Sucks"; }?></td>
										<td><?php if(strlen(strip_tags($event->post_message))>50) { echo substr(strip_tags($event->post_message), 0,50)."...."; } else { echo strip_tags($event->post_message); }?></td>
										<td><?php echo ucwords($event->first_name);?></td>
										<td><?php echo ucwords($event->last_name);?></td>
										<!-- <td><?php echo $event->bar_title;?></td> -->
										<!-- <td><?php echo $event->email;?></td> -->
										<th>
											<?php if($event->image!=''){?>
											<a href="<?php echo base_url().'upload/postcard_orig/'.$event->image;?>" target='_blank'>Download Image</a>
											<?php } else {?>
												 No Image
										  <?php } ?>		
											</th>
										<td>
											<!-- <a href="javascript://" onclick="editbarevent('<?php echo $event->event_id; ?>')"><i class="strip edit_table"></i></a> -->
											<a href="javascript://" onclick="deletepostcard('<?php echo $event->postcard_id; ?>')" ><i class="strip delete"></i></a>
											
										</td>
										<?php } else {?>
										<td><?php if($event->post_title=='Your Bar is Awesome'){ echo "Awesome"; } else { echo "Sucks"; }?></td>
										<td><?php echo ucwords($event->bar_title);?></td>
										<td><?php if(strlen(strip_tags($event->post_message))>50) { echo substr(strip_tags($event->post_message), 0,50)."...."; } else { echo strip_tags($event->post_message); }?></td>
										
										<th>
											<?php if($event->image!=''){?>
											<a href="<?php echo base_url().'upload/postcard_orig/'.$event->image;?>" target='_blank'>Download Image</a>
											<?php } else {?>
												 No Image
										  <?php } ?>		
											</th>
										
											
									  <?php } ?>		
										<input type="hidden" name="postcard_id" id="postcard_id" value="<?php echo $event->postcard_id;?>" />
									</tr>
								<?php $i++; } } else { ?>
									<tr>
										<td colspan="8">No postcards were found.</td>
									</tr>	
										
									<?php } ?>	
								</tbody>
							</table>
							</div>
							<input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
					<input type="hidden" name="offset" id="offset" value="<?php echo ($offset!='')?$offset:0; ?>" />
					<input type="hidden" name="limit" id="limit" value="<?php echo ($limit>0)?$limit:10; ?>" />
						</div>
						</form>
					</div>	
					
				<div id="list_show" style="display: none;" >	
					<input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
					<input type="hidden" name="offset" id="offset" value="<?php echo ($offset!='')?$offset:0; ?>" />
					<input type="hidden" name="limit" id="limit" value="<?php echo ($limit>0)?$limit:10; ?>" />
					
					<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
					<!-- s<form name="add_event" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('bar/add_cocktail/'.base64_encode($getbar['bar_id'])); ?>">
						<input type="hidden" name="event_id" id="event_id" value="" /> -->
					<!-- <div class="dashboard_detail">
     				
		     		<div class="dashboard_subblock">
		     			<div class="text-center pad_t15b20">
     					<form class="form-horizontal" role="form">
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Add Cocktail : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad tags" id="cocktail_id" name="cocktail_id" value="">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10 text-left">
	                       			<button type="submit" class="btn btn-lg btn-primary marr_10" >Submit</button> 
	                       			<a  class="btn btn-lg btn-primary marr_10" href="<?php echo site_url('bar/bar_cocktail');?>" >Cancel</a>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="clearfix"></div>
	        			</form>
     		</div>
		     		</div>
     			</div> 
     			</form>-->
     			</div>
     			
		     	</div>
     		</div>
     	<div class="clearfix"></div>
     </div>
   </div>
   </div>
 </div>
<link href="<?php echo base_url().getThemeName(); ?>/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/datepicker/jquery.datetimepicker.css" />
<script src="<?php echo base_url().getThemeName();?>/datepicker/jquery.datetimepicker.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/js/jquery_form.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.easing.1.3.js"></script>
<!-- <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/jquery.tagsinput.css" />
<script src="<?php echo base_url().getThemeName();?>/js/jquery.tagsinput.js" type="text/javascript"></script>
<!-- <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script> -->
    
    <script>
   
   
$(document).ready(function(){
	 $('.label_check, .label_radio').click(function(){
            setupLabel();
        });
        setupLabel(); 	
	  bindJquery();	
	 var arrVal = new Array();
	var t = $("[class=user_type]").val();
	
	 });
        
        $('#form').validate(
		{
		rules: {
					cocktail_id: {
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
						if($('#event_id').val()=='')
						{
							$.growlUI('Your cocktail add successfully .');
						}
						else
						{
							$.growlUI('Your cocktail update successfully .');
						}
						$(':input','#form')
					 	.not(':button, :submit, :reset, :hidden')
					 	.val('')
					 	//.removeAttr('checked')
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
	var url='<?php echo site_url('bar/') ?>/'+redirect_page+'/'+limit+'/'+keyword+'/'+offset;
	
	
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
    	$("#event_id").val('');
    	$(':input','#form')
					 	.not(':button, :submit, :reset, :hidden')
					 	.val('')
					 	//.removeAttr('checked')
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
 function editbarevent(id)
 {
 		
 	 $.ajax({
	       type: "POST",
		   url: "<?php echo site_url('bar/bareventdetail')?>",
		   data : {id:id},
		   dataType : 'JSON',
		   success: function(response) {
		   
		      $("#event_id").val(response.event_id);
		      $("#event_title").val(response.event_title);
		      $("#event_desc").val(response.event_desc);
		      $("#start_date").val(response.start_date);
		      $("#end_date").val(response.end_date);
		      $("#address").val(response.address);
		      $("#city").val(response.city);
		      $("#state").val(response.state);
		      $("#phone").val(response.phone);
		      $("#zipcode").val(response.zipcode);
		      $("#event_video_link").val(response.event_video_link);
		      $("#is_power_boost_event").val(response.is_power_boost_event);
		      $("#status").val(response.status);
		      $("#prev_event_image").val(response.event_image);
		      $("#prev_event_video").val(response.event_video);
		      
		      if(response.event_video!='')
		      {
		      		 var src_vid = '<?php echo base_url().'upload/event_video/'?>';
		      	     var htm = '<a href="'+src_vid+response.event_video+'" id="video_add" class="image_play fancybox-video">'+response.event_video+'</a>';
		      	   //  $("#video_add").attr("href", src_vid+response.event_video);
		      		 $("#prev_event_video_htm").html(htm);
			  }
		     
		      if(response.event_image!='')
		      {
		      		var src1 = '<?php echo base_url().'upload/event_thumb/'?>';
					$("#img_here").attr("src", src1+response.event_image);
			 }
		      $("#list_hide").slideUp();
	    	$("#list_hide_m").slideUp();
	    	$("#hd_del").slideUp();
	    	$("#hs_del").slideDown();
	    	
	    	$('#list_show').slideDown();
	    	bindJquery();
		     
		  }
	   });
 }
 function get_search_event()
 {
 	  var event_keyword = $("#event_keyword").val();
 	  var limit = $("#limit").val();
 	  var offset = 0; 
 	  var res = $.ajax(
	        {						
			   type: 'POST',
			   url: '<?php echo site_url('bar/postcard/')?>',
			   dataType: 'post', 
			   data : {event_keyword:event_keyword,limit:limit,offset:offset},
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
			//bindJquery();
			 $('.label_check').removeClass('c_on');
                    $('.checkboxes').removeAttr('Checked'); 
                    bindJquery();
 }
 
 function deletepostcard(id)
 {
 	 
			alertify.confirm("Are you sure you want to delete this postcard?", function (e) {
				if (e) {
					 var res = $.ajax(
	        {						
			   type: 'POST',
			   url: '<?php echo site_url('bar/barpostcarddelete/')?>',
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
				     $("#remove_event_"+id).remove();
				     $.growlUI('Your cocktail deleted successfully .');
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
		
		alertify.confirm("Are you sure you want to delete this cocktail?", function (e) {
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
                	$.growlUI('Your cocktail deleted successfully .'); 
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

