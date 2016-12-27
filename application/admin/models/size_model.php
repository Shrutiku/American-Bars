<?php
class size_model extends CI_Model {
	
    function size_model() {
        parent::__construct();	
    }   
	
	// Use :This function use for check UserName of admin .
	// Param :username
	// Return :Boolean
	function size_name_unique($str) {
		if($this->input->post('Size_id')) {
			$query = $this->db->get_where('Size',array('Size_id'=>$this->input->post('Size_id')));
			$res = $query->row_array();
			$email = $res['size_name'];
			
			$query = $this->db->query("select size_name from ".$this->db->dbprefix('size')." where size_name = '$str' and Size_id!='".$this->input->post('Size_id')."'");
		}else{
			$query = $this->db->query("select size_name from ".$this->db->dbprefix('size')." where size_name = '$str'");
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
	
	function size_insert(){
		$data = array(
			'size_name' => $this->input->post('size_name'),
			'status' => $this->input->post('status'),
		);		
		//print_r($data); die;
		$this->db->insert('Size',$data);
        //echo "chi"; die;
         //header('Location: ' . $_SERVER['HTTP_REFERER']);
         //Log data
         //$data_log = array("activity_name" => "LOG_UPDATE_DOCTOR_size");
         //maintain_log($data_log);
		
		
	}
	
	function size_update(){
		$data = array(
			'size_name' => $this->input->post('size_name'),
			'status' => $this->input->post('status'),
		
		);		
		$this->db->where('Size_id',$this->input->post('Size_id'));
		$this->db->update('Size',$data);
        
         //Log data
         $data_log = array("activity_name" => "LOG_UPDATE_DOCTOR_size");
         maintain_log($data_log);
		
		
	}
	

	// Use :This function use for get one admin detail.
	// Param :Admin Id
	// Return :array
	function get_one_size($id)
	{
		$query = $this->db->get_where('Size',array('Size_id'=>$id));
		return $query->row_array();
	}	
	
	// Use :This function use for count all admin.
	// Param :'N/A'
	// Return :Number
	
	function get_total_size_count()
	{
		
		$query=$this->db->get('Size');
		return $query->num_rows();
		
	}
	
	// Use :This function use for get admin detail by limit and offset.
	// Param :offset,limit
	// Return :array of object
	
	function get_size_result($offset,$limit) {
		$this->db->order_by('Size_id','asc');
		$query = $this->db->get('Size',$limit,$offset);
	
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	// Use :This function use for Count all admin login history.
	// Param :'N/A'
	// Return :number
	
	function get_total_adminlogin_count() {
		$query = $this->db->query("select a.username,a.password,a.admin_type,a.email,ad.* from ".$this->db->dbprefix('admin_login')." ad left join ".$this->db->dbprefix('admin')." a on ad.Size_id=a.Size_id order by ad.login_id desc");
		return $query->num_rows();
	}
	
	// Use :This function use for get admin login history by limit and offset.
	// Param :offset,limit
	// Return :array of object
	
	function get_adminlogin_result($offset, $limit) {
		$query = $this->db->query("select a.username,a.password,a.admin_type,a.email,ad.* from ".$this->db->dbprefix('admin_login')." ad left join ".$this->db->dbprefix('admin')." a on ad.Size_id=a.Size_id order by ad.login_id desc LIMIT ".$limit." Offset ".$offset);
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	// Use :This function use for count admin by Filder.
	// Param :option,keyword
	// Return :number
	function get_total_search_size_count($option,$keyword) {
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('Size.*');
		$this->db->from('Size');
		
		if($option=='size_name') {
			$this->db->like('size_name',$keyword);
			
			if(substr_count($keyword,' ')>=1) {
				$ex=explode(' ',$keyword);
				foreach($ex as $val) {
					$this->db->like('size_name',$val);
				}	
			}
		}
		
		$this->db->order_by('Size_id','asc');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	// Use :This function use for get admin detail by filter and limit and offset.
	// Param :offset,limit,option,keyword
	// Return :array of object
	
	function get_search_size_result($option,$keyword,$offset, $limit) {
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('Size.*');
		$this->db->from('Size');
		
		if($option=='size_name') {
			$this->db->like('size_name',$keyword);
			
			if(substr_count($keyword,' ')>=1) {
				$ex=explode(' ',$keyword);
				foreach($ex as $val) {
					$this->db->like('size_name',$val);
				}	
			}
		}
		
		$this->db->order_by('Size_id','asc');
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