<?php
 class Blog_model extends CI_Model 
{

	function Blog_model()
    {
        parent::__construct();	
    } 
	
	
	function get_total_blog_count($type = 0,$keyword = 0)
	{
		$this->db->select("*");
		$this->db->from("blog v");
		$this->db->where("v.status",'active');
		
		if($keyword != '0')
		{
		  //$this->db->join("category c","c.category_id = v.blog_category_id");
		  $this->db->join("user_master u","u.user_id = v.user_id","LEFT");
		  
				$this->db->like("v.blog_title",$keyword);
		}
		
		$qry = $this->db->get();
		
		return $qry->num_rows();
	}
	
	function get_blog_result($offset = 0,$limit = 0,$sort_by= '',$sort_type = '',$type = 0,$keyword = 0)
	{
		
		//echo $keyword; die;
		$this->db->select("v.*,u.first_name,u.last_name,u.profile_image");
		$this->db->from("blog v");
		$this->db->where("v.status",'active');
		//$this->db->join("category c","c.category_id = v.blog_category_id");
		$this->db->join("user_master u","u.user_id = v.user_id","LEFT");
		
		
		if($keyword != '0')
		{
			
				$this->db->like("v.blog_title",$keyword);
		}
		
		$this->db->order_by($sort_by,$sort_type);
		$this->db->limit($limit,$offset);
		$qry = $this->db->get();
		//echo $this->db->last_query(); die;
		if($qry->num_rows()>0)
		{
			 return $qry->result();
		}
		
		
		return 0;
	}
	
	
	 function get_one_blog($id = 0)
	{
		$this->db->select("v.*,u.first_name,u.last_name");
		$this->db->from("blog v");
		//$this->db->join("category c","c.category_id = v.blog_category_id");
		$this->db->join("user_master u","u.user_id = v.user_id","LEFT");
		$this->db->where("v.blog_id",$id);
		
		$qry = $this->db->get();
		
		if($qry->num_rows()>0)
		{
			 return $qry->row_array();
		}
		
		
		return 0;
	}
	
	
	
	
	function insert_comment($data_insert = array())
	{
		$this->db->insert("blog_comment",$data_insert);
		return mysql_insert_id();
		
	}
	
	function get_blog_comment_count($vid = 0)
	{
		$this->db->order_by("date_added",'desc');
		$this->db->join("user_master","user_master.user_id = blog_comment.user_id",'left');
		$qry = $this->db->get_where("blog_comment",array("blog_id"=>$vid,"blog_comment.status"=>"active","blog_comment.is_deleted"=>"no"));
		
		
		if($qry->num_rows()>0)
		{
			  return $qry->num_rows();
		}
		
		return 0;
	}
	function get_blog_comment($vid = 0,$offset="",$limit="")
	{
		$this->db->limit($limit,$offset);
		$this->db->order_by("date_added",'desc');
		$this->db->join("user_master","user_master.user_id = blog_comment.user_id",'left');
		$qry = $this->db->get_where("blog_comment",array("blog_id"=>$vid,"blog_comment.status"=>"active","blog_comment.is_deleted"=>"no"));
		
		if($qry->num_rows()>0)
		{
			  return $qry->result();
		}
		
		return 0;
	}
	function insert_subcomment($data_insert = array())
	{
		
		$data_insert["user_id"] = $this->session->userdata("user_id");
		$data_insert["status"] = "active";
		$data_insert["date_added"] = date("Y-m-d H:i:s");
		$data_insert["is_deleted"] = "0";
	
		$this->db->insert("blog_comment",$data_insert);
		
		return mysql_insert_id();
	}
	function get_blog_subcomments($id=0){
		$this->db->select('b.*,u.profile_image,u.first_name,u.last_name');
		$this->db->from('blog_comment b');		
		$this->db->join('user_master u','u.user_id=b.user_id');
		//$CI->db->join('beer_comment bc','bc.master_comment_id=b.beer_comment_id');
		$this->db->where('b.master_comment_id!=','0',false);
		$this->db->where('b.blog_id',$id);
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
		}
	}
	function sub_comment_remove($blog_comment_id){
		$this->db->where('blog_comment_id', $blog_comment_id);
		$this->db->delete('blog_comment'); 
	}
	function get_blog_recent()
	{
		$this->db->select("v.*,u.first_name,u.last_name");
		$this->db->from("blog v");
		$this->db->join("user_master u","u.user_id = v.user_id","LEFT");
		$this->db->where('v.status','active');
		$this->db->order_by('date_added','desc');
		$this->db->limit(5);
		$qry = $this->db->get();
		//echo $this->db->last_query(); die;
		if($qry->num_rows()>0)
		{
			 return $qry->result();
		}
		
		
		return 0;
	}
}	