<?php
include('include/trichyhome_bar.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wp_slug</title>
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
        <h3 align="center">Master Slug Table</h3></br>
        <div class="table-responsive">

            <input type="text" id="myInput" placeholder="Search for names..">
            </br></br>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th colspan=11>To insert Data</th>
                    </tr>
                    <tr>
                        <!-- <th>Id</th> -->
                        <th>Wp Slug</th>
						<th>Flight URL</th>
						<th>Source Field</th>
						<th>Project Code</th>
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
                        <th>Wp Slug</th>
						<th>Flight URL</th>
						<th>Source Field</th>
						<th>Project Code</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                </tbody>

            </table>
        </div>

    </div>

</body>
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
                url: "<?php echo base_url('Airport_Controller/get_master_slug_table') ?>",
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
						html += '<td id="slug_t" class="table_data" data-row_id="' + a[count].id + '" data-column_name="slug" contenteditable>' + a[count].slug + '</td>';
                        
						html += '<td id="url_t" class="table_data" data-row_id="' + a[count].id + '" data-column_name="url" contenteditable>' + a[count].url + '</td>';
						html += '<td id="source_t" class="table_data" data-row_id="' + a[count].id + '" data-column_name="source" contenteditable>' + a[count].source + '</td>';
                        
                        html += '<td id="project_code_t" class="table_data" data-row_id="' + a[count].id + '" data-column_name="project_code" contenteditable>' + a[count].project_code + '</td>';
                        html += '<td id="date_t" class="table_data" data-row_id="' + a[count].id + '" data-column_name="date" contenteditable>' + a[count].date + '</td>';
                        html += '<td><button type="button" name="delete_btn" id="' + a[count].id + '" class="btn btn-xs btn-danger btn_delete"><span class="glyphicon glyphicon-remove"></span></button></td></tr>';

                    }
					html1 += '<tr>';
                    html1 += '<td id="slug" contenteditable placeholder="Enter From place"></td>';
                    html1 += '<td id="url" contenteditable placeholder="Enter the Airline"></td>';
					html1 += '<td id="source" contenteditable placeholder="Enter the Airline Number"></td>';
					

                    html1 += '<td id="project_code" contenteditable placeholder="Enter the Airline Number"></td>';
                    // html1 += '<td id="date" contenteditable placeholder="Enter the Date"></td>';
                    html1 += '<td><button type="button" name="btn_add" id="btn_add" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span></button></td></tr>';
                    $('#tbody').html(html);
                    $('#tfoot').html(html1);
                    $('#ch_table').DataTable();
                }
            });
        }
        fetch_data();
        
        $(document).on('click', '#btn_add', function() {
            var slug = $('#slug').text();
            var url = $('#url').text();
            var source = $('#source').text();
            
            // var type = $('#type').text();
            // var airport = $('#airport').text();

            if (slug == '') {
                alert('Enter Slug');
                return false;
            }
            if (url == '') {
                alert('Enter Url');
                return false;
            }
            if (source == '') {
                alert('Enter Source Field');
                return false;
            }
            
          
            // alert(status);
            // alert(origin);
            // alert(arrival);
            // alert(flight);
            // alert(airline);
            // alert(terminal); 
            // alert(status);
        
            $.ajax({
                url: "<?php echo base_url('Airport_Controller/insert_master_slug_table'); ?>",
                method: "POST",
                data: {
                    slug:slug,
					url:url,
					source:source,
					
                    
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
            var slug = $(this).closest('tr').children('td#slug_t').text();
            var url = $(this).closest('tr').children('td#url_t').text();
            var source = $(this).closest('tr').children('td#source_t').text();
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
		    // alert(table_column);
            $.ajax({
                url: "<?php echo base_url('Airport_Controller/update_master_slug_table'); ?>",
                method: "POST",
                //dataType:"JSON",
                data: {
                    id: id,
                    table_column: table_column,
                    value: value,
                    slug:slug,
					url:url,
					source:source
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
			// alert(id);
            if (confirm("Are you sure you want to delete this?")) {
                $.ajax({
                    url: "<?php echo base_url('Airport_Controller/delete_master_slug_table'); ?>",
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
