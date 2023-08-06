
<html lang="en">
<head>
	<title>Display Record</title>
	<style>
	.result,.result td, .result th{
		border:1px solid black;
		border-collapse :collapse;
		padding :8px;
		margin: auto;
		background-color:lightblue;
		
	}
	.result th{
		background-color:lightskyblue;
	}
		
		
	</style>
</head>
<body>
          <?php
            if(isset($data)){
				
				?>
				<form action="<?=base_url('College/update')?>" method="POST">
				<table cellspacing="20">
				<tr>
				<td>Name</td>
				<td><input name="fname" value="<?=$data[0]->Name?>"></td>
				</tr>
				<tr>
				<td>Date_of_joining</td>
				<td><input name="date" value="<?=$data[0]->Date_of_joining?>"></td>
				</tr>
				<tr>
				<td>Address</td>
				<td><input name="Address" value="<?=$data[0]->Address?>"></td>
				</tr>
				<tr>
				<td>Department</td>
				<td><input name="Department" value="<?=$data[0]->Department?>"></td>
				</tr>
				<tr>
				<td>Phone_Number</td>
				<td><input name="number" value="<?=$data[0]->Phone_Number?>"></td>
				</tr>
				<tr>
				<td>Gender</td>
				<td><input name="gender" value="<?=$data[0]->Gender?>"></td>
				</tr>
				<tr>
				<td>Blood_group</td>
				<td><input name="blood" value="<?=$data[0]->Blood_group?>"></td>
				</tr>
				<tr>
				<td><button>Update</button></td>
				<td></td>
				</tr>
				</table>
				</form>
				<?php
			}
			else{
              ?>
             <table class ="result">
			 <tr>
			        
			       <th> Name</th>
					<th>Date_of_joining</th>
					<th>Address</th>
					<th>Department</th>
					<th>Phone_Number</th>
					<th>Gender</th>
					<th>Blood_group</th>
					 <th>Action</th>
					 <th>Delete</th>
					</tr>
			
					
<?php
if(isset($table)){
	foreach($table as $row){
		?>
		
		<tr>

		<td><?=$row->Name?></td>
		<td><?=$row->Date_of_joining?></td>
		<td><?=$row->Address?></td>
	    <td><?=$row->Department?></td>
		<td><?=$row->Phone_Number?></td>
		<td><?=$row->Gender?></td>
		<td><?=$row->Blood_group?></td>
				<td><a href ="<?=base_url('College/send_Value/'.$row->Name)?>">Edit</a></td>
		<td><a onclick="confirm('want to delete?')" href ="<?=base_url('College/delete/'.$row->Name)?>">Delete</a></td>
		</tr>
		<?php
          }
              }?>
			  </table>
			<?php
			}
			?>
			  <br>
   
	<a href="<?=base_url('College/details')?>" >Go to form</a>	
		
		
	
</body>
</html>
