<?php
class Bar extends SPACULLUS_Controller {
	/*
	 Function name :User()
	 */
	function Bar() {
		 ini_set('memory_limit', '2048M');
		ini_set("display_errors", 1);
		parent :: __construct ();
	    $this->load->model('bar_model');
		$this->load->model('beer_model');
		$this->load->model('home_model');
	}

	public function index ($msg = '') {
		redirect('bar/lists');
	}

	public function lists($limit='20',$options= '',$bar_title_new='1V1',$bar_title_j='1V1',$address_j='1V1',$days='1V1',$offset=0,$msg='') {
		// die;
		//echo "hello"; die;
		// if(!check_user_authentication())
		// { redirect('home'); }	 
		
		
		if($this->session->userdata('detail')==1)
		{
			$this->session->set_userdata('detail',0);
			redirect('bar/lists');
		}
		
		
		$data['msg'] = base64_decode($msg);
		
		
		
		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$data['theme'] = $theme;
		$this->template->set_master_template ($theme.'/template.php');
		
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['site_setting'] = site_setting ();
        $data['active_menu']='bar';
		
		  
		$this->load->helper('recaptchalib');
		$publickey = '6LcjQAoTAAAAAMeqHoabD3bRBJuuQciyIbnaZFkU';
		$privatekey = '6LcjQAoTAAAAAM1AR1k-_AtX0DVZ5r0II1GgUzPL';
		# the response from reCAPTCHA
		$resp = null;
		# the error code from reCAPTCHA, if any
		$error = null;
		$captcha_error='';
		
			
        		
		if($_POST)
		{
			//echo $this->input->post("bar_title_new") ;
			//die;
			
		    $bar_title = $this->input->post("bar_title")=='' ? "1V1":trim($this->input->post("bar_title"));
			
			$bar_title_j =  $this->input->post("bar_title_j")=='' ? "1V1":trim($this->input->post("bar_title_j"));
			$address_j = $this->input->post("address_j")=='' ? "1V1":trim($this->input->post("address_j")); 
			 
			$days =  $this->input->post("days")=='' ? "1V1":trim($this->input->post("days"));
			
			
			if($this->input->post("bar_title_new")!='')
			{
			$bar_title_new = $this->input->post("bar_title_new")=='' ? "1V1":base64_encode($this->input->post("bar_title_new"));
			}
			
			if(base64_decode($this->input->post("bar_title_new"))=='1V1')
			{
				
				$bar_title_new = '1V1';
			}
			
			
			//if($this->input->post('bar_title_new'))
				
			$state = trim($this->input->post("state"));
			$city = trim($this->input->post("city"));
			$zipcode = trim($this->input->post("zipcode"));
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
				if($limit==0)
				{
					$limit = 20;
				}	
		}
		else
		{
			//echo 	base64_decode($bar_title_new);	
			//echo base64_decode($bar_title_new);
			//echo $bar_title_new;
				if($options != "")
				{
					
					$get_option = explode("s@s",base64_decode($options));
					
					
					$sort_by =$get_option[0];
					$sort_type = $get_option[1];
				    $bar_title = $get_option[2];
					
				    $state = $get_option[3];
					$city = $get_option[4];		
					$zipcode = 	$get_option[5];		
					//$bar_title_new ="1V1";		
				}
				else
			    {
					 $sort_by = "";
					 $sort_type = "";	
					 //$type = "0";
					 $bar_title = '1V1';
					 $state = '1V1';
					 $city = '1V1';
					 $zipcode = '1V1';
					 $bar_title_new ='1V1';
				}			 
		}
		
		$data['search_by'] = $this->input->post('search_by');
		if($data['search_by']=='bname')
		{
			  $bar_title = $this->input->post("bar_title"); 	
			 // $zipcode ='';
		}
			if($data['search_by']=='bzip')
		{
			  $zipcode = $this->input->post("bar_title"); 	
			  $bar_title ='';
		}
		
		$this->load->library('pagination');
		//echo $sort_by."@".$sort_type."@".$type."@".$keyword;
			$options = base64_encode($sort_by."s@s".$sort_type."s@s".$bar_title."s@s".$state."s@s".$city."s@s".$zipcode);
		

		$config['uri_segment']='9';
		//echo $this->input->post('bar_title_new'); 
		
		
		if($bar_title_new!='1V1' && $bar_title_new!='')
		{
		$config['base_url'] = base_url().'bar/lists/'.$limit."/".$options."/".$bar_title_new.'/'.$bar_title_j.'/'.$address_j.'/'.$days.'/';
		}
		else
		{
			$config['base_url'] = base_url().'bar/lists/'.$limit."/".$options."/1V1/".$bar_title_j.'/'.$address_j.'/'.$days.'/';
		}
		//echo $config['base_url'];
		//echo $state;
		//echo $bar_title;
		if($bar_title_new!='1V1' && $bar_title_new!='')
		{
			$config['total_rows'] = $this->bar_model->get_total_bar_count($bar_title,$state,$city,$zipcode,base64_decode($bar_title_new),$bar_title_j,$address_j,$days);
		}
		else
		{
			$config['total_rows'] = $this->bar_model->get_total_bar_count($bar_title,$state,$city,$zipcode,'1V1',$bar_title_j,$address_j,$days);
		}	
		
		
		
		$data["total_rows"] = $config['total_rows'];
		//echo $data["total_rows"];
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
	 
		
		if($bar_title_new!='1V1' && $bar_title_new!='')
		{
			$data['result'] = $this->bar_model->get_bar_result($offset,$limit,$sort_by,$sort_type,$bar_title,$state,$city,$zipcode,base64_decode($bar_title_new),$bar_title_j,$address_j,$days);
		}
		else
		{
			$data['result'] = $this->bar_model->get_bar_result($offset,$limit,$sort_by,$sort_type,$bar_title,$state,$city,$zipcode,'1V1',$bar_title_j,$address_j,$days);
		}	
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
	  	//$data['type']=$type;
		if($bar_title == "0" || $bar_title == "1V1"){$bar_title = '';}
		if(is_numeric($bar_title_new)){$bar_title_new = '';}
		if($state == "0" || $state == "1V1"){$state = '';}
		if($city == "0" || $city == "1V1"){$city = '';}
		if($zipcode == "0" || $zipcode == "1V1"){$zipcode = '';}
		
	    $data['bar_title'] = $bar_title;
		$data['state'] = $state;
		$data['city'] = $city;
		$data['zipcode'] = $zipcode;
		if($bar_title_new == "1V1"){$bar_title_new = '';}
		if($bar_title_j == "1V1"){$bar_title_j = '';}
		if($address_j == "1V1"){$address_j= '';}
		if($days == "1V1"){$days = '';}
		$data['bar_title_new'] = $bar_title_new;
		$data['bar_title_j'] = $bar_title_j;
		$data['address_j'] = $address_j;
		$data['days'] = $days;
		
		if(base64_decode($bar_title_new)=='1V1')
		{
			$data['bar_title_new'] = '1V1';
		}
		$data['redirect_page']='lists';
		$data['sort_type']=$sort_type;
		$data['sort_by']=$sort_by;
		$data['page_name']="Bar";
	    $data["order_by"] = $sort_by."#".$sort_type;
		//$data["alpha"] = $alpha;
		//echo $data['sort_type'];
		
		
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
		$this->template->write_view ('content_center', $theme.'/bar/lists', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();

	}

	
	function auto_suggest_bar()
	{
		$arr = array();	
		if($_REQUEST['em'])
		{
			$operator_list 	 = $this->bar_model->auto_suggest_bar($_REQUEST['em']);
			
			if($operator_list){
			foreach($operator_list as $key=>$val){
				$arr[] = array("id"=>$val['bar_id'],"label"=>$val['bar_title'],"value"=>$val['bar_title']); 
			}
			}
			
		}
		print_r(json_encode($arr));die;
	}
	
	function auto_suggest_bar_lab()
	{
		$operator_list 	 = $this->bar_model->auto_suggest_bar($_REQUEST['em']);
		$arr = array();	
		if($operator_list){
		foreach($operator_list as $key=>$val){
			$arr[] = array("id"=>$val['bar_id'],"label"=>$val['bar_title'],"value"=>$val['bar_title']); 
		}
		}
		print_r(json_encode($arr));die;
	}
  
    
    function checkExistPost()
	{
		$get_post_card = getTodayPostCard($this->input->post('id'));
		if($get_post_card!=0)
		{
			$timestamp1 = strtotime($get_post_card['date_added']);
			$timestamp2 = strtotime(date('Y-m-d h:i:s'));
			$data['time'] = 24 - abs($timestamp2 - $timestamp1)/(60*60);
			$data['time'] = number_format($data['time'],2);
			$response = array("time"=>$data["time"],"status"=>"success");
		}
		else {
			$data['time'] = '';
			$response = array("time"=>$data["time"],"status"=>"fail");
		}

		echo json_encode($response);
		die;	
		
		
	}
	function add_rating()
	{
  		$data = $_POST;
	  	$data["date_added"] = date("Y-m-d H:i:s");
	  	$this->db->insert("bar_comment",$data);
	 	$id = mysql_insert_id();	 
	 	echo get_bar_rating($_POST["bar_id"]);
	// echo $id;
  	}
	
	function map()
	{
		$theme = getThemeName ();
		echo $this->load->view($theme.'/home/map');
	}
	
	
  	function update_totalviews()
	{
	    $view = $_REQUEST["view"];
		$qry = $this->db->query("update ".$this->db->dbprefix("video")." set total_views = total_views + 1 where video_id = '".$view."' ");	
	}
	
	function add_comment(){
		//$data_insert = $_POST;		
		$this->bar_model->insert_comment($_POST);		
		/*echo "Your comment added successfully";*/
		$latest_comment = latest_comment($_POST['bar_id']);
		$latest_comment->cust_date = date('d M',strtotime($latest_comment->date_added));
	    $latest_comment->date_duration = getDuration($latest_comment->date_added); 
		$latest_comment->testdd='config={"playlist":[{"url":"'.base_url().'upload/comment_video/'.$latest_comment->comment_video.'","autoPlay":false}]}';		
		$res =  json_encode($latest_comment);
		echo $res;
	}
	function add_subcomment(){	
		$this->bar_model->insert_subcomment($_POST);
		$latest_comment = latest_comment($_POST['bar_id']);
		$latest_comment->cust_date = date('d M',strtotime($latest_comment->date_added));
	    $latest_comment->date_duration = getDuration($latest_comment->date_added); 
		$latest_comment->testdd='config={"playlist":[{"url":"'.base_url().'upload/comment_video/'.$latest_comment->comment_video.'","autoPlay":false}]}';		
		$res2 =  json_encode($latest_comment);
		echo $res2;
	}
	function bar_comment_likes(){
		$data = $_POST;
		$data["date_added"] = date("Y-m-d H:i:s");
		if($_POST['like_flag']==2){
			$data['like_flag']=1;
			$this->db->insert("all_likes",$data);
			$total_single = $this->bar_model->single_comment_total_likes($_POST['bar_id'],$_POST['bar_comment_id']);
			$find_flag = $this->bar_model->flag_return($_POST['bar_id'],$_POST['user_id'],$_POST['bar_comment_id']);
			if($find_flag==0){
				$find_flags=1;
			}
			if($find_flag==1){
				$find_flags=0;
			}
			echo $find_flags.'*'.$total_single;
			//echo $cnt_like = like_checker($_POST['bar_id'],$_POST['user_id']);			
			//$data['user_id'] = one_bar_likers($_POST['user_id'],$_POST['like_flag']);
		}
		else{
			$data_update = array("like_flag"=>$_POST['like_flag']);
			$this->db->where("bar_id",$_POST['bar_id']);
			$this->db->where("user_id",$_POST['user_id']);
			$this->db->where("bar_comment_id",$_POST['bar_comment_id']);
			$this->db->update("all_likes",$data_update);
		
			$total_single = $this->bar_model->single_comment_total_likes($_POST['bar_id'],$_POST['bar_comment_id']);
			$find_flag = $this->bar_model->flag_return($_POST['bar_id'],$_POST['user_id'],$_POST['bar_comment_id']);
			if($find_flag==0){
				$find_flags=1;
			}
			if($find_flag==1){
				$find_flags=0;
			}
			echo $find_flags.'*'.$total_single;
		}
		//$this->db->insert("all_likes",$data);
		//echo $cnt_like = like_checker($_POST['bar_id'],$_POST['user_id']);			
	}
	function remove_subcomment(){
		$bar_comment_id = $_POST['bar_comment_id'];
		$this->bar_model->sub_comment_remove($bar_comment_id);
		echo $bar_comment_id;
	}

    function post_card_send($id)
	{
	//	print_r($_FILES);
		//echo $temporary = explode(".", $_FILES["file"]["name"]);
	//	print_r($_POST);
	//	die;
	
	    $erro_str = '';
		if($_POST["desc_post_card"] == '')
		{
			  $erro_str .=  "<p>Comment description is required</p>";
		}
		
		if($erro_str !="")
		{
			$response = array("comment_error"=>$erro_str,"status"=>"fail");
			echo json_encode($response);
		    die;
		}
	    $bar_id = base64_decode($id);
		$site_data = site_setting();
		//echo get_authenticateUserID();
		
		$userinfo = get_user_info(get_authenticateUserID());		  
		$bar_detail = $this->bar_model->get_one_bar($bar_id);
		//print_r($userinfo);
		//echo $userinfo['first_name'];
		
		$bar_type = $bar_detail['bar_type'];
		$postcard_image = '';
		if(isset($_FILES['file']['name']) && $_FILES['file']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
             $_FILES['userfile']['name']     =   $_FILES['file']['name'];
             $_FILES['userfile']['type']     =   $_FILES['file']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['file']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['file']['error'];
             $_FILES['userfile']['size']     =   $_FILES['file']['size'];
   
			$config['file_name'] = $rand.'banner';
			
            $config['upload_path'] = base_path().'upload/postcard_orig/';
			
            $config['allowed_types'] = 'jpg|jpeg|png|';  
 
             $this->upload->initialize($config);

              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   
              $this->image_lib->clear();
			
					$gd_var='gd';
				
				
		   if ($_FILES["file"]["type"]!= "image/png" and $_FILES["file"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["file"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["file"]["type"] != "image/jpeg" and $_FILES["file"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		   $this->image_lib->clear();
			
			resize(base_path().'upload/postcard_orig/'.$picture['file_name'],base_path().'upload/postcard_thumb/'.$picture['file_name'],394,290);
			
			
			$this->image_lib->clear();
		   
		   
		   resize(base_path().'upload/postcard_orig/'.$picture['file_name'],base_path().'upload/postcard_thumb_70by70/'.$picture['file_name'],70,70);
             
           
			
			$postcard_image=$picture['file_name'];

			
			} 
            
            $data = array('image'=>$postcard_image,
			              'post_title'=>$this->input->post('sel_title'),
						  'post_message'=>$this->input->post('desc_post_card'),
						  'user_id'=>get_authenticateUserID(),
						  'bar_id'=>$bar_id,
						  'card_type'=>$bar_type,
						  'status'=>'active',
						  'date_added'=>date('Y-m-d h:i:s')); 
			
			$this->db->insert('bar_post_card',$data);
			$pid = mysql_insert_id();
			$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Postcard'");
            
            $email_temp=$email_template->row();             
                
                    
            $email_address_from=$email_temp->from_address;
            $email_address_reply=$email_temp->reply_address;
                    
            $email_subject=$email_temp->subject;                
            $email_message=$email_temp->message;
              
			if($bar_detail['email']!="")
			{
				$email = $bar_detail['email'];
				$user = $bar_detail['first_name']." ".$bar_detail['last_name'];
			}        
			else {
				$email = $site_data->site_email;
				$user = "ADB";
			}
           // $email = $site_data->site_email;
            $site_name = $site_data->site_name;
            $email_to =$email;
            $user_name = @$userinfo->first_name." ".@$userinfo->last_name;        
			$login_link= '<a href='.base_url().'postcard/view'.base64_encode($pid).'>Postcard Login</a>';
            $email_message=str_replace('{break}','<br/>',$email_message);
            $email_message=str_replace('{username}',$user_name,$email_message);
            $email_message=str_replace('{user}',$user,$email_message); 
             $email_message=str_replace('{link}',$login_link,$email_message);         
            $str=$email_message;
           // echo $str;exit;
            /** custom_helper email function **/
              if($email_temp->status=='active'){              
            email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
			  }	
			
			
			
			
			$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Postcard Admin'");
            
            $email_temp=$email_template->row();             
                
                    
            $email_address_from=$email_temp->from_address;
            $email_address_reply=$email_temp->reply_address;
                    
            $email_subject=$email_temp->subject;                
            $email_message=$email_temp->message;
              
			if($bar_detail['email']!="")
			{
				//$email = $bar_detail['email'];
				$user = $bar_detail['first_name']." ".$bar_detail['last_name'];
			}        
			else {
				//$email = $site_data->site_email;
				$user = "ADB";
			}
            $email = $site_data->site_email;
            $site_name = $site_data->site_name;
            $email_to =$site_data->site_email;
            $user_name = @$userinfo->first_name." ".@$userinfo->last_name;        
			
            $email_message=str_replace('{break}','<br/>',$email_message);
            $email_message=str_replace('{username}',$user_name,$email_message);
            $email_message=str_replace('{user}',$user,$email_message); 
                    
            $str=$email_message;
           // echo $str;exit;
            /** custom_helper email function **/
                if($email_temp->status=='active'){            
            email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
				}
			
			
			$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Postcard User'");
            
            $email_temp=$email_template->row();             
                
                    
            $email_address_from=$email_temp->from_address;
            $email_address_reply=$email_temp->reply_address;
                    
            $email_subject=$email_temp->subject;                
            $email_message=$email_temp->message;
              
			if($bar_detail['email']!="")
			{
				//$email = $bar_detail['email'];
				$user = $bar_detail['bar_title'];
			}        
			else {
				//$email = $userinfo->email;
				$user = $bar_detail['bar_title'];
			}
         	 $email = $userinfo->email;
            $site_name = $site_data->site_name;
            $email_to =$email;
            $user_name = @$userinfo->first_name." ".@$userinfo->last_name;        
			
            $email_message=str_replace('{break}','<br/>',$email_message);
            $email_message=str_replace('{username}',$user_name,$email_message);
            $email_message=str_replace('{user}',$user,$email_message); 
                    
            $str=$email_message;
           // echo $str;exit;
            /** custom_helper email function **/
                  if($email_temp->status=='active'){          
            email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
				  }
			//redirect('bar/bar_detail/'.base64_encode($bar_id).'/success');	
			$response = array("status"=>"success");
			echo json_encode($response);
		    die;		  
		
	}


	function add_bar_comment($bid = 0){
		//$data_insert = $_POST;	
		
		if(!check_user_authentication())
			{
				redirect("home/login");
			}
			
				
		$erro_str = '';
		if($_POST["comment_title"] == '')
		{
			  $erro_str .=  "<p>Comment title is required</p>";
		}
		
		if($_POST["comment"] == '')
		{
			$erro_str .=  "<p>Comment  is required</p>";
		}
		
		if($_POST["rating"] == '')
		{
			$erro_str .=  "<p>Rating  is required</p>";
		}
		
		if($erro_str !="")
		{
			$response = array("comment_error"=>$erro_str,"status"=>"fail");
			echo json_encode($response);
		     die;
		}
		
		$cmt_id = $this->bar_model->insert_bar_comment($_POST);		
		/*echo "Your comment added successfully";*/
		//echo $cmt_id;
		$latest_comment = latest_bar_comment($_POST['bar_id'],$cmt_id);
		
		//print_r($latest_comment);
		$latest_comment->cust_date = date('d M',strtotime($latest_comment->date_added));
	    $latest_comment->date_duration = getDuration($latest_comment->date_added); 
		$res =  json_encode($latest_comment);
		echo $res;
	}
	
	function contact_bar_owner($bar_id)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('phone', 'Phone', 'required');
		$this->form_validation->set_rules('email_new', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('desc', 'Query', 'required');
		$data["error"] = '';
		$data["msg"] = '';
		
		$bar_detail = $this->bar_model->get_one_bar(base64_decode($bar_id));
		
		if($this->form_validation->run() == FALSE)
		{			
				if(validation_errors())
				{
					$data["error"] = validation_errors();
				}else{
					$data["error"] = "";
				}
				$data["name"] = $this->input->post('name');
				$data["phone"] = $this->input->post('phone');
				$data["email"] = $this->input->post('email_new');
				$data["desc"] = $this->input->post('desc');
		}
		else {
			$name1 = $this->input->post('name');
			$phone_no = $this->input->post('phone');
			$email_user = $this->input->post('email_new');
			$desc = $this->input->post('desc');
			
			$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Get In Touch'");
			$email_temp=$email_template->row();	
			$email_address_from=$email_temp->from_address;
			$email_address_reply=$email_temp->reply_address;
			
			$email_subject=$email_temp->subject;				
			$email_message=$email_temp->message;
			$username = $bar_detail['first_name']." ".$bar_detail['last_name'];
			//$user = $frst.' '.$last;
			$email = $bar_detail['email'];
			$barname = ucwords($bar_detail['bar_first_name'])." ".ucwords($bar_detail['bar_last_name']);
			//$phoneno = $phone_no;
			//$comment = $msg;
			
			$email_to =$email;
			//$login_link= base_url().'home/activate/'.$uid."/".$confirm_code.'/user';
			$title='Contact Us';
			$base_url=base_url().getThemeName().'/';
			
			$email_message=str_replace('{username}',$username,$email_message);
			$email_message=str_replace('{break}','<br/>',$email_message);
			$email_message=str_replace('{name}',$name1,$email_message);
			$email_message=str_replace('{email}',$email_user,$email_message);
			$email_message=str_replace('{phone}',$phone_no,$email_message);
			$email_message=str_replace('{desc}',$desc,$email_message);
			$email_message=str_replace('{barname}',$barname,$email_message);
			//$email_message=str_replace('{user}',$user,$email_message);
			$str=$email_message;
			if($email_temp->status=='active'){
			email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
			}
			$data["msg"] = "success";
			
		}
		
		if($data["error"] !="")
		{
			$response = array("comment_error"=>$data["error"],"status"=>"fail");
			echo json_encode($response);
		    die;
		}
		
		if($data["msg"] == "success")
		{
			$response = array("status"=>"success");
			echo json_encode($response);
		    die;
		}
	}

	function changebarlogo()
	{	$valid_formats = array("jpg", "png", "gif", "bmp","jpeg","PNG","JPG","JPEG","GIF","BMP");
	
	   $ext = array();
	    if(!empty($_FILES['photoimg']['name']))
		{
		$ext = end(explode(".", $_FILES['photoimg']['name']));
		} 
		$bar_logo_img = '';
		if(in_array($ext,$valid_formats))
		{
		 if($_FILES['photoimg']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['photoimg']['name'];
             $_FILES['userfile']['type']     =   $_FILES['photoimg']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['photoimg']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['photoimg']['error'];
             $_FILES['userfile']['size']     =   $_FILES['photoimg']['size'];
   
			$config['file_name'] = 'bar_logo'.$rand;
			
            $config['upload_path'] = base_path().'upload/barlogo_orig/';
			
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			
			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   
              $this->image_lib->clear();
		   	
			
					$gd_var='gd2';
				
				
		   if ($_FILES["photoimg"]["type"]!= "image/png" and $_FILES["photoimg"]["type"] != "image/x-png") {		  
			   	$gd_var='gd2';			
			}
			
					
		   if ($_FILES["photoimg"]["type"] != "image/gif") {		   
		    	$gd_var='gd2';
		   }	   
		   
		   if ($_FILES["photoimg"]["type"] != "image/jpeg" and $_FILES["photoimg"]["type"] != "image/pjpeg" ) {		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 resize(base_path().'upload/barlogo_orig/'.$picture['file_name'],base_path().'upload/barlogo/'.$picture['file_name'],685,320);
             
			
			$this->image_lib->clear();
		   
		   resize(base_path().'upload/barlogo_orig/'.$picture['file_name'],base_path().'upload/barlogo_thumb/'.$picture['file_name'],120,120);
           
		   $this->image_lib->clear();
		   
		   
		   resize(base_path().'upload/barlogo_orig/'.$picture['file_name'],base_path().'upload/barlogo_312/'.$picture['file_name'],312,312);
             
			$this->image_lib->clear();
		   
		   
		   resize(base_path().'upload/barlogo_orig/'.$picture['file_name'],base_path().'upload/barlogo_291/'.$picture['file_name'],291,291);
             
			 $this->image_lib->clear();
		   
		   
		   resize(base_path().'upload/barlogo_orig/'.$picture['file_name'],base_path().'upload/barlogo_225/'.$picture['file_name'],225,225);
             $this->image_lib->clear();
		   
		   
		   resize(base_path().'upload/barlogo_orig/'.$picture['file_name'],base_path().'upload/barlogo_200/'.$picture['file_name'],200,200);
             $this->image_lib->clear();
		   
		   
		   resize(base_path().'upload/barlogo_orig/'.$picture['file_name'],base_path().'upload/barlogo_240/'.$picture['file_name'],240,240);
             
		  $this->image_lib->clear();
		   
		   
		 //  resize(base_path().'upload/barlogo_orig/'.$picture['file_name'],base_path().'upload/barlogo_140/'.$picture['file_name'],140,140);
             
		
			$bar_logo_img=$picture['file_name'];
			
		
			if($this->input->post('prev_bar_logo')!='')
				{
					if(file_exists(base_path().'upload/barlogo_140/'.$this->input->post('prev_bar_logo')))
					{
						$link=base_path().'upload/barlogo_140/'.$this->input->post('prev_bar_logo');
						unlink($link);
					}
					if(file_exists(base_path().'upload/barlogo_200/'.$this->input->post('prev_bar_logo')))
					{
						$link=base_path().'upload/barlogo_200/'.$this->input->post('prev_bar_logo');
						unlink($link);
					}
					if(file_exists(base_path().'upload/barlogo_240/'.$this->input->post('prev_bar_logo')))
					{
						$link=base_path().'upload/barlogo_240/'.$this->input->post('prev_bar_logo');
						unlink($link);
					}
					if(file_exists(base_path().'upload/barlogo_orig/'.$this->input->post('prev_bar_logo')))
					{
						$link=base_path().'upload/barlogo_orig/'.$this->input->post('prev_bar_logo');
						unlink($link);
					}
					if(file_exists(base_path().'upload/barlogo_312/'.$this->input->post('prev_bar_logo')))
					{
						$link=base_path().'upload/barlogo_312/'.$this->input->post('prev_bar_logo');
						unlink($link);
					}
					if(file_exists(base_path().'upload/barlogo_225/'.$this->input->post('prev_bar_logo')))
					{
						$link=base_path().'upload/barlogo_225/'.$this->input->post('prev_bar_logo');
						unlink($link);
					}
				if(file_exists(base_path().'upload/barlogo_291/'.$this->input->post('prev_bar_logo')))
					{
						$link=base_path().'upload/barlogo_291/'.$this->input->post('prev_bar_logo');
						unlink($link);
					}
					if(file_exists(base_path().'upload/barlogo/'.$this->input->post('prev_bar_logo')))
					{
						$link2=base_path().'upload/barlogo/'.$this->input->post('prev_bar_logo');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('prev_bar_logo')!='')
				{
					$bar_logo_img=$this->input->post('prev_bar_logo');
				}
				
				
			}
			 $update = array('bar_logo'=>$bar_logo_img);
			 $this->db->where("bar_id",$this->input->post('bar_id'));
		 	 $this->db->update("bars",$update);
			 echo "<img src='".base_url()."upload/barlogo_thumb/".$bar_logo_img."' class='img-responsive'/>";
			}
else {
	         echo "Invalid file format.."; 
}
            
	}

    function bar_events($limit=5,$keyword='1V1',$offset=0,$msg='')
	{
	    if($this->session->userdata('user_type')!='bar_owner')
		{
			redirect('home');
		}
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}

		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		$data['get_cat'] = $this->home_model->eventCategory();
		if($data['getbar']['bar_type']=='half_mug')
		{
			redirect('home/registration_step3_upgrade/'.base64_encode(@$data['getbar']['bar_id']));
		}
		if($this->input->post('event_keyword')!='')
		{
			$keyword= $this->input->post('event_keyword');
			$limit= $this->input->post('limit');
			$offset= $this->input->post('offset');
		}
		else {
			$keyword = $keyword;
			$limit= $limit;
			$offset= $offset;
		}
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'bar/bar_events/'.$limit.'/'.$keyword;
		$config["total_rows"] = $this->bar_model->getBarEventcount(@$data['getbar']['bar_id'],$keyword);
		
		//$config['total_rows'] = $this->service_provider_model->countStaff($id,$keyword);
		//echo $data["total_rows"];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->bar_model->getBarEventDetail(@$data['getbar']['bar_id'],$offset,$limit,$keyword);
		
	
		//	$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='bar_events';
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/bar/bar_events_ajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/bar/bar_events', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
	}
    
	function bareventdetail()
	{
		
		$getdata = $this->bar_model->getOneEvent();
		print_r(json_encode($getdata)) ;
		die;
	}
	
	function geteventcategory()
	{
		$get_cat = $this->home_model->eventCategory();
		$event_category = $this->input->post('id');
		$html = '';
		$html1 = '';
		$event_category = explode(',', @$event_category);
		if($get_cat)
		{
			foreach($get_cat as $list)
			{
				if(!empty($event_category))
				{
					$sel = '';
					if(in_array($list->event_category_id, $event_category))
					{
						$sel = "selected";
						 $html1 .= '<li class="select2-search-choice">    <div>'.$list->event_category_name.'</div>    <a tabindex="-1" class="select2-search-choice-close" onclick="return false;" href="#"></a></li>';
					}
					
					 $html.= '<option '.$sel.' value="'.$list->event_category_id.'">'.$list->event_category_name.'</option>';	
					
					
																				
				}
				else
				{																		
			 		$html.= '<option value="'.$list->event_category_id.'">'.$list->event_category_name.'</option>';
				}	
			}
		}
		
		$html1.= '<li class="select2-search-field">    <input type="text" class="select2-input select2-default" spellcheck="false" autocapitilize="off" autocorrect="off" autocomplete="off" id="s2id_autogen1" tabindex="0" style="width: 100%;">  </li>';
		
		//print_r(json_encode($html)) ;
		
		echo json_encode(array('result1'=>$html1,'result2'=>$html));
		die;
		die;
	}
	function bargallerydetail()
	{
		$getdata = $this->bar_model->getOneGallery();
		print_r(json_encode($getdata)) ;
		die;
	}
	function bargalleryimages()
	{
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$data = array();
		$data['imageGallery'] = $this->bar_model->getGalleryImages();
		
		//print_r(json_encode($getdata)) ;
		echo $this->load->view($theme.'/bar/bar_gallery_images_ajax',$data);
		die;
	}
	
	function bareventgalleryimages()
	{
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$data = array();
		$data['imageGallery'] = $this->bar_model->getEventGalleryImages();
		
		//print_r($data['imageGallery']) ;
		echo $this->load->view($theme.'/bar/bar_eventgallery_images_ajax',$data);
		//die;
	}
function bareventtime()
	{
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$data = array();
		$data['bareventtime'] = $this->bar_model->getEventtime();
		
		//print_r($data['imageGallery']) ;
		echo $this->load->view($theme.'/bar/bar_event_time_ajax',$data);
		//die;
	}
	
    function search_bar_events($limit=5,$keyword='1V1',$offset=0,$msg='')
	{
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}

		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
		if($_POST)
		{		
			$keyword=($this->input->post('event_keyword')!='')?str_replace(" ", "-",trim($this->input->post('event_keyword'))):'1V1';
			$limit=($this->input->post('limit'))?$this->input->post('limit'):$limit;
		}
		else
		{
			$keyword=$keyword;	
		}
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',trim($keyword)));
		if($keyword=='')
		{
			$keyword='1V1';
		}
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'bar/bar_events/'.$limit.'/'.$keyword;
		$config["total_rows"] = $this->bar_model->getBarEventSearchcount(@$data['getbar']['bar_id'],$keyword);
		
		//$config['total_rows'] = $this->service_provider_model->countStaff($id,$keyword);
		//echo $data["total_rows"];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->bar_model->getBarEventSearchDetail(@$data['getbar']['bar_id'],$keyword,$offset,$limit);
		
	
		//	$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='bar_events';
		
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/bar/bar_events_ajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/bar/bar_events', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
	}

     function add_event($bar_id='')
	{
		$imagarr = '';
		if($this->session->userdata('user_type')!='bar_owner')
		{
			redirect('home');
		}
                
               
                
		$this->load->library('form_validation');
		$this->form_validation->set_rules('event_title', 'Event Title', 'required');
		$this->form_validation->set_rules('event_desc', 'Event Description', 'required');
		//$this->form_validation->set_rules('start_date', 'Start Date', 'required');
		//$this->form_validation->set_rules('end_date', 'End Date','required|trim|callback_compareDates');
		//$this->form_validation->set_rules('start_time', 'Start Time', 'required');
		//$this->form_validation->set_rules('end_time', 'End Time','required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');
		$this->form_validation->set_rules('admission', 'Admission', 'numeric');
		$this->form_validation->set_rules('event_video_link','Event Video Link', 'valid_url');
		$this->form_validation->set_rules('website','Website', 'valid_url');
		$this->form_validation->set_rules('eventdate[]', 'Event Date', 'required|xss_clean');
		$this->form_validation->set_rules('eventstarttime[]', 'Event Start Time', 'required|xss_clean');
		$this->form_validation->set_rules('eventendtime[]', 'Event End Time', 'required|xss_clean');
	
                $data["error"] = '';
		$data["msg"] = '';
		// $this->form_validation->set_rules('event_fb_link','Facebook Link', 'valid_url');
		// $this->form_validation->set_rules('event_twitter_link','Twitter Link', 'valid_url');
		// $this->form_validation->set_rules('event_google_plus_link','Google Plus Link', 'valid_url');
		// $this->form_validation->set_rules('event_pinterest_link','Pinterest Link', 'valid_url');
		$this->form_validation->set_rules('buy_ticket','Buy Ticket', 'valid_url');
		$this->form_validation->set_rules('zipcode', 'Zipcode', 'required|numeric|max_length[6]');
		//$this->form_validation->set_rules('phone', 'Phone', 'required');
		
	
		
		
		if($_POST)
		{
			//echo '<pre>';
			//print_r($_FILES);die;
			// if($_FILES['event_video']['name']!=''){
					// if($_FILES['event_video']['name']!=''){
					   // $imagarr=$this->validate_video(array('name'=>$_FILES['event_video']['name'],'type'=>$_FILES['event_video']['type']));
					// }
					// if($imagarr!='')
					// {
						// //break;
					// }
// 				
			// }
			
			if(count($_FILES['photo_image']['name'])>0 && $_FILES['photo_image']['name'][0]!=''){
				foreach ($_FILES['photo_image']['name'] as $key => $value) {
					if($_FILES['photo_image']['name'][$key]!=''){
					   $imagarr=$this->validate_image(array('name'=>$_FILES['photo_image']['name'][$key],'type'=>$_FILES['photo_image']['type'][$key]));
					}
					if($imagarr!='')
					{
						break;
					}
				}
				//echo $imagarr.'<br>';
				
			}
			// else{
				// if($this->input->post('event_id')==''){
				// $imagarr ="Event image is required.";
				// }
			// }
		}	
		
                $data['getbar'] = $this->home_model->get_bar_info($bar_id);
		$bar_detail = $this->bar_model->get_one_bar(base64_decode($bar_id));
		
		if($this->form_validation->run() == FALSE || $imagarr!='')
		{			
				if(validation_errors()  || $imagarr!='')
				{
					$data["error"] = validation_errors().$imagarr;
				}else{
					$data["error"] = "";
				}
				$data["event_title"] = $this->input->post('event_title');
				$data["event_desc"] = $this->input->post('event_desc');
				//$data["start_date"] = $this->input->post('start_date');
				//$data["end_date"] = $this->input->post('end_date');
				$data["address"] = $this->input->post('desc');
				//$data["start_time"] = $this->input->post('start_time');
				$data["event_category"] = $this->input->post('event_category');
				//$data["end_time"] = $this->input->post('end_time');
				$data["event_id"] = $this->input->post('event_id');
				$data["city"] = $this->input->post('city');
				$data["state"] = $this->input->post('state');
				$data["zipcode"] = $this->input->post('zipcode');
				$data["phone"] = $this->input->post('phone');
				$data["venue"] = $this->input->post('venue');
				$data["prev_event_image"] = $this->input->post('prev_event_image');
				$data["prev_event_video"] = $this->input->post('prev_event_video');
				$data["event_video_link"] = $this->input->post('event_video_link');
				$data["is_power_boost_event"] = $this->input->post('is_power_boost_event');
				$data["status"] = $this->input->post('status');
				
		}
		else {
			if($this->input->post('event_id')=='')
			{
			    $this->bar_model->event_insert(base64_decode($bar_id));			
				$data["msg"] = "success";	
			}
			else {
				$this->bar_model->event_update(base64_decode($bar_id));			
				$data["msg"] = "success";
			}
			
			
		}
		
		if($data["error"] !="")
		{
			$response = array("comment_error"=>$data["error"],"status"=>"fail");
			echo json_encode($response);
		    die;
		}
		
		if($data["msg"] == "success")
		{
			$response = array("status"=>"success");
			echo json_encode($response);
		    die;
		}
	}
	public function validate_image($image = NULL) {
	       // print_r($image);die;
	        $file_name      =   $image['name'];
	
	        $allowed_ext    =   array('gif', 'jpeg','jpg','png');
	        $ext                =   strtolower(end(explode('.', $file_name)));
	
	        $allowed_file_types =   array('image/jpeg', 'image/pjpeg','image/png',  'image/x-png','image/gif');
	        $file_type              =   $image['type'];
	
	        if(!in_array($ext, $allowed_ext) && !in_array($file_type, $allowed_file_types)) {
	            
	            return 'Image file type is not allowed.';
				
	            
	        }else{
	        	return '';
	        }
			        
	    }
	
	public function validate_video($image = NULL) {
	       // print_r($image);die;
	      
	        $file_name      =   $image['name'];
	
	        $allowed_ext    =   array('mp3', 'mp4','3gp','3gpp','mpg','mpeg','flv','avi');
	        $ext                =   strtolower(end(explode('.', $file_name)));
	
	        $allowed_file_types =   array('audio/mpeg', 'audio/mpg', 'audio/mpeg3', 'audio/mp3', 'video/mpeg', 'video/quicktime','video/x-msvideo','video/x-sgi-movie','video/wmv', 'video/x-ms-wmv', 'flv-application/octet-stream', 'application/octet-stream','video/x-flv', 'flv-application/octet-stream', 'application/octet-stream','video/mp4','video/3gpp','video/avi');
	        $file_type              =   $image['type'];
	
	        if(!in_array($ext, $allowed_ext) && !in_array($file_type, $allowed_file_types)) {
	            
	            return 'Video file type is not allowed.';
				
	            
	        }else{
	        	return '';
	        }
			        
	    }
	function compareDates()
	{
	$start = strtotime($this->input->post('start_date'));
	$end = strtotime($this->input->post('end_date'));
   	
	if($start > $end)
	{
	    $this->form_validation->set_message('compareDates','Your end date must greater than your start date');
	    return false;
	}
	}
 	function details($bar_slug = 0, $msg = '',$limit=4,$offset=0)
   {
   	
   
   	    if($bar_slug=="" || $bar_slug=="0")
		{
			redirect('home');
		}
		
		$bar_id = getBarID($bar_slug);
		$this->load->library('pagination');
		
	    $data = array();
		$data['msg'] = $msg;
		$data["bar_id"] = $bar_id;
		$data['time'] = '';
		
		$theme = getThemeName ();
		$data['theme'] = $theme;
		$this->template->set_master_template ($theme.'/template.php');
		
		$count = getBarByIDCount($bar_id);
		
		if($count==0)
		{
			if($bar_id!=0)
			{
			$add = array('bar_id'=>$bar_id, 
			            'impression'=>1,
						'visit'=>1,
						'ip'=>$_SERVER['REMOTE_ADDR']);
			$this->db->insert('count_clcik_bar',$add);	
			}
			//echo $this->db->last_query();
			//die;		
						
		}
		if($count>0) 
		{
			$dt = getbarimpByID($bar_id);
			
			 
			if($dt==1 && $bar_id!='')
			{
				$data_update = array("visit"=>1,'ip'=>$_SERVER['REMOTE_ADDR'],'bar_id'=>$bar_id, );
				$this->db->insert('count_clcik_bar',$data_update);	
				
			}
			else {
				$data_update1 = array("visit"=>1,'impression'=>1,'ip'=>$_SERVER['REMOTE_ADDR'],'bar_id'=>$bar_id, );
				$this->db->insert("count_clcik_bar",$data_update1);
			}
			
		}	
		
		
		//$this->bar_model->insert_total_views($bar_id ,$this->session->userdata("user_id"));
		
		$data["bar_liker"] = $this->bar_model->get_bar_likers($bar_id);
		$data["bar_detail"] = $this->bar_model->get_one_bar($bar_id);
		$data["get_bar_hour"] = $this->bar_model->get_bar_hour($bar_id);
		
		
		$data["bar_gallery"] = $this->bar_model->getBarGallery($bar_id);
		
		$data["bar_gallery_all"] = $this->bar_model->getBarGalleryAll($bar_id);
		$data["bar_event"] = $this->bar_model->getBarEvent($bar_id,$limit=4);
		$data["bar_beer"] = $this->bar_model->getBarBeer($bar_id,$limit=4);
		$data["bar_cocktail"] = $this->bar_model->getBarCocktail($bar_id,$limit=4);
		$data['get_post_card'] = getTodayPostCard($bar_id);
		$data['user_detail'] = get_user_info(get_authenticateUserID());
		$data['barhours'] =  $this->bar_model->getBarHours($bar_id);
		// echo "<pre>";
		// print_r($data["barhours"]);
		// die;
		if($data['bar_detail']['lat']!=''){
		$data['bar_detail_map'] = $this->bar_model->getbarnear($data['bar_detail']['lat'],$data['bar_detail']['lang'],$bar_id);
		}
			else {
				$data['bar_detail_map'] = '';
			}
		$page_detail=meta_setting();
		$pageTitle=$data["bar_detail"]['bar_meta_title'];
		$metaDescription=$data["bar_detail"]['bar_meta_description'];
		$metaKeyword=$data["bar_detail"]['bar_meta_keyword'];
		
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
		
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
	
		if($data['get_post_card']!=0)
		{
			//echo ;
			
			$timestamp1 = strtotime($data['get_post_card']['date_added']);
			$timestamp2 = strtotime(date('Y-m-d h:i:s'));
			$data['time'] = abs($timestamp2 - $timestamp1)/(60*60);
		}
		
		$bar_type = $data["bar_detail"]['bar_type'];
		
		$data["bar_liker"] = $this->bar_model->get_bar_likers($bar_id);
		
		
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'bar/details/'.$bar_slug.'/'.$msg="null".'/'.$limit.'/';
		$config["total_rows"] = $this->bar_model->get_bar_comments_count($bar_id);
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		
		if($data['result']=='')
		{
			//$offset=0;
			$config['uri_segment']='6';
			$config['base_url'] = base_url().'bar/bar_detail/'.$bar_slug.'/'.$msg="null".'/'.$limit.'/';
			$config["total_rows"] = $this->bar_model->get_bar_comments_count($bar_id);
			$config['per_page'] = $limit;
			$this->pagination->initialize($config);		
			$data['page_link'] = $this->pagination->create_links();
			$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		}
		$data["bar_subcomment"] = $this->bar_model->get_bar_subcomments($bar_id);
		//echo '<pre>';
		//print_r($data["bar_subcomment"]);
		//$data["bar_comment"] = $this->bar_model->get_bar_comment($bar_id);
		
        $data["check_already_retade"] = check_already_bar_rated($bar_id,$this->session->userdata("user_id"));
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/bar/comment_ajax',$data,TRUE);die;
		}
	else
	{
        if(get_authenticateUserID() > 0)
        {
		  $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        }
        else
        {
            $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        }
		//$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        
		
		if($bar_type =='half_mug')
		{
		//echo "dsad"; die;
		 
			$this->template->write_view ('content_center', $theme.'/bar/halfmug_bar_detail', $data, TRUE);
		}
	}
		if($bar_type =='full_mug'){
			
			
			$this->template->write_view ('content_center', $theme.'/bar/fullmug_bar_detail', $data, TRUE);
		}
	
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();		
    } 
    
    
    function bareventdelete()
	{
		$datadelete = array('is_deleted'=>'yes');
		$this->db->where("event_id",$this->input->post('id'));
		$this->db->update('events',$datadelete);	
		
		
	}
	
	  function barproductdelete()
	{
			$this->db->where('store_id',$this->input->post('id'))->delete('store');	
	}
	
	function actionevent()
	{
			$event_id =$this->input->post('chk');
			foreach($event_id as $id)
			{			
				$datadelete = array('is_deleted'=>'yes');
				$this->db->where("event_id",$id);
				$this->db->update('events',$datadelete);
			}
		$res=array('status'=>'done');
		echo json_encode($res);die;
			
	}
	
	function actionbeer()
	{
			$event_id =$this->input->post('chk');
			foreach($event_id as $id)
			{			
				$this->db->where('beer_bar_id',$id)->delete('beer_bars');
			}
		$res=array('status'=>'done');
		echo json_encode($res);die;
			
	}
	
	function actioncocktail()
	{
			$cocktail_id =$this->input->post('chk');
			foreach($cocktail_id as $id)
			{			
				$this->db->where('cocktail_bar_id',$id)->delete('cocktail_bars');
			}
		$res=array('status'=>'done');
		echo json_encode($res);die;
			
	}
	
	function actionproduct()
	{
			$store_id =$this->input->post('chk');
			foreach($store_id as $id)
			{			
				$this->db->where('store_id',$id)->delete('store');
			}
		$res=array('status'=>'done');
		echo json_encode($res);die;
			
	}
	
	function actionliquor()
	{
			$liquor_id =$this->input->post('chk');
			foreach($liquor_id as $id)
			{			
				$this->db->where('liquor_bar_id',$id)->delete('liquors_bars');
			}
		$res=array('status'=>'done');
		echo json_encode($res);die;
			
	}
	
	function bar_gallery($limit=5,$keyword='1V1',$offset=0,$msg='')
	{
		if($this->session->userdata('user_type')!='bar_owner')
		{
			redirect('home');
		}
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}

		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		if($data['getbar']['bar_type']=='half_mug')
		{
			redirect('home/registration_step3_upgrade/'.base64_encode(@$data['getbar']['bar_id']));
		}
		if($this->input->post('event_keyword')!='')
		{
			$keyword= $this->input->post('event_keyword');
			$limit= $this->input->post('limit');
			$offset= $this->input->post('offset');
		}
		else {
			$keyword = $keyword;
			$limit= $limit;
			$offset= $offset;
		}
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'bar/bar_gallery/'.$limit.'/'.$keyword;
		$config["total_rows"] = $this->bar_model->getBarGallerycount(@$data['getbar']['bar_id'],$keyword);
		
		//$config['total_rows'] = $this->service_provider_model->countStaff($id,$keyword);
		//echo $data["total_rows"];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->bar_model->getBarGalleryDetail(@$data['getbar']['bar_id'],$offset,$limit,$keyword);
		
	
		//	$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='bar_gallery';
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/bar/bar_gallery_ajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/bar/bar_gallery', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
	}
    
	 function add_gallery($bar_id='')
	{
		$imagarr = '';
		if($this->session->userdata('user_type')!='bar_owner')
		{
			redirect('home');
		}
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required');
		
		if($_POST)
		{
			//echo '<pre>';
			//print_r($_FILES);die;
			
			if(count($_FILES['photo_image']['name'])>0 && $_FILES['photo_image']['name'][0]!=''){
				foreach ($_FILES['photo_image']['name'] as $key => $value) {
					if($_FILES['photo_image']['name'][$key]!=''){
					   $imagarr=$this->validate_image(array('name'=>$_FILES['photo_image']['name'][$key],'type'=>$_FILES['photo_image']['type'][$key]));
					}
					if($imagarr!='')
					{
						break;
					}
				}
				//echo $imagarr.'<br>';
				
			}else{
				if($this->input->post('bar_gallery_id')==''){
				$imagarr ="Gallery image is required.";
				}
			}
		}	
		//$this->form_validation->set_rules('description', 'Description', 'required');
		$data["error"] = '';
		$data["msg"] = '';
		
		$bar_detail = $this->bar_model->get_one_bar(base64_decode($bar_id));
		
		if($this->form_validation->run() == FALSE || $imagarr!='')
		{			
				if(validation_errors()  || $imagarr!='')
				{
					$data["error"] = validation_errors().$imagarr;
				}else{
					$data["error"] = "";
				}
				$data["title"] = $this->input->post('title');
				$data["description"] = $this->input->post('description');
				$data["prev_photo_image"] = $this->input->post('prev_photo_image');
				$data["type"] = $this->input->post('type');
				$data["status"] = $this->input->post('status');
		}
		else {
			if($this->input->post('bar_gallery_id')=='')
			{
			    $this->bar_model->bar_gallery_insert(base64_decode($bar_id));			
				$data["msg"] = "success";	
			}
			else {
				$this->bar_model->bar_gallery_update(base64_decode($bar_id));			
				$data["msg"] = "success";
			}
			
			
		}
		
		if($data["error"] !="")
		{
			$response = array("comment_error"=>$data["error"],"status"=>"fail");
			echo json_encode($response);
		    die;
		}
		
		if($data["msg"] == "success")
		{
			$response = array("status"=>"success");
			echo json_encode($response);
		    die;
		}
	}

    function removeImageAjax($id=0)
	{
		$oneImage=$this->bar_model->getOneImageGallery($id);
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
		
	}	
	
	 function removeImageAjaxEvent($id=0)
	{
		$oneImage=$this->bar_model->getOneEventImageGallery($id);
		//print_r($oneImage);die;
		if($oneImage!='')
		{
			if($oneImage->event_image_name!=''){
			if(file_exists(base_path().'upload/bar_eventgallery_orig/'.$oneImage->event_image_name))
			{
				unlink(base_path().'upload/bar_eventgallery_orig/'.$oneImage->event_image_name);
			}
			if(file_exists(base_path().'upload/bar_eventgallery_thumb/'.$oneImage->event_image_name))
			{
				unlink(base_path().'upload/bar_eventgallery_thumb/'.$oneImage->event_image_name);
			}
			if(file_exists(base_path().'upload/bar_eventgallery_thumb_big/'.$oneImage->event_image_name))
			{
				unlink(base_path().'upload/bar_eventgallery_thumb_big/'.$oneImage->event_image_name);
			}
			
			}
			$this->db->where('event_image_id',$oneImage->event_image_id)->delete('event_images');
		}
		
	}	
	
	 function removeTimeAjaxEvent($id=0)
	{
		$oneImage=$this->bar_model->getOneEventTime($id);
		//print_r($oneImage);die;
		if($oneImage!='')
		{
			$this->db->where('sss_event_time_id',$oneImage->sss_event_time_id)->delete('event_time');
		}
		
	}	
	
	  function bargallerydelete()
	{
		$this->db->where('bar_gallery_id',$this->input->post('id'))->delete('bar_gallery');
		$this->db->where('bar_gallery_id',$this->input->post('id'))->delete('bar_images');
		
	}
	
	function barbeerdelete()
	{
		$this->db->where('beer_bar_id',$this->input->post('id'))->delete('beer_bars');
		
	}
	
	function barcocktaildelete()
	{
		$this->db->where('cocktail_bar_id',$this->input->post('id'))->delete('cocktail_bars');
	}

	function barliquordelete()
	{
		$this->db->where('liquor_bar_id',$this->input->post('id'))->delete('liquors_bars');
	}

	function actiongallery()
	{
			$gal_id =$this->input->post('chk');
			foreach($gal_id as $id)
			{			
				$this->db->where('bar_gallery_id',$id)->delete('bar_gallery');
				$this->db->where('bar_gallery_id',$id)->delete('bar_images');
			}
		$res=array('status'=>'done');
		echo json_encode($res);die;
			
	}
	
	function bar_beer($limit=10,$keyword='1V1',$offset=0,$msg='')
	{
		if($this->session->userdata('user_type')!='bar_owner')
		{
			redirect('home');
		}
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		

		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		
		$data['beer_list'] 	 = $this->bar_model->getBeer(@$data['getbar']['bar_id']);
		if($this->input->post('event_keyword')!='')
		{
			$keyword= $this->input->post('event_keyword');
			$limit= $this->input->post('limit');
			$offset= $this->input->post('offset');
		}
		else {
			$keyword = $keyword;
			$limit= $limit;
			$offset= $offset;
		}
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'bar/bar_beer/'.$limit.'/'.$keyword;
		$config["total_rows"] = $this->bar_model->getBarBeercount(@$data['getbar']['bar_id'],$keyword);
		
		//$config['total_rows'] = $this->service_provider_model->countStaff($id,$keyword);
		//echo $data["total_rows"];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->bar_model->getBarBeerDetail(@$data['getbar']['bar_id'],$offset,$limit,$keyword);
		
	    // echo "<pre>";
		// print_r($data['result']);
		//	$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='bar_beer';
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/bar/bar_beer_ajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/bar/bar_beer', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
	}

    function getallbeerbybar()
	{
		$operator_list 	 = $this->bar_model->getBeer();
		// $arr = array();	
		// foreach($operator_list as $key=>$val){
// 			
			// $chckexist = checkbeerbarexist($val['beer_id'],$_REQUEST["utype"]);
			// if($chckexist==0)
			// {
					// $arr[] = array("id"=>$val['beer_id'],"label"=>$val['beer_name'],"value"=>$val['beer_name']); 
			// }
// 		
		// }
		//print_r(json_encode($operator_list));die;
		$html = '';
		$html1 = '';
		if($operator_list)
		{
			$i=0;foreach($operator_list as $list1)
			{
				$chckexist = checkbeerbarexist($list1->beer_id,$this->input->post('id'));
				if($chckexist==0)
			    {
					$html1.= '<li style="" class="active-result" id="beer_id_chzn_o_'.$i.'">'.$list1->beer_name.'</li>';
				}
else {
	$i--;
}
			$i++;}
		}
		if($operator_list)
		{
			foreach($operator_list as $list)
			{
				$chckexist = checkbeerbarexist($list->beer_id,$this->input->post('id'));
				if($chckexist==0)
			    {
			 		$html.= '<option value="'.$list->beer_id.'">'.$list->beer_name.'</option>';
				}
			}
		}
		//echo(json_encode($html));
		
		//print_r($html1);
		//die;
		echo json_encode(array('result1'=>$html,'result2'=>$html1));
		die;
	}
	
	 function getallbeerbybar_new()
	{
		$search = isset($_GET['c'])?$_GET['c']:'';
		$bar_id = isset($_GET['bar_id'])?$_GET['bar_id']:'';
		$operator_list = $this->bar_model->getAllBeerByID($search,$bar_id);
		echo json_encode($operator_list);
		die;
	}
	
	function getallcocktailbybar_new()
	{	$search = isset($_GET['c'])?$_GET['c']:'';
		$bar_id = isset($_GET['bar_id'])?$_GET['bar_id']:'';
		$operator_list = $this->bar_model->getAllCocktailByID($search,$bar_id);
		echo json_encode($operator_list);
		die;
	}
function getallliquorbybar_new()
	{	$search = isset($_GET['c'])?$_GET['c']:'';
		$bar_id = isset($_GET['bar_id'])?$_GET['bar_id']:'';
		$operator_list = $this->bar_model->getAllLiquorByID($search,$bar_id);
		echo json_encode($operator_list);
		die;
	}
	function add_beer($bar_id='', $redirect='')
	{
		if($this->session->userdata('user_type')!='bar_owner')
		{
			redirect('home');
		}
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('beer_id[]', 'Beer Name', 'required');
		
		
		//$this->form_validation->set_rules('description', 'Description', 'required');
		$data["error"] = '';
		$data["msg"] = '';
		
		$bar_detail = $this->bar_model->get_one_bar(base64_decode($bar_id));
		
		if($this->form_validation->run() == FALSE)
		{			
				if(validation_errors())
				{
					$data["error"] = validation_errors();
				}else{
					$data["error"] = "";
				}
				
				
				$data["beer_id"] = $this->input->post('beer_id');
				$data["beer_bar_id"] = $this->input->post('beer_bar_id');
				//if($data["error"] !="")
				//{
					$response = array("comment_error"=>$data["error"],"status"=>"fail");
				//}
		}
		else {
			if($this->input->post('beer_bar_id')=='')
			{
				
			    $this->bar_model->bar_beer_insert(base64_decode($bar_id));			
				$data["msg"] = "success";	
				// if($data["msg"] == "success")
				// {a
					$response = array("status"=>"success");
				//}
			}
			
			
		}
                
                if ($redirect == "bar_beer")
                {
                    redirect('bar/bar_beer');
                }
		
		echo json_encode($response);
		die;
		
		
		
	}
        
        function add_drink()
        {
            if($this->session->userdata('user_type')!='bar_owner')
            {
                    redirect('home');
            }
            if(get_authenticateUserID()=='')
            {
                    redirect('home');
            }

            $data["error"] = '';
            $data["msg"] = '';
                
            $theme = getThemeName ();
	    $this->template->set_master_template ($theme.'/template.php');
            $page_detail=meta_setting();
            $pageTitle=$page_detail->title;
            $metaDescription=$page_detail->meta_description;
            $metaKeyword=$page_detail->meta_keyword;

            $data['error'] = '';
            $data['site_setting'] = site_setting ();
            
            $this->template->write ('pageTitle', $pageTitle, TRUE);
            $this->template->write ('metaDescription', $metaDescription, TRUE);
            $this->template->write ('metaKeyword', $metaKeyword, TRUE);
                
            $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
            $this->template->write_view ('content_center', $theme.'/home/drinks', $data, TRUE);
            $this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
            $this->template->render ();
        }
        
        function choose_beer($limit=10,$keyword='1V1',$offset=0,$msg='')
        {
            if($this->session->userdata('user_type')!='bar_owner')
		{
			redirect('home');
		}
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		

		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		
		$data['beer_list'] 	 = $this->bar_model->getBeer(@$data['getbar']['bar_id']);
		if($this->input->post('event_keyword')!='')
		{
			$keyword= $this->input->post('event_keyword');
			$limit= $this->input->post('limit');
			$offset= $this->input->post('offset');
		}
		else {
			$keyword = $keyword;
			$limit= $limit;
			$offset= $offset;
		}
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'bar/bar_beer/'.$limit.'/'.$keyword;
		$config["total_rows"] = $this->bar_model->getBarBeercount(@$data['getbar']['bar_id'],$keyword);
		
		//$config['total_rows'] = $this->service_provider_model->countStaff($id,$keyword);
		//echo $data["total_rows"];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->bar_model->getBarBeerDetail(@$data['getbar']['bar_id'],$offset,$limit,$keyword);
		
	    // echo "<pre>";
		// print_r($data['result']);
		//	$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='bar_beer';
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/bar/bar_beer_ajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/bar/bar_beer_add', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
        }

    function bar_cocktail($limit=10,$keyword='1V1',$offset=0,$msg='')
	{
		if($this->session->userdata('user_type')!='bar_owner')
		{
			redirect('home');
		}
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
        
		$getbarinfo = getBarInfoByUserID(get_authenticateUserID());
		
		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		
		if($this->input->post('event_keyword')!='')
		{
			$keyword= $this->input->post('event_keyword');
			$limit= $this->input->post('limit');
			$offset= $this->input->post('offset');
		}
		else {
			$keyword = $keyword;
			$limit= $limit;
			$offset= $offset;
		}
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'bar/bar_cocktail/'.$limit.'/'.$keyword;
		$config["total_rows"] = $this->bar_model->getBarCocktailcount(@$data['getbar']['bar_id'],$keyword);
		
		//$config['total_rows'] = $this->service_provider_model->countStaff($id,$keyword);
		//echo $data["total_rows"];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->bar_model->getBarCocktailDetail(@$data['getbar']['bar_id'],$offset,$limit,$keyword);
		
	
		//	$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='bar_cocktail';
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/bar/bar_cocktail_ajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
			
			//echo $getbarinfo->serve_as;
		if($getbarinfo->serve_as=='liquor')
		{
			$this->template->write_view ('content_center', $theme.'/bar/bar_cocktail_no', $data, TRUE);
		}
		else
	    {
	    	
	       $this->template->write_view ('content_center', $theme.'/bar/bar_cocktail', $data, TRUE);	
	    }		
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
	}

        function choose_cocktail($limit=10,$keyword='1V1',$offset=0,$msg='')
	{
		if($this->session->userdata('user_type')!='bar_owner')
		{
			redirect('home');
		}
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
        
		$getbarinfo = getBarInfoByUserID(get_authenticateUserID());
		
		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		
		if($this->input->post('event_keyword')!='')
		{
			$keyword= $this->input->post('event_keyword');
			$limit= $this->input->post('limit');
			$offset= $this->input->post('offset');
		}
		else {
			$keyword = $keyword;
			$limit= $limit;
			$offset= $offset;
		}
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'bar/bar_cocktail/'.$limit.'/'.$keyword;
		$config["total_rows"] = $this->bar_model->getBarCocktailcount(@$data['getbar']['bar_id'],$keyword);
		
		//$config['total_rows'] = $this->service_provider_model->countStaff($id,$keyword);
		//echo $data["total_rows"];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->bar_model->getBarCocktailDetail(@$data['getbar']['bar_id'],$offset,$limit,$keyword);
		
	
		//	$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='bar_cocktail';
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/bar/bar_cocktail_ajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
			
			//echo $getbarinfo->serve_as;
//		if($getbarinfo->serve_as=='liquor')
//		{
//			$this->template->write_view ('content_center', $theme.'/bar/bar_cocktail_no', $data, TRUE);
//		}
//		else
//                {
//
//                   $this->template->write_view ('content_center', $theme.'/bar/bar_cocktail_add', $data, TRUE);	
//                }		
                    $this->template->write_view ('content_center', $theme.'/bar/bar_cocktail_add', $data, TRUE);
                    $this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
                    $this->template->render ();
		}
	}
        
    function bar_liquor($limit=10,$keyword='1V1',$offset=0,$msg='')
	{
		if($this->session->userdata('user_type')!='bar_owner')
		{
			redirect('home');
		}
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		$getbarinfo = getBarInfoByUserID(get_authenticateUserID());
		
		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		
		if($this->input->post('event_keyword')!='')
		{
			$keyword= $this->input->post('event_keyword');
			$limit= $this->input->post('limit');
			$offset= $this->input->post('offset');
		}
		else {
			$keyword = $keyword;
			$limit= $limit;
			$offset= $offset;
		}
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'bar/bar_liquor/'.$limit.'/'.$keyword;
		$config["total_rows"] = $this->bar_model->getBarLiquorcount(@$data['getbar']['bar_id'],$keyword);
		
		//$config['total_rows'] = $this->service_provider_model->countStaff($id,$keyword);
		//echo $data["total_rows"];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->bar_model->getBarLiquorDetail(@$data['getbar']['bar_id'],$offset,$limit,$keyword);
		
	
		//	$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='bar_liquor';
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/bar/bar_liquor_ajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
//		if($getbarinfo->serve_as=='cocktail')
//		{
//			//redirect('bar/bar_cocktail');
//			$this->template->write_view ('content_center', $theme.'/bar/bar_liquor_no', $data, TRUE);
//		}
//                    else
//                {
//                   $this->template->write_view ('content_center', $theme.'/bar/bar_liquor', $data, TRUE);	
//                }
		
		$this->template->write_view ('content_center', $theme.'/bar/bar_liquor', $data, TRUE);
                $this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
	}
        
        function choose_liquor($limit=10,$keyword='1V1',$offset=0,$msg='')
	{
            if($this->session->userdata('user_type')!='bar_owner')
		{
			redirect('home');
		}
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		$getbarinfo = getBarInfoByUserID(get_authenticateUserID());
		
		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		
		if($this->input->post('event_keyword')!='')
		{
			$keyword= $this->input->post('event_keyword');
			$limit= $this->input->post('limit');
			$offset= $this->input->post('offset');
		}
		else {
			$keyword = $keyword;
			$limit= $limit;
			$offset= $offset;
		}
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'bar/bar_liquor/'.$limit.'/'.$keyword;
		$config["total_rows"] = $this->bar_model->getBarLiquorcount(@$data['getbar']['bar_id'],$keyword);
		
		//$config['total_rows'] = $this->service_provider_model->countStaff($id,$keyword);
		//echo $data["total_rows"];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->bar_model->getBarLiquorDetail(@$data['getbar']['bar_id'],$offset,$limit,$keyword);
		
	
		//	$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='bar_liquor';
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/bar/bar_liquor_ajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
//		if($getbarinfo->serve_as=='cocktail')
//		{
//			//redirect('bar/bar_cocktail');
//			$this->template->write_view ('content_center', $theme.'/bar/bar_liquor_no', $data, TRUE);
//		}
//                    else
//                {
//                   $this->template->write_view ('content_center', $theme.'/bar/bar_liquor', $data, TRUE);	
//                }
		
		$this->template->write_view ('content_center', $theme.'/bar/bar_liquor_add', $data, TRUE);
                $this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
	}

    function add_cocktail($bar_id='', $redirect='')
	{
		if($this->session->userdata('user_type')!='bar_owner')
		{
			redirect('home');
		}
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('cocktail_id[]', 'Cocktail Name', 'required');
		//$this->form_validation->set_rules('description', 'Description', 'required');
		$data["error"] = '';
		$data["msg"] = '';
		
		$bar_detail = $this->bar_model->get_one_bar(base64_decode($bar_id));
		
		if($this->form_validation->run() == FALSE)
		{			
				if(validation_errors())
				{
					$data["error"] = validation_errors();
				}else{
					$data["error"] = "";
				}
				$data["cocktail_id"] = $this->input->post('cocktail_id');
				$data["cocktail_bar_id"] = $this->input->post('cocktail_bar_id');
				$response = array("comment_error"=>$data["error"],"status"=>"fail");
		}
		else {
			if($this->input->post('cocktail_bar_id')=='')
			{
				
			    $this->bar_model->bar_cocktail_insert(base64_decode($bar_id));			
				$data["msg"] = "success";	
				$response = array("status"=>"success");
			}
			
			
		}
                
                if($redirect == "bar_cocktail") {
                    redirect("bar/bar_cocktail");
                }
		
			echo json_encode($response);
		    die;
	}

	function add_liquor($bar_id='', $redirect="")
	{
		if($this->session->userdata('user_type')!='bar_owner')
		{
			redirect('home');
		}
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('liquor_id[]', 'Liquor Name', 'required');
		//$this->form_validation->set_rules('description', 'Description', 'required');
		$data["error"] = '';
		$data["msg"] = '';
		
		$bar_detail = $this->bar_model->get_one_bar(base64_decode($bar_id));
		
		if($this->form_validation->run() == FALSE)
		{			
				if(validation_errors())
				{
					$data["error"] = validation_errors();
				}else{
					$data["error"] = "";
				}
				$data["liquor_id"] = $this->input->post('liquor_id');
				$data["liquor_bar_id"] = $this->input->post('liquor_bar_id');
				$response = array("comment_error"=>$data["error"],"status"=>"fail");
		}
		else {
			if($this->input->post('liquor_bar_id')=='')
			{
				
			    $this->bar_model->bar_liquor_insert(base64_decode($bar_id));			
				$data["msg"] = "success";	
				$response = array("status"=>"success");
			}
			
			
		}
                
                if ( $redirect == "bar_liquor") {
                    redirect("bar_liquor");
                }
		
			echo json_encode($response);
		    die;
	}

 	function getallcocktailbybar()
	{
		$operator_list 	 = $this->bar_model->getCocktail();
		
		$html = '';
		$html1 = '';
		if($operator_list)
		{
			$i=0;foreach($operator_list as $list1)
			{
				$chckexist = checkcocktailbarexist($list1->cocktail_id,$this->input->post('id'));
				if($chckexist==0)
			    {
			 		
					$html1.= '<li style="" class="active-result" id="beer_id_chzn_o_'.$i.'">'.$list1->cocktail_name.'</li>';
				}
				else {
	$i--;
}
			$i++;}
		}
		if($operator_list)
		{
			foreach($operator_list as $list)
			{
				$chckexist = checkcocktailbarexist($list->cocktail_id,$this->input->post('id'));
				if($chckexist==0)
			    {
			 		$html.= '<option value="'.$list->cocktail_id.'">'.$list->cocktail_name.'</option>';
				}
			}
		}
		//echo(json_encode($html));
		
		//print_r($html1);
		//die;
		echo json_encode(array('result1'=>$html,'result2'=>$html1));
		die;
	}
	
	
	function getallliquorbybar()
	{
		$operator_list 	 = $this->bar_model->getLiquor();
		
		$html = '';
		$html1 = '';
		if($operator_list)
		{
			$i=0;foreach($operator_list as $list1)
			{
				$chckexist = checkliquorbarexist($list1->liquor_id,$this->input->post('id'));
				if($chckexist==0)
			    {
			 		
					$html1.= '<li style="" class="active-result" id="beer_id_chzn_o_'.$i.'">'.$list1->liquor_title.'</li>';
				}
				else {
	$i--;
}
			$i++;}
		}
		if($operator_list)
		{
			foreach($operator_list as $list)
			{
				$chckexist = checkliquorbarexist($list->liquor_id,$this->input->post('id'));
				if($chckexist==0)
			    {
			 		$html.= '<option value="'.$list->liquor_id.'">'.$list->liquor_title.'</option>';
				}
			}
		}
		//echo(json_encode($html));
		
		//print_r($html1);
		//die;
		echo json_encode(array('result1'=>$html,'result2'=>$html1));
		die;
	}
	
	function postcard($limit=5,$keyword='1V1',$offset=0,$msg='')
	{
		// if($this->session->userdata('user_type')!='bar_owner')
		// {
			// redirect('home');
		// }
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}

		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		if( $data['getbar']!='' && $data['getbar']['bar_type']=='half_mug')
		{
			redirect('home/registration_step3_upgrade/'.base64_encode(@$data['getbar']['bar_id']));
		}
		if($this->input->post('event_keyword')!='')
		{
			$keyword= $this->input->post('event_keyword');
			$limit= $this->input->post('limit');
			$offset= $this->input->post('offset');
		}
		else {
			$keyword = $keyword;
			$limit= $limit;
			$offset= $offset;
		}
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'bar/postcard/'.$limit.'/'.$keyword;
		$config["total_rows"] = $this->bar_model->getBarPostcardcount(@$data['getbar']['bar_id'],$keyword);
		
		//$config['total_rows'] = $this->service_provider_model->countStaff($id,$keyword);
		//echo $data["total_rows"];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->bar_model->getBarPostcardDetail(@$data['getbar']['bar_id'],$offset,$limit,$keyword);
		
	
		//	$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='postcard';
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/bar/bar_postcard_ajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/bar/bar_postcard', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
	}

	

    function barpostcarddelete()
	{
		$datadelete = array('is_delete'=>'1');
		$this->db->where("postcard_id",$this->input->post('id'));
		$this->db->update('bar_post_card',$datadelete);	
	}
	
	function actionpostcard()
	{
			$event_id =$this->input->post('chk');
			foreach($event_id as $id)
			{			
				$datadelete = array('is_delete'=>'1');
				$this->db->where("postcard_id",$id);
				$this->db->update('bar_post_card',$datadelete);
			}
		$res=array('status'=>'done');
		echo json_encode($res);die;
			
	}
	
	function comments($limit=5,$keyword='1V1',$offset=0,$msg='')
	{
		if($this->session->userdata('user_type')!='bar_owner')
		{
			redirect('home');
		}
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}

		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		if($data['getbar']['bar_type']=='half_mug')
		{
			redirect('home/registration_step3_upgrade/'.base64_encode(@$data['getbar']['bar_id']));
		}
		if($this->input->post('event_keyword')!='')
		{
			$keyword= $this->input->post('event_keyword');
			$limit= $this->input->post('limit');
			$offset= $this->input->post('offset');
		}
		else {
			$keyword = $keyword;
			$limit= $limit;
			$offset= $offset;
		}
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'bar/comments/'.$limit.'/'.$keyword;
		$config["total_rows"] = $this->bar_model->getBarCommentscount(@$data['getbar']['bar_id'],$keyword);
		
		//$config['total_rows'] = $this->service_provider_model->countStaff($id,$keyword);
		//echo $data["total_rows"];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->bar_model->getBarCommentDetail(@$data['getbar']['bar_id'],$offset,$limit,$keyword);
		
	
	
		//	$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='comments';
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/bar/bar_comments_ajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/bar/bar_comments', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
	}

