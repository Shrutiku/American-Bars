<?php
class Newsletter_model extends CI_Model {
	
    function Newsletter_model()
    {
        parent::__construct();	
    }   
	
	
	/* get total patients
	 * param :doctor id
	 */
	function get_total_newsletter_count()
	{
	
		$query = $this->db->get('newsletter');
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}
		return 0;
	}
	
	/* 
	 * get newsletter 
	 */
	function get_newsletter_result($offset,$limit)
	{
		
	//	$this->db->where(array('doctor_id'=>$doctor_id));
		$this->db->order_by("newsletter_id","desc");
		
		$query = $this->db->get('newsletter',$limit,$offset);
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	/* search patient doctor wise
	 * param:doctor id,option ,keyword
	 */	
	function get_total_search_subscribe_count($option,$keyword)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('newsletter.*');
		$this->db->from('newsletter');
		
		if($option=='full_name')
		{
			$this->db->like('first_name',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('first_name',$val);
				}	
			}
			
			$this->db->like('last_name',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('last_name',$val);
				}	
			}
			
		}
		if($option=='email')
		{
			$this->db->like('email',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('email',$val);
				}	
			}

		}
		
		$this->db->order_by('newsletter_id','desc');
		
		$query = $this->db->get();
		
		
		return $query->num_rows();
	}
	
	/* search patient doctor wise
	 * param:doctor id,option ,keyword
	 */		
	function get_search_subscribe_result($option,$keyword,$offset, $limit)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('newsletter.*');
		$this->db->from('newsletter');
		
		if($option=='full_name')
		{
			$this->db->like('first_name',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('first_name',$val);
				}	
			}
			
			$this->db->or_like('last_name',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->or_like('last_name',$val);
				}	
			}
			
		}
		if($option=='email')
		{
			$this->db->like('email',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('email',$val);
				}	
			}

		}
		
		$this->db->order_by('newsletter_id','desc');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
	
}
?>