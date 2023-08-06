<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
class Airport_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form', 'url');
        $this->load->model('Airport_Model');
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
                $check = $this->Airport_Model->check_login($data);
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

	//Departure selenium Table Controller All Functions

	function master_departure_selenium_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('Departure_selenium_table');
        } else {
            $this->load->view('trichylogin');
        }
    }
	function get_TrichyMasterDepartureSelenium_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Airport_Model->get_TrichyMasterDepartureSelenium_table();
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

        $ins_airport = $this->Airport_Model->insert_master_airport($data_airport);
        $ins_airline = $this->Airport_Model->insert_master_airline($data_airline);
        $ins_destination = $this->Airport_Model->insert_master_1_airport_1($data_destination);

        $departure_data = array(
            "airport_id" => $ins_airport,
			"airline_id" => $ins_airline,
			"flight_no" => $this->input->post('flight'),
			"destination_id" => $ins_destination,
			"departure" => $this->input->post('departure'),
			"terminal" => $this->input->post('terminal'),
			"status" => $this->input->post('status')
        );

        $data['result'] = $this->Airport_Model->insert_departure_selenium_table($departure_data);
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
            $this->Airport_Model->update_master_airport_table3($data_from, $this->input->post('id'));
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
            $this->Airport_Model->update_master_airline_status_table3($data_airline, $this->input->post('id'));
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
            $this->Airport_Model->update_master_airport_1_table3($data_destination, $this->input->post('id'));
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
            $this->Airport_Model->update_departure_selenium_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_departure_selenium_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_departure_selenium_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_departure_selenium_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_departure_selenium_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}
    }

	function delete_departure_selenium_table()
	{
		$data['in_deleted'] = '1';
        $this->Airport_Model->delete_departure_selenium_table($this->input->post('id'), $data);
	}


