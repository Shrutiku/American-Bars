<?php
class Image_setting_model extends CI_Model {
	
    function Image_setting_model()
    {
        parent::__construct();	
    }   
	
	// Use :This function use for Update image setting.
	// Param :Post Date
	// Return :'N/A'
	function image_setting_update()
	{
				
		
		$data = array(	
			'user_width'=> $this->input->post('user_width'),
			'user_height'=>$this->input->post('user_height'),
			'image_width'=> $this->input->post('image_width'),
			'image_height'=> $this->input->post('image_height'),
			
		);
		
		$this->db->where('image_setting_id',$this->input->post('image_setting_id'));
		$this->db->update('image_setting',$data);
	
          /// Log entry
           $data_log = array("activity_name" => "LOG_UPDATE_IMAGE_SETTING");
           maintain_log($data_log);
	}
	
	

}
?>