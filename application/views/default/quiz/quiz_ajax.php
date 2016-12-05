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