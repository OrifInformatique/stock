<?php

$routes->group('welcome',function($routes){
    $routes->add('home','\Welcome\Controllers\Home');
    $routes->add('home/(:any)','\Welcome\Controllers\Home::$1');
});

?>