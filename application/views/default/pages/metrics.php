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
      
            function checkAndSet() {
                $.getJSON('<?php echo site_url('metrics/get');?>', function(data) {
                    var newhm = data.hulfmug_bars;
                    var newfm = data.fullmug_bars;
                    var newen = data.enthusiasts;

                    var oldhm = $("#hm").val();
                    var oldfm = $("#fm").val();
                    var olden = $("#en").val();

                    if (newhm !== oldhm) {
                        $("#hm").text(''+newfm);
                        $("#hm").counterUp()
                        $(".hmstars").celebrate({
                            particles: 7,
                            radius: 75,
                            color: "black",
                            unicode: '\u2605', // star
                            start_size: '15',
                            min_end_size: '20',
                            max_end_size: '75',
                            max_duration: 500,
                            min_duration: 400,
                            complete: function() {} // callback
                        });


                    }
                    if (newfm !== oldfm) {
                        $("#fm").text(''+newfm);
                        $("#fm").counterUp();
                        $(".fmstars").celebrate({
                            particles: 7,
                            radius: 75,
                            color: "black",
                            unicode: '\u2605', // star
                            start_size: '15',
                            min_end_size: '20',
                            max_end_size: '75',
                            max_duration: 500,
                            min_duration: 400,
                            complete: function() {} // callback
                        });
                    }
                    if (newen !== olden) {$("#en").text(''+newen); $("#en").counterUp();}
                });
            }

            checkAndSet();

            setInterval(checkAndSet(), 60000);
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
                <span class="counter" id="hm"></span>
                <div class="hmstars"></div>
            </div>
            <div id="column" style="margin-top: -100px;">
                <h1>Full-Mugs</h1>
                <span class="counter" id="fm"></span>
                <div class="fmstars"></div>
            </div>
            <div id="column" style="margin-top: -100px;">
                <h1>Enthusiasts</h1>
                <span class="counter" id="en"></span>
            </div>
        </div>
    </div>
    <script src="<?php echo app_bower_url(); ?>/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="<?php echo app_bower_url(); ?>/counter/jquery.counterup.min.js"></script>
    <script src="<?php echo app_bower_url(); ?>/celebrate/celebrate.js"></script>
</body>
</html>