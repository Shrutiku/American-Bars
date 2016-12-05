<?php
 date_default_timezone_set("Europe/London");
class Site_setting extends CI_Controller {

	function Site_setting() {
		parent::__construct();
		$this -> load -> model('site_setting_model');
	}

	/*** site setting home page
	 **/
	function index() {
		redirect('site_setting/add_site_setting');
	}

	/** admin site setting display and update function
	 * var integer $site_setting_id
	 * var integer $site_online
	 * var integer $captcha_enable
	 * var string $site_name
	 * var integer $site_version
	 * var integer $site_language
	 * var string $currency_code
	 * var string $date_format
	 * var string $time_format
	 * var string $date_time_format
	 * var string $site_tracker
	 * var text $how_it_works_video
	 * var integer $zipcode_min
	 * var integer $zipcode_max
	 * var string $error
	 **/
	function add_site_setting() {
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('add_site_setting');
 		
		 if(	$check_rights==0) {			
			 redirect('home/dashboard/no_rights');	
		 }
		$data = array();
		$theme = getThemeName();
		$this -> template -> set_master_template($theme . '/template.php');

		$this -> load -> library('form_validation');
		$this -> form_validation -> set_rules('site_name', 'SITE NAME', 'required');
		$this -> form_validation -> set_rules('date_format', 'DATE FORMAT', 'required');
		//$this -> form_validation -> set_rules('time_format', 'TIME FORMAT', 'required');
		//$this -> form_validation -> set_rules('default_latitude', 'Default Latitude', 'required');
		//$this -> form_validation -> set_rules('default_longitude', 'Default Longitude', 'required');
		$this -> form_validation -> set_rules('site_email', 'Site Email', 'required|email');
       
        
		$data['page_name']="add_site_setting";
		
		if ($this -> form_validation -> run() == FALSE) {
			if (validation_errors()) {
				$data["error"] = validation_errors();
			} else {
				$data["error"] = "";
			}
			if ($this -> input -> post('site_setting_id')) {
				$one_site_setting = site_setting();

				$data["site_setting_id"] = $this -> input -> post('site_setting_id');
				$data["site_online"] = $this -> input -> post('site_online');
				$data["site_name"] = $this -> input -> post('site_name');
				$data["site_address"] = $this -> input -> post('site_address');
				$data["email_conversation"] = $this -> input -> post('email_conversation');
				$data["site_version"] = $this -> input -> post('site_version');
				$data["currency_code"] = $this -> input -> post('currency_code');
				$data["currency_symbol"] = $this -> input -> post('currency_symbol');
				$data["date_format"] = $this -> input -> post('date_format');
				$data["time_format"] = $this -> input -> post('time_format');
				$data["date_time_format"] = $this -> input -> post('date_time_format');
				$data["google_map_key"] = $this -> input -> post('google_map_key');
				$data["default_latitude"] = $this -> input -> post('default_latitude');
				$data["default_longitude"] = $this -> input -> post('default_longitude');
                $data["how_it_works_video"] = $this -> input -> post('how_it_works_video');
                $data["header_text"] = $this -> input -> post('header_text');
				$data["site_email"] = $this -> input -> post('site_email');
				$data["poker_coach_price"] = $this -> input -> post('poker_coach_price');
				$data["amount"] = $this -> input -> post('amount');
				$data["managed_account_amount"] = $this -> input -> post('managed_account_amount');
				
		
			} else {
				$one_site_setting = site_setting();
					
				$data["site_setting_id"] = $one_site_setting -> site_setting_id;
				$data["site_online"] = $one_site_setting -> site_online;
				$data["managed_account_amount"] = $one_site_setting -> managed_account_amount;
				$data["captcha_enable"] = $one_site_setting -> captcha_enable;
				$data["site_address"] = $one_site_setting -> site_address;
				$data["site_name"] = $one_site_setting -> site_name;
				$data["site_version"] = $one_site_setting -> site_version;
				$data["currency_symbol"] = $one_site_setting -> currency_symbol;
				$data["currency_code"] = $one_site_setting -> currency_code;
				$data["email_conversation"] = $one_site_setting->email_conversation;
				$data["date_format"] = $one_site_setting -> date_format;
				$data["time_format"] = $one_site_setting -> time_format;
				$data["date_time_format"] = $one_site_setting -> date_time_format;
				$data["google_map_key"] = $one_site_setting -> google_map_key;
				$data["default_latitude"] = $one_site_setting -> default_latitude;
				$data["default_longitude"] = $one_site_setting -> default_longitude;
                $data["how_it_works_video"] = $one_site_setting -> how_it_works_video;
                $data["header_text"] =$one_site_setting -> header_text;
				$data["amount"] =$one_site_setting -> amount;
				$data["site_email"] = (isset($one_site_setting -> site_email))?$one_site_setting -> site_email:'';
                 $data["poker_coach_price"] =$one_site_setting -> poker_coach_price;
				
			}
			
			$data['site_setting'] = site_setting();

			$this ->template->write_view('header_menu', $theme . '/layout/common/header', $data, TRUE);
			$this->template-> write_view('center', $theme . '/layout/setting/add_site', $data, TRUE);
			$this->template->write_view('left', $theme . '/layout/common/sidebar', $data, TRUE);
			$this -> template -> write_view('footer', $theme . '/layout/common/footer', $data, TRUE);
			$this -> template -> render();
		} else {
			$this -> site_setting_model -> site_setting_update();
			$one_site_setting = site_setting();

			$data["error"] = "update";
			$data["site_setting_id"] = $this -> input -> post('site_setting_id');
			$data["site_online"] = $this -> input -> post('site_online');
			$data["captcha_enable"] = $this -> input -> post('captcha_enable');
			$data["managed_account_amount"] = $this -> input -> post('managed_account_amount');
			$data["site_name"] = $this -> input -> post('site_name');
			$data["site_address"] = $this -> input -> post('site_address');
			$data["email_conversation"] = $this -> input -> post('email_conversation');
			$data["site_version"] = $this -> input -> post('site_version');
			$data["amount"] = $this -> input -> post('amount');
			$data["site_language"] = $this -> input -> post('site_language');
			$data["currency_code"] = $this -> input -> post('currency_code');
			$data["currency_symbol"] = $this -> input -> post('currency_symbol');
			$data["date_format"] = $this -> input -> post('date_format');
			$data["time_format"] = $this -> input -> post('time_format');
			$data["date_time_format"] = $this -> input -> post('date_time_format');
			$data["site_tracker"] = $this -> input -> post('site_tracker');
			$data["zipcode_min"] = $this -> input -> post('zipcode_min');
			$data["zipcode_max"] = $this -> input -> post('zipcode_max');
			$data["site_timezone"] = $this -> input -> post('site_timezone');

			$data["google_map_key"] = $this -> input -> post('google_map_key');
			$data["default_latitude"] = $this -> input -> post('default_latitude');
			$data["default_longitude"] = $this -> input -> post('default_longitude');
			$data["site_email"] = $this -> input -> post('site_email');
			$data["poker_coach_price"] = $this -> input -> post('poker_coach_price');
            $data["how_it_works_video"] = $this -> input -> post('how_it_works_video');
            $data["header_text"] = $this -> input -> post('header_text');
     
            
			$data['site_setting'] = site_setting();
			
			$data['page_name']="usercls";
			$this -> template -> write_view('header_menu', $theme . '/layout/common/header', $data, TRUE);
			$this -> template -> write_view('left', $theme . '/layout/common/sidebar', $data, TRUE);
			$this -> template -> write_view('center', $theme . '/layout/setting/add_site', $data, TRUE);
			$this -> template -> write_view('footer', $theme . '/layout/common/footer', $data, TRUE);

			$this -> template -> render();
		}
	}

