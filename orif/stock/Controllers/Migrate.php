<?php

namespace Stock\Controllers;

use App\Controllers\BaseController;

class Migrate extends BaseController
{
    public function index()
    {
        $migrate = \Config\Services::migrations();

        try
        {
            $migrate->setNamespace('Stock')->latest();
        }
        catch(\Throwable $e)
        {
            echo $e->getMessage();
        }

        return redirect()->to(base_url());
    }
}