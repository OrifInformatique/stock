<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use CodeIgniter\HTTP\Response;

use Common\Exceptions\AccessDeniedException;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

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
    public function initController(RequestInterface $request,
        ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // E.g.: $this->session = \Config\Services::session();
        $this->session = \Config\Services::session();
        
        // Check permission on construct
        if (!$this->check_permission()) {
            throw AccessDeniedException::forPageAccessDenied();
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
    protected function check_permission(
        ?int $required_level = NULL): bool|Response
    {
        if (!isset($_SESSION['logged_in'])) {
            // Tests can accidentally delete $_SESSION,
            // this makes sure it always exists.
            $_SESSION['logged_in'] = false;
        }

        if (is_null($required_level)) {
            // No required level is defined, use the controller's default level
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
                return false;
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
    public function display_view(string|array $view_parts,
        ?array $data = NULL): string
    {
        // The view to be constructed and displayed
        $viewToDisplay = '';
        
        // If not defined in $data, set page title to empty string
        if (!isset($data['title'])) {
            $data['title'] = '';
        }

        // Add common headers to the view
        $viewToDisplay .=  view('Common\header', $data);

        // Add login bar to the view
        $viewToDisplay .= view('Common\login_bar');

        // Add admin menu to the view if the current url is an admin url
        foreach (config('Common\Config\AdminPanelConfig')->tabs as $tab){
            if (strstr(current_url(),$tab['pageLink'])) {
                $viewToDisplay .= view('\Common\adminMenu');
            }
        }

        if (is_array($view_parts)) {
            // Add multiple parts to the view
            foreach ($view_parts as $view_part) {
                $viewToDisplay .= view($view_part, $data);
            }
        }
        elseif (is_string($view_parts)) {
            // Add unique part to the view
            $viewToDisplay .= view($view_parts, $data);
        }

        // Add common footers to the view
        $viewToDisplay .= view('Common\footer');
        
        // Return the complete view to display
        return $viewToDisplay;
    }

    /**
     * Transform the array for dropdown display 
     *
     * @param  array $array 
     * @param  string $id = column name of the id
     * @return array
     */
    protected function dropdown($array, $id) {
        $result = array();

        foreach ($array as $row) {
            $result[$row[$id]] = $row['name'];
        }

        return $result;
    }
}
