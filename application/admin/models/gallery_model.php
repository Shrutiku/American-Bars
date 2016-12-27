<?php
class Gallery_model extends CI_Model {
	
    function Bar_gallery_model()
    {
        parent::__construct();	
    }   	
	
	/* add gallery detail in db
	 * 
	 */	
	function gallery_insert()
	{
		$this->load->library('upload');
		$data["title"] = $this->input->post('title');
		$data["description"] = $this->input->post('description');	
		//$data["image_link"] = $this->input->post('image_link');		
		$data["status"] = $this->input->post('status');
		$data["bar_id"] = $this->input->post('bar_id');
		$data["date_added"] = date("Y-m-d h:i:s");

		//date($site_setting->date_format,strtotime($rs->product_date));
        
		$this->db->insert('bar_gallery',$data);	
		$gallery_id = mysql_insert_id();
			$datatick['image_title']=$this->input->post('image_title');
			$datatick['image_link']=$this->input->post('image_link');
		if(isset($_FILES['photo_image']['name']) && count($_FILES['photo_image']['name'])>0)
		{ 
		foreach ($_FILES['photo_image']['name'] as $key => $value) {
		if($_FILES['photo_image']['name'][$key] != "")
        {
                 
			$rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['photo_image']['name'][$key];
             $_FILES['userfile']['type']     =   $_FILES['photo_image']['type'][$key];
             $_FILES['userfile']['tmp_name'] =   $_FILES['photo_image']['tmp_name'][$key];
             $_FILES['userfile']['error']    =   $_FILES['photo_image']['error'][$key];
             $_FILES['userfile']['size']     =   $_FILES['photo_image']['size'][$key];
   
			$config['file_name'] = $rand.'bargallery';
			
            $config['upload_path'] = base_path().'upload/bar_gallery_orig/';
			
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
            $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
		
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
			  resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big600by600/'.$picture['file_name'],600,600);
             $this->image_lib->clear();
			  resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big200by200/'.$picture['file_name'],200,200);
			  $this->image_lib->clear();
			  resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big840by720/'.$picture['file_name'],840,720);
			  $this->image_lib->clear();
			  resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big261by261/'.$picture['file_name'],261,261);
             
			$company_image=$picture['file_name'];
			$pg=array('bar_gallery_id'=>$gallery_id,'bar_image_name'=>$company_image,'image_title'=>$datatick['image_title'][$key],'image_link'=>$datatick['image_link'][$key]);
			$this->db->insert('bar_images',$pg);
			
			} 
			}
				
		
		}
	}


  
	
