<?php
 class Video_model extends CI_Model 
{

	function Video_model()
    {
        parent::__construct();	
    } 
	
	
	function get_total_video_count($type = 0,$keyword = 0)
	{
		$this->db->select("*");
		$this->db->from("video v");
		
		if($type != '0' || $keyword != '0')
		{
		  $this->db->join("category c","c.category_id = v.video_category_id");
		  $this->db->join("user_master u","u.user_id = v.user_id","LEFT");
		  
		    if($type == "author" &&  $keyword != '0')
			{
				$this->db->like("u.first_name",$keyword,"after");
			}
			else if($type == "video_title" &&  $keyword != '0')
			{
				$this->db->like("v.video_title",$keyword,"after");
			}
			else if($type == "category" &&  $keyword != '0')
			{
				$this->db->like("c.category_name",$keyword,"after");
				$this->db->where("c.category_type","video");
			}
			
			else
			{
				$this->db->like("v.video_title",$keyword,"after");
				$this->db->or_like("v.video_title",$keyword,"after");
				$this->db->or_like("c.category_name",$keyword,"after");
				$this->db->where("c.category_type","video");
			}
		}
		
		$qry = $this->db->get();
		
		return $qry->num_rows();
	}
	
	function get_video_result($offset = 0,$limit = 0,$sort_by= '',$sort_type = '',$type = 0,$keyword = 0)
	{
		$this->db->select("v.*,c.category_name,u.first_name,u.last_name");
		$this->db->from("video v");
		$this->db->join("category c","c.category_id = v.video_category_id");
		$this->db->join("user_master u","u.user_id = v.user_id","LEFT");
		
		
		if($type != '0' || $keyword != '0')
		{
			
		    if($type == "author" &&  $keyword != '0')
			{
				$this->db->like("u.first_name",$keyword,"after");
			}
			else if($type == "video_title" &&  $keyword !='0')
			{
				$this->db->like("v.video_title",$keyword,"after");
			}
			else if($type == "category" &&  $keyword != '0')
			{
				$this->db->like("c.category_name",$keyword,"after");
				$this->db->where("c.category_type","video");
			}
			
			else
			{
				$this->db->like("v.video_title",$keyword,"after");
				$this->db->or_like("v.video_title",$keyword,"after");
				$this->db->or_like("c.category_name",$keyword,"after");
				$this->db->where("c.category_type","video");
			}
		}
		
		$this->db->order_by($sort_by,$sort_type);
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		
		if($qry->num_rows()>0)
		{
			 return $qry->result();
		}
		
		
		return 0;
	}
	
	
	 function get_one_video($id = 0)
	{
		$this->db->select("v.*,c.category_name,u.first_name,u.last_name");
		$this->db->from("video v");
		$this->db->join("category c","c.category_id = v.video_category_id");
		$this->db->join("user_master u","u.user_id = v.user_id","LEFT");
		$this->db->where("v.video_id",$id);
		
		$qry = $this->db->get();
		
		if($qry->num_rows()>0)
		{
			 return $qry->row_array();
		}
		
		
		return 0;
	}
	
	function get_video_comment($vid = 0)
	{
		$this->db->order_by("date_added");
		$this->db->join("user_master","user_master.user_id = video_comment.user_id");
		$qry = $this->db->get_where("video_comment",array("video_id"=>$vid,"video_comment.status"=>"active","video_comment.is_deleted"=>"no"));
		
		if($qry->num_rows()>0)
		{
			  return $qry->result();
		}
		
		return 0;
	}
	
	
	function insert_comment($data_insert = array())
	{
		$this->db->insert("video_comment",$data_insert);
	}
	
}	