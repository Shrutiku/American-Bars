<?php
date_default_timezone_set("Europe/London");
class Image_setting extends CI_Controller {


	function Image_setting()
	{
		parent::__construct();	
		$this->load->model('image_setting_model');
	}
	

	function index()
	{
		redirect('image_setting/add_image_setting');	
	}
	
	// Use :This function use for add Or Update Image Setting.
	// Param :'N/A'
	// Return :'N/A'
	function add_image_setting()
	{
		if(!check_admin_authentication())
		{
			redirect('home');
		}
		
		$data = array();
		$theme = getThemeName();
		$this->template->set_master_template($theme .'/template.php');
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user_width', 'User image width', 'required|numeric');
		$this->form_validation->set_rules('user_height', 'User image height', 'required|numeric');
		$this->form_validation->set_rules('image_width', 'Image width', 'required|numeric');
		$this->form_validation->set_rules('image_height', 'Image height', 'required|numeric');
		
		$this->form_validation->set_rules('beer_width', 'Beer Width', 'required|numeric');
		$this->form_validation->set_rules('beer_height', 'Beer height', 'required|numeric');
		$this->form_validation->set_rules('event_width', 'Beer Width', 'required|numeric');
		$this->form_validation->set_rules('event_height', 'Beer height', 'required|numeric');
		$this->form_validation->set_rules('photo_gallery_width', 'Photo Gallery Width', 'required|numeric');
		$this->form_validation->set_rules('photo_gallery_height', 'Photo Gallery height', 'required|numeric');
		$this->form_validation->set_rules('cocktail_width', 'Cocktail Width', 'required|numeric');
		$this->form_validation->set_rules('cocktail_height', 'Cocktail height', 'required|numeric');		
		$this->form_validation->set_rules('banner_width', 'Banner Width', 'required|numeric');
		$this->form_validation->set_rules('banner_height', 'Banner height', 'required|numeric');
		$this->form_validation->set_rules('comment_image_width', 'Comment Image Width', 'required|numeric');
		$this->form_validation->set_rules('comment_image_height', 'Comment Image Height', 'required|numeric');
	
		$data['page_name']="add_image_setting";
		
		
		if($this->form_validation->run() == FALSE){			
			if(validation_errors())
			{
				$data["error"] = validation_errors();
			}else{
				$data["error"] = "";
			}
			if($this->input->post('image_setting_id'))
			{
				$one_image_setting = image_setting(); 
				
				$data["image_setting_id"] = $this->input->post('image_setting_id');
				$data["user_width"] = $this->input->post('user_width');
				$data["user_height"] = $this->input->post('user_height');
				$data["image_width"] = $this->input->post('image_width');
				$data["image_height"] = $this->input->post('image_height');
				
				$data["beer_width"] = $this->input->post('beer_width');
				$data["beer_height"] = $this->input->post('beer_height');
				$data["event_width"] = $this->input->post('event_width');
				$data["event_height"] = $this->input->post('event_height');
				$data["photo_gallery_width"] = $this->input->post('photo_gallery_width');
				$data["photo_gallery_height"] = $this->input->post('photo_gallery_height');
				$data["cocktail_width"] = $this->input->post('cocktail_width');
				$data["cocktail_height"] = $this->input->post('cocktail_height');
				$data["banner_width"] = $this->input->post('banner_width');
				$data["banner_height"] = $this->input->post('banner_height');
				$data["comment_image_width"] = $this->input->post('comment_image_width');
				$data["comment_image_height"] = $this->input->post('comment_image_height');
					
			}else{
				$one_image_setting = image_setting(); 

				$data["image_setting_id"] = $one_image_setting->image_setting_id;
				$data["user_width"] = $one_image_setting->user_width;
				$data["user_height"] = $one_image_setting->user_height;
				$data["image_width"] = $one_image_setting->image_width;
				$data["image_height"] = $one_image_setting->image_height;
				
				$data["beer_width"] = $one_image_setting->beer_width;
				$data["beer_height"] =$one_image_setting->beer_height;
				$data["event_width"] =$one_image_setting->event_width;
				$data["event_height"] = $one_image_setting->event_height;
				$data["photo_gallery_width"] = $one_image_setting->photo_gallery_width;
				$data["photo_gallery_height"] = $one_image_setting->photo_gallery_height;
				$data["cocktail_width"] = $one_image_setting->cocktail_width;
				$data["cocktail_height"] = $one_image_setting->cocktail_height;
				$data["banner_width"] = $one_image_setting->banner_width;
				$data["banner_height"] = $one_image_setting->banner_height;
				$data["comment_image_width"] = $one_image_setting->comment_image_width;
				$data["comment_image_height"] = $one_image_setting->comment_image_height;
				
				
			}
			$data['image_setting'] = image_setting(); 
			
			$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/setting/add_image_setting',$data,TRUE);
	   	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);
			$this->template->render();
		}else{
				$this->image_setting_model->image_setting_update();
				$one_image_setting = image_setting(); 
				
				$data["error"] = "update";
				$data["image_setting_id"] = $this->input->post('image_setting_id');
				$data["user_width"] = $this->input->post('user_width');
				$data["user_height"] = $this->input->post('user_height');
				$data["image_width"] = $this->input->post('image_width');
				$data["image_height"] = $this->input->post('image_height');
				
				$data["beer_width"] = $this->input->post('beer_width');
				$data["beer_height"] = $this->input->post('beer_height');
				$data["event_width"] = $this->input->post('event_width');
				$data["event_height"] = $this->input->post('event_height');
				$data["photo_gallery_width"] = $this->input->post('photo_gallery_width');
				$data["photo_gallery_height"] = $this->input->post('photo_gallery_height');
				$data["cocktail_width"] = $this->input->post('cocktail_width');
				$data["cocktail_height"] = $this->input->post('cocktail_height');
				$data["banner_width"] = $this->input->post('banner_width');
				$data["banner_height"] = $this->input->post('banner_height');
				$data["comment_image_width"] = $this->input->post('comment_image_width');
				$data["comment_image_height"] = $this->input->post('comment_image_height');

				$data['image_setting'] = image_setting();
				
			$this->template->write_view('header_menu',$theme .'/layout/common/header',$data,TRUE);
	   	    $this->template->write_view('left',$theme .'/layout/common/sidebar',$data,TRUE);
			$this->template->write_view('center',$theme .'/layout/setting/add_image_setting',$data,TRUE);
			$this->template->write_view('footer',$theme .'/layout/common/footer',$data,TRUE);

			$this->template->render();
		}				
	}
	
	
}
?>