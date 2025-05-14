<?php

namespace Stock\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Cors implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: X-API-KEY, Origin,X-Requested-With, Content-Type, Accept, Access-Control-Requested-Method, Authorization');

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'OPTIONS') {
            die();
        }
    }

    public function after(RequestInterface $request,
        ResponseInterface $response, $arguments = null)
    {

    }
}