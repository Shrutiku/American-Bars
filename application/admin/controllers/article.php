<?php
class Article extends  CI_Controller {
	function Article()
	{
	    
		parent::__construct();	
		$this->load->model('blog_model');
		
	}
	
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('article/list_article');
		
		$check_rights=get_rights('list_article');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
	}
	
	// Use :This function use for Lost all blog of User.
	// Param :limit,offset,message
	// Return :'N/A'
	function list_article($limit='10',$offset=0,$msg='')
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
		
		$check_rights=get_rights('list_article');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('pagination');

		//$data['user_id']=$user_id;
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'article/list_article/'.$limit.'/';
		$config['total_rows'] = $this->blog_model->get_total_admin_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
       // $data['user_id']=$user_id;
		
		$data['result'] = $this->blog_model->get_blog_result($offset,$limit);
        
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
		$data['redirect_page']='list_article';
		
		$data['site_setting'] = site_setting();

		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/blog/list_blog',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for list admin by filter.
	// Param :limit,option,keyword,offset,message
	// Return :'N/A'
	function search_list_article($limit=20,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$redirect_page = 'search_list_article';
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('search_list_article');
		
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
		$config['total_rows'] = $this->blog_model->get_total_search_admin_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->blog_model->get_search_admin_result($option,$keyword,$offset, $limit);
		
		
		if($data['result']==0){
		$offset=0;
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'admin/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->blog_model->get_total_search_admin_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->blog_model->get_search_admin_result($option,$keyword,$offset, $limit);
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
		$this->template->write_view('center',$theme .'/layout/admin/list_blog',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for add new admin.
	// Param :'N/A'
	// Return :'N/A'
	
	function add_article($limit=0)
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
		
		$check_rights=get_rights('add_article');
		
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
		$this->form_validation->set_rules('blog_title', 'Blog Title', 'required');
		$this->form_validation->set_rules('blog_description', 'Description', 'required');
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
					
			$data["active"] = $this->input->post('active');
			$data['blog_description']=$this->input->post('blog_description');
			$data['user_id']=$this->input->post('user_id');
			$data['blog_id'] = $this->input->post('blog_id');
			$data['blog_title'] = $this->input->post('blog_title');
			$data['pre_blog_image']=$this->input->post('prev_beer_image');
			$data['blog_meta_title']=$this->input->post('blog_meta_title');
			$data['blog_meta_keyword']=$this->input->post('blog_meta_keyword');
			$data['blog_meta_description']=$this->input->post('blog_meta_description');
			$data["search_option"]='';
			$data["search_keyword"]='';
             
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_article';
			
			
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
			$this->template->write_view('center',$theme .'/layout/blog/add_blog',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				
			if($this->input->post('blog_id')!='')
			{	
				$this->blog_model->blog_update();
				$msg = "update";
			}else{
				$this->blog_model->blog_insert();			
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
			
			 
			if($redirect_page == 'list_article')
			{
				redirect('article/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			else
			{
				redirect('article/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	
	// Use :This function use for edit of update admin.
	// Param :admin id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function edit_article($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
		
		$check_rights=get_rights('edit_article');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_blog = $this->blog_model->get_one_blog($id);
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		//$data["user_id"] = $user_id;
        $data["blog_id"] = $id;
		$data["user_id"] = $one_blog['user_id'];
		$data["redirect_page"]=$redirect_page;
		$data["blog_description"] = $one_blog['blog_description'];
		$data["active"] = $one_blog['status'];
		$data['blog_title'] = $one_blog['blog_title'];
		$data['pre_blog_image']= $one_blog['blog_image'];
		$data['blog_meta_title']=$one_blog['blog_meta_title'];
		$data['blog_meta_keyword']=$one_blog['blog_meta_keyword'];
		$data['blog_meta_description']=$one_blog['blog_meta_description'];
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/blog/add_blog',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}

	// Use :This function use for Delete blog.
	// Param :blog id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function delete_article($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*   
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_article');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		// $this->db->delete('blog',array('blog_id'=>$id));
		// $this->db->delete('blog',array('master_id'=>$id));
		
			$this->db->query("delete from ".$this->db->dbprefix('blog')." where blog_id ='".$id."'");
			$this->db->query("delete from ".$this->db->dbprefix('blog')." where master_id ='".$id."'");
		if($redirect_page == 'list_article')
		{
			
			redirect('article/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('article/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	
	// Use :This function use for change status or delete blog.
	// Param :'N/a'
	// Return :'N/A'
	function action_article()
	{
		/* Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_article');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
        
		
		$blog_id =$this->input->post('chk');
        //$user_id = $this->input->post('search_user_id');
		
		if($action=='delete')
		{		
			foreach($blog_id as $id)
			{			
				$this->db->query("delete from ".$this->db->dbprefix('blog')." where blog_id ='".$id."' or master_id ='".$id."' ");
				
			}
			
			if($redirect_page == 'list_article')
			{
				redirect('article/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('article/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{		
			foreach($blog_id as $id)
			{			
				$data = array('status'=>'active');
				$this->db->where('blog_id',$id);
				$this->db->update('blog', $data);
			}
			if($redirect_page == 'list_article')
			{
				redirect('article/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('article/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive')
		{		
			foreach($blog_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('blog_id',$id);
				$this->db->update('blog', $data);
			}
			
			if($redirect_page == 'list_article')
			{
				redirect('article/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('article/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');

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
		
		$check_rights=get_rights('reply_message_article');
				
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//echo $id; die;
		$one_message = $this->blog_model->get_blog($id);
		//print_r($one_message); die;
	
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		$data["redirect_page"]=$redirect_page;
		
		$data["blog_id"] = $id;
		$data["user_id"] = $one_message['user_id'];
		$data["blog_title"] = $one_message['blog_title'];
		$data["date_created"] = $one_message['date_added'];
		$data["first_name"] = $one_message['first_name'];
		$data["last_name"] = $one_message['last_name'];
		$data["blog_description"] = $one_message['blog_description'];
		$data["master_id"] = $one_message['master_id'];
		
		$data['reply'] = $this->blog_model->get_list($id,$data["master_id"]);
		//print_r($data['reply']); die;
		
		//update data
	    $data_update = array("blog_id"=>$id);
	    $this->db->where("blog_id",$id);
	    $this->db->update("blog",$data_update);
		//end of update data//
	
		
		if($_POST){
			$this->blog_model->reply_insert();			
			$msg = "insert"; 
			//echo 'forum/view/'.$limit.'/'.$offset; die;
			 redirect('article/view/'.$id.'/'.$limit.'/'.$offset.'/'.$msg);
			
		}
		
		$data['total_comment']=$this->blog_model->get_blog_count($id);
		//print_r($data['total']);
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/blog/view',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();

	}
	
		function delete_comment($blog_id = 0, $blog_comment_id = 0 )
	{
			$check_rights=get_rights('delete_blog_comment');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$qry = $this->db->query("delete from ".$this->db->dbprefix("blog_comment")." where blog_comment_id = '".$blog_comment_id."' or 
		master_comment_id = '".$beer_comment_id."'");
		
		redirect ("article/view/".$blog_id."/delete");
	}
	
}


?>