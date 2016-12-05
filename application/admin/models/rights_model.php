<?php

class Rights_model extends CI_Model {
	
    function Rights_model()
    {
        parent::__construct();
    }   
	
	
	
	function get_assign_rights($id)
	{
		$query=$this->db->query("select * from ".$this->db->dbprefix('rights_assign')." where admin_id='".$id."'");
		
		if($query->num_rows()>0)
		{		
			$rights=$query->result();	
			
			$temp=array();
			
			foreach($rights as $rig)
			{
				if($rig->rights_set==1 || $rig->rights_set=='1')
				{
					$temp[]=$rig->rights_id;	
				}
			}
			
			return $temp;
			
		}
		else
		{
			return 0;
		}
	}
	
	function get_rights()
	{
		//$query=$this->db->query("select * from ".$this->db->dbprefix('rights')." order by rights_id asc");
		//return $query->result();	
		$query=$this->db->query("select * from sss_module left join  sss_rights on sss_module.module_id=sss_rights.module_id group by sss_module.module_id");
		return $query->result();	
		
	}
	
	function add_rights()
	{
		
		$get_rights=$this->db->query("select * from ".$this->db->dbprefix('rights')." order by rights_id asc");
		$all_rights=$get_rights->result();
		
		
		$rights_id=$this->input->post('rights_id');
		$admin_id=$this->input->post('admin_id');
		
	
		
		if($rights_id)
		{
			foreach($all_rights as $rig)
			{
				
				if(in_array($rig->rights_id,$rights_id))
				{
				
				
			
					$detail=$this->db->query("select * from ".$this->db->dbprefix('rights_assign')." where rights_id='".$rig->rights_id."' and admin_id='".$admin_id."'");
					
					if($detail->num_rows()>0)
					{
						$update=$this->db->query("update ".$this->db->dbprefix('rights_assign')." set rights_set='1' where rights_id='".$rig->rights_id."' and admin_id='".$admin_id."'");	
					}
					else
					{
						$insert=$this->db->query("insert into ".$this->db->dbprefix('rights_assign')." (`admin_id`,`rights_id`,`rights_set`)values('".$admin_id."','".$rig->rights_id."','1')");
					}
					
					
					
				
				}
				else
				{
					$detail=$this->db->query("select * from ".$this->db->dbprefix('rights_assign')." where rights_id='".$rig->rights_id."' and admin_id='".$admin_id."'");
					
					if($detail->num_rows()>0)
					{
					
					$remove=$this->db->query("update ".$this->db->dbprefix('rights_assign')." set rights_set='0' where rights_id='".$rig->rights_id."' and admin_id='".$admin_id."'");	
					
					}
					else
					{
					
					$insert_remove=$this->db->query("insert into ".$this->db->dbprefix('rights_assign')." (`admin_id`,`rights_id`,`rights_set`)values('".$admin_id."','".$rig->rights_id."','0')");					
					}
					
				}
				
				
				
				
			}
		}
		else
		{
		  $this->db->delete('rights_assign',array('admin_id'=>$admin_id));
		}
		
		
		
			
	}
	
	
}

?>