<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
*/

// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------

$config =
	array(
		// set on "base_url" the relative url that point to HybridAuth Endpoint
		'base_url' => '/hauth/endpoint',

		"providers" => array (
			// openid providers
			"OpenID" => array (
				"enabled" => false
			),

			"Yahoo" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" ),
			),

			"AOL"  => array (
				"enabled" => false
			),

			"Google" => array (
				"enabled" => true,
                                "redirect_uri" => "https://sandbox.americanbars.com/huath/?hauth.done=Google",
				"keys"    => array ( "id" => "307988649375-kccgstqffmjds02p9ntb43o5f9g05607.apps.googleusercontent.com", "secret" => "XngMmE2_jRo_kFAAzL5G_3qg" ),
			),
			"Instagram" => array (
				"enabled" => true,
			),
			"Facebook" => array (
				"enabled" => true,
                                "scope" => "manage_pages,publish_pages",
				"keys"    => array ( "id" => "322878041237170", "secret" => "90f2a242f65cd83c3fb2a581dd778f92" ),
			),

			"Twitter" => array (
				"enabled" => true,
				"keys"    => array ( "key" => "cu7KN3VKR9fqyPzVxaPpUEaVi", "secret" => "3B6uwOEyAMeCEXcKA0lIJCyhwCdQrvM0aSIATeWkUSPtAtXofZ" )
			),

			// windows live
			"Live" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" )
			),

			"MySpace" => array (
				"enabled" => false,
				"keys"    => array ( "key" => "", "secret" => "" )
			),

			"LinkedIn" => array (
				"enabled" => false,
				"keys"    => array ( "key" => "", "secret" => "" )
			),
                    
                    	"PushNotifications" => array (
				"enabled" => false,
			),

			"Foursquare" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" )
			),
		),

		// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
		"debug_mode" => false,

		"debug_file" => APPPATH.'/logs/hybridauth.log',
	);


/* End of file hybridauthlib.php */
/* Location: ./application/config/hybridauthlib.php */