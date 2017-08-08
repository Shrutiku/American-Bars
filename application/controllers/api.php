<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'/libraries/REST_Controller.php');
require_once(APPPATH . 'libraries/Twilio/autoload.php');
require_once(APPPATH . 'libraries/Twilio/Rest/Client.php');

use Twilio\Rest\Client as TwilioClient;
 
class Api extends REST_Controller
{
    
    function Api()
    {
        parent::__construct();  
        $this->load->model('home_model');
		$this->load->model('api_model');
    }
    
    function checklogin_post()
    {
    	//$email = "php.viral@spaculus.info";//$this->input->post('email');
        //$pass = "a@12345678";//$this->input->post('password');
        $email = $this->input->post('email');
        $pass = $this->input->post('password');
        $data = $this->api_model->check_api_login($email,$pass);
        $this->response($data ,200);
    }
    
    function user_phone_login_post()
    {
    	//$email = "php.viral@spaculus.info";//$this->input->post('email');
        //$pass = "a@12345678";//$this->input->post('password');
        $phone_str = $this->input->post('phone');
        $phone_dash = filter_var($phone_str, FILTER_SANITIZE_NUMBER_INT);
        $phone = str_replace(array('+','-', '.'), '', $phone_dash);        
        $pass = $this->input->post('activation_code');
        $data = $this->api_model->check_api_phone_login($phone,$pass);
        $this->response($data ,200);
    }
    
    function user_phone_check_post()
    {
        $phone_str = $this->input->post('phone');
        $phone_dash = filter_var($phone_str, FILTER_SANITIZE_NUMBER_INT);
        $phone = str_replace(array('+','-', '.'), '', $phone_dash);
        $num	=	$this->db->select('count(user_id) AS total')
                                         ->where("phone_no",$phone)
                                         ->where("user_type",'user')
                                         ->get("user_master")
                                         ->row()
                                         ->total; 
        
        $data['status'] = $num == 0 ? "unregistered" : "registered";   
        $this->response($data ,200);   	
    }
    
    function user_register_post()
	{
			$num	=	$this->db->select('count(user_id) AS total')
							 ->where("email",$this->input->post('email'))
							 ->where("user_type",'user')
							 ->get("user_master")
							 ->row()
							 ->total;
			
			
			if($num > 0) {
				$data['status'] = "unique_failed"; 
				$this->response($data ,200);
			}
			
			$start = strtotime($this->input->post('year').'-'.$this->input->post('month').'-'.$this->input->post('day'));
	        $dt = date('Y-m-d');
	        $end = strtotime($dt.'-21 year'); 
			if($start >= $end)
			{
	              $data['status'] = "age_failed"; 
				  $this->response($data ,200);
			}
        	$first_name = $this->input->post('first_name');
			$last_name = $this->input->post('last_name');
        	$email = $this->input->post('email');
			$nick_name = $this->input->post('nick_name');
			$pass = $this->input->post('password');
			$mobile_no = $this->input->post('mobile_no'); 
			$month = $this->input->post('month'); 
			$day = $this->input->post('day'); 
			$year = $this->input->post('year'); 
			$gender = $this->input->post('gender'); 
        	
			//$data = $this->api_model->user_register_api($user_type,$first_name,$last_name,$email,$pass,$mobile_no);
			$data = $this->api_model->user_register_api($first_name,$last_name,$email,$pass,$mobile_no,$nick_name,$month,$day,$year,$gender);
        	$this->response($data ,200);
			
	}
	
	function user_phone_activate_post()
	{
            $phone_str = $this->input->post('phone');
            $phone_dash = filter_var($phone_str, FILTER_SANITIZE_NUMBER_INT);
            $phone = str_replace(array('+','-', '.'), '', $phone_dash);
            $num	=	$this->db->select('count(user_id) AS total')
                                             ->where("phone_no",$phone)
                                             ->where("user_type",'user')
                                             ->get("user_master")
                                             ->row()
                                             ->total;          

            if($num == 0) { 
                $first_name = "not given"; // $this->input->post('first_name'); //"NOTZERO";
                $last_name = "not given"; // $this->input->post('last_name');
            
                $data = $this->api_model->user_phone_register_api($first_name,$last_name,$phone);
            }
            else
            {
                $this->load->model('user_model');
                
                $user = $this->user_model->get_one_user_by_phone($phone);

                if ($user && $user['user_id'])
                {
                    $data['user_id'] = $user['user_id']; 
                    $data['status']= 'success';
                    
                    if ($this->input->post('first_name')) {
                        $name_update = array ( 
                            'first_name'=> $this->input->post('first_name'), 
                            'last_name'=> $this->input->post('last_name')
                                );

                        $this->db->where('user_name',$phone);
                        $this->db->update('user_master',$name_update);

                        $data['first_name'] = $name_update['first_name'];
                        $data['last_name'] = $name_update['last_name'];

                        $this->response($data ,200);
                    }
                    
                }
                
//                if($user && $user['first_name'] && ($user['first_name'] === "not given")) {
//                if($user) {
//                    $name=array(
//                        $first_name = "direct input works", //; //$this->input->post('first_name'); //"test";
//                        $last_name = $this->input->post('last_name')
//                            );
//
////                    $this->api_model->user_phone_update_name_api($first_name,$last_name,$phone);
////                    $user->user_model->update_name($name);
//                    $data['user'] = $user;
//                    $data['first_name'] = $this->input->post('first_name');
//                    $data['last_name'] = $this->input->post('last_name');
//
//                    $this->response($data ,200);
//
////                    return;
//                    }
            }
            
            if (!$data['user_id']) {
                $data['status']= 'failure';
                $this->response($data ,200);
            }
                        
            $account_sid = 'AC5d7f1511f026bd36a6d3eac9cb2a2d82';
            $auth_token = 'd79f765dae55cbf3755b261e6d47e222';
            $client = new TwilioClient($account_sid, $auth_token);
            $activation_code = rand(100000, 999999);
            $user_update = array('password' => md5($activation_code));
            $body = 'Here is your verification code for American Bars: ' . $activation_code;

            try {
                $client->account->messages->create($phone, array(
                    'from' => '+13102725642',
                    'body' => $body,
                        )
                );

                $this->db->where('user_id', $data['user_id']);
                $this->db->update('user_master', $user_update);
            } catch (Exception $e) {
                $data["error"] = "Connectivity Error";
            }
            
            $this->response($data ,200);			
	}
        
//        function user_update_names_post() {
//            
//            $phone_str = $this->input->post('phone');
//            $phone_dash = filter_var($phone_str, FILTER_SANITIZE_NUMBER_INT);
//            $phone = str_replace(array('+','-', '.'), '', $phone_dash);
//            $num	=	$this->db->select('count(user_id) AS total')
//                                             ->where("phone_no",$phone)
//                                             ->where("user_type",'user')
//                                             ->get("user_master")
//                                             ->row()
//                                             ->total;
//            
//            $first_name = $this->input->post('first_name'); //"NOTZERO";
//            $last_name = $this->input->post('last_name');
//
//            $data = $this->api_model->user_phone_update_name_api($first_name,$last_name,$phone);
//
//            $this->response($data ,200);
//        }

	function user_edit_post()
		{
			$num	=	$this->db->select('count(user_id) AS total')
							 ->where("email",$this->input->post('email'))
							 ->where("user_id !="  ,$this->input->post('user_id'))	
							 ->get("user_master")
							 ->row()
							 ->total;
			//echo $this->db->last_query(); die; 
			//print_r($num); die;				 	
			
			if($num > 0) {
				$data['status'] = "unique_failed"; 
				$this->response($data ,200);
			}
			
        	
			//$data = $this->api_model->user_register_api($user_type,$first_name,$last_name,$email,$pass,$mobile_no);
			$data = $this->api_model->user_edit_api();
        	$this->response($data ,200);
			
			
		}
	
	 function bar_categories_post()
    {
        $data = $this->api_model->getAllBarCategories();
		
        $this->response($data ,200);
    }
    
    function forget_password_post()
    {
    	$email = $this->input->post('email');
        $data = $this->api_model->forgot_password($email);
		
        $this->response($data ,200);
    }

    function change_password_post()
	{
		$password1 =md5 ($this->input->post('old_password'));
		$new_password1 =md5($this->input->post('new_password'));	
		$data = $this->api_model->change_password($password1,$new_password1);
		//$data['status'] = "success"; 
		$this->response($data ,200);
		
	}
	
	function bar_lists_post()
	{
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
				
		$limit = $this->input->post('limit');
		$offset = $this->input->post('offset');
		$state = $this->input->post('state');
		$city = $this->input->post('city');
		$zipcode = $this->input->post('zipcode');
		$bar_title = $this->input->post('title');
		$lat = $this->input->post('lat');
		$lang = $this->input->post('lang');
                $category = $this->input->post('category');
	
		$address_j = $this->input->post("address_j");
			$days = $this->input->post("days"); 
		
		$data['barlist'] = $this->api_model->getAllBar($sort_by,$sort_type,$limit,$offset,$state,$city,$zipcode,$bar_title,$lat,$lang,$category,$address_j,$days,'result');
		
		
		$data['barlist_total'] = $this->api_model->getAllBar($sort_by,$sort_type,$limit,$offset,$state,$city,$zipcode,$bar_title,$lat,$lang,$category,$address_j,$days,'total');
		$data['bar_happy_hours'] = $this->api_model->getAllBarHappyHours($sort_by,$sort_type,$limit,$offset,$state,$city,$zipcode,$bar_title,$lat,$lang,$address_j,$days,'result');
		$data['bar_events'] = $this->api_model->getAllbarEvents($sort_by,$sort_type,$limit,$offset,$state,$city,$zipcode,$bar_title,$lat,$lang,$address_j,$days,'result');
		
		
	    if($data)
        {
        	
        	$data["status"] = "success";
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
            $data["status"] = "fail";
            $this->response($data, 200);
        }
		
	}
	
