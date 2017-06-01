<?php

class Upload extends MY_Controller {
    /* MY_Controller variables definition */
    protected $access_level = "*";

        public function __construct()
        {
                parent::__construct();
                $this->load->helper(array('form', 'url'));
        }

        public function index()
        {
                $this->load->view('upload/upload_form', array('error' => ' ' ));
        }

        public function do_upload()
        {

                $config['upload_path']          = './uploads/images/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 10000;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;

                $this->load->library('upload');
                $this->upload->initialize($config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                        $error = array('error' => $this->upload->display_errors());

                        $this->load->view('upload/upload_form', $error);
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());

                        $this->load->view('upload/upload_success', $data);
                }
        }
}
?>