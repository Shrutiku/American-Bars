


<style>
	.ui-front
	{
		z-index:1111 !important;
	}
</style>

<div class="padtb10">
	<input type="hidden" name="postcard" id="postcard" value="0"  />
     	<div>
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	     				<h1 class="result_search_text box_title" id="login-block">Find a Taxi! &nbsp;&nbsp; Search by any field below !</h1>
	     				
     				</div>
                    
     				<div class="pad20">
     				<span id="clickall_taxi" for="zipcode" class="help-inline" style="display: none; text-align: center;">Please fill atleast one field .</span>
     				
     				<form method="post" action="<?php echo site_url('taxiowner/lists/');?>" role="form" id="taxi_form_v" class="form-horizontal mart10">
                   <div class="form-group">
                       <label class="col-sm-3 control-label" for="inputEmail3">Search By Name :</label>
                       <div class="col-sm-8 input_box">
                           <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input onkeydown="if (event.keyCode == 13) { click1('one'); return false; }" type="text" placeholder="Name" class="form-control form-pad search-control" id="taxi_title1" name="taxi_title" autocomplete="off">
                           <!-- <a onclick="click1_taxi('one')" class="btn btn-lg btn-primary search-icon" name="" ><i class="glyphicon glyphicon-search"></i></a> -->
                           <div class="clearfix"></div>
                       <span id="click1_taxi" for="taxi_title1" class="help-inline" style="display: none;">This field is required.</span>
                       </div>
                   </div>
                   <div class="form-group">
                       <label class="col-sm-3 control-label" for="inputEmail3">Search By State :</label>
                       <div class="col-sm-8 input_box">
                           <input type="text" onkeydown="if (event.keyCode == 13) { click1_taxi('two'); return false; }" placeholder="State" id="state123_taxi" name="state_taxi" class="form-control form-pad search-control" >
                           <!-- <a onclick="click1_taxi('two')" class="btn btn-lg btn-primary search-icon" name="" ><i class="glyphicon glyphicon-search"></i></a> -->
                           <div class="clearfix"></div>
                       <span id="click2_taxi" for="state123_taxi" class="help-inline" style="display: none;">This field is required.</span>
                       </div>
                   </div>
                    <div class="form-group">
                       <label class="col-sm-3 control-label" for="inputEmail3">Search By City :</label>
                       <div class="col-sm-8 input_box">
                           <input type="text" placeholder="City" onkeydown="if (event.keyCode == 13) { click1_taxi('three'); return false; }" id="city123_taxi" name="city_taxi" class="form-control form-pad search-control">
                           <!-- <a onclick="click1_taxi('three')" class="btn btn-lg btn-primary search-icon" name="" ><i class="glyphicon glyphicon-search"></i></a> -->
                           <div class="clearfix"></div>
                       <span id="click3_taxi" for="city123_taxi" class="help-inline" style="display: none;">This field is required.</span>
                       </div>
                  	</div>
                   <div class="form-group">
                       <label class="col-sm-3 control-label" for="inputEmail3">Search By Zip Code :</label>
                       <div class="col-sm-8 input_box">
                           <input type="text" placeholder="Zip Code" onkeydown="if (event.keyCode == 13) { click1_taxi('four'); return false; }" id="zipcode_taxi" name="zipcode_taxi" class="form-control form-pad search-control">
                           <!-- <a onclick="click1_taxi('four')" class="btn btn-lg btn-primary search-icon" name="" ><i class="glyphicon glyphicon-search"></i></a> -->
                           <div class="clearfix"></div>
                       <span id="click4_taxi" for="zipcode_taxi" class="help-inline" style="display: none;">This field is required.</span>
                       </div>
                   </div>
                   <!-- <div class="form-group">
                       <label for="inputEmail3" class="col-sm-3 control-label">Search By City :</label>
                       <div class="col-sm-8 input_box clearfix">
                       	<div class="pull-left col-sm-6">
                           <input type="text" class="form-control form-pad" name="city" id="city" placeholder="City"></div>
                           <div class="pull-left cityboxpad col-sm-6">
                           	<label for="inputEmail3" class="col-sm-3 control-label ziplabel">Search By Zip Code :</label>
                           	<input type="text" class="form-control form-pad" name="zipcode" id="zipcode" placeholder="Zip Code">
                           </div>
                       </div>
                   </div> -->
                  
                   <div class="form-group">
                   		<div class="center">
	                   		<!-- <div class="col-sm-7"> -->
	                   		<input type="hidden" value="10" id="limit" name="limit">
	                       		<a onclick="click1_taxi('five')"  class="btn btn-lg btn-primary text-center  marr_10">Start Search</a>      
	                       		<div class="clearfix"></div>
	                       <!-- </div> -->
                       </div> 
                       
                       
                       <!-- <div class="text-center padt5"><a href="#" class="white">Submit a bar to the Directory</a></div> -->
                  </div>
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
  function click1_taxi(ty)
  {
  	
  	 if(ty=='one')
  	 {
  	 	if($("#taxi_title1").val()=='')
  	 	{
  	 		$("#click1_taxi").show();
  	 		return false;
  	 	}
  	 	else
  	 	{
  	 		$("#state123_taxi").val('');
  	 		$("#city123_taxi").val('');
  	 		$("#zipcode_taxi").val('');
  	 		
  	 			$('#taxi_form_v').submit();
  	 		return true;
  	 	}
  	 }else if(ty=='two')
  	 {
  	 	if($("#state123_taxi").val()=='')
  	 	{
  	 		$("#click2_taxi").show();
  	 		return false;
  	 	}
  	 	else
  	 	{
  	 			$("#taxi_title1").val('');
  	 		$("#city123_taxi").val('');
  	 		$("#zipcode_taxi").val('');
  	 			$('#taxi_form_v').submit();
  	 		return true;
  	 	}
  	 }
  	 else if(ty=='three')
  	 {
  	 	if($("#city123_taxi").val()=='')
  	 	{
  	 		$("#click3_taxi").show();
  	 		return false;
  	 	}
  	 	else
  	 	{
  	 			$("#taxi_title1").val('');
  	 		$("#state123_taxi").val('');
  	 		$("#zipcode_taxi").val('');
  	 			$('#taxi_form_v').submit();
  	 		return true;
  	 	}
  	 }
  	 else if(ty=='four')
  	 {
  	 	if($("#zipcode_taxi").val()=='')
  	 	{
  	 		$("#click4_taxi").show();
  	 		return false;
  	 	}
  	 	else
  	 	{
  	 			$("#taxi_title1").val('');
  	 		$("#city123_taxi").val('');
  	 		$("#state123_taxi").val('');
  	 			$('#taxi_form_v').submit();
  	 		return true;
  	 	}
  	 } 
  	 else if(ty=='five')
  	 {
  	 	if($("#taxi_title1").val()=='' && $("#state123_taxi").val()=='' && $("#city123_taxi").val()=='' && $("#zipcode_taxi").val()=='')
  	 	{
  	 		$("#clickall_taxi").show();
  	 		return false;
  	 	}
  	 	
  	 	else
  	 	{
  	 			$('#taxi_form_v').submit();
  	 		    return true;
  	 	}
  	 }
  	 
  }
	
</script>