
<script type="text/javascript">
	$(document).ready(function(){
//===== Usual validation engine=====//
	$("#step_1").validate({
		rules: {			
			email: {
				required: true,
				email: true
			},			
			bar_title: {
				required: true,
				
			},	
			last_name: {
				lettersspaceonly:true,
				required: true,
			},	
			first_name: {
				lettersspaceonly:true,
				required: true,
			},	
			address: {
				required: true,
			},	
			
			// bar_meta_title: {
				// required: true,
			// },
			// bar_meta_keyword: {
				// required: true,
			// },
			// bar_meta_description: {
				// required: true,
			// },	
			city: {
				lettersspaceonly:true,
				required: true,
			},
			state: {
				lettersspaceonly:true,
				required: true,
			},
			zip: {
				required: true,
			},				
		  	errorClass:'error fl_right'			
		}
	});	
});
</script>
<!-- ########################################################################################### -->
<!-- content -->
<div class="wrapper row6 padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
	     				<i class="strip login_icon"></i><div class="result_search_text">Registration</div>
     				</div>
     				<div>
     				<h1 class="yellow_title padb10 br_bott_gray text-center padding-bottom-15">Bar Owner Registration Step2</h1>
     				<div>
     					<ul class="registration_steplist">
     						<li ><a href="<?php echo site_url('home/bar_owner_register')?>">Step 1</a></li>
     						<li class="active" ><a href="<?php echo site_url('home/registration_step2')?>">Step 2</a></li>
     						<li><a href="<?php echo site_url('home/registration_step3')?>">Step 3</a></li>
     						<li class="last"><a href="<?php echo site_url('home/registration_step4')?>">Step 4</a></li>
     						<div class="clearfix"></div>
     					</ul>
     				</div>
     				<div class="pad20">
     					<?php
				if($error != "")
				{
					echo "<div class='error1 text-center'>".$error."</div>";
				}			
				if($msg != "" && $msg != "1V1")
				{
					echo "<div class='success text-center'>".$msg."</div>";
				}			
  			?>
	     				<form class="form-horizontal" role="form" name="step_1" id="step_1" action="<?php echo site_url("home/claimbar_registration_step2/".$type); ?>" method="post">
	     					
	     					
	     					<input type="hidden" name="bar_id" id="bar_id" value="<?php echo $bar_id;?>" />
	        				 <div class="padtb mar_top20">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Bar Name : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" name="bar_title" maxlength="40"  class="tags form-control form-pad" id="bar_title" placeholder="Bar Name" <?php if($this->session->userdata('viewid_orig')!='' && $this->session->userdata('viewid_orig')!=0){ ?> <?php }?> value="<?php echo @$bar_title; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">First Name : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" maxlength="40" name="first_name" id="first_name1" value="<?php echo @$first_name; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Last Name : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" maxlength="40" id="last_name1" name="last_name" value="<?php echo @$last_name; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Email : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="email1" name="email" value="<?php echo @$email; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div  class="padtb">
	                       		<div class="col-sm-3">
	        				 		<label class="control-label">Gender :</label>
	        				 	</div>
	        				 	<div class="padb10 col-sm-7">
				     				<div class="radio pull-left">
					     				<label>
					          				<input type="radio" value="male" <?php echo @$male=='male' ? 'checked':'';?> name="gender" id="gender" checked> Male
					        			</label>
				        			</div>
				        			<div class="radio pull-left">
					     				<label>
					          				<input type="radio" value="female" <?php echo @$female=='female' ? 'checked':'';?> name="gender" id="gender" > Female
					        			</label>
				        			</div>
			        				<div class="clearfix"></div>
	        					</div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Address : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<textarea rows="5" placeholder="Address" name="address" id="address1" class="form-control form-pad"><?php echo @$address; ?></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">City : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="city1" name="city" value="<?php echo @$city; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">State : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7" name="state_id" id="state_id">
	                           		<input type="text" class="form-control form-pad" id="state1" name="state" value="<?php echo @$state; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Zip Code : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="zipcode1" name="zip" value="<?php echo @$zip; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Description : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<textarea rows="5" placeholder="Description" name="desc" id="desc" class="form-control form-pad"><?php echo @$desc; ?></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       		<!-- <div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Meta Title : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="bar_meta_title" name="bar_meta_title" value="<?php echo @$bar_meta_title; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       		<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Meta Keyword : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="bar_meta_keyword" name="bar_meta_keyword" value="<?php echo @$bar_meta_keyword; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Meta Description : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<textarea rows="5" placeholder="Meta Description" name="bar_meta_description" id="bar_meta_description" class="form-control form-pad"><?php echo @$bar_meta_description; ?></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div> -->
	                       	
	                       	<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10">
	                       			<input class="btn btn-lg btn-primary pull-right"  type="submit" name="submit" value="Next" id="submit" />
	                       			<a class="btn btn-lg btn-primary" href="<?php echo site_url('home/bar_owner_register/'.$type);?>">Back</a>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<input type="hidden" name="temp_id" id="temp_id" value="<?php echo @$getbardata['temp_id']?>" />
	                       	<input type="hidden" name="user_id" id="user_id" value="" />
	        			</form>
	        			</div>
	        		</div>
     			</div>
     		</div>
   		</div>
   	</div>
