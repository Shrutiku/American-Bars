<?php
class Divebar_findout_model extends CI_Model {
	
    function divebar_findout_model()
    {
        parent::__construct();	
    }   
	
	
	// Use :This function use for Update admin Detail.
	// Param :Post Data
	// Return :'N/A'
	
	function divebar_findout_insert()
	{
		$this->load->library('upload');
		$data['divebar_findout_title'] = $this->input->post('divebar_findout_title');
		$data['status'] = $this->input->post('active');
		$data['date_added'] = date('Y-m-d H:i:s');		
		$this->db->insert('divebar_findout',$data);
		
		$id = $this->db->insert_id();
		$datatick['divebar_findout_description']=$this->input->post('divebar_findout_description');
		
		
		 if( isset( $datatick['divebar_findout_description'] ) && is_array( $datatick['divebar_findout_description'] ) ){
			foreach( $datatick['divebar_findout_description'] as $key => $each ){
				$company_image = '';
				
				if(isset($_FILES['photo_image']['name']) && count($_FILES['photo_image']['name'])>0)
		{
			if($_FILES['photo_image']['name'][$key] != "")
        {
		
                 
			$rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['photo_image']['name'][$key];
             $_FILES['userfile']['type']     =   $_FILES['photo_image']['type'][$key];
             $_FILES['userfile']['tmp_name'] =   $_FILES['photo_image']['tmp_name'][$key];
             $_FILES['userfile']['error']    =   $_FILES['photo_image']['error'][$key];
             $_FILES['userfile']['size']     =   $_FILES['photo_image']['size'][$key];
   
			$config['file_name'] = $rand.'bargallery';
			
            $config['upload_path'] = base_path().'upload/divebar_orig/';
			
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
		   	
			
			
			  resize(base_path().'upload/divebar_orig/'.$picture['file_name'],base_path().'upload/divebar_thumb/'.$picture['file_name'],400,250);
             
			
			$this->image_lib->clear();
             
			$company_image=$picture['file_name'];
			//$pg=array('bar_gallery_id'=>$gallery_id,'bar_image_name'=>$company_image);
			//$this->db->insert('bar_images',$pg);
			
			}
		
		}
				$dataticket=array(
				'divebar_findout_id'=>$id,
				'divebar_findout_description' => $datatick['divebar_findout_description'][$key],
				'image'=>$company_image,
			);
			
		
			$this->db->insert('divebar_findout_topic',$dataticket);
			}
		 }
	}
	
	function divebar_findout_update()
	{
		$this->load->library('upload');
		$preImg = $this->input->post('pre_img');
		$preImg1 = $this->input->post('pre_img1');
		$img_id=$this->input->post('image_id');
		
		$active=($this->input->post('active')=='active')?'Active':'inactive';
		$data = array(
			'divebar_findout_title'=>$this->input->post('divebar_findout_title'),
			'status' => $this->input->post('active'),
		);		
		$this->db->where('divebar_findout_id',$this->input->post('divebar_findout_id'));
		$this->db->update('divebar_findout',$data);
		
		$datatick['divebar_findout_description']=$this->input->post('divebar_findout_description');
		$datatick['image_id']=$this->input->post('image_id');
		
		
		//echo 
		 if( isset( $datatick['divebar_findout_description'] ) && is_array( $datatick['divebar_findout_description'] ) ){
			foreach( $datatick['divebar_findout_description'] as $key => $each ){
				
				
				
				if(isset($_FILES['photo_image']['name']) && count($_FILES['photo_image']['name'])>0)
		{
				$rand=rand(0,100000); 
			  if($_FILES['photo_image']['name'][$key] != "")
			  {
			  
             $_FILES['userfile']['name']     =   $_FILES['photo_image']['name'][$key];
             $_FILES['userfile']['type']     =   $_FILES['photo_image']['type'][$key];
             $_FILES['userfile']['tmp_name'] =   $_FILES['photo_image']['tmp_name'][$key];
             $_FILES['userfile']['error']    =   $_FILES['photo_image']['error'][$key];
             $_FILES['userfile']['size']     =   $_FILES['photo_image']['size'][$key];
   
			$config['file_name'] = $rand.'business';
			
             $config['upload_path'] = base_path().'upload/divebar_orig/';
			
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
				
			
		   
            
               resize(base_path().'upload/divebar_orig/'.$picture['file_name'],base_path().'upload/divebar_thumb/'.$picture['file_name'],400,250);
             
			
			$this->image_lib->clear();
		   
             
              $this->image_lib->clear();
		   
			$product_image=$picture['file_name'];
				
				
				if(isset($preImg1[$key]) && $preImg1[$key]!='')
						{
							if(file_exists(base_path().'upload/divebar_orig/'.$preImg1[$key]))
							{
								unlink(base_path().'upload/divebar_orig/'.$preImg1[$key]);
							}
							if(file_exists(base_path().'upload/divebar_thumb/'.$preImg1[$key]))
							{
								unlink(base_path().'upload/divebar_thumb/'.$preImg1[$key]);
							}
							
						}
				
				}
				else
				{
				
				  $product_image = $preImg1[$key];
				}
				
				
				
		
		}
				
				
				if(isset($datatick['image_id'][$key])){
					
					$dataticket=array(
					'divebar_findout_id'=>$this->input->post('divebar_findout_id'),
				     'divebar_findout_description' => $datatick['divebar_findout_description'][$key],
				     'image' => $product_image,
					);
					
				
					$this->db->where('divebar_findout_topic_id',$datatick['image_id'][$key]);
					$this->db->update('divebar_findout_topic',$dataticket);
				}else{
					$dataticket=array(
					'divebar_findout_id'=>$this->input->post('divebar_findout_id'),
				     'divebar_findout_description' => $datatick['divebar_findout_description'][$key],
				     'image' => $product_image,
					);
					$this->db->insert('divebar_findout_topic',$dataticket);
				}
			}
		 }
		
		
	}
	

