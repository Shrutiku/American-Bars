<?php
class Archived_cocktail_model extends CI_Model {
	
    function Archived_cocktail_model()
    {
        parent::__construct();	
    }   
	
	/*check unique cocktail 
	 * param : cocktailname, paitent_id(if in edit mode)
	 */
	function cocktail_unique($str)
	{
		if($this->input->post('cocktail_id'))
		{
			$query = $this->db->get_where('cocktail_directory',array('cocktail_id'=>$this->input->post('cocktail_id')));
			$res = $query->row_array();
			$email = $res['cocktail_name'];
			
			$query = $this->db->query("select cocktail_name from ".$this->db->dbprefix('cocktail_directory')." where cocktail_name = '$str' and cocktail_id!='".$this->input->post('cocktail_id')."'");
		}else{
			$query = $this->db->query("select cocktail_name from ".$this->db->dbprefix('cocktail_directory')." where cocktail_name = '$str'");
		}
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	
	function cocktail_name($str)
	{
		
		$query = $this->db->query("select cocktail_name from ".$this->db->dbprefix('cocktail_directory')." where md5(cocktail_name) = '".md5($str)."' and is_deleted='no'",FALSE);
		
		
		if($query->num_rows()>0){
			return 1;
		}else{
			return 0;
		}
	}
	
	function cocktail_name_n($str='',$ing='',$how='',$base='',$type='',$ser='',$stren='',$diff='',$id='')
	{
		
		if($id=='')
		{
		   $query = $this->db->query("select cocktail_name from ".$this->db->dbprefix('cocktail_directory')." where ingredients='".addslashes(utf8_encode($ing))."' and how_to_make_it='".addslashes(utf8_encode($how))."' and base_spirit='".addslashes(utf8_encode($base))."' and type='".addslashes(utf8_encode($type))."' and served='".addslashes(utf8_encode($ser))."' and strength='".addslashes(utf8_encode($stren))."' and difficulty='".addslashes(utf8_encode($diff))."' and cocktail_name = '".addslashes(utf8_encode($str))."' and is_deleted='no'",FALSE);	
		}
		else {
		   $query = $this->db->query("select cocktail_name from ".$this->db->dbprefix('cocktail_directory')." where ingredients='".addslashes(utf8_encode($ing))."' and how_to_make_it='".addslashes(utf8_encode($how))."' and base_spirit='".addslashes(utf8_encode($base))."' and type='".addslashes(utf8_encode($type))."' and served='".addslashes(utf8_encode($ser))."' and strength='".addslashes(utf8_encode($stren))."' and difficulty='".addslashes(utf8_encode($diff))."' and cocktail_id!='".$id."' and cocktail_name = '".addslashes(utf8_encode($str))."' and is_deleted='no'",FALSE);	
		}
		
		// echo $this->db->last_query();
		// die;
		
		
		if($query->num_rows()>0){
			return 1;
		}else{
			return 0;
		}
	}
	/* add cocktail detail in db
	 * 
	 */	
	function cocktail_insert($data_insert= array())
	{
		  $slug=getCocktailSlug($data_insert["cocktail_name"]);	
 	      $data_insert['cocktail_slug'] = $slug;
		   unset($data_insert["offset"]);
		   unset($data_insert["limit"]);
		   unset($data_insert["option"]);
		   unset($data_insert["keyword"]);
		   unset($data_insert["search_option"]);
		   unset($data_insert["redirect_page"]);
		   unset($data_insert["search_keyword"]);
		   unset($data_insert["submit"]);
		$image_setting = image_setting();
		$cocktail_image='';
		if($_FILES['file_up']['name']!='')
         {
            $cocktail_image = $this->upload_cocktail_image();  
			$data_insert["cocktail_image"] = $cocktail_image;
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
	if($this->input->post("bars_id")>0 && is_numeric($this->input->post("bars_id")))
		{
			  $data_insert["bar_id"] = $this->input->post("bars_id");
			  unset($data_insert["bars_id"]);
		}
		 
		    unset($data_insert["bars_id"]);
		
		unset($data_insert["prev_cocktail_image"]);
		unset($data_insert["prev_cocktail_image1"]);
		
		unset($data_insert["cocktail_id"]);
			 $data_insert["date_added"] = date('Y-m-d H:i:s');
			 $data_insert["upload_type"] = $this->input->post('upload_type');
			 
			 
			 
		
		$this->db->insert('cocktail_directory',$data_insert);
		
		
		$cocktail_id = mysql_insert_id();
		
		
		$inar = array('cat_id'=>$cocktail_id,
		              'category'=>'cocktail',
					  'date'=>date('Y-m-d H:i:s'));
		$this->db->insert('sitemap', $inar);
		      //  email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
	
				//echo $str; die; 
	
		
		
		
		
	}


    ///////////// upload image////////////////////////////
    //////////////// upload bar logo//////////////////////////
	function upload_cocktail_image()
	{
		$cocktail_image = '';
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
   
			$config['file_name'] = 'cocktail'.$rand;
			
            $config['upload_path'] = base_path().'upload/cocktail_orig/';
			
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
			
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_thumb/'.$picture['file_name'],215,247);
			 
			$this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_list/'.$picture['file_name'],120,120);
			
			$this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_thumb_70by70/'.$picture['file_name'],70,70);
			
			$this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_225/'.$picture['file_name'],225,225);
			
			$this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_291/'.$picture['file_name'],291,291);
			$this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_200/'.$picture['file_name'],200,200);
			$this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_240/'.$picture['file_name'],240,240);
			
			$this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_140/'.$picture['file_name'],140,140);
			$this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_312/'.$picture['file_name'],312,312);
			
			
			$cocktail_image =$picture['file_name'];
			
		
			if($this->input->post('prev_cocktail_image')!='')
				{
					if(file_exists(base_path().'upload/cocktail_312/'.$this->input->post('prev_cocktail_image')))
					{
						$link=base_path().'upload/cocktail_312/'.$this->input->post('prev_cocktail_image');
						unlink($link);
					}
					if(file_exists(base_path().'upload/cocktail_200/'.$this->input->post('prev_cocktail_image')))
					{
						$link=base_path().'upload/cocktail_200/'.$this->input->post('prev_cocktail_image');
						unlink($link);
					}
					if(file_exists(base_path().'upload/cocktail_140/'.$this->input->post('prev_cocktail_image')))
					{
						$link=base_path().'upload/cocktail_140/'.$this->input->post('prev_cocktail_image');
						unlink($link);
					}
					if(file_exists(base_path().'upload/cocktail_240/'.$this->input->post('prev_cocktail_image')))
					{
						$link=base_path().'upload/cocktail_240/'.$this->input->post('prev_cocktail_image');
						unlink($link);
					}
					if(file_exists(base_path().'upload/cocktail_291/'.$this->input->post('prev_cocktail_image')))
					{
						$link=base_path().'upload/cocktail_291/'.$this->input->post('prev_cocktail_image');
						unlink($link);
					}
					if(file_exists(base_path().'upload/cocktail_225/'.$this->input->post('prev_cocktail_image')))
					{
						$link=base_path().'upload/cocktail_225/'.$this->input->post('prev_cocktail_image');
						unlink($link);
					}
					if(file_exists(base_path().'upload/cocktail_thumb_70by70/'.$this->input->post('prev_cocktail_image')))
					{
						$link=base_path().'upload/cocktail_thumb_70by70/'.$this->input->post('prev_cocktail_image');
						unlink($link);
					}
					if(file_exists(base_path().'upload/cocktail_thumb/'.$this->input->post('prev_cocktail_image')))
					{
						$link=base_path().'upload/cocktail_thumb/'.$this->input->post('prev_cocktail_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/cocktail_list/'.$this->input->post('prev_cocktail_image')))
					{
						$link2=base_path().'upload/cocktail_list/'.$this->input->post('prev_cocktail_image');
						unlink($link2);
					}
					
					if(file_exists(base_path().'upload/cocktail_orig/'.$this->input->post('prev_cocktail_image')))
					{
						$link2=base_path().'upload/cocktail_orig/'.$this->input->post('prev_cocktail_image');
						unlink($link2);
					}
					
						
					if(file_exists(base_path().'upload/cocktail_thumb_70by70/'.$this->input->post('prev_cocktail_image')))
					{
						$link2=base_path().'upload/cocktail_thumb_70by70/'.$this->input->post('prev_cocktail_image');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('prev_cocktail_image')!='')
				{
					$cocktail_image=$this->input->post('prev_cocktail_image');
				}
			}
			
			return $cocktail_image;
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
   
			$config['file_name'] = 'cocktail'.$rand;
			
            $config['upload_path'] = base_path().'upload/cocktail_orig/';
			
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
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_thumb/'.$picture['file_name'],397,222);
			
			$this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_600by400/'.$picture['file_name'],600,400);
			 
			 $this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_912by480/'.$picture['file_name'],912,480);
			  
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
			
		
			if($this->input->post('prev_cocktail_image1')!='')
				{
					if(file_exists(base_path().'upload/cocktail_912by480/'.$this->input->post('prev_cocktail_image1')))
					{
						$link=base_path().'upload/cocktail_912by480/'.$this->input->post('prev_cocktail_image1');
						unlink($link);
					}
					if(file_exists(base_path().'upload/cocktail_600by400/'.$this->input->post('prev_cocktail_image1')))
					{
						$link=base_path().'upload/cocktail_600by400/'.$this->input->post('prev_cocktail_image1');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/cocktail_thumb/'.$this->input->post('prev_cocktail_image1')))
					{
						$link=base_path().'upload/cocktail_thumb/'.$this->input->post('prev_cocktail_image1');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/cocktail_orig/'.$this->input->post('prev_cocktail_image1')))
					{
						$link2=base_path().'upload/cocktail_orig/'.$this->input->post('prev_cocktail_image1');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('prev_cocktail_image1')!='')
				{
					$cocktail_image1=$this->input->post('prev_cocktail_image1');
				}
			}
			
			return $cocktail_image1;
	}
    ////// end of uplaod image////////////////////////////
	
	/* cocktail update 
	 * 
	 */
	function cocktail_update($data_insert = array())
	{
		$image_setting = image_setting();
		
		if($_FILES['file_up']['name']!='')
         {
		        $cocktail_image = $this->upload_cocktail_image();  
				   $data_insert["cocktail_image"] = $cocktail_image;
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
			
		  $slug=getCocktailSlug_new($data_insert["cocktail_slug"],$data_insert["cocktail_id"]);	
 	     $data_insert['cocktail_slug'] = $slug;
		   // unset($data_insert["bar_id"]);
		   unset($data_insert["offset"]);
		   unset($data_insert["limit"]);
		   unset($data_insert["option"]);
		   unset($data_insert["keyword"]);
		   unset($data_insert["search_option"]);
		   unset($data_insert["redirect_page"]);
		   unset($data_insert["search_keyword"]);
		   unset($data_insert["submit"]);
		   
		
		   unset($data_insert["prev_cocktail_image"]);
		   unset($data_insert["prev_cocktail_image1"]);
		   unset($data_insert["cocktail_id"]);
		   
		if($this->input->post("bars_id")>0 && is_numeric($this->input->post("bars_id")))
		{
			  $data_insert["bar_id"] = $this->input->post("bars_id");
			  unset($data_insert["bars_id"]);
		}
		 
		    unset($data_insert["bars_id"]);
		$this->db->where('cocktail_id',$this->input->post('cocktail_id'));
		$this->db->update('cocktail_directory',$data_insert);
       // echo $this->db->last_query(); die;
           
		
		
	}
	
	/* get cocktail info
	 * param : cocktail id
	 * 
	 */		
	function get_one_cocktail($id)
	{
		$query = $this->db->get_where('cocktail_directory',array('cocktail_id'=>$id));
		return $query->row_array();
	}	
	
	/* get total cocktails
	 * param :doctor id
	 */
	function get_total_cocktail_count($bar_id = 0)
	{
		
		//$this->db->where('is_deleted','no');
		if($bar_id > 0 && is_numeric($bar_id))
		{
			//$query = $this->db->get_where('beer_directory',array('is_deleted'=>'no',"bar_id"=>$bar_id));
			$this->db->select('*');
			$this->db->from('cocktail_bars');
			$this->db->join('cocktail_directory','cocktail_directory.cocktail_id=cocktail_bars.cocktail_id');
			$this->db->where('cocktail_bars.bar_id',$bar_id);
			
			$this->db->where('cocktail_directory.is_deleted','no');
			$this->db->where('cocktail_directory.status','archived');
			$query= $this->db->get();
		}
       else
       {
		$query = $this->db->get_where('cocktail_directory',array('is_deleted'=>'no','status'=>'archived'));
	   }
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}
		return 0;
	}
	/* get cocktail doctor wise
	 * param : doctor id
	 */
	function get_cocktail_result($offset,$limit,$bar_id = 0)
	{
		
		if($bar_id > 0 && is_numeric($bar_id))
		{
			$this->db->select('*');
			$this->db->from('cocktail_bars');
			$this->db->join('cocktail_directory','cocktail_directory.cocktail_id=cocktail_bars.cocktail_id');
			$this->db->join("bars b","cocktail_bars.bar_id = b.bar_id","LEFT");
			$this->db->where('cocktail_bars.bar_id',$bar_id);
			$this->db->where('cocktail_directory.is_deleted','no');
			$this->db->where('cocktail_directory.status','archived');  
			$this->db->order_by("cocktail_directory.cocktail_id","desc");
			$this->db->limit($limit,$offset);
		}
		else {
		$this->db->select("*,e.status");
		$this->db->from("cocktail_directory e");
		$this->db->join("bars b","e.bar_id = b.bar_id","LEFT");
		$this->db->where('e.is_deleted','no');
		$this->db->where('e.status','archived');
		$this->db->order_by("cocktail_id","desc");
		
		$this->db->limit($limit,$offset);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	
	/* search cocktail doctor wise
	 * param:doctor id,option ,keyword
	 */	
	function get_total_search_cocktail_count($option,$keyword,$bar_id = 0)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('cocktail_directory.*');
		$this->db->from('cocktail_directory');
		$this->db->where('cocktail_directory.status','archived');
		if($bar_id > 0 && is_numeric($bar_id))
		{
			$this->db->where("bar_id",$bar_id);
		}
		
		if($option=='cocktail_name')
		{
			$this->db->like('cocktail_name',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('cocktail_name',$val);
				}	
			}

		}

		if($option=='base_spirit')
		{
			$this->db->like('base_spirit',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('base_spirit',$val);
				}	
			}

		}

       
	//	$this->db->order_by('cocktail_id','desc');
		$this->db->where('is_deleted','no');
		$query = $this->db->get();
		
		
		return $query->num_rows();
	}
	
	
	
	/* search cocktail doctor wise
	 * param:doctor id,option ,keyword
	 */		
	function get_search_cocktail_result($option,$keyword,$offset, $limit,$bar_id = 0)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('*,cocktail_directory.status');
		$this->db->from('cocktail_directory');
		$this->db->where('cocktail_directory.status','archived');
		$this->db->join("bars b","cocktail_directory.bar_id = b.bar_id","LEFT");
		if($option=='cocktail_name')
		{
			$this->db->like('cocktail_name',$keyword,'after');
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('cocktail_name',$val);
				}	
			}

		}

      
		if($option=='base_spirit')
		{
			$this->db->like('base_spirit',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('base_spirit',$val);
				}	
			}

		}
		$this->db->where('cocktail_directory.is_deleted','no');  
		$this->db->order_by('cocktail_id','desc');
		$this->db->limit($limit,$offset);
		
