<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Authentification extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('authentification_model', 'authentification');
    }

    public function index()
    {
        redirect('authentification/login');
    }

    public function login()
    {
        $this->logged_in_check();
        if ($this->form_validation->run() == true) {
            $status = $this->authentification->validate();
            if ($status == ERR_INVALID_USERNAME) {
                $this->session->set_flashdata('error', 'Username is invalid');
            } elseif ($status == ERR_INVALID_PASSWORD) {
                $this->session->set_flashdata('error', 'Password is invalid');
            } else {
                $this->session->set_userdata($this->authentification->get_data());
                $this->session->set_userdata("logged_in", true);
                redirect("dashboard");
            }
        }
        $this->template
            ->set_partial('header', 'partials/authentification_header')
            ->set_partial('footer', 'partials/authentification_footer')
            ->set_layout('blank')
            ->build('login');
    }

    public function logged_in_check()
    {
        if ($this->session->userdata("logged_in")) {
            redirect("dashboard");
        }
    }

    /**
     * logout function.
     *
     * @access public
     * @return void
     */
    public function logout()
    {
        $data = new stdClass();
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            foreach ($_SESSION as $key => $value) {
                unset($_SESSION[$key]);
            }
            $this->session->set_flashdata('error', 'Vous êtes maintenant déconnecté !');
            redirect('authentification/login', 'refresh');
        } else {
            redirect('/');
        }

    }

}