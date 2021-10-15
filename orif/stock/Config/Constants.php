<?php

/*
|--------------------------------------------------------------------------
| CUSTOM CONSTANTS
|--------------------------------------------------------------------------
|
| These are constants defined specially for this application.
|
*/

/**
 * Array of files in public/images that mustn't be deleted or renamed.
 */
define('IMAGES_TO_NOT_DELETE', [
    'favicon.png',
    'logo.jpg',
    'logo.png',
    'no_image.png',
]);

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

 /*
 |-------------------------------------------------------------------------
 | Admin short names max lenght
 |-------------------------------------------------------------------------
 */
define('GROUP_SHORT_MAX_LENGHT', 2);
define('TAG_SHORT_MAX_LENGHT', 3);
define('STOCKING_SHORT_MAX_LENGHT', 10);

/*
 |-------------------------------------------------------------------------
 | Password hash
 |-------------------------------------------------------------------------
 */
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


?>
