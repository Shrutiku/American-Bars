<?php
class Message extends  CI_Controller {
	function message() {
		 parent::__construct();	
		$this->load->model('message_model');	
		date_default_timezone_set("Europe/London"); 
	}
	
	function index() {
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('message/list_message');	
	}
	
	// Use :This function use for Lost all message.
	// Param :limit,offset,message
	// Return :'N/A'
	function list_message($limit='10',$offset=0,$msg='') {
		
		if(!check_admin_authentication()) {
			redirect('home');
		}
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		 /* 
		 * Future enhancement
		 * when assigning rights is used
		 */
		
		$check_rights=get_rights('list_message');
		
		if(	$check_rights==0) {			
		redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('pagination');

		$config['uri_segment']='4';
		$config['base_url'] = base_url().'message/list_message/'.$limit.'/';
		$config['total_rows'] = $this->message_model->get_total_message_count();
	    
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		//echo $data['page_link'];die;
		
		$to_user_id[] = "";
		$from_user_id = "";
		
		$data['result'] = $this->message_model->get_message_result($offset, $limit);
		
	
		
		$data['msg'] = $msg;
		$data['offset'] = $offset;
		if($this->input->post('limit') != '') {
			$data['limit']=$this->input->post('limit');
		} else {
			$data['limit']=$limit;
		}
		$data['option']='1V1';
		$data['keyword']='1V1';
		$data['serach_option']='1V1';
		$data['serach_keyword']='1V1';
		$data['search_type']='normal';
		$data['redirect_page']='list_message';
		
		$data['site_setting'] = site_setting();
	
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/message/list_message',$data,TRUE);
		
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for list message by filter.
	// Param :limit,option,keyword,offset,message
	// Return :'N/A'
	function search_list_message($limit=20,$option='',$keyword='',$offset=0,$msg=''){
		if(!check_admin_authentication()){
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_message';
		/* 
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('search_list_message');
 		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('pagination');
		if($_POST)
		{		
			$option=$this->input->post('option');
			$keyword=$this->input->post('keyword');
		}
		else
		{
			$option=$option;
			$keyword=$keyword;			
		}
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',trim($keyword)));
	
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'message/search_list_message/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->message_model->get_total_search_message_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->message_model->get_search_message_result($option,$keyword,$offset, $limit);
		$data['msg'] = $msg;
		$data['offset'] = $offset;
		
		//$data['statelist']=$this->project_category_model->get_state();
		
		$data['site_setting'] = site_setting();
		
		$data['limit']=$limit;
		$data['option']=$option;
		$data['keyword']=$keyword;
		$data['search_type']='search';
		$data['redirect_page']=$redirect_page;
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/message/list_message',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	/* ----------------------------- Sent box code start ---------------------- */
	
	
	function sent_message($limit='10',$offset=0,$msg='') {
		
		if(!check_admin_authentication()) {
			redirect('home');
		}
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/* 
		* Future enhancement
		* when assigning rights is used
		*/
		
		$check_rights=get_rights('sent_message');
		
		if(	$check_rights==0) {			
		redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('pagination');

		$config['uri_segment']='4';
		$config['base_url'] = base_url().'message/sent_message/'.$limit.'/';
		$config['total_rows'] = $this->message_model->get_total_sent_message_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$to_user_id[] = "";
		$from_user_id = "";
		
		$data['result'] = $this->message_model->get_sent_message_result($offset, $limit);
		
		$data['msg'] = $msg;
		$data['offset'] = $offset;
		if($this->input->post('limit') != '') {
			$data['limit']=$this->input->post('limit');
		} else {
			$data['limit']=$limit;
		}
		$data['option']='1V1';
		$data['keyword']='1V1';
		$data['serach_option']='1V1';
		$data['serach_keyword']='1V1';
		$data['search_type']='normal';
		$data['redirect_page']='sent_message';
		
		$data['site_setting'] = site_setting();
	
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/message/sent_message',$data,TRUE);
		
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for list message by filter.
	// Param :limit,option,keyword,offset,message
	// Return :'N/A'
	function search_sent_message($limit=20,$option='',$keyword='',$offset=0,$msg=''){
		if(!check_admin_authentication()){
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_message';
		/* 
		 * Future enhancement
		 * when assigning rights is used
		 */
		 
		 $check_rights=get_rights('search_sent_message');
 		
		 if( $check_rights==0) {			
			 redirect('home/dashboard/no_rights');	
		 }
		
		$this->load->library('pagination');
		if($_POST)
		{		
			$option=$this->input->post('option');
			$keyword=$this->input->post('keyword');
		}
		else
		{
			$option=$option;
			$keyword=$keyword;			
		}
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',trim($keyword)));
	
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'message/search_sent_message/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->message_model->get_total_search_sent_message_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->message_model->get_search_sent_message_result($option,$keyword,$offset, $limit);
		$data['msg'] = $msg;
		$data['offset'] = $offset;
		
		//$data['statelist']=$this->project_category_model->get_state();
		
		$data['site_setting'] = site_setting();
		
		$data['limit']=$limit;
		$data['option']=$option;
		$data['keyword']=$keyword;
		$data['search_type']='search';
		$data['redirect_page']=$redirect_page;
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/message/sent_message',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	/* ----------------------------- Sent box code end ------------------------- */


	// Use :This function use for check unique message Name.
	// Param :message name
	// Return :Boolean
	
	function message_check($message_name){
		$message_name = $this->message_model->message_unique($message_name);
		if($message_name == TRUE) {
			return TRUE;
		} else {
			$this->form_validation->set_message('message_check', EXIST_message);
			return FALSE;
		}
	}
	
	
	// Use :This function use for add new message.
	// Param :'N/A'
	// Return :'N/A'
	
	function add_message($limit="20"){
		
		if(!check_admin_authentication()){
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/*
		 *Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('add_message');
				
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('form_validation');	
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		$this->form_validation->set_rules('to_user_id', 'User', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			
			$data["message_id"] = $this->input->post('message_id');
			$data["subject"] = $this->input->post('subject');
			$data["description"] = $this->input->post('description');
			$data["from_user_id"] = $this->input->post('from_user_id');
			$data["from_user_type"] = $this->input->post('from_user_type');
			$data["to_user_id"] = $this->input->post('to_user_id');
			$data["to_user_type"] = $this->input->post('to_user_type');
			$data["is_read"] = $this->input->post('is_read');
			$data["reply_message_id"] = $this->input->post('reply_message_id');
		    $data["is_deleted"] = $this->input->post('is_delete');
			$data["status"] = $this->input->post('status');
			$data["ip_address"] = $_SERVER['REMOTE_ADDR'];
			
			$data["admin_id"] = $this->session->userdata("admin_id");
			$data["admin_type"] = $this->session->userdata("admin_type");
						
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_message';	
					
			$data['site_setting'] = site_setting();
		//	$data['doctor_list'] = get_doctor_list();
			
			if($this->input->post('offset')==""){
				//$limit = '10';
				$data["offset"] = 0;
			}else{
				$data["offset"] = $this->input->post('offset');
			}
			$data['limit']=$limit;
			$data["offset"]=0;
			
			$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/message/add_message',$data,TRUE);
			$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
			if($this->input->post('message_id')!=''){
				$this->message_model->message_update();
				$msg = "update";
			}else{
				$this->message_model->message_insert();			
				$msg = "insert";
			}
			$offset = $this->input->post('offset');
			$limit=$this->input->post('limit');
			
			if($limit == 0) {
				$limit = 20;
			} else {
				$limit = $limit;
			}
						
			$redirect_page = $this->input->post('redirect_page');
			$option = $this->input->post('option');
			$keyword = $this->input->post('keyword');
		 	
			 
			if($redirect_page == 'list_message') {
				redirect('message/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			} else {
				redirect('message/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
			
		}				
	}


	// Use :This function use for edit of update message.
	// Param :message id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function edit_message($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0){
		
		if(!check_admin_authentication()) {
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('edit_message');
				
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_message = $this->message_model->get_one_message($id);
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		$data["redirect_page"]=$redirect_page;
		
		$data["message_id"] = $id;
		$data["subject"] = $one_message['subject'];
		$data["description"] = $one_message['description'];
		$data["from_user_id"] = $one_message['from_user_id'];
		$data["from_user_type"] = $one_message['from_user_type'];
		$data["to_user_id"] = $one_message['to_user_id'];
		$data["to_user_type"] = $one_message['to_user_type'];
		$data["is_read"] = $one_message['is_read'];
		$data["reply_message_id"] = $one_message['reply_message_id'];
		$data["is_deleted"] = $one_message['is_delete'];
		$data["status"] = $one_message['status'];
		$data["ip_address"] = $_SERVER['REMOTE_ADDR'];
		
		$data["doctor_id"] = $one_message['doctor_id'];
		$data["description"] = $one_message['description'];
		$data["is_deleted"] = $one_message['is_deleted'];
		$data["status"] = $one_message['status'];
		
		$data['site_setting'] = site_setting();
		$data['doctor_list'] = get_doctor_list();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/message/add_message',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	function reply_message_orig($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0){
		
	
		if(!check_admin_authentication()) {
		redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('reply_message_orig');
				
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
	
		$one_message = $this->message_model->get_one_message($id);
	
	
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		$data["redirect_page"]=$redirect_page;
		
		$data["message_id"] = $id;
		$data["subject"] = $one_message['subject'];
		$data["description"] = $one_message['description'];
		$data["from_user_id"] = $one_message['from_user_id'];
		$data["from_user_type"] = $one_message['from_user_type'];
    	$data["to_user_id"] = $one_message['to_user_id'];
		
		$data["to_user_type"] = $one_message['to_user_type'];
		$data["is_read"] = $one_message['is_read'];
		$data["master_message_id"] = $one_message['master_message_id'];
		//$data["is_deleted"] = $one_message['is_delete'];
		$data["ip_address"] = $_SERVER['REMOTE_ADDR'];
		
		$data["admin_id"] = $this->session->userdata('admin_id');
		$data["admin_type"] = $this->session->userdata('admin_type');
		
		$data["description"] = $one_message['description'];
		$data["is_deleted"] = $one_message['is_deleted'];
		//$data["status"] = $one_message['status'];
		$data['site_setting'] = site_setting();
		//$data['doctor_list'] = get_doctor_list();
	
		$data['reply'] = $this->message_model->get_reply_message_list($one_message['message_id'],$data["master_message_id"]);
		
		//update data
	    $data_update = array("is_read"=>"1");
	    $this->db->where("message_id",$id);
	    $this->db->update("message",$data_update);
		//end of update data//
	
		
		if($_POST){
			$this->message_model->reply_insert();			
			$msg = "insert";
			
			redirect('message/'.$redirect_page.'/'.$limit.'/'.$offset.'/send');
		}
		
	   $this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/message/reply_message',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}

	function reply_message($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0){
		
		if(!check_admin_authentication()) {
		redirect('home');
		}
		$checkid =  checkexist('message',$dat=array('message_id'=>$id));
		if($checkid==0)
		{
			redirect('bar/list_message');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('reply_message');
				
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
	   
		$one_message = $this->message_model->get_one_message($id);
	
	
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		$data["redirect_page"]=$redirect_page;
		
		$data["message_id"] = $id;
		$data["subject"] = $one_message['subject'];
		$data["description"] = $one_message['description'];
		$data["from_user_id"] = $one_message['from_user_id'];
		$data["from_user_type"] = $one_message['from_user_type'];
    	$data["to_user_id"] = $one_message['to_user_id'];
		
		$data["to_user_type"] = $one_message['to_user_type'];
		$data["is_read"] = $one_message['is_read'];
		$data["master_message_id"] = $one_message['master_message_id'];
		//$data["is_deleted"] = $one_message['is_delete'];
		$data["ip_address"] = $_SERVER['REMOTE_ADDR'];
		
		$data["admin_id"] = $this->session->userdata('admin_id');
		$data["admin_type"] = $this->session->userdata('admin_type');
		
		$data["description"] = $one_message['description'];
		$data["is_deleted"] = $one_message['is_deleted'];
		//$data["status"] = $one_message['status'];
		$data['site_setting'] = site_setting();
		//$data['doctor_list'] = get_doctor_list();
	
		$data['reply'] = $this->message_model->get_reply_message_list($one_message['message_id'],$data["master_message_id"]);
		
		$data['oneTickets'] =$this->message_model->get_one_message($id);
		$data['ticketConversation']=  $this->message_model->get_reply_message_list($one_message['message_id'],$data["master_message_id"]);
		
		
	    
		//update data
	    $data_update = array("is_read"=>"1");
	    $this->db->where("message_id",$id);
	    $this->db->update("message",$data_update);
		//end of update data//
	
		
		if($_POST){
			$this->message_model->reply_insert();			
			$msg = "insert";
			
			redirect('message/'.$redirect_page.'/'.$limit.'/'.$offset.'/send');
		}
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/message/reply_message',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	// Use :This function use for Delete message.
	// Param :message id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	function delete_message($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
	
		$this->db->delete('message',array('message_id'=>$id));
		if($redirect_page == 'list_message'){	
			redirect('message/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		} else {
			redirect('message/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');
		}
	}
	
	// Use :This function use for Delete message.
	// Param :message id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	function delete_boradcast_message($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		$this->db->delete('broadcast_message',array('number'=>$id));
		if($redirect_page == 'list_broadcast_message'){	
			redirect('message/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		} else {
			redirect('message/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');
		}
	}
	
	function delete_push_notification($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		$this->db->delete('push_message',array('number'=>$id));
		if($redirect_page == 'list_push_notification'){	
			redirect('message/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		} else {
			redirect('message/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');
		}
	}
	
	
	function delete_sent_message($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*
		 *  Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_message');
        
        //Log Entry    
            $data_log = array("activity_name" => "LOG_DELETE_MESSAGE");
            maintain_log($data_log); 
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		// $data = array(
		   // 'is_deleted' => '1'
		// );
// 		
		// $this->db->where('message_id', $id);
		// $this->db->update('message', $data);
		
		$this->db->delete('message',array('message_id'=>$id));
		if($redirect_page == 'sent_message'){	
			redirect('message/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		} else {
			redirect('message/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');
		}
	}
	
	
	// Use :This function use for change status or delete message.
	// Param :'N/a'
	// Return :'N/A'
	
	function action_message()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
	
		
		$offset=$this->input->post('offset');
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		$message_id =$this->input->post('chk');
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
			
		if($action=='delete')
		{
		    //Log Entry    
            $data_log = array("activity_name" => "LOG_DELETE_MESSAGE");
            maintain_log($data_log); 
            		
			foreach($message_id as $id) {
				// $data = array(
				   // 'is_deleted' => '1'
				// );
				// $this->db->where('message_id', $id);
				// $this->db->update('message', $data);			
				
				$this->db->query("delete from ".$this->db->dbprefix('message')." where message_id ='".$id."'");
			}
			
			if($redirect_page == 'list_message') {	
				redirect('message/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			} else {
				redirect('message/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');
			}
		}
			
		if($action=='active')
		{
		    //Log Entry    
            $data_log = array("activity_name" => "LOG_ACTIVE_MESSAGE");
            maintain_log($data_log); 
            		
			foreach($message_id as $id)
			{			
				$data = array('status'=>'active');
				$this->db->where('message_id',$id);
				$this->db->update('message', $data);
			}
			if($redirect_page == 'list_message')
		{
			
			redirect('message/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
		}
		else
		{
			redirect('message/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');

		}
		}	
		if($action=='inactive')
		{
		    
              //Log Entry    
            $data_log = array("activity_name" => "LOG_INACTIVE_MESSAGE");
            maintain_log($data_log); 
            		
			foreach($message_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('message_id',$id);
				$this->db->update('message', $data);
			}
			
				if($redirect_page == 'list_message')
		{
			
			redirect('message/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
		}
		else
		{
			redirect('message/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');
		}			
		}
	}

	// Use :This function use for change status or delete message.
	// Param :'N/a'
	// Return :'N/A'
	
	function action_broadcast_message()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
	
		
		$offset=$this->input->post('offset');
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		$message_id =$this->input->post('chk');
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword = $this->input->post('serach_keyword');
			
		if($action=='delete')
		{
		    //Log Entry    
            $data_log = array("activity_name" => "LOG_DELETE_MESSAGE");
            maintain_log($data_log); 
            		
			foreach($message_id as $id) {
				// $data = array(
				   // 'is_deleted' => '1'
				// );
				// $this->db->where('message_id', $id);
				// $this->db->update('message', $data);			
				
				$this->db->query("delete from ".$this->db->dbprefix('broadcast_message')." where number ='".$id."'");
			}
			
			if($redirect_page == 'list_broadcast_message') {	
				redirect('message/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			} else {
				redirect('message/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');
			}
		}
			
	
		
	}

function action_push_notification()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
	
		
		$offset=$this->input->post('offset');
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		$message_id =$this->input->post('chk');
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword = $this->input->post('serach_keyword');
			
		if($action=='delete')
		{
		    //Log Entry    
            $data_log = array("activity_name" => "LOG_DELETE_MESSAGE");
            maintain_log($data_log); 
            		
			foreach($message_id as $id) {
				// $data = array(
				   // 'is_deleted' => '1'
				// );
				// $this->db->where('message_id', $id);
				// $this->db->update('message', $data);			
				
				$this->db->query("delete from ".$this->db->dbprefix('push_message')." where number ='".$id."'");
			}
			
			if($redirect_page == 'list_push_notification') {	
				redirect('message/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			} else {
				redirect('message/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');
			}
		}
			
	
		
	}
	
	function get_user_list(){	
	
	 
		$operator_list 	 = $this->message_model->get_user_list($_REQUEST["utype"],$_REQUEST['em']);
			
		$arr = array();	
		if($operator_list){
		foreach($operator_list as $key=>$val){
			
			$arr[] = array("id"=>$val['user_id'],"label"=>$val['email'],"value"=>$val['email']."#".$_REQUEST["utype"]); 
		}
		}
			echo json_encode($arr);die;
	}
	
	function getAllUser()
	{
		$operator_list 	 = $this->message_model->getAllUser($this->input->post('type'));
		$str = '';
		if(!empty($operator_list))
		{
			if($this->input->post('type')=='user')
			{
			$str.='<label class="checkbox span4 no-margin"><input type="checkbox" name="select" id="selectAll" value="All" />Select All</label><div class="clearfix"></div>';
		foreach($operator_list as $r)
		  {
		  			
						$str.='<label class="checkbox wid228 pull-left"><input type="checkbox" id="email" name="email_user[]" value="'.$r->email.'" />'.$r->email.'</label>';		
		  	 
		  }
			}
			
			if($this->input->post('type')=='bar_owner')
			{
			$str.='<label class="checkbox span4 no-margin"><input type="checkbox" name="select" id="selectAll_bar" value="All" />Select All</label><div class="clearfix"></div>';
		foreach($operator_list as $r)
		  {
		  			
						$str.='<label class="checkbox wid228 pull-left"><input type="checkbox" id="email" name="email_bar[]" value="'.$r->email.'" />'.$r->email.'</label>';		
		  	 
		  }
			}
			
			if($this->input->post('type')=='taxi_owner')
			{
			$str.='<label class="checkbox span4 no-margin"><input type="checkbox" name="select" id="selectAll_taxi" value="All" />Select All</label><div class="clearfix"></div>';
		foreach($operator_list as $r)
		  {
		  			
						$str.='<label class="checkbox wid228 pull-left"><input type="checkbox" id="email" name="email_taxi[]" value="'.$r->email.'" />'.$r->email.'</label>';		
		  	 
		  }
			}
	   }
		echo $str;
		die;
	}
	
	function get_message_view(){
		$message_id = $this->input->get('message_id');
		$message_detail = $this->message_model->get_one_message($message_id);
		$data = array();
		
	    //update data
	    $data_update = array("is_read"=>"1");
	    $this->db->where("message_id",$message_id);
	    $this->db->update("message",$data_update);
		//end of update data//
		$data['site_setting'] = site_setting();
		$data['message_detail'] = $message_detail;
		$data['msg_type'] = $this->input->get('msg_type');
		
		$theme = getThemeName();
		echo $this->load->view($theme.'/layout/message/view_message', $data);
	}
	
	function get_broadcast_message_view(){
		$message_id = $this->input->get('message_id');
		$message_detail = $this->message_model->get_one_broadcast_message($message_id);
		$data = array();
		
	    //update data
		$data['site_setting'] = site_setting();
		$data['message_detail'] = $message_detail;
		
		$theme = getThemeName();
		echo $this->load->view($theme.'/layout/message/view_broadcast_message', $data);
	}
	
	function postConversationReply()
	{
		//print_r($_POST);die;
		$array=array('from_user_type'=>'admin',
		'to_user_type'=>'user',
		'master_message_id'=>$this->input->post('Tickets_id'),
		'from_user_id'=>get_authenticateadminID(),
		'description'=>$this->input->post('comment'),
		'to_user_id'=>$this->input->post('to_user_id'),
		'date_added'=>date('Y-m-d H:i:s'));
		$this->db->insert('message',$array);
		
		echo json_encode($array);die;
	}
	
	function getTicketCommentAjax()
	{
		//print_r($_POST);die;
		$replyBy=$this->input->post('replyBy');
		$ticket_id=$this->input->post('ticket_id');
		$ctime=$this->input->post('ctime');
		$user_id=$this->input->post('user_id');
		$theme = getThemeName();
		$userDetail=get_user_name($user_id);
		$pim=(isset($userDetail->profile_image) && $userDetail->profile_image!='' && file_exists(base_path().'upload/user_thumb/'.$userDetail->profile_image))?front_base_url().'upload/user_thumb/'.$userDetail->profile_image:front_base_url().'upload/no-image.png';
		
		$ntime=date('Y-m-d H:i:s');
		
		$sql="select * FROM ".$this->db->dbprefix('message')." WHERE (`from_user_id` =  ".$this->input->post('to_user_id')." OR `from_user_id` =  ".$this->input->post('user_id').") and from_user_type='user' and date_added between '".$ctime."' and '".$ntime."' order by date_added asc";
		
		
		$gd=$this->db->query($sql);
		
		$data['userInfo']=$userDetail;
		$data['pim']=$pim;
		
		if($gd->num_rows()>0){
		$data['ticketConv']=$gd->result();
		$res=array('html'=> $this->load->view($theme .'/layout/message/ticketConversationAjax',$data,TRUE),'status'=>'success','ntime'=>$ntime);
		}else{
			$res=array('status'=>'fail','result'=>'','ntime'=>$ntime);
		}
		echo json_encode($res);die;
	}
	
	
	function list_broadcast_message($limit='10',$offset=0,$msg='') {
		
		if(!check_admin_authentication()) {
			redirect('home');
		}
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		 /* 
		 * Future enhancement
		 * when assigning rights is used
		 */
		
		$check_rights=get_rights('list_broadcast_message');
		
		if(	$check_rights==0) {			
		redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('pagination');

		$config['uri_segment']='4';
		$config['base_url'] = base_url().'message/list_broadcast_message/'.$limit.'/';
		$config['total_rows'] = $this->message_model->get_total_broadcast_message_count();
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		//echo $data['page_link'];die;
		
		$to_user_id[] = "";
		$from_user_id = "";
		
		$data['result'] = $this->message_model->get_broadcast_message_result($offset, $limit);
		
		// echo "<pre>";
		// print_r($data['result']);
		// die;
	
		
		$data['msg'] = $msg;
		$data['offset'] = $offset;
		if($this->input->post('limit') != '') {
			$data['limit']=$this->input->post('limit');
		} else {
			$data['limit']=$limit;
		}
		$data['option']='1V1';
		$data['keyword']='1V1';
		$data['serach_option']='1V1';
		$data['serach_keyword']='1V1';
		$data['search_type']='normal';
		$data['redirect_page']='list_broadcast_message';
		
		$data['site_setting'] = site_setting();
	
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/message/list_broadcast_message',$data,TRUE);
		
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for add new message.
	// Param :'N/A'
	// Return :'N/A'
	
	function add_broadcast_message($limit="20"){
		
		if(!check_admin_authentication()){
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/*
		 *Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('add_message');
				
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('form_validation');	
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		$this->form_validation->set_rules('to_user_id', 'User', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		
		$data['operator_list_user'] 	 = $this->message_model->getAllUser('user');
		$data['operator_list_bar_owner'] 	 = $this->message_model->getAllUser('bar_owner');
		$data['operator_list_taxi_owner'] 	 = $this->message_model->getAllUser('taxi_owner');
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			
			$data["message_id"] = $this->input->post('message_id');
			$data["subject"] = $this->input->post('subject');
			$data["description"] = $this->input->post('description');
			$data["from_user_id"] = $this->input->post('from_user_id');
			$data["from_user_type"] = $this->input->post('from_user_type');
			$data["to_user_id"] = $this->input->post('to_user_id');
			$data["to_user_type"] = $this->input->post('to_user_type');
			$data["reply_message_id"] = $this->input->post('reply_message_id');
		    $data["is_deleted"] = $this->input->post('is_delete');
			$data["status"] = $this->input->post('status');
			$data["ip_address"] = $_SERVER['REMOTE_ADDR'];
			
			$data["admin_id"] = $this->session->userdata("admin_id");
			$data["admin_type"] = $this->session->userdata("admin_type");
						
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_broadcast_message';	
					
			$data['site_setting'] = site_setting();
		//	$data['doctor_list'] = get_doctor_list();
			
			if($this->input->post('offset')==""){
				//$limit = '10';
				$data["offset"] = 0;
			}else{
				$data["offset"] = $this->input->post('offset');
			}
			$data['limit']=$limit;
			$data["offset"]=0;
			
			$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/message/add_broadcast_message',$data,TRUE);
			$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
			
				$this->message_model->broadcast_message_insert();	
				$msg = "insert";
			$offset = $this->input->post('offset');
			$limit=$this->input->post('limit');
			
			if($limit == 0) {
				$limit = 20;
			} else {
				$limit = $limit;
			}
						
			$redirect_page = $this->input->post('redirect_page');
			$option = $this->input->post('option');
			$keyword = $this->input->post('keyword');
		 	
			 
			if($redirect_page == 'list_broadcast_message') {
				redirect('message/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			} else {
				redirect('message/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
			
		}				
	}

function test(){
		$data = array();
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/*
		 *Future enhancement
		 * when assigning rights is used
		*/
		
			
			$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/common/test',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
	}

	function list_push_notification($limit='10',$offset=0,$msg='') {
		
		if(!check_admin_authentication()) {
			redirect('home');
		}
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		 /* 
		 * Future enhancement
		 * when assigning rights is used
		 */
		
		$check_rights=get_rights('list_push_notification');
		
		if(	$check_rights==0) {			
		redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('pagination');

		$config['uri_segment']='4';
		$config['base_url'] = base_url().'message/list_push_notification/'.$limit.'/';
		$config['total_rows'] = $this->message_model->get_total_push_message_count();
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		//echo $data['page_link'];die;
		
		$to_user_id[] = "";
		$from_user_id = "";
		
		$data['result'] = $this->message_model->get_push_message_result($offset, $limit);
		
		// echo "<pre>";
		// print_r($data['result']);
		// die;
	
		
		$data['msg'] = $msg;
		$data['offset'] = $offset;
		if($this->input->post('limit') != '') {
			$data['limit']=$this->input->post('limit');
		} else {
			$data['limit']=$limit;
		}
		$data['option']='1V1';
		$data['keyword']='1V1';
		$data['serach_option']='1V1';
		$data['serach_keyword']='1V1';
		$data['search_type']='normal';
		$data['redirect_page']='list_push_notification';
		
		$data['site_setting'] = site_setting();
	
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/message/list_push_message',$data,TRUE);
		
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for add new message.
	// Param :'N/A'
	// Return :'N/A'
	
	function send_push_notification($limit="20"){
		
		if(!check_admin_authentication()){
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/*
		 *Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('add_message');
				
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('form_validation');	
		$this->form_validation->set_rules('description', 'Description', 'required');
		
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			
			$data["message_id"] = $this->input->post('message_id');
			$data["description"] = $this->input->post('description');
			$data["status"] = $this->input->post('status');
			
						
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_push_notification';	
					
			$data['site_setting'] = site_setting();
		//	$data['doctor_list'] = get_doctor_list();
			
			if($this->input->post('offset')==""){
				//$limit = '10';
				$data["offset"] = 0;
			}else{
				$data["offset"] = $this->input->post('offset');
			}
			$data['limit']=$limit;
			$data["offset"]=0;
			
			$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/message/add_push_message',$data,TRUE);
			$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
			
				$this->message_model->push_message_insert();	
				$msg = "insert";
			$offset = $this->input->post('offset');
			$limit=$this->input->post('limit');
			
			if($limit == 0) {
				$limit = 20;
			} else {
				$limit = $limit;
			}
						
			$redirect_page = $this->input->post('redirect_page');
			$option = $this->input->post('option');
			$keyword = $this->input->post('keyword');
		 	
			 
			if($redirect_page == 'list_push_notification') {
				redirect('message/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			} else {
				redirect('message/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
			
		}				
	}
}
?>