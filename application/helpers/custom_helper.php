<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
	
	function getUserID() {
	       $CI =& get_instance();
			if($CI->session->userdata('user_id')!='')
			{
				return true;
			}
			else
			{
				return false;
			}
	}
	// --------------------------------------------------------------------
	
	function getThemeName()
	{
		
		$default_theme_name='default';
		
		$CI =& get_instance();
		
		return $default_theme_name;	
				
			
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
	
	function image_setting()
	{		
		$CI =& get_instance();
		$query = $CI->db->get("image_setting");
		return $query->row();
			
	
	}
	
	
	
	/** Function : randomCode
	 
	 *  @return string
	 * parameter: null
	 * author: sanjay Amin
	 */
	 
	 function randomCode($length=10) {
 
   		/* Only select from letters and numbers that are readable - no 0 or O etc..*/
  		 $characters = "23456789abcdefghijklmnopqrstuvwxyz";
        $string ='';
		   for ($p = 0; $p < $length; $p++) 
		   {
		       $string .= $characters[mt_rand(0, strlen($characters)-1)];
		   }
 
  		 return $string;
 
	}
	 

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
				
		
		$CI->email->from($email_address_from,"American Bars Team");
		$CI->email->reply_to($email_address_reply);
		$CI->email->to($email_to);
		$CI->email->subject($email_subject);
		$CI->email->message($str);
		$CI->email->send();

	}
	
	
	/**
 * Check user login
 *
 * @return    boolen
 */
function check_user_authentication()
{
	$CI =& get_instance();

	if ($CI->session->userdata('user_id') != '')
	{
		return true;
	} else
	{
		return false;
	}

}


/** get_user_type
 * author thais
 * retun user type string
 */
 
 function get_user_type()
{
	$CI =& get_instance();

	return $CI->session->userdata('user_type');

}

// --------------------------------------------------------------------

	/**
	 * get login user id
	 *
	 * @return	integer 
	 */
	function get_authenticateUserID()
	{		 
		$CI =& get_instance();
		return $CI->session->userdata('user_id');
	}
	
	function get_user_info($user_id='')
	{
		$CI =& get_instance();
		$query = $CI->db->get_where("user_master",array('user_id'=>$user_id));
		return $query->row();
	}
	
		function get_bar_info($user_id='')
	{
		$CI =& get_instance();
		//$query = $CI->db->get_where("user_master",array('user_id'=>$user_id));
		$CI->db->select('*');
		$CI->db->from('bars');
		$CI->db->join('user_master','bars.owner_id=user_master.user_id');
		$CI->db->where('owner_id',$user_id);
		$query = $CI->db->get();
		if($query->num_rows()>0)
		{
			 return $query->row(); 
		}
		return '';
	}
	
	function get_user_info_taxi($user_id='')
	{
		$CI =& get_instance();
		//$query = $CI->db->get_where("user_master",array('user_id'=>$user_id));
		$CI->db->select('*');
		$CI->db->from('user_master');
		$CI->db->join('taxi_directory','taxi_directory.taxi_owner_id=user_master.user_id');
		$CI->db->where('user_master.user_id',$user_id);
		$query = $CI->db->get();
		if($query->num_rows()>0)
		{
			 return $query->row(); 
		}
		return '';
		//return $query->row();
	}
	
/*** load meta setting
	*  return single record array
	**/
	
	function meta_setting()
	{		
		$CI =& get_instance();
		
		
		$supported_cache=check_supported_cache_driver();
		
		if(isset($supported_cache))
		{
			if($supported_cache!='' && $supported_cache!='none')
			{
				////===load cache driver===
				$CI->load->driver('cache');
				
				if($CI->cache->$supported_cache->get('meta_setting'))
				{
					return (object)$CI->cache->$supported_cache->get('meta_setting');				
				}
				else
				{
					$query = $CI->db->get("meta_setting");
					$CI->cache->$supported_cache->save('meta_setting', $query->row(),CACHE_VALID_SEC);	
					return $query->row();						
				}
			
			}
			
			else
			{
				$query = $CI->db->get("meta_setting");
				return $query->row();
			}
		}
		else
		{
			$query = $CI->db->get("meta_setting");
			return $query->row();
		}
		//////////====end cache part
	
	}


	function getDuration($date)
    {
		date_default_timezone_set("Europe/London"); 
		$CI =& get_instance();
		$curdate = date('Y-m-d H:i:s');
	    $diff = abs(strtotime($date) - strtotime($curdate));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 )/ (60*60));
        $mins = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ (60));
              
        $ago = '';
        if($years != 0){ if($years > 1) {$ago =  $years.' years';} else { $ago =  $years.' year';}}
        elseif($months != 0){ if($months > 1) {$ago =  $months.' months';} else { $ago =  $months.' month';}}
        elseif($days != 0) { if($days > 1) {$ago =  $days.' days';} else { $ago =  $days.' day';}}
        elseif($hours != 0){ if($hours > 1) {$ago =  $hours.' hours';} else { $ago =  $hours.' hour';}}
        else{ if($mins > 1) {$ago =  $mins.' minutes';} else { $ago =  $mins.' minute';}}
        return $ago.' ago';
    }

 
	function get_AllCountry()
	{
		$CI =& get_instance();
		
		$qry = $CI->db->query("select * from ".$CI->db->dbprefix("country_master"));
		
		if($qry->num_rows()>0)
		{
			
			return $qry->result();
		}
		
		return;
	}
	
	

 
 
 function get_admin_info($id=0,$type="")
 {
 	 $CI =& get_instance();
 	 $qry = $CI->db->query("select admin_id as user_id , first_name, last_name,email,image as profile_image from ".$CI->db->dbprefix('admin')." where admin_id = '".$id."' ");
		
	 if($qry->num_rows()>0)
	 {
			if($type == "arr")
			{
				return $qry->row_array();
			}
			else 
			{
				return $qry->row();
			}
		
	 }
 	
 	   return 0;
 }
 
 function count_video_comment($id =0)
 {
 	$CI =& get_instance();
 	$CI->db->select("video_comment_id");
	$CI->db->from("video_comment");
	$CI->db->where("video_id",$id);
	$CI->db->where("status","active");
	$CI->db->where("is_deleted","no");
	
	$qry = $CI->db->get();
	
	return $qry->num_rows();
 }
 
  function user_profile_picture($id =0)
 {
 	//echo $id; 
 	$CI =& get_instance();
 	$CI->db->select("profile_image");
	$CI->db->from("user_master");
	$CI->db->where("user_id",$id);
	
	$qry = $CI->db->get();
	//print_r($qry->row()); die;
	return $qry->row();
 }
 
 
