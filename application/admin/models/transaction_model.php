<?php

class Transaction_model extends CI_Model {

	function Transaction_model()
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
		$this->db->insert('transaction', $form_data);
		
		if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
    function transaction_insert()
	{
	 
	  $data_array=array();
					  $data_insert["transaction_title"] = $this->input->post('transaction_title');
					  $data_insert["transaction_desc"] = $this->input->post('transaction_desc');
					  $data_insert["transaction_price"] = $this->input->post('transaction_price');
					  
				
				 $transactionname="";
		 if($_FILES["file_up_transaction"]["name"]!="")
         {
             $this->load->library("upload");
             $rand=rand(0,100000); 
			  
             $_FILES["userfile"]["name"]     =   $_FILES["file_up_transaction"]["name"];
             $_FILES["userfile"]["type"]     =   $_FILES["file_up_transaction"]["type"];
             $_FILES["userfile"]["tmp_name"] =   $_FILES["file_up_transaction"]["tmp_name"];
             $_FILES["userfile"]["error"]    =   $_FILES["file_up_transaction"]["error"];
             $_FILES["userfile"]["size"]     =   $_FILES["file_up_transaction"]["size"];
   
		
			
			$config["file_name"] = $this->input->post('file_up_transaction').$rand;
		 
            $config['upload_path']=base_path()."upload/transaction";
			
            $config['allowed_types'] = 'avi|wmv|mpeg|mpg|mp4';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();
				//echo $error ; die;   
			  } 
			 
           	    $picture = $this->upload->data();
			    $transactionname=$picture["file_name"];
		        $data_insert["transaction_file_name"] = $transactionname;
                }
				
			$transaction_preview="";
		 if($_FILES["transaction_preview"]["name"]!="")
         {
             $this->load->library("upload");
             $rand=rand(0,100000); 
			  
             $_FILES["userfile"]["name"]     =   $_FILES["transaction_preview"]["name"];
             $_FILES["userfile"]["type"]     =   $_FILES["transaction_preview"]["type"];
             $_FILES["userfile"]["tmp_name"] =   $_FILES["transaction_preview"]["tmp_name"];
             $_FILES["userfile"]["error"]    =   $_FILES["transaction_preview"]["error"];
             $_FILES["userfile"]["size"]     =   $_FILES["transaction_preview"]["size"];
   
		
			
			$config["file_name"] = $this->input->post('transaction_preview').$rand;
		 
            $config['upload_path']=base_path()."upload/transaction_preview";
			
            $config['allowed_types'] = 'avi|wmv|mpeg|mpg|mp4';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			 
           	    $picture1 = $this->upload->data();
			    $transaction_preview=$picture1["file_name"];
		        $data_insert["transaction_preview"] = $transaction_preview;
                }			
			