	function beer_lists_post()
	{
		$bar_id = $this->input->post('bar_id');
		$limit = $this->input->post('limit');
		$offset = $this->input->post('offset');
		if($bar_id!=0 && $bar_id!='')
		{
			$bar_id = $bar_id;
		}
		else {
			$bar_id =0;
		}
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
					
		$keyword = $this->input->post("keyword"); 		
		$alpha = $this->input->post('alpha');
		$data['beerlist'] = $this->api_model->getAllBeer($sort_by,$sort_type,$limit,$offset,$keyword,$alpha,$bar_id,'result');
		$data['beerlist_total'] = $this->api_model->getAllBeer($sort_by,$sort_type,$limit,$offset,$keyword,$alpha,$bar_id,'total');
	    if($data['beerlist'])
        {
        	$data["status"] = "success";
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
        	$data["status"] = "fail";
            $this->response($data, 200);
        }
		
	}
	function cocktail_lists_post()
	{
		$bar_id = $this->input->post('bar_id');
		$limit = $this->input->post('limit');
		$offset = $this->input->post('offset');
		if($bar_id!=0 && $bar_id!='')
		{
			$bar_id = $bar_id;
		}
		else {
			$bar_id =0;
		}
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
		$keyword = $this->input->post("keyword"); 		
		$alpha = $this->input->post('alpha');
		$data["cocktaillist"] = $this->api_model->getAllCocktail($sort_by,$sort_type,$limit,$offset,$keyword,$alpha,$bar_id,'result');
		$data["cocktaillist_total"] = $this->api_model->getAllCocktail($sort_by,$sort_type,$limit,$offset,$keyword,$alpha,$bar_id,'total');
	    if($data)
        {
        	$data["status"] = "success";
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
           $data["status"] = "fail";
            $this->response($data, 200);
        }
		
	}
	
	function liquor_lists_post()
	{
		$bar_id = $this->input->post('bar_id');
		$limit = $this->input->post('limit');
		$offset = $this->input->post('offset');
		if($bar_id!=0 && $bar_id!='')
		{
			$bar_id = $bar_id;
		}
		else {
			$bar_id =0;
		}
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
		$keyword = $this->input->post("keyword"); 		
		$alpha = $this->input->post('alpha');
		$data["liquorlist"] = $this->api_model->getAllLiquor($sort_by,$sort_type,$limit,$offset,$keyword,$alpha,$bar_id,'result');
		$data["liquorlist_total"] = $this->api_model->getAllLiquor($sort_by,$sort_type,$limit,$offset,$keyword,$alpha,$bar_id,'total');
	    if($data)
        {
        	$data["status"] = "success";
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
            $data["status"] = "fail";
            $this->response($data, 200);
        }
		
	}
	
	function taxi_lists_post()
	{
		$limit = $this->input->post('limit');
		$offset = $this->input->post('offset');
		$order = explode("#",$this->input->post("order_by"));
			
			 
				if(isset($order[0]) && isset($order[1]))
				{
					 $sort_by = $order[0];
				     $sort_type = $order[1];	
				}
				else
				{
				     $sort_by = "taxi_id";
				     $sort_type = "desc";		
				}
		$keyword = $this->input->post("keyword"); 		
		$alpha = $this->input->post('alpha');
		
		$data['taxilist'] = $this->api_model->getAllTaxi($sort_by,$sort_type,$limit,$offset,$keyword,$alpha,'result');
		$data['taxilist_total'] = $this->api_model->getAllTaxi($sort_by,$sort_type,$limit,$offset,$keyword,$alpha,'total');
	    if($data)
        {
        	$data["status"] = "success";
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
            $data["status"] = "fail";
            $this->response($data, 200);
        }
		
	}
	
	function bar_details_post()
	{
		$bar_id = $this->input->post('bar_id');
		$user_id = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');
		$limit = $this->input->post('limit');
		$offset = $this->input->post('offset');
		$data['bardetails'] = $this->api_model->getBarDetails($bar_id,$user_id);
		$data['barreview'] = $this->api_model->getBarReview($bar_id,$limit,$offset);
		$data['beerserved'] = $this->api_model->getBeerServedAtBar($bar_id,$limit,$offset);
		$data['cocktailserved'] = $this->api_model->getCocktailServedAtBar($bar_id,$limit,$offset);
		$data['liquorserved'] = $this->api_model->getLiquorServedAtBar($bar_id,$limit,$offset);
		$data['getbargallery'] = $this->api_model->getBarGallery($bar_id);
		$data['barhours'] =  $this->api_model->getBarHours($bar_id);
//		$get_bar_hour = $this->api_model->get_bar_hour($bar_id);
                $get_bar_hour = $this->api_model->get_bar_happy_hour($bar_id);
		$data["barevent"] = $this->api_model->getBarEvent($bar_id,$limit,$offset);
		
		$data['get_bar_hour'] = array();
		
		if($get_bar_hour)
		{
			 foreach($get_bar_hour as $r)
			 {
//			 	  $v = $this->api_model->getHourByID($r['rand']);
                                  $v = $this->api_model->getHappyHourByRAND($r['rand']);
			 	  $data['get_bar_hour'][$r['rand']] = $v;
			 }
		}

 
		 if($data['bardetails'])
        {
        	$data["status"] = "success";
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
            $this->response(NULL, 404);
        }
		
	}
	
	function bar_likes_post()
	{
		//$data = $_POST;
		$bar_id = $this->input->post('bar_id');
		$user_id = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');
                $code = $this->input->post('code')=='' ? '0':$this->input->post('code');
		$data["date_added"] = date("Y-m-d H:i:s");
		
		$chk=$this->db->get_where('all_likes',array('bar_id'=>$bar_id,'user_id'=>$user_id));
		
		if($code == "adammightbestraight" || CheckAuth()){
		if($chk->num_rows()>0)
		{
				$arr=array();
				switch ($chk->row()->like_flag) {
					case '1':
						$data['like_flag']='0';
						break;
					case '0':
						$data['like_flag']='1';
						break;
				
			}
			
			$this->db->where("bar_id",$bar_id);
			$this->db->where("user_id",$user_id);
			$this->db->update("all_likes",$data);
		 	$data_m['status']='success';
			$data_m['message']=$data['like_flag'];
			//print_r($data_m);
			
		}
		else
		{
			$data['like_flag']=1;
			$this->db->insert("all_likes",$data);
			$data_m['status']='success';
			$data_m['message']= 1;
			//echo print_r($data_m);
		}
		}
		else {
			$data_m['status'] = 'login_required';
			$data_m['message'] = 'Login Required';
		}
		echo json_encode($data_m);
		exit ;	
		  	
	}
	
	function bar_favorite_post()
	{
		//$data = $_POST;
		$bar_id = $this->input->post('bar_id');
		$user_id = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
		$data["date_added"] = date("Y-m-d H:i:s");
		
		
		if(CheckAuth()){
		$chk=$this->db->get_where('all_likes',array('bar_id'=>$bar_id,'user_id'=>$user_id));
		if($chk->num_rows()>0)
		{
				$arr=array();
				switch ($chk->row()->bar_fav_flag) {
					case '1':
						$data['bar_fav_flag']='0';
						break;
					case '0':
						$data['bar_fav_flag']='1';
						break;
				
			}
			
			$this->db->where("bar_id",$bar_id);
			$this->db->where("user_id",$user_id);
			$this->db->update("all_likes",$data);
		 	$data_m['status']='success';
			$data_m['message']=$data['bar_fav_flag'];
			//print_r($data_m);
			
		}
		else
		{
			$data['bar_fav_flag']=1;
			$data['bar_id'] = $this->input->post('bar_id');
			$data['user_id'] = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
			$this->db->insert("all_likes",$data);
			$data_m['status']='success';
			$data_m['message']= 1;
			//echo print_r($data_m);
		}
		}
		else {
			$data_m['status'] = 'login_required';
			$data_m['message'] = 'Login Required';
		}
		echo json_encode($data_m);
		exit ;	
		  	
	}
    
	function beer_details_post()
	{
		$beer_id = $this->input->post('beer_id');
		$user_id = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
		$limit = $this->input->post('limit');
		$offset = $this->input->post('offset');
		$data["beer_detail"] = $this->api_model->getBeerDetails($beer_id,$user_id);
		$data['beercomments'] = $this->api_model->getBeerComments($beer_id,$limit,$offset,0);
		//$data['beersubcomments'] = $this->api_model->getBeerComments($beer_id,$limit,$offset,1);
		 if($data['beer_detail'])
        {
        	$data["status"] = "success";
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
            $this->response(NULL, 404);
        }
	}	
	
	function beer_likes_post()
	{
		//$data = $_POST;
		$beer_id = $this->input->post('beer_id');
		$user_id = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
		$data["date_added"] = date("Y-m-d H:i:s");
		
		
		$chk=$this->db->get_where('all_likes',array('beer_id'=>$beer_id,'user_id'=>$user_id));
		
		//echo $chk->num_rows(); 
		if(CheckAuth()){
			
		if($chk->num_rows()>0)
		{
			
				$arr=array();
				switch ($chk->row()->like_flag) {
					case '1':
						$data['like_flag']='0';
						break;
					case '0':
						$data['like_flag']='1';
						break;
				
			}
			
			$this->db->where("beer_id",$beer_id);
			$this->db->where("user_id",$user_id);
			$this->db->update("all_likes",$data);
		 	$data_m['status']='success';
			$data_m['message']=$data['like_flag'];
			//print_r($data_m);
			
		}
		else
		{
			$data['like_flag']=1;
			 
			$this->db->insert("all_likes",$data);
			$data_m['status']='success';
			$data_m['message']= 1;
			//echo print_r($data_m);
		}
		}
		else {
			$data_m['status'] = 'login_required';
			$data_m['message'] = 'Login Required';
		}
		echo json_encode($data_m);
		exit ;	
		  	
	}
	
