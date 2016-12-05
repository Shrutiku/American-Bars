<?php
class Archived_beer_model extends CI_Model {
	
    function Archived_beer_model()
    {
        parent::__construct();	
    }   
	
	/*check unique beer 
	 * param : beername, paitent_id(if in edit mode)
	 */
	function beer_unique($str)
	{
		
		if($this->input->post('beer_id'))
		{
			$query = $this->db->get_where('beer_directory',array('beer_id'=>$this->input->post('beer_id')));
			$res = $query->row_array();
			$email = $res['beer_name'];
			
			$query = $this->db->query("select beer_name from ".$this->db->dbprefix('beer_directory')." where beer_name = '$str' and beer_id!='".$this->input->post('beer_id')."'");
		}else{
			$query = $this->db->query("select beer_name from ".$this->db->dbprefix('beer_directory')." where beer_name = '$str'");
		}
		if($query->num_rows()>0){
			
			return FALSE;
		}else{
			
			return TRUE;
		}
	}
	
	function beer_name($str)
	{
		
		$query = $this->db->query("select beer_name from ".$this->db->dbprefix('beer_directory')." where md5(beer_name) = '".md5($str)."' and is_deleted='no'",FALSE);
			
			
		if($query->num_rows()>0){
			
			return 1;
		}else{
			
			return 0;
		}
	}
	function beer_name_v($str,$type='',$abv='',$brew='',$add='',$city='',$state='',$zip='',$con='',$phone='',$website='',$id='')
	{
		if($id=='')
		{
		    $query123 = $this->db->query("select * from ".$this->db->dbprefix('beer_directory')." where beer_address='".addslashes(utf8_encode($add))."' and beer_country='".addslashes(utf8_encode($con))."' and beer_phone='".$phone."' and beer_zipcode='".$zip."' and beer_type='".addslashes(utf8_encode($type))."' and abv='".addslashes(utf8_encode($abv))."' and producer='".addslashes(utf8_encode($brew))."' and city_produced='".addslashes(utf8_encode($city))."' and beer_state='".addslashes(utf8_encode($state))."' and beer_website='".$website."' and  beer_name = '".addslashes(utf8_encode($str))."' and is_deleted='no'",FALSE);
		}
		else {
			$query123 = $this->db->query("select * from ".$this->db->dbprefix('beer_directory')." where beer_address='".addslashes(utf8_encode($add))."' and beer_country='".addslashes(utf8_encode($con))."' and beer_phone='".$phone."' and beer_zipcode='".$zip."' and beer_type='".addslashes(utf8_encode($type))."' and abv='".addslashes(utf8_encode($abv))."' and producer='".addslashes(utf8_encode($brew))."' and city_produced='".addslashes(utf8_encode($city))."' and beer_state='".addslashes(utf8_encode($state))."' and beer_website='".$website."' and beer_id!='".$id."' and  beer_name = '".addslashes(utf8_encode($str))."' and is_deleted='no'",FALSE);
		} 
		
		
		// print_r($query123->result());
		
       // echo $query->num_rows();
       // die;
		if($query123->num_rows()>0){
			
			return 1;
		}else{
			
			return 0;
		}
	}
	
