

<div class="padtb10">
	<input type="hidden" name="postcard" id="postcard" value="0"  />
     	<div>
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	     				<h1 class="result_search_text box_title" id="login-block">Find Cocktails</h1>
	     				
     				</div><br>
                    
     				<div class="pad20">
     				
     				<form method="post" action="<?php echo site_url('cocktail/lists/');?>" role="form" id="bar_form_v113" class="form-horizontal mart10">
                   <div class="form-group">
                       <label class="col-sm-3 control-label" for="inputEmail3">Search  :</label>
                       <div class="col-sm-8 input_box">
                           <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input type="text" placeholder="Cocktail search by name" class="form-control form-pad" id="keyword" name="keyword" autocomplete="off">
                           <div class="clearfix"></div>
                           <span id="clickall1122" for="keyword" class="help-inline" style="display: none; ">This field is required.</span>
                       </div>
                   </div><br>
                  
                   <div class="form-group">
                   		<div class="center">
	                   		<!-- <div class="col-sm-7"> -->
	                   		<input type="hidden" value="10" id="limit" name="limit">
	                       		<a onclick="click1_cocktail()"  class="btn btn-lg btn-primary text-center  marr_10">Start Search</a>      
	                       		<div class="clearfix"></div>
	                       <!-- </div> -->
                       </div> 
                       
                       
                       <!-- <div class="text-center padt5"><a href="#" class="white">Submit a bar to the Directory</a></div> -->
                  </div>
                   	<!-- <div class="pull-left marl30r10">
                       <button class="btn btn-lg btn-primary btn-block text-center" type="submit">Search Your Bar</button>        
                   </div>
                   <div class="pull-left padt5"><a href="#">Submit A Bar To Directory</a></div>
                  </div> -->
              </form>
	        			
	        		</div>

				</div>
					    	<!-- <a class="accordion_tabs" href="#tab2">Bar Owner</a> -->
	        				
					    	
	        				
	        				 
	                       	
	        			</form>
	        			</div>
	        			
	        			
	                </div>
	        			
   		</div>
   	</div>
<script type="text/javascript">
 function click1_cocktail()
  {
  	 	if($("#keyword").val()=='')
  	 	{
  	 		$("#clickall1122").show();
  	 		return false;
  	 	}
  	 	
  	 	else
  	 	{
  	 			$('#bar_form_v113').submit();
  	 		    return true;
  	 	}
  	 
  }
</script>