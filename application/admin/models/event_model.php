<?php
class Event_model extends CI_Model {
	
    function Event_model()
    {
        parent::__construct();	
    }   
	
	/*check unique event 
	 * param : eventname, paitent_id(if in edit mode)
	 */
	function event_unique($str)
	{
		if($this->input->post('event_id'))
		{
			$query = $this->db->get_where('events',array('event_id'=>$this->input->post('event_id')));
			$res = $query->row_array();
			$email = $res['event_title'];
			
			$query = $this->db->query("select event_title from ".$this->db->dbprefix('events')." where event_title = '$str' and event_id!='".$this->input->post('event_id')."'");
		}else{
			$query = $this->db->query("select event_title from ".$this->db->dbprefix('events')." where event_title = '$str'");
		}
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	
	/* add event detail in db
	 * 
	 */	
	function event_insert($data_insert= array())
	{
		
		  $res = getCoordinatesFromAddress($this->input->post('address'),$this->input->post('city'),$this->input->post('state'));
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
		
		
		
			if($this->input->post('event_category'))
		{
		$getcat = implode(",", $this->input->post('event_category'));  
		}
		else
		{
			$getcat = '';
		}
		 // if($_FILES["event_video"]["name"] != "")
		  // {
// 		
// 			
			// $types = explode(".",$_FILES["event_video"]["name"]);
// 			
			// if(isset($types[1]))
			// {
				// $type = $types[1];
			// }
			// else {
				// $type =  'mp4';
			// }
// 		
		  	  // $name = "event_video_".rand(0,100000).".".$type;
		  	  // $upload_path = base_path()."upload/event_video/".$name;
// 			  
			  // move_uploaded_file($_FILES["event_video"]["tmp_name"],$upload_path);
// 			  
			  // $data_insert['event_video']=$name;
		  // }	
	
		
		unset($data_insert["prev_event_image"]);
		unset($data_insert["eventdate"]);
		unset($data_insert["cntpro1"]);
		unset($data_insert["eventstarttime"]);
		unset($data_insert["eventendtime"]);
		unset($data_insert["event_id"]);
		unset($data_insert["date"]);
		unset($data_insert["prev_event_video"]);
		//$this->input->post("bars_id"); 
		
		  if($this->input->post("bars_id")>0 && is_numeric($this->input->post("bars_id")))
		{
			  $data_insert["bar_id"] = $this->input->post("bars_id");
			  
			  unset($data_insert["bars_id"]);
			  
		}
		 unset($data_insert["bars_id"]);
		   $data_insert['event_lat'] = $res['lat'];
			$data_insert['event_lng'] = $res['lng'];
		 $data_insert["event_category"] =$getcat;
		$this->db->insert('events',$data_insert);
		
		
		$event_id = mysql_insert_id();
		
		 $datatick['eventdate']=$this->input->post('eventdate');
		 $datatick['eventstarttime']=$this->input->post('eventstarttime');
		 $datatick['eventendtime']=$this->input->post('eventendtime');
		
		
		 if( isset( $datatick['eventdate'] ) && is_array( $datatick['eventdate'] ) ){
			foreach( $datatick['eventdate'] as $key => $each ){
			
				$dataticket=array(
				'eventdate'=> date('Y-m-d' ,strtotime($datatick['eventdate'][$key])),
				'eventstarttime'=>$datatick['eventstarttime'][$key],
				'eventendtime'=>$datatick['eventendtime'][$key],
				'event_id'=>$event_id,
			);
			
		
			$this->db->insert('event_time',$dataticket);
			}
		 }
		$inar = array('cat_id'=>$event_id,
		              'category'=>'event',
					  'date'=>date('Y-m-d H:i:s'));
		$this->db->insert('sitemap', $inar);
		
		
		 if(isset($_FILES['photo_image']['name']) && count($_FILES['photo_image']['name'])>0 && $this->input->post('event_upload_type')=='image')
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
   
			$config['file_name'] = $rand.'eventgallery';
			
            $config['upload_path'] = base_path().'upload/bar_eventgallery_orig/';
			
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
            $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				echo $error =  $this->upload->display_errors();
				die;   
		
			  } 
			   

			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   $gd_var='gd2';
              $this->image_lib->clear();
		   	
			resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/bar_eventgallery_thumb_big/'.$picture['file_name'],394,290);
             
			
			$this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/bar_eventgallery_thumb/'.$picture['file_name'],70,70);
           
		   $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/bar_eventgallery_thumb_250by150/'.$picture['file_name'],240,150);
           
			  $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/bar_eventgallery_thumb_304by201/'.$picture['file_name'],304,201);
			
			 $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_225/'.$picture['file_name'],225,225);
			 $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_840by720/'.$picture['file_name'],840,720);
			
			 $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_261/'.$picture['file_name'],261,261);
			
			
			 $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_140/'.$picture['file_name'],140,140);
			 $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_200/'.$picture['file_name'],200,200);
			
			 $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_600/'.$picture['file_name'],600,600);
			
			$company_image=$picture['file_name'];
			$pg=array('bar_eventgallery_id'=>$event_id,'event_image_name'=>$company_image);
			$this->db->insert('event_images',$pg);
			
			
			} 
			}
				
		
		}	
		
		      //  email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
	
				//echo $str; die; 
	
		
		
		
		
	}


    ///////////// upload image////////////////////////////
    //////////////// upload bar logo//////////////////////////
	function upload_event_image()
	{
		$event_image = '';
		$image_setting = image_setting();
		 if($_FILES['event_image']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['event_image']['name'];
             $_FILES['userfile']['type']     =   $_FILES['event_image']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['event_image']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['event_image']['error'];
             $_FILES['userfile']['size']     =   $_FILES['event_image']['size'];
   
			$config['file_name'] = 'event'.$rand;
			
            $config['upload_path'] = base_path().'upload/event_orig/';
			
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
				
				
		   if ($_FILES["event_image"]["type"]!= "image/png" and $_FILES["event_image"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["event_image"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["event_image"]["type"] != "image/jpeg" and $_FILES["event_image"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/event_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/event_thumb/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => $image_setting->event_width,
				'height' => $image_setting->event_height,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			//echo $error;
			//die;
			$event_image =$picture['file_name'];
			
		
			if($this->input->post('prev_event_image')!='')
				{
					if(file_exists(base_path().'upload/event_thumb/'.$this->input->post('prev_event_image')))
					{
						$link=base_path().'upload/event_thumb/'.$this->input->post('prev_event_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/event_orig/'.$this->input->post('prev_event_image')))
					{
						$link2=base_path().'upload/event_orig/'.$this->input->post('prev_event_image');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('prev_event_image')!='')
				{
					$event_image=$this->input->post('prev_event_image');
				}
			}
			
			return $event_image;
	}
    ////// end of uplaod image////////////////////////////
	
	/* event update 
	 * 
	 */
	function event_update($data_insert = array())
	{
		  $res = getCoordinatesFromAddress($this->input->post('address'),$this->input->post('city'),$this->input->post('state'));
		$this->load->library('upload');
		 $event_image = '';
		 $product_image = '';
		 $name = '';
		$image_setting = image_setting();
		
// 
           // if(isset($_FILES['event_video']) && $_FILES['event_video']["name"]!='')
		  // {
// 		
// 			
			// $types = explode(".",$_FILES["event_video"]["name"]);
// 			
			// if(isset($types[1]))
			// {
				// $type = $types[1];
			// }
			// else {
				// $type =  'mp4';
			// }
// 		
		  	  // $name = "event_video_".rand(0,100000).".".$type;
		  	  // $upload_path = base_path()."upload/event_video/".$name;
// 			  
			  // move_uploaded_file($_FILES["event_video"]["tmp_name"],$upload_path);
// 			  
			  // //$data_insert['event_video']=$name;
		  // }	
		  if($this->input->post('event_category'))
		{
		$getcat = implode(",", $this->input->post('event_category'));  
		}
		else
		{
			$getcat = '';
		}	
		  $data_insert = array('event_title'=>$this->input->post('event_title'),
		                       'event_desc'=>$this->input->post('event_desc'),
							 //  'start_date'=>$this->input->post('start_date'),
							  // 'end_date'=>$this->input->post('end_date'),
							 //  'start_time'=>$this->input->post('start_time'),
							  // 'end_time'=>$this->input->post('end_time'),
							   'address'=>$this->input->post('address'),
							     'event_lat' => $res['lat'],
							   'event_lng' => $res['lng'],
							   'city'=>$this->input->post('city'),
							   'state'=>$this->input->post('state'),
							   'venue'=>$this->input->post('venue'),
							   'phone'=>$this->input->post('phone'),
							   'zipcode'=>$this->input->post('zipcode'),
							   'bar_id'=>$this->input->post('bars_id'),
							   'event_image'=>$event_image,
							   'event_video'=>$name,
							   'event_video_link'=> $this->input->post('event_video_link'),
							   'is_power_boost_event'=>$this->input->post('is_power_boost_event'),
							    'event_meta_title'=>$this->input->post('event_meta_title'),
							     'event_meta_keyword'=>$this->input->post('event_meta_keyword'),
							      'event_meta_description'=>$this->input->post('event_meta_description'),
							   'status'=>$this->input->post('status'),
							   'organizer'=>$this->input->post('organizer'),
							   'admission'=>$this->input->post('admission'),
							   'website' => $this->input->post('website'),
							   // 'event_fb_link' => $this->input->post('event_fb_link'),
							   // 'event_twitter_link' => $this->input->post('event_twitter_link'),
							   // 'event_google_plus_link' => $this->input->post('event_google_plus_link'),
							   // 'event_pinterest_link' => $this->input->post('event_pinterest_link'),
							   'event_upload_type' => $this->input->post('event_upload_type'),
							   'buy_ticket' => $this->input->post('buy_ticket'),
							   'event_category'=>$getcat,
							   'is_deleted'=>'no',
							   'date_added'=>date('Y-m-d H:i:s'));
			
		 					   
		$this->db->where("event_id",$this->input->post('event_id'));
		$this->db->update('events',$data_insert);	
		
		 $datatick['eventdate']=$this->input->post('eventdate');
		 $datatick['eventstarttime']=$this->input->post('eventstarttime');
		 $datatick['eventendtime']=$this->input->post('eventendtime');
		 
		$datatick['image_id1']=$this->input->post('image_id1');
		
		
		//echo 
		
		 if( isset( $datatick['eventdate'] ) && is_array( $datatick['eventdate'] ) ){
			foreach( $datatick['eventdate'] as $key => $each ){
				
				
				if(isset($datatick['image_id1'][$key])){
					
					
							$dataticket=array(
				'eventdate'=> date('Y-m-d' ,strtotime($datatick['eventdate'][$key])),
				'eventstarttime'=>$datatick['eventstarttime'][$key],
				'eventendtime'=>$datatick['eventendtime'][$key],
			);
			
				
					$this->db->where('sss_event_time_id',$datatick['image_id1'][$key]);
					$this->db->update('sss_event_time',$dataticket);
				}else{
					
							$dataticket=array(
				'eventdate'=> date('Y-m-d' ,strtotime($datatick['eventdate'][$key])),
				'eventstarttime'=>$datatick['eventstarttime'][$key],
				'eventendtime'=>$datatick['eventendtime'][$key],
				'event_id' => $this->input->post('event_id'),
			);
			if($datatick['eventdate'][$key] && $datatick['eventstarttime'][$key] &&  $datatick['eventendtime'][$key] ){
				
				$this->db->insert('sss_event_time',$dataticket);
			}
				}
			}
		 }
		
		$img_id = $this->input->post('image_id');
		$preImg=$this->input->post('pre_img');
			/***********INsert Gallery************/
			
		
		if(isset($_FILES['photo_image']['name']) && count($_FILES['photo_image']['name'])>0  && $this->input->post('event_upload_type')=='image')
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
   
			$config['file_name'] = $rand.'eventgallery';
			
            $config['upload_path'] = base_path().'upload/bar_eventgallery_orig/';
			
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
				
			
		   
            
            resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/bar_eventgallery_thumb_big/'.$picture['file_name'],394,290);
             
			
			$this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/bar_eventgallery_thumb/'.$picture['file_name'],70,70);
           
			  $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/bar_eventgallery_thumb_250by150/'.$picture['file_name'],240,150);
           
			  $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/bar_eventgallery_thumb_304by201/'.$picture['file_name'],304,201);
            $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_225/'.$picture['file_name'],225,225);
			
			 $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_840by720/'.$picture['file_name'],840,720);
			
			 $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_261/'.$picture['file_name'],261,261);
			
			 $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_140/'.$picture['file_name'],140,140);
			
			 $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_200/'.$picture['file_name'],200,200);
			
			 $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_600/'.$picture['file_name'],600,600);
			
			$product_image=$picture['file_name'];
				
				
				if(isset($preImg[$key]) && $preImg[$key]!='')
				{
					if(file_exists(base_path().'upload/event_600/'.$preImg[$key]))
					{
						unlink(base_path().'upload/event_600/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/event_200/'.$preImg[$key]))
					{
						unlink(base_path().'upload/event_200/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/event_140/'.$preImg[$key]))
					{
						unlink(base_path().'upload/event_140/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/event_261/'.$preImg[$key]))
					{
						unlink(base_path().'upload/event_261/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/event_840by720/'.$preImg[$key]))
					{
						unlink(base_path().'upload/event_840by720/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/bar_eventgallery_orig/'.$preImg[$key]))
					{
						unlink(base_path().'upload/bar_eventgallery_orig/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/event_225/'.$preImg[$key]))
					{
						unlink(base_path().'upload/event_225/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/bar_eventgallery_thumb/'.$preImg[$key]))
					{
						unlink(base_path().'upload/bar_eventgallery_thumb/'.$preImg[$key]);
					}
					
					if(file_exists(base_path().'upload/bar_eventgallery_thumb_big/'.$preImg[$key]))
					{
						unlink(base_path().'upload/bar_eventgallery_thumb_big/'.$preImg[$key]);
					}
if(file_exists(base_path().'upload/bar_eventgallery_thumb_250by150/'.$preImg[$key]))
					{
						unlink(base_path().'upload/bar_eventgallery_thumb_250by150/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/bar_eventgallery_thumb_304by201/'.$preImg[$key]))
					{
						unlink(base_path().'upload/bar_eventgallery_thumb_304by201/'.$preImg[$key]);
					}
				}
				
				 }
				 else
				 {
// 				
				  $product_image = $preImg[$key];
				}
// 				
// 				echo 

               
				if($product_image!=''){
					
				$pg = array('bar_eventgallery_id'=>$this->input->post('event_id'),'event_image_name'=>$product_image);
			
			    
				//echo $img_id[$key];
				if($product_image!=''){
					
				if(isset($img_id[$key]) && $img_id[$key]>0){
					
					$this->db->where('event_image_id',$img_id[$key]);
					$this->db->update('event_images',$pg);
				}else{
					$this->db->insert('event_images',$pg);
				}
				}
				}
				
			} 
				
				}	   
       // echo $this->db->last_query(); die;
           
		
		
	}
	
	/* get event info
	 * param : event id
	 * 
	 */		
	function get_one_event($id)
	{
		$query = $this->db->get_where('events',array('event_id'=>$id));
		return $query->row_array();
	}	
	
	/* get total events
	 * param :doctor id
	 */
	function get_total_event_count($bar_id = 0)
	{
		//$this->db->where('is_deleted','no');
		$this->db->select("e.*,b.bar_id,b.bar_title,event_time.eventdate");
		$this->db->from("events e");
		$this->db->join("event_time",'event_time.event_id=e.event_id');
		$this->db->join("bars b","e.bar_id = b.bar_id","LEFT");
		if($bar_id > 0 && is_numeric($bar_id))
		{
			   
				$this->db->where('e.bar_id',$bar_id);
		}
		$this->db->where('e.is_deleted','no');
		//$this->db->where('event_time.eventdate >=',date('Y-m-d'));
		$this->db->order_by("event_time.eventdate","asc");
		$this->db->group_by("event_time.event_id");
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}
		return 0;
	}
	
	
	
	/* get event doctor wise
	 * param : doctor id
	 */
	function get_event_result($offset,$limit,$bar_id = 0)
	{
		
	// //	$this->db->where(array('doctor_id'=>$doctor_id));
		// $this->db->order_by("event_id","desc");
		// $this->db->where('is_deleted','no');
		// if($bar_id > 0 && is_numeric($bar_id))
		// {
// 			   
				// $this->db->where('bar_id',$bar_id);
		// }
		// $query = $this->db->get('events',$limit,$offset);
		
		$this->db->select("e.*,b.bar_id,b.bar_title,event_time.eventdate");
		$this->db->from("events e");
		$this->db->join("event_time",'event_time.event_id=e.event_id');
		$this->db->join("bars b","e.bar_id = b.bar_id","LEFT");
		if($bar_id > 0 && is_numeric($bar_id))
		{
				$this->db->where('e.bar_id',$bar_id);
		}
		$this->db->where('e.is_deleted','no');
		//$this->db->where('event_time.eventdate >=',date('Y-m-d'));
		$this->db->order_by("event_time.eventdate","asc");
		$this->db->group_by("event_time.event_id");
		$this->db->limit($limit,$offset);
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	
	/* search event doctor wise
	 * param:doctor id,option ,keyword
	 */	
	function get_total_search_event_count($option= '',$keyword= '',$date='',$bar_id = 0)
	{
		$keyword=str_replace('-',' ',$keyword);
		//$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('events.*');
		$this->db->from('events');
		$this->db->join('event_time','event_time.event_id=events.event_id','left');
		
		if($bar_id > 0 && is_numeric($bar_id))
		{
			$this->db->where("bar_id",$bar_id);
		}
			if($option=='event_title' && $keyword!='' && $keyword!='1V1')
		{
			$this->db->like('event_title',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('event_title',$val);
				// }	
			// }

		}
		
		 if($option=='city')
		{
			$this->db->like('city',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('city',$val);
				// }	
			// }

		}

       if($option=='zipcode')
		{
			$this->db->like('zipcode',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('state',$val);
				// }	
			// }

		}
		if($date!='1V1' && $date!='' && $date!='0')
		{
			$date = explode('to',$date);
			$start_date  = date("Y-m-d",strtotime($date[0]));
			$end_date= date("Y-m-d",strtotime($date[1]));
			$this->db->where('eventdate >=', $start_date);
			$this->db->where('eventdate <=', $end_date);
			//$this->db->where('eventdate',$event_date );
		}
		/*if($option=='phone_number')
		{
			$this->db->like('phone',$keyword);
		}
*/
       
		$this->db->group_by('event_time.event_id');
		$this->db->where('is_deleted','no');
		$query = $this->db->get();
		
		
		return $query->num_rows();
	}
	
	
	
	/* search event doctor wise
	 * param:doctor id,option ,keyword
	 */		
	function get_search_event_result($option='',$keyword='',$date='',$offset =0, $limit = 0,$bar_id = 0)
	{
		$keyword=str_replace('-',' ',$keyword);
		//$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('e.*,b.bar_id,b.bar_title, event_time.eventdate');
		$this->db->from('events e');
		$this->db->join('event_time','event_time.event_id=e.event_id','left');
		$this->db->join("bars b","e.bar_id = b.bar_id","LEFT");
		if($bar_id > 0 && is_numeric($bar_id))
		{
			$this->db->where("e.bar_id",$bar_id);
		}
		if($option=='event_title' && $keyword!='' && $keyword!='1V1')
		{
			$this->db->like('e.event_title',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('e.event_title',$val);
				// }	
			// }

		}
        
if($date!='1V1' && $date!='' && $date!='0')
		{
			
			$date = explode('to',$date);
			$start_date  = date("Y-m-d",strtotime($date[0]));
			$end_date= date("Y-m-d",strtotime($date[1]));
			$this->db->where('eventdate >=', $start_date);
			$this->db->where('eventdate <=', $end_date);
			//$this->db->where('eventdate',$event_date );
		}
      if($option=='city')
		{
			$this->db->like('e.city',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('e.city',$val);
				// }	
			// }

		}

       if($option=='zipcode')
		{
			$this->db->like('e.zipcode',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('e.state',$val);
				// }	
			// }

		}
		
		/*if($option=='phone_number')
		{
			$this->db->like('phone',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->or_like('phone',$val);
				}	
			}
		}	*/	
		$this->db->where('e.is_deleted','no');  
		//$this->db->where('event_time.eventdate >=', $start_date);
		$this->db->group_by('event_time.event_id');
		$this->db->order_by('event_time.eventdate','asc');
		$this->db->limit($limit,$offset);
		
		$query = $this->db->get();
		
		
	//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
	
	
	/* insert event attachment
	 * param :event id, file
	 */	
	
   function get_event_comment_result($id = 0)
   {
   
		$this->db->select("*");
		$this->db->from("event_comment c");
		$this->db->join("user_master u","c.user_id = u.user_id","LEFT");
		$this->db->where("c.master_comment_id","0");
		$this->db->where("c.event_id",$id);
		
		$qry = $this->db->get();
		if($qry->num_rows()>0)
		{
		   return  $qry->result();
			
		}
		return 0;
   }
   
   function get_event_subcomment_result($id = 0)
   {
		$this->db->select("*");
		$this->db->from("event_comment c");
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
	  
	  $this->db->insert("event_comment",$data);
   }
   
   function getImageEvent($id)
	{
		$query = $this->db->get_where('event_images',array('bar_eventgallery_id'=>$id));
		//echo $this->db->last_query();die;
		if($query->num_rows()>0){
		return $query->result();
		}
		return '';
	}
	
	function getEventtime($id)
	{
		$this->db->order_by('eventdate','asc'); 
		$query = $this->db->get_where('event_time',array('event_id'=>$id));
		//echo $this->db->last_query();die;
		if($query->num_rows()>0){
		return $query->result();
		}
		return '';
	}
	
	function getOneImageEvent($id)
	{
		$query = $this->db->get_where('event_images',array('event_image_id'=>$id));
		return $query->row();
	}
	
	function getOneTimeEvent($id)
	{
		$query = $this->db->get_where('event_time',array('sss_event_time_id'=>$id));
		return $query->row();
	}
	
	function getallbar()
	{
		$query = $this->db->get_where('bars',array('status'=>'active','is_deleted'=>'no','bar_type'=>'full_mug'));
		if($query->num_rows()>0){
		return $query->result();
		}
		return '';
	}
	
	function eventCategory()
	{
		$this->db->select('*');
		$this->db->from('event_category');
		$this->db->where('status','active');
		$this->db->order_by('event_category_id','desc');
		$query = $this->db->get();
		
		if($query->num_rows()>0)
		{
			 return $query->result();
		}
		 return '';
	}
}
?>