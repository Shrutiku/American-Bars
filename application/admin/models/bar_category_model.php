<?php

class Bar_category_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	// --------------------------------------------------------------------

      /** 
       * function Savebar()
       *
       * insert bar data
       * @param $bar_data - array
       * @return Bool - TRUE or FALSE
       */

	function Savebar($bar_data)
	{
		$this->db->insert('bar_category', $bar_data);
		
		if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
    function bar_category_insert()
	{
	 
	  $data_array=array();
					  $data_insert["bar_category_name"] = $this->input->post('bar_category_name');
					  $data_insert['status']=$this->input->post('status');
			          $data_insert['date_added']=date('Y-m-d H:i:s');
			 //$data['ip']=$_SERVER['REMOTE_ADDR'];
			 //print_r($data_insert); die;
			$this->db->insert('bar_category', $data_insert);

	}
	
	function bar_category_update()
	{
		
	$data_update=array();
					  $data_update["bar_category_name"] = $this->input->post('bar_category_name');
					  $data_update["status"] = $this->input->post('status');
					 
			
	
		$this->db->where("bar_category_id",$this->input->post("bar_category_id"));
		$this->db->update('bar_category',$data_update);
		
	}
	
	function get_total_bar_category_count()
	{
	 return $this->db->count_all('bar_category');
	}
	
	function get_bar_category_result($offset=0, $limit=0)
	{
	   $this->db->order_by("bar_category_id","desc");
	   $query = $this->db->get('bar_category',$limit,$offset);
	     if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	function get_one_bar_category($id=0)
	{
	   $query = $this->db->get_where('bar_category',array("bar_category_id"=>$id));
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
	
	function get_total_search_bar_category_count($option,$keyword)
	{
	   $keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
	
	
		$this->db->from('bar_category');
		if($option=="bar_category_name")
		{
				   $this->db->like("bar_category_name",$keyword,"after");
				   
				   // if(substr_count($keyword,' ')>=1)
			      // {
				     // $ex=explode(' ',$keyword);
// 				
					// foreach($ex as $val)
					// {
						// $this->db->like('bar_category_name',$val);
					// }	
				// }
				
				
		}
		
		
		$this->db->order_by("bar_category_id", "desc"); 
		$query = $this->db->get();
		//echo $query = $this->db->last_query(); die;
		return $query->num_rows();
	}
	
	function get_search_bar_category_result($option,$keyword,$offset, $limit)
	{
	   $keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/",'-'),' ',$keyword));
		
		//$this->db->select('bar_category *');
		$this->db->from('bar_category');
		
				if($option=="bar_category_name")
				{
				   $this->db->like("bar_category_name",$keyword,"after");
				   
				   // if(substr_count($keyword,' ')>=1)
			      // {
				     // $ex=explode(' ',$keyword);
// 				
					// foreach($ex as $val)
					// {
						// $this->db->like('bar_category_name',$val);
					// }	
				// }
				}
				
				
		$this->db->order_by("bar_category_id", "desc"); 
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
