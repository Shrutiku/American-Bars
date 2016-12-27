<!DOCTYPE html>
<html lang="en">
  <head>
    <title>JQuery JSONP</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
 
        $("#useJSONP").click(function(){
            $.ajax({
                url: '<?php echo site_url('home/test_ajax123')?>',
                data: {name: 'Chad'},
                dataType: 'jsonp',
                jsonp: 'callback',
                jsonpCallback: 'jsonpCallback',
                success: function(){
                    alert("success");
                }
            });
        });
 
    });
     
    function jsonpCallback(data){
        $('#jsonpResult').text(data.message);
    }
    </script>
  </head> 
  
  <body>
    <input type="button" id="useJSONP" value="Use JSONP"></input><br /><br />
    <span id="jsonpResult"></span>
  </body>
</html>