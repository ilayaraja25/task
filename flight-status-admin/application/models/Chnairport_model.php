<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chnairport_model extends CI_Model
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
    /**python insert Function */
    function insert_place_py($data_p)
    {
        $this->db->select('place_id');
        $this->db->where('place', $data_p['place']);
        $this->db->where('terminal', $data_p['terminal']);
        $sel = $this->db->get('place');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('place', $data_p);
            $place_id = $this->db->insert_id();
            return $place_id;
        } else {
            $place_id = $res[0]['place_id'];
            return $place_id;
        }
    }
    function insert_time_py($data_ti)
    {
        $this->db->select('time_id');
        $this->db->where('time', $data_ti['time']);
        $sel = $this->db->get('time');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('time', $data_ti);
            $time_id = $this->db->insert_id();
            return $time_id;
        } else {
            $time_id = $res[0]['time_id'];
            return $time_id;
        }
    }
    function insert_name_number_py($data_f)
    {
        $this->db->select('flight_id');
        $this->db->where('flight_name', $data_f['flight_name']);
        $this->db->where('number', $data_f['number']);
        $sel = $this->db->get('flight');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('flight', $data_f);
            $flight_id = $this->db->insert_id();
            return $flight_id;
        } else {
            $flight_id = $res[0]['flight_id'];
            return $flight_id;
        }
    }
    function insert_status_py($data_s)
    {
        $this->db->select('status_id');
        $this->db->where('status', $data_s['status']);
        $sel = $this->db->get('status');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('status', $data_s);
            $status_id = $this->db->insert_id();
            return $status_id;
        } else {
            $status_id = $res[0]['status_id'];
            return $status_id;
        }
    }
    function insert_airport_py($data_airport)
    {
        $this->db->select('airport_id');
        $this->db->where('airport_name', $data_airport['airport_name']);
        $sel = $this->db->get('airport');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('airport', $data_airport);
            $airport_id = $this->db->insert_id();
            return $airport_id;
        } else {
            $airport_id = $res[0]['airport_id'];
            return $airport_id;
        }
    }
    function insert_live_table_py($l_data)
    {
        $this->db->select('live_id, state');
        $this->db->where('place_id', $l_data['place_id'])->where('flight_id', $l_data['flight_id'])->where('time_id', $l_data['time_id'])->where('status_id', $l_data['status_id'])->where('type', $l_data['type'])->where('airport_id', $l_data['airport_id'])->where('state', $l_data['state']);
        $sel = $this->db->get('live_status');
        $res = $sel->result_array();
        //print_r($res);
        //exit();
        if (empty($res)) {

            $ins = $this->db->insert('live_status', $l_data);
            return $ins;
        } else {
            $state = $res[0]['state'];
            $id = $res[0]['live_id'];
            //print_r($res);
            //die;
            if ($state == '1') {
                $data = array(
                    "state" => '0',
                    "time_stamp" => date('Y-m-d H:i:s')
                );
                $this->db->where('live_id', $id);
                $up = $this->db->update('live_status', $data);
                return $up;
            }
        }
    }
    /**Insert python function End */
    /**Admin master_live_status Function */
    function airport_id_check($data)
    {
        $this->db->select('airport_id');
        $this->db->where('airport_name', $data['airport_name']);
        $sel = $this->db->get('airport');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('airport', $data);
            $airport_id = $this->db->insert_id();
            return $airport_id;
        } else {
            $airport_id = $res[0]['airport_id'];
            return $airport_id;
        }
    }
    function insert_master_place($data_p)
    {

        $this->db->select('place_id');
        $this->db->where('place', $data_p['place']);
        $this->db->where('terminal', $data_p['terminal']);
        $sel = $this->db->get('place');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('place', $data_p);
            $place_id = $this->db->insert_id();
            return $place_id;
        } else {
            $place_id = $res[0]['place_id'];
            return $place_id;
        }
    }
    function insert_master_time($data_ti)
    {
        $this->db->select('time_id');
        $this->db->where('time', $data_ti['time']);
        $sel = $this->db->get('time');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('time', $data_ti);
            $time_id = $this->db->insert_id();
            return $time_id;
        } else {
            $time_id = $res[0]['time_id'];
            return $time_id;
        }
    }
    function insert_master_flight($data_f)
    {
        $this->db->select('flight_id');
        $this->db->where('flight_name', $data_f['flight_name']);
        $this->db->where('number', $data_f['number']);
        $sel = $this->db->get('flight');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('flight', $data_f);
            $flight_id = $this->db->insert_id();
            return $flight_id;
        } else {
            $flight_id = $res[0]['flight_id'];
            return $flight_id;
        }
    }
    function insert_master_status($data_s)
    {
        $this->db->select('status_id');
        $this->db->where('status', $data_s['status']);
        $sel = $this->db->get('status');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('status', $data_s);
            $status_id = $this->db->insert_id();
            return $status_id;
        } else {
            $status_id = $res[0]['status_id'];
            return $status_id;
        }
    }
    function insert_master_airport($data_airport)
    {
        $this->db->select('airport_id');
        $this->db->where('airport_name', $data_airport['airport_name']);
        $sel = $this->db->get('airport');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('airport', $data_airport);
            $airport_id = $this->db->insert_id();
            return $airport_id;
        } else {
            $airport_id = $res[0]['airport_id'];
            return $airport_id;
        }
    }
    function insert_master_live_table($l_data)
    {
        $this->db->select('live_id');
        $this->db->where('place_id', $l_data['place_id'])->where('flight_id', $l_data['flight_id'])->where('time_id', $l_data['time_id'])->where('status_id', $l_data['status_id'])->where('type', $l_data['type'])->where('airport_id', $l_data['airport_id'])->where('state', $l_data['state']);
        $sel = $this->db->get('live_status');
        $res = $sel->result_array();
        //print_r($res);
        //exit();
        if (empty($res)) {

            $ins = $this->db->insert('live_status', $l_data);
            return $ins;
        }
    }
    function update_place_master($data_p, $id)
    {
        $this->db->select('place_id');
        $this->db->where('place', $data_p['place']);
        $this->db->where('terminal', $data_p['terminal']);
        $sel = $this->db->get('place');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "place_id" => $res[0]['place_id'],
                "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('live_id', $id);
            $this->db->update('live_status', $data);
        } else {
            $this->db->insert('place', $data_p);
            $place_id = $this->db->insert_id();
            $data = array(
                "place_id" => $place_id,
                "time_stamp" => $data_p['time_stamp']
            );
            $this->db->where('live_id', $id);
            $this->db->update('live_status', $data);
        }
    }
    function update_time_master($data_ti, $id)
    {
        $this->db->select('time_id');
        $this->db->where('time', $data_ti['time']);
        $sel = $this->db->get('time');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "time_id" => $res[0]['time_id'],
                "time_stamp" => $data_ti['time_stamp']
            );
            $this->db->where('live_id', $id);
            $this->db->update('live_status', $data);
        } else {
            $this->db->insert('time', $data_ti);
            $time_id = $this->db->insert_id();
            $data = array(
                "time_id" => $time_id,
                "time_stamp" => $data_ti['time_stamp']
            );
            $this->db->where('live_id', $id);
            $this->db->update('live_status', $data);
        }
    }
    function update_flight_master($data_f, $id)
    {
        $this->db->select('flight_id');
        $this->db->where('number', $data_f['number']);
        $this->db->where('flight_name', $data_f['flight_name']);
        $sel = $this->db->get('flight');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "flight_id" => $res[0]['flight_id'],
                "time_stamp" => $data_f['time_stamp']
            );
            $this->db->where('live_id', $id);
            $this->db->update('live_status', $data);
        } else {
            $this->db->insert('flight', $data_f);
            $flight_id = $this->db->insert_id();
            $data = array(
                "flight_id" => $flight_id,
                "time_stamp" => $data_f['time_stamp']
            );
            $this->db->where('live_id', $id);
            $this->db->update('live_status', $data);
        }
    }
    function update_status_master($data_s, $id)
    {
        $this->db->select('status_id');
        $this->db->where('status', $data_s['status']);
        $sel = $this->db->get('status');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "status_id" => $res[0]['status_id'],
                "time_stamp" => $data_s['time_stamp']
            );
            $this->db->where('live_id', $id);
            $this->db->update('live_status', $data);
        } else {
            $this->db->insert('status', $data_s);
            $status_id = $this->db->insert_id();
            $data = array(
                "status_id" => $status_id,
                "time_stamp" => $data_s['time_stamp']
            );
            $this->db->where('live_id', $id);
            $this->db->update('live_status', $data);
        }
    }
    function update_airport_master($data_airport, $id)
    {

        $this->db->select('airport_id');
        $this->db->where('airport_name', $data_airport['airport_name']);
        $sel = $this->db->get('airport');
        $res = $sel->result_array();

        if (!empty($res)) {
            $data = array(
                "airport_id" => $res[0]['airport_id'],
                "time_stamp" => $data_airport['time_stamp']
            );
            $this->db->where('live_id', $id);
            $this->db->update('live_status', $data);
        } else {

            $this->db->insert('airport', $data_airport);
            $airport_id = $this->db->insert_id();
            $data = array(
                "airport_id" => $airport_id,
                "time_stamp" => $data_airport['time_stamp']
            );
            $this->db->where('live_id', $id);
            $this->db->update('live_status', $data);
        }
    }
    function update_master_live_table($data, $id)
    {
        $this->db->where('live_id', $id);
        $this->db->update('live_status', $data);
    }
    function delete_master_live_table($id, $data)
    {

        $this->db->select('live_id');
        $this->db->where('live_id', $id);
        $sel = $this->db->get('live_status');
        $res = $sel->result_array();
        if (!empty($res)) {
            $this->db->where('live_id', $id);
            $this->db->update('live_status', $data);
        }
    }
    function get_MasterLiveStatus_table()
    {
        $this->db->select('ls.live_id as id,ls.time_stamp as last_update, ls.type , ls.state, a.airport_name as airport, p.place as place, p.terminal, ti.time as time, f.flight_name as airline, f.number as flight, s.status');
        $this->db->from('live_status as ls');
        $this->db->join('place as p', 'p.place_id=ls.place_id');
        $this->db->join('time as ti', 'ti.time_id=ls.time_id');
        $this->db->join('flight as f', 'f.flight_id=ls.flight_id');
        $this->db->join('status as s', 's.status_id=ls.status_id');
        $this->db->join('airport as a', 'a.airport_id=ls.airport_id');

        $this->db->order_by('ls.live_id', 'ASC');

        $query = $this->db->get();
        //$queryy=$query->result_array();
        //print_r($queryy);
        //exit();
        return $query->result_array();
    }
    /** End Admin master_live_status Function*/
    /** Admin master_place_table Function */
    function insert_master_place_table($data)
    {
        $this->db->select('place_id');
        $this->db->where('place', $data['place']);
        $this->db->where('terminal', $data['terminal']);
        $sel = $this->db->get('place');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('place', $data);
        } else {
            return false;
        }
    }
    function update_master_place_table($data, $id)
    {

        $this->db->where('place_id', $id);
        $this->db->update('place', $data);
    }
    function delete_master_place_table($id, $data)
    {

        $this->db->select('place_id');
        $this->db->where('place_id', $id);
        $sel = $this->db->get('place');
        $res = $sel->result_array();
        if (!empty($res)) {
            $this->db->where('place_id', $id);
            $this->db->update('place', $data);
        }
    }
    function get_master_place_table()
    {
        $this->db->select('p.place_id, p.place, p.terminal, p.state, p.time_stamp');
        $this->db->from('place as p');
        $this->db->order_by('p.place');
        $sel = $this->db->get();
        $res = $sel->result_array();
        //print_r($res);
        //exit();
        return $res;
    }
    /** End Admin master_place_table Function */

    /**Admin master_flight_table Function  */
    function insert_master_flight_table($data)
    {
        $this->db->select('flight_id');
        $this->db->where('flight_name', $data['flight_name']);
        $this->db->where('number', $data['number']);
        $sel = $this->db->get('flight');
        $res = $sel->result_array();

        if (empty($res)) {
            $this->db->insert('flight', $data);
        } else {
            return false;
        }
    }
    function update_master_flight_table($data, $id)
    {
        $this->db->where('flight_id', $id);
        $this->db->update('flight', $data);
    }
    function delete_master_flight_table($id, $data)
    {

        $this->db->select('flight_id');
        $this->db->where('flight_id', $id);
        $sel = $this->db->get('flight');
        $res = $sel->result_array();
        if (!empty($res)) {
            $this->db->where('flight_id', $id);
            $this->db->update('flight', $data);
        }
    }
    function get_master_flight_table()
    {
        $this->db->select('f.flight_id, f.flight_name, f.number, f.state, f.time_stamp');
        $this->db->from('flight as f');
        $this->db->order_by('f.flight_name');
        $sel = $this->db->get();
        $res = $sel->result_array();
        //print_r($res);
        //exit();
        return $res;
    }
    /**Adminpanel time table function */
    function insert_master_time_table($data)
    {
        $this->db->select('time_id');
        $this->db->where('time', $data['time']);
        $sel = $this->db->get('time');
        $res = $sel->result_array();
        if (empty($res)) {
            $this->db->insert('time', $data);
        } else {
            return false;
        }
    }
    function update_master_time_table($data, $id)
    {
        $this->db->where('time_id', $id);
        $this->db->update('time', $data);
    }
    function delete_master_time_table($id, $data)
    {

        $this->db->select('time_id');
        $this->db->where('time_id', $id);
        $sel = $this->db->get('time');
        $res = $sel->result_array();
        if (!empty($res)) {
            $this->db->where('time_id', $id);
            $this->db->update('time', $data);
        }
    }
    function get_master_time_table()
    {
        $this->db->select('t.time_id, t.time, t.state, t.time_stamp');
        $this->db->from('time as t');
        $this->db->order_by('t.time', 'ASC');
        $sel = $this->db->get();
        $res = $sel->result_array();
        //print_r($res);
        //exit();
        return $res;
    }
    /**Adminpanel time table function End*/

    /**Adminpanel status table function */
    function insert_master_status_table($data)
    {
        $this->db->select('status_id');
        $this->db->where('status', $data['status']);
        $sel = $this->db->get('status');
        $res = $sel->result_array();
        if (empty($res)) {
            $this->db->insert('status', $data);
        } else {
            return false;
        }
    }
    function update_master_status_table($data, $id)
    {
        $this->db->where('status_id', $id);
        $this->db->update('status', $data);
    }
    function delete_master_status_table($id, $data)
    {

        $this->db->select('status_id');
        $this->db->where('status_id', $id);
        $sel = $this->db->get('status');
        $res = $sel->result_array();
        if (!empty($res)) {
            $this->db->where('status_id', $id);
            $this->db->update('status', $data);
        }
    }
    function get_master_status_table()
    {
        $this->db->select('s.status_id, s.status, s.state, s.time_stamp');
        $this->db->from('status as s');
        $this->db->order_by('s.status', 'ASC');
        $sel = $this->db->get();
        $res = $sel->result_array();
        //print_r($res);
        //exit();
        return $res;
    }
    /**Adminpanel status table function End*/
}
