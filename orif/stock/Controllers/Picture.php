<?php

namespace Stock\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * A controller to display and manage items
 *
 * @author      Tombez Rémy
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2019, Orif <http://www.orif.ch>
 */
class Picture extends BaseController {
    protected $access_level = "@";

    /**
     * Constructor
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        $this->access_level = "@";
        parent::initController($request, $response, $logger);
    }

    /**
     * Show the image selection and cropping view
     *
     * @param integer $errorId
     * @return void
     */
    public function get_picture($errorId = 0) {
        $data = [];

        switch ($errorId) {
            case 1:
                $data['upload_error'] = lang('MY_application.msg_err_photo_upload');
                break;
            case 0:
            default:
                break;
        }

        $this->display_view('Stock\Views\item\select_photo', $data);
    }

    /**
     * Redirect to the previous page with the cropped image's data
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function add_picture() {
        if (isset($_POST)) {
            if (!empty($_POST) && $_POST['cropped_file'] != NULL) {
                $picture_file = $_POST['cropped_file'];
                $picture_name = $_SESSION['picture_prefix'].IMAGE_PICTURE_SUFFIX.IMAGE_TMP_SUFFIX.IMAGE_EXTENSION;
                file_put_contents(config('\Stock\Config\StockConfig')->images_uploads_path.$picture_name, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $picture_file)));
                return redirect()->to($_SESSION['picture_callback']);
            } else {
                return redirect()->to(base_url('picture/get_picture/1'));
            }
        } else {
            redirect(base_url());
        }
    }

    /**
     * Save previous url, then redirect to Picture/get_picture
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function select_picture() {
        $_SESSION['picture_callback'] = $_SERVER['HTTP_REFERER'];

        return redirect()->to(base_url('picture/get_picture'));
    }
}
