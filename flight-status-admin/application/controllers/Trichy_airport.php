<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
class Trichy_airport extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form', 'url');
        $this->load->model('Trichyairport_model');
        $this->load->library('form_validation');
    }
    public function index()
    {

        $this->load->view('trichylogin');
    }
    /** Login function End*/
	function log()
    {
        if (isset($_POST)) {
            $pass = $_POST['password'] ? $_POST['password'] : '';
            $email = $_POST['email'] ? $_POST['email'] : '';
            if ($pass == '' || $email == '') {
                $data['message'] = "Password or Email is Empty";
                $this->load->view('login', $data);
            } else {
                $password = filter_var($pass, FILTER_DEFAULT);
                $email = filter_var($email, FILTER_VALIDATE_EMAIL);
                $data = array(
                    "email" => $_POST['email'],
                    "password" => $password,
                );
                $check = $this->Trichyairport_model->check_login($data);
                if (empty($check)) {
                    $data['message'] = "Password or Email is incorrect";
                    $this->load->view('login', $data);
                } elseif ($check == true) {
                    $_SESSION["is_logged_in"] = true;
                    $this->load->view('trichyhome');
                }
            }
        }
    }
	function trichyhome()
    {
        if ($this->login_check() === true) {
            $this->load->view('trichyhome');
        } else {
            $this->load->view('trichylogin');
        }
    }
	public function login_check()
    {
        if (isset($_SESSION["is_logged_in"])) {
            return true;
        } else {
            return false;
        }
    }
	/** Login function End*/
	function trichy_master_departure_selenium_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('trichy_master_departure_selenium_table');
        } else {
            $this->load->view('trichylogin');
        }
    }
	function get_TrichyMasterDepartureSelenium_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Trichyairport_model->get_TrichyMasterDepartureSelenium_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['message'] = "No Data Found";
            echo json_encode($get);
        }
    }
	function insert_departure_selenium_table()
	{
		$data_airport = array(
			"place" => $this->input->post('airport')
            
        );

        $data_airline = array(
            "airline_name" => $this->input->post('airline')
        );

        $data_destination = array(
           "place" => $this->input->post('destination')
        );

        $ins_airport = $this->Trichyairport_model->insert_master_1_airport($data_airport);
        $ins_airline = $this->Trichyairport_model->insert_master_1_airline($data_airline);
        $ins_destination = $this->Trichyairport_model->insert_master_1_airport_1($data_destination);

        $departure_data = array(
            "airport_id" => $ins_airport,
			"airline_id" => $ins_airline,
			"flight_no" => $this->input->post('flight'),
			"destination_id" => $ins_destination,
			"departure" => $this->input->post('departure'),
			"terminal" => $this->input->post('terminal'),
			"status" => $this->input->post('status')
        );

        $data['result'] = $this->Trichyairport_model->insert_departure_selenium_table($departure_data);
        echo json_encode($data);
	}
	function update_departure_selenium_table()

	{

        $time_stamp = date("Y-m-d H:i:s");
        $state = '0';
        $from = $this->input->post('from');
        $airline = $this->input->post('airline');
        $flight =  $this->input->post('flight');
        $airport = $this->input->post('airport');
		$arrival = $this->input->post('arrival');
		$terminal = $this->input->post('terminal');
		$status = $this->input->post('status');


        if ($_POST['table_column'] == 'airport') {
			$data_from = array(
                "place" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "terminal" => $terminal
            );
            //print_r($data_p);
            //exit();
            $this->Trichyairport_model->update_master_airport_table3($data_from, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'airline') {
            
			$data_airline = array(
                "airline_name" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state
            );
            //print_r($data_ti);
            //exit();
            $this->Trichyairport_model->update_master_airline_status_table3($data_airline, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'place') {
            $data_destination = array(
                "place" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_master_airport_1_table3($data_destination, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'number') {
			$data = array(
                "flight_no" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_departure_selenium_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'departure') {
            $data = array(
                "departure" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_departure_selenium_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'terminal') {
            $data = array(
                "terminal" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_departure_selenium_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'status') {
            $data = array(
                "status" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_departure_selenium_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'date') {
            $data = array(
                "create_at" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_departure_selenium_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}
    }

	function delete_departure_selenium_table()
	{
		$data['in_deleted'] = '1';
        $this->Trichyairport_model->delete_departure_selenium_table($this->input->post('id'), $data);
	}



	function trichy_master_departure_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('trichy_master_departure_table');
        } else {
            $this->load->view('trichylogin');
        }
    }
	function get_TrichyMasterDeparture_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Trichyairport_model->get_TrichyMasterDeparture_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
			$get['status'] = false;
            $get['message'] = "No Data Found";
            echo json_encode($get);
        }
    }
	function insert_departure_table()
	{
		$data_airport = array(
			"place" => $this->input->post('airport')
            
        );

        $data_airline = array(
            "airline_name" => $this->input->post('airline')
        );

        $data_destination = array(
           "place" => $this->input->post('destination')
        );

        $ins_airport = $this->Trichyairport_model->insert_master_1_airport($data_airport);
        $ins_airline = $this->Trichyairport_model->insert_master_1_airline($data_airline);
        $ins_destination = $this->Trichyairport_model->insert_master_1_airport_1($data_destination);

        $departure_data = array(
            "airport_id" => $ins_airport,
			"airline_id" => $ins_airline,
			"flight_no" => $this->input->post('flight'),
			"destination_id" => $ins_destination,
			"departure" => $this->input->post('departure'),
			"terminal" => $this->input->post('terminal'),
			"status" => $this->input->post('status')
        );

        $data['result'] = $this->Trichyairport_model->insert_departure_table($departure_data);
        echo json_encode($data);
	}
	function update_departure_table()
	{

        $time_stamp = date("Y-m-d H:i:s");
        $state = '0';
        $from = $this->input->post('from');
        $airline = $this->input->post('airline');
        $flight =  $this->input->post('flight');
        $airport = $this->input->post('airport');
		$arrival = $this->input->post('arrival');
		$terminal = $this->input->post('terminal');
		$status = $this->input->post('status');


        if ($_POST['table_column'] == 'airport') {
			$data_from = array(
                "place" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "terminal" => $terminal
            );
            //print_r($data_p);
            //exit();
            $this->Trichyairport_model->update_master_airport_table4($data_from, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'airline') {
            
			$data_airline = array(
                "airline_name" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state
            );
            //print_r($data_ti);
            //exit();
            $this->Trichyairport_model->update_master_airline_status_table4($data_airline, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'place') {
            $data_destination = array(
                "place" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_master_airport_1_table4($data_destination, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'number') {
			$data = array(
                "flight_no" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_departure_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'departure') {
            $data = array(
                "departure" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_departure_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'terminal') {
            $data = array(
                "terminal" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_departure_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'status') {
            $data = array(
                "status" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_departure_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'date') {
            $data = array(
                "create_at" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_departure_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}
    }

	function delete_departure_table()
	{
		$data['in_deleted'] = '1';
        $this->Trichyairport_model->delete_departure_table($this->input->post('id'), $data);
	}



	function trichy_master_arrival_selenium_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('trichy_master_arrival_selenium_table');
        } else {
            $this->load->view('trichylogin');
        }
    }
	function get_TrichyMasterArrivalSelenium_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Trichyairport_model->get_TrichyMasterArrivalSelenium_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['message'] = "No Data Found";
            echo json_encode($get);
        }
    }
	function insert_arrival_selenium_table()
    {
        // $data['status'] = true;
        // $airport = $this->input->post('airport');
        // $state = '0';
        // $time_stamp = date("Y-m-d H:i:s");

        $data_from = array(
			"place" => $this->input->post('origin')
            
        );

        $data_airline = array(
            "airline_name" => $this->input->post('airline')
        );

        $data_airport = array(
           "place" => $this->input->post('airport')
        );

        $ins_from = $this->Trichyairport_model->insert_master_airport($data_from);
        $ins_airline = $this->Trichyairport_model->insert_master_airline($data_airline);
        $ins_airport = $this->Trichyairport_model->insert_master_airport_1($data_airport);

        $arrival_data = array(
            "from_id" => $ins_from,
			"airline_id" => $ins_airline,
			"flight_no" => $this->input->post('flight'),
			"destination_id" => $ins_airport,
			"arrival" => $this->input->post('arrival'),
			"terminal" => $this->input->post('terminal'),
			"status" => $this->input->post('status')
        );

        $data['result'] = $this->Trichyairport_model->insert_arrival_selenium_table($arrival_data);
        echo json_encode($data);
    }
	function update_arrival_selenium_table()
    {

        $time_stamp = date("Y-m-d H:i:s");
        $state = '0';
        $from = $this->input->post('from');
        $airline = $this->input->post('airline');
        $flight =  $this->input->post('flight');
        $airport = $this->input->post('airport');
		$arrival = $this->input->post('arrival');
		$terminal = $this->input->post('terminal');
		$status = $this->input->post('status');


        if ($_POST['table_column'] == 'place') {
			$data_from = array(
                "place" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "terminal" => $terminal
            );
            //print_r($data_p);
            //exit();
            $this->Trichyairport_model->update_master_airport_table($data_from, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'airline') {
            
			$data_airline = array(
                "airline_name" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state
            );
            //print_r($data_ti);
            //exit();
            $this->Trichyairport_model->update_master_airline_status_table($data_airline, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'airport') {
            $data_destination = array(
                "place" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_master_airport_1_table($data_destination, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'number') {
			$data = array(
                "flight_no" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_arrival_selenium_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'arrival') {
            $data = array(
                "arrival" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_arrival_selenium_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'terminal') {
            $data = array(
                "terminal" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_arrival_selenium_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'status') {
            $data = array(
                "status" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_arrival_selenium_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'date') {
            $data = array(
                "create_at" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_arrival_selenium_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}
    }
	function delete_arrival_selenium_table()
	{
		$data['in_deleted'] = '1';
        $this->Trichyairport_model->delete_arrival_selenium_table($this->input->post('id'), $data);
	}



	function trichy_master_arrival_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('trichy_master_arrival_table');
        } else {
            $this->load->view('trichylogin');
        }
    }
	function get_TrichyMasterArrival_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Trichyairport_model->get_TrichyMasterArrival_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['message'] = "No Data Found";
            echo json_encode($get);
        }
    }
	function insert_arrival_table()
	{
		$data_from = array(
			"place" => $this->input->post('origin')
            
        );

        $data_airline = array(
            "airline_name" => $this->input->post('airline')
        );

        $data_airport = array(
           "place" => $this->input->post('airport')
        );

        $ins_from = $this->Trichyairport_model->insert_master_airport($data_from);
        $ins_airline = $this->Trichyairport_model->insert_master_airline($data_airline);
        $ins_airport = $this->Trichyairport_model->insert_master_airport_1($data_airport);

        $arrival_data = array(
            "from_id" => $ins_from,
			"airline_id" => $ins_airline,
			"flight_no" => $this->input->post('flight'),
			"destination_id" => $ins_airport,
			"arrival" => $this->input->post('arrival'),
			"terminal" => $this->input->post('terminal'),
			"status" => $this->input->post('status')
        );

        $data['result'] = $this->Trichyairport_model->insert_arrival_table($arrival_data);
        echo json_encode($data);
	}
	function update_arrival_table()
	{
		$time_stamp = date("Y-m-d H:i:s");
        $state = '0';
        $from = $this->input->post('from');
        $airline = $this->input->post('airline');
        $flight =  $this->input->post('flight');
        $airport = $this->input->post('airport');
		$arrival = $this->input->post('arrival');
		$terminal = $this->input->post('terminal');
		$status = $this->input->post('status');


        if ($_POST['table_column'] == 'place') {
			$data_from = array(
                "place" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "terminal" => $terminal
            );
            //print_r($data_p);
            //exit();
            $this->Trichyairport_model->update_master_airport_table2($data_from, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'airline') {
            
			$data_airline = array(
                "airline_name" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state
            );
            //print_r($data_ti);
            //exit();
            $this->Trichyairport_model->update_master_airline_status_table2($data_airline, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'airport') {
            $data_destination = array(
                "place" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_master_airport_1_table2($data_destination, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'number') {
			$data = array(
                "flight_no" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_arrival_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'arrival') {
            $data = array(
                "arrival" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_arrival_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'terminal') {
            $data = array(
                "terminal" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_arrival_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'status') {
            $data = array(
                "status" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_arrival_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'date') {
            $data = array(
                "create_at" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_arrival_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}
    }
	function delete_arrival_table()
	{
		$data['in_deleted'] = '1';
        $this->Trichyairport_model->delete_arrival_table($this->input->post('id'), $data);
	}




	function trichy_master_flight_selenium_table()
	{
		if ($this->login_check() === true) {
            $this->load->view('trichy_master_flight_selenium_table');
        } else {
            $this->load->view('trichylogin');
        }
	}
	function get_TrichyMasterFlightSelenium_table()
	{
		$get['status'] = true;
        $get['result'] = $this->Trichyairport_model->get_TrichyMasterFlightSelenium_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['message'] = "No Data Found";
            echo json_encode($get);
        }
	}
	function insert_flight_selenium_table()
	{
        // $data['status'] = true;
        // $airport = $this->input->post('airport');
        // $state = '0';
        // $time_stamp = date("Y-m-d H:i:s");

        $data_from = array(
			"place" => $this->input->post('from')
            
        );

		$data_dest = array(
			"place" => $this->input->post('destination')
            
        );

        $data_airline = array(
            "airline_name" => $this->input->post('airline')
        );

        $data_airport = array(
           "place" => $this->input->post('airport')
        );

        $ins_from = $this->Trichyairport_model->insert_master_airport_from($data_from);
		$ins_dest = $this->Trichyairport_model->insert_master_airport_dest($data_dest);
        $ins_airline = $this->Trichyairport_model->insert_master_airline_1($data_airline);
        $ins_airport = $this->Trichyairport_model->insert_master_airport_airport($data_airport);

        $flight_data = array(
			"airport_id" => $ins_airport,
			"airline_id" => $ins_airline,
			"flight_no" => $this->input->post('flight'),
			"type" => $this->input->post('type'),
			"departure_time" => $this->input->post('departure'),
			"arrival_time" => $this->input->post('arrival'),
			"from_id" => $ins_from,
			"destination_id" => $ins_dest,
			"terminal" => $this->input->post('terminal'),
			"status" => $this->input->post('status')
        );

        $data['result'] = $this->Trichyairport_model->insert_flight_selenium_table($flight_data);
        echo json_encode($data);
    }
	function update_flight_selenium_table()
    {
	
        $time_stamp = date("Y-m-d H:i:s");
        $state = '0';
        $from = $this->input->post('from');
        $airline = $this->input->post('airline');
        $flight =  $this->input->post('flight');
        $airport = $this->input->post('airport');
		$arrival = $this->input->post('arrival');
		$terminal = $this->input->post('terminal');
		$status = $this->input->post('status');


        if ($_POST['table_column'] == 'airport') {
			$data_airport = array(
                "place" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "terminal" => $terminal
            );
            //print_r($data_p);
            //exit();
            $this->Trichyairport_model->update_master_airportFS_airport($data_airport, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'airline_name') {
            
			$data_airline = array(
                "airline_name" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state
            );
            //print_r($data_ti);
            //exit();
            $this->Trichyairport_model->update_master_airline_statusFS($data_airline, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'from') {
            $data_from = array(
                "place" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_master_airportFS_from($data_from, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'dest') {
            $data_destination = array(
                "place" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_master_airportFS_dest($data_destination, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'flight_no') {
			$data = array(
                "flight_no" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_flight_selenium($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'type') {
            $data = array(
                "type" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_flight_selenium($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'departure_time') {
            $data = array(
                "departure_time" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_flight_selenium($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'arrival_time') {
            $data = array(
                "arrival_time" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_flight_selenium($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'terminal') {
            $data = array(
                "terminal" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_flight_selenium($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'status') {
            $data = array(
                "status" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_flight_selenium($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'create_at') {
            $data = array(
                "create_at" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_flight_selenium($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}
    }
	function delete_flight_selenium_table()
	{
		$data['in_deleted'] = '1';
        $this->Trichyairport_model->delete_flight_selenium_table($this->input->post('id'), $data);
	}



	function trichy_master_flight_table()
	{
		if ($this->login_check() === true) {
            $this->load->view('trichy_master_flight_table');
        } else {
            $this->load->view('trichylogin');
        }
	}
	function get_TrichyMasterFlight_table()
	{
		// die('1');
		$get['status'] = true;
        $get['result'] = $this->Trichyairport_model->get_TrichyMasterFlight_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['message'] = "No Data Found";
            echo json_encode($get);
        }
	}
	function insert_flight_table()
	{
        // $data['status'] = true;
        // $airport = $this->input->post('airport');
        // $state = '0';
        // $time_stamp = date("Y-m-d H:i:s");

        $data_from = array(
			"place" => $this->input->post('from')
            
        );

		$data_dest = array(
			"place" => $this->input->post('destination')
            
        );

        $data_airline = array(
            "airline_name" => $this->input->post('airline')
        );

        $data_airport = array(
           "place" => $this->input->post('airport')
        );

        $ins_from = $this->Trichyairport_model->insert_master_airport_fromF($data_from);
		$ins_dest = $this->Trichyairport_model->insert_master_airport_destF($data_dest);
        $ins_airline = $this->Trichyairport_model->insert_master_airline_1F($data_airline);
        $ins_airport = $this->Trichyairport_model->insert_master_airport_airportF($data_airport);

        $flight_data = array(
			"airport_id" => $ins_airport,
			"airline_id" => $ins_airline,
			"flight_no" => $this->input->post('flight'),
			"type" => $this->input->post('type'),
			"departure_time" => $this->input->post('departure'),
			"arrival_time" => $this->input->post('arrival'),
			"from_id" => $ins_from,
			"destination_id" => $ins_dest,
			"terminal" => $this->input->post('terminal'),
			"status" => $this->input->post('status')
        );

        $data['result'] = $this->Trichyairport_model->insert_flight_table($flight_data);
        echo json_encode($data);
    }
	function update_flight_table()
    {
	
        $time_stamp = date("Y-m-d H:i:s");
        $state = '0';
        $from = $this->input->post('from');
        $airline = $this->input->post('airline');
        $flight =  $this->input->post('flight');
        $airport = $this->input->post('airport');
		$arrival = $this->input->post('arrival');
		$terminal = $this->input->post('terminal');
		$status = $this->input->post('status');


        if ($_POST['table_column'] == 'airport') {
			$data_airport = array(
                "place" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "terminal" => $terminal
            );
            //print_r($data_p);
            //exit();
            $this->Trichyairport_model->update_master_airportF_airport($data_airport, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'airline_name') {
            
			$data_airline = array(
                "airline_name" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state
            );
            //print_r($data_ti);
            //exit();
            $this->Trichyairport_model->update_master_airlineF_status($data_airline, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'from') {
            $data_from = array(
                "place" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_master_airportF_from($data_from, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'dest') {
            $data_destination = array(
                "place" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_master_airportF_dest($data_destination, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'flight_no') {
			$data = array(
                "flight_no" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_flight_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'type') {
            $data = array(
                "type" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_flight_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'departure_time') {
            $data = array(
                "departure_time" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_flight_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'arrival_time') {
            $data = array(
                "arrival_time" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_flight_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'terminal') {
            $data = array(
                "terminal" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_flight_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'status') {
            $data = array(
                "status" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_flight_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'create_at') {
            $data = array(
                "create_at" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_flight_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}
    }
	function delete_flight_table()
	{
		$data['in_deleted'] = '1';
        $this->Trichyairport_model->delete_flight_table($this->input->post('id'), $data);
	}




	function trichy_Airlines_table()
	{
		if ($this->login_check() === true) {
            $this->load->view('trichy_master_Airlines_table');
        } else {
            $this->load->view('trichylogin');
        }
	}
	function get_TrichyMasterAirline_table()
	{
		// die('1');
		$get['status'] = true;
        $get['result'] = $this->Trichyairport_model->get_TrichyMasterAirline_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['message'] = "No Data Found";
            echo json_encode($get);
        }
	}
	function insert_airline_table()
	{
        // $data['status'] = true;
        // $airport = $this->input->post('airport');
        // $state = '0';
        // $time_stamp = date("Y-m-d H:i:s");

        $data_from = array(
			"place" => $this->input->post('from')
            
        );

		$data_dest = array(
			"place" => $this->input->post('destination')
            
        );

        $data_airline = array(
            "airline_name" => $this->input->post('airline')
        );

        $ins_from = $this->Trichyairport_model->insert_master_airport_fromA($data_from);
		$ins_dest = $this->Trichyairport_model->insert_master_airport_destA($data_dest);
        $ins_airline = $this->Trichyairport_model->insert_master_airline_1A($data_airline);
        

        $flight_data = array(
			
			"airline_id" => $ins_airline,
			"flight_no" => $this->input->post('flight'),
			"departure_time" => $this->input->post('departure'),
			"arrival_time" => $this->input->post('arrival'),
			"from_id" => $ins_from,
			"destination_id" => $ins_dest,
			"terminal" => $this->input->post('terminal'),
			"status" => $this->input->post('status')
        );

        $data['result'] = $this->Trichyairport_model->insert_airline_table($flight_data);
        echo json_encode($data);
    }
	function update_airline_table()
    {
	
        $time_stamp = date("Y-m-d H:i:s");
        $state = '0';
        $from = $this->input->post('from');
        $airline = $this->input->post('airline');
        $flight =  $this->input->post('flight');
        $airport = $this->input->post('airport');
		$arrival = $this->input->post('arrival');
		$terminal = $this->input->post('terminal');
		$status = $this->input->post('status');


        
        	if ($_POST['table_column'] == 'airline_name') {
            
			$data_airline = array(
                "airline_name" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state
            );
            //print_r($data_ti);
            //exit();
            $this->Trichyairport_model->update_master_airline_statusA($data_airline, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'from') {
            $data_from = array(
                "place" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_master_airport_fromA($data_from, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'dest') {
            $data_destination = array(
                "place" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_master_airport_destA($data_destination, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'flight_no') {
			$data = array(
                "flight_no" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_airline_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		
		}elseif ($_POST['table_column'] == 'departure_time') {
            $data = array(
                "departure_time" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_airline_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'arrival_time') {
            $data = array(
                "arrival_time" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_airline_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'terminal') {
            $data = array(
                "terminal" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_airline_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'status') {
            $data = array(
                "status" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_airline_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'create_at') {
            $data = array(
                "create_at" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_airline_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}
    }
	function delete_airline_table()
	{
		$data['in_deleted'] = '1';
        $this->Trichyairport_model->delete_airline_table($this->input->post('id'), $data);
	}





	function trichy_master_AirlineSelenium_table()
	{
		if ($this->login_check() === true) {
            $this->load->view('trichy_master_AirlineSelenium_table');
        } else {
            $this->load->view('trichylogin');
        }
	}
	function get_TrichyMasterAirlineSelenium_table()
	{
		// die('1');
		$get['status'] = true;
        $get['result'] = $this->Trichyairport_model->get_TrichyMasterAirlineSelenium_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['message'] = "No Data Found";
            echo json_encode($get);
        }
	}
	function insert_airline_selenium_table()
	{
        // $data['status'] = true;
        // $airport = $this->input->post('airport');
        // $state = '0';
        // $time_stamp = date("Y-m-d H:i:s");

        $data_from = array(
			"place" => $this->input->post('from')
            
        );

		$data_dest = array(
			"place" => $this->input->post('destination')
            
        );

        $data_airline = array(
            "airline_name" => $this->input->post('airline')
        );

        $ins_from = $this->Trichyairport_model->insert_master_airport_fromAS($data_from);
		$ins_dest = $this->Trichyairport_model->insert_master_airport_destAS($data_dest);
        $ins_airline = $this->Trichyairport_model->insert_master_airline_1AS($data_airline);
        

        $flight_data = array(
			
			"airline_id" => $ins_airline,
			"flight_no" => $this->input->post('flight'),
			"departure_time" => $this->input->post('departure'),
			"arrival_time" => $this->input->post('arrival'),
			"from_id" => $ins_from,
			"destination_id" => $ins_dest,
			"terminal" => $this->input->post('terminal'),
			"status" => $this->input->post('status')
        );

        $data['result'] = $this->Trichyairport_model->insert_airline_selenium_table($flight_data);
        echo json_encode($data);
    }
	function update_airline_selenium_table()
    {
	
        $time_stamp = date("Y-m-d H:i:s");
        $state = '0';
        $from = $this->input->post('from');
        $airline = $this->input->post('airline');
        $flight =  $this->input->post('flight');
        $airport = $this->input->post('airport');
		$arrival = $this->input->post('arrival');
		$terminal = $this->input->post('terminal');
		$status = $this->input->post('status');


        
        	if ($_POST['table_column'] == 'airline_name') {
            
			$data_airline = array(
                "airline_name" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state
            );
            //print_r($data_ti);
            //exit();
            $this->Trichyairport_model->update_master_airline_statusAS($data_airline, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'from') {
            $data_from = array(
                "place" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_master_airport_fromAS($data_from, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'dest') {
            $data_destination = array(
                "place" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_master_airport_destAS($data_destination, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'flight_no') {
			$data = array(
                "flight_no" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_airline_selenium_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		
		}elseif ($_POST['table_column'] == 'departure_time') {
            $data = array(
                "departure_time" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_airline_selenium_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'arrival_time') {
            $data = array(
                "arrival_time" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_airline_selenium_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'terminal') {
            $data = array(
                "terminal" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_airline_selenium_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'status') {
            $data = array(
                "status" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_airline_selenium_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'create_at') {
            $data = array(
                "create_at" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_airline_selenium_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}
    }
	function delete_airline_selenium_table()
	{
		$data['in_deleted'] = '1';
        $this->Trichyairport_model->delete_airline_selenium_table($this->input->post('id'), $data);
	}





	function trichy_master_place_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('trichy_place_table');
        } else {
            $this->load->view('trichylogin');
        }
    }
	function get_trichymaster_place_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Trichyairport_model->get_trichymaster_place_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['result'] = "Error in Trichy_airport/get_trichymaster_place_table get Query";
            echo json_encode($get);
        }
    }
	function insert_master_place_table()
    {
        $time_stamp = date("Y-m-d H:i:s");
        $state = '0';
        $data['time_stamp'] = date("Y-m-d H:i:s");
        $data['state'] = '0';
        $data['place'] = $this->input->post('place');
        $data['terminal'] = $this->input->post('terminal');

        $this->Trichyairport_model->insert_master_place_table($data);
    }
	function update_master_place_table()
    {
        $time_stamp = date("Y-m-d H:i:s");
        $state = '0';

        if (($this->input->post('table_column')) == 'place') {
            $data = array(
                "place" => $this->input->post('value'),
                "terminal" => $this->input->post('terminal'),
                "time_stamp" => $time_stamp,
                "state" => $state
            );
            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_master_place_table($data, $this->input->post('id'));
        } elseif (($this->input->post('table_column')) == 'terminal') {
            $data = array(
                "terminal" => $this->input->post('value'),
                "place" => $this->input->post('place'),
                "time_stamp" => $time_stamp,
                "state" => $state
            );
            $this->Trichyairport_model->update_master_place_table($data, $this->input->post('id'));
        }
    }
	function delete_master_place_Table()
	{
		$data['terminal'] = '1';
        $this->Trichyairport_model->delete_master_place_Table($this->input->post('id'), $data);
	}





	function trichy_master_airline_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('trichy_airline_table');
        } else {
            $this->load->view('trichylogin');
        }
    }
	function get_trichymaster_airline_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Trichyairport_model->get_trichymaster_airline_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['result'] = "Error in Trichy_airport/get_trichymaster_airline_table get Query";
            echo json_encode($get);
        }
    }
	function insert_master_airline_table()
    {
        $data['create_at'] = date("Y-m-d H:i:s");
        $data['update_at'] = date("Y-m-d H:i:s");
        $data['airline_name'] = $this->input->post('airline');
        $data['iata_code'] = $this->input->post('iata');
		$data['icao_code'] = $this->input->post('icao');
		$data['airline_url'] = $this->input->post('url');
		$data['image'] = $this->input->post('image');


        // $this->Trichyairport_model->insert_master_airline_table($data);
		// $data['time_stamp'] = date("Y-m-d H:i:s");
        // $data['state'] = '0';
        // $data['airline_name'] = $this->input->post('airline_name');
        // $data['number'] = $this->input->post('number');

        $this->Trichyairport_model->insert_master_airline_table($data);
    }
	function update_master_airline_table()
    {
        $time_stamp = date("Y-m-d H:i:s");
        $state = '0';

     	 $data = array(
		'si_no'  => $this->input->post('id'),
	    "airline_name" => $this->input->post('airline'),
        "iata" => $this->input->post('iata'),
		"icao" => $this->input->post('icao'),
		"url" => $this->input->post('url'),
		"image" => $this->input->post('image'),
               
        );
            //print_r($data);
            //exit();
        $this->Trichyairport_model->update_master_airline_table($data);
        
    }
	function delete_master_airline_table()
	{
		$data['in_deleted'] = '1';
        $this->Trichyairport_model->delete_master_airline_table($this->input->post('id'), $data);
	}



	function trichy_master_flight_status()
    {
        if ($this->login_check() === true) {
            $this->load->view('trichy_master_flight_status_table');
        } else {
            $this->load->view('trichylogin');
        }
    }
	function get_flight_status_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Trichyairport_model->get_flight_status_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['result'] = "Error in Trichy_airport/get_flight_status_table get Query";
            echo json_encode($get);
        }
    }
	function insert_flight_status_table()
	{
        // $data['status'] = true;
        // $airport = $this->input->post('airport');
        // $state = '0';
        // $time_stamp = date("Y-m-d H:i:s");

        $data_airport = array(
			"place" => $this->input->post('airport')
            
        );


        $ins_airport = $this->Trichyairport_model->insert_master_airport_MFS($data_airport);

        $flight_data = array(
			"airport_id" => $ins_airport,
			"url" => $this->input->post('url'),
			"source" => $this->input->post('code')
        );

        $data['result'] = $this->Trichyairport_model->insert_flight_status_table($flight_data);
        echo json_encode($data);
    }
	function update_flight_status_table()
    {
	

		if ($_POST['table_column'] == 'airport') {
            $data_destination = array(
                "place" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_master_airport_MFS($data_destination, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'url') {
			$data = array(
                "url" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_flight_status_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'code') {
            $data = array(
                "source" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_flight_status_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'date') {
            $data = array(
                "create_at" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_flight_status_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}
    }
	function delete_flight_status_table()
	{
		$data['in_deleted'] = '1';
        $this->Trichyairport_model->delete_flight_status_table($this->input->post('id'), $data);
	}





	function trichy_master_missed_Airport_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('trichy_master_missed_Airport_table');
        } else {
            $this->load->view('trichylogin');
        }
    }
	function get_trichymaster_missed_Airport_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Trichyairport_model->get_trichymaster_missed_Airport_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['result'] = "Error in Trichy_airport/get_trichymaster_missed_Airport_table get Query";
            echo json_encode($get);
        }
    }
	function delete_master_missed_airport_Table()
	{
		// $data['create_at'] = date("Y-m-d H:i:s");
        $data['status'] = '1';
        $this->Trichyairport_model->delete_master_missed_airport_table($this->input->post('id'), $data);
    }




	function trichy_master_missed_Airline_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('trichy_master_missed_Airline_table');
        } else {
            $this->load->view('trichylogin');
        }
    }
	function get_trichymaster_missed_Airline_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Trichyairport_model->get_trichymaster_missed_Airline_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['result'] = "Error in Trichy_airport/get_trichymaster_missed_Airline_table get Query";
            echo json_encode($get);
        }
    }
	function delete_master_missed_airline_table()
    {
        // $data['time_stamp'] = date("Y-m-d H:i:s");
        $data['status'] = '1';
        $this->Trichyairport_model->delete_master_missed_airline_table($this->input->post('id'), $data);
    }




	function trichy_master_access_log_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('trichy_master_access_log_table');
        } else {
            $this->load->view('trichylogin');
        }
    }
	function get_trichymaster_access_log_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Trichyairport_model->get_trichymaster_access_log_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['result'] = "Error in Trichy_airport/get_trichymaster_access_log_table get Query";
            echo json_encode($get);
        }
    }




	function trichy_master_error_log_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('trichy_master_error_log_table');
        } else {
            $this->load->view('trichylogin');
        }
    }
	function get_trichymaster_error_log_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Trichyairport_model->get_trichymaster_error_log_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['result'] = "Error in Trichy_airport/get_trichymaster_error_log_table get Query";
            echo json_encode($get);
        }
    }


	function master_slug_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('master_slug_table');
        } else {
            $this->load->view('trichylogin');
        }
    }
	function get_master_slug_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Trichyairport_model->get_master_slug_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['result'] = "Error in Trichy_airport/get_master_slug_table get Query";
            echo json_encode($get);
        }
    }
	function insert_master_slug_table()
	{
        $slug_data = array(
			"wp_slug" => $this->input->post('slug'),
			"flight_url" => $this->input->post('url'),
			"source" => $this->input->post('source')
        );

        $data['result'] = $this->Trichyairport_model->insert_master_slug_table($slug_data);
        echo json_encode($data);
    }
	function update_master_slug_table()
    {
	

		if ($_POST['table_column'] == 'slug') {
            $data = array(
                "wp_slug" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_master_slug_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'url') {
			$data = array(
                "flight_url" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_master_slug_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'source') {
            $data = array(
                "source" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Trichyairport_model->update_master_slug_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
    	}
	}
	function delete_master_slug_table()
	{
		$data['in_deleted'] = '1';
        $this->Trichyairport_model->delete_master_slug_table($this->input->post('id'), $data);
	}
	function trichylogout()
    {
        unset($_SESSION["is_logged_in"]);
        $this->load->view('trichylogin');
    }

	// start departure selenium json data
	function getdepartureseleniumData()
    {
		$get = $this->Trichyairport_model->get_TrichyMasterDepartureSelenium_table();
        if (!empty($get)) {
            echo json_encode($get);
        } else {
			$get = "No Data Found";
            echo json_encode($get);
        }
    }
	public function departureSelenium(){
		$url = 'http://app.trichyairport.in/getds';
		$json = file_get_contents($url);
		$data['departureSelenium'] = json_decode($json);
		// echo $data['departureSelenium'][1]->airline;
		// die;
		$this->load->view('departureSelenium', $data);
	}
	// end departure selenium json data

	// start departure json data
	public function getdepartureData(){

        $get = $this->Trichyairport_model->get_TrichyMasterDeparture_table();
        if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}
	public function departure(){
		$url = 'http://app.trichyairport.in/getd';
		$json = file_get_contents($url);
		$data['departure'] = json_decode($json);
		// echo $data['departure'][1]->airline;
		// die;
		$this->load->view('departure', $data);
	}
	// end departure selenium json data

		// start arrival selenium json data
		function getarrivalseleniumData()
    {

        $get = $this->Trichyairport_model->get_TrichyMasterArrivalSelenium_table();
        if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
    }
	public function arrivalSelenium(){
		$url = 'http://app.trichyairport.in/getas';
		$json = file_get_contents($url);
		$data['arrivalSelenium'] = json_decode($json);
		// echo $data['arrival'][1]->airline;
		// die;
		$this->load->view('arrivalSelenium', $data);
	}
	// end arrival selenium json data

	//start arrival json data
	function getarrivalData()
    {
        $get = $this->Trichyairport_model->get_TrichyMasterArrival_table();
        if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
    }
	public function arrival(){
		$url = 'http://app.trichyairport.in/geta';
		$json = file_get_contents($url);
		$data['arrival'] = json_decode($json);
		// echo $data['arrival'][1]->airline;
		// die;
		$this->load->view('arrival', $data);
	}
	// end arrival json data

	public function get(){
		// die;
		$url = 'http://localhost/flight-status-admin/get';
$json = file_get_contents($url);
// var_dump(json_decode($json));
// echo $jo[0];
$jo = json_decode($json);
// Object.keys(data.shareInfo[i]).length;
echo $jo[0]->airport;
	}
	public function putData(){
		// die;
		$curl= curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_URL, 'https://trichyairport.in/wp-json/wp/v2/posts?1');
$res = curl_exec($curl);
curl_close($curl);
$jo = json_decode($res);
echo $jo[0]->id;
	  }
	  public function wordpress($data1='', $data2=''){
		// $this->load->view('test');
		// echo $data1;
		// echo $data2;
		// die;
		$get = $this->Trichyairport_model->get_Wordpress_Data($data1, $data2);
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}
	function getflightData()
	{
		
        $get = $this->Trichyairport_model->get_TrichyMasterFlightSelenium_table();
        if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
    
	}
	// api file for wordpres
	function get_Apiflights($data='')
	{
		$get = $this->Trichyairport_model->get_Apiflights($data);
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}

	// api file for arrival flights wordpres
	function get_ApiArrival($data='')
	{
		$get = $this->Trichyairport_model->get_ApiArrival($data);
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}

	// api file for departure flights wordpres
	function get_ApiDeparture($data='')
	{
		$get = $this->Trichyairport_model->get_ApiDeparture($data);
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}

	// api file for slug table wordpres
	function get_Apislug()
	{
		$get = $this->Trichyairport_model->get_Apislug();
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}

	// api file for slug table wordpres
	function get_slug_url($data='')
	{
		
		$get = $this->Trichyairport_model->get_slug_url($data);
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}
}
