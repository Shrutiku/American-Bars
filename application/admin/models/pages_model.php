<?php

class Pages_model extends CI_Model {
	
    function Pages_model()
    {
        parent::__construct();	
    }   
	
	function get_total_pages_count()
	{
		return $this->db->count_all('pages');
	}
	
	
	function get_pages_result($offset,$limit,$sort_by='pages_id',$sort_type='DESC')
	{
		$this->db->order_by($sort_by,$sort_type);
		$query = $this->db->get('pages',$limit,$offset);

		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}

	function pages_insert()
	{
		$data = array(
			'pages_title' => $this->input->post('pages_title'),
			'description' => $this->input->post('description'),
			'slug' => $this->input->post('slug'),
			'active' => $this->input->post('active'),
			'meta_keyword' => $this->input->post('meta_keyword'),
			'meta_description' => $this->input->post('meta_description')
		);		
		$this->db->insert('pages',$data);
	}	

	
	function pages_update()
	{
		$data = array(			
			'pages_title' => $this->input->post('pages_title'),
			'description' => $this->input->post('description'),
			'description1' => $this->input->post('description1'),
			'slug' => $this->input->post('slug'),
			'active' => $this->input->post('active'),
			'meta_keyword' => $this->input->post('meta_keyword'),
			'meta_description' => $this->input->post('meta_description')
		);
		$this->db->where('pages_id',$this->input->post('pages_id'));
		$this->db->update('pages',$data);
        
         /// Log entry
           $data_log = array("activity_name" => "LOG_UPDATE_PAGE");
           maintain_log($data_log);
	}	
	function get_one_pages($id)
	{
		$query = $this->db->get_where('pages',array('pages_id'=>$id));
		return $query->row_array();
	}	
	
	
	function get_total_search_pages_count($option,$keyword,$sort_type,$sort_by)
	{
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('pages.*');
		$this->db->from('pages');
		
		if($option=='pages_title' || $option=='all')
		{
			$this->db->like('pages_title',$keyword);
	
		}
		
		
		$this->db->order_by($sort_by,$sort_type); 
		
		$query = $this->db->get();
		
		
		return $query->num_rows();
	}

	
	function get_search_pages_result($option,$keyword,$sort_type,$sort_by,$offset, $limit)
	{
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('pages.*');
		$this->db->from('pages');
		
		if($option=='pages_title' || $option=='all')
		{
			$this->db->like('pages_title',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('pages_title',$val);
				}	
			}
			

		}
		
		$this->db->order_by($sort_by,$sort_type);
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
		
		
	}
	
	
	
}
?>