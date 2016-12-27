<?php

class Trivia extends SPACULLUS_Controller {

	/*
	 Function name :Home()
	 Description :Its Default Constuctor which called when home object initialzie.its load necesary models
	 */

	function Trivia () {
		
		parent :: __construct ();
		$this->load->model ('quiz_model');
	}

	public function index ($msg = '') {
		
		//$this->cart->destroy();
	
	  
		$data['getquenum']  = $this->quiz_model->quenum($this->session->userdata('set_quiz'));
		
	    if($data['getquenum']<20 && $this->session->userdata('set_quiz')!='')
		{
			redirect('trivia/start');
		}
		
	    $data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
		$data['msg'] = base64_decode($msg);
		
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
		$this->template->write_view ('content_center', $theme.'/quiz/quiz_home', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();

	}

    function start($msg='')
	{$this->load->helper('cookie');
		
		//$this->session->sess_destroy ();
		//die;
		if($this->session->userdata('set_quiz')=='')
		{
			$quiz = array('set_quiz' => rand('11111111','99999999'));
			$this->session->set_userdata($quiz);
			
			$insertuser = array('ip'=>$_SERVER['REMOTE_ADDR'],'sessuserid'=>$this->session->userdata('set_quiz'));
			$this->db->insert('quiz_user',$insertuser);
			
		}
		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
		$data['msg'] = base64_decode($msg);
		
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $data['getquenum']  = $this->quiz_model->quenum($this->session->userdata('set_quiz'));
		
		
		
		$data['time']  ='';
		$data["qid"] = get_cookie('qid');
		
		if($data["qid"]=='')
		{
			$data['result'] = $this->quiz_model->getquiz();
		}
		else
		{
			$data['result'] = $this->quiz_model->getquiz_byid($data["qid"]);
		} 
		//print_r($result);
        if(get_authenticateUserID() > 0)
        {
		  $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        }
        else
        {
            $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        }
		$this->template->write_view ('content_center', $theme.'/quiz/quiz', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();
		
	}


	function checkanswer()
	{
		$getanswerdet = $this->quiz_model->checkquesion($this->input->post('questid'));
		print_r(json_encode($getanswerdet));
		die;
		 
	}
	
	function storedataincoockie()
	{
		$this->load->helper('cookie');
		$cookieu = array('name' => 'qid', 'value' => $this->input->post('questid') , 'expire' => time() + 86500);
		setcookie("qid", $this->input->post('questid'), time() + 60 * 60 * 24 * 30, '/');
		$cookiep = array('name' => 'tm', 'value' => $this->input->post('moredata'), 'expire' => time() + 86500);
		setcookie("tm", $this->input->post('moredata'), time() + 60 * 60 * 24 * 30, '/');
	}
	function nextanswer()
	{
		$theme = getThemeName ();
		if($this->input->post('showans')==0)
		{
			$checkquestion =  $this->quiz_model->checkquesion($this->input->post('questid'));
			if($checkquestion['answer']==$this->input->post('user_answer'))
			{
				$right = 1;
				$wring = 0;
				$no_result = 0;
			}
			else {
				 if($this->input->post('user_answer')=='')
				 {
				 	$right = 0;
				    $wring = 0;
				    $no_result = 1;
				 }
				 else {
					$right = 0;
					$wring = 1;
				    $no_result = 0;
				 }
				
			}
		}
		else {
			   
			    $right = 0;
				$wring = 0;
				$no_result = 1;
		}
		
		
		
		$arr = array('right_answer'=>$right,
		             'wring'=>$wring,
					 'no_result'=>$no_result,
					 'time'=> $this->input->post('moredata')==0 ? '20':20-$this->input->post('moredata'),
					 'sessionuserid'=>$this->session->userdata('set_quiz'),
					 'q_id'=>$this->input->post('questid'));
				
		
		$this->db->insert('quiz_answer',$arr);
		$data['getquenum']  = $this->quiz_model->quenum($this->session->userdata('set_quiz'));
		
		//print_r($getarray);
		$data['result'] = $this->quiz_model->getquiz($this->input->post('questid'));
		if($data['getquenum']>20)
		{
			echo 'stop';
			die;
			//$this->session->unset_userdata('set_quiz');
		}
		echo $this->load->view($theme .'/quiz/quiz_ajax',$data,TRUE);die;
		
	}
	function start_new_game()
	{
			$this->session->unset_userdata('set_quiz');
			redirect('trivia');
		
	}
	function quitgame()
	{
			$this->session->unset_userdata('set_quiz');
			redirect('home');
		
	}
	function result($msg='')
	{
		
		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
		$data['msg'] = base64_decode($msg);
		
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
       // $data['getquenum']  = $this->quiz_model->quenum($this->session->userdata('set_quiz'));
        $data['getquenum']  = $this->quiz_model->quenum($this->session->userdata('set_quiz'));
		
		
	    if($data['getquenum']<21 && $this->session->userdata('set_quiz')!='')
		{
			redirect('trivia/start');
		}
		
		if($this->session->userdata('set_quiz')=='')
		{
			redirect('trivia');
		}
		$data['result'] = $this->quiz_model->getquizresult($this->session->userdata('set_quiz'));
		
		$data['count'] =  $this->quiz_model->getquizresult_time($this->session->userdata('set_quiz'));
		$this->session->unset_userdata('set_quiz');
		
	
        if(get_authenticateUserID() > 0)
        {
		  $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        }
        else
        {
            $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        }
		$this->template->write_view ('content_center', $theme.'/quiz/result', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();
		
	}
	}
?>