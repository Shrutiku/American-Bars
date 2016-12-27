<?php date_default_timezone_set("Europe/London"); ?>
<style type="text/css">
	.page_title h2{ font-family: 'open_sanslight'; font-size: 20px; font-weight:bold; color:#888; }
	.br_bottom { border-bottom: 1px solid #888; margin-bottom: 10px; }
	.pad10 { padding: 20px; }
	.app_text { color: #747373; font-family: 'open_sanslight'; font-size: 13px; margin: 0 0 10px; }
	.app_text span.app_title { color: #4A4A4A; display: inline-block; font-family: 'open_sanslight'; font-size: 14px; font-weight: 500; margin-right: 10px; width: 120px;}

	.mesg_left { float:left;  font-weight:bold; margin-right:5px; padding:5px; width:120px;}
	.mesg_right { float:right; width:265px;  padding:5px;}
	.row_flue { display:block; margin-bottom:5px; clear:both;}
	.row_flue p {margin:0; padding:0;}
</style>
<div id="pop_up_box" style="color:#000; width:800px; min-height:300px; padding:0px 10px;" >
	<div class="page_title br_bottom">
	  <h2>Message Detail</h2>
	</div>
	<div class="pad10">
	
	<div class="row_flue">	
		<div class="mesg_left"> From: </div>
		<div class="mesg_right"> <?php echo get_user_detail($message_detail['from_user_id'], $message_detail['from_user_type'])." (".ucfirst($message_detail['from_user_type'])." )";?></div>
	</div>
	
	<?php if($msg_type == 'sentbox'){ ?>
		<div class="row_flue">	
			<div class="mesg_left"> To: </div>
			<div class="mesg_right"> <?php echo get_user_detail($message_detail['to_user_id'], $message_detail['to_user_type'])." (".ucfirst($message_detail['to_user_type'])." )";?></div>
		</div>
	<?php }?>
	
	<div class="row_flue">	
		<div class="mesg_left"> Subject:</div>
		<div class="mesg_right"> <?php echo $message_detail['subject']; ?></div>
	</div>
	<div class="row_flue">	
		<div class="mesg_left">Description: </div>
		<div class="mesg_right"><?php echo html_entity_decode($message_detail['description']); ?></div>
	</div>
	<div class="row_flue">	
		<div class="mesg_left">Received Date: </div>
		<div class="mesg_right"><?php echo date($site_setting->date_format,strtotime($message_detail['date_added'])); ?></div>
	</div>
 

		<?php /*?><p class="app_text"><span class="app_title">From:</span>  <?php echo get_user_detail($message_detail['from_user_id'], $message_detail['from_user_type'])." (".ucfirst($message_detail['from_user_type'])." )";?></p>
		<p class="app_text"><span class="app_title">Subject :</span>  <?php echo $message_detail['subject']; ?></p>
		<p class="app_text"><span class="app_title">Description :</span>  <?php echo html_entity_decode($message_detail['description']); ?></p>
		<p class="app_text"><span class="app_title">Received Date :</span>  <?php echo date("Y-m-d g:i A",strtotime($message_detail['date_added'])); ?></p><?php */?>
	</div>
</div>