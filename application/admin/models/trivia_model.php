<?php
class Trivia_model extends CI_Model {
	
    function Trivia_model()
    {
        parent::__construct();	
    }   
	
	
	// Use :This function use for Update admin Detail.
	// Param :Post Data
	// Return :'N/A'
	
	function trivia_insert()
	{
		$data['question'] = $this->input->post('question');
		$data['question1'] = $this->input->post('question1');
		$data['question2'] = $this->input->post('question2');
		$data['question3'] = $this->input->post('question3');
		$data['question4'] = $this->input->post('question4');
		$data['status'] = $this->input->post('active');
		$data['answer'] = $this->input->post('answer');	
		$this->db->insert('trivia',$data);
	}
	
	function trivia_update()
	{
		$data = array(
			'question' => $this->input->post('question'),
			'question1' => $this->input->post('question1'),
			'question2' => $this->input->post('question2'),
			'question3' => $this->input->post('question3'),
			'question4' => $this->input->post('question4'),
			'status' => $this->input->post('active'),
			'answer' => $this->input->post('answer'),	
		);		
		$this->db->where('trivia_id',$this->input->post('trivia_id'));
		$this->db->update('trivia',$data);
		
		
	}
	

	// Use :This function use for get one admin detail.
	// Param :Admin Id
	// Return :array
	function get_one_trivia($id)
	{
		$query = $this->db->get_where('trivia',array('trivia_id'=>$id));
		return $query->row_array();
	}	
	
	// Use :This function use for count all admin.
	// Param :'N/A'
	// Return :Number
	
	function get_total_admin_count()
	{
		$query = $this->db->get_where('trivia');
		return $query->num_rows();
	}
	
	// Use :This function use for get admin detail by limit and offset.
	// Param :offset,limit
	// Return :array of object
	
	function get_trivia_result($offset = 0,$limit = 0)
	{
		    
		$this->db->select("*");
		$this->db->from("trivia");
		$this->db->order_by("trivia_id","DESC");
		$this->db->limit($limit,$offset);
		
		$qry = $this->db->get();
		
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		
		return 0;
		
	}
	function get_trivia($id=0) {
		$this->db->select('*');
		$this->db->from('trivia b');
		$query=$this->db->get();
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
		
		$qry = $this->db->query("select * from ".$this->db->dbprefix('trivia')." where 1=1 and (master_id = '".$main_id."')  order by 
		trivia_id asc
		");
		//echo $this->db->last_query(); die;
		if ($qry->num_rows() > 0) {
			return $qry->result_array();
		}
		return 0;
	}
		function get_trivia_count($master_id)
	{
		//echo $master_id; die;	
	 return $this->db->count_all('trivia where master_id ='.$master_id);
		//echo $this->db->last_query(); die;
	}
	function reply_insert(){
	$data = array(
			'trivia_description' =>  $this->input->post('description'),
			'master_id' => $this->input->post('message_id'),
			'admin_id'=>$this->input->post('admin_id'),
			'date_added' => date("Y-m-d H:i:s")
		);		
		//print_r($data); die;
		$this->db->insert('sss_trivia',$data);
        
           //Log Entry    
           // $data_log = array("activity_name" => "LOG_REPLY_MESSAGE");
            //maintain_log($data_log); 
		
	}
		
	
	function get_total_search_trivia_count($option,$keyword)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('*');
		$this->db->from('trivia');
		
			$this->db->like('question',$keyword,'after');
			

		$this->db->order_by('trivia_id','desc');
		
		$query = $this->db->get();
		
		
		return $query->num_rows();
	}
	
	
	// Use :This function use for get city detail by filter and limit and offset.
	// Param :offset,limit,option,keyword
	// Return :array of object
	
	function get_search_trivia_result($option,$keyword,$offset, $limit)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('*');
		$this->db->from('trivia');
		
			$this->db->like('question',$keyword,'after');
			

