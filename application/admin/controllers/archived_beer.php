<?php
class Archived_beer extends  CI_Controller {
	function Archived_beer()
	{
		parent::__construct();	
		$this->load->model('archived_beer_model');	
		$this->load->library('pagination');
		  ini_set('memory_limit', '2048M');
	  
	}
	//use:for redirecting at list beer page
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('archived_beer/list_archived_beer');	
	}
	
	/* beer list
	 * param  : doctor id ,limit,offset,msg
	 * 
	 */
	function list_archived_beer($limit='10',$bars_id=0, $offset=0,$msg='',$er='',$er1='') {
		
		
		 
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
		
		$check_rights=get_rights('list_archived_beer');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
			$this->load->library('pagination');
		
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'archived_beer/list_archived_beer/'.$limit.'/'.$bars_id. "/";
		$config['total_rows'] = $this->archived_beer_model->get_total_beer_count($bars_id);
	$data['er'] = $er;
	$data['er1'] = $er1;
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->archived_beer_model->get_beer_result($offset,$limit,$bars_id);
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
		$data['redirect_page']='list_archived_beer';
		$data["bars_id"] = $bars_id ;
		
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/archived_beer/list_beer',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	/* search patitent
	 * param  : doctor id ,limit,option,keyword,offset,msg
	 * 
	 */
	function search_list_archived_beer($limit=20,$bars_id = 0,$option='',$keyword='',$offset=0,$msg='')
	{
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('search_list_beer');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_archived_beer';
		
		
		
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

	$data['er'] = '';
	$data['er1'] = '';
		$config['uri_segment']='7';
		$config['base_url'] = base_url().'archived_beer/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$option.'/'.$keyword;
		$config['total_rows'] = $this->archived_beer_model->get_total_search_beer_count($option,$keyword,$bars_id);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->archived_beer_model->get_search_beer_result($option,$keyword,$offset, $limit,$bars_id);
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
		$this->template->write_view('center',$theme .'/layout/archived_beer/list_beer',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
	
	
	
	function delete_archived_beer($id=0,$redirect_page='',$option='',$keyword='',$bars_id = 0,$limit=20,$offset=0)
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
	
		
		$check_rights=get_rights('delete_beer');
		
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//$this->db->delete('rights_assign',array('beer_id'=>$id));
		
		if($bars_id > 0 && is_numeric($bars_id))
		{
			
			$this->db->query("delete from ".$this->db->dbprefix('beer_bars')." where bar_id ='".$bars_id."' and beer_id='".$id."'");
		}
		else {
			//$data=array('is_deleted'=>'yes');
			//$this->db->where('beer_id',$id);
			//$this->db->update('beer_directory',$data);
			$this->db->query("delete from ".$this->db->dbprefix('beer_directory')." where beer_id ='".$id."'");
			
		}
		
        
        
		
		//$this->db->delete('beer',array('beer_id'=>$id));
		if($redirect_page == 'list_archived_beer')
		{
			redirect('archived_beer/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$offset.'/delete');
		}
		else
		{
			redirect('archived_beer/'.$redirect_page.'/'.$limit.'/'.$bars_id.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	/*delete , active , inactive multiple beer at a time
	 * param  : beer id,doctor id ,redirect page,search option,search keyword,limit,offset,msg
	 * 
	 */ 
	function action_archived_beer()
	{
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		$check_rights=get_rights('action_beer');
		
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
		
		$beer_id =$this->input->post('chk');
			
		if($action=='delete')
		{
		
			    		
			foreach($beer_id as $id)
			{
				if($bar_id > 0 && is_numeric($bar_id))
				{
					$this->db->query("delete from ".$this->db->dbprefix('beer_bars')." where bar_id ='".$bar_id."' and beer_id='".$id."'");
				}
				else {
				//	$data=array('is_deleted'=>'yes');
				//$this->db->where('beer_id',$id);
				//$this->db->update('beer_directory',$data);	
				}		
				$this->db->query("delete from ".$this->db->dbprefix('beer_directory')." where beer_id ='".$id."'");
			}
			
			if($redirect_page == 'list_archived_beer')
			{
				redirect('archived_beer/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/delete');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('archived_beer/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('archived_beer/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
		if($action=='active')
		{
			foreach($beer_id as $id)
			
			{			
				$data = array('status'=>'active');
				$this->db->where('beer_id',$id);
				$this->db->update('beer_directory', $data);
			}
			if($redirect_page == 'list_archived_beer')
			{
				redirect('archived_beer/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/active');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('archived_beer/'.$redirect_page.'/'.$limit.'/'.$offset.'/active');
			}
			else
			{
				redirect('archived_beer/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bar_id.'/'.$offset.'/active');
			}
		}	
		if($action=='inactive')
		{
		
             		
			foreach($beer_id as $id)
			{			
				$data = array('status'=>'inactive');
				$this->db->where('beer_id',$id);
				$this->db->update('beer_directory', $data);
			}
			
			if($redirect_page == 'list_archived_beer')
			{
				redirect('archived_beer/'.$redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset.'/inactive');
			}
			elseif ($redirect_page == 'list_poker') {
				redirect('archived_beer/'.$redirect_page.'/'.$limit.'/'.$offset.'/inactive');
			}
			else
			{
				redirect('archived_beer/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$bar_id.'/'.$offset.'/inactive');
			}			
		}		
	}	
	
	
}
?>