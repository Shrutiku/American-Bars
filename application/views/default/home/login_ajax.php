<?php
$theme_url = base_url().getThemeName(); 
$data = array(
		'facebook'		=> $this->fb_connect->fb,
		'fbSession'		=> $this->fb_connect->fbSession,
		'user'			=> $this->fb_connect->user,
		'uid'			=> $this->fb_connect->user_id,
		'fbLogoutURL'	=> $this->fb_connect->fbLogoutURL,
		'fbLoginURL'	=> $this->fb_connect->fbLoginURL,	
		'base_url'		=> site_url('home/facebook'),
		'appkey'		=> $this->fb_connect->appkey,
	);
?>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js" ></script>
<script>
	jQuery(document).ready(function() {  
		var count = 0;
		    var form1 = $('#frmlogin_ajax');
		    var base = '<?php echo base_url();?>';
            var error1 = $('.alert-error', form1);
            var success1 = $('.alert-success', form1);
            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-inline', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                      password: {required: true},
                      email: {
                        required: true,
                        email:true,
                    }
                },
                submitHandler: function (form) {
                    success1.show();
                    error1.hide();
                    var mydata = $("#frmlogin_ajax").serialize();
                    
				    $.ajax({
				        type: "POST",
				        url: "<?php echo site_url('home/login_ajax')?>",
				        data: mydata,
				        dataType: 'json',
				        success: function(response, textStatus, xhr) {
				        		       
				        	if(response.error!="")
				        	{
				        		count += 1;
				        		
							    if (count == 3) {
							    	count = 0;
							    	  var mydata = $("form#frmlogin_ajax").serialize();
								    $.ajax({
								        type: "POST",
								        url: "<?php echo site_url('home/sendemail')?>",
								        data: mydata,
								        dataType: 'json',
								        success: function(response, textStatus, xhr) {
								        	
								        }
								    });
							      // come code
							    }
				        		$("#ajax_msg_error").html("<div class='error1 text-center'><a class='closemsg' data-dismiss='alert'></a><span>"+response.error+"</span></div>");
				        		return false;
				        	}
				        	else if(response.msg=="success")
				        	{
				        		
				        	
				        		<?php if(isset($bar_id)){ ?>
				        		$.ajax({
									      type: "POST",
									      url: "<?php echo site_url('bar/checkExistPost')?>",
									      data: {id:'<?php echo $bar_id;?>'},
									      dataType: 'json',
									      success: function(response, textStatus, xhr) {
									      if(response.status=="success")
									      {
									      	 $("#crd_not_send").empty();
											 $("#crd_not_send").html("<div  class='error mar_top20  center'>Hello user now you can send another post card after "+response.time+" hours</div>");
									      }
									      }	
									   });
								<?php } ?>	   
				        	$("#sess_id").val(1);
				        		if($("#postcard").val()==0)
				        		{
				        		  $('#myModal1').modal('show');	
				        		}
				        		<?php if((isset($bar_id) || $this->uri->segment(2)=='detail') && ($this->uri->segment(2)!='registration_step2' && $this->uri->segment(2)!='registration_step3')){ ?>
				        		   //$('#loginmodal').modal('hide');
				        		   window.location.href = "<?php echo current_url();?>";
				        		<?php } else if($this->uri->segment(2)=='profile' || $this->uri->segment(2)=='forums' || $this->uri->segment(2)=='cart') {?>
				        				// $('#loginmodal').modal('hide');
				        				window.location.href = "<?php echo current_url();?>";
				        		<?php }
								
								 else {
								 	
								 	?>		
										window.location.href = "<?php echo base_url();?>"+response.redirectpage; 
				        	   <?php } ?>			
				        		//$('#dis_block').show();
				        		//$('#dis_none').hide();
				        		
				        		//window.location.href = ""; 
				        		//return true;
				        	}
				        }
				    });
                }
            });
		});
		
		
		jQuery(document).ready(function() {  
		    var form1 = $('#frmforget_ajax');
		    var base = '<?php echo base_url();?>';
            var error1 = $('.alert-error', form1);
            var success1 = $('.alert-success', form1);
            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-inline', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                     password: {required: true},
                      username: {
                        email:true,
                    }
                },
                submitHandler: function (form) {
                    success1.show();
                    error1.hide();
                    var mydata = $("form#frmforget_ajax").serialize();
				    $.ajax({
				        type: "POST",
				        url: "<?php echo site_url('home/forgetpassword_ajax')?>",
				        data: mydata,
				        dataType: 'json',
				        success: function(response, textStatus, xhr) {
				        	if(response.error!="")
				        	{
				        		$("#ajax_msg_error2").html("<div class='error1 text-center'><a class='closemsg' data-dismiss='alert'></a><span>"+response.error+"</span></div>");
				        		return false;
				        	}
				        	else if(response.msg=="success")
				        	{
				        		$("#ajax_msg_error2").html("<div class='error1 text-center'><a class='closemsg' data-dismiss='alert'></a><span>Please Check Your Email.</span></div>");
				        		return true;
				        	}
				        }
				    });
                }
            });
		});
		
		function toogle_eff(id1,id2)
		{
			$("#ajax_msg_error").empty();
		$('#'+id2+'-block').fadeOut('slow',function(){	
		$('#'+id1+'-block').fadeIn();
	});
	
	  
	$('#'+id2+'-form').fadeOut('slow',function(){	
		$('#'+id1+'-form').fadeIn();
	});
			
		}
		
