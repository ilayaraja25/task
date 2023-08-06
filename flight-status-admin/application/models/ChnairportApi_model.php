<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ChnairportApi_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    function get_airport_details($airport_name, $destination, $type, $airline, $terminal, $times, $timee)
    {
        $this->db->select('a.airport_name, ls.live_id as id, ls.type, ls.time_stamp as last_update, p.place as place, p.terminal, ti.time as time, f.flight_name as airline, f.number as flight, s.status')->from('live_status as ls');
        $this->db->join('place as p', 'p.place_id=ls.place_id');
        $this->db->join('time as ti', 'ti.time_id=ls.time_id');
        $this->db->join('flight as f', 'f.flight_id=ls.flight_id');
        $this->db->join('status as s', 's.status_id=ls.status_id');
        $this->db->join('airport as a', 'a.airport_id=ls.airport_id');
        $this->db->where('ls.state !=', '1');
        $this->db->where('ls.type', $type);
        $this->db->like('a.airport_name', $airport_name);
        if ($destination != '') {
            $this->db->like('p.place', $destination);
        }
        if ($airline != '') {
            $this->db->where('f.flight_name', $airline);
        }
        if ($terminal != '') {
            $this->db->where('p.terminal', $terminal);
        }
        if ($times != '' && $timee != '') {
            $this->db->where('ti.time >=', $times);
            $this->db->where('ti.time <=', $timee);
        }
        $this->db->order_by('ti.time', 'ASC');
        $res = $this->db->get();
        $sel = $res->result_array();
        return $sel;
    }
    function airport_detail_bykeyword($key, $airport_name, $type)
    {
        $this->db->select('a.airport_name, ls.live_id as id, ls.type, ls.time_stamp as last_update, p.place as place, p.terminal, ti.time as time, f.flight_name as airline, f.number as flight, s.status')->from('live_status as ls');
        $this->db->join('place as p', 'p.place_id=ls.place_id');
        $this->db->join('time as ti', 'ti.time_id=ls.time_id');
        $this->db->join('flight as f', 'f.flight_id=ls.flight_id');
        $this->db->join('status as s', 's.status_id=ls.status_id');
        $this->db->join('airport as a', 'a.airport_id=ls.airport_id');
        $this->db->where('ls.state !=', '1');
        $this->db->where('ls.type', $type);
        $this->db->like('a.airport_name', $airport_name);
        if ($key != '') {
            $this->db->like('p.place', $key);
            $this->db->or_like('f.flight_name', $key);
            $this->db->or_like('f.number', $key);
        }

        $this->db->order_by('ti.time', 'ASC');
        $res = $this->db->get();
        $sel = $res->result_array();
        return $sel;
    }
    function get_airport_airlines()
    {
        $sel = $this->db->select('f.flight_name as airline')->from('flight as f')->order_by('f.flight_name', 'ASC')->group_by('f.flight_name')->get()->result_array();
        return $sel;
    }
    function get_airport_terminals()
    {
        $sel = $this->db->select('p.terminal')->from('place as p')->order_by('p.terminal', 'ASC')->group_by('p.terminal')->get()->result_array();
        return $sel;
    }
}
