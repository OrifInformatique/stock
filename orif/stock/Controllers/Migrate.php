<?php

namespace Stock\Controllers;

use App\Controllers\BaseController;
use Stock\Models\User_details_model;
use Stock\Models\User_model_old;
use User\Models\User_model;

class Migrate extends BaseController
{
    public function index()
    {
        $users = [];
        $userModelOld = new User_model_old();
        $userModelNew = new User_model();
        $userDetails  = new User_details_model();
        $migrate = \Config\Services::migrations();

        $userData = $userModelOld->findAll();

        $size = count($userData);

        for ($i = 0; $i < $size; $i++)
        {
            $users[$i]['lastname']  = $userData[$i]['lastname'];
            $users[$i]['firstname'] = $userData[$i]['firstname'];
        }

        try
        {
            $migrate->setNamespace('Stock')->latest();
        }
        catch(\Throwable $e)
        {
            echo $e->getMessage();
        }

        for ($j = 1; $j < $size+1; $j++)
        {
            $userDetails->insert([
                'id'        => $j,
                'lastname'  => $users[$j-1]['lastname'],
                'firstname' => $users[$j-1]['firstname']
            ]);

            $userModelNew->save([
                'id'                => $j,
                'fk_user_details'   => $j
            ]);
        }

        session()->setFlashdata('warning', 'Migrations completed');
        return redirect()->to(base_url());
    }
}