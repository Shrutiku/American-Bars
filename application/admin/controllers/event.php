<?php
class Event extends  CI_Controller {
	function Event()
	{
		parent::__construct();	
		$this->load->model('event_model');	
	   $this->load->library('pagination');
	}
	//use:for redirecting at list event page
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('event/list_event');	
	}
	
	/* event list
	 * param  : doctor id ,limit,offset,msg
	 * 
	 */
	function list_event($limit=20,$bars_id =0,$offset=0,$msg='') {
		
		
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
		
		$check_rights=get_rights('list_event');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//	$this->load->library('pagination');
		
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'event/list_event/'.$limit.'/'.$bars_id. "/";
		$config['total_rows'] = $this->event_model->get_total_event_count($bars_id);
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->event_model->get_event_result($offset,$limit,$bars_id);
		
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
		$data['date']='1V1';
		$data['serach_option']='1V1';
		$data['serach_keyword']='1V1';
		$data['search_type']='normal';
		$data['redirect_page']='list_event';
		
		$data["bars_id"] = $bars_id ;
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/event/list_event',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	/* search patitent
	 * param  : doctor id ,limit,option,keyword,offset,msg
	 * 
	 */
	 
	function search_list_event($limit=20,$option='',$keyword='',$date='',$bars_id = 0,$offset=0,$msg='')
	{
		
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('search_list_event');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_event';
		
		
		
		if($_POST)
		{		
			$option=$this->input->post('option');
			$date=$this->input->post('date');
			$keyword=($this->input->post('keyword')!='')?str_replace(" ", "-",trim($this->input->post('keyword'))):'1V1';
			$bars_id=$this->input->post('bars_id');
			
		}
		else
		{
			$option=$option;
			$date=$date;
			$keyword=str_replace(" ", "-",trim($keyword));	
		    $bars_id = $bars_id;
		}
		
		//$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',trim($keyword)));

	
		$config['uri_segment']='8';
		$config['base_url'] = base_url().'event/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$date."/".$bars_id;
		$config['total_rows'] = $this->event_model->get_total_search_event_count($option,$keyword,$date,$bars_id);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->event_model->get_search_event_result($option,$keyword,$date,$offset, $limit,$bars_id);
		
		$data['msg'] = $msg;
		$data['offset'] = $offset;
		$data['site_setting'] = site_setting();
		
		$data['limit']=$limit;
		$data['option']=$option=='' ? '1V1':$option;
		$data['keyword']=$keyword;
		$data['date']=$date=='' ? '1V1':$date;
		$data['search_type']='search';
		$data['redirect_page']=$redirect_page;
		$data["bars_id"] = $bars_id;
		
		
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/event/list_event',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	
	/*check unique event email
	 * param  : email
	 * return : BOOLEAN
	 */
	function eventname_check($name)
	{
		$eventname = $this->event_model->event_unique($name);
		if($eventname == FALSE)
		{
			$this->form_validation->set_message('eventname_check', 'There is an existing record with this Event Name');
			return FALSE;
		}
		return TRUE;
	}
	
	/*add new event also called in event update
	 * param  : limit
	 * 
	 */
	function add_event($bars_id = 0,$limit=20)
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
		
		$check_rights=get_rights('add_event');
		
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
		$this->form_validation->set_rules('event_title', 'Event Title', 'required');
		$this->form_validation->set_rules('event_desc', 'description', 'required');
		// $this->form_validation->set_rules('start_date', 'Start Date', 'required');
		// $this->form_validation->set_rules('end_date', 'End Date', 'required');
		// $this->form_validation->set_rules('start_time', 'Start Time', 'required');
		// $this->form_validation->set_rules('end_time', 'End Time', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('city', 'city', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');
		$this->form_validation->set_rules('zipcode', 'Zipcode', 'required');
	    //$this->form_validation->set_rules('phone', 'Phone Number', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
		
		$video_error = '';
		if($_POST)
		{
			// $mp4_arr = array('video/mp4','video/x-flv', 'flv-application/octet-stream', 'application/octet-stream');
// 			
			// if($_FILES["event_video"]["name"] != "")
			// {
				// if(!in_array($_FILES["event_video"]["type"],$mp4_arr))
				// {
					// $video_error .= "<p>Please upload flv or mp4 video</p>";
				// }
			// }	
// 			
			// if($_FILES["event_video"]["name"] != "")
			// {
				// if($_FILES["event_video"]["size"] > "5242880")
				// {
					// $video_error .= "<p>video size can not greater than 5MB</p>";
				// }
			// }	
			
			$image_arr = array('image/gif','image/jpeg', 'image/pjpeg','image/jpeg', 'image/pjpeg','image/jpeg', 'image/pjpeg','image/png',  'image/x-png');
		}		
		
		if($this->form_validation->run() == FALSE || $video_error != ""){			
			if (validation_errors () || $video_error != "") {
					$data["error"] = validation_errors ();
					$data["error"] .= $video_error;
			}else{
				$data["error"] = "";
			}
			$data['get_cat'] = $this->event_model->eventCategory(); 	
			$data['bareventtime'] = $this->event_model->getEventtime($this->input->post('event_id'));
			
			
			$data["event_category"] = $this->input->post('event_category');
//			$data['imageGallery']=$this->event_model->getImageEvent($this->input->post('event_id'));
		$data["event_id"] = $this->input->post('event_id');
		$data['getallbar'] = $this->event_model->getallbar();
		$data["event_title"] = $this->input->post('event_title');
		$data["organizer"] = $this->input->post('organizer');
		$data["start_date"] = $this->input->post('start_date');
		$data["venue"] = $this->input->post('venue');
		$data["start_time"] = $this->input->post('start_time');
		$data["admission"] = $this->input->post('admission');
		$data["end_date"] = $this->input->post('end_date');
		$data["end_time"] = $this->input->post('end_time');
		$data["address"] = $this->input->post('address');
		$data["city"] =$this->input->post('city');
	
		$data["state"] = $this->input->post('state');
		$data["phone"] = $this->input->post('phone');
		$data["website"] = $this->input->post('website');
	    $data["zipcode"] = $this->input->post('zipcode');
		$data["status"] = $this->input->post('status');
		// $data["event_fb_link"] = $this->input->post('event_fb_link');
		// $data["event_twitter_link"] = $this->input->post('event_twitter_link');
		// $data["event_google_plus_link"] = $this->input->post('event_google_plus_link');
		// $data["event_pinterest_link"] = $this->input->post('event_pinterest_link');
		$data["event_desc"] = $this->input->post('event_desc');
		//$data["prev_event_image"] = $this->input->post('prev_event_image');
		$data["prev_event_video"] = $this->input->post('prev_event_video');
		$data["event_video_link"] = $this->input->post('event_video_link');
		$data["is_power_boost_event"] = $this->input->post('is_power_boost_event');
		$data["bar_id"] = $this->input->post('bar_id');
		$data["created_by"] = $this->input->post('created_by');
		$data["bars_id"] = $bars_id;
		$data["prev_photo_image"] = $this->input->post('prev_photo_image');
		$data['event_meta_title']=$this->input->post('event_meta_title');
		$data['event_meta_keyword']=$this->input->post('event_meta_keyword');
		$data['event_upload_type']=$this->input->post('event_upload_type');
		$data['buy_ticket']=$this->input->post('buy_ticket');
		$data['event_meta_description']=$this->input->post('event_meta_description');
		
		$data['imageGallery']=$this->event_model->getImageEvent($this->input->post('event_id'));
		$data['bareventtime'] = $this->event_model->getEventtime($this->input->post('event_id'));
		// $data['states']=get_all_state_by_country_id($this->input->post('country_id'));
		// $data['cities']=get_all_city_by_state_id($this->input->post('state'));
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["date"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_event';
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
			$this->template->write_view('center',$theme .'/layout/event/add_event',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				
			if($this->input->post('event_id')!='')
			{	
				$this->event_model->event_update($_POST);
				$msg = "update";
			}else{
				$this->event_model->event_insert($_POST);			
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
			$date = $this->input->post('date');
		 	
			 
			if($redirect_page == 'list_event')
			{
				redirect('event/'.$redirect_page.'/'.$limit.'/'.$this->input->post("bars_id").'/0/'.$msg);
			}
			
			else
			{
				redirect('event/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$date."/".$this->input->post("bars_id")."/".$offset.'/'.$msg);
			}
		}				
	}
	
	/*event update form fill
	 * param  : event id,doctor id ,redirect page,option,keyword,limit,offset
	 * 
	 */
	function edit_event($id=0,$redirect_page='',$option='',$keyword='',$date='',$limit=0,$offset=0,$bars_id = 0)
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
		
		$check_rights=get_rights('edit_event');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_event = $this->event_model->get_one_event($id);
		$data['imageGallery']=$this->event_model->getImageEvent($id);
		$data['bareventtime'] = $this->event_model->getEventtime($id);
		$data['getallbar'] = $this->event_model->getallbar();
		$data['get_cat'] = $this->event_model->eventCategory(); 		
		$data["event_category"] = explode(',', $one_event["event_category"]);
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["date"]=$date;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		
		$data["event_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		
        $data["event_title"] = $one_event['event_title'];
	   // $data["start_date"] = $one_event['start_date'];
		$data["organizer"] = $one_event['organizer'];
		//$data["end_date"] = $one_event['end_date'];
		//$data["start_time"] = $one_event['start_time'];
		//$data["end_time"] = $one_event['end_time'];
		$data["address"] = $one_event['address'];
		$data["admission"] = $one_event['admission'];
		$data["website"] = $one_event['website'];
		// $data["event_pinterest_link"] = $one_event['event_pinterest_link'];
		// $data["event_google_plus_link"] = $one_event['event_google_plus_link'];
		// $data["event_twitter_link"] = $one_event['event_twitter_link'];
		// $data["event_fb_link"] = $one_event['event_fb_link'];
		$data["event_upload_type"] = $one_event['event_upload_type'];
		$data["city"] = $one_event['city'];
		$data["state"] = $one_event['state'];
		$data["phone"] = $one_event['phone'];
	    $data["zipcode"] = $one_event['zipcode'];
		$data["venue"] = $one_event['venue'];
		$data["buy_ticket"] = $one_event['buy_ticket'];
		$data["status"] = $one_event['status'];
		$data["event_desc"] = $one_event['event_desc'];
		
		$data["prev_event_image"] = $one_event['event_image'];
		$data["prev_event_video"] = $one_event['event_video'];
		$data["event_video_link"] = $one_event['event_video_link'];
		$data["is_power_boost_event"] = $one_event['is_power_boost_event'];
		$data["bars_id"] = $one_event['bar_id'];
		$data["bar_id"] = $one_event['bar_id'];
		$data["created_by"] = $one_event['created_by'];
		$data['event_meta_title']=$one_event['event_meta_title'];
		$data['event_meta_keyword']=$one_event['event_meta_keyword'];
		$data['event_meta_description']=$one_event['event_meta_description'];
		//$data["bars_id"] = $bars_id;
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/event/add_event',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/*delete event data
	 * 
	 * 
	 */
	function delete_event($id=0,$redirect_page='',$option='',$keyword='',$bars_id = 0,$limit=20,$offset=0)
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_event');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//$this->db->delete('rights_assign',array('event_id'=>$id));
		// $data=array('is_deleted'=>'yes');
		// $this->db->where('event_id',$id);
		// $this->db->update('events',$data);
        $this->db->query("delete from ".$this->db->dbprefix('events')." where event_id ='".$id."'");
        
		
		//$this->db->delete('event',array('event_id'=>$id));
		if($redirect_page == 'list_event')
		{
			
			redirect('event/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$offset.'/delete');
		}
		else
		{
		redirect('event/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$keyword."/".$bars_id.'/'.$offset.'/delete');

		}
	}
	
	/*delete , active , inactive multiple event at a time
	 * param  : event id,doctor id ,redirect page,search option,search keyword,limit,offset,msg
	 * 
	 */ 
	function action_event()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_event');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
	$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
			$option = $this->input->post('serach_option');
		$date = $this->input->post('search_date');
		$keyword = $this->input->post('serach_keyword')=='' ? '1V1':$this->input->post('serach_keyword');
		$bar_id = $this->input->post("bar_id");
		
		$event_id =$this->input->post('chk');
			
		if($action=='delete')
		{
		
			    		
			foreach($event_id as $id)
			{
				// $data=array('is_deleted'=>'yes');
				// $this->db->where('event_id',$id);
				// $this->db->update('events',$data);			
				$this->db->query("delete from ".$this->db->dbprefix('events')." where event_id ='".$id."'");
			}
			
			if($redirect_page == 'list_event')
			{
				redirect('event/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/delete');
			}
			
			else
			{
				redirect('event/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$date."/".$bar_id.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
			foreach($event_id as $id)
			
			{			
				$data = array('status'=>'active');
				$this->db->where('event_id',$id);
				$this->db->update('events', $data);
			}
			
			
			if($redirect_page == 'list_event')
			{
				redirect('event/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/active');
			}
			
			else
			{
				redirect('event/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$date."/".$bar_id.'/'.$offset.'/active');

			}
		}	
		if($action=='inactive')
		{
		
             		
			foreach($event_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('event_id',$id);
				$this->db->update('events', $data);
			}
			
			
			if($redirect_page == 'list_event')
			{
				redirect('event/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/inactive');
			}
			
			else
			{
				
				redirect('event/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$date."/".$bar_id.'/'.$offset.'/inactive');

			}
			
			
		}	
		
		
		
		
	}
	
	

	// Use :This function use for edit of update bar.
	// Param :bar id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	function view($id=0,$msg=''){
		
	
		if(!check_admin_authentication()) {
		redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		
		//echo $id; die;
		$data["one_event_detail"] = $this->event_model->get_one_event($id);
		
	
		$data["error"] = "";
		// $data["limit"]=$limit;
		// $data["offset"]=$offset;
		// $data["option"]=$option;
		// $data["keyword"]=$keyword;
		// $data["search_option"]=$option;
		// $data["search_keyword"]=$keyword;
		// $data["redirect_page"]=$redirect_page;
		
		$data["event_id"] = $id;
	
	   $data["msg"] = $msg;
		$found = array();
		
		$data['reply'] = $this->event_model->get_event_comment_result($id);
		
		
	
		
		if($_POST){
			$this->event_model->reply_insert($_POST);			
			$msg = "insert"; 
			//echo 'bar/view/'.$limit.'/'.$offset; die;
			 redirect('event/view/'.$id.'/'.$msg);
			
		}
		$data['total_comment'] = 9;
		//$data['total_comment']=$this->event_model->get_total_bar_comment_count($id);
		//print_r($data['total']); die;
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/event/view',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();

	}
	
	function delete_comment($event_id = 0, $event_comment_id = 0 )
	{
		$qry = $this->db->query("delete from ".$this->db->dbprefix("event_comment")." where event_comment_id = '".$event_comment_id."' or 
		master_comment_id = '".$event_comment_id."'");
		
		redirect ("event/view/".$event_id."/delete");
	}
	function removeimage($event_id,$image,$limit,$offset,$redirect_page,$option,$keyword)
	{
		//echo "sdfsdf";die;
		if($image!='')
		{
			if(file_exists(base_path().'upload/event_orig/'.$image))
			{
				$link=base_path().'upload/event_orig/'.$image;
				unlink($link);
			}
			
			if(file_exists(base_path().'upload/event_thumb/'.$image))
			{
				$link1=base_path().'upload/event_thumb/'.$image;
				unlink($link1);
			}			
		}
		$msg='Image Removed';
		//redirect('serviceprovider/list_staff/'.$limit.'/'.$offset.'/'.$msg);
		redirect('event/edit_event/'.$event_id.'/'.$redirect_page.'/'.$limit);
	}

    function removeImageAjax($id=0)
	{
		$oneImage=$this->event_model->getOneImageEvent($id);
		//print_r($oneImage);die;
		if($oneImage!='')
		{
			if($oneImage->event_image_name!=''){
			if(file_exists(base_path().'upload/bar_eventgallery_orig/'.$oneImage->event_image_name))
			{
				unlink(base_path().'upload/bar_eventgallery_orig/'.$oneImage->event_image_name);
			}
			if(file_exists(base_path().'upload/bar_eventgallery_thumb/'.$oneImage->event_image_name))
			{
				unlink(base_path().'upload/bar_eventgallery_thumb/'.$oneImage->event_image_name);
			}
			if(file_exists(base_path().'upload/bar_eventgallery_thumb_big/'.$oneImage->event_image_name))
			{
				unlink(base_path().'upload/bar_eventgallery_thumb_big/'.$oneImage->event_image_name);
			}
			
			}
			$this->db->where('event_image_id',$oneImage->event_image_id)->delete('event_images');
			
			
		}
		
	}	

  function removeTimeAjax($id=0)
	{
		$oneImage=$this->event_model->getOneTimeEvent($id);
		//print_r($oneImage);die;
		if($oneImage!='')
		{
			$this->db->where('sss_event_time_id',$oneImage->sss_event_time_id)->delete('event_time');
		}
		
	}
	
		function getEventDate($id='')
	{
		//valid_pass
		$theme = getThemeName();
		$data["eventtime"] = $this->event_model->getEventTime($id);
		echo $this->load->view($theme .'/layout/event/eventtime',$data,TRUE);
		die;
		
		
	}	
}
?>