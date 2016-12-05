<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	// --------------------------------------------------------------------
	/**
	 * Site Base Path
	 *
	 * @access	public
	 * @param	string	the Base Path string
	 * @return	string
	 */
	function base_path()
	{		
		$CI =& get_instance();
		return $base_path = $CI->config->slash_item('base_path');		
	}
	// --------------------------------------------------------------------

	/**
	 * Site Front Url
	 *
	 * @access	public
	 * @param	string	the Front Url string
	 * @return	string
	 */
	function front_base_url()
	{		
		$CI =& get_instance();
		return $base_path = $CI->config->slash_item('base_url_site');		
	}
	
	// --------------------------------------------------------------------

	/**
	 * Site Front ActiveTemplate
	 *
	 * @access	public
	 * @param	string	current theme folder name
	 * @return	string
	 */
	 function get_rights($rights_name)
	{
		$CI =& get_instance();
        if($CI->session->userdata('admin_type')==1)
		{
			return 1;
		}
		else{
		
		
		$right_detail = $CI->db->get_where("rights",array('rights_name'=>trim($rights_name)));
		
		
	   
		if($right_detail->num_rows()>0)
			{
				$right_result=$right_detail->row();
				$rights_id=$right_result->rights_id;

			$query=$CI->db->get_where("rights_assign",array('rights_id'=>$rights_id,'admin_id'=>$CI->session->userdata('admin_id')));
			
		
			if($query->num_rows()>0) {
				$result=$query->row();
				
				if($result->rights_set=='1' || $result->rights_set==1) {
					return 1;
				} else {
					return 0;
				}					
			} else {
					       return 0;
			}	
		} else {
			return 0;		
		}
		}
	}
	
	function getThemeName() {
		
		$default_theme_name='default';
		
		$CI =& get_instance();
		$query = $CI->db->get_where("template_manager",array('active_template'=>1 ,'is_admin_template'=>1));
		$row = $query->row();
		
		$theme_name=trim($row->template_name);
		
		if(is_dir(APPPATH.'views/'.$theme_name))
		{
			return $theme_name;
		}
		else
		{
			return $default_theme_name;	
		}
		
	}
		
	
	// --------------------------------------------------------------------

	/**
	 * Check user login
	 *
	 * @return	boolen
	 */
	function check_admin_authentication()
	{		
		$CI =& get_instance();
	
			if($CI->session->userdata('admin_id')!='')
			{
				return true;
			}
			else
			{
				return false;
			}
	
	}
	
	
	// --------------------------------------------------------------------

	/**
	 * get login user id
	 *
	 * @return	integer
	 */
	function get_authenticateadminID()
	{		
		$CI =& get_instance();
		return $CI->session->userdata('admin_id');
	}
	
	/*** get user name
	*  return string username
	**/
	function get_admin_login_name($uid)
	{		
		$CI =& get_instance();
		$query = $CI->db->get_where("admin",array('admin_id'=>$uid));
		//echo $CI->db->last_query();
		//die;
		if($query->num_rows() > 0)
		{
			$user = $query->row();
			return ucfirst($user->first_name.' '.$user->last_name);
		//return anchor(front_base_url().'user/'.$user->profile_name,ucfirst($user->first_name).' '.ucfirst(substr($user->last_name,0,1)),' style="color:#004C7A;" target="_blank"');
		}
		else
		{
			return 'N/A';
		}
	}
	
	
	
	
	/************************************************report end****************************/
	
	/** send email
	 * @return	integer
	 */
	 
	function email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str)
	{
				
		$CI =& get_instance();
		$query = $CI->db->get_where("email_setting",array('email_setting_id'=>1));
		$email_set=$query->row();
					
									
		$CI->load->library(array('email'));
			
		///////====smtp====
		
		if($email_set->mailer=='smtp')
		{
		
			$config['protocol']='smtp';  
			$config['smtp_host']=trim($email_set->smtp_host);  
			$config['smtp_port']=trim($email_set->smtp_port);  
			$config['smtp_timeout']='30';  
			$config['smtp_user']=trim($email_set->smtp_email);  
			$config['smtp_pass']=trim($email_set->smtp_password);  
					
		}
		
		/////=====sendmail======
		
		elseif(	$email_set->mailer=='sendmail')
		{	
		
			$config['protocol'] = 'sendmail';
			$config['mailpath'] = trim($email_set->sendmail_path);
			
		}
		
		/////=====php mail default======
		
		else
		{
		
		}
			
			
		$config['wordwrap'] = TRUE;	
		$config['mailtype'] = 'html';
		$config['crlf'] = '\n\n';
		$config['newline'] = '\n\n';
		
		$CI->email->initialize($config);	
				
		
		$CI->email->from($email_address_from);
		$CI->email->reply_to($email_address_reply);
		$CI->email->to($email_to);
		$CI->email->subject($email_subject);
		$CI->email->message($str);
		$CI->email->send();

	}
	
	
	
	
	/**
	 * generate random code
	 *
	 * @return	string
	 */
	
	function randomCode()
	{
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array(); 
		
		for ($i = 0; $i < 12; $i++) {
		$n = rand(0, strlen($alphabet)-1); //use strlen instead of count
		$pass[$i] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}
	
	
	/*** load site setting
	*  return single record array
	**/
	
	function site_setting()
	{		
		$CI =& get_instance();
		$query = $CI->db->get("site_setting");
		return $query->row();
	
	}
	
	
	function google_setting()
	{		
		$CI =& get_instance();
		$query = $CI->db->get("google_setting");
		return $query->row();
	
	}
	
	function facebook_setting()
	{		
		$CI =& get_instance();
		$query = $CI->db->get("facebook_setting");
		return $query->row();
	
	}
	
	function paypal_setting()
	{		
		$CI =& get_instance();
		$query = $CI->db->get("paypal");
		return $query->row();
	
	}
	
	
	function message_setting()
	{		
		$CI =& get_instance();
		$query = $CI->db->get("twilio_setting");
		return $query->row();
	
	}
	
	function yahoo_setting()
	{		
		$CI =& get_instance();
		$query = $CI->db->get("yahoo_setting");
		return $query->row();
	
	}
	
		
	/*** get all languages details
	*  return all record array
	**/
	
	function get_languages()
	{		
		$CI =& get_instance();
		$query = $CI->db->get('language');
		return $query->result();
	
	}

	
	/*** get user name
	*  return string username
	**/
		function get_user_name($id){
			$CI =& get_instance();
		
			$CI->db->select('first_name,last_name,profile_image');
			$CI->db->where('user_id',$id);
			$query=$CI->db->get('user_master');
			if($query->num_rows()>0){
			return  $query->row();
		}else{
			return '';
		}
			
		
	}
	
	function get_user_info($user_id='')
	{
		$CI =& get_instance();
		$query = $CI->db->get_where("user_master",array('user_id'=>$user_id));
		return $query->row();
	}
	
		
	/****  create seo friendly url 
	* var string $text
	**/ 	  
  
  	function clean_url($text) 
	{ 
	
		$text=strtolower($text); 
		$code_entities_match = array( '&quot;' ,'!' ,'@' ,'#' ,'$' ,'%' ,'^' ,'&' ,'*' ,'(' ,')' ,'+' ,'{' ,'}' ,'|' ,':' ,'"' ,'<' ,'>' ,'?' ,'[' ,']' ,'' ,';' ,"'" ,',' ,'.' ,'_' ,'/' ,'*' ,'+' ,'~' ,'`' ,'=' ,' ' ,'---' ,'--','--','�'); 
		$code_entities_replace = array('' ,'-' ,'-' ,'' ,'' ,'' ,'-' ,'-' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'-' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'-' ,'' ,'-' ,'-' ,'' ,'' ,'' ,'' ,'' ,'-' ,'-' ,'-','-'); 
		$text = str_replace($code_entities_match, $code_entities_replace, $text); 
		return $text; 
	} 
	
	
	
	
	function get_currency()
	{		
		$CI =& get_instance();
		$query = $CI->db->get('currency_code');
		return $query->result();
	
	}
	
	 function get_all_country()
	 {
	 	$CI =& get_instance();
		$query = $CI->db->get_where('country_master',array('is_delete'=>'n'));
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return 0;
		}
	 }
	
	
	
