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

        $query = $this->db->get_where('schedule',array('id' => $slug));
        
        return $query->row_array();
    }

    public function set_schedule()
    {
        $this->load->helper('url');

        $link_hash = uniqid('melt_');

        $data = array(
            'name' => $this->input->post('name'),
            'link_hash' => $link_hash,
            'description' => $this->input->post('description')
        );
        return $this->db->insert('schedule', $data);
    }

}