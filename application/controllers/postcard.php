<?php
class Postcard extends SPACULLUS_Controller {

	/*
	 Function name :Home()
	 Description :Its Default Constuctor which called when home object initialzie.its load necesary models
	 */

	function Postcard () {
		
		
		
		parent :: __construct ();
		$this->load->library ("PasswordHash");
		$this->load->library ("encrypt");
		$this->load->model ('home_model');
	
	}

	public function index () {
            
                $data['error'] = '';
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

		$this->form_validation->set_rules ('code', 'Code', 'required');
    
                if ($_POST) { 
                    if ($this->form_validation->run ()== FALSE) {
				if (validation_errors ()) {
					$data["error"] = validation_errors ();
				} else {
					$data["error"] = "";
				}
				
				$data["code"] = $this->input->post ('code');	
			} else {
                                $postcard = $this->home_model->get_postcard_by_id($this->input->post('code'));
                                
                                if ($postcard == '') {
                                    $data["code"] = $this->input->post ('code');	
                                    $data["error"] = "Invalid code.";
                                } else {
                                    redirect('postcard/view/'.base64_encode($postcard->postcard_id));
                                }
                        }
                }
                
                $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/default_postcard', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render();
	}
	
	function view($id = '',$msg='') 
	{
            if (check_user_authentication() != '') {
                redirect('/bar/postcard');
            }
        
		if ($id== '') {
			redirect ('home');
		}
		$theme = getThemeName ();

		$data['error'] = '';
        $data["active_menu"]='';
        $data['site_setting'] = site_setting ();
		$data["msg"] = base64_decode($msg);
		$data['postcardid'] = $id;
		$data["maximum_attemp_cond"] = '';

        $data['postcard'] = $this->home_model->get_postcard_by_id($id);
        $data['bar_info'] = $this->home_model->getBardata($data['postcard']->bar_id);

		
		//print_r($data['postcard']);
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
				
				
				$login = $this->home_model->check_login(trim($this->input->post ('email')), trim($this->input->post ('password')), $this->input->post ('remember_me'),'bar_owner');
								 
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
		$this->template->write_view ('content_center', $theme.'/home/login_postcard', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render();
	}
	

  
}
?>