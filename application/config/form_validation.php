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
        array('field' => 'username', 'label' => 'Username', 'rules' => 'trim|required|min_length[3]|max_length[64]|is_unique[users.username], array(\'is_unique\' => \'This username already exists. Please choose another one.\')'),
        ['field' => 'firstname', 'label' => 'First name', 'rules' => 'trim|required|min_length[3]|max_length[64]'],
        ['field' => 'lastname', 'label' => 'Last name', 'rules' => 'trim|required|min_length[3]|max_length[64]'],
        ['field' => 'password', 'label' => 'Password', 'rules' => 'trim|required|min_length[8]'],
        ['field' => 'confirm_password', 'label' => 'Confirm Password', 'rules' => 'trim|required|matches[password]'],
        ['field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email']
    ],

    'authentification/login' => [
        ['field' => 'username', 'label' => 'Username', 'rules' => 'trim|required|min_length[3]|max_length[64]'],
        ['field' => 'password', 'label' => 'Password', 'rules' => 'trim|required|min_length[8]'],
    ],

    'users/add' => [
        ['field' => 'username', 'label' => 'Username', 'rules' => 'trim|required|min_length[3]|max_length[64]|is_unique[users.username]'],
        ['field' => 'firstname', 'label' => 'First name', 'rules' => 'trim|required|min_length[3]|max_length[64]'],
        ['field' => 'lastname', 'label' => 'Last name', 'rules' => 'trim|required|min_length[3]|max_length[64]'],
        ['field' => 'confirm_password', 'label' => 'Confirm Password', 'rules' => 'trim|required|matches[password]'],
        ['field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email']
    ],

    'users/edit' => [
        ['field' => 'username', 'label' => 'Username', 'rules' => 'trim|required|min_length[3]|max_length[64]|is_unique[users.username]'],
        ['field' => 'firstname', 'label' => 'First name', 'rules' => 'trim|required|min_length[3]|max_length[64]'],
        ['field' => 'lastname', 'label' => 'Last name', 'rules' => 'trim|required|min_length[3]|max_length[64]'],
        ['field' => 'confirm_password', 'label' => 'Confirm Password', 'rules' => 'trim|required|matches[password]'],
        ['field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email']
    ],

    'groups/add' => [
        ['field' => 'name', 'label' => 'Name', 'rules' => 'trim|required|min_length[3]|max_length[64]|is_unique[groups.name]'],
    ],

    'groups/edit' => [
        ['field' => 'name', 'label' => 'Name', 'rules' => 'trim|required|min_length[3]|max_length[64]|is_unique[groups.name]'],
    ],

    'items/add' => [
        ['field' => 'name', 'label' => 'Name', 'rules' => 'trim|required|min_length[3]|max_length[64]'],
    ],

    'items/edit' => [
        ['field' => 'name', 'label' => 'Name', 'rules' => 'trim|required|min_length[3]|max_length[64]'],
    ],

    'email' => [
        ['field' => 'email', 'label' => 'Email', 'rules' => 'required|valid_email'],
        ['field' => 'name', 'label' => 'Name', 'rules' => 'required|alpha'],
        ['field' => 'title', 'label' => 'Title', 'rules' => 'required'],
        ['field' => 'message', 'label' => 'MessageBody', 'rules' => 'required']
    ]
];