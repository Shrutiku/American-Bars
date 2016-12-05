<?php
class cocktail_suggestion_model extends CI_Model {
	
    function cocktail_suggestion_model()
    {
        parent::__construct();	
    }   
	

	/* get total cocktail_suggestions
	 * param :doctor id
	 */
	 function get_one_cocktail_suggestion($id)
	{
		
		$query = $this->db->get_where('cocktail_directory',array('is_deleted'=>'no','status'=>'pending','cocktail_id'=>$id));
		return $query->row_array();
	}	
	
	function get_total_cocktail_suggestion_count($bar_id = 0)
	{
		//$this->db->where('is_deleted','no');
		if($bar_id > 0 && is_numeric($bar_id))
		{
			//$query = $this->db->get_where('beer_directory',array('is_deleted'=>'no',"bar_id"=>$bar_id));
			$this->db->select('*');
			$this->db->from('cocktail_bars');
			$this->db->join('cocktail_directory','cocktail_directory.cocktail_id=cocktail_bars.cocktail_id');
			$this->db->where('cocktail_bars.bar_id',$bar_id);
			$this->db->where('cocktail_directory.is_deleted','no');
			$query= $this->db->get();
		}
       else
       {
		$query = $this->db->get_where('cocktail_directory',array('is_deleted'=>'no','status'=>'pending'));
	   }
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}
		return 0;
	}
	
	
	/* get cocktail_suggestion doctor wise
	 * param : doctor id
	 */
	function get_cocktail_suggestion_result($offset,$limit,$bar_id = 0)
	{
		
		if($bar_id > 0 && is_numeric($bar_id))
		{
			$this->db->select('*');
			$this->db->from('cocktail_bars');
			$this->db->join('cocktail_directory','cocktail_suggestion_directory.cocktail_suggestion_id=cocktail_suggestion_bars.cocktail_suggestion_id');
			$this->db->join("bars b","cocktail_suggestion_bars.bar_id = b.bar_id","LEFT");
			$this->db->where('cocktail_suggestion_bars.bar_id',$bar_id);
			$this->db->where('cocktail_suggestion_directory.is_deleted','no');  
			$this->db->order_by("cocktail_suggestion_directory.cocktail_suggestion_id","desc");
			$this->db->limit($limit,$offset);
		}
		else {
		$this->db->select("*,e.status");
		$this->db->from("cocktail_directory e");
		$this->db->join("bars b","e.bar_id = b.bar_id","LEFT");
		$this->db->where('e.is_deleted','no');
		$this->db->where('e.status','pending');
		$this->db->order_by("cocktail_id","desc");
		$this->db->limit($limit,$offset);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	
	/* search cocktail_suggestion doctor wise
	 * param:doctor id,option ,keyword
	 */	
	function get_total_search_cocktail_suggestion_count($option,$keyword,$bar_id = 0)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('cocktail_directory.*');
		$this->db->from('cocktail_directory');
		if($bar_id > 0 && is_numeric($bar_id))
		{
			$this->db->where("bar_id",$bar_id);
		}
		
		if($option=='cocktail_name')
		{
			$this->db->like('cocktail_name',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('cocktail_name',$val);
				// }	
			// }

		}

       
	//	$this->db->order_by('cocktail_suggestion_id','desc');
		$this->db->where('is_deleted','no');
		$this->db->where('status','pending');
		$query = $this->db->get();
		
		
		return $query->num_rows();
	}
	
	
	
	/* search cocktail_suggestion doctor wise
	 * param:doctor id,option ,keyword
	 */		
	function get_search_cocktail_suggestion_result($option,$keyword,$offset, $limit,$bar_id = 0)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('*,cocktail_directory.status');
		$this->db->from('cocktail_directory');
		$this->db->join("bars b","cocktail_directory.bar_id = b.bar_id","LEFT");
		if($option=='cocktail_name')
		{
			$this->db->like('cocktail_name',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('cocktail_name',$val);
				// }	
			// }

		}

      
		
		$this->db->where('cocktail_directory.is_deleted','no');  
		$this->db->order_by('cocktail_id','desc');
		$this->db->order_by('cocktail_directory.status','pending');
		$this->db->limit($limit,$offset);
		
		$query = $this->db->get();
		
		
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
	
	function getallcocktail_suggestion($bars_id)
	{
		$this->db->select('*');
		$this->db->from('cocktail_suggestion_directory');
		$this->db->where('status','active');
		$this->db->where('is_deleted','no');
		$this->db->where('status','pending');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
	}
		return 0;
	}
}
?>