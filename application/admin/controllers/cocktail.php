<?php
class Cocktail extends  CI_Controller {
	function Cocktail()
	{
		parent::__construct();	
		$this->load->model('cocktail_model');	
	   $this->load->library('pagination');
	}
	//use:for redirecting at list cocktail page
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('cocktail/list_cocktail');	
	}
	
	/* cocktail list
	 * param  : doctor id ,limit,offset,msg
	 * 
	 */
	function list_cocktail($limit='10',$bars_id=0,$offset=0,$msg='',$er='',$er1='')  {
		
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
		
		$check_rights=get_rights('list_cocktail');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
			$this->load->library('pagination');
		$data['er'] = $er;
	   $data['er1'] = $er1;
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'cocktail/list_cocktail/'.$limit.'/'.$bars_id.'/';
		$config['total_rows'] = $this->cocktail_model->get_total_cocktail_count($bars_id);
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->cocktail_model->get_cocktail_result($offset,$limit,$bars_id);
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
		$data['redirect_page']='list_cocktail';
		$data["bars_id"] = $bars_id ;
		
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/cocktail/list_cocktail',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	/* search patitent
	 * param  : doctor id ,limit,option,keyword,offset,msg
	 * 
	 */
	function search_list_cocktail($limit=20,$bars_id = 0,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('search_list_cocktail');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_cocktail';
		$data['er'] = '';
	    $data['er1'] = '';
		
		
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

	
		$config['uri_segment']='7';
		$config['base_url'] = base_url().'cocktail/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$option.'/'.$keyword;
		$config['total_rows'] = $this->cocktail_model->get_total_search_cocktail_count($option,$keyword,$bars_id);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->cocktail_model->get_search_cocktail_result($option,$keyword,$offset, $limit,$bars_id);
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
		$this->template->write_view('center',$theme .'/layout/cocktail/list_cocktail',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	/*check unique cocktail email
	 * param  : email
	 * return : BOOLEAN
	 */
	function cocktailname_check($name)
	{
		$cocktailname = $this->cocktail_model->cocktail_unique($name);
		if($cocktailname == FALSE)
		{
			$this->form_validation->set_message('cocktailname_check', 'There is an existing record with this Cocktail Name');
			return FALSE;
		}
		return TRUE;
	}
	
	/*add new cocktail also called in cocktail update
	 * param  : limit
	 * 
	 */
	function add_cocktail($bars_id=0,$limit=0)
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
		
		$check_rights=get_rights('add_cocktail');
		
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
		$this->form_validation->set_rules('cocktail_name', 'Cocktail Name', 'required');
		//$this->form_validation->set_rules('ingredients', 'Ingredients', 'required');
		//$this->form_validation->set_rules('how_to_make_it', 'Hoe to make it', 'required');
		//$this->form_validation->set_rules('base_spirit', 'Base Spirit', 'required');
		//$this->form_validation->set_rules('type', 'Type', 'required');
		//$this->form_validation->set_rules('served', 'Served', 'required');
		//$this->form_validation->set_rules('preparation', 'Preparation', 'required');
		//$this->form_validation->set_rules('strength', 'Strength', 'required');
		//$this->form_validation->set_rules('difficulty', 'Difficulty', 'required');
		//$this->form_validation->set_rules('flavor_profile', 'Flavor Profile', 'required');	
	//	$this->form_validation->set_rules('cocktail_meta_title', 'Meta Title', 'required');
	//	$this->form_validation->set_rules('cocktail_meta_keyword', 'Meta Keyword', 'required');
	//	$this->form_validation->set_rules('cocktail_meta_description', 'Meta Description', 'required');
						
		$video_error = '';
		$exist_error = '';
		$exist_error1= '';
		if($_POST)
		{			
			$image_arr = array('image/gif','image/jpeg', 'image/pjpeg','image/jpeg', 'image/pjpeg','image/jpeg', 'image/pjpeg','image/png',  'image/x-png');
			if($_FILES["file_up"]["name"]!="")
			{
				if(!in_array($_FILES["file_up"]["type"],$image_arr))
				{
					$video_error .= "<p>Please upload jpg,jpeg,png,gif format only</p>";
				}
			}
			
				$exist_error = $this->cocktail_model->cocktail_name_n(trim($this->input->post('cocktail_name')),trim($this->input->post('ingredients')),trim($this->input->post('how_to_make_it')),trim($this->input->post('base_spirit')),trim($this->input->post('type')),trim($this->input->post('served')),trim($this->input->post('strength')),trim($this->input->post('difficulty')),$this->input->post('cocktail_id'));
				
				if($exist_error==1)
				{
					$exist_error1 .= "<p>Cocktail already exixting please change at least one field.</p>";
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
			
		$data["cocktail_id"] = $this->input->post('cocktail_id');		
		$data["cocktail_name"] = $this->input->post('cocktail_name');
		$data["cocktail_slug"] = $this->input->post('cocktail_slug');
		$data["ingredients"] = $this->input->post('ingredients');
		$data["glassware"] = $this->input->post('glassware');
		$data["how_to_make_it"] =$this->input->post('how_to_make_it');
	
		$data["is_suggested"] = $this->input->post('is_suggested');
		$data["base_spirit"] = $this->input->post('base_spirit');
		$data["type"] = $this->input->post('type');
		$data["served"] = $this->input->post('served');
		//$data["preparation"] = $this->input->post('preparation');
		$data["strength"] = $this->input->post('strength');
		$data["difficulty"] = $this->input->post('difficulty');
		//$data["flavor_profile"] = $this->input->post('flavor_profile');
		$data["prev_cocktail_image"] = $this->input->post('prev_cocktail_image');
		$data["prev_cocktail_image1"] = $this->input->post('prev_cocktail_image1');
		$data["video_link"] = $this->input->post('video_link');
		$data["status"] = $this->input->post('status');
		$data["upload_type"] = $this->input->post('upload_type');
		$data["cocktail_meta_title"] = $this->input->post('cocktail_meta_title');
			$data["cocktail_meta_keyword"] = $this->input->post('cocktail_meta_keyword');
			$data["cocktail_meta_description"] = $this->input->post('cocktail_meta_description');
		$data["bars_id"] = $bars_id;
		
		// $data['states']=get_all_state_by_country_id($this->input->post('country_id'));
		// $data['cities']=get_all_city_by_state_id($this->input->post('state'));
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_cocktail';
			// $data['all_countries']=get_all_country();
			
			$data['site_setting'] = site_setting();
			
		
			if($this->input->post('offset')=="")
			{
				$limit = '10';
				$totalRows = $this->cocktail_model->get_total_cocktail_count($bars_id);
				$data["offset"] = 0;
			}else{
				$data["offset"] = $this->input->post('offset');
			}
			
			
			
			$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
			 $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/cocktail/add_cocktail',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				
			if($this->input->post('cocktail_id')!='')
			{	
				$this->cocktail_model->cocktail_update($_POST);
				$msg = "update";
			}else{
				$this->cocktail_model->cocktail_insert($_POST);			
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
		 	
			 
			if($redirect_page == 'list_cocktail')
			{
				redirect('cocktail/'.$redirect_page.'/'.$limit.'/'.$this->input->post("bars_id").'/'.$offset.'/'.$msg);
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('cocktail/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}	
			else
			{
				redirect('cocktail/'.$redirect_page.'/'.$limit.'/'.$this->input->post("bars_id").'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}


	function add_newcocktail($bars_id=0,$limit=0)
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
		
		$check_rights=get_rights('add_newcocktail');
		
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
		$this->form_validation->set_rules('cocktail_id', 'Cocktail Name', 'required');
		
		
		if($this->form_validation->run() == FALSE){
			if (validation_errors ())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			
		$data["cocktail_id"] = $this->input->post('cocktail_id');
		
		$data['getallcocktail'] = $this->cocktail_model->getallcocktail($bars_id);		
		$data["bars_id"] = $bars_id;
		
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_cocktail';
			
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
			$this->template->write_view('center',$theme .'/layout/cocktail/add_newcocktail',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				$this->cocktail_model->cocktail_newinsert($_POST);			
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
		 	
			 
			if($redirect_page == 'list_cocktail')
			{
				redirect('cocktail/'.$redirect_page.'/'.$limit.'/'.$this->input->post("bars_id").'/'.$offset.'/'.$msg);
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('cocktail/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}	
			else
			{
				redirect('cocktail/'.$redirect_page.'/'.$limit.'/'.$this->input->post("bars_id").'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	/*cocktail update form fill
	 * param  : cocktail id,doctor id ,redirect page,option,keyword,limit,offset
	 * 
	 */
	function edit_cocktail($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0,$bars_id = 0)
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
		
		$check_rights=get_rights('edit_cocktail');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_cocktail = $this->cocktail_model->get_one_cocktail($id);
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		
		$data["cocktail_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		
		
		
		
		$data["cocktail_name"] = $one_cocktail['cocktail_name'];
        $data["ingredients"] = $one_cocktail['ingredients'];
		$data["how_to_make_it"] = $one_cocktail['how_to_make_it'];
		$data["is_suggested"] = $one_cocktail['is_suggested'];
		$data["cocktail_slug"] = $one_cocktail['cocktail_slug'];
		$data["glassware"] = $one_cocktail['glassware'];
		$data["base_spirit"] = $one_cocktail['base_spirit'];
		$data["type"] = $one_cocktail['type'];
		$data["served"] = $one_cocktail['served'];
		//$data["preparation"] = $one_cocktail['preparation'];
		$data["strength"] = $one_cocktail['strength'];
		$data["difficulty"] = $one_cocktail['difficulty'];
		//$data["flavor_profile"] = $one_cocktail['flavor_profile'];
		
		$data["prev_cocktail_image"] = $one_cocktail['cocktail_image'];
		$data["prev_cocktail_image1"] = $one_cocktail['image_default'];
		$data["upload_type"] = $one_cocktail['upload_type'];
		$data["video_link"] = $one_cocktail['video_link'];
		$data["status"] = $one_cocktail['status'];
		$data["cocktail_meta_title"] = $one_cocktail['cocktail_meta_title'];
		$data["cocktail_meta_keyword"] = $one_cocktail['cocktail_meta_keyword'];
		$data["cocktail_meta_description"] = $one_cocktail['cocktail_meta_description'];
		$data["bars_id"] = $bars_id;
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/cocktail/add_cocktail',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/*delete cocktail data
	 * 
	 * 
	 */
	function delete_cocktail($id=0,$redirect_page='',$option='',$keyword='',$bars_id = 0,$limit=20,$offset=0)
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_cocktail');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//$this->db->delete('rights_assign',array('cocktail_id'=>$id));
		if($bars_id > 0 && is_numeric($bars_id))
				{
					$this->db->query("delete from ".$this->db->dbprefix('cocktail_bars')." where bar_id ='".$bars_id."' and cocktail_id='".$id."'");
				}
				else {
		// $data=array('is_deleted'=>'yes');
		// $this->db->where('cocktail_id',$id);
		// $this->db->update('cocktail_directory',$data);
		
		$this->db->query("delete from ".$this->db->dbprefix('cocktail_directory')." where cocktail_id='".$id."'");
		}
        
		
		//$this->db->delete('cocktail',array('cocktail_id'=>$id));
		if($redirect_page == 'list_cocktail')
		{
			
			redirect('cocktail/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$offset.'/delete');
		}
		else
		{
			redirect('cocktail/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');
		}
	}
	
	/*delete , active , inactive multiple cocktail at a time
	 * param  : cocktail id,doctor id ,redirect page,search option,search keyword,limit,offset,msg
	 * 
	 */ 
	function action_cocktail()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_cocktail');
		
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
		$cocktail_id =$this->input->post('chk');
			
		if($action=='delete')
		{
		
			    		
			foreach($cocktail_id as $id)
			{
				if($bar_id > 0 && is_numeric($bar_id))
				{
					$this->db->query("delete from ".$this->db->dbprefix('cocktail_bars')." where bar_id ='".$bar_id."' and cocktail_id='".$id."'");
				}
				else {
				// $data=array('is_deleted'=>'yes');
				// $this->db->where('cocktail_id',$id);
				// $this->db->update('cocktail_directory',$data);
				
				$this->db->query("delete from ".$this->db->dbprefix('cocktail_directory')." where cocktail_id='".$id."'");
				}			
				//$this->db->query("delete from ".$this->db->dbprefix('cocktail')." where cocktail_id ='".$id."'");
			}
			
			if($redirect_page == 'list_cocktail')
			{
				redirect('cocktail/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/delete');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('cocktail/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('cocktail/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');
			}
			
		}
			
		if($action=='active')
		{
			foreach($cocktail_id as $id)
			
			{			
				$data = array('status'=>'active');
				$this->db->where('cocktail_id',$id);
				$this->db->update('cocktail_directory', $data);
			}
			if($redirect_page == 'list_cocktail')
			{
				redirect('cocktail/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/active');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('cocktail/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('cocktail/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bar_id.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive')
		{
		
             		
			foreach($cocktail_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('cocktail_id',$id);
				$this->db->update('cocktail_directory', $data);
			}
			
			if($redirect_page == 'list_cocktail')
			{
				redirect('cocktail/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/inactive');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('cocktail/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('cocktail/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bar_id.'/'.$offset.'/inactive');

			}
			
			
		}	
		
		if($action=='archived')
		{
		
             		
			foreach($cocktail_id as $id)
			{			
				$data = array('status'=>'archived');
				$this->db->where('cocktail_id',$id);
				$this->db->update('cocktail_directory', $data);
			}
			
			if($redirect_page == 'list_cocktail')
			{
				redirect('cocktail/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/inactive');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('cocktail/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('cocktail/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bar_id.'/'.$offset.'/inactive');

			}
			
			
		}	
		
		
		
		
	}
	
	

	// Use :This function use for edit of update bar.
	// Param :bar id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	function view_cocktail_comment($id=0,$msg=''){
		
	
		if(!check_admin_authentication()) {
		redirect('home');
		}
		$check_rights=get_rights('view_cocktail_comment');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		
		//echo $id; die;
		$data["one_cocktail_detail"] = $this->cocktail_model->get_one_cocktail($id);
		
	
		$data["error"] = "";
		// $data["limit"]=$limit;
		// $data["offset"]=$offset;
		// $data["option"]=$option;
		// $data["keyword"]=$keyword;
		// $data["search_option"]=$option;
		// $data["search_keyword"]=$keyword;
		// $data["redirect_page"]=$redirect_page;
		
		$data["cocktail_id"] = $id;
	
	   $data["msg"] = $msg;
		$found = array();
		
		$data['reply'] = $this->cocktail_model->get_cocktail_comment_result($id);
		
		
	
		
		if($_POST){
			$this->cocktail_model->reply_insert($_POST);			
			$msg = "insert"; 
			//echo 'bar/view/'.$limit.'/'.$offset; die;
			 redirect('cocktail/view_cocktail_comment/'.$id.'/'.$msg);
			
		}
		$data['total_comment'] = 9;
		//$data['total_comment']=$this->cocktail_model->get_total_bar_comment_count($id);
		//print_r($data['total']); die;
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/cocktail/view',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();

	}
	
	function delete_comment($cocktail_id = 0, $cocktail_comment_id = 0 )
	{
		$check_rights=get_rights('delete_comment_cocktail');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$qry = $this->db->query("delete from ".$this->db->dbprefix("cocktail_comment")." where cocktail_comment_id = '".$cocktail_comment_id."' or 
		master_comment_id = '".$cocktail_comment_id."'");
		
		redirect ("cocktail/view_cocktail_comment/".$cocktail_id."/delete");
	}
	function removeimage($cocktail_id,$image,$limit,$offset,$redirect_page,$option,$keyword)
	{
		//echo "sdfsdf";die;
		if($image!='')
		{
			if(file_exists(base_path().'upload/cocktail_orig/'.$image))
			{
				$link=base_path().'upload/cocktail_orig/'.$image;
				unlink($link);
			}
			
			if(file_exists(base_path().'upload/cocktail_thumb/'.$image))
			{
				$link1=base_path().'upload/cocktail_thumb/'.$image;
				unlink($link1);
			}			
		}
		$msg='Image Removed';
		//redirect('serviceprovider/list_staff/'.$limit.'/'.$offset.'/'.$msg);
		redirect('cocktail/edit_cocktail/'.$cocktail_id.'/'.$redirect_page.'/'.$limit);
	}
	function removeimage1($cocktail_id,$image,$limit,$offset,$redirect_page,$option,$keyword)
	{
		//echo "sdfsdf";die;
		if($image!='')
		{
			if(file_exists(base_path().'upload/cocktail_orig/'.$image))
			{
				$link=base_path().'upload/cocktail_orig/'.$image;
				unlink($link);
			}
			
			if(file_exists(base_path().'upload/cocktail_thumb/'.$image))
			{
				$link1=base_path().'upload/cocktail_thumb/'.$image;
				unlink($link1);
			}			
		}
		$msg='Image Removed';
		
		$data = array('image_default'=>'');
				$this->db->where('cocktail_id',$cocktail_id);
				$this->db->update('cocktail_directory', $data);
		//redirect('serviceprovider/list_staff/'.$limit.'/'.$offset.'/'.$msg);
		redirect('cocktail/edit_cocktail/'.$cocktail_id.'/'.$redirect_page.'/'.$limit);
	}
	 function getallcocktailbybar()
	{
		$operator_list 	 = $this->cocktail_model->getCocktailByBarid($_REQUEST["utype"],$_REQUEST['em']);
		$arr = array();	
		foreach($operator_list as $key=>$val){
			$chckexist = checkcocktailbarexist($val['cocktail_id'],$_REQUEST["utype"]);
			if($chckexist==0)
			{
			$arr[] = array("id"=>$val['cocktail_id'],"label"=>$val['cocktail_name'],"value"=>$val['cocktail_name']);
			} 
		}
		print_r(json_encode($arr));die;
	}
	function import($msg='')
	{
		if(!check_admin_authentication()) {
		redirect('home');
		}
		$check_rights=get_rights('import_cocktail');
		
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
		$this->template->write_view('center',$theme .'/layout/cocktail/import',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
			
	}
	
	function import_csv()
	{		
			$get = $this->cocktail_model->importcsv();
	
	}
	
	 function download()
	{
		 $keyword=($this->input->post('key')!='')?str_replace(' ','-',$this->input->post('key')):'1V1';
         $option=($this->input->post('opt')!='')?str_replace(' ','-',$this->input->post('opt')):'1V1';
		 $typ=($this->input->post('typ')!='')?str_replace('', '-', $this->input->post('typ')):'1v1';
		 $result = $this->cocktail_model->getAllCocktailResult($typ,$option,$keyword);
		 
		 //echo "<pre>";
		 
		
		 $filename ="Cocktail_Record.csv";
         $this->load->dbutil();
         $delimiter = ",";
         $newline = "\r\n";
		 
         $data= $this->dbutil->csv_from_result($result, $delimiter, $newline);
		 
         //$this->load->helper('download');
        // force_download($filename, $data);
		 
		//$data = ltrim(strstr($this->dbutil->csv_from_result($result, ',', "\r\n"), "\r\n"));
		
		$this->load->helper('download');
		force_download("cocktailrecord.csv", $data);
		
		
		exit;
	}
	function changecocktailstatus()
	{
		    $data_insert["status"] = $this->input->post('status');
			$this->db->where("cocktail_comment_id",$this->input->post('cmnt_id'));
			$this->db->update('cocktail_comment',$data_insert);
			
			//echo $this->db->last_query();
			echo "success";
			die;
	}

function Editcocktailcomment($id='',$cocktail_id='')
	{
		
		//valid_pass
		$data['comment'] = $this->cocktail_model->getcocktailcomment($id);
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
			
			$this->cocktail_model->update_comment($id);
			$data['success']='success';
			$data['msg']='Comment edited successfully.';
			$data['error']='';
			
		}
		if($_POST){
			echo json_encode($data);die;
		}
		$data["site_setting"] = site_setting();
		$theme = getThemeName();
		$data['cocktail_comment_id']=$id;
		$data['cocktail_id']=$cocktail_id;
		
			echo $this->load->view($theme .'/layout/cocktail/editcomment',$data,TRUE);
		die;
		
		
	}
	
	
}
?>