<?php
class Forum extends  CI_Controller {
	function Forum()
	{
		 parent::__construct();	
		$this->load->model('forum_model');
		
	}
	
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('forum/list_forum');
		
		$check_rights=get_rights('list_forum');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
	}
	
	// Use :This function use for Lost all forum User.
	// Param :limit,offset,message
	// Return :'N/A'
	function list_forum($limit='10',$offset=0,$msg='')
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
		
		$check_rights=get_rights('list_forum');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('pagination');

		
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'forum/list_forum/'.$limit.'/';
		$config['total_rows'] = $this->forum_model->get_total_forum_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->forum_model->get_forum_result($offset,$limit);
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
		$data['redirect_page']='list_forum';
	
		
		
		
		
		$data['site_setting'] = site_setting();

		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/forum/list_forum',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for list forum by filter.
	// Param :limit,option,keyword,offset,message
	// Return :'N/A'
	function search_list_forum($limit=20,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$redirect_page = 'search_list_forum';
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('search_list_forum');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$this->load->library('pagination');
		
		if($_POST)
		{		
			$option=$this->input->post('option');
			//$keyword=($this->input->post('keyword')!='')?str_replace(" ", "-",trim($this->input->post('keyword'))):'1V1';
			if($this->input->post('keyword')!=''){ $keyword = $this->input->post('keyword'); } else { $keyword = '1V1'; }
			
		}
		else
		{
			$option=$option;
			$keyword = $keyword;
			//$keyword=str_replace(" ", "-",trim($keyword));	
		
		}
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',trim($keyword)));

	
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'forum/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->forum_model->get_total_search_forum_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->forum_model->get_search_forum_result($option,$keyword,$offset, $limit);
		
		
		if($data['result']==0){
		$offset=0;
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'forum/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->forum_model->get_total_search_forum_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->forum_model->get_search_forum_result($option,$keyword,$offset, $limit);
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
		$this->template->write_view('center',$theme .'/layout/forum/list_forum',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for check unique UserName of forum.
	// Param :UserName
	// Return :Boolean
	function username_check($username)
	{
		$username = $this->forum_model->user_unique($username);
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
	
	
	// Use :This function use for add new forum.
	// Param :'N/A'
	// Return :'N/A'
	
	function add_forum($limit=0)
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
		
		$check_rights=get_rights('add_forum');
		
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
		$this->form_validation->set_rules('topic_name', 'Forum  Topic', 'required');
		$this->form_validation->set_rules('forum_decription', 'Forum  description', 'required');
	
		$this->form_validation->set_rules('status', 'Status', 'required');
			
		
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			
			
			$data["topic_name"] = $this->input->post('topic_name');
			$data["forum_id"] = $this->input->post('forum_id');
			$data["status"] = $this->input->post('forum_status');
			$data["forum_decription"] = $this->input->post('forum_decription');
			$data["forum_category"] = $this->input->post('forum_category');
			$data["forum_meta_title"] = $this->input->post('forum_meta_title');
			$data["forum_meta_keyword"] = $this->input->post('forum_meta_keyword');
			$data["forum_meta_description"] = $this->input->post('forum_meta_description');
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_forum';
			
			
			$data['site_setting'] = site_setting();
			$data["forum_category_list"] = $this->forum_model->get_forum_category();
			
		
			if($this->input->post('offset')=="")
			{
				$limit = '10';
				$data["offset"] = 0;
			}else{
				$data["offset"] = $this->input->post('offset');
			}
			
			
			$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/forum/add_forum',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				$data_insert["topic_name"] = $this->input->post("topic_name");
				$data_insert["status"] = $this->input->post("status");
				$data_insert["forum_category"] = $this->input->post("forum_category");
				$data_insert["forum_decription"] = $this->input->post("forum_decription");
				$data_insert["forum_id"] = $this->input->post("forum_id");
				$data_insert["forum_meta_title"] = $this->input->post('forum_meta_title');
				$data_insert["forum_meta_keyword"] = $this->input->post('forum_meta_keyword');
				$data_insert["forum_meta_description"] = $this->input->post('forum_meta_description');
				
			if($this->input->post('forum_id')!='')
			{
				
					
				$this->forum_model->forum_update($data_insert);
				$msg = "update";
			}else{
				$this->forum_model->forum_insert($data_insert);			
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
		 	
			 
			if($redirect_page == 'list_forum')
			{
				redirect('forum/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			else
			{
				redirect('forum/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	
	// Use :This function use for edit of update forum.
	// Param :forum id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	function view($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0){
		
	
		if(!check_admin_authentication()) {
		redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('view_forum');
				
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//echo $id; die;
		$one_message = $this->forum_model->get_topic($id);
		
	
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		$data["redirect_page"]=$redirect_page;
		
		$data["topic_id"] = $id;
		$data["topic_name"] = $one_message['topic_name'];
		$data["forum_decription"] = $one_message['forum_decription'];
		$data["date_created"] = $one_message['date_created'];
		$data["first_name"] = $one_message['first_name'];
		$data["last_name"] = $one_message['last_name'];
	
		$data["master_id"] = $one_message['master_id'];
		
		
		$data['reply'] = $this->forum_model->get_list($id,$data["master_id"]);
		//print_r($data['reply']); die;
		
		 //update data
	    $data_update = array("forum_id"=>$id);
	    $this->db->where("forum_id",$id);
	    $this->db->update("forum",$data_update);
		//end of update data//
	
		
		if($_POST){
			$this->forum_model->reply_insert($_POST);			
			$msg = "insert"; 
			//echo 'forum/view/'.$limit.'/'.$offset; die;
			 redirect('forum/view/'.$id.'/'.$limit.'/'.$offset.'/'.$msg);
			
		}
		
		$data['total_comment']=$this->forum_model->get_forum_count($id);
		//print_r($data['total']); die;
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/forum/view',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();

	}

	function edit_forum($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
		
		$check_rights=get_rights('edit_forum');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$data["forum_category_list"] = $this->forum_model->get_forum_category();
		
		$one_forum = $this->forum_model->get_one_forum($id);
		//print_r($one_user); die;
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		$data["forum_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		
		$data["topic_name"] = $one_forum['topic_name'];
		
		$data["status"] = $one_forum['status'];
		$data["forum_decription"] = $one_forum['forum_decription'];
		$data["forum_category"] = $one_forum['forum_category'];
		$data["forum_meta_title"] = $one_forum['forum_meta_title'];
		$data["forum_meta_keyword"] = $one_forum['forum_meta_keyword'];
		$data["forum_meta_description"] = $one_forum['forum_meta_description'];
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/forum/add_forum',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}

	// Use :This function use for Delete forum.
	// Param :forum id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function delete_forum($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*   
		 * Future enhancement
		 * when assigning rights is used
		*/
		//echo "mnbjb"; die;
		$check_rights=get_rights('delete_forum');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
     
		$this->db->delete('forum',array('forum_id'=>$id));
		$this->db->delete('forum',array('master_id'=>$id));
	
		if($redirect_page == 'list_forum')
		{
			
			redirect('forum/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('forum/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
        
        /// common function for insert all action//
           $data_log = array("activity_name" => "LOG_DELETE_ADMIN");
           maintain_log($data_log);
	}
	
	
	// Use :This function use for change status or delete forum.
	// Param :'N/a'
	// Return :'N/A'
	function action_forum()
	{
		/* Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('action_forum');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
		
		$forum_id =$this->input->post('chk');
		
		if($action=='delete')
		{
             /// common function for insert all action//
           $data_log = array("activity_name" => "LOG_DELETE_ADMIN");
           maintain_log($data_log);
               
                		
			foreach($forum_id as $id)
			{			
				$this->db->query("delete from ".$this->db->dbprefix('forum')." where forum_id ='".$id."' or master_id ='".$id."' ");
				//echo $this->db->last_query(); die;
			}
			
			if($redirect_page == 'list_forum')
			{
				redirect('forum/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('forum/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
            //Log Entry	
            //echo  "mkjmkj"; die;	
           $data_log = array("activity_name" => "LOG_ACTIVE_ADMIN");
           maintain_log($data_log);    
                		
			foreach($forum_id as $id)
			{			
				$data = array('status'=>'active');
				$this->db->where('forum_id',$id);
				$this->db->update('forum', $data);
			}
			if($redirect_page == 'list_forum')
			{
				redirect('forum/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('forum/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive')
		{
		  //Log Entry        
           $data_log = array("activity_name" => "LOG_INACTIVE_ADMIN");
           maintain_log($data_log);   
                		
			foreach($forum_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('forum_id',$id);
				$this->db->update('forum', $data);
			}
			
			if($redirect_page == 'list_forum')
			{
				redirect('forum/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('forum/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');

			}
		}	
		
	}

  
    
	
}


?>