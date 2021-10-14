<?php

namespace  Stock\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use PSR\Log\LoggerInterface;
use App\Controllers\BaseController;
use Stock\Commands\UpdateImages;
use \CodeIgniter\CLI\Commands;

/**
 * A controller to run the stock:update_images command
 *
 * @author      Orif (ViDi)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c) 2021, Orif <http://www.orif.ch>
 */
class Clean_images extends BaseController {
    //protected $access_level = ACCESS_LVL_ADMIN;
    protected $access_level = '*';

    public function initController(RequestInterface $request, REsponseInterface $response, LoggerInterface $logger) {
        $this->access_level = '*';
        parent::initController($request, $response, $logger);
    }

    public function index() {
        return $this->display_view('Stock\Views\admin\clean_images\delete');
    }

    public function delete() {
        (new UpdateImages($this->logger, new Commands))->run([]);
        //command('stock:update_images'); // Redirects to /localhost
        return $this->display_view('Stock\Views\admin\clean_images\success');
    }
}
