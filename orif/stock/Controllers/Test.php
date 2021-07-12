<?php
/**
 * User Authentication
 *
 * @author      Orif (ViDi,HeMa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */
namespace Stock\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Stock\Models\Item_model;

class Test extends BaseController 
{

    /**
     * Constructor
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        helper('form');

        // Load required services
        $this->validation = \Config\Services::validation();

        // Load required models
        $this->item_model = new Item_model();

        //get db instance
        $this->db = \CodeIgniter\Database\Config::connect();
    }

    public function index()
    {
        //$item = $this->item_model->where('item_id', 5)->first();
        return $this->item_model->get_future_id();
    }
}