	/* check unique email
	 * param : email, beer id(if in edit mode)
	 */
	function beer_email_unique($str)
	{
		if($this->input->post('beer_id'))
		{
			$query = $this->db->get_where('beer_directory',array('beer_id'=>$this->input->post('beer_id')));
			$res = $query->row_array();
			$email = $res['email'];
			
			$query = $this->db->query("select email from ".$this->db->dbprefix('beer_directory')." where email = '$str' and beer_id!='".$this->input->post('beer_id')."'");
		}else{
			$query = $this->db->query("select email from ".$this->db->dbprefix('beer_directory')." where email = '$str'");
		}
		
		
		
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/* add beer detail in db
	 * 
	 */	
	function beer_insert($data_insert= array())
	{
		  $slug=getBeerSlug($data_insert["beer_name"]);	
 	     $data_insert['beer_slug'] = $slug;
		   unset($data_insert["offset"]);
		   unset($data_insert["limit"]);
		   unset($data_insert["option"]);
		   unset($data_insert["keyword"]);
		   unset($data_insert["search_option"]);
		   unset($data_insert["redirect_page"]);
		   unset($data_insert["search_keyword"]);
		   unset($data_insert["submit"]);
		$image_setting = image_setting();
		$beer_image='';
		if($_FILES['file_up']['name']!='')
         {
            $beer_image = $this->upload_beer_image();  
			$data_insert["beer_image"] = $beer_image;
		} 
			
	 if($_FILES['file_up1']['name']!='' && $this->input->post('upload_type')=='image')
         {
            $cocktail_image1 = $this->upload_cocktail_image1();  
			$data_insert["image_default"] = $cocktail_image1;
			$data_insert["video_link"] = '';
		} 
			
			if($this->input->post('upload_type')=='video')
			{
				$data_insert["video_link"] = $this->input->post('video_link');
				$data_insert["image_default"] = '';
			}
		
		unset($data_insert["prev_beer_image"]);
		unset($data_insert["prev_beer_image1"]);
		unset($data_insert["beer_id"]);
		  if($this->input->post("bars_id")>0 && is_numeric($this->input->post("bars_id")))
		{
			  $data_insert["bar_id"] = $this->input->post("bars_id");
			  
			  unset($data_insert["bars_id"]);
			  
		}
		 unset($data_insert["bars_id"]);
		 $data_insert["date_added"] = date('Y-m-d H:i:s');
		 
		
		 $data_insert["upload_type"] = $this->input->post('upload_type');
		 
		
		$this->db->insert('beer_directory',$data_insert);
		
		$beer_id = mysql_insert_id();
		
		
		$inar = array('cat_id'=>$beer_id,
		              'category'=>'beer',
					  'date'=>date('Y-m-d H:i:s'));
		$this->db->insert('sitemap', $inar);
		      //  email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
	
				//echo $str; die; 
	
		
		
		
		
	}


function upload_cocktail_image1()
	{
		$cocktail_image1 = '';
		$image_setting = image_setting();
		 if($_FILES['file_up1']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['file_up1']['name'];
             $_FILES['userfile']['type']     =   $_FILES['file_up1']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['file_up1']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['file_up1']['error'];
             $_FILES['userfile']['size']     =   $_FILES['file_up1']['size'];
   
			$config['file_name'] = 'beer'.$rand;
			
            $config['upload_path'] = base_path().'upload/beer_orig/';
			
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
				
				
		   if ($_FILES["file_up1"]["type"]!= "image/png" and $_FILES["file_up1"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["file_up1"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["file_up1"]["type"] != "image/jpeg" and $_FILES["file_up1"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			//resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_thumb/'.$picture['file_name'],397,222);
			
			
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_thumb/'.$picture['file_name'],397,222);
			
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_912by480/'.$picture['file_name'],912,480);
			
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_600by600/'.$picture['file_name'],600,600);
			 
			 $this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_600by400/'.$picture['file_name'],600,400);
			  
			//$this->image_lib->clear();
		//	resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_list/'.$picture['file_name'],120,120);
			
			 // $this->image_lib->initialize(array(
				// 'image_library' => $gd_var,
				// 'source_image' => base_path().'upload/cocktail_orig/'.$picture['file_name'],
				// 'new_image' => base_path().'upload/cocktail_thumb/'.$picture['file_name'],
				// 'maintain_ratio' => TRUE,
				// 'quality' => '100%',
				// 'width' => 397,
				// 'height' => 222,
			 // ));
// 			
// 			
			// if(!$this->image_lib->resize())
			// {
				// $error = $this->image_lib->display_errors();
			// }
// 			
			$cocktail_image1 = $picture['file_name'];
			
		
			if($this->input->post('prev_beer_image1')!='')
				{
					if(file_exists(base_path().'upload/beer_600by600/'.$this->input->post('prev_beer_image1')))
					{
						$link=base_path().'upload/beer_600by600/'.$this->input->post('prev_beer_image1');
						unlink($link);
					}
					if(file_exists(base_path().'upload/beer_600by400/'.$this->input->post('prev_beer_image1')))
					{
						$link=base_path().'upload/beer_600by400/'.$this->input->post('prev_beer_image1');
						unlink($link);
					}
					if(file_exists(base_path().'upload/beer_912by480/'.$this->input->post('prev_beer_image1')))
					{
						$link=base_path().'upload/beer_912by480/'.$this->input->post('prev_beer_image1');
						unlink($link);
					}
					if(file_exists(base_path().'upload/beer_thumb/'.$this->input->post('prev_beer_image1')))
					{
						$link=base_path().'upload/beer_thumb/'.$this->input->post('prev_beer_image1');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/beer_orig/'.$this->input->post('prev_beer_image1')))
					{
						$link2=base_path().'upload/beer_orig/'.$this->input->post('prev_beer_image1');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('prev_beer_image1')!='')
				{
					$cocktail_image1=$this->input->post('prev_beer_image1');
				}
			}
			
			return $cocktail_image1;
	}
    ///////////// upload image////////////////////////////
    //////////////// upload bar logo//////////////////////////
	function upload_beer_image()
	{
		$beer_image = '';
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
   
			$config['file_name'] = 'beer_logo'.$rand;
			
            $config['upload_path'] = base_path().'upload/beer_orig/';
			
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
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_thumb/'.$picture['file_name'],215,247);
			 
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_list/'.$picture['file_name'],120,120);
			
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_thumb_70by70/'.$picture['file_name'],70,70);
			
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_225/'.$picture['file_name'],225,225);
			
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_291/'.$picture['file_name'],291,291);
			
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_200/'.$picture['file_name'],200,200);
			
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_240/'.$picture['file_name'],240,240);
			
				$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_140/'.$picture['file_name'],140,140);
			
				$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_312/'.$picture['file_name'],312,312);
			
			
			$beer_image =$picture['file_name'];
			
		
			if($this->input->post('prev_beer_image')!='')
				{
					if(file_exists(base_path().'upload/beer_312/'.$this->input->post('prev_beer_image')))
					{
						$link=base_path().'upload/beer_312/'.$this->input->post('prev_beer_image');
						unlink($link);
					}
					if(file_exists(base_path().'upload/beer_200/'.$this->input->post('prev_beer_image')))
					{
						$link=base_path().'upload/beer_200/'.$this->input->post('prev_beer_image');
						unlink($link);
					}
					if(file_exists(base_path().'upload/beer_140/'.$this->input->post('prev_beer_image')))
					{
						$link=base_path().'upload/beer_140/'.$this->input->post('prev_beer_image');
						unlink($link);
					}
					if(file_exists(base_path().'upload/beer_240/'.$this->input->post('prev_beer_image')))
					{
						$link=base_path().'upload/beer_240/'.$this->input->post('prev_beer_image');
						unlink($link);
					}
					if(file_exists(base_path().'upload/beer_225/'.$this->input->post('prev_beer_image')))
					{
						$link=base_path().'upload/beer_225/'.$this->input->post('prev_beer_image');
						unlink($link);
					}
					if(file_exists(base_path().'upload/beer_225/'.$this->input->post('prev_beer_image')))
					{
						$link=base_path().'upload/beer_225/'.$this->input->post('prev_beer_image');
						unlink($link);
					}
					if(file_exists(base_path().'upload/beer_291/'.$this->input->post('prev_beer_image')))
					{
						$link=base_path().'upload/beer_291/'.$this->input->post('prev_beer_image');
						unlink($link);
					}
					if(file_exists(base_path().'upload/beer_thumb/'.$this->input->post('prev_beer_image')))
					{
						$link=base_path().'upload/beer_thumb/'.$this->input->post('prev_beer_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/beer_orig/'.$this->input->post('prev_beer_image')))
					{
						$link2=base_path().'upload/beer_orig/'.$this->input->post('prev_beer_image');
						unlink($link2);
					}
					
					if(file_exists(base_path().'upload/beer_thumb_70by70/'.$this->input->post('prev_beer_image')))
					{
						$link2=base_path().'upload/beer_thumb_70by70/'.$this->input->post('prev_beer_image');
						unlink($link2);
					}
					if(file_exists(base_path().'upload/beer_list/'.$this->input->post('prev_beer_image')))
					{
						$link2=base_path().'upload/beer_list/'.$this->input->post('prev_beer_image');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('prev_beer_image')!='')
				{
					$beer_image=$this->input->post('prev_beer_image');
				}
			}
			
			return $beer_image;
	}
    ////// end of uplaod image////////////////////////////
	
	/* beer update 
	 * 
	 */
	function beer_update($data_insert = array())
	{
		
		$image_setting = image_setting();
		// $getdate = getCoordinatesFromAddress($this->input->post("beer_address"),$this->input->post("city_produced"),$this->input->post("beer_state"));
		// print_r($getdate);
		// die;
		
		if($_FILES['file_up']['name']!='')
         {
		        $beer_image = $this->upload_beer_image();  
				   $data_insert["beer_image"] = $beer_image;
		 }	
		 
		  if($_FILES['file_up1']['name']!='' && $this->input->post('upload_type')=='image')
         {
            $cocktail_image1 = $this->upload_cocktail_image1();  
			$data_insert["image_default"] = $cocktail_image1;
			$data_insert["video_link"] = '';
		} 
			
			if($this->input->post('upload_type')=='video')
			{
				$data_insert["video_link"] = $this->input->post('video_link');
				$data_insert["image_default"] = '';
			}
		 $slug=getBeerSlug_new($data_insert["beer_slug"],$data_insert["beer_id"]);	
 	     
 	       $data_insert['beer_slug'] = $slug;
		 
		 
		   unset($data_insert["offset"]);
		   unset($data_insert["limit"]);
		   unset($data_insert["option"]);
		   unset($data_insert["keyword"]);
		   unset($data_insert["search_option"]);
		   unset($data_insert["redirect_page"]);
		   unset($data_insert["search_keyword"]);
		   unset($data_insert["submit"]);
		   
		
		   unset($data_insert["prev_beer_image"]);
		   unset($data_insert["beer_id"]);
		    if($this->input->post("bars_id")>0 && is_numeric($this->input->post("bars_id")))
		{
			  $data_insert["bar_id"] = $this->input->post("bars_id");
			  unset($data_insert["bars_id"]);
		}
		 
		    unset($data_insert["bars_id"]);
		unset($data_insert["prev_beer_image1"]);
		$this->db->where('beer_id',$this->input->post('beer_id'));
		$this->db->update('beer_directory',$data_insert);
       // echo $this->db->last_query(); die;
           
		
		
	}
	
	/* get beer info
	 * param : beer id
	 * 
	 */		
	function get_one_beer($id)
	{
		
		$query = $this->db->get_where('beer_directory',array('beer_id'=>$id));
		return $query->row_array();
	}	
	
	function getBeerByBarid($utype,$q){
		$this->db->like('beer_name',$q);
		$this->db->select('beer_id,beer_name');
		$this->db->from('beer_directory');
		$this->db->where('beer_directory.is_deleted','no'); 
		$this->db->where('status','active');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
	}
		return 0;
	}
	/* get total beers
	 * param :doctor id
	 */
	function get_total_beer_count($bar_id = 0)
	{
		//$this->db->where('is_deleted','no');
		
		
		if($bar_id > 0 && is_numeric($bar_id))
		{
			//$query = $this->db->get_where('beer_directory',array('is_deleted'=>'no',"bar_id"=>$bar_id));
			$this->db->select('*');
			$this->db->from('beer_bars');
			$this->db->join('beer_directory','beer_directory.beer_id=beer_bars.beer_id');
			$this->db->where('beer_bars.bar_id',$bar_id);
			$this->db->where('beer_directory.is_deleted','no');
			$this->db->where('beer_directory.status','archived');
			$query= $this->db->get();
		}
       else
       {
		$query = $this->db->get_where('beer_directory',array('is_deleted'=>'no','beer_directory.status'=>'archived'));
	   }
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}
		return 0;
	}
	
	function get_total_poker_count()
	{
		//$this->db->where('is_deleted','no');
		 	$this->db->where('is_deleted','no');
			$this->db->where('beer_type','poker_expert');
			//$this->db->or_where('beer_type','poker_coach');
			$query = $this->db->get('beer_directory');
			//echo $this->db->last_query(); die;
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}
		return 0;
	}
	
	/* get beer doctor wise
	 * param : doctor id
	 */
	function get_beer_result($offset,$limit,$bar_id = 0)
	{
		
	    if($bar_id > 0 && is_numeric($bar_id))
		{
			$this->db->select('*');
			$this->db->from('beer_bars');
			$this->db->join('beer_directory','beer_directory.beer_id=beer_bars.beer_id');
			$this->db->join("bars b","beer_bars.bar_id = b.bar_id","LEFT");
			$this->db->where('beer_bars.bar_id',$bar_id);
			$this->db->where('beer_directory.status','archived');
			$this->db->where('beer_directory.is_deleted','no');  
			$this->db->order_by("beer_directory.beer_id","desc");
			$this->db->limit($limit,$offset);
		}
		else {
			$this->db->select("*,e.status");
			$this->db->from("beer_directory e");
			$this->db->join("bars b","e.bar_id = b.bar_id","LEFT");
			$this->db->where('e.is_deleted','no');
			$this->db->where('e.status','archived');
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
	
	

	/* search beer doctor wise
	 * param:doctor id,option ,keyword
	 */	
	function get_total_search_beer_count($option,$keyword,$bar_id = 0)
	{
		$keyword=str_replace('-',' ',$keyword);
		//$keyword=str_replace('"','',str_replace(array("%","$","&","*","(",")",":",";",">","<","/"),'',$keyword));
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		 if($bar_id > 0 && is_numeric($bar_id))
		{
			$this->db->select('*');
			$this->db->from('beer_bars');
			$this->db->join('beer_directory','beer_directory.beer_id=beer_bars.beer_id');
			$this->db->where('beer_bars.bar_id',$bar_id);
			$this->db->where('beer_directory.status','archived');
			$this->db->where('beer_directory.is_deleted','no');  
		}
		else
		{
		$this->db->select('beer_directory.*');
		$this->db->from('beer_directory');
		$this->db->where('beer_directory.status','archived');
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
					// $this->db->like('beer_name',$val,'after');
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
					// $this->db->like('beer_type',$val,'after');
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
					// $this->db->like('producer',$val,'after');
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
					// $this->db->like('city_produced',$val,'after');
				// }	
			// }

		}
		
	//	$this->db->order_by('beer_id','desc');
		$this->db->where('beer_directory.is_deleted','no');
		$query = $this->db->get();
		
		
		return $query->num_rows();
	}
	
	/* search beer doctor wise
	 * param:doctor id,option ,keyword
	 */		
	function get_search_beer_result($option,$keyword,$offset, $limit,$bar_id = 0)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		//$keyword=str_replace('"','',str_replace(array("%","$","&","*","(",")",":",";",">","<","/"),'',$keyword));
		if($bar_id > 0 && is_numeric($bar_id))
		{
			$this->db->select('*');
			$this->db->from('beer_bars');
			$this->db->join('beer_directory','beer_directory.beer_id=beer_bars.beer_id');
			$this->db->join("bars b","beer_bars.bar_id = b.bar_id","LEFT");
			$this->db->where('beer_bars.bar_id',$bar_id);
			$this->db->where('beer_directory.status','archived');
		}
		else
		{
			$this->db->select('*,beer_directory.status');
			$this->db->from('beer_directory');
			$this->db->where('beer_directory.status','archived');
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
					// $this->db->like('beer_name',$val,'after');
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
					// $this->db->like('beer_type',$val,'after');
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
					// $this->db->like('producer',$val,'after');
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
					// $this->db->like('city_produced',$val,'after');
				// }	
			// }

		}
		
		$this->db->where('beer_directory.is_deleted','no');  
		$this->db->order_by('beer_directory.beer_id','desc');
		$this->db->limit($limit,$offset);
		
		$query = $this->db->get();
		
		
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
	
	
	/* insert beer attachment
	 * param :beer id, file
	 */	
	
   function get_beer_comment_result($id = 0)
   {
   
		$this->db->select("*,c.status as status");
		$this->db->from("beer_comment c");
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
   
   function get_beer_subcomment_result($id = 0)
   {
   
		$this->db->select("*,c.status as status");
		$this->db->from("beer_comment c");
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
	  
	  $this->db->insert("beer_comment",$data);
   }
  
   function beernew_insert() {
	
		$to_id_arr = $this->input->post('beer_id');
		
		
	  
		foreach($to_id_arr as $id){
			$data = array(
				'bar_id' => $this->input->post('bars_id'),
		     	'beer_id' =>  $id,
				'date' => date("Y-m-d")
			);
			$this->db->insert('beer_bars',$data);
		}
	} 
    
	function get_one_beer_by_name($name)
	{
		
		$query = $this->db->get_where('beer_directory',array('beer_name'=>$name));
		return $query->row_array();
	}	
	
	
	function importcsv_orig()
	{
			if($_FILES['csv']['size']>0 && !empty($_FILES['csv']['name']))
			{
				$file = fopen($_FILES['csv']['tmp_name'],"r");
					if (($handle = fopen($_FILES['csv']['tmp_name'], "r")) !== FALSE) {
						
					  
						$data = fgetcsv($handle,1000,',','"');
						
						print_r($data);
						die;
						$flag = true;
						if($data[0]!=""){
							
        						if(count($data)=='11') {
						 	$arr123 = '';		
						  $i=2;   do {
						  	
						   	if($flag) { $flag = false; continue; }
							
							$checkbeername = $this->beer_name_v((preg_replace('/[^A-Za-z0-9\- ]/', '' , trim($data[0]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim($data[1]))),preg_replace('/[^A-Za-z0-9\- ]/', '', trim($data[2])),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim($data[3]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim($data[4]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim($data[5]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim($data[6]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim($data[7]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim($data[8]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim($data[9]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim($data[10]))));
							
							
							 $slug=getBeerSlug(preg_replace('/[^A-Za-z0-9\- ]/', '', trim($data[0])));	
						if($checkbeername==0)
						{
						   		
        							
            						$arr=array(
										'beer_name'=>trim($data[0]),
										'beer_type'=>trim($data[1]),
										'abv'=>preg_replace('/[^A-Za-z0-9\- ]/', '', trim($data[2])),
										'producer'=>trim($data[3]),
										'beer_address'=>trim($data[4]),
										'city_produced'=>trim($data[5]),
										'beer_state'=>trim($data[6]),
										'is_deleted'=>'no',
										'beer_slug'=>$slug,
										'beer_zipcode'=>trim($data[7]),
										'beer_country'=>trim($data[8]),
										'beer_phone'=>trim($data[9]),
										'beer_website'=>trim($data[10]),
										'status'=>'Active',
										'bar_id'=>0,
										'date_added'=>date('Y-m-d H:i:s'),
										);
										
										
										  	$this->db->insert('beer_directory',$arr);	
										
								}
						else
							{
								 $arr123 .= $i.'*';
							}
   							$i++;}
							 while ($data = fgetcsv($handle,1000,",","'"));
							$result="Successfully";	
							$msg="Import Successfully";	
							$limit=20;
							$offset=0;
							redirect('beer/list_beer/'.$limit.'/0/'.$offset.'/'.$result.'/'.base64_encode($arr123));
				   							}
										else {
								
									$msg = "csv_not_valid";
								redirect('beer/import/'.$msg);	
									//die;	
								}
								}
					
   							
					}
			}
		
	}

  function importcsv()
	{
			 $this->db->_protect_identifiers=false;
		         ini_set('memory_limit', '2048M');
	        ini_set("display_errors",1);
			//require_once APPPATH.'excel_reader2.php';
			require_once(base_path()."/application/excel_reader2.php");
			$flag = true;
			$data = new Spreadsheet_Excel_Reader($_FILES['csv']['tmp_name']);
				$arr123 = 0;
			
			if($data->sheets[0]['numCols']==11){
for($i=0;$i<count($data->sheets);$i++) // Loop to get all sheets in a file.
{
	
	
	
	if(isset($data->sheets[$i]['cells']) && count($data->sheets[$i]['cells'])>0) // checking sheet not empty
	{
		for($j=1;$j<=count($data->sheets[$i]['cells']);$j++) // loop used to get each row of the sheet
		{
			//$checkbeername = 0;
			//$checkbeername = $this->beer_name_v((preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@@$data->sheets[$i]['cells'][$j][1]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][2]))),preg_replace('/[^A-Za-z0-9\- ]/', '', trim(@$data->sheets[$i]['cells'][$j][3])),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][4]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][5]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][6]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][7]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][8]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][9]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][10]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][11]))));
			
			$checkbeername = $this->beer_name_v(trim(@$data->sheets[$i]['cells'][$j][1]),trim(@$data->sheets[$i]['cells'][$j][2]),trim(@$data->sheets[$i]['cells'][$j][3]),trim(@$data->sheets[$i]['cells'][$j][4]),trim(@$data->sheets[$i]['cells'][$j][5]),trim(@$data->sheets[$i]['cells'][$j][6]),trim(@$data->sheets[$i]['cells'][$j][7]),trim(@$data->sheets[$i]['cells'][$j][8]),trim(@$data->sheets[$i]['cells'][$j][9]),trim(@$data->sheets[$i]['cells'][$j][10]),trim(@$data->sheets[$i]['cells'][$j][11]));
							 $slug=getBeerSlug(preg_replace('/[^A-Za-z0-9\- ]/', '', trim(@$data->sheets[$i]['cells'][$j][1])));
							 
							 		
						if(isset($data->sheets[$i]['cells'][$j][1]) && $checkbeername==0 && $data->sheets[$i]['cells'][$j][1]!="Beer Name")
						
						//if($checkbeername==0)
						{
							
							
			$arr=array(
			                        
										'beer_name'=>isset($data->sheets[$i]['cells'][$j][1]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][1])):'' ,
										'beer_type'=>isset($data->sheets[$i]['cells'][$j][2]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][2])):'' ,
										'abv'=>isset($data->sheets[$i]['cells'][$j][3]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][3])):'' ,
										'producer'=>isset($data->sheets[$i]['cells'][$j][4]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][4])):'' ,
										'beer_address'=>isset($data->sheets[$i]['cells'][$j][5]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][5])):'' ,
										'city_produced'=>isset($data->sheets[$i]['cells'][$j][6]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][6])):'' ,
										'beer_state'=>isset($data->sheets[$i]['cells'][$j][7]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][7])):'' ,
										'is_deleted'=>'no',
										'beer_slug'=>$slug,
										'beer_zipcode'=> isset($data->sheets[$i]['cells'][$j][8]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][8])):'' ,
										'beer_country'=>isset($data->sheets[$i]['cells'][$j][9]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][9])):'' ,
										'beer_phone'=>isset($data->sheets[$i]['cells'][$j][10]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][10])):'' ,
										'beer_website'=>isset($data->sheets[$i]['cells'][$j][11]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][11])):'' ,
										'status'=>'Active',
										'bar_id'=>0,
										'date_added'=>date('Y-m-d H:i:s'),
										);
										
									
			
			$this->db->insert('beer_directory',$arr,FALSE);	
			
			
			
			}
			else if(isset($data->sheets[$i]['cells'][$j][1]))
			//else
							{
								
								 $arr123 .= $j.'*';
							}

		}

              

								$result="Successfully";	
							$msg="Import Successfully";	
							$limit=20;
							$offset=0;
							
							if($arr123==0)
							{
								redirect('beer/list_beer/'.$limit.'/0/'.$offset.'/'.$result.'/'.base64_encode(0).'/'.base64_encode($data->sheets[0]['numRows']));
							}
							else {
								redirect('beer/list_beer/'.$limit.'/0/'.$offset.'/'.$result.'/'.base64_encode($arr123).'/'.base64_encode($data->sheets[0]['numRows']));
							}

	}
  
  } 
}

