<?php
class Taxi_owner extends  CI_Controller {
	function Taxi_owner()
	{
		parent::__construct();	
		$this->load->model('taxi_owner_user_model');	
		$this->load->library('pagination');
	    $this->load->library ("PasswordHash");
	}
	//use:for redirecting at list list_taxi page
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('taxi_owner/list_taxi_owner');	
	}
	
	/* list_taxi list
	 * param  : doctor id ,limit,offset,msg
	 * 
	 */
	function list_taxi_owner($state='active',$limit='10',$offset=0,$msg='',$option='',$keyword='') {
		
	
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
		
		$check_rights=get_rights('list_taxi_owner');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
			$this->load->library('pagination');
		
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'taxi_owner/list_taxi_owner/'.$state."/".$limit.'/';
		$config['total_rows'] = $this->taxi_owner_user_model->get_total_user_count($type='taxi_owner',$state);
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->taxi_owner_user_model->get_user_result($offset,$limit,$type='taxi_owner',$state);
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
		$data['state']=$state;
		$data['serach_option']='1V1';
		$data['serach_keyword']='1V1';
		$data['search_type']='normal';
		$data['redirect_page']='list_taxi_owner';
		
		
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/user/list_taxi_owner',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}

	
	
	/* search patitent
	 * param  : doctor id ,limit,option,keyword,offset,msg
	 * 
	 */
	function search_list_taxi_owner($state='',$limit=20,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_taxi_owner';
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('search_list_taxi_owner');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
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
		$config['base_url'] = base_url().'list_taxi/'.$redirect_page.'/'.$state."/".$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->taxi_owner_user_model->get_total_search_user_count($option,$keyword,$type='taxi_owner',$state);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->taxi_owner_user_model->get_search_user_result($option,$keyword,$offset, $limit,$type='taxi_owner',$state);
		
		$data['msg'] = $msg;
		$data['offset'] = $offset;
		$data['site_setting'] = site_setting();
		
		$data['limit']=$limit;
		$data['option']=$option;
		$data['state']=$state;
		$data['keyword']=$keyword;
		$data['search_type']='search';
		$data['redirect_page']=$redirect_page;
		
		
		
		
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/user/list_taxi_owner',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	
	/*check unique list_taxi email
	 * param  : email
	 * return : BOOLEAN
	 */
	function list_taximail_check($emailField)
	{
		$list_taxiname = $this->taxi_owner_user_model->user_unique($emailField,'taxi_owner');
		if($list_taxiname == FALSE)
		{
			$this->form_validation->set_message('list_taximail_check', 'There is an existing account associated with this Email');
			return FALSE;
		}
		return TRUE;
	}
	
	/*add new list_taxi also called in list_taxi update
	 * param  : limit
	 * 
	 */
	function add_taxi_owner($limit=0,$offset=0)
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
		
		$check_rights=get_rights('add_taxi_owner');
		
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
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		//$this->form_validation->set_rules('state', 'State', 'required');
		//$this->form_validation->set_rules('city', 'City', 'required');
		//$this->form_validation->set_rules('cmpn_zipcode', 'Zipcode', 'required');
		
		$this->form_validation->set_rules('emailField', 'Email', 'required|valid_email|callback_list_taximail_check');
	
		$video_error = '';
		if($_POST)
		{			
			$image_arr = array('image/gif','image/jpeg', 'image/pjpeg','image/jpeg', 'image/pjpeg','image/jpeg', 'image/pjpeg','image/png',  'image/x-png');
			if($_FILES["file_up"]["name"]!="")
			{
				if(!in_array($_FILES["file_up"]["type"],$image_arr))
				{
					$video_error .= "<p>Please upload jpg,jpeg,png,gif format only</p>";
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
		$data["user_id"] = $this->input->post('user_id');
		
		$data["email"] = $this->input->post('emailField');
		$data["state"] = $this->input->post('state');
		$data["first_name"] = $this->input->post('first_name');
		$data["last_name"] =$this->input->post('last_name');
		$data["gender"] = $this->input->post("gender");
		$data["status"] = $this->input->post('status');
		$data["state"] = $this->input->post('state');
		$data["city"] = $this->input->post('city');
		$data["cmpn_zipcode"] = $this->input->post('cmpn_zipcode');
		$data['image']=$this->input->post('pre_profile_image');
		$data["right_upload"] = $this->input->post('right_upload');
		$data["about_list_taxi"] = $this->input->post('about_list_taxi');
		$data["list_taxi_type"] = $this->input->post('list_taxi_type');
		$data["tax_company_name"] = $this->input->post('tax_company_name');
		$data["tax_cmpn_address"] = $this->input->post('tax_cmpn_address');
		$data["texi_company_phone_number"] = $this->input->post('texi_company_phone_number');
		$data["taxi_company_website"] = $this->input->post('taxi_company_website');
		$data["reciew"] = $this->input->post('reciew');
		$data["mobile_no"] = $this->input->post('mobile_no');
		$data["offset"] = $offset;
		
		// $data['states']=get_all_state_by_country_id($this->input->post('country_id'));
		// $data['cities']=get_all_city_by_state_id($this->input->post('state'));
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_taxi_owner';
			// $data['all_countries']=get_all_country();
			
			$data['site_setting'] = site_setting();
			
		
			if($this->input->post('offset')=="" && $_POST)
			{
				$limit = '10';
				
				$data["offset"] = 0;
			}
			
			
			$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
			 $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/user/add_taxi_owner',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				
			if($this->input->post('user_id')!='')
			{	
				$this->taxi_owner_user_model->user_update();
				$msg = "update";
			}else{
				$this->taxi_owner_user_model->user_insert();			
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
		 	$state = $this->input->post('state');
			 
			if($redirect_page == 'list_taxi_owner')
			{
				redirect('taxi_owner/'.$redirect_page.'/'.$state."/".$limit.'/'.$offset.'/'.$msg);
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('taxi_owner/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}	
			else
			{
				redirect('taxi_owner/'.$redirect_page.'/'.$state."/".$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	/*list_taxi update form fill
	 * param  : list_taxi id,doctor id ,redirect page,option,keyword,limit,offset
	 * 
	 */
	function edit_taxi_owner($state='',$id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
		
		$check_rights=get_rights('edit_taxi_owner');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_list_taxi = $this->taxi_owner_user_model->get_one_user($id);
		if(empty($one_list_taxi))
		{
			redirect('taxi_owner/list_taxi_owner');	
		}
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["states"]=$state;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		
		$data["user_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		$data["email"] = $one_list_taxi['email'];
		
		
		$data["email"] = $one_list_taxi['email'];
		$data["first_name"] = $one_list_taxi['first_name'];
		$data["last_name"] =$one_list_taxi['last_name'];
		$data["gender"] = $one_list_taxi['gender'];
		$data["status"] = $one_list_taxi['status'];
		$data["mobile_no"] = $one_list_taxi['mobile_no'];
		$data["image"] = $one_list_taxi['profile_image'];
		$data["city"] = $one_list_taxi['city'];
		$data["cmpn_zipcode"] = $one_list_taxi['cmpn_zipcode'];
		
		
		$data["state"] = $one_list_taxi['state'];
		$data["image"] = $one_list_taxi['taxi_image'];
	//	$data["right_upload"] = $one_list_taxi['right_upload'];
		$data["about_user"] = $one_list_taxi['about_user'];
		$data["tax_company_name"] = $one_list_taxi['taxi_company'];
		$data["tax_cmpn_address"] = $one_list_taxi['address'];
		$data["texi_company_phone_number"] = $one_list_taxi['phone_number'];
		$data["taxi_company_website"] = $one_list_taxi['cmpn_website'];
		$data["reciew"] = $one_list_taxi['taxi_desc'];
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/user/add_taxi_owner',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/*delete list_taxi data
	 * param  : list_taxi id,doctor id ,option,keyword,limit,offset,msg
	 * 
	 */
	function delete_taxi_owner($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0,$state='')
	{
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_taxi_owner');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//$this->db->delete('rights_assign',array('user_id'=>$id));
		//$data=array('is_deleted'=>'yes');
		//$this->db->where('user_id',$id);
		//$this->db->update('user_master',$data);
        
        
		
		$this->db->delete('taxi_directory',array('taxi_owner_id'=>$id));
		$this->db->delete('user_master',array('user_id'=>$id));
		if($redirect_page == 'list_taxi_owner')
		{
			
			redirect('taxi_owner/'.$redirect_page.'/'.$state."/".$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('taxi_owner/'.$redirect_page.'/'.$state."/".$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	/*delete , active , inactive multiple list_taxi at a time
	 * param  : list_taxi id,doctor id ,redirect page,search option,search keyword,limit,offset,msg
	 * 
	 */ 
	function action_taxi_owner()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_taxi_owner');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		$state=$this->input->post('state');
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
		
		$user_id =$this->input->post('chk');
			
		if($action=='delete')
		{
		
			    		
			foreach($user_id as $id)
			{
				$this->db->delete('taxi_directory',array('taxi_owner_id'=>$id));
				$this->db->delete('user_master',array('user_id'=>$id));
			}
			
			if($redirect_page == 'list_taxi_owner')
			{
				redirect('taxi_owner/'.$redirect_page.'/'.$state."/".$limit.'/'.$offset.'/delete');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('taxi_owner/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('taxi_owner/'.$redirect_page.'/'.$state."/".$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
			foreach($user_id as $id)
			
			{			
				$data = array('status'=>'active');
				$this->db->where('user_id',$id);
				$this->db->update('user_master', $data);
			}
			if($redirect_page == 'list_taxi_owner')
			{
				redirect('taxi_owner/'.$redirect_page.'/'.$state."/".$limit.'/'.$offset.'/active');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('taxi_owner/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('taxi_owner/'.$redirect_page.'/'.$state."/".$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive')
		{
		
             		
			foreach($user_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('user_id',$id);
				$this->db->update('user_master', $data);
			}
			
			if($redirect_page == 'list_taxi_owner')
			{
				redirect('taxi_owner/'.$redirect_page.'/'.$state."/".$limit.'/'.$offset.'/inactive');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('taxi_owner/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('taxi_owner/'.$redirect_page.'/'.$state."/".$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');
			}		
		}	
	}
	function removeimage($user_id,$image,$limit,$offset,$redirect_page,$option,$keyword)
	{
		//echo "sdfsdf";die;
		if($image!='')
		{
			if(file_exists(base_path().'upload/user_orig/'.$image))
			{
				$link=base_path().'upload/user_orig/'.$image;
				unlink($link);
			}
			
			if(file_exists(base_path().'upload/user_thumb/'.$image))
			{
				$link1=base_path().'upload/user_thumb/'.$image;
				unlink($link1);
			}			
		}
		$msg='Image Removed';
		//redirect('serviceprovider/list_staff/'.$limit.'/'.$offset.'/'.$msg);
		redirect('taxi_owner/edit_taxi_owner/'.$user_id.'/'.$redirect_page.'/'.$limit);
	}	
}
?>