     function barcommentdelete()
	{
		$datadelete = array('is_deleted'=>'yes');
		$this->db->where("bar_comment_id",$this->input->post('id'));
		$this->db->update('bar_comment',$datadelete);	
	}
	
	function actioncomment()
	{
			$event_id =$this->input->post('chk');
			foreach($event_id as $id)
			{			
				$datadelete = array('is_deleted'=>'yes');
				$this->db->where("bar_comment_id",$id);
				$this->db->update('bar_comment',$datadelete);
			}
		$res=array('status'=>'done');
		echo json_encode($res);die;
			
	}

    function list_message($limit=10,$keyword='1V1',$offset=0,$msg='')
	{
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}

		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		// if($data['getbar']!="" && $data['getbar']['bar_type']=='half_mug')
		// {
			// redirect('home/upgrade');
		// }
		if($this->input->post('event_keyword')!='')
		{
			$keyword= $this->input->post('event_keyword');
			$limit= $this->input->post('limit');
			$offset= $this->input->post('offset');
		}
		else {
			$keyword = $keyword;
			$limit= $limit;
			$offset= $offset;
		}
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'bar/list_message/'.$limit.'/'.$keyword;
		$config["total_rows"] = $this->bar_model->getBarMessagescount();
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->bar_model->get_message_result($offset,$limit);
		
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='list_message';
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/bar/bar_message_ajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/bar/bar_message', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
	}

    function viewconversation($message_id='',$msg='')
	{
	  
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		

		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		 $message_id = base64_decode($message_id);
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		
	 	$data_update = array("is_read"=>"1");
	    $this->db->where("master_message_id",$message_id);
		$this->db->where("to_user_id",get_authenticateUserID());
	    $this->db->update("message",$data_update);
		
			$data_update1 = array("is_read"=>"1");
	    $this->db->where("message_id",$message_id);
	    $this->db->update("message",$data_update1);
		//$one_message = $this->message_model->get_one_message($message_id);
		$one_message = $this->bar_model->get_one_message($message_id);
		
		$data["message_id"] = $message_id;
		$data["subject"] = $one_message['subject'];
		$data["description"] = $one_message['description'];
		$data["from_user_id"] = $one_message['from_user_id'];
		$data["from_user_type"] = $one_message['from_user_type'];
		$data["date_added"] = $one_message['date_added'];
		
    	$data["to_user_id"] = $one_message['to_user_id'];
		
		$data["to_user_type"] = $one_message['to_user_type'];
		$data["is_read"] = $one_message['is_read'];
		$data["master_message_id"] = $one_message['master_message_id'];
		$data["description"] = $one_message['description'];
		$data["is_deleted"] = $one_message['is_deleted'];
		
		$data['redirect_page']='list_message';
		
		$data['result'] = $this->bar_model->get_message_conversation($message_id);
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/bar/messageconversation', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
	}
	
	function getTicketCommentAjax()
	{
		//print_r($_POST);die;
		$replyBy=$this->input->post('replyBy');
		$ticket_id=$this->input->post('ticket_id');
		$ctime=$this->input->post('ctime');
		$user_id=$this->input->post('user_id');
		$theme = getThemeName();
		$userDetail=get_user_name($user_id);
		$pim=(isset($userDetail->profile_image) && $userDetail->profile_image!='' && file_exists(base_path().'upload/user/'.$userDetail->profile_image))?base_url().'upload/user/'.$userDetail->profile_image:base_url().'upload/user/no_image.png';
		
		$ntime=date('Y-m-d H:i:s');
		
		$sql="select * FROM ".$this->db->dbprefix('message')." WHERE `master_message_id` =  ".$ticket_id." and from_user_type='admin' and date_added between '".$ctime."' and '".$ntime."' order by date_added asc";
		
		
		$gd=$this->db->query($sql);
		
	  
		$data['userInfo']=$userDetail;
		$data['pim']=$pim;
		
		if($gd->num_rows()>0){
		$data['ticketConv']=$gd->result();
		$res=array('html'=> $this->load->view($theme .'/bar/ticketConversationAjax',$data,TRUE),'status'=>'success','ntime'=>$ntime);
		}else{
			$res=array('status'=>'fail','result'=>'','ntime'=>$ntime);
		}
		echo json_encode($res);die;
	}

    function postConversationReply()
	{
		$array=array('from_user_type'=>'user',
		'to_user_type'=>'ADB',
		'master_message_id'=>$this->input->post('ticket_id'),
		'from_user_id'=>get_authenticateUserID(),
		'description'=>$this->input->post('comment'),
		'to_user_id'=>$this->input->post('to_user_id'),
		'date_added'=>date('Y-m-d H:i:s'));
		$this->db->insert('message',$array);
		
		echo json_encode($array);die;
	}

	
    function getbarinfo()
    {
    	$getdata = get_user_info(get_authenticateUserID());
		print_r(json_encode($getdata)) ;
		die;
    }
    
     function getbarinfoByID()
    {
    	$getdata = $this->bar_model->get_one_bar($this->input->post('id'));
		print_r(json_encode($getdata)) ;
		die;
    }
    function editinfo()
	{
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email','Email','required|callback_email_check_baruser');
		$this->form_validation->set_rules('bar_title', 'Bar Title', 'required|callback_bartitle_check');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');
		$this->form_validation->set_rules('zip', 'Zip Code', 'required|numeric');
		//$this->form_validation->set_rules('desc', 'Description', 'required');
		//$this->form_validation->set_rules('bar_meta_title', 'Meta Title', 'required');
		//$this->form_validation->set_rules('bar_meta_keyword', 'Meta Keyword', 'required');
		//$this->form_validation->set_rules('bar_meta_description', 'Meta Description', 'required');
		$data["error"] = '';
		$data["msg"] = '';
		
		
		if($this->form_validation->run() == FALSE)
		{			
				if(validation_errors())
				{
					$data["error"] = validation_errors();
				}else{
					$data["error"] = "";
				}
				$data["email"] = $this->input->post('email');
				$data["bar_title"] = $this->input->post('bar_title');
				$data["first_name"] = $this->input->post('first_name');
				$data["last_name"] = $this->input->post('last_name');
				$data["address"] = $this->input->post('address');
				$data["city"] = $this->input->post('city');
				$data["phone"] = $this->input->post('phone');
				$data["state"] = $this->input->post('state');
				$data["zip"] = $this->input->post('zip');
				$data["bar_video_link"] = $this->input->post('bar_video_link');
				$data["desc"] = $this->input->post('desc');
				$data["serve_as"] = $this->input->post('serve_as');
				$data["bar_category"] = $this->input->post('bar_category');
				$data["bar_meta_description"] = $this->input->post('bar_meta_description');
				$data["bar_meta_keyword"] = $this->input->post('bar_meta_keyword');
				$data["bar_meta_title"] = $this->input->post('bar_meta_title');
				
				$data["cash_p"] = $this->input->post('cash_p');
				$data["master_p"] = $this->input->post('master_p');
				$data["american_p"] = $this->input->post('american_p');
				$data["visa_p"] = $this->input->post('visa_p');
				$data["paypal_p"] = $this->input->post('paypal_p');
				$data["bitcoin_p"] = $this->input->post('bitcoin_p');
				$data["apple_p"] = $this->input->post('apple_p');
                                
                                $data['facebook_link'] = $this->input->post('facebook_link');
                                $data['twitter_link'] = $this->input->post('twitter_link');
                                $data['instagram_link'] = $this->input->post('instagram_link');
                }
		else {
			    $this->bar_model->bar_update();			
				$data["msg"] = "success";	
		}
		
		if($data["error"] !="")
		{
			$response = array("comment_error"=>$data["error"],"status"=>"fail");
			echo json_encode($response);
		    die;
		}
		
		if($data["msg"] == "success")
		{
			$response = array("status"=>"success");
			echo json_encode($response);
		    die;
		}
	}

    function getbardata()
    {
    	$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
    	$data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		echo $this->load->view($theme .'/home/dashboardajax',$data,TRUE);
		die;
    }
	
	function email_check($email){
		$email = $this->home_model->email_unique($email);
		if($email == FALSE){
			$this->form_validation->set_message('email_check','There is an existing record with this Email Address');
			return FALSE;
		}
		return TRUE;
	}
	function email_check_baruser($email){
		
		$email = $this->home_model->email_unique($email,'bar_owner');
		
		if($email == FALSE){
			$this->form_validation->set_message('email_check_baruser','There is an existing record with this Email Address');
			return FALSE;
		}
		return TRUE;
	}
	function bartitle_check($title)
	{
		$username = $this->bar_model->bar_title_unique($title);
		if($username == FALSE)
		{
			$this->form_validation->set_message('bartitle_check', 'There is an existing Bar associated with this Title');
			return FALSE;
		}
		return TRUE;
	}
	
	function bartitle_check_suggest($title)
	{
		$username = $this->bar_model->bar_title_unique_suggest($title);
		if($username == FALSE)
		{
			$this->form_validation->set_message('bartitle_check_suggest', 'There is an existing Bar associated with this Title');
			return FALSE;
		}
		return TRUE;
	}
	
	function getmorebeer()
	{
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
    	$data["bar_beer"] = $this->bar_model->getBarBeerNew($_GET['bar_id'],$_GET['offset'],$_GET['limit']);
		if($data["bar_beer"])
		{
		echo $this->load->view($theme .'/bar/barbeerajaxscroll',$data,TRUE);
		}
		elseif($_GET['offset']==0) {
			echo "No";
		}
		die;
	}
	
	function getmorecocktail()
	{
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
    	$data["bar_cocktail"] = $this->bar_model->getBarCocktailNew($_GET['bar_id'],$_GET['offset'],$_GET['limit']);
		if($data["bar_cocktail"])
		{
		echo $this->load->view($theme .'/bar/barcocktailajaxscroll',$data,TRUE);
		}
		elseif($_GET['offset']==0) {
			echo "No";
		}
		die;
	}

	function getmoreliquor()
	{
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
    	$data["bar_cocktail"] = $this->bar_model->getBarLiquorNew($_GET['bar_id'],$_GET['offset'],$_GET['limit']);
		if($data["bar_cocktail"])
		{
		echo $this->load->view($theme .'/bar/barliquorajaxscroll',$data,TRUE);
		}
		elseif($_GET['offset']==0) {
			echo "No";
		}
		die;
	}

    function gallery($id='',$msg='')
	{
	    $data = array();
		$data['msg'] = $msg;
		$data['id'] = $id;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        
		$data["bar_event"] = $this->bar_model->getBarEventGallery();
		$data["gallery"] = $this->bar_model->getGallery();
		$data["barpostcard"] = $this->bar_model->getBarPostcards();
		
		$this->load->helper('recaptchalib');
		$publickey = '6Lf0JfQSAAAAAOX2iWkSoOl3THquEUEq-WARD1-k';
		$privatekey = '6Lf0JfQSAAAAAJGqvUMuNOdo8Y_4cIegn41T_myW';
		# the response from reCAPTCHA
		$resp = null;
		# the error code from reCAPTCHA, if any
		$error = null;
		$captcha_error='';
		
					
			
        if(get_authenticateUserID() > 0)
        {
		  $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        }
        else
        {
            $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        }
		$this->template->write_view ('content_center', $theme.'/home/gallery', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();
	}

	function removemessage()
	{
			
		$this->db->where('message_id',$this->input->post('id'))->delete('message');
		$this->db->where('master_message_id',$this->input->post('id'))->delete('message');
		$res=array('status'=>'done');
		echo json_encode($res);die;
			
	}
	
	function suggest_bar($msg='')
	{
		
		if(isset($_SERVER['HTTP_REFERER']))
		{
    	$data['url'] = $_SERVER['HTTP_REFERER']; // parse the url
		}
		else {
			$data['url'] = '';
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
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        
		$data["bar_event"] = $this->bar_model->getBarEventGallery();
		$data["barpostcard"] = $this->bar_model->getBarPostcards();
		
		
		$this->load->helper('recaptchalib');
		
		$publickey = '6LcjQAoTAAAAAMeqHoabD3bRBJuuQciyIbnaZFkU';
		$privatekey = '6LcjQAoTAAAAAM1AR1k-_AtX0DVZ5r0II1GgUzPL';
		# the response from reCAPTCHA
		$resp = null;
		# the error code from reCAPTCHA, if any
		$error = null;
		$captcha_error='';
        $captcha = '';
		# was there a reCAPTCHA response?
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('bar_name', 'Bar Name', 'required|callback_bartitle_check_suggest');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('phone_number', 'Phone Number', 'required');
		$this->form_validation->set_rules('zip_code', 'Zip Code', 'required');
        $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'required');
        // Load the library
       // $this->load->library('recaptcha');
       // echo "fdsaf";
		//die;
        // Catch the user's answer
        $captcha_answer = $this->input->post('g-recaptcha-response');
        
        // Verify user's answer
       // $resp = $this->recaptcha->verifyResponse($captcha_answer);
        
        // Processing ...
        // if ($resp['success']) {
            // // Your success code here
        // } else {
            // // Something goes wrong
            // $cerror = $resp;
		    // $captcha_error='<span> Please enter valid captcha code. </span>';
        // }
        
		if($this->form_validation->run() == FALSE)
			{			
				if(validation_errors())
				{
					$data["error"] = validation_errors();
				}else{
					$data["error"] = "";
				}
				
				$data["bar_name"] = $this->input->post('bar_name');
				$data["address"] = $this->input->post('address');
				$data["state"] = $this->input->post('state');
				$data["url"] = $this->input->post('url');
				$data["city"] = $this->input->post('city');
				$data["phone_number"] = $this->input->post('phone_number');
				$data["zip_code"] = $this->input->post('zip_code');
				
			}
		else
			{
				$this->bar_model->insert_suggest_bar();
				$this->session->set_flashdata('msg','success');
				$msg = 'success';
				
				$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Suggest Dive Bar'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = getsuperadminemail();
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{bar_name}', $this->input->post('bar_name'), $email_message);
				$email_message = str_replace('{address}', $this->input->post('address'), $email_message);
				$email_message = str_replace('{state}', $this->input->post('state'), $email_message);
				$email_message = str_replace('{city}', $this->input->post('city'), $email_message);
				$email_message = str_replace('{zip_code}', $this->input->post('zip_code'), $email_message);
				$email_message = str_replace('{phone_number}', $this->input->post('phone_number'), $email_message);
				$str = $email_message;
				
				$getemail = explode(',', $email);
				if($email_temp->status=='active'){
				foreach($getemail as $r){
					email_send($email_address_from, $email_address_reply, $r, $email_subject, $str);
				}
				}
				
				redirect('bar/suggest_bar/'.$msg);
			}		
        if(get_authenticateUserID() > 0)
        {
		  $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        }
        else
        {
            $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        }
		$this->template->write_view ('content_center', $theme.'/bar/suggestbar', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();
	}

   

    function dictionary($limit=20,$alpha = 'no',$options='',$offset=0,$msg='')
	{
	    $data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		
		if($_POST)
		{			
		    $keyword = $this->input->post("keyword"); 			
			$order = explode("#",'dictionary_id');
			 
				if(isset($order[0]) && isset($order[1]))
				{
					 $sort_by = $order[0];
				     $sort_type = $order[1];	
				}
				else
				{
				     $sort_by = "dictionary_title";
				     $sort_type = "ASC";		
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
				}
				else
			    {
					 $sort_by = "dictionary_title";
					 $sort_type = "ASC";	
					 //$type = "0";
					 $keyword = '0';
				}			 
		}
		$options = base64_encode($sort_by."@".$sort_type."@".$keyword);
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $data['getbar'] = $this->bar_model->getdictionarycount();
		$config['uri_segment']='6';
		$config['base_url'] = base_url().'bar/dictionary/'.$limit.'/'.$alpha."/".$options.'/';
		$config["total_rows"] = $this->bar_model->getdictionarycount($alpha);
		
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->bar_model->getndictionaryresult($offset,$limit,$alpha);
		$data['latest_mews'] = $this->bar_model->latestdictionary(2);
		
		$data["alpha"] = $alpha;
		//	$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='dictionary';
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/bar/dictionaryajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/bar/dictionary', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
	}

 	function send_new_message($bar_id='')
	{
		// if($this->session->userdata('user_type')!='bar_owner')
		// {
			// redirect('home');
		// }
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$data["error"] = '';
		$data["msg"] = '';
		
		$bar_detail = $this->bar_model->get_one_bar(base64_decode($bar_id));
		
		if($this->form_validation->run() == FALSE)
		{			
				if(validation_errors())
				{
					$data["error"] = validation_errors();
				}else{
					$data["error"] = "";
				}
				$data["subject"] = $this->input->post('subject');
				$data["description"] = $this->input->post('description');
		}
		else {
			    $this->bar_model->message_send(base64_decode($bar_id));			
				$data["msg"] = "success";	
		}
		
		if($data["error"] !="")
		{
			$response = array("comment_error"=>$data["error"],"status"=>"fail");
			echo json_encode($response);
		    die;
		}
		
		if($data["msg"] == "success")
		{
			$response = array("status"=>"success");
			echo json_encode($response);
		    die;
		}
	}
	function beername_check($name)
	{
		$beername = $this->bar_model->beer_unique($name);
		if($beername == FALSE)
		{
			$this->form_validation->set_message('beername_check', 'There is an existing record with this Beer Name');
			return FALSE;
		}
		return TRUE;
	}
	function beersuggest()
	{
		$this->load->helper('recaptchalib');
		$publickey = '6Lf0JfQSAAAAAOX2iWkSoOl3THquEUEq-WARD1-k';
		$privatekey = '6Lf0JfQSAAAAAJGqvUMuNOdo8Y_4cIegn41T_myW';
		# the response from reCAPTCHA
		$resp = null;
		# the error code from reCAPTCHA, if any
		$error = null;
		$captcha_error='';
		# was there a reCAPTCHA response?
		$this->load->library('form_validation');
		$this->form_validation->set_rules('beer_name', 'Beer Name', 'required|callback_beername_check');
		$this->form_validation->set_rules('beer_country', 'Country', 'required');
		//$this->form_validation->set_rules('beer_desc', 'Description', 'required');
		//$this->form_validation->set_rules('beer_type', 'Beer Type', 'required');
		//$this->form_validation->set_rules('abv', 'ABV', 'required');
		//$this->form_validation->set_rules('producer', 'Producer', 'required');
		//$this->form_validation->set_rules('beer_state', 'State', 'required');
		//$this->form_validation->set_rules('beer_website', 'Website', 'required');
		// $this->form_validation->set_rules('beer_meta_title', 'Meta Title', 'required');
		// $this->form_validation->set_rules('beer_meta_keyword', 'Meta Keyword', 'required');
		// $this->form_validation->set_rules('beer_meta_description', 'Meta Description', 'required');
		$this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'required');
		if (isset($_POST["recaptcha_response_field"]) && $_POST["recaptcha_response_field"]) {
		        $resp = recaptcha_check_answer ($privatekey,
		                                        $_SERVER["REMOTE_ADDR"],
		                                        $_POST["recaptcha_challenge_field"],
		                                        $_POST["recaptcha_response_field"]);
		
		        if ($resp->is_valid) {
		               // echo "You got it!";
		        } else {
		                # set the error code so that we can display it
		                $cerror = $resp->error;
						$captcha_error='<span> Please enter valid captcha code. </span>';
		        }
				
				//echo $cerror;die;
		}
		$data['captcha_img']=recaptcha_get_html($publickey,$error);		
		$data["error"] = '';
		$data["msg"] = '';
		$data['site_setting'] = site_setting ();
		if($this->form_validation->run() == FALSE)
		{			
				if(validation_errors())
				{
					$data["error"] = validation_errors();
				}else{
					$data["error"] = "";
				}
				$data["beer_name"] = $this->input->post('beer_name');
				$data["beer_state"] = $this->input->post('beer_state');
				$data["beer_country"] = $this->input->post('beer_country');
				$data["beer_desc"] = $this->input->post('beer_desc');
				$data["beer_type"] = $this->input->post('beer_type');
				$data["abv"] = $this->input->post('abv');
				$data["producer"] = $this->input->post('producer');
				$data["beer_website"] = $this->input->post('beer_website');
				// $data["beer_meta_title"] = $this->input->post('beer_meta_title');
				// $data["beer_meta_keyword"] = $this->input->post('beer_meta_keyword');
				// $data["beer_meta_description"] = $this->input->post('beer_meta_description');
		}
		else {
			    $this->bar_model->suggestbeer_insert();			
				$data["msg"] = "success";	
		}
		
		if($data["error"] !="")
		{
			$response = array("comment_error"=>$data["error"],"status"=>"fail");
			echo json_encode($response);
		    die;
		}
		
		if($data["msg"] == "success")
		{
			$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Beer Suggest'");
			$email_temp = $email_template->row();
			$email_address_from = $email_temp->from_address;
			$email_address_reply = $email_temp->reply_address;
			$email_subject = $email_temp->subject;
			$email_message = $email_temp->message;
			$email = getsuperadminemail();
			$email_to = $email;
			$email_message = str_replace('{break}', '<br/>', $email_message);
			$email_message = str_replace('{beer_name}', $this->input->post('beer_name'), $email_message);
			$email_message = str_replace('{beer_desc}', $this->input->post('beer_desc'), $email_message);
			$email_message = str_replace('{beer_type}', $this->input->post('beer_type'), $email_message);
			$email_message = str_replace('{abv}', $this->input->post('abv'), $email_message);
			$email_message = str_replace('{producer}', $this->input->post('producer'), $email_message);
			$email_message = str_replace('{city_produced}', $this->input->post('city_produced'), $email_message);
			$email_message = str_replace('{website}', $this->input->post('beer_website'), $email_message);
			$str = $email_message;
			$getemail = explode(',', $email);
				if($email_temp->status=='active'){
				foreach($getemail as $r){
					email_send($email_address_from, $email_address_reply, $r, $email_subject, $str);
				}
				}
			//email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
			$response = array("status"=>"success");
			echo json_encode($response);
		    die;
		}
	}

	function suggest_bar_ajax($msg='')
	{
		if(isset($_SERVER['HTTP_REFERER']))
		{
    	$data['url'] = $_SERVER['HTTP_REFERER']; // parse the url
		}
		else {
			$data['url'] = '';
		}
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        
		
		$this->load->helper('recaptchalib');
		$publickey = '6Lf0JfQSAAAAAOX2iWkSoOl3THquEUEq-WARD1-k';
		$privatekey = '6Lf0JfQSAAAAAJGqvUMuNOdo8Y_4cIegn41T_myW';
		# the response from reCAPTCHA
		$resp = null;
		# the error code from reCAPTCHA, if any
		$error = null;
		$captcha_error='';
		# was there a reCAPTCHA response?
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('bar_name', 'Bar Name', 'required|callback_bartitle_check_suggest');
		$this->form_validation->set_rules('zip_code', 'Zip Code', 'required');
		$this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'required');
		
		if (isset($_POST["recaptcha_response_field"]) && $_POST["recaptcha_response_field"]) {
		        $resp = recaptcha_check_answer ($privatekey,
		                                        $_SERVER["REMOTE_ADDR"],
		                                        $_POST["recaptcha_challenge_field"],
		                                        $_POST["recaptcha_response_field"]);
		
		        if ($resp->is_valid) {
		               // echo "You got it!";
		        } else {
		                # set the error code so that we can display it
		                $cerror = $resp->error;
						$captcha_error='<span> Please enter valid captcha code. </span>';
		        }
				
				//echo $cerror;die;
		}
		$data['captcha_img']=recaptcha_get_html($publickey,$error);		 
		
		if($this->form_validation->run() == FALSE || $captcha_error!='')
			{			
				if(validation_errors() || $captcha_error!='')
				{
					$data["error"] = validation_errors().$captcha_error;
				}else{
					$data["error"] = "";
				}
				
				$data["bar_name"] = $this->input->post('bar_name');
				$data["address"] = $this->input->post('address');
				$data["state"] = $this->input->post('state');
				$data["url"] = $this->input->post('url');
				$data["city"] = $this->input->post('city');
				$data["phone_number"] = $this->input->post('phone_number');
				$data["zip_code"] = $this->input->post('zip_code');
				
			}
		else
			{
				$this->bar_model->insert_suggest_bar();
					$data["msg"] = "success";	
				
				
				
			}		

		if($data["error"] !="")
		{
			$response = array("comment_error"=>$data["error"],"status"=>"fail");
			echo json_encode($response);
		    die;
		}
		
		if($data["msg"] == "success")
		{
			$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Suggest Dive Bar'");
				$email_temp = $email_template->row();
				$email_address_from = $email_temp->from_address;
				$email_address_reply = $email_temp->reply_address;
				$email_subject = $email_temp->subject;
				$email_message = $email_temp->message;
				$email = $data['site_setting']->site_email;
				$email_to = $email;
				$email_message = str_replace('{break}', '<br/>', $email_message);
				$email_message = str_replace('{bar_name}', $this->input->post('bar_name'), $email_message);
				$email_message = str_replace('{address}', $this->input->post('address'), $email_message);
				$email_message = str_replace('{state}', $this->input->post('state'), $email_message);
				$email_message = str_replace('{city}', $this->input->post('city'), $email_message);
				$email_message = str_replace('{zip_code}', $this->input->post('zip_code'), $email_message);
				$email_message = str_replace('{phone_number}', $this->input->post('phone_number'), $email_message);
				$str = $email_message;
				if($email_temp->status=='active'){
				email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
				}
				
			$response = array("status"=>"success");
			echo json_encode($response);
		    die;
		}	
	}
     
	function cocktailname_check($name)
	{
		$cocktailname = $this->bar_model->cocktail_unique($name);
		if($cocktailname == FALSE)
		{
			$this->form_validation->set_message('cocktailname_check', 'There is an existing record with this Cocktail Name');
			return FALSE;
		}
		return TRUE;
	}
	
	function liquorname_check($name)
	{
		$cocktailname = $this->bar_model->liquor_unique($name);
		if($cocktailname == FALSE)
		{
			$this->form_validation->set_message('liquorname_check', 'There is an existing record with this liquor Name');
			return FALSE;
		}
		return TRUE;
	}
	 
	function cocktailsuggest()
	{
		$this->load->helper('recaptchalib');
		$publickey = '6Lf0JfQSAAAAAOX2iWkSoOl3THquEUEq-WARD1-k';
		$privatekey = '6Lf0JfQSAAAAAJGqvUMuNOdo8Y_4cIegn41T_myW';
		# the response from reCAPTCHA
		$resp = null;
		# the error code from reCAPTCHA, if any
		$error = null;
		$captcha_error='';
		# was there a reCAPTCHA response?
		$this->load->library('form_validation');
		$this->form_validation->set_rules('cocktail_name', 'Cocktail Name', 'required|callback_cocktailname_check');
		//$this->form_validation->set_rules('ingredients', 'Ingredients', 'required');
		//$this->form_validation->set_rules('how_to_make_it', 'How To Make It', 'required');
		//$this->form_validation->set_rules('base_spirit', 'Base Spirit', 'required');
		//$this->form_validation->set_rules('type', 'Type', 'required');
		//$this->form_validation->set_rules('served', 'Served', 'required');
		//$this->form_validation->set_rules('preparation', 'Preparation', 'required');
		//$this->form_validation->set_rules('strength', 'Strength', 'required');
		//$this->form_validation->set_rules('difficulty', 'Difficulty', 'required');
		//$this->form_validation->set_rules('flavor_profile', 'Flavor Profile', 'required');
		// $this->form_validation->set_rules('cocktail_meta_title', 'Meta Title', 'required');
		// $this->form_validation->set_rules('cocktail_meta_keyword', 'Meta Keyword', 'required');
		// $this->form_validation->set_rules('cocktail_meta_description', 'Meta Description', 'required');
		$this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'required');
		
		if (isset($_POST["recaptcha_response_field"]) && $_POST["recaptcha_response_field"]) {
		        $resp = recaptcha_check_answer ($privatekey,
		                                        $_SERVER["REMOTE_ADDR"],
		                                        $_POST["recaptcha_challenge_field"],
		                                        $_POST["recaptcha_response_field"]);
		
		        if ($resp->is_valid) {
		               // echo "You got it!";
		        } else {
		                # set the error code so that we can display it
		                $cerror = $resp->error;
						$captcha_error='<span> Please enter valid captcha code. </span>';
		        }
				
				//echo $cerror;die;
		}
		$data['captcha_img']=recaptcha_get_html($publickey,$error);		
		
		$data["error"] = '';
		$data["msg"] = '';
		$data['site_setting'] = site_setting ();
		if($this->form_validation->run() == FALSE)
		{			
				if(validation_errors())
				{
					$data["error"] = validation_errors();
				}else{
					$data["error"] = "";
				}
				$data["cocktail_name"] = $this->input->post('cocktail_name');
				$data["ingredients"] = $this->input->post('ingredients');
				$data["how_to_make_it"] = $this->input->post('how_to_make_it');
				$data["base_spirit"] = $this->input->post('base_spirit');
				$data["type"] = $this->input->post('type');
				$data["served"] = $this->input->post('served');
				$data["preparation"] = $this->input->post('preparation');
				$data["strength"] = $this->input->post('strength');
				$data["difficulty"] = $this->input->post('difficulty');
				$data["flavor_profile"] = $this->input->post('flavor_profile');
				// $data["cocktail_meta_title"] = $this->input->post('cocktail_meta_title');
				// $data["cocktail_meta_keyword"] = $this->input->post('cocktail_meta_keyword');
				// $data["cocktail_meta_description"] = $this->input->post('cocktail_meta_description');
		}
		else {
			    $this->bar_model->suggestcocktail_insert();			
				$data["msg"] = "success";	
		}
		
		if($data["error"] !="")
		{
			$response = array("comment_error"=>$data["error"],"status"=>"fail");
			echo json_encode($response);
		    die;
		}
		
		if($data["msg"] == "success")
		{
			$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Cocktail Suggest'");
			$email_temp = $email_template->row();
			$email_address_from = $email_temp->from_address;
			$email_address_reply = $email_temp->reply_address;
			$email_subject = $email_temp->subject;
			$email_message = $email_temp->message;
			$email = getsuperadminemail();
			$email_to = $email;
			$email_message = str_replace('{break}', '<br/>', $email_message);
			$email_message = str_replace('{cocktail_name}', $this->input->post('cocktail_name'), $email_message);
			$email_message = str_replace('{ingredients}', $this->input->post('ingredients'), $email_message);
			$email_message = str_replace('{how_to_make_it}', $this->input->post('how_to_make_it'), $email_message);
			$email_message = str_replace('{base_spirit}', $this->input->post('base_spirit'), $email_message);
			$email_message = str_replace('{type}', $this->input->post('type'), $email_message);
			$email_message = str_replace('{served}', $this->input->post('served'), $email_message);
			$email_message = str_replace('{preparation}', $this->input->post('preparation'), $email_message);
			$email_message = str_replace('{strength}', $this->input->post('strength'), $email_message);
			$email_message = str_replace('{difficulty}', $this->input->post('difficulty'), $email_message);
			$email_message = str_replace('{flavor_profile}', $this->input->post('flavor_profile'), $email_message);
			$str = $email_message;
			//email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
			$getemail = explode(',', $email);
				if($email_temp->status=='active'){
				foreach($getemail as $r){
					email_send($email_address_from, $email_address_reply, $r, $email_subject, $str);
				}
				}
			$response = array("status"=>"success");
			echo json_encode($response);
		    die;
		}
	}

	function liquorsuggest()
	{
		$this->load->helper('recaptchalib');
		$publickey = '6Lf0JfQSAAAAAOX2iWkSoOl3THquEUEq-WARD1-k';
		$privatekey = '6Lf0JfQSAAAAAJGqvUMuNOdo8Y_4cIegn41T_myW';
		# the response from reCAPTCHA
		$resp = null;
		# the error code from reCAPTCHA, if any
		$error = null;
		$captcha_error='';
		# was there a reCAPTCHA response?
		$this->load->library('form_validation');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('liquor_title', 'Liquor Name', 'required|callback_liquorname_check');
		//$this->form_validation->set_rules('type', 'Type', 'required');
		//$this->form_validation->set_rules('proof', 'Proof', 'required');
		//$this->form_validation->set_rules('producer', 'Producer', 'required');
		//$this->form_validation->set_rules('country', 'Country', 'required');
		$this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'required');
		
		if (isset($_POST["recaptcha_response_field"]) && $_POST["recaptcha_response_field"]) {
		        $resp = recaptcha_check_answer ($privatekey,
		                                        $_SERVER["REMOTE_ADDR"],
		                                        $_POST["recaptcha_challenge_field"],
		                                        $_POST["recaptcha_response_field"]);
		
		        if ($resp->is_valid) {
		               // echo "You got it!";
		        } else {
		                # set the error code so that we can display it
		                $cerror = $resp->error;
						$captcha_error='<span> Please enter valid captcha code. </span>';
		        }
				
				//echo $cerror;die;
		}
		$data['captcha_img']=recaptcha_get_html($publickey,$error);	
		$data["error"] = '';
		$data["msg"] = '';
		$data['site_setting'] = site_setting ();
		if($this->form_validation->run() == FALSE)
		{			
				if(validation_errors())
				{
					$data["error"] = validation_errors();
				}else{
					$data["error"] = "";
				}
				$data["liquor_title"] = $this->input->post('liquor_title');
				$data["type"] = $this->input->post('type');
				$data["proof"] = $this->input->post('proof');
				$data["producer"] = $this->input->post('producer');
				$data["country"] = $this->input->post('country');
		}
		else {
			    $this->bar_model->suggestliquor_insert();			
				$data["msg"] = "success";	
		}
		
		if($data["error"] !="")
		{
			$response = array("comment_error"=>$data["error"],"status"=>"fail");
			echo json_encode($response);
		    die;
		}
		
		if($data["msg"] == "success")
		{
			$email_template = $this->db->query("select * from " . $this->db->dbprefix('email_template') . " where task='Liquor Suggest'");
			$email_temp = $email_template->row();
			$email_address_from = $email_temp->from_address;
			$email_address_reply = $email_temp->reply_address;
			$email_subject = $email_temp->subject;
			$email_message = $email_temp->message;
			$email = getsuperadminemail();
			$email_to = $email;
			$email_message = str_replace('{break}', '<br/>', $email_message);
			$email_message = str_replace('{liquor_title}', $this->input->post('liquor_title'), $email_message);
			$email_message = str_replace('{type}', $this->input->post('type'), $email_message);
			$email_message = str_replace('{proof}', $this->input->post('proof'), $email_message);
			$email_message = str_replace('{producer}', $this->input->post('producer'), $email_message);
			$email_message = str_replace('{country}', $this->input->post('country'), $email_message);
			$str = $email_message;
			$getemail = explode(',', $email);
				if($email_temp->status=='active'){				foreach($getemail as $r){
					email_send($email_address_from, $email_address_reply, $r, $email_subject, $str);
				}
				}
			//email_send($email_address_from, $email_address_reply, $email_to, $email_subject, $str);
			$response = array("status"=>"success");
			echo json_encode($response);
		    die;
		}
	}

	function ChaneState()
	{
		$acc_id = $_REQUEST['id'];
		$value = $_REQUEST['val'];
		$tapval = $_REQUEST['tapval'];
		
		if($tapval=='no')
		{
			$value='yes';
		}
		else {
			$value = 'no';
		}
		$data = array('tap'=>$value);
		$this->db->where('beer_bar_id',$acc_id);
		$this->db->update('beer_bars',$data);
		
		echo $this->db->last_query();
		die;
		die;
	}
	
	function ChaneState1()
	{
		$acc_id = $_REQUEST['id'];
		$value = $_REQUEST['val'];
		$tapval = $_REQUEST['tapval'];
		if($tapval=='no')
		{
			$value='yes';
		}
		else {
			$value = 'no';
		}
		$data = array('bottle'=>$value);
		$this->db->where('beer_bar_id',$acc_id);
		$this->db->update('beer_bars',$data);
		die;
	}
	
	
	function bar_fav($bid = 0){
		
		// if(!get_authenticateUserID())
			// {
				// $this->session->set_userdata("REDIRECT_PAGE","beer/beer_detail/".base64_encode($bid));
				// redirect("home/login");
			// }
			
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}	
		$data = $_POST;
		$data["date_added"] = date("Y-m-d H:i:s");
		if($_POST['fav_flag']==2){
			$checkbeerentry = checkBarEntryAlready($_POST['bar_id'],$_POST['user_id']);
			
			if($checkbeerentry==0)
			{
			$data['bar_fav_flag']=1;
			$this->db->insert("all_likes",$data);
			echo $cnt_like = fav_checker_bar($_POST['bar_id'],$_POST['user_id']);			
			$data['user_id'] = $this->beer_model->one_beer_likers($_POST['user_id']);
			if($data['user_id']!=""){
				$profile = $data['user_id']->profile_image;
				echo '*<li id="user_'.$_POST['user_id'].'" class="active"><a href="#"><img src="'.base_url().'upload/user_thumb/'.$profile.'" class="user_img"/>';
			}
			else{
				echo '*<li id="user_'.$_POST['user_id'].'" class="active"><a href="#"><img src="'.base_url().'upload/user_thumb/no_img.png" class="user_img"/>';
			}
			}
else{
	$data['bar_fav_flag']=1;
			$this->db->where("bar_id",$_POST['bar_id']);
			$this->db->where("user_id",get_authenticateUserID());
			$this->db->update("all_likes",$data);
			echo $cnt_like = fav_checker_bar($_POST['bar_id'],$_POST['user_id']);			
			$data['user_id'] = $this->beer_model->one_beer_likers($_POST['user_id']);
			if($data['user_id']!=""){
				$profile = $data['user_id']->profile_image;
				echo '*<li id="user_'.$_POST['user_id'].'" class="active"><a href="#"><img src="'.base_url().'upload/user_thumb/'.$profile.'" class="user_img"/>';
			}
			else{
				echo '*<li id="user_'.$_POST['user_id'].'" class="active"><a href="#"><img src="'.base_url().'upload/user_thumb/no_img.png" class="user_img"/>';
			}
}
		}
		else{			
			$data_update = array("bar_fav_flag"=>$_POST['fav_flag']);
			$this->db->where("bar_id",$_POST['bar_id']);
			$this->db->where("user_id",get_authenticateUserID());
			$this->db->update("all_likes",$data_update);
			echo $cnt_like = fav_checker_bar($_POST['bar_id'],get_authenticateUserID());
			
			if($cnt_like ==0){
				echo '*user_'.get_authenticateUserID();
			}
			else{
				$data['user_id'] = $this->beer_model->one_beer_likers(get_authenticateUserID());
				if($data['user_id']!=""){
				$profile = $data['user_id']->profile_image;
					if($profile!="" && is_file(base_path().'upload/user_thumb/'.$profile)){
						echo '*<li id="user_'.get_authenticateUserID().'" class="active"><a href="#"><img src="'.base_url().'upload/user_thumb/'.$profile.'" class="user_img"/>';
					}
					else{
						echo '*<li id="user_'.get_authenticateUserID().'" class="active"><a href="#"><img src="'.base_url().'upload/user_thumb/no_img.png" class="user_img"/>';
					}
				}
			}
		}	  	
	}

