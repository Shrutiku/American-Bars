<?php
class Archived_taxi extends  CI_Controller {
	function Archived_taxi()
	{
		ini_set('memory_limit', '2048M');
		parent::__construct();	
		$this->load->model('archived_taxi_model');	
	   $this->load->library('pagination');
	}
	//use:for redirecting at list taxi page
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('archived_taxi/list_archived_taxi');	
	}
	
	/* taxi list
	 * param  : doctor id ,limit,offset,msg
	 * 
	 */
	function list_archived_taxi($limit='10',$offset=0,$msg='',$er='',$er1='') {
		
		
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
		$config['base_url'] = base_url().'archived_taxi/list_archived_taxi/'.$limit.'/';
		$config['total_rows'] = $this->archived_taxi_model->get_total_taxi_count();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->archived_taxi_model->get_taxi_result($offset,$limit);
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
		$data['redirect_page']='list_archived_taxi';
		
		
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/archived_taxi/list_taxi',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	/* search patitent
	 * param  : doctor id ,limit,option,keyword,offset,msg
	 * 
	 */
	function search_list_archived_taxi($limit=20,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_archived_taxi';
		
		
		
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
		$config['base_url'] = base_url().'archived_taxi/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->archived_taxi_model->get_total_search_taxi_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->archived_taxi_model->get_search_taxi_result($option,$keyword,$offset, $limit);
		
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
		$this->template->write_view('center',$theme .'/layout/archived_taxi/list_taxi',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	/*delete taxi data
	 * 
	 * 
	 */
	function delete_archived_taxi($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$one_taxi = $this->archived_taxi_model->get_one_taxi($id);
		
		$check_rights=get_rights('list_taxi');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//$this->db->delete('rights_assign',array('taxi_id'=>$id));
	
        
        $one_taxi = $this->archived_taxi_model->get_one_taxi($id);
		
		
		
		$this->db->delete('taxi_directory',array('taxi_id'=>$id));
		if($one_taxi){
		$this->db->delete('user_master',array('user_id'=>$one_taxi['taxi_owner_id']));
		}
		if($redirect_page == 'list_archived_taxi')
		{
			
			redirect('archived_taxi/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('archived_taxi/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	/*delete , active , inactive multiple taxi at a time
	 * param  : taxi id,doctor id ,redirect page,search option,search keyword,limit,offset,msg
	 * 
	 */ 
	function action_archived_taxi()
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
				$one_taxi = $this->archived_taxi_model->get_one_taxi($id);
				$this->db->delete('taxi_directory',array('taxi_id'=>$id));
				if($one_taxi){
				$this->db->delete('user_master',array('user_id'=>$one_taxi['taxi_owner_id']));
				}
			}
			
			if($redirect_page == 'list_archived_taxi')
			{
				redirect('archived_taxi/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('archived_taxi/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

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
			if($redirect_page == 'list_archived_taxi')
			{
				redirect('archived_taxi/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('taxi/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('archived_taxi/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
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
			if($redirect_page == 'list_archived_taxi')
			{
				redirect('archived_taxi/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('archived_taxi/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('archived_taxi/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/active');
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
			
			if($redirect_page == 'list_archived_taxi')
			{
				redirect('archived_taxi/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('archived_taxi/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/inactive');

			}
			
			
		}	
		
		
		
		
	}
	
}
?>