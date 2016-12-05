<?php

class Banner_pages_model extends CI_Model {
	
    function Banner_pages_model()
    {
        parent::__construct();	
    }   
	

	function banner_pages_update()
	{
		 $find_bar = '';
		  $find_trivia = '';
		 $find_beer = '';
		 $find_cocktail = '';
		 $find_suggestbar = '';
		 $find_contact_us = '';
		 $find_gallery = '';
		 $find_resource = '';
		 $find_media = '';
		 $find_forum = '';
		 $find_liquor = '';
		 $find_taxi = '';
		 $beer_directory_state = 0;
		 $liqur_directory_state = 0;
		 $resource_directory_state = 0;
		 $cocktail_directory_state = 0;
		 $suggest_bar_state = 0;
		 $contact_us_state = 0;
		 $photo_gallery_state = 0;
		 $media_state = 0;
		 $forum_state = 0;
		 $taxi_directory_state = 0;
		 $find_article = '';
		 $find_article_state = 0;
		 $find_trivia_state = 0;
		 
		  if($_FILES['find_trivia']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['find_trivia']['name'];
             $_FILES['userfile']['type']     =   $_FILES['find_trivia']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['find_trivia']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['find_trivia']['error'];
             $_FILES['userfile']['size']     =   $_FILES['find_trivia']['size'];
   
			$config['file_name'] = 'banner'.$rand;
			
            $config['upload_path'] = base_path().'upload/bar_pages_banner_orig/';
			
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
				
		   if ($_FILES["find_trivia"]["type"]!= "image/png" and $_FILES["find_trivia"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["find_trivia"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["find_trivia"]["type"] != "image/jpeg" and $_FILES["find_trivia"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/bar_pages_banner_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/bar_pages_banner/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => 1140,
				'height' => 410,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
				echo $error; die;
			}
			//echo $error;
			//die;
			$find_trivia =$picture['file_name'];
			$crop_from_top = abs ($this->input->post('pos_trivia')) ;
		
		
		$default_cover_width = 1140;
		$default_cover_height = 410;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$picture['file_name'];
        
		
		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$find_trivia;
		
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
			
		
			if($this->input->post('prev_trivia_banner_find')!='')
				{
					if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_trivia_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_trivia_banner_find');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_trivia_banner_find')))
					{
						$link2=base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_trivia_banner_find');
						unlink($link2);
					}
					
				}
				
				$find_trivia_state = $this->input->post('find_trivia_state');
			} else {
				$find_trivia_state = $this->input->post('find_trivia_state');
				if($this->input->post('prev_trivia_banner_find')!='')
				{
					
					
					if($this->input->post('pos_trivia')!=0)
					{
						
						
						if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_trivia_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_trivia_banner_find');
						unlink($link);
					}
					
					
						
						$this->load->library('upload');
						$crop_from_top = abs ($this->input->post('pos_trivia')) ;
						
						
		$default_cover_width = 1140;
		$default_cover_height = 410;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$this->input->post('prev_trivia_banner_find');

       
		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$this->input->post('prev_trivia_banner_find');
		 
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
		
					}
					
					$find_trivia =$this->input->post('prev_trivia_banner_find');
					 
				}
			}


