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
            $this->schedule_model->set_schedule();
            $this->load->view('templates/header', $data);
            $this->load->view('schedules/success');
            $this->load->view('templates/footer');
        }
    }

}