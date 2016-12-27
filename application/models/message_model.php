<?php
class Message_model extends CI_Model 
{
	function Message_model()
    {
        parent::__construct();	
    } 	
	
	function getBarMessagescount()
	{
		
		$query = $this->db->query("select * from sss_message_user where master_message_id=0 && (to_user_id=".get_authenticateUserID()." or  from_user_id=".get_authenticateUserID().") ");
		//$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	function get_message_result($offset, $limit){
		
       
        $query = $this->db->query("select * from sss_message_user where master_message_id=0 && (to_user_id=".get_authenticateUserID()." or  from_user_id=".get_authenticateUserID().") ORDER BY message_id desc  limit ".$limit." offset ".$offset." ");
		
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		return 0;
	}
	function get_one_message($id=0) {
		
		$query = $this->db->get_where('message_user',array('message_id'=>$id));
		
		return $query->row_array();
	
	}

	 function get_message_conversation($id)
	{
		$this->db->select('message_user.*');
		$this->db->from('message_user');
		$this->db->where('master_message_id ',$id);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		return 0;
		
	}
	
	function message_send($bar_id) {
			$data = array(
				'to_user_id' => $this->input->post('to_user_id1'),
		     	'from_user_id' =>  get_authenticateUserID(),
				'from_user_type'=>'sender',
				'to_user_type'=>'reciever',
				'subject' => $this->input->post('subject'),
				'description' => $this->input->post('description'),
				'date_added'=>date('Y-m-d H:i:s')
			);
			
			
			$this->db->insert('message_user',$data);
	}
	function get_user_list($q){
		$this->db->like('first_name',$q);
		$this->db->select('user_id,first_name,last_name,user_type');
		$this->db->from('user_master');
		$this->db->where('status','active');
		$query = $this->db->get();
		
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
		return 0;
	}		
}	
?>