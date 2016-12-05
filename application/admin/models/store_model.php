<?php
class Store_model extends CI_Model {
	
    function Store_model()
    {
        parent::__construct();	
    }   
	
	/*check unique store 
	 * param : storename, paitent_id(if in edit mode)
	 */
	function store_unique($str)
	{
		if($this->input->post('store_id'))
		{
			$query = $this->db->get_where('store',array('store_id'=>$this->input->post('store_id'),'type'=>'store'));
			$res = $query->row_array();
			$email = $res['store_title'];
			
			$query = $this->db->query("select store_title from ".$this->db->dbprefix('store')." where type='store' and store_title = '$str' and store_id!='".$this->input->post('store_id')."'");
		}else{
			$query = $this->db->query("select store_title from ".$this->db->dbprefix('store')." where type='store' and store_title = '$str'");
		}
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/* check unique email
	 * param : email, store id(if in edit mode)
	 */
	function store_email_unique($str)
	{
		if($this->input->post('store_id'))
		{
			$query = $this->db->get_where('store',array('store_id'=>$this->input->post('store_id'),'type'=>'store'));
			$res = $query->row_array();
			$email = $res['email'];
			
			$query = $this->db->query("select email from ".$this->db->dbprefix('store')." where type='store' and email = '$str' and store_id!='".$this->input->post('store_id')."'");
		}else{
			$query = $this->db->query("select email from ".$this->db->dbprefix('store')." where type='store' and email = '$str'");
		}
		
		
		
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/* add store detail in db
	 * 
	 */	
	function store_insert()
	{
		 $this->load->library('upload');
		$profile_image='';
		
	
		$data["product_name"] = $this->input->post('product_name');
		$data["quantity"] = $this->input->post('quantity');
		$data["price"] =$this->input->post('price');
		$data["status"] = $this->input->post('status');
		$data["product_image"] = $profile_image;
		$data["description"] = $this->input->post('description');
		$data["type"] = 'adbstore';
		$data["back_col"] = $this->input->post('back_col');
		$data["status"] = $this->input->post('status');
		$data["color"]=implode(",",$this->input->post('color'));
		$data["size"]=implode(",",$this->input->post('size'));
		$this->db->insert('store',$data);
		$store_id = mysql_insert_id();
		
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
   
			$config['file_name'] = $rand.'product';
			
            $config['upload_path'] = base_path().'upload/product_orig/';
			
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
		   	
			
			
			  resize(base_path().'upload/product_orig/'.$picture['file_name'],base_path().'upload/product_thumb/'.$picture['file_name'],252,350,$this->input->post('back_col'));
			  $this->image_lib->clear();
		      resize(base_path().'upload/product_orig/'.$picture['file_name'],base_path().'upload/product_thumb_big/'.$picture['file_name'],392,274,$this->input->post('back_col'));
              $this->image_lib->clear();
			  resize(base_path().'upload/product_orig/'.$picture['file_name'],base_path().'upload/product_thumb_80/'.$picture['file_name'],80,80,$this->input->post('back_col'));
				 $this->image_lib->clear();
              	  resize(base_path().'upload/product_orig/'.$picture['file_name'],base_path().'upload/product_thumb_254/'.$picture['file_name'],252,350,$this->input->post('back_col'));
				 $this->image_lib->clear();
			
			$company_image=$picture['file_name'];
			$pg=array('product_id'=>$store_id,'product_image_name'=>$company_image);
			$this->db->insert('product_images',$pg);
			
			} 
			}
				
		
		}
	}
	
	/* store update  */
	function store_update()
	{$profile_image ='';
		
		 $this->load->library('upload');
		$data["product_name"] = $this->input->post('product_name');
		$data["quantity"] = $this->input->post('quantity');
		$data["price"] =$this->input->post('price');
		$data["status"] = $this->input->post('status');
		$data["description"] = $this->input->post('description');
		$data["product_image"] = $profile_image;
		$data["status"] = $this->input->post('status');
		$data["back_col"] = $this->input->post('back_col');
		$data["color"]=implode(",",$this->input->post('color'));
		$data["size"]=implode(",",$this->input->post('size'));
		
		
		$this->db->where('store_id',$this->input->post('store_id'));
		$this->db->update('store',$data);
		$product_image = '';
		$preImg = $this->input->post('pre_img');
		$img_id=$this->input->post('image_id');
	
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
   
			$config['file_name'] = $rand.'product';
			
             $config['upload_path'] = base_path().'upload/product_orig/';
			
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
				
			
		      resize(base_path().'upload/product_orig/'.$picture['file_name'],base_path().'upload/product_thumb/'.$picture['file_name'],252,350,$this->input->post('back_col'));
			  $this->image_lib->clear();
		      resize(base_path().'upload/product_orig/'.$picture['file_name'],base_path().'upload/product_thumb_big/'.$picture['file_name'],392,274,$this->input->post('back_col'));
              $this->image_lib->clear();
			  resize(base_path().'upload/product_orig/'.$picture['file_name'],base_path().'upload/product_thumb_80/'.$picture['file_name'],80,80,$this->input->post('back_col'));
			  $this->image_lib->clear();
			   	  resize(base_path().'upload/product_orig/'.$picture['file_name'],base_path().'upload/product_thumb_254/'.$picture['file_name'],252,350,$this->input->post('back_col'));
				 $this->image_lib->clear();
			
			  $product_image=$picture['file_name'];
				
				
				if(isset($preImg[$key]) && $preImg[$key]!='')
						{
							if(file_exists(base_path().'upload/product_orig/'.$preImg[$key]))
							{
								unlink(base_path().'upload/product_orig/'.$preImg[$key]);
							}
							if(file_exists(base_path().'upload/product_thumb/'.$preImg[$key]))
							{
								unlink(base_path().'upload/product_thumb/'.$preImg[$key]);
							}
							
							if(file_exists(base_path().'upload/product_thumb_big/'.$preImg[$key]))
							{
								unlink(base_path().'upload/product_thumb_big/'.$preImg[$key]);
							}
							if(file_exists(base_path().'upload/product_thumb_80/'.$preImg[$key]))
							{
								unlink(base_path().'upload/product_thumb_80/'.$preImg[$key]);
							}
						}
				
				}
				else
				{
				
				$product_image = $preImg[$key];
				}
				if($product_image!=''){
					
						 $pg=array('product_id'=>$this->input->post('store_id'),'product_image_name'=>$product_image);
						if(isset($img_id[$key]) && $img_id[$key]>0){
							$this->db->where('product_image_id',$img_id[$key]);
							$this->db->update('product_images',$pg);
						}else{
							
							$this->db->insert('product_images',$pg);
						}
				}
			
				
			} 
				
		
		}
		
		
		// $prodColor=$this->getProductColor($this->input->post('store_id'));
		// $colarry=array();
		// if(count($color)>0){
		// foreach ($color as $co => $cvalue) {
			// if(!in_array($cvalue, $prodColor)){
			// $colarry[]=array('product_id'=>$this->input->post('store_id'),'color_id'=>$cvalue);
			// }
		// }
		// if(count($colarry)>0)
		// {
			// //print_r($colarry);
			// $this->db->insert_batch('Product_color',$colarry);
		// }
		// }