// Departure Flights Controller CRUD Functions

	function master_departure_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('Departure_table');
        } else {
            $this->load->view('trichylogin');
        }
    }
	function get_TrichyMasterDeparture_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Airport_Model->get_TrichyMasterDeparture_table();
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
			"airport_name" => $this->input->post('airport')
            
        );

        $data_airline = array(
            "airline_name" => $this->input->post('airline')
        );

        $data_dest = array(
           "airport_name" => $this->input->post('destination')
        );
		$data_from = array(
			"airport_name" => $this->input->post('origin')
		 );

        $ins_airport = $this->Airport_Model->insert_master_airport($data_airport);
		$ins_from = $this->Airport_Model->insert_master_airport_origin($data_from);
        $ins_airline = $this->Airport_Model->insert_master_airline($data_airline);
        $ins_destination = $this->Airport_Model->insert_master_airport_destination($data_dest);

        $departure_data = array(
            "airport_id" => $ins_airport,
			"from_id" => $ins_from,
			"airline_id" => $ins_airline,
			"flight_no" => $this->input->post('flight'),
			"destination_id" => $ins_destination,
			"departure_time" => $this->input->post('departure'),
			"arrival_time" => $this->input->post('arrival'),
			"terminal" => $this->input->post('terminal'),
			"status" => $this->input->post('status')
        );

        $data['result'] = $this->Airport_Model->insert_departure_table($departure_data);
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


        if ($_POST['table_column'] == 'origin') {
			$data_from = array(
                "airport_name" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "terminal" => $terminal
            );
            //print_r($data_p);
            //exit();
            $this->Airport_Model->update_master_airport_origin($data_from, $this->input->post('id'));
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
            $this->Airport_Model->update_master_airline_status($data_airline, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'destination') {
            $data_destination = array(
                "airport_name" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Airport_Model->update_master_airport_dest($data_destination, $this->input->post('id'));
            //print_r($res);
            //exit();
		} elseif ($_POST['table_column'] == 'airport') {
            $data_airport = array(
                "airport_name" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Airport_Model->update_master_airport($data_airport, $this->input->post('id'));
            //print_r($res);
            //exit();
		}
		elseif ($_POST['table_column'] == 'number') {
			$data = array(
                "flight_no" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Airport_Model->update_departure_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_departure_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		} elseif ($_POST['table_column'] == 'arrival_time') {
            $data = array(
                "arrival_time" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Airport_Model->update_departure_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}
		elseif ($_POST['table_column'] == 'terminal') {
            $data = array(
                "terminal" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Airport_Model->update_departure_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_departure_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_departure_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}
    }

	function delete_departure_table()
	{
		$data['in_deleted'] = '1';
        $this->Airport_Model->delete_departure_table($this->input->post('id'), $data);
	}


// Arrival Selenium CRUD Functions

	function master_arrival_selenium_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('Arrival_selenium_table');
        } else {
            $this->load->view('trichylogin');
        }
    }
	function get_TrichyMasterArrivalSelenium_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Airport_Model->get_TrichyMasterArrivalSelenium_table();
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

        $ins_from = $this->Airport_Model->insert_master_airport($data_from);
        $ins_airline = $this->Airport_Model->insert_master_airline($data_airline);
        $ins_airport = $this->Airport_Model->insert_master_airport_1($data_airport);

        $arrival_data = array(
            "from_id" => $ins_from,
			"airline_id" => $ins_airline,
			"flight_no" => $this->input->post('flight'),
			"destination_id" => $ins_airport,
			"arrival" => $this->input->post('arrival'),
			"terminal" => $this->input->post('terminal'),
			"status" => $this->input->post('status')
        );

        $data['result'] = $this->Airport_Model->insert_arrival_selenium_table($arrival_data);
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
            $this->Airport_Model->update_master_airport_table($data_from, $this->input->post('id'));
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
            $this->Airport_Model->update_master_airline_status_table($data_airline, $this->input->post('id'));
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
            $this->Airport_Model->update_master_airport_1_table($data_destination, $this->input->post('id'));
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
            $this->Airport_Model->update_arrival_selenium_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_arrival_selenium_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_arrival_selenium_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_arrival_selenium_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_arrival_selenium_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}
    }
	function delete_arrival_selenium_table()
	{
		$data['in_deleted'] = '1';
        $this->Airport_Model->delete_arrival_selenium_table($this->input->post('id'), $data);
	}


//Arrival flights CRUD Functions

	function master_arrival_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('Arrival_table');
        } else {
            $this->load->view('trichylogin');
        }
    }
	
	function get_TrichyMasterArrival_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Airport_Model->get_TrichyMasterArrival_table();
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
			"airport_name" => $this->input->post('origin')
            
        );

        $data_airline = array(
            "airline_name" => $this->input->post('airline')
        );

        $data_airport = array(
           "airport_name" => $this->input->post('airport')
        );

		$data_dest = array(
			"airport_name" => $this->input->post('destination')
		 );

        $ins_dest = $this->Airport_Model->insert_master_airport_destination($data_dest);
		$ins_from = $this->Airport_Model->insert_master_airport_origin($data_from);
        $ins_airline = $this->Airport_Model->insert_master_airline($data_airline);
        $ins_airport = $this->Airport_Model->insert_master_airport($data_airport);

        $arrival_data = array(
			// "airport_id" =>
			"airline_id" => $ins_airline,
			"airport_id" => $ins_airport,
			"flight_no" => $this->input->post('flight'),
			"departure_time" => $this->input->post('departure'),
			"arrival_time" => $this->input->post('arrival'),
			"from_id" => $ins_from,
			"destination_id" => $ins_dest,
			"terminal" => $this->input->post('terminal'),
			"status" => $this->input->post('status')
        );

        $data['result'] = $this->Airport_Model->insert_arrival_table($arrival_data);
        echo json_encode($data);
	}
	function update_arrival_table()
	{
		$time_stamp = date("Y-m-d H:i:s");
        $state = '0';
        // $from = $this->input->post('origin');
        // $airline = $this->input->post('airline');
        // $flight =  $this->input->post('flight');
        // $airport = $this->input->post('airport');
		// $departure = $this->input->post('departure_time');
		// $arrival = $this->input->post('arrival_time');
		// $terminal = $this->input->post('terminal');
		// $status = $this->input->post('status');


        if ($_POST['table_column'] == 'origin') {
			$data_from = array(
                "airport_name" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "terminal" => $terminal
            );
            //print_r($data_p);
            //exit();
            $this->Airport_Model->update_master_airport_origin($data_from, $this->input->post('id'));
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
            $this->Airport_Model->update_master_airline_status($data_airline, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'destination') {
            $data_destination = array(
                "airport_name" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Airport_Model->update_master_airport_dest($data_destination, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'airport') {
            $data_airport = array(
                "airport_name" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            // print_r($data_airport);
			// die();
            // exit();
            $this->Airport_Model->update_master_airport($data_airport, $this->input->post('id'));
            //print_r($res);
            //exit();
		}
		elseif ($_POST['table_column'] == 'number') {
			$data = array(
                "flight_no" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Airport_Model->update_arrival_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_arrival_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}
		elseif ($_POST['table_column'] == 'arrival_time') {
            $data = array(
                "arrival_time" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Airport_Model->update_arrival_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_arrival_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_arrival_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_arrival_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}
    }
	function delete_arrival_table()
	{
		$data['in_deleted'] = '1';
        $this->Airport_Model->delete_arrival_table($this->input->post('id'), $data);
	}



//Flight selenium CRUD Functions

	function master_flight_selenium_table()
	{
		if ($this->login_check() === true) {
            $this->load->view('Flight_selenium_table');
        } else {
            $this->load->view('trichylogin');
        }
	}
	function get_TrichyMasterFlightSelenium_table()
	{
		$get['status'] = true;
        $get['result'] = $this->Airport_Model->get_TrichyMasterFlightSelenium_table();
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

        $ins_from = $this->Airport_Model->insert_master_airport_from($data_from);
		$ins_dest = $this->Airport_Model->insert_master_airport_dest($data_dest);
        $ins_airline = $this->Airport_Model->insert_master_airline_1($data_airline);
        $ins_airport = $this->Airport_Model->insert_master_airport_airport($data_airport);

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

        $data['result'] = $this->Airport_Model->insert_flight_selenium_table($flight_data);
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
            $this->Airport_Model->update_master_airportFS_airport($data_airport, $this->input->post('id'));
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
            $this->Airport_Model->update_master_airline_statusFS($data_airline, $this->input->post('id'));
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
            $this->Airport_Model->update_master_airportFS_from($data_from, $this->input->post('id'));
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
            $this->Airport_Model->update_master_airportFS_dest($data_destination, $this->input->post('id'));
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
            $this->Airport_Model->update_flight_selenium($data, $this->input->post('id'));
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
            $this->Airport_Model->update_flight_selenium($data, $this->input->post('id'));
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
            $this->Airport_Model->update_flight_selenium($data, $this->input->post('id'));
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
            $this->Airport_Model->update_flight_selenium($data, $this->input->post('id'));
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
            $this->Airport_Model->update_flight_selenium($data, $this->input->post('id'));
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
            $this->Airport_Model->update_flight_selenium($data, $this->input->post('id'));
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
            $this->Airport_Model->update_flight_selenium($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}
    }
	function delete_flight_selenium_table()
	{
		$data['in_deleted'] = '1';
        $this->Airport_Model->delete_flight_selenium_table($this->input->post('id'), $data);
	}


// Flight Table CRUD Functions

	function master_flight_table()
	{
		if ($this->login_check() === true) {
            $this->load->view('Flight_table');
        } else {
            $this->load->view('trichylogin');
        }
	}
	 public function fetchData(){
	    $this->load->model('Trichyairport_model');
      $result['table']= $this->Trichyairport_model->getData();
	  $this->load->view('display-record',$result);
	}
	  public function send_Value($Id)
	{//4
         $this->load->model('Trichyairport_model');
		 $result['data']=$this->Trichyairport_model->editData($Id);
		 $this->load->view('display-record',$result);
	}
	   public function delete($Id){//6
	 
	  $this->load->model('Trichyairport_model');
	 $result=$this->Trichyairport_model->deleteData($Id);
        if(isset($result)){
            $this->fetchdata();
	   }
	   }
	public function saveData(){
		extract($_post);
	}
	function get_TrichyMasterFlight_table()
	{
		// die('1');
		$get['status'] = true;
        $get['result'] = $this->Airport_Model->get_TrichyMasterFlight_table();
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
			"airport_name" => $this->input->post('origin')
            
        );

		$data_dest = array(
			"airport_name" => $this->input->post('destination')
            
        );

        $data_airline = array(
            "airline_name" => $this->input->post('airline')
        );

        $data_airport = array(
           "airport_name" => $this->input->post('airport')
        );

        $ins_from = $this->Airport_Model->insert_master_airport_origin($data_from);
		$ins_dest = $this->Airport_Model->insert_master_airport_destination($data_dest);
        $ins_airline = $this->Airport_Model->insert_master_airline($data_airline);
        $ins_airport = $this->Airport_Model->insert_master_airport($data_airport);

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

        $data['result'] = $this->Airport_Model->insert_flight_table($flight_data);
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
                "airport_name" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "terminal" => $terminal
            );
            //print_r($data_p);
            //exit();
            $this->Airport_Model->update_master_airport($data_airport, $this->input->post('id'));
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
            $this->Airport_Model->update_master_airline_status($data_airline, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'origin') {
            $data_from = array(
                "airport_name" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Airport_Model->update_master_airport_origin($data_from, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'destination') {
            $data_destination = array(
                "airport_name" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Airport_Model->update_master_airport_dest($data_destination, $this->input->post('id'));
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
            $this->Airport_Model->update_flight_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_flight_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_flight_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_flight_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_flight_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_flight_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_flight_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}
    }
	function delete_flight_table()
	{
		$data['in_deleted'] = '1';
        $this->Airport_Model->delete_flight_table($this->input->post('id'), $data);
	}



//Airline Table CRUD functions

	function Airlines_table()
	{
		if ($this->login_check() === true) {
            $this->load->view('Airlines_table');
        } else {
            $this->load->view('trichylogin');
        }
	}
	function get_TrichyMasterAirline_table()
	{
		// die('1');
		$get['status'] = true;
        $get['result'] = $this->Airport_Model->get_TrichyMasterAirline_table();
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
			"airport_name" => $this->input->post('origin')
            
        );

		$data_dest = array(
			"airport_name" => $this->input->post('destination')
            
        );

        $data_airline = array(
            "airline_name" => $this->input->post('airline')
        );

        $ins_from = $this->Airport_Model->insert_master_airport_origin($data_from);
		$ins_dest = $this->Airport_Model->insert_master_airport_destination($data_dest);
        $ins_airline = $this->Airport_Model->insert_master_airline($data_airline);
        

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

        $data['result'] = $this->Airport_Model->insert_airline_table($flight_data);
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
            $this->Airport_Model->update_master_airline_status_airline($data_airline, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'origin') {
            $data_from = array(
                "airport_name" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Airport_Model->update_master_airport_origin_airline($data_from, $this->input->post('id'));
            //print_r($res);
            //exit();
		}elseif ($_POST['table_column'] == 'destination') {
            $data_destination = array(
                "airport_name" => $this->input->post('value'),
                // "time_stamp" => $time_stamp,
                // "state" => $state,
                // "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Airport_Model->update_master_airport_dest_airline($data_destination, $this->input->post('id'));
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
            $this->Airport_Model->update_airline_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_airline_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_airline_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_airline_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_airline_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_airline_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}
    }
	function delete_airline_table()
	{
		$data['in_deleted'] = '1';
        $this->Airport_Model->delete_airline_table($this->input->post('id'), $data);
	}




//Airline Selenium table CRUD Functions

	function master_AirlineSelenium_table()
	{
		if ($this->login_check() === true) {
            $this->load->view('Airline_Selenium_table');
        } else {
            $this->load->view('trichylogin');
        }
	}
	function get_TrichyMasterAirlineSelenium_table()
	{
		// die('1');
		$get['status'] = true;
        $get['result'] = $this->Airport_Model->get_TrichyMasterAirlineSelenium_table();
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

        $ins_from = $this->Airport_Model->insert_master_airport_fromAS($data_from);
		$ins_dest = $this->Airport_Model->insert_master_airport_destAS($data_dest);
        $ins_airline = $this->Airport_Model->insert_master_airline_1AS($data_airline);
        

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

        $data['result'] = $this->Airport_Model->insert_airline_selenium_table($flight_data);
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
            $this->Airport_Model->update_master_airline_statusAS($data_airline, $this->input->post('id'));
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
            $this->Airport_Model->update_master_airport_fromAS($data_from, $this->input->post('id'));
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
            $this->Airport_Model->update_master_airport_destAS($data_destination, $this->input->post('id'));
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
            $this->Airport_Model->update_airline_selenium_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_airline_selenium_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_airline_selenium_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_airline_selenium_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_airline_selenium_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_airline_selenium_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}
    }
	function delete_airline_selenium_table()
	{
		$data['in_deleted'] = '1';
        $this->Airport_Model->delete_airline_selenium_table($this->input->post('id'), $data);
	}




// Master Airport table CRUD functions

	function master_airport_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('master_airport_table');
        } else {
            $this->load->view('trichylogin');
        }
    }
	function get_trichymaster_place_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Airport_Model->get_trichymaster_place_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['result'] = "Error in Airport_Controller/get_trichymaster_place_table get Query";
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

        $this->Airport_Model->insert_master_place_table($data);
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
            $this->Airport_Model->update_master_place_table($data, $this->input->post('id'));
        } elseif (($this->input->post('table_column')) == 'terminal') {
            $data = array(
                "terminal" => $this->input->post('value'),
                "place" => $this->input->post('place'),
                "time_stamp" => $time_stamp,
                "state" => $state
            );
            $this->Airport_Model->update_master_place_table($data, $this->input->post('id'));
        }
    }
	function delete_master_place_Table()
	{
		$data['terminal'] = '1';
        $this->Airport_Model->delete_master_place_Table($this->input->post('id'), $data);
	}




//Mster Airline table CRUD functions

	function master_airline_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('airline_table');
        } else {
            $this->load->view('trichylogin');
        }
    }
	function get_trichymaster_airline_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Airport_Model->get_trichymaster_airline_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['result'] = "Error in Airport_Controller/get_trichymaster_airline_table get Query";
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


        // $this->Airport_Model->insert_master_airline_table($data);
		// $data['time_stamp'] = date("Y-m-d H:i:s");
        // $data['state'] = '0';
        // $data['airline_name'] = $this->input->post('airline_name');
        // $data['number'] = $this->input->post('number');

        $this->Airport_Model->insert_master_airline_table($data);
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
        $this->Airport_Model->update_master_airline_table($data);
        
    }
	function delete_master_airline_table()
	{
		$data['in_deleted'] = '1';
        $this->Airport_Model->delete_master_airline_table($this->input->post('id'), $data);
	}


