<?php

class Video_model extends CI_Model {

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
		$this->db->insert('video', $form_data);
		
		if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
    function video_insert()
	{
	 
	  $data_array=array();
					  $data_insert["video_title"] = $this->input->post('video_title');
					  $data_insert["video_desc"] = $this->input->post('video_desc');
					  $data_insert["video_price"] = $this->input->post('video_price');
			
		$image_setting = image_setting();
		$video_image='';
		if($_FILES['file_up']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['file_up']['name'];
             $_FILES['userfile']['type']     =   $_FILES['file_up']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['file_up']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['file_up']['error'];
             $_FILES['userfile']['size']     =   $_FILES['file_up']['size'];
   
			$config['file_name'] = 'video'.$rand;
			
            $config['upload_path'] = base_path().'upload/video_image/';
			
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
				'source_image' => base_path().'upload/video_image/'.$picture['file_name'],
				'new_image' => base_path().'upload/video_image/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => '685',
				'height' => '320',
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$video_image=$picture['file_name'];
			
		
			if($this->input->post('pre_video_image')!='')
				{
					if(file_exists(base_path().'upload/user/'.$this->input->post('pre_video_image')))
					{
						$link=base_path().'upload/video_image/'.$this->input->post('pre_video_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/video_image/'.$this->input->post('pre_video_image')))
					{
						$link2=base_path().'upload/video_image/'.$this->input->post('pre_video_image');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('pre_video_image')!='')
				{
					$video_image=$this->input->post('pre_video_image');
				}
			}		  
				
				 $videoname="";
		 if($_FILES["file_up_video"]["name"]!="")
         {
             $this->load->library("upload");
             $rand=rand(0,100000); 
			  
             $_FILES["userfile"]["name"]     =   $_FILES["file_up_video"]["name"];
             $_FILES["userfile"]["type"]     =   $_FILES["file_up_video"]["type"];
             $_FILES["userfile"]["tmp_name"] =   $_FILES["file_up_video"]["tmp_name"];
             $_FILES["userfile"]["error"]    =   $_FILES["file_up_video"]["error"];
             $_FILES["userfile"]["size"]     =   $_FILES["file_up_video"]["size"];
   
		
			
			$config["file_name"] = $this->input->post('file_up_video').$rand;
		 
            $config['upload_path'