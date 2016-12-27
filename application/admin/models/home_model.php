<?php

class Home_model extends CI_Model 
{

	
	function Home_model()
    {
        parent::__construct();	
    } 
	/*
	 * function check login is used for check admin login if login credential are correct than set all session variables*/
	function check_login(){
	
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		$query = $this->db->get_where('admin',array('email'=>$username,'password'=>$password,'active'=>'Active'));
		
		if($query->num_rows() > 0)
		{
			$admin = $query->row_array();
			$admin_id = $admin['admin_id'];
			$admin_type = $admin['admin_type'];
			$data = array(
					'admin_id' => $admin_id,
					'username' => $username,
					'admin_type'=>$admin_type
					);	
				
			$this->session->set_userdata($data);
			
			
			$data1=array(
					'admin_id'=>$admin_id,
					'login_date'=> date('Y-m-d H:i:s'),
					'login_ip'=>$_SERVER['REMOTE_ADDR']
					); 
			$this->db->insert('admin_login',$data1);
			
			
			
			
			return "1";
		}
		else
		{
			return "0";
		}
	
	}
	
	
	/*Function : forgot_email for password recovery of admin 
	 * Future enhancement*/
	function forgot_email()
	{
		$email = $this->input->post('email');
		
		
		
		
			$query = $this->db->get_where('admin',array('email'=>$email));
			
			if($query->num_rows()>0)
			{
			
				$row = $query->row();
				
			
			if($row->active == "Active")
			{
				if($row->email != "")
				{
					
					$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Forgot Password Admin'");
					$email_temp=$email_template->row();
					
					
					
					$email_address_from=$email_temp->from_address;
					$email_address_reply=$email_temp->reply_address;
					
					$email_subject=$email_temp->subject;				
					$email_message=$email_temp->message;
					
					$username =$row->username;
					$password = $row->password;
					$email = $row->email;
					$email_to=$email;
					
					$login_link=base_url().'home/index';
					
					$email_message=str_replace('{break}','<br/><br/>',$email_message);
					$email_message=str_replace('{user_name}',$username,$email_message);
					$email_message=str_replace('{password}',$password,$email_message);
					$email_message=str_replace('{email}',$email,$email_message);
					$email_message=str_replace('{login_link}',$login_link,$email_message);
					
			   	$str=$email_message;
			
				
						/** custom_helper email function **/
				if($email_temp->status=='active'){	
				email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
				}		
					
				
					return '1';
					
				}
					else{
						
						return '0';
					}
				
				
				}
				else {
					
					return 2;
				}
     
				
			}	
			
			else
			{
				return 2;
			}
		
		
		
		
	}
	

 
}

?>