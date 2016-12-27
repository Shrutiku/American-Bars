<?php
class size extends  CI_Controller {
	function size()
	{
		 parent::__construct();	
		$this->load->model('size_model');
		
	}
	
	function index()
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('size/list_size');
		
		$check_rights=get_rights('list_size');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
	}
	
	// Use :This function use for Lost all size User.
	// Param :limit,offset,message
	// Return :'N/A'
	function list_size($limit='20',$offset=0,$msg='')
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
		
		$check_rights=get_rights('list_size');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('pagination');

		
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'size/list_size/'.$limit.'/';
		$config['total_rows'] = $this->size_model->get_total_size_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->size_model->get_size_result($offset,$limit);
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
		$data['redirect_page']='list_size';
	
		
		
		
		
		$data['site_setting'] = site_setting();

		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/size/list_size',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for list size by filter.
	// Param :limit,option,keyword,offset,message
	// Return :'N/A'
	function search_list_size($limit=20,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$redirect_page = 'search_list_size';
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('search_list_size');
		
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
		$config['base_url'] = base_url().'size/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->size_model->get_total_search_size_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->size_model->get_search_size_result($option,$keyword,$offset, $limit);
		
		
		
		
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
		$this->template->write_view('center',$theme .'/layout/size/list_size',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for check unique UserName of size.
	// Param :UserName
	// Return :Boolean
	function username_check($username)
	{
		$username = $this->size_model->user_unique($username);
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
	// Use :This function use for check unique Email of size.
	// Param :Email
	// Return :Boolean
	function sizemail_check($emailField)
	{
		$username = $this->size_model->user_email_unique($emailField);
		if($username == TRUE)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('sizemail_check', 'There is an existing account associated with this Email');
			return FALSE;
		}
	}
	
	// Use :This function use for add new size.
	// Param :'N/A'
	// Return :'N/A'
	
	function add_size($limit=0)
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
		
		$check_rights=get_rights('add_size');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
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
		$this->form_validation->set_rules('size_name', 'Form Name', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
			
		
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			$data["size_name"] = $this->input->post('size_name');
			$data["Size_id"] = $this->input->post('Size_id');
			$data["status"] = $this->input->post('size_status');
			
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_size';
			
			
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
			$this->template->write_view('center',$theme .'/layout/size/add_size',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				
			if($this->input->post('Size_id')!='')
			{	
				$this->size_model->size_update();
				$msg = "update";
			}else{
				$this->size_model->size_insert();			
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
		 	
			 
			if($redirect_page == 'list_size')
			{
				redirect('size/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			else
			{
				redirect('size/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	
	// Use :This function use for edit of update size.
	// Param :size id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function edit_size($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
		
		$check_rights=get_rights('add_size');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		
		$one_user = $this->size_model->get_one_size($id);
		//print_r($one_user); die;
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		$data["Size_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		$data["size_name"] = $one_user['size_name'];
		$data['status']=$one_user['status'];
		
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/size/add_size',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}

	// Use :This function use for Delete size.
	// Param :size id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function delete_size($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*   
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_size');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
         $data_log = array("activity_name" => "LOG_DELETE_ADMIN");
         maintain_log($data_log);
		//$this->db->delete('rights_assign',array('Size_id'=>$id));
		$this->db->delete('Size',array('Size_id'=>$id));
		if($redirect_page == 'list_size')
		{
			
			redirect('size/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('size/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
        
        /// common function for insert all action//
           $data_log = array("activity_name" => "LOG_DELETE_ADMIN");
           maintain_log($data_log);
	}
	
	
	// Use :This function use for change status or delete size.
	// Param :'N/a'
	// Return :'N/A'
	function action_size()
	{
		/* Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('action_size');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword = $this->input->post('serach_keyword');
		
		$Size_id =$this->input->post('chk');
		
		if($action=='delete')
		{
          
               
                		
			foreach($Size_id as $id)
			{			
				$this->db->query("delete from ".$this->db->dbprefix('Size')." where Size_id ='".$id."'");
			}
			
			if($redirect_page == 'list_size')
			{
				redirect('size/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('size/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
           
                		
			foreach($Size_id as $id)
			{			
				$data = array('status'=>'active');
				$this->db->where('Size_id',$id);
				$this->db->update('Size', $data);
			}
			if($redirect_page == 'list_size')
			{
				redirect('size/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('size/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive')
		{
		  //Log Entry        
          
                		
			foreach($Size_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('Size_id',$id);
				$this->db->update('Size', $data);
			}
			
			if($redirect_page == 'list_size')
			{
				redirect('size/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('size/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');

			}
		}	
		
	}

  
    
	
}


?>