<?php
/**
 * Routes for Stock Module
 *
 * @author      Orif (ViDi, AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

$routes->add('stock/migrate/(:any)','\Stock\Controllers\Migrate::$1');
?>