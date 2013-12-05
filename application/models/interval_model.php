<?php
class interval_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_intervalsForDate($dateID = FALSE)
    {
        if ($dateID === FALSE)
        {
            $query = $this->db->get('date_interval');

            return $query->result_array();
        }

        $query = $this->db->get_where('date_interval',array('date' => $dateID));
        return $query->result_array();
    }

    public function set_intervals()
    {

    }

}