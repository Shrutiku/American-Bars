<div class="wrapper row6 padtb10 has-js">
     	<div class="container">
     		<div class="margin-top-50 bg_brown">
     			<?php echo $this->load->view(getThemeName().'/home/dashboard_menu'); ?>
     			<div class="dashboard_detail">
     				<div class="result_search event"><div class="result_search_text"><i class="strip social_share"></i> Social Share - Twitter</div></div>
		     		<div class="dashboard_subblock">
		     		<div>
     					
					
					
					<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
					<!-- <form name="add_event" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('bar/add_event/'.base64_encode($getbar['bar_id'])); ?>"> -->
						
     			
		     	</div>
     		</div>
     	<div class="clearfix"></div>
     	<div class="pad20">
     		<h2> Welcome <?php echo $this->session->userdata('screen_name');?> <a class="listing-title" href="<?php echo site_url('home/twitterlogout')?>" >Logout</a></h5>
     		<a href="<?php echo site_url('home/socialshare')?>"  class="btn btn-lg btn-primary marr_10 pull-right" >Back</a>
     		        <a href="javascript://" onclick="openpost()" id="hide_this" class="btn btn-lg btn-primary marr_10 pull-right" >Create New Post</a><div class="clearfix"></div>
     					<div class="reult_sub_title"><h4 class="media-heading"><a class="pull-left listing-title">Posts List</a></h4></div><div class="clearfix"></div><br>
     					<ul class="happy-list result_sub_box" id="infinite-list">
     						
     						<div class="clearfix"></div><?php
     						
     						 if($getposttw){
     							  foreach($getposttw as $r){?>
                        	<li class="active">
                            	<p class="happy-title"><?php echo ucfirst($r->comment);?></p>
                                <p class="happy-text"><?php echo getDuration($r->date) ;?></p>
                            </li>
                            <?php } } else {?>
                            	<h3>No any post founds.</h3>
                            <?php } ?>	
                            </li>
                        </ul>	
     						
     						
     				</div>	
     </div>
     
   </div>
   
 </div>
 
 
    
 <div class="modal fade login_pop2" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	<div class="padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button  onclick="change_url()" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	     				<i class="strip login_icon"></i><div class="result_search_text">Post To Twitter</div>
     				</div>
     				
     				<div class="pad20">
     						<div id="ajax_msg_error_reg"></div>
     						<div class="error1 hide1" id="cm-err-main" style="text-align: center;">&nbsp;</div>
     						<form name="frm_add_review" enctype="multipart/form-data" id="frm_add_review" method="post" class="form-horizontal" action="<?php echo site_url("home/shareontwitter"); ?>">
     						<div class="error1 hide1 center" id="cm-err-main">&nbsp;</div>
	                       	
	                       	<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Description :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		 <textarea name="comment" maxLength='100' id="comment" class="form-control form-pad"  onKeyDown="limitText(event,this.form.comment,this.form.countdown,100 );" 
onKeyUp="limitText(event,this.form.comment,this.form.countdown,100 );"   placeholder="Write Here"></textarea>
	                           		 <span>This textarea has a limit of 100 characters.</span>
	                           		 <div class="padtb10 pull-right">
							<font size="2">
							You have <input readonly type="text" style="background-color:transparent; border: 0; width: 23px; font-weight: bold;" name="countdown" id="countdown" size="3" value="100">Characters left.</font>
     					</div>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       		
	                       		
	                       	</div>
	                       	
	                       	<input type="hidden" name="fbid" id="fbid" value="" />
	                       	
	                       	 <div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10">
									<button class="btn btn-lg btn-primary" type="submit">Post</button>									
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	</form>	
	                       	
	                       	
	                       		
     				</div>		
     				
     			</div>
     		</div>
     	</div>
     </div>	
</div>




<script>

	function limitText(e,limitField, limitCount, limitNum) 
	{  
		  
		content = document.getElementById('comment').value.replace(/\n/g, '<br>');
		   newLines = limitField.value.split("\n").length;
		   
		
		 if (limitField.value.length > limitNum || (e.keyCode != 13 && newLines>=16)) {
		 
		limitField.value = limitField.value.substring(0, limitNum);
		return false;
	} else {
		
		  $("#linesUsed").html(newLines);
		limitCount.value = limitNum - limitField.value.length;
		  limitField.selected = false;
	}
	}
function maxLength(el) {	
	if (!('maxLength' in el)) {
		var max = el.attributes.maxLength.value;
		el.onkeypress = function () {
			if (this.value.length >= max) return false;
		};
	}
}


function openpost()
{
	$("#myModal1").modal('show');
	// $("#open_this").fadeIn();
	// $("#hide_this").fadeOut();
}

	$(document).ready(function () {
 	maxLength(document.getElementById("comment"));
 	<?php if($msg=='success'){?>
 		$.growlUI('<?php echo "Message Posted Successfully."; ?>'); 
 		
 	<?php } ?>	
 	
 	<?php if($msg=='logout'){?>
 		$.growlUI('<?php echo "You have successfully logged out."; ?>'); 
 		
 	<?php } ?>
 });
</script>



<!--------------Scroll ------------------->
	<link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/css/prettify.css">
	<script src="<?php echo base_url().getThemeName(); ?>/js/jquery.slimscroll.js"></script>
	<script src="<?php echo base_url().getThemeName(); ?>/js/prettify.js"></script>
	<script type="text/javascript">
		$(function(){
		      $('#infinite-list').slimscroll({
		        alwaysVisible: true,
		        height: 600,
		        color: '#f19d12',
		        wheelStep: 1,
		        opacity: .8
		      });
		      
		       $('#infinite-list-fb').slimscroll({
		        alwaysVisible: true,
		        height: 410,
		        color: '#f19d12',
		        wheelStep: 1,
		        opacity: .8
		      });
		       $('#infinite-list-in').slimscroll({
		        alwaysVisible: true,
		        height: 410,
		        color: '#f19d12',
		        wheelStep: 1,
		        opacity: .8
		      });
		      
		  });
		  
		   function change_url()
 {
 	window.location = '<?php echo site_url('home/twitterpost/');?>'
 }
	</script>
	<!--------------End Scroll ------------------->
<style>
 #infinite-list {
    height: 600px;
    margin-left: auto;
    margin-right: auto;
    overflow-x: hidden;
    overflow-y: scroll;
}
#infinite-list-fb {
    height: 410px;
    margin-left: auto;
    margin-right: auto;
    overflow-x: hidden;
    overflow-y: scroll;
}
#infinite-list-in {
    height: 410px;
    margin-left: auto;
    margin-right: auto;
    overflow-x: hidden;
    overflow-y: scroll;
}
</style>	
