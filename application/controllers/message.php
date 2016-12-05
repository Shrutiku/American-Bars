<?php
class Message extends SPACULLUS_Controller {
	/*
	 Function name :User()
	 */
	function Message() {
		ini_set("display_errors", 1);
		parent :: __construct ();
	    $this->load->model('message_model');
	}

	public function index ($msg = '') {
		redirect('message/list_user_message');
	}


    function list_user_message($limit=10,$keyword='1V1',$offset=0,$msg='')
	{
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}

		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        // $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		// if($data['getbar']!="" && $data['getbar']['bar_type']=='half_mug')
		// {
			// redirect('home/upgrade');
		// }
		if($this->input->post('event_keyword')!='')
		{
			$keyword= $this->input->post('event_keyword');
			$limit= $this->input->post('limit');
			$offset= $this->input->post('offset');
		}
		else {
			$keyword = $keyword;
			$limit= $limit;
			$offset= $offset;
		}
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'message/list_user_message/'.$limit.'/'.$keyword;
		$config["total_rows"] = $this->message_model->getBarMessagescount();
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->message_model->get_message_result($offset,$limit);
		$data['getalluser'] = get_all_user();
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='list_user_message';
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/bar/bar_message_user_ajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/bar/bar_message_user', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
	}

    function viewconversation_user($message_id='',$msg='')
	{
	  
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		

		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		 $message_id = base64_decode($message_id);
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        //$data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		
	 	$data_update = array("is_read"=>"1");
	    $this->db->where("master_message_id",$message_id);
		$this->db->where("to_user_id",get_authenticateUserID());
	    $this->db->update("message_user",$data_update);
		
		
		$data_update1 = array("is_read"=>"1");
	    $this->db->where("message_id",$message_id);
	    $this->db->update("message_user",$data_update1);
		$one_message = $this->message_model->get_one_message($message_id);
		
		$data["message_id"] = $message_id;
		$data["subject"] = $one_message['subject'];
		$data["description"] = $one_message['description'];
		$data["from_user_id"] = $one_message['from_user_id'];
		$data["from_user_type"] = $one_message['from_user_type'];
    	$data["to_user_id"] = $one_message['to_user_id'];
		$data["to_user_type"] = $one_message['to_user_type'];
		$data["date_added"] = $one_message['date_added'];
		$data["is_read"] = $one_message['is_read'];
		$data["master_message_id"] = $one_message['master_message_id'];
		$data["description"] = $one_message['description'];
		$data["is_deleted"] = $one_message['is_deleted'];
		
		$data['redirect_page']='list_user_message';
		
		$data['result'] = $this->message_model->get_message_conversation($message_id);
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/bar/messageconversation_user', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
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
		$pim=(isset($userDetail->profile_image) && $userDetail->profile_image!='' && file_exists(base_path().'upload/user/'.$userDetail->profile_image))?base_url().'upload/user/'.$userDetail->profile_image:base_url().'upload/user/no_image.png';
		
		$ntime=date('Y-m-d H:i:s');
		
		$sql="select * FROM ".$this->db->dbprefix('message_user')." WHERE `master_message_id` =  ".$ticket_id."  and from_user_id!=".get_authenticateUserID()." and date_added between '".$ctime."' and '".$ntime."' order by date_added asc";
		$gd=$this->db->query($sql);
	  
		$data['userInfo']=$userDetail;
		$data['pim']=$pim;
		
		if($gd->num_rows()>0){
		$data['ticketConv']=$gd->result();
		$res=array('html'=> $this->load->view($theme .'/bar/ticketConversationAjax_user',$data,TRUE),'status'=>'success','ntime'=>$ntime);
		}else{
			$res=array('status'=>'fail','result'=>'','ntime'=>$ntime);
		}
		echo json_encode($res);die;
	}

    function postConversationReply()
	{
		//echo $this->input->post('from_user_id')
		if($this->input->post('to_user_id')==get_authenticateUserID())
		{
			$toid = $this->input->post('user_id');
		}
		else {
			$toid = $this->input->post('to_user_id');
		}
		$array=array(
		'master_message_id'=>$this->input->post('ticket_id'),
		'from_user_id'=>get_authenticateUserID(),
		'from_user_type'=>'sender',
		'to_user_type'=>'reciever',
		'description'=>$this->input->post('comment'),
		'to_user_id'=>$toid,
		'date_added'=>date('Y-m-d H:i:s'));
		
		// print_r($array);
		// die;
		$this->db->insert('message_user',$array);
		
		echo json_encode($array);die;
	}

	

 	function send_new_message($bar_id='')
	{
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		$this->form_validation->set_rules('to_user_id', 'User', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$data["error"] = '';
		$data["msg"] = '';
		
		//$bar_detail = $this->message_model->get_one_bar(base64_decode($bar_id));
		
		if($this->form_validation->run() == FALSE)
		{			
				if(validation_errors())
				{
					$data["error"] = validation_errors();
				}else{
					$data["error"] = "";
				}
				$data["subject"] = $this->input->post('subject');
				$data["user_id"] = $this->input->post('user_id');
				$data["description"] = $this->input->post('description');
		}
		else {
			    $this->message_model->message_send(base64_decode($bar_id));			
				$data["msg"] = "success";	
		}
		
		if($data["error"] !="")
		{
			$response = array("comment_error"=>$data["error"],"status"=>"fail");
			echo json_encode($response);
		    die;
		}
		
		if($data["msg"] == "success")
		{
			$response = array("status"=>"success");
			echo json_encode($response);
		    die;
		}
	}

   function removemessage()
	{
			
		$this->db->where('message_id',$this->input->post('id'))->delete('message_user');
		$this->db->where('master_message_id',$this->input->post('id'))->delete('message_user');
		$res=array('status'=>'done');
		echo json_encode($res);die;
			
	}
	
	function get_user_list(){	
	
	 
		$operator_list 	 = $this->message_model->get_user_list($_REQUEST['em']);
		$arr = array();	
		if($operator_list){
		foreach($operator_list as $key=>$val){
			$arr[] = array("id"=>$val['user_id'],"label"=>$val['first_name'].' '.$val['last_name'].' ['.$val['user_type'].']',"value"=>$val['first_name']." ".$val['last_name']); 
		}
		}
		print_r(json_encode($arr));die;
	}	
}
?>