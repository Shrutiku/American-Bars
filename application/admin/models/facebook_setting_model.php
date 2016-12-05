<?php

class Facebook_setting_model extends CI_Model {
	
    function Facebook_setting_model()
    {
       parent::__construct();	
    }   
	
	/** admin facebook setting update function
	* var integer $facebook_application_id
	* var integer $facebook_login_enable
	* var string $facebook_api_key
	* var string $facebook_secret_key	
	* var string $facebook_url	
	**/
	function facebook_setting_update()
	{
		$data = array(			
			'facebook_application_id' => $this->input->post('facebook_application_id'),
			'facebook_login_enable' => $this->input->post('facebook_login_enable'),
			'facebook_api_key' => $this->input->post('facebook_api_key'),
			'facebook_secret_key' => $this->input->post('facebook_secret_key'),
			'facebook_url' => $this->input->post('facebook_url'),
		);
		$this->db->where('facebook_setting_id',$this->input->post('facebook_setting_id'));
		$this->db->update('facebook_setting',$data);
	}
	
	/*** get facebook setting details
	*  return single record array
	**/
	function get_one_facebook_setting()
	{
		$query = $this->db->get_where('facebook_setting');
		return $query->row();
	}
}
?>