		$this->db->order_by('trivia_id','desc');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
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
			
		
			if($data->sheets[0]['numCols']==8){
for($i=0;$i<count($data->sheets);$i++) // Loop to get all sheets in a file.
{
	
	
	
	if(isset($data->sheets[$i]['cells']) && count($data->sheets[$i]['cells'])>0) // checking sheet not empty
	{
		//$data_c = array('number_new' => 1 );
	 //  $this->session->set_userdata($data_c);	
	   for($j=1;$j<=count($data->sheets[$i]['cells']);$j++) // loop used to get each row of the sheet
		{
			//$checkbeername = 0;
			//$checkbeername = $this->beer_name_v((preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@@$data->sheets[$i]['cells'][$j][1]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][2]))),preg_replace('/[^A-Za-z0-9\- ]/', '', trim(@$data->sheets[$i]['cells'][$j][3])),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][4]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][5]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][6]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][7]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][8]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][9]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][10]))),(preg_replace('/[^A-Za-z0-9\- ]/', '' , trim(@$data->sheets[$i]['cells'][$j][11]))));
			
						
							for($v=1;$v<=4;$v++)
							{
								if($j==1 || $this->session->userdata('number_new')==1)
								{
									
									$arr=array(
			                        
										'question'=>isset($data->sheets[$i]['cells'][$j][1]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][1])):'' ,
										'question1'=>isset($data->sheets[$i]['cells'][$j][2]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][2])):'' ,
										'question2'=>isset($data->sheets[$i]['cells'][$j][3]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][3])):'' ,
										'question3'=>isset($data->sheets[$i]['cells'][$j][4]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][4])):'' ,
										'question4'=>isset($data->sheets[$i]['cells'][$j][5]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][5])):'' ,
										'answer'=>1,
										'status'=>'active',
										);
										
										
										$data_c = array('number_new' => 2 );
	  								    $this->session->set_userdata($data_c);	
									    break;	
								}
								else if($this->session->userdata('number_new')==2)
								{
									
								
									
									$arr=array(
			                        
										'question'=>isset($data->sheets[$i]['cells'][$j][1]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][1])):'' ,
										'question2'=>isset($data->sheets[$i]['cells'][$j][2]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][2])):'' ,
										'question3'=>isset($data->sheets[$i]['cells'][$j][3]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][3])):'' ,
										'question4'=>isset($data->sheets[$i]['cells'][$j][4]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][4])):'' ,
										'question1'=>isset($data->sheets[$i]['cells'][$j][5]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][5])):'' ,
										'answer'=>2,
										'status'=>'active',
										);
										
									
										$data_c = array('number_new' => 3 );
	  								    $this->session->set_userdata($data_c);	
									    break;	
								}
								else if($this->session->userdata('number_new')==3)
								{
									$arr=array(
			                        
										'question'=>isset($data->sheets[$i]['cells'][$j][1]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][1])):'' ,
										'question3'=>isset($data->sheets[$i]['cells'][$j][2]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][2])):'' ,
										'question4'=>isset($data->sheets[$i]['cells'][$j][3]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][3])):'' ,
										'question1'=>isset($data->sheets[$i]['cells'][$j][4]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][4])):'' ,
										'question2'=>isset($data->sheets[$i]['cells'][$j][5]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][5])):'' ,
										'answer'=>3,
										'status'=>'active',
										);
										$data_c = array('number_new' => 4 );
	  								    $this->session->set_userdata($data_c);	
									    break;	
								}
								else if($this->session->userdata('number_new')==4)
								{
									$arr=array(
			                        
										'question'=>isset($data->sheets[$i]['cells'][$j][1]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][1])):'' ,
										'question4'=>isset($data->sheets[$i]['cells'][$j][2]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][2])):'' ,
										'question1'=>isset($data->sheets[$i]['cells'][$j][3]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][3])):'' ,
										'question2'=>isset($data->sheets[$i]['cells'][$j][4]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][4])):'' ,
										'question3'=>isset($data->sheets[$i]['cells'][$j][5]) ? utf8_encode(trim($data->sheets[$i]['cells'][$j][5])):'' ,
										'answer'=>4,
										'status'=>'active',
										);
										
										
										$data_c = array('number_new' => 1 );
	  								    $this->session->set_userdata($data_c);	
									    break;	
								}
							}
										
			
								$this->db->insert('trivia',$arr,FALSE);	
			

		}

              

								$result="Successfully";	
							$msg="Import Successfully";	
							$limit=20;
							$offset=0;
							$this->session->unset_userdata('number_new');
							if($arr123==0)
							{
								redirect('trivia/list_trivia/'.$limit.'/'.$offset.'/'.$result.'/'.base64_encode(0).'/'.base64_encode($data->sheets[0]['numRows']));
							}
							else {
								redirect('trivia/list_trivia/'.$limit.'/'.$offset.'/'.$result.'/'.base64_encode($arr123).'/'.base64_encode($data->sheets[0]['numRows']));
							}

	}
  
  } 
}

