<?php
class Category_model extends CI_Model {
	
    function Category_model() {
        parent::__construct();	
    }   
	
	// Use :This function use for check UserName of admin .
	// Param :username
	// Return :Boolean
	function category_name_unique($str) {
		if($this->input->post('category_id')) {
			$query = $this->db->get_where('category',array('category_id'=>$this->input->post('category_id')));
			$res = $query->row_array();
			$email = $res['category_name'];
			
			$query = $this->db->query("select category_name from ".$this->db->dbprefix('category')." where category_name = '$str' and category_id!='".$this->input->post('category_id')."'");
		}else{
			$query = $this->db->query("select category_name from ".$this->db->dbprefix('category')." where category_name = '$str'");
		}
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	
	

	// Use :This function use for Update admin Detail.
	// Param :Post Data
	// Return :'N/A'
	
	function category_insert(){
		$data = array(
			'category_name' => $this->input->post('category_name'),
			'category_type' => $this->input->post('category_type'),
			'status' => $this->input->post('status'),
			'created_on' => date('Y-m-d H:i:s')
		);		
		//print_r($data); die;
		$this->db->insert('category',$data);
        //echo "chi"; die;
         //header('Location: ' . $_SERVER['HTTP_REFERER']);
         //Log data
         //$data_log = array("activity_name" => "LOG_UPDATE_DOCTOR_CATEGORY");
         //maintain_log($data_log);
		
		
	}
	
	function category_update(){
		$data = array(
			'category_name' => $this->input->post('category_name'),
			'status' => $this->input->post('status'),
			'updated_on' => date('Y-m-d H:i:s')
		
		);		
		$this->db->where('category_id',$this->input->post('category_id'));
		$this->db->update('category',$data);
        
         //Log data
         $data_log = array("activity_name" => "LOG_UPDATE_DOCTOR_CATEGORY");
         maintain_log($data_log);
		
		
	}
	

	// Use :This function use for get one admin detail.
	// Param :Admin Id
	// Return :array
	function get_one_category($id)
	{
		$query = $this->db->get_where('category',array('category_id'=>$id));
		return $query->row_array();
	}	
	
	// Use :This function use for count all admin.
	// Param :'N/A'
	// Return :Number
	
	function get_total_category_count($type)
	{
		
		$query=$this->db->get_where('category',array('category_type'=>$type));
		return $query->num_rows();
		
	}
	
	// Use :This function use for get admin detail by limit and offset.
	// Param :offset,limit
	// Return :array of object
	
	function get_category_result($type,$offset,$limit) {
		$this->db->where('category_type',$type);
		$this->db->order_by('category_id','asc');
		$query = $this->db->get('category',$limit,$offset);
	
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	// Use :This function use for Count all admin login history.
	// Param :'N/A'
	// Return :number
	
	function get_total_adminlogin_count() {
		$query = $this->db->query("select a.username,a.password,a.admin_type,a.email,ad.* from ".$this->db->dbprefix('admin_login')." ad left join ".$this->db->dbprefix('admin')." a on ad.category_id=a.category_id order by ad.login_id desc");
		return $query->num_rows();
	}
	
	// Use :This function use for get admin login history by limit and offset.
	// Param :offset,limit
	// Return :array of object
	
	function get_adminlogin_result($offset, $limit) {
		$query = $this->db->query("select a.username,a.password,a.admin_type,a.email,ad.* from ".$this->db->dbprefix('admin_login')." ad left join ".$this->db->dbprefix('admin')." a on ad.category_id=a.category_id order by ad.login_id desc LIMIT ".$limit." Offset ".$offset);
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	// Use :This function use for count admin by Filder.
	// Param :option,keyword
	// Return :number
	function get_total_search_category_count($type,$option,$keyword) {
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('category.*');
		$this->db->from('category');
		
		if($option=='category_name') {
			$this->db->like('category_name',$keyword);
			
			if(substr_count($keyword,' ')>=1) {
				$ex=explode(' ',$keyword);
				foreach($ex as $val) {
					$this->db->like('category_name',$val);
				}	
			}
		}
		
		$this->db->order_by('category_id','asc');
		$this->db->where('category_type',$type);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	// Use :This function use for get admin detail by filter and limit and offset.
	// Param :offset,limit,option,keyword
	// Return :array of object
	
	function get_search_category_result($type,$option,$keyword,$offset, $limit) {
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('category.*');
		$this->db->from('category');
		
		if($option=='category_name') {
			$this->db->like('category_name',$keyword);
			
			if(substr_count($keyword,' ')>=1) {
				$ex=explode(' ',$keyword);
				foreach($ex as $val) {
					$this->db->like('category_name',$val);
				}	
			}
		}
		
		$this->db->order_by('category_id','asc');
		$this->db->where('category_type',$type);
		$this->db->limit($limit,$offset);
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		if ($query->num_rows() > 0) {	
			return $query->result();
		}
		return 0;
	}
}
?>