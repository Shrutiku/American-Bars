<?php
class Cocktail extends SPACULLUS_Controller {
 
	/*
	 Function name :User()
	 */

	function Cocktail() {
		parent :: __construct ();
	    $this->load->model('cocktail_model');
	}

	public function index ($msg = '') {
		redirect('cocktail/lists');
	}
	
	function get_client_ip() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
	public function lists($limit='20',$alpha = 'no',$options= '',$offset=0,$msg='') {
		
		//print_r($_SERVER);
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
		
		$data['site_setting'] = site_setting();
        $data['active_menu']='cocktail';
		
		// if($_POST)
		// {			
		    // $keyword = $this->input->post("keyword");
			// $limit = $this->input->post("limit");
			// $order = explode("#",$this->input->post("order_by"));
// 			
// 			
// 			 
				// if(isset($order[0]) && isset($order[1]))
				// {
				     // $sort_type = $order[1];	
				// }
				// else
				// {
				     // $sort_type = "DESC";		
				// }	
		// }
		// else
		// {		$sort_type = "DESC";
				// if($options != "")
				// {
					// $keyword = base64_decode($options);					
				// }
				// else
			    // {
					 // $keyword = '0';
				// }			 
		// }
		if($_POST)
		{			
		    $keyword = $this->input->post("keyword");
			$keyword1 = $this->input->post("keyword1"); 			
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
				
				if($limit == 0)
				{
					$limit = 20;
				}	
		}
		else
		{		
				if($options != "")
				{
				
					$get_option = explode("@",base64_decode($options));
					
				    $sort_by = $get_option[0];
				    $sort_type = $get_option[1];
					$keyword = $get_option[2];	
					$keyword1 = $get_option[3];					
				}
				else
			    {
					 $sort_by = "";
					 $sort_type = "";	
					 //$type = "0";
					 $keyword = '0';
					 $keyword1 = '0';
				}			 
		}
		
		
		$this->load->library('pagination');
		//echo $sort_by."@".$sort_type."@".$type."@".$keyword;
	  if($keyword == "") {$keyword = 0;}
	  if($keyword1 == "") {$keyword1 = 0;}
		//$options = base64_encode($keyword);
		$options = base64_encode($sort_by."@".$sort_type."@".$keyword."@".$keyword1);
		$config['uri_segment']='6';
		
		
		$config['base_url'] = base_url().'cocktail/lists/'.$limit.'/'.base64_encode($alpha)."/".$options.'/';
		$config['total_rows'] = $this->cocktail_model->get_total_cocktail_count($keyword,$keyword1,$alpha);
		
		$data["total_rows"] = $config['total_rows'];
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		$sort_by= 'cocktail_name';
				
		$data['result'] = $this->cocktail_model->get_cocktail_result($offset,$limit,$sort_by,$sort_type,$keyword,$keyword1,$alpha);
		
	  
	
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
	    $data['keyword'] = $keyword;
		if($keyword1 == "0"){$keyword1 = '';}
	    $data['keyword1'] = $keyword1;
		
		$data['redirect_page']='lists';
		$data['sort_type']=$sort_type;
		$data['sort_by']=$sort_by;
		$data['page_name']="Video";
	    $data["order_by"] = $sort_by."#".$sort_type;
		$data["alpha"] = $alpha;
	//	$data["options"] = $options;
		
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
		$this->template->write_view ('content_center', $theme.'/cocktail/lists', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();

	}
	
   function detail($cocktail_slug = 0, $limit = 5 , $offset = 0 ,$msg = '')
   {
   	if($cocktail_slug=="" || $cocktail_slug=="0")
		{
			redirect('home');
		}
   	  	$cocktail_id = getCocktailID($cocktail_slug);

	    $data = array();
		$data['msg'] = $msg;
		$data["cocktail_id"] = $cocktail_id;
		
		$theme = getThemeName ();
		$this->template->set_master_template ($theme.'/template.php');
		
		$data['nextcocktail'] = $this->cocktail_model->getCocktailIdByNext($cocktail_id,'asc');
		
		$data['prevcocktail'] = $this->cocktail_model->getCocktailIdByNext($cocktail_id,'desc');
		$page_detail=meta_setting();
		$data["cocktail_detail"] = $this->cocktail_model->get_one_cocktail($cocktail_id);
		$pageTitle=$data["cocktail_detail"]['cocktail_meta_title'];
		$metaDescription=$data["cocktail_detail"]['cocktail_meta_description'];
		$metaKeyword=$data["cocktail_detail"]['cocktail_meta_keyword'];
		
		$data['site_setting'] = site_setting ();
        $data['active_menu']='home';
        $this->template->write ('pageTitle', $pageTitle, TRUE);
		$this->template->write ('metaDescription', $metaDescription, TRUE);
		$this->template->write ('metaKeyword', $metaKeyword, TRUE);
		
		//$this->cocktail_model->insert_total_views($cocktail_id ,$this->session->userdata("user_id"));
		
		
		
		$data["cocktail_liker"] = $this->cocktail_model->get_cocktail_likers($cocktail_id);
		
		// cocktail comment pagiantiuon ..//
		$this->load->library('pagination');

		$config['uri_segment']='5';
		$config['base_url'] = base_url().'cocktail/cocktail_comment_ajax/'.$cocktail_id."/".$limit;
		$config['total_rows'] = $this->cocktail_model->get_cocktail_comments_count($cocktail_id);
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		
		$data["cocktail_comment"] = $this->cocktail_model->get_cocktail_comments($cocktail_id,$limit,$offset);
		$data["cocktail_subcomment"] = $this->cocktail_model->get_cocktail_subcomments($cocktail_id);
		
  //      $data["check_already_retade"] = check_already_cocktail_rated($cocktail_id,$this->session->userdata("user_id"));
        if(get_authenticateUserID() > 0)
        {
		  $this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
        }
        else
        {
            $this->template->write_view ('header', $theme.'/common/header_home', $data, TRUE);
        }
		$this->template->write_view ('header', $theme.'/common/header', $data, TRUE);
		$this->template->write_view ('content_center', $theme.'/cocktail/cocktail_detail', $data, TRUE);
		$this->template->write_view ('footer', $theme.'/common/footer', $data, TRUE);

		$this->template->render ();		
    } 
	
	 /*
 * function : cocktail_comment_ajax
 * ajax pagination for cocktail comment
 * return array view
 * 
 */
    function cocktail_comment_ajax($cocktail_id,$limit=0,$offset=0)
	{
		$data=array();
	    $theme = getThemeName();
	    
	    $this->load->library('pagination');

		$config['uri_segment']='5';
		$config['base_url'] = base_url().'cocktail/cocktail_comment_ajax/'.$cocktail_id."/".$limit;
		$config['total_rows'] = $this->cocktail_model->get_cocktail_comments_count($cocktail_id);
	
		$config['per_page'] = $limit;		
		$this->pagination->initialize($config);		
		$data['page_link'] = $this->pagination->create_links();
		
		
		$data["site_setting"] = site_setting();
	
		$pageTitle = 'Cocktail-Comment';
		$metaDescription= 'Cocktail-Comment';
		$metaKeyword= 'Cocktail-Comment';
		
		$data["cocktail_comment"] = $this->cocktail_model->get_cocktail_comments($cocktail_id,$limit,$offset);
		$data["cocktail_detail"] = $this->cocktail_model->get_one_cocktail($cocktail_id);
		$data["cocktail_subcomment"] = $this->cocktail_model->get_cocktail_subcomments($cocktail_id);
		echo $this->load->view($theme .'/cocktail/cocktail_comment_ajax',$data,TRUE);
	}	 

	function add_rating()
	{
  		$data = $_POST;
	  	$data["date_added"] = date("Y-m-d H:i:s");
	  	$this->db->insert("cocktail_comment",$data);
	 	$id = mysql_insert_id();	 
	 	echo get_cocktail_rating($_POST["cocktail_id"]);
	// echo $id;
  	}
	function cocktail_likes($cid = 0){
			if(!check_user_authentication())
			{
				$this->session->set_userdata("REDIRECT_PAGE","cocktail/cocktail_detail/".base64_encode($cid));
				redirect("home/login");
			}
		$data = $_POST;
		$data["date_added"] = date("Y-m-d H:i:s");
		if($_POST['like_flag']==2){
			
			$checkbeerentry = checkCocktailEntryAlready($_POST['cocktail_id'],$_POST['user_id']);
			
			if($checkbeerentry==0)
			{
			$data['like_flag']=1;
			$this->db->insert("all_likes",$data);
			$profile = "";
			echo $cnt_like = cocktail_like_checker($_POST['cocktail_id'],$_POST['user_id']);		
			$data['user_id'] = $this->cocktail_model->one_cocktail_likers($_POST['user_id']);
			if($data['user_id']!="" && $data['user_id']->profile_image){
				$profile = $data['user_id']->profile_image;
				echo '*<li id="user_'.$_POST['user_id'].'" class="active"><a href="'.site_url('user/profile/'.base64_encode(get_authenticateUserID())).'"><img src="'.base_url().'upload/user_thumb/'.$profile.'" class="user_img"/>';
			}
			else{
				echo '*<li id="user_'.$_POST['user_id'].'" class="active"><a href="'.site_url('user/profile/'.base64_encode(get_authenticateUserID())).'"><img src="'.base_url().'upload/user_thumb/no_img.png" class="user_img"/>';
			}
			}
			else {
				$data['like_flag']=1;
			$this->db->where("cocktail_id",$_POST['cocktail_id']);
			$this->db->where("cocktail_comment_id",0);
			$this->db->where("user_id",get_authenticateUserID());
			$this->db->update("all_likes",$data);
			$profile = "";
			echo $cnt_like = cocktail_like_checker($_POST['cocktail_id'],$_POST['user_id']);		
			$data['user_id'] = $this->cocktail_model->one_cocktail_likers($_POST['user_id']);
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
			$this->db->where("cocktail_id",$_POST['cocktail_id']);
			$this->db->where("cocktail_comment_id",0);
			$this->db->where("user_id",get_authenticateUserID());
			$this->db->update("all_likes",$data_update);
			echo $cnt_like = cocktail_like_checker($_POST['cocktail_id'],get_authenticateUserID());
			$profile = "";
			if($cnt_like ==0){
				echo '*user_'.get_authenticateUserID();
			}
			else{
				$data['user_id'] = $this->cocktail_model->one_cocktail_likers(get_authenticateUserID());
				if($data['user_id']!=""){
					$profile = $data['user_id']->profile_image;
					if($profile!=""){
						echo '*<li id="user_'.get_authenticateUserID().'" class="active"><a href="'.site_url('user/profile/'.base64_encode(get_authenticateUserID())).'"><img src="'.base_url().'upload/user_thumb/'.$profile.'" class="user_img"/>';
					}
					else{
						echo '*<li id="user_'.get_authenticateUserID().'" class="active"><a href="'.site_url('user/profile/'.base64_encode(get_authenticateUserID())).'"><img src="'.base_url().'upload/user_thumb/no_img.png" class="user_img"/>';
					}
				}
			}			
		}	  	
	}
	
	
	function cocktail_fav($cid = 0){
			if(!check_user_authentication())
			{
				$this->session->set_userdata("REDIRECT_PAGE","cocktail/cocktail_detail/".base64_encode($cid));
				redirect("home/login");
			}
		$data = $_POST;
		$data["date_added"] = date("Y-m-d H:i:s");
		if($_POST['fav_flag']==2){
			$checkbeerentry = checkCocktailEntryAlready($_POST['cocktail_id'],$_POST['user_id']);
			
			if($checkbeerentry==0)
			{
			$data['fav_flag']=1;
			$this->db->insert("all_likes",$data);
			$profile = "";
			echo $cnt_fav = cocktail_fav_checker($_POST['cocktail_id'],$_POST['user_id']);		
			$data['user_id'] = $this->cocktail_model->one_cocktail_likers($_POST['user_id']);
			if($data['user_id']!=""){
				$profile = $data['user_id']->profile_image;
				echo '*<li id="user_'.$_POST['user_id'].'" class="active"><a href="#"><img src="'.base_url().'upload/user_thumb/'.$profile.'" class="user_img"/>';
			}
			else{
				echo '*<li id="user_'.$_POST['user_id'].'" class="active"><a href="#"><img src="'.base_url().'upload/user_thumb/no_img.png" class="user_img"/>';
			}
			}
			else {
				$data['fav_flag']=1;
			$this->db->where("cocktail_id",$_POST['cocktail_id']);
			$this->db->where("user_id",get_authenticateUserID());
			$this->db->update("all_likes",$data);
			$profile = "";
			echo $cnt_fav = cocktail_fav_checker($_POST['cocktail_id'],$_POST['user_id']);		
			$data['user_id'] = $this->cocktail_model->one_cocktail_likers($_POST['user_id']);
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
			$data_update = array("fav_flag"=>$_POST['fav_flag']);
			$this->db->where("cocktail_id",$_POST['cocktail_id']);
			$this->db->where("user_id",get_authenticateUserID());
			$this->db->update("all_likes",$data_update);
			echo $cnt_fav = cocktail_fav_checker($_POST['cocktail_id'],get_authenticateUserID());
			$profile = "";
			if($cnt_fav ==0){
				echo '*user_'.get_authenticateUserID();
			}
			else{
				$data['user_id'] = $this->cocktail_model->one_cocktail_likers(get_authenticateUserID());
				if($data['user_id']!=""){
					$profile = $data['user_id']->profile_image;
					if($profile!=""){
						echo '*<li id="user_'.get_authenticateUserID().'" class="active"><a href="#"><img src="'.base_url().'upload/user_thumb/'.$profile.'" class="user_img"/>';
					}
					else{
						echo '*<li id="user_'.get_authenticateUserID().'" class="active"><a href="#"><img src="'.base_url().'upload/user_thumb/no_img.png" class="user_img"/>';
					}
				}
			}			
		}	  	
	}
	
  	function update_totalviews()
	{
	    $view = $_REQUEST["view"];
		$qry = $this->db->query("update ".$this->db->dbprefix("video")." set total_views = total_views + 1 where video_id = '".$view."' ");	
	}
	
	function add_comment($cid=0){
		if(!check_user_authentication())
		{
			$this->session->set_userdata("REDIRECT_PAGE","cocktail/cocktail_detail/".base64_encode($cid));
			redirect("home/login");
		}
			
	$erro_str = '';
		if($_POST["comment_title"] == '')
		{
			  $erro_str .=  "<p>Comment title is required</p>";
		}
		
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
		
		$cmt_id = $this->cocktail_model->insert_comment($_POST);		
		//echo "Your comment added successfully";
		$latest_comment = cocktail_latest_comment($_POST['cocktail_id'],$cmt_id);
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
								$vget =  '<iframe style="width:702px; height:250px;" class="br_red img-responsive max-height embed_vid_height"  src="//www.youtube.com/embed/'.$id.'?rel=0" frameborder="0" allowfullscreen></iframe>';
							}else{
								$vget = $url;
							}
				    } elseif (strpos($url, 'vimeo') > 0) {
				    	preg_match('~^http://(?:www\.)?vimeo\.com/(?:clip:)?(\d+)~',$url,$matches);
				//	$parsed = parse_url($url);
					//print_r($parsed);
				       if(isset($matches[1])){
							$id = $matches[1];
							$vget = '<iframe style="width:702px; height:250px;" src="//player.vimeo.com/video/'.$id.'" class="br_red img-responsive max-height embed_vid_height" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> ';	
								
							}else{
								$a=json_decode(file_get_contents('http://vimeo.com/api/oembed.json?url='.$url));
								
								if(isset($a->video_id) && $a->video_id!=''){
								$id=$a->video_id;
									$vget = '<iframe style="width:702px; height:250px;" src="//player.vimeo.com/video/'.$id.'" class="br_red img-responsive max-height embed_vid_height" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> ';	
								}
							}
				    }
				    }
		$latest_comment->testdd= $vget;		
		$res =  json_encode($latest_comment);
		echo $res;
	}
	function add_subcomment($cid = 0){	
		if(!check_user_authentication())
		{
			$this->session->set_userdata("REDIRECT_PAGE","cocktail/cocktail_detail/".base64_encode($cid));
			redirect("home/login");
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
		
		$cmt_id = $this->cocktail_model->insert_subcomment($_POST);
		$cocktail_latest_comment = cocktail_latest_comment($_POST['cocktail_id'],$cmt_id);
		$cocktail_latest_comment->cust_date = date('d M',strtotime($cocktail_latest_comment->date_added));
	    $cocktail_latest_comment->date_duration = getDuration($cocktail_latest_comment->date_added); 
		$cocktail_latest_comment->testdd='config={"playlist":[{"url":"'.base_url().'upload/comment_video/'.$cocktail_latest_comment->comment_video.'","autoPlay":false}]}';		

		if($cocktail_latest_comment->profile_image == "" || !is_file(base_path()."upload/user_thumb/".$cocktail_latest_comment->profile_image))
		{
			$cocktail_latest_comment->profile_image = "no_img.png";
		}		
		$res2 = json_encode($cocktail_latest_comment);
		echo $res2;
	}
	function cocktail_comment_likes($cid =0){
	// if(!check_user_authentication())
		// {
			// $this->session->set_userdata("REDIRECT_PAGE","cocktail/cocktail_detail/".base64_encode($cid));
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
			$total_single = $this->cocktail_model->single_comment_total_likes($_POST['cocktail_id'],$_POST['cocktail_comment_id']);
			$find_flag = $this->cocktail_model->flag_return($_POST['cocktail_id'],$_POST['user_id'],$_POST['cocktail_comment_id']);
			if($find_flag==0){
				$find_flags=1;
			}
			if($find_flag==1){
				$find_flags=0;
			}
			echo $find_flags.'*'.$total_single;
			//echo $cnt_like = like_checker($_POST['cocktail_id'],$_POST['user_id']);			
			//$data['user_id'] = one_cocktail_likers($_POST['user_id'],$_POST['like_flag']);
		}
		else{
			$data_update = array("like_flag"=>$_POST['like_flag']);
			$this->db->where("cocktail_id",$_POST['cocktail_id']);
			$this->db->where("user_id",$_POST['user_id']);
			$this->db->where("cocktail_comment_id",$_POST['cocktail_comment_id']);
			$this->db->update("all_likes",$data_update);
		
			$total_single = $this->cocktail_model->single_comment_total_likes($_POST['cocktail_id'],$_POST['cocktail_comment_id']);
			$find_flag = $this->cocktail_model->flag_return($_POST['cocktail_id'],$_POST['user_id'],$_POST['cocktail_comment_id']);
			if($find_flag==0){
				$find_flags=1;
			}
			if($find_flag==1){
				$find_flags=0;
			}
			echo $find_flags.'*'.$total_single;
		}
		//$this->db->insert("all_likes",$data);
		//echo $cnt_like = like_checker($_POST['cocktail_id'],$_POST['user_id']);			
	}
	function remove_subcomment(){
		$cocktail_comment_id = $_POST['cocktail_comment_id'];
		$this->cocktail_model->sub_comment_remove($cocktail_comment_id);
		echo $cocktail_comment_id;
	}

function actioncocktailfav()
	{
		$cocktail_id =$this->input->post('chk');
			foreach($cocktail_id as $id)
			{			
				$data_update = array("fav_flag"=>0);
				$this->db->where("cocktail_id",$id);
				$this->db->where("user_id",get_authenticateUserID());
				$this->db->update("all_likes",$data_update);
			}
		$res=array('status'=>'done');
		echo json_encode($res);die;
	}
	
