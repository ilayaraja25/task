<?php
include('include/home_bar.php');
include('include/side_bar.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master live status table</title>
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
        <h3 align="center">Master live_status Table</h3></br>
        <div class="table-responsive">

            <input type="text" id="myInput" placeholder="Search for names..">
            </br></br>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th colspan=11>To insert Data</th>
                    </tr>
                    <tr>
                        <th>Airport</th>
                        <th>Type</th>
                        <th>Place</th>
                        <th>Time</th>
                        <th>Filght</th>
                        <th>Airline</th>
                        <th>Terminal</th>
                        <th>Status</th>
                        <th>Is_Exist</th>
                        <th>Last Update</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tfoot">
                </tbody>
            </table>
            <table id="ch_table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th colspan="11">To update Data</th>
                    </tr>
                    <tr>
                        <th>Id</th>
                        <th>Airport</th>
                        <th>Type</th>
                        <th>Place</th>
                        <th>Time</th>
                        <th>Filght</th>
                        <th>Airline</th>
                        <th>Terminal</th>
                        <th>Status</th>

                        <th>Is_Exist</th>
                        <th>Last Update</th>
                        <th>Action</th>
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

        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });


        function fetch_data() {
            $.ajax({
                url: "<?php echo base_url('Chn_airport/get_MasterLiveStatus_table') ?>",
                method: "GET",
                dataType: "JSON",
                success: function(data) {
                    //alert(data);
                    //var datas =JSON.parse(data['status']);
                    //alert(datas);
                    var a = data['result'];
                    //var b =data['links'];
                    //$('#link').html(b);
                    //alert(date_format(a[0].last_updated), "dd/mm/yy H:i:s");
                    //alert(a.length);

                    var html;
                    var html1;
                    for (var count = 0; count < a.length; count++) {
                        html += '<tr>';
                        html += '<td id="id_t" class="table_data" data-row_id="' + a[count].id + '" data-column_name="id">' + a[count].id + '</td>';
                        html += '<td id="airport_t" class="table_data" data-row_id="' + a[count].id + '" data-column_name="airport" contenteditable>' + a[count].airport + '</td>';
                        html += '<td id="type_t" class="table_data" data-row_id="' + a[count].id + '" data-column_name="type" contenteditable>' + a[count].type + '</td>';
                        html += '<td id="place_t" class="table_data" data-row_id="' + a[count].id + '" data-column_name="place" contenteditable>' + a[count].place + '</td>';
                        html += '<td id="time_t" class="table_data" data-row_id="' + a[count].id + '" data-column_name="time" contenteditable>' + a[count].time + '</td>';
                        html += '<td id="flight_t" class="table_data" data-row_id="' + a[count].id + '" data-column_name="flight" contenteditable>' + a[count].flight + '</td>';
                        html += '<td id="airline_t" class="table_data" data-row_id="' + a[count].id + '" data-column_name="airline" contenteditable>' + a[count].airline + '</td>';
                        html += '<td id="terminal_t" class="table_data" data-row_id="' + a[count].id + '" data-column_name="terminal" contenteditable>' + a[count].terminal + '</td>';
                        html += '<td id="status_t" class="table_data" data-row_id="' + a[count].id + '" data-column_name="status" contenteditable>' + a[count].status + '</td>';


                        html += '<td id="state_t" class="table_data" data-row_id="' + a[count].id + '" data-column_name="state" >' + a[count].state + '</td>';
                        html += '<td id="last_updated_t" class="table_data" data-row_id="' + a[count].id + '" data-column_name="last_updated" >' + a[count].last_update + '</td>';
                        html += '<td><button type="button" name="delete_btn" id="' + a[count].id + '" class="btn btn-xs btn-danger btn_delete"><span class="glyphicon glyphicon-remove"></span></button></td></tr>';

                    }

                    html1 += '<tr><td id="airport" contenteditable placeholder="Enter the airport"></td>';
                    html1 += '<td id="type" contenteditable placeholder="Enter the type"></td>';
                    html1 += '<td id="place" contenteditable placeholder="Place"></td>';
                    html1 += '<td id="time" contenteditable placeholder="Enter the Time"></td>';
                    html1 += '<td id="flight" contenteditable placeholder="Enter the flight"></td>';
                    html1 += '<td id="airline" contenteditable placeholder="Enter the airline"></td>';
                    html1 += '<td id="terminal" contenteditable placeholder="Enter the terminal"></td>';
                    html1 += '<td id="status" contenteditable placeholder="Enter the status"></td>';


                    html1 += '<td id="state" value="State">' + "State" + '</td>';
                    html1 += '<td id="last_updated" value="Last_updated">' + "Last updated" + '</td>';
                    html1 += '<td><button type="button" name="btn_add" id="btn_add" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span></button></td></tr>';
                    $('#tbody').html(html);
                    $('#tfoot').html(html1);
                    $('#ch_table').DataTable();
                }
            });
        }
        fetch_data();
        //
        $(document).on('click', '#btn_add', function() {
            var origin = $('#place').text();
            var arrival = $('#time').text();
            var flight = $('#flight').text();
            var airline = $('#airline').text();
            var terminal = $('#terminal').text();
            var status = $('#status').text();
            var type = $('#type').text();
            var airport = $('#airport').text();

            if (origin == '') {
                alert('Enter Origin');
                return false;
            }
            if (arrival == '') {
                alert('Enter Arrival');
                return false;
            }
            if (flight == '') {
                alert('Enter flight');
                return false;
            }
            if (airline == '') {
                alert('Enter Airline');
                return false;
            }
            if (terminal == '') {
                alert('Enter terminal');
                return false;
            }
            if (status == '') {
                alert('Enter status');
                return false;
            }
            if (type == '') {
                alert('Enter status');
                return false;
            }
            if (airport == '') {
                alert('Enter status');
                return false;
            }
            /*
            alert(type);
            alert(origin);
            alert(arrival);
            alert(flight);
            alert(airline);
            alert(terminal); 
            alert(status);
            */
            $.ajax({
                url: "<?php echo base_url('Chn_airport/insert_master_live_table'); ?>",
                method: "POST",
                data: {
                    place: origin,
                    time: arrival,
                    flight: flight,
                    airline: airline,
                    terminal: terminal,
                    status: status,
                    type: type,
                    airport: airport
                },
                success: function(data) {
                    fetch_data();
                }
            })
        });
        $(document).on('blur', '.table_data', function() {
            var id = $(this).data('row_id');
            var table_column = $(this).data('column_name');
            var value = $(this).text();
            var place = $(this).closest('tr').children('td#place_t').text();
            var terminal = $(this).closest('tr').children('td#terminal_t').text();
            var flight = $(this).closest('tr').children('td#flight_t').text();
            var airline = $(this).closest('tr').children('td#airline_t').text();
            //var type = $(this).closest('tr').children('td#type_t').text();
            /*
            alert(id);
            alert(table_column);
            alert(value);
            alert(airport);
            //alert(type);
            alert(place);
            alert(terminal);
            alert(flight);
            alert(airline);
            */
            $.ajax({
                url: "<?php echo base_url('Chn_airport/update_master_live_table'); ?>",
                method: "POST",
                //dataType:"JSON",
                data: {
                    id: id,
                    table_column: table_column,
                    value: value,
                    place: place,
                    terminal: terminal,
                    flight: flight,
                    airline: airline
                },
                success: function(data) {
                    //alert(JSON.stringfy(data));
                    //$('#ch_table').DataTable();
                    fetch_data();
                }
            })
        });
        $(document).on('click', '.btn_delete', function() {
            var id = $(this).attr('id');
            if (confirm("Are you sure you want to delete this?")) {
                $.ajax({
                    url: "<?php echo base_url('Chn_airport/delete_master_live_table'); ?>",
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