<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/** cache days ***/
define('CACHE_VALID_SEC',864000);


/*All Error Message*/
/*Login Form validation*/
define('INVALID_CAPTCHA',"Invalid Captcha");
define('INVALID_USERNAME',"Invalid Email or Password.");

/*End login form validation*/

//for Business
define('ACCOUNT_UPDATE_SUCCESS','Account updated successfully.');
define('LOGOUT_SUCCESS','You have logged out successfully..');


// change email

define('ALREADY_ASSOC','You are already associated with email.');
define('ASSOC_WITH_OTHER','This email is already associated with another business.');
define('CHANGE_SUCC','Email has been successfully changed.');
define('SEND_SUCC','Email has been successfully sent.');

// change password

define('WRONG_CPASS','Your current password is wrong.');
define('CHANGE_SUCCESS','Password has been successfully changed.');

define('ALBUM_SUCCESS_UPLOAD','Images successfully uploaded.');

define('LOG_OUT_SUCCESS','Your are Log out successfully.');
define('NEW_BUSINESS_ADDED','Business has been successfully added.Please check your mail inbox and activate business.');
define('FORGET_SEND','Your login detail is sent to your email address. Please, check.');
define('ACCOUNT_VERIFY','Your account verified. you can logged in now !!');

define('ACTIVATE_SUCCESS','Business activated successfully.');
define('ACTIVATE_FAIL','Sorry ! your link has been expired.');

/* End of file constants.php */
/* Location: ./application/config/constants.php */
define('PAY_SUC','Payment has been successfully done.');
define('PAY_FAIL','Payment process is failed.');

/*Login msg*/
define('ACC_INACTIVE','Your account is inactive.');
define('INVALID_EMAIL','Please enter valid email or password.');
define('CANCEL_SUB','Your business subscription has been cancelled sucessfully.');
define('CANCEL_SUB_FAIL','Cancel subscription process has been failed.Please try again.');

define('IP_BLOCKED','Your ip is blocked');

/*List Report message*/
define('ADD_NEW_REPORT','Record has been added successfully.');
define('UPDATE_REPORT','Enregistrement a été mis à jour.');
define('DELETE_REPORT','Record has been deleted successfully.');
define('ACTIVE_REPORT','Record has been activated successfully.');
define('INACTIVE_REPORT','Record has been inactivated successfully.');
define('ASSIGN_RIGHTS','Record has been updated successfully.');



define('ACCOUNT_ACTIVATE_SUCCESS','Account is activated successully.');
define("ACTIVATION_LINK_EXP","The activation link has expired.");
define("SIGNUP_SUCCESS","You have successfully registered. The activation link sent to your email address.");
define("INVALIDE_USER_AND_PASSWORD","Email or password incorrect");
define("INACTIVE_ACCOUNT","Your account is not activated. Please activate your account first");
define("PASSWORD_CHANGE_SUCCESS","Your Password changed successfully");
define("RESET_PASSWORD_SUCCESS","The link to reset your password has been sent to you at your address:");
define("PASSWORD_ALREADY_RESET","You have already reset your password.");
define("RESET_PASSWORD","Passsword Reset successfully.");
define("EMAIL_NOT_FOUND","Email address not found.");
define("ACCOUNT_SUSPEND","Your account is suspended. Please contact the administrator.");
define("NO_RIGHT","You have no rights.");

?>