<?php
class Article extends SPACULLUS_Controller {
 
	/*
	 Function name :User()
	 */

	function Article(){
		parent :: __construct ();
	    $this->load->model('blog_model');
	}

	public function index ($msg = '') {
		
		
		redirect('article/listarticle');

	}

	public function listarticle($limit='2',$options= '',$offset=0,$msg='') {
		
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
        $data['active_menu']='listarticle';
		
		$data["recent_blog"] = $this->blog_model->get_blog_recent();
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
				     $sort_by = "blog_id";
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
					 $sort_by = "blog_id";
					 $sort_type = "DESC";	
					 $type = "0";
					 $keyword = '0';
				}
			
			 
		}
			if($this->input->post('limit') != '')
		{
			$limit=$this->input->post('limit');
		}
		else
		{
			$limit=$limit;
		}
         $data['limit']  = $limit;
		 
		$this->load->library('pagination');
		//echo $sort_by."@".$sort_type."@".$type."@".$keyword;
		$options = base64_encode($sort_by."@".$sort_type."@".$type."@".$keyword);

		$config['uri_segment']='5';
		$config['base_url'] = base_url().'article/listarticle/'.$limit.'/'.$options.'/';
		$config['total_rows'] = $this->blog_model->get_total_blog_count($type,$keyword);
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->blog_model->get_blog_result($offset,$limit,$sort_by,$sort_type,$type,$keyword);
		
	
		
	
		$data['msg'] = $msg;
		$data["task_type"] = '';
		
		
		$data['offset'] = $offset;
		$data['error']='';
		
	
	  	$data['type']=$type;
		if($keyword == "0"){$keyword = '';}
	    $data['keyword'] = $keyword;
		
		$data['redirect_page']='listarticle';
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
		$this->template->write_view ('content_center', $theme.'/blog/blog_list', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();

	}

	
	
   function detail($blog_id = 0, $msg = '',$limit=5,$offset=0)
   {
   	
   	
   	  $blog_id = base64_decode($blog_id);
	  $this->load->library('pagination');
	    $data = array();
		$data['msg'] = $msg;
		$data["blog_id"] = $blog_id;
		
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$page_detail=meta_setting();
		$data["blog_detail"] = $this->blog_model->get_one_blog($blog_id);
		$pageTitle=$data["blog_detail"]['blog_meta_title'];
		$metaDescription=$data["blog_detail"]['blog_meta_description'];
		$metaKeyword=$data["blog_detail"]['blog_meta_keyword'];
		
		
		$data['site_setting'] = site_setting ();
        $data['active_menu']='detail';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		
		$data["blog_comment"] = $this->blog_model->get_blog_comment($blog_id);
		$data["recent_blog"] = $this->blog_model->get_blog_recent();
		
        $data["check_already_retade"] = check_already_blog_rated($blog_id,$this->session->userdata("user_id"));
		
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'article/detail/'.base64_encode($blog_id).'/'.$msg="null".'/'.$limit.'/';
		$config["total_rows"] = $this->blog_model->get_blog_comment_count($blog_id);
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['blog_comment'] = $this->blog_model->get_blog_comment($blog_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		 $data["blog_subcomment"] = $this->blog_model->get_blog_subcomments($blog_id);
		if($data['blog_comment']=='')
		{
			//$offset=0;
			$config['uri_segment']='6';
			$config['base_url'] = base_url().'article/detail/'.base64_encode($blog_id).'/'.$msg="null".'/'.$limit.'/';
			$config["total_rows"] = $this->blog_model->get_blog_comment_count($blog_id);
			$config['per_page'] = $limit;
			$this->pagination->initialize($config);		
			$data['page_link'] = $this->pagination->create_links();
			$data['blog_comment'] = $this->blog_model->get_blog_comment($blog_id,$offset,$limit);	
		}
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/blog/comment_ajax',$data,TRUE);die;
		}
		else{
        // if(get_authenticateUserID() > 0)
        // {
		  // $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        // }
        // else
        // {
            // $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        // }
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/blog/blog_detail', $data, TRUE);
		}
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();
		
   }

  
  
  // function add_comment()
  // {
  	// $data_insert = $_POST;
// 	 
	 // $data_insert["user_id"] = $this->session->userdata("user_id");
	 // $data_insert["status"] = "active";
	 // $data_insert["date_added"] = date("Y-m-d H:i:s");
	 // $data_insert["is_deleted"] = "no";
// 	 
	 // $this->blog_model->insert_comment($data_insert);
// 	 
	 // echo "Your comment added successfully";
	 // die;
// 	 
  // }
  
  function add_comment($bid = 0){
			if(get_authenticateUserID()=='')
		{
			redirect('home');
		}	
		
		$erro_str = '';
		if($_POST["comment_title"] == '')
		{
			  $erro_str .=  "<p>Comment title is required</p>";
		}
		if($_POST["comment"] == '')
		{
			  $erro_str .=  "<p>Comment description is required</p>";
		}
		
		
		if($erro_str !="")
		{
			$response = array("comment_error"=>$erro_str,"status"=>"fail");
			echo json_encode($response);
		     die;
		}
		
		 	$data_insert = $_POST;
	 
	 $data_insert["user_id"] = $this->session->userdata("user_id");
	 $data_insert["status"] = "active";
	 $data_insert["date_added"] = date("Y-m-d H:i:s");
	 $data_insert["is_deleted"] = "no";
	 
	 $cmt_id = $this->blog_model->insert_comment($data_insert);	
			
		$latest_comment = latest_blog_comment($cmt_id);
		
		$latest_comment->cust_date = date('d M',strtotime($latest_comment->date_added));
	    $latest_comment->date_duration = getDuration($latest_comment->date_added); 
			
		$res =  json_encode($latest_comment);
		echo $res;
	}
  
  function add_subcomment($bid =0){

        if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		$erro_str = '';
		
		if($_POST["comment"] == '')
		{
			$erro_str .=  "<p>Comment  is required</p>";
		}
		
		
		if($erro_str !="")
		{
			$response = array("comment_error"=>$erro_str,"status"=>"fail","master_comment"=>$_POST["master_comment_id"]);
			echo json_encode($response);
		     die;
		}
		
			// end of validation//
		$cmt_id = $this->blog_model->insert_subcomment($_POST);
		
		$latest_comment = latest_blog_comment($cmt_id);
		$latest_comment->cust_date = date('d M',strtotime($latest_comment->date_added));
	    $latest_comment->date_duration = getDuration($latest_comment->date_added); 
		
		$res2 =  json_encode($latest_comment);
		echo $res2;
	}
  function add_rating()
  {
  	  $data = $_POST;
	  $data["date_added"] = date("Y-m-d H:i:s");
	  $this->db->insert("blog_rating",$data);
	 $id = mysql_insert_id();
	 
	 echo get_blog_rating($_POST["blog_id"]);
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
	
	function remove_subcomment(){
		$blog_comment_id = $_POST['blog_comment_id'];
		$this->blog_model->sub_comment_remove($blog_comment_id);
		echo $blog_comment_id;
	}
}
?>