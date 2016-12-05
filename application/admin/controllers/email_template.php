<?php
date_default_timezone_set("Europe/London");
class Email_template extends CI_Controller {
	function Email_template()
	{
		 parent::__construct();	
		$this->load->model('email_template_model');	
	}
	/*Email template page*/
	function index()
	{
		redirect('email_template/list_email_template/');
	}
	/*This function is use for list email templates for email format
	 * param  : limit ,redirect page,option,keyword,limit,offset
	 * Result : diaply list of all email templates*/
	
	function list_email_template($limit='20',$offset=0,$sort_type='sort',$sort_by='admin_id',$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}		
		$check_rights=get_rights('list_email_template');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$data["error"] = '';
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		
		$this->load->library('pagination');

		$config['uri_segment']='4';
		$config['base_url'] = base_url().'email_template/list_email_template/'.$limit.'/';
		$config['total_rows'] = $this->email_template_model->get_email_template_count();
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		if($this->input->post('limit') != '')
		{
			$data['limit']=$this->input->post('limit');
		}
		else
		{
			$data['limit']=$limit;
		}
		$data['offset'] = $offset;
		$data['option']='1V1';
		$data['keyword']='1V1';
		$data['serach_option']='1V1';
		$data['serach_keyword']='1V1';
		$data['search_type']='normal';
		$data['redirect_page']='list_email_template';
		$data['sort_type']=$sort_type;
		$data['sort_by']=$sort_by;
		$data['msg']=$msg;
		
		$data['page_name']="list_email_template";
		$data['site_setting'] = site_setting();
		$data["template"] = $this->email_template_model->get_email_template($offset, $limit);
		
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/email_template/list_email_template',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/*This function is use for edit email template
	 * param  : id,limit
	 * Result : Add page of email template*/
	
	function add_email_template($id=0,$limit=0)
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('add_email_template');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$one_email_template = $this->email_template_model->get_one_email_template($id);
		$data['task'] = $one_email_template->task;
		$this->load->library('form_validation');
		if($limit > 0)
		{
			$data['limit']=$limit;
		}
		else
		{
			$data['limit']=20;
		}

		$this->form_validation->set_rules('from_address', 'From Address', 'required|valid_email');
		//$this->form_validation->set_rules('reply_address', 'Reply Address', 'required|valid_email');
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		$this->form_validation->set_rules('message', 'Message', 'required');
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			if($this->input->post('email_template_id'))
			{
				$data["email_template_id"] = $this->input->post('email_template_id');
				$data["from_address"] = $this->input->post('from_address');
				$data["reply_address"] = $this->input->post('reply_address');
				$data["subject"] = $this->input->post('subject');
				$data["message"] = $this->input->post('message');
			}else{
				
				$data["email_template_id"] = $one_email_template->email_template_id;
				$data["from_address"] = $one_email_template->from_address;
				$data["reply_address"] = $one_email_template->reply_address;
				$data["subject"] = $one_email_template->subject;
				$data["message"] = $one_email_template->message;
				$data["task"] = $one_email_template->task;
			}
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_email_template';
			$data['sort_type']='desc';
			$data['sort_by']='email_template_id';
			
			
			if($this->input->post('offset')=="")
			{
				$limit = '10';
				$data["offset"] = 0;
			}else{
				$data["offset"] = $this->input->post('offset');
			}
			
			
			$data['site_setting'] = site_setting();
			$data['page_name']="list_email_template";
			$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/email_template/add_email_template',$data,TRUE);
			
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
			$this->email_template_model->email_template_update();
			$data["error"] = "Email template updated successfully";
			$data["email_template_id"] = $this->input->post('email_template_id');
			$data["from_address"] = $this->input->post('from_address');
			$data["reply_address"] = $this->input->post('reply_address');
			$data["subject"] = $this->input->post('subject');
			$data["message"] = $this->input->post('message');
			$data['site_setting'] = site_setting();
			$msg = "update";
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
		 	$sort_type = $this->input->post('sort_type');
			$sort_by = $this->input->post('sort_by');
			if($redirect_page == 'list_email_template')
			{
				redirect('email_template/'.$redirect_page.'/'.$limit.'/'.$sort_type.'/'.$sort_by.'/'.$offset.'/'.$msg);
			}
			else
			{
				redirect('email_template/'.$redirect_page.'/'.$limit.'/'.$sort_type.'/'.$sort_by.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}	

function action_email_template()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_cocktail');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$cocktail_id =$this->input->post('chk');
			
		if($action=='active')
		{
			foreach($cocktail_id as $id)
			
			{			
				$data = array('status'=>'active');
				$this->db->where('email_template_id',$id);
				$this->db->update('email_template', $data);
			}
			if($redirect_page == 'list_email_template')
			{
				redirect('email_template/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('email_template/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive')
		{
		
             		
			foreach($cocktail_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('email_template_id',$id);
				$this->db->update('email_template', $data);
			}
			
			if($redirect_page == 'list_email_template')
			{
				redirect('email_template/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('email_template/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');

			}
			
			
		}	
		
		
		
		
	}
}
?>