function get_video_category_wise($vid = 0,$vcid = 0,$limit = 0,$offset = 0)
{
	 $CI =& get_instance();
	 
	 $CI->db->select("*");
	 $CI->db->from("video");
	 $CI->db->where("video_id !=",$vid);
	 $CI->db->where("video_category_id",$vcid);
	 $CI->db->limit($limit,$offset);
	 
	 $qry = $CI->db->get();
	 
	 if($qry->num_rows()>0)
	 {
	 	return $qry->result();
	 }
	 
	 return 0;
}
 
 function get_page_info($slug='')
  {
    $CI =& get_instance();
    $query=$CI->db->get_where('pages',array('slug'=>$slug,'active'=>'1'));
    if($query->num_rows>0)
    {
        return $query->row();
    }
    return false;
  } 
  function get_news_info($slug='')
  {
    $CI =& get_instance();
    $query=$CI->db->get_where('news',array('slug'=>$slug,'status'=>'active'));
    if($query->num_rows>0)
    {
        return $query->row();
    }
    return false;
  } 
  
  
  function check_already_video_rated($vid = 0,$uid=0)
  {
  	 $CI =& get_instance();
     $query=$CI->db->get_where('video_rating',array('video_id'=>$vid,'user_id'=>$uid));
     if($query->num_rows>0)
     {
        return 1;
     }
    return 0;
  }
  
   function count_article_comment($id =0)
 {
 	$CI =& get_instance();
 	$CI->db->select("article_comment_id");
	$CI->db->from("article_comment");
	$CI->db->where("article_id",$id);
	$CI->db->where("status","active");
	$CI->db->where("is_deleted","no");
	
	$qry = $CI->db->get();
	
	return $qry->num_rows();
 }
 
   function count_blog_comment($id =0)
 {
 	$CI =& get_instance();
 	$CI->db->select("blog_comment_id");
	$CI->db->from("blog_comment");
	$CI->db->where("blog_id",$id);
	$CI->db->where("status","active");
	$CI->db->where("is_deleted","no");
	
	$qry = $CI->db->get();
	
	return $qry->num_rows();
 }
    function count_forum_comment($id =0)
 {
 	$CI =& get_instance();
 	$CI->db->select("forum_comment_id");
	$CI->db->from("forum_comment");
	$CI->db->where("forum_id",$id);
	$CI->db->where("status","active");
	$CI->db->where("is_deleted","no");
	
	$qry = $CI->db->get();
	
	return $qry->num_rows();
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
	
		
	 return '<div class="'.$class.' wid115 fl_left">  <a href="javascript://"></a> </div>';				
}
	function get_blog_rating($article_id = 0)
	{
		
	   $CI =& get_instance();
	   $id=$article_id;
	 
	$qry =  $CI->db->query("SELECT  sum(blog_rating) AS rat,COUNT(*) AS tot FROM ".$CI->db->dbprefix('blog_rating')." WHERE blog_id='".$id."'");
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
	
		
	 return '<div class="'.$class.' wid115 fl_left">  <a href="javascript://"></a> </div>';				
}
	
	function get_blog_rating_count($article_id = 0)
	{
		
	   $CI =& get_instance();
	   $id=$article_id;
	 
	$qry =  $CI->db->query("SELECT  sum(blog_rating) AS rat,COUNT(*) AS tot FROM ".$CI->db->dbprefix('blog_rating')." WHERE blog_id='".$id."'");
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
	
	return $final_rate = intval($rat);
				
}
	function get_forum_rating($forum_id = 0)
	{
		
	   $CI =& get_instance();
	   $id=$forum_id;
	 
	$qry =  $CI->db->query("SELECT  sum(forum_rating) AS rat,COUNT(*) AS tot FROM ".$CI->db->dbprefix('forum_rating')." WHERE forum_id='".$id."'");
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
	
		
	 return '<div class="'.$class.' wid115 fl_left">  <a href="javascript://"></a> </div>';				
}
	
	
 function check_already_article_rated($vid = 0,$uid=0)
  {
  	 $CI =& get_instance();
     $query=$CI->db->get_where('article_rating',array('article_id'=>$vid,'user_id'=>$uid));
     if($query->num_rows>0)
     {
        return 1;
     }
    return 0;
  }
  
  function check_already_blog_rated($vid = 0,$uid=0)
  {
  	 $CI =& get_instance();
     $query=$CI->db->get_where('blog_rating',array('blog_id'=>$vid,'user_id'=>$uid));
     if($query->num_rows>0)
     {
        return 1;
     }
    return 0;
  }
  
  function check_already_forum_rated($vid = 0,$uid=0)
  {
  	 $CI =& get_instance();
     $query=$CI->db->get_where('forum_rating',array('forum_id'=>$vid,'user_id'=>$uid));
     if($query->num_rows>0)
     {
        return 1;
     }
    return 0;
  }	


	function get_article_category_wise($vid = 0,$arid = 0,$limit = 0,$offset = 0)
	{
		 $CI =& get_instance();
		 
		 $CI->db->select("*");
		 $CI->db->from("article");
		 $CI->db->where("article_id !=",$vid);
		 $CI->db->where("article_category_id",$arid);
		 $CI->db->limit($limit,$offset);
		 
		 $qry = $CI->db->get();
		 
		 if($qry->num_rows()>0)
		 {
			return $qry->result();
		 }
		 
		 return 0;
	}


	function get_forum_category($place ='')
	{
		$CI =& get_instance();
		if($place == "footer")
		{
			$CI->db->limit(5,0);
		}
		$qry = $CI->db->get_where("forum_category",array("status"=>"active"));
		
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		
		return 0;
	}

	function check_already_beer_rated($id = 0,$uid=0)
  	{
  	 	$CI =& get_instance();
     	$query=$CI->db->get_where('beer_comment',array('beer_id'=>$id,'user_id'=>$uid,'beer_rating >'=>0));
		
		
     	if($query->num_rows>0)
     	{
        	return 1;
     	}
    	return 0;
  	}
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
	
	function like_checker($beer_id=0,$user_id=0){
	 $CI =& get_instance();
		$CI->db->select('like_flag');
		$CI->db->from('all_likes');
		$CI->db->where('beer_id',$beer_id);
		$CI->db->where('beer_comment_id',0);
		$CI->db->where('user_id',$user_id);
		
		$qry =$CI->db->get();
		$query = $qry->row();
		
		//echo $CI->db->last_query();
		return  $qry->num_rows()>0?$query->like_flag:2;		
	}

	function like_checker_bar($bar_id=0,$user_id=0){
	 $CI =& get_instance();
		$CI->db->select('like_flag');
		$CI->db->from('all_likes');
		$CI->db->where('bar_id',$bar_id);
		$CI->db->where('user_id',$user_id);
		
		$qry =$CI->db->get();
		$query = $qry->row();
		return  $qry->num_rows()>0?$query->like_flag:2;		
	}

   
	function fav_checker($beer_id=0,$user_id=0){
	 $CI =& get_instance();
		$CI->db->select('beer_fav_flag');
		$CI->db->from('all_likes');
		$CI->db->where('beer_id',$beer_id);
		$CI->db->where('user_id',$user_id);
		
		$qry =$CI->db->get();
		$query = $qry->row();
		return  $qry->num_rows()>0?$query->beer_fav_flag:2;		
	}
	
	function checkBeerEntryAlready($beer_id=0,$user_id=0){
	 $CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('all_likes');
		$CI->db->where('beer_id',$beer_id);
		$CI->db->where('beer_comment_id',0);
		$CI->db->where('user_id',$user_id);
		
		$qry =$CI->db->get();
		$query = $qry->row();
		return  $qry->num_rows()>0?1:0;		
	}
	
	function checkCocktailEntryAlready($cocktail_id=0,$user_id=0){
	 $CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('all_likes');
		$CI->db->where('cocktail_id',$cocktail_id);
		$CI->db->where('cocktail_comment_id',0);
		$CI->db->where('user_id',$user_id);
		
		$qry =$CI->db->get();
		$query = $qry->row();
		return  $qry->num_rows()>0?1:0;		
	}
	
	function checkLiquorEntryAlready($liquor_id=0,$user_id=0){
	 $CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('all_likes');
		$CI->db->where('liquor_id',$liquor_id);
		$CI->db->where('liquor_comment_id',0);
		$CI->db->where('user_id',$user_id);
		
		$qry =$CI->db->get();
		$query = $qry->row();
		return  $qry->num_rows()>0?1:0;		
	}
	
	function checkBarEntryAlready($bar_id=0,$user_id=0){
	 $CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('all_likes');
		$CI->db->where('bar_id',$bar_id);
		$CI->db->where('user_id',$user_id);
		
		$qry =$CI->db->get();
		$query = $qry->row();
		return  $qry->num_rows()>0?1:0;		
	}
	
	function fav_checker_bar($beer_id=0,$user_id=0){
	 $CI =& get_instance();
		$CI->db->select('bar_fav_flag');
		$CI->db->from('all_likes');
		$CI->db->where('bar_id',$beer_id);
		$CI->db->where('user_id',$user_id);
		
		$qry =$CI->db->get();
		$query = $qry->row();
		
	
		return  $qry->num_rows()>0?$query->bar_fav_flag:2;		
	}
	function comment_like_checker($beer_id=0,$user_id=0,$comment_id=0){
		$CI =& get_instance();
		$CI->db->select('like_flag');
		$CI->db->from('all_likes');
		$CI->db->where('beer_id',$beer_id);
		$CI->db->where('user_id',$user_id);
		$CI->db->where('beer_comment_id',$comment_id);
		
		$qry =$CI->db->get();
		$query = $qry->row();
		
		return  $qry->num_rows()>0?$query->like_flag:2;		
	}
	function one_beer_likers($id=0){
	$CI =& get_instance();
		$CI->db->select('a.*,u.profile_image');
		$CI->db->from('all_likes a');		
		$CI->db->join('user_master u','u.user_id=a.user_id');
		$CI->db->where('a.beer_id',$id);
//		$CI->db->where('like_flag',$flg);
		$qry = $CI->db->get();
		echo '==>'.$qry->num_rows();die;
		if($qry->num_rows()>0){
			return $qry->row()->profile_image;
		}
//		print_r($qry);die;
	}
	function latest_comment($id=0,$cmt_id = 0){
		$CI =& get_instance();
		$CI->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$CI->db->from('beer_comment b');		
		$CI->db->join('user_master u','u.user_id=b.user_id',"left");
		$CI->db->where('b.beer_id',$id);
		$CI->db->where("b.beer_comment_id",$cmt_id);
		$CI->db->where('b.is_deleted',0);
		$CI->db->order_by('date_added','desc');
		$CI->db->limit(1);
		$qry = $CI->db->get();
		if($qry->num_rows() >0){
			return $qry->row();
		}
	}
	
	function get_beer_subcomments($id=0,$mci=0){
		$CI =& get_instance();
		$CI->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$CI->db->from('beer_comment b');		
		$CI->db->join('user_master u','u.user_id=b.user_id');
		$CI->db->where('b.beer_id',$id);
		$CI->db->where('b.is_deleted',0);
		$CI->db->where('b.master_comment_id',$mci);
		$CI->db->order_by('date_added',$mci);
		$qry = $CI->db->get();		
		if($qry->num_rows() >0){
			return $qry->result();
		}
//		print_r($qry);die;
	}
	function flag_return($beer_id,$comment_id){
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('all_likes');
		$CI->db->where('beer_id',$beer_id);
		$CI->db->where('beer_comment_id',$comment_id);
		$CI->db->where('like_flag',1);
		$query = $CI->db->get();
		if($query->num_rows() >0){
			return $query->num_rows();
		}
		else{
			return 0;
		}
	}
	
	function comment_rights($user_id,$comment_id){
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('beer_comment');
		$CI->db->where('user_id',$user_id);
		$CI->db->where('beer_comment_id',$comment_id);
		$query = $CI->db->get();
		if($query->num_rows() >0){
			return 'yes';
		}
		else{
			return 'no';
		}
	}
	
	function comment_blog_rights($user_id,$comment_id){
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('blog_comment');
		$CI->db->where('user_id',$user_id);
		$CI->db->where('blog_comment_id',$comment_id);
		$query = $CI->db->get();
		if($query->num_rows() >0){
			return 'yes';
		}
		else{
			return 'no';
		}
	}
	
	function toprelatedbeer($beer_id=0,$beer_type,$producer){
			
		$CI =& get_instance();
		$query = $CI->db->query("SELECT * FROM ".$CI->db->dbprefix('beer_directory')." WHERE `beer_id` != '".$beer_id."' and ( `beer_type` = '".$beer_type."' OR `producer` = '".$beer_type."') and is_deleted = 'no'  ORDER BY `date_added` LIMIT 5");
		
		
		if($query->num_rows() >0)
		{
			return $query->result();
		}
	}
	
	function toprelatedproduct($store_id=0,$product_name){
			
		$CI =& get_instance();
		$query = $CI->db->query("SELECT * FROM `sss_store` where status='active' and type='adbstore' and store_id!=$store_id ORDER BY RAND( ) LIMIT 0 , 4");
		
		
		if($query->num_rows() >0)
		{
			return $query->result();
		}
	}
	
	function check_already_bar_rated($id = 0,$uid=0)
  	{
  	 	$CI =& get_instance();
     	$query=$CI->db->get_where('bar_comment',array('bar_id'=>$id,'user_id'=>$uid,'bar_rating >'=>0));
		
     	if($query->num_rows>0)
     	{
        	return 1;
     	}
    	return 0;
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
		
		
		$class = 'starrating';
		if($final_rate == 1) { $class = "starrating1"; }
		else if($final_rate == 2) { $class = "starrating2"; }
		else if($final_rate == 3) { $class = "starrating3"; }
		else if($final_rate == 4) { $class = "starrating4"; }
		else if($final_rate == 5) { $class = "starrating5"; }
	
	
		
		return '<div class="'.$class.'">  <a href="javascript://"></a> </div>';									
	}
	
	function cocktail_like_checker($beer_id=0,$user_id=0){
	    $CI =& get_instance();
		$CI->db->select('like_flag');
		$CI->db->from('all_likes');
		$CI->db->where('cocktail_id',$beer_id);
		$CI->db->where('cocktail_comment_id',0);
		$CI->db->where('user_id',$user_id);
		
		$qry =$CI->db->get();
		$query = $qry->row();
		return  $qry->num_rows()>0?$query->like_flag:2;		
	}
	
	function liquor_like_checker($beer_id=0,$user_id=0){
	    $CI =& get_instance();
		$CI->db->select('like_flag');
		$CI->db->from('all_likes');
		$CI->db->where('liquor_id',$beer_id);
		$CI->db->where('liquor_comment_id',0);
		$CI->db->where('user_id',$user_id);
		
		$qry =$CI->db->get();
		$query = $qry->row();
		return  $qry->num_rows()>0?$query->like_flag:2;		
	}
	
	function cocktail_fav_checker($beer_id=0,$user_id=0){
	    $CI =& get_instance();
		$CI->db->select('fav_flag');
		$CI->db->from('all_likes');
		$CI->db->where('cocktail_id',$beer_id);
		$CI->db->where('user_id',$user_id);
		
		$qry =$CI->db->get();
		$query = $qry->row();
		return  $qry->num_rows()>0?$query->fav_flag:2;		
	}
	function liquor_fav_checker($beer_id=0,$user_id=0){
	 $CI =& get_instance();
		$CI->db->select('fav_flag');
		$CI->db->from('all_likes');
		$CI->db->where('liquor_id',$beer_id);
		$CI->db->where('user_id',$user_id);
		
		$qry =$CI->db->get();
		$query = $qry->row();
		return  $qry->num_rows()>0?$query->fav_flag:2;		
	}
	function check_already_cocktail_rated($id = 0,$uid=0)
  	{
  	 	$CI =& get_instance();
     	$query=$CI->db->get_where('cocktail_comment',array('cocktail_id'=>$id,'user_id'=>$uid,'cocktail_rating >'=>0));
		
     	if($query->num_rows>0)
     	{
        	return 1;
     	}
    	return 0;
  	}
	
	function check_already_liquor_rated($id = 0,$uid=0)
  	{
  	 	$CI =& get_instance();
     	$query=$CI->db->get_where('liquor_comment',array('liquor_id'=>$id,'user_id'=>$uid,'liquor_rating >'=>0));
		
     	if($query->num_rows>0)
     	{
        	return 1;
     	}
    	return 0;
  	}
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
	
	function get_liquor_rating($bar_id = 0)
	{		
	    $CI =& get_instance();
		$rating_tableName     = 'sss_liquor_comment';
		$id=$bar_id;

		$qry =  $CI->db->query("SELECT  sum(liquor_rating) AS rat,COUNT(*) AS tot FROM ".$CI->db->dbprefix('liquor_comment')." WHERE liquor_id='".$id."' and liquor_rating>0");
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
	function cocktail_latest_comment($id=0,$cmt_id = 0){
		$CI =& get_instance();
		$CI->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$CI->db->from('cocktail_comment b');		
		$CI->db->join('user_master u','u.user_id=b.user_id',"left");
		$CI->db->where('b.cocktail_id',$id);
		$CI->db->where("b.cocktail_comment_id",$cmt_id);
		$CI->db->where('b.is_deleted',0);
		$CI->db->order_by('date_added','desc');
		$CI->db->limit(1);
		$qry = $CI->db->get();
		if($qry->num_rows() >0){
			return $qry->row();
		}
	}
	
	function liquor_latest_comment($id=0,$cmt_id = 0){
		$CI =& get_instance();
		$CI->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$CI->db->from('liquor_comment b');		
		$CI->db->join('user_master u','u.user_id=b.user_id',"left");
		$CI->db->where('b.liquor_id',$id);
		$CI->db->where("b.liquor_comment_id",$cmt_id);
		$CI->db->where('b.is_deleted',0);
		$CI->db->order_by('date_added','desc');
		$CI->db->limit(1);
		$qry = $CI->db->get();
		if($qry->num_rows() >0){
			return $qry->row();
		}
	}
	function cocktail_comment_like_checker($cocktail_id=0,$user_id=0,$comment_id=0){
		$CI =& get_instance();
		$CI->db->select('like_flag');
		$CI->db->from('all_likes');
		$CI->db->where('cocktail_id',$cocktail_id);
		$CI->db->where('user_id',$user_id);
		$CI->db->where('cocktail_comment_id',$comment_id);
		
		$qry =$CI->db->get();
		$query = $qry->row();
		
		return  $qry->num_rows()>0?$query->like_flag:2;		
	}
	function liquor_comment_like_checker($liquor_id=0,$user_id=0,$comment_id=0){
		$CI =& get_instance();
		$CI->db->select('like_flag');
		$CI->db->from('all_likes');
		$CI->db->where('liquor_id',$liquor_id);
		$CI->db->where('user_id',$user_id);
		$CI->db->where('liquor_comment_id',$comment_id);
		
		$qry =$CI->db->get();
		$query = $qry->row();
		
		return  $qry->num_rows()>0?$query->like_flag:2;		
	}
	function cocktail_comment_rights($user_id,$comment_id){
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('cocktail_comment');
		$CI->db->where('user_id',$user_id);
		$CI->db->where('cocktail_comment_id',$comment_id);
		$query = $CI->db->get();
		if($query->num_rows() >0){
			return 'yes';
		}
		else{
			return 'no';
		}
	}
function liquor_comment_rights($user_id,$comment_id){
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('liquor_comment');
		$CI->db->where('user_id',$user_id);
		$CI->db->where('liquor_comment_id',$comment_id);
		$query = $CI->db->get();
		if($query->num_rows() >0){
			return 'yes';
		}
		else{
			return 'no';
		}
	}
	function cocktail_flag_return($cocktail_id,$comment_id){
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('all_likes');
		$CI->db->where('cocktail_id',$cocktail_id);
		$CI->db->where('cocktail_comment_id',$comment_id);
		$CI->db->where('like_flag',1);
		$query = $CI->db->get();
		if($query->num_rows() >0){
			return $query->num_rows();
		}
		else{
			return 0;
		}
	}
	function liquor_flag_return($liquor_id,$comment_id){
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('all_likes');
		$CI->db->where('liquor_id',$liquor_id);
		$CI->db->where('liquor_comment_id',$comment_id);
		$CI->db->where('like_flag',1);
		$query = $CI->db->get();
		if($query->num_rows() >0){
			return $query->num_rows();
		}
		else{
			return 0;
		}
	}
	function toprelated_cocktail($cocktail_id=0,$type){
			
		$CI =& get_instance();
		$query = $CI->db->query("SELECT * FROM ".$CI->db->dbprefix('cocktail_directory')." WHERE `cocktail_id` != '".$cocktail_id."' and `type` = '".$type."'  ORDER BY `date_added` LIMIT 5");
		
		if($query->num_rows() >0)
		{
			return $query->result();
		}
	}
	
	function latest_bar_comment($id=0,$cmt_id = 0){
		$CI =& get_instance();
		$CI->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$CI->db->from('bar_comment b');		
		$CI->db->join('user_master u','u.user_id=b.user_id',"left");
		$CI->db->where('b.bar_id',$id);
		$CI->db->where("b.bar_comment_id",$cmt_id);
		//$CI->db->where('b.is_deleted',0);
		$CI->db->order_by('date_added','desc');
		$CI->db->limit(1);
		$qry = $CI->db->get();
		
	
		if($qry->num_rows() >0){
			return $qry->row();
		}
	}
	
	
	function latest_forum_comment($cmt_id = 0){
		$CI =& get_instance();
		$CI->db->join("user_master","user_master.user_id = forum_comment.user_id");
		$qry = $CI->db->get_where("forum_comment",array("forum_comment_id"=>$cmt_id));
		
		
		if($qry->num_rows()>0)
		{
			  return $qry->row();
		}
		
		return 0;
	}
	
		function latest_blog_comment($cmt_id = 0){
		$CI =& get_instance();
		$CI->db->join("user_master","user_master.user_id = blog_comment.user_id");
		$qry = $CI->db->get_where("blog_comment",array("blog_comment_id"=>$cmt_id));
		
		
		if($qry->num_rows()>0)
		{
			  return $qry->row();
		}
		
		return 0;
	}
	
	function getCoordinatesFromAddress_orig($addr='',$city='',$state='',$country='' )
	{
		$sQuery=$addr.' '.$city.' '.$state.' '.$country;
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

    function getTodayPostCard($bar_id)
	{
		$date1 = date('Y-m-d h:i:s');
		$date2 = date('Y-m-d h:i:s', strtotime('-1 day', strtotime($date1)));
		$CI =& get_instance();
		$CI->db->select("*");
		$CI->db->from('bar_post_card');
		$CI->db->where(array('bar_id'=>$bar_id,'is_delete'=>'0','user_id'=>get_authenticateUserID()));
		//$CI->db->where(array('bar_id'=>$bar_id,'is_delete'=>'0'));
		$CI->db->where('date_added <= ',$date1);
		$CI->db->where('date_added >= ',$date2);
		$query = $CI->db->get();
	    if($query->num_rows() >0){
			return $query->row_array();
		}
		else{
			return 0;
		}
	}
	
	 function getReviewRating($bar_id = 0)
	{
		
	   $CI =& get_instance();
	   $id=$bar_id;
	 
	$qry =  $CI->db->query("SELECT  sum(bar_rating) AS rat,COUNT(*) AS tot FROM ".$CI->db->dbprefix('bar_comment')." WHERE is_deleted='no' and bar_id='".$bar_id."'");
	
	
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
	
		
	 return '<div class="'.$class.' pull-left ">  <a href="javascript://"></a> </div>';				
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
	
	function readmsg($id)
	  {
	  		$CI =& get_instance();
			$CI->db->select('*');
			$CI->db->from('message');
			$CI->db->where(array('master_message_id'=>$id,'from_user_type'=>'admin','to_user_id'=>get_authenticateUserID(),'is_read'=>0));
			$query=$CI->db->get();
			
			if($query->num_rows()>0){
			return  $query->num_rows();
		}else{
			return 0;
		}
			
	  }
	  
	  function readmsg_am($id)
	  {
	  		$CI =& get_instance();
			$CI->db->select('*');
			$CI->db->from('message');
			$CI->db->where(array('message_id'=>$id,'from_user_type'=>'admin','to_user_id'=>get_authenticateUserID(),'is_read'=>0));
			$query=$CI->db->get();
			
			
			if($query->num_rows()>0){
			return  $query->num_rows();
		}else{
			return 0;
		}
			
	  }
	  
	  function readmsg_user($id)
	  {
	  		$CI =& get_instance();
			$CI->db->select('*');
			$CI->db->from('message_user');
			$CI->db->where(array('master_message_id'=>$id,'from_user_type'=>'sender','to_user_id'=>get_authenticateUserID(),'is_read'=>0));
			
			
			$query=$CI->db->get();
			
			if($query->num_rows()>0){
			return  $query->num_rows();
		}else{
			return 0;
		}
			
	  }
	  
	  function readmsg_user_1($id)
	  {
	  		$CI =& get_instance();
			$CI->db->select('*');
			$CI->db->from('message_user');
			$CI->db->where(array('message_id'=>$id,'from_user_type'=>'sender','to_user_id'=>get_authenticateUserID(),'is_read'=>0));
			
			
			$query=$CI->db->get();
			
			if($query->num_rows()>0){
			return  $query->num_rows();
		}else{
			return 0;
		}
			
	  }
  	function unread_message()
	{
	  		$CI =& get_instance();
			$CI->db->select('*');
			$CI->db->from('message_user');
			$CI->db->where(array('from_user_type'=>'sender','to_user_id'=>get_authenticateUserID(),'is_read'=>0));
			
			
			$query=$CI->db->get();
			
			if($query->num_rows()>0){
			return  $query->num_rows();
		}else{
			return 0;
		}
			
	  }
	
		function unread_message_admin()
	{
	  		$CI =& get_instance();
			$CI->db->select('*');
			$CI->db->from('message');
			$CI->db->where(array('from_user_type'=>'admin','to_user_id'=>get_authenticateUserID(),'is_read'=>0));
			
			
			$query=$CI->db->get();
			
			
			if($query->num_rows()>0){
			return  $query->num_rows();
		}else{
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
	
	function getBarID($slug)
	{
		$CI =& get_instance();
		$CI->db->where("bar_slug",$slug);
		$query = $CI->db->get("bars");
		
		
		if($query->num_rows() > 0){
			$res = $query->row();
			return $res->bar_id;
		}else{
			return '';
		}
	}
	
	function getBarName($bar_id)
	{
		$CI =& get_instance();
		$CI->db->where("bar_id",$bar_id);
		$query = $CI->db->get("bars");
		if($query->num_rows() > 0){
			$res = $query->row();
			return $res->bar_title;
		}else{
			return '';
		}
	}
	
	function getBarsl($bar_id)
	{
		$CI =& get_instance();
		$CI->db->where("bar_id",$bar_id);
		$query = $CI->db->get("bars");
		if($query->num_rows() > 0){
			$res = $query->row();
			return $res->bar_slug;
		}else{
			return '';
		}
	}
	
	function getBeerID($slug)
	{
		$CI =& get_instance();
		$CI->db->where("beer_slug",$slug);
		$query = $CI->db->get("beer_directory");
		if($query->num_rows() > 0){
			$res = $query->row();
			return $res->beer_id;
		}else{
			return '';
		}
	}
	
	function getBlogID($slug)
	{
		$CI =& get_instance();
		$CI->db->where("slug",$slug);
		$query = $CI->db->get("blog");
		if($query->num_rows() > 0){
			$res = $query->row();
			return $res->blog_id;
		}else{
			return '';
		}
	}
	
	function getProductID($slug)
	{
		$CI =& get_instance();
		$CI->db->where("product_slug",$slug);
		$query = $CI->db->get("store");
		if($query->num_rows() > 0){
			$res = $query->row();
			return $res->store_id;
		}else{
			return '';
		}
	}
	
	function getCocktailID($slug)
	{
		$CI =& get_instance();
		$CI->db->where("cocktail_slug",$slug);
		$query = $CI->db->get("cocktail_directory");
		if($query->num_rows() > 0){
			$res = $query->row();
			return $res->cocktail_id;
		}else{
			return '';
		}
	}
	
	function getliquorID($slug)
	{
		$CI =& get_instance();
		$CI->db->where("liquor_slug",$slug);
		$query = $CI->db->get("liquors");
		if($query->num_rows() > 0){
			$res = $query->row();
			return $res->liquor_id;
		}else{
			return '';
		}
	}
	
	function getimagename($event_id)
	{
		$that =& get_instance();
		$query	=	$that->db->get_where("event_images",array("bar_eventgallery_id"=>$event_id));
		if($query->num_rows())
		{
			$images	=	$query->result();
			
			foreach($images as $i)
			{
				if(file_exists(base_path()."upload/bar_eventgallery_thumb_big/$i->event_image_name"))
				return	base_url()."upload/bar_eventgallery_thumb_big/$i->event_image_name";
			}
		}
		return	base_url()."upload/event_default.jpg";
	}
	
	function getimagenameorig($event_id)
	{
		$that =& get_instance();
		$query	=	$that->db->get_where("event_images",array("bar_eventgallery_id"=>$event_id));
		if($query->num_rows())
		{
			$images	=	$query->result();
			
			foreach($images as $i)
			{
				if(file_exists(base_path()."upload/bar_eventgallery_orig/$i->event_image_name"))
				return	base_url()."upload/bar_eventgallery_orig/$i->event_image_name";
			}
		}
		return	base_url()."upload/event_default.jpg";
	}
	function geteventimagethumb($event_id)
	{
		$that =& get_instance();
		$query	=	$that->db->get_where("event_images",array("bar_eventgallery_id"=>$event_id));
		if($query->num_rows())
		{
			$images	=	$query->result();
			
			foreach($images as $i)
			{
				if(file_exists(base_path()."upload/bar_eventgallery_thumb/$i->event_image_name"))
				return	base_url()."upload/bar_eventgallery_thumb/$i->event_image_name";
			}
		}
		return	base_url()."upload/event_default.jpg";
	}
	
	function getimagenamegal($gal_id)
	{
		$that =& get_instance();
		$query	=	$that->db->get_where("bar_images",array("bar_gallery_id"=>$gal_id));
		if($query->num_rows())
		{
			$images	=	$query->result();
			
			foreach($images as $i)
			{
				if(file_exists(base_path()."upload/bar_gallery_thumb_big/$i->bar_image_name"))
				return	base_url()."upload/bar_gallery_thumb_big/$i->bar_image_name";
			}
		}
		return	base_url()."upload/event_default.jpg";
	}
	
	function getimagenameoriggal($gal_id)
	{
		
		$that =& get_instance();
		$query	=	$that->db->get_where("bar_images",array("bar_gallery_id"=>$gal_id));
		if($query->num_rows())
		{
			$images	=	$query->result();
			
			foreach($images as $i)
			{
				if(file_exists(base_path()."upload/bar_gallery_orig/$i->bar_image_name"))
				return	base_url()."upload/bar_gallery_orig/$i->bar_image_name";
			}
		}
		return	base_url()."upload/event_default.jpg";
	}
	
	function paypalsetting()
	{
		$CI =& get_instance();
		
		$qry = $CI->db->query("select * from ".$CI->db->dbprefix("paypal"));
		
		if($qry->num_rows()>0)
		{
			
			return $qry->row();
		}
		
		return;
	}
	
	function getadvertisement($page='',$pos=0)
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('advertisement_master');
		$CI->db->where('( `number_click` > `total_click` and type="click" OR `number_visit` > `total_visit` and type="visit")');
		$CI->db->where('(`pages` LIKE  \'%'.mysql_real_escape_string($page).'%\')', NULL, 'FALSE');
		$CI->db->where('status', 'active');
		
		
		if($pos!='0')
		{
			$CI->db->where('position', $pos);
		}
	    $CI->db->order_by('advertisement_id', 'RANDOM');
	    
	    $CI->db->limit(1);
	    
		$query = $CI->db->get();
		//echo $CI->db->last_query();
	    if($query->num_rows()>0)
	    {
	    	 return $query->row_array();
	    }
		else {
		     return '';	
		}
	   
	}
	
	function getadvertisementtrivia($page='',$pos=0)
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('advertisement_master');
		$CI->db->where('( `number_click` > `total_click` and type="click" OR `number_visit` > `total_visit` and type="visit")');
		$CI->db->where('(`pages` LIKE  \'%'.mysql_real_escape_string($page).'%\')', NULL, 'FALSE');
		$CI->db->where('status', 'active');
		
		
		if($pos!='0')
		{
			$CI->db->where('position', $pos);
		}
	    $CI->db->order_by('advertisement_id', 'RANDOM');
	    
	    $CI->db->limit(3);
	    
		$query = $CI->db->get();
		//echo $CI->db->last_query();
	    if($query->num_rows()>0)
	    {
	    	 return $query->result();
	    }
		else {
		     return '';	
		}
	   
	}
	
	function getadvertisementSearch($page='',$pos=0,$keyword='')
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('advertisement_master');
		//$CI->db->where('(`pages` LIKE  \'%'.mysql_real_escape_string($page).'%\')', NULL, 'FALSE');
		$CI->db->where('( `number_click` > `total_click` and type="click" OR `number_visit` > `total_visit` and type="visit")');
		$CI->db->where('(`pages` LIKE  \'%'.mysql_real_escape_string($page).'%\')', NULL, 'FALSE');
		$CI->db->where('status', 'active');
		//$CI->db->where('(`city_zip` LIKE  \''.mysql_real_escape_string($keyword).'%\')', NULL, 'FALSE');
		$CI->db->where ("FIND_IN_SET('".mysql_real_escape_string($keyword)."', city_zip)");
		
		if($pos!='0')
		{
			$CI->db->where('position', $pos);
		}
	    $CI->db->order_by('advertisement_id', 'RANDOM');
	    
	    $CI->db->limit(1);
	    
		$query = $CI->db->get();
		//echo $CI->db->last_query();
	    if($query->num_rows()>0)
	    {
	    	 return $query->row_array();
	    }
		else {
		     return '';	
		}
	   
	}
	
	function getadvertisementByIDCount($id,$type)
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('count_clcik_advertisement');
		$CI->db->where('advertisement_id', $id);
		$CI->db->where('click_type', $type);
		$query = $CI->db->get();
		
		
		
	    if($query->num_rows()>0)
	    {
	    	 return $query->num_rows();
	    }
		else {
		     return 0;	
		}
	}
	
	function getadvertisementBannerByIDCount($id,$type)
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('count_clcik_advertisement_banner');
		$CI->db->where('banner_pages_id', $id);
		$CI->db->where('click_type', $type);
		$query = $CI->db->get();
		
		
		
	    if($query->num_rows()>0)
	    {
	    	 return $query->num_rows();
	    }
		else {
		     return 0;	
		}
	}
	
	function getadvertisementSearchBar1($page='',$pos=0,$city,$zipcode)
	{
		$query = "SELECT * FROM (`sss_advertisement_master`), 
		         
		         LEFT JOIN (select * from sss_advertisement_master left join `sss_count_clcik_advertisement`.`advertisement_id`=`sss_advertisement_master`.`advertisement_id` where HAVING count(sss_count_clcik_advertisement.advertisement_id) <= 2 ) as t `sss_count_clcik_advertisement` ON `sss_count_clcik_advertisement`.`advertisement_id`=`sss_advertisement_master`.`advertisement_id` 
		         WHERE (`pages` LIKE '%barlist%') 
		         AND `status` = 'active' 
		         AND FIND_IN_SET('New York', city_zip) 
		         AND `position` = 'top' 
		         ";
				 
	    echo $query;
	    die;			 
	}
	
	function getadvertisementSearchBar($page='',$pos=0,$city,$zipcode)
	{
		  $en='';
		$en1='';
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('advertisement_master');
		//$CI->db->where('(`pages` LIKE  \'%'.mysql_real_escape_string($page).'%\')', NULL, 'FALSE');
		$CI->db->where('(`pages` LIKE  \'%'.mysql_real_escape_string($page).'%\')', NULL, 'FALSE');
		$CI->db->where('status', 'active');
		$CI->db->where('( `number_click` > `total_click` and type="click" OR `number_visit` > `total_visit` and type="visit")');
		if($city!='' && $city!='1V1' && $city!='0' && $zipcode!='' && $zipcode!='1V1' && $zipcode!='0')
		{
			//$CI->db->where('(`city_zip` LIKE  \''.mysql_real_escape_string($city).'%\')', NULL, 'FALSE');
			$CI->db->where ("(FIND_IN_SET('$city', city_zip) OR FIND_IN_SET('$zipcode', city_zip))");
			
			
			//$en.=" FIND_IN_SET('$city', city_zip) OR FIND_IN_SET('$zipcode', city_zip)";
			//$CI->db->where('( FIND_IN_SET('.$city.', city_zip) OR FIND_IN_SET('.$zipcode.', city_zip ))');
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
			//
			//$CI->db->where('('.substr($en, 0 ,-3).')')  ;
			
		}
		else if($city!='' && $city!='1V1' && $city!='0')
		{
			//$CI->db->where('(`city_zip` LIKE  \''.mysql_real_escape_string($city).'%\')', NULL, 'FALSE');
			$CI->db->where ("FIND_IN_SET('$city', city_zip)");
			
		}
		
		else if($zipcode!='' && $zipcode!='1V1' && $zipcode!='0')
		{
			$CI->db->where("FIND_IN_SET('$zipcode', city_zip)");
			//$CI->db->where('(`city_zip` LIKE  \''.mysql_real_escape_string($zipcode).'%\')', NULL, 'FALSE');
		}
		if($pos!='0')
		{
			$CI->db->where('position', $pos);
		}
	    $CI->db->order_by('advertisement_id', 'RANDOM');
	    
	    $CI->db->limit(1);
	    
		$query = $CI->db->get();
		//echo $CI->db->last_query();
	    if($query->num_rows()>0)
	    {
	    	 return $query->row_array();
	    }
		else {
		     return '';	
		}
	   
	}

