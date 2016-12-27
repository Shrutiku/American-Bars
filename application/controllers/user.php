<?php
class User extends SPACULLUS_Controller {

	/*
	 Function name :User()
	 */

	function User() {
		parent :: __construct ();
	   // $this->load->model ('patient_model');
		$this->load->model ('user_model');
		$this->load->model ('home_model');
		//$this->load->model ('bar_model');
		$this->load->helper ("cookie");
		$this->load->library('twilio');
		$this->load->config('twilio', TRUE);

	}

	public function index ($msg = '') {
		
		
		redirect('user/myprofile');

	}

	public function myprofile($msg = '') {
		
		//echo $msg; die;
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
		$one_user=$this->user_model->get_one_user(get_authenticateUserID());
		//print_r($one_user);
		
		$this->load->library ('form_validation');
       
		$data["patient_id"] = get_authenticateUserID();
		$this->form_validation->set_rules ('first_name', 'First name', 'required');
		$this->form_validation->set_rules ('last_name', 'Last name', 'required');
		$this->form_validation->set_rules ('gender', 'Gender', 'required');
		$this->form_validation->set_rules ('email', 'Email', 'required');
		$this->form_validation->set_rules ('about_user', 'About user', 'required');
		$this->form_validation->set_rules ('address', 'Address', 'required');
		$this->form_validation->set_rules('phone_no','Phone_no','required');
		
		$data['first_name']=$one_user['first_name'];
		$data['last_name']=$one_user['last_name'];
		$data['gender']=$one_user['gender'];
		$data['birth_date']=date('Y-m-d',strtotime($one_user['birthdate']));
		$data['email']=($one_user['email']);
		$data['about_user']=($one_user['about_user']);
		$data['address']=$one_user['address'];
		$data['phone_no']=$one_user['phone_no'];
		$data['profile_image']=$one_user['profile_image'];
	    
		
		
		
		if ($_POST) {
			if ($this->form_validation->run ()== FALSE) {
				if (validation_errors ()) {
					$data["error"] = validation_errors ();
				} else {
					$data["error"] = "";
				}
				$data['first_name']=$this->input->post('first_name');
				$data['last_name']=$this->input->post('last_name');
				$data['gender']=$this->input->post('gender');
				$data['birth_date']=$this->input->post('birth_date');
				$data['address']=$this->input->post('address');
				$data['phone_no']=$this->input->post('phone_no');
				$data['about_user']=$this->input->post('about_user');
				$data['email']=$this->input->post('email');
				
				

			} else {

				///* INSERT ARRAY****//
				$this->user_model->update_user($this->input->post());
				//redirect ('user/myprofile/Record has been updated Successfully');
				$data["msg"] = "update";
				$this->template->write ('pageTitle', $pageTitle, TRUE);
				$this->template->write ('metaDescription', $metaDescription, TRUE);
				$this->template->write ('metaKeyword', $metaKeyword, TRUE);
				//$this->template->write_view ('content_center', $theme.'/patient/myprofile_first', $data, TRUE);
				$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		        $this->template->write_view ('content_center', $theme.'/user/myprofile', $data, TRUE);
				$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		
				$this->template->render ();
				

			}
		}

        //$user_info = get_patient_user_info(get_authenticateUserID());
		
		
        
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		//$this->template->write_view ('content_center', $theme.'/patient/myprofile_first', $data, TRUE);
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
       $this->template->write_view ('content_center', $theme.'/user/myprofile', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();

	}

	
	function upload_file()
	{
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$data['active_menu']="";
		$data['error']="";
		$data["site_setting"] = site_setting ();
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		 $user_image='';
		 $image_settings=image_setting();
		 if($_FILES['photoimg']['name']!='')
		 {
			 $this->load->library('upload');
			 $rand=rand(0,100000); 
			  
			
			 $img_type = array('image/gif','image/jpeg', 'image/pjpeg','image/jpeg', 'image/pjpeg','image/jpeg', 'image/pjpeg',
			                   'image/png',  'image/x-png','image/bmp', 'image/x-windows-bmp');
			 
			 if(!in_array($_FILES['photoimg']['type'],$img_type))
			 {
			 	  echo json_encode(array('status' => "fail", 'msg' => $_REQUEST["prev_img"]));
			 	  exit;
			 }
			 
			 
			 $_FILES['userfile']['name']     =   $_FILES['photoimg']['name'];
			 $_FILES['userfile']['type']     =   $_FILES['photoimg']['type'];
			 $_FILES['userfile']['tmp_name'] =   $_FILES['photoimg']['tmp_name'];
			 $_FILES['userfile']['error']    =   $_FILES['photoimg']['error'];
			 $_FILES['userfile']['size']     =   $_FILES['photoimg']['size'];
   
			$config['file_name'] = $rand.'user'.substr($_FILES['photoimg']['name'],0,3);
			
			$config['upload_path'] = base_path().'upload/user_orig/';
			
			$config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
			 $this->upload->initialize($config);
 
			  if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			   

			   
			  $picture = $this->upload->data();
			  $this->load->library('image_lib');
			  $this->image_lib->clear();
				$gd_var='gd2';
		   if ($_FILES["photoimg"]["type"]!= "image/png" and $_FILES["photoimg"]["type"] != "image/x-png") {
			$gd_var='gd2';
			}
		   if ($_FILES["photoimg"]["type"] != "image/gif") {
				$gd_var='gd2';
		   }
			if ($_FILES["photoimg"]["type"] != "image/jpeg" and $_FILES["photoimg"]["type"] != "image/pjpeg" ) {
				$gd_var='gd2';
		   }
			  $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/user_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/user_thumb/'.$picture['file_name'],
				'maintain_ratio' => TRUE,
				'quality' => '100%',
				'width' => $image_settings->user_width ,
				'height' => $image_settings->user_height
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			    redirect("user/myprofile/".base64_encode($error));
			}
			
			$user_image=$picture['file_name'];
			//$this->input->post('prev_restaurant_image');
			
			$this->user_model->update_image($user_image,$this->input->post("prev_img"));
			//$msg="update";
			//redirect("user/myprofile/".$msg);
            echo json_encode(array('status' => "success", 'msg' => $user_image));
	 		
				
	 }
  }	

  
	function changeuserlogo()
	{	$valid_formats = array("jpg", "png", "gif", "bmp","jpeg","PNG","JPG","JPEG","GIF","BMP");
	
	   
		$ext = end(explode(".", $_FILES['photoimg']['name']));
		 
		$bar_logo_img = '';
		if(in_array($ext,$valid_formats))
		{
		 if($_FILES['photoimg']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['photoimg']['name'];
             $_FILES['userfile']['type']     =   $_FILES['photoimg']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['photoimg']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['photoimg']['error'];
             $_FILES['userfile']['size']     =   $_FILES['photoimg']['size'];
   
			$config['file_name'] = 'user_logo'.$rand;
			
            $config['upload_path'] = base_path().'upload/user_orig/';
			
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			
			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   
              $this->image_lib->clear();
		   	
			
					$gd_var='gd2';
				
				
		   if ($_FILES["photoimg"]["type"]!= "image/png" and $_FILES["photoimg"]["type"] != "image/x-png") {		  
			   	$gd_var='gd2';			
			}
			
					
		   if ($_FILES["photoimg"]["type"] != "image/gif") {		   
		    	$gd_var='gd2';
		   }	   
		   
		   if ($_FILES["photoimg"]["type"] != "image/jpeg" and $_FILES["photoimg"]["type"] != "image/pjpeg" ) {		   
		    	$gd_var='gd2';
		   }
		   
             
			// $this->image_lib->clear();
// 			
			 // $this->image_lib->initialize(array(
				// 'image_library' => $gd_var,
				// 'source_image' => base_path().'upload/user_orig/'.$picture['file_name'],
				// 'new_image' => base_path().'upload/barlogo/'.$picture['file_name'],
				// 'maintain_ratio' => FALSE,
				// 'quality' => '100%',
				// 'width' => '685',
				// 'height' => '320',
			 // ));
// 			
// 			
			// if(!$this->image_lib->resize())
			// {
				// $error = $this->image_lib->display_errors();
			// }
// 			
			
			$this->image_lib->clear();
		    resize(base_path().'upload/user_orig/'.$picture['file_name'],base_path().'upload/user_thumb/'.$picture['file_name'],120,120);
			
			$this->image_lib->clear();
		    resize(base_path().'upload/user_orig/'.$picture['file_name'],base_path().'upload/user_140/'.$picture['file_name'],140,140);
			
			$this->image_lib->clear();
		    resize(base_path().'upload/user_orig/'.$picture['file_name'],base_path().'upload/user_288/'.$picture['file_name'],288,288);
			
			$bar_logo_img=$picture['file_name'];
			
		
			if($this->input->post('prev_bar_logo')!='')
				{
					if(file_exists(base_path().'upload/user_288/'.$this->input->post('prev_bar_logo')))
					{
						$link=base_path().'upload/user_288/'.$this->input->post('prev_bar_logo');
						unlink($link);
					}
					if(file_exists(base_path().'upload/user_140/'.$this->input->post('prev_bar_logo')))
					{
						$link=base_path().'upload/user_140/'.$this->input->post('prev_bar_logo');
						unlink($link);
					}
					if(file_exists(base_path().'upload/user_orig/'.$this->input->post('prev_bar_logo')))
					{
						$link=base_path().'upload/user_orig/'.$this->input->post('prev_bar_logo');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/user_thumb/'.$this->input->post('prev_bar_logo')))
					{
						$link2=base_path().'upload/user_thumb/'.$this->input->post('prev_bar_logo');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('prev_bar_logo')!='')
				{
					$bar_logo_img=$this->input->post('prev_bar_logo');
				}
				
				
			}
			 $update = array('profile_image'=>$bar_logo_img);
			 $this->db->where("user_id",get_authenticateUserID());
		 	 $this->db->update("user_master",$update);
			 
			  $update = array('taxi_image'=>$bar_logo_img);
			 $this->db->where("taxi_owner_id",get_authenticateUserID());
		 	 $this->db->update("taxi_directory",$update);
			 echo "<img src='".base_url()."upload/user_thumb/".$bar_logo_img."' class='img-responsive'/>";
			}
else {
	         echo "Invalid file format.."; 
}
            
	}
 
    function editinfo()
	{
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email','Email','required|callback_email_check_enthuser');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('nick_name', 'Bay Fly Nickname', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
	//	$this->form_validation->set_rules('about_user', 'About User', 'required');
		$data["error"] = '';
		$data["msg"] = '';
		
		
		if($this->form_validation->run() == FALSE)
		{			
				if(validation_errors())
				{
					$data["error"] = validation_errors();
				}else{
					$data["error"] = "";
				}
				$data["email"] = $this->input->post('email');
				$data["first_name"] = $this->input->post('first_name');
				$data["last_name"] = $this->input->post('last_name');
				$data["nick_name"] = $this->input->post('nick_name');
				$data["address"] = $this->input->post('address');
				$data["about_user"] = $this->input->post('about_user');
				$data["mobile_no"] = $this->input->post('mobile_no');
				$data["user_city"] = $this->input->post('user_city');
				$data["user_state"] = $this->input->post('user_state');
				$data["gender"] = $this->input->post('gender');
				$data["user_zip"] = $this->input->post('user_zip');
				$data["fb_link"] = $this->input->post('fb_link');
				$data["gplus_link"] = $this->input->post('gplus_link');
				$data["twitter_link"] = $this->input->post('twitter_link');
				$data["linkedin_link"] = $this->input->post('linkedin_link');
				$data["pinterest_link"] = $this->input->post('pinterest_link');
				$data["instagram_link"] = $this->input->post('instagram_link');
		}
		else {
			    $this->user_model->user_update();			
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

function editinfo_taxi_owner()
	{
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email','Email','required|callback_email_check_taxiuser');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('taxi_company', 'Company Name', 'required');
		$this->form_validation->set_rules('address', 'Company Address', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');
		$this->form_validation->set_rules('cmpn_zipcode', 'Company Zipcode', 'required|numeric');
		//$this->form_validation->set_rules('texi_company_phone_number', 'Phone Number', 'required');
		//$this->form_validation->set_rules('taxi_company_website', 'Company Website', 'required|valid_url');
		//$this->form_validation->set_rules('reciew', 'Description', 'required');
		$data["error"] = '';
		$data["msg"] = '';
		
		
		if($this->form_validation->run() == FALSE)
		{			
				if(validation_errors())
				{
					$data["error"] = validation_errors();
				}else{
					$data["error"] = "";
				}
				$data["email"] = $this->input->post('email');
				$data["taxi_company"] = $this->input->post('taxi_company');
				$data["address"] = $this->input->post('address');
				$data["phone_number"] = $this->input->post('phone_number');
				$data["city"] = $this->input->post('city');
				$data["state"] = $this->input->post('state');
				$data["cmpn_zipcode"] = $this->input->post('cmpn_zipcode');
				$data["cmpn_website"] = $this->input->post('cmpn_website');
				$data["reciew"] = $this->input->post('reciew');
				$data["first_name"] = $this->input->post('first_name');
				$data["last_name"] = $this->input->post('last_name');
				$data["address"] = $this->input->post('address');
				$data["about_user"] = $this->input->post('about_user');
				$data["mobile_no"] = $this->input->post('mobile_no');
				$data["user_city"] = $this->input->post('user_city');
				$data["user_state"] = $this->input->post('user_state');
				$data["user_zip"] = $this->input->post('user_zip');
				$data["fb_link"] = $this->input->post('fb_link');
				$data["gplus_link"] = $this->input->post('gplus_link');
				$data["twitter_link"] = $this->input->post('twitter_link');
				$data["linkedin_link"] = $this->input->post('linkedin_link');
				$data["pinterest_link"] = $this->input->post('pinterest_link');
				$data["instagram_link"] = $this->input->post('instagram_link');
		}
		else {
			    $this->user_model->taxi_owner_update();			
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
function email_check_taxiuser($email){
		
		$email = $this->home_model->email_unique($email,'taxi_owner');
		if($email == FALSE){
			$this->form_validation->set_message('email_check_taxiuser','There is an existing record with this Email Address');
			return FALSE;
		}
		return TRUE;
	}
	
	function email_check_baruser($email){
		
		$email = $this->home_model->email_unique($email,'bar_owner');
		if($email == FALSE){
			$this->form_validation->set_message('email_check_baruser','There is an existing record with this Email Address');
			return FALSE;
		}
		return TRUE;
	}
	
	function email_check_enthuser($email){
		
		$email = $this->home_model->email_unique($email,'user');
		if($email == FALSE){
			$this->form_validation->set_message('email_check_enthuser','There is an existing record with this Email Address');
			return FALSE;
		}
		return TRUE;
	}
function email_check($email){
		$email = $this->home_model->email_unique($email);
		
		if($email == FALSE){
			$this->form_validation->set_message('email_check','There is an existing record with this Email Address');
			return FALSE;
		}
		return TRUE;
	}
  
    function getuserdata()
    {
    	$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
    	$data['getalldata'] = get_user_info(get_authenticateUserID());
		echo $this->load->view($theme .'/home/dashboarduserajax',$data,TRUE);
		die;
    }

	function gettaxiuserdata()
    {
    	$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
    	$data['getalldata'] = get_user_info_taxi(get_authenticateUserID());
		echo $this->load->view($theme .'/home/dashboardtaxiuserajax',$data,TRUE);
		die;
    }
	
	function favoritebeer($limit=5,$keyword='1V1',$offset=0,$msg='')
	{
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}

		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		if($this->input->post('event_keyword')!='')
		{
			$keyword= $this->input->post('event_keyword');
			$limit= $this->input->post('limit');
			$offset= $this->input->post('offset');
		}
		else {
			$keyword = $keyword;
			$limit= $limit;
			$offset= $offset;
		}
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'user/favoritebeer/'.$limit.'/'.$keyword;
		$config["total_rows"] = $this->user_model->getFavoriteBeerCount($keyword);
		
		//$config['total_rows'] = $this->service_provider_model->countStaff($id,$keyword);
		//echo $data["total_rows"];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->user_model->getFavoriteBeer($offset,$limit,$keyword);
		
	
		//	$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='favoritebeer';
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/user/favoritebeer_ajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/user/favoritebeer', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
	}
	
	function favoritecocktail($limit=5,$keyword='1V1',$offset=0,$msg='')
	{
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}

		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		if($this->input->post('event_keyword')!='')
		{
			$keyword= $this->input->post('event_keyword');
			$limit= $this->input->post('limit');
			$offset= $this->input->post('offset');
		}
		else {
			$keyword = $keyword;
			$limit= $limit;
			$offset= $offset;
		}
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'user/favoritecocktail/'.$limit.'/'.$keyword;
		$config["total_rows"] = $this->user_model->getFavoriteCocktailCount($keyword);
		
		//$config['total_rows'] = $this->service_provider_model->countStaff($id,$keyword);
		//echo $data["total_rows"];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->user_model->getFavoriteCocktail($offset,$limit,$keyword);
		
	
		//	$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='favoritecocktail';
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/user/favoritecocktail_ajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/user/favoritecocktail', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
	}

    function favoriteliquor($limit=5,$keyword='1V1',$offset=0,$msg='')
	{
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}

		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		if($this->input->post('event_keyword')!='')
		{
			$keyword= $this->input->post('event_keyword');
			$limit= $this->input->post('limit');
			$offset= $this->input->post('offset');
		}
		else {
			$keyword = $keyword;
			$limit= $limit;
			$offset= $offset;
		}
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'user/favoriteliquor/'.$limit.'/'.$keyword;
		$config["total_rows"] = $this->user_model->getFavoriteLiquorCount($keyword);
		
		//$config['total_rows'] = $this->service_provider_model->countStaff($id,$keyword);
		//echo $data["total_rows"];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->user_model->getFavoriteLiquor($offset,$limit,$keyword);
		
	
		//	$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='favoriteliquor';
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/user/favoriteliquor_ajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/user/favoriteliquor', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
	}

	function favoritebar($limit=5,$keyword='1V1',$offset=0,$msg='')
	{
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}

		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		if($this->input->post('event_keyword')!='')
		{
			$keyword= $this->input->post('event_keyword');
			$limit= $this->input->post('limit');
			$offset= $this->input->post('offset');
		}
		else {
			$keyword = $keyword;
			$limit= $limit;
			$offset= $offset;
		}
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'user/favoritebar/'.$limit.'/'.$keyword;
		$config["total_rows"] = $this->user_model->getFavoriteBarCount($keyword);
		
		//$config['total_rows'] = $this->service_provider_model->countStaff($id,$keyword);
		//echo $data["total_rows"];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->user_model->getFavoriteBar($offset,$limit,$keyword);
		
	
		//	$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='favoritebar';
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/user/favoritebar_ajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/user/favoritebar', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
	}
	
	
	function album($limit=5,$keyword='1V1',$offset=0,$msg='')
	{
		if($this->session->userdata('user_type')!='user')
		{
			redirect('home');
		}
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}

		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
	
		if($this->input->post('event_keyword')!='')
		{
			$keyword= $this->input->post('event_keyword');
			$limit= $this->input->post('limit');
			$offset= $this->input->post('offset');
		}
		else {
			$keyword = $keyword;
			$limit= $limit;
			$offset= $offset;
		}
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'user/album/'.$limit.'/'.$keyword;
		$config["total_rows"] = $this->user_model->getBarGallerycount($keyword);
		
		//$config['total_rows'] = $this->service_provider_model->countStaff($id,$keyword);
		//echo $data["total_rows"];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->user_model->getBarGalleryDetail($offset,$limit,$keyword);
		
	
		//	$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='album';
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/user/bar_gallery_ajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/user/bar_gallery', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
	}
    
	function add_album()
	{
		$imagarr = '';
		if($this->session->userdata('user_type')!='user')
		{
			redirect('home');
		}
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required');
		
		if($_POST)
		{
			
			//echo '<pre>';
			//print_r($_FILES);die;
			
			
			if(count($_FILES['photo_image']['name'])>0 && $_FILES['photo_image']['name'][0]!=''){
				foreach ($_FILES['photo_image']['name'] as $key => $value) {
					if($_FILES['photo_image']['name'][$key]!=''){
						
					   $imagarr=$this->validate_image(array('name'=>$_FILES['photo_image']['name'][$key],'type'=>$_FILES['photo_image']['type'][$key]));
					}
					if($imagarr!='')
					{
						break;
					}
				}
				//echo $imagarr.'<br>';
				
			}else{
				
				if($this->input->post('bar_gallery_id')==''){
				$imagarr ="Gallery image is required.";
				}
			}
		}	
		//$this->form_validation->set_rules('description', 'Description', 'required');
		$data["error"] = '';
		$data["msg"] = '';
		
		//$bar_detail = $this->bar_model->get_one_bar(base64_decode($bar_id));
		
		if($this->form_validation->run() == FALSE || $imagarr!='')
		{
						
				if(validation_errors()  || $imagarr!='')
				{
					$data["error"] = validation_errors().$imagarr;
				}else{
					$data["error"] = "";
				}
				$data["title"] = $this->input->post('title');
				$data["prev_photo_image"] = $this->input->post('prev_photo_image');
				$data["type"] = $this->input->post('type');
				$data["status"] = $this->input->post('status');
		}
		else {
			if($this->input->post('bar_gallery_id')=='')
			{
			    $this->user_model->bar_gallery_insert();			
				$data["msg"] = "success";	
			}
			else {
				$this->user_model->bar_gallery_update();			
				$data["msg"] = "success";
			}
			
			
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

   public function validate_image($image = NULL) {
   
	       // print_r($image);die;
	        $file_name      =   $image['name'];
	
	        $allowed_ext    =   array('gif', 'jpeg','jpg','png');
	        $ext                =   strtolower(end(explode('.', $file_name)));
	
	        $allowed_file_types =   array('image/jpeg', 'image/pjpeg','image/png',  'image/x-png','image/gif');
	        $file_type              =   $image['type'];
	
	        if(!in_array($ext, $allowed_ext) && !in_array($file_type, $allowed_file_types)) {
	            
	            return 'Image file type is not allowed.';
				
	            
	        }else{
	        	return '';
	        }
			        
	    }
    function removeImageAjax($id=0)
	{
		$oneImage=$this->user_model->getOneImageGallery($id);
		//print_r($oneImage);die;
		if($oneImage!='')
		{
			if($oneImage->bar_image_name!=''){
			if(file_exists(base_path().'upload/bar_gallery_orig/'.$oneImage->bar_image_name))
			{
				unlink(base_path().'upload/bar_gallery_orig/'.$oneImage->bar_image_name);
			}
			if(file_exists(base_path().'upload/bar_gallery_thumb/'.$oneImage->bar_image_name))
			{
				unlink(base_path().'upload/bar_gallery_thumb/'.$oneImage->bar_image_name);
			}
			if(file_exists(base_path().'upload/bar_gallery_thumb_big/'.$oneImage->bar_image_name))
			{
				unlink(base_path().'upload/bar_gallery_thumb_big/'.$oneImage->bar_image_name);
			}
			
			}
			$this->db->where('bar_image_id',$oneImage->bar_image_id)->delete('album_images');
		}
		
	}	
	
	function actiongallery()
	{
			$gal_id =$this->input->post('chk');
			foreach($gal_id as $id)
			{			
				$this->db->where('bar_gallery_id',$id)->delete('album');
				$this->db->where('bar_gallery_id',$id)->delete('album_images');
			}
		$res=array('status'=>'done');
		echo json_encode($res);die;
			
	}
	
	function bargallerydetail()
	{
		$getdata = $this->user_model->getOneGallery();
		print_r(json_encode($getdata)) ;
		die;
	}
	
	function bargalleryimages()
	{
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$data = array();
		$data['imageGallery'] = $this->user_model->getGalleryImages();
		
		//print_r(json_encode($getdata)) ;
		echo $this->load->view($theme.'/user/bar_gallery_images_ajax',$data);
		die;
	}

      function bargallerydelete()
	{
		$this->db->where('bar_gallery_id',$this->input->post('id'))->delete('album');
		$this->db->where('bar_gallery_id',$this->input->post('id'))->delete('album_images');
		
	}
	
	function profile($id='',$msg='')
	{
		

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
		$data['getalldata']=$this->user_model->get_one_user(base64_decode($id));
		$data['getsetting'] = $this->user_model->getsetting(base64_decode($id));
		
	
		if($data['getsetting'])
		{
			$data['getsetting'] = $data['getsetting'];
		}
		else {
			$data['getsetting'] = '';
		}
		if($data['getalldata']=='' || $data['getalldata']==0)
		{
			redirect('home');
		}
		
		
		if($data['getalldata']['user_type']=='bar_owner')
		{
			
			$get_bar_info = $this->user_model->getbarinfoByUserID(base64_decode($id));
			
			
			if($get_bar_info['bar_slug']!='')
			{
				
				redirect('bar/details/'.$get_bar_info['bar_slug']);
			}
			else {
				redirect('home');
			}
		}
		$data['albumgallery'] = $this->user_model->getalbumgallery(base64_decode($id));
        $data["bar_gallery_all"] = $this->user_model->getalbumgalleryAll(base64_decode($id));
		
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		//$this->template->write_view ('content_center', $theme.'/patient/myprofile_first', $data, TRUE);
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
       $this->template->write_view ('content_center', $theme.'/user/profile', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();
		
	}

	function getAllGalAjax()
	{
		$theme = getThemeName ();
		$data = array();
		$data["bar_gallery"] = $this->user_model->getBarGalleryAll123($this->input->post('id'));
		
			echo $this->load->view($theme .'/user/getajaxgal',$data,TRUE);die;
	}

    function settings($msg='')
	{
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		
		$this->load->library('form_validation');
		$data["msg"] = '';
		$data["error"] = '';
		
		$getsetting = $this->user_model->getsetting(get_authenticateUserID());
		
		if($getsetting)
		{
			$data['fname'] = $getsetting->fname;
			$data['setting_id'] = $getsetting->setting_id;
			$data['lname'] = $getsetting->lname;
			$data['email1'] = $getsetting->email1;
			$data['gender1'] = $getsetting->gender1;
			$data['address1'] = $getsetting->address1;
			$data['mnum'] = $getsetting->mnum;
			$data['abt'] = $getsetting->abt;
			$data['pic'] = $getsetting->pic;
			$data['album'] = $getsetting->album;
		}
else {
			$data['fname'] = '';
			$data['setting_id'] = '';
			$data['lname'] = '';
			$data['email1'] = '';
			$data['gender1'] = '';
			$data['address1'] = '';
			$data['mnum'] = '';
			$data['abt'] = '';
			$data['pic'] = '';
			$data['album'] ='';
}
		if($_POST){
			if($this->input->post('setting_id')=='' || $this->input->post('setting_id')==0)
			{
				$res= $this->user_model->insertusersetting();
			} 	
			else {
				$res = $this->user_model->updateusersetting();
			}	
				
			
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
			$response = array("status"=>"success",'id'=>$res);
			echo json_encode($response);
		    die;
		}
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/settings', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
	}

    function send_text_message()
	{
		// echo strlen("You are receiving a text message from (username) from the ADB network:");
		// die;
		$from = $this->config->item('number', 'twilio');
		$to = $this->input->post('number');
		$message= "You are receiving a text message from ".$this->input->post('name')." from the ADB network: ". substr($this->input->post('description_msg'),0,80);
		$response = $this->twilio->sms($from, $to, $message);
			$response = array("status"=>"success");
			echo json_encode($response);
		    die;
	}
	
	

	function getAllFavoriteBar()
	{
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
    	$data["bar_cocktail"] = $this->user_model->getAllFavoriteBar($_GET['user_id'],$_GET['offset'],$_GET['limit']);
		if($data["bar_cocktail"])
		{
		echo $this->load->view($theme .'/user/favoritebarajax',$data,TRUE);
		}
		elseif($_GET['offset']==0) {
			echo "No";
		}
		die;
	}

	function getAllFavoriteBeer()
	{
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
    	$data["bar_beer"] = $this->user_model->getAllFavoriteBeer($_GET['user_id'],$_GET['offset'],$_GET['limit']);
		if($data["bar_beer"])
		{
		echo $this->load->view($theme .'/user/favoritebeerajax',$data,TRUE);
		}
		elseif($_GET['offset']==0) {
			echo "No";
		}
		die;
	}

	function getAllFavoriteCocktail()
	{
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
    	$data["bar_cocktail"] = $this->user_model->getAllFavoriteCocktail($_GET['user_id'],$_GET['offset'],$_GET['limit']);
		if($data["bar_cocktail"])
		{
			echo $this->load->view($theme .'/user/favoritecocktailajax',$data,TRUE);
		}
elseif($_GET['offset']==0) {
			echo "No";
		}
		//echo $this->load->view($theme .'/user/favoritecocktailajax',$data,TRUE);
		die;
	}
	function getAllFavoriteLiquor()
	{
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
    	$data["bar_cocktail"] = $this->user_model->getAllFavoriteLiquor($_GET['user_id'],$_GET['offset'],$_GET['limit']);
		if($data["bar_cocktail"])
		{
		echo $this->load->view($theme .'/user/favoriteliquorajax',$data,TRUE);
		}
		elseif($_GET['offset']==0) {
			echo "No";
		}
		die;
	}
	function reorder()
	{
			$updateRecordsArray 	= $_POST['id'];
			$listingCounter = 1;
			foreach ($updateRecordsArray as $recordIDValue) {
				$query = "UPDATE ".$this->db->dbprefix('album')." SET reorder = " . $listingCounter . " WHERE bar_gallery_id = " . $recordIDValue;
				$this->db->query($query);
				//echo $this->db->last_query();
				$listingCounter = $listingCounter + 1;	
			}
	}
	
	
}
?>