<?php
 class Register_model extends CI_Model 
{	/*
	Function name :Home_model
	Description :its default constuctor which called when Home_model object initialzie.its load necesary parent constructor
	*/
	function Register_model()
    {
        parent::__construct();	
    }
	function email_unique($email){
		if($this->input->post('user_id')){
			$query = $this->db->get_where('user_master',array('user_id'=>$this->input->post('user_id')));
			$res = $query->row_array();
			$email = $res['email'];
			
			$query = $this->db->query("select email from ".$this->db->dbprefix('user_master')." where email = '$email' and user_id!='".$this->input->post('user_id')."'");
		}
		else{
			$query = $this->db->query('select email from '.$this->db->dbprefix('user_master').' where email="'.$email.'"');
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
			$query = $this->db->get_where('user_master',array('user_id'=>$this->input->post('user_id')));
			$res = $query->row_array();
			$email = $res['user_name'];
			
			$query = $this->db->query("select user_name from ".$this->db->dbprefix('user_master')." where user_name = '$username' and user_id!='".$this->input->post('user_id')."'");
		}else{
			$query = $this->db->query("select user_name from ".$this->db->dbprefix('user_master')." where user_name = '$username'");
		}
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	function add_register(){
		$data['first_name'] = $this->input->post('first_name');
		$data['last_name'] = $this->input->post('last_name');
		$data['email'] = $this->input->post('email');
		$data['user_name'] = $this->input->post('first_name');
		$data['password'] =md5($this->input->post('password'));
		$data['user_type']= 'user';
		$data['sign_up_ip'] = $_SERVER['REMOTE_ADDR'];
		$data["sign_up_date"] = date("Y-m-d H:i:s");
		$this->db->insert('user_master',$data);
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
	
     function check_login($username = '', $password = '', $remember_me = '')
	{

		$this->load->helper('cookie');

		$query = $this->db->get_where('user_master', array('email' => $username));
       

		if ($query->num_rows() > 0)
		{
			$user = $query->row_array();
			$user_id = $user['user_id'];
			$email = $user['email'];
			$status = $user['status'];
            $user_type = $user["user_type"];
			
		//	 $has_passed = $this->passwordhash->check($password, $user["password"]);
			
			
			if ($user["password"] == md5($password))
			{
				if ($status == "active")
				{
					$data = array('user_id' => $user_id, 
					
					              'email' => $email,
					              
					              "user_type"=>$user_type,
					              
					              "right_upload" => $user["right_upload"],
					              
					              "username" =>$user["first_name"]
								  );

					$this->session->set_userdata($data);
                    
                   

					if ($remember_me == '1')
					{

						$cookie = array('name' => 'remember_me', 'value' => '1', 'expire' => time() + 86500, 'domain' => '', 'path' => '', 'prefix' => '',);
						//set_cookie($cookie);
						setcookie("remember_me", '1', time() + 60 * 60 * 24 * 30, '/');

						$cookieu = array('name' => 'username', 'value' => $username, 'expire' => time() + 86500, 'domain' => '', 'path' => '', 'prefix' => '',);
						//set_cookie($cookieu);
						setcookie("username", $username, time() + 60 * 60 * 24 * 30, '/');

						$cookiep = array('name' => 'password', 'value' => $password, 'expire' => time() + 86500, 'domain' => '', 'path' => '', 'prefix' => '',);
						//set_cookie($cookiep);
						setcookie("password", $this->encrypt->encode($password), time() + 60 * 60 * 24 * 30, '/');

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
		else{
			return "4";
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
	 
	 function insert_user($data_insert = '', $orig_password = '')
	{
		 $code = randomCode(); 
		 $final_arr = array();
		 $email_code = array("email_verification_code"=>$code);
		 
		 $final_arr = array_merge($data_insert,$email_code);
		
		
		
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

		$user_name = $data_insert['email'];
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
       
	
		/** custom_helper email function **/
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
	     
        $query = $this->db->query("select * from " . $this->db->dbprefix('user_master') . " where email= '" . $user_email . "'");
         
	  	$res = $query->row();
		
		if (count($res) > 0)
		{
	
			if ($res->status == '0' || $res->status == "inactive" )
			{
				
				return 'inactive';
			} else
			{

				/*Mail Send*/
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
				$email_message = str_replace('{user_name}', $username, $email_message);
                $email_message = str_replace('{reset_link}', $reset_link, $email_message);

			   $str = $email_message;
				
				
                
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
	   		$sql = " SELECT * FROM ".$this->db->dbprefix('user_master')." WHERE fb_id ='".$fb_id."'";
		
		if($email != ''){
			$sql = " SELECT * FROM ".$this->db->dbprefix('user_master')." WHERE fb_id ='".$fb_id."' or email='".$email."'";
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
					      "right_upload" => $user->right_upload,
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
   function validate_user_facebook($uid = 0,$email='') {
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
	  
		 $query = $this->db->get_where('user_master',array('email'=>$email,'status'=>"active"));
		
		if($query->num_rows() > 0)
		{
			$this->db->query("Update ".$this->db->dbprefix('user_master')." set fb_id='".$this->user_id."' where email='".$email."' and status='active'");
			$user = $query->row();
			
			$data = array('user_id' => $user->user_id, 
					
					              'email' => $user->email,
					              
					              "user_type"=>$user->user_type,
					              
					              "right_upload" => $user->right_upload,
					              
					              "username" =>$user->first_name
								  );
			$this->session->set_userdata($data);
			return "2";			
		}	
		else{
			
	  //See if User exists
      $this->db->where('fb_id', $this->user_id);
      $q = $this->db->get('user_master');

      if($q->num_rows == 1) {
         //yes, a user exists,
		 
		 $query = $this->db->get_where('user_master',array('fb_id'=>$this->user_id,'status'=>"active"));
		
		if($query->num_rows() > 0)
		{
			$user = $query->row();
			
			
		
			$data = array('user_id' => $user->user_id, 
					
					              'email' => $user->email,
					              
					              "user_type"=>$user->user_type,
					              
					              "right_upload" => $user->right_upload,
					              
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
	  else{
	  //See if User exists
      $this->db->where('fb_id', $this->user_id);
      $q = $this->db->get('user_master');

      if($q->num_rows == 1) {
         //yes, a user exists,
		 
		 $query = $this->db->getwhere('user',array('fb_id'=>$this->user_id,'status'=>"active"));
		
		if($query->num_rows() > 0)
		{
			$user = $query->row();
			
					
			$data = array('user_id' => $user->user_id, 
					
					       'email' => $user->email,
					              
					       "user_type"=>$user->user_type,
					              
					        "right_upload" => $user->right_upload,
					              
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
    
}

?>