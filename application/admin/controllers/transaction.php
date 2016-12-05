<?php
class Transaction extends  CI_Controller {
	function Transaction()
	{
		 parent::__construct();	
		$this->load->model('transaction_model');
		
	}
	
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('transaction/list_transaction');
		
		$check_rights=get_rights('list_transaction');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
	}
	
	// Use :This function use for Lost all transaction User.
	// Param :limit,offset,message
	// Return :'N/A'
	function list_transaction($limit='10',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/* 
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('list_transaction');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$this->load->library('pagination');

		
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'transaction/list_transaction/'.$limit.'/';
		$config['total_rows'] = $this->transaction_model->get_total_transaction_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->transaction_model->get_transaction_result($offset,$limit);
		//echo '<pre>';
		//print_r($data['result']); die;
		$data['msg'] = $msg;
		
		$data['offset'] = $offset;
		$data['error']='';
		if($this->input->post('limit') != '')
		{
			$data['limit']=$this->input->post('limit');
		}
		else
		{
			$data['limit']=$limit;
		}
		$data['option']='1V1';
		$data['keyword']='1V1';
		$data['serach_option']='1V1';
		$data['serach_keyword']='1V1';
		$data['search_type']='normal';
		$data['redirect_page']='list_transaction';
	
		
		
		
		
		$data['site_setting'] = site_setting();

		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/transaction/list_transaction',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	// Use :This function use for list transaction by filter.
	// Param :limit,option,keyword,offset,message
	// Return :'N/A'
	function search_list_transaction($limit=20,$option='',$keyword='',$from_date='1V1',$to_date='1V1',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$redirect_page = 'search_list_transaction';
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('search_list_transaction');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$this->load->library('pagination');
		
		if($_POST)
		{		
			$option=$this->input->post('option');
			$keyword=($this->input->post('keyword')!='')?str_replace(" ", "-",trim($this->input->post('keyword'))):'1V1';
			
		}
		else
		{
			$option=$option;
			$keyword=str_replace(" ", "-",trim($keyword));	
		
		}
		 if($this->input->post('from_date')!="" && $this->input->post('to_date')!="" )
		 {
		 	$from_date= date("Y-m-d", strtotime($this->input->post('from_date')));
		 	$to_date= date("Y-m-d", strtotime($this->input->post('to_date')));
		 }
		 else {
		 	
			 $from_date = $from_date;
			 $to_date = $to_date; 
				 
		 }
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',trim($keyword)));

	
		$config['uri_segment']='8';
		$config['base_url'] = base_url().'transaction/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword."/".$from_date."/".$to_date;
		$config['total_rows'] = $this->transaction_model->get_total_search_transaction_count($option,$keyword,$from_date,$to_date);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->transaction_model->get_search_transaction_result($option,$keyword,$offset, $limit,$from_date,$to_date);
		
		
		if($data['result']==0){
		$offset=0;
		$config['uri_segment']='8';
		$config['base_url'] = base_url().'transaction/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword."/".$from_date."/".$to_date;
		$config['total_rows'] = $this->transaction_model->get_total_search_transaction_count($option,$keyword,$from_date,$to_date);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->transaction_model->get_search_transaction_result($option,$keyword,$offset, $limit,$from_date,$to_date);
		}
		
		$data['msg'] = $msg;
		$data['offset'] = $offset;
		$data['site_setting'] = site_setting();
			$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['limit']=$limit;
		$data['option']=$option;
		$data['keyword']=$keyword;
		$data['search_type']='search';
		$data['redirect_page']=$redirect_page;
		
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/transaction/list_transaction',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	function delete_transaction($id=0,$redirect_page='',$option='',$keyword='',$from_date='',$to_date='',$limit=20,$offset=0)
	{
		/*   
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_transaction');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
         $data_log = array("activity_name" => "LOG_DELETE_ADMIN");
         maintain_log($data_log);
		//$this->db->delete('rights_assign',array('transaction_id'=>$id));
		$this->db->delete('transaction_order',array('transaction_id'=>$id));
		if($redirect_page == 'list_transaction')
		{
			
			redirect('transaction/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('transaction/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$from_date.'/'.$to_date.'/'.$offset.'/delete');

		}
        
        /// common function for insert all action//
           $data_log = array("activity_name" => "LOG_DELETE_ADMIN");
           maintain_log($data_log);
	}
	
	
	// Use :This function use for change transaction_status or delete transaction.
	// Param :'N/a'
	// Return :'N/A'
	function action_transaction()
	{
		/* Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('action_transaction');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
		
		$transaction_id =$this->input->post('chk');
		
		if($action=='delete')
		{
             /// common function for insert all action//
           $data_log = array("activity_name" => "LOG_DELETE_ADMIN");
           maintain_log($data_log);
               
                		
			foreach($transaction_id as $id)
			{			
				$this->db->query("delete from ".$this->db->dbprefix('transaction_order')." where transaction_id ='".$id."'");
			}
			
			if($redirect_page == 'list_transaction')
			{
				redirect('transaction/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('transaction/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
            //Log Entry	
            //echo  "mkjmkj"; die;	
           $data_log = array("activity_name" => "LOG_ACTIVE_ADMIN");
           maintain_log($data_log);    
                		
			foreach($transaction_id as $id)
			{			
				$data = array('transaction_status'=>'active');
				$this->db->where('transaction_id',$id);
				$this->db->update('transaction', $data);
			}
			if($redirect_page == 'list_transaction')
			{
				redirect('transaction/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('transaction/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive')
		{
		  //Log Entry        
           $data_log = array("activity_name" => "LOG_INACTIVE_ADMIN");
           maintain_log($data_log);   
                		
			foreach($transaction_id as $id)
			{			
				$data = array('transaction_status'=>'inactive');
				$this->db->where('transaction_id',$id);
				$this->db->update('transaction', $data);
			}
			
			if($redirect_page == 'list_transaction')
			{
				redirect('transaction/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('transaction/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');

			}
		}	
		
	}

  
    
	
function downloadPaymentRecord()
	{
		//echo '<pre>';
		//print_r($_POST);
			
		//	$keyword=($this->input->post('key')!='')?str_replace(' ','-',$this->input->post('key')):'1V1';
		//	$option=($this->input->post('opt')!='')?str_replace(' ','-',$this->input->post('opt')):'1V1';
			
		
		$result=$this->transaction_model->downloadPaymentRecord();
		
		$filename ="Payment.csv";
		$this->load->dbutil();
		$delimiter = ",";
		$newline = "\r\n";
	
	$data=$this->dbutil->csv_from_result($result, $delimiter, $newline);
	$this->load->helper('download');

	force_download($filename, $data);
	}
}


?>