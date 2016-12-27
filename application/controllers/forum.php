<?php
class Forum extends SPACULLUS_Controller {
 
	/*
	 Function name :User()
	 */

	function Forum(){
		parent :: __construct ();
	    $this->load->model('forum_model');
	}

	public function index ($msg = '') {
		redirect('forum/forums');

	}

	public function forums($options= '',$offset=0,$msg='') {
		
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
        $data['active_menu']='forum';
		$limit=5;
		$this->load->helper('recaptchalib');
		$publickey = '6Lf0JfQSAAAAAOX2iWkSoOl3THquEUEq-WARD1-k';
		$privatekey = '6Lf0JfQSAAAAAJGqvUMuNOdo8Y_4cIegn41T_myW';
		# the response from reCAPTCHA
		$resp = null;
		# the error code from reCAPTCHA, if any
		$error = null;
		$captcha_error='';
		
					
			
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
				     $sort_by = "forum_id";
				     $sort_type = "DESC";		
				}
			
		}
		else
		{
			
				if($options != "")
				{
					if(is_numeric($options))
					{
						 $sort_by = "forum_id";
					 $sort_type = "DESC";	
					 $type = $options;
					 $keyword = '';
					}
					else {
						$get_option = explode("@",base64_decode($options));
				    $sort_by = $get_option[0];
				    $sort_type = $get_option[1];
				    $type = $get_option[2];
					$keyword = $get_option[3];
					}
					
				}
				else
			    {
					 $sort_by = "forum_id";
					 $sort_type = "DESC";	
					 $type = "0";
					 $keyword = '0';
				}
			
			 
		}
		
		$this->load->library('pagination');
		//echo $sort_by."@".$sort_type."@".$type."@".$keyword;
		
		$options = base64_encode($sort_by."@".$sort_type."@".$type."@".$keyword);
		$data['category'] = $this->forum_model->get_category();
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'forum/forums/'.$options.'/';
		$config['total_rows'] = $this->forum_model->get_total_forum_count($type,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->forum_model->get_forum_result($offset,$limit,$sort_by,$sort_type,$type,$keyword);
		$data['popular_forum'] = $this->forum_model->get_forum_popular();
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
		
		$data['redirect_page']='forums';
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
		$this->template->write_view ('content_center', $theme.'/forum/forum_list', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();

	}

	
	
   function detail($forum_id = 0, $msg = '',$limit=5,$offset=0)
   {
   		$this->load->library('pagination');
   		$forum_id = base64_decode($forum_id);
	  
	    $data = array();
		$data['msg'] = $msg;
		$data["forum_id"] = $forum_id;
		
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$page_detail=meta_setting();
		// $pageTitle=$page_detail->title;
		// $metaDescription=$page_detail->meta_description;
		// $metaKeyword=$page_detail->meta_keyword;
		
		$data['popular_forum'] = $this->forum_model->get_forum_popular();
		$data["forum_detail"] = $this->forum_model->get_one_forum($forum_id);
		
		
		$pageTitle= $data["forum_detail"]['forum_meta_title'];
		$metaDescription= $data["forum_detail"]['forum_meta_description'];
		$metaKeyword=$data["forum_detail"]['forum_meta_keyword'];
		
		$data['site_setting'] = site_setting ();
        $data['active_menu']='detail';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		
		
		
		$dataup = array('view'=>$data["forum_detail"]['view']+1);
		$this->db->where('forum_id',$forum_id);
		$this->db->update('forum',$dataup);
        $data["check_already_retade"] = check_already_forum_rated($forum_id,$this->session->userdata("user_id"));
		
		
		//$data["forum_comment"] = $this->forum_model->get_forum_comment($forum_id);
		
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'forum/detail/'.base64_encode($forum_id).'/'.$msg="null".'/'.$limit.'/';
		$config["total_rows"] = $this->forum_model->get_forum_comment_count($forum_id);
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['forum_comment'] = $this->forum_model->get_forum_comment($forum_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		
		if($data['forum_comment']=='')
		{
			//$offset=0;
			$config['uri_segment']='6';
			$config['base_url'] = base_url().'forum/detail/'.base64_encode($forum_id).'/'.$msg="null".'/'.$limit.'/';
			$config["total_rows"] = $this->forum_model->get_forum_comment_count($forum_id);
			$config['per_page'] = $limit;
			$this->pagination->initialize($config);		
			$data['page_link'] = $this->pagination->create_links();
			$data['forum_comment'] = $this->forum_model->get_forum_comment($forum_id,$offset,$limit);	
		}
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/forum/comment_ajax',$data,TRUE);die;
		}
		else{
        if(get_authenticateUserID() > 0)
        {
		  $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        }
        else
        {
            $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        }

		$this->template->write_view ('content_center', $theme.'/forum/forum_detail', $data, TRUE);
		}
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
	 
	 $cmt_id = $this->forum_model->insert_comment($data_insert);
	
	 $latest_comment = latest_forum_comment($cmt_id);
		
		//$latest_comment->cust_date = date('d M',strtotime($latest_comment->date_added));
	   // $latest_comment->date_duration = getDuration($latest_comment->date_added); 
		$res =  json_encode($latest_comment);
		echo $res;
	 
  }
  
  function add_rating()
  {
  	  $data = $_POST;
	  $data["date_added"] = date("Y-m-d H:i:s");
	  $this->db->insert("forum_rating",$data);
	 $id = mysql_insert_id();
	 
	 echo get_forum_rating($_POST["forum_id"]);
	// echo $id;
  }
  function editorimage()
	{
	//	$url = '../images/uploads/’.time()."_".$_FILES['upload']['name']';
		
		$url = base_path()."upload/gallery/".time()."_".$_FILES['upload']['name'];
		$url1 = front_base_url()."upload/gallery/".time()."_".$_FILES['upload']['name'];

 //extensive suitability check before doing anything with the file…
    if (($_FILES['upload'] == "none") OR (empty($_FILES['upload']['name'])) )
    {
       $message = "No file uploaded.";
    }
    else if ($_FILES['upload']["size"] == 0)
    {
       $message = "The file is of zero length.";
    }
    else if (($_FILES['upload']["type"] != "image/pjpeg") AND ($_FILES['upload']["type"] != "image/jpeg") AND ($_FILES['upload']["type"] != "image/png"))
    {
       $message = "The image must be in either JPG or PNG format. Please upload a JPG or PNG instead.";
    }
    else if (!is_uploaded_file($_FILES['upload']["tmp_name"]))
    {
       $message = "You may be attempting to hack our server. We’re on to you; expect a knock on the door sometime soon.";
    }
    else {
      $message = "";
      $move = @ move_uploaded_file($_FILES['upload']['tmp_name'], $url);
      if(!$move)
      {
         $message = "Error moving uploaded file. Check the script is granted Read/Write/Modify permissions.";
      }
      $url = "../" . $url;
    }
			$funcNum = $_GET['CKEditorFuncNum'] ;
			//echo "<script type=’text/javascript’>window.parent.CKEDITOR.tools.callFunction('$funcNum', '$url', '$message');</script>";
			echo "<script type='text/javascript'>alert('bnn');window.parent.CKEDITOR.tools.callFunction($funcNum, '$url1', '$message');</script>";
	}
	
	
	function forumsuggest()
	{
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('topic_name', 'Topic Name', 'required');
		$this->form_validation->set_rules('forum_category', 'Category', 'required');
		$this->form_validation->set_rules('forum_decription', 'Decription', 'required');
		
		$data["error"] = '';
		$data["msg"] = '';
		$data['site_setting'] = site_setting ();
		if($this->form_validation->run() == FALSE)
		{			
				if(validation_errors())
				{
					$data["error"] = validation_errors();
				}else{
					$data["error"] = "";
				}
				$data["topic_name"] = $this->input->post('topic_name');
				$data["forum_category"] = $this->input->post('forum_category');
				$data["forum_decription"] = $this->input->post('forum_decription');
		}
		else {
			    $this->forum_model->suggestforum_insert();			
				$data["msg"] = "success";	
		}
		
		if($data["error"] !="")
		{
			$response = array("comment_error"=>$data["error"],"status"=>"fail");
			echo json_encode($response);
		    die;
		}
		if($data["msg"] == "success")
		{
			
			$response = array("status"=>"success");
			echo json_encode($response);
		    die;
		}
		
		
	}
}
?>