<?php
class Taxiowner extends SPACULLUS_Controller {
	/*
	 Function name :User()
	 */
	function Taxiowner() {
		ini_set("display_errors", 1);
		parent :: __construct ();
		$this->load->model('taxiowner_model');
		$this->load->model('bar_model');
	}

	public function index ($msg = '') {
		redirect('taxiowner/lists');
	}

	public function lists($limit='10',$alpha = 'no',$options= '',$offset=0,$msg='') {
		//echo "hello"; die;
		// if(!check_user_authentication())
		// { redirect('home'); }	 
		
		$data['msg'] = base64_decode($msg);
			if($alpha != "no" && $alpha != "" )
		{
		     $alpha = base64_decode($alpha);
		}
		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['site_setting'] = site_setting ();
        $data['active_menu']='taxiowner';
		
		
	
		if($_POST)
		{
			$taxi_title = $this->input->post("taxi_title");
			$state_taxi = $this->input->post("state_taxi");
			$city_taxi = $this->input->post("city_taxi");
			$zipcode_taxi = $this->input->post("zipcode_taxi");		
		    $keyword = $this->input->post("keyword"); 			
			$order = explode("#",$this->input->post("order_by"));
			
			 
				if(isset($order[0]) && isset($order[1]))
				{
					 $sort_by = $order[0];
				     $sort_type = $order[1];	
				}
				else
				{
				     $sort_by = "";
				     $sort_type = "";		
				}				
		 		$limit = $this->input->post("limit");		
		}
		else
		{		
				if($options != "")
				{
				
					$get_option = explode("@",base64_decode($options));
				    $sort_by = $get_option[0];
				    $sort_type = $get_option[1];
					$keyword = $get_option[2];	
					$taxi_title = $get_option[2];
				    $state_taxi = $get_option[3];
					$city_taxi = $get_option[4];		
					$zipcode_taxi = 	$get_option[5];							
				}
				else
			    {
					 $sort_by = "";
					 $sort_type = "";	
					 //$type = "0";
					 $keyword = '0';
					 $taxi_title = '';
				     $state_taxi = '';
					 $city_taxi = '';		
					 $zipcode_taxi = 	'';		
				}			 
		}
		
		$this->load->library('pagination');
		//echo $sort_by."@".$sort_type."@".$type."@".$keyword;
		
		//$options = base64_encode($sort_by."@".$sort_type."@".$keyword);
		if($this->input->post("taxi_title")=='' && $this->input->post("state_taxi") && $this->input->post("city_taxi") && $this->input->post("zipcode_taxi"))
		{
			$options = base64_encode($sort_by."@".$sort_type."@".$keyword);
		}
		else {
			$options = base64_encode($sort_by."@".$sort_type."@".$taxi_title."@".$state_taxi."@".$city_taxi."@".$zipcode_taxi);
		}
			
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'taxiowner/lists/'.$limit.'/'.$alpha."/".$options.'/';
		$config['total_rows'] = $this->taxiowner_model->get_total_taxi_owner_count(trim($keyword),$alpha,$taxi_title,$state_taxi,$city_taxi,$zipcode_taxi);
		
		$data["total_rows"] = $config['total_rows'];
		
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->taxiowner_model->get_taxi_owner_result($offset,$limit,$sort_by,$sort_type,trim($keyword),$alpha,$taxi_title,$state_taxi,$city_taxi,$zipcode_taxi);
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
		if($keyword == "0"){$keyword = '';}
	    $data['keyword'] = $keyword;
		$data['redirect_page']='lists';
		$data['sort_type']=$sort_type;
		$data['sort_by']=$sort_by;
		$data['page_name']="Taxiowner";
	    $data["order_by"] = $sort_by."#".$sort_type;
		$data["alpha"] = $alpha;
		
		
		if($taxi_title == "0"){$taxi_title = '';}
		if($state_taxi == "0"){$state_taxi = '';}
		if($city_taxi == "0"){$city = '';}
		if($zipcode_taxi == "0"){$zipcode = '';}
		
	    $data['taxi_title'] = $taxi_title;
		$data['state_taxi'] = $state_taxi;
		$data['city_taxi'] = $city_taxi;
		$data['zipcode_taxi'] = $zipcode_taxi;
		
		
		if($keyword!='' && $keyword!=0 && $keyword!='1V1')
		{
		$getad = getadvertisementSearch('taxilist','top',$keyword); 
		
		if($getad)
		{
	    $count = getadvertisementByIDCount(@$getad['advertisement_id'],'visit');
		if($getad['type']=='visit')
		{
			if($getad['type']=='click')
			{
				$cnt = $getad['number_click'];
			}
			else
			{
				$cnt = $getad['number_visit'];
			}
						
			$getad_new = getadvertisementByID(@$getad['advertisement_id'],'visit');
		
			if($getad_new==0 && $count<$cnt)
			{
				$array = array('ip'=>$_SERVER['REMOTE_ADDR'],'datetime'=>date('Y-m-d H:i:s'),'advertisement_id'=>$getad['advertisement_id'],'click_type'=>'visit');
				$this->db->insert('count_clcik_advertisement',$array);
			}
		}
		}
		
		
		
		$getadsec = getadvertisementSearch('taxilist','bottom',$keyword); 
		
		if($getadsec)
		{
	    $countsec = getadvertisementByIDCount(@$getadsec['advertisement_id'],'visit');
		if($getadsec['type']=='visit')
		{
			if($getadsec['type']=='click')
			{
				$cntsec = $getadsec['number_click'];
			}
			else
			{
				$cntsec = $getadsec['number_visit'];
			}
						
			$getad_newsec = getadvertisementByID(@$getadsec['advertisement_id'],'visit');
		
		   
			if($getad_newsec==0 && $countsec<$cntsec)
			{
				$array = array('ip'=>$_SERVER['REMOTE_ADDR'],'datetime'=>date('Y-m-d H:i:s'),'advertisement_id'=>$getadsec['advertisement_id'],'click_type'=>'visit');
				$this->db->insert('count_clcik_advertisement',$array);
			}
		}
		}
		}
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        
        if(get_authenticateUserID() > 0)
        {
		  $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        }
        else
        {
            $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        }
		$this->template->write_view ('content_center', $theme.'/bar/lists_taxiowner', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();

	}

	
 	function details($user_id = 0, $msg = '',$limit=4,$offset=0)
   {
   	
   
   	    if($user_id=="" || $user_id=="0")
		{
			redirect('home');
		}
        
   	  	//$bar_id = base64_decode($bar_id);
		
		//$bar_id = getBarID($bar_slug);
		$this->load->library('pagination');
		
	    $data = array();
		$data['msg'] = $msg;
		$data["user_id"] = base64_decode($user_id);
		
		$theme = getThemeName ();
		$data['theme'] = $theme;
		$this->template->set_master_template ($theme.'/template.php');
		
		//editinfoprint_r($data["bar_detail"]);
		$page_detail=meta_setting();
		// $pageTitle=$page_detail->title;
		// $metaDescription=$page_detail->meta_description;
		// $metaKeyword=$page_detail->meta_keyword;
		
		$data['user_detail'] = $this->taxiowner_model->getUserByID(base64_decode($user_id));
		$pageTitle=$data["user_detail"]['taxi_meta_title'];
		$metaDescription=$data["user_detail"]['taxi_meta_description'];
		$metaKeyword=$data["user_detail"]['taxi_meta_keyword'];
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
		
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
	
        if(get_authenticateUserID() > 0)
        {
		  $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        }
		else
			{
				$this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
			}
		$this->template->write_view ('content_center', $theme.'/bar/taxiowner_detail', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();		
    } 
    
   function auto_suggest_taxi()
	{
		$operator_list 	 = $this->taxiowner_model->auto_suggest_taxi($_REQUEST['em']);
		$arr = array();	
		if($operator_list){
		foreach($operator_list as $key=>$val){
			$arr[] = array("id"=>$val['user_id'],"label"=>$val['first_name']." ".$val['last_name'],"value"=>$val['first_name']." ".$val['last_name']); 
		}
		}
		print_r(json_encode($arr));die;
	} 
    function gettaxireportajax()
	{
		$theme = getThemeName ();
		$data = array();
		$data['taxi_detail'] = $this->taxiowner_model->getUserByID($this->input->post('id'));
		echo $this->load->view($theme .'/bar/report_taxi.php',$data,TRUE);die;
		
	}

	function add_report_taxi()
	{
		if($this->input->post('report_type')=="Other")
		{
			$desc = $this->input->post('desc');
		}
		else {
			$desc = '';
		}
		$arr = array('status'=> $this->input->post('report_type'),
		             'taxi_id'=>$this->input->post('taxi_id'),
		             'reported_by'=>$this->input->post('email'),
		             'desc'=>$desc,
					 'user_id'=> get_authenticateUserID(),
					 'date'=>date('Y-m-d H:i:s'));
		$this->db->insert('report_taxi',$arr);
		echo "success";
		die;			 
	}
   
    function gettaxiajax()
	{
		$theme = getThemeName ();
		$data = array();
		$bar_detail = $this->bar_model->get_one_bar($this->input->post('id'));
		$data['bar_detail'] = $bar_detail;
		$data['result'] = $this->taxiowner_model->gettaxibysearch($bar_detail['state'],$bar_detail['city'],$bar_detail['zipcode']);
		echo $this->load->view($theme .'/home/taxilistajax',$data,TRUE);die;
		
	}
	
	function getmoretaxi()
	{
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
    	//$data["bar_cocktail"] = $this->taxiowner_model->getBarCocktailNew($_GET['bar_id'],$_GET['offset'],$_GET['limit']);
		$data['result'] = $this->taxiowner_model->gettaxibysearch($_GET['state'],$_GET['city'],$_GET['zipcode'],$_GET['offset'],$_GET['limit']);
		
		
		if($data["result"])
		{
		echo $this->load->view($theme .'/home/taxiajaxscroll',$data,TRUE);
		}
		else {
			echo "No";
		}
		die;
	}
}
?>