	/* gallery update 
	 * 
	 */
	function gallery_update()
	{
		$this->load->library('upload');
		$data["title"] = $this->input->post('title');
		$data["description"] = $this->input->post('description');		
		$data["status"] = $this->input->post('status');
		$data["bar_id"] = $this->input->post('bar_id');
		$preImg = $this->input->post('pre_img');
		$img_id=$this->input->post('image_id');
		$product_image = '';
		
		
		$this->db->where('bar_gallery_id',$this->input->post('bar_gallery_id'));
		$this->db->update('bar_gallery',$data);
		$datatick['image_title']=$this->input->post('image_title');
		$datatick['image_link']=$this->input->post('image_link');
		// echo "<pre>";
		// print_r($_FILES);
		// print_r($preImg);
		// die;
		
			/***********INsert Gallery************/
		if(isset($_FILES['photo_image']['name']) && count($_FILES['photo_image']['name'])>0)
		{
			foreach ($_FILES['photo_image']['name'] as $key => $value) {
				
				$rand=rand(0,100000); 
			  if($_FILES['photo_image']['name'][$key] != "")
			  {
			  
             $_FILES['userfile']['name']     =   $_FILES['photo_image']['name'][$key];
             $_FILES['userfile']['type']     =   $_FILES['photo_image']['type'][$key];
             $_FILES['userfile']['tmp_name'] =   $_FILES['photo_image']['tmp_name'][$key];
             $_FILES['userfile']['error']    =   $_FILES['photo_image']['error'][$key];
             $_FILES['userfile']['size']     =   $_FILES['photo_image']['size'][$key];
   
			$config['file_name'] = $rand.'business';
			
             $config['upload_path'] = base_path().'upload/bar_gallery_orig/';
			
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				echo $error =  $this->upload->display_errors();die;   
			  } 
			   

			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   
              $this->image_lib->clear();
		   	
			
					$gd_var='gd2';
				
			
		   
            
               resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big/'.$picture['file_name'],394,290);
             
			
			$this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb/'.$picture['file_name'],65,47);
			
			$this->image_lib->clear();
			
			  resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big650by470/'.$picture['file_name'],650,470);
             
               $this->image_lib->clear();
			  resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big600by600/'.$picture['file_name'],600,600);
             $this->image_lib->clear();
			  resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big200by200/'.$picture['file_name'],200,200);
			  $this->image_lib->clear();
			  resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big840by720/'.$picture['file_name'],840,720);
			  $this->image_lib->clear();
			  resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big261by261/'.$picture['file_name'],261,261);
             
		   
			$product_image=$picture['file_name'];
				
				
				if(isset($preImg[$key]) && $preImg[$key]!='')
						{
							if(file_exists(base_path().'upload/bar_gallery_thumb_big600by600/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bar_gallery_thumb_big600by600/'.$preImg[$key]);
							}
							if(file_exists(base_path().'upload/bar_gallery_thumb_big200by200/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bar_gallery_thumb_big200by200/'.$preImg[$key]);
							}
							if(file_exists(base_path().'upload/bar_gallery_thumb_big840by720/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bar_gallery_thumb_big840by720/'.$preImg[$key]);
							}
							if(file_exists(base_path().'upload/bar_gallery_thumb_big261by261/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bar_gallery_thumb_big261by261/'.$preImg[$key]);
							}
							
							
							if(file_exists(base_path().'upload/bar_gallery_orig/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bar_gallery_orig/'.$preImg[$key]);
							}
							if(file_exists(base_path().'upload/bar_gallery_thumb/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bar_gallery_thumb/'.$preImg[$key]);
							}
							
							if(file_exists(base_path().'upload/bar_gallery_thumb_big/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bar_gallery_thumb_big/'.$preImg[$key]);
							}
if(file_exists(base_path().'upload/bar_gallery_thumb_big650by470/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bar_gallery_thumb_big650by470/'.$preImg[$key]);
							}
						}
				
				}
				else
				{
				
				$product_image = $preImg[$key];
				}
				if($product_image!=''){
						 $pg=array('bar_gallery_id'=>$this->input->post('bar_gallery_id'),'bar_image_name'=>$product_image,'image_title'=>$datatick['image_title'][$key],'image_link'=>$datatick['image_link'][$key]);
						if(isset($img_id[$key]) && $img_id[$key]>0){
							$this->db->where('bar_image_id',$img_id[$key]);
							$this->db->update('bar_images',$pg);
						}else{
							$this->db->insert('bar_images',$pg);
						}
				}
				
				// if($product_image!=''){
				// $pg=array('user_id'=>$user_id,'image_name'=>$product_image);
				// if(isset($img_id[$key]) && $img_id[$key]>0){
					// $this->db->where('img_id',$img_id[$key]);
					// $this->db->update('business_images',$pg);
				// }else{
					// $this->db->insert('business_images',$pg);
				// }
				// }
				
			} 
				
		
		}
		/***********INsert Gallery************/
			/***********INsert Gallery************/
		/*
		if(isset($_FILES['photo_image']['name']) && count($_FILES['photo_image']['name'])>0)
				{
					foreach ($_FILES['photo_image']['name'] as $key => $value) {
						
						$rand=rand(0,100000); 
					  if($_FILES['photo_image']['name'][$key] != "")
					  {
											 $_FILES['userfile']['name']     =   $_FILES['photo_image']['name'][$key];
					 $_FILES['userfile']['type']     =   $_FILES['photo_image']['type'][$key];
					 $_FILES['userfile']['tmp_name'] =   $_FILES['photo_image']['tmp_name'][$key];
					 $_FILES['userfile']['error']    =   $_FILES['photo_image']['error'][$key];
					 $_FILES['userfile']['size']     =   $_FILES['photo_image']['size'][$key];
								 $config['file_name'] = $rand.'business';
										  $config['upload_path'] = base_path().'upload/bar_gallery_orig/';
										  $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
								$this->upload->initialize($config);
								 if (!$this->upload->do_upload())
					  {
						echo $error =  $this->upload->display_errors();die;   
					  } 
																					 $picture = $this->upload->data();
										   $this->load->library('image_lib');
										   $this->image_lib->clear();
																		   $gd_var='gd2';
																												 $this->image_lib->initialize(array(
						'image_library' => $gd_var,
						'source_image' => base_path().'upload/bar_gallery_orig/'.$picture['file_name'],
						'new_image' => base_path().'upload/bar_gallery_thumb/'.$picture['file_name'],
						'maintain_ratio' => FALSE,
						'quality' => '100%',
						'width' => 65,
						'height' => 47
					 ));
					
					
					if(!$this->image_lib->resize())
					{
						$error = $this->image_lib->display_errors();
					}
					
					
					
					$this->image_lib->clear();
										   $this->image_lib->initialize(array(
						'image_library' => $gd_var,
						'source_image' => base_path().'upload/bar_gallery_orig/'.$picture['file_name'],
						'new_image' => base_path().'upload/bar_gallery_thumb_big/'.$picture['file_name'],
						'maintain_ratio' => FALSE,
						'quality' => '100%',
						'width' => 394,
						'height' => 290
					 ));
					
					
					if(!$this->image_lib->resize())
					{
						$error = $this->image_lib->display_errors();
					}
					
					$product_image=$picture['file_name'];
						
						
						if(isset($preImg[$key]) && $preImg[$key]!='')
						{
							if(file_exists(base_path().'upload/bar_gallery_orig/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bar_gallery_orig/'.$preImg[$key]);
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
						
						//if($product_image!=''){
						 $pg=array('bar_gallery_id'=>$this->input->post('bar_gallery_id'),'bar_image_name'=>$product_image);
						if(isset($img_id[$key]) && $img_id[$key]>0){
							$this->db->where('bar_image_id',$img_id[$key]);
							$this->db->update('bar_images',$pg);
						}else{
							$this->db->insert('bar_images',$pg);
						}
						//}
						
					} 
						
						}*/
		
		
	}
	
	/* get gallery info
	 * param : gallery id
	 * 
	 */		
	function get_one_gallery($id)
	{
		$query = $this->db->get_where('bar_gallery',array('bar_gallery_id'=>$id));
		return $query->row_array();
	}	
	
	function getOneImageGallery($id)
	{
		$query = $this->db->get_where('bar_images',array('bar_gallery_id'=>$id));
		return $query->row();
	}
	
	function getOneImageGallery_nwe($id)
	{
		$query = $this->db->get_where('bar_images',array('bar_image_id'=>$id));
		return $query->row();
	}
	
	/* get total photo_gallery
	 * param :doctor id
	 */
	function get_total_gallery_count($bar_id)
	{
		$this->db->select('*');
		$this->db->from('bar_gallery');
		$this->db->where('bar_id',$bar_id);
		//$this->db->order_by('bar_id','desc');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function getImageGallery($id)
	{
		$query = $this->db->get_where('bar_images',array('bar_gallery_id'=>$id));
		//echo $this->db->last_query();die;
		if($query->num_rows()>0){
		return $query->result();
		}
		return '';
	}
	
	/* get gallery doctor wise
	 * param : doctor id
	 */
	function get_gallery_result($offset,$limit,$bar_id = 0)
	{
		$this->db->select('*');
		$this->db->from('bar_gallery');
		//$this->db->join('bars','bars.bar_id=bar_gallery.bar_id','left');
		$this->db->where('bar_gallery.bar_id',$bar_id);
		$this->db->order_by('reorder','asc');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return '';
	}
	
	
	/* search gallery doctor wise
	 * param:doctor id,option ,keyword
	 */	
	function get_total_search_gallery_count($option= '',$keyword= '',$bar_id = 0)
	{
		  $en='';
		$en1='';
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('*');
		$this->db->from('bar_gallery');
		//$this->db->join('bars','bars.bar_id=bar_gallery.bar_id','left');
		
		$this->db->where("bar_gallery.bar_id",0);
		
		
		
		if($option=='title')
		{
			$this->db->like('title',$keyword,'after');
			
		}		
		else {
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
		}
			

		$query = $this->db->get();
	
		return $query->num_rows();
	}
	
	
	
	/* search gallery doctor wise
	 * param:doctor id,option ,keyword
	 */		
	function get_search_gallery_result($option='',$keyword='',$offset =0, $limit = 0,$bar_id = 0)
	{
		  $en='';
		$en1='';
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('*');
		$this->db->from('bar_gallery');
		//$this->db->join('bars','bars.bar_id=bar_gallery.bar_id');
		$this->db->where("bar_gallery.bar_id",0);
		
		if($option=='title')
		{
			$this->db->like('title',$keyword,'after');
				}
		else {
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
		}
			
	//	$this->db->order_by('bar_gallery_id','desc');
		$this->db->order_by('reorder','asc');
		$this->db->limit($limit,$offset);		
		$query = $this->db->get();
		
		
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
}
?>