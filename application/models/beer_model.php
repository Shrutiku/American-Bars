<?php
class Beer_model extends CI_Model 
{
	function Beer_model()
    {
        parent::__construct();	
    } 	
	
	function get_total_beer_count($keyword = 0, $alpha ='')
	{
		$this->db->select("*");
		$this->db->from("beer_directory");
		$this->db->where('status','active');
		$this->db->where('is_deleted','no');
		if($alpha != "" && $alpha != "no")
		{
			if($alpha=="'-#")
			{
				 $this->db->where("( `beer_name` LIKE '#%'  OR `beer_name` LIKE '\'%' OR `beer_name` LIKE '\"%' OR `beer_name` LIKE '@%' OR `beer_name` LIKE '#%' OR `beer_name` LIKE '\%%' OR `beer_name` LIKE '$%' OR `beer_name` LIKE '!%' OR `beer_name` LIKE ',%') ", NULL, 'FALSE');
				//$this->db->where("( `beer_name` LIKE '#%'    )", NULL, 'FALSE');
				 // $this->db->like("beer_name","'","after");
				 // $this->db->or_like("beer_name",'"',"after");
				 // $this->db->or_like("beer_name",'@',"after");
				 // $this->db->or_like("beer_name",'#',"after");
				 // $this->db->or_like("beer_name",'%',"after");
				 // $this->db->or_like("beer_name",'$',"after");
				 // $this->db->or_like("beer_name",'!',"after");
				 // $this->db->or_like("beer_name",',',"after");
			}
			else if($alpha=="0-9")
			{
				$this->db->where("(`beer_name` LIKE '1%' OR `beer_name` LIKE '2%' OR `beer_name` LIKE '3%' OR `beer_name` LIKE '4%' OR `beer_name` LIKE '5%' OR `beer_name` LIKE '6%' OR `beer_name` LIKE '7%' OR `beer_name` LIKE '8%' OR `beer_name` LIKE '9%'   )", NULL, 'FALSE');
				// $this->db->like("beer_name","0","after");
				 // $this->db->or_like("beer_name",'1',"after");
				 // $this->db->or_like("beer_name",'2',"after");
				 // $this->db->or_like("beer_name",'3',"after");
				 // $this->db->or_like("beer_name",'4',"after");
				 // $this->db->or_like("beer_name",'5',"after");
				 // $this->db->or_like("beer_name",'6',"after");
				 // $this->db->or_like("beer_name",'7',"after");
				 // $this->db->or_like("beer_name",'8',"after");
				 // $this->db->or_like("beer_name",'9',"after");
			}
			else {
				  $this->db->like("beer_name",$alpha,'after');
			}
		  
		}
		
		if($keyword != '0')
		{
			$en12 = '';
			$en34 = '';
			//$this->db->like("bar_title",$bar_title);
			//$this->db->or_like("zipcode",$bar_title);
			//$this->db->or_like("bar_desc",$bar_title);
			
			$en12.=" `beer_name` like ('%".mysql_real_escape_string($keyword)."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
											  
				  	foreach($ex as $val)
					{
						//echo strlen($val);
						$en34.=" `beer_name` like ('".mysql_real_escape_string($val)."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en12.substr($en34, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en12, 0 ,-3).')')  ;
		}
		}	

		$qry = $this->db->get();	
		
		// echo $this->db->last_query();	
		return $qry->num_rows();
	}
	
