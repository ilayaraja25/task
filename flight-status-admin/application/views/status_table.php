<?php
include('include/home_bar.php');
include('include/side_bar.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airport Status Table</title>
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
        <h3 align="center">Master Airport Status Table</h3></br>
        <div class="table-responsive">
            </br>
            <input type="text" id="myInput" placeholder="Search for names..">
            </br></br>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th colspan="4">To insert Data</th>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>State</td>
                        <td>Last Update</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody id="tfoot">
                </tbody>
            </table>
            <table id="ch_table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th colspan="5">To update Data</th>
                    </tr>
                    <tr>
                        <td>Id</td>
                        <td>Status</td>
                        <td>State</td>
                        <td>Last Update</td>
                        <td>Action</td>
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
                url: "<?php echo base_url('Chn_airport/get_master_status_table') ?>",
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
                        html += '<td id="id_t" class="table_data" data-row_id="' + a[count].status_id + '" data-column_name="id" >' + a[count].status_id + '</td>';
                        html += '<td id="status_t" class="table_data" data-row_id="' + a[count].status_id + '" data-column_name="airport" contenteditable>' + a[count].status + '</td>';
                        html += '<td id="state_t" class="table_data" data-row_id="' + a[count].status_id + '" data-column_name="state" >' + a[count].state + '</td>';
                        html += '<td id="time_stamp_t" class="table_data" data-row_id="' + a[count].status_id + '" data-column_name="time_stamp" >' + a[count].time_stamp + '</td>';
                        html += '<td><button type="button" name="delete_btn" id="' + a[count].status_id + '" class="btn btn-xs btn-danger btn_delete"><span class="glyphicon glyphicon-remove"></span></button></td></tr>';

                    }

                    html1 += '<tr>';
                    html1 += '<td id="status" contenteditable placeholder="Enter the Status"></td>';
                    html1 += '<td id="state" value="state">' + "State" + '</td>';
                    html1 += '<td id="time_stamp" value="time_stamp">' + "Last updated" + '</td>';
                    html1 += '<td><button type="button" name="btn_add" id="btn_add" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span></button></td></tr>';

                    $('#tbody').html(html);
                    $('#tfoot').html(html1);
                    $('#ch_table').DataTable();
                }
            });
        }
        fetch_data();

        $(document).on('click', '#btn_add', function() {
            var status = $('#status').text();

            if (status == '') {
                alert('Enter status');
                return false;
            }
            alert($status);
            /*$.ajax({
                url: "<?php echo base_url('Chn_airport/insert_master_status_table'); ?>",
                method: "POST",
                data: {

                    status: status

                },
                success: function(data) {
                    fetch_data();
                }
            })*/
        });
        $(document).on('blur', '.table_data', function() {
            var id = $(this).data('row_id');
            var table_column = $(this).data('column_name');
            var value = $(this).text();

            //alert(id);
            //alert(table_column);
            //alert(value);
            
            $.ajax({
                url: "<?php echo base_url('Chn_airport/update_master_status_table'); ?>",
                method: "POST",
                //dataType:"JSON",
                data: {
                    id: id,
                    table_column: table_column,
                    value: value
                },
                success: function(data) {
                    //alert(JSON.stringfy(data));
                    fetch_data();
                }
            })
        });
        $(document).on('click', '.btn_delete', function() {
            var id = $(this).attr('id');
            if (confirm("Are you sure you want to delete this?")) {
                $.ajax({
                    url: "<?php echo base_url('Chn_airport/delete_master_status_table'); ?>",
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