	function add_user_guide($error='') {
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('add_user_guide');
 		
		 if(	$check_rights==0) {			
			 redirect('home/dashboard/no_rights');	
		 }
		$data = array();
		$theme = getThemeName();
		$this -> template -> set_master_template($theme . '/template.php');
      //  $data['msg'] = $msg;
		$this -> load -> library('form_validation');
		$this -> form_validation -> set_rules('h', 'dsads', 'required');
		//$this -> form_validation -> set_rules('halfmug_user_guide', 'Half-Mug Bar User Guide', 'required');
		//$this -> form_validation -> set_rules('time_format', 'TIME FORMAT', 'required');
		//$this -> form_validation -> set_rules('default_latitude', 'Default Latitude', 'required');
		//$this -> form_validation -> set_rules('default_longitude', 'Default Longitude', 'required');
		//$this -> form_validation -> set_rules('fullmug_user_guide', 'Full-Mug Bar', 'required');
       
        
		$data['page_name']="add_cms_pages";
		$data["error"] = $error;
		if ($this -> form_validation -> run() == FALSE) {
			if (validation_errors()) {
				$data["error"] = validation_errors();
			} else {
				//$data["error"] = "";
			}
			if ($this -> input -> post('site_setting_id')) {
				$one_site_setting = site_setting();

				$data["site_setting_id"] = $this -> input -> post('site_setting_id');
				$data["enthusiast_user_guide"] = $this -> input -> post('enthusiast_user_guide');
				$data["halfmug_user_guide"] = $this -> input -> post('halfmug_user_guide');
				$data["fullmug_user_guide"] = $this -> input -> post('fullmug_user_guide');
		
			} else {
				$one_site_setting = site_setting();
					
				$data["site_setting_id"] = $one_site_setting -> site_setting_id;
				$data["enthusiast_user_guide"] = $one_site_setting -> enthusiast_user_guide;
				$data["halfmug_user_guide"] = $one_site_setting -> halfmug_user_guide;
				$data["fullmug_user_guide"] = $one_site_setting -> fullmug_user_guide;
			}
			
			$data['site_setting'] = site_setting();

			$this ->template->write_view('header_menu', $theme . '/layout/common/header', $data, TRUE);
			$this->template-> write_view('center', $theme . '/layout/setting/add_cms_pages', $data, TRUE);
			$this->template->write_view('left', $theme . '/layout/common/sidebar', $data, TRUE);
			$this -> template -> write_view('footer', $theme . '/layout/common/footer', $data, TRUE);
			$this -> template -> render();
		} else {
			
			$this -> site_setting_model -> site_setting_update_new();
			
			redirect('site_setting/add_user_guide/update');
			$one_site_setting = site_setting();

			
			$data["site_setting_id"] = $this -> input -> post('site_setting_id');
			$data["enthusiast_user_guide"] = $this -> input -> post('enthusiast_user_guide');
			$data["halfmug_user_guide"] = $this -> input -> post('halfmug_user_guide');
			$data["fullmug_user_guide"] = $this -> input -> post('fullmug_user_guide');
			$data['site_setting'] = site_setting();
			
			$data['page_name']="usercls";
			$this -> template -> write_view('header_menu', $theme . '/layout/common/header', $data, TRUE);
			$this -> template -> write_view('left', $theme . '/layout/common/sidebar', $data, TRUE);
			$this -> template -> write_view('center', $theme . '/layout/setting/add_cms_pages', $data, TRUE);
			$this -> template -> write_view('footer', $theme . '/layout/common/footer', $data, TRUE);

			$this -> template -> render();
		}
	}

