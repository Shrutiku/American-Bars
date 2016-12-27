<?php
class Job_model extends CI_Model {
	
    function Job_model()
    {
        parent::__construct();	
    }   
	
	/*check unique job 
	 * param : jobname, paitent_id(if in edit mode)
	 */
	function job_unique($str)
	{
		if($this->input->post('job_id'))
		{
			$query = $this->db->get_where('jobs',array('job_id'=>$this->input->post('job_id')));
			$res = $query->row_array();
			$email = $res['job_title'];
			
			$query = $this->db->query("select job_title from ".$this->db->dbprefix('jobs')." where job_title = '$str' and job_id!='".$this->input->post('job_id')."'");
		}else{
			$query = $this->db->query("select job_title from ".$this->db->dbprefix('jobs')." where job_title = '$str'");
		}
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/* check unique email
	 * param : email, job id(if in edit mode)
	 */
	function job_email_unique($str)
	{
		if($this->input->post('job_id'))
		{
			$query = $this->db->get_where('jobs',array('job_id'=>$this->input->post('job_id')));
			$res = $query->row_array();
			$email = $res['email'];
			
			$query = $this->db->query("select email from ".$this->db->dbprefix('jobs')." where email = '$str' and job_id!='".$this->input->post('job_id')."'");
		}else{
			$query = $this->db->query("select email from ".$this->db->dbprefix('jobs')." where email = '$str'");
		}
		
		
		
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/* add job detail in db
	 * 
	 */	
	function job_insert()
	{
		$data["job_title"] = $this->input->post('job_title');
		$data["job_desc"] = $this->input->post('job_desc');
		$data["user_id"] = get_authenticateadminID();
		$data["added_by"] = 'admin';
		$data["job_category"] =$this->input->post('job_category');
		$data["status"] = $this->input->post('status');
		$data["date_added"] = date("Y-m-d h:i:s");
		$this->db->insert('jobs',$data);
		$job_id = mysql_insert_id();
	}
	
	/* job update  */
	function job_update()
	{
		$data["job_title"] = $this->input->post('job_title');
		$data["job_desc"] = $this->input->post('job_desc');
		$data["user_id"] = get_authenticateadminID();
		$data["added_by"] = 'admin';
		$data["job_category"] =$this->input->post('job_category');
		$data["status"] = $this->input->post('status');
				
		$this->db->where('job_id',$this->input->post('job_id'));
		$this->db->update('jobs',$data);
	}
	
	/* get job info * param : job id */		
	function get_one_job($id)
	{
		$query = $this->db->get_where('jobs',array('job_id'=>$id));
		return $query->row_array();
	}	
	
	/* get total jobs
	 * param :doctor id
	 */
	function get_total_job_count()
	{
		$this->db->select('*');
		$this->db->from('jobs');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function get_total_poker_count()
	{
		//$this->db->where('is_deleted','no');
		 	$this->db->where('is_deleted','no');
			$this->db->where('job_type','poker_expert');
			//$this->db->or_where('job_type','poker_coach');
			$query = $this->db->get('jobs');
			//echo $this->db->last_query(); die;
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}
		return 0;
	}
	
	/* get job doctor wise
	 * param : doctor id
	 */
	function get_job_result($offset,$limit)
	{
		$this->db->select('*');
		$this->db->from('jobs');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return '';
	}
	function get_poker_result($offset,$limit)
	{
		
	//	$this->db->where(array('doctor_id'=>$doctor_id));
		$this->db->order_by("job_id","desc");
		$this->db->where('is_deleted','no');
		//$this->db->where('job_type','poker_expert');
		$this->db->where('job_type','poker_coach');
		$query = $this->db->get('jobs',$limit,$offset);
		
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	/* search job doctor wise
	 * param:doctor id,option ,keyword
	 */	
	function get_total_search_job_count($option,$keyword)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('jobs.*');
		$this->db->from('jobs');
		
		
		if($option=='job_title')
		{
			$this->db->like('job_title',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);				
				foreach($ex as $val)
				{
					$this->db->like('job_title',$val);
				}	
			}
		}
		
		if($option=='job_category')
		{
			$this->db->like('job_category',$keyword);			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);				
				foreach($ex as $val)
				{
					$this->db->like('job_category',$val);
				}	
			}

		}
		
		$query = $this->db->get();	
		return $query->num_rows();
	}	
	
	/* search job doctor wise * param:doctor id,option ,keyword  */		
	function get_search_job_result($option,$keyword,$offset, $limit)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('jobs.*');
		$this->db->from('jobs');
		
		if($option=='job_title')
		{
			$this->db->like('job_title',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('job_title',$val);
				}	
			}

		}
		
		if($option=='job_category')
		{
			$this->db->like('job_category',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('job_category',$val);
				}	
			}

		}

		$this->db->order_by('job_id','desc');
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