<?php $theme_url = base_url().getThemeName(); ?>



  <!-- ************************************************************************ -->
  <div class="main-container">
    <div class="container">
        <div class="jumbotron">
        
<div id="fb-root"></div>
   
   
         
         <style type="text/css">

.fb_frnds{
	list-style:none;
}
.fb_frnds li{
		padding:10px;
	float:left;
	width:30%;
}
.frnd_list{
	margin-top:-25px;
	margin-left:40px;
}
.fb_frnds a{
		text-decoration:none;
		 background: #333;
		 filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#333', endColorstr='#D95858'); /* for IE */
background: -webkit-gradient(linear, left top, left bottom, from(#333), to(#D95858)); /* for webkit browsers */
background: -moz-linear-gradient(top,  #333,  #D95858)/* for firefox 3.6+ */ ;
    color: #FFFFFF;
		float: right;
		font: bold 13px arial;
		margin-right:110px ;
		
		
}
</style>
</head>
<body>
<?php 



$facebook = new Facebook(array(
		'appId'		=>  "428176620608507",
		'secret'	=> "34007214152b3645b8d37732f931969c",
		));
//get the user facebook id	
	
$user = $facebook->getUser();
echo $user;
if($user){
	try{
		//get the facebook friends list
	  $user_friends = $facebook->api('/me/friends');
	}catch(FacebookApiException $e){
		error_log($e);
		$user = NULL;
	}		
}
if(isset($user_friends)){  ?>
<h1> Facebook Friends List </h1>   <a href="javascript:void(0);" onclick="fb_logout();">Logout</a>
<ul  class="fb_frnds">
<?php
	foreach($user_friends['data'] as $user_friend){
?>
<li ><img src="https://graph.facebook.com/<?php echo $user_friend['id']; ?>/picture" width="30" height="30"/>
<div  class="frnd_list"><?php echo $user_friend['name']; ?><a href="javascript:void(0);" onclick="send_invitation(<?php echo $user_friend['id']; ?>);"> Invite </a></div>
</li>

<?php  }  ?>
</ul>
<?php
}else{
	
//header('Location: '.base_url());	
}?>
   <script src="http://connect.facebook.net/en_US/all.js#xfbml=1"> </script>

<script type="text/javascript">
FB.init({ 
       appId:'<?php echo "428176620608507"; ?>', cookie:true, 
       status:true, xfbml:true 
     });

function send_invitation(fb_frnd_id){
     FB.ui({ method: 'apprequests', 
       message: 'IdiotMinds Programming Blog...',
	   to:fb_frnd_id
	   });
}
function fb_logout(){
	FB.logout(function(response) {
		  parent.location ='<?php echo base_url(); ?>';
});
	
}
</script>
         
       </div><!---->
      </div> <!-- /container -->
  </div>
<!-- ************************************************************************ -->