// Master Flight status Table CRUD Functions

	function master_flight_status()
    {
        if ($this->login_check() === true) {
            $this->load->view('master_flight_status_table');
        } else {
            $this->load->view('trichylogin');
        }
    }
	function get_flight_status_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Airport_Model->get_flight_status_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['result'] = "Error in Airport_Controller/get_flight_status_table get Query";
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


        $ins_airport = $this->Airport_Model->insert_master_airport_MFS($data_airport);

        $flight_data = array(
			"airport_id" => $ins_airport,
			"url" => $this->input->post('url'),
			"source" => $this->input->post('code')
        );

        $data['result'] = $this->Airport_Model->insert_flight_status_table($flight_data);
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
            $this->Airport_Model->update_master_airport_MFS($data_destination, $this->input->post('id'));
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
            $this->Airport_Model->update_flight_status_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_flight_status_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_flight_status_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
		}
    }
	function delete_flight_status_table()
	{
		$data['in_deleted'] = '1';
        $this->Airport_Model->delete_flight_status_table($this->input->post('id'), $data);
	}




// Master Missed Airport table CRUD Functions

	function master_missed_Airport_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('master_missed_Airport_table');
        } else {
            $this->load->view('trichylogin');
        }
    }
	function get_trichymaster_missed_Airport_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Airport_Model->get_trichymaster_missed_Airport_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['result'] = "Error in Airport_Controller/get_trichymaster_missed_Airport_table get Query";
            echo json_encode($get);
        }
    }
	function delete_master_missed_airport_Table()
	{
		// $data['create_at'] = date("Y-m-d H:i:s");
        $data['status'] = '1';
        $this->Airport_Model->delete_master_missed_airport_table($this->input->post('id'), $data);
    }



