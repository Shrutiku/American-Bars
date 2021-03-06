<?php
class Gallery extends  CI_Controller {
	function Gallery()
	{
		parent::__construct();	
		$this->load->model('gallery_model');	
	   $this->load->library('pagination');
	}
	//use:for redirecting at list gallery page
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('gallery/list_gallery');	
	}
	
	/* gallery list
	 * param  : doctor id ,limit,offset,msg
	 * 
	 */
	function list_gallery($limit=10,$bar_id =0 ,$offset=0,$msg='') {
		
		
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
		
		$check_rights=get_rights('list_gallery');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//	$this->load->library('pagination');
		
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'gallery/list_gallery/'.$limit.'/'.$bar_id. "/";
		$config['total_rows'] = $this->gallery_model->get_total_gallery_count($bar_id);
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->gallery_model->get_gallery_result($offset,$limit,$bar_id);
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
		$data['redirect_page']='list_gallery';
		
		$data["bar_id"] = $bar_id ;
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/gallery/list_gallery',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	/* search patitent
	 * param  : doctor id ,limit,option,keyword,offset,msg
	 * 
	 */
	function search_list_gallery($limit=20,$option='',$keyword='',$bar_id = 0,$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('search_list_gallery');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_gallery';
		
		
		
		if($_POST)
		{		
			$option=$this->input->post('option');
			$keyword=($this->input->post('keyword')!='')?str_replace(" ", "-",trim($this->input->post('keyword'))):'1V1';
			$bar_id=$this->input->post('bar_id');
			
		}
		else
		{
			$option=$option;
			$keyword=str_replace(" ", "-",trim($keyword));	
		    $bar_id = $bar_id;
		}
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',trim($keyword)));

	
		$config['uri_segment']='7';
		$config['base_url'] = base_url().'gallery/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bar_id;
		$config['total_rows'] = $this->gallery_model->get_total_search_gallery_count($option,$keyword,$bar_id);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->gallery_model->get_search_gallery_result($option,$keyword,$offset, $limit,$bar_id);
		
		$data['msg'] = $msg;
		$data['offset'] = $offset;
		$data['site_setting'] = site_setting();
		
		$data['limit']=$limit;
		$data['option']=$option;
		$data['keyword']=$keyword;
		$data['search_type']='search';
		$data['redirect_page']=$redirect_page;
		$data["bar_id"] = $bar_id;
		
		
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/gallery/list_gallery',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/*add new gallery also called in gallery update
	 * param  : limit
	 * 
	 */
	function add_gallery($bar_id = 0,$limit=20)
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
		
		$check_rights=get_rights('add_gallery');
		
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
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
		
		$video_error = '';
		$data['imageGallery'] = '';
		
		
		if($this->form_validation->run() == FALSE || $video_error != ""){
			if (validation_errors () || $video_error != "")
			{
				$data["error"] = validation_errors();
				$data["error"] .= $video_error;
			}else{
				$data["error"] = "";
			}
			
		$data["bar_gallery_id"] = $this->input->post('bar_gallery_id');		
		$data["title"] = $this->input->post('title');
		$data["description"] = $this->input->post('description');		
		$data["image_link"] = $this->input->post('image_link');		
		$data["status"] = $this->input->post('status');
		$data["prev_photo_image"] = $this->input->post('prev_photo_image');

		$data["bar_id"] = $bar_id;
		
		// $data['states']=get_all_state_by_country_id($this->input->post('country_id'));
		// $data['cities']=get_all_city_by_state_id($this->input->post('state'));
			
			$data["search_option"]='';
			$data["search_keyword"]='';
			$data["option"]='1V1';
			$data["keyword"]='1V1';
			$data["redirect_page"]='list_gallery';
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
			$this->template->write_view('center',$theme .'/layout/gallery/add_gallery',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				
			if($this->input->post('bar_gallery_id')!='' && $this->input->post('bar_gallery_id')!=0)
			{	
		
				$this->gallery_model->gallery_update($_POST);
				$msg = "update";
			}else{
				$this->gallery_model->gallery_insert($_POST);			
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
		 	
			
			if($redirect_page == 'list_gallery')
			{
				redirect('gallery/'.$redirect_page.'/'.$limit.'/'.$this->input->post("bar_id").'/'.$offset.'/'.$msg);
			}
			
			else
			{
				redirect('gallery/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$this->input->post("bar_id").'/'.$offset.'/'.$msg);
			}
		}				
	}

	function removeImageAjax($id=0)
	{
		$oneImage=$this->gallery_model->getOneImageGallery_nwe($id);
		
		if($oneImage!='')
		{
			
			if($oneImage->bar_image_name!=''){
				
			if(file_exists(base_path().'upload/bar_gallery_orig/'.$oneImage->bar_image_name))
			{
				unlink(base_path().'upload/bar_gallery_orig/'.$oneImage->bar_image_name);
			}
			if(file_exists(base_path().'upload/bar_gallery_thumb/'.$oneImage->bar_image_name))
			{
				unlink(base_path().'upload/bar_gallery_thumb/'.$oneImage->bar_image_name);
			}
			if(file_exists(base_path().'upload/bar_gallery_thumb_big/'.$oneImage->bar_image_name))
			{
				unlink(base_path().'upload/bar_gallery_thumb_big/'.$oneImage->bar_image_name);
			}
			
			}
			$this->db->where('bar_image_id',$oneImage->bar_image_id)->delete('bar_images');
		}
		
	}	
	
	
	/*gallery update form fill
	 * param  : gallery id,doctor id ,redirect page,option,keyword,limit,offset
	 * 
	 */
	 
	 
	function edit_gallery($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0,$bar_id = 0)
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
		
		$check_rights=get_rights('edit_gallery');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$one_gallery = $this->gallery_model->get_one_gallery($id);
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		
		$data['imageGallery']=$this->gallery_model->getImageGallery($id);
		$data["bar_gallery_id"] = $id;
		$data["redirect_page"]=$redirect_page;
		$data["bar_id"]=$bar_id;
		
        $data["title"] = $one_gallery['title'];
		$data["description"] = $one_gallery['description'];
		//$data["image_link"] = $one_gallery['image_link']; 
		$data["status"] = $one_gallery['status'];
		//$data["prev_photo_image"] = $one_gallery['photo_image'];
		
		
		
		$data['site_setting'] = site_setting();
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/gallery/add_gallery',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	/*delete gallery data
	 * 
	 * 
	 */
	function delete_gallery($id=0,$redirect_page='',$option='',$keyword='',$bar_id = 0,$limit=20,$offset=0)
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('delete_gallery');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//$this->db->delete('rights_assign',array('gallery_id'=>$id));
		$this->db->query("delete from ".$this->db->dbprefix('bar_gallery')." where bar_gallery_id ='".$id."'");
		
		$oneImage=$this->gallery_model->getOneImageGallery($id);
		//print_r($oneImage);die;
				if($oneImage!='')
				{
					if($oneImage->bar_image_name!=''){
					if(file_exists(base_path().'upload/bar_gallery_orig/'.$oneImage->bar_image_name))
					{
						unlink(base_path().'upload/bar_gallery_orig/'.$oneImage->bar_image_name);
					}
					if(file_exists(base_path().'upload/bar_gallery_thumb/'.$oneImage->bar_image_name))
					{
						unlink(base_path().'upload/bar_gallery_thumb/'.$oneImage->bar_image_name);
					}
					if(file_exists(base_path().'upload/bar_gallery_thumb_big/'.$oneImage->bar_image_name))
					{
						unlink(base_path().'upload/bar_gallery_thumb_big/'.$oneImage->bar_image_name);
					}
					
					}
					$this->db->where('bar_image_id',$oneImage->bar_image_id)->delete('bar_images');
				}
	
		//$this->db->delete('gallery',array('gallery_id'=>$id));
		if($redirect_page == 'list_gallery')
		{
			
			redirect('gallery/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/delete');
		}
		else
		{
		redirect('gallery/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	/*delete , active , inactive multiple gallery at a time
	 * param  : gallery id,doctor id ,redirect page,search option,search keyword,limit,offset,msg
	 * 
	 */ 
	function action_gallery()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_gallery');
		
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
		
		$bar_gallery_id =$this->input->post('chk');
			
		if($action=='delete')
		{
		
			foreach($bar_gallery_id as $id)
			{
				$this->db->query("delete from ".$this->db->dbprefix('bar_gallery')." where bar_gallery_id ='".$id."'");
				$oneImage=$this->gallery_model->getOneImageGallery($id);
		
				if($oneImage!='')
				{
					
					if($oneImage->bar_image_name!=''){
						
					if(file_exists(base_path().'upload/bar_gallery_orig/'.$oneImage->bar_image_name))
					{
						unlink(base_path().'upload/bar_gallery_orig/'.$oneImage->bar_image_name);
					}
					if(file_exists(base_path().'upload/bar_gallery_thumb/'.$oneImage->bar_image_name))
					{
						unlink(base_path().'upload/bar_gallery_thumb/'.$oneImage->bar_image_name);
					}
					if(file_exists(base_path().'upload/bar_gallery_thumb_big/'.$oneImage->bar_image_name))
					{
						unlink(base_path().'upload/bar_gallery_thumb_big/'.$oneImage->bar_image_name);
					}
					
					}
					$this->db->where('bar_image_id',$oneImage->bar_image_id)->delete('bar_images');
				}
				//$this->db->query("delete from ".$this->db->dbprefix('gallery')." where gallery_id ='".$id."'");
			}
			
			if($redirect_page == 'list_gallery')
			{
				redirect('gallery/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/delete');
			}
			
			else
			{
				redirect('gallery/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bar_id.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
			foreach($bar_gallery_id as $id)
			
			{			
				$data = array('status'=>'Active');
				$this->db->where('bar_gallery_id',$id);
				$this->db->update('bar_gallery', $data);
			}
			
			
			if($redirect_page == 'list_gallery')
			{
				redirect('gallery/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/active');
			}
			
			else
			{
				redirect('gallery/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bar_id.'/'.$offset.'/active');

			}
		}	
		if($action=='inactive')
		{
		
             		
			foreach($bar_gallery_id as $id)
			{			
				$data = array('status'=>'Inactive');
				$this->db->where('bar_gallery_id',$id);
				$this->db->update('bar_gallery', $data);
				
			}
			
			
			if($redirect_page == 'list_gallery')
			{
				redirect('gallery/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/inactive');
			}
			
			else
			{
				redirect('gallery/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bar_id.'/'.$offset.'/inactive');

			}
			
			
		}	
		
		
		
		
	}
	
	

	function removeimage($gallery_id,$image,$limit,$offset,$redirect_page,$option,$keyword)
	{
		//echo "sdfsdf";die;
		if($image!='')
		{
			if(file_exists(base_path().'upload/photo_gallery_orig/'.$image))
			{
				$link=base_path().'upload/photo_gallery_orig/'.$image;
				unlink($link);
			}
			
			if(file_exists(base_path().'upload/photo_gallery/'.$image))
			{
				$link1=base_path().'upload/photo_gallery/'.$image;
				unlink($link1);
			}			
		}
		$msg='Image Removed';
		//redirect('serviceprovider/list_staff/'.$limit.'/'.$offset.'/'.$msg);
		redirect('gallery/edit_gallery/'.$gallery_id.'/'.$redirect_page.'/'.$limit);
	}
	
	function reorder()
	{
			$updateRecordsArray 	= $_POST['id'];
			$listingCounter = 1;
			foreach ($updateRecordsArray as $recordIDValue) {
				$query = "UPDATE ".$this->db->dbprefix('bar_gallery')." SET reorder = " . $listingCounter . " WHERE bar_gallery_id = " . $recordIDValue;
				$this->db->query($query);
				//echo $this->db->last_query();
				$listingCounter = $listingCounter + 1;	
			}
	}
}
?>