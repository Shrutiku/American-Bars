<?php 
if (! defined('BASEPATH')) exit('No direct script access allowed');
class Adborder_model extends CI_Model {
	/* start of get Total Order
	 * 
	 */
	function getTotalOrder()
	{
		$this->db->distinct();
		$this->db->from('order_master');
		$this->db->join('user_master','user_master.user_id=order_master.user_id');
		$this->db->join('order_detail','order_detail.order_id=order_master.order_id','left');
		$this->db->join('store','order_detail.product_id=store.store_id','left');
		$this->db->select('order_master.order_id, order_number, order_date, order_master.status, order_master.total, first_name, email');
		$this->db->where('order_master.is_deleted',"N");
		$this->db->where('order_detail.bar_id =',"0");
		
		
		$this->db->where('store.bar_id =',"0");
		////$this->db->group_by('order_detail.bar_id');
		
		$query=$this->db->get();
		//echo $this->db->last_query();die;
		if($query->num_rows()>0)
		{
			return $query->num_rows();
		}else{ return 0; }
		
	}
	/* end of grtTotal Order */
/*start of getOrderResult
	 * used for get total rows of order
	 */ 
	function getOrderResult($limit=0,$offset=0)
	{
		$this->db->distinct();
		$this->db->from('order_master');
		$this->db->join('user_master','user_master.user_id=order_master.user_id');
		$this->db->join('order_detail','order_detail.order_id=order_master.order_id','left');
		$this->db->join('store','order_detail.product_id=store.store_id','left');
		$this->db->select('order_master.order_id, order_number, order_date, order_master.status, order_master.total, first_name, email');
		$this->db->where('order_master.is_deleted',"N");
		$this->db->where('order_detail.bar_id =',"0");
		$this->db->where('store.bar_id =',"0");
		$this->db->limit($limit,$offset);
		$this->db->order_by('order_master.order_id','desc');
		//////$this->db->group_by('order_detail.bar_id');
		$query=$this->db->get();
		//$query=$this->db->get('order_master',$limit,$offset);
		//echo $this->db->last_query();die;
		if($query->num_rows()>0)
		{
			return $query->result();
		}else{ return ''; }
		
	}
	//end of getorderResult
	
	//start of get_one_order
	function get_one_order($id=0,$limit=0,$offset=0)
	{
		$this->db->select('*');
		$this->db->join('order_detail','order_detail.order_id=order_master.order_id','left');
		$this->db->join('user_master','user_master.user_id=order_master.user_id','left');
		
		//$this->db->join('country_master','country_master.country_id=user.country_id','left');
		//$this->db->join('state_master','state_master.state_id=user.state_id','left');
		$this->db->join('store','store.store_id=order_detail.product_id','left');
		$this->db->select('order_master.order_id, order_number, order_date, order_master.status, order_master.total, first_name,last_name, email, order_detail.price, order_detail.total, order_detail.quantity ');
	  	$this->db->where('order_master.is_deleted',"N");
		
	  	$query = $this->db->get_where('order_master',array("order_master.order_id"=>$id));
		//echo $this->db->last_query();die;
		//return $query->row_array();
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return 0;
	}
	//end of get_one_order
	
	/*
	 * Function:get_total_search_order_count
	 * Description: no of record for search
	 */
	function get_total_search_order_count($option,$keyword,$keyword_date,$from_date,$to_date)
	{
		$this->db->distinct();
		//$keyword=str_replace('-',' ',$keyword);
		if($option=="first_name" && $keyword!='1V1')
				{
				$this->db->like('user_master.first_name',$keyword,'after');
						
						// if(substr_count($keyword,' ')>=1)
						// {
							// $ex=explode(' ',$keyword);
// 							
							// foreach($ex as $val)
							// {
								// $this->db->like('user_master.first_name',$val);
							// }	
						// }
			   }
		
		if($option=="status" && $keyword!='1V1')
				{
				$this->db->like('order_master.status',$keyword,'after');
						
						// if(substr_count($keyword,' ')>=1)
						// {
							// $ex=explode(' ',$keyword);
// 							
							// foreach($ex as $val)
							// {
								// $this->db->like('order_master.status',$val);
							// }	
						// }
			   }
		$this->db->order_by("order_id", "desc"); 
		
		
		
		$this->db->from('order_master');
		$this->db->join('order_detail','order_detail.order_id=order_master.order_id');
		$this->db->join('user_master','user_master.user_id=order_master.user_id');
		$this->db->join('store','order_detail.product_id=store.store_id','left');
		$this->db->select('order_master.order_id, order_number, order_date, order_master.status, order_master.total, first_name, email');
		$this->db->where('order_master.is_deleted',"N");
		$this->db->where('order_detail.bar_id =',"0");
		$this->db->where('store.bar_id =',"0");
		if($from_date!="" && $to_date!="" && $from_date!="1V1" && $to_date!="1V1")
		{
			$this->db->where('order_master.order_date >=',$from_date);
			$this->db->where('order_master.order_date <=',$to_date);
		}
		
		$this->db->order_by('order_master.order_id','desc');
		////$this->db->group_by('order_detail.bar_id');
		$query=$this->db->get();
		return $query->num_rows();
	}
	//end of get_search_order_result
	
