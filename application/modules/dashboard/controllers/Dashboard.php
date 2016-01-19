<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: jeffreymostroso
 * Date: 17.01.16
 * Time: 18:49
 */
class Dashboard extends MY_Controller
{
    public function index()
    {
        $this->template
            ->set_partial('header', 'partials/dashboard_header')
            ->set_partial('navbar', 'partials/dashboard_navbar')
            ->set_partial('footer', 'partials/dashboard_footer')
            ->set_layout('dashboard')
            ->build('dashboard');
    }
}