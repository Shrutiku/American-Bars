<?php			 
					$attributes = array('name'=>'actionevent','id'=>'actionevent','data-target'=>'.content');
					echo form_open('user/actiongallery',$attributes);?> 
					<input type="hidden" name="action" id="action" />
					    					<div class="table-responsive">
     						<div id="responsecomment">
     							<div class="pagination" id="at_ajax">
	     				<?php echo $page_link;?>
     				</div><div class="clearfix"></div>
							<table  class="table  sorted_table table border">
								<thead>
									
									<th><label  class="radio-checkbox label_check c_on group-checkable" for="checkbox-00"><input type="checkbox" data-set=".checkboxes" name="sample-checkbox-00" id="checkbox-00" value="1"></label></th>
										<th>Reorder</th>
									<th>Title</th>
									<th>Date</th>
									<th>Status</th>
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
									<tr data-id="<?php echo $event->bar_gallery_id; ?>" class="<?php echo $dark; ?>" id='remove_event_<?php echo $event->bar_gallery_id; ?>'>
										
										<td><label class="radio-checkbox label_check c_on" for="checkbox-<?php echo  $event->bar_gallery_id;?>">
											<input type="checkbox"  class="checkboxes" name="chk[]" id="checkbox-<?php echo  $event->bar_gallery_id;?>" value="<?php echo $event->bar_gallery_id;?>"></label></td>
											<td ><i class="strip sort_icon"></i></td>
										<td><?php echo $event->title;?></td>
										<td><?php echo $event->date_added;?></td>
										<td><?php echo ucfirst($event->status);?></td>
										<td>
											<a href="javascript://" onclick="editbargallery('<?php echo $event->bar_gallery_id; ?>')"><i class="strip edit_table"></i></a>
											<a href="javascript://" onclick="deletegallery('<?php echo $event->bar_gallery_id; ?>')" ><i class="strip delete"></i></a>
										</td>
									</tr>
								<?php $i++; } } else { ?>
									<tr>
										<td colspan="5">No any bar gallery found .</td>
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

      
$('#add_row').click(function(){
		var cnt=parseInt($('#cntpro').val())+1;
		if($('#cntpro').val() =='NaN')
		{
		    $('#cntpro').val('1');
		    cnt = 1;
		}
		$('#cntpro').val(cnt)
		$('#inner').append('<div class="padtb" id="img_'+cnt+'" style="display:none;"><div class="col-sm-3 text-right"><label class="control-label"></label></div><div class="input_box upload_btn" data-provides="fileupload"><div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div><div class="input_box upload_btn"><span class="fileupload-exists"></div><input type="file" class="form-control form-pad" name="photo_image[]" id="photo_image_'+cnt+'" /></span></div><a href="javascript://" class="btn btn-lg btn-primary search marr_10 pull-left" onclick="removeImageDive(\''+cnt+'\')"><span class="glyphicon glyphicon-minus"></span></a></div></div><div class="clear"></div>');
		$('#img_'+cnt).slideDown();
			
		});
function removeImageDive(id)
	{
		var cnt=parseInt($('#cntpro').val())-1;
		$('#cntpro').val(cnt);
		$('#img_'+id).slideUp('normal',function(){	$(this).remove(); });
	}
</script>