			 $data_insert["transaction_category_id"] = $this->input->post('transaction_category_id');
		     $data_insert["transaction_type"] = $this->input->post('transaction_type');
			 $data['status']=$this->input->post('status');
			 $data['date_added']=date('Y-m-d H:i:s');
			 $data['ip']=$_SERVER['REMOTE_ADDR'];
			 //print_r($data_insert); die;
			$this->db->insert('transaction', $data_insert);

	}
	
	function transaction_update()
	{
		
	$data_update=array();
					  $data_update["transaction_title"] = $this->input->post('transaction_title');
					  $data_update["transaction_desc"] = $this->input->post('transaction_desc');
					  $data_update["transaction_price"] = $this->input->post('transaction_price');
					  $data_update["transaction_type"] = $this->input->post('transaction_type');
				
	$transactionname="";		
		 if($_FILES["file_up_transaction"]["name"]!="")
         {
             $this->load->library("upload");
             $rand=rand(0,100000); 
			  
             $_FILES["userfile"]["name"]     =   $_FILES["file_up_transaction"]["name"];
             $_FILES["userfile"]["type"]     =   $_FILES["file_up_transaction"]["type"];
             $_FILES["userfile"]["tmp_name"] =   $_FILES["file_up_transaction"]["tmp_name"];
             $_FILES["userfile"]["error"]    =   $_FILES["file_up_transaction"]["error"];
             $_FILES["userfile"]["size"]     =   $_FILES["file_up_transaction"]["size"];
   
		
			
			$config["file_name"] = $this->input->post('transaction_name').$rand;
		 
            $config['upload_path']=base_path()."upload/transaction";
			
            $config['allowed_types'] = 'avi|wmv|mpeg|mpg|mp4';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			 
           	    $picture = $this->upload->data();
			    $transactionname=$picture["file_name"];
		      //  $data_insert["transaction"] = $transactionname;
			      if($this->input->post("prev_transaction")!="")
				{
					if(file_exists(base_path()."upload/transaction/".$this->input->post("prev_transaction")))
					{
						$link=base_path()."upload/transaction/".$this->input->post("prev_transaction");
						unlink($link);
					}
					
				
				} 
                }
		else {
				if($this->input->post("pre_file_up_transaction"))
				{
					$transactionname=$this->input->post("pre_file_up_transaction");
				}
		   }
			$transaction_preview="";		
		 if($_FILES["file_up_transaction"]["name"]!="")
         {
             $this->load->library("upload");
             $rand=rand(0,100000); 
			  
             $_FILES["userfile"]["name"]     =   $_FILES["file_up_transaction"]["name"];
             $_FILES["userfile"]["type"]     =   $_FILES["file_up_transaction"]["type"];
             $_FILES["userfile"]["tmp_name"] =   $_FILES["file_up_transaction"]["tmp_name"];
             $_FILES["userfile"]["error"]    =   $_FILES["file_up_transaction"]["error"];
             $_FILES["userfile"]["size"]     =   $_FILES["file_up_transaction"]["size"];
   
		
			
			$config["file_name"] = $this->input->post('transaction_name').$rand;
		 
            $config['upload_path']=base_path()."upload/transaction_preview";
			
            $config['allowed_types'] = 'avi|wmv|mpeg|mpg|mp4';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  	//echo $error; die;
			  } 
			 
           	    $picture = $this->upload->data();
			    $transaction_preview=$picture["file_name"];
		      //  $data_insert["transaction"] = $transaction_preview;
			      if($this->input->post("prev_transaction")!="")
				{
					if(file_exists(base_path()."upload/transaction/".$this->input->post("prev_transaction")))
					{
						$link=base_path()."upload/transaction/".$this->input->post("prev_transaction");
						unlink($link);
					}
					
				
				} 
                }
		else {
				if($this->input->post("pre_transaction_preview"))
				{
					$transaction_preview=$this->input->post("pre_transaction_preview");
				}
		   }			
		   
		              $data_update['transaction_file_name']=$transactionname;
			          $data_update['transaction_preview']=$transaction_preview;
					
					  $data_update["transaction_category_id"] = $this->input->post('transaction_category_id');
					  $data_update["transaction_status"] = $this->input->post('status');
					  $data_update["ip_address"] = $_SERVER['REMOTE_ADDR'];
					  $data_update['date_created']=date('Y-m-d H:i:s');
			
	
		$this->db->where("transaction_id",$this->input->post("transaction_id"));
		$this->db->update('transaction',$data_update);
		
	}
	
	function get_total_transaction_count()
	{
	  $this->db->select('*'); 
		$this->db->from('transaction_order a');
		$this->db->join('user_master u', 'u.user_id =a.user_id');
		//$this->db->where('a.user_id !=',0);
		//$this->db->where('user_id !=',0);
		
		$this->db->group_by('a.transaction_id');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	function get_transaction_result($offset=0, $limit=0)
	{
	   $this->db->select('*'); 
		$this->db->from('transaction_order a');
		$this->db->join('user_master u', 'u.user_id =a.user_id');
		//$this->db->where('a.user_id !=',0);
		$this->db->order_by('a.transaction_date','desc');
		$this->db->group_by('transaction_id');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		
		return $query->result();
	}
	
	function get_one_transaction($id=0)
	{
	   $query = $this->db->get_where('transaction_order',array("transaction_id"=>$id));
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return 0;
	}
	
	
	function get_total_search_transaction_count($option,$keyword,$from_date,$to_date)
	{
	  $en='';
		$en1='';
	$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('*');
		$this->db->from('transaction_order a');
		$this->db->join('user_master u',"u.user_id = a.user_id");
			if($from_date!="" && $to_date!="" && $from_date!="1V1" && $to_date!="1V1")
		{
			//$this->db->where('a.transaction_date >=',$from_date);
			//$this->db->where('a.transaction_date <=',$to_date);
			
		$this->db->where("DATE_FORMAT(a.transaction_date, '%Y-%m-%d') >=",$from_date);
			$this->db->where("DATE_FORMAT(a.transaction_date, '%Y-%m-%d') <=",$to_date);
		}
		//$this->db->where('a.user_id !=',0);
		if($option=='username')
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
	
	function get_search_transaction_result($option,$keyword,$offset, $limit,$from_date,$to_date)
	{
		$en='';
		$en1='';
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('*');
		$this->db->from('transaction_order s');
		$this->db->join('user_master u',"u.user_id = s.user_id");
		if($from_date!="" && $to_date!="" && $from_date!="1V1" && $to_date!="1V1")
		{
			$this->db->where("DATE_FORMAT(s.transaction_date, '%Y-%m-%d') >=",$from_date);
			$this->db->where("DATE_FORMAT(s.transaction_date, '%Y-%m-%d') <=",$to_date);
			
			//$this->db->where("s.transaction_date >=",$from_date);
			//$this->db->where("s.transaction_date <=",$to_date);
		}
		//$this->db->where('s.user_id !=',0);
		
		if($option=='username' && $keyword!='1V1')
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


		$this->db->order_by('s.transaction_date','desc');
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
	function downloadPaymentRecord()
	{
		
		
		$this->db->select('u.first_name as "First Name",u.last_name as "Last Name",u.email as "Email",s.price as "Price ($)",s.txn_id as "Transaction ID",s.transaction_date as "Transaction Date",');
		$this->db->from('transaction_order s');
		$this->db->join('user_master u',"u.user_id = s.user_id");
		//$this->db->join('bars b', 'b.owner_id =u.user_id');
		
		$query = $this->db->get();
		
		//echo $this->db->last_query();die;
		return $query;
	}	
	
}
?>
