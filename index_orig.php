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
            @font-face {font-family: 'audiowideregular';src: url('fonts/Audiowide-Regular.ttf') format('truetype');font-weight: normal;font-style: normal;}
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
              padding-bottom: 40px;
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
            input {
              width: 66%;
              float: left;
              margin-left: 15px;
              padding: 6px;
              font-size: 16px;
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
              position: fixed;
              bottom: 0;
              left: 0;
              padding-left: 15px;
              font-size: 12px;
              text-transform: uppercase;
              background: rgba(0,0,0,.65);
              width: 99%;
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
              float: left;
              padding: 7px;
              margin: 3% 0;
              font-size: 30px;
            }
            .number-row, .under-number-row {
              width: 400px;
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
                span {
                  float: left;
                  padding: 7px;
                  margin: 0;
                  font-size: 20px;
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
    </head>

    <body id="top">
        <video autoplay loop id="bgvid">
            <source src="images/cocktail.mp4" type="video/mp4">
        </video>
        <div class="right-content">
            <div class="logo-box">
                <h1><img class="logo-main" src="images/americanbars.png" alt="American Bars" title="American Bars" /></h1>
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
                    <h2>REMEMBER THE DATE AUGUST 17, 2015</h2>
                    <p>We upgraded from American Dive Bars to American Bars. Our new and improved version of American Bars is scheduled for a soft launch on August 17, 2015 at The Del Monte Speakeasy in Venice Beach, CA.</p>
                    <h3 class="text-center">The number of days until launch on <br /> August 17, 2015</h3>
    				<section id="countdown" class="text-center">
    					<div class="number-row">
                            <script>
                            (function (e) {
                              e.fn.countdown = function (t, n) {
                              function i() {
                                eventDate = Date.parse(r.date) / 1e3;
                                currentDate = Math.floor(e.now() / 1e3);
                                if (eventDate <= currentDate) {
                                  n.call(this);
                                  clearInterval(interval)
                                }
                                seconds = eventDate - currentDate;
                                days = Math.floor(seconds / 86400);
                                seconds -= days * 60 * 60 * 24;
                                hours = Math.floor(seconds / 3600);
                                seconds -= hours * 60 * 60;
                                minutes = Math.floor(seconds / 60);
                                seconds -= minutes * 60;
                                days == 1 ? thisEl.find(".timeRefDays").text("day") : thisEl.find(".timeRefDays").text("days");
                                hours == 1 ? thisEl.find(".timeRefHours").text("hour") : thisEl.find(".timeRefHours").text("hours");
                                minutes == 1 ? thisEl.find(".timeRefMinutes").text("minute") : thisEl.find(".timeRefMinutes").text("minutes");
                                seconds == 1 ? thisEl.find(".timeRefSeconds").text("second") : thisEl.find(".timeRefSeconds").text("seconds");
                                if (r["format"] == "on") {
                                  days = String(days).length >= 2 ? days : "0" + days;
                                  hours = String(hours).length >= 2 ? hours : "0" + hours;
                                  minutes = String(minutes).length >= 2 ? minutes : "0" + minutes;
                                  seconds = String(seconds).length >= 2 ? seconds : "0" + seconds
                                }
                                if (!isNaN(eventDate)) {
                                  thisEl.find(".days").text(days);
                                  thisEl.find(".hours").text(hours);
                                  thisEl.find(".minutes").text(minutes);
                                  thisEl.find(".seconds").text(seconds)
                                } else {
                                  alert("Invalid date. Example: 30 Tuesday 2013 15:50:00");
                                  clearInterval(interval)
                                }
                              }
                              var thisEl = e(this);
                              var r = {
                                date: null,
                                format: null
                              };
                              t && e.extend(r, t);
                              i();
                              interval = setInterval(i, 1e3)
                              }
                              })(jQuery);
                              $(document).ready(function () {
                              function e() {
                                var e = new Date;
                                e.setDate(e.getDate() + 60);
                                dd = e.getDate();
                                mm = e.getMonth() + 1;
                                y = e.getFullYear();
                                futureFormattedDate = mm + "/" + dd + "/" + y;
                                return futureFormattedDate
                              }
                              $("#countdown").countdown({
                                date: "17 August 2015 20:00:00", // Change this to your desired date to countdown to
                                format: "on"
                              });
                            });
                            </script>
    						<div class="number days"> 00</div>
                            <span>:</span>
                            <div class="number hours"> 00</div>
                            <span>:</span>
                            <div class="number minutes"> 00</div>
                            <span>:</span>
                            <div class="number seconds"> 00</div>
                        </div>
                        <div class="under-number-row">
                            <div class="number-header">Days</div>
                            <div class="number-header">Hours</div>
                            <div class="number-header">Minutes</div>
                            <div class="number-header">Seconds</div>
                        </div>
    				</section>
                </div>
            </div>
        </div>
        <div class="copyright">
            <p>Copyright &copy; 2015 American Bars. All rights reserved.</p>
        </div>
        <script type="application/ld+json">
        {
          "@context": "http://schema.org",
          "@type": "Event",
          "name": "Launch for www.americanbars.com at The Del Monte Speakeasy",
          "startDate" : "2015-07-17T21:30",
          "url" : "http://www.americanbars.com/",
          "location" : {
            "@type" : "Place",
            "sameAs" : "http://www.americanbars.com",
            "name" : "American Bars Launch",
            "address" : "52 Windward Ave, Venice, CA 90291"
          }
        }
        </script>
    </body>
</html>
