<?php
class Event_model extends CI_Model 
{
	function Event_model()
    {
        parent::__construct();	
    } 	
	
	function get_total_event_count($keyword = 0,$event_date, $alpha ='',$bar_id)
	{
		$getid = getcategoryIdbykeyword($keyword);
		$this->db->select("*");
		$this->db->from("events");
		$this->db->join("event_time",'event_time.event_id=events.event_id');
		$this->db->where('events.status','active');
		$this->db->where('is_deleted','no');
		//$this->db->where('end_date >=',date('Y-m-d h:i:s'));
		if($bar_id>0)
		{
			$this->db->where('bar_id',$bar_id);
		}
		else {
			$this->db->where('bar_id','0');
		}
		
		if($alpha != "" && $alpha != "no")
		{
		   $this->db->like("event_title",$alpha,"after");
		}
		
		// if($keyword != '0')
		// {
			// $this->db->like("event_title",$keyword);
// 		 	
		// }		
		
		
		
		if($keyword!='1V1' && $keyword!='' && $keyword!='0')
		{
			
			
				$en56 = '';
				$en78 = '';
				if($getid)
				{
					$en56.="`event_title` like ('%".mysql_real_escape_string($keyword)."%')  OR `zipcode` like ('%".mysql_real_escape_string($keyword)."%')  OR FIND_IN_SET(".$getid.", event_category) OR `address` like ('%".mysql_real_escape_string($keyword)."%')  OR ";
				}
				else {
					$en56.="`event_title` like ('%".mysql_real_escape_string($keyword)."%')  OR `zipcode` like ('%".mysql_real_escape_string($keyword)."%')  OR `address` like ('%".mysql_real_escape_string($keyword)."%')  OR ";
				}
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		if(substr_count($keyword,' ') >=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$en78.=" `event_title` like ('".mysql_real_escape_string($val)."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en56.substr($en78, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en56, 0 ,-3).')')  ;
		}
		}
		
		if($event_date!='1V1' && $event_date!='' && $event_date!='0')
		{
			$date = explode('-',$event_date);
			$start_date  = date("Y-m-d",strtotime($date[0]));
			$end_date= date("Y-m-d",strtotime($date[1]));
				$this->db->where('eventdate >=', $start_date);
			$this->db->where('eventdate <=', $end_date);
			//$this->db->where('eventdate',$event_date );
		}
		$this->db->where('eventdate >=',date('Y-m-d'));
			$this->db->group_by('event_time.event_id');
		$qry = $this->db->get();		
		return $qry->num_rows();
	}
	
	function getcountallevent($bar_id)
	{
		$this->db->select("*");
		$this->db->from("events");
		$this->db->join("event_time",'event_time.event_id=events.event_id');
		$this->db->where('events.status','active');
		$this->db->where('is_deleted','no');
		//$this->db->where('end_date >=',date('Y-m-d h:i:s'));
		if($bar_id>0)
		{
			$this->db->where('bar_id',$bar_id);
		}
		else {
			$this->db->where('bar_id','0');
		}
		
		$this->db->where('eventdate >=',date('Y-m-d'));
		$this->db->group_by('event_time.event_id');
		$qry = $this->db->get();		
		return $qry->num_rows();
	}
	function getlatestevent($limit,$bar_id)
	{
		$this->db->select('*');
		$this->db->from("events");
		$this->db->join("event_time",'event_time.event_id=events.event_id');
		$this->db->where('status','active');
			$this->db->where('eventdate >=',date('Y-m-d'));
		$this->db->where('is_deleted','no');
		
			if($bar_id>0)
		{
			$this->db->where('bar_id',$bar_id);
		}
		else {
			$this->db->where('bar_id','0');
		}
		
		$this->db->limit($limit);
		$this->db->order_by('events.event_id','desc');
		$this->db->group_by('event_time.event_id');
		$qry = $this->db->get();
		
		if($qry->num_rows()>0)
		{
			 return $qry->result();
		}
		
		
		return 0;
	}
	function get_event_result($offset = 0,$limit = 0,$sort_by= '',$sort_type = '',$keyword = 0,$event_date,$alpha ='',$bar_id)
	{
		$getid = getcategoryIdbykeyword($keyword);
		/*$this->db->select("v.*,c.category_name,u.first_name,u.last_name");
		$this->db->from("beer_directory v");
		$this->db->join("category c","c.category_id = v.beer_category_id");
		$this->db->join("user_master u","u.user_id = v.user_id","LEFT");*/
		$this->db->select('*');
		$this->db->from("events");
		$this->db->join("event_time",'event_time.event_id=events.event_id');
		$this->db->where('events.status','active');
		$this->db->where('is_deleted','no');
		//$this->db->where('end_date >=',date('Y-m-d h:i:s'));
		if($bar_id>0)
		{
			$this->db->where('bar_id',$bar_id);
		}
		else {
			$this->db->where('bar_id','0');
		}
		if($alpha != "" && $alpha != "no")
		{
		   $this->db->like("event_title",$alpha,"after");
		}
		
		if($keyword!='1V1' && $keyword!='' && $keyword!='0')
		{
			
			
				$en56 = '';
				$en78 = '';
				if($getid)
				{
					$en56.="`event_title` like ('%".mysql_real_escape_string($keyword)."%')  OR `zipcode` like ('%".mysql_real_escape_string($keyword)."%')  OR FIND_IN_SET(".$getid.", event_category) OR `address` like ('%".mysql_real_escape_string($keyword)."%')  OR ";
				}
				else {
					$en56.="`event_title` like ('%".mysql_real_escape_string($keyword)."%')  OR `zipcode` like ('%".mysql_real_escape_string($keyword)."%')  OR `address` like ('%".mysql_real_escape_string($keyword)."%')  OR ";
				}
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		if(substr_count($keyword,' ') >=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$en78.=" `event_title` like ('".mysql_real_escape_string($val)."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en56.substr($en78, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en56, 0 ,-3).')')  ;
		}
		}
		if($event_date!='1V1' && $event_date!='' && $event_date!='0')
		{
			$date = explode('-',$event_date);
			$start_date  = date("Y-m-d",strtotime($date[0]));
			$end_date= date("Y-m-d",strtotime($date[1]));
				$this->db->where('eventdate >=', $start_date);
			$this->db->where('eventdate <=', $end_date);
			//$this->db->where('eventdate',$event_date );
		}
		$this->db->where('eventdate >=',date('Y-m-d'));
		$this->db->order_by('eventdate','asc' );
		$this->db->order_by("events.".$sort_by,$sort_type);
		
		$this->db->group_by('event_time.event_id');
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		
		//echo $this->db->last_query();
		if($qry->num_rows()>0)
		{
			 return $qry->result();
		}
		
		
		return 0;
	}
	
	
	function get_one_event($id = 0)
	{
		$this->db->select('*');		
		$this->db->from('events');
		//$this->db->join('event_attend',);
		$this->db->where('event_id',$id);

		$qry = $this->db->get();
		if($qry->num_rows()>0)
		{
			 return $qry->row_array();
		}
		return 0;
	}
	
