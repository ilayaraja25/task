
<html lang="en">
<head>
	<title>Display Record</title>
	<style>
	.result,.result td, .result th{
		border:1px solid black;
	}
	</style>
</head>
<body>
        
          <table class ="result" cellspacing="">
			 <tr>
			         <th>Id</th>
					 <th>Airport</th>
			       <th>Airline</th>
					<th>Flight Number</th>
					<th>Type</th>
					<th>Depature</th>
					<th>Arrival</th>
					<th>From</th>
					<th>To</th>
					<th>Terminal</th>
					<th>Status</th>
					<th>Create</th>
					<th>Delete</th>
					
					</tr>
					
<?php
if(isset($table)){
	foreach($table as $row){//fetch
		?>
		
		<tr>
	
		<td><?=$row->si_no?></td>
		<td><?=$row->airport_id?></td>
		<td><?=$row->airline_id?></td>
	    <td><?=$row->flight_no?></td>
		<td><?=$row->type?></td>
		<td><?=$row->departure_time?></td>
		<td><?=$row->arrival_time?></td>
		<td><?=$row->from_id?></td>
		<td><?=$row->destination_id?></td>
		<td><?=$row->terminal?></td>
		<td><?=$row->status?></td>
					<td><a href ="<?=base_url('Airport_Controller/send_Value/'.$row->si_no)?>">Edit</a></td>
		<td><a onclick="confirm('want to delete?')" href ="<?=base_url('Airport_Controller/delete/'.$row->si_no)?>">Delete</a></td>

		</tr>
		<?php
          }
              }?>
			  </table>

   
	
		
		
	
</body>
</html>
