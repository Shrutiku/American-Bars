<?php
 class Article_model extends CI_Model 
{

	function Article_model()
    {
        parent::__construct();	
    } 
	
	
	function get_total_article_count($type = 0,$keyword = 0)
	{
		$this->db->select("*");
		$this->db->from("article v");
		
		if($type != '0' || $keyword != '0')
		{
		  $this->db->join("category c","c.category_id = v.article_category_id");
		  $this->db->join("user_master u","u.user_id = v.user_id","LEFT");
		  
		    if($type == "author" &&  $keyword != '0')
			{
				$this->db->like("u.first_name",$keyword,"after");
			}
			else if($type == "article_title" &&  $keyword != '0')
			{
				$this->db->like("v.article_title",$keyword,"after");
			}
			else if($type == "category" &&  $keyword != '0')
			{
				$this->db->like("c.category_name",$keyword,"after");
				$this->db->where("c.category_type","article");
			}
			
			else
			{
				$this->db->like("v.article_title",$keyword,"after");
				$this->db->or_like("v.article_title",$keyword,"after");
				$this->db->or_like("c.category_name",$keyword,"after");
				$this->db->where("c.category_type","article");
			}
		}
		
		$qry = $this->db->get();
		
		return $qry->num_rows();
	}
	
	function get_article_result($offset = 0,$limit = 0,$sort_by= '',$sort_type = '',$type = 0,$keyword = 0)
	{
		$this->db->select("v.*,c.category_name,u.first_name,u.last_name");
		$this->db->from("article v");
		$this->db->join("category c","c.category_id = v.article_category_id");
		$this->db->join("user_master u","u.user_id = v.user_id","LEFT");
		
		
		if($type != '0' || $keyword != '0')
		{
			
		    if($type == "author" &&  $keyword != '0')
			{
				$this->db->like("u.first_name",$keyword,"after");
			}
			else if($type == "article_title" &&  $keyword !='0')
			{
				$this->db->like("v.article_title",$keyword,"after");
			}
			else if($type == "category" &&  $keyword != '0')
			{
				$this->db->like("c.category_name",$keyword,"after");
				$this->db->where("c.category_type","article");
			}
			
			else
			{
				$this->db->like("v.article_title",$keyword,"after");
				$this->db->or_like("v.article_title",$keyword,"after");
				$this->db->or_like("c.category_name",$keyword,"after");
				$this->db->where("c.category_type","article");
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
	
	
	 function get_one_article($id = 0)
	{
		$this->db->select("v.*,c.category_name,u.first_name,u.last_name");
		$this->db->from("article v");
		$this->db->join("category c","c.category_id = v.article_category_id");
		$this->db->join("user_master u","u.user_id = v.user_id","LEFT");
		$this->db->where("v.article_id",$id);
		
		$qry = $this->db->get();
		
		if($qry->num_rows()>0)
		{
			 return $qry->row_array();
		}
		
		
		return 0;
	}
	
	function get_article_comment($vid = 0)
	{
		$this->db->order_by("date_added");
		$this->db->join("user_master","user_master.user_id = article_comment.user_id");
		$qry = $this->db->get_where("article_comment",array("article_id"=>$vid,"article_comment.status"=>"active","article_comment.is_deleted"=>"no"));
		
		if($qry->num_rows()>0)
		{
			  return $qry->result();
		}
		
		return 0;
	}
	
	
	function insert_comment($data_insert = array())
	{
		$this->db->insert("article_comment",$data_insert);
	}
	
}	