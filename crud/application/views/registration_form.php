<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collage Staff Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
   <?php
     if(isset($msg)){
      echo '<h1>'.$msg.'</h1>';
     }
   ?> 
<form action= "<?=base_url("register/savedata/") ?>" method="post">
  <div class="form-group">
  <label for="exampleInputEmail1">Id</label>
    <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="id" name="nid">
    <label for="exampleInputEmail1">Name</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Name" name="name">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Join of Date</label>
    <input type="date" class="form-control" id="exampleInputPassword1" placeholder="Join of date" name="doj">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Address</label>
    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="address" name="add">
  </div class="form-group">
  <div class="form-group">
  <select class="form-control" name="sel">
    <option>Mechanical</option>
  <option>Automobile</option>
  <option>ComputerScience</option>
  <option>Civil</option>
  <option>Electrical And Electronics</option>
  <option>Information Techology</option>
  </select>

</div>
<div class="form-group">
    <label for="exampleInputPassword1">PhoenNumber</label>
  
    <input type="number" class="form-control" id="exampleInputPassword1" placeholder="PhoneNumber" name="pn">
  </div>
  <div class="input-group">
  <div class="input-group-prepend">
    <div class="input-group-text">
    <label for="radio">Male</label>
    <input type="radio" aria-label="Radio button for following text input" id="radio" name="gender" value="Male">
    <label for="radio">Female</label>
    <input type="radio" aria-label="Radio button for following text input" id="radio" name="gender" value="Female" >

  </div>
  </div>
</div>
<div class="form-group">
  <select class="form-group" name="bg">
    <option>AB+</option>
  <option>A+</option>
  <option>B+</option>
  <option>O+</option>
  <option>AB-</option>
  <option>A-</option>
  <option>B-</option>
  <option>O-</option>
  </select>

  </div>
  <button type="submit" class="btn btn-primary" value="Register">Submit</button>
  <br>
  <a href="<?= base_url('register/fetchdata')?>">Staff_lists</a>


</form>
</body>
</html> 