function getadvertisementBannerSearchBar($page='')
	{
		  $en='';
		$en1='';
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('banner_pages_master');
		//$CI->db->where('(`pages` LIKE  \'%'.mysql_real_escape_string($page).'%\')', NULL, 'FALSE');
		$CI->db->where('(`pages` LIKE  \'%'.mysql_real_escape_string($page).'%\')', NULL, 'FALSE');
		$CI->db->where('status', 'active');
		$CI->db->where('( (`number_click` > `total_click` and type="click") OR (`number_visit` > `total_visit` and type="visit") OR type="")');
		
	    $CI->db->order_by('banner_pages_id', 'RANDOM');
	    
	    $CI->db->limit(1);
	    
		$query = $CI->db->get();
	//	echo $CI->db->last_query();
	    if($query->num_rows()>0)
	    {
	    	 return $query->row_array();
	    }
		else {
		     return '';	
		}
	   
	}
	function getadvertisementSearchBarsd($page='',$pos=0,$city,$zipcode)
	{
		
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('advertisement_master');
		//$CI->db->where('(`pages` LIKE  \'%'.mysql_real_escape_string($page).'%\')', NULL, 'FALSE');
		$CI->db->join('count_clcik_advertisement','count_clcik_advertisement.advertisement_id=advertisement_master.advertisement_id','left');
		$CI->db->where('(`pages` LIKE  \'%'.mysql_real_escape_string($page).'%\')', NULL, 'FALSE');
		$CI->db->where('status', 'active');
		//$CI->db->having(' count(sss_count_clcik_advertisement.advertisement_id) < sss_advertisement_master.number_click');
		//$CI->db->having('count(sss_count_clcik_advertisement.advertisement_id) <= '2', NULL, FALSE');
		//$CI->db->having('count(sss_count_clcik_advertisement.advertisement_id) <= 2', NULL, 'FALSE');  
		//$CI->db->having(' count(sss_count_clcik_advertisement.advertisement_id) < sss_advertisement_master.number_visit AND sss_count_clcik_advertisement.click_type = "visit"',NULL,'FALSE');
		if($city!='' && $city!='1V1' && $city!='0')
		{
			//$CI->db->where('(`city_zip` LIKE  \''.mysql_real_escape_string($city).'%\')', NULL, 'FALSE');
			$CI->db->where ("FIND_IN_SET('$city', city_zip)");
		}
		if($zipcode!='' && $zipcode!='1V1' && $zipcode!='0')
		{
			$CI->db->where ("FIND_IN_SET('$zipcode', city_zip)");
			//$CI->db->where('(`city_zip` LIKE  \''.mysql_real_escape_string($zipcode).'%\')', NULL, 'FALSE');
		}
		if($pos!='0')
		{
			$CI->db->where('position', $pos);
		}
	    $CI->db->order_by('advertisement_id', 'RANDOM');
	    
	    $CI->db->limit(1);
	    
		$query = $CI->db->get();
		//echo $CI->db->last_query();
	    if($query->num_rows()>0)
	    {
	    	 return $query->row_array();
	    }
		else {
		     return '';	
		}
	   
	}
	function getadvertisementByID($id,$type)
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('count_clcik_advertisement');
		$CI->db->where('advertisement_id', $id);
		$CI->db->where('click_type', $type);
		$CI->db->where('ip', $_SERVER['REMOTE_ADDR']);
		$CI->db->where('date_format(datetime,\'%Y-%m-%d\') =', date('Y-m-d'));
	    
		$query = $CI->db->get();
		
		
	    if($query->num_rows()>0)
	    {
	    	 return $query->num_rows();
	    }
		else {
		     return 0;	
		}
	}
	
	function getadvertisementByID_banner($id,$type)
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('count_clcik_advertisement_banner');
		$CI->db->where('banner_pages_id', $id);
		$CI->db->where('click_type', $type);
		$CI->db->where('ip', $_SERVER['REMOTE_ADDR']);
		$CI->db->where('date_format(datetime,\'%Y-%m-%d\') =', date('Y-m-d'));
	    
		$query = $CI->db->get();
		
		
	    if($query->num_rows()>0)
	    {
	    	 return $query->num_rows();
	    }
		else {
		     return 0;	
		}
	}
	
	function getadvertisementByID_new($id,$type)
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('count_clcik_advertisement');
		$CI->db->where('advertisement_id', $id);
		$CI->db->where('click_type', $type);
		$CI->db->where('ip', $_SERVER['REMOTE_ADDR']);
		$CI->db->where('date_format(datetime,\'%Y-%m-%d\') =', date('Y-m-d'));
	    
		$query = $CI->db->get();
		
		
	    if($query->num_rows()>0)
	    {
	    	 return $query->num_rows();
	    }
		else {
		     return 0;	
		}
	}
	
	function getadvertisementBannerByID_new($id,$type)
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('count_clcik_advertisement_banner');
		$CI->db->where('banner_pages_id', $id);
		$CI->db->where('click_type', $type);
		$CI->db->where('ip', $_SERVER['REMOTE_ADDR']);
		$CI->db->where('date_format(datetime,\'%Y-%m-%d\') =', date('Y-m-d'));
	    
		$query = $CI->db->get();
		
		
	    if($query->num_rows()>0)
	    {
	    	 return $query->num_rows();
	    }
		else {
		     return 0;	
		}
	}
	
	function getadvertisementByIDSec($id,$type)
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('count_clcik_advertisement');
		$CI->db->where('advertisement_id', $id);
		$CI->db->where('click_type', $type);
		$CI->db->where('date_format(datetime,\'%Y-%m-%d\') =', date('Y-m-d'));
	    
		$query = $CI->db->get();
	    if($query->num_rows()>0)
	    {
	    	 return 1;
	    }
		else {
		     return 0;	
		}
	}
	
	
	
	function getBarByIDCount($id)
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('count_clcik_bar');
		$CI->db->where('bar_id', $id);
		//$CI->db->where('click_type', $type);
		$query = $CI->db->get();
		
		
		
	    if($query->num_rows()>0)
	    {
	    	 return $query->num_rows();
	    }
		else {
		     return 0;	
		}
	}
	
	function getBarTotal($id)
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('count_clcik_bar');
		$CI->db->where('bar_id', $id);
		//$CI->db->where('click_type', $type);
		$query = $CI->db->get();
		
		
		
	    if($query->num_rows()>0)
	    {
	    	 return $query->row_array();
	    }
		else {
		     return 0;	
		}
	}
	
	function getimagenamebanner()
	{
		$CI =& get_instance();
		$query = $CI->db->get("banner_pages");
		return $query->row();
	}
	
	function resize_orig($source_image, $destination, $tn_w, $tn_h, $quality = 100, $wmsource = false)
{

	
    $info = @getimagesize($source_image);
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
    $backgroundColor = imagecolorallocate($final, 0, 0, 0);
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
   function get_all_user()
   {
   	  $CI =& get_instance();
	  $CI->db->select("*");
	  $CI->db->from("user_master");
	  $CI->db->where("status",'active');
	  $qry = $CI->db->get();
		 
	  if($qry->num_rows()>0)
	  {
		 return $qry->result();
	  }
		 
		 return 0;
   }
   
   function getimagename_gal($event_id)
	{
		$that =& get_instance();
		$query	=	$that->db->get_where("bar_images",array("bar_gallery_id"=>$event_id));
		if($query->num_rows())
		{
			$images	=	$query->result();
			
			foreach($images as $i)
			{
				if(file_exists(base_path()."upload/bar_gallery_thumb_big/$i->bar_image_name"))
				return	base_url()."upload/bar_gallery_thumb_big/$i->bar_image_name";
			}
		}
		return	base_url()."upload/event_default.jpg";
	}
	
	function getimagenameorig_gal($event_id)
	{
		$that =& get_instance();
		$query	=	$that->db->get_where("bar_images",array("bar_gallery_id"=>$event_id));
		if($query->num_rows())
		{
			$images	=	$query->result();
			
			foreach($images as $i)
			{
				if(file_exists(base_path()."upload/bar_gallery_orig/$i->bar_image_name"))
				return	base_url()."upload/bar_gallery_orig/$i->bar_image_name";
			}
		}
		return	base_url()."upload/event_default.jpg";
	}
   
     function getalbumimage($id)
	 {
	 	 $CI =& get_instance();
	  $CI->db->select("*");
	  $CI->db->from("album_images");
	  $CI->db->where("bar_gallery_id",$id);
	  $qry = $CI->db->get();
		 
	  if($qry->num_rows()>0)
	  {
		 return $qry->result();
	  }
		 
		 return 0;
	 
	 }
	 
	   function getalbumimageuser($id)
	 {
	 	 $CI =& get_instance();
	  $CI->db->select("*");
	  $CI->db->from("album_images");
	  $CI->db->where("bar_gallery_id",$id);
	  $qry = $CI->db->get();
		 
	  if($qry->num_rows()>0)
	  {
		 return $qry->result();
	  }
		 
		 return 0;
	 
	 }
	  function getalbumimage1($id)
	 {
	 	 $CI =& get_instance();
	  $CI->db->select("*");
	  $CI->db->from("bar_images");
	  $CI->db->where("bar_gallery_id",$id);
	  $qry = $CI->db->get();
		 
	  if($qry->num_rows()>0)
	  {
		 return $qry->result();
	  }
		 
		 return 0;
	 
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
       function twilio_setting()
	{		
		$CI =& get_instance();
		$query = $CI->db->get("twilio_setting");
		return $query->row();
	
	}	
	
	function first_hours(){
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('days');
		$query = $CI->db->get();
		if($query->num_rows() > 0)
		{	
			return $query->result();
		}
	}
	
	function getBarInfoByUserID($id)
	{
	  $CI =& get_instance();
	  $CI->db->select("*");
	  $CI->db->from("bars");
	  //$CI->db->join('user_master','user_master.user_id=bars.owner_id');
	  $CI->db->where("bars.owner_id",$id);
	  $qry = $CI->db->get();
	  if($qry->num_rows() > 0)
		{	
			return $qry->row();
		}
	}
	
	function getBarInfoByID($id)
	{
	  $CI =& get_instance();
	  $CI->db->select("*");
	  $CI->db->from("bars");
	  //$CI->db->join('user_master','user_master.user_id=bars.owner_id');
	  $CI->db->where("bars.bar_id",$id);
	  $qry = $CI->db->get();
	  if($qry->num_rows() > 0)
		{	
			return $qry->row();
		}
	}
	
	function get_count_impression($id)
	{
	  $CI =& get_instance();
	  $CI->db->select_sum('impression');
	  $CI->db->from("count_clcik_bar");
	  //$CI->db->join('user_master','user_master.user_id=bars.owner_id');
	  $CI->db->where("bar_id",$id);
	  $qry = $CI->db->get();
	  
	  if($qry->num_rows() > 0)
		{
			$res = $qry->row();	
			return $res->impression;
		}
		
		
	}
	function get_count_visit($id)
	{
	  $CI =& get_instance();
	  $CI->db->select_sum('visit');
	  $CI->db->from("count_clcik_bar");
	  //$CI->db->join('user_master','user_master.user_id=bars.owner_id');
	  $CI->db->where("bar_id",$id);
	  $qry = $CI->db->get();
	  if($qry->num_rows() > 0)
		{
			$res = $qry->row();	
			return $res->visit;
		}
	
	}
	
	
	function getbarimpByID($id)
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('count_clcik_bar');
		$CI->db->where('bar_id', $id);
		$CI->db->where('ip', $_SERVER['REMOTE_ADDR']);
	    
		$query = $CI->db->get();
		
		
	    if($query->num_rows()>0)
	    {
	    	 return 1;
	    }
		else {
		     return 0;	
		}
	}
	function get_category()
	{
		$CI =& get_instance();
		$qry = $CI->db->get_where("forum_category",array("status"=>"active"));
		
		
		if($qry->num_rows()>0)
		{
			  return $qry->result();
		}
		
		return 0;
	}
	
	function getallproductsByBarID($bar_id)
	{
			$CI =& get_instance();
				$CI->db->select('*');
		$CI->db->from('store');
		$CI->db->where('(bar_id ='.$bar_id.' AND is_delete=0 and status="active") OR (status="active" and type="store")');
		$CI->db->order_by('store_id', 'desc');
		$query = $CI->db->get();
		
		if($query->num_rows()>0)
		{
			  return $query->result();
		}
		
		return 0;
		
		
		
	}
	
	function getallproducts()
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('store');
		$CI->db->where('status', 'active');
		$CI->db->where('is_delete', 0);
		$CI->db->order_by('store_id', 'desc');
		$query = $CI->db->get();
		
		if($query->num_rows()>0)
		{
			  return $query->result();
		}
		
		return 0;
	}

	function get_product_name($product_id)
	{
		$CI =& get_instance();
		//$query	=	$that->db->get_where("product",array("product_id"=>$product_id));
		
		 $CI->db->select('*')
		                  ->from('store')
						  ->where('store_id',$product_id);
		$query = $CI->db->get();				  
		if($query->num_rows())
		{
			$images	=	$query->row();
			return $images->product_name;
		}
		return	'N/A';
	}
	
	 function getColor($col)
	{
		$CI =& get_instance();
		//$q=$CI->db->get_where('Color',array('status'=>'Active'));
		//$categories = array('10', '12');
		$CI->db->select('*');
		$CI->db->from('Color');
		$CI->db->where_in('Color_id', $col);
		$query = $CI->db->get();
		if($query->num_rows()>0)
		{
			return $query->result();
		}else{
			return '';
		}
	}
	
	function getSize($col)
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('Size');
		$CI->db->where_in('Size_id', $col);
		$query = $CI->db->get();
		if($query->num_rows()>0)
		{
			return $query->result();
		}else{
			return '';
		}
	}
	
	function getsinglecolor()
	{
		$CI =& get_instance();
		$q=$CI->db->get_where('Color',array('status'=>'Active'));
		if($q->num_rows()>0)
		{
			$images	=	$q->row();
			return $images->Color_id;
		}else{
			return '';
		}
	}
	
	function getcolorname($col_id)
	{
		$CI =& get_instance();
		$q=$CI->db->get_where('Color',array('Color_id'=>$col_id));
		
		//echo $CI->db->last_query();
		if($q->num_rows()>0)
		{
			$images	=	$q->row();
			return $images->color_name;
		}else{
			return '';
		}
	}
	
	function getstoreinfo($id)
	{
		$CI =& get_instance();
		$q=$CI->db->get_where('store',array('store_id'=>$id));
		
		//echo $CI->db->last_query();
		if($q->num_rows()>0)
		{
			return $q->row();
		}else{
			return '';
		}
	}
	function getsizename($col_id)
	{
		$CI =& get_instance();
		$q=$CI->db->get_where('Size',array('Size_id'=>$col_id));
		
		//echo $CI->db->last_query();
		if($q->num_rows()>0)
		{
			$images	=	$q->row();
			return $images->size_name;
		}else{
			return '';
		}
	}
	
	function getsinglesize()
	{
		$CI =& get_instance();
		$q=$CI->db->get_where('Size',array('status'=>'Active'));
		if($q->num_rows()>0)
		{
			$images	=	$q->row();
			return $images->Size_id;
		}else{
			return '';
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
	
	function getsingleimage_event($id)
	{
		$CI =& get_instance();
		$q=$CI->db->get_where('event_images',array('bar_eventgallery_id'=>$id));
		if($q->num_rows()>0)
		{
			$images	=	$q->row();
			return $images->event_image_name;
		}else{
			return '';
		}
	}
	
	function getbarsite()
	{
		$CI =& get_instance();
	  $CI->db->select("*");
	  $CI->db->from("bars");
	  //$CI->db->join('bars','sitemap.cat_id=bars.bar_id');
	  $CI->db->where("bars.status",'active');
	  $CI->db->order_by('bar_id','desc');
	  $CI->db->limit(50);
	  $qry = $CI->db->get();
	  if($qry->num_rows() > 0)
		{	
			return $qry->result();
		}
	}
	
	function getbeersite()
	{
		$CI =& get_instance();
	  $CI->db->select("*");
	  $CI->db->from("beer_directory");
	  //$CI->db->join('bars','sitemap.cat_id=bars.bar_id');
	  $CI->db->where("beer_directory.status",'active');
	    $CI->db->order_by('beer_id','desc');
	  $CI->db->limit(50);
	  $qry = $CI->db->get();
	  if($qry->num_rows() > 0)
		{	
			return $qry->result();
		}
	}
	
	function getcocktailsite()
	{
		$CI =& get_instance();
	  $CI->db->select("*");
	  $CI->db->from("cocktail_directory");
	  //$CI->db->join('bars','sitemap.cat_id=bars.bar_id');
	  $CI->db->where("cocktail_directory.status",'active');
	    $CI->db->order_by('cocktail_id','desc');
	  $CI->db->limit(50);
	  $qry = $CI->db->get();
	  if($qry->num_rows() > 0)
		{	
			return $qry->result();
		}
	}
	
	
	function getliquorsite()
	{
		$CI =& get_instance();
	  $CI->db->select("*");
	  $CI->db->from("liquors");
	  //$CI->db->join('bars','sitemap.cat_id=bars.bar_id');
	  $CI->db->where("liquors.status",'active');
	    $CI->db->order_by('liquor_id','desc');
	  $CI->db->limit(50);
	  $qry = $CI->db->get();
	  if($qry->num_rows() > 0)
		{	
			return $qry->result();
		}
	}
	
	function geteventsite()
	{
		$CI =& get_instance();
	  $CI->db->select("*");
	  $CI->db->from("events");
	  //$CI->db->join('bars','sitemap.cat_id=bars.bar_id');
	  $CI->db->where("events.status",'active');
	  $CI->db->where("events.is_deleted",'no');
	  $qry = $CI->db->get();
	  if($qry->num_rows() > 0)
		{	
			return $qry->result();
		}
	}
	
	function getforumsite()
	{
		$CI =& get_instance();
	  $CI->db->select("*");
	  $CI->db->from("forum");
	  //$CI->db->join('bars','sitemap.cat_id=bars.bar_id');
	  $CI->db->where("forum.status",'active');
	  $qry = $CI->db->get();
	  if($qry->num_rows() > 0)
		{	
			return $qry->result();
		}
	}
	
	function getarcticlesite()
	{
		$CI =& get_instance();
	  $CI->db->select("*");
	  $CI->db->from("blog");
	  //$CI->db->join('bars','sitemap.cat_id=bars.bar_id');
	  $CI->db->where("blog.status",'active');
	  $qry = $CI->db->get();
	  if($qry->num_rows() > 0)
		{	
			return $qry->result();
		}
	}

   

 function getstatenamebycode($name)
	{
		$CI =& get_instance();
		$q=$CI->db->get_where('state_master',array('state_code'=>$name));
		
		if($q->num_rows()>0)
		{
			$images	=	$q->row();
			return $images->state_name;
		}else{
			return '';
		}
	}

 function getcodebystate($name)
	{
		$CI =& get_instance();
		$q=$CI->db->get_where('state_master',array('state_name'=>$name));
		
		if($q->num_rows()>0)
		{
			$images	=	$q->row();
			return $images->state_code;
		}else{
			return '';
		}
	}
	
	function gethalmugfeature($type='')
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('feature');
		$CI->db->where(''.$type.' !=','');
		$query = $CI->db->get();
		if($query->num_rows()>0)
		{
			return $query->result();
		} 
		return '';
	}
	
	function getFreeListingText()
	{
		$CI =& get_instance();
		$q=$CI->db->get_where('pages',array('pages_title'=>'Registration Step2'));
		
		//echo $CI->db->last_query();
		if($q->num_rows()>0)
		{
			return $q->row();
		}else{
			return '';
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
		$sQuery=$addr.'+'.$city.'+'.$state.'+'.$country;
		///$url = 'http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($sQuery).'&sensor=false&region='.$country;
		
	//	$url = "https://maps.google.com/maps/api/geocode/json?address=".urlencode($sQuery)."&sensor=false&key=AIzaSyC3EDjDVgTV15wfNAX5trrNOiiHugrhnqg";
		
		$geturl = getallapi();
		
		
		//$url = "https://maps.google.com/maps/api/geocode/json?address=".urlencode($sQuery)."&sensor=false&key=AIzaSyCoBWbzJwQyH5smmrKV07zhcrpYWszIiAQ";
		//$url = "https://maps.google.com/maps/api/geocode/json?address=".urlencode($sQuery)."&sensor=false&key=AIzaSyAFuf13JKDdpBpeKtpGZ7rHRwSw4l052Qw";
		$url = "https://maps.google.com/maps/api/geocode/json?address=".urlencode($sQuery)."&sensor=false&key=AIzaSyDDnFi3wywvle6rstbj4N-0W7GxPr43ZD4";
		
		//$url = "https://maps.google.com/maps/api/geocode/json?address=".urlencode($sQuery)."&sensor=false&key=AIzaSyAIwfE5dUdjpz8QjUsYjdCQzQu-_Ex-50k";
		//$url = "https://maps.google.com/maps/api/geocode/json?address=".urlencode($sQuery)."&sensor=false&key=AIzaSyCe-igkpmEN5KinTTiz83YDieu8xFgzdqY";
		
		
		// $data_location .= "maps.google.com/maps/api/geocode/json?address=".urlencode(utf8_encode($address))."&sensor=false".$this->sensor."&key=AIzaSyC3EDjDVgTV15wfNAX5trrNOiiHugrhnqg";
		//echo $url; 
		
		
		$json = file_get_contents($url);
		
		
		$data=json_decode($json);
		
		//$sQuery=$addr.'+'.$city.'+'.$state.'+'.$country;
		//$sQuery=$addr.'+'.$city;
		//$sURL = 'http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($sQuery).'&sensor=false&region='.$country;
		
		//$sData = file_get_contents($sURL);
		//$data=json_decode($sData);
		
		//print_r($data);
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
	
	function getfavusersbybars($bar_id)
	{
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('all_likes');
		$CI->db->join('user_master','user_master.user_id=all_likes.user_id');
		$CI->db->where('`bar_id` = '.$bar_id.' and (like_flag=1 OR bar_fav_flag=1)');
		$CI->db->group_by('all_likes.user_id');
		$query = $CI->db->get();
		if($query->num_rows()>0)
		{
			return $query->result();
		} 
		return '';
	}
	
	function getbeername($beer_id){
		$CI =& get_instance();
		//echo "right"; die;;
	
	       $CI->db->where("beer_id",$beer_id);
			$query = $CI->db->get("beer_directory");
			
			if($query->num_rows() > 0){
				$res = $query->row();
				$user_name = "<a href='".base_url()."beer/detail/".$res->beer_slug."'>". ucwords($res->beer_name) ."</a>";
			}
		
		return $user_name;
		
	}

function getcocktailname($cocktail_id){
		$CI =& get_instance();
		//echo "right"; die;;
	
	       $CI->db->where("cocktail_id",$cocktail_id);
			$query = $CI->db->get("cocktail_directory");
			
			if($query->num_rows() > 0){
				$res = $query->row();
				$user_name = "<a href='".base_url()."cocktail/detail/".$res->cocktail_slug."'>". ucwords($res->cocktail_name) ."</a>";
			}
		
		return $user_name;
		
	}
	
	function getliquorname($liquor_id){
		$CI =& get_instance();
		//echo "right"; die;;
	
	       $CI->db->where("liquor_id",$liquor_id);
			$query = $CI->db->get("liquors");
			
			if($query->num_rows() > 0){
				$res = $query->row();
				$user_name = "<a href='".base_url()."liquor/detail/".$res->liquor_slug."'>". ucwords($res->liquor_title) ."</a>";
			}
		
		return $user_name;
		
	}
	
	function CheckAuth(){
		
		$CI =& get_instance();
		
		
		$user_id = $CI->input->post('user_id');
		$device_id = $CI->input->post('device_id');
		$unique_code = $CI->input->post('unique_code');
		
		$CI->db->select('d.*,u.status');
		$CI->db->from('device_master d');
		$CI->db->join('user_master u','u.user_id = d.user_id');
		$CI->db->where('d.user_id',$user_id);
		$CI->db->where('d.device_name',$device_id);
		$CI->db->where('d.unique_code',$unique_code);
		$CI->db->where('u.status','active');
		$query = $CI->db->get();
		//prd($CI->db->last_query());
		if($query->num_rows()>0){
			return 1;
		} else {
			return 0;
		}
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

    function checkpaymentexist($bar_id)
	{
		$CI =& get_instance();
		
		$CI->db->select('*');
		$CI->db->from('bar_payment_setting');
		$CI->db->where('bar_id',$bar_id);
		$query = $CI->db->get();
		//prd($CI->db->last_query());
		if($query->num_rows()>0){
			return $query->row();
		} else {
			return 0;
		}
	}
	
	function getLatestMessage()
	{
		
		$CI =& get_instance();
		
		$CI->db->select('*');
		$CI->db->from('broadcast_message');
		$CI->db->where('to_user_id',get_authenticateUserID());
		$CI->db->where('is_read','0');
		$CI->db->order_by('message_id','desc');
		$query = $CI->db->get();
		//prd($CI->db->last_query());
		if($query->num_rows()>0){
			return $query->row();
		} else {
			return 0;
		}
	}
	
	function sendPushNotificationAndroid($patient_id,$data)
	{
		$that =& get_instance();
		$registatoin_ids_count	=	$that->db->select('COUNT(registered_android_id) as TOTAL')->where("patient_id",$patient_id)->get("registered_android")->row()->TOTAL;
		//prd($registatoin_ids_count);

		if($registatoin_ids_count)
		{
			$site_setting = site_setting();
			//$device_login = $that->db->select('COUNT(android_session) as TOTAL')->where("patient_id",$patient_id)->get("registered_android")->row()->TOTAL;
			$registatoin_ids = $that->db->select('gcm_regid')->where(array("patient_id"=>$patient_id,"android_session"=>'1'))->get("registered_android");
			//prd($registatoin_ids->result());
			//prd($device_login);

			if($registatoin_ids->num_rows())
			{
				foreach($registatoin_ids->result() as $r)
				{
					$__registatoin_ids[] = $r->gcm_regid;
				}
				$registatoin_ids = $__registatoin_ids;
				//prd($registatoin_ids);
				$that->db->insert("test",array("data"=>serialize($registatoin_ids)));
				$url = 'https://android.googleapis.com/gcm/send';
	 
		        $fields = array(
		            'registration_ids' => $registatoin_ids,
		            'data' => $data,
		        );
		 
		        $headers = array(
		            "Authorization: key=$site_setting->android_api_key",
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
		        if ($result === FALSE) {
		            die('Curl failed: ' . curl_error($ch));
		        }
		 
		        // Close connection
		        curl_close($ch);
				//sleep(0.5);
				//$that->db->insert("test",array("data"=>$result));
				//ti($result);
				$res = json_decode($result);
				//$res->results;
				if(isset($res->results) && $res->results)
				{
					for($i=0;$i<count($res->results);$i++)
					{
						if(isset($res->results[$i]->error))
						{
							$that->db->delete('registered_android',array('gcm_regid'=>$registatoin_ids[$i]));
						}
					}
				}
				return $result;
			}
			else
			{
				$that->db->insert('android_stored_notification',array("patient_id"=>$patient_id,'notification'=>serialize($data)));
			}
		}
		
	}

  	function checkbarid($bar_id)
	{
		
		$CI =& get_instance();
		
		$CI->db->select('*');
		$CI->db->from('bars');
		$CI->db->where('bar_id',$bar_id);
		$query = $CI->db->get();
		//prd($CI->db->last_query());
		if($query->num_rows()>0){
			return 1;
		} else {
			return '';
		}
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
	
	            	function multi_in_array($value, $array) 
{ 
    foreach ($array AS $item) 
    { 
        if (!is_array($item)) 
        { 
            if ($item == $value) 
            { 
                return true; 
            } 
            continue; 
        } 

        if (in_array($value, $item)) 
        { 
            return true; 
        } 
        else if (multi_in_array($value, $item)) 
        { 
            return true; 
        } 
    } 
    return false; 
} 

   function getCatname($id)
   {
   		$CI =& get_instance();
		$q=$CI->db->get_where('bar_category',array('bar_category_id'=>$id));
		
		if($q->num_rows()>0)
		{
			$images	=	$q->row();
			return $images->bar_category_name;
		}else{
			return '';
		}
   }   
 function getEventCatname($id)
   {
   		$CI =& get_instance();
		$q=$CI->db->get_where('event_category',array('event_category_id'=>$id));
		
		if($q->num_rows()>0)
		{
			$images	=	$q->row();
			return $images->event_category_name;
		}else{
			return '';
		}
   }   
   
   function getcategoryIdbykeyword($keyword)
   {
   		$CI =& get_instance();
//		$q = $CI->db->get_where('event_category',array('event_category_name'=>$keyword));
			$CI->db->select('*');
		$CI->db->from('event_category');
		$CI->db->like('event_category_name',$keyword);
		$q = $CI->db->get();
		if($q->num_rows()>0)
		{
			$images1233	=	$q->row();
			return $images1233->event_category_id;
		}else{
			return '';
		}
   	  
   }
   
   function getBarHappyHoursByRand($rand,$type)
   {
   	 	 $CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('bar_happy_hour');
		$CI->db->where('rand',$rand);
		if($type=='beer'){
		$CI->db->where('sp_beer_id !=',0);
		}
		if($type=='cocktail'){
		$CI->db->where('sp_cocktail_id !=',0);
		}
		if($type=='liquor'){
		$CI->db->where('sp_liquor_id !=',0);
		}
		if($type=='food'){
		$CI->db->where('food_name !=','');
		}
		if($type=='other'){
		$CI->db->where('other_name !=','');
		}
		$query = $CI->db->get();
		//prd($CI->db->last_query());
		
		
		if($query->num_rows()>0){
			return $query->result();
		} else {
			return '';
		}              
    }
   
   function getBarSpecialHoursByRand($rand,$type)
   {
   	 	 $CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('bar_special_hours');
		$CI->db->where('rand',$rand);
		if($type=='beer'){
		$CI->db->where('sp_beer_id !=',0);
		}
		if($type=='cocktail'){
		$CI->db->where('sp_cocktail_id !=',0);
		}
		if($type=='liquor'){
		$CI->db->where('sp_liquor_id !=',0);
		}
		if($type=='food'){
		$CI->db->where('food_name !=','');
		}
		if($type=='other'){
		$CI->db->where('other_name !=','');
		}
		$query = $CI->db->get();
		//prd($CI->db->last_query());
		
		
		if($query->num_rows()>0){
			return $query->result();
		} else {
			return '';
		}              
    }
   
    function getBeernameByID($id)
   {
   		$CI =& get_instance();
//		$q = $CI->db->get_where('event_category',array('event_category_name'=>$keyword));
			$CI->db->select('*');
		$CI->db->from('beer_directory');
		$CI->db->where('beer_id',$id);
		$q = $CI->db->get();
		if($q->num_rows()>0)
		{
			$images1233	=	$q->row();
			return $images1233->beer_name;
		}else{
			return '';
		}
   	  
   }
   
    function getCocktailnameByID($id)
   {
   		$CI =& get_instance();
//		$q = $CI->db->get_where('event_category',array('event_category_name'=>$keyword));
			$CI->db->select('*');
		$CI->db->from('cocktail_directory');
		$CI->db->where('cocktail_id',$id);
		$q = $CI->db->get();
		if($q->num_rows()>0)
		{
			$images1233	=	$q->row();
			return $images1233->cocktail_name;
		}else{
			return '';
		}
   	  
   }
   
      function getLiquornameByID($id)
   {
   		$CI =& get_instance();
//		$q = $CI->db->get_where('event_category',array('event_category_name'=>$keyword));
			$CI->db->select('*');
		$CI->db->from('liquors');
		$CI->db->where('liquor_id',$id);
		$q = $CI->db->get();
		if($q->num_rows()>0)
		{
			$images1233	=	$q->row();
			return $images1233->liquor_title;
		}else{
			return '';
		}
   	  
   }
   
   	 function getEventDate($event_id)
	{
		
		$CI =& get_instance();
		$CI->db->_protect_identifiers=false; 
		$CI->db->select('*');
		$CI->db->from('event_time');
		$CI->db->where(array('event_id'=>$event_id));
		$CI->db->where('eventdate >=',date('Y-m-d'));
		//$CI->db->where('date_added >= ',$date2);
		$CI->db->limit(1);
		$query = $CI->db->get();
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		return '';
	}
?>