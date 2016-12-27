<?php
class Admin extends  CI_Controller {
	function Admin()
	{
		parent::__construct();	
		$this->load->model('admin_model');
	}
	
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('admin/list_admin');
		
		// $check_rights=get_rights('list_admin');
// 		
		// if(	$check_rights==0) {			
			// redirect('home/dashboard/no_rights');	
		// }
		
	}
	
	// Use :This function use for Lost all admin User.
	// Param :limit,offset,message
	// Return :'N/A'
	function list_admin($limit='10',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/* 
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('list_admin');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('pagination');

		
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'admin/list_admin/'.$limit.'/';
		$config['total_rows'] = $this->admin_model->get_total_admin_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->admin_model->get_admin_result($offset,$limit);
		$data['msg'] = $msg;
		
		$data['offset'] = $offset;
		$data['error']='';
		if($this->input->post('limit') != '')
		{
			$data['limit']=$this->input->post('limit');
		}
		else
		{
			$data['limit']=$limit;
		}
		$data['option']='1V1';
		$data['keyword']='1V1';
		$data['serach_option']='1V1';
		$data['serach_keyword']='1V1';
		$data['search_type']='normal';
		$data['redirect_page']='list_admin';
	
		
		
		
		
		$data['site_setting'] = site_setting();

		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/admin/list_admin',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for list admin by filter.
	// Param :limit,option,keyword,offset,message
	// Return :'N/A'
	function search_list_admin($limit=20,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$redirect_page = 'search_list_admin';
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('search_list_admin');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$this->load->library('pagination');
		
		if($_POST)
		{		
			$option=$this->input->post('option');
			$keyword=($this->input->post('keyword')!='')?str_replace(" ", "-",trim($this->input->post('keyword'))):'1V1';
			
		}
		else
		{
			$option=$option;
			$keyword=str_replace(" ", "-",trim($keyword));	
		
		}
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',trim($keyword)));

	
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'admin/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->admin_model->get_total_search_admin_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->admin_model->get_search_admin_result($option,$keyword,$offset, $limit);
		
		
		if($data['result']==0){
		$offset=0;
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'admin/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->admin_model->get_total_search_admin_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->admin_model->get_search_admin_result($option,$keyword,$offset, $limit);
		}
		
		$data['msg'] = $msg;
		$data['offset'] = $offset;
		$data['site_setting'] = site_setting();
		
		$data['limit']=$limit;
		$data['option']=$option;
		$data['keyword']=$keyword;
		$data['search_type']='search';
		$data['redirect_page']=$redirect_page;
		
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/admin/list_admin',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for check unique UserName of admin.
	// Param :UserName
	// Return :Boolean
	function username_check($username)
	{
		$username = $this->admin_model->user_unique($username);
		if($username == TRUE)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('username_check', 'There is an existing account associated with this Username');
			return FALSE;
		}
	}	
	// Use :This function use for check unique Email of admin.
	// Param :Email
	// Return :Boolean
	function adminmail_check($emailField)
	{
		$username = $this->admin_model->user_email_unique($emailField);
		if($username == TRUE)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('adminmail_check', 'There is an existing account associated with this Email');
			return FALSE;
		}
	}
	
	// Use :This function use for add new admin.
	// Param :'N/A'
	// Return :'N/A'
	
	function add_admin($limit=0)
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/*   
		 * Future enhancement
		 * when assigning rights is used
		*/
		if(check_admin_authentication()!=$this->input->post('admin_id'))
		{
		$check_rights=get_rights('add_admin');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		}
		if($limit > 0)
		{
			$data['limit']=$limit;
		}
		else
		{
			$data['limit']=20;
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('username', 'User Name', 'required|alpha_numeric|callback_username_check');
		$this->form_validation->set_rules('emailField', 'Email', 'required|valid_email|callback_adminmail_check');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[15]');
		$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|min_length[8]|max_length[15]|matches[password]');
			
		$video_error = '';
		if($_POST)
		{			
			$image_arr = array('image/gif','image/jpeg', 'image/pjpeg','image/jpeg', 'image/pjpeg','image/jpeg', 'image/pjpeg','image/png',  'image/x-png');
			if($_FILES["file_up"]["name"]!="")
			{
				if(!in_array($_FILES["file_up"]["type"],$image_arr))
				{
					$video_error .= "<p>Please upload jpg,jpeg,png,gif format only</p>";
				}
			}			
		}
		
		if($this->form_validation->run() == FALSE || $video_error != ""){			
			if (validation_errors () || $video_error != "")
			{
				$data["error"] = validation_errors();
				$data["error"] .= $video_error;
			}else{
				$data["error"] = "";
			}
			$data["first_name"] = $this->input->post('first_name');
			$data["last_name"] = $this->input->post('last_name');
			$data["admin_id"] = $this->input->post('admin_id');
			$data["email"] = $this->input->post('emailField');
			$data["username"] = $this->input->post('username');
			$data["password"] = $this->input->post('password');
			$data["login_ip"] = $this->input->post('login_ip');
			$data["admin_type"] = $this->input->post('admin_type');		
			$data["active"] = $this->input->post('active');
			$data['image']=$this->input->post('pre_profile_image');
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_admin';
			
			
			$data['site_setting'] = site_setting();
			
		
			if($this->input->post('offset')=="")
			{
				$limit = '10';
				$data["offset"] = 0;
			}else{
				$data["offset"] = $this->input->post('offset');
			}
			
			
			$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/admin/add_admin',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				
			if($this->input->post('admin_id')!='')
			{	
				$this->admin_model->admin_update();
				$msg = "update";
			}else{
				$this->admin_model->admin_insert();			
				$msg = "insert";
			}
			$offset = $this->input->post('offset');
			$limit=$this->input->post('limit');
			
			if($limit == 0)
			{
				$limit = 20;
			}
			else
			{
				$limit = $limit;
			}
			$redirect_page = $this->input->post('redirect_page');
			$option = $this->input->post('option');
			$keyword = $this->input->post('keyword');
		 	
			 
			if($redirect_page == 'list_admin')
			{
				redirect('admin/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			else
			{
				redirect('admin/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	
	// Use :This function use for edit of update admin.
	// Param :admin id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function edit_admin($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/*   
		 * Future enhancement
		 * when assigning rights is used
		*/
		if(check_admin_authentication()!=$id)
		{
		$check_rights=get_rights('edit_admin');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}}
		
		$one_user = $this->admin_model->get_one_admin($id);
		
		
		if(empty($one_user))
		{
			redirect('admin');
		}
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		$data["admin_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		$data["email"] = $one_user['email'];
		$data["first_name"] = $one_user['first_name'];
		$data["last_name"] =$one_user['last_name'];
		$data["username"] = $one_user['username'];
		$data["password"] = $one_user['password'];
		$data["login_ip"] = $one_user['login_ip'];
		$data["admin_type"] = $one_user['admin_type'];
		$data["active"] = $one_user['active'];
		$data['image']=$one_user['image'];
		
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/admin/add_admin',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}

	// Use :This function use for Delete admin.
	// Param :admin id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function delete_admin($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*   
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_admin');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
         $data_log = array("activity_name" => "LOG_DELETE_ADMIN");
         maintain_log($data_log);
		//$this->db->delete('rights_assign',array('admin_id'=>$id));
		$this->db->delete('admin',array('admin_id'=>$id));
		if($redirect_page == 'list_admin')
		{
			
			redirect('admin/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('admin/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
        
        /// common function for insert all action//
           $data_log = array("activity_name" => "LOG_DELETE_ADMIN");
           maintain_log($data_log);
	}
	
	// Use :This function use for admin Login.
	// Param :offset,message (optional)
	// Return :'N/A'
	function admin_login($offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/* Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('admin_login');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		
		
		$this->load->library('pagination');

		$limit = '20';
		
		$config['base_url'] = base_url().'admin/admin_login/';
		$config['total_rows'] = $this->admin_model->get_total_adminlogin_count();
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->admin_model->get_adminlogin_result($offset, $limit);
		$data['offset'] = $offset;
		
		$data['site_setting'] = site_setting();
		
		$data['msg']=$msg;
		

		$this->template->write_view('header_menu',$theme .'/layout/common/header_menu',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/admin/list_admin_login',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for change status or delete admin.
	// Param :'N/a'
	// Return :'N/A'
	function action_login()
	{
		/* Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('action_login');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
		
		$admin_id =$this->input->post('chk');
		
		if($action=='delete')
		{
             /// common function for insert all action//
           $data_log = array("activity_name" => "LOG_DELETE_ADMIN");
           maintain_log($data_log);
               
                		
			foreach($admin_id as $id)
			{			
				$this->db->query("delete from ".$this->db->dbprefix('admin')." where admin_id ='".$id."' and admin_id != ".get_authenticateadminID()."");
			}
			
			if($redirect_page == 'list_admin')
			{
				redirect('admin/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('admin/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
            //Log Entry		
           $data_log = array("activity_name" => "LOG_ACTIVE_ADMIN");
           maintain_log($data_log);    
                		
			foreach($admin_id as $id)
			{			
				$data = array('active'=>'Active');
				$this->db->where('admin_id',$id);
				$this->db->where('admin_id !=',get_authenticateadminID());
				$this->db->update('admin', $data);
			}
			if($redirect_page == 'list_admin')
			{
				redirect('admin/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('admin/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive')
		{
		  //Log Entry        
           $data_log = array("activity_name" => "LOG_INACTIVE_ADMIN");
           maintain_log($data_log);   
                		
			foreach($admin_id as $id)
			{			
				$data = array('active'=>'Inactive');
				$this->db->where('admin_id',$id);
				$this->db->where('admin_id !=',get_authenticateadminID());
				$this->db->update('admin', $data);
			}
			
			if($redirect_page == 'list_admin')
			{
				redirect('admin/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('admin/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');

			}
		}	
		
	}

  
    //Patient log activity
    // Use :This function use for Lost all blog of User.
    // Param :limit,offset,message
    // Return :'N/A'
    function list_logactivity($admin_id="",$limit='10',$offset=0,$msg='')
    {
        
        if(!check_admin_authentication())
        {
            redirect('home');
        }
        
        $theme = getThemeName();
        $this->template->set_master_template($theme .'/template.php');
        
        /* 
         * Future enhancement
         * when assigning rights is used
        */
        
        $check_rights=get_rights('list_logactivity');
        
        if( $check_rights==0) {         
            redirect('home/dashboard/no_rights');   
        }
        
        $this->load->library('pagination');

        $data['admin_id']=$admin_id;
        $config['uri_segment']='5';
        $config['base_url'] = base_url().'admin/list_logactivity/'.$admin_id.'/'.$limit.'/';
        $config['total_rows'] = $this->admin_model->get_total_count_logactivity($admin_id);
       
    
        $config['per_page'] = $limit;       
        $this->pagination->initialize($config);     
        $data['page_link'] = $this->pagination->create_links();
       
        
        $data['result'] = $this->admin_model->get_logactivity_result($admin_id,$limit,$offset);
         
      /*  echo "<pre>";
        print_r($data['result']);
        die;*/
        
        $data['msg'] = $msg;
        
        $data['offset'] = $offset;
        $data['error']='';
        if($this->input->post('limit') != '')
        {
            $data['limit']=$this->input->post('limit');
        }
        else
        {
            $data['limit']=$limit;
        }
        $data['option']='1V1';
        $data['keyword']='1V1';
        $data['serach_option']='1V1';
        $data['serach_keyword']='1V1';
        $data['search_type']='normal';
        $data['redirect_page']='list_logactivity';
        $data['site_setting'] = site_setting();
        $this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
        $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
        $this->template->write_view('center',$theme .'/layout/admin/list_admin_logactivity',$data,TRUE);
        $this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
        $this->template->render();
    }
								
    function removeimage($admin_id,$image,$limit,$offset,$redirect_page,$option,$keyword)
	{
		//echo "sdfsdf";die;
		if($image!='')
		{
			if(file_exists(base_path().'upload/admin_orig/'.$image))
			{
				$link=base_path().'upload/admin_orig/'.$image;
				unlink($link);
			}
			
			if(file_exists(base_path().'upload/admin/'.$image))
			{
				$link1=base_path().'upload/admin/'.$image;
				unlink($link1);
			}			
		}
		$msg='Image Removed';
		//redirect('serviceprovider/list_staff/'.$limit.'/'.$offset.'/'.$msg);
		redirect('admin/edit_admin/'.$admin_id.'/'.$redirect_page.'/'.$limit.'/1V1/1V1/'.$offset);
	}

function test()
	{
		$data = array();
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
	  		 $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/admin/test',$data,TRUE);
		$this->template->render();
	}	
}


?>