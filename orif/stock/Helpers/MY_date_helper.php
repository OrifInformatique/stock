<?php
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
        return date(config('\Stock\Config\StockConfig')->database_date_format);
    }
    else
    {
        return date_format($date, config('\Stock\Config\StockConfig')->database_date_format);
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
        return date(config('\Stock\Config\StockConfig')->database_datetime_format);
    }
    else
    {
        return date_format($date, config('\Stock\Config\StockConfig')->database_datetime_format);
    }
}


/**
* Convert date from database format to short date format defined in language file
*
* @param $date : The database formatted date
* @return The short formatted date
*/
function databaseToShortDate($date)
{
    if (!empty($date) && $date!='0000-00-00')
    {
        return date_format(date_create_from_format(config('\Stock\Config\StockConfig')->database_date_format, $date),
                           lang('MY_application.date_format_short'));
    }
    else
    {
        return Null;
    }
}
/* End of file My_date_helper.php */
