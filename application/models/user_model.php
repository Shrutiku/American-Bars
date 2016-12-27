<?php
class User_model extends CI_Model {
	
    function User_model()
    {
        parent::__construct();
	}   
	
	// Use :This function use for get one user detail.
	// Param :Patient Id
	// Return :array
	function get_one_user($id)
	{
		$this->db->select("*");
		$this->db->from('user_master');
		$this->db->where('user_id',$id);
		$this->db->order_by('user_id','desc');
		$this->db->limit('1','0');
		$query=$this->db->get();
		
		if($query->num_rows()>0)
		{
			
			return $query->row_array();
		}
		return;
	}	

     
	/** function insert_profile_step1()
	 * insert_profile_step1
	 * 
	 * auth: thais
	 */
	function update_user($res)
	{
		//update user details
		$data=array(
			'first_name'=>$res['first_name'],
			'last_name'=>$res['last_name'],
			'address'=>$res['address'],
			'about_user'=>$res['about_user'],
			'gender'=>$res['gender'],
			'email'=>$res['email'],
			'phone_no'=>$res['phone_no']
		);
		$this->db->where('user_id',get_authenticateUserID());
		$this->db->update('user_master',$data);
		
	}
	
	/**
	 * fucntion : get_consultation_list
	 * get consultation lisr
	 * return result array
	 * author : Thais
	 */
	 function get_consultation_list()
	 {
	 	$qry = $this->db->get_where("user_consultation",array("status"=>1));
		
		if($qry->num_rows()>0)
		{
			return $qry->result_array();
		}
		
		return 0;
	 }
	 /**
	 * fucntion : get_user_beverage_list
	 * get user everage list
	 * return result array
	 * author : Thais
	 */
	 
	 function get_user_beverage_list()
	 {
	 	$qry = $this->db->get_where("user_beverage",array("user_id"=>get_authenticateUserID()));
		
		if($qry->num_rows()>0)
		{
			 return $qry->row_array();
		}
		
		return 0;
	 }
	 
	  /**
	 * fucntion : get_user_food_choice_list
	 * get user food choice list
	 * return result array
	 * author : Thais
	 */
	 function get_user_food_choice_list()
	 {
	 	$qry = $this->db->get_where("user_food_choice",array("user_id"=>get_authenticateUserID()));
		$data_main = array();
		
		if($qry->num_rows()>0)
		{
			 $rs = $qry->row_array();
			 
			 unset($rs["food_choice_id"]);
			 unset($rs["user_id"]);
			 unset($rs["date_created"]);
		 foreach($rs as $key => $value){
     
		
			  $key =  utf8_decode ($key);
			  $exp = explode("#",$value);
			  $data[''.$key.''] = array();
		//	  print_r($exp); die;
			 if(isset($exp[0])){array_push($data[$key],$exp[0]);}else{array_push($data[$key],0);}
		     if(isset($exp[1])){array_push($data[$key],$exp[1]);}else{array_push($data[$key],0);}
		     if(isset($exp[2])){array_push($data[$key],$exp[2]);}else{array_push($data[$key],0);}
		     if(isset($exp[3])){array_push($data[$key],$exp[3]);}else{array_push($data[$key],0);}
		     if(isset($exp[4])){array_push($data[$key],$exp[4]);}else{array_push($data[$key],0);}
			
	
       }
		 
		  return $data;
		}
		
		
		return 0;
	 }
   /**
	 * fucntion : explode_food_choice
	 *  explode user_food_choice
	 * return  array
	 * author : Thais
	 */
     function explode_food_choice($values)
	 {
	 	  $exp = explode("#",$values);
		  $data = array();
		  
		  if(isset($exp[0])){array_push($data,1);}else{array_push($data,0);}
		  if(isset($exp[1])){array_push($data,1);}else{array_push($data,0);}
		  if(isset($exp[2])){array_push($data,1);}else{array_push($data,0);}
		  if(isset($exp[3])){array_push($data,1);}else{array_push($data,0);}
		  if(isset($exp[4])){array_push($data,1);}else{array_push($data,0);}
		   
		   
		   return $data;
		   
		  
	 }
	 /**
	 * fucntion : get_user_cooking_method
	 *  get user cooking method
	 * return  array
	 * author : Thais
	 */
	 function get_user_cooking_method()
	 {
	 	$qry = $this->db->get_where("user_cooking_method",array("user_id"=>get_authenticateUserID()));
		$data_main = array();
		
		if($qry->num_rows()>0)
		{
			 $rs = $qry->row_array();
			 
			 unset($rs["cooking_id"]);
			 unset($rs["user_id"]);
			 unset($rs["date_created"]);
			 
		 foreach($rs as $key => $value){
     
		
			 $key =  utf8_decode ($key);
			  $exp = explode("#",$value);
			  // print_r($exp); die;
			  $data[''.$key.''] = array();
			 if(isset($exp[0])){array_push($data[$key],$exp[0]);}else{array_push($data[$key],0);}
		     if(isset($exp[1])){array_push($data[$key],$exp[1]);}else{array_push($data[$key],0);}
		     if(isset($exp[2])){array_push($data[$key],$exp[2]);}else{array_push($data[$key],0);}
		     if(isset($exp[3])){array_push($data[$key],$exp[3]);}else{array_push($data[$key],0);}
		     if(isset($exp[4])){array_push($data[$key],$exp[4]);}else{array_push($data[$key],0);}
			 if(isset($exp[5])){array_push($data[$key],$exp[5]);}else{array_push($data[$key],0);}
			
	
       }

		  return $data;
		}
		
		
		return 0;
	 }

