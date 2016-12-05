<?php

class Advertisement_model extends CI_Model {

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
		$this->db->insert('advertisement_master', $form_data);
		
		if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
    function advertisement_insert()
	{
		if($_FILES['advertisement_image']['name']!='')
        {
            $advertisement_image = $this->upload_advertisement_image();  
			$data_insert["advertisement_image"] = $advertisement_image;
		}
		
		if($this->input->post('allow_pages')!='')
		{
		$pages = implode(",",$this->input->post('allow_pages')) ;
		}
		else {
			$pages = '';
		}
		$data_array=array();
		
		$data_insert["advertisement_title"] = $this->input->post('advertisement_title');
		$data_insert["description"] = $this->input->post('advertisement_desc');
		$data_insert["pages"] = $pages;
		$data_insert['status']=$this->input->post('status');
		$data_insert["size"] = $this->input->post('size');
		$data_insert["type"] = $this->input->post('type');
		$data_insert["url"] = $this->input->post('link');
		$data_insert["number_click"] = $this->input->post('number_click');
		$data_insert["number_visit"] = $this->input->post('number_visit');
		$data_insert["position"] = $this->input->post('position');
		
		$this->db->insert('advertisement_master', $data_insert);
	}
	function advertisement_city_insert()
	{
		$pages123 = implode(",",$this->input->post('city_zip')) ;	
		if($_FILES['advertisement_image']['name']!='')
        {
            $advertisement_image = $this->upload_advertisement_image();  
			$data_insert["advertisement_image"] = $advertisement_image;
		}
		
		if($this->input->post('allow_pages')!='')
		{
		$pages = implode(",",$this->input->post('allow_pages')) ;
		}
		else {
			$pages = '';
		}
		$data_array=array();
		
		$data_insert["advertisement_title"] = $this->input->post('advertisement_title');
		$data_insert["description"] = $this->input->post('advertisement_desc');
		$data_insert["pages"] = $pages;
		$data_insert['status']=$this->input->post('status');
		$data_insert["size"] = $this->input->post('size');
		$data_insert["city_zip"] = $pages123;
		$data_insert["s_type"] = $this->input->post('s_type');
		$data_insert["type"] = $this->input->post('type');
		$data_insert["url"] = $this->input->post('link');
		$data_insert["number_click"] = $this->input->post('number_click');
		$data_insert["number_visit"] = $this->input->post('number_visit');
		$data_insert["position"] = $this->input->post('position');
		
		
		$this->db->insert('advertisement_master', $data_insert);
	}
	
	function advertisement_update()
	{	
		
		$pages = implode(",",$this->input->post('allow_pages')) ;	
		$data_update=array();
		
		if($_FILES['advertisement_image']['name']!='')
        {
            $advertisement_image = $this->upload_advertisement_image();  
			$data_update["advertisement_image"] = $advertisement_image;
		}		
		
		$data_update["advertisement_title"] = $this->input->post('advertisement_title');
		$data_update["description"] = $this->input->post('advertisement_desc');
		$data_update["pages"] = $pages;
		$data_update['status']=$this->input->post('status');
		$data_update["size"] = $this->input->post('size');
		$data_update["number_click"] = $this->input->post('number_click');
		$data_update["number_visit"] = $this->input->post('number_visit');
		$data_update["url"] = $this->input->post('link');
		$data_update["type"] = $this->input->post('type');
		$data_update["position"] = $this->input->post('position');
	
	
		$this->db->where("advertisement_id",$this->input->post("advertisement_id"));
		$this->db->update('advertisement_master',$data_update);
		
	}
	
