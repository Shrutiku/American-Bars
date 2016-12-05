<?php
class Video extends SPACULLUS_Controller {
 
	/*
	 Function name :User()
	 */

	function Video() {
		parent :: __construct ();
	    $this->load->model('video_model');
	}

	public function index ($msg = '') {
		
		
		redirect('video/videoes');

	}

	public function videoes($limit='10',$options= '',$offset=0,$msg='') {
		
		//echo "hello"; die;
		// if(!check_user_authentication())
		// { redirect('home'); }	 

		$data['msg'] = base64_decode($msg);
		
		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['site_setting'] = site_setting ();
        $data['active_menu']='video';
		
		
		if($_POST)
		{
			
			  
			 
			 $type = $this->input->post("type");
		     $keyword = $this->input->post("keyword"); 
			   
			   $order = explode("#",$this->input->post("order_by"));
			  
				if(isset($order[0]) && isset($order[1]))
				{
					 $sort_by = $order[0];
				     $sort_type = $order[1];	
				}
				else
				{
				     $sort_by = "video_id";
				     $sort_type = "DESC";		
				}
			
		}
		else
		{
			
				if($options != "")
				{
					$get_option = explode("@",base64_decode($options));
				    $sort_by = $get_option[0];
				    $sort_type = $get_option[1];
				    $type = $get_option[2];
					$keyword = $get_option[3];
				}
				else
			    {
					 $sort_by = "video_id";
					 $sort_type = "DESC";	
					 $type = "0";
					 $keyword = '0';
				}
			
			 
		}
		
		$this->load->library('pagination');
		//echo $sort_by."@".$sort_type."@".$type."@".$keyword;
		$options = base64_encode($sort_by."@".$sort_type."@".$type."@".$keyword);

		$config['uri_segment']='5';
		$config['base_url'] = base_url().'video/videoes/'.$limit.'/'.$options.'/';
		$config['total_rows'] = $this->video_model->get_total_video_count($type,$keyword);
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->video_model->get_video_result($offset,$limit,$sort_by,$sort_type,$type,$keyword);
		
	
		
	
		$data['msg'] = $msg;
		$data["task_type"] = '';
		
		
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
	  	$data['type']=$type;
		if($keyword == "0"){$keyword = '';}
	    $data['keyword'] = $keyword;
		
		$data['redirect_page']='videoes';
		$data['sort_type']=$sort_type;
		$data['sort_by']=$sort_by;
		$data['page_name']="Video";
	    $data["order_by"] = $sort_by."#".$sort_type;
		
		
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
		$this->template->write_view ('content_center', $theme.'/video/video_listing', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();

	}

	
	
   function video_detail($video_id = 0, $msg = '')
   {
   	  $video_id = base64_decode($video_id);
	  
	    $data = array();
		$data['msg'] = $msg;
		$data["video_id"] = $video_id;
		
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		
		
		$data["video_title"] = $this->video_model->get_one_video($video_id);
		$data["video_comment"] = $this->video_model->get_video_comment($video_id);
		
        $data["check_already_retade"] = check_already_video_rated($video_id,$this->session->userdata("user_id"));
        if(get_authenticateUserID() > 0)
        {
		  $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        }
        else
        {
            $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        }
		$this->template->write_view ('content_center', $theme.'/video/video_detail', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();
		
   }
  
  
  function add_comment()
  {
  	 $data_insert = $_POST;
	 
	 $data_insert["user_id"] = $this->session->userdata("user_id");
	 $data_insert["status"] = "active";
	 $data_insert["date_added"] = date("Y-m-d H:i:s");
	 $data_insert["is_deleted"] = "no";
	 
	 $this->video_model->insert_comment($data_insert);
	 
	 echo "Your comment added successfully";
	 die;
	 
  }
  
  function add_rating()
  {
  	  $data = $_POST;
	  $data["date_added"] = date("Y-m-d H:i:s");
	  $this->db->insert("video_rating",$data);
	 $id = mysql_insert_id();
	 
	 echo get_video_rating($_POST["video_id"]);
	// echo $id;
  }
	
}
?>