	function google_setting() {
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('google_setting');
 		
		 if(	$check_rights==0) {			
			 redirect('home/dashboard/no_rights');	
		 }
		
		$data = array();
		$theme = getThemeName();
		$this -> template -> set_master_template($theme . '/template.php');

		$this -> load -> library('form_validation');
		$this -> form_validation -> set_rules('google_client_id', 'Google Client Id', 'required');
		$this -> form_validation -> set_rules('google_url', 'Google Url', 'required');
		$this -> form_validation -> set_rules('google_login_enable', 'Google Login Enable', 'required');
		$this -> form_validation -> set_rules('google_client_secret', 'Google Client Secret', 'required|email');
       
        
		$data['page_name']="google_setting";
		
		if ($this -> form_validation -> run() == FALSE) {
			if (validation_errors()) {
				$data["error"] = validation_errors();
			} else {
				$data["error"] = "";
			}
			if ($this -> input -> post('google_setting_id')) {
				$one_site_setting = google_setting();
				
				$data["google_setting_id "] = $this -> input -> post('google_setting_id ');
				$data["google_client_id"] = $this -> input -> post('google_client_id');
				$data["google_url"] = $this -> input -> post('google_url');
				$data["google_login_enable"] = $this -> input -> post('google_login_enable');
				$data["google_client_secret"] = $this -> input -> post('google_client_secret');
				
				
		
			} else {
				$one_google_setting = google_setting();
				//print_r($one_site_setting); die;	
				$data["google_setting_id"] = $one_google_setting -> google_setting_id ;
				$data["google_client_id"] = $one_google_setting -> google_client_id;
				$data["google_url"] = $one_google_setting -> google_url;
				$data["google_login_enable"] = $one_google_setting -> google_login_enable;
				$data["google_client_secret"] = $one_google_setting -> google_client_secret;
				
               
			
			}
			
			$data['google_setting'] = google_setting();

			$this ->template->write_view('header_menu', $theme . '/layout/common/header', $data, TRUE);
			$this->template-> write_view('center', $theme . '/layout/setting/google', $data, TRUE);
			$this->template->write_view('left', $theme . '/layout/common/sidebar', $data, TRUE);
			$this -> template -> write_view('footer', $theme . '/layout/common/footer', $data, TRUE);
			$this -> template -> render();
		} else {
			$this -> site_setting_model -> site_google_update();
			$one_google_setting = google_setting();
			
			$data["error"] = "update";
			$data["google_setting_id"] = $this -> input -> post('google_setting_id');
			$data["google_client_id"] = $this -> input -> post('google_client_id');
			$data["google_url"] = $this -> input -> post('google_url');
			$data["google_login_enable"] = $this -> input -> post('google_login_enable');
			$data["google_client_secret"] = $this -> input -> post('google_client_secret');
			
     
			$data['google_setting'] = google_setting();
			
			$data['page_name']="usercls";
			$this -> template -> write_view('header_menu', $theme . '/layout/common/header', $data, TRUE);
			$this -> template -> write_view('left', $theme . '/layout/common/sidebar', $data, TRUE);
			$this -> template -> write_view('center', $theme . '/layout/setting/google', $data, TRUE);
			$this -> template -> write_view('footer', $theme . '/layout/common/footer', $data, TRUE);

			$this -> template -> render();
		}
	}
	
	
	function facebook_setting() {
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('facebook_setting');
 		
		 if(	$check_rights==0) {			
			 redirect('home/dashboard/no_rights');	
		 }
		
		$data = array();
		$theme = getThemeName();
		$this -> template -> set_master_template($theme . '/template.php');

		$this -> load -> library('form_validation');
		$this -> form_validation -> set_rules('facebook_application_id', 'Facebook Application Id', 'required');
		$this -> form_validation -> set_rules('facebook_login_enable', 'Facebook Login Enable', 'required');
		$this -> form_validation -> set_rules('facebook_access_token', 'Facebook_Access Token', 'required');
		$this -> form_validation -> set_rules('facebook_api_key', 'Facebook Api Key', 'required');
		$this -> form_validation -> set_rules('facebook_secret_key', 'Facebook Secret Key', 'required');
		$this -> form_validation -> set_rules('facebook_user_autopost', 'Facebook User Autopost', 'required');
		$this -> form_validation -> set_rules('facebook_wall_post', 'Facebook Wall Post', 'required');
		$this -> form_validation -> set_rules('facebook_url', 'Facebook Url', 'required');
		
       
        
		$data['page_name']="facebook_setting";
		
		if ($this -> form_validation -> run() == FALSE) {
			if (validation_errors()) {
				$data["error"] = validation_errors();
			} else {
				$data["error"] = "";
			}
			if ($this -> input -> post('facebook_setting_id')) {
				$one_facebook_setting = facebook_setting();
				//print_r($one_facebook_setting); die;
				
				$data["facebook_setting_id"] = $this -> input -> post('facebook_setting_id');
				$data["facebook_login_enable"] = $this -> input -> post('facebook_login_enable');
				$data["facebook_application_id"] = $this -> input -> post('facebook_application_id');
				$data["facebook_access_token"] = $this -> input -> post('facebook_access_token');
				$data["facebook_api_key"] = $this -> input -> post('facebook_api_key');
				$data["facebook_secret_key"] = $this -> input -> post('facebook_secret_key');
				$data["facebook_user_autopost"] = $this -> input -> post('facebook_user_autopost');
				$data["facebook_wall_post"] = $this -> input -> post('facebook_wall_post');
				$data["facebook_url"] = $this -> input -> post('facebook_url');
				
				
		
			} else {
				$one_facebook_setting = facebook_setting();
				//print_r($one_facebook_setting); die;	
				$data["facebook_setting_id"] = $one_facebook_setting -> facebook_setting_id ;
				$data["facebook_login_enable"] = $one_facebook_setting -> facebook_login_enable;
				$data["facebook_application_id"] = $one_facebook_setting -> facebook_application_id ;
				$data["facebook_access_token"] = $one_facebook_setting -> facebook_access_token;
				$data["facebook_api_key"] = $one_facebook_setting -> facebook_api_key;
				$data["facebook_secret_key"] = $one_facebook_setting -> facebook_secret_key;
				$data["facebook_user_autopost"] = $one_facebook_setting -> facebook_user_autopost;
				$data["facebook_wall_post"] = $one_facebook_setting -> facebook_wall_post;
				$data["facebook_url"] = $one_facebook_setting -> facebook_url;
				
               
			
			}
			
			$data['facebook_setting'] = facebook_setting();

			$this ->template->write_view('header_menu', $theme . '/layout/common/header', $data, TRUE);
			$this->template-> write_view('center', $theme . '/layout/setting/facebook', $data, TRUE);
			$this->template->write_view('left', $theme . '/layout/common/sidebar', $data, TRUE);
			$this -> template -> write_view('footer', $theme . '/layout/common/footer', $data, TRUE);
			$this -> template -> render();
		} else {
			$this -> site_setting_model -> site_facebook_update();
			$one_facebook_setting = facebook_setting();
			
			     $data["error"] = "update";
			    //$data["facebook_setting_id"] = $this -> input -> post('facebook_setting_id');
				 
				$data["facebook_setting_id"] = $this -> input -> post('facebook_setting_id');
				$data["facebook_application_id"] = $this -> input -> post('facebook_application_id');
				$data["facebook_login_enable"] = $this -> input -> post('facebook_login_enable');
				$data["facebook_access_token"] = $this -> input -> post('facebook_access_token');
				$data["facebook_api_key"] = $this -> input -> post('facebook_api_key');
				$data["facebook_secret_key"] = $this -> input -> post('facebook_secret_key');
				$data["facebook_user_autopost"] = $this -> input -> post('facebook_user_autopost');
				$data["facebook_wall_post"] = $this -> input -> post('facebook_wall_post');
				$data["facebook_url"] = $this -> input -> post('facebook_url');
     		
			$data['facebook_setting'] = facebook_setting();
			
			$data['page_name']="usercls";
			$this -> template -> write_view('header_menu', $theme . '/layout/common/header', $data, TRUE);
			$this -> template -> write_view('left', $theme . '/layout/common/sidebar', $data, TRUE);
			$this -> template -> write_view('center', $theme . '/layout/setting/facebook', $data, TRUE);
			$this -> template -> write_view('footer', $theme . '/layout/common/footer', $data, TRUE);

			$this -> template -> render();
		}
	}
	
	
	function paypal_setting() {
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('paypal_setting');
 		
		 if(	$check_rights==0) {			
			 redirect('home/dashboard/no_rights');	
		 }
		$data = array();
		$theme = getThemeName();
		$this -> template -> set_master_template($theme . '/template.php');

		$this -> load -> library('form_validation');
		$this -> form_validation -> set_rules('site_status', 'Site Status', 'required');
		//$this -> form_validation -> set_rules('paypal_email', 'Paypal Emaile', 'required');
		//$this -> form_validation -> set_rules('admin_commision', 'Admin Commision', 'required');
		$this -> form_validation -> set_rules('vendor', 'Vendor', 'required');
		$this -> form_validation -> set_rules('paypal_username', 'Username', 'required');
		$this -> form_validation -> set_rules('paypal_password', 'Password', 'required');
		$this -> form_validation -> set_rules('partner_name', 'Partner Name', 'required');
		//$this -> form_validation -> set_rules('secret_key', 'Secret Key', 'required');
       
        
		$data['page_name']="paypal_setting";
		
		if ($this -> form_validation -> run() == FALSE) {
			if (validation_errors()) {
				$data["error"] = validation_errors();
			} else {
				$data["error"] = "";
			}
			if ($this -> input -> post('id')) {
				$one_paypal_setting = paypal_setting();
				//print_r($one_facebook_setting); die;
				
				$data["id"] = $this -> input -> post('id');
				$data["site_status"] = $this -> input -> post('site_status');
				$data["partner_name"] = $this -> input -> post('partner_name');
				//$data["admin_commision"] = $this -> input -> post('admin_commision');
				//$data["paypal_email"] = $this -> input -> post('paypal_email');
				$data["paypal_password"] = $this -> input -> post('paypal_password');
				$data["paypal_username"] = $this -> input -> post('paypal_username');
				$data["vendor"] = $this -> input -> post('vendor');
				
				
		
			} else {
				$one_paypal_setting = paypal_setting();
				//print_r($one_paypal_setting); die;	
				$data["id"] = $one_paypal_setting ->id ;
				$data["site_status"] = $one_paypal_setting -> site_status;
				$data["partner_name"] = $one_paypal_setting -> partner_name;
				//$data["admin_commision"] = $one_paypal_setting -> admin_commision;
				//$data["paypal_email"] = $one_paypal_setting -> paypal_email ;
				$data["paypal_password"] = $one_paypal_setting -> paypal_password ;
				$data["paypal_username"] = $one_paypal_setting -> paypal_username ;
				$data["vendor"] = $one_paypal_setting -> vendor ;
			
			}
			
			$data['paypal_setting'] = paypal_setting();

			$this ->template->write_view('header_menu', $theme . '/layout/common/header', $data, TRUE);
			$this->template-> write_view('center', $theme . '/layout/setting/paypal', $data, TRUE);
			$this->template->write_view('left', $theme . '/layout/common/sidebar', $data, TRUE);
			$this -> template -> write_view('footer', $theme . '/layout/common/footer', $data, TRUE);
			$this -> template -> render();
		} else {
			$this -> site_setting_model -> site_paypal_update();
			$one_paypal_setting = paypal_setting();
			
			     $data["error"] = "update";
			    //$data["facebook_setting_id"] = $this -> input -> post('facebook_setting_id');
				 
				$data["id"] = $this -> input -> post('id');
				$data["site_status"] = $this -> input -> post('site_status');
				//$data["admin_commision"] = $this -> input -> post('admin_commision');
				//$data["paypal_email"] = $this -> input -> post('paypal_email');
				$data["paypal_password"] = $one_paypal_setting -> paypal_password ;
				$data["partner_name"] = $one_paypal_setting -> partner_name ;
				$data["paypal_username"] = $one_paypal_setting -> paypal_username ;
				$data["vendor"] = $one_paypal_setting -> vendor ;
			
     		   $data['paypal_setting'] = paypal_setting();
			
			$data['page_name']="usercls";
			$this -> template -> write_view('header_menu', $theme . '/layout/common/header', $data, TRUE);
			$this -> template -> write_view('left', $theme . '/layout/common/sidebar', $data, TRUE);
			$this -> template -> write_view('center', $theme . '/layout/setting/paypal', $data, TRUE);
			$this -> template -> write_view('footer', $theme . '/layout/common/footer', $data, TRUE);

			$this -> template -> render();
		}
	}

