
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>admin/default/assets/plugins/select2/select2_metro.css" />
	<script type="text/javascript" src="<?php echo base_url();?>admin/default/assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>admin/default/assets/plugins/select2/select2.min.js"></script>
	<style>
	.select2-container-multi.select2-dropdown-open .select2-choices, .select2-container-multi.select2-container-active .select2-choices
	{
		border: 0px;
	}
		.select2-container-multi .select2-choices, .select2-container-multi.select2-dropdown-open .select2-choices, .select2-container-multi.select2-container-active .select2-choices
		
{
	background:none !important;
	border: none !important;
}
	</style>
<script type="text/javascript">
	$(document).ready(function(){
		$('#bar_category').select2({
            placeholder: "Select Bar Type Categories",
            allowClear: true
        });
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
<?php  /* $getimagename = getimagenamebanner();?>	
          	  <?php 
									if($getimagename->beer_directory_state==1 && $getimagename->beer_directory!="" && is_file(base_path().'upload/bar_pages_banner_orig/'.$getimagename->beer_directory)){ ?>
										<img src="<?php echo base_url().'upload/bar_pages_banner/'.$getimagename->beer_directory; ?>"   />
									<?php
									} else {?>
            	<!-- <img src="<?php echo base_url(); ?>/default/images/smallbanner1.png" alt="American Bars"/> -->
            	<?php } */ 
            	$v=0;
          $getad_banner = '';
            	$getad_banner = getadvertisementBannerSearchBar('bar_owner_register');
				
				if($getad_banner){
					
						 ?>
<div class="wrapper row4">
   		<div class="container clearfix">
   			<div id="slider-fixed-banner" class="carousel slide">
        	<div class="carousel-inner">
          	<div class="active item">
            	 
							<?php 
	     				$count = getadvertisementBannerByIDCount(@$getad_banner['banner_pages_id'],$getad_banner['type']);
						if($getad_banner['type']=='click')
						{
							$cnt = $getad_banner['number_click'];
						}
						else
						{
							$cnt = $getad_banner['number_visit'];
						}
						
						$getad_new = getadvertisementByID_banner(@$getad_banner['banner_pages_id'],'visit');
		
						if(($getad_new==0 || $getad_new<5) && $count<$cnt && $getad_banner['type']=='visit' && $getad_banner['type']!='')
						{
							$array = array('ip'=>$_SERVER['REMOTE_ADDR'],'datetime'=>date('Y-m-d H:i:s'),'banner_pages_id'=>$getad_banner['banner_pages_id'],'click_type'=>'visit');
							$this->db->insert('count_clcik_advertisement_banner',$array);
							
							$array1 = array('total_visit'=>$getad_banner['total_visit']+1);
							$this->db->where('banner_pages_id',$getad_banner['banner_pages_id']);
							$this->db->update('banner_pages_master',$array1);
						}
						
						$v= 1;
	     				if($getad_banner && $count<$cnt){ ?>
	     					<?php if(($getad_banner['banner_pages_image']!='' && file_exists(base_path().'upload/banner_pages_thumb/'.$getad_banner['banner_pages_image']))){ ?>
	     						<a target="_blank" <?php if($getad_banner['type']=='click'){?>onclick="add_click_banner('<?php echo $getad_banner['banner_pages_id'];?>');"<?php } ?> href="<?php echo $getad_banner['url']; ?>"><img src="<?php echo base_url().'upload/banner_pages_thumb/'.$getad_banner['banner_pages_image']; ?>" class="img-responsive"/></a>
	     					<?php } ?>	
	     					<?php } else { ?>
		     		 <img src="<?php echo base_url().'upload/banner_pages_thumb/'.$getad_banner['banner_pages_image']; ?>" class="img-responsive"/>
		     			
		     			  <?php }  ?>
							
						
				<div class="clearfix"></div>    
          </div>
        </div>
        <!-- <a class="left carousel-control" href="#slider-fixed-banner" data-slide="prev">&lsaquo;</a>
        <a class="right carousel-control" href="#slider-fixed-banner" data-slide="next">&rsaquo;</a> -->
       
   	</div>
	</div>
  </div>
  <?php } ?>
	<div class="wrapper row5 beer-list" style="border:<?php echo $v==0 ? 'none':'';?>">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow" style="width:870px">
     				<div class="result_search">
	     				<i class="strip login_icon"></i><div class="result_search_text">Registration</div>
     				</div>
     				<div>
     				<h1 class="yellow_title padb10 br_bott_gray text-center padding-bottom-15">Please Fill Bar Details Below</h1>
     				<div>
     					<ul class="registration_steplist">
     						<li ><a >Step 1</a></li>
     						<li class="active" ><a>Step 2</a></li>
     						<li> <a>Step Test</a></li>
     						<li><a >Step 3</a></li>
     						<li class="last"><a >Step 4</a></li>
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
	     				<form class="form-horizontal" role="form" name="step_1" id="step_1" action="<?php echo site_url("home/registration_step2/".$type); ?>" method="post">
	        				 <div class="padtb mar_top20">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Bar Name : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" name="bar_title" maxlength="40"  class="tags form-control form-pad" id="bar_title" placeholder="Start Typing..." <?php if($this->session->userdata('viewid_orig')!='' && $this->session->userdata('viewid_orig')!=0){ ?> <?php }?> value="<?php echo @$bar_title; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb mar_top20">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Bar Type : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<select class="m_wrap wid360 span12 select2 select_box" multiple name="bar_category[]" id="bar_category">
		                           		
																	<?php 
																	//$bar_category = explode(',', @$bar_category);
																	if($get_cat)
																	       {
																	       	  foreach($get_cat as $row)
																			  {  
																			  	if(!empty($bar_category))
																				{ ?>
																				<option <?php echo in_array($row->bar_category_id, $bar_category) ? 'selected':''; ?> value="<?php echo $row->bar_category_id; ?>"><?php echo $row->bar_category_name; ?></option>	
																			<?php	}
																				else { 																			  	?>
																			  	 <option value="<?php echo $row->bar_category_id; ?>"><?php echo $row->bar_category_name; ?></option>
																			  	 
																			  	<?php } ?>  
																			<?php  }
																	       }
																	       ?>	
		                         	</select>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Bar Owner First Name : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" maxlength="40" name="first_name" id="first_name1" value="<?php echo @$first_name; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Bar Owner Last Name : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" maxlength="40" id="last_name1" name="last_name" value="<?php echo @$last_name; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Bar Owner Email : <span class="aestrick"> * </span></label>
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
	        				 		<label class="control-label">Bar Address : <span class="aestrick"> * </span></label>
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
	        				 		<label class="control-label">Bar Description : </label>
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
	                       	
	                       	<div class="padtb8 mar_left15" style="position: relative;">
	                       		<!-- <div class="col-sm-3"></div> -->
	                       		<!-- <div class="col-sm-7 mart10"> -->
	                       			<a class="btn btn-lg btn-primary btn-next pull-left" href="<?php echo site_url('home/bar_owner_register/'.$type);?>"><i class="previous-arrow-icon"></i> Back</a>
	                       			<button class="btn btn-lg btn-primary btn-next next-right"  type="submit" name="submit" id="submit">Next <i class="next-arrow-icon"></i></button>
	                       		<!-- </div> -->
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<input type="hidden" name="temp_id" id="temp_id" value="<?php echo @$getbardata['temp_id']?>" />
	                       	<input type="hidden" name="user_id" id="user_id" value="" />
	                       	<input type="hidden" name="claim_bar_id" id="claim_bar_id" value="" />
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
						     $("#claim_bar_id").val('');
						     //$("#submit").removeattr('disabled','disabled');
						     $('#submit').show(); 
						      $("#first_name1").prop("disabled", false);
						     $("#last_name1").prop("disabled", false);
						     $("#email1").prop("disabled", false);
						     $("#address1").prop("disabled", false);
						     $("#city1").prop("disabled", false); 
						     $("#state1").prop("disabled", false); 
						     $("#desc").prop('disabled',false);
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
		      $("#claim_bar_id").val(response.bar_id);
		       if(response.owner_id!='' && response.owner_id!=0)
						     {
						     $("#first_name1").attr('disabled','disabled');
						     //   $("#bar_title").attr('disabled','disabled');
						      $("#last_name1").attr('disabled','disabled');
						        $("#email1").attr('disabled','disabled');
						        $("#address1").attr('disabled','disabled');
						      $("#city1").attr('disabled','disabled');
						       $("#state1").attr('disabled','disabled');
						     $("#zipcode1").attr('disabled','disabled');
						   
		     					$("#desc").attr('disabled','disabled');
		     					$("#submit").hide();
		                  }
		                  else
		                  {
		                  	 
						      $("#first_name1").prop("disabled", false);
						     $("#last_name1").prop("disabled", false);
						     $("#email1").prop("disabled", false);
						     $("#address1").prop("disabled", false);
						     $("#city1").prop("disabled", false); 
						     $("#state1").prop("disabled", false); 
						     $("#zipcode1").prop("disabled", false); 
						     $("#desc").prop('disabled',false);
		     					$("#submit").show();
		                  }
		   //  $("#email1").attr('disabled','disabled');
		  
		    
		   
		    // $("#desc").attr('disabled','disabled');
		   //  $("#submit").attr('disabled','disabled');
		     
		  }
	   });
		      		
      //  $("#to_user_id1").val(ui.item.id);  // ui.item.value contains the id of the selected label
    },
		      	autoFocus: true,
		      	minLength: 0      	
		      });
		      
    	 
    	 });
    </script>	