     /**
     * fucntion : get_user_cooking_method_fordashboard
     *  get user get_user_cooking_method_fordashboard method
     * return  array
     * author : Thais
     */
     function get_user_cooking_method_fordashboard()
     {
        $qry = $this->db->get_where("user_cooking_method",array("user_id"=>get_authenticateUserID()));
        $data_main = array();
        $data_desp = array();
        $data_values = array('Beurre','Huile','Margarine', 'Crème','Friture','Matières grasses / allégées');
        
        if($qry->num_rows()>0)
        {
             $rs = $qry->row_array();
             
             unset($rs["cooking_id"]);
             unset($rs["user_id"]);
             unset($rs["date_created"]);
             
         foreach($rs as $key => $value){
     
        
             $key =  utf8_decode ($key);
              $exp = explode("#",$value);
              // print_r($exp); die;
              $data[''.$key.''] = array();
             if(isset($exp[0])){if($value == 1){array_push($data_desp,$key.'-'.$data_values[0]);}}
             if(isset($exp[1])){if($value == 1){array_push($data_desp,$key.'-'.$data_values[1]);}}
             if(isset($exp[2])){if($value == 1){array_push($data_desp,$key.'-'.$data_values[2]);}}
             if(isset($exp[3])){if($value == 1){array_push($data_desp,$key.'-'.$data_values[3]);}}
             if(isset($exp[4])){if($value == 1){array_push($data_desp,$key.'-'.$data_values[4]);}}
             if(isset($exp[5])){if($value == 1){array_push($data_desp,$key.'-'.$data_values[5]);}}
            
    
       }
      
          return $data_desp;
        }
        
        
        return 0;
     }


   function insert_profile_step2($data= array() ,$beverage = array() ,$choice_arr = array(),$cooking_arr = array())
   {
   	    $uid = get_authenticateUserID();
		
		
		///user_initial_questions
   	    $this->db->where("user_id",$uid);
		$this->db->update("user_initial_questions",$data);
		//end //
		
		///user_beverage
   	    $this->db->where("user_id",$uid);
		$this->db->update("user_beverage",$beverage);
		//end //
		
		///user_food_choice
		
   	    $this->db->where("user_id",$uid);
		$this->db->update("user_food_choice",$choice_arr);
		//end //
		
		///user_cooking_method
	
		
   	    $this->db->where("user_id",$uid);
		$this->db->update("user_cooking_method",$cooking_arr);
		
		
		
		
		//end //
		
		 /// common function for insert all action//
		   $data_log = array("activity_name" => "Update user profile page step2","patient_id"=>$this->session->userdata("user_id"));
		   maintain_log($data_log);
		   /// end of common function for insert all the action//
		return true;
		
		
   }
   
    function get_user_initial_questions()
	{
		$qry = $this->db->get_where("user_initial_questions",array("user_id"=>get_authenticateUserID()));
		
		if($qry->num_rows()>0)
		{
			 return $qry->row_array();      
		}
		
		return 0;
	}
	
