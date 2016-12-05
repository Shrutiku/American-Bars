<?php
class Rights extends CI_Controller {
	function Rights()
	{
		parent::__construct();	
		$this->load->model('rights_model');
	}
	function assign_rights($id,$limit=0,$offset=0)
	{
		 if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		if($id=='')
		{
			redirect('admin/list_admin');
		}
		
			
			$data['admin_id']=$id;
			
			$data['offset']=$offset;
			$data['limit']=$limit;
		
			$data['assign_rights']=$this->rights_model->get_assign_rights($id);
			$data['rights']=$this->rights_model->get_rights();	
		
		
		    // echo "<pre>";
			// print_r($data['rights']);
			// die;
				
			$data['site_setting'] = site_setting();

			
			 $this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
	  		 $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			 $this->template->write_view('center',$theme .'/layout/rights/assign_rights',$data,TRUE);
       		$this->template->render();
		
	}
	
	function add_rights($id)
	{
		 if(!check_admin_authentication())
		{
			redirect('home');
		}
		
		$this->rights_model->add_rights();
		
		redirect('admin/list_admin/'.$this->input->post('limit').'/'.$this->input->post('offset').'/rights');
		//redirect('admin/list_admin');
	
	}
}
?>