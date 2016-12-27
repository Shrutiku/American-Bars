<?php
 class Forum_model extends CI_Model 
{

	function Forum_model()
    {
        parent::__construct();	
    } 
	
	
	function get_total_forum_count($type = 0,$keyword = 0)
	{
		//echo $type; die;
		$this->db->select("*");
		$this->db->from("forum v");
		$this->db->where("v.status",'active');
		if($type != '0' || $keyword != '0')
		{
			
		    if($type != "" && $type != "0" &&  $keyword != '0')
			{
				$this->db->where("v.forum_category",$type);
				$this->db->or_like("v.topic_name",$keyword,"after");
			}
			
		}
		
		$qry = $this->db->get();
		
		return $qry->num_rows();
	}
	
	function get_forum_popular()
	{
		$this->db->select("v.*,u.first_name,u.last_name,u.profile_image");
		$this->db->from("forum v");
		$this->db->join("user_master u","u.user_id = v.user_id","LEFT");
		$this->db->where("v.status",'active');
		$this->db->where("view >",0);
		$this->db->order_by('view','desc');
		$this->db->limit(5);
		$qry = $this->db->get();
		if($qry->num_rows()>0)
		{
			 return $qry->result();
		}
		
		
		return 0;
	}
	function get_forum_result($offset = 0,$limit = 0,$sort_by= '',$sort_type = '',$type = 0,$keyword = 0)
	{
		//echo "hell";
		//echo $keyword; die;
		$this->db->select("v.*,u.first_name,u.last_name,u.profile_image");
		$this->db->from("forum v");
		//$this->db->join("category c","c.category_id = v.forum_category_id");
		$this->db->join("user_master u","u.user_id = v.user_id","LEFT");
		$this->db->where("v.status",'active');
		
		if($type != '0' || $keyword != '0')
		{
			
				$this->db->where("v.forum_category",$type);
				$this->db->like("v.topic_name",$keyword,"after");
			
		}
		//echo $sort_by;
		//echo $sort_type; die;
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
	
	
	 function get_one_forum($id = 0)
	{
		$this->db->select("v.*,u.first_name,u.last_name,u.profile_image");
		$this->db->from("forum v");
		//$this->db->join("category c","c.category_id = v.forum_category_id");
		$this->db->join("user_master u","u.user_id = v.user_id","LEFT");
		$this->db->where("v.forum_id",$id);
		
		$qry = $this->db->get();
		
		if($qry->num_rows()>0)
		{
			 return $qry->row_array();
		}
		
		
		return 0;
	}
	
	function get_category()
	{
		$qry = $this->db->get_where("forum_category",array("status"=>"active"));
		
		
		if($qry->num_rows()>0)
		{
			  return $qry->result();
		}
		
		return 0;
	}
	function get_forum_comment($vid = 0,$offset="",$limit="")
	{
		$this->db->limit($limit,$offset);
		$this->db->order_by("date_added");
		$this->db->join("user_master","user_master.user_id = forum_comment.user_id");
		$qry = $this->db->get_where("forum_comment",array("forum_id"=>$vid,"forum_comment.status"=>"active","forum_comment.is_deleted"=>"no"));
		
		if($qry->num_rows()>0)
		{
			  return $qry->result();
		}
		
		return 0;
	}
	
	function get_forum_comment_count($vid = 0)
	{
		$this->db->order_by("date_added");
		$this->db->join("user_master","user_master.user_id = forum_comment.user_id");
		$qry = $this->db->get_where("forum_comment",array("forum_id"=>$vid,"forum_comment.status"=>"active","forum_comment.is_deleted"=>"no"));
		
		if($qry->num_rows()>0)
		{
			  return $qry->num_rows();
		}
		
		return 0;
	}
	
	
	function insert_comment($data_insert = array())
	{
		$this->db->insert("forum_comment",$data_insert);
		return mysql_insert_id();
	}
	
	function suggestforum_insert()
	{
		
			$data = array(
				'topic_name' => $this->input->post('topic_name'),
				'forum_category' => $this->input->post('forum_category'),
				'forum_decription' => $this->input->post('forum_decription'),
				'status' => 'pending',
				'user_id' => get_authenticateUserID(),
				'date_created' => date('Y-m-d H:i:s'),
			);
			
			$this->db->insert('forum',$data);
			
			
			$news_id = mysql_insert_id();
		$inar = array('cat_id'=>$news_id,
		              'category'=>'forum',
					  'date'=>date('Y-m-d H:i:s'));
		$this->db->insert('sitemap', $inar);
	}
}	