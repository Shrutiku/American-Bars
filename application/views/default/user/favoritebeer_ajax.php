		<?php			 
					$attributes = array('name'=>'actionevent','id'=>'actionevent','data-target'=>'.content');
					echo form_open('beer/actionbeerfav',$attributes);?> 
					<input type="hidden" name="action" id="action" />
					    					<div class="table-responsive">
     						<div id="responsecomment">
     							<div class="pagination" id="at_ajax">
	     				<?php echo $page_link;?>
     				</div><div class="clearfix"></div>
							<table class="table">
								<thead>
									<th><label  class="radio-checkbox label_check c_on group-checkable" for="checkbox-00"><input type="checkbox" data-set=".checkboxes" name="sample-checkbox-00" id="checkbox-00" value="1"></label></th>
									<th>Beer Name</th>
									<!-- <th>Description</th> -->
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
									<tr class="<?php echo $dark;  ?>" id='remove_event_<?php echo $event->beer_id; ?>'>
										<td><label class="radio-checkbox label_check c_on" for="checkbox-<?php echo  $event->beer_id;?>">
											<input type="checkbox"  class="checkboxes" name="chk[]" id="checkbox-<?php echo  $event->beer_id;?>" value="<?php echo $event->beer_id;?>"></label></td>
										<td><a target="_blank" class="bar_title" href="<?php echo site_url('beer/detail/'.$event->beer_slug);?>"><?php echo $event->beer_name;?></td>
										<!-- <td><?php if(strlen($event->beer_desc)>150){  echo substr($event->beer_desc,0,150); } else { echo $event->beer_desc; }?></td> -->
										<td><?php echo $event->beer_type;?></td>
										<td><?php 
								       	  
								       	  echo  date($site_setting->date_format. " h:i:s",strtotime($event->date_added)); ?></td>
										<td>
											<!-- <a href="javascript://" onclick="editbarevent('<?php echo $event->event_id; ?>')"><i class="strip edit_table"></i></a> -->
											<a href="javascript://" onclick="deletefavbeer('<?php echo $event->beer_id; ?>')" ><i class="strip delete"></i></a>
										</td>
									</tr>
								<?php $i++; } } else { ?>
									<tr>
										<td colspan="6">No any favorite beer found .</td>
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
			setupLabel();
			bindJquery();
			return false;
			
		});

      
</script>
