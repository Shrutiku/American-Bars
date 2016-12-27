<?php
class Liquor_model extends CI_Model 
{
	function Liquor_model()
    {
        parent::__construct();	
    } 	
	
	function get_total_liquor_count($keyword = 0, $alpha ='')
	{
		$this->db->select("*");
		$this->db->from("liquors");
		$this->db->where('status','active');
		$this->db->where('is_deleted','no');
		if($alpha != "" && $alpha != "no")
		{
			if($alpha=="'-#")
			{
				 $this->db->like("liquor_title","'","after");
				 $this->db->or_like("liquor_title",'"',"after");
				 $this->db->or_like("liquor_title",'@',"after");
				 $this->db->or_like("liquor_title",'#',"after");
				 $this->db->or_like("liquor_title",'%',"after");
				 $this->db->or_like("liquor_title",'$',"after");
				 $this->db->or_like("liquor_title",'!',"after");
				 $this->db->or_like("liquor_title",',',"after");
			}
			else if($alpha=="0-9")
			{
				$this->db->like("liquor_title","0","after");
				 $this->db->or_like("liquor_title",'1',"after");
				 $this->db->or_like("liquor_title",'2',"after");
				 $this->db->or_like("liquor_title",'3',"after");
				 $this->db->or_like("liquor_title",'4',"after");
				 $this->db->or_like("liquor_title",'5',"after");
				 $this->db->or_like("liquor_title",'6',"after");
				 $this->db->or_like("liquor_title",'7',"after");
				 $this->db->or_like("liquor_title",'8',"after");
				 $this->db->or_like("liquor_title",'9',"after");
			}
			else {
				  $this->db->like("liquor_title",$alpha,'after');
				
			}
		  
		}
		
		if($keyword != '0')
		{
			//$this->db->like("liquor_title",trim($keyword),"after");	
			//$this->db->where('(`liquor_title` LIKE  \'%'.mysql_real_escape_string($keyword).'%\' OR `type` LIKE \'%'.mysql_real_escape_string($keyword).'%\')', NULL, 'FALSE');
			//$this->db->where('(`liquor_title` LIKE  \'%'.mysql_real_escape_string($keyword).'%\')', NULL, 'FALSE');
			
			
			$en12 = '';
			$en34 = '';
			//$this->db->like("bar_title",$bar_title);
			//$this->db->or_like("zipcode",$bar_title);
			//$this->db->or_like("bar_desc",$bar_title);
			
			$en12.=" `liquor_title` like ('%".mysql_real_escape_string($keyword)."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
											  
				  	foreach($ex as $val)
					{
						//echo strlen($val);
						$en34.=" `liquor_title` like ('".mysql_real_escape_string($val)."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en12.substr($en34, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en12, 0 ,-3).')')  ;
		}
		}		
		$qry = $this->db->get();		
		return $qry->num_rows();
	}
	