     function message_setting() {
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('message_setting');
 		
		 if(	$check_rights==0) {			
			 redirect('home/dashboard/no_rights');	
		 }
		$data = array();
		$theme = getThemeName();
		$this -> template -> set_master_template($theme . '/template.php');

		$this -> load -> library('form_validation');
		$this -> form_validation -> set_rules('mode', 'Mode', 'required');
		$this -> form_validation -> set_rules('account_sid', 'Sid', 'required');
		$this -> form_validation -> set_rules('auth_token', 'Token', 'required');
		$this -> form_validation -> set_rules('api_version', 'Api Version', 'required');
		$this -> form_validation -> set_rules('number', 'From Number', 'required');
       
        
		$data['page_name']="message_setting";
		
		if ($this -> form_validation -> run() == FALSE) {
			if (validation_errors()) {
				$data["error"] = validation_errors();
			} else {
				$data["error"] = "";
			}
			if ($this -> input -> post('id')) {
				$one_paypal_setting = message_setting();
				//print_r($one_facebook_setting); die;
				
				$data["twilio_id"] = $this -> input -> post('twilio_id');
				$data["mode"] = $this -> input -> post('mode');
				$data["account_sid"] = $this -> input -> post('account_sid');
				$data["auth_token"] = $this -> input -> post('auth_token');
				$data["api_version"] = $this -> input -> post('api_version');
				$data["number"] = $this -> input -> post('number');
				
				
				
		
			} else {
				$one_paypal_setting = message_setting();
				//print_r($one_paypal_setting); die;	
				$data["twilio_id"] = $one_paypal_setting ->twilio_id ;
				$data["mode"] = $one_paypal_setting -> mode;
				$data["account_sid"] = $one_paypal_setting -> account_sid;
				$data["auth_token"] = $one_paypal_setting -> auth_token ;
				$data["api_version"] = $one_paypal_setting -> api_version ;
				$data["number"] = $one_paypal_setting -> number ;
			
			}
			
			$data['paypal_setting'] = message_setting();

			$this ->template->write_view('header_menu', $theme . '/layout/common/header', $data, TRUE);
			$this->template-> write_view('center', $theme . '/layout/setting/twilio', $data, TRUE);
			$this->template->write_view('left', $theme . '/layout/common/sidebar', $data, TRUE);
			$this -> template -> write_view('footer', $theme . '/layout/common/footer', $data, TRUE);
			$this -> template -> render();
		} else {
			$this -> site_setting_model -> site_twilio_update();
			$one_paypal_setting = message_setting();
			
			     $data["error"] = "update";
			    //$data["facebook_setting_id"] = $this -> input -> post('facebook_setting_id');
				 
				$data["twilio_id"] = $this -> input -> post('twilio_id');
				$data["mode"] = $this -> input -> post('mode');
				$data["account_sid"] = $this -> input -> post('account_sid');
				$data["auth_token"] = $this -> input -> post('auth_token');
				$data["api_version"] = $this -> input -> post('api_version');
				$data["number"] = $this -> input -> post('number');
			
     		   $data['paypal_setting'] = message_setting();
			
			$data['page_name']="usercls";
			$this -> template -> write_view('header_menu', $theme . '/layout/common/header', $data, TRUE);
			$this -> template -> write_view('left', $theme . '/layout/common/sidebar', $data, TRUE);
			$this -> template -> write_view('center', $theme . '/layout/setting/twilio', $data, TRUE);
			$this -> template -> write_view('footer', $theme . '/layout/common/footer', $data, TRUE);

			$this -> template -> render();
		}
	}

