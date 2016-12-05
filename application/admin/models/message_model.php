<?php

class message_model extends CI_Model {
	
    function message_model()
    {
        parent::__construct();	
    }   
	
	// Use :This function use for add new message.
	// Param :Post Data
	// Return :'N/A'
	function message_insert() {
	
	//print_r($this->input->post('to_user_id'));
		$to_id_arr = explode(',', $this->input->post('to_user_id') );
		
		
	    
		
		for($i=0;$i<count($to_id_arr); $i++){
			
		//	$id = $this->get_id_by_email($to_id_arr[$i],$this->input->post('to_user_type'));
		 $r = explode('#', $this->input->post('to_user_id') );
		 
		   $ap = $this->input->post('to_user_id');
		   
			$id = $this->get_id_by_email($r[0],$r[1]);
			
		///'description' =>  stripslashes(str_replace('\r\n', '', mysql_real_escape_string(htmlentities($this->input->post('description'))))),
			$data = array(
				'subject' => $this->input->post('subject'),
		     	'description' =>  $this->input->post('description'),
				'from_user_id' => $this->input->post('from_user_id'),
				'from_user_type' => $this->input->post('from_user_type'),
				'to_user_id' => $id,
				'to_user_type' =>'user',
				'is_read' => '0',
				'master_message_id	' => '0',
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				'is_deleted' => '0',
				'date_added' => date("Y-m-d H:i:s")
			);
			$this->db->insert('message',$data);
		}
		
         
          //Log Entry    
            $data_log = array("activity_name" => "LOG_INSERT_MESSAGE");
            maintain_log($data_log); 
	}

// Use :This function use for add new message.
	// Param :Post Data
	// Return :'N/A'
	function push_message_insert()
	{
		
	
	
		$rand = rand('11111111','99999999');
	
		
		$to_id_arr 	 = $this->getAllUser_Device('user');
	    $to_id_android =  $this->getAllUser_Device_android('user');
		
		if($to_id_android){
		foreach($to_id_android as $row){
			sendPushNotificationAndroid($row->gcm_regid,array("type"=>"American Bars","subject"=>"American Bars","message"=>$this->input->post('description')));
		}	
		}
		if($to_id_arr){
		foreach($to_id_arr as $row){
			
		//	$id = $this->get_id_by_email($to_id_arr[$i],$this->input->post('to_user_type'));
		   
			
		///'description' =>  stripslashes(str_replace('\r\n', '', mysql_real_escape_string(htmlentities($this->input->post('description'))))),
			$data = array(
		     	'description' =>  $this->input->post('description'),
				'to_user_id' => $row->user_id,
				'number' => $rand,
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				'date_added' => date("Y-m-d H:i:s")
			);
			$this->db->insert('push_message',$data);
			sendPushNotificationiPhone($row->device_id,array("type"=>"American Bars","subject"=>"American Bars","message"=>$this->input->post('description')));
		}	
		}

		
		
         
          //Log Entry    
            $data_log = array("activity_name" => "LOG_INSERT_MESSAGE");
            maintain_log($data_log); 
	}
	
	function getAllUser_Device()
	{
		$qry = $this->db->query("select * from sss_registered_iphone");		
		if ($qry->num_rows() > 0) {
			return $qry->result();
		}
		return '';
	}
	
	function getAllUser_Device_android()
	{
		$qry = $this->db->query("select * from sss_registered_android");		
		if ($qry->num_rows() > 0) {
			return $qry->result();
		}
		return '';
	}
	function broadcast_message_insert() {
	
	
	$rand = rand('11111111','99999999');
	
		$to_id_arr = $this->input->post('to_user_id');
		
		
	    
		
		foreach($to_id_arr as $row){
			
		//	$id = $this->get_id_by_email($to_id_arr[$i],$this->input->post('to_user_type'));
		 $r = explode('#', $row);
		 
		   $ap = $row;
		   
			$id = $this->get_id_by_email($r[0],$r[1]);
			
		///'description' =>  stripslashes(str_replace('\r\n', '', mysql_real_escape_string(htmlentities($this->input->post('description'))))),
			$data = array(
				'subject' => $this->input->post('subject'),
		     	'description' =>  $this->input->post('description'),
				'from_user_id' => $this->input->post('from_user_id'),
				'from_user_type' => $this->input->post('from_user_type'),
				'to_user_id' => $id,
				'number' => $rand,
				'to_user_type' =>'user',
				'master_message_id	' => '0',
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				'is_deleted' => '0',
				'date_added' => date("Y-m-d H:i:s")
			);
			$this->db->insert('broadcast_message',$data);
			
			$getuser = get_user_info($id);
			$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Notification From AB'");
		$email_temp = $email_template->row();

		$email_address_from = $email_temp->from_address;
		$email_address_reply = $email_temp->reply_address;

		$email_subject = ucwords($this->input->post('subject'));
		$email_message = $email_temp->message;

		$email = $r[0];

		$user_name = $getuser->first_name." ".$getuser->last_name;
		$email_to = $email;

		$email_message = str_replace('{break}', '<br/>', $email_message);
		$email_message = str_replace('{user}', $user_name, $email_message);
		$email_message = str_replace('{subject}', $this->input->post('subject'), $email_message);
		$email_message = str_replace('{description}', $this->input->post('description'), $email_message);
		
	    $str = $email_message;
		
		
	
		/** custom_helper email function **/
		if($email_temp->status=='active'){
		email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
		}	
		}
		
         
          //Log Entry    
            $data_log = array("activity_name" => "LOG_INSERT_MESSAGE");
            maintain_log($data_log); 
	}
	
