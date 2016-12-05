<?php
class Archived_bar extends  CI_Controller {
	function Archived_bar()
	{
		 parent::__construct();	
		$this->load->model('archived_bar_model');
		
	}
	
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('archived_bar/list_archived_bar');
		
		$check_rights=get_rights('list_archived_bar');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
	}
	
	// Use :This function use for Lost all archived_bar User.
	// Param :limit,offset,message
	// Return :'N/A'
	function list_archived_bar($bar_type ='all',$limit='10',$offset=0,$msg='',$er='',$er1='')
	{
		 //echo base64_decode($er1);
		 
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
		
		$check_rights=get_rights('list_archived_bar');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');
		}
		
		$this->load->library('pagination');

		
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'archived_bar/list_archived_bar/'.$bar_type.'/'.$limit.'/';
		$config['total_rows'] = $this->archived_bar_model->get_total_archived_bar_count($bar_type);
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->archived_bar_model->get_archived_bar_result($offset,$limit,$bar_type);
		$data['msg'] = $msg;
		
		$data['er'] = $er;
		$data['er1'] = $er1;
		
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
		$data['redirect_page']='list_archived_bar';
	    $data["bar_type"] = $bar_type;
		$data['site_setting'] = site_setting();

		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/archived_bar/list_archived_bar',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}

    function download()
	{
		    ini_set('memory_limit', '2048M');
		 $keyword=($this->input->post('key')!='')?str_replace(' ','-',$this->input->post('key')):'1V1';
         $option=($this->input->post('opt')!='')?str_replace(' ','-',$this->input->post('opt')):'1V1';
		 $typ=($this->input->post('typ')!='')?str_replace('', '-', $this->input->post('typ')):'1v1';
		 $result = $this->archived_bar_model->getarchived_baresult($typ,$option,$keyword);
		 
		 //echo "<pre>";
		 
		
		 $filename ="archived_bar_Record.csv";
         $this->load->dbutil();
         $delimiter = ",";
         $newline = "\r\n";
		 
         $data= $this->dbutil->csv_from_result($result, $delimiter, $newline);
		 
         //$this->load->helper('download');
        // force_download($filename, $data);
		 
		//$data = ltrim(strstr($this->dbutil->csv_from_result($result, ',', "\r\n"), "\r\n"));
		
		$this->load->helper('download');
		force_download("archived_barrecord.csv", $data);
		
		
		exit;
	}
	
	// Use :This function use for list archived_bar by filter.
	// Param :limit,option,keyword,offset,message
	// Return :'N/A'
	function search_list_archived_bar($bar_type = "all",$limit=20,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$redirect_page = 'search_list_archived_bar';
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('search_list_archived_bar');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$this->load->library('pagination');
		$data['er'] = '';
		$data['er1'] = '';
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
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',trim($keyword)));

	
		$config['uri_segment']='7';
		$config['base_url'] = base_url().'archived_bar/search_list_archived_bar'.'/'.$bar_type."/".$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->archived_bar_model->get_total_search_archived_bar_count($bar_type,$option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->archived_bar_model->get_search_archived_bar_result($bar_type,$option,$keyword,$offset, $limit);
		
		
		
		
		$data['msg'] = $msg;
		$data['offset'] = $offset;
		$data['site_setting'] = site_setting();
		$data["bar_type"] =$bar_type;
		
		$data['limit']=$limit;
		$data['option']=$option;
		$data['keyword']=$keyword;
		$data['search_type']='search';
		$data['redirect_page']=$redirect_page;
		
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/archived_bar/list_archived_bar',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	function delete_archived_bar($archived_bartype="all",$id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*   
		 * Future enhancement
		 * when assigning rights is used
		*/
		//echo "mnbjb"; die;
		$check_rights=get_rights('delete_archived_bar');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
        $getarchived_bar = $this->archived_bar_model->get_one_archived_bar($id);
		if($getarchived_bar['owner_id']!='' && $getarchived_bar['owner_id']!=0)
		{
			
		      $getuserinfo = get_user_info($getarchived_bar['owner_id']);
			 
			    $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Delete archived_bar Profile'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = $getuserinfo->email;
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{username}', ucwords($getarchived_bar['archived_bar_first_name'])." ".ucwords($getarchived_bar['archived_bar_last_name']), $email_message);
				$str = $email_message;
				if($email_temp->status=='active'){
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
				}
				$this->db->delete('user_master',array('user_id'=>$getarchived_bar['owner_id']));
				
		}
		$this->db->delete('archived_bars',array('bar_id'=>$id));
		
		
		if($redirect_page == 'list_archived_bar')
			{
				redirect('archived_bar/'.$redirect_page.'/'.$archived_bartype.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('archived_bar/'.$redirect_page.'/'.$archived_bartype.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
        
        /// common function for insert all action//
           $data_log = array("activity_name" => "LOG_DELETE_ADMIN");
           maintain_log($data_log);
	}
	
	
	// Use :This function use for change status or delete archived_bar.
	// Param :'N/a'
	// Return :'N/A'
	function action_archived_bar($archived_bartype='all')
	{
		/* Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('action_archived_bar');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
		
		$bar_id =$this->input->post('chk');
		
		
		if($action=='delete')
		{
          
               
                		
			foreach($bar_id as $id)
			{	$getarchived_bar = $this->archived_bar_model->get_one_archived_bar($id);
				if($getarchived_bar['owner_id']!='' && $getarchived_bar['owner_id']!=0)
				{
				       $getuserinfo = get_user_info($getarchived_bar['owner_id']);
					    $email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Delete archived_bar Profile'");
						$email_temp = $email_template->row();
						$email_address_from = $email_temp->from_address;
						$email_address_reply = $email_temp->reply_address;
						$email_subject = $email_temp->subject;
						$email_message = $email_temp->message;
						$email = $getuserinfo->email;
						$email_to = $email;
						$email_message = str_replace('{break}', '<br/>', $email_message);
						$email_message = str_replace('{username}', ucwords($this->input->post('archived_bar_first_name'))." ".ucwords($this->input->post('archived_bar_last_name')), $email_message);
						$str = $email_message;
						$this->db->delete('user_master',array('user_id'=>$getarchived_bar['owner_id']));
				}		
				$this->db->query("delete from ".$this->db->dbprefix('archived_bars')." where bar_id ='".$id."'");
				$this->db->query("delete from ".$this->db->dbprefix('archived_bar_comment')." where bar_id ='".$id."'");
				//echo $this->db->last_query(); die;
			}
			
			if($redirect_page == 'list_archived_bar')
			{
				redirect('archived_bar/'.$redirect_page.'/'.$archived_bartype.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('archived_bar/'.$redirect_page.'/'.$archived_bartype.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
            
                		
			foreach($bar_id as $id)
			{			
				$data = array('status'=>'active');
				$this->db->where('bar_id',$id);
				$this->db->update('bars', $data);
			}
			if($redirect_page == 'list_archived_bar')
			{
				
				redirect('archived_bar/'.$redirect_page.'/'.$archived_bartype.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('archived_bar/'.$redirect_page.'/'.$archived_bartype.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
			}
		}	

if($action=='archived')
		{
            
                		
			foreach($bar_id as $id)
			{			
				$data = array('status'=>'archived');
				$this->db->where('bar_id',$id);
				$this->db->update('bars', $data);
			}
			if($redirect_page == 'list_archived_bar')
			{
				redirect('archived_bar/'.$redirect_page.'/'.$archived_bartype.'/'.$limit.'/'.$offset.'/archived');
			}
			else
			{
				redirect('archived_bar/'.$redirect_page.'/'.$archived_bartype.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/archived');
			}
		}	
	if($action=='claimed')
		{
            
                		
			foreach($bar_id as $id)
			{			
				$data = array('claim'=>'claimed');
				$this->db->where('bar_id',$id);
				$this->db->update('bars', $data);
			}
			if($redirect_page == 'list_archived_bar')
			{
				redirect('archived_bar/'.$redirect_page.'/'.$archived_bartype.'/'.$limit.'/'.$offset.'/claimed');
			}
			else
			{
				redirect('archived_bar/'.$redirect_page.'/'.$archived_bartype.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/claimed');
			}
		}	
		
		
	if($action=='unclaimed')
		{
            
                		
			foreach($bar_id as $id)
			{			
				$data = array('claim'=>'unclaimed');
				$this->db->where('bar_id',$id);
				$this->db->update('bars', $data);
			}
			if($redirect_page == 'list_archived_bar')
			{
				redirect('archived_bar/'.$redirect_page.'/'.$archived_bartype.'/'.$limit.'/'.$offset.'/unclaimed');
			}
			else
			{
				redirect('archived_bar/'.$redirect_page.'/'.$archived_bartype.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/unclaimed');
			}
		}	
		if($action=='inactive')
		{
		 
                		
			foreach($bar_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('bar_id',$id);
				$this->db->update('bars', $data);
			}
			
			if($redirect_page == 'list_archived_bar')
			{
				redirect('archived_bar/'.$redirect_page.'/'.$archived_bartype.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('archived_bar/'.$redirect_page.'/'.$archived_bartype.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');

			}
		}	
		
	}

  
}
?>