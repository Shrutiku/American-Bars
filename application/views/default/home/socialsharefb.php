<?php
  $config = array(
    'appId' => '322878041237170',
    'secret' => '90f2a242f65cd83c3fb2a581dd778f92',
    'fileUpload' => true,
    'allowSignedRequest' => false // optional but should be set to false for non-canvas apps
  );

  $facebook = new Facebook($config);
  $user_id = $facebook->getUser();

  $photo = 'https://americanbars.com/upload/test.jpeg'; // Path to the photo on the local filesystem
if ($user_id) {

} else {
    $loginUrl = $facebook->getLoginUrl();
    header('Location:' . $loginUrl . '&scope=user_photos,publish_actions,email,user_friends, public_profile');
}
?>

  <?php
  
    if($user_id) {
      try {
              
              // $param = array(
    // 'message' => "test test tset",
     // 'picture' => "http://www.thesoftwareguy.in/wp-content/uploads/2014/03/facebook-680x250.jpg",
    // 'link' => "https://americanbars.com",
   // );
// 
              // $posted = $facebook->api('/me/feed/', 'post', $param);
			  redirect('home/socialshare');
      } catch(FacebookApiException $e) {
        error_log($e->getType());
        error_log($e->getMessage());
      }   
	  
	  
    } else {

    }

  ?>

