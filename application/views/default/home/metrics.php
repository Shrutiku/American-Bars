<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="/assets/css/flipclock.css">
<style>
body {
    background-color: gold;
}
</style>
</head>
<body>
<h1><img src="https://americanbars.com/default/images/americanbars.png" style="max-width: 400px;"></h1>
<div class="your-clock"></div>
<script src="/assets/js/libs/jquery.js"></script>
<script src="/assets/js/flipclock/flipclock.min.js"></script>
<script> 
$(document).ready(function(){        
var clock = $('.your-clock').FlipClock({
autoPlay: true});

clock.setFaceValue(30);
});</script>
<p></p>

</body>
</html>