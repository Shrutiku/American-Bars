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
									<th>First</th>
									<th>Last</th>
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
												 No Image .
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
												 No Image .
										  <?php } ?>		
											</th>
										
											
									  <?php } ?>		
										<input type="hidden" name="postcard_id" id="postcard_id" value="<?php echo $event->postcard_id;?>" />
									</tr>
								<?php $i++; } } else { ?>
									<tr>
										<td colspan="8">No any postcard found .</td>
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
