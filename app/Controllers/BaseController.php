<?php
/**
 * BaseController
 *
 * @author      Orif (ViDi)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch) 
 */

namespace App\Controllers;
use CodeIgniter\Controller;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 * 
 * @package CodeIgniter
 */

class BaseController extends Controller
{
    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Limit the accessibility to the entire controller.
     * Modify this value in constructor of child controllers, before calling parent::initController.
     * 
     * '*' accessible for all users
     * '@' accessible for logged in users
     * 
     * Other possible values are defined in User\Config\UserConfig
     * For example : $access_level = config('User\Config\UserConfig')->access_lvl_admin
     */
    protected $access_level = "*";

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();
        $this->session = \Config\Services::session();
        // Check permission on construct
        if (!$this->check_permission()) {
            $this->display_view('\User\errors\403error');
            exit();
            //throw new \Exception("some message here",403);
            //show_error(lang('msg_err_access_denied_message'), 403, lang('msg_err_access_denied_header'));
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
        if (!isset($_SESSION['logged_in'])) {
            // Tests can accidentally delete $_SESSION,
            // this makes sure it always exists.
            $_SESSION['logged_in'] = FALSE;
        }
        if (is_null($required_level)) {
            $required_level = $this->access_level;
        }

        if ($required_level == "*") {
            // page is accessible for all users
            return true;
        }
        else {
            // check if user is logged in, if not access is not allowed
            if ($_SESSION['logged_in'] != true) {
                // The usual redirect()->to() doesn't work here. Keep this kind of redirect.
                return $this->response->redirect(base_url('user/auth/login'));
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

    /**
     * Display one or multiple view(s), adding header, footer and
     * any other view part wich is common to all pages.
     *
     * @param  $view_parts : single view or array of view parts to display
     *         $data : data array to send to the view
     */
    public function display_view($view_parts, $data = NULL)
    {
        // If not defined in $data, set page title to empty string
        if (!isset($data['title'])) {
            $data['title'] = '';
        }

        // Display common headers
        echo view('Common\header', $data);
        echo view('Common\login_bar');

        if (is_array($view_parts)) {
            // Display multiple view parts
            foreach ($view_parts as $view_part) {
                echo view($view_part, $data);
            }
        }
        elseif (is_string($view_parts)) {
            // Display unique view part
            echo view($view_parts, $data);
        }

        // Display common footer
        echo view('Common\footer');
    }
}
