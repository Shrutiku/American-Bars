<?php
class Faq extends  CI_Controller {
	function faq() {
		 parent::__construct();	
		$this->load->model('faq_model');	
	}
	
	function index() {
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('faq/list_faq');	
	}
	
	// Use :This function use for Lost all faq.
	// Param :limit,offset,message
	// Return :'N/A'
	function list_faq($limit='10',$offset=0,$msg=''){
		
		if(!check_admin_authentication()){
			redirect('home');
		}
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		 /* 
		 * Future enhancement
		 * when assigning rights is used
		 */
		 
		$check_rights=get_rights('list_faq');
		
		if($check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('pagination');

		$config['uri_segment']='4';
		$config['base_url'] = base_url().'faq/list_faq/'.$limit.'/';
		$config['total_rows'] = $this->faq_model->get_total_faq_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->faq_model->get_faq_result($offset, $limit);
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
		$data['redirect_page']='list_faq';
		
		$data['site_setting'] = site_setting();
	
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/faq/list_faq',$data,TRUE);
		
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for list faq by filter.
	// Param :limit,option,keyword,offset,message
	// Return :'N/A'
	
	function search_list_faq($limit=20,$option='',$keyword='',$offset=0,$msg=''){
		if(!check_admin_authentication()){
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_faq';
		/* 
		 * Future enhancement
		 * when assigning rights is used
		*/
		 
		 $check_rights=get_rights('list_faq');
 		
		 if( $check_rights==0) {			
			 redirect('home/dashboard/no_rights');	
		 }
		
		$this->load->library('pagination');
		if($_POST) {		
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
		$config['base_url'] = base_url().'faq/search_list_faq/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->faq_model->get_total_search_faq_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->faq_model->get_search_faq_result($option,$keyword,$offset, $limit);
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
		$this->template->write_view('center',$theme .'/layout/faq/list_faq',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}


	// Use :This function use for check unique faq Name.
	// Param :faq name
	// Return :Boolean
	
	function faq_check($faq_name){
		$faq_name = $this->faq_model->faq_unique($faq_name);
		if($faq_name == TRUE) {
			return TRUE;
		} else {
			$this->form_validation->set_message('faq_check', 'Package name already exists. Please enter different faq name.');
			return FALSE;
		}
	}
	
	
	// Use :This function use for add new faq.
	// Param :'N/A'
	// Return :'N/A'
	
	function add_faq($limit="20"){
		if(!check_admin_authentication()){
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/*
		 *Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('list_faq');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
				
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('faq_question', 'Question', 'required');
		$this->form_validation->set_rules('faq_answer', 'Answer', 'required');
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors()){
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			
			$data["faq_id"] = $this->input->post('faq_id');
			$data["faq_question"] = $this->input->post('faq_question');
			$data["faq_answer"] = $this->input->post('faq_answer');
			$data["status"] = $this->input->post('status');
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_faq';
			$data['site_setting'] = site_setting();
			
			if($this->input->post('offset')==""){
				//$limit = '10';
				$data["offset"] = 0;
			}else{
				$data["offset"] = $this->input->post('offset');
			}
			$data['limit']=$limit;
			$data["offset"]=0;
			$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/faq/add_faq',$data,TRUE);
			$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
			if($this->input->post('faq_id')!=''){	
				$this->faq_model->faq_update();
				$msg = "update";
			}else{
				$count = $this->faq_model->get_total_faq_count();
				if($count < 20){
					$this->faq_model->faq_insert();			
					$msg = "insert";
				}else{
					$msg = "faq_limit";
				}
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
		 	
			 
			if($redirect_page == 'list_faq') {
				redirect('faq/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			} else {
				redirect('faq/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
			
		}				
	}


	// Use :This function use for edit of update faq.
	// Param :faq id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function edit_faq($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0){
		
		if(!check_admin_authentication()) {
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('list_faq');
				
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_faq = $this->faq_model->get_one_faq($id);
		
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		$data["redirect_page"]=$redirect_page;
		
		$data["faq_id"] = $id;
		$data["faq_question"] = $one_faq['faq_question'];
		$data["faq_answer"] = $one_faq['faq_answer'];
		$data["status"] = $one_faq['status'];
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/faq/add_faq',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for Delete faq.
	// Param :faq id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	function delete_faq($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*
		 *  Future enhancement
		 * when assigning rights is used<br>
		*/
		
		$check_rights=get_rights('list_faq');
				
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
				
     
                            
		
		//$this->db->where('faq_id', $id);
		//$this->db->delete('faq', $data);
		
		$this->db->delete('faq', array("faq_id"=>$id));	
		
		//$this->db->delete('faq',array('faq_id'=>$id));
		if($redirect_page == 'list_faq'){	
			redirect('faq/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		} else {
			redirect('faq/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');
		}
	}
	
	
	
	// Use :This function use for change status or delete faq.
	// Param :'N/a'
	// Return :'N/A'
	
	function action_faq()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('list_faq');
				
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		$faq_id =$this->input->post('chk');
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
			
		if($action=='delete')
		{
		   
        
            		
			foreach($faq_id as $id) {
			//	$this->db->where('faq_id', $id);
				$this->db->delete('faq', array("faq_id"=>$id));			
				//$this->db->query("delete from ".$this->db->dbprefix('faq')." where faq_id ='".$id."'");
			}
			
			if($redirect_page == 'list_faq') {	
				redirect('faq/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			} else {
				redirect('faq/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');
			}
		}
			
		if($action=='active')
		{
		     
			foreach($faq_id as $id)
			{			
				$data = array('status'=>'active');
				$this->db->where('faq_id',$id);
				$this->db->update('faq', $data);
			}
			if($redirect_page == 'list_faq')
		{
			
			redirect('faq/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
		}
		else
		{
			redirect('faq/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');

		}
		}	
		if($action=='inactive')
		{
		    //Log Entry    
            $data_log = array("activity_name" => "LOG_INACTIVE_FAQ");
            maintain_log($data_log);
            		
			foreach($faq_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('faq_id',$id);
				$this->db->update('faq', $data);
			}
			
				if($redirect_page == 'list_faq')
		{
			
			redirect('faq/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
		}
		else
		{
			redirect('faq/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');

		}
			
		}
	}
	
	
}


?>