	function reply_insert(){	
		
		$data = array(
			'subject' => $this->input->post('subject'),
			'description' =>  $this->input->post('description'),
			'from_user_id' => $this->input->post('from_user_id'),
			'from_user_type' => $this->input->post('from_user_type'),
			'to_user_id' => $this->input->post('to_user_id'),
			'to_user_type' => $this->input->post('to_user_type'),
			'is_read' => '0',
			'master_message_id	' => $this->input->post('message_id'),
			'ip_address' => $_SERVER['REMOTE_ADDR'],
			'is_deleted' => '0',
			'date_added' => date("Y-m-d H:i:s")
		);		
		
		$this->db->insert('message',$data);
        
           //Log Entry    
            $data_log = array("activity_name" => "LOG_REPLY_MESSAGE");
            maintain_log($data_log); 
		
	}



	// Use :This function use for check message .
	// Param :message
	// Return :Boolean
	function message_unique($str) {
		if($this->input->post('message_id'))
		{
			$query = $this->db->get_where('message',array('message_id'=>$this->input->post('message_id')));
			$res = $query->row_array();
			$message_name = $res['message_Name'];
			
			$query = $this->db->query("select message_Name from ".$this->db->dbprefix('message')." where message_Name= '$str' and message_id!='".$this->input->post('message_id')."'");
		}else{
		
			$query = $this->db->query("select message_Name from ".$this->db->dbprefix('message')." where message_Name = '$str'");
		}
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
		
	}
	
	
	// Use :This function use for Update message Detail.
	// Param :Post Data
	// Return :'N/A'
	
	function message_update(){
		$data = array(
			'subject' => $this->input->post('subject'),
			'description' => mysql_real_escape_string(strip_tags($this->input->post('description'))),
			'from_user_id' => $this->input->post('from_user_id'),
			'from_user_type' => $this->input->post('from_user_type'),
			'to_user_id' => $this->input->post('to_user_id'),
			'to_user_type' => $this->input->post('to_user_type'),
			'is_read' => $this->input->post('is_read'),
			'master_message_id	' => $this->input->post('master_message_id	'),
			'ip_address' => $_SERVER['REMOTE_ADDR'],
			'is_deleted' => '0',
			'updated_on' => date("Y-m-d H:i:s")
		);
			
		$this->db->where('message_id',$this->input->post('message_id'));
		$this->db->update('message',$data);
        
         //Log Entry    
            $data_log = array("activity_name" => "LOG_UPDATE_MESSAGE");
            maintain_log($data_log); 
		
	}
	// Use :This function use for Update message Detail.
	// Param :Post Data
	// Return :'N/A'
	
	function broadcast_message_update(){
		$data = array(
			'subject' => $this->input->post('subject'),
			'description' => mysql_real_escape_string(strip_tags($this->input->post('description'))),
			'from_user_id' => $this->input->post('from_user_id'),
			'from_user_type' => $this->input->post('from_user_type'),
			'to_user_id' => $this->input->post('to_user_id'),
			'to_user_type' => $this->input->post('to_user_type'),
			'master_message_id	' => $this->input->post('master_message_id	'),
			'ip_address' => $_SERVER['REMOTE_ADDR'],
			'is_deleted' => '0',
			'updated_on' => date("Y-m-d H:i:s")
		);
			
		$this->db->where('message_id',$this->input->post('message_id'));
		$this->db->update('broadcast_message',$data);
        
         //Log Entry    
            $data_log = array("activity_name" => "LOG_UPDATE_MESSAGE");
            maintain_log($data_log); 
		
	}
	
	// Use :This function use for get one message detail.
	// Param :message Id
	// Return :array
	function get_one_message($id=0) {
		
		$query = $this->db->get_where('message',array('message_id'=>$id));
		
	
		return $query->row_array();
	
	}
	function get_one_broadcast_message($id=0) {
		
		$query = $this->db->get_where('broadcast_message',array('message_id'=>$id));
		
	
		return $query->row_array();
	
	}
	
