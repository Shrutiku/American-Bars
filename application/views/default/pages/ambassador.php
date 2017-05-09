
<div class="wrapper row6 padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow" style="width: 90%;">
     				<div class="result_search">
	     				<div class="result_search_text">Ambassador Signup</div>
     				</div>
				
                        
                     
     				<div class="pad20">
                                    <h1 align="center" class="yellow_title padb10 br_bott_gray">Welcome to American Bars. Verify your phone number to complete your ambassador registration.</h1>
                                    
                                    <?php $attributes = array('id'=>'frm_login','name'=>'frm_login','class'=>'form-horizontal','rolde'=>'form'); echo form_open('ambassador/',$attributes); ?>
                                    <br><br>
                                    <?php if($error!=""){ ?>
                                    <div class="error1 text-center"><a class="closemsg" data-dismiss="alert"></a><span>////<?php echo $error; ?></span></div>
                                    <?php }?>
   
                                    <!--<div class="padtb8">
                                           <div class="col-sm-3">
                                                   <label class="control-label">Phone Number :</label>
                                           </div>
                                    <div class="input_box col-sm-7">
                                            <input type="text" class="form-control form-pad" id="phone_num" placeholder="310 555 1234" name="phone_num">
                                    </div>
                                    <div class="clearfix"></div>
                                    </div>
                                    <div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7">
		                       		
                                            <div class="mar_top4">
                                                <button class="btn btn-lg btn-primary"  type="submit" name="submit"  id="submit" onclick="showDiv()">Enter</button>
                                            </div>
                                            <div class="clearfix"></div>
		        		</div>
                                        <div class="clearfix"></div>
                                    </div> -->
	        		</div>
     			</div>
     		</div>
   	</div>
</div>

<div style="padding: 20px" class="wrapper">
    <div class="container">
        <h1 class="productbar_title mar_top20 padding-10"><center>Become an American Bars Ambassador</center></h1><br/>
        <h3><center>Start Making Money Today!</center></h3><br/>
        <p>You can earn hundreds or thousands of dollars a month.  Really, you can!</p>
        <p>Let me show you how.</p>
        <p>For every bar you recruit as a full mug, paying member to American Bars, you get paid $50.  Then, you get paid $25 a month, for the life of the account if you do the following:</p>
        <p>Contact the bar and make sure they update their events, specials, and beverage list and photo gallery.  All of this can be done in less than 15 min.  That is an hourly rate of $100 per hour on average.</p>
        <h3><center><b>If you recruit 10 bars, you can make $250 a month.<br/>20 Bars makes you $500 a month.<br/>50 Bars makes you $1250 a month.<br/>And, if you sign up 100 bars, $2500 a month!<br/>
        </center></b></h3><br/>
        <p>How do you get started?  It is easy:</p>
        <ol type="1">
            <li>Fill out our application online.</li>
            <li>Have a brief interview call with an authorized agent.</li>
            <li>Get you approval code.</li>
            <li>Start signing up bars from you phone or laptop.</li>
            <li>Get paid and perform monthly maintenance.</li>
        </ol><br/>
        <h2><center>It’s that easy!  Interested?  <a href="<?php echo site_url('/ambassador/');?>">Click here!</a></center></h2><br/>
        <center><img src="https://static.pexels.com/photos/260922/pexels-photo-260922.jpeg" width="722" height="406" alt="American Bars Ambassador"/></center>
    </div>
</div>