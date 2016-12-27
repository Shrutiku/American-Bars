<?php
class City extends  CI_Controller {
	function City()
	{
		 parent::__construct();	
		$this->load->model('city_model');	
	}
	
	function index()
	{
		redirect('city/list_city');	
	}
	
	// Use :This function use for Lost all City.
	// Param :limit,offset,message
	// Return :'N/A'
	function list_city($limit='10',$offset=0,$msg='')
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
		 * $check_rights=get_rights('list_city');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}*/
		$this->load->library('pagination');

		//$limit = '2';
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'city/list_city/'.$limit.'/';
		$config['total_rows'] = $this->city_model->get_total_city_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->city_model->get_city_result($offset, $limit);
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
		$data['redirect_page']='list_city';
		
		$data['site_setting'] = site_setting();

		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/city/list_city',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
// Use :This function use for list City by filter.
	// Param :limit,option,keyword,offset,message
	// Return :'N/A'
	function search_list_city($limit=20,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_city';
		/*
		 * Future enhancement
		 * when assigning rights is used
		 
		  $check_rights=get_rights('list_city');
		
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
		$config['base_url'] = base_url().'city/search_list_city/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->city_model->get_total_search_city_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->city_model->get_search_city_result($option,$keyword,$offset, $limit);
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
		$this->template->write_view('center',$theme .'/layout/city/list_city',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	// Use :This function use for add new City.
	// Param :'N/A'
	// Return :'N/A'
	function add_city($limit=0)
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
		 
		  $check_rights=get_rights('list_city');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}*/
		$data['limit']=$limit;

		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('country_id', 'Country', 'required');
		$this->form_validation->set_rules('state_id', 'State', 'required');
		$this->form_validation->set_rules('city_name', 'City Name', 'required');
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			$data["city_id"] = $this->input->post('city_id');
			$data["country_id"] = $this->input->post('country_id');			
			$data["state_id"] = $this->input->post('state_id');			
			$data["zipcode"] = $this->input->post('zipcode');
			$data["lat"] = $this->input->post('lat');
			$data["lng"] = $this->input->post('lng');
			$data["city_name"] = $this->input->post('city_name');
			$data['site_setting'] = site_setting();
			$data["all_countries"] = get_all_countries();
			$data['states']=get_all_state_by_country_id($this->input->post('country_id'));
			$data['option']='1V1';
		$data['keyword']='1V1';
		$data['serach_option']='1V1';
		$data['serach_keyword']='1V1';
		$data['search_type']='normal';
		$data['redirect_page']='list_city';
			
		
			if($this->input->post('offset')=="")
			{
				$limit = '10';
				$data["offset"] = 0;
			}else{
				$data["offset"] = $this->input->post('offset');
			}
			
			
			$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/city/add_city',$data,TRUE);
			 $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				
			if($this->input->post('city_id')!='')
			{	
				$this->city_model->city_update();
				$msg = "update";
			}else{
				$this->city_model->city_insert();			
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
		 	
			 
			if($redirect_page == 'list_city')
			{
				redirect('city/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			else
			{
				redirect('city/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}


	// Use :This function use for edit of update City.
	// Param :city id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	function edit_city($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
		 
		  $check_rights=get_rights('list_city');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}*/
		
		
		
		$one_user = $this->city_model->get_one_city($id);
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;		
		$data["redirect_page"]=$redirect_page;;
		$data["city_id"] = $id;
		$data["city_name"] = $one_user['city_name'];
		$data["zipcode"] =$one_user['zipcode'];
		$data["lat"] =$one_user['lat'];
		$data["lng"] = $one_user['lng'];
		$data["country_id"] =  $one_user['country_id'];
		$data["state_id"] =  $one_user['state_id'];
		$data["all_countries"] = get_all_countries();
		$data['states']=get_all_state_by_country_id($one_user['country_id']);
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/city/add_city',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	
	// Use :This function use for Delete City.
	// Param :city id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function delete_city($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*   
		 * Future enhancement
		 * when assigning rights is used 
		 * $check_rights=get_rights('list_city');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}*/
		
		
		$this->db->delete('city_master',array('city_id'=>$id));
		if($redirect_page == 'list_city')
		{
			
			redirect('city/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('city/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	
	
	// Use :This function use for change status or delete City.
	// Param :'N/a'
	// Return :'N/A'
	
	
	function action_city()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		 
		  $check_rights=get_rights('list_city');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}*/
		
		
		$offset=$this->input->post('offset');
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		$city_id =$this->input->post('chk');
		
			
		if($action=='delete')
		{		
			foreach($city_id as $id)
			{			
				$this->db->query("delete from ".$this->db->dbprefix('city_master')." where city_id ='".$id."'");
			}
			
			redirect('city/list_city/'.$limit.'/'.$offset.'/delete');
		}
			
		if($action=='active')
		{		
			foreach($city_id as $id)
			{			
				$data = array('status'=>'active');
				$this->db->where('city_id',$id);
				$this->db->update('city_master', $data);
			}
			redirect('city/list_city/'.$limit.'/'.$offset.'/active');
		}	
		if($action=='inactive')
		{		
			foreach($city_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('city_id',$id);
				$this->db->update('city_master', $data);
			}
			redirect('city/list_city/'.$limit.'/'.$offset.'/inactive');
		}	
		
		
		
		
	}


	// Use :This function use for Get all state by country.
	// Param :Post Data country id
	// Return :'String'

function get_state_ajax()
	{
		
		$country_id = $this->input->post('country_id');
		
		$query = $this->db->get_where('state_master',array('country_id'=>$country_id));
		$states = $query->result();
		
		$str='';
		
		
		
		$str ='<option value="">--Select--</option>';
								 if($states){
									foreach($states as $st){
									$str.='<option value="'.$st->state_id.'">'.$st->state_name.'</option>';
									 } }
		
		
echo $str;		
		
	}

	
	
}
?>