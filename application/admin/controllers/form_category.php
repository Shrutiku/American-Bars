<?php
class Form_category extends  CI_Controller {
	function Form_category()
	{
		 parent::__construct();	
		$this->load->model('form_category_model');
		$this->output->nocache();
		//$this->output->clear_page_cache();
	}
	
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
	
		redirect('form_category/list_form_category');
		
		$check_rights=get_rights('list_form_category');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
	}
	
	// Use :This function use for Lost all form_category User.
	// Param :limit,offset,message
	// Return :'N/A'
	function list_form_category($limit='10',$offset=0,$msg='')
	{
		$this->load->driver('cache');
		 $this->cache->clean();
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
		
		$check_rights=get_rights('list_form_category');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('pagination');

		
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'form_category/list_form_category/'.$limit.'/';
		$config['total_rows'] = $this->form_category_model->get_total_form_category_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->form_category_model->get_form_category_result($offset,$limit);
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
		$data['redirect_page']='list_form_category';
	
		
		
		
		
		$data['site_setting'] = site_setting();

		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/form_category/list_form_category',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for list form_category by filter.
	// Param :limit,option,keyword,offset,message
	// Return :'N/A'
	function search_list_form_category($limit=20,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$redirect_page = 'search_list_form_category';
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('search_list_form_category');
		
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
		$config['base_url'] = base_url().'form_category/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->form_category_model->get_total_search_form_category_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		;
		
		$data['result'] = $this->form_category_model->get_search_form_category_result($option,$keyword,$offset, $limit);
		
		
		
		
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
		$this->template->write_view('center',$theme .'/layout/form_category/list_form_category',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for check unique UserName of form_category.
	// Param :UserName
	// Return :Boolean
	function username_check($username)
	{
		$username = $this->form_category_model->user_unique($username);
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
	// Use :This function use for check unique Email of form_category.
	// Param :Email
	// Return :Boolean
	function form_categorymail_check($emailField)
	{
		$username = $this->form_category_model->user_email_unique($emailField);
		if($username == TRUE)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('form_categorymail_check', 'There is an existing account associated with this Email');
			return FALSE;
		}
	}
	
	// Use :This function use for add new form_category.
	// Param :'N/A'
	// Return :'N/A'
	
	function add_form_category($limit=0)
	{
		$this->load->driver('cache');
		 $this->cache->clean();
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
		
		$check_rights=get_rights('add_form_category');
		
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
		
		$data['category'] = $this->form_category_model->get_category();
		//print_r($category); die;
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('forum_category_name', 'Form Name', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
			
		
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			$data["forum_category_name"] = $this->input->post('forum_category_name');
			$data["form_category_id"] = $this->input->post('form_category_id');
			$data["status"] = $this->input->post('form_category_status');
			
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_form_category';
			
			
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
			$this->template->write_view('center',$theme .'/layout/form_category/add_form_category',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				
			if($this->input->post('form_category_id')!='')
			{	
				$this->form_category_model->form_category_update();
				$msg = "update";
			}else{
				$this->form_category_model->form_category_insert();			
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
		 	
			 
			if($redirect_page == 'list_form_category')
			{
				redirect('form_category/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			else
			{
				redirect('form_category/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	
	// Use :This function use for edit of update form_category.
	// Param :form_category id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function edit_form_category($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
		
		$check_rights=get_rights('edit_form_category');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$data['category'] = $this->form_category_model->get_category();
		
		$one_user = $this->form_category_model->get_one_form_category($id);
		//print_r($one_user); die;
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		$data["form_category_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		$data["forum_category_name"] = $one_user['forum_category_name'];
		$data['status']=$one_user['status'];
		
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/form_category/add_form_category',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}

	// Use :This function use for Delete form_category.
	// Param :form_category id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function delete_form_category($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*   
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_form_category');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
         $data_log = array("activity_name" => "LOG_DELETE_ADMIN");
         maintain_log($data_log);
		//$this->db->delete('rights_assign',array('form_category_id'=>$id));
		$this->db->delete('forum_category',array('forum_category_id'=>$id));
		if($redirect_page == 'list_form_category')
		{
			
			redirect('form_category/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('form_category/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
        
        /// common function for insert all action//
           $data_log = array("activity_name" => "LOG_DELETE_ADMIN");
           maintain_log($data_log);
	}
	
	
	// Use :This function use for change status or delete form_category.
	// Param :'N/a'
	// Return :'N/A'
	function action_form_category()
	{
		/* Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('action_form_category');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
		
		$form_category_id =$this->input->post('chk');
		
		if($action=='delete')
		{
          
               
                		
			foreach($form_category_id as $id)
			{			
				$this->db->query("delete from ".$this->db->dbprefix('forum_category')." where forum_category_id ='".$id."'");
			}
			
			if($redirect_page == 'list_form_category')
			{
				redirect('form_category/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('form_category/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
           
                		
			foreach($form_category_id as $id)
			{			
				$data = array('status'=>'active');
				$this->db->where('forum_category_id',$id);
				$this->db->update('forum_category', $data);
			}
			if($redirect_page == 'list_form_category')
			{
				redirect('form_category/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('form_category/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive')
		{
		  //Log Entry        
          
                		
			foreach($form_category_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('forum_category_id',$id);
				$this->db->update('forum_category', $data);
			}
			
			if($redirect_page == 'list_form_category')
			{
				redirect('form_category/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('form_category/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');

			}
		}	
		
	}

  
    
	
}


?>