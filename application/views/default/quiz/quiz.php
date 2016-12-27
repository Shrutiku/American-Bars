<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.countdownTimer.js"></script>
	
<script type="text/javascript">
 


  function ckeck_ans(val)
  {
  		
  	
  } 
  
  function showanswer(val)
  {
       for (var i = 1; i < 10000; i++)
				        window.clearInterval(i);
  	      $(".que-option-block a p").removeClass("que-option1");
  		  $("#"+val).addClass("que-option1");
  		  $("#user_answer").val(val);
  	          $("#a").removeAttr("onclick");
  	          $("#b").removeAttr("onclick");
  	          $("#c").removeAttr("onclick");
  	          $("#d").removeAttr("onclick");
  	        
	 $.ajax({ 
	 	     type: "POST",   
             url: "<?php echo site_url('trivia/checkanswer')?>",
             data: $("#quest").serialize(),
             async: true,
             dataType:'json',
             // beforeSend : function(){
			   // $('#dvLoading').fadeIn('slow');
			 // },
			 // complete: function(){
			   // $('#dvLoading').fadeOut('slow');
// 			    
			 // },
             success : function(textnew)
             {
             	 $("#showans").val(0);
             	 $(".que-option-block a p").removeClass("que-option1");
             	 $(".que-option-block a p").removeClass("que-option2");
             	 $(".que-option-block a p").removeClass("que-option3");
             	  $("#"+$('#user_answer').val()).addClass("que-option2");
             	  if(textnew.answer!=$("#user_answer").val())
             	  {
             	  	  $("#"+textnew.answer).addClass("que-option3");
             	  }
               	if(textnew.answer==$("#user_answer").val())
             	  {
             	  	  //$("#"+$('#user_answer').val()).effect( "highlight", {color:"#669966"}, 300 );
             	  	 // $("#"+textnew.answer).addClass("que-option3");
             	  	 // $(".que-option-block a p").removeClass("que-option3");
             	  	   $("#"+$('#user_answer').val()).removeClass("que-option2");
             	  	  $("#"+$('#user_answer').val()).addClass("que-option3");
             	  }
             	// $("#replace_with").html(textnew);
             }
    });
  }     
   $(document).ready(function () {
   	
  
   	 //set_cookie('sitename', 10, 7);
   	 
   	// alert(document.cookie);
   	// storedataincookie();
   	 //cookie()
   	 var sitename = get_cookie();
   	  
	// alert(sitename);	
   	 if(sitename==null || sitename==0 || sitename<0  )
   	 {
   	 	countDown(20);
   	 }
   	 else
   	 {
   	 	countDown(sitename);
   	 }
   	 
   	
   	 
});	
   
   function storedataincookie()
   {
   	   $.ajax({ 
	 	     type: "POST",   
             url: "<?php echo site_url('trivia/storedataincoockie')?>",
             data: $("#quest").serialize(),
             async: true,
             dataType:'html',
             success : function(textnew)
             {
             }
    });
   }
   function nextanswer()
  {
 
	
  	//var interval_id = window.setInterval("", 9999); 
                                              
				for (var i = 1; i < 10000; i++)
				        window.clearInterval(i);
		
		if($("#s_timer").html()==0)
		{
			var v = 1;
		}		     
		else
		{
			var v =$("#s_timer").html();
		}   
	 $.ajax({ 
	 	     type: "POST",   
             url: "<?php echo site_url('trivia/nextanswer')?>",
             data: $("#quest").serialize() + "&moredata=" + v,
             async: true,
             dataType:'html',
             beforeSend : function(){
			   $('#dvLoading').fadeIn('slow');
			 },
			 complete: function(){
			   $('#dvLoading').fadeOut('slow');
			 },
             success : function(textnew)
             {
             	if(textnew=='stop')
             	{
             		window.location = '<?php echo site_url('trivia/result');?>';
             	} 
				  else
				  {    	
             	 $(".que-option-block a p").removeClass("que-option1");
             	 $(".que-option-block a p").removeClass("que-option2");
             	 $(".que-option-block a p").removeClass("que-option3");
             	 $("#question_list").html(textnew);
             	// clearInterval(myVar);
             	
             	  var j = 20;
             	  //alert(i);
             	     var int = setInterval(function () {
					//document.cookie=j;
					set_cookie('sitename', j, 7);
				        document.getElementById("s_timer").innerHTML =  j;
				        j-- || nextanswer();  //if i is 0, then stop the interval
				    }, 1000);
             	 }
             	 
             }
    });
  }   
 function countDown(i) {
 	
    var int = setInterval(function () {
    	//document.cookie= i;
    	set_cookie('sitename', i, 7);
        document.getElementById("s_timer").innerHTML =  i;
        i-- || nextanswer();  //if i is 0, then stop the interval
    }, 1000);
}