else {
		//$msg = "xls_not_valid";
		$msg = "xls_not_valid-".$data->sheets[0]['numCols']."";
								redirect('beer/import/'.$msg);	
	
}
		
	}

    function getallbeer($bars_id='')
	{
		$this->db->select('*');
		$this->db->from('beer_directory');
		$this->db->where('status','active');
		$this->db->where('is_deleted','no');
		//$this->db->limit(10000,10000);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
	}
		return 0;
	}
	
	function getallbeer_100($bars_id='')
	{
		$this->db->select('*');
		$this->db->from('beer_directory');
		$this->db->where('status','active');
		$this->db->where('is_deleted','no');
		//$this->db->where('beer_id',16049);
		$this->db->limit(5000,60000);
		$query = $this->db->get();
		
		
		if ($query->num_rows() > 0) {
			return $query->result();
	}
		return 0;
	}
	
	function getAllBeerResult($bar_id = 0,$option,$keyword)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		if($bar_id > 0 && is_numeric($bar_id))
		{
			$this->db->select('beer_name as `Beer Name`, beer_type as  `Beer Type`, abv as `ABV`, producer as `Brewed By`, city_produced as `City`, beer_state as `State`, beer_website as `Website`');
			$this->db->from('beer_bars');
			$this->db->join('beer_directory','beer_directory.beer_id=beer_bars.beer_id');
			$this->db->join("bars b","beer_bars.bar_id = b.bar_id","LEFT");
			$this->db->where('beer_bars.bar_id',$bar_id);
		}
		else
		{
			$this->db->select('beer_name as `Beer Name`, beer_type as  `Beer Type`, abv as `ABV`, producer as `Brewed By`, city_produced as `City`, beer_state as `State`, beer_website as `Website`');
			$this->db->from('beer_directory');
			$this->db->join("bars b","beer_directory.bar_id = b.bar_id","LEFT");
		}
		
		if($option=='beer_name')
		{
			$this->db->like('beer_name',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('beer_name',$val);
				}	
			}

		}

       if($option=='type')
		{
			$this->db->like('beer_type',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('beer_type',$val);
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

		}
		
		$this->db->where('beer_directory.is_deleted','no');  
		$this->db->order_by('beer_directory.beer_id','desc');
		
		$query = $this->db->get();
		
		
		
			
			return $query;
	}
	
	
}
?>