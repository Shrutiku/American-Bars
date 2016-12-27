<?php
class Cron_model extends CI_Model 
{
	function Cron_model()
    {
        parent::__construct();	
    } 	
	
	function getUserNoActivity($date='')
	{
		$date = date('Y-m-d',strtotime('-2 weeks'));
		$date1 = date('Y-m-d',strtotime('-4 weeks'));
		$date2 = date('Y-m-d',strtotime('-2 month'));
		$date3 = date('Y-m-d',strtotime('-3 month'));
		
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->join('user_login','user_master.user_id=user_login.user_id');
		$this->db->where("(DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') = '$date' OR DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') = '$date1' OR DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') = '$date2' OR DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') = '$date3')");
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		$this->db->where('user_master.user_type','user');
		$this->db->where('user_master.status','active');
		$this->db->group_by('user_login.user_id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return "";
		
	}

	function getUserNoActivity_bar($date='')
	{
		$date = date('Y-m-d',strtotime('-2 weeks'));
		$date1 = date('Y-m-d',strtotime('-4 weeks'));
		$date2 = date('Y-m-d',strtotime('-2 month'));
		$date3 = date('Y-m-d',strtotime('-3 month'));
		
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->join('all_likes','user_master.user_id=all_likes.user_id');
		$this->db->where("(DATE_FORMAT(sss_all_likes.date_added, '%Y-%m-%d') = '$date' OR DATE_FORMAT(sss_all_likes.date_added, '%Y-%m-%d') = '$date1' OR DATE_FORMAT(sss_all_likes.date_added, '%Y-%m-%d') = '$date2' OR DATE_FORMAT(sss_all_likes.date_added, '%Y-%m-%d') = '$date3')");
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		$this->db->where('user_master.user_type','user');
		$this->db->where('user_master.status','active');
		$this->db->where('all_likes.bar_fav_flag',1);
		$this->db->where('all_likes.bar_id !=','');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		
		
		return "";
		
	}

	function getUserNoActivity_bar_user($date='')
	{
		$date = date('Y-m-d',strtotime('-2 weeks'));
		$date1 = date('Y-m-d',strtotime('-4 weeks'));
		$date2 = date('Y-m-d',strtotime('-2 month'));
		$date3 = date('Y-m-d',strtotime('-3 month'));
		
		
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->where("(DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date' OR DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date1' OR DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date2' OR DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date3')");
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		 $this->db->where('user_master.user_type','user');
		 $this->db->where('user_master.status','active');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		
		return "";
		
	}


	function getUserNoActivity_cocktail($date='')
	{
		$date = date('Y-m-d',strtotime('-2 weeks'));
		$date1 = date('Y-m-d',strtotime('-4 weeks'));
		$date2 = date('Y-m-d',strtotime('-2 month'));
		$date3 = date('Y-m-d',strtotime('-3 month'));
		
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->join('all_likes','user_master.user_id=all_likes.user_id');
		$this->db->where("(DATE_FORMAT(sss_all_likes.date_added, '%Y-%m-%d') = '$date' OR DATE_FORMAT(sss_all_likes.date_added, '%Y-%m-%d') = '$date1' OR DATE_FORMAT(sss_all_likes.date_added, '%Y-%m-%d') = '$date2' OR DATE_FORMAT(sss_all_likes.date_added, '%Y-%m-%d') = '$date3')");
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		$this->db->where('user_master.user_type','user');
		$this->db->where('user_master.status','active');
		$this->db->where('all_likes.fav_flag',1);
		 $this->db->where('all_likes.cocktail_id !=','');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		
		
		return "";
		
	}

function getUserNoActivity_cocktail_user($date='')
	{
		$date = date('Y-m-d',strtotime('-2 weeks'));
		$date1 = date('Y-m-d',strtotime('-4 weeks'));
		$date2 = date('Y-m-d',strtotime('-2 month'));
		$date3 = date('Y-m-d',strtotime('-3 month'));
		
		
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->where("(DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date' OR DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date1' OR DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date2' OR DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date3')");
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		 $this->db->where('user_master.user_type','user');
		$this->db->where('user_master.status','active');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return "";
		
	}

	function getUserNoActivity_liquor($date='')
	{
		$date = date('Y-m-d',strtotime('-2 weeks'));
		$date1 = date('Y-m-d',strtotime('-4 weeks'));
		$date2 = date('Y-m-d',strtotime('-2 month'));
		$date3 = date('Y-m-d',strtotime('-3 month'));
		
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->join('all_likes','user_master.user_id=all_likes.user_id');
		$this->db->where("(DATE_FORMAT(sss_all_likes.date_added, '%Y-%m-%d') = '$date' OR DATE_FORMAT(sss_all_likes.date_added, '%Y-%m-%d') = '$date1' OR DATE_FORMAT(sss_all_likes.date_added, '%Y-%m-%d') = '$date2' OR DATE_FORMAT(sss_all_likes.date_added, '%Y-%m-%d') = '$date3')");
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		$this->db->where('user_master.user_type','user');
		$this->db->where('user_master.status','active');
		$this->db->where('all_likes.fav_flag',1);
		 $this->db->where('all_likes.liquor_id !=','');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		
		return "";
		
	}

function getUserNoActivity_liquor_user($date='')
	{
		$date = date('Y-m-d',strtotime('-2 weeks'));
		$date1 = date('Y-m-d',strtotime('-4 weeks'));
		$date2 = date('Y-m-d',strtotime('-2 month'));
		$date3 = date('Y-m-d',strtotime('-3 month'));
		
		
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->where("(DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date' OR DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date1' OR DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date2' OR DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date3')");
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		 $this->db->where('user_master.user_type','user');
		 $this->db->where('user_master.status','active');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		
		return "";
		
	}

function getUserNoActivity_profile($date='')
	{
		$date = date('Y-m-d',strtotime('-2 weeks'));
		$date1 = date('Y-m-d',strtotime('-4 weeks'));
		$date2 = date('Y-m-d',strtotime('-2 month'));
		$date3 = date('Y-m-d',strtotime('-3 month'));
		
		
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->where("(DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date' OR DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date1' OR DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date2' OR DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date3')");
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		 $this->db->where('user_master.user_type','user');
		 $this->db->where('user_master.status','active');
		 $this->db->where('user_master.profile_image =','');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		
		return "";
		
	}

	function getHalfMugUser_profile($date='')
	{
		$date = date('Y-m-d',strtotime('-2 weeks'));
		
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->join('bars','bars.owner_id=user_master.user_id');
		$this->db->where("DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date'");
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		$this->db->where('user_master.user_type','bar_owner');
		$this->db->where('bars.bar_type','half_mug');
		$this->db->where('user_master.status','active');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		
		return "";
		
	}

	function getHalfMugUser_profile_logo($date='')
	{
		$date = date('Y-m-d',strtotime('-2 weeks'));
		
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->join('bars','bars.owner_id=user_master.user_id');
		$this->db->where("DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date'");
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		$this->db->where('user_master.user_type','bar_owner');
		$this->db->where('bars.bar_type','half_mug');
		$this->db->where('bars.bar_logo =','');
		$this->db->where('user_master.status','active');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		
		return "";
		
	}

	function getHalfMugUser_profile_beer($date='')
	{
		$date = date('Y-m-d',strtotime('-1 weeks'));
		
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->join('bars','bars.owner_id=user_master.user_id');
		$this->db->join('beer_bars','beer_bars.bar_id=bars.bar_id','left');
		$this->db->where("DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date'");
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		$this->db->where('user_master.user_type','bar_owner');
		$this->db->where('bars.bar_type','full_mug');
		//$this->db->where('beer_bars.bar_id !','');
		
		$this->db->where('user_master.status','active');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		
		return "";
		
	}
	
	function getHalfMugUser_profile_cocktail($date='')
	{
		$date = date('Y-m-d',strtotime('-1 weeks'));
		
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->join('bars','bars.owner_id=user_master.user_id');
		$this->db->join('cocktail_bars','cocktail_bars.bar_id=bars.bar_id','left');
		$this->db->where("DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date'");
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		$this->db->where('user_master.user_type','bar_owner');
		$this->db->where('bars.bar_type','full_mug');
		//$this->db->where('beer_bars.bar_id !','');
		
		$this->db->where('user_master.status','active');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		
		return "";
		
	}
	
	function getHalfMugUser_profile_liquor($date='')
	{
		$date = date('Y-m-d',strtotime('-1 weeks'));
		
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->join('bars','bars.owner_id=user_master.user_id');
		$this->db->join('liquors_bars','liquors_bars.bar_id=bars.bar_id','left');
		$this->db->where("DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date'");
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		$this->db->where('user_master.user_type','bar_owner');
		$this->db->where('bars.bar_type','full_mug');
		//$this->db->where('beer_bars.bar_id !','');
		$this->db->where('user_master.status','active');
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		
		return "";
		
	}
	
	function getHalfMugUser_profile_event($date='')
	{
		$date = date('Y-m-d',strtotime('-1 weeks'));
		
		$this->db->select('*,events.bar_id as b_id');
		$this->db->from('user_master');
		$this->db->join('bars','bars.owner_id=user_master.user_id');
		$this->db->join('events','events.bar_id=bars.bar_id','left');
		$this->db->where("DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date'");
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		$this->db->where('user_master.user_type','bar_owner');
		$this->db->where('bars.bar_type','full_mug');
		//$this->db->where('beer_bars.bar_id !','');
		$this->db->where('user_master.status','active');
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		
		return "";
		
	}
	
	function getFullMugUser_profile_logo($date='')
	{
		$date = date('Y-m-d',strtotime('-1 weeks'));
		
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->join('bars','bars.owner_id=user_master.user_id');
		$this->db->where("DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date'");
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		$this->db->where('user_master.user_type','bar_owner');
		$this->db->where('bars.bar_type','full_mug');
		$this->db->where('bars.bar_logo =','');
		$this->db->where('user_master.status','active');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		
		return "";
		
	}

function getUser_profile_logo($date='')
	{
		$date = date('Y-m-d',strtotime('-1 weeks'));
		
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->join('bars','bars.owner_id=user_master.user_id');
		$this->db->where("DATE_FORMAT(sss_user_master.sign_up_date, '%Y-%m-%d') = '$date'");
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		$this->db->where('user_master.user_type','bar_owner');
		$this->db->where('bars.bar_type','full_mug');
		$this->db->where('user_master.profile_image =','');
		$this->db->where('user_master.status','active');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		
		return "";
		
	}
	
	function getUser_profile_event()
	{
		$date = date('Y-m-d',strtotime('+1 weeks'));
		$date1 = date('Y-m-d',strtotime('+1 days'));
		
		$this->db->select('*,events.address,events.city,events.state,events.zipcode');
		$this->db->from('event_attend');
		$this->db->join('events','events.event_id=event_attend.event_id');
		$this->db->join('user_master','user_master.user_id=event_attend.user_id');
		$this->db->where("(DATE_FORMAT(sss_events.start_date, '%Y-%m-%d') = '$date' OR DATE_FORMAT(sss_events.start_date, '%Y-%m-%d') = '$date1')");
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		// $this->db->or_where("DATE_FORMAT(sss_user_login.login_date_time, '%Y-%m-%d') =",$date);
		$this->db->where('user_master.status','active');
		$this->db->where('event_attend.is_attend','yes');
		$query = $this->db->get();
		
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		
		return "";
		
	}

  function getAllevent()
  {
  		$this->db->select('events.event_id');
		$this->db->from('events');
		$this->db->join('event_time','events.event_id=event_time.event_id');
		$this->db->where('event_time.eventdate >=',date('Y-m-d'));
		$this->db->order_by("event_time.eventdate","asc");
		$this->db->group_by("event_time.event_id");
		$query = $this->db->get();
		$array1 = $query->result();
		
		$r1 = '';
		
		if($array1)
		{
			foreach($array1 as $r)
			{
				$r1 .= $r->event_id.",";
				 
			}
		}
		
		$array1 = array();
		
		if($r1!='')
		{
			$array1 = explode(",",substr($r1,0,-1));
		}
		
		//print_r($array1);
		
		$this->db->select('event_id');
		$this->db->from('events');
		$this->db->where_not_in('event_id',explode(",",substr($r1,0,-1)));
		$query1 = $this->db->get();
		if($query1->num_rows()>0)
		{
		 return $query1->result();
		}
		else {
			return '';
		}
		//echo $this->db->last_query();
		
		//print_r($array2);
		//echo $r2;
		//print_r(array_diff($array1, $array2));
		//die;
		
		
  }
}	
?>