<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This controller can be accessed
 * for Editor group only
 */
class Editor extends MY_Controller
{

    protected $access = ["Admin", "Editor"];

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->template->build('home');
    }
}