else {
		$msg = "xls_not_valid";
								redirect('trivia/import/'.$msg);	
	
}
		
	}

function banner_pages_update()
	{
		 $find_bar = '';
		  $find_trivia = '';
		    $find_trivia_app = '';
			$find_trivia_app_state = 0;
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





		  if($_FILES['find_trivia_app']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['find_trivia_app']['name'];
             $_FILES['userfile']['type']     =   $_FILES['find_trivia_app']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['find_trivia_app']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['find_trivia_app']['error'];
             $_FILES['userfile']['size']     =   $_FILES['find_trivia_app']['size'];
   
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
				
		   if ($_FILES["find_trivia_app"]["type"]!= "image/png" and $_FILES["find_trivia_app"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["find_trivia_app"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["find_trivia_app"]["type"] != "image/jpeg" and $_FILES["find_trivia_app"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/bar_pages_banner_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/bar_pages_banner/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => 1920,
				'height' => 1080,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
				echo $error; die;
			}
			//echo $error;
			//die;
			$find_trivia_app =$picture['file_name'];
			$crop_from_top = abs ($this->input->post('pos_trivia_app')) ;
		
		
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
			
		
			if($this->input->post('prev_trivia_app_banner_find')!='')
				{
					if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_trivia_app_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_trivia_app_banner_find');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_trivia_app_banner_find')))
					{
						$link2=base_path().'upload/bar_pages_banner_orig/'.$this->input->post('prev_trivia_app_banner_find');
						unlink($link2);
					}
					
				}
				
				$find_trivia_app_state = $this->input->post('find_trivia_app_state');
			} else {
				$find_trivia_app_state = $this->input->post('find_trivia_app_state');
				if($this->input->post('prev_trivia_app_banner_find')!='')
				{
					
					
					if($this->input->post('pos_trivia_app')!=0)
					{
						
						
						if(file_exists(base_path().'upload/bar_pages_banner/'.$this->input->post('prev_trivia_app_banner_find')))
					{
						$link=base_path().'upload/bar_pages_banner/'.$this->input->post('prev_trivia_app_banner_find');
						unlink($link);
					}
					
					
						
						$this->load->library('upload');
						$crop_from_top = abs ($this->input->post('pos_trivia_app')) ;
						
						
		$default_cover_width = 1140;
		$default_cover_height = 410;
		$a = base_path ()."cover-reposition/thumbncrop.inc.php";
		require_once ($a);
		//php class for image resizing & cropping

		$tb = new ThumbAndCrop ();

		$p = base_path ().'upload/bar_pages_banner_orig/'.$this->input->post('prev_trivia_app_banner_find');

       
		$tb->openImg ($p);
		//original cover image

		$newHeight = $tb->getRightHeight ($default_cover_width);

		$tb->creaThumb ($default_cover_width, $newHeight);

		$tb->setThumbAsOriginal ();

		$tb->cropThumb ($default_cover_width, $default_cover_height, 0, $crop_from_top);

		$q = base_path ().'upload/bar_pages_banner/'.$this->input->post('prev_trivia_app_banner_find');
		 
		$tb->saveThumb ($q);
		//save cropped cover image

		$tb->resetOriginal ();

		$tb->closeImg ();
		
					}
					
					$find_trivia_app =$this->input->post('prev_trivia_app_banner_find');
					 
				}
			}

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
			'find_trivia_app_state' => $find_trivia_app_state,
			'find_trivia_app' => $find_trivia_app,
			
			'media' => $find_media,
			'forum' => $find_forum,
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
}
?>