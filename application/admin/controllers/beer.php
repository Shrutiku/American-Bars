<?php
class Beer extends  CI_Controller {
	function Beer()
	{
		parent::__construct();	
		$this->load->model('beer_model');	
		$this->load->library('pagination');
		  ini_set('memory_limit', '2048M');
	  
	}
	//use:for redirecting at list beer page
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('beer/list_beer');	
	}
	
	/* beer list
	 * param  : doctor id ,limit,offset,msg
	 * 
	 */
	function list_beer($limit='10',$bars_id=0, $offset=0,$msg='',$er='',$er1='') {
		
		
		 
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
		
		$check_rights=get_rights('list_beer');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
			$this->load->library('pagination');
		
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'beer/list_beer/'.$limit.'/'.$bars_id. "/";
		$config['total_rows'] = $this->beer_model->get_total_beer_count($bars_id);
	$data['er'] = $er;
	$data['er1'] = $er1;
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->beer_model->get_beer_result($offset,$limit,$bars_id);
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
		$data['redirect_page']='list_beer';
		$data["bars_id"] = $bars_id ;
		
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/beer/list_beer',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	 function download()
	{
		 $keyword=($this->input->post('key')!='')?str_replace(' ','-',$this->input->post('key')):'1V1';
         $option=($this->input->post('opt')!='')?str_replace(' ','-',$this->input->post('opt')):'1V1';
		 $typ=($this->input->post('typ')!='')?str_replace('', '-', $this->input->post('typ')):'1v1';
		 $result = $this->beer_model->getAllBeerResult($typ,$option,$keyword);
		 
		 //echo "<pre>";
		 
		
		 $filename ="barrecord.csv";
         $this->load->dbutil();
         $delimiter = ",";
         $newline = "\r\n";
		 
         $data= $this->dbutil->csv_from_result($result, $delimiter, $newline);
		 
         //$this->load->helper('download');
        // force_download($filename, $data);
		 
		//$data = ltrim(strstr($this->dbutil->csv_from_result($result, ',', "\r\n"), "\r\n"));
		
		$this->load->helper('download');
		force_download("Beer_Record.csv", $data);
		
		
		exit;
	}
	
	/* search patitent
	 * param  : doctor id ,limit,option,keyword,offset,msg
	 * 
	 */
	function search_list_beer($limit=20,$bars_id = 0,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('search_list_beer');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_beer';
		
		
		
		if($_POST)
		{		
			$option=$this->input->post('option');
			$keyword=($this->input->post('keyword')!='')?str_replace(" ", "-",trim($this->input->post('keyword'))):'1V1';
			$bars_id=$this->input->post('bars_id');
		}
		else
		{
			$option=$option;
			$keyword=str_replace(" ", "-",trim($keyword));	
			 $bars_id = $bars_id;
		
		}
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',trim($keyword)));

	$data['er'] = '';
	$data['er1'] = '';
		$config['uri_segment']='7';
		$config['base_url'] = base_url().'beer/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$option.'/'.$keyword;
		$config['total_rows'] = $this->beer_model->get_total_search_beer_count($option,$keyword,$bars_id);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->beer_model->get_search_beer_result($option,$keyword,$offset, $limit,$bars_id);
		$data["bars_id"] = $bars_id;
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
		$this->template->write_view('center',$theme .'/layout/beer/list_beer',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	function search_list_poker($limit=20,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_beer';
		
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
		$config['base_url'] = base_url().'beer/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->beer_model->get_total_search_poker_count($option,$keyword);
		//print_r($config['total_rows']); die;
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->beer_model->get_search_poker_result($option,$keyword,$offset, $limit);
		
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
		$this->template->write_view('center',$theme .'/layout/beer/list_beer',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	/*check unique beer email
	 * param  : email
	 * return : BOOLEAN
	 */
	function beername_check($name)
	{
		$beername = $this->beer_model->beer_name($name);
		if($beername == FALSE)
		{
			$this->form_validation->set_message('beername_check', 'There is an existing record with this Beer Name');
			return FALSE;
		}
		return TRUE;
	}
	
	/*add new beer also called in beer update
	 * param  : limit
	 * 
	 */
	function add_beer($bars_id=0,$limit=0)
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
		
		$check_rights=get_rights('add_beer');
		
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
		//$this->form_validation->set_rules('beer_name', 'Beer Name', 'required|callback_beername_check');
		$this->form_validation->set_rules('beer_name', 'Beer Name', 'required');
		$this->form_validation->set_rules('beer_country', 'Country', 'required');
		//$this->form_validation->set_rules('producer', 'Producer', 'required');
		//$this->form_validation->set_rules('city_produced', 'city produced', 'required');
		//$this->form_validation->set_rules('beer_desc', 'Description', 'required');
		//$this->form_validation->set_rules('beer_desc', 'Description', 'required');
		//$this->form_validation->set_rules('abv', 'ABV ', 'required');
		//$this->form_validation->set_rules('beer_state', 'State ', 'required');
		//$this->form_validation->set_rules('beer_meta_title', 'Meta Title', 'required');
		//$this->form_validation->set_rules('beer_meta_keyword', 'Meta Keyword', 'required');
		//$this->form_validation->set_rules('beer_meta_description', 'Meta Description', 'required');
				
		$video_error = '';
		$exist_error = '';
		$exist_error1= '';
				
		if($_POST)
		{			
			$image_arr = array('image/gif','image/jpeg', 'image/pjpeg','image/jpeg', 'image/pjpeg','image/jpeg', 'image/pjpeg','image/png',  'image/x-png');
			if($_FILES["file_up"]["name"] != "")
			{
				if(!in_array($_FILES["file_up"]["type"],$image_arr))
				{
					$video_error .= "<p>Please upload jpg,jpeg,png,gif format only</p>";
				}
			}	
			$exist_error = $this->beer_model->beer_name_v(trim($this->input->post('beer_name')),trim($this->input->post('beer_type')),trim($this->input->post('abv')),trim($this->input->post('producer')),trim($this->input->post('beer_address')),trim($this->input->post('city_produced')),trim($this->input->post('beer_state')),trim($this->input->post('beer_zipcode')),trim($this->input->post('beer_country')),trim($this->input->post('beer_phone')),trim($this->input->post('beer_website')),$this->input->post('beer_id'));
				if($exist_error==1)
				{
					$exist_error1 .= "<p>Beer already exixting please change at least one field.</p>";
				}	
		}
		
		if($this->form_validation->run() == FALSE || $video_error != "" || $exist_error1!=''){			
			if (validation_errors () || $video_error != "" || $exist_error1!='') {
					$data["error"] = validation_errors ();
					$data["error"] .= $video_error;
					$data["error"] .= $exist_error1;
			}else{
				$data["error"] = "";
			}
			
			$data["beer_id"] = $this->input->post('beer_id');
			$data["beer_address"] = $this->input->post('beer_address');
			$data["beer_country"] = $this->input->post('beer_country');
			$data["beer_zipcode"] = $this->input->post('beer_zipcode');
			$data["beer_phone"] = $this->input->post('beer_phone');
			$data["beer_name"] = $this->input->post('beer_name');
			$data["beer_slug"] = $this->input->post('beer_slug');
			$data["beer_type"] = $this->input->post('beer_type');
			$data["producer"] =$this->input->post('producer');
			$data["city_produced"] = $this->input->post("city_produced");
			$data["abv"] = $this->input->post("abv");		
			$data["status"] = $this->input->post('status');
			$data["prev_beer_image1"] = $this->input->post('prev_beer_image1');
			$data["video_link"] = $this->input->post('video_link');
			$data["upload_type"] = $this->input->post('upload_type');
			$data['prev_beer_image']=$this->input->post('prev_beer_image');
			$data["beer_desc"] = $this->input->post('beer_desc');
			$data["beer_state"] = $this->input->post('beer_state');
			$data["beer_website"] = $this->input->post('beer_website');
			$data["bar_id"] = $this->input->post('bar_id');
			$data["is_suggested"] = $this->input->post('bar_id');
			$data["beer_meta_title"] = $this->input->post('beer_meta_title');
			$data["beer_meta_keyword"] = $this->input->post('beer_meta_keyword');
			$data["beer_meta_description"] = $this->input->post('beer_meta_description');
			$data["bars_id"] = $bars_id;
		
		// $data['states']=get_all_state_by_country_id($this->input->post('country_id'));
		// $data['cities']=get_all_city_by_state_id($this->input->post('state'));
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_beer';
			// $data['all_countries']=get_all_country();
			
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
			$this->template->write_view('center',$theme .'/layout/beer/add_beer',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				
			if($this->input->post('beer_id')!='')
			{	
				$this->beer_model->beer_update($_POST);
				$msg = "update";
			}else{
				$this->beer_model->beer_insert($_POST);			
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
			$did = $this->input->post('did');
		 	
			 if($this->input->post('beer_id')==0 || $this->input->post('beer_id')=='')
				{
					$offset=0;
				}
			if($redirect_page == 'list_beer')
			{
				
				
				redirect('beer/'.$redirect_page.'/'.$limit.'/'.$this->input->post("bars_id").'/'.$offset.'/'.$msg);
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('beer/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}	
			else
			{
				redirect('beer/'.$redirect_page.'/'.$limit.'/'.$this->input->post("bars_id").'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	/*beer update form fill
	 * param  : beer id,doctor id ,redirect page,option,keyword,limit,offset
	 * 
	 */
	function edit_beer($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0,$bars_id = 0)
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
		
		$check_rights=get_rights('edit_beer');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_beer = $this->beer_model->get_one_beer($id);
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		
		$data["beer_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		
		
		//print_r($one_beer);
		
		$data["prev_beer_image1"] = $one_beer['image_default'];
		$data["upload_type"] = $one_beer['upload_type'];
		$data["video_link"] = $one_beer['video_link'];
		$data["beer_phone"] = $one_beer['beer_phone'];
		$data["beer_zipcode"] = $one_beer['beer_zipcode'];
		$data["beer_country"] = $one_beer['beer_country'];
		$data["beer_address"] = $one_beer['beer_address'];
		$data["beer_name"] = $one_beer['beer_name'];
		$data["beer_type"] = $one_beer['beer_type'];
		$data["producer"] =  $one_beer['producer'];
		$data["city_produced"] = $one_beer['city_produced'];
		$data["status"] = $one_beer['status'];
		$data["beer_slug"] =$one_beer['beer_slug'];
		$data['prev_beer_image']= $one_beer['beer_image'];
		$data["beer_desc"] = $one_beer['beer_desc'];
		$data["beer_state"] = $one_beer['beer_state'];
		$data["beer_website"] = $one_beer['beer_website'];
		$data["bar_id"] = $one_beer['bar_id'];
		$data["abv"] = $one_beer['abv'];		
		$data["is_suggested"] = $one_beer['is_suggested'];
		$data["beer_meta_title"] = $one_beer['beer_meta_title'];
		$data["beer_meta_keyword"] = $one_beer['beer_meta_keyword'];
		$data["beer_meta_description"] = $one_beer['beer_meta_description'];
		$data["bars_id"] = $bars_id;
		
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/beer/add_beer',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/*delete beer data
	 * param  : beer id,doctor id ,option,keyword,limit,offset,msg
	 * 
	 */
	 
	 function delete_r()
	 {
	 	for($i=76;$i<=56130;$i++){
	 		$this->db->query("delete from ".$this->db->dbprefix('beer_directory')." where beer_id ='".$i."'");
		
		}
	 }
	function delete_beer($id=0,$redirect_page='',$option='',$keyword='',$bars_id = 0,$limit=20,$offset=0)
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
	
		
		$check_rights=get_rights('delete_beer');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//$this->db->delete('rights_assign',array('beer_id'=>$id));
		
		if($bars_id > 0 && is_numeric($bars_id))
		{
			
			$this->db->query("delete from ".$this->db->dbprefix('beer_bars')." where bar_id ='".$bars_id."' and beer_id='".$id."'");
		}
		else {
			//$data=array('is_deleted'=>'yes');
			//$this->db->where('beer_id',$id);
			//$this->db->update('beer_directory',$data);
			$this->db->query("delete from ".$this->db->dbprefix('beer_directory')." where beer_id ='".$id."'");
			
		}
		
        
        
		
		//$this->db->delete('beer',array('beer_id'=>$id));
		if($redirect_page == 'list_beer')
		{
			redirect('beer/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$offset.'/delete');
		}
		else
		{
			redirect('beer/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	/*delete , active , inactive multiple beer at a time
	 * param  : beer id,doctor id ,redirect page,search option,search keyword,limit,offset,msg
	 * 
	 */ 
	function action_beer()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_beer');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
		$bar_id = $this->input->post('bars_id');
		
		$beer_id =$this->input->post('chk');
			
		if($action=='delete')
		{
		
			    		
			foreach($beer_id as $id)
			{
				if($bar_id > 0 && is_numeric($bar_id))
				{
					$this->db->query("delete from ".$this->db->dbprefix('beer_bars')." where bar_id ='".$bar_id."' and beer_id='".$id."'");
				}
				else {
				//	$data=array('is_deleted'=>'yes');
				//$this->db->where('beer_id',$id);
				//$this->db->update('beer_directory',$data);	
				}		
				$this->db->query("delete from ".$this->db->dbprefix('beer_directory')." where beer_id ='".$id."'");
			}
			
			if($redirect_page == 'list_beer')
			{
				redirect('beer/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/delete');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('beer/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('beer/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
			foreach($beer_id as $id)
			
			{			
				$data = array('status'=>'active');
				$this->db->where('beer_id',$id);
				$this->db->update('beer_directory', $data);
			}
			if($redirect_page == 'list_beer')
			{
				redirect('beer/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/active');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('beer/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('beer/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bar_id.'/'.$offset.'/active');
			}
		}	
		
		if($action=='archived')
		{
			foreach($beer_id as $id)
			
			{			
				$data = array('status'=>'archived');
				$this->db->where('beer_id',$id);
				$this->db->update('beer_directory', $data);
			}
			if($redirect_page == 'list_beer')
			{
				redirect('beer/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/archived');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('beer/'.$redirect_page.'/'.$limit.'/'.$offset.'/archived');
			}
			else
			{
				redirect('beer/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bar_id.'/'.$offset.'/archived');
			}
		}	
		if($action=='inactive')
		{
		
             		
			foreach($beer_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('beer_id',$id);
				$this->db->update('beer_directory', $data);
			}
			
			if($redirect_page == 'list_beer')
			{
				redirect('beer/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/inactive');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('beer/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('beer/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bar_id.'/'.$offset.'/inactive');
			}			
		}		
	}	
	
	function view_beer_comment($id=0,$msg=''){
		
		if(!check_admin_authentication()) {
		redirect('home');
		}
			$check_rights=get_rights('view_beer_comment');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		//echo $id; die;
		$data["one_beer_detail"] = $this->beer_model->get_one_beer($id);
		$data["error"] = "";	
		$data["beer_id"] = $id;
	
	    $data["msg"] = $msg;
		$found = array();
		
		$data['reply'] = $this->beer_model->get_beer_comment_result($id);
		
		if($_POST){
			$this->beer_model->reply_insert($_POST);			
			$msg = "insert"; 
			//echo 'bar/view/'.$limit.'/'.$offset; die;
			 redirect('beer/view_beer_comment/'.$id.'/'.$msg);
			
		}
		$data['total_comment'] = 9;
		//$data['total_comment']=$this->cocktail_model->get_total_bar_comment_count($id);
		//print_r($data['total']); die;
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/beer/view',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();

	}

	function Editbeercomment($id='',$beer_id='')
	{
		
		//valid_pass
		$data['comment'] = $this->beer_model->getbeercomment($id);
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('comment_title', 'Comment Title', 'required');
		$this->form_validation->set_rules('comment_video', 'Video Link', 'valid_url');
		
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
		}else{
			
			$this->beer_model->update_comment($id);
			$data['success']='success';
			$data['msg']='Comment edited successfully.';
			$data['error']='';
			
		}
		if($_POST){
			echo json_encode($data);die;
		}
		$data["site_setting"] = site_setting();
		$theme = getThemeName();
		$data['beer_comment_id']=$id;
		$data['beer_id']=$beer_id;
		
			echo $this->load->view($theme .'/layout/beer/editcomment',$data,TRUE);
		die;
		
		
	}

	
	function delete_comment($beer_id = 0, $beer_comment_id = 0 )
	{
			$check_rights=get_rights('delete_beer_comment');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$qry = $this->db->query("delete from ".$this->db->dbprefix("beer_comment")." where beer_comment_id = '".$beer_comment_id."' or 
		master_comment_id = '".$beer_comment_id."'");
		
		redirect ("beer/view_beer_comment/".$beer_id."/delete");
	}
	function removeimage($beer_id,$image,$limit,$offset,$redirect_page,$option,$keyword)
	{
		//echo "sdfsdf";die;
		if($image!='')
		{
			if(file_exists(base_path().'upload/beer_orig/'.$image))
			{
				$link=base_path().'upload/beer_orig/'.$image;
				unlink($link);
			}
			
			if(file_exists(base_path().'upload/beer_thumb/'.$image))
			{
				$link1=base_path().'upload/beer_thumb/'.$image;
				unlink($link1);
			}			
		}
		$msg='Image Removed';
		//redirect('serviceprovider/list_staff/'.$limit.'/'.$offset.'/'.$msg);
		redirect('beer/edit_beer/'.$beer_id.'/'.$redirect_page.'/'.$limit);
	}	
	
	function add_newbeer($bars_id=0,$limit=0)
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
		
		$check_rights=get_rights('add_newbeer');
		
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
		$data['msg']='';
       // echo $this->input->post('beer_id');
	   // die;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('beer_id[]', 'Beer Name', 'required');
				
		$data['getallbeer'] = $this->beer_model->getallbeer($bars_id);	
		if($this->form_validation->run() == FALSE){			
			if (validation_errors ()) {
					$data["error"] = validation_errors ();
			}else{
				$data["error"] = "";
			}
			
			$data["beer_id"] = $this->input->post('beer_id');
			$data["bars_id"] = $bars_id;
		
		// $data['states']=get_all_state_by_country_id($this->input->post('country_id'));
		// $data['cities']=get_all_city_by_state_id($this->input->post('state'));
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_beer';
			// $data['all_countries']=get_all_country();
			
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
			$this->template->write_view('center',$theme .'/layout/beer/add_newbeer',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				
				$this->beer_model->beernew_insert();			
				$msg = "insert";
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
			$did = $this->input->post('did');
		 	
			 
			if($redirect_page == 'list_beer')
			{
				
				redirect('beer/'.$redirect_page.'/'.$limit.'/'.$this->input->post("bars_id").'/'.$offset.'/'.$msg);
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('beer/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}	
			else
			{
				redirect('beer/'.$redirect_page.'/'.$limit.'/'.$this->input->post("bars_id").'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}

    function getallbeerbybar()
	{
		$operator_list 	 = $this->beer_model->getBeerByBarid($_REQUEST["utype"],$_REQUEST['em']);
		$arr = array();	
		foreach($operator_list as $key=>$val){
			
			$chckexist = checkbeerbarexist($val['beer_id'],$_REQUEST["utype"]);
			if($chckexist==0)
			{
					$arr[] = array("id"=>$val['beer_id'],"label"=>$val['beer_name'],"value"=>$val['beer_name']); 
			}
		
		}
		print_r(json_encode($arr));die;
	}

function import($msg='')
	{
		if(!check_admin_authentication()) {
		redirect('home');
		}
		$check_rights=get_rights('import_beer');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$data = array();    
        $data['error'] = '';    
		$data['msg'] = $msg;
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
        $data['active_menu']='contact';

		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/beer/import',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
			
	}
	
	function import_csv()
	{
		// print_r($_FILES);
		// die;		
			$get = $this->beer_model->importcsv();
			
			// if($get!=0)
			// {	
			// $result="Success";			
			// $msg="Import Successfully";	
			// $limit=20;
			// $offset=0;
			// redirect('beer/list_beer/'.$limit.'/0/'.$offset.'/'.$result);			
			// }
			// else {
				// redirect('beer/list_beer/'.$limit.'/0/'.$offset.'/'.$result);
			// }
	}
	function removeimage1($beer_id,$image,$limit,$offset,$redirect_page,$option,$keyword)
	{
		//echo "sdfsdf";die;
		if($image!='')
		{
			if(file_exists(base_path().'upload/beer_orig/'.$image))
			{
				$link=base_path().'upload/beer_orig/'.$image;
				unlink($link);
			}
			
			if(file_exists(base_path().'upload/beer_thumb/'.$image))
			{
				$link1=base_path().'upload/beer_thumb/'.$image;
				unlink($link1);
			}			
		}
		$msg='Image Removed';
		
		$data = array('image_default'=>'');
				$this->db->where('beer_id',$beer_id);
				$this->db->update('beer_directory', $data);
		//redirect('serviceprovider/list_staff/'.$limit.'/'.$offset.'/'.$msg);
		redirect('beer/edit_beer/'.$beer_id.'/'.$redirect_page.'/'.$limit);
	}
	
	function getallbeer_new()
	{
		$getbeer = $this->beer_model->getallbeer_100('0');
		
		
		foreach($getbeer as $b)
		{
			$slug = getBeerSlug_new($b->beer_slug,$b->beer_id);
			
			$data_insert["beer_slug"] = $slug;
			$this->db->where("beer_id",$b->beer_id);
			$this->db->update('beer_directory',$data_insert);
			
		}
	}
	
	function changebeerstatus()
	{
		    $data_insert["status"] = $this->input->post('status');
			$this->db->where("beer_comment_id",$this->input->post('cmnt_id'));
			$this->db->update('beer_comment',$data_insert);
			
			//echo $this->db->last_query();
			echo "success";
			die;
	}
}
?>