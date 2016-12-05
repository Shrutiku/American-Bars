<?php
class Resource_model extends CI_Model 
{
	function Resource_model()
    {
        parent::__construct();	
    } 	
	
	function get_total_resource_count($keyword = 0, $alpha ='',$resource_category=0)
	{
		$this->db->select("*");
		$this->db->from("resource");
		$this->db->where('status','active');
		
		if($alpha != "" && $alpha != "no")
		{
		   $this->db->like("resource_title",$alpha,"after");
		}
		
		if($keyword != '0')
		{
			$this->db->like("resource_title",$keyword,'after');
		 	/*
			$this->db->join("category c","c.category_id = b.resource_id");
		  	$this->db->join("user_master u","u.user_id = b.user_id","LEFT");
					  
		    if($type == "author" &&  $keyword != '0')
			{
				$this->db->like("u.first_name",$keyword,"after");
			}
			else if($type == "resource_title" &&  $keyword != '0')
			{
				$this->db->like("v.resource_title",$keyword,"after");
			}
			else if($type == "category" &&  $keyword != '0')
			{
				$this->db->like("c.category_name",$keyword,"after");
				$this->db->where("c.category_type","resource");
			}
			
			else
			{
				$this->db->like("v.resource_title",$keyword,"after");
				$this->db->or_like("v.resource_title",$keyword,"after");
				$this->db->or_like("c.category_name",$keyword,"after");
				$this->db->where("c.category_type","resource");
			}*/
		}		
		
		if($resource_category != '0')
		{
			$this->db->like('resource_category',$resource_category,'after');

		}
		$qry = $this->db->get();		
		return $qry->num_rows();
	}
	