// MAster missed Airline Table CRUD Functions

	function master_missed_Airline_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('master_missed_Airline_table');
        } else {
            $this->load->view('trichylogin');
        }
    }
	function get_trichymaster_missed_Airline_table()
    {
        
		$get['status'] = true;
        $get['result'] = $this->Airport_Model->get_trichymaster_missed_Airline_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['result'] = "Error in Airport_Controller/get_trichymaster_missed_Airline_table get Query";
            echo json_encode($get);
        }
    }
	function delete_master_missed_airline_table()
    {
        // $data['time_stamp'] = date("Y-m-d H:i:s");
        $data['status'] = '1';
        $this->Airport_Model->delete_master_missed_airline_table($this->input->post('id'), $data);
    }


// Access log table CRUD Functions

	function master_access_log_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('master_access_log_table');
        } else {
            $this->load->view('trichylogin');
        }
    }
	function get_trichymaster_access_log_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Airport_Model->get_trichymaster_access_log_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['result'] = "Error in Airport_Controller/get_trichymaster_access_log_table get Query";
            echo json_encode($get);
        }
    }



// Error log Table CRUD FUnctions

	function master_error_log_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('master_error_log_table');
        } else {
            $this->load->view('trichylogin');
        }
    }
	function get_trichymaster_error_log_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Airport_Model->get_trichymaster_error_log_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['result'] = "Error in Airport_Controller/get_trichymaster_error_log_table get Query";
            echo json_encode($get);
        }
    }

