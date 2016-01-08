<?php
/**
 * Created by PhpStorm.
 * User: MoJe
 * Date: 21.12.2015
 * Time: 13:06
 */

/*
 * Saving Sets of Validation Rules to a Config File
 * In order to organize your rules into "sets" requires that you place them into "sub arrays"
 * Your validation rule file will be loaded automatically and used when you call the run() function.
 * When a rule group is named identically to a controller class/function it will be used automatically when the run() function is invoked from that class/function.
 * !! Please note that you MUST name your array $config. !!
 * https://ellislab.com/codeigniter/user-guide/libraries/form_validation.html
 */

$config = [
    'authentification/register' => [
        ['field' => 'username', 'label' => 'Username', 'rules' => 'trim|required|min_length[6]|max_length[12]|is_unique[users.username]'],
        ['field' => 'password', 'label' => 'Password', 'rules' => 'trim|required|min_length[8]'],
        ['field' => 'confirm_password', 'label' => 'Confirm Password', 'rules' => 'trim|required|matches[password]'],
        ['field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email']
    ],
    'authentification/login' => [
        ['field' => 'username', 'label' => 'Username', 'rules' => 'trim|required'],
        ['field' => 'password', 'label' => 'Password', 'rules' => 'trim|required'],
    ],
    'email' => [
        ['field' => 'email', 'label' => 'Email', 'rules' => 'required|valid_email'],
        ['field' => 'name', 'label' => 'Name', 'rules' => 'required|alpha'],
        ['field' => 'title', 'label' => 'Title', 'rules' => 'required'],
        ['field' => 'message', 'label' => 'MessageBody', 'rules' => 'required']
    ]
];