function set_cookie ( cookie_name, cookie_value, lifespan_in_days, valid_domain )
{
  // http://www.thesitewizard.com/javascripts/cookies.shtml
  var domain_string = valid_domain ? ("; domain=" + valid_domain) : '' ;
  document.cookie = cookie_name + "=" + encodeURIComponent( cookie_value ) +
      "; max-age=" + 60 * 60 * 24 * lifespan_in_days +
      "; path=/" + domain_string ;
} 
function get_cookie()
{
  var nameEQ = 'sitename' + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
} 
</script>



<div class="wrapper row5 quiz">
     	<div class="container">
     		<div class="result_search">
     			<div class="col-sm-8">
	     			<div class="result_search_text pull-left">Trivia</div>
	            </div>
	            <div class="clearfix"></div>
     		</div>
  <div id="question_list">
    <form name="quest" id="quest" action="<?php echo site_url('trivia/checkanswer')?>"> 
    	<input type="hidden" name="user_answer" id="user_answer" value="">
    	<input type="hidden" name="showans" id="showans" value="0">
    	<input type="hidden" name="questid" id="questid" value="<?php echo $result['trivia_id'];?>">
    			
    	
     		<div class="mar_top20">
 				<h1 class="question"><?php echo $result['question'];?></h1>
 				<div class="que-block margin-right-30">
 					<p><?php echo $getquenum; ?>/20</p>
 					<div class="que-title">
 						Question
 					</div>
 				</div>
 				<div class="que-block">
 					<p id="s_timer" class="s_timer123" >20</p>
 					<div class="que-title">
 						Trivia Timer
 					</div>
 				</div>
 				<div class="clearfix"></div>
     		</div>
     		<div class="option-block margin-top-30">
     			<div>
     				<div class="que-option-block correct mar_right20 pos_rel">
     					<a id="a" href="javascript://" onclick="showanswer('1');">
	     					<div class="que-no">1</div>
	     					<p class="que-option" id="1"><?php echo $result['question1'];?></p>
	     					<div class="clearfix"></div>
     					</a>
     				</div>
     				<div class="que-option-block wrong pos_rel">
     					<a id="b" href="javascript://" onclick="showanswer('2');">
	     					<div class="que-no">2</div>
	     					<p class="que-option" id="2"><?php echo $result['question2'];?></p>
	     					<div class="clearfix"></div>
     					</a>
     				</div>
     				<div class="clearfix"></div>
     			</div>
     			<div class="mar_top20">
     				<div class="que-option-block mar_right20 pos_rel">
     					<a id="c" href="javascript://" onclick="showanswer('3');">
	     					<div class="que-no">3</div>
	     					<p class="que-option" id="3"><?php echo $result['question3'];?></p>
	     					<div class="clearfix"></div>
     					</a>
     				</div>
     				<div class="que-option-block pos_rel">
     					<a id="d" href="javascript://" onclick="showanswer('4');">
	     					<div class="que-no">4</div>
	     					<p class="que-option" id="4"><?php echo $result['question4'];?></p>
	     					<div class="clearfix"></div>
     					</a>
     				</div>
     				<div class="clearfix"></div>
     			</div>
     			<!-- <ul>
     				<li class="correct"><a href="#">
     					<p class="que-no">1</p>
     					<p class="que-option">Moe's Tavern swan with 2 necks Moe's Tavern swan with 2 necks</p>
     				</a></li>
     				<li class="wrong"><a href="#">
     					<p class="que-no">2</p>
     					<p class="que-option">swan with 2 necks</p>
     				</a></li>
     				<li><a href="#">
     					<p class="que-no">3</p>
     					<p class="que-option">Ten Forward</p>
     				</a></li>
     				<li><a href="#">
     					<p class="que-no">4</p>
     					<p class="que-option">The star</p>
     				</a></li>
     				<div class="clearfix"></div>
     			</ul> -->
     		</div>
     	
     		<div class="margin-top-30 text-right">
     			<!-- <a href="javascript://" onclick="showanswer()" class="white review mar_right20">Show Ans</a> -->
     			<a href="<?php echo site_url('trivia/quitgame');?>"  class="white pull-left review mar_r5">Quit Game</a>
     			<a href="<?php echo site_url('trivia/start_new_game');?>"  class="white pull-left review">Start New Game</a>
     			<a href="javascript://" onclick="nextanswer()" class="white review"><?php echo $getquenum==20 ? 'Finish':'Next'; ?></a>
     		</div>
     </form>
     </div>		
     	
   	</div>
   	</div>
  