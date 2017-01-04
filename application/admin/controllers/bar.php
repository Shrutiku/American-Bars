<?php
class Bar extends  CI_Controller {
	function Bar()
	{
		 parent::__construct();	
		$this->load->model('bar_model');
		
	}
	
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('bar/list_bar');
		
		$check_rights=get_rights('list_bar');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
	}
	
	// Use :This function use for Lost all bar User.
	// Param :limit,offset,message
	// Return :'N/A'
	function list_bar($bar_type ='all',$limit='10',$offset=0,$msg='',$er='',$er1='')
	{
		 //echo base64_decode($er1);
		 
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
		
		$check_rights=get_rights('list_bar');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');
		}
		
		$this->load->library('pagination');

		
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'bar/list_bar/'.$bar_type.'/'.$limit.'/';
		$config['total_rows'] = $this->bar_model->get_total_bar_count($bar_type);
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();

		$data['result'] = $this->bar_model->get_bar_result($offset,$limit,$bar_type);
		$data['msg'] = $msg;
		
		$data['er'] = $er;
		$data['er1'] = $er1;
		
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
		$data['redirect_page']='list_bar';
	    $data["bar_type"] = $bar_type;
		$data['site_setting'] = site_setting();

		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/bar/list_bar',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}

    function download()
	{
		    ini_set('memory_limit', '2048M');
		 $keyword=($this->input->post('key')!='')?str_replace(' ','-',$this->input->post('key')):'1V1';
         $option=($this->input->post('opt')!='')?str_replace(' ','-',$this->input->post('opt')):'1V1';
		 $typ=($this->input->post('typ')!='')?str_replace('', '-', $this->input->post('typ')):'1v1';
		 $result = $this->bar_model->getbaresult($typ,$option,$keyword);
		 
		 //echo "<pre>";
		 
		
		 $filename ="Bar_Record.csv";
         $this->load->dbutil();
         $delimiter = ",";
         $newline = "\r\n";
		 
         $data= $this->dbutil->csv_from_result($result, $delimiter, $newline);
		 
         //$this->load->helper('download');
        // force_download($filename, $data);
		 
		//$data = ltrim(strstr($this->dbutil->csv_from_result($result, ',', "\r\n"), "\r\n"));
		
		$this->load->helper('download');
		force_download("barrecord.csv", $data);
		
		
		exit;
	}
	
	// Use :This function use for list bar by filter.
	// Param :limit,option,keyword,offset,message
	// Return :'N/A'
	function search_list_bar($bar_type = "all",$limit=20,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$redirect_page = 'search_list_bar';
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('search_list_bar');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$this->load->library('pagination');
		$data['er'] = '';
		$data['er1'] = '';
		if($_POST)
		{		
			$option=$this->input->post('option');
			$keyword=($this->input->post('keyword')!='')?str_replace(" ", "-",trim($this->input->post('keyword'))):'1V1';
			
		}
		else
		{
			$option=$option;
			$keyword= str_replace(" ", "-",trim($keyword));	
		
		}
		
		$keyword=str_replace('"','',str_replace(array(",","%","$","&","*","#","(",")",":",";",">","<","/"),'',trim($keyword)));
                $keyword=str_replace("'", "\\'", trim($keyword));
	
		$config['uri_segment']='7';
		$config['base_url'] = base_url().'bar/search_list_bar'.'/'.$bar_type."/".$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->bar_model->get_total_search_bar_count($bar_type,$option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->bar_model->get_search_bar_result($bar_type,$option,$keyword,$offset, $limit);
		
		
		
		
		$data['msg'] = $msg;
		$data['offset'] = $offset;
		$data['site_setting'] = site_setting();
		$data["bar_type"] =$bar_type;
		
		$data['limit']=$limit;
		$data['option']=$option;
		$data['keyword']=$keyword;
		$data['search_type']='search';
		$data['redirect_page']=$redirect_page;
		
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/bar/list_bar',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for check unique UserName of bar.
	// Param :UserName
	// Return :Boolean
	function username_check($username)
	{
		$username = $this->bar_model->user_unique($username);
		if($username == TRUE)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('username_check', 'There is an existing account associated with this Username');
			return FALSE;
		}
	}	
	
	
	// Use :This function use for add new bar.
	// Param :'N/A'
	// Return :'N/A'
	
	function add_bar($bartype,$limit=0)
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
		
		$check_rights=get_rights('add_bar');
		
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
		$this->form_validation->set_rules('bar_title', 'Bar Title', 'required|callback_bartitle_check');
		//$this->form_validation->set_rules('bar_desc', 'Bar description', 'required');
		//$this->form_validation->set_rules('owner_name', 'Bar Owner', 'required');
	
		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_rules('facebook_link', 'Facebook Link', 'valid_url');
		$this->form_validation->set_rules('twitter_link', 'Twitter Link', 'valid_url');
		$this->form_validation->set_rules('linkedin_link', 'Linkedin Link', 'valid_url');
		$this->form_validation->set_rules('google_plus_link', 'Google Plus Link', 'valid_url');
		$this->form_validation->set_rules('instagram_link', 'Instagram Link', 'valid_url');
		$this->form_validation->set_rules('dribble_link', 'Dribble Link', 'valid_url');
		$this->form_validation->set_rules('pinterest_link', 'Pinterest Link', 'valid_url');
		//$this->form_validation->set_rules('bar_first_name', 'First Name', 'required');
		//$this->form_validation->set_rules('bar_last_name', 'Last Name', 'required');
		//$this->form_validation->set_rules('bar_meta_title', 'Meta Title', 'required');
		//$this->form_validation->set_rules('bar_meta_keyword', 'Meta Keyword', 'required');
		//$this->form_validation->set_rules('bar_meta_description', 'Meta Description', 'required');
		$data['get_cat'] = $this->bar_model->barCategory(); 		
		$video_error = '';		
		if($_POST)
		{
			$mp4_arr = array('video/mp4','video/x-flv', 'flv-application/octet-stream', 'application/octet-stream');
			
			if($_FILES["bar_video_file"]["name"] != "")
			{
				if(!in_array($_FILES["bar_video_file"]["type"],$mp4_arr))
				{
					$video_error .= "<p>Please upload flv or mp4 video</p>";
				}
			}	
			
			if($_FILES["bar_video_file"]["name"] != "")
			{
				if($_FILES["bar_video_file"]["size"] > "5242880")
				{
					$video_error .= "<p>video size can not greater than 5MB</p>";
				}
			}	
			
			$image_arr = array('image/gif','image/jpeg', 'image/pjpeg','image/jpeg', 'image/pjpeg','image/jpeg', 'image/pjpeg','image/png',  'image/x-png');
			if($_FILES["bar_logo_file"]["name"] != "")
			{
				if(!in_array($_FILES["bar_logo_file"]["type"],$image_arr))
				{
					$video_error .= "<p>Please upload jpg,jpeg,png,gif format only</p>";
				}
			}
			if($_FILES["bar_banner_file"]["name"] != "")
			{
				if(!in_array($_FILES["bar_banner_file"]["type"],$image_arr))
				{
					$video_error .= "<p>Please upload jpg,jpeg,png,gif format only</p>";
				}
			}	
		}
			
		
		
		if($this->form_validation->run() == FALSE || $video_error != ""){			
			if (validation_errors () || $video_error != "") {
					$data["error"] = validation_errors ();
					$data["error"] .= $video_error;
				} else {
					$data["error"] = "";
				}
			
			$data["bar_id"] = $this->input->post('bar_id');
			$data["bar_title"] = $this->input->post('bar_title');
			$data["bar_desc"] = $this->input->post('bar_desc');
			$data["status"] = $this->input->post('status');
			$data["owner_name"] = $this->input->post('owner_name');
			$data["bar_slug"] = $this->input->post('bar_slug');
			$data["address"] = $this->input->post('address');
			$data["bar_category"] = $this->input->post('bar_category');
			$data["facebook_link"] = $this->input->post('facebook_link');
			$data["twitter_link"] = $this->input->post('twitter_link');
			$data["instagram_link"] = $this->input->post('instagram_link');
			$data["linkedin_link"] = $this->input->post('linkedin_link');
			$data["bar_first_name"] = $this->input->post('bar_first_name');
			$data["bar_last_name"] = $this->input->post('bar_last_name');
			$data["google_plus_link"] = $this->input->post('google_plus_link');
			$data["dribble_link"] = $this->input->post('dribble_link');
			$data["pinterest_link"] = $this->input->post('pinterest_link');
			$data["city"] = $this->input->post('city');
			$data["serve_as"] = $this->input->post('serve_as');
			$data["state"] = $this->input->post('state');
			$data["phone"] = $this->input->post('phone');
			$data["zipcode"] = $this->input->post('zipcode');
			$data["email"] = $this->input->post('email');
			$data["bar_type"] = $this->input->post('bar_type');
			$data["website"] = $this->input->post('website');
			$data["prev_bar_logo"] = $this->input->post('prev_bar_logo');
			$data["prev_bar_banner"] = $this->input->post('prev_bar_banner');
			$data["is_claimed"] = $this->input->post('is_claimed');
			$data["bar_meta_title"] = $this->input->post('bar_meta_title');
			$data["bar_meta_keyword"] = $this->input->post('bar_meta_keyword');
			$data["bar_meta_description"] = $this->input->post('bar_meta_description');
			
			$data["cash_p"] = $this->input->post('cash_p');
			$data["master_p"] = $this->input->post('master_p');
			$data["american_p"] = $this->input->post('american_p');
			$data["visa_p"] = $this->input->post('visa_p');
			$data["paypal_p"] = $this->input->post('paypal_p');
			$data["bitcoin_p"] = $this->input->post('bitcoin_p');
			$data["apple_p"] = $this->input->post('apple_p');

			$data["prev_bar_video"] = $this->input->post('prev_bar_video');
			$data["bar_video_link"] = $this->input->post('bar_video_link');
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_bar';
			
			
			$data['site_setting'] = site_setting();
			
			$data["bartype"] = $bartype;
		
			if($this->input->post('offset')=="")
			{
				$limit = '10';
				$data["offset"] = 0;
			}else{
				$data["offset"] = $this->input->post('offset');
			}
			
			
			$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/bar/add_bar',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
			
				
				
			if($this->input->post('bar_id')!='')
			{			
				$this->bar_model->bar_update($_POST);
				$msg = "update";
			}else{
				$this->bar_model->bar_insert($_POST);			
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
		 	
			 
			if($redirect_page == 'list_bar')
			{
				redirect('bar/'.$redirect_page.'/'.$bartype.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			else
			{
				redirect('bar/'.$redirect_page.'/'.$bartype.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	
	// Use :This function use for edit of update bar.
	// Param :bar id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	function view($bar_type= "" ,$id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0){
		
	
		if(!check_admin_authentication()) {
		redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('view_bar');
				
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//echo $id; die;
		$data["one_bar_detail"] = $this->bar_model->get_one_bar($id);
		
	
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		$data["redirect_page"]=$redirect_page;
		
		$data["bar_id"] = $id;
	
	
		
		
		$data['reply'] = $this->bar_model->get_bar_comment_result($id,$limit, $offset);
		//print_r($data['reply']); die;get_bar_comment_result($id,$limit, $offset);
		
	
		
		if($_POST){
			$this->bar_model->reply_insert($_POST);			
			$msg = "insert"; 
			//echo 'bar/view/'.$limit.'/'.$offset; die;
			 redirect('bar/view/'.$id.'/'.$limit.'/'.$offset.'/'.$msg);
			
		}
		
		$data['total_comment']=$this->bar_model->get_total_bar_comment_count($id);
		//print_r($data['total']); die;
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/bar/view',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();

	}

	function edit_bar($bartype = '',$id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
		
		$check_rights=get_rights('edit_bar');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		
		$one_bar = $this->bar_model->get_one_bar($id);
		//print_r($one_user); die;
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		$data["bar_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		$data['get_cat'] = $this->bar_model->barCategory();
		
		//$data['getselectedcat'] =
	   	
			$data["bar_title"] = $one_bar["bar_title"];
			$data["bar_desc"] = $one_bar["bar_desc"];
			$data["status"] = $one_bar["status"];
			$data["bar_category"] = explode(',', $one_bar["bar_category"]);
			$data["owner_name"] = $one_bar["owner_name"];
			$data["address"] = $one_bar["address"];
			$data["city"] = $one_bar["city"];
			$data["state"] = $one_bar["state"];
			$data["is_managed"] = $one_bar["is_managed"];
			$data["instagram_link"] = $one_bar["instagram_link"];
			$data["phone"] = $one_bar["phone"];
			$data["bar_first_name"] = $one_bar["bar_first_name"];
			$data["bar_last_name"] = $one_bar["bar_last_name"];
			$data["zipcode"] = $one_bar["zipcode"];
			$data["email"] = $one_bar["email"];
			$data["bar_type"] = $one_bar["bar_type"];
			$data["website"] = $one_bar["website"];
			$data["prev_bar_logo"] = $one_bar["bar_logo"];
			$data["prev_bar_banner"] = $one_bar["bar_banner"];
			$data["prev_bar_video"] = $one_bar["bar_video"];
			$data["uid"] = $one_bar["owner_id"];
			$data["bar_video_link"] = $one_bar["bar_video_link"];
			$data["is_claimed"] = $one_bar["is_claimed"];
			$data["serve_as"] = $one_bar["serve_as"];
		    $data["facebook_link"] = $one_bar['facebook_link'];
			$data["twitter_link"] = $one_bar['twitter_link'];
			$data["linkedin_link"] = $one_bar['linkedin_link'];
			$data["google_plus_link"] = $one_bar['google_plus_link'];
			$data["dribble_link"] = $one_bar['dribble_link'];
			$data["bar_slug"] = $one_bar['bar_slug'];
			$data["pinterest_link"] = $one_bar['pinterest_link'];
			$data["bar_meta_description"] = $one_bar['bar_meta_description'];
			$data["bar_meta_keyword"] = $one_bar['bar_meta_keyword'];
			$data["bar_meta_title"] = $one_bar['bar_meta_title'];
			
			$data["cash_p"] = $one_bar['cash_p'];
				$data["master_p"] = $one_bar['master_p'];
				$data["american_p"] =$one_bar['american_p'];
				$data["visa_p"] = $one_bar['visa_p'];
				$data["paypal_p"] = $one_bar['paypal_p'];
				$data["bitcoin_p"] = $one_bar['bitcoin_p'];
				$data["apple_p"] = $one_bar['apple_p'];
		
		$data['site_setting'] = site_setting();
		$data["bartype"] = $bartype;
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/bar/add_bar',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}

	// Use :This function use for Delete bar.
	// Param :bar id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	
	function delete_bar($bartype="all",$id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*   
		 * Future enhancement
		 * when assigning rights is used
		*/
		//echo "mnbjb"; die;
		$check_rights=get_rights('delete_bar');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
        $getbar = $this->bar_model->get_one_bar($id);
		if($getbar['owner_id']!='' && $getbar['owner_id']!=0)
		{
			
		      $getuserinfo = get_user_info($getbar['owner_id']);
			 
			    $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Delete Bar Profile'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = $getuserinfo->email;
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{username}', ucwords($getbar['bar_first_name'])." ".ucwords($getbar['bar_last_name']), $email_message);
				$str = $email_message;
				if($email_temp->status=='active'){
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
				}
				$this->db->delete('user_master',array('user_id'=>$getbar['owner_id']));
				
		}
		$this->db->delete('bars',array('bar_id'=>$id));
		
		
		if($redirect_page == 'list_bar')
			{
				redirect('bar/'.$redirect_page.'/'.$bartype.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('bar/'.$redirect_page.'/'.$bartype.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
        
        /// common function for insert all action//
           $data_log = array("activity_name" => "LOG_DELETE_ADMIN");
           maintain_log($data_log);
	}
	
	
	// Use :This function use for change status or delete bar.
	// Param :'N/a'
	// Return :'N/A'
	function action_bar($bartype='all')
	{
		/* Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('action_bar');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		//$keyword = $this->input->post('serach_keyword');
		
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
		
	
		$bar_id =$this->input->post('chk');
		
		if($action=='delete')
		{
          
               
                		
			foreach($bar_id as $id)
			{	$getbar = $this->bar_model->get_one_bar($id);
				if($getbar['owner_id']!='' && $getbar['owner_id']!=0)
				{
				       $getuserinfo = get_user_info($getbar['owner_id']);
					    $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Delete Bar Profile'");
						$email_temp = $email_template->row();
						$email_address_from = $email_temp->from_address;
						$email_address_reply = $email_temp->reply_address;
						$email_subject = $email_temp->subject;
						$email_message = $email_temp->message;
						$email = $getuserinfo->email;
						$email_to = $email;
						$email_message = str_replace('{break}', '<br/>', $email_message);
						$email_message = str_replace('{username}', ucwords($this->input->post('bar_first_name'))." ".ucwords($this->input->post('bar_last_name')), $email_message);
						$str = $email_message;
						$this->db->delete('user_master',array('user_id'=>$getbar['owner_id']));
				}		
				$this->db->query("delete from ".$this->db->dbprefix('bars')." where bar_id ='".$id."'");
				$this->db->query("delete from ".$this->db->dbprefix('bar_comment')." where bar_id ='".$id."'");
				//echo $this->db->last_query(); die;
			}
			
			if($redirect_page == 'list_bar')
			{
				redirect('bar/'.$redirect_page.'/'.$bartype.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('bar/'.$redirect_page.'/'.$bartype.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
            
                		
			foreach($bar_id as $id)
			{			
				$data = array('status'=>'active');
				$this->db->where('bar_id',$id);
				$this->db->update('bars', $data);
			}
			if($redirect_page == 'list_bar')
			{
				redirect('bar/'.$redirect_page.'/'.$bartype.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('bar/'.$redirect_page.'/'.$bartype.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
			}
		}	

if($action=='archived')
		{
            
                		
			foreach($bar_id as $id)
			{			
				$data = array('status'=>'archived');
				$this->db->where('bar_id',$id);
				$this->db->update('bars', $data);
			}
			if($redirect_page == 'list_bar')
			{
				redirect('bar/'.$redirect_page.'/'.$bartype.'/'.$limit.'/'.$offset.'/archived');
			}
			else
			{
				redirect('bar/'.$redirect_page.'/'.$bartype.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/archived');
			}
		}	
		
		
	if($action=='claimed')
		{
            
                		
			foreach($bar_id as $id)
			{			
				$data = array('claim'=>'claimed');
				$this->db->where('bar_id',$id);
				$this->db->update('bars', $data);
			}
			if($redirect_page == 'list_bar')
			{
				redirect('bar/'.$redirect_page.'/'.$bartype.'/'.$limit.'/'.$offset.'/claimed');
			}
			else
			{
				redirect('bar/'.$redirect_page.'/'.$bartype.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/claimed');
			}
		}	
		
		 
	if($action=='unclaimed')
		{
            
                		
			foreach($bar_id as $id)
			{
				$one_bar = $this->bar_model->get_one_bar($id);
				
				if($one_bar['owner_id']!=0 && $one_bar['owner_id']!='')
				{
					$this->db->delete('user_master',array('user_id'=>$one_bar['owner_id']));
				}			
				$data = array('claim'=>'unclaimed','owner_id'=>'','bar_first_name'=>'','bar_last_name'=>'','email'=>'');
				$this->db->where('bar_id',$id);
				$this->db->update('bars', $data);
			}
			if($redirect_page == 'list_bar')
			{
				redirect('bar/'.$redirect_page.'/'.$bartype.'/'.$limit.'/'.$offset.'/unclaimed');
			}
			else
			{
				redirect('bar/'.$redirect_page.'/'.$bartype.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/unclaimed');
			}
		}	
		if($action=='inactive')
		{
		 
                		
			foreach($bar_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('bar_id',$id);
				$this->db->update('bars', $data);
			}
			
			if($redirect_page == 'list_bar')
			{
				redirect('bar/'.$redirect_page.'/'.$bartype.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('bar/'.$redirect_page.'/'.$bartype.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');

			}
		}	
		
	}

  
  // Use :This function use for Lost all bar User.
	// Param :limit,offset,message
	// Return :'N/A'
	function comment($bar_type ='all',$id = 0,$redirect_page='list_bar',$option='',$keyword='',$limit=10,$offset=0,$msg = '')
	
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
		
		$check_rights=get_rights('comment');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('pagination');

		
		$config['uri_segment']='9';
		$config['base_url'] = base_url().'bar/comment/'.$bar_type.'/'.$id.'/'.$redirect_page.'/1V1/1V1/'.$limit;
		$config['total_rows'] = $this->bar_model->get_total_bar_comment_count($id);
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->bar_model->get_bar_comment_result($id,$limit, $offset);
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
		$data['redirect_page']='list_bar';
	    $data["bar_type"] = $bar_type;
		$data["bar_id"] = $id;
		
		
		
		$data['site_setting'] = site_setting();

		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/bar/list_bar_comment',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}


    function edit_comment($bartype = '',$bar_id=0,$id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
		
		$check_rights=get_rights('edit_comment');
		
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
		
		$one_bar_comment = $this->bar_model->get_one_bar_comment($id);
		
            
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('comment_title', 'Comment Title', 'required');
		$this->form_validation->set_rules('comment', 'Comment', 'required');
		
	  //  $this->form_validation->set_rules('status', 'Status', 'required');
			
		
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			
			if($_POST)
			{
			$data["bar_comment_id"] = $this->input->post('bar_comment_id');
			$data["comment_title"] = $this->input->post('comment_title');
			$data["comment"] = $this->input->post('comment');
			$data["status"] = $this->input->post('status');
			$data["user_id"] = $this->input->post('user_id');
			$data["bar_id"] = $this->input->post('bar_id');
			$data["rating"] = $this->input->post('bar_rating');
			}
			else {
				$data["bar_comment_id"] =$id;
			$data["comment_title"] = $one_bar_comment['comment_title'];
			$data["comment"] = $one_bar_comment['comment'];
			$data["status"] = $one_bar_comment['status'];
			$data["user_id"] = $one_bar_comment['user_id'];
			$data["bar_id"] = $one_bar_comment['bar_id'];
			$data["rating"] = $one_bar_comment['bar_rating'];
			}
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='comment';
			$data['bar_id'] = $bar_id;
			
			$data['site_setting'] = site_setting();
			
			$data["bartype"] = $bartype;
		
			if($this->input->post('offset')=="")
			{
				$limit = '10';
				$data["offset"] = 0;
			}else{
				$data["offset"] = $this->input->post('offset');
			}
			
			
			$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/bar/add_comment',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
			
				
				
			if($this->input->post('bar_comment_id')!='' && $this->input->post('bar_comment_id')!=0)
			{
				$data_update["comment_title"] = $this->input->post("comment_title");
				$data_update["comment"] = $this->input->post("comment");
				$data_update["bar_rating"] = $this->input->post("rating");
				$data_update["status"] = $this->input->post("status");
				
			
				$this->bar_model->comment_update($this->input->post('bar_comment_id'),$data_update);
				$msg = "update";
			}else{
				$data_update["comment_title"] = $this->input->post("comment_title");
				$data_update["comment"] = $this->input->post("comment");
				$data_update["bar_id"] = $this->input->post("bar_id");
				$data_update["bar_rating"] = $this->input->post("rating");
				$data_update["date_added"] = date('Y-m-d h:i:s');
				$data_update["status"] = "Active";
				
				$this->bar_model->comment_insert($data_update);			
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
		 	
			 
			if($redirect_page == 'comment')
			{
			redirect('bar/comment/'.$bartype.'/'.$this->input->post("bar_id").'/'.$redirect_page.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			else
			{
				redirect('bar/comment/'.$bartype.'/'.$this->input->post("bar_id").'/'.$redirect_page.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset.'/'.$msg);
			}
		}				
	}


   // Use :This function use for change status or delete bar.
	// Param :'N/a'
	// Return :'N/A'
	function action_bar_comment($bartype='all',$bar_id=0)
	{
		/* Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('action_bar_comment');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$option = "1v1";
		$keyword = "1v1";
		
		$bar_comment_id =$this->input->post('chk');
		
		if($action=='delete')
		{
           
       
               
                		
			foreach($bar_comment_id as $id)
			{			
				$this->db->query("delete from ".$this->db->dbprefix('bar_comment')." where bar_comment_id ='".$id."' ");
				//echo $this->db->last_query(); die;
			}
			
			$msg = "delete";
			if($redirect_page == 'comment')
			{
					redirect('bar/comment/'.$bartype.'/'.$bar_id.'/'.$redirect_page.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			else
			{
					redirect('bar/comment/'.$bartype.'/'.$bar_id.'/'.$redirect_page.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset.'/'.$msg);

			}
			
		}
			
		if($action=='active')
		{
          
			foreach($bar_comment_id as $id)
			{			
				$data = array('status'=>'active');
				$this->db->where('bar_comment_id',$id);
				$this->db->update('bar_comment', $data);
			}
			
			$msg = "active";
			if($redirect_page == 'comment')
			{
					redirect('bar/comment/'.$bartype.'/'.$bar_id.'/'.$redirect_page.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			else
			{
					redirect('bar/comment/'.$bartype.'/'.$bar_id.'/'.$redirect_page.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset.'/'.$msg);

			}
		}	
		if($action=='inactive')
		{
		  
                		
			foreach($bar_comment_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('bar_comment_id',$id);
				$this->db->update('bar_comment', $data);
			}
			$msg = "inactive";
			if($redirect_page == 'comment')
			{
					redirect('bar/comment/'.$bartype.'/'.$bar_id.'/'.$redirect_page.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			else
			{
					redirect('bar/comment/'.$bartype.'/'.$bar_id.'/'.$redirect_page.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset.'/'.$msg);

			}
		}	
		
	}
   
   
   function delete_barcomment($bartype= 'all',$bar_id = 0,$id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*   
		 * Future enhancement
		 * when assigning rights is used
		*/
		//echo "mnbjb"; die;
		$check_rights=get_rights('delete_barcomment');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
     
		$this->db->delete('bar_comment',array('bar_comment_id'=>$id));
		$msg= 'delete';
	
		   if($redirect_page == 'comment')
			{
					redirect('bar/comment/'.$bartype.'/'.$bar_id.'/'.$redirect_page.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			else
			{
					redirect('bar/comment/'.$bartype.'/'.$bar_id.'/'.$redirect_page.'/'.$option.'/'.$keyword.'/'.$limit.'/'.$offset.'/'.$msg);

			}
        
        /// common function for insert all action//
           $data_log = array("activity_name" => "LOG_DELETE_ADMIN");
           maintain_log($data_log);
	}
	
    
	/*check unique bar Title
	 * param  : email
	 * return : BOOLEAN
	 */
	function bartitle_check($title)
	{
		$username = $this->bar_model->bar_title_unique($title);
		if($username == FALSE)
		{
			$this->form_validation->set_message('bartitle_check', 'There is an existing Bar associated with this Title');
			return FALSE;
		}
		return TRUE;
	}
	function removeimage($bar_id,$image,$limit,$offset,$redirect_page,$option,$keyword)
	{
		//echo "sdfsdf";die;
		if($image!='')
		{
			if(file_exists(base_path().'upload/barlogo_orig/'.$image))
			{
				$link=base_path().'upload/barlogo_orig/'.$image;
				unlink($link);
			}
			
			if(file_exists(base_path().'upload/barlogo/'.$image))
			{
				$link1=base_path().'upload/barlogo/'.$image;
				unlink($link1);
			}			
		}
		$msg='Image Removed';
		//redirect('serviceprovider/list_staff/'.$limit.'/'.$offset.'/'.$msg);
		redirect('bar/edit_bar/all/'.$bar_id.'/'.$redirect_page.'/'.$limit.'/1V1/1V1/'.$offset);
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
			$today = date('Y-m-d');
			$getbar = $this->bar_model->get_one_bar($id);
			$arr = array('first_name'=>$getbar['owner_name'], 
			             'email'=>$getbar['email'],
						 'password'=>md5(trim($this->input->post('password'))),
						 'status'=>'active',
						 'user_type'=>'bar_owner',
						 'expire_date'=>strtotime(date('Y-m-d', strtotime($today)) . '+1 month'));
			$this->db->insert('user_master',$arr);
			
			$this->db->where('bar_id',$id)->update('bars',array('owner_id'=>mysql_insert_id()));
			
			$data['success']='success';
			$data['msg']='Password has been reseted successfully.';
			$data['error']='';
			
		}
		if($_POST){
			echo json_encode($data);die;
		}
		$data["site_setting"] = site_setting();
		$theme = getThemeName();
		$data['bar_id']=$id;
		
			echo $this->load->view($theme .'/layout/bar/changePassword',$data,TRUE);
		die;
		
		
	}

	function import_bar($msg='')
	{
		if(!check_admin_authentication()) {
		redirect('home');
		}
		
		$check_rights=get_rights('import_bar');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$data = array();    
        $data['error'] = '';    
		$data['msg'] = $msg;
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
        $data['active_menu']='contact';

		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/bar/import',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
			
	}
	
	function import_csv()
	{
			$get = $this->bar_model->importcsv();
			
	}
	
	function getbadetail()
	{
		
		$one_bar = $this->bar_model->get_one_bar($this->input->post('id'));
		print_r(json_encode($one_bar));
		die;
	}
	
	function getallbar_new()
	{
		
		
		$getbeer = $this->bar_model->getallbar_100('0');
		
		
		foreach($getbeer as $b)
		{
			$slug = getBarSlug_new($b->bar_slug,$b->bar_id);
			
			$data_insert["bar_slug"] = $slug;
			$this->db->where("bar_id",$b->bar_id);
			$this->db->update('bars',$data_insert);
			
		}
	}
	
	function test1()
	{
		$getbeer = $this->db->query('select bar_slug, bar_id  from sss_bars group by bar_slug having count(*) > 1');
		$result = $getbeer->result();
		//$query = $this->db->get();
		// echo "<pre>";
		 // print_r($result);
		 // die;
		foreach($result as $b)
		{
			$slug = getBarSlug_new($b->bar_slug,$b->bar_id);
			$data_insert["bar_slug"] = $slug;
			$data_insert["linkurl"] = "http://sandbox.americanbars.com/bar/details/$slug";
			
			$this->db->where("bar_id",$b->bar_id);
			$this->db->update('bars',$data_insert);
			
		}
		
		
	}
	
	function add_happy_hours($bars_id = 0,$msg='')
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
		
		$check_rights=get_rights('add_happy_hours');
		$data['bars_id'] = $bars_id;
		$data['msg'] = $msg;
		$data['error'] = '';
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
			$data['getbar_hour'] = $this->bar_model->get_bar_hour($bars_id);
		if($this->input->post('submit')=="Add")
		{
			
			$this->bar_model->bar_hours_update($bars_id);			
				$data["msg"] = "success";	
			redirect("bar/add_happy_hours/".$bars_id."/update");	
		 }		
		
		
			
			$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
			 $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/happy_hours/add_happy_hours',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
				
	}

	function removebarhours($id=0)
	{
			$this->db->where('bar_hour_id',$id)->delete('bar_special_hours');
	}
}
?>
