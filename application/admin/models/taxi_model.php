<?php
class Taxi_model extends CI_Model {
	
    function Taxi_model()
    {
        parent::__construct();	
    }   
	
	/*check unique taxi 
	 * param : taxiname, paitent_id(if in edit mode)
	 */
	function taxi_unique($str)
	{
		if($this->input->post('taxi_id'))
		{
			$query = $this->db->get_where('taxi_directory',array('taxi_id'=>$this->input->post('taxi_id')));
			$res = $query->row_array();
			$email = $res['taxi_company'];
			
			$query = $this->db->query("select taxi_company from ".$this->db->dbprefix('taxi_directory')." where taxi_company = '$str' and taxi_id!='".$this->input->post('taxi_id')."'");
		}else{
			$query = $this->db->query("select taxi_company from ".$this->db->dbprefix('taxi_directory')." where taxi_company = '$str'");
		}
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	
	function taxi_name_v($str,$phone='',$add='',$city='',$state='',$zip='',$website='')
	{
		    $query123 = $this->db->query("select * from ".$this->db->dbprefix('taxi_directory')." where address='".addslashes(utf8_encode($add))."' and phone_number='".addslashes(utf8_encode($phone))."'  and cmpn_zipcode='".$zip."' and  city='".addslashes(utf8_encode($city))."' and state='".addslashes(utf8_encode($state))."' and cmpn_website='".$website."' and  taxi_company = '".addslashes(utf8_encode($str))."' ",FALSE);
		// print_r($query123->result());
		
       // echo $query->num_rows();
       // die;
		if($query123->num_rows()>0){
			
			return 1;
		}else{
			
			return 0;
		}
	}
	
	
	/* add taxi detail in db
	 * 
	 */	
	function taxi_insert($data_insert= array())
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
		   
             
		resize(base_path().'upload/user_orig/'.$picture['file_name'],base_path().'upload/user_thumb/'.$picture['file_name'],120,120);
			 $this->image_lib->clear();
			 resize(base_path().'upload/user_orig/'.$picture['file_name'],base_path().'upload/user_thumb_200/'.$picture['file_name'],200,200);
			  $this->image_lib->clear();
			 resize(base_path().'upload/user_orig/'.$picture['file_name'],base_path().'upload/user_thumb_240/'.$picture['file_name'],240,240);
		
		  $this->image_lib->clear();
			 resize(base_path().'upload/user_orig/'.$picture['file_name'],base_path().'upload/user_thumb_312/'.$picture['file_name'],312,312);
		
			$profile_image=$picture['file_name'];
			
		
			if($this->input->post('pre_profile_image')!='')
				{
					if(file_exists(base_path().'upload/user_thumb_312/'.$this->input->post('pre_profile_image')))
					{
						$link=base_path().'upload/user_thumb_312/'.$this->input->post('pre_profile_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/user_thumb_200/'.$this->input->post('pre_profile_image')))
					{
						$link=base_path().'upload/user_thumb_200/'.$this->input->post('pre_profile_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/user_thumb_240/'.$this->input->post('pre_profile_image')))
					{
						$link=base_path().'upload/user_thumb_240/'.$this->input->post('pre_profile_image');
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
			}
		
	
		
		$data_taxi = array(
			'taxi_company' => $this->input->post('tax_company_name'),
			'address' => $this->input->post('tax_cmpn_address'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'taxi_desc' => $this->input->post('reciew'),
			'cmpn_zipcode' => $this->input->post('cmpn_zipcode'),
			'phone_number' => $this->input->post('texi_company_phone_number'),
			'cmpn_website' => $this->input->post('taxi_company_website'),
			'taxi_meta_title' => $this->input->post('taxi_meta_title'),
			'taxi_meta_keyword' => $this->input->post('taxi_meta_keyword'),
			'taxi_meta_description' => $this->input->post('taxi_meta_description'),
			'taxi_image'=>$profile_image,
			'status' => $this->input->post('active'),
			'cmpn_email' => $this->input->post('emailField'),
			'date_added' => date('Y-m-d H:i:s')
		
		);
		$this->db->insert('taxi_directory',$data_taxi);
		
		
	}


    ///////////// upload image////////////////////////////
    //////////////// upload bar logo//////////////////////////
	function upload_taxi_image()
	{
		$taxi_image = '';
		$image_setting = image_setting();
		 if($_FILES['file_up']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['file_up']['name'];
             $_FILES['userfile']['type']     =   $_FILES['file_up']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['file_up']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['file_up']['error'];
             $_FILES['userfile']['size']     =   $_FILES['file_up']['size'];
   
			$config['file_name'] = 'taxi_image'.$rand;
			
            $config['upload_path'] = base_path().'upload/taxi_orig/';
			
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
				'source_image' => base_path().'upload/taxi_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/taxi_thumb/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => $image_setting->banner_width,
				'height' => $image_setting->banner_height,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$taxi_image =$picture['file_name'];
			
		
			if($this->input->post('prev_taxi_image')!='')
				{
					if(file_exists(base_path().'upload/taxi_thumb/'.$this->input->post('prev_taxi_image')))
					{
						$link=base_path().'upload/taxi_thumb/'.$this->input->post('prev_taxi_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/taxi_orig/'.$this->input->post('prev_taxi_image')))
					{
						$link2=base_path().'upload/taxi_orig/'.$this->input->post('prev_taxi_image');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('prev_taxi_image')!='')
				{
					$taxi_image=$this->input->post('prev_taxi_image');
				}
			}
			
			return $taxi_image;
		   
	}
    ////// end of uplaod image////////////////////////////
	
	function upload_taxi_banner()
		{
		$taxi_banner = '';
		$image_setting = image_setting();
		 if($_FILES['file_up2']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['file_up2']['name'];
             $_FILES['userfile']['type']     =   $_FILES['file_up2']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['file_up2']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['file_up2']['error'];
             $_FILES['userfile']['size']     =   $_FILES['file_up2']['size'];
   
			$config['file_name'] = 'taxi_banner'.$rand;
			
            $config['upload_path'] = base_path().'upload/taxi_orig/';
			
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
				
				
		   if ($_FILES["file_up2"]["type"]!= "image/png" and $_FILES["file_up"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["file_up2"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["file_up2"]["type"] != "image/jpeg" and $_FILES["file_up"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/taxi_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/taxi_thumb/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => $image_setting->banner_width,
				'height' => $image_setting->banner_height,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$taxi_banner =$picture['file_name'];
			
		
			if($this->input->post('prev_taxi_banner')!='')
				{
					if(file_exists(base_path().'upload/taxi_thumb/'.$this->input->post('prev_taxi_banner')))
					{
						$link=base_path().'upload/taxi_thumb/'.$this->input->post('prev_taxi_banner');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/taxi_orig/'.$this->input->post('prev_taxi_banner')))
					{
						$link2=base_path().'upload/taxi_orig/'.$this->input->post('prev_taxi_banner');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('prev_taxi_banner')!='')
				{
					$taxi_banner=$this->input->post('prev_taxi_banner');
				}
			}
			
			return $taxi_banner;
	}
	
	// ======  End Texi Banner upload
	
	/* taxi update 
	 * 
	 */
	function taxi_update($data_insert = array())
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
			
			resize(base_path().'upload/user_orig/'.$picture['file_name'],base_path().'upload/user_thumb/'.$picture['file_name'],120,120);
			 $this->image_lib->clear();
			 resize(base_path().'upload/user_orig/'.$picture['file_name'],base_path().'upload/user_thumb_200/'.$picture['file_name'],200,200);
			  $this->image_lib->clear();
			 resize(base_path().'upload/user_orig/'.$picture['file_name'],base_path().'upload/user_thumb_240/'.$picture['file_name'],240,240);
		
		$this->image_lib->clear();
			 resize(base_path().'upload/user_orig/'.$picture['file_name'],base_path().'upload/user_thumb_312/'.$picture['file_name'],312,312);
		
			$profile_image =$picture['file_name'];
			
		
			if($this->input->post('pre_profile_image')!='')
				{
					if(file_exists(base_path().'upload/user_thumb_312/'.$this->input->post('pre_profile_image')))
					{
						$link=base_path().'upload/user_thumb_312/'.$this->input->post('pre_profile_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/user_thumb_200/'.$this->input->post('pre_profile_image')))
					{
						$link=base_path().'upload/user_thumb_200/'.$this->input->post('pre_profile_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/user_thumb_240/'.$this->input->post('pre_profile_image')))
					{
						$link=base_path().'upload/user_thumb_240/'.$this->input->post('pre_profile_image');
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
			}
		
		
		
		$data_taxi = array(
			'taxi_company' => $this->input->post('tax_company_name'),
			'address' => $this->input->post('tax_cmpn_address'),
			'city' => $this->input->post('city'),
			'taxi_desc' => $this->input->post('reciew'),
			'state' => $this->input->post('state'),
			'cmpn_zipcode' => $this->input->post('cmpn_zipcode'),
			'phone_number' => $this->input->post('texi_company_phone_number'),
			'cmpn_website' => $this->input->post('taxi_company_website'),
			'taxi_image'=>$profile_image,
			'cmpn_email' => $this->input->post('emailField'),
			'taxi_meta_title' => $this->input->post('taxi_meta_title'),
			'taxi_meta_keyword' => $this->input->post('taxi_meta_keyword'),
			'taxi_meta_description' => $this->input->post('taxi_meta_description'),
			'status' => $this->input->post('active'),
		);
		
		
		
		$this->db->where('taxi_id',$this->input->post('taxi_id'));
		$this->db->update('taxi_directory',$data_taxi);
       // echo $this->db->last_query(); die;
           
		
		
		
	}
	
	/* get taxi info
	 * param : taxi id
	 * 
	 */		
	function get_one_taxi($id)
	{
		$query = $this->db->get_where('taxi_directory',array('taxi_id'=>$id));
		return $query->row_array();
	}	
	
	/* get total taxis
	 * param :doctor id
	 */
	function get_total_taxi_count()
	{
		//$this->db->where('is_deleted','no');
		//$query = $this->db->get_where('taxi_directory',array('is_deleted'=>'no'));
		
		$this->db->select('*');
		$this->db->from('taxi_directory');
		$this->db->join('user_master','taxi_directory.taxi_owner_id=user_master.user_id','left');
		$this->db->where('taxi_directory.status !=','archived');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}
		return 0;
	}
	
	
	/* get taxi doctor wise
	 * param : doctor id
	 */
	function get_taxi_result($offset,$limit)
	{
		
	//	$this->db->where(array('doctor_id'=>$doctor_id));
		$this->db->order_by("taxi_id","desc");
		$this->db->select('*,taxi_directory.status,taxi_directory.address');
		$this->db->from('taxi_directory');
		$this->db->where('taxi_directory.status !=','archived');
		$this->db->join('user_master','taxi_directory.taxi_owner_id=user_master.user_id','left');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	
	/* search taxi doctor wise
	 * param:doctor id,option ,keyword
	 */	
	function get_total_search_taxi_count($option,$keyword)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('*');
		$this->db->from('taxi_directory');
		
		$this->db->join('user_master','taxi_directory.taxi_owner_id=user_master.user_id','left');
		$this->db->where('taxi_directory.status !=','archived');
		
		if($option=='taxi_company')
		{
			$this->db->like('taxi_company',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->or_like('taxi_company',$val);
				}	
			}

		}
		
		if($option=='city')
		{
			$this->db->like('city',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->or_like('city',$val);
				}	
			}

		}

       if($option=='state')
		{
			$this->db->like('state',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->or_like('state',$val);
				}	
			}

		}
		
		if($option=='phone_number')
		{
			$this->db->like('phone_number',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->or_like('phone_number',$val);
				}	
			}

		}

       
	//	$this->db->order_by('taxi_id','desc');
		$query = $this->db->get();
		
		
		return $query->num_rows();
	}
	
	
	
	/* search taxi doctor wise
	 * param:doctor id,option ,keyword
	 */		
	function get_search_taxi_result($option,$keyword,$offset, $limit)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('*,taxi_directory.status,taxi_directory.address');
		$this->db->from('taxi_directory');
		$this->db->join('user_master','taxi_directory.taxi_owner_id=user_master.user_id','left');
		
		$this->db->where('taxi_directory.status !=','archived');
		if($option=='taxi_company')
		{
			$this->db->like('taxi_company',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->or_like('taxi_company',$val);
				}	
			}

		}

      if($option=='city')
		{
			$this->db->like('city',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->or_like('city',$val);
				}	
			}

		}

       if($option=='state')
		{
			$this->db->like('state',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->or_like('state',$val);
				}	
			}

		}
		
		if($option=='phone_number')
		{
			$this->db->like('phone_number',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->or_like('phone_number',$val);
				}	
			}

		}
	  
      
		
