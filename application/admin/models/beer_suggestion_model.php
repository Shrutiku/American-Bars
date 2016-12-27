<?php
class beer_suggestion_model extends CI_Model {
	
    function beer_suggestion_model()
    {
        parent::__construct();	
    }   
	
	/*check unique beer_suggestion 
	 * param : beer_suggestionname, paitent_id(if in edit mode)
	 */
	function beer_suggestion_unique($str)
	{
		
		if($this->input->post('beer_id'))
		{
			$query = $this->db->get_where('beer_suggestion_directory',array('beer_id'=>$this->input->post('beer_id')));
			$res = $query->row_array();
			$email = $res['beer_suggestion_name'];
			
			$query = $this->db->query("select beer_suggestion_name from ".$this->db->dbprefix('beer_suggestion_directory')." where beer_suggestion_name = '$str' and beer_id!='".$this->input->post('beer_id')."'");
		}else{
			$query = $this->db->query("select beer_suggestion_name from ".$this->db->dbprefix('beer_suggestion_directory')." where beer_suggestion_name = '$str'");
		}
		if($query->num_rows()>0){
			
			return FALSE;
		}else{
			
			return TRUE;
		}
	}
	
	function beer_suggestion_name($str)
	{
		
		$query = $this->db->query("select beer_suggestion_name from ".$this->db->dbprefix('beer_suggestion_directory')." where md5(beer_suggestion_name) = '".md5($str)."' and is_deleted='no'",FALSE);
			
			
		if($query->num_rows()>0){
			
			return 1;
		}else{
			
			return 0;
		}
	}
	
