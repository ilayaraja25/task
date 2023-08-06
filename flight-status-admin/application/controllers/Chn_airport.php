<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
class Chn_airport extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form', 'url');
        $this->load->model('Chnairport_model');
        $this->load->library('form_validation');
    }
    public function index()
    {

        $this->load->view('login');
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
                $check = $this->Chnairport_model->check_login($data);
                if (empty($check)) {
                    $data['message'] = "Password or Email is incorrect";
                    $this->load->view('login', $data);
                } elseif ($check == true) {
                    $_SESSION["is_logged_in"] = true;
                    $this->load->view('home');
                }
            }
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
    function home()
    {
        if ($this->login_check() === true) {
            $this->load->view('home');
        } else {
            $this->load->view('login');
        }
    }
    /**Script Run Function */
    function script_run()
    {
        $this->chn_arrival();
        //echo "<br>";
        $this->chn_departure();
        //echo "<br>";
        $this->trz_arrival();
        //echo "<br>";
        $this->trz_departure();

        $this->home();
    }
    /**For Storing Data into Db from json file Function */
    function chn_arrival()
    {
        $type = 'arrival';
        $airport = 'chennai';

        /**Pre-defined Variables */
        $data_airport['airport_name'] = 'chennai';

        $data_p['time_stamp'] = date('Y-m-d H:i:s');
        $data_ti['time_stamp'] = date('Y-m-d H:i:s');
        $data_f['time_stamp'] = date('Y-m-d H:i:s');
        $data_s['time_stamp'] = date('Y-m-d H:i:s');
        $data_airport['time_stamp'] = date('Y-m-d H:i:s');

        $data_p['state'] = '0';
        $data_ti['state'] = '0';
        $data_f['state'] = '0';
        $data_s['state'] = '0';
        $data_airport['state'] = '0';

        $result = shell_exec('python3 assets/py/Chennai_airport/carrivals-2.py 2>&1');

        $dec = json_decode(file_get_contents('assets/py/Chennai_airport/arrivals2.json'), 1);
        //print_r($dec);

        $origin1 = $dec['origin'][0];
        unset($origin1[0]);

        //print_r($origin1).'<br>';
        //print'<br>';

        $origin2 = $dec['origin'][1];
        unset($origin2[0]);

        //print_r($origin2).'<br>';
        //print'<br>';


        $origin3 = $dec['origin'][2];
        unset($origin3[0]);
        //print_r($origin3).'<br>';
        //print'<br>';

        $origin4 = $dec['origin'][3];
        unset($origin4[0]);
        //print_r($origin3).'<br>';
        //print'<br>';
        $origin = array_merge($origin1, $origin2, $origin3, $origin4);

        //print_r($origin).'<br>';
        //print'<br>'; 
        $arrival1 = $dec['arrival'][0];
        unset($arrival1[0]);
        $arrival2 = $dec['arrival'][1];
        unset($arrival2[0]);
        $arrival3 = $dec['arrival'][2];
        unset($arrival3[0]);
        $arrival4 = $dec['arrival'][3];
        unset($arrival4[0]);
        $arrival = array_merge($arrival1, $arrival2, $arrival3, $arrival4);

        //print_r($arrival).'<br>';



        $airline1 = $dec['airline'][0];
        unset($airline1[0]);
        $airline2 = $dec['airline'][1];
        unset($airline2[0]);
        $airline3 = $dec['airline'][2];
        unset($airline3[0]);
        $airline4 = $dec['airline'][3];
        unset($airline4[0]);
        $airline = array_merge($airline1, $airline2, $airline3, $airline4);

        //print_r($airline).'<br>';

        //print'<br>';

        $flight1 = $dec['flight'][0];
        unset($flight1[0]);
        $flight2 = $dec['flight'][1];
        unset($flight2[0]);
        $flight3 = $dec['flight'][2];
        unset($flight3[0]);
        $flight4 = $dec['flight'][3];
        unset($flight4[0]);
        $flight = array_merge($flight1, $flight2, $flight3, $flight4);

        //print_r($flight).'<br>';
        //print'<br>';

        $terminal1 = $dec['terminal'][0];
        unset($terminal1[0]);
        $terminal2 = $dec['terminal'][1];
        unset($terminal2[0]);
        $terminal3 = $dec['terminal'][2];
        unset($terminal3[0]);
        $terminal4 = $dec['terminal'][3];
        unset($terminal4[0]);
        $terminal = array_merge($terminal1, $terminal2, $terminal3, $terminal4);

        //print_r($terminal).'<br>';
        //print'<br>';

        $status1 = $dec['status'][0];
        unset($status1[0]);
        $status2 = $dec['status'][1];
        unset($status2[0]);
        $status3 = $dec['status'][2];
        unset($status3[0]);
        $status4 = $dec['status'][3];
        unset($status4[0]);
        $status = array_merge($status1, $status2, $status3, $status4);

        //print_r($status).'<br>';
        //print'<br>';

        /*        print(count($origin));  
        print'<br>';
        print(count($arrival)); 
        print'<br>';
        print(count($airline));  
        print'<br>';
        print(count($flight)); 
        print'<br>';
        print(count($terminal));
        print'<br>';
        print(count($status)); 
        exit();
       */
        $origin_c = count($origin);
        $arrival_c = count($arrival);
        $flight_c = count($flight);
        $airline_c = count($airline);
        $terminal_c = count($terminal);
        $status_c = count($status);
        /*
        echo $origin_c. '<br>';
        echo $arrival_c. '<br>';
        echo $flight_c. '<br>';
        echo $airline_c. '<br>';
        echo $terminal_c . '<br>';
        echo $status_c. '<br>';
        */
        //print_r($origin);
        //$data['place']= 'Kochi\n(COj)';
        //$ins_place=$this->ChnairportApi_model->insert_place($data);
        //print_r( $ins_place);


        if (($origin_c == $arrival_c) && ($arrival_c == $flight_c) && ($flight_c == $airline_c) && ($airline_c == $terminal_c) && ($terminal_c == $status_c)) {

            for ($i = 1; $i < $origin_c; $i++) {
                if (empty($origin[$i])) {
                    $data_p['place'] = 'NULL';
                } else {
                    $data_p['place'] = $origin[$i];
                }
                if (empty($arrival[$i])) {
                    $data_ti['time'] = 'NULL';
                } else {
                    $data_ti['time'] = $arrival[$i];
                }
                if (empty($flight[$i])) {
                    $data_f['number'] = 'NULL';
                } else {
                    $data_f['number'] = $flight[$i];
                }
                if (empty($airline[$i])) {
                    $data_f['flight_name']  = 'NULL';
                } else {
                    $data_f['flight_name'] = $airline[$i];
                }
                if (empty($terminal[$i])) {
                    $data_p['terminal'] = 'NULL';
                } else {
                    $data_p['terminal'] = $terminal[$i];
                }
                if (empty($status[$i])) {
                    $data_s['status'] = 'NULL';
                } else {
                    $data_s['status'] = $status[$i];
                }

                /* print_r($data_p); print'<br>';
                print_r($data_f);print'<br>';
                print_r($data_ti);print'<br>';
                print_r($data_s);print'<br>';
                */

                $ins_airport = $this->Chnairport_model->insert_airport_py($data_airport);
                $ins_place = $this->Chnairport_model->insert_place_py($data_p);
                //print_r($ins_place);
                $ins_time = $this->Chnairport_model->insert_time_py($data_ti);
                $ins_flight = $this->Chnairport_model->insert_name_number_py($data_f);
                $ins_status = $this->Chnairport_model->insert_status_py($data_s);

                //print($ins_place);    


                $l_data = array(
                    'place_id' => $ins_place,
                    'flight_id' => $ins_flight,
                    'time_id' => $ins_time,
                    'status_id' => $ins_status,
                    'type' => $type,
                    'time_stamp' => $data_p['time_stamp'],
                    'airport_id' => $ins_airport,
                    'state' => $data_p['state']

                );
                //print_r($l_data);
                //print"<br>";
                //exit();
                $output = $this->Chnairport_model->insert_live_table_py($l_data);
                /*if(empty($output)){
                    echo "success";
                }else{
                    echo "Fail";
                }*/
                //exit();
            }
        } else {
            $data['status'] = false;
            $data['result'] = 'Rows Count not matching';
            print_r($data);
        }
    }
    function chn_departure()
    {
        $type = 'departure';


        $data_p['time_stamp'] = date('Y-m-d H:i:s');
        $data_ti['time_stamp'] = date('Y-m-d H:i:s');
        $data_f['time_stamp'] = date('Y-m-d H:i:s');
        $data_s['time_stamp'] = date('Y-m-d H:i:s');

        $data_p['state'] = '0';
        $data_ti['state'] = '0';
        $data_f['state'] = '0';
        $data_s['state'] = '0';

        $data_airport['state'] = '0';
        $data_airport['time_stamp'] = date('Y-m-d H:i:s');
        $data_airport['airport_name'] = 'chennai';
        $result = shell_exec('python3 assets/py/Chennai_airport/cdepartures-2.py 2>&1');

        $dec = json_decode(file_get_contents('assets/py/Chennai_airport/departures2.json'), 1);
        //print_r($dec);
        $origin1 = $dec['origin'][0];
        unset($origin1[0]);

        //print_r($origin1).'<br>';
        //print'<br>';

        $origin2 = $dec['origin'][1];
        unset($origin2[0]);

        //print_r($origin2).'<br>';
        //print'<br>';


        $origin3 = $dec['origin'][2];
        unset($origin3[0]);
        //print_r($origin3).'<br>';
        //print'<br>';

        $origin4 = $dec['origin'][3];
        unset($origin4[0]);
        //print_r($origin3).'<br>';
        //print'<br>';
        $origin = array_merge($origin1, $origin2, $origin3, $origin4);

        //print_r($origin).'<br>';
        //print'<br>'; 
        $arrival1 = $dec['arrival'][0];
        unset($arrival1[0]);
        $arrival2 = $dec['arrival'][1];
        unset($arrival2[0]);
        $arrival3 = $dec['arrival'][2];
        unset($arrival3[0]);
        $arrival4 = $dec['arrival'][3];
        unset($arrival4[0]);
        $arrival = array_merge($arrival1, $arrival2, $arrival3, $arrival4);

        //print_r($arrival).'<br>';



        $airline1 = $dec['airline'][0];
        unset($airline1[0]);
        $airline2 = $dec['airline'][1];
        unset($airline2[0]);
        $airline3 = $dec['airline'][2];
        unset($airline3[0]);
        $airline4 = $dec['airline'][3];
        unset($airline4[0]);
        $airline = array_merge($airline1, $airline2, $airline3, $airline4);

        //print_r($airline).'<br>';

        //print'<br>';

        $flight1 = $dec['flight'][0];
        unset($flight1[0]);
        $flight2 = $dec['flight'][1];
        unset($flight2[0]);
        $flight3 = $dec['flight'][2];
        unset($flight3[0]);
        $flight4 = $dec['flight'][3];
        unset($flight4[0]);
        $flight = array_merge($flight1, $flight2, $flight3, $flight4);

        //print_r($flight).'<br>';
        //print'<br>';

        $terminal1 = $dec['terminal'][0];
        unset($terminal1[0]);
        $terminal2 = $dec['terminal'][1];
        unset($terminal2[0]);
        $terminal3 = $dec['terminal'][2];
        unset($terminal3[0]);
        $terminal4 = $dec['terminal'][3];
        unset($terminal4[0]);
        $terminal = array_merge($terminal1, $terminal2, $terminal3, $terminal4);

        //print_r($terminal).'<br>';
        //print'<br>';

        $status1 = $dec['status'][0];
        unset($status1[0]);
        $status2 = $dec['status'][1];
        unset($status2[0]);
        $status3 = $dec['status'][2];
        unset($status3[0]);
        $status4 = $dec['status'][3];
        unset($status4[0]);
        $status = array_merge($status1, $status2, $status3, $status4);

        //print_r($status).'<br>';
        //print'<br>';
        $origin_c = count($origin);
        $arrival_c = count($arrival);
        $flight_c = count($flight);
        $airline_c = count($airline);
        $terminal_c = count($terminal);
        $status_c = count($status);
        /*
        echo $origin_c. '<br>';
        echo $arrival_c. '<br>';
        echo $flight_c. '<br>';
        echo $airline_c. '<br>';
        echo $terminal_c . '<br>';
        echo $status_c. '<br>';
        */
        //exit();
        //print_r($origin);
        //$data['place']= 'Kochi\n(COj)';
        //$ins_place=$this->ChnairportApi_model->insert_place($data);
        //print_r( $ins_place);


        if (($origin_c == $arrival_c) && ($arrival_c == $flight_c) && ($flight_c == $airline_c) && ($airline_c == $terminal_c) && ($terminal_c == $status_c)) {

            for ($i = 1; $i < $origin_c; $i++) {
                if (empty($origin[$i])) {
                    $data_p['place'] = 'NULL';
                } else {
                    $data_p['place'] = $origin[$i];
                }
                if (empty($arrival[$i])) {
                    $data_ti['time'] = 'NULL';
                } else {
                    $data_ti['time'] = $arrival[$i];
                }
                if (empty($flight[$i])) {
                    $data_f['number'] = 'NULL';
                } else {
                    $data_f['number'] = $flight[$i];
                }
                if (empty($airline[$i])) {
                    $data_f['flight_name']  = 'NULL';
                } else {
                    $data_f['flight_name'] = $airline[$i];
                }
                if (empty($terminal[$i])) {
                    $data_p['terminal'] = 'NULL';
                } else {
                    $data_p['terminal'] = $terminal[$i];
                }
                if (empty($status[$i])) {
                    $data_s['status'] = 'NULL';
                } else {
                    $data_s['status'] = $status[$i];
                }
                /*
                print_r($data_p);
                print_r($data_f);
                print_r($data_ti);
                print_r($data_s);
                */
                //exit();

                $ins_airport = $this->Chnairport_model->insert_airport_py($data_airport);
                $ins_place = $this->Chnairport_model->insert_place_py($data_p);
                //print_r($ins_place);
                $ins_time = $this->Chnairport_model->insert_time_py($data_ti);
                $ins_flight = $this->Chnairport_model->insert_name_number_py($data_f);
                $ins_status = $this->Chnairport_model->insert_status_py($data_s);

                //print($ins_place);    


                $l_data = array(
                    'place_id' => $ins_place,
                    'flight_id' => $ins_flight,
                    'time_id' => $ins_time,
                    'status_id' => $ins_status,
                    'type' => $type,
                    'time_stamp' => $data_p['time_stamp'],
                    'airport_id' => $ins_airport,
                    'state' => $data_p['state']

                );
                //print_r($l_data);
                //print'<br>';
                $output = $this->Chnairport_model->insert_live_table_py($l_data);
                //print_r($l_data);
                //print'<br>';
                /*
                if (empty($output)) {
                    echo "success";
                } else {
                    echo "Fail";
                }*/
            }
        } else {
            $data['status'] = false;
            $data['result'] = 'Rows Count not matching';
            print_r($data);
        }
    }
    function trz_arrival()
    {
        $type = 'arrival';

        $data_p['terminal'] = 'NULL';

        $data_p['time_stamp'] = date('Y-m-d H:i:s');
        $data_ti['time_stamp'] = date('Y-m-d H:i:s');
        $data_f['time_stamp'] = date('Y-m-d H:i:s');
        $data_s['time_stamp'] = date('Y-m-d H:i:s');

        $data_p['state'] = '0';
        $data_ti['state'] = '0';
        $data_f['state'] = '0';
        $data_s['state'] = '0';

        $data_airport['state'] = '0';
        $data_airport['time_stamp'] = date('Y-m-d H:i:s');
        $data_airport['airport_name'] = 'tirchy';
        $result = shell_exec('python3 assets/py/Tirchy_airport/trchyarrivals1.py 2>&1');

        $dec = json_decode(file_get_contents('assets/py/Tirchy_airport/tarrival1.json'), 1);
        $dec_count = count($dec);
        for ($i = 1; $i < $dec_count; $i++) {
            //print_r($dec[$i]['data']);
            //print '<br>';
            $input = $dec[$i]['data'];
            if (empty($input[2])) {
                $data_p['place'] = 'NULL';
            } else {
                $data_p['place'] = $input[2];
            }
            if (empty($input[3])) {
                $data_ti['time'] = 'NULL';
            } else {
                $time = $input[3];
                $df = date_create_from_format("g:i A", $time);
                $data_ti['time'] = date_format($df, "H:i");
                //print_r($dfc . '\n');
            }
            if (empty($input[0])) {
                $data_f['number'] = 'NULL';
            } else {
                $data_f['number'] = $input[0];
            }
            if (empty($input[1])) {
                $data_f['flight_name']  = 'NULL';
            } else {
                $data_f['flight_name'] = $input[1];
            }
            if (empty($input[4])) {
                $data_s['status'] = 'NULL';
            } else {
                $data_s['status'] = $input[4];
            }
            /*
            print_r($data_p);
            print '<br>';
            print_r($data_f);
            print '<br>';
            print_r($data_ti);
            print '<br>';
            print_r($data_s);
            print '<br>';
            */

            $ins_airport = $this->Chnairport_model->insert_airport_py($data_airport);
            $ins_place = $this->Chnairport_model->insert_place_py($data_p);
            //print_r($ins_place);
            $ins_time = $this->Chnairport_model->insert_time_py($data_ti);
            $ins_flight = $this->Chnairport_model->insert_name_number_py($data_f);
            $ins_status = $this->Chnairport_model->insert_status_py($data_s);


            $l_data = array(
                'place_id' => $ins_place,
                'flight_id' => $ins_flight,
                'time_id' => $ins_time,
                'status_id' => $ins_status,
                'type' => $type,
                'time_stamp' => $data_p['time_stamp'],
                'airport_id' => $ins_airport,
                'state' => $data_p['state']

            );
            //print_r($l_data);

            $output = $this->Chnairport_model->insert_live_table_py($l_data);
            //print_r($l_data);
            //print'<br>';
            /*if (empty($output)) {
                echo "success";
            } else {
                echo "Fail";
            }*/
        }
    }
    function trz_departure()
    {
        $type = 'departure';

        $data_p['terminal'] = 'NULL';

        $data_p['time_stamp'] = date('Y-m-d H:i:s');
        $data_ti['time_stamp'] = date('Y-m-d H:i:s');
        $data_f['time_stamp'] = date('Y-m-d H:i:s');
        $data_s['time_stamp'] = date('Y-m-d H:i:s');

        $data_p['state'] = '0';
        $data_ti['state'] = '0';
        $data_f['state'] = '0';
        $data_s['state'] = '0';

        $data_airport['state'] = '0';
        $data_airport['time_stamp'] = date('Y-m-d H:i:s');
        $data_airport['airport_name'] = 'tirchy';
        $result = shell_exec('python3 assets/py/Tirchy_airport/trchydepartures1.py 2>&1');

        $dec = json_decode(file_get_contents('assets/py/Tirchy_airport/tdeparture1.json'), 1);
        //print_r($dec);

        //exit();
        $dec_count = count($dec);
        for ($i = 1; $i < $dec_count; $i++) {
            //print_r($dec[$i]['data']);
            //print '<br>';
            $input = $dec[$i]['data'];
            if (empty($input[2])) {
                $data_p['place'] = 'NULL';
            } else {
                $data_p['place'] = $input[2];
            }
            if (empty($input[3])) {
                $data_ti['time'] = 'NULL';
            } else {
                $time = $input[3];
                $df = date_create_from_format("g:i A", $time);
                $data_ti['time'] = date_format($df, "H:i");
            }
            if (empty($input[0])) {
                $data_f['number'] = 'NULL';
            } else {
                $data_f['number'] = $input[0];
            }
            if (empty($input[1])) {
                $data_f['flight_name']  = 'NULL';
            } else {
                $data_f['flight_name'] = $input[1];
            }
            if (empty($input[4])) {
                $data_s['status'] = 'NULL';
            } else {
                $data_s['status'] = $input[4];
            }

            /*print_r($data_p);
            print '<br>';
            print_r($data_f);
            print '<br>';
            print_r($data_ti);
            print '<br>';
            print_r($data_s);
            print '<br>';
            
            */
            $ins_airport = $this->Chnairport_model->insert_airport_py($data_airport);
            $ins_place = $this->Chnairport_model->insert_place_py($data_p);
            //print_r($ins_place);
            $ins_time = $this->Chnairport_model->insert_time_py($data_ti);
            $ins_flight = $this->Chnairport_model->insert_name_number_py($data_f);
            $ins_status = $this->Chnairport_model->insert_status_py($data_s);


            $l_data = array(
                'place_id' => $ins_place,
                'flight_id' => $ins_flight,
                'time_id' => $ins_time,
                'status_id' => $ins_status,
                'type' => $type,
                'time_stamp' => $data_p['time_stamp'],
                'airport_id' => $ins_airport,
                'state' => $data_p['state']

            );
            //print_r($l_data);

            $output = $this->Chnairport_model->insert_live_table_py($l_data);
            //print_r($l_data);
            //print'<br>';
            /*if (empty($output)) {
                echo "success";
            } else {
                echo "Fail";
            }*/
        }
    }
    /**End of the Storing data in Db Function */

    /**Admin panel Master live table Function */
    function master_live_status_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('master_live_status_table');
        } else {
            $this->load->view('login');
        }
    }
    function insert_master_live_table()
    {
        $data['status'] = true;
        $airport = $this->input->post('airport');
        $state = '0';
        $time_stamp = date("Y-m-d H:i:s");

        $data_p = array(
            "state" => $state,
            "place" => $this->input->post('place'),
            "terminal" => $this->input->post('terminal'),
            "time_stamp" => $time_stamp
        );

        $data_f = array(
            "state" => $state,
            "number" => $this->input->post('flight'),
            "flight_name" => $this->input->post('airline'),
            "time_stamp" => $time_stamp,
        );

        $data_ti = array(
            "state" => $state,
            "time" => $this->input->post('time'),
            "time_stamp" => $time_stamp
        );

        $data_s = array(
            "state" => $state,
            "status" => $this->input->post('status'),
            "time_stamp" => $time_stamp
        );
        $data_airport = array(
            "airport_name" => $airport,
            "state" => $state,
            "time_stamp" => $time_stamp
        );

        $ins_place = $this->Chnairport_model->insert_master_place($data_p);
        $ins_flight = $this->Chnairport_model->insert_master_flight($data_f);
        $ins_time = $this->Chnairport_model->insert_master_time($data_ti);
        $ins_status = $this->Chnairport_model->insert_master_status($data_s);
        $ins_airport = $this->Chnairport_model->insert_master_airport($data_airport);

        $l_data = array(
            "place_id" => $ins_place,
            "flight_id" => $ins_flight,
            "time_id" => $ins_time,
            "status_id" => $ins_status,
            "type" => $this->input->post('type'),
            "time_stamp" => $time_stamp,
            "airport_id" => $ins_airport,
            "state" => $state
        );

        $data['result'] = $this->Chnairport_model->insert_master_live_table($l_data);
        echo json_encode($data);
    }
    function update_master_live_table()
    {

        $time_stamp = date("Y-m-d H:i:s");
        $state = '0';
        $place = $this->input->post('place');
        $terminal = $this->input->post('terminal');
        $flight =  $this->input->post('flight');
        $airline = $this->input->post('airline');


        if ($_POST['table_column'] == 'place') {
            $data_p = array(
                $this->input->post('table_column') => $this->input->post('value'),
                "time_stamp" => $time_stamp,
                "state" => $state,
                "terminal" => $terminal
            );
            //print_r($data_p);
            //exit();
            $this->Chnairport_model->update_place_master($data_p, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'time') {
            $data_ti = array(
                $this->input->post('table_column') => $this->input->post('value'),
                "time_stamp" => $time_stamp,
                "state" => $state
            );
            //print_r($data_ti);
            //exit();
            $this->Chnairport_model->update_time_master($data_ti, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'flight') {
            $data_f = array(
                "number" => $this->input->post('value'),
                "time_stamp" => $time_stamp,
                "state" => $state,
                "flight_name" => $airline
            );

            //print_r($data);
            //exit();
            $this->Chnairport_model->update_flight_master($data_f, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'airline') {
            $data_f = array(
                "flight_name" => $this->input->post('value'),
                "number" => $flight,
                "time_stamp" => $time_stamp,
                "state" => $state
            );

            //print_r($data);
            //exit();
            $this->Chnairport_model->update_flight_master($data_f, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'terminal') {
            $data_p = array(
                $this->input->post('table_column') => $this->input->post('value'),
                "time_stamp" => $time_stamp,
                "state" => $state,
                "place" => $place
            );
            //print_r($data);
            //exit();
            $this->Chnairport_model->update_place_master($data_p, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'status') {
            $data_s = array(
                $this->input->post('table_column') => $this->input->post('value'),
                "time_stamp" => $time_stamp,
                "state" => $state
            );
            //print_r($data);
            //exit();
            $this->Chnairport_model->update_status_master($data_s, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'type') {
            $data_type = array(
                $this->input->post('table_column') => $this->input->post('value'),
                "time_stamp" => $time_stamp
            );
            //print_r($data);
            //exit();
            $this->Chnairport_model->update_master_live_table($data_type, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'airport') {
            $data_airport = array(
                "airport_name" => $this->input->post('value'),
                "time_stamp" => $time_stamp,
                "state" => $state
            );
            //print_r($data);
            //exit();
            $this->Chnairport_model->update_airport_master($data_airport, $this->input->post('id'));
            //print_r($res);
            //exit();
        } elseif ($_POST['table_column'] == 'state') {
            $data_state = array(
                $this->input->post('table_column') => $this->input->post('value'),
                "time_stamp" => $time_stamp,
            );
            //print_r($data);
            //exit();
            $this->Chnairport_model->update_master_live_table($data_state, $this->input->post('id'));
            //print_r($res);
            //exit();
        }
    }
    function delete_master_live_table()
    {
        $data['time_stamp'] = date("Y-m-d H:i:s");
        $data['state'] = '1';
        $this->Chnairport_model->delete_master_live_table($this->input->post('id'), $data);
    }
    function get_MasterLiveStatus_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Chnairport_model->get_MasterLiveStatus_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['result'] = "Error in Chn_airport/get_MasterLiveStatus_table get Query";
            echo json_encode($get);
        }
    }
    /**Admin panel Place table Function  */
    function master_place_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('places_table');
        } else {
            $this->load->view('login');
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

        $this->Chnairport_model->insert_master_place_table($data);
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
            $this->Chnairport_model->update_master_place_table($data, $this->input->post('id'));
        } elseif (($this->input->post('table_column')) == 'terminal') {
            $data = array(
                "terminal" => $this->input->post('value'),
                "place" => $this->input->post('place'),
                "time_stamp" => $time_stamp,
                "state" => $state
            );
            $this->Chnairport_model->update_master_place_table($data, $this->input->post('id'));
        }
    }
    function delete_master_place_table()
    {
        $data['time_stamp'] = date("Y-m-d H:i:s");
        $data['state'] = '1';
        $this->Chnairport_model->delete_master_place_table($this->input->post('id'), $data);
    }
    function get_master_place_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Chnairport_model->get_master_place_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['result'] = "Error in Chn_airport/get_master_place_table get Query";
            echo json_encode($get);
        }
    }

    /**Admin panel flight table Function  */
    function master_flight_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('flights_table');
        } else {
            $this->load->view('login');
        }
    }
    function insert_master_flight_table()
    {

        $data['time_stamp'] = date("Y-m-d H:i:s");
        $data['state'] = '0';
        $data['flight_name'] = $this->input->post('flight_name');
        $data['number'] = $this->input->post('number');

        $this->Chnairport_model->insert_master_flight_table($data);
    }
    function update_master_flight_table()
    {
        $time_stamp = date("Y-m-d H:i:s");
        $state = '0';

        if (($this->input->post('table_column')) == 'flight_name') {
            $data = array(
                "flight_name" => $this->input->post('value'),
                "number" => $this->input->post('number'),
                "time_stamp" => $time_stamp,
                "state" => $state
            );
            //print_r($data);
            //exit();
            $this->Chnairport_model->update_master_flight_table($data, $this->input->post('id'));
        } elseif (($this->input->post('table_column')) == 'number') {
            $data = array(
                "number" => $this->input->post('value'),
                "flight_name" => $this->input->post('flight_name'),
                "time_stamp" => $time_stamp,
                "state" => $state
            );
            //print_r($data);
            //exit();
            $this->Chnairport_model->update_master_flight_table($data, $this->input->post('id'));
        }
    }
    function delete_master_flight_table()
    {
        $data['time_stamp'] = date("Y-m-d H:i:s");
        $data['state'] = '1';
        $this->Chnairport_model->delete_master_flight_table($this->input->post('id'), $data);
    }
    function get_master_flight_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Chnairport_model->get_master_flight_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['result'] = "Error in Chn_airport/get_master_place_table get Query";
            echo json_encode($get);
        }
    }

    /**Admin panel Time table Function  */

    function master_time_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('times_table');
        } else {
            $this->load->view('login');
        }
    }
    function insert_master_time_table()
    {
        $time_stamp = date("Y-m-d H:i:s");
        $state = '0';
        $data = array(
            "time" => $this->input->post('time'),
            "state" => $state,
            "time_stamp" => $time_stamp
        );
        $this->Chnairport_model->insert_master_time_table($data);
    }
    function update_master_time_table()
    {
        $time_stamp = date("Y-m-d H:i:s");
        $state = '0';
        $data = array(
            "time" => $this->input->post('value'),
            "time_stamp" => $time_stamp,
            "state" => $state
        );
        $this->Chnairport_model->update_master_time_table($data, $this->input->post('id'));
    }
    function delete_master_time_table()
    {
        $data['time_stamp'] = date("Y-m-d H:i:s");
        $data['state'] = '1';
        $this->Chnairport_model->delete_master_time_table($this->input->post('id'), $data);
    }
    function get_master_time_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Chnairport_model->get_master_time_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['result'] = "Error in Chn_airport/get_master_place_table get Query";
            echo json_encode($get);
        }
    }

    /**Admin panel Status table Function  */
    function master_status_table()
    {
        if ($this->login_check() === true) {
            $this->load->view('status_table');
        } else {
            $this->load->view('login');
        }
    }
    function insert_master_status_table()
    {
        $time_stamp = date("Y-m-d H:i:s");
        $state = '0';
        $data = array(
            "status" => $this->input->post('status'),
            "state" => $state,
            "time_stamp" => $time_stamp
        );
        $this->Chnairport_model->insert_master_status_table($data);
    }
    function update_master_status_table()
    {
        $time_stamp = date("Y-m-d H:i:s");
        $state = '0';
        $data = array(
            "status" => $this->input->post('value'),
            "time_stamp" => $time_stamp,
            "state" => $state
        );
        $this->Chnairport_model->update_master_status_table($data, $this->input->post('id'));
    }
    function delete_master_status_table()
    {
        $data['time_stamp'] = date("Y-m-d H:i:s");
        $data['state'] = '1';
        $this->Chnairport_model->delete_master_status_table($this->input->post('id'), $data);
    }
    function get_master_status_table()
    {
        $get['status'] = true;
        $get['result'] = $this->Chnairport_model->get_master_status_table();
        if (!empty($get['result'])) {
            echo json_encode($get);
        } else {
            $get['status'] = false;
            $get['result'] = "Error in Chn_airport/get_master_place_table get Query";
            echo json_encode($get);
        }
    }
    function logout()
    {
        unset($_SESSION["is_logged_in"]);
        $this->load->view('login');
    }
}
