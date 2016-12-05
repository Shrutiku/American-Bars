<?php

class Bar_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	// --------------------------------------------------------------------

      /** 
       * function SaveForm()
       *
       * insert form dataget_bar_result
	   * 
       * @param $form_data - array
       * @return Bool - TRUE or FALSE
       */

	
	
    function bar_insert($data_insert = array())
	{
		// $data_insert1['first_name'] = $this->input->post('bar_first_name') ;
		// $data_insert1['last_name'] = $this->input->post('bar_last_name') ;
		// $data_insert1['email'] = $this->input->post('email');
		// $data_insert1['address'] = $this->input->post('address');
		// $data_insert1['user_city'] = $this->input->post('city');
		// $data_insert1['user_state'] = $this->input->post('state');
		// $data_insert1['user_zip'] = $this->input->post('zipcode');
		// $data_insert1['status'] = 'active';
		// $data_insert1['is_deleted'] = 'no';
		// $data_insert1['user_type'] = 'bar_owner';
		// $data_insert1['sign_up_ip'] = $_SERVER['REMOTE_ADDR'];
		// $data_insert1['sign_up_date'] = date('Y-m-d H:i:s');	
		// $data_insert1['expire_date'] = date('Y-m-d', strtotime("+30 days"));
		// $this->db->insert('user_master',$data_insert1);	
		// $id1 = mysql_insert_id();
		if($this->input->post('bar_category'))
		{
		$getcat = implode(",", $this->input->post('bar_category'));  
		}
		else
		{
			$getcat = '';
		}	
		 $getlat = getCoordinatesFromAddress($this->input->post('address'),$this->input->post('city'),$this->input->post('state'));
		// print_r($getlat)."Fdsaf";
		// die;
             $slug= getBarSlug($data_insert["bar_title"]);	
 	     $data_insert['bar_slug'] = $slug;
		   unset($data_insert["bar_id"]);
		   unset($data_insert["offset"]);
		   unset($data_insert["limit"]);
		   unset($data_insert["option"]);
		   unset($data_insert["uid"]);
		    unset($data_insert["bar_category"]);
		   unset($data_insert["pos"]);
		   unset($data_insert["keyword"]);
		   unset($data_insert["search_option"]);
		   unset($data_insert["redirect_page"]);
		   unset($data_insert["search_keyword"]);
		   unset($data_insert["submit"]);
					
          if($_FILES["bar_logo_file"]["name"] != "")
		  {
		  	$logo_image = $this->upload_bar_logo();
			  $data_insert['bar_logo']=$logo_image;
		  }
		  
		  if($_FILES["bar_banner_file"]["name"] != "")
		  {
		  	$banner_image = $this->upload_bar_banner();
			  $data_insert['bar_banner']=$banner_image;
		  }
		  
		  if($this->input->post('bar_type')=='managed_bar')
		  {
		  	  $data_insert['is_managed']='yes';
		  	   $data_insert['bar_type']='full_mug';
		  }
		
		  if($_FILES["bar_video_file"]["name"] != "")
		  {
		
			
			$types = explode(".",$_FILES["bar_video_file"]["name"]);
			
			if(isset($types[1]))
			{
				$type = $types[1];
			}
			else {
				$type =  'mp4';
			}
		
		  	  $name = "bar_video_".rand(0,100000).".".$type;
		  	  $upload_path = base_path()."upload/barvideo/".$name;
			  
			  move_uploaded_file($_FILES["bar_video_file"]["tmp_name"],$upload_path);
			  
			  $data_insert['bar_video']=$name;
		  }
          
	      
		
	      unset($data_insert["prev_bar_video"]);
          unset($data_insert["prev_bar_banner"]);
          unset($data_insert["prev_bar_logo"]);
          
		
		
		$data_insert["cash_p"] = $this->input->post('cash_p');
		$data_insert["master_p"] = $this->input->post('master_p');
		$data_insert["american_p"] = $this->input->post('american_p');
		$data_insert["visa_p"] = $this->input->post('visa_p');
		$data_insert["paypal_p"] = $this->input->post('paypal_p');
		$data_insert["bitcoin_p"] = $this->input->post('bitcoin_p');
		$data_insert["apple_p"] = $this->input->post('apple_p');
		$data_insert["owner_id"] = 0;
		$data_insert["lat"] = $getlat['lat'];
		$data_insert["lang"] = $getlat['lng'];
		$data_insert["bar_category"] =$getcat;
		$data_insert['date_added']=date('Y-m-d H:i:s');
		$this->db->insert('bars', $data_insert);
			
		$id = mysql_insert_id();
		
		
	
		
		
		$inar = array('cat_id'=>$id,
		              'category'=>'bar',
					  'date'=>date('Y-m-d H:i:s'));
		$this->db->insert('sitemap', $inar);

	}
	function bar_suggest_update()
	{
		$getlat = getCoordinatesFromAddress($this->input->post('address'),$this->input->post('city'),$this->input->post('state'));
		$inar = array('bar_name'=>$this->input->post('bar_name'),
		              'address'=>$this->input->post('address'),
		              'city'=>$this->input->post('city'),
		              'state'=>$this->input->post('state'),
		              'phone_number'=>$this->input->post('phone'),
		              'lat'=>$getlat['lat'],
		              'lang'=>$getlat['lang'],
		              'zip_code'=>$this->input->post('zipcode'));
		$this->db->where('suggest_bar_id', $this->input->post('suggest_bar_id'));
		$this->db->update('suggest_bars', $inar);
			
	}	
	function bar_update($data_insert = array())
	{
		if($this->input->post('bar_category'))
		{
		$getcat = implode(",", $this->input->post('bar_category'));  
		}
		else
		{
			$getcat = '';
		}	
		 $getlat = getCoordinatesFromAddress($this->input->post('address'),$this->input->post('city'),$this->input->post('state'));
		
		$getbardata = $this->get_one_bar($data_insert["bar_id"]);
		
		if($getbardata['bar_type']=='full_mug' && $this->input->post('bar_type')=='half_mug' && $this->input->post('uid')!='' && $this->input->post('uid')!='0')
		{
			    $getuserinfo = get_user_info($this->input->post('uid'));
				
				
			    $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Cancel Full Mug Membership Email To User'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = $getuserinfo->email;
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{username}', ucwords($this->input->post('bar_first_name'))." ".ucwords($this->input->post('bar_last_name')), $email_message);
				$str = $email_message;
				if($email_temp->status=='active'){
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
				}
				$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Cancel Full Mug Membership Email To Admin'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = getsuperadminemail();
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{username}', ucwords($this->input->post('bar_first_name'))." ".ucwords($this->input->post('bar_last_name')), $email_message);
				$email_subject = str_replace('{username}', ucwords($this->input->post('bar_first_name'))." ".ucwords($this->input->post('bar_last_name')), $email_subject);
				$str = $email_message;
				
				$getemail = explode(',', $email);
				if($email_temp->status=='active'){
				foreach($getemail as $r){
					email_send($email_address_from, $email_address_reply, $r, $email_subject, $str);
				}
				}
		}
	 $slug=getBarSlug_new($data_insert['bar_slug'],$data_insert["bar_id"]);	
      
	 
	 $data_insert['date_added']=date('Y-m-d H:i:s');
 	 $bar_id = $data_insert['bar_id'];
	      $data_insert['bar_slug'] = $slug;
          unset($data_insert["bar_id"]);
		   unset($data_insert["offset"]);
		   unset($data_insert["limit"]);
		   unset($data_insert["option"]);
		   unset($data_insert["keyword"]);
		   unset($data_insert["pos"]);
		       unset($data_insert["bar_category"]);
		  // unset($data_insert["bar_slug"]);
		   unset($data_insert["search_option"]);
		   unset($data_insert["redirect_page"]);
		   unset($data_insert["search_keyword"]);
		   unset($data_insert["submit"]);
					 
	
	 	  if($_FILES["bar_logo_file"]["name"] != "")
		  {
		  	$logo_image = $this->upload_bar_logo();
			  $data_insert['bar_logo']=$logo_image;
		  }
		  
		  if($_FILES["bar_banner_file"]["name"] != ""  || $this->input->post('pos')!=0)
		  {
		  	  $banner_image = $this->upload_bar_banner();
			  $data_insert['bar_banner']=$banner_image;
		  }
		   if($this->input->post('bar_type')=='managed_bar')
		  {
		  	  $data_insert['is_managed']='yes';
		  	   $data_insert['bar_type']='full_mug';
		  }
else {
	  $data_insert['is_managed']='no';
}
		  
		   if($_FILES["bar_video_file"]["name"] != "")
		  {
		
			
			$types = explode(".",$_FILES["bar_video_file"]["name"]);
			
			if(isset($types[1]))
			{
				$type = $types[1];
			}
			else {
				$type =  'mp4';
			}
		
		  	  $name = "bar_video_".rand(0,100000).".".$type;
		  	  $upload_path = base_path()."upload/barvideo/".$name;
			  
			  move_uploaded_file($_FILES["bar_video_file"]["tmp_name"],$upload_path);
			  
			  if(file_exists(base_path().'upload/barvideo/'.$this->input->post('prev_bar_video')))
			  {
			     $link2=base_path().'upload/barvideo/'.$this->input->post('prev_bar_video');
			     unlink($link2);
			  }
			  
			  $data_insert['bar_video']=$name;
		  }
   
       unset($data_insert["prev_bar_video"]);
       unset($data_insert["prev_bar_banner"]);
       unset($data_insert["prev_bar_logo"]);
	   unset($data_insert["first_name"]);
	   unset($data_insert["uid"]);
	   unset($data_insert["last_name"]);
	   unset($data_insert["prev_bar_logo"]);
   
   
     if($this->input->post('bar_first_name')=='' && $this->input->post('bar_last_name')=='' && $this->input->post('email')=='')
     {
     			$one_bar = $this->get_one_bar($this->input->post('bar_id'));
				
				if(!empty($one_bar))
				{
				if($one_bar['owner_id']!=0 && $one_bar['owner_id']!='')
				{
					$this->db->delete('user_master',array('user_id'=>$one_bar['owner_id']));
				}
				}	
     		$data_insert["claim"] = 'unclaimed';
     }
			$data_insert["cash_p"] = $this->input->post('cash_p');
		$data_insert["master_p"] = $this->input->post('master_p');
		$data_insert["american_p"] = $this->input->post('american_p');
		$data_insert["visa_p"] = $this->input->post('visa_p');
		$data_insert["bar_category"] =$getcat;
		$data_insert["paypal_p"] = $this->input->post('paypal_p');
		$data_insert["bitcoin_p"] = $this->input->post('bitcoin_p');
		$data_insert["apple_p"] = $this->input->post('apple_p');
		$data_insert["lat"] = $getlat['lat'];
		$data_insert["lang"] = $getlat['lng'];
		
	
		$this->db->where("bar_id",$bar_id);
		$this->db->update('bars',$data_insert);
		
		if($this->input->post('uid')!='' && $this->input->post('uid')!='0')
		{
			
			$arrup = array('first_name'=>$this->input->post('bar_first_name'),
			               'last_name'=>$this->input->post('bar_last_name'));
			$this->db->where("user_id",$this->input->post('uid'));
		   $this->db->update('user_master',$arrup);
		   
		   
		}
		
		
	}
	
	
	
	//////////////// upload bar logo//////////////////////////
	function upload_bar_logo()
	{
		$bar_logo_img = '';
		 if($_FILES['bar_logo_file']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['bar_logo_file']['name'];
             $_FILES['userfile']['type']     =   $_FILES['bar_logo_file']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['bar_logo_file']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['bar_logo_file']['error'];
             $_FILES['userfile']['size']     =   $_FILES['bar_logo_file']['size'];
   
			$config['file_name'] = 'bar_logo'.$rand;
			
            $config['upload_path'] = base_path().'upload/barlogo_orig/';
			
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
		   
             
			$this->image_lib->clear();
			
			resize(base_path().'upload/barlogo_orig/'.$picture['file_name'],base_path().'upload/barlogo/'.$picture['file_name'],685,320);
			
			
			$this->image_lib->clear();
		   
		   
		   resize(base_path().'upload/barlogo_orig/'.$picture['file_name'],base_path().'upload/barlogo_thumb/'.$picture['file_name'],120,120);
             
			$this->image_lib->clear();
		   
		   
		   resize(base_path().'upload/barlogo_orig/'.$picture['file_name'],base_path().'upload/barlogo_312/'.$picture['file_name'],312,312);
             
			$this->image_lib->clear();
		   
		   
		   resize(base_path().'upload/barlogo_orig/'.$picture['file_name'],base_path().'upload/barlogo_291/'.$picture['file_name'],291,291);
            
            $this->image_lib->clear();
		   
		   
		   resize(base_path().'upload/barlogo_orig/'.$picture['file_name'],base_path().'upload/barlogo_225/'.$picture['file_name'],225,225);
             
              $this->image_lib->clear();
		   
		   
		   resize(base_path().'upload/barlogo_orig/'.$picture['file_name'],base_path().'upload/barlogo_200/'.$picture['file_name'],200,200);
             
                $this->image_lib->clear();
		   
		   
		   resize(base_path().'upload/barlogo_orig/'.$picture['file_name'],base_path().'upload/barlogo_240/'.$picture['file_name'],240,240);
             
                
             
			$bar_logo_img=$picture['file_name'];
			
		
			if($this->input->post('prev_bar_logo')!='')
				{
					if(file_exists(base_path().'upload/barlogo_200/'.$this->input->post('prev_bar_logo')))
					{
						$link=base_path().'upload/barlogo_200/'.$this->input->post('prev_bar_logo');
						unlink($link);
					}
					if(file_exists(base_path().'upload/barlogo_240/'.$this->input->post('prev_bar_logo')))
					{
						$link=base_path().'upload/barlogo_240/'.$this->input->post('prev_bar_logo');
						unlink($link);
					}
					if(file_exists(base_path().'upload/barlogo_orig/'.$this->input->post('prev_bar_logo')))
					{
						$link=base_path().'upload/barlogo_orig/'.$this->input->post('prev_bar_logo');
						unlink($link);
					}
			if(file_exists(base_path().'upload/barlogo_312/'.$this->input->post('prev_bar_logo')))
					{
						$link=base_path().'upload/barlogo_312/'.$this->input->post('prev_bar_logo');
						unlink($link);
					}
if(file_exists(base_path().'upload/barlogo_225/'.$this->input->post('prev_bar_logo')))
					{
						$link=base_path().'upload/barlogo_225/'.$this->input->post('prev_bar_logo');
						unlink($link);
					}
				if(file_exists(base_path().'upload/barlogo_291/'.$this->input->post('prev_bar_logo')))
					{
						$link=base_path().'upload/barlogo_291/'.$this->input->post('prev_bar_logo');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/barlogo/'.$this->input->post('prev_bar_logo')))
					{
						$link2=base_path().'upload/barlogo/'.$this->input->post('prev_bar_logo');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('prev_bar_logo')!='')
				{
					$bar_logo_img=$this->input->post('prev_bar_logo');
				}
			}
			
			return $bar_logo_img;
	}
	////////////// end of upload bar logo/////////////////////
	
	
	////////////////// upload banner ......///////////////////
	function upload_bar_banner()
	{
		$bar_banner_img = '';
		 if($_FILES['bar_banner_file']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['bar_banner_file']['name'];
             $_FILES['userfile']['type']     =   $_FILES['bar_banner_file']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['bar_banner_file']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['bar_banner_file']['error'];
             $_FILES['userfile']['size']     =   $_FILES['bar_banner_file']['size'];
   
			$config['file_name'] = 'bar_logo'.$rand;
			
            $config['upload_path'] = base_path().'upload/barlogo_orig/';
			
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
				
				
		   if ($_FILES["bar_banner_file"]["type"]!= "image/png" and $_FILES["bar_banner_file"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["bar_banner_file"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["bar_banner_file"]["type"] != "image/jpeg" and $_FILES["bar_banner_file"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			resize(base_path().'upload/barlogo_orig/'.$picture['file_name'],base_path().'upload/barlogo/'.$picture['file_name'],685,320);
			
			
			$this->image_lib->clear();
			
			resize(base_path().'upload/barlogo_orig/'.$picture['file_name'],base_path().'upload/banner_without_drag/'.$picture['file_name'],1140,244);
			
			$this->image_lib->clear();
			
			$crop_from_top = abs ($this->input->post('pos')) ;
			
		
		$default_cover_width = 1140;
		$default_cover_height = 244;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/barlogo_orig/'.$picture['file_name'];

		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/banner_drag/'.$picture['file_name'];
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
		
		resize(base_path().'upload/banner_drag/'.$picture['file_name'],base_path().'upload/banner_drag_thumb/'.$picture['file_name'],150,150);
			 // $this->image_lib->initialize(array(
				// 'image_library' => $gd_var,
				// 'source_image' => base_path().'upload/barlogo_orig/'.$picture['file_name'],
				// 'new_image' => base_path().'upload/banner_drag/'.$picture['file_name'],
				// 'maintain_ratio' => FALSE,
				// 'quality' => '100%',
				// 'width' => '685',
				// 'height' => '320',
				// 'x_axis' => $this->input->post('pos'),
			 // ));
// 			
// 			
			// if(!$this->image_lib->crop())
			// {
				// $error = $this->image_lib->display_errors();
			// }
// 			
			$bar_banner_img=$picture['file_name'];
			
		
			if($this->input->post('prev_bar_banner')!='')
				{
					if(file_exists(base_path().'upload/barlogo_orig/'.$this->input->post('prev_bar_banner')))
					{
						$link=base_path().'upload/barlogo_orig/'.$this->input->post('prev_bar_banner');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/barlogo/'.$this->input->post('prev_bar_banner')))
					{
						$link2=base_path().'upload/barlogo/'.$this->input->post('prev_bar_banner');
						unlink($link2);
					}

					if(file_exists(base_path().'upload/banner_drag/'.$this->input->post('prev_bar_banner')))
					{
						$link2=base_path().'upload/banner_drag/'.$this->input->post('prev_bar_banner');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('prev_bar_banner')!='')
				{
					
					if($this->input->post('pos')!=0)
					{
						if(file_exists(base_path().'upload/banner_drag/'.$this->input->post('prev_bar_banner')))
					{
						$link=base_path().'upload/banner_drag/'.$this->input->post('prev_bar_banner');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/banner_drag_thumb/'.$this->input->post('prev_bar_banner')))
					{
						$link=base_path().'upload/banner_drag_thumb/'.$this->input->post('prev_bar_banner');
						unlink($link);
					}
					
						$this->load->library('upload');
						$crop_from_top = abs ($this->input->post('pos')) ;
						
						
		$default_cover_width = 1140;
		$default_cover_height = 244;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/barlogo_orig/'.$this->input->post('prev_bar_banner');

		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/banner_drag/'.$this->input->post('prev_bar_banner');
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
		
		resize(base_path().'upload/banner_drag/'.$this->input->post('prev_bar_banner'),base_path().'upload/banner_drag_thumb/'.$this->input->post('prev_bar_banner'),150,150);
					}
					$bar_banner_img=$this->input->post('prev_bar_banner');
				}
			}
			
			return $bar_banner_img;
	}
	/////// end of uplaod banner //////////////////////////////
	function get_total_bar_count($bar_type = '')
	{
	// return $this->db->count_all('bars');
	
	    $this->db->select('b.*');
		$this->db->from('bars b');
		$this->db->join('user_master u','u.user_id=b.owner_id','left');
		
		if($bar_type != "all" && $bar_type!='managed_bar' )
		{
			$this->db->where("bar_type",$bar_type);
		}
		if($bar_type=='managed_bar' )
		{
			$this->db->where("is_managed",'yes');
		}
		$this->db->where("b.status !=",'archived');
		
		$qry = $this->db->get();
		
		return $qry->num_rows();
	}
	
	function get_bar_count($master_id)
	{
		
		//echo $master_id; die;	
	 return $this->db->count_all('bars');
		//echo $this->db->last_query(); die;
	}
	
	function get_bar_result($offset=0, $limit=0,$bar_type = '')
	{
		$this->db->select('b.*,u.user_id,u.status as ustatus, u.agree, u.is_agree_shown, u.date_shown');
		$this->db->from('bars b');
		$this->db->join('user_master u','u.user_id=b.owner_id','left');
		
		if($bar_type != "all" && $bar_type!='managed_bar' )
		{
			$this->db->where("bar_type",$bar_type);
		}
		if($bar_type=='managed_bar' )
		{
			$this->db->where("is_managed",'yes');
		}
		
		$this->db->where("b.status !=",'archived');
		$this->db->limit($limit,$offset);
		$this->db->order_by('b.bar_id','desc');
		$qry = $this->db->get();

	 
		     
	    if ($qry->num_rows() > 0) {
			return $qry->result();
		}
		return 0;
	}
	
	function get_one_bar($id=0)
	{
	   //$query = $this->db->get_where('bars',array("bar_id"=>$id));
	   $this->db->select('bars.*,user_master.first_name,user_master.last_name');
		$this->db->from('bars');
		$this->db->join('user_master','bars.owner_id=user_master.user_id','left');
		$this->db->where('bars.bar_id',$id);
		$query = $this->db->get();
		//return $query->row_array();
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return 0;
	}
	
	function get_one_barsuggest($id)
	{
	   //$query = $this->db->get_where('bars',array("bar_id"=>$id));
	   $this->db->select('*');
		$this->db->from('suggest_bars');
		$this->db->where('suggest_bar_id',$id);
		$query = $this->db->get();
		//return $query->row_array();
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return 0;
	}
	
	
	
	
	function get_total_search_bar_count($bar_type='',$option='',$keyword='')
	{
	  
	     $keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
	
		$this->db->select('b.bar_id');
		
		$this->db->from('bars b');
		
		
		
		if($bar_type != "all" && $bar_type!='managed_bar' )
		{
			$this->db->where("b.bar_type",$bar_type);
		}
		if($bar_type=='managed_bar' )
		{
			$this->db->where("b.is_managed",'yes');
		}
		
		if($option =="cust_num")
		{
			$this->db->where("b.bar_id",$keyword);
		}
		
		if($option=="bar_title")
		{
				   $this->db->like("b.bar_title",$keyword,'after');
				   
				   // if(substr_count($keyword,' ')>=1)
			      // {
				     // $ex=explode(' ',$keyword);
// 				
					// foreach($ex as $val)
					// {
						// $this->db->like('b.bar_title',$val,'both');
					// }	
				// }
				
				
		}
		if($option=="owner_name")
		{
				   $this->db->like("owner_name",$keyword,'after');
				   
				   // if(substr_count($keyword,' ')>=1)
			      // {
				     // $ex=explode(' ',$keyword);
// 				
					// foreach($ex as $val)
					// {
						// $this->db->like('owner_name',$val,'after');
					// }	
				// }
				
				
		}
		
		if($option=="city")
		{
				   $this->db->like("city",$keyword,'after');
				   
				   // if(substr_count($keyword,' ')>=1)
			      // {
				     // $ex=explode(' ',$keyword);
// 				
					// foreach($ex as $val)
					// {
						// $this->db->like('city',$val,'after');
					// }	
				// }
				
				
		}
		
		
		if($option=="state")
		{
				   $this->db->like("state",$keyword,'after');
				   
				   // if(substr_count($keyword,' ')>=1)
			      // {
				     // $ex=explode(' ',$keyword);
// 				
					// foreach($ex as $val)
					// {
						// $this->db->like('state',$val,'after');
					// }	
				// }
				
				
		}
		
		if($option=="email")
		{
				   $this->db->like("email",$keyword,'after');
				   
				   // if(substr_count($keyword,' ')>=1)
			      // {
				     // $ex=explode(' ',$keyword);
// 				
					// foreach($ex as $val)
					// {
						// $this->db->like('email',$val);
					// }	
				// }
				
				
		}
		
		if($option=="zipcode")
		{
		    $this->db->like("zipcode",$keyword,'after');
		}
		
		if($option=="phone")
		{
		 $this->db->like("phone",$keyword,'after');
		   
		}
		$this->db->where("b.status !=",'archived');
		
		
		$query = $this->db->get();
		//echo $query = $this->db->last_query(); die;
		return $query->num_rows();
	}
	
	function get_search_bar_result($bar_type,$option,$keyword,$offset, $limit)
	{
	
	   $keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
	   
	   //$this->db->select('b.*');
	   $this->db->select('b.*,u.user_id,u.status as ustatus');
	   
		$this->db->from('bars b');
		$this->db->join('user_master u','u.user_id=b.owner_id','left');
		
		if($bar_type != "all" && $bar_type!='managed_bar' )
		{
			$this->db->where("b.bar_type",$bar_type);
		}
		if($bar_type=='managed_bar' )
		{
			$this->db->where("b.is_managed",'yes');
		}
		
		if($option=="bar_title")
		{
				   $this->db->like("b.bar_title",$keyword,'after');
				   
				   // if(substr_count($keyword,' ')>=1)
			      // {
				     // $ex=explode(' ',$keyword);
// 				
					// foreach($ex as $val)
					// {
						// $this->db->like('b.bar_title',$val,'both');
					// }	
				// }
				
				
		}
		
		if($option=="owner_name")
		{
				   $this->db->like("owner_name",$keyword,'after');
				   
				   // if(substr_count($keyword,' ')>=1)
			      // {
				     // $ex=explode(' ',$keyword);
// 				
					// foreach($ex as $val)
					// {
						// $this->db->like('owner_name',$val,'after');
					// }	
				// }
				
				
		}
		
		if($option=="city")
		{
				   $this->db->like("city",$keyword,'after');
				   
				   // if(substr_count($keyword,' ')>=1)
			      // {
				     // $ex=explode(' ',$keyword);
// 				
					// foreach($ex as $val)
					// {
						// $this->db->like('city',$val,'after');
					// }	
				// }
// 				
				
		}
		
		
		if($option=="state")
		{
				   $this->db->like("state",$keyword,'after');
				   
				   // if(substr_count($keyword,' ')>=1)
			      // {
				     // $ex=explode(' ',$keyword);
// 				
					// foreach($ex as $val)
					// {
						// $this->db->like('state',$val,'after');
					// }	
				// }
				
				
		}
		
		if($option=="email")
		{
				   $this->db->like("email",$keyword,'after');
				   
				   // if(substr_count($keyword,' ')>=1)
			      // {
				     // $ex=explode(' ',$keyword);
// 				
					// foreach($ex as $val)
					// {
						// $this->db->like('email',$val,'after');
					// }	
				// }
				
				
		}
		
		if($option=="zipcode")
		{
		    $this->db->like("zipcode",$keyword,'after');
		}
		
		if($option=="phone")
		{
		 $this->db->like("phone",$keyword,'after');
		   
		}
		
		if($option =="cust_num")
		{
			$this->db->where("b.bar_id",$keyword);
		}
		$this->db->where("b.status !=",'archived');
		$this->db->order_by("bar_id", "desc"); 
		$this->db->limit($limit,$offset);
	$query = $this->db->get();
		
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	
	}
	
	/////////////// bar comment function/////////////////////
	function get_total_bar_comment_count($id = 0)
	{
		$qry= $this->db->get_where("bar_comment",array("bar_id"=>$id,'is_deleted'=>'no'));
		
		return $qry->num_rows();
	}
	
	function get_bar_comment_result($id = 0,$limit = 0, $offset = 0)
	{
		
		$this->db->select("bc.*,u.first_name,u.last_name,u.email");
		$this->db->from("bar_comment bc");
		$this->db->join("user_master u","u.user_id = bc.user_id","left");
		$this->db->where("bar_id",$id);
		$this->db->where("bc.is_deleted",'no');
		$this -> db->order_by("bar_comment_id","desc");
		$this->db->limit($limit,$offset);
		
		$qry = $this->db->get();
		 
		
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		
		
		return 0;
		
		
	}
	////////// end of bar comment function//////////////////
	
	function get_one_bar_comment($id = 0)
	{
		$qry = $this->db->get_where("bar_comment",array("bar_comment_id"=>$id));
		
		if($qry->num_rows()>0)
		{
			return $qry->row_array();
		}
		
		return 0;
	}
	
	
	
	function comment_update($id =0 ,$update = array())
	{
		 $this->db->where("bar_comment_id",$id);
		 $this->db->update("bar_comment",$update);
		 
		return true;
	}
	
	
	function comment_insert($update = array())
	{
		
		 $this->db->insert("bar_comment",$update);
		 
		return true;
	}
	
	
	
	/* check unique email
	 * param : email, user id(if in edit mode)
	 */
	function bar_title_unique($str)
	{
		if($this->input->post('bar_id'))
		{
			$query = $this->db->get_where('bars',array('bar_id'=>$this->input->post('bar_id')));
			$res = $query->row_array();
			$email = $res['bar_title'];
			
			$query = $this->db->query("select bar_title from ".$this->db->dbprefix('bars')." where  address = '".addslashes($this->input->post('address'))."' and bar_title = '".addslashes($str)."' and bar_id !='".$this->input->post('bar_id')."'");
		}else{
			$query = $this->db->query("select bar_title from ".$this->db->dbprefix('bars')." where  address = '".addslashes($this->input->post('address'))."' and bar_title = '".addslashes($str)."'");
		}
		
		
		
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}

	function get_total_domain_bar()
	{
		// return $this->db->count_all('bars');

		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->where(array( 'agree' => '1'));
		$qry = $this->db->get();
		return $qry->num_rows();
	}
	/////// end of uplaod banner //////////////////////////////
	function get_total_suggest_bar()
	{
	// return $this->db->count_all('bars');
	
	    $this->db->select('*');
		$this->db->from('suggest_bars');
		$this->db->where('status','pending');
		$qry = $this->db->get();
		return $qry->num_rows();
	}
	
	function get_total_suggest_ad()
	{
	// return $this->db->count_all('bars');
	
	    $this->db->select('*');
		$this->db->from('suggest_advertise');
		$qry = $this->db->get();
		return $qry->num_rows();
	}
	
	function get_suggest_bar_result($offset=0, $limit=0)
	{
		$this->db->select('*');
		$this->db->from('suggest_bars');
		$this->db->where('status','pending');
		$this->db->limit($limit,$offset);
		$this -> db->order_by("suggest_bar_id","desc");
		
		$qry = $this->db->get();
	    if ($qry->num_rows() > 0) {
			return $qry->result();
		}
		return 0;
	}

	function get_domain_bar_result()
	{
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->where(array('agree' => '1'));

		$qry = $this->db->get();
		if ($qry->num_rows() > 0) {
			return $qry->result();
		}
		return 0;
	}

	function get_suggest_ad_result($offset=0, $limit=0)
	{
		$this->db->select('*');
		$this->db->from('suggest_advertise');
		$this->db->limit($limit,$offset);
		$this -> db->order_by("suggest_ad_id","desc");
		$qry = $this->db->get();
	    if ($qry->num_rows() > 0) {
			return $qry->result();
		}
		return 0;
	}

	function get_total_search_suggest_bar_count($option='',$keyword='')
	{
	  
	     $keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
	
		$this->db->select('*');
		$this->db->from('suggest_bars');
		$this->db->where('status','pending');
		
		if($option=="name")
		{
				   $this->db->like("bar_name",$keyword);
				   
				   if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('bar_name',$val);
					}	
				}
				
				
		}
		
		$query = $this->db->get();
		//echo $query = $this->db->last_query(); die;
		return $query->num_rows();
	}
	
	function get_search_suggest_bar_record_result($option,$keyword,$offset, $limit)
	{
	
	   $keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
	   
	   $this->db->select('*');
		$this->db->from('suggest_bars');
		$this->db->where('status','pending');
		if($option=="name")
		{
				   $this->db->like("bar_name",$keyword,'after');
				   
				
				
		}
		
		$this->db->order_by("suggest_bar_id", "desc"); 
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	
	}
	
	function get_total_search_suggest_ad_count($option='',$keyword='')
	{
	  
	     $keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
	
		$this->db->select('*');
		$this->db->from('suggest_advertise');
		
		
		if($option=="name")
		{
				   $this->db->like("name",$keyword,'after');
				   
				
		}
		
		if($option=="type")
		{
				   $this->db->like("type",$keyword,'after');
				   
				
		}
		
		$query = $this->db->get();
		//echo $query = $this->db->last_query(); die;
		return $query->num_rows();
	}
	
	function get_search_suggest_ad_record_result($option,$keyword,$offset, $limit)
	{
	
	   $keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
	   
	   $this->db->select('*');
		$this->db->from('suggest_advertise');
		if($option=="name")
		{
				   $this->db->like("name",$keyword,'after');
				   
				
		}
		
		if($option=="type")
		{
				   $this->db->like("type",$keyword,'after');
				   
				
		}
		
		$this->db->order_by("suggest_ad_id", "desc"); 
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	
	}
	
	function get_suggest_bar($id)
	{
		$this->db->select('*');
		$this->db->from('suggest_bars');
		$this->db->where('suggest_bar_id',$id);
		$qry = $this->db->get();
		if ($qry->num_rows() > 0) {
			
			return $qry->row_array();
		}
		return 0;
		
	}
	
	function get_suggest_ad($id)
	{
		$this->db->select('*');
		$this->db->from('suggest_advertise');
		$this->db->where('suggest_ad_id',$id);
		$qry = $this->db->get();
		if ($qry->num_rows() > 0) {
			
			return $qry->row_array();
		}
		return 0;
		
	}
	
	function get_bar_postcard_count($bar_id)
	{
		$this->db->select('*');
		$this->db->from('bar_post_card');
		$this->db->where('bar_post_card.bar_id',$bar_id);
		$this->db->where('bar_post_card.status','active');
		$this->db->where('bar_post_card.is_delete',0);
		$this->db->order_by('bar_post_card.postcard_id','desc');
		$query= $this->db->get();
		
		return $query->num_rows();
	}
	
	function get_suggest_bar_info($id)
	{
		$this->db->select('*');
		$this->db->from('suggest_bars');
		$this->db->where('suggest_bar_id',$id);
		$qry = $this->db->get();
		if ($qry->num_rows() > 0) {
			
			return $qry->row_array();
		}
		return 0;
	}
	
	
	function bar_name($str)
	{
		
		$query = $this->db->query("select bar_title from ".$this->db->dbprefix('bars')." where md5(bar_title) = '".md5($str)."'",FALSE);
			
			
		if($query->num_rows()>0){
			
			return 1;
		}else{
			
			return 0;
		}
	}
	
	function bar_name_address($addr,$str)
	{
		$query = $this->db->query("select bar_title from ".$this->db->dbprefix('bars')." where address='".addslashes(utf8_encode($addr))."' and bar_title = '".addslashes(utf8_encode($str))."'",FALSE);
			
			
		if($query->num_rows()>0){
			
			return 1;
		}else{
			
			return 0;
		}
	}
	function bar_email($str)
	{
		
		$query = $this->db->query("select email from ".$this->db->dbprefix('bars')." where md5(email) = '".md5($str)."'",FALSE);
		$query1 = $this->db->query("select email from ".$this->db->dbprefix('user_master')." where md5(email) = '".md5($str)."'",FALSE);
			
		if($query->num_rows()>0 || $query->num_rows()>0 ){
			return 1;
		}else{
			
			return 0;
		}
	}
		function importcsv_orig()
	{
		
			if($_FILES['csv']['size']>0 && !empty($_FILES['csv']['name']))
			{			
					if (($handle = fopen($_FILES['csv']['tmp_name'], "r")) !== FALSE) {
					
					
					
						$data = fgetcsv($handle,1000,",","'");
						
											
						$flag = true;
						if($data[0]!=""){
						
        						if(count($data)=='12') {
        							
							$arr123 = '';		
						  $i=2; do {
						   	if($flag) { $flag = false; continue; }
							$checkbeername = $this->bar_name_address(trim($data[4]),preg_replace('/[^A-Za-z0-9\- ]/', '', trim($data[1])));
							//$checkbeeremail = $this->bar_email(preg_replace('/[^A-Za-z0-9\- ]/', '', trim($data[2])));
							 $slug=getBarSlug(preg_replace('/[^A-Za-z0-9\- ]/', '', trim($data[1])));	
							
						if($checkbeername==0 )
						{
						   		   
        							//echo $i;
									
            						$arr=array(
										'bar_title'=>preg_replace('/[^A-Za-z0-9\- ]/', '', trim($data[1])),
										//'owner_name'=>trim($data[1]),
										'phone'=>trim($data[2]),
										'email'=>trim($data[3]),
										'address'=>trim($data[4]),
										//'bar_desc'=>trim($data[4]),
										'city'=>trim($data[5]),
										'state'=>trim($data[6]),
										'zipcode'=>trim($data[7]),
										'website'=>trim($data[8]),
										'bar_meta_title'=>trim($data[9]),
										'bar_meta_description'=>trim($data[10]),
										'bar_meta_keyword'=>trim($data[11]),
										'bar_slug'=>$slug,
										'status'=>'Active',
										'bar_type'=>'half_mug',
										'date_added'=>date('Y-m-d H:i:s'),
										);
										
										
										
										  	$this->db->insert('bars',$arr);	
										
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
							
							redirect('bar/list_bar/half_mug/'.$limit.'/'.$offset.'/'.$result.'/'.base64_encode($arr123));	
				   							}
										else {
								
									$msg = "csv_not_valid";
								redirect('bar/import_bar/'.$msg);	
									//die;	
								}
								}
					
   							
					}
			}
		
	}
	
	 function importcsv()
	{
		         ini_set('memory_limit', '2048M');
			//require_once APPPATH.'excel_reader2.php';
			require_once(base_path()."/application/excel_reader2.php");
			//$data = new Spreadsheet_Excel_Reader(base_path()."/application/example11.xls");
			$data = new Spreadsheet_Excel_Reader($_FILES['csv']['tmp_name']);
				$arr123 = 0;
			
			
		   
			if($data->sheets[0]['numCols']==12){
				
for($i=0;$i<count($data->sheets);$i++) // Loop to get all sheets in a file.
{
	
	
	
	if(isset($data->sheets[$i]['cells']) && count($data->sheets[$i]['cells'])>0) // checking sheet not empty
	{
		for($j=1;$j<=count($data->sheets[$i]['cells']);$j++) // loop used to get each row of the sheet
		{
			//$checkbeername = 0;
			//$checkbeername = $this->beer_name_v((preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@@$data->sheets[$i]['cells'][$j][1]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][2]))),preg_replace('/[^A-Za-z0-9\- ]/', '', trim(@$data->sheets[$i]['cells'][$j][3])),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][4]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][5]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][6]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][7]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][8]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][9]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][10]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][11]))));
			
			//$checkbeername = $this->beer_name_v(@$data->sheets[$i]['cells'][$j][1],@$data->sheets[$i]['cells'][$j][2],@$data->sheets[$i]['cells'][$j][3],@$data->sheets[$i]['cells'][$j][4],@$data->sheets[$i]['cells'][$j][5],@$data->sheets[$i]['cells'][$j][6],@$data->sheets[$i]['cells'][$j][7],@$data->sheets[$i]['cells'][$j][8],@$data->sheets[$i]['cells'][$j][9],@$data->sheets[$i]['cells'][$j][10],@$data->sheets[$i]['cells'][$j][11]);
			
			$checkbeername = $this->bar_name_address(trim(@$data->sheets[$i]['cells'][$j][5]),trim(@$data->sheets[$i]['cells'][$j][2]));
							 $slug=getBarSlug(preg_replace('/[^A-Za-z0-9\- ]/', '', trim(@$data->sheets[$i]['cells'][$j][2])));
			$getlat = getCoordinatesFromAddress(trim(@$data->sheets[$i]['cells'][$j][5]),trim(@$data->sheets[$i]['cells'][$j][6]),trim(@$data->sheets[$i]['cells'][$j][7]));		
						if($checkbeername==0 && isset($data->sheets[$i]['cells'][$j][2]))
						{
							
			$arr=array(
			
										'bar_title'=>isset($data->sheets[$i]['cells'][$j][2]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][2])):'' ,
										'phone'=>isset($data->sheets[$i]['cells'][$j][3]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][3])):'' ,
										'email'=>isset($data->sheets[$i]['cells'][$j][4]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][4])):'' ,
										'address'=>isset($data->sheets[$i]['cells'][$j][5]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][5])):'' ,
										'city'=>isset($data->sheets[$i]['cells'][$j][6]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][6])):'' ,
										'state'=>isset($data->sheets[$i]['cells'][$j][7]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][7])):'' ,
										'zipcode'=> isset($data->sheets[$i]['cells'][$j][8]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][8])):'' ,
										'website'=>isset($data->sheets[$i]['cells'][$j][9]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][9])):'' ,
										'bar_meta_title'=>isset($data->sheets[$i]['cells'][$j][10]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][10])):'' ,
										'bar_meta_description'=>isset($data->sheets[$i]['cells'][$j][11]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][11])):'' ,
										'bar_meta_keyword'=>isset($data->sheets[$i]['cells'][$j][12]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][12])):'' ,
										'bar_slug'=>$slug,
										'linkurl'=>'http://test.americanbars.com/bar/details/'.$slug,
										'status'=>'Active',
										'lat' => $getlat['lat'],
										'lang' => $getlat['lng'],
										'bar_type'=>'half_mug',
										'date_added'=>date('Y-m-d H:i:s'),
								
										);
								
								
				
			$this->db->insert('bars',$arr,FALSE);
			
			
			}
			else if(isset($data->sheets[$i]['cells'][$j][2]))
			//else
							{
								 $arr123 .= $j.'*';
							}

		}

							$result="Successfully";	
							$msg="Import Successfully";	
							$limit=20;
							$offset=0;
							redirect('bar/list_bar/half_mug/'.$limit.'/'.$offset.'/'.$result.'/'.base64_encode($arr123).'/'.base64_encode($data->sheets[0]['numRows']));

	}
  
  } 
}

