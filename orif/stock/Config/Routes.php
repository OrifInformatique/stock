<?php
/**
 * Routes for Stock Module
 *
 * @author      Orif (ViDi, AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

$routes->add('stock/migrate/(:any)','\Stock\Controllers\Migrate::$1');
$routes->add('stock/admin/(:any)','\Stock\Controllers\Admin::$1');
$routes->add('stock/export_excel','\Stock\Controllers\ExcelExport::index');
$routes->add('stock/export_excel/(:any)','\Stock\Controllers\ExcelExport::$1');


?>