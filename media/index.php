<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="description" content=""/>
        <meta name="author" content=""/>
        <title>American Bars | Coming Soon</title>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <style>
            body{background: #000;font-family: 'audiowideregular';color: #fff;}
            @font-face {font-family: 'audiowideregular';src: url('http://americanbars.com/fonts/Audiowide-Regular.ttf') format('truetype');font-weight: normal;font-style: normal;}
            .span6 {
              width: 70%;
              float: left;
              padding: 0 15%;
              text-align: center;
            }
            .social-box {
              width: 100%;
              margin-top: -25px;
            }
            .clear{clear: both;}
            p{text-align:justify;}
            video#bgvid {
            position: fixed;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -100;
            -webkit-transform: translateX(-50%) translateY(-50%);
            transform: translateX(-50%) translateY(-50%);
            background-size: cover;
            }
            .right-content {
              background: rgba(0,0,0,.65);
              width: 50%;
              height: auto;
              float: right;
              margin: 40px;
              border-radius: 11px;
                overflow: hidden;
            }
            .logo-box{
                width: 100%;
            }
            .logo-main{
                width: 100%;
                height: auto;
            }
            ul.social-buttons {
              position: relative;
              text-align: center;
              list-style: none;
            }
            .social-buttons li {
              margin: 5px 0;
              display: inline-block;
            }
            .social-buttons li a:hover{
                background: rgb(254,231,151);
            }
            ul.social-buttons li a {
              display: block;
              width: 40px;
              height: 40px;
              border-radius: 100%;
              font-size: 20px;
              line-height: 40px;
              outline: 0;
              color: #000;
              background-color: rgb(234,161,33);
              -webkit-transition: all .3s;
              -moz-transition: all .3s;
              transition: all .3s;
            }
            label.hidden {
              display: none;
            }
            #sign_up {
              float: left;
              width: 26%;
              border-style: double;
              background-color: rgb(234,161,33);
              color: #fff;
              margin-top: 0;
              padding: 7px;
              cursor: pointer;
            }
            h2.news-title {
              font-size: 19px;
            }
            .copyright {
              font-size: 12px;
              padding: 0 0 0 15px;
              text-transform: uppercase;
            }
            h1 {
              margin: 0;
            }
            .number {
                float: left;
                  width: 13%;
                  text-align: center;
                  font-size: 30px;
                  padding: 3px;
                  margin: 3%;
              border: solid 1px;
              box-shadow: 1px 1px 5px #fff;
            }
            section#countdown {
              width: 400px;
              margin: auto;
            }
            .under-number-row {
              float: left;
            }
            .number-header:first-child {
              width: 20%;
            }
            .number-header:nth-child(3) {
              width: 31%;
              margin-left: -24px;
            }
            .number-header:nth-child(2) {
              width: 35%;
            }
            .number-header:last-child {
              width:18%;
            }
            .number-header {
              float: left;
              font-size: 20px;
              margin: 0px auto;
              width: 26%;
            }
            span {
                margin: 0 20px 20px 20px;
            }
            label {
              font-size: 16px;
              margin: 0;
              width: 207px;
              vertical-align: top;
              display: inline-block;
              float: left;
            }
            input[type="radio"] {
              width: auto;
              vertical-align: middle;
                margin: 12px 0;
            }
            .input-block {
              height: 50px;
            }
            input, textarea{
              width: 250px;
              margin-bottom: 15px;
              border-radius: 5px;
              padding: 5px;
              display: inline-block;
            }
            .number-row, .under-number-row {
              width: 400px;
            }
            .center{
                text-align: center;
                text-transform: uppercase;
            }
            .confirmation {
              width: 80%;
              margin: 20px auto 40px;
            }
            @media(max-width: 1140px){
                .right-content{
                    width: 560px;
                }
                
            }
            @media (max-width: 800px) {
            video#bgvid {position: fixed; top:0; left: 0; width: auto; height: 100%;transform: none; -webkit-transform: none;}
            }
            @media (max-width: 710px){
                .right-content{
                    margin: 0;
                }
            }
            @media (max-width: 560px){
                .number {
                  font-size: 20px;
                  padding: 3px;
                  margin: 0%;
                }
                .number-header:first-child {
                  width: 17%;
                }
                .number-header:nth-child(2) {
                  width: 21%;
                }
                .number-header:nth-child(3) {
                  width: 36%;
                }
                .number-header:last-child {
                  width: 17%;
                  margin-left: -15px;
                }
                .number-header{
                    font-size: 15px;
                }
                .number-row, .under-number-row {
                  width: 340px;
                }
            }
            @media (max-width: 414px){
                .right-content {
                  margin: 0;
                  width: 414px;
                }
                input{
                    width: 40%;
                }
                #sign_up{
                    width: 30%;
                }
                .copyright p{ font-size: 8px;}
            }
            @media (max-width: 375px){
                .right-content {
                  width: 375px;
                }
            }
            @media (max-width: 320px){
                .right-content {
                  width: 320px;
                }
                h2 {
                  font-size: 17px;
                }
                p {
                  font-size: 14px;
                }
                #sign_up {
                  width: 38%;
                }
                .copyright p {
                  font-size: 8px;
                }
                .number-row, .under-number-row {
                  width: 340px;
                  margin-left: -21px;
                }
                .number-header:last-child {
                  width: 17%;
                  margin-left: -20px;
                }
            }
        </style>
        <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
        <?php
            if(isset($_POST["submit"]))
            {
                ?><meta http-equiv="refresh" content="8" /><?php
            }
        ?>
    </head>

    <body id="top">
        <video autoplay loop id="bgvid">
            <source src="../images/cocktail.mp4" type="video/mp4">
        </video>
        <div class="right-content">
            <h1 class="center">Media Confirmation Form</h1>
            <div class="logo-box">
                <h2><img class="logo-main" src="../images/americanbars.png" alt="American Bars" title="American Bars" /></h2>
            </div>
            <div class="social-box">
                <ul class="social-buttons">
                    <li><a href="https://www.facebook.com/AmericanDiveBars" target="_blank"><i class="fa fa-facebook"></i></a></li>
               	    <li><a href="https://twitter.com/American_Bars" target="_blank"><i class="fa fa-twitter"></i></a></li>
               	    <li><a href="https://www.linkedin.com/company/american-dive-bars-inc-" target="_blank"><i class="fa fa-linkedin"></i></a></li>
               	    <li><a href="https://plus.google.com/+AmericanDiveBars/posts" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                    <li><a href="https://www.pinterest.com/americandivebar/" target="_blank"><i class="fa fa-pinterest"></i></a></li>
                </ul>
            </div>
            <div class="newsletter-box">
                <div class="span6">
                    <p>Thank you for visiting us. Please let us know if you are planning on attending our relaunch party on August 17, 2015 at The Del Monte Speakeasy in Venice Beach, CA. We will be able to accomodate you and anything you may need. If you have any special accomodations, please let us know a few days ahead of time or in the form below. Once we receive your confirmation, we will send you your media pass for the event.</p>
    				<p>For any further information or questions please contact us directly at 1-800-303-8803 x111 or email us at brian@americanbars.com.</p>
                    <?php
                        if(isset($_POST["submit"]))
                        {
                            $recipient = "brian@choosebsg.com";

                            $subject = "Media Confirmation";
                            $sender = $_POST["name"];
                            $senderEmail = $_POST["email"];
                            $senderPhone = $_POST["phone"];
                            $senderAttending = $_POST["attending"];
                            $message = $_POST["message"];
                            
                            $message = "MEDIA PAGE CONFIRMATION:\r\n\r\nThis message is from ".$sender.".\r\n\r\nEmail: ".$senderEmail."\r\n\r\nPhone Number: ".$senderPhone."\r\n\r\nAttending: ".$senderAttending."\r\n\r\nMessage: ".$message;
                        
                            mail($recipient, $subject, $message, "From: ".$sender."");
                            if($senderAttending == "Yes") {
                                echo "<h2 class='center'>Thank You For Your Comfirmation</h2><p class='confirmation'>Your reservation was completed. We will be sending you a media pass for the event and we look forward to seeing you on August 17, 2015 at The Del Monte Speakeasy in Venice Beach, CA.</p>";
                            }
                            else{
                                echo "<h2 class='center'>Thank You For Your Comfirmation</h2><p class='confirmation'>Sorry to hear you will not be coming to our event; however, feel free to come back and use the site as soon as we launch on August 17, 2015.</p>";
                            }
                        }
                        else{
                            ?>
                            <form method="post" class="reply-input" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
                                <div class="input-block">
                                    <label for="comment-name" class="label_comment"><strong>Name</strong> (required)</label>
                                    <input type="text" name="name" value="" id="comment-name" required="" />
                                </div>
                                <div class="input-block">
                    				<label for="comment-phone" class="label_comment"><strong>Phone</strong></label>
                                    <input type="text" name="phone" value="" id="comment-phone"/>
                                </div>
                                <div class="input-block">
                    				<label for="comment-email" class="label_comment"><strong>Email</strong></label>
                    				<input type="email" name="email" value="" id="comment-email" />
                                </div>
                                <div class="input-block">
                    				<label for="comment-attending" class="label_comment"><strong>Will You Be Attending?</strong> (required)</label>
                    				<input type="radio" name="attending" id="Yes" value="Yes" required="" checked="" /><span>Yes</span>
                                    <input type="radio" name="attending" id="No" value="No" required="" /><span>No</span>
                                </div>
                                <div class="textarea-block">
                    				<label for="comment-message" class="label_comment"><strong>Message/Accomodations</strong></label>
                    				<textarea name="message" id="comment-message" cols="44" rows="4"></textarea>
                    				<div class="clear"></div>
                                </div>
                                <div id="RecaptchaField1" class="g-recaptcha"></div><br/>
                                <input type="submit" name="submit" value="Submit Reservation" />
                                <div class="clear"></div>
                            </form> 
                    <?php
                        }
                    ?>  
                </div>
            </div>
            <div class="copyright">
                <p>Copyright &copy; 2015 American Bars. All rights reserved.</p>
            </div>
        </div>
    </body>
</html>
