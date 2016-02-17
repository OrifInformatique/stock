<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * A base controller with permission check functions
 * 
 * @author      Didier Viret
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */

class MY_Controller extends CI_Controller
{

    /**
     * '*' for all users
     * '@' for logged in users
     * '0, 1, 2, 4, 8, ...' for access level (power of 2)
     */
    protected $access_level = "*";

    public function __construct()
    {
        parent::__construct();

        /* Check permission on construct */
        if (!$this->check_permission()) {
            die("<h4>Access denied</h4>");
        }
    }

    /**
    * Check if user access level matches the required access level.
    * Required level can be the controller's default level or a custom
    * specified level.
    *
    * @param  $required_level : minimum level required to get permission
    * @return bool : true if user level is equal or higher than required level,
    *                false else
    */
    protected function check_permission($required_level = NULL)
    {
        if (is_null($required_level)) {
            $required_level = $this->access_level;
        }

        if ($required_level == "*") {
            // page is accessible for all users
            return true;
        }
        else {
            // check if user is logged in
            // if not, redirect to login page
            if ($_SESSION['logged_in'] != true) {
                redirect("auth/login");
            }
            // check if page is accessible for all logged in users
            elseif ($required_level == "@") {
                return true;
            }
            // check access level
            elseif ($required_level <= $_SESSION['user_access']) {
                return true;
            }
            // no permission
            else {
                return false;
            }
        }
    }
}