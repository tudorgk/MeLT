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
                    $this->db->insert('date_interval', $intervalToInsert);
                }
            }
        }

        return $link_hash;
    }

    public function set_user_for_schedule(){
        $this->load->helper('url');

        $user = array(
           'firstname' => $this->input->post('name'),
            'schedule_id' => $this->input->post('scheduleID')
        );
        $this->db->insert('user',$user);
        $userID = mysql_insert_id();

        $intervalArray = $this->input->post('data');

        foreach($intervalArray as $input){
            if($input['checkboxValue']=='true'){
                //getting the interval ID
                $checkboxArray = explode('-',$input['checkboxID']);
                $intervalID = $checkboxArray[2];

                //creating  user_intervals entries
                $user_entry = array(
                    'user_id' => $userID,
                    'interval_id' => $intervalID
                );

                //inserting in user_intervals for resolving many-to-many
                $this->db->insert('user_intervals', $user_entry);
            }
        }
//       var_dump($intervalArray);
    }

    //gets all the users for populating the table
    public function get_all_users_for_schedule($scheduleID){

        $query = $this->db->get_where('schedule',array('id' => $scheduleID));
        $schedule = $query->row_array();
//        var_dump($schedule);

        $query = $this->db->query(
            "select *
            from user U
            inner join user_intervals UI on U.id = UI.user_id
            inner join date_interval I on UI.interval_id = I.id
            where U.schedule_id=".$schedule['id']."
            order by U.id, I.id");
        return $query->result_array();
    }

    //removes a user
    public function remove_user_fromschedule(){

    }

}