else {
		//$msg = "xls_not_valid";
		$msg = "xls_not_valid-".$data->sheets[0]['numCols']."";
								redirect('bar/import_bar/'.$msg);	
	
}
		
	}

	function getallbar_100($bars_id='')
	{
		$this->db->select('*');
		$this->db->from('bars');
		$this->db->where('status','active');
		//$this->db->where('is_deleted','no');
		$this->db->order_by('bar_id','desc');
		$this->db->limit(3000);
		$query = $this->db->get();
		
		
		if ($query->num_rows() > 0) {
			return $query->result();
	}
		return 0;
	}
	
	function getbaresult($bar_type,$option,$keyword)
	{
	
	   $keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
	   
	   $this->db->select('bar_id as `Customer #`');
	   $this->db->select('linkurl as `Bar Detail Link`, bar_title as `Bar Name`,  phone as `Phone`, email as `Email`, address as `Street Address`, city as `City`, state as `State`, zipcode as `Zipcode`, website as `URL`, bar_meta_title as `Title Tags`, bar_meta_description as `Meta Description`, bar_meta_keyword as `Keywords`');
		$this->db->from('bars');
		
		if($bar_type !="all")
		{
			$this->db->where("bar_type",$bar_type);
		}
		
		if($option=="bar_title")
		{
				   $this->db->like("bar_title",$keyword,'after');
				
		}
		if($option=="owner_name")
		{
				   $this->db->like("owner_name",$keyword,'after');
				   
		}
		
		if($option=="city")
		{
				   $this->db->like("city",$keyword,'after');
				   
				
		}
		
		
		if($option=="state")
		{
				   $this->db->like("state",$keyword,'after');
				   
				
				
		}
		
		if($option=="email")
		{
				   $this->db->like("email",$keyword,'after');
				   
				
		}
		
		if($option=="zipcode")
		{
		    $this->db->like("zipcode",$keyword,'after');
		}
		
		if($option=="phone")
		{
		 $this->db->like("phone",$keyword,'after');
		   
		}
		//	$this->db->where("bar_id >",62704);
		$this->db->order_by("bar_id", "desc"); 
		$query = $this->db->get();
		
		
		return $query;
	
	}

    function getBarReportCount()
	{
	// return $this->db->count_all('bars');
	
	    $this->db->select('*,report.status');
		$this->db->from('report');
		$this->db->join('bars','bars.bar_id=report.bar_id','left');
		$this->db->join('user_master','user_master.user_id=report.user_id','left');
		$this->db->order_by('report_id','desc');
		$qry = $this->db->get();
		return $qry->num_rows();
	}
	
	
	function getBarReport($offset=0, $limit=0,$bar_type = '')
	{
		
	    $this->db->select('*,report.status');
		$this->db->from('report');
		$this->db->join('bars','bars.bar_id=report.bar_id','left');
		$this->db->join('user_master','user_master.user_id=report.user_id','left');
		
		$this->db->limit($limit,$offset);
		$this->db->order_by('report_id','desc');
		$qry = $this->db->get();

		     
	    if ($qry->num_rows() > 0) {
			return $qry->result();
		}
		return '';
	}
	
	function get_total_search_bar_report_count($keyword)
	{
		$en = '';
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('*,report.status');
		$this->db->from('report');
		$this->db->join('bars','bars.bar_id=report.bar_id','left');
		$this->db->join('user_master','user_master.user_id=report.user_id','left');
		
		$en.="`sss_report`.`status` like ('".$keyword."%') OR `sss_bars`.`bar_title` like ('".$keyword."%') OR `sss_user_master`.`first_name` like ('".$keyword."%') OR `sss_user_master`.`last_name` like ('".$keyword."%') OR";
		$this->db->where('('.substr($en, 0 ,-3).')')  ;	

		$this->db->order_by('report_id','desc');
		
		$query = $this->db->get();
		
		
		return $query->num_rows();
	}
	
	
	// Use :This function use for get city detail by filter and limit and offset.
	// Param :offset,limit,option,keyword
	// Return :array of object
	
	function get_search_bar_report_result($keyword,$offset, $limit)
	{
		$en = '';
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('*,report.status');
		$this->db->from('report');
		$this->db->join('bars','bars.bar_id=report.bar_id','left');
		$this->db->join('user_master','user_master.user_id=report.user_id','left');
		
		$en.="`sss_report`.`status` like ('".$keyword."%') OR `sss_bars`.`bar_title` like ('".$keyword."%') OR `sss_user_master`.`first_name` like ('".$keyword."%') OR `sss_user_master`.`last_name` like ('".$keyword."%') OR";
		$this->db->where('('.substr($en, 0 ,-3).')')  ;	
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
	
	function get_taxi_company_report($id)
	{
		
		$this->db->select('*,report_taxi.status');
		$this->db->from('report_taxi');
		$this->db->join('taxi_directory','report_taxi.taxi_id=taxi_directory.taxi_id','left');
		$this->db->join('user_master','user_master.user_id=report_taxi.user_id','left');
		
		$this->db->where('report_id',$id)  ;	
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			
			return $query->row_array();
		}
		return 0;
	}
	
	 function getTaxiReportCount()
	{
	// return $this->db->count_all('bars');
	
	    $this->db->select('*,report_taxi.status');
		$this->db->from('report_taxi');
		$this->db->join('taxi_directory','report_taxi.taxi_id=taxi_directory.taxi_id','left');
		$this->db->join('user_master','user_master.user_id=report_taxi.user_id','left');
		$this->db->order_by('report_id','desc');
		$qry = $this->db->get();
		return $qry->num_rows();
	}
	
	
	function getTaxiReport($offset=0, $limit=0,$bar_type = '')
	{
		
	    $this->db->select('*,report_taxi.status');
		$this->db->from('report_taxi');
		$this->db->join('taxi_directory','report_taxi.taxi_id=taxi_directory.taxi_id','left');
		$this->db->join('user_master','user_master.user_id=report_taxi.user_id','left');
		
		$this->db->limit($limit,$offset);
		$this->db->order_by('report_id','desc');
		$qry = $this->db->get();

		     
	    if ($qry->num_rows() > 0) {
			return $qry->result();
		}
		return '';
	}
	
	function get_total_search_taxi_report_count($keyword)
	{
		$en = '';
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('*,report_taxi.status');
		$this->db->from('report_taxi');
		$this->db->join('taxi_directory','report_taxi.taxi_id=taxi_directory.taxi_id','left');
		$this->db->join('user_master','user_master.user_id=report_taxi.user_id','left');
		
		$en.="`sss_report_taxi`.`status` like ('".$keyword."%') OR `sss_taxi_directory`.`taxi_company` like ('".$keyword."%') OR `sss_user_master`.`first_name` like ('".$keyword."%') OR `sss_user_master`.`last_name` like ('".$keyword."%') OR";
		$this->db->where('('.substr($en, 0 ,-3).')')  ;	

		$this->db->order_by('report_id','desc');
		
		$query = $this->db->get();
		
		
		return $query->num_rows();
	}
	
	
	// Use :This function use for get city detail by filter and limit and offset.
	// Param :offset,limit,option,keyword
	// Return :array of object
	
	function get_search_taxi_report_result($keyword,$offset, $limit)
	{
		$en = '';
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('*,report_taxi.status');
		$this->db->from('report_taxi');
		$this->db->join('taxi_directory','report_taxi.taxi_id=taxi_directory.taxi_id','left');
		$this->db->join('user_master','user_master.user_id=report_taxi.user_id','left');
		
		$en.="`sss_report_taxi`.`status` like ('".$keyword."%') OR `sss_taxi_directory`.`taxi_company` like ('".$keyword."%') OR `sss_user_master`.`first_name` like ('".$keyword."%') OR `sss_user_master`.`last_name` like ('".$keyword."%') OR";
		$this->db->where('('.substr($en, 0 ,-3).')')  ;	
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
	
	function get_taxi_report($id)
	{
		
		$this->db->select('*,report_taxi.status');
		$this->db->from('report_taxi');
		$this->db->join('taxi_directory','report_taxi.taxi_id=taxi_directory.taxi_id','left');
		$this->db->join('user_master','user_master.user_id=report_taxi.user_id','left');
		
		
		$this->db->where('report_id',$id)  ;	
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			
			return $query->row_array();
		}
		return 0;
	}
