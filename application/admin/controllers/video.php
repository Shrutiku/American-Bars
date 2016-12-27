<?php
class Video extends  CI_Controller {
	function Video()
	{
		 parent::__construct();	
		$this->load->model('video_model');
		
	}
	
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('video/list_video');
		
		$check_rights=get_rights('list_video');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
	}
	
	// Use :This function use for Lost all video User.
	// Param :limit,offset,message
	// Return :'N/A'
	function list_video($limit='20',$offset=0,$msg='')
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
		
		$check_rights=get_rights('list_video');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('pagination');

		
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'video/list_video/'.$limit.'/';
		$config['total_rows'] = $this->video_model->get_total_video_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->video_model->get_video_result($offset,$limit);
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
		$data['redirect_page']='list_video';
	
		
		
		
		
		$data['site_setting'] = site_setting();

		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/video/list_video',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for list video by filter.
	// Param :limit,option,keyword,offset,message
	// Return :'N/A'
	function search_list_video($limit=20,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$redirect_page = 'search_list_video';
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('search_list_video');
		
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
		$config['base_url'] = base_url().'video/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->video_model->get_total_search_video_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->video_model->get_search_video_result($option,$keyword,$offset, $limit);
		
		
		if($data['result']==0){
		$offset=0;
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'video/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->video_model->get_total_search_video_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->video_model->get_search_video_result($option,$keyword,$offset, $limit);
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
		$this->template->write_view('center',$theme .'/layout/video/list_video',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for check unique UserName of video.
	// Param :UserName
	// Return :Boolean
	function username_check($username)
	{
		$username = $this->video_model->user_unique($username);
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
	// Use :This function use for check unique Email of video.
	// Param :Email
	// Return :Boolean
	function videomail_check($emailField)
	{
		$username = $this->video_model->user_email_unique($emailField);
		if($username == TRUE)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('videomail_check', 'There is an existing account associated with this Email');
			return FALSE;
		}
	}
	
	// Use :This function use for add new video.
	// Param :'N/A'
	// Return :'N/A'
	
	function add_video($limit=0)
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
		
		$check_rights=get_rights('add_video');
		
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
		
		$data['category'] = $this->video_model->get_category();
		//print_r($category); die;
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('video_title', 'video Title', 'required');
		$this->form_validation->set_rules('video_desc', 'Video Description', 'required');
		$this->form_validation->set_rules('video_category_id', 'Category Name', 'required');
		$this->form_validation->set_rules('video_price', 'Video Price', 'required');
		$this->form_validation->set_rules('video_type', 'Video Type', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
			
		
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			$data["video_title"] = $this->input->post('video_title');
			$data["video_desc"] = $this->input->post('video_desc');
			$data["video_id"] = $this->input->post('video_id');
			$data["video_file_name"] = $this->input->post('video_file_name');
			$data["video_category_id"] = $this->input->post('video_category_id');
		
			$data["video_price"] = $this->input->post('video_price');
			$data["video_preview"] = $this->input->post('video_preview');		
			$data["video_type"] = $this->input->post("video_type");
			$data["status"] = $this->input->post('video_status');
			$data['image']=$this->input->post('pre_video_image');
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_video';
			
			
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
			$this->template->write_view('center',$theme .'/layout/video/add_video',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				
			if($this->input->post('video_id')!='')
			{	
				$this->video_model->video_update();
				$msg = "update";
			}else{
				$this->video_model->video_insert();			
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
		 	
			 
			if($redirect_page == 'list_video')
			{
				redirect('video/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			else
			{
				redirect('video/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	
	// Use :This function use for edit of update video.
	// Param :video id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function edit_video($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
		
		$check_rights=get_rights('add_video');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$data['category'] = $this->video_model->get_category();
		
		$one_user = $this->video_model->get_one_video($id);
		//print_r($one_user); die;
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		$data["video_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		$data["video_title"] = $one_user['video_title'];
		$data["video_desc"] = $one_user['video_desc'];
		$data["video_file_name"] =$one_user['video_file_name'];
		$data["video_category_id"] = $one_user['video_category_id'];
		$data["video_price"] = $one_user['video_price'];
		$data["video_preview"] = $one_user['video_preview'];
		$data["video_type"] = $one_user['video_type'];
		$data["video_type"] = $one_user['video_type'];
		$data['status']=$one_user['video_status'];
		$data['image']=$one_user['video_image'];
		
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/video/add_video',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}

	// Use :This function use for Delete video.
	// Param :video id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function delete_video($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*   
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_video');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
         $data_log = array("activity_name" => "LOG_DELETE_ADMIN");
         maintain_log($data_log);
		//$this->db->delete('rights_assign',array('video_id'=>$id));
		$this->db->delete('video',array('video_id'=>$id));
		if($redirect_page == 'list_video')
		{
			
			redirect('video/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('video/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
        
        /// common function for insert all action//
           $data_log = array("activity_name" => "LOG_DELETE_ADMIN");
           maintain_log($data_log);
	}
	
	
	// Use :This function use for change status or delete video.
	// Param :'N/a'
	// Return :'N/A'
	function action_video()
	{
		/* Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('action_video');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword = $this->input->post('serach_keyword');
		
		$video_id =$this->input->post('chk');
		
		if($action=='delete')
		{
             /// common function for insert all action//
           $data_log = array("activity_name" => "LOG_DELETE_ADMIN");
           maintain_log($data_log);
               
                		
			foreach($video_id as $id)
			{			
				$this->db->query("delete from ".$this->db->dbprefix('video')." where video_id ='".$id."'");
			}
			
			if($redirect_page == 'list_video')
			{
				redirect('video/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('video/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
            //Log Entry	
            //echo  "mkjmkj"; die;	
           $data_log = array("activity_name" => "LOG_ACTIVE_ADMIN");
           maintain_log($data_log);    
                		
			foreach($video_id as $id)
			{			
				$data = array('video_status'=>'active');
				$this->db->where('video_id',$id);
				$this->db->update('video', $data);
			}
			if($redirect_page == 'list_video')
			{
				redirect('video/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('video/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive')
		{
		  //Log Entry        
           $data_log = array("activity_name" => "LOG_INACTIVE_ADMIN");
           maintain_log($data_log);   
                		
			foreach($video_id as $id)
			{			
				$data = array('video_status'=>'inactive');
				$this->db->where('video_id',$id);
				$this->db->update('video', $data);
			}
			
			if($redirect_page == 'list_video')
			{
				redirect('video/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('video/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');

			}
		}	
		
	}

  
    
	
}


?>