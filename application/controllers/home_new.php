<?php
require(APPPATH.'PayPal-PHP-SDK/paypal/rest-api-sdk-php/sample/bootstrap.php');
//require(APPPATH.'PayPal/vendor/autoload.php');
//require ('Paypal/common.php');
use PayPal\Api\CreditCard;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\CreditCardToken;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Transaction;


class Home extends SPACULLUS_Controller {

	/*
	 Function name :Home()
	 Description :Its Default Constuctor which called when home object initialzie.its load necesary models
	 */

	function Home () {
		
		
		
		parent :: __construct ();
		$this->load->library ("PasswordHash");
		$this->load->library ("encrypt");
		$this->load->model ('home_model');
		$this->load->model ('bar_model');
		$this->load->model ('user_model');
		$this->load->helper ("cookie");
		$this->load->library('fb_connect');
		$this->config->load('facebook');
		
	
		 $getpaypalsetting = paypalsetting();
		$this->apiContext = new ApiContext(
		new OAuthTokenCredential(
			$getpaypalsetting->client_id,
			$getpaypalsetting->secret_key
		)
	);
	
	
	   $this->apiContext->setConfig(
		array(
			'mode' => $getpaypalsetting->site_status,
			'http.ConnectionTimeOut' => 30,
			'log.LogEnabled' => true,
			'log.FileName' => FCPATH.'application/logs/PayPal.log',
			'log.LogLevel' => 'FINE'
		)
	);
	
	}

	public function index ($msg = '') {
		
		//$this->cart->destroy();
	    $data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
		$data['ms'] = base64_decode($msg);
		
		
		
		// echo md5($data['site_setting']->site_name.time());
		// die; 
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        
		$this->load->helper('recaptchalib');
		$publickey = '6LcjQAoTAAAAAMeqHoabD3bRBJuuQciyIbnaZFkU';
		$privatekey = '6LcjQAoTAAAAAM1AR1k-_AtX0DVZ5r0II1GgUzPL';
		$resp = null;
		$error = null;
		$captcha_error='';
		
		$data['captcha_img']=recaptcha_get_html($publickey,$error);		
		$data['first_name'] = $this->input->post('first_name');
		$data['last_name'] = $this->input->post('last_name');
		$data['email'] = $this->input->post('email');
		$data['user_name'] = $this->input->post('user_name');
		$data['gallery'] = $this->home_model->getBannerGallery();
		$data['latest_news']  = $this->home_model->latestmews(2);
		$data['latest_event']  = $this->home_model->latestevent(2);
		$data['latest_forum']  = $this->home_model->latestforum(4);
        if(get_authenticateUserID() > 0)
        {
		  $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        }
        else
        {
            $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        }
		$this->template->write_view ('content_center', $theme.'/home/index', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();

	}
	
	function signup ($msg = '') 
	{
		if (check_user_authentication ()!= '') {
			redirect ('home');
		}
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$data['msg'] = '';
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name','First Name','required');
		$this->form_validation->set_rules('last_name','Last Name','required');
		$this->form_validation->set_rules('email','Email','required|callback_email_check_enthuser');
		$this->form_validation->set_rules('user_name','User Name','required|callback_username_check');
		$this->form_validation->set_rules('password','Password','required|min_length[8]|callback_password_check');
		$this->form_validation->set_rules('confirm_password','Confirm Password','required');
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			$data['first_name'] = $this->input->post('first_name');
			$data['last_name'] = $this->input->post('last_name');
			$data['email'] = $this->input->post('email');
			$data['user_name'] = $this->input->post('user_name');
		}
		else{
			$password = md5($this->input->post("password"));
			$data_insert = array ();
            $data_insert['first_name'] = $this->input->post ('first_name');
			$data_insert['last_name'] = $this->input->post ('last_name');
			$data_insert['email'] = $this->input->post ('email');
		    $data_insert['password'] = $password;
			$data_insert["status"] = "inactive";
			$data_insert['user_name'] = $this->input->post('user_name');
            $data_insert['sign_up_ip'] = $_SERVER['REMOTE_ADDR'];
			$data_insert['sign_up_date'] = date ('Y-m-d H:i:s');				
				
			$login = $this->home_model->insert_user ($data_insert, $this->input->post ("password"));
			$msg = 'insert';
			$msg = base64_encode("signup_sucess");
			redirect ('home/login/'.$msg);
		}
		$this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/signup', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();
	}
	