	function get_resource_result($offset = 0,$limit = 0,$sort_by= '',$sort_type = '',$keyword = 0,$alpha ='',$resource_category=0)
	{
		/*$this->db->select("v.*,c.category_name,u.first_name,u.last_name");
		$this->db->from("resource v");
		$this->db->join("category c","c.category_id = v.resource_category_id");
		$this->db->join("user_master u","u.user_id = v.user_id","LEFT");*/
		$this->db->select('*');
		$this->db->from("resource");
		$this->db->where('status','active');
		
		if($alpha != "" && $alpha != "no")
		{
		   $this->db->like("resource_title",$alpha,"after");
		}
		
		if($keyword != '0')
		{
			$this->db->like("resource_title",$keyword,'after');
		   /* if($type == "author" &&  $keyword != '0')
			{
				$this->db->like("u.first_name",$keyword,"after");
			}
			else if($type == "resource_title" &&  $keyword !='0')
			{
				$this->db->like("v.resource_title",$keyword,"after");
			}
			else if($type == "category" &&  $keyword != '0')
			{
				$this->db->like("c.category_name",$keyword,"after");
				$this->db->where("c.category_type","resource");
			}
			
			else
			{
				$this->db->like("v.resource_title",$keyword,"after");
				$this->db->or_like("v.resource_title",$keyword,"after");
				$this->db->or_like("c.category_name",$keyword,"after");
				$this->db->where("c.category_type","resource");
			}*/
		}
		if($resource_category != '0')
		{
			$this->db->like('resource_category',$resource_category,'after');

		}
		$this->db->order_by($sort_by,$sort_type);
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		
		if($qry->num_rows()>0)
		{
			 return $qry->result();
		}
		
		
		return 0;
	}
	
	
	function get_one_resource($id = 0)
	{
		$this->db->select('*');		
		$this->db->from('resource');
		$this->db->where('resource_id',$id);

		$qry = $this->db->get();
		if($qry->num_rows()>0)
		{
			 return $qry->row_array();
		}
		return 0;
	}
	function get_resource_likers($id=0){
		$this->db->select('a.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('all_likes a');		
		$this->db->join('user_master u','u.user_id=a.user_id');
		$this->db->where('a.resource_id',$id);
		$this->db->where('like_flag',1);
		$this->db->order_by('date_added','asc');
		$this->db->group_by('user_id');
		$this->db->limit(10);
		$qry = $this->db->get();
		if($qry->num_rows() >0){
			return $qry->result();
		}
//		print_r($qry);die;
	}
	
	function get_all_resource_likers($id=0){
		$this->db->select('a.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('all_likes a');		
		$this->db->join('user_master u','u.user_id=a.user_id');
		$this->db->where('a.resource_id',$id);
		$this->db->where('like_flag',1);
		$this->db->order_by('date_added','asc');
		$this->db->group_by('user_id');
		$qry = $this->db->get();
		if($qry->num_rows() >0){
			return $qry->result();
		}
//		print_r($qry);die;
	}
	
	function get_resource_comments_count($id=0){
		$this->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('resource_comment b');		
		$this->db->join('user_master u','u.user_id=b.user_id','left');
		$this->db->where('b.resource_id',$id);
		$this->db->where('b.is_deleted',0);
		$this->db->where('b.master_comment_id',0);
		$this->db->order_by('date_added','desc');
		$qry = $this->db->get();
		
		return $qry->num_rows();
//		print_r($qry);die;
	}
	
	
	function get_resource_comments($id=0,$limit = 0,$offset = 0){
		$this->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('resource_comment b');		
		$this->db->join('user_master u','u.user_id=b.user_id','left');
		$this->db->where('b.resource_id',$id);
		$this->db->where('b.is_deleted',0);
		$this->db->where('b.master_comment_id',0);
		$this->db->order_by('date_added','desc');
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		if($qry->num_rows() >0){
			return $qry->result();
		}

	}
	
	

	function insert_comment($data_insert = array())
	{
		
		$image_setting = image_setting();
		$data_insert['comment_image']='';
		//print_r($_FILES);die;
		if(isset($_FILES['comment_image']) && $_FILES['comment_image']["name"]!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
            $_FILES['userfile']['name']     =   $_FILES['comment_image']['name'];
             $_FILES['userfile']['type']     =   $_FILES['comment_image']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['comment_image']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['comment_image']['error'];
             $_FILES['userfile']['size']     =   $_FILES['comment_image']['size'];
   
			$config['file_name'] = 'comment'.$rand;
			
            $config['upload_path'] = base_path().'upload/comment_image/';
			
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
				
				
		   if ($_FILES["comment_image"]["type"]!= "image/png" and $_FILES["comment_image"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["comment_image"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["comment_image"]["type"] != "image/jpeg" and $_FILES["comment_image"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			resize(base_path().'upload/comment_image/'.$picture['file_name'],base_path().'upload/comment_image/'.$picture['file_name'],698,270);
			$data_insert['comment_image']= $picture['file_name'];
			
		
			if($this->input->post('pre_comment_image')!='')
				{
					if(file_exists(base_path().'upload/comment_image/'.$this->input->post('pre_profile_image')))
					{
						$link=base_path().'upload/comment_image/'.$this->input->post('pre_profile_image');
						unlink($link);
					}			
				}
			}
			else {
				if($this->input->post('pre_comment_image')!='')
				{
					$data_insert['comment_image']=$this->input->post('pre_comment_image');
				}
			}
			
			
		// ///////////////// VIDEO UPLOAD////////////////////////////
		
	//	 $data_insert['comment_video']="";		
		 // if(isset($_FILES["comment_video"]) && $_FILES["comment_video"]["name"]!="")
         // {
             // $this->load->library("upload");
             // $rand=rand(0,100000); 
// 			  
             // $_FILES["userfile"]["name"]     =   $_FILES["comment_video"]["name"];
             // $_FILES["userfile"]["type"]     =   $_FILES["comment_video"]["type"];
             // $_FILES["userfile"]["tmp_name"] =   $_FILES["comment_video"]["tmp_name"];
             // $_FILES["userfile"]["error"]    =   $_FILES["comment_video"]["error"];
             // $_FILES["userfile"]["size"]     =   $_FILES["comment_video"]["size"];
//    
// 		
// 			
			// $config["file_name"] = $this->input->post('comment_video').$rand;
// 		 
            // $config['upload_path']=base_path()."upload/comment_video";
// 			
            // $config['allowed_types'] = '*';  
//  
             // $this->upload->initialize($config);
//  
              // if (!$this->upload->do_upload())
			  // {
				// $error =  $this->upload->display_errors();   
			  // } 
// 			 
           	    // $picture = $this->upload->data();
			    // $data_insert['comment_video']=$picture["file_name"];
		      // //  $data_insert["video"] = $videoname;
			      // if($this->input->post("prev_comment_video")!="")
				// {
					// if(file_exists(base_path()."upload/comment_video/".$this->input->post("prev_comment_video")))
					// {
						// $link=base_path()."upload/comment_video/".$this->input->post("prev_comment_video");
						// unlink($link);
					// }
// 					
// 				
				// } 
                // }
		// else {
				// if($this->input->post("pre_comment_video"))
				// {
					// $videoname=$this->input->post("pre_comment_video");
				// }
		   // }
		// ///////////////// VIDEO UPLOAD////////////////////////////		
		
		$data_insert["user_id"] = $this->session->userdata("user_id");
		$data_insert["status"] = "active";
		//$data_insert["comment_video"] = $this->input->post('comment_video');
		$data_insert["date_added"] = date("Y-m-d H:i:s");
		$data_insert["is_deleted"] = "0";
	
		$this->db->insert("resource_comment",$data_insert);
		
		return mysql_insert_id();
	}
	
	function insert_subcomment($data_insert = array())
	{
		
		$image_setting = image_setting();
		$data_insert['comment_image']='';
		//print_r($_FILES);die;
		if(isset($_FILES['comment_image']) && $_FILES['comment_image']["name"]!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
            $_FILES['userfile']['name']     =   $_FILES['comment_image']['name'];
             $_FILES['userfile']['type']     =   $_FILES['comment_image']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['comment_image']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['comment_image']['error'];
             $_FILES['userfile']['size']     =   $_FILES['comment_image']['size'];
   
			$config['file_name'] = 'subcomment'.$rand;
			
            $config['upload_path'] = base_path().'upload/comment_image/';
			
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
				
				
		   if ($_FILES["comment_image"]["type"]!= "image/png" and $_FILES["comment_image"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["comment_image"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["comment_image"]["type"] != "image/jpeg" and $_FILES["comment_image"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			resize(base_path().'upload/comment_image/'.$picture['file_name'],base_path().'upload/comment_image/'.$picture['file_name'],596,232);
			
			
			$data_insert['comment_image']= $picture['file_name'];
			
		
			if($this->input->post('pre_comment_image')!='')
				{
					if(file_exists(base_path().'upload/comment_image/'.$this->input->post('pre_profile_image')))
					{
						$link=base_path().'upload/comment_image/'.$this->input->post('pre_profile_image');
						unlink($link);
					}			
				}
			}
			else {
				if($this->input->post('pre_comment_image')!='')
				{
					$data_insert['comment_image']=$this->input->post('pre_comment_image');
				}
			}
			
			
		// ///////////////// VIDEO UPLOAD////////////////////////////
		
		 $data_insert['comment_video']="";		
		 if(isset($_FILES["comment_video"]) && $_FILES["comment_video"]["name"]!="")
         {
             $this->load->library("upload");
             $rand=rand(0,100000); 
			  
             $_FILES["userfile"]["name"]     =   $_FILES["comment_video"]["name"];
             $_FILES["userfile"]["type"]     =   $_FILES["comment_video"]["type"];
             $_FILES["userfile"]["tmp_name"] =   $_FILES["comment_video"]["tmp_name"];
             $_FILES["userfile"]["error"]    =   $_FILES["comment_video"]["error"];
             $_FILES["userfile"]["size"]     =   $_FILES["comment_video"]["size"];
   
		
			
			$config["file_name"] = $this->input->post('comment_video').$rand;
		 
            $config['upload_path']=base_path()."upload/comment_video";
			
            $config['allowed_types'] = '*';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			 
           	    $picture = $this->upload->data();
			    $data_insert['comment_video']=$picture["file_name"];
		      //  $data_insert["video"] = $videoname;
			      if($this->input->post("prev_comment_video")!="")
				{
					if(file_exists(base_path()."upload/comment_video/".$this->input->post("prev_comment_video")))
					{
						$link=base_path()."upload/comment_video/".$this->input->post("prev_comment_video");
						unlink($link);
					}
					
				
				} 
                }
		else {
				if($this->input->post("pre_comment_video"))
				{
					$videoname=$this->input->post("pre_comment_video");
				}
		   }
		// ///////////////// VIDEO UPLOAD////////////////////////////		
		
		$data_insert["user_id"] = $this->session->userdata("user_id");
		$data_insert["status"] = "active";
		$data_insert["date_added"] = date("Y-m-d H:i:s");
		$data_insert["is_deleted"] = "0";
	
		$this->db->insert("resource_comment",$data_insert);
		
		
		return mysql_insert_id();
	}
	function get_resource_subcomments($id=0){
		$this->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('resource_comment b');		
		$this->db->join('user_master u','u.user_id=b.user_id');
		//$CI->db->join('resource_comment bc','bc.master_comment_id=b.resource_comment_id');
		$this->db->where('b.master_comment_id!=','0',false);
		$this->db->where('b.resource_id',$id);
		$this->db->where('b.is_deleted',0);
		$this->db->order_by('date_added','desc');
		$qry = $this->db->get();		
		if($qry->num_rows() >0){
			$temp_arr = $qry->result();
			$res = array();
			$i =0;
			foreach($temp_arr as $temp){
				$res[$temp->master_comment_id][$i] = $temp;
				$i++;
			}
			return $res;
		}
	}
	function single_comment_total_likes($resource_id,$comment_id){
		$this->db->select('*');
		$this->db->from('all_likes');
		$this->db->where('resource_id',$resource_id);
		$this->db->where('resource_comment_id',$comment_id);
		$this->db->where('like_flag',1);
		
		$query = $this->db->get();
		if($query->num_rows() >0){	     
			return $query->num_rows();
		} 
	}
	
	function flag_return($resource_id,$user_id,$comment_id){
		$this->db->select('like_flag');
		$this->db->from('all_likes');
		$this->db->where('resource_id',$resource_id);
		$this->db->where('user_id',$user_id);
		$this->db->where('resource_comment_id',$comment_id);
		$query = $this->db->get();
		if($query->num_rows() >0){
			return $query->row()->like_flag;
		}
	}
	function sub_comment_remove($resource_comment_id){
		$data_update = array('is_deleted'=>1);
		$this->db->where('resource_comment_id',$resource_comment_id);
		$this->db->update('resource_comment',$data_update);
	}
	function one_resource_likers($id=0){
		$this->db->select('*');
		$this->db->from('user_master');		
		$this->db->where('user_id',$id);
		$qry = $this->db->get();
		if($qry->num_rows()>0){
			//echo '==>'.$qry->row()->profile_image;die;
			//return $qry->row()->profile_image;
			return $qry->row();
		}
		else{
			return '';
		}
	}
	function auto_suggest_resource($q){
		$this->db->like('resource_title',$q);
		$this->db->select('resource_title,resource_id');
		$this->db->from('resource');
		$this->db->where('status','active');
		
		$query = $this->db->get();
		
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
		return 0;
	}
}	
?>