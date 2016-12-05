<?php
class Myvideo extends SPACULLUS_Controller {

	/*
	 Function name :User()
	 */

	function Myvideo() {
		parent :: __construct ();
	   	$this->load->model ('myvideo_model');
		$this->load->helper ("cookie");

	}

	public function index ($msg = '') {
		
		//echo "hello"; die;
		redirect('myvideo/myvideo_list');

	}

	public function myvideo_list($limit=5,$offset=0,$msg = '') {
		
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
		$config['base_url'] = base_url().'myvideo/myvideo_list/'.$limit.'/';
		$config['total_rows'] = $this->myvideo_model->get_total_video_count($user_id);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['active_menu']="";
		$data['error']="";
		$data["site_setting"] = site_setting ();
		$user_id=$this->session->userdata("user_id");
		$data['result'] = $this->myvideo_model->get_video_result_by_user($user_id,$offset,$limit);
		//print_r($data['result']); die;
		//echo $this->db->last_query();
		$data['option']='';
		$data['keyword']='';
			
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		//$this->template->write_view ('content_center', $theme.'/patient/myvideo_list_first', $data, TRUE);
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        $this->template->write_view ('content_center', $theme.'/user/myvideo_list', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();

	}

	function add_myvideo($msg = '',$id=0){
		//echo "$id"; die;
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
		$data["category"]=$this->myvideo_model->get_category_result();
		$data["membership"]=$this->myvideo_model->get_membership_result();
		//echo $this->db->last_query(); die;
		//print_r($data["category"]); die;
		
		$this->load->library ('form_validation');
       
		$this->form_validation->set_rules ('video_title', 'Video title', 'required');
		$this->form_validation->set_rules ('video_category_id', 'Video Category Id', 'required');
		//$this->form_validation->set_rules ('membership_paln_id', 'Membership Paln Id', 'required');
		$this->form_validation->set_rules ('video_desc', 'Description', 'required');
		$this->form_validation->set_rules ('video_type', 'Video Type', 'required');
		$this->form_validation->set_rules ('video_status', 'Video Status', 'required');
		$this->form_validation->set_rules ('video_price', 'Video Price', 'required');
		$one_video = $this->myvideo_model->get_one_video($id);
		//print_r($one_video);
		$data["error"] = "";
		
		$data["video_id"] = $id;
		//$data["redirect_page"]=$redirect_page;
		$data["video_title"] = $one_video['video_title'];
		$data["video_price"] = $one_video['video_price'];
		$data["video_category_id"] = $one_video['video_category_id'];
		$data["membership_paln_id"] =$one_video['membership_paln_id'];
		$data["video_desc"] = $one_video['video_desc'];
		$data['video_type']=$one_video['video_type'];
		$data['video_status']=$one_video['video_status'];
		$data['video_image']=$one_video['video_image'];
		$data['video_file_name']=$one_video['video_file_name'];
		$data['video_preview']=$one_video['video_preview'];		
		$data['site_setting'] = site_setting();
		
		if ($_POST) {
			if ($this->form_validation->run ()== FALSE) {
				if (validation_errors ()) {
					$data["error"] = validation_errors ();
				} else {
					$data["error"] = "";
				}
				$data['video_title']=$this->input->post('video_title');
				$data['video_category_id']=$this->input->post('video_category_id');
				$data['membership_paln_id']=$this->input->post('membership_paln_id');
				$data['video_desc']=$this->input->post('video_desc');
				$data['video_type']=$this->input->post('video_type');
				$data['video_status']=$this->input->post('video_status');
				$data['video_image']=$this->input->post('video_image');
				$data['video_file_name']=$this->input->post('video_file_name');
				$data['video_file_name']=$this->input->post('video_file_name');
				//$data['video_status']=$this->input->post('video_status');
				

			} else {
					//echo $this->input->post('video_id'); die;
				if($this->input->post('video_id')=='' || $this->input->post('video_id')==0 ){
						//echo "insert"; die;
				$this->myvideo_model->insert_myvideo();
				//redirect ('user/myprofile/Record has been updated Successfully');
				//$data["msg"] = "Insert";
				$msg = base64_encode("insert");
				
				redirect('myvideo/myvideo_list/5/0/' . $msg.'/');
					}
					else {
						//echo "update"; die;
						$this->myvideo_model->update_video($this->input->post());
						//$data["msg"] = "Insert";
						$msg = base64_encode("update");
						redirect('myvideo/myvideo_list/5/0/' . $msg.'/');
					}
				///* INSERT ARRAY****//
				}	
				
			}
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		//$this->template->write_view ('content_center', $theme.'/patient/myprofile_first', $data, TRUE);
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
       $this->template->write_view ('content_center', $theme.'/user/addMyvideo', $data, TRUE);
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
		
		$one_membership = $this->myvideo_model->get_one_membership($id);
		//print_r($one_membership); die;
		$data["error"] = "";
		/*$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;*/
		
		$data["video_id"] = $id;
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
			
		
	function delete_video123()
	{
		
	}
	
	function delete_video($id=0)
	{
		$this->db->delete('video',array('video_id'=>$id));
		$msg = base64_encode("delete");
		redirect('myvideo/myvideo_list/5/0/' . $msg.'/');
        
	}
	function search_list_video($limit=5,$option='',$keyword='',$offset=0,$msg='')
	{
		
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$redirect_page = 'search_list_video';
		
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
		$config['base_url'] = base_url().'myvideo/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->myvideo_model->get_total_search_video_count($option,$keyword);
		//print_r($config['total_rows']); die;
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		
		$data['result'] = $this->myvideo_model->get_search_video_result($limit,$option,$keyword,$offset);
		//print_r($data['result']); die;
		//echo $this->db->last_query();
		if($data['result']==0){
		$offset=0;
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'myvideo/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->myvideo_model->get_total_search_membership_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->myvideo_model->get_search_video_result($option,$keyword,$offset, $limit);
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
		//echo $option;
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        $this->template->write_view ('content_center', $theme.'/user/myvideo_list', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render();
	}
 
  
	
}
?>