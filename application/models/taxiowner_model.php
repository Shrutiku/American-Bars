<?php
class Taxiowner_model extends CI_Model 
{
	function Taxiowner_model()
    {
        parent::__construct();	
    } 	
	
	function get_total_taxi_owner_count($keyword = '', $alpha ='',$taxi_title='',$state='',$city='',$zipcode='')
	{
		$en='';
		$en1='';
		
		// echo $keyword;
		// die;
		$getstatename = getstatenamebycode($state);
		$getstatename1 = getcodebystate($state);
		$this->db->select("*");
		$this->db->from("taxi_directory");
		$this->db->join("user_master",'user_master.user_id=taxi_directory.taxi_owner_id','left');
		$this->db->where('taxi_directory.status','active');
		$this->db->where('taxi_directory.is_deleted','no');
		
		//$this->db->where('user_type','taxi_owner');
		if($alpha != "" && $alpha != "no")
		{
		   $this->db->like("sss_taxi_directory.taxi_company",$alpha,"after");
		}
		
		if($taxi_title != '0' && $taxi_title != "")
		{
			
			$this->db->like("taxi_company",$taxi_title);
			//$this->db->or_like("zipcode",$bar_title);
			//$this->db->or_like("bar_desc",$bar_title);
		}
		if($state != '0' && $state != "")
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
		if($city != '0' && $city != "")
		{
			$this->db->like("city",$city);
		}
		 if($zipcode != '0' && $zipcode != "")
		 {
			 $this->db->like("cmpn_zipcode",$zipcode);
		 }
		
		
		
		if($keyword != '0'  && $keyword != "")
		{
			//$this->db->where('(`cocktail_name` LIKE  \'%'.mysql_real_escape_string($keyword).'%\')', NULL, 'FALSE');	 	
			
			$en12 = '';
			$en34 = '';
			//$this->db->like("bar_title",$bar_title);
			//$this->db->or_like("zipcode",$bar_title);
			//$this->db->or_like("bar_desc",$bar_title);
			
			$en12.=" `taxi_company` like ('%".mysql_real_escape_string($keyword)."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
											  
				  	foreach($ex as $val)
					{
						//echo strlen($val);
						$en34.=" `taxi_company` like ('".mysql_real_escape_string($val)."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en12.substr($en34, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en12, 0 ,-3).')')  ;
		}
		}
		$qry = $this->db->get();		
		return $qry->num_rows();
	}
	
