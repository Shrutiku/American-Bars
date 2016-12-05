<?php
class State extends  CI_Controller {
	//contructor
	function State()
	{
		 parent::__construct();	
		$this->load->model('state_model');	
	}
	
	//to redirect on list page
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('state/list_state');	
	}
	
	/* state listing function
	 * param  : limit,offset,msg
	 * 
	 */
	function list_state($limit='10',$offset=0,$msg='')
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
		 $check_rights=get_rights('list_state');
				
				if(	$check_rights==0) {			
					redirect('home/dashboard/no_rights');	
				}*/
		
		
		$this->load->library('pagination');

		$config['uri_segment']='4';
		$config['base_url'] = base_url().'state/list_state/'.$limit.'/';
		$config['total_rows'] = $this->state_model->get_total_state_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->state_model->get_state_result($offset, $limit);
		$data['msg'] = $msg;
		$data['error']='';
		$data['offset'] = $offset;
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
		$data['redirect_page']='list_state';
		
		$data['site_setting'] = site_setting();

		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/state/list_state',$data,TRUE);
		
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}

	/* serach state
	 * param  : limit,option,keyword,offset,msg
	 * 
	 */
	function search_list_state($limit=20,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_state';
		/*
		 * Future enhancement
		 * when assigning rights is used
		$check_rights=get_rights('list_state');
				
				if(	$check_rights==0) {			
					redirect('home/dashboard/no_rights');	
				}*/
		
		
		$this->load->library('pagination');
		if($_POST)
		{		
			$option=$this->input->post('option');
			$keyword=str_replace(' ','-',$this->input->post('keyword'));
		}
		else
		{
			$option=$option;
			$keyword=str_replace(' ','-',$keyword);	
					
		}
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',trim($keyword)));
	
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'state/search_list_state/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->state_model->get_total_search_state_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->state_model->get_search_state_result($option,$keyword,$offset, $limit);
		$data['msg'] = $msg;
		$data['offset'] = $offset;
		
		
		$data['site_setting'] = site_setting();
		
		$data['limit']=$limit;
		$data['option']=$option;
		$data['keyword']=$keyword;
		$data['search_type']='search';
		$data['redirect_page']=$redirect_page;
		
		
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		 $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/state/list_state',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/* check unique state name
	 * param  : state name
	 * 
	 */
	function state_check($state_name)
	{
		$username = $this->state_model->state_unique($state_name);
		if($username == TRUE)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('state_check', 'There is an existing state associated with this Name');
			return FALSE;
		}
	}
	
	/* add new state 
	 * param  : limit
	 * 
	 */
	function add_state($limit="20")
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
		$check_rights=get_rights('list_state');
				
				if(	$check_rights==0) {			
					redirect('home/dashboard/no_rights');	
				}*/
		
		$data['limit']=$limit;
		$data['all_country'] = get_all_country();

		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('country_id', 'Country Name', 'required');
		$this->form_validation->set_rules('state_name', 'State Name', 'required|callback_state_check');
	
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			$data["state_id"] = $this->input->post('state_id');
			$data["country_id"] = $this->input->post('country_id');
			$data["state_name"] = $this->input->post('state_name');
		    $data["is_delete"] = $this->input->post('is_delete');
			$data['site_setting'] = site_setting();
			$data['all_countries']=get_all_countries();
			
		
			if($this->input->post('offset')=="")
			{
				$limit = '10';
				
				$data["offset"] = 0;
			}else{
				$data["offset"] = $this->input->post('offset');
			}
			$data["offset"]=0;
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_state';	
			
			
			$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/state/add_state',$data,TRUE);
			 $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				
			if($this->input->post('state_id')!='')
			{	
				$this->state_model->state_update();
				$msg = "update";
			}else{
				$this->state_model->state_insert();			
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
			
			if($redirect_page == 'list_state')
			{
				redirect('state/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			else
			{
				redirect('state/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
			
		}				
	}
	
	/* edit state 
	 * param  : state id ,redirect page,option,keyword,limit,offset
	 * 
	 */
	function edit_state($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
				$check_rights=get_rights('list_state');
				
				if(	$check_rights==0) {			
					redirect('home/dashboard/no_rights');	
				}*/
		
		
		
		
		$one_state = $this->state_model->get_one_state($id);
		$data['all_country'] = get_all_country();

		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		$data["redirect_page"]=$redirect_page;
		$data["state_id"] = $id;
		$data["country_id"] = $one_state['country_id'];
		$data["state_name"] = $one_state['state_name'];
		$data["is_delete"] = $one_state['is_delete'];
		$data['all_countries']=get_all_countries();
		
		
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/state/add_state',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/* delete state
	 * param  : state id,redirect page ,limit,offset,msg
	 * 
	 */
	function delete_state($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
	  
		/*
		 * Future enhancement
		 * when assigning rights is used
		$check_rights=get_rights('list_state');
				
				if(	$check_rights==0) {			
					redirect('home/dashboard/no_rights');	
				}
				*/
		
		
		$this->db->delete('state_master',array('state_id'=>$id));
		
		if($redirect_page == 'list_state')
		{
			
			redirect('state/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('state/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
		
		
	}
		
	/* action state for multiple transaction of delete,active,inactive
	 * param  : state id ,redirect page,option,keyword,limit,offset
	 * 
	 */
	function action_state()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		$check_rights=get_rights('list_state');
				
			if(	$check_rights==0) {			
				redirect('home/dashboard/no_rights');	
		}*/
	
		$offset=$this->input->post('offset');
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		$state_id =$this->input->post('chk');
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword = $this->input->post('serach_keyword');
		
			
		if($action=='delete')
		{		
			foreach($state_id as $id)
			{			
				$this->db->query("delete from ".$this->db->dbprefix('state_master')." where state_id ='".$id."'");
			}
			
			
			if($redirect_page == 'list_state')
			{
				
				redirect('state/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('state/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');
	
			}
			
		}
			
		if($action=='active')
		{		
			foreach($state_id as $id)
			{			
				$data = array('status'=>'active');
				$this->db->where('state_id',$id);
				$this->db->update('state_master', $data);
			}
			
			if($redirect_page == 'list_state')
			{
				
				redirect('state/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('state/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
	
			}
			
		}	
		if($action=='inactive')
		{		
			foreach($state_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('state_id',$id);
				$this->db->update('state_master', $data);
			}
			
			if($redirect_page == 'list_state')
			{
				
				redirect('state/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('state/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');
	
			}
			
		}	
	}
	
	
}


?>