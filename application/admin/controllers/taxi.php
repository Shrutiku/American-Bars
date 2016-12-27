<?php
class Taxi extends  CI_Controller {
	function Taxi()
	{
		ini_set('memory_limit', '2048M');
		parent::__construct();	
		$this->load->model('taxi_model');	
	   $this->load->library('pagination');
	}
	//use:for redirecting at list taxi page
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('taxi/list_taxi');	
	}
	
	/* taxi list
	 * param  : doctor id ,limit,offset,msg
	 * 
	 */
	function list_taxi($limit='10',$offset=0,$msg='',$er='',$er1='') {
		
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		
			$data['er'] = $er;
		$data['er1'] = $er1;
		
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('list_taxi');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
			$this->load->library('pagination');
		
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'taxi/list_taxi/'.$limit.'/';
		$config['total_rows'] = $this->taxi_model->get_total_taxi_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->taxi_model->get_taxi_result($offset,$limit);
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
		$data['redirect_page']='list_taxi';
		
		
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/taxi/list_taxi',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	/* search patitent
	 * param  : doctor id ,limit,option,keyword,offset,msg
	 * 
	 */
	function search_list_taxi($limit=20,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_taxi';
		
		
		
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
		$config['base_url'] = base_url().'taxi/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->taxi_model->get_total_search_taxi_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->taxi_model->get_search_taxi_result($option,$keyword,$offset, $limit);
		
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
		$this->template->write_view('center',$theme .'/layout/taxi/list_taxi',$data,TRUE);
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
		$redirect_page = 'search_list_taxi';
		
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
		$config['base_url'] = base_url().'taxi/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->taxi_model->get_total_search_poker_count($option,$keyword);
		//print_r($config['total_rows']); die;
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->taxi_model->get_search_poker_result($option,$keyword,$offset, $limit);
		
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
		$this->template->write_view('center',$theme .'/layout/taxi/list_taxi',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	/*check unique taxi email
	 * param  : email
	 * return : BOOLEAN
	 */
	function taxiname_check($name)
	{
		$taxiname = $this->taxi_model->taxi_unique($name);
		if($taxiname == FALSE)
		{
			$this->form_validation->set_message('taxiname_check', 'There is an existing record with this Beer Name');
			return FALSE;
		}
		return TRUE;
	}
	
	/*add new taxi also called in taxi update
	 * param  : limit
	 * 
	 */
	function add_taxi($limit=0)
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
		
		$check_rights=get_rights('add_taxi');
		
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
		//$this->form_validation->set_rules('tax_company_name', 'Taxi Company', 'required|callback_taxiname_check');
		$this->form_validation->set_rules('tax_company_name', 'Taxi Company', 'required');
		//$this->form_validation->set_rules('city', 'city', 'required');
		//$this->form_validation->set_rules('state', 'State', 'required');
		//$this->form_validation->set_rules('texi_company_phone_number', 'phone number', 'required');
		$this->form_validation->set_rules('active', 'Status', 'required');
		
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
			
		$data["taxi_id"] = $this->input->post('taxi_id');
		
		$data["tax_company_name"] = $this->input->post('tax_company_name');
		$data["tax_cmpn_address"] = $this->input->post('tax_cmpn_address');
		$data["city"] =$this->input->post('city');
		$data["taxi_id"] = $this->input->post('taxi_id');
		$data["cmpn_zipcode"] = $this->input->post('cmpn_zipcode');
		
		$data["state"] = $this->input->post('state');
		$data["texi_company_phone_number"] = $this->input->post('texi_company_phone_number');
		$data["is_sugested"] = $this->input->post('is_sugested');
		$data["taxi_company_website"] = $this->input->post('taxi_company_website');
		
		$data["status"] = $this->input->post('status');
		$data["reciew"] = $this->input->post('reciew');
		$data["prev_taxi_image"] = $this->input->post('taxi_image');
		$data["image"] = $this->input->post('image');
		$data["prev_taxi_banner"] = $this->input->post('taxi_banner');
		$data["taxi_meta_title"] = $this->input->post('taxi_meta_title');
		$data["taxi_meta_keyword"] = $this->input->post('taxi_meta_keyword');
		$data["taxi_meta_description"] = $this->input->post('taxi_meta_description');
		
		// $data['states']=get_all_state_by_country_id($this->input->post('country_id'));
		// $data['cities']=get_all_city_by_state_id($this->input->post('state'));
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_taxi';
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
			$this->template->write_view('center',$theme .'/layout/taxi/add_taxi',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				
			if($this->input->post('taxi_id')!='')
			{	
				$this->taxi_model->taxi_update($_POST);
				$msg = "update";
			}else{
				$this->taxi_model->taxi_insert($_POST);			
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
		 	
			 
			if($redirect_page == 'list_taxi')
			{
				redirect('taxi/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('taxi/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}	
			else
			{
				redirect('taxi/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	/*taxi update form fill
	 * param  : taxi id,doctor id ,redirect page,option,keyword,limit,offset
	 * 
	 */
	function edit_taxi($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
		
		$check_rights=get_rights('add_taxi');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_taxi = $this->taxi_model->get_one_taxi($id);
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		
		$data["taxi_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		
        $data["tax_company_name"] = $one_taxi['taxi_company'];
		$data["tax_cmpn_address"] =     $one_taxi['address'];
		$data["city"] =$one_taxi['city'];
		$data["state"] = $one_taxi['state'];
		$data["phone_number"] = $one_taxi['phone_number'];
		$data["is_sugested"] = $one_taxi['is_sugested'];
		$data["status"] = $one_taxi['status'];
		$data["taxi_desc"] = $one_taxi['taxi_desc'];
		$data["prev_taxi_image"] = $one_taxi['taxi_image'];
		$data["cmpn_zipcode"] = $one_taxi['cmpn_zipcode'];
		$data["texi_company_phone_number"] = $one_taxi['phone_number'];
		$data["taxi_company_website"] = $one_taxi['cmpn_website'];
		$data["prev_taxi_banner"] = $one_taxi['taxi_banner'];
		$data["reciew"] = $one_taxi['taxi_desc'];
		$data["image"] = $one_taxi['taxi_image'];
		$data["taxi_meta_title"] = $one_taxi['taxi_meta_title'];
		$data["taxi_meta_keyword"] = $one_taxi['taxi_meta_keyword'];
		$data["taxi_meta_description"] = $one_taxi['taxi_meta_description'];
		
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/taxi/add_taxi',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/*delete taxi data
	 * 
	 * 
	 */
	function delete_taxi($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$one_taxi = $this->taxi_model->get_one_taxi($id);
		
		$check_rights=get_rights('list_taxi');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//$this->db->delete('rights_assign',array('taxi_id'=>$id));
	
        
        $one_taxi = $this->taxi_model->get_one_taxi($id);
		
		
		
		$this->db->delete('taxi_directory',array('taxi_id'=>$id));
		if($one_taxi){
		$this->db->delete('user_master',array('user_id'=>$one_taxi['taxi_owner_id']));
		}
		if($redirect_page == 'list_taxi')
		{
			
			redirect('taxi/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('taxi/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	/*delete , active , inactive multiple taxi at a time
	 * param  : taxi id,doctor id ,redirect page,search option,search keyword,limit,offset,msg
	 * 
	 */ 
	function action_taxi()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('list_taxi');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
		
		$taxi_id =$this->input->post('chk');
			
		if($action=='delete')
		{
		
			    		
			foreach($taxi_id as $id)
			{
				$one_taxi = $this->taxi_model->get_one_taxi($id);
				$this->db->delete('taxi_directory',array('taxi_id'=>$id));
				if($one_taxi){
				$this->db->delete('user_master',array('user_id'=>$one_taxi['taxi_owner_id']));
				}
			}
			
			if($redirect_page == 'list_taxi')
			{
				redirect('taxi/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('taxi/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('taxi/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
			foreach($taxi_id as $id)
			
			{			
				$data = array('status'=>'active');
				$this->db->where('taxi_id',$id);
				$this->db->update('taxi_directory', $data);
			}
			if($redirect_page == 'list_taxi')
			{
				redirect('taxi/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('taxi/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('taxi/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
			}
		}	
		
		if($action=='archived')
		{
			foreach($taxi_id as $id)
			
			{			
				$data = array('status'=>'archived');
				$this->db->where('taxi_id',$id);
				$this->db->update('taxi_directory', $data);
			}
			if($redirect_page == 'list_taxi')
			{
				redirect('taxi/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('taxi/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('taxi/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive')
		{
		
             		
			foreach($taxi_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('taxi_id',$id);
				$this->db->update('taxi_directory', $data);
			}
			
			if($redirect_page == 'list_taxi')
			{
				redirect('taxi/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('taxi/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('taxi/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');

			}
			
			
		}	
		
		
		
		
	}
	
	

	// Use :This function use for edit of update bar.
	// Param :bar id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	function view($id=0,$msg=''){
		
	
		if(!check_admin_authentication()) {
		redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		
		//echo $id; die;
		$data["one_taxi_detail"] = $this->taxi_model->get_one_taxi($id);
		
	
		$data["error"] = "";
		// $data["limit"]=$limit;
		// $data["offset"]=$offset;
		// $data["option"]=$option;
		// $data["keyword"]=$keyword;
		// $data["search_option"]=$option;
		// $data["search_keyword"]=$keyword;
		// $data["redirect_page"]=$redirect_page;
		
		$data["taxi_id"] = $id;
	
	   $data["msg"] = $msg;
		$found = array();
		
		$data['reply'] = $this->taxi_model->get_taxi_comment_result($id);
		
		
	
		
		if($_POST){
			$this->taxi_model->reply_insert($_POST);			
			$msg = "insert"; 
			//echo 'bar/view/'.$limit.'/'.$offset; die;
			 redirect('taxi/view/'.$id.'/'.$msg);
			
		}
		$data['total_comment'] = 9;
		//$data['total_comment']=$this->taxi_model->get_total_bar_comment_count($id);
		//print_r($data['total']); die;
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/taxi/view',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();

	}
	
	function delete_comment($taxi_id = 0, $taxi_comment_id = 0 )
	{
		$qry = $this->db->query("delete from ".$this->db->dbprefix("taxi_comment")." where taxi_comment_id = '".$taxi_comment_id."' or 
		master_comment_id = '".$taxi_comment_id."'");
		
		redirect ("taxi/view/".$taxi_id."/delete");
	}
	function removeimage($taxi_id,$image,$limit,$offset,$redirect_page,$option,$keyword)
	{
		//echo "sdfsdf";die;
		if($image!='')
		{
			if(file_exists(base_path().'upload/taxi_orig/'.$image))
			{
				$link=base_path().'upload/taxi_orig/'.$image;
				unlink($link);
			}
			
			if(file_exists(base_path().'upload/taxi_thumb/'.$image))
			{
				$link1=base_path().'upload/taxi_thumb/'.$image;
				unlink($link1);
			}			
		}
		$msg='Image Removed';
		//redirect('serviceprovider/list_staff/'.$limit.'/'.$offset.'/'.$msg);
		redirect('taxi/edit_taxi/'.$taxi_id.'/'.$redirect_page.'/'.$limit);
	}
	
	function import_taxi($msg='')
	{
		if(!check_admin_authentication()) {
		redirect('home');
		}
		
		$check_rights=get_rights('import_taxi');
		
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
		$this->template->write_view('center',$theme .'/layout/taxi/import',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
			
	}
	
	function import_csv()
	{
			$get = $this->taxi_model->importcsv();
			
	}
}
?>