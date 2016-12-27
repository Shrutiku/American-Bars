<?php
class Banner_pages extends  CI_Controller {
	function banner_pages()
	{
		parent::__construct();	
		$this->load->model('banner_pages_model');
		$this->load->helper("ckeditor_helper");		
	}
	
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('banner_pages/list_banner_pages');
		
		$check_rights=get_rights('list_banner_pages');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
	}
	
	// Use :This function use for Lost all banner_pages User.
	// Param :limit,offset,message
	// Return :'N/A'
			
	function list_banner_pages($limit='10',$offset=0,$msg='')
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
		
		$check_rights=get_rights('list_banner_pages');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('pagination');

		
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'banner_pages/list_banner_pages/'.$limit.'/';
		$config['total_rows'] = $this->banner_pages_model->get_total_banner_pages_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->banner_pages_model->get_banner_pages_result($offset,$limit);
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
		$data['redirect_page']='list_banner_pages';
	
		
		
		
		
		$data['site_setting'] = site_setting();

		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/banner_pages/list_banner_pages',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for list banner_pages by filter.
	// Param :limit,option,keyword,offset,message
	// Return :'N/A'
	function search_list_banner_pages($limit=20,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$redirect_page = 'search_list_banner_pages';
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('search_list_banner_pages');
		
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
		$config['base_url'] = base_url().'banner_pages/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->banner_pages_model->get_total_search_banner_pages_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->banner_pages_model->get_search_banner_pages_result($option,$keyword,$offset, $limit);
		
		
		if($data['result']==0){
		$offset=0;
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'banner_pages/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->banner_pages_model->get_total_search_banner_pages_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->banner_pages_model->get_search_banner_pages_result($option,$keyword,$offset, $limit);
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
		$this->template->write_view('center',$theme .'/layout/banner_pages/list_banner_pages',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for check unique UserName of banner_pages.
	// Param :UserName
	// Return :Boolean
	function username_check($username)
	{
		$username = $this->banner_pages_model->user_unique($username);
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
	// Use :This function use for check unique Email of banner_pages.
	// Param :Email
	// Return :Boolean
	function banner_pagesmail_check($emailField)
	{
		$username = $this->banner_pages_model->user_email_unique($emailField);
		if($username == TRUE)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('banner_pagesmail_check', 'There is an existing account associated with this Email');
			return FALSE;
		}
	}
	
	// Use :This function use for add new banner_pages.
	// Param :'N/A'
	// Return :'N/A'
	
	function add_banner_pages($limit=0)
	{
		//echo "class"; 
		//echo (check_admin_authentication()); die;
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		//echo "hey"; die;
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/*   
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('add_banner_pages');
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//echo "hi middel est"; die;
		if($limit > 0)
		{
			$data['limit']=$limit;
		}
		else
		{
			$data['limit']=20;
		}
		
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('banner_pages_title', 'banner_pages Title', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
		
		
		
		$video_error = '';
		if($_POST)
		{			
			$image_arr = array('image/gif','image/jpeg', 'image/pjpeg','image/jpeg', 'image/pjpeg','image/jpeg', 'image/pjpeg','image/png',  'image/x-png');
			if($_FILES["banner_pages_image"]["name"]!="")
			{
				if(!in_array($_FILES["banner_pages_image"]["type"],$image_arr))
				{
					$video_error .= "<p>Please upload jpg,jpeg,png,gif format only</p>";
				}
			}	
			
			$tmpName = $_FILES['banner_pages_image']['tmp_name'];
			
			//print_r(getimagesize(front_base_url().'upload/banner_pages_thumb/'.$this->input->post('prev_beer_image')));
			
			if($this->input->post('prev_beer_image')!='' && $_FILES["banner_pages_image"]["name"]=="")
			{
				list($width, $height, $type, $attr) = getimagesize(front_base_url().'upload/banner_pages_thumb/'.$this->input->post('prev_beer_image'));
			}
			else {
				list($width, $height, $type, $attr) = getimagesize($tmpName);
			}
			
			
			if($this->input->post('size')=='1140x237')
			{
				if($width != 1140 || $height != 237)
				{
				   $video_error .= "<p>banner_pages image size must be 1140*237 px.</p>";
				}
			}
		}		
		
		if($this->form_validation->run() == FALSE || $video_error != ""){
			if (validation_errors () || $video_error != "")
			{
				$data["error"] = validation_errors();
				$data["error"] .= $video_error;
			}else{
				$data["error"] = "";
			}
			$data["banner_pages_title"] = $this->input->post('banner_pages_title');
			$data["banner_pages_desc"] = $this->input->post('banner_pages_desc');
			
			$data["size"] = $this->input->post('size');
			$data["number_click"] = $this->input->post('number_click');
			$data["link"] = $this->input->post('link');
			$data["number_visit"] = $this->input->post('number_visit');
			$data["position"] = $this->input->post('position');
			
			$data["banner_pages_id"] = $this->input->post('banner_pages_id');
			$data["allow_pages"] = $this->input->post('allow_pages');
		    
			
			$data["status"] = $this->input->post('status');
			$data['pre_banner_pages_image']=$this->input->post('prev_beer_image');
			$data['type']=$this->input->post('type');
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_banner_pages';
			
			
			$data['site_setting'] = site_setting();
			
		
			if($this->input->post('offset')=="")
			{
				$limit = '10';
				$data["offset"] = 0;
			}else{
				$data["offset"] = $this->input->post('offset');
			}
			
			//echo "wait"; die;
			$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/banner_pages/add_banner_pages',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				//echo "else"; die;
			if($this->input->post('banner_pages_id')!='')
			{
				//echo "update" ; die;	
				$this->banner_pages_model->banner_pages_update();
				$msg = "update";
			}else{
					//echo "insert"; die;
				$this->banner_pages_model->banner_pages_insert();			
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
		 	
			 //echo ('banner_pages/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg); die;
			if($redirect_page == 'list_banner_pages')
			{
				redirect('banner_pages/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			else
			{
				redirect('banner_pages/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	function add_city_banner_pages($limit=0)
	{
		//echo "class"; 
		//echo (check_admin_authentication()); die;
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		//echo "hey"; die;
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/*   
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('add_banner_pages');
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//echo "hi middel est"; die;
		if($limit > 0)
		{
			$data['limit']=$limit;
		}
		else
		{
			$data['limit']=20;
		}
		
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('banner_pages_title', 'banner_pages Title', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
		//$this->form_validation->set_rules('city_zip', 'City Names/Zipcodes', 'required');
		
		
		
		$video_error = '';
		if($_POST)
		{
			$image_arr = array('image/gif','image/jpeg', 'image/pjpeg','image/jpeg', 'image/pjpeg','image/jpeg', 'image/pjpeg','image/png',  'image/x-png');
			if(isset($_FILES['banner_pages_image']) && $_FILES["banner_pages_image"]["name"] != ""){
			$tmpName = $_FILES['banner_pages_image']['tmp_name'];
			if($this->input->post('prev_beer_image')!='' && $_FILES["banner_pages_image"]["name"]=="")
			{
				 $video_error .= "<p>Please select banner_pages image.</p>";
			}
			else 
			{
				
				list($width, $height, $type, $attr) = getimagesize($tmpName);
			}
			
			if($this->input->post('size')=='309x244')
			{
				if($width != 309 || $height != 244)
				{
				   $video_error .= "<p>banner_pages image size must be 309*244 px.</p>";
				}
			}
			elseif($this->input->post('size')=='300x625')
			{
				if($width != 300 || $height != 625)
				{
					$video_error .= "<p>banner_pages image size must be 300*625 px.</p>";
				}	
			} 	
		  }else if($this->input->post('prev_beer_image')==''){
				 $video_error .= "<p>Please select banner_pages image.</p>";
		  }
			
						
		
			// if($_FILES["banner_pages_image"]["name"]!="")
			// {
				// if(!in_array($_FILES["banner_pages_image"]["type"],$image_arr))
				// {
					// $video_error .= "<p>Please upload jpg,jpeg,png,gif format only</p>";
				// }
			// }	
// 			
			// $tmpName = $_FILES['banner_pages_image']['tmp_name'];
// 			
			// //print_r(getimagesize(front_base_url().'upload/banner_pages_thumb/'.$this->input->post('prev_beer_image')));
// 			
			// if($this->input->post('prev_beer_image')!='' && $_FILES["banner_pages_image"]["name"]=="")
			// {
				// list($width, $height, $type, $attr) = getimagesize(front_base_url().'upload/banner_pages_thumb/'.$this->input->post('prev_beer_image'));
			// }
			// else {
				// if($tmpName)
				// {
					// list($width, $height, $type, $attr) = getimagesize($tmpName);
				// }
// 				
			// }
			
			
				
		}		
		
		if($this->form_validation->run() == FALSE || $video_error != ""){
			if (validation_errors () || $video_error != "")
			{
				$data["error"] = validation_errors();
				$data["error"] .= $video_error;
			}else{
				$data["error"] = "";
			}
			$data["banner_pages_title"] = $this->input->post('banner_pages_title');
			$data["banner_pages_desc"] = $this->input->post('banner_pages_desc');
			
			$data["size"] = $this->input->post('size');
			$data["number_click"] = $this->input->post('number_click');
			$data["link"] = $this->input->post('link');
			$data["number_visit"] = $this->input->post('number_visit');
			$data["s_type"] = $this->input->post('s_type');
			$data["city_zip"] = $this->input->post('city_zip');
			
			$data["position"] = $this->input->post('position');
			
			$data["banner_pages_id"] = $this->input->post('banner_pages_id');
			if($this->input->post('allow_pages')){
			$data["pages"] = implode(",",$this->input->post('allow_pages'));
			}
			else {
				$data["pages"] = $this->input->post('allow_pages');
			}
			$data["status"] = $this->input->post('status');
			$data['pre_banner_pages_image']=$this->input->post('prev_beer_image');
			$data['type']=$this->input->post('type');
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_banner_pages';
			
			
			$data['site_setting'] = site_setting();
			
		
			if($this->input->post('offset')=="")
			{
				$limit = '10';
				$data["offset"] = 0;
			}else{
				$data["offset"] = $this->input->post('offset');
			}
			
			//echo "wait"; die;
			$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/banner_pages/add_city_banner_pages',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				//echo "else"; die;
			if($this->input->post('banner_pages_id')!='')
			{
				//echo "update" ; die;	
				$this->banner_pages_model->banner_pages_city_update();
				$msg = "update";
			}else{
					//echo "insert"; die;
				$this->banner_pages_model->banner_pages_city_insert();			
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
		 	
			 //echo ('banner_pages/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg); die;
			if($redirect_page == 'list_banner_pages')
			{
				redirect('banner_pages/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			else
			{
				redirect('banner_pages/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	// Use :This function use for edit of update banner_pages.
	// Param :banner_pages id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	
	function getAllCityOrZipcode($city)
	{
		
		$search = isset($_GET['c'])?$_GET['c']:'';
		 $operator_list = $this->banner_pages_model->getAllCityOrZipcode($search,$city);
		 
		// $html = '';
// 		
		// if($city=='city' || $city=='')
		// {
		 // if($operator_list)
		// {
			// foreach($operator_list as $list)
			// {
			 		// $html.= '<option value="'.$list->bar_id.'">'.$list->city.'</option>';
			// }
		// }
		// }
		// else {
			 // if($operator_list)
		// {
			// foreach($operator_list as $list)
			// {
			 		// $html.= '<option value="'.$list->bar_id.'">'.$list->zipcode.'</option>';
			// }
		// }
		// }
		echo json_encode($operator_list);
		die;
	}
	function edit_banner_pages($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
		
		$check_rights=get_rights('edit_banner_pages');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_user = $this->banner_pages_model->get_one_banner_pages($id);
		//print_r($one_user); 
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		$data["banner_pages_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		$data["banner_pages_title"] = $one_user['banner_pages_title'];
		$data["banner_pages_desc"] = $one_user['description'];
		$data['pre_banner_pages_image']= $one_user['banner_pages_image'];
		$data['type']= $one_user['type'];
		$data['link']= $one_user['url'];
		
		$data["size"] = $one_user['size'];
		$data["number_click"] = $one_user['number_click'];
		$data["number_visit"] = $one_user['number_visit'];
		$data["position"] = $one_user['position'];
		
		$data["pages"] =$one_user['pages'];
		$data['status']=$one_user['status'];
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/banner_pages/add_banner_pages',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
		function edit_city_banner_pages($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
		
		$check_rights=get_rights('edit_banner_pages');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_user = $this->banner_pages_model->get_one_banner_pages($id);
		//print_r($one_user); 
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		$data["banner_pages_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		$data["banner_pages_title"] = $one_user['banner_pages_title'];
		$data["banner_pages_desc"] = $one_user['description'];
		$data['pre_banner_pages_image']= $one_user['banner_pages_image'];
		$data['type']= $one_user['type'];
		$data['s_type']= $one_user['s_type'];
		$data['city_zip']= $one_user['city_zip'];
		$data['link']= $one_user['url'];
		
		$data["size"] = $one_user['size'];
		$data["number_click"] = $one_user['number_click'];
		$data["number_visit"] = $one_user['number_visit'];
		$data["position"] = $one_user['position'];
		
		$data["pages"] =$one_user['pages'];
		$data['status']=$one_user['status'];
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/banner_pages/add_city_banner_pages',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}

	// Use :This function use for Delete banner_pages.
	// Param :banner_pages id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function delete_banner_pages($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*   
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_banner_pages');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
         $data_log = array("activity_name" => "LOG_DELETE_ADMIN");
         maintain_log($data_log);
		//$this->db->delete('rights_assign',array('banner_pages_id'=>$id));
		$this->db->delete('banner_pages_master',array('banner_pages_id'=>$id));
		if($redirect_page == 'list_banner_pages')
		{
			
			redirect('banner_pages/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('banner_pages/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
        
        /// common function for insert all action//
           $data_log = array("activity_name" => "LOG_DELETE_ADMIN");
           maintain_log($data_log);
	}
	
	
	// Use :This function use for change status or delete banner_pages.
	// Param :'N/a'
	// Return :'N/A'
	function action_banner_pages()
	{
		/* Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('action_banner_pages');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
		
		$banner_pages_id =$this->input->post('chk');
		
		if($action=='delete')
		{
             /// common function for insert all action//
           $data_log = array("activity_name" => "LOG_DELETE_ADMIN");
           maintain_log($data_log);
               
                		
			foreach($banner_pages_id as $id)
			{			
				$this->db->query("delete from ".$this->db->dbprefix('banner_pages_master')." where banner_pages_id ='".$id."'");
			}
			
			if($redirect_page == 'list_banner_pages')
			{
				redirect('banner_pages/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('banner_pages/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
            //Log Entry	
            //echo  "mkjmkj"; die;	
           $data_log = array("activity_name" => "LOG_ACTIVE_ADMIN");
           maintain_log($data_log);    
                		
			foreach($banner_pages_id as $id)
			{			
				$data = array('status'=>'active');
				$this->db->where('banner_pages_id',$id);
				$this->db->update('banner_pages_master', $data);
			}
			if($redirect_page == 'list_banner_pages')
			{
				redirect('banner_pages/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('banner_pages/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive')
		{
		  //Log Entry        
           $data_log = array("activity_name" => "LOG_INACTIVE_ADMIN");
           maintain_log($data_log);   
                		
			foreach($banner_pages_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('banner_pages_id',$id);
				$this->db->update('banner_pages_master', $data);
			}
			
			if($redirect_page == 'list_banner_pages')
			{
				redirect('banner_pages/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('banner_pages/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');
			}
		}
	}
	function removeimage($banner_pages_id,$image,$limit,$offset,$redirect_page,$option,$keyword)
	{
		//echo "sdfsdf";die;
		if($image!='')
		{
			if(file_exists(base_path().'upload/banner_pages_orig/'.$image))
			{
				$link=base_path().'upload/banner_pages_orig/'.$image;
				unlink($link);
			}
			
			if(file_exists(base_path().'upload/banner_pages_thumb/'.$image))
			{
				$link1=base_path().'upload/banner_pages_thumb/'.$image;
				unlink($link1);
			}			
		}
		$msg='Image Removed';
		//redirect('serviceprovider/list_staff/'.$limit.'/'.$offset.'/'.$msg);
		redirect('banner_pages/edit_banner_pages/'.$banner_pages_id.'/'.$redirect_page.'/'.$limit);
	}
}
?>