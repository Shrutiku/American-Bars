<?php if($result){
     			
     			   foreach($result as $row){?>		
     				<div class="padtb10 pad_lr10 br_bott_gray ">
     					<a href="" class="beer_title"><?php echo $row->dictionary_title;?></a>
     					<div class="img_wid95 ">
     						
     						<div class="result_desc padtb10">
     							<?php echo $row->dictionary_description;?>
     						</div>
     						<!-- <div class="padtb10">
     							<div class="pull-left"><a href="#" class="readmore_btn active">Read More</a></div>
     							<div class="pull-right">
     								<a href="#"><i class="strip mail_icon pull-left"></i></a>
     								<a href="#"><i class="strip print pull-left"></i></a>
     								<div class="clearfix"></div>
     							</div>
     							<div class="clearfix"></div>
     						</div> -->
     					</div>
     					
     				</div>
     				
     			<?php } } ?> 
     			
     			<div class="pagination" id="at_ajax">
	     				<?php echo $page_link;?>
     				</div><div class="clearfix"></div>	
     				
     				<input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page;?>"/>
					<input type="hidden" name="offset" id="offset" value="<?php echo ($offset!='')?$offset:0; ?>" />
					<input type="hidden" name="limit" id="limit" value="<?php echo ($limit>0)?$limit:10; ?>" />
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
			
			return false;
			
		});
 </Script>  					