jQuery(document).ready(function() { 
	  $("#mobile_no").inputmask("(999) 999-9999");
	
	 
		    var form1 = $('#custreg_ajax');
		    var base = '<?php echo base_url();?>';
            var error1 = $('.alert-error', form1);
            var success1 = $('.alert-success', form1);
            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-inline', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                	first_name: {required: true},
                	nick_name: {required: true},
                	last_name: {required: true},
                	year: {required: true},
                	month: {required: true},
                	day: {required: true},
                	age_t: {required: true},
                	email: {
                        required: true,
                        email:true
                   },                   
                    custpassword: {                        
                        required: true,
                       	loginRegex: true,
                        rangelength: [8, 16]
                    },
                   
                    
                	confirm_password: {
                		required: true,
                		equalTo:'#custpassword',              		
                		},
                	
                },
                
               
                submitHandler: function(form) {
                    success1.show();
                    error1.hide();
                    var mydata = $("#custreg_ajax").serialize();
				    $.ajax({
				        type: "POST",
				        url: "<?php echo site_url('home/customersignup')?>",
				        data: mydata,
				        dataType: 'json',
				        success: function(response, textStatus, xhr) {		
				        	
				         	
				        	
				        	if(response==null)
				        	{
				        		//alert("Email is exists");
				        		$("#ajax_msg_error_reg1").html("<div class='error1 text-center'><a class='closemsg' data-dismiss='alert'></a><span>Email Already Exists, Please insert different Email</span></div>");
				        		return false;
				        	}
				        	else if(response.error!='')
				        	{
				        		$("#ajax_msg_error_reg1").html("<div class='error1 text-center'><a class='closemsg' data-dismiss='alert'></a><span>"+response.error+"</span></div>");
				        		return false;
				        	}
				        	else if(response.msg=="success")
				        	{
				        		
				        		window.location.href = '<?php echo base_url().'home/success_user'?>'; 
				        		//return true;
				        	}
				        }
				    });
                   
                }
            });
            
           $.validator.addMethod("loginRegex", function(value, element) {
		        return this.optional(element) || /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,16}$/.test(value);
		    }, "Provide atleast 1 Number, 1 Special character,1 Alphabet and between 8 to 16 characters.");
		    
		});		
		
	</script>





<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/css/jquerytab/jQueryTab.js" ></script>
<link href="<?php echo base_url().getThemeName(); ?>/css/jquerytab/jQueryTab.css" rel="stylesheet" type="text/css" />




<?php $this->load->helper('cookie');
$email = "";
$password = "";
$type = '';
$remember_me = "";
		 $email = get_cookie('username');
		 $type = get_cookie('type');
		$password = get_cookie('password');
		$remember_me = get_cookie('remember_me'); 
		
		?> 	
<script>

var sliders = new Array();
var offerSlider='';
var config =new Array();

