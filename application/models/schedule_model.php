<?php
class schedule_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_schedules($slug = FALSE)
    {
        if ($slug === FALSE)
        {
            $query = $this->db->get('schedule');

            return $query->result_array();
        }

        $query = $this->db->get_where('schedule',array('link_hash' => $slug));
        //var_dump($query);
        return $query->row_array();
    }

    public function set_schedule()
    {
        $this->load->helper('url');

        //var_dump($this->input->post());
        //var_dump($this->input->post('selectedDates'));

        //adding the schedule to the database
        $link_hash = uniqid('melt_');
        $schedule = array(
            'name' => $this->input->post('name'),
            'link_hash' => $link_hash,
            'description' => $this->input->post('description')
        );
        $this->db->insert('schedule', $schedule);

        //adding dates to the schedule
        $scheduleID = mysql_insert_id();
        $dates = $this->input->post('selectedDates');
        foreach ($dates as $selectedDate){

            $ymd = DateTime::createFromFormat('m-d-Y', $selectedDate['key'])->format('Y-m-d');
            $dateToInsert = array(
                'date' => $ymd,
                'schedule' => $scheduleID,
            );
            $this->db->insert('date', $dateToInsert);

            //adding intervals to each schedule date
            $dateID = mysql_insert_id();
            for ($i = 0; $i < 3; $i++){
                $interval = $selectedDate['value'][$i];
                if ($interval != ''){
                    $intervalToInsert = array(
                        'name' => $interval,
                        'date' => $dateID
                    );
                    $this->db->insert('interval', $intervalToInsert);
                }
            }
        }

        return $link_hash;
    }

}