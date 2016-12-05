<?php
class User extends  CI_Controller {
	function User()
	{
		parent::__construct();	
		$this->load->model('user_model');	
		$this->load->library('pagination');
	    $this->load->library ("PasswordHash");
	}
	//use:for redirecting at list user page
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('user/list_user');	
	}
	
	/* user list
	 * param  : doctor id ,limit,offset,msg
	 * 
	 */
	function list_user($limit='10',$option='',$keyword='',$offset=0,$msg='') {
		
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
		
		$check_rights=get_rights('list_user');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
			$this->load->library('pagination');
		
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'user/list_user/'.$limit.'/';
		$config['total_rows'] = $this->user_model->get_total_user_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->user_model->get_user_result($offset,$limit);
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
		$data['redirect_page']='list_user';
		
		
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/user/list_user',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}

	function list_enthusiast_user($state='active',$limit='10',$offset=0,$msg='',$option='',$keyword='') {
		
		
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
		
		$check_rights=get_rights('list_enthusiast_user');
		
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
			$this->load->library('pagination');
		
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'user/list_enthusiast_user/'.$state.'/'.$limit.'/';
		$config['total_rows'] = $this->user_model->get_total_user_count($type='user',$state);
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->user_model->get_user_result($offset,$limit,$type='user',$state);
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
		$data['redirect_page']='list_enthusiast_user';
		
		
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/user/list_user',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	function list_bar_user($limit='10',$offset=0,$msg='',$option='',$keyword='') {
		
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
		
		$check_rights=get_rights('list_user');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
			$this->load->library('pagination');
		
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'user/list_enthusiast_user/'.$limit.'/';
		$config['total_rows'] = $this->user_model->get_total_user_count($type='bar_owner');
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->user_model->get_user_result($offset,$limit,$type='bar_owner');
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
		$data['redirect_page']='list_bar_user';
		
		
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/user/list_user',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	function list_poker($limit='10',$offset=0,$msg='') {
		
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
		
		$check_rights=get_rights('list_poker');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
			$this->load->library('pagination');
		
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'user/list_poker/'.$limit.'/';
		$config['total_rows'] = $this->user_model->get_total_poker_count();
		//print_r($config['total_rows']); die;
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->user_model->get_poker_result($offset,$limit);
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
		$data['redirect_page']='list_poker';
		
		
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/user/list_poker',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/* search patitent
	 * param  : doctor id ,limit,option,keyword,offset,msg
	 * 
	 */
	function search_list_user($state='active',$limit=20,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_user';
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('search_list_user');
		
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

	
		$config['uri_segment']='8';
		$config['base_url'] = base_url().'user/'.$redirect_page.'/'.$state."/".$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->user_model->get_total_search_user_count($option,$keyword,$state);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->user_model->get_search_user_result($option,$keyword,$offset, $limit,$state);
		
		$data['msg'] = $msg;
		$data['offset'] = $offset;
		$data['site_setting'] = site_setting();
		
		$data['limit']=$limit;
		$data['state']=$state;
		$data['option']=$option;
		$data['keyword']=$keyword;
		$data['search_type']='search';
		$data['redirect_page']=$redirect_page;
		
		
		
		
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/user/list_user',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	
	
	/*check unique user email
	 * param  : email
	 * return : BOOLEAN
	 */
	function usermail_check($emailField)
	{
		$username = $this->user_model->user_email_unique($emailField);
		if($username == FALSE)
		{
			$this->form_validation->set_message('usermail_check', 'There is an existing account associated with this Email');
			return FALSE;
		}
		return TRUE;
	}
	
	function usermail_check_enthuser($emailField)
	{
		$username = $this->user_model->user_email_unique($emailField,'user');
		if($username == FALSE)
		{
			$this->form_validation->set_message('usermail_check_enthuser', 'There is an existing account associated with this Email');
			return FALSE;
		}
		return TRUE;
	}
	
	/*add new user also called in user update
	 * param  : limit
	 * 
	 */
	function add_user($limit=0,$offset=0)
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
		
		$check_rights=get_rights('add_user');
		
		
		
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
		$this->form_validation->set_rules('nick_name', 'Bar Fly Nickname', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('emailField', 'Email', 'required|valid_email|callback_usermail_check_enthuser');
	
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
		$data["state"] = $this->input->post('state');
		$data["email"] = $this->input->post('emailField');
		$data["first_name"] = $this->input->post('first_name');
		$data["nick_name"] = $this->input->post('nick_name');
		$data["last_name"] =$this->input->post('last_name');
		$data["gender"] = $this->input->post("gender");
		$data["status"] = $this->input->post('status');
		$data["mobile_no"] = $this->input->post('mobile_no');
		$data['image']=$this->input->post('pre_profile_image');
		$data['start_date']=$this->input->post('birthdate');
		$data["right_upload"] = $this->input->post('right_upload');
		$data["about_user"] = $this->input->post('about_user');
		$data["user_type"] = $this->input->post('user_type');
		$data["offset"] = $offset;
		
		// $data['states']=get_all_state_by_country_id($this->input->post('country_id'));
		// $data['cities']=get_all_city_by_state_id($this->input->post('state'));
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_enthusiast_user';
			// $data['all_countries']=get_all_country();
			
			$data['site_setting'] = site_setting();
			
		
			if($this->input->post('offset')=="" && $_POST)
			{
			$limit = '10';
				
				$data["offset"] = 0;
			}
			
			
			$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
			 $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/user/add_user',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				
			if($this->input->post('user_id')!='')
			{	
				$this->user_model->user_update();
				$msg = "update";
			}else{
				
				$this->user_model->user_insert();			
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
		 	
			 
			if($redirect_page == 'list_enthusiast_user')
			{
				redirect('user/'.$redirect_page.'/'.$state."/".$limit.'/'.$offset.'/'.$msg);
			}
			else
			{
				redirect('user/'.$redirect_page.'/'.$state."/".$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	/*user update form fill
	 * param  : user id,doctor id ,redirect page,option,keyword,limit,offset
	 * 
	 */
	function edit_user($state='',$id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
		
		$check_rights=get_rights('edit_user');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_user = $this->user_model->get_one_user($id);
		
		
		if(empty($one_user))
		{
			redirect('user/list_enthusiast_user');	
		}
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["state"]=$state;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		
		$data["user_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		$data["email"] = $one_user['email'];
		
		
		$data["email"] = $one_user['email'];
		$data["first_name"] = $one_user['first_name'];
		$data["nick_name"] = $one_user['nick_name'];
		$data["last_name"] =$one_user['last_name'];
		$data["gender"] = $one_user['gender'];
		$data["status"] = $one_user['status'];
		$data["image"] = $one_user['profile_image'];
	//	$data["right_upload"] = $one_user['right_upload'];
		$data["about_user"] = $one_user['about_user'];
		$data["user_type"] = $one_user['user_type'];
		$data["start_date"] = $one_user['birthdate'];
		$data["mobile_no"] = $one_user['mobile_no'];
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/user/add_user',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/*delete user data
	 * param  : user id,doctor id ,option,keyword,limit,offset,msg
	 * 
	 */
	function delete_user($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0,$state='')
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_user');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//$this->db->delete('rights_assign',array('user_id'=>$id));
		//$data=array('is_deleted'=>'yes');
		//$this->db->where('user_id',$id);
		//$this->db->update('user_master',$data);
        
        
		
		$this->db->delete('user_master',array('user_id'=>$id));
		if($redirect_page == 'list_enthusiast_user')
		{
			
			redirect('user/'.$redirect_page.'/'.$state."/".$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('user/'.$redirect_page.'/'.$state."/".$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	/*delete , active , inactive multiple user at a time
	 * param  : user id,doctor id ,redirect page,search option,search keyword,limit,offset,msg
	 * 
	 */ 
	function action_user()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_user');
		
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
				//$data=array('is_deleted'=>'yes');
				//$this->db->where('user_id',$id);
				//$this->db->update('user_master',$data);			
				$this->db->query("delete from ".$this->db->dbprefix('user_master')." where user_id ='".$id."'");
			}
			
			if($redirect_page == 'list_enthusiast_user')
			{
				redirect('user/'.$redirect_page.'/'.$state."/".$limit.'/'.$offset.'/delete');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('user/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('user/'.$redirect_page.'/'.$state."/".$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

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
			if($redirect_page == 'list_enthusiast_user')
			{
				redirect('user/'.$redirect_page.'/'.$state."/".$limit.'/'.$offset.'/active');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('user/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('user/'.$redirect_page.'/'.$state."/".$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
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
			
			if($redirect_page == 'list_enthusiast_user')
			{
				redirect('user/'.$redirect_page.'/'.$state."/".$limit.'/'.$offset.'/inactive');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('user/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('user/'.$redirect_page.'/'.$state."/".$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');
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
		redirect('user/edit_user/'.$user_id.'/'.$redirect_page.'/'.$limit);
	}
	
	function viewUserFrontProfile($user_id)
	{
		$this->load->helper('cookie');
	
		
		//$user_id=$this->input->post('user_id');
		$one_user = $this->user_model->get_one_User($user_id);
		//echo '<pre>';
		//print_r($one_user);
		
		$cookie = array(
				'name'   => 'login_for',
				'value'  => 'user',
				'expire' => '86500',
				'path'   => '/',
				);
		$this->input->set_cookie($cookie);
		
		$cookie = array(
				'name'   => 'user_id',
				'value'  => $user_id,
				'expire' => '86500',
				'path'   => '/',
				);
		$this->input->set_cookie($cookie);
		
		
		echo "<script>window.location.href='".front_base_url().'home/adminLogin/'.$user_id."';</script>;";
		
		//redirect(front_base_url().'home/adminLogin');
	}
	 function euser_download($state)
	{
		 $keyword=($this->input->post('key')!='')?str_replace(' ','-',$this->input->post('key')):'1V1';
         $option=($this->input->post('opt')!='')?str_replace(' ','-',$this->input->post('opt')):'1V1';
		 $typ=($this->input->post('typ')!='')?str_replace('', '-', $this->input->post('typ')):'1v1';
		 $result = $this->user_model->getAllUserResult($option,$keyword,$state);
		 
		 
		
		 $filename ="User.csv";
         $this->load->dbutil();
         $delimiter = ",";
         $newline = "\r\n";
		 
         $data= $this->dbutil->csv_from_result($result, $delimiter, $newline);
		 
         //$this->load->helper('download');
        // force_download($filename, $data);
		 
		//$data = ltrim(strstr($this->dbutil->csv_from_result($result, ',', "\r\n"), "\r\n"));
		
		$this->load->helper('download');
		force_download("Enthusiast_User.csv", $data);
		
		
		exit;
	}	
	
	 function bar_user_download()
	{
		 $keyword=($this->input->post('key')!='')?str_replace(' ','-',$this->input->post('key')):'1V1';
         $option=($this->input->post('opt')!='')?str_replace(' ','-',$this->input->post('opt')):'1V1';
		 $typ=($this->input->post('typ')!='')?str_replace('', '-', $this->input->post('typ')):'1v1';
		 $result = $this->user_model->getAllBarUserResult($option,$keyword);
		 
		 
		
		 $filename ="User.csv";
         $this->load->dbutil();
         $delimiter = ",";
         $newline = "\r\n";
		 
         $data= $this->dbutil->csv_from_result($result, $delimiter, $newline);
		 
         //$this->load->helper('download');
        // force_download($filename, $data);
		 
		//$data = ltrim(strstr($this->dbutil->csv_from_result($result, ',', "\r\n"), "\r\n"));
		
		$this->load->helper('download');
		force_download("Bar_User.csv", $data);
		
		
		exit;
	}
	
	 function taxi_user_download()
	{
		 $keyword=($this->input->post('key')!='')?str_replace(' ','-',$this->input->post('key')):'1V1';
         $option=($this->input->post('opt')!='')?str_replace(' ','-',$this->input->post('opt')):'1V1';
		 $typ=($this->input->post('typ')!='')?str_replace('', '-', $this->input->post('typ')):'1v1';
		 $result = $this->user_model->getAllTaxiUserResult($option,$keyword);
		 
		 
		
		 $filename ="User.csv";
         $this->load->dbutil();
         $delimiter = ",";
         $newline = "\r\n";
		 
         $data= $this->dbutil->csv_from_result($result, $delimiter, $newline);
		 
         //$this->load->helper('download');
        // force_download($filename, $data);
		 
		//$data = ltrim(strstr($this->dbutil->csv_from_result($result, ',', "\r\n"), "\r\n"));
		
		$this->load->helper('download');
		force_download("Taxi_Owner_User.csv", $data);
		
		
		exit;
	}
	function password_check($str)
{
	
   if (preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {
   
     return TRUE;
   }
			$this->form_validation->set_message('password_check', 'Provide atleast 1 Number, 1 Special character,1 Alphabet and between 8 to 16 characters.');
			return FALSE;
}

	function setNewPassword($id='')
	{
		//valid_pass
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[12]|callback_password_check');
		//$this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]|min_length[8]|alpha_numeric|callback_password_check');
		$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|min_length[8]|max_length[12]|matches[password]|valid_pass');
		
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
		}else{
			//print_r($_POST);die;
			
			//$this->db->where('user_id',$this->input->post('business_id'))->update('user_master',array('password'=>md5(trim($this->input->post('password')))));
			//$today = date('Y-m-d');
			//$getbar = $this->bar_model->get_one_bar($id);
			//$arr = array('password'=>md5(trim($this->input->post('password'))));
			//$this->db->insert('user_master',$arr);
			
			$this->db->where('user_id',$id)->update('user_master',array('password'=>md5(trim($this->input->post('password')))));
			
			$data['success']='success';
			$data['msg']='Password has been reseted successfully.';
			$data['error']='';
			
		}
		if($_POST){
			echo json_encode($data);die;
		}
		$data["site_setting"] = site_setting();
		$theme = getThemeName();
		$data['user_id']=$id;
		
			echo $this->load->view($theme .'/layout/user/changePassword',$data,TRUE);
		die;
		
		
	}
}
?>