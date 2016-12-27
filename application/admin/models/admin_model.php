<?php

class Admin_model extends CI_Model {
	
    function Admin_model()
    {
        parent::__construct();	
    }   
	
	// Use :This function use for check UserName of admin .
	// Param :username
	// Return :Boolean
	function user_unique($str)
	{
		if($this->input->post('admin_id'))
		{
			$query = $this->db->get_where('admin',array('admin_id'=>$this->input->post('admin_id')));
			$res = $query->row_array();
			$email = $res['username'];
			
			$query = $this->db->query("select username from ".$this->db->dbprefix('admin')." where username = '$str' and admin_id!='".$this->input->post('admin_id')."'");
		}else{
			$query = $this->db->query("select username from ".$this->db->dbprefix('admin')." where username = '$str'");
		}
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	
	// Use :This function use for check Email of admin .
	// Param :email
	// Return :Boolean
	function user_email_unique($str)
	{
		if($this->input->post('admin_id'))
		{
			$query = $this->db->get_where('admin',array('admin_id'=>$this->input->post('admin_id')));
			$res = $query->row_array();
			$email = $res['username'];
			
			$query = $this->db->query("select email from ".$this->db->dbprefix('admin')." where email = '$str' and admin_id!='".$this->input->post('admin_id')."'");
		}else{
			$query = $this->db->query("select email from ".$this->db->dbprefix('admin')." where email = '$str'");
		}
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	
	// Use :This function use for add new admin.
	// Param :Post Data
	// Return :'N/A'
	function admin_insert()
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
   
			$config['file_name'] = 'Admin'.$rand;
			
            $config['upload_path'] = base_path().'upload/admin_orig/';
			
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
				'source_image' => base_path().'upload/admin_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/admin/'.$picture['file_name'],
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
					if(file_exists(base_path().'upload/admin/'.$this->input->post('pre_profile_image')))
					{
						$link=base_path().'upload/admin/'.$this->input->post('pre_profile_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/admin_orig/'.$this->input->post('pre_profile_image')))
					{
						$link2=base_path().'upload/admin_orig/'.$this->input->post('pre_profile_image');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('pre_profile_image')!='')
				{
					$profile_image=$this->input->post('pre_profile_image');
				}
			}
	
		$active=($this->input->post('active')=='Active')?'Active':'Inactive';
	
		$data = array(
			'email' => $this->input->post('emailField'),
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'active' => $this->input->post('active'),
			'image'=>$profile_image,
			'date_added' => date('Y-m-d'),
		
		);
		
		$this->db->insert('admin',$data);
        
      /// common function for insert all action//
           $data_log = array("activity_name" => "LOG_ADD_ADMIN");
           maintain_log($data_log);
       /// end of common function for insert all the action//
       
        
        
		
	}

	// Use :This function use for Update admin Detail.
	// Param :Post Data
	// Return :'N/A'
	
	function admin_update()
	{
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
   
			$config['file_name'] = $rand.'Admin';
			
			$config['upload_path'] = base_path().'upload/admin_orig/';
			
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



			  $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/admin_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/admin/'.$picture['file_name'],
				'maintain_ratio' => TRUE,
				'quality' => '100%',
				'width' => 300,
				'height' => 300
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			  
			}
		
			 $profile_image=$picture['file_name'];
			
		
		
		
			if($this->input->post('pre_profile_image')!='')
				{
					if(file_exists(base_path().'upload/admin/'.$this->input->post('pre_profile_image')))
					{
						$link=base_path().'upload/admin/'.$this->input->post('pre_profile_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/admin_orig/'.$this->input->post('pre_profile_image')))
					{
						$link2=base_path().'upload/admin_orig/'.$this->input->post('pre_profile_image');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('pre_profile_image')!='')
				{
					$profile_image=$this->input->post('pre_profile_image');
				}
			}
		
		$active=($this->input->post('active')=='Active')?'Active':'Inactive';
		$data = array(
			'email' => $this->input->post('emailField'),
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'login_ip' => $_SERVER['REMOTE_ADDR'],
			'image'=>$profile_image,
			'active' => $this->input->post('active'),
			'date_added' => date('Y-m-d'),
		
		);		
		$this->db->where('admin_id',$this->input->post('admin_id'));
		$this->db->update('admin',$data);
		