	function beer_favorite_post()
	{
		//$data = $_POST;
		$beer_id = $this->input->post('beer_id');
		$user_id = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
		$data["date_added"] = date("Y-m-d H:i:s");
		$chk=$this->db->get_where('all_likes',array('beer_id'=>$beer_id,'user_id'=>$user_id));
		
		if(CheckAuth()){
		if($chk->num_rows()>0)
		{
				$arr=array();
				switch ($chk->row()->beer_fav_flag) {
					case '1':
						$data['beer_fav_flag']='0';
						break;
					case '0':
						$data['beer_fav_flag']='1';
						break;
				
			}
			
			$this->db->where("beer_id",$beer_id);
			$this->db->where("user_id",$user_id);
			$this->db->update("all_likes",$data);
		 	$data_m['status']='success';
			$data_m['message']=$data['beer_fav_flag'];
			//print_r($data_m);
			
		}
		else
		{
			$data['beer_fav_flag']=1;
			$data['beer_id'] = $this->input->post('beer_id');
			$data['user_id'] = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');
			$this->db->insert("all_likes",$data);
			$data_m['status']='success';
			$data_m['message']= 1;
			//echo print_r($data_m);
		}
		}
		else {
			$data_m['status'] = 'login_required';
			$data_m['message'] = 'Login Required';
		}
		echo json_encode($data_m);
		exit ;	
		  	
	}
	function cocktail_details_post()
	{
		$cocktail_id = $this->input->post('cocktail_id');
		$user_id = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
		$limit = $this->input->post('limit');
		$offset = $this->input->post('offset');
		
		$data["cocktail_detail"] = $this->api_model->getCocktailDetails($cocktail_id,$user_id);
		$data['cocktailcomments'] = $this->api_model->getCocktailComments($cocktail_id,$limit,$offset,0);
		//$data['cocktailsubcomments'] = $this->api_model->getCocktailComments($cocktail_id,$limit,$offset,1);
		 if($data['cocktail_detail'])
        {
        	$data["status"] = "success";
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
            $this->response(NULL, 404);
        }
	}
	
	function cocktail_likes_post()
	{
		//$data = $_POST;
		$cocktail_id = $this->input->post('cocktail_id');
		$user_id = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
		$data["date_added"] = date("Y-m-d H:i:s");
		
		$chk=$this->db->get_where('all_likes',array('cocktail_id'=>$cocktail_id,'user_id'=>$user_id));
		
		if(CheckAuth()){
		if($chk->num_rows()>0)
		{
				$arr=array();
				switch ($chk->row()->like_flag) {
					case '1':
						$data['like_flag']='0';
						break;
					case '0':
						$data['like_flag']='1';
						break;
				
			}
			
			$this->db->where("cocktail_id",$cocktail_id);
			$this->db->where("user_id",$user_id);
			$this->db->update("all_likes",$data);
		 	$data_m['status']='success';
			$data_m['message']=$data['like_flag'];
			//print_r($data_m);
			
		}
		else
		{
			$data['like_flag']=1;
			$data['cocktail_id'] = $this->input->post('cocktail_id');
			$data['user_id'] = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
			$this->db->insert("all_likes",$data);
			$data_m['status']='success';
			$data_m['message']= 1;
			//echo print_r($data_m);
		}
		}
		else {
			$data_m['status'] = 'login_required';
			$data_m['message'] = 'Login Required';
		}
		echo json_encode($data_m);
		exit ;	
		  	
	}
	
	function cocktail_favorite_post()
	{
		//$data = $_POST;
		$cocktail_id = $this->input->post('cocktail_id');
		$user_id = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
		$data["date_added"] = date("Y-m-d H:i:s");
		$chk=$this->db->get_where('all_likes',array('cocktail_id'=>$cocktail_id,'user_id'=>$user_id));
		
		if(CheckAuth()){
		if($chk->num_rows()>0)
		{
				$arr=array();
				switch ($chk->row()->fav_flag) {
					case '1':
						$data['fav_flag']='0';
						break;
					case '0':
						$data['fav_flag']='1';
						break;
				
			}
			
			$this->db->where("cocktail_id",$cocktail_id);
			$this->db->where("user_id",$user_id);
			$this->db->update("all_likes",$data);
		 	$data_m['status']='success';
			$data_m['message']=$data['fav_flag'];
			//print_r($data_m);
			
		}
		else
		{
			$data['fav_flag']=1;
				$data['cocktail_id'] = $this->input->post('cocktail_id');
			$data['user_id'] = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
			$this->db->insert("all_likes",$data);
			$data_m['status']='success';
			$data_m['message']= 1;
			//echo print_r($data_m);
		}
		}
		else {
			$data_m['status'] = 'login_required';
			$data_m['message'] = 'Login Required';
		}
		echo json_encode($data_m);
		exit ;	
		  	
	}
	
	function liquor_details_post()
	{
		$liquor_id = $this->input->post('liquor_id');
		$user_id = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
		$limit = $this->input->post('limit');
		$offset = $this->input->post('offset');
		
		$data["liquor_detail"] = $this->api_model->getLiquorDetails($liquor_id,$user_id);
		$data['liquorcomments'] = $this->api_model->getLiquorComments($liquor_id,$limit,$offset,0);
		//$data['liquorsubcomments'] = $this->api_model->getLiquorComments($liquor_id,$limit,$offset,1);
		 if($data['liquor_detail'])
        {
        	$data["status"] = "success";
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
            $this->response(NULL, 404);
        }
	}
	
	function liquor_likes_post()
	{
	//	$data = $_POST;
		$liquor_id = $this->input->post('liquor_id');
		$user_id = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
		$data["date_added"] = date("Y-m-d H:i:s");
		
		$chk=$this->db->get_where('all_likes',array('liquor_id'=>$liquor_id,'user_id'=>$user_id));
		
		if(CheckAuth()){
		if($chk->num_rows()>0)
		{
				$arr=array();
				switch ($chk->row()->like_flag) {
					case '1':
						$data['like_flag']='0';
						break;
					case '0':
						$data['like_flag']='1';
						break;
				
			}
			
			$this->db->where("liquor_id",$liquor_id);
			$this->db->where("user_id",$user_id);
			$this->db->update("all_likes",$data);
		 	$data_m['status']='success';
			$data_m['message']=$data['like_flag'];
			//print_r($data_m);
			
		}
		else
		{
			$data['like_flag']=1;
				$data['liquor_id'] = $this->input->post('liquor_id');
			$data['user_id'] = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
			$this->db->insert("all_likes",$data);
			$data_m['status']='success';
			$data_m['message']= 1;
			//echo print_r($data_m);
		}
		}
		else {
			$data_m['status'] = 'login_required';
			$data_m['message'] = 'Login Required';
		}
		echo json_encode($data_m);
		exit ;	
		  	
	}
	
	function liquor_favorite_post()
	{
		//$data = $_POST;
		$liquor_id = $this->input->post('liquor_id');
		$user_id = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
		$data["date_added"] = date("Y-m-d H:i:s");
		$chk=$this->db->get_where('all_likes',array('liquor_id'=>$liquor_id,'user_id'=>$user_id));
		
		if(CheckAuth()){
		if($chk->num_rows()>0)
		{
				$arr=array();
				switch ($chk->row()->fav_flag) {
					case '1':
						$data['fav_flag']='0';
						break;
					case '0':
						$data['fav_flag']='1';
						break;
				
			}
			
			$this->db->where("liquor_id",$liquor_id);
			$this->db->where("user_id",$user_id);
			$this->db->update("all_likes",$data);
		 	$data_m['status']='success';
			$data_m['message']=$data['fav_flag'];
			//print_r($data_m);
			
		}
		else
		{
			$data['fav_flag']=1;
			$data['liquor_id'] = $this->input->post('liquor_id');
			$data['user_id'] = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
			$this->db->insert("all_likes",$data);
			$data_m['status']='success';
			$data_m['message']= 1;
			//echo print_r($data_m);
		}
		}
		else {
			$data_m['status'] = 'login_required';
			$data_m['message'] = 'Login Required';
		}
		echo json_encode($data_m);
		exit ;	
		  	
	}

	function taxi_details_post()
	{
		$taxi_id = $this->input->post('taxi_id');
		$user_id = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
		
		$data["taxi_detail"] = $this->api_model->getTaxiDetails($taxi_id,$user_id);
		 if($data['taxi_detail'])
        {
        	$data["status"] = "success";
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
            $this->response(NULL, 404);
        }
	}
	
	function getuserdashboard_post()
	{
		
		if(CheckAuth()){
		  $user_id = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
	  	  $data['getalldata'] = $this->api_model->get_user_info($user_id);
		  
		  $data['status'] = 'success';
		}
		else {
			$data['status'] = 'login_required';
		}
		
         $this->response($data, 200);
	}
	
	function editinfo_post()
	{
		if(CheckAuth())
		{
			$user_id = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');
			
			$num	=	$this->db->select('count(user_id) AS total')
							 ->where("email",$this->input->post('email'))
							 ->where("user_type",'user')
							  ->where("user_id !=",$user_id)
							 ->get("user_master")
							 ->row()
							 ->total;
			
			if($num > 0) {
				$data['status'] = "unique_failed"; 
				$this->response($data ,200);
			}
			    $data['res'] =  $this->api_model->user_edit_api($user_id);			
				$data["status"] = "success";	
		}
		else {
			$data['status'] = 'login_required';
		}
         $this->response($data, 200);
	}
	
