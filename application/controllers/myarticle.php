<?php
class Myarticle extends SPACULLUS_Controller {

	/*
	 Function name :User()
	 */

	function Myarticle() {
		parent :: __construct ();
	   	$this->load->model ('myarticle_model');
		$this->load->helper ("cookie");

	}

	public function index ($msg = '') {
		
		//echo "hello"; die;
		redirect('myarticle/myarticle_list');

	}

	public function myarticle_list($limit=5,$offset=0,$msg = '',$option='') {
		
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
		$config['base_url'] = base_url().'myarticle/myarticle_list/'.$limit.'/';
		$config['total_rows'] = $this->myarticle_model->get_total_article_count($user_id);
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
		$data['result'] = $this->myarticle_model->get_article_result_by_user($user_id,$offset,$limit);
		//print_r($data['result']); die;
		//echo $this->db->last_query();
		
			
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		//$this->template->write_view ('content_center', $theme.'/patient/myarticle_list_first', $data, TRUE);
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        $this->template->write_view ('content_center', $theme.'/user/myarticle_list', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();

	}

	function add_myarticle($msg = '',$id=0){
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
		$data["category"]=$this->myarticle_model->get_category_result();
		$data["membership"]=$this->myarticle_model->get_membership_result();
		//echo $this->db->last_query(); die;
		//print_r($data["category"]); die;
		
		$this->load->library ('form_validation');
       
		$this->form_validation->set_rules ('article_title', 'Article title', 'required');
		$this->form_validation->set_rules ('article_category_id', 'Article Category Id', 'required');
		//$this->form_validation->set_rules ('membership_paln_id', 'Membership Paln Id', 'required');
		$this->form_validation->set_rules ('article_desc', 'Description', 'required');
		$this->form_validation->set_rules ('article_type', 'Article Type', 'required');
		$this->form_validation->set_rules ('article_status', 'Article Status', 'required');
		//$this->form_validation->set_rules ('article_price', 'Video Price', 'required');
		$one_article = $this->myarticle_model->get_one_article($id);
		//print_r($one_article);
		$data["error"] = "";
		
		$data["article_id"] = $id;
		//$data["redirect_page"]=$redirect_page;
		$data["article_title"] = $one_article['article_title'];
		$data["article_category_id"] = $one_article['article_category_id'];
		$data["membership_paln_id"] =$one_article['membership_paln_id'];
		$data["article_desc"] = $one_article['article_desc'];
		$data['article_type']=$one_article['article_type'];
		$data['article_price']=$one_article['article_price'];
		$data['article_status']=$one_article['article_status'];
		$data['article_image']=$one_article['article_image'];
		$data['site_setting'] = site_setting();
		
		if ($_POST) {
			if ($this->form_validation->run ()== FALSE) {
				if (validation_errors ()) {
					$data["error"] = validation_errors ();
				} else {
					$data["error"] = "";
				}
				$data['article_title']=$this->input->post('article_title');
				$data['article_category_id']=$this->input->post('article_category_id');
				$data['membership_paln_id']=$this->input->post('membership_paln_id');
				$data['article_desc']=$this->input->post('article_desc');
				$data['article_type']=$this->input->post('article_type');
				$data['article_status']=$this->input->post('article_status');
				$data['article_image']=$this->input->post('article_image');
				//$data['article_file_name']=$this->input->post('article_file_name');
				//$data['article_file_name']=$this->input->post('article_file_name');
				//$data['article_status']=$this->input->post('article_status');
				

			} else {
					//echo $this->input->post('article_id'); die;
				if($this->input->post('article_id')=='' || $this->input->post('article_id')==0 ){
						//echo "insert"; die;
				$this->myarticle_model->insert_myarticle();
				//redirect ('user/myprofile/Record has been updated Successfully');
				//$data["msg"] = "Insert";
				$msg = base64_encode("insert");
				
				redirect('myarticle/myarticle_list/5/0/' . $msg.'/');
					}
					else {
						//echo "update"; die;
						$this->myarticle_model->update_article();
						//$data["msg"] = "Insert";
						$msg = base64_encode("update");
						redirect('myarticle/myarticle_list/5/0/' . $msg.'/');
					}
				///* INSERT ARRAY****//
				}	
				
			}
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		//$this->template->write_view ('content_center', $theme.'/patient/myprofile_first', $data, TRUE);
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
       $this->template->write_view ('content_center', $theme.'/user/addMyarticle', $data, TRUE);
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
		
		$one_membership = $this->myarticle_model->get_one_membership($id);
		//print_r($one_membership); die;
		$data["error"] = "";
		/*$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;*/
		
		$data["article_id"] = $id;
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
			
	function delete_article($id=0)
	{
		$this->db->delete('article',array('article_id'=>$id));
		$msg = base64_encode("delete");
		redirect('myarticle/myarticle_list/5/0/' . $msg.'/');
        
	}
	function search_list_article($limit=5,$option='',$keyword='',$offset=0,$msg='')
	{
		
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$redirect_page = 'search_list_article';
		
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
		$config['base_url'] = base_url().'myarticle/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->myarticle_model->get_total_search_article_count($option,$keyword);
		//print_r($config['total_rows']); die;
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		
		$data['result'] = $this->myarticle_model->get_search_article_result($limit,$option,$keyword,$offset);
		//print_r($data['result']); die;
		//echo $this->db->last_query();
		if($data['result']==0){
		$offset=0;
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'myarticle/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->myarticle_model->get_total_search_article_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->myarticle_model->get_search_article_result($option,$keyword,$offset, $limit);
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
        $this->template->write_view ('content_center', $theme.'/user/myarticle_list', $data, TRUE);
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