<?php
class Resource extends SPACULLUS_Controller {
 
	/*
	 Function name :User()
	 */

	function Resource() {
		parent :: __construct ();
	    $this->load->model('resource_model');
	}

	public function index ($msg = '') {
		
		
		redirect('resource/lists');

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
        $data['active_menu']='resource';
		
		
		
		$getad = getadvertisement('resourcelist','top'); 
		
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
		
		
		
		$getadsec = getadvertisement('resourcelist','bottom'); 
		
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
		
		
		if($_POST)
		{			
		    $keyword = $this->input->post("keyword");
			$resource_category = $this->input->post("resource_category"); 			
			
			
			$order = explode("#",$this->input->post("order_by"));
			
			 
				if(isset($order[0]) && isset($order[1]))
				{
					 $sort_by = $order[0];
				     $sort_type = $order[1];	
				}
				else
				{
				     $sort_by = "resource_id";
				     $sort_type = "DESC";		
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
					$resource_category = $get_option[3];					
				}
				else
			    {
					 $sort_by = "resource_id";
					 $sort_type = "DESC";	
					 //$type = "0";
					 $keyword = '0';
					 $resource_category = '0';
				}			 
		}
		
		$this->load->library('pagination');
		//echo $sort_by."@".$sort_type."@".$type."@".$keyword;
		$options = base64_encode($sort_by."@".$sort_type."@".$keyword."@".$resource_category);

		$config['uri_segment']='6';
		$config['base_url'] = base_url().'resource/lists/'.$limit.'/'.$alpha."/".$options.'/';
		$config['total_rows'] = $this->resource_model->get_total_resource_count($keyword,$alpha,$resource_category);
		
		$data["total_rows"] = $config['total_rows'];
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		$data['result'] = $this->resource_model->get_resource_result($offset,$limit,$sort_by,$sort_type,$keyword,$alpha,$resource_category);
		
	
	
	
		$data['msg'] = $msg;
		$data["task_type"] = '';
		
		$data["options"] = $options;
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
		if($keyword == "0"){$keyword = '';}
		if($resource_category == "0"){$resource_category = '';}
	    $data['keyword'] = $keyword;
		$data['resource_category'] = $resource_category;
		
		$data['redirect_page']='lists';
		$data['sort_type']=$sort_type;
		$data['sort_by']=$sort_by;
		$data['page_name']="Video";
	    $data["order_by"] = $sort_by."#".$sort_type;
		$data["alpha"] = $alpha;
		
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
		$this->template->write_view ('content_center', $theme.'/resource/lists', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();

	}

	
	
   function detail($resource_id = 0, $limit = 5 , $offset = 0 ,$msg = '')
   {
   		if($resource_id=="" || $resource_id=="0")
		{
			redirect('home');
		}
        
   	  	//$bar_id = base64_decode($bar_id);
		
		//$bar_id = getBarID($bar_slug);
   	  	//$resource_id = getresourceID($resource_slug);

	    $data = array();
		$data['msg'] = $msg;
		$data["resource_id"] = base64_decode($resource_id);
		$resource_id = base64_decode($resource_id);
		
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		$data["resource_detail"] = $this->resource_model->get_one_resource($resource_id);
		$page_detail=meta_setting();
		// $pageTitle= $page_detail->title;
		// $metaDescription=$page_detail->meta_description;
		// $metaKeyword=$page_detail->meta_keyword;
		
		$pageTitle= $data["resource_detail"]['resource_meta_title'];
		$metaDescription= $data["resource_detail"]['resource_meta_description'];
		$metaKeyword=$data["resource_detail"]['resource_meta_keyword'];
	
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		
		$this->load->library('pagination');

        if(get_authenticateUserID() > 0)
        {
		  $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        }
        else
        {
            $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        }
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/resource/resource_detail', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();		
    } 

 /*
 * function : resource_comment_ajax
 * ajax pagination for resource comment
 * return array view
 * 
 */
    function resource_comment_ajax($resource_id,$limit=0,$offset=0)
	{
		$data=array();
	    $theme = getThemeName();
	    
	    $this->load->library('pagination');

		$config['uri_segment']='5';
		$config['base_url'] = base_url().'resource/resource_comment_ajax/'.$resource_id."/".$limit;
		$config['total_rows'] = $this->resource_model->get_resource_comments_count($resource_id);
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		
		$data["site_setting"] = site_setting();
	
		$pageTitle = 'resource-Comment';
		$metaDescription= 'resource-Comment';
		$metaKeyword= 'resource-Comment';
		
		$data["resource_comment"] = $this->resource_model->get_resource_comments($resource_id,$limit,$offset);
		$data["resource_detail"] = $this->resource_model->get_one_resource($resource_id);
		$data["resource_subcomment"] = $this->resource_model->get_resource_subcomments($resource_id);
		echo   $this->load->view($theme .'/resource/resource_comment_ajax',$data,TRUE);
	}	 



	function add_rating()
	{
  		$data = $_POST;
	  	$data["date_added"] = date("Y-m-d H:i:s");
	  	$this->db->insert("resource_comment",$data);
	 	$id = mysql_insert_id();	 
	 	echo get_resource_rating($_POST["resource_id"]);
	// echo $id;
  	}
	function resource_likes($bid = 0){
		
		// if(!get_authenticateUserID())
			// {
				// $this->session->set_userdata("REDIRECT_PAGE","resource/resource_detail/".base64_encode($bid));
				// redirect("home/login");
			// }
			
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}	
		$data = $_POST;
		$data["date_added"] = date("Y-m-d H:i:s");
		if($_POST['like_flag']==2){
			$data['like_flag']=1;
			$this->db->insert("all_likes",$data);
			echo $cnt_like = like_checker($_POST['resource_id'],$_POST['user_id']);			
			$data['user_id'] = $this->resource_model->one_resource_likers($_POST['user_id']);
			if($data['user_id']!=""){
				$profile = $data['user_id']->profile_image;
				echo '*<li id="user_'.$_POST['user_id'].'" class="active"><a href="'.site_url('user/profile/'.base64_encode(get_authenticateUserID())).'"><img src="'.base_url().'upload/user_thumb/'.$profile.'" class="user_img"/>';
			}
			else{
				echo '*<li id="user_'.$_POST['user_id'].'" class="active"><a href="'.site_url('user/profile/'.base64_encode(get_authenticateUserID())).'"><img src="'.base_url().'upload/user_thumb/no_img.png" class="user_img"/>';
			}
		}
		else{			
			$data_update = array("like_flag"=>$_POST['like_flag']);
			$this->db->where("resource_id",$_POST['resource_id']);
			$this->db->where("user_id",get_authenticateUserID());
			$this->db->update("all_likes",$data_update);
			echo $cnt_like = like_checker($_POST['resource_id'],get_authenticateUserID());
			
			if($cnt_like ==0){
				echo '*user_'.get_authenticateUserID();
			}
			else{
				$data['user_id'] = $this->resource_model->one_resource_likers(get_authenticateUserID());
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

	function resource_fav($bid = 0){
		
		// if(!get_authenticateUserID())
			// {
				// $this->session->set_userdata("REDIRECT_PAGE","resource/resource_detail/".base64_encode($bid));
				// redirect("home/login");
			// }
			
		if(get_authenticateUserID()=='')
		{
			redirect('home');
		}	
		$data = $_POST;
		$data["date_added"] = date("Y-m-d H:i:s");
		if($_POST['fav_flag']==2){
			$data['resource_fav_flag']=1;
			$this->db->insert("all_likes",$data);
			echo $cnt_like = fav_checker($_POST['resource_id'],$_POST['user_id']);			
			$data['user_id'] = $this->resource_model->one_resource_likers($_POST['user_id']);
			if($data['user_id']!=""){
				$profile = $data['user_id']->profile_image;
				echo '*<li id="user_'.$_POST['user_id'].'" class="active"><a href="#"><img src="'.base_url().'upload/user_thumb/'.$profile.'" class="user_img"/>';
			}
			else{
				echo '*<li id="user_'.$_POST['user_id'].'" class="active"><a href="#"><img src="'.base_url().'upload/user_thumb/no_img.png" class="user_img"/>';
			}
		}
		else{			
			$data_update = array("resource_fav_flag"=>$_POST['fav_flag']);
			$this->db->where("resource_id",$_POST['resource_id']);
			$this->db->where("user_id",get_authenticateUserID());
			$this->db->update("all_likes",$data_update);
			echo $cnt_like = fav_checker($_POST['resource_id'],get_authenticateUserID());
			
			if($cnt_like ==0){
				echo '*user_'.get_authenticateUserID();
			}
			else{
				$data['user_id'] = $this->resource_model->one_resource_likers(get_authenticateUserID());
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
	
	
	function deletefavresource()
	{
			$data_update = array("resource_fav_flag"=>0);
			$this->db->where("resource_id",$_POST['id']);
			$this->db->where("user_id",get_authenticateUserID());
			$this->db->update("all_likes",$data_update);
	}
  	function update_totalviews()
	{
	    $view = $_REQUEST["view"];
		$qry = $this->db->query("update ".$this->db->dbprefix("video")." set total_views = total_views + 1 where video_id = '".$view."' ");	
	}
	
	function add_comment($bid = 0){
		//$data_insert = $_POST;	
		
		// if(!check_user_authentication())
			// {
				// $this->session->set_userdata("REDIRECT_PAGE","resource/resource_detail/".base64_encode($bid));
				// redirect("home/login");
			// }
// 			
			if(get_authenticateUserID()=='')
		{
			redirect('home');
		}	
		$erro_str = '';
		if($_POST["comment_title"] == '')
		{
			  $erro_str .=  "<p>Comment title is required</p>";
		}
		
		// if($_POST["comment"] == '')
		// {
			// $erro_str .=  "<p>Comment  is required</p>";
		// }
		
		if($_POST["comment_video"]!='')
		{
		if ( !filter_var($_POST["comment_video"] , FILTER_VALIDATE_URL) === false) {
		    $erro_str = "";
		} else {
		     $erro_str = "<p>Please enter valid video url.</p>";
		}
		}
		if(isset($_FILES['comment_image']) && $_FILES["comment_image"]["name"] != "")
		{
			$image_arr = array('image/gif','image/jpeg', 'image/pjpeg','image/jpeg', 'image/pjpeg','image/jpeg', 'image/pjpeg','image/png',  'image/x-png');
			if(!in_array($_FILES["comment_image"]["type"],$image_arr))
				{
					$erro_str .= "<p>Please upload jpg,jpeg,png,gif format only</p>";
				}
		}
		
		// if(isset($_FILES['comment_video']) && $_FILES["comment_video"]["name"] != "")
		// {
			// $mp4_arr = array('video/mp4','video/x-flv', 'flv-application/octet-stream', 'application/octet-stream');
			// if(!in_array($_FILES["comment_video"]["type"],$mp4_arr))
				// {
					// $erro_str .= "<p>Please upload flv or mp4 video</p>";
				// }
			// if($_FILES['comment_video']["size"]>"5242880")
			// {
				// $erro_str .= "<p>Video size can not be more than 5MB</p>";
			// }	
		// }
		
		if($erro_str !="")
		{
			$response = array("comment_error"=>$erro_str,"status"=>"fail");
			echo json_encode($response);
		     die;
		}
		
		
		$cmt_id = $this->resource_model->insert_comment($_POST);		
		/*echo "Your comment added successfully";*/
		$latest_comment = latest_comment($_POST['resource_id'],$cmt_id);
		$latest_comment->cust_date = date('d M',strtotime($latest_comment->date_added));
	    $latest_comment->date_duration = getDuration($latest_comment->date_added); 
	    $vget = '';
	     if($latest_comment->comment_video!=''){
            $url	=	$latest_comment->comment_video;
				if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',$url,$matches)) {
					//echo $url;
				      //preg_match('/[\\?\\&]v=([^\\?\\&]+)/',$url,$matches);
				      //preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',$url,$matches);
							if(isset($matches[1])){
							$id = $matches[1];
								$vget =  '<iframe style="width:640px; height:250px;" class="br_red img-responsive max-height embed_vid_height"  src="//www.youtube.com/embed/'.$id.'?rel=0" frameborder="0" allowfullscreen></iframe>';
							}else{
								$vget = $url;
							}
				    } elseif (strpos($url, 'vimeo') > 0) {
				    	preg_match('~^http://(?:www\.)?vimeo\.com/(?:clip:)?(\d+)~',$url,$matches);
				//	$parsed = parse_url($url);
					//print_r($parsed);
				       if(isset($matches[1])){
							$id = $matches[1];
							$vget = '<iframe style="width:640px; height:250px;" src="//player.vimeo.com/video/'.$id.'" class="br_red img-responsive max-height embed_vid_height" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> ';	
								
							}else{
								$a=json_decode(file_get_contents('http://vimeo.com/api/oembed.json?url='.$url));
								
								if(isset($a->video_id) && $a->video_id!=''){
								$id=$a->video_id;
									$vget = '<iframe style="width:640px; height:250px;" src="//player.vimeo.com/video/'.$id.'" class="br_red img-responsive max-height embed_vid_height" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> ';	
								}
							}
				    }
				    }
		$latest_comment->testdd= $vget;
		
		if($latest_comment->profile_image == "" || !is_file(base_path()."upload/user_thumb/".$latest_comment->profile_image))
		{
			$latest_comment->profile_image = "no_img.png";
		}		
		$res =  json_encode($latest_comment);
		echo $res;
	}
	function add_subcomment($bid =0){
		///validation before submit
		
		// if(!check_user_authentication())
			// {
				// $this->session->set_userdata("REDIRECT_PAGE","resource/resource_detail/".base64_encode($bid));
				// redirect("home/login");
// 				
// 				
			// }
// 			

        if(get_authenticateUserID()=='')
		{
			redirect('home');
		}
		$erro_str = '';
		
		if($_POST["comment"] == '')
		{
			$erro_str .=  "<p>Comment  is required</p>";
		}
		
		if(isset($_FILES['comment_image']) && $_FILES["comment_image"]["name"] != "")
		{
			$image_arr = array('image/gif','image/jpeg', 'image/pjpeg','image/jpeg', 'image/pjpeg','image/jpeg', 'image/pjpeg','image/png',  'image/x-png');
			if(!in_array($_FILES["comment_image"]["type"],$image_arr))
				{
					$erro_str .= "<p>Please upload jpg,jpeg,png,gif format only</p>";
				}
		}
		
		if(isset($_FILES['comment_video']) && $_FILES["comment_video"]["name"] != "")
		{
			$mp4_arr = array('video/mp4','video/x-flv', 'flv-application/octet-stream', 'application/octet-stream');
			if(!in_array($_FILES["comment_video"]["type"],$mp4_arr))
				{
					$erro_str .= "<p>Please upload flv or mp4 video</p>";
				}
			if($_FILES['comment_video']["size"]>"5242880")
			{
				$erro_str .= "<p>Video size can not be more than 5MB</p>";
			}	
		}
		
		if($erro_str !="")
		{
			$response = array("comment_error"=>$erro_str,"status"=>"fail","master_comment"=>$_POST["master_comment_id"]);
			echo json_encode($response);
		     die;
		}
		
			// end of validation//
		$cmt_id = $this->resource_model->insert_subcomment($_POST);
		
		$latest_comment = latest_comment($_POST['resource_id'],$cmt_id);
		$latest_comment->cust_date = date('d M',strtotime($latest_comment->date_added));
	    $latest_comment->date_duration = getDuration($latest_comment->date_added); 
		$latest_comment->testdd='config={"playlist":[{"url":"'.base_url().'upload/comment_video/'.$latest_comment->comment_video.'","autoPlay":false}]}';		
		
		if($latest_comment->profile_image == "" || !is_file(base_path()."upload/user_thumb/".$latest_comment->profile_image))
		{
			$latest_comment->profile_image = "no_img.png";
		}		
		
		$res2 =  json_encode($latest_comment);
		echo $res2;
	}
	function resource_comment_likes($bid = 0){
				
			if(!check_user_authentication())
			{
				$this->session->set_userdata("REDIRECT_PAGE","resource/resource_detail/".base64_encode($bid));
				redirect("home/login");
			}
		
		$data = $_POST;
		$data["date_added"] = date("Y-m-d H:i:s");
		if($_POST['like_flag']==2){
			$data['like_flag']=1;
			$this->db->insert("all_likes",$data);
			$total_single = $this->resource_model->single_comment_total_likes($_POST['resource_id'],$_POST['resource_comment_id']);
			$find_flag = $this->resource_model->flag_return($_POST['resource_id'],$_POST['user_id'],$_POST['resource_comment_id']);
			if($find_flag==0){
				$find_flags=1;
			}
			if($find_flag==1){
				$find_flags=0;
			}
			echo $find_flags.'*'.$total_single;
			//echo $cnt_like = like_checker($_POST['resource_id'],$_POST['user_id']);			
			//$data['user_id'] = one_resource_likers($_POST['user_id'],$_POST['like_flag']);
		}
		else{
			$data_update = array("like_flag"=>$_POST['like_flag']);
			$this->db->where("resource_id",$_POST['resource_id']);
			$this->db->where("user_id",$_POST['user_id']);
			$this->db->where("resource_comment_id",$_POST['resource_comment_id']);
			$this->db->update("all_likes",$data_update);
		
			$total_single = $this->resource_model->single_comment_total_likes($_POST['resource_id'],$_POST['resource_comment_id']);
			$find_flag = $this->resource_model->flag_return($_POST['resource_id'],$_POST['user_id'],$_POST['resource_comment_id']);
			if($find_flag==0){
				$find_flags=1;
			}
			if($find_flag==1){
				$find_flags=0;
			}
			echo $find_flags.'*'.$total_single;
		}
		//$this->db->insert("all_likes",$data);
		//echo $cnt_like = like_checker($_POST['resource_id'],$_POST['user_id']);			
	}
	function remove_subcomment(){
		$resource_comment_id = $_POST['resource_comment_id'];
		$this->resource_model->sub_comment_remove($resource_comment_id);
		echo $resource_comment_id;
	}
	
	function actionresourcefav()
	{
		$resource_id =$this->input->post('chk');
			foreach($resource_id as $id)
			{			
				$data_update = array("resource_fav_flag"=>0);
				$this->db->where("resource_id",$id);
				$this->db->where("user_id",get_authenticateUserID());
				$this->db->update("all_likes",$data_update);
			}
		$res=array('status'=>'done');
		echo json_encode($res);die;
	}
	
	function view_all_likers()
	{
		$html = '';
		$bar_liker = $this->resource_model->get_all_resource_likers($this->input->post('id'));
		$html .= "<div class='padtb10'><div class='container'><div class='result_box clearfix mar_top30bot20'><div class='login_block br_green_yellow'><div class='result_search'><button aria-hidden='true' data-dismiss='modal' class='close' type='button'>×</button>
	     				<i class='strip login_icon'></i><div class='result_search_text'>resource Likers</div></div><div class='pad20'><div id='ajax_msg_error_reg'></div><ul class='likeduser marl_0'>";	
		
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
		$html .= "<span class='result_search_text'>No any resource likers found .</span>";
	}
        
		$html .= "</ul><div class='clear'></div></div></div></div></div></div>";
		print_r($html);
		die;
	}
	
	function auto_suggest_resource()
	{
		$operator_list 	 = $this->resource_model->auto_suggest_resource($_REQUEST['em']);
		$arr = array();	
		if($operator_list){
		foreach($operator_list as $key=>$val){
			$arr[] = array("id"=>$val['resource_id'],"label"=>$val['resource_title'],"value"=>$val['resource_title']); 
		}
		}
		print_r(json_encode($arr));die;
	}
  
}
?>