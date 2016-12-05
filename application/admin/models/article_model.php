<?php

class Article_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	// --------------------------------------------------------------------

      /** 
       * function SaveForm()
       *
       * insert form data
       * @param $form_data - array
       * @return Bool - TRUE or FALSE
       */

	function SaveForm($form_data)
	{
		$this->db->insert('article', $form_data);
		
		if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
    function article_insert()
	{
	 
	  $data_array=array();
					  $data_insert["article_title"] = $this->input->post('article_title');
					  $data_insert["article_desc"] = $this->input->post('article_desc');
					  $data_insert["article_price"] = $this->input->post('article_price');
	
	
		$image_setting = image_setting();
		$article_image='';
		if($_FILES['file_up']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['file_up']['name'];
             $_FILES['userfile']['type']     =   $_FILES['file_up']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['file_up']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['file_up']['error'];
             $_FILES['userfile']['size']     =   $_FILES['file_up']['size'];
   
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
				'source_image' => base_path().'upload/article_image/'.$picture['file_name'],
				'new_image' => base_path().'upload/article_image/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => $image_setting->user_width,
				'height' => $image_setting->user_height,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$article_image=$picture['file_name'];
			
		
			if($this->input->post('pre_article_image')!='')
				{
					if(file_exists(base_path().'upload/article_image/'.$this->input->post('pre_article_image')))
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
				
				 $articlename="";
		 if($_FILES["file_up_article"]["name"]!="")
         {
             $this->load->library("upload");
             $rand=rand(0,100000); 
			  
             $_FILES["userfile"]["name"]     =   $_FILES["file_up_article"]["name"];
             $_FILES["userfile"]["type"]     =   $_FILES["file_up_article"]["type"];
             $_FILES["userfile"]["tmp_name"] =   $_FILES["file_up_article"]["tmp_name"];
             $_FILES["userfile"]["error"]    =   $_FILES["file_up_article"]["error"];
             $_FILES["userfile"]["size"]     =   $_FILES["file_up_article"]["size"];
   
		
			
			$config["file_name"] = $this->input->post('file_up_article').$rand;
		 
            $config['upload_path']=base_path()."upload/article";
			
			$config['allowed_types'] = 'pdf|doc|docx|xlsx|word|xl|eml|csv|bin|exe';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();
				//echo $error ; die;   
			  } 
			 
           	    $picture = $this->upload->data();
			    $articlename=$picture["file_name"];
		        $data_insert["article_file_name"] = $articlename;
                }			
			
			 $data_insert["article_category_id"] = $this->input->post('article_category_id');
		     $data_insert["article_type"] = $this->input->post('article_type');
			 $data_insert['article_status']=$this->input->post('status');
			 $data_insert['date_created']=date('Y-m-d H:i:s');
			 $data_insert['ip_address']=$_SERVER['REMOTE_ADDR'];
			 $data_insert['article_image']=$article_image;
			 //print_r($data_insert); die;
			$this->db->insert('article', $data_insert);

	}
	
	function article_update()
	{
		
	$data_update=array();
					  $data_update["article_title"] = $this->input->post('article_title');
					  $data_update["article_desc"] = $this->input->post('article_desc');
					  $data_update["article_price"] = $this->input->post('article_price');
					  $data_update["article_type"] = $this->input->post('article_type');
	
	
	$image_setting = image_setting();
		$article_image='';
		if($_FILES['file_up']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['file_up']['name'];
             $_FILES['userfile']['type']     =   $_FILES['file_up']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['file_up']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['file_up']['error'];
             $_FILES['userfile']['size']     =   $_FILES['file_up']['size'];
   
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
				'source_image' => base_path().'upload/article_image/'.$picture['file_name'],
				'new_image' => base_path().'upload/article_image/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => $image_setting->user_width,
				'height' => $image_setting->user_height,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$article_image=$picture['file_name'];
			
		
			if($this->input->post('pre_article_image')!='')
				{
					if(file_exists(base_path().'upload/article_image/'.$this->input->post('pre_article_image')))
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
				
	$articlename="";		
		 if($_FILES["file_up_article"]["name"]!="")
         {
             $this->load->library("upload");
             $rand=rand(0,100000); 
			  
			  echo'<pre>';
			  print_r($_FILES); 
             $_FILES["userfile"]["name"]     =   $_FILES["file_up_article"]["name"];
             $_FILES["userfile"]["type"]     =   $_FILES["file_up_article"]["type"];
             $_FILES["userfile"]["tmp_name"] =   $_FILES["file_up_article"]["tmp_name"];
             $_FILES["userfile"]["error"]    =   $_FILES["file_up_article"]["error"];
             $_FILES["userfile"]["size"]     =   $_FILES["file_up_article"]["size"];
   
		
			
			$config["file_name"] = $this->input->post('article_name').$rand;
		 
            $config['upload_path']=base_path()."upload/article";
			
            $config['allowed_types'] =  'pdf|doc|docx|xlsx|word|xl|eml|csv|bin|exe';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  	//echo $error ; die;
			  } 
			 
           	    $picture = $this->upload->data();
			    $articlename=$picture["file_name"];
		      //  $data_insert["article"] = $articlename;
			      if($this->input->post("prev_article")!="")
				{
					if(file_exists(base_path()."upload/article/".$this->input->post("prev_article")))
					{
						$link=base_path()."upload/article/".$this->input->post("prev_article");
						unlink($link);
					}
					
				
				} 
                }
		else {
				if($this->input->post("pre_file_up_article"))
				{
					$articlename=$this->input->post("pre_file_up_article");
				}
		   }				
		   
		              $data_update['article_file_name']=$articlename;
			          $data_update["article_category_id"] = $this->input->post('article_category_id');
					  $data_update["article_status"] = $this->input->post('status');
					  $data_update["ip_address"] = $_SERVER['REMOTE_ADDR'];
					  $data_update['date_created']=date('Y-m-d H:i:s');
				      $data_update['article_image']=$article_image;	
	
		$this->db->where("article_id",$this->input->post("article_id"));
		$this->db->update('article',$data_update);
		
	}
	
	function get_total_article_count()
	{
	 return $this->db->count_all('article');
	}
	
	function get_article_result($offset=0, $limit=0)
	{
	   /*$this->db->order_by("article_id","desc");
	   $query = $this->db->get('article',$limit,$offset);*/
	    $this->db->select('a.*,u.first_name,u.last_name,c.category_name');
		$this->db->from('article a');
		$this->db->join("user_master u","a.user_id = u.user_id","left");
		$this->db->join("category c","c.category_id = a.article_category_id","left");
		$query = $this->db->get();
		
       if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
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
	
	function get_category()
	{
	   $query = $this->db->get_where('category',array("status"=>'Active'));
		//return $query->row_array();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	function get_total_search_article_count($option,$keyword)
	{
	  
	
		$this->db->select('a.*,u.first_name,u.last_name,c.category_name');
		$this->db->from('article a');
		$this->db->join("user_master u","a.user_id = u.user_id","left");
		$this->db->join("category c","a.article_category_id = c.category_id","left");
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
		if($option=="username")
		{
				   $this->db->like("u.first_name",$keyword);
				   
				   if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('u.first_name',$val);
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
		
		
		return $query->num_rows();
	}
	
	function get_search_article_result($option,$keyword,$offset, $limit)
	{
	   $keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		$this->db->select('a.*,u.first_name,u.last_name,c.category_name');
		$this->db->from('article a');
		$this->db->join("user_master u","a.user_id = u.user_id","left");
		$this->db->join("category c","a.article_category_id = c.category_id","left");
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
				if($option=="username")
				{
				   $this->db->like("u.first_name",$keyword);
				   
				   if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('u.first_name',$val);
					}	
				}
				}
				
		$this->db->order_by("article_id", "desc"); 
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	
	}
	
	function get_parent_sub_category($catid)
	{
	    $qry=$this->db->get_where('category',array('parent_category_id'=>$catid,'status'=>1));
		
		if($qry->num_rows()>0)
		{
		   return $qry->result();
		}
		
		return 0;
	}
	
}
?>
