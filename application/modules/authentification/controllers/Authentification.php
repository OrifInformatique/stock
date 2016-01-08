<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Authentification extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        $this->login();
    }

    public function login()
    {
        if ($this->form_validation->run() == false) {
            $this->template->build('authentification/login');
        } else {
            // else redirect the user to the admin panel
            $this->session->set_flashdata('message', 'Bienvenu !');
            redirect('dashboard', 'refresh');
        }
    }

    public function registration()
    {
        if ($this->form_validation->run() == false) {
            $this->template->build('authentification/registration');
        } else {
            // else redirect the user to the admin panel
            $this->session->set_flashdata('message', 'Bienvenu !');
            redirect('dashboard', 'refresh');
        }
    }

    function logout()
    {
        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect('home', 'refresh');
    }

}