        /// common function for insert all action//
           $data_log = array("activity_name" => "LOG_UPDATE_ADMIN");
           maintain_log($data_log);
		
	}
	

	// Use :This function use for get one admin detail.
	// Param :Admin Id
	// Return :array
	function get_one_admin($id)
	{
		$query = $this->db->get_where('admin',array('admin_id'=>$id));
		return $query->row_array();
	}	
	
	// Use :This function use for count all admin.
	// Param :'N/A'
	// Return :Number
	
	function get_total_admin_count()
	{
		return $this->db->count_all('admin');
	}
	
	// Use :This function use for get admin detail by limit and offset.
	// Param :offset,limit
	// Return :array of object
	
	function get_admin_result($offset,$limit)
	{
		
		
		$this->db->order_by('admin_id','asc');
		$query = $this->db->get('admin',$limit,$offset);
		

		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	// Use :This function use for Count all admin login history.
	// Param :'N/A'
	// Return :number
	
	function get_total_adminlogin_count()
	{
			$query = $this->db->query("select a.username,a.password,a.admin_type,a.email,ad.* from ".$this->db->dbprefix('admin_login')." ad left join ".$this->db->dbprefix('admin')." a on ad.admin_id=a.admin_id order by ad.login_id desc");


		return $query->num_rows();
	}
	// Use :This function use for get admin login history by limit and offset.
	// Param :offset,limit
	// Return :array of object
	
	function get_adminlogin_result($offset, $limit)
	{
			
		$query = $this->db->query("select a.username,a.password,a.admin_type,a.email,ad.* from ".$this->db->dbprefix('admin_login')." ad left join ".$this->db->dbprefix('admin')." a on ad.admin_id=a.admin_id order by ad.login_id desc LIMIT ".$limit." Offset ".$offset);


		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	// Use :This function use for count admin by Filder.
	// Param :option,keyword
	// Return :number
	function get_total_search_admin_count($option,$keyword)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('admin.*');
		$this->db->from('admin');
		
		if($option=='username')
		{
			$this->db->like('username',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('username',$val);
				}	
			}

		}
		if($option=='email')
		{
			$this->db->like('email',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('email',$val);
				}	
			}

		}
		if($option=='admintype')
		{
			$this->db->like('admintype',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('admintype',$val);
				}	
			}

		}
		
		$this->db->order_by('admin_id','asc');
		
		$query = $this->db->get();
		
		
		return $query->num_rows();
	}
	
	// Use :This function use for get admin detail by filter and limit and offset.
	// Param :offset,limit,option,keyword
	// Return :array of object
	
	function get_search_admin_result($option,$keyword,$offset, $limit)
	{
		
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('admin.*');
		$this->db->from('admin');
		
		if($option=='username')
		{
			$this->db->like('username',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('username',$val);
				}	
			}

		}
		if($option=='email')
		{
			$this->db->like('email',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('email',$val);
				}	
			}

		}
		
		
		$this->db->order_by('admin_id','asc');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
    
     /*Patient log*/
    function get_total_count_logactivity($admin_id)
    {
        $query=$this->db->query("SELECT ul.* FROM sss_user u,sss_user_log_master ul WHERE ul.patient_id='".$admin_id."' and user_type = 'admin' group by  user_log_id  order by ul.`user_log_id` desc ");
        //echo $this->db->last_query();
        if($query->num_rows()>0)
        {
            return $query->num_rows();
        }
        else
         {
            return 0;
         }     
    }
    
    function get_logactivity_result($admin_id,$limit,$offset)
    {
        $query=$this->db->query("SELECT ul.* FROM sss_user u,sss_user_log_master ul WHERE ul.patient_id='".$admin_id."' and user_type = 'admin' group by  user_log_id  order by ul.`user_log_id` desc limit ".$limit." offset ".$offset);
        
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
         {
            return 0;
         }      
    }
    
}
?>