	/* check unique email
	 * param : email, beer_suggestion id(if in edit mode)
	 */
	function beer_suggestion_email_unique($str)
	{
		if($this->input->post('beer_id'))
		{
			$query = $this->db->get_where('beer_suggestion_directory',array('beer_id'=>$this->input->post('beer_id')));
			$res = $query->row_array();
			$email = $res['email'];
			
			$query = $this->db->query("select email from ".$this->db->dbprefix('beer_suggestion_directory')." where email = '$str' and beer_id!='".$this->input->post('beer_id')."'");
		}else{
			$query = $this->db->query("select email from ".$this->db->dbprefix('beer_suggestion_directory')." where email = '$str'");
		}
		
		
		
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/* add beer_suggestion detail in db
	 * 
	 */	
	function beer_suggestion_insert($data_insert= array())
	{
		  $slug=getbeer_suggestionSlug($data_insert["beer_suggestion_name"]);	
 	     $data_insert['beer_suggestion_slug'] = $slug;
		   unset($data_insert["offset"]);
		   unset($data_insert["limit"]);
		   unset($data_insert["option"]);
		   unset($data_insert["keyword"]);
		   unset($data_insert["search_option"]);
		   unset($data_insert["redirect_page"]);
		   unset($data_insert["search_keyword"]);
		   unset($data_insert["submit"]);
		$image_setting = image_setting();
		$beer_suggestion_image='';
		if($_FILES['file_up']['name']!='')
         {
            $beer_suggestion_image = $this->upload_beer_suggestion_image();  
			$data_insert["beer_suggestion_image"] = $beer_suggestion_image;
		} 
			
	
		
		unset($data_insert["prev_beer_suggestion_image"]);
		unset($data_insert["beer_id"]);
		  if($this->input->post("bars_id")>0 && is_numeric($this->input->post("bars_id")))
		{
			  $data_insert["bar_id"] = $this->input->post("bars_id");
			  
			  unset($data_insert["bars_id"]);
			  
		}
		 unset($data_insert["bars_id"]);
		 $data_insert["date_added"] = date('Y-m-d H:i:s');
		$this->db->insert('beer_suggestion_directory',$data_insert);
		
		$beer_id = mysql_insert_id();
		
		
		
		      //  email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
	
				//echo $str; die; 
	
		
		
		
		
	}


    ///////////// upload image////////////////////////////
    //////////////// upload bar logo//////////////////////////
	function upload_beer_suggestion_image()
	{
		$beer_suggestion_image = '';
		$image_setting = image_setting();
		 if($_FILES['file_up']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['file_up']['name'];
             $_FILES['userfile']['type']     =   $_FILES['file_up']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['file_up']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['file_up']['error'];
             $_FILES['userfile']['size']     =   $_FILES['file_up']['size'];
   
			$config['file_name'] = 'bar_logo'.$rand;
			
            $config['upload_path'] = base_path().'upload/beer_suggestion_orig/';
			
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
				'source_image' => base_path().'upload/beer_suggestion_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/beer_suggestion_thumb/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => $image_setting->beer_suggestion_width,
				'height' => $image_setting->beer_suggestion_height,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$beer_suggestion_image =$picture['file_name'];
			
		
			if($this->input->post('prev_beer_suggestion_image')!='')
				{
					if(file_exists(base_path().'upload/beer_suggestion_thumb/'.$this->input->post('prev_beer_suggestion_image')))
					{
						$link=base_path().'upload/beer_suggestion_thumb/'.$this->input->post('prev_beer_suggestion_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/beer_suggestion_orig/'.$this->input->post('prev_beer_suggestion_image')))
					{
						$link2=base_path().'upload/beer_suggestion_orig/'.$this->input->post('prev_beer_suggestion_image');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('prev_beer_suggestion_image')!='')
				{
					$beer_suggestion_image=$this->input->post('prev_beer_suggestion_image');
				}
			}
			
			return $beer_suggestion_image;
	}
    ////// end of uplaod image////////////////////////////
	
	/* beer_suggestion update 
	 * 
	 */
	function beer_suggestion_update($data_insert = array())
	{
		$image_setting = image_setting();
		
		if($_FILES['file_up']['name']!='')
         {
		        $beer_suggestion_image = $this->upload_beer_suggestion_image();  
				   $data_insert["beer_suggestion_image"] = $beer_suggestion_image;
		 }	
		 $slug=getbeer_suggestionSlug($data_insert["beer_suggestion_name"],$data_insert["beer_id"]);	
 	     $data_insert['beer_suggestion_slug'] = $slug;
		 
		 
		   unset($data_insert["offset"]);
		   unset($data_insert["limit"]);
		   unset($data_insert["option"]);
		   unset($data_insert["keyword"]);
		   unset($data_insert["search_option"]);
		   unset($data_insert["redirect_page"]);
		   unset($data_insert["search_keyword"]);
		   unset($data_insert["submit"]);
		   
		
		   unset($data_insert["prev_beer_suggestion_image"]);
		   unset($data_insert["beer_id"]);
		    if($this->input->post("bars_id")>0 && is_numeric($this->input->post("bars_id")))
		{
			  $data_insert["bar_id"] = $this->input->post("bars_id");
			  unset($data_insert["bars_id"]);
		}
		 
		    unset($data_insert["bars_id"]);
		
		$this->db->where('beer_id',$this->input->post('beer_id'));
		$this->db->update('beer_suggestion_directory',$data_insert);
       // echo $this->db->last_query(); die;
           
		
		
	}
	
	/* get beer_suggestion info
	 * param : beer_suggestion id
	 * 
	 */		
	function get_one_beer_suggestion($id)
	{
		
		$query = $this->db->get_where('beer_directory',array('is_deleted'=>'no','status'=>'pending','beer_id'=>$id));
		return $query->row_array();
	}	
	
	function getbeer_suggestionByBarid($utype,$q){
		$this->db->like('beer_suggestion_name',$q);
		$this->db->select('beer_id,beer_suggestion_name');
		$this->db->from('beer_suggestion_directory');
		$this->db->where('beer_suggestion_directory.is_deleted','no'); 
		$this->db->where('status','active');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
	}
		return 0;
	}
	/* get total beer_suggestions
	 * param :doctor id
	 */
	function get_total_beer_suggestion_count($bar_id = 0)
	{
		//$this->db->where('is_deleted','no');
		
		
		if($bar_id > 0 && is_numeric($bar_id))
		{
			//$query = $this->db->get_where('beer_suggestion_directory',array('is_deleted'=>'no',"bar_id"=>$bar_id));
			$this->db->select('*');
			$this->db->from('beer_bars');
			$this->db->join('beer_directory','beer_directory.beer_id=beer_bars.beer_id');
			$this->db->where('beer_bars.bar_id',$bar_id);
			$this->db->where('beer_directory.status','pending');
			$this->db->where('beer_directory.is_deleted','no');
			$query= $this->db->get();
		}
       else
       {
		$query = $this->db->get_where('beer_directory',array('is_deleted'=>'no','status'=>'pending'));
	   }
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}
		return 0;
	}
	
	
	