		$query = $this->db->get();
		
		
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
	
	
	function get_cocktail_comment_result($id = 0)
   {
   
		$this->db->select("*,c.status as status");
		$this->db->from("cocktail_comment c");
		$this->db->join("user_master u","c.user_id = u.user_id","LEFT");
		$this->db->where("c.master_comment_id","0");
		$this->db->where("c.cocktail_id",$id);
		
		$qry = $this->db->get();
		if($qry->num_rows()>0)
		{
		   return  $qry->result();
			
		}
		return 0;
   }
   
   function get_cocktail_subcomment_result($id = 0)
   {
   
		$this->db->select("*");
		$this->db->from("cocktail_comment c");
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
	  
	  $this->db->insert("cocktail_comment",$data);
   }
   function getCocktailByBarid($utype,$q){
		$this->db->like('cocktail_name',$q);
		$this->db->select('cocktail_id,cocktail_name');
		$this->db->from('cocktail_directory');
			$this->db->where('cocktail_directory.is_deleted','no'); 
		$this->db->where('status','active');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
	}
		return 0;
	}
   
    function cocktail_newinsert() {
	
		$to_id_arr = $this->input->post('cocktail_id');
		
		
	  
		foreach($to_id_arr as $id)
		{	
					
			$data = array(
				'bar_id' => $this->input->post('bars_id'),
		     	'cocktail_id' =>  $id,
				'date' => date("Y-m-d")
			);
			$this->db->insert('cocktail_bars',$data);
		}
	} 
	
	function get_one_cocktail_by_name($name)
	{
		
		$query = $this->db->get_where('cocktail_directory',array('cocktail_name'=>$name));
		return $query->row_array();
	}	
	
	function importcsv_orgi()
	{
			if($_FILES['csv']['size']>0 && !empty($_FILES['csv']['name']))
			{			
					if (($handle = fopen($_FILES['csv']['tmp_name'], "r")) !== FALSE) {
					
						$data = fgetcsv($handle,1000,",","'");
						//echo count($data);die;
						$flag = true;
						if($data[0]!=""){
        						if(count($data)=='8') {
						$arr123 = '';		
						  $i=2;
						   do {
						   	if($flag) { $flag = false; continue; }
								$checkbeername = $this->cocktail_name_n(preg_replace('/[^A-Za-z0-9\- ]/', '', trim($data[0])),trim($data[1]),trim($data[2]),trim($data[3]),trim($data[4]),trim($data[5]),trim($data[6]),trim($data[7]));
						   	 $slug=getCocktailSlug(preg_replace('/[^A-Za-z0-9\- ]/', '', trim($data[0])));	
						if($checkbeername==0)
						{
						   		
            						$arr=array(
										'cocktail_name'=>preg_replace('/[^A-Za-z0-9\- ]/', '', trim($data[0])),
										'ingredients'=>trim($data[1]),
										'how_to_make_it'=>trim($data[2]),
										'base_spirit'=>trim($data[3]),
										'type'=>trim($data[4]),
										'served'=>trim($data[5]),
										'is_deleted'=>'no',
										'cocktail_slug'=>$slug,
										'strength'=>trim($data[6]),
										'difficulty'=>trim($data[7]),
										'status'=>'Active',
										'bar_id'=>0,
										'date_added'=>date('Y-m-d H:i:s'),
										);
										$this->db->insert('cocktail_directory',$arr);
       							 }
							else
							{
								 $arr123 .= $i.'*';
							}	
								
   						$i++;	} while ($data = fgetcsv($handle,1000,",","'"));
							$result="Successfully";			
			$msg="Import Successfully";	
			$limit=20;
			$offset=0;
			redirect('cocktail/list_cocktail/'.$limit.'/0/'.$offset.'/'.$result.'/'.base64_encode($arr123));		
   							}
else {
								
									$msg = "csv_mot_valid";
				redirect('cocktail/import/'.$msg);	
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
			
			if($data->sheets[0]['numCols']==8){
for($i=0;$i<count($data->sheets);$i++) // Loop to get all sheets in a file.
{
	
	
	
	if(isset($data->sheets[$i]['cells']) && count($data->sheets[$i]['cells'])>0) // checking sheet not empty
	{
		for($j=1;$j<=count($data->sheets[$i]['cells']);$j++) // loop used to get each row of the sheet
		{
			//$checkbeername = 0;
			//$checkbeername = $this->beer_name_v((preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@@$data->sheets[$i]['cells'][$j][1]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][2]))),preg_replace('/[^A-Za-z0-9\- ]/', '', trim(@$data->sheets[$i]['cells'][$j][3])),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][4]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][5]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][6]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][7]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][8]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][9]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][10]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][11]))));
			
			$checkbeername = $this->cocktail_name_n(trim(@$data->sheets[$i]['cells'][$j][1]),trim(@$data->sheets[$i]['cells'][$j][2]),trim(@$data->sheets[$i]['cells'][$j][3]),trim(@$data->sheets[$i]['cells'][$j][4]),trim(@$data->sheets[$i]['cells'][$j][5]),trim(@$data->sheets[$i]['cells'][$j][6]),trim(@$data->sheets[$i]['cells'][$j][7]),trim(@$data->sheets[$i]['cells'][$j][8]));
							 $slug=getCocktailSlug(preg_replace('/[^A-Za-z0-9\- ]/', '', trim(@$data->sheets[$i]['cells'][$j][1])));
							 
							 		
						if(isset($data->sheets[$i]['cells'][$j][1]) && $checkbeername==0 && $data->sheets[$i]['cells'][$j][1]!="Cocktail Name")
						
						//if($checkbeername==0)
						{
							
							
			$arr=array(
			                        
										'cocktail_name'=>isset($data->sheets[$i]['cells'][$j][1]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][1])):'' ,
										'ingredients'=>isset($data->sheets[$i]['cells'][$j][2]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][2])):'' ,
										'how_to_make_it'=>isset($data->sheets[$i]['cells'][$j][3]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][3])):'' ,
										'base_spirit'=>isset($data->sheets[$i]['cells'][$j][4]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][4])):'' ,
										'type'=>isset($data->sheets[$i]['cells'][$j][5]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][5])):'' ,
										'served'=>isset($data->sheets[$i]['cells'][$j][6]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][6])):'' ,
										'strength'=>isset($data->sheets[$i]['cells'][$j][7]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][7])):'' ,
										'is_deleted'=>'no',
										'cocktail_slug'=>$slug,
										'difficulty'=> isset($data->sheets[$i]['cells'][$j][8]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][8])):'' ,
										'status'=>'Active',
										'bar_id'=>0,
										'date_added'=>date('Y-m-d H:i:s'),
										);
										
									
			
			$this->db->insert('cocktail_directory',$arr,FALSE);	
			
			
			
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
								redirect('cocktail/list_cocktail/'.$limit.'/0/'.$offset.'/'.$result.'/'.base64_encode(0).'/'.base64_encode($data->sheets[0]['numRows']));
							}
							else {
								redirect('cocktail/list_cocktail/'.$limit.'/0/'.$offset.'/'.$result.'/'.base64_encode($arr123).'/'.base64_encode($data->sheets[0]['numRows']));
							}

	}
  
  } 
}

else {
		//$msg = "xls_not_valid";
		$msg = "xls_not_valid-".$data->sheets[0]['numCols']."";
								redirect('cocktail/import/'.$msg);	
	
}
		
	}
	
	function getallcocktail($bars_id)
	{
		$this->db->select('*');
		$this->db->from('cocktail_directory');
		$this->db->where('status','active');
		$this->db->where('is_deleted','no');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
	}
		return 0;
	}
	
	function getAllCocktailResult($bar_id = 0,$option,$keyword)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('cocktail_directory.cocktail_name,cocktail_directory.ingredients,cocktail_directory.how_to_make_it,cocktail_directory.base_spirit,cocktail_directory.type,cocktail_directory.served,cocktail_directory.strength,cocktail_directory.difficulty');
		$this->db->from('cocktail_directory');
		$this->db->join("bars b","cocktail_directory.bar_id = b.bar_id","LEFT");
		if($option=='cocktail_name')
		{
			$this->db->like('cocktail_name',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('cocktail_name',$val);
				}	
			}

		}

      
		
		$this->db->where('cocktail_directory.is_deleted','no');  
		$this->db->order_by('cocktail_id','desc');
		$query = $this->db->get();
		return $query;
	}
}
?>