	function update_image($new_img='',$old_img='')
	{
		$data = array("profile_image" => $new_img);
	     
		 $this->db->where("user_id",$this->session->userdata("user_id"));
		 $this->db->update("user_master",$data);
		
		 
		 if($old_img !="")
		 {
		 	if(file_exists(base_path().'upload/user_orig/'.$old_img))
			{
				$link=base_path().'upload/user_orig/'.$old_img;
		    	unlink($link);
			}
					
			if(file_exists(base_path().'upload/user_thumb/'.$old_img))
			{
				$link2=base_path().'upload/user_thumb/'.$old_img;
				unlink($link2);
			}
		 }
	}
	/* 
	 * function : add_travail
	 * add data in travail table
	 * retuen string
	 * author: Thais
	 */
	function add_travail($data)
	{
		$this->db->insert("user_travail",$data);
		$id = mysql_insert_id();
		/// common function for insert all action//
		 $data_log = array("activity_name" => "Insert Au travail data","patient_id"=>$this->session->userdata("user_id"));
		 maintain_log($data_log);
	    /// end of common function for insert all the action//
		   
		   
		return $id;
		
		
		
	}
	
	
	/* 
	 * function : add_domicile
	 * add data in domicile table
	 * retuen string
	 * author: Thais
	 */
	 
	function add_domicile($data)
	{
		$this->db->insert("user_domicile",$data);
		
		$id = mysql_insert_id();
		/// common function for insert all action//
		 $data_log = array("activity_name" => "Insert Au domicile data","patient_id"=>$this->session->userdata("user_id"));
		 maintain_log($data_log);
	    /// end of common function for insert all the action//
		
		return $id;
	}
	
	
	/* 
	 * function : add_domicile
	 * add data in leisure table
	 * return string
	 * author: Thais
	 */
	 
	function add_leisure($data)
	{
		$this->db->insert("user_in_leisure",$data);
		$id = mysql_insert_id();
		/// common function for insert all action//
		 $data_log = array("activity_name" => "Insert Dans les loisirs data","patient_id"=>$this->session->userdata("user_id"));
		 maintain_log($data_log);
	    /// end of common function for insert all the action//
		
		return $id;
	}
	
	
	/* 
	 * function : get_user_travail_list
	 * get the user travil data list
	 * @return array
	 * author: Thais
	 */
	 
	function get_user_travail_list()
	{
		$qry = $this->db->get_where("user_travail",array("user_id"=>get_authenticateUserID()));
		
		if($qry->num_rows()>0)
		{
			return $qry->result_array();
		}
		
		
		return 0;
		
	}
	
	/* 
	 * function : delete_from_3tables
	 * delete from three table 
	 * @return integet value
	 * author: Thais
	 */
	function delete_from_3tables($id=0, $table_name='',$main_id)
	{
		 if($table_name !="")
		 {
		 	$this->db->delete($table_name,array($main_id=>$id,"user_id"=>get_authenticateUserID()));
		 	
			 if($table_name == "user_travail")
		    {
		 	/// common function for insert all action//
		     $data_log = array("activity_name" => "Delete Au travail data","patient_id"=>$this->session->userdata("user_id"));
		     maintain_log($data_log);
	        /// end of common function for insert all the action//
		    }
		   else if($table_name == "user_in_leisure")
		   {
		 	/// common function for insert all action//
		     $data_log = array("activity_name" => "Delete Dans les loisirs data","patient_id"=>$this->session->userdata("user_id"));
		     maintain_log($data_log);
	        /// end of common function for insert all the action//
		   }
		 
		 else
		 	{
		 		/// common function for insert all action//
		        $data_log = array("activity_name" => "Delete Au domicile data","patient_id"=>$this->session->userdata("user_id"));
		        maintain_log($data_log);
	           /// end of common function for insert all the action//
		 	}
			
			return base64_encode('delete');
			
		 }
		 else
		 {
		     return base64_encode('notdelete'); 
		 }
		 
		 
		 
		 
		
		 
	}
	
	
	/* 
	 * function : get_user_domicile_list
	 * get the user domicile data list
	 * @return array
	 * author: Thais
	 */
	 
	function get_user_domicile_list()
	{
		$qry = $this->db->get_where("user_domicile",array("user_id"=>get_authenticateUserID()));
		
		if($qry->num_rows()>0)
		{
			return $qry->result_array();
		}
		
		
		return 0;
		
	}
	
	/* 
	 * function : get_user_leisure_list
	 * get the user leisure data list
	 * @return array
	 * author: Thais
	 */
	
	function get_user_leisure_list()
	{
		$qry = $this->db->get_where("user_in_leisure",array("user_id"=>get_authenticateUserID()));
		
		if($qry->num_rows()>0)
		{
			return $qry->result_array();
		}
		
		
		return 0;
	}
	
