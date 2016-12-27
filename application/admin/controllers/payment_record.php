<?php
class payment_record extends  CI_Controller {
	function payment_record()
	{
		parent::__construct();	
		$this->load->model('payment_record_model');	
		$this->load->library('pagination');
	  
	}
	//use:for redirecting at list payment_record page
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('payment_record/list_payment_record');	
	}
	
	/* payment_record list
	 * param  : doctor id ,limit,offset,msg
	 * 
	 */
	function list_payment_record($limit='10',$offset=0,$msg='') {
		
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
		
		$check_rights=get_rights('list_payment_record');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
			$this->load->library('pagination');
		
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'payment_record/list_payment_record/'.$limit.'/';
		$config['total_rows'] = $this->payment_record_model->get_total_payment_record_count();
	
	   
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		
		$data['result'] = $this->payment_record_model->get_payment_record_result($offset,$limit);
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
		$data['redirect_page']='list_payment_record';
		
		
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/payment_record/list_payment_record',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/* search patitent	 * param  : doctor id ,limit,option,keyword,offset,msg	 * 	 */
	function search_list_payment_record($limit=20,$option='',$keyword='',$from_date='1V1',$to_date='1V1',$offset=0,$msg='')
	{		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('search_list_payment_record');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_payment_record';
		
		
		
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
		$config['base_url'] = base_url().'payment_record/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword."/".$from_date."/".$to_date;
		$config['total_rows'] = $this->payment_record_model->get_total_search_payment_record_count($option,$keyword,$from_date,$to_date);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->payment_record_model->get_search_payment_record_result($option,$keyword,$offset, $limit,$from_date,$to_date);
		
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
		$this->template->write_view('center',$theme .'/layout/payment_record/list_payment_record',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/*check unique payment_record email
	 * param  : email
	 * return : BOOLEAN
	 */
	function payment_recordname_check($name)
	{
		$payment_recordname = $this->payment_record_model->payment_record_unique($name);
		if($payment_recordname == FALSE)
		{
			$this->form_validation->set_message('payment_recordname_check', 'There is an existing record with this News Name');
			return FALSE;
		}
		return TRUE;
	}
	
	
	/*delete payment_record data
	 * param  : payment_record id,doctor id ,option,keyword,limit,offset,msg
	 * 
	 */
	function delete_payment_record($id=0,$redirect_page='',$option='',$keyword='',$from_date='',$to_date='',$limit=20,$offset=0)
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_payment_record');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$this->db->query("delete from ".$this->db->dbprefix('transaction')." where transaction_id ='".$id."'");
	
		//$this->db->delete('payment_record',array('payment_record_id'=>$id));
		if($redirect_page == 'list_payment_record')
		{
			
			redirect('payment_record/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('payment_record/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$from_date.'/'.$to_date.'/'.$offset.'/delete');

		}
	}
	
	/*delete , active , inactive multiple payment_record at a time
	 * param  : payment_record id,doctor id ,redirect page,search option,search keyword,limit,offset,msg
	 * 
	 */ 
	function action_payment_record()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_payment_record');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');

		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
		
		$payment_record_id =$this->input->post('chk');
			
		if($action=='delete')
		{			    		
			foreach($payment_record_id as $id)
			{
				//$this->db->where('payment_record_id',$id);
				//$this->db->delete('payment_record',$data);			
				//$this->db->query("delete from ".$this->db->dbprefix('payment_record')." where payment_record_id ='".$id."'");				
				$this->db->query("delete from ".$this->db->dbprefix('transaction')." where transaction_id ='".$id."'");
			}
			
			if($redirect_page == 'list_payment_record')
			{
				redirect('payment_record/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('payment_record/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
			foreach($payment_record_id as $id)
			
			{			
				$data = array('status'=>'active');
				$this->db->where('transaction_id',$id);
				$this->db->update('transaction', $data);
			}
			if($redirect_page == 'list_payment_record')
			{
				redirect('payment_record/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('payment_record/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive')
		{             		
			foreach($payment_record_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('transaction_id',$id);
				$this->db->update('transaction', $data);
			}			
			if($redirect_page == 'list_payment_record')
			{
				redirect('payment_record/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('payment_record/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');

			}			
		}
		
		if($action=='pending')
		{
			foreach($payment_record_id as $id)			
			{			
				$data = array('status'=>'pending');
				$this->db->where('transaction_id',$id);
				$this->db->update('transaction', $data);
			}
			if($redirect_page == 'list_payment_record')
			{
				redirect('payment_record/'.$redirect_page.'/'.$limit.'/'.$offset.'/pending');
			}
			else
			{
				redirect('payment_record/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/pending');
			}
		}
		if($action=='deliver')
		{
			foreach($payment_record_id as $id)			
			{			
				$data = array('status'=>'deliver');
				$this->db->where('transaction_id',$id);
				$this->db->update('transaction', $data);
			}
			if($redirect_page == 'list_payment_record')
			{
				redirect('payment_record/'.$redirect_page.'/'.$limit.'/'.$offset.'/deliver');
			}
			else
			{
				redirect('payment_record/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/deliver');
			}
		}				
	}	


function downloadPaymentRecord()
	{
		//echo '<pre>';
		//print_r($_POST);
			
		//	$keyword=($this->input->post('key')!='')?str_replace(' ','-',$this->input->post('key')):'1V1';
		//	$option=($this->input->post('opt')!='')?str_replace(' ','-',$this->input->post('opt')):'1V1';
			
		
		$result=$this->payment_record_model->downloadPaymentRecord();
		
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