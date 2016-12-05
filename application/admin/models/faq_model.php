<?php

class Faq_model extends CI_Model {
	
    function faq_model()
    {
        parent::__construct();	
    }   
	
	// Use :This function use for add new faq.
	// Param :Post Data
	// Return :'N/A'
	function faq_insert() {
		$data = array(
			'faq_question' => $this->input->post('faq_question'),
			'faq_answer' => $this->input->post('faq_answer'),
			'status' => ($this->input->post('status') == 'Active')?'Active':'Inactive',
			'created_on' => date("Y-m-d H:i:s")
		);		
		$this->db->insert('faq',$data);
        
       
	}

	// Use :This function use for check faq .
	// Param :faq
	// Return :Boolean
	function faq_unique($str){	
		if($this->input->post('faq_id')){
			$query = $this->db->get_where('faq',array('faq_id'=>$this->input->post('faq_id')));
			$res = $query->row_array();
			$faq_name = $res['faq_name'];
			
			$query = $this->db->query("select faq_name from ".$this->db->dbprefix('faq')." where faq_name= '$str' and faq_id!='".$this->input->post('faq_id')."'");
		}else{
			$query = $this->db->query("select faq_name from ".$this->db->dbprefix('faq')." where faq_name = '$str' ");
		}
		if($query->num_rows()>0){
			return FALSE;
		}else{
			return TRUE;
		}
		
	}
	
	// Use :This function use for Update faq Detail.
	// Param :Post Data
	// Return :'N/A'
	
	function faq_update(){
		$data = array(
			'faq_question' => $this->input->post('faq_question'),
			'faq_answer' => $this->input->post('faq_answer'),
			'status' => ($this->input->post('status') == 'Active')?'Active':'Inactive',
			'updated_on' => date("Y-m-d H:i:s")
		);
			
		$this->db->where('faq_id',$this->input->post('faq_id'));
		$this->db->update('faq',$data);
		
      
	}
	
	// Use :This function use for get one faq detail.
	// Param :faq Id
	// Return :array
	function get_one_faq($id) {
		$query = $this->db->get_where('faq',array('faq_id'=>$id));
		return $query->row_array();
	}	
	// Use :This function use for count all faq.
	// Param :'N/A'
	// Return :Number
	function get_total_faq_count(){
		return $this->db->count_all('faq');
	}
	
	// Use :This function use for get faq detail by limit and offset.
	// Param :offset,limit
	// Return :array of object
	
	
	function get_faq_result($offset, $limit){
		$this->db->order_by('faq_id','asc');
		$query = $this->db->get('faq',$limit,$offset);
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return 0;
	}
	
	
	
	// Use :This function use for count faq by Filder.
	// Param :option,keyword
	// Return :number
	function get_total_search_faq_count($option,$keyword) {
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		if($option=='faq_name'){
			$this->db->like('faq_name',$keyword);
			
			if(substr_count($keyword,' ')>=1){
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val){
					$this->db->like('faq_name',$val);
				}	
			}

		}
		
		if($option=='status'){
			$this->db->like('status',$keyword);
			
			if(substr_count($keyword,' ')>=1){
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val){
					$this->db->like('status',$val);
				}	
			}
		}
		
		$this->db->order_by("faq_id", "asc");
		$query = $this->db->get('faq');
		return $query->num_rows();
	}
	
	// Use :This function use for get faq detail by filter and limit and offset.
	// Param :offset,limit,option,keyword
	// Return :array of object
	function get_search_faq_result($option,$keyword,$offset, $limit) {
		$keyword=str_replace('"','',str_replace(array("'",",","%","$","&","*","#","(",")",":",";",">","<","/"),'',$keyword));
		
		if($option=='faq_name'){
			$this->db->like('faq_name',$keyword);
			
			if(substr_count($keyword,' ')>=1){
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val){
					$this->db->like('faq_name',$val);
				}	
			}
		}
		
		if($option=='status'){
			$this->db->like('t.status',$keyword);
			
			if(substr_count($keyword,' ')>=1) {
				$ex=explode(' ',$keyword);
				
				foreach($ex as $val) {
					$this->db->like('status',$val);
				}	
			}
		}
	    $this->db->order_by("faq_id", "asc");
		$query = $this->db->get('faq',$limit,$offset);
		
		if ($query->num_rows() > 0) {
			
			return $query->result();
		}
		return 0;
	}
}
?>