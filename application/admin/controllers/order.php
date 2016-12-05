<?php
//start of order controller for order list,add, delete,update.

class Order extends CI_Controller
{
	//load model(order model)
	function Order()
	{
		
		parent::__construct();	
		$this->load->model('order_model');
		
		
	}
	//end of order function
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('order/orderlist');
	}
	//start of orderlist function for all order listing
	function orderlist($limit=10,$offset=0,$msg='')
	{
		if(!check_admin_authentication())
		{
			
			redirect('home');
		}
		$check_rights=get_rights('orderlist');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$data["msg"] = $msg;
		$theme = getThemeName(); 
		$this->load->library('pagination');
		$config['uri_segment']=4;
		$config['base_url'] = site_url('order/orderlist/'.$limit);
		$config['div'] = '#content';
		//load total row
		$config['total_rows'] = $this->order_model->getTotalOrder();
	    $config['per_page'] = $limit;
		$this->pagination->initialize($config);
		
		$data['page_link']=$this->pagination->create_links();	
	    $data['result']=$this->order_model->getOrderResult($limit, $offset);
		$data["offset"] = $offset;
		$data["limit"] = $limit;
		$data['option']='1V1';
		$data['site_setting']=site_setting();
		$data['keyword']='1V1';
		$data['serach_option']='1V1';
		$data['serach_keyword']='1V1';
		$data['search_type']='normal';
		$data['redirect_page']='orderlist';
	    $data['page_name']="orderlist";
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/layout/order/orderlist_ajax',$data,TRUE);die;
		}
		else
		{
			// $pageTitle       = 'Order_list';
		  	// $metaDescription ='Order_list';
			// $metaKeyword='Order_list';
			// $this->template->write('pageTitle',$pageTitle,TRUE);
			// $this->template->write('metaDescription',$metaDescription,TRUE);
			// $this->template->write('metaKeyword',$metaKeyword,TRUE);
			//load temlate
			$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/order/orderlist',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);	
			
			$this->template->render(); 
		}
	}
	//end of orderlist
	//start of search Order listing function 
	function searchOrderlist($limit=10,$option='1V1',$keyword='1V1',$from_date='1V1',$to_date='1V1',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			
			redirect('home');
		}
		$check_rights=get_rights('searchOrderlist');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme ."/template.php");
		$redirect_page = 'searchorderlist';
	    $data['page_name']="orderlist";
		//print_r($_POST);
	    $keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',trim($keyword)));
		if($keyword=='')
		{
			$keyword='1V1';
		}
	  	if($_POST)
		{
			//print_r($_POST);die;
			if($this->input->post('option')!='')
			{
				$option=$this->input->post('option');
			}		
			else{
				$option='1V1';
			}
			
			$keyword=($this->input->post('keyword')!='')?str_replace(" ", "-",trim($this->input->post('keyword'))):'1V1';
			if($keyword=='' && $option=='date')
			{
				$keyword_date=$this->input->post('date');
			}
		}
		else
		{
			
			if($option=='')
			{
				$option = '1V1';
			}
			else{
				$option=$option;
			}
			
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
		
		
		 $keyword_date = "";
		 $this->load->library('pagination');
		 $data['site_setting'] = site_setting();
		 $config["uri_segment"]="8";
		 $config["base_url"] = base_url()."order/searchOrderlist/".$limit."/".$option."/".$keyword."/".$from_date."/".$to_date;
	
	     $config["total_rows"] = $this->order_model->get_total_search_order_count($option,$keyword,$keyword_date,$from_date,$to_date);
	     $config['div'] = '#content';
	     $config["per_page"] = $limit;		
	     $this->pagination->initialize($config);	
	   
	     $data["page_link"] = $this->pagination->create_links();
		
	     $data["result"] = $this->order_model->get_search_order_result($option,$keyword,$offset, $limit,$keyword_date,$from_date,$to_date);
	     if($data['result']==0)
		 {	
			if($offset>=$limit)
			{
				$offset=$offset-$limit;
			if($offset>=0)
			{
				redirect('order/searchOrderlist/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}else{
				$offset=0;
			}
				$data['offset']=$offset;
			}else{
				$data['limit']=10;
				$data['offset']=0;
				$offset=$data['offset'];
				$limit=$data['limit'];
			}
		}
	    $data["msg"] = $msg;
	    $data["offset"] = $offset;
		$data['limit']=$limit;
		$data['option']=$option;
		$data['keyword']=$keyword;
		$data['search_type']='search';
		$data['redirect_page']=$redirect_page;
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
			// $pageTitle = 'User_list';
	  		// $metaDescription ='User_list';
			// $metaKeyword='User_list';
			// $this->template->write('pageTitle',$pageTitle,TRUE);
			// $this->template->write('metaDescription',$metaDescription,TRUE);
			// $this->template->write('metaKeyword',$metaKeyword,TRUE);

			$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/order/orderlist',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);	
		
			$this->template->render();
	}//end of search list

	//start of single delete function
	function deleteOrder($id=0,$redirect_page='',$option='',$keyword='',$from_date='',$to_date='',$limit=10,$offset=0)
	{   //$limit="20";
	$check_rights=get_rights('deleteOrder');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$this->db->delete('order_master',array('order_id'=>$id));
		$this->db->delete('order_detail',array('order_id'=>$id));
		//echo  $this->db->lastquery();
		if($redirect_page == 'orderlist')
		{
			redirect('order/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('order/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$option.'/'.$keyword.'/'.$from_date.'/'.$to_date.'/'.$offset.'/delete');

		}
	}
	//end of single delete function
	
	//start of actionOrder function for maltipal delete,active and enactive
	function actionOrder()
	{
		$check_rights=get_rights('actionOrder');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
	  	$offset=$this->input->post("offset");
		$limit=$this->input->post("limit");
		$action=$this->input->post("action");
		$ids =$this->input->post("chk");
		
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		
		//for delete
		if($action=="delete")
		{		
			foreach($ids as $id)
			{			
				$this->db->delete('order_master',array('order_id'=>$id));
				$this->db->delete('order_detail',array('order_id'=>$id));
			}
			
		}
		if($redirect_page == 'orderlist')
		{
			redirect('order/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('order/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$option.'/'.$keyword.'/'.$from_date.'/'.$to_date.'/'.$offset.'/delete');

		}
		//end of delete		
		
	}
	//end of action function
	
	/*
	* function : DownloadCsv 
    * description :It is used for downoad order list csv.
    */
    function DowloadCsv()
	{
		$result=$this->order_model->downloadOrder();
		$filename ="Order.csv";
		$this->load->dbutil();
		$delimiter = ",";
		$newline = "\r\n";
		$data=$this->dbutil->csv_from_result($result, $delimiter, $newline);
		$this->load->helper('download');

		force_download($filename, $data);	
	}
	//end of DowloadCsv function
	
	/*
	* function : orderDetails 
    * description :It is used for order Details.
    */
	function orderDetails($id=0,$limit=10,$option='1V1',$keyword='1V1',$offset=0)
	{
		if(!check_admin_authentication())
		{
			
			redirect('home');
		}
		$check_rights=get_rights('orderDetails');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme ."/template.php");
		$data['page_name']='orderlist';
		
		$one_order = $this->order_model->get_one_order($id);
		$one_order_new = $this->order_model->get_one_order_info($id);
		
		$data['site_setting'] = site_setting();
		$data['user_id'] = $one_order['user_id'];
		
		 
		 
		$data["order_id"]=$id;
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		
		$data['getuserinf']= get_user_info($one_order_new['user_id']);
		
		
		$data['order_number'] = $one_order_new['order_number'];
		$data['order_date'] = $one_order_new['order_date'];
		$data['status'] = $one_order_new['status'];
		$data['total'] = $one_order_new['total'];
		$data['first_name'] = $one_order_new['first_name'];
		$data['last_name'] = $one_order_new['last_name'];
		$data['email'] = $one_order_new['email'];
		$data['mobile_no'] = $one_order_new['mobile_no'];
		$data['address1'] = $one_order_new['address1'];
		$data['address2'] = $one_order_new['address2'];
		$data['address'] = $one_order_new['address'];
		$data['country'] = $one_order_new['country'];
		$data['state'] = $one_order_new['state'];
		$data['city'] = $one_order_new['city'];
		$data['zipcode'] = $one_order_new['zipcode'];
		// echo '<pre>';email
		 
		// die;
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/order/orderdetails',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	function updatecode($code,$id)
	{
		$data=array(
				'tracking_code'=>$code,
				);
		$this->db->where('order_id', $id);
		$this->db->update('order_master', $data);
		
		
		//$data['']
		echo "done";
		die;
	}
	//end of DowloadCsv
	/*
	* function : statusChnage 
	* param: order_id, order Status 
    * description :for order status Chnage.
    */
    function statusChange($order_id, $order_status,$limit=10,$offset=0,$msg='update')
    {
    	
    	
  		$data["msg"] = $msg;
		$theme = getThemeName(); 
		$this->load->library('pagination');
		
		$config['uri_segment']=4;
		$config['base_url'] = site_url('order/orderlist/'.$limit);
		$config['div'] = '#content';
		//load total row
		$config['total_rows'] = $this->order_model->getTotalOrder();
	    $config['per_page'] = $limit;

		$this->pagination->initialize($config);
		
		$data['page_link']=$this->pagination->create_links();	
	    $data['result']=$this->order_model->getOrderResult($limit, $offset);
		$this->order_model->changeOrderStatus($order_id,$order_status);
		echo 'done';die;
	}
	//end of statusChange
	/*
	* function : searchOrderlistDate 
    * description :for search list between two dates
    */
	function searchOrderlistDate($limit='10',$option='1V1', $offset=0, $msg='', $keyword='')
	{
		if(!check_admin_authentication())
		{
			
			redirect('home');
		}
		$check_rights=get_rights('searchOrderlistDate');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme ."/template.php");
		$redirect_page = 'searchOrderlist';
	    $data['page_name']="orderlist";
		$from_date=date("Y-m-d", strtotime($this->input->post('from_date')));
		$to_date=date("Y-m-d", strtotime($this->input->post('to_date')));
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		
		 
		$this->load->library('pagination');
		$config["uri_segment"]="6";
		$config["base_url"] = base_url()."order/searchOrderlistDate/".$limit."/".$offset;
	    $config["total_rows"] = $this->order_model->get_total_search_orderdate_count($option,$from_date,$to_date);
	    $config['div'] = '#content';
	    $config["per_page"] = $limit;		
	    $this->pagination->initialize($config);	
	    $data["page_link"] = $this->pagination->create_links();
	    $data["result"] = $this->order_model->get_search_orderdate_result($option,$from_date,$offset, $limit,$to_date);
	    if($data['result']==0)
		{	
			if($offset>=$limit)
			{
				$offset=$offset-$limit;
			if($offset>=0)
			{
				redirect('order/searchOrderlistDate/'.$limit.'/'.$offset.'/'.$msg);
			}else{
				$offset=0;
			}
				$data['offset']=$offset;
			}else{
				$data['limit']=10;
				$data['offset']=0;
				$offset=$data['offset'];
				$limit=$data['limit'];
			}
		}
	    $data["msg"] = $msg;
	    $data["offset"] = $offset;
		$data['limit']=$limit;
		$data['option']=$option;
		$data['keyword']=$keyword;
		$data['search_type']='search';
		$data['redirect_page']=$redirect_page;
		if($this->input->is_ajax_request())
		{
			echo $this->load->view($theme .'/layout/order/orderlist_ajax',$data,TRUE);die;
		}
		else
		{
			$date['from_date_ref']=$this->input->post('from_date');
			// $pageTitle = 'User_list';
	  		// $metaDescription ='User_list';
			// $metaKeyword='User_list';
			// $this->template->write('pageTitle',$pageTitle,TRUE);
			// $this->template->write('metaDescription',$metaDescription,TRUE);
			// $this->template->write('metaKeyword',$metaKeyword,TRUE);
			$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('content_side',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('content_center',$theme .'/layout/order/orderlist',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);	
			$this->template->render();
		}
	}//end of searchOrderlistDate
	
	
	function print_order($id=0)
	{
			$check_rights=get_rights('print_order');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$data = array();    
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$data['active_menu']='invoice';		
		$data['site_setting'] = site_setting();
		
			if(!check_admin_authentication())
		{
			
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme ."/template.php");
		$data['page_name']='orderlist';
		
		$one_order = $this->order_model->get_one_order($id);
		$one_order_new = $this->order_model->get_one_order_info($id);
		
		$data['site_setting'] = site_setting();
		$data['user_id'] = $one_order['user_id'];
		
		 
		 
		$data["order_id"]=$id;
		
		$data['getuserinf']= get_user_info($one_order_new['user_id']);
		
		
		$data['order_number'] = $one_order_new['order_number'];
		$data['order_date'] = $one_order_new['order_date'];
		$data['status'] = $one_order_new['status'];
		$data['total'] = $one_order_new['total'];
		$data['first_name'] = $one_order_new['first_name'];
		$data['last_name'] = $one_order_new['last_name'];
		$data['email'] = $one_order_new['email'];
		$data['mobile_no'] = $one_order_new['mobile_no'];
		$data['address1'] = $one_order_new['address1'];
		$data['address2'] = $one_order_new['address2'];
		$data['address'] = $one_order_new['address'];
		$data['country'] = $one_order_new['country'];
		$data['state'] = $one_order_new['state'];
		$data['city'] = $one_order_new['city'];
		$data['zipcode'] = $one_order_new['zipcode'];
			
		$this->load->view($theme .'/layout/order/printorder',$data);
		//$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		//$this->template->render();
	}	
	
}
//end of order cotroller
?>