<?php
class Suggest_advertise extends  CI_Controller {
	function Suggest_advertise()
	{
		 parent::__construct();	
		$this->load->model('bar_model');
		
	}
	
	function index()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		redirect('suggest_advertise/list_suggest_advertise');
		
		
	}
	
	
	function list_suggest_advertise($limit='10',$offset=0,$msg='')
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$this->load->library('pagination');
		
		$config['uri_segment']='4';
		$config['base_url'] = base_url().'suggest_advertise/list_suggest_advertise/'.$limit.'/';
		$config['total_rows'] = $this->bar_model->get_total_suggest_ad();
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->bar_model->get_suggest_ad_result($offset,$limit);
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
		$data['redirect_page']='list_suggest_advertise';
		
		
		$data['site_setting'] = site_setting();
		$this->template->write_view('header',$theme .'/layout/common/header',$data,TRUE);
  	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/bar/list_suggest_ad',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}

	/* search patitent	 * param  : doctor id ,limit,option,keyword,offset,msg	 * 	 */
	function search_list_suggest_advertise($limit=20,$option='',$keyword='',$offset=0,$msg='')
	{		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$redirect_page = 'search_list_suggest_advertise';
		
		$this->load->library('pagination');
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
		$config['base_url'] = base_url().'suggest_advertise/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/';
		$config['total_rows'] = $this->bar_model->get_total_search_suggest_ad_count($option,$keyword);
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->bar_model->get_search_suggest_ad_record_result($option,$keyword,$offset, $limit);
		
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
		$this->template->write_view('center',$theme .'/layout/bar/list_suggest_ad',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();
	}
  
    function delete_suggest_advertise($id=0,$redirect_page='',$option='',$keyword='',$limit=20,$offset=0)
	{
		
		$this->db->query("delete from ".$this->db->dbprefix('suggest_advertise')." where suggest_ad_id ='".$id."'");
		if($redirect_page == 'list_suggest_advertise')
		{
			
			redirect('suggest_advertise/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
		}
		else
		{
			redirect('suggest_advertise/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

		}
	}
	
	function action_suggest_advertise()
	{
		
		$offset=$this->input->post('offset');
		$limit = $this->input->post('limit');
		$action=$this->input->post('action');
		$redirect_page = $this->input->post('redirect_page');
		$option = $this->input->post('serach_option');
		$keyword=($this->input->post('serach_keyword')!='')?str_replace(' ','-',$this->input->post('serach_keyword')):'1V1';
		
		$suggest_advertise_id =$this->input->post('chk');
			
			
			
		if($action=='delete')
		{			    		
			foreach($suggest_advertise_id as $id)
			{
				$this->db->query("delete from ".$this->db->dbprefix('suggest_advertise')." where suggest_ad_id ='".$id."'");				
			}
			
			if($redirect_page == 'list_suggest_advertise')
			{
				redirect('suggest_advertise/'.$redirect_page.'/'.$limit.'/'.$offset.'/delete');
			}
			else
			{
				redirect('suggest_advertise/'.$redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset.'/delete');

			}
			
		}
			
	}
function view_suggest_advertise($id=0,$redirect_page='',$option='',$keyword='',$limit=0,$offset=0){
		
		
	    if($id=='')
		{
			redirect('home');
		}
		if(!check_admin_authentication()) {
		redirect('home');
		}
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		/*
		 * Future enhancement
		 * when assigning rights is used
		*/
		
		$check_rights=get_rights('reply_message');
				
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		//echo $id; die;
		$one_message = $this->bar_model->get_suggest_ad($id);
		
		
		 if($one_message=='0')
		{
			redirect('suggest_advertise/list_suggest_advertise');
		}
		$data["error"] = "";
		$data["limit"]=$limit;
		$data["offset"]=$offset;
		$data["option"]=$option;
		$data["keyword"]=$keyword;
		$data["search_option"]=$option;
		$data["search_keyword"]=$keyword;
		$data["redirect_page"]=$redirect_page;
		
		$data["suggest_bar_id"] = $id;
		$data["type"] = $one_message['type'];
		$data["description"] = $one_message['description'];
		$data["text"] = $one_message['text'];
		$data["remarks"] = $one_message['remarks'];
		$data["name"] = $one_message['name'];
		$data["number"] = $one_message['number'];
		$data["email"] = $one_message['email'];
		$data["date"] = $one_message['date'];
	
	    $data_update = array("states"=>'read');
	    $this->db->where("suggest_bar_id",$id);
	    $this->db->update("suggest_bars",$data_update);
		//end of update data//
	
		
		
		//print_r($data['total']); die;
		
		$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
		$this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
		$this->template->write_view('center',$theme .'/layout/bar/view_suggest_ad',$data,TRUE);
		$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
		$this->template->render();

	}		
}
?>