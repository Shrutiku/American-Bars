<?php

class Site_setting_model extends CI_Model {
	
    function Site_setting_model()
    {
        parent::__construct();	
    }   
	
	function feature_update()
	{
			$this->db->empty_table('feature'); 
			
		
		$datatick['halfmug']=$this->input->post('halfmug');
		$datatick['fullmug']=$this->input->post('fullmug');
		$datatick['managedmug']=$this->input->post('managedmug');
		
		
		 if( isset( $datatick['halfmug'] ) && is_array( $datatick['halfmug'] ) ){
		 	
			foreach( $datatick['halfmug'] as $key => $each ){
				
			
				$dataticket=array(
				'halfmug' => $datatick['halfmug'][$key],
			);
			
			
		
			$this->db->insert('feature',$dataticket);
			}
		 }
		 
		  if( isset( $datatick['fullmug'] ) && is_array( $datatick['fullmug'] ) ){
		 	
			foreach( $datatick['fullmug'] as $key => $each ){
				
			
				$dataticket=array(
				'fullmug' => $datatick['fullmug'][$key],
			);
			
			
		
			$this->db->insert('feature',$dataticket);
			}
		 }
		  
		    if( isset( $datatick['managedmug'] ) && is_array( $datatick['managedmug'] ) ){
		 	
			foreach( $datatick['managedmug'] as $key => $each ){
				
			
				$dataticket=array(
				'managedmug' => $datatick['managedmug'][$key],
			);
			
			
		
			$this->db->insert('feature',$dataticket);
			}
		 }
		  redirect('feature/add_feature/update');
	}

function site_setting_update_new()
	{
		
		$data = array(	
			'fullmug_user_guide'=> $this->input->post('fullmug_user_guide'),
			'halfmug_user_guide'=> $this->input->post('halfmug_user_guide'),
			'enthusiast_user_guide'=> $this->input->post('enthusiast_user_guide'),
		);
		
		
		$this->db->where('site_setting_id',$this->input->post('site_setting_id'));
		$this->db->update('site_setting',$data);
		
		
	}
	function site_setting_update()
	{
		
		$data = array(	
			'site_online' => $this->input->post('site_online'),
		    'site_version'=> $this->input->post('site_version'),	
			'site_name' => $this->input->post('site_name'),	
			'site_address' => $this->input->post('site_address'),	
			'currency_symbol' => $this->input->post('currency_symbol'),
			'currency_code' => $this->input->post('currency_code'),
			'email_conversation' => $this->input->post('email_conversation'),
			'date_format' => $this->input->post('date_format'),	
			'time_format' => $this->input->post('time_format'),
			'date_time_format' => $this->input->post('date_time_format'),
			'site_email'=> $this->input->post('site_email'),
			'default_longitude'=>trim($this->input->post('default_longitude')),
			'default_latitude'=>trim($this->input->post('default_latitude')),
			'google_map_key'=>trim($this->input->post('google_map_key')),
			'poker_coach_price'=> $this->input->post('poker_coach_price'),
			'amount'=> $this->input->post('amount'),
			'managed_account_amount'=> $this->input->post('managed_account_amount'),
			'fullmug_user_guide'=> $this->input->post('fullmug_user_guide'),
			'halfmug_user_guide'=> $this->input->post('halfmug_user_guide'),
			'enthusiast_user_guide'=> $this->input->post('enthusiast_user_guide'),
			'how_it_works_video'=> trim($this -> input -> post('how_it_works_video')),
		
			
		);
		
		
		$this->db->where('site_setting_id',$this->input->post('site_setting_id'));
		$this->db->update('site_setting',$data);
		
		/// Log entry
           $data_log = array("activity_name" => "LOG_UPDATE_SITE_SETTING");
           maintain_log($data_log);
		
		
		$supported_cache=check_supported_cache_driver();
		
		if(isset($supported_cache))
		{
			if($supported_cache!='' && $supported_cache!='none')
			{
				////===load cache driver===
				$this->load->driver('cache');				
				
				$query = $this->db->get("site_setting");					
				$this->cache->$supported_cache->save('site_setting', $query->row(),CACHE_VALID_SEC);		
				
			}			
			
		}
	}

function site_twilio_update()
	{
		
		$data = array(	
			'mode' => $this->input->post('mode'),
		    'account_sid'=> $this->input->post('account_sid'),	
			'auth_token' => $this->input->post('auth_token'),	
			'api_version' => $this->input->post('api_version'),
			'number' => $this->input->post('number'),
		);
		
		$this->db->where('twilio_id',$this->input->post('twilio_id'));
		$this->db->update('twilio_setting',$data);
		
	}

	
	function site_google_update()
	{
		
		$data = array(	
			'google_client_id' => $this->input->post('google_client_id'),
		    'google_url'=> $this->input->post('google_url'),	
			'google_login_enable' => $this->input->post('google_login_enable'),	
			'google_client_secret' => $this->input->post('google_client_secret'),
		);
		//print_r($data); die;
		$this->db->where('google_setting_id',$this->input->post('google_setting_id'));
		$this->db->update('google_setting',$data);
	
	}
	
	
	function site_facebook_update()
	{
		
		$data = array(	
			'facebook_setting_id' => $this->input->post('facebook_setting_id'),
		    'facebook_application_id'=> $this->input->post('facebook_application_id'),	
			'facebook_login_enable' => $this->input->post('facebook_login_enable'),	
			'facebook_access_token' => $this->input->post('facebook_access_token'),
			'facebook_api_key' => $this->input->post('facebook_api_key'),
		    'facebook_secret_key'=> $this->input->post('facebook_secret_key'),	
			'facebook_user_autopost' => $this->input->post('facebook_user_autopost'),	
			'facebook_wall_post' => $this->input->post('facebook_wall_post'),
			'facebook_url' => $this->input->post('facebook_url'),
		
		);
		//print_r($data); die;
		$this->db->where('facebook_setting_id',$this->input->post('facebook_setting_id'));
		$this->db->update('facebook_setting',$data);
	
	}
	
