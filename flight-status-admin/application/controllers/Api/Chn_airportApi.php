<?php

require APPPATH . 'libraries/REST_Controller.php';
class Chn_airportApi extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url', 'form');
        $this->load->library('pagination');

        $this->load->model('ChnairportApi_model');
        date_default_timezone_set('Asia/Kolkata');
    }
    function get_airport_details_post()
    {
        $data['status'] = true;
        $times = '';
        $timee = '';

        if (isset($_POST['airport_name']) && isset($_POST['place']) && isset($_POST['type']) && isset($_POST['airline']) && isset($_POST['terminal']) && isset($_POST['time'])) {
            $airportname_i = $_POST['airport_name'] ? $_POST['airport_name'] : '';
            $destination_i = $_POST['place'] ? $_POST['place'] : '';
            $type_i = $_POST['type'] ? $_POST['type'] : '';
            $airline_i = $_POST['airline'] ? $_POST['airline'] : '';
            $terminal_i = $_POST['terminal'] ? $_POST['terminal'] : '';
            $time_i = $_POST['time'] ? $_POST['time'] : '';
            $airport_name = filter_var($airportname_i, FILTER_SANITIZE_STRING);
            $destination = filter_var($destination_i, FILTER_SANITIZE_STRING);
            $airline = filter_var($airline_i, FILTER_SANITIZE_STRING);
            $type = filter_var($type_i, FILTER_SANITIZE_STRING);
            $terminal = filter_var($terminal_i, FILTER_SANITIZE_NUMBER_INT);
            $time = filter_var($time_i, FILTER_SANITIZE_STRING);
            if ($time != '') {
                $tp = explode("-", $time, 2);
                $times = $tp[0];
                $timee = $tp[1];
            }
            //echo $tp[0].'<br>';
            //echo $tp[1].'<br>';
            /*print_r($airport_name);
            print_r('<br>');
            print_r($destination);
            print_r('<br>');
            print_r($type);
            print_r('<br>');
            print_r($airline);
            print_r('<br>');
            print_r($terminal);
            print_r('<br>');
            print_r($time);*/
            //exit();
            //|| $destination == '' || $type == '' || $terminal == '' || $time == '' || $airline == ''
            if ($airport_name == '' && $type == '') {
                $data['status'] = false;
                $data['result'] = 'Key values are Empty ';
                $this->response($data, REST_Controller::HTTP_NOT_FOUND);
            } else {
                $data['result'] = $this->ChnairportApi_model->get_airport_details($airport_name, $destination, $type, $airline, $terminal, $times, $timee);
                if (!empty($data['result'])) {
                    $data['no_of_results'] = count($data['result']);
                    $data['airline'] = $this->ChnairportApi_model->get_airport_airlines();
                    $data['terminal'] = $this->ChnairportApi_model->get_airport_terminals();
                    $this->response($data, REST_Controller::HTTP_OK);
                } else {

                    $data['status'] = false;
                    $data['result'] = 'No flight Details found';
                    $this->response($data, REST_Controller::HTTP_NOT_FOUND);
                }
            }
        } else {
            $data['status'] = false;
            $data['result'] = 'Error in request';
            $this->response($data, REST_Controller::HTTP_NOT_FOUND);
        }
    }
    function airport_detail_bykeyword_post()
    {
        $data['status'] = true;
        if (isset($_POST['airport_name']) && isset($_POST['type']) && isset($_POST['keyword'])) {
            $airportname_i = $_POST['airport_name'] ? $_POST['airport_name'] : '';
            $type_i = $_POST['type'] ? $_POST['type'] : '';
            $key_i = $_POST['keyword'] ? $_POST['keyword'] : '';
            $airport_name = filter_var($airportname_i, FILTER_SANITIZE_STRING);
            $key = filter_var($key_i, FILTER_SANITIZE_STRING);
            $type = filter_var($type_i, FILTER_SANITIZE_STRING);
            if ($key == '' && $airport_name == '' && $type == '') {
                $data['status'] = false;
                $data['result'] = 'Key values are Empty ';
                $this->response($data, REST_Controller::HTTP_NOT_FOUND);
            } else {
                $data['result'] = $this->ChnairportApi_model->airport_detail_bykeyword($key, $airport_name, $type);
                if (!empty($data['result'])) {
                    $data['no_of_results'] = count($data['result']);
                    $data['airline'] = $this->ChnairportApi_model->get_airport_airlines();
                    $data['terminal'] = $this->ChnairportApi_model->get_airport_terminals();
                    $this->response($data, REST_Controller::HTTP_OK);
                } else {

                    $data['status'] = false;
                    $data['result'] = 'No data Found';
                    $this->response($data, REST_Controller::HTTP_NOT_FOUND);
                }
            }
        } else {
            $data['status'] = false;
            $data['result'] = 'Error in request';
            $this->response($data, REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
