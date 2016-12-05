<?php

class Membership_model extends CI_Model {

	function Membership_model()
	{
		parent::__construct();
	}
	
	// --------------------------------------------------------------------

      /** 
       * function SaveForm()
       *
       * insert form data
       * @param $form_data - array
       * @return Bool - TRUE or FALSE
       */

	function SaveForm($form_data)
	{
		$this->db->insert('membership_plan', $form_data);
		
		if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
    function membership_insert()
	{
	 
	  $data_array=array();
					  $data_insert["plan_title"] = $this->input->post('plan_title');
					  $data_insert["category"] = $this->input->post('category');
					  $data_insert["total_month"] = $this->input->post('total_month');
					  $data_insert["price"] = $this->input->post('price');
		              $data['status']=$this->input->post('status');
			          $data['date_added']=date('Y-m-d H:i:s');
			          $data['ip']=$_SERVER['REMOTE_ADDR'];
			 //print_r($data_insert); die;
			$this->db->insert('membership_plan', $data_insert);

	}
	
	function membership_update()
	{
		
	$data_update=array();
					  $data_update["plan_title"] = $this->input->post('plan_title');
					  $data_update["category"] = $this->input->post('category');
					  $data_update["total_month"] = $this->input->post('total_month');
					  $data_update["price"] = $this->input->post('price');
		 			  $data_update["status"] = $this->input->post('status');
			
	
		$this->db->where("membership_plan_id",$this->input->post("membership_plan_id"));
		$this->db->update('membership_plan',$data_update);
		
	}
	
	function get_total_membership_count()
	{
	 return $this->db->count_all('membership_plan');
	}
	
	function get_membership_result($offset=0, $limit=0)
	{
	   /*$this->db->order_by("membership_plan_id","desc");
	   $query = $this->db->get('membership_plan',$limit,$offset);*/
	    $this->db->select('m.*,u.first_name,u.last_name');
		$this->db->from('membership_plan m');
		$this->db->join("user_master u","m.user_id = u.user_id","left");
		
		$query = $this->db->get();
		//echo $query = $this->db->last_query(); die;
       if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
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
	
	function get_category()
	{
	   $query = $this->db->get_where('category',array("status"=>'Active'));
		//return $query->row_array();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	function get_total_search_membership_count($option,$keyword)
	{
	  
	
		$this->db->select('m.*,u.first_name,u.last_name');
		$this->db->from('membership_plan m');
		$this->db->join("user_master u","m.user_id = u.user_id","left");
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
	
	function get_search_membership_result($option,$keyword,$offset, $limit)
	{
	   $keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		$this->db->select('m.*,u.first_name,u.last_name');
		$this->db->from('membership_plan m');
		$this->db->join("user_master u","m.user_id = u.user_id","left");
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
				
		$this->db->order_by("membership_plan_id", "desc"); 
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	
	}
	
	function get_parent_sub_category($catid)
	{
	    $qry=$this->db->get_where('category',array('parent_category_id'=>$catid,'status'=>1));
		if($qry->num_rows()>0)
		{
		   return $qry->result();
		}
		
		return 0;
	}
	
}
?>
