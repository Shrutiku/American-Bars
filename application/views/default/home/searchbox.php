


<style>
	.ui-front
	{
		z-index:1111 !important;
	}
</style>
<script type="text/javascript">

$(document).ready(function(){
	
		$('.tags1236').autocomplete({
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('bar/auto_suggest_bar/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
							 response( $.map( data, function( item ) {
								return {
									label: item.label,
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		      
	
	
	
});
	
</script>
<div class="padtb10">
	<input type="hidden" name="postcard" id="postcard" value="0"  />
     	<div>
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	     				<h1 class="result_search_text box_title" id="login-block">Find a Bar! &nbsp;&nbsp; Search by any field below !</h1>
	     				
     				</div>
                    
     				<div class="pad20">
     				<span id="clickall" for="zipcode" class="help-inline" style="display: none; text-align: center;">Please fill atleast one field .</span>
     				
     				<form method="post" action="<?php echo site_url('bar/lists/');?>" role="form" id="bar_form_v" class="form-horizontal mart10">
                   <div class="form-group">
                       <label class="col-sm-3 control-label" for="inputEmail3">Search By Name :</label>
                       <div class="col-sm-8 input_box">
                           <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input onkeydown="if (event.keyCode == 13) { click1('one'); return false; }" type="text" placeholder="Start typing name..." class="form-control form-pad tags1236 search-control ui-autocomplete-input" id="bar_title1" name="bar_title" autocomplete="off">
                           <!-- <a onclick="click1('one')" class="btn btn-lg btn-primary search-icon" name="" ><i class="glyphicon glyphicon-search"></i></a> -->
                           <div class="clearfix"></div>
                       <span id="click1" for="bar_title1" class="help-inline" style="display: none;">This field is required.</span>
                       </div>
                   </div>
                   <div class="form-group">
                       <label class="col-sm-3 control-label" for="inputEmail3">Search By State :</label>
                       <div class="col-sm-8 input_box">
                           <input type="text" onkeydown="if (event.keyCode == 13) { click1('two'); return false; }" placeholder="State" id="state123" name="state" class="form-control form-pad search-control" >
                           <!-- <a onclick="click1('two')" class="btn btn-lg btn-primary search-icon" name="" ><i class="glyphicon glyphicon-search"></i></a> -->
                           <div class="clearfix"></div>
                       <span id="click2" for="state123" class="help-inline" style="display: none;">This field is required.</span>
                       </div>
                   </div>
                    <div class="form-group">
                       <label class="col-sm-3 control-label" for="inputEmail3">Search By City :</label>
                       <div class="col-sm-8 input_box">
                           <input type="text" placeholder="City" onkeydown="if (event.keyCode == 13) { click1('three'); return false; }" id="city123" name="city" class="form-control form-pad search-control">
                           <!-- <a onclick="click1('three')" class="btn btn-lg btn-primary search-icon" name="" ><i class="glyphicon glyphicon-search"></i></a> -->
                           <div class="clearfix"></div>
                       <span id="click3" for="city123" class="help-inline" style="display: none;">This field is required.</span>
                       </div>
                  	</div>
                   <div class="form-group">
                       <label class="col-sm-3 control-label" for="inputEmail3">Search By Zip Code :</label>
                       <div class="col-sm-8 input_box">
                           <input type="text" placeholder="Zip Code" onkeydown="if (event.keyCode == 13) { click1('four'); return false; }" id="zipcode" name="zipcode" class="form-control form-pad search-control">
                           <!-- <a onclick="click1('four')" class="btn btn-lg btn-primary search-icon" name="" ><i class="glyphicon glyphicon-search"></i></a> -->
                           <div class="clearfix"></div>
                       <span id="click4" for="zipcode" class="help-inline" style="display: none;">This field is required.</span>
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
	                       		<a onclick="click1('five')"  class="btn btn-lg btn-primary text-center  marr_10">Start Search</a>
	                       		<a href="javascript://" onclick="openSug()" class="btn btn-lg btn-primary text-center">Help Us Find Every Bar!</a>  
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
  function click1(ty)
  {
  	
  	 if(ty=='one')
  	 {
  	 	if($("#bar_title1").val()=='')
  	 	{
  	 		$("#click1").show();
  	 		return false;
  	 	}
  	 	else
  	 	{
  	 		$("#state123").val('');
  	 		$("#city123").val('');
  	 		$("#zipcode").val('');
  	 		
  	 			$('#bar_form_v').submit();
  	 		return true;
  	 	}
  	 }else if(ty=='two')
  	 {
  	 	if($("#state123").val()=='')
  	 	{
  	 		$("#click2").show();
  	 		return false;
  	 	}
  	 	else
  	 	{
  	 			$("#bar_title1").val('');
  	 		$("#city123").val('');
  	 		$("#zipcode").val('');
  	 			$('#bar_form_v').submit();
  	 		return true;
  	 	}
  	 }
  	 else if(ty=='three')
  	 {
  	 	if($("#city123").val()=='')
  	 	{
  	 		$("#click3").show();
  	 		return false;
  	 	}
  	 	else
  	 	{
  	 			$("#bar_title1").val('');
  	 		$("#state123").val('');
  	 		$("#zipcode").val('');
  	 			$('#bar_form_v').submit();
  	 		return true;
  	 	}
  	 }
  	 else if(ty=='four')
  	 {
  	 	if($("#zipcode").val()=='')
  	 	{
  	 		$("#click4").show();
  	 		return false;
  	 	}
  	 	else
  	 	{
  	 			$("#bar_title1").val('');
  	 		$("#city123").val('');
  	 		$("#state123").val('');
  	 			$('#bar_form_v').submit();
  	 		return true;
  	 	}
  	 } 
  	 else if(ty=='five')
  	 {
  	 	if($("#bar_title1").val()=='' && $("#state123").val()=='' && $("#city123").val()=='' && $("#zipcode").val()=='')
  	 	{
  	 		$("#clickall").show();
  	 		return false;
  	 	}
  	 	
  	 	else
  	 	{
  	 			$('#bar_form_v').submit();
  	 		    return true;
  	 	}
  	 }
  	 
  }
	
</script>