	/** password check function
	 * 
	 * author : Thais
	 */
    public function password_check($str)
    {
       if (preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {
           
         return TRUE;
       }
       else {
           $this->form_validation->set_message('password_check', 'The password can only contain alphanumeric characters');
            return FALSE;
       }
       
    }

	/** login function
	 * 
	 * author : Thais
	 */
	function login($msg = '',$email = '') {
		if (check_user_authentication ()!= '') {
			redirect ('home');
		}

		$data["email"] = get_cookie ('email');
		$data["password"] = $this->encrypt->decode(get_cookie('password'));
		$data["remember_me"] = get_cookie ('remember_me');
		$theme = getThemeName ();

		$data['error'] = '';
        $data["active_menu"]='';
        $data['site_setting'] = site_setting ();
		$data["msg"] = base64_decode($msg);
		
		$data["reset_email"] = base64_decode($email);
		
		$data["maximum_attemp_cond"] = '';

		$this->template->set_master_template ($theme.'/template.php');

		
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		$this->load->library ('form_validation');

		$this->form_validation->set_rules ('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules ('password', 'Password', 'required');

		if ($_POST) { 
			if ($this->form_validation->run ()== FALSE) {
				if (validation_errors ()) {
					$data["error"] = validation_errors ();
				} else {
					$data["error"] = "";
				}
				
			
				$data["email"] = $this->input->post ('email');
				$data["password"] = $this->input->post ('password');
				$data["remember_me"] = $this->input->post ('remember_me');
			} else {
				
				
				$login = $this->home_model->check_login ($this->input->post ('email'), $this->input->post ('password'), $this->input->post ('remember_me'));
								
				if ($login== '1') {
					
					$REDIRECT_URL = $this->session->userdata("REDIRECT_PAGE");
					$this->session->unset_userdata("REDIRECT_PAGE");
					
					if($REDIRECT_URL != "")
					{
						redirect($REDIRECT_URL);
					}
					redirect ('home/dashboard');                    
				}              
				elseif ($login== 0) {
					$data['error'] = INACTIVE_ACCOUNT;
				} 				
				else {                    
                   $data["msg"] = "invalid";
				}
			}
		}
		
		$this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/login', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render();

	}

	function dashboard($msg='')
	{
	
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		
		if($this->session->userdata('user_type')!='bar_owner' && $this->session->userdata('user_type')!='taxi_owner' && get_authenticateUserID())
		{
			redirect('home/user_dashboard');
		}
		
		if($this->session->userdata('user_type')!='bar_owner' && $this->session->userdata('user_type')!='user' && get_authenticateUserID())
		{
			redirect('home/taxi_owner_dashboard');
		}
		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$data['theme'] = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
		
		$data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		$data['getpostcard'] = $this->home_model->get_bar_postcard($data['getbar']['bar_id'],'4');
		$data['getorder'] = $this->home_model->get_bar_order($data['getbar']['bar_id'],'4');
		
	
		
		$data['one_user'] = $this->home_model->get_availability_time($data['getbar']['bar_id']);
		$data['albumgallery'] = $this->bar_model->getAllBarGal($data['getbar']['bar_id']);
		$data['result'] = $this->bar_model->getAllComments($data['getbar']['bar_id'],$offset=0,$limit=4);
		$data['resultmessage'] = $this->bar_model->getUnreadMessage($offset=0,$limit=4);
		$data['getalldata'] = $this->home_model->getOneUser();
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/dashboard', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();
	} 

   function taxi_owner_dashboard($msg='')
   {
   	    if($this->session->userdata('user_type')=='bar_owner')
		{
			redirect('home/dashboard');
		}
		if($this->session->userdata('user_type')=='user')
		{
			redirect('home/user_dashboard');
		}
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$data['theme'] = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
		
		$data['getalldata'] = get_user_info_taxi(get_authenticateUserID());
		$data['albumgallery'] = $this->user_model->getalbumgallery(get_authenticateUserID());
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/dashboard_taxi_owner', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();
   }
   function user_dashboard($msg='')
   {
  
   		if($this->session->userdata('user_type')=='bar_owner')
		{
			redirect('home/dashboard');
		}
		if($this->session->userdata('user_type')=='taxi_owner')
		{
			redirect('home/taxi_owner_dashboard');
		}
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$data['theme'] = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
		
		$data['getalldata'] = get_user_info(get_authenticateUserID());
		$data['albumgallery'] = $this->user_model->getalbumgallery(get_authenticateUserID());
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/dashboard_user', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();
   }
   function bar_owner_register($msg = '', $email = '',$bar_id_orig='') {
   	 
		if (check_user_authentication ()!= '') {
			redirect ('home');
		}

		$theme = getThemeName ();

		$data['error'] = '';
        $data["active_menu"]='';
        $data['site_setting'] = site_setting ();
		$data["msg"] = base64_decode($msg);
		
		$data["reset_email"] = base64_decode($email);
		
       
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$bar_id ='';
		 
		if($bar_id_orig!='')
		{
			
			$bar_id_orig = base64_decode($bar_id_orig);
			$this->session->set_userdata(array('viewid_orig' => $bar_id_orig));
			$data['getbardata'] = $this->home_model->getBarData($bar_id_orig);
			
			//print_r($data['getbardata']);
			
			$data["email"] = $data['getbardata']['email'];
			$data["bar_title"] = $data['getbardata']['bar_title'];
			//$data["first_name"] = $data['getbardata']['first_name'];
			//$data["last_name"] = $data['getbardata']['last_name'];
			$data["address"] = $data['getbardata']['address'];
			$data["city"] = $data['getbardata']['city'];
			$data["zip"] = $data['getbardata']['zipcode'];
			$data["state"] = $data['getbardata']['state'];
			$data["bar_meta_title"] = $data['getbardata']['bar_meta_title'];
			$data["bar_meta_keyword"] = $data['getbardata']['bar_meta_keyword'];
			$data["bar_meta_description"] = $data['getbardata']['bar_meta_description'];
			//$data["zip"] = $data['getbardata']['zip'];
			//$data["desc"] = $data['getbardata']['desc'];
			//$bar_id = $this->session->userdata('viewid_orig');
			//$barid= $this->home_model->register_bar_owner($bar_id);
		}
		else {
		   $bar_id = $this->session->userdata('viewid');	
		}
		
		if($bar_id!='')
		{
			$data['getbardata'] = $this->home_model->getBardataTemp($bar_id);
			
			$data['getbardatafeature'] = $this->home_model->getBardataTempFeature($bar_id);
			$data["email"] = $data['getbardata']['email'];
			$data["bar_title"] = $data['getbardata']['bar_title'];
			$data["first_name"] = $data['getbardata']['first_name'];
			$data["last_name"] = $data['getbardata']['last_name'];
			$data["address"] = $data['getbardata']['address'];
			$data["city"] = $data['getbardata']['city'];
			$data["state"] = $data['getbardata']['state'];
			$data["zip"] = $data['getbardata']['zip'];
			$data["desc"] = $data['getbardata']['desc'];
			$data["bar_meta_title"] = $data['getbardata']['bar_meta_title'];
			$data["bar_meta_keyword"] = $data['getbardata']['bar_meta_keyword'];
			$data["bar_meta_description"] = $data['getbardata']['bar_meta_description'];
		}
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		$this->load->library ('form_validation');

		$this->form_validation->set_rules('email','Email','required|callback_email_check_baruser');
		$this->form_validation->set_rules('bar_title', 'Bar Title', 'required|callback_bartitle_check');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');
		$this->form_validation->set_rules('zip', 'Zip Code', 'required|numeric');
		//$this->form_validation->set_rules('desc', 'Description', 'required');
		//$this->form_validation->set_rules('bar_meta_title', 'Meta Title', 'required');
		//$this->form_validation->set_rules('bar_meta_keyword', 'Meta Keyword', 'required');
		//$this->form_validation->set_rules('bar_meta_description', 'Meta Description', 'required');
       
		if ($_POST) { 
			if ($this->form_validation->run ()== FALSE) {
				if (validation_errors ()) {
					$data["error"] = validation_errors ();
				} else {
					$data["error"] = "";
				}
				
			
				$data["email"] = $this->input->post ('email');
				$data["bar_title"] = $this->input->post ('bar_title');
				$data["first_name"] = $this->input->post ('first_name');
				$data["last_name"] = $this->input->post ('last_name');
				$data["address"] = $this->input->post ('address');
				$data["city"] = $this->input->post ('city');
				$data["state"] = $this->input->post ('state');
				$data["zip"] = $this->input->post ('zip');
				$data["desc"] = $this->input->post ('desc');
				$data["bar_meta_title"] = $this->input->post ('bar_meta_title');
				$data["bar_meta_keyword"] = $this->input->post ('bar_meta_keyword');
				$data["bar_meta_description"] = $this->input->post ('bar_meta_description');
			} else {
				if($this->input->post('temp_id')=="")
				{
					$barid= $this->home_model->register_bar_owner();
					redirect('home/registration_step2/'.base64_encode($barid));
				}	
				else
				{
					$barid= $this->home_model->register_bar_owner_update();
					redirect('home/registration_step2/'.base64_encode($this->input->post('temp_id')));
				}
				
			}
		}
		
		$this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/bar_owner_register', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render();

	}
	
	function registration_step2($bar_id='')
	{
		if (check_user_authentication ()!= '') {
			redirect ('home');
		}
		
		
		if($bar_id!="")
		{
			$bar_id = base64_decode($bar_id);
			$this->session->set_userdata(array('viewid' => $bar_id));
			$bar_id = $this->session->userdata('viewid');
		}
		elseif($this->session->userdata('viewid')!="") {
			$bar_id = $this->session->userdata('viewid');
			
		}
		if($bar_id=='')
		{
			redirect ('home/bar_owner_register');
		}
		$theme = getThemeName ();
		$data['error'] = '';
		$data['bar_id'] = $bar_id;
        $data["active_menu"]='';
        $data['site_setting'] = site_setting ();
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$data['getbardata'] = $this->home_model->getBardataTemp($bar_id);
		$data['getbardatafeature'] = $this->home_model->getBardataTempFeature($bar_id);
		$data['one_user'] = $this->home_model->get_availability($bar_id);
		
		
		
		if($data['getbardatafeature']){
		$data['getbardatafeature_new'] = $data['getbardatafeature']['feature_id'];
		}
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		$this->load->library ('form_validation');

		$this->form_validation->set_rules('btype','Free Listing Or Paid Listing','required');

        
		if ($_POST) { 
			if ($this->form_validation->run ()== FALSE) {
				if (validation_errors ()) {
					$data["error"] = validation_errors ();
				} else {
					$data["error"] = "";
				}
			} else {
				if($this->input->post('bar_feature_id')=="")
				{
					
					$barid_new = $this->home_model->register_bar_owner_features();
					redirect('home/registration_step3');
				}	
				else
				{
					$barid_new = $this->home_model->register_bar_owner_features_update();
					redirect('home/registration_step3');
				}
				
			}
		}
		
		$this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/registration_step2', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render();
		
	
	}

    function registration_step3()
	{
		$bar_id = $this->session->userdata('viewid');
		
		if($bar_id=='')
		{
			redirect ('home/bar_owner_register');
		}

		$theme = getThemeName ();
		$data['error'] = '';
		$data['bar_id'] = $bar_id;
        $data["active_menu"]='';
        $data['site_setting'] = site_setting ();
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$data['getbardata'] = $this->home_model->getBardataTemp($bar_id);
		$data['getbardatafeature'] = $this->home_model->getBardataTempFeature($bar_id);
		
		
		$count = 0;
		if($data['getbardatafeature'])
		{
		$count = $data['getbardatafeature']['feature_id'];
		//$count = count(explode(',',$count));
		}
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		$this->load->library ('form_validation');

		$this->form_validation->set_rules('choise_bar','Choise Bar','required');

		if ($_POST) { 
					
					//$barid_new = $this->home_model->register_bar_owner_features();
					if($count>0)
					{
						// $slug=getBarSlug($data['getbardata']['bar_title']);	
						// $bar_id = $this->session->userdata('viewid');
						// $data['getbardata'] = $this->home_model->getBardataTemp($bar_id);
						// $data['getbardatafeature'] = $this->home_model->getBardataTempFeature($bar_id);
						// $pass = randomCode();
						// $conf = rand('11111111','99999999');
						// $data_insert['first_name'] = $data['getbardata']['first_name'] ;
						// $data_insert['last_name'] = $data['getbardata']['last_name'] ;
						// $data_insert['email'] = $data['getbardata']['email'];
						// $data_insert['gender'] =$data['getbardata']['gender'];
						// $data_insert['address'] = $data['getbardata']['address'];
						// $data_insert['status'] = 'inactive';
						// $data_insert['is_deleted'] = 'no';
						// $data_insert['user_type'] = 'bar_owner';
// 						
						// $data_insert['password'] = md5($pass);		
						// $data_insert['confirm_code'] = $conf;		
						// $data_insert['sign_up_ip'] = $_SERVER['REMOTE_ADDR'];
						// $data_insert['sign_up_date'] = date('Y-m-d H:i:s');		
						// $this->db->insert('user_master',$data_insert);		
						// $uid = mysql_insert_id();
						// $data['user_id'] = $uid;
// 				
				        // if($this->session->userdata('viewid_orig')!='' && $this->session->userdata('viewid_orig')!=0)
						// {
							// $data_insert_new['bar_title'] = $data['getbardata']['bar_title'] ;
							// $data_insert_new['owner_name'] = $data['getbardata']['first_name']." ".$data['getbardata']['last_name'];
							// $data_insert_new['email'] = $data['getbardata']['email'];
							// $data_insert_new['owner_id'] = $uid;
							// $data_insert_new['address'] =$data['getbardata']['address'];
							// $data_insert_new['bar_desc'] = nl2br($data['getbardata']['desc']);
							// $data_insert_new['city'] = $data['getbardata']['city'];
							// $data_insert_new['bar_type'] = 'full_mug';
							// $data_insert_new['bar_slug'] = $slug;
							// $data_insert_new['owner_type'] = 'bar_owner';
							// $data_insert_new['state'] = $data['getbardata']['state'];
							// $data_insert_new['zipcode'] = $data['getbardata']['zip'];
							// $this->db->where('bar_id',$this->session->userdata('viewid_orig'));
							// $this->db->update('bars',$data_insert_new);	
							// $bar_id = $this->session->userdata('viewid_orig');
						// }
						// else {
							// $data_insert_new['bar_title'] = $data['getbardata']['bar_title'] ;
							// $data_insert_new['owner_name'] = $data['getbardata']['first_name']." ".$data['getbardata']['last_name'];
							// $data_insert_new['email'] = $data['getbardata']['email'];
							// $data_insert_new['owner_id'] = $uid;
							// $data_insert_new['address'] =$data['getbardata']['address'];
							// $data_insert_new['bar_desc'] = nl2br($data['getbardata']['desc']);
							// $data_insert_new['city'] = $data['getbardata']['city'];
							// $data_insert_new['bar_type'] = 'full_mug';
							// $data_insert_new['bar_slug'] = $slug;
							// $data_insert_new['owner_type'] = 'bar_owner';
							// $data_insert_new['state'] = $data['getbardata']['state'];
							// $data_insert_new['zipcode'] = $data['getbardata']['zip'];
							// $this->db->insert('bars',$data_insert_new);		
							// $bar_id = mysql_insert_id();
						// }
// 						
// 						
						// $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='SIGNUP BAR'");
						// $email_temp = $email_template->row();
// 			
						// $email_address_from = $email_temp->from_address;
						// $email_address_reply = $email_temp->reply_address;
						// $email_subject = $email_temp->subject;
						// $email_message = $email_temp->message;
						// $email = $data['getbardata']['email'];
						// $user_name = $data['getbardata']['first_name']." ".$data['getbardata']['last_name'];
						// $email_to = $email;
						// $email_message = str_replace('{break}', '<br/>', $email_message);
						// $email_message = str_replace('{user_name}', $user_name, $email_message);
						// $email_message = str_replace('{email}', $email, $email_message);
						// $email_message = str_replace('{password}', $pass, $email_message);
						// $email_message = str_replace('{activation_link}', $conf, $email_message);
					    // $str = $email_message;
						// email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
// 						
// 						
						// $uid = base64_encode($uid);
						// $this->session->set_userdata(array('userid_sess' => $uid));
						
						
						redirect('home/registration_step4');
					}
					else {
							
						$slug=getBarSlug($data['getbardata']['bar_title']);	
						$bar_id = $this->session->userdata('viewid');
						$data['getbardata'] = $this->home_model->getBardataTemp($bar_id);
						$data['getbardatafeature'] = $this->home_model->getBardataTempFeature($bar_id);
						$pass = randomCode();
						$conf = rand('11111111','99999999');
						$data_insert['first_name'] = $data['getbardata']['first_name'] ;
						$data_insert['last_name'] = $data['getbardata']['last_name'] ;
						$data_insert['email'] = $data['getbardata']['email'];
						$data_insert['gender'] =$data['getbardata']['gender'];
						$data_insert['address'] = $data['getbardata']['address'];
						
						
						$data_insert['status'] = 'inactive';
						$data_insert['is_deleted'] = 'no';
						$data_insert['user_type'] = 'bar_owner';
						
						$data_insert['password'] = md5($pass);		
						$data_insert['confirm_code'] = $conf;		
						$data_insert['sign_up_ip'] = $_SERVER['REMOTE_ADDR'];
						$data_insert['sign_up_date'] = date('Y-m-d H:i:s');		
						$this->db->insert('user_master',$data_insert);		
						$uid = mysql_insert_id();
						$data['user_id'] = $uid;
				// 		
				
				         if($this->session->userdata('viewid_orig')!='' && $this->session->userdata('viewid_orig')!=0)
						{
							
							$data_insert_new['bar_title'] = $data['getbardata']['bar_title'] ;
							$data_insert_new['owner_name'] = $data['getbardata']['first_name']." ".$data['getbardata']['last_name'];
							$data_insert_new['email'] = $data['getbardata']['email'];
							$data_insert_new['owner_id'] = $uid;
							$data_insert_new['address'] =$data['getbardata']['address'];
							$data_insert_new['bar_desc'] = nl2br($data['getbardata']['desc']);
							$data_insert_new['city'] = $data['getbardata']['city'];
							$data_insert_new['bar_type'] = 'half_mug';
							$data_insert_new['owner_type'] = 'bar_owner';
							$data_insert_new['bar_slug'] = $slug;
							$data_insert_new['state'] = $data['getbardata']['state'];
							$data_insert_new['zipcode'] = $data['getbardata']['zip'];
							$data_insert_new['status'] = 'inactive';
							$data_insert_new['bar_meta_title'] = $data['getbardata']['bar_meta_title'];
							$data_insert_new['bar_meta_keyword'] =$data['getbardata']['bar_meta_keyword'];
							$data_insert_new['date_added'] = date('Y-m-d H:i:s');	
							$data_insert_new['bar_meta_description'] = $data['getbardata']['bar_meta_description'];
							$this->db->where('bar_id',$this->session->userdata('viewid_orig'));
							
							$this->db->update('bars',$data_insert_new);	
							$bar_id = $this->session->userdata('viewid_orig');
							
							$data['one_user'] = $this->home_model->get_availability($bar_id);
							
							
							
							/*--------- E-mail To Super Admin ----*/
							
							$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Claim Bar'");
							$email_temp = $email_template->row();
					
							$email_address_from = $email_temp->from_address;
							$email_address_reply = $email_temp->reply_address;
					
							$email_subject = $email_temp->subject;
							$email_message = $email_temp->message;
					
							$email = getsuperadminemail();
					
							$barname = ucwords($data['getbardata']['bar_title']);
							$type = 'Half Mug';
							$username = ucwords($data['getbardata']['first_name'])." ".ucwords($data['getbardata']['last_name']);
							$email_to = $email;
					
							$email_message = str_replace('{break}', '<br/>', $email_message);
							$email_message = str_replace('{barname}', $barname, $email_message);
							$email_message = str_replace('{type}', $type, $email_message);
							$email_message = str_replace('{username}', $username, $email_message);
						    $str = $email_message;
							$getemail = explode(',', $email);
				
				foreach($getemail as $r){
					email_send($email_address_from, $email_address_reply, $r, $email_subject, $str);
				}
							//email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
	
							
							/*--------- E-mail To Super Admin ----*/
							
				if($data['one_user']){
				foreach($data['one_user']  as $os){
					
					if($os->start_from!='')
					{
						$f = $os->start_from;
					}
					else {
						$f = '';
					}
					if($os->start_to!='')
					{
						$t = $os->start_to;
					}
					else {
						$t = '';
					}
					if($os->is_closed!='')
					{
						$c = $os->is_closed;
					}
					else {
						$c = '';
					}
			 	$ava_arr = array("bar_id"=>$bar_id1,
				                   "days_id" => $os->days_id,
				                   "start_from"=>$f,
								   "start_to"=>$t,
								   "is_closed"=>$c,
								   "date_added"=>date("Y-m-d H:i:s")
							);
				$this->db->insert("bar_hours",$ava_arr);   
				}
								}
						}
						 else
						{
							
							$data_insert_new['bar_title'] = $data['getbardata']['bar_title'] ;
							$data_insert_new['owner_name'] = $data['getbardata']['first_name']." ".$data['getbardata']['last_name'];
							$data_insert_new['email'] = $data['getbardata']['email'];
							$data_insert_new['owner_id'] = $uid;
							$data_insert_new['address'] =$data['getbardata']['address'];
							$data_insert_new['bar_desc'] = nl2br($data['getbardata']['desc']);
							$data_insert_new['city'] = $data['getbardata']['city'];
							$data_insert_new['bar_type'] = 'half_mug';
							$data_insert_new['owner_type'] = 'bar_owner';
							$data_insert_new['bar_slug'] = $slug;
							$data_insert_new['state'] = $data['getbardata']['state'];
							$data_insert_new['zipcode'] = $data['getbardata']['zip'];
							$data_insert_new['date_added'] = date('Y-m-d H:i:s');
							
							$data_insert_new['status'] = 'inactive';
							$data_insert_new['bar_meta_title'] = $data['getbardata']['bar_meta_title'];
							$data_insert_new['bar_meta_keyword'] =$data['getbardata']['bar_meta_keyword'];
							$data_insert_new['bar_meta_description'] = $data['getbardata']['bar_meta_description'];
							$this->db->insert('bars',$data_insert_new);		
							$bar_id1 = mysql_insert_id();
							
							$data['one_user'] = $this->home_model->get_availability($bar_id);
							
							
				if($data['one_user']){
				foreach($data['one_user']  as $os){
					
					if($os->start_from!='')
					{
						$f = $os->start_from;
					}
					else {
						$f = '';
					}
					if($os->start_to!='')
					{
						$t = $os->start_to;
					}
					else {
						$t = '';
					}
					if($os->is_closed!='')
					{
						$c = $os->is_closed;
					}
					else {
						$c = '';
					}
			 	$ava_arr = array("bar_id"=>$bar_id1,
				                   "days_id" => $os->days_id,
				                   "start_from"=>$f,
								   "start_to"=>$t,
								   "is_closed"=>$c,
								   "date_added"=>date("Y-m-d H:i:s")
							);
				$this->db->insert("bar_hours",$ava_arr);   
				}
								}
						} 	
							$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='SIGNUP BAR'");
						$email_temp = $email_template->row();
			
						$email_address_from = $email_temp->from_address;
						$email_address_reply = $email_temp->reply_address;
						$email_subject = $email_temp->subject;
						$email_message = $email_temp->message;
						$email = $data['getbardata']['email'];
						$user_name = $data['getbardata']['first_name']." ".$data['getbardata']['last_name'];
			        	//$activation_link = "<a href='".base_url()."home/activation/".$data_pass."'>here</a>";
						$email_to = $email;
						$email_message = str_replace('{break}', '<br/>', $email_message);
						$email_message = str_replace('{user_name}', $user_name, $email_message);
						//$email_message = str_replace('{email}', $email, $email_message);
						//$email_message = str_replace('{password}', $pass, $email_message);
						$email_message = str_replace('{activation_link}', $conf, $email_message);
					    $str = $email_message;
						email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
						
						$getfull = gethalmugfeature('fullmug');
						
						
						$getrecord = '';
						 $i=1;foreach($getfull as $sct)    
				       {
				        	
							$getrecord .=  $i.") ".ucwords($sct->fullmug)."<br>";
						$i++;}
						
	
		
						$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Reminding Of Full Mug Features'");
						$email_temp = $email_template->row();
			
						$email_address_from = $email_temp->from_address;
						$email_address_reply = $email_temp->reply_address;
						$email_subject = $email_temp->subject;
						$email_message = $email_temp->message;
						$email = $data['getbardata']['email'];
						$user_name = $data['getbardata']['first_name']." ".$data['getbardata']['last_name'];
			        	//$activation_link = "<a href='".base_url()."home/activation/".$data_pass."'>here</a>";
						$email_to = $email;
						$email_message = str_replace('{break}', '<br/>', $email_message);
						$email_message = str_replace('{username}', $user_name, $email_message);
						$email_message = str_replace('{featurelist}', $getrecord, $email_message);
						//$email_message = str_replace('{email}', $email, $email_message);
						//$email_message = str_replace('{password}', $pass, $email_message);
						//$email_message = str_replace('{activation_link}', $conf, $email_message);
					    $str = $email_message;
						
						
						email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
						
						
						$uid = base64_encode($uid);
						$this->session->set_userdata(array('userid_sess' => $uid));
						$this->session->unset_userdata('viewid_orig');
						$this->session->unset_userdata('viewid');
					//	$bar_id = $this->session->userdata('viewid');
						
						redirect('home/registration_step5');
					}
		}
		
		$this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/registration_step3', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render();
		
		
	}

    function registration_step4()
	{
		$bar_id = $this->session->userdata('viewid');
		
		if($bar_id=='')
		{
			redirect ('home/bar_owner_register');
		}
		
		$res= '';

		$theme = getThemeName ();
		$data['error'] = '';
		$data['bar_id'] = $bar_id;
        $data["active_menu"]='';
        $data['site_setting'] = site_setting ();
		 $site_setting = site_setting ();
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$data['getbardata'] = $this->home_model->getBardataTemp($bar_id);
		$data['getbardatafeature'] = $this->home_model->getBardataTempFeature($bar_id);
		$count = 0;
		if($data['getbardatafeature'])
		{
			$count = $data['getbardatafeature']['feature_id'];
			//$count = count(explode(',',$count));
		}
		
		$this->load->library ('form_validation');
		$this->form_validation->set_rules('cc_type','Credit Card Type','required');
		$this->form_validation->set_rules('card_number','Card Number','required');
		$this->form_validation->set_rules('ex_month','Month','required');
		$this->form_validation->set_rules('ex_year','Year','required');
		$this->form_validation->set_rules('cvv','Cvv','required');

		if ($_POST) { 
			if ($this->form_validation->run ()== FALSE) {
				if (validation_errors ()) {
					$data["error"] = validation_errors ();
				} else {
					$data["error"] = "";
				}
			} else {
				
				
		$card = new CreditCard();
			$type = strtolower($this->input->post('cc_type'));
			$number = strtolower($this->input->post('card_number'));
			$month = strtolower($this->input->post('ex_month'));
			$year = strtolower($this->input->post('ex_year'));
			$cvv_number = strtolower($this->input->post('cvv'));
			
			$card->setType($type)
			->setNumber($number)
			->setExpireMonth($month)
			->setExpireYear($year)
			->setCvv2($cvv_number)
			->setFirstName('viral')
			->setLastName('jadav');

			$fi = new FundingInstrument();
			$fi->setCreditCard($card);

			$payer = new Payer();
			$payer->setPaymentMethod("credit_card")
    		->setFundingInstruments(array($fi));

			$amount = new Amount();
			$amount->setCurrency("USD")
					->setTotal($site_setting->amount);

		$transaction = new Transaction();
		$transaction->setAmount($amount)
			    	->setDescription("Payment description");

		$payment = new Payment();
		$payment->setIntent("sale")
   				->setPayer($payer)
    		    ->setTransactions(array($transaction));


// ### Create Payment
// Create a payment by calling the payment->create() method
// with a valid ApiContext (See bootstrap.php for more on `ApiContext`)
// The return object contains the state.
try {
   $res = $payment->create($this->apiContext);
} catch (Exception $ex) {
	
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
 	//ResultPrinter::printError('Create Payment Using Credit Card. If 500 Exception, try creating a new Credit Card using <a href="https://ppmts.custhelp.com/app/answers/detail/a_id/750">Step 4, on this link</a>, and using it.', 'Payment', null, $request, $ex);
 	$data["error"]='Payment Fail Please Enter Proper Credit Card Information.';
   // exit(1);
}

// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
 //ResultPrinter::printResult('Create Payment Using Credit Card', 'Payment', $payment->getId(), $request, $payment);
 
 
 
			// echo "<pre>";
			// print_r($res);
	    	// echo $res->getId(); 
// 			
// 			
			// die;
		
		//echo "getout";
		//	die;
		if($res=="")
		    {
		    	$data["error"]='Payment Fail Please Enter Proper Credit Card Information.';
				//echo 'in';die;
			}
		 elseif($res->state!="approved" )
		 
		 {
		 	$data["error"]='<p>Payment Fail</p>';
		 }else{
		    	
		$slug=getBarSlug($data['getbardata']['bar_title']);	
		$bar_id = $this->session->userdata('viewid');
		$data['getbardata'] = $this->home_model->getBardataTemp($bar_id);
		$data['getbardatafeature'] = $this->home_model->getBardataTempFeature($bar_id);
		$pass = randomCode();
		$conf = rand('11111111','99999999');
		$data_insert['first_name'] = $data['getbardata']['first_name'] ;
		$data_insert['last_name'] = $data['getbardata']['last_name'] ;
		$data_insert['email'] = $data['getbardata']['email'];
		$data_insert['gender'] =$data['getbardata']['gender'];
		$data_insert['address'] = $data['getbardata']['address'];
		$data_insert['status'] = 'inactive';
		$data_insert['is_deleted'] = 'no';
		$data_insert['user_type'] = 'bar_owner';
		$data_insert['password'] = md5($pass);		
		$data_insert['confirm_code'] = $conf;		
		$data_insert['sign_up_ip'] = $_SERVER['REMOTE_ADDR'];
		$data_insert['sign_up_date'] = date('Y-m-d H:i:s');	
		$data_insert['expire_date'] = date('Y-m-d', strtotime("+30 days"));
		$data_insert['credit_card_id'] = $res->getId();
		$this->db->insert('user_master',$data_insert);		
		$uid = mysql_insert_id();
		$data['user_id'] = $uid;
		
		
		if($this->session->userdata('viewid_orig')!='' && $this->session->userdata('viewid_orig')!=0)
		{
			
				$data_insert_new['bar_title'] = $data['getbardata']['bar_title'] ;
				$data_insert_new['owner_name'] = $data['getbardata']['first_name']." ".$data['getbardata']['last_name'];
				$data_insert_new['email'] = $data['getbardata']['email'];
				$data_insert_new['owner_id'] = $uid;
				$data_insert_new['address'] =$data['getbardata']['address'];
				$data_insert_new['bar_desc'] = nl2br($data['getbardata']['desc']);
				$data_insert_new['city'] = $data['getbardata']['city'];
				$data_insert_new['bar_type'] = 'full_mug';
				$data_insert_new['bar_slug'] = $slug;
				$data_insert_new['owner_type'] = 'bar_owner';
				$data_insert_new['status'] = 'inactive';
				$data_insert_new['state'] = $data['getbardata']['state'];
				$data_insert_new['zipcode'] = $data['getbardata']['zip'];
				$data_insert_new['bar_meta_title'] = $data['getbardata']['bar_meta_title'];
				$data_insert_new['bar_meta_keyword'] =$data['getbardata']['bar_meta_keyword'];
				$data_insert_new['date_added'] =date('Y-m-d h:i:s');
				$data_insert_new['bar_meta_description'] = $data['getbardata']['bar_meta_description'];
				$this->db->where('bar_id',$this->session->userdata('viewid_orig'));
				$this->db->update('bars',$data_insert_new);	
				$bar_id = $this->session->userdata('viewid_orig');
				
				$data['one_user'] = $this->home_model->get_availability($bar_id);
				/*--------- E-mail To Super Admin ----*/
							
							$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Claim Bar'");
							$email_temp = $email_template->row();
					
							$email_address_from = $email_temp->from_address;
							$email_address_reply = $email_temp->reply_address;
					
							$email_subject = $email_temp->subject;
							$email_message = $email_temp->message;
					
							$email = getsuperadminemail();
					
							$barname = ucwords($data['getbardata']['bar_title']);
							$type = 'Full Mug';
							$username = ucwords($data['getbardata']['first_name'])." ".ucwords($data['getbardata']['last_name']);
							$email_to = $email;
					
							$email_message = str_replace('{break}', '<br/>', $email_message);
							$email_message = str_replace('{barname}', $barname, $email_message);
							$email_message = str_replace('{type}', $type, $email_message);
							$email_message = str_replace('{username}', $username, $email_message);
						    $str = $email_message;
							$getemail = explode(',', $email);
				
				foreach($getemail as $r){
					email_send($email_address_from, $email_address_reply, $r, $email_subject, $str);
				}
							//email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
	
							
							/*--------- E-mail To Super Admin ----*/			
							
				if($data['one_user']){
				foreach($data['one_user']  as $os){
					
					if($os->start_from!='')
					{
						$f = $os->start_from;
					}
					else {
						$f = '';
					}
					if($os->start_to!='')
					{
						$t = $os->start_to;
					}
					else {
						$t = '';
					}
					if($os->is_closed!='')
					{
						$c = $os->is_closed;
					}
					else {
						$c = '';
					}
			 	$ava_arr = array("bar_id"=>$bar_id1,
				                   "days_id" => $os->days_id,
				                   "start_from"=>$f,
								   "start_to"=>$t,
								   "is_closed"=>$c,
								   "date_added"=>date("Y-m-d H:i:s")
							);
				$this->db->insert("bar_hours",$ava_arr);   
				}
								}
				
				
		}
		else 
		{
			
			
				$data_insert_new['bar_title'] = $data['getbardata']['bar_title'] ;
				$data_insert_new['owner_name'] = $data['getbardata']['first_name']." ".$data['getbardata']['last_name'];
				$data_insert_new['email'] = $data['getbardata']['email'];
				$data_insert_new['owner_id'] = $uid;
				$data_insert_new['address'] =$data['getbardata']['address'];
				$data_insert_new['bar_desc'] = nl2br($data['getbardata']['desc']);
				$data_insert_new['city'] = $data['getbardata']['city'];
				$data_insert_new['bar_type'] = 'full_mug';
				$data_insert_new['bar_slug'] = $slug;
				$data_insert_new['owner_type'] = 'bar_owner';
				$data_insert_new['status'] = 'inactive';
				$data_insert_new['state'] = $data['getbardata']['state'];
				$data_insert_new['zipcode'] = $data['getbardata']['zip'];
				$data_insert_new['date_added'] =date('Y-m-d h:i:s');
				$data_insert_new['bar_meta_title'] = $data['getbardata']['bar_meta_title'];
				$data_insert_new['bar_meta_keyword'] =$data['getbardata']['bar_meta_keyword'];
				$data_insert_new['bar_meta_description'] = $data['getbardata']['bar_meta_description'];
				
				
				$this->db->insert('bars',$data_insert_new);		
				$bar_id1 = mysql_insert_id();
				$data['one_user'] = $this->home_model->get_availability($bar_id);
					
				if($data['one_user']){
				foreach($data['one_user']  as $os){
					
					if($os->start_from!='')
					{
						$f = $os->start_from;
					}
					else {
						$f = '';
					}
					if($os->start_to!='')
					{
						$t = $os->start_to;
					}
					else {
						$t = '';
					}
					if($os->is_closed!='')
					{
						$c = $os->is_closed;
					}
					else {
						$c = '';
					}
			 	$ava_arr = array("bar_id"=>$bar_id1,
				                   "days_id" => $os->days_id,
				                   "start_from"=>$f,
								   "start_to"=>$t,
								   "is_closed"=>$c,
								   "date_added"=>date("Y-m-d H:i:s")
							);
				$this->db->insert("bar_hours",$ava_arr);   
				}
								}
		 }
			$transar=array('txn_id'=> $res->getId(),'user_id'=>$uid,'price'=>$site_setting->amount,'transaction_date'=>date('Y-m-d H:i:s'),'is_deleted'=>'no');
		    $this->db->insert('transaction',$transar);				
						
			$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='SIGNUP BAR'");
			$email_temp = $email_template->row();
			$email_address_from = $email_temp->from_address;
			$email_address_reply = $email_temp->reply_address;
			$email_subject = $email_temp->subject;
			$email_message = $email_temp->message;
			$email = $data['getbardata']['email'];
			$user_name = $data['getbardata']['first_name']." ".$data['getbardata']['last_name'];
			$email_to = $email;
			$email_message = str_replace('{break}', '<br/>', $email_message);
			$email_message = str_replace('{user_name}', $user_name, $email_message);
			//$email_message = str_replace('{email}', $email, $email_message);
			//$email_message = str_replace('{password}', $pass, $email_message);
			$email_message = str_replace('{activation_link}', $conf, $email_message);
		    $str = $email_message;
			email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
			$uid = base64_encode($uid);
		
			
			
  			$this->session->set_userdata(array('userid_sess' => $uid));
			$this->session->unset_userdata('viewid_orig');
			$this->session->unset_userdata('viewid');
  			redirect('home/registration_step5');
		
		
		//die;
	}
				
			}
		}
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		$this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/registration_step4', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render();
	}

    function registration_step4_upgrade()
	{
		$bar_id = $this->session->userdata('viewid');
	
		if($bar_id=='')
		{
			redirect ('home/bar_owner_register');
		}
		
		$res= '';

		$theme = getThemeName ();
		$data['error'] = '';
		$data['bar_id'] = $bar_id;
        $data["active_menu"]='';
        $data['site_setting'] = site_setting ();
		 $site_setting = site_setting ();
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$data['getbardata'] = $this->home_model->getBardata($bar_id);
		$data['getbardatafeature'] = $this->home_model->getBardataTempFeature($bar_id);
		
		$getuserinfo = get_user_info(get_authenticateUserID());
		
		$count = 4;
		if($data['getbardatafeature'])
		{
			$count = $data['getbardatafeature']['feature_id'];
			$count = count(explode(',',$count));
		}
		
		$this->load->library ('form_validation');
		$this->form_validation->set_rules('cc_type','Credit Card Type','required');
		$this->form_validation->set_rules('card_number','Card Number','required');
		$this->form_validation->set_rules('ex_month','Month','required');
		$this->form_validation->set_rules('ex_year','Year','required');
		$this->form_validation->set_rules('cvv','Cvv','required');

		if ($_POST) { 
			if ($this->form_validation->run ()== FALSE) {
				if (validation_errors ()) {
					$data["error"] = validation_errors ();
				} else {
					$data["error"] = "";
				}
			} else {
				
			$card = new CreditCard();
			$type = strtolower($this->input->post('cc_type'));
			$number = strtolower($this->input->post('card_number'));
			$month = strtolower($this->input->post('ex_month'));
			$year = strtolower($this->input->post('ex_year'));
			$cvv_number = strtolower($this->input->post('cvv'));
			
			$card->setType($type)
			->setNumber($number)
			->setExpireMonth($month)
			->setExpireYear($year)
			->setCvv2($cvv_number)
			->setFirstName($getuserinfo->first_name)
			->setLastName($getuserinfo->last_name);
			
			
		try {
		
	
		$card_data = $card->create($this->apiContext);
	 	$card = $card_data;
		$creditCardToken = new CreditCardToken();
		
		$creditCardToken->setCreditCardId($card->getId());
		$fi = new FundingInstrument();
		$fi->setCreditCardToken($creditCardToken);
		
		$payer = new Payer();
		$payer->setPaymentMethod("credit_card")
			->setFundingInstruments(array($fi));
		
         
		$amount = new Amount();
		$amount->setCurrency("USD")
			->setTotal($site_setting->amount);
			
		 // $amount->setCurrency("USD")
		// ->setTotal('0.01');
			//->setDetails($details);
		
		$transaction = new Transaction();
		$transaction->setAmount($amount)
			    	->setDescription("Payment description");
					//->setItemList($itemList)
			
		$payment = new Payment();
		$payment->setIntent("sale")
			->setPayer($payer)
			->setTransactions(array($transaction));
			
			
			try {
				
			$res = $payment->create($this->apiContext);
			// print_r($res);
			// die;
			/*
			 *	transaction_id = $res->id will look like "PAY-4YW24830U2864994WKM6UZ4Q"
			 */
		} catch (PayPal\Exception\PPConnectionException $ex) {
			//var_dump($ex->getData());	
			//exit(1);
			//echo "catch";
			//die;
			$data["error"] = "Please Enter proper credit card details.";
			//var_dump($ex->getData());	
			//exit(1);
			//die;
		}
		
			} catch (PayPal\Exception\PPConnectionException $ex) {
			$data["error"] = "Please Enter proper credit card details.";
				//var_dump($ex->getData());
				//exit(1);
				//die;
			}
		//	echo "<pre>";
		//	print_r($res);
	    //	echo $card->getId(); 
		//	die;
		
		//echo "getout";
		//	die;
		if($res=="")
		    {
		    	$data["error"]='Payment Fail Please Enter Proper Credit Card Information.';
				//echo 'in';die;
			}
		 elseif($res->state!="approved" )
		 
		 {
		 	$data["error"]='<p>Payment Fail</p>';
		 }else{
		 	    
				$data_insert_new = array('bar_type'=>'full_mug');
				$this->db->where('owner_id',get_authenticateUserID());
				$this->db->update('bars',$data_insert_new);	
				
				$data_insert['flag'] = 0;
				$data_insert['expire_date'] = date('Y-m-d', strtotime("+30 days"));
				$data_insert['credit_card_id'] = $card->getId();
				$this->db->where('user_id',get_authenticateUserID());
				$this->db->update('user_master',$data_insert);	
						
						
			$transar=array('txn_id'=>$res->id,'user_id'=>get_authenticateUserID(),'price'=>$site_setting->amount,'transaction_date'=>date('Y-m-d H:i:s'),'is_deleted'=>'no');
		    $this->db->insert('transaction',$transar);
			
			
			
			$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Notification Email Profile Upgrade From Half Mug To Full Mug'");
			$email_temp = $email_template->row();
			$email_address_from = $email_temp->from_address;
			$email_address_reply = $email_temp->reply_address;
			$email_subject = $email_temp->subject;
			$email_message = $email_temp->message;
			$email = getsuperadminemail();
			$email_to = $email;
			$email_message = str_replace('{break}', '<br/>', $email_message);
			$email_message = str_replace('{username}', ucwords($getuserinfo->first_name." ".$getuserinfo->last_name), $email_message);
			$email_message = str_replace('{barname}', $data['getbardata']['bar_title'], $email_message);
			$email_subject = str_replace('{barname}', $data['getbardata']['bar_title'], $email_subject);
			$str = $email_message;
			//email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
			$getemail = explode(',', $email);
				
				foreach($getemail as $r){
					email_send($email_address_from, $email_address_reply, $r, $email_subject, $str);
				}
					
  			//$this->session->set_userdata(array('userid_sess' => $uid));
  			
  			
  			$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Profile Upgrade Successfully'");
			$email_temp = $email_template->row();
			$email_address_from = $email_temp->from_address;
			$email_address_reply = $email_temp->reply_address;
			$email_subject = $email_temp->subject;
			$email_message = $email_temp->message;
			$email = $getuserinfo->email;
			$email_to = $email;
			$email_message = str_replace('{break}', '<br/>', $email_message);
			$email_message = str_replace('{username}', ucwords($getuserinfo->first_name." ".$getuserinfo->last_name), $email_message);
			$email_message = str_replace('{barname}', $data['getbardata']['bar_title'], $email_message);
			$email_subject = str_replace('{barname}', $data['getbardata']['bar_title'], $email_subject);
			$str = $email_message;
			email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
				
			$this->session->unset_userdata('viewid_orig');
			$this->session->unset_userdata('viewid');
  			redirect('home/success_page/'.base64_encode(get_authenticateUserID()));
		
		
		//die;
	}
				
			}
		}
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		$this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/registration_step4_upgrade', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render();
	}
    function registration_step5()
	{
		
		$this->session->unset_userdata('viewid');
		$uid = $this->session->userdata('userid_sess');
		if($uid=='')
		{
			redirect ('home/bar_owner_register');
		}
		

		$theme = getThemeName ();
		$data['error'] = '';
		//$data['bar_id'] = $bar_id;
		$data['user_id'] = base64_decode($uid);
        $data["active_menu"]='';
        $data['site_setting'] = site_setting ();
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		$this->load->library ('form_validation');
        $data['get_user_info'] = get_user_info($data['user_id']);
		$this->form_validation->set_rules('code','Code','required');

		if ($_POST) { 
			if ($this->form_validation->run ()== FALSE) {
				if (validation_errors ()) {
					$data["error"] = validation_errors ();
				} else {
					$data["error"] = "";
				}
			} else {
				$user_id = $this->home_model->checkcode();
				
				if($user_id!="" && $user_id['confirm_code']!='')
				{
					 $pass  = randomCode();
					$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Successfully Registration'");
					$email_temp = $email_template->row();
					$email_address_from = $email_temp->from_address;
					$email_address_reply = $email_temp->reply_address;
					$email_subject = $email_temp->subject;
					$email_message = $email_temp->message;
					$email = $data['get_user_info']->email;
					$user_name = $data['get_user_info']->first_name." ".$data['get_user_info']->last_name;
					$email_to = $email;
					$email_message = str_replace('{break}', '<br/>', $email_message);
					$email_message = str_replace('{user_name}', $user_name, $email_message);
					$email_message = str_replace('{email}', $email, $email_message);
					$email_message = str_replace('{password}', $pass, $email_message);
					$str = $email_message;
					
					email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
						
					$data_up = array('status'=>"active",'confirm_code'=>'','password'=>md5($pass));
					$this->db->where('user_id',$this->input->post('user_id'));
					$this->db->update('user_master',$data_up);
					
					$data_up12 = array('status'=>"active");
					$this->db->where('taxi_owner_id',$this->input->post('user_id'));
					$this->db->update('taxi_directory',$data_up12);
					
					$data_up1 = array('status'=>"active");
					$this->db->where('owner_id',$this->input->post('user_id'));
					$this->db->update('bars',$data_up1);
					$this->session->unset_userdata('userid_sess');
					
					
					redirect('home/success_page/'.base64_encode($this->input->post('user_id')));
				}
				// elseif($user_id['confirm_code']=='') {
					// $this->session->unset_userdata('userid_sess');
					// redirect('home/index/reg_link_expire');
// 					
				// }
				else {
					$data["error"] = "<p>Please Enter Correct Confirmation Code .</p>";
				}
				
			}
		}
		
		$this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/confirm', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render();
			
			
			//return $uid;
	}

    function success_page($uid='')
	{
			
        if($uid=='')
		{
			redirect('home');
		}
		$theme = getThemeName ();
		$data['error'] = '';
		//$data['msg'] = $msg;
		
		$data['user_info'] = get_user_info(base64_decode($uid));
		if($data['user_info']=='')
		{
			redirect('home');
		}
        $data['site_setting'] = site_setting ();
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		
		$this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/confirmpage', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render();
	}

   
	function bartitle_check($title)
	{
		$username = $this->home_model->bar_title_unique($title);
		if($username == FALSE)
		{
			$this->form_validation->set_message('bartitle_check', 'There is an existing Bar associated with this Title');
			return FALSE;
		}
		return TRUE;
	}
   function forgetpassword_ajax()
	{
		$theme = getThemeName();
		$data['error']='';
		$data["msg"]='';
		$data['active_menu']='';
		$this->template->set_master_template($theme .'/template.php');
		
		$meta_setting    = meta_setting();
		$pageTitle       = $meta_setting->title;
	  	$metaDescription = $meta_setting->meta_description;
		
		$metaKeyword=$meta_setting->meta_keyword;
		$this->template->write('pageTitle',$pageTitle,TRUE);
		$this->template->write('metaDescription',$metaDescription,TRUE);
		$this->template->write('metaKeyword',$metaKeyword,TRUE);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		if($this->form_validation->run() == FALSE)
		{
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			$data["email"] = $this->input->post('email');
		}
		else
		{
			$message = $this->home_model->user_forgot_password($this->input->post('email'),$this->input->post('type'));

			if($message=="success")
			{
				$data['msg'] = 	"success";			
			}
			else if($message=="inactive")
			{
				$data['error']="<p>Your account is Inactive. Please, Contact to your Administrator.</p>";
			}
			else if($message=="suspend")
			{
				$data['error']="<p>Your account is Suspended. Please, Contact to your Administrator.</p>";
			}
			else
			{
				$data['error']="<p>Email Address Not Found.</p>";
			}

		}

       echo json_encode($data);
			exit;
		// $this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		// $this->template->write_view('content_center',$theme .'/layout/common/forget_password',$data,TRUE);
		// $this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		// $this->template->render();
	}
     function login_ajax($msg="")
	{
		$this->load->helper('cookie');
		$data["email"] = get_cookie('email');
		$data["password"] = get_cookie('password');
		$data["remember_me"] = get_cookie('remember_me');
		$data['active_menu']='';
		$theme = getThemeName();

		$data['error']='';
		$data["msg"]=$msg;

		$this->template->set_master_template($theme .'/template.php');

		$meta_setting    = meta_setting();
        
		$pageTitle       = 'Login - '.$meta_setting->title;
	  	$metaDescription = $meta_setting->meta_description;
		$metaKeyword=$meta_setting->meta_keyword;
		$this->template->write('pageTitle',$pageTitle,TRUE);
		$this->template->write('metaDescription',$metaDescription,TRUE);
		$this->template->write('metaKeyword',$metaKeyword,TRUE);

		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');

		//$data["account_type"]='';

		if($this->form_validation->run() == FALSE)
		{
			if(validation_errors())
			{
				 $data["error"] = validation_errors();
				
			}else{
				$data["error"] = "";
			}
			//echo $data["password"];die;
			if($_POST){
				$data["email"] = $this->input->post('email');
				$data["password"] = $this->input->post('password');
				$data["remember_me"] = $this->input->post('remember_me');
			}
		}
		else
		{
			
			
			$this->load->helper('cookie');
			$login =$this->home_model->check_login(trim($this->input->post ('email')), trim($this->input->post ('password')), $this->input->post ('remember_me'),$this->input->post('type'));

			if($login == '1')
			{
				
			
					$REDIRECT_URL = $this->session->userdata("REDIRECT_PAGE");
					$this->session->unset_userdata("REDIRECT_PAGE");
					
					
					if($REDIRECT_URL != "")
					{
						$data['redirectpage'] = $this->session->unset_userdata("REDIRECT_PAGE");
					}
					$data['msg'] = "success";
					$data['user_type'] = $this->session->userdata("user_type");
					
					
					
					if($this->session->userdata("user_type")=='bar_owner')
					{
						$data['redirectpage'] =  'home/dashboard';  
					}
					else {
						$data['redirectpage'] =  'home';  
					}
					 
				
			}
			else if($login == '0')
			{
				
				$data['error'] = INACTIVE_ACCOUNT;
			}
			else if($login == '2')
			{
				
				$data['error'] = 'Invalid User Type';
			}
			else
			{
				 $data["error"] = "Invalid Username Or Password.";
			}
			
			//echo json_encode($data);
			//exit;
		}
		echo json_encode($data);
			exit;
	}
	/** user activation function
	 * @return null
	 * author: sanjay Amin
	 */
	function activation ($code) {
		
		$user_type = '';
		$org_code = base64_decode ($code);
		$org_code_arr = explode ("1@1", $org_code);
		$uid = $org_code_arr[0];
		$code_org = $org_code_arr[1];
		
		if(isset($org_code_arr[2]))
		{
			$user_type = $org_code_arr[2];
		}
  
        $check = $this->home_model->check_user_activation ($uid, $code_org);
		
		if ($check== 1) {
			$msg = base64_encode ("activate");
		} else {

			$msg = base64_encode ("expired");
		}
		
      	redirect ("home/index/".$msg);
	}

	/** logout function
	 * @return null
	 * author: Thais
	 */
	function logout () {
		
		if(get_authenticateUserID()!='' && $this->session->userdata('login_history_id')!=""){
		 	
		 $usl=array(
				'logout_date_time'=>date('Y-m-d H:i:s'),
				'login_status'=>'offline'
				);
			$this->db->where('login_id',$this->session->userdata('login_history_id'));
			$this->db->update('user_login',$usl);	
		}
		
		$this->session->sess_destroy ();
		redirect ("home");
	}
	
	/** email_check function
	 * check unique email
	 * @return booloean
	 * author: Thais
	 */
	function email_check($email){
		
		$email = $this->home_model->email_unique($email);
		if($email == FALSE){
			$this->form_validation->set_message('email_check','There is an existing record with this Email Address');
			return FALSE;
		}
		return TRUE;
	}
	
	function email_check_taxiuser($email){
		
		$email = $this->home_model->email_unique($email,'taxi_owner');
		if($email == FALSE){
			$this->form_validation->set_message('email_check_taxiuser','There is an existing record with this Email Address');
			return FALSE;
		}
		return TRUE;
	}
	
	function email_check_baruser($email){
		
		$email = $this->home_model->email_unique($email,'bar_owner');
		if($email == FALSE){
			$this->form_validation->set_message('email_check_baruser','There is an existing record with this Email Address');
			return FALSE;
		}
		return TRUE;
	}
	
	function email_check_enthuser($email){
		
		$email = $this->home_model->email_unique($email,'user');
		if($email == FALSE){
			$this->form_validation->set_message('email_check_enthuser','There is an existing record with this Email Address');
			return FALSE;
		}
		return TRUE;
	}
	function username_check($name)
	{
		$username = $this->home_model->register_unique($name);
		if($username == FALSE)
		{
			$this->form_validation->set_message('username_check', 'There is an existing record with this User Name');
			return FALSE;
		}
		return TRUE;
	}
	
	

	/** function : forget paassword
 	*  author : Pokatalk
 	*/
  	function forget_password($type='')
	{
		$type = base64_decode($type);
		if (check_user_authentication() != '')
		{
			redirect('home');
		}

		$theme = getThemeName();

		$data['error'] = '';
		$data["msg"] = '';
        $data["active_menu"]='';
		$this->template->set_master_template($theme . '/template.php');

		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$pageTitle = 'forget_password';
	    $metaDescription = '';
		$metaKeyword = '';
        $data['site_setting'] = site_setting ();
		
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		

		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

		if ($_POST)
		{
			if ($this->form_validation->run() == FALSE)
			{
				if (validation_errors())
				{
					$data["error"] = validation_errors();
				} else
				{
					$data["error"] = "";
				}
				$data["email"] = $this->input->post('email');

			} else
			{
			    
                

				$message = $this->home_model->user_forgot_password($this->input->post('email'));

				if ($message == "success")
				{
					$msg = base64_encode("forget");
					$email_encode = base64_encode($this->input->post('email'));
					if($type!="doctor")
					{redirect('home/login/' . $msg.'/'.$email_encode);}
					else{redirect('home/professional_login/' . $msg.'/'.$email_encode);}
					
				} else
					if ($message == "inactive")
					{
						$data['error'] = INACTIVE_ACCOUNT;
					} else
						if ($message == "suspend")
						{
							$data['error'] = ACCOUNT_SUSPEND;
						} else
						{
							$data['error'] = EMAIL_NOT_FOUND;
						}

			}
		}
        $data["type"] = $type;
		$this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/common/forget_password', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render();

	}

    /** function : reset_password
	 * author : Pokatalk
	 * 
	 */
	function reset_password($id = 0, $msg = '')
	{		
		$uid = base64_decode($id);
		$type = '';
	    
	    $check_forgot_password = $this->home_model->check_forgot_passwordflag($uid,$type);

		if ($check_forgot_password == 0)
		{
			redirect("home/login/".base64_encode('set'));
			 
		}
		$theme = getThemeName();

		$data['error'] = '';
		$data["msg"] = '';
        $data["active_menu"]='';
        $data['site_setting'] = site_setting ();
		$this->template->set_master_template($theme . '/template.php');

		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		
		$this->template->write('pageTitle', $pageTitle, TRUE);
		$this->template->write('metaDescription', $metaDescription, TRUE);
		$this->template->write('metaKeyword', $metaKeyword, TRUE);

		$this->load->library('form_validation');
	//	$this->form_validation->set_rules('new_password', 'New Password', 'required');
        $this->form_validation->set_rules ('rpassword', 'New Password', 'required|min_length[8]|max_length[12]');
		$this->form_validation->set_rules('confirm_password', 'confirm New Password', 'required');

		if ($_POST)
		{        
			if ($this->form_validation->run() == FALSE)
			{
				$data["error"] = '';
				
				if (validation_errors())
				{
					$data["error"] .= validation_errors();
				} else
				{
					
					$data["error"] .= "";
				}

				$data["rpassword"] = $this->input->post('rpassword');
				$data["confirm_pssword"] = $this->input->post('confirm_pssword');

			}
			else
			{
				$message = $this->home_model->reset_password($this->input->post("rpassword"), $uid,$type);				
				if($message == "1")
				{
					$msg = base64_encode("reset");
					redirect('home/index/'. $msg);
					/*
					if($type=='doctor')
					{
						redirect('home/login/' . $msg);
					}
					else {
						redirect('home/login/' . $msg);
					}*/					
				}
			}
		}
		$data["msg"] = $msg;
		$data["user_id"] = $uid;
		$data["type"] = $type;
		
		$this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/common/reset_password', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render();
	}
	
    function page($slug='') {
         
        if($slug == '')
        {
            redirect('home');
        }
        
        $data = array();
        $site_setting = site_setting();
        $data['site_setting']=$site_setting;
        $data['active_menu']=$slug;
        
        $result = get_page_info($slug);
        if(!$result)
        {
            redirect('home');
        }
        
        $data['result'] = $result;
        
        $theme = getThemeName();
        $page_detail=meta_setting();
        $pageTitle=$result->pages_title;
        $metaDescription=$result->meta_description;
        $metaKeyword=$result->meta_keyword;
        $this -> template -> set_master_template($theme . '/template.php');
        $this->template->write ('pageTitle', $pageTitle, TRUE);
        $this->template->write ('metaDescription', $metaDescription, TRUE);
        $this->template->write ('metaKeyword', $metaKeyword, TRUE);
        
        if(get_authenticateUserID() > 0)
        {
          $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        }
        else
        {
            $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        }
        $this->template->write_view ('content_center', $theme.'/common/page', $data, TRUE);
        $this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
        $this -> template -> render();
    }



    /*Function : FAQ
     * Display all faq from admin side*/
    function faq($keyword = "1v1") {
    
       
        $data = array();
        $theme = getThemeName ();
        $this->template->set_master_template ($theme.'/template.php');
        
        $page_detail=meta_setting();
        $pageTitle=$page_detail->title;
        $metaDescription=$page_detail->meta_description;
        $metaKeyword=$page_detail->meta_keyword;

        $data["site_setting"] = site_setting ();
        $data["active_menu"]='faq';
		
		if($_POST)
		{
			$keyword = $this->input->post("keyword");
		}
		
        $data["all_faq"] = $this->home_model->get_all_faq ($keyword);
		$data["keyword"] = $keyword;
        
        $this->template->write ('pageTitle', $pageTitle, TRUE);
        $this->template->write ('metaDescription', $metaDescription, TRUE);
        $this->template->write ('metaKeyword', $metaKeyword, TRUE);

         if(get_authenticateUserID() > 0)
        {
          $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        }
        else
        {
            $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        }
        $this->template->write_view ('content_center', $theme.'/home/faq', $data, TRUE);
        $this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
        $this->template->render ();
    }
    
    /*Function : FAQ
     * Display all faq from admin side*/
    function contactus($msg='') {
    
       
        $data = array();
        $theme = getThemeName ();
        $this->template->set_master_template ($theme.'/template.php');
        
        $page_detail=meta_setting();
        $pageTitle=$page_detail->title;
        $metaDescription=$page_detail->meta_description;
        $metaKeyword=$page_detail->meta_keyword;

        $data["site_setting"] = site_setting ();
        $data["active_menu"]='contactus';
        $data["error"] = "";
        $data["msg"] = $msg;
		$data["site_setting"] = site_setting();
        $this->load->library ('form_validation');
        
        $this->form_validation->set_rules ('name', 'nom', 'required');
        $this->form_validation->set_rules ('last_name', 'Prenom', 'required');
        $this->form_validation->set_rules ('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules ('subject', 'Sujet', 'required');
        $this->form_validation->set_rules ('message', 'Message', 'required');
        
        
        
        
        if($_POST){
            if ($this->form_validation->run ()== FALSE) {
                if (validation_errors ()) {
                    $data["error"] = validation_errors();
                    $data['name']=$this->input->post('name');
                    $data['last_name']=$this->input->post('last_name');
                    $data['email']=$this->input->post('email');
                    $data['subject']=$this->input->post('subject');
                    $data['message']=$this->input->post('message');
                } else {
                    $data["error"] = "";
                    $data['name']='';
                    $data['last_name']="";
                    $data['email']='';
                    $data['subject']='';
                    $data['message']='';
                }

            } else {
                
                $name = $this->input->post('name');
                $last_name = $this->input->post('last_name');
                $email = $this->input->post('email');
                $subject = $this->input->post('subject');
                $message = $this->input->post('message');
                $result = $this->home_model->insert_inquiry($name,$last_name,$email,$subject,$message);
                $msg="success";
                redirect ('contact-us/'.$msg);
            }
        }else
            {
                $data['name']='';
                $data['last_name']="";
                $data['email']='';
                $data['subject']='';
                $data['message']='Votre message';
                
            }
        
        
        $this->template->write ('pageTitle', $pageTitle, TRUE);
        $this->template->write ('metaDescription', $metaDescription, TRUE);
        $this->template->write ('metaKeyword', $metaKeyword, TRUE);

         if(get_authenticateUserID() > 0)
        {
          $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        }
        else
        {
            $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        }
        $this->template->write_view ('content_center', $theme.'/common/contactus', $data, TRUE);
        $this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
        $this->template->render ();
    }


     function add_contact()
	 {
	 	$name = $_REQUEST["name"];
		$last_name = $_REQUEST["name"];
		$email = $_REQUEST["email"];
		$subject = $_REQUEST["subject"];
		$message = $_REQUEST["message"];
		
	 	$this->home_model->insert_inquiry($name,$last_name,$email,$subject,$message);
		
		echo "Contact us inquiry send successfully.";
	 }
    /*
    * function : newsletter();
    * inseret news letter data 
    * author: Thais
    */
     function newsletter()
	 {
	 	$result = $this->home_model->insert_newsletter($_POST);
		$set=site_setting();
		$apikey =$set->mailchimp_apikey;
		$my_email =$this->input->post('email');
		// A List Id to run examples against. use lists() to view all
		// Also, login to MC account, go to List, then List Tools, and look for the List ID entry
		$listId = $set->newsletter_mailchimp_listid;
		
		$api = new MCAPI($apikey);
		$merge_vars = array('FNAME'=>$this->input->post('first_name'),
		                    'LNAME'=>$this->input->post('last_name'), 
		                   'INTERESTS'=>'');
		$retval = $api->listSubscribe( $listId, $my_email, $merge_vars );
		                    
		if ($api->errorCode){
			//$data['error'] ="Unable to load listSubscribe()!\n";
		    //  echo "\tCode=".$api->errorCode."\n";
		    // echo "\tMsg=".$api->errorMessage."\n";
	    } else {
	       //echo "Returned: ".$retval."\n";
	    }
		echo $result;
		
		die;
	 }
     
  
  ////////////////////facebook///////////////////////////////////////
 
	
  	function social_signup($social_data=array())
	{
		
		$data = array();
		$data['fb_img']='';
		ini_set('memory_limit',-1);
		ini_set('memory_size',-1);
		ini_set('max_execution_time',0);
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$site_setting=site_setting();
		$meta_setting=meta_setting();
		
		$pageTitle='Facebook Register for - '.$meta_setting->title;
		$metaDescription='Facebook Register for - '.$meta_setting->meta_description;
		$metaKeyword='Facebook Register for - '.$meta_setting->meta_keyword;
		
		
		
		
		if($social_data)
		{
			
			$data['first_name']= $social_data['first_name'];
			$data['last_name']= $social_data['last_name'];
			$data['email']= $social_data['email'];
			$data['password']= '';
			$data['fb_id']= $social_data['fb_id'];
			if(isset($social_data['fb_img']))$data['image']=$social_data['fb_img'];
			$data['gender']= $social_data['gender'];
			$data['birthday']= $social_data['birthday'];
			$data['verified'] = $social_data['verified'];
			$data["user_type"] = "user";
			$data["verify_email"] = "1";
		
			
		//	$password=randomCode();
		   $pass  = randomCode();
			//$password = $this->passwordhash->hash ($pass);
			$password =md5 ($pass);
			$data_user['first_name'] = $social_data['first_name'];
			$data_user['last_name'] = $social_data['last_name'];
			$data_user['email'] = $social_data['email'];
			$data_user['fb_id'] = $social_data['fb_id'];
			$data_user['status'] = "active";
			$data_user['gender'] = $social_data['gender'];
			$data_user['password'] = $password;
			$data_user["profile_image"] = $social_data['fb_img'];
			$data_user["user_type"] = "user";
			$data_user["verify_email"] = "1";
			//$data_user["right_upload"] = "no";
			
			if($social_data['birthday']!=''){
				if(explode('/',$social_data['birthday'])){
					$bdd = explode('/',$social_data['birthday']);
					$dob= $bdd[2].'-'.$bdd[0].'-'.$bdd[1];
				}
			}


           $data_user["birthdate"] = date("Y-m-d",strtotime($dob)) ;
			
	    	$this->db->insert('user_master',$data_user);
			$uid = mysql_insert_id();
			$data["user_id"] = $uid;
			
			$data = array(
						'user_id' => $uid,
						'fb_id' => $social_data['fb_id'],
						'email' => $social_data['email'],
						'username' => $social_data['first_name'],
						"user_type"=>"user",
					    // "right_upload" => "no",
					              
					           
						);	
			$this->session->set_userdata($data);

			//04/18/1990
			

			
			//$data["countrylist"]=get_all_country();	
			/*Mail Send*/
				$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='social sign up'");
				$email_temp=$email_template->row();				
			
				
				$email_address_from=$email_temp->from_address;
				$email_address_reply=$email_temp->reply_address;
				
				$email_subject=$email_temp->subject;				
				$email_message=$email_temp->message;
				
				$email =$social_data['email'];
				
				//$password = $this->input->post('password');
				$user_name = $social_data['first_name']." ".$social_data['last_name'];
				
				$email_to =$email;
				//$login_link= base_url().'home/activate/'.$uid."/".$confirm_code;
				$login_link= '<a href='.base_url().'home>Here</a>';
			
				$email_message=str_replace('{break}','<br/>',$email_message);
				$email_message=str_replace('{user_name}',$user_name,$email_message);
				$email_message=str_replace('{email}',$email,$email_message);
				$email_message=str_replace('{password}',$pass,$email_message);
				$email_message=str_replace('{login_link}',$login_link,$email_message);
				
				$str=$email_message;
	
				
				/** custom_helper email function **/
				//echo $str; die; 					
				email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
				
				redirect("user/myprofile");
			/*End mail send*/	
			
			
		   
		}
		else
		{
			redirect('home/socialfail');
			
		}
		
	}	
 
    function customersignup($msg= '')
	{	
		
		$site_setting = site_setting();	
		$theme = getThemeName();

		$data['error']='';
		$data["msg"]=$msg;
		$data['active_menu']='';

		$this->template->set_master_template($theme .'/template.php');

		
		$this->form_validation->set_rules('first_name','First Name','required');
		$this->form_validation->set_rules('last_name','Last Name','required');
		$this->form_validation->set_rules('nick_name','Bar Fly Nickname','required');
		$this->form_validation->set_rules('email','Email','required|callback_email_check_enthuser');
		$this->form_validation->set_rules('custpassword','Password','required|min_length[8]|callback_password_check');
		$this->form_validation->set_rules('confirm_password','Confirm Password','required');
		//$this->form_validation->set_rules('gender','Gender','required');
		//$this->form_validation->set_rules('mobile_no', 'Mobile No', 'required|numeric|min_length[9]|max_length[11]');
		// $this->form_validation->set_rules('question', 'Question', 'required|');
		// if($this->input->post('question')!="")
		// {
			// $this->form_validation->set_rules('answer', 'Answer', 'required|');
		// }
		//$this->form_validation->set_rules('month', 'Month','required|trim|callback_compareDates');
		
		$imagarr = '';
		if($_POST)
		{
			//echo '<pre>';
			//print_r($_FILES);die;
			
			$start = strtotime($this->input->post('year').'-'.$this->input->post('month').'-'.$this->input->post('day'));
			//$date = strtotime('2010-01-01 -21 year');
			//$end = strtotime(date('Y-m-d', $date));
	         
	         $dt = date('Y-m-d');
	         $end = strtotime($dt.'-21 year'); 
	         // echo $start.'<br>';
			 // echo $end.'<br>';
			
			if($start >= $end)
			{
	              $imagarr= 'Your age must be 21 years or above plese enter proper birth date.';
				
			}
			
		}	
			if($this->form_validation->run() == FALSE || $imagarr!='')
			{
				
				if(validation_errors()  || $imagarr!='')
				{
					$data["error"] = validation_errors().$imagarr;
				}else{
					$data["error"] = "";
				}
				if($_POST)
				{
					$data["first_name"] = $this->input->post('first_name');
					$data["last_name"] = $this->input->post('last_name');
					$data["email"] = $this->input->post('email');
					$data["nick_name"] = $this->input->post('nick_name');
					$data["custpassword"] = $this->input->post('custpassword');		
					$data["confirm_password"] = $this->input->post('confirm_password');
					//$data["phone_no"] = $this->input->post('phone_no');		
					//$data["mobile_no"] = $this->input->post('mobile_no');
					$data["number"] = $this->input->post('number');
					$data['msg']='notsuccess';
					// $data["question"] = $this->input->post('question');
					// $data["answer"] =$this->input->post('answer');
				}
			}
			else
			{
				
				$login =$this->home_model->insert_customer();
				$uid = mysql_insert_id();
				
				if($uid!="")
				{					
					$data['msg']='success';
				}
				else {
					$data['msg']='notsuccess';
				}
			
							
					
							
				
			}
			
			echo json_encode($data);
					exit;
		
	}
  /////////////// end of facebook//////////////////////////////////
  
   function compareDates()
	{
	$start = strtotime($this->input->post('year').'-'.$this->input->post('month').'-'.$this->input->post('day'));
	$end = strtotime(date('Y-m-d'));
	
	
	if($start < $end)
	{
	    $this->form_validation->set_message('compareDates','Your age must be 21 years or above plese enter proper birth date.');
	    return false;
	}
	}
    function test()
	{
           
       
        $data = array();
        $theme = getThemeName ();
        $this->template->set_master_template ($theme.'/template.php');
        
        $page_detail=meta_setting();
        $pageTitle=$page_detail->title;
        $metaDescription=$page_detail->meta_description;
        $metaKeyword=$page_detail->meta_keyword;

        $data["site_setting"] = site_setting ();
        $data["active_menu"]='contactus';
        $data["error"] = "";
		$data["site_setting"] = site_setting();
        
        
        $this->template->write ('pageTitle', $pageTitle, TRUE);
        $this->template->write ('metaDescription', $metaDescription, TRUE);
        $this->template->write ('metaKeyword', $metaKeyword, TRUE);
         //   $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        $this->template->write_view ('content_center', $theme.'/common/test', $data, TRUE);
        //$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
        $this->template->render ();
	} 
    
	function test_ajax()
	{
		$data = array();
        $theme = getThemeName ();
        $this->template->set_master_template ($theme.'/template.php');
        
        $page_detail=meta_setting();
        $pageTitle=$page_detail->title;
        $metaDescription=$page_detail->meta_description;
        $metaKeyword=$page_detail->meta_keyword;

        $data["site_setting"] = site_setting ();
        $data["active_menu"]='contactus';
        $data["error"] = "";
		$data["site_setting"] = site_setting();
        
        
        $this->template->write ('pageTitle', $pageTitle, TRUE);
        $this->template->write ('metaDescription', $metaDescription, TRUE);
        $this->template->write ('metaKeyword', $metaKeyword, TRUE);
         //   $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        $this->template->write_view ('content_center', $theme.'/common/test123', $data, TRUE);
        //$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
        $this->template->render ();
	}
	function test_ajax123()
	{
		
       // $obj->name = "sadadad";
        //$obj->message = "Hello " . $obj->name;
         
        echo $_GET['callback']. '(' . json_encode("dsadsa") . ');';
	}
	
	function changepassword($msg='')
	{
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('oldpassword', 'Old Password', 'required|');
		$this->form_validation->set_rules('upassword', 'Password', 'required|');
		$this->form_validation->set_rules('cpassword', 'Confirm password', 'required|matches[upassword]');
		$data["msg"] = '';
		$data["error"] = '';
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			
			
			
		}else{
			
			$res=$this->home_model->updateUserPassword();
			if($res){
				//$data["msg"] = '';
				$data["msg"] = "success";
			 //redirect('home/dashboard/passwordUpdateSuccess');
			}else{
				$data["error"] = "<p>Please enter valid old password.</p>";
			}
		}
		
		if($data["error"] !="")
		{
			$response = array("comment_error"=>$data["error"],"status"=>"fail");
			echo json_encode($response);
		    die;
		}
		
		if($data["msg"] == "success")
		{
			$response = array("status"=>"success");
			echo json_encode($response);
		    die;
		}
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/changepassword', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
	}

	
    function upgrade($bar_id='')
	{
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		
		if($bar_id!="")
		{
			$bar_id = base64_decode($bar_id);
			$this->session->set_userdata(array('viewid' => $bar_id));
			$bar_id = $this->session->userdata('viewid');
			
		}
		elseif($this->session->userdata('viewid')!="") {
			$bar_id = $this->session->userdata('viewid');
			
		}
		
		
		$theme = getThemeName ();
		$data['error'] = '';
		$data['bar_id'] = $bar_id;
        $data["active_menu"]='';
        $data['site_setting'] = site_setting ();
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$data['getbardatafeature'] = $this->home_model->getBardataTempFeature($bar_id);
		$data['getbardata'] = $this->home_model->getBardata($bar_id);
		$data['one_user'] = $this->home_model->get_availability($bar_id);
		if($data['getbardatafeature']){
		$data['getbardatafeature_new'] = $data['getbardatafeature']['feature_id'];
		}
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		$this->load->library ('form_validation');

		$this->form_validation->set_rules('btype','Bar Type','required');

		if ($_POST) {
			 
			if ($this->form_validation->run ()== FALSE) {
				if (validation_errors ()) {
					$data["error"] = validation_errors ();
				} else {
					$data["error"] = "";
				}
			} else {
				if($this->input->post('bar_feature_id')=="")
				{
					$barid_new = $this->home_model->register_bar_owner_features();
					redirect('home/registration_step3_upgrade');
				}	
				else
				{
					$barid_new = $this->home_model->register_bar_owner_features_update();
					redirect('home/registration_step3_upgrade');
				}
				
			}
		}
		
		$this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/registration_step2_upgrade', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render();
	}

	function registration_step3_upgrade()
	{
		
		$bar_id = $this->session->userdata('viewid');
	 
		if($bar_id=='')
		{
			redirect ('home/bar_owner_register');
		}

		$theme = getThemeName ();
		$data['error'] = '';
		$data['bar_id'] = $bar_id;
        $data["active_menu"]='';
        $data['site_setting'] = site_setting ();
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		
		$data['getbardata'] = $this->home_model->getBardata($bar_id);
		
		$data['getbardatafeature'] = $this->home_model->getBardataTempFeature($bar_id);
		$count = 0;
		if($data['getbardatafeature'])
		{
		$count = $data['getbardatafeature']['feature_id'];
		}
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		$this->load->library ('form_validation');

		$this->form_validation->set_rules('btype','Free Listing Or Paid Listing','required');
        
		if ($_POST) { 
					
					//$barid_new = $this->home_model->register_bar_owner_features();
					if($count>0)
					{
					 	redirect('home/registration_step4_upgrade');
						//redirect('home/registration_step5');
						
						// $bar_id = $this->session->userdata('viewid');
						// $data['getbardata'] = $this->home_model->getBardataTemp($bar_id);
						// $data['getbardatafeature'] = $this->home_model->getBardataTempFeature($bar_id);
						// $pass = randomCode();
						// $conf = rand('11111111','99999999');
						// $data_insert['first_name'] = $data['getbardata']['first_name'] ;
						// $data_insert['last_name'] = $data['getbardata']['last_name'] ;
						// $data_insert['email'] = $data['getbardata']['email'];
						// $data_insert['gender'] =$data['getbardata']['gender'];
						// $data_insert['address'] = $data['getbardata']['address'];
						// $data_insert['status'] = 'inactive';
						// $data_insert['is_deleted'] = 'no';
						// $data_insert['user_type'] = 'bar_owner';
// 						
						// $data_insert['password'] = md5($pass);		
						// $data_insert['confirm_code'] = $conf;		
						// $data_insert['sign_up_ip'] = $_SERVER['REMOTE_ADDR'];
						// $data_insert['sign_up_date'] = date('Y-m-d H:i:s');		
						// $this->db->insert('user_master',$data_insert);		
						// $uid = mysql_insert_id();
						// $data['user_id'] = $uid;
				// // 		
						// $data_insert_new['bar_title'] = $data['getbardata']['bar_title'] ;
						// $data_insert_new['owner_name'] = $data['getbardata']['first_name']." ".$data['getbardata']['last_name'];
						// $data_insert_new['email'] = $data['getbardata']['email'];
						// $data_insert_new['owner_id'] = $uid;
						// $data_insert_new['address'] =$data['getbardata']['address'];
						// $data_insert_new['bar_desc'] = nl2br($data['getbardata']['desc']);
						// $data_insert_new['city'] = $data['getbardata']['city'];
						// $data_insert_new['bar_type'] = 'full_mug';
						// $data_insert_new['owner_type'] = 'bar_owner';
// 						
// 						
						// $data_insert_new['state'] = $data['getbardata']['state'];
						// $data_insert_new['zipcode'] = $data['getbardata']['zip'];
						// $this->db->insert('bars',$data_insert_new);		
						// $bar_id = mysql_insert_id();
// 						
							// $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='SIGNUP BAR'");
						// $email_temp = $email_template->row();
// 			
						// $email_address_from = $email_temp->from_address;
						// $email_address_reply = $email_temp->reply_address;
						// $email_subject = $email_temp->subject;
						// $email_message = $email_temp->message;
						// $email = $data['getbardata']['email'];
						// $user_name = $data['getbardata']['first_name']." ".$data['getbardata']['last_name'];
			        	// //$activation_link = "<a href='".base_url()."home/activation/".$data_pass."'>here</a>";
						// $email_to = $email;
						// $email_message = str_replace('{break}', '<br/>', $email_message);
						// $email_message = str_replace('{user_name}', $user_name, $email_message);
						// $email_message = str_replace('{email}', $email, $email_message);
						// $email_message = str_replace('{password}', $pass, $email_message);
						// $email_message = str_replace('{activation_link}', $conf, $email_message);
					    // $str = $email_message;
						// email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
// 						
// 						
						// $uid = base64_encode($uid);
						// $this->session->set_userdata(array('userid_sess' => $uid));
						
					//	$bar_id = $this->session->userdata('viewid');
						
						//redirect('home/success_page/'.base64_encode(get_authenticateUserID()));
						//redirect('home/registration_step5');
					}
					else {
							$data_up = array('bar_type'=>"half_mug");
					$this->db->where('bar_id',$bar_id);
					$this->db->update('bars',$data_up);
					$this->session->unset_userdata('viewid');
						// $bar_id = $this->session->userdata('viewid');
						// $data['getbardata'] = $this->home_model->getBardataTemp($bar_id);
						// $data['getbardatafeature'] = $this->home_model->getBardataTempFeature($bar_id);
						// $pass = randomCode();
						// $conf = rand('11111111','99999999');
						// $data_insert['first_name'] = $data['getbardata']['first_name'] ;
						// $data_insert['last_name'] = $data['getbardata']['last_name'] ;
						// $data_insert['email'] = $data['getbardata']['email'];
						// $data_insert['gender'] =$data['getbardata']['gender'];
						// $data_insert['address'] = $data['getbardata']['address'];
						// $data_insert['status'] = 'inactive';
						// $data_insert['is_deleted'] = 'no';
						// $data_insert['user_type'] = 'bar_owner';
// 						
						// $data_insert['password'] = md5($pass);		
						// $data_insert['confirm_code'] = $conf;		
						// $data_insert['sign_up_ip'] = $_SERVER['REMOTE_ADDR'];
						// $data_insert['sign_up_date'] = date('Y-m-d H:i:s');		
						// $this->db->insert('user_master',$data_insert);		
						// $uid = mysql_insert_id();
						// $data['user_id'] = $uid;
				// // 		
						// $data_insert_new['bar_title'] = $data['getbardata']['bar_title'] ;
						// $data_insert_new['owner_name'] = $data['getbardata']['first_name']." ".$data['getbardata']['last_name'];
						// $data_insert_new['email'] = $data['getbardata']['email'];
						// $data_insert_new['owner_id'] = $uid;
						// $data_insert_new['address'] =$data['getbardata']['address'];
						// $data_insert_new['bar_desc'] = nl2br($data['getbardata']['desc']);
						// $data_insert_new['city'] = $data['getbardata']['city'];
						// $data_insert_new['bar_type'] = 'half_mug';
						// $data_insert_new['owner_type'] = 'bar_owner';
						// $data_insert_new['state'] = $data['getbardata']['state'];
						// $data_insert_new['zipcode'] = $data['getbardata']['zip'];
						// $this->db->insert('bars',$data_insert_new);		
						// $bar_id = mysql_insert_id();
// 						
							// $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='SIGNUP BAR'");
						// $email_temp = $email_template->row();
// 			
						// $email_address_from = $email_temp->from_address;
						// $email_address_reply = $email_temp->reply_address;
						// $email_subject = $email_temp->subject;
						// $email_message = $email_temp->message;
						// $email = $data['getbardata']['email'];
						// $user_name = $data['getbardata']['first_name']." ".$data['getbardata']['last_name'];
			        	// //$activation_link = "<a href='".base_url()."home/activation/".$data_pass."'>here</a>";
						// $email_to = $email;
						// $email_message = str_replace('{break}', '<br/>', $email_message);
						// $email_message = str_replace('{user_name}', $user_name, $email_message);
						// $email_message = str_replace('{email}', $email, $email_message);
						// $email_message = str_replace('{password}', $pass, $email_message);
						// $email_message = str_replace('{activation_link}', $conf, $email_message);
					    // $str = $email_message;
						// email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
// 						
						// $uid = base64_encode($uid);
						// $this->session->set_userdata(array('userid_sess' => $uid));
					// //	$bar_id = $this->session->userdata('viewid');
						
							redirect('home/success_page/'.base64_encode(get_authenticateUserID()));
					}
		}
		
		
		$this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/registration_step3_upgrade', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render();
		
		
	}

	function registration_step5_upgrade()
	{
			
		
			
			//return $bar_id;
		//	$bar_id = 	$this->session->unset_userdata('viewid');
		//	$data['getbardata'] = $this->home_model->getBardataTemp($bar_id);
			
		
		$this->session->unset_userdata('viewid');
		$uid = $this->session->userdata('userid_sess');
		if($uid=='')
		{
			redirect ('home/bar_owner_register');
		}
		

		$theme = getThemeName ();
		$data['error'] = '';
		//$data['bar_id'] = $bar_id;
		$data['user_id'] = base64_decode($uid);
        $data["active_menu"]='';
        $data['site_setting'] = site_setting ();
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		$this->load->library ('form_validation');
        $data['get_user_info'] = get_user_info($data['user_id']);
		$this->form_validation->set_rules('code','Code','required');

		if ($_POST) { 
			if ($this->form_validation->run ()== FALSE) {
				if (validation_errors ()) {
					$data["error"] = validation_errors ();
				} else {
					$data["error"] = "";
				}
			} else {
				$user_id = $this->home_model->checkcode();
				
				if($user_id!="" && $user_id['confirm_code']!='')
				{
					$data_up = array('status'=>"active",'confirm_code'=>'','flag'=>'0');
					$this->db->where('user_id',$this->input->post('user_id'));
					$this->db->update('user_master',$data_up);
					
					// $data_up_owner = array('bar_type'=>"full_mug");
					// $this->db->where('owner_id',$this->input->post('user_id'));
					// $this->db->update('bars',$data_up_owner); 
					$this->session->unset_userdata('userid_sess');
					
					redirect('home/success_page/'.base64_encode($this->input->post('user_id')));
				}
				elseif($user_id['confirm_code']=='') {
					$this->session->unset_userdata('userid_sess');
					redirect('home/index/reg_link_expire');
					
				}
				else {
					$data["error"] = "<p>Please Enter Correct Confirmation Code .</p>";
				}
				
			}
		}
		
		$this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/confirm', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render();
			
			
			//return $uid;
	}

    function statistics()
	{
		$data = array();
        $theme = getThemeName ();
        $this->template->set_master_template ($theme.'/template.php');
        
        $page_detail=meta_setting();
        $pageTitle=$page_detail->title;
        $metaDescription=$page_detail->meta_description;
        $metaKeyword=$page_detail->meta_keyword;

        $data["site_setting"] = site_setting ();
        $data["active_menu"]='contactus';
        $data["error"] = "";
		$data["site_setting"] = site_setting();
        $this->load->helper('recaptchalib');
		$publickey = '6LcjQAoTAAAAAMeqHoabD3bRBJuuQciyIbnaZFkU';
		$privatekey = '6LcjQAoTAAAAAM1AR1k-_AtX0DVZ5r0II1GgUzPL';
		# the response from reCAPTCHA
		$resp = null;
		# the error code from reCAPTCHA, if any
		$error = null;
		$captcha_error='';
		
			$data['captcha_img']=recaptcha_get_html($publickey,$error);		
        $data['statistics'] = $this->home_model->getStatisticsData();
        $this->template->write ('pageTitle', $pageTitle, TRUE);
        $this->template->write ('metaDescription', $metaDescription, TRUE);
        $this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        $this->template->write_view ('content_center', $theme.'/home/statistics', $data, TRUE);
        $this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
        $this->template->render ();
	}

	function news($limit=4,$offset=0,$msg='')
	{
		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $data['getbar'] = $this->home_model->getnewslettercount();
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'home/news/'.$limit;
		$config["total_rows"] = $this->home_model->getnewslettercount();
		
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->home_model->getnewsletterresult($offset,$limit);
		$data['latest_mews'] = $this->home_model->latestmews($limit=2);
	
		//	$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='newsletterevent';
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/home/newsletterajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/newsletter', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
	}
    
	function getmorecomment()
	{
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
    	$data["bar_comment"] = $this->bar_model->getAllComments($_GET['bar_id'],$_GET['offset'],$_GET['limit']);
		echo $this->load->view($theme .'/bar/barcommentajaxscroll',$data,TRUE);
		die;
	}
	
	 function update_user_old()
   {
   	  $getUsers = $this->home_model->getAllUser();
	  $site_setting = site_setting();
	  if($getUsers)
	  {
	  	foreach($getUsers as $row)
		{
			
			if($row->credit_card_id !="" && $row->expire_date<date('Y-m-d'))
			{
		
					$usr_status=array('staus'=>'inactive');
					$this->db->where('user_id',$row->user_id);
					$this->db->update('user_master',$usr_status);
	                		
					$ccToken = new CreditCardToken();
					$ccToken->setCreditCardId($row->credit_card_id);	
					
					$fi = new FundingInstrument();
					$fi->setCreditCardToken($ccToken);
					
					$payer = new Payer();
					$payer->setPaymentMethod("credit_card");
					$payer->setFundingInstruments(array($fi));	
					
					// Specify the payment amount.
					$amount = new Amount();
					$amount->setCurrency("USD");
					$amount->setTotal($site_setting->amount);
					// ###Transaction
					// A transaction defines the contract of a
					// payment - what is the payment for and who
					// is fulfilling it. Transaction is created with
					// a `Payee` and `Amount` types
					$transaction = new Transaction();
					$transaction->setAmount($amount);
					//$transaction->setDescription($paymentDesc);
					
					$payment = new Payment();
					$payment->setIntent("sale");
					$payment->setPayer($payer);
					$payment->setTransactions(array($transaction));
					
					//$payment->create(getApiContext());
					try {
			//$res = $payment->create($this->apiContext);
			$payment->create(getApiContext());
			
			/*
			 *	transaction_id = $res->id will look like "PAY-4YW24830U2864994WKM6UZ4Q"
			 */
		} catch (PayPal\Exception\PPConnectionException $ex) {
			
		$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Payment Failure Email'");
		$email_temp=$email_template->row();				
		$email_address_from=$email_temp->from_address;
		$email_address_reply=$email_temp->reply_address;
		$email_subject=$email_temp->subject;				
		$email_message=$email_temp->message;
		$email = $row->email;
		$user_name = ucwords($row->first_name." ".$row->last_name);
		$email_to =$email;
		$link= anchor('home/update_creditcard_detail/'.$row->user_id,'home/update_creditcard_detail/'.$row->user_id,'target="_blank"');
		$email_message=str_replace('{break}','<br/>',$email_message);
		$email_message=str_replace('{user_name}',$user_name,$email_message);
		$email_message=str_replace('{break}','<br/>',$email_message);
		$email_message=str_replace('{link}',$link,$email_message);
		$str=$email_message;
		email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
		
		
		$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Payment Failure Email To Admin'");
		$email_temp=$email_template->row();				
		$email_address_from=$email_temp->from_address;
		$email_address_reply=$email_temp->reply_address;
		$email_subject=$email_temp->subject;				
		$email_message=$email_temp->message;
		$email = $email_temp->from_address;
		$user_name = ucwords($row->first_name." ".$row->last_name);
		$email_to =$email;
		$email_message=str_replace('{break}','<br/>',$email_message);
		$email_message=str_replace('{user_name}',$user_name,$email_message);
		$str=$email_message;
		email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
			//var_dump($ex->getData());	
			exit(1);
		}
					
					if($payment->state!="approved")
    {
    	//$data["error"]='<p>Payment Fail</p>';
		
		$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Payment Failure Email'");
		$email_temp=$email_template->row();				
		$email_address_from=$email_temp->from_address;
		$email_address_reply=$email_temp->reply_address;
		$email_subject=$email_temp->subject;				
		$email_message=$email_temp->message;
		$email = $row->email;
		$user_name = ucwords($row->first_name." ".$row->last_name);
		$email_to =$email;
		$link= anchor('home/update_creditcard_detail/'.$row->user_id,'home/update_creditcard_detail/'.$row->user_id,'target="_blank"');
		$email_message=str_replace('{break}','<br/>',$email_message);
		$email_message=str_replace('{user_name}',$user_name,$email_message);
		$email_message=str_replace('{break}','<br/>',$email_message);
		$email_message=str_replace('{link}',$link,$email_message);
		$str=$email_message;
		email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
		
		$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Payment Failure Email To Admin'");
		$email_temp=$email_template->row();				
		$email_address_from=$email_temp->from_address;
		$email_address_reply=$email_temp->reply_address;
		$email_subject=$email_temp->subject;				
		$email_message=$email_temp->message;
		$email = $email_temp->from_address;
		$user_name = ucwords($row->first_name." ".$row->last_name);
		$email_to =$email;
		$email_message=str_replace('{break}','<br/>',$email_message);
		$email_message=str_replace('{user_name}',$user_name,$email_message);
		$str=$email_message;
		email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
		//echo 'in';die;
	}else{
		    
			
		$expDate=date('Y-m-d', strtotime("+30 days"));
		
		$usr=array('expire_date'=>date('Y-m-d',strtotime($expDate)),'credit_card_id'=>$row->credit_card_id,'staus'=>'active');
		
		$this->db->where('user_id',$row->user_id);
		$this->db->update('user_master',$usr);
		/*  User Update  */
		/*  Insert Transaction  */
		$transar=array('txn_id'=>$payment->id,'user_id'=>$row->user_id,'price'=>$site_setting->amount,'transaction_date'=>date('Y-m-d'));
		$this->db->insert('transaction',$transar);	
		
		$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='User Account Update'");
		$email_temp=$email_template->row();				
		$email_address_from=$email_temp->from_address;
		$email_address_reply=$email_temp->reply_address;
		$email_subject=$email_temp->subject;				
		$email_message=$email_temp->message;
		$email = $row->email;
		$user_name = ucwords($row->first_name." ".$row->last_name);
		$email_to =$email;
		$email_message=str_replace('{break}','<br/>',$email_message);
		$email_message=str_replace('{user_name}',$user_name,$email_message);
		$email_message=str_replace('{break}','<br/>',$email_message);
		$str=$email_message;
		email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
			
			  
		
		
		//die;
	}
			}

		// else if($row->credit_card_id =="" && $row->expire_date<date('Y-m-d'))
			// {
// 				
// 		
		// $chargeAmount = "0";
		// $userplan = $row->user_plan;
		// $countAccounts = getTotalAccountsByuserID($row->user_id);
		// $data['reachMaxLimit']  = 0;
		// $total_account = "0";
		// if($countAccounts>=10 && $userplan==1 || $countAccounts>=20 && $userplan==2 || $countAccounts>=50 && $userplan==3 || $countAccounts>=100 && $userplan==4 || $countAccounts>=500 && $userplan==5)
		// {
			// $data['reachMaxLimit'] = 1;
			// if($userplan==1)
			// {
				// $chargeAmount = $row->plan_amt/10;
				// $total_account = $countAccounts-10;
			// }
			// elseif($userplan==2)
			// {
				// $chargeAmount = $row->plan_amt/20;
				// $total_account = $countAccounts-20;
			// }
			// elseif($userplan==3)
			// {
				// $chargeAmount = $row->plan_amt/50;
				// $total_account = $countAccounts-50;
			// }
			// elseif($userplan==4)
			// {
				// $chargeAmount = $row->plan_amt/100;
				// $total_account = $countAccounts-100;
			// }
			// elseif($userplan==5)
			// {
				// $chargeAmount = $row->plan_amt/500;
				// $total_account = $countAccounts-500;
			// }
// 			
		// }
				// if($total_account>0)
				// {
					// $total_amount = $row->plan_amt + $chargeAmount*$total_account;
				// }
				// else {
					// $total_amount = $row->plan_amt + $chargeAmount;
				// }
					// $usr_status=array('staus'=>4);
					// $this->db->where('user_id',$row->user_id);
					// $this->db->update('user_master',$usr_status);
// 	                		
// 			
		// $email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Payment Failure Email'");
		// $email_temp=$email_template->row();				
		// $email_address_from=$email_temp->from_address;
		// $email_address_reply=$email_temp->reply_address;
		// $email_subject=$email_temp->subject;				
		// $email_message=$email_temp->message;
		// $email = $row->email;
		// $user_name = ucwords($row->first_name." ".$row->last_name);
		// $email_to =$email;
		// $link= anchor('home/update_creditcard_detail/'.$row->user_id,'home/update_creditcard_detail/'.$row->user_id,'target="_blank"');
		// $email_message=str_replace('{break}','<br/>',$email_message);
		// $email_message=str_replace('{user_name}',$user_name,$email_message);
		// $email_message=str_replace('{break}','<br/>',$email_message);
		// $email_message=str_replace('{link}',$link,$email_message);
		// $str=$email_message;
		// email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
// 		
// 		
		// $email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Payment Failure Email To Admin'");
		// $email_temp=$email_template->row();				
		// $email_address_from=$email_temp->from_address;
		// $email_address_reply=$email_temp->reply_address;
		// $email_subject=$email_temp->subject;				
		// $email_message=$email_temp->message;
		// $email = $email_temp->from_address;
		// $user_name = ucwords($row->first_name." ".$row->last_name);
		// $email_to =$email;
		// $email_message=str_replace('{break}','<br/>',$email_message);
		// $email_message=str_replace('{user_name}',$user_name,$email_message);
		// $str=$email_message;
		// email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
			// }
		}
	  }
   }


    function update_user()
   {
   	  $getUsers = $this->home_model->getAllUser();
	  $site_setting = site_setting();
	  if($getUsers)
	  {
	  	foreach($getUsers as $row)
		{
			$date = date('Y-m-d', strtotime('+30 day', strtotime($row->expire_date)));
			if($row->credit_card_id !="" && $date < date('Y-m-d') && $row->flag==1)
			{
				$usr_status=array('bar_type'=>'half_mug');
				$this->db->where('owner_id',$row->user_id);
				$this->db->update('bars',$usr_status);
			}	
			
			if($row->credit_card_id !="" && $row->expire_date<date('Y-m-d') && $row->flag!=1)
			{
		
					$usr_status=array('flag'=>'1');
					$this->db->where('user_id',$row->user_id);
					$this->db->update('user_master',$usr_status);
	                		
					$ccToken = new CreditCardToken();
					$ccToken->setCreditCardId($row->credit_card_id);	
					
					$fi = new FundingInstrument();
					$fi->setCreditCardToken($ccToken);
					
					$payer = new Payer();
					$payer->setPaymentMethod("credit_card");
					$payer->setFundingInstruments(array($fi));	
					
					// Specify the payment amount.
					$amount = new Amount();
					$amount->setCurrency("USD");
					$amount->setTotal($site_setting->amount);
					
					$transaction = new Transaction();
					$transaction->setAmount($amount);
					//$transaction->setDescription($paymentDesc);
					
					$payment = new Payment();
					$payment->setIntent("sale");
					$payment->setPayer($payer);
					$payment->setTransactions(array($transaction));
					
					//$payment->create(getApiContext());
					try {
			//$res = $payment->create($this->apiContext);
			$payment->create(getApiContext());
			
			/*
			 *	transaction_id = $res->id will look like "PAY-4YW24830U2864994WKM6UZ4Q"
			 */
		} catch (PayPal\Exception\PPConnectionException $ex) {
			
		$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Payment Failure Email'");
		$email_temp=$email_template->row();				
		$email_address_from=$email_temp->from_address;
		$email_address_reply=$email_temp->reply_address;
		$email_subject=$email_temp->subject;				
		$email_message=$email_temp->message;
		$email = $row->email;
		$user_name = ucwords($row->first_name." ".$row->last_name);
		$email_to =$email;
		$link= anchor('home/update_creditcard_detail/'.$row->user_id,'home/update_creditcard_detail/'.$row->user_id,'target="_blank"');
		$email_message=str_replace('{break}','<br/>',$email_message);
		$email_message=str_replace('{user_name}',$user_name,$email_message);
		//$email_message=str_replace('{break}','<br/>',$email_message);
		$email_message=str_replace('{link}',$link,$email_message);
		$str=$email_message;
		email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
		
		
		$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Payment Failure Email To Admin'");
		$email_temp=$email_template->row();				
		$email_address_from=$email_temp->from_address;
		$email_address_reply=$email_temp->reply_address;
		$email_subject=$email_temp->subject;				
		$email_message=$email_temp->message;
		$email = $email_temp->from_address;
		$user_name = ucwords($row->first_name." ".$row->last_name);
		$email_to =getsuperadminemail();
		$email_message=str_replace('{break}','<br/>',$email_message);
		$email_message=str_replace('{user_name}',$user_name,$email_message);
		$str=$email_message;
			$getemail = explode(',', $email);
				
				foreach($getemail as $r){
					email_send($email_address_from, $email_address_reply, $r, $email_subject, $str);
				}
		//email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
			//var_dump($ex->getData());	
			//exit(1);
		}
					
					if($payment->state!="approved")
    {
    	//$data["error"]='<p>Payment Fail</p>';
		
		$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Payment Failure Email'");
		$email_temp=$email_template->row();				
		$email_address_from=$email_temp->from_address;
		$email_address_reply=$email_temp->reply_address;
		$email_subject=$email_temp->subject;				
		$email_message=$email_temp->message;
		$email = $row->email;
		$user_name = ucwords($row->first_name." ".$row->last_name);
		$email_to =$email;
		$link= anchor('home/update_creditcard_detail/'.$row->user_id,'home/update_creditcard_detail/'.$row->user_id,'target="_blank"');
		$email_message=str_replace('{break}','<br/>',$email_message);
		$email_message=str_replace('{user_name}',$user_name,$email_message);
		//$email_message=str_replace('{break}','<br/>',$email_message);
		$email_message=str_replace('{link}',$link,$email_message);
		$str=$email_message;
		email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
		
		
		$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Payment Failure Email To Admin'");
		$email_temp=$email_template->row();				
		$email_address_from=$email_temp->from_address;
		$email_address_reply=$email_temp->reply_address;
		$email_subject=$email_temp->subject;				
		$email_message=$email_temp->message;
		$email = $email_temp->from_address;
		$user_name = ucwords($row->first_name." ".$row->last_name);
		$email_to =getsuperadminemail();
		$email_message=str_replace('{break}','<br/>',$email_message);
		$email_message=str_replace('{user_name}',$user_name,$email_message);
		$str=$email_message;
			$getemail = explode(',', $email);
				
				foreach($getemail as $r){
					email_send($email_address_from, $email_address_reply, $r, $email_subject, $str);
				}
		
		// $email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Payment Failure Email To Admin'");
		// $email_temp=$email_template->row();				
		// $email_address_from=$email_temp->from_address;
		// $email_address_reply=$email_temp->reply_address;
		// $email_subject=$email_temp->subject;				
		// $email_message=$email_temp->message;
		// $email = $email_temp->from_address;
		// $user_name = ucwords($row->first_name." ".$row->last_name);
		// $email_to =$email;
		// $email_message=str_replace('{break}','<br/>',$email_message);
		// $email_message=str_replace('{user_name}',$user_name,$email_message);
		// $str=$email_message;
		// email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
		//echo 'in';die;
	}else{
		    
			
		$expDate=date('Y-m-d', strtotime("+30 days"));
		
		$usr=array('expire_date'=>date('Y-m-d',strtotime($expDate)),'credit_card_id'=>$row->credit_card_id,'flag'=>'0');
		
		$this->db->where('user_id',$row->user_id);
		$this->db->update('user_master',$usr);
		/*  User Update  */
		/*  Insert Transaction  */
		$transar=array('txn_id'=>$payment->id,'user_id'=>$row->user_id,'price'=>$site_setting->amount,'transaction_date'=>date('Y-m-d'));
		$this->db->insert('transaction',$transar);	
		
		$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='User Account Upgrade Notification To User'");
		$email_temp=$email_template->row();				
		$email_address_from=$email_temp->from_address;
		$email_address_reply=$email_temp->reply_address;
		$email_subject=$email_temp->subject;				
		$email_message=$email_temp->message;
		$email = $row->email;
		$user_name = ucwords($row->first_name." ".$row->last_name);
		$email_to =$email;
		$email_message=str_replace('{break}','<br/>',$email_message);
		$email_message=str_replace('{user_name}',$user_name,$email_message);
		$email_message=str_replace('{break}','<br/>',$email_message);
		$str=$email_message;
		email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
		
		$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='User Account Upgrade Notification To Admin'");
		$email_temp=$email_template->row();				
		$email_address_from=$email_temp->from_address;
		$email_address_reply=$email_temp->reply_address;
		$email_subject=$email_temp->subject;				
		$email_message=$email_temp->message;
		$email = getsuperadminemail();
		$user_name = ucwords($row->first_name." ".$row->last_name);
		$email_to =$email;
		$email_message=str_replace('{break}','<br/>',$email_message);
		$email_message=str_replace('{user_name}',$user_name,$email_message);
		$email_message=str_replace('{break}','<br/>',$email_message);
		$str=$email_message;
		//email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
			$getemail = explode(',', $email);
				
				foreach($getemail as $r){
					email_send($email_address_from, $email_address_reply, $r, $email_subject, $str);
				}
			
			  
		
		
		//die;
	}
			}

		
		}
	  }
   }
   
    function update_creditcard_detail($id="",$msg="")
   {
   
   	  
	  $site_setting = site_setting();
	  $theme = getThemeName();
	  $this->template->set_master_template($theme .'/template.php');
	  $data=array();
	  $data['error']='';
	  $data['id']=$id;
	  $res = "";
	  $user_info = get_user_info($id);
	  
	  if(!$user_info)
	  {
	  	redirect('home');
	  }
	  $data['email'] =  $user_info->email;
      $data['msg'] = $msg; //login fail message
      
      $this->form_validation->set_rules('cc_type','Credit Card Type', 'required');
	  $this->form_validation->set_rules('card_number','Credit Card Number', 'required');
	  $this->form_validation->set_rules('ex_month','Expire Month', 'required');
	  $this->form_validation->set_rules('ex_year','Expire Year', 'required');
	  $this->form_validation->set_rules('cvv', 'Cvv Number', 'required');
	  
	  if($this->form_validation->run() == FALSE)
		{
				if(validation_errors())
				{													
					$data["error"] = validation_errors();
				}
				else
				{		
					$data["error"] = "";							
				}
				if($_POST)
				{
				
					$data['cc_type']=$this->input->post('cc_type');
					$data['card_number']=$this->input->post('card_number');
					$data['ex_month']=$this->input->post('ex_month');
					$data['ex_year']=$this->input->post('ex_year');
					$data['cvv']=$this->input->post('cvv');
					$data['email']=$this->input->post('email');
				}
				else
				{
					$data['email']=$user_info->email;
				}
		}
        else
		{
				
			$card = new CreditCard();
			$type = strtolower($this->input->post('cc_type'));
			$number = strtolower($this->input->post('card_number'));
			$month = strtolower($this->input->post('ex_month'));
			$year = strtolower($this->input->post('ex_year'));
			$cvv_number = strtolower($this->input->post('cvv'));
			
			
			$card->setType($type)
			->setNumber($number)
			->setExpireMonth($month)
			->setExpireYear($year)
			->setCvv2($cvv_number)
			->setFirstName($user_info->first_name)
			->setLastName($user_info->last_name);
			
			
		try {
		$card_data = $card->create($this->apiContext);
	 	$card = $card_data;
		$creditCardToken = new CreditCardToken();
		$creditCardToken->setCreditCardId($card->getId());
		/* Store credit card end */
		/*
		 *	saved_card or token = $card->getId() will look like "CARD-2KU74474A0609264BKM6U2YA"
		 *	temporary store this value in database
		 *	To collect the payment this id will be used
		 */
		/* Make Payment */
		$fi = new FundingInstrument();
		$fi->setCreditCardToken($creditCardToken);
		
		$payer = new Payer();
		$payer->setPaymentMethod("credit_card")
			->setFundingInstruments(array($fi));
		
		$amount = new Amount();
		$amount->setCurrency("USD")
			->setTotal($site_setting->amount);
			//->setDetails($details);
		
		$transaction = new Transaction();
		$transaction->setAmount($amount)
			    	->setDescription("Payment description");
					//->setItemList($itemList)
			
		$payment = new Payment();
		$payment->setIntent("sale")
			->setPayer($payer)
			->setTransactions(array($transaction));

			//print_r($transaction);

			try {
			$res = $payment->create($this->apiContext);
			//pr($res);
			/*
			 *	transaction_id = $res->id will look like "PAY-4YW24830U2864994WKM6UZ4Q"
			 */
		} catch (PayPal\Exception\PPConnectionException $ex) {
			$data["error"] = "Please Enter proper credit card details.";
			//var_dump($ex->getData());	
			//exit(1);
		}
		
			} catch (PayPal\Exception\PPConnectionException $ex) {
		$data["error"] = "Please Enter proper credit card details.";
		//var_dump($ex->getData());
		//exit(1);
	}
		//	echo "<pre>";
		//	print_r($res);
		//echo $card->getId(); 
		//die;

 if($res=="")
    {
    	$data["error"]='<p>Payment Fail Please Enter Proper Credit Card Information.</p>';
		//echo 'in';die;
	}
 elseif($res->state!="approved" )
 
 {
 	$data["error"]='<p>Payment Fail</p>';
 }
	else{
		
		$expDate=date('Y-m-d', strtotime("+30 days"));
		
		$usr=array('expire_date'=>date('Y-m-d',strtotime($expDate)),'credit_card_id'=>$card->getId(),'staus'=>'active');
		
		$this->db->where('user_id',$user_info->user_id);
		$this->db->update('user_master',$usr);
		/*  User Update  */
		/*  Insert Transaction  */
		$transar=array('txn_id'=>$res->id,'user_id'=>$user_info->user_id,'amount'=>$site_setting->amount,'transaction_date'=>date('Y-m-d'));
		$this->db->insert('transaction',$transar);		
			//  $msg = "insert";
			//  redirect('home/index/successfully_registration');
			
			
		$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='User Account Update'");
		$email_temp=$email_template->row();				
		$email_address_from=$email_temp->from_address;
		$email_address_reply=$email_temp->reply_address;
		$email_subject=$email_temp->subject;				
		$email_message=$email_temp->message;
		$email = $user_info->email;
		$user_name = ucwords($user_info->first_name." ".$user_info->last_name);
		$email_to =$email;
		$email_message=str_replace('{break}','<br/>',$email_message);
		$email_message=str_replace('{user_name}',$user_name,$email_message);
		$email_message=str_replace('{break}','<br/>',$email_message);
		$str=$email_message;
		email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
		
		redirect('home/index/successfully_update_credit_card');
			
		
		
		//die;
	}	
	   }	
	
	 	$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/update_payment_account', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
   }
	
	function updatecard($msg="")
	{
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}		
		if($this->session->userdata('user_type')!='bar_owner')
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$data['page_name']="credit_card_update";
		 $data['msg'] = $msg; //login fail message
	  $this->form_validation->set_rules('cc_type','Credit Card Type', 'required');
	  $this->form_validation->set_rules('card_number','Credit Card Number', 'required');
	  $this->form_validation->set_rules('ex_month','Expire Month', 'required');
	  $this->form_validation->set_rules('ex_year','Expire Year', 'required');
	  $this->form_validation->set_rules('cvv', 'Cvv Number', 'required');
	  $data['error'] = '';
	   if($this->form_validation->run() == FALSE)
		{
				if(validation_errors())
				{													
					$data["error"] = validation_errors();
				}
				else
				{		
					$data["error"] = "";							
				}
					$data['cc_type']=$this->input->post('cc_type');
					$data['card_number']=$this->input->post('card_number');
					$data['ex_month']=$this->input->post('ex_month');
					$data['ex_year']=$this->input->post('ex_year');
					$data['cvv']=$this->input->post('cvv');
					$data['email']=$this->input->post('email');
		}
        else
		{
			    $card = new CreditCard();
		
			
			$type = strtolower($this->input->post('cc_type'));
			$number = strtolower($this->input->post('card_number'));
			$month = strtolower($this->input->post('ex_month'));
			$year = strtolower($this->input->post('ex_year'));
			$cvv_number = strtolower($this->input->post('cvv'));
			
			
			$card->setType($type)
			->setNumber($number)
			->setExpireMonth($month)
			->setExpireYear($year)
			->setCvv2($cvv_number);
			try {
				//$card->create($apiContext); 
				
				$card->create($this->apiContext);
		$usr=array('credit_card_id'=>$card->getId());
		
		$this->db->where('user_id',get_authenticateUserID());
		$this->db->update('user_master',$usr);
		$data["msg"] = "success";
		//redirect('home/updatecard/update_credit_card_successfully');
				
			} catch (PayPal\Exception\PPConnectionException $ex) {
				 $data["error"]="Please enter proper credit card information.";
			 }
		}
		
		if($data["error"] !="")
		{
			$response = array("comment_error"=>$data["error"],"status"=>"fail");
			echo json_encode($response);
		    die;
		}
		
		if($data["msg"] == "success")
		{
			$response = array("status"=>"success");
			echo json_encode($response);
		    die;
		}
		
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/updatecardinfo', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
	}

    function contact_us($msg='')
	{
	
	  $theme = getThemeName();
	  $this->template->set_master_template($theme .'/template.php');
	  $data['page_name']="credit_card_update";
	  $data['msg'] = $msg; //login fail message
	  $data['site_setting'] = site_setting();
	  $this->form_validation->set_rules('name','Name', 'required');
	  $this->form_validation->set_rules('email','Email', 'required|valid_email');
	  $this->form_validation->set_rules('subject','Subject', 'required');
	  $this->form_validation->set_rules('message','Message', 'required');
	  $data['error'] = '';
	  $this->load->helper('recaptchalib');
	  $publickey = '6LcjQAoTAAAAAMeqHoabD3bRBJuuQciyIbnaZFkU';
	  $privatekey = '6LcjQAoTAAAAAM1AR1k-_AtX0DVZ5r0II1GgUzPL';
	  $resp = null;
		# the error code from reCAPTCHA, if any
		$error = null;
		$captcha_error='';
		
		if (isset($_POST["recaptcha_response_field"]) && $_POST["recaptcha_response_field"]) {
		        $resp = recaptcha_check_answer ($privatekey,
		                                        $_SERVER["REMOTE_ADDR"],
		                                        $_POST["recaptcha_challenge_field"],
		                                        $_POST["recaptcha_response_field"]);
		
		        if ($resp->is_valid) {
		               // echo "You got it!";
		        } else {
		                # set the error code so that we can display it
		                $cerror = $resp->error;
						$captcha_error='<span> Please enter valid captcha code. </span>';
		        }
				
				//echo $cerror;die;
		}
		$data['captcha_img']=recaptcha_get_html($publickey,$error);		 
	   if($this->form_validation->run() == FALSE || $captcha_error!='')
		{
				if(validation_errors() || $captcha_error!='')
				{													
					$data["error"] = validation_errors().$captcha_error;
				}
				else
				{		
					$data["error"] = "";							
				}
					$data['name']=$this->input->post('name');
					$data['email']=$this->input->post('email');
					$data['subject']=$this->input->post('subject');
					$data['message']=$this->input->post('message');
		}
        else
		{
			    $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Contact Us'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = $data['site_setting']->site_email;
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{name}', $this->input->post('name'), $email_message);
				$email_message = str_replace('{email}', $this->input->post('email'), $email_message);
				$email_message = str_replace('{subject}', $this->input->post('subject'), $email_message);
				$email_message = str_replace('{message}', $this->input->post('message'), $email_message);
				$str = $email_message;
				
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
				$this->session->set_flashdata('msg','success');
				$msg = 'success';
				redirect('home/contact_us/'.$msg);
		}
		
		
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/contactus', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
	}

    function add_clcik()
	{
		// $getad = getadvertisementByIDSec($this->input->post('id'),'click');
// 		
		// if($getad==0)
		// {
			$getad = $this->geta($this->input->post('id'));
				
			//echo 	$getad['number_click'];
			$getad_newsec = getadvertisementByID_new(@$getad['advertisement_id'],'click');
			
			if(($getad_newsec<5 ||  $getad_newsec==0) && $getad['total_click'] < $getad['number_click'])
			{
				
			$array = array('ip'=>$_SERVER['REMOTE_ADDR'],'datetime'=>date('Y-m-d H:i:s'),'advertisement_id'=>$this->input->post('id'),'click_type'=>'click');
			$this->db->insert('count_clcik_advertisement',$array);
			
			$array1 = array('total_click'=>$getad['total_click']+1);
							$this->db->where('advertisement_id',$getad['advertisement_id']);
							$this->db->update('advertisement_master',$array1);
			}			
		//}
	}
	
	function geta($id){
		
			$this->db->select('*');
			$this->db->where('advertisement_id',$id);
			$query=$this->db->get('advertisement_master');
			if($query->num_rows()>0){
			return  $query->row_array();
		}else{
			return '';
		}
			
		
	}

     function taxi_owner_register($msg = '') {
     	
		if (check_user_authentication ()!= '') {
			redirect ('home');
		}

		$theme = getThemeName ();

		$data['error'] = '';
		$data['msg'] = $msg;
        $data["active_menu"]='';
        $data['site_setting'] = site_setting ();
       
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		$this->load->library ('form_validation');

		$this->form_validation->set_rules('email','Email','required|callback_email_check_taxiuser');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
	//	$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required');
 		//$this->form_validation->set_rules ('pass', 'Password', 'required|min_length[8]|max_length[12]|callback_password_check');
	//	$this->form_validation->set_rules('confpass', 'confirm Password', 'required');
		
		 $bar_id = $this->session->userdata('viewid');	
		
		if($bar_id!='')
		{
			$data['getbardata'] = $this->home_model->getBardataTemp($bar_id);
			$data['getbardatafeature'] = $this->home_model->getBardataTempFeature($bar_id);
			$data["email"] = $data['getbardata']['email'];
			$data["bar_title"] = $data['getbardata']['bar_title'];
			$data["first_name"] = $data['getbardata']['first_name'];
			$data["last_name"] = $data['getbardata']['last_name'];
			$data["address"] = $data['getbardata']['address'];
			$data["city"] = $data['getbardata']['city'];
			$data["state"] = $data['getbardata']['state'];
			$data["mobile_no"] = $data['getbardata']['mobile_no'];
			
			$data["zip"] = $data['getbardata']['zip'];
			$data["desc"] = $data['getbardata']['desc'];
			
			
		}
		if ($_POST) { 
			if ($this->form_validation->run ()== FALSE) {
				if (validation_errors ()) {
					$data["error"] = validation_errors ();
				} else {
					$data["error"] = "";
				}
				
			
				$data["email"] = $this->input->post ('email');
				$data["first_name"] = $this->input->post ('first_name');
				$data["last_name"] = $this->input->post ('last_name');
				$data["mobile_no"] = $this->input->post ('mobile_no');
			//	$data["pass"] = $this->input->post ('pass');
				$data["temp_id"] = $this->input->post ('temp_id');
			//	$data["confpass"] = $this->input->post ('confpass');
			} else {
				if($this->input->post('temp_id')=="")
				{
					$barid= $this->home_model->register_taxi_owner();
					redirect('home/taxi_owner_registration_step2/'.base64_encode($barid));
				}	
				else
				{
					$barid= $this->home_model->register_bar_owner_update();
					redirect('home/taxi_owner_registration_step2/'.base64_encode($this->input->post('temp_id')));
				}
				
			}
		}
		
		$this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/taxi_owner_register', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render();

	}	

	function taxi_owner_registration_step2($bar_id='')
	{
		
		
		if($bar_id!="")
		{
			$bar_id = base64_decode($bar_id);
			$this->session->set_userdata(array('viewid' => $bar_id));
			$bar_id = $this->session->userdata('viewid');
		}
		elseif($this->session->userdata('viewid')!="") {
			$bar_id = $this->session->userdata('viewid');
			
		}
		if($bar_id=='')
		{
			redirect ('home/taxi_owner_register');
		}

		$theme = getThemeName ();
		$data['error'] = '';
		$data['bar_id'] = $bar_id;
        $data["active_menu"]='';
        $data['site_setting'] = site_setting ();
		 $site_setting = site_setting ();
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$conf = rand('11111111','99999999');
		$data['getbardata'] = $this->home_model->getBardataTemp($bar_id);
			
		
		
		$this->load->library ('form_validation');
		$this->form_validation->set_rules('tax_company_name','Taxi Company Name','required');
		$this->form_validation->set_rules('tax_cmpn_address','Address','required');
		//$this->form_validation->set_rules('texi_company_phone_number','Phone Number','required');
		//$this->form_validation->set_rules('taxi_company_website','Taxi Company Website','required');
	//	$this->form_validation->set_rules('reciew','Review','required');
		$this->form_validation->set_rules('city','City','required');
		$this->form_validation->set_rules('state','State','required');
		$this->form_validation->set_rules('cmpn_zipcode','Zipcode','required|numeric');
		//$this->form_validation->set_rules('profile_image','Profile Image','required');

		if ($_POST) { 
			if ($this->form_validation->run ()== FALSE) {
				if (validation_errors ()) {
					$data["error"] = validation_errors ();
				} else {
					$data["error"] = "";
				}
			} else {
		
		$data_insert['first_name'] = $data['getbardata']['first_name'];
		$data_insert['last_name'] = $data['getbardata']['last_name'];
		$data_insert['mobile_no'] = $data['getbardata']['mobile_no'];
		$data_insert['email'] = $data['getbardata']['email'];
		$data_insert['password'] = md5($data['getbardata']['pass']);
		$data_insert1['taxi_company'] = $this->input->post('tax_company_name');
		$data_insert1['address'] = $this->input->post('tax_cmpn_address');
		$data_insert1['phone_number'] = $this->input->post('texi_company_phone_number');
		$data_insert1['cmpn_website'] = $this->input->post('taxi_company_website');
		$data_insert1['taxi_desc'] = $this->input->post('reciew');
		$data_insert1['city'] = $this->input->post('city');
		$data_insert1['state'] = $this->input->post('state');
		$data_insert1['cmpn_zipcode'] = $this->input->post('cmpn_zipcode');
		
		$data_insert['status'] = 'inactive';
		$data_insert1['status'] = 'inactive';
		$data_insert['is_deleted'] = 'no';
		$data_insert['user_type'] = 'taxi_owner';
		$data_insert['confirm_code'] = $conf;		
		$data_insert['sign_up_ip'] = $_SERVER['REMOTE_ADDR'];
		$data_insert['sign_up_date'] = date('Y-m-d H:i:s');	
		$data_insert1['date_added'] = date('Y-m-d H:i:s');	
		
		
		$bar_logo_img = '';
		 if($_FILES['profile_image']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['profile_image']['name'];
             $_FILES['userfile']['type']     =   $_FILES['profile_image']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['profile_image']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['profile_image']['error'];
             $_FILES['userfile']['size']     =   $_FILES['profile_image']['size'];
   
			$config['file_name'] = 'user_logo'.$rand;
			
            $config['upload_path'] = base_path().'upload/user_orig/';
			
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			
			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   
              $this->image_lib->clear();
		   	
			
					$gd_var='gd2';
				
				
		   if ($_FILES["profile_image"]["type"]!= "image/png" and $_FILES["profile_image"]["type"] != "image/x-png") {		  
			   	$gd_var='gd2';			
			}
			
					
		   if ($_FILES["profile_image"]["type"] != "image/gif") {		   
		    	$gd_var='gd2';
		   }	   
		   
		   if ($_FILES["profile_image"]["type"] != "image/jpeg" and $_FILES["profile_image"]["type"] != "image/pjpeg" ) {		   
		    	$gd_var='gd2';
		   }
		   
		   resize(base_path().'upload/user_orig/'.$picture['file_name'],base_path().'upload/user_thumb/'.$picture['file_name'],120,120);
			
			$bar_logo_img=$picture['file_name'];
			
		
			
			}

		$data_insert1['taxi_image'] = $bar_logo_img;
		$this->db->insert('user_master',$data_insert);		
		$uid = mysql_insert_id();
		$data_insert1['taxi_owner_id'] = $uid;
		$data['user_id'] = $uid;
		$this->db->insert('taxi_directory',$data_insert1);		
		
		
		$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='SIGNUP BAR'");
		$email_temp = $email_template->row();
		$email_address_from = $email_temp->from_address;
		$email_address_reply = $email_temp->reply_address;
		$email_subject = $email_temp->subject;
		$email_message = $email_temp->message;
		$email = $data['getbardata']['email'];
		$user_name = $data['getbardata']['first_name']." ".$data['getbardata']['last_name'];
		$email_to = $email;
		$email_message = str_replace('{break}', '<br/>', $email_message);
		$email_message = str_replace('{user_name}', $user_name, $email_message);
		//$email_message = str_replace('{email}', $email, $email_message);
		//$email_message = str_replace('{password}', $pass, $email_message);
		$email_message = str_replace('{activation_link}', $conf, $email_message);
		$str = $email_message;
		email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
		$uid = base64_encode($uid);
		
			$this->session->set_userdata(array('userid_sess' => $uid));
		redirect('home/registration_step5');
		
			}
		}
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		$this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/taxi_registration_step2', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render();
	
	}

   function suggest_advertise($msg='')
	{
		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        
		$data["bar_event"] = $this->bar_model->getBarEventGallery();
		$data["barpostcard"] = $this->bar_model->getBarPostcards();
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('type', 'Type', 'required');
		$this->form_validation->set_rules('text', 'Text', 'required');
		$this->form_validation->set_rules('remarks', 'Remarks', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('name', 'Contact Person name', 'required');
		$this->form_validation->set_rules('number', 'Number', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		
		if($this->form_validation->run() == FALSE)
			{			
				if(validation_errors())
				{
					$data["error"] = validation_errors();
				}else{
					$data["error"] = "";
				}
				
				$data["type"] = $this->input->post('type');
				$data["text"] = $this->input->post('text');
				$data["remarks"] = $this->input->post('remarks');
				$data["description"] = $this->input->post('description');
				$data["name"] = $this->input->post('name');
				$data["number"] = $this->input->post('number');
				$data["email"] = $this->input->post('email');
				
			}
		else
			{
				$this->home_model->insert_advertise();
				$this->session->set_flashdata('msg','success');
				$msg = 'success';
				
				$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Suggest Advertise'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = $data['site_setting']->site_email;
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{type}', $this->input->post('type'), $email_message);
				$email_message = str_replace('{text}', $this->input->post('text'), $email_message);
				$email_message = str_replace('{remarks}', $this->input->post('remarks'), $email_message);
				$email_message = str_replace('{description}', $this->input->post('description'), $email_message);
				$email_message = str_replace('{name}', $this->input->post('name'), $email_message);
				$email_message = str_replace('{number}', $this->input->post('number'), $email_message);
				$email_message = str_replace('{email}', $this->input->post('email'), $email_message);
				$str = $email_message;
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
				
				
				redirect('home/suggest_advertise/'.$msg);
			}		
        if(get_authenticateUserID() > 0)
        {
		  $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        }
        else
        {
            $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        }
		$this->template->write_view ('content_center', $theme.'/home/suggestadvertise', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();
	}

    function updatebanner($msg='')
	{
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		
		if($this->session->userdata('user_type')=='bar_owner')
		{
		  	$data['bar_detail'] = $this->home_model->get_bar_info(get_authenticateUserID());
		}
		else {
			$data['bar_detail'] = get_user_info(get_authenticateUserID());
		}
		$data['msg'] = $msg;
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		if($this->session->userdata('user_type')=='bar_owner')
		{
		$this->template->write_view ('content_center', $theme.'/home/updatebanner', $data, TRUE);
		}
		else {
				$this->template->write_view ('content_center', $theme.'/home/updatebanneruser', $data, TRUE);
		}
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
	}

    function updatebannernew()
	{
		
		$bar_banner_img = '';
		 if($_FILES['file']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['file']['name'];
             $_FILES['userfile']['type']     =   $_FILES['file']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['file']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['file']['error'];
             $_FILES['userfile']['size']     =   $_FILES['file']['size'];
   
			$config['file_name'] = 'bar_logo'.$rand;
			
            $config['upload_path'] = base_path().'upload/barlogo_orig/';
			
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			
			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   
              $this->image_lib->clear();
		   	
			
					$gd_var='gd2';
				
				
		   if ($_FILES["file"]["type"]!= "image/png" and $_FILES["file"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["file"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["file"]["type"] != "image/jpeg" and $_FILES["file"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			 $this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/barlogo_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/barlogo/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => '685',
				'height' => '320',
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/barlogo_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/banner_without_drag/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => '1140',
				'height' => '244',
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$this->image_lib->clear();
			
			$crop_from_top = abs ($this->input->post('pos')) ;
			
		
		$default_cover_width = 1140;
		$default_cover_height = 244;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/barlogo_orig/'.$picture['file_name'];

		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/banner_drag/'.$picture['file_name'];
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
		
		resize(base_path().'upload/banner_drag/'.$picture['file_name'],base_path().'upload/banner_drag_thumb/'.$picture['file_name'],150,150);
			 // $this->image_lib->initialize(array(
				// 'image_library' => $gd_var,
				// 'source_image' => base_path().'upload/barlogo_orig/'.$picture['file_name'],
				// 'new_image' => base_path().'upload/banner_drag/'.$picture['file_name'],
				// 'maintain_ratio' => FALSE,
				// 'quality' => '100%',
				// 'width' => '685',
				// 'height' => '320',
				// 'x_axis' => $this->input->post('pos'),
			 // ));
// 			
// 			
			// if(!$this->image_lib->crop())
			// {
				// $error = $this->image_lib->display_errors();
			// }
// 			
			$bar_banner_img=$picture['file_name'];
			
		
			if($this->input->post('prev_bar_banner')!='')
				{
					if(file_exists(base_path().'upload/barlogo_orig/'.$this->input->post('prev_bar_banner')))
					{
						$link=base_path().'upload/barlogo_orig/'.$this->input->post('prev_bar_banner');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/barlogo/'.$this->input->post('prev_bar_banner')))
					{
						$link2=base_path().'upload/barlogo/'.$this->input->post('prev_bar_banner');
						unlink($link2);
					}

					if(file_exists(base_path().'upload/banner_drag/'.$this->input->post('prev_bar_banner')))
					{
						$link2=base_path().'upload/banner_drag/'.$this->input->post('prev_bar_banner');
						unlink($link2);
					}
					
				}
			} else {
				
				if($this->input->post('prev_bar_banner')!='')
				{
					
					if($this->input->post('pos')!=0)
					{
						
					if(file_exists(base_path().'upload/banner_drag/'.$this->input->post('prev_bar_banner')))
					{
						$link=base_path().'upload/banner_drag/'.$this->input->post('prev_bar_banner');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/banner_drag_thumb/'.$this->input->post('prev_bar_banner')))
					{
						$link=base_path().'upload/banner_drag_thumb/'.$this->input->post('prev_bar_banner');
						unlink($link);
					}
						
						$this->load->library('upload');
						$crop_from_top = abs ($this->input->post('pos')) ;
						
						
		$default_cover_width = 1140;
		$default_cover_height = 244;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/barlogo_orig/'.$this->input->post('prev_bar_banner');

		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/banner_drag/'.$this->input->post('prev_bar_banner');
		
		
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
		
		resize(base_path().'upload/banner_drag/'.$this->input->post('prev_bar_banner'),base_path().'upload/banner_drag_thumb/'.$this->input->post('prev_bar_banner'),150,150);
					}
					$bar_banner_img=$this->input->post('prev_bar_banner');
				}
			}
	    //$bar_detail = $this->bar_model->get_one_bar($this->input->post('bar_id'));	
	    
	    $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		$data1	 = array('bar_banner'=>$bar_banner_img);
		$this->db->where("bar_id",@$data['getbar']['bar_id']);
		$this->db->update('bars',$data1);	
		//redirect('bar/details/'.$data['getbar']['bar_slug']);
		
		redirect('home/updatebanner/success');
	}

	function updatebannernew_user()
	{
		
		
		$bar_banner_img = '';
		 if($_FILES['file']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['file']['name'];
             $_FILES['userfile']['type']     =   $_FILES['file']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['file']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['file']['error'];
             $_FILES['userfile']['size']     =   $_FILES['file']['size'];
   
			$config['file_name'] = 'bar_logo'.$rand;
			
            $config['upload_path'] = base_path().'upload/barlogo_orig/';
			
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			
			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   
              $this->image_lib->clear();
		   	
			
					$gd_var='gd2';
				
				
		   if ($_FILES["file"]["type"]!= "image/png" and $_FILES["file"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["file"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["file"]["type"] != "image/jpeg" and $_FILES["file"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			 $this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/barlogo_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/barlogo/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => '685',
				'height' => '320',
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/barlogo_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/banner_without_drag/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => '1140',
				'height' => '244',
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$this->image_lib->clear();
			
			$crop_from_top = abs ($this->input->post('pos')) ;
			
		
		$default_cover_width = 1140;
		$default_cover_height = 244;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/barlogo_orig/'.$picture['file_name'];

		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/banner_drag/'.$picture['file_name'];
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
		
		resize(base_path().'upload/banner_drag/'.$picture['file_name'],base_path().'upload/banner_drag_thumb/'.$picture['file_name'],150,150);
			 // $this->image_lib->initialize(array(
				// 'image_library' => $gd_var,
				// 'source_image' => base_path().'upload/barlogo_orig/'.$picture['file_name'],
				// 'new_image' => base_path().'upload/banner_drag/'.$picture['file_name'],
				// 'maintain_ratio' => FALSE,
				// 'quality' => '100%',
				// 'width' => '685',
				// 'height' => '320',
				// 'x_axis' => $this->input->post('pos'),
			 // ));
// 			
// 			
			// if(!$this->image_lib->crop())
			// {
				// $error = $this->image_lib->display_errors();
			// }
// 			
			$bar_banner_img=$picture['file_name'];
			
		
			if($this->input->post('prev_bar_banner')!='')
				{
					if(file_exists(base_path().'upload/barlogo_orig/'.$this->input->post('prev_bar_banner')))
					{
						$link=base_path().'upload/barlogo_orig/'.$this->input->post('prev_bar_banner');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/barlogo/'.$this->input->post('prev_bar_banner')))
					{
						$link2=base_path().'upload/barlogo/'.$this->input->post('prev_bar_banner');
						unlink($link2);
					}

					if(file_exists(base_path().'upload/banner_drag/'.$this->input->post('prev_bar_banner')))
					{
						$link2=base_path().'upload/banner_drag/'.$this->input->post('prev_bar_banner');
						unlink($link2);
					}
					
				}
			} else {
				
				
				
				if($this->input->post('prev_bar_banner')!='')
				{
					
					if($this->input->post('pos')!=0)
					{
					if(file_exists(base_path().'upload/banner_drag/'.$this->input->post('prev_bar_banner')))
					{
						$link=base_path().'upload/banner_drag/'.$this->input->post('prev_bar_banner');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/banner_drag_thumb/'.$this->input->post('prev_bar_banner')))
					{
						$link=base_path().'upload/banner_drag_thumb/'.$this->input->post('prev_bar_banner');
						unlink($link);
					}
						
						$this->load->library('upload');
						$crop_from_top = abs ($this->input->post('pos')) ;
						
						
		$default_cover_width = 1140;
		$default_cover_height = 244;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/barlogo_orig/'.$this->input->post('prev_bar_banner');

		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/banner_drag/'.$this->input->post('prev_bar_banner');
		
		
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
		
		resize(base_path().'upload/banner_drag/'.$this->input->post('prev_bar_banner'),base_path().'upload/banner_drag_thumb/'.$this->input->post('prev_bar_banner'),150,150);
					}
					$bar_banner_img=$this->input->post('prev_bar_banner');
				}
			}
	    //$bar_detail = $this->bar_model->get_one_bar($this->input->post('bar_id'));	
	    
	    //$data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		$data1	 = array('user_banner'=>$bar_banner_img);
		$this->db->where("user_id",get_authenticateUserID());
		$this->db->update('user_master',$data1);	
		redirect('home/updatebanner');
	}

    function socialmedialink($msg="")
	{
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}		
		if($this->session->userdata('user_type')!='bar_owner')
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$data['page_name']="credit_card_update";
		 $data['msg'] = $msg; //login fail message
	  $this->form_validation->set_rules('facebook_link','Facebook Link', 'valid_url');
	  $this->form_validation->set_rules('twitter_link','Twitter Tink', 'valid_url');
	  $this->form_validation->set_rules('linkedin_link','Linkedin Link', 'valid_url');
	  $this->form_validation->set_rules('google_plus_link','Google Plus Link', 'valid_url');
	  $this->form_validation->set_rules('dribble_link', 'Dribble Link', 'valid_url');
	  $this->form_validation->set_rules('pinterest_link', 'Pinterest Link', 'valid_url');
	  $data['error'] = '';
	  
	   $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
	  
	   $data['facebook_link']=$data['getbar']['facebook_link'];
	   $data['twitter_link']=$data['getbar']['twitter_link'];
	   $data['linkedin_link']=$data['getbar']['linkedin_link'];
	   $data['google_plus_link']=$data['getbar']['google_plus_link'];
	   $data['dribble_link']=$data['getbar']['dribble_link'];
	   $data['pinterest_link']=$data['getbar']['pinterest_link'];
	   
	  
	   if($_POST)
	   {
	   if($this->form_validation->run() == FALSE)
		{
				if(validation_errors())
				{													
					$data["error"] = validation_errors();
				}
				else
				{		
					$data["error"] = "";							
				}
					$data['facebook_link']=$this->input->post('facebook_link');
					$data['twitter_link']=$this->input->post('twitter_link');
					$data['linkedin_link']=$this->input->post('linkedin_link');
					$data['google_plus_link']=$this->input->post('google_plus_link');
					$data['dribble_link']=$this->input->post('dribble_link');
					$data['pinterest_link']=$this->input->post('pinterest_link');
					
		}
        else
		{
			 
		$usr=array('facebook_link'=>$this->input->post('facebook_link'),
		           'twitter_link'=>$this->input->post('twitter_link'),
				   'linkedin_link'=>$this->input->post('linkedin_link'),
				   'google_plus_link'=>$this->input->post('google_plus_link'),
				   'dribble_link'=>$this->input->post('dribble_link'),
				   'pinterest_link'=>$this->input->post('pinterest_link'),);
		
		$this->db->where('owner_id',get_authenticateUserID());
		$this->db->update('bars',$usr);
		
		
		$data["msg"] = "success";
		
		
		}
		}
		
		
		if($data["error"] !="")
		{
			$response = array("comment_error"=>$data["error"],"status"=>"fail");
			echo json_encode($response);
		    die;
		}
		
		if($data["msg"] == "success")
		{
			$response = array("status"=>"success");
			echo json_encode($response);
		    die;
		}
		
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/updatesocialurl', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
	}


     function barcriteria()
	{
		$this->session->set_userdata(array('count' => 0));
		$data = array();
        $theme = getThemeName ();
        $this->template->set_master_template ($theme.'/template.php');
        
        $page_detail=meta_setting();
        $pageTitle=$page_detail->title;
        $metaDescription=$page_detail->meta_description;
        $metaKeyword=$page_detail->meta_keyword;

        $data["site_setting"] = site_setting ();
        $data["active_menu"]='barcriteria';
        $data["error"] = "";
		$data["site_setting"] = site_setting();
		
		$data['get_dive_bar'] = $this->home_model->getdivebar();
        if($_POST)
		{
			$this->session->set_userdata(array('count' => count($this->input->post('sample')),'fchk'=>$this->input->post('fchk')));
			redirect('bar/suggest_bar');
		}
        $data['statistics'] = $this->home_model->getStatisticsData();
        $this->template->write ('pageTitle', $pageTitle, TRUE);
        $this->template->write ('metaDescription', $metaDescription, TRUE);
        $this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        $this->template->write_view ('content_center', $theme.'/home/criteria', $data, TRUE);
        $this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
        $this->template->render ();
	}

	function adminLogin($user_id)
	{
		// echo get_cookie('login_for');
		// die;
		//$this->load->helper('cookie');
		//$login_for = get_cookie('login_for');
		//$user_id = get_cookie('user_id');
		
		$OneUsr=get_user_info($user_id);
		
		if($OneUsr!=''){
    		$data = array(
    		'user_id' => $OneUsr->user_id,
    		'email' => $OneUsr->email,
    		'user_type' => $OneUsr->user_type,
    		'username' => $OneUsr->first_name,
    		);	
            $this->session->set_userdata($data);
        }
		
		
		//delete_cookie('login_for');
		//delete_cookie('user_id');
		redirect('home/test123');
		
	}
	
	function test123()
	{
		$login_for = get_cookie('login_for');
		$user_id = get_cookie('user_id');
		
		$OneUsr=get_user_info($user_id);
		
		if($OneUsr!=''){
    		$data = array(
    		'user_id' => $OneUsr->user_id,
    		'email' => $OneUsr->email,
    		'user_type' => $OneUsr->user_type,
    		'username' => $OneUsr->first_name,
    		);	
            $this->session->set_userdata($data);
        }
		redirect('home/dashboard');
		
	}
    
	function events()
	{
		echo "sda";
		die;
	}
	
	function sitemap($msg='')
	{
		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        
        if(get_authenticateUserID() > 0)
        {
		  $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        }
        else
        {
            $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        }
		$this->template->write_view ('content_center', $theme.'/home/sitemap', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();
	}

    function emaisend()
	{
		$str = "Your Account Created Successfully";
		email_send('qa@spaculus.com', 'qa@spaculus.com', 'qa@spaculus.com', 'Regitration Syccess', $str);
		
	}
	
	function success_user()
	{
		$theme = getThemeName ();
        $data['site_setting'] = site_setting ();
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		
		$this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/confirmpage_user', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render();
		
	}
	
	function sendemail()
	{
		$message = $this->home_model->user_forgot_password($this->input->post('email'),$this->input->post('type'));
		
	}
	
	function getsugbar()
	{
		$theme = getThemeName ();
		$data = array();
		//$bar_detail = $this->bar_model->get_one_bar($this->input->post('id'));
		//$data['bar_detail'] = $bar_detail;
		//$data['result'] = $this->taxiowner_model->gettaxibysearch($bar_detail['city'],$bar_detail['zipcode']);
		echo $this->load->view($theme .'/bar/bar_suggest',$data,TRUE);die;
	}
	
	function redirect_home()
	{
		redirect(base_url());
	}
	
	function _facebook_validate($fb_uid = 0,$email='',$accessToken='') 
	{
   		//this query basically sees if the users facebook user id is associated with a user.
   		$bQry = $this->home_model->validate_user_facebook($fb_uid,$email,$accessToken);
		
		//echo $bQry;
      	if($bQry=='2'){
			//$this->session->set_flashdata('msg', 'login');
			$this->session->set_flashdata('successmsg', "loginSuccess");
			redirect('home/dashboard');	
			//redirect('home/dashboard');
			//redirect('home/facebook_login');
			
		} elseif($bQry) { // if the user's credentials validated...	
	 		//$this->session->set_flashdata('msg', 'login');
			$this->session->set_flashdata('successmsg', "loginSuccess");
			redirect('home/dashboard');
	 		//redirect('home/facebook_login');
			 
      	} else {
        	// incorrect username or password
        	$data = array();
         	$data["login_failed"] = TRUE;
         	$this->index($data);
      	}
   }


	function facebook() 
   	{
   		//  $this->load->library('upload');
   		if(!$this->fb_connect->fbSession) {
   			redirect('home');
		} else {
   			$fb_uid = $this->fb_connect->user_id;			
   			$fb_usr = $this->fb_connect->user;
			
			
			$accessToken = '';
			
			if($fb_uid != ''){
				$this->session->set_userdata(array("facebook_id"=>$fb_uid));		
			}
		
   			if($fb_uid != false) {
	   			if(isset($fb_usr["email"])){
					 $email = $fb_usr["email"];
					 
				} else {
					 $email='';
				}

				$usr = $this->home_model->get_user_by_fb_uid($fb_uid,$email);
				
				 
				if($usr) {
	   				$this->_facebook_validate($fb_uid,$email,$accessToken);
										
	   			} else {
	   				$fname = $fb_usr["first_name"]; 
	   				$lname = $fb_usr["last_name"];
	   				$fullname = $fb_usr["name"];
	   				$pwd = ''; 
					$fb_img='';
					
					$base_path = base_path();
					$image_settings = image_setting();
					$img = file_get_contents('https://graph.facebook.com/'.$fb_uid.'/picture?type=large');
					$file = base_path()."upload/user_orig/".$fb_uid.".jpg";
					
					file_put_contents($file, $img);
					$fb_img= $fb_uid.'.jpg';
					$config['upload_path'] = $base_path.'upload/user_orig/';
					$config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';
					//$config['max_size']	= '100';// in KB
					$this->load->library('upload', $config);
					$config['source_image'] = $this->upload->upload_path.$fb_img;
					$config['new_image'] = base_path()."upload/user_thumb/";
					$config['thumb_marker'] = "";
					//$config['maintain_ratio'] = $image_settings['u_ratio'];
					$config['create_thumb'] = TRUE;
					$config['width'] = 120;
					$config['height'] = 120;
					$this->load->library('image_lib', $config);
					$gd_var='gd2';
					if(!$this->image_lib->resize()){
						echo $error = $this->image_lib->display_errors();
						die;				
					}	

					$fb_values = array (                    
						'fb_id' => $fb_uid,
						'first_name' => strtolower(str_replace (" ", "",$fname)),
						'last_name' => strtolower(str_replace (" ", "",$lname)),                    
						'email'=>$email,
						'fb_img'=>$fb_img,
						'type' =>'facebook'
					);
           			
					//print_r($fb_values)
					
					//if(GetDomainId() > 0){
						$this->home_model->save_social_data($fb_values);
						//$this->session->set_flashdata('msg', 'login');
						$this->session->set_flashdata('successmsg', "loginSuccess");
						redirect('home/dashboard');
						
	   			}
	   		} 
   		}
   	}
     
	 function test_paypal()
	 {
	 	$card = new CreditCard();
$card->setType("visa")
    ->setNumber("4148529247832259")
    ->setExpireMonth("11")
    ->setExpireYear("2019")
    ->setCvv2("012")
    ->setFirstName("Joe")
    ->setLastName("Shopper");

// ### FundingInstrument
// A resource representing a Payer's funding instrument.
// For direct credit card payments, set the CreditCard
// field on this object.
$fi = new FundingInstrument();
$fi->setCreditCard($card);

// ### Payer
// A resource representing a Payer that funds a payment
// For direct credit card payments, set payment method
// to 'credit_card' and add an array of funding instruments.
$payer = new Payer();
$payer->setPaymentMethod("credit_card")
    ->setFundingInstruments(array($fi));

// ### Itemized information
// (Optional) Lets you specify item wise
// information
$item1 = new Item();
$item1->setName('Ground Coffee 40 oz')
    ->setDescription('Ground Coffee 40 oz')
    ->setCurrency('USD')
    ->setQuantity(1)
    ->setTax(0.3)
    ->setPrice(7.50);
$item2 = new Item();
$item2->setName('Granola bars')
    ->setDescription('Granola Bars with Peanuts')
    ->setCurrency('USD')
    ->setQuantity(5)
    ->setTax(0.2)
    ->setPrice(2);

$itemList = new ItemList();
$itemList->setItems(array($item1, $item2));

// ### Additional payment details
// Use this optional field to set additional
// payment information such as tax, shipping
// charges etc.
$details = new Details();
$details->setShipping(1.2)
    ->setTax(1.3)
    ->setSubtotal(17.5);

// ### Amount
// Lets you specify a payment amount.
// You can also specify additional details
// such as shipping, tax.
$amount = new Amount();
$amount->setCurrency("USD")
    ->setTotal(20)
    ->setDetails($details);

// ### Transaction
// A transaction defines the contract of a
// payment - what is the payment for and who
// is fulfilling it. 
$transaction = new Transaction();
$transaction->setAmount($amount)
    ->setItemList($itemList)
    ->setDescription("Payment description")
    ->setInvoiceNumber(uniqid());

// ### Payment
// A Payment Resource; create one using
// the above types and intent set to sale 'sale'
$payment = new Payment();
$payment->setIntent("sale")
    ->setPayer($payer)
    ->setTransactions(array($transaction));

// For Sample Purposes Only.
$request = clone $payment;

// ### Create Payment
// Create a payment by calling the payment->create() method
// with a valid ApiContext (See bootstrap.php for more on `ApiContext`)
// The return object contains the state.
try {
    $payment->create($this->apiContext);
} catch (Exception $ex) {
    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
 	ResultPrinter::printError('Create Payment Using Credit Card. If 500 Exception, try creating a new Credit Card using <a href="https://ppmts.custhelp.com/app/answers/detail/a_id/750">Step 4, on this link</a>, and using it.', 'Payment', null, $request, $ex);
    exit(1);
}

// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
 ResultPrinter::printResult('Create Payment Using Credit Card', 'Payment', $payment->getId(), $request, $payment);
echo "<pre>";
print_r($payment);
	 }
}
?>