<?php
include('include/trichyhome_bar.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airline Table</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url('assets/jquery/jquery-3.5.1.min.js');?>"></script>
    <script src="<?php echo base_url('assets/DataTables/DataTables-1.10.23/js/jquery.dataTables.min.js');?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/DataTables/DataTables-1.10.23/css/jquery.dataTables.min.css');?>">
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
        <h3 align="center">Master Airlines Table</h3></br>
        <div class="table-responsive">
            </br>
            <input type="text" id="myInput" placeholder="Search for names..">
            </br></br>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th colspan="5">To insert Data</th>
                    </tr>
                    <tr>
						<td>Airline Name</td>
						<td>IATA Code</td>
						<td>ICAO Code</td>
						<td>Airline URL</td>
						<td>Image</td>
						<td>Action</td>
                    </tr>
                </thead>
                <tbody id="tfoot">
                </tbody>
            </table>
            <table id="ch_table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th colspan="6">To update Data</th>
                    </tr>
                    <tr>
                        <td>Id</td>
                        <td>Airline Name</td>
						<td>IATA Code</td>
						<td>ICAO Code</td>
						<td>Airline URL</td>
						<td>Image</td>
						<td>Create_at</td>
						<td>Action</td>
                        <!-- <td>Airline Number</td> -->
                    </tr>
                </thead>
                <tbody id="tbody">
                </tbody>

            </table>
        </div>
    </div>
</body>

</html>
<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        function fetch_data() {
            $.ajax({
                url: "<?php echo base_url('Airport_Controller/get_trichymaster_airline_table') ?>",
                method: "GET",
                dataType: "JSON",
                success: function(data) {
                    //alert(data);
                    //var datas =JSON.parse(data['status']);
                    //alert(data);
                    var a = data['result'];

                    //alert(date_format(a[0].last_updated), "dd/mm/yy H:i:s");
                    //alert(a.length);

                    var html;
                    var html1;

                    for (var count = 0; count < a.length; count++) {
                        html += '<tr>';
                        html += '<td id="si_no_t" class="table_data" data-row_id="' + a[count].si_no + '" data-column_name="si_no" >' + a[count].si_no + '</td>';
                        
                        html += '<td id="airline_name_t" class="table_data" data-row_id="' + a[count].si_no + '" data-column_name="airline_name" contenteditable>' + a[count].airline_name + '</td>';
                        // html += '<td id="number_t" class="table_data" data-row_id="' + a[count].airline_id + '" data-column_name="number" contenteditable>' + a[count].number + '</td>';
                        html += '<td id="iata_code_t" class="table_data" data-row_id="' + a[count].si_no + '" data-column_name="iata_code" >' + a[count].iata_code + '</td>';
                        html += '<td id="icao_code_t" class="table_data" data-row_id="' + a[count].si_no + '" data-column_name="icao_code" >' + a[count].icao_code + '</td>';
						html += '<td id="airline_url_t" class="table_data" data-row_id="' + a[count].si_no + '" data-column_name="airline_url" >' + a[count].airline_url + '</td>';
						html += '<td id="image_t" class="table_data" data-row_id="' + a[count].si_no + '" data-column_name="image" >' + a[count].image + '</td>';
						html += '<td id="create_at_t" class="table_data" data-row_id="' + a[count].si_no + '" data-column_name="create_at" >' + a[count].create_at + '</td>';
                        html += '<td><button type="button" name="delete_btn" id="' + a[count].si_no + '" class="btn btn-xs btn-danger btn_delete"><span class="glyphicon glyphicon-remove"></span></button></td></tr>';

                    }

                    html1 += '<tr>';
                    
                    html1 += '<td id="airline" contenteditable placeholder="Enter the Airline"></td>';

                    html1 += '<td id="iata_code" contenteditable placeholder="Enter the iata-code"></td>';
                    html1 += '<td id="icao_code" contenteditable placeholder="Enter the icao-code"></td>';
					html1 += '<td id="airline_url" contenteditable placeholder="Enter the airline-url"></td>';
					html1 += '<td id="image" contenteditable placeholder="Enter the airline-image"></td>';
					

                    // html1 += '<td id="time_stamp" value="time_stamp">' + "Last updated" + '</td>';
                    html1 += '<td><button type="button" name="btn_add" id="btn_add" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span></button></td></tr>';

                    $('#tbody').html(html);
                    $('#tfoot').html(html1);
                    $('#ch_table').DataTable();
                }
            });
        }
        fetch_data();

        $(document).on('click', '#btn_add', function() {
            var airline = $('#airline').text();
            var iata = $('#iata_code').text();
			var icao = $('#icao_code').text();
			var url = $('#airline_url').text();
			var image = $('#image').text();
            

            if (airline == '') {
                alert('Enter Airline name');
                return false;
            }
            if (iata == '') {
                alert('Enter Iata number');
                return false;
            }
			if (icao == '') {
                alert('Enter Icao number');
                return false;
            }
			if (url == '') {
                alert('Enter url');
                return false;
            }
			if (image == '') {
                alert('Enter image src');
                return false;
            }
            

            /*
            alert(type);
            alert(origin);
            alert(arrival);
            
            alert(terminal); 
            alert(status);
            */
            //alert(flight);
            //alert(airline);
            $.ajax({
                url: "<?php echo base_url('Airport_Controller/insert_master_airline_table'); ?>",
                method: "POST",
                data: {
                    airline:airline,
					iata:iata,
					icao:icao,
					url:url,
					image:image
                },
                success: function(data) {
                    fetch_data();
                }
            })
        });
        $(document).on('blur', '.table_data', function() {
            // var id = $(this).data('row_id');
            var table_column = $(this).data('column_name');
            var value = $(this).text();
			var id = $(this).closest('tr').children('td#si_no_t').text();
            var airline = $(this).closest('tr').children('td#airline_name_t').text();
            var iata = $(this).closest('tr').children('td#iata_code_t').text();
			var icao = $(this).closest('tr').children('td#icao_code_t').text();
			var url = $(this).closest('tr').children('td#airline_url_t').text();
			var image = $(this).closest('tr').children('td#image_t').text();
            //var state = $(this).closest('tr').children('td#state_t').text();
            // alert(id);
            //alert(table_column);
            //alert(value);
            //alert(airport);
            //alert(flight_name);
            //alert(number);
            $.ajax({
                url: "<?php echo base_url('Airport_Controller/update_master_airline_table'); ?>",
                method: "POST",
                //dataType:"JSON",
                data: {
                    id: id,
                    // table_column: table_column,
                    // value: value,
                    airline:airline,
					iata:iata,
					icao:icao,
					url:url,
					image:image
                },
                success: function(data) {
                    //alert(JSON.stringfy(data));
                    fetch_data();
                }
            })
        });
        $(document).on('click', '.btn_delete', function() {
            var id = $(this).attr('id');
			// alert(id);
            if (confirm("Are you sure you want to delete this?")) {
                $.ajax({
                    url: "<?php echo base_url('Airport_Controller/delete_master_airline_table'); ?>",
                    method: "POST",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        fetch_data();
                    }
                })
            }
        });
    });
</script>
