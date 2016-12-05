<div class="wrapper row5">
     	<div class="container">
     		<div class="textbox_block">
     		<div class="result_search">
     			<div class="col-sm-8">
	     			<div class="result_search_text pull-left">DiveBar Statistics</div>
	            </div>
	            <div class="col-sm">
     				<!-- <form class="form-horizontal" id="bar-search-frm" method="post" role="form" action="<?php echo site_url("bar/lists"); ?>"> -->
	                   <div class="form-group pull-right">
	                   	<a class="review text-center" data-toggle="modal" href="javascript://" onclick="openSug()">Help Us Find Bars!</a>
	                    </div>      
	                <!-- </form> -->
	              </div>
	            <div class="clearfix"></div>
     		</div>
     		<!-- <div class="br_bott_yellow">
     			<div class="padt10">
     				<form class="form-horizontal" role="form">
	                   <div class="form-group">
	                       <div class="col-sm-4 input_box pull-left">
	                           <input type="text" class="form-control form-pad" id="inputEmail3" placeholder="Type Keyword Here">
	                       </div>
	                       <div class="col-sm-2 input_box pull-left">
                        		<a href="#" class="btn btn-lg btn-primary"><i class="strip search"></i></a>
                       	   </div>
                       	   <div class="clearfix"></div>
	                    </div>
                    </form>
     			</div>
     			<div class="clearfix"></div>
	     	</div> -->
     		<div class="clearfix"></div>
     		
     <?php if($statistics){ 
     	    ?>		
     		<div class="mar_top20">
	   			<a href="javascript:toggleDiv('myContent');" class="addnew"><div class="divebar_statistics active">Dive Bars</div></a>
	   			
					<div id="myContent" class="img_br_yellow padtb10 pad_lr10">
						<?php foreach($statistics as $row){
     	   			  switch($row->category) {
		   			  case "dive_bars": ?> 
						<ul class="beerdirectory">
							
						   <li>
						       <div class="pull-left yellow_text marr_10 statistic-title"><?php echo $row->question; ?>  </div>
						       <div class="white_text margin-left-198"><?php echo $row->answer; ?></div>
						       <div class="clearfix"></div>
						</ul>
						<?php break;?>
	   		<?php  } } ?>
					</div>
					
	   			</div>
	   			<?php } ?>	
	   			<div class="mar_top20">
	   			<a href="javascript:toggleDiv('myContent1');" class="addnew"><div class="divebar_statistics">Food</div></a>
					<div id="myContent1" class="img_br_yellow padtb10 pad_lr10" style="display: none;">
						<?php foreach($statistics as $row){
     	   			  switch($row->category) {
		   			  case "food": ?> 
						<ul class="beerdirectory">
							
						   <li>
						       <div class="pull-left yellow_text marr_10 statistic-title"><?php echo $row->question; ?> </div>
						       <div class="white_text margin-left-198"><?php echo $row->answer; ?></div>
						       <div class="clearfix"></div>
						</ul>
						<?php break;?>
	   		<?php  } } ?>
					</div>
	   			</div>
	   			<div class="mar_top20">
	   			<a href="javascript:toggleDiv('myContent2');" class="addnew"><div class="divebar_statistics">Drink</div></a>
					<div id="myContent2" class="img_br_yellow padtb10 pad_lr10" style="display: none;">
						<?php foreach($statistics as $row){
     	   			  switch($row->category) {
		   			  case "drink": ?> 
						<ul class="beerdirectory">
							
						   <li>
						       <div class="pull-left yellow_text marr_10 statistic-title"><?php echo $row->question; ?>  </div>
						       <div class="white_text margin-left-198"><?php echo $row->answer; ?></div>
						       <div class="clearfix"></div>
						</ul>
						<?php break;?>
	   		<?php  } } ?>
					</div>
	   			</div>
	   			<div class="mar_top20">
	   			<a href="javascript:toggleDiv('myContent3');" class="addnew"><div class="divebar_statistics">HangOvers</div></a>
					<div id="myContent3" class="img_br_yellow padtb10 pad_lr10" style="display: none;">
						<?php foreach($statistics as $row){
     	   			  switch($row->category) {
		   			  case "hangovers": ?> 
						<ul class="beerdirectory">
							
						   <li> 
						       <div class="pull-left yellow_text marr_10 statistic-title"><?php echo $row->question; ?>  </div>
						       <div class="white_text margin-left-198"><?php echo $row->answer; ?></div>
						       <div class="clearfix"></div>
						</ul>
						<?php break;?>
	   		<?php  } } ?>
					</div>
	   			</div>
	   			<div class="mar_top20">
	   			<a href="javascript:toggleDiv('myContent4');" class="addnew"><div class="divebar_statistics">Countries</div></a>
					<div id="myContent4" class="img_br_yellow padtb10 pad_lr10" style="display: none;">
						<?php foreach($statistics as $row){
     	   			  switch($row->category) {
		   			  case "countries": ?> 
						<ul class="beerdirectory">
							
						   <li>
						       <div class="pull-left yellow_text marr_10 statistic-title"><?php echo $row->question; ?>  </div>
						       <div class="white_text margin-left-198"><?php echo $row->answer; ?></div>
						       <div class="clearfix"></div>
						</ul>
						<?php break;?>
	   		<?php  } } ?>
					</div>
	   			</div>
	   			<div class="mar_top20">
	   			<a href="javascript:toggleDiv('myContent5');" class="addnew"><div class="divebar_statistics">Records</div></a>
					<div id="myContent5" class="img_br_yellow padtb10 pad_lr10" style="display: none;">
						<?php foreach($statistics as $row){
     	   			  switch($row->category) {
		   			  case "records": ?> 
						<ul class="beerdirectory">
							
						   <li>
						       <div class="pull-left yellow_text marr_10 statistic-title"><?php echo $row->question; ?> </div>
						       <div class="white_text margin-left-198"><?php echo $row->answer; ?></div>
						       <div class="clearfix"></div>
						</ul>
						<?php break;
						       ?>
	   		<?php  } } ?>
					</div>
	   			</div>
     		</div>
   		</div>
   	</div>
<script type="text/javascript">

	function toggleDiv(divId) {
	   $("#"+divId).toggle();
	   
	   
	}
	</script>

<div class="modal fade" id="helpfindbar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<?php echo $this->load->view(getThemeName().'/bar/bar_suggest');?>
</div>	