	function deletefavcocktail()
	{
			$data_update = array("fav_flag"=>0);
			$this->db->where("cocktail_id",$_POST['id']);
			$this->db->where("user_id",get_authenticateUserID());
			$this->db->update("all_likes",$data_update);
	}
	
	function view_all_likers()
	{
		$html = '';
		$bar_liker = $this->cocktail_model->get_all_cocktail_likers($this->input->post('id'));
		$html .= "<div class='padtb10'><div class='container'><div class='result_box clearfix mar_top30bot20'><div class='login_block br_green_yellow'><div class='result_search'><button aria-hidden='true' data-dismiss='modal' class='close' type='button'>×</button>
	     				<i class='strip login_icon'></i><div class='result_search_text'>Cocktail Likers</div></div><div class='pad20'><div id='ajax_msg_error_reg'></div><ul class='likeduser marl_0'>";	
		
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
		$html .= "<span class='result_search_text'>No any cocktail likers found .</span>";
	}
        
		$html .= "</ul><div class='clear'></div></div></div></div></div></div>";
		print_r($html);
		die;
	}
	
	function auto_suggest_cocktail()
	{
		$operator_list 	 = $this->cocktail_model->auto_suggest_cocktail($_REQUEST['em']);
		$arr = array();	
		if($operator_list){
		foreach($operator_list as $key=>$val){
			$arr[] = array("id"=>$val['cocktail_id'],"label"=>$val['cocktail_name'],"value"=>$val['cocktail_name']); 
		}
		}
		print_r(json_encode($arr));die;
	}
}
?>