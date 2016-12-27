<?php
class Cron extends SPACULLUS_Controller {
	/*
	 Function name :User()
	 */
	function Cron() {
		parent :: __construct ();
	    $this->load->model('cron_model');
	}

	function getUserNoActivityTwoWeek()
	{
		
		$result = $this->cron_model->getUserNoActivity();
		
		if($result)
		{
			 foreach($result as $r)
			 {
			 	$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Reminder For Do Something In American Bar'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = $r->email;
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{username}', ucwords($r->first_name)." ".ucwords($r->last_name), $email_message);
				$str = $email_message;
			if($email_temp->status=='active'){
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
			}
			 }
		}
		
	}
	
	function getUserNoActivityTwoWeek_bar()
	{
		
		$result = $this->cron_model->getUserNoActivity_bar();
		$result1 = $this->cron_model->getUserNoActivity_bar_user();
		
		if($result)
		{
			 foreach($result as $r)
			 {
			 	$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Reminder For Favorite Bar'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = $r->email;
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{username}', ucwords($r->first_name)." ".ucwords($r->last_name), $email_message);
				$str = $email_message;
				if($email_temp->status=='active'){
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
				}
				
			 }
		}
		
		if($result1)
		{
			 foreach($result1 as $r)
			 {
			 	$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Reminder For Favorite Bar'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = $r->email;
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{username}', ucwords($r->first_name)." ".ucwords($r->last_name), $email_message);
				$str = $email_message;
				if($email_temp->status=='active'){
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
				}	
				
			 }
		}
		
	}
	
	function getUserNoActivityTwoWeek_cocktail()
	{
		
		$result = $this->cron_model->getUserNoActivity_cocktail();
		$result1 = $this->cron_model->getUserNoActivity_cocktail_user();
		if($result)
		{
			 foreach($result as $r)
			 {
			 	$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Reminder For Favorite Cocktail'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = $r->email;
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{username}', ucwords($r->first_name)." ".ucwords($r->last_name), $email_message);
				$str = $email_message;
				if($email_temp->status=='active'){
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
				}
				
			 }
		}
		
		if($result1)
		{
			 foreach($result1 as $r)
			 {
			 	$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Reminder For Favorite Cocktail'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = $r->email;
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{username}', ucwords($r->first_name)." ".ucwords($r->last_name), $email_message);
				$str = $email_message;
				if($email_temp->status=='active'){
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
				}
			 }
		}
		
	}
	
	function getUserNoActivityTwoWeek_liquor()
	{
		
		$result = $this->cron_model->getUserNoActivity_liquor();
		$result1 = $this->cron_model->getUserNoActivity_liquor_user();
		if($result)
		{
			 foreach($result as $r)
			 {
			 	$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Reminder For Favorite Liquor'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = $r->email;
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{username}', ucwords($r->first_name)." ".ucwords($r->last_name), $email_message);
				$str = $email_message;
				if($email_temp->status=='active'){
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
				}
			 }
		}
		
		if($result1)
		{
			 foreach($result1 as $r)
			 {
			 	$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Reminder For Favorite Liquor'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = $r->email;
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{username}', ucwords($r->first_name)." ".ucwords($r->last_name), $email_message);
				$str = $email_message;
				if($email_temp->status=='active'){
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
				}
			 }
		}
		
	}
	
	function getUserNoActivityTwoWeek_profile()
	{
		
		$result = $this->cron_model->getUserNoActivity_profile();
		if($result)
		{
			 foreach($result as $r)
			 {
			 	$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Reminder For Upload User Image'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = $r->email;
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{username}', ucwords($r->first_name)." ".ucwords($r->last_name), $email_message);
				$str = $email_message;
				//echo $str;
				if($email_temp->status=='active'){
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
				}
			 }
		}
		
	}
	
	function getHalfMugUser()
	{
		$result = $this->cron_model->getHalfMugUser_profile();
		
		
		$getfull = gethalmugfeature('fullmug');
						$getrecord = '';
						 $i=1;foreach($getfull as $sct)    
				       {
				        	
							$getrecord .=  $i.") ".ucwords($sct->fullmug)."<br>";
						$i++;}
		if($result)
		{
			 foreach($result as $r)
			 {
			 	$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Reminder For Upgrade Profile'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = $r->email;
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{username}', ucwords($r->first_name)." ".ucwords($r->last_name), $email_message);
				$email_message = str_replace('{featurelist}', $getrecord, $email_message);
			    $str = $email_message;
				if($email_temp->status=='active'){
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
				}
			 }
		}
	}

