<?php
class Happy_hours extends  CI_Controller {
	function Happy_hours()
	{
		parent::__construct();	
		$this->load->model('happy_hours_model');	
	   $this->load->library('pagination');
	}
	
	/*add new event also called in event update
	 * param  : limit
	 * 
	 */
	
	
}
?>