<?php
/**
 * Created by PhpStorm.
 * User: tudorgk
 * Date: 22/11/13
 * Time: 8:15 PM
 */

class pages extends CI_Controller {

    public function index($page = 'home')
    {
        if ( ! file_exists('application/views/pages/'.$page.'.php'))
        {
            // Whoops, we don't have a page for that!
            show_404();
        }

        $data['title'] = ucfirst($page); // Capitalize the first letter

        $this->load->view('templates/header', $data);
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer', $data);    }

}