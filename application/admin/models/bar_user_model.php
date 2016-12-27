<?php
class Bar_user_model extends CI_Model {
	
    function Bar_user_model()
    {
        parent::__construct();	
    }   
	
	/*check unique user 
	 * param : username, paitent_id(if in edit mode)
	 */
	function user_unique($str)
	{
		if($this->input->post('user_id'))
		{
			$query = $this->db->get_where('user_master',array('user_id'=>$this->input->post('user_id')));
			$res = $query->row_array();
			$email = $res['username'];
			
			$query = $this->db->query("select username from ".$this->db->dbprefix('user')." where username = '$str' and user_id!='".$this->input->post('user_id')."'");
		}else{
			$query = $this->db->query("select username from ".$this->db->dbprefix('user')." where username = '$str'");
		}
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/* check unique email
	 * param : email, user id(if in edit mode)
	 */
	function user_email_unique($str,$type)
	{
		if($this->input->post('user_id'))
		{
			$query = $this->db->get_where('user_master',array('user_id'=>$this->input->post('user_id'),'user_type'=>$type));
			$res = $query->row_array();
			$email = $res['email'];
			
			$query = $this->db->query("select email from ".$this->db->dbprefix('user_master')." where user_type='$type' and email = '$str' and user_id!='".$this->input->post('user_id')."'");
		}else{
			$query = $this->db->query("select email from ".$this->db->dbprefix('user_master')." where user_type='$type' and email = '$str'");
		}
		
		
		
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/* add user detail in db
	 * 
	 */	
	function user_insert()
	{
			
		$image_setting = image_setting();
		$profile_image='';
		if($_FILES['file_up']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['file_up']['name'];
             $_FILES['userfile']['type']     =   $_FILES['file_up']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['file_up']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['file_up']['error'];
             $_FILES['userfile']['size']     =   $_FILES['file_up']['size'];
   
			$config['file_name'] = 'user'.$rand;
			
            $config['upload_path'] = base_path().'upload/user_orig/';
			
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
				
				
		   if ($_FILES["file_up"]["type"]!= "image/png" and $_FILES["file_up"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["file_up"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["file_up"]["type"] != "image/jpeg" and $_FILES["file_up"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/user_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/user_thumb/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => $image_setting->user_width,
				'height' => $image_setting->user_height,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$profile_image=$picture['file_name'];
			
		
			if($this->input->post('pre_profile_image')!='')
				{
					if(file_exists(base_path().'upload/user/'.$this->input->post('pre_profile_image')))
					{
						$link=base_path().'upload/user_thumb/'.$this->input->post('pre_profile_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/user_orig/'.$this->input->post('pre_profile_image')))
					{
						$link2=base_path().'upload/user_orig/'.$this->input->post('pre_profile_image');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('pre_profile_image')!='')
				{
					$profile_image=$this->input->post('pre_profile_image');
				}
			}
		
	
		$active=($this->input->post('status')=='active')?'Active':'inactive';
	    $right=($this->input->post('right_upload')=='yes')?'yes':'no';
	   // $password = $this->passwordhash->hash ($this->input->post ("password"));
		$password = md5($this->input->post ("password"));
		$code = randomCode(); 
		$data = array(
			'email' => $this->input->post('emailField'),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'gender' => $this->input->post('gender'),
			'about_user' => $this->input->post('about_user'),
			'password' => $password,
			'status' => $this->input->post('active'),
			'user_type' => 'user',
			'mobile_no' => $this->input->post('mobile_no'),
			'birthdate' => date('Y-m-d',strtotime($this->input->post('start_date'))),
			'profile_image '=>$profile_image,
			'email_verification_code' =>$code,
			'sign_up_date' => date('Y-m-d H:i:s'),
			'sign_up_ip' => $_SERVER['REMOTE_ADDR']
		
		);
		$this->db->insert('user_master',$data);
		
		
		$user_id = mysql_insert_id();
		
		
			/*Mail Send*/
				$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='SIGNUP'");
				$email_temp = $email_template->row();
		
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
		
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
		
				$email = $this->input->post('emailField');
		
				$user_name = $this->input->post('first_name');
				$login_link = front_base_url() . "home/login";
				$data_pass = base64_encode($user_id."1@1".$code);
				
                $activation_link = "<a href='".front_base_url()."/home/activation/".$data_pass."'>Activation link</a>";
		        $login_link = "<a href='".front_base_url()."/home/login'>here</a>";
				$email_to = $email;
		
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{user_name}', $user_name, $email_message);
				$email_message = str_replace('{email}', $email, $email_message);
				$email_message = str_replace('{password}', $this->input->post ("password"), $email_message);
				$email_message = str_replace('{login_link}', $login_link, $email_message);
				$email_message = str_replace('{activation_link}', $activation_link, $email_message);
				
				$str = $email_message;
	        	/** custom_helper email function **/
		
		      //  email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
	
				//echo $str; die; 
	
		
		
		
		
	}
	
	/* user update 
	 * 
	 */
	function user_update()
	{
		$image_setting = image_setting();
		$profile_image='';
		
		if($_FILES['file_up']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['file_up']['name'];
             $_FILES['userfile']['type']     =   $_FILES['file_up']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['file_up']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['file_up']['error'];
             $_FILES['userfile']['size']     =   $_FILES['file_up']['size'];
   
			$config['file_name'] = 'user'.$rand;
			
            $config['upload_path'] = base_path().'upload/user_orig/';
			
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
				
				
		   if ($_FILES["file_up"]["type"]!= "image/png" and $_FILES["file_up"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["file_up"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["file_up"]["type"] != "image/jpeg" and $_FILES["file_up"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/user_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/user_thumb/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => $image_setting->user_width,
				'height' => $image_setting->user_height,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				echo $error = $this->image_lib->display_errors();
			}
			
			$profile_image =$picture['file_name'];
			
		
			if($this->input->post('pre_profile_image')!='')
				{
					if(file_exists(base_path().'upload/user_thumb/'.$this->input->post('pre_profile_image')))
					{
						$link=base_path().'upload/user_thumb/'.$this->input->post('pre_profile_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/user_orig/'.$this->input->post('pre_profile_image')))
					{
						$link2=base_path().'upload/user_orig/'.$this->input->post('pre_profile_image');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('pre_profile_image')!='')
				{
					$profile_image=$this->input->post('pre_profile_image');
				}
			}
		
		
		
		
		$active=($this->input->post('status')=='active')?'active':'inactive';
		$right=($this->input->post('right_upload')=='yes')?'yes':'no';
		
			/*$coach_date='0000-00-00';
		if($this->input->post('user_type')=='poker_coach'){
			 $coach_date = date('Y-m-d');
		}*/
		$data = array(
			'email' => $this->input->post('emailField'),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'gender' => $this->input->post('gender'),
			'about_user' => $this->input->post('about_user'),
		    'mobile_no' => $this->input->post('mobile_no'),
			'birthdate' => date('Y-m-d',strtotime($this->input->post('start_date'))),
			'status' => $this->input->post('active'),
			//'user_type' => $this->input->post('user_type'),
			//'coach_date' =>$coach_date,
			'profile_image '=>$profile_image
			);
		//print_r($data); die;
		$this->db->where('user_id',$this->input->post('user_id'));
		$this->db->update('user_master',$data);
       // echo $this->db->last_query(); die;
       
       
       $dataup = array('bar_first_name'=>$this->input->post('first_name'),
	                    'bar_last_name'=>$this->input->post('last_name'));
           $this->db->where('owner_id',$this->input->post('user_id'));
		$this->db->update('bars',$dataup);
		
		
	}
	
	/* get user info
	 * param : user id
	 * 
	 */		
	function get_one_user($id)
	{
		$query = $this->db->get_where('user_master',array('user_id'=>$id));
		return $query->row_array();
	}	
	
	/* get total users
	 * param :doctor id
	 */
	function get_total_user_count($type=0,$state)
	{
		//$this->db->where('is_deleted','no');
		$this->db->select('user_master.*,bars.bar_type,bars.bar_id,bars.bar_title,bars.bar_slug,bars.address,bars.city,bars.state,bars.zipcode,bars.date_added');
		
		
		$this->db->from('user_master');
		$this->db->join('bars','bars.owner_id=user_master.user_id','left');
		//$this->db->join('user_login','user_master.user_id=user_login.user_id','left');
		
		
		//$this->db->where('user_master.is_deleted','no');
		//$this->db->where('bars.is_deleted','no');
		$this->db->where('user_type','bar_owner');
		$this->db->where('user_master.status',"$state");
		
		//$this->db->group_by('user_login.user_id');
		$this->db->order_by('user_id','desc');
		
		$query = $this->db->get();
		return $query->num_rows();
	
		
	}
	
	
	
	
	/* get user doctor wise
	 * param : doctor id
	 */
	function get_user_result($offset,$limit,$type=0,$state)
	{
		$this->db->select('user_master.*,bars.bar_type,bars.bar_id,bars.bar_title,bars.bar_slug,bars.address,bars.city,bars.state,bars.zipcode,bars.date_added');
		$this->db->from('user_master');
		$this->db->join('bars','bars.owner_id=user_master.user_id','left');
		//$this->db->join('user_login','user_master.user_id=user_login.user_id','left');
		
		//$this->db->where('user_master.is_deleted','no');
		//$this->db->where('bars.is_deleted','no');
		$this->db->where('user_master.status',"$state");
		$this->db->where('user_type',$type);
		$this->db->order_by('user_id','desc');
		//$this->db->order_by('login_id','desc');
		
		//$this->db->group_by('user_login.user_id');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	/* search user doctor wise
	 * param:doctor id,option ,keyword
	 */	
	function get_total_search_user_count($option,$keyword,$state)
	{
		$en='';
		$en1='';
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('user_master.*,bars.bar_type,bars.bar_id,bars.bar_title,bars.bar_slug,bars.address,bars.city,bars.state,bars.zipcode,bars.date_added,user_login.login_date_time');
		
		$this->db->from('user_master');
		$this->db->join('bars','bars.owner_id=user_master.user_id','left');
		$this->db->join('user_login','user_master.user_id=user_login.user_id','left');
		
		
		if($option=='full_name')
		{
			$en.=" `first_name` like ('%".$keyword."%') OR `last_name` like ('%".$keyword."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$en1.=" `first_name` like ('%".$val."%') OR `last_name` like ('%".$val."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en.substr($en1, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
		}
			
		}
		if($option=='email')
		{
			$this->db->like('user_master.email',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('user_master.email',$val);
				}	
			}

		}
		
		
		$this->db->where('user_master.is_deleted','no');
		$this->db->where('user_type','bar_owner');
		$this->db->where('user_master.status',"$state");
		$this->db->group_by('user_login.user_id');
		$this->db->order_by('user_id','desc');
		$query = $this->db->get();
		
		
		return $query->num_rows();
	}
	

	
	/* search user doctor wise
	 * param:doctor id,option ,keyword
	 */		
	function get_search_user_result($option,$keyword,$offset, $limit,$state)
	{
		$en='';
		$en1='';
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('user_master.*,bars.bar_type,bars.bar_id,bars.bar_title,bars.bar_slug,bars.address,bars.city,bars.state,bars.zipcode,bars.date_added,user_login.login_date_time');
		$this->db->from('user_master');
		$this->db->join('bars','bars.owner_id=user_master.user_id','left');
		$this->db->join('user_login','user_master.user_id=user_login.user_id','left');
		
		
		if($option=='full_name')
		{
			$en.=" `first_name` like ('%".$keyword."%') OR `last_name` like ('%".$keyword."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$en1.=" `first_name` like ('%".$val."%') OR `last_name` like ('%".$val."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en.substr($en1, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
		}
			
		}
		if($option=='email')
		{
			$this->db->like('user_master.email',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('user_master.email',$val);
				}	
			}

		}
		$this->db->where('user_master.is_deleted','no');  
		
		$this->db->where('user_type','bar_owner');
		$this->db->order_by('user_id','desc');
		$this->db->group_by('user_login.user_id');
		$this->db->where('user_master.status',"$state");
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
	
	
	/* insert user attachment
	 * param :user id, file
	 */	
	
   
   
}
?>