<?php
 date_default_timezone_set("Europe/London");
class Feature extends CI_Controller {

	function Feature() {
		parent::__construct();
		$this -> load -> model('site_setting_model');
	}

	/** admin site setting display and update function
	 * var integer $site_setting_id
	 * var integer $site_online
	 * var integer $captcha_enable
	 * var string $site_name
	 * var integer $site_version
	 * var integer $site_language
	 * var string $currency_code
	 * var string $date_format
	 * var string $time_format
	 * var string $date_time_format
	 * var string $site_tracker
	 * var text $how_it_works_video
	 * var integer $zipcode_min
	 * var integer $zipcode_max
	 * var string $error
	 **/
	 function index() {
	 	 redirect('feature/add_feature');
	 }
	 
	function add_feature($msg='') {
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('add_site_setting');
 		
		 if(	$check_rights==0) {			
			 redirect('home/dashboard/no_rights');	
		 }
		$data = array();
		$theme = getThemeName();
		$this -> template -> set_master_template($theme . '/template.php');

		$this -> load -> library('form_validation');
       
        $this->form_validation->set_rules('ss', 'ss', 'required');
		$data['page_name']="feature";
		$data["msg"] = $msg;
		$data["error"] = '';
		if ($this -> form_validation -> run() == FALSE) {
			if (validation_errors()) {
				$data["error"] = validation_errors();
			} else {
				$data["error"] = "";
			}
			if ($this -> input -> post('site_setting_id')) {
				$data['imageGallery']=$this->site_setting_model->getfeature();
				$data['imageGallery1']=$this->site_setting_model->getfeature1();
				$data['imageGallery2']=$this->site_setting_model->getfeature2();
				
		
			} else {
				$data['imageGallery']=$this->site_setting_model->getfeature();
				$data['imageGallery1']=$this->site_setting_model->getfeature1();
				$data['imageGallery2']=$this->site_setting_model->getfeature2();
				
			}
			
			$data['site_setting'] = site_setting();
			$this ->template->write_view('header_menu', $theme . '/layout/common/header', $data, TRUE);
			$this->template-> write_view('center', $theme . '/layout/setting/add_feature', $data, TRUE);
			$this->template->write_view('left', $theme . '/layout/common/sidebar', $data, TRUE);
			$this -> template -> write_view('footer', $theme . '/layout/common/footer', $data, TRUE);
			$this -> template -> render();
		} else {
			
			$this -> site_setting_model -> feature_update();
			$data['imageGallery']=$this->site_setting_model->getfeature();
			$data['imageGallery1']=$this->site_setting_model->getfeature1();
			$data['page_name']="usercls";
			$this -> template -> write_view('header_menu', $theme . '/layout/common/header', $data, TRUE);
			$this -> template -> write_view('left', $theme . '/layout/common/sidebar', $data, TRUE);
			$this -> template -> write_view('center', $theme . '/layout/setting/add_feature', $data, TRUE);
			$this -> template -> write_view('footer', $theme . '/layout/common/footer', $data, TRUE);

			$this -> template -> render();
		}
	}

	function removefeature($id='')
	{
		 $this->db->delete('feature', array('feature_id' => $id)); 
		 echo $this->db->last_query();
		 die;
	}
	

}
?>