	function get_beer_result($offset = 0,$limit = 0,$sort_by= '',$sort_type = '',$keyword = 0,$alpha ='')
	{
		$en ='';
		$this->db->_protect_identifiers=false; 
		//$this->db->query("CREATE FUNCTION  regex_replace (pattern VARCHAR(1000),replacement VARCHAR(1000),original VARCHAR(1000))");
		/*$this->db->select("v.*,c.category_name,u.first_name,u.last_name");
		$this->db->from("beer_directory v");
		$this->db->join("category c","c.category_id = v.beer_category_id");
		$this->db->join("user_master u","u.user_id = v.user_id","LEFT");*/
		//$this->db->select('*, beer_name REGEXP "[\"#0-9\']+" as t');
		
		//$this->db->select('*, regex_replace(beer_name, "[\"#0-9\']+", "Ww") as t');
		$this->db->select('*');
		$this->db->from("beer_directory");
		$this->db->where('status','active');
		$this->db->where('is_deleted','no');
		//$this->db->group_start();
		if($alpha != "" && $alpha != "no")
		{
			
			if($alpha=="'-#")
			{
				 $this->db->where("( `beer_name` LIKE '#%'  OR `beer_name` LIKE '\'%' OR `beer_name` LIKE '\"%' OR `beer_name` LIKE '@%' OR `beer_name` LIKE '#%' OR `beer_name` LIKE '\%%' OR `beer_name` LIKE '$%' OR `beer_name` LIKE '!%' OR `beer_name` LIKE ',%') ", NULL, 'FALSE');
				//$this->db->where("( `beer_name` LIKE '#%'     )", NULL, 'FALSE');
				 // $this->db->like("beer_name","'","after");
				 // $this->db->or_like("beer_name",'"',"after");
				 // $this->db->or_like("beer_name",'@',"after");
				 // $this->db->or_like("beer_name",'#',"after");
				 // $this->db->or_like("beer_name",'%',"after");
				 // $this->db->or_like("beer_name",'$',"after");
				 // $this->db->or_like("beer_name",'!',"after");
				 // $this->db->or_like("beer_name",',',"after");
			}
			else if($alpha=="0-9")
			{
				$this->db->where("(`beer_name` LIKE '1%' OR `beer_name` LIKE '2%' OR `beer_name` LIKE '3%' OR `beer_name` LIKE '4%' OR `beer_name` LIKE '5%' OR `beer_name` LIKE '6%' OR `beer_name` LIKE '7%' OR `beer_name` LIKE '8%' OR `beer_name` LIKE '9%'   )", NULL, 'FALSE');
				// $this->db->like("beer_name","0","after");
				 // $this->db->or_like("beer_name",'1',"after");
				 // $this->db->or_like("beer_name",'2',"after");
				 // $this->db->or_like("beer_name",'3',"after");
				 // $this->db->or_like("beer_name",'4',"after");
				 // $this->db->or_like("beer_name",'5',"after");
				 // $this->db->or_like("beer_name",'6',"after");
				 // $this->db->or_like("beer_name",'7',"after");
				 // $this->db->or_like("beer_name",'8',"after");
				 // $this->db->or_like("beer_name",'9',"after");
			}
		 else {
				  $this->db->like("beer_name",$alpha,'after');
			}
		}
		
		if($keyword != '0')
		{
			$en12 = '';
			$en34 = '';
			//$this->db->like("bar_title",$bar_title);
			//$this->db->or_like("zipcode",$bar_title);
			//$this->db->or_like("bar_desc",$bar_title);
			
			$en12.=" `beer_name` like ('%".mysql_real_escape_string($keyword)."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
											  
				  	foreach($ex as $val)
					{
						//echo strlen($val);
						$en34.=" `beer_name` like ('".mysql_real_escape_string($val)."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en12.substr($en34, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en12, 0 ,-3).')')  ;
		}
		}
		
		//$this->db->order_by($sort_by.' REGEXP "^[^A-Za-z]"', 'desc');
		//$this->db->order_by($sort_by , 'ASC');
		
		//$this->db->group_end();
		//$this->db->order_by($sort_by,$sort_type);
		//echo $keyword;
		if($keyword!='' && $keyword!='0' && $keyword!='1V1')
		{
			
		
			//echo $sort_type;
			if($sort_type=='')
			{
			//	echo "SDa";
		$this->db->order_by('CASE WHEN beer_name like "'.$keyword.'" THEN 0
            WHEN beer_name like "'.$keyword.' %" THEN 1
           WHEN beer_name like "%'.$keyword .'" THEN 2
           ELSE beer_name 
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
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		
		
		//echo $this->db->last_query();
		if($qry->num_rows()>0)
		{
			 return $qry->result();
		}
		
		
		return 0;
	}
	
	
	function get_one_beer($id = 0)
	{
		$this->db->select('*');		
		$this->db->from('beer_directory');
		$this->db->where('beer_id',$id);

		$qry = $this->db->get();
		if($qry->num_rows()>0)
		{
			 return $qry->row_array();
		}
		return 0;
	}
	function get_beer_likers($id=0){
		$this->db->select('a.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('all_likes a');		
		$this->db->join('user_master u','u.user_id=a.user_id');
		$this->db->where('a.beer_id',$id);
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
	
	function get_all_beer_likers($id=0){
		$this->db->select('a.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('all_likes a');		
		$this->db->join('user_master u','u.user_id=a.user_id');
		$this->db->where('a.beer_id',$id);
		$this->db->where('like_flag',1);
		$this->db->order_by('date_added','asc');
		$this->db->group_by('user_id');
		$qry = $this->db->get();
		if($qry->num_rows() >0){
			return $qry->result();
		}
//		print_r($qry);die;
	}
	
	function get_beer_comments_count($id=0){
		$this->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('beer_comment b');		
		$this->db->join('user_master u','u.user_id=b.user_id','left');
		$this->db->where('b.beer_id',$id);
		$this->db->where('b.is_deleted',0);
		$this->db->where('b.status','active');
		$this->db->where('b.master_comment_id',0);
		$this->db->order_by('date_added','desc');
		$qry = $this->db->get();
		
		return $qry->num_rows();
//		print_r($qry);die;
	}
	
	
	function get_beer_comments($id=0,$limit = 0,$offset = 0){
		$this->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('beer_comment b');		
		$this->db->join('user_master u','u.user_id=b.user_id','left');
		$this->db->where('b.beer_id',$id);
		$this->db->where('b.is_deleted',0);
		$this->db->where('b.status','active');
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
			
	
		
		$data_insert["user_id"] = $this->session->userdata("user_id");
		$data_insert["status"] = "active";
		//$data_insert["comment_video"] = $this->input->post('comment_video');
		$data_insert["date_added"] = date("Y-m-d H:i:s");
		$data_insert["is_deleted"] = "0";
	
	 
		$this->db->insert("beer_comment",$data_insert);
		
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
	
		$this->db->insert("beer_comment",$data_insert);
		
		
		return mysql_insert_id();
	}
	function get_beer_subcomments($id=0){
		$this->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('beer_comment b');		
		$this->db->join('user_master u','u.user_id=b.user_id');
		//$CI->db->join('beer_comment bc','bc.master_comment_id=b.beer_comment_id');
		$this->db->where('b.master_comment_id!=','0',false);
		$this->db->where('b.beer_id',$id);
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
	function single_comment_total_likes($beer_id,$comment_id){
		$this->db->select('*');
		$this->db->from('all_likes');
		$this->db->where('beer_id',$beer_id);
		$this->db->where('beer_comment_id',$comment_id);
		$this->db->where('like_flag',1);
		
		$query = $this->db->get();
		if($query->num_rows() >0){	     
			return $query->num_rows();
		} 
	}
	
	function flag_return($beer_id,$user_id,$comment_id){
		$this->db->select('like_flag');
		$this->db->from('all_likes');
		$this->db->where('beer_id',$beer_id);
		$this->db->where('user_id',$user_id);
		$this->db->where('beer_comment_id',$comment_id);
		$query = $this->db->get();
		if($query->num_rows() >0){
			return $query->row()->like_flag;
		}
	}
	function sub_comment_remove($beer_comment_id){
		$data_update = array('is_deleted'=>1);
		$this->db->where('beer_comment_id',$beer_comment_id);
		$this->db->update('beer_comment',$data_update);
	}
	function one_beer_likers($id=0){
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
	function auto_suggest_beer($q){
		$this->db->like('beer_name',$q,'after');
		$this->db->select('beer_name,beer_id');
		$this->db->from('beer_directory');
		$this->db->where('status','active');
		$this->db->where('is_deleted','no');
		if(strlen($q)>=4)
		{
			$this->db->limit(100);
		}
		else {
			$this->db->limit(10);
		}
		$query = $this->db->get();
		
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
		return 0;
	}
	
	function getBeerIdByNext($id,$ord)
	{
		$this->db->select('beer_slug,beer_id');
		$this->db->from('beer_directory');
		$this->db->where('status','active');
		$this->db->where('is_deleted','no');
		if($ord=='asc')
		{
		$this->db->where('beer_id >',$id);
		}
		if($ord=='desc')
		{
		$this->db->where('beer_id <',$id);
		}
		
		$this->db->order_by('beer_id',$ord);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return 0;
	}
}	
?>