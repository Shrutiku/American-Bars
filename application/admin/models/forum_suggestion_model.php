<?php
class Forum_suggestion_model extends CI_Model {
	
    function Forum_suggestion_model()
    {
        parent::__construct();	
    }   
	
	/*check unique forum_suggestion 
	 * param : forum_suggestionname, paitent_id(if in edit mode)
	 */
	function forum_suggestion_unique($str)
	{
		
		if($this->input->post('forum_id'))
		{
			$query = $this->db->get_where('forum_suggestion_directory',array('forum_id'=>$this->input->post('forum_id')));
			$res = $query->row_array();
			$email = $res['forum_suggestion_name'];
			
			$query = $this->db->query("select forum_suggestion_name from ".$this->db->dbprefix('forum_suggestion_directory')." where forum_suggestion_name = '$str' and forum_id!='".$this->input->post('forum_id')."'");
		}else{
			$query = $this->db->query("select forum_suggestion_name from ".$this->db->dbprefix('forum_suggestion_directory')." where forum_suggestion_name = '$str'");
		}
		if($query->num_rows()>0){
			
			return FALSE;
		}else{
			
			return TRUE;
		}
	}
	
	function forum_suggestion_name($str)
	{
		
		$query = $this->db->query("select forum_suggestion_name from ".$this->db->dbprefix('forum_suggestion_directory')." where md5(forum_suggestion_name) = '".md5($str)."' and is_deleted='no'",FALSE);
			
			
		if($query->num_rows()>0){
			
			return 1;
		}else{
			
			return 0;
		}
	}
	