	function user_update()
	{
		//update user details
		$data=array(
			'first_name'=>$this->input->post('first_name'),
			'nick_name'=>$this->input->post('nick_name'),
			'last_name'=>$this->input->post('last_name'),
			'address'=>$this->input->post('address'),
			'about_user'=>$this->input->post('about_user'),
			'gender'=>$this->input->post('gender'),
			'email'=>$this->input->post('email'),
			'user_city'=>$this->input->post('user_city'),
			'user_state'=>$this->input->post('user_state'),
			'user_zip'=> $this->input->post('user_zip'),
			'fb_link' => $this->input->post('fb_link'),
			'gplus_link' => $this->input->post('gplus_link'),
			'twitter_link' => $this->input->post('twitter_link'),
			'linkedin_link' => $this->input->post('linkedin_link'),
			'pinterest_link' => $this->input->post('pinterest_link'),
			'instagram_link' => $this->input->post('instagram_link'),
			'mobile_no'=>$this->input->post('mobile_no')
		);
		$this->db->where('user_id',get_authenticateUserID());
		$this->db->update('user_master',$data);
		
	}
	
	
	function taxi_owner_update()
	{
		//update user details
		$data=array(
			'first_name'=>$this->input->post('first_name'),
			'last_name'=>$this->input->post('last_name'),
			'address'=>$this->input->post('address'),
			'email'=>$this->input->post('email'),
			//'tax_company_name' => $this->input->post('tax_company_name'),
		//	'tax_cmpn_address' => $this->input->post('tax_cmpn_address'),
			//'texi_company_phone_number' => $this->input->post('texi_company_phone_number'),
			//'taxi_company_website' => $this->input->post('taxi_company_website'),
			//'reciew' => $this->input->post('reciew'),
			'mobile_no'=>$this->input->post('mobile_no')
		);
		$this->db->where('user_id',get_authenticateUserID());
		$this->db->update('user_master',$data);
		
		$data1=array(
			'taxi_company'=>$this->input->post('taxi_company'),
			'taxi_desc'=>$this->input->post('reciew'),
			'address'=>$this->input->post('address'),
			'city'=>$this->input->post('city'),
			'state'=>$this->input->post('state'),
			'cmpn_zipcode'=>$this->input->post('cmpn_zipcode'),
			'phone_number'=>$this->input->post('phone_number'),
			'cmpn_website'=>$this->input->post('cmpn_website')
		);
		$this->db->where('taxi_owner_id',get_authenticateUserID());
		$this->db->update('taxi_directory',$data1);
		
	}
	 
	function getFavoriteBeerCount($keyword)
	{
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
		$this->db->select('*');
		$this->db->from('all_likes');
		$this->db->join('beer_directory','beer_directory.beer_id=all_likes.beer_id');
		$this->db->where(array('all_likes.user_id'=>get_authenticateUserID(),'all_likes.beer_id !='=>'','all_likes.beer_fav_flag'=>1,'beer_directory.is_deleted'=>'no'));
		if($keyword!='' && $keyword!='1V1')
		{
		$this->db->like("beer_directory.beer_name",$keyword);	
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('beer_directory.beer_name',$val);
					}	
				}
		}		  
		$this->db->order_by('all_likes.like_id','desc');
		$query = $this->db->get();
// 		
		 // echo $this->db->last_query();
		 // die;
		return $query->num_rows();
	}

	function getFavoriteBeer($offset="",$limit="",$keyword='')
	{
		
		$this->db->select('*,all_likes.date_added as date_added');
		$this->db->from('all_likes');
		$this->db->join('beer_directory','beer_directory.beer_id=all_likes.beer_id');
		$this->db->where(array('all_likes.user_id'=>get_authenticateUserID(),'all_likes.beer_id !='=>'','all_likes.beer_fav_flag'=>1,'beer_directory.is_deleted'=>'no'));
		if($keyword!='' && $keyword!='1V1')
		{
		$this->db->like("beer_directory.beer_name",$keyword);
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('beer_directory.beer_name',$val);
					}	
				}
		}		  
		$this->db->order_by('all_likes.like_id','desc');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}
	
	function getFavoriteCocktailCount($keyword)
	{
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
		$this->db->select('*,all_likes.date_added as date_added');
		$this->db->from('all_likes');
		$this->db->join('cocktail_directory','cocktail_directory.cocktail_id=all_likes.cocktail_id');
		$this->db->where(array('all_likes.user_id'=>get_authenticateUserID(),'all_likes.cocktail_id !='=>'','all_likes.fav_flag'=>1,'cocktail_directory.is_deleted'=>'no'));
		if($keyword!='' && $keyword!='1V1')
		{
		$this->db->like("cocktail_directory.cocktail_name",$keyword);	
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('cocktail_directory.cocktail_name',$val);
					}	
				}
		}		  
		$this->db->order_by('all_likes.like_id','desc');
		$query = $this->db->get();
