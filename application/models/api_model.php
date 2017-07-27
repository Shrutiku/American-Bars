<?php
 
class Api_model extends CI_Model 
{

	/*
	Function name :Home_model
	Description :its default constuctor which called when Home_model object initialzie.its load necesary parent constructor
	*/
	function Api_model()
    {
        parent::__construct();	
    } 

			
	/**N**/
    function check_api_login($email,$password)
    {
            //$this->load->helper('cookie');
            $device_id = $this->input->post('device_id');
            $unique_code = uniqid().$device_id;
            $query = $this->db->get_where('user_master',array('email'=>$email,'password'=>md5($password),'user_type'=>'user'));
            if($query->num_rows() == 1)
            {
                    $user = $query->row_array();
                    $user_type=$user['user_type'];
                    $user_id = $user['user_id'];
                    $status = $user['status'];
                    $first_name= $user['first_name'];
                    $last_name= $user['last_name'];
                    $email= $user['email'];
                    $mobile_no= $user['mobile_no'];
                    $image= $user['profile_image'];


                    if($status=='active')
                    {
                            //return "1";
                            $data = array(
                                            'user_id' => $user_id,
                                            'email' => $email,
                                            'image' => $image,
                                            'first_name'=>$first_name,
                                            'last_name'=>$last_name,
                                            'mobile_no'=>$mobile_no,
                                            'unique_code' => $unique_code,
                                            'device_id'=>$device_id,
                                            'status'=>'success'
                                            );

                        $data_device = array(
                    'user_id' => $user_id,
                    'device_name'=>$device_id,
                    'unique_code' => $unique_code,
                    'created_on'=> date('Y-m-d H:i:s')
            );
                            $this->db->insert('device_master',$data_device);	

                            return $data;



                    }else if($status=='suspend'){

                            $data = array(
                    'status'=>'suspend'
                    );
                            return $data;

                    }
                    else if($status=='inactive'){

                            $data = array(
                    'status'=>'inactive'
                    );
                            return $data;

                    }else{
                            $data = array(
                    'status'=>'fail'
                    );
                            return $data;
                    }	

            }
            else
            {
                    $data = array(
                    'status'=>'fail'
                    );
                            return $data;
            }

    }
    
    function check_api_phone_login($phone,$password)
    {
            //$this->load->helper('cookie');
            $device_id = $this->input->post('device_id');
            $unique_code = uniqid().$device_id;
            $query = $this->db->get_where('user_master',array('phone_no'=>$phone,'password'=>md5($password),'user_type'=>'user'));
//            $name_update = array (
//                                    'first_name' => "FUCK",//$this->input->post('first_name'),
//                                    'last_name' => $this->input->post('last_name')
//                                );
//            $this->db->where('user_id',$user_id);
//            $this->db->update('user_master',$name_update);
            
            if($query->num_rows() == 1)
            {
                    $user = $query->row_array();
                    $user_type=$user['user_type'];
                    $user_id = $user['user_id'];
                    $status = $user['status'];
                    $first_name= $user['first_name'];
                    $last_name= $user['last_name'];
                    $phone_no= $user['phone_no'];
                    $image= $user['profile_image'];
                
                    if($status=='active')
                    {
                            //return "1";
                            $data = array(
                                            'user_id' => $user_id,
                                            'image' => $image,
                                            'first_name'=>$first_name,
                                            'last_name'=>$last_name,
                                            'phone'=>$phone_no,
                                            'unique_code' => $unique_code,
                                            'device_id'=>$device_id,
                                            'status'=>'success'
                                            );
                            
                        $data_device = array(
                                'user_id' => $user_id,
                                'device_name'=>$device_id,
                                'unique_code' => $unique_code,
                                'created_on'=> date('Y-m-d H:i:s')
                        );
                        $this->db->insert('device_master',$data_device);	

                        return $data;



                    }else if($status=='suspend'){

                            $data = array(
                    'status'=>'suspend'
                    );
                            return $data;

                    }
                    else if($status=='inactive'){

                            $data = array(
                    'status'=>'inactive'
                    );
                            return $data;

                    }else{
                            $data = array(
                    'status'=>'fail'
                    );
                            return $data;
                    }	

            }
            else
            {
                    $data = array(
                    'status'=>'fail'
                    );
                            return $data;
            }

    }
        
    function user_register_api($first_name,$last_name,$email,$pass,$mobile_no,$nick_name,$month,$day,$year,$gender)
    {
    	$site_setting = site_setting();	
		$confirm_code=md5(uniqid(rand()));
		
		$data_insert = array();
		//$orig_password = $this->input->post('custpassword');
		$date = '';
		if($month!='' && $day && $year)
		{
			$date = $year.'-'.$month.'-'.$day;
		}
		$data_insert['first_name'] = $first_name;
		$data_insert['last_name'] = $last_name;
		$data_insert['email'] = $email;
		$data_insert['gender'] = $gender;
		
		$data_insert['password'] = md5($pass);		
		$data_insert['mobile_no'] = $mobile_no;
		$data_insert['nick_name'] = $nick_name;
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
		
		if($this->input->post('device')=="iphone")
		{
		$data1234=array(
			'device_id'=>$this->input->post('device_id'),
			'token_id'=>$this->input->post('token_id'),
			'user_id'=>1,
		);
		//$this->db->where('setting_id',$this->input->post('setting_id'));
		$this->db->insert('registered_iphone',$data1234);
		}
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
		$email_message = str_replace('{password}', $pass, $email_message);
		$email_message = str_replace('{login_link}', $login_link, $email_message);
		$email_message = str_replace('{activation_link}', $activation_link, $email_message);
		
	    $str = $email_message;
	
		/** custom_helper email function **/
		if($email_temp->status=='active'){
		email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
		}	
		$data = array(
						'status'=>'success',
					  	'user_id'=> $uid
					  );
			return $data;
    }
    
    function user_phone_register_api($first_name,$last_name,$phone_no)
    {
    	$site_setting = site_setting();	
		
        $data_insert = array();
        $data_insert['first_name'] = $first_name;
        $data_insert['last_name'] = $last_name;
        $data_insert['phone_no'] = $phone_no;		
        $data_insert['mobile_no'] = $phone_no;	
        $data_insert['user_name'] = $phone_no;		
        $data_insert['status'] = 'active';
        $data_insert['user_type'] = 'user';		
        $data_insert['sign_up_ip'] = $_SERVER['REMOTE_ADDR'];
        $data_insert['sign_up_date'] = date('Y-m-d H:i:s');		
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

        if($this->input->post('device')=="iphone")
        {
        $data1234=array(
                'device_id'=>$this->input->post('device_id'),
                'token_id'=>$this->input->post('token_id'),
                'user_id'=>1,
        );
        //$this->db->where('setting_id',$this->input->post('setting_id'));
        $this->db->insert('registered_iphone',$data1234);
        }

        $data = array(
                                        'status'=>'success',
                                        'user_id'=> $uid
                                  );
        return $data;
    }

//    function user_phone_update_name_api($first_name,$last_name,$phone_no) {
//        
//        $name_update = array ( 
//            'first_name'=> $first_name, 
//            'last_name'=> $last_name
//                );
//        
//        $this->db->where('user_id',$phone_no);
//        $this->db->update('user_master',$name_update);
//        
//        return $name_update;
//    }
    
	function user_edit_api($user_id)
	{
		 $this->load->library('upload');
		
		
		
		$profile_image='';
		
		// print_r($_FILES);
		// die;
		if(isset($_FILES['file_up']['name']) && $_FILES['file_up']['name']!='')
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
			
            $config['allowed_types'] = '*';  
 
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
		    resize(base_path().'upload/user_orig/'.$picture['file_name'],base_path().'upload/user_thumb/'.$picture['file_name'],120,120);
		
		$this->image_lib->clear();
		    resize(base_path().'upload/user_orig/'.$picture['file_name'],base_path().'upload/user_140/'.$picture['file_name'],140,140);
		
			$this->image_lib->clear();
		    resize(base_path().'upload/user_orig/'.$picture['file_name'],base_path().'upload/user_288/'.$picture['file_name'],288,288);
		
			$this->image_lib->clear();
		    resize(base_path().'upload/user_orig/'.$picture['file_name'],base_path().'upload/user_312/'.$picture['file_name'],312,312);
		
			$profile_image =$picture['file_name'];
			
		
			if($this->input->post('pre_profile_image')!='')
				{	if(file_exists(base_path().'upload/user_288/'.$this->input->post('pre_profile_image')))
					{
						$link=base_path().'upload/user_288/'.$this->input->post('pre_profile_image');
						unlink($link);
					}
					if(file_exists(base_path().'upload/user_312/'.$this->input->post('pre_profile_image')))
					{
						$link=base_path().'upload/user_312/'.$this->input->post('pre_profile_image');
						unlink($link);
					}
					if(file_exists(base_path().'upload/user_140/'.$this->input->post('pre_profile_image')))
					{
						$link=base_path().'upload/user_140/'.$this->input->post('pre_profile_image');
						unlink($link);
					}
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
				$data_update['profile_image'] = $profile_image;
			}
			
		$data_update=array(
			'first_name'=>$this->input->post('first_name'),
			'nick_name'=>$this->input->post('nick_name'),
			'last_name'=>$this->input->post('last_name'),
			'gender'=>$this->input->post('gender'),
			'address'=>$this->input->post('address'),
			'about_user'=>$this->input->post('about_user'),
			'email'=>$this->input->post('email'),
			'user_city'=>$this->input->post('user_city'),
			'user_state'=>$this->input->post('user_state'),
			'user_zip'=> $this->input->post('user_zip'),
			'fb_link' => $this->input->post('fb_link'),
			'gplus_link' => $this->input->post('gplus_link'),
			'twitter_link' => $this->input->post('twitter_link'),
			'linkedin_link' => $this->input->post('linkedin_link'),
			'pinterest_link' => $this->input->post('pinterest_link'),
			'instagram_link' => $this->input->post('instagram_link'),
			'profile_image' => $profile_image,
			'mobile_no'=>$this->input->post('mobile_no')
		);	
		$this->db->where('user_id',$user_id);
		$this->db->update('user_master',$data_update);
		
		//echo $this->db->last_query();
		//die;
		$data = array(
						'status'=>'success',
						'imagename'=>$profile_image,
					  	'user_id'=> $user_id
					  );
			return $data;
		
}

	function forgot_password($email)
	{
		$this->load->library('encrypt');
		$rnd=randomCode();
		$site_setting=site_setting();
		$query = $this->db->get_where("user_master",array("email"=>$email,"user_type"=>'user'));
		$res = $query->row();
		//print_r($res);die;
		if($query->num_rows() > 0)
		{
			if($res->status == 'inactive')
			{
				//return 'inactive';
				$data = array(
						'status'=>'inactive'
					  );
				return $data;
			
			}else if($res->status == 'suspend'){
					
				$data = array(
						'status'=>'suspend'
					  );
				return $data;
				
			}else{
				//return $res;
				
				$ud=array('forget_password_code'=>$rnd);
				//print_r($ud) ;die;
				$this->db->where('user_id',$res->user_id);
				$this->db->update('user_master',$ud);
				
				/*Mail Send*/
				 /*Mail Send*/
                $email_template=$this->db->get_where("email_template",array("task"=>'Forgot Password APP'));
                $email_temp=$email_template->row();
                
                
                $email_address_from=$email_temp->from_address;
                $email_address_reply=$email_temp->reply_address;
                
                $email_subject=$email_temp->subject;
                $email_message=$email_temp->message;
                
                $email = $email;
                $username=ucwords($res->first_name.' '.$res->last_name);
                
                $email_to =$email;
                
                $email_message=str_replace('{break}','<br/>',$email_message);
                $email_message=str_replace('{user_name}',$username,$email_message);
                $email_message=str_replace('{verification_code}',$rnd,$email_message);
                $email_message=str_replace('{site_name}',$site_setting->site_name,$email_message);
                $email_message=str_replace('{break}','<br/>',$email_message);
                
                $str=$email_message;
				
				//$str;
                
				/** custom_helper email function **/
if($email_temp->status=='active'){
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
}
				/*End mail send*/
				$data = array(
						'status'=>'success'
					  );
				return $data;
			}
		}else{
				$data = array(
						'status'=>'notfound'
					  );
			return $data;
		}
	
		
	}
        
        function getAllBarCategories() {
            $this->db->select("bar_category.bar_category_name");
            return $this->db->get("bar_category")->result_array();
        }

	function change_password($password1='',$new_password1='')
	{
		$site_setting=site_setting();
		$query = $this->db->get_where("user",array("password"=>$password1,"user_id"=>$this->input->post('user_id')));
		$res = $query->row();
		//print_r($res);die;
		if($query->num_rows() > 0)
		{
			
			$ud=array('password'=>$new_password1);
			$this->db->where('user_id',$this->input->post('user_id'));
			$this->db->update('user_master',$ud);
			
			$data = array(
						'status'=>'success'
					  );
				return $data;
				
			
		}else{
				$data = array(
						'status'=>'fail'
					  );
			return $data;
		}
	
		
	}
	