	function favoritebar_post()
	{
		if(CheckAuth()){
		$keyword= $this->input->post('keyword');
		$limit= $this->input->post('limit');
		$offset= $this->input->post('offset');
		$user_id= $this->input->post('user_id');
		$data['favorite_bar_list'] = $this->api_model->getFavoriteBar($offset,$limit,$keyword,$user_id,'result');
		$data['favorite_bar_list_total'] = $this->api_model->getFavoriteBar($offset,$limit,$keyword,$user_id,'total');
         if($data)
        {
        	$data['status'] = "success";
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
            $this->response(NULL, 404);
        }
		}
		else {
			$data['status'] = 'login_required';
			$this->response($data, 200);
		}
	}
	
	function favoritebeer_post()
	{
		if(CheckAuth()){
		$keyword= $this->input->post('keyword');
		$limit= $this->input->post('limit');
		$offset= $this->input->post('offset');
		$user_id= $this->input->post('user_id');
		$data['favorite_beer_list'] = $this->api_model->getFavoriteBeer($offset,$limit,$keyword,$user_id,'result');
		$data['favorite_beer_list_total'] = $this->api_model->getFavoriteBeer($offset,$limit,$keyword,$user_id,'total');
         if($data)
        {
        	$data['status'] = "success";
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
            $this->response(NULL, 404);
        }
		}
		else
		{
			$data['status'] = 'login_required';
			$this->response($data, 200);
		}	
	}
	
	function favoritecocktail_post()
	{
		if(CheckAuth()){
		$keyword= $this->input->post('keyword');
		$limit= $this->input->post('limit');
		$offset= $this->input->post('offset');
		$user_id= $this->input->post('user_id');
		$data['favorite_cocktail_list'] = $this->api_model->getFavoriteCocktail($offset,$limit,$keyword,$user_id,'result');
		$data['favorite_cocktail_list_total'] = $this->api_model->getFavoriteCocktail($offset,$limit,$keyword,$user_id,'total');
         if($data)
        {
        	$data['status'] = "success";
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
            $this->response(NULL, 404);
        }
        }
			else
		{
			$data['status'] = 'login_required';
			$this->response($data, 200);
		}	
		
	}
	
	function favoriteliquor_post()
	{
		if(CheckAuth()){
		$keyword= $this->input->post('keyword');
		$limit= $this->input->post('limit');
		$offset= $this->input->post('offset');
		$user_id= $this->input->post('user_id');
		$data['favorite_liquor_list'] = $this->api_model->getFavoriteLiquor($offset,$limit,$keyword,$user_id,'result');
		$data['favorite_liquor_list_total'] = $this->api_model->getFavoriteLiquor($offset,$limit,$keyword,$user_id,'total');
         if($data)
        {
        	$data['status'] = "success";
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
            $this->response(NULL, 404);
        }
		}
		else
		{
			$data['status'] = 'login_required';
			$this->response($data, 200);
		}	
	}
	
	function user_change_password_post()
	{
			if(CheckAuth()){
			$user_id = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
        	$old_pass = $this->input->post('old_pass');
			$new_pass = $this->input->post('new_pass'); 
        	
        	$data = $this->api_model->user_change_password_api($user_id,$old_pass,$new_pass);
        	$this->response($data ,200);
			}
			else
			{
				$data['status'] = 'login_required';
				$this->response($data, 200);
			}	
			
			
	}	
	
	function get_user_album_post()
	{
			if(CheckAuth()){
			$keyword= $this->input->post('keyword');
			$limit= $this->input->post('limit');
			$offset= $this->input->post('offset');
			$user_id= $this->input->post('user_id');
        	
			$data['album'] = $this->api_model->getBarGalleryDetail($offset,$limit,$keyword,$user_id,'result');
			$data['album_total'] = $this->api_model->getBarGalleryDetail($offset,$limit,$keyword,$user_id,'total');
			$data['status'] = 'success';
        	$this->response($data ,200);
			}
			else
			{
				$data['status'] = 'login_required';
				$this->response($data, 200);
			}	
			
			
	}	
	
	function edit_album_post()
	{
		if(CheckAuth()){
			$id=  $this->input->post('bar_gallery_id');
			$data['gallery'] = $this->api_model->getOneGallery($id);
			$data['galleryimages'] = $this->api_model->getGalleryImages($id);
			$data['status'] = 'success';
			$this->response($data ,200);
		}
		else
		{
			$data['status'] = 'login_required';
			$this->response($data, 200);
		}		
		
	}
	
	function add_album_post()
	{
	   	if(CheckAuth()){
			if($this->input->post('bar_gallery_id')=='')
			{
			  	//echo "first";
				//die;
			    $this->api_model->bar_gallery_insert();			
				$data["status"] = "success";	
			}
			else {
			//	echo "second";
			//	die;
				$this->api_model->bar_gallery_update();			
				$data["status"] = "success";
			}
			$this->response($data ,200);
		}
		else
		{
			$data['status'] = 'login_required';
			$this->response($data, 200);
		}	
	}
	
	function deletefavbar_post()
	{
			$bar_id = explode(',', $this->input->post('bar_id')) ;
			if($bar_id)
			{
			foreach($bar_id as $id)
			{			
				$data_update = array('bar_fav_flag'=>0);
				$this->db->where("bar_id",$id);
				
				$this->db->where("user_id",$this->input->post('user_id'));
				$this->db->update("all_likes",$data_update);
			}
			}
			$data["status"] = "success";
			$this->response($data ,200);
	}
	
	
	function deletefavbeer_post()
	{
			$beer_id = explode(',', $this->input->post('beer_id')) ;
			if($beer_id)
			{
			foreach($beer_id as $id)
			{			
				$data_update = array('beer_fav_flag'=>0);
				$this->db->where("beer_id",$id);
				
				$this->db->where("user_id",$this->input->post('user_id'));
				$this->db->update("all_likes",$data_update);
			}
			}
			$data["status"] = "success";
			$this->response($data ,200);
	}
	
	function deletefavcocktail_post()
	{
			
			$cocktail_id = explode(',', $this->input->post('cocktail_id')) ;
			if($cocktail_id)
			{
			foreach($cocktail_id as $id)
			{			
				$data_update = array('fav_flag'=>0);
				$this->db->where("cocktail_id",$id);
				
				$this->db->where("user_id",$this->input->post('user_id'));
				$this->db->update("all_likes",$data_update);
			}
			}
			$data["status"] = "success";
			$this->response($data ,200);
	}
	
	function deletefavliquor_post()
	{
			
			$liquor_id = explode(',', $this->input->post('liquor_id')) ;
			if($liquor_id)
			{
			foreach($liquor_id as $id)
			{			
				$data_update = array('fav_flag'=>0);
				$this->db->where("liquor_id",$id);
				$this->db->where("user_id",$this->input->post('user_id'));
				$this->db->update("all_likes",$data_update);
			}
			}
			$data["status"] = "success";
			$this->response($data ,200);
	}
	
	function bargallerydelete_post()
	{
		$bar_gallery_id = explode(',', $this->input->post('bar_gallery_id')) ;
			if($bar_gallery_id)
			{
			foreach($bar_gallery_id as $id)
			{			
				$this->db->where('bar_gallery_id',$id)->delete('album');
				$this->db->where('bar_gallery_id',$id)->delete('album_images');
			}
			}
		
		$data["status"] = "success";
		$this->response($data ,200);
	}
	
