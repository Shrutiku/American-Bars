<?php
class Liquor_suggestion_model extends CI_Model {
	
    function Liquor_suggestion_model()
    {
        parent::__construct();	
    }   
	

	/* get total liquor_suggestions
	 * param :doctor id
	 */
	function get_total_liquor_suggestion_count($bar_id = 0)
	{
		//$this->db->where('is_deleted','no');
		if($bar_id > 0 && is_numeric($bar_id))
		{
			//$query = $this->db->get_where('beer_directory',array('is_deleted'=>'no',"bar_id"=>$bar_id));
			$this->db->select('*');
			$this->db->from('liquor_bars');
			$this->db->join('liquors','liquors.liquor_id=liquor_bars.liquor_id');
			$this->db->where('liquor_bars.bar_id',$bar_id);
			$this->db->where('liquors.is_deleted','no');
			$query= $this->db->get();
		}
       else
       {
		$query = $this->db->get_where('liquors',array('is_deleted'=>'no','status'=>'pending'));
	   }
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}
		return 0;
	}
	
	
	/* get liquor_suggestion doctor wise
	 * param : doctor id
	 */
	function get_liquor_suggestion_result($offset,$limit,$bar_id = 0)
	{
		
		if($bar_id > 0 && is_numeric($bar_id))
		{
			$this->db->select('*');
			$this->db->from('liquor_bars');
			$this->db->join('liquors','liquor_suggestion_directory.liquor_suggestion_id=liquor_suggestion_bars.liquor_suggestion_id');
			$this->db->join("bars b","liquor_suggestion_bars.bar_id = b.bar_id","LEFT");
			$this->db->where('liquor_suggestion_bars.bar_id',$bar_id);
			$this->db->where('liquor_suggestion_directory.is_deleted','no');  
			$this->db->order_by("liquor_suggestion_directory.liquor_suggestion_id","desc");
			$this->db->limit($limit,$offset);
		}
		else {
		$this->db->select("*,e.status");
		$this->db->from("liquors e");
		$this->db->join("bars b","e.bar_id = b.bar_id","LEFT");
		$this->db->where('e.is_deleted','no');
		$this->db->where('e.status','pending');
		$this->db->order_by("liquor_id","desc");
		$this->db->limit($limit,$offset);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	
	/* search liquor_suggestion doctor wise
	 * param:doctor id,option ,keyword
	 */	
	function get_total_search_liquor_suggestion_count($option,$keyword,$bar_id = 0)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('liquors.*');
		$this->db->from('liquors');
		if($bar_id > 0 && is_numeric($bar_id))
		{
			$this->db->where("bar_id",$bar_id);
		}
		
		if($option=='liquor_title')
		{
			$this->db->like('liquor_title',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('liquor_title',$val);
				// }	
			// }

		}

       
	//	$this->db->order_by('liquor_suggestion_id','desc');
		$this->db->where('is_deleted','no');
		$this->db->where('status','pending');
		$query = $this->db->get();
		
		
		return $query->num_rows();
	}
	
	
	
	/* search liquor_suggestion doctor wise
	 * param:doctor id,option ,keyword
	 */		
	function get_search_liquor_suggestion_result($option,$keyword,$offset, $limit,$bar_id = 0)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('*,liquors.status');
		$this->db->from('liquors');
		$this->db->join("bars b","liquors.bar_id = b.bar_id","LEFT");
		if($option=='liquor_title')
		{
			$this->db->like('liquor_title',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('liquor_title',$val);
				// }	
			// }

		}

      
		
		$this->db->where('liquors.is_deleted','no');  
		$this->db->order_by('liquor_id','desc');
		$this->db->order_by('liquors.status','pending');
		$this->db->limit($limit,$offset);
		
		$query = $this->db->get();
		
		
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
	
	function getallliquor_suggestion($bars_id)
	{
		$this->db->select('*');
		$this->db->from('liquor_suggestion_directory');
		$this->db->where('status','active');
		$this->db->where('is_deleted','no');
		$this->db->where('status','pending');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
	}
		return 0;
	}
	
	 function get_one_liquor_suggestion($id)
	{
		
		$query = $this->db->get_where('liquors',array('is_deleted'=>'no','status'=>'pending','liquor_id'=>$id));
		return $query->row_array();
	}	
	
}
?>