<?php

class Country_model extends CI_Model {
	
    function Country_model()
    {
        parent::__construct();	
    }   
	
	
	// Use :This function use for add new Country.
	// Param :Post Data
	// Return :'N/A'
	function country_insert()
	{
		$flag='';
		$image_settings=image_setting();
		  if(isset($_FILES['file_up']) && $_FILES['file_up']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['file_up']['name'];
             $_FILES['userfile']['type']     =   $_FILES['file_up']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['file_up']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['file_up']['error'];
             $_FILES['userfile']['size']     =   $_FILES['file_up']['size'];
   
			$config['file_name'] = $rand.$this->input->post('country_iso_Code');
			
            $config['upload_path'] = base_path().'upload/flag/';
			
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			   

			   
       	  $picture = $this->upload->data();
			
			$flag=$picture['file_name'];
			
			
		
			if($this->input->post('prev_flag_image')!='')
				{
					if(file_exists(base_path().'upload/flag/'.$this->input->post('prev_flag_image')))
					{
						$link=base_path().'upload/flag/'.$this->input->post('prev_flag_image');
						unlink($link);
					}
					
					
				}
			} else {
				if($this->input->post('prev_flag_image')!='')
				{
					$flag=$this->input->post('prev_flag_image');
				}
			}
		$data = array(
			'Country_Name' => $this->input->post('country_name'),
			'Countries_ISO_Code' => $this->input->post('country_iso_Code'),
			
			
			'is_delete' => ($this->input->post('is_delete')=='n')?'n':'y',
			
			
			
		   );		
		$this->db->insert('country_master',$data);
		
	}

	// Use :This function use for check Country .
	// Param :country
	// Return :Boolean
	function country_unique($str)
	{
	
		if($this->input->post('country_id'))
		{
			$query = $this->db->get_where('country_master',array('Country_id'=>$this->input->post('country_id')));
			$res = $query->row_array();
			$country_name = $res['Country_Name'];
			
			$query = $this->db->query("select Country_Name from ".$this->db->dbprefix('country_master')." where Country_Name= '$str' and country_id!='".$this->input->post('country_id')."'");
		}else{
		
			$query = $this->db->query("select Country_Name from ".$this->db->dbprefix('country_master')." where Country_Name = '$str'");
		}
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
		
	}
	
	
	// Use :This function use for Update Country Detail.
	// Param :Post Data
	// Return :'N/A'
	
	function country_update()
	{
		$flag='';
		$image_settings=image_setting();
		  if(isset($_FILES['file_up']) &&  $_FILES['file_up']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['file_up']['name'];
             $_FILES['userfile']['type']     =   $_FILES['file_up']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['file_up']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['file_up']['error'];
             $_FILES['userfile']['size']     =   $_FILES['file_up']['size'];
   
			$config['file_name'] = $rand.$this->input->post('country_iso_Code');
			
            $config['upload_path'] = base_path().'upload/flag/';
			
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			   

			   
           	  $picture = $this->upload->data();
		   
             
			
					
		
			
			$flag=$picture['file_name'];
			
			
		
			if($this->input->post('prev_flag_image')!='')
				{
					if(file_exists(base_path().'upload/flag/'.$this->input->post('prev_flag_image')))
					{
						$link=base_path().'upload/flag/'.$this->input->post('prev_flag_image');
						unlink($link);
					}
					
					
				}
			} else {
				if($this->input->post('prev_flag_image')!='')
				{
					$flag=$this->input->post('prev_flag_image');
				}
			}
		$data = array(
			'Country_Name' => $this->input->post('country_name'),
			'Countries_ISO_Code' => $this->input->post('country_iso_Code'),
			'is_delete' => ($this->input->post('is_delete')=='n')?'n':'y'
		   );
			
		$this->db->where('Country_id',$this->input->post('country_id'));
		$this->db->update('country_master',$data);
		
	}
	
	// Use :This function use for get one Country detail.
	// Param :Country Id
	// Return :array
	function get_one_country($id)
	{
		$query = $this->db->get_where('country_master',array('Country_id'=>$id));
		return $query->row_array();
	}	
	// Use :This function use for count all country.
	// Param :'N/A'
	// Return :Number
	function get_total_country_count()
	{
		return $this->db->count_all('country_master');
	}
	
	// Use :This function use for get country detail by limit and offset.
	// Param :offset,limit
	// Return :array of object
	
	
	function get_country_result($offset, $limit)
	{
		$this->db->order_by('Country_id','asc');
		$query = $this->db->get('country_master',$limit,$offset);
		

		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	
	
	// Use :This function use for count country by Filder.
	// Param :option,keyword
	// Return :number
	function get_total_search_country_count($option,$keyword)
	{
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		
		$this->db->select('country_master.*');
		$this->db->from('country_master');
		
		if($option=='countryname')
		{
			$this->db->like('country_name',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('country_name',$val);
				}	
			}

		}
		
		$this->db->order_by("Country_id", "asc"); 
		
		$query = $this->db->get();
		
		
		return $query->num_rows();
	}
	
	
	// Use :This function use for get country detail by filter and limit and offset.
	// Param :offset,limit,option,keyword
	// Return :array of object
	function get_search_country_result($option,$keyword,$offset, $limit)
	{
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('country_master.*');
		$this->db->from('country_master');
		
		if($option=='countryname')
		{
			$this->db->like('country_name',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('country_name',$val);
				}	
			}

		}
		
		
		
	    $this->db->order_by("Country_id", "asc"); 
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
}
?>