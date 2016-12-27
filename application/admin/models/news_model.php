<?php
class News_model extends CI_Model {
	
    function News_model()
    {
        parent::__construct();	
    }   
	
	/*check unique news 
	 * param : newsname, paitent_id(if in edit mode)
	 */
	function news_unique($str)
	{
		if($this->input->post('news_id'))
		{
			$query = $this->db->get_where('news',array('news_id'=>$this->input->post('news_id')));
			$res = $query->row_array();
			$email = $res['news_title'];
			
			$query = $this->db->query("select news_title from ".$this->db->dbprefix('news')." where news_title = ".mysql_real_escape_string($str)." and news_id!='".$this->input->post('news_id')."'");
		}else{
			$query = $this->db->query("select news_title from ".$this->db->dbprefix('news')." where news_title = ".mysql_real_escape_string($str)."");
		}
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/* check unique email
	 * param : email, news id(if in edit mode)
	 */
	function news_email_unique($str)
	{
		if($this->input->post('news_id'))
		{
			$query = $this->db->get_where('news',array('news_id'=>$this->input->post('news_id')));
			$res = $query->row_array();
			$email = $res['email'];
			
			$query = $this->db->query("select email from ".$this->db->dbprefix('news')." where email = '$str' and news_id!='".$this->input->post('news_id')."'");
		}else{
			$query = $this->db->query("select email from ".$this->db->dbprefix('news')." where email = '$str'");
		}
		
		
		
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/* add news detail in db
	 * 
	 */	
	function news_insert()
	{
		 $slug=getNewsSlug($this->input->post('news_title'));	
		$data["news_title"] = $this->input->post('news_title');
		$data["news_desc"] = $this->input->post('news_desc');
		$data["user_id"] = get_authenticateadminID();
		$data["slug"] = $slug;
		$data["author_name"] = 'admin';
		$data["news_category"] =$this->input->post('news_category');
		$data["status"] = $this->input->post('status');
		$this->db->insert('news',$data);
		$news_id = mysql_insert_id();
		$inar = array('cat_id'=>$news_id,
		              'category'=>'news',
					  'date'=>date('Y-m-d H:i:s'));
		$this->db->insert('sitemap', $inar);
	}
	
	/* news update  */
	function news_update()
	{
		 $slug=getNewsSlug($this->input->post('news_title'),$this->input->post('news_id'));	
		$data["news_title"] = $this->input->post('news_title');
		$data["news_desc"] = $this->input->post('news_desc');
		$data["user_id"] = get_authenticateadminID();
		$data["slug"] = $slug;
		$data["author_name"] = 'admin';
		$data["news_category"] =$this->input->post('news_category');
		$data["status"] = $this->input->post('status');
				
		$this->db->where('news_id',$this->input->post('news_id'));
		$this->db->update('news',$data);
	}
	
	/* get news info * param : news id */		
	function get_one_news($id)
	{
		$query = $this->db->get_where('news',array('news_id'=>$id));
		return $query->row_array();
	}	
	
	/* get total newss
	 * param :doctor id
	 */
	function get_total_news_count()
	{
		$this->db->select('*');
		$this->db->from('news');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	
	/* get news doctor wise
	 * param : doctor id
	 */
	function get_news_result($offset,$limit)
	{
		$this->db->select('*');
		$this->db->from('news');
		$this->db->limit($limit,$offset);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return '';
	}
	
	/* search news doctor wise
	 * param:doctor id,option ,keyword
	 */	
	function get_total_search_news_count($option,$keyword)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		
		$this->db->select('news.*');
		$this->db->from('news');
		
		
		if($option=='news_title')
		{
			$this->db->like('news_title',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('news_title',$val);
				// }	
			// }

		}

      /* if($option=='type')
		{
			$this->db->like('news_type',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('news_type',$val);
				}	
			}

		}
		
		
		if($option=='producer')
		{
			$this->db->like('producer',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('producer',$val);
				}	
			}

		}
		
		
		if($option=='city_produced')
		{
			$this->db->like('city_produced',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('city_produced',$val);
				}	
			}

		}*/
		
	//	$this->db->order_by('news_id','desc');
		$query = $this->db->get();	
		return $query->num_rows();
	}	
	
	/* search news doctor wise * param:doctor id,option ,keyword  */		
	function get_search_news_result($option,$keyword,$offset, $limit)
	{
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('news.*');
		$this->db->from('news');
		
		if($option=='news_title')
		{
			$this->db->like('news_title',$keyword,'after');
			
			// if(substr_count($keyword,' ')>=1)
			// {
				// $ex=explode(' ',$keyword);
// 				
				// foreach($ex as $val)
				// {
					// $this->db->like('news_title',$val);
				// }	
			// }

		}

       /*if($option=='type')
		{
			$this->db->like('news_type',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('news_type',$val);
				}	
			}

		}
		
		
		if($option=='producer')
		{
			$this->db->like('producer',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('producer',$val);
				}	
			}

		}
		
		
		if($option=='city_produced')
		{
			$this->db->like('city_produced',$keyword);
			
			if(substr_count($keyword,' ')>=1)
			{
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val)
				{
					$this->db->like('city_produced',$val);
				}	
			}

		}*/

		$this->db->order_by('news_id','desc');
		$this->db->limit($limit,$offset);
		
		$query = $this->db->get();
		
		
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}	  
}
?>