// mAster slug table CRUD functions

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
        $get['result'] = $this->Airport_Model->get_master_slug_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['result'] = "Error in Airport_Controller/get_master_slug_table get Query";
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

        $data['result'] = $this->Airport_Model->insert_master_slug_table($slug_data);
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
            $this->Airport_Model->update_master_slug_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_master_slug_table($data, $this->input->post('id'));
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
            $this->Airport_Model->update_master_slug_table($data, $this->input->post('id'));
            //print_r($res);
            //exit();
    	}
	}
	function delete_master_slug_table()
	{
		$data['in_deleted'] = '1';
        $this->Airport_Model->delete_master_slug_table($this->input->post('id'), $data);
	}


// Trichy logout functions
	function trichylogout()
    {
        unset($_SESSION["is_logged_in"]);
        $this->load->view('trichylogin');
    }




	// start departure selenium json data
	function getdepartureseleniumData()
    {
		$get = $this->Airport_Model->get_TrichyMasterDepartureSelenium_table();
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

        $get = $this->Airport_Model->get_TrichyMasterDeparture_table();
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

        $get = $this->Airport_Model->get_TrichyMasterArrivalSelenium_table();
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
        $get = $this->Airport_Model->get_TrichyMasterArrival_table();
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
		$get = $this->Airport_Model->get_Wordpress_Data($data1, $data2);
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}
	function getflightData()
	{
		
        $get = $this->Airport_Model->get_TrichyMasterFlightSelenium_table();
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
		// $password = "kira";





		$get = $this->Airport_Model->get_Apiflights($data);
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
		$get = $this->Airport_Model->get_ApiArrival($data);
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
		$get = $this->Airport_Model->get_ApiDeparture($data);
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
		
		$get = $this->Airport_Model->get_Apislug();
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}

	// api file for slug table wordpres
	function get_ApislugFlight()
	{
		
		$get = $this->Airport_Model->get_ApislugFlight();
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}

	// api file for slug table wordpres
	function get_slug_url($data_1='', $data_2='')
	{
		
		$get = $this->Airport_Model->get_slug_url($data_1, $data_2);
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}

	// api file for slug table wordpres
	function get_slug_url_sitemap($data_1='', $data_2='')
	{
		
		$get = $this->Airport_Model->get_slug_url_sitemap($data_1, $data_2);
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}


	//function for Dubai Airport Data
	public function get_DubaiData()
	{

		$get = $this->Airport_Model->get_DubaiData();
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}

	public function get_Dubai_Departure_Data()
	{

		$get = $this->Airport_Model->get_Dubai_Departure_Data();
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}

	public function get_Dubai_Arrival_Data()
	{
		
		$get = $this->Airport_Model->get_Dubai_Arrival_Data();
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}

	public function get_Dubai_Departure_dest_Data($data='')
	{

		$get = $this->Airport_Model->get_Dubai_Departure_dest_Data($data);
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}

	public function get_chennai_Departure_dest_Data($data='')
	{

		$get = $this->Airport_Model->get_chennai_Departure_dest_Data($data);
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}

	public function get_Dubai_Arrival_dest_Data($data='')
	{

		$get = $this->Airport_Model->get_Dubai_Arrival_dest_Data($data);
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}

	public function get_chennai_Arrival_dest_Data($data='')
	{

		$get = $this->Airport_Model->get_chennai_Arrival_dest_Data($data);
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}

	public function Dubai_Destination()
	{

		$get = $this->Airport_Model->get_Dubai_Departure_Data();
		// $a1["wp_slug"]=[];
		if (!empty($get)) {
			// echo json_encode($get);
		 } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
		$data_1 = json_encode($get);
		$data = json_decode($data_1);
		foreach($data as $a)
			{
				$code = ($a->{'code'});
				$city = ($a->{'city'});
				// $code = substr($da, 1, 3);
				// array_push($a,$code);
				// $name = substr($da, strpos($da, ") ") + 1);
				// $first = strtok($name, ' ');
				$new_string = str_replace(str_split('\\/:*?" <>|+,-'), '', $city);
				$a_1=$new_string;
				$a1=strtolower($a_1);
				// echo json_encode($a1);
				// echo json_encode($code);
				$find = $this->Airport_Model->find_dubai_destination_slug($a1);
				if (empty($find))
				{
					$this->Airport_Model->insert_dubai_destination_slug($a1, $code);
				}
				// $this->Airport_Model->insert_dubai_destination_slug($a1);
				// print_r($code);
				// break;
				
			}
	}
				// // $code = substr($da, 1, 3);
				// // array_push($a,$code);
				// // $name = substr($da, strpos($da, ") ") + 1);
				// // $first = strtok($name, ' ');
				// $new_string = str_replace(str_split('\\/:*?" <>|+,-'), '', $city);
				// $a_1=$new_string;
				// $a1=strtolower($a_1);
				// // echo json_encode($a1);
				// // echo json_encode($code);
				// $find = $this->Airport_Model->find_dubai_destination_slug($a1);
				// if (empty($find))
				// {
				// 	$this->Airport_Model->insert_dubai_destination_slug($a1, $code);
				// }
				// // $this->Airport_Model->insert_dubai_destination_slug($a1);
				// // print_r($code);
				// // break;
				
			
				public function Dubai_Arrival()
				{
			
					$get = $this->Airport_Model->get_Dubai_Arrival_Data();
					// $a1["wp_slug"]=[];
					if (!empty($get)) {
						// echo json_encode($get);
					 } else {
						$get = "No Data Found";
						echo json_encode($get);
					}
					$data_1 = json_encode($get);
					$data = json_decode($data_1);
					foreach($data as $a)
						{
							$code = ($a->{'code'});
							$city = ($a->{'city'});
							// array_push($a,$code);
							// $name = substr($da, strpos($da, ") ") + 1);
							// $first = strtok($name, ' ');
							$new_string = str_replace(str_split('\\/:*?" <>|+,-'), '', $city);
							$a_1=$new_string;
							$a1=strtolower($a_1);
							// echo json_encode($a1);
							// echo json_encode($code);
							$find = $this->Airport_Model->find_dubai_arrival_slug($a1);
							if (empty($find))
							{
								$this->Airport_Model->insert_dubai_arrival_slug($a1, $code);
							}
							
							
						}
				}
