<?php
class Store extends  CI_Controller {
	function Store()
	{
		parent::__construct();	
		$this->load->model('store_model');	
		$this->load->library('pagination');
	  
	}
	//use:for redirecting at list store page
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('store/list_store');	
	}
	
	/* store list
	 * param  : doctor id ,limit,offset,msg
	 * 
	 */
	function list_store($limit='10',$offset=0,$msg='') {
		
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
		
		$check_rights=get_rights('list_store');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
			$this->load->library('pagination');
		
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'store/list_store/'.$limit.'/';
		$config['total_rows'] = $this->store_model->get_total_store_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->store_model->get_store_result($offset,$limit);
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
		$data['redirect_page']='list_store';
		
		
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/store/list_store',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/* search patitent	 * param  : doctor id ,limit,option,keyword,offset,msg	 * 	 */
	function search_list_store($limit=20,$option='',$keyword='',$offset=0,$msg='')
	{		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('search_list_store');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_store';
		
		
		
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
		$config['base_url'] = base_url().'store/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->store_model->get_total_search_store_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->store_model->get_search_store_result($option,$keyword,$offset, $limit);
		
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
		$this->template->write_view('center',$theme .'/layout/store/list_store',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/*check unique store email
	 * param  : email
	 * return : BOOLEAN
	 */
	function storename_check($name)
	{
		$storename = $this->store_model->store_unique($name);
		if($storename == FALSE)
		{
			$this->form_validation->set_message('storename_check', 'There is an existing record with this News Name');
			return FALSE;
		}
		return TRUE;
	}
	
	/*add new store also called in store update
	 * param  : limit
	 * 
	 */
	function add_store($limit=0)
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
		
		$check_rights=get_rights('add_store');
		
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

		$data['imageGallery']= '';

		$this->load->library('form_validation');
		$this->form_validation->set_rules('product_name', 'Product Name', 'required');
		$this->form_validation->set_rules('quantity', 'Quantity', 'required');
		$this->form_validation->set_rules('color', 'Color', 'required');			
		$this->form_validation->set_rules('status', 'Status', 'required');	
		$this->form_validation->set_rules('size', 'Size', 'required');	
		$this->form_validation->set_rules('description', 'Description', 'required');	
		$this->form_validation->set_rules('price', 'Price', 'required');			
		$data['colorlist']=getColor();
		$data['sizelist']=getSize();
		$video_error = '';
			
		if($this->form_validation->run() == FALSE || $video_error != ""){	
			if(validation_errors() || $video_error != "")
			{
				$data["error"] = validation_errors();
					$data["error"] .= $video_error;
			}else{
				$data["error"] = "";
			}
			
			
			$data["store_id"] = $this->input->post('store_id');		
			$data["product_name"] = $this->input->post('product_name');
			$data["quantity"] = $this->input->post('quantity');
			$data["color"] =$this->input->post('color');
			$data["size"] =$this->input->post('size');
			$data["back_col"] =$this->input->post('back_col');
			$data["description"] =$this->input->post('description');
			$data["price"] =$this->input->post('price');
			$data["status"] = $this->input->post('status');
			$data['image']=$this->input->post('pre_profile_image');
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_store';
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
			$this->template->write_view('center',$theme .'/layout/store/add_store',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}
		else
		{				
			if($this->input->post('store_id')!='')
			{	
				$this->store_model->store_update();
				$msg = "update";
			}else{
				$this->store_model->store_insert();			
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
		 	
			 
			if($redirect_page == 'list_store')
			{
				redirect('store/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}
			elseif ($redirect_page == 'list_store') {
				redirect('store/'.$redirect_page.'/'.$limit.'/'.$offset.'/'.$msg);
			}	
			else
			{
				redirect('store/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/'.$msg);
			}
		}				
	}
	
	/*store update form fill
	 * param  : store id,doctor id ,redirect page,option,keyword,limit,offset
	 * 
	 */
	function edit_store($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0)
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
		
		$check_rights=get_rights('edit_store');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_store = $this->store_model->get_one_store($id);
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		
		$data["store_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		
		$data["store_id"] = $one_store['store_id'];
		$data["product_name"] = $one_store['product_name'];
		$data["quantity"] = $one_store['quantity'];
		$data["color"] = $one_store['color'];
		$data["status"] = $one_store['status'];
		$data["size"] = $one_store['size'];
		$data["back_col"] =$one_store['back_col'];
		$data["price"] = $one_store['price'];
		$data["image"] = $one_store['product_image'];
		$data["description"] = $one_store['description'];
		$data['colorlist']=getColor();
		$data['sizelist']=getSize();
		$data['imageGallery']=$this->store_model->getImageGallery($id);
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/store/add_store',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	function removeimage($store_id,$image,$limit,$offset,$redirect_page,$option,$keyword)
	{
		//echo "sdfsdf";die;
		if($image!='')
		{
			if(file_exists(base_path().'upload/product_orig/'.$image))
			{
				$link=base_path().'upload/product_orig/'.$image;
				unlink($link);
			}
			
			if(file_exists(base_path().'upload/product_thumb/'.$image))
			{
				$link1=base_path().'upload/product_thumb/'.$image;
				unlink($link1);
			}			
		}
		$msg='Image Removed';
		//redirect('serviceprovider/list_staff/'.$limit.'/'.$offset.'/'.$msg);
		redirect('store/edit_store/'.$store_id.'/'.$redirect_page.'/'.$limit);
	}
	
	
	/*delete store data
	 * param  : store id,doctor id ,option,keyword,limit,offset,msg
	 * 
	 */
	function delete_store($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_store');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
	//	$this->db->query("delete from ".$this->db->dbprefix('store')." where store_id ='".$id."'");
				$data = array('is_delete'=>'1');
				$this->db->where('store_id',$id);
				$this->db->update('store', $data);
	
		//$this->db->delete('store',array('store_id'=>$id));
		if($redirect_page == 'list_store')
		{
			
			redirect('store/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('store/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	/*delete , active , inactive multiple store at a time
	 * param  : store id,doctor id ,redirect page,search option,search keyword,limit,offset,msg
	 * 
	 */ 
	function action_store()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_store');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');

		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
		
		$store_id =$this->input->post('chk');
			
		if($action=='delete')
		{			    		
			foreach($store_id as $id)
			{
				//$this->db->where('store_id',$id);
				//$this->db->delete('store',$data);			
				//$this->db->query("delete from ".$this->db->dbprefix('store')." where store_id ='".$id."'");				
				
				$data = array('is_delete'=>'1');
				$this->db->where('store_id',$id);
				$this->db->update('store', $data);
			}
			
			if($redirect_page == 'list_store')
			{
				redirect('store/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('store/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
			foreach($store_id as $id)
			
			{			
				$data = array('status'=>'active');
				$this->db->where('store_id',$id);
				$this->db->update('store', $data);
			}
			if($redirect_page == 'list_store')
			{
				redirect('store/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('store/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive')
		{             		
			foreach($store_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('store_id',$id);
				$this->db->update('store', $data);
			}			
			if($redirect_page == 'list_store')
			{
				redirect('store/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('store/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');

			}			
		}
		
		if($action=='pending')
		{
			foreach($store_id as $id)			
			{			
				$data = array('status'=>'pending');
				$this->db->where('store_id',$id);
				$this->db->update('store', $data);
			}
			if($redirect_page == 'list_store')
			{
				redirect('store/'.$redirect_page.'/'.$limit.'/'.$offset.'/pending');
			}
			else
			{
				redirect('store/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/pending');
			}
		}
		if($action=='deliver')
		{
			foreach($store_id as $id)			
			{			
				$data = array('status'=>'deliver');
				$this->db->where('store_id',$id);
				$this->db->update('store', $data);
			}
			if($redirect_page == 'list_store')
			{
				redirect('store/'.$redirect_page.'/'.$limit.'/'.$offset.'/deliver');
			}
			else
			{
				redirect('store/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/deliver');
			}
		}				
	}	
}
?>