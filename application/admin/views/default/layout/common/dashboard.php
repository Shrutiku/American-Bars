
<div class="page_content">

			<div class="container_fluid">
		
				
					<?php 

		if($msg != ""){
	       if($msg == "insert"){ $msg = ADD_NEW_RECORD;}
            if($msg == "update"){ $msg = UPDATE_RECORD;}
            if($msg == "delete"){ $msg = DELETE_RECORD;}
			if($msg == "active") {  $msg = ACTIVE_RECORD;}
			if($msg == "inactive"){ $msg = INACTIVE_RECORD;}
			if($msg == "rights"){ $msg = ASSIGN_RIGHTS;}
    ?>
        <div class="success_msg"><?php echo '<p>You have no rights to access this section.</p>';?></div>
    <?php } ?>
				
			</div>
		</div>
	</div>