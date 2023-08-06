<!DOCTYPE html>
<html>
<body>
<?php
//if(isset($_POST['submit']))

	 $fname=$_POST['fname'];
	 $date=$_POST['date'];
	 $Address=$_POST['Address'];
	 $name=$_POST['name'];
	 $number=$_POST['number'];
	 $gender=$_POST['gender'];
	 $blood=$_POST['blood'];
	 
	 $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "college";
     $conn = mysqli_connect($servername, $username, $password, $dbname);
	 $sql="INSERT INTO staff
    /* (Name,Date of joining,Address,Department,Phone Number,Gender,Blood group)*/
	 values ('$fname','$date','$Address','$name','$number','$gender','$blood')";
	$result=mysqli_query($conn,$sql);
	 if($result)
	 {
		 echo "sucessfull";
	 }
else{
	echo "fail";
}

?>
</body>
</html>