	function getAllBar($sort_by,$sort_type,$limit=0,$offset=0,$state='',$city='',$zipcode='',$bar_title='',$lat,$lang,$category='',$address_j,$days,$type='')	{
			$this->db->_protect_identifiers=false; 
		$result = array();
		$R = 6371;
		$rad = 10;
		//$result = array();
		// first-cut bounding box (in degrees)
		$maxLat = '';
		$minLat = '';
		$maxLon = '';
		$minLon = '';
		if($lat!='' && $lang!=''){
$maxLat = $lat + rad2deg($rad/$R);
$minLat = $lat - rad2deg($rad/$R);
// compensate for degrees longitude getting smaller with increasing latitude
$maxLon = $lang + rad2deg($rad/$R/cos(deg2rad($lat)));
$minLon = $lang - rad2deg($rad/$R/cos(deg2rad($lat)));
		}
         
		
		$en ='';
		$getstatename = getstatenamebycode($state);
		$getstatename1 = getcodebystate($state);
		$getstatename4 = getstatenamebycode($address_j);
		$getstatename5 = getcodebystate($address_j);
		
			
			
		
		$this->db->select('bars.lat,bars.lang,bars.bar_title,bars.bar_id,bars.bar_type,bars.bar_desc,bars.owner_id,bars.address,bars.city,bars.state,bars.phone,bars.zipcode,bars.email,
		                   bars.bar_logo, (SELECT sum(bar_rating) AS rat FROM sss_bar_comment  WHERE sss_bar_comment.bar_id = sss_bars.bar_id and sss_bar_comment.status="active" and bar_rating) as total_rating, (SELECT count(*) AS rat FROM sss_bar_comment  WHERE sss_bar_comment.bar_id = sss_bars.bar_id and sss_bar_comment.status="active") as total_commnets');
		
		$this->db->from("bars");
		if($days!= "")
		{
			$this->db->join("bar_special_hours",'bar_special_hours.bar_id=bars.bar_id');
		}
		//$this->db->join("sss_bar_comment",'sss_bar_comment.bar_id=bars.bar_id','left');
		
		// if($bar_title != '0' && $bar_title != "")
		// {
			// $this->db->like("bar_title",$bar_title);
		// }
		if($bar_title != '0' && $bar_title!="1V1" && $bar_title != "")
		{
			
			//echo "fsda";
			$en12 = '';
			$en34 = '';
			//$this->db->like("bar_title",$bar_title);
			//$this->db->or_like("zipcode",$bar_title);
			//$this->db->or_like("bar_desc",$bar_title);
			
			$en12.=" `bar_title` like ('%".mysql_real_escape_string($bar_title)."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		if(substr_count($bar_title,' ')>=1)
			      {
				     $ex=explode(' ',$bar_title);
											  
				  	foreach($ex as $val)
					{
						//echo strlen($val);
						$en34.=" `bar_title` like ('".mysql_real_escape_string($val)."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en12.substr($en34, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en12, 0 ,-3).')')  ;
		}
		
		}
		if($days!= "")
		{
			$this->db->where("days",$days);
			
			//$this->db->like("bar_title",$bar_title_j);
			//$this->db->or_like("zipcode",$bar_title);
			//$this->db->or_like("bar_desc",$bar_title);
		}
		if($address_j!='')
		{
			if($getstatename4)
			{
				$en.="`address` like ('%".$address_j."%') OR `city` like ('%".$address_j."%') OR `zipcode` like ('%".$address_j."%') OR `state` like ('".$getstatename4."%') OR `state` like ('%".$address_j."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
				//$this->db->like("state",$getstatename);
			}
			else if($getstatename5){
				$en.="`address` like ('%".$address_j."%') OR `city` like ('%".$address_j."%') OR `zipcode` like ('%".$address_j."%') OR `state` like ('%".$getstatename5."%') OR `state` like ('%".$address_j."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
			}
			else {
				$en.="`address` like ('%".$address_j."%') OR `city` like ('%".$address_j."%') OR `zipcode` like ('%".$address_j."%') OR `state` like ('%".$address_j."%') OR";
			//$en.=" `user_master.last_name` like ('".$keyword."%') OR";
		
		
			  $this->db->where('('.substr($en, 0 ,-3).')')  ;
			}
		}
		if($state != '0' && $state != "")
		{
			if($getstatename)
			{
				$en.=" `state` like ('%".$getstatename."%') OR `state` like ('%".$state."%') OR";
				$this->db->where('('.substr($en, 0 ,-3).')')  ;
			}
			else if($getstatename1){
				$en.=" `state` like ('%".$getstatename1."%') OR `state` like ('%".$state."%') OR";
				$this->db->where('('.substr($en, 0 ,-3).')')  ;
			}
			else {
				$this->db->like("state",$state);
			}
		}
		if($city != '0' && $city != "")
		{
			$this->db->like("city",$city);
		}
                if($category != '0' && $category != "")
		{
			$this->db->join("bar_category",'FIND_IN_SET(bar_category.bar_category_id, sss_bars.bar_category) != 0');
                        $this->db->where("bar_category.bar_category_name", $category);
		}
		if($zipcode != '0' && $zipcode != "")
		{
			$this->db->like("zipcode",$zipcode);
		 }	
	
		$this->db->where('bars.status','active');
		
		
		if($lat!='' && $lang!='')
		{
			$this->db->where("lat BETWEEN $minLat AND $maxLat");
		   $this->db->where("lang BETWEEN $minLon AND $maxLon");
		}
		
		
		
		$this->db->order_by('bar_type','desc');
		
		if($bar_title!='' && $bar_title!='1V1')
		{
			if($sort_type=='')
			{
		$this->db->order_by('CASE WHEN bar_title like "'.$bar_title.'" THEN 0
            WHEN bar_title like "'.$bar_title.' %" THEN 1
           WHEN bar_title like "%'.$bar_title.'" THEN 2
           ELSE bar_title  END',NULL,FALSE);
	  
	  
			}
			else {
				if($sort_by && $sort_type)
				{
			$this->db->order_by($sort_by,$sort_type);
				}
		}
		}
		else {
			if($sort_by && $sort_type)
				{
			$this->db->order_by($sort_by,$sort_type);
				}
		}
		if($days!= "")
		{
			$this->db->group_by('bar_special_hours.bar_id');
		}
		
		
		if($type=='result')
		{
		if($lat=='' && $lang=='')
		{	
			$this->db->limit($limit,$offset);
		}
		$qry = $this->db->get();
		
		
		//echo $this->db->last_query();
		
		if($qry->num_rows()>0)
		{
			$result["result"] = $qry->result_array();
			//$result["status"] = "success";
			if($city)
			{
				$result["city"] = $city;
			}
			
			$result["sort_by"] = $sort_by;
			$result["sort_type"] = $sort_type;
			
			if($state)
			{
				$result["state"] = $state;
			}
			if($bar_title)
			{
				$result["title"] = $bar_title;
			}
			if($zipcode)
			{
				$result["zipcode"] = $zipcode;
			}
			
			
			return $result;
		}
		else 
			{
				$result["result"] = $qry->result_array();
			//$result["status"] = "success";
			if($city)
			{
				$result["city"] = $city;
			}
			
			$result["sort_by"] = $sort_by;
			$result["sort_type"] = $sort_type;
			
			if($state)
			{
				$result["state"] = $state;
			}
			if($bar_title)
			{
				$result["title"] = $bar_title;
			}
			if($zipcode)
			{
				$result["zipcode"] = $zipcode;
			}
			
			return $result;
			}
		}
		else {
			$qry = $this->db->get();
			return $qry->num_rows(); 
		}
		
	 // print_r($result);
	 // die;
		
		//$result["status"] = "fail";
			return $result;
	}
	
	function getAllBarHappyHours($sort_by,$sort_type,$limit=0,$offset=0,$state='',$city='',$zipcode='',$bar_title='',$lat,$lang,$address_j,$days,$type='')	{
		
		$R = 6371;
		$rad = 10;
		// first-cut bounding box (in degrees)
		$maxLat = '';
		$minLat = '';
		$maxLon = '';
		$minLon = '';
		if($lat!='' && $lang!=''){
$maxLat = $lat + rad2deg($rad/$R);
$minLat = $lat - rad2deg($rad/$R);
// compensate for degrees longitude getting smaller with increasing latitude
$maxLon = $lang + rad2deg($rad/$R/cos(deg2rad($lat)));
$minLon = $lang - rad2deg($rad/$R/cos(deg2rad($lat)));
		}
         
		$result = array();
		$en ='';
		$getstatename = getstatenamebycode($state);
		$getstatename1 = getcodebystate($state);
		$getstatename4 = getstatenamebycode($address_j);
		$getstatename5 = getcodebystate($address_j);
		
			
			
		
//		$this->db->select('bar_special_hours.*');
                $this->db->select('bar_happy_hour.*');
                
		$this->db->from("bars");
		//if($days!= "")
		//{
//			$this->db->join("bar_special_hours",'bar_special_hours.bar_id=bars.bar_id');
                        $this->db->join("bar_happy_hour",'bar_happy_hour.bar_id=bars.bar_id');
		//}
		//$this->db->join("sss_bar_comment",'sss_bar_comment.bar_id=bars.bar_id','left');
		
		if($bar_title != '0' && $bar_title != "")
		{
			$this->db->like("bar_title",$bar_title);
		}
		if($days!= "")
		{
			$this->db->where("days",$days);
			
			//$this->db->like("bar_title",$bar_title_j);
			//$this->db->or_like("zipcode",$bar_title);
			//$this->db->or_like("bar_desc",$bar_title);
		}
		if($address_j!='')
		{
			if($getstatename4)
			{
				$en.="`address` like ('%".$address_j."%') OR `city` like ('%".$address_j."%') OR `zipcode` like ('%".$address_j."%') OR `state` like ('".$getstatename4."%') OR `state` like ('%".$address_j."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
				//$this->db->like("state",$getstatename);
			}
			else if($getstatename5){
				$en.="`address` like ('%".$address_j."%') OR `city` like ('%".$address_j."%') OR `zipcode` like ('%".$address_j."%') OR `state` like ('%".$getstatename5."%') OR `state` like ('%".$address_j."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
			}
			else {
				$en.="`address` like ('%".$address_j."%') OR `city` like ('%".$address_j."%') OR `zipcode` like ('%".$address_j."%') OR `state` like ('%".$address_j."%') OR";
			//$en.=" `user_master.last_name` like ('".$keyword."%') OR";
		
		
			  $this->db->where('('.substr($en, 0 ,-3).')')  ;
			}
		}
		if($state != '0' && $state != "")
		{
			if($getstatename)
			{
				$en.=" `state` like ('%".$getstatename."%') OR `state` like ('%".$state."%') OR";
				$this->db->where('('.substr($en, 0 ,-3).')')  ;
			}
			else if($getstatename1){
				$en.=" `state` like ('%".$getstatename1."%') OR `state` like ('%".$state."%') OR";
				$this->db->where('('.substr($en, 0 ,-3).')')  ;
			}
			else {
				$this->db->like("state",$state);
			}
		}
		if($city != '0' && $city != "")
		{
			$this->db->like("city",$city);
		}
		if($zipcode != '0' && $zipcode != "")
		{
			$this->db->like("zipcode",$zipcode);
		 }	
	
		$this->db->where('bars.status','active');
		
		
		if($lat!='' && $lang!='')
		{
			$this->db->where("lat BETWEEN $minLat AND $maxLat");
		   $this->db->where("lang BETWEEN $minLon AND $maxLon");
		}
		
		$this->db->order_by('bar_type','desc');
		
		if($bar_title!='' && $bar_title!='1V1')
		{
			if($sort_type=='')
			{
		$this->db->order_by('CASE WHEN bar_title like "'.$bar_title.'" THEN 0
            WHEN bar_title like "'.$bar_title.' %" THEN 1
           WHEN bar_title like "%'.$bar_title.'" THEN 2
           ELSE bar_title  END',NULL,FALSE);
			}
			else {
				if($sort_by && $sort_type)
				{
			$this->db->order_by($sort_by,$sort_type);
				}
		}
		}
		else {
			if($sort_by && $sort_type)
				{
			$this->db->order_by($sort_by,$sort_type);
				}
		}
		//$this->db->order_by($sort_by,$sort_type);
		// if($days!= "")
		// {
		// $this->db->group_by('bars.bar_id');
		// }
		if($type=='result')
		{
		if($lat=='' && $lang=='')
		{	
			$this->db->limit($limit,$offset);
		}
		$qry = $this->db->get();
		
		
		//echo $this->db->last_query();
		
		if($qry->num_rows()>0)
		{
			$result["result"] = $qry->result_array();
			//$result["status"] = "success";
			if($city)
			{
				$result["city"] = $city;
			}
			
			$result["sort_by"] = $sort_by;
			$result["sort_type"] = $sort_type;
			
			if($state)
			{
				$result["state"] = $state;
			}
			if($bar_title)
			{
				$result["title"] = $bar_title;
			}
			if($zipcode)
			{
				$result["zipcode"] = $zipcode;
			}
			
			
			return $result;
		}
		else 
			{
				$result["result"] = $qry->result_array();
			//$result["status"] = "success";
			if($city)
			{
				$result["city"] = $city;
			}
			
			$result["sort_by"] = $sort_by;
			$result["sort_type"] = $sort_type;
			
			if($state)
			{
				$result["state"] = $state;
			}
			if($bar_title)
			{
				$result["title"] = $bar_title;
			}
			if($zipcode)
			{
				$result["zipcode"] = $zipcode;
			}
			
			return $result;
			}
		}
		else {
		
			$qry = $this->db->get();
			return $qry->num_rows(); 
		}
		
		
		//$result["status"] = "fail";
			return $result;
	}


function getAllbarEvents($sort_by,$sort_type,$limit=0,$offset=0,$state='',$city='',$zipcode='',$bar_title='',$lat,$lang,$address_j,$days,$type='')	{
				$this->db->_protect_identifiers=false; 
		$R = 6371;
		$rad = 20;
		// first-cut bounding box (in degrees)
		$maxLat = '';
		$minLat = '';
		$maxLon = '';
		$minLon = '';
		if($lat!='' && $lang!=''){
$maxLat = $lat + rad2deg($rad/$R);
$minLat = $lat - rad2deg($rad/$R);
// compensate for degrees longitude getting smaller with increasing latitude
$maxLon = $lang + rad2deg($rad/$R/cos(deg2rad($lat)));
$minLon = $lang - rad2deg($rad/$R/cos(deg2rad($lat)));
		}
         
		$result = array();
		$en ='';
		$getstatename = getstatenamebycode($state);
		$getstatename1 = getcodebystate($state);
		$getstatename4 = getstatenamebycode($address_j);
		$getstatename5 = getcodebystate($address_j);
		
			
			
		
		$this->db->select('*');
		
		$this->db->from("events");
		//if($days!= "")
		//{
			$this->db->join("event_time",'event_time.event_id=events.event_id');
                        //$this->db->join("event_images",'event_images.bar_eventgallery_id=events.event_id');

		//}
		//$this->db->join("sss_bar_comment",'sss_bar_comment.bar_id=bars.bar_id','left');
		
	
		$this->db->where('events.status','active');
		$this->db->where('events.bar_id',0);
		$this->db->where('event_time.eventdate >=',date('Y-m-d'));
		
		$stdate = date('Y-m-d');
		$enddate =  date('Y-m-d', strtotime("+30 days"));
		
		$this->db->where('event_time.eventdate >=',$stdate);
		$this->db->where('event_time.eventdate <=',$enddate);
		
		if($lat!='' && $lang!='')
		{
			$this->db->where("event_lat BETWEEN $minLat AND $maxLat");
		  	$this->db->where("event_lng BETWEEN $minLon AND $maxLon");
		}
		
		
		$this->db->group_by('event_time.event_id');
		//$this->db->order_by($sort_by,$sort_type);
		// if($days!= "")
		// {
		// $this->db->group_by('bars.bar_id');
		// }
		if($type=='result')
		{
		if($lat=='' && $lang=='')
		{	
			$this->db->limit($limit,$offset);
		}
		$qry = $this->db->get();
		
		//echo $this->db->last_query();
		
		if($qry->num_rows()>0)
		{
			$result["result"] = $qry->result_array();
			//$result["status"] = "success";
			
			return $result;
		}
		else 
			{
				$result["result"] = $qry->result_array();
			//$result["status"] = "success";
			if($city)
			{
				$result["city"] = $city;
			}
			
			$result["sort_by"] = $sort_by;
			$result["sort_type"] = $sort_type;
			
			if($state)
			{
				$result["state"] = $state;
			}
			if($bar_title)
			{
				$result["title"] = $bar_title;
			}
			if($zipcode)
			{
				$result["zipcode"] = $zipcode;
			}
			
			return $result;
			}
		}
		else {
		
			$qry = $this->db->get();
			return $qry->num_rows(); 
		}
		
		
		//$result["status"] = "fail";
			return $result;
	}
	
	function getAllBeer($sort_by='',$sort_type='',$limit=0,$offset=0,$keyword='',$alpha='',$bar_id,$type='')
	{
		$result = array();
		//$this->db->protect_identifiers=false;
		$this->db->_protect_identifiers=false;
		$en ='';
		$this->db->select('beer_directory.beer_id,beer_name,beer_type,producer,city_produced,beer_state,beer_image,status, REPLACE(beer_website,"http://", "") as beer_website');
		$this->db->from("beer_directory");
		if($bar_id!=0 && $bar_id!='')
		{
			$this->db->join("beer_bars",'beer_bars.beer_id=beer_directory.beer_id');
			$this->db->where('beer_bars.bar_id',$bar_id);
		}
		$this->db->where('status','active');
		$this->db->where('is_deleted','no');
		
		//$this->db->group_start();
		if($alpha != "" && $alpha != "no")
		{
			
			if($alpha=="'-#")
			{
				 $this->db->where("( `beer_name` LIKE '#%'  OR `beer_name` LIKE '\'%' OR `beer_name` LIKE '\"%' OR `beer_name` LIKE '@%' OR `beer_name` LIKE '#%' OR `beer_name` LIKE '\%%' OR `beer_name` LIKE '$%' OR `beer_name` LIKE '!%' OR `beer_name` LIKE ',%') ", NULL, 'FALSE');
			}
			else if($alpha=="0-9")
			{
				$this->db->where("(`beer_name` LIKE '1%' OR `beer_name` LIKE '2%' OR `beer_name` LIKE '3%' OR `beer_name` LIKE '4%' OR `beer_name` LIKE '5%' OR `beer_name` LIKE '6%' OR `beer_name` LIKE '7%' OR `beer_name` LIKE '8%' OR `beer_name` LIKE '9%'   )", NULL, 'FALSE');
			}
		 else {
				 $this->db->like("beer_name",$alpha,"after");
			}
		}
		
		if($keyword != '0')
		{
			$this->db->where('(`beer_name` LIKE  \'%'.mysql_real_escape_string($keyword).'%\' OR `beer_type` LIKE \''.mysql_real_escape_string($keyword).'%\' OR `producer` LIKE \''.mysql_real_escape_string($keyword).'%\')', NULL, 'FALSE');
		}
		
		
		if($keyword!='0' && $keyword!='' && $keyword!='1V1')
		{
			if($sort_type=='')
			{
		$this->db->order_by('CASE WHEN beer_name like "'.$keyword.'" THEN 0
            WHEN beer_name like "'.$keyword.' %" THEN 1
           WHEN beer_name like "%'.$keyword.'" THEN 2
           ELSE beer_name  END',NULL,FALSE);
			}
			else {
				if($sort_by && $sort_type)
				{
			$this->db->order_by($sort_by,$sort_type);
				}
		}
		}
		else {
			if($sort_by && $sort_type)
				{
			$this->db->order_by($sort_by,$sort_type);
				}
		}
		//$this->db->order_by($sort_by,$sort_type);
		
		if($type=='result')
		{
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		
		
		if($qry->num_rows()>0)
		{
			 $result["result"] = $qry->result_array();
			//$result["status"] = "success";
			if($keyword)
			{
				$result["keyword"] = $keyword;
			}
			if($alpha)
			{
				$result["alpha"] = $alpha;
			}
			$result["sort_by"] = $sort_by;
			$result["sort_type"] = $sort_type;
			$result["bar_id"] = $bar_id;
			//$result["status"] = "success";
			return $result;
		}
		}
		else
		{
			$qry = $this->db->get();
			return $qry->num_rows(); 
		}

		
		//$result["status"] = "fail";
		return $result;
	}
		
	function getAllCocktail($sort_by='',$sort_type='',$limit=0,$offset=0,$keyword='',$alpha='',$bar_id,$type='')
	{
		$result = array();
		$this->db->_protect_identifiers=false;
		$en ='';
		$this->db->select('cocktail_directory.cocktail_id,cocktail_name,ingredients,type,served,difficulty,status,cocktail_image');
		$this->db->from("cocktail_directory");
		if($bar_id!=0 && $bar_id!='')
		{
			$this->db->join("cocktail_bars",'cocktail_bars.cocktail_id=cocktail_directory.cocktail_id');
			$this->db->where('cocktail_bars.bar_id',$bar_id);
		}
		$this->db->where('status','active');
		$this->db->where('is_deleted','no');
		//$this->db->group_start();
		if($alpha != "" && $alpha != "no")
		{
			
			if($alpha=="'-#")
			{
				 $this->db->where("( `cocktail_name` LIKE '#%'  OR `cocktail_name` LIKE '\'%' OR `cocktail_name` LIKE '\"%' OR `cocktail_name` LIKE '@%' OR `cocktail_name` LIKE '#%' OR `cocktail_name` LIKE '\%%' OR `cocktail_name` LIKE '$%' OR `cocktail_name` LIKE '!%' OR `cocktail_name` LIKE ',%') ", NULL, 'FALSE');
			}
			else if($alpha=="0-9")
			{
				$this->db->where("(`cocktail_name` LIKE '1%' OR `cocktail_name` LIKE '2%' OR `cocktail_name` LIKE '3%' OR `cocktail_name` LIKE '4%' OR `cocktail_name` LIKE '5%' OR `cocktail_name` LIKE '6%' OR `cocktail_name` LIKE '7%' OR `cocktail_name` LIKE '8%' OR `cocktail_name` LIKE '9%'   )", NULL, 'FALSE');
			}
		 else {
				 $this->db->like("cocktail_name",$alpha,"after");
			}
		}
		
		if($keyword != '0')
		{
			$this->db->where('(`cocktail_name` LIKE  \'%'.mysql_real_escape_string($keyword).'%\' OR `type` LIKE \''.mysql_real_escape_string($keyword).'%\')', NULL, 'FALSE');
		}
		
		//$this->db->order_by($sort_by,$sort_type);
		
			if($keyword!='' && $keyword!='0' && $keyword!='1V1')
		{
			
		
			//echo $sort_type;
			if($sort_type=='')
			{
			//	echo "SDa";
		$this->db->order_by('CASE WHEN cocktail_name like "'.$keyword.'" THEN 0
            WHEN cocktail_name like "'.$keyword.' %" THEN 1
           WHEN cocktail_name like "%'.$keyword .'" THEN 2
           ELSE cocktail_name 
      END',NULL,FALSE);
			}
			else
			{
				if($sort_by && $sort_type)
				{
				$this->db->order_by($sort_by,$sort_type);
				}
				
			}	
		}
		
		else {
				//$this->db->order_by('bar_type','desc');
		//}
				if($sort_by && $sort_type)
				{
				$this->db->order_by($sort_by,$sort_type);
				}
		}
		if($type=="result")
		{
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		if($qry->num_rows()>0)
		{
			 $result["result"] = $qry->result_array();
			//$result["status"] = "success";
			if($keyword)
			{
				$result["keyword"] = $keyword;
			}
			if($alpha)
			{
				$result["alpha"] = $alpha;
			}
			$result["sort_by"] = $sort_by;
			$result["sort_type"] = $sort_type;
			$result["bar_id"] = $bar_id;
			//$result["status"] = "success";
			return $result;
		}
		}
		else {
			$qry = $this->db->get();
			return $qry->num_rows(); 
		}
		
		//$result["status"] = "fail";
		return $result;
	}	
	
	function getAllLiquor($sort_by='',$sort_type='',$limit=0,$offset=0,$keyword='',$alpha='',$bar_id,$type='')
	{
		$result = array();
		$en ='';
		$this->db->_protect_identifiers=false;
		$this->db->select('liquors.liquor_id,liquor_title,type,proof,producer,status,liquor_image');
		$this->db->from("liquors");
		if($bar_id!=0 && $bar_id!='')
		{
			$this->db->join("liquors_bars",'liquors_bars.liquor_id=liquors.liquor_id');
			$this->db->where('liquors_bars.bar_id',$bar_id);
		}
		$this->db->where('status','active');
		$this->db->where('is_deleted','no');
		//$this->db->group_start();
		if($alpha != "" && $alpha != "no")
		{
			
			if($alpha=="'-#")
			{
				 $this->db->where("( `liquor_title` LIKE '#%'  OR `liquor_title` LIKE '\'%' OR `liquor_title` LIKE '\"%' OR `liquor_title` LIKE '@%' OR `liquor_title` LIKE '#%' OR `liquor_title` LIKE '\%%' OR `liquor_title` LIKE '$%' OR `liquor_title` LIKE '!%' OR `liquor_title` LIKE ',%') ", NULL, 'FALSE');
			}
			else if($alpha=="0-9")
			{
				$this->db->where("(`liquor_title` LIKE '1%' OR `liquor_title` LIKE '2%' OR `liquor_title` LIKE '3%' OR `liquor_title` LIKE '4%' OR `liquor_title` LIKE '5%' OR `liquor_title` LIKE '6%' OR `liquor_title` LIKE '7%' OR `liquor_title` LIKE '8%' OR `liquor_title` LIKE '9%'   )", NULL, 'FALSE');
			}
		 else {
				 $this->db->like("liquor_title",$alpha,"after");
			}
		}
		
		if($keyword != '0')
		{
			$this->db->where('(`liquor_title` LIKE  \'%'.mysql_real_escape_string($keyword).'%\' OR `type` LIKE \''.mysql_real_escape_string($keyword).'%\')', NULL, 'FALSE');
		}
		if($keyword!='' && $keyword!='0' && $keyword!='1V1')
		{
			
		
			//echo $sort_type;
			if($sort_type=='')
			{
			//	echo "SDa";
		$this->db->order_by('CASE WHEN liquor_title like "'.$keyword.'" THEN 0
            WHEN liquor_title like "'.$keyword.' %" THEN 1
           WHEN liquor_title like "%'.$keyword .'" THEN 2
           ELSE liquor_title 
      END',NULL,FALSE);
			}
			else
			{
				if($sort_by && $sort_type)
				{
				$this->db->order_by($sort_by,$sort_type);
				}
				
			}	
		}
		else {
				//$this->db->order_by('bar_type','desc');
		//}
				if($sort_by && $sort_type)
				{
				$this->db->order_by($sort_by,$sort_type);
				}
		}
		
		
		if($type=="result")
		{
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		if($qry->num_rows()>0)
		{
			 $result["result"] = $qry->result_array();
			//$result["status"] = "success";
			if($keyword)
			{
				$result["keyword"] = $keyword;
			}
			if($alpha)
			{
				$result["alpha"] = $alpha;
			}
			$result["sort_by"] = $sort_by;
			$result["sort_type"] = $sort_type;
			$result["bar_id"] = $bar_id;
			//$result["status"] = "success";
			return $result;
		}
		}
		else {
			$qry = $this->db->get();
			return $qry->num_rows(); 
		}
		
		
		//$result["status"] = "fail";
		return $result;
	}		
	
	function getAllTaxi($sort_by='',$sort_type='',$limit=0,$offset=0,$keyword='',$alpha='',$type='')
	{
		$result = array();
		$en ='';
		$this->db->select('taxi_id,taxi_company,address,city,state,phone_number,status,cmpn_zipcode,taxi_image,taxi_desc');
		$this->db->from("taxi_directory");
		$this->db->where('status','active');
		$this->db->where('is_deleted','no');
		//$this->db->group_start();
		if($alpha != "" && $alpha != "no")
		{
			$this->db->like("taxi_company",$alpha,"after");
		}
		
		if($keyword != '0')
		{
			$this->db->where('(`taxi_company` LIKE  \''.mysql_real_escape_string($keyword).'%\' OR `city` LIKE \''.mysql_real_escape_string($keyword).'%\' OR `state` LIKE \''.mysql_real_escape_string($keyword).'%\' OR `cmpn_zipcode` LIKE \''.mysql_real_escape_string($keyword).'%\')', NULL, 'FALSE');
		}
		
		$this->db->order_by($sort_by,$sort_type);
		if($type=='result')
		{
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		if($qry->num_rows()>0)
		{
			 $result["result"] = $qry->result_array();
			//$result["status"] = "success";
			if($keyword)
			{
				$result["keyword"] = $keyword;
			}
			if($alpha)
			{
				$result["alpha"] = $alpha;
			}
			$result["sort_by"] = $sort_by;
			$result["sort_type"] = $sort_type;
			//$result["status"] = "success";
			return $result;
		}
		}
		else {
			$qry = $this->db->get();
			return $qry->num_rows(); 
		}
		
		//$result["status"] = "fail";
		return $result;
	}		
	
	function getBarDetails($bar_id='',$user_id='')
	{
		$result["result"] = array();
		$this->db->_protect_identifiers=false;
		$this->db->select('bars.bar_title,bars.bar_slug,bars.bar_video_link,bars.bar_logo,bars.address,bars.phone,bars.bar_desc,bars.bar_desc,bars.bar_id,
		                   bars.bar_type,bars.twitter_link as twitter_link,bars.linkedin_link as linkedin_link,
		                   bars.pinterest_link as pinterest_link,bars.facebook_link as facebook_link,lat,lang,
		                   bars.google_plus_link as google_plus_link, bars.dribble_link as dribble_link,serve_as,
		                   bars.city,bars.state,bars.zipcode,bars.phone,bars.email, REPLACE(website,"http://", "") as website,
		                   bars.cash_p,bars.master_p,bars.american_p,bars.visa_p,bars.paypal_p,bars.bitcoin_p,bars.apple_p,
		                   (select like_flag from sss_all_likes where sss_all_likes.bar_id='.$bar_id.' and sss_all_likes.user_id='.$user_id.') as like_bar,
		                   (select bar_fav_flag from sss_all_likes where sss_all_likes.bar_id='.$bar_id.' and sss_all_likes.user_id='.$user_id.') as fav_bar,
		                   (select sum(bar_rating) as rat FROM sss_bar_comment  WHERE sss_bar_comment.bar_id = '.$bar_id.' and sss_bar_comment.status="active" and bar_rating) as total_rating,
						   (select count(*) as rat FROM sss_bar_comment  WHERE sss_bar_comment.bar_id = '.$bar_id.' and sss_bar_comment.status="active") as total_commnets');		
		$this->db->from('bars');
		$this->db->join('user_master u','u.user_id=bars.owner_id','left');
		$this->db->where('bar_id',$bar_id);
		$qry = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($qry->num_rows()>0)
		{
			 $result["result"] = $qry->result_array();
			// $result["status"] = "success";
			 return $result;
		}
		//$result["status"] = "fail";
		return $result;
	}	
	
	function getBarReview($bar_id='',$limit=0,$offset=0)
	{
		$result["result"] = array();
		$this->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('bar_comment b');		
		$this->db->join('user_master u','u.user_id=b.user_id','left');
		$this->db->where('b.bar_id',$bar_id);
		$this->db->where('b.is_deleted','no');
		$this->db->order_by('date_added','desc');
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		if($qry->num_rows() >0){
			$result["result"] = $qry->result_array();
			//$result["comment_status"] = "success";
			 return $result;
		}
		//$result["comment_status"] = "fail";
		return $result;
//		print_r($qry);die;
	}
	
	function getBeerServedAtBar($bar_id='',$limit=0,$offset=0)
	{
		$result["result"] = array();
		$this->db->select('beer_directory.beer_name,beer_directory.beer_type,beer_directory.beer_id,beer_directory.producer,beer_directory.city_produced,beer_directory.beer_image');
		$this->db->from('beer_bars');		
		$this->db->join('beer_directory','beer_directory.beer_id=beer_bars.beer_id');
		$this->db->where('beer_bars.bar_id',$bar_id);
		$this->db->where('beer_directory.status','active');
		$this->db->order_by('beer_bars.beer_bar_id','desc');
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		if($qry->num_rows() >0){
			$result["result"] = $qry->result_array();
			//$result["comment_status"] = "success";
			 return $result;
		}
		//$result["comment_status"] = "fail";
		return $result;
//		print_r($qry);die;
	}
	
	function getCocktailServedAtBar($bar_id='',$limit=0,$offset=0)
	{
		$result["result"] = array();
		$this->db->select('cocktail_directory.cocktail_id,cocktail_directory.cocktail_name,cocktail_directory.type,cocktail_directory.served,cocktail_directory.strength,cocktail_directory.cocktail_image');
		$this->db->from('cocktail_bars');		
		$this->db->join('cocktail_directory','cocktail_directory.cocktail_id=cocktail_bars.cocktail_id');
		$this->db->where('cocktail_bars.bar_id',$bar_id);
		$this->db->where('cocktail_directory.status','active');
		$this->db->order_by('cocktail_bars.cocktail_bar_id','asc');
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		
		//echo $this->db->last_query();
		if($qry->num_rows() >0){
			$result["result"] = $qry->result_array();
			//$result["comment_status"] = "success";
			 return $result;
		}
		//$result["comment_status"] = "fail";
		return $result;
		//print_r($qry);die;
	}
	
	function getLiquorServedAtBar($bar_id='',$limit=0,$offset=0)
	{
		$result["result"] = array();
		$this->db->select('liquors.liquor_id,liquors.liquor_title,liquors.type,liquors.proof,liquors.producer,liquors.liquor_image');
		$this->db->from('liquors_bars');		
		$this->db->join('liquors','liquors.liquor_id=liquors_bars.liquor_id');
		$this->db->where('liquors_bars.bar_id',$bar_id);
		$this->db->where('liquors.status','active');
		$this->db->order_by('liquors_bars.liquor_bar_id','desc');
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		if($qry->num_rows() >0){
			$result["result"] = $qry->result_array();
			//$result["comment_status"] = "success";
			 return $result;
		}
		//$result["comment_status"] = "fail";
		return $result;
		//print_r($qry);die;
	}
	
	 function getBarGallery($bar_id='')
	{
		$result["result"] = array();
		$this->db->select_max('bar_gallery_id');
		$this->db->where('bar_id',$bar_id);
		$this->db->where('status','Active');
		$Q = $this->db->get('bar_gallery');
		$row = $Q->row_array();
	     
		$this->db->select('bar_images.image_title,bar_images.bar_image_name,bar_images.image_link,bar_gallery.title,bar_gallery.description');
		$this->db->from('bar_gallery');
		$this->db->join('bar_images','bar_gallery.bar_gallery_id=bar_images.bar_gallery_id');
		$this->db->where(array('bar_gallery.bar_id'=>$bar_id,'status'=>'Active','bar_gallery.bar_gallery_id'=>$row['bar_gallery_id']));
		$this->db->order_by('bar_gallery.bar_gallery_id','desc');
		
		$query = $this->db->get();
		
		//echo $this->db->last_query();
		if($query->num_rows() > 0)
		{
			$result["result"] = $query->result_array();
			 return $result;
		}
		return $result;
	}
	
	 function getBarHours($bar_id='')
	{
		$result["result"] = array();
		$this->db->select('days.days,bar_hours.start_from,bar_hours.start_to,bar_hours.is_closed');
		$this->db->from('bar_hours');
		$this->db->join('days','days.days_id=bar_hours.days_id');
		$this->db->where('bar_hours.bar_id',$bar_id);
		
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$result["result"] = $query->result_array();
			 return $result;
		}
		return $result;
	}
	
	function getBarEvent($bar_id='',$limit=0,$offset=0)
	{
		$result["result"] = array();
		$this->db->select('event_time.*,events.event_title,events.event_id,events.event_desc,events.start_date,
		                  (select event_image_name from sss_event_images where sss_event_images.bar_eventgallery_id=sss_events.event_id ORDER BY sss_event_images.event_image_id ASC LIMIT 1) as event_image');
		$this->db->from('events');
		$this->db->join('event_time','event_time.event_id=events.event_id','left');
		$this->db->where(array('events.bar_id'=>$bar_id,'status'=>'active','is_deleted'=>'no','event_time.eventdate >='=>date('Y-m-d')));
		$this->db->order_by('events.event_id','desc');
		$this->db->group_by('event_time.event_id');
		if($limit>0 && $limit!="")
		{
			$this->db->limit($limit);
		}	
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$result["result"] = $query->result_array();
			 return $result;
		}
		return $result;
	
	}
	
	function getHourByID($id)
	{
		//$this->db->select("*");
		$this->db->select("bar_special_hours.*,beer_directory.beer_name,beer_directory.beer_name,cocktail_directory.cocktail_name,liquors.liquor_title as liquor_name");
		$this->db->from("bar_special_hours");
		$this->db->join("beer_directory",'beer_directory.beer_id=bar_special_hours.sp_beer_id','left');
		$this->db->join("cocktail_directory",'cocktail_directory.cocktail_id=bar_special_hours.sp_cocktail_id','left');
		$this->db->join("liquors",'liquors.liquor_id=bar_special_hours.sp_liquor_id','left');
		$this->db->where("bar_special_hours.rand",$id);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		return array();
	}
        
        function getHappyHourByRAND($id)
	{
		//$this->db->select("*");
		$this->db->select("bar_happy_hour.*,beer_directory.beer_name,beer_directory.beer_name,cocktail_directory.cocktail_name,liquors.liquor_title as liquor_name");
		$this->db->from("bar_happy_hour");
		$this->db->join("beer_directory",'beer_directory.beer_id=bar_happy_hour.sp_beer_id','left');
		$this->db->join("cocktail_directory",'cocktail_directory.cocktail_id=bar_happy_hour.sp_cocktail_id','left');
		$this->db->join("liquors",'liquors.liquor_id=bar_happy_hour.sp_liquor_id','left');
		$this->db->where("bar_happy_hour.rand",$id);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		return array();
	}
        
	function getBeerDetails($beer_id='',$user_id='')
	{
		
		$result["result"] = array();
		$this->db->_protect_identifiers=false;
		$qry = $this->db->select('beer_directory.beer_name,beer_directory.beer_slug,beer_directory.upload_type,beer_directory.video_link,beer_directory.image_default,beer_directory.beer_image,beer_directory.producer,beer_directory.city_produced,
		                   		  beer_directory.beer_type,beer_directory.beer_website,beer_directory.abv,beer_directory.beer_desc,beer_directory.beer_id,
		                          (select like_flag from sss_all_likes where sss_all_likes.beer_id='.$beer_id.' and sss_all_likes.user_id='.$user_id.' group by sss_all_likes.beer_id) as like_beer,
		                          (select beer_fav_flag from sss_all_likes where sss_all_likes.beer_id='.$beer_id.' and sss_all_likes.user_id='.$user_id.' group by sss_all_likes.beer_id) as fav_beer')
		                 ->from('beer_directory')
		                 ->where(array('status'=>'active','beer_id'=>$beer_id))
		                 ->get();
						   
		if($qry->num_rows()>0)
		{
			 $result["result"] = $qry->result_array();
			// $result["status"] = "success";
			 return $result;
		}
		//$result["status"] = "fail";
		return $result;			   
	}

    function getBeerComments($beer_id='',$limit=0,$offset=0,$sub_c='')
	{
		$result["result"] = array();
		$this->db->select('b.beer_comment_id,b.beer_id,u.profile_image,u.first_name,u.last_name,
		 				   b.user_id,b.comment_title,b.comment,b.comment_video,b.comment_image,b.master_comment_id,
		 				   b.date_added,
		 				    (SELECT sss_all_likes.like_flag FROM sss_all_likes  WHERE sss_all_likes.user_id = '.@$this->input->post('user_id').' and sss_all_likes.beer_comment_id = b.beer_comment_id) as is_like,
				 	      (SELECT count(sss_all_likes.like_id) FROM sss_all_likes  WHERE sss_all_likes.like_flag = 1 and  sss_all_likes.beer_comment_id = b.beer_comment_id group by sss_all_likes.beer_id ) as total_like');
		$this->db->from('beer_comment b');		
		$this->db->join('user_master u','u.user_id=b.user_id','left');
		$this->db->where('b.beer_id',$beer_id);
		$this->db->where('b.is_deleted',0);
		$this->db->where('b.status','active');
		if($sub_c==1)
		{
			$this->db->where('b.master_comment_id !=',0);
		}
		else
		{
			$this->db->where('b.master_comment_id',$sub_c);	
		}
		$this->db->order_by('date_added','desc');
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		if($qry->num_rows()>0)
		{
			 $result["result"] = $qry->result_array();
			 return $result;
		}
		return $result;	
	}
	
	function getCocktailDetails($cocktail_id='',$user_id='')
	{
		
		$qry = $this->db->select('cocktail_directory.cocktail_id,cocktail_directory.cocktail_slug,cocktail_directory.upload_type,cocktail_directory.video_link,cocktail_directory.image_default,cocktail_directory.cocktail_name,cocktail_directory.base_spirit,cocktail_directory.type,
		                   cocktail_directory.served,cocktail_directory.strength,cocktail_directory.difficulty,cocktail_directory.how_to_make_it,
		                   cocktail_directory.how_to_make_it,cocktail_directory.ingredients,cocktail_directory.cocktail_image,
						   (select like_flag from sss_all_likes where sss_all_likes.cocktail_id='.$cocktail_id.' and sss_all_likes.user_id='.$user_id.' group by sss_all_likes.cocktail_id) as like_cocktail,
		                   (select fav_flag from sss_all_likes where sss_all_likes.cocktail_id='.$cocktail_id.' and sss_all_likes.user_id='.$user_id.' group by sss_all_likes.cocktail_id) as fav_cocktail')
		                 ->from('cocktail_directory')
		                 ->where(array('status'=>'active','cocktail_id'=>$cocktail_id))
		                 ->get();
						   
		if($qry->num_rows()>0)
		{
			 $result["result"] = $qry->result_array();
			 return $result;
		}
		return array();				   
	}

    function getCocktailComments($cocktail_id='',$limit='',$offset='',$sub_c='')
	{
		
		$result["result"] =array();	
		$this->db->select('c.cocktail_comment_id,c.cocktail_id,u.profile_image,u.first_name,u.last_name,
		 				   c.user_id,c.comment_title,c.comment,c.comment_image,c.comment_video,c.master_comment_id,
		 				   c.date_added,
		 				     (SELECT sss_all_likes.like_flag FROM sss_all_likes  WHERE sss_all_likes.user_id = '.@$this->input->post('user_id').' and sss_all_likes.cocktail_comment_id = c.cocktail_comment_id) as is_like,
				 	      (SELECT count(sss_all_likes.like_id) FROM sss_all_likes  WHERE sss_all_likes.like_flag = 1 and sss_all_likes.cocktail_comment_id = c.cocktail_comment_id group by sss_all_likes.cocktail_id) as total_like');
		$this->db->from('cocktail_comment c');		
		$this->db->join('user_master u','u.user_id=c.user_id','left');
		$this->db->where('c.cocktail_id',$cocktail_id);
		$this->db->where('c.is_deleted',0);
		$this->db->where('c.status','active');
		//$this->db->where('c.master_comment_id',$sub_c);
		if($sub_c==1)
		{
			$this->db->where('c.master_comment_id !=',0);
		}
		else
		{
			$this->db->where('c.master_comment_id',$sub_c);	
		}
		$this->db->order_by('c.date_added','desc');
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		
		if($qry->num_rows()>0)
		{
			 $result["result"] = $qry->result_array();
			 return $result;
		}
		return $result;		
	}
	function getLiquorDetails($liquor_id='',$user_id='')
	{
		$qry = $this->db->select('liquors.liquor_id,liquors.liquor_slug,liquors.upload_type,liquors.video_link,liquors.image_default,liquors.liquor_title,liquors.liquor_description,liquors.type,
		                   liquors.proof,liquors.producer,liquors.country,liquors.liquor_image,
						    (select like_flag from sss_all_likes where sss_all_likes.liquor_id='.$liquor_id.' and sss_all_likes.user_id='.$user_id.' group by sss_all_likes.liquor_id) as like_liquor,
		                   (select fav_flag from sss_all_likes where sss_all_likes.liquor_id='.$liquor_id.' and sss_all_likes.user_id='.$user_id.' group by sss_all_likes.liquor_id) as fav_liquor')
						   
		                 ->from('liquors')
		                 ->where(array('status'=>'active','liquor_id'=>$liquor_id))
		                 ->get();
						   
		if($qry->num_rows()>0)
		{
			 $result["result"] = $qry->result_array();
			 return $result;
		}
		return array();				   
	}
	
	 function getLiquorComments($liquor_id='',$limit='',$offset='',$sub_c='')
	{
		$result["result"] =array();	
		$this->db->select('l.liquor_comment_id,l.liquor_id,u.profile_image,u.first_name,u.last_name,
		 				   l.user_id,l.comment_title,l.comment,l.comment_image,l.comment_video,l.master_comment_id,
		 				   l.date_added,
		 				     (SELECT sss_all_likes.like_flag FROM sss_all_likes  WHERE sss_all_likes.user_id = '.@$this->input->post('user_id').' and sss_all_likes.liquor_comment_id = l.liquor_comment_id) as is_like,
				 	      (SELECT count(sss_all_likes.like_id) FROM sss_all_likes  WHERE sss_all_likes.like_flag = 1 and sss_all_likes.liquor_comment_id =l.liquor_comment_id group by sss_all_likes.liquor_id ) as  total_like ');
		$this->db->from('liquor_comment l');		
		$this->db->join('user_master u','u.user_id=l.user_id','left');
		$this->db->where('l.liquor_id',$liquor_id);
		$this->db->where('l.is_deleted',0);
		$this->db->where('l.status','active');
		if($sub_c==1)
		{
			$this->db->where('l.master_comment_id !=',0);
		}
		else
		{
			$this->db->where('l.master_comment_id',$sub_c);	
		}
		$this->db->order_by('l.date_added','desc');
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		
		if($qry->num_rows()>0)
		{
			 $result["result"] = $qry->result_array();
			 return $result;
		}
		return $result;		
	}
	
	function getTaxiDetails($taxi_id='',$user_id='')
	{
		$qry = $this->db->select('taxi_directory.taxi_id,taxi_directory.city,taxi_directory.cmpn_website,taxi_directory.taxi_desc,taxi_directory.taxi_owner_id,taxi_directory.taxi_company,taxi_directory.address,
		                   		  taxi_directory.state,taxi_directory.phone_number,taxi_directory.taxi_image,
		                   		  taxi_directory.taxi_owner_id,taxi_directory.cmpn_zipcode,
		                          user_master.first_name,user_master.last_name,user_master.mobile_no')
		                 ->from('taxi_directory')
						 ->join('user_master','user_master.user_id=taxi_directory.taxi_owner_id','left')
		                 ->where(array('taxi_directory.status'=>'active','taxi_directory.taxi_id'=>$taxi_id))
		                 ->get();
						   
		if($qry->num_rows()>0)
		{
			 $result["result"] = $qry->result_array();
			// $result["status"] = "success";
			 return $result;
		}
		//$result["status"] = "fail";
		return array();				   
	}
	function get_user_info($user_id='')
	{
		$CI =& get_instance();
		$query = $CI->db->get_where("user_master",array('user_id'=>$user_id));
		return $query->row_array();
	}
	
	function getFavoriteBar($offset="",$limit="",$keyword='',$user_id='',$type='')
	{
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
		$this->db->select('bars.bar_title,bars.bar_logo,bars.bar_id,bars.bar_type,all_likes.date_added as date_added');
		$this->db->from('all_likes');
		$this->db->join('bars','bars.bar_id=all_likes.bar_id');
		$this->db->where(array('all_likes.user_id'=>$user_id,'all_likes.bar_id !='=>'','all_likes.bar_fav_flag'=>1,'bars.is_deleted'=>'0'));
		if($keyword!='' && $keyword!='1V1')
		{
		$this->db->like("bars.bar_title",$keyword);
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('bars.bar_title',$val);
					}	
				}
		}		  
		$this->db->order_by('all_likes.like_id','desc');
		
		if($type=='result')
		{
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($qry->num_rows()>0)
		{
			 //$result["result"] = 'success';
			 $result["result"] = $qry->result_array();
			 return $result;
		}
		}
		else {
			$qry = $this->db->get();
			return $qry->num_rows(); 
		}
		//$result["status"] = "fail";
		$result["status"] = "fail";
		return $result;
	}
	
	function getFavoriteBeer($offset="",$limit="",$keyword='',$user_id='',$type='')
	{
		$this->db->select('beer_directory.beer_name,beer_directory.beer_image,beer_directory.producer as brewed_by,beer_directory.beer_id,beer_directory.beer_type,all_likes.date_added as date_added');
		$this->db->from('all_likes');
		$this->db->join('beer_directory','beer_directory.beer_id=all_likes.beer_id');
		$this->db->where(array('all_likes.user_id'=>$user_id,'all_likes.beer_id !='=>'','all_likes.beer_fav_flag'=>1,'beer_directory.is_deleted'=>'no'));
		if($keyword!='' && $keyword!='1V1')
		{
		$this->db->like("beer_directory.beer_name",$keyword);
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('beer_directory.beer_name',$val);
					}	
				}
		}		  
		$this->db->order_by('all_likes.like_id','desc');
		if($type=='result')
		{
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($qry->num_rows()>0)
		{
			// $result["result"] = 'success';
			 $result["result"] = $qry->result_array();
			 return $result;
		}
		}
		else {
			$qry = $this->db->get();
			return $qry->num_rows();
		}
		//$result["status"] = "fail";
		$result["status"] = "fail";
		return $result;
	}

	function getFavoriteCocktail($offset="",$limit="",$keyword='',$user_id='',$type='')
	{
		
		$this->db->select('cocktail_directory.cocktail_name,cocktail_directory.cocktail_image,cocktail_directory.cocktail_id,cocktail_directory.type,all_likes.date_added as date_added');
		$this->db->from('all_likes');
		$this->db->join('cocktail_directory','cocktail_directory.cocktail_id=all_likes.cocktail_id');
		$this->db->where(array('all_likes.user_id'=>$user_id,'all_likes.cocktail_id !='=>'','all_likes.fav_flag'=>1,'cocktail_directory.is_deleted'=>'no'));
		if($keyword!='' && $keyword!='1V1')
		{
		$this->db->like("cocktail_directory.cocktail_name",$keyword);
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('cocktail_directory.cocktail_name',$val);
					}	
				}
		}		  
		$this->db->order_by('all_likes.like_id','desc');
		if($type=='result')
		{
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($qry->num_rows()>0)
		{
			// $result["result"] = 'success';
			 $result["result"] = $qry->result_array();
			 return $result;
		}
		}
		else {
			$qry = $this->db->get();
			return $qry->num_rows();
		}
		//$result["status"] = "fail";
		$result["status"] = "fail";
		return $result;
	}


	function getFavoriteLiquor($offset="",$limit="",$keyword='',$user_id='',$type='')
	{
		
		$this->db->select('liquors.liquor_title,liquors.liquor_id,liquors.liquor_image,liquors.producer as brewed_by,liquors.type,all_likes.date_added as date');
		$this->db->from('all_likes');
		$this->db->join('liquors','liquors.liquor_id=all_likes.liquor_id');
		$this->db->where(array('all_likes.user_id'=>$user_id,'all_likes.liquor_id !='=>'','all_likes.fav_flag'=>1,'liquors.is_deleted'=>'no'));
		if($keyword!='' && $keyword!='1V1')
		{
		$this->db->like("liquors.liquor_title",$keyword);
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('liquors.liquor_title',$val);
					}	
				}
		}		  
		$this->db->order_by('all_likes.like_id','desc');
		if($type=='result')
		{
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		
		if($qry->num_rows()>0)
		{
			 $result["result"] = 'success';
			 $result["result"] = $qry->result_array();
			 return $result;
		}
		}
		else {
			$qry = $this->db->get();
			return $qry->num_rows();
		}
		//$result["status"] = "fail";
		$result["status"] = "fail";
		return $result;
	}
	
	
	function user_change_password_api($user_id,$old_pass,$new_pass)
	{
		
		$query = $this->db->get_where("user_master",array("user_id"=>$user_id,"user_type"=>'user',"password"=>md5($old_pass)));
		if($query->num_rows() > 0)
		{
			$data["password"] = md5($new_pass);
			$this->db->where('user_id',$user_id);
			$this->db->update('user_master',$data);
			//echo $this->db->last_query(); die;
			$data = array(
						'status'=>'success',
					  );
			return $data;	
		}
		else {
			$data = array(
						'status'=>'old_password_did_not_match_with_current_password',
					  );
			return $data;
		}	
	}
	
	function getBarGalleryDetail($offset="",$limit="",$keyword='',$user_id='',$type='')
	{
		
		$this->db->select('*');
		$this->db->from('album');
		$this->db->where(array('bar_id'=>$user_id));
		if($keyword!='' && $keyword!='1V1')
		{
		$this->db->like("title",$keyword);	
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('title',$val);
					}	
				}
		}		  
		$this->db->order_by('bar_gallery_id','desc');
		if($type=='result')
		{
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($query->num_rows() > 0)
		{
			 $result["result"] = 'success';
			 $result["result"] = $query->result_array();
			 return $result;
		}
		}
		else {
			$query = $this->db->get();
			return $query->num_rows();
		}
		return array();
		
	}
	function getOneGallery($id)
	 {
	 	  $this->db->select('*');
		  $this->db->from('album');
		  $this->db->where('bar_gallery_id',$id);
		  $query = $this->db->get();
		  return $query->row_array(); 
	 }
	 
	function getGalleryImages($id)
	{
	 	 $this->db->select('*');
		 $this->db->from('album_images');
		 $this->db->where('bar_gallery_id',$id);
		 $query = $this->db->get();
		 if($query->num_rows()>0)
		 {
		 	return $query->result_array();
		 }
		 return array();
	 
	}
	
	function bar_gallery_insert()
	{
		$this->load->library('upload');
		$data["title"] = $this->input->post('title');
		$data["description"] = $this->input->post('description');		
		$data["status"] = $this->input->post('status');
		$data["bar_id"] = $this->input->post('user_id');
		$data["date_added"] = date("Y-m-d h:i:s");

		//date($site_setting->date_format,strtotime($rs->product_date));
        
		$this->db->insert('album',$data);	
		$gallery_id = mysql_insert_id();
		
		$datatick['image_title']=$this->input->post('image_title');
		
	if($_FILES){
			if(isset($_FILES['photo_image']) && count($_FILES['photo_image']['name'])>0){
				foreach ($_FILES['photo_image']['name'] as $key => $value) {
					if($_FILES['photo_image']['name'][$key]!=''){
        	
			$rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['photo_image']['name'][$key];
             $_FILES['userfile']['type']     =   $_FILES['photo_image']['type'][$key];
             $_FILES['userfile']['tmp_name'] =   $_FILES['photo_image']['tmp_name'][$key];
             $_FILES['userfile']['error']    =   $_FILES['photo_image']['error'][$key];
             $_FILES['userfile']['size']     =   $_FILES['photo_image']['size'][$key];
   
			$config['file_name'] = $rand.'bargallery';
			
            $config['upload_path'] = base_path().'upload/bar_gallery_orig/';
			
            $config['allowed_types'] = '*';  
 
            $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				echo $error =  $this->upload->display_errors();
				die;   
		
			  } 
			   

			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		      $gd_var='gd2';
             $this->image_lib->clear();
		   	
			 resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big/'.$picture['file_name'],394,290);
              
			
			$this->image_lib->clear();
		   
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb/'.$picture['file_name'],65,47);
          
		  $this->image_lib->clear();
		   
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big650by470/'.$picture['file_name'],650,470);
          
             $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big183by183/'.$picture['file_name'],183,183);
              $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big140by140/'.$picture['file_name'],140,140);
              
			  $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big600by600/'.$picture['file_name'],600,600);
              
			  $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big200by200/'.$picture['file_name'],200,200);
             
			   $this->image_lib->clear();
			   
			     resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big840by720/'.$picture['file_name'],840,720);
             
			   $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big912by525/'.$picture['file_name'],912,525);
            
              $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big261by261/'.$picture['file_name'],261,261);
            
			$company_image=$picture['file_name'];
			$pg=array('bar_gallery_id'=>$gallery_id,'bar_image_name'=>$company_image,'image_title'=>$datatick['image_title'][$key]);
			//print_r($pg);
			//die;
			$this->db->insert('album_images',$pg);
			
			 } 
		   }
		}
		}
	}

	 function bar_gallery_update()
	 {
		$this->load->library('upload');
		$data["title"] = $this->input->post('title');
		$data["description"] = $this->input->post('description');		
		$data["status"] = $this->input->post('status');
		$data["gallery"] = 'gallery';
		$data["bar_id"] =  $this->input->post('user_id');
		
		$this->db->where('bar_gallery_id',$this->input->post('bar_gallery_id'));
		$this->db->update('album',$data);
		$product_image = '';
		$img_id = $this->input->post('image_id');
		$preImg=$this->input->post('pre_img');
		$datatick['image_title']=$this->input->post('image_title');
			/***********INsert Gallery************/
		// echo "<pre>";
		//print_r($_POST);
		 //echo "<pre>";
		 //print_r($_FILES);
		 //print_r($preImg);
		 //die;
		if($_FILES){
			if(isset($_FILES['photo_image']) && count($_FILES['photo_image']['name'])>0){
				foreach ($_FILES['photo_image']['name'] as $key => $value) {
					if($_FILES['photo_image']['name'][$key]!='' && $_FILES['photo_image']['size'][$key]>0){
			//echo $img_id[$key];
					//	die;
			$rand=rand(0,100000);   
             $_FILES['userfile']['name']     =   $_FILES['photo_image']['name'][$key];
             $_FILES['userfile']['type']     =   $_FILES['photo_image']['type'][$key];
             $_FILES['userfile']['tmp_name'] =   $_FILES['photo_image']['tmp_name'][$key];
             $_FILES['userfile']['error']    =   $_FILES['photo_image']['error'][$key];
             $_FILES['userfile']['size']     =   $_FILES['photo_image']['size'][$key];
   
			$config['file_name'] = $rand.'bargallery';
			
            $config['upload_path'] = base_path().'upload/bar_gallery_orig/';
			
            $config['allowed_types'] = '*';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				echo $error =  $this->upload->display_errors();die;   
			  } 
			   

			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   
              $this->image_lib->clear();
		   	
			
					$gd_var='gd2';
				
		 $this->image_lib->clear();
		   	
			 resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big/'.$picture['file_name'],394,290);
              
			
			$this->image_lib->clear();
		   
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb/'.$picture['file_name'],65,47);
          
		  $this->image_lib->clear();
		   
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big650by470/'.$picture['file_name'],650,470);
          
             $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big183by183/'.$picture['file_name'],183,183);
              $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big140by140/'.$picture['file_name'],140,140);
              
			  $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big600by600/'.$picture['file_name'],600,600);
              
			  $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big200by200/'.$picture['file_name'],200,200);
             
			   $this->image_lib->clear();
			   
			     resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big840by720/'.$picture['file_name'],840,720);
             
			   $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big912by525/'.$picture['file_name'],912,525);
             $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big261by261/'.$picture['file_name'],261,261);
            
             
			$product_image=$picture['file_name'];
				
				
				if(isset($preImg[$key]) && $preImg[$key]!='')
				{
							if(file_exists(base_path().'upload/bar_gallery_thumb_big840by720/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bar_gallery_thumb_big840by720/'.$preImg[$key]);
							}
							if(file_exists(base_path().'upload/bar_gallery_thumb_big600by600/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bar_gallery_thumb_big600by600/'.$preImg[$key]);
							}
							if(file_exists(base_path().'upload/bar_gallery_thumb_big200by200/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bar_gallery_thumb_big200by200/'.$preImg[$key]);
							}
							if(file_exists(base_path().'upload/bar_gallery_thumb_big140by140/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bar_gallery_thumb_big140by140/'.$preImg[$key]);
							}
							if(file_exists(base_path().'upload/bar_gallery_thumb_big183by183/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bar_gallery_thumb_big183by183/'.$preImg[$key]);
							}
							if(file_exists(base_path().'upload/bar_gallery_orig/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bar_gallery_orig/'.$preImg[$key]);
							}
								if(file_exists(base_path().'upload/bar_gallery_thumb_big650by470/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bar_gallery_thumb_big650by470/'.$preImg[$key]);
							}
							if(file_exists(base_path().'upload/bar_gallery_thumb/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bar_gallery_thumb/'.$preImg[$key]);
							}
							
							if(file_exists(base_path().'upload/bar_gallery_thumb_big/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bar_gallery_thumb_big/'.$preImg[$key]);
							}
				}
				
				}
				else
				{
					$product_image = $preImg[$key];
				}
				
				if($product_image!=''){
				$pg=array('bar_gallery_id'=>$this->input->post('bar_gallery_id'),'bar_image_name'=>$product_image,'image_title'=>$datatick['image_title'][$key]);
				if(isset($img_id[$key]) && $img_id[$key]>0){
					$this->db->where('bar_image_id',$img_id[$key]);
					$this->db->update('album_images',$pg);
				}else{
					$this->db->insert('album_images',$pg);
				}
				}
				
			} 
			}
				}
	 }

	function getsetting($id)
	{
		$query = $this->db->get_where('user_setting',array('user_id'=>$id));
		//echo $this->db->last_query();
		return $query->row_array();
	}
	
	function updateusersetting()
	{
		$data=array(
			'fname'=>$this->input->post('fname'),
			'user_id'=>$this->input->post('user_id'),
			'lname'=>$this->input->post('lname'),
			'email1'=>$this->input->post('email1'),
			'gender1'=>$this->input->post('gender1'),
			'address1'=>$this->input->post('address1'),
			'mnum'=>$this->input->post('mnum'),
			'abt'=>$this->input->post('abt'),
			'pic'=>$this->input->post('pic'),
			'album'=>$this->input->post('album'),
		);
		$this->db->where('setting_id',$this->input->post('setting_id'));
		$this->db->update('user_setting',$data);
		//return $this->input->post('setting_id');
	}

	function insertusersetting()
	{
		$data=array(
			'fname'=>$this->input->post('fname'),
			'user_id'=>$this->input->post('user_id'),
			'lname'=>$this->input->post('lname'),
			'email1'=>$this->input->post('email1'),
			'gender1'=>$this->input->post('gender1'),
			'address1'=>$this->input->post('address1'),
			'mnum'=>$this->input->post('mnum'),
			'abt'=>$this->input->post('abt'),
			'pic'=>$this->input->post('pic'),
			'album'=>$this->input->post('album'),
		);
		//$this->db->where('setting_id',$this->input->post('setting_id'));
		$this->db->insert('user_setting',$data);
		$id = mysql_insert_id();
		//return $id;
	}

	 function getGallery()
	{
		$this->db->select('*');
		$this->db->from('bar_gallery');
		$this->db->where(array('bar_gallery.bar_id'=>0,'status'=>'Active'));
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		return '';
	}
	 function getBarGalleryAll123()
	{
		$this->db->select('*');
		$this->db->from('bar_images');
		//$this->db->where(array('bar_gallery_id'=>$bar_gallery_id));
		
		$query = $this->db->get();
		
		
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		return array();
	}
	
	 function getGalByID($bar_gallery_id)
	{
		$this->db->select('*');
		$this->db->from('bar_images');
		$this->db->where(array('bar_gallery_id'=>$bar_gallery_id));
		
		$query = $this->db->get();
		
		
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		return array();
	}
	
	 function getAlbumByID($bar_gallery_id)
	{
		$this->db->select('*');
		$this->db->from('album_images');
		$this->db->where(array('bar_gallery_id'=>$bar_gallery_id));
		
		$query = $this->db->get();
		
		
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		return array();
	}
	function user_logout($user_id,$device_id,$unique_code){
			$this->db->delete('device_master',array('user_id'=>$user_id,'device_name'=>$device_id,'unique_code'=>$unique_code));
			return 1;
	 }
         
         function user_logout_hotfix($device_id,$unique_code){
                        $this->db->delete('device_master',array('device_name'=>$device_id, 'unique_code'=>$unique_code));
                        
                        $this->db->select('*');
                        $this->db->from('device_master');
                        $this->db->where(array('device_name'=>$device_id, 'unique_code'=>$unique_code));

                        $query = $this->db->get();


                        if($query->num_rows() > 0)
                        {
                                return 0;
                        }
			return 1;
	 }
	
	function auto_suggest_bar($q){
		$this->db->like('bar_title',$q,'after');
		//$this->db->select('bar_title,bar_id,bar_type,address,city,state,zipcode,phone,owner_id,lat,lang,email,bar_type,bar_logo');
		
		$this->db->select('bars.lat,bars.lang,bars.bar_title,bars.bar_id,bars.bar_type,bars.bar_desc,bars.owner_id,bars.address,bars.city,bars.state,bars.phone,bars.zipcode,bars.email,
		                   bars.bar_logo, (SELECT sum(bar_rating) AS rat FROM sss_bar_comment  WHERE sss_bar_comment.bar_id = sss_bars.bar_id and sss_bar_comment.status="active" and bar_rating) as total_rating, (SELECT count(*) AS rat FROM sss_bar_comment  WHERE sss_bar_comment.bar_id = sss_bars.bar_id and sss_bar_comment.status="active") as total_commnets');
		
		$this->db->from('bars');
		$this->db->where('status','active');
		$this->db->limit(4);
		$query = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
		return  array();
	}
     function reset_password($forget_password_code,$password)
	  {
	        $query = $this->db->get_where('user_master',array('forget_password_code'=>$forget_password_code));
	         if($query->num_rows() > 0)
	        {
	              $data=array('password'=>md5($password));
	              $this->db->where('forget_password_code',$forget_password_code);
	              $this->db->update('user_master',$data);
	              
	              $data=array('forget_password_code'=>'');
	              $this->db->where('forget_password_code',$forget_password_code);
	              $this->db->update('user_master',$data);
	              $data = array(
		            'status'=>'success'
		            );
		            return $data; 
	              
	        }
	         else {
	             $data = array(
	                'status'=>'fail'
	                );
	                return $data; 
	         }
	  }
	  
	function getAllEvent($offset = 0,$limit = 0,$sort_by= '',$sort_type = '',$keyword = 0,$alpha ='',$bar_id,$type)
	{
		
		$result = array();
		// $this->db->select('*,event_time(select event_image_name from sss_event_images where sss_event_images.bar_eventgallery_id=sss_events.event_id ORDER BY sss_event_images.event_image_id ASC LIMIT 1) as event_image');
		// $this->db->from("events");
		// $this->db->from("event_time",'event_time.event_id=events.event_id');
		// $this->db->where('status','active');
		// $this->db->where('event_time.eventdate >=',date('Y-m-d'));
		// $this->db->where('is_deleted','no');
		
		
		$this->db->select('event_time.*,events.event_title,events.event_id,events.event_desc,events.start_date,
		                  (select event_image_name from sss_event_images where sss_event_images.bar_eventgallery_id=sss_events.event_id ORDER BY sss_event_images.event_image_id ASC LIMIT 1) as event_image');
		$this->db->from('events');
		$this->db->join('event_time','event_time.event_id=events.event_id','left');
		$this->db->where(array('events.bar_id'=>$bar_id,'status'=>'active','is_deleted'=>'no','event_time.eventdate >='=>date('Y-m-d')));
		$this->db->order_by('events.event_id','asc');
		$this->db->group_by('event_time.event_id');
		
		if($bar_id>0)
		{
			$this->db->where('bar_id',$bar_id);
		}
		else {
			$this->db->where('bar_id','0');
		}
		if($alpha != "" && $alpha != "no")
		{
		   $this->db->like("event_title",$alpha,"after");
		}
		
		if($keyword != '0')
		{
			$this->db->like("event_title",$keyword);
		   
		}
		
		$this->db->order_by('event_time.eventdate','asc');
		$this->db->group_by('events.event_id');
		if($type=='result')
		{
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		
		if($qry->num_rows()>0)
		{
			 $result["result"] = 'success';
			 $result["result"] = $qry->result_array();
			 return $result;
		}
		}
		else {
			$qry = $this->db->get();
			//echo $this->db->last_query();
			return $qry->num_rows();
		}
		//$result["status"] = "fail";
		//$result["status"] = "fail";
		return $result;
	}
	
	function get_one_bar($id = 0)
	{
		$this->db->select('*,bars.address as address,bars.city as city,bars.state as state,bars.zipcode as zipcode,bars.website as website,bars.twitter_link as twitter_link,bars.linkedin_link as linkedin_link,bars.pinterest_link as pinterest_link');		
		$this->db->from('bars');
		$this->db->join('user_master u','u.user_id=bars.owner_id','left');
		$this->db->where('bar_id',$id);
		$qry = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($qry->num_rows()>0)
		{
			 return $qry->row_array();
		}
		return array();
	}
	
	function getEventDetails($id = 0)
	{
		//$result["result"] = array();
		$this->db->_protect_identifiers=false;
		
		$this->db->select('bars.bar_title,events.event_category,events.event_id,events.event_title,events.event_desc,events.start_date,events.end_date,events.address,events.city,events.state,
		                   events.phone,events.zipcode');		
		$this->db->from('events');
		$this->db->join('bars','bars.bar_id=events.bar_id','left');
		//$this->db->join('user_master u','u.user_id=bars.owner_id','left');
		$this->db->where('event_id',$id);
		$qry = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($qry->num_rows()>0)
		{
			return $qry->row_array();
			// $result["status"] = "success";
			// return $result;
		}
		//$result["status"] = "fail";
		return $result;
	}

 	function getEventGallery($event_id)
	{
		$this->db->select('*');
		$this->db->from('event_images');
		$this->db->where(array('bar_eventgallery_id'=>$event_id));
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		return array();
	}
	
	function getGal()
	{
		$this->db->select('bar_gallery.bar_gallery_id,bar_images.image_title,bar_images.bar_image_name,bar_images.image_link,bar_gallery.title,bar_gallery.description');
		$this->db->from('bar_gallery');
		$this->db->join('bar_images','bar_gallery.bar_gallery_id=bar_images.bar_gallery_id');
		$this->db->where(array('bar_gallery.bar_id'=>0,'status'=>'Active'));
		$this->db->order_by('reorder','asc');
		$this->db->group_by('bar_images.bar_gallery_id');
		$query = $this->db->get();
		
		//echo $this->db->last_query();
		if($query->num_rows() > 0)
		{
			$result["result"] = $query->result_array();
			 return $result;
		}
		return $result;
	}
	
	   function getOneImageGallery($id)
	{
		$query = $this->db->get_where('album_images',array('bar_image_id'=>$id));
		return $query->row();
	}
	function get_one_user($id)
	{
		$this->db->select("*");
		$this->db->from('user_master');
		$this->db->where('user_id',$id);
		$this->db->order_by('user_id','desc');
		$this->db->limit('1','0');
		$query=$this->db->get();
		
		if($query->num_rows()>0)
		{
			
			return $query->row_array();
		}
		return;
	}	

 function getalbumgallery($id=0)
	{
		
		$this->db->select('*');
		$this->db->from('album');
		//$this->db->join('album_images','album.bar_gallery_id=album_images.bar_gallery_id');
		$this->db->where(array('album.bar_id'=>$id,'status'=>'Active'));
		$this->db->order_by('bar_gallery_id', 'desc');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		return 0;
	}
	
  function getConttactusInfo()
  {
  		$this->db->select("site_name, site_email, site_address");
		$this->db->from('site_setting');
		$query=$this->db->get();
		
		if($query->num_rows()>0)
		{
			
			return $query->row_array();
		}
		return;
  }	

  function send_inquiry()
  {
  				$data['site_setting'] = site_setting();
  				$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Contact Us'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = $data['site_setting']->site_email;
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{name}', $this->input->post('name'), $email_message);
				$email_message = str_replace('{email}', $this->input->post('email'), $email_message);
				$email_message = str_replace('{subject}', $this->input->post('subject'), $email_message);
				$email_message = str_replace('{message}', $this->input->post('message'), $email_message);
				$str = $email_message;
				if($email_temp->status=='active'){
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
				}
  }

 function get_page_info($slug='')
  {
    $CI =& get_instance();
    $query=$CI->db->get_where('pages',array('slug'=>$slug,'active'=>'1'));
    if($query->num_rows>0)
    {
        return $query->row_array();
    }
    return '';
  } 
  
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
	function save_social_data($data)
	{
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


	function register_device_android()
	{
		
		$this->db->delete("registered_android",array('device_id'=>$this->input->post('device_id')));
		
		$data['user_id'] = $this->input->post('user_id');
		$data['gcm_regid'] = $this->input->post('gcm_regid');
		$data['device_id'] = $this->input->post('device_id');
		$data['android_session'] = '1';
		$data['date_added'] = date('Y-m-d H:i:s');
		
		$this->db->insert("registered_android",$data);
		//echo $this->db->last_query(); die;
		$id = $this->db->insert_id();
		
		
		$s	=	'android';
		
		/*$query = $this->db->get_where("{$s}_stored_notification",array('user_id' => $this->input->post('user_id')));
		if($query->num_rows()>0)
		{
			foreach($query->result() as $q)
			{
			sendPushNotificationAndroid($this->input->post('user_id'),unserialize($q->notification));
			}
			$this->db->delete("{$s}_stored_notification",array('user_id'=>$this->input->post('user_id')));
		} */
		
		
		return	$id	?	$id	:	FALSE;
	}

	function register_device_iphone()
	{
		if($this->input->post('token_id') && $this->input->post('token_id')!='(null)')
		{
			$this->db->delete("registered_iphone",array('device_id'=>$this->input->post('device_id')));
			
			$data['user_id'] = $this->input->post('user_id');
			$data['token_id'] = $this->input->post('token_id');
			$data['device_id'] = $this->input->post('device_id');
			$data['iphone_session'] = '1';
			$data['date_added'] = date('Y-m-d H:i:s');
	
			$this->db->insert("registered_iphone",$data);
			//echo $this->db->last_query(); die;
			//lq($this,0,1);
			$id = $this->db->insert_id();
			
			
			$s	=	'iphone';
		
		/*$query = $this->db->get_where("{$s}_stored_notification",array('user_id' => $this->input->post('user_id')));
		if($query->num_rows()>0)
		{
			foreach($query->result() as $q)
			{
			sendPushNotificationiPhone($this->input->post('user_id'),unserialize($q->notification));
			}
			$this->db->delete("{$s}_stored_notification",array('user_id'=>$this->input->post('user_id')));
		} */
			
			
			return	$id	?	$id	:	FALSE;	
		}
		return	FALSE;
	}

 function get_bar_hour($bar_id)
	{
		$this->db->select("bar_special_hours.*,beer_directory.beer_name,beer_directory.beer_name,cocktail_directory.cocktail_name,liquors.liquor_title as liquor_name");
        $this->db->from("bar_special_hours");
		$this->db->join("beer_directory",'beer_directory.beer_id=bar_special_hours.sp_beer_id','left');
		$this->db->join("cocktail_directory",'cocktail_directory.cocktail_id=bar_special_hours.sp_cocktail_id','left');
		$this->db->join("liquors",'liquors.liquor_id=bar_special_hours.sp_liquor_id','left');
		$this->db->where('bar_special_hours.bar_id',$bar_id);
		$this->db->order_by('day','asc');
		$this->db->group_by('rand');
		//$this->db->order_by('days', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $query =  $this->db->get();
		//echo $this->db->last_query();
       
		// die;
		if($query->num_rows()>0)
		{
			 return $query->result_array();
		}
		 return array();
	}
        
        function get_bar_happy_hour($bar_id)
	{
		$this->db->select("bar_happy_hour.*,beer_directory.beer_name,beer_directory.beer_name,cocktail_directory.cocktail_name,liquors.liquor_title as liquor_name");
        $this->db->from("bar_happy_hour");
		$this->db->join("beer_directory",'beer_directory.beer_id=bar_happy_hour.sp_beer_id','left');
		$this->db->join("cocktail_directory",'cocktail_directory.cocktail_id=bar_happy_hour.sp_cocktail_id','left');
		$this->db->join("liquors",'liquors.liquor_id=bar_happy_hour.sp_liquor_id','left');
		$this->db->where('bar_happy_hour.bar_id',$bar_id);
//		$this->db->order_by('day','asc');
		$this->db->group_by('rand');
		//$this->db->order_by('days', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $query =  $this->db->get();
		//echo $this->db->last_query();
       
		// die;
		if($query->num_rows()>0)
		{
			 return $query->result_array();
		}
		 return array();
	}
	

    function suggestbeer_insert($beer_name,$beer_state,$beer_country,$beer_desc,$beer_type,$abv,$producer,$beer_website,$city_produced)
	{
		 $slug=getBeerSlug($this->input->post('beer_name'));	
		$beer_image = '';
		$image_setting = image_setting();
		 if(isset($_FILES['beer_image']) && $_FILES['beer_image']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['beer_image']['name'];
             $_FILES['userfile']['type']     =   $_FILES['beer_image']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['beer_image']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['beer_image']['error'];
             $_FILES['userfile']['size']     =   $_FILES['beer_image']['size'];
   
			$config['file_name'] = 'bar_logo'.$rand;
			
            $config['upload_path'] = base_path().'upload/beer_orig/';
			
           // $config['allowed_types'] = '*';
			//$config['allowed_types'] = '*';
			
           $config['allowed_types'] = '*';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				 $error =  $this->upload->display_errors();
				   
			  } 
			
			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   
              $this->image_lib->clear();
		   	
			
					$gd_var='gd2';
				
				
		   if ($_FILES["beer_image"]["type"]!= "image/jpg" and $_FILES["beer_image"]["type"] != "image/x-jpg") {
		  
		   	$gd_var='gd2';
			
			
			}
			if ($_FILES["beer_image"]["type"]!= "image/png" and $_FILES["beer_image"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["beer_image"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["beer_image"]["type"] != "image/jpeg" and $_FILES["beer_image"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_thumb/'.$picture['file_name'],215,247);
			 
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_list/'.$picture['file_name'],120,120);
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_thumb_70by70/'.$picture['file_name'],70,70);
			
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_225/'.$picture['file_name'],225,225);
			
			
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_291/'.$picture['file_name'],291,291);
			
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_200/'.$picture['file_name'],200,200);
			
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_240/'.$picture['file_name'],240,240);
			
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_140/'.$picture['file_name'],140,140);
			
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_312/'.$picture['file_name'],312,312);
			
			$beer_image =$picture['file_name'];
			} 
			
			$data = array(
				'beer_name' => $beer_name,
				'beer_desc' => $beer_desc,
				'beer_type' => $beer_type,
				'beer_country' => $beer_country,
				'beer_state' => $beer_state,
				'abv' => $abv,
				'beer_image' => $beer_image,
				'producer' => $producer,
				'status' => 'pending',
				'is_deleted' => 'no',
				'beer_slug' => $slug,
				'date_added' => date('Y-m-d H:i:s'),
				'city_produced' => $city_produced,
				'beer_website' => $beer_website,
				// 'beer_meta_title' => $this->input->post('beer_meta_title'),
				// 'beer_meta_keyword' => $this->input->post('beer_meta_keyword'),
				// 'beer_meta_description' => $this->input->post('beer_meta_description'),
			);
			
			$this->db->insert('beer_directory',$data);
			
			$news_id = mysql_insert_id();
		$inar = array('cat_id'=>$news_id,
		              'category'=>'beer',
					  'date'=>date('Y-m-d H:i:s'));
		$this->db->insert('sitemap', $inar);
	}

	function suggestcocktail_insert($cocktail_name,$ingredients,$how_to_make_it,$base_spirit,$type,$served,$preparation,$strength,$difficulty,$flavor_profile)
	{
		
		$beer_image = '';
		$image_setting = image_setting();
		
		 if(isset($_FILES['beer_image']) && $_FILES['beer_image']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['beer_image']['name'];
             $_FILES['userfile']['type']     =   $_FILES['beer_image']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['beer_image']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['beer_image']['error'];
             $_FILES['userfile']['size']     =   $_FILES['beer_image']['size'];
   
			$config['file_name'] = 'bar_logo'.$rand;
			
            $config['upload_path'] = base_path().'upload/cocktail_orig/';
			
            //$config['allowed_types'] = '*';
            $config['allowed_types'] = '*';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			
			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   
              $this->image_lib->clear();
		   	
			
					$gd_var='gd2';
				
				
		   if ($_FILES["beer_image"]["type"]!= "image/png" and $_FILES["beer_image"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["beer_image"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["beer_image"]["type"] != "image/jpeg" and $_FILES["beer_image"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			 $this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_thumb/'.$picture['file_name'],215,247);
			 
			$this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_list/'.$picture['file_name'],120,120);
			
			
			$this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_thumb_70by70/'.$picture['file_name'],70,70);
			
			
			$this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_225/'.$picture['file_name'],225,225);
			
			$this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_291/'.$picture['file_name'],291,291);
			
			$this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_200/'.$picture['file_name'],200,200);
			
			$this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_240/'.$picture['file_name'],240,240);
			
			$this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_140/'.$picture['file_name'],140,140);
			 
			
			$beer_image =$picture['file_name'];
			
		
			
			} 
			  $slug=getCocktailSlug($cocktail_name);
			$data = array(
				'cocktail_name' => $cocktail_name,
				'ingredients' => $ingredients,
				'how_to_make_it' => $how_to_make_it,
				'base_spirit' => $base_spirit,
				'cocktail_image' => $beer_image,
				'type' => $type,
				'status' => 'pending',
				'is_deleted' => 'no',
				'date_added' => date('Y-m-d H:i:s'),
				'served' => $served,
				'preparation' => $preparation,
				'strength' => $strength,
				'difficulty' => $difficulty,
				'flavor_profile' => $flavor_profile,
				'cocktail_slug' => $slug,
				// 'cocktail_meta_title' => $this->input->post('cocktail_meta_title'),
				// 'cocktail_meta_keyword' => $this->input->post('cocktail_meta_keyword'),
				// 'cocktail_meta_description' => $this->input->post('cocktail_meta_description'),
			);
			
			$this->db->insert('cocktail_directory',$data);
			
			$news_id = mysql_insert_id();
		$inar = array('cat_id'=>$news_id,
		              'category'=>'cocktail',
					  'date'=>date('Y-m-d H:i:s'));
		$this->db->insert('sitemap', $inar);
	}

 	function suggestliquor_insert($liquor_title,$type,$proof,$producer,$country,$description)
	{
		
		$beer_image = '';
		$image_setting = image_setting();
		 if(isset($_FILES['image']) && $_FILES['image']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['image']['name'];
             $_FILES['userfile']['type']     =   $_FILES['image']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['image']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['image']['error'];
             $_FILES['userfile']['size']     =   $_FILES['image']['size'];
   
			$config['file_name'] = 'liquor'.$rand;
			
            $config['upload_path'] = base_path().'upload/liquor_orig/';
			
            $config['allowed_types'] = '*';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			
			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   
              $this->image_lib->clear();
		   	
			
					$gd_var='gd2';
				
				
		   if ($_FILES["image"]["type"]!= "image/png" and $_FILES["image"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["image"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["image"]["type"] != "image/jpeg" and $_FILES["image"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_thumb/'.$picture['file_name'],215,247);
			 
			$this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_list/'.$picture['file_name'],120,120);
			
			
			$this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_thumb_70by70/'.$picture['file_name'],70,70);
			
			$this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_225/'.$picture['file_name'],225,225);
			
			$this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_291/'.$picture['file_name'],291,291);
			
			$this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_240/'.$picture['file_name'],240,240);
			
			$this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_200/'.$picture['file_name'],200,200);
			$this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_140/'.$picture['file_name'],140,140);
			
			$beer_image =$picture['file_name'];
			
		
			
			} 
			  $slug=getLiquorSlug($liquor_title);
			$data = array(
				'liquor_title' => $liquor_title,
				'type' => $type,
				'proof' => $proof,
				'producer' => $producer,
				'liquor_description' => $description,
				'liquor_image' => $beer_image,
				'country' => $country,
				'status' => 'pending',
				'is_deleted' => 'no',
				'liquor_slug' => $slug,
				'date_added' => date('Y-m-d H:i:s'),
			);
			
			$this->db->insert('liquors',$data);
			
			$news_id = mysql_insert_id();
		$inar = array('cat_id'=>$news_id,
		              'category'=>'liquor',
					  'date'=>date('Y-m-d H:i:s'));
		$this->db->insert('sitemap', $inar);
	}

	function insert_suggest_bar()
	{    
		 $getlat = getCoordinatesFromAddress($this->input->post('address'),$this->input->post('city'),$this->input->post('state'));
		$data_insert1["bar_name"] = $this->input->post('bar_name');
		$data_insert1["address"] = $this->input->post('address');
		$data_insert1["state"] = $this->input->post('state');
		$data_insert1["city"] = $this->input->post('city');
		$data_insert1["phone_number"] = $this->input->post('phone_number');
		$data_insert1["lat"] = $getlat['lat'];
		$data_insert1["lang"] = $getlat['lng'];
		$data_insert1["zip_code"] = $this->input->post('zip_code');
		$data_insert1["description"] = $this->input->post('description');
		$data_insert1["sugget_by_user"] = $this->input->post('user_id');
		$data_insert1["ip"] = $_SERVER['REMOTE_ADDR'];
		$data_insert1["date"] =date("Y-m-d");
		$data_insert1["count"] = 0;
		$this->db->insert("suggest_bars",$data_insert1);
	}
	
	function getAllArticle($sort_by,$sort_type,$limit=0,$offset=0,$keyword,$type='')
	{
		$this->db->select('v.*,u.first_name,u.last_name,  (SELECT count(sss_blog_rating.blog_id) AS rat FROM sss_blog_rating  WHERE sss_blog_rating.user_id = '.@$this->input->post('user_id').' and sss_blog_rating.blog_id = v.blog_id) as total_number,
		(SELECT sum(sss_blog_rating.blog_rating) AS rat FROM sss_blog_rating  WHERE sss_blog_rating.user_id = '.@$this->input->post('user_id').' and sss_blog_rating.blog_id = v.blog_id) as total_rating');
		//	$this->db->select('CONCAT(path,blog_image , " ",  blog_description) AS blog_description', FALSE);
		$this->db->from("blog v");
		$this->db->where("v.status",'active');
		  $this->db->join("user_master u","u.user_id = v.user_id","LEFT");
		if($keyword != '0')
		{
		  //$this->db->join("category c","c.category_id = v.blog_category_id");
		  
				$this->db->like("v.blog_title",$keyword);
		}
				$this->db->order_by($sort_by,$sort_type);
				if($type=='result')
		{
			
			$this->db->limit($limit,$offset);
		}
		$qry = $this->db->get();
		
		//echo $this->db->last_query();
		if($type=='result')
		{
			
		
		
		if($qry->num_rows()>0)
		{
			return  $qry->result_array();
			
		}
		else 
			{
				$result["result"] = $qry->result_array();
			//$result["status"] = "success";
			$result["keyword"] = $keyword;
			$result["sort_by"] = $sort_by;
			$result["sort_type"] = $sort_type;
			return $result;
			}
		}
		else {
			//$qry = $this->db->get();
			return $qry->num_rows(); 
		}
		
		
		
	}
	
	 function get_one_blog($id = 0)
	{
			//`	$this->db->_protect_identifiers=false; 
		$g = "http://sandbox.americanbars.com/upload/blog_thumb/";	
	//	echo $g; die;
	
		//$this->db->select("CONCAT(user_firstname, '.', user_surname) AS name) AS name");
		
		
		$this->db->select('v.*,u.first_name,u.last_name,  (SELECT count(sss_blog_rating.blog_id) AS rat FROM sss_blog_rating  WHERE sss_blog_rating.user_id = '.@$this->input->post('user_id').' and sss_blog_rating.blog_id = v.blog_id) as total_number,
		(SELECT sum(sss_blog_rating.blog_rating) AS rat FROM sss_blog_rating  WHERE sss_blog_rating.user_id = '.@$this->input->post('user_id').' and sss_blog_rating.blog_id = v.blog_id) as total_rating');
		//$this->db->select('CONCAT(path,blog_image , " ",  blog_description) AS blog_description', FALSE);
		$this->db->from("blog v");
		//$this->db->join("category c","c.category_id = v.blog_category_id");
		$this->db->join("user_master u","u.user_id = v.user_id","LEFT");
		$this->db->where("v.blog_id",$id);
		
		$qry = $this->db->get();
		
		if($qry->num_rows()>0)
		{
			 return $qry->row_array();
		}
		
		
		return 0;
	}
	
	
	 function getAllComments($id=0,$limit="",$offset="",$type=''){
		$this->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('bar_comment b');		
		$this->db->join('user_master u','u.user_id=b.user_id','left');
		$this->db->where('b.bar_id',$id);
		$this->db->where('b.is_deleted','no');
		$this->db->order_by('date_added','desc');
		$qry = $this->db->get();
		if($type=='total')
		{
			return $qry->num_rows();
		}
		else
		{
			$this->db->limit($limit,$offset);
		
			if($qry->num_rows() >0){
				return $qry->result_array();
			}
			return array();
			
		}
		
//		print_r($qry);die;
	}

    function insert_bar_comment()
	{
		
		
		$data_insert1["user_id"] = $this->input->post("user_id");
		$data_insert1["status"] = "active";
		$data_insert1["date_added"] = date("Y-m-d H:i:s");
		$data_insert1["is_deleted"] = "no";
		$data_insert1["comment"] = nl2br($this->input->post('comment'));
		$data_insert1["bar_id"] = $this->input->post('bar_id');
		$data_insert1["comment_title"] = $this->input->post('comment_title');
		$data_insert1["bar_rating"] = $this->input->post('rating');
	
		$this->db->insert("bar_comment",$data_insert1);
		$getid= mysql_insert_id();
		$getbarinfo = $this->get_one_bar($this->input->post('bar_id'));
		
		$getuserinfo = $this->get_user_info($this->input->post("user_id"));
		//print_r($getuserinfo);
		$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Bar Comment'");
		$email_temp=$email_template->row();             
		$email_address_from=$email_temp->from_address;
        $email_address_reply=$email_temp->reply_address;
                
        $email_subject=$email_temp->subject;                
        $email_message=$email_temp->message;
                
        $email = $getbarinfo['email'];
        //"php.developer@spaculus.com";
        //$site_name = $site_data->site_name;
        $email_to =$email;
		
		$bar_owner = ucwords($getbarinfo['bar_first_name'])." ".ucwords($getbarinfo['bar_last_name']);
		$username = ucwords($getuserinfo['first_name'])." ".ucwords($getuserinfo['last_name']);
		$barname = ucwords($getbarinfo['bar_title']);
		$title = ucwords($this->input->post('comment_title'));
		$description = $this->input->post('comment');
		$ratings = $this->input->post('rating');
        $email_message=str_replace('{break}','<br/>',$email_message);
        $email_message=str_replace('{bar_owner}',$bar_owner,$email_message);
		$email_message=str_replace('{barname}',$barname,$email_message);
		$email_message=str_replace('{title}',$title,$email_message);
		$email_message=str_replace('{description}',$description,$email_message);
		$email_message=str_replace('{ratings}',$ratings,$email_message);
		$email_message=str_replace('{username}',$username,$email_message);
		$email_subject=str_replace('{username}',$username,$email_subject);
        $str=$email_message;
        //echo $str;exit;
        /** custom_helper email function **/
       // echo $email_temp->status;
        if($email_temp->status=='active'){
        email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
		}
	}

    function get_beer_comments($id=0,$user_id=0,$limit = 0,$offset = 0,$type=''){
    	
		$this->db->select('b.*,u.profile_image,u.first_name,u.last_name, 
		          (SELECT sss_all_likes.like_flag FROM sss_all_likes  WHERE sss_all_likes.user_id = '.@$this->input->post('user_id').' and sss_all_likes.beer_comment_id = b.beer_comment_id) as is_like,
				  (SELECT count(sss_all_likes.like_id) FROM sss_all_likes  WHERE  sss_all_likes.like_flag=1 and sss_all_likes.beer_comment_id = b.beer_comment_id group by sss_all_likes.beer_id) as total_like ');
	//$this->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('beer_comment b');		
		$this->db->join('user_master u','u.user_id=b.user_id','left');
		
		$this->db->where('b.beer_id',$id);
		$this->db->where('b.is_deleted',0);
		$this->db->where('b.status','active');
		$this->db->where('b.master_comment_id',0);
		$this->db->order_by('date_added','desc');
		if($type=='result')
		{
		$this->db->limit($limit,$offset);
		
		$qry = $this->db->get();
		
		if($qry->num_rows() >0){
			return $qry->result_array();
		}
		else {
			return array();
		}
		}
		else if($type=='total')
		{
			
			$qry = $this->db->get();
		
			return $qry->num_rows();
		}	

	}
	
	function get_beer_subcomments($id=0,$limit,$offset,$type){
		$this->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('beer_comment b');		
		$this->db->join('user_master u','u.user_id=b.user_id','');
		//$CI->db->join('beer_comment bc','bc.master_comment_id=b.beer_comment_id');
		//$this->db->where('b.master_comment_id!=','0',false);
		$this->db->where('b.master_comment_id',$id);
		$this->db->where('b.is_deleted',0);
		$this->db->order_by('date_added','desc');
		if($type=='result')
		{
			$this->db->limit($limit,$offset);
			$qry = $this->db->get();	
			
			if($qry->num_rows() >0){
				
				return $qry->result_array();
			}
			return array();
		}
		else if($type=='total')
		{
			$qry = $this->db->get();
			return $qry->num_rows();
		}	
	}
	
    function insert_beer_comment()
	{
		$data_insert["user_id"] = $this->input->post("user_id");
		$data_insert["beer_id"] = $this->input->post("beer_id");
		$data_insert["comment_title"] = $this->input->post("comment_title");
		$data_insert["comment"] = $this->input->post("comment");
		$data_insert["status"] = "active";
		//$data_insert["comment_video"] = $this->input->post('comment_video');
		$data_insert["date_added"] = date("Y-m-d H:i:s");
		$data_insert["is_deleted"] = "0";
	 
		$this->db->insert("beer_comment",$data_insert);
	} 
 function insert_beer_subcomment()
	{
		$data_insert["user_id"] = $this->input->post("user_id");
		$data_insert["beer_id"] = $this->input->post("beer_id");
		$data_insert["comment"] = $this->input->post("comment");
		$data_insert["master_comment_id"] = $this->input->post("master_comment_id");
		$data_insert["status"] = "active";
		//$data_insert["comment_video"] = $this->input->post('comment_video');
		$data_insert["date_added"] = date("Y-m-d H:i:s");
		$data_insert["is_deleted"] = "0";
	 
		$this->db->insert("beer_comment",$data_insert);
	} 
	
	function remove_beer_comment($beer_comment_id){
	
		$this->db->delete('beer_comment', array('beer_comment_id' => $beer_comment_id)); 
	}
	
	 
	 
	 function get_cocktail_comments($id=0,$user_id=0,$limit = 0,$offset = 0,$type=''){
		$this->db->select('b.*,u.profile_image,u.first_name,u.last_name, 
		          (SELECT sss_all_likes.like_flag FROM sss_all_likes  WHERE sss_all_likes.user_id = '.@$this->input->post('user_id').' and sss_all_likes.cocktail_comment_id = b.cocktail_comment_id) as is_like,
				  (SELECT count(sss_all_likes.like_id) FROM sss_all_likes  WHERE sss_all_likes.like_flag=1 and sss_all_likes.cocktail_comment_id = b.cocktail_comment_id group by sss_all_likes.cocktail_id) as total_like ');
	//$this->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('cocktail_comment b');		
		$this->db->join('user_master u','u.user_id=b.user_id','left');
		
		$this->db->where('b.cocktail_id',$id);
		$this->db->where('b.is_deleted',0);
		$this->db->where('b.status','active');
		$this->db->where('b.master_comment_id',0);
		$this->db->order_by('date_added','desc');
		if($type=='result')
		{
		$this->db->limit($limit,$offset);
		
		$qry = $this->db->get();
		
		if($qry->num_rows() >0){
			return $qry->result_array();
		}
		else {
			return array();
		}
		}
		else if($type=='total')
		{
			$qry = $this->db->get();
			return $qry->num_rows();
		}	

	}
	
	function get_cocktail_subcomments($id=0,$limit,$offset,$type){
		$this->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('cocktail_comment b');		
		$this->db->join('user_master u','u.user_id=b.user_id','');
		//$CI->db->join('cocktail_comment bc','bc.master_comment_id=b.cocktail_comment_id');
		$this->db->where('b.master_comment_id',$id);
		$this->db->where('b.is_deleted',0);
		$this->db->order_by('date_added','desc');
		if($type=='result')
		{
			$this->db->limit($limit,$offset);
			$qry = $this->db->get();	
			
			if($qry->num_rows() >0){
				
				return $qry->result_array();
			}
			return array();
		}
		else if($type=='total')
		{
			$qry = $this->db->get();
			return $qry->num_rows();
		}	
	}
	
    function insert_cocktail_comment()
	{
		$data_insert["user_id"] = $this->input->post("user_id");
		$data_insert["cocktail_id"] = $this->input->post("cocktail_id");
		$data_insert["comment_title"] = $this->input->post("comment_title");
		$data_insert["comment"] = $this->input->post("comment");
		$data_insert["status"] = "active";
		//$data_insert["comment_video"] = $this->input->post('comment_video');
		$data_insert["date_added"] = date("Y-m-d H:i:s");
		$data_insert["is_deleted"] = "0";
	 
		$this->db->insert("cocktail_comment",$data_insert);
	} 
 function insert_cocktail_subcomment()
	{
		$data_insert["user_id"] = $this->input->post("user_id");
		$data_insert["cocktail_id"] = $this->input->post("cocktail_id");
		$data_insert["comment"] = $this->input->post("comment");
		$data_insert["master_comment_id"] = $this->input->post("master_comment_id");
		$data_insert["status"] = "active";
		//$data_insert["comment_video"] = $this->input->post('comment_video');
		$data_insert["date_added"] = date("Y-m-d H:i:s");
		$data_insert["is_deleted"] = "0";
	 
		$this->db->insert("cocktail_comment",$data_insert);
	} 
	
	function remove_cocktail_comment($cocktail_comment_id){
	
		$this->db->delete('cocktail_comment', array('cocktail_comment_id' => $cocktail_comment_id)); 
	}
	
	
	
	
	
	 function get_liquor_comments($id=0,$user_id=0,$limit = 0,$offset = 0,$type=''){
		$this->db->select('b.*,u.profile_image,u.first_name,u.last_name, 
		          (SELECT sss_all_likes.like_flag FROM sss_all_likes  WHERE sss_all_likes.user_id = '.@$this->input->post('user_id').' and sss_all_likes.liquor_comment_id = b.liquor_comment_id) as is_like,
				  (SELECT count(sss_all_likes.like_id) FROM sss_all_likes  WHERE sss_all_likes.like_flag=1 and sss_all_likes.liquor_comment_id = b.liquor_comment_id group by sss_all_likes.liquor_id) as total_like');
	//$this->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('liquor_comment b');		
		$this->db->join('user_master u','u.user_id=b.user_id','left');
		
		$this->db->where('b.liquor_id',$id);
		$this->db->where('b.is_deleted',0);
		$this->db->where('b.status','active');
		$this->db->where('b.master_comment_id',0);
		$this->db->order_by('date_added','desc');
		if($type=='result')
		{
		$this->db->limit($limit,$offset);
		
		$qry = $this->db->get();
		
		if($qry->num_rows() >0){
			return $qry->result_array();
		}
		else {
			return array();
		}
		}
		else if($type=='total')
		{
			$qry = $this->db->get();
			return $qry->num_rows();
		}	

	}
	
	function get_liquor_subcomments($id=0,$limit=0,$offset=0,$type=''){
		
		
		$this->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('liquor_comment b');		
		$this->db->join('user_master u','u.user_id=b.user_id','');
		//$CI->db->join('liquor_comment bc','bc.master_comment_id=b.liquor_comment_id');
		$this->db->where('b.master_comment_id',$id);
		$this->db->where('b.is_deleted',0);
		$this->db->order_by('date_added','desc');
		//$qry = $this->db->get();	
		
		//$this->db->order_by('date_added','desc');
		if($type=='result')
		{
			$this->db->limit($limit,$offset);
			$qry = $this->db->get();	
			
			if($qry->num_rows() >0){
				
				return $qry->result_array();
			}
			return array();
		}
		else if($type=='total')
		{
			$qry = $this->db->get();
			return $qry->num_rows();
		}	
	}
	
    function insert_liquor_comment()
	{
		$data_insert["user_id"] = $this->input->post("user_id");
		$data_insert["liquor_id"] = $this->input->post("liquor_id");
		$data_insert["comment_title"] = $this->input->post("comment_title");
		$data_insert["comment"] = $this->input->post("comment");
		$data_insert["status"] = "active";
		//$data_insert["comment_video"] = $this->input->post('comment_video');
		$data_insert["date_added"] = date("Y-m-d H:i:s");
		$data_insert["is_deleted"] = "0";
	 
		$this->db->insert("liquor_comment",$data_insert);
	} 
 function insert_liquor_subcomment()
	{
		$data_insert["user_id"] = $this->input->post("user_id");
		$data_insert["liquor_id"] = $this->input->post("liquor_id");
		$data_insert["comment"] = $this->input->post("comment");
		$data_insert["master_comment_id"] = $this->input->post("master_comment_id");
		$data_insert["status"] = "active";
		//$data_insert["comment_video"] = $this->input->post('comment_video');
		$data_insert["date_added"] = date("Y-m-d H:i:s");
		$data_insert["is_deleted"] = "0";
	 
		$this->db->insert("liquor_comment",$data_insert);
	} 
	
	function remove_liquor_comment($liquor_comment_id){
	
		$this->db->delete('liquor_comment', array('liquor_comment_id' => $liquor_comment_id)); 
	}
	
	function getquiz()
	{
		$this->db->select('trivia_id, answer, question, question1 as `1`, question2 as `2`, question3 as `3`, question4 as `4`');
		$this->db->from('trivia');
		
		$this->db->where('status','active');
		$this->db->order_by('trivia_id', 'RANDOM');
		$this->db->limit(20);
		$qry = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($qry->num_rows()>0)
		{
			 return $qry->result_array();
		}
		return array();
	}
	
	function getimagenamebanner()
	{
		$CI =& get_instance();
		$query = $CI->db->get("banner_pages");
		return $query->row_array();
	}
	
	
		 function getEventTime($event_id)
	{
		$this->db->select('*');
		$this->db->from('event_time');
		$this->db->where(array('event_id'=>$event_id));
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		return '';
	}
}

?>