	function getHalfMugUser_barlogo_missing()
	{
		$result = $this->cron_model->getHalfMugUser_profile_logo();
		
	
		if($result)
		{
			 foreach($result as $r)
			 {
			 	$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Reminder For Update Barlogo'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = $r->email;
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{username}', ucwords($r->first_name)." ".ucwords($r->last_name), $email_message);
				$email_message = str_replace('{barname}', ucwords($r->bar_title), $email_message);
				$email_subject = str_replace('{barname}', ucwords($r->bar_title), $email_subject);
			    $str = $email_message;
				if($email_temp->status=='active'){
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
				}
			 }
		}
	}

	function getHalfMugUser_Beer()
	{
		$result = $this->cron_model->getHalfMugUser_profile_beer();
		
	
		if($result)
		{
			 foreach($result as $r)
			 {
			 	if($r->beer_bar_id=='')
			 	{
			 	$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Reminder For Add Beers'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = $r->email;
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{username}', ucwords($r->first_name)." ".ucwords($r->last_name), $email_message);
				$email_message = str_replace('{barname}', ucwords($r->bar_title), $email_message);
				$email_subject = str_replace('{barname}', ucwords($r->bar_title), $email_subject);
			    $str = $email_message;
				if($email_temp->status=='active'){
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
				}	
				}
				
			 }
		}
	}
	
	function getHalfMugUser_Liquor()
	{
		$result = $this->cron_model->getHalfMugUser_profile_liquor();
		
	
		if($result)
		{
			 foreach($result as $r)
			 {
			 	if($r->liquor_bar_id=='')
			 	{
			 	$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Reminder For Add Liquor'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = $r->email;
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{username}', ucwords($r->first_name)." ".ucwords($r->last_name), $email_message);
				$email_message = str_replace('{barname}', ucwords($r->bar_title), $email_message);
				$email_subject = str_replace('{barname}', ucwords($r->bar_title), $email_subject);
			    $str = $email_message;
				if($email_temp->status=='active'){
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
				}	
					
				}
				
			 }
		}
	}

function getHalfMugUser_Event()
	{
		$result = $this->cron_model->getHalfMugUser_profile_event();
		
	
		if($result)
		{
			 foreach($result as $r)
			 {
			 	if($r->b_id=='')
			 	{
			 	$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Reminder For Add Event'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = $r->email;
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{username}', ucwords($r->first_name)." ".ucwords($r->last_name), $email_message);
				$email_message = str_replace('{barname}', ucwords($r->bar_title), $email_message);
				$email_subject = str_replace('{barname}', ucwords($r->bar_title), $email_subject);
			    $str = $email_message;
				if($email_temp->status=='active'){
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
				}	
					
				}
				
			 }
		}
	}

	function getFullMugUser_barlogo_missing()
	{
		$result = $this->cron_model->getFullMugUser_profile_logo();
		
	
		if($result)
		{
			 foreach($result as $r)
			 {
			 	$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Reminder For Update Barlogo'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = $r->email;
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{username}', ucwords($r->first_name)." ".ucwords($r->last_name), $email_message);
				$email_message = str_replace('{barname}', ucwords($r->bar_title), $email_message);
				$email_subject = str_replace('{barname}', ucwords($r->bar_title), $email_subject);
			    $str = $email_message;
				if($email_temp->status=='active'){
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
				}
			 }
		}
	}

function getUser_profile_missing()
	{
		$result = $this->cron_model->getUser_profile_logo();
		
	
		if($result)
		{
			 foreach($result as $r)
			 {
			 	$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Reminder For Upload User Image'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = $r->email;
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{username}', ucwords($r->first_name)." ".ucwords($r->last_name), $email_message);$str = $email_message;
				//echo $str;
				if($email_temp->status=='active'){
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
				}
				
			 }
		}
	}
	
	function getattendeventuser_one_day()
	{
		$result = $this->cron_model->getUser_profile_event();
		
		
	
		if($result)
		{
			 foreach($result as $r)
			 {
			 	$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Reminder For Attend Event Notification'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = $r->email;
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_subject = str_replace('{eventname}', ucwords($r->event_title), $email_subject);
				$email_message = str_replace('{eventname}', ucwords($r->event_title), $email_message);
				$email_message = str_replace('{date}', $r->start_date." to ".$r->end_date, $email_message);
				$email_message = str_replace('{address}', ucfirst($r->address).", ".ucfirst($r->city)." ".ucfirst($r->zipcode), $email_message);
				$email_message = str_replace('{username}', ucwords($r->first_name)." ".ucwords($r->last_name), $email_message);
				
				$str = $email_message;
				//echo $str;
				if($email_temp->status=='active'){
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
				}
			 }
		}
	}

    function getAllEvent()
	{
		$result = $this->cron_model->getAllevent();
		//print_r($result);
		if($result)
		{
			foreach($result as $r)
			{
				 $data_update = array('status'=>'inactive');
				$this->db->where('event_id',$r->event_id);
				$this->db->update('events',$data_update);
			}
		}
		
		
		 
	}
}
?>