	 function remove_gallery_image_post()
	{
		$id = $this->input->post('bar_image_id');
		$oneImage=$this->api_model->getOneImageGallery($id);
		
		if($oneImage!='' && $oneImage)
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
			if(file_exists(base_path().'upload/bar_gallery_thumb_big650by470/'.$oneImage->bar_image_name))
			{
				unlink(base_path().'upload/bar_gallery_thumb_big650by470/'.$oneImage->bar_image_name);
			}
			if(file_exists(base_path().'upload/bar_gallery_thumb_big183by183/'.$oneImage->bar_image_name))
			{
				unlink(base_path().'upload/bar_gallery_thumb_big183by183/'.$oneImage->bar_image_name);
			}
			if(file_exists(base_path().'upload/bar_gallery_thumb_big140by140/'.$oneImage->bar_image_name))
			{
				unlink(base_path().'upload/bar_gallery_thumb_big140by140/'.$oneImage->bar_image_name);
			}
			}
			$this->db->where('bar_image_id',$oneImage->bar_image_id)->delete('album_images');
			$data["status"] = "success";
		}
		else {
			$data["status"] = "fail";              
		}
		$this->response($data ,200);
		
	}	
	function privacy_settings_post()
	{
		if(CheckAuth()){
		$user_id =	$this->input->post('user_id');
		$getsetting = $this->api_model->getsetting($user_id);
		if($getsetting)
		{
			$data['getsetting'] = $getsetting;
			$data['status'] = 'success';
			$this->response($data ,200);
			
		}
		else
		{
			$data = array();
			$this->response($data ,200);
		}
		}
	   else
		{
			$data['status'] = 'login_required';
			$this->response($data, 200);
		}	
		
	}
	
	function update_privacy_settings_post()
	{
		if(CheckAuth()){
		$user_id =	$this->input->post('user_id');
		if($this->input->post('setting_id')=='' || $this->input->post('setting_id')==0)
		{
				$res= $this->api_model->insertusersetting();
				$data['status'] = 'success';
			 	$this->response($data, 200);
		} 	
		else 
		{
				$res = $this->api_model->updateusersetting();
				$data['status'] = 'success';
				$this->response($data, 200);
		}	
		}
	   else
		{
			$data['status'] = 'login_required';
			$this->response($data, 200);
		}	
		
	}
	
	 function page_post() {
        $slug =	$this->input->post('slug');
        $result = get_page_info($slug);
		 if($result)
        {
            $this->response($result, 200); // 200 being the HTTP response code
        }
        else
        {
            $this->response(NULL, 404);
        }
    }
	 
	function gallery_post()
	{
		$data = array();
		$data['gal'] = $this->api_model->getGal();
		
		//$data["one_bar_gallery"] = $this->api_model->getBarGalleryAll123();
		if($data)
        {
        	$data['status'] = "success";
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
            $this->response(NULL, 404);
        }
	}
	
	function get_gallery_by_id_post()
	{
		$data = array();
		$id = $this->input->post('bar_gallery_id');
		$data['gal'] = $this->api_model->getGalByID($id);
		
		//$data["one_bar_gallery"] = $this->api_model->getBarGalleryAll123();
		if($data)
        {
        		$data['status'] = "success";
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
            $this->response(NULL, 404);
        }
	}	
	
	 function user_logout_post(){
//		$user_id = $_POST['user_id'];
		$device_id = $_POST['device_id'];
		$unique_code = $_POST['unique_code'];
//		$this->response(array('user_id'=>$user_id, 'device_id'=>$device_id,'unique_code'=>$unique_code),200);
//                $logout = $this->api_model->user_logout($user_id,$device_id,$unique_code);
                $logout = $this->api_model->user_logout_hotfix($device_id,$unique_code);
//                $this->response($logout);
		if($logout){
			$this->response(array('status'=>'success'),200);
		} else {
			$this->response(array('status'=>'fail'),200);
		}
	}
	 
	function auto_suggest_bar_post()
	{
		$arr = array();	
		if($this->input->post('term'))
		{
		$data['barlist'] 	 = $this->api_model->auto_suggest_bar($this->input->post('term'));
		
		if($data['barlist']){
		// foreach($operator_list as $key=>$val){
			// $arr1[] = array("zipcode"=>$val['zipcode'],"state"=>$val['state'],"phone"=>$val['phone'],"owner_id"=>$val['owner_id'],"lat"=>$val['lat'],"lang"=>$val['lang'],"email"=>$val['email'],"city"=>$val['city'],"bar_type"=>$val['bar_type'],"address"=>$val['address'],"bar_logo"=>$val['bar_logo'],"bar_title"=>$val['bar_title'],"id"=>$val['bar_id'],"label"=>$val['address'].",".$val['city'].",".$val['state'],"value"=>$val['bar_title']); 
// 			
		// }
		     $data['status'] = 'success';
			 $this->response($data, 200);
		}
		else {
			$this->response(array('status'=>'fail'),200);
		}
		}
		 $this->response($arr, 200);
	}
	
	 function reset_password_post()
    {
       $forget_password_code = $this->input->post('forget_password_code');
       $password = $this->input->post('password');
       $data = $this->api_model->reset_password($forget_password_code,$password);
       $this->response($data ,200);
    }
	
	function getAllEvent_post()
	{
		$order = explode("#",$this->input->post("order_by"));	
		if(isset($order[0]) && isset($order[1]))
				{
					 $sort_by = $order[0];
				     $sort_type = $order[1];	
				}
				else
				{
				     $sort_by = "event_id";
				     $sort_type = "ASC";		
				}	
				
		$limit = $this->input->post('limit');
		$offset = $this->input->post('offset');
		$keyword = $this->input->post('keyword');
		$bar_id = $this->input->post('bar_id');
		if($bar_id!=0 && $bar_id!='')
		{
			$bar_id = $bar_id;
		}
		else
		{
		   $bar_id = 0;	
		}
	
		$alpha = $this->input->post('alpha');
		$data['eventlist'] = $this->api_model->getAllEvent($offset,$limit,$sort_by,$sort_type,$keyword,$alpha,$bar_id,'result');
		$data['eventlist_total'] = $this->api_model->getAllEvent($offset,$limit,$sort_by,$sort_type,$keyword,$alpha,$bar_id,'total');
		
		//print_r($data);
	    if($data)
        {
        	$data["status"] = "success";
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
            $data["status"] = "fail";
            $this->response($data, 200);
        }
	}

	function getInTouch_post()
	{
		$bar_id = $this->input->post('bar_id');
		$bar_detail = $this->api_model->get_one_bar($bar_id);
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
		$data["status"] = "success";
        $this->response($data, 200);	
	}

    function event_details_post()
	{
		
		$event_id = $this->input->post('event_id');
		$user_id = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
		$data["event_detail"] = $this->api_model->getEventDetails($event_id);
		
		$data["event_cat"] = '';
		if($data["event_detail"]['event_category'])
		{
			$cat = '';
			 $getin1 = explode(',',strip_tags($data["event_detail"]['event_category']));
			
			  foreach($getin1 as $r)
			  {
			  	  $cat .=  getEventCatname($r).', ';
			}
			 
			$data["event_cat"] = substr($cat,0,-2);  
		}
		$data["eventtime"] = $this->api_model->getEventTime($event_id);
		$data["event_gallery"] = $this->api_model->getEventGallery($event_id);
		//$data['beersubcomments'] = $this->api_model->getBeerComments($beer_id,$limit,$offset,1);
		 if($data['event_detail'])
        {
        	$data["status"] = "success";
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
            $this->response(NULL, 404);
        }
	}   
	function userInfo_post()
	{
		if(CheckAuth())
		{
			$user_id = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
			$num	=	$this->db->select('*')
							 ->where("user_type",'user')
							  ->where("user_id",$user_id)
							 ->get("user_master");
							 
			
			
			if($num) {
				$result['status'] = 'success';
				$result["result"] = $num->row_array();
			}
			else
			{
					$result["status"] = 'fail';
			}
			   	
		}
		else {
			$data['status'] = 'login_required';
		}
		//print_r($result) ;
	}
	
   function profile_post()
   {
   	  $id = $this->input->post('user_id');
	  $data['getalldata']=$this->api_model->get_one_user($id);
	  $data['getsetting'] = $this->api_model->getsetting($id);
	  $data['albumgallery'] = $this->api_model->getalbumgallery($id);
	  $data['status'] = 'success';
	  $this->response($data, 200);
	}
	
	function get_album_by_id_post()
	{
		$data = array();
		$id = $this->input->post('bar_gallery_id');
		$data['gal'] = $this->api_model->getAlbumByID($id);
		
		//$data["one_bar_gallery"] = $this->api_model->getBarGalleryAll123();
		if($data)
        {
        		$data['status'] = "success";
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
            $this->response(NULL, 404);
        }
	}	

  function get_contact_us_info_post()
  {
  		$data = array();
		$data['info'] = $this->api_model->getConttactusInfo();
		
		//$data["one_bar_gallery"] = $this->api_model->getBarGalleryAll123();
		if($data)
        {
        		$data['status'] = "success";
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
            $this->response(NULL, 404);
        }
  	
  }			
  
  function send_inquiry_post()
  {
  	 $this->api_model->send_inquiry();	
	
	 $data["status"] = "success";	
	  $this->response($data, 200);
	 
  }
  
  function cms_page_post()
  {
  	 $slug = $this->input->post('slug');
		if($slug!=''){
			$url = site_url('home/contentView/'.$slug);
			$data = array(
				'status' => 'success',
				'url' => $url
			);
			$this->response($data,200);
		} else {
			$this->response(array('status'=>'fail'),200);
		}
  	
  }
  
  function fb_register_post()
  {
  	 $first_name = $this->input->post('first_name');
	 $fb_id = $this->input->post('fb_id');
	 $last_name = $this->input->post('last_name');
	 $email = $this->input->post('email');
	 $fb_img = $this->input->post('fb_img');
	 $device_id = $this->input->post('device_id');
	 $unique_code = uniqid().$device_id;
	 $usr = $this->api_model->get_user_by_fb_uid($fb_id,$email);
     if($usr) {
	   	
		$query = $this->db->get_where('user_master',array('email'=>$email,'email !='=>'','user_type'=>'user'));
		if($query->num_rows() == 1)
		{
			$user = $query->row_array();
			$user_type=$user['user_type'];
			$user_id = $user['user_id'];
			$status = $user['status'];
			$first_name= $user['first_name'];
			$last_name= $user['last_name'];
			$email= $user['email'];
			$mobile_no= $user['mobile_no'];
			$image= $user['profile_image'];

			
			if($status=='active')
			{
				//return "1";
				$data = array(
						'user_id' => $user_id,
						'email' => $email,
						'image' => $image,
						'first_name'=>$first_name,
						'last_name'=>$last_name,
						'mobile_no'=>$mobile_no,
						'unique_code' => $unique_code,
						'device_id'=>$device_id,
						'status'=>'success'
						);
						
			    $data_device = array(
                        'user_id' => $user_id,
                        'device_name'=>$device_id,
                        'unique_code' => $unique_code,
                        'created_on'=> date('Y-m-d H:i:s')
                );
				$this->db->insert('device_master',$data_device);	
				
				$this->response($data,200);
				
						
						
			}else if($status=='suspend'){
				
				$data = array(
                        'status'=>'suspend'
                        );
				$this->response($data,200);
				
			}
			else if($status=='inactive'){
				
				$data = array(
                        'status'=>'inactive'
                        );
				$this->response($data,200);
				
			}else{
				$data = array(
                        'status'=>'fail'
                        );
				$this->response($data,200);
			}	

		}
		else
		{
			$data = array(
                        'status'=>'fail'
                        );
				$this->response($data,200);
		}
										
	  }  

		else {
			
	   				$fname = $this->input->post('first_name'); 
	   				$lname = $this->input->post('last_name');
	   				//$fullname = $fb_usr["name"];
	   				$pwd = ''; 
					$fb_img='';
					
					$base_path = base_path();
					$image_settings = image_setting();
					$img = file_get_contents('https://graph.facebook.com/'.$fb_id.'/picture?type=large');
					$file = base_path()."upload/user_orig/".$fb_id.".jpg";
					
					file_put_contents($file, $img);
					$fb_img= $fb_id.'.jpg';
					$config['upload_path'] = $base_path.'upload/user_orig/';
					$config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';
					//$config['max_size']	= '100';// in KB
					$this->load->library('upload', $config);
					$config['source_image'] = $this->upload->upload_path.$fb_img;
					$config['new_image'] = base_path()."upload/user_thumb/";
					$config['thumb_marker'] = "";
					//$config['maintain_ratio'] = $image_settings['u_ratio'];
					$config['create_thumb'] = TRUE;
					$config['width'] = 120;
					$config['height'] = 120;
					$this->load->library('image_lib', $config);
					$gd_var='gd2';
					if(!$this->image_lib->resize()){
						echo $error = $this->image_lib->display_errors();
						die;				
					}	

					$fb_values = array (                    
						'fb_id' => $fb_id,
						'first_name' => strtolower(str_replace (" ", "",$fname)),
						'last_name' => strtolower(str_replace (" ", "",$lname)),                    
						'email'=>$email,
						'fb_img'=>$fb_img,
						'type' =>'facebook'
					);
					$user_id = $this->api_model->save_social_data($fb_values);
						$data = array(
						'user_id' => $user_id,
						'email' => $email,
						'image' => $fb_img,
						'first_name'=>$first_name,
						'last_name'=>$last_name,
						//'mobile_no'=>$mobile_no,
						'unique_code' => $unique_code,
						'device_id'=>$device_id,
						'status'=>'success'
						);
						
				    $data_device = array(
	                        'user_id' => $user_id,
	                        'device_name'=>$device_id,
	                        'unique_code' => $unique_code,
	                        'created_on'=> date('Y-m-d H:i:s')
	                );
					$this->db->insert('device_master',$data_device);	
					
					$this->response($data,200);
						
		} 

      
  }

  function register_android_device_post()
	{
		$check_register	=	$this->db->select('COUNT(registered_android_id) AS TOTAL')
									 ->where(array("gcm_regid"=>$this->input->post('gcm_regid'),"device_id"=>$this->input->post('device_id')))
									 ->get("registered_android")
									 ->row()
									 ->TOTAL;
		if($check_register)
		{
			$this->response(array("status"=>"already_register"),200);
		}
		else
		{
			$data = $this->api_model->register_device_android();
			if($data)
			{
				$this->response(array("status"=>"success"),200);
			}
			else
			{
				$this->response(array("status"=>"fail"),200);
			}
		}
	}
	function register_iphone_device_post()
	{
		$check_register	=	$this->db->select('COUNT(registered_iphone_id) AS TOTAL')
									 ->where(array("token_id"=>$this->input->post('token_id'),"device_id"=>$this->input->post('device_id')))
									 ->get("registered_iphone")
									 ->row()
									 ->TOTAL;
		if($check_register)
		{
			//echo "if"; die;
			$this->response(array("status"=>"already_register"),200);
		}
		else
		{
			//echo "else"; die;
			$data = $this->api_model->register_device_iphone();
			if($data)
			{
				$this->response(array("status"=>"success"),200);
			}
			else
			{
				$this->response(array("status"=>"fail"),200);
			}
		}
	}
	
	
	function unregister_android_device_post()
	{
		$device_id = $this->input->post('device_id');
		$this->db->delete('registered_android',array('device_id'=>$device_id))	?	$this->response(array("status"=>"success"),200)	:	$this->response(array("status"=>"fail"),200);
	}
	
	function unregister_iphone_device_post()
	{
		$device_id = $this->input->post('device_id');
		$this->db->delete('registered_iphone',array('device_id'=>$device_id))	?	$this->response(array("status"=>"success"),200)	:	$this->response(array("status"=>"fail"),200);
	} 
	
			
	
	function beersuggest_post()
	{
			$beer_name = $this->input->post('beer_name');
			$beer_state = $this->input->post('beer_state');
			$beer_country = $this->input->post('beer_country');
			$beer_desc = $this->input->post('beer_desc');
			$beer_type = $this->input->post('beer_type');
			$city_produced = $this->input->post('city_produced');
			$abv = $this->input->post('abv');
			$producer = $this->input->post('producer');
			$beer_website = $this->input->post('beer_website');
			
			$num = $this->db->select('count(beer_id) AS total')
							 ->where("beer_name",$beer_name)
							 ->get("beer_directory")
							 ->row()
							 ->total;
			
			
			if($num > 0) {
				$data['status'] = "unique_failed"; 
				//$this->response($data ,200);
			}
        	
			//$data = $this->api_model->user_register_api($user_type,$first_name,$last_name,$email,$pass,$mobile_no);
			$this->api_model->suggestbeer_insert($beer_name,$beer_state,$beer_country,$beer_desc,$beer_type,$abv,$producer,$beer_website,$city_produced);
			$data['status'] = "success" ;
        	$this->response($data ,200);
	}
	
	function cocktailsuggest_post()
	{
			$cocktail_name = $this->input->post('cocktail_name');
			$ingredients = $this->input->post('ingredients');
			$how_to_make_it = $this->input->post('how_to_make_it');
			$base_spirit = $this->input->post('base_spirit');
			$type = $this->input->post('type');
			$served = $this->input->post('served');
			$preparation = $this->input->post('preparation');
			$strength = $this->input->post('strength');
			$difficulty = $this->input->post('difficulty');
			$flavor_profile = $this->input->post('flavor_profile');
			
			$num = $this->db->select('count(cocktail_id) AS total')
							 ->where("cocktail_name",$cocktail_name)
							 ->get("cocktail_directory")
							 ->row()
							 ->total;
			
			
			if($num > 0) {
				$data['status'] = "unique_failed"; 
				$this->response($data ,200);
			}
        	
			//$data = $this->api_model->user_register_api($user_type,$first_name,$last_name,$email,$pass,$mobile_no);
			$this->api_model->suggestcocktail_insert($cocktail_name,$ingredients,$how_to_make_it,$base_spirit,$type,$served,$preparation,$strength,$difficulty,$flavor_profile);
			$data['status'] = "success" ;
        	$this->response($data ,200);
	}


	function liquorsuggest_post()
	{
			$liquor_title = $this->input->post('liquor_title');
			$type = $this->input->post('type');
			$proof = $this->input->post('proof');
			$producer = $this->input->post('producer');
			$country = $this->input->post('country');
			$description = $this->input->post('description');
			
			$num = $this->db->select('count(liquor_id) AS total')
							 ->where("liquor_title",$liquor_title)
							 ->get("liquors")
							 ->row()
							 ->total;
			
			
			if($num > 0) {
				$data['status'] = "unique_failed"; 
				$this->response($data ,200);
			}
        	
			//$data = $this->api_model->user_register_api($user_type,$first_name,$last_name,$email,$pass,$mobile_no);
			$this->api_model->suggestliquor_insert($liquor_title,$type,$proof,$producer,$country,$description);
			$data['status'] = "success" ;
        	$this->response($data ,200);
	}
	
	function suggest_bar_post()
	{
		$query = $this->db->query("select bar_title from ".$this->db->dbprefix('bars')." where  address='".addslashes($this->input->post('address'))."' and  bar_title = '".addslashes($this->input->post('bar_name'))."'");
		
		
		if($query->num_rows() > 0) {
			$data['status'] = "unique_failed"; 
			$this->response($data ,200);
		}
		
		$this->api_model->insert_suggest_bar();
				
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
				
				$data['status'] = "success" ;
        	$this->response($data ,200);
				
	}

	function add_report_bar_post()
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
					 'user_id'=> $this->input->post('user_id'),
					 'date'=>date('Y-m-d H:i:s'));
		$this->db->insert('report',$arr);
			$data['status'] = "success" ;
        	$this->response($data ,200);	 
	}
	
	function listarticle_post()
	{
		$order = explode("#",$this->input->post("order_by"));	
		if(isset($order[0]) && isset($order[1]))
				{
					 $sort_by = $order[0];
				     $sort_type = $order[1];	
				}
				else
				{
				     $sort_by = "blog_id";
				     $sort_type = "desc";		
				}	
				
		$limit = $this->input->post('limit');
		$offset = $this->input->post('offset');
		$keyword = $this->input->post('keyword');
		
		$articlelist = $this->api_model->getAllArticle($sort_by,$sort_type,$limit,$offset,$keyword,'result');
		$data['article_total'] = $this->api_model->getAllArticle($sort_by,$sort_type,$limit,$offset,$keyword,'total');
		
		
	    if($articlelist)
        {
        	foreach($articlelist as $k => $v){
        		
        		$g = "<img style=\"width:100%\" src='".base_url()."upload/blog_thumb/".$v["blog_image"]."' />";
				$data['result'][$k]['blog_description_with_image'] = $g ." ". $v['blog_description'];
				$data['result'][$k]['blog_description'] = $v['blog_description'];
				$data['result'][$k]['blog_image'] = $v['blog_image'];
				$data['result'][$k]['date_added'] = $v['date_added'];
				$data['result'][$k]['first_name'] = $v['first_name'];
				$data['result'][$k]['last_name'] = $v['last_name'];
				$data['result'][$k]['blog_id'] = $v['blog_id'];
				$data['result'][$k]['blog_title'] = $v['blog_title'];	
				$data['result'][$k]['total_rating'] = $v['total_rating'];
				$data['result'][$k]['total_number'] = $v['total_number'];	
				
				//die;
				// $g = "<img src='http://sandbox.americanbars.com/upload/blog_thumb/'".$r[$i]->blog_image." />";
				// $data['blog_description'] =  $g ." ". $r[$i]->blog_description;
				// $data['blog_id'] =  $r[$i]->blog_id;
				// $data['blog_title'] =  $r[$i]->blog_title;
			}
        	
        	$data["status"] = "success";
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
            $data["status"] = "fail";
            $this->response($data, 200);
        }
		
	}
	
	function articledetail_post()
   {
   	
   	    $blog_id = $this->input->post('article_id');
		$blog_detail = $this->api_model->get_one_blog($blog_id);
		//echo $data["blog_detail"]['blog_image'];
		$g = "<img src='http://sandbox.americanbars.com/upload/blog_thumb/'".$blog_detail['blog_image']." />";
		
		$data['blog_description'] =  $g ." ". $blog_detail['blog_description'];
		$data['blog_id'] =  $blog_detail['blog_id'];
		$data['blog_title'] =  $blog_detail['blog_title'];
	     if($blog_detail)
        {
        	$data['url'] = site_url('home/contentViewarticle/'.$data['blog_id']);
        	$data["status"] = "success";
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
            $this->response(NULL, 404);
        }		
   }

  function add_rating_post()
  {
  	  $data["blog_rating"]  = $this->input->post('blog_rating');
	  $data["blog_id"]  = $this->input->post('blog_id');
	  $data["user_id"]  = $this->input->post('user_id');
	  $data["date_added"] = date("Y-m-d H:i:s");
	  $this->db->insert("blog_rating",$data);
	  $data["status"] = "success";
      $this->response($data, 200);
  }
 
  function barcomment_post()
  {
  	    $bar_id = $this->input->post('bar_id');
		$limit = $this->input->post('limit');
		$offset = $this->input->post('offset');
  		$data['barcomment'] = $this->api_model->getAllComments($bar_id,$limit,$offset,'result');
		$data['barcomment_total'] = $this->api_model->getAllComments($bar_id,$limit,$offset,'total'); 
		if(!empty($data['barcomment']))
        {
        	
        	$data["status"] = "success";
            $this->response($data, 200); // 200 being the HTTP response code
        }
        else
        {
            $data["status"] = "fail";
            $this->response($data, 200);
        }
  } 
  
  function add_bar_comment_post()
  {
  	  
  	  $this->api_model->insert_bar_comment();	
  	  	$data["status"] = "success";
            $this->response($data, 200); 	
  }
  
   function beer_comments_post()
	{
		$beer_id = $this->input->post('beer_id');
		$limit = $this->input->post('limit');
		$offset = $this->input->post('offset');
		$user_id = $this->input->post('user_id');
		$data["beer_comment"] = $this->api_model->get_beer_comments($beer_id,$user_id,$limit,$offset,'result');
		//$data["beer_subcomment"] = $this->api_model->get_beer_subcomments($beer_id);
		$data["beer_comment_total"] = $this->api_model->get_beer_comments($beer_id,$user_id,$limit,$offset,'total');

		if(!empty($data['beer_comment']))
	    {
		  //echo "Fdas";
		  	$data["status"] = "success";
            $this->response($data, 200);
		}
		$data["status"] = "fail";
            $this->response($data, 200);
	}
	function beer_subcomments_post()
	{
		$comment_id = $this->input->post('master_comment_id');
		$limit = $this->input->post('limit');
		$offset = $this->input->post('offset');
		$data["beer_subcomment"] = $this->api_model->get_beer_subcomments($comment_id,$limit,$offset,'result');
		$data["beer_subcomment_total"] = $this->api_model->get_beer_subcomments($comment_id,$limit,$offset,'total');
		if(!empty($data['beer_subcomment']))
	    {
		  //echo "Fdas";
		  	$data["status"] = "success";
            $this->response($data, 200);
		}
		$data["status"] = "fail";
            $this->response($data, 200);
	}	
	
	function beer_comment_likes_post(){
		//$data = $_POST;
		$beer_id = $this->input->post('beer_id');
		$beer_comment_id = $this->input->post('beer_comment_id');
		$user_id = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
		$data["date_added"] = date("Y-m-d H:i:s");
		$data['beer_id'] = $this->input->post('beer_id');
		$data['beer_comment_id'] = $this->input->post('beer_comment_id');
		$data['user_id'] = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
		
		$chk=$this->db->get_where('all_likes',array('beer_comment_id'=>$beer_comment_id,'beer_id'=>$beer_id,'user_id'=>$user_id));
		
		if(CheckAuth()){
		if($chk->num_rows()>0)
		{
				$arr=array();
				switch ($chk->row()->like_flag) {
					case '1':
						$data['like_flag']='0';
						break;
					case '0':
						$data['like_flag']='1';
						break;
				
			}
			
			$this->db->where("beer_comment_id",$beer_comment_id);
			$this->db->where("user_id",$user_id);
			$this->db->where("beer_id",$beer_id);
			$this->db->update("all_likes",$data);
			$chk1=$this->db->get_where('all_likes',array('beer_comment_id'=>$beer_comment_id,'beer_id'=>$beer_id,'like_flag'=>1));
			$data_m['total_like'] =  ((string)$chk1->num_rows());
		 	$data_m['status']='success';
			$data_m['is_like']=((string)$data['like_flag']);
			//print_r($data_m);
			
		}
		else
		{
			$data['like_flag']=1;
			$this->db->insert("all_likes",$data);
			$chk1=$this->db->get_where('all_likes',array('beer_comment_id'=>$beer_comment_id,'beer_id'=>$beer_id,'like_flag'=>1));
			$data_m['total_like'] = ((string)$chk1->num_rows());
			$data_m['status']='success';
			$data_m['is_like']= ((string)1);
			//echo print_r($data_m);
		}
		}
		else {
			$data_m['status'] = 'login_required';
			$data_m['message'] = 'Login Required';
		}
		echo json_encode($data_m);
		exit ;	
		
		
		
		// if(CheckAuth()){
		 // $is_like = $this->input->post('is_like');	
		 // $beer_id = $this->input->post('beer_id');	
		 // $user_id = $this->input->post('user_id');
		 // $beer_comment_id = $this->input->post('beer_comment_id');
// 		 
		// if($is_like==1){
			 // $data['like_flag']=1;
			 // $data['beer_id'] = $this->input->post('beer_id');	
			 // $data['user_id'] = $this->input->post('user_id');
			 // $data["date_added"] = date("Y-m-d H:i:s");
			 // $beer_comment_id = $this->input->post('beer_comment_id');
// 			 
			// $this->db->insert("all_likes",$data);
			// $data['like_flag']=0;
				// $data["status"] = "success";
            // $this->response($data, 200);
			// //echo $cnt_like = like_checker($_POST['beer_id'],$_POST['user_id']);			
			// //$data['user_id'] = one_beer_likers($_POST['user_id'],$_POST['like_flag']);
		// }
		// else{
			// $data_update = array("like_flag"=>0);
			// $this->db->where("beer_id",$beer_id);
			// $this->db->where("user_id",$user_id);
			// $this->db->where("beer_comment_id",$beer_comment_id);
			// $this->db->update("all_likes",$data_update);
			// $data['like_flag']=1;
			// $data["status"] = "success";
            // $this->response($data, 200);
		// }
		// }
		// else {
			// $data["status"] = "login_required";
		    // $this->response($data, 200);
		// }
		//$this->db->insert("all_likes",$data);
		//echo $cnt_like = like_checker($_POST['beer_id'],$_POST['user_id']);			
	}

	function add_beer_comment_post(){
		$cmt_id = $this->api_model->insert_beer_comment();		
		$data["status"] = "success";
        $this->response($data, 200);
		
	}
	function add_beer_subcomment_post(){
		$cmt_id = $this->api_model->insert_beer_subcomment();
		$data["status"] = "success";
        $this->response($data, 200);
	}
	
	function remove_beer_comment_post(){
		$beer_comment_id = $this->input->post('beer_comment_id');
		$this->api_model->remove_beer_comment($beer_comment_id);
		$data["status"] = "success";
        $this->response($data, 200);
	}
	
	
	
	// Cocktail Comments
	
	 function cocktail_comments_post()
	{
		$cocktail_id = $this->input->post('cocktail_id');
		$limit = $this->input->post('limit');
		$offset = $this->input->post('offset');
		$user_id = $this->input->post('user_id');
		$data["cocktail_comment"] = $this->api_model->get_cocktail_comments($cocktail_id,$user_id,$limit,$offset,'result');
		$data["cocktail_comment_total"] = $this->api_model->get_cocktail_comments($cocktail_id,$user_id,$limit,$offset,'total');

		if(!empty($data['cocktail_comment']))
	    {
		  //echo "Fdas";
		  	$data["status"] = "success";
            $this->response($data, 200);
		}
		$data["status"] = "fail";
            $this->response($data, 200);
	}
	function cocktail_subcomments_post()
	{
		$comment_id = $this->input->post('master_comment_id');
		$limit = $this->input->post('limit');
		$offset = $this->input->post('offset');
		$data["cocktail_subcomment"] = $this->api_model->get_cocktail_subcomments($comment_id,$limit,$offset,'result');
		$data["cocktail_subcomment_total"] = $this->api_model->get_cocktail_subcomments($comment_id,$limit,$offset,'total');
		if(!empty($data['cocktail_subcomment']))
	    {
		  //echo "Fdas";
		  	$data["status"] = "success";
            $this->response($data, 200);
		}
		$data["status"] = "fail";
            $this->response($data, 200);
	}	
	
	function cocktail_comment_likes_post(){
		//$data = $_POST;
		$cocktail_id = $this->input->post('cocktail_id');
		$cocktail_comment_id = $this->input->post('cocktail_comment_id');
		$user_id = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
		$data["date_added"] = date("Y-m-d H:i:s");
		
		$data['cocktail_id'] = $this->input->post('cocktail_id');
		$data['cocktail_comment_id'] = $this->input->post('cocktail_comment_id');
		$data['user_id'] = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
		$chk=$this->db->get_where('all_likes',array('cocktail_comment_id'=>$cocktail_comment_id,'cocktail_id'=>$cocktail_id,'user_id'=>$user_id));
		
		if(CheckAuth()){
		if($chk->num_rows()>0)
		{
				$arr=array();
				switch ($chk->row()->like_flag) {
					case '1':
						$data['like_flag']='0';
						break;
					case '0':
						$data['like_flag']='1';
						break;
				
			}
			
			$this->db->where("cocktail_comment_id",$cocktail_comment_id);
			$this->db->where("user_id",$user_id);
			$this->db->where("cocktail_id",$cocktail_id);
			$this->db->update("all_likes",$data);
			$chk1=$this->db->get_where('all_likes',array('cocktail_comment_id'=>$cocktail_comment_id,'cocktail_id'=>$cocktail_id,'like_flag'=>1));
			$data_m['total_like'] = (string)$chk1->num_rows();
		 	$data_m['status']='success';
			$data_m['is_like']=(string)$data['like_flag'];
			//print_r($data_m);
			
		}
		else
		{
			$data['like_flag']=1;
			$this->db->insert("all_likes",$data);
			$chk1=$this->db->get_where('all_likes',array('cocktail_comment_id'=>$cocktail_comment_id,'cocktail_id'=>$cocktail_id,'like_flag'=>1));
			$data_m['total_like'] = (string)$chk1->num_rows();
			$data_m['status']='success';
			$data_m['is_like']= (string)1;
			//echo print_r($data_m);
		}
		}
		else {
			$data_m['status'] = 'login_required';
			$data_m['message'] = 'Login Required';
		}
		echo json_encode($data_m);
		exit ;	
		// if(CheckAuth()){
		 // $is_like = $this->input->post('is_like');	
		 // $cocktail_id = $this->input->post('cocktail_id');	
		 // $user_id = $this->input->post('user_id');
		 // $cocktail_comment_id = $this->input->post('cocktail_comment_id');
// 		 
		// if($is_like==1){
			 // $data['like_flag']=1;
			 // $data['cocktail_id'] = $this->input->post('cocktail_id');	
			 // $data['user_id'] = $this->input->post('user_id');
			 // $data["date_added"] = date("Y-m-d H:i:s");
			 // $cocktail_comment_id = $this->input->post('cocktail_comment_id');
			// $this->db->insert("all_likes",$data);
				// $data["status"] = "success";
            // $this->response($data, 200);
			// //echo $cnt_like = like_checker($_POST['cocktail_id'],$_POST['user_id']);			
			// //$data['user_id'] = one_cocktail_likers($_POST['user_id'],$_POST['like_flag']);
		// }
		// else{
			// $data_update = array("like_flag"=>0);
			// $this->db->where("cocktail_id",$cocktail_id);
			// $this->db->where("user_id",$user_id);
			// $this->db->where("cocktail_comment_id",$cocktail_comment_id);
			// $this->db->update("all_likes",$data_update);
			// $data["status"] = "success";
            // $this->response($data, 200);
		// }
		// }
		// else {
			// $data["status"] = "login_required";
		    // $this->response($data, 200);
		// }
		//$this->db->insert("all_likes",$data);
		//echo $cnt_like = like_checker($_POST['cocktail_id'],$_POST['user_id']);			
	}

	function add_cocktail_comment_post(){
		$cmt_id = $this->api_model->insert_cocktail_comment();		
		$data["status"] = "success";
        $this->response($data, 200);
		
	}
	function add_cocktail_subcomment_post(){
		$cmt_id = $this->api_model->insert_cocktail_subcomment();
		$data["status"] = "success";
        $this->response($data, 200);
	}
	
	function remove_cocktail_comment_post(){
		$cocktail_comment_id = $this->input->post('cocktail_comment_id');
		$this->api_model->remove_cocktail_comment($cocktail_comment_id);
		$data["status"] = "success";
        $this->response($data, 200);
	}
	
	
	// Liquor Comments
	
	 function liquor_comments_post()
	{
		$liquor_id = $this->input->post('liquor_id');
		$limit = $this->input->post('limit');
		$offset = $this->input->post('offset');
		$user_id = $this->input->post('user_id');
		$data["liquor_comment"] = $this->api_model->get_liquor_comments($liquor_id,$user_id,$limit,$offset,'result');
		$data["liquor_comment_total"] = $this->api_model->get_liquor_comments($liquor_id,$user_id,$limit,$offset,'total');
		//$data["liquor_subcomment"] = $this->api_model->get_liquor_subcomments($liquor_id);
	  //  if(!empty($data["liquor_comment"]))
	//	{
		///	foreach($data["liquor_comment"] as $comment)
		//	{
	    		//$data["liquor_subcomment"][$comment['liquor_comment_id']] = $this->api_model->get_liquor_subcomments($liquor_id);
		//	}
		//}

		if(!empty($data['liquor_comment']))
	    {
		  //echo "Fdas";
		  	$data["status"] = "success";
            $this->response($data, 200);
		}
		$data["status"] = "fail";
            $this->response($data, 200);
	}
	function liquor_subcomments_post()
	{
		$comment_id = $this->input->post('master_comment_id');
		$limit = $this->input->post('limit');
		$offset = $this->input->post('offset');
		$data["liquor_subcomment"] = $this->api_model->get_liquor_subcomments($comment_id,$limit,$offset,'result');
		$data["liquor_subcomment_total"] = $this->api_model->get_liquor_subcomments($comment_id,$limit,$offset,'total');
		
		if(!empty($data['liquor_subcomment']))
	    {
		  //echo "Fdas";
		  	$data["status"] = "success";
            $this->response($data, 200);
		}
		$data["status"] = "fail";
            $this->response($data, 200);
	}	
	
	function liquor_comment_likes_post(){
		
		// if(CheckAuth()){
		 // $is_like = $this->input->post('is_like');	
		 // $liquor_id = $this->input->post('liquor_id');	
		 // $user_id = $this->input->post('user_id');
		 // $liquor_comment_id = $this->input->post('liquor_comment_id');
// 		 
		// if($is_like==1){
			 // $data['like_flag']=1;
			 // $data['liquor_id'] = $this->input->post('liquor_id');	
			 // $data['user_id'] = $this->input->post('user_id');
			 // $data["date_added"] = date("Y-m-d H:i:s");
			 // $liquor_comment_id = $this->input->post('liquor_comment_id');
			// $this->db->insert("all_likes",$data);
				// $data["status"] = "success";
            // $this->response($data, 200);
			// //echo $cnt_like = like_checker($_POST['liquor_id'],$_POST['user_id']);			
			// //$data['user_id'] = one_liquor_likers($_POST['user_id'],$_POST['like_flag']);
		// }
		// else{
			// $data_update = array("like_flag"=>0);
			// $this->db->where("liquor_id",$liquor_id);
			// $this->db->where("user_id",$user_id);
			// $this->db->where("liquor_comment_id",$liquor_comment_id);
			// $this->db->update("all_likes",$data_update);
			// $data["status"] = "success";
            // $this->response($data, 200);
		// }
		// }
		// else {
			// $data["status"] = "login_required";
		    // $this->response($data, 200);
		// }
		//$this->db->insert("all_likes",$data);
		//echo $cnt_like = like_checker($_POST['liquor_id'],$_POST['user_id']);	
		
		
		$liquor_id = $this->input->post('liquor_id');
		$liquor_comment_id = $this->input->post('liquor_comment_id');
		$user_id = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
		
		$data['liquor_id'] = $this->input->post('liquor_id');
		$data['liquor_comment_id'] = $this->input->post('liquor_comment_id');
		$data['user_id'] = $this->input->post('user_id')=='' ? '0':$this->input->post('user_id');;
		$data["date_added"] = date("Y-m-d H:i:s");
		
		$chk=$this->db->get_where('all_likes',array('liquor_comment_id'=>$liquor_comment_id,'liquor_id'=>$liquor_id,'user_id'=>$user_id));
		
		if(CheckAuth()){
		if($chk->num_rows()>0)
		{
				$arr=array();
				switch ($chk->row()->like_flag) {
					case '1':
						$data['like_flag']='0';
						break;
					case '0':
						$data['like_flag']='1';
						break;
				
			}
			
			$this->db->where("liquor_comment_id",$liquor_comment_id);
			$this->db->where("user_id",$user_id);
			$this->db->where("liquor_id",$liquor_id);
			$this->db->update("all_likes",$data);
			$chk1=$this->db->get_where('all_likes',array('liquor_comment_id'=>$liquor_comment_id,'liquor_id'=>$liquor_id,'like_flag'=>1));
			$data_m['total_like'] = (string)$chk1->num_rows();
		 	$data_m['status']='success';
			$data_m['is_like']=(string)$data['like_flag'];
			//print_r($data_m);
			
		}
		else
		{
			$data['like_flag']=1;
			$this->db->insert("all_likes",$data);
			$chk1=$this->db->get_where('all_likes',array('liquor_comment_id'=>$liquor_comment_id,'liquor_id'=>$liquor_id,'like_flag'=>1));
			$data_m['total_like'] = (string)$chk1->num_rows();
			$data_m['status']='success';
			$data_m['is_like']= (string)1;
			//echo print_r($data_m);
		}
		}
		else {
			$data_m['status'] = 'login_required';
			$data_m['message'] = 'Login Required';
		}
		echo json_encode($data_m);
		exit ;		
	}

	function add_liquor_comment_post(){
		$cmt_id = $this->api_model->insert_liquor_comment();		
		$data["status"] = "success";
        $this->response($data, 200);
		
	}
	function add_liquor_subcomment_post(){
		$cmt_id = $this->api_model->insert_liquor_subcomment();
		$data["status"] = "success";
        $this->response($data, 200);
	}
	
	function remove_liquor_comment_post(){
		$liquor_comment_id = $this->input->post('liquor_comment_id');
		$this->api_model->remove_liquor_comment($liquor_comment_id);
		$data["status"] = "success";
        $this->response($data, 200);
	}
	
	function trivia_post()
	{
		$data['result'] = $this->api_model->getquiz();
		$data['imagedate'] =$this->api_model->getimagenamebanner();
		$data["status"] = "success";
        $this->response($data, 200);
	}
	
}
