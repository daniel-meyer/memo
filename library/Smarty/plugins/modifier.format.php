<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty date_format modifier plugin
 *
 * Type:     modifier<br>
 * Name:     date_format<br>
 * Purpose:  format datestamps via strftime<br>
 * Input:<br>
 *         - string: input date string
 *         - format: strftime format for output
 *         - default_date: default date if $string is empty
 * @link http://smarty.php.net/manual/en/language.modifier.date.format.php
 *          date_format (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param string
 * @param string
 * @return string|void
 * @uses smarty_make_timestamp()
 */
function smarty_modifier_format($string, $format = 'Y.m.d G:i')
{
    if (empty($string) || $string == '0000-00-00' || $string == '0000-00-00 00:00-00') {
        return;
    } elseif($string instanceof DateTime){
        $datetime = $string;
    } else {
        $datetime = new DateTime($string);
    }

    return $datetime->format($format);
}

