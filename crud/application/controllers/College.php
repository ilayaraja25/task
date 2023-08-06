<?php
class College extends CI_Controller{
	public function details(){//1
		$this->load->view('College_Staff_details');
}
 public function showData(){//2
      extract($_POST);
	   $data=[
            'Name'=>$fname,
            'Date_of_joining'=>$date,
            'Address'=>$Address,
            'Department'=>$Department,
            'Phone_Number'=>$number,
            'Gender'=>$gender,
            'Blood_group'=>$blood
   ];
   $this->load->model('Details');
       $this->Details->insertData($data);
	  redirect(base_url('College/details/'));//refresh
}
 public function fetchData(){//3
	    $this->load->model('Details');
      $result['table']= $this->Details->getData();
	  $this->load->view('display-record',$result);
	}
	 public function send_Value($Name)
	{//4
         $this->load->model('Details');
		 $result['data']=$this->Details->editData($Name);
		 $this->load->view('display-record',$result);
	}
	public function update(){//5
extract($_POST);
$Name=$fname;
   $data=[
            'Name'=>$fname,
            'Date_of_joining'=>$date,
            'Address'=>$Address,
            'Department'=>$Department,
            'Phone_Number'=>$number,
            'Gender'=>$gender,
            'Blood_group'=>$blood
   ];
    $this->load->model('Details');
	$result=$this->Details->updateData($data,$Name);
	if($result){
		$this->fetchData();
	}
}
public function delete($Name){//6
	 
	  $this->load->model('Details');
	 $result=$this->Details->deleteData($Name);
        if(isset($result)){
            $this->fetchdata();
	   }
	   }
}

?>