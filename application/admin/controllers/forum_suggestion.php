<?php
class Forum_suggestion extends  CI_Controller {
	function Forum_suggestion()
	{
		parent::__construct();	
		$this->load->model('forum_suggestion_model');	
		$this->load->library('pagination');
	  
	}
	//use:for redirecting at list forum_suggestion page
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('forum_suggestion/list_forum_suggestion');	
	}
	
	/* forum_suggestion list
	 * param  : doctor id ,limit,offset,msg
	 * 
	 */
	function list_forum_suggestion($limit='10', $offset=0,$msg='') {
		
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
		
		$check_rights=get_rights('list_forum_suggestion');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
			$this->load->library('pagination');
		
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'forum_suggestion/list_forum_suggestion/'.$limit.'/';
		$config['total_rows'] = $this->forum_suggestion_model->get_total_forum_suggestion_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->forum_suggestion_model->get_forum_suggestion_result($offset,$limit);
		
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
		$data['redirect_page']='list_forum_suggestion';
		
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/forum_suggestion/list_forum_suggestion',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	
	/* search patitent
	 * param  : doctor id ,limit,option,keyword,offset,msg
	 * 
	 */
	function search_list_forum_suggestion($limit=20,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('search_list_forum_suggestion');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_forum_suggestion';
		
		
		
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
		$config['base_url'] = base_url().'forum_suggestion/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword;
		$config['total_rows'] = $this->forum_suggestion_model->get_total_search_forum_suggestion_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->forum_suggestion_model->get_search_forum_suggestion_result($option,$keyword,$offset, $limit);
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
		$this->template->write_view('center',$theme .'/layout/forum_suggestion/list_forum_suggestion',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	/*delete forum_suggestion data
	 * param  : forum_suggestion id,doctor id ,option,keyword,limit,offset,msg
	 * 
	 */
	function delete_forum_suggestion($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
	
		
		$check_rights=get_rights('delete_forum_suggestion');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//$this->db->delete('rights_assign',array('forum_suggestion_id'=>$id));
		
			$this->db->query("delete from ".$this->db->dbprefix('forum')." where  forum_id='".$id."'");
		
		//$this->db->delete('forum_suggestion',array('forum_suggestion_id'=>$id));
		if($redirect_page == 'list_forum_suggestion')
		{
			redirect('forum_suggestion/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('forum_suggestion/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	/*delete , active , inactive multiple forum_suggestion at a time
	 * param  : forum_suggestion id,doctor id ,redirect page,search option,search keyword,limit,offset,msg
	 * 
	 */ 
	function action_forum_suggestion()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_forum_suggestion');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		
		$offset=$this->input->post('offset');
		
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
		
		$forum_suggestion_id =$this->input->post('chk');
		if($action=='delete')
		{
		
			    		
			foreach($forum_suggestion_id as $id)
			{
					$this->db->query("delete from ".$this->db->dbprefix('forum')." where  forum_id='".$id."'");
			}
			
			if($redirect_page == 'list_forum_suggestion')
			{
				redirect('forum_suggestion/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('forum_suggestion/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
			foreach($forum_suggestion_id as $id)
			
			{			
				$data = array('status'=>'active');
				$this->db->where('forum_id',$id);
				$this->db->update('forum', $data);
			}
			if($redirect_page == 'list_forum_suggestion')
			{
				redirect('forum_suggestion/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('forum_suggestion/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
			}
		}	
			
	}	
	
	function view_forum($id=0,$msg=''){
		
		if(!check_admin_authentication()) {
		redirect('home');
		}
			$check_rights=get_rights('view_forum_suggestion');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		//echo $id; die;
		$one_message = $this->forum_suggestion_model->get_topic($id);
		$data["topic_id"] = $id;
		$data["topic_name"] = $one_message['topic_name'];
		$data["forum_decription"] = $one_message['forum_decription'];
		$data["date_created"] = $one_message['date_created'];
		$data["first_name"] = $one_message['first_name'];
		$data["last_name"] = $one_message['last_name'];
	
		$data["master_id"] = $one_message['master_id'];
		$data["error"] = "";	
	
	    $data["msg"] = $msg;
		 $data_update = array("states"=>'read');
	    $this->db->where("forum_id",$id);
	    $this->db->update("forum",$data_update);
		//$data['total_comment']=$this->cocktail_model->get_total_bar_comment_count($id);
		//print_r($data['total']); die;
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/forum_suggestion/view',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();

	}
	
}
?>