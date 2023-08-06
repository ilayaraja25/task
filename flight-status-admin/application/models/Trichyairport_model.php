<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Trichyairport_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
	function check_login($data)
    {
        $this->db->select('password');
        $this->db->from('user');
        $this->db->where('email', $data['email']);

        $sel = $this->db->get();
        $res = $sel->result_array();
        if (!empty($res)) {
            $password = $res[0]['password'];
            //echo $password . '<br>';
            //echo $data['password'];
            //die;
            if (password_verify($data['password'], $password)) {
                return true;
            }
        }
    }
	function get_TrichyMasterDepartureSelenium_table()
    {
		$date = date("Y-m-d");
		$status = '0';
        $this->db->select('ts.si_no as id, ts.flight_no as number, aip.place as airport,ts.departure, ts.status, ts.create_at as date, p.place as place, air.airline_name as airline');
        $this->db->where('date(ts.create_at)', $date);
		$this->db->where('(ts.in_deleted)', $status);
		$this->db->from('trz_departure_se as ts');
        $this->db->join('master_airport as p', 'p.place_id=ts.destination_id');
        $this->db->join('master_airport as aip', 'aip.place_id = ts.airport_id');
        $this->db->join('master_airline_status as air', 'air.si_no=ts.airline_id');
        
        // $this->db->join('master_airport as a', 'a.airport_id=ts.airport_id');

        $this->db->order_by('ts.si_no', 'ASC');

        $query = $this->db->get();
        //$queryy=$query->result_array();
        //print_r($queryy);
        //exit();
        return $query->result_array();
    }
	function update_master_airport_table3($data_from, $id)
    {
        $this->db->select('place_id');
        $this->db->where('place', $data_from['place']);
        // $this->db->where('terminal', $data_p['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "airport_id" => $res[0]['place_id'],
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_departure_se', $data);
        } else {
            $this->db->insert('master_airport', $data_from);
            $place_id = $this->db->insert_id();
            $data = array(
                "airport_id" => $place_id,
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_departure_se', $data);
        }
    }
	function update_master_airport_1_table3($data_destination, $id)
    {
        $this->db->select('place_id');
        $this->db->where('place', $data_destination['place']);
        // $this->db->where('terminal', $data_p['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "destination_id" => $res[0]['place_id'],
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_departure_se', $data);
        } else {
            $this->db->insert('master_airport', $data_destination);
            $place_id = $this->db->insert_id();
            $data = array(
                "destination_id" => $place_id,
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_departure_se', $data);
        }
    }
    function update_master_airline_status_table3($data_airline, $id)
    {
		$this->db->select('si_no');
        $this->db->where('airline_name', $data_airline['airline_name']);
        $sel = $this->db->get('master_airline_status');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "airline_id" => $res[0]['si_no'],
                // "time_stamp" => $data_ti['time_stamp']s
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_departure_se', $data);
        } else {
            $this->db->insert('master_airline_status', $data_airline);
            $time_id = $this->db->insert_id();
            $data = array(
                "airline_id" => $time_id,
                // "time_stamp" => $data_ti['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_departure_se', $data);
        }
    }
    
    function update_departure_selenium_table($data, $id)
    {
        $this->db->where('si_no', $id);
        $this->db->update('trz_departure_se', $data);
    }
	
	function get_TrichyMasterArrivalSelenium_table()
    {
		$date = date("Y-m-d");
		$status = '0';
        $this->db->select('ts.si_no as id, ts.flight_no as number, ts.arrival, ts.terminal, aip.place as airport, ts.status, ts.create_at as date, p.place as place, air.airline_name as airline');
        $this->db->where('date(ts.create_at)', $date);
		$this->db->where('(ts.in_deleted)', $status);
		$this->db->from('trz_arrival_se as ts');
        $this->db->join('master_airport as p', 'p.place_id=ts.from_id');
        $this->db->join('master_airport as aip', 'aip.place_id = ts.destination_id');
        $this->db->join('master_airline_status as air', 'air.si_no=ts.airline_id');
        
        // $this->db->join('master_airport as a', 'a.airport_id=ts.destination_id');

        $this->db->order_by('ts.si_no', 'ASC');

        $query = $this->db->get();
        //$queryy=$query->result_array();
        //print_r($queryy);
        //exit();
        return $query->result_array();
    }
	function update_master_airport_table($data_from, $id)
    {
        $this->db->select('place_id');
        $this->db->where('place', $data_from['place']);
        // $this->db->where('terminal', $data_p['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "from_id" => $res[0]['place_id'],
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_arrival_se', $data);
        } else {
            $this->db->insert('master_airport', $data_from);
            $place_id = $this->db->insert_id();
            $data = array(
                "from_id" => $place_id,
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_arrival_se', $data);
        }
    }
	function update_master_airport_1_table($data_destination, $id)
    {
        $this->db->select('place_id');
        $this->db->where('place', $data_destination['place']);
        // $this->db->where('terminal', $data_p['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "destination_id" => $res[0]['place_id'],
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_arrival_se', $data);
        } else {
            $this->db->insert('master_airport', $data_destination);
            $place_id = $this->db->insert_id();
            $data = array(
                "destination_id" => $place_id,
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_arrival_se', $data);
        }
    }
    function update_master_airline_status_table($data_airline, $id)
    {
		$this->db->select('si_no');
        $this->db->where('airline_name', $data_airline['airline_name']);
        $sel = $this->db->get('master_airline_status');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "airline_id" => $res[0]['si_no'],
                // "time_stamp" => $data_ti['time_stamp']s
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_arrival_se', $data);
        } else {
            $this->db->insert('master_airline_status', $data_airline);
            $time_id = $this->db->insert_id();
            $data = array(
                "airline_id" => $time_id,
                // "time_stamp" => $data_ti['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_arrival_se', $data);
        }
    }
    
    function update_arrival_selenium_table($data, $id)
    {
        $this->db->where('si_no', $id);
        $this->db->update('trz_arrival_se', $data);
    }
	function get_TrichyMasterArrival_table()
    {
		$date = date("Y-m-d");
		$status = '0';
        $this->db->select('ts.si_no as id, ts.flight_no as number, ts.arrival, ts.terminal, aip.place as airport, ts.status, ts.create_at as date, p.place as place, air.airline_name as airline');
        $this->db->where('date(ts.create_at)', $date);
		$this->db->where('(ts.in_deleted)', $status);
		$this->db->from('trz_arrival as ts');
        $this->db->join('master_airport as p', 'p.place_id=ts.from_id');
        $this->db->join('master_airport as aip', 'aip.place_id = ts.destination_id');
        $this->db->join('master_airline_status as air', 'air.si_no=ts.airline_id');
        
        // $this->db->join('master_airport as a', 'a.airport_id=ts.destination_id');

        $this->db->order_by('ts.si_no', 'ASC');

        $query = $this->db->get();
        //$queryy=$query->result_array();
        //print_r($queryy);
        //exit();
        return $query->result_array();
    }
	function update_master_airport_table2($data_from, $id)
    {
        $this->db->select('place_id');
        $this->db->where('place', $data_from['place']);
        // $this->db->where('terminal', $data_p['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "from_id" => $res[0]['place_id'],
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_arrival', $data);
        } else {
            $this->db->insert('master_airport', $data_from);
            $place_id = $this->db->insert_id();
            $data = array(
                "from_id" => $place_id,
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_arrival', $data);
        }
    }
	function update_master_airport_1_table2($data_destination, $id)
    {
        $this->db->select('place_id');
        $this->db->where('place', $data_destination['place']);
        // $this->db->where('terminal', $data_p['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "destination_id" => $res[0]['place_id'],
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_arrival', $data);
        } else {
            $this->db->insert('master_airport', $data_destination);
            $place_id = $this->db->insert_id();
            $data = array(
                "destination_id" => $place_id,
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_arrival_se', $data);
        }
    }
    function update_master_airline_status_table2($data_airline, $id)
    {
		$this->db->select('si_no');
        $this->db->where('airline_name', $data_airline['airline_name']);
        $sel = $this->db->get('master_airline_status');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "airline_id" => $res[0]['si_no'],
                // "time_stamp" => $data_ti['time_stamp']s
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_arrival', $data);
        } else {
            $this->db->insert('master_airline_status', $data_airline);
            $time_id = $this->db->insert_id();
            $data = array(
                "airline_id" => $time_id,
                // "time_stamp" => $data_ti['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_arrival', $data);
        }
    }
    
    function update_arrival_table($data, $id)
    {
        $this->db->where('si_no', $id);
        $this->db->update('trz_arrival', $data);
    }
	function get_TrichyMasterFlightSelenium_table()
	{
		$date = date("Y-m-d");
		$status = '0';
        $this->db->select('ts.si_no as id, p1.place as airport, air.airline_name, ts.flight_no, ts.type, ts.departure_time, ts.arrival_time, p.place as from, aip.place as dest, ts.terminal, ts.status, ts.create_at, ts.update_at');
        $this->db->where('date(ts.create_at)', $date);
		$this->db->where('(ts.in_deleted)', $status);
		$this->db->from('flights_selenium as ts');
        $this->db->join('master_airport as p', 'p.place_id=ts.from_id');
		$this->db->join('master_airport as p1', 'p1.place_id=ts.airport_id');
        $this->db->join('master_airport as aip', 'aip.place_id = ts.destination_id');
        $this->db->join('master_airline_status as air', 'air.si_no=ts.airline_id');

        // $this->db->join('master_airport as a', 'a.airport_id=ts.destination_id');

        $this->db->order_by('ts.si_no', 'ASC');

        $query = $this->db->get();
        //$queryy=$query->result_array();
        // print_r($query);
        //exit();
        return $query->result_array();
	}
	function insert_master_airport_from($data_from)
    {

        $this->db->select('place_id');
        $this->db->where('place', $data_from['place']);
        // $this->db->where('terminal', $data_from['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('master_airport', $data_from);
            $place_id = $this->db->insert_id();
            return $place_id;
        } else {
            $place_id = $res[0]['place_id'];
            return $place_id;
        }
		
    }
	function insert_master_airport_dest($data_dest)
    {

        $this->db->select('place_id');
        $this->db->where('place', $data_dest['place']);
        // $this->db->where('terminal', $data_from['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('master_airport', $data_dest);
            $place_id = $this->db->insert_id();
            return $place_id;
        } else {
            $place_id = $res[0]['place_id'];
            return $place_id;
        }
    }
	function insert_master_airline_1($data_airline)
    {

        $this->db->select('si_no');
        $this->db->where('airline_name', $data_airline['airline_name']);
        // $this->db->where('terminal', $data_from['terminal']);
        $sel = $this->db->get('master_airline_status');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('master_airline_status', $data_airline);
            $airline_id = $this->db->insert_id();
            return $airline_id;
        } else {
            $airline_id = $res[0]['si_no'];
            return $airline_id;
        }
    }
	function insert_master_airport_airport($data_airport)
    {

        $this->db->select('place_id');
        $this->db->where('place', $data_airport['place']);
        // $this->db->where('terminal', $data_from['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('master_airport', $data_airport);
            $place_id = $this->db->insert_id();
            return $place_id;
        } else {
            $place_id = $res[0]['place_id'];
            return $place_id;
        }
		
    }
	function insert_flight_selenium_table($flight_data)
    {
        $this->db->select('si_no');
        $this->db->where('from_id', $flight_data['from_id'])->where('airline_id', $flight_data['airline_id'])->where('flight_no', $flight_data['flight_no'])->where('destination_id', $flight_data['destination_id'])->where('arrival_time', $flight_data['arrival_time'])->where('departure_time', $flight_data['departure_time'])->where('terminal', $flight_data['terminal'])->where('status', $flight_data['status']);
        $sel = $this->db->get('flights_selenium');
        $res = $sel->result_array();
        //print_r($res);
        //exit();
        if (empty($res)) {

            $ins = $this->db->insert('flights_selenium', $flight_data);
            return $ins;
        }
    }
	function update_master_airportFS_from($data_from, $id)
    {
        $this->db->select('place_id');
        $this->db->where('place', $data_from['place']);
        // $this->db->where('terminal', $data_p['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "from_id" => $res[0]['place_id'],
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('flights_selenium', $data);
        } else {
            $this->db->insert('master_airport', $data_from);
            $place_id = $this->db->insert_id();
            $data = array(
                "from_id" => $place_id,
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('flights_selenium', $data);
        }
    }
	function update_master_airportFS_dest($data_destination, $id)
    {
        $this->db->select('place_id');
        $this->db->where('place', $data_destination['place']);
        // $this->db->where('terminal', $data_p['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "destination_id" => $res[0]['place_id'],
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('flights_selenium', $data);
        } else {
            $this->db->insert('master_airport', $data_destination);
            $place_id = $this->db->insert_id();
            $data = array(
                "destination_id" => $place_id,
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('flights_selenium', $data);
        }
    }
	function update_master_airportFS_airport($data_airport, $id)
    {
        $this->db->select('place_id');
        $this->db->where('place', $data_airport['place']);
        // $this->db->where('terminal', $data_p['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "airport_id" => $res[0]['place_id'],
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('flights_selenium', $data);
        } else {
            $this->db->insert('master_airport', $data_airport);
            $place_id = $this->db->insert_id();
            $data = array(
                "airport_id" => $place_id,
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('flights_selenium', $data);
        }
    }
    function update_master_airline_statusFS($data_airline, $id)
    {
		$this->db->select('si_no');
        $this->db->where('airline_name', $data_airline['airline_name']);
        $sel = $this->db->get('master_airline_status');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "airline_id" => $res[0]['si_no'],
                // "time_stamp" => $data_ti['time_stamp']s
            );
            $this->db->where('si_no', $id);
            $this->db->update('flights_selenium', $data);
        } else {
            $this->db->insert('master_airline_status', $data_airline);
            $time_id = $this->db->insert_id();
            $data = array(
                "airline_id" => $time_id,
                // "time_stamp" => $data_ti['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('flight_selenium', $data);
        }
    }
    
	function update_flight_selenium($data, $id)
    {
        $this->db->where('si_no', $id);
        $this->db->update('flights_selenium', $data);
    }
	function delete_flight_selenium_table($id, $data)
	{
		$this->db->select('si_no');
        $this->db->where('si_no', $id);
        $sel = $this->db->get('flights_selenium');
        $res = $sel->result_array();
        if (!empty($res)) {
            $this->db->where('si_no', $id);
            $this->db->update('flights_selenium', $data);
        }
	}
	function get_TrichyMasterFlight_table()
	{
		$date = date("Y-m-d");
		$status = '0';
        $this->db->select('ts.si_no as id, p1.place as airport, air.airline_name, ts.flight_no, ts.type, ts.departure_time, ts.arrival_time, p.place as from, aip.place as dest, ts.terminal, ts.status, ts.create_at, ts.update_at');
        $this->db->where('date(ts.create_at)', $date);
		$this->db->where('(ts.in_deleted)', $status);
		$this->db->from('flights as ts');
        $this->db->join('master_airport as p', 'p.place_id=ts.from_id');
		$this->db->join('master_airport as p1', 'p1.place_id=ts.airport_id');
        $this->db->join('master_airport as aip', 'aip.place_id = ts.destination_id');
        $this->db->join('master_airline_status as air', 'air.si_no=ts.airline_id');

        // $this->db->join('master_airport as a', 'a.airport_id=ts.destination_id');

        $this->db->order_by('ts.si_no', 'ASC');

        $query = $this->db->get();
        //$queryy=$query->result_array();
        // print_r($query);
        //exit();
        return $query->result_array();
	}
	function insert_master_airport_fromF($data_from)
    {

        $this->db->select('place_id');
        $this->db->where('place', $data_from['place']);
        // $this->db->where('terminal', $data_from['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('master_airport', $data_from);
            $place_id = $this->db->insert_id();
            return $place_id;
        } else {
            $place_id = $res[0]['place_id'];
            return $place_id;
        }
		
    }
	function insert_master_airport_destF($data_dest)
    {

        $this->db->select('place_id');
        $this->db->where('place', $data_dest['place']);
        // $this->db->where('terminal', $data_from['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('master_airport', $data_dest);
            $place_id = $this->db->insert_id();
            return $place_id;
        } else {
            $place_id = $res[0]['place_id'];
            return $place_id;
        }
    }
	function insert_master_airline_1F($data_airline)
    {

        $this->db->select('si_no');
        $this->db->where('airline_name', $data_airline['airline_name']);
        // $this->db->where('terminal', $data_from['terminal']);
        $sel = $this->db->get('master_airline_status');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('master_airline_status', $data_airline);
            $airline_id = $this->db->insert_id();
            return $airline_id;
        } else {
            $airline_id = $res[0]['si_no'];
            return $airline_id;
        }
    }
	function insert_master_airport_airportF($data_airport)
    {

        $this->db->select('place_id');
        $this->db->where('place', $data_airport['place']);
        // $this->db->where('terminal', $data_from['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('master_airport', $data_airport);
            $place_id = $this->db->insert_id();
            return $place_id;
        } else {
            $place_id = $res[0]['place_id'];
            return $place_id;
        }
		
    }
	function insert_flight_table($flight_data)
    {
        $this->db->select('si_no');
        $this->db->where('from_id', $flight_data['from_id'])->where('airline_id', $flight_data['airline_id'])->where('flight_no', $flight_data['flight_no'])->where('destination_id', $flight_data['destination_id'])->where('arrival_time', $flight_data['arrival_time'])->where('departure_time', $flight_data['departure_time'])->where('terminal', $flight_data['terminal'])->where('status', $flight_data['status']);
        $sel = $this->db->get('flights');
        $res = $sel->result_array();
        //print_r($res);
        //exit();
        if (empty($res)) {

            $ins = $this->db->insert('flights', $flight_data);
            return $ins;
        }
    }
	function update_master_airportF_from($data_from, $id)
    {
        $this->db->select('place_id');
        $this->db->where('place', $data_from['place']);
        // $this->db->where('terminal', $data_p['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "from_id" => $res[0]['place_id'],
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('flights', $data);
        } else {
            $this->db->insert('master_airport', $data_from);
            $place_id = $this->db->insert_id();
            $data = array(
                "from_id" => $place_id,
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('flights', $data);
        }
    }
	function update_master_airportF_dest($data_destination, $id)
    {
        $this->db->select('place_id');
        $this->db->where('place', $data_destination['place']);
        // $this->db->where('terminal', $data_p['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "destination_id" => $res[0]['place_id'],
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('flights', $data);
        } else {
            $this->db->insert('master_airport', $data_destination);
            $place_id = $this->db->insert_id();
            $data = array(
                "destination_id" => $place_id,
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('flights', $data);
        }
    }
	function update_master_airportF_airport($data_airport, $id)
    {
        $this->db->select('place_id');
        $this->db->where('place', $data_airport['place']);
        // $this->db->where('terminal', $data_p['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "airport_id" => $res[0]['place_id'],
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('flights', $data);
        } else {
            $this->db->insert('master_airport', $data_airport);
            $place_id = $this->db->insert_id();
            $data = array(
                "airport_id" => $place_id,
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('flights', $data);
        }
    }
    function update_master_airlineF_status($data_airline, $id)
    {
		$this->db->select('si_no');
        $this->db->where('airline_name', $data_airline['airline_name']);
        $sel = $this->db->get('master_airline_status');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "airline_id" => $res[0]['si_no'],
                // "time_stamp" => $data_ti['time_stamp']s
            );
            $this->db->where('si_no', $id);
            $this->db->update('flights', $data);
        } else {
            $this->db->insert('master_airline_status', $data_airline);
            $time_id = $this->db->insert_id();
            $data = array(
                "airline_id" => $time_id,
                // "time_stamp" => $data_ti['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('flights', $data);
        }
    }
    
	function update_flight_table($data, $id)
    {
        $this->db->where('si_no', $id);
        $this->db->update('flights', $data);
    }
	 public function getData(){//2get data from database
            $this->load->database();
		return $this->db->get('flights')->result();
	 }
	 	public function editData($Id){//3
		 $this->load->database();
		$this->db->where('si_no',$Id);
	   return $this->db->get('flights')->result();
	}
	  public function deleteData($Id){//5
		   $this->load->database();
	   $this->db->where('si_no',$Id);
	   return $this->db->delete('flights');
	   }
	function delete_flight_table($id, $data)
	{
		$this->db->select('si_no');
        $this->db->where('si_no', $id);
        $sel = $this->db->get('flights');
        $res = $sel->result_array();
        if (!empty($res)) {
            $this->db->where('si_no', $id);
            $this->db->update('flights', $data);
        }
	}
	function get_TrichyMasterAirline_table()
	{
		
		$date = date("Y-m-d");
		$status = '0';
        $this->db->select('ts.si_no as id, air.airline_name, ts.flight_no, ts.departure_time, ts.arrival_time, p.place as from, aip.place as dest, ts.terminal, ts.status, ts.create_at, ts.update_at');
        $this->db->where('date(ts.create_at)', $date);
		$this->db->where('(ts.in_deleted)', $status);
		$this->db->from('airline as ts');
        $this->db->join('master_airport as p', 'p.place_id=ts.from_id');
		// $this->db->join('master_airport as p1', 'p1.place_id=ts.airport_id');
        $this->db->join('master_airport as aip', 'aip.place_id = ts.destination_id');
        $this->db->join('master_airline_status as air', 'air.si_no=ts.airline_id');

        // $this->db->join('master_airport as a', 'a.airport_id=ts.destination_id');

        $this->db->order_by('ts.si_no', 'ASC');

        $query = $this->db->get();
        // $queryy=$query->result_array();
        // print_r($query);
        //exit();
        return $query->result_array();
	}
	function insert_master_airport_fromA($data_from)
    {

        $this->db->select('place_id');
        $this->db->where('place', $data_from['place']);
        // $this->db->where('terminal', $data_from['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('master_airport', $data_from);
            $place_id = $this->db->insert_id();
            return $place_id;
        } else {
            $place_id = $res[0]['place_id'];
            return $place_id;
        }
		
    }
	function insert_master_airport_destA($data_dest)
    {

        $this->db->select('place_id');
        $this->db->where('place', $data_dest['place']);
        // $this->db->where('terminal', $data_from['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('master_airport', $data_dest);
            $place_id = $this->db->insert_id();
            return $place_id;
        } else {
            $place_id = $res[0]['place_id'];
            return $place_id;
        }
    }
	function insert_master_airline_1A($data_airline)
    {

        $this->db->select('si_no');
        $this->db->where('airline_name', $data_airline['airline_name']);
        // $this->db->where('terminal', $data_from['terminal']);
        $sel = $this->db->get('master_airline_status');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('master_airline_status', $data_airline);
            $airline_id = $this->db->insert_id();
            return $airline_id;
        } else {
            $airline_id = $res[0]['si_no'];
            return $airline_id;
        }
    }
	function insert_airline_table($flight_data)
    {
        $this->db->select('si_no');
        $this->db->where('from_id', $flight_data['from_id'])->where('airline_id', $flight_data['airline_id'])->where('flight_no', $flight_data['flight_no'])->where('destination_id', $flight_data['destination_id'])->where('arrival_time', $flight_data['arrival_time'])->where('departure_time', $flight_data['departure_time'])->where('terminal', $flight_data['terminal'])->where('status', $flight_data['status']);
        $sel = $this->db->get('airline');
        $res = $sel->result_array();
        //print_r($res);
        //exit();
        if (empty($res)) {

            $ins = $this->db->insert('airline', $flight_data);
            return $ins;
        }
    }
	function update_master_airport_fromA($data_from, $id)
    {
        $this->db->select('place_id');
        $this->db->where('place', $data_from['place']);
        // $this->db->where('terminal', $data_p['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "from_id" => $res[0]['place_id'],
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('airline', $data);
        } else {
            $this->db->insert('master_airport', $data_from);
            $place_id = $this->db->insert_id();
            $data = array(
                "from_id" => $place_id,
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('airline', $data);
        }
    }
	function update_master_airport_destA($data_destination, $id)
    {
        $this->db->select('place_id');
        $this->db->where('place', $data_destination['place']);
        // $this->db->where('terminal', $data_p['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "destination_id" => $res[0]['place_id'],
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('airline', $data);
        } else {
            $this->db->insert('master_airport', $data_destination);
            $place_id = $this->db->insert_id();
            $data = array(
                "destination_id" => $place_id,
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('airline', $data);
        }
    }
    function update_master_airline_statusA($data_airline, $id)
    {
		$this->db->select('si_no');
        $this->db->where('airline_name', $data_airline['airline_name']);
        $sel = $this->db->get('master_airline_status');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "airline_id" => $res[0]['si_no'],
                // "time_stamp" => $data_ti['time_stamp']s
            );
            $this->db->where('si_no', $id);
            $this->db->update('airline', $data);
        } else {
            $this->db->insert('master_airline_status', $data_airline);
            $time_id = $this->db->insert_id();
            $data = array(
                "airline_id" => $time_id,
                // "time_stamp" => $data_ti['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('airline', $data);
        }
    }
    
	function update_airline_table($data, $id)
    {
        $this->db->where('si_no', $id);
        $this->db->update('airline', $data);
    }
	function delete_airline_table($id, $data)
	{
		$this->db->select('si_no');
        $this->db->where('si_no', $id);
        $sel = $this->db->get('airline');
        $res = $sel->result_array();
        if (!empty($res)) {
            $this->db->where('si_no', $id);
            $this->db->update('airline', $data);
        }
	}
	function get_TrichyMasterAirlineSelenium_table()
	{
		
		$date = date("Y-m-d");
		$status = '0';
        $this->db->select('ts.si_no as id, air.airline_name, ts.flight_no, ts.departure_time, ts.arrival_time, p.place as from, aip.place as dest, ts.terminal, ts.status, ts.create_at, ts.update_at');
        $this->db->where('date(ts.create_at)', $date);
		$this->db->where('(ts.in_deleted)', $status);
		$this->db->from('airline_selenium as ts');
        $this->db->join('master_airport as p', 'p.place_id=ts.from_id');
		// $this->db->join('master_airport as p1', 'p1.place_id=ts.airport_id');
        $this->db->join('master_airport as aip', 'aip.place_id = ts.destination_id');
        $this->db->join('master_airline_status as air', 'air.si_no=ts.airline_id');

        // $this->db->join('master_airport as a', 'a.airport_id=ts.destination_id');

        $this->db->order_by('ts.si_no', 'ASC');

        $query = $this->db->get();
        // $queryy=$query->result_array();
        // print_r($query);
        //exit();
        return $query->result_array();
	}
	function insert_master_airport_fromAS($data_from)
    {

        $this->db->select('place_id');
        $this->db->where('place', $data_from['place']);
        // $this->db->where('terminal', $data_from['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('master_airport', $data_from);
            $place_id = $this->db->insert_id();
            return $place_id;
        } else {
            $place_id = $res[0]['place_id'];
            return $place_id;
        }
		
    }
	function insert_master_airport_destAS($data_dest)
    {

        $this->db->select('place_id');
        $this->db->where('place', $data_dest['place']);
        // $this->db->where('terminal', $data_from['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('master_airport', $data_dest);
            $place_id = $this->db->insert_id();
            return $place_id;
        } else {
            $place_id = $res[0]['place_id'];
            return $place_id;
        }
    }
	function insert_master_airline_1AS($data_airline)
    {

        $this->db->select('si_no');
        $this->db->where('airline_name', $data_airline['airline_name']);
        // $this->db->where('terminal', $data_from['terminal']);
        $sel = $this->db->get('master_airline_status');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('master_airline_status', $data_airline);
            $airline_id = $this->db->insert_id();
            return $airline_id;
        } else {
            $airline_id = $res[0]['si_no'];
            return $airline_id;
        }
    }
	function insert_airline_selenium_table($flight_data)
    {
        $this->db->select('si_no');
        $this->db->where('from_id', $flight_data['from_id'])->where('airline_id', $flight_data['airline_id'])->where('flight_no', $flight_data['flight_no'])->where('destination_id', $flight_data['destination_id'])->where('arrival_time', $flight_data['arrival_time'])->where('departure_time', $flight_data['departure_time'])->where('terminal', $flight_data['terminal'])->where('status', $flight_data['status']);
        $sel = $this->db->get('airline_selenium');
        $res = $sel->result_array();
        //print_r($res);
        //exit();
        if (empty($res)) {

            $ins = $this->db->insert('airline_selenium', $flight_data);
            return $ins;
        }
    }
	function update_master_airport_fromAS($data_from, $id)
    {
        $this->db->select('place_id');
        $this->db->where('place', $data_from['place']);
        // $this->db->where('terminal', $data_p['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "from_id" => $res[0]['place_id'],
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('airline_selenium', $data);
        } else {
            $this->db->insert('master_airport', $data_from);
            $place_id = $this->db->insert_id();
            $data = array(
                "from_id" => $place_id,
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('airline_selenium', $data);
        }
    }
	function update_master_airport_destAS($data_destination, $id)
    {
        $this->db->select('place_id');
        $this->db->where('place', $data_destination['place']);
        // $this->db->where('terminal', $data_p['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "destination_id" => $res[0]['place_id'],
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('airline_selenium', $data);
        } else {
            $this->db->insert('master_airport', $data_destination);
            $place_id = $this->db->insert_id();
            $data = array(
                "destination_id" => $place_id,
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('airline_selenium', $data);
        }
    }
    function update_master_airline_statusAS($data_airline, $id)
    {
		$this->db->select('si_no');
        $this->db->where('airline_name', $data_airline['airline_name']);
        $sel = $this->db->get('master_airline_status');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "airline_id" => $res[0]['si_no'],
                // "time_stamp" => $data_ti['time_stamp']s
            );
            $this->db->where('si_no', $id);
            $this->db->update('airline_selenium', $data);
        } else {
            $this->db->insert('master_airline_status', $data_airline);
            $time_id = $this->db->insert_id();
            $data = array(
                "airline_id" => $time_id,
                // "time_stamp" => $data_ti['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('airline_selenium', $data);
        }
    }
    
	function update_airline_selenium_table($data, $id)
    {
        $this->db->where('si_no', $id);
        $this->db->update('airline_selenium', $data);
    }
	function delete_airline_selenium_table($id, $data)
	{
		$this->db->select('si_no');
        $this->db->where('si_no', $id);
        $sel = $this->db->get('airline_selenium');
        $res = $sel->result_array();
        if (!empty($res)) {
            $this->db->where('si_no', $id);
            $this->db->update('airline_selenium', $data);
        }
	}
	function get_trichymaster_place_table()
    {
        $status = '0';
		$this->db->select('p.place_id, p.place, p.terminal, p.state, p.time_stamp');
        $this->db->from('master_airport as p');
		$this->db->where('(p.terminal)', $status);
        $this->db->order_by('p.place');
        $sel = $this->db->get();
        $res = $sel->result_array();
        //print_r($res);
        //exit();
        return $res;
    }
	function get_flight_status_table()
    {
		$status = '0';
		$this->db->select('ap.si_no as id, p.place as airport, ap.url as url, ap.source as code, ap.create_at as date');
        $this->db->from('master_flight_status as ap');
		$this->db->where('(ap.in_deleted)', $status);
		$this->db->join('master_airport as p', 'p.place_id=ap.airport_id');
        $this->db->order_by('ap.si_no');
        $sel = $this->db->get();
        $res = $sel->result_array();
        //print_r($res);
        //exit();
        return $res;
    }
	function insert_master_airport_MFS($data_airport)
    {

        $this->db->select('place_id');
        $this->db->where('place', $data_airport['place']);
        // $this->db->where('terminal', $data_from['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('master_airport', $data_airport);
            $place_id = $this->db->insert_id();
            return $place_id;
        } else {
            $place_id = $res[0]['place_id'];
            return $place_id;
        }
		
    }
	function insert_flight_status_table($flight_data)
    {
        $this->db->select('si_no');
        $this->db->where('airport_id', $flight_data['airport_id'])->where('url', $flight_data['url'])->where('source', $flight_data['source']);
        $sel = $this->db->get('master_flight_status');
        $res = $sel->result_array();
        //print_r($res);
        //exit();
        if (empty($res)) {

            $ins = $this->db->insert('master_flight_status', $flight_data);
            return $ins;
        }
    }
	function update_master_airport_MFS($data_destination, $id)
    {
        $this->db->select('place_id');
        $this->db->where('place', $data_destination['place']);
        // $this->db->where('terminal', $data_p['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "airport_id" => $res[0]['place_id'],
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('master_flight_status', $data);
        } else {
            $this->db->insert('master_airport', $data_destination);
            $place_id = $this->db->insert_id();
            $data = array(
                "airport_id" => $place_id,
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('master_flight_status', $data);
        }
    }
	function update_flight_status_table($data, $id)
    {
        $this->db->where('si_no', $id);
        $this->db->update('master_flight_status', $data);
    }
	function delete_flight_status_table($id, $data)
    {

        $this->db->select('si_no');
        $this->db->where('si_no', $id);
        $sel = $this->db->get('master_flight_status');
        $res = $sel->result_array();
        if (!empty($res)) {
            $this->db->where('si_no', $id);
            $this->db->update('master_flight_status', $data);
        }
    }
	function get_trichymaster_missed_Airport_table()
	{
		$status = '0';
		$this->db->select('p.si_no, p.place, p.status, p.create_at, p.update_at');
        $this->db->from('master_missed_airport as p');
		$this->db->where('(p.status)', $status);
        $this->db->order_by('p.si_no');
        $sel = $this->db->get();
        $res = $sel->result_array();
        //print_r($res);
        //exit();
        return $res;
	}
	function get_trichymaster_missed_Airline_table()
	{
		$status = '0';
		$this->db->select('p.si_no, p.airline, p.status, p.create_at, p.update_at');
        $this->db->from('master_missed_airline as p');
		$this->db->where('(p.status)', $status);
        $this->db->order_by('p.si_no');
        $sel = $this->db->get();
        $res = $sel->result_array();
        //print_r($res);
        //exit();
        return $res;
	}
	function get_trichymaster_access_log_table()
	{
		$this->db->select('p.si_no, p.file_name, p.airport, p.source, p.create_at, p.update_at');
        $this->db->from('access_log as p');
        $this->db->order_by('p.si_no');
        $sel = $this->db->get();
        $res = $sel->result_array();
        //print_r($res);
        //exit();
        return $res;
	}
	function get_trichymaster_error_log_table()
	{
		$this->db->select('p.si_no, p.error_statement, p.create_at, p.update_at');
        $this->db->from('error_log as p');
        $this->db->order_by('p.si_no');
        $sel = $this->db->get();
        $res = $sel->result_array();
        //print_r($res);
        //exit();
        return $res;
	}
	function get_TrichyMasterDeparture_table()
    {
		$date = date("Y-m-d");
		$status = '0';
        $this->db->select('ts.si_no as id, ts.flight_no as number, ts.departure, ts.terminal, aip.place as airport, ts.status, ts.create_at as date, p.place as place, air.airline_name as airline');
        $this->db->where('date(ts.create_at)', $date);
		$this->db->where('(ts.in_deleted)', $status);
		$this->db->from('trz_departure as ts');
        $this->db->join('master_airport as p', 'p.place_id=ts.destination_id');
        $this->db->join('master_airport as aip', 'aip.place_id = ts.airport_id');
        $this->db->join('master_airline_status as air', 'air.si_no=ts.airline_id');
        
        // $this->db->join('master_airport as a', 'a.airport_id=ts.airport_id');

        $this->db->order_by('ts.si_no', 'ASC');

        $query = $this->db->get();
        //$queryy=$query->result_array();
        //print_r($queryy);
        //exit();
        return $query->result_array();
    }
	function update_master_airport_table4($data_from, $id)
    {
        $this->db->select('place_id');
        $this->db->where('place', $data_from['place']);
        // $this->db->where('terminal', $data_p['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "airport_id" => $res[0]['place_id'],
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_departure', $data);
        } else {
            $this->db->insert('master_airport', $data_from);
            $place_id = $this->db->insert_id();
            $data = array(
                "airport_id" => $place_id,
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_departure', $data);
        }
    }
	function update_master_airport_1_table4($data_destination, $id)
    {
        $this->db->select('place_id');
        $this->db->where('place', $data_destination['place']);
        // $this->db->where('terminal', $data_p['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "destination_id" => $res[0]['place_id'],
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_departure', $data);
        } else {
            $this->db->insert('master_airport', $data_destination);
            $place_id = $this->db->insert_id();
            $data = array(
                "destination_id" => $place_id,
                // "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_departure', $data);
        }
    }
    function update_master_airline_status_table4($data_airline, $id)
    {
		$this->db->select('si_no');
        $this->db->where('airline_name', $data_airline['airline_name']);
        $sel = $this->db->get('master_airline_status');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "airline_id" => $res[0]['si_no'],
                // "time_stamp" => $data_ti['time_stamp']s
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_departure', $data);
        } else {
            $this->db->insert('master_airline_status', $data_airline);
            $time_id = $this->db->insert_id();
            $data = array(
                "airline_id" => $time_id,
                // "time_stamp" => $data_ti['time_stamp']
            );
            $this->db->where('si_no', $id);
            $this->db->update('trz_departure', $data);
        }
    }
    
    function update_departure_table($data, $id)
    {
        $this->db->where('si_no', $id);
        $this->db->update('trz_departure', $data);
    }
	function get_trichymaster_airline_table()
    {
        $status = '0';
		$this->db->select('air.si_no, air.airline_name, air.iata_code, air.icao_code, air.airline_url, air.image, air.create_at, air.update_at');
        $this->db->from('master_airline_status as air');
		$this->db->where('(air.in_deleted)', $status);
        $this->db->order_by('air.si_no');
        $sel = $this->db->get();
        $res = $sel->result_array();
        //print_r($res);
        //exit();
        return $res;
    }
	
	function  get_master_slug_table()
    {
        $status = '0';
		$this->db->select('air.si_no as id, air.wp_slug as slug, air.flight_url as url, air.source, air.create_at as date');
        $this->db->from('master_slugs as air');
		$this->db->where('(air.in_deleted)', $status);
        $this->db->order_by('air.si_no');
        $sel = $this->db->get();
        $res = $sel->result_array();
        //print_r($res);
        //exit();
        return $res;
    }
	
	function insert_master_slug_table($slug_data)
    {
        $ins = $this->db->insert('master_slugs', $slug_data);
        return $ins;
    
    }
	function update_master_slug_table($data, $id)
    {
        $this->db->where('si_no', $id);
        $this->db->update('master_slugs', $data);
    }
	function delete_master_slug_table($id, $data)
    {

        $this->db->select('si_no');
        $this->db->where('si_no', $id);
        $sel = $this->db->get('master_slugs');
        $res = $sel->result_array();
        if (!empty($res)) {
            $this->db->where('si_no', $id);
            $this->db->update('master_slugs', $data);
        }
    }
	function get_Wordpress_Data($data1, $data2){

		$date = '2022-10-13';
		$this->db->select('ts.si_no as id, ts.flight_no as number,ts.type, ts.status, ts.create_at as date, p.place as place, air.airline_name as airline');
        $this->db->where('date(ts.create_at)', $date);
		$this->db->like('aip.place', $data1);
		$this->db->like('ts.type', $data2);
		$this->db->from('flights as ts');
        $this->db->join('master_place as p', 'p.place_id=ts.destination_id');
		$this->db->join('master_place as aip', 'aip.place_id = ts.airport_id');
        $this->db->join('master_airline as air', 'air.airline_id=ts.airline_id');
        $this->db->order_by('ts.si_no', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
	}
	function insert_master_airline_table($data)
    {
        $this->db->select('si_no');
        $this->db->where('airline_name', $data['airline_name']);
        // $this->db->where('terminal', $data['terminal']);
        $sel = $this->db->get('master_airline_status');
        $res = $sel->result_array();
		
        if (empty($res)) {
            $this->db->insert('master_airline_status', $data);
        } else {
            return false;
        }
    }
	function insert_master_place_table($data)
    {
        $this->db->select('place_id');
        $this->db->where('place', $data['place']);
        $this->db->where('terminal', $data['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();
		
        if (empty($res)) {
            $this->db->insert('master_airport', $data);
        } else {
            return false;
        }
    }
	function delete_master_missed_airline_table($id, $data)
    {

        $this->db->select('si_no');
        $this->db->where('si_no', $id);
        $sel = $this->db->get('master_missed_airline');
        $res = $sel->result_array();
        if (!empty($res)) {
            $this->db->where('si_no', $id);
            $this->db->update('master_missed_airline', $data);
        }
    }
	function delete_master_airline_table($id, $data)
    {

        $this->db->select('si_no');
        $this->db->where('si_no', $id);
        $sel = $this->db->get('master_airline_status');
        $res = $sel->result_array();
        if (!empty($res)) {
            $this->db->where('si_no', $id);
            $this->db->update('master_airline_status', $data);
        }
    }
	function delete_master_place_Table($id, $data)
	{
		$this->db->select('place_id');
        $this->db->where('place_id', $id);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();
        if (!empty($res)) {
            $this->db->where('place_id', $id);
            $this->db->update('master_airport', $data);
        }
	}
	function update_master_place_table($data, $id)
    {

        $this->db->where('place_id', $id);
        $this->db->update('master_airport', $data);
    }
	function delete_master_missed_airport_table($id, $data)
	{
		$this->db->select('si_no');
        $this->db->where('si_no', $id);
        $sel = $this->db->get('master_missed_airport');
        $res = $sel->result_array();
        if (!empty($res)) {
            $this->db->where('si_no', $id);
            $this->db->update('master_missed_airport', $data);
        }
	}
	function insert_master_airport($data_from)
    {

        $this->db->select('place_id');
        $this->db->where('place', $data_from['place']);
        // $this->db->where('terminal', $data_from['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('master_airport', $data_from);
            $place_id = $this->db->insert_id();
            return $place_id;
        } else {
            $place_id = $res[0]['place_id'];
            return $place_id;
        }
    }
	function insert_master_airline($data_airline)
    {

        $this->db->select('si_no');
        $this->db->where('airline_name', $data_airline['airline_name']);
        // $this->db->where('terminal', $data_from['terminal']);
        $sel = $this->db->get('master_airline_status');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('master_airline_status', $data_airline);
            $airline_id = $this->db->insert_id();
            return $airline_id;
        } else {
            $airline_id = $res[0]['si_no'];
            return $airline_id;
        }
    }
	function insert_master_airport_1($data_airport)
    {

        $this->db->select('place_id');
        $this->db->where('place', $data_airport['place']);
        // $this->db->where('terminal', $data_from['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('master_airport', $data_airport);
            $place_id = $this->db->insert_id();
            return $place_id;
        } else {
            $place_id = $res[0]['place_id'];
            return $place_id;
        }
		
    }
	function insert_master_1_airport($data_airport)
    {

        $this->db->select('place_id');
        $this->db->where('place', $data_airport['place']);
        // $this->db->where('terminal', $data_from['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('master_airport', $data_airport);
            $place_id = $this->db->insert_id();
            return $place_id;
        } else {
            $place_id = $res[0]['place_id'];
            return $place_id;
        }
    }
	function insert_master_1_airline($data_airline)
    {

        $this->db->select('si_no');
        $this->db->where('airline_name', $data_airline['airline_name']);
        // $this->db->where('terminal', $data_from['terminal']);
        $sel = $this->db->get('master_airline_status');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('master_airline_status', $data_airline);
            $airline_id = $this->db->insert_id();
            return $airline_id;
        } else {
            $airline_id = $res[0]['si_no'];
            return $airline_id;
        }
    }
	function insert_master_1_airport_1($data_destination)
    {

        $this->db->select('place_id');
        $this->db->where('place', $data_destination['place']);
        // $this->db->where('terminal', $data_from['terminal']);
        $sel = $this->db->get('master_airport');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('master_airport', $data_destination);
            $place_id = $this->db->insert_id();
            return $place_id;
        } else {
            $place_id = $res[0]['place_id'];
            return $place_id;
        }
		
    }
	function insert_arrival_selenium_table($arrival_data)
    {
        $this->db->select('si_no');
        $this->db->where('from_id', $arrival_data['from_id'])->where('airline_id', $arrival_data['airline_id'])->where('flight_no', $arrival_data['flight_no'])->where('destination_id', $arrival_data['destination_id'])->where('arrival', $arrival_data['arrival'])->where('terminal', $arrival_data['terminal'])->where('status', $arrival_data['status']);
        $sel = $this->db->get('trz_arrival_se');
        $res = $sel->result_array();
        //print_r($res);
        //exit();
        if (empty($res)) {

            $ins = $this->db->insert('trz_arrival_se', $arrival_data);
            return $ins;
        }
    }
	function insert_arrival_table($arrival_data)
    {
        $this->db->select('si_no');
        $this->db->where('from_id', $arrival_data['from_id'])->where('airline_id', $arrival_data['airline_id'])->where('flight_no', $arrival_data['flight_no'])->where('destination_id', $arrival_data['destination_id'])->where('arrival', $arrival_data['arrival'])->where('terminal', $arrival_data['terminal'])->where('status', $arrival_data['status']);
        $sel = $this->db->get('trz_arrival');
        $res = $sel->result_array();
        //print_r($res);
        //exit();
        if (empty($res)) {

            $ins = $this->db->insert('trz_arrival', $arrival_data);
            return $ins;
        }
    }
	function insert_departure_selenium_table($departure_data)
    {
        $this->db->select('si_no');
        $this->db->where('airport_id', $departure_data['from_id'])->where('airline_id', $departure_data['airline_id'])->where('flight_no', $departure_data['flight_no'])->where('destination_id', $departure_data['destination_id'])->where('departure', $departure_data['departure'])->where('terminal', $departure_data['terminal'])->where('status', $departure_data['status']);
        $sel = $this->db->get('trz_departure_se');
        $res = $sel->result_array();
        //print_r($res);
        //exit();
        if (empty($res)) {

            $ins = $this->db->insert('trz_departure_se', $departure_data);
            return $ins;
        }
    }
	function insert_departure_table($departure_data)
	{
		$this->db->select('si_no');
        $this->db->where('airport_id', $departure_data['from_id'])->where('airline_id', $departure_data['airline_id'])->where('flight_no', $departure_data['flight_no'])->where('destination_id', $departure_data['destination_id'])->where('departure', $departure_data['departure'])->where('terminal', $departure_data['terminal'])->where('status', $departure_data['status']);
        $sel = $this->db->get('trz_departure');
        $res = $sel->result_array();
        //print_r($res);
        //exit();
        if (empty($res)) {

            $ins = $this->db->insert('trz_departure', $departure_data);
            return $ins;
        }
	}
	function update_master_airline_table($data)
	{
		$this->db->where('si_no', $data['si_no']);
        $this->db->update('master_airline-status', $data);
	}
	function delete_arrival_selenium_table($id, $data)
	{
		$this->db->select('si_no');
        $this->db->where('si_no', $id);
        $sel = $this->db->get('trz_arrival_se');
        $res = $sel->result_array();
        if (!empty($res)) {
            $this->db->where('si_no', $id);
            $this->db->update('trz_arrival_se', $data);
        }
	}
	function delete_arrival_table($id, $data)
	{
		$this->db->select('si_no');
        $this->db->where('si_no', $id);
        $sel = $this->db->get('trz_arrival');
        $res = $sel->result_array();
        if (!empty($res)) {
            $this->db->where('si_no', $id);
            $this->db->update('trz_arrival', $data);
        }
	}
	function delete_departure_selenium_table($id, $data)
	{
		$this->db->select('si_no');
        $this->db->where('si_no', $id);
        $sel = $this->db->get('trz_departure_se');
        $res = $sel->result_array();
        if (!empty($res)) {
            $this->db->where('si_no', $id);
            $this->db->update('trz_departure_se', $data);
        }
	}
	function delete_departure_table($id, $data)
	{
		$this->db->select('si_no');
        $this->db->where('si_no', $id);
        $sel = $this->db->get('trz_departure');
        $res = $sel->result_array();
        if (!empty($res)) {
            $this->db->where('si_no', $id);
            $this->db->update('trz_departure', $data);
        }
	}
	// json format for flightd table
	function get_Apiflights($data)
	{
		$date = date("Y-m-d");
		$this->db->select('air.airline_name, ts.flight_no, ts.type, ts.departure_time, ts.arrival_time, f.place as origin, p.place as destination, ts.terminal, ts.status');
        $this->db->where('date(ts.create_at)', $date);
		$this->db->like('aip.place', $data);
		// $this->db->like('ts.type', $data2);
		$this->db->from('flights as ts');
        $this->db->join('master_airport as p', 'p.place_id=ts.destination_id');
		$this->db->join('master_airport as aip', 'aip.place_id = ts.airport_id');
		$this->db->join('master_airport as f', 'f.place_id = ts.from_id');
        $this->db->join('master_airline_status as air', 'air.si_no=ts.airline_id');
        $this->db->order_by('ts.si_no', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
	}

	// json format for flightd table
	function get_ApiArrival($data)
	{
		$date = date("Y-m-d");
		$this->db->select('air.airline_name, ts.flight_no, ts.arrival, f.place as origin, p.place as destination, ts.terminal, ts.status');
        $this->db->where('date(ts.create_at)', $date);
		$this->db->like('f.place', $data);
		// $this->db->like('ts.type', $data2);
		$this->db->from('trz_arrival as ts');
        $this->db->join('master_airport as p', 'p.place_id=ts.destination_id');
		// $this->db->join('master_airport as aip', 'aip.place_id = ts.airport_id');
		$this->db->join('master_airport as f', 'f.place_id = ts.from_id');
        $this->db->join('master_airline_status as air', 'air.si_no=ts.airline_id');
        $this->db->order_by('ts.si_no', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
	}

	// json format for flightd table
	function get_ApiDeparture($data)
	{
		$date = date("Y-m-d");
		$this->db->select('air.airline_name, ts.flight_no, ts.departure, aip.place as origin, p.place as destination, ts.terminal, ts.status');
        $this->db->where('date(ts.create_at)', $date);
		$this->db->like('aip.place', $data);
		// $this->db->like('ts.type', $data2);
		$this->db->from('trz_departure as ts');
        $this->db->join('master_airport as p', 'p.place_id=ts.destination_id');
		$this->db->join('master_airport as aip', 'aip.place_id = ts.airport_id');
		// $this->db->join('master_airport as f', 'f.place_id = ts.from_id');
        $this->db->join('master_airline_status as air', 'air.si_no=ts.airline_id');
        $this->db->order_by('ts.si_no', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
	}
	
	// json format for master_slug table
	function get_Apislug()
	{
		
		$this->db->select('*');
        // $this->db->where('date(ts.create_at)', $date);
		// $this->db->like('aip.place', $data);
		// $this->db->like('ts.type', $data2);
		$this->db->from('master_slugs');
        // $this->db->join('master_airport as p', 'p.place_id=ts.destination_id');
		// $this->db->join('master_airport as aip', 'aip.place_id = ts.airport_id');
		// // $this->db->join('master_airport as f', 'f.place_id = ts.from_id');
        // $this->db->join('master_airline_status as air', 'air.si_no=ts.airline_id');
        $this->db->order_by('si_no', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
	}

	function get_slug_url($data)
	{
		
		$this->db->select('flight_url');
        // $this->db->where('date(ts.create_at)', $date);
		$this->db->where('wp_slug', $data);
		// $this->db->like('ts.type', $data2);
		$this->db->from('master_slugs');
        // $this->db->order_by('si_no', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
	}
}
