<?php
class Term_model extends CI_Model {
	
    function Term_model()
    {
        parent::__construct();	
    }   

	/* add term detail in db
	 * 
	 */	
	function term_insert()
	{
		$data["term_id"] = $this->input->post('term_id');		
		$data["term_title"] = $this->input->post('term_title');
		$data["description"] = $this->input->post('description');
		$data["term_usage"] =$this->input->post('term_usage');
		$data["status"] = $this->input->post('status');
		$data["date_added"] = date("Y-m-d h:i:s");
		
		$this->db->insert('bar_term',$data);
		$term_id = mysql_insert_id();
	}
	
	/* term update  */
	function term_update()
	{
		$data["term_id"] = $this->input->post('term_id');		
		$data["term_title"] = $this->input->post('term_title');
		$data["description"] = $this->input->post('description');
		$data["term_usage"] =$this->input->post('term_usage');
		$data["status"] = $this->input->post('status');
				
		$this->db->where('term_id',$this->input->post('term_id'));
		$this->db->update('bar_term',$data);
	}
	
	/* get term info * param : term id */		
	function get_one_term($id)
	{
		$query = $this->db->get_where('bar_term',array('term_id'=>$id));
		return $query->row_array();
	}	
	
	/* get total terms
	 * param :doctor id
	 */
	function get_total_term_count()
	{
		$this->db->select('*');
		$this->db->from('bar_term');
		$query = $this->db->get();
		return $query->num_rows();
	}	
	
	/* get term doctor wise
	 * param : doctor id
	 */
	function get_term_result($offset,$limit)
	{
		$this->db->select('*');
		$this->db->from('bar_term');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return '';
	}
	
	/* search term doctor wise
	 * param:doctor id,option ,keyword
	 */	
	function get_total_search_term_count($option,$keyword)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('bar_term.*');
		$this->db->from('bar_term');
		
		
		if($option=='term_title')
		{
			$this->db->like('term_title',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('term_title',$val);
				}	
			}

		}
		$query = $this->db->get();	
		return $query->num_rows();
	}	
	
	/* search term doctor wise * param:doctor id,option ,keyword  */		
	function get_search_term_result($option,$keyword,$offset, $limit)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('bar_term.*');
		$this->db->from('bar_term');
		
		if($option=='term_title')
		{
			$this->db->like('term_title',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('term_title',$val);
				}	
			}
		}

		$this->db->order_by('term_id','desc');
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