<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .sidenav {
            height: 100%;
            width: auto;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #333;
            overflow-x: hidden;
            padding-top: 2px;

        }

        .sidenav a {
            padding: 6px 8px 6px 16px;
            text-decoration: none;
            font-size: 19px;
            color: #818181;
            display: block;
        }

        .sidenav a.dashboard {
            font-size: 20px;
            color: black;
            background-color: #ffcc00;
            margin-top: 0px;
            display: block;
        }

        .sidenav a.title {
            color: black;
            background-color: #ffcc00;
            border-bottom: 3px solid #bbb;
        }

        .dropdown-btn {
            margin-top: 5px;
            padding: 6px 8px 6px 16px;
            text-decoration: none;
            font-size: 20px;
            color: white;
            display: block;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            outline: none;
        }

        .sidenav a:hover {
            color: black;
            background-color: #ffcc00;
        }

        /* On mouse-over */
        .dropdown-btn:hover {
            color: #ffcc00;
        }



        /* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
        .dropdown-container {
            display: block;
            background-color: #262626;
            padding-left: 8px;
        }

        /* Optional: Style the caret down icon */
        .fa-caret-down {
            float: right;
            padding-right: 8px;
        }

        @media screen and (max-width: 760px) {
            .sidenav {
                display: block;
                padding-top: 15px;
            }

            .sidenav a {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>
    <div class="sidenav">
        <a class="dashboard" href="<?php echo base_url('Chn_airport/home') ?>" style="font-size:25px;font-weight:bolder;">TAILER-MADE</a>
        <a class="title">Airport Admin</a>
        <a class="dashboard" style="font-weight:bolder;" href="<?php echo base_url('Chn_airport/home') ?>">Dashboard</a>
        <button class="dropdown-btn">Tables
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="<?php echo base_url('Chn_airport/master_live_status_table') ?>">Master</a>
            <a href="<?php echo base_url('Chn_airport/master_place_table') ?>">Place</a>
            <a href="<?php echo base_url('Chn_airport/master_flight_table') ?>">Flight</a>
            <a href="<?php echo base_url('Chn_airport/master_time_table') ?>">Time</a>
            <a href="<?php echo base_url('Chn_airport/master_status_table') ?>">Status</a>
            <a href="<?php echo base_url('Chn_airport/user_table') ?>">Users</a>
        </div>
    </div>
</body>

</html>