	 function getEventGallery($event_id)
	{
		$this->db->select('*');
		$this->db->from('event_images');
		$this->db->where(array('bar_eventgallery_id'=>$event_id));
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}
	
		 function getEventTime($event_id)
	{
		$this->db->select('*');
		$this->db->from('event_time');
		$this->db->where(array('event_id'=>$event_id));
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}
	
	function checkeventalreadyattend($eventid,$type,$user_id)
	{
		$this->db->select('*');		
		$this->db->from('event_attend');
		$this->db->where('event_id',$eventid);
		$this->db->where('user_id',$user_id);

		$qry = $this->db->get();
		if($qry->num_rows()>0)
		{
			 return $qry->row_array();
		}
		return 0;
	}
	
	function get_event_likers($id=0){
		$this->db->select('a.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('event_attend a');		
		$this->db->join('user_master u','u.user_id=a.user_id');
		$this->db->where('a.event_id',$id);
		$this->db->where('a.is_attend','yes');
		$this->db->order_by('a.date','desc');
		$this->db->group_by('user_id');
		$this->db->limit(12);
		$qry = $this->db->get();
		if($qry->num_rows() >0){
			return $qry->result();
		}
//		print_r($qry);die;
	}
	
	function get_all_event_likers($id=0){
		$this->db->select('a.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('event_attend a');		
		$this->db->join('user_master u','u.user_id=a.user_id');
		$this->db->where('a.event_id',$id);
		$this->db->where('a.is_attend','yes');
		$this->db->order_by('a.date','desc');
		$this->db->group_by('user_id');
		$qry = $this->db->get();
		if($qry->num_rows() >0){
			return $qry->result();
		}
//		print_r($qry);die;
	}
		function getBarEvent_m($bar_id,$limit='',$eid='')
	{
		
		$this->db->select('*');
		$this->db->from('events');
		$this->db->join("event_time",'event_time.event_id=events.event_id');
		$this->db->where(array('events.bar_id'=>$bar_id,'status'=>'active','is_deleted'=>'no'));
		$this->db->where('events.event_id !=' ,$eid);
		$this->db->where('eventdate >=',date('Y-m-d'));
		$this->db->order_by('events.event_id','desc');
		$this->db->group_by('event_time.event_id');
		if($limit>0 && $limit!="")
		{
			$this->db->limit($limit);
		}	
		$query = $this->db->get();
		
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}
	
	
	function getallevent()
	{
		 $this->db->select("*");
		 $this->db->from("events");
		 //$this->db->from("events");
		 $query =$this->db->get();
		 if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}


}	
?>