	function yahoo_setting() {
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('yahoo_setting');
 		
		 if(	$check_rights==0) {			
			 redirect('home/dashboard/no_rights');	
		 }
		
		$data = array();
		$theme = getThemeName();
		$this -> template -> set_master_template($theme . '/template.php');

		$this -> load -> library('form_validation');
		$this -> form_validation -> set_rules('app_id', 'App Id', 'required');
		$this -> form_validation -> set_rules('consumer_key', 'Consumer Key', 'required');
		$this -> form_validation -> set_rules('consumer_secret', 'Consumer Secret', 'required');
		$this -> form_validation -> set_rules('email_id', 'Email Id', 'required');
		$this -> form_validation -> set_rules('password', 'Password', 'required');
		
       
        
		$data['page_name']="yahoo_setting";
		
		if ($this -> form_validation -> run() == FALSE) {
			if (validation_errors()) {
				$data["error"] = validation_errors();
			} else {
				$data["error"] = "";
			}
			if ($this -> input -> post('id')) {
				$one_yahoo_setting = yahoo_setting();
				//print_r($one_facebook_setting); die;
				
				$data["yahoo_setting_id"] = $this -> input -> post('yahoo_setting_id');
				$data["app_id"] = $this -> input -> post('app_id');
				$data["consumer_key"] = $this -> input -> post('consumer_key');
				$data["consumer_secret"] = $this -> input -> post('consumer_secret');
				$data["email_id"] = $this -> input -> post('email_id');
				$data["password"] = $this -> input -> post('password');
				
				
				
		
			} else {
				$one_yahoo_setting = yahoo_setting();
				//print_r($one_yahoo_setting); die;	
				$data["yahoo_setting_id"] = $one_yahoo_setting ->yahoo_setting_id ;
				$data["app_id"] = $one_yahoo_setting -> app_id;
				$data["consumer_key"] = $one_yahoo_setting -> consumer_key;
				$data["consumer_secret"] = $one_yahoo_setting -> consumer_secret ;
				$data["email_id"] = $one_yahoo_setting -> email_id;
				$data["password"] = $one_yahoo_setting -> password ;
			
			}
			
			$data['yahoo_setting'] = yahoo_setting();

			$this ->template->write_view('header_menu', $theme . '/layout/common/header', $data, TRUE);
			$this->template-> write_view('center', $theme . '/layout/setting/yahoo', $data, TRUE);
			$this->template->write_view('left', $theme . '/layout/common/sidebar', $data, TRUE);
			$this -> template -> write_view('footer', $theme . '/layout/common/footer', $data, TRUE);
			$this -> template -> render();
		} else {
			$this -> site_setting_model -> site_yahoo_update();
			$one_yahoo_setting = yahoo_setting();
			
			     $data["error"] = "update";
			    //$data["facebook_setting_id"] = $this -> input -> post('facebook_setting_id');
				 
				$data["yahoo_setting_id"] = $this -> input -> post('yahoo_setting_id');
				$data["app_id"] = $this -> input -> post('app_id');
				$data["consumer_key"] = $this -> input -> post('consumer_key');
				$data["consumer_secret"] = $this -> input -> post('consumer_secret');
				$data["email_id"] = $this -> input -> post('email_id');
				$data["password"] = $this -> input -> post('password');
			
     		   $data['yahoo_setting'] = yahoo_setting();
			
			$data['page_name']="usercls";
			$this -> template -> write_view('header_menu', $theme . '/layout/common/header', $data, TRUE);
			$this -> template -> write_view('left', $theme . '/layout/common/sidebar', $data, TRUE);
			$this -> template -> write_view('center', $theme . '/layout/setting/yahoo', $data, TRUE);
			$this -> template -> write_view('footer', $theme . '/layout/common/footer', $data, TRUE);

			$this -> template -> render();
		}
	}
	

}
?>