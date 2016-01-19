<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: MoJe
 * Date: 08.01.2016
 * Time: 08:06
 */
class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->template
            ->set_partial('header', 'partials/default_header')
            ->set_partial('navbar', 'partials/default_navbar')
            ->set_partial('footer', 'partials/default_footer')
            ->set_layout('dashboard')
            ->build('home');
    }

}