<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
//===== Usual validation engine=====//
	$("#frm_login").validate({
		rules: {			
			email: {
				required: true,
				email: true
			},			
			password: {
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
     			<div class="login_block br_green_yellow" style="width: 90%;">
     				<div class="result_search">
	     				<div class="result_search_text">Post Card Login Page</div>
     				</div>
				
                        
                     
     				<div class="pad20">
     				<h1 class="yellow_title padb10 br_bott_gray">Congratulations, you have received a Comment Post Card from one of your customers. If you have 
     					    already claimed your bar, please login to read the Postcard comments. If you have no claimed your bar, please claim it
     					    immidiatly.  </h1>
					<?php $attributes = array('id'=>'frm_login','name'=>'frm_login','class'=>'form-horizontal','rolde'=>'form');
							echo form_open('postcard/view/'.$postcardid,$attributes); ?>	
	     						<input type="hidden" name="type" value="bar_owner" id="type" />
	     						<input type="hidden" name="postcardid" id="postcardid" />
	     						<br><br>
	     							<?php if($error!=""){ ?>
                        <div class="error1 text-center"><a class="closemsg" data-dismiss="alert"></a><span><?php echo $error; ?></span></div>
                        <?php }?>
                        
                      <?php if($msg!="" && $maximum_attemp_cond == ''){
                                if($msg=="activate") 
                                {
                                    echo "<div class='success text-center'>".ACCOUNT_ACTIVATE_SUCCESS."</div>";
                                }
                                
                                if($msg=="expired") 
                                {
                                    echo "<div class='error1 text-center'>".ACTIVATION_LINK_EXP."</div>";
                                }
                                
                                if($msg=="signup_sucess") 
                                {
                                    echo "<div class='success text-center'>".SIGNUP_SUCCESS."</div>";
                                }
                                
                                if($msg=="invalid")
                                {
                                    echo "<div class='error1 text-center'>".INVALIDE_USER_AND_PASSWORD."</div>";
                                }
                                if($msg=='forget')
                                {
                                    echo "<div class='success text-center'>".RESET_PASSWORD_SUCCESS.' '.$reset_email."</div>";
                                }
                                if($msg=='set')
                                {
                                    
                                    echo "<div class='error1 text-center'>".PASSWORD_ALREADY_RESET."</div>";
                            
                                }
                        
                                if($msg=="reset")
                                {
                                      echo "<div class='success text-center'>".RESET_PASSWORD."</div>";
                                }
								
								 if($msg=="resetlinksend")
                                {
                                     echo "<div class='error text-center'>".MAX_LOGIN_ATTEMPT.'<p>'.RESET_PASSWORD_SUCCESS.' '.$this->input->post("username").'</p>'."</div>";
                                }
                                
                        }     
                       ?>
	        				 <div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Email :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="email" placeholder="Email" name="email">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb8">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Password :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="password" class="form-control form-pad" id="password" name="password">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10">
									<button class="btn btn-lg btn-primary">Login</button>							
	                       		</div>
	                       		<div class="clearfix"></div>
                                <div id="message">
                                </div>
                                <div id="status"></div>
                                <div id="fb-root"></div>
                                <script>
                                  window.fbAsyncInit = function() {
                                    FB.init({
                                      appId      : '1701973756705217', // App ID
                                      channelUrl : 'http://americanbars.com/home/fbconnect.php', // Channel File
                                      status     : true, // check login status
                                      cookie     : true, // enable cookies to allow the server to access the session
                                      xfbml      : true  // parse XFBML
                                    });
                                    
                                    
                                	FB.Event.subscribe('auth.authResponseChange', function(response) 
                                	{
                                 	 if (response.status === 'connected') 
                                  	{
                                  		document.getElementById("message").innerHTML +=  "<br>Connected to Facebook";
                                  		//SUCCESS
                                  		
                                  	}	 
                                	else if (response.status === 'not_authorized') 
                                    {
                                    	document.getElementById("message").innerHTML +=  "<br>Failed to Connect";
                                
                                		//FAILED
                                    } else 
                                    {
                                    	document.getElementById("message").innerHTML +=  "<br>Logged Out";
                                    	//UNKNOWN ERROR
                                    }
                                	});	
                                	
                                    };
                                    
                                   	function Login()
                                	{
                                    	FB.login(function(response) {
                                            if (response.authResponse) 
                                    		   {
                                    		    	getUserInfo();
                                                    loginUser();
                                      			} else 
                                      			{
                                      	    	 console.log('User cancelled login or did not fully authorize.');
                                       			}
                                         }, {scope: 'email,public_profile',return_scopes: true});
                                	}
                                     
                                  function getUserInfo() {
                                	    FB.api('/me?fields=id,name,first_name,last_name,email,public_key', function(response) {
                                
                                	  var str="<b>Name</b> : "+response.name+"<br>";
                                          str +="<b>ID:</b> "+response.id+"<br>";
                                	  	  str +="<b>Email:</b> "+response.email+"<br>";
                                          str +="<b>First Name:</b> "+response.first_name+"<br>";
                                          str +="<b>Last Name:</b> "+response.last_name+"<br>";
                                	  	  str +="<input type='button' value='Logout' onclick='Logout();'/>";
                                	  	  document.getElementById("status").innerHTML=str;
                                	  	  	    
                                    });
                                    }
                                	function Logout()
                                	{
                                		FB.logout(function(){document.location.reload();});
                                	}
                                  function loginUser(){
                                    
                                  }
                                  // Load the SDK asynchronously
                                  (function(d){
                                     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
                                     if (d.getElementById(id)) {return;}
                                     js = d.createElement('script'); js.id = id; js.async = true;
                                     js.src = "//connect.facebook.net/en_US/all.js";
                                     ref.parentNode.insertBefore(js, ref);
                                   }(document));
                                
                                </script>

	                       	</div>
	                       	
	                       	<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7">
		                       		
		        					<div class="mar_top4">
		        						Not Registered: <a href="<?php echo site_url('home/claim_bar_owner_register/'.base64_encode('1V1').'/1V1/'.base64_encode($postcard->bar_id));?>" class="yellow_text">Claim you Bar Now</a>
		        					</div>
		        					<div class="clearfix"></div>
		        				</div>
		        				<div class="clearfix"></div>
	                       	</div>
	                       	
	        			</form>
	        		</div>
     			</div>
     		</div>
   		</div>
   	</div>
<!-- ************************************************************************ -->