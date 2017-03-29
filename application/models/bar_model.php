<?php
class Bar_model extends CI_Model 
{
	function Bar_model()
    {
        parent::__construct();	
    } 	
    
    /////// end of uplaod banner //////////////////////////////
	function get_total_bar_count_by_type($bar_type = '')
	{
	// return $this->db->count_all('bars');
	
	    $this->db->select('b.*');
		$this->db->from('bars b');
		$this->db->join('user_master u','u.user_id=b.owner_id','left');
		
                if ($bar_type == "half_mug_claimed_bar") {
                    $where = "(b.bar_type='half_mug' AND ((b.owner_id IS NOT NULL AND b.owner_id!=0 AND u.status='active') OR (b.claim='claimed')))";
                    $this->db->where($where);
                }
                else if ($bar_type == "half_mug_unclaimed_bar") {
                    $where = "(b.bar_type='half_mug' AND (b.owner_id IS NULL OR u.status!='active') OR (b.owner_id=0 AND b.claim='unclaimed'))";
                    $this->db->where($where);  
                }
		else if($bar_type != "all" && $bar_type!='managed_bar' )
		{
			$this->db->where("bar_type",$bar_type);
		}
		if($bar_type=='managed_bar' )
		{
			$this->db->where("is_managed",'yes');
		}
		$this->db->where("b.status !=",'archived');
		
		$qry = $this->db->get();
		
		return $qry->num_rows();
	}
	
