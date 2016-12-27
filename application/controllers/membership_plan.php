<?php
class Membership_plan extends SPACULLUS_Controller {

	/*
	 Function name :User()
	 */

	function Membership_plan() {
		parent :: __construct ();
	   	$this->load->model ('membership_model');
		$this->load->helper ("cookie");

	}

	public function index ($msg = '') {
		
		//echo "hello"; die;
		redirect('membership_plan/membership_plan_list');

	}

	public function membership_plan_list($limit=5,$offset=0,$msg = '') {
		
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
		$config['base_url'] = base_url().'membership_plan/membership_plan_list/'.$limit.'/';
		$config['total_rows'] = $this->membership_model->get_total_membership_count($user_id);
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
		$data['result'] = $this->membership_model->get_membership_result_by_user($user_id,$offset,$limit);
		//echo $this->db->last_query();
		$data['option']='';
		$data['keyword']='';
			
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		//$this->template->write_view ('content_center', $theme.'/patient/membership_plan_list_first', $data, TRUE);
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        $this->template->write_view ('content_center', $theme.'/user/membership_plan_list', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();

	}

	function add_membership_plan($msg = '',$id=0){
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
		
		$this->load->library ('form_validation');
       
		$this->form_validation->set_rules ('plan_title', 'Plan title', 'required');
		$this->form_validation->set_rules ('category', 'Category', 'required');
		$this->form_validation->set_rules ('description', 'Description', 'required');
		$this->form_validation->set_rules ('price', 'Price', 'required');
		$this->form_validation->set_rules ('total_month', 'Total month', 'required');
		
		$one_membership = $this->membership_model->get_one_membership($id);
		//print_r($one_membership); die;
		$data["error"] = "";
		
		$data["membership_plan_id"] = $id;
		//$data["redirect_page"]=$redirect_page;
		$data["plan_title"] = $one_membership['plan_title'];
		$data["category"] = $one_membership['category'];
		$data["total_month"] =$one_membership['total_month'];
		$data["price"] = $one_membership['price'];
		$data['description']=$one_membership['description'];
		$data['site_setting'] = site_setting();
		
		if ($_POST) {
			if ($this->form_validation->run ()== FALSE) {
				if (validation_errors ()) {
					$data["error"] = validation_errors ();
				} else {
					$data["error"] = "";
				}
				$data['plan_title']=$this->input->post('plan_title');
				$data['category']=$this->input->post('category');
				$data['description']=$this->input->post('description');
				$data['price']=$this->input->post('price');
				$data['total_month']=$this->input->post('total_month');
				$data['membership_plan_id']=$this->input->post('membership_plan_id');
				

			} else {
				if($this->input->post('membership_plan_id')!='' && $this->input->post('membership_plan_id')==0 ){
						//echo "insert"; die;
				$this->membership_model->insert_membership_plan($this->input->post());
				//redirect ('user/myprofile/Record has been updated Successfully');
				//$data["msg"] = "Insert";
				$msg = base64_encode("insert");
				redirect('membership_plan/membership_plan_list/5/0/' . $msg.'/');
					}
					else {
						//echo "update"; die;
						$this->membership_model->update_membership_plan($this->input->post());
						//$data["msg"] = "Insert";
						$msg = base64_encode("update");
						redirect('membership_plan/membership_plan_list/5/0/' . $msg.'/');
					}
				///* INSERT ARRAY****//
				}	
				
			}
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		//$this->template->write_view ('content_center', $theme.'/patient/myprofile_first', $data, TRUE);
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
       $this->template->write_view ('content_center', $theme.'/user/addMembership', $data, TRUE);
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
		
		$one_membership = $this->membership_model->get_one_membership($id);
		//print_r($one_membership); die;
		$data["error"] = "";
		/*$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;*/
		
		$data["membership_plan_id"] = $id;
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
			
		
	
	
	function delete_membership($id=0)
	{
		$this->db->delete('membership_plan',array('membership_plan_id'=>$id));
		$msg = base64_encode("delete");
		redirect('membership_plan/membership_plan_list/5/0/' . $msg.'/');
        
	}
	function search_list_membership($limit=5,$option='',$keyword='',$offset=0,$msg='')
	{
		
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$redirect_page = 'search_list_membership';
		
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
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',trim($keyword)));
		//echo $keyword; die; 
	
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'membership_plan/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->membership_model->get_total_search_membership_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		
		$data['result'] = $this->membership_model->get_search_membership_result($limit,$option,$keyword,$offset);
		//print_r($data['result']); die;
		
		if($data['result']==0){
		$offset=0;
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'membership_plan/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->membership_model->get_total_search_membership_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->membership_model->get_search_membership_result($option,$keyword,$offset, $limit);
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
        $this->template->write_view ('content_center', $theme.'/user/membership_plan_list', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render();
	}
 
  
	
}
?>