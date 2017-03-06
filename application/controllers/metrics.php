<?php

require(APPPATH.'/libraries/REST_Controller.php');

class Metrics extends REST_Controller {

	/*
	 Function name :Home()
	 Description :Its Default Constuctor which called when home object initialzie.its load necesary models
	 */

	function Metrics () {
		
		
		
		parent :: __construct ();
		$this->load->library ("PasswordHash");
		$this->load->library ("encrypt");
		$this->load->model ('home_model');
	
	}

	public function get_get() {
                $this->load->model('bar_model');
                $this->load->model('user_model');

                $data['hulfmug_bars'] = $this->bar_model->get_total_bar_count_by_type("half_mug_claimed_bar");
                $data['fullmug_bars'] = $this->bar_model->get_total_bar_count_by_type("full_mug");
                $data['enthusiasts'] = $this->user_model->get_total_user_count("user", "active");
		
                $this->response($data ,200);
	}
}
?>