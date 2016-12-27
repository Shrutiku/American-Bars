<?php
class Divebar_findout extends  CI_Controller {
	function Divebar_findout()
	{
	    
		parent::__construct();	
		$this->load->model('divebar_findout_model');
		
	}
	
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('divebar_findout/list_divebar_findout');
		
		$check_rights=get_rights('list_divebar_findout');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
	}
	
	// Use :This function use for Lost all divebar_findout of User.
	// Param :limit,offset,message
	// Return :'N/A'
	function list_divebar_findout($limit='10',$offset=0,$msg='')
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
		
		$check_rights=get_rights('list_divebar_findout');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('pagination');

		//$data['user_id']=$user_id;
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'divebar_findout/list_divebar_findout/'.$limit.'/';
		$config['total_rows'] = $this->divebar_findout_model->get_total_admin_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
       // $data['user_id']=$user_id;
		
		$data['result'] = $this->divebar_findout_model->get_divebar_findout_result($offset,$limit);
        
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
		$data['redirect_page']='list_divebar_findout';
		
		$data['site_setting'] = site_setting();

		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/divebar_findout/list_divebar_findout',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for list admin by filter.
	// Param :limit,option,keyword,offset,message
	// Return :'N/A'
	function search_list_divebar_findout($limit=20,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$redirect_page = 'search_list_divebar_findout';
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('search_list_divebar_findout');
		
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

	
		$config['uri_segment']='7';
		$config['base_url'] = base_url().'admin/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->divebar_findout_model->get_total_search_admin_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->divebar_findout_model->get_search_admin_result($option,$keyword,$offset, $limit);
		
		
		if($data['result']==0){
		$offset=0;
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'admin/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->divebar_findout_model->get_total_search_admin_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->divebar_findout_model->get_search_admin_result($option,$keyword,$offset, $limit);
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
		$this->template->write_view('center',$theme .'/layout/admin/list_divebar_findout',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for add new admin.
	// Param :'N/A'
	// Return :'N/A'
	
	function add_divebar_findout($limit=0)
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
		
		$check_rights=get_rights('add_divebar_findout');
		
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
		$this->form_validation->set_rules('divebar_findout_title', 'divebar_findout Title', 'required');
		$this->form_validation->set_rules('divebar_findout_description', 'Description', 'required');
		$data['divebardesc'] = '';
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
					
			$data["active"] = $this->input->post('active');
			$data['divebar_findout_description']=$this->input->post('divebar_findout_description');
			$data['user_id']=$this->input->post('user_id');
			$data['divebar_findout_id'] = $this->input->post('divebar_findout_id');
			$data['divebar_findout_title'] = $this->input->post('divebar_findout_title');
			$data["prev_photo_image"] = $this->input->post('prev_photo_image');
			
			$data["search_option"]='';
			$data["search_keyword"]='';
             
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_divebar_findout';
			
			
			$data['site_setting'] = site_setting();
			
		
			if($this->input->post('offset')=="")
			{
				$limit = '10';
				$data["offset"] = 0;
			}else{
				$data["offset"] = $this->input->post('offset');
			}
			$data["offset"] = 0;
			
			$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/divebar_findout/add_divebar_findout',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				
			if($this->input->post('divebar_findout_id')!='')
			{	
				$this->divebar_findout_model->divebar_findout_update();
				$msg = "update";
			}else{
				$this->divebar_findout_model->divebar_findout_insert();			
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
		 	//$user_id = $this->input->post('user_id');
			
			 
			if($redirect_page == 'list_divebar_findout')
			{
				redirect('divebar_findout/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			else
			{
				redirect('divebar_findout/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	
	// Use :This function use for edit of update admin.
	// Param :admin id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function edit_divebar_findout($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
		
		$check_rights=get_rights('edit_divebar_findout');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_divebar_findout = $this->divebar_findout_model->get_one_divebar_findout($id);
		$data['divebardesc']=$this->divebar_findout_model->divebardesc($id);
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		//$data["user_id"] = $user_id;
        $data["divebar_findout_id"] = $id;
		$data["user_id"] = $one_divebar_findout['user_id'];
		$data["redirect_page"]=$redirect_page;
		$data["active"] = $one_divebar_findout['status'];
		$data['divebar_findout_title'] = $one_divebar_findout['divebar_findout_title'];
		
		
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/divebar_findout/add_divebar_findout',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}

	// Use :This function use for Delete divebar_findout.
	// Param :divebar_findout id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function delete_divebar_findout($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*   
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_divebar_findout');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$this->db->delete('divebar_findout',array('divebar_findout_id'=>$id));
		$this->db->delete('divebar_findout_topic',array('divebar_findout_id'=>$id));
		if($redirect_page == 'list_divebar_findout')
		{
			
			redirect('divebar_findout/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('divebar_findout/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	
	// Use :This function use for change status or delete divebar_findout.
	// Param :'N/a'
	// Return :'N/A'
	function action_divebar_findout()
	{
		/* Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_divebar_findout');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
        
		
		$divebar_findout_id =$this->input->post('chk');
        //$user_id = $this->input->post('search_user_id');
		
		if($action=='delete')
		{		
			foreach($divebar_findout_id as $id)
			{			
				$this->db->query("delete from ".$this->db->dbprefix('divebar_findout')." where divebar_findout_id ='".$id."' ");
				$this->db->query("delete from ".$this->db->dbprefix('divebar_findout_topic')." where divebar_findout_id ='".$id."' ");
				
			}
			
			if($redirect_page == 'list_divebar_findout')
			{
				redirect('divebar_findout/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('divebar_findout/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{		
			foreach($divebar_findout_id as $id)
			{			
				$data = array('status'=>'active');
				$this->db->where('divebar_findout_id',$id);
				$this->db->update('divebar_findout', $data);
			}
			if($redirect_page == 'list_divebar_findout')
			{
				redirect('divebar_findout/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('divebar_findout/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive')
		{		
			foreach($divebar_findout_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('divebar_findout_id',$id);
				$this->db->update('divebar_findout', $data);
			}
			
			if($redirect_page == 'list_divebar_findout')
			{
				redirect('divebar_findout/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('divebar_findout/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');

			}
		}	
		
	}

function removeImageAjax($id=0)
	{
		$this->db->query("delete from ".$this->db->dbprefix('divebar_findout_topic')." where divebar_findout_topic_id ='".$id."' ");
		
	}	
	function view($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0){
			//echo "call"; die;
		if(!check_admin_authentication()) {
		redirect('home');
		}
		$check_rights=get_rights('view_divebar_findout');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
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
		//echo $id; die;
		$one_message = $this->divebar_findout_model->get_divebar_findout($id);
		//print_r($one_message); die;
	
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		$data["redirect_page"]=$redirect_page;
		
		$data["divebar_findout_id"] = $id;
		$data["user_id"] = $one_message['user_id'];
		$data["divebar_findout_title"] = $one_message['divebar_findout_title'];
		$data["date_created"] = $one_message['date_added'];
		$data["first_name"] = $one_message['first_name'];
		$data["last_name"] = $one_message['last_name'];
		$data["divebar_findout_description"] = $one_message['divebar_findout_description'];
		$data["master_id"] = $one_message['master_id'];
		
		$data['reply'] = $this->divebar_findout_model->get_list($id,$data["master_id"]);
		//print_r($data['reply']); die;
		
		//update data
	    $data_update = array("divebar_findout_id"=>$id);
	    $this->db->where("divebar_findout_id",$id);
	    $this->db->update("divebar_findout",$data_update);
		//end of update data//
	
		
		if($_POST){
			$this->divebar_findout_model->reply_insert();			
			$msg = "insert"; 
			//echo 'forum/view/'.$limit.'/'.$offset; die;
			 redirect('divebar_findout/view/'.$id.'/'.$limit.'/'.$offset.'/'.$msg);
			
		}
		
		$data['total_comment']=$this->divebar_findout_model->get_divebar_findout_count($id);
		//print_r($data['total']);
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/divebar_findout/view',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();

	}
	
	function import($msg='')
	{
		if(!check_admin_authentication()) {
		redirect('home');
		}
		$check_rights=get_rights('import_divebar_findout');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$data = array();    
        $data['error'] = '';    
		$data['msg'] = $msg;
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
        $data['active_menu']='contact';

		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/divebar_findout/import',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
			
	}
	
	function import_csv()
	{
		// print_r($_FILES);
		// die;		
			$get = $this->divebar_findout_model->importcsv();
			
			// if($get!=0)
			// {	
			// $result="Success";			
			// $msg="Import Successfully";	
			// $limit=20;
			// $offset=0;
			// redirect('beer/list_beer/'.$limit.'/0/'.$offset.'/'.$result);			
			// }
			// else {
				// redirect('beer/list_beer/'.$limit.'/0/'.$offset.'/'.$result);
			// }
	}
}


?>