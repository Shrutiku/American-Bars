<?php
class Category extends  CI_Controller {
	function Category()
	{
		 parent::__construct();	
		$this->load->model('category_model');	
	}
	
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('category/list_category');	
	}
	
	// Use :This function use for Lost all admin User.
	// Param :limit,offset,message
	// Return :'N/A'
	function list_category($type ='',$limit='10',$offset=0,$msg='')
	{
		if(!check_admin_authentication()) {
			redirect('home');
		}
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/* 
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('list_category');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('pagination');

		$config['uri_segment']='4';
		$config['base_url'] = base_url().'category/list_category/'.$limit.'/';
		$config['total_rows'] = $this->category_model->get_total_category_count($type);
		
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->category_model->get_category_result($type,$offset,$limit);
		
		
		$data['msg'] = $msg;
		
		$data['offset'] = $offset;
		$data['error']='';
		if($this->input->post('limit') != ''){
			$data['limit']=$this->input->post('limit');
		} else {
			$data['limit']=$limit;
		}
		$data['option']='1V1';
		$data['keyword']='1V1';
		$data['serach_option']='1V1';
		$data['serach_keyword']='1V1';
		$data['search_type']='normal';
		$data['redirect_page']='list_category';	
		$data['site_setting'] = site_setting();
		$data["category_type"] = $type;

		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/category/list_category',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for list admin by filter.
	// Param :limit,option,keyword,offset,message
	// Return :'N/A'
	function search_list_category($type='',$limit=20,$option='',$keyword='',$offset=0,$msg='')
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$redirect_page = 'search_list_category';
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('search_list_category');
		
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
		$config['base_url'] = base_url().'category/'.$redirect_page.'/'.$type.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->category_model->get_total_search_category_count($type,$option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->category_model->get_search_category_result($type,$option,$keyword,$offset, $limit);
		
		
		if($data['result']==0){
		$offset=0;
		$config['uri_segment']='7';
		$config['base_url'] = base_url().'category/'.$redirect_page.'/'.$type.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->category_model->get_total_search_category_count($type,$option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->category_model->get_search_category_result($type,$option,$keyword,$offset, $limit);
		}
		
		$data['msg'] = $msg;
		$data['offset'] = $offset;
		$data['site_setting'] = site_setting();
		
		$data['limit']=$limit;
		$data['option']=$option;
		$data['keyword']=$keyword;
		$data['search_type']='search';
		$data['redirect_page']=$redirect_page;
		$data["category_type"] = $type;
		
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/category/list_category',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for check unique UserName of admin.
	// Param :UserName
	// Return :Boolean
	function username_check($username)
	{
		$username = $this->category_model->user_unique($username);
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
	function category_name_unique($category_name)
	{
		$category = $this->category_model->category_name_unique($category_name);
		if($category == TRUE){
			return TRUE;
		} else {
			$this->form_validation->set_message('category_name_unique', 'category name already exists. Please enter different category name.');
			return FALSE;
		}
	}
	
	// Use :This function use for add new admin.
	// Param :'N/A'
	// Return :'N/A'
	
	function add_category($type='',$limit=0,$offset=0)
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
		
		$check_rights=get_rights('add_category');
		
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
		//$data['category_arr'] = get_category_list();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('category_name', 'Category Name', 'required|callback_category_name_unique');
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			$data['category_type']=$type;
			$data["category_id"] = $this->input->post('category_id');
			$data["category_name"] = $this->input->post('category_name');
			$data["status"] = $this->input->post('status');
		
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_category';
			
			$data['site_setting'] = site_setting();
			
			if($this->input->post('offset')==""){
				$limit = '10';
				$data["offset"] = 0;
			}else{
				$data["offset"] = $this->input->post('offset');
			}
			
			
			$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/category/add_category',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				
			if($this->input->post('category_id')!='')
			{	
				$this->category_model->category_update();
				$msg = "update";
			}else{
				$this->category_model->category_insert();			
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
			$category_type = $this->input->post("category_type");
			 
			if($redirect_page == 'list_category') {
				
				redirect('category/'.$redirect_page.'/'.$category_type.'/'.$limit.'/'.$offset.'/'.$msg);
			} else {
				redirect('category/'.$redirect_page.'/'.$category_type.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	
	// Use :This function use for edit of update admin.
	// Param :admin id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function edit_category($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0,$type='')
	{
		//echo $type; die;
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/*   
		 * Future enhancement
		 * when assigning rights is used 
		 * 
		*/
		
		$check_rights=get_rights('add_category');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_user = $this->category_model->get_one_category($id);
		//print_r($one_user); die;
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		$data["category_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		$data["category_name"] = $one_user['category_name'];
		$data["status"] = $one_user['status'];
		$data["category_type"]=$type;
		
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/category/add_category',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}

	// Use :This function use for Delete admin.
	// Param :admin id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function delete_category($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0,$type='')
	{
		/*   
		 * Future enhancement
		 * when assigning rights is used 
		*/
		
		$check_rights=get_rights('delete_category');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		//$this->db->delete('rights_assign',array('category_id'=>$id));
		//$this->db->delete('category',array('category_id'=>$id));
		//Log data
         $data_log = array("activity_name" => "LOG_DELETE_DOCTOR_CATEGORY");
         maintain_log($data_log);
         
		$data = array(
		   'is_deleted' => 'y'
		);
		//$this->db->where('category_id', $id);
		//$this->db->update('category', $data);
		$this->db->delete('category',array('category_id'=>$id));
		if($redirect_page == 'list_category') {
			redirect('category/'.$redirect_page.'/'.$type.'/'.$limit.'/'.$offset.'/delete');
		} else {
			redirect('category/'.$redirect_page.'/'.$type.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');
		}
	}
	
	
	// Use :This function use for change status or delete admin.
	// Param :'N/a'
	// Return :'N/A'
	function action_login($category_type) {
		/* Future enhancement
		 * when assigning rights is used 
		 */
		 //echo $category_type;
		 //echo "action"; die;
		$check_rights=get_rights('action_category');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
		
		$category_id =$this->input->post('chk');
		
		if($action=='delete')
		{
		    //Log data
         $data_log = array("activity_name" => "LOG_DELETE_DOCTOR_CATEGORY");
         maintain_log($data_log);
            		
			foreach($category_id as $id) {
				$this->db->delete('category',array('category_id'=>$id));
			}
			
			if($redirect_page == 'list_category') {
				redirect('category/'.$redirect_page.'/'.$category_type.'/'.$limit.'/'.$offset.'/delete');
			} else {
				redirect('category/'.$redirect_page.'/'.$category_type.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');
			}
			
		}
			
		if($action=='active') {
		    
            //Log data
         $data_log = array("activity_name" => "LOG_ACTIVE_DOCTOR_CATEGORY");
         maintain_log($data_log);
         		
			foreach($category_id as $id) {			
				$data = array('status'=>'Active');
				$this->db->where('category_id',$id);
				$this->db->update('category', $data);
			}
			if($redirect_page == 'list_category') {
				redirect('category/'.$redirect_page.'/'.$category_type.'/'.$limit.'/'.$offset.'/active');
			} else {
				redirect('category/'.$redirect_page.'/'.$category_type.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive') {
		    
             //Log data
         $data_log = array("activity_name" => "LOG_INACTIVE_DOCTOR_CATEGORY");
         maintain_log($data_log);
         		
			foreach($category_id as $id) {			
				$data = array('status'=>'Inactive');
				$this->db->where('category_id',$id);
				$this->db->update('category', $data);
			}
			
			if($redirect_page == 'list_category')
			{
				redirect('category/'.$redirect_page.'/'.$category_type.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('category/'.$redirect_page.'/'.$category_type.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');

			}
		}
	}
}


?>