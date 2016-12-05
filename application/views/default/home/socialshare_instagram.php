<div class="wrapper row6 padtb10 has-js">
     	<div class="container">
     		<div class="margin-top-50 bg_brown">
     			<?php echo $this->load->view(getThemeName().'/home/dashboard_menu'); ?>
     			<div class="dashboard_detail">
     				<div class="result_search event"><div class="result_search_text"><i class="strip social_share"></i> Social Share - Instagram</div></div>
		     		<div class="dashboard_subblock">
		     		<div>
     					
					
					
					<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
					<!-- <form name="add_event" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('bar/add_event/'.base64_encode($getbar['bar_id'])); ?>"> -->
						
     			
		     	</div>
     		</div>
     	<div class="clearfix"></div>
     	<div class="pad20">
     		<h2><?php echo $this->session->userdata("insta_username")!='' ? 'Welcome '.$this->session->userdata("insta_username"):''?> <a class="listing-title" href="<?php echo site_url('home/insta_logout')?>"  >Logout</a></h5>
     			<a href="<?php echo site_url('home/socialshare')?>"  class="btn btn-lg btn-primary marr_10 pull-right" >Back</a>
     		        <a href="javascript://" onclick="openpost()" id="hide_this" class="btn btn-lg btn-primary marr_10 pull-right" >Create New Post</a><div class="clearfix"></div>
     					<div class="reult_sub_title"><h4 class="media-heading"><a class="pull-left listing-title">Posts List</a></h4></div><div class="clearfix"></div><br>
     					<ul class="happy-list result_sub_box" id="infinite-list">
     						
     						<div class="clearfix"></div><?php
     						
     						 if($getpostin){
     							  foreach($getpostin as $r){?>
                        	<li class="active">
                            	<p class="happy-title"><?php if(strip_tags(strlen($r->comment)>200)){ echo substr(strip_tags($r->comment),0,200).'...' ; } else { echo strip_tags($r->comment); } ?></p>
                                <p class="happy-text"><?php echo getDuration($r->date) ;?> <?php if($r->image){?><a class="yellow_text" target="_blank" href="<?php echo ucfirst($r->image);?>">View Image</a><?php } ?></p>
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
	     				<i class="strip login_icon"></i><div class="result_search_text">Post To Instagram</div>
     				</div>
     				<div class="pad20" >
     						<div id="ajax_msg_error_reg"></div>
     						<div class="error1 hide1" id="cm-err-main" style="text-align: center;">&nbsp;</div>
     						<form name="posttoinstagram" enctype="multipart/form-data" id="frm_add_review" method="post" class="form-horizontal" action="<?php echo site_url("home/shareoninstagram"); ?>">
     						<div class="error1 hide1 center" id="cm-err-main">&nbsp;</div>
	                       	
	                       	<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Description :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		 <textarea name="comment_insta" required  id="comment_insta" class="form-control form-pad" ></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       		
	                       		
	                       	</div>
	                       	
	                       	<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Image :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		 <input name="image_insta" required="required" type="file"  id="image_insta" class="form-control form-pad" accept="image/jpeg" >
	                       		</div>
	                       		<div class="clearfix"></div>
	                       		
	                       		
	                       	</div>
	                       	
	                       	
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




function openpost()
{
	$("#myModal1").modal('show');
	// $("#open_this").fadeIn();
	// $("#hide_this").fadeOut();
}

	$(document).ready(function () {
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
		      
		  });
		  
		   function change_url()
 {
 	window.location = '<?php echo site_url('home/instagrampost/');?>'
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
</style>	