	function get_total_bar_count($bar_title = '',$state = '',$city = '',$zipcode='',$bar_title_new='',$bar_title_j,$address_j,$days)
	{
		 if($bar_title_new=='1V1' || $bar_title_new=='')
		{
			$bar_title_new = '';
		}
		$en ='';
		$getstatename = getstatenamebycode($state);
		$getstatename1 = getcodebystate($state);
		$getstatename2 = getstatenamebycode($bar_title_new);
		$getstatename3 = getcodebystate($bar_title_new);
		$getstatename4 = getstatenamebycode($address_j);
		$getstatename5 = getcodebystate($address_j);
		$this->db->select("*");
		$this->db->from("bars");
		if($days != '1V1' && $days!= "")
		{
			$this->db->join("bar_special_hours",'bar_special_hours.bar_id=bars.bar_id');
		}
		
		
		
		if($address_j!='1V1' && $address_j!='')
		{
			if($getstatename4)
			{
				$en.="`address` like ('%".$address_j."%') OR `city` like ('%".$address_j."%') OR `zipcode` like ('%".$address_j."%') OR `state` like ('".$getstatename4."%') OR `state` like ('%".$address_j."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
				//$this->db->like("state",$getstatename);
			}
			else if($getstatename5){
				$en.="`address` like ('%".$address_j."%') OR `city` like ('%".$address_j."%') OR `zipcode` like ('%".$address_j."%') OR `state` like ('%".$getstatename5."%') OR `state` like ('%".$address_j."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
			}
			else {
				$en.="`address` like ('%".$address_j."%') OR `city` like ('%".$address_j."%') OR `zipcode` like ('%".$address_j."%') OR `state` like ('%".$address_j."%') OR";
			//$en.=" `user_master.last_name` like ('".$keyword."%') OR";
		
		
			  $this->db->where('('.substr($en, 0 ,-3).')')  ;
			}
		}
		if($bar_title_j != '1V1' && $bar_title_j!= "" && !is_numeric($bar_title_j))
		{
			
			
			$this->db->like("bar_title",$bar_title_j);
			//$this->db->or_like("zipcode",$bar_title);
			//$this->db->or_like("bar_desc",$bar_title);
		}
		if($days != '1V1' && $days!= "")
		{
			$this->db->where("days",$days);
			$this->db->where("bar_type","full_mug");
			
			//$this->db->like("bar_title",$bar_title_j);
			//$this->db->or_like("zipcode",$bar_title);
			//$this->db->or_like("bar_desc",$bar_title);
		}
		if($bar_title_new!='' && $bar_title_new!='1V1' && $bar_title_new!='')
		{
			
			// $this->db->like("bar_title",$bar_title_new);
			// $this->db->like("city",$bar_title_new);
			// $this->db->like("zipcode",$bar_title_new);
			if($getstatename2)
			{
				$en56 = '';
				$en78 = '';
				$en56.="`bar_title` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `city` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `zipcode` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `state` like ('".$getstatename2."%') OR `state` like ('%".mysql_real_escape_string($bar_title_new)."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		if(substr_count($bar_title_new,' ')>=1)
			      {
				     $ex=explode(' ',$bar_title_new);
				
					foreach($ex as $val)
					{
						$en78.=" `bar_title` like ('".mysql_real_escape_string($val)."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en56.substr($en78, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en56, 0 ,-3).')')  ;
		}
		
			//$this->db->where('('.substr($en, 0 ,-3).')')  ;
				//$this->db->like("state",$getstatename);
			}
			else if($getstatename3){
			//	$en.="`bar_title` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `city` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `zipcode` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `state` like ('%".$getstatename3."%') OR `state` like ('%".mysql_real_escape_string($bar_title_new)."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		
			//$this->db->where('('.substr($en, 0 ,-3).')')  ;
			
			$en56 = '';
				$en78 = '';
				$en56.="`bar_title` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `city` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `zipcode` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `state` like ('".$getstatename3."%') OR `state` like ('%".mysql_real_escape_string($bar_title_new)."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		if(substr_count($bar_title_new,' ')>=1)
			      {
				     $ex=explode(' ',$bar_title_new);
				
					foreach($ex as $val)
					{
						$en78.=" `bar_title` like ('".mysql_real_escape_string($val)."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en56.substr($en78, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en56, 0 ,-3).')')  ;
		}
			}
			else {
				//$en.="`bar_title` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `city` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `zipcode` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `state` like ('%".mysql_real_escape_string($bar_title_new)."%') OR";
			//$en.=" `user_master.last_name` like ('".$keyword."%') OR";
		
		
			//  $this->db->where('('.substr($en, 0 ,-3).')')  ;
			  
			  	$en56 = '';
				$en78 = '';
				$en56.="`bar_title` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `city` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `zipcode` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `state` like ('%".mysql_real_escape_string($bar_title_new)."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		if(substr_count($bar_title_new,' ')>=1)
			      {
				     $ex=explode(' ',$bar_title_new);
				
					foreach($ex as $val)
					{
						$en78.=" `bar_title` like ('".mysql_real_escape_string($val)."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en56.substr($en78, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en56, 0 ,-3).')')  ;
		}
			}
		}
		if($bar_title != '0' && $bar_title!="1V1" && $bar_title != "")
		{
			
			//echo "fsda";
			$en12 = '';
			$en34 = '';
			//$this->db->like("bar_title",$bar_title);
			//$this->db->or_like("zipcode",$bar_title);
			//$this->db->or_like("bar_desc",$bar_title);
			
			$en12.=" `bar_title` like ('%".mysql_real_escape_string($bar_title)."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		if(substr_count($bar_title,' ')>=1)
			      {
				     $ex=explode(' ',$bar_title);
				
					foreach($ex as $val)
					{
						$en34.=" `bar_title` like ('".mysql_real_escape_string($val)."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en12.substr($en34, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en12, 0 ,-3).')')  ;
		}
		
		}
		if($state != '0' && $state != '1V1' && $state != "")
		{
			
			
			if($getstatename)
			{
				
				$en.=" `state` like ('%".$getstatename."%') OR `state` like ('%".$state."%') OR";
			//$en.=" `user_master.last_name` like ('".$keyword."%') OR";
		
		
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
				//$this->db->like("state",$getstatename);
			}
			else if($getstatename1){
				$en.=" `state` like ('%".$getstatename1."%') OR `state` like ('%".$state."%') OR";
			//$en.=" `user_master.last_name` like ('".$keyword."%') OR";
		
		
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
			}
			else {
					$this->db->like("state",$state);
				
			}
				//$this->db->or_like("state",$state);
			
		}
		if($city != '0' && $city != '1V1' && $city != "")
		{
			$this->db->like("city",$city);
		}
		 if($zipcode != '0' && $zipcode != '1V1' && $zipcode != "")
		 {
			 $this->db->like("zipcode",$zipcode);
		 }	
		$this->db->where('status','active');
		
		//if((!is_numeric($bar_title_new)=='' || $bar_title_new=='1V1'  || $bar_title_new!='') && ($bar_title == '0' || $bar_title == "") && ($state == '0' || $state == "") && ($city == '0' || $city == "") && ($zipcode == '0' || $zipcode == ""))
		//{
		//}
		if($days != '1V1' && $days!= "")
		{
			$this->db->group_by('bar_special_hours.bar_id');
		}
		
		$qry = $this->db->get();
		
		//echo $this->db->last_query();
		
		if($qry->num_rows()>0)
		{
			 return $qry->num_rows();
		}
		
		
		return 0;
		//die;	
		
	}
	
	function get_bar_result($offset = 0,$limit = 0,$sort_by= '',$sort_type = '',$bar_title = '',$state = '',$city = '',$zipcode='',$bar_title_new='',$bar_title_j,$address_j,$days)
	{
		$this->db->_protect_identifiers=false; 
		//echo $bar_title_new;
		 if($bar_title_new=='1V1' || $bar_title_new=='')
		{
			$bar_title_new = '';
		}
		$en ='';
			$getstatename = getstatenamebycode($state);
		$getstatename1 = getcodebystate($state);
		$getstatename2 = getstatenamebycode($bar_title_new);
			$getstatename3 = getcodebystate($bar_title_new);
		$getstatename4 = getstatenamebycode($address_j);
		$getstatename5 = getcodebystate($address_j);
		$this->db->select("*");
		$this->db->from("bars");
		if($days != '1V1' && $days!= "")
		{
			$this->db->join("bar_special_hours",'bar_special_hours.bar_id=bars.bar_id');
		}
		
		
		
		if($address_j!='1V1' && $address_j!='')
		{
			if($getstatename4)
			{
				$en.="`address` like ('%".$address_j."%') OR `city` like ('%".$address_j."%') OR `zipcode` like ('%".$address_j."%') OR `state` like ('".$getstatename4."%') OR `state` like ('%".$address_j."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
				//$this->db->like("state",$getstatename);
			}
			else if($getstatename5){
				$en.="`address` like ('%".$address_j."%') OR `city` like ('%".$address_j."%') OR `zipcode` like ('%".$address_j."%') OR `state` like ('%".$getstatename5."%') OR `state` like ('%".$address_j."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
			}
			else {
				$en.="`address` like ('%".$address_j."%') OR `city` like ('%".$address_j."%') OR `zipcode` like ('%".$address_j."%') OR `state` like ('%".$address_j."%') OR";
			//$en.=" `user_master.last_name` like ('".$keyword."%') OR";
		
		
			  $this->db->where('('.substr($en, 0 ,-3).')')  ;
			}
		}
		if($bar_title_j != '1V1' && $bar_title_j!= "" && !is_numeric($bar_title_j))
		{
			
			
			$this->db->like("bar_title",$bar_title_j);
			//$this->db->or_like("zipcode",$bar_title);
			//$this->db->or_like("bar_desc",$bar_title);
		}
		if($days != '1V1' && $days!= "")
		{
			$this->db->where("days",$days);
			$this->db->where("bar_type","full_mug");
			
			//$this->db->like("bar_title",$bar_title_j);
			//$this->db->or_like("zipcode",$bar_title);
			//$this->db->or_like("bar_desc",$bar_title);
		}
		if($bar_title_new!='' && $bar_title_new!='1V1' && $bar_title_new!='')
		{
			
			// $this->db->like("bar_title",$bar_title_new);
			// $this->db->like("city",$bar_title_new);
			// $this->db->like("zipcode",$bar_title_new);
			if($getstatename2)
			{
				$en56 = '';
				$en78 = '';
				$en56.="`bar_title` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `city` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `zipcode` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `state` like ('".$getstatename2."%') OR `state` like ('%".mysql_real_escape_string($bar_title_new)."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		if(substr_count($bar_title_new,' ')>=1)
			      {
				     $ex=explode(' ',$bar_title_new);
				
					foreach($ex as $val)
					{
						$en78.=" `bar_title` like ('".mysql_real_escape_string($val)."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en56.substr($en78, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en56, 0 ,-3).')')  ;
		}
		
			//$this->db->where('('.substr($en, 0 ,-3).')')  ;
				//$this->db->like("state",$getstatename);
			}
			else if($getstatename3){
			//	$en.="`bar_title` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `city` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `zipcode` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `state` like ('%".$getstatename3."%') OR `state` like ('%".mysql_real_escape_string($bar_title_new)."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		
			//$this->db->where('('.substr($en, 0 ,-3).')')  ;
			
			$en56 = '';
				$en78 = '';
				$en56.="`bar_title` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `city` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `zipcode` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `state` like ('".$getstatename3."%') OR `state` like ('%".mysql_real_escape_string($bar_title_new)."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		if(substr_count($bar_title_new,' ')>=1)
			      {
				     $ex=explode(' ',$bar_title_new);
				
					foreach($ex as $val)
					{
						$en78.=" `bar_title` like ('".mysql_real_escape_string($val)."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en56.substr($en78, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en56, 0 ,-3).')')  ;
		}
			}
			else {
				//$en.="`bar_title` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `city` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `zipcode` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `state` like ('%".mysql_real_escape_string($bar_title_new)."%') OR";
			//$en.=" `user_master.last_name` like ('".$keyword."%') OR";
		
		
			//  $this->db->where('('.substr($en, 0 ,-3).')')  ;
			  
			  	$en56 = '';
				$en78 = '';
				$en56.="`bar_title` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `city` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `zipcode` like ('%".mysql_real_escape_string($bar_title_new)."%') OR `state` like ('%".mysql_real_escape_string($bar_title_new)."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		if(substr_count($bar_title_new,' ')>=1)
			      {
				     $ex=explode(' ',$bar_title_new);
				
					foreach($ex as $val)
					{
						$en78.=" `bar_title` like ('".mysql_real_escape_string($val)."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en56.substr($en78, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en56, 0 ,-3).')')  ;
		}
			}
		}
		if($bar_title != '0' && $bar_title!="1V1" && $bar_title != "")
		{
			
			//echo "fsda";
			$en12 = '';
			$en34 = '';
			//$this->db->like("bar_title",$bar_title);
			//$this->db->or_like("zipcode",$bar_title);
			//$this->db->or_like("bar_desc",$bar_title);
			
			$en12.=" `bar_title` like ('%".mysql_real_escape_string($bar_title)."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		if(substr_count($bar_title,' ')>=1)
			      {
				     $ex=explode(' ',$bar_title);
											  
				  	foreach($ex as $val)
					{
						//echo strlen($val);
						$en34.=" `bar_title` like ('".mysql_real_escape_string($val)."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en12.substr($en34, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en12, 0 ,-3).')')  ;
		}
		
		}
		if($state != '0' && $state != '1V1' && $state != "")
		{
			
			
			if($getstatename)
			{
				
				$en.=" `state` like ('%".$getstatename."%') OR `state` like ('%".$state."%') OR";
			//$en.=" `user_master.last_name` like ('".$keyword."%') OR";
		
		
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
				//$this->db->like("state",$getstatename);
			}
			else if($getstatename1){
				$en.=" `state` like ('%".$getstatename1."%') OR `state` like ('%".$state."%') OR";
			//$en.=" `user_master.last_name` like ('".$keyword."%') OR";
		
		
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
			}
			else {
					$this->db->like("state",$state);
				
			}
				//$this->db->or_like("state",$state);
			
		}
		if($city != '0' && $city != '1V1' && $city != "")
		{
			$this->db->like("city",$city);
		}
		 if($zipcode != '0' && $zipcode != '1V1' && $zipcode != "")
		 {
			 $this->db->like("zipcode",$zipcode);
		 }	
		$this->db->where('status','active');
		
		//if((!is_numeric($bar_title_new)=='' || $bar_title_new=='1V1'  || $bar_title_new!='') && ($bar_title == '0' || $bar_title == "") && ($state == '0' || $state == "") && ($city == '0' || $city == "") && ($zipcode == '0' || $zipcode == ""))
		//{
		$this->db->order_by('bar_type','desc');
		//}
	//	$this->db->order_by($sort_by,$sort_type);
		
		if($bar_title!='' && $bar_title!='1V1')
		{
			if($sort_type=='')
			{
		$this->db->order_by('CASE WHEN bar_title like "'.$bar_title.'" THEN 0
            WHEN bar_title like "'.$bar_title.' %" THEN 1
           WHEN bar_title like "%'.$bar_title.'" THEN 2
           ELSE bar_title  END',NULL,FALSE);
			}
			else
			{
				if($sort_by && $sort_type)
				{
				$this->db->order_by($sort_by,$sort_type);
				}
				
			}	
		}
		
		
		else if($bar_title_new!='' && $bar_title_new!='1V1' && $bar_title_new!='')
		{
			if($sort_type=='')
			{
				$this->db->order_by('CASE WHEN bar_title like "'.$bar_title_new.'" THEN 0
           WHEN bar_title like "'.$bar_title_new.' %" THEN 1
		   WHEN bar_title like "%'.$bar_title_new.'%" THEN 2
            ELSE bar_title 
      END',NULL,FALSE);
			}
			else
				if($sort_by && $sort_type)
				{
				$this->db->order_by($sort_by,$sort_type);
				}
			
		}
		else {
				//$this->db->order_by('bar_type','desc');
		//}
				if($sort_by && $sort_type)
				{
				$this->db->order_by($sort_by,$sort_type);
				}
		}
			if($days != '1V1' && $days!= "")
		{
			$this->db->group_by('bar_special_hours.bar_id');
		}
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		
		//echo $this->db->last_query();
		
		if($qry->num_rows()>0)
		{
			 return $qry->result();
		}
		
		
		return 0;
	}
	
	
	function auto_suggest_bar($q){
		$this->db->like('bar_title',$q,'after');
		$this->db->select('bar_title,bar_id,bar_type');
		$this->db->from('bars');
		$this->db->where('status','active');
		if(strlen($q)>=4)
		{
			$this->db->limit(100);
		}
		else {
			$this->db->limit(10);
		}
		$query = $this->db->get();
		
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
		return 0;
	}
	
	function get_one_bar($id = 0)
	{
		$this->db->select('*,bars.address as address,bars.followers, bars.city as city,bars.state as state,bars.zipcode as zipcode,bars.website as website,bars.twitter_link as twitter_link,bars.linkedin_link as linkedin_link,bars.pinterest_link as pinterest_link,bars.instagram_link as instagram_link');		
		$this->db->from('bars');
		$this->db->join('user_master u','u.user_id=bars.owner_id','left');
		$this->db->where('bar_id',$id);
		$qry = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($qry->num_rows()>0)
		{
			 return $qry->row_array();
		}
		return 0;
	}
	//function get_bar_likers($id=0){
		/*$this->db->select('a.*,u.profile_image');
		$this->db->from('all_likes a');		
		$this->db->join('user_master u','u.user_id=a.user_id');
		$this->db->where('a.bar_id',$id);
		$this->db->where('like_flag',1);
		$this->db->order_by('date_added','asc');
		$this->db->group_by('user_id');
		$qry = $this->db->get();
		if($qry->num_rows() >0){
			return $qry->result();
		}*/
//		print_r($qry);die;
	//}
	
	function get_bar_comments($id=0){
		$this->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('bar_comment b');		
		$this->db->join('user_master u','u.user_id=b.user_id','left');
		$this->db->where('b.bar_id',$id);
		$this->db->where('b.is_deleted',0);
		//$this->db->where('b.master_comment_id',0);
		$this->db->order_by('date_added','desc');
		$qry = $this->db->get();
		if($qry->num_rows() >0){
			return $qry->result();
		}
//		print_r($qry);die;
	}
	
	function get_bar_comments_count($id=0){
		$this->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('bar_comment b');		
		$this->db->join('user_master u','u.user_id=b.user_id','left');
		$this->db->where('b.bar_id',$id);
		$this->db->where('b.is_deleted','no');
		//$this->db->where('b.master_comment_id',0);
		$this->db->order_by('date_added','desc');
		$qry = $this->db->get();
			return $qry->num_rows();
//		print_r($qry);die;
	}
	

    function getAllComments($id=0,$offset="",$limit=""){
		$this->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('bar_comment b');		
		$this->db->join('user_master u','u.user_id=b.user_id','left');
		$this->db->where('b.bar_id',$id);
		$this->db->where('b.is_deleted','no');
		$this->db->order_by('date_added','desc');
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		if($qry->num_rows() >0){
			return $qry->result();
		}
//		print_r($qry);die;
	}
	
	function insert_comment($data_insert = array())
	{
		
		$image_setting = image_setting();
		$data_insert['comment_image']='';
		//print_r($_FILES);die;
		if(isset($_FILES['comment_image']) && $_FILES['comment_image']["name"]!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
            $_FILES['userfile']['name']     =   $_FILES['comment_image']['name'];
             $_FILES['userfile']['type']     =   $_FILES['comment_image']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['comment_image']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['comment_image']['error'];
             $_FILES['userfile']['size']     =   $_FILES['comment_image']['size'];
   
			$config['file_name'] = 'comment'.$rand;
			
            $config['upload_path'] = base_path().'upload/comment_image/';
			
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			
			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   
              $this->image_lib->clear();
		   	
			
					$gd_var='gd2';
				
				
		   if ($_FILES["comment_image"]["type"]!= "image/png" and $_FILES["comment_image"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["comment_image"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["comment_image"]["type"] != "image/jpeg" and $_FILES["comment_image"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/comment_image/'.$picture['file_name'],
				//'new_image' => base_path().'upload/user_thumb/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => $image_setting->comment_image_width,//$image_setting->user_width,
				'height' => $image_setting->comment_image_height,//$image_setting->user_height,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$data_insert['comment_image']= $picture['file_name'];
			
		
			if($this->input->post('pre_comment_image')!='')
				{
					if(file_exists(base_path().'upload/comment_image/'.$this->input->post('pre_profile_image')))
					{
						$link=base_path().'upload/comment_image/'.$this->input->post('pre_profile_image');
						unlink($link);
					}			
				}
			}
			else {
				if($this->input->post('pre_comment_image')!='')
				{
					$data_insert['comment_image']=$this->input->post('pre_comment_image');
				}
			}
			
			
		// ///////////////// VIDEO UPLOAD////////////////////////////
		
		 $data_insert['comment_video']="";		
		 if(isset($_FILES["comment_video"]) && $_FILES["comment_video"]["name"]!="")
         {
             $this->load->library("upload");
             $rand=rand(0,100000); 
			  
             $_FILES["userfile"]["name"]     =   $_FILES["comment_video"]["name"];
             $_FILES["userfile"]["type"]     =   $_FILES["comment_video"]["type"];
             $_FILES["userfile"]["tmp_name"] =   $_FILES["comment_video"]["tmp_name"];
             $_FILES["userfile"]["error"]    =   $_FILES["comment_video"]["error"];
             $_FILES["userfile"]["size"]     =   $_FILES["comment_video"]["size"];
   
		
			
			$config["file_name"] = $this->input->post('comment_video').$rand;
		 
            $config['upload_path']=base_path()."upload/comment_video";
			
            $config['allowed_types'] = '*';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			 
           	    $picture = $this->upload->data();
			    $data_insert['comment_video']=$picture["file_name"];
		      //  $data_insert["video"] = $videoname;
			      if($this->input->post("prev_comment_video")!="")
				{
					if(file_exists(base_path()."upload/comment_video/".$this->input->post("prev_comment_video")))
					{
						$link=base_path()."upload/comment_video/".$this->input->post("prev_comment_video");
						unlink($link);
					}
					
				
				} 
                }
		else {
				if($this->input->post("pre_comment_video"))
				{
					$videoname=$this->input->post("pre_comment_video");
				}
		   }
		// ///////////////// VIDEO UPLOAD////////////////////////////		
		
		$data_insert["user_id"] = $this->session->userdata("user_id");
		$data_insert["status"] = "active";
		$data_insert["date_added"] = date("Y-m-d H:i:s");
		$data_insert["is_deleted"] = "0";
	
		$this->db->insert("bar_comment",$data_insert);
	}
	
	function insert_subcomment($data_insert = array())
	{
		
		$image_setting = image_setting();
		$data_insert['comment_image']='';
		//print_r($_FILES);die;
		if(isset($_FILES['comment_image']) && $_FILES['comment_image']["name"]!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
            $_FILES['userfile']['name']     =   $_FILES['comment_image']['name'];
             $_FILES['userfile']['type']     =   $_FILES['comment_image']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['comment_image']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['comment_image']['error'];
             $_FILES['userfile']['size']     =   $_FILES['comment_image']['size'];
   
			$config['file_name'] = 'subcomment'.$rand;
			
            $config['upload_path'] = base_path().'upload/comment_image/';
			
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			
			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   
              $this->image_lib->clear();
		   	
			
					$gd_var='gd2';
				
				
		   if ($_FILES["comment_image"]["type"]!= "image/png" and $_FILES["comment_image"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["comment_image"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["comment_image"]["type"] != "image/jpeg" and $_FILES["comment_image"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/comment_image/'.$picture['file_name'],
				//'new_image' => base_path().'upload/user_thumb/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => $image_setting->comment_image_width,//$image_setting->user_width,
				'height' => $image_setting->comment_image_height,//$image_setting->user_height,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$data_insert['comment_image']= $picture['file_name'];
			
		
			if($this->input->post('pre_comment_image')!='')
				{
					if(file_exists(base_path().'upload/comment_image/'.$this->input->post('pre_profile_image')))
					{
						$link=base_path().'upload/comment_image/'.$this->input->post('pre_profile_image');
						unlink($link);
					}			
				}
			}
			else {
				if($this->input->post('pre_comment_image')!='')
				{
					$data_insert['comment_image']=$this->input->post('pre_comment_image');
				}
			}
			
			
		// ///////////////// VIDEO UPLOAD////////////////////////////
		
		 $data_insert['comment_video']="";		
		 if(isset($_FILES["comment_video"]) && $_FILES["comment_video"]["name"]!="")
         {
             $this->load->library("upload");
             $rand=rand(0,100000); 
			  
             $_FILES["userfile"]["name"]     =   $_FILES["comment_video"]["name"];
             $_FILES["userfile"]["type"]     =   $_FILES["comment_video"]["type"];
             $_FILES["userfile"]["tmp_name"] =   $_FILES["comment_video"]["tmp_name"];
             $_FILES["userfile"]["error"]    =   $_FILES["comment_video"]["error"];
             $_FILES["userfile"]["size"]     =   $_FILES["comment_video"]["size"];
   
		
			
			$config["file_name"] = $this->input->post('comment_video').$rand;
		 
            $config['upload_path']=base_path()."upload/comment_video";
			
            $config['allowed_types'] = '*';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			 
           	    $picture = $this->upload->data();
			    $data_insert['comment_video']=$picture["file_name"];
		      //  $data_insert["video"] = $videoname;
			      if($this->input->post("prev_comment_video")!="")
				{
					if(file_exists(base_path()."upload/comment_video/".$this->input->post("prev_comment_video")))
					{
						$link=base_path()."upload/comment_video/".$this->input->post("prev_comment_video");
						unlink($link);
					}
					
				
				} 
                }
		else {
				if($this->input->post("pre_comment_video"))
				{
					$videoname=$this->input->post("pre_comment_video");
				}
		   }
		// ///////////////// VIDEO UPLOAD////////////////////////////		
		
		$data_insert["user_id"] = $this->session->userdata("user_id");
		$data_insert["status"] = "active";
		$data_insert["date_added"] = date("Y-m-d H:i:s");
		$data_insert["is_deleted"] = "0";
	
		$this->db->insert("bar_comment",$data_insert);
	}
	function get_bar_subcomments($id=0){
		/*$this->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('bar_comment b');		
		$this->db->join('user_master u','u.user_id=b.user_id');
		//$CI->db->join('bar_comment bc','bc.master_comment_id=b.bar_comment_id');
		$this->db->where('b.master_comment_id!=','0',false);
		$this->db->where('b.bar_id',$id);
		$this->db->where('b.is_deleted',0);
		$this->db->order_by('date_added','desc');
		$qry = $this->db->get();		
		if($qry->num_rows() >0){
			$temp_arr = $qry->result();
			$res = array();
			$i =0;
			foreach($temp_arr as $temp){
				$res[$temp->master_comment_id][$i] = $temp;
				$i++;
			}
			return $res;
		}*/
	}
	function single_comment_total_likes($bar_id,$comment_id){
		$this->db->select('*');
		$this->db->from('all_likes');
		$this->db->where('bar_id',$bar_id);
		$this->db->where('bar_comment_id',$comment_id);
		$this->db->where('like_flag',1);
		
		$query = $this->db->get();
		if($query->num_rows() >0){	     
			return $query->num_rows();
		} 
	}
	
	function flag_return($bar_id,$user_id,$comment_id){
		$this->db->select('like_flag');
		$this->db->from('all_likes');
		$this->db->where('bar_id',$bar_id);
		$this->db->where('user_id',$user_id);
		$this->db->where('bar_comment_id',$comment_id);
		$query = $this->db->get();
		if($query->num_rows() >0){
			return $query->row()->like_flag;
		}
	}
	function sub_comment_remove($bar_comment_id){
		$data_update = array('is_deleted'=>1);
		$this->db->where('bar_comment_id',$bar_comment_id);
		$this->db->update('bar_comment',$data_update);
	}
	function one_bar_likers($id=0){
		$this->db->select('*');
		$this->db->from('user_master');		
		$this->db->where('user_id',$id);
		$qry = $this->db->get();
		if($qry->num_rows()>0){
			//return $qry->row()->profile_image;
			return $qry->row();
		}
		else{
			return '';
		}
	}

	function insert_bar_comment($data_insert = array())
	{
		
		$data_insert1["user_id"] = $this->session->userdata("user_id");
		$data_insert1["status"] = "active";
		$data_insert1["date_added"] = date("Y-m-d H:i:s");
		$data_insert1["is_deleted"] = "no";
		$data_insert1["comment"] = nl2br($this->input->post('comment'));
		$data_insert1["bar_id"] = $this->input->post('bar_id');
		$data_insert1["comment_title"] = $this->input->post('comment_title');
		$data_insert1["bar_rating"] = $this->input->post('rating');
	
		$this->db->insert("bar_comment",$data_insert1);
		$getid= mysql_insert_id();
		$getbarinfo = $this->get_one_bar($this->input->post('bar_id'));
		
		$getuserinfo = get_user_info($this->session->userdata("user_id"));
		$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Bar Comment'");
		$email_temp=$email_template->row();             
		$email_address_from=$email_temp->from_address;
        $email_address_reply=$email_temp->reply_address;
                
        $email_subject=$email_temp->subject;                
        $email_message=$email_temp->message;
                
        $email = $getbarinfo['email'];
        //"php.developer@spaculus.com";
        //$site_name = $site_data->site_name;
        $email_to =$email;
		$bar_owner = ucwords($getbarinfo['bar_first_name'])." ".ucwords($getbarinfo['bar_last_name']);
		$username = ucwords($getuserinfo->first_name)." ".ucwords($getuserinfo->last_name);
		$barname = ucwords($getbarinfo['bar_title']);
		$title = ucwords($this->input->post('comment_title'));
		$description = $this->input->post('comment');
		$ratings = $this->input->post('rating');
        $email_message=str_replace('{break}','<br/>',$email_message);
        $email_message=str_replace('{bar_owner}',$bar_owner,$email_message);
		$email_message=str_replace('{barname}',$barname,$email_message);
		$email_message=str_replace('{title}',$title,$email_message);
		$email_message=str_replace('{description}',$description,$email_message);
		$email_message=str_replace('{ratings}',$ratings,$email_message);
		$email_message=str_replace('{username}',$username,$email_message);
		$email_subject=str_replace('{username}',$username,$email_subject);
        $str=$email_message;
        //echo $str;exit;
        /** custom_helper email function **/
       // echo $email_temp->status;
        if($email_temp->status=='active'){
        email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
		}
		return $getid ;
	}

    
    function getBarGallery($bar_id)
	{
		$this->db->select_max('bar_gallery_id');
		$this->db->where('bar_id',$bar_id);
		$this->db->where('status','Active');
		$Q = $this->db->get('bar_gallery');
		$row = $Q->row_array();
		
		$this->db->select('*');
		$this->db->from('bar_gallery');
		$this->db->join('bar_images','bar_gallery.bar_gallery_id=bar_images.bar_gallery_id');
		$this->db->where(array('bar_gallery.bar_id'=>$bar_id,'status'=>'Active','bar_gallery.bar_gallery_id'=>$row['bar_gallery_id']));
		$this->db->order_by('bar_gallery.bar_gallery_id','desc');
		
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}
	
	 function getBarGalleryAll($bar_id)
	{
		$this->db->select('*');
		$this->db->from('bar_gallery');
		$this->db->join('bar_images','bar_gallery.bar_gallery_id=bar_images.bar_gallery_id');
		$this->db->where(array('bar_gallery.bar_id'=>$bar_id,'status'=>'Active'));
		$this->db->order_by('bar_gallery.reorder','asc');
		$this->db->group_by('bar_images.bar_gallery_id');
	    
		
		$query = $this->db->get();
		
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}
	
	 function getBarGalleryAll123($bar_id)
	{
		$this->db->select('*');
		$this->db->from('bar_images');
		$this->db->where(array('bar_gallery_id'=>$bar_id));
		
		$query = $this->db->get();
		
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}
	
		 function getBarGalleryAllNew($bar_id)
	{
		$this->db->select('*');
		$this->db->from('bar_images');
		$this->db->where(array('bar_gallery_id'=>$bar_id));
		
		$query = $this->db->get();
		
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}
	
	function getBarEventcount($bar_id,$keyword)
	{
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
		$this->db->select('*');
		$this->db->from('events');
		$this->db->where(array('events.bar_id'=>$bar_id,'is_deleted'=>'no'));
		if($keyword!='' && $keyword!='1V1')
		{
		$this->db->like("event_title",$keyword);	
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('event_title',$val);
					}	
				}
		}		  
		$this->db->order_by('events.event_id','desc');
		$query = $this->db->get();
// 		
		 // echo $this->db->last_query();
		 // die;
		return $query->num_rows();
	}

    function getBarBeercount($bar_id,$keyword)
	{
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
		$this->db->select('*');
		$this->db->from('beer_bars');
		$this->db->join('beer_directory','beer_directory.beer_id=beer_bars.beer_id');
		$this->db->where('beer_bars.bar_id',$bar_id);
		$this->db->where('beer_directory.is_deleted','no');
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
		$this->db->order_by('beer_bars.beer_bar_id','desc');
		$query = $this->db->get();
// 		
		//  echo $this->db->last_query();
		//  die;
		return $query->num_rows();
	}
 
    function getBarCocktailcount($bar_id,$keyword)
	{
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
		$this->db->select('*');
		$this->db->from('cocktail_bars');
		$this->db->join('cocktail_directory','cocktail_directory.cocktail_id=cocktail_bars.cocktail_id');
		$this->db->where('cocktail_bars.bar_id',$bar_id);
		$this->db->where('cocktail_directory.is_deleted','no');
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
		$this->db->order_by('cocktail_bars.cocktail_bar_id','desc');
		$query = $this->db->get();
// 		
		//  echo $this->db->last_query();
		//  die;
		return $query->num_rows();
	}
	
	function getBarLiquorcount($bar_id,$keyword)
	{
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
		$this->db->select('*');
		$this->db->from('liquors_bars');
		$this->db->join('liquors','liquors.liquor_id=liquors_bars.liquor_id');
		$this->db->where('liquors_bars.bar_id',$bar_id);
		$this->db->where('liquors.is_deleted','no');
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
		$this->db->order_by('liquors_bars.liquor_bar_id','desc');
		$query = $this->db->get();
// 		
		//  echo $this->db->last_query();
		//  die;
		return $query->num_rows();
	}
 

    function getBarGallerycount($bar_id,$keyword)
	{
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
		$this->db->select('*');
		$this->db->from('bar_gallery');
		$this->db->where(array('bar_id'=>$bar_id));
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
	
	
	function getBarPostcardcount($bar_id,$keyword)
	{
		$en='';
		$en1='';
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
		$this->db->select('*');
		$this->db->from('bar_post_card');
		$this->db->join('user_master','user_master.user_id=bar_post_card.user_id');
		$this->db->join('bars','bar_post_card.bar_id=bars.bar_id');
		if($this->session->userdata('user_type')=='bar_owner')
		{
		$this->db->where(array('bar_post_card.bar_id'=>$bar_id,'bar_post_card.status'=>'active','bar_post_card.is_delete'=>'0'));
		}
		else
			{
				$this->db->where(array('bar_post_card.user_id'=>get_authenticateUserID(),'bar_post_card.status'=>'active','bar_post_card.is_delete'=>'0'));
			}
		if($keyword!='' && $keyword!='1V1')
		{
			if($this->session->userdata('user_type')=='bar_owner')
			{
				$en.=" `first_name` like ('%".$keyword."%') OR `last_name` like ('%".$keyword."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$en1.=" `first_name` like ('%".$val."%') OR `last_name` like ('%".$val."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en.substr($en1, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
		}
			}
else
	{
		$this->db->like("bar_title",$keyword);	
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('bar_title',$val);
					}	
				}
			}
		
		}		  
		$this->db->order_by('bar_post_card.postcard_id','desc');
		$query = $this->db->get();
// 		
		 // echo $this->db->last_query();
		 // die;
		return $query->num_rows();
	}
	
	
	
	
	function getBarCommentscount($bar_id,$keyword)
	{
		$en='';
		$en1='';
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
		$this->db->select('*');
		$this->db->from('bar_comment');
		$this->db->join('user_master','user_master.user_id=bar_comment.user_id');
		$this->db->where(array('bar_comment.bar_id'=>$bar_id,'bar_comment.is_deleted'=>'no'));
		if($keyword!='' && $keyword!='1V1')
		{
			$en.=" `first_name` like ('%".$keyword."%') OR `last_name` like ('%".$keyword."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$en1.=" `first_name` like ('%".$val."%') OR `last_name` like ('%".$val."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en.substr($en1, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
		}
			
		}		  
		$this->db->order_by('bar_comment.bar_comment_id','desc');
		$query = $this->db->get();
// 		
		 // echo $this->db->last_query();
		 // die;
		return $query->num_rows();
	}
	
	function getBarMessagescount()
	{
		
		$query = $this->db->query("select * from sss_message where master_message_id=0 && (to_user_id=".get_authenticateUserID()." or  from_user_id=".get_authenticateUserID().") ");
		//$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	function get_message_result($offset, $limit){
		
       
        $query = $this->db->query("select * from sss_message where master_message_id=0 && (to_user_id=".get_authenticateUserID()." or  from_user_id=".get_authenticateUserID().") ORDER BY message_id desc  limit ".$limit." offset ".$offset." ");
		
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		return 0;
	}
	function getBarPostcardDetail($bar_id='',$offset="",$limit="",$keyword='')
	{
		$en ='';
		$en1 ='';
		$this->db->select('*');
		$this->db->from('bar_post_card');
		$this->db->join('user_master','user_master.user_id=bar_post_card.user_id');
		$this->db->join('bars','bar_post_card.bar_id=bars.bar_id');
		//$this->db->where(array('bar_post_card.bar_id'=>$bar_id,'bar_post_card.status'=>'active','bar_post_card.is_delete'=>'0'));
		if($this->session->userdata('user_type')=='bar_owner')
		{
		$this->db->where(array('bar_post_card.bar_id'=>$bar_id,'bar_post_card.status'=>'active','bar_post_card.is_delete'=>'0'));
		}
		else
			{
				$this->db->where(array('bar_post_card.user_id'=>get_authenticateUserID(),'bar_post_card.status'=>'active','bar_post_card.is_delete'=>'0'));
			}
		if($keyword!='' && $keyword!='1V1')
		{
			if($this->session->userdata('user_type')=='bar_owner')
			{
				$en.=" `first_name` like ('%".$keyword."%') OR `last_name` like ('%".$keyword."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$en1.=" `first_name` like ('%".$val."%') OR `last_name` like ('%".$val."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en.substr($en1, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
		}
			}
else
	{
		$this->db->like("bar_title",$keyword);	
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('bar_title',$val);
					}	
				}
			}
		
		}			  
		$this->db->order_by('bar_post_card.postcard_id','desc');
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
	
	function getBarCommentDetail($bar_id='',$offset="",$limit="",$keyword='')
	{
		$en = '';
		$en1 = '';
		$en2 = '';
		$en3 = '';
		$this->db->select('*');
		$this->db->from('bar_comment');
		$this->db->join('user_master','user_master.user_id=bar_comment.user_id');
		$this->db->where(array('bar_comment.bar_id'=>$bar_id,'bar_comment.is_deleted'=>'no'));
		
		
		if($keyword!='' && $keyword!='1V1')
		{
			$en.=" `first_name` like ('%".$keyword."%') OR `last_name` like ('%".$keyword."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$en1.=" `first_name` like ('%".$val."%') OR `last_name` like ('%".$val."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en.substr($en1, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
		}
			
		}		
		
		$this->db->order_by('bar_comment.bar_comment_id','desc');
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
	
	function getBarEvent($bar_id,$limit='')
	{
		
		$this->db->select('*');
		$this->db->from('events');
		$this->db->join("event_time",'event_time.event_id=events.event_id');
		$this->db->where(array('events.bar_id'=>$bar_id,'status'=>'active','is_deleted'=>'no'));
		$this->db->where('eventdate >=',date('Y-m-d'));
		$this->db->order_by('event_time.eventdate','asc');
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
	
	
	
	function getBarEventDetail($bar_id='',$offset="",$limit="",$keyword='')
	{
		
		$this->db->select('*');
		$this->db->from('events');
		$this->db->where(array('events.bar_id'=>$bar_id,'is_deleted'=>'no'));
		if($keyword!='' && $keyword!='1V1')
		{
		$this->db->like("event_title",$keyword);	
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('event_title',$val);
					}	
				}
		}		  
		$this->db->order_by('events.event_id','desc');
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
	
	function getBarBeerDetail($bar_id='',$offset="",$limit="",$keyword='')
	{
		
		$this->db->select('*');
		$this->db->from('beer_bars');
		$this->db->join('beer_directory','beer_directory.beer_id=beer_bars.beer_id','left');
		$this->db->where('beer_bars.bar_id',$bar_id);
		$this->db->where('beer_directory.is_deleted','no');
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
		$this->db->order_by('beer_bars.beer_bar_id','desc');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
		
	}
	
	function getBarCocktailDetail($bar_id='',$offset="",$limit="",$keyword='')
	{
		
		$this->db->select('*');
		$this->db->from('cocktail_bars');
		$this->db->join('cocktail_directory','cocktail_directory.cocktail_id=cocktail_bars.cocktail_id');
		$this->db->where('cocktail_bars.bar_id',$bar_id);
		$this->db->where('cocktail_directory.is_deleted','no');
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
		$this->db->order_by('cocktail_bars.cocktail_bar_id','desc');
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
	
	function getBarLiquorDetail($bar_id='',$offset="",$limit="",$keyword='')
	{
		
		$this->db->select('*');
		$this->db->from('liquors_bars');
		$this->db->join('liquors','liquors.liquor_id=liquors_bars.liquor_id');
		$this->db->where('liquors_bars.bar_id',$bar_id);
		$this->db->where('liquors.is_deleted','no');
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
		$this->db->order_by('liquors_bars.liquor_bar_id','desc');
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
	
	function getCocktailByBarid($utype,$q){
		$this->db->like('cocktail_name',$q);
		$this->db->select('cocktail_id,cocktail_name');
		$this->db->from('cocktail_directory');
			$this->db->where('cocktail_directory.is_deleted','no'); 
		$this->db->where('status','active');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
	}
		return 0;
	}
	
	function getBeerByBarid($utype,$q){
		$this->db->like('beer_name',$q);
		$this->db->select('beer_id,beer_name,is_deleted');
		$this->db->from('beer_directory');
		$this->db->where('beer_directory.is_deleted','no'); 
		$this->db->where('status','active');
		$query = $this->db->get();
		
	
		if ($query->num_rows() > 0) {
			return $query->result_array();
	}
		return 0;
	}
	
	function getBeer()
	{
		$this->db->select('*');
		$this->db->from('beer_directory');
		$this->db->where('is_deleted','no'); 
		$this->db->where('status','active');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
	}
		return 0;
	}
	
	function getCocktail()
	{
		$this->db->select('*');
		$this->db->from('cocktail_directory');
		$this->db->where('is_deleted','no'); 
		$this->db->where('status','active');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
	}
		return 0;
	}
	
	function getLiquor()
	{
		$this->db->select('*');
		$this->db->from('liquors');
		$this->db->where('is_deleted','no'); 
		$this->db->where('status','active');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
	}
		return 0;
	}
	function getBarGalleryDetail($bar_id='',$offset="",$limit="",$keyword='')
	{
		
		$this->db->select('*');
		$this->db->from('bar_gallery');
		$this->db->where(array('bar_id'=>$bar_id));
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
	
	function getAllBarGal($bar_id='')
	{
		
		$this->db->select('*');
		$this->db->from('bar_gallery');
		$this->db->where(array('bar_id'=>$bar_id));
		$this->db->order_by('bar_gallery_id','desc');
		$query = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
		
	}
	function getBarBeer($bar_id,$limit='')
	{
		
		$this->db->select('*');
		$this->db->from('beer_bars');
		$this->db->join('beer_directory','beer_directory.beer_id=beer_bars.beer_id');
		$this->db->where(array('beer_bars.bar_id'=>$bar_id));
		$this->db->where('beer_directory.is_deleted','no');  
		$this->db->order_by('beer_directory.beer_id','desc');
		$this->db->group_by('beer_bar_id');
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
	
	function getBarCocktail($bar_id,$limit='')
	{
		
		$this->db->select('*');
		$this->db->from('cocktail_bars');
		$this->db->join('cocktail_directory','cocktail_directory.cocktail_id=cocktail_bars.cocktail_id');
		$this->db->where(array('cocktail_bars.bar_id'=>$bar_id));
		$this->db->where('cocktail_directory.is_deleted','no');
		$this->db->order_by('cocktail_directory.cocktail_id','desc');
		$this->db->group_by('cocktail_bar_id');
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

     function event_insert($bar_id='')
	{
		
		 $this->load->library('upload');
		 $event_image = '';
		 $name = '';
		 $image_setting = image_setting();
		$res  = getCoordinatesFromAddress_orig($this->input->post('address'),$this->input->post('city'),$this->input->post('state'));

              if(isset($_FILES['event_video']) && $_FILES['event_video']["name"]!='')
		  {
		
			
			$types = explode(".",$_FILES["event_video"]["name"]);
			
			if(isset($types[1]))
			{
				$type = $types[1];
			}
			else {
				$type =  'mp4';
			}
		
		  	  $name = "event_video_".rand(0,100000).".".$type;
		  	  $upload_path = base_path()."upload/event_video/".$name;
			  
			  move_uploaded_file($_FILES["event_video"]["tmp_name"],$upload_path);
			  
			  //$data_insert['event_video']=$name;
		  }	
		  	  if($this->input->post('event_category'))
		{
		$getcat = implode(",", $this->input->post('event_category'));  
		}
		else
		{
			$getcat = '';
		}	
		  $data_insert = array('event_title'=>$this->input->post('event_title'),
		                       'event_desc'=>$this->input->post('event_title'),
							    // 'start_date'=> date('Y-m-d' ,strtotime($this->input->post('start_date'))),
							   // 'end_date' =>  date('Y-m-d' ,strtotime($this->input->post('end_date'))),
							   // 'start_time'=>$this->input->post('start_time'),
							   // 'end_time'=>$this->input->post('end_time'),
							   'address'=>$this->input->post('address'),
							   'city'=>$this->input->post('city'),
							   'state'=>$this->input->post('state'),
							   'event_lat' => $res['lat'],
							   'event_lng' => $res['lng'],
							   'phone'=>$this->input->post('phone'),
							   'zipcode'=>$this->input->post('zipcode'),
							   'venue'=>$this->input->post('venue'),
							   'event_image'=>$event_image,
							   'event_video'=>$name,
							   'event_video_link'=>$this->input->post('event_video_link'),
							   'is_power_boost_event'=>$this->input->post('is_power_boost_event'),
							   'bar_id'=>$bar_id,
							   'status'=>$this->input->post('status'),
							   'is_deleted'=>'no',
							  // 'organizer'=>$this->input->post('organizer'),
							   'admission'=>$this->input->post('admission'),
							   'website' => $this->input->post('website'),
							   // 'event_fb_link' => $this->input->post('event_fb_link'),
							   // 'event_twitter_link' => $this->input->post('event_twitter_link'),
							   // 'event_google_plus_link' => $this->input->post('event_google_plus_link'),
							   // 'event_pinterest_link' => $this->input->post('event_pinterest_link'),
							   'event_upload_type' => $this->input->post('event_upload_type'),
							   'buy_ticket' => $this->input->post('buy_ticket'),
							   'event_category'=>$getcat,
							   'date_added'=>date('Y-m-d H:i:s'));
			
		 					   
		 $this->db->insert('events',$data_insert);		
		 $event_id = mysql_insert_id();
		 
		 
		 $datatick['eventdate']=$this->input->post('eventdate');
		 $datatick['eventstarttime']=$this->input->post('eventstarttime');
		 $datatick['eventendtime']=$this->input->post('eventendtime');
		
		
		 if( isset( $datatick['eventdate'] ) && is_array( $datatick['eventdate'] ) ){
			foreach( $datatick['eventdate'] as $key => $each ){
				
			
				$dataticket=array(
				'eventdate'=> date('Y-m-d' ,strtotime($datatick['eventdate'][$key])),
				'eventstarttime'=>$datatick['eventstarttime'][$key],
				'eventendtime'=>$datatick['eventendtime'][$key],
				'event_id'=>$event_id,
			);
			
		
			$this->db->insert('event_time',$dataticket);
			}
		 }
		 
		$getbarinfo = $this->get_one_bar($bar_id);
		
		$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Event Notification To Enthusiast User'");
		$email_temp=$email_template->row();             
		$email_address_from=$email_temp->from_address;
        $email_address_reply=$email_temp->reply_address;
                
        $email_subject=$email_temp->subject;                
        $email_message=$email_temp->message;
                
		$getusers = getfavusersbybars($bar_id);
		
		if($getusers)
	    {
	    	foreach($getusers as $row)
			{
				$email = $row->email;
		        $email_to =$email;
				$event = "<a href='".base_url()."event/detail/".base64_encode($event_id)."'>". ucwords($this->input->post('event_title')) ."</a>";
				
				
				$username = ucwords($row->first_name)." ".ucwords($row->last_name);
				$barname = ucwords($getbarinfo['bar_title']);
		        $email_message=str_replace('{break}','<br/>',$email_message);
				$email_message=str_replace('{barname}',$barname,$email_message);
				$email_message=str_replace('{eventname}',$event,$email_message);
				$email_message=str_replace('{username}',$username,$email_message);
				$email_subject=str_replace('{barname}',$barname,$email_subject);
		        $str=$email_message;
				if($email_temp->status=='active'){
		        email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
				}
			}
	    }			
       
		 
		 
		 if(isset($_FILES['photo_image']['name']) && count($_FILES['photo_image']['name'])>0 && $this->input->post('event_upload_type')=='image')
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
   
			$config['file_name'] = $rand.'eventgallery';
			
            $config['upload_path'] = base_path().'upload/bar_eventgallery_orig/';
			
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
		   	
			
           resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/bar_eventgallery_thumb_big/'.$picture['file_name'],394,290);
             
			
			$this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/bar_eventgallery_thumb/'.$picture['file_name'],70,70);
           
			
			$this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/bar_eventgallery_thumb_250by150/'.$picture['file_name'],250,150);
           
			
			$this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/bar_eventgallery_thumb_304by201/'.$picture['file_name'],304,201);
           $this->image_lib->clear();
			  
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_225/'.$picture['file_name'],225,225);
			
			 $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_840by720/'.$picture['file_name'],840,720);
			
			 $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_261/'.$picture['file_name'],261,261);
			
			 $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_140/'.$picture['file_name'],140,140);
			
			 $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_200/'.$picture['file_name'],200,200);
			
			 $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_600/'.$picture['file_name'],600,600);
			
			$company_image=$picture['file_name'];
			$pg=array('bar_eventgallery_id'=>$event_id,'event_image_name'=>$company_image);
			$this->db->insert('event_images',$pg);
			
			} 
			}
				
		
		}		   
		  
	}

    function bar_beer_insert($bar_id) {
    	
		$admin_id  = $this->input->post('beer_id');
	
		//$to_id_arr = implode(' ', $this->input->post('beer_id') );
		
		$servicename = "";
		foreach($admin_id as $id)
		{
			
			$servicename .= " ".getbeername($id)." ,";
			$data = array(
				'bar_id' => $bar_id,
		     	'beer_id' =>  $id,
				'date' => date("Y-m-d")
			);
			$this->db->insert('beer_bars',$data);
		}
		
		$getbarinfo = $this->get_one_bar($bar_id);
		$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Beer Notification To Enthusiast User'");
		$email_temp=$email_template->row();             
		$email_address_from=$email_temp->from_address;
        $email_address_reply=$email_temp->reply_address;
                
        $email_subject=$email_temp->subject;                
        $email_message=$email_temp->message;
                
		$getusers = getfavusersbybars($bar_id);
		
		if($getusers)
	    {
	    	foreach($getusers as $row)
			{
				$email = $row->email;
		        $email_to =$email;
			//	$event = "<a href='".base_url()."event/detail/".base64_encode($event_id)."'>". ucwords($this->input->post('event_title')) ."</a>";
				
				
				$username = ucwords($row->first_name)." ".ucwords($row->last_name);
				$barname = ucwords($getbarinfo['bar_title']);
		        $email_message=str_replace('{break}','<br/>',$email_message);
				$email_message=str_replace('{barname}',$barname,$email_message);
				$email_message=str_replace('{beername}',$servicename,$email_message);
				$email_message=str_replace('{username}',$username,$email_message);
				$email_subject=str_replace('{barname}',$barname,$email_subject);
		        $str=$email_message;
				if($email_temp->status=='active'){
		        email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
				}
			}
	    }	
		
		
	} 
	
	function bar_cocktail_insert($bar_id) {
	
		$to_id_arr = $this->input->post('cocktail_id');
		
		$servicename = "";
		foreach($to_id_arr as $id)
		{
			$servicename .= " ".getcocktailname($id)." ,";	
			$data = array(
				'bar_id' => $bar_id,
		     	'cocktail_id' =>  $id,
				'date' => date("Y-m-d")
			);
			$this->db->insert('cocktail_bars',$data);
		}
		
		$getbarinfo = $this->get_one_bar($bar_id);
		$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Cocktail Notification To Enthusiast User'");
		$email_temp=$email_template->row();             
		$email_address_from=$email_temp->from_address;
        $email_address_reply=$email_temp->reply_address;
                
        $email_subject=$email_temp->subject;                
        $email_message=$email_temp->message;
                
		$getusers = getfavusersbybars($bar_id);
		
		if($getusers)
	    {
	    	foreach($getusers as $row)
			{
				$email = $row->email;
		        $email_to =$email;
			//	$event = "<a href='".base_url()."event/detail/".base64_encode($event_id)."'>". ucwords($this->input->post('event_title')) ."</a>";
				
				
				$username = ucwords($row->first_name)." ".ucwords($row->last_name);
				$barname = ucwords($getbarinfo['bar_title']);
		        $email_message=str_replace('{break}','<br/>',$email_message);
				$email_message=str_replace('{barname}',$barname,$email_message);
				$email_message=str_replace('{cocktailname}',$servicename,$email_message);
				$email_message=str_replace('{username}',$username,$email_message);
				$email_subject=str_replace('{barname}',$barname,$email_subject);
		        $str=$email_message;
				if($email_temp->status=='active'){
		        email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
				}
			}
	    }	
	} 
	
	function bar_liquor_insert($bar_id) {
	
		$to_id_arr = $this->input->post('liquor_id');
		
		$servicename = "";
		foreach($to_id_arr as $id)
		{
			$servicename .= " ".getliquorname($id)." ,";		
			$data = array(
				'bar_id' => $bar_id,
		     	'liquor_id' =>  $id,
				'date' => date("Y-m-d")
			);
			$this->db->insert('liquors_bars',$data);
		}
		
		$getbarinfo = $this->get_one_bar($bar_id);
		$email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Liquor Notification To Enthusiast User'");
		$email_temp=$email_template->row();             
		$email_address_from=$email_temp->from_address;
        $email_address_reply=$email_temp->reply_address;
                
        $email_subject=$email_temp->subject;                
        $email_message=$email_temp->message;
                
		$getusers = getfavusersbybars($bar_id);
		
		if($getusers)
	    {
	    	foreach($getusers as $row)
			{
				$email = $row->email;
		        $email_to =$email;
			//	$event = "<a href='".base_url()."event/detail/".base64_encode($event_id)."'>". ucwords($this->input->post('event_title')) ."</a>";
				
				
				$username = ucwords($row->first_name)." ".ucwords($row->last_name);
				$barname = ucwords($getbarinfo['bar_title']);
		        $email_message=str_replace('{break}','<br/>',$email_message);
				$email_message=str_replace('{barname}',$barname,$email_message);
				$email_message=str_replace('{liquorname}',$servicename,$email_message);
				$email_message=str_replace('{username}',$username,$email_message);
				$email_subject=str_replace('{barname}',$barname,$email_subject);
		        $str=$email_message;
				if($email_temp->status=='active'){
		        email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
				}
			}
	    }	
	} 
	
	function get_one_cocktail_by_name($name)
	{
		
		$query = $this->db->get_where('cocktail_directory',array('cocktail_name'=>$name));
		return $query->row_array();
	}	
	
	function get_one_beer_by_name($name)
	{
		
		$query = $this->db->get_where('beer_directory',array('beer_name'=>$name));
		return $query->row_array();
	}	

     function getOneEvent()
	 {
	 	  $this->db->select('*');
		  $this->db->from('events');
		  $this->db->where('event_id',$this->input->post('id'));
		  $query = $this->db->get();
		  return $query->row(); 
	 }

	function getOneGallery()
	 {
	 	  $this->db->select('*');
		  $this->db->from('bar_gallery');
		  $this->db->where('bar_gallery_id',$this->input->post('id'));
		  $query = $this->db->get();
		  return $query->row(); 
	 }
	 
	 

     function getGalleryImages()
	 {
	 	 $this->db->select('*');
		 $this->db->from('bar_images');
		 $this->db->where('bar_gallery_id',$this->input->post('id'));
		 $query = $this->db->get();
		 if($query->num_rows()>0)
		 {
		 	return $query->result();
		 }
		 return '';
	 } 
	 
	 function getEventGalleryImages()
	 {
	 	 $this->db->select('*');
		 $this->db->from('event_images');
		 $this->db->where('bar_eventgallery_id',$this->input->post('id'));
		 $query = $this->db->get();
		 if($query->num_rows()>0)
		 {
		 	return $query->result();
		 }
		 return '';
	 } 
	 
	 function getEventtime()
	 {
	 	 $this->db->select('*');
		 $this->db->from('event_time');
		 $this->db->where('event_id',$this->input->post('id'));
		 $query = $this->db->get();
		 if($query->num_rows()>0)
		 {
		 	return $query->result();
		 }
		 return '';
	 } 
     function event_update($bar_id='')
	{
		$res  = getCoordinatesFromAddress_orig($this->input->post('address'),$this->input->post('city'),$this->input->post('state'));
		$this->load->library('upload');
		 $event_image = '';
		 $product_image = '';
		 $name = '';
		$image_setting = image_setting();
		

           // if(isset($_FILES['event_video']) && $_FILES['event_video']["name"]!='')
		  // {
// 		
// 			
			// $types = explode(".",$_FILES["event_video"]["name"]);
// 			
			// if(isset($types[1]))
			// {
				// $type = $types[1];
			// }
			// else {
				// $type =  'mp4';
			// }
// 		
		  	  // $name = "event_video_".rand(0,100000).".".$type;
		  	  // $upload_path = base_path()."upload/event_video/".$name;
// 			  
			  // move_uploaded_file($_FILES["event_video"]["tmp_name"],$upload_path);
// 			  
			  // //$data_insert['event_video']=$name;
		  // }	
		   if($this->input->post('event_category'))
		{
		$getcat = implode(",", $this->input->post('event_category'));  
		}
		else
		{
			$getcat = '';
		}	
		  $data_insert = array('event_title'=>$this->input->post('event_title'),
		                       'event_desc'=>$this->input->post('event_desc'),
							   // 'start_date'=>date('Y-m-d'),strtotime($this->input->post('start_date')),
							   // 'end_date' => date('Y-m-d'),strtotime($this->input->post('end_date')),
							    // 'start_time'=>$this->input->post('start_time'),
							     // 'start_date'=> date('Y-m-d' ,strtotime($this->input->post('start_date'))),
							   // 'end_date' =>  date('Y-m-d' ,strtotime($this->input->post('end_date'))),
							   // 'end_time'=>$this->input->post('end_time'),
							   'address'=>$this->input->post('address'),
							   'venue'=>$this->input->post('venue'),
							   'city'=>$this->input->post('city'),
							   'state'=>$this->input->post('state'),
							   'phone'=>$this->input->post('phone'),
							    'event_lat' => $res['lat'],
							   'event_lng' => $res['lng'],
							   'zipcode'=>$this->input->post('zipcode'),
							   'event_image'=>$event_image,
							   'event_video'=>$name,
							   'event_video_link'=>$this->input->post('event_video_link'),
							   'is_power_boost_event'=>$this->input->post('is_power_boost_event'),
							   'bar_id'=>$bar_id,
							   'status'=>$this->input->post('status'),
							   'is_deleted'=>'no',
							    //'organizer'=>$this->input->post('organizer'),
							   'admission'=>$this->input->post('admission'),
							   'website' => $this->input->post('website'),
							   // 'event_fb_link' => $this->input->post('event_fb_link'),
							   // 'event_twitter_link' => $this->input->post('event_twitter_link'),
							   // 'event_google_plus_link' => $this->input->post('event_google_plus_link'),
							   // 'event_pinterest_link' => $this->input->post('event_pinterest_link'),
							   'event_upload_type' => $this->input->post('event_upload_type'),
							   'buy_ticket' => $this->input->post('buy_ticket'),
							   'event_category'=>$getcat,
							   'date_added'=>date('Y-m-d H:i:s'));
			
			
		 					   
		$this->db->where("event_id",$this->input->post('event_id'));
		$this->db->update('events',$data_insert);	
		$img_id = $this->input->post('image_id');
		$preImg=$this->input->post('pre_img');
			/***********INsert Gallery************/
// 			
		 // echo $this->input->post('event_upload_type');
		// // die;
// 		
		// print_r($_FILES);
		// die;
		
		if(isset($_FILES['photo_image']['name']) && count($_FILES['photo_image']['name'])>0 && $this->input->post('event_upload_type')=='image')
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
   
			$config['file_name'] = $rand.'eventgallery';
			
            $config['upload_path'] = base_path().'upload/bar_eventgallery_orig/';
			
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
				
			
		   
            
               resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/bar_eventgallery_thumb_big/'.$picture['file_name'],394,290);
             
			
			$this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/bar_eventgallery_thumb/'.$picture['file_name'],70,70);
           
				$this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/bar_eventgallery_thumb_250by150/'.$picture['file_name'],250,150);
           
			
			$this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/bar_eventgallery_thumb_304by201/'.$picture['file_name'],304,201);
           
			 $this->image_lib->clear();
			  
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_225/'.$picture['file_name'],225,225);
			
			 $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_840by720/'.$picture['file_name'],840,720);
			
			 $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_261/'.$picture['file_name'],261,261);
			
			 $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_140/'.$picture['file_name'],140,140);
			
			 $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_200/'.$picture['file_name'],200,200);
			
			 $this->image_lib->clear();
		   
		   resize(base_path().'upload/bar_eventgallery_orig/'.$picture['file_name'],base_path().'upload/event_600/'.$picture['file_name'],600,600);
			
			
			$product_image=$picture['file_name'];
				
				
				if(isset($preImg[$key]) && $preImg[$key]!='')
				{
					if(file_exists(base_path().'upload/event_200/'.$preImg[$key]))
					{
						unlink(base_path().'upload/event_200/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/event_600/'.$preImg[$key]))
					{
						unlink(base_path().'upload/event_600/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/event_140/'.$preImg[$key]))
					{
						unlink(base_path().'upload/event_140/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/event_261/'.$preImg[$key]))
					{
						unlink(base_path().'upload/event_261/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/event_840by720/'.$preImg[$key]))
					{
						unlink(base_path().'upload/event_840by720/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/bar_eventgallery_orig/'.$preImg[$key]))
					{
						unlink(base_path().'upload/bar_eventgallery_orig/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/event_225/'.$preImg[$key]))
					{
						unlink(base_path().'upload/event_225/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/bar_eventgallery_thumb/'.$preImg[$key]))
					{
						unlink(base_path().'upload/bar_eventgallery_thumb/'.$preImg[$key]);
					}
					
					if(file_exists(base_path().'upload/bar_eventgallery_thumb_big/'.$preImg[$key]))
					{
						unlink(base_path().'upload/bar_eventgallery_thumb_big/'.$preImg[$key]);
					}
if(file_exists(base_path().'upload/bar_eventgallery_thumb_250by150/'.$preImg[$key]))
					{
						unlink(base_path().'upload/bar_eventgallery_thumb_250by150/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/bar_eventgallery_thumb_304by201/'.$preImg[$key]))
					{
						unlink(base_path().'upload/bar_eventgallery_thumb_304by201/'.$preImg[$key]);
					}
				}
				
				 }
				 else
				 {
// 				
				  $product_image = $preImg[$key];
				}
// 				
// 				
               
				if($product_image!=''){
					
				$pg = array('bar_eventgallery_id'=>$this->input->post('event_id'),'event_image_name'=>$product_image);
			
				//echo $img_id[$key];
				if($product_image!=''){
				if(isset($img_id[$key]) && $img_id[$key]>0){
					$this->db->where('event_image_id',$img_id[$key]);
					$this->db->update('event_images',$pg);
				}else{
					
					$this->db->insert('event_images',$pg);
				}
				}
				}
				
			} 
				
				}	   

		 $datatick['eventdate']=$this->input->post('eventdate');
		 $datatick['eventstarttime']=$this->input->post('eventstarttime');
		 $datatick['eventendtime']=$this->input->post('eventendtime');
		 
		$datatick['image_id1']=$this->input->post('image_id1');
		
		
		//echo 
		 if( isset( $datatick['eventdate'] ) && is_array( $datatick['eventdate'] ) ){
			foreach( $datatick['eventdate'] as $key => $each ){
				
				
				if(isset($datatick['image_id1'][$key])){
					
					
							$dataticket=array(
				'eventdate'=> date('Y-m-d' ,strtotime($datatick['eventdate'][$key])),
				'eventstarttime'=>$datatick['eventstarttime'][$key],
				'eventendtime'=>$datatick['eventendtime'][$key],
			);
			
				
					$this->db->where('sss_event_time_id',$datatick['image_id1'][$key]);
					$this->db->update('sss_event_time',$dataticket);
				}else{
					
							$dataticket=array(
				'eventdate'=> date('Y-m-d' ,strtotime($datatick['eventdate'][$key])),
				'eventstarttime'=>$datatick['eventstarttime'][$key],
				'eventendtime'=>$datatick['eventendtime'][$key],
				'event_id' => $this->input->post('event_id'),
			);
					$this->db->insert('sss_event_time',$dataticket);
				}
			}
		 }
		  
	}


    function bar_gallery_insert($bar_id='')
	{
		$this->load->library('upload');
		$data["title"] = $this->input->post('title');
		$data["description"] = $this->input->post('description');		
		$data["status"] = $this->input->post('status');
		$data["gallery"] = $this->input->post('gallery');
		$data["bar_id"] = $bar_id;
		$data["date_added"] = date("Y-m-d h:i:s");

		//date($site_setting->date_format,strtotime($rs->product_date));
        
		$this->db->insert('bar_gallery',$data);	
		$gallery_id = mysql_insert_id();
		
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
		   
			
			
			  resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bargallery_261/'.$picture['file_name'],261,261);
             
			  $this->image_lib->clear();
		   	
			
			
			  resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bargallery_840by720/'.$picture['file_name'],840,720);
             
			 $this->image_lib->clear();
		   	
			
			
			  resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bargallery_100/'.$picture['file_name'],100,100);
             
			 $this->image_lib->clear();
		   	
			
			
			  resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bargallery_300/'.$picture['file_name'],300,300);
            
			 $this->image_lib->clear();
		   	
			
			
			  resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bargallery_600/'.$picture['file_name'],600,600);
             
			  $this->image_lib->clear();
		   	
			
			
			  resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bargallery_200/'.$picture['file_name'],200,200);
              
			$company_image=$picture['file_name'];
			$pg=array('bar_gallery_id'=>$gallery_id,'bar_image_name'=>$company_image);
			$this->db->insert('bar_images',$pg);
			
			} 
			}
				
		
		}
	}

     function bar_gallery_update($bar_id)
	 {
	 	
		$this->load->library('upload');
		$data["title"] = $this->input->post('title');
		$data["description"] = $this->input->post('description');		
		$data["status"] = $this->input->post('status');
		$data["gallery"] = $this->input->post('gallery');
		$data["bar_id"] = $bar_id;
		
		$this->db->where('bar_gallery_id',$this->input->post('bar_gallery_id'));
		$this->db->update('bar_gallery',$data);
		$product_image = '';
		$img_id = $this->input->post('image_id');
		$preImg=$this->input->post('pre_img');
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
		   
			
			
			  resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bargallery_261/'.$picture['file_name'],261,261);
             
			  $this->image_lib->clear();
		   	
			
			
			  resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bargallery_840by720/'.$picture['file_name'],840,720);
             $this->image_lib->clear();
		   	
			
			
			  resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bargallery_100/'.$picture['file_name'],100,100);
             
			 $this->image_lib->clear();
		   	
			
			
			  resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bargallery_300/'.$picture['file_name'],300,300);
             
              $this->image_lib->clear();
		   	
			
			
			  resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bargallery_600/'.$picture['file_name'],600,600);
             
			  $this->image_lib->clear();
		   	
			
			
			  resize(base_path().'upload/bar_gallery_orig/'.$picture['file_name'],base_path().'upload/bargallery_200/'.$picture['file_name'],200,200);
             
			
			$product_image=$picture['file_name'];
				
				
				if(isset($preImg[$key]) && $preImg[$key]!='')
				{
					if(file_exists(base_path().'upload/bargallery_200/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bargallery_200/'.$preImg[$key]);
							}
								if(file_exists(base_path().'upload/bargallery_600/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bargallery_600/'.$preImg[$key]);
							}
					if(file_exists(base_path().'upload/bargallery_300/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bargallery_300/'.$preImg[$key]);
							}
								if(file_exists(base_path().'upload/bargallery_100/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bargallery_100/'.$preImg[$key]);
							}
					if(file_exists(base_path().'upload/bar_gallery_orig/'.$preImg[$key]))
					{
						unlink(base_path().'upload/bar_gallery_orig/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/bar_gallery_thumb/'.$preImg[$key]))
					{
						unlink(base_path().'upload/bar_gallery_thumb/'.$preImg[$key]);
					}
				if(file_exists(base_path().'upload/bargallery_840by720/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bargallery_840by720/'.$preImg[$key]);
							}
							if(file_exists(base_path().'upload/bargallery_261/'.$preImg[$key]))
							{
								unlink(base_path().'upload/bargallery_261/'.$preImg[$key]);
							}
					
					if(file_exists(base_path().'upload/bar_gallery_thumb_big/'.$preImg[$key]))
					{
						unlink(base_path().'upload/bar_gallery_thumb_big/'.$preImg[$key]);
					}
				}
				
				}
				else
				{
					$product_image = $preImg[$key];
				}
				
				if($product_image!=''){
				$pg=array('bar_gallery_id'=>$this->input->post('bar_gallery_id'),'bar_image_name'=>$product_image);
				if(isset($img_id[$key]) && $img_id[$key]>0){
					$this->db->where('bar_image_id',$img_id[$key]);
					$this->db->update('bar_images',$pg);
				}else{
					$this->db->insert('bar_images',$pg);
				}
				}
				
			} 
				
				}
	 }

     function getOneImageGallery($id)
	{
		$query = $this->db->get_where('bar_images',array('bar_image_id'=>$id));
		return $query->row();
	}
	
	 function getOneEventImageGallery($id)
	{
		$query = $this->db->get_where('event_images',array('event_image_id'=>$id));
		return $query->row();
	}
	
	 function getOneEventTime($id)
	{
		$query = $this->db->get_where('event_time',array('sss_event_time_id'=>$id));
		return $query->row();
	}
	
	 function getOneProductImageGallery($id)
	{
		$query = $this->db->get_where('product_images',array('product_image_id'=>$id));
		return $query->row();
	}
	function get_one_message($id=0) {
		
		$query = $this->db->get_where('message',array('message_id'=>$id));
		
		return $query->row_array();
	
	}

	 function get_message_conversation($id)
	{
		$this->db->select('message.*');
		$this->db->from('message');
		$this->db->where('master_message_id ',$id);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		return 0;
		
	}
	
	function bar_update()
	{
		
		 $getlat = getCoordinatesFromAddress($this->input->post('address'),$this->input->post('city'),$this->input->post('state'));
		
		$user_image = '';
		 $name = '';
		$image_setting = image_setting();
		 if(isset($_FILES['user_image']) && $_FILES['user_image']["name"]!='')
         {
         	
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['user_image']['name'];
             $_FILES['userfile']['type']     =   $_FILES['user_image']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['user_image']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['user_image']['error'];
             $_FILES['userfile']['size']     =   $_FILES['user_image']['size'];
   
			$config['file_name'] = 'user'.$rand;
			
            $config['upload_path'] = base_path().'upload/user_orig/';
			
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			
			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   
              $this->image_lib->clear();
		   	
			
					$gd_var='gd2';
				
				
		   if ($_FILES["user_image"]["type"]!= "image/png" and $_FILES["user_image"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["user_image"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["user_image"]["type"] != "image/jpeg" and $_FILES["user_image"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 resize(base_path().'upload/user_orig/'.$picture['file_name'],base_path().'upload/user_thumb/'.$picture['file_name'],120,120);
			
			//echo $error;
			//die;
			$user_image =$picture['file_name'];
			
		
			if($this->input->post('prev_user_image')!='')
				{
					if(file_exists(base_path().'upload/user_thumb/'.$this->input->post('prev_user_image')))
					{
						$link=base_path().'upload/user_thumb/'.$this->input->post('prev_user_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/user_orig/'.$this->input->post('prev_user_image')))
					{
						$link2=base_path().'upload/user_orig/'.$this->input->post('prev_user_image');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('prev_user_image')!='')
				{
					$user_image=$this->input->post('prev_user_image');
				}
			}

           
		  
		$data_insert['first_name'] = $this->input->post('first_name') ;
		$data_insert['last_name'] = $this->input->post('last_name') ;
		$data_insert['email'] = $this->input->post('email');
		$data_insert['address'] = $this->input->post('address');
		$data_insert['profile_image'] = $user_image;
		$this->db->where('user_id',get_authenticateUserID());
		$this->db->update('user_master',$data_insert);
		
		$slug=getBarSlug($this->input->post('bar_title'),$this->input->post('b_id'));
			if($this->input->post('bar_category'))
		{		$getcat = implode(",", $this->input->post('bar_category'));
		}
			else
			{
				$getcat ='';
			}	  
		$data_insert_new['bar_title'] = $this->input->post('bar_title') ;
		//$data_insert_new['owner_name'] = $this->input->post('first_name')." ".$this->input->post('last_name');
		
		
		$data_insert_new['bar_first_name'] = $this->input->post('first_name') ;
		$data_insert_new['bar_last_name'] = $this->input->post('last_name') ;
		$data_insert_new['email'] = $this->input->post('email');
			$data_insert_new["bar_category"] =$getcat;
		$data_insert_new['owner_id'] = get_authenticateUserID();
		$data_insert_new['address'] =$this->input->post('address');
		$data_insert_new['bar_video_link'] =$this->input->post('bar_video_link');
		$data_insert_new['bar_desc'] = $this->input->post('desc');
		$data_insert_new['city'] = $this->input->post('city');
		$data_insert_new['phone'] = $this->input->post('phone');
		$data_insert_new['state'] = $this->input->post('state');
		$data_insert_new['zipcode'] = $this->input->post('zip');
		$data_insert_new['lat'] = $getlat['lat'];
		$data_insert_new['lang'] = $getlat['lng'];
		
		//if($this->input->post('cash_p')!='')
		//{
			$data_insert_new["cash_p"] = $this->input->post('cash_p');
		//}
		//if($this->input->post('master_p')!='')
		//{
		$data_insert_new["master_p"] = $this->input->post('master_p');
		//}
		//if($this->input->post('american_p')!='')
		//{
		$data_insert_new["american_p"] = $this->input->post('american_p');
		//}
		//if($this->input->post('visa_p')!='')
		//{
		$data_insert_new["visa_p"] = $this->input->post('visa_p');
		//}
		//if($this->input->post('paypal_p')!='')
		//{
		$data_insert_new["paypal_p"] = $this->input->post('paypal_p');
		//}
		//if($this->input->post('bitcoin_p')!='')
		//{
		$data_insert_new["bitcoin_p"] = $this->input->post('bitcoin_p');
		//}
		//if($this->input->post('apple_p')!='')
		//{
		$data_insert_new["apple_p"] = $this->input->post('apple_p');
		//}
		$data_insert_new['website'] = $this->input->post('website');
		$data_insert_new['bar_meta_description'] = $this->input->post('bar_meta_description');
		$data_insert_new['bar_meta_keyword'] = $this->input->post('bar_meta_keyword');
		$data_insert_new['serve_as'] = $this->input->post('serve_as');
		$data_insert_new['bar_meta_title'] = $this->input->post('bar_meta_title');
		$data_insert_new['bar_slug'] = $slug;
                
                $data_insert_new['facebook_link'] = $this->input->post('facebook_link');                
                $data_insert_new['twitter_link'] = $this->input->post('twitter_link');
                $data_insert_new['instagram_link'] = $this->input->post('instagram_link');
		
		$this->db->where('bar_id',$this->input->post('b_id'));
		$this->db->update('bars',$data_insert_new);
		
		
		 if(isset($_POST["days_id"]))
		 {
		 	$this->db->delete("bar_hours",array("bar_id"=>$this->input->post('b_id')));
			
		 	 for($i=0 ; $i<count($_POST["days_id"]);$i++)
			 {
			 	$close = 0;
			 	if(isset($_POST["closed_".$_POST["days_id"][$i].""]))
				{
					$close = $_POST["closed_".$_POST["days_id"][$i].""];
				}
				$from_time = NULL;	
	
				if($_POST["from_".$_POST["days_id"][$i].""] != "")
				{
					
					$from_time = date("H:i", strtotime($_POST["from_".$_POST["days_id"][$i].""]));
				}
				
				$to_time = NULL;
				if($_POST["to_".$_POST["days_id"][$i].""] != "")
				{//$to_time = $_POST["to"][$i];
					$to_time = date("H:i", strtotime($_POST["to_".$_POST["days_id"][$i].""]));
				}
				
				
				if($to_time != "" && $from_time != "")
				{
					$close = 0;
				}
			 	  $ava_arr = array("bar_id"=>$this->input->post('b_id'),
				                   "days_id" => $_POST["days_id"][$i],
				                   "start_from"=>$from_time,
								   "start_to"=>$to_time,
								   "is_closed"=>$close,
								   "date_added"=>date("Y-m-d H:i:s")
							);
						
					if($to_time == "") {unset($ava_arr["to_time"]);}	
					if($from_time == "") {unset($ava_arr["from_time"]);}	
						   
						   
					//array_push($main_update_arr,$ava_arr);	
					$this->db->insert("bar_hours",$ava_arr);   
			 }
		 }
		
		
	}
	
	function bar_title_unique($str)
	{
		if($this->input->post('b_id'))
		{
			$query = $this->db->get_where('bars',array('bar_id'=>$this->input->post('b_id')));
			
			$res = $query->row_array();
			$email = $res['bar_title'];
			
			$query = $this->db->query("select bar_title from ".$this->db->dbprefix('bars')." where  address='".addslashes($this->input->post('address'))."' and  bar_title = '".addslashes($str)."' and bar_id !='".$this->input->post('b_id')."'");
		}else{
			$query = $this->db->query("select bar_title from ".$this->db->dbprefix('bars')." where  address='".addslashes($this->input->post('address'))."' and  bar_title = '".addslashes($str)."'");
		}
		
		
	
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	function bar_title_unique_suggest($str)
	{
		if($this->input->post('b_id'))
		{
			$query = $this->db->get_where('bars',array('bar_id'=>$this->input->post('b_id')));
			
			$res = $query->row_array();
			$email = $res['bar_title'];
			
			$query = $this->db->query("select bar_title from ".$this->db->dbprefix('bars')." where  address='".addslashes($this->input->post('address'))."' and  bar_title = '".addslashes($str)."' and bar_id !='".$this->input->post('b_id')."'");
		}else{
			$query = $this->db->query("select bar_title from ".$this->db->dbprefix('bars')." where  address='".addslashes($this->input->post('address'))."' and  bar_title = '".addslashes($str)."'");
		}
		
		
	
		if($query->num_rows()>0){
			
			return FALSE;
		}else{
			$query1 = $this->db->query("select bar_name from ".$this->db->dbprefix('suggest_bars')." where  address='".addslashes($this->input->post('address'))."' and  bar_name = '".addslashes($str)."'");
			
			if($query1->num_rows()>0){
			
			return FALSE;
			}
			return TRUE;
		}
	}

	function getBarBeerNew($bar_id,$offset='',$limit='')
	{
		
		$this->db->select('*');
		$this->db->from('beer_bars');
		$this->db->join('beer_directory','beer_directory.beer_id=beer_bars.beer_id');
		$this->db->where(array('beer_bars.bar_id'=>$bar_id));
		$this->db->where('beer_directory.is_deleted','no');  
		$this->db->order_by('beer_directory.beer_id','desc');
		$this->db->group_by('beer_bar_id');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}
	
	function getBarCocktailNew($bar_id,$offset='',$limit='')
	{
		
		$this->db->select('*');
		$this->db->from('cocktail_bars');
		$this->db->join('cocktail_directory','cocktail_directory.cocktail_id=cocktail_bars.cocktail_id');
		$this->db->where(array('cocktail_bars.bar_id'=>$bar_id));
		$this->db->where('cocktail_directory.is_deleted','no');  
		$this->db->order_by('cocktail_directory.cocktail_id','desc');
		$this->db->group_by('cocktail_bar_id');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}

	function getBarLiquorNew($bar_id,$offset='',$limit='')
	{
		
		$this->db->select('*');
		$this->db->from('liquors_bars');
		$this->db->join('liquors','liquors.liquor_id=liquors_bars.liquor_id');
		$this->db->where(array('liquors_bars.bar_id'=>$bar_id));
		$this->db->where('liquors.is_deleted','no');  
		$this->db->order_by('liquors.liquor_id','desc');
		$this->db->group_by('liquor_bar_id');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}
	
	
	function getBarEventGallery()
	{
		
		$this->db->select('*');
		$this->db->from('events');
		$this->db->where(array('status'=>'active','is_deleted'=>'no'));
		$this->db->order_by('events.event_id','desc');
		$this->db->limit(16);
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}
	
	function getBarPostcards()
	{
		$this->db->select('*');
		$this->db->from('bar_gallery');
		$this->db->where('status','active');
		$this->db->where('gallery','postcard');
		$this->db->order_by('bar_gallery_id','desc');
		$this->db->limit(16);
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}
	
	function insert_suggest_bar()
	{    $keys = parse_url($this->input->post('url')); // parse the url
    	 $path = explode("/", $keys['path']); // splitting the path
    	 $last = end($path);
		 
		$getlat = getCoordinatesFromAddress($this->input->post('address'),$this->input->post('city'),$this->input->post('state'));
		$data_insert1["bar_name"] = $this->input->post('bar_name');
		$data_insert1["address"] = $this->input->post('address');
		$data_insert1["state"] = $this->input->post('state');
		$data_insert1["city"] = $this->input->post('city');
                $data_insert1["lat"] = $getlat['lat'];
		$data_insert1["lang"] = $getlat['lng'];
		$data_insert1["phone_number"] = $this->input->post('phone_number');
		$data_insert1["zip_code"] = $this->input->post('zip_code');
		$data_insert1["description"] = $this->input->post('description');
		$data_insert1["sugget_by_user"] = get_authenticateUserID();
		$data_insert1["ip"] = $_SERVER['REMOTE_ADDR'];
		$data_insert1["date"] =date("Y-m-d");
		
		if($last=='barcriteria')
		{
			if($this->session->userdata('fchk')==1)
			{
				$data_insert1["count"] =  $this->session->userdata('count');
			}
			else
			{
				$data_insert1["count"] =  0;
			}
			
		}
		else
		{
			$data_insert1["count"] = 0;
		}	
	   
		$this->db->insert("suggest_bars",$data_insert1);
	}
	
	function getdictionarycount($alpha ='')
	{
		$this->db->select('*');
		$this->db->from('dictionary');
		$this->db->where('status','active');
		if($alpha != "" && $alpha != "no")
		{
		   $this->db->like("dictionary_title",chr(base64_decode($alpha)),"after");
		}
		
		$this->db->order_by('dictionary_title','ASC');
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->num_rows();
		}
		return '';
	}
	
	function getndictionaryresult($offset,$limit,$alpha ='')
	{
		$this->db->select('*');
		$this->db->from('dictionary');
		$this->db->where('status','active');
		if($alpha != "" && $alpha != "no")
		{
		   $this->db->like("dictionary_title",chr(base64_decode($alpha)),"after");
		}
		$this->db->order_by('dictionary_title','ASC');
		//$this->db->order_by('dictionary_id','ASC');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		
		
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return '';
	}
	
	function latestdictionary($limit)
	{
		$this->db->select('*');
		$this->db->from('dictionary');
		$this->db->where('status','active');
		$this->db->order_by('dictionary_id','desc');
		$this->db->limit($limit);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return '';
	}
	
	function message_send($bar_id) {
			$data = array(
				'to_user_id' => 1,
		     	'from_user_id' =>  get_authenticateUserID(),
				'to_user_type' => 'admin',
				'from_user_type' => 'user',
				'subject' => $this->input->post('subject'),
				'description' => $this->input->post('description'),
				'date_added'=>date('Y-m-d H:i:s')
			);
			$this->db->insert('message',$data);
	}
	
	function beer_unique($str)
	{
		
		$query = $this->db->query("select beer_name from ".$this->db->dbprefix('beer_directory')." where beer_name = '$str'");
		if($query->num_rows()>0){
			
			return FALSE;
		}else{
			
			return TRUE;
		}
	} 
	
	function suggestbeer_insert()
	{
		 $slug=getBeerSlug($this->input->post('beer_name'));	
		$beer_image = '';
		$image_setting = image_setting();
		 if(isset($_FILES['beer_image']) && $_FILES['beer_image']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['beer_image']['name'];
             $_FILES['userfile']['type']     =   $_FILES['beer_image']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['beer_image']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['beer_image']['error'];
             $_FILES['userfile']['size']     =   $_FILES['beer_image']['size'];
   
			$config['file_name'] = 'bar_logo'.$rand;
			
            $config['upload_path'] = base_path().'upload/beer_orig/';
			
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			
			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   
              $this->image_lib->clear();
		   	
			
					$gd_var='gd2';
				
				
		   if ($_FILES["beer_image"]["type"]!= "image/png" and $_FILES["beer_image"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["beer_image"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["beer_image"]["type"] != "image/jpeg" and $_FILES["beer_image"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_thumb/'.$picture['file_name'],215,247);
			 
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_list/'.$picture['file_name'],120,120);
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_thumb_70by70/'.$picture['file_name'],70,70);
			
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_225/'.$picture['file_name'],225,225);
			
			
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_291/'.$picture['file_name'],291,291);
			
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_200/'.$picture['file_name'],200,200);
			
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_240/'.$picture['file_name'],240,240);
			
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_140/'.$picture['file_name'],140,140);
			
			$this->image_lib->clear();
			resize(base_path().'upload/beer_orig/'.$picture['file_name'],base_path().'upload/beer_312/'.$picture['file_name'],312,312);
			
			$beer_image =$picture['file_name'];
			} 
			
			$data = array(
				'beer_name' => $this->input->post('beer_name'),
				'beer_desc' => $this->input->post('beer_desc'),
				'beer_type' => $this->input->post('beer_type'),
				'beer_country' => $this->input->post('beer_country'),
				'beer_state' => $this->input->post('beer_state'),
				'abv' => $this->input->post('abv'),
				'beer_image' => $beer_image,
				'producer' => $this->input->post('producer'),
				'status' => 'pending',
				'is_deleted' => 'no',
				'beer_slug' => $slug,
				'date_added' => date('Y-m-d H:i:s'),
				'city_produced' => $this->input->post('city_produced'),
				'beer_website' => $this->input->post('beer_website'),
				// 'beer_meta_title' => $this->input->post('beer_meta_title'),
				// 'beer_meta_keyword' => $this->input->post('beer_meta_keyword'),
				// 'beer_meta_description' => $this->input->post('beer_meta_description'),
			);
			
			$this->db->insert('beer_directory',$data);
			
			$news_id = mysql_insert_id();
		$inar = array('cat_id'=>$news_id,
		              'category'=>'beer',
					  'date'=>date('Y-m-d H:i:s'));
		$this->db->insert('sitemap', $inar);
	}

    function cocktail_unique($str)
	{
		$query = $this->db->query("select cocktail_name from ".$this->db->dbprefix('cocktail_directory')." where cocktail_name = '$str'");
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	function liquor_unique($str)
	{
		$query = $this->db->query("select liquor_title from ".$this->db->dbprefix('liquors')." where liquor_title = '$str'");
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	function suggestcocktail_insert()
	{
		
		$beer_image = '';
		$image_setting = image_setting();
		
		 if(isset($_FILES['beer_image']) && $_FILES['beer_image']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['beer_image']['name'];
             $_FILES['userfile']['type']     =   $_FILES['beer_image']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['beer_image']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['beer_image']['error'];
             $_FILES['userfile']['size']     =   $_FILES['beer_image']['size'];
   
			$config['file_name'] = 'bar_logo'.$rand;
			
            $config['upload_path'] = base_path().'upload/cocktail_orig/';
			
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			
			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   
              $this->image_lib->clear();
		   	
			
					$gd_var='gd2';
				
				
		   if ($_FILES["beer_image"]["type"]!= "image/png" and $_FILES["beer_image"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["beer_image"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["beer_image"]["type"] != "image/jpeg" and $_FILES["beer_image"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			 $this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_thumb/'.$picture['file_name'],215,247);
			 
			$this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_list/'.$picture['file_name'],120,120);
			
			
			$this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_thumb_70by70/'.$picture['file_name'],70,70);
			
			
			$this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_225/'.$picture['file_name'],225,225);
			
			$this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_291/'.$picture['file_name'],291,291);
			
			$this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_200/'.$picture['file_name'],200,200);
			
			$this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_240/'.$picture['file_name'],240,240);
			
			$this->image_lib->clear();
			resize(base_path().'upload/cocktail_orig/'.$picture['file_name'],base_path().'upload/cocktail_140/'.$picture['file_name'],140,140);
			 
			
			$beer_image =$picture['file_name'];
			
		
			
			} 
			  $slug=getCocktailSlug($this->input->post('cocktail_name'));
			$data = array(
				'cocktail_name' => $this->input->post('cocktail_name'),
				'ingredients' => $this->input->post('ingredients'),
				'how_to_make_it' => $this->input->post('how_to_make_it'),
				'base_spirit' => $this->input->post('base_spirit'),
				'cocktail_image' => $beer_image,
				'type' => $this->input->post('type'),
				'status' => 'pending',
				'is_deleted' => 'no',
				'date_added' => date('Y-m-d H:i:s'),
				'served' => $this->input->post('served'),
				'preparation' => $this->input->post('preparation'),
				'strength' => $this->input->post('strength'),
				'difficulty' => $this->input->post('difficulty'),
				'flavor_profile' => $this->input->post('flavor_profile'),
				'cocktail_slug' => $slug,
				// 'cocktail_meta_title' => $this->input->post('cocktail_meta_title'),
				// 'cocktail_meta_keyword' => $this->input->post('cocktail_meta_keyword'),
				// 'cocktail_meta_description' => $this->input->post('cocktail_meta_description'),
			);
			
			$this->db->insert('cocktail_directory',$data);
			
			$news_id = mysql_insert_id();
		$inar = array('cat_id'=>$news_id,
		              'category'=>'cocktail',
					  'date'=>date('Y-m-d H:i:s'));
		$this->db->insert('sitemap', $inar);
	}



    function getGallery()
	{
		$this->db->select('*');
		$this->db->from('bar_gallery');
		$this->db->where(array('bar_gallery.bar_id'=>0,'status'=>'Active'));
		$this->db->order_by('reorder','asc');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return '';
	}


    function suggestliquor_insert()
	{
		
		$beer_image = '';
		$image_setting = image_setting();
		 if(isset($_FILES['image']) && $_FILES['image']['name']!='')
         {
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['image']['name'];
             $_FILES['userfile']['type']     =   $_FILES['image']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['image']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['image']['error'];
             $_FILES['userfile']['size']     =   $_FILES['image']['size'];
   
			$config['file_name'] = 'liquor'.$rand;
			
            $config['upload_path'] = base_path().'upload/liquor_orig/';
			
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			
			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   
              $this->image_lib->clear();
		   	
			
					$gd_var='gd2';
				
				
		   if ($_FILES["image"]["type"]!= "image/png" and $_FILES["image"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["image"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["image"]["type"] != "image/jpeg" and $_FILES["image"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_thumb/'.$picture['file_name'],215,247);
			 
			$this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_list/'.$picture['file_name'],120,120);
			
			
			$this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_thumb_70by70/'.$picture['file_name'],70,70);
			
			$this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_225/'.$picture['file_name'],225,225);
			
			$this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_291/'.$picture['file_name'],291,291);
			
			$this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_240/'.$picture['file_name'],240,240);
			
			$this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_200/'.$picture['file_name'],200,200);
			$this->image_lib->clear();
			resize(base_path().'upload/liquor_orig/'.$picture['file_name'],base_path().'upload/liquor_140/'.$picture['file_name'],140,140);
			
			$beer_image =$picture['file_name'];
			
		
			
			} 
			  $slug=getLiquorSlug($this->input->post('liquor_title'));
			$data = array(
				'liquor_title' => $this->input->post('liquor_title'),
				'type' => $this->input->post('type'),
				'proof' => $this->input->post('proof'),
				'producer' => $this->input->post('producer'),
				'liquor_description' => $this->input->post('liquor_description'),
				'liquor_image' => $beer_image,
				'country' => $this->input->post('country'),
				'status' => 'pending',
				'is_deleted' => 'no',
				'liquor_slug' => $slug,
				'date_added' => date('Y-m-d H:i:s'),
			);
			
			$this->db->insert('liquors',$data);
			
			$news_id = mysql_insert_id();
		$inar = array('cat_id'=>$news_id,
		              'category'=>'liquor',
					  'date'=>date('Y-m-d H:i:s'));
		$this->db->insert('sitemap', $inar);
	}
	
	function get_bar_likers($id=0){
		$this->db->select('a.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('all_likes a');		
		$this->db->join('user_master u','u.user_id=a.user_id');
		$this->db->where('a.bar_id',$id);
		$this->db->where('like_flag',1);
		$this->db->order_by('date_added','asc');
		$this->db->group_by('user_id');
		$this->db->limit(8);
		$qry = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($qry->num_rows() >0){
			return $qry->result();
		}
//		print_r($qry);die;
	}

		function get_all_bar_likers($id=0){
		$this->db->select('a.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('all_likes a');		
		$this->db->join('user_master u','u.user_id=a.user_id');
		$this->db->where('a.bar_id',$id);
		$this->db->where('like_flag',1);
		$this->db->order_by('date_added','asc');
		$this->db->group_by('user_id');
		$qry = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($qry->num_rows() >0){
			return $qry->result();
		}
//		print_r($qry);die;
	}
	
        function get_all_bar_likers_ids($id=0){
		$this->db->select('a.user_id as NULL');
		$this->db->from('all_likes a');		
		$this->db->join('user_master u','u.user_id=a.user_id');
		$this->db->where('a.bar_id',$id);
		$this->db->where('like_flag',1);
		$this->db->order_by('date_added','asc');
		$this->db->group_by('a.user_id');
		$qry = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($qry->num_rows() >0){
			return $qry->result();
		}
//		print_r($qry);die;
	}
        
    function getBarLikersCount($keyword)
	{
		
		$en = '';
		$en1 = '';
		$bar_det = $this->home_model->get_bar_info(get_authenticateUserID());
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
		$this->db->select('user_master.*,all_likes.date_added as date');
		$this->db->from('all_likes');
		$this->db->join('bars','bars.bar_id=all_likes.bar_id');
		$this->db->join('user_master','all_likes.user_id=user_master.user_id');
		$this->db->where(array('all_likes.bar_id'=>$bar_det['bar_id'],'all_likes.like_flag'=>1,'bars.is_deleted'=>'no'));
		if($keyword!='' && $keyword!='1V1')
		{
			$en.=" `first_name` like ('%".$keyword."%') OR `last_name` like ('%".$keyword."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$en1.=" `first_name` like ('%".$val."%') OR `last_name` like ('%".$val."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en.substr($en1, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
		}
		}			  
		$this->db->order_by('all_likes.like_id','desc');
		$query = $this->db->get();
// 		
		 // echo $this->db->last_query();
		 // die;
		return $query->num_rows();
	}
	
	function getBarLikers($offset="",$limit="",$keyword='')
	{   $en = '';
		$en1 = '';
		$bar_det = $this->home_model->get_bar_info(get_authenticateUserID());
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
		$this->db->select('user_master.*,all_likes.date_added as date');
		$this->db->from('all_likes');
		$this->db->join('bars','bars.bar_id=all_likes.bar_id');
		$this->db->join('user_master','all_likes.user_id=user_master.user_id');
		$this->db->where(array('all_likes.bar_id'=>$bar_det['bar_id'],'all_likes.like_flag'=>1,'bars.is_deleted'=>'no'));
		if($keyword!='' && $keyword!='1V1')
		{
			$en.=" `first_name` like ('%".$keyword."%') OR `last_name` like ('%".$keyword."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$en1.=" `first_name` like ('%".$val."%') OR `last_name` like ('%".$val."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en.substr($en1, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
		}
		}
				  
		$this->db->order_by('all_likes.like_id','desc');
		$query = $this->db->get();
// 		
		
		if($query->num_rows() >0){
			return $query->result();
		}
	}

    function getBarHours($bars_id)
	{
		$this->db->select('*');
		$this->db->from('bar_hours');
		$this->db->join('days','days.days_id=bar_hours.days_id');
		$this->db->where('bar_hours.bar_id',$bars_id);
		//$this->db->order_by('days', 'Sunday', 'Monday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Tuesda');
		$qry = $this->db->get();
		if($qry->num_rows() >0){
			return $qry->result();
		}
	}
	
	function getUnreadMessage($offset, $limit){
		
       
        $query = $this->db->query("select * from sss_message where master_message_id=0  && (to_user_id=".get_authenticateUserID()." or  from_user_id=".get_authenticateUserID().") ORDER BY message_id desc  limit ".$limit." offset ".$offset." ");
		
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		return 0;
	}
	
	function bar_update_logo()
	{
		
		$cap_image = '';
		$tshirt_image = '';
		 $name = '';
		$image_setting = image_setting();
		
		if(isset($_FILES['cap_image']) && $_FILES["cap_image"]["name"] != ""){
			
			
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['cap_image']['name'];
             $_FILES['userfile']['type']     =   $_FILES['cap_image']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['cap_image']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['cap_image']['error'];
             $_FILES['userfile']['size']     =   $_FILES['cap_image']['size'];
   
			$config['file_name'] = 'productlogo'.$rand;
			
            $config['upload_path'] = base_path().'upload/product_logo_orig/';
			
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			
			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   
              $this->image_lib->clear();
		   	
			
					$gd_var='gd2';
				
				
		   if ($_FILES["cap_image"]["type"]!= "image/png" and $_FILES["cap_image"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["cap_image"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["cap_image"]["type"] != "image/jpeg" and $_FILES["cap_image"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/product_logo_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/product_logo_thumb/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => 120,
				'height' => 120,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$cap_image=$picture['file_name'];
			
		
			if($this->input->post('prev_cap_image')!='')
				{
					if(file_exists(base_path().'upload/product_logo_orig/'.$this->input->post('prev_cap_image')))
					{
						$link=base_path().'upload/product_logo_orig/'.$this->input->post('prev_cap_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/product_logo_thumb/'.$this->input->post('prev_cap_image')))
					{
						$link2=base_path().'upload/product_logo_thumb/'.$this->input->post('prev_cap_image');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('pre_cap_image')!='')
				{
					$cap_image=$this->input->post('pre_cap_image');
				}
			}
if(isset($_FILES['tshirt_image']) && $_FILES["tshirt_image"]["name"] != ""){
             $this->load->library('upload');
             $rand=rand(0,100000); 
			  
             $_FILES['userfile']['name']     =   $_FILES['tshirt_image']['name'];
             $_FILES['userfile']['type']     =   $_FILES['tshirt_image']['type'];
             $_FILES['userfile']['tmp_name'] =   $_FILES['tshirt_image']['tmp_name'];
             $_FILES['userfile']['error']    =   $_FILES['tshirt_image']['error'];
             $_FILES['userfile']['size']     =   $_FILES['tshirt_image']['size'];
   
			$config['file_name'] = 'productlogo'.$rand;
			
            $config['upload_path'] = base_path().'upload/product_logo_orig/';
			
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';  
 
             $this->upload->initialize($config);
 
              if (!$this->upload->do_upload())
			  {
				$error =  $this->upload->display_errors();   
			  } 
			
			   
           	  $picture = $this->upload->data();
		   
              $this->load->library('image_lib');
		   
              $this->image_lib->clear();
		   	
			
					$gd_var='gd2';
				
				
		   if ($_FILES["tshirt_image"]["type"]!= "image/png" and $_FILES["tshirt_image"]["type"] != "image/x-png") {
		  
		   	$gd_var='gd2';
			
			
			}
			
					
		   if ($_FILES["tshirt_image"]["type"] != "image/gif") {
		   
		    	$gd_var='gd2';
		   }
		   
		   
		    if ($_FILES["tshirt_image"]["type"] != "image/jpeg" and $_FILES["tshirt_image"]["type"] != "image/pjpeg" ) {
		   
		    	$gd_var='gd2';
		   }
		   
             
			$this->image_lib->clear();
			
			 $this->image_lib->initialize(array(
				'image_library' => $gd_var,
				'source_image' => base_path().'upload/product_logo_orig/'.$picture['file_name'],
				'new_image' => base_path().'upload/product_logo_thumb/'.$picture['file_name'],
				'maintain_ratio' => FALSE,
				'quality' => '100%',
				'width' => 120,
				'height' => 120,
			 ));
			
			
			if(!$this->image_lib->resize())
			{
				$error = $this->image_lib->display_errors();
			}
			
			$tshirt_image=$picture['file_name'];
			
		
			if($this->input->post('prev_tshirt_image')!='')
				{
					if(file_exists(base_path().'upload/product_logo_orig/'.$this->input->post('prev_tshirt_image')))
					{
						$link=base_path().'upload/product_logo_orig/'.$this->input->post('prev_tshirt_image');
						unlink($link);
					}
					
					if(file_exists(base_path().'upload/product_logo_thumb/'.$this->input->post('prev_tshirt_image')))
					{
						$link2=base_path().'upload/product_logo_thumb/'.$this->input->post('prev_tshirt_image');
						unlink($link2);
					}
					
				}
			} else {
				if($this->input->post('prev_tshirt_image')!='')
				{
					$tshirt_image=$this->input->post('prev_tshirt_image');
				}
			}
           
		  
		$data_insert['cap_logo'] = $cap_image;
		$data_insert['tshirt_logo'] = $tshirt_image;
		
		
		$this->db->where('bar_id',$this->input->post('b_id'));
		$this->db->update('bars',$data_insert);
		
	}

function bar_update_product()
	{
		$data_insert['prcap'] = $this->input->post('prcap');
		$data_insert['prtshirt'] = $this->input->post('prtshirt');
		$this->db->where('bar_id',$this->input->post('b_id'));
		$this->db->update('bars',$data_insert);
		
		
	}

 	function getBarOrdercount($bar_id,$keyword,$from_date,$to_date)
	{
		
		$en='';
		$en1='';
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
		$this->db->select('order_master.*,transaction_order.txn_id as transaction_id,user_master.first_name as first_name,user_master.last_name as last_name');
		$this->db->from('order_master');
		$this->db->join('order_detail','order_master.order_id=order_detail.order_id');
		$this->db->join('store','store.store_id=order_detail.product_id','left');
		$this->db->join('transaction_order','order_master.order_id=transaction_order.order_id','left');
		$this->db->join('user_master','user_master.user_id=order_master.user_id');
		$this->db->where(array('order_detail.bar_id'=>$bar_id));
		$this->db->or_where(array('store.bar_id'=>$bar_id));
		if($keyword!='' && $keyword!='1V1')
		{
		$en.=" `first_name` like ('%".$keyword."%') OR `last_name` like ('%".$keyword."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$en1.=" `first_name` like ('%".$val."%') OR `last_name` like ('%".$val."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en.substr($en1, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
		}	
		}	
		if($from_date!="" && $to_date!="")
		{
			$this->db->where('order_master.order_date >=',date('Y-m-d',strtotime($from_date)));
			$this->db->where('order_master.order_date <=',date('Y-m-d',strtotime($to_date)));
		}  
		$this->db->order_by('order_master.order_id','desc');
		$this->db->group_by('order_detail.order_id');
		$query = $this->db->get();
// 		
		 // echo $this->db->last_query();
		 // die;
		return $query->num_rows();
	}
	
	function getBarOrderDetail($bar_id='',$offset="",$limit="",$keyword='',$from_date,$to_date)
	{
		
		$en='';
		$en1='';
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
		$this->db->select('order_master.*,store.bar_id,transaction_order.txn_id as transaction_id,user_master.first_name as first_name,user_master.last_name as last_name,user_master.email as email,user_master.mobile_no as mobile_no,user_master.address as address,user_master.user_city as user_city,user_master.user_state as user_state,user_master.user_zip as user_zip');
		$this->db->from('order_master');
		$this->db->join('order_detail','order_master.order_id=order_detail.order_id');
		$this->db->join('transaction_order','order_master.order_id=transaction_order.order_id','left');
		$this->db->join('user_master','user_master.user_id=order_master.user_id');
		$this->db->join('store','store.store_id=order_detail.product_id','left');
		$this->db->where(array('order_detail.bar_id'=>$bar_id));
		$this->db->or_where(array('store.bar_id'=>$bar_id));
		if($keyword!='' && $keyword!='1V1')
		{
		$en.=" `first_name` like ('%".$keyword."%') OR `last_name` like ('%".$keyword."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$en1.=" `first_name` like ('%".$val."%') OR `last_name` like ('%".$val."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en.substr($en1, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
		}	
		}	 
			if($from_date!="" && $to_date!="")
		{
			$this->db->where('order_master.order_date >=',date('Y-m-d',strtotime($from_date)));
			$this->db->where('order_master.order_date <=',date('Y-m-d',strtotime($to_date)));
		}   
		$this->db->order_by('order_master.order_id','desc');
		$this->db->group_by('order_detail.order_id');
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

function getUserOrdercount($keyword,$from_date,$to_date)
	{
		
		$en='';
		$en1='';
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
		$this->db->select('order_master.*,transaction_order.txn_id as transaction_id,user_master.first_name as first_name,user_master.last_name as last_name');
		$this->db->from('order_master');
		$this->db->join('order_detail','order_master.order_id=order_detail.order_id');
		$this->db->join('transaction_order','order_master.order_id=transaction_order.order_id','left');
		$this->db->join('user_master','user_master.user_id=order_master.user_id');
		$this->db->where(array('order_master.user_id'=>get_authenticateUserID()));
		if($keyword!='' && $keyword!='1V1')
		{
		$en.=" `first_name` like ('%".$keyword."%') OR `last_name` like ('%".$keyword."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$en1.=" `first_name` like ('%".$val."%') OR `last_name` like ('%".$val."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en.substr($en1, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
		}	
		}	
		if($from_date!="" && $to_date!="")
		{
			$this->db->where('order_master.order_date >=',date('Y-m-d',strtotime($from_date)));
			$this->db->where('order_master.order_date <=',date('Y-m-d',strtotime($to_date)));
		}  
		$this->db->order_by('order_master.order_id','desc');
		$this->db->group_by('order_detail.order_id');
		$query = $this->db->get();
// 		
		 // echo $this->db->last_query();
		 // die;
		return $query->num_rows();
	}
	
	function getUserOrderDetail($offset="",$limit="",$keyword='',$from_date,$to_date)
	{
		
		$en='';
		$en1='';
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
		$this->db->select('order_master.*,transaction_order.txn_id as transaction_id,user_master.first_name as first_name,user_master.last_name as last_name,user_master.email as email,user_master.mobile_no as mobile_no,user_master.address as address,user_master.user_city as user_city,user_master.user_state as user_state,user_master.user_zip as user_zip');
		$this->db->from('order_master');
		$this->db->join('order_detail','order_master.order_id=order_detail.order_id');
		$this->db->join('transaction_order','order_master.order_id=transaction_order.order_id','left');
		$this->db->join('user_master','user_master.user_id=order_master.user_id');
		$this->db->where(array('order_master.user_id'=>get_authenticateUserID()));
		if($keyword!='' && $keyword!='1V1')
		{
		$en.=" `first_name` like ('%".$keyword."%') OR `last_name` like ('%".$keyword."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$en1.=" `first_name` like ('%".$val."%') OR `last_name` like ('%".$val."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en.substr($en1, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en, 0 ,-3).')')  ;
		}	
		}	 
			if($from_date!="" && $to_date!="")
		{
			$this->db->where('order_master.order_date >=',date('Y-m-d',strtotime($from_date)));
			$this->db->where('order_master.order_date <=',date('Y-m-d',strtotime($to_date)));
		}   
		$this->db->order_by('order_master.order_id','desc');
		$this->db->group_by('order_detail.order_id');
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

	function AllOrderDet($id)
	{
		$query = $this->db->select('order_detail.*,b1.bar_title as bname, b1.bar_slug as bslug, bars.bar_slug as bar_slug,  store.product_slug,store.bar_id,order_detail.bar_id as b,order_detail.color_id as colname,order_detail.size_id as sizename,store.*,bars.bar_title as barname,order_detail.quantity as quantity')
		                  ->from('order_detail')
						  ->join('store','store.store_id=order_detail.product_id','left')
						 // ->join('Color','Color.Color_id=order_detail.color_id','left')
						  //->join('Size','Size.Size_id=order_detail.size_id','left')
						  ->join('bars','bars.bar_id=order_detail.bar_id','left')
						  ->join('bars b1','b1.bar_id=store.bar_id','left')
						  //->join('bars','bars.bar_id=order_detail.bar_id','left')
						  ->where('order_detail.order_id',$id);
		
		$query = $this->db->get();				  
	    if($query->num_rows()>0)
		{
			return $query->result();
		}					  
		else {
			return '';
		}
	}
	
	function getAllBarResult()
	{
		$this->db->select('bar_id,address,city,state,bar_id,lat,gt');
		$this->db->from("bars");
		$this->db->where('status','active');
		$this->db->where('lat =','');
		//$this->db->where('gt','0');
		$this->db->where('bar_id >=','62704');
		//$this->db->limit(1000);
		//$this->db->where('bar_id','54823');
		$this->db->order_by('bar_id','asc');
		$this->db->limit(2500);
		$qry = $this->db->get();
		
	   // echo $this->db->last_query();
		if($qry->num_rows()>0)
		{
			 return $qry->result();
		}
		
		
		return 0;
		
	}
	
	function getAllBarResult1()
	{
		$this->db->select('CONCAT_ws(" ", address,city,state ) address',false);
		$this->db->select('bar_id,lat,gt');
		$this->db->from("bars");
		$this->db->where('status','active');
		$this->db->where('lat =','');
		//$this->db->where('gt','0');
		//$this->db->where('bar_id','54823');
		//$this->db->limit(1000);
		$this->db->where('bar_id >','61922');
		$this->db->order_by('bar_id','asc');
		$this->db->limit(2500);
		$qry = $this->db->get();
		
	
		if($qry->num_rows()>0)
		{
			 return $qry->row();
		}
		
		
		return 0;
		
	}
function getAllBarResult11()
	{
		$this->db->select('CONCAT_ws(" ", address,city,state ) address',false);
		$this->db->select('bar_id,lat,gt');
		$this->db->from("bars");
		$this->db->where('status','active');
		$this->db->where('lat =','');
		//$this->db->where('gt','0');
		//$this->db->where('bar_id','54823');
		//$this->db->limit(1000);
		//$this->db->where('bar_id <=','54823');
		$this->db->order_by('bar_id','asc');
		$this->db->limit(1);
		$qry = $this->db->get();
		
	
		if($qry->num_rows()>0)
		{
			 return $qry->row();
		}
		
		
		return 0;
		
	}
	function getbarnear($latitude,$longitude,$bar_id)
	{
		$radius = 3;
	  $qry =	$this->db->query("SELECT * 
						FROM
						    sss_bars
						WHERE bar_id!=".$bar_id." and
						    (
						    	(69.1 * (lat - " . $latitude . ")) * 
						    	(69.1 * (lat - " . $latitude . "))
						    ) + ( 
						    	(69.1 * (lang - " . $longitude . ") * COS(" . $latitude . " / 57.3)) * 
						    	(69.1 * (lang - " . $longitude . ") * COS(" . $latitude . " / 57.3))
						    ) < " . pow($radius, 2) . " 
						ORDER BY 
						    (
						    	(69.1 * (lat - " . $latitude . ")) * 
						    	(69.1 * (lat - " . $latitude . "))
						    ) + ( 
						    	(69.1 * (lang - " . $longitude . ") * COS(" . $latitude . " / 57.3)) * 
						    	(69.1 * (lang - " . $longitude . ") * COS(" . $latitude . " / 57.3))
						    ) ASC");
			
			
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}	
		else {
			return '';
		}			
	
	   
	}
		function getquiz_id($id='')
	{
		$this->db->select('beer_id');
		$this->db->from('beer_bars');
		if($id!='')
        {
		  $this->db->where('bar_id',"$id");
		}  
		$qry = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($qry->num_rows()>0)
		{
			 return $qry->result();
		}
	}
	
		function getquiz_id1($id='')
	{
		$this->db->select('cocktail_id');
		$this->db->from('cocktail_bars');
		if($id!='')
        {
		  $this->db->where('bar_id',"$id");
		}  
		$qry = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($qry->num_rows()>0)
		{
			 return $qry->result();
		}
	}
		function getquiz_id2($id='')
	{
		$this->db->select('liquor_id');
		$this->db->from('liquors_bars');
		if($id!='')
        {
		  $this->db->where('bar_id',"$id");
		}  
		$qry = $this->db->get();
		
		// echo $this->db->last_query();
		// die;
		if($qry->num_rows()>0)
		{
			 return $qry->result();
		}
	}
	function getAllBeerByID($search='',$city='')
	{
		//$query = $this->db->query("select beer_id from sss_beer_bars where bar_id='$city'  ");
		$getarray = $this->getquiz_id($city);
		$getarray123 = array();
		
		
	    if($getarray)
		{
	    foreach($getarray as $row)
	    {
	        $getarray123[] = $row->beer_id; // add each user id to the array
	    }
		}
		
		$this->db->select("beer_directory.beer_id as value,beer_directory.beer_name as text");
        $this->db->from("beer_directory");
		$this->db->join("beer_bars",'beer_bars.beer_id=beer_directory.beer_id','left');
		//$this->db->where('beer_directory.beer_id not in',$city);
		if(is_array($getarray))
		{
		$this->db->where_not_in('beer_directory.beer_id', $getarray123);
		}
		$this->db->like("beer_name",$search,'after');
		$this->db->where('status','active');
		$this->db->group_by('beer_directory.beer_id');
		if(strlen($search)>=4)
		{
			$this->db->limit(100);
		}
		else {
			$this->db->limit(10);
		}
        $query =  $this->db->get();
		//echo $this->db->last_query();
        return $query->result();
	}
	
	function getAllCocktailByID($search='',$city='')
	{
		//$query = $this->db->query("select beer_id from sss_beer_bars where bar_id='$city'  ");
		$getarray = $this->getquiz_id1($city);
		$getarray123 = array();
		
		
	    if($getarray)
		{
	    foreach($getarray as $row)
	    {
	        $getarray123[] = $row->cocktail_id; // add each user id to the array
	    }
		}
		
		$this->db->select("cocktail_directory.cocktail_id as value,cocktail_directory.cocktail_name as text");
        $this->db->from("cocktail_directory");
		$this->db->join("cocktail_bars",'cocktail_bars.cocktail_id=cocktail_directory.cocktail_id','left');
		//$this->db->where('beer_directory.beer_id not in',$city);
		if(is_array($getarray))
		{
		$this->db->where_not_in('cocktail_directory.cocktail_id', $getarray123);
		}
		$this->db->like("cocktail_name",$search,'after');
		$this->db->where('status','active');
		$this->db->group_by('cocktail_directory.cocktail_id');
		if(strlen($search)>=4)
		{
			$this->db->limit(100);
		}
		else {
			$this->db->limit(10);
		}
        $query =  $this->db->get();
		
        return $query->result();
	}	
	
	function getAllLiquorByID($search='',$city='')
	{
		//$query = $this->db->query("select beer_id from sss_beer_bars where bar_id='$city'  ");
		$getarray = $this->getquiz_id2($city);
		$getarray123 = array();
		
		
	    if($getarray)
		{
	    foreach($getarray as $row)
	    {
	        $getarray123[] = $row->liquor_id; // add each user id to the array
	    }
		}
		
		$this->db->select("liquors.liquor_id as value,liquors.liquor_title as text");
        $this->db->from("liquors");
		$this->db->join("liquors_bars",'liquors_bars.liquor_id=liquors.liquor_id','left');
		//$this->db->where('beer_directory.beer_id not in',$city);
		if(is_array($getarray))
		{
		$this->db->where_not_in('liquors.liquor_id', $getarray123);
		}
		$this->db->like("liquor_title",$search,'after');
		$this->db->where('status','active');
		$this->db->group_by('liquors.liquor_id');
		if(strlen($search)>=4)
		{
			$this->db->limit(100);
		}
		else {
			$this->db->limit(10);
		}
        $query =  $this->db->get();
		
        return $query->result();
	}	
	
	function bar_hours_update($bar_id)
	{
		$this -> db -> where('bar_id', $bar_id);
  		$this -> db -> delete('bar_special_hours');
		$datatick['days']=$this->input->post('days');
		$datatick['hour_from']=$this->input->post('hour_from');
		$datatick['hour_to']=$this->input->post('hour_to');
		$datatick['price']=$this->input->post('price');
		$datatick['speciality']=$this->input->post('speciality');
		$datatick['bar_hour_id']=$this->input->post('bar_hour_id');
		$datatick['beerid']=$this->input->post('beerid');
		$datatick['beerprice']=$this->input->post('beerprice');
		$datatick['cocktailid']=$this->input->post('cocktailid');
		$datatick['cocktailprice']=$this->input->post('cocktailprice');
		$datatick['liquorid']=$this->input->post('liquorid');
		$datatick['liquorprice']=$this->input->post('liquorprice');
		$datatick['foodid']=$this->input->post('foodid');
		$datatick['foodprice']=$this->input->post('foodprice');
		$datatick['otherid']=$this->input->post('otherid');
		$datatick['otherprice']=$this->input->post('otherprice');
		$datatick['cntprobeer']=$this->input->post('cntprobeer');
		
		
		//echo 
		
		// echo "<pre>";
		// print_r($_POST);
		// die;
		
		
		 if( isset( $datatick['days'] ) && is_array( $datatick['days'] ) ){
			foreach( $datatick['days'] as $key => $each ){
				
					$d = '';
					if($datatick['days'][$key]=="Monday")
					{
						$d = 1;
					}
					if($datatick['days'][$key]=="Tuesday")
					{
						$d = 2;
					}
					if($datatick['days'][$key]=="Wednesday")
					{
						$d = 3;
					}
					if($datatick['days'][$key]=="Thursday")
					{
						$d = 4;
					}
					if($datatick['days'][$key]=="Friday")
					{
						$d = 5;
					}
					if($datatick['days'][$key]=="Saturday")
					{
						$d = 6;
					}
					if($datatick['days'][$key]=="Sunday")
					{
						$d = 7;
					}
				
					
					 
				//$datatick['beer_id'] = $this->input->post('')
				//if($thi)
				//$datatick['otherprice']=$this->input->post('otherprice');
				 // $countbeer =  $datatick['cntprobeer'][$key]+1;
// 				 
				 // //foreach($countbeer)
				 // if($countbeer)
				 // {
				 	// foreach($countbeer as $beer)
					// {
						// $dataticket=array(
					// 'days'=>$datatick['days'][$key],
				    // 'hour_from' => $datatick['hour_from'][$key],
				    // 'hour_to' => $datatick['hour_to'][$key],
				    // 'bar_id' => $bar_id,
				     // 'rand' => $rand,
				     // 'beer' => $datatick['speciality'][$key],
					// );
					// $this->db->insert('bar_special_hours',$dataticket);	
					// }
				 // }
				 
				$beer =$this->input->post('bid'.$key);
				$beerprice =$this->input->post('beerprice'.$key);
				
				//echo count($beer)."test";
				//echo count($beer);
				//print_r($beer);
				$rand = rand('1111','9999');
				 if(count($beer))
				 {
				 	 $i=0; foreach($beer as $b)
					 {
					 	
					 	//echo $b;
					 	$dataticket=array(
						'days'=>$datatick['days'][$key],
					    'hour_from' => $datatick['hour_from'][$key],
					    'hour_to' => $datatick['hour_to'][$key],
					    'sp_beer_price' => isset($beerprice[$i]) ? $beerprice[$i]:'',
					    'sp_beer_id' => $b,
					    'cat' => 'beer',
					     'rand' => $rand,
					     'bar_id' => $bar_id,
						);
						$this->db->insert('bar_special_hours',$dataticket);	
					  $i++; }
				 }
				 
				 
				 $cocktail =$this->input->post('cid'.$key);
				$cocktailprice =$this->input->post('cocktailprice'.$key);
				
				 if(count($cocktail))
				 {
				 	 $i=0; foreach($cocktail as $c)
					 {
					 	//echo $b;
					 	$dataticket=array(
						'days'=>$datatick['days'][$key],
					    'hour_from' => $datatick['hour_from'][$key],
					    'hour_to' => $datatick['hour_to'][$key],
					    'sp_cocktail_price' => isset($cocktailprice[$i]) ? $cocktailprice[$i]:'',
					    'sp_cocktail_id' => $c,
					     'rand' => $rand,
					     'cat' => 'cocktail',
					     'bar_id' => $bar_id,
						);
						$this->db->insert('bar_special_hours',$dataticket);	
					  $i++; }
				 }
				 
				  $liquor =$this->input->post('lid'.$key);
				$liquorprice =$this->input->post('liquorprice'.$key);
				
				 if(count($liquor))
				 {
				 	 $i=0; foreach($liquor as $b)
					 {
					 	//echo $b;
					 	$dataticket=array(
						'days'=>$datatick['days'][$key],
					    'hour_from' => $datatick['hour_from'][$key],
					    'hour_to' => $datatick['hour_to'][$key],
					    'sp_liquor_price' => isset($liquorprice[$i]) ? $liquorprice[$i]:'',
					    'sp_liquor_id' => $b,
					    'cat' => 'liquor',
					     'rand' => $rand,
					     'bar_id' => $bar_id,
						);
						$this->db->insert('bar_special_hours',$dataticket);	
					  $i++; }
				 }
				 
				   $foodid =$this->input->post('foodid'.$key);
				$foodprice =$this->input->post('foodprice'.$key);
				
				 if(count($foodid))
				 {
				 	 $i=0; foreach($foodid as $b)
					 {
					 	//echo $b;
					 	$dataticket=array(
						'days'=>$datatick['days'][$key],
					    'hour_from' => $datatick['hour_from'][$key],
					    'hour_to' => $datatick['hour_to'][$key],
					    'food_price' => isset($foodprice[$i]) ? $foodprice[$i]:'',
					    'food_name' => $b,
					     'rand' => $rand,
					     'cat' => 'food',
					     'bar_id' => $bar_id,
						);
						$this->db->insert('bar_special_hours',$dataticket);	
					  $i++; }
				 }
				 
				  $otherid =$this->input->post('otherid'.$key);
				$otherprice =$this->input->post('otherprice'.$key);
				
				 if(count($otherid))
				 {
				 	 $i=0; foreach($otherid as $b)
					 {
					 	//echo $b;
					 	$dataticket=array(
						'days'=>$datatick['days'][$key],
					    'hour_from' => $datatick['hour_from'][$key],
					    'hour_to' => $datatick['hour_to'][$key],
					    'other_price' => isset($otherprice[$i]) ? $otherprice[$i]:'',
					    'other_name' => $b,
					    'cat' => 'other',
					     'rand' => $rand,
					     'bar_id' => $bar_id,
						);
						$this->db->insert('bar_special_hours',$dataticket);	
					  $i++; }
				 }
				// die;d
					// $dataticket=array(
					// 'days'=>$datatick['days'][$key],
				    // 'hour_from' => $datatick['hour_from'][$key],
				    // 'hour_to' => $datatick['hour_to'][$key],
				    // 'bar_id' => $bar_id,
				    // 'day' => $d,
				     // 'price' =>$datatick['price'][$key],
				     // 'speciality' => $datatick['speciality'][$key],
					// );
					// $this->db->insert('bar_special_hours',$dataticket);	
			}
		 }
	}

    function get_bar_hour($bar_id)
	{
		$this->db->select("*");
        $this->db->from("bar_special_hours");
		$this->db->where('bar_id',$bar_id);
		$this->db->order_by('bar_hour_id','desc');
		$this->db->group_by('rand');
		//$this->db->order_by('days', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $query =  $this->db->get();
		//echo $this->db->last_query();
       
		// die;
		if($query->num_rows()>0)
		{
			 return $query->result();
		}
		 return '';
	}
	
    function getBarProductcount($bar_id,$keyword)
	{
		
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/","-"),' ',$keyword));
		$this->db->select('*');
		$this->db->from('store');
		$this->db->where(array('store.bar_id'=>$bar_id));
		if($keyword!='' && $keyword!='1V1')
		{
		$this->db->like("product_name",$keyword);	
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('product_name',$val);
					}	
				}
		}		  
		$this->db->order_by('store_id','desc');
		$query = $this->db->get();
// 		
		 // echo $this->db->last_query();
		 // die;
		return $query->num_rows();
	}

  	function getBarProductDetail($bar_id='',$offset="",$limit="",$keyword='')
	{
		
		$this->db->select('*');
		$this->db->from('store');
		$this->db->where(array('store.bar_id'=>$bar_id));
		if($keyword!='' && $keyword!='1V1')
		{
		$this->db->like("product_name",$keyword);	
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('product_name',$val);
					}	
				}
		}		  
		$this->db->order_by('store_id','desc');
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
	
	  function product_insert($bar_id='')
	{
		
		 $this->load->library('upload');
		$profile_image='';
		 $name = '';
		 $image_setting = image_setting();
		
			$slug=getProductSlug($this->input->post('product_name'));	
		 $data_insert = array('product_name'=>$this->input->post('product_name'),
		                       'description'=>$this->input->post('description'),
							   'quantity'=>$this->input->post('quantity'),
							   'color'=>$this->input->post('color'),
							   'size'=>$this->input->post('size'),
							   //'color'=>implode(",",$this->input->post('color')),
								//'size'=>implode(",",$this->input->post('size')),
							   'price'=>$this->input->post('price'),
							   'back_col'=>$this->input->post('back_col'),
							   'type' => 'barstore',
							   'product_slug' => $slug,
							   'product_image'=>$profile_image,
							   'bar_id'=>$bar_id,
							   'status'=>$this->input->post('status'),
							   'store_meta_title'=> $this->input->post('store_meta_title'),
							   'store_meta_keyword'=>$this->input->post('store_meta_keyword'),
							   'store_meta_description' => $this->input->post('store_meta_description'),
							   'date'=>date('Y-m-d H:i:s'));
			
		 					   
		 $this->db->insert('store',$data_insert);		
		 $store_id = mysql_insert_id();
		 
		 
		 
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
   
			$config['file_name'] = $rand.'product';
			
            $config['upload_path'] = base_path().'upload/product_orig/';
			
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
		   	
			
            resize(base_path().'upload/product_orig/'.$picture['file_name'],base_path().'upload/product_thumb/'.$picture['file_name'],236,185,$this->input->post('back_col'));
			  $this->image_lib->clear();
		      resize(base_path().'upload/product_orig/'.$picture['file_name'],base_path().'upload/product_thumb_big/'.$picture['file_name'],392,274,$this->input->post('back_col'));
              $this->image_lib->clear();
			  resize(base_path().'upload/product_orig/'.$picture['file_name'],base_path().'upload/product_thumb_80/'.$picture['file_name'],80,80,$this->input->post('back_col'));
				 $this->image_lib->clear();
				  	  resize(base_path().'upload/product_orig/'.$picture['file_name'],base_path().'upload/product_thumb_254/'.$picture['file_name'],252,350,$this->input->post('back_col'));
				 $this->image_lib->clear();
			
				 
			$company_image=$picture['file_name'];
			$pg=array('product_id'=>$store_id,'product_image_name'=>$company_image);
			$this->db->insert('product_images',$pg);
			
			} 
			}
				
		
		}		   
		  
	}
     
	  function product_update($bar_id='')
	{
		
		$this->load->library('upload');
		 $event_image = '';
		 $product_image = '';
		 $name = '';
		$image_setting = image_setting();
		$slug=getProductSlug($this->input->post('product_name'),$this->input->post('store_id'));	
		$profile_image='';

		 $data_insert = array('product_name'=>$this->input->post('product_name'),
		                       'description'=>$this->input->post('description'),
							   'quantity'=>$this->input->post('quantity'),
							   'color'=>$this->input->post('color'),
							   'size'=>$this->input->post('size'),
							  //'color'=>implode(",",$this->input->post('color')),
							//	'size'=>implode(",",$this->input->post('size')),
							   'price'=>$this->input->post('price'),
							   'back_col'=>$this->input->post('back_col'),
							   'type' => 'barstore',
							   'product_slug' => $slug,
							   'product_image'=>$profile_image,
							   'bar_id'=>$bar_id,
							   'status'=>$this->input->post('status'),
							   'store_meta_title'=> $this->input->post('store_meta_title'),
							   'store_meta_keyword'=>$this->input->post('store_meta_keyword'),
							   'store_meta_description' => $this->input->post('store_meta_description'),
							   'date'=>date('Y-m-d H:i:s'));
			
		 					   
		$this->db->where("store_id",$this->input->post('store_id'));
		$this->db->update('store',$data_insert);	
		$img_id = $this->input->post('image_id');
		$preImg=$this->input->post('pre_img');
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

			$config['file_name'] = $rand.'product';
			
            $config['upload_path'] = base_path().'upload/product_orig/';
			
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
				
			
		  
            
             resize(base_path().'upload/product_orig/'.$picture['file_name'],base_path().'upload/product_thumb/'.$picture['file_name'],236,185,$this->input->post('back_col'));
			  $this->image_lib->clear();
		      resize(base_path().'upload/product_orig/'.$picture['file_name'],base_path().'upload/product_thumb_big/'.$picture['file_name'],392,274,$this->input->post('back_col'));
              $this->image_lib->clear();
			  resize(base_path().'upload/product_orig/'.$picture['file_name'],base_path().'upload/product_thumb_80/'.$picture['file_name'],80,80,$this->input->post('back_col'));
				 $this->image_lib->clear();
				 	  resize(base_path().'upload/product_orig/'.$picture['file_name'],base_path().'upload/product_thumb_254/'.$picture['file_name'],252,350,$this->input->post('back_col'));
				 $this->image_lib->clear();
			
			
			$product_image=$picture['file_name'];
				
				
				if(isset($preImg[$key]) && $preImg[$key]!='')
				{
					if(file_exists(base_path().'upload/product_thumb_254/'.$preImg[$key]))
					{
						unlink(base_path().'upload/product_thumb_254/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/product_orig/'.$preImg[$key]))
					{
						unlink(base_path().'upload/product_orig/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/product_thumb/'.$preImg[$key]))
					{
						unlink(base_path().'upload/product_thumb/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/product_thumb_big/'.$preImg[$key]))
					{
						unlink(base_path().'upload/product_thumb_big/'.$preImg[$key]);
					}
					if(file_exists(base_path().'upload/product_thumb_80/'.$preImg[$key]))
					{
						unlink(base_path().'upload/product_thumb_80/'.$preImg[$key]);
					}
					
				}
				
				 }
				 else
				 {
// 				
				  $product_image = $preImg[$key];
				}
// 				
// 				
				if($product_image!=''){
					
						 $pg=array('product_id'=>$this->input->post('store_id'),'product_image_name'=>$product_image);
						if(isset($img_id[$key]) && $img_id[$key]>0){
							$this->db->where('product_image_id',$img_id[$key]);
							$this->db->update('product_images',$pg);
						}else{
							
							$this->db->insert('product_images',$pg);
						}
				}
				
			} 
				
				}	   
		  
	}
	 function getOneProduct()
	 {
	 	  $this->db->select('*');
		  $this->db->from('store');
		  $this->db->where('store_id',$this->input->post('id'));
		  $query = $this->db->get();
		  return $query->row(); 
	 }
    
	  function getProductGalleryImages()
	 {
	 	 $this->db->select('*');
		 $this->db->from('product_images');
		 $this->db->where('product_id',$this->input->post('id'));
		 $query = $this->db->get();
		 if($query->num_rows()>0)
		 {
		 	return $query->result();
		 }
		 return '';
	 }
	   function changeOrderStatus($order_id,$order_status){
    	// require_once(APPPATH.'paypal-php-library-master/includes/config.php');
		// require_once(APPPATH.'paypal-php-library-master/includes/paypal.class.php');
		// $gettransactionID = $this->gettransactionID($order_id); 
	     $getOrederDetails = $this->getOrederDetails($order_id); 
		// if($order_status=="Canceled1")
		// {
			// $PayPalConfig = array(
					// 'Sandbox' => $sandbox,
					// 'APIUsername' => $api_username,
					// 'APIPassword' => $api_password,
					// 'APISignature' => $api_signature
					// );
// 
			// $PayPal = new PayPal($PayPalConfig);
// 			
			// $RTFields = array(
					// 'transactionid' => $gettransactionID['txn_id'], 							// Required.  PayPal transaction ID for the order you're refunding.
					// 'invoiceid' => '', 								// Your own invoice tracking number.
					// 'refundtype' => 'Partial', 							// Required.  Type of refund.  Must be Full, Partial, or Other.
					// 'amt' => $gettransactionID['amount'] + ($gettransactionID['amount']*2.90/100)  - $gettransactionID['amount']/10, 									// Refund Amt.  Required if refund type is Partial.  
					// 'currencycode' => '', 							// Three-letter currency code.  Required for Partial Refunds.  Do not use for full refunds.
					// 'note' => '',  									// Custom memo about the refund.  255 char max.
					// 'retryuntil' => '', 							// Maximum time until you must retry the refund.  Note:  this field does not apply to point-of-sale transactions.
					// 'refundsource' => '', 							// Type of PayPal funding source (balance or eCheck) that can be used for auto refund.  Values are:  any, default, instant, eCheck
					// 'merchantstoredetail' => '', 					// Information about the merchant store.
					// 'refundadvice' => '', 							// Flag to indicate that the buyer was already given store credit for a given transaction.  Values are:  1/0
					// 'refunditemdetails' => '', 						// Details about the individual items to be returned.
					// 'storeid' => '', 								// ID of a merchant store.  This field is required for point-of-sale transactions.  50 char max.
					// 'terminalid' => ''								// ID of the terminal.  50 char max.
				// );
// 				
			// $PayPalRequestData = array('RTFields'=>$RTFields);
			// $PayPalResult = $PayPal->RefundTransaction($PayPalRequestData);	
// 			
// 			
		// }
// 
        // if($PayPalResult!="Failure" && $order_status=="Canceled")
		// {
				// $data=array(
				// 'status'=>$order_status,
				// );
				// $this->db->where('order_id', $order_id);
				// $this->db->update('order_master', $data);
// 				
				// if($getOrederDetails)
				// {
					 // /*Mail Send*/
			            // $email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Order Cancelled Successfully'");
			            // $email_temp=$email_template->row();             
			            // $email_address_from=$email_temp->from_address;
			            // $email_address_reply=$email_temp->reply_address;
// 			                    
			            // $email_subject=$email_temp->subject;                
			            // $email_message=$email_temp->message;
// 			                    
			            // $email = $getOrederDetails['email'];//"php.developer@spaculus.com";
			            // //$site_name = $site_data->site_name;
			            // $email_to =$email;
			            // $user_name =   $getOrederDetails['first_name']." ".$getOrederDetails['last_name'];
			            // $email_message=str_replace('{break}','<br/>',$email_message);
			            // $email_message=str_replace('{username}',$user_name,$email_message);
			            // $email_message=str_replace('{ordernumber}',$getOrederDetails['order_number'],$email_message); 
			            // $str=$email_message;
			            // //echo $str;exit;
			            // /** custom_helper email function **/
// 			                                        
			            // email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
				// }
		// }
		// else if($order_status!="Canceled") {
				if($order_status=='Completed')
			{
						 $email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Order Completed Successfully'");
			            $email_temp=$email_template->row();             
			            $email_address_from=$email_temp->from_address;
			            $email_address_reply=$email_temp->reply_address;
			                    
			            $email_subject=$email_temp->subject;                
			            $email_message=$email_temp->message;
			                    
			            $email = $getOrederDetails['email'];//"php.developer@spaculus.com";
			            //$site_name = $site_data->site_name;
			            $email_to =$email;
			            $user_name =   $getOrederDetails['first_name']." ".$getOrederDetails['last_name'];
			            $email_message=str_replace('{break}','<br/>',$email_message);
			            $email_message=str_replace('{username}',$user_name,$email_message);
			            $email_message=str_replace('{orderno}',$getOrederDetails['order_number'],$email_message); 
			            $str=$email_message;
			            //echo $str;exit;
			            /** custom_helper email function **/
			                      if($email_temp->status=='active'){                  
			            email_send($email_address_from,$email_address_reply,$email_to,$email_subject,$str);
								  }
						 $email_template=$this->db->query("select * from ".$this->db->dbprefix('email_template')." where task='Order Completed Successfully Email To Admin'");
			            $email_temp=$email_template->row();             
			            $email_address_from=$email_temp->from_address;
			            $email_address_reply=$email_temp->reply_address;
			                    
			            $email_subject=$email_temp->subject;                
			            $email_message=$email_temp->message;
			                    
			             $email = getsuperadminemail();
			            //$site_name = $site_data->site_name;
			            $email_to =$email;
			            $user_name =   $getOrederDetails['first_name']." ".$getOrederDetails['last_name'];
			            $email_message=str_replace('{break}','<br/>',$email_message);
			            $email_message=str_replace('{username}',$user_name,$email_message);
			            $email_message=str_replace('{orderno}',$getOrederDetails['order_number'],$email_message); 
			            $str=$email_message;
			            //echo $str;exit;
			            /** custom_helper email function **/
			                                        
			          $getemail = explode(',', $email);
				if($email_temp->status=='active'){
				foreach($getemail as $r){
					email_send($email_address_from, $email_address_reply, $r, $email_subject, $str);
				}
				}
			}
			
			$data=array(
				'status'=>$order_status,
				);
			$this->db->where('order_id', $order_id);
			$this->db->update('order_master', $data);	
		//}		
		
		
    }

function getOrederDetails($ord_id)
	{
		$this->db->select('*');
		$this->db->from('order_master');
		$this->db->join('user_master','user_master.user_id=order_master.user_id');
		$this->db->where('order_master.order_id',$ord_id);
		$query = $this->db->get();

		//echo $this->db->last_query();die;
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		else
		{
			return ''; 
		}
	}
	
	function insert_paypal($id)
	{
		 $data_insert = array('bar_id'=>$id,
		                       'site_status'=>$this->input->post('site_status'),
							   'client_id'=>$this->input->post('client_id'),
							   'secret_key'=>$this->input->post('secret_key'));
			
		 					   
		 $this->db->insert('bar_payment_setting',$data_insert);	
	}
	
	function update_paypal($id)
	{
		 $data_insert = array('bar_id'=>$id,
		                       'site_status'=>$this->input->post('site_status'),
							   'vendor'=> $this->input->post('vendor'),	
							   'paypal_password' => $this->input->post('paypal_password'),
							   'paypal_username' => $this->input->post('paypal_username'));
			
		 					   
		$this->db->where('bar_id', $id);
		$this->db->update('bar_payment_setting', $data_insert);	
	}
	
	function get_store_result()
	{
	
		
		$this->db->select('product_name'); 
		$this->db->from('store a');
		$this->db->where('a.is_delete','0'); 
		$this->db->where('a.type','store'); 
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function getBarSpecialHoursByIDGroup($id,$days)
	{
		$this->db->select('bar_special_hours.*, beer_directory.beer_name, beer_directory.beer_slug, cocktail_directory.cocktail_slug, liquors.liquor_slug, cocktail_directory.cocktail_name, liquors.liquor_title');
		$this->db->from('bar_special_hours');
		$this->db->join('beer_directory','beer_directory.beer_id=bar_special_hours.sp_beer_id','left');
		$this->db->join('cocktail_directory','cocktail_directory.cocktail_id=bar_special_hours.sp_cocktail_id','left');
		$this->db->join('liquors','liquors.liquor_id=bar_special_hours.sp_liquor_id','left');
		if($days!='viewall')
		{
			$this->db->where(array('bar_special_hours.days'=>$days,'bar_special_hours.bar_id'=>$id));
		}
		else 
		{
			$this->db->where(array('bar_special_hours.bar_id'=>$id));
		}
		$this->db->group_by('rand');
		$query = $this->db->get();

		//echo $this->db->last_query();die;
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		else
		{
			return ''; 
		}
	}

function getBarSpecialHoursByID($rand)
	{
		$this->db->select('bar_special_hours.*, beer_directory.beer_name, beer_directory.beer_slug, cocktail_directory.cocktail_slug, liquors.liquor_slug, cocktail_directory.cocktail_name, liquors.liquor_title');
		$this->db->from('bar_special_hours');
		$this->db->join('beer_directory','beer_directory.beer_id=bar_special_hours.sp_beer_id','left');
		$this->db->join('cocktail_directory','cocktail_directory.cocktail_id=bar_special_hours.sp_cocktail_id','left');
		$this->db->join('liquors','liquors.liquor_id=bar_special_hours.sp_liquor_id','left');
		$this->db->where(array('bar_special_hours.rand'=>$rand));
		$query = $this->db->get();

		//echo $this->db->last_query();die;
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		else
		{
			return ''; 
		}
	}
}	
?>