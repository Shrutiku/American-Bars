	<?php			 
					$attributes = array('name'=>'actionevent','id'=>'actionevent','data-target'=>'.content');
					echo form_open('bar/actioncocktail',$attributes);?> 
					<input type="hidden" name="action" id="action" />
					    					<div class="table-responsive">
     						<div id="responsecomment">
     							<div class="pagination" id="at_ajax">
	     				<?php echo $page_link;?>
     				</div><div class="clearfix"></div>
							<table class="table">
								<thead>
									<th width='5%'><label  class="radio-checkbox label_check c_on group-checkable" for="checkbox-00"><input type="checkbox" data-set=".checkboxes" name="sample-checkbox-00" id="checkbox-00" value="1"></label></th>
									<th width='15%'>Cocktail Name</th>
									<th width='10%'>Type</th>
									<th width='60%'>Ingredients</th>
									<th width='10%'>Action</th>
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
									<tr class="<?php echo $dark; ?>" id='remove_event_<?php echo $event->cocktail_bar_id; ?>'>
										<td><label class="radio-checkbox label_check c_on" for="checkbox-<?php echo  $event->cocktail_bar_id;?>">
											<input type="checkbox"  class="checkboxes" name="chk[]" id="checkbox-<?php echo  $event->cocktail_bar_id;?>" value="<?php echo $event->cocktail_bar_id;?>"></label></td>
										<td><?php echo $event->cocktail_name;?></td>
										<td><?php echo $event->type;?></td>
										<td>
											<?php if(strip_tags(strlen($event->ingredients)>350)){ echo substr(strip_tags($event->ingredients),0,350).'...' ; } else { echo strip_tags($event->ingredients); } ?>
										</td>
										<td>
											<!-- <a href="javascript://" onclick="editbarevent('<?php echo $event->event_id; ?>')"><i class="strip edit_table"></i></a> -->
											<a href="javascript://" onclick="deletecocktail('<?php echo $event->cocktail_bar_id; ?>')" ><i class="strip delete"></i></a>
											<a onclick="morelink('<?php echo $event->cocktail_bar_id; ?>')"><i class="strip view"></i></a>
											<div class="modal fade" id="myModalnew_open_<?php echo $event->cocktail_bar_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Cocktail Ingredients </div>
     				</div>
     				<div class="pad20">
     						<label class="control-label" style="color: #fff;"><?php echo $event->ingredients; ?></label>	
     				</div>		
     			</div>
     		</div>
     	</div>
     </div>
	
</div>
			
											<input type="hidden" name="cocktail_bar_id" id="cocktail_bar_id" value="<?php echo $event->cocktail_bar_id;?>" />
										</td>
									</tr>
								<?php $i++; } } else { ?>
									<tr>
										<td colspan="6">No any events found .</td>
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
