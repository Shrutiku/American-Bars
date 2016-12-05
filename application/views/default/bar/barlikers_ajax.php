<?php			 
					$attributes = array('name'=>'actionliquorfav','id'=>'actionliquorfav','data-target'=>'.content');
					echo form_open('liquor/actionliquorfav',$attributes);?> 
					<input type="hidden" name="action" id="action" />
					    					<div class="table-responsive">
     						<div id="responsecomment">
     							<div class="pagination" id="at_ajax">
	     				<?php echo $page_link;?>
     				</div><div class="clearfix"></div>
							<table class="table">
								<thead>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Date</th>
									<th>Profile Link</th>
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
									<tr class="<?php echo $dark; ?>" id='remove_event_<?php echo $event->liquor_id; ?>'>
										<td><?php echo ucfirst($event->first_name);?></td>
										<td><?php echo ucfirst($event->last_name);?></td>
										<td><?php echo date($site_setting->date_format,strtotime($event->date));?></td>
										<td><a target="_blank" href="<?php echo site_url('user/profile/'.base64_encode($event->user_id)); ?>">View Profile</a></td>
										
									</tr>
								<?php $i++; } } else { ?>
									<tr>
										<td colspan="5">No any bar likers found .</td>
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
			return false;
			
		});

      
</script>