		 if($_FILES['find_article']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['find_article']['name'];
             $_FILES['userfile']['type']     =   $_FILES['find_article']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['find_article']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['find_article']['error'];
             $_FILES['userfile']['size']     =   $_FILES['find_article']['size'];
   
			$config['file_name'] = 'banner'.$rand;
			
            $config['upload_path'] = base_path().'upload/bar_pages_banner_orig/';
			
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
				
		   if ($_FILES["find_article"]["type"]!= "image/png" and $_FILES["find_article"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["find_article"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["find_article"]["type"] != "image/jpeg" and $_FILES["find_article"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/bar_pages_banner_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/bar_pages_banner/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => 1140,
				'height' => 237,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
				echo $error; die;
			}
			//echo $error;
			//die;
			$find_article =$picture['file_name'];
			$crop_from_top = abs ($this->input->post('pos_article')) ;
		
		
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$picture['file_name'];
        
		
		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$find_article;
		
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
			
		
			if($this->input->post('prev_article_banner_find')!='')
				{
					if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_article_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_article_banner_find');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_article_banner_find')))
					{
						$link2=base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_article_banner_find');
						unlink($link2);
					}
					
				}
				
				$find_article_state = $this->input->post('find_article_state');
			} else {
				$find_article_state = $this->input->post('find_article_state');
				if($this->input->post('prev_article_banner_find')!='')
				{
					
					
					if($this->input->post('pos_article')!=0)
					{
						
						
						if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_article_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_article_banner_find');
						unlink($link);
					}
					
					
						
						$this->load->library('upload');
						$crop_from_top = abs ($this->input->post('pos_article')) ;
						
						
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$this->input->post('prev_article_banner_find');

       
		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$this->input->post('prev_article_banner_find');
		 
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
		
					}
					
					$find_article =$this->input->post('prev_article_banner_find');
					 
				}
			}
		 
		 if($_FILES['find_bar']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['find_bar']['name'];
             $_FILES['userfile']['type']     =   $_FILES['find_bar']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['find_bar']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['find_bar']['error'];
             $_FILES['userfile']['size']     =   $_FILES['find_bar']['size'];
   
			$config['file_name'] = 'banner'.$rand;
			
            $config['upload_path'] = base_path().'upload/bar_pages_banner_orig/';
			
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
				
		   if ($_FILES["find_bar"]["type"]!= "image/png" and $_FILES["find_bar"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["find_bar"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["find_bar"]["type"] != "image/jpeg" and $_FILES["find_bar"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/bar_pages_banner_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/bar_pages_banner/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => 1140,
				'height' => 237,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
				echo $error; die;
			}
			//echo $error;
			//die;
			$find_bar =$picture['file_name'];
			$crop_from_top = abs ($this->input->post('pos')) ;
		
		
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$picture['file_name'];
        
		
		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$find_bar;
		
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
			
		
			if($this->input->post('prev_bar_banner_find')!='')
				{
					if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_bar_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_bar_banner_find');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_bar_banner_find')))
					{
						$link2=base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_bar_banner_find');
						unlink($link2);
					}
					
				}
				
				$find_bar_state = $this->input->post('find_bar_state');
			} else {
				$find_bar_state = $this->input->post('find_bar_state');
				if($this->input->post('prev_bar_banner_find')!='')
				{
					
					
					if($this->input->post('pos')!=0)
					{
						
						
						if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_bar_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_bar_banner_find');
						unlink($link);
					}
					
					
						
						$this->load->library('upload');
						$crop_from_top = abs ($this->input->post('pos')) ;
						
						
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$this->input->post('prev_bar_banner_find');

       
		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$this->input->post('prev_bar_banner_find');
		 
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
		
					}
					
					$find_bar =$this->input->post('prev_bar_banner_find');
					 
				}
			}


        
		 
		  if($_FILES['find_beer']['name']!='')
         {
         	$beer_directory_state = $this->input->post('beer_directory_state');
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['find_beer']['name'];
             $_FILES['userfile']['type']     =   $_FILES['find_beer']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['find_beer']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['find_beer']['error'];
             $_FILES['userfile']['size']     =   $_FILES['find_beer']['size'];
   
			$config['file_name'] = 'banner'.$rand;
			
            $config['upload_path'] = base_path().'upload/bar_pages_banner_orig/';
			
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
				
		   if ($_FILES["find_beer"]["type"]!= "image/png" and $_FILES["find_beer"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["find_beer"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["find_beer"]["type"] != "image/jpeg" and $_FILES["find_beer"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/bar_pages_banner_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/bar_pages_banner/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => 1140,
				'height' => 237,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
				echo $error; die;
			}
			//echo $error;
			//die;
			$find_beer =$picture['file_name'];
			$crop_from_top = abs ($this->input->post('pos_beer')) ;
		
		
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$picture['file_name'];
        
		
		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$find_beer;
		
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
			
		
			if($this->input->post('prev_beer_banner_find')!='')
				{
					if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_beer_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_beer_banner_find');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_beer_banner_find')))
					{
						$link2=base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_beer_banner_find');
						unlink($link2);
					}
					
				}
			} else {
				
				if($this->input->post('prev_beer_banner_find')!='')
				{
					$beer_directory_state = $this->input->post('beer_directory_state');
					if($this->input->post('pos_beer')!=0)
					{
						
							if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_beer_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_beer_banner_find');
						unlink($link);
					}
						$this->load->library('upload');
						$crop_from_top = abs ($this->input->post('pos_beer')) ;
						
						
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$this->input->post('prev_beer_banner_find');

		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$this->input->post('prev_beer_banner_find');
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
					}
					
					$find_beer =$this->input->post('prev_beer_banner_find');
				}
			}


  if($_FILES['find_liquor']['name']!='')
         {
         	$liqur_directory_state = $this->input->post('liqur_directory_state');
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['find_liquor']['name'];
             $_FILES['userfile']['type']     =   $_FILES['find_liquor']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['find_liquor']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['find_liquor']['error'];
             $_FILES['userfile']['size']     =   $_FILES['find_liquor']['size'];
   
			$config['file_name'] = 'banner'.$rand;
			
            $config['upload_path'] = base_path().'upload/bar_pages_banner_orig/';
			
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
				
		   if ($_FILES["find_liquor"]["type"]!= "image/png" and $_FILES["find_liquor"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["find_liquor"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["find_liquor"]["type"] != "image/jpeg" and $_FILES["find_liquor"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/bar_pages_banner_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/bar_pages_banner/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => 1140,
				'height' => 237,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
				echo $error; die;
			}
			//echo $error;
			//die;
			$find_liquor =$picture['file_name'];
			$crop_from_top = abs ($this->input->post('pos_liquor')) ;
		
		
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$picture['file_name'];
        
		
		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$find_beer;
		
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
			
		
			if($this->input->post('prev_liquor_banner_find')!='')
				{
					if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_liquor_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_liquor_banner_find');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_liquor_banner_find')))
					{
						$link2=base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_liquor_banner_find');
						unlink($link2);
					}
					
				}
			} else {
				
				if($this->input->post('prev_liquor_banner_find')!='')
				{$liqur_directory_state = $this->input->post('liqur_directory_state');
					
					if($this->input->post('pos_liquor')!=0)
					{
						
							if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_liquor_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_liquor_banner_find');
						unlink($link);
					}
						$this->load->library('upload');
						$crop_from_top = abs ($this->input->post('pos_liquor')) ;
						
						
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$this->input->post('prev_liquor_banner_find');

		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$this->input->post('prev_liquor_banner_find');
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
					}
					
					$find_liquor =$this->input->post('prev_liquor_banner_find');
				}
			}

  if($_FILES['find_cocktail']['name']!='')
         {
         	$cocktail_directory_state = $this->input->post('cocktail_directory_state');
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['find_cocktail']['name'];
             $_FILES['userfile']['type']     =   $_FILES['find_cocktail']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['find_cocktail']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['find_cocktail']['error'];
             $_FILES['userfile']['size']     =   $_FILES['find_cocktail']['size'];
   
			$config['file_name'] = 'banner'.$rand;
			
            $config['upload_path'] = base_path().'upload/bar_pages_banner_orig/';
			
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
				
		   if ($_FILES["find_cocktail"]["type"]!= "image/png" and $_FILES["find_cocktail"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["find_cocktail"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["find_cocktail"]["type"] != "image/jpeg" and $_FILES["find_cocktail"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/bar_pages_banner_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/bar_pages_banner/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => 1140,
				'height' => 237,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
				echo $error; die;
			}
			//echo $error;
			//die;
			$find_cocktail =$picture['file_name'];
			$crop_from_top = abs ($this->input->post('pos_cocktail')) ;
		
		
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$picture['file_name'];
        
		
		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$find_cocktail;
		
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
			
		
			if($this->input->post('prev_cocktail_banner_find')!='')
				{
					if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_cocktail_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_cocktail_banner_find');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_cocktail_banner_find')))
					{
						$link2=base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_cocktail_banner_find');
						unlink($link2);
					}
					
				}
			} else {
				
				if($this->input->post('prev_cocktail_banner_find')!='')
				{
					$cocktail_directory_state = $this->input->post('cocktail_directory_state');
					if($this->input->post('pos_cocktail')!=0)
					{
						if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_cocktail_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_cocktail_banner_find');
						unlink($link);
					}
						$this->load->library('upload');
						$crop_from_top = abs ($this->input->post('pos_cocktail')) ;
						
						
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$this->input->post('prev_cocktail_banner_find');

		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$this->input->post('prev_cocktail_banner_find');
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
					}
					
					$find_cocktail =$this->input->post('prev_cocktail_banner_find');
				}
			}





        if($_FILES['find_suggest_bar']['name']!='')
         {
         	$suggest_bar_state = $this->input->post('suggest_bar_state');
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['find_suggest_bar']['name'];
             $_FILES['userfile']['type']     =   $_FILES['find_suggest_bar']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['find_suggest_bar']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['find_suggest_bar']['error'];
             $_FILES['userfile']['size']     =   $_FILES['find_suggest_bar']['size'];
   
			$config['file_name'] = 'banner'.$rand;
			
            $config['upload_path'] = base_path().'upload/bar_pages_banner_orig/';
			
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
				
		   if ($_FILES["find_suggest_bar"]["type"]!= "image/png" and $_FILES["find_suggest_bar"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["find_suggest_bar"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["find_suggest_bar"]["type"] != "image/jpeg" and $_FILES["find_suggest_bar"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/bar_pages_banner_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/bar_pages_banner/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => 1140,
				'height' => 237,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
				echo $error; die;
			}
			//echo $error;
			//die;
			$find_suggestbar =$picture['file_name'];
			$crop_from_top = abs ($this->input->post('pos_suggest_bar')) ;
		
		
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$picture['file_name'];
        
		
		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$find_suggestbar;
		
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
			
		
			if($this->input->post('prev_suggest_bar_banner_find')!='')
				{
					if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_suggest_bar_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_suggest_bar_banner_find');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_suggest_bar_banner_find')))
					{
						$link2=base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_suggest_bar_banner_find');
						unlink($link2);
					}
					
				}
			} else {
					
				if($this->input->post('prev_suggest_bar_banner_find')!='')
				{
					$suggest_bar_state = $this->input->post('suggest_bar_state');
					if($this->input->post('pos_suggest_bar')!=0)
					{
						
							if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_suggest_bar_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_suggest_bar_banner_find');
						unlink($link);
					}
						
						$this->load->library('upload');
						$crop_from_top = abs ($this->input->post('pos_suggest_bar')) ;
						
						
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$this->input->post('prev_suggest_bar_banner_find');

		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$this->input->post('prev_suggest_bar_banner_find');
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
					}
					
					$find_suggestbar =$this->input->post('prev_suggest_bar_banner_find');
				}
			}


 if($_FILES['find_contact_us']['name']!='')
         {
         	$contact_us_state = $this->input->post('contact_us_state');
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['find_contact_us']['name'];
             $_FILES['userfile']['type']     =   $_FILES['find_contact_us']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['find_contact_us']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['find_contact_us']['error'];
             $_FILES['userfile']['size']     =   $_FILES['find_contact_us']['size'];
   
			$config['file_name'] = 'banner'.$rand;
			
            $config['upload_path'] = base_path().'upload/bar_pages_banner_orig/';
			
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
				
		   if ($_FILES["find_contact_us"]["type"]!= "image/png" and $_FILES["find_contact_us"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["find_contact_us"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["find_contact_us"]["type"] != "image/jpeg" and $_FILES["find_contact_us"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/bar_pages_banner_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/bar_pages_banner/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => 1140,
				'height' => 237,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
				echo $error; die;
			}
			//echo $error;
			//die;
			$find_contact_us =$picture['file_name'];
			$crop_from_top = abs ($this->input->post('pos_contact_us')) ;
		
		
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$picture['file_name'];
        
		
		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$find_contact_us;
		
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
			
		
			if($this->input->post('prev_contact_us_banner_find')!='')
				{
					if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_contact_us_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_contact_us_banner_find');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_contact_us_banner_find')))
					{
						$link2=base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_contact_us_banner_find');
						unlink($link2);
					}
					
				}
			} else {
				
				if($this->input->post('prev_contact_us_banner_find')!='')
				{
					$contact_us_state = $this->input->post('contact_us_state');
					if($this->input->post('pos_contact_us')!=0)
					{
							if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_contact_us_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_contact_us_banner_find');
						unlink($link);
					}
						
						$this->load->library('upload');
						$crop_from_top = abs ($this->input->post('pos_contact_us')) ;
						
						
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$this->input->post('prev_contact_us_banner_find');

		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$this->input->post('prev_contact_us_banner_find');
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
					}
					
					$find_contact_us =$this->input->post('prev_contact_us_banner_find');
				}
			}







 if($_FILES['find_gallery']['name']!='')
         {
         	$photo_gallery_state = $this->input->post('photo_gallery_state');
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['find_gallery']['name'];
             $_FILES['userfile']['type']     =   $_FILES['find_gallery']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['find_gallery']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['find_gallery']['error'];
             $_FILES['userfile']['size']     =   $_FILES['find_gallery']['size'];
   
			$config['file_name'] = 'banner'.$rand;
			
            $config['upload_path'] = base_path().'upload/bar_pages_banner_orig/';
			
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
				
		   if ($_FILES["find_gallery"]["type"]!= "image/png" and $_FILES["find_gallery"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["find_gallery"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["find_gallery"]["type"] != "image/jpeg" and $_FILES["find_gallery"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/bar_pages_banner_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/bar_pages_banner/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => 1140,
				'height' => 237,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
				echo $error; die;
			}
			//echo $error;
			//die;
			$find_gallery =$picture['file_name'];
			$crop_from_top = abs ($this->input->post('pos_gallery')) ;
		
		
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$picture['file_name'];
        
		
		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$find_gallery;
		
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
			
		
			if($this->input->post('prev_gallery_banner_find')!='')
				{
					if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_gallery_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_gallery_banner_find');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_gallery_banner_find')))
					{
						$link2=base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_gallery_banner_find');
						unlink($link2);
					}
					
				}
			} else {
				
				if($this->input->post('prev_gallery_banner_find')!='')
				{
					$photo_gallery_state = $this->input->post('photo_gallery_state');
					if($this->input->post('pos_gallery')!=0)
					{
							if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_gallery_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_gallery_banner_find');
						unlink($link);
					}
						
						$this->load->library('upload');
						$crop_from_top = abs ($this->input->post('pos_gallery')) ;
						
						
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$this->input->post('prev_gallery_banner_find');

		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$this->input->post('prev_gallery_banner_find');
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
					}
					
					$find_gallery =$this->input->post('prev_gallery_banner_find');
				}
			}