	// Use :This function use for get one admin detail.
	// Param :Admin Id
	// Return :array
	function get_one_divebar_findout($id)
	{
		$query = $this->db->get_where('divebar_findout',array('divebar_findout_id'=>$id));
		return $query->row_array();
	}	
	
	// Use :This function use for count all admin.
	// Param :'N/A'
	// Return :Number
	
	function get_total_admin_count()
	{
		$query = $this->db->get_where('divebar_findout');
		return $query->num_rows();
	}
	
	// Use :This function use for get admin detail by limit and offset.
	// Param :offset,limit
	// Return :array of object
	
	function get_divebar_findout_result($offset = 0,$limit = 0)
	{
		    
		$this->db->select("*");
		$this->db->from("divebar_findout");
		$this->db->order_by("divebar_findout_id","DESC");
		$this->db->where(array("master_id"=>'0'));
		$this->db->limit($limit,$offset);
		
		$qry = $this->db->get();
		
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		
		return 0;
		
	}
	function get_divebar_findout($id=0) {
		$this->db->select('b.*,u.first_name,u.last_name');
		$this->db->from('divebar_findout b');
		$this->db->join("user_master u","b.user_id = u.user_id","left");
		$this->db->where(array('b.divebar_findout_id'=>$id));
		//$query = $this->db->get_where('forum',array('forum_id'=>$id));
		$query=$this->db->get();
		//echo $this->db->last_query(); die;
		return $query->row_array();
	
	}
	function get_list($topic_id,$master_id = 0){
		if($master_id == 0)
		{
			$main_id = $topic_id;
		}
		else
		{
			$main_id = $master_id;
		}
		
		$qry = $this->db->query("select * from ".$this->db->dbprefix('divebar_findout')." where 1=1 and (master_id = '".$main_id."')  order by 
		divebar_findout_id asc
		");
		//echo $this->db->last_query(); die;
		if ($qry->num_rows() > 0) {
			return $qry->result_array();
		}
		return 0;
	}
		function get_divebar_findout_count($master_id)
	{
		//echo $master_id; die;	
	 return $this->db->count_all('divebar_findout where master_id ='.$master_id);
		//echo $this->db->last_query(); die;
	}
	function reply_insert(){
	$data = array(
			'divebar_findout_description' =>  $this->input->post('description'),
			'master_id' => $this->input->post('message_id'),
			'admin_id'=>$this->input->post('admin_id'),
			'date_added' => date("Y-m-d H:i:s")
		);		
		//print_r($data); die;
		$this->db->insert('sss_divebar_findout',$data);
        
           //Log Entry    
           // $data_log = array("activity_name" => "LOG_REPLY_MESSAGE");
            //maintain_log($data_log); 
		
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
        						if(count($data)=='2') {
						   do {
						   	if($flag) { $flag = false; continue; }
							//$checkbeername = $this->beer_name(preg_replace('/[^A-Za-z0-9\- ]/', '', trim($data[0])));
						
						   		
        							
            						$arr=array(
										'divebar_findout_title'=>preg_replace('/[^A-Za-z0-9\- ]/', '', trim($data[0])),
										'divebar_findout_description'=>trim($data[1]),
										'status'=>'Active',
										'date_added'=>date('Y-m-d H:i:s'),
										);
										
										$this->db->insert('divebar_findout',$arr);	
										
   							}
							 while ($data = fgetcsv($handle,1000,",","'"));
							 $result="Success";			
							$msg="Import Successfully";	
							$limit=20;
							$offset=0;
							redirect('divebar_findout/list_divebar_findout/'.$limit.'/'.$offset.'/'.$result);	
				   							}
										else {
								
									$msg = "csv_not_valid";
								redirect('divebar_findout/import/'.$msg);	
									//die;	
								}
								}
					
   							
					}
			}
		
	}
	
	function divebardesc($id)
	{
		$query = $this->db->get_where('divebar_findout_topic',array('divebar_findout_id'=>$id));
		//echo $this->db->last_query();die;
		if($query->num_rows()>0){
		return $query->result();
		}
		return '';
	}
		
}
?>