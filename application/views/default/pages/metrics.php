<!DOCTYPE html>
<html>
<head>
    <title>AB Metrics</title>
    <style>
    div.container {
    align-items: center;
    width: 100%;
    }
    span.counter {
        font-family: 'Anton', sans-serif;
        width: 33%;
        line-height: 100px;
        color: #FFF;
        font-size:100px;
    }
    #column {
        float: left;
        width: 33%
    }
    h1 {
        font-family: 'Anton', sans-serif;
        color: #2f2f2a;
        font-size: 70px;
    }
    </style>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
    
    <!-- JQuery for Counter -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            var minutes = 1;
            var hm = document.getElementById('hm');
            var fm = document.getElementById('fm');
            var en = document.getElementById('en');
      
            function countUp() {
                $.getJSON('<?php echo site_url('metrics/get');?>', function(data) {
                    // set new number
                    hm.innerHTML = data.hulfmug_bars;
                    fm.innerHTML = data.fullmug_bars;
                    en.innerHTML = data.enthusiasts;
                });

                // Function to count with the number in counter span
                $('.counter').counterUp({
                        delay: 10,
                        time: 1000
                    });
            }

            countUp();

            setInterval(countUp(), minutes * 60000);
        });
    </script>
</head>
<body bgcolor="#C57B00" align="center">

    <div align="center">
        <img src="https://americanbars.com/default/images/americanbars.png" style="width: 70%; margin-bottom: -80px;">
        <div class="container">
                <h1 style="font-size: 100px;float: left; margin-left: 21%; margin-right: 10%">Claimed Bars</h1>
                <h1 style="font-size: 100px;float: right; margin-right: 12%">Users</h1>
            <div id="column" style="margin-top: -100px;">
                <h1>Half-Mugs</h1>
                <span class="counter" id="hm">40304</span>
            </div>
            <div id="column" style="margin-top: -100px;">
                <h1>Full-Mugs</h1>
                <span class="counter" id="fm">1234</span>
            </div>
            <div id="column" style="margin-top: -100px;">
                <h1>Enthusiasts</h1>
                <span class="counter" id="en">800367</span>
            </div>
        </div>
    </div>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->
    <script src="<?php echo app_bower_url(); ?>/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="<?php echo app_bower_url(); ?>/counter/jquery.counterup.min.js"></script>
</body>
</html>