<?php

class State_model extends CI_Model {
	
    function State_model()
    {
        parent::__construct();	
    }   
	
	/* insert state data in db
	 * param  : state id ,state name , is delete
	 */	
	function state_insert()
	{
		$data = array(
			'country_id' => $this->input->post('country_id'),
			'state_name' => $this->input->post('state_name'),
			'is_delete' => ($this->input->post('is_delete')=='n')?'n':'y',
		   );	
		 
		 $this->db->insert('state_master',$data);
		
	}
	
	/* check for unque state name
	 * param :state name , state id(if in edit mode)
	 */
	function state_unique($str)
	{
	
		if($this->input->post('state_id'))
		{
			$query = $this->db->get_where('state_master',array('state_id'=>$this->input->post('state_id')));
			$res = $query->row_array();
			$state_name = $res['state_name'];

			$query = $this->db->query("select state_name from ".$this->db->dbprefix('state_master')." where state_name= '$str' and state_id!='".$this->input->post('state_id')."'");
		}else{
		
			$query = $this->db->query("select state_name from ".$this->db->dbprefix('state_master')." where state_name = '$str'");
		}
		
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
		
	}
	
	/* state update form fill
	 *  param  : state id 
	 */	
	function state_update()
	{
		
		$data = array(
			'country_id' => $this->input->post('country_id'),
			'state_name' => $this->input->post('state_name'),
			'is_delete' => ($this->input->post('is_delete')=='n')?'n':'y',
		   );	
		$this->db->where('state_id',$this->input->post('state_id'));
		$this->db->update('state_master',$data);
		
		
		
	}
	
	/*
	 * get one state info
	 * param : state id
	 */	
	function get_one_state($id)
	{
		$query = $this->db->get_where('state_master',array('state_id'=>$id));
		return $query->row_array();
	}	
	
	/*get total num of states
	 * 
	 */
	function get_total_state_count()
	{
		return $this->db->count_all('state_master');
	}
	
	function get_state_result($offset, $limit)
	{
		$sql = "select st.*,cn.Country_Name from ".$this->db->dbprefix('state_master')." st,".$this->db->dbprefix('country_master')." cn where st.country_id = cn.country_id order by state_id DESC limit ".$limit." offset ".$offset."";
		 $query = $this->db->query($sql);
	
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	/* total search count
	 * param : option, keyword
	 */	
	function get_total_search_state_count($option,$keyword)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		//$option='username';
		
		$this->db->select('st.*,ct.Country_Name');
		$this->db->from('state_master st');
		$this->db->join('country_master ct','ct.Country_id=st.country_id');
		
		
		if($option=='statename')
		{
			$this->db->like('st.state_name',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('st.state_name',$val);
				}	
			}

		}
		if($option=='countryname')
		{
			$this->db->like('ct.Country_Name',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('ct.Country_Name',$val);
				}	
			}

		}
		
		$this->db->order_by("state_id", "asc"); 
		
		$query = $this->db->get();
		
		
		return $query->num_rows();
	}
	
	// Use :This function use for get state detail by filter and limit and offset.
	// Param :offset,limit,option,keyword
	// Return :array of object
	function get_search_state_result($option,$keyword,$offset, $limit)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('st.*,ct.Country_Name');
		$this->db->from('state_master st');
		$this->db->join('country_master ct','ct.Country_id=st.country_id');
		
		
		if($option=='statename')
		{
			$this->db->like('st.state_name',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('st.state_name',$val);
				}	
			}

		}
		if($option=='countryname')
		{
			$this->db->like('ct.Country_Name',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('ct.Country_Name',$val);
				}	
			}

		}
		
		$this->db->order_by("state_id", "asc"); 
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
}
?>