<?php
class Postcard_model extends CI_Model {
	
    function Postcard_model()
    {
        parent::__construct();	
    }   	
	/* add postcard detail in db **/	
	function postcard_insert()
	{
		$data["postcard_title"] = $this->input->post('postcard_title');
		$data["postcard_desc"] = $this->input->post('postcard_desc');
		$data["user_id"] = get_authenticateadminID();
		$data["author_name"] = 'admin';
		$data["postcard_category"] =$this->input->post('postcard_category');
		$data["status"] = $this->input->post('status');
		$this->db->insert('bar_post_card',$data);
		$postcard_id = mysql_insert_id();
	}
	
	/* postcard update  */
	function postcard_update()
	{
		$data["postcard_title"] = $this->input->post('postcard_title');
		$data["postcard_desc"] = $this->input->post('postcard_desc');
		$data["user_id"] = get_authenticateadminID();
		$data["author_name"] = 'admin';
		$data["postcard_category"] =$this->input->post('postcard_category');
		$data["status"] = $this->input->post('status');
				
		$this->db->where('postcard_id',$this->input->post('postcard_id'));
		$this->db->update('bar_post_card',$data);
	}
	
	/* get postcard info * param : postcard id */		
	function get_one_postcard($id)
	{
		$this->db->select('*,u.first_name,u.last_name,u.email,b.address as address,b.zipcode as zipcode,b.city as city,b.state as state'); 
		$this->db->from('bar_post_card a');
		$this->db->join('bars b', 'b.bar_id = a.bar_id', 'left');
		$this->db->join('user_master u', 'u.user_id = a.user_id');
		$this->db->where('a.postcard_id',$id); 
		$query = $this->db->get();		
		return $query->row_array();
		//$query = $this->db->get_where('bar_post_card',array('postcard_id'=>$id));
		//return $query->row_array();
	}	
	
	/* get total postcards
	 * param :doctor id
	 */
	function get_total_postcard_count($bar_id = 0)
	{
		 
		$this->db->select('*');
		$this->db->from('bar_post_card');
		if($bar_id > 0 && is_numeric($bar_id))
		{
				$this->db->where('bar_id',$bar_id); 
		}
		$this->db->where('is_delete','0'); 
		 
		$query = $this->db->get();		
		return $query->num_rows();
	}
	
	/* get postcard doctor wise
	 * param : doctor id
	 */
	function get_postcard_result($offset,$limit,$bar_id = 0)
	{
	/*
		$this->db->select('bars.bar_title,user_master.first_name,user_master.last_name,postcard.*');
		$this->db->from('postcard');
		$this->db->join('bars b', 'b.bar_id = postcard.bar_id'); 
		//$this->db->join('user_master u', 'u.user_id = postcard.user_id'); 
		$this->db->limit($limit,$offset);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return '';
		*/
		
		$this->db->select('a.*,b.bar_title,u.first_name,u.last_name'); 
		$this->db->from('bar_post_card a');
		$this->db->join('bars b', 'b.bar_id = a.bar_id', 'left');
		$this->db->join('user_master u', 'u.user_id = a.user_id');
		if($bar_id > 0 && is_numeric($bar_id))
		{
				$this->db->where('a.bar_id',$bar_id); 
		}
		$this->db->where('a.is_delete','0'); 
		$this->db->order_by('postcard_id','desc');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		//echo $this->db->last_query();
		return $query->result();
	}	
	
	/* search postcard doctor wise
	 * param:doctor id,option ,keyword
	 */	
	function get_total_search_postcard_count($option,$keyword,$bar_id = 0)
	{
		$en='';
		$en1='';
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('a.*,b.bar_title,u.first_name,u.last_name'); 
		$this->db->from('bar_post_card a');
		$this->db->join('bars b', 'b.bar_id = a.bar_id', 'left');
		$this->db->join('user_master u', 'u.user_id = a.user_id');
		if($bar_id > 0 && is_numeric($bar_id))
		{
				$this->db->where('a.bar_id',$bar_id); 
		}
		$this->db->where('a.is_delete','0'); 
		
		if($option=='bar_title')
		{
			$this->db->like('b.bar_title',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('bar_title',$val);
				// }	
			// }

		}

		if($option=='name')
		{
		//	$en.=" `first_name` like ('".$keyword."%') OR `last_name` like ('".$keyword."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
			//$this->db->where('('.substr($en, 0 ,-3).')')  ;
			$this->db->like('u.first_name',$keyword,'after');
		}

		$query = $this->db->get();	
		return $query->num_rows();
	}	
	
	/* search postcard doctor wise * param:doctor id,option ,keyword  */		
	function get_search_postcard_result($option,$keyword,$offset, $limit,$bar_id = 0)
	{
		$en='';
		$en1='';
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('a.*,b.bar_title,u.first_name,u.last_name'); 
		$this->db->from('bar_post_card a');
		$this->db->join('bars b', 'b.bar_id = a.bar_id', 'left');
		$this->db->join('user_master u', 'u.user_id = a.user_id');
		if($bar_id > 0 && is_numeric($bar_id))
		{
				$this->db->where('a.bar_id',$bar_id); 
		}
		$this->db->where('a.is_delete','0'); 
		
		if($option=='bar_title')
		{
			$this->db->like('b.bar_title',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('bar_title',$val);
				// }	
			// }

		}

		if($option=='name')
		{
		//	$en.=" `first_name` like ('".$keyword."%') OR `last_name` like ('".$keyword."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
			//$this->db->where('('.substr($en, 0 ,-3).')')  ;
			$this->db->like('u.first_name',$keyword,'after');
		}
		$this->db->limit($limit,$offset);
		
		$query = $this->db->get();
	
		
	//	echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}	  
}
?>