<?php
/**
 * Routes for user module
 *
 * @author      Orif (ViDi,HeMa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

$routes->add('user/auth/(:any)','\User\Controllers\Auth::$1');

$routes->add('user/admin/(:any)','\User\Controllers\Admin::$1');
?>