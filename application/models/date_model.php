<?php
class date_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_datesForSchedule($scheduleId = FALSE)
    {
        if ($scheduleId === FALSE)
        {
            $query = $this->db->get('date');

            return $query->result_array();
        }

        $query = $this->db->get_where('date',array('schedule' => $scheduleId));
        return $query->result_array();
    }

    public function set_dates()
    {
        
    }

}