	function get_suggested_liqour($id,$type,$limit)
	{
		$this->db->select('*');
		$this->db->from("cocktail_directory");
		$this->db->where('status','active');
		$this->db->where('base_spirit',"$type");
		$this->db->order_by('cocktail_id', 'RANDOM');
		$this->db->limit($limit);
		$qry = $this->db->get();
		 
		// echo $this->db->last_query();
	//	echo $qry->num_rows();
		//if($qry->num_rows()>0)
		//{
			 if($qry->num_rows()<10)
			 {
			 	  // echo $qry->num_rows();
			 		$this->db->select('*');
					$this->db->from("cocktail_directory");
					$this->db->where('status','active');
					$this->db->where('base_spirit !=',"$type");
					$this->db->order_by('cocktail_id', 'RANDOM');
					$this->db->limit(10-$qry->num_rows());
					$qry1 = $this->db->get();
			 	    return array_merge($qry->result(),$qry1->result());
			 }
		return $qry->result();
		//}
		
		
		//return '';
		
	}
	function get_liquor_result($offset = 0,$limit = 0,$sort_by= '',$sort_type = '',$keyword = 0,$alpha ='')
	{
		
		$this->db->_protect_identifiers=false; 
		$this->db->select('*');
		$this->db->from("liquors");
		$this->db->where('status','active');
		$this->db->where('is_deleted','no');
		if($alpha != "" && $alpha != "no")
		{
			if($alpha=="'-#")
			{
				 $this->db->like("liquor_title","'","after");
				 $this->db->or_like("liquor_title",'"',"after");
				 $this->db->or_like("liquor_title",'@',"after");
				 $this->db->or_like("liquor_title",'#',"after");
				 $this->db->or_like("liquor_title",'%',"after");
				 $this->db->or_like("liquor_title",'$',"after");
				 $this->db->or_like("liquor_title",'!',"after");
				 $this->db->or_like("liquor_title",',',"after");
			}
			else if($alpha=="0-9")
			{
				$this->db->like("liquor_title","0","after");
				 $this->db->or_like("liquor_title",'1',"after");
				 $this->db->or_like("liquor_title",'2',"after");
				 $this->db->or_like("liquor_title",'3',"after");
				 $this->db->or_like("liquor_title",'4',"after");
				 $this->db->or_like("liquor_title",'5',"after");
				 $this->db->or_like("liquor_title",'6',"after");
				 $this->db->or_like("liquor_title",'7',"after");
				 $this->db->or_like("liquor_title",'8',"after");
				 $this->db->or_like("liquor_title",'9',"after");
			}
			else {
				  $this->db->like("liquor_title",$alpha,'after');
			}
		  
		}
		
		if($keyword != '0')
		{
			//$this->db->like("liquor_title",trim($keyword),"after");	
			//$this->db->where('(`liquor_title` LIKE  \'%'.mysql_real_escape_string($keyword).'%\' OR `type` LIKE \'%'.mysql_real_escape_string($keyword).'%\')', NULL, 'FALSE');
			//$this->db->where('(`liquor_title` LIKE  \'%'.mysql_real_escape_string($keyword).'%\')', NULL, 'FALSE');
			
			
			$en12 = '';
			$en34 = '';
			//$this->db->like("bar_title",$bar_title);
			//$this->db->or_like("zipcode",$bar_title);
			//$this->db->or_like("bar_desc",$bar_title);
			
			$en12.=" `liquor_title` like ('%".mysql_real_escape_string($keyword)."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
											  
				  	foreach($ex as $val)
					{
						//echo strlen($val);
						$en34.=" `liquor_title` like ('".mysql_real_escape_string($val)."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en12.substr($en34, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en12, 0 ,-3).')')  ;
		}
		}		
		
		//$this->db->order_by($sort_by,$sort_type);
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
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		 
		if($qry->num_rows()>0)
		{
			 return $qry->result();
		}
		
		
		return 0;
	}
	
	
	function get_one_liquor($id = 0)
	{
		$this->db->select('*');		
		$this->db->from('liquors');
		$this->db->where('liquor_id',$id);

		$qry = $this->db->get();
		if($qry->num_rows()>0)
		{
			 return $qry->row_array();
		}
		return 0;
	}
	function get_liquor_likers($id=0){
		$this->db->select('a.*,u.profile_image');
		$this->db->from('all_likes a');		
		$this->db->join('user_master u','u.user_id=a.user_id');
		$this->db->where('a.liquor_id',$id);
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
	
	function get_all_liquor_likers($id=0){
		$this->db->select('a.*,u.profile_image');
		$this->db->from('all_likes a');		
		$this->db->join('user_master u','u.user_id=a.user_id');
		$this->db->where('a.liquor_id',$id);
		$this->db->where('like_flag',1);
		$this->db->order_by('date_added','asc');
		$this->db->group_by('user_id');
		$qry = $this->db->get();
		if($qry->num_rows() >0){
			return $qry->result();
		}
//		print_r($qry);die;
	}
	
	function get_liquor_comments($id=0,$limit = 0,$offset = 0){
		$this->db->select('b.*,u.profile_image,u.first_name,u.last_name,b.status as status');
		$this->db->from('liquor_comment b');		
		$this->db->join('user_master u','u.user_id=b.user_id','left');
		$this->db->where('b.liquor_id',$id);
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
		
	
		// ///////////////// VIDEO UPLOAD////////////////////////////		
		
		$data_insert["user_id"] = $this->session->userdata("user_id");
		$data_insert["status"] = "active";
		$data_insert["date_added"] = date("Y-m-d H:i:s");
		$data_insert["is_deleted"] = "0";
	
		$this->db->insert("liquor_comment",$data_insert);
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
	
		$this->db->insert("liquor_comment",$data_insert);
		return mysql_insert_id();
	}
	function get_liquor_subcomments($id=0){
		$this->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('liquor_comment b');		
		$this->db->join('user_master u','u.user_id=b.user_id');
		//$CI->db->join('liquor_comment bc','bc.master_comment_id=b.liquor_comment_id');
		$this->db->where('b.master_comment_id!=','0',false);
		$this->db->where('b.liquor_id',$id);
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
	function single_comment_total_likes($liquor_id,$comment_id){
		$this->db->select('*');
		$this->db->from('all_likes');
		$this->db->where('liquor_id',$liquor_id);
		$this->db->where('liquor_comment_id',$comment_id);
		$this->db->where('like_flag',1);
		
		$query = $this->db->get();
		if($query->num_rows() >0){	     
			return $query->num_rows();
		} 
	}
	
	function flag_return($liquor_id,$user_id,$comment_id){
		$this->db->select('like_flag');
		$this->db->from('all_likes');
		$this->db->where('liquor_id',$liquor_id);
		$this->db->where('user_id',$user_id);
		$this->db->where('liquor_comment_id',$comment_id);
		$query = $this->db->get();
		if($query->num_rows() >0){
			return $query->row()->like_flag;
		}
	}
	function sub_comment_remove($liquor_comment_id){
		$data_update = array('is_deleted'=>1);
		$this->db->where('liquor_comment_id',$liquor_comment_id);
		$this->db->update('liquor_comment',$data_update);
	}
	function one_liquor_likers($id=0){
		$this->db->select('*');
		$this->db->from('user_master');		
		$this->db->where('user_id',$id);
		$qry = $this->db->get();
		if($qry->num_rows()>0){
			return $qry->row();
		}
		else{
			return '';
		}
	}

	function get_liquor_comments_count($id=0,$limit = 0,$offset = 0){
		$this->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('liquor_comment b');		
		$this->db->join('user_master u','u.user_id=b.user_id','left');
		$this->db->where('b.liquor_id',$id);
		$this->db->where('b.is_deleted',0);
		$this->db->where('b.status','active');
		$this->db->where('b.master_comment_id',0);
		$this->db->order_by('date_added','desc');
		$qry = $this->db->get();
		
		return $qry->num_rows();
//		print_r($qry);die;
	}
	function auto_suggest_liquor($q){
		$this->db->like('liquor_title',$q,'after');
		$this->db->select('liquor_title,liquor_id');
		$this->db->from('liquors');
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
	
	function getLiquorIdByNext($id,$ord)
	{
		$this->db->select('liquor_slug,liquor_id');
		$this->db->from('liquors');
		$this->db->where('status','active');
		$this->db->where('is_deleted','no');
		if($ord=='asc')
		{
		$this->db->where('liquor_id >',$id);
		}
		if($ord=='desc')
		{
		$this->db->where('liquor_id <',$id);
		}
		
		$this->db->order_by('liquor_id',$ord);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return 0;
	}
}	

?>