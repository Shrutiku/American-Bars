<?php
class Myblog extends SPACULLUS_Controller {

	/*
	 Function name :User()
	 */

	function Myblog() {
		parent :: __construct ();
	   	$this->load->model ('myblog_model');
		$this->load->helper ("cookie");

	}

	public function index ($msg = '') {
		
		//echo "hello"; die;
		redirect('myblog/myblog_list');

	}
	
	public function myblog_list($limit=5,$offset=0,$msg = '',$option='') {
		
		//echo "class"; die;
		if(!check_user_authentication())
		{ redirect('home'); }	 

		$data['msg'] = base64_decode($msg);
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$this->load->library('pagination');

		$user_id=$this->session->userdata("user_id");
		//$limit=5;
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'myblog/myblog_list/'.$limit.'/';
		$config['total_rows'] = $this->myblog_model->get_total_blog_count($user_id);
		//print_r($config['total_rows']); die;
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		$data['option']=$option;
		$data['keyword']='';
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['active_menu']="";
		$data['error']="";
		$data["site_setting"] = site_setting ();
		$user_id=$this->session->userdata("user_id");
		$data['result'] = $this->myblog_model->get_blog_result_by_user($user_id,$offset,$limit);
		//print_r($data['result']); die;
		//echo $this->db->last_query();
		
			
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		//$this->template->write_view ('content_center', $theme.'/patient/myblog_list_first', $data, TRUE);
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        $this->template->write_view ('content_center', $theme.'/user/myblog_list', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();

	}
	//,$redirectpage='',$option='',$keyword='',$limit='',$offset=''
	
	public function blog_view($id='')
	{
		//echo $id; die;
		if(!check_user_authentication())
		{ redirect('home'); }	 

		//$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['active_menu']="";
		$data['error']="";
		$data["site_setting"] = site_setting ();
		//echo $this->db->last_query(); die;
		//print_r($data["category"]); die;
		
		$one_blog = $this->myblog_model->get_one_blog($id);
		//print_r($one_blog);
		$data["error"] = "";
		
		$data["blog_id"] = $id;
		//$data["redirect_page"]=$redirect_page;
		$data["blog_title"] = $one_blog['blog_title'];
		$data["blog_description"] = $one_blog['blog_description'];
		$data["status"] =$one_blog['status'];
		$data["date_added"] =$one_blog['date_added'];
		$data["user_id"] =$one_blog['user_id'];
		$data["status"] =$one_blog['status'];
		$data["status"] =$one_blog['status'];
		$data["status"] =$one_blog['status'];	
		
		$data['site_setting'] = site_setting();
		
		
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		//$this->template->write_view ('content_center', $theme.'/patient/myprofile_first', $data, TRUE);
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
       	$this->template->write_view ('content_center', $theme.'/user/view_blog', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();
		
	}
	
	
	function add_myblog($msg = '',$id=0){
		//echo "$id"; die;
		//echo "class"; die;
	if(!check_user_authentication())
		{ redirect('home'); }	 

		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['active_menu']="";
		$data['error']="";
		$data["site_setting"] = site_setting ();
		//echo $this->db->last_query(); die;
		//print_r($data["category"]); die;
		
		$this->load->library ('form_validation');
       
		$this->form_validation->set_rules ('blog_title', 'Article title', 'required');
		$this->form_validation->set_rules ('blog_description', 'Blog description', 'required');
		$this->form_validation->set_rules ('status', 'Status', 'required');
		$one_blog = $this->myblog_model->get_one_blog($id);
		//print_r($one_blog);
		$data["error"] = "";
		
		$data["blog_id"] = $id;
		//$data["redirect_page"]=$redirect_page;
		$data["blog_title"] = $one_blog['blog_title'];
		$data["blog_description"] = $one_blog['blog_description'];
		$data["status"] =$one_blog['v'];
		//$data["blog_desc"] = $one_blog['blog_desc'];
		//$data['blog_type']=$one_blog['blog_type'];
		//$data['blog_price']=$one_blog['blog_price'];
		//$data['blog_status']=$one_blog['blog_status'];
		//$data['blog_image']=$one_blog['blog_image'];
		$data['site_setting'] = site_setting();
		
		if ($_POST) {
			if ($this->form_validation->run ()== FALSE) {
				if (validation_errors ()) {
					$data["error"] = validation_errors ();
				} else {
					$data["error"] = "";
				}
				$data['blog_title']=$this->input->post('blog_title');
				$data['blog_description']=$this->input->post('blog_description');
				$data['status']=$this->input->post('status');
				//$data['blog_desc']=$this->input->post('blog_desc');
				//$data['blog_type']=$this->input->post('blog_type');
				//$data['blog_status']=$this->input->post('blog_status');
				//$data['blog_image']=$this->input->post('blog_image');
				//$data['blog_file_name']=$this->input->post('blog_file_name');
				//$data['blog_file_name']=$this->input->post('blog_file_name');
				//$data['blog_status']=$this->input->post('blog_status');
				

			} else {
					//echo $this->input->post('blog_id'); die;
				if($this->input->post('blog_id')=='' || $this->input->post('blog_id')==0 ){
						//echo "insert"; die;
				$this->myblog_model->insert_myblog();
				//redirect ('user/myprofile/Record has been updated Successfully');
				//$data["msg"] = "Insert";
				$msg = base64_encode("insert");
				
				redirect('myblog/myblog_list/5/0/' . $msg.'/');
					}
					else {
						echo "update"; die;
						$this->myblog_model->update_blog();
						//$data["msg"] = "Insert";
						$msg = base64_encode("update");
						redirect('myblog/myblog_list/5/0/' . $msg.'/');
					}
				///* INSERT ARRAY****//
				}	
				
			}
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		//$this->template->write_view ('content_center', $theme.'/patient/myprofile_first', $data, TRUE);
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
       $this->template->write_view ('content_center', $theme.'/user/addMyblog', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();
        //$user_info = get_patient_user_info(get_authenticateUserID());		
}
	
	function edit_membership($id=0)
	{
		//echo "edit_membership"; die;	
		if(!check_user_authentication())
		{ redirect('home'); }	 
		
		//$data['msg'] = base64_decode($msg);
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$one_membership = $this->myblog_model->get_one_membership($id);
		//print_r($one_membership); die;
		$data["error"] = "";
		/*$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;*/
		
		$data["blog_id"] = $id;
		//$data["redirect_page"]=$redirect_page;
		$data["plan_title"] = $one_membership['plan_title'];
		$data["category"] = $one_membership['category'];
		$data["total_month"] =$one_membership['total_month'];
		$data["price"] = $one_membership['price'];
		$data['description']=$one_membership['description'];
		$data['site_setting'] = site_setting();
		
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
       $this->template->write_view ('content_center', $theme.'/user/addMembership', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render();
	}
			
	function delete_blog($id=0)
	{
		$this->db->delete('blog',array('blog_id'=>$id));
		$msg = base64_encode("delete");
		redirect('myblog/myblog_list/5/0/' . $msg.'/');
        
	}
	function search_list_blog($limit=5,$option='',$keyword='',$offset=0,$msg='')
	{
		
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$redirect_page = 'search_list_blog';
		
		$this->load->library('pagination');
		
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
		//echo $option; die;
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',trim($keyword)));

	
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'myblog/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->myblog_model->get_total_search_blog_count($option,$keyword);
		//print_r($config['total_rows']); die;
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		
		$data['result'] = $this->myblog_model->get_search_blog_result($limit,$option,$keyword,$offset);
		//print_r($data['result']); die;
		//echo $this->db->last_query();
		if($data['result']==0){
		$offset=0;
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'myblog/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->myblog_model->get_total_search_blog_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->myblog_model->get_search_blog_result($option,$keyword,$offset, $limit);
		//print_r($data['result']); die;
		}
		
		$data['msg'] = $msg;
		$data['offset'] = $offset;
		$data['site_setting'] = site_setting();
		
		$data['limit']=$limit;
		$data['option']=$option;
		$data['keyword']=$keyword;
		$data['search_type']='search';
		$data['redirect_page']=$redirect_page;
		
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        $this->template->write_view ('content_center', $theme.'/user/myblog_list', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render();
	}
	function editorimage()
	{
	//	$url = '../images/uploads/’.time()."_".$_FILES['upload']['name']';
		
		$url = base_path()."upload/gallery/".time()."_".$_FILES['upload']['name'];
		$url1 =base_url()."upload/gallery/".time()."_".$_FILES['upload']['name'];

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
			echo "<script type='text/javascript'>;window.parent.CKEDITOR.tools.callFunction($funcNum, '$url1', '$message');</script>";
	}
 
  
	
}
?>