	/*
	 * Function:get_search_order_result
	 * Description: search record
	 */
	function get_search_order_result($option,$keyword,$offset, $limit,$keyword_date,$from_date,$to_date)
	{
		//$keyword=str_replace('-',' ',$keyword);
		//echo $keyword;
		//die;
		$this->db->distinct();
		if($option=="first_name" && $keyword!='1V1')
				{
				$this->db->like('user_master.first_name',$keyword,'after');
						
						// if(substr_count($keyword,' ')>=1)
						// {
							// $ex=explode(' ',$keyword);
// 							
							// foreach($ex as $val)
							// {
								// $this->db->like('user_master.first_name',$val);
							// }	
						// }
			   }
		
		if($option=="status" && $keyword!='1V1')
				{
				$this->db->like('order_master.status',$keyword,'after');
						
						// if(substr_count($keyword,' ')>=1)
						// {
							// $ex=explode(' ',$keyword);
// 							
							// foreach($ex as $val)
							// {
								// $this->db->like('order_master.status',$val);
							// }	
						// }
			   }
				
		$this->db->order_by("order_id", "desc"); 
		$this->db->from('order_master');
		$this->db->join('order_detail','order_detail.order_id=order_master.order_id');
		$this->db->join('user_master','user_master.user_id=order_master.user_id');
		$this->db->join('store','order_detail.product_id=store.store_id','left');
		$this->db->select('order_master.order_id, order_number, order_date, order_master.status, order_master.total, first_name, email');
		$this->db->where('order_master.is_deleted',"N");
		$this->db->where('order_detail.bar_id =',"0");
		$this->db->where('store.bar_id =',"0");
		if($from_date!="" && $to_date!="" && $from_date!="1V1" && $to_date!="1V1")
		{
			$this->db->where('order_master.order_date >=',$from_date);
			$this->db->where('order_master.order_date <=',$to_date);
		}
		$this->db->limit($limit,$offset);
		$this->db->order_by('order_master.order_id','desc');
		////$this->db->group_by('order_detail.bar_id');
		$query=$this->db->get();
		
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
	//end of get_search_order_result
	
	/*
	 * Function:downloadOrder
	 * Description: used for download order data in csv
	 */
	function downloadOrder()
	{
		$this->db->from('order_master');
		$this->db->join('user_master','user_master.user_id=order_master.user_id');
		$this->db->select('order_number as "Order No", order_date as "Order Date", first_name as "Username", email as "Email", order_master.total as "Total($)", order_master.status as "Status"');
		$this->db->where('order_master.is_deleted',"N");
		$query = $this->db->get();

		//echo $this->db->last_query();die;
		if($query->num_rows()>0)
		{
			return $query;
		}
		else
		{
			return ''; 
		}
		
	}
	//end of downloadOrder function
	
	/*
	* function : orderStaus  
    * description :for order status.
    */
    function changeOrderStatus($order_id,$order_status){
    	// require_once(APPPATH.'paypal-php-library-master/includes/config.php');
		// require_once(APPPATH.'paypal-php-library-master/includes/paypal.class.php');
		// $gettransactionID = $this->gettransactionID($order_id); 
	     $getOrederDetails = $this->getOrederDetails($order_id); 
		// if($order_status=="Canceled1")
		// {
			// $PayPalConfig = array(
					// 'Sandbox' => $sandbox,
					// 'APIUsername' => $api_username,
					// 'APIPassword' => $api_password,
					// 'APISignature' => $api_signature
					// );
// 
			// $PayPal = new PayPal($PayPalConfig);
// 			
			// $RTFields = array(
					// 'transactionid' => $gettransactionID['txn_id'], 							// Required.  PayPal transaction ID for the order you're refunding.
					// 'invoiceid' => '', 								// Your own invoice tracking number.
					// 'refundtype' => 'Partial', 							// Required.  Type of refund.  Must be Full, Partial, or Other.
					// 'amt' => $gettransactionID['amount'] + ($gettransactionID['amount']*2.90/100)  - $gettransactionID['amount']/10, 									// Refund Amt.  Required if refund type is Partial.  
					// 'currencycode' => '', 							// Three-letter currency code.  Required for Partial Refunds.  Do not use for full refunds.
					// 'note' => '',  									// Custom memo about the refund.  255 char max.
					// 'retryuntil' => '', 							// Maximum time until you must retry the refund.  Note:  this field does not apply to point-of-sale transactions.
					// 'refundsource' => '', 							// Type of PayPal funding source (balance or eCheck) that can be used for auto refund.  Values are:  any, default, instant, eCheck
					// 'merchantstoredetail' => '', 					// Information about the merchant store.
					// 'refundadvice' => '', 							// Flag to indicate that the buyer was already given store credit for a given transaction.  Values are:  1/0
					// 'refunditemdetails' => '', 						// Details about the individual items to be returned.
					// 'storeid' => '', 								// ID of a merchant store.  This field is required for point-of-sale transactions.  50 char max.
					// 'terminalid' => ''								// ID of the terminal.  50 char max.
				// );
// 				
			// $PayPalRequestData = array('RTFields'=>$RTFields);
			// $PayPalResult = $PayPal->RefundTransaction($PayPalRequestData);	
// 			
// 			
		// }
// 
        // if($PayPalResult!="Failure" && $order_status=="Canceled")
		// {
				// $data=array(
				// 'status'=>$order_status,
				// );
				// $this->db->where('order_id', $order_id);
				// $this->db->update('order_master', $data);
// 				
				// if($getOrederDetails)
				// {
					 // /*Mail Send*/
			            // $email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Order Cancelled Successfully'");
			            // $email_temp=$email_template->row();             
			            // $email_address_from=$email_temp->from_address;
			            // $email_address_reply=$email_temp->reply_address;
// 			                    
			            // $email_subject=$email_temp->subject;                
			            // $email_message=$email_temp->message;
// 			                    
			            // $email = $getOrederDetails['email'];//"php.developer@spaculus.com";
			            // //$site_name = $site_data->site_name;
			            // $email_to =$email;
			            // $user_name =   $getOrederDetails['first_name']." ".$getOrederDetails['last_name'];
			            // $email_message=str_replace('{break}','<br/>',$email_message);
			            // $email_message=str_replace('{username}',$user_name,$email_message);
			            // $email_message=str_replace('{ordernumber}',$getOrederDetails['order_number'],$email_message); 
			            // $str=$email_message;
			            // //echo $str;exit;
			            // /** custom_helper email function **/
// 			                                        
			            // email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
				// }
		// }
		// else if($order_status!="Canceled") {
				if($order_status=='Completed')
			{
						 $email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Order Completed Successfully'");
			            $email_temp=$email_template->row();             
			            $email_address_from=$email_temp->from_address;
			            $email_address_reply=$email_temp->reply_address;
			                    
			            $email_subject=$email_temp->subject;                
			            $email_message=$email_temp->message;
			                    
			            $email = $getOrederDetails['email'];//"php.developer@spaculus.com";
			            //$site_name = $site_data->site_name;
			            $email_to =$email;
			            $user_name =   $getOrederDetails['first_name']." ".$getOrederDetails['last_name'];
			            $email_message=str_replace('{break}','<br/>',$email_message);
			            $email_message=str_replace('{username}',$user_name,$email_message);
			            $email_message=str_replace('{orderno}',$getOrederDetails['order_number'],$email_message); 
			            $str=$email_message;
			            //echo $str;exit;
			            /** custom_helper email function **/
			             if($email_temp->status=='active'){                           
			            email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
						 }
						 $email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Order Completed Successfully Email To Admin'");
			            $email_temp=$email_template->row();             
			            $email_address_from=$email_temp->from_address;
			            $email_address_reply=$email_temp->reply_address;
			                    
			            $email_subject=$email_temp->subject;                
			            $email_message=$email_temp->message;
			                    
			             $email = getsuperadminemail();
			            //$site_name = $site_data->site_name;
			            $email_to =$email;
			            $user_name =   $getOrederDetails['first_name']." ".$getOrederDetails['last_name'];
			            $email_message=str_replace('{break}','<br/>',$email_message);
			            $email_message=str_replace('{username}',$user_name,$email_message);
			            $email_message=str_replace('{orderno}',$getOrederDetails['order_number'],$email_message); 
			            $str=$email_message;
			            //echo $str;exit;
			            /** custom_helper email function **/
			                                        
			          $getemail = explode(',', $email);
				if($email_temp->status=='active'){
				foreach($getemail as $r){
					if($email_temp->status=='active'){
					email_send($email_address_from, $email_address_reply, $r, $email_subject, $str);
				}
				}
			}
			
			$data=array(
				'status'=>$order_status,
				);
			$this->db->where('order_id', $order_id);
			$this->db->update('order_master', $data);	
		}		
		
		
    }
	
	function gettransactionID($order_id)
	{
		//$query = $this->db->get_where('transaction',array('order_id'=>$order_id));
		$this->db->select('*');
		$this->db->from('transaction');
		$this->db->where('order_id',$order_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
		return $query->row_array();
		}
		else {
		 return 0;	
		}	
	}
	
	function getOrederDetails($ord_id)
	{
		$this->db->select('*');
		$this->db->from('order_master');
		$this->db->join('user_master','user_master.user_id=order_master.user_id');
		$this->db->where('order_master.order_id',$ord_id);
		$query = $this->db->get();

		//echo $this->db->last_query();die;
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		else
		{
			return ''; 
		}
	}
	
	function AllOrderDet($id)
	{
		$query = $this->db->select('order_detail.*,order_detail.color_id as colname,order_detail.size_id as sizename,store.*,bars.bar_title as barname,order_detail.quantity as quantity')
		                  ->from('order_detail')
						  ->join('store','store.store_id=order_detail.product_id','left')
						  //->join('Color','Color.Color_id=order_detail.color_id','left')
						  //->join('Size','Size.Size_id=order_detail.size_id','left')
						  ->join('bars','bars.bar_id=order_detail.bar_id','left')
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
	
	function get_one_order_info($id)
	{
		$query = $this->db->select('*,order_master.status as status')
		                  ->from('order_master')
						  ->join('user_master','user_master.user_id=order_master.user_id','left')
						  ->where('order_master.order_id',$id);
		
		$query = $this->db->get();				  
	    if($query->num_rows()>0)
		{
			return $query->row_array();
		}					  
		else {
			return '';
		}
	}
    /**
	 * end of changeOrderStatus
	 **/
	 
    /**
	 * Function :get_total_search_orderdate_count
	 * Desc: For no of record between fro date to to date
	 * Param: form_date, to_date
	 */
	function get_total_search_orderdate_count($option,$from_date,$to_date)
	{
	
		$this->db->join('user_master','user_master.user_id=order_master.user_id');
		$this->db->select('order_master.order_id, order_number, order_date, order_master.status, total, first_name, email');
		//$this->db->where('order_master.order_date BETWEEN "'.$from_date.'" and "'.$to_date.'"');
		$this->db->where('order_master.order_date >=',$from_date);
		$this->db->where('order_master.order_date <=',$to_date);
		$this->db->where('order_master.is_deleted',"N");
		$this->db->from('order_master');
		$query=$this->db->get();
		//echo $this->db->last_query();die;
		return $query->num_rows();
	}
	//end of get_total_search_orderdate_count
	/**
	 * Function :  get_search_orderdate_result
	 * Desc: for order date ratio
	 */
	function get_search_orderdate_result($option,$from_date,$offset, $limit,$to_date)
	{
		
		//$this->db->join('order_detail','order_detail.order_id=order_master.order_id');
		$this->db->join('user_master','user_master.user_id=order_master.user_id');
		$this->db->select('order_master.order_id, order_number, order_date, order_master.status, total, first_name, email');
		//$this->db->where('order_master.order_date BETWEEN "'.$from_date.'" and "'.$to_date.'"');
		$this->db->where('order_master.order_date >=',$from_date);
		$this->db->where('order_master.order_date <=',$to_date);
		$this->db->where('order_master.is_deleted',"N");
		$this->db->limit($limit,$offset);
		$this->db->from('order_master');		
		$query=$this->db->get();
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	
	}//end of get_search_orderdate_result
}
//end of model class
?>