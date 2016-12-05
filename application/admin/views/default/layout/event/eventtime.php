<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h3>Event Time</h3>
</div>
<div class="modal-body">
<div class="row-fluid">
		<div class="alert alert-error" id="errorDiv" style="display: none;"></div>
	<ul class="control_group">
		<?php
     						
     						 if($eventtime){
     							  foreach($eventtime as $r){?>
                        	<li>
                        		<label class="control_label"><b>Date :</b> <?php echo date('l, F j, Y',strtotime($r->eventdate)) ."<br> <b>Time :</b> ". $r->eventstarttime." - ".$r->eventendtime; ?></label>
                            </li>
                            <?php } } else {?>
                            	<h3>No record founds.</h3>
                            <?php } ?>	
										
																			
										<div class="clear"></div>
									</ul>
									
									
									
		
</div>
</div>
<div class="modal-footer">
	
</div>

