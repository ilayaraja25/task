<?php
class Details extends CI_Model{
	
	public function insertData($data){//1
		Print_r($data);
		$this->load->database();
		return $this->db->insert('staff',$data);
		
	}
	 public function getData(){//2
            $this->load->database();
		return $this->db->get('staff')->result();
		
	   }
	   public function editData($Name){//3
		 $this->load->database();
		$this->db->where('Name',$Name);
	   return $this->db->get('staff')->result();
	}
	public function updateData($data,$Name){//4
	$this->load->database();
	$this->db->where('Name',$Name);
	 return $this->db->update('staff',$data);
	}
	 public function deleteData($Name){
		   $this->load->database();
	   $this->db->where('Name',$Name);
	   return $this->db->delete('staff');
	   }
	
	
}
	
	
?>