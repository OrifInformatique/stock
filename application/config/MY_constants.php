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
| Inventory number
|--------------------------------------------------------------------------
*/
define('INVENTORY_PREFIX', 'ORP');   // first part of inventory number (Orif site prefix)
define('INVENTORY_NUMBER_CHARS', 4); // number of chars in the ID part (to add leading zeros)

 /*
 |-------------------------------------------------------------------------
 | Admin short names max lenght
 |-------------------------------------------------------------------------
 */
define('GROUP_SHORT_MAX_LENGHT', 2);
define('TAG_SHORT_MAX_LENGHT', 3);
define('STOCKING_SHORT_MAX_LENGHT', 10);

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
|--------------------------------------------------------------------------
| Default image used for when there is no image assigned to a item
|--------------------------------------------------------------------------
*/
define('ITEM_NO_IMAGE', 'no_image.png');

/*
|--------------------------------------------------------------------------
| Default image extension for when a image is saved
|--------------------------------------------------------------------------
*/
define('IMAGE_EXTENSION', '.png');

/*
|--------------------------------------------------------------------------
| Pictures' name suffix
|--------------------------------------------------------------------------
*/
define('IMAGE_PICTURE_SUFFIX', '_picture');

/*
|--------------------------------------------------------------------------
| Pictures' temporary name suffix
|--------------------------------------------------------------------------
*/
define('IMAGE_TMP_SUFFIX', '_tmp');

/*
|--------------------------------------------------------------------------
| Uploaded images path
|--------------------------------------------------------------------------
*/
define('IMAGES_UPLOAD_PATH', 'uploads/images/');

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

/*
 |-------------------------------------------------------------------------
 | Image upload dimensions
 |-------------------------------------------------------------------------
 */
define('IMAGE_UPLOAD_WIDTH', 360);
define('IMAGE_UPLOAD_HEIGHT', 360);