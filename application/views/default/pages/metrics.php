<!DOCTYPE html>
<html>
<head>
    <title>AB Metrics</title>
    <style>
    div.container {
    align-items: center;
    width: 100%;
    margin: auto;
    }
    span.counter {
        font-family: 'Anton', sans-serif;
        width: 33%;
        line-height: 100px;
        color:white;
        margin-left:30px;
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
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
    
    <!-- JQuery for Counter -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>
        jQuery(document).ready(function($) {
            var minutes = 5;
            var hm = document.getElementById('hm');
            var fm = document.getElementById('fm');
            var en = document.getElementById('en');
            var cb = document.getElementById('cb');

            function countUp() {
                $.getJSON('https://sandbox.americanbars.com/metrics/get', function(data) {

                    // clears number in counter span
                    hm.innerHTML = "";
                    fm.innerHTML = "";
                    en.innerHTML = "";
                    // cb.innerHTML = "";

                    // set new number
                    hm.innerHTML = data.hulfmug_bars;
                    fm.innerHTML = data.fullmug_bars;
                    en.innerHTML = data.enthusiasts;
                    // cb.innerHTML = data.hulfmug_bars + data.fullmug_bars;
                });

                // Function to count with the number in counter span
                $('.counter').counterUp({
                        delay: 10,
                        time: 1000
                    });
            }

            countUp();

            setInterval(countUp(), 5000);
        });
    </script>
</head>
<body bgcolor="#C57B00" align="center">

    <div align="center">
        <img src="https://americanbars.com/default/images/americanbars.png" style="width: 100%;">
        <div class="container">
            <!-- <div style="float: left; width:375px">
                <h1>Claimed Bars</h1>
                <span class="counter" id="cb">45000</span>
            </div> -->
            <div>
                <h1 style="font-size: 100px;float: left; margin-left: 21%; margin-right: 12%">Claimed Bars</h1>
                <h1 style="font-size: 100px;float: right; margin-left:12%; margin-right: 13%">Users</h1>
            </div>
            <div id="column">
                <h1>Half-Mugs</h1>
                <span class="counter" id="hm">40304</span>
            </div>
            <div id="column">
                <h1>Full-Mugs</h1>
                <span class="counter" id="fm">1234</span>
            </div>
            <div id="column">
                <h1>Enthusiasts</h1>
                <span class="counter" id="en">800367</span>
            </div>
        </div>
    </div>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
    <script src="jquery.counterup.min.js"></script>
</body>
</html>