	function get_one_message_master($id)
		
	 {  
	
		$qry = $this->db->get_where('message',array('message_id'=>$id));
	  
	   if($qry->num_rows()>0)
		{
			
			return '123';
	
		 
		}
	   else
	   	{
		
		return 'dd' ;
		}
	}
	
	
	// Use :This function use for count all message.
	// Param :'N/A'
	// Return :Number
	function get_total_message_count(){
		/*$this->db->select('*');
		$this->db->from('message');
		$query = $this->db->get();
		return $query->num_rows();*/
		
		$aid = get_authenticateadminID();		
		$qry = $this->db->query("select * from (select m.* from sss_message m where  1=1 and is_deleted='0' and master_message_id=0 order by message_id desc) as x");
		
		return $qry->num_rows();
	}
	
	
	// Use :This function use for count all message.
	// Param :'N/A'
	// Return :Number
	function get_total_broadcast_message_count(){
		/*$this->db->select('*');
		$this->db->from('message');
		$query = $this->db->get();
		return $query->num_rows();*/
		
		$aid = get_authenticateadminID();		
		$qry = $this->db->query("select * from (select m.* from sss_broadcast_message m where   1=1 and is_deleted='0' and master_message_id=0  group by number order by message_id desc ) as x");
		
		return $qry->num_rows();
	}
	
	function get_total_push_message_count(){
		/*$this->db->select('*');
		$this->db->from('message');
		$query = $this->db->get();
		return $query->num_rows();*/
		
		$aid = get_authenticateadminID();		
		$qry = $this->db->query("select * from sss_push_message  group by number order by message_id desc");
		
		return $qry->num_rows();
	}
	
	// Use :This function use for count all message.
	// Param :'N/A'
	// Return :Number
	function get_total_broadcast_message_count_rec(){
		/*$this->db->select('*');
		$this->db->from('message');
		$query = $this->db->get();
		return $query->num_rows();*/
		
		$aid = get_authenticateadminID();		
		$qry = $this->db->query("select * from (select m.* from sss_broadcast_message m where   1=1 and is_deleted='0' and master_message_id=0   order by message_id desc ) as x");
		
		return $qry->num_rows();
	}
	
	// Use :This function use for get message detail by limit and offset.
	// Param :offset,limit
	// Return :array of object	
	
	function get_message_result($offset, $limit){
	/*	$this->db->select('*');
		$this->db->from('message');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();*/
		$aid = get_authenticateadminID();		
		//$qry = $this->db->query("select * from (select m.* from sss_message m where  1=1 and to_user_type= 'admin' and is_deleted='0' order by message_id desc) as x group by master_message_id	 limit ".$limit."  offset ".$offset."");
		$qry = $this->db->query("select * from (select m.* from sss_message m where  1=1  and is_deleted='0' and master_message_id=0 order by message_id desc) as x  limit ".$limit."  offset ".$offset."");		
		if ($qry->num_rows() > 0) {
			return $qry->result();
		}
		return '';
	}
	
	// Use :This function use for get message detail by limit and offset.
	// Param :offset,limit
	// Return :array of object	
	
	function get_broadcast_message_result($offset, $limit){
	/*	$this->db->select('*');
		$this->db->from('message');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();*/
		$aid = get_authenticateadminID();		
		//$qry = $this->db->query("select * from (select m.* from sss_message m where  1=1 and to_user_type= 'admin' and is_deleted='0' order by message_id desc) as x group by master_message_id	 limit ".$limit."  offset ".$offset."");
		$qry = $this->db->query("select * from (select m.* from sss_broadcast_message m where  1=1  and is_deleted='0' and master_message_id=0  group by number order by message_id  desc ) as x  limit ".$limit."  offset ".$offset."");		
		if ($qry->num_rows() > 0) {
			return $qry->result();
		}
		return '';
	}
	
