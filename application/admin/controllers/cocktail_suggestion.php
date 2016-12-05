<?php
class cocktail_suggestion extends  CI_Controller {
	function cocktail_suggestion()
	{
		parent::__construct();	
		$this->load->model('cocktail_suggestion_model');	
	   $this->load->library('pagination');
	}
	//use:for redirecting at list cocktail_suggestion page
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('cocktail_suggestion/list_cocktail_suggestion');	
	}
	
	/* cocktail_suggestion list
	 * param  : doctor id ,limit,offset,msg
	 * 
	 */
	function list_cocktail_suggestion($limit='10',$bars_id=0,$offset=0,$msg='') {
		
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
		
		$check_rights=get_rights('list_cocktail_suggestion');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
			$this->load->library('pagination');
		
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'cocktail_suggestion/list_cocktail_suggestion/'.$limit.'/'.$bars_id.'/';
		$config['total_rows'] = $this->cocktail_suggestion_model->get_total_cocktail_suggestion_count($bars_id);
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->cocktail_suggestion_model->get_cocktail_suggestion_result($offset,$limit,$bars_id);
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
		$data['redirect_page']='list_cocktail_suggestion';
		$data["bars_id"] = $bars_id ;
		
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/cocktail_suggestion/list_cocktail_suggestion',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	/* search patitent
	 * param  : doctor id ,limit,option,keyword,offset,msg
	 * 
	 */
	function search_list_cocktail_suggestion($limit=20,$bars_id = 0,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('search_list_cocktail_suggestion');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_cocktail_suggestion';
		
		
		
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

	
		$config['uri_segment']='8';
		$config['base_url'] = base_url().'cocktail_suggestion/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$option.'/'.$keyword;
		$config['total_rows'] = $this->cocktail_suggestion_model->get_total_search_cocktail_suggestion_count($option,$keyword,$bars_id);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->cocktail_suggestion_model->get_search_cocktail_suggestion_result($option,$keyword,$offset, $limit,$bars_id);
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
		$this->template->write_view('center',$theme .'/layout/cocktail_suggestion/list_cocktail_suggestion',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	/*check unique cocktail_suggestion email
	 * param  : email
	 * return : BOOLEAN
	 */
	function cocktail_suggestionname_check($name)
	{
		$cocktail_suggestionname = $this->cocktail_suggestion_model->cocktail_suggestion_unique($name);
		if($cocktail_suggestionname == FALSE)
		{
			$this->form_validation->set_message('cocktail_suggestionname_check', 'There is an existing record with this cocktail_suggestion Name');
			return FALSE;
		}
		return TRUE;
	}
	
	/*add new cocktail_suggestion also called in cocktail_suggestion update
	 * param  : limit
	 * 
	 */
	function add_cocktail_suggestion($bars_id=0,$limit=0)
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
		
		$check_rights=get_rights('add_cocktail_suggestion');
		
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
		$this->form_validation->set_rules('cocktail_suggestion_name', 'cocktail_suggestion Name', 'required|callback_cocktail_suggestionname_check');
		$this->form_validation->set_rules('ingredients', 'Ingredients', 'required');
		$this->form_validation->set_rules('how_to_make_it', 'Hoe to make it', 'required');
		$this->form_validation->set_rules('base_spirit', 'Base Spirit', 'required');
		$this->form_validation->set_rules('type', 'Type', 'required');
		$this->form_validation->set_rules('served', 'Served', 'required');
		$this->form_validation->set_rules('preparation', 'Preparation', 'required');
		$this->form_validation->set_rules('strength', 'Strength', 'required');
		$this->form_validation->set_rules('difficulty', 'Difficulty', 'required');
		$this->form_validation->set_rules('flavor_profile', 'Flavor Profile', 'required');	
						
		$video_error = '';
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
		}		
		
		if($this->form_validation->run() == FALSE || $video_error != ""){
			if (validation_errors () || $video_error != "")
			{
				$data["error"] = validation_errors();
				$data["error"] .= $video_error;
			}else{
				$data["error"] = "";
			}
			
		$data["cocktail_suggestion_id"] = $this->input->post('cocktail_suggestion_id');		
		$data["cocktail_suggestion_name"] = $this->input->post('cocktail_suggestion_name');
		$data["ingredients"] = $this->input->post('ingredients');
		$data["how_to_make_it"] =$this->input->post('how_to_make_it');
	
		$data["is_suggested"] = $this->input->post('is_suggested');
		$data["base_spirit"] = $this->input->post('base_spirit');
		$data["type"] = $this->input->post('type');
		$data["served"] = $this->input->post('served');
		$data["preparation"] = $this->input->post('preparation');
		$data["strength"] = $this->input->post('strength');
		$data["difficulty"] = $this->input->post('difficulty');
		$data["flavor_profile"] = $this->input->post('flavor_profile');
		$data["prev_cocktail_suggestion_image"] = $this->input->post('prev_cocktail_suggestion_image');
		$data["status"] = $this->input->post('status');
		$data["bars_id"] = $bars_id;
		
		// $data['states']=get_all_state_by_country_id($this->input->post('country_id'));
		// $data['cities']=get_all_city_by_state_id($this->input->post('state'));
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_cocktail_suggestion';
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
			$this->template->write_view('center',$theme .'/layout/cocktail_suggestion/add_cocktail_suggestion',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				
			if($this->input->post('cocktail_suggestion_id')!='')
			{	
				$this->cocktail_suggestion_model->cocktail_suggestion_update($_POST);
				$msg = "update";
			}else{
				$this->cocktail_suggestion_model->cocktail_suggestion_insert($_POST);			
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
		 	
			 
			if($redirect_page == 'list_cocktail_suggestion')
			{
				redirect('cocktail_suggestion/'.$redirect_page.'/'.$limit.'/'.$this->input->post("bars_id").'/'.$offset.'/'.$msg);
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('cocktail_suggestion/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}	
			else
			{
				redirect('cocktail_suggestion/'.$redirect_page.'/'.$limit.'/'.$this->input->post("bars_id").'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}


	function add_newcocktail_suggestion($bars_id=0,$limit=0)
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
		
		$check_rights=get_rights('add_newcocktail_suggestion');
		
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
		$this->form_validation->set_rules('cocktail_suggestion_id', 'cocktail_suggestion Name', 'required');
		
		
		if($this->form_validation->run() == FALSE){
			if (validation_errors ())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			
		$data["cocktail_suggestion_id"] = $this->input->post('cocktail_suggestion_id');
		
		$data['getallcocktail_suggestion'] = $this->cocktail_suggestion_model->getallcocktail_suggestion($bars_id);		
		$data["bars_id"] = $bars_id;
		
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_cocktail_suggestion';
			
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
			$this->template->write_view('center',$theme .'/layout/cocktail_suggestion/add_newcocktail_suggestion',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				$this->cocktail_suggestion_model->cocktail_suggestion_newinsert($_POST);			
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
		 	
			 
			if($redirect_page == 'list_cocktail_suggestion')
			{
				redirect('cocktail_suggestion/'.$redirect_page.'/'.$limit.'/'.$this->input->post("bars_id").'/'.$offset.'/'.$msg);
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('cocktail_suggestion/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}	
			else
			{
				redirect('cocktail_suggestion/'.$redirect_page.'/'.$limit.'/'.$this->input->post("bars_id").'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	/*cocktail_suggestion update form fill
	 * param  : cocktail_suggestion id,doctor id ,redirect page,option,keyword,limit,offset
	 * 
	 */
	function edit_cocktail_suggestion($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0,$bars_id = 0)
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
		
		$check_rights=get_rights('edit_cocktail_suggestion');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_cocktail_suggestion = $this->cocktail_suggestion_model->get_one_cocktail_suggestion($id);
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		
		$data["cocktail_suggestion_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		
		
		
		
		$data["cocktail_suggestion_name"] = $one_cocktail_suggestion['cocktail_suggestion_name'];
        $data["ingredients"] = $one_cocktail_suggestion['ingredients'];
		$data["how_to_make_it"] = $one_cocktail_suggestion['how_to_make_it'];
		$data["is_suggested"] = $one_cocktail_suggestion['is_suggested'];
		
		$data["base_spirit"] = $one_cocktail_suggestion['base_spirit'];
		$data["type"] = $one_cocktail_suggestion['type'];
		$data["served"] = $one_cocktail_suggestion['served'];
		$data["preparation"] = $one_cocktail_suggestion['preparation'];
		$data["strength"] = $one_cocktail_suggestion['strength'];
		$data["difficulty"] = $one_cocktail_suggestion['difficulty'];
		$data["flavor_profile"] = $one_cocktail_suggestion['flavor_profile'];
		
		$data["prev_cocktail_suggestion_image"] = $one_cocktail_suggestion['cocktail_suggestion_image'];
		$data["status"] = $one_cocktail_suggestion['status'];
		$data["bars_id"] = $bars_id;
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/cocktail_suggestion/add_cocktail_suggestion',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/*delete cocktail_suggestion data
	 * 
	 * 
	 */
	function delete_cocktail_suggestion($id=0,$redirect_page='',$option='',$keyword='',$bars_id = 0,$limit=20,$offset=0)
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_cocktail_suggestion');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//$this->db->delete('rights_assign',array('cocktail_suggestion_id'=>$id));
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
        
		
		//$this->db->delete('cocktail_suggestion',array('cocktail_suggestion_id'=>$id));
		if($redirect_page == 'list_cocktail_suggestion')
		{
			
			redirect('cocktail_suggestion/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$offset.'/delete');
		}
		else
		{
			redirect('cocktail_suggestion/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');
		}
	}
	
	/*delete , active , inactive multiple cocktail_suggestion at a time
	 * param  : cocktail_suggestion id,doctor id ,redirect page,search option,search keyword,limit,offset,msg
	 * 
	 */ 
	function action_cocktail_suggestion()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_cocktail_suggestion');
		
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
		$cocktail_suggestion_id =$this->input->post('chk');
			
		if($action=='delete')
		{
		
			    		
			foreach($cocktail_suggestion_id as $id)
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
				//$this->db->query("delete from ".$this->db->dbprefix('cocktail_suggestion')." where cocktail_suggestion_id ='".$id."'");
			}
			
			if($redirect_page == 'list_cocktail_suggestion')
			{
				redirect('cocktail_suggestion/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/delete');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('cocktail_suggestion/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('cocktail_suggestion/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');
			}
			
		}
			
		if($action=='active')
		{
			foreach($cocktail_suggestion_id as $id)
			
			{			
				$data = array('status'=>'active');
				$this->db->where('cocktail_id',$id);
				$this->db->update('cocktail_directory', $data);
			}
			if($redirect_page == 'list_cocktail_suggestion')
			{
				redirect('cocktail_suggestion/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/active');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('cocktail_suggestion/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('cocktail_suggestion/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bar_id.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive')
		{
		
             		
			foreach($cocktail_suggestion_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('cocktail_suggestion_id',$id);
				$this->db->update('cocktail_suggestion_directory', $data);
			}
			
			if($redirect_page == 'list_cocktail_suggestion')
			{
				redirect('cocktail_suggestion/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/inactive');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('cocktail_suggestion/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('cocktail_suggestion/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bar_id.'/'.$offset.'/inactive');

			}
			
			
		}	
		
		
		
		
	}
	
	

	// Use :This function use for edit of update bar.
	// Param :bar id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	function viewcoktail($id=0,$msg=''){
		
	
		if(!check_admin_authentication()) {
		redirect('home');
		}
$check_rights=get_rights('viewcoktail_suggestion');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		
		//echo $id; die;
		$data["one_cocktail_suggestion_detail"] = $this->cocktail_suggestion_model->get_one_cocktail_suggestion($id);
		
	
		$data["error"] = "";
		// $data["limit"]=$limit;
		// $data["offset"]=$offset;
		// $data["option"]=$option;
		// $data["keyword"]=$keyword;
		// $data["search_option"]=$option;
		// $data["search_keyword"]=$keyword;
		// $data["redirect_page"]=$redirect_page;
		
		$data["cocktail_suggestion_id"] = $id;
	
	    $data_update = array("states"=>'read');
	    $this->db->where("cocktail_id",$id);
	    $this->db->update("cocktail_directory",$data_update);
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/cocktail_suggestion/view',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();

	}
	
	function removeimage($cocktail_suggestion_id,$image,$limit,$offset,$redirect_page,$option,$keyword)
	{
		//echo "sdfsdf";die;
		if($image!='')
		{
			if(file_exists(base_path().'upload/cocktail_suggestion_orig/'.$image))
			{
				$link=base_path().'upload/cocktail_suggestion_orig/'.$image;
				unlink($link);
			}
			
			if(file_exists(base_path().'upload/cocktail_suggestion_thumb/'.$image))
			{
				$link1=base_path().'upload/cocktail_suggestion_thumb/'.$image;
				unlink($link1);
			}			
		}
		$msg='Image Removed';
		//redirect('serviceprovider/list_staff/'.$limit.'/'.$offset.'/'.$msg);
		redirect('cocktail_suggestion/edit_cocktail_suggestion/'.$cocktail_suggestion_id.'/'.$redirect_page.'/'.$limit);
	}
	 function getallcocktail_suggestionbybar()
	{
		$operator_list 	 = $this->cocktail_suggestion_model->getcocktail_suggestionByBarid($_REQUEST["utype"],$_REQUEST['em']);
		$arr = array();	
		foreach($operator_list as $key=>$val){
			$chckexist = checkcocktail_suggestionbarexist($val['cocktail_suggestion_id'],$_REQUEST["utype"]);
			if($chckexist==0)
			{
			$arr[] = array("id"=>$val['cocktail_suggestion_id'],"label"=>$val['cocktail_suggestion_name'],"value"=>$val['cocktail_suggestion_name']);
			} 
		}
		print_r(json_encode($arr));die;
	}
	function import($msg='')
	{
		if(!check_admin_authentication()) {
		redirect('home');
		}
		$data = array();    
        $data['error'] = '';    
		$data['msg'] = $msg;
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
        $data['active_menu']='contact';

		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/cocktail_suggestion/import',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
			
	}
	
	function import_csv()
	{		
			$get = $this->cocktail_suggestion_model->importcsv();
// 			
			// $data = array();
			// $get = '';
			// $data['msg'] = $msg;	
// 			
// 			
			// if($get==0)
			// {	
				// $msg = "csv_mot_valid";
				// redirect('cocktail_suggestion/import/'.$msg);	
			// }
			// elseif($get=='') {
// 				
				// $result="Success";			
			// $msg="Import Successfully";	
			// $limit=20;
			// $offset=0;
			// redirect('cocktail_suggestion/list_cocktail_suggestion/'.$limit.'/0/'.$offset.'/'.$result);	
			// }		
	}
}
?>