function getDuration($date)
{
     //   date_default_timezone_set("Europe/London");
        $CI =& get_instance();

		$curdate = date('Y-m-d H:i:s');
		
		
		$diff = abs(strtotime($date) - strtotime($curdate));
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		$hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 )/ (60*60));
		$mins = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ (60));
		
		$ago = '';
		if($years != 0){ if($years > 1) {$ago = $years.' years';} else { $ago = $years.' year';}}
		elseif($months != 0){ if($months > 1) {$ago = $months.' months';} else { $ago = $months.' month';}}
		elseif($days != 0) { if($days > 1) {$ago = $days.' days';} else { $ago = $days.' day';}}
		elseif($hours != 0){ if($hours > 1) {$ago = $hours.' hours';} else { $ago = $hours.' hour';}}
		else{ if($mins > 1) {$ago = $mins.' minutes';} else { $ago = $mins.' minute';}}
		return $ago.' ago';
}

function get_all_countries()
	{
		$CI =& get_instance();
		$query = $CI->db->get("country_master");
		if($query->num_rows() > 0)
		{
			return $query->result();
		}else{ return ''; }
	}
	function get_all_state($id=0)
	{
		$CI =& get_instance();
		$query = $CI->db->get_where("state_master",array('country_id'=>$id));
		if($query->num_rows() > 0)
		{
			return $query->result();
		}else{
				return '';
		}
	}
	
	
	
	function get_all_state_by_country_id($id=0)
	{
		$CI =& get_instance();
		$query = $CI->db->get_where("state_master",array('country_id'=>$id));
		//echo $query->num_rows();die;
		if($query->num_rows() > 0)
		{
			return $query->result();
		}else{
			return '';
		}
	}
	
	function get_all_city_by_state_id($id=0)
	{
		$CI =& get_instance();
		 ini_set('memory_limit','150M');
		$CI->db->select('city_name,city_id');
		$CI->db->group_by('city_name');
		$CI->db->where(array('state_id'=>$id));
		$CI->db->order_by('city_name','asc');
		$query = $CI->db->get("city_master");
		if($query->num_rows() > 0)
		{
			return $query->result();
		}else{
			return '';
		}
	}
	
	function get_slug ($str,$id=0)
    {
		$CI =& get_instance();
        $slug = url_title($str, 'dash', true);
		if($id!=0){
			 $query = $CI->db->get_where("category",array('slug'=>$slug,'category_id'=>$id));
			if($query->num_rows()>0){
			if($query->num_rows()==1){
				return $slug;
			}else{
				return $slug.($query->num_rows()+1);
			}
			}else{
				return $slug;
			}
		}else{
        $query = $CI->db->get_where("category",array('slug'=>$slug));
		if($query->num_rows()>0){
			return $slug.($query->num_rows()+1);
		}
		
        return $slug;
		}
    }
	
	
	
	function get_one_city($city_id)
	{
		$CI =& get_instance();
		$query = $CI->db->get_where("city",array('city_id'=>$city_id));
		if($query->num_rows() > 0)
		{
			return $query->row();
		}	else{
			return '';
		}
	}
	
	function get_one_state($state_id)
	{
		$CI =& get_instance();
		$query = $CI->db->get_where("state_master",array('state_id'=>$state_id));
		if($query->num_rows() > 0)
		{
			return $query->row();
		}	else{
			return '';
		}
	}
	
	
	function get_one_country($country_id)
	{
		$CI =& get_instance();
		$query = $CI->db->get_where("country_master",array('country_id'=>$country_id));
		if($query->num_rows() > 0)
		{
			return $query->row();
		}	else{
			return '';
		}
	}
	
	function clear_cache()
	{
		// header('Cache-Control: no-store, no-cache, must-revalidate');
		// header('Cache-Control: post-check=0, pre-check=0',false);
		// header('Pragma: no-cache');
	}
	function image_setting()
	{		
		$CI =& get_instance();
		$query = $CI->db->get("image_setting");
		return $query->row();
	
	}
	function get_patient_phone($pid=0)
	{
		$CI =& get_instance();
		$query = $CI->db->get_where("patient_phone_master",array('patient_master_id'=>$pid));
		if($query->num_rows() > 0)
		{
			return $query->row();
		}	else{
			return array();
		}
	}
	
	function get_doctor_category_list(){
		$CI =& get_instance();
		$CI->db->where(array("is_deleted"=>"n", "status"=>"Active"));
		$query = $CI->db->get("doctor_category");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return array();
		}
	}
	
	function get_doctor_list(){
		$CI =& get_instance();
		$CI->db->where("status","active");
		$query = $CI->db->get("doctor_master");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return array();
		}
	}
	
	function get_single_detail($user_id){
		$CI =& get_instance();
		$CI->db->where("user_id",$user_id);
		$query = $CI->db->get("user_master");
		
		//echo $CI->db->last_query();die;
		
		if($query->num_rows() > 0){
			$res = $query->row();
			//print_r($res); die;
			return $res;
		}else{
			
		}
	}
	
	function get_single_admin_detail($admin_id){
		$CI =& get_instance();
		$CI->db->where("admin_id",$admin_id);
		$query = $CI->db->get("admin");
		
		//echo $CI->db->last_query();die;
		
		if($query->num_rows() > 0){
			$res = $query->row();
			//print_r($res); die;
			return $res;
		}else{
			
		}
	}
	
	function get_member_single_detail($user_id){
		$CI =& get_instance();
		$CI->db->where("user_id",$user_id);
		$query = $CI->db->get("user_master");
		if($query->num_rows() > 0){
			$res = $query->row();
			return $res;
		}else{
			return 'N/A';
		}
	}
	
	function get_admin_single_detail($admin_id){
		$CI =& get_instance();
		$CI->db->where("admin_id",$admin_id);
		$query = $CI->db->get("admin");
		if($query->num_rows() > 0){
			$res = $query->row();
			return $res;
		}else{
			return 'N/A';
		}
	}
	
	function get_user_detail($user_id){
		$CI =& get_instance();
		//echo "right"; die;;
		$user_name = "N/A";
	
	       $CI->db->where("user_id",$user_id);
			$query = $CI->db->get("user_master");
			
			if($query->num_rows() > 0){
				$res = $query->row();
				$user_name = $res->first_name.' '.$res->last_name;
			}
		
		return $user_name;
		
	}
	function get_admin_detail($user_id){
		$CI =& get_instance();
		//echo "right"; die;;
		$user_name = "N/A";
	
	       $CI->db->where("admin_id",$user_id);
			$query = $CI->db->get("admin");
			
			if($query->num_rows() > 0){
				$res = $query->row();
				$user_name = $res->first_name.' '.$res->last_name;
			}
		
		return $user_name;
		
	}
	
	function get_parent_category_detail($sport_category_id){
		$CI =& get_instance();
		$CI->db->where("sport_category_id",$sport_category_id);
		$query = $CI->db->get("sport_category");
		if($query->num_rows() > 0){
			$res = $query->row();
			return $res->category_name;
		}else{
			return 'N/A';
		}
	}
	
	function getOfferName($id)
	{
		$CI =& get_instance();
		$query=$CI->db->get_where("package",array('package_id'=>$id));
	
		if($query->num_rows() > 0){
			$res = $query->row();
			return $res->package_name;
		}else{
			return 'N/A';
		}
	}
	
	function getBlogCount($id)
	{
		$CI =& get_instance();
		$query=$CI->db->get_where("blog",array('user_id'=>$id));
	
		if($query->num_rows() > 0){
			return $query->num_rows();
		}
		return 0;
	}
	
	 function get_offer_info($package_id='')
    {
        //Get package information or Offer information    
        $CI =& get_instance();
        $query = $CI->db->get_where("package",array('package_id'=>$package_id));
        if($query->num_rows()>0)
        {
            return $query->row();
        }
        else {
            return 'N/A';
        }
    }
  /*
  * function : maintain_log
  * common function add all user/doctor action in master log
  * return null
  * author: Thais
  */
 
 
 function maintain_log($data_insert = array())
 {
 	return true;
     // $CI =& get_instance();
     // $data_insert["user_type"] = 'admin';
     // $data_insert["user_id"] = get_authenticateadminID();
     // $data_insert["date_added"] = date("Y-m-d h:i:s");
     // $CI->db->insert("user_log_master",$data_insert);
     
}  
   
   
   /*
    * video rating
    * function get_video_rating
    * return stringh
    * auth : spaculus
    * */
    
    function get_beer_rating($beer_id = 0)
	{
		
	   $CI =& get_instance();
		$rating_tableName     = 'sss_beer_comment';
		$id=$beer_id;

	    //$q="SELECT  sum(beer_rating) AS rat,COUNT(*) AS tot FROM $rating_tableName WHERE beer_id=$id and beer_rating>0 ";

	$qry =  $CI->db->query("SELECT  sum(beer_rating) AS rat,COUNT(*) AS tot FROM ".$CI->db->dbprefix('beer_comment')." WHERE beer_id='".$id."' and beer_rating>0");
	$rat = 0;
	if($qry->num_rows()>0)
		{
			$row = $qry->row_array();
			$v=$row['tot'];
		    $tv=$row['rat'];
			if($v >0)
			{
				 $rat=$tv/$v;
			}
			
		
		}
	
	$final_rate = intval($rat);
	//echo 'tgs'  .$final_rate;die;
	$class = 'starrating';
	 if($final_rate == 1) { $class = "starrating1"; }
     else if($final_rate == 2) { $class = "starrating2"; }
	 else if($final_rate == 3) { $class = "starrating3"; }
	 else if($final_rate == 4) { $class = "starrating4"; }
      else if($final_rate == 5) { $class = "starrating5"; }
	
		
	  return '<div class="'.$class.'">  <a href="javascript://"></a> </div>';									
}
	function get_article_rating($article_id = 0)
	{
		
	   $CI =& get_instance();
	   $id=$article_id;
	 
	$qry =  $CI->db->query("SELECT  sum(article_rating) AS rat,COUNT(*) AS tot FROM ".$CI->db->dbprefix('article_rating')." WHERE article_id='".$id."'");
	$rat = 0;
	if($qry->num_rows()>0)
		{
			$row = $qry->row_array();
			$v=$row['tot'];
		    $tv=$row['rat'];
			
			if($v >0)
			{
				 $rat=$tv/$v;
			}
			
		
		}
	
	$final_rate = intval($rat);
	$class = 'starrating';
	 if($final_rate == 1) { $class = "starrating1"; }
     else if($final_rate == 2) { $class = "starrating2"; }
	 else if($final_rate == 3) { $class = "starrating3"; }
	 else if($final_rate == 4) { $class = "starrating4"; }
      else if($final_rate == 5) { $class = "starrating5"; }
	
		
	  return '<div class="'.$class.'">  <a href="javascript://"></a> </div>';									
}
	
	
	