//under watch
	public function Dubai_Arrival_1()
	{

		$get = $this->Airport_Model->get_Dubai_Arrival_Data();
		// $a1["wp_slug"]=[];
		if (!empty($get)) {
			echo json_encode($get);
		 } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
		$data_1 = json_encode($get);
		$data = json_decode($data_1);
		$airport_code = $data[0]->{'airport_code'};
		$airport_name_1 = $data[0]->{'airport_city'};
		$airport_name=strtolower($airport_name_1);
		// print_r($airport_name);
		$array = array();
		foreach($data as $a)
			{
				$code = $a->code ."-". $a->city;
				// $airport_code = $a->airport_code;
				// print_r($airport_code);
				// $city = $a->city;
				// $data = $code = $city;
				array_push($array,$code);	
			}
		$original = array_unique($array);
		// print_r($original);
		foreach($original as $dest_code)
		{
				$small_letter=strtolower($dest_code);	
				$city = substr($small_letter, strpos($small_letter, "-") + 1);
				// print_r($city);
				// echo "<br>";
				// $small_letter=strtolower($dest_code);
				$code = strtok($small_letter, '-');
				// print_r($code." ".$city);
				// echo "<br>";
				$city = ($a->{'city'});
				$new_string = str_replace(str_split('\\/:*?" <>|+,-'), '', $city);
				$a_1=$new_string;
				$a1=strtolower($dest_code);
				// echo json_encode($a1);
				echo "<br>";
				// echo json_encode($code);
				// $find = $this->Airport_Model->find_dubai_arrival_slug($a1);
				// if (empty($find))
				// {
				// 	$this->Airport_Model->insert_arrival_slug($code, $city, $airport_code, $airport_name);
				// }

		}
	}

	public function get_Airline_Detail()
	{

		$get['status'] = true;
        $get['result'] = $this->Airport_Model->get_Airline_Detail();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['message'] = "No Data Found";
            echo json_encode($get);
        }
	}

	public function airline_detail()
	{
		if ($this->login_check() === true) {
            $this->load->view('Airline_Detail');
        } else {
            $this->load->view('trichylogin');
        }
	}

	public function get_Arrival_unique_Data($data_1='', $data_2='')
	{

		$get = $this->Airport_Model->get_Arrival_unique_Data($data_1, $data_2);
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}

	public function get_Departure_unique_Data($data_1='', $data_2='')
	{

		$get = $this->Airport_Model->get_Departure_unique_Data($data_1, $data_2);
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}

	// api for unique flights info
	function get_unique_flight($data_1='', $data_2='')
	{
		$flight_no = strtok($data_1, '-');
		// echo json_encode($flight_no);
		$get = $this->Airport_Model->get_unique_flight($flight_no, $data_2);
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}



	// api for unique flights info
	function get_unique_airlirne($data_1='', $data_2='')
	{
		
		$get = $this->Airport_Model->get_unique_airlirne($data_1, $data_2);
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}


	function get_airline_details($data='')
	{
		$get = $this->Airport_Model->get_airline_details($data);
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}

    function get_category($data='')
	{
		$get = $this->Airport_Model->get_category($data);
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}

	function get_category_field($data = '')
	{
		$get = $this->Airport_Model->get_category_field($data);
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}

	function get_airline_categeory_data($data='')
	{
		$code = $this->input->get('code');
		$get = $this->Airport_Model->get_airline_categeory_data($data, $code);
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}
	function airline_field_details()
	{
		$get = $this->Airport_Model->airline_field_details();
		if (!empty($get)) {
            echo json_encode($get);
        } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
	}