// 		
		 // echo $this->db->last_query();
		 // die;
		return $query->num_rows();
	}
	
	function getFavoriteLiquorCount($keyword)
	{
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
		$this->db->select('*');
		$this->db->from('all_likes');
		$this->db->join('liquors','liquors.liquor_id=all_likes.liquor_id');
		$this->db->where(array('all_likes.user_id'=>get_authenticateUserID(),'all_likes.liquor_id !='=>'','all_likes.fav_flag'=>1,'liquors.is_deleted'=>'no'));
		if($keyword!='' && $keyword!='1V1')
		{
		$this->db->like("liquors.liquor_title",$keyword);	
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('liquors.liquor_title',$val);
					}	
				}
		}		  
		$this->db->order_by('all_likes.like_id','desc');
		$query = $this->db->get();
// 		
		 // echo $this->db->last_query();
		 // die;
		return $query->num_rows();
	}

	function getFavoriteCocktail($offset="",$limit="",$keyword='')
	{
		
		$this->db->select('*,all_likes.date_added as date_added');
		$this->db->from('all_likes');
		$this->db->join('cocktail_directory','cocktail_directory.cocktail_id=all_likes.cocktail_id');
		$this->db->where(array('all_likes.user_id'=>get_authenticateUserID(),'all_likes.cocktail_id !='=>'','all_likes.fav_flag'=>1,'cocktail_directory.is_deleted'=>'no'));
		if($keyword!='' && $keyword!='1V1')
		{
		$this->db->like("cocktail_directory.cocktail_name",$keyword);
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('cocktail_directory.cocktail_name',$val);
					}	
				}
		}		  
		$this->db->order_by('all_likes.like_id','desc');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}
	
	function getFavoriteLiquor($offset="",$limit="",$keyword='')
	{
		
		$this->db->select('*,all_likes.date_added as date');
		$this->db->from('all_likes');
		$this->db->join('liquors','liquors.liquor_id=all_likes.liquor_id');
		$this->db->where(array('all_likes.user_id'=>get_authenticateUserID(),'all_likes.liquor_id !='=>'','all_likes.fav_flag'=>1,'liquors.is_deleted'=>'no'));
		if($keyword!='' && $keyword!='1V1')
		{
		$this->db->like("liquors.liquor_title",$keyword);
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('liquors.liquor_title',$val);
					}	
				}
		}		  
		$this->db->order_by('all_likes.like_id','desc');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}
	
	function getFavoriteBarCount($keyword)
	{
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
		$this->db->select('*');
		$this->db->from('all_likes');
		$this->db->join('bars','bars.bar_id=all_likes.bar_id');
		$this->db->where(array('all_likes.user_id'=>get_authenticateUserID(),'all_likes.bar_id !='=>'','all_likes.bar_fav_flag'=>1,'bars.is_deleted'=>'0'));
		if($keyword!='' && $keyword!='1V1')
		{
		$this->db->like("bars.bar_title",$keyword);	
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('bars.bar_title',$val);
					}	
				}
		}		  
		$this->db->order_by('all_likes.like_id','desc');
		$query = $this->db->get();
