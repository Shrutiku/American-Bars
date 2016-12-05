<?php

class City_model extends CI_Model {
	
    function City_model()
    {
        parent::__construct();	
    }   
	
	// Use :This function use for add new City.
	// Param :Post Data
	// Return :'N/A'
	
	function city_insert()
	{
			
		$data = array(
			'country_id'=>$this->input->post('country_id'),
			'state_id'=>$this->input->post('state_id'),
			'city_name' => $this->input->post('city_name'),
			'lat' => $this->input->post('lat'),
			'lng' => $this->input->post('lng'),
			'zipcode'=> $this->input->post('zipcode')
		);		
		$this->db->insert('city_master',$data);
		
	}
	
	
	
	// Use :This function use for Update City.
	// Param :Post Data
	// Return :'N/A'
	function city_update()
	{
		
		$data = array(
			'country_id'=>$this->input->post('country_id'),
			'state_id'=>$this->input->post('state_id'),
			'city_name' => $this->input->post('city_name'),
			'lat' => $this->input->post('lat'),
			'lng' => $this->input->post('lng'),
			'zipcode'=> $this->input->post('zipcode')
		);		
		$this->db->where('city_id',$this->input->post('city_id'));
		$this->db->update('city_master',$data);
		
		
	}
	
	
	// Use :This function use for get one city detail.
	// Param :City Id
	// Return :array
	function get_one_city($id)
	{
		$query = $this->db->get_where('city_master',array('city_id'=>$id));
		return $query->row_array();
	}	
	
	
	// Use :This function use for count all city.
	// Param :'N/A'
	// Return :Number
	
	function get_total_city_count()
	{
		$query = $this->db->get('city_master');
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}
		return 0;
	}
	
	// Use :This function use for get city detail by limit and offset.
	// Param :offset,limit
	// Return :array of object
	
	function get_city_result($offset, $limit)
	{
		$this->db->select('ci.*,s.state_name,cm.country_name');
		$this->db->from('city_master ci');
		$this->db->join('state_master s','s.state_id=ci.state_id');
		$this->db->join('country_master cm','cm.country_id=ci.country_id');
		$this->db->order_by('ci.city_name','asc');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		

		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	
	

	
	// Use :This function use for count city by Filder.
	// Param :option,keyword
	// Return :number
	function get_total_search_city_count($option,$keyword)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('ci.*,s.state_name,cm.country_name');
		$this->db->from('city_master ci');
		$this->db->join('state_master s','s.state_id=ci.state_id');
		$this->db->join('country_master cm','cm.country_id=ci.country_id');
		
		
		
		if($option=='city')
		{
			$this->db->like('ci.city_name',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('ci.city_name',$val);
				}	
			}

		}
		if($option=='state')
		{
			$this->db->like('s.state_name',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('s.state_name',$val);
				}	
			}

		}
		if($option=='country')
		{
			$this->db->like('cm.country_name',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('cm.country_name',$val);
				}	
			}

		}
		
		
		$this->db->order_by('ci.city_name','asc');
		
		$query = $this->db->get();
		
		
		return $query->num_rows();
	}
	
	
	// Use :This function use for get city detail by filter and limit and offset.
	// Param :offset,limit,option,keyword
	// Return :array of object
	
	function get_search_city_result($option,$keyword,$offset, $limit)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('ci.*,s.state_name,cm.country_name');
		$this->db->from('city_master ci');
		$this->db->join('state_master s','s.state_id=ci.state_id');
		$this->db->join('country_master cm','cm.country_id=ci.country_id');
		
		
		
		if($option=='city')
		{
			$this->db->like('ci.city_name',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('ci.city_name',$val);
				}	
			}

		}
		if($option=='state')
		{
			$this->db->like('s.state_name',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('s.state_name',$val);
				}	
			}

		}
		if($option=='country')
		{
			$this->db->like('cm.country_name',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('cm.country_name',$val);
				}	
			}

		}
		
		
		$this->db->order_by('ci.city_name','asc');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
}
?>