	/* get beer_suggestion doctor wise
	 * param : doctor id
	 */
	function get_beer_suggestion_result($offset,$limit,$bar_id = 0)
	{
		
	    if($bar_id > 0 && is_numeric($bar_id))
		{
			$this->db->select('*');
			$this->db->from('beer_bars');
			$this->db->join('beer_directory','beer_directory.beer_id=beer_bars.beer_id');
			$this->db->join("bars b","beer_bars.bar_id = b.bar_id","LEFT");
			$this->db->where('beer_bars.bar_id',$bar_id);
			$this->db->where('beer_directory.is_deleted','no');  
			$this->db->where('beer_directory.status','pending');  
			$this->db->order_by("beer_directory.beer_id","desc");
			$this->db->limit($limit,$offset);
		}
		else {
			$this->db->select("*,e.status");
			$this->db->from("beer_directory e");
			$this->db->join("bars b","e.bar_id = b.bar_id","LEFT");
			$this->db->where('e.is_deleted','no');
			$this->db->where('e.status','pending');
			$this->db->order_by("beer_id","desc");
			$this->db->limit($limit,$offset);
		}
		
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
		
		
	}
	function get_poker_result($offset,$limit)
	{
		
	//	$this->db->where(array('doctor_id'=>$doctor_id));
		$this->db->order_by("beer_id","desc");
		$this->db->where('is_deleted','no');
		//$this->db->where('beer_suggestion_type','poker_expert');
		$this->db->where('beer_suggestion_type','poker_coach');
		$query = $this->db->get('beer_suggestion_directory',$limit,$offset);
		
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	/* search beer_suggestion doctor wise
	 * param:doctor id,option ,keyword
	 */	
	function get_total_search_beer_suggestion_count($option,$keyword,$bar_id = 0)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		 if($bar_id > 0 && is_numeric($bar_id))
		{
			$this->db->select('*');
			$this->db->from('beer_bars');
			$this->db->join('beer_directory','beer_directory.beer_id=beer_bars.beer_id');
			$this->db->where('beer_bars.bar_id',$bar_id);
			$this->db->where('beer_directory.is_deleted','no');  
		}
		else
		{
		$this->db->select('beer_directory.*');
		$this->db->from('beer_directory');
		
		}
		
		if($option=='beer_name')
		{
			$this->db->like('beer_name',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('beer_name',$val);
				// }	
			// }

		}

       if($option=='type')
		{
			$this->db->like('beer_type',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('beer_type',$val);
				// }	
			// }

		}
		
		
		if($option=='producer')
		{
			$this->db->like('producer',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('producer',$val);
				// }	
			// }

		}
		
		
		if($option=='city_produced')
		{
			$this->db->like('city_produced',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('city_produced',$val);
				// }	
			// }

		}
		
	//	$this->db->order_by('beer_id','desc');
		$this->db->where('beer_directory.is_deleted','no');
		$this->db->where('beer_directory.status','pending');
		$query = $this->db->get();
		
		
		return $query->num_rows();
	}
	
	function get_total_search_poker_count($option,$keyword)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('beer_directory.*');
		$this->db->from('beer_directory');
		
		if($option=='beer_name')
		{
			$this->db->like('beer_name',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('beer_name',$val);
				// }	
			// }

		}

       if($option=='type')
		{
			$this->db->like('beer_type',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('beer_type',$val);
				// }	
			// }

		}
		
		
		if($option=='producer')
		{
			$this->db->like('producer',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('producer',$val);
				// }	
			// }

		}
		
		
		if($option=='city_produced')
		{
			$this->db->like('city_produced',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('city_produced',$val);
				// }	
			// }

		}
		
	//	$this->db->order_by('beer_id','desc');
		$this->db->where('is_deleted','no');
		$this->db->where('status','pending');
		//$this->db->where('beer_suggestion_type','poker_expert');
		//$this->db->where('beer_suggestion_type','poker_coach');  
		$query = $this->db->get();
		
		//echo $query = $this->db->last_query(); die;
		return $query->num_rows();
	}
	
	
	/* search beer_suggestion doctor wise
	 * param:doctor id,option ,keyword
	 */		
	function get_search_beer_suggestion_result($option,$keyword,$offset, $limit,$bar_id = 0)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		if($bar_id > 0 && is_numeric($bar_id))
		{
			$this->db->select('*');
			$this->db->from('beer_bars');
			$this->db->join('beer_directory','beer_directory.beer_id=beer_bars.beer_id');
			$this->db->join("bars b","beer_bars.bar_id = b.bar_id","LEFT");
			$this->db->where('beer_bars.bar_id',$bar_id);
			$this->db->where('beer_directory.status','pending');
		}
		else
		{
			$this->db->select('*,beer_directory.status');
			$this->db->from('beer_directory');
			$this->db->join("bars b","beer_directory.bar_id = b.bar_id","LEFT");
		}
		
		if($option=='beer_name')
		{
			$this->db->like('beer_name',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('beer_name',$val);
				// }	
			// }

		}

       if($option=='type')
		{
			$this->db->like('beer_type',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('beer_type',$val);
				// }	
			// }

		}
		
		
		if($option=='producer')
		{
			$this->db->like('producer',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('producer',$val);
				// }	
			// }

		}
		
		
		if($option=='city_produced')
		{
			$this->db->like('city_produced',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('city_produced',$val);
				// }	
			// }

		}
		
		$this->db->where('beer_directory.is_deleted','no');  
		$this->db->where('beer_directory.status','pending');  
		$this->db->order_by('beer_directory.beer_id','desc');
		$this->db->limit($limit,$offset);
		
		$query = $this->db->get();
		
		
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
	
	function get_search_poker_result($option,$keyword,$offset, $limit)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('beer_suggestion_directory.*');
		$this->db->from('beer_suggestion_directory');
		
		if($option=='full_name')
		{
			$this->db->like('first_name',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('first_name',$val);
				}	
			}
			
			$this->db->or_like('last_name',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->or_like('last_name',$val);
				}	
			}
			
		}
		if($option=='email')
		{
			$this->db->like('email',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('email',$val);
				}	
			}

		}
		$this->db->where('is_deleted','no');
		//$this->db->where('beer_suggestion_type','poker_expert'); 
		$this->db->where('beer_suggestion_type','poker_coach');
		$this->db->order_by('beer_id','desc');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		//echo $this->db->last_query() ; die;
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
	
	/* insert beer_suggestion attachment
	 * param :beer_suggestion id, file
	 */	
	
   function get_beer_suggestion_comment_result($id = 0)
   {
   
		$this->db->select("*");
		$this->db->from("beer_suggestion_comment c");
		$this->db->join("user_master u","c.user_id = u.user_id","LEFT");
		$this->db->where("c.master_comment_id","0");
		$this->db->where("c.beer_id",$id);
		
		$qry = $this->db->get();
		if($qry->num_rows()>0)
		{
		   return  $qry->result();
			
		}
		return 0;
   }
   
   function get_beer_suggestion_subcomment_result($id = 0)
   {
   
		$this->db->select("*");
		$this->db->from("beer_suggestion_comment c");
		$this->db->join("user_master u","c.user_id = u.user_id","LEFT");
		$this->db->where("c.master_comment_id",$id);
		
		$qry = $this->db->get();
		if($qry->num_rows()>0)
		{
		   return  $qry->result();
			
		}
		return 0;
   }
   
   
   function reply_insert($data)
   {
   	  $data["date_added"] = date("Y-m-d h:i:s");
	  
	  $this->db->insert("beer_suggestion_comment",$data);
   }
  
   function beer_suggestionnew_insert() {
	
		$to_id_arr = $this->input->post('beer_id');
		
		
	  
		foreach($to_id_arr as $id){
			$data = array(
				'bar_id' => $this->input->post('bars_id'),
		     	'beer_id' =>  $id,
				'date' => date("Y-m-d")
			);
			$this->db->insert('beer_suggestion_bars',$data);
		}
	} 
    
	function get_one_beer_suggestion_by_name($name)
	{
		
		$query = $this->db->get_where('beer_suggestion_directory',array('beer_suggestion_name'=>$name));
		return $query->row_array();
	}	
	
	
	function importcsv()
	{
			if($_FILES['csv']['size']>0 && !empty($_FILES['csv']['name']))
			{			
					if (($handle = fopen($_FILES['csv']['tmp_name'], "r")) !== FALSE) {
					
						$data = fgetcsv($handle,1000,",","'");
						
						
						//echo count($data);die;
						$flag = true;
						if($data[0]!=""){
        						if(count($data)=='7') {
						   do {
						   	if($flag) { $flag = false; continue; }
							$checkbeer_suggestionname = $this->beer_suggestion_name(preg_replace('/[^A-Za-z0-9\- ]/', '', trim($data[0])));
						
						if($checkbeer_suggestionname==0)
						{
						   		
        							
            						$arr=array(
										'beer_suggestion_name'=>preg_replace('/[^A-Za-z0-9\- ]/', '', trim($data[0])),
										'beer_suggestion_type'=>trim($data[1]),
										'producer'=>trim($data[2]),
										'city_produced'=>trim($data[3]),
										'beer_suggestion_desc'=>trim($data[4]),
										'abv'=>trim($data[5]),
										'is_deleted'=>'no',
										'beer_suggestion_website'=>trim($data[6]),
										'status'=>'Active',
										'bar_id'=>0,
										'date_added'=>date('Y-m-d H:i:s'),
										);
										
										  	$this->db->insert('beer_suggestion_directory',$arr);	
										
								}
   							}
							 while ($data = fgetcsv($handle,1000,",","'"));
							 $result="Success";			
							$msg="Import Successfully";	
							$limit=20;
							$offset=0;
							redirect('beer_suggestion/list_beer_suggestion/'.$limit.'/0/'.$offset.'/'.$result);	
				   							}
										else {
								
									$msg = "csv_not_valid";
								redirect('beer_suggestion/import/'.$msg);	
									//die;	
								}
								}
					
   							
					}
			}
		
	}

    function getallbeer_suggestion($bars_id)
	{
		$this->db->select('*');
		$this->db->from('beer_suggestion_directory');
		$this->db->where('status','active');
		$this->db->where('is_deleted','no');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
	}
		return 0;
	}
}
?>