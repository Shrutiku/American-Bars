<?php
class Barstatistic_model extends CI_Model {
	
    function Barstatistic_model()
    {
        parent::__construct();	
    }   
	
	/*check unique barstatistic 
	 * param : barstatisticname, paitent_id(if in edit mode)
	 */
	function barstatistic_unique($str)
	{
		if($this->input->post('bar_statistic'))
		{
			$query = $this->db->get_where('bar_statistic',array('bar_statistic'=>$this->input->post('bar_statistic')));
			$res = $query->row_array();
			$email = $res['barstatistic_title'];
			
			$query = $this->db->query("select barstatistic_title from ".$this->db->dbprefix('barstatistic')." where barstatistic_title = '$str' and bar_statistic!='".$this->input->post('bar_statistic')."'");
		}else{
			$query = $this->db->query("select barstatistic_title from ".$this->db->dbprefix('barstatistic')." where barstatistic_title = '$str'");
		}
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/* check unique email
	 * param : email, barstatistic id(if in edit mode)
	 */
	function barstatistic_email_unique($str)
	{
		if($this->input->post('bar_statistic'))
		{
			$query = $this->db->get_where('bar_statistic',array('bar_statistic'=>$this->input->post('bar_statistic')));
			$res = $query->row_array();
			$email = $res['email'];
			
			$query = $this->db->query("select email from ".$this->db->dbprefix('bar_statistic')." where email = '$str' and bar_statistic!='".$this->input->post('bar_statistic')."'");
		}else{
			$query = $this->db->query("select email from ".$this->db->dbprefix('bar_statistic')." where email = '$str'");
		}
		
		
		
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/* add barstatistic detail in db
	 * 
	 */	
	function barstatistic_insert()
	{		
		$data["question"] = $this->input->post('question');
		$data["category"] =$this->input->post('category');
		$data["answer"] = $this->input->post('answer');			
		$data["status"] = $this->input->post('status');

		$this->db->insert('bar_statistic',$data);
		$bar_statistic = mysql_insert_id();
	}
	
	/* barstatistic update  */
	function barstatistic_update()
	{
		$data["question"] = $this->input->post('question');
		$data["category"] =$this->input->post('category');
		$data["answer"] = $this->input->post('answer');			
		$data["status"] = $this->input->post('status');
				
		$this->db->where('bar_statistic_id',$this->input->post('bar_statistic_id'));
		$this->db->update('bar_statistic',$data);
	}
	
	/* get barstatistic info * param : barstatistic id */		
	function get_one_barstatistic($id)
	{
		$query = $this->db->get_where('bar_statistic',array('bar_statistic_id'=>$id));
		return $query->row_array();
	}	
	
	/* get total barstatistics
	 * param :doctor id
	 */
	function get_total_barstatistic_count()
	{
		$this->db->select('*');
		$this->db->from('bar_statistic');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function get_total_poker_count()
	{
		//$this->db->where('is_deleted','no');
		 	$this->db->where('is_deleted','no');
			$this->db->where('barstatistic_type','poker_expert');
			//$this->db->or_where('barstatistic_type','poker_coach');
			$query = $this->db->get('bar_statistic');
			//echo $this->db->last_query(); die;
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}
		return 0;
	}
	
	/* get barstatistic doctor wise
	 * param : doctor id
	 */
	function get_barstatistic_result($offset,$limit)
	{
		$this->db->select('*');
		$this->db->from('bar_statistic');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return '';
	}
	/* search barstatistic doctor wise
	 * param:doctor id,option ,keyword
	 */	
	function get_total_search_barstatistic_count($option,$keyword)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('bar_statistic.*');
		$this->db->from('bar_statistic');
		
		
		if($option=='barstatistic_title')
		{
			$this->db->like('barstatistic_title',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('barstatistic_title',$val);
				}	
			}

		}

        	if($option=='category')
		{
			$this->db->like('category',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('category',$val);
				}	
			}

		}
		
		if($option=='answer')
		{
			$this->db->like('answer',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('answer',$val,'after');
				// }	
			// }

		}   
      /* if($option=='type')
		{
			$this->db->like('barstatistic_type',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('barstatistic_type',$val);
				}	
			}

		}
		
		
		if($option=='producer')
		{
			$this->db->like('producer',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('producer',$val);
				}	
			}

		}
		
		
		if($option=='city_produced')
		{
			$this->db->like('city_produced',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('city_produced',$val);
				}	
			}

		}*/
		
	//	$this->db->order_by('bar_statistic','desc');
		$query = $this->db->get();	
		return $query->num_rows();
	}	
	
	/* search barstatistic doctor wise * param:doctor id,option ,keyword  */		
	function get_search_barstatistic_result($option,$keyword,$offset, $limit)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('bar_statistic.*');
		$this->db->from('bar_statistic');
		
		if($option=='question')
		{
			$this->db->like('question',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('question',$val);
				}	
			}

		}
		
		if($option=='category')
		{
			$this->db->like('category',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('category',$val);
				}	
			}

		}
		
		if($option=='answer')
		{
			$this->db->like('answer',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('answer',$val,'after');
				// }	
			// }

		}     

		$this->db->order_by('bar_statistic_id','desc');
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