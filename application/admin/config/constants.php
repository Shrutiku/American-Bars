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

/*Messages*/

/*Admin login message*/
define('INVALID_USERNAME','<strong>Username</strong> and/or <strong>Password</strong> are wrong.');
define('LOGOUT_SUCCESS','You have logged out successfully.');
/*End admin login message*/


/*List admin message*/
define('ADD_NEW_RECORD','Record has been added successfully.');
define('UPDATE_RECORD','Record has been updated successfully.');
define('DELETE_RECORD','Record has been deleted successfully.');
define('ACTIVE_RECORD','Record has been activated successfully.');
define('INACTIVE_RECORD','Record has been inactivated successfully.');
define('ARCHIVED_RECORD','Record has been archived successfully.');
define('CLAIM_RECORD','Record has been claimed successfully.');
define('UNCLAIM_RECORD','Record has been unclaimed successfully.');
define('ASSIGN_RIGHTS','Rights has been assigned successfully.');
define('NO_RIGHTS','You have no rights to access this module.');
define('FAQ_LIMIT','You cannot add more than 20 FAQs.');
/*End of list admin message*/



/*Website Track message*/
define('UNBLOCK_IP','IP has been unblock successfully.');
define('BLOCK_IP','IP has been block successfully.');
define('DELETE_IP','Record has been deleted successfully.');
define('UPDATE_IP','Record has been updated successfully.');
/*End of website Track message*/

/*Coupon*/
define('ADD_NEW_COUPON','Record has been added successfully.');
define('UPDATE_COUPON','Record has been updated successfully.');
define('DELETE_COUPON','Record has been deleted successfully.');
define('ACTIVE_COUPON','Record has been activated successfully.');
define('INACTIVE_COUPON','Record has been inactivated successfully.');
/*End of coupon*/

/*Usertrack message*/
define('DELETE_USER_IP','Record has been deleted successfully.');
/*End of user track message*/


/*Image setting message*/
define('IMAGE_SETTING_UPDATE','Image settings updated successfully.');
define('SITE_SETTING_UPDATE','Site settings updated successfully.');
define('SITE_GOOGLE_UPDATE','Google settings updated successfully.');
define('SITE_FACEBOOK_UPDATE','Facebook settings updated successfully.');
define('SITE_PAYPAL_UPDATE','Paypal settings updated successfully.');
define('SITE_YAHOO_UPDATE','Yahoo settings updated successfully.');
define('META_SETTING_UPDATE','SEO settings updated successfully.');
/*End of image setting message*/

/*Vehicle management message*/
define('ADD_NEW_VEHICLE_MAKE','Record has been added successfully.');
define('UPDATE_VEHICLE_MAKE','Record has been updated successfully.');
define('DELETE_VEHICLE_MAKE','Record has been deleted successfully.');
define('ACTIVE_VEHICLE_MAKE','Record has been activated successfully.');
define('INACTIVE_VEHICLE_MAKE','Record has been inactivated successfully.');

define('ADD_NEW_VEHICLE_MODEL','Record has been added successfully.');
define('UPDATE_VEHICLE_MODEL','Record has been updated successfully.');
define('DELETE_VEHICLE_MODEL','Record has been deleted successfully.');
define('ACTIVE_VEHICLE_MODEL','Record has been activated successfully.');
define('INACTIVE_VEHICLE_MODEL','Record has been inactivated successfully.');

define('ADD_NEW_VEHICLE_RENTAL','Record has been added successfully.');
define('UPDATE_VEHICLE_RENTAL','Record has been updated successfully.');
define('DELETE_VEHICLE_RENTAL','Record has been deleted successfully.');
define('ACTIVE_VEHICLE_RENTAL','Record has been activated successfully.');
define('INACTIVE_VEHICLE_RENTAL','Record has been inactivated successfully.');

/*End of Vehicle management  message*/

/*Department Message*/
define('ADD_NEW_DEPARTMENT','Record has been added successfully.');
define('UPDATE_DEPARTMENT','Record has been updated successfully.');
define('DELETE_DEPARTMENT','Record has been deleted successfully.');
define('ACTIVE_DEPARTMENT','Record has been activated successfully.');
define('INACTIVE_DEPARTMENT','Record has been inactivated successfully.');
/*End of department*/

/*Bank Message*/
define('ADD_NEW_BANK','Record has been added successfully.');
define('UPDATE_BANK','Record has been updated successfully.');
define('DELETE_BANK','Record has been deleted successfully.');
define('ACTIVE_BANK','Record has been activated successfully.');
define('INACTIVE_BANK','Record has been inactivated successfully.');
/*End of bank*/

/*Bank Message*/
define('ADD_NEW_FORM','Record has been added successfully.');
define('UPDATE_BANK_FORM','Record has been updated successfully.');
define('DELETE_BANK_FORM','Record has been deleted successfully.');
define('ACTIVE_BANK_FORM','Record has been activated successfully.');
define('INACTIVE_BANK_FORM','Record has been inactivated successfully.');
/*End of bank*/


