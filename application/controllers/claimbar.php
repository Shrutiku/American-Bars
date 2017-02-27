<?php
class Claimbar extends SPACULLUS_Controller {

	/*
	 Function name :Home()
	 Description :Its Default Constuctor which called when home object initialzie.its load necesary models
	 */

	function Claimbar () {
		
		
		
		parent :: __construct ();
		$this->load->library ("PasswordHash");
		$this->load->library ("encrypt");
		$this->load->model ('home_model');
	
	}

	public function index () {
            
                $data['error'] = '';
                $data["active_menu"]='';
                $data['site_setting'] = site_setting ();
		
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
                
                $page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);    
               
                $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/home/claimbar', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render();
	}
}
?>