$(document).ready(function(){
	
		
	jQuery.jQueryTab({
	responsive:true,							// enable accordian on smaller screens
	collapsible:true,							// allow all accordions to collapse 
	useCookie: false,							// remember last active tab using cookie
	openOnhover: false,		
	initialTab: 2,			
	
	tabClass:'tabs',							// class of the tabs
	headerClass:'accordion_tabs',	// class of the header of accordion on smaller screens
	contentClass:'tabContent',		// class of container
	activeClass:'active',					// name of the class used for active tab
	
	tabTransition: 'fade',				// transitions to use - normal or fade
	tabIntime:500,								// time for animation IN (1000 = 1s)
	tabOuttime:0,									// time for animation OUT (1000 = 1s)
	
	accordionTransition: 'slide',	// transitions to use - normal or slide
	accordionIntime:500,					// time for animation IN (1000 = 1s)
	accordionOuttime:400,					// time for animation OUT (1000 = 1s)

	before: function(){
		
	},					// function to call before tab is opened
	after: function(index){
		var itea=$('a.accordion_tabs:active').attr('id');
		var actdiv=$( "a.accordion_tabs" ).index($('a.accordion_tabs.active'));
		 
	}	
	
});
     });
     
     function changetype(type)
     {
     	$("#type").val(type);
     	$("#type1").val(type);
     }
 </script>