	function site_paypal_update()
	{
		
		$data = array(	
			'id' => $this->input->post('id'),
		    'site_status'=> $this->input->post('site_status'),
		    'vendor'=> $this->input->post('vendor'),	
		    'partner_name'=> $this->input->post('partner_name'),	
			'paypal_password' => $this->input->post('paypal_password'),
			'paypal_username' => $this->input->post('paypal_username'),	
		);
		//print_r($data); die;
		$this->db->where('id',$this->input->post('id'));
		$this->db->update('paypal',$data);
	
	}
	
	function site_yahoo_update()
	{
		
		$data = array(	
			'yahoo_setting_id' => $this->input->post('yahoo_setting_id'),
		    'app_id'=> $this->input->post('app_id'),
		    'consumer_key'=> $this->input->post('consumer_key'),	
			'consumer_secret' => $this->input->post('consumer_secret'),
			'email_id' => $this->input->post('email_id'),
			'password' => $this->input->post('password'),	
		);
		//print_r($data); die;
		$this->db->where('yahoo_setting_id',$this->input->post('yahoo_setting_id'));
		$this->db->update('yahoo_setting',$data);
	
	}
	
	function getfeature()
	{
		$this->db->select('*');
		$this->db->from('feature');
		$this->db->where('halfmug !=','');
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->result();
		} 
		return '';
	}
	
		function getfeature1()
	{
		$this->db->select('*');
		$this->db->from('feature');
		$this->db->where('fullmug !=','');
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->result();
		} 
		return '';
	}
	
		function getfeature2()
	{
		$this->db->select('*');
		$this->db->from('feature');
		$this->db->where('managedmug !=','');
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->result();
		} 
		return '';
	}
}
?>