		$this->db->order_by('taxi_id','desc');
		$this->db->limit($limit,$offset);
		
		$query = $this->db->get();
		
		
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
	
	
	/* insert taxi attachment
	 * param :taxi id, file
	 */	
	
	function get_taxi_comment_result($id = 0)
   {
   
		$this->db->select("*");
		$this->db->from("taxi_comment c");
		$this->db->join("user_master u","c.user_id = u.user_id","LEFT");
		$this->db->where("c.master_comment_id","0");
		$this->db->where("c.taxi_id",$id);
		
		$qry = $this->db->get();
		if($qry->num_rows()>0)
		{
		   return  $qry->result();
			
		}
		return 0;
   }
   
   function get_taxi_subcomment_result($id = 0)
   {
   
		$this->db->select("*");
		$this->db->from("taxi_comment c");
		$this->db->join("user_master u","c.user_id = u.user_id","LEFT");
		$this->db->where("c.master_comment_id",$id);
		
		$qry = $this->db->get();
		if($qry->num_rows()>0)
		{
		   return  $qry->result();
			
		}
		return 0;
   }
   
  function importcsv()
	{
			 $this->db->_protect_identifiers=false;
		         ini_set('memory_limit', '2048M');
	        ini_set("display_errors",1);
			//require_once APPPATH.'excel_reader2.php';
			require_once(base_path()."/application/excel_reader2.php");
			$flag = true;
			$data = new Spreadsheet_Excel_Reader($_FILES['csv']['tmp_name']);
				$arr123 = 0;
			
			
			if($data->sheets[0]['numCols']==7){
for($i=0;$i<count($data->sheets);$i++) // Loop to get all sheets in a file.
{
	
	
	
	if(isset($data->sheets[$i]['cells']) && count($data->sheets[$i]['cells'])>0) // checking sheet not empty
	{
		for($j=1;$j<=count($data->sheets[$i]['cells']);$j++) // loop used to get each row of the sheet
		{
			
			//$checkbeername = 0;
			//$checkbeername = $this->beer_name_v((preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@@$data->sheets[$i]['cells'][$j][1]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][2]))),preg_replace('/[^A-Za-z0-9\- ]/', '', trim(@$data->sheets[$i]['cells'][$j][3])),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][4]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][5]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][6]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][7]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][8]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][9]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][10]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][11]))));
			
			$checkbeername = $this->taxi_name_v(trim(@$data->sheets[$i]['cells'][$j][1]),trim(@$data->sheets[$i]['cells'][$j][2]),trim(@$data->sheets[$i]['cells'][$j][3]),trim(@$data->sheets[$i]['cells'][$j][4]),trim(@$data->sheets[$i]['cells'][$j][5]),trim(@$data->sheets[$i]['cells'][$j][6]),trim(@$data->sheets[$i]['cells'][$j][7]));
					//		 $slug=getBeerSlug(preg_replace('/[^A-Za-z0-9\- ]/', '', trim(@$data->sheets[$i]['cells'][$j][1])));
							 
							 		
						if(isset($data->sheets[$i]['cells'][$j][1]) && $checkbeername==0 && $data->sheets[$i]['cells'][$j][1]!="Company Name")
						
						//if($checkbeername==0)
						{
								$getadd = explode(",",$data->sheets[$i]['cells'][$j][3]);
							
							
			$arr=array(
			                        
										'taxi_company'=>isset($data->sheets[$i]['cells'][$j][1]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][1])):'' ,
										'phone_number'=>isset($data->sheets[$i]['cells'][$j][2]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][2])):'' ,
										'address'=>isset($data->sheets[$i]['cells'][$j][3]) ? utf8_encode(trim($getadd[0])):'' ,
										'city'=>isset($data->sheets[$i]['cells'][$j][4]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][4])):'' ,
										'state'=>isset($data->sheets[$i]['cells'][$j][5]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][5])):'' ,
										'cmpn_zipcode'=>isset($data->sheets[$i]['cells'][$j][6]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][6])):'' ,
										'cmpn_website'=>isset($data->sheets[$i]['cells'][$j][7]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][7])):'' ,
										'is_deleted'=>'no',
										'status'=>'active',
										'date_added'=>date('Y-m-d H:i:s'),
										);
										
									
			
			$this->db->insert('taxi_directory',$arr,FALSE);	
			
			
			
			}
			else if(isset($data->sheets[$i]['cells'][$j][1]))
			//else
							{
								
								 $arr123 .= $j.'*';
							}

		}

              

								$result="Successfully";	
							$msg="Import Successfully";	
							$limit=20;
							$offset=0;
							
							if($arr123==0)
							{
								redirect('taxi/list_taxi/'.$limit.'/'.$offset.'/'.$result.'/'.base64_encode(0).'/'.base64_encode($data->sheets[0]['numRows']));
							}
							else {
								redirect('taxi/list_taxi/'.$limit.'/'.$offset.'/'.$result.'/'.base64_encode($arr123).'/'.base64_encode($data->sheets[0]['numRows']));
							}

	}
  
  } 
}

else {
		//$msg = "xls_not_valid";
		$msg = "xls_not_valid-".$data->sheets[0]['numCols']."";
								redirect('taxi/import_taxi/'.$msg);	
	
}
		
	} 
   function reply_insert($data)
   {
   	  $data["date_added"] = date("Y-m-d h:i:s");
	  
	  $this->db->insert("taxi_comment",$data);
   }
}
?>