	function get_push_message_result($offset, $limit){
	/*	$this->db->select('*');
		$this->db->from('message');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();*/
		$aid = get_authenticateadminID();		
		//$qry = $this->db->query("select * from (select m.* from sss_message m where  1=1 and to_user_type= 'admin' and is_deleted='0' order by message_id desc) as x group by master_message_id	 limit ".$limit."  offset ".$offset."");
		$qry = $this->db->query("select * from sss_push_message group by number order by message_id  desc");		
		if ($qry->num_rows() > 0) {
			return $qry->result();
		}
		return '';
	}
	// Use :This function use for count message by Filder.
	// Param :option,keyword
	// Return :number
	function get_total_search_message_count($option,$keyword) {
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		//$this->db->select('message.*');
		//$this->db->from('message');
		
		$this->db->from('message');
		
		/*if($option=='status'){
			$this->db->like('status',$keyword);
			if(substr_count($keyword,' ')>=1){
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val){
					$this->db->like('status',$val);
				}	
			}
		}*/
		
		$this->db->where('is_deleted','0');
		$this->db->order_by("message_id", "asc");
		$query = $this->db->get();
		
		
		return $query->num_rows();
	}
	
	
	// Use :This function use for get message detail by filter and limit and offset.
	// Param :offset,limit,option,keyword
	// Return :array of object
	function get_search_message_result($option,$keyword,$offset, $limit) {
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		//$this->db->select('message.*');
		//$this->db->from('message');
		$this->db->from('message t');
		
		/*if($option=='status'){
			$this->db->like('status',$keyword);
			
			if(substr_count($keyword,' ')>=1) {
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val) {
					$this->db->like('status',$val);
				}	
			}
		}*/
		
		$this->db->where('is_deleted','0');
	    $this->db->order_by("message_id", "asc"); 
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
	
	
	
	/* ------------------------- Sent box code start -------------------------------------- */
	
	function get_total_sent_message_count(){
		
		$qry = $this->db->get_where("message",array('is_deleted'=>'0', 'master_message_id	'=>'0', 'from_user_type'=>'admin'));
		
		
		return $qry->num_rows();
	}
	
	// Use :This function use for get message detail by limit and offset.
	// Param :offset,limit
	// Return :array of object	
	
	function get_sent_message_result($offset, $limit){
		$this->db->from('message');
		$this->db->where(array('is_deleted'=>'0', 'master_message_id	'=>'0', 'from_user_type'=>'admin'));
		$this->db->order_by('message_id','asc');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		
		return 0;
	}
	
	// Use :This function use for count message by Filder.
	// Param :option,keyword
	// Return :number
	function get_total_search_sent_message_count($option,$keyword) {
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		//$this->db->select('message.*');
		//$this->db->from('message');
		
		$this->db->from('message');
		
		/*if($option=='status'){
			$this->db->like('status',$keyword);
			if(substr_count($keyword,' ')>=1){
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val){
					$this->db->like('status',$val);
				}	
			}
		}*/
		
		$this->db->where('is_deleted','0');
		$this->db->order_by("message_id", "asc");
		$query = $this->db->get();
		
		
		return $query->num_rows();
	}
	
	
	// Use :This function use for get message detail by filter and limit and offset.
	// Param :offset,limit,option,keyword
	// Return :array of object
	function get_search_sent_message_result($option,$keyword,$offset, $limit) {
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		//$this->db->select('message.*');
		//$this->db->from('message');
		$this->db->from('message t');
		
		/*if($option=='status'){
			$this->db->like('status',$keyword);
			
			if(substr_count($keyword,' ')>=1) {
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val) {
					$this->db->like('status',$val);
				}	
			}
		}*/
		
		$this->db->where('is_deleted','0');
	    $this->db->order_by("message_id", "asc"); 
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
	
	
	/* ------------------------- Sent box code end ---------------------------------------- */
	
	
	function get_user_list($utype,$q){
		$this->db->like('email',$q,'after');
		$this->db->select('user_id,email');
		$this->db->from('user_master');
		$this->db->where('status','active');
		$this->db->where('user_type',$utype);
		$query = $this->db->get();
		
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
		return 0;
	}	
	
		
	function getAllUser($utype){
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->where('status','active');
		$this->db->where('user_type',$utype);
		$this->db->where('email !=','');
		$query = $this->db->get();
		
		
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}	
	
	function get_reply_message_list($message_id,$master_id = 0){
		/*$this->db->from('message');
		$this->db->where('is_deleted','0');
		$this->db->where('master_message_id	 <> ','0');
		$this->db->where('master_message_id	',$message_id);
		
		$query = $this->db->get();*/
		
		if($master_id == 0)
		{
			$main_id = $message_id;
		}
		else
		{
			$main_id = $master_id;
		}

		$qry = $this->db->query("select * from ".$this->db->dbprefix('message')." where 1=1 and (master_message_id= '".$main_id."' or message_id ='".$main_id."') and is_deleted = '0' order by 
		message_id asc
		");
		if ($qry->num_rows() > 0) {
			return $qry->result_array();
		}
		return 0;
	}
	
	function get_id_by_email($email,$type){
		$id= '';
		$user_name = "N/A";
		
			$this->db->select("user_id");
			$this->db->where("email",$email);
			$this->db->where("user_type",$type);
			$query = $this->db->get("user_master");
			
			
			if($query->num_rows() > 0){
				$res = $query->row();
				$id = $res->user_id;
			}
			
		return $id;
			
		
	}
	
}
?>