if($_FILES['find_media']['name']!='')
         {
         	$media_state = $this->input->post('media_state');
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['find_media']['name'];
             $_FILES['userfile']['type']     =   $_FILES['find_media']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['find_media']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['find_media']['error'];
             $_FILES['userfile']['size']     =   $_FILES['find_media']['size'];
   
			$config['file_name'] = 'banner'.$rand;
			
            $config['upload_path'] = base_path().'upload/bar_pages_banner_orig/';
			
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
				
		   if ($_FILES["find_media"]["type"]!= "image/png" and $_FILES["find_media"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["find_media"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["find_media"]["type"] != "image/jpeg" and $_FILES["find_media"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/bar_pages_banner_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/bar_pages_banner/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => 1140,
				'height' => 237,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
				echo $error; die;
			}
			//echo $error;
			//die;
			$find_media =$picture['file_name'];
			$crop_from_top = abs ($this->input->post('pos_media')) ;
		
		
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$picture['file_name'];
        
		
		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$find_media;
		
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
			
		
			if($this->input->post('prev_media_banner_find')!='')
				{
					if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_media_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_media_banner_find');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_media_banner_find')))
					{
						$link2=base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_media_banner_find');
						unlink($link2);
					}
					
				}
			} else {
				
				if($this->input->post('prev_media_banner_find')!='')
				{$media_state = $this->input->post('media_state');
					
					if($this->input->post('pos_media')!=0)
					{
							if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_media_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_media_banner_find');
						unlink($link);
					}
						
						
						$this->load->library('upload');
						$crop_from_top = abs ($this->input->post('pos_media')) ;
						
						
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$this->input->post('prev_media_banner_find');

		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$this->input->post('prev_media_banner_find');
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
					}
					
					$find_media =$this->input->post('prev_media_banner_find');
				}
			}






		if($_FILES['find_forum']['name']!='')
         {
         	$forum_state = $this->input->post('forum_state');
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['find_forum']['name'];
             $_FILES['userfile']['type']     =   $_FILES['find_forum']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['find_forum']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['find_forum']['error'];
             $_FILES['userfile']['size']     =   $_FILES['find_forum']['size'];
   
			$config['file_name'] = 'banner'.$rand;
			
            $config['upload_path'] = base_path().'upload/bar_pages_banner_orig/';
			
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
				
		   if ($_FILES["find_forum"]["type"]!= "image/png" and $_FILES["find_forum"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["find_forum"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["find_forum"]["type"] != "image/jpeg" and $_FILES["find_forum"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/bar_pages_banner_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/bar_pages_banner/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => 1140,
				'height' => 237,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
				echo $error; die;
			}
			//echo $error;
			//die;
			$find_forum =$picture['file_name'];
			$crop_from_top = abs ($this->input->post('pos_forum')) ;
		
		
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$picture['file_name'];
        
		
		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$find_forum;
		
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
			
		
			if($this->input->post('prev_forum_banner_find')!='')
				{
					if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_forum_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_forum_banner_find');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_forum_banner_find')))
					{
						$link2=base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_forum_banner_find');
						unlink($link2);
					}
					
				}
			} else {
				
				if($this->input->post('prev_forum_banner_find')!='')
				{
					$forum_state = $this->input->post('forum_state');
					if($this->input->post('pos_forum')!=0)
					{
							if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_forum_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_forum_banner_find');
						unlink($link);
					}
						
						$this->load->library('upload');
						$crop_from_top = abs ($this->input->post('pos_forum')) ;
						
						
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$this->input->post('prev_forum_banner_find');

		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$this->input->post('prev_forum_banner_find');
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
					}
					
					$find_forum =$this->input->post('prev_forum_banner_find');
				}
			}
 
 
 
 
 
 
 
 
 
 
 
 
 
		if($_FILES['find_taxi']['name']!='')
         {
         	$taxi_directory_state = $this->input->post('taxi_directory_state');
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['find_taxi']['name'];
             $_FILES['userfile']['type']     =   $_FILES['find_taxi']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['find_taxi']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['find_taxi']['error'];
             $_FILES['userfile']['size']     =   $_FILES['find_taxi']['size'];
   
			$config['file_name'] = 'banner'.$rand;
			
            $config['upload_path'] = base_path().'upload/bar_pages_banner_orig/';
			
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
				
		   if ($_FILES["find_taxi"]["type"]!= "image/png" and $_FILES["find_taxi"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["find_taxi"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["find_taxi"]["type"] != "image/jpeg" and $_FILES["find_taxi"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/bar_pages_banner_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/bar_pages_banner/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => 1140,
				'height' => 237,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
				echo $error; die;
			}
			//echo $error;
			//die;
			$find_taxi =$picture['file_name'];
			$crop_from_top = abs ($this->input->post('pos_taxi')) ;
		
		
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$picture['file_name'];
        
		
		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$find_forum;
		
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
			
		
			if($this->input->post('prev_taxi_banner_find')!='')
				{
					if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_taxi_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_taxi_banner_find');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_taxi_banner_find')))
					{
						$link2=base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_taxi_banner_find');
						unlink($link2);
					}
					
				}
			} else {
			
				
				if($this->input->post('prev_taxi_banner_find')!='')
				{
					$taxi_directory_state = $this->input->post('taxi_directory_state');
					if($this->input->post('pos_taxi')!=0)
					{
							if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_taxi_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_taxi_banner_find');
						unlink($link);
					}
						
						$this->load->library('upload');
						$crop_from_top = abs ($this->input->post('pos_taxi')) ;
						
						
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$this->input->post('prev_taxi_banner_find');

		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$this->input->post('prev_taxi_banner_find');
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
					}
					
					$find_taxi =$this->input->post('prev_taxi_banner_find');
				}
			}




  if($_FILES['find_resource']['name']!='')
         {
         	$resource_directory_state = $this->input->post('resource_directory_state');
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['find_resource']['name'];
             $_FILES['userfile']['type']     =   $_FILES['find_resource']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['find_resource']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['find_resource']['error'];
             $_FILES['userfile']['size']     =   $_FILES['find_resource']['size'];
   
			$config['file_name'] = 'banner'.$rand;
			
            $config['upload_path'] = base_path().'upload/bar_pages_banner_orig/';
			
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
				
		   if ($_FILES["find_resource"]["type"]!= "image/png" and $_FILES["find_resource"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["find_resource"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["find_resource"]["type"] != "image/jpeg" and $_FILES["find_resource"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/bar_pages_banner_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/bar_pages_banner/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => 1140,
				'height' => 237,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
				echo $error; die;
			}
			//echo $error;
			//die;
			$find_resource =$picture['file_name'];
			$crop_from_top = abs ($this->input->post('pos_resource')) ;
		
		
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$picture['file_name'];
        
		
		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$find_beer;
		
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
			
		
			if($this->input->post('prev_resource_banner_find')!='')
				{
					if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_resource_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_resource_banner_find');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_resource_banner_find')))
					{
						$link2=base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_resource_banner_find');
						unlink($link2);
					}
					
				}
			} else {
				
				if($this->input->post('prev_resource_banner_find')!='')
				{
					$resource_directory_state = $this->input->post('resource_directory_state');
					if($this->input->post('pos_resource')!=0)
					{
						
				    if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_resource_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_resource_banner_find');
						unlink($link);
					}
					
						$this->load->library('upload');
						$crop_from_top = abs ($this->input->post('pos_resource')) ;
						
						
		$default_cover_width = 1140;
		$default_cover_height = 237;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$this->input->post('prev_resource_banner_find');

		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$this->input->post('prev_resource_banner_find');
		
		
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
					}
					
					$find_resource =$this->input->post('prev_resource_banner_find');
				}
			}
		   // $find_bar = '';
		 // $find_beer = '';
		 // $find_cocktail = '';
		 // $find_suggestbar = '';
		 // $find_contact_us = '';
		 // $find_gallery = '';
		 // $find_media = '';
		 // $find_forum = '';
		  $data = array(	
			'find_bar' => $find_bar,
			'taxi_directory' => $find_taxi,
		    'beer_directory'=> $find_beer,
		    'resource_directory'=> $find_resource,	
			'cocktail_directory' => $find_cocktail,	
			'suggest_bar' => $find_suggestbar,
			'contact_us' => $find_contact_us,
			'photo_gallery' => $find_gallery,
			'liqur_directory' => $find_liquor,
			'find_article_state' => $find_article_state,
			'article' => $find_article,
			'find_trivia_state' => $find_trivia_state,
			'trivia' => $find_trivia,
			
			'media' => $find_media,
			'forum' => $find_forum,
			'find_bar_state' => $find_bar_state,
				'beer_directory_state' => $beer_directory_state,
				'liqur_directory_state' => $liqur_directory_state,
				'resource_directory_state' => $resource_directory_state,
				'cocktail_directory_state' => $cocktail_directory_state,
				'suggest_bar_state' => $suggest_bar_state,
				'contact_us_state' => $contact_us_state,
				'photo_gallery_state' => $photo_gallery_state,
				'media_state' => $media_state,
				'forum_state' => $forum_state,
				'taxi_directory_state' => $taxi_directory_state,
		);
		
		// print_r($data);
		// die;
		
		  $this->db->where('banner_pages_id',$this->input->post('banner_pages_id'));
		  $this->db->update('banner_pages',$data);
          
	}

	
	function site_google_update()
	{
		
		$data = array(	
			'google_client_id' => $this->input->post('google_client_id'),
		    'google_url'=> $this->input->post('google_url'),	
			'google_login_enable' => $this->input->post('google_login_enable'),	
			'google_client_secret' => $this->input->post('google_client_secret'),
		);
		//print_r($data); die;
		$this->db->where('google_setting_id',$this->input->post('google_setting_id'));
		$this->db->update('google_setting',$data);
	
	}
	
	
	function site_facebook_update()
	{
		
		$data = array(	
			'facebook_setting_id' => $this->input->post('facebook_setting_id'),
		    'facebook_application_id'=> $this->input->post('facebook_application_id'),	
			'facebook_login_enable' => $this->input->post('facebook_login_enable'),	
			'facebook_access_token' => $this->input->post('facebook_access_token'),
			'facebook_api_key' => $this->input->post('facebook_api_key'),
		    'facebook_secret_key'=> $this->input->post('facebook_secret_key'),	
			'facebook_user_autopost' => $this->input->post('facebook_user_autopost'),	
			'facebook_wall_post' => $this->input->post('facebook_wall_post'),
			'facebook_url' => $this->input->post('facebook_url'),
		
		);
		//print_r($data); die;
		$this->db->where('facebook_setting_id',$this->input->post('facebook_setting_id'));
		$this->db->update('facebook_setting',$data);
	
	}
	
	function site_paypal_update()
	{
		
		$data = array(	
			'id' => $this->input->post('id'),
		    'site_status'=> $this->input->post('site_status'),
		    'client_id'=> $this->input->post('client_id'),	
			'secret_key' => $this->input->post('secret_key'),	
		);
		//print_r($data); die;
		$this->db->where('id',$this->input->post('id'));
		$this->db->update('paypal',$data);
	
	}
	
	function site_yahoo_update()
	{
		
		$data = array(	
			'yahoo_setting_id' => $this->input->post('yahoo_setting_id'),
		    'app_id'=> $this->input->post('app_id'),
		    'consumer_key'=> $this->input->post('consumer_key'),	
			'consumer_secret' => $this->input->post('consumer_secret'),
			'email_id' => $this->input->post('email_id'),
			'password' => $this->input->post('password'),	
		);
		//print_r($data); die;
		$this->db->where('yahoo_setting_id',$this->input->post('yahoo_setting_id'));
		$this->db->update('yahoo_setting',$data);
	
	}
	
}
?>