function get_date ($d1) 
{

 return round(abs(strtotime($d1)-strtotime(date("Y-m-d")))/86400);

}  // end function dateDiff
	
/* End of file custom_helper.php */
/* Location: ./system/application/helpers/custom_helper.php */
/* Start get user information */
function get_cocktail_rating($bar_id = 0)
	{		
	    $CI =& get_instance();
		$rating_tableName     = 'sss_cocktail_comment';
		$id=$bar_id;

		$qry =  $CI->db->query("SELECT  sum(cocktail_rating) AS rat,COUNT(*) AS tot FROM ".$CI->db->dbprefix('cocktail_comment')." WHERE cocktail_id='".$id."' and cocktail_rating>0");
		$rat = 0;
		if($qry->num_rows()>0)
		{
			$row = $qry->row_array();
			$v=$row['tot'];
			$tv=$row['rat'];
			if($v >0)
			{
				 $rat=$tv/$v;
			}
		}
		
		$final_rate = intval($rat);
		//echo 'tgs'  .$final_rate;die;
		$class = 'starrating';
		if($final_rate == 1) { $class = "starrating1"; }
		else if($final_rate == 2) { $class = "starrating2"; }
		else if($final_rate == 3) { $class = "starrating3"; }
		else if($final_rate == 4) { $class = "starrating4"; }
		else if($final_rate == 5) { $class = "starrating5"; }
	
	
		
		return '<div class="'.$class.'">  <a href="javascript://"></a> </div>';									
	}
	function get_bar_rating($bar_id = 0)
	{		
	    $CI =& get_instance();
		$rating_tableName     = 'sss_bar_comment';
		$id=$bar_id;

		$qry =  $CI->db->query("SELECT  sum(bar_rating) AS rat,COUNT(*) AS tot FROM ".$CI->db->dbprefix('bar_comment')." WHERE bar_id='".$id."' and bar_rating>0");
		$rat = 0;
		if($qry->num_rows()>0)
		{
			$row = $qry->row_array();
			$v=$row['tot'];
			$tv=$row['rat'];
			if($v >0)
			{
				 $rat=$tv/$v;
			}
		}
		
		$final_rate = intval($rat);
		//echo 'tgs'  .$final_rate;die;
		$class = 'starrating';
		if($final_rate == 1) { $class = "starrating1"; }
		else if($final_rate == 2) { $class = "starrating2"; }
		else if($final_rate == 3) { $class = "starrating3"; }
		else if($final_rate == 4) { $class = "starrating4"; }
		else if($final_rate == 5) { $class = "starrating5"; }
	
	
		
		return '<div class="'.$class.'">  <a href="javascript://"></a> </div>';									
	}
	
	function checkbeerbarexist($beer_id,$bar_id)
	{
		$CI =& get_instance();
        $query = $CI->db->get_where("beer_bars",array('beer_id'=>$beer_id,'bar_id'=>$bar_id));
        if($query->num_rows()>0)
        {
            return 1;
        }
        else {
            return 0;
        }
	}

	function checkcocktailbarexist($cocktail_id,$bar_id)
	{
		   $CI =& get_instance();
        $query = $CI->db->get_where("cocktail_bars",array('cocktail_id'=>$cocktail_id,'bar_id'=>$bar_id));
        if($query->num_rows()>0)
        {
            return 1;
        }
        else {
            return 0;
        }
	}
	
	function checkliquorbarexist($liquor_id,$bar_id)
	{
		   $CI =& get_instance();
        $query = $CI->db->get_where("liquors_bars",array('liquor_id'=>$liquor_id,'bar_id'=>$bar_id));
        if($query->num_rows()>0)
        {
            return 1;
        }
        else {
            return 0;
        }
	}
	
	
	function get_admin_name($id){
	
		$CI =& get_instance();
			$CI->db->select('first_name,last_name');
			$CI->db->where('admin_id',$id);
			$query=$CI->db->get('admin');
			if($query->num_rows()>0){
			return  ucwords($query->row()->first_name.' '.$query->row()->last_name);
		}else{
			return '';
		}
			
		
	}

	function checkexist($tablename='',$dat=array())
	{
		$CI =& get_instance();
        $query = $CI->db->get_where($tablename,$dat);
        if($query->num_rows()>0)
        {
            return 1;
        }
        else {
            return 0;
        }
	} 
	
	function getBarSlug($str,$id=0)
    {
		$CI =& get_instance();
		//echo $str.$id;
		$str=str_replace('"','',str_replace(array(",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$str));
		$str=url_title(trim($str), 'dash', true);
    	 $slug = url_title(trim($str), 'dash', true);
		if($id!=0){
			 $query = $CI->db->get_where("bars",array("LCASE(REPLACE(bar_title,' ','-')) ="=>$str,'bar_id !='=>$id));
			
		}else{
        	$query = $CI->db->where("LCASE(REPLACE(bar_title,' ','-')) =",$str)->get("bars");
		}
		
		//echo $CI->db->last_query();die; 
		if($query->num_rows()>0){
			return $slug.($query->num_rows()+1);
		}
		
        return $slug;
		
    }
	
	function getNewsSlug($str,$id=0)
    {
		$CI =& get_instance();
		//echo $str.$id;
		$str=str_replace('"','',str_replace(array(",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$str));
		$str=url_title(trim($str), 'dash', true);
    	 $slug = url_title(trim($str), 'dash', true);
		if($id!=0){
			 $query = $CI->db->get_where("news",array("LCASE(REPLACE(news_title,' ','-')) ="=>$str,'news_id !='=>$id));
			
		}else{
        	$query = $CI->db->where("LCASE(REPLACE(news_title,' ','-')) =",$str)->get("news");
		}
		
		//echo $CI->db->last_query();die; 
		if($query->num_rows()>0){
			return $slug.($query->num_rows()+1);
		}
		
        return $slug;
		
    }
	
	function getBeerSlug($str,$id=0)
    {
		$CI =& get_instance();
		//echo $str.$id;
		$str=str_replace('"','',str_replace(array(",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$str));
		$str=url_title(trim($str), 'dash', true);
    	 $slug = url_title(trim($str), 'dash', true);
		if($id!=0){
			 $query = $CI->db->get_where("beer_directory",array("LCASE(REPLACE(beer_name,' ','-')) ="=>$str,'beer_id !='=>$id));
			
		}else{
        	$query = $CI->db->where("LCASE(REPLACE(beer_name,' ','-')) =",$str)->get("beer_directory");
		}
		
		//echo $CI->db->last_query();die; 
		if($query->num_rows()>0){
			return $slug.($query->num_rows()+1);
		}
		
        return $slug;
		
    }
	
	
	function getBeerSlug_new($str,$id=0)
    {
    	
		$CI =& get_instance();
		//echo $str.$id;
		$str=str_replace('"','',str_replace(array(",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$str));
		$str=url_title(trim($str), 'dash', true);
		
    	 $slug = url_title(trim($str), 'dash', true);
		 
		 
		if($id!=0){
			// $query = $CI->db->get_where("beer_directory",array("LCASE(REPLACE(beer_name,' ','-')) ="=>$str,'beer_id !='=>$id));
			
			$query = $CI->db->get_where("beer_directory",array("beer_slug ="=>$str,'beer_id !='=>$id));
			
		}else{
        	$query = $CI->db->where("beer_name =",$str)->get("beer_directory");
		}
		
		//echo $CI->db->last_query();die; 
		if($query->num_rows()>0){
			return $slug.($query->num_rows()+1);
		}
		
        return $slug;
		
    }
	
		function getCocktailSlug_new($str,$id=0)
    {
    	
		$CI =& get_instance();
		//echo $str.$id;
		$str=str_replace('"','',str_replace(array(",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$str));
		$str=url_title(trim($str), 'dash', true);
		
    	 $slug = url_title(trim($str), 'dash', true);
		 
		 
		if($id!=0){
			// $query = $CI->db->get_where("beer_directory",array("LCASE(REPLACE(beer_name,' ','-')) ="=>$str,'beer_id !='=>$id));
			
			$query = $CI->db->get_where("cocktail_directory",array("cocktail_slug ="=>$str,'cocktail_id !='=>$id));
			
		}else{
        	$query = $CI->db->where("cocktail_name =",$str)->get("cocktail_directory");
		}
		
		//echo $CI->db->last_query();die; 
		if($query->num_rows()>0){
			return $slug.($query->num_rows()+1);
		}
		
        return $slug;
		
    }
	function getLiquorSlug_new($str,$id=0)
    {
		$CI =& get_instance();
		//echo $str.$id;
		$str=str_replace('"','',str_replace(array(",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$str));
		$str=url_title(trim($str), 'dash', true);
    	 $slug = url_title(trim($str), 'dash', true);
		if($id!=0){
			 $query = $CI->db->get_where("liquors",array("LCASE(REPLACE(liquor_slug,' ','-')) ="=>$str,'liquor_id !='=>$id));
			
		}else{
        	$query = $CI->db->where("LCASE(REPLACE(liquor_slug,' ','-')) =",$str)->get("liquors");
		}
		
		//echo $CI->db->last_query();die; 
		if($query->num_rows()>0){
			return $slug.($query->num_rows()+1);
		}
		
        return $slug;
		
    }
	function getBarSlug_new($str,$id=0)
    {
    	
		$CI =& get_instance();
		//echo $str.$id;
		$str=str_replace('"','',str_replace(array(",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$str));
		$str=url_title(trim($str), 'dash', true);
		
    	 $slug = url_title(trim($str), 'dash', true);
		 
		 
		if($id!=0){
			// $query = $CI->db->get_where("beer_directory",array("LCASE(REPLACE(beer_name,' ','-')) ="=>$str,'beer_id !='=>$id));
			
			$query = $CI->db->get_where("bars",array("bar_slug ="=>$str,'bar_id !='=>$id));
			
		}else{
        	$query = $CI->db->where("bar_slug =",$str)->get("bars");
		}
		
		//echo $CI->db->last_query();//die; 
		if($query->num_rows()>0){
			return $slug.($query->num_rows()+1);
		}
		
        return $slug;
		
    }
	function getProductSlug($str,$id=0)
    {
		$CI =& get_instance();
		//echo $str.$id;
		$str=str_replace('"','',str_replace(array(",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$str));
		$str=url_title(trim($str), 'dash', true);
    	 $slug = url_title(trim($str), 'dash', true);
		if($id!=0){
			 $query = $CI->db->get_where("store",array("LCASE(REPLACE(product_name,' ','-')) ="=>$str,'store_id !='=>$id));
			
		}else{
        	$query = $CI->db->where("LCASE(REPLACE(product_name,' ','-')) =",$str)->get("store");
		}
		
		//echo $CI->db->last_query();die; 
		if($query->num_rows()>0){
			return $slug.($query->num_rows()+1);
		}
		
        return $slug;
		
    }
	
	function getCocktailSlug($str,$id=0)
    {
		$CI =& get_instance();
		//echo $str.$id;
		$str=str_replace('"','',str_replace(array(",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$str));
		$str=url_title(trim($str), 'dash', true);
    	 $slug = url_title(trim($str), 'dash', true);
		if($id!=0){
			 $query = $CI->db->get_where("cocktail_directory",array("LCASE(REPLACE(cocktail_name,' ','-')) ="=>$str,'cocktail_id !='=>$id));
			
		}else{
        	$query = $CI->db->where("LCASE(REPLACE(cocktail_name,' ','-')) =",$str)->get("cocktail_directory");
		}
		
		//echo $CI->db->last_query();die; 
		if($query->num_rows()>0){
			return $slug.($query->num_rows()+1);
		}
		
        return $slug;
		
    }
	
	function getLiquorSlug($str,$id=0)
    {
		$CI =& get_instance();
		//echo $str.$id;
		$str=str_replace('"','',str_replace(array(",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$str));
		$str=url_title(trim($str), 'dash', true);
    	 $slug = url_title(trim($str), 'dash', true);
		if($id!=0){
			 $query = $CI->db->get_where("liquors",array("LCASE(REPLACE(liquor_title,' ','-')) ="=>$str,'liquor_id !='=>$id));
			
		}else{
        	$query = $CI->db->where("LCASE(REPLACE(liquor_title,' ','-')) =",$str)->get("liquors");
		}
		
		//echo $CI->db->last_query();die; 
		if($query->num_rows()>0){
			return $slug.($query->num_rows()+1);
		}
		
        return $slug;
		
    }
	
	 function getReviewRating($bar_id = 0)
	{
		
	   $CI =& get_instance();
	   $id=$bar_id;
	 
	$qry =  $CI->db->query("SELECT  sum(bar_rating) AS rat,COUNT(*) AS tot FROM ".$CI->db->dbprefix('bar_comment')." WHERE is_deleted='no' and bar_id='".$bar_id."'");
	
	//echo $CI->db->last_query();
	//die;
	
	$rat = 0;
	if($qry->num_rows()>0)
		{
			$row = $qry->row_array();
			$v=$row['tot'];
		    $tv=$row['rat'];
			if($v >0)
			{
				 $rat=$tv/$v;
			}
		}
	
	
	$final_rate = intval($rat);
	$class = 'starrating11';
	 if($final_rate == 1) { $class = "starrating11"; }
     else if($final_rate == 2) { $class = "starrating12"; }
	 else if($final_rate == 3) { $class = "starrating13"; }
	 else if($final_rate == 4) { $class = "starrating14"; }
      else if($final_rate == 5) { $class = "starrating15"; }
	
		
	 return '<div class="'.$class.' pull-left mar_right20">  <a href="javascript://"></a> </div>';				
}
	
	function paypalsetting()
	{
		
	}
	
	function banner_pages()
	{
		$CI =& get_instance();
		$query = $CI->db->get("banner_pages");
		return $query->row();
	}
	
	function resize($source_image, $destination, $tn_w, $tn_h, $backcol='', $quality = 100, $wmsource = false)
	{
	
	
    $info = getimagesize($source_image);
    $imgtype = image_type_to_mime_type($info[2]);

    #assuming the mime type is correct
    switch ($imgtype) {
        case 'image/jpeg':
            $source = imagecreatefromjpeg($source_image);
            break;
        case 'image/gif':
            $source = imagecreatefromgif($source_image);
            break;
        case 'image/png':
            $source = imagecreatefrompng($source_image);
            break;
        default:
            die('Invalid image type.');
    }

    #Figure out the dimensions of the image and the dimensions of the desired thumbnail
    $src_w = imagesx($source);
    $src_h = imagesy($source);


    #Do some math to figure out which way we'll need to crop the image
    #to get it proportional to the new size, then crop or adjust as needed

    $x_ratio = $tn_w / $src_w;
    $y_ratio = $tn_h / $src_h;

    if (($src_w <= $tn_w) && ($src_h <= $tn_h)) {
        $new_w = $src_w;
        $new_h = $src_h;
    } elseif (($x_ratio * $src_h) < $tn_h) {
        $new_h = ceil($x_ratio * $src_h);
        $new_w = $tn_w;
    } else {
        $new_w = ceil($y_ratio * $src_w);
        $new_h = $tn_h;
    }

    $newpic = imagecreatetruecolor(round($new_w), round($new_h));
    imagecopyresampled($newpic, $source, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
    $final = imagecreatetruecolor($tn_w, $tn_h);
	if($backcol=='white'){
        $backgroundColor = imagecolorallocate($final, 255, 255, 255);
	}
	else
	{
		$backgroundColor = imagecolorallocate($final, 0, 0, 0);
	}	
    imagefill($final, 0, 0, $backgroundColor);
    //imagecopyresampled($final, $newpic, 0, 0, ($x_mid - ($tn_w / 2)), ($y_mid - ($tn_h / 2)), $tn_w, $tn_h, $tn_w, $tn_h);
    imagecopy($final, $newpic, (($tn_w - $new_w)/ 2), (($tn_h - $new_h) / 2), 0, 0, $new_w, $new_h);

    #if we need to add a watermark
    if ($wmsource) {
        #find out what type of image the watermark is
        $info    = getimagesize($wmsource);
        $imgtype = image_type_to_mime_type($info[2]);

        #assuming the mime type is correct
        switch ($imgtype) {
            case 'image/jpeg':
                $watermark = imagecreatefromjpeg($wmsource);
                break;
            case 'image/gif':
                $watermark = imagecreatefromgif($wmsource);
                break;
            case 'image/png':
                $watermark = imagecreatefrompng($wmsource);
                break;
            default:
                die('Invalid watermark type.');
        }

        #if we're adding a watermark, figure out the size of the watermark
        #and then place the watermark image on the bottom right of the image
        $wm_w = imagesx($watermark);
        $wm_h = imagesy($watermark);
        imagecopy($final, $watermark, $tn_w - $wm_w, $tn_h - $wm_h, 0, 0, $tn_w, $tn_h);

    }
    if (imagejpeg($final, $destination, $quality)) {
        return true;
    }
    return false;
}

   function get_unread_beer()
   {
   	  $CI =& get_instance();
			$CI->db->select('*');
			$CI->db->from('beer_directory');
			$CI->db->where(array('is_deleted'=>'no','states'=>'unread','status'=>'pending'));
			$query=$CI->db->get();
			
			if($query->num_rows()>0){
			return  $query->num_rows();
		}else{
			return 0;
		}
   }
   
   function get_unread_forum()
   {
   	  $CI =& get_instance();
			$CI->db->select('*');
			$CI->db->from('forum');
			$CI->db->where(array('states'=>'unread','status'=>'pending'));
			$query=$CI->db->get();
			
			if($query->num_rows()>0){
			return  $query->num_rows();
		}else{
			return 0;
		}
   }
   
    function get_unread_message()
   {
   	  $CI =& get_instance();
			$CI->db->select('*');
			$CI->db->from('message');
			$CI->db->where(array('is_deleted'=>'0','is_read'=>'0','status'=>'active','from_user_id !='=>'1'));
			$query=$CI->db->get();
			
			if($query->num_rows()>0){
			return  $query->num_rows();
		}else{
			return 0;
		}
   }
   
   function get_unread_cocktail()
   {
   	  $CI =& get_instance();
			$CI->db->select('*');
			$CI->db->from('cocktail_directory');
			$CI->db->where(array('is_deleted'=>'no','states'=>'unread','status'=>'pending'));
			$query=$CI->db->get();
			
			if($query->num_rows()>0){
			return  $query->num_rows();
		}else{
			return 0;
		}
   }
   
   function get_unread_liquor()
   {
   	  $CI =& get_instance();
			$CI->db->select('*');
			$CI->db->from('liquors');
			$CI->db->where(array('is_deleted'=>'no','states'=>'unread','status'=>'pending'));
			$query=$CI->db->get();
			
			if($query->num_rows()>0){
			return  $query->num_rows();
		}else{
			return 0;
		}
   }
   
    function get_unread_sugbar()
   {
   	  $CI =& get_instance();
			$CI->db->select('*');
			$CI->db->from('suggest_bars');
			$CI->db->where(array('states'=>'unread'));
			$CI->db->where(array('status'=>'pending'));
			$query=$CI->db->get();
			
			
			if($query->num_rows()>0){
			return  $query->num_rows();
		}else{
			return 0;
		}
   }
   
   function get_unread_reportbar()
   {
   	  $CI =& get_instance();
			$CI->db->select('*');
			$CI->db->from('report');
			$CI->db->where('r_st','0');
			$query=$CI->db->get();
			
						if($query->num_rows()>0){
			return  $query->num_rows();
		}else{
			return 0;
		}
   }
   
   function get_unread_reporttaxi()
   {
   	  $CI =& get_instance();
			$CI->db->select('*');
			$CI->db->from('report_taxi');
			$CI->db->where('r_st','0');
			$query=$CI->db->get();
			
						if($query->num_rows()>0){
			return  $query->num_rows();
		}else{
			return 0;
		}
   }

   function get_unread_agreed(){
   	  $CI =& get_instance();
			$CI->db->select('*');
			$CI->db->from('user_master');
			$CI->db->where(array('is_agree_shown'=>'0', 'agree' => '1'));
			$query=$CI->db->get();
			
						if($query->num_rows()>0){
			return  $query->num_rows();
		}else{
			return 0;
		}
   }

   function getColor()
	{
		$CI =& get_instance();
		$q=$CI->db->get_where('Color',array('status'=>'Active'));
		if($q->num_rows()>0)
		{
			return $q->result();
		}else{
			return '';
		}
	}
	
	function getSize()
	{
		$CI =& get_instance();
		$q=$CI->db->get_where('Size',array('status'=>'Active'));
		if($q->num_rows()>0)
		{
			return $q->result();
		}else{
			return '';
		}
	}
		function gettotalampunt()
	{
		$CI =& get_instance();
		$CI->db->from('order_master');
		$CI->db->select('sum(total) as total');
		$CI->db->where('order_master.is_deleted',"N");
		$CI->db->where('order_master.status',"Completed");
		$CI->db->group_by('order_master.status','Completed');
		$query=$CI->db->get();
		//$query=$this->db->get('order_master',$limit,$offset);
		//echo $this->db->last_query();die;
		$row = $query->row();
		if($row)
		{
			return $row->total;
		}
		else {
			return 0;
		}
	}
	function getsingleimage($id)
	{
		$CI =& get_instance();
		$q=$CI->db->get_where('product_images',array('product_id'=>$id));
		if($q->num_rows()>0)
		{
			$images	=	$q->row();
			return $images->product_image_name;
		}else{
			return '';
		}
	}
	
	function getlastlogindate($uid)
	{
		$CI =& get_instance();
		$q= $CI->db->order_by('login_id', 'desc')->get_where('user_login',array('user_id'=>$uid));
		if($q->num_rows()>0)
		{
			$new	=	$q->row();
			return $new->login_date_time;
		}else{
			return '';
		}
	}
	
	function getfeaturename($id)
	{
		$CI =& get_instance();
		$q=$CI->db->get_where('rights',array('module_id'=>$id));
		if($q->num_rows()>0)
		{
			return $q->result();
		}else{
			return '';
		}
	}

function getCoordinatesFromAddress_old($addr='',$city='',$state='',$country='' )
	{
		$sQuery=$addr.'+'.$city.'+'.$state.'+'.$country;
		//$sQuery=$addr.'+'.$city;
		$sURL = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($sQuery).'&sensor=false&region='.$country;
		
		$sData = file_get_contents($sURL);
		
		
		$data=json_decode($sData);
		$result=$data->results;
		
		if(isset($result[0]->geometry->location) && $result[0]->geometry->location!='')
		{
			$res=array('lat'=>$result[0]->geometry->location->lat,'lng'=>$result[0]->geometry->location->lng);
			return $res;
		}
		else
		{
			$res=array('lat'=>'','lng'=>'');
			return $res;
		}

	}
	function getallapi()
	{
		$CI =& get_instance();
		$q=$CI->db->get('mappi');
		if($q->num_rows()>0)
		{
			return $q->row();
		}else{
			return '';
		}
	}
	function getCoordinatesFromAddress($addr='',$city='',$state='',$country='' )
	{
		$CI =& get_instance();
		//$params = "address=" . urlencode($_GET{'addr'});
		//$url = 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false&' . $params;
		$sQuery=$addr.' '.$city.' '.$state.' '.$country;
		
		//echo $sQuery;
		///$url = 'http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($sQuery).'&sensor=false&region='.$country;
		
	//	$url = "https://maps.google.com/maps/api/geocode/json?address=".urlencode($sQuery)."&sensor=false&key=AIzaSyC3EDjDVgTV15wfNAX5trrNOiiHugrhnqg";
		
		$geturl = getallapi();
		
		
		$url = "https://maps.google.com/maps/api/geocode/json?address=".urlencode($sQuery)."&sensor=false&key=AIzaSyCoBWbzJwQyH5smmrKV07zhcrpYWszIiAQ";
		
		
		// $data_location .= "maps.google.com/maps/api/geocode/json?address=".urlencode(utf8_encode($address))."&sensor=false".$this->sensor."&key=AIzaSyC3EDjDVgTV15wfNAX5trrNOiiHugrhnqg";
		//echo $url;
		//die; 
		
		
		$json = file_get_contents($url);
		
		
		$data=json_decode($json);
		
		//$sQuery=$addr.'+'.$city.'+'.$state.'+'.$country;
		//$sQuery=$addr.'+'.$city;
		//$sURL = 'http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($sQuery).'&sensor=false&region='.$country;
		
		//$sData = file_get_contents($sURL);
		//$data=json_decode($sData);
		$result=$data->results;
		
		if(isset($result[0]->geometry->location) && $result[0]->geometry->location!='')
		{
			$res=array('lat'=>$result[0]->geometry->location->lat,'lng'=>$result[0]->geometry->location->lng);
			return $res;
		}
		else
		{
			$res=array('lat'=>'','lng'=>'');
			return $res;
		}

	}
	
	function getsuperadminemail()
	{		
		$CI =& get_instance();
		$query = $CI->db->get("site_setting");
		//echo $CI->db->last_query();
		//die;
		if($query->num_rows() > 0)
		{
			$user = $query->row();
			return $user->email_conversation;
		//return anchor(front_base_url().'user/'.$user->profile_name,ucfirst($user->first_name).' '.ucfirst(substr($user->last_name,0,1)),' style="color:#004C7A;" target="_blank"');
		}
		else
		{
			return 'info@americandivebar.com';
		}
	}
	
	function totalbeercomment($id)
	{
		 $CI =& get_instance();
			$CI->db->select('*');
			$CI->db->from('beer_comment');
			$CI->db->where(array('beer_id'=>$id,'master_comment_id'=>0));
			$query=$CI->db->get();
			
			if($query->num_rows()>0){
			return  $query->num_rows();
		}else{
			return 0;
		}
	}

function totalcocktailcomment($id)
	{
		 $CI =& get_instance();
			$CI->db->select('*');
			$CI->db->from('cocktail_comment');
			$CI->db->where(array('cocktail_id'=>$id,'master_comment_id'=>0));
			$query=$CI->db->get();
			
			if($query->num_rows()>0){
			return  $query->num_rows();
		}else{
			return 0;
		}
	}
	function totalliquorcomment($id)
	{
		 $CI =& get_instance();
			$CI->db->select('*');
			$CI->db->from('liquor_comment');
			$CI->db->where(array('liquor_id'=>$id,'master_comment_id'=>0));
			$query=$CI->db->get();
			
			if($query->num_rows()>0){
			return  $query->num_rows();
		}else{
			return 0;
		}
	}

function totalbarcomment($id)
	{
		 $CI =& get_instance();
			$CI->db->select('*');
			$CI->db->from('bar_comment');
			$CI->db->where(array('bar_id'=>$id));
			$query=$CI->db->get();
			
			if($query->num_rows()>0){
			return  $query->num_rows();
		}else{
			return 0;
		}
	}

   function getcountrecipient($id)
   {
   	 $CI =& get_instance();
			$CI->db->select('*');
			$CI->db->from('broadcast_message');
			$CI->db->where(array('number'=>$id));
			$query=$CI->db->get();
			
			if($query->num_rows()>0){
			return  $query->num_rows();
		}else{
			return 0;
		}
   	 
   }
   
   
   
   function sendPushNotificationAndroid($patient_id,$data)
	{
		//echo $patient_id; die;
		$that =& get_instance();
		$registatoin_ids_count	=	$that->db->select('COUNT(registered_android_id) as TOTAL')->where("gcm_regid",$patient_id)->get("registered_android")->row()->TOTAL;
		//print_r($registatoin_ids_count); die;
		//prd($registatoin_ids_count);

		if($registatoin_ids_count)
		{
			$site_setting = site_setting();
			//$device_login = $that->db->select('COUNT(android_session) as TOTAL')->where("patient_id",$patient_id)->get("registered_android")->row()->TOTAL;
			$registatoin_ids = $that->db->select('gcm_regid')->where(array("gcm_regid"=>$patient_id,"android_session"=>'1'))->get("registered_android");
			
			//prd($registatoin_ids->result());
			//prd($device_login);

			if($registatoin_ids->num_rows())
			{
				foreach($registatoin_ids->result() as $r)
				{
					$__registatoin_ids[] = $r->gcm_regid;
				}
				$registatoin_ids = $__registatoin_ids;
				//print_r($registatoin_ids); die;
				//prd($registatoin_ids);
				//$that->db->insert("test",array("data"=>serialize($registatoin_ids)));
				$url = 'https://android.googleapis.com/gcm/send';
	 
		        $fields = array(
		            'registration_ids' => $registatoin_ids,
		            'data' => $data,
		        );
		 		
				$temp ="AIzaSyD_ZMHoIPB5--2926J94uI0J8Tj-fZiPm4";
		 
		        $headers = array(
		            "Authorization: key=$temp",
		            'Content-Type: application/json'
		        );
		       
		        // Open connection
		        $ch = curl_init();

		        // Set the url, number of POST vars, POST data
		        curl_setopt($ch, CURLOPT_URL, $url);
		 
		        curl_setopt($ch, CURLOPT_POST, true);
		        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 
		        // Disabling SSL Certificate support temporarly
		        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		 
		        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		 
		        // Execute post
		        $result = curl_exec($ch);
				//print_r($result);
		       // echo "<br>";
			//	echo "<br>";
				//echo "<br>";
		        if ($result === FALSE) {
		            die('Curl failed: ' . curl_error($ch));
		        }
		 
		        // Close connection
		        curl_close($ch);
				//sleep(0.5);
				//$that->db->insert("test",array("data"=>$result));
				//ti($result);
				$res = json_decode($result);
				$res->results;
				if(isset($res->results) && $res->results)
				{
					for($i=0;$i<count($res->results);$i++)
					{
						if(isset($res->results[$i]->error))
						{
							//$that->db->delete('registered_android',array('gcm_regid'=>$registatoin_ids[$i]));
						}
					}
				}
				return $result;
			}
			else
			{
				//$that->db->insert('android_stored_notification',array("user_id"=>$patient_id,'notification'=>serialize($data)));
			}
		}
		
	}
   function sendPushNotificationiPhone($patient_id,$data)
	{
		//print_r(phpinfo()); die;
		//print_r($patient_id);
		//echo "<br>";
		$that =& get_instance();
		$registatoin_ids_count	=	$that->db->select('COUNT(registered_iphone_id) as TOTAL')->where("device_id",$patient_id)->get("registered_iphone")->row()->TOTAL;

		if($registatoin_ids_count)
		{
			$registatoin_ids = $that->db->select('token_id,sound_name')->where(array("device_id"=>$patient_id,"iphone_session"=>'1'))->get("registered_iphone");
			//echo $that->db->last_query();
			//echo "<br>";
			//print_r($registatoin_ids->result()); die;
			if($registatoin_ids->num_rows())
			{
				foreach($registatoin_ids->result() as $r)
				{
					
					$r->token_id;
					// Put your device token here (without spaces):
					$deviceToken = str_replace(array("<",">"," "),'',$r->token_id);
					//ti($deviceToken);
					// Put your private key's passphrase here:
					//$passphrase = 'Therapy';
					$passphrase = '123456';
					////////////////////////////////////////////////////////////////////////////////
					//echo base_path().'iphone/ck.pem';die;
					$ctx = stream_context_create();
					
					
					if($_SERVER['HTTP_HOST']=='test.americanbars.com')
					{
						//ab_ck.pem	
						// adb_dist_ck.pem
						$pem_file = 'ab_ck.pem';
						$stream = 'ssl://gateway.push.apple.com:2195';
						//$pem_file = 'adb-adhoc-ck.pem';
						//$stream = 'ssl://gateway.sandbox.push.apple.com:2195';
					}
					else
					{
						$pem_file = 'adb-adhoc-ck.pem';
						$stream = 'ssl://gateway.sandbox.push.apple.com:2195';
					}
					//echo front_base_url()."iphone/$pem_file"; die;
					stream_context_set_option($ctx, 'ssl', 'local_cert', base_path()."iphone/$pem_file");
					
					
					stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
					
					// Open a connection to the APNS server
					$fp = stream_socket_client(
						$stream, $err,
						$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
					
					if (!$fp)
						exit("Failed to connect: $err $errstr" . PHP_EOL);
					
					//echo 'Connected to APNS' . PHP_EOL;
					
					if($data['type'] == 'Recursive Reminder'){
						if($r->sound_name !=''){
							$sound =  $r->sound_name;	
						}
						else{
							$sound = 'Argonium-30s.mp3';
						}
						
					}else {
						$sound =  'default'; //'push_sound.wav';
					}
					
					// Create the payload body
					$body['aps'] = array(
						'alert' => $data['message'],
						//'sound' => 'push_sound.wav'
						'sound' => $sound,
						);
						
					$body['type'] = $data['type'];
					$body['subject'] = $data['subject'];
					
					// Encode the payload as JSON
					$payload = json_encode($body);
					//print_r($payload); die;
					// Build the binary notification
					$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
					
					// Send it to the server
					$result = fwrite($fp, $msg, strlen($msg));
					
					//print_r($result);
					//die;
					//prd($result,$msg,$payload);
					/*if (!$result)
						echo 'Message not delivered' . PHP_EOL;
					else
						echo 'Message successfully delivered' . PHP_EOL;*/
					
					// Close the connection to the server
					fclose($fp);
				}
				return (bool)$result;
			}
			else
			{
				//$that->db->insert('iphone_stored_notification',array("device_id"=>$patient_id,'notification'=>serialize($data)));
			}
			
		}


	}



?>
