<?php
class Archived_liquor_model extends CI_Model {
	
    function Archived_liquor_model()
    {
        parent::__construct();	
    }   
	
	/*check unique liquor 
	 * param : liquorname, paitent_id(if in edit mode)
	 */
	function liquor_unique($str)
	{
		if($this->input->post('liquor_id'))
		{
			$query = $this->db->get_where('liquors',array('liquor_id'=>$this->input->post('liquor_id')));
			$res = $query->row_array();
			$email = $res['liquor_title'];
			
			$query = $this->db->query("select liquor_title from ".$this->db->dbprefix('liquors')." where liquor_title = '$str' and liquor_id!='".$this->input->post('liquor_id')."'");
		}else{
			$query = $this->db->query("select liquor_title from ".$this->db->dbprefix('liquors')." where liquor_title = '$str'");
		}
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	
	/* add liquor detail in db
	 * 
	 */	
	function liquor_insert($data_insert= array())
	{
		 $slug=getLiquorSlug($data_insert["liquor_title"]);
		  $data_insert['liquor_slug'] = $slug;	
		  $this->load->library('upload');
		  // unset($data_insert["bar_id"]);
		   unset($data_insert["offset"]);
		   unset($data_insert["limit"]);
		   unset($data_insert["option"]);
		   unset($data_insert["keyword"]);
		   unset($data_insert["search_option"]);
		   unset($data_insert["redirect_page"]);
		   unset($data_insert["search_keyword"]);
		   unset($data_insert["submit"]);
		   unset($data_insert["image_count"]);
		   unset($data_insert["cntpro"]);
		   unset($data_insert["prev_photo_image"]);
		
			
		 $cocktail_image='';
		if($_FILES['bar_logo_file']['name']!='')
         {
            $cocktail_image = $this->upload_cocktail_image();  
			$data_insert["liquor_image"] = $cocktail_image;
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
	
		
		unset($data_insert["prev_bar_logo"]);
		unset($data_insert["liquor_id"]);
		unset($data_insert["prev_liquor_image1"]);
		
		  if($this->input->post("bars_id")>0 && is_numeric($this->input->post("bars_id")))
		{
			  $data_insert["bar_id"] = $this->input->post("bars_id");
			  unset($data_insert["bars_id"]);
			  
		}
		 unset($data_insert["bars_id"]);
		  $data_insert["date_added"] = date('Y-m-d H:i:s');
		 $data_insert["upload_type"] = $this->input->post('upload_type');
		 
		
		$this->db->insert('liquors',$data_insert);
		
		$liquor_id = mysql_insert_id();
		
		
		$inar = array('cat_id'=>$liquor_id,
		              'category'=>'liquor',
					  'date'=>date('Y-m-d H:i:s'));
		$this->db->insert('sitemap', $inar);
		
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
   
			$config['file_name'] = 'liquor'.$rand;
			
            $config['upload_path'] = base_path().'upload/liquor_orig/';
			
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
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_thumb/'.$picture['file_name'],397,222);
			 
			 $this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_600by400/'.$picture['file_name'],600,400);
			 
			 $this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_912by480/'.$picture['file_name'],912,480);
			 
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
			
		
			if($this->input->post('prev_liquor_image1')!='')
				{
					if(file_exists(base_path().'upload/liquor_912by480/'.$this->input->post('prev_liquor_image1')))
					{
						$link=base_path().'upload/liquor_912by480/'.$this->input->post('prev_liquor_image1');
						unlink($link);
					}
					if(file_exists(base_path().'upload/liquor_600by400/'.$this->input->post('prev_liquor_image1')))
					{
						$link=base_path().'upload/liquor_600by400/'.$this->input->post('prev_liquor_image1');
						unlink($link);
					}
					if(file_exists(base_path().'upload/liquor_thumb/'.$this->input->post('prev_liquor_image1')))
					{
						$link=base_path().'upload/liquor_thumb/'.$this->input->post('prev_liquor_image1');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/liquor_orig/'.$this->input->post('prev_liquor_image1')))
					{
						$link2=base_path().'upload/liquor_orig/'.$this->input->post('prev_liquor_image1');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('prev_liquor_image1')!='')
				{
					$cocktail_image1=$this->input->post('prev_liquor_image1');
				}
			}
			
			return $cocktail_image1;
	}

function upload_cocktail_image()
	{
		$cocktail_image = '';
		$image_setting = image_setting();
		 if($_FILES['bar_logo_file']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['bar_logo_file']['name'];
             $_FILES['userfile']['type']     =   $_FILES['bar_logo_file']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['bar_logo_file']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['bar_logo_file']['error'];
             $_FILES['userfile']['size']     =   $_FILES['bar_logo_file']['size'];
   
			$config['file_name'] = 'liquor'.$rand;
			
            $config['upload_path'] = base_path().'upload/liquor_orig/';
			
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
				
				
		   if ($_FILES["bar_logo_file"]["type"]!= "image/png" and $_FILES["bar_logo_file"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["bar_logo_file"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["bar_logo_file"]["type"] != "image/jpeg" and $_FILES["bar_logo_file"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			//$this->image_lib->clear();
			
			
			
			//resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_thumb/'.$picture['file_name'],395,222);
			
			
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_thumb/'.$picture['file_name'],215,247);
			 
			$this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_list/'.$picture['file_name'],120,120);
			
			
			 
			$this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_thumb_70by70/'.$picture['file_name'],70,70);
			
			$this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_225/'.$picture['file_name'],225,225);
			
			$this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_291/'.$picture['file_name'],291,291);
			$this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_240/'.$picture['file_name'],240,240);
			$this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_200/'.$picture['file_name'],200,200);
			
			$this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_140/'.$picture['file_name'],140,140);
			$this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_312/'.$picture['file_name'],312,312);
			
			 // $this->image_lib->initialize(array(
				// 'image_library' => $gd_var,
				// 'source_image' => base_path().'upload/cocktail_orig/'.$picture['file_name'],
				// 'new_image' => base_path().'upload/cocktail_thumb/'.$picture['file_name'],
				// 'maintain_ratio' => FALSE,
				// 'quality' => '100%',
				// 'width' => $image_setting->cocktail_width,
				// 'height' => $image_setting->cocktail_height,
			 // ));
// 			
// 			
			// if(!$this->image_lib->resize())
			// {
				// $error = $this->image_lib->display_errors();
			// }
			
			$cocktail_image =$picture['file_name'];
			
		
			if($this->input->post('prev_bar_logo')!='')
				{
					if(file_exists(base_path().'upload/liquor_312/'.$this->input->post('prev_bar_logo')))
					{
						$link=base_path().'upload/liquor_312/'.$this->input->post('prev_bar_logo');
						unlink($link);
					}
					if(file_exists(base_path().'upload/liquor_200/'.$this->input->post('prev_bar_logo')))
					{
						$link=base_path().'upload/liquor_200/'.$this->input->post('prev_bar_logo');
						unlink($link);
					}
					if(file_exists(base_path().'upload/liquor_240/'.$this->input->post('prev_bar_logo')))
					{
						$link=base_path().'upload/liquor_240/'.$this->input->post('prev_bar_logo');
						unlink($link);
					}
					if(file_exists(base_path().'upload/liquor_291/'.$this->input->post('prev_bar_logo')))
					{
						$link=base_path().'upload/liquor_291/'.$this->input->post('prev_bar_logo');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/liquor_225/'.$this->input->post('prev_bar_logo')))
					{
						$link=base_path().'upload/liquor_225/'.$this->input->post('prev_bar_logo');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/liquor_thumb/'.$this->input->post('prev_bar_logo')))
					{
						$link=base_path().'upload/liquor_thumb/'.$this->input->post('prev_bar_logo');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/liquor_orig/'.$this->input->post('prev_bar_logo')))
					{
						$link2=base_path().'upload/liquor_orig/'.$this->input->post('prev_bar_logo');
						unlink($link2);
					}
					if(file_exists(base_path().'upload/liquor_thumb_70by70/'.$this->input->post('prev_bar_logo')))
					{
						$link2=base_path().'upload/liquor_thumb_70by70/'.$this->input->post('prev_bar_logo');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('prev_bar_logo')!='')
				{
					$cocktail_image=$this->input->post('prev_bar_logo');
				}
			}
			
			return $cocktail_image;
	}

    ///////////// upload image////////////////////////////
    //////////////// upload bar logo//////////////////////////
	
	function liquor_update($data_insert = array())
	{
		  $slug=getLiquorSlug_new($this->input->post('liquor_slug'),$this->input->post('liquor_id'));	
		$this->load->library('upload');
		// $liquor_image = '';
		 $product_image = '';
		 $name = '';
		$image_setting = image_setting();
		
 			$cocktail_image='';
		$cocktail_image1 = '';
            $liquor_image = $this->upload_cocktail_image();  
			//$liquor_image = $liquor_image;
		  if($_FILES['file_up1']['name']!='' && $this->input->post('upload_type')=='image')
         {
            $cocktail_image1 = $this->upload_cocktail_image1();  
			
		} 
			
			if($this->input->post('upload_type')=='video')
			{
				$video_link = $this->input->post('video_link');
				$cocktail_image1 = '';
			}
			else {
				$video_link ='';
			}
	
		  $data_insert = array('liquor_title'=>$this->input->post('liquor_title'),
							   'type'=>$this->input->post('type'),
							   'upload_type'=>$this->input->post('upload_type'),
							   'proof'=>$this->input->post('proof'),
							   'size'=>$this->input->post('size'),
							   'producer'=>$this->input->post('producer'),
							   'video_link'=>$video_link,
							   'country'=>$this->input->post('country'),
							   'liquor_description'=>$this->input->post('liquor_description'),
							   'liquor_image'=>$liquor_image,
							   'image_default'=>$cocktail_image1,
							   'liquor_slug'=>$slug,
							   'status'=>$this->input->post('status'),
							   'liquor_meta_title'=>$this->input->post('liquor_meta_title'),
							   'liquor_meta_keyword'=>$this->input->post('liquor_meta_keyword'),
							   'liquor_meta_description'=>$this->input->post('liquor_meta_description'),
							   'is_deleted'=>'no',
							   'date_added'=>date('Y-m-d H:i:s'));
			
		$this->db->where("liquor_id",$this->input->post('liquor_id'));
		$this->db->update('liquors',$data_insert);	
		
		
		
	}
	
	/* get liquor info
	 * param : liquor id
	 * 
	 */		
	function get_one_liquor($id)
	{
		$query = $this->db->get_where('liquors',array('liquor_id'=>$id));
		return $query->row_array();
	}	
	
	/* get total liquors
	 * param :doctor id
	 */
	function get_total_liquor_count($bar_id = 0)
	{
		//$this->db->where('is_deleted','no');
		if($bar_id > 0 && is_numeric($bar_id))
		{
			//$query = $this->db->get_where('beer_directory',array('is_deleted'=>'no',"bar_id"=>$bar_id));
			$this->db->select('*');
			$this->db->from('liquors_bars');
			$this->db->join('liquors','liquors.liquor_id=liquors_bars.liquor_id');
			$this->db->where('liquors_bars.bar_id',$bar_id);
			$this->db->where('liquors.is_deleted','no');
			$this->db->where('liquors.status','archived');
			$query= $this->db->get();
		}
       else
       {
		$query = $this->db->get_where('liquors',array('is_deleted'=>'no','status'=>'archived'));
	   }
		
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}
		return 0;
	}
	
	
	
	/* get liquor doctor wise
	 * param : doctor id
	 */
	function get_liquor_result($offset,$limit,$bar_id = 0)
	{
		
		if($bar_id > 0 && is_numeric($bar_id))
		{
			$this->db->select('*');
			$this->db->from('liquors_bars');
			$this->db->join('liquors','liquors.liquor_id=liquors_bars.liquor_id');
			$this->db->join("bars b","liquors_bars.bar_id = b.bar_id","LEFT");
			$this->db->where('liquors_bars.bar_id',$bar_id);
			$this->db->where('liquors.is_deleted','no');  
			$this->db->where('liquors.status','archived');
			$this->db->order_by("liquors.liquor_id","desc");
			$this->db->limit($limit,$offset);
		}
		else {
		$this->db->select("*,e.status,e.date_added");
		$this->db->from("liquors e");
		$this->db->join("bars b","e.bar_id = b.bar_id","LEFT");
		$this->db->where('e.is_deleted','no');
		$this->db->where('e.status','archived');
		$this->db->order_by("liquor_id","desc");
		$this->db->limit($limit,$offset);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	
	/* search liquor doctor wise
	 * param:doctor id,option ,keyword
	 */	
	function get_total_search_liquor_count($option= '',$keyword= '',$bar_id = 0)
	{
	$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('liquors.*');
		$this->db->from('liquors');
		$this->db->where('liquors.status !=','archived');
		if($bar_id > 0 && is_numeric($bar_id))
		{
			$this->db->where("bar_id",$bar_id);
		}
		
		if($option=='liquor_title')
		{
			$this->db->like('liquor_title',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('liquor_title',$val);
				// }	
			// }

		}

       
	//	$this->db->order_by('cocktail_id','desc');
		$this->db->where('is_deleted','no');
		$query = $this->db->get();
		
		
		return $query->num_rows();
	}
	
	
	
	/* search liquor doctor wise
	 * param:doctor id,option ,keyword
	 */		
	function get_search_liquor_result($option='',$keyword='',$offset =0, $limit = 0,$bar_id = 0)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select("*,liquors.status,liquors.date_added");
		$this->db->from('liquors');
		$this->db->where('liquors.status !=','archived');
		$this->db->join("bars b","liquors.bar_id = b.bar_id","LEFT");
		if($option=='liquor_title')
		{
			$this->db->like('liquor_title',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('liquor_title',$val);
				// }	
			// }

		}

      
		
		$this->db->where('liquors.is_deleted','no');  
		$this->db->order_by('liquor_id','desc');
		$this->db->limit($limit,$offset);
		
		$query = $this->db->get();
		
		
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
	
	
	
   
   function getImageliquor($id)
	{
		$query = $this->db->get_where('liquor_images',array('bar_liquorgallery_id'=>$id));
		//echo $this->db->last_query();die;
		if($query->num_rows()>0){
		return $query->result();
		}
		return '';
	}
	
	function getOneImageliquor($id)
	{
		$query = $this->db->get_where('liquor_images',array('liquor_image_id'=>$id));
		return $query->row();
	}
	
	function getallliquor($bars_id)
	{
		$this->db->select('*');
		$this->db->from('liquors');
		$this->db->where('status','active');
		$this->db->where('is_deleted','no');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
	}
		return 0;
	}
	
	function liquor_newinsert() {
	
		$to_id_arr = $this->input->post('liquor_id');
		
		
	  
		foreach($to_id_arr as $id)
		{	
					
			$data = array(
				'bar_id' => $this->input->post('bars_id'),
		     	'liquor_id' =>  $id,
				'date' => date("Y-m-d")
			);
			$this->db->insert('liquors_bars',$data);
		}
	}
	
	function get_liquor_comment_result($id = 0)
   {
   
		$this->db->select("*");
		$this->db->from("liquor_comment c");
		$this->db->join("user_master u","c.user_id = u.user_id","LEFT");
		$this->db->where("c.master_comment_id","0");
		$this->db->where("c.liquor_id",$id);
		
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
	  
	  $this->db->insert("liquor_comment",$data);
   }
   
    function get_liquor_subcomment_result($id = 0)
   {
   
		$this->db->select("*");
		$this->db->from("liquor_comment c");
		$this->db->join("user_master u","c.user_id = u.user_id","LEFT");
		$this->db->where("c.master_comment_id",$id);
		
		$qry = $this->db->get();
		if($qry->num_rows()>0)
		{
		   return  $qry->result();
			
		}
		return 0;
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
			
			if($data->sheets[0]['numCols']==6){
for($i=0;$i<count($data->sheets);$i++) // Loop to get all sheets in a file.
{
	
	
	
	if(isset($data->sheets[$i]['cells']) && count($data->sheets[$i]['cells'])>0) // checking sheet not empty
	{
		for($j=1;$j<=count($data->sheets[$i]['cells']);$j++) // loop used to get each row of the sheet
		{
			
			
			$checkbeername = $this->liquor_unique_v(trim(@$data->sheets[$i]['cells'][$j][1]),trim(@$data->sheets[$i]['cells'][$j][2]),trim(@$data->sheets[$i]['cells'][$j][3]),trim(@$data->sheets[$i]['cells'][$j][4]),trim(@$data->sheets[$i]['cells'][$j][5]));
							 $slug=getLiquorSlug(preg_replace('/[^A-Za-z0-9\- ]/', '', trim(@$data->sheets[$i]['cells'][$j][1])));
							 
							 	
						if(isset($data->sheets[$i]['cells'][$j][1]) && $checkbeername==0 && $data->sheets[$i]['cells'][$j][1]!="Liquor Title")
						{
								
							
			$arr=array(
			                        
										'liquor_title'=>isset($data->sheets[$i]['cells'][$j][1]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][1])):'' ,
										'liquor_description'=>isset($data->sheets[$i]['cells'][$j][1]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][6])):'' ,
										'type'=>isset($data->sheets[$i]['cells'][$j][2]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][2])):'' ,
										'proof'=>isset($data->sheets[$i]['cells'][$j][3]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][3])):'' ,
										'producer'=>isset($data->sheets[$i]['cells'][$j][4]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][4])):'' ,
										'country'=>isset($data->sheets[$i]['cells'][$j][5]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][5])):'' ,
										'is_deleted'=>'no',
										'liquor_slug'=>$slug,
										'status'=>'Active',
										'bar_id'=>0,
										'date_added'=>date('Y-m-d H:i:s'),
										);
										
								
			
			$this->db->insert('liquors',$arr,FALSE);	
			
			
			
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
								redirect('liquor/list_liquor/'.$limit.'/0/'.$offset.'/'.$result.'/'.base64_encode(0).'/'.base64_encode($data->sheets[0]['numRows']));
							}
							else {
								redirect('liquor/list_liquor/'.$limit.'/0/'.$offset.'/'.$result.'/'.base64_encode($arr123).'/'.base64_encode($data->sheets[0]['numRows']));
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

	function liquor_unique_v($str='',$type='',$proof='',$pro='',$con='',$id='')
	{
		if($id=='')
		{
	       	$query = $this->db->query("select liquor_title from ".$this->db->dbprefix('liquors')." where type='".addslashes(utf8_encode($type))."' and proof='".addslashes(utf8_encode($proof))."' and producer='".addslashes(utf8_encode($pro))."' and country='".addslashes(utf8_encode($con))."' and liquor_title = '".addslashes(utf8_encode($str))."' ");		
		}
		else {
				$query = $this->db->query("select liquor_title from ".$this->db->dbprefix('liquors')." where type='".addslashes(utf8_encode($type))."' and proof='".addslashes(utf8_encode($proof))."' and producer='".addslashes(utf8_encode($pro))."' and country='".addslashes(utf8_encode($con))."' and liquor_id!='".$id."' and liquor_title = '".addslashes(utf8_encode($str))."' ");
		}
	
		
		if($query->num_rows()>0){
			return 1;
		}else{
			return 0;
		}
	}
	
	function getAllLiquorResult($bar_id = 0,$option,$keyword)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		if($bar_id > 0 && is_numeric($bar_id))
		{
			$this->db->select('liquor_title as `Liquor Title`, type as  `Type`, proof as `Proof`, producer as `Producer`, country as `Country`');
			$this->db->from('liquors_bars');
			$this->db->join('liquors','liquors.liquor_id=liquors_bars.liquor_id');
			$this->db->join("liquors b","liquors_bars.bar_id = b.bar_id","LEFT");
			$this->db->where('liquors_bars.bar_id',$bar_id);
		}
		else
		{
			$this->db->select('liquor_title as `Liquor Title`, type as  `Type`, proof as `Proof`, producer as `Producer`, country as `Country`');
			$this->db->from('liquors');
			$this->db->join("bars b","liquors.bar_id = b.bar_id","LEFT");
		}
		
		if($option=='liquor_title')
		{
			$this->db->like('liquor_title',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('liquor_title',$val);
				}	
			}

		}
		
		$this->db->where('liquors.is_deleted','no');  
		$query = $this->db->get();
		
		
		
			
			return $query;
	}
}
?>