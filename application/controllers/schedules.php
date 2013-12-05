<?php
/**
 * Created by PhpStorm.
 * User: tudorgk
 * Date: 22/11/13
 * Time: 7:39 PM
 */

class schedules extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('schedule_model');
        $this->load->model('date_model');
        $this->load->model('interval_model');

    }

    public function index()
    {
        $data['schedules'] = $this->schedule_model->get_schedules();

//        var_dump($data);

        $data['title'] = 'Schedule List';
        $data['name'] = 'Schedule List';

        $this->load->view('templates/header', $data);
        $this->load->view('schedules/index', $data);
        $this->load->view('templates/footer');
    }

    public function view($slug)
    {
        $data['schedule_item'] = $this->schedule_model->get_schedules($slug);
        var_dump($data['schedule_item']);
        if (empty($data['schedule_item']))
        {
            show_404();
        }

        $data['title'] = $data['schedule_item']['name'];
        $data['name'] = $data['schedule_item']['name'];

        $this->load->view('templates/header', $data);
        $this->load->view('schedules/view', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['name'] = 'Create a schedule';
        $data['title'] = 'Create a schedule';

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');


        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('schedules/create');
            $this->load->view('templates/footer');

        }
        else
        {
            $data['schedule'] = $this->schedule_model->set_schedule();
            $this->load->view('templates/header', $data);
            $this->load->view('schedules/success',$data);
            $this->load->view('templates/footer');
        }
    }

    public function vote($schedule_hash = false)
    {
        if($schedule_hash == false){
            show_404();
        }

        //loading the form helper
        $this->load->helper('form');

        $data['schedule'] = $this->schedule_model->get_schedules($schedule_hash);
        $data['dates'] = $this->date_model->get_datesForSchedule($data['schedule']['id']);

        //retrieving the intervals for the dates
        for($i =0 ; $i< count($data['dates']); $i++){
            $intervals =  $this->interval_model->get_intervalsForDate($data['dates'][$i]['id']);
            $data['dates'][$i]['intervals'] = $intervals;
            //var_dump($data['dates'][$i]['intervals']);
        }

        //var_dump($data['dates'][0]['intervals']);
        //var_dump($this->date_model->get_datesForSchedule($data['schedule']['id']));

        var_dump($this->schedule_model->get_all_users_for_schedule($data['schedule']['id']));

        $data['title'] = 'Vote on an interval';

        $this->load->view('templates/header', $data);
        $this->load->view('schedules/vote',$data);
        $this->load->view('templates/footer');
    }

    public function submitVote(){
        //loading the form helper
        $this->load->helper('form');

        $data['data'] = $this->schedule_model->set_user_for_schedule();

        return $data['data'];
    }

}