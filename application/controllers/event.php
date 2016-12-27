<?php
class Event extends SPACULLUS_Controller {
 
	/*
	 Function name :User()
	 */

	function Event() {
		parent :: __construct ();
	    $this->load->model('event_model');
		$this->load->model('home_model');
	}

	public function index ($msg = '') {
		
		
		redirect('event/lists');

	}

	public function lists($bar_sulg=0 ,$limit='6',$alpha = 'no',$options= '',$offset=0,$msg='') {
		
		//echo "hello"; die;
		// if(!check_user_authentication())
		// { redirect('home'); }	 
		
	
		$data['msg'] = base64_decode($msg);
		
		if($alpha != "no" && $alpha != "" )
		{
		     $alpha = base64_decode($alpha);
		}
		
		$data = array();
		if($bar_sulg!='0')
		{
		$bar_id = getBarID($bar_sulg);
		}
		else {
 		  $bar_id = 0;	
		}
		
		$data["bar_id"] = $bar_id;
		$data["bar_sulg"] = $bar_sulg;
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['site_setting'] = site_setting ();
        $data['active_menu']='event';
		
		if($_POST)
		{			
		    $keyword = $this->input->post("keyword"); 			
			$event_date = $this->input->post("event_date"); 			
			$order = explode("#",$this->input->post("order_by"));
			
			 $bar_id = $this->input->post("bar_id"); 
				if(isset($order[0]) && isset($order[1]))
				{
					 $sort_by = $order[0];
				     $sort_type = $order[1];	
				}
				else
				{
				     $sort_by = "event_id";
				     $sort_type = "DESC";		
				}				
		 		$limit = $this->input->post("limit");		
		}
		else
		{		
				if($options != "")
				{
				
					$get_option = explode("@",base64_decode($options));
				    $sort_by = $get_option[0];
				    $sort_type = $get_option[1];
					$keyword = $get_option[2];
					$event_date = $get_option[3];					
				}
				else
			    {
					 $sort_by = "event_id";
					 $sort_type = "DESC";	
					 //$type = "0";
					 $event_date = '0';
					 $keyword = '0';
				}			 
		}
		
		$this->load->library('pagination');
		//echo $sort_by."@".$sort_type."@".$type."@".$keyword;
		$options = base64_encode($sort_by."@".$sort_type."@".$keyword."@".$event_date);
        
	
		$config['uri_segment']='7';
		$config['base_url'] = base_url().'event/lists/'.$bar_sulg.'/'.$limit.'/'.base64_encode($alpha)."/".$options.'/';
		$config['total_rows'] = $this->event_model->get_total_event_count($keyword,$event_date,$alpha,$bar_id);
		$data['totalevent'] = $this->event_model->getcountallevent($bar_id);
		
		$data["total_rows"] = $config['total_rows'];
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->event_model->get_event_result($offset,$limit,$sort_by,$sort_type,$keyword,$event_date,$alpha,$bar_id);
	
		$data['latest_event'] = $this->event_model->getlatestevent(2,$bar_id);
	
	
	
		$data['msg'] = $msg;
		$data["task_type"] = '';
		
		$data["options"] = $options;
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
	  	//$data['type']=$type;
		if($keyword == "0"){$keyword = '';}
		if($event_date == "0"){$event_date = '';}
	    $data['keyword'] = $keyword;
		$data['event_date'] = $event_date;
		$data['redirect_page']='lists';
		$data['sort_type']=$sort_type;
		$data['sort_by']=$sort_by;
		$data['page_name']="Video";
	    $data["order_by"] = $sort_by."#".$sort_type;
		$data["alpha"] = $alpha;
		
		
		
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        
        if(get_authenticateUserID() > 0)
        {
		  $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        }
        else
        {
            $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        }
		$this->template->write_view ('content_center', $theme.'/event/lists', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();

	}

	
	
   function detail($event_id = 0, $limit = 5 , $offset = 0 ,$msg = '')
   {
   		if($event_id=="" || $event_id=="0")
		{
			redirect('home');
		}
        
   	  	$event_id = base64_decode($event_id);
		
		//$bar_id = getBarID($bar_slug);
   	  	//$event_id = geteventID($event_slug);

	    $data = array();
		$data['msg'] = $msg;
		$data["event_id"] = $event_id;
		$data["bar_gallery"] = $this->event_model->getEventGallery($event_id);
		$data["eventtime"] = $this->event_model->getEventTime($event_id);
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$data["event_detail"] = $this->event_model->get_one_event($event_id);
		$pageTitle=$data["event_detail"]['event_meta_title'];
		$metaDescription=$data["event_detail"]['event_meta_description'];
		$metaKeyword=$data["event_detail"]['event_meta_keyword'];
		
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		$data["beer_liker"] = $this->event_model->get_event_likers($event_id);
		
		
		if($data["event_detail"]['bar_id'])
		{
			
			$data['latest_event']  = $this->event_model->getBarEvent_m($data["event_detail"]['bar_id'],$limit=4,$data["event_detail"]['event_id']);
		}
		else {
			$data['latest_event']  = $this->home_model->latestevent_m(4,$data["event_detail"]['event_id']);
		}
	
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
       
		$this->load->library('pagination');

		
        if(get_authenticateUserID() > 0)
        {
		  $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        }
        else
        {
            $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        }
		//$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/event/event_detail', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();		
    } 

    function changestatus()
	{
		$checkrecexist = $this->event_model->checkeventalreadyattend($this->input->post('id'),$this->input->post('type'),get_authenticateUserID());
		if($checkrecexist)
		{
			$arr = array('is_attend'=>$this->input->post('type'));
			$this->db->where(array('event_id'=>$this->input->post('id'),'user_id'=>get_authenticateUserID()));
		    $this->db->update('event_attend',$arr);
			
			if($this->input->post('type')=='yes')
			{
				echo 2;
			}
			else {
				echo 0;
			}
			$data['user_id'] = get_user_info(get_authenticateUserID());
			if($this->session->userdata('user_type')=="bar_owner")
			{
				
				$data['user_id'] = get_bar_info(get_authenticateUserID());
			}
			
			//print_r($data['user_id']);
			if($this->input->post('type')=="bar_owner")
			{
			if($data['user_id']){
				$profile = $data['user_id']->profile_image;
				echo '*<li id="user_'.$data['user_id']->user_id.'" class="active"><a href="'.site_url('user/profile/'.base64_encode(get_authenticateUserID())).'"><img src="'.base_url().'upload/user_thumb/'.$profile.'" class="user_img"/>';
			}
			else{
				echo '*<li id="user_'.$data['user_id']->user_id.'" class="active"><a href="'.site_url('user/profile/'.base64_encode(get_authenticateUserID())).'"><img src="'.base_url().'upload/user_thumb/no_img.png" class="user_img"/>';
			}
			}
			else {
				if($data['user_id']){
				$profile = $data['user_id']->bar_logo;
				echo '*<li id="user_'.$data['user_id']->user_id.'" class="active"><a href="'.site_url('user/profile/'.base64_encode(get_authenticateUserID())).'"><img src="'.base_url().'upload/barlogo_thumb/'.$profile.'" class="user_img"/>';
			}
			else{
				echo '*<li id="user_'.$data['user_id']->user_id.'" class="active"><a href="'.site_url('user/profile/'.base64_encode(get_authenticateUserID())).'"><img src="'.base_url().'upload/user_thumb/no_img.png" class="user_img"/>';
			}
			}
			
			
		}
		else {
			//echo 1;
			$arr = array('is_attend'=>$this->input->post('type'),
						 'event_id'=>$this->input->post('id'),
						 'date'=>date('Y-m-d'),
						 'user_id'=>get_authenticateUserID());
		    $this->db->insert('event_attend',$arr);
			$data['user_id'] = get_user_info(get_authenticateUserID());
			
			
			if($data['user_id']){
				$profile = $data['user_id']->profile_image;
				echo '*<li id="user_'.$data['user_id']->user_id.'" class="active"><a href="'.site_url('user/profile/'.base64_encode(get_authenticateUserID())).'"><img src="'.base_url().'upload/user_thumb/'.$profile.'" class="user_img"/>';
			}
			else{
				echo '*<li id="user_'.$data['user_id']->user_id.'" class="active"><a href="'.site_url('user/profile/'.base64_encode(get_authenticateUserID())).'"><img src="'.base_url().'upload/user_thumb/no_img.png" class="user_img"/>';
			}
			
			

		}
		
		
		//echo "success";
		die;
		
	}

	function getmapajaxevent()
	{
		$theme = getThemeName ();
		$data = array();
		$data['bar_detail'] = $this->event_model->get_one_event($this->input->post('id'));
		echo $this->load->view($theme .'/home/map',$data,TRUE);die;
		
	}
	
	
	function view_all_likers()
	{
		$html = '';
		$bar_liker = $this->event_model->get_all_event_likers($this->input->post('id'));
		$html .= "<div class='padtb10'><div class='container'><div class='result_box clearfix mar_top30bot20'><div class='login_block br_green_yellow'><div class='result_search'><button aria-hidden='true' data-dismiss='modal' class='close' type='button'>×</button>
	     				<i class='strip login_icon'></i><div class='result_search_text'>Event attend users list</div></div><div class='pad20'><div id='ajax_msg_error_reg'></div><ul class='likeduser marl_0'>";	
		
		if($bar_liker){
			
	    foreach($bar_liker as $r)
		{
			$profile = $r->profile_image;
			if($profile!="" && is_file(base_path().'upload/user_thumb/'.$profile))
			{
			  $html .=  '<li id="user_'.$r->user_id.'" class="active"><a target="_blank" href="'.site_url('user/profile/'.base64_encode($r->user_id)).'"><img src="'.base_url().'upload/user_thumb/'.$r->profile_image.'" class="user_img"/>';
			}
			else 
			{
			  $html .= '<li id="user_'.$r->user_id.'" class="active"><a target="_blank" href="'.site_url('user/profile/'.base64_encode($r->user_id)).'"><img src="'.base_url().'upload/user_thumb/no_img.png" class="user_img"/>';
			}
		}
        }
	else {
		$html .= "<span class='result_search_text'>No any user found .</span>";
	}
        
		$html .= "</ul><div class='clear'></div></div></div></div></div></div>";
		print_r($html);
		die;
	}
	
	function getallevent()
	{
		$evet = $this->event_model->getallevent();
		
		foreach($evet as $r)
		{
			$res  = getCoordinatesFromAddress_orig($r->address,$r->city,$r->state);
			$data_update = array('event_lat'=>$res['lat'],'event_lng'=>$res['lng']);
			$this->db->where('event_id',$r->event_id);
			$this->db->update('events',$data_update);
		}
	}
	
	
}
?>