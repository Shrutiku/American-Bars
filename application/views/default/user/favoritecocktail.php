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
  </div><div class="user-top-border">
  		<div class="container">
     		<div class="bg_brown">
     		<div class="margin-top-50 bg_brown">
     			<?php echo $this->load->view(getThemeName().'/home/dashboard_menu'); ?>
     			<div class="dashboard_detail">
     				<div class="result_search event"><div class="result_search_text"><i class="strip cocktails"></i> Favorite Cocktail</div></div>
		     		<div class="dashboard_subblock">
		     			<div>
		     				<div class="dash-btngroup">
	     						<div id="hd_del">
	     							<a class="btn btn-lg btn-primary marr_10" href="javascript:void(0)" onclick="searchboxbeer();">Add Favorite Cocktails</a>
		                       		<a class="btn btn-lg btn-primary marr_10" href="javascript:void(0)" onclick="setaction('chk[]','delete',   'actioncocktailfav');">Delete</a>
	     						</div>
     						</div>
     					<div id="list_hide_m">
     						<?php			 
					$attributes = array('name'=>'frm_search','id'=>'frm_search','data-async'=>'','data-target'=>'.content');
					echo form_open('admin/search_bar_gallery/'.$limit,$attributes);?>
					<div class="search_block">
						<input type="hidden" name="limit" id="search-limit" value="<?php echo ($limit>0)?$limit:10; ?>" />
				     			<div class="search-strip order-form">
				     				<form class="form-horizontal" role="form">
					                   <div class="form-group">
					                       <div class="col-sm-8 input_box pull-left" style="padding: 0 5px 0 0;">
					                           <input type="text" name="event_keyword" id="event_keyword" class="form-control form-pad"  placeholder="Search My Favorite Cocktail" onkeydown="if (event.keyCode == 13) { get_search_event(); return false; }" />
					                       </div>
					                       <div class="col-sm-2 input_box pull-left" style="margin-right: 0;">
				                        		<button type="button" onclick="get_search_event()" id="search" class="btn btn-lg btn-primary search"><i class="strip search"></i></button>
				                       	   </div>
				                       	   <div class="col-sm-2 input_box pull-left" style="margin-right: 0;">
				                        		<a href="<?php echo site_url('user/favoritecocktail')?>" class="btn btn-lg btn-primary search" type="submit"><i class="strip refresh"></i>
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
					$attributes = array('name'=>'actioncocktailfav','id'=>'actioncocktailfav','data-target'=>'.content');
					echo form_open('cocktail/actioncocktailfav',$attributes);?> 
					<input type="hidden" name="action" id="action" />
					    					<div class="table-responsive">
     						<div id="responsecomment">
     							<div class="pagination" id="at_ajax">
	     				<?php echo $page_link;?>
     				</div><div class="clearfix"></div>
							<table class="table">
								<thead>
									<th><label  class="radio-checkbox label_check c_on group-checkable" for="checkbox-00"><input type="checkbox" data-set=".checkboxes" name="sample-checkbox-00" id="checkbox-00" value="1"></label></th>
									<th>Cocktail Name</th>
									<!-- <th>Ingredients</th>
									<th>How to make it</th> -->
									<th>Type</th>
									<th>Date & Time</th>
									<th>Action</th>
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
									<tr class="<?php echo $dark; ?>" id='remove_event_<?php echo $event->cocktail_id; ?>'>
										<td><label class="radio-checkbox label_check c_on" for="checkbox-<?php echo  $event->cocktail_id;?>">
											<input type="checkbox"  class="checkboxes" name="chk[]" id="checkbox-<?php echo  $event->cocktail_id;?>" value="<?php echo $event->cocktail_id;?>"></label></td>
										
										<td><a target="_blank" class="bar_title" href="<?php echo site_url('cocktail/detail/'.$event->cocktail_slug);?>"><?php echo $event->cocktail_name;?></td>
										<!-- <td><?php echo $event->ingredients;?></td>
										<td><?php echo $event->how_to_make_it;?></td> -->
										<td><?php echo $event->type;?></td>
										<td><?php 
								       	  
								       	  echo  date($site_setting->date_format. " h:i:s",strtotime($event->date_added)); ?></td>
										<td>
											<!-- <a href="javascript://" onclick="editbarevent('<?php echo $event->event_id; ?>')"><i class="strip edit_table"></i></a> -->
											<a href="javascript://" onclick="deletefavcocktail('<?php echo $event->cocktail_id; ?>')" ><i class="strip delete"></i></a>
										</td>
									</tr>
								<?php $i++; } } else { ?>
									<tr>
										<td colspan="7">You have no favorite cocktails.</td>
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
		     	</div>
     		</div>
     	<div class="clearfix"></div>
     </div>
   </div>
   </div>
 </div>
 
 <div class="modal fade login_pop2" id="searchboxbeer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	  <?php echo $this->load->view(getThemeName().'/home/searchboxcocktail');?>	
</div>
<script>
	function searchboxbeer()
	{
		$("#searchboxbeer").modal('show');
		 
	}
</script>
<script>

function deletefavcocktail(id)
 {
 	 
			alertify.confirm("Are you sure you want to delete this favorite cocktail?", function (e) {
				if (e) {
					 var res = $.ajax(
	        {						
			   type: 'POST',
			   url: '<?php echo site_url('cocktail/deletefavcocktail/')?>',
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
				     $.growlUI('Your favorite cocktail deleted successfully .');
				    }
				}).responseText;
				bindJquery();
			}
			return false;
			
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
 
 function get_search_event()
 {
 	  var event_keyword = $("#event_keyword").val();
 	  var limit = $("#limit").val();
 	  var offset = 0; 
 	  var res = $.ajax(
	        {						
			   type: 'POST',
			   url: '<?php echo site_url('user/favoritecocktail/')?>',
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
			 setupLabel();
				bindJquery();
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
			               $(this).parent('label').addClass('c_on');
			                $( ".radio-checkbox" ).addClass( "c_on" ); 
			                            $('.checkboxes').attr('Checked','Checked'); 
			                    $('#states').find('span').addClass('checked');        
			            });                
			        };
	            });
	
	}
$(document).ready(function(){	
	 $('.label_check, .label_radio').click(function(){
    	        	
            setupLabel();
        });
        setupLabel(); 	
	  bindJquery();	
	 }); 
 
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
	var url='<?php echo site_url('user/') ?>/'+redirect_page+'/'+limit+'/'+keyword+'/'+offset;
	
	
	$.ajax({
			url : url,
			cache: false,
			success : function(response) {
				$('.content').html('');
				$('.content').html(response);
				setupLabel();
				bindJquery();
			},
	});
	
	}
	
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
		
		alertify.confirm("Are you sure you want to delete this favorite cocktail?", function (e) {
				if (e) {
			document.getElementById('action').value=actionval;	
			//$('#frm_admin').submit();
		var $form = $('#actioncocktailfav');
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
                	$.growlUI('Your favorite cocktail deleted successfully .'); 
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

