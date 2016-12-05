<?php
class Pages extends CI_Controller {
	
	
	function Pages()
	{
		parent::__construct();	
		$this->load->model('home_model');	
		$this->load->model('pages_model');	
		
		//$this->load->model('user_model');	
		
		
	}
	
	/* redirect to list pages
	 */
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}		
		redirect('pages/list_pages'); 
	}
	

	function list_pages($limit='10',$sort_type='sort',$sort_by='pages_id',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		
		 /* 
		 * Future enhancement
		 * when assigning rights is used
		 */
		$check_rights=get_rights('list_pages');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$data = array();
	
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
			
		$this->load->library('pagination');

		$config['uri_segment']='4';
		$config['base_url'] = base_url().'pages/list_pages/'.$limit.'/'.$sort_type.'/'.$sort_by.'/';
		$config['total_rows'] = $this->pages_model->get_total_pages_count();
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->pages_model->get_pages_result($offset,$limit,$sort_by,$sort_type);
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
		$data['redirect_page']='list_pages';
		$data['sort_type']=$sort_type;
		$data['sort_by']=$sort_by;
		$data['page_name']="list_pages";
		
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/pages/list_pages',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		
		$this->template->render();
	}

	/* add pages 
	 * param  : limit , sort type , sort by , option , keyword , option , msg
	 */
	function add_pages($limit=20,$sort_type='sort',$sort_by='pages_id',$option='',$keyword='',$offset=0,$msg='')
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		
		/* 
		* Future enhancement
		* when assigning rights is used
		*/
		
		$check_rights=get_rights('add_pages');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
				
		$data = array();
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$data['limit']=$limit;
		
		$this->load->library('form_validation');
		
		//$this->form_validation->set_rules('pages_title', 'Pages Title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		
		$data['page_name']="list_pages";
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			$data["pages_id"] = $this->input->post('pages_id');
			$data["pages_title"] = $this->input->post('pages_title');
			$data["description"] = $this->input->post('description');
			$data["description1"] = $this->input->post('description1');
			$data["slug"] = $this->input->post('slug');
			$data["active"] = $this->input->post('active');
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_pages';
			$data['sort_type']='desc';
			$data['sort_by']='pages_id';
		
			$data["meta_keyword"] = $this->input->post('meta_keyword');
			$data["meta_description"] = $this->input->post('meta_description');
			if($this->input->post('offset')=="")
			{
				//$limit = '10';
				////$data['limit']=$limit;
				//$totalRows = $this->pages_model->get_total_pages_count();
				//$data["offset"] = (int)($totalRows/$limit)*$limit;
				$limit = '10';
				
				$data["offset"] = 0;
				$data['limit']=$limit;
			}else{
				$data["offset"] = $this->input->post('offset');
			}
			
			$data['site_setting'] = site_setting();
			
					
			$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/pages/add_pages',$data,TRUE);
			 $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			 $this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);



			 
			 
			 $this->template->render();
			
		}else{
			if($this->input->post('pages_id'))
			{
				$this->pages_model->pages_update();
				$msg = "update";
			}else{
				$this->pages_model->pages_insert();
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
		 	$sort_type = $this->input->post('sort_type');
			$sort_by = $this->input->post('sort_by');
			 
			if($redirect_page == 'list_pages')
			{
				redirect('pages/'.$redirect_page.'/'.$limit.'/'.$sort_type.'/'.$sort_by.'/'.$offset.'/'.$msg);
			}
			else
			{
				redirect('pages/'.$redirect_page.'/'.$limit.'/'.$sort_type.'/'.$sort_by.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	/* edit pages 
	 * param  : page id , redirect page , sort type , sort by , option , keyword , limit , offset
	 */
	function edit_pages($id=0,$redirect_page='',$sort_type='',$sort_by='',$option='',$keyword='',$limit=0,$offset=0)
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		
		/* 
		* Future enhancement
		* when assigning rights is used
		*/
		
		$check_rights=get_rights('edit_pages');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$data = array();
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$data["limit"] = $limit;
		$one_pages = $this->pages_model->get_one_pages($id);
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		$data["sort_by"]=$sort_by;
		$data["sort_type"]=$sort_type;
		
		$data["pages_id"] = $id;
		$data["pages_title"] = $one_pages['pages_title'];
		$data["description"] = $one_pages['description'];
		$data["description1"] = $one_pages['description1'];
		$data["slug"] = $one_pages['slug'];
		$data["active"] = $one_pages['active'];
		$data["meta_keyword"] = $one_pages['meta_keyword'];
		$data["meta_description"] = $one_pages['meta_description'];
		
		$data["redirect_page"]=$redirect_page;
		$data['page_name']="list_pages";
		$data["base_url"] = base_url();
		$data['site_setting']=site_setting();
		$data['page_name']="list_pages";
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/pages/add_pages',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/* Delete pages
	 * param  : page id ,redirect page,option,keyword,sort type,sort by,limit,offset
	 * 
	 */
	function delete_pages($id=0,$redirect_page='',$option='',$keyword='',$sort_type='sort',$sort_by='admin_id',$limit=20,$offset=0)
	{
	  	
		$check_rights=get_rights('delete_pages');
				
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
	  $limit=10;
	  $msg='delete';
      
      /// Log entry
           $data_log = array("activity_name" => "LOG_DELETE_PAGE");
           maintain_log($data_log);
           
	  $this->db->delete('pages',array('pages_id'=>$id));
		
		if($redirect_page == 'list_pages')
		{
			
			redirect('pages/'.$redirect_page.'/'.$limit.'/'.$sort_type.'/'.$sort_by.'/'.$offset.'/delete');
		}
		else
		{
			redirect('pages/'.$redirect_page.'/'.$limit.'/'.$sort_type.'/'.$sort_by.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	/* action pages
	 * param  : page id ,action,redirect page,search option,search keyword,limit,offset
	 * 
	 */
	function action_pages()
	{
	 
	 	$check_rights=get_rights('action_pages');
				
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}		
			
	 	$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
		
		$sort_type = $this->input->post('action_sorttype');
		$sort_by = $this->input->post('action_sortby');
		$ids =$this->input->post('chk');
		
		if($action=="delete")
		{
		      /// Log entry
           $data_log = array("activity_name" => "LOG_DELETE_PAGE");
           maintain_log($data_log);
           		
			foreach($ids as $id)
			{			
				
				$this->db->delete('pages',array('pages_id'=>$id));
			}
			
			
			if($redirect_page == 'list_pages')
			{
				redirect('pages/'.$redirect_page.'/'.$limit.'/'.$sort_type.'/'.$sort_by.'/'.$offset.'/delete');
			}
			else
			{
				redirect('pages/'.$redirect_page.'/'.$limit.'/'.$sort_type.'/'.$sort_by.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
		}
		
		if($action=="active")
		{
	       /// Log entry
           $data_log = array("activity_name" => "LOG_ACTIVE_PAGE");
           maintain_log($data_log);  
                		
			foreach($ids as $id)
			{			
				$data = array("active"=>"0");
				$this->db->where('pages_id',$id);
				$this->db->update('pages', $data);
			}
			
			if($redirect_page == 'list_pages')
			{
				redirect('pages/'.$redirect_page.'/'.$limit.'/'.$sort_type.'/'.$sort_by.'/'.$offset.'/active');
			}
			else
			{
				redirect('pages/'.$redirect_page.'/'.$limit.'/'.$sort_type.'/'.$sort_by.'/'.$option.'/'.$keyword.'/'.$offset.'/active');

			}
          
		}
		
		if($action=="inactive")
		{
			    
            /// Log entry
           $data_log = array("activity_name" => "LOG_INACTIVE_PAGE");
           maintain_log($data_log);  
               		
			foreach($ids as $id)
			{			
				$data = array("active"=>"1");
				$this->db->where('pages_id',$id);
				$this->db->update('pages', $data);
			}
			
			if($redirect_page == 'list_pages')
			{
				redirect('pages/'.$redirect_page.'/'.$limit.'/'.$sort_type.'/'.$sort_by.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('pages/'.$redirect_page.'/'.$limit.'/'.$sort_type.'/'.$sort_by.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');

			}
			
		}	
		
	}
	
	/* search pages 
	 * param  : limit,sort type,sort by,option,keyword,offset,msg
	 * 
	 */
	function search_list_pages($limit=20,$sort_type='sort',$sort_by='pages_id',$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		
		/* 
		* Future enhancement
		* when assigning rights is used
		*/
		
		$check_rights=get_rights('search_list_pages');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$data['page_name']="list_pages";
				
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
		//$keyword = str_replace(' ','+',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',trim($keyword)));
		$redirect_page = 'search_list_pages';
		
		
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'pages/search_list_pages/'.$redirect_page.'/'.$limit.'/'.$sort_type.'/'.$sort_by.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->pages_model->get_total_search_pages_count($option,$keyword,$sort_type,$sort_by);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->pages_model->get_search_pages_result($option,$keyword,$sort_type,$sort_by,$offset, $limit);
		$data['msg'] = $msg;
		$data['offset'] = $offset;
		
		
		
		$data['site_setting'] = site_setting();
		
		
		$data['option']=$option;
		$data['limit']=$limit;
		
		$data['keyword']=$keyword;
		$data['search_type']='search';
		$data['redirect_page']=$redirect_page;
		$data['sort_type']=$sort_type;
		$data['sort_by']=$sort_by;
		
		
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		 $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/pages/list_pages',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}


	function editorimage()
	{
	//	$url = '../images/uploads/’.time()."_".$_FILES['upload']['name']';
		
		$url = base_path()."upload/barlogo/".time()."_".$_FILES['upload']['name'];
		$url1 = front_base_url()."upload/barlogo/".time()."_".$_FILES['upload']['name'];

 //extensive suitability check before doing anything with the file…
    if (($_FILES['upload'] == "none") OR (empty($_FILES['upload']['name'])) )
    {
       $message = "No file uploaded.";
    }
    else if ($_FILES['upload']["size"] == 0)
    {
       $message = "The file is of zero length.";
    }
    else if (($_FILES['upload']["type"] != "image/pjpeg") AND ($_FILES['upload']["type"] != "image/jpeg") AND ($_FILES['upload']["type"] != "image/png"))
    {
       $message = "The image must be in either JPG or PNG format. Please upload a JPG or PNG instead.";
    }
    else if (!is_uploaded_file($_FILES['upload']["tmp_name"]))
    {
       $message = "You may be attempting to hack our server. We’re on to you; expect a knock on the door sometime soon.";
    }
    else {
      $message = "";
      $move = @ move_uploaded_file($_FILES['upload']['tmp_name'], $url);
      if(!$move)
      {
         $message = "Error moving uploaded file. Check the script is granted Read/Write/Modify permissions.";
      }
      $url = "../" . $url;
    }
			$funcNum = $_GET['CKEditorFuncNum'] ;
			//echo "<script type=’text/javascript’>window.parent.CKEDITOR.tools.callFunction('$funcNum', '$url', '$message');</script>";
			echo "<script type='text/javascript'>alert('done');window.parent.CKEDITOR.tools.callFunction($funcNum, '$url1', '$message');</script>";
	}




	
	
}

?>