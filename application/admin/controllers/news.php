<?php
class News extends  CI_Controller {
	function News()
	{
		parent::__construct();	
		$this->load->model('news_model');	
		$this->load->library('pagination');
	  
	}
	//use:for redirecting at list news page
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('news/list_news');	
	}
	
	/* news list
	 * param  : doctor id ,limit,offset,msg
	 * 
	 */
	function list_news($limit='10',$offset=0,$msg='') {
		
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
		
		$check_rights=get_rights('list_news');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
			$this->load->library('pagination');
		
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'news/list_news/'.$limit.'/';
		$config['total_rows'] = $this->news_model->get_total_news_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->news_model->get_news_result($offset,$limit);
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
		$data['redirect_page']='list_news';
		
		
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/news/list_news',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/* search patitent	 * param  : doctor id ,limit,option,keyword,offset,msg	 * 	 */
	function search_list_news($limit=20,$option='',$keyword='',$offset=0,$msg='')
	{		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('search_list_news');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_news';
		
		
		
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
		$config['base_url'] = base_url().'news/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->news_model->get_total_search_news_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->news_model->get_search_news_result($option,$keyword,$offset, $limit);
		
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
		$this->template->write_view('center',$theme .'/layout/news/list_news',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/*check unique news email
	 * param  : email
	 * return : BOOLEAN
	 */
	function newsname_check($name)
	{
		$newsname = $this->news_model->news_unique($name);
		if($newsname == FALSE)
		{
			$this->form_validation->set_message('newsname_check', 'There is an existing record with this News Name');
			return FALSE;
		}
		return TRUE;
	}
	
	/*add new news also called in news update
	 * param  : limit
	 * 
	 */
	function add_news($limit=0)
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
		
		$check_rights=get_rights('add_news');
		
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
		$this->form_validation->set_rules('news_title', 'News Title', 'required');
		$this->form_validation->set_rules('news_category', 'News Category', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');			
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			
			$data["news_id"] = $this->input->post('news_id');		
			$data["news_title"] = $this->input->post('news_title');
			$data["news_desc"] = $this->input->post('news_desc');
			$data["news_category"] =$this->input->post('news_category');
			$data["status"] = $this->input->post('status');
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_news';
			// $data['all_countries']=get_all_country();

			$data['site_setting'] = site_setting();
			
		
			if($this->input->post('offset')=="")
			{
				$limit = '10';
				$data["offset"] = 0;
			}else{
				$data["offset"] = $this->input->post('offset');
			}
			
			
			$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
			 $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/news/add_news',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}
		else
		{				
			if($this->input->post('news_id')!='')
			{	
				$this->news_model->news_update();
				$msg = "update";
			}else{
				$this->news_model->news_insert();			
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
			$did = $this->input->post('did');
		 	
			 
			if($redirect_page == 'list_news')
			{
				redirect('news/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			elseif ($redirect_page == 'list_news') {
				redirect('news/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}	
			else
			{
				redirect('news/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	/*news update form fill
	 * param  : news id,doctor id ,redirect page,option,keyword,limit,offset
	 * 
	 */
	function edit_news($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
		
		$check_rights=get_rights('edit_news');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_news = $this->news_model->get_one_news($id);
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		
		$data["news_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		
		$data["news_id"] = $one_news['news_id'];
		$data["news_title"] = $one_news['news_title'];
		$data["news_desc"] = $one_news['news_desc'];
		$data["news_category"] = $one_news['news_category'];
		$data["status"] = $one_news['status'];
		$data["author_name"] = $one_news['author_name'];
		
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/news/add_news',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/*delete news data
	 * param  : news id,doctor id ,option,keyword,limit,offset,msg
	 * 
	 */
	function delete_news($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_news');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$this->db->query("delete from ".$this->db->dbprefix('news')." where news_id ='".$id."'");
	
		//$this->db->delete('news',array('news_id'=>$id));
		if($redirect_page == 'list_news')
		{
			
			redirect('news/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('news/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	/*delete , active , inactive multiple news at a time
	 * param  : news id,doctor id ,redirect page,search option,search keyword,limit,offset,msg
	 * 
	 */ 
	function action_news()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_news');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
		
		$news_id =$this->input->post('chk');
			
		if($action=='delete')
		{			    		
			foreach($news_id as $id)
			{
				//$this->db->where('news_id',$id);
				//$this->db->delete('news',$data);			
				$this->db->query("delete from ".$this->db->dbprefix('news')." where news_id ='".$id."'");
			}
			
			if($redirect_page == 'list_news')
			{
				redirect('news/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('news/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
			foreach($news_id as $id)
			
			{			
				$data = array('status'=>'active');
				$this->db->where('news_id',$id);
				$this->db->update('news', $data);
			}
			if($redirect_page == 'list_news')
			{
				redirect('news/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('news/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive')
		{             		
			foreach($news_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('news_id',$id);
				$this->db->update('news', $data);
			}			
			if($redirect_page == 'list_news')
			{
				redirect('news/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('news/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');

			}			
		}			
	}	
}
?>