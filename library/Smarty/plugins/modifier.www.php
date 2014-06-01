<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty upper modifier plugin
 *
 * Type:     modifier<br>
 * Name:     upper<br>
 * Purpose:  convert string to uppercase
 * @link http://smarty.php.net/manual/en/language.modifier.upper.php
 *          upper (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @return string
 */
function smarty_modifier_www($string, $prefix='')
{
    $url = str_replace('http://', '', $string);
    
    if(empty($url)){
        return '';
    }
    
    if($prefix == ''){
        return $url;
    }else{
        return 'http://'.$url;
    }

}

