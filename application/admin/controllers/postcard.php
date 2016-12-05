<?php
class Postcard extends  CI_Controller {
	function Postcard()
	{
		parent::__construct();	
		$this->load->model('postcard_model');	
		$this->load->library('pagination');
	  
	}
	//use:for redirecting at list postcard page
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('postcard/list_postcard');	
	}
	
	/* postcard list
	 * param  : doctor id ,limit,offset,msg
	 * 
	 */
	function list_postcard($limit='10',$bars_id =0,$offset=0,$msg='') {
		
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
		
		$check_rights=get_rights('list_postcard');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
			$this->load->library('pagination');
		
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'postcard/list_postcard/'.$limit.'/'.$bars_id.'/';
		$config['total_rows'] = $this->postcard_model->get_total_postcard_count($bars_id);
	
	  
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->postcard_model->get_postcard_result($offset,$limit,$bars_id);
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
		$data['redirect_page']='list_postcard';
		$data["bars_id"] = $bars_id ;
		
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/postcard/list_postcard',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/* search patitent	 * param  : doctor id ,limit,option,keyword,offset,msg	 * 	 */
	function search_list_postcard($limit=20,$option='',$keyword='',$bars_id = 0,$offset=0,$msg='')
	{		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('search_list_postcard');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_postcard';
		
		
		
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
		$config['base_url'] = base_url().'postcard/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bars_id.'/';
		$config['total_rows'] = $this->postcard_model->get_total_search_postcard_count($option,$keyword,$bars_id);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->postcard_model->get_search_postcard_result($option,$keyword,$offset, $limit,$bars_id);
		
		$data['msg'] = $msg;
		$data['offset'] = $offset;
		$data['site_setting'] = site_setting();
		$data["bars_id"] = $bars_id;
		$data['limit']=$limit;
		$data['option']=$option;
		$data['keyword']=$keyword;
		$data['search_type']='search';
		$data['redirect_page']=$redirect_page;		
		
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/postcard/list_postcard',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/*check unique postcard email
	 * param  : email
	 * return : BOOLEAN
	 */
	function postcardname_check($name)
	{
		$postcardname = $this->postcard_model->postcard_unique($name);
		if($postcardname == FALSE)
		{
			$this->form_validation->set_message('postcardname_check', 'There is an existing record with this News Name');
			return FALSE;
		}
		return TRUE;
	}
	
	/*add new postcard also called in postcard update
	 * param  : limit
	 * 
	 */
	function add_postcard($limit=0)
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
		
		$check_rights=get_rights('add_postcard');
		
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
		$this->form_validation->set_rules('postcard_title', 'News Title', 'required|callback_postcardname_check');
		$this->form_validation->set_rules('postcard_category', 'News Category', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');		
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			
			$data["postcard_id"] = $this->input->post('postcard_id');		
			$data["postcard_title"] = $this->input->post('postcard_title');
			$data["postcard_desc"] = $this->input->post('postcard_desc');
			$data["postcard_category"] =$this->input->post('postcard_category');
			$data["status"] = $this->input->post('status');
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_postcard';
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
			$this->template->write_view('center',$theme .'/layout/postcard/add_postcard',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}
		else
		{				
			if($this->input->post('postcard_id')!='')
			{	
				$this->postcard_model->postcard_update();
				$msg = "update";
			}else{
				$this->postcard_model->postcard_insert();			
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
		 	
			 
			if($redirect_page == 'list_postcard')
			{
				redirect('postcard/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			elseif ($redirect_page == 'list_postcard') {
				redirect('postcard/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}	
			else
			{
				redirect('postcard/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	/*postcard update form fill
	 * param  : postcard id,doctor id ,redirect page,option,keyword,limit,offset
	 * 
	 */
	function edit_postcard($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
		
		$check_rights=get_rights('edit_postcard');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_postcard = $this->postcard_model->get_one_postcard($id);
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		
		$data["postcard_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		
		$data["postcard_id"] = $one_postcard['postcard_id'];
		$data["postcard_title"] = $one_postcard['postcard_title'];
		$data["postcard_desc"] = $one_postcard['postcard_desc'];
		$data["postcard_category"] = $one_postcard['postcard_category'];
		$data["status"] = $one_postcard['status'];
		$data["author_name"] = $one_postcard['author_name'];
		
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/postcard/add_postcard',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/*delete postcard data
	 * param  : postcard id,doctor id ,option,keyword,limit,offset,msg
	 * 
	 */
	function delete_postcard($id=0,$redirect_page='',$option='',$keyword='',$bars_id = 0,$limit=20,$offset=0)
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_postcard');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$this->db->query("delete from ".$this->db->dbprefix('bar_post_card')." where postcard_id ='".$id."'");
				// $data = array('is_delete'=>'1');
				// $this->db->where('postcard_id',$id);
				// $this->db->update('bar_post_card', $data);
// 	
		$this->db->delete('bar_post_card',array('postcard_id'=>$id));
		if($redirect_page == 'list_postcard')
		{			
			redirect('postcard/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$offset.'/delete');
		}
		else
		{
			redirect('postcard/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bars_id.'/'.$offset.'/delete');
		}
	}
	
	/*delete , active , inactive multiple postcard at a time
	 * param  : postcard id,doctor id ,redirect page,search option,search keyword,limit,offset,msg
	 * 
	 */ 
	function action_postcard()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_postcard');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');

		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
		$bars_id = $this->input->post("bars_id");
		$postcard_id =$this->input->post('chk');
			
		if($action=='delete')
		{			    		
			foreach($postcard_id as $id)
			{
				//$this->db->where('postcard_id',$id);
				//$this->db->delete('postcard',$data);			
				$this->db->query("delete from ".$this->db->dbprefix('bar_post_card')." where postcard_id ='".$id."'");				
				
				// $data = array('is_delete'=>'1');
				// $this->db->where('postcard_id',$id);
				// $this->db->update('bar_post_card', $data);
			}
			
			if($redirect_page == 'list_postcard')
			{
				redirect('postcard/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$offset.'/delete');
			}
			else
			{
				redirect('postcard/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bars_id.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
			foreach($postcard_id as $id)
			
			{			
				$data = array('status'=>'active');
				$this->db->where('postcard_id',$id);
				$this->db->update('bar_post_card', $data);
			}
			if($redirect_page == 'list_postcard')
			{
				redirect('postcard/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$offset.'/active');
			}
			else
			{
				redirect('postcard/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bars_id.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive')
		{             		
			foreach($postcard_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('postcard_id',$id);
				$this->db->update('bar_post_card', $data);
			}			
			if($redirect_page == 'list_postcard')
			{
				redirect('postcard/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('postcard/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bars_id.'/'.$offset.'/inactive');

			}			
		}
		
		if($action=='pending')
		{
			foreach($postcard_id as $id)			
			{			
				$data = array('status'=>'pending');
				$this->db->where('postcard_id',$id);
				$this->db->update('bar_post_card', $data);
			}
			if($redirect_page == 'list_postcard')
			{
				redirect('postcard/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$offset.'/pending');
			}
			else
			{
				redirect('postcard/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bars_id.'/'.$offset.'/pendding');
			}
		}
		if($action=='deliver')
		{
			foreach($postcard_id as $id)			
			{			
				$data = array('status'=>'deliver');
				$this->db->where('postcard_id',$id);
				$this->db->update('bar_post_card', $data);
			}
			if($redirect_page == 'list_postcard')
			{
				redirect('postcard/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$offset.'/deliver');
			}
			else
			{
				redirect('postcard/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bars_id.'/'.$offset.'/deliver');
			}
		}				
	}

    function view($id=0,$msg=''){
		
	
		if(!check_admin_authentication()) {
		redirect('home');
		}
$check_rights=get_rights('view_postcard');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		
		//echo $id; die;
		//$data["one_cocktail_detail"] = $this->cocktail_model->get_one_cocktail($id);
		$data['one_postcard'] = $this->postcard_model->get_one_postcard($id);
	
	 
	//  print_r($data['one_postcard']);
	$data["error"] = "";
		// $data["limit"]=$limit;
		// $data["offset"]=$offset;
		// $data["option"]=$option;
		// $data["keyword"]=$keyword;
		// $data["search_option"]=$option;
		// $data["search_keyword"]=$keyword;
		// $data["redirect_page"]=$redirect_page;
		
		$data["postcard_id"] = $id;
		$data["site_setting"] = site_setting();
	
	   $data["msg"] = $msg;
		
		
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/postcard/view',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();

	}
	
	function print_postcard($id=0)
	{
		
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
		
		$data['one_order'] = $this->postcard_model->get_one_postcard($id);
		
		$data['site_setting'] = site_setting();
			
		$this->load->view($theme .'/layout/postcard/printpostcard',$data);
		//$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		//$this->template->render();
	}		
}
?>