<?php
class Blog_model extends CI_Model {
	
    function Blog_model()
    {
        parent::__construct();	
    }   
	
	
	// Use :This function use for Update admin Detail.
	// Param :Post Data
	// Return :'N/A'
	
	function blog_insert()
	{
		if($_FILES['blog_image']['name']!='')
        {
            $blog_image = $this->upload_advertisement_image();  
			$data["blog_image"] = $blog_image;
		}
		$data['blog_title'] = $this->input->post('blog_title');
		$data['status'] = $this->input->post('active');
		$data['blog_description'] = $this->input->post('blog_description');		
		$data['blog_meta_title'] = $this->input->post('blog_meta_title');
		$data['blog_meta_keyword'] = $this->input->post('blog_meta_keyword');
		$data['blog_meta_description'] = $this->input->post('blog_meta_description');
		$data['date_added'] = date('Y-m-d H:i:s');
		$this->db->insert('blog',$data);
		$forum_id = mysql_insert_id();
		$inar = array('cat_id'=>$forum_id,
		              'category'=>'blog',
					  'date'=>date('Y-m-d H:i:s'));
		$this->db->insert('sitemap', $inar);
	}
	
	function upload_advertisement_image()
	{
		
		$blog_image = '';
		$image_setting = image_setting();
		 if($_FILES['blog_image']['name']!='')
         {
         	
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['blog_image']['name'];
             $_FILES['userfile']['type']     =   $_FILES['blog_image']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['blog_image']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['blog_image']['error'];
             $_FILES['userfile']['size']     =   $_FILES['blog_image']['size'];
   
			$config['file_name'] = 'blog_image'.$rand;
			
            $config['upload_path'] = base_path().'upload/blog_orig/';
			
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
				
		   if ($_FILES["blog_image"]["type"]!= "image/png" and $_FILES["blog_image"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["blog_image"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["blog_image"]["type"] != "image/jpeg" and $_FILES["blog_image"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			resize(base_path().'upload/blog_orig/'.$picture['file_name'],base_path().'upload/blog_thumb/'.$picture['file_name'],776,323);
		
		$this->image_lib->clear();
			resize(base_path().'upload/blog_orig/'.$picture['file_name'],base_path().'upload/blog_thumb_50by50/'.$picture['file_name'],75,75);
			
			$this->image_lib->clear();
			resize(base_path().'upload/blog_orig/'.$picture['file_name'],base_path().'upload/blog_thumb_130by130/'.$picture['file_name'],188,210);
			
			$this->image_lib->clear();
			resize(base_path().'upload/blog_orig/'.$picture['file_name'],base_path().'upload/blog300by300/'.$picture['file_name'],300,300);
			
			$this->image_lib->clear();
			resize(base_path().'upload/blog_orig/'.$picture['file_name'],base_path().'upload/blog1920by450/'.$picture['file_name'],1920,450);
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
				//echo $error; die;
			}
			//echo $error;
			//die;
			$blog_image =$picture['file_name'];
			if($this->input->post('pre_blog_image')!='')
				{
					if(file_exists(base_path().'upload/blog_orig/'.$this->input->post('pre_blog_image')))
					{
						$link=base_path().'upload/blog_orig/'.$this->input->post('pre_blog_image');
						unlink($link);
					}
if(file_exists(base_path().'upload/blog_thumb_50by50/'.$this->input->post('pre_blog_image')))
					{
						$link=base_path().'upload/blog_thumb_50by50/'.$this->input->post('pre_blog_image');
						unlink($link);
					}
					if(file_exists(base_path().'upload/blog_thumb_130by130/'.$this->input->post('pre_blog_image')))
					{
						$link=base_path().'upload/blog_thumb_130by130/'.$this->input->post('pre_blog_image');
						unlink($link);
					}
					if(file_exists(base_path().'upload/blog_thumb/'.$this->input->post('pre_blog_image')))
					{
						$link2=base_path().'upload/blog_thumb/'.$this->input->post('pre_blog_image');
						unlink($link2);
					}
				}
			} else {
				if($this->input->post('pre_blog_image')!='')
				{				
					$blog_image=$this->input->post('pre_blog_image');
				}
			}
			return $blog_image;
	}
	function blog_update()
	{
		if($_FILES['blog_image']['name']!='')
        {
            $blog_image = $this->upload_advertisement_image();  
		}
		else {
			$blog_image = $this->input->post('prev_blog_image');
		}
		$active=($this->input->post('active')=='active')?'Active':'inactive';
		$data = array(
			'blog_title'=>$this->input->post('blog_title'),
			'blog_image'=>$blog_image,
		    'blog_description'=>$this->input->post('blog_description'), 
		    'blog_meta_title' => $this->input->post('blog_meta_title'),
		   'blog_meta_keyword' => $this->input->post('blog_meta_keyword'),
		  'blog_meta_description' => $this->input->post('blog_meta_description'),
			'status' => $this->input->post('active'),
		);		
		$this->db->where('blog_id',$this->input->post('blog_id'));
		$this->db->update('blog',$data);
		
		
	}
	

	// Use :This function use for get one admin detail.
	// Param :Admin Id
	// Return :array
	function get_one_blog($id)
	{
		$query = $this->db->get_where('blog',array('blog_id'=>$id));
		return $query->row_array();
	}	
	
	// Use :This function use for count all admin.
	// Param :'N/A'
	// Return :Number
	
	function get_total_admin_count()
	{
		$query = $this->db->get_where('blog',array('master_id'=>'0'));
		return $query->num_rows();
	}
	
	// Use :This function use for get admin detail by limit and offset.
	// Param :offset,limit
	// Return :array of object
	
	function get_blog_result($offset = 0,$limit = 0)
	{
		    
		$this->db->select("*");
		$this->db->from("blog");
		$this->db->order_by("blog_id","DESC");
		$this->db->where(array("master_id"=>'0'));
		$this->db->limit($limit,$offset);
		
		$qry = $this->db->get();
		
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		
		return 0;
		
	}
	function get_blog($id=0) {
		$this->db->select('b.*,u.first_name,u.last_name');
		$this->db->from('blog b');
		$this->db->join("user_master u","b.user_id = u.user_id","left");
		$this->db->where(array('b.blog_id'=>$id));
		//$query = $this->db->get_where('forum',array('forum_id'=>$id));
		$query=$this->db->get();
		//echo $this->db->last_query(); die;
		return $query->row_array();
	
	}
	function get_list($id,$master_id = 0){
		
	
		$this->db->select("*");
		$this->db->from("blog_comment c");
		$this->db->join("user_master u","c.user_id = u.user_id","LEFT");
		$this->db->where("c.master_comment_id","0");
		$this->db->where("c.blog_id",$id);
		
		$qry = $this->db->get();
		
		if($qry->num_rows()>0)
		{
		   return  $qry->result();
			
		}
		return 0;
	}
	function get_blog_count($master_id)
	{
		//echo $master_id; die;	
	 //return $this->db->count_all('blog where master_id ='.$master_id);
	 
	 $qry= $this->db->get_where("blog_comment",array("blog_id"=>$master_id,'is_deleted'=>'no'));
		
		return $qry->num_rows();
		//echo $this->db->last_query(); die;
	}

 function get_blog_subcomment_result($id = 0)
   {
   
		$this->db->select("*");
		$this->db->from("blog_comment c");
		$this->db->join("user_master u","c.user_id = u.user_id","LEFT");
		$this->db->where("c.master_comment_id",$id);
		
		$qry = $this->db->get();
		if($qry->num_rows()>0)
		{
		   return  $qry->result();
			
		}
		return 0;
   }
   
	function reply_insert(){
				
	 $data["date_added"] = date("Y-m-d h:i:s");
	 $data["blog_id"] = $this->input->post('blog_id');
	 $data["comment"] = $this->input->post('description');
	 $data["master_comment_id"] = 0;
	  
	  $this->db->insert("blog_comment",$data);
        
           //Log Entry    
           // $data_log = array("activity_name" => "LOG_REPLY_MESSAGE");
            //maintain_log($data_log); 
		
	}
		
	
		
}
?>