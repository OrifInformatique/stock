<?php

/**
 * Created by PhpStorm.
 * User: MoJe
 * Date: 15.12.2015
 * Time: 10:55
 */
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->template
            //->set_layout('dashboard')
            ->build('dashboard');
    }


}