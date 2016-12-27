<?php
class Myarticle_model extends CI_Model {
	
    function Myarticle_model()
    {
        parent::__construct();
	} 
	function get_total_article_count($id)
	{
		$this->db->select('a.*,c.category_name');
		$this->db->from('article a');
		$this->db->join("category c","c.category_id = a.article_category_id","left");
		$this->db->where('user_id',get_authenticateUserID());
		$query = $this->db->get();
		return $query->num_rows();	
	}
	  
	function get_article_result_by_user($user_id,$offset=0, $limit=0)
	{
		$this->db->select("a.*,c.category_name");
		$this->db->from('article a');
		$this->db->join("category c","c.category_id = a.article_category_id","left");
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
		$this->db->where('category_type',"article");
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
	
	function insert_myarticle()
	{
			//print_r($res); die;
			//echo "hhh"; die;
			$data_array=array();
					  $data_insert["article_title"] = $this->input->post('article_title');
					  $data_insert["article_desc"] = $this->input->post('article_desc');
					  $data_insert["article_price"] = $this->input->post('article_price');
					  $data_insert["membership_paln_id"] = $this->input->post('membership_paln_id');
					  
			
		$image_setting = image_setting();
		$article_image='';
		if($_FILES['article_image']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['article_image']['name'];
             $_FILES['userfile']['type']     =   $_FILES['article_image']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['article_image']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['article_image']['error'];
             $_FILES['userfile']['size']     =   $_FILES['article_image']['size'];
   
			$config['file_name'] = 'article'.$rand;
			
            $config['upload_path'] = base_path().'upload/article_image/';
			
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
				
				
		   if ($_FILES["article_image"]["type"]!= "image/png" and $_FILES["article_image"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["article_image"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["article_image"]["type"] != "image/jpeg" and $_FILES["article_image"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/article/'.$picture['file_name'],
				'new_image' => base_path().'upload/article_image/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => '685',
				'height' => '320',
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$article_image=$picture['file_name'];
			
		
			if($this->input->post('pre_article_image')!='')
				{
					if(file_exists(base_path().'upload/article/'.$this->input->post('pre_article_image')))
					{
						$link=base_path().'upload/article/'.$this->input->post('pre_article_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/article_image/'.$this->input->post('pre_article_image')))
					{
						$link2=base_path().'upload/article_image/'.$this->input->post('pre_article_image');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('pre_article_image')!='')
				{
					$article_image=$this->input->post('pre_article_image');
				}
			}		  
				
				
						
			
			 $data_insert["article_category_id"] = $this->input->post('article_category_id');
		     $data_insert["article_type"] = $this->input->post('article_type');
			 $data_insert['article_status']=$this->input->post('article_status');
			 $data_insert['date_created']=date('Y-m-d H:i:s');
			 $data_insert['ip_address']=$_SERVER['REMOTE_ADDR'];
			 $data_insert['article_image']=$article_image;
			// $data_insert['video_file_name']=$videoname;
			// $data_insert['video_preview']=$video_preview;
			 $data_insert['user_id']=get_authenticateUserID();
			 //print_r($data_insert); die;
			$this->db->insert('article', $data_insert);
	}
	function get_one_article($id=0)
	{
	   $query = $this->db->get_where('article',array("article_id"=>$id));
		//return $query->row_array();
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return 0;
	}
	function update_article()
	{
		$image_setting = image_setting();
		$article_image='';
		if($_FILES['article_image']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['article_image']['name'];
             $_FILES['userfile']['type']     =   $_FILES['article_image']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['article_image']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['article_image']['error'];
             $_FILES['userfile']['size']     =   $_FILES['article_image']['size'];
   
			$config['file_name'] = 'video'.$rand;
			
            $config['upload_path'] = base_path().'upload/article_image/';
			
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
				
				
		   if ($_FILES["article_image"]["type"]!= "image/png" and $_FILES["article_image"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["article_image"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["article_image"]["type"] != "image/jpeg" and $_FILES["article_image"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/article_image/'.$picture['file_name'],
				'new_image' => base_path().'upload/article_image/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => '685',
				'height' => '320',
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$article_image=$picture['file_name'];
			
		
			if($this->input->post('pre_article_image')!='')
				{
					if(file_exists(base_path().'upload/user/'.$this->input->post('pre_article_image')))
					{
						$link=base_path().'upload/article_image/'.$this->input->post('pre_article_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/article_image/'.$this->input->post('pre_article_image')))
					{
						$link2=base_path().'upload/article_image/'.$this->input->post('pre_article_image');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('pre_article_image')!='')
				{
					$article_image=$this->input->post('pre_article_image');
				}
			}
		
	$data_update=array();
					  $data_update["article_title"] = $this->input->post('article_title');
					  $data_update["article_desc"] = $this->input->post('article_desc');
					  $data_update["article_price"] = $this->input->post('article_price');
					  $data_update["article_type"] = $this->input->post('article_type');
					   
		             // $data_update['video_file_name']=$videoname;
			          //$data_update['video_preview']=$video_preview;
					
					  $data_update["article_category_id"] = $this->input->post('article_category_id');
					  $data_update["article_status"] = $this->input->post('article_status');
					 $data_update["membership_paln_id"] = $this->input->post('membership_paln_id');;
					  //$data_update['date_created']=date('Y-m-d H:i:s');
					  $data_update['article_image ']=$article_image;						
		
		//print_r($data_update); die;	
		$this->db->where("article_id",$this->input->post("article_id"));
		$this->db->update('article',$data_update);
		
	}
	function get_search_article_result($limit = 0,$option='',$keyword='',$offset = 0)
	{
		//echo $option;
	   $keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
	   
	   $this->db->select('a.*,c.category_name');
		$this->db->from('article a');
		$this->db->join("category c","c.category_id = a.article_category_id","left");
		$this->db->where('user_id',get_authenticateUserID());
		//$this->db->join("user_master u","m.user_id = u.user_id","left");
			if($option=="article_title")
				{
				   $this->db->like("article_title",$keyword);
				   
				   if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('article_title',$val);
					}	
				}
				}
				if($option=="article_price")
				{
				   $this->db->like("article_price",$keyword);
				   
				   if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('article_price',$val);
					}	
				}
				}
				if($option=="article_type")
				{
				   $this->db->like("article_type",$keyword);
				   
				   if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('article_typee',$val);
					}	
				}
				}
				
		$this->db->order_by("article_id", "desc"); 
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		
		return 0;
	
	}
	function get_total_search_article_count($option,$keyword)
	{
	  
	
		$this->db->select('a.*,c.category_name');
		//$this->db->join("category c","v.video_category_id = c.category_id","left");
		$this->db->from('article a');
		$this->db->join("category c","c.category_id = a.article_category_id","left");
		$this->db->where('user_id',get_authenticateUserID());
		if($option=="article_title")
		{
				   $this->db->like("article_title",$keyword);
				   
				   if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('article_title',$val);
					}	
				}
				
				
		}
		if($option=="article_price")
		{
				   $this->db->like("article_price",$keyword);
				   
				   if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('article_price',$val);
					}	
				}
				
				
		}
		if($option=="article_type")
		{
				   $this->db->like("article_type",$keyword);
				   
				   if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('article_type',$val);
					}	
				}
				
				
		}
		
		$this->db->order_by("article_id", "desc"); 
		
		
		
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		
		return $query->num_rows();
	}
	
	
	
}
?>