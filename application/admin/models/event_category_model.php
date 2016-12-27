<?php

class event_category_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	// --------------------------------------------------------------------

      /** 
       * function Saveevent()
       *
       * insert event data
       * @param $event_data - array
       * @return Bool - TRUE or FALSE
       */

	function Saveevent($event_data)
	{
		$this->db->insert('event_category', $event_data);
		
		if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
    function event_category_insert()
	{
	 
	  $data_array=array();
					  $data_insert["event_category_name"] = $this->input->post('event_category_name');
					  $data_insert['status']=$this->input->post('status');
			          $data_insert['date_added']=date('Y-m-d H:i:s');
			 //$data['ip']=$_SERVER['REMOTE_ADDR'];
			 //print_r($data_insert); die;
			$this->db->insert('event_category', $data_insert);

	}
	
	function event_category_update()
	{
		
	$data_update=array();
					  $data_update["event_category_name"] = $this->input->post('event_category_name');
					  $data_update["status"] = $this->input->post('status');
					 
			
	
		$this->db->where("event_category_id",$this->input->post("event_category_id"));
		$this->db->update('event_category',$data_update);
		
	}
	
	function get_total_event_category_count()
	{
	 return $this->db->count_all('event_category');
	}
	
	function get_event_category_result($offset=0, $limit=0)
	{
	   $this->db->order_by("event_category_id","desc");
	   $query = $this->db->get('event_category',$limit,$offset);
	     if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	function get_one_event_category($id=0)
	{
	   $query = $this->db->get_where('event_category',array("event_category_id"=>$id));
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
	
	function get_total_search_event_category_count($option,$keyword)
	{
	   $keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
	
	
		$this->db->from('event_category');
		if($option=="event_category_name")
		{
				   $this->db->like("event_category_name",$keyword,"after");
				   
				   // if(substr_count($keyword,' ')>=1)
			      // {
				     // $ex=explode(' ',$keyword);
// 				
					// foreach($ex as $val)
					// {
						// $this->db->like('event_category_name',$val);
					// }	
				// }
				
				
		}
		
		
		$this->db->order_by("event_category_id", "desc"); 
		$query = $this->db->get();
		//echo $query = $this->db->last_query(); die;
		return $query->num_rows();
	}
	
	function get_search_event_category_result($option,$keyword,$offset, $limit)
	{
	   $keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/",'-'),' ',$keyword));
		
		//$this->db->select('event_category *');
		$this->db->from('event_category');
		
				if($option=="event_category_name")
				{
				   $this->db->like("event_category_name",$keyword,"after");
				   
				   // if(substr_count($keyword,' ')>=1)
			      // {
				     // $ex=explode(' ',$keyword);
// 				
					// foreach($ex as $val)
					// {
						// $this->db->like('event_category_name',$val);
					// }	
				// }
				}
				
				
		$this->db->order_by("event_category_id", "desc"); 
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
