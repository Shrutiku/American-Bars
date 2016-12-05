<?php
class Membership_model extends CI_Model {
	
    function Membership_model()
    {
        parent::__construct();
	} 
	function get_total_membership_count($id)
	{
		$this->db->select('*');
		$this->db->from('membership_plan');
		$this->db->where('user_id',get_authenticateUserID());
		$query = $this->db->get();
		return $query->num_rows();	
	}
	  
	function get_membership_result_by_user($user_id,$offset=0, $limit=0)
	{
		$this->db->select("*");
		$this->db->from('membership_plan');
		$this->db->where('user_id',$user_id);
		$this->db->limit($limit,$offset);
		
		$query = $this->db->get();
		 //echo $this->db->last_query(); die;
		 if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	function insert_membership_plan($res)
	{
			//print_r($res); die;
			$data=array(
			'plan_title'=>$res['plan_title'],
			'category'=>$res['category'],
			'description'=>$res['description'],
			'price'=>$res['price'],
			'total_month'=>$res['total_month'],
			'user_id'=>get_authenticateUserID()
		);
		//print_r($data); die;
		$this->db->insert("membership_plan",$data);
	}
	function get_one_membership($id=0)
	{
	   $query = $this->db->get_where('membership_plan',array("membership_plan_id"=>$id));
		//return $query->row_array();
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return 0;
	}
	function update_membership_plan($res)
	{
		//print_r($res); die;
		$data=array(
			'plan_title'=>$res['plan_title'],
			'category'=>$res['category'],
			'description'=>$res['description'],
			'price'=>$res['price'],
			'total_month'=>$res['total_month'],
			//'membership_plan_id'=>$res['membership_plan_id']
		);
		$this->db->where('membership_plan_id',$res['membership_plan_id']);
		$this->db->update('membership_plan',$data);
		
	}
	function get_search_membership_result($limit = 0,$option,$keyword,$offset=0)
	{
	   $keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		$this->db->select('*');
		$this->db->from('membership_plan');
		$this->db->where('user_id',get_authenticateUserID());
		//$this->db->join("user_master u","m.user_id = u.user_id","left");
			if($option=="plan_title")
				{
				   $this->db->like("plan_title",$keyword);
				   
				   if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('plan_title',$val);
					}	
				}
				}
				if($option=="category")
				{
				   $this->db->like("category",$keyword);
				   
				   if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('category',$val);
					}	
				}
				}
				/*if($option=="username")
				{
				   $this->db->like("u.first_name",$keyword);
				   
				   if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('u.first_name',$val);
					}	
				}
				}*/
				
		$this->db->order_by("membership_plan_id", "desc"); 
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	
	}
	function get_total_search_membership_count($option,$keyword)
	{
	  
	
		$this->db->select('*');
		$this->db->from('membership_plan m');
		$this->db->where('user_id',get_authenticateUserID());
		if($option=="plan_title")
		{
				   $this->db->like("plan_title",$keyword);
				   
				   if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('plan_title',$val);
					}	
				}
				
				
		}
		if($option=="username")
		{
				   $this->db->like("u.first_name",$keyword);
				   
				   if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('u.first_name',$val);
					}	
				}
				
				
		}
		if($option=="category")
		{
				   $this->db->like("category",$keyword);
				   
				   if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('category',$val);
					}	
				}
				
				
		}
		
		$this->db->order_by("membership_plan_id", "desc"); 
		
		
		
		$query = $this->db->get();
		
		
		return $query->num_rows();
	}
	
	
	
}
?>