function deletefavbar()
	{
			$data_update = array("bar_fav_flag"=>0);
			$this->db->where("bar_id",$_POST['id']);
			$this->db->where("user_id",get_authenticateUserID());
			$this->db->update("all_likes",$data_update);
	}
	
	function actioncocktailfav()
	{
		$bar_id =$this->input->post('chk');
			foreach($bar_id as $id)
			{			
				$data_update = array("bar_fav_flag"=>0);
				$this->db->where("bar_id",$id);
				$this->db->where("user_id",get_authenticateUserID());
				$this->db->update("all_likes",$data_update);
			}
		$res=array('status'=>'done');
		echo json_encode($res);die;
	}
	
	
	function bar_likes($bid = 0){
		
			
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}	
		$data = $_POST;
		$data["date_added"] = date("Y-m-d H:i:s");
		if($_POST['like_flag']==2){
			$checkbeerentry = checkBarEntryAlready($_POST['bar_id'],$_POST['user_id']);
			
			if($checkbeerentry==0)
			{
			$data['like_flag']=1;
			$this->db->insert("all_likes",$data);
			echo $cnt_like = like_checker_bar($_POST['bar_id'],$_POST['user_id']);			
			$data['user_id'] = $this->beer_model->one_beer_likers($_POST['user_id']);
			if($data['user_id']!=""){
				$profile = $data['user_id']->profile_image;
				echo '*<li id="user_'.$_POST['user_id'].'" class="active"><a href="'.site_url('user/profile/'.base64_encode(get_authenticateUserID())).'"><img src="'.base_url().'upload/user_thumb/'.$profile.'" class="user_img"/>';
			}
			else{
				echo '*<li id="user_'.$_POST['user_id'].'" class="active"><a href="'.site_url('user/profile/'.base64_encode(get_authenticateUserID())).'"><img src="'.base_url().'upload/user_thumb/no_img.png" class="user_img"/>';
			}
			}
			else{
				$data['like_flag']=1;
			$this->db->where("bar_id",$_POST['bar_id']);
			$this->db->where("user_id",get_authenticateUserID());
			$this->db->update("all_likes",$data);
			echo $cnt_like = like_checker_bar($_POST['bar_id'],$_POST['user_id']);			
			$data['user_id'] = $this->beer_model->one_beer_likers($_POST['user_id']);
			if($data['user_id']!=""){
				$profile = $data['user_id']->profile_image;
				echo '*<li id="user_'.$_POST['user_id'].'" class="active"><a href="'.site_url('user/profile/'.base64_encode(get_authenticateUserID())).'"><img src="'.base_url().'upload/user_thumb/'.$profile.'" class="user_img"/>';
			}
			else{
				echo '*<li id="user_'.$_POST['user_id'].'" class="active"><a href="'.site_url('user/profile/'.base64_encode(get_authenticateUserID())).'"><img src="'.base_url().'upload/user_thumb/no_img.png" class="user_img"/>';
			}
			}
		}
		else{			
			$data_update = array("like_flag"=>$_POST['like_flag']);
			$this->db->where("bar_id",$_POST['bar_id']);
			$this->db->where("user_id",get_authenticateUserID());
			$this->db->update("all_likes",$data_update);
			echo $cnt_like = like_checker_bar($_POST['bar_id'],get_authenticateUserID());
			
			if($cnt_like ==0){
				echo '*user_'.get_authenticateUserID();
			}
			else{
				$data['user_id'] = $this->beer_model->one_beer_likers(get_authenticateUserID());
				if($data['user_id']!=""){
				$profile = $data['user_id']->profile_image;
					if($profile!="" && is_file(base_path().'upload/user_thumb/'.$profile)){
						echo '*<li id="user_'.get_authenticateUserID().'" class="active"><a href="'.site_url('user/profile/'.base64_encode(get_authenticateUserID())).'"><img src="'.base_url().'upload/user_thumb/'.$profile.'" class="user_img"/>';
					}
					else{
						echo '*<li id="user_'.get_authenticateUserID().'" class="active"><a href="'.site_url('user/profile/'.base64_encode(get_authenticateUserID())).'"><img src="'.base_url().'upload/user_thumb/no_img.png" class="user_img"/>';
					}
				}
			}
		}	  	
	}

	function view_all_likers()
	{
		$html = '';
		$bar_liker = $this->bar_model->get_all_bar_likers($this->input->post('id'));
		$html .= "<div class='padtb10'><div class='container'><div class='result_box clearfix mar_top30bot20'><div class='login_block br_green_yellow'><div class='result_search'><button aria-hidden='true' data-dismiss='modal' class='close' type='button'>×</button>
	     				<i class='strip login_icon'></i><div class='result_search_text'>Bar Likers</div></div><div class='pad20'><div id='ajax_msg_error_reg'></div><ul class='likeduser marl_0'>";	
		
		if($bar_liker){
			
	    foreach($bar_liker as $r)
		{
			$profile = $r->profile_image;
			if($profile!="" && is_file(base_path().'upload/user_thumb/'.$profile))
			{
			  $html .=  '<li id="user_'.$r->user_id.'" class="active"><a target="_blank" href="'.site_url('user/profile/'.base64_encode($r->user_id)).'"><img src="'.base_url().'upload/user_thumb/'.$r->profile_image.'" class="user_img"/>';
			}
			else 
			{
			  $html .= '<li id="user_'.$r->user_id.'" class="active"><a target="_blank" href="'.site_url('user/profile/'.base64_encode($r->user_id)).'"><img src="'.base_url().'upload/user_thumb/no_img.png" class="user_img"/>';
			}
		}
        }
	else {
		$html .= "<span class='result_search_text'>No any bar likers found .</span>";
	}
        
		$html .= "</ul><div class='clear'></div></div></div></div></div></div>";
		print_r($html);
		die;
	}
	
	function barlikers($limit=5,$keyword='1V1',$offset=0,$msg='')
	{
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}

		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		if($this->input->post('event_keyword')!='')
		{
			$keyword= $this->input->post('event_keyword');
			$limit= $this->input->post('limit');
			$offset= $this->input->post('offset');
		}
		else {
			$keyword = $keyword;
			$limit= $limit;
			$offset= $offset;
		}
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'bar/barlikers/'.$limit.'/'.$keyword;
		$config["total_rows"] = $this->bar_model->getBarLikersCount($keyword);
		
		//$config['total_rows'] = $this->service_provider_model->countStaff($id,$keyword);
		//echo $data["total_rows"];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->bar_model->getBarLikers($offset,$limit,$keyword);
		
	
		//	$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='barlikers';
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/bar/barlikers_ajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/bar/barlikers', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
	}

    function product_logo()
	{
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		
		
		
		
		
		
		$data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		if($data['getbar']['bar_type']=='half_mug')
		{
			redirect('home/registration_step3_upgrade/'.base64_encode(@$data['getbar']['bar_id']));
		}
		$data["msg"] = '';
		$data["error"] = '';
		//$video_error ='';
		
		if($_POST)
		{
			if(isset($_FILES['cap_image']) && $_FILES["cap_image"]["name"] != ""){
			$tmpName = $_FILES['cap_image']['tmp_name'];
			if($this->input->post('prev_cap_image')!='' && $_FILES["cap_image"]["name"]=="")
			{
				 $data["error"] .= "<p>Please select cap image.</p>";
			}
			else 
			{
				
				list($width, $height, $type, $attr) = getimagesize($tmpName);
			}
			
			if($width < 120 || $height < 120 || $width!=$height)
			{
				
				   $data["error"] .= "<p>Cap Image size must be greater than 120px by 120px and in square.</p>";
			}
		  }else if($this->input->post('prev_cap_image')==''){
				 $data["error"] .= "<p>Please select cap image.</p>";
		  }
			
			if(isset($_FILES['tshirt_image']) && $_FILES["tshirt_image"]["name"] != ""){
			$tmpName = $_FILES['tshirt_image']['tmp_name'];
			if($this->input->post('prev_tshirt_image')!='' && $_FILES["tshirt_image"]["name"]=="")
			{
				$data["error"] .= "<p>Please select tshirt image.</p>";
			}
			else 
			{
				list($width, $height, $type, $attr) = getimagesize($tmpName);
			}
			
			if($width < 120 || $height < 120 || $width!=$height)
			{
				   $data["error"] .= "<p>Tshirt Image size must be greater than 120px by 120px and in square.</p>";
			}
		  }
			else if($this->input->post('prev_tshirt_image')==''){
				 $data["error"] .= "<p>Please select tshirt image.</p>";
		  }
			if($data["error"] =="")
		{			
			$this->bar_model->bar_update_logo();			
			$data["msg"] = "success";	
		}
		}
		
		if($data["error"] !="")
		{
			$response = array("comment_error"=>$data["error"],"status"=>"fail");
			echo json_encode($response);
		    die;
		}
		
		if($data["msg"] == "success")
		{
			$response = array("status"=>"success");
			echo json_encode($response);
		    die;
		}
		$data['result'] = $this->bar_model->get_store_result();
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/bar/productlogo_ajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/bar/productlogo', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
	}

	function product_setting()
	{
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		
		$data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		if($data['getbar']['bar_type']=='half_mug')
		{
			redirect('home/registration_step3_upgrade/'.base64_encode(@$data['getbar']['bar_id']));
		}
		$data["msg"] = '';
		$data["error"] = '';
		if($_POST)
		{			
			$this->bar_model->bar_update_product();			
			$data["msg"] = "success";	
		}
		
		if($data["error"] !="")
		{
			$response = array("comment_error"=>$data["error"],"status"=>"fail");
			echo json_encode($response);
		    die;
		}
		$data['result'] = $this->bar_model->get_store_result();
		if($data["msg"] == "success")
		{
			$response = array("status"=>"success");
			echo json_encode($response);
		    die;
		}
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/bar/productsetting', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		
	}	
  
    function all_orders($limit=5,$keyword='1V1',$offset=0,$msg='')
	{
		// if($this->session->userdata('user_type')!='bar_owner')
		// {
			// redirect('home');
		// }
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		
		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		if($data['getbar']['bar_type']=='half_mug')
		{
			redirect('home/registration_step3_upgrade/'.base64_encode(@$data['getbar']['bar_id']));
		}
		if($this->input->post('event_keyword')!='')
		{
			$keyword= $this->input->post('event_keyword');
			$limit= $this->input->post('limit');
			$offset= $this->input->post('offset');
		}
		else {
			$keyword = $keyword;
			$limit= $limit;
			$offset= $offset;
		}
		 if($this->input->post('from_date')!="" && $this->input->post('to_date')!="")
		 {
		 	$from_date= date("Y-m-d", strtotime($this->input->post('from_date')));
		 	$to_date= date("Y-m-d", strtotime($this->input->post('to_date')));
		 }
		 else {
			$from_date = "";
			$to_date = ""; 	 
		 }
		 
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'bar/all_orders/'.$limit.'/'.$keyword;
		$config["total_rows"] = $this->bar_model->getBarOrdercount(@$data['getbar']['bar_id'],$keyword,$from_date,$to_date);
		
		//$config['total_rows'] = $this->service_provider_model->countStaff($id,$keyword);
		//echo $data["total_rows"];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->bar_model->getBarOrderDetail(@$data['getbar']['bar_id'],$offset,$limit,$keyword,$from_date,$to_date);
		
		
		//	$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='all_orders';
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/bar/bar_order_ajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/bar/bar_order', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
		
	}

	function orderhistory($limit=10,$keyword='1V1',$offset=0,$msg='')
	{
		// if($this->session->userdata('user_type')!='bar_owner')
		// {
			// redirect('home');
		// }
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		
		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        //$data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		
		if($this->input->post('event_keyword')!='')
		{
			$keyword= $this->input->post('event_keyword');
			$limit= $this->input->post('limit');
			$offset= $this->input->post('offset');
		}
		else {
			$keyword = $keyword;
			$limit= $limit;
			$offset= $offset;
		}
		 if($this->input->post('from_date')!="" && $this->input->post('to_date')!="")
		 {
		 	$from_date= date("Y-m-d", strtotime($this->input->post('from_date')));
		 	$to_date= date("Y-m-d", strtotime($this->input->post('to_date')));
		 }
		 else {
			$from_date = "";
			$to_date = ""; 	 
		 }
		 
		$config['uri_segment']='5';
		$config['base_url'] = base_url().'bar/orderhistory/'.$limit.'/'.$keyword;
		$config["total_rows"] = $this->bar_model->getUserOrdercount($keyword,$from_date,$to_date);
		
		//$config['total_rows'] = $this->service_provider_model->countStaff($id,$keyword);
		//echo $data["total_rows"];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->bar_model->getUserOrderDetail($offset,$limit,$keyword,$from_date,$to_date);
		
	
		
		//	$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='orderhistory';
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/bar/orderhistory_ajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/bar/orderhistory', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
		
	}

	function getAllGalAjax()
	{
		$theme = getThemeName ();
		$data = array();
		$data['i'] = $this->input->post('id');
		$data["bar_gallery"] = $this->bar_model->getBarGalleryAll123($this->input->post('id'));
		$data["bar_one_gallery"] = $this->bar_model->getOneGallery($this->input->post('id'));
		
			echo $this->load->view($theme .'/bar/getajaxgal',$data,TRUE);die;
	}
	function getAllGalAjaxbar()
	{
		$theme = getThemeName ();
		$data = array();
		$data['i'] = $this->input->post('id');
		$data["bar_detail"] = $this->bar_model->get_one_bar($this->input->post('id1'));
		//print_r($data["bar_detail"]);
		$data["bar_gallery"] = $this->bar_model->getBarGalleryAll123($this->input->post('id'));
		$data["bar_one_gallery"] = $this->bar_model->getOneGallery($this->input->post('id'));
		echo $this->load->view($theme .'/bar/getajaxgalbar',$data,TRUE);die;
	}

    function getseachpage()
	{
		$theme = getThemeName ();
		$data = array();
		echo $this->load->view($theme .'/home/searchbox',$data,TRUE);die;
	} 
	
	function getmapajax()
	{
		$theme = getThemeName ();
		$data = array();
		$data['bar_detail'] = $this->bar_model->get_one_bar($this->input->post('id'));
		echo $this->load->view($theme .'/home/map',$data,TRUE);die;
		
	}
	function getbarreportajax()
	{
		$theme = getThemeName ();
		$data = array();
		$data['bar_detail'] = $this->bar_model->get_one_bar($this->input->post('id'));
		echo $this->load->view($theme .'/bar/report_bar.php',$data,TRUE);die;
		
	}
	
	
    
	function insertlat()
	{
		$result = $this->bar_model->getAllBarResult();
		// print_r($result);
		// die;
		
		
		foreach($result as $row)
		{
				  $getlat = getCoordinatesFromAddress($row->address,$row->city,$row->state);
				  $data_update = array('lat'=>$getlat['lat'],'lang'=>$getlat['lng'],'gt'=>'1');
				  $this->db->where('bar_id',$row->bar_id);
				  $this->db->update('bars',$data_update);
		}
		
	}
	
	function insertlat1()
	{
		$result = $this->bar_model->getAllBarResult1();
		print_r(json_encode($result));
		die;
	
		foreach($result as $row)
		{
				  $getlat = getCoordinatesFromAddress($row->address,$row->city,$row->state);
				  
				  $data_update = array('lat'=>$getlat['lat'],'lang'=>$getlat['lng'],'gt'=>'1');
				  $this->db->where('bar_id',$row->bar_id);
				  $this->db->update('bars',$data_update);
		}
		
	}
	
	function insertlat112()
	{
		 $data_update = array('lat'=>$this->input->post('lat'),'lang'=>$this->input->post('lng'),'gt'=>'1');
		 $this->db->where('bar_id',$this->input->post('id'));
		 $this->db->update('bars',$data_update);
	}
	function testd()
	{
		
		
		$data = array();
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->template->write_view ('content_center', $theme.'/home/test', $data, TRUE);
		$this->template->render();
	}
	
	
	
	
	function insertlat11()
	{
		$result = $this->bar_model->getAllBarResult11();
		print_r(json_encode($result));
		die;
		
		foreach($result as $row)
		{
				  $getlat = getCoordinatesFromAddress($row->address,$row->city,$row->state);
				   print_r($getlat);
				   die;
				  
				  $data_update = array('lat'=>$getlat['lat'],'lang'=>$getlat['lng'],'gt'=>'1');
				  $this->db->where('bar_id',$row->bar_id);
				  $this->db->update('bars',$data_update);
		}
		
	}
	
	function insertlat1123()
	{
		 $data_update = array('lat'=>$this->input->post('lat'),'lang'=>$this->input->post('lng'),'gt'=>'1');
		 $this->db->where('bar_id',$this->input->post('id'));
		 $this->db->update('bars',$data_update);
	}
	function testd1()
	{
		
		
		$data = array();
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->template->write_view ('content_center', $theme.'/home/test1', $data, TRUE);
		$this->template->render();
	}
	
	function getmapajax_half()
	{
		$theme = getThemeName ();
		$data = array();
		$data['bar_detail'] = $this->bar_model->get_one_bar($this->input->post('id'));
		$data['bar_detail_map'] = $this->bar_model->getbarnear($data['bar_detail']['lat'],$data['bar_detail']['lang']);
		echo $this->load->view($theme .'/home/map2',$data,TRUE);die;
		
	}
	
	function add_report_bar()
	{
		if($this->input->post('report_type')=="Other")
		{
			$desc = $this->input->post('desc');
		}
		else {
			$desc = '';
		}
		$arr = array('status'=> $this->input->post('report_type'),
		             'bar_id'=>$this->input->post('bar_id'),
		             'reported_by'=>$this->input->post('email'),
		             'desc'=>$desc,
					 'user_id'=> get_authenticateUserID(),
					 'date'=>date('Y-m-d H:i:s'));
		$this->db->insert('report',$arr);
		echo "success";
		die;			 
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
	
        function bar_happy_hours($msg='')
	{
		// print_r($_POST);
		// die;
		if($this->session->userdata('user_type')!='bar_owner')
		{
			redirect('home');
		}
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}

		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		
		
		if($data['getbar']['bar_type']=='half_mug')
		{
			redirect('home/registration_step3_upgrade/'.base64_encode(@$data['getbar']['bar_id']));
		}
		$data['getbar_hour'] = $this->bar_model->get_bar_happy_hour(@$data['getbar']['bar_id']);
		if($this->input->post('submit')=="Submit")
		{
		
			$this->bar_model->bar_happy_hours_update($data['getbar']['bar_id']);			
				$data["msg"] = "success";	
//			redirect("bar/bar_special_hours/update");	
			redirect("bar/bar_happy_hours/update");	
		}
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/bar/bar_happy_hour', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
	}
        
	function bar_special_hours($msg='')
	{
		// print_r($_POST);
		// die;
		if($this->session->userdata('user_type')!='bar_owner')
		{
			redirect('home');
		}
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}

		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		
		
		if($data['getbar']['bar_type']=='half_mug')
		{
			redirect('home/registration_step3_upgrade/'.base64_encode(@$data['getbar']['bar_id']));
		}
		$data['getbar_hour'] = $this->bar_model->get_bar_hour(@$data['getbar']['bar_id']);
		if($this->input->post('submit')=="Submit")
		{
		
			$this->bar_model->bar_hours_update($data['getbar']['bar_id']);			
				$data["msg"] = "success";	
//			redirect("bar/bar_special_hours/update");	
			redirect("bar/bar_special_hours");	
		}
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/bar/bar_special_hour', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
	}
   
    function add_bar_hours($bar_id)
	{
		
	}
	
	function removebarhours($id=0)
	{
			$this->db->where('bar_hour_id',$id)->delete('bar_special_hours');
	}
