<?php

namespace Stock\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Cors implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if ($request->getMethod() === 'options') {
            header('Access-Control-Allow-Origin: http://localhost:4000');

            exit;
        }
    }

    public function after(RequestInterface $request,
        ResponseInterface $response, $arguments = null)
    {
        $response->setHeader('Access-Control-Allow-Origin', 'http://localhost:4000');
    }
}