<div class="padtb10">
	<input type="hidden" name="postcard" id="postcard" value="0"  />
     	<div>
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
     					 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	     				<i class="strip login_icon"></i><div class="result_search_text" id="login-block">Login</div>
	     				<div class="result_search_text" id="forget-block" style="display: none;">Forgot Password</div>
	     				
     				</div>
                    
     				<div class="pad20">
     				
     				
     				<div id="login-form"> 
					<h1 class="yellow_title padb10 br_bott_gray text-center">Member Login</h1>
					
	     				
	        				<div class=" tabs">
                                                    <ul class="tabs active" style="justify-content: center; display: flex;">
                                                        <li class="tab_btn display-inline divr <?php //echo $type=='user' ? 'active':''; ?>"><a onclick="changetype('user')" id="enthusiast-tab" href="#tab1" data-id="tab1">Enthusiast</a></li>
	        					<li class="tab_btn display-inline divr <?php //echo $type=='bar_owner' ? 'active':''; ?>"><a onclick="changetype('bar_owner')" id="bar-owner-tab" href="#tab2" data-id="tab2">Bar Owner</a></li>
	        					</ul>
	        				</div>
	        				<!-- <a class="accordion_tabs active" href="#tab1">Enthusiast</a> -->
	        				
	        				<?php $attributes = array('id'=>'frmlogin_ajax','name'=>'frmlogin_ajax','class'=>'form-horizontal','rolde'=>'form');
							echo form_open('home/login',$attributes); ?>
							<div id="ajax_msg_error"></div>	
							<input type="hidden" class="type" id="type" value="bar_owner" name="type">
	        				 <div class="mar_top20">
	    						<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Email :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="email" placeholder="Email" name="email" value="<?php echo @$email; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Password :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="password" class="form-control form-pad" id="password" name="password" value="<?php echo @$password; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb8 forgot_div">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7">
		                       		<div class="checkbox pull-left">
			     						 <label>
			          							<input type="checkbox" value="1" name="remember_me" id="remember_me" <?php echo @$remember_me==1 ? 'checked':''; ?> > Remember Me
			        					</label>
		        					</div>
		        					<div class="pull-right mar_top4">
		        						<a href="javascript://" onclick="toogle_eff('forget','login');" class="forgot_pass">Forgot Password</a>
		        					</div>
		        					<div class="clearfix"></div>
		        				</div>
		        				<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10">
									<button class="btn btn-lg btn-primary">Login</button>		
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       </div>
	                      </form> 
	        				<div class="tab_block tabContent" id="tab1">
	        					<div class="padtb8 text-center mart10">
	                       		<a class="fb-login" href="<?php echo $data['fbLoginURL'];?>" onclick="Login()"><i class="strip event_fb"></i> Login with Facebook</a>	
	                       	</div>
	                       	
	        					<a href="#sign-up-block" id="tab1" class="btn btn-lg btn-primary text-center enth-btn">Not An Enthusiast? Sign Up!</a>
	        					
	                       <div id="signup-form" class="signup margin-top-30 margin-minus-top">
	        				<div class="result_search">
	     				<i class="strip login_icon"></i><div class="result_search_text" id="login-block">Sign-up to be an American Bar Enthusiast! It's Free and always will be!</div>
     				</div> 
     				<div class="pad20">
					<!-- <h1 class="yellow_title padb10 br_bott_gray text-center">Sign Up</h1> -->
					<?php $attributes = array('id'=>'custreg_ajax','name'=>'custreg_ajax','class'=>'form-horizontal','rolde'=>'form');
							echo form_open('home/customersignup',$attributes); ?>	
							<!-- <div class="padb10 text-center padt10">
								<a href="<?php echo site_url('home/taxi_owner_register')?>" class="btn btn-lg btn-primary">Taxi Owner Rgister</a>
							</div> -->
	     					
	        				<div id="ajax_msg_error_reg1"></div>
	        				<div id="ajax_msg_error1"></div>
	        				<div class="radio_block" id="sign-up-block">
	        				 <div class="padtb8">
	        				 	<!-- <div class="col-sm-3">
	        				 		<label class="control-label">Email :</label>
	        				 	</div> -->
	        				 	<div class="padtb8">
	        				 	<input type="text" class="form-control form-pad" maxlength="40" placeholder="Username" name="nick_name" id="nick_name" value="<?php echo @$nick_name; ?>">
	                       	</div>
	        				 	
	                       		<div class="input_box mar_right20">
	                           		<input type="text" class="form-control form-pad" maxlength="40" placeholder="First Name" name="first_name" id="first_name" value="<?php echo @$first_name; ?>">
	                       		</div>
	                       		<div class="input_box">
	                           		<input type="text" class="form-control form-pad" maxlength="40" placeholder="Last Name" name="last_name" id="last_name" value="<?php echo @$last_name; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb8">
	        				 	<input type="text" class="form-control form-pad" id="email" placeholder="Email" name="email" value="<?php echo @$email; ?>">
	                       	</div>
	                       	<div class="padtb8">
	        				 	<input type="text" class="form-control form-pad" id="mobile_no" placeholder="Mobile Number" name="mobile_no" value="<?php echo @$mobile_no; ?>"><span class="pera"> (This is not a required field. Please provide your mobile phone information only if you want to receive promotional information via text from American Bars and bars listed in your favorite section.) </span>
	                       	</div>
	                       	<div class="padtb8">
	        				 	<input type="password" class="form-control form-pad" id="custpassword" placeholder="Password" name="custpassword" value="<?php echo @$password; ?>">
	                       	</div>
	                       	
	                       		<div class="padtb8">
	        				 	<input type="password" class="form-control form-pad" id="confirm_password" placeholder="Confirm Password" name="confirm_password" value="<?php echo @$confirm_password; ?>">
	                       	</div>
	                       	<div class="padtb8">
	                       		<div class="col-sm-8">
	                       			<div class="col-sm-4" style="padding-left: 0">
	                       			<select class="form-control form-pad select" id="month" name="month">
	                       				<option value="">Month</option>
	                       				<option value="1">January</option>
	                       				<option value="2">February</option>
	                       				<option value="3">March</option>
	                       				<option value="4">April</option>
	                       				<option value="5">May</option>
	                       				<option value="6">June</option>
	                       				<option value="7">July</option>
	                       				<option value="8">August</option>
	                       				<option value="9">September</option>
	                       				<option value="10">October</option>
	                       				<option value="11">November</option>
	                       				<option value="12">December</option>
	                       			</select>
	                       			<div class="clearfix"></div>
	                       			<span for="month" class="help-inline" style="display: none;">This field is required.</span>
	                       			</div>
	                       			<div class="col-sm-4" style="padding-left: 0">
	                       			<select class="form-control form-pad select"  id="day" name="day">
	                       				<option value="">Day</option>
	                       				<?php for($i=1;$i<=31;$i++){ ?>
	                       				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>	
	                       				<?php }?>
	                       			</select>
	                       			<div class="clearfix"></div>
	                       			<span for="day" class="help-inline" style="display: none;">This field is required.</span>
	                       			</div>
	                       			<div class="col-sm-4" style="padding-left: 0">
	                       			<select class="form-control form-pad select"  id="year" name="year">
	                       				<option value="">year</option>
	                       				<?php for($i=date('Y');$i>=1950;$i--){ ?>
	                       				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>	
	                       				<?php }?>
	                       			</select>
	                       			<div class="clearfix"></div>
	                       			<span for="year" class="help-inline" style="display: none;">This field is required.</span>
	                       			</div><div class="clearfix"></div>
	                       			
	        				 		<!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
	        				 	</div>
	        				 	<!-- <div class="col-sm-4">
	        				 		<a href="#">Why do I need to provide my birthday?</a>
	        				 	</div> -->
	        				 	<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padb10">
			     				<div class="radio pull-left">
				     				<label>
				          				<input type="radio" value="female" name="gender" id="gender"> Female
				        			</label>
			        			</div>
			        			<div class="radio pull-left">
				     				<label>
				          				<input type="radio" value="male"  name="gender" id="gender" checked="checked"> Male
				        			</label>
			        			</div>
		        				<div class="clearfix"></div>
	        				</div>
	        				
	        				<div>
	        					<label class="pera"><input type="checkbox" value="1" name="age_t" id="age_t" /> By checking this box, your are certifying that you are over the age of 21. The subject matter of this website is intended only for people over the age of 21 and use of this website by people under the age of 21 is not authorized.</label>
	        					<div class="clearfix"></div>
	        					<span for="age_t" class="help-inline" style="display: none;">This field is required.</span>
	        				</div>
	        				
	        				<div class="mar_top15">
	        					<label class="pera"> By clicking Sign Up, you agree to our <a href="#">Terms</a> and that you have read our <a href="#">Data Use Policy</a> including our <a href="#">Cookie Use</a>.</label>
	        				</div>
	        				
	                       	<div class="padtb8">
	                       		<div class="mart10">
									<button class="btn btn-lg btn-primary">Sign Up</button>									
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<!-- <div class="padb10 text-center padt10 mar_top20">
								<a href="<?php echo site_url('home/taxi_owner_register')?>" class="btn btn-lg btn-primary">Taxi Owner Rgister</a>
							</div> -->
	                      </div> 	
	                      
	                     
	        			</form>
	        			</div>
	        			
	        		</div>

				</div>
					    	<!-- <a class="accordion_tabs" href="#tab2">Bar Owner</a> -->
	        				<div class="tab_block tabContent" id="tab2">
	        					
	
					    	</div>
					    	<!-- <a class="accordion_tabs" href="#tab3">Taxi Owner</a> -->
	        				<div class="tab_block tabContent" id="tab3">
	        					
	                       		<div class="mart10 text-center br-top-yellow">
		                      		<p class="notyet">Not Yet Register</p>
		                      		<a class="btn btn-lg btn-primary" href="<?php echo site_url('home/taxi_owner_register');?>">Register Now</a>	
		                      	</div>
					    	</div>
	        				
	        				 
	                       	
	        			</form>
	        			</div>
	        			
	        			<div id="forget-form" style="display: none;">
	        				
	                 <form name="frmforget_ajax" method="post" id="frmforget_ajax" class="form-horizontal login-form" action="<?php echo base_url();?>home/login" target="_blank">
	                	<div id="ajax_msg_error2"></div>	
	                	<input type="hidden" class="type" id="type1" value="<?php echo $type!='' ? $type:'bar_owner'; ?>" name="type">
	                  
	        				
	                   <div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Email :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="email" placeholder="Email" name="email" value="<?php echo @$email; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                   jquery.f
	                   <div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7">
		                       		
		        					<div class="pull-right mar_top4">
		        						<a href="javascript://" onclick="toogle_eff('login','forget');" class="forgot_pass">Back To Login</a>
		        					</div>
		        					<div class="clearfix"></div>
		        				</div>
		        				<div class="clearfix"></div>
	                       	</div>
	                   <div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10">
									<button class="btn btn-lg btn-primary" type="submit">Send</button>									
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
