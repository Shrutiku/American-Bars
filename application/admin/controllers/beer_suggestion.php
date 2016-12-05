<?php
class Beer_suggestion extends  CI_Controller {
	function Beer_suggestion()
	{
		parent::__construct();	
		$this->load->model('beer_suggestion_model');	
		$this->load->library('pagination');
	  
	}
	//use:for redirecting at list beer_suggestion page
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('beer_suggestion/list_beer_suggestion');	
	}
	
	/* beer_suggestion list
	 * param  : doctor id ,limit,offset,msg
	 * 
	 */
	function list_beer_suggestion($limit='10',$bars_id=0, $offset=0,$msg='') {
		
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
		
		$check_rights=get_rights('list_beer_suggestion');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
			$this->load->library('pagination');
		
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'beer_suggestion/list_beer_suggestion/'.$limit.'/'.$bars_id. "/";
		$config['total_rows'] = $this->beer_suggestion_model->get_total_beer_suggestion_count($bars_id);
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->beer_suggestion_model->get_beer_suggestion_result($offset,$limit,$bars_id);
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
		$data['redirect_page']='list_beer_suggestion';
		$data["bars_id"] = $bars_id ;
		
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/beer_suggestion/list_beer_suggestion',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	/* search patitent
	 * param  : doctor id ,limit,option,keyword,offset,msg
	 * 
	 */
	function search_list_beer_suggestion($limit=20,$bars_id = 0,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		
		$check_rights=get_rights('search_list_beer_suggestion');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_beer_suggestion';
		
		
		
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
		$config['base_url'] = base_url().'beer_suggestion/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$option.'/'.$keyword;
		$config['total_rows'] = $this->beer_suggestion_model->get_total_search_beer_suggestion_count($option,$keyword,$bars_id);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->beer_suggestion_model->get_search_beer_suggestion_result($option,$keyword,$offset, $limit,$bars_id);
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
		$this->template->write_view('center',$theme .'/layout/beer_suggestion/list_beer_suggestion',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	/*check unique beer_suggestion email
	 * param  : email
	 * return : BOOLEAN
	 */
	function beer_suggestionname_check($name)
	{
		$beer_suggestionname = $this->beer_suggestion_model->beer_suggestion_unique($name);
		if($beer_suggestionname == FALSE)
		{
			$this->form_validation->set_message('beer_suggestionname_check', 'There is an existing record with this beer_suggestion Name');
			return FALSE;
		}
		return TRUE;
	}
	
	/*add new beer_suggestion also called in beer_suggestion update
	 * param  : limit
	 * 
	 */
	function add_beer_suggestion($bars_id=0,$limit=0)
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
		
		$check_rights=get_rights('add_beer_suggestion');
		
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
		$this->form_validation->set_rules('beer_suggestion_name', 'beer_suggestion Name', 'required|callback_beer_suggestionname_check');
		$this->form_validation->set_rules('beer_suggestion_type', 'beer_suggestion Type', 'required');
		$this->form_validation->set_rules('producer', 'Producer', 'required');
		$this->form_validation->set_rules('city_produced', 'city produced', 'required');
		$this->form_validation->set_rules('beer_suggestion_desc', 'Description', 'required');
		$this->form_validation->set_rules('beer_suggestion_desc', 'Description', 'required');
		$this->form_validation->set_rules('abv', 'ABV ', 'required');
				
		$video_error = '';		
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
		}
		
		if($this->form_validation->run() == FALSE || $video_error != ""){			
			if (validation_errors () || $video_error != "") {
					$data["error"] = validation_errors ();
					$data["error"] .= $video_error;
			}else{
				$data["error"] = "";
			}
			
			$data["beer_suggestion_id"] = $this->input->post('beer_suggestion_id');
			
			$data["beer_suggestion_name"] = $this->input->post('beer_suggestion_name');
			$data["beer_suggestion_type"] = $this->input->post('beer_suggestion_type');
			$data["producer"] =$this->input->post('producer');
			$data["city_produced"] = $this->input->post("city_produced");
			$data["abv"] = $this->input->post("abv");		
			$data["status"] = $this->input->post('status');
			$data['prev_beer_suggestion_image']=$this->input->post('prev_beer_suggestion_image');
			$data["beer_suggestion_desc"] = $this->input->post('beer_suggestion_desc');
			$data["beer_suggestion_website"] = $this->input->post('beer_suggestion_website');
			$data["bar_id"] = $this->input->post('bar_id');
			$data["is_suggested"] = $this->input->post('bar_id');
			$data["bars_id"] = $bars_id;
		
		// $data['states']=get_all_state_by_country_id($this->input->post('country_id'));
		// $data['cities']=get_all_city_by_state_id($this->input->post('state'));
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_beer_suggestion';
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
			$this->template->write_view('center',$theme .'/layout/beer_suggestion/add_beer_suggestion',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				
			if($this->input->post('beer_suggestion_id')!='')
			{	
				$this->beer_suggestion_model->beer_suggestion_update($_POST);
				$msg = "update";
			}else{
				$this->beer_suggestion_model->beer_suggestion_insert($_POST);			
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
		 	
			 
			if($redirect_page == 'list_beer_suggestion')
			{
				
				redirect('beer_suggestion/'.$redirect_page.'/'.$limit.'/'.$this->input->post("bars_id").'/'.$offset.'/'.$msg);
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('beer_suggestion/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}	
			else
			{
				redirect('beer_suggestion/'.$redirect_page.'/'.$limit.'/'.$this->input->post("bars_id").'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	/*beer_suggestion update form fill
	 * param  : beer_suggestion id,doctor id ,redirect page,option,keyword,limit,offset
	 * 
	 */
	function edit_beer_suggestion($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0,$bars_id = 0)
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
		
		$check_rights=get_rights('edit_beer_suggestion');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_beer_suggestion = $this->beer_suggestion_model->get_one_beer_suggestion($id);
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		
		$data["beer_suggestion_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		
		
		
		
		$data["beer_suggestion_name"] = $one_beer_suggestion['beer_suggestion_name'];
		$data["beer_suggestion_type"] = $one_beer_suggestion['beer_suggestion_type'];
		$data["producer"] =  $one_beer_suggestion['producer'];
		$data["city_produced"] = $one_beer_suggestion['city_produced'];
		$data["status"] = $one_beer_suggestion['status'];
		$data['prev_beer_suggestion_image']= $one_beer_suggestion['beer_suggestion_image'];
		$data["beer_suggestion_desc"] = $one_beer_suggestion['beer_suggestion_desc'];
		$data["beer_suggestion_website"] = $one_beer_suggestion['beer_suggestion_website'];
		$data["bar_id"] = $one_beer_suggestion['bar_id'];
		$data["abv"] = $one_beer_suggestion['abv'];		
		$data["is_suggested"] = $one_beer_suggestion['is_suggested'];
		$data["bars_id"] = $bars_id;
		
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/beer_suggestion/add_beer_suggestion',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/*delete beer_suggestion data
	 * param  : beer_suggestion id,doctor id ,option,keyword,limit,offset,msg
	 * 
	 */
	function delete_beer_suggestion($id=0,$redirect_page='',$option='',$keyword='',$bars_id = 0,$limit=20,$offset=0)
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
	
		
		$check_rights=get_rights('delete_beer_suggestion');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//$this->db->delete('rights_assign',array('beer_suggestion_id'=>$id));
		
		if($bars_id > 0 && is_numeric($bars_id))
		{
			
			$this->db->query("delete from ".$this->db->dbprefix('beer_bars')." where bar_id ='".$bars_id."' and beer_id='".$id."'");
		}
		else {
			// $data=array('is_deleted'=>'yes');
			// $this->db->where('beer_id',$id);
			// $this->db->update('beer_directory',$data);
			
			$this->db->query("delete from ".$this->db->dbprefix('beer_directory')." where beer_id ='".$id."'");
		}
		
        
        
		
		//$this->db->delete('beer_suggestion',array('beer_suggestion_id'=>$id));
		if($redirect_page == 'list_beer_suggestion')
		{
			redirect('beer_suggestion/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$offset.'/delete');
		}
		else
		{
			redirect('beer_suggestion/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	/*delete , active , inactive multiple beer_suggestion at a time
	 * param  : beer_suggestion id,doctor id ,redirect page,search option,search keyword,limit,offset,msg
	 * 
	 */ 
	function action_beer_suggestion()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_beer_suggestion');
		
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
		
		$beer_suggestion_id =$this->input->post('chk');
			
		if($action=='delete')
		{
		
			    		
			foreach($beer_suggestion_id as $id)
			{
				if($bar_id > 0 && is_numeric($bar_id))
				{
					$this->db->query("delete from ".$this->db->dbprefix('beer_bars')." where bar_id ='".$bar_id."' and beer_id='".$id."'");
				}
				else {
					// $data=array('is_deleted'=>'yes');
				// $this->db->where('beer_id',$id);
				// $this->db->update('beer_directory',$data);	
				
				$this->db->query("delete from ".$this->db->dbprefix('beer_directory')." where beer_id ='".$id."'");
				}		
				//$this->db->query("delete from ".$this->db->dbprefix('beer_suggestion')." where beer_suggestion_id ='".$id."'");
			}
			
			if($redirect_page == 'list_beer_suggestion')
			{
				redirect('beer_suggestion/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/delete');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('beer_suggestion/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('beer_suggestion/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
			foreach($beer_suggestion_id as $id)
			
			{			
				$data = array('status'=>'active');
				$this->db->where('beer_id',$id);
				$this->db->update('beer_directory', $data);
			}
			if($redirect_page == 'list_beer_suggestion')
			{
				redirect('beer_suggestion/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/active');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('beer_suggestion/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('beer_suggestion/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bar_id.'/'.$offset.'/active');
			}
		}	
			
	}	
	
	function view($id=0,$msg=''){
		
		if(!check_admin_authentication()) {
		redirect('home');
		}

$check_rights=get_rights('view_beer_suggestion');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		//echo $id; die;
		$data["one_beer_suggestion_detail"] = $this->beer_suggestion_model->get_one_beer_suggestion($id);
		$data["error"] = "";	
		$data["beer_suggestion_id"] = $id;
	
	    $data["msg"] = $msg;
		 $data_update = array("states"=>'read');
	    $this->db->where("beer_id",$id);
	    $this->db->update("beer_directory",$data_update);
		//$data['total_comment']=$this->cocktail_model->get_total_bar_comment_count($id);
		//print_r($data['total']); die;
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/beer_suggestion/view',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();

	}
	
	function delete_comment($beer_suggestion_id = 0, $beer_suggestion_comment_id = 0 )
	{
		$qry = $this->db->query("delete from ".$this->db->dbprefix("beer_suggestion_comment")." where beer_suggestion_comment_id = '".$beer_suggestion_comment_id."' or 
		master_comment_id = '".$beer_suggestion_comment_id."'");
		
		redirect ("beer_suggestion/view/".$beer_suggestion_id."/delete");
	}
	function removeimage($beer_suggestion_id,$image,$limit,$offset,$redirect_page,$option,$keyword)
	{
		//echo "sdfsdf";die;
		if($image!='')
		{
			if(file_exists(base_path().'upload/beer_suggestion_orig/'.$image))
			{
				$link=base_path().'upload/beer_suggestion_orig/'.$image;
				unlink($link);
			}
			
			if(file_exists(base_path().'upload/beer_suggestion_thumb/'.$image))
			{
				$link1=base_path().'upload/beer_suggestion_thumb/'.$image;
				unlink($link1);
			}			
		}
		$msg='Image Removed';
		//redirect('serviceprovider/list_staff/'.$limit.'/'.$offset.'/'.$msg);
		redirect('beer_suggestion/edit_beer_suggestion/'.$beer_suggestion_id.'/'.$redirect_page.'/'.$limit);
	}	
	


    function getallbeer_suggestionbybar()
	{
		$operator_list 	 = $this->beer_suggestion_model->getbeer_suggestionByBarid($_REQUEST["utype"],$_REQUEST['em']);
		$arr = array();	
		foreach($operator_list as $key=>$val){
			
			$chckexist = checkbeer_suggestionbarexist($val['beer_suggestion_id'],$_REQUEST["utype"]);
			if($chckexist==0)
			{
					$arr[] = array("id"=>$val['beer_suggestion_id'],"label"=>$val['beer_suggestion_name'],"value"=>$val['beer_suggestion_name']); 
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
		$this->template->write_view('center',$theme .'/layout/beer_suggestion/import',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
			
	}
	
	function import_csv()
	{
		// print_r($_FILES);
		// die;		
			$get = $this->beer_suggestion_model->importcsv();
			
			// if($get!=0)
			// {	
			// $result="Success";			
			// $msg="Import Successfully";	
			// $limit=20;
			// $offset=0;
			// redirect('beer_suggestion/list_beer_suggestion/'.$limit.'/0/'.$offset.'/'.$result);			
			// }
			// else {
				// redirect('beer_suggestion/list_beer_suggestion/'.$limit.'/0/'.$offset.'/'.$result);
			// }
	}
}
?>