<!-- ************************************************************************ -->


<script>
    	 $(document).ready(function(){
		$('.tags').autocomplete({
			
		      	source: function( request, response ) {
		      		$.ajax({
		      			url : '<?php echo site_url('bar/auto_suggest_bar_lab/');?>',
		      			dataType: "json",
						data: {
						   em: request.term,
						},
						 success: function( data ) {
						 	if(data=='')
						 	{ $("#first_name1").val('');
						     $("#last_name1").val('');
						     $("#email1").val('');
						     $("#address1").val('');
						     $("#city1").val('');
						     $("#state1").val('');
						     $("#zipcode1").val('');
						     $("#desc").val('');
						     //$("#submit").removeattr('disabled','disabled');
						     $('#submit').prop("disabled", false); 
						      $("#first_name1").prop("disabled", false); 
						     $("#last_name1").prop("disabled", false); 
						   //  $("#email1").prop("disabled", false); 
						     $("#address1").prop("disabled", false); 
						     $("#city1").prop("disabled", false); 
						     $("#state1").prop("disabled", false); 
						   //  $("#desc").prop("disabled", false); 
						     $("#zipcode1").prop("disabled", false); 
						     
						     //$("#submit").attr('enabled','enabled');
						 	}
							 response( $.map( data, function( item ) {
								return {
									label: item.label,
									 id: item.id,
							        value: item.value
								}
							}));
						}
		      		});
		      	},
		      	  	select: function(event, ui) {
		      //	alert(ui.item.id);
		      
		       $.ajax({
	       type: "POST",
		   url: "<?php  echo site_url('bar/getbarinfoByID')?>",
		   data: {id:ui.item.id},
		   dataType : 'JSON',
		   success: function(response) {
		  
		     $("#first_name1").val(response.bar_first_name);
		     $("#last_name1").val(response.bar_last_name);
		     $("#email1").val(response.email);
		     $("#address1").val(response.address);
		     $("#city1").val(response.city);
		     $("#state1").val(response.state);
		     $("#desc").val(response.bar_desc);
		     $("#zipcode1").val(response.zipcode);
		      $("#first_name1").attr('disabled','disabled');
		      $("#zipcode1").attr('disabled','disabled');
		     $("#last_name1").attr('disabled','disabled');
		   //  $("#email1").attr('disabled','disabled');
		     $("#address").attr('disabled','disabled');
		     $("#city").attr('disabled','disabled');
		     $("#state").attr('disabled','disabled');
		    // $("#desc").attr('disabled','disabled');
		     $("#submit").attr('disabled','disabled');
		     
		  }
	   });
		      		
      //  $("#to_user_id1").val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		      
    	 
    	 });
    </script>	