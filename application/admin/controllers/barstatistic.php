<?php
class Barstatistic extends  CI_Controller {
	function Barstatistic()
	{
		parent::__construct();	
		$this->load->model('barstatistic_model');	
		$this->load->library('pagination');
	  
	}
	//use:for redirecting at list barstatistic page
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('barstatistic/list_barstatistic');	
	}
	
	/* barstatistic list
	 * param  : doctor id ,limit,offset,msg
	 * 
	 */
	function list_barstatistic($limit='10',$offset=0,$msg='') {
		
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
		
		$check_rights=get_rights('list_barstatistic');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
			$this->load->library('pagination');
		
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'barstatistic/list_barstatistic/'.$limit.'/';
		$config['total_rows'] = $this->barstatistic_model->get_total_barstatistic_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->barstatistic_model->get_barstatistic_result($offset,$limit);
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
		$data['redirect_page']='list_barstatistic';
		
		
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/barstatistic/list_barstatistic',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/* search patitent	 * param  : doctor id ,limit,option,keyword,offset,msg	 * 	 */
	function search_list_barstatistic($limit=20,$option='',$keyword='',$offset=0,$msg='')
	{		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('search_list_barstatistic');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_barstatistic';
		
		
		
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
		$config['base_url'] = base_url().'barstatistic/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->barstatistic_model->get_total_search_barstatistic_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->barstatistic_model->get_search_barstatistic_result($option,$keyword,$offset, $limit);
		
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
		$this->template->write_view('center',$theme .'/layout/barstatistic/list_barstatistic',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/*check unique barstatistic email
	 * param  : email
	 * return : BOOLEAN
	 */
	function barstatisticname_check($name)
	{
		$barstatisticname = $this->barstatistic_model->barstatistic_unique($name);
		if($barstatisticname == FALSE)
		{
			$this->form_validation->set_message('barstatisticname_check', 'There is an existing record with this News Name');
			return FALSE;
		}
		return TRUE;
	}
	
	/*add new barstatistic also called in barstatistic update
	 * param  : limit
	 * 
	 */
	function add_barstatistic($limit=0)
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
		
		$check_rights=get_rights('add_barstatistic');
		
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
		$this->form_validation->set_rules('category', 'Bar Statistic Category', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');			
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			
			$data["bar_statistic_id"] = $this->input->post('bar_statistic_id');		
			$data["question"] = $this->input->post('question');
			$data["category"] =$this->input->post('category');
			$data["answer"] = $this->input->post('answer');			
			$data["status"] = $this->input->post('status');
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_barstatistic';
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
			$this->template->write_view('center',$theme .'/layout/barstatistic/add_barstatistic',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}
		else
		{				
			if($this->input->post('bar_statistic_id')!='')
			{	
				$this->barstatistic_model->barstatistic_update();
				$msg = "update";
			}else{
				$this->barstatistic_model->barstatistic_insert();			
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
		 	
			 
			if($redirect_page == 'list_barstatistic')
			{
				redirect('barstatistic/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			elseif ($redirect_page == 'list_barstatistic') {
				redirect('barstatistic/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}	
			else
			{
				redirect('barstatistic/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	/*barstatistic update form fill
	 * param  : barstatistic id,doctor id ,redirect page,option,keyword,limit,offset
	 * 
	 */
	function edit_barstatistic($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
		
		$check_rights=get_rights('edit_barstatistic');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_barstatistic = $this->barstatistic_model->get_one_barstatistic($id);
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		
		$data["bar_statistic_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		
		
		$data["question"] = $one_barstatistic["question"];
		$data["category"] = $one_barstatistic["category"];
		$data["answer"] = $one_barstatistic["answer"];
		$data["status"] = $one_barstatistic["status"];
		
		$data['site_setting'] = site_setting();
				
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/barstatistic/add_barstatistic',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/*delete barstatistic data
	 * param  : barstatistic id,doctor id ,option,keyword,limit,offset,msg
	 * 
	 */
	function delete_barstatistic($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_barstatistic');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$this->db->query("delete from ".$this->db->dbprefix('bar_statistic')." where bar_statistic_id ='".$id."'");
	
		//$this->db->delete('barstatistic',array('bar_statistic'=>$id));
		if($redirect_page == 'list_barstatistic')
		{
			
			redirect('barstatistic/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('barstatistic/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	/*delete , active , inactive multiple barstatistic at a time
	 * param  : barstatistic id,doctor id ,redirect page,search option,search keyword,limit,offset,msg
	 * 
	 */ 
	function action_barstatistic()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_barstatistic');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
		
		$bar_statistic =$this->input->post('chk');
			
		if($action=='delete')
		{			    		
			foreach($bar_statistic as $id)
			{
				//$this->db->where('bar_statistic_id',$id);
				//$this->db->delete('bar_statistic',$data);			
				$this->db->query("delete from ".$this->db->dbprefix('bar_statistic')." where bar_statistic_id ='".$id."'");
			}
			
			if($redirect_page == 'list_barstatistic')
			{
				redirect('barstatistic/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('barstatistic/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
			foreach($bar_statistic as $id)
			
			{			
				$data = array('status'=>'active');
				$this->db->where('bar_statistic_id',$id);
				$this->db->update('bar_statistic', $data);
			}
			if($redirect_page == 'list_barstatistic')
			{
				redirect('barstatistic/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('barstatistic/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive')
		{             		
			foreach($bar_statistic as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('bar_statistic_id',$id);
				$this->db->update('bar_statistic', $data);
			}			
			if($redirect_page == 'list_barstatistic')
			{
				redirect('barstatistic/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('barstatistic/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');

			}			
		}			
	}	
}
?>