function gersuggestbar($id)
	{
	// return $this->db->count_all('bars');
	
	    $this->db->select('*,report.status as status');
		$this->db->from('report');
		$this->db->join('bars','report.bar_id=bars.bar_id','left');
		$this->db->join('user_master','user_master.user_id=report.user_id','left');
		$this->db->where('report.report_id',$id);
		$qry = $this->db->get();
		return $qry->row_array();
	}
	
	function bar_hours_update($bar_id)
	{
		$datatick['days']=$this->input->post('days');
		$datatick['hour_from']=$this->input->post('hour_from');
		$datatick['hour_to']=$this->input->post('hour_to');
		$datatick['price']=$this->input->post('price');
		$datatick['speciality']=$this->input->post('speciality');
		$datatick['bar_hour_id']=$this->input->post('bar_hour_id');
		
		
		//echo 
		 if( isset( $datatick['days'] ) && is_array( $datatick['days'] ) ){
			foreach( $datatick['days'] as $key => $each ){
				
					$d = '';
					if($datatick['days'][$key]=="Monday")
					{
						$d = 1;
					}
					if($datatick['days'][$key]=="Tuesday")
					{
						$d = 2;
					}
					if($datatick['days'][$key]=="Wednesday")
					{
						$d = 3;
					}
					if($datatick['days'][$key]=="Thursday")
					{
						$d = 4;
					}
					if($datatick['days'][$key]=="Friday")
					{
						$d = 5;
					}
					if($datatick['days'][$key]=="Saturday")
					{
						$d = 6;
					}
					if($datatick['days'][$key]=="Sunday")
					{
						$d = 7;
					}
				if(isset($datatick['bar_hour_id'][$key]) && $datatick['bar_hour_id'][$key]!=''){
					
					$dataticket=array(
					'days'=>$datatick['days'][$key],
				    'hour_from' => $datatick['hour_from'][$key],
				    'bar_id' => $bar_id,
				    'day' => $d,
				    'hour_to' => $datatick['hour_to'][$key],
				     'price' =>$datatick['price'][$key],
				     'speciality' => $datatick['speciality'][$key],
					);
					$this->db->where('bar_hour_id',$datatick['bar_hour_id'][$key]);
					$this->db->update('bar_special_hours',$dataticket);
				}else{
				
					$dataticket=array(
					'days'=>$datatick['days'][$key],
				    'hour_from' => $datatick['hour_from'][$key],
				    'hour_to' => $datatick['hour_to'][$key],
				    'bar_id' => $bar_id,
				    'day' => $d,
				     'price' =>$datatick['price'][$key],
				     'speciality' => $datatick['speciality'][$key],
					);
					$this->db->insert('bar_special_hours',$dataticket);	
				}
			}
		 }
	}

 function get_bar_hour($bar_id)
	{
		$this->db->select("*");
        $this->db->from("bar_special_hours");
		$this->db->where('bar_id',$bar_id);
		$this->db->order_by('day','asc');
		//$this->db->order_by('days', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $query =  $this->db->get();
		//echo $this->db->last_query();
       
		// die;
		if($query->num_rows()>0)
		{
			 return $query->result();
		}
		 return '';
	}
	
	function bar_title_unique_suggest($str)
	{
		
			$query = $this->db->query("select bar_title from ".$this->db->dbprefix('bars')." where  address='".addslashes($this->input->post('address'))."' and  bar_title = '".addslashes($str)."'");
	     
		
		if($query->num_rows()>0){
			
			return FALSE;
		}else{
			if($this->input->post('suggest_bar_id'))
		{
			
			$query1 = $this->db->query("select bar_name from ".$this->db->dbprefix('suggest_bars')." where suggest_bar_id!=".$this->input->post('suggest_bar_id')." and  address='".addslashes($this->input->post('address'))."' and  bar_name = '".addslashes($str)."'");
		}
			else
			{
				$query1 = $this->db->query("select bar_name from ".$this->db->dbprefix('suggest_bars')." where  address='".addslashes($this->input->post('address'))."' and  bar_name = '".addslashes($str)."'");
			}		
			// echo $this->db->last_query();
		// die;
			if($query1->num_rows()>0){
			
			return FALSE;
			}
			return TRUE;
		}
	}
	
	function barCategory()
	{
		$this->db->select('*');
		$this->db->from('bar_category');
		$this->db->where('status','active');
		$this->db->order_by('bar_category_id','desc');
		$query = $this->db->get();
		
		if($query->num_rows()>0)
		{
			 return $query->result();
		}
		 return '';
	}	   
}
?>
