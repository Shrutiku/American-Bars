<?php
class Happy_hours_model extends CI_Model {
	
    function Happy_hours_model()
    {
        parent::__construct();	
    }   
	
function bar_hours_update($bar_id)
	{
		$datatick['days']=$this->input->post('days');
		$datatick['hour_from']=$this->input->post('hour_from');
		$datatick['hour_to']=$this->input->post('hour_to');
		$datatick['price']=$this->input->post('price');
		$datatick['speciality']=$this->input->post('speciality');
		$datatick['bar_hour_id']=$this->input->post('bar_hour_id');
		
		
		//echo 
		 if( isset( $datatick['days'] ) && is_array( $datatick['days'] ) ){
			foreach( $datatick['days'] as $key => $each ){
				
					$d = '';
					if($datatick['days'][$key]=="Monday")
					{
						$d = 1;
					}
					if($datatick['days'][$key]=="Tuesday")
					{
						$d = 2;
					}
					if($datatick['days'][$key]=="Wednesday")
					{
						$d = 3;
					}
					if($datatick['days'][$key]=="Thursday")
					{
						$d = 4;
					}
					if($datatick['days'][$key]=="Friday")
					{
						$d = 5;
					}
					if($datatick['days'][$key]=="Saturday")
					{
						$d = 6;
					}
					if($datatick['days'][$key]=="Sunday")
					{
						$d = 7;
					}
				if(isset($datatick['bar_hour_id'][$key]) && $datatick['bar_hour_id'][$key]!=''){
					
					$dataticket=array(
					'days'=>$datatick['days'][$key],
				    'hour_from' => $datatick['hour_from'][$key],
				    'bar_id' => $bar_id,
				    'day' => $d,
				    'hour_to' => $datatick['hour_to'][$key],
				     'price' =>$datatick['price'][$key],
				     'speciality' => $datatick['speciality'][$key],
					);
					$this->db->where('bar_hour_id',$datatick['bar_hour_id'][$key]);
					$this->db->update('bar_special_hours',$dataticket);
				}else{
				
					$dataticket=array(
					'days'=>$datatick['days'][$key],
				    'hour_from' => $datatick['hour_from'][$key],
				    'hour_to' => $datatick['hour_to'][$key],
				    'bar_id' => $bar_id,
				    'day' => $d,
				     'price' =>$datatick['price'][$key],
				     'speciality' => $datatick['speciality'][$key],
					);
					$this->db->insert('bar_special_hours',$dataticket);	
				}
			}
		 }
	}

 function get_bar_hour($bar_id)
	{
		$this->db->select("*");
        $this->db->from("bar_special_hours");
		$this->db->where('bar_id',$bar_id);
		$this->db->order_by('day','asc');
		//$this->db->order_by('days', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $query =  $this->db->get();
		//echo $this->db->last_query();
       
		// die;
		if($query->num_rows()>0)
		{
			 return $query->result();
		}
		 return '';
	}
	
}
?>