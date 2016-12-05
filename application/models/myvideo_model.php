<?php
class Myvideo_model extends CI_Model {
	
    function Myvideo_model()
    {
        parent::__construct();
	} 
	function get_total_video_count($id)
	{
		$this->db->select('v.*,c.category_name');
		$this->db->from('video v');
		$this->db->join("category c","c.category_id = v.video_category_id","left");
		$this->db->where('user_id',get_authenticateUserID());
		$query = $this->db->get();
		return $query->num_rows();	
	}
	  
	function get_video_result_by_user($user_id,$offset=0, $limit=0)
	{
		$this->db->select("v.*,c.category_name");
		$this->db->from('video v');
		$this->db->join("category c","c.category_id = v.video_category_id","left");
		$this->db->where('user_id',$user_id);
		$this->db->limit($limit,$offset);
		
		$query = $this->db->get();
		 //echo $this->db->last_query(); die;
		 if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	function get_category_result() {
		$this->db->where('category_type',"video");
		$this->db->order_by('category_id','asc');
		$query = $this->db->get('category');
	
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		//echo $this->db->last_query(); die;
		return 0;
	}
	
	function get_membership_result() {
		$this->db->where('status',"active");
		$this->db->order_by('membership_plan_id','asc');
		$query = $this->db->get('membership_plan');
	
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		//echo $this->db->last_query(); die;
		return 0;
	}
	
	function insert_myvideo()
	{
			//print_r($res); die;
			//echo "hhh"; die;
			$data_array=array();
					  $data_insert["video_title"] = $this->input->post('video_title');
					  $data_insert["video_desc"] = $this->input->post('video_desc');
					  $data_insert["video_price"] = $this->input->post('video_price');
			
		$image_setting = image_setting();
		$video_image='';
		if($_FILES['video_image']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['video_image']['name'];
             $_FILES['userfile']['type']     =   $_FILES['video_image']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['video_image']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['video_image']['error'];
             $_FILES['userfile']['size']     =   $_FILES['video_image']['size'];
   
			$config['file_name'] = 'video'.$rand;
			
            $config['upload_path'] = base_path().'upload/video_image/';
			
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				echo $error =  $this->upload->display_errors(); die;   
			  } 
			
			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   
              $this->image_lib->clear();
		   	
			
					$gd_var='gd2';
				
				
		   if ($_FILES["video_image"]["type"]!= "image/png" and $_FILES["video_image"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["video_image"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["video_image"]["type"] != "image/jpeg" and $_FILES["video_image"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/video_image/'.$picture['file_name'],
				'new_image' => base_path().'upload/video_image/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => '685',
				'height' => '320',
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$video_image=$picture['file_name'];
			
		
			if($this->input->post('pre_video_image')!='')
				{
					if(file_exists(base_path().'upload/video_image/'.$this->input->post('pre_video_image')))
					{
						$link=base_path().'upload/video_image/'.$this->input->post('pre_video_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/video_image/'.$this->input->post('pre_video_image')))
					{
						$link2=base_path().'upload/video_image/'.$this->input->post('pre_video_image');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('pre_video_image')!='')
				{
					$video_image=$this->input->post('pre_video_image');
				}
			}		  
				
				 $videoname="";
		 if($_FILES["video_file_name"]["name"]!="")
         {
             $this->load->library("upload");
             $rand=rand(0,100000); 
			  
             $_FILES["userfile"]["name"]     =   $_FILES["video_file_name"]["name"];
             $_FILES["userfile"]["type"]     =   $_FILES["video_file_name"]["type"];
             $_FILES["userfile"]["tmp_name"] =   $_FILES["video_file_name"]["tmp_name"];
             $_FILES["userfile"]["error"]    =   $_FILES["video_file_name"]["error"];
             $_FILES["userfile"]["size"]     =   $_FILES["video_file_name"]["size"];
   
		
			
			$config["file_name"] = $this->input->post('video_file_name').$rand;
		 
            $config['upload_path']=base_path()."upload/video";
			
           // $config['allowed_types'] = 'avi|wmv|mpeg|mpg|mp4'; 
			 $config['allowed_types'] = '*';
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();
				echo $error ; die;   
			  } 
			 
           	    $picture = $this->upload->data();
			    $videoname=$picture["file_name"];
		        $data_insert["video_file_name"] = $videoname;
                }
				
			$video_preview="";
		 if($_FILES["video_preview_names"]["name"]!="")
         {
             $this->load->library("upload");
             $rand=rand(0,100000); 
			  
             $_FILES["userfile"]["name"]     =   $_FILES["video_preview_names"]["name"];
             $_FILES["userfile"]["type"]     =   $_FILES["video_preview_names"]["type"];
             $_FILES["userfile"]["tmp_name"] =   $_FILES["video_preview_names"]["tmp_name"];
             $_FILES["userfile"]["error"]    =   $_FILES["video_preview_names"]["error"];
             $_FILES["userfile"]["size"]     =   $_FILES["video_preview_names"]["size"];
   
		
			
			$config["file_name"] = $this->input->post('video_preview_names').$rand;
		 
            $config['upload_path']=base_path()."upload/video_preview";
			
            $config['allowed_types'] = 'avi|wmv|mpeg|mpg|mp4';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				echo $error =  $this->upload->display_errors();   
			  	die;
			  } 
			 
           	    $picture1 = $this->upload->data();
			    $video_preview=$picture1["file_name"];
		        $data_insert["video_preview"] = $video_preview;
                }			
			
			 $data_insert["video_category_id"] = $this->input->post('video_category_id');
		     $data_insert["video_type"] = $this->input->post('video_type');
			 $data_insert['video_status']=$this->input->post('video_status');
			 $data_insert['date_created']=date('Y-m-d H:i:s');
			 $data_insert['ip_address']=$_SERVER['REMOTE_ADDR'];
			 $data_insert['video_image']=$video_image;
			// $data_insert['video_file_name']=$videoname;
			// $data_insert['video_preview']=$video_preview;
			 $data_insert['user_id']=get_authenticateUserID();
			//print_r($data_insert); die;
			$this->db->insert('video', $data_insert);
	}
	function get_one_video($id=0)
	{
	   $query = $this->db->get_where('video',array("video_id"=>$id));
		//return $query->row_array();
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return 0;
	}
	function update_video()
	{
		$image_setting = image_setting();
		$video_image='';
		if($_FILES['video_image']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['video_image']['name'];
             $_FILES['userfile']['type']     =   $_FILES['video_image']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['video_image']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['video_image']['error'];
             $_FILES['userfile']['size']     =   $_FILES['video_image']['size'];
   
			$config['file_name'] = 'video'.$rand;
			
            $config['upload_path'] = base_path().'upload/video_image/';
			
            $config['allowed_types'] = '*';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				echo $error =  $this->upload->display_errors(); die;   
			  } 
			
			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   
              $this->image_lib->clear();
		   	
			
					$gd_var='gd2';
				
				
		   if ($_FILES["video_image"]["type"]!= "image/png" and $_FILES["video_image"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["video_image"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["video_image"]["type"] != "image/jpeg" and $_FILES["video_image"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/video_image/'.$picture['file_name'],
				'new_image' => base_path().'upload/video_image/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => '685',
				'height' => '320',
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$video_image=$picture['file_name'];
			
		
			if($this->input->post('pre_video_image')!='')
				{
					if(file_exists(base_path().'upload/user/'.$this->input->post('pre_video_image')))
					{
						$link=base_path().'upload/video_image/'.$this->input->post('pre_video_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/video_image/'.$this->input->post('pre_video_image')))
					{
						$link2=base_path().'upload/video_image/'.$this->input->post('pre_video_image');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('pre_video_image')!='')
				{
					$video_image=$this->input->post('pre_video_image');
				}
			}
		
	$data_update=array();
					  $data_update["video_title"] = $this->input->post('video_title');
					  $data_update["video_desc"] = $this->input->post('video_desc');
					  $data_update["video_price"] = $this->input->post('video_price');
					  $data_update["video_type"] = $this->input->post('video_type');
				
	$videoname="";		
		 if($_FILES["video_file_name"]["name"]!="")
         {
             $this->load->library("upload");
             $rand=rand(0,100000); 
			  
             $_FILES["userfile"]["name"]     =   $_FILES["video_file_name"]["name"];
             $_FILES["userfile"]["type"]     =   $_FILES["video_file_name"]["type"];
             $_FILES["userfile"]["tmp_name"] =   $_FILES["video_file_name"]["tmp_name"];
             $_FILES["userfile"]["error"]    =   $_FILES["video_file_name"]["error"];
             $_FILES["userfile"]["size"]     =   $_FILES["video_file_name"]["size"];
   
		
			
			$config["file_name"] = $this->input->post('video_name').$rand;
		 
            $config['upload_path']=base_path()."upload/video";
			
            $config['allowed_types'] = '*';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			 
           	    $picture = $this->upload->data();
			    $videoname=$picture["file_name"];
		      //  $data_insert["video"] = $videoname;
			      if($this->input->post("prev_video")!="")
				{
					if(file_exists(base_path()."upload/video/".$this->input->post("prev_video")))
					{
						$link=base_path()."upload/video/".$this->input->post("prev_video");
						unlink($link);
					}
					
				
				} 
                }
		else {
				if($this->input->post("pre_file_up_video"))
				{
					$videoname=$this->input->post("pre_file_up_video");
				}
		   }
			$video_preview="";		
		 if($_FILES["video_file_name"]["name"]!="")
         {
             $this->load->library("upload");
             $rand=rand(0,100000); 
			  
             $_FILES["userfile"]["name"]     =   $_FILES["video_file_name"]["name"];
             $_FILES["userfile"]["type"]     =   $_FILES["video_file_name"]["type"];
             $_FILES["userfile"]["tmp_name"] =   $_FILES["video_file_name"]["tmp_name"];
             $_FILES["userfile"]["error"]    =   $_FILES["video_file_name"]["error"];
             $_FILES["userfile"]["size"]     =   $_FILES["video_file_name"]["size"];
   
		
			
			$config["file_name"] = $this->input->post('video_name').$rand;
		 
            $config['upload_path']=base_path()."upload/video_preview";
			
            $config['allowed_types'] = '*';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  	//echo $error; die;
			  } 
			 
           	    $picture = $this->upload->data();
			    $video_preview=$picture["file_name"];
		      //  $data_insert["video"] = $video_preview;
			      if($this->input->post("prev_video")!="")
				{
					if(file_exists(base_path()."upload/video/".$this->input->post("prev_video")))
					{
						$link=base_path()."upload/video/".$this->input->post("prev_video");
						unlink($link);
					}
					
				
				} 
                }
		else {
				if($this->input->post("pre_video_preview"))
				{
					$video_preview=$this->input->post("pre_video_preview");
				}
		   }			
		   
		              $data_update['video_file_name']=$videoname;
			          $data_update['video_preview']=$video_preview;
					
					  $data_update["video_category_id"] = $this->input->post('video_category_id');
					  $data_update["video_status"] = $this->input->post('status');
					  //$data_update["ip_address"] = $_SERVER['REMOTE_ADDR'];
					  //$data_update['date_created']=date('Y-m-d H:i:s');
					  $data_update['video_image ']=$video_image;						
		
		//print_r($data_update); die;	
		$this->db->where("video_id",$this->input->post("video_id"));
		$this->db->update('video',$data_update);
		
	}
	function get_search_video_result($limit = 0,$option='',$keyword='',$offset = 0)
	{
		//echo $option;
	   $keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
	   $this->db->select('v.*,c.category_name');
		$this->db->from('video v');
		$this->db->join("category c","c.category_id = v.video_category_id","left");
		$this->db->where('user_id',get_authenticateUserID());
		//$this->db->join("user_master u","m.user_id = u.user_id","left");
			if($option=="video_title")
				{
				   $this->db->like("video_title",$keyword);
				   
				   if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('video_title',$val);
					}	
				}
				}
				if($option=="video_price")
				{
				   $this->db->like("video_price",$keyword);
				   
				   if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('video_price',$val);
					}	
				}
				}
				if($option=="video_type")
				{
				   $this->db->like("video_type",$keyword);
				   
				   if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('video_typee',$val);
					}	
				}
				}
				
		$this->db->order_by("video_id", "desc"); 
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
		//echo $this->db->last_query(); die;	
			return $query->result();
		}
		
		return 0;
	
	}
	function get_total_search_video_count($option,$keyword)
	{
	  
	
		$this->db->select('v.*,c.category_name');
		//$this->db->join("category c","v.video_category_id = c.category_id","left");
		$this->db->from('video v');
		$this->db->join("category c","c.category_id = v.video_category_id","left");
		$this->db->where('user_id',get_authenticateUserID());
		if($option=="video_title")
		{
				   $this->db->like("video_title",$keyword);
				   
				   if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('video_title',$val);
					}	
				}
				
				
		}
		if($option=="video_price")
		{
				   $this->db->like("video_price",$keyword);
				   
				   if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('video_price',$val);
					}	
				}
				
				
		}
		if($option=="video_type")
		{
				   $this->db->like("video_type",$keyword);
				   
				   if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('video_type',$val);
					}	
				}
				
				
		}
		
		$this->db->order_by("video_id", "desc"); 
		
		
		
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		
		return $query->num_rows();
	}
	
	
	
}
?>