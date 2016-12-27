<?php
class Banner_pages extends CI_Controller {

	function Banner_pages() {
		parent::__construct();
		$this -> load -> model('banner_pages_model');
	}

	/*** site setting home page
	 **/
	function index() {
		redirect('banner_pages/add_banner_pages');
	}

	/** admin site setting display and update function
	 * var integer $site_setting_id
	 * var integer $site_online
	 * var integer $captcha_enable
	 * var string $site_name
	 * var integer $site_version
	 * var integer $site_language
	 * var string $currency_code
	 * var string $date_format
	 * var string $time_format
	 * var string $date_time_format
	 * var string $site_tracker
	 * var text $how_it_works_video
	 * var integer $zipcode_min
	 * var integer $zipcode_max
	 * var string $error
	 **/
	function add_banner_pages($msg='') {
		
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		$check_rights=get_rights('add_banner_pages');
				
		if(	$check_rights==0) {			
			redirect('home/dashboard/no_rights');	
		}
		$data = array();
		$theme = getThemeName();
		$this -> template -> set_master_template($theme . '/template.php');
        $this->load->library('form_validation');
		$data['error'] = '';
		$data['msg'] = $msg;
		$video_error = '';		
		
		
			    $banner_pages = banner_pages();
				$data["banner_pages_id"] = $banner_pages -> banner_pages_id;
				$data["prev_bar_banner_find"] = $banner_pages -> find_bar;
				$data["prev_beer_banner_find"] = $banner_pages -> beer_directory;
				$data["prev_liquor_banner_find"] = $banner_pages -> liqur_directory;
				$data["prev_resource_banner_find"] = $banner_pages -> resource_directory;
				$data["prev_cocktail_banner_find"] = $banner_pages -> cocktail_directory;
				$data["prev_suggest_bar_banner_find"] = $banner_pages -> suggest_bar;
				$data["prev_contact_us_banner_find"] = $banner_pages -> contact_us;
				
				$data["prev_gallery_banner_find"] = $banner_pages -> photo_gallery;
				
				$data["prev_taxi_banner_find"] = $banner_pages -> taxi_directory;
				$data["prev_media_banner_find"] = $banner_pages -> media;
				$data["prev_forum_banner_find"] = $banner_pages -> forum;
				$data["prev_article_banner_find"] = $banner_pages -> article;
				$data["prev_trivia_banner_find"] = $banner_pages -> trivia;
				
				$data["find_bar_state"] = $banner_pages -> find_bar_state;
				$data["beer_directory_state"] = $banner_pages -> beer_directory_state;
				$data["liqur_directory_state"] = $banner_pages -> liqur_directory_state;
				$data["resource_directory_state"] = $banner_pages -> resource_directory_state;
				$data["cocktail_directory_state"] = $banner_pages -> cocktail_directory_state;
				$data["suggest_bar_state"] = $banner_pages -> suggest_bar_state;
				$data["contact_us_state"] = $banner_pages -> contact_us_state;
				$data["photo_gallery_state"] = $banner_pages -> photo_gallery_state;
				$data["media_state"] = $banner_pages -> media_state;
				$data["forum_state"] = $banner_pages -> forum_state;
				$data["taxi_directory_state"] = $banner_pages -> taxi_directory_state;
				$data["find_article_state"] = $banner_pages -> find_article_state;
				$data["find_trivia_state"] = $banner_pages -> find_trivia_state;
				 
				
		if ($_POST) {
			
			if(isset($_FILES['find_bar']) && $_FILES["find_bar"]["name"] != ""){
				
			$tmpName = $_FILES['find_bar']['tmp_name'];
			
				
				list($width, $height, $type, $attr) = getimagesize($tmpName);
			
			if($width < 1140 || $height < 237)
			{
				
				   $video_error .= "<p>Bar Banner size must be greater than 1140px by 237px.</p>";
			}
		  }
		  
		  if(isset($_FILES['find_trivia']) && $_FILES["find_trivia"]["name"] != ""){
				
			$tmpName = $_FILES['find_trivia']['tmp_name'];
			
				
				list($width, $height, $type, $attr) = getimagesize($tmpName);
			
			if($width < 1140 || $height < 415)
			{
				
				   $video_error .= "<p>Bar Banner size must be greater than 1140px by 415px.</p>";
			}
		  }
			
			if(isset($_FILES['find_beer']) && $_FILES["find_beer"]["name"] != ""){
			$tmpName = $_FILES['find_beer']['tmp_name'];
			
				
				list($width, $height, $type, $attr) = getimagesize($tmpName);
			
			if($width < 1140 || $height < 237)
			{
				
				   $video_error .= "<p>Beer Directory Banner size must be greater than 1140px by 237px.</p>";
			}
		  }
		  
		  if(isset($_FILES['find_cocktail']) && $_FILES["find_cocktail"]["name"] != ""){
			$tmpName = $_FILES['find_cocktail']['tmp_name'];
			
				
				list($width, $height, $type, $attr) = getimagesize($tmpName);
			
			if($width < 1140 || $height < 237)
			{
				
				   $video_error .= "<p>Cocktail Directory Banner size must be greater than 1140px by 237px.</p>";
			}
		  }
		  
		  if(isset($_FILES['find_suggest_bar']) && $_FILES["find_suggest_bar"]["name"] != ""){
			$tmpName = $_FILES['find_suggest_bar']['tmp_name'];
			
				
				list($width, $height, $type, $attr) = getimagesize($tmpName);
			
			if($width < 1140 || $height < 237)
			{
				
				   $video_error .= "<p>Suggest Bar Banner size must be greater than 1140px by 237px.</p>";
			}
		  }
			
			if(isset($_FILES['find_contact_us']) && $_FILES["find_contact_us"]["name"] != ""){
			$tmpName = $_FILES['find_contact_us']['tmp_name'];
			
				
				list($width, $height, $type, $attr) = getimagesize($tmpName);
			
			if($width < 1140 || $height < 237)
			{
				
				   $video_error .= "<p>Contact Us Banner size must be greater than 1140px by 237px.</p>";
			}
		  }
			
			if(isset($_FILES['find_gallery']) && $_FILES["find_gallery"]["name"] != ""){
			$tmpName = $_FILES['find_gallery']['tmp_name'];
			
				
				list($width, $height, $type, $attr) = getimagesize($tmpName);
			
			if($width < 1140 || $height < 237)
			{
				
				   $video_error .= "<p>Galle Banner size must be greater than 1140px by 237px.</p>";
			}
		  }
			
			if(isset($_FILES['find_media']) && $_FILES["find_media"]["name"] != ""){
			$tmpName = $_FILES['find_media']['tmp_name'];
			
				
				list($width, $height, $type, $attr) = getimagesize($tmpName);
			
			if($width < 1140 || $height < 237)
			{
				
				   $video_error .= "<p>Media Banner size must be greater than 1140px by 237px.</p>";
			}
		  }
			
			if(isset($_FILES['find_forum']) && $_FILES["find_forum"]["name"] != ""){
			$tmpName = $_FILES['find_forum']['tmp_name'];
			
				
				list($width, $height, $type, $attr) = getimagesize($tmpName);
			
			if($width < 1140 || $height < 237)
			{
				
				   $video_error .= "<p>Forum Banner size must be greater than 1140px by 237px.</p>";
			}
		  }

		if(isset($_FILES['find_liquor']) && $_FILES["find_liquor"]["name"] != ""){
			$tmpName = $_FILES['find_liquor']['tmp_name'];
			
				
				list($width, $height, $type, $attr) = getimagesize($tmpName);
			
			if($width < 1140 || $height < 237)
			{
				
				   $video_error .= "<p>Liquor Banner size must be greater than 1140px by 237px.</p>";
			}
		  }

		if(isset($_FILES['find_taxi']) && $_FILES["find_taxi"]["name"] != ""){
			$tmpName = $_FILES['find_taxi']['tmp_name'];
			
				
				list($width, $height, $type, $attr) = getimagesize($tmpName);
			
			if($width < 1140 || $height < 237)
			{
				
				   $video_error .= "<p>Taxi Banner size must be greater than 1140px by 237px.</p>";
			}
		  }
		
		if(isset($_FILES['find_resource']) && $_FILES["find_resource"]["name"] != ""){
			$tmpName = $_FILES['find_resource']['tmp_name'];
			
				
				list($width, $height, $type, $attr) = getimagesize($tmpName);
			
			if($width < 1140 || $height < 237)
			{
				
				   $video_error .= "<p>Resource Banner size must be greater than 1140px by 237px.</p>";
			}
		  }
				if($video_error != ""){
			if ($video_error != "")
			{
				$data["error"] = $video_error;
			}else{
				$data["error"] = "";
			}
			
				}
				else {
					
					
					    $this -> banner_pages_model -> banner_pages_update();
						redirect('banner_pages/test');
									}
			
		  }   



			$data['site_setting'] = site_setting();
			
			$data['page_name']="usercls";
			$this -> template -> write_view('header_menu', $theme . '/layout/common/header', $data, TRUE);
			$this -> template -> write_view('left', $theme . '/layout/common/sidebar', $data, TRUE);
			$this -> template -> write_view('center', $theme . '/layout/setting/add_banner', $data, TRUE);
			$this -> template -> write_view('footer', $theme . '/layout/common/footer', $data, TRUE);
			$this -> template -> render();
		
	}
   
   function test()
   {
   
   	redirect('banner_pages');
   }
	

	

}
?>