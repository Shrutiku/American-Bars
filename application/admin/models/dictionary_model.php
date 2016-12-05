<?php
class Dictionary_model extends CI_Model {
	
    function Dictionary_model()
    {
        parent::__construct();	
    }   
	
	
	// Use :This function use for Update admin Detail.
	// Param :Post Data
	// Return :'N/A'
	
	function dictionary_insert()
	{
		$data['dictionary_title'] = $this->input->post('dictionary_title');
		$data['status'] = $this->input->post('active');
		$data['dictionary_description'] = $this->input->post('dictionary_description');	
		$data['date_added'] = date('Y-m-d H:i:s');		
		$this->db->insert('dictionary',$data);
		$forum_id = mysql_insert_id();
		$inar = array('cat_id'=>$forum_id,
		              'category'=>'dictionary',
					  'date'=>date('Y-m-d H:i:s'));
		$this->db->insert('sitemap', $inar);
	}
	
	function dictionary_update()
	{
		$active=($this->input->post('active')=='active')?'Active':'inactive';
		$data = array(
			'dictionary_title'=>$this->input->post('dictionary_title'),
		    'dictionary_description'=>$this->input->post('dictionary_description'), 
			'status' => $this->input->post('active'),
		);		
		$this->db->where('dictionary_id',$this->input->post('dictionary_id'));
		$this->db->update('dictionary',$data);
		
		
	}
	

	// Use :This function use for get one admin detail.
	// Param :Admin Id
	// Return :array
	function get_one_dictionary($id)
	{
		$query = $this->db->get_where('dictionary',array('dictionary_id'=>$id));
		return $query->row_array();
	}	
	
	// Use :This function use for count all admin.
	// Param :'N/A'
	// Return :Number
	
	function get_total_admin_count()
	{
		$query = $this->db->get_where('dictionary');
		return $query->num_rows();
	}
	
	// Use :This function use for get admin detail by limit and offset.
	// Param :offset,limit
	// Return :array of object
	
	function get_dictionary_result($offset = 0,$limit = 0)
	{
		    
		$this->db->select("*");
		$this->db->from("dictionary");
		$this->db->order_by("dictionary_id","DESC");
		$this->db->where(array("master_id"=>'0'));
		$this->db->limit($limit,$offset);
		
		$qry = $this->db->get();
		
		if($qry->num_rows()>0)
		{
			return $qry->result();
		}
		
		return 0;
		
	}
	function get_dictionary($id=0) {
		$this->db->select('b.*,u.first_name,u.last_name');
		$this->db->from('dictionary b');
		$this->db->join("user_master u","b.user_id = u.user_id","left");
		$this->db->where(array('b.dictionary_id'=>$id));
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
		
		$qry = $this->db->query("select * from ".$this->db->dbprefix('dictionary')." where 1=1 and (master_id = '".$main_id."')  order by 
		dictionary_id asc
		");
		//echo $this->db->last_query(); die;
		if ($qry->num_rows() > 0) {
			return $qry->result_array();
		}
		return 0;
	}
		function get_dictionary_count($master_id)
	{
		//echo $master_id; die;	
	 return $this->db->count_all('dictionary where master_id ='.$master_id);
		//echo $this->db->last_query(); die;
	}
	function reply_insert(){
	$data = array(
			'dictionary_description' =>  $this->input->post('description'),
			'master_id' => $this->input->post('message_id'),
			'admin_id'=>$this->input->post('admin_id'),
			'date_added' => date("Y-m-d H:i:s")
		);		
		//print_r($data); die;
		$this->db->insert('sss_dictionary',$data);
        
           //Log Entry    
           // $data_log = array("activity_name" => "LOG_REPLY_MESSAGE");
            //maintain_log($data_log); 
		
	}
		
	function importcsv()
	{
		
			if($_FILES['csv']['size']>0 && !empty($_FILES['csv']['name']))
			{			
					if (($handle = fopen($_FILES['csv']['tmp_name'], "r")) !== FALSE) {
					
						$data = fgetcsv($handle,1000,",","'");
						
						
						//echo count($data);die;
						$flag = true;
						if($data[0]!=""){
        						if(count($data)=='2') {
						   do {
						   	if($flag) { $flag = false; continue; }
							//$checkbeername = $this->beer_name(preg_replace('/[^A-Za-z0-9\- ]/', '', trim($data[0])));
						
						   		
        							
            						$arr=array(
										'dictionary_title'=>preg_replace('/[^A-Za-z0-9\- ]/', '', trim($data[0])),
										'dictionary_description'=>trim($data[1]),
										'status'=>'Active',
										'date_added'=>date('Y-m-d H:i:s'),
										);
										
										$this->db->insert('dictionary',$arr);	
										
   							}
							 while ($data = fgetcsv($handle,1000,",","'"));
							 $result="Success";			
							$msg="Import Successfully";	
							$limit=20;
							$offset=0;
							redirect('dictionary/list_dictionary/'.$limit.'/'.$offset.'/'.$result);	
				   							}
										else {
								
									$msg = "csv_not_valid";
								redirect('dictionary/import/'.$msg);	
									//die;	
								}
								}
					
   							
					}
			}
		
	}
		
}
?>