/*Lead Vehicle*/
define('ADD_LEAD_VEHICLE','Record has been added successfully.');
define('UPDATE_LEAD_VEHICLE','Record has been updated successfully.');
define('DELETE_LEAD_VEHICLE','Record has been deleted successfully.');
define('ACTIVE_LEAD_VEHICLE','Record has been activated successfully.');
define('INACTIVE_LEAD_VEHICLE','Record has been inactivated successfully.');
/*End lead vehicle*/

/*Lead Trade*/

define('ADD_LEAD_TRADE','Record has been added successfully.');
define('UPDATE_LEAD_TRADE','Record has been updated successfully.');
define("MESSAGE_SEND","Message send successfully.");
/*End Trade*/

define('TRANSACTION_APPROVE',"Transaction(s) has been approved.");
/*End of messages*/
//Log constant

define('LOG_UPDATE_ADMIN','Updated admin data.');
define('LOG_DELETE_ADMIN','Deleted admin data.');
define('LOG_ADD_ADMIN','Added admin data.');
define('LOG_ACTIVE_ADMIN','Activated admin data.');
define('LOG_INACTIVE_ADMIN','Inactivated admin data.');
define('LOG_UPDATE_SITE_SETTING','Updated site setting data.');
define('LOG_UPDATE_META_SETTING','Updated meta setting data.');
define('LOG_UPDATE_EMAIL_SETTING','Updated email setting data.');
define('LOG_UPDATE_IMAGE_SETTING','Updated image setting data.');
define('LOG_UPDATE_EMAILTEMPLATE_SETTING','Updated email template setting data.');

define('LOG_UPDATE_PAGE','Updated page data.');
define('LOG_DELETE_PAGE','Deleted page.');
define('LOG_ACTIVE_PAGE','Activated page.');
define('LOG_INACTIVE_PAGE','Inactive page.');

define('LOG_DELETE_DOCTOR','Deleted doctor.');
define('LOG_ACTIVE_DOCTOR','Activated doctor.');
define('LOG_INACTIVE_DOCTOR','Inactive doctor.');
define('LOG_ADD_DOCTOR','Added doctor.');
define('LOG_UPDATE_DOCTOR','Updated doctor.');

define('LOG_DELETE_DOCTOR_CATEGORY','Deleted doctor category.');
define('LOG_ACTIVE_DOCTOR_CATEGORY','Activated doctor category.');
define('LOG_INACTIVE_DOCTOR_CATEGORY','Inactive doctor category.');
define('LOG_INSERT_DOCTOR_CATEGORY','Added doctor category.');
define('LOG_UPDATE_DOCTOR_CATEGORY','Updated doctor category.');

define('LOG_DELETE_PATIENT','Deleted patient.');
define('LOG_ACTIVE_PATIENT','Activated patient.');
define('LOG_INACTIVE_PATIENT','Inactive patient.');
define('LOG_UPDATE_PATIENT','Updated patient.');

define('LOG_DELETE_PACKAGE','Deleted package.');
define('LOG_ACTIVE_PACKAGE','Activated package.');
define('LOG_INACTIVE_PACKAGE','Inactive package.');
define('LOG_INSERT_PACKAGE','Added package.');
define('LOG_UPDATE_PACKAGE','Updated package.');

define('LOG_DELETE_DIET','Deleted diet.');
define('LOG_ACTIVE_DIET','Activated diet.');
define('LOG_INACTIVE_DIET','Inactive diet.');
define('LOG_INSERT_DIET','Added diet.');
define('LOG_UPDATE_DIET','Updated diet.');

define('LOG_DELETE_SPORTCATEGORY','Deleted sport category.');
define('LOG_ACTIVE_SPORTCATEGORY','Activated sport category.');
define('LOG_INACTIVE_SPORTCATEGORY','Inactive sport category.');
define('LOG_INSERT_SPORTCATEGORY','Addeded sport category.');
define('LOG_UPDATE_SPORTCATEGORY','Updated sport category.');

define('LOG_DELETE_MESSAGE','Deleted message.');
define('LOG_ACTIVE_MESSAGE','Activated message.');
define('LOG_INACTIVE_MESSAGE','Inactive message.');
define('LOG_INSERT_MESSAGE','Added message.');
define('LOG_REPLY_MESSAGE','Reply message.');
define('LOG_UPDATE_MESSAGE','Updated message.');

define('LOG_DLETE_FAQ','Deleted FAQ.');
define('LOG_ACTIVE_FAQ','Activated FAQ.');
define('LOG_INACTIVE_FAQ','Inactive FAQ.');
define('LOG_INSERT_FAQ','Added FAQ.');
define('LOG_UPDATE_FAQ','Updated FAQ.');

define('LOG_DLETE_NEWSLETTER','Deleted newsletter.');



/* End of file constants.php */
/* Location: ./application/config/constants.php */