<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master arrival table</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	<style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
            font-family: Arial, Helvetica, sans-serif;
        }

        .box {
            margin-left: 160px;

            width: auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
	</head>
<body>
    <div class="container box">
        <h3 align="center">Master Arrival Table</h3></br>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <!-- <tr>
                        <th colspan=11>Departure Selenium Table</th>
                    </tr> -->
                    <tr>
					<th>Edit</th>
                        <th>Id</th>
						<th>Airline</th>
						<th>Airline  Number</th>
						<th>Origin</th>
						<th>Arrival</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
				
					<?php
				foreach($arrival as $a) {
					;?>
					<tr>
                                    <td><a href ="<?=base_url('Airport_Controller/insert_arrival_table/'.$a->id)?>">Edit</a></td>
                                        <td data-label="@lang('Id')"><?php echo $a->id ?></td>


                                        <td data-label="@lang('Airline')"><?php echo $a->airline ?></td>
                                        <td data-label="@lang('Airline Number')"><?php echo $a->number ?></td>

                                        <td data-label="@lang('Origin')"><?php echo $a->place ?></td>


                                        <td data-label="@lang('Departure')"><?php echo $a->arrival ?></td>
                                        <td data-label="@lang('Status')"><?php echo $a->status ?></td>

                                    </tr>
									<?php
				}; ?>
                </tbody>
            </table>
			</table>
        </div>

    </div>

</body>
