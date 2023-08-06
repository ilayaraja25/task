<html lang="en">
<body>	
 <h4>Staff Details</h4> 
 
<form action="details.php" method="POST">

Name: <input type="text" name="fname" placeholder="Enter your name" ><br><br>
Date of Joining:<input type="date" name="date"><br><br>
Address:<br>
<textarea name="Address" rows="5" cols="40"  ></textarea><br><br>
Department: <select  name="name"><br>
<option value="">select</option>
<option value="">COMPUTER SCIENCE</option>
<option value="">INFORMATION TECHNOLOGY</option>
<option value="">ELECTRICAL AND ELECTRONICS</option>
<option value="">ROBOTICS</option></select><br><br>
Phone Number:<input type="number" name="number" placeholder="Enter your number" ><br><br>
Gender:
<br>
<input type="radio" name="gender" value="female">Female
<input type="radio" name="gender" value="male">Male
<input type="radio" name="gender" value="other">Other<br><br>
Blood Group: 
<select name="blood"><br>
<option value="">select</option>
<option value="">O+ve</option>
<option value="">O-ve</option>
<option value="">other</option></select><br><br>
<input type="submit">
</form>

</body>
</html>