	/* check unique email
	 * param : email, forum_suggestion id(if in edit mode)
	 */
	function forum_suggestion_email_unique($str)
	{
		if($this->input->post('forum_id'))
		{
			$query = $this->db->get_where('forum_suggestion_directory',array('forum_id'=>$this->input->post('forum_id')));
			$res = $query->row_array();
			$email = $res['email'];
			
			$query = $this->db->query("select email from ".$this->db->dbprefix('forum_suggestion_directory')." where email = '$str' and forum_id!='".$this->input->post('forum_id')."'");
		}else{
			$query = $this->db->query("select email from ".$this->db->dbprefix('forum_suggestion_directory')." where email = '$str'");
		}
		
		
		
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/* add forum_suggestion detail in db
	 * 
	 */	
	function forum_suggestion_insert($data_insert= array())
	{
		  $slug=getforum_suggestionSlug($data_insert["forum_suggestion_name"]);	
 	     $data_insert['forum_suggestion_slug'] = $slug;
		   unset($data_insert["offset"]);
		   unset($data_insert["limit"]);
		   unset($data_insert["option"]);
		   unset($data_insert["keyword"]);
		   unset($data_insert["search_option"]);
		   unset($data_insert["redirect_page"]);
		   unset($data_insert["search_keyword"]);
		   unset($data_insert["submit"]);
		$image_setting = image_setting();
		$forum_suggestion_image='';
		if($_FILES['file_up']['name']!='')
         {
            $forum_suggestion_image = $this->upload_forum_suggestion_image();  
			$data_insert["forum_suggestion_image"] = $forum_suggestion_image;
		} 
			
	
		
		unset($data_insert["prev_forum_suggestion_image"]);
		unset($data_insert["forum_id"]);
		  if($this->input->post("bars_id")>0 && is_numeric($this->input->post("bars_id")))
		{
			  $data_insert["bar_id"] = $this->input->post("bars_id");
			  
			  unset($data_insert["bars_id"]);
			  
		}
		 unset($data_insert["bars_id"]);
		 $data_insert["date_added"] = date('Y-m-d H:i:s');
		$this->db->insert('forum_suggestion_directory',$data_insert);
		
		$forum_id = mysql_insert_id();
		
		
		
		      //  email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
	
				//echo $str; die; 
	
		
		
		
		
	}


    ///////////// upload image////////////////////////////
    //////////////// upload bar logo//////////////////////////
	function upload_forum_suggestion_image()
	{
		$forum_suggestion_image = '';
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
			
            $config['upload_path'] = base_path().'upload/forum_suggestion_orig/';
			
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
				'source_image' => base_path().'upload/forum_suggestion_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/forum_suggestion_thumb/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => $image_setting->forum_suggestion_width,
				'height' => $image_setting->forum_suggestion_height,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$forum_suggestion_image =$picture['file_name'];
			
		
			if($this->input->post('prev_forum_suggestion_image')!='')
				{
					if(file_exists(base_path().'upload/forum_suggestion_thumb/'.$this->input->post('prev_forum_suggestion_image')))
					{
						$link=base_path().'upload/forum_suggestion_thumb/'.$this->input->post('prev_forum_suggestion_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/forum_suggestion_orig/'.$this->input->post('prev_forum_suggestion_image')))
					{
						$link2=base_path().'upload/forum_suggestion_orig/'.$this->input->post('prev_forum_suggestion_image');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('prev_forum_suggestion_image')!='')
				{
					$forum_suggestion_image=$this->input->post('prev_forum_suggestion_image');
				}
			}
			
			return $forum_suggestion_image;
	}
    ////// end of uplaod image////////////////////////////
	
	/* forum_suggestion update 
	 * 
	 */
	function forum_suggestion_update($data_insert = array())
	{
		$image_setting = image_setting();
		
		if($_FILES['file_up']['name']!='')
         {
		        $forum_suggestion_image = $this->upload_forum_suggestion_image();  
				   $data_insert["forum_suggestion_image"] = $forum_suggestion_image;
		 }	
		 $slug=getforum_suggestionSlug($data_insert["forum_suggestion_name"],$data_insert["forum_id"]);	
 	     $data_insert['forum_suggestion_slug'] = $slug;
		 
		 
		   unset($data_insert["offset"]);
		   unset($data_insert["limit"]);
		   unset($data_insert["option"]);
		   unset($data_insert["keyword"]);
		   unset($data_insert["search_option"]);
		   unset($data_insert["redirect_page"]);
		   unset($data_insert["search_keyword"]);
		   unset($data_insert["submit"]);
		   
		
		   unset($data_insert["prev_forum_suggestion_image"]);
		   unset($data_insert["forum_id"]);
		    if($this->input->post("bars_id")>0 && is_numeric($this->input->post("bars_id")))
		{
			  $data_insert["bar_id"] = $this->input->post("bars_id");
			  unset($data_insert["bars_id"]);
		}
		 
		    unset($data_insert["bars_id"]);
		
		$this->db->where('forum_id',$this->input->post('forum_id'));
		$this->db->update('forum_suggestion_directory',$data_insert);
       // echo $this->db->last_query(); die;
           
		
		
	}
	
	/* get forum_suggestion info
	 * param : forum_suggestion id
	 * 
	 */		
	function get_one_forum_suggestion($id)
	{
		
		$query = $this->db->get_where('forum',array('status'=>'pending','forum_id'=>$id));
		return $query->row_array();
	}	
	
	function get_topic($id=0) {
		$this->db->select('f.*,u.first_name,u.last_name');
		$this->db->from('forum f');
		$this->db->join("user_master u","f.user_id = u.user_id","left");
		$this->db->where(array('f.forum_id'=>$id));
		//$query = $this->db->get_where('forum',array('forum_id'=>$id));
		$query=$this->db->get();
		//echo $this->db->last_query(); die;
		return $query->row_array();
	
	}
	
	function getforum_suggestionByBarid($utype,$q){
		$this->db->like('forum_suggestion_name',$q);
		$this->db->select('forum_id,forum_suggestion_name');
		$this->db->from('forum_suggestion_directory');
		$this->db->where('forum_suggestion_directory.is_deleted','no'); 
		$this->db->where('status','active');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
	}
		return 0;
	}
	/* get total forum_suggestions
	 * param :doctor id
	 */
	function get_total_forum_suggestion_count()
	{
		
			$this->db->select('*');
			$this->db->from('forum');
			$this->db->where('forum.status','pending');
			$query= $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}
		return 0;
	}
	
	
	
	/* get forum_suggestion doctor wise
	 * param : doctor id
	 */
	function get_forum_suggestion_result($offset,$limit)
	{
		$this->db->select('f.*,c.forum_category_name');
		$this->db->from('forum f');
		$this->db->join('forum_category c','f.forum_category=c.forum_category_id');
	    $this->db->where(array("f.master_id"=>'0','f.status'=>'pending'));
	   //$this->db->order_by("forum_id","desc");
	 
	   $query = $this->db->get();
	    //echo $query = $this->db->last_query(); die;	     
	   	     if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
		
		
		
	}
	function get_poker_result($offset,$limit)
	{
		
	//	$this->db->where(array('doctor_id'=>$doctor_id));
		$this->db->order_by("forum_id","desc");
		$this->db->where('is_deleted','no');
		//$this->db->where('forum_suggestion_type','poker_expert');
		$this->db->where('forum_suggestion_type','poker_coach');
		$query = $this->db->get('forum_suggestion_directory',$limit,$offset);
		
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	/* search forum_suggestion doctor wise
	 * param:doctor id,option ,keyword
	 */	
	function get_total_search_forum_suggestion_count($option,$keyword)
	{$keyword=str_replace('-',' ',$keyword);
		 $keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
	   
		$this->db->select('f.*,c.forum_category_id,c.forum_category_name');
		$this->db->from('forum f');
		$this->db->join('forum_category c','f.forum_category=c.forum_category_id');
		  $this->db->where(array("f.master_id"=>'0','f.status'=>'pending'));
				if($option=="forum_name")
				{
				   $this->db->like("topic_name",$keyword,'after');
// 				   
				   // if(substr_count($keyword,' ')>=1)
			      // {
				     // $ex=explode(' ',$keyword);
// 				
					// foreach($ex as $val)
					// {
						// $this->db->like('topic_name',$val);
					// }	
				  // }
				}
			
				
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	/* search forum_suggestion doctor wise
	 * param:doctor id,option ,keyword
	 */		
	function get_search_forum_suggestion_result($option,$keyword,$offset, $limit,$bar_id = 0)
	{
		$keyword=str_replace('-',' ',$keyword);
		 $keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
	   
		$this->db->select('f.*,c.forum_category_id,c.forum_category_name');
		$this->db->from('forum f');
		$this->db->join('forum_category c','f.forum_category=c.forum_category_id');
		  $this->db->where(array("f.master_id"=>'0','f.status'=>'pending'));
				if($option=="forum_name")
				{
				   $this->db->like("topic_name",$keyword,'after');
				   
				   // if(substr_count($keyword,' ')>=1)
			      // {
				     // $ex=explode(' ',$keyword);
// 				
					// foreach($ex as $val)
					// {
						// $this->db->like('topic_name',$val);
					// }	
				  // }
				}
		$this->db->limit($limit,$offset);
		
		$query = $this->db->get();
		
		
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
	
	/* insert forum_suggestion attachment
	 * param :forum_suggestion id, file
	 */	
	
   function get_forum_suggestion_comment_result($id = 0)
   {
   
		$this->db->select("*");
		$this->db->from("forum_suggestion_comment c");
		$this->db->join("user_master u","c.user_id = u.user_id","LEFT");
		$this->db->where("c.master_comment_id","0");
		$this->db->where("c.forum_id",$id);
		
		$qry = $this->db->get();
		if($qry->num_rows()>0)
		{
		   return  $qry->result();
			
		}
		return 0;
   }
   
   function get_forum_suggestion_subcomment_result($id = 0)
   {
   
		$this->db->select("*");
		$this->db->from("forum_suggestion_comment c");
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
	  
	  $this->db->insert("forum_suggestion_comment",$data);
   }
  
   function forum_suggestionnew_insert() {
	
		$to_id_arr = $this->input->post('forum_id');
		
		
	  
		foreach($to_id_arr as $id){
			$data = array(
				'bar_id' => $this->input->post('bars_id'),
		     	'forum_id' =>  $id,
				'date' => date("Y-m-d")
			);
			$this->db->insert('forum_suggestion_bars',$data);
		}
	} 
    
	function get_one_forum_suggestion_by_name($name)
	{
		
		$query = $this->db->get_where('forum_suggestion_directory',array('forum_suggestion_name'=>$name));
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
							$checkforum_suggestionname = $this->forum_suggestion_name(preg_replace('/[^A-Za-z0-9\- ]/', '', trim($data[0])));
						
						if($checkforum_suggestionname==0)
						{
						   		
        							
            						$arr=array(
										'forum_suggestion_name'=>preg_replace('/[^A-Za-z0-9\- ]/', '', trim($data[0])),
										'forum_suggestion_type'=>trim($data[1]),
										'producer'=>trim($data[2]),
										'city_produced'=>trim($data[3]),
										'forum_suggestion_desc'=>trim($data[4]),
										'abv'=>trim($data[5]),
										'is_deleted'=>'no',
										'forum_suggestion_website'=>trim($data[6]),
										'status'=>'Active',
										'bar_id'=>0,
										'date_added'=>date('Y-m-d H:i:s'),
										);
										
										  	$this->db->insert('forum_suggestion_directory',$arr);	
										
								}
   							}
							 while ($data = fgetcsv($handle,1000,",","'"));
							 $result="Success";			
							$msg="Import Successfully";	
							$limit=20;
							$offset=0;
							redirect('forum_suggestion/list_forum_suggestion/'.$limit.'/0/'.$offset.'/'.$result);	
				   							}
										else {
								
									$msg = "csv_not_valid";
								redirect('forum_suggestion/import/'.$msg);	
									//die;	
								}
								}
					
   							
					}
			}
		
	}

    function getallforum_suggestion($bars_id)
	{
		$this->db->select('*');
		$this->db->from('forum_suggestion_directory');
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