function removebarhoursall($id=0)
	{
			$this->db->where('rand',$id)->delete('bar_special_hours');
	}


    function myproduct($limit=10,$keyword='1V1',$offset=0,$msg='')
	{
		
	    if($this->session->userdata('user_type')!='bar_owner')
		{
			redirect('home');
		}
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}

		$data = array();
		$data['msg'] = $msg;
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$this->load->library('pagination');
		$page_detail=meta_setting();
		$pageTitle=$page_detail->title;
		$metaDescription=$page_detail->meta_description;
		$metaKeyword=$page_detail->meta_keyword;
		
		$data['error'] = '';
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
        $data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
		$data['checkpaymentexist'] = checkpaymentexist($data['getbar']['bar_id']); 
		if($data['getbar']['bar_type']=='half_mug')
		{
			redirect('home/registration_step3_upgrade/'.base64_encode(@$data['getbar']['bar_id']));
		}
		if($this->input->post('event_keyword')!='')
		{
			$keyword= $this->input->post('event_keyword');
			$limit= $this->input->post('limit');
			$offset= $this->input->post('offset');
		}
		else {
			$keyword = $keyword;
			$limit= $limit;
			$offset= $offset;
		}
		$config['uri_segment']='5';
		
		$config['base_url'] = base_url().'bar/myproduct/'.$limit.'/'.$keyword;
		$config["total_rows"] = $this->bar_model->getBarProductcount(@$data['getbar']['bar_id'],$keyword);
		
		//$config['total_rows'] = $this->service_provider_model->countStaff($id,$keyword);
		//echo $data["total_rows"];
		$config['per_page'] = $limit;
		$this->pagination->initialize($config);	
		$data['page_link'] = $this->pagination->create_links();
		$data['result'] = $this->bar_model->getBarProductDetail(@$data['getbar']['bar_id'],$offset,$limit,$keyword);
		
	
		//	$data['result'] = $this->bar_model->getAllComments($bar_id,$offset,$limit);	
		$data['offset'] = $offset;
		$data['limit'] = $limit;
		$data['redirect_page']='myproduct';
		
		if($this->input->is_ajax_request()){
			echo $this->load->view($theme .'/bar/bar_products_ajax',$data,TRUE);die;
			
		}
		else {
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/bar/bar_products', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render ();
		}
	}
      
	 function paypal_setting($msg='')
	 {
	 	$data = array();
	 	 if($this->session->userdata('user_type')!='bar_owner')
		{
			redirect('home');
		}
	 	if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
	
		$data['getbar'] = $this->home_model->get_bar_info(get_authenticateUserID());
			if($data['getbar']['bar_type']=='half_mug')
		{
			redirect('home/registration_step3_upgrade/'.base64_encode(@$data['getbar']['bar_id']));
		}
		$checkpaymentexist = checkpaymentexist($data['getbar']['bar_id']);
		
		
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$data['page_name']="credit_card_update";
		 $data['msg'] = $msg; //login fail message
	  $this->form_validation->set_rules('site_status','Status', 'required');
	  $this -> form_validation -> set_rules('vendor', 'Vendor', 'required');
	  $this -> form_validation -> set_rules('paypal_username', 'Username', 'required');
	  $this -> form_validation -> set_rules('paypal_password', 'Password', 'required');
	  $data['error'] = '';
	  
	   if($this->form_validation->run() == FALSE)
		{
			
				if(validation_errors())
				{													
					$data["error"] = validation_errors();
				}
				else
				{		
					$data["error"] = "";							
				}
					$data['site_status']=$this->input->post('site_status');
					$data["paypal_password"] = $this -> input -> post('paypal_password');
					$data["paypal_username"] = $this -> input -> post('paypal_username');
					$data["vendor"] = $this -> input -> post('vendor');
		}
        else
		{
			
			 if($checkpaymentexist)
			 {
			 	$this->bar_model->update_paypal($data['getbar']['bar_id']);
			 }
			 else
			 {
			 	$this->bar_model->insert_paypal($data['getbar']['bar_id']);
			 }	
			 $msg = "success";
		}
		if(!empty($checkpaymentexist))
		{
			$data['site_status']=$checkpaymentexist->site_status;
			//$data['client_id']=$checkpaymentexist->client_id;
			//$data['secret_key']=$checkpaymentexist->secret_key;
			$data["paypal_password"] = $checkpaymentexist -> paypal_password ;
			$data["paypal_username"] = $checkpaymentexist -> paypal_username ;
			$data["vendor"] = $checkpaymentexist -> vendor ;
		}
		if($data["error"] !="")
		{
			$response = array("comment_error"=>$data["error"],"status"=>"fail");
			echo json_encode($response);
		    die;
		}
		
		if($msg == "success")
		{
			$response = array("status"=>"success");
			echo json_encode($response);
		    die;
		}
	
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/bar/paypalinfo', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);
		$this->template->render (); 
	 } 
     function add_product($bar_id='')
	{
		$imagarr = '';
		if($this->session->userdata('user_type')!='bar_owner')
		{
			redirect('home');
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('product_name', 'Product Name', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('quantity', 'Quantity', 'required');
		//$this->form_validation->set_rules('back_col', 'Background Color','required');
		$this->form_validation->set_rules('price', 'Price', 'required|numeric');
		$this->form_validation->set_rules('color', 'Color', 'required');
		$this->form_validation->set_rules('size', 'Size', 'required');
		$this->form_validation->set_rules('store_meta_title', 'Meta Title', 'required');
		$this->form_validation->set_rules('store_meta_keyword', 'Meta Keyword', 'required');
		$this->form_validation->set_rules('store_meta_description', 'Meta Description', 'required');
		
		$data["error"] = '';
		$data["msg"] = '';
		
		
		if($_POST)
		{
			if(count($_FILES['photo_image']['name'])>0 && $_FILES['photo_image']['name'][0]!=''){
				foreach ($_FILES['photo_image']['name'] as $key => $value) {
					if($_FILES['photo_image']['name'][$key]!=''){
					   $imagarr=$this->validate_image(array('name'=>$_FILES['photo_image']['name'][$key],'type'=>$_FILES['photo_image']['type'][$key]));
					}
					if($imagarr!='')
					{
						break;
					}
				}
				//echo $imagarr.'<br>';
				
			}else{
				if($this->input->post('store_id')==''){
				$imagarr ="Product image is required.";
				}
			}
		}	
		
		
		$bar_detail = $this->bar_model->get_one_bar(base64_decode($bar_id));
		
		if($this->form_validation->run() == FALSE || $imagarr!='')
		{			
				if(validation_errors()  || $imagarr!='')
				{
					$data["error"] = validation_errors().$imagarr;
				}else{
					$data["error"] = "";
				}
				
					$this->form_validation->set_rules('product_name', 'Product Name', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('quantity', 'Quantity', 'required');
		$this->form_validation->set_rules('back_col', 'Background Color','required');
		$this->form_validation->set_rules('price', 'Price', 'required|numeric');
		$this->form_validation->set_rules('color', 'Color', 'required');
		$this->form_validation->set_rules('size', 'Size', 'required');
		$this->form_validation->set_rules('store_meta_title', 'Meta Title', 'required');
		$this->form_validation->set_rules('store_meta_keyword', 'Meta Keyword', 'required');
		$this->form_validation->set_rules('store_meta_description', 'Meta Description', 'required');
		
				$data["product_name"] = $this->input->post('product_name');
				$data["description"] = $this->input->post('description');
				$data["quantity"] = $this->input->post('quantity');
				$data["back_col"] = $this->input->post('back_col');
				$data["price"] = $this->input->post('price');
				$data["store_id"] = $this->input->post('store_id');
				$data["color"] = $this->input->post('color');
				$data["size"] = $this->input->post('size');
				$data["zipcode"] = $this->input->post('zipcode');
				$data["store_meta_title"] = $this->input->post('store_meta_title');
				$data["prev_event_image"] = $this->input->post('prev_event_image');
				$data["store_meta_keyword"] = $this->input->post('store_meta_keyword');
				$data["store_meta_description"] = $this->input->post('store_meta_description');
				$data["status"] = $this->input->post('status');
		}
		else {
			if($this->input->post('store_id')=='')
			{
			    $this->bar_model->product_insert(base64_decode($bar_id));			
				$data["msg"] = "success";	
			}
			else {
				$this->bar_model->product_update(base64_decode($bar_id));			
				$data["msg"] = "success";
			}
			
			
		}
		
		if($data["error"] !="")
		{
			$response = array("comment_error"=>$data["error"],"status"=>"fail");
			echo json_encode($response);
		    die;
		}
		
		if($data["msg"] == "success")
		{
			$response = array("status"=>"success");
			echo json_encode($response);
		    die;
		}
	}

	function barproductdetail()
	{
		
		$getdata = $this->bar_model->getOneProduct();
		print_r(json_encode($getdata)) ;
		die;
	}
	
	function barproductgalleryimages()
	{
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$data = array();
		$data['imageGallery'] = $this->bar_model->getProductGalleryImages();
		
		//print_r($data['imageGallery']) ;
		echo $this->load->view($theme.'/bar/bar_productgallery_images_ajax',$data);
		//die;
	}

	function removeImageAjaxProduct($id=0)
	{
		$oneImage=$this->bar_model->getOneProductImageGallery($id);
		//print_r($oneImage);die;
		if($oneImage!='')
		{
			if($oneImage->product_image_name!=''){
			if(file_exists(base_path().'upload/product_thumb/'.$oneImage->product_image_name))
			{
				unlink(base_path().'upload/product_thumb/'.$oneImage->product_image_name);
			}
			if(file_exists(base_path().'upload/product_thumb_big/'.$oneImage->product_image_name))
			{
				unlink(base_path().'upload/product_thumb_big/'.$oneImage->product_image_name);
			}
			if(file_exists(base_path().'upload/product_thumb_80/'.$oneImage->product_image_name))
			{
				unlink(base_path().'upload/product_thumb_80/'.$oneImage->product_image_name);
			}
			if(file_exists(base_path().'upload/product_orig/'.$oneImage->product_image_name))
			{
				unlink(base_path().'upload/product_orig/'.$oneImage->product_image_name);
			}
			
			}
			$this->db->where('product_image_id',$oneImage->product_image_id)->delete('product_images');
		}
		
	}	
	
	/*
	* function : statusChnage 
	* param: order_id, order Status 
    * description :for order status Chnage.
    */
    function statusChange($order_id, $order_status)
    {
    	
    	
		$this->bar_model->changeOrderStatus($order_id,$order_status);
		echo 'done';die;
	}
	//end of statusChange
	
	function getBarSpecialHoursByID()
	{
		$data['cur'] =  $this->input->post('day');
		$data['getbarhour'] = $this->bar_model->getBarSpecialHoursByIDGroup($this->input->post('id'),$this->input->post('day')); 
		//print_r($getbarhour);
		//die;
		
		$theme = getThemeName ();
		echo $this->load->view($theme .'/bar/displayhours',$data,TRUE);die;
	}	 
}
?>