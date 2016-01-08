<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: MoJe
 * Date: 08.01.2016
 * Time: 14:00
 */
class Users extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->template
            //->set_layout('dashboard')
            ->build('list');
    }

    public function add()
    {
        $this->template
            //->set_layout('dashboard')
            ->build('add');

    }

    public function read()
    {
        $this->template
            //->set_layout('dashboard')
            ->build('read');
    }

    public function edit()
    {
        $this->template
            //->set_layout('dashboard')
            ->build('edit');
    }


}