//------------------------------------------
	// public function get_slug()
	// {

	// 	$get = $this->Airport_Model->get_slug();
	// 	if (!empty($get)) {
    //         echo json_encode($get);
    //     } else {
    //         $get = "No Data Found";
    //         echo json_encode($get);
    //     }
	// }
	public function Insert_slug($data)
	{

		$get = $this->Airport_Model->get_slug($data);
		// $a1["wp_slug"]=[];
		if (!empty($get)) {
			// echo json_encode($get);
		 } else {
            $get = "No Data Found";
            echo json_encode($get);
        }
		$data_1 = json_encode($get);
		$data_2 = json_decode($data_1);
		// $airport_code = $data[0]->{'airport_code'};
		// $airport_name_1 = $data[0]->{'airport_city'};
		// $airport_name=strtolower($airport_name_1);
		// print_r($airport_name);
		$array = array();

		if($data == 'dxb'){
			$code = 1;
		}elseif($data == 'maa'){
			$code = 2;
		}elseif($data == 'trz'){
			$code = 3;
		}
		// $code = 3;
		// foreach($data as $a)
		// 	{
		// 		$code = $a->flight_no;
		// 		// $airport_code = $a->airport_code;
		// 		// print_r($airport_code);
		// 		// $city = $a->city;
		// 		// $data = $code = $city;
		// 		array_push($array,$code);	
		// 	}
		// $original = array_unique($array);
		// print_r($original);
		foreach($data_2 as $data_3)
		{
				// $small_letter=strtolower($dest_code);	
				// $city = substr($small_letter, strpos($small_letter, "-") + 1);
				// print_r($flight_no);
				// echo "<br>";
				// // $small_letter=strtolower($dest_code);
				// $code = strtok($small_letter, '-');
				// // print_r($code." ".$city);
				// echo "<br>";
		// 		$city = ($a->{'city'});
				$airline = $data_3->flight_no;
				// $iata = $data_1->iata_code;
				$new_string = str_replace(str_split('\\/:*?" <>|+,-'), '-', $airline);
				// $new_string_1 = str_replace(str_split('\\/:*?" <>|+,-'), '', $iata);
		// 		$a_1=$new_string;
				$flight_no=strtolower($new_string);
				$wpslug = $flight_no;
				$source = 'f';
				// $iata_code=strtolower($new_string_1);
				// echo json_encode($flight_no);
				// echo json_encode($iata_code);
				echo "<br>";
		// 		// echo json_encode($code);
				$find = $this->Airport_Model->find_slug($wpslug, $source, $code);
				if (empty($find))
				{
					$this->Airport_Model->insert_slug($flight_no, $code, $source, $data);
					echo json_encode("Data is insert successfully");
				}else{
					echo json_encode("Data is Already Availabel");
					// echo json_encode($find);
				}

		}
	}

	//-------------------------------------------------------------------------------------
}
