<?php
class Resource extends  CI_Controller {
	function Resource()
	{
		parent::__construct();	
		$this->load->model('resource_model');	
		$this->load->library('pagination');
	  
	}
	//use:for redirecting at list resource page
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
	
		redirect('resource/list_resource');	
	}
	
	/* resource list
	 * param  : doctor id ,limit,offset,msg
	 * 
	 */
	function list_resource($limit='10',$offset=0,$msg='') {
		
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
		
		$check_rights=get_rights('list_resource');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
			$this->load->library('pagination');
		
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'resource/list_resource/'.$limit.'/';
		$config['total_rows'] = $this->resource_model->get_total_resource_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->resource_model->get_resource_result($offset,$limit);
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
		$data['redirect_page']='list_resource';
		
		
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/resource/list_resource',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/* search patitent	 * param  : doctor id ,limit,option,keyword,offset,msg	 * 	 */
	function search_list_resource($limit=20,$option='',$keyword='',$offset=0,$msg='')
	{		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('search_list_resource');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_resource';
		
		
		
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
		$config['base_url'] = base_url().'resource/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->resource_model->get_total_search_resource_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->resource_model->get_search_resource_result($option,$keyword,$offset, $limit);
		
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
		$this->template->write_view('center',$theme .'/layout/resource/list_resource',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/*check unique resource email
	 * param  : email
	 * return : BOOLEAN
	 */
	function resourcename_check($name)
	{
		$resourcename = $this->resource_model->resource_unique($name);
		if($resourcename == FALSE)
		{
			$this->form_validation->set_message('resourcename_check', 'There is an existing record with this News Name');
			return FALSE;
		}
		return TRUE;
	}
	
	/*add new resource also called in resource update
	 * param  : limit
	 * 
	 */
	function add_resource($limit=0)
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
		
		$check_rights=get_rights('add_resource');
		
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
		$this->form_validation->set_rules('resource_category', 'Bar Statistic Category', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');			
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			
			$data["resource_id"] = $this->input->post('resource_id');		
			$data["resource_title"] = $this->input->post('resource_title');
			$data["resource_desc"] = $this->input->post('resource_desc');
			$data["resource_category"] =$this->input->post('resource_category');
			$data["website"] =$this->input->post('website');
			$data["status"] = $this->input->post('status');
			$data["resource_meta_title"] = $this->input->post('resource_meta_title');
			$data["resource_meta_keyword"] = $this->input->post('resource_meta_keyword');
			$data["resource_meta_description"] = $this->input->post('resource_meta_description');
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_resource';
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
			$this->template->write_view('center',$theme .'/layout/resource/add_resource',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}
		else
		{				
			if($this->input->post('resource_id')!='')
			{	
				$this->resource_model->resource_update();
				$msg = "update";
			}else{
				$this->resource_model->resource_insert();			
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
		 	
			 
			if($redirect_page == 'list_resource')
			{
				redirect('resource/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			elseif ($redirect_page == 'list_resource') {
				redirect('resource/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}	
			else
			{
				redirect('resource/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	/*resource update form fill
	 * param  : resource id,doctor id ,redirect page,option,keyword,limit,offset
	 * 
	 */
	function edit_resource($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
		
		$check_rights=get_rights('edit_resource');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_resource = $this->resource_model->get_one_resource($id);
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		
		$data["resource_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		
		$data["resource_title"] = $one_resource["resource_title"];
		$data["resource_desc"] = $one_resource["resource_desc"];
		$data["resource_category"] = $one_resource["resource_category"];
		$data["website"] = $one_resource["website"];
		$data["status"] = $one_resource["status"];
		$data["resource_meta_title"] = $one_resource['resource_meta_title'];
		$data["resource_meta_keyword"] = $one_resource['resource_meta_keyword'];
		$data["resource_meta_description"] = $one_resource['resource_meta_description'];	
			
			
		
		$data['site_setting'] = site_setting();
				
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/resource/add_resource',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/*delete resource data
	 * param  : resource id,doctor id ,option,keyword,limit,offset,msg
	 * 
	 */
	function delete_resource($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_resource');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$this->db->query("delete from ".$this->db->dbprefix('resource')." where resource_id ='".$id."'");
	
		//$this->db->delete('resource',array('bar_statistic'=>$id));
		if($redirect_page == 'list_resource')
		{
			
			redirect('resource/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('resource/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	/*delete , active , inactive multiple resource at a time
	 * param  : resource id,doctor id ,redirect page,search option,search keyword,limit,offset,msg
	 * 
	 */ 
	function action_resource()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_resource');
		
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
			
				$this->db->query("delete from ".$this->db->dbprefix('resource')." where resource_id ='".$id."'");
			}
			
			if($redirect_page == 'list_resource')
			{
				redirect('resource/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('resource/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
			foreach($bar_statistic as $id)
			
			{			
				$data = array('status'=>'active');
				$this->db->where('resource_id',$id);
				$this->db->update('resource', $data);
			}
			if($redirect_page == 'list_resource')
			{
				redirect('resource/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('resource/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive')
		{             		
			foreach($bar_statistic as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('resource_id',$id);
				$this->db->update('resource', $data);
			}			
			if($redirect_page == 'list_resource')
			{
				redirect('resource/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('resource/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');

			}			
		}			
	}	
}
?>