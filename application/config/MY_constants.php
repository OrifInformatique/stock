<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| CUSTOM CONSTANTS
|--------------------------------------------------------------------------
|
| These are constants defined specially for this application.
|
*/

/*
|--------------------------------------------------------------------------
| Authentication system constants
|--------------------------------------------------------------------------
*/
define('ACCESS_LVL_GUEST', 1);
define('ACCESS_LVL_OBSERVATION', 2);
define('ACCESS_LVL_FORMATION', 4);
define('ACCESS_LVL_MSP', 8);
define('ACCESS_LVL_ADMIN', 16);

define('USERNAME_MIN_LENGTH', 3);
define('USERNAME_MAX_LENGTH', 45);
define('PASSWORD_MIN_LENGTH', 6);
define('PASSWORD_MAX_LENGTH', 72);

define('PASSWORD_HASH_ALGORITHM', PASSWORD_BCRYPT);

/*
|--------------------------------------------------------------------------
| Inventory number
|--------------------------------------------------------------------------
*/
define('INVENTORY_PREFIX', 'ORP');   // first part of inventory number (Orif site prefix)
define('INVENTORY_NUMBER_CHARS', 4); // number of chars in the ID part (to add leading zeros)

/*
|--------------------------------------------------------------------------
| ID of the "functional" item condition
|--------------------------------------------------------------------------
*/
define('FUNCTIONAL_ITEM_CONDITION_ID', 10);

/*
|--------------------------------------------------------------------------
| ID of the item's default group
|--------------------------------------------------------------------------
*/
define('ITEMS_DEFAULT_GROUP', 2);

/*
 |-------------------------------------------------------------------------
 | Number of items show by page
 |-------------------------------------------------------------------------
 */
define('ITEMS_PER_PAGE',25);

/*
 |-------------------------------------------------------------------------
 | Database date and datetime format for conversions to PHP format
 |-------------------------------------------------------------------------
 */
define('DATABASE_DATE_FORMAT', 'Y-m-d');
define('DATABASE_DATETIME_FORMAT', 'Y-m-d H:i:s');
