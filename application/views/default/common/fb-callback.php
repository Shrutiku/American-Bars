<?php 

require_once 'src/facebook.php'; //include the facebook php sdk
$facebook = new Facebook(array(
        'appId'  => '1701973756705217',    //app id
        'secret' => '4ff05d99e4c0264d3df574bf9f44d033', // app secret
));
$user = $facebook->getUser();
if ($user) { // check if current user is authenticated
    try {
        // Proceed knowing you have a logged in user who's authenticated.
        $user_profile = $facebook->api('/me');  //get current user's profile information using open graph
            }
         catch(Exception $e){}
}

?>