// 		
		// $size=$this->input->post('size');
		// $prodSize=$this->getProductSize($this->input->post('store_id'));
		// $sizery=array();
		// if(count($size)>0){
		// foreach ($size as $so => $svalue) {
			// if(in_array($svalue, $prodSize)==false){
				// $sizery[]=array('product_id'=>$this->input->post('store_id'),'size_id'=>$svalue);
			// }
		// }
		// if(count($sizery)>0)
		// {
			// //print_r($sizery);
			// $this->db->insert_batch('Product_size',$sizery);
		// }
		// }
				
	}
	
	function getProductSize($prduct_id)
	{
		$query=$this->db->select('size_id')->get_where('Product_size',array('product_id'=>$prduct_id));
		if($query->num_rows()>0)
		{
			$co=array();
			foreach ($query->result() as $c) {
				$co[]=$c->size_id;
			}
			return $co;
		}else{
			return array();
		}
	}
	
	/* get store info * param : store id */	
	
	function getProductColor($prduct_id)
	{
		$query=$this->db->select('color_id')->get_where('Product_color',array('product_id'=>$prduct_id));
		if($query->num_rows()>0)
		{
			$co=array();
			foreach ($query->result() as $c) {
				$co[]=$c->color_id;
			}
			return $co;
		}else{
			return array();
		}
	}
		
	function get_one_store($id)
	{
		$query = $this->db->get_where('store',array('store_id'=>$id));
		return $query->row_array();
	}	
	
	/* get total stores
	 * param :doctor id
	 */
	function get_total_store_count()
	{
		$this->db->select('*');
		$this->db->from('store');
		$this->db->where('is_delete','0'); 
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function get_total_poker_count()
	{
		//$this->db->where('is_deleted','no');
		 	$this->db->where('is_deleted','no');
			$this->db->where('store_type','poker_expert');
			//$this->db->or_where('store_type','poker_coach');
			$query = $this->db->get('store');
			//echo $this->db->last_query(); die;
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}
		return 0;
	}
	
	/* get store doctor wise
	 * param : doctor id
	 */
	function get_store_result($offset,$limit)
	{
	
		
		$this->db->select('a.*'); 
		$this->db->from('store a');
		$this->db->where('a.is_delete','0'); 
		$this->db->where('a.type','store'); 
		$query = $this->db->get();
		return $query->result();
	}
	function get_poker_result($offset,$limit)
	{
		
	//	$this->db->where(array('doctor_id'=>$doctor_id));
		$this->db->order_by("store_id","desc");
		$this->db->where('is_deleted','no');
		//$this->db->where('store_type','poker_expert');
		$this->db->where('store_type','poker_coach');
		$query = $this->db->get('store',$limit,$offset);
		
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	/* search store doctor wise
	 * param:doctor id,option ,keyword
	 */	
	function get_total_search_store_count($option,$keyword)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('s.store_id');
		$this->db->from('store s');
		$this->db->join('bars b',"s.bar_id = b.bar_id");
		$this->db->join('user_master u',"s.user_id = u.user_id");
		$this->db->where('s.type','store'); 
		if($option=='bar_title')
		{
			$this->db->like('bar_title',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('b.bar_title',$val);
				}	
			}

		}
		/*if($option=='name')
		{
			$this->db->like('first_name OR last_name',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('u.first_name OR u.last_name',$val);
				}	
			}

		}
*/

      /* if($option=='type')
		{
			$this->db->like('store_type',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('store_type',$val);
				}	
			}

		}
		
		
		if($option=='producer')
		{
			$this->db->like('producer',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('producer',$val);
				}	
			}

		}
		
		
		if($option=='city_produced')
		{
			$this->db->like('city_produced',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('city_produced',$val);
				}	
			}

		}*/
		
	//	$this->db->order_by('store_id','desc');
		$query = $this->db->get();	
		return $query->num_rows();
	}	
	
	/* search store doctor wise * param:doctor id,option ,keyword  */		
	function get_search_store_result($option,$keyword,$offset, $limit)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('s.*,b.*,u.*');
		$this->db->from('store s');
		$this->db->join('bars b',"s.bar_id = b.bar_id");
		$this->db->join('user_master u',"s.user_id = u.user_id");
		$this->db->where('s.type','store'); 
		if($option=='bar_title')
		{
	//		echo 'xxx';die;
			$this->db->like('bar_title',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('b.bar_title',$val);
				}	
			}

		}

		if($option=='name')
		{
			$this->db->like('first_name OR last_name',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('u.first_name OR u.last_name',$val);
				}	
			}

		}

       /*if($option=='type')
		{
			$this->db->like('store_type',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('store_type',$val);
				}	
			}

		}
		
		
		if($option=='producer')
		{
			$this->db->like('producer',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('producer',$val);
				}	
			}

		}
		
		
		if($option=='city_produced')
		{
			$this->db->like('city_produced',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('city_produced',$val);
				}	
			}

		}*/

		$this->db->order_by('store_id','desc');
		$this->db->limit($limit,$offset);
		
		$query = $this->db->get();
	
		
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
	function getImageGallery($id)
	{
		$query = $this->db->get_where('product_images',array('product_id'=>$id));
		//echo $this->db->last_query();die;
		if($query->num_rows()>0){
		return $query->result();
		}
		return '';
	}	 	  
}
?>