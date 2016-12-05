<?php
class Register extends SPACULLUS_Controller {

	/*
	 Function name :Home()
	 Description :Its Default Constuctor which called when home object initialzie.its load necesary models
	 */

	function Register() {
		parent :: __construct ();
		$this->load->library ("PasswordHash");
		$this->load->library ("encrypt");
		$this->load->model ('register_model');
		$this->load->helper ("cookie");
			$this->load->library('fb_connect');
		$this->config->load('facebook');
	}

	public function index ($msg = '') {	
	    $data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
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
		$this->template->write_view ('content_center', $theme.'/register/signup', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
	}	
	
	function signup($msg = '') 
	{
		if (check_user_authentication ()!= '') {
			redirect ('home');
		}
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;

		$data["site_setting"] = site_setting ();
        $site_setting = $data["site_setting"];
        
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);

		$data["first_name"] = $this->input->post ('first_name');
		$data["last_name"] = $this->input->post ('last_name');
		$data["email"] = $this->input->post ('email');
		$data["password"] = $this->input->post ('password');
		$data["about_user"] = $this->input->post ('about_user');
		$data["agree"] = $this->input->post ('agree');
		
		$this->load->library ('form_validation');
         $data["active_menu"]='';

		$this->form_validation->set_rules ('email', 'Email', 'required|valid_email|callback_email_check');
		$this->form_validation->set_rules ('password', 'Password', 'required|min_length[8]|max_length[12]|callback_password_check');
		$data["error"] = "";

		if ($_POST) {

			if ($this->form_validation->run ()== FALSE) {
				if (validation_errors ()) {
					$data["error"] = validation_errors ();
				} else {
					$data["error"] = "";
				}

			} else {

				///* INSERT ARRAY****//

				//$password = $this->passwordhash->hash ($this->input->post ("password"));
				$password = md5($this->input->post ("password"));
				$data_insert = array ();

               $data_insert['first_name'] = $this->input->post ('first_name');
			   $data_insert['last_name'] = $this->input->post ('last_name');
			   $data_insert['email'] = $this->input->post ('email');
			   $data_insert['about_user'] = $this->input->post ('about_user');
		       $data_insert['password'] = $password;
			   $data_insert["status"] = "inactive";
               $data_insert['sign_up_ip'] = $_SERVER['REMOTE_ADDR'];
			   $data_insert['sign_up_date'] = date ('Y-m-d H:i:s');
          
				
				
				$login = $this->home_model->insert_user ($data_insert, $this->input->post ("password"));
			
                            
				$msg = base64_encode("signup_sucess");
				redirect ('home/login/'.$msg);

			}
		}

		$this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/register/register', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();
	}
	function add_registration(){
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$data['msg'] = '';
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name','First Name','required');
		$this->form_validation->set_rules('last_name','Last Name','required');
		$this->form_validation->set_rules('email','Email','required|callback_email_check');
		$this->form_validation->set_rules('user_name','User Name','required|callback_username_check');
		$this->form_validation->set_rules('password','Password','required');
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
			$this->register_model->add_register();
			$msg = 'insert';
		}
		$this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/register/signup', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();
	}
	function email_check($email){
		$email = $this->register_model->email_unique($email);
		if($email == FALSE){
			$this->form_validation->set_message('email_check','There is an existing record with this Email Address');
			return FALSE;
		}
		return TRUE;
	}
	function username_check($name)
	{
		$username = $this->register_model->register_unique($name);
		if($username == FALSE)
		{
			$this->form_validation->set_message('username_check', 'There is an existing record with this User Name');
			return FALSE;
		}
		return TRUE;
	}
}
?>