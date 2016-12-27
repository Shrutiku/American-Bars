<?php
class Report extends  CI_Controller {
	function Report()
	{
	    
		parent::__construct();	
		$this->load->model('bar_model');
		
	}
	
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('report/list_bar_report');
		
		$check_rights=get_rights('list_bar_report');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
	}
	
	// Use :This function use for Lost all trivia of User.
	// Param :limit,offset,message
	// Return :'N/A'
	function list_bar_report($limit='10',$offset=0,$msg='')
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
		
		$check_rights=get_rights('list_bar_report');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('pagination');

		//$data['user_id']=$user_id;
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'report/list_bar_report/'.$limit.'/';
		$config['total_rows'] = $this->bar_model->getBarReportCount();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
       // $data['user_id']=$user_id;
		
		$data['result'] = $this->bar_model->getBarReport($offset,$limit);
        
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
		$data['redirect_page']='list_bar_report';
		
		$data['site_setting'] = site_setting();

		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/bar/list_bar_report',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}


	function list_taxi_company_report($limit='10',$offset=0,$msg='')
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
		
		$check_rights=get_rights('list_taxi_company_report');
		
		//echo $check_rights;
		//die;
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('pagination');

		//$data['user_id']=$user_id;
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'report/list_taxi_company_report/'.$limit.'/';
		$config['total_rows'] = $this->bar_model->getTaxiReportCount();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
       // $data['user_id']=$user_id;
		
		$data['result'] = $this->bar_model->getTaxiReport($offset,$limit);
        
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
		$data['redirect_page']='list_taxi_company_report';
		
		$data['site_setting'] = site_setting();

		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/bar/list_taxi_company_report',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for list admin by filter.
	// Param :limit,option,keyword,offset,message
	// Return :'N/A'
	function search_list_trivia($limit=20,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$redirect_page = 'search_list_trivia';
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('search_list_trivia');
		
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
		$config['base_url'] = base_url().'trivia/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->bar_model->get_total_search_trivia_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->bar_model->get_search_trivia_result($option,$keyword,$offset, $limit);
		
		
		if($data['result']==0){
		$offset=0;
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'trivia/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->bar_model->get_total_search_trivia_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->bar_model->get_search_trivia_result($option,$keyword,$offset, $limit);
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
		$this->template->write_view('center',$theme .'/layout/trivia/list_trivia',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for add new admin.
	// Param :'N/A'
	// Return :'N/A'
	
	function add_trivia($limit=0)
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
		
		$check_rights=get_rights('add_trivia');
		
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
		$this->form_validation->set_rules('question', 'Question', 'required');
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
					
			$data["active"] = $this->input->post('active');
			$data['question']=$this->input->post('question');
			$data['question2']=$this->input->post('question2');
			$data['question1']=$this->input->post('question1');
			$data['question3']=$this->input->post('question3');
			$data['question4']=$this->input->post('question4');
			$data['answer']=$this->input->post('answer');
			$data['trivia_id'] = $this->input->post('trivia_id');
			
			$data["search_option"]='';
			$data["search_keyword"]='';
             
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_trivia';
			
			
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
			$this->template->write_view('center',$theme .'/layout/trivia/add_trivia',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				
			if($this->input->post('trivia_id')!='')
			{	
				$this->bar_model->trivia_update();
				$msg = "update";
			}else{
				$this->bar_model->trivia_insert();			
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
			
			 
			if($redirect_page == 'list_trivia')
			{
				redirect('trivia/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			else
			{
				redirect('trivia/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	
	// Use :This function use for edit of update admin.
	// Param :admin id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function edit_trivia($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
		
		$check_rights=get_rights('edit_trivia');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_trivia = $this->bar_model->get_one_trivia($id);
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		//$data["user_id"] = $user_id;
        $data["trivia_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		$data["question"] = $one_trivia['question'];
		$data["question1"] = $one_trivia['question1'];
		$data["question2"] = $one_trivia['question2'];
		$data["question3"] = $one_trivia['question3'];
		$data["question4"] = $one_trivia['question4'];
		$data["answer"] = $one_trivia['answer'];
		$data["active"] = $one_trivia['status'];
		
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/trivia/add_trivia',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}

	// Use :This function use for Delete trivia.
	// Param :trivia id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function delete_bar_report($id=0,$redirect_page='',$keyword='',$limit=20,$offset=0)
	{
		
		
		/*   
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_bar_report');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$this->db->delete('report',array('report_id'=>$id));
		
		if($redirect_page == 'list_bar_report')
		{
			
			
			redirect('report/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('report/'.$redirect_page.'/'.$limit.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	
	// Use :This function use for change status or delete trivia.
	// Param :'N/a'
	// Return :'N/A'
	function action_bar_report()
	{
		/* Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_bar_report');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
        
		
		$trivia_id =$this->input->post('chk');
        //$user_id = $this->input->post('search_user_id');
		
		if($action=='delete')
		{		
			foreach($trivia_id as $id)
			{			$this->db->delete('report',array('report_id'=>$id));
				
			}
			
			if($redirect_page == 'list_bar_report')
			{
				redirect('report/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('report/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
	
	}


	function delete_taxi_company_report($id=0,$redirect_page='',$keyword='',$limit=20,$offset=0)
	{
		
		
		/*   
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_taxi_company_report');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$this->db->delete('report_taxi',array('report_id'=>$id));
		
		if($redirect_page == 'list_taxi_company_report')
		{
			
			
			redirect('report/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('report/'.$redirect_page.'/'.$limit.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	
	// Use :This function use for change status or delete trivia.
	// Param :'N/a'
	// Return :'N/A'
	function action_taxi_company_report()
	{
		/* Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_taxi_company_report');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword = $this->input->post('serach_keyword');
        
		
		$trivia_id =$this->input->post('chk');
        //$user_id = $this->input->post('search_user_id');
		
		if($action=='delete')
		{		
			foreach($trivia_id as $id)
			{			$this->db->delete('report_taxi',array('report_id'=>$id));
				
			}
			
			if($redirect_page == 'list_taxi_company_report')
			{
				redirect('report/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('report/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
	
	}
	function viewreport($id=0){
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
		
		$check_rights=get_rights('viewreport');
				
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//echo $id; die;
		$one_message = $this->bar_model->gersuggestbar($id);
		//print_r($one_message); die;
	
	    $data_update = array("r_st"=>'1');
	    $this->db->where("report_id",$id);
	    $this->db->update("report",$data_update);
		$data["error"] = "";
		$data["status"] = $one_message['status'];
		$data["bar_title"] = $one_message['bar_title'];
		$data["first_name"] = $one_message['first_name'];
		$data["reported_by"] = $one_message['reported_by'];
		$data["last_name"] = $one_message['last_name'];
		$data["desc"] = $one_message['desc'];
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/bar/view_bar_report',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();

	}

    function view_taxi_company_report($id=0){
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
		
		$check_rights=get_rights('view_taxi_company_report');
				
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//echo $id; die;
		$one_message = $this->bar_model->get_taxi_report($id);
		
	
	    $data_update = array("r_st"=>'1');
	    $this->db->where("report_id",$id);
	    $this->db->update("report_taxi",$data_update);
		$data["error"] = "";
		$data["status"] = $one_message['status'];
		$data["taxi_company"] = $one_message['taxi_company'];
		$data["first_name"] = $one_message['first_name'];
		$data["reported_by"] = $one_message['reported_by'];
		$data["last_name"] = $one_message['last_name'];
		$data["desc"] = $one_message['desc'];
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/bar/view_taxi_report',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();

	}
	
	function import($msg='')
	{
		if(!check_admin_authentication()) {
		redirect('home');
		}
		$check_rights=get_rights('import_trivia');
				
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
		$this->template->write_view('center',$theme .'/layout/trivia/import',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
			
	}
	
	function import_csv()
	{
		// print_r($_FILES);
		// die;		
			$get = $this->bar_model->importcsv();
			
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
	
   function search_list_bar_report($limit=20,$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$redirect_page = 'search_list_bar_report';
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('list_bar_report');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$this->load->library('pagination');
		
		if($_POST)
		{		
			$keyword=($this->input->post('keyword')!='')?str_replace(" ", "-",trim($this->input->post('keyword'))):'1V1';
			
		}
		else
		{
			$keyword=str_replace(" ", "-",trim($keyword));	
		
		}
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',trim($keyword)));

	
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'report/'.$redirect_page.'/'.$limit.'/'.$keyword.'/';
		$config['total_rows'] = $this->bar_model->get_total_search_bar_report_count($keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->bar_model->get_search_bar_report_result($keyword,$offset, $limit);
		
		
		$data['msg'] = $msg;
		$data['offset'] = $offset;
		$data['site_setting'] = site_setting();
		
		$data['limit']=$limit;
		$data['keyword']=$keyword;
		$data['search_type']='search';
		$data['redirect_page']=$redirect_page;
		
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/bar/list_bar_report',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}	

function search_list_taxi_company_report($limit=20,$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$redirect_page = 'search_list_taxi_company_report';
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('list_taxi_company_report');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$this->load->library('pagination');
		
		if($_POST)
		{		
			$keyword=($this->input->post('keyword')!='')?str_replace(" ", "-",trim($this->input->post('keyword'))):'1V1';
			
		}
		else
		{
			$keyword=str_replace(" ", "-",trim($keyword));	
		
		}
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',trim($keyword)));

	
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'report/'.$redirect_page.'/'.$limit.'/'.$keyword.'/';
		$config['total_rows'] = $this->bar_model->get_total_search_taxi_report_count($keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->bar_model->get_search_taxi_report_result($keyword,$offset, $limit);
		
		
		$data['msg'] = $msg;
		$data['offset'] = $offset;
		$data['site_setting'] = site_setting();
		
		$data['limit']=$limit;
		$data['keyword']=$keyword;
		$data['search_type']='search';
		$data['redirect_page']=$redirect_page;
		
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/bar/list_taxi_company_report',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}	
}


?>