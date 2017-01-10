<?php
class Suggest_bar extends  CI_Controller {
	function Suggest_bar()
	{
		 parent::__construct();	
		$this->load->model('bar_model');
		
	}
	
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('suggest_bar/list_suggest_bar');
		
		
	}
	
	
	function list_suggest_bar($limit='10',$offset=0,$msg='')
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('list_suggest_bar');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$this->load->library('pagination');
		
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'suggest_bar/list_suggest_bar/'.$limit.'/';
		$config['total_rows'] = $this->bar_model->get_total_suggest_bar();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->bar_model->get_suggest_bar_result($offset,$limit);
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
		$data['redirect_page']='list_suggest_bar';
		
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/bar/list_suggest_bar',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}

	/* search patitent	 * param  : doctor id ,limit,option,keyword,offset,msg	 * 	 */
	function search_list_suggest_bar($limit=20,$option='',$keyword='',$offset=0,$msg='')
	{		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('search_list_suggest_bar');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_suggest_bar';
		
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
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',trim($keyword)));
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'suggest_bar/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->bar_model->get_total_search_suggest_bar_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->bar_model->get_search_suggest_bar_record_result($option,$keyword,$offset, $limit);
		
		$data['msg'] = $msg;
		$data['offset'] = $offset;
		$data['site_setting'] = site_setting();
		
		$data['limit']=$limit;
		$data['option']=$option;
		$data['keyword']=$keyword;
		$data['search_type']='search';
		$data['redirect_page']=$redirect_page;		
		
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/bar/list_suggest_bar',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
  
    function delete_suggest_bar($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		$check_rights=get_rights('delete_suggest_bar');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$this->db->query("delete from ".$this->db->dbprefix('suggest_bars')." where suggest_bar_id ='".$id."'");
		if($redirect_page == 'list_suggest_bar')
		{
			
			redirect('suggest_bar/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('suggest_bar/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	function action_suggest_bar()
	{
		$check_rights=get_rights('action_suggest_bar');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
		
		$suggest_bar_id =$this->input->post('chk');
			
	    if($action=='delete')
		{		
			foreach($suggest_bar_id as $id)
			{			
				$this->db->query("delete from ".$this->db->dbprefix('suggest_bars')." where suggest_bar_id ='".$id."'");
			}
			
			if($redirect_page == 'list_suggest_bar')
			{
				redirect('suggest_bar/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('suggest_bar/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
		if($action=='pending')
		{			    		
			foreach($suggest_bar_id as $id)
			{
				//$this->db->where('payment_fail_record_id',$id);
				//$this->db->delete('payment_fail_record',$data);			
				//$this->db->query("delete from ".$this->db->dbprefix('suggest_bars')." where suggest_bar_id ='".$id."'");
				 $data_update = array("status"=>'approve');
	   			 $this->db->where("suggest_bar_id",$id);
	   				$this->db->update("suggest_bars",$data_update);
				$get_bar_info = $this->bar_model->get_suggest_bar_info($id);
				 $slug=getBarSlug($get_bar_info['bar_name']);	
				$dataarr = array('bar_title'=>$get_bar_info['bar_name'],
				                 'bar_desc'=>$get_bar_info['description'],
                                                 'lang'=>$get_bar_info['lang'],
                                                 'lat'=>$get_bar_info['lat'],
								 'address'=>$get_bar_info['address'],
								 'state'=>$get_bar_info['state'],
								 'phone'=>$get_bar_info['phone_number'],
								 'bar_desc'=>'',
								 'zipcode'=>$get_bar_info['zip_code'],
								 'bar_slug'=>$slug,
								 'suggest_by_user_id'=>$get_bar_info['sugget_by_user'],
								 'date_added'=>date('Y-m-d H:i:s'),
								 'city'=>$get_bar_info['city']);
	            $this->db->insert('bars',$dataarr);	
				
				$news_id = mysql_insert_id();
				$inar = array('cat_id'=>$news_id,
				              'category'=>'bar',
							  'date'=>date('Y-m-d H:i:s'));
				$this->db->insert('sitemap', $inar);
				
				if($get_bar_info['sugget_by_user']!='' && $get_bar_info['sugget_by_user']!=0)
				{
					
					$getinfo = get_user_info($get_bar_info['sugget_by_user']);
					
					//print_r($getinfo);
					$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Suggestion Success'");
					$email_temp=$email_template->row();				
					$email_address_from=$email_temp->from_address;
					$email_address_reply=$email_temp->reply_address;
					$email_subject=$email_temp->subject;				
					$email_message=$email_temp->message;
					$email = $getinfo->email;
					$user = ucwords($getinfo->first_name." ".$getinfo->last_name);
					$email_to =$email;
					$email_message=str_replace('{break}','<br/>',$email_message);
					$email_message=str_replace('{user}',$user,$email_message);
					$email_message=str_replace('{break}','<br/>',$email_message);
					$email_message=str_replace('{barname}',$get_bar_info['bar_name'],$email_message);
					$str=$email_message;
					if($email_temp->status=='active'){
					email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
					}	
		
				}
				//if()				 
								
			}
			
			if($redirect_page == 'list_suggest_bar')
			{
				redirect('suggest_bar/'.$redirect_page.'/'.$limit.'/'.$offset.'/approve');
			}
			else
			{
				redirect('suggest_bar/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/approve');

			}
			
		}
			
	}
    // Use :This function use for add new bar.
	// Param :'N/A'
	// Return :'N/A'
	function bartitle_check_suggest($title)
	{
		$username = $this->bar_model->bar_title_unique_suggest($title);
		if($username == FALSE)
		{
			$this->form_validation->set_message('bartitle_check_suggest', 'There is an existing Bar associated with this Title');
			return FALSE;
		}
		return TRUE;
	}
	
	function add_suggest_bar($limit=0)
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
		
		$check_rights=get_rights('add_bar');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		if($limit > 0)
		{
			$data['limit']=$limit;
		}
		else
		{
			$data['limit']=20;
		}
		

		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('bar_name', 'Bar Title', 'required|callback_bartitle_check_suggest');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');
		$this->form_validation->set_rules('phone', 'Phone', 'required');
		$this->form_validation->set_rules('zipcode', 'Zipcode', 'required');
		
		if($this->form_validation->run() == FALSE || $video_error != ""){			
			if (validation_errors () || $video_error != "") {
					$data["error"] = validation_errors ();
				} else {
					$data["error"] = "";
				}
			
			$data["suggest_bar_id"] = $this->input->post('suggest_bar_id');
			$data["bar_name"] = $this->input->post('bar_name');
			$data["address"] = $this->input->post('address');
			$data["city"] = $this->input->post('city');
			$data["state"] = $this->input->post('state');
			$data["phone_number"] = $this->input->post('phone');
			$data["zip_code"] = $this->input->post('zipcode');
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_suggest_bar';
			
			
			$data['site_setting'] = site_setting();
			
		
			if($this->input->post('offset')=="")
			{
				$limit = '10';
				$data["offset"] = 0;
			}else{
				$data["offset"] = $this->input->post('offset');
			}
			
			
			$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/bar/add_suggest_bar',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
			
				
				
			if($this->input->post('suggest_bar_id')!='')
			{			
				$this->bar_model->bar_suggest_update();
				$msg = "update";
			}else{
				$this->bar_model->bar_insert($_POST);			
				$msg = "insert";
			}
			$offset = $this->input->post('offset');
			$limit=$this->input->post('limit');
			
			if($limit == 0)
			{
				$limit = 20;
			}
			else
			{
				$limit = $limit;
			}
			$redirect_page = $this->input->post('redirect_page');
			$option = $this->input->post('option');
			$keyword = $this->input->post('keyword');
		 	
			 
			if($redirect_page == 'list_suggest_bar')
			{
				redirect('suggest_bar/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			else
			{
				redirect('suggest_bar/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	function edit_suggest_bar($id,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
		
		$check_rights=get_rights('edit_suggest_bar');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		;
		
		$one_bar = $this->bar_model->get_one_barsuggest($id);
		//print_r($one_bar); die;
		//print_r($one_user); die;
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		$data["redirect_page"]=$redirect_page;
	   	
			$data["bar_name"] = $one_bar["bar_name"];
			$data["description"] = $one_bar["description"];
			$data["address"] = $one_bar["address"];
			$data["city"] = $one_bar["city"];
			$data["state"] = $one_bar["state"];
			$data["phone_number"] = $one_bar["phone_number"];
			$data["zip_code"] = $one_bar["zip_code"];
			$data["status"] = $one_bar["status"];
			$data["suggest_bar_id"] = $one_bar["suggest_bar_id"];
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/bar/add_suggest_bar',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}

	function view_suggest_bar($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0){
		
	    if($id=='')
		{
			redirect('home');
		}
		if(!check_admin_authentication()) {
		redirect('home');
		}
		$check_rights=get_rights('view_suggest_bar');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$data['site_setting'] = site_setting();
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('reply_message');
				
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//echo $id; die;
		$one_message = $this->bar_model->get_suggest_bar($id);
		
		
		 if($one_message=='0')
		{
			redirect('suggest_bar/list_suggest_bar');
		}
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		$data["redirect_page"]=$redirect_page;
		
		$data["suggest_bar_id"] = $id;
		$data["bar_name"] = $one_message['bar_name'];
		$data["description"] = $one_message['description'];
		$data["address"] = $one_message['address'];
		$data["state"] = $one_message['state'];
		$data["city"] = $one_message['city'];
		$data["phone_number"] = $one_message['phone_number'];
		$data["zip_code"] = $one_message['zip_code'];
		$data["date"] = $one_message['date'];
	
	    $data_update = array("states"=>'read');
	    $this->db->where("suggest_bar_id",$id);
	    $this->db->update("suggest_bars",$data_update);
		//end of update data//
	
		
		
		//print_r($data['total']); die;
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/bar/view_suggest_bar',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();

	}		
}
?>