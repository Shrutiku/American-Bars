<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Shopping_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	/*
	 *  This function is use for get all product data
	 */
	function getAllproduct()
	{
		$query = $this->db->select('*')
		                  ->from('product')
						  ->join('category','category.category_id=product.category_id','left')
						  ->where('product.status','Active')
						  ->order_by('product_id','desc'); 
		
		$query = $this->db->get();				  
	    if($query->num_rows()>0)
		{
			return $query->result();
		}					  
		else {
			return '';
		}
	}
	
	
	/*
	 *  This function is use for get all product data by sale
	 */
	function getSaleproduct($type='')
	{
		$query = $this->db->select('*')
		                  ->from('product')
						  ->join('category','category.category_id=product.category_id','left')
						  ->where('product.status','Active')
						  ->where('product_type',$type)
						  ->order_by('product_id','desc'); 
		
		$query = $this->db->get();				  
	    if($query->num_rows()>0)
		{
			return $query->result();
		}					  
		else {
			return '';
		}
	}
	
	
	
	function getOrderDetails($id)
	{
		$query = $this->db->select('*,order_detail.quantity as qe')
		                  ->from('order_detail')
						  ->join('store','store.store_id=order_detail.product_id','left')
						  ->where('order_detail.order_id',$id);
		
		$query = $this->db->get();				  
	    if($query->num_rows()>0)
		{
			return $query->result();
		}					  
		else {
			return '';
		}
	}
	/*
	 *  This function is use for get all product data by search keyword
	 */
	function getProductBySearch($searchtype="")
	{
		$keyword = $this->input->post('keyword'); 
		$type = $this->input->post('type'); 
		$state_id = $this->input->post('state_id'); 
		if($type == '') { $type = $searchtype; }
		$keyword=str_replace('-',' ',$keyword);
		$amount = substr($this->input->post('type'),1);
		$vintage = $this->input->post('vintage');
		$variety = $this->input->post('variety');
		$range = $this->input->post('range');
		
		$this->db->select('*');
		$this->db->from('product');
		$this->db->join('category','category.category_id=product.category_id','left');
		$this->db->where('product.status','Active');
		if($type!="")
		{
			$this->db->where('product_type',$type);
		}
		if($keyword!='')
		{
			$lk='';
			$ex=explode(' ',$keyword);
			if(count($ex)>=2)
			{
					$lk.=" product_name like '".$keyword."' and ";
				foreach($ex as $val)
				{
					$lk.=" product_name like '%".$val."%' OR ";
				}
			$lk=substr($lk,0,-3);	
			}else{
				
				$lk.=" product_name like '%".$keyword."%' ";
			}
		//$this->db->like('association_name',$keyword);
			$this->db->where("(".$lk.")");
		}
		 if($state_id!="" && $state_id!=0)
		{
					$this->db->where('product.state_id',$state_id);
		}
        if($range!="" && $range!=0)
		{
			$this->db->where('category.parent_id',$range);
		}
		if($vintage)
		{
			$this->db->where('vintage',$vintage);
		}

		if($variety)
		{
			$this->db->where('product.category_id',$variety);
		}

		if($amount>1)
		{
			$this->db->where('product_price <=',$amount);
		}

		$this->db->order_by("product_id", "desc"); 
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}


    function getcatByParentID()
	{
		$str='<option value="">Select Variety</option>';
		
		$this->db->select('c.category_id,c.category_name');
		$this->db->from('category c');
		$this->db->join('product p','p.category_id=c.category_id');
		$this->db->where('p.status','Active');
		$this->db->where('c.parent_id',$this->input->post('id'));
		$this->db->group_by('c.category_id');
		$q = $this->db->get();
		
		if($q->num_rows()>0)
		{
			foreach ($q->result() as $pc) {
						$str.='<option value="'.$pc->category_id.'">'.ucwords($pc->category_name).'</option>';	
			}
		}
		return $str;
	}
	
	function getOneProduct($id)
	{
		$query = $this->db->select('*')
		                  ->from('store')
						  ->where('store.store_id',$id);
		
		$query = $this->db->get();				  
	    if($query->num_rows()>0)
		{
			return $query->row_array();
		}					  
		else {
			return '';
		}
	}

	/*
	 *  This function is use for get all order history data
	 */
	function getOrderHistory($limit,$offset)
	{
		$query = $this->db->select('*')
		                  ->from('order_master')	
						  ->where('user_id',get_authenticateUserID())						 
						  ->order_by('order_id','desc') 
						  ->limit($limit,$offset);
		
		$query = $this->db->get();	
		
		//echo $this->db->last_query();			  
	    if($query->num_rows()>0)
		{
			return $query->result();
		}					  
		else {
			return '';
		}
	}
	
	/*
	 *  This function is use for get all review history data
	 */
	function getReviewHistory($limit,$offset)
	{
		$query = $this->db->select('*')
		                  ->from('review')
						  ->where('user_id',get_authenticateUserID())		
						  ->where('order_id !=',0)						 
						  ->order_by('review_id','desc') 
						  ->limit($limit,$offset);
		
		$query = $this->db->get();				  
	    if($query->num_rows()>0)
		{
			return $query->result();
		}					  
		else {
			return '';
		}
	}
	
	/*
	 *  This function is use for get all transaction history data
	 */
	function getTransactionHistory($limit,$offset)
	{
		$query = $this->db->select('*')
		                  ->from('transaction')	
						  ->where('user_id',get_authenticateUserID())						 
						  ->order_by('transaction_id','desc') 
						  ->limit($limit,$offset);
		
		$query = $this->db->get();				  
	    if($query->num_rows()>0)
		{
			return $query->result();
		}					  
		else {
			return '';
		}
	}
	
	/*
	 *  This function is use for get all Favorite history data
	 */
	function getFavoriteHistory($limit,$offset)
	{
		$query = $this->db->select('*')
		                  ->from('favorite')
						  ->where('is_deleted', 0)						 
						  ->order_by('id','desc') 
						  ->limit($limit,$offset);
		
		$query = $this->db->get();				  
	    if($query->num_rows()>0)
		{
			return $query->result();
		}					  
		else {
			return '';
		}
	}
	
	/*
	 *  This function is use for get all transaction history data
	 */
	function getOrderDetail($id)
	{
		$query = $this->db->select('*')
		                  ->from('order_detail')						 
						  ->where('order_id',$id);
		
		$query = $this->db->get();				  
	    if($query->num_rows()>0)
		{
			return $query->result();
		}					  
		else {
			return '';
		}
	}

	function get_total_product_count($keyword = 0, $alpha ='')
	{
		$this->db->select("*");
		$this->db->from("store");
		$this->db->where('status','active');
		$this->db->where('type','adbstore');
		if($alpha != "" && $alpha != "no")
		{
		   $this->db->like("product_name",$alpha,"after");
		}
		
		if($keyword != '0')
		{
			$this->db->like("product_name",$keyword);
		}		
		$qry = $this->db->get();		
		return $qry->num_rows();
	}
	
	function get_product_result($offset = 0,$limit = 0,$sort_by= '',$sort_type = '',$keyword = 0,$alpha ='')
	{
		$this->db->select('*');
		$this->db->from("store");
		$this->db->where('status','active');
		$this->db->where('type','adbstore');
		if($alpha != "" && $alpha != "no")
		{
		   $this->db->like("product_name",$alpha,"after");
		}
		
		if($keyword != '0')
		{
			$this->db->like("product_name",$keyword);
		}
		
		$this->db->order_by($sort_by,$sort_type);
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		
		if($qry->num_rows()>0)
		{
			 return $qry->result();
		}
		
		
		return 0;
	}


     function getGalleryImages($store_id)
	 {
	 	 $this->db->select('*');
		 $this->db->from('product_images');
		 $this->db->where('product_id',$store_id);
		 $query = $this->db->get();
		 if($query->num_rows()>0)
		 {
		 	return $query->result();
		 }
		 return '';
	 } 
	
}	