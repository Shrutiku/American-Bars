<?php
class color_model extends CI_Model {
	
    function color_model() {
        parent::__construct();	
    }   
	
	// Use :This function use for check UserName of admin .
	// Param :username
	// Return :Boolean
	function color_name_unique($str) {
		if($this->input->post('color_id')) {
			$query = $this->db->get_where('Color',array('color_id'=>$this->input->post('color_id')));
			$res = $query->row_array();
			$email = $res['color_name'];
			
			$query = $this->db->query("select color_name from ".$this->db->dbprefix('color')." where color_name = '$str' and color_id!='".$this->input->post('color_id')."'");
		}else{
			$query = $this->db->query("select color_name from ".$this->db->dbprefix('color')." where color_name = '$str'");
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
	
	function color_insert(){
		$data = array(
			'color_name' => $this->input->post('color_name'),
			'status' => $this->input->post('status'),
		);		
		//print_r($data); die;
		$this->db->insert('Color',$data);
        //echo "chi"; die;
         //header('Location: ' . $_SERVER['HTTP_REFERER']);
         //Log data
         //$data_log = array("activity_name" => "LOG_UPDATE_DOCTOR_color");
         //maintain_log($data_log);
		
		
	}
	
	function color_update(){
		$data = array(
			'color_name' => $this->input->post('color_name'),
			'status' => $this->input->post('status'),
		
		);		
		$this->db->where('color_id',$this->input->post('color_id'));
		$this->db->update('Color',$data);
        
         //Log data
         $data_log = array("activity_name" => "LOG_UPDATE_DOCTOR_color");
         maintain_log($data_log);
		
		
	}
	

	// Use :This function use for get one admin detail.
	// Param :Admin Id
	// Return :array
	function get_one_color($id)
	{
		$query = $this->db->get_where('Color',array('color_id'=>$id));
		return $query->row_array();
	}	
	
	// Use :This function use for count all admin.
	// Param :'N/A'
	// Return :Number
	
	function get_total_color_count()
	{
		
		$query=$this->db->get('Color');
		return $query->num_rows();
		
	}
	
	// Use :This function use for get admin detail by limit and offset.
	// Param :offset,limit
	// Return :array of object
	
	function get_color_result($offset,$limit) {
		$this->db->order_by('color_id','asc');
		$query = $this->db->get('Color',$limit,$offset);
	
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	// Use :This function use for Count all admin login history.
	// Param :'N/A'
	// Return :number
	
	function get_total_adminlogin_count() {
		$query = $this->db->query("select a.username,a.password,a.admin_type,a.email,ad.* from ".$this->db->dbprefix('admin_login')." ad left join ".$this->db->dbprefix('admin')." a on ad.color_id=a.color_id order by ad.login_id desc");
		return $query->num_rows();
	}
	
	// Use :This function use for get admin login history by limit and offset.
	// Param :offset,limit
	// Return :array of object
	
	function get_adminlogin_result($offset, $limit) {
		$query = $this->db->query("select a.username,a.password,a.admin_type,a.email,ad.* from ".$this->db->dbprefix('admin_login')." ad left join ".$this->db->dbprefix('admin')." a on ad.color_id=a.color_id order by ad.login_id desc LIMIT ".$limit." Offset ".$offset);
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	// Use :This function use for count admin by Filder.
	// Param :option,keyword
	// Return :number
	function get_total_search_color_count($option,$keyword) {
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('Color.*');
		$this->db->from('Color');
		
		if($option=='color_name') {
			$this->db->like('color_name',$keyword);
			
			if(substr_count($keyword,' ')>=1) {
				$ex=explode(' ',$keyword);
				foreach($ex as $val) {
					$this->db->like('color_name',$val);
				}	
			}
		}
		
		$this->db->order_by('color_id','asc');
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	// Use :This function use for get admin detail by filter and limit and offset.
	// Param :offset,limit,option,keyword
	// Return :array of object
	
	function get_search_color_result($option,$keyword,$offset, $limit) {
		$keyword=str_replace('-',' ',$keyword);
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		$this->db->select('Color.*');
		$this->db->from('Color');
		
		if($option=='color_name') {
			$this->db->like('color_name',$keyword);
			
			if(substr_count($keyword,' ')>=1) {
				$ex=explode(' ',$keyword);
				foreach($ex as $val) {
					$this->db->like('color_name',$val);
				}	
			}
		}
		
		$this->db->order_by('color_id','asc');
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