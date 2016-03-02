<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Add some functions to the basic CodeIgniter Date Helper
 * 
 * @author      Didier Viret
 * @link        https://github.com/OrifInformatique/stock
 * @copyright   Copyright (c) 2016, Orif <http://www.orif.ch>
 */


/**
* Check if a given date (for example a date written in a form) is a valid date
*
* @return true if the date is valid, false else
*/
function validateDate($date, $format)
{
    // Check that $date is a valid date
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

/**
* Format a given date or the current date to the php timestamp format
*
* @return The formated date
*/
function phpDate($date)
{
    if (empty($date) || strtolower($date) == 'now')
    {
        return now();
    }
    else
    {
        return strtotime($date);
    }
}

/**
* Format a given date or the current date to MySQL DATE type
*
* @return The formated date
*/
function mysqlDate($date)
{
    if (empty($date) || strtolower($date) == 'now')
    {
        return date('Y-m-d');
    }
    else
    {
        return nice_date($date, 'Y-m-d');
    }
}

/**
* Format a given date or the current date to MySQL DATETIME type
*
* @return The formated date
*/
function mysqlDateTime($date)
{
    if (empty($date) || strtolower($date) == 'now')
    {
        return date('Y-m-d H:i:s');
    }
    else
    {
        return nice_date($date, 'Y-m-d H:i:s');
    }
}

/* End of file My_date_helper.php */