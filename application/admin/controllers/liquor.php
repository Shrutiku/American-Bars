<?php
class Liquor extends  CI_Controller {
	function Liquor()
	{
		parent::__construct();	
		$this->load->model('liquor_model');	
	   $this->load->library('pagination');
	}
	//use:for redirecting at list liquor page
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('liquor/list_liquor');	
	}
	
	/* liquor list
	 * param  : doctor id ,limit,offset,msg
	 * 
	 */
	function list_liquor($limit=20,$bars_id =0,$offset=0,$msg='',$er='',$er1='') {
		
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
		
		$check_rights=get_rights('list_liquor');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//	$this->load->library('pagination');
		
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'liquor/list_liquor/'.$limit.'/'.$bars_id. "/";
		$config['total_rows'] = $this->liquor_model->get_total_liquor_count($bars_id);
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->liquor_model->get_liquor_result($offset,$limit,$bars_id);
		
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
		$data['redirect_page']='list_liquor';
		
		$data["bars_id"] = $bars_id ;
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/liquor/list_liquor',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	/* search patitent
	 * param  : doctor id ,limit,option,keyword,offset,msg
	 * 
	 */
	function search_list_liquor($limit=20,$bars_id = 0,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('search_list_liquor');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_liquor';
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

	
		$config['uri_segment']='8';
		$config['base_url'] = base_url().'liquor/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bars_id;
		$config['total_rows'] = $this->liquor_model->get_total_search_liquor_count($option,$keyword,$bars_id);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->liquor_model->get_search_liquor_result($option,$keyword,$offset, $limit,$bars_id);
		
		$data['msg'] = $msg;
		$data['offset'] = $offset;
		$data['site_setting'] = site_setting();
		
		$data['limit']=$limit;
		$data['option']=$option;
		$data['keyword']=$keyword;
		$data['search_type']='search';
		$data['redirect_page']=$redirect_page;
		$data["bars_id"] = $bars_id;
		
		
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/liquor/list_liquor',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	
	/*check unique liquor email
	 * param  : email
	 * return : BOOLEAN
	 */
	function liquorname_check($name)
	{
		$liquorname = $this->liquor_model->liquor_unique($name);
		if($liquorname == FALSE)
		{
			$this->form_validation->set_message('liquorname_check', 'There is an existing record with this liquor Name');
			return FALSE;
		}
		return TRUE;
	}
	
	/*add new liquor also called in liquor update
	 * param  : limit
	 * 
	 */
	function add_liquor($bars_id = 0,$limit=20)
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
		
		$check_rights=get_rights('add_liquor');
		
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
		$this->form_validation->set_rules('liquor_title', 'liquor Title', 'required');
		///$this->form_validation->set_rules('type', 'Type', 'required');
		//$this->form_validation->set_rules('proof', 'Proof', 'required');
		//$this->form_validation->set_rules('producer', 'Producer', 'required');
		//$this->form_validation->set_rules('country', 'Country', 'required');
		//$this->form_validation->set_rules('liquor_meta_title', 'Meta Title', 'required');
		//$this->form_validation->set_rules('liquor_meta_keyword', 'Meta Keyword', 'required');
		//$this->form_validation->set_rules('liquor_meta_description', 'Meta Description', 'required');
		
		$video_error = '';
		$exist_error = '';
		$exist_error1= '';
		
		if($_POST)
		{
			$exist_error = $this->liquor_model->liquor_unique_v(trim($this->input->post('liquor_title')),trim($this->input->post('type')),trim($this->input->post('proof')),trim($this->input->post('producer')),trim($this->input->post('country')),$this->input->post('liquor_id'));
				if($exist_error==1)
				{
					$exist_error1 .= "<p>Liquor already exixting please change at least one field.</p>";
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
			
		$data["liquor_id"] = $this->input->post('liquor_id');
		
		$data["liquor_title"] = $this->input->post('liquor_title');
		$data["type"] = $this->input->post('type');
		$data["size"] = $this->input->post('size');
		$data["proof"] = $this->input->post('proof');
		$data["producer"] = $this->input->post('producer');
		$data["country"] =$this->input->post('country');
		$data["bar_id"] = $this->input->post('bar_id');
		$data["status"] = $this->input->post('status');
		$data["liquor_description"] = $this->input->post('liquor_description');
		$data["prev_liquor_image1"] = $this->input->post('prev_liquor_image1');
			$data["video_link"] = $this->input->post('video_link');
			$data["upload_type"] = $this->input->post('upload_type');
			$data["liquor_slug"] =  $this->input->post('liquor_slug');
		$data["bars_id"] = $bars_id;
		$data["prev_bar_logo"] = $this->input->post('prev_bar_logo');
		$data["liquor_meta_title"] = $this->input->post('liquor_meta_title');
		$data["liquor_meta_keyword"] = $this->input->post('liquor_meta_keyword');
		$data["liquor_meta_description"] = $this->input->post('liquor_meta_description');
		
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_liquor';
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
			$this->template->write_view('center',$theme .'/layout/liquor/add_liquor',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				
			if($this->input->post('liquor_id')!='')
			{	
				$this->liquor_model->liquor_update($_POST);
				$msg = "update";
			}else{
				$this->liquor_model->liquor_insert($_POST);			
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
		 	
			 
			if($redirect_page == 'list_liquor')
			{
				redirect('liquor/'.$redirect_page.'/'.$limit.'/'.$this->input->post("bars_id").'/'.$offset.'/'.$msg);
			}
			
			else
			{
				
				redirect('liquor/'.$redirect_page.'/'.$limit.'/'.$this->input->post("bars_id").'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	/*liquor update form fill
	 * param  : liquor id,doctor id ,redirect page,option,keyword,limit,offset
	 * 
	 */
	function edit_liquor($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0,$bars_id = 0)
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
		
		$check_rights=get_rights('edit_liquor');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_liquor = $this->liquor_model->get_one_liquor($id);
		//$data['imageGallery']=$this->liquor_model->getImageliquor($id);
		
		
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		
		$data["liquor_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		
        $data["liquor_title"] = $one_liquor['liquor_title'];
		$data["liquor_description"] =  $one_liquor['liquor_description'];
	    $data["type"] = $one_liquor['type'];
		$data["proof"] = $one_liquor['proof'];
		$data["producer"] = $one_liquor['producer'];
		$data["country"] = $one_liquor['country'];
		$data["size"] = $one_liquor['size'];
		$data["prev_bar_logo"] = $one_liquor['liquor_image'];
		$data["status"] = $one_liquor['status'];
		$data["liquor_slug"] = $one_liquor['liquor_slug'];
		$data["bar_id"] = $one_liquor['bar_id'];
		$data["liquor_meta_title"] = $one_liquor['liquor_meta_title'];
		$data["liquor_meta_keyword"] = $one_liquor['liquor_meta_keyword'];
		$data["liquor_meta_description"] = $one_liquor['liquor_meta_description'];
		$data["prev_liquor_image1"] = $one_liquor['image_default'];
		$data["upload_type"] = $one_liquor['upload_type'];
		$data["video_link"] = $one_liquor['video_link'];
		
		$data["bars_id"] = $bars_id;
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/liquor/add_liquor',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/*delete liquor data
	 * 
	 * 
	 */
	function delete_liquor($id=0,$redirect_page='',$option='',$keyword='',$bars_id = 0,$limit=20,$offset=0)
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_liquor');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//$this->db->delete('rights_assign',array('liquor_id'=>$id));
		// $data=array('is_deleted'=>'yes');
		// $this->db->where('liquor_id',$id);
		// $this->db->update('liquors',$data);
        
        
		$this->db->query("delete from ".$this->db->dbprefix('liquors')." where liquor_id='".$id."'");
		//$this->db->delete('liquor',array('liquor_id'=>$id));
		if($redirect_page == 'list_liquor')
		{
			
			redirect('liquor/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$offset.'/delete');
		}
		else
		{
		redirect('liquor/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bars_id.'/'.$offset.'/delete');

		}
	}
	
	/*delete , active , inactive multiple liquor at a time
	 * param  : liquor id,doctor id ,redirect page,search option,search keyword,limit,offset,msg
	 * 
	 */ 
	function action_liquor()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_liquor');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
		$bar_id = $this->input->post("bar_id");
		
		$liquor_id =$this->input->post('chk');
			
		if($action=='delete')
		{
		
			    		
			foreach($liquor_id as $id)
			{
				// $data=array('is_deleted'=>'yes');
				// $this->db->where('liquor_id',$id);
				// $this->db->update('liquors',$data);	
				
						
				$this->db->query("delete from ".$this->db->dbprefix('liquors')." where liquor_id ='".$id."'");
			}
			
			if($redirect_page == 'list_liquor')
			{
				redirect('liquor/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/delete');
			}
			
			else
			{
				redirect('liquor/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bar_id.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
			foreach($liquor_id as $id)
			
			{			
				$data = array('status'=>'active');
				$this->db->where('liquor_id',$id);
				$this->db->update('liquors', $data);
			}
			
			
			if($redirect_page == 'list_liquor')
			{
				redirect('liquor/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/active');
			}
			
			else
			{
				redirect('liquor/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bar_id.'/'.$offset.'/active');

			}
		}	
		
		if($action=='archived')
		{
			foreach($liquor_id as $id)
			
			{			
				$data = array('status'=>'archived');
				$this->db->where('liquor_id',$id);
				$this->db->update('liquors', $data);
			}
			
			
			if($redirect_page == 'list_liquor')
			{
				redirect('liquor/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/active');
			}
			
			else
			{
				redirect('liquor/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bar_id.'/'.$offset.'/active');

			}
		}	
		if($action=='inactive')
		{
		
             		
			foreach($liquor_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('liquor_id',$id);
				$this->db->update('liquors', $data);
			}
			
			
			if($redirect_page == 'list_liquor')
			{
				redirect('liquor/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/inactive');
			}
			
			else
			{
				redirect('liquor/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bar_id.'/'.$offset.'/inactive');

			}
			
			
		}	
		
		
		
		
	}
	
	

	// Use :This function use for edit of update bar.
	// Param :bar id,redirect page,option,keyword,limit,offset
	// Return :'N/A'
	function view_liquor_comment($id=0,$msg=''){
		
	
		if(!check_admin_authentication()) {
		redirect('home');
		}
		$check_rights=get_rights('view_liquor_comment');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		
		//echo $id; die;
		$data["one_liquor_detail"] = $this->liquor_model->get_one_liquor($id);
		
	
		$data["error"] = "";
		// $data["limit"]=$limit;
		// $data["offset"]=$offset;
		// $data["option"]=$option;
		// $data["keyword"]=$keyword;
		// $data["search_option"]=$option;
		// $data["search_keyword"]=$keyword;
		// $data["redirect_page"]=$redirect_page;
		
		$data["liquor_id"] = $id;
	
	   $data["msg"] = $msg;
		$found = array();
		
		$data['reply'] = $this->liquor_model->get_liquor_comment_result($id);
		
		
	
		
		if($_POST){
			$this->liquor_model->reply_insert($_POST);			
			$msg = "insert"; 
			//echo 'bar/view/'.$limit.'/'.$offset; die;
			 redirect('liquor/view_liquor_comment/'.$id.'/'.$msg);
			
		}
		$data['total_comment'] = 9;
		//$data['total_comment']=$this->liquor_model->get_total_bar_comment_count($id);
		//print_r($data['total']); die;
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/liquor/view',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();

	}
	
	function delete_comment($liquor_id = 0, $liquor_comment_id = 0 )
	{
		$check_rights=get_rights('delete_comment_liquor');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$qry = $this->db->query("delete from ".$this->db->dbprefix("liquor_comment")." where liquor_comment_id = '".$liquor_comment_id."' or 
		master_comment_id = '".$liquor_comment_id."'");
		
		redirect ("liquor/view_liquor_comment/".$liquor_id."/delete");
	}
	function removeimage($liquor_id,$image,$limit,$offset,$redirect_page,$option,$keyword)
	{
		
		if($image!='')
		{
			if(file_exists(base_path().'upload/liquor_orig/'.$image))
			{
				$link=base_path().'upload/liquor_orig/'.$image;
				unlink($link);
			}
			
			if(file_exists(base_path().'upload/liquor_thumb/'.$image))
			{
				$link1=base_path().'upload/liquor_thumb/'.$image;
				unlink($link1);
			}			
		}
		$msg='Image Removed';
		//redirect('serviceprovider/list_staff/'.$limit.'/'.$offset.'/'.$msg);
		//redirect('liquor/edit_liquor/'.$liquor_id.'/'.$redirect_page.'/'.$limit);
		redirect('liquor/edit_liquor/'.$liquor_id.'/'.$redirect_page.'/'.$limit.'/1V1/1V1/'.$offset);
	}

    function removeImageAjax($id=0)
	{
		$oneImage=$this->liquor_model->getOneImageliquor($id);
		//print_r($oneImage);die;
		if($oneImage!='')
		{
			if($oneImage->liquor_image_name!=''){
			if(file_exists(base_path().'upload/bar_liquorgallery_orig/'.$oneImage->liquor_image_name))
			{
				unlink(base_path().'upload/bar_liquorgallery_orig/'.$oneImage->liquor_image_name);
			}
			if(file_exists(base_path().'upload/bar_liquorgallery_thumb/'.$oneImage->liquor_image_name))
			{
				unlink(base_path().'upload/bar_liquorgallery_thumb/'.$oneImage->liquor_image_name);
			}
			if(file_exists(base_path().'upload/bar_liquorgallery_thumb_big/'.$oneImage->liquor_image_name))
			{
				unlink(base_path().'upload/bar_liquorgallery_thumb_big/'.$oneImage->liquor_image_name);
			}
			
			}
			$this->db->where('liquor_image_id',$oneImage->liquor_image_id)->delete('liquor_images');
			
			
		}
		
	}

    function add_newliquor($bars_id=0,$limit=0)
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
			$check_rights=get_rights('add_newliquor');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		
		if($limit > 0)
		{
			$data['limit']=$limit;
		}
		else
		{
			$data['limit']=20;
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('liquor_id', 'Liquor Name', 'required');
		
		
		if($this->form_validation->run() == FALSE){
			if (validation_errors ())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			
		$data["liquor_id"] = $this->input->post('liquor_id');
		
		$data['getallliquor'] = $this->liquor_model->getallliquor($bars_id);		
		$data["bars_id"] = $bars_id;
		
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_liquor';
			
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
			$this->template->write_view('center',$theme .'/layout/liquor/add_newliquor',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
			$this->liquor_model->liquor_newinsert($_POST);			
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
		 	
			 
			if($redirect_page == 'list_liquor')
			{
				redirect('liquor/'.$redirect_page.'/'.$limit.'/'.$this->input->post("bars_id").'/'.$offset.'/'.$msg);
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('liquor/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}	
			else
			{
				redirect('liquor/'.$redirect_page.'/'.$limit.'/'.$this->input->post("bars_id").'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}	

function import($msg='')
	{
		if(!check_admin_authentication()) {
		redirect('home');
		}
		$check_rights=get_rights('import_liquor');
		
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
		$this->template->write_view('center',$theme .'/layout/liquor/import',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
			
	}
	
	function import_csv()
	{
		// print_r($_FILES);
		// die;		
			$get = $this->liquor_model->importcsv();
			
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
	function download()
	{
		 $keyword=($this->input->post('key')!='')?str_replace(' ','-',$this->input->post('key')):'1V1';
         $option=($this->input->post('opt')!='')?str_replace(' ','-',$this->input->post('opt')):'1V1';
		 $typ=($this->input->post('typ')!='')?str_replace('', '-', $this->input->post('typ')):'1v1';
		 $result = $this->liquor_model->getAllLiquorResult($typ,$option,$keyword);
		 
		 //echo "<pre>";
		 
		
		 $filename ="Liquor_Record.csv";
         $this->load->dbutil();
         $delimiter = ",";
         $newline = "\r\n";
		 
         $data= $this->dbutil->csv_from_result($result, $delimiter, $newline);
		 
         //$this->load->helper('download');
        // force_download($filename, $data);
		 
		//$data = ltrim(strstr($this->dbutil->csv_from_result($result, ',', "\r\n"), "\r\n"));
		
		$this->load->helper('download');
		force_download("Liquor_Record.csv", $data);
		
		
		exit;
	}
function removeimage1($liquor_id,$image,$limit,$offset,$redirect_page,$option,$keyword)
	{
		//echo "sdfsdf";die;
		if($image!='')
		{
			if(file_exists(base_path().'upload/liquor_orig/'.$image))
			{
				$link=base_path().'upload/liquor_orig/'.$image;
				unlink($link);
			}
			
			if(file_exists(base_path().'upload/liquor_thumb/'.$image))
			{
				$link1=base_path().'upload/liquor_thumb/'.$image;
				unlink($link1);
			}			
		}
		$msg='Image Removed';
		
		$data = array('image_default'=>'');
				$this->db->where('liquor_id',$liquor_id);
				$this->db->update('liquors', $data);
		//redirect('serviceprovider/list_staff/'.$limit.'/'.$offset.'/'.$msg);
		redirect('liquor/edit_liquor/'.$liquor_id.'/'.$redirect_page.'/'.$limit);
	}
	
	function changeliquorstatus()
	{
		    $data_insert["status"] = $this->input->post('status');
			$this->db->where("liquor_comment_id",$this->input->post('cmnt_id'));
			$this->db->update('liquor_comment',$data_insert);
			
			//echo $this->db->last_query();
			echo "success";
			die;
	}
	
	function Editliquorcomment($id='',$liquor_id='')
	{
		
		//valid_pass
		$data['comment'] = $this->liquor_model->getliquorcomment($id);
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
			
			$this->liquor_model->update_comment($id);
			$data['success']='success';
			$data['msg']='Comment edited successfully.';
			$data['error']='';
			
		}
		if($_POST){
			echo json_encode($data);die;
		}
		$data["site_setting"] = site_setting();
		$theme = getThemeName();
		$data['liquor_comment_id']=$id;
		$data['liquor_id']=$liquor_id;
		
			echo $this->load->view($theme .'/layout/liquor/editcomment',$data,TRUE);
		die;
		
		
	}
}
?>