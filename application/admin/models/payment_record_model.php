<?php
class Payment_record_model extends CI_Model {
	
    function Payment_record_model()
    {
        parent::__construct();	
    }   
	
	/* get total payment_records
	 * param :doctor id
	 */
	function get_total_payment_record_count()
	{
		$this->db->select('*'); 
		$this->db->from('transaction a');
		$this->db->join('user_master u', 'u.user_id =a.user_id');
		//$this->db->where('a.user_id !=',0);
		//$this->db->where('user_id !=',0);
		$this->db->group_by('a.transaction_id');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	/* get payment_record doctor wise
	 * param : doctor id
	 */
	function get_payment_record_result($offset,$limit)
	{
		$this->db->select('*,b.bar_title,b.bar_slug');
		$this->db->from('transaction a');
		$this->db->join('user_master u', 'u.user_id =a.user_id');
		$this->db->join('bars b', 'b.owner_id =a.user_id');
		//$this->db->where('a.user_id !=',0);
		$this->db->group_by('transaction_id');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		
		return $query->result();
	}
	
	
	/* search payment_record doctor wise
	 * param:doctor id,option ,keyword
	 */	
	function get_total_search_payment_record_count($option,$keyword,$from_date,$to_date)
	{
		$en='';
		$en1='';
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('*');
		$this->db->from('transaction a');
		$this->db->join('user_master u',"u.user_id = a.user_id");
		
		if($from_date!="" && $to_date!="" && $from_date!="1V1" && $to_date!="1V1")
		{
			//$this->db->where('a.transaction_date >=',$from_date);
			//$this->db->where('a.transaction_date <=',$to_date);
			
		$this->db->where("DATE_FORMAT(a.transaction_date, '%Y-%m-%d') >=",$from_date);
			$this->db->where("DATE_FORMAT(a.transaction_date, '%Y-%m-%d') <=",$to_date);
		}
		//$this->db->where('a.user_id !=',0);
		if($option=='name')
		{
			$en.=" `first_name` like ('".$keyword."%') OR `last_name` like ('".$keyword."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$en1.=" `first_name` like ('".$val."%') OR `last_name` like ('".$val."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en.substr($en1, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
		}
			

		}
		
		$query = $this->db->get();	
		return $query->num_rows();
	}	
	
	/* search payment_record doctor wise * param:doctor id,option ,keyword  */		
	function get_search_payment_record_result($option,$keyword,$offset, $limit,$from_date,$to_date)
	{
		$en='';
		$en1='';
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
			$this->db->select('*,b.bar_title,b.bar_slug');
		$this->db->from('transaction s');
		$this->db->join('user_master u',"u.user_id = s.user_id");
		$this->db->join('bars b', 'b.owner_id =u.user_id');
		//$this->db->where('s.user_id !=',0);
		if($from_date!="" && $to_date!="" && $from_date!="1V1" && $to_date!="1V1")
		{
			$this->db->where("DATE_FORMAT(s.transaction_date, '%Y-%m-%d') >=",$from_date);
			$this->db->where("DATE_FORMAT(s.transaction_date, '%Y-%m-%d') <=",$to_date);
			
			//$this->db->where("s.transaction_date >=",$from_date);
			//$this->db->where("s.transaction_date <=",$to_date);
		}
		if($option=='name' && $keyword!='1V1')
		{
			$en.=" `first_name` like ('".$keyword."%') OR `last_name` like ('".$keyword."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$en1.=" `first_name` like ('".$val."%') OR `last_name` like ('".$val."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en.substr($en1, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
		}
			
		}


		$this->db->order_by('s.transaction_id','desc');
		$this->db->limit($limit,$offset);
		
		$query = $this->db->get();
		
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
	
	function downloadPaymentRecord()
	{
		
		
		$this->db->select('u.first_name as "First Name",u.last_name as "Last Name",b.bar_title as "Bar Name",u.email as "Email",s.price as "Price ($)",s.txn_id as "Transaction ID",s.transaction_date as "Transaction Date",');
		$this->db->from('transaction s');
		$this->db->join('user_master u',"u.user_id = s.user_id");
		$this->db->join('bars b', 'b.owner_id =u.user_id');
		
		$query = $this->db->get();
		
		//echo $this->db->last_query();die;
		return $query;
	}	  
}
?>