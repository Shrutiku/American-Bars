<?php
class Home_model extends CI_Model 
{
	/*
	Function name :Home_model
	Description :its default constuctor which called when Home_model object initialzie.its load necesary parent constructor
	*/
	function Home_model()
    {
        parent::__construct();
    }	
	function email_unique($str,$type){
		if($this->input->post('user_id')){
			$query = $this->db->get_where('user_master',array('user_id'=>$this->input->post('user_id'),'user_type'=>$type));
			$res = $query->row_array();
			$email = $res['email'];
			$query = $this->db->query("select email from ".$this->db->dbprefix('user_master')." where user_type='$type' and  is_deleted='no' and email = '$str' and user_id!='".$this->input->post('user_id')."'");
		}
		else{
			$query = $this->db->query('select email from '.$this->db->dbprefix('user_master').' where user_type="'.$type.'" and  is_deleted="no" and email="'.$str.'" ');
		}
		
		
		if($query->num_rows() >0){
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	function register_unique($username){
		if($this->input->post('user_id'))
		{
			$query = $this->db->get_where('user_master',array('user_id'=>$this->input->post('user_id'),'is_deleted'=>'no'));
			$res = $query->row_array();
			$email = $res['user_name'];
			
			$query = $this->db->query("select user_name from ".$this->db->dbprefix('user_master')." where user_name = '$username' and is_deleted='no' and user_id!='".$this->input->post('user_id')."'");
		}else{
			$query = $this->db->query("select user_name from ".$this->db->dbprefix('user_master')." where is_deleted='no' and  user_name = '$username'");
		}
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}	
	
	function is_valid_page($pages_id){

		$this->db->select('*');
		$this->db->where("pages_id",$pages_id);
		$this->db->from('pages');
		$this->db->where('active',1);
		$qry=$this->db->get();
		
		if($qry->num_rows()>0)
		{
		return 1;
		}
		return 0;
		
		}
	function get_page_detail($pages_id){
		
		$this->db->select('*');
		$this->db->where("pages_id",$pages_id);
		
		$this->db->from('pages');
		$qry=$this->db->get();
		if($qry->num_rows()>0)
		{
			return $qry->row();
			}
		return 0;

		}
		
		function get_page_detail_by_slug($slug){
		
		$this->db->select('*');
		$this->db->where("slug",$slug);
		
		$this->db->from('pages');
		$qry=$this->db->get();
		if($qry->num_rows()>0)
		{
			return $qry->row();
			}
		return 0;

		}
	
    function check_login($username = '', $password = '', $remember_me = '',$type='')
	{
	
		$this->load->helper('cookie');

		$query = $this->db->get_where('user_master', array('email' => $username,'password'=>md5($password),'user_type'=>$type,'is_deleted !='=>'yes'));       
      
	
		if ($query->num_rows() > 0)
		{
			$user = $query->row_array();
			$user_id = $user['user_id'];
			$email = $user['email'];
			$status = $user['status'];
            $user_type = $user["user_type"];
		//	echo $user_type;
		//	 $has_passed = $this->passwordhash->check($password, $user["password"]);
			
			
				if($user_type !=$this->input->post('type'))
				{
					return 2;
				}
				if ($status == "active")
				{
					  $usl=array(
					'user_id'=>$user_id,
					'login_date_time'=>date('Y-m-d H:i:s'),
					'login_ip'=>$_SERVER['REMOTE_ADDR'],
					'login_status'=>'online'
					);
				$this->db->insert('user_login',$usl);
					
					$data = array('user_id' => $user_id, 
					
					              'email' => $email,
					              
					              "user_type"=>$user_type,
					              'login_history_id' => $this->db->insert_id() ,
					              
/*					              "right_upload" => $user["right_upload"],*/
					              
					              "username" =>$user["first_name"]
								  );

					$this->session->set_userdata($data);
                    
                 

					if ($remember_me == '1')
					{

						$cookie = array('name' => 'remember_me', 'value' => '1', 'expire' => time() + 86500);
						//set_cookie($cookie);
						setcookie("remember_me", '1', time() + 60 * 60 * 24 * 30, '/');

						$cookieu = array('name' => 'username', 'value' => $username, 'expire' => time() + 86500);
						//set_cookie($cookieu);
						setcookie("username", $username, time() + 60 * 60 * 24 * 30, '/');

						$cookiep = array('name' => 'password', 'value' => $password, 'expire' => time() + 86500);
						setcookie("password", $password, time() + 60 * 60 * 24 * 30, '/');
						
						$cookiep = array('name' => 'type', 'value' => $this->input->post('type'), 'expire' => time() + 86500);
						setcookie("type", $this->input->post('type'), time() + 60 * 60 * 24 * 30, '/');

					} else
					{
						//echo '79sdfs'; die;

						delete_cookie('remember_me');
						delete_cookie('username');
						delete_cookie('password');

					}
                  return 1;
				}
                
				else if ($status == "inactive")
				{
					return 0;
				} 
				else
				{
						return 0;
				}

		

		} 
		
		else
		{
			return "4";
		}

	}	
	
	/** user regisration insert 
	 *8 parameter : insert array and org password
	 @return 0
	 * author:pokatalk
	 */
	 
	 function insert_customer()
	{
		$site_setting = site_setting();	
		$confirm_code=md5(uniqid(rand()));
		
		$data_insert = array();
		$orig_password = $this->input->post('custpassword');
		$date = '';
		if($this->input->post('month')!='' && $this->input->post('day') && $this->input->post('year'))
		{
			$date = $this->input->post('year').'-'.$this->input->post('month').'-'.$this->input->post('day');
		}
		$data_insert['first_name'] = $this->input->post('first_name');
		$data_insert['last_name'] = $this->input->post('last_name');
		$data_insert['email'] = $this->input->post('email');
		$data_insert['gender'] = $this->input->post('gender');
		
		$data_insert['password'] = md5($this->input->post('custpassword'));		
		$data_insert['mobile_no'] = $this->input->post('mobile_no');
		$data_insert['nick_name'] = $this->input->post('nick_name');
		$data_insert['status'] = 'inactive';
		$data_insert['birthdate'] = $date;		
		$data_insert['user_type'] = 'user';		
		$data_insert['sign_up_ip'] = $_SERVER['REMOTE_ADDR'];
		$data_insert['sign_up_date'] = date('Y-m-d H:i:s');		
		$data_insert['email_verification_code'] = $confirm_code;
		$this->db->insert('user_master',$data_insert);		
		$uid = mysql_insert_id();
		
		$data123=array(
			'fname'=>1,
			'user_id'=>$uid,
			'lname'=>1,
			'email1'=>1,
			'gender1'=>1,
			'address1'=>1,
			'mnum'=>1,
			'abt'=>1,
			'pic'=>1,
			'album'=>1,
		);
		//$this->db->where('setting_id',$this->input->post('setting_id'));
		$this->db->insert('user_setting',$data123);
		
		
		//return $uid;
		//die;
		$data_pass = base64_encode($uid."1@1".$confirm_code);
		
		$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='SIGNUP'");
		$email_temp = $email_template->row();

		$email_address_from = $email_temp->from_address;
		$email_address_reply = $email_temp->reply_address;

		$email_subject = $email_temp->subject;
		$email_message = $email_temp->message;

		$email = $data_insert['email'];

		$user_name = $data_insert['first_name']." ".$data_insert['last_name'];
		$login_link = "<a href='".base_url()."home/login/'>here</a>";
        $activation_link = "<a href='".base_url()."home/activation/".$data_pass."'>here</a>";
		$email_to = $email;

		$email_message = str_replace('{break}', '<br/>', $email_message);
		$email_message = str_replace('{user_name}', $user_name, $email_message);
		$email_message = str_replace('{email}', $email, $email_message);
		$email_message = str_replace('{password}', $orig_password, $email_message);
		$email_message = str_replace('{login_link}', $login_link, $email_message);
		$email_message = str_replace('{activation_link}', $activation_link, $email_message);
		
	    $str = $email_message;
		
		
	
		/** custom_helper email function **/
		if($email_temp->status=='active'){
		email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
		}
		return $uid;
		//die;
					/*End mail send*/
					
				
	}
	function insert_user($data_insert = '', $orig_password = '')
	{
		 $code = randomCode(); 
		 $final_arr = array();
		 $email_code = array("email_verification_code"=>$code);
		 
		 $final_arr = array_merge($data_insert,$email_code);

		 $this->db->where('email', $data_insert['email']);
		 $this->db->delete('user_master');
		
		 $this->db->insert('user_master', $final_arr);
		 $uid = mysql_insert_id();
		 
		 
		/*Mail Send*/
		$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='SIGNUP'");
		$email_temp = $email_template->row();

		$email_address_from = $email_temp->from_address;
		$email_address_reply = $email_temp->reply_address;

		$email_subject = $email_temp->subject;
		$email_message = $email_temp->message;

		$email = $data_insert['email'];

		$user_name = $data_insert['user_name'];
		$login_link = "<a href='".base_url()."home/login/'>here</a>";
		$data_pass = base64_encode($uid."1@1".$code);
        $activation_link = "<a href='".base_url()."home/activation/".$data_pass."'>here</a>";
		$email_to = $email;

		$email_message = str_replace('{break}', '<br/>', $email_message);
		$email_message = str_replace('{user_name}', $user_name, $email_message);
		$email_message = str_replace('{email}', $email, $email_message);
		$email_message = str_replace('{password}', $orig_password, $email_message);
		$email_message = str_replace('{login_link}', $login_link, $email_message);
		$email_message = str_replace('{activation_link}', $activation_link, $email_message);
		
	    $str = $email_message;
	if($email_temp->status=='active'){
		email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
	}
	
		/*End mail send*/
		
		return $uid;
	}
	
	function check_user_activation($uid=0,$email_verification_code='')
	{
		$query = $this->db->query("SELECT * FROM  ".$this->db->dbprefix('user_master')." where email_verification_code='".$email_verification_code."' and user_id = '".$uid."' and verify_email = 0");
		if($query->num_rows()>0)
		 {
			$data = array('verify_email'=>1,'status'=>"active");
			$this->db->where('user_id',$uid);
			$this->db->update('user_master',$data);
			return 1;
		 }
		 else 
		 {
			return 0;
		 }	
		
	}
	
	
	function emailTaken($email)
	{
		
		$query = $this->db->query("select email from ".$this->db->dbprefix('user_master')." where email='".$email."'");
	
		 if($query->num_rows()>0)
		 {
			return true;
		 }
		 else 
		 {
			return false;
		 }		
	}

    function check_user_master_type($email)
    {
        $query = $this->db->query("select email, 'user_master' as user_mastertype from ".$this->db->dbprefix('user_master')." where email='".$email."' 
        Union select email, 'doctor' as user_mastertype from ".$this->db->dbprefix('doctor_master')." where email='".$email."'");
    
         if($query->num_rows()>0)
         {
             $res =$query->row();
             return $res->user_mastertype;
            
         }
         else 
         {
            return false;
         }      
    }
	/** function :  user_master_forgot_password
	 * send reset link 
	 * return string
	 * author: pokatalk
	 * */
	 function user_forgot_password($user_email = '',$type='')
	{	     
        $query = $this->db->query("select * from " . $this->db->dbprefix('user_master') . " where user_type='".$this->input->post('type')."' and email= '" . $user_email . "'");
         
	  	$res = $query->row();
		
		if (count($res) > 0)
		{
	
			if ($res->status == '0' || $res->status == "inactive" )
			{				
				return 'inactive';
			}
			else
			{	/*Mail Send*/
				/// set forgot Password Flag////////////////
				$data_update = array("forget_password_flag" => 1);
				$this->db->where("user_id", $res->user_id);
				$this->db->update("user_master", $data_update);
				
				///end of set forgot Password Flag.////////////

				$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Reset Password Link'");
				$email_temp = $email_template->row();

				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;

				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;

				$email = $user_email;

		     	$username = $email;
				$email_to = $email;
			    $reset_link = "<a href='".base_url()."home/reset_password/".base64_encode($res->user_id)."'>here</a>";

				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{user_name}', ucwords($res->first_name)." ".$res->last_name, $email_message);
                $email_message = str_replace('{reset_link}', $reset_link, $email_message);

			   $str = $email_message;
				
				//$str;
                
				/** custom_helper email function **/
if($email_temp->status=='active'){
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
}
				/*End mail send*/
				return 'success';
			}
		} else
		{
			return 'notfound';
		}

	}

	 /** function : check fotgot password
	  * return integert
	  * author: pokatalk
	  */
	function check_forgot_passwordflag($uid = 0,$type='')
	{
		$qry = $this->db->get_where("user_master", array("user_id" => $uid));

		if ($qry->num_rows() > 0)
		{
			$result = $qry->row_array();
			return $result["forget_password_flag"];
		}
		return 0;
	}
	
	/** function : reset_passsword
	 * return int 
	 * author: pokatalk
	 */
	 
	function reset_password($password = '', $uid = 0 , $type="")
	{
		//$qry = $this->db->query("select * from " . $this->db->dbprefix('user') . " where user_id='" . $uid . "'");
		
		$qry = $this->db->get_where("user_master", array("user_id" => $uid));

		if ($qry->num_rows() > 0)
		{
			$user = $qry->row_array();

			//$pass = $this->passwordhash->hash($password);
			$pass = md5($password);
			$password_update = array("password" => $pass, "forget_password_flag" => 0,"reset_password_date"=>date('Y-m-d h:i:s'));
		
			
			$this->db->where("user_id", $uid);
		    $this->db->update("user_master", $password_update);
		    $user_name = $user["first_name"] . " " . $user["last_name"];
		    $login_link = base_url() . "login";

			///////// change password mail//////////////
			$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='change password'");
			$email_temp = $email_template->row();

			$email_address_from = $email_temp->from_address;
			$email_address_reply = $email_temp->reply_address;

			$email_subject = $email_temp->subject;
			$email_message = $email_temp->message;

			$email = $user["email"];


			
			

			$email_to = $email;
			
			

			$email_message = str_replace('{break}', '<br/>', $email_message);
			$email_message = str_replace('{user_name}', $user_name, $email_message);
			$email_message = str_replace('{email}', $email, $email_message);
			$email_message = str_replace('{password}', $password, $email_message);
			$email_message = str_replace('{login_link}', $login_link, $email_message);

			 	$str = $email_message;
			
			/** custom_helper email function **/
if($email_temp->status=='active'){
			email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
}
	        /////// end of change password mail////////////////
	        
	        
	         
	          

			return 1;

		} else
		{
			return 0;
		}

	}

   

	
    /*function : insert_inquiry
     * Insert contact inquiry and send mail to admin*/
     function insert_inquiry($name,$last_name,$email,$subject,$message)
     {
          
          // $data = array('name'=>$name,
                        // 'email'=>$email,
                        // 'subject'=>$subject,
                        // 'last_name'=>$last_name,
                        // 'message'=>$message,
                        // 'ip'=>$_SERVER['REMOTE_ADDR'],
                        // 'date_added'=>date('Y-m-d h:i:s'));
           // $this->db->insert('contact_inquiry',$data);
           
            $site_setting = site_setting();
            
             ///////// Contact us mail//////////////
            $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='enquiry form'");
            $email_temp = $email_template->row();

            $email_address_from = $email_temp->from_address;
            $email_address_reply = $email_temp->reply_address;

            $email_subject = $email_temp->subject;
            $email_message = $email_temp->message;
            
           $email_to = $site_setting->site_email;
            
            $email_message = str_replace('{break}', '<br/>', $email_message);
            $email_message = str_replace('{name}', $name, $email_message);
             $email_message = str_replace('{email}', $email, $email_message);
            $email_message = str_replace('{subject}', $subject, $email_message);
            $email_message = str_replace('{message}', $message, $email_message);
            $str = $email_message;
          
          //dev@nextvisao.com
            /** custom_helper email function **/
            if($email_temp->status=='active'){
            email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
			}
            /////// end of change password mail////////////////
            return 1;
     }

     /*
	  * function : insert_newsletter
	  * insert newletter data
	  *return string
	  * auth: Thais
	  */
     function insert_newsletter($data = array())
	 {
	 	$data["date_created"] = date("Y-m-d H:i:s");
		
		$qry = $this->db->get_where("newsletter",array("email"=>$data['email']));
		
		if($qry->num_rows()>0)
		{
			return "exist";
		}
		
		else
		{
				$this->db->insert("newsletter",$data);	
				return NEWSLETTER_SUCCESS;
		}
	 }
	 
	 
	
   

    
	////////////////////// facebook ///////////////////////////////
	function get_user_by_fb_uid($fb_id = 0,$email='') {
	
	   	//returns the facebook user as an array.
	   		$sql = " SELECT * FROM ".$this->db->dbprefix('user_master')." WHERE fb_id ='".$fb_id."' and user_type='user'";
		
		if($email != ''){
			$sql = " SELECT * FROM ".$this->db->dbprefix('user_master')." WHERE (fb_id ='".$fb_id."' or email='".$email."') and user_type='user'";
		}
		
	
		
	   	$usr_qry = $this->db->query($sql);
		
	   	if($usr_qry->num_rows() > 0) {
		//yes, a user exists
			$user = $usr_qry->row();
			
			
			
			
			if($user->fb_id == 0){
				$data2 = array(					
						'fb_id' => $fb_id	
				);
						
				$this->db->where('email', $email);
				$this->db->update('user_master', $data2);
				
			}
						
			$data = array('user_id' => $user->user_id, 
				          'email' => $user->email,
					      "user_type"=>$user->user_type,
					      //"right_upload" => $user->right_upload,
					      "username" =>$user->first_name,
					      'fb_id' => $user->fb_id,
								  );
			$this->session->set_userdata($data);
//			print_r($data1); print_r($data); die();
	   		
	   		return $user;
	   	} else {
	   		// no user exists
	   		return false;
	   	}
	
	   		
   }
   function remove_fb()
   {
   		$data=array(
			'fb_id'=>''
		);
		
   		$this->db->where('user_id',get_authenticateUserID());
   		$this->db->update('user_master',$data);   
   }
 
	
	//////////////////// end off facebook///////////////////////////
	
	
	 /*function : get_all_faq
     * Get all Active FAQ
    */
    function get_all_faq($keyword = '')
    {
      
		$this->db->select("*");
		$this->db->from("faq");
		$this->db->where("status","active");
		if($keyword!="" && $keyword != "1v1")
		{
		  $this->db->like("faq_question",$keyword,"after");
		}
		
		$qry = $this->db->get();
        if($qry->num_rows()>0)
        {
           return $qry->result();
        }
        
        return 0;
    }
    function bar_title_unique($str)
	{
		
		
		if($this->input->post('bar_id') || $this->session->userdata('viewid_orig')!='')
		{
			
			if($this->session->userdata('viewid_orig')!='')
			{
				$bid= $this->session->userdata('viewid_orig');
			}
			else {
				$bid= $this->input->post('bar_id');
			}	
			$query = $this->db->get_where('bars',array('bar_id'=>$bid));
			$res = $query->row_array();
			$email = $res['bar_title'];
			
			//$query = $this->db->query("select bar_title from ".$this->db->dbprefix('bars')." where bar_title = '$str' and bar_id !='".$bid."'");
				$query = $this->db->query("select bar_title from ".$this->db->dbprefix('bars')." where bar_title = '".addslashes($str)."' and address = '".addslashes($this->input->post('address'))."' and bar_id !='".$bid."'");
		}else{
			//$query = $this->db->query("select bar_title from ".$this->db->dbprefix('bars')." where bar_title = '$str' and is_deleted='no'");
			$query = $this->db->query("select bar_title from ".$this->db->dbprefix('bars')." where address = '".addslashes($this->input->post('address'))."' and bar_title = '".addslashes($str)."' ");
		}
		
		
		//echo $this->db->last_query();
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	function register_bar_owner($type)
	{
		// $data_insert['first_name'] = $this->input->post('first_name');
		// $data_insert['last_name'] = $this->input->post('last_name');
		// $data_insert['email'] = $this->input->post('email');
		// $data_insert['gender'] = $this->input->post('gender');
		// $data_insert['address'] = $this->input->post('address');
		// $data_insert['status'] = 'inactive';
		// $data_insert['is_deleted'] = 'no';
		// $data_insert['user_type'] = 'bar_owner';		
		// $data_insert['sign_up_ip'] = $_SERVER['REMOTE_ADDR'];
		// $data_insert['sign_up_date'] = date('Y-m-d H:i:s');		
		// $this->db->insert('user_master',$data_insert);		
		// $uid = mysql_insert_id();
// 		
		// $data_insert_new['bar_title'] = $this->input->post('bar_title');
		// $data_insert_new['owner_name'] = $this->input->post('first_name')." ".$this->input->post('last_name');
		// $data_insert_new['email'] = $this->input->post('email');
		// $data_insert_new['owner_id'] = $uid;
		// $data_insert_new['address'] = $this->input->post('address');
		// $data_insert_new['bar_desc'] = nl2br($this->input->post('desc'));
		// $data_insert_new['city'] = $this->input->post('city');
		// $data_insert_new['state'] = $this->input->post('state');
		// $data_insert_new['zipcode'] = $this->input->post('zip');
		// $this->db->insert('bars',$data_insert_new);		
		// $bar_id = mysql_insert_id();
		// return $bar_id;
		$getcat = '';
		if($this->input->post('bar_category'))
		{
		$getcat = implode(",", $this->input->post('bar_category'));
		}  
		$data_insert["bar_category"] =$getcat;
		$data_insert['first_name'] = $this->input->post('first_name');
		$data_insert['last_name'] = $this->input->post('last_name');
		$data_insert['email'] = $this->input->post('email');
		$data_insert['gender'] = $this->input->post('gender');
		$data_insert['address'] = $this->input->post('address');
		$data_insert['bar_title'] = $this->input->post('bar_title');
		$data_insert['address'] = $this->input->post('address');
		
		$data_insert['desc'] = nl2br($this->input->post('desc'));
		$data_insert['city'] = $this->input->post('city');
		$data_insert['state'] = $this->input->post('state');
		$data_insert['zip'] = $this->input->post('zip');
		$data_insert['bar_meta_title'] = $this->input->post('bar_meta_title');
		$data_insert['bar_meta_keyword'] = $this->input->post('bar_meta_keyword');
		$data_insert['bar_meta_description'] = $this->input->post('bar_meta_description');
		$this->db->insert('temp_bar',$data_insert);		
		$bar_id = mysql_insert_id();
		return $bar_id;
		
	}  

   function register_taxi_owner()
	{
		
		
		$data_insert['first_name'] = $this->input->post('first_name');
		$data_insert['last_name'] = $this->input->post('last_name');
		$data_insert['email'] = $this->input->post('email');
		$data_insert['mobile_no'] = $this->input->post('mobile_no');
		$data_insert['pass'] = $this->input->post('pass');
		$data_insert['confpass'] = $this->input->post('confpass');
		$this->db->insert('temp_bar',$data_insert);		
		$bar_id = mysql_insert_id();
		return $bar_id;
		
	}  

function claim_register_bar_owner()
	{
		// $data_insert['first_name'] = $this->input->post('first_name');
		// $data_insert['last_name'] = $this->input->post('last_name');
		// $data_insert['email'] = $this->input->post('email');
		// $data_insert['gender'] = $this->input->post('gender');
		// $data_insert['address'] = $this->input->post('address');
		// $data_insert['status'] = 'inactive';
		// $data_insert['is_deleted'] = 'no';
		// $data_insert['user_type'] = 'bar_owner';		
		// $data_insert['sign_up_ip'] = $_SERVER['REMOTE_ADDR'];
		// $data_insert['sign_up_date'] = date('Y-m-d H:i:s');		
		// $this->db->insert('user_master',$data_insert);		
		// $uid = mysql_insert_id();
// 		
		// $data_insert_new['bar_title'] = $this->input->post('bar_title');
		// $data_insert_new['owner_name'] = $this->input->post('first_name')." ".$this->input->post('last_name');
		// $data_insert_new['email'] = $this->input->post('email');
		// $data_insert_new['owner_id'] = $uid;
		// $data_insert_new['address'] = $this->input->post('address');
		// $data_insert_new['bar_desc'] = nl2br($this->input->post('desc'));
		// $data_insert_new['city'] = $this->input->post('city');
		// $data_insert_new['state'] = $this->input->post('state');
		// $data_insert_new['zipcode'] = $this->input->post('zip');
		// $this->db->insert('bars',$data_insert_new);		
		// $bar_id = mysql_insert_id();
		// return $bar_id;
		
		$getcat = '';
		if($this->input->post('bar_category'))
		{
		$getcat = implode(",", $this->input->post('bar_category'));
		}  
		$data_insert["bar_category"] =$getcat;
		$data_insert['first_name'] = $this->input->post('first_name');
		$data_insert['last_name'] = $this->input->post('last_name');
		$data_insert['email'] = $this->input->post('email');
		$data_insert['gender'] = $this->input->post('gender');
		$data_insert['address'] = $this->input->post('address');
		$data_insert['bar_title'] = $this->input->post('bar_title');
		$data_insert['address'] = $this->input->post('address');
		$data_insert['desc'] = nl2br($this->input->post('desc'));
		$data_insert['city'] = $this->input->post('city');
		$data_insert['state'] = $this->input->post('state');
		$data_insert['zip'] = $this->input->post('zip');
		$data_insert['bar_meta_title'] = $this->input->post('bar_meta_title');
		$data_insert['bar_meta_keyword'] = $this->input->post('bar_meta_keyword');
		$data_insert['bar_meta_description'] = $this->input->post('bar_meta_description');
		$this->db->insert('temp_bar',$data_insert);		
		$bar_id = mysql_insert_id();
		return $bar_id;
		
	}  
	function register_bar_owner_update()
	{
		// $data_insert['first_name'] = $this->input->post('first_name');
		// $data_insert['last_name'] = $this->input->post('last_name');
		// $data_insert['email'] = $this->input->post('email');
		// $data_insert['gender'] = $this->input->post('gender');
		// $data_insert['address'] = $this->input->post('address');
		// $data_insert['status'] = 'inactive';
		// $data_insert['is_deleted'] = 'no';
		// $data_insert['user_type'] = 'bar_owner';		
		// $data_insert['sign_up_ip'] = $_SERVER['REMOTE_ADDR'];
		// $data_insert['sign_up_date'] = date('Y-m-d H:i:s');		
		// $this->db->insert('user_master',$data_insert);		
		// $uid = mysql_insert_id();
// 		
		// $data_insert_new['bar_title'] = $this->input->post('bar_title');
		// $data_insert_new['owner_name'] = $this->input->post('first_name')." ".$this->input->post('last_name');
		// $data_insert_new['email'] = $this->input->post('email');
		// $data_insert_new['owner_id'] = $uid;
		// $data_insert_new['address'] = $this->input->post('address');
		// $data_insert_new['bar_desc'] = nl2br($this->input->post('desc'));
		// $data_insert_new['city'] = $this->input->post('city');
		// $data_insert_new['state'] = $this->input->post('state');
		// $data_insert_new['zipcode'] = $this->input->post('zip');
		// $this->db->insert('bars',$data_insert_new);		
		// $bar_id = mysql_insert_id();
		// return $bar_id;
		$getcat = '';
		if($this->input->post('bar_category'))
		{
		$getcat = implode(",", $this->input->post('bar_category'));
		}  
		$data_insert["bar_category"] =$getcat;
		
		$data_insert['first_name'] = $this->input->post('first_name');
		$data_insert['last_name'] = $this->input->post('last_name');
		$data_insert['email'] = $this->input->post('email');
		$data_insert['gender'] = $this->input->post('gender');
		$data_insert['address'] = $this->input->post('address');
		$data_insert['mobile_no'] = $this->input->post('mobile_no');
		
		$data_insert['bar_title'] = $this->input->post('bar_title');
		$data_insert['address'] = $this->input->post('address');
		$data_insert['desc'] = nl2br($this->input->post('desc'));
		$data_insert['city'] = $this->input->post('city');
		$data_insert['state'] = $this->input->post('state');
		$data_insert['zip'] = $this->input->post('zip');
		$data_insert['bar_meta_title'] = $this->input->post('bar_meta_title');
		$data_insert['bar_meta_keyword'] = $this->input->post('bar_meta_keyword');
		$data_insert['bar_meta_description'] = $this->input->post('bar_meta_description');
		//$this->db->insert('temp_bar',$data_insert);		
		$this->db->where('temp_id',$this->input->post('temp_id'));
		$this->db->update('temp_bar',$data_insert);
		return $this->input->post('temp_id');
		
	}  


	function register_bar_owner_features()
	{
		
	    $data_insert['temp_bar_id'] = $this->input->post('bar_id');
		$data_insert['feature_id'] = $this->input->post('btype');
		$this->db->insert('temp_bar_features',$data_insert);	
		
		
		
		$dataup = array('serve_as'=>$this->input->post('serve_as'));
		$this->db->where(array('temp_id'=>$this->input->post('bar_id')));
		$this->db->update('temp_bar',$dataup);
		
		$main_update_arr = array();
		
		
		 if(isset($_POST["days_id"]))
		 {
		 	$this->db->delete("business_hours",array("bar_id"=>$this->input->post('bar_id')));
			
		 	 for($i=0 ; $i<count($_POST["days_id"]);$i++)
			 {
			 	$close = 0;
			 	if(isset($_POST["closed_".$_POST["days_id"][$i].""]))
				{
					$close = $_POST["closed_".$_POST["days_id"][$i].""];
				}
				$from_time = NULL;	
	
				if($_POST["from_".$_POST["days_id"][$i].""] != "")
				{
					
					$from_time = date("H:i", strtotime($_POST["from_".$_POST["days_id"][$i].""]));
				}
				
				$to_time = NULL;
				if($_POST["to_".$_POST["days_id"][$i].""] != "")
				{//$to_time = $_POST["to"][$i];
					$to_time = date("H:i", strtotime($_POST["to_".$_POST["days_id"][$i].""]));
				}
				
				
				if($to_time != "" && $from_time != "")
				{
					$close = 0;
				}
			 	  $ava_arr = array("bar_id"=>$this->input->post('bar_id'),
				                   "days_id" => $_POST["days_id"][$i],
				                   "start_from"=>$from_time,
								   "start_to"=>$to_time,
								   "is_closed"=>$close,
								   "date_added"=>date("Y-m-d H:i:s")
							);
						
					if($to_time == "") {unset($ava_arr["to_time"]);}	
					if($from_time == "") {unset($ava_arr["from_time"]);}	
						   
						   
					//array_push($main_update_arr,$ava_arr);	
					$this->db->insert("business_hours",$ava_arr);   
			 }
		 }
		//return true;
	}
	function register_bar_owner_features_update()
	{
	    //$data_insert['temp_bar_id'] = $this->input->post('bar_id');
		$data_insert['feature_id'] =  $this->input->post('btype');
		$this->db->where('bar_feature_id',$this->input->post('bar_feature_id'));
		$this->db->update('temp_bar_features',$data_insert);
		
		$dataup = array('serve_as'=>$this->input->post('serve_as'));
		$this->db->where(array('temp_id'=>$this->input->post('bar_id')));
		$this->db->update('temp_bar',$dataup);
		
		 if(isset($_POST["days_id"]))
		 {
		 	$this->db->delete("business_hours",array("bar_id"=>$this->input->post('bar_id')));
			
		 	 for($i=0 ; $i<count($_POST["days_id"]);$i++)
			 {
			 	$close = 0;
			 	if(isset($_POST["closed_".$_POST["days_id"][$i].""]))
				{
					$close = $_POST["closed_".$_POST["days_id"][$i].""];
				}
				$from_time = NULL;	
	
				if($_POST["from_".$_POST["days_id"][$i].""] != "")
				{
					
					$from_time = date("H:i", strtotime($_POST["from_".$_POST["days_id"][$i].""]));
				}
				
				$to_time = NULL;
				if($_POST["to_".$_POST["days_id"][$i].""] != "")
				{//$to_time = $_POST["to"][$i];
					$to_time = date("H:i", strtotime($_POST["to_".$_POST["days_id"][$i].""]));
				}
				
				
				if($to_time != "" && $from_time != "")
				{
					$close = 0;
				}
			 	  $ava_arr = array("bar_id"=>$this->input->post('bar_id'),
				                   "days_id" => $_POST["days_id"][$i],
				                   "start_from"=>$from_time,
								   "start_to"=>$to_time,
								   "is_closed"=>$close,
								   "date_added"=>date("Y-m-d H:i:s")
							);
						
					if($to_time == "") {unset($ava_arr["to_time"]);}	
					if($from_time == "") {unset($ava_arr["from_time"]);}	
						   
						   
					//array_push($main_update_arr,$ava_arr);	
					$this->db->insert("business_hours",$ava_arr);   
			 }
		 }
	}

    function getBardataTemp($bar_id='')
	{
		$this->db->select('*');
		$this->db->from('temp_bar');
		$this->db->where('temp_id',$bar_id);
		$query = $this->db->get();
		if($query->num_rows>0)
		{
			return $query->row_array();
		}
	}
	
	 function getBardata($bar_id='')
	{
		$this->db->select('*');
		$this->db->from('bars');
		$this->db->where('bar_id',$bar_id);
		$query = $this->db->get();
		if($query->num_rows>0)
		{
			return $query->row_array();
		}
	}
 	function getBardataTempFeature($bar_id='')
	{
		$this->db->select('*');
		$this->db->from('temp_bar_features');
		$this->db->where('temp_bar_id',$bar_id);
		$query = $this->db->get();
		
		if($query->num_rows>0)
		{
			return $query->row_array();
		}
		else {
			return '';
		}
		
	}
	
	function checkcode()
	{
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->where(array('user_id'=>$this->input->post('user_id'),'confirm_code'=>$this->input->post('code')));
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		return 0;
	}
	
	function get_bar_info($user_id)
	{
		$this->db->select('*,bars.facebook_link,bars.twitter_link,bars.linkedin_link,bars.google_plus_link,
		                 bars.dribble_link,bars.pinterest_link,bars.instagram_link,bars.bar_type');
		$this->db->from('bars');
		$this->db->join('user_master','user_master.user_id=bars.owner_id');
		$this->db->where('bars.owner_id',$user_id);
		$query= $this->db->get();
		
		//echo $this->db->last_query();
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		return '';
	}  
	
	function get_bar_postcard($bar_id,$limit)
	{
		$this->db->select('*');
		$this->db->from('bar_post_card');
		$this->db->where('bar_post_card.bar_id',$bar_id);
		$this->db->where('bar_post_card.status','active');
		$this->db->where('bar_post_card.is_delete','0');
		$this->db->order_by('bar_post_card.postcard_id','desc');
		
		if($limit!='' && $limit!=0)
		{
			$this->db->limit('4');
		}
		$query= $this->db->get();
		
	
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return '';
	}  
	
	function get_bar_postcard_count($bar_id)
	{
		$this->db->select('*');
		$this->db->from('bar_post_card');
		$this->db->where('bar_post_card.bar_id',$bar_id);
		$this->db->where('bar_post_card.status','active');
		$this->db->where('bar_post_card.is_delete',0);
		$this->db->order_by('bar_post_card.postcard_id','desc');
		$query= $this->db->get();
		
		return $query->num_rows();
	}  
	
	function getmessagecount()
	{
		$this->db->select('*');
		$this->db->from('message');
		$this->db->where('from_user_type','admin');
		$this->db->where('to_user_id',get_authenticateUserID());
		$this->db->where('is_read',0);
		$this->db->where('is_deleted',0);
		$this->db->order_by('message_id','desc');
		$query= $this->db->get();
		
		return $query->num_rows();
	}
        
        function getcommentcount()
	{
		$this->db->select('*');
		$this->db->from('comments');
		$this->db->where('from_user_type','admin');
		$this->db->where('to_user_id',get_authenticateUserID());
//		$this->db->where('is_read',0);
//		$this->db->where('is_deleted',0);
		$this->db->order_by('bar_comment_id','desc');
		$query= $this->db->get();
		
		return $query->num_rows();
	}  
	
	
	function countbeer($bar_id)
	{
		$this->db->select('*');
		$this->db->from('beer_bars');
		$this->db->join('beer_directory','beer_directory.beer_id=beer_bars.beer_id');
		$this->db->where('beer_bars.bar_id',$bar_id);
		$this->db->where('beer_directory.is_deleted','no');
		$this->db->order_by('beer_bars.beer_bar_id','desc');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function countcocktail($bar_id)
	{
		$this->db->select('*');
		$this->db->from('cocktail_bars');
		$this->db->join('cocktail_directory','cocktail_directory.cocktail_id=cocktail_bars.cocktail_id');
		$this->db->where('cocktail_bars.bar_id',$bar_id);
		$this->db->where('cocktail_directory.is_deleted','no');
		$this->db->order_by('cocktail_bars.cocktail_bar_id','desc');
		$query = $this->db->get();
		return $query->num_rows();
	}
	function countliquor($bar_id)
	{
		$this->db->select('*');
		$this->db->from('liquors_bars');
		$this->db->join('liquors','liquors.liquor_id=liquors_bars.liquor_id');
		$this->db->where('liquors_bars.bar_id',$bar_id);
		$this->db->where('liquors.is_deleted','no');
			  
		$this->db->order_by('liquors_bars.liquor_bar_id','desc');
		$query = $this->db->get();
		return $query->num_rows();
	}
	function getOneUser()
	 {
	 	  $this->db->select('*');
		  $this->db->from('user_master');
		  $this->db->join('bars','bars.owner_id=user_master.user_id','left');
		  $this->db->where('user_master.user_id',get_authenticateUserID());
		  $query = $this->db->get();
		  
		 
		  return $query->row(); 
	 }
	 
	 function updateUserPassword()
	{
		$data = array('password' =>  md5($this->input->post('upassword')));		
		$query=$this->db->where(array('user_id'=>get_authenticateUserID(),'password'=>md5($this->input->post('oldpassword'))))->get_where('user_master');
		
		if($query->num_rows()>0){
		$this->db->where(array('user_id'=>get_authenticateUserID(),'password'=>md5($this->input->post('oldpassword'))));
		$this->db->update('user_master',$data);
		return true;
		}else{
			return false;
		}
	}
	
	function getStatisticsData()
	{
		$this->db->select('*');
		$this->db->from('bar_statistic');
		$this->db->where('status','active');
		$this->db->order_by('bar_statistic_id','desc');
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return '';
	}
	
	function getnewslettercount()
	{
		$this->db->select('*');
		$this->db->from('news');
		$this->db->where('status','active');
		$this->db->order_by('news_id','desc');
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->num_rows();
		}
		return '';
	}
	
	function getnewsletterresult($offset,$limit)
	{
		$this->db->select('*');
		$this->db->from('news');
		$this->db->where('status','active');
		$this->db->order_by('news_id','desc');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return '';
	}

	function latestmews($limit,$id)
	{
		$this->db->select('*');
		$this->db->from('news');
		$this->db->where('status','active');
		if($id)
		{
			$this->db->where('news_id !=',$id);
		}
		$this->db->order_by('news_id','desc');
		if($limit)
		{
		$this->db->limit($limit);
		}
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return '';
	}
	
	function latestevent($limit)
	{
		$this->db->select('*');
		$this->db->from('events');
		$this->db->join("event_time",'event_time.event_id=events.event_id');
		$this->db->where('status','active');
		$this->db->where('is_deleted','no');
		$this->db->where('bar_id',0);
		$this->db->where('eventdate >=',date('Y-m-d'));
		$this->db->order_by('event_time.eventdate','asc');
		$this->db->group_by('event_time.event_id');
		if($limit)
		{
		$this->db->limit($limit);
		}
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return '';
	}
	
	function latestevent_m($limit,$eid)
	{
		$this->db->select('*');
		$this->db->from('events');
		$this->db->join("event_time",'event_time.event_id=events.event_id');
		$this->db->where('status','active');
		$this->db->where('is_deleted','no');
		$this->db->where('bar_id',0);
		
		$this->db->where('events.event_id !=',$eid);
		$this->db->where('eventdate >=',date('Y-m-d'));
		$this->db->order_by('events.event_id','desc');
		$this->db->group_by('event_time.event_id');
		$this->db->limit($limit);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return '';
	}
	
	 function getAllUser()
    {
    	$this->db->select('*');
		$this->db->from('user_master');
		$this->db->where('status','active');
		//$this->db->where('is_deleted','no');
		$this->db->where('user_id',497);
		$query = $this->db->get();
        if($query->num_rows()>0)
        {
           return $query->result();
        }
        
        return 0;
    }
	
	function getBannerGallery()
	{
		$this->db->select('*');
		$this->db->from('photo_gallery');
		$this->db->where('status','active');
		$this->db->order_by('gallery_id','desc');
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return '';
	}
	
	function insert_advertise()
	{
		$data_insert1["type"] = $this->input->post('type');
		$data_insert1["text"] = $this->input->post('text');
		$data_insert1["description"] = $this->input->post('description');
		$data_insert1["remarks"] = $this->input->post('remarks');
		$data_insert1["name"] = $this->input->post('name');
		$data_insert1["number"] = $this->input->post('number');
		$data_insert1["email"] = $this->input->post('email');
		$data_insert1["date"] =date("Y-m-d");
	   
		$this->db->insert("suggest_advertise",$data_insert1);
	}

function upload_image(){
		if($_FILES['banner_image']['name']!='')
        {
            $profile_image = $this->upload_profile_img();  
			$data_insert["banner_image"] = $profile_image;
		}		
		$this->db->where('owner_id',get_authenticateUserID());
		$this->db->update('bars',$data_insert);
		return $data_insert["banner_image"];
	}

   function upload_profile_img()
	{
		
		$bar_banner_img = '';
		 if($_FILES['banner_image']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['banner_image']['name'];
             $_FILES['userfile']['type']     =   $_FILES['banner_image']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['banner_image']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['banner_image']['error'];
             $_FILES['userfile']['size']     =   $_FILES['banner_image']['size'];
   
			$config['file_name'] = 'bar_logo'.$rand;
			
            $config['upload_path'] = base_path().'upload/barlogo_orig/';
			
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			
			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   
              $this->image_lib->clear();
		   	
			
					$gd_var='gd2';
				
				
		   if ($_FILES["banner_image"]["type"]!= "image/png" and $_FILES["banner_image"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["banner_image"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["banner_image"]["type"] != "image/jpeg" and $_FILES["banner_image"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/barlogo_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/barlogo/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => '685',
				'height' => '320',
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/barlogo_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/banner_without_drag/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => '1140',
				'height' => '244',
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$this->image_lib->clear();
			
			$crop_from_top = abs ($this->input->post('pos')) ;
			
		
		$default_cover_width = 1140;
		$default_cover_height = 244;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/barlogo_orig/'.$picture['file_name'];

		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/banner_drag/'.$picture['file_name'];
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
			 // $this->image_lib->initialize(array(
				// 'image_library' => $gd_var,
				// 'source_image' => base_path().'upload/barlogo_orig/'.$picture['file_name'],
				// 'new_image' => base_path().'upload/banner_drag/'.$picture['file_name'],
				// 'maintain_ratio' => FALSE,
				// 'quality' => '100%',
				// 'width' => '685',
				// 'height' => '320',
				// 'x_axis' => $this->input->post('pos'),
			 // ));
// 			
// 			
			// if(!$this->image_lib->crop())
			// {
				// $error = $this->image_lib->display_errors();
			// }
// 			
			$bar_banner_img=$picture['file_name'];
			
		
			if($this->input->post('prev_bar_banner')!='')
				{
					if(file_exists(base_path().'upload/barlogo_orig/'.$this->input->post('prev_bar_banner')))
					{
						$link=base_path().'upload/barlogo_orig/'.$this->input->post('prev_bar_banner');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/barlogo/'.$this->input->post('prev_bar_banner')))
					{
						$link2=base_path().'upload/barlogo/'.$this->input->post('prev_bar_banner');
						unlink($link2);
					}

					if(file_exists(base_path().'upload/banner_drag/'.$this->input->post('prev_bar_banner')))
					{
						$link2=base_path().'upload/banner_drag/'.$this->input->post('prev_bar_banner');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('prev_bar_banner')!='')
				{
					
					if($this->input->post('pos')!=0)
					{
						
						$this->load->library('upload');
						$crop_from_top = abs ($this->input->post('pos')) ;
						
						
		$default_cover_width = 1140;
		$default_cover_height = 244;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/barlogo_orig/'.$this->input->post('prev_bar_banner');

		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/banner_drag/'.$this->input->post('prev_bar_banner');
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
					}
					$bar_banner_img=$this->input->post('prev_bar_banner');
				}
			}
			
			return $bar_banner_img;
	}

    function get_availability($bar_id=0){
		$query = $this->db->query("SELECT DATE_FORMAT(`start_from`, '%h:%i %p') as start_from, DATE_FORMAT(`start_to`, '%h:%i %p') as start_to ,`is_closed`,`hours_id`,d.*
                                   FROM ".$this->db->dbprefix("days")." d left join ".$this->db->dbprefix("business_hours")." a on d.days_id = a.days_id
                                   where 1=1 and bar_id = '".$bar_id."' ");
			
								   
								   
		if($query->num_rows()>0){
			return $query->result();
		}
		return 0;
	}
	
	 function get_availability_time($bar_id=0){
		$query = $this->db->query("SELECT DATE_FORMAT(`start_from`, '%h:%i %p') as start_from, DATE_FORMAT(`start_to`, '%h:%i %p') as start_to ,`is_closed`,`hours_id`,d.*
                                   FROM ".$this->db->dbprefix("days")." d left join ".$this->db->dbprefix("bar_hours")." a on d.days_id = a.days_id
                                   where 1=1 and bar_id = '".$bar_id."' ");
			
								   
								   
		if($query->num_rows()>0){
			return $query->result();
		}
		return 0;
	}
	
	function getdivebar()
	{
		$this->db->select('*');
		$this->db->from('divebar_findout');
		$this->db->where('status','active');
		$this->db->order_by('divebar_findout_id','asc');
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return '';
	}
	
	function getdivebar_crt($id)
	{
		$this->db->select('*');
		$this->db->from('divebar_findout_topic');
		$this->db->where('divebar_findout_id',$id);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return '';
	}
	
	function latestforum($limit='')
	{
		$this->db->select("v.*,u.first_name,u.last_name,u.profile_image");
		$this->db->from("forum v");
		$this->db->join("user_master u","u.user_id = v.user_id","LEFT");
		$this->db->where("v.status",'active');
		$this->db->order_by('v.forum_id','desc');
		$this->db->limit($limit);
		$qry = $this->db->get();
		//echo $this->db->last_query(); die;
		if($qry->num_rows()>0)
		{
			 return $qry->result();
		}
		
		
		return 0;
	}
	function get_bar_order($bar_id,$limit)
	{
		$this->db->select('*');
		$this->db->from('order_detail');
		$this->db->join('order_master','order_master.order_id=order_detail.order_id');
		$this->db->join('user_master','order_master.user_id=user_master.user_id');
		$this->db->join('store','order_detail.product_id=store.store_id');
		$this->db->where('order_detail.bar_id',$bar_id);
		$this->db->group_by('order_detail.order_id');
		
		if($limit!='' && $limit!=0)
		{
			$this->db->limit('4');
		}
		$query= $this->db->get();
		
	
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return '';
	}
	
	function validate_user_facebook($uid = 0,$email='',$accessToken='') {
		//confirm that facebook session data is still valid and matches
		$this->load->library('fb_connect');
		
   		//see if the facebook session is valid and the user id in the sesison is equal to the user_id you want to validate
		//$session_uid = $this->fb_connect->fbSession['uid'];
		if(!$this->fb_connect->fbSession) {
   	  		return false;
		}
        
   	  	//Receive Data
       	$this->user_id = $uid;
      
	  	if($email!=''){
		 	//$query = $this->db->get_where('user',array('email'=>$email,'user_status'=>"Active", 'domain_id' => GetDomainId()));
		 	$query = $this->db->get_where('user_master',array('email'=>$email,'user_type'=>'user','status'=>"Active"));
			if($query->num_rows() > 0)
			{

				

				//$this->db->query("Update ".$this->db->dbprefix('user')." set fb_id='".$this->user_id."' where email='".$email."' and domain_id = '".GetDomainId()."' ");
				$this->db->query("Update ".$this->db->dbprefix('user_master')." set verify_email='1' where email='".$email."' and 'user_type'='user' ");
				$user = $query->row();
				
				 	 $usl=array(
					'user_id'=>$user->user_id,
					'login_date_time'=>date('Y-m-d H:i:s'),
					'login_ip'=>$_SERVER['REMOTE_ADDR'],
					'login_status'=>'online'
					);
					
					$this->db->insert('user_login',$usl);
					
					$data = array('user_id' => $user->user_id, 
					              'email' => $user->email,
					              "user_type"=>$user->user_type,
					              'login_history_id' => $this->db->insert_id() ,
					              "username" =>$user->first_name
								  );
								
					$this->session->set_userdata($data);	
				
				
				$socialdata['facebook_token']   =  $accessToken;
				$socialdata['facebook_connect'] = 'yes';
				//echo '<pre>'; print_r($socialdata); die;
		
				$user_id = $user->user_id;
			
				/*if(check_IdExit('user_socialshare_settings','user_id',$user_id)){
					$this->db->where(array('user_id'=>$user_id));
					$this->db->update('user_socialshare_settings',$socialdata);	
				} else {
					$socialdata['user_id'] = $user_id;
					$this->db->insert('user_socialshare_settings',$socialdata);
				}*/
				
				//echo $this->db->last_query(); die;
				return "2";		
			} else {
		      	return false;
			}
	  	} else {
	  		
		  	//See if User exists
	      	$this->db->where('fb_id', $this->user_id);
			//$this->db->where('domain_id',GetDomainId());
	      	$q = $this->db->get('user_master');
	
	      	if($q->num_rows == 1) {
	         	 //yes, a user exists,
			  	//$query = $this->db->getwhere('user',array('fb_id'=>$this->user_id,'status'=>"Active", 'domain_id' => GetDomainId()));
				$query = $this->db->get_where('user_master',array('fb_id'=>$this->user_id,'user_type'=>'user','status'=>"Active"));
				
				if($query->num_rows() > 0)
				{
					$user = $query->row();	
					  $usl=array(
					'user_id'=>$user->user_id,
					'login_date_time'=>date('Y-m-d H:i:s'),
					'login_ip'=>$_SERVER['REMOTE_ADDR'],
					'login_status'=>'online'
					);
					$this->db->insert('user_login',$usl);
					$data = array('user_id' => $user->user_id, 
					              'email' => $user->email,
					              "user_type"=>$user->user_type,
					              'login_history_id' => $this->db->insert_id() ,
					              "username" =>$user->first_name
								  );
								
					$this->session->set_userdata($data);			
					return "2";			
				}	
			 	return true;
			}
		    //no user exists
		    return false;
	  	}
   }
		function save_social_data($data){
		$rand = rand('1111','9999');	
		$user_password = $data['first_name'] .'@'.$rand;  
		$data_insert["first_name"] 	= $data['first_name'];
		$data_insert["last_name"] 	= $data['last_name'];
		$data_insert["email"] 		= $data['email'];
		$data_insert["user_type"] 		= 'user';
			
		/*if(GetDomainId() > 0){		
			$data_insert['user_type'] 	= 'consumer';
		} else {
			$data_insert['user_type'] 	= 'merchant';
		} */
		$data_insert["status"] = 'Active';
		$data_insert['sign_up_date']= date('Y-m-d H:i:s');
		$data_insert['sign_up_ip'] 	= $_SERVER['REMOTE_ADDR'];	
		//$data_insert['domain_name'] = $_SERVER['SERVER_NAME'];
		$data_insert['password'] = md5($user_password);
		//$data_insert['domain_id'] 	= GetDomainId();
		
			$data_insert['fb_id'] = $data['fb_id'];
			$data_insert['profile_image'] = $data['fb_img'];
			$data_insert["verify_email"] = "1";	
		
		//echo '<pre>'; print_r($data_insert); die;		
		$this->db->insert('user_master',$data_insert);
		$uid = mysql_insert_id();
		//echo $this->db->last_query(); die;
		
		$data1 = array(	'user_id' => $uid,
						$data['type'].'_id' => $data['fb_id'],
						'email' => $data_insert["email"],
						'username' => $data_insert['first_name'].' '.$data_insert['last_name'],
						//'user_type'=>$data_insert['user_type'],
					);	
		$this->session->set_userdata($data1);
		
			  $usl=array(
					'user_id'=>$uid,
					'login_date_time'=>date('Y-m-d H:i:s'),
					'login_ip'=>$_SERVER['REMOTE_ADDR'],
					'login_status'=>'online'
					);
					$this->db->insert('user_login',$usl);
					
					$data = array('user_id' =>$uid, 
					              'email' =>$data_insert["email"],
					              "user_type"=>'user',
					              'login_history_id' => $this->db->insert_id() ,
					              "username" =>$data_insert['first_name']
								  );
								
					$this->session->set_userdata($data);	
		
	
		
		//==== Mail Send ====//
		$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Sign up with Facebook'");
		$email_temp=$email_template->row();				

		$email_address_from=$email_temp->from_address;
		$email_address_reply=$email_temp->reply_address;

		$email_subject=$email_temp->subject;				
		$email_message=$email_temp->message;
		
		$site_setting = site_setting();
		$email = $data_insert["email"];//$this->input->post('email');
		$user_name = $data_insert["first_name"]." ".$data_insert["last_name"];
		//$data_pass = base64_encode($uid."1@1".$confirm_code);
		$password = $user_password;//$this->input->post('password');
		//$activation_link = "<a href='".base_url()."home/activation/".$data_pass."'>here</a>";
		//$login_link = "<a href='".site_url('home/index/'. base64_encode('login'))."'>here</a>";
		$login_link = "<a href='".site_url('home')."'>here</a>"; 

		$email_message=str_replace('{break}','<br/>',$email_message);
		$email_message=str_replace('{user_name}',$user_name,$email_message);
		$email_message=str_replace('{password}',$password,$email_message);
		$email_message=str_replace('{email}',$email,$email_message);
		//$email_message=str_replace('{activation_link}',$activation_link,$email_message);
		$email_message=str_replace('{login_link}',$login_link,$email_message);
		$email_message=str_replace('{site_name}',$site_setting->site_name,$email_message);
        $email_message=str_replace('{base_theme_url}',base_url().getThemeName(),$email_message);
		
		$email_to =$email;
		
		/*$message=$this->load->view(getThemeName() .'/layout/email/mail_format','',TRUE);
		$message=str_replace('{name}',$user_name,$message);
		$message=str_replace('{mail_content}',$email_message,$message);
		$message=str_replace('{site_name}',$site_setting->site_name,$message);		*/	
		$str=$email_message;
		//==== custom_helper email function ====//
		//print_r($str); die; 			
		if($email_temp->status=='active'){		
		email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
		}
		return $uid;	
	}
function is_valid_page_by_slug($slug=''){

		$this->db->select('*');
		$this->db->where("slug",$slug);
		$this->db->from('pages');
		//$this->db->where('active',1);
		$qry=$this->db->get();
		//echo $this->db->last_query();die;
		if($qry->num_rows()>0)
		{
		return $qry->row();
		}
		return '';

		}

function is_valid_page_by_slug_id($slug=''){

		$this->db->select('*');
		$this->db->where("blog_id",$slug);
		$this->db->from('blog');
		//$this->db->where('active',1);
		$qry=$this->db->get();
		//echo $this->db->last_query();die;
		if($qry->num_rows()>0)
		{
		return $qry->row();
		}
		return '';

		}

	function getrecentblog()
	{
		$this->db->select("v.*,u.first_name,u.last_name");
		$this->db->from("blog v");
		$this->db->join("user_master u","u.user_id = v.user_id","LEFT");
		$this->db->where('v.status','active');
		$this->db->order_by('date_added','desc');
		$this->db->limit(10);
		$qry = $this->db->get();
		//echo $this->db->last_query(); die;
		if($qry->num_rows()>0)
		{
			 return $qry->result();
		}
		
		
		return 0;
	}
	
	function get_postcard_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('bar_post_card');
		$this->db->join('bars','bars.bar_id=bar_post_card.bar_id');
		$this->db->where('bar_post_card.postcard_id',base64_decode($id));
		$query= $this->db->get();
		
	
		if($query->num_rows()>0)
		{
			return $query->row();
		}
		return '';
	}
	
	function barCategory()
	{
		$this->db->select('*');
		$this->db->from('bar_category');
		$this->db->where('status','active');
		$this->db->order_by('bar_category_id','desc');
		$query = $this->db->get();
		
		if($query->num_rows()>0)
		{
			 return $query->result();
		}
		 return '';
	}
	
	function eventCategory()
	{
		$this->db->select('*');
		$this->db->from('event_category');
		$this->db->where('status','active');
		$this->db->order_by('event_category_id','desc');
		$query = $this->db->get();
		
		if($query->num_rows()>0)
		{
			 return $query->result();
		}
		 return '';
	}
	
	function getAllPost($p)
	{
		$this->db->select('*');
		$this->db->from('social_post');
		$this->db->where('user_id',get_authenticateUserID());
		$this->db->where('post_to',$p);
		$this->db->order_by('post_id','desc');
		$query = $this->db->get();
		
		if($query->num_rows()>0)
		{
			 return $query->result();
		}
		 return '';
	}	    
}

?>