	function advertisement_city_update()
	{
		
		
		
		$pages = implode(",",$this->input->post('allow_pages')) ;	
		$pages123 = implode(",",$this->input->post('city_zip')) ;	
		$data_update=array();
		
		if($_FILES['advertisement_image']['name']!='')
        {
            $advertisement_image = $this->upload_advertisement_image();  
			$data_update["advertisement_image"] = $advertisement_image;
		}		
		
		$data_update["advertisement_title"] = $this->input->post('advertisement_title');
		$data_update["description"] = $this->input->post('advertisement_desc');
		$data_update["pages"] = $pages;
		$data_update['status']=$this->input->post('status');
		$data_update["size"] = $this->input->post('size');
		$data_update["number_click"] = $this->input->post('number_click');
		$data_update["number_visit"] = $this->input->post('number_visit');
		$data_update["url"] = $this->input->post('link');
		$data_update["type"] = $this->input->post('type');
		$data_update["position"] = $this->input->post('position');
		$data_update["city_zip"] = $pages123;
		//$data_update["city_zip"] = substr($pages123, 1);
		$data_update["s_type"] = $this->input->post('s_type');
	
	  
		$this->db->where("advertisement_id",$this->input->post("advertisement_id"));
		$this->db->update('advertisement_master',$data_update);
		
	}
	function upload_advertisement_image()
	{
		$adv_size = explode('x',$_REQUEST['size']);
		$adv_width = $adv_size[0];
		$adv_height = $adv_size[1];
		$advertisement_image = '';
		$image_setting = image_setting();
		 if($_FILES['advertisement_image']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['advertisement_image']['name'];
             $_FILES['userfile']['type']     =   $_FILES['advertisement_image']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['advertisement_image']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['advertisement_image']['error'];
             $_FILES['userfile']['size']     =   $_FILES['advertisement_image']['size'];
   
			$config['file_name'] = 'advertisement_image'.$rand;
			
            $config['upload_path'] = base_path().'upload/advertisement_orig/';
			
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
				
		   if ($_FILES["advertisement_image"]["type"]!= "image/png" and $_FILES["advertisement_image"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["advertisement_image"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["advertisement_image"]["type"] != "image/jpeg" and $_FILES["advertisement_image"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/advertisement_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/advertisement_thumb/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => $adv_width,
				'height' => $adv_height,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
				//echo $error; die;
			}
			//echo $error;
			//die;
			$advertisement_image =$picture['file_name'];
			if($this->input->post('pre_advertisement_image')!='')
				{
					if(file_exists(base_path().'upload/advertisement_orig/'.$this->input->post('pre_advertisement_image')))
					{
						$link=base_path().'upload/advertisement_orig/'.$this->input->post('pre_advertisement_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/advertisement_thumb/'.$this->input->post('pre_advertisement_image')))
					{
						$link2=base_path().'upload/advertisement_thumb/'.$this->input->post('pre_advertisement_image');
						unlink($link2);
					}
				}
			} else {
				if($this->input->post('pre_advertisement_image')!='')
				{				
					$advertisement_image=$this->input->post('pre_advertisement_image');
				}
			}
			return $advertisement_image;
	}
	function get_total_advertisement_count()
	{
	 return $this->db->count_all('advertisement_master');
	}
	
	function get_advertisement_result($offset=0, $limit=0)
	{
	   /*$this->db->order_by("advertisement_id","desc");
	   $query = $this->db->get('advertisement',$limit,$offset);*/
	    $this->db->select('*');
		$this->db->from('advertisement_master');
		//$this->db->join("user_master u","a.user_id = u.user_id","left");
		//$this->db->join("category c","c.category_id = a.advertisement_category_id","left");
		$this->db->order_by("advertisement_id", "desc"); 
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		
       if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	function get_one_advertisement($id=0)
	{
	   $query = $this->db->get_where('advertisement_master',array("advertisement_id"=>$id));
		//return $query->row_array();
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return 0;
	}
	
	function get_total_search_advertisement_count($option,$keyword)
	{
	  $keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
	   
	
		$this->db->select('*');
		$this->db->from('advertisement_master');
		if($option=="advertisement_title")
		{
				   $this->db->like("advertisement_title",$keyword,'after');
				   
				   // if(substr_count($keyword,' ')>=1)
			      // {
				     // $ex=explode(' ',$keyword);
// 				
					// foreach($ex as $val)
					// {
						// $this->db->like('advertisement_title',$val);
					// }	
				// }
				
				
		}
		if($option=="status")
		{
				   $this->db->like("status",$keyword,'after');
				   
				   // if(substr_count($keyword,' ')>=1)
			      // {
				     // $ex=explode(' ',$keyword);
// 				
					// foreach($ex as $val)
					// {
						// $this->db->like('status',$val);
					// }	
				// }
				
				
		}
		$this->db->order_by("advertisement_id", "desc"); 
		
		
		
		$query = $this->db->get();
		
		
		return $query->num_rows();
	}
	
	function get_search_advertisement_result($option,$keyword,$offset, $limit)
	{
	   $keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
	   
		$this->db->select('*');
		$this->db->from('advertisement_master');
			if($option=="advertisement_title")
				{
				   $this->db->like("advertisement_title",$keyword,'after');
				   
				   // if(substr_count($keyword,' ')>=1)
			      // {
				     // $ex=explode(' ',$keyword);
// 				
					// foreach($ex as $val)
					// {
						// $this->db->like('advertisement_title',$val);
					// }	
				// }
				}
				if($option=="status")
				{
					$this->db->where('status',$keyword,'after');
				   /*$this->db->like("status",$keyword);
				   
				   if(substr_count($keyword,' ')>=1)
			      	{
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('status',$val);
					}	
					}*/
				}
				
		$this->db->order_by("advertisement_id", "desc"); 
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	
	}
    
	function getAllCityOrZipcode($search='',$city='')
	{
		if($city=='city')
		{
			$this->db->select("city as value,city as text");
		}
		else if($city=='zipcode'){
			$this->db->select("zipcode as value,zipcode as text");
		}
		else {
			$this->db->select("city as value,city as text");
		}
        //$this->db->distinct();
        $this->db->from("bars");
        $this->db->where("status",'active');
		if($city=='city')
		{
			$this->db->like("city",$search,'after');
		}
		else if($city=='zipcode'){
			$this->db->like("zipcode",$search,'after');
		}
		else {
			$this->db->like("city",$search,'after');
		}
		if($city=='city')
		{
			$this->db->group_by("city");
		}
		else if($city=='zipcode'){
			$this->db->group_by("zipcode");
		}
		else {
			$this->db->group_by("zipcode");
		}
        $this->db->get(); 
        $query1 = $this->db->last_query();
         
		 
		if($city=='city')
		{
			 $this->db->select("city as value, city as text");
		}
		else if($city=='zipcode'){
			$this->db->select("cmpn_zipcode as value,  cmpn_zipcode as text");
		}
		else {
			$this->db->select("city as value, city as text");
		} 
       
        $this->db->distinct();
        $this->db->from("taxi_directory");
        $this->db->where("status",'active');
		if($this->input->post('type')=='city')
		{
			$this->db->like("city",$search,'after');
		}
		else if($city=='zipcode'){
			$this->db->like("cmpn_zipcode",$search,'after');
		}
		else {
			$this->db->like("city",$search,'after');
		}
        if($city=='city')
		{
			 $this->db->group_by("city");
		}
		else if($city=='zipcode'){
			$this->db->group_by("cmpn_zipcode");
		}
		else {
			$this->db->group_by("city");
		} 
        $this->db->get(); 
        $query2 =  $this->db->last_query();
        $query = $this->db->query($query1." UNION ".$query2);
         
		// echo $this->db->last_query();
        return $query->result();
	}	
}
?>
