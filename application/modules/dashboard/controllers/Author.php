<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This controller can be accessed
 * for Author group only
 */
class Author extends MY_Controller
{

    protected $access = "Author";

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->template->build('home');
    }

}