// 		
		 // echo $this->db->last_query();
		 // die;
		return $query->num_rows();
	}

	function getFavoriteBar($offset="",$limit="",$keyword='')
	{
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
		$this->db->select('*,all_likes.date_added as date_added');
		$this->db->from('all_likes');
		$this->db->join('bars','bars.bar_id=all_likes.bar_id');
		$this->db->where(array('all_likes.user_id'=>get_authenticateUserID(),'all_likes.bar_id !='=>'','all_likes.bar_fav_flag'=>1,'bars.is_deleted'=>'0'));
		if($keyword!='' && $keyword!='1V1')
		{
		$this->db->like("bars.bar_title",$keyword);
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('bars.bar_title',$val);
					}	
				}
		}		  
		$this->db->order_by('all_likes.like_id','desc');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}
	
	
	function getAllFavoriteBar($uid='',$offset='',$limit='')
	{
		
		$this->db->select('*');
		$this->db->from('all_likes');
		$this->db->join('bars','bars.bar_id=all_likes.bar_id');
		$this->db->where(array('all_likes.user_id'=>$uid,'all_likes.bar_id !='=>'','all_likes.bar_fav_flag'=>1,'bars.is_deleted'=>'0'));
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}

	function getAllFavoriteBeer($uid='',$offset='',$limit='')
	{
		
		
		$this->db->select('*,all_likes.date_added as date');
		$this->db->from('all_likes');
		$this->db->join('beer_directory','beer_directory.beer_id=all_likes.beer_id');
		$this->db->where(array('all_likes.user_id'=>$uid,'all_likes.beer_id !='=>'','all_likes.beer_fav_flag'=>1,'beer_directory.is_deleted'=>'no'));
		$this->db->order_by('all_likes.like_id','desc');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}
	
	function getAllFavoriteCocktail($uid='',$offset='',$limit='')
	{
		$this->db->select('*,all_likes.date_added as date');
		$this->db->from('all_likes');
		$this->db->join('cocktail_directory','cocktail_directory.cocktail_id=all_likes.cocktail_id');
		$this->db->where(array('all_likes.user_id'=>$uid,'all_likes.cocktail_id !='=>'','all_likes.fav_flag'=>1,'cocktail_directory.is_deleted'=>'no'));
		$this->db->order_by('all_likes.like_id','desc');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}

function getAllFavoriteLiquor($uid='',$offset='',$limit='')
	{
		$this->db->select('*,all_likes.date_added as date');
		$this->db->from('all_likes');
		$this->db->join('liquors','liquors.liquor_id=all_likes.liquor_id');
		$this->db->where(array('all_likes.user_id'=>$uid,'all_likes.liquor_id !='=>'','all_likes.fav_flag'=>1,'liquors.is_deleted'=>'no'));
		$this->db->order_by('all_likes.like_id','desc');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}
	
	function getBarGallerycount($keyword)
	{
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
		$this->db->select('*');
		$this->db->from('album');
		$this->db->where(array('bar_id'=>get_authenticateUserID()));
		if($keyword!='' && $keyword!='1V1')
		{
		$this->db->like("title",$keyword);	
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('title',$val);
					}	
				}
		}		  
		$this->db->order_by('bar_gallery_id','desc');
		$query = $this->db->get();
