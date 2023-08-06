<?php
include('include/trichyhome_bar.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access log</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url('assets/jquery/jquery-3.5.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/DataTables/DataTables-1.10.23/js/jquery.dataTables.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/DataTables/DataTables-1.10.23/css/jquery.dataTables.min.css'); ?>">
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
        <h3 align="center">Access Log</h3></br>
        <div class="table-responsive">
            </br>
            <table id="ch_table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <!-- <th colspan="6">To update Data</th> -->
                    </tr>
                    <tr>
						<td>Id</td>
                        <td>File Name</td>
						<td>Aiport Code</td>
                        <td>Source Code</td>
                        <td>Start Run Time</td>
						<td>End Run Time</td>
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
                url: "<?php echo base_url('Airport_Controller/get_trichymaster_access_log_table') ?>",
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
                        html += '<td id="si_no_t" class="table_data" data-row_id="' + a[count].place_id + '" data-column_name="si_no" >' + a[count].si_no + '</td>';

                        html += '<td id="file_name_t" class="table_data" data-row_id="' + a[count].place_id + '" data-column_name="file_name" contenteditable>' + a[count].file_name + '</td>';
                        html += '<td id="airport_t" class="table_data" data-row_id="' + a[count].place_id + '" data-column_name="airport" contenteditable>' + a[count].airport + '</td>';
                        html += '<td id="source_t" class="table_data" data-row_id="' + a[count].place_id + '" data-column_name="source" >' + a[count].source + '</td>';
                        html += '<td id="create_at_t" class="table_data" data-row_id="' + a[count].place_id + '" data-column_name="create_at" >' + a[count].create_at + '</td>';
						html += '<td id="update_at_t" class="table_data" data-row_id="' + a[count].place_id + '" data-column_name="update_at" >' + a[count].update_at + '</td>';
                        html += '<td><button type="button" name="delete_btn" id="' + a[count].place_id + '" class="btn btn-xs btn-danger btn_delete"><span class="glyphicon glyphicon-remove"></span></button></td></tr>';

                    }

                    html1 += '<tr>';

                    html1 += '<td id="place" contenteditable placeholder="Enter the Place"></td>';

                    html1 += '<td id="terminal" contenteditable placeholder="Enter the terminal"></td>';
                    html1 += '<td id="state" value="State">' + "State" + '</td>';

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
            var origin = $('#place').text();
            var terminal = $('#terminal').text();



            if (origin == '') {
                alert('Enter Place');
                return false;
            }
            if (terminal == '') {
                alert('Enter terminal');
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
                url: "<?php echo base_url('Airport_Controller/insert_master_place_table'); ?>",
                method: "POST",
                data: {
                    place: origin,
                    terminal: terminal
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
            //alert(id);
            //alert(table_column);
            //alert(value);

            if (confirm("Are you sure you want to update this?")) {
                $.ajax({
                    url: "<?php echo base_url('Airport_Controller/update_master_place_table'); ?>",
                    method: "POST",
                    //dataType:"JSON",
                    data: {
                        id: id,
                        table_column: table_column,
                        value: value,
                        terminal: terminal,
                        place: place

                    },
                    success: function(data) {
                        //alert(JSON.stringfy(data));
                        fetch_data();
                    }
                })
            }
        });
        $(document).on('click', '.btn_delete', function() {
            var id = $(this).attr('id');
            //alert(id);
            if (confirm("Are you sure you want to delete this?")) {
                $.ajax({
                    url: "<?php echo base_url('Chn_airport/delete_master_place_Table'); ?>",
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
