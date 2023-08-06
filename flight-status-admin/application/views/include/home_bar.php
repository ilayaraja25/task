<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
            font-family: Arial, Helvetica, sans-serif;
        }

        .topnav {

            overflow: hidden;
            background-color: #333;
        }

        .topnav a {
            float: right;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        .topnav a:hover {
            background-color: ghostwhite;
            color: black;
            text-decoration: none;
        }


        .topnav .icon {
            display: none;
        }

        @media screen and (max-width: 600px) {
            /*.topnav a:not(:first-child) {
                display: none;
            }*/

            .topnav a.icon {
                float: right;
                display: block;
            }
        }

        @media screen and (max-width: 600px) {
            .topnav.responsive {
                position: relative;
            }

            .topnav.responsive .icon {
                position: absolute;
                right: 0;
                top: 0;
            }

            .topnav.responsive a {
                float: none;
                display: block;
                text-align: left;
            }
        }
    </style>
</head>

<body>
    <div class="topnav" id="myTopnav">
        <a href="<?php echo base_url('Chn_airport/logout') ?>">Logout</a>
        <a href="<?php echo base_url('Chn_airport/home') ?>">Home</a>
        <!--<a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a>-->
    </div>
</body>

</html>
