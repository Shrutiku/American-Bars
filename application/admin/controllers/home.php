<?php
class Home extends CI_Controller {
	
	
	function Home()
	{
		parent::__construct();	
		$this->load->model('home_model');	
	
	}
	/*** email setting page
	**/
	
	public function index($msg = '')
	{
		if(check_admin_authentication())
		{
			redirect('admin/list_admin');
			//if a dashboard created for use
			//redirect('home/dashboard');
		}
		$data=array();
		$data["error"] = "";
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		
		$data['msg'] = $msg; //login fail message

		//$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/common/login',$data,TRUE);
		//this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/*
	 * Function : login user for admin login*/
	function login()
	{
	
	$theme = getThemeName();
	$this->template->set_master_template($theme .'/template.php');
	
	$this->form_validation->set_rules('username', 'Email', 'required|valid_email');
	$this->form_validation->set_rules('password', 'Password', 'required');
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				//$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
		
		}else{
		//print_r($_POST);die;
			$login =$this->home_model->check_login();
			
			if(isset($login) && $login == '1')
			{
				//redirect("home/dashboard/valid");
				//echo 'done';die;
				redirect('admin/list_admin');
				
			}else{
			$data["error"] = "<p>Invalid UserName or Password.</p>";
				//redirect("home/index/invalid");
			}
			
		}
		
		$data['msg'] = $msg=''; //login fail message

		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/common/login',$data,TRUE);
		//this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
		
	}
	
	
	/*Function : forgot password is use for forgot password
	 * Future enhancement
	 * */
	function forgot_password()
	{
		
		
		$data["error"] = "";
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				//$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
					
	
		
		}else
		{
		
			$chk_mail=$this->home_model->forgot_email();
			
			if($chk_mail==0)
			{
					
				$data['error']='email_not_found';
				
			
			
			}
			elseif($chk_mail==2)
			{
				$data['error']='Inactive';	
				
			
			}
			else
			{
				$data['error']='success';	
				
			
			}
			
		
		}
		
		
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
	
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/common/forgot_password',$data,TRUE);
		//$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
		
		
	}
	
	
	/*After login admin will redirect to dashboard
	 * param : msg*/
	
	function dashboard($msg='')
    {
	
		//redirect("admin/list_admin/20/0/no_rights");
        $theme = getThemeName();
        $this->template->set_master_template($theme .'/template.php');

       $data = array();
       $data['msg'] = $msg; //login success message
       $offset = 0; $limit =10;
      
       $this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
	   $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
       $this->template->write_view('center',$theme .'/layout/common/dashboard',$data,TRUE);
       //$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
       $this->template->render();

}

	
	//function user for logout and clear all session variables
	function logout()
	{
		
		
		
		$this->session->sess_destroy();
		redirect("home/index/logout");
	}
	
	

	
}

?>