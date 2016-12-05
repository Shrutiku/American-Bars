<?php
class Domain_bar extends  CI_Controller {
	function Domain_bar()
	{
		 parent::__construct();	
		$this->load->model('bar_model');
		
	}
	
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('domain_bar/list_domain_bar');
		
		
	}
	
	function list_domain_bar($msg="")
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('list_suggest_bar');

		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}

		$id = $this->input->post('user_id');

		$action = $this->input->post('action');

		if($id){

			$data = array();
			if($action == '1'){
				$this->db->query("update ".$this->db->dbprefix('user_master')." set date_shown = NOW(), is_agree_shown = 1 where user_id =" . $id);
			}
			else{
				$this->db->query("update ".$this->db->dbprefix('user_master')." set date_shown = NULL, is_agree_shown = 0 where user_id =" . $id);
			}

			$userdata = $this->db->query("select * from " . $this->db->dbprefix('user_master') . ' where user_id =' . $id);
			$userdata_row = $userdata->row();

			$data['date_shown'] = $userdata_row->date_shown;

			$data['status'] = 'success';
			echo json_encode($data);
			exit;
		}


		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'domain_bar/list_domain_bar/';
		$config['total_rows'] = $this->bar_model->get_total_domain_bar();

		$data['result'] = $this->bar_model->get_domain_bar_result();
		$data['msg'] = $msg;
		$data['error']='';


		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/bar/list_domain_bar',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}

}
?>