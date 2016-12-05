<?php
class Quiz_model extends CI_Model 
{
	/*
	Function name :Home_model
	Description :its default constuctor which called when Home_model object initialzie.its load necesary parent constructor
	*/
	function Quiz_model()
    {
        parent::__construct();
    }	
	
	function getquiz($id='')
	{
		$getarray = $this->getquiz_id($this->session->userdata('set_quiz'));
		
		
		$getarray123 = array();
    if($getarray)
	{
    foreach($getarray as $row)
    {
        $getarray123[] = $row->q_id; // add each user id to the array
    }
	}
     
	    
      
		$this->db->select('*');
		$this->db->from('trivia');
		if($id!='')
        {
		  $this->db->where('trivia_id !=',$id);
		}  
		if(!is_array($getarray))
		{
			$this->db->where_not_in('trivia_id ',$getarray);
		}
		
		 $this->db->where('status','active');
		$this->db->order_by('trivia_id', 'RANDOM');
		$qry = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($qry->num_rows()>0)
		{
			 return $qry->row_array();
		}
		return 0;
	}
	
	function getquiz_id($id='')
	{
		$this->db->select('q_id');
		$this->db->from('quiz_answer');
		if($id!='')
        {
		  $this->db->where('sessionuserid',"$id");
		}  
		$qry = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($qry->num_rows()>0)
		{
			 return $qry->result();
		}
		return 0;
	}
	
	function getquiz_byid($id='')
	{
		$this->db->select('*');
		$this->db->from('trivia');
		  $this->db->where('trivia_id',$id);
		  $this->db->where('status','active');
		$qry = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($qry->num_rows()>0)
		{
			 return $qry->row_array();
		}
		return 0;
	}
	
	function checkquesion($id)
	{
		$this->db->select('*');
		$this->db->from('trivia');
		$this->db->where('trivia_id',$id);
		$qry = $this->db->get();
		if($qry->num_rows()>0)
		{
			 return $qry->row_array();
		}
		return 0;
	}
	
	function quenum($sessid)
	{
		$this->db->select('*');
		$this->db->from('quiz_answer');
		$this->db->where('sessionuserid',$sessid);
		$qry = $this->db->get();
		return $qry->num_rows()+1;
	}
	
	function getquizresult($sessid)
	{
		$this->db->select('*,sum(right_answer) as pt,count(quiz_answer_id) as an');
		$this->db->from('quiz_answer');
		$this->db->where('sessionuserid',"$sessid");
		$this->db->where('no_result !=','1');
		$this->db->group_by('sessionuserid');
		$qry = $this->db->get();
		
		
		if($qry->num_rows()>0)
		{
			 return $qry->row_array();
		}
		return 0;
		
	}

function getquizresult_time($sessid)
	{
		$this->db->select('sum(time) as time');
		$this->db->from('quiz_answer');
		$this->db->where('sessionuserid',"$sessid");
		$this->db->group_by('sessionuserid');
		$qry = $this->db->get();
		
		
		if($qry->num_rows()>0)
		{
			 return $qry->row_array();
		}
		return 0;
		
	}
}

?>