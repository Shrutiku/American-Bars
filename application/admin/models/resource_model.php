<?php
class Resource_model extends CI_Model {
	
    function Resource_model()
    {
        parent::__construct();	
    }   

	/* add resource detail in db
	 * 
	 */	
	function resource_insert()
	{		
		$data["resource_title"] = $this->input->post('resource_title');
		$data["resource_desc"] = $this->input->post('resource_desc');
		$data["resource_category"] =$this->input->post('resource_category');
		$data["website"] =$this->input->post('website');
		$data["status"] = $this->input->post('status');
		$data["resource_meta_title"] = $this->input->post('resource_meta_title');
		$data["resource_meta_keyword"] = $this->input->post('resource_meta_keyword');
		$data["resource_meta_description"] = $this->input->post('resource_meta_description');

		$this->db->insert('resource',$data);
		$resource = mysql_insert_id();
	}
	
	/* resource update  */
	function resource_update()
	{
		$data["resource_title"] = $this->input->post('resource_title');
		$data["resource_desc"] = $this->input->post('resource_desc');
		$data["resource_category"] =$this->input->post('resource_category');
		$data["website"] =$this->input->post('website');
		$data["status"] = $this->input->post('status');
		$data["resource_meta_title"] = $this->input->post('resource_meta_title');
		$data["resource_meta_keyword"] = $this->input->post('resource_meta_keyword');
		$data["resource_meta_description"] = $this->input->post('resource_meta_description');		
		$this->db->where('resource_id',$this->input->post('resource_id'));
		$this->db->update('resource',$data);
	}
	
	/* get resource info * param : resource id */		
	function get_one_resource($id)
	{
		$query = $this->db->get_where('resource',array('resource_id'=>$id));
		return $query->row_array();
	}	
	
	/* get total resources
	 * param :doctor id
	 */
	function get_total_resource_count()
	{
		$this->db->select('*');
		$this->db->from('resource');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function get_total_poker_count()
	{
		//$this->db->where('is_deleted','no');
		 	$this->db->where('is_deleted','no');
			$this->db->where('resource_type','poker_expert');
			//$this->db->or_where('resource_type','poker_coach');
			$query = $this->db->get('resource');
			//echo $this->db->last_query(); die;
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}
		return 0;
	}
	
	/* get resource doctor wise
	 * param : doctor id
	 */
	function get_resource_result($offset,$limit)
	{
		$this->db->select('*');
		$this->db->from('resource');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return '';
	}
	/* search resource doctor wise
	 * param:doctor id,option ,keyword
	 */	
	function get_total_search_resource_count($option,$keyword)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('resource.*');
		$this->db->from('resource');
		
		if($option=='resource_title')
		{
			$this->db->like('resource_title',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('resource_title',$val);
				}	
			}

		}
		
		if($option=='resource_category')
		{
			$this->db->like('resource_category',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('resource_category',$val);
				}	
			}

		}
		
		$query = $this->db->get();	
		return $query->num_rows();
	}	
	
	/* search resource doctor wise * param:doctor id,option ,keyword  */		
	function get_search_resource_result($option,$keyword,$offset, $limit)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('resource.*');
		$this->db->from('resource');
		
		if($option=='resource_title')
		{
			$this->db->like('resource_title',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('resource_title',$val);
				}	
			}

		}
		
		if($option=='resource_category')
		{
			$this->db->like('resource_category',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('resource_category',$val);
				}	
			}

		}		
		
		$this->db->order_by('resource_id','desc');
		$this->db->limit($limit,$offset);
		
		$query = $this->db->get();
		
		
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}	  
}
?>