<?php

namespace Stock\Controllers;

use App\Controllers\BaseController;
use DateTime;
use Stock\Models\User_details_model;
use Stock\Models\User_model_old;
use User\Models\User_model;

class Migrate extends BaseController
{
    public function index()
    {
        $users = [];
        $archive = [];
        $userModelOld = new User_model_old();
        $userModelNew = new User_model();
        $userDetails  = new User_details_model();
        $migrate = \Config\Services::migrations();

        $userData = $userModelOld->findAll();

        // counts all users in user table
        $size = count($userData);

        // Add all data inside two arrays, to avoid data loss
        for ($i = 0; $i < $size; $i++)
        {
            $users[$i]['lastname']  = $userData[$i]['lastname'];
            $users[$i]['firstname'] = $userData[$i]['firstname'];
            $archive[$i+1]['archive'] = $userData[$i]['is_active'];
        }

        try
        {
            $migrate->setNamespace('Stock')->latest();
        }
        catch(\Throwable $e)
        {
            echo $e->getMessage();
        }

        // Inserts data from precendent arrays and then connects foreign key to the correct user 
        // Because we begin the loop at 1, we need to increment size a single time
        for ($j = 1; $j < $size+1; $j++)
        {
            $userDetails->insert([
                'id'        => $j,
                'lastname'  => $users[$j-1]['lastname'],
                'firstname' => $users[$j-1]['firstname']
            ]);

            // Makes sure archive is set on NULL to avoid non-active account
            if ($archive[$j]['archive'] == 1)
            {
                $userModelNew->save([
                    'id'        => $j,
                    'archive'   => null
                ]);
            }

            $userModelNew->save([
                'id'                => $j,
                'fk_user_details'   => $j
            ]);
        }

        return redirect()->to(base_url());
    }
}