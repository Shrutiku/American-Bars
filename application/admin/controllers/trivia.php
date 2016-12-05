<?php
class trivia extends  CI_Controller {
	function trivia()
	{
	    
		parent::__construct();	
		$this->load->model('trivia_model');
		$this->load->model('banner_pages_model');
		
	}
	
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('trivia/list_trivia');
		
		$check_rights=get_rights('list_trivia');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
	}
	
	// Use :This function use for Lost all trivia of User.
	// Param :limit,offset,message
	// Return :'N/A'
	function list_trivia($limit='10',$offset=0,$msg='',$er='',$er1='')
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
		
		$check_rights=get_rights('list_trivia');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('pagination');

		//$data['user_id']=$user_id;
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'trivia/list_trivia/'.$limit.'/';
		$config['total_rows'] = $this->trivia_model->get_total_admin_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
       // $data['user_id']=$user_id;
		
		$data['result'] = $this->trivia_model->get_trivia_result($offset,$limit);
        
        $data['msg'] = $msg;
		$data['er'] = $er;
		$data['er1'] = $er1;
		
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
		$data['redirect_page']='list_trivia';
		
		$data['site_setting'] = site_setting();

		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/trivia/list_trivia',$data,TRUE);
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
		$config['total_rows'] = $this->trivia_model->get_total_search_trivia_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->trivia_model->get_search_trivia_result($option,$keyword,$offset, $limit);
		
		
		if($data['result']==0){
		$offset=0;
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'trivia/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->trivia_model->get_total_search_trivia_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->trivia_model->get_search_trivia_result($option,$keyword,$offset, $limit);
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
				$this->trivia_model->trivia_update();
				$msg = "update";
			}else{
				$this->trivia_model->trivia_insert();			
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
		
		$one_trivia = $this->trivia_model->get_one_trivia($id);
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
	
	function delete_trivia($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*   
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_trivia');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$this->db->delete('trivia',array('trivia_id'=>$id));
		if($redirect_page == 'list_trivia')
		{
			
			redirect('trivia/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('trivia/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	
	// Use :This function use for change status or delete trivia.
	// Param :'N/a'
	// Return :'N/A'
	function action_trivia()
	{
		/* Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_trivia');
		
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
			{			
				$this->db->query("delete from ".$this->db->dbprefix('trivia')." where trivia_id ='".$id."'");
				
			}
			
			if($redirect_page == 'list_trivia')
			{
				redirect('trivia/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('trivia/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{		
			foreach($trivia_id as $id)
			{			
				$data = array('status'=>'active');
				$this->db->where('trivia_id',$id);
				$this->db->update('trivia', $data);
			}
			if($redirect_page == 'list_trivia')
			{
				redirect('trivia/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('trivia/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive')
		{		
			foreach($trivia_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('trivia_id',$id);
				$this->db->update('trivia', $data);
			}
			
			if($redirect_page == 'list_trivia')
			{
				redirect('trivia/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('trivia/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');

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
		
		$check_rights=get_rights('view_trivia');
				
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//echo $id; die;
		$one_message = $this->trivia_model->get_trivia($id);
		//print_r($one_message); die;
	
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		$data["redirect_page"]=$redirect_page;
		
		$data["trivia_id"] = $id;
		$data["user_id"] = $one_message['user_id'];
		$data["trivia_title"] = $one_message['trivia_title'];
		$data["date_created"] = $one_message['date_added'];
		$data["first_name"] = $one_message['first_name'];
		$data["last_name"] = $one_message['last_name'];
		$data["trivia_description"] = $one_message['trivia_description'];
		$data["master_id"] = $one_message['master_id'];
		
		$data['reply'] = $this->trivia_model->get_list($id,$data["master_id"]);
		//print_r($data['reply']); die;
		
		//update data
	    $data_update = array("trivia_id"=>$id);
	    $this->db->where("trivia_id",$id);
	    $this->db->update("trivia",$data_update);
		//end of update data//
	
		
		if($_POST){
			$this->trivia_model->reply_insert();			
			$msg = "insert"; 
			//echo 'forum/view/'.$limit.'/'.$offset; die;
			 redirect('trivia/view/'.$id.'/'.$limit.'/'.$offset.'/'.$msg);
			
		}
		
		$data['total_comment']=$this->trivia_model->get_trivia_count($id);
		//print_r($data['total']);
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/trivia/view',$data,TRUE);
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
			$get = $this->trivia_model->importcsv();
			
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
	
	function trivia_banner($msg='') {
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('add_banner_pages');
				
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$data = array();
		$theme = getThemeName();
		$this -> template -> set_master_template($theme . '/template.php');
        $this->load->library('form_validation');
		$data['error'] = '';
		$data['msg'] = $msg;
		$video_error = '';		
		
		
			    $banner_pages = banner_pages();
				$data["banner_pages_id"] = $banner_pages -> banner_pages_id;
				$data["prev_bar_banner_find"] = $banner_pages -> find_bar;
				$data["prev_beer_banner_find"] = $banner_pages -> beer_directory;
				$data["prev_liquor_banner_find"] = $banner_pages -> liqur_directory;
				$data["prev_resource_banner_find"] = $banner_pages -> resource_directory;
				$data["prev_cocktail_banner_find"] = $banner_pages -> cocktail_directory;
				$data["prev_suggest_bar_banner_find"] = $banner_pages -> suggest_bar;
				$data["prev_contact_us_banner_find"] = $banner_pages -> contact_us;
				
				$data["prev_gallery_banner_find"] = $banner_pages -> photo_gallery;
				
				$data["prev_taxi_banner_find"] = $banner_pages -> taxi_directory;
				$data["prev_media_banner_find"] = $banner_pages -> media;
				$data["prev_forum_banner_find"] = $banner_pages -> forum;
				$data["prev_article_banner_find"] = $banner_pages -> article;
				$data["prev_trivia_banner_find"] = $banner_pages -> trivia;
				$data["prev_trivia_app_banner_find"] = $banner_pages -> find_trivia_app;
				$data["find_bar_state"] = $banner_pages -> find_bar_state;
				$data["beer_directory_state"] = $banner_pages -> beer_directory_state;
				$data["liqur_directory_state"] = $banner_pages -> liqur_directory_state;
				$data["resource_directory_state"] = $banner_pages -> resource_directory_state;
				$data["cocktail_directory_state"] = $banner_pages -> cocktail_directory_state;
				$data["suggest_bar_state"] = $banner_pages -> suggest_bar_state;
				$data["contact_us_state"] = $banner_pages -> contact_us_state;
				$data["photo_gallery_state"] = $banner_pages -> photo_gallery_state;
				$data["media_state"] = $banner_pages -> media_state;
				$data["forum_state"] = $banner_pages -> forum_state;
				$data["taxi_directory_state"] = $banner_pages -> taxi_directory_state;
				$data["find_article_state"] = $banner_pages -> find_article_state;
				$data["find_trivia_state"] = $banner_pages -> find_trivia_state;
				$data["find_trivia_app_state"] = $banner_pages -> find_trivia_app_state;
				$data["find_trivia_app"] = $banner_pages -> find_trivia_app;
				 
				
		if ($_POST) {
			
			
		  
		  if(isset($_FILES['find_trivia']) && $_FILES["find_trivia"]["name"] != ""){
				
			$tmpName = $_FILES['find_trivia']['tmp_name'];
			
				
				list($width, $height, $type, $attr) = getimagesize($tmpName);
			
			if($width < 1140 || $height < 415)
			{
				
				   $video_error .= "<p>Bar Banner size must be greater than 1140px by 415px.</p>";
			}
		  }
		
			 if(isset($_FILES['find_trivia_app']) && $_FILES["find_trivia_app"]["name"] != ""){
				
			$tmpName = $_FILES['find_trivia_app']['tmp_name'];
			
				
				list($width, $height, $type, $attr) = getimagesize($tmpName);
			
			if($width < 1920 || $height < 1080)
			{
				
				   $video_error .= "<p>Bar Banner size must be greater than 1920px by 1080px.</p>";
			}
		  }
				if($video_error != ""){
			if ($video_error != "")
			{
				$data["error"] = $video_error;
			}else{
				$data["error"] = "";
			}
			
				}
				else {
					
					
					    $this -> trivia_model -> banner_pages_update();
						redirect('trivia/test');
									}
			
		  }   



			$data['site_setting'] = site_setting();
			
			$data['page_name']="usercls";
			$this -> template -> write_view('header_menu', $theme . '/layout/common/header', $data, TRUE);
			$this -> template -> write_view('left', $theme . '/layout/common/sidebar', $data, TRUE);
			$this -> template -> write_view('center', $theme . '/layout/trivia/add_banner', $data, TRUE);
			$this -> template -> write_view('footer', $theme . '/layout/common/footer', $data, TRUE);
			$this -> template -> render();
		
	}

  function test()
   {
   
   	redirect('trivia/trivia_banner');
   }
	
	
}


?>