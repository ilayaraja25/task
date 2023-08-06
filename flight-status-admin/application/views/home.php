<?
include('include/home_bar.php');
include('include/side_bar.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chennai Airport Flight Info</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <style>
        body {
            margin-right: 22%;
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
            font-family: Arial, Helvetica, sans-serif;
        }


        /* Float four columns side by side */
        .column {
            float: left;
            width: 25%;
            margin-top: 10px;
            margin-bottom: 10px;
            padding: 0 10px;
        }

        /* Remove extra left and right margins, due to padding */
        .row {
            margin-left: 250px;
            margin-right: auto;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Responsive columns */
        @media screen and (max-width: 450px) {
            .column {
                width: 100%;
                display: block;
                margin-bottom: 20px;
            }
        }

        /* Style the counter cards */
        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            padding: 16px;
            text-align: center;
            background-color: #f1f1f1;
        }

        .card a {
            text-decoration: none;
            color: black;
        }
    </style>
</head>

<body>
    <div class="container-fluid" style="float:right; margin-top:5px;">
        <label for="update-btn">To update Database</label>
        <button id="update-btn" type="button" class="btn btn-warning float-right" onclick="location.href='<?php echo base_url('Chn_airport/script_run') ?>'">
            <i class="loading-icon fa fa-spinner fa-spin hide"></i>
            <span class="btn-txt">Update</span>
        </button>
    </div>
    <div class="row">
        <h2>Tables in Database</h2>
        <div class="column" onclick="">
            <div class="card" style="background-color: #E0E0E0;">
                <h3>Master</h3>
                <a href="<?php echo base_url('Chn_airport/master_live_status_table') ?>">Click to view</a>

            </div>
        </div>
        <div class="column">
            <div class="card" onclick="" style="background-color: #E0E0E0;">
                <h3>Places</h3>
                <a href="<?php echo base_url('Chn_airport/master_place_table') ?>">click to view</a>

            </div>
        </div>

        <div class="column" onclick="">
            <div class="card" style="background-color: #E0E0E0;">
                <h3>Flights</h3>
                <a href="<?php echo base_url('Chn_airport/master_flight_table') ?>">Click to view</a>

            </div>
        </div>
        <div class="column" onclick="">
            <div class="card" style="background-color: #E0E0E0;">
                <h3>Status</h3>
                <a href="<?php echo base_url('Chn_airport/master_status_table') ?>">Click to view</a>

            </div>
        </div>
        <div class="column" onclick="">
            <div class="card" style="background-color: #E0E0E0;">
                <h3>Time</h3>
                <a href="<?php echo base_url('Chn_airport/master_time_table') ?>">Click to view</a>

            </div>
        </div>
    </div>

    <div class="row">
        <h2>User Database</h2>
        <div class="column">
            <div class="card" onclick="" style="background-color: #E0E0E0;">
                <h3>User</h3>
                <a href="<?php echo base_url('Chn_airport/arrival_table') ?>">click to view</a>

            </div>
        </div>
        <div class="column" onclick="">
            <div class="card" style="background-color:#E0E0E0;">
                <h3> User Details</h3>
                <a>Click to view</a>

            </div>
        </div>
    </div>
    <!-- Bootsrtap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!-- jQuery -->
    <script src="<?php echo base_url('assets/jquery/jquery.min.js'); ?>"></script>
    <!-- Page specific script -->
    <script>
        $(Document).ready(function() {
            $("#update-btn").on("click", function() {
                $(".loading-icon").removeClass("hide");
                $("#update-btn").attr("disabled", true);
                $(".btn-txt").text("Updating Data...");
            });
        });
    </script>

</body>

</html>