	function getUserByID($id)
	{
		$this->db->select('*,taxi_directory.address');		
		$this->db->from('taxi_directory');
		$this->db->join('user_master','taxi_directory.taxi_owner_id=user_master.user_id','left');
		$this->db->where('taxi_directory.taxi_id',$id);
		$qry = $this->db->get();
		if($qry->num_rows()>0)
		{
			 return $qry->row_array();
		}
		return 0;
	}
	function get_taxi_owner_result($offset = 0,$limit = 0,$sort_by= '',$sort_type = '',$keyword = 0,$alpha ='',$taxi_title='',$state='',$city='',$zipcode='')
	{
		$this->db->_protect_identifiers=false; 
	
		$en='';
		$en1='';
		$getstatename = getstatenamebycode($state);
		$getstatename1 = getcodebystate($state);
		/*$this->db->select("v.*,c.category_name,u.first_name,u.last_name");
		$this->db->from("bars v");
		$this->db->join("category c","c.category_id = v.bar_category_id");
		$this->db->join("user_master u","u.user_id = v.user_id","LEFT");*/
		$this->db->select("*,taxi_directory.address");
		$this->db->from("taxi_directory");
		$this->db->join("user_master",'user_master.user_id=taxi_directory.taxi_owner_id','left');
		$this->db->where('taxi_directory.status','active');
		$this->db->where('taxi_directory.is_deleted','no');
		
		//$this->db->where('user_type','taxi_owner');
		if($alpha != "" && $alpha != "no")
		{
		   $this->db->like("sss_taxi_directory.taxi_company",$alpha,"after");
		}
		
		if($taxi_title != '0' && $taxi_title != "")
		{
			
			$this->db->like("taxi_company",$taxi_title);
			//$this->db->or_like("zipcode",$bar_title);
			//$this->db->or_like("bar_desc",$bar_title);
		}
		if($state != '0' && $state != "")
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
		if($city != '0' && $city != "")
		{
			$this->db->like("city",$city);
		}
		 if($zipcode != '0' && $zipcode != "")
		 {
			 $this->db->like("cmpn_zipcode",$zipcode);
		 }
		if($keyword != '0'  && $keyword != "")
		{
			//$this->db->where('(`cocktail_name` LIKE  \'%'.mysql_real_escape_string($keyword).'%\')', NULL, 'FALSE');	 	
			
			$en12 = '';
			$en34 = '';
			//$this->db->like("bar_title",$bar_title);
			//$this->db->or_like("zipcode",$bar_title);
			//$this->db->or_like("bar_desc",$bar_title);
			
			$en12.=" `taxi_company` like ('%".mysql_real_escape_string($keyword)."%') OR";
			//$en.=" `user_master.last_name` like ('%".$keyword."%') OR";
		
		if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
											  
				  	foreach($ex as $val)
					{
						//echo strlen($val);
						$en34.=" `taxi_company` like ('".mysql_real_escape_string($val)."%') OR";
						//$en1.=" `user_master.last_name` like ('%".$val."%')";
					}	
					$this->db->where('('.$en12.substr($en34, 0 ,-3).')')  ;
				}
		else {
			$this->db->where('('.substr($en12, 0 ,-3).')')  ;
		}
		}
		
	//	$this->db->order_by($sort_by,$sort_type);
		
		if($keyword!='' && $keyword!='0' && $keyword!='1V1')
		{
			
		
			//echo $sort_type;
			if($sort_type=='')
			{
			//	echo "SDa";
		$this->db->order_by('CASE WHEN taxi_company like "'.$keyword.'" THEN 0
            WHEN taxi_company like "'.$keyword.' %" THEN 1
           WHEN taxi_company like "%'.$keyword .'" THEN 2
           ELSE taxi_company 
      END',NULL,FALSE);
			}
			else
			{
				if($sort_by && $sort_type)
				{
				$this->db->order_by($sort_by,$sort_type);
				}
				
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
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		
		
		if($qry->num_rows()>0)
		{
			 return $qry->result();
		}
		
		
		return 0;
	}
	
	function gettaxibysearch($state='',$city='',$zipcode='',$offset='',$limit='')
	{
		
		$en = '';
		//$getstatename = getstatenamebycode($state);
		//$getstatename1 = getcodebystate($state);
		
		$this->db->select("*,taxi_directory.address");
		$this->db->from("taxi_directory");
		$this->db->join("user_master",'user_master.user_id=taxi_directory.taxi_owner_id','left');
		$this->db->where('taxi_directory.status','active');
		$this->db->where('taxi_directory.is_deleted','no');
		
		if($state != '0' && $state != "")
		{
				$en.=" ((`sss_taxi_directory`.`cmpn_zipcode` = '$zipcode') OR (`sss_taxi_directory`.`city` like ('%".$city."%') AND `sss_taxi_directory`.`state` like ('%".$state."%')) )  ";
			    $this->db->where('('.substr($en, 0 ,-3).'))')  ;
		}
		
	
		
		//$this->db->order_by('taxi_directory.cmpn_zipcode','ASC');
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		
		//echo $this->db->last_query();
		//die;
		if($qry->num_rows()>0)
		{
			 return $qry->result();
		}
		
		
		return "";
		
		
		
	}
	function auto_suggest_taxi($q){
		$this->db->like('first_name',$q);
		$this->db->select('first_name,last_name,user_id');
		$this->db->from('user_master');
		$this->db->where('status','active');
		$this->db->where('user_type','taxi_owner');
		$this->db->where('is_deleted','no');
		$query = $this->db->get();
		
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
		return 0;
	}
	}	
?>