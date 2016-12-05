<?php
class Country extends  CI_Controller {
	function Country()
	{
		 parent::__construct();	
		$this->load->model('country_model');	
	}
	
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('country/list_country');	
	}
	
	// Use :This function use for Lost all Country.
	// Param :limit,offset,message
	// Return :'N/A'
	function list_country($limit='10',$offset=0,$msg='')
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
		 $check_rights=get_rights('list_country');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}*/
		
		$this->load->library('pagination');

		$config['uri_segment']='4';
		$config['base_url'] = base_url().'country/list_country/'.$limit.'/';
		$config['total_rows'] = $this->country_model->get_total_country_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->country_model->get_country_result($offset, $limit);
		$data['msg'] = $msg;
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
		$data['redirect_page']='list_country';
		
		$data['site_setting'] = site_setting();

		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/country/list_country',$data,TRUE);
		
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
// Use :This function use for list Country by filter.
	// Param :limit,option,keyword,offset,message
	// Return :'N/A'
	function search_list_country($limit=20,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_country';
		/* 
		 * Future enhancement
		 * when assigning rights is used
		 * $check_rights=get_rights('list_country');
 		
		 if(	$check_rights==0) {			
			 redirect('home/dashboard/no_rights');	
		 } */
		
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
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',trim($keyword)));
	
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'country/search_list_country/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->country_model->get_total_search_country_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->country_model->get_search_country_result($option,$keyword,$offset, $limit);
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
		$this->template->write_view('center',$theme .'/layout/country/list_country',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}


	// Use :This function use for check unique Country Name.
	// Param :country name
	// Return :Boolean
	
	function country_check($country_name)
	{
		$country_name = $this->country_model->country_unique($country_name);
		if($country_name == TRUE)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('country_check', EXIST_COUNTRY);
			return FALSE;
		}
	}
	
	
	// Use :This function use for add new Country.
	// Param :'N/A'
	// Return :'N/A'
	
	function add_country($limit="20")
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/*
		 *Future enhancement
		 * when assigning rights is used
		$check_rights=get_rights('list_country');
				
				if(	$check_rights==0) {			
					redirect('home/dashboard/no_rights');	
				}
				*/
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('country_name', 'Country Name', 'required|callback_country_check');
		$this->form_validation->set_rules('country_iso_Code', 'Country ISO Code', 'required');
		
		
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			$data["country_id"] = $this->input->post('country_id');
			$data["country_name"] = $this->input->post('country_name');
			$data["country_iso_Code"] = $this->input->post('country_iso_Code');
			
		    $data["is_delete"] = $this->input->post('is_delete');
						
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_country';	
					
			
			$data['site_setting'] = site_setting();
			
			if($this->input->post('offset')=="")
			{
				//$limit = '10';
				$data["offset"] = 0;
			}else{
				$data["offset"] = $this->input->post('offset');
			}
			$data['limit']=$limit;
			$data["offset"]=0;
			$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/country/add_country',$data,TRUE);
			 $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				
			if($this->input->post('country_id')!='')
			{	
				$this->country_model->country_update();
				$msg = "update";
			}else{
				$this->country_model->country_insert();			
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
		 	
			 
			if($redirect_page == 'list_country')
			{
				redirect('country/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			else
			{
				redirect('country/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
			
		}				
	}


	// Use :This function use for edit of update Country.
	// Param :country id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function edit_country($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
		
		
		
		$one_country = $this->country_model->get_one_country($id);
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		$data["redirect_page"]=$redirect_page;
		$data["country_id"] = $id;
		$data["country_name"] = $one_country['Country_Name'];
		$data["country_iso_Code"] = $one_country['Countries_ISO_Code'];
		$data["is_delete"] = $one_country['is_delete'];
				
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/country/add_country',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	
	// Use :This function use for Delete Country.
	// Param :Country id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	function delete_country($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*
		 *  Future enhancement
		 * when assigning rights is used
		$check_rights=get_rights('list_country');
				
				if(	$check_rights==0) {			
					redirect('home/dashboard/no_rights');	
				}
				*/
		
		
		$this->db->delete('country_master',array('country_id'=>$id));
		if($redirect_page == 'list_country')
		{
			
			redirect('country/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('country/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	
	
	// Use :This function use for change status or delete Country.
	// Param :'N/a'
	// Return :'N/A'
	
	function action_country()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		$check_rights=get_rights('list_country');
				
				if(	$check_rights==0) {			
					redirect('home/dashboard/no_rights');	
				}*/
		
		
		
		$offset=$this->input->post('offset');
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		$country_id =$this->input->post('chk');
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
			
		if($action=='delete')
		{		
			foreach($country_id as $id)
			{			
				$this->db->query("delete from ".$this->db->dbprefix('country_master')." where country_id ='".$id."'");
			}
			
			if($redirect_page == 'list_country')
			{
				
				redirect('country/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('country/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');
	
			}
		}
			
		if($action=='active')
		{		
			foreach($country_id as $id)
			{			
				$data = array('status'=>'active');
				$this->db->where('country_id',$id);
				$this->db->update('country_master', $data);
			}
			if($redirect_page == 'list_country')
		{
			
			redirect('country/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
		}
		else
		{
			redirect('country/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');

		}
		}	
		if($action=='inactive')
		{		
			foreach($country_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('country_id',$id);
				$this->db->update('country_master', $data);
			}
			
				if($redirect_page == 'list_country')
		{
			
			redirect('country/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
		}
		else
		{
			redirect('country/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');

		}
			
		}	
		
		
		
		
	}
	
	
}


?>