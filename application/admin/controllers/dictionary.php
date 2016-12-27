<?php
class Dictionary extends  CI_Controller {
	function Dictionary()
	{
	    
		parent::__construct();	
		$this->load->model('dictionary_model');
		
	}
	
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('dictionary/list_dictionary');
		
		$check_rights=get_rights('list_dictionary');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
	}
	
	// Use :This function use for Lost all dictionary of User.
	// Param :limit,offset,message
	// Return :'N/A'
	function list_dictionary($limit='10',$offset=0,$msg='')
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
		
		$check_rights=get_rights('list_dictionary');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('pagination');

		//$data['user_id']=$user_id;
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'dictionary/list_dictionary/'.$limit.'/';
		$config['total_rows'] = $this->dictionary_model->get_total_admin_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
       // $data['user_id']=$user_id;
		
		$data['result'] = $this->dictionary_model->get_dictionary_result($offset,$limit);
        
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
		$data['redirect_page']='list_dictionary';
		
		$data['site_setting'] = site_setting();

		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/dictionary/list_dictionary',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for list admin by filter.
	// Param :limit,option,keyword,offset,message
	// Return :'N/A'
	function search_list_dictionary($limit=20,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$redirect_page = 'search_list_dictionary';
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('search_list_dictionary');
		
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
		$config['total_rows'] = $this->dictionary_model->get_total_search_admin_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->dictionary_model->get_search_admin_result($option,$keyword,$offset, $limit);
		
		
		if($data['result']==0){
		$offset=0;
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'admin/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->dictionary_model->get_total_search_admin_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->dictionary_model->get_search_admin_result($option,$keyword,$offset, $limit);
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
		$this->template->write_view('center',$theme .'/layout/admin/list_dictionary',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for add new admin.
	// Param :'N/A'
	// Return :'N/A'
	
	function add_dictionary($limit=0)
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
		
		$check_rights=get_rights('add_dictionary');
		
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
		$this->form_validation->set_rules('dictionary_title', 'dictionary Title', 'required');
		$this->form_validation->set_rules('dictionary_description', 'Description', 'required');
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
					
			$data["active"] = $this->input->post('active');
			$data['dictionary_description']=$this->input->post('dictionary_description');
			$data['user_id']=$this->input->post('user_id');
			$data['dictionary_id'] = $this->input->post('dictionary_id');
			$data['dictionary_title'] = $this->input->post('dictionary_title');
			
			$data["search_option"]='';
			$data["search_keyword"]='';
             
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_dictionary';
			
			
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
			$this->template->write_view('center',$theme .'/layout/dictionary/add_dictionary',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				
			if($this->input->post('dictionary_id')!='')
			{	
				$this->dictionary_model->dictionary_update();
				$msg = "update";
			}else{
				$this->dictionary_model->dictionary_insert();			
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
			
			 
			if($redirect_page == 'list_dictionary')
			{
				redirect('dictionary/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			else
			{
				redirect('dictionary/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	
	// Use :This function use for edit of update admin.
	// Param :admin id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function edit_dictionary($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
		
		$check_rights=get_rights('edit_dictionary');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_dictionary = $this->dictionary_model->get_one_dictionary($id);
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		//$data["user_id"] = $user_id;
        $data["dictionary_id"] = $id;
		$data["user_id"] = $one_dictionary['user_id'];
		$data["redirect_page"]=$redirect_page;
		$data["dictionary_description"] = $one_dictionary['dictionary_description'];
		$data["active"] = $one_dictionary['status'];
		$data['dictionary_title'] = $one_dictionary['dictionary_title'];
		
		
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/dictionary/add_dictionary',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}

	// Use :This function use for Delete dictionary.
	// Param :dictionary id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function delete_dictionary($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*   
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_dictionary');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$this->db->delete('dictionary',array('dictionary_id'=>$id));
		$this->db->delete('dictionary',array('master_id'=>$id));
		if($redirect_page == 'list_dictionary')
		{
			
			redirect('dictionary/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('dictionary/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	
	// Use :This function use for change status or delete dictionary.
	// Param :'N/a'
	// Return :'N/A'
	function action_dictionary()
	{
		/* Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_dictionary');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
        
		
		$dictionary_id =$this->input->post('chk');
        //$user_id = $this->input->post('search_user_id');
		
		if($action=='delete')
		{		
			foreach($dictionary_id as $id)
			{			
				$this->db->query("delete from ".$this->db->dbprefix('dictionary')." where dictionary_id ='".$id."' or master_id ='".$id."' ");
				
			}
			
			if($redirect_page == 'list_dictionary')
			{
				redirect('dictionary/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('dictionary/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{		
			foreach($dictionary_id as $id)
			{			
				$data = array('status'=>'active');
				$this->db->where('dictionary_id',$id);
				$this->db->update('dictionary', $data);
			}
			if($redirect_page == 'list_dictionary')
			{
				redirect('dictionary/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('dictionary/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive')
		{		
			foreach($dictionary_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('dictionary_id',$id);
				$this->db->update('dictionary', $data);
			}
			
			if($redirect_page == 'list_dictionary')
			{
				redirect('dictionary/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('dictionary/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');

			}
		}	
		
	}
	function view($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0){
			//echo "call"; die;
		if(!check_admin_authentication()) {
		redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('view_dictionary');
				
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//echo $id; die;
		$one_message = $this->dictionary_model->get_dictionary($id);
		//print_r($one_message); die;
	
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		$data["redirect_page"]=$redirect_page;
		
		$data["dictionary_id"] = $id;
		$data["user_id"] = $one_message['user_id'];
		$data["dictionary_title"] = $one_message['dictionary_title'];
		$data["date_created"] = $one_message['date_added'];
		$data["first_name"] = $one_message['first_name'];
		$data["last_name"] = $one_message['last_name'];
		$data["dictionary_description"] = $one_message['dictionary_description'];
		$data["master_id"] = $one_message['master_id'];
		
		$data['reply'] = $this->dictionary_model->get_list($id,$data["master_id"]);
		//print_r($data['reply']); die;
		
		//update data
	    $data_update = array("dictionary_id"=>$id);
	    $this->db->where("dictionary_id",$id);
	    $this->db->update("dictionary",$data_update);
		//end of update data//
	
		
		if($_POST){
			$this->dictionary_model->reply_insert();			
			$msg = "insert"; 
			//echo 'forum/view/'.$limit.'/'.$offset; die;
			 redirect('dictionary/view/'.$id.'/'.$limit.'/'.$offset.'/'.$msg);
			
		}
		
		$data['total_comment']=$this->dictionary_model->get_dictionary_count($id);
		//print_r($data['total']);
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/dictionary/view',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();

	}
	
	function import($msg='')
	{
		if(!check_admin_authentication()) {
		redirect('home');
		}
		$check_rights=get_rights('import_dictionary');
				
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
		$this->template->write_view('center',$theme .'/layout/dictionary/import',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
			
	}
	
	function import_csv()
	{
		// print_r($_FILES);
		// die;		
			$get = $this->dictionary_model->importcsv();
			
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