// 		
		 // echo $this->db->last_query();
		 // die;
		return $query->num_rows();
	}

	function getBarGalleryDetail($offset="",$limit="",$keyword='')
	{
		
		$this->db->select('*');
		$this->db->from('album');
		$this->db->where(array('bar_id'=>get_authenticateUserID()));
		if($keyword!='' && $keyword!='1V1')
		{
		$this->db->like("title",$keyword);	
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('title',$val);
					}	
				}
		}		  
		$this->db->order_by('reorder','asc');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
		
	}
	
	function bar_gallery_insert($bar_id='')
	{
		$this->load->library('upload');
		$data["title"] = $this->input->post('title');
		$data["description"] = $this->input->post('description');		
		$data["status"] = $this->input->post('status');
		$data["bar_id"] = get_authenticateUserID();
		$data["date_added"] = date("Y-m-d h:i:s");

		//date($site_setting->date_format,strtotime($rs->product_date));
        
		$this->db->insert('album',$data);	
		$gallery_id = mysql_insert_id();
		
		$datatick['image_title']=$this->input->post('image_title');
		if(isset($_FILES['photo_image']['name']) && count($_FILES['photo_image']['name'])>0)
		{ 
		foreach ($_FILES['photo_image']['name'] as $key => $value) {
		if($_FILES['photo_image']['name'][$key] != "")
        {
                 
			$rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['photo_image']['name'][$key];
             $_FILES['userfile']['type']     =   $_FILES['photo_image']['type'][$key];
             $_FILES['userfile']['tmp_name'] =   $_FILES['photo_image']['tmp_name'][$key];
             $_FILES['userfile']['error']    =   $_FILES['photo_image']['error'][$key];
             $_FILES['userfile']['size']     =   $_FILES['photo_image']['size'][$key];
   
			$config['file_name'] = $rand.'bargallery';
			
            $config['upload_path'] = base_path().'upload/bar_gallery_orig/';
			
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
            $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
		
			  } 
			   

			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		      $gd_var='gd2';
              $this->image_lib->clear();
		   	
			
			 resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big/'.$picture['file_name'],394,290);
              
			
			$this->image_lib->clear();
		   
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb/'.$picture['file_name'],65,47);
		   
		    $this->image_lib->clear();
		   
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big650by470/'.$picture['file_name'],650,470);
          $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big183by183/'.$picture['file_name'],183,183);
             
			$this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big140by140/'.$picture['file_name'],140,140);
             
             
			   $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big600by600/'.$picture['file_name'],600,600);
              
			  $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big200by200/'.$picture['file_name'],200,200);
              
             
			$company_image=$picture['file_name'];
			$pg=array('bar_gallery_id'=>$gallery_id,'bar_image_name'=>$company_image,'image_title'=>$datatick['image_title'][$key]);
			$this->db->insert('album_images',$pg);
			
			 } 
			}
				
		
		}
	}

     function bar_gallery_update()
	 {
	 	
		$this->load->library('upload');
		$data["title"] = $this->input->post('title');
		$data["description"] = $this->input->post('description');		
		$data["status"] = $this->input->post('status');
		$data["gallery"] = 'gallery';
		$data["bar_id"] = get_authenticateUserID();
		
		$this->db->where('bar_gallery_id',$this->input->post('bar_gallery_id'));
		$this->db->update('album',$data);
		$product_image = '';
		$img_id = $this->input->post('image_id');
		$preImg=$this->input->post('pre_img');
		$datatick['image_title']=$this->input->post('image_title');
			/***********INsert Gallery************/
		if(isset($_FILES['photo_image']['name']) && count($_FILES['photo_image']['name'])>0)
		{
			foreach ($_FILES['photo_image']['name'] as $key => $value) {
				
				$rand=rand(0,100000); 
			  if($_FILES['photo_image']['name'][$key] != "")
			  {
			  
             $_FILES['userfile']['name']     =   $_FILES['photo_image']['name'][$key];
             $_FILES['userfile']['type']     =   $_FILES['photo_image']['type'][$key];
             $_FILES['userfile']['tmp_name'] =   $_FILES['photo_image']['tmp_name'][$key];
             $_FILES['userfile']['error']    =   $_FILES['photo_image']['error'][$key];
             $_FILES['userfile']['size']     =   $_FILES['photo_image']['size'][$key];
   
			$config['file_name'] = $rand.'business';
			
            $config['upload_path'] = base_path().'upload/bar_gallery_orig/';
			
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				echo $error =  $this->upload->display_errors();die;   
			  } 
			   

			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   
              $this->image_lib->clear();
		   	
			
					$gd_var='gd2';
				
			 resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big/'.$picture['file_name'],394,290);
              
			
			$this->image_lib->clear();
		   
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb/'.$picture['file_name'],65,47);
               
			 $this->image_lib->clear();
		   
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big650by470/'.$picture['file_name'],650,470);
          $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big183by183/'.$picture['file_name'],183,183);
             
			   $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big140by140/'.$picture['file_name'],140,140);
             
			   $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big600by600/'.$picture['file_name'],600,600);
              
			  $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bar_gallery_thumb_big200by200/'.$picture['file_name'],200,200);
              
			$product_image=$picture['file_name'];
				
				
				if(isset($preImg[$key]) && $preImg[$key]!='')
				{
					if(file_exists(base_path().'upload/bar_gallery_thumb_big600by600/'.$preImg[$key]))
					{
						unlink(base_path().'upload/bar_gallery_thumb_big600by600/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/bar_gallery_thumb_big200by200/'.$preImg[$key]))
					{
						unlink(base_path().'upload/bar_gallery_thumb_big200by200/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/bar_gallery_thumb_big140by140/'.$preImg[$key]))
					{
						unlink(base_path().'upload/bar_gallery_thumb_big140by140/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/bar_gallery_thumb_big183by183/'.$preImg[$key]))
					{
						unlink(base_path().'upload/bar_gallery_thumb_big183by183/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/bar_gallery_orig/'.$preImg[$key]))
					{
						unlink(base_path().'upload/bar_gallery_orig/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/bar_gallery_thumb/'.$preImg[$key]))
					{
						unlink(base_path().'upload/bar_gallery_thumb/'.$preImg[$key]);
					}
					
					if(file_exists(base_path().'upload/bar_gallery_thumb_big/'.$preImg[$key]))
					{
						unlink(base_path().'upload/bar_gallery_thumb_big/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/bar_gallery_thumb_big650by470/'.$preImg[$key]))
					{
						unlink(base_path().'upload/bar_gallery_thumb_big650by470/'.$preImg[$key]);
					}
				}
				
				}
				else
				{
					$product_image = $preImg[$key];
				}
				
				if($product_image!=''){
				$pg=array('bar_gallery_id'=>$this->input->post('bar_gallery_id'),'bar_image_name'=>$product_image,'image_title'=>$datatick['image_title'][$key]);
				if(isset($img_id[$key]) && $img_id[$key]>0){
					$this->db->where('bar_image_id',$img_id[$key]);
					$this->db->update('album_images',$pg);
				}else{
					$this->db->insert('album_images',$pg);
				}
				}
				
			} 
				
				}
	 }

     function getOneGallery()
	 {
	 	  $this->db->select('*');
		  $this->db->from('album');
		  $this->db->where('bar_gallery_id',$this->input->post('id'));
		  $query = $this->db->get();
		  return $query->row(); 
	 }
	  function getGalleryImages()
	 {
	 	 $this->db->select('*');
		 $this->db->from('album_images');
		 $this->db->where('bar_gallery_id',$this->input->post('id'));
		 $query = $this->db->get();
		 if($query->num_rows()>0)
		 {
		 	return $query->result();
		 }
		 return '';
	 
	 }
	 
	   function getOneImageGallery($id)
	{
		$query = $this->db->get_where('album_images',array('bar_image_id'=>$id));
		return $query->row();
	}
	
	function getalbumgallery($id=0)
	{
		
		$this->db->select('*');
		$this->db->from('album');
		//$this->db->join('album_images','album.bar_gallery_id=album_images.bar_gallery_id');
		$this->db->where(array('album.bar_id'=>$id,'status'=>'Active'));
		$this->db->order_by('bar_gallery_id', 'desc');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return 0;
	}
	
	
	 function getalbumgalleryAll($user_id)
	{
		$this->db->select('*');
		$this->db->from('album');
		$this->db->join('album_images','album.bar_gallery_id=album_images.bar_gallery_id');
		$this->db->where(array('album.bar_id'=>$user_id,'status'=>'Active'));
		$this->db->group_by('reorder','asc');
		$this->db->group_by('album_images.bar_gallery_id');
		
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}

	function getsetting($id)
	{
		$query = $this->db->get_where('user_setting',array('user_id'=>$id));
		return $query->row();
	}
	
	function updateusersetting()
	{
		$data=array(
			'fname'=>$this->input->post('fname'),
			'user_id'=>get_authenticateUserID(),
			'lname'=>$this->input->post('lname'),
			'email1'=>$this->input->post('email1'),
			'gender1'=>$this->input->post('gender1'),
			'address1'=>$this->input->post('address1'),
			'mnum'=>$this->input->post('mnum'),
			'abt'=>$this->input->post('abt'),
			'pic'=>$this->input->post('pic'),
			'album'=>$this->input->post('album'),
		);
		$this->db->where('setting_id',$this->input->post('setting_id'));
		$this->db->update('user_setting',$data);
		return $this->input->post('setting_id');
	}

	function insertusersetting()
	{
		$data=array(
			'fname'=>$this->input->post('fname'),
			'user_id'=>get_authenticateUserID(),
			'lname'=>$this->input->post('lname'),
			'email1'=>$this->input->post('email1'),
			'gender1'=>$this->input->post('gender1'),
			'address1'=>$this->input->post('address1'),
			'mnum'=>$this->input->post('mnum'),
			'abt'=>$this->input->post('abt'),
			'pic'=>$this->input->post('pic'),
			'album'=>$this->input->post('album'),
		);
		//$this->db->where('setting_id',$this->input->post('setting_id'));
		$this->db->insert('user_setting',$data);
		$id = mysql_insert_id();
		return $id;
	}
	
	function getbarinfoByUserID($id)
	{
		$this->db->select('*');
		$this->db->from('bars');
		$this->db->where(array('owner_id'=>$id,'status'=>'active','is_deleted'=>'no'));
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		return 0;
	}
	
	 function getBarGalleryAll123($bar_id)
	{
		$this->db->select('*');
		$this->db->from('album_images');
		$this->db->where(array('bar_gallery_id'=>$bar_id));
		
		$query = $this->db->get();
		
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}
}
?>