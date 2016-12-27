<?php

class Forum_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	// --------------------------------------------------------------------

      /** 
       * function SaveForm()
       *
       * insert form data
       * @param $form_data - array
       * @return Bool - TRUE or FALSE
       */

	
	
    function forum_insert($data_insert = array())
	{

					 
	       $data_insert['date_created']=date('Y-m-d H:i:s');
		
			$this->db->insert('forum', $data_insert);
			$forum_id = mysql_insert_id();
			$inar = array('cat_id'=>$forum_id,
		              'category'=>'forum',
					  'date'=>date('Y-m-d H:i:s'));
		$this->db->insert('sitemap', $inar);

	}
	
	function forum_update($data_insert = array())
	{
		
	 $data_insert['date_created']=date('Y-m-d H:i:s');
 	 $forum_id = $data_insert['forum_id'];
	 unset($data_insert['forum_id']);		
	
		$this->db->where("forum_id",$forum_id);
		$this->db->update('forum',$data_insert);
		
	}
	
	function get_total_forum_count()
	{
	 return $this->db->count_all('forum where master_id=0 ');
	}
	
	function get_forum_count($master_id)
	{
		//echo $master_id; die;	
	 return $this->db->count_all('forum where master_id ='.$master_id);
		//echo $this->db->last_query(); die;
	}
	
	function get_forum_result($offset=0, $limit=0)
	{
		$this->db->select('f.*,c.forum_category_name');
		$this->db->from('forum f');
		$this->db->join('forum_category c','f.forum_category=c.forum_category_id');
	    $this->db->where(array("f.master_id"=>'0'));
	   //$this->db->order_by("forum_id","desc");
	 $this->db->limit($limit,$offset);
	   $query = $this->db->get();
	    //echo $query = $this->db->last_query(); die;	     
	   	     if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	function get_one_forum($id=0)
	{
	   $query = $this->db->get_where('forum',array("forum_id"=>$id));
		//return $query->row_array();
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return 0;
	}
	
	
	function get_topic($id=0) {
		$this->db->select('f.*,u.first_name,u.last_name');
		$this->db->from('forum f');
		$this->db->join("user_master u","f.user_id = u.user_id","left");
		$this->db->where(array('f.forum_id'=>$id));
		//$query = $this->db->get_where('forum',array('forum_id'=>$id));
		$query=$this->db->get();
		//echo $this->db->last_query(); die;
		return $query->row_array();
	
	}
	function get_list($topic_id,$master_id = 0){
		
		if($master_id == 0)
		{
			$main_id = $topic_id;
		}
		else
		{
			$main_id = $master_id;
		}
		
		$qry = $this->db->query("select * from ".$this->db->dbprefix('forum')." where 1=1 and (master_id = '".$main_id."')  order by 
		forum_id asc
		");
		
		if ($qry->num_rows() > 0) {
			return $qry->result_array();
		}
		return 0;
	}
	
	function reply_insert(){
	$data = array(
			'forum_decription' =>  $this->input->post('description'),
			'master_id' => $this->input->post('message_id'),
			'admin_id'=>$this->input->post('admin_id'),
			'date_created' => date("Y-m-d H:i:s")
		);		
		//print_r($data); die;
		$this->db->insert('sss_forum',$data);
        
           //Log Entry    
           // $data_log = array("activity_name" => "LOG_REPLY_MESSAGE");
            //maintain_log($data_log); 
		
	}
	
	function get_total_search_forum_count($option,$keyword)
	{
	  
	
		//$this->db->select('sss_forum *');
		$this->db->from('forum');
		if($option=="topic_name")
		{
				   $this->db->like("topic_name",$keyword,'after');
				   
				 /*  if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('topic_name',$val);
					}	
				}*/
				
				
		}
		if($option=="status")
		{
				   $this->db->like("status",$keyword);
				   
				   /*if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('status',$val);
					}	
				}*/
				
				
		}
		
		$this->db->order_by("forum_id", "desc"); 
		$query = $this->db->get();
		//echo $query = $this->db->last_query(); die;
		return $query->num_rows();
	}
	
	function get_search_forum_result($option,$keyword,$offset, $limit)
	{
	    $keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
	   
		$this->db->select('f.*,c.forum_category_id,c.forum_category_name');
		$this->db->from('forum f');
		$this->db->join('forum_category c','f.forum_category=c.forum_category_id');
		
				if($option=="topic_name")
				{
				   $this->db->like("topic_name",$keyword,'after');
				   
				   /*if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('topic_name',$val);
					}	
				  }*/
				}
				if($option=="status")
				{
				   $this->db->like("status",$keyword,'after');
				   
				 /*  if(substr_count($keyword,' ')>=1)
			      {
				     $ex=explode(' ',$keyword);
				
					foreach($ex as $val)
					{
						$this->db->like('status',$val);
					}	
				  }*/
				}
				
		$this->db->order_by("forum_id", "desc"); 
		$this->db->limit($limit,$offset);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	
	}
	
	function get_parent_sub_category($catid)
	{
	    $qry=$this->db->get_where('category',array('parent_category_id'=>$catid,'status'=>1));
		
		if($qry->num_rows()>0)
		{
		   return $qry->result();
		}
		
		return 0;
	}
	
	
	function get_forum_category()
	{
		 $qry=$this->db->get_where('forum_category',array('status'=>"active"));
		
		if($qry->num_rows()>0)
		{
		   return $qry->result();
		}
		
		return 0;
	}
	
	
}
?>
