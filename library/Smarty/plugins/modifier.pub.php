<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty strip modifier plugin
 *
 * Type:     modifier<br>
 * Name:     strip<br>
 * Purpose:  Replace all repeated spaces, newlines, tabs
 *           with a single space or supplied replacement string.<br>
 * Example:  {$var|strip} {$var|strip:"&nbsp;"}
 * Date:     September 25th, 2008
 * @link http://smarty.php.net/manual/en/language.modifier.strip.php
 *          strip (Smarty online manual)
 * @author   Etendard
 * @version  1.0
 * @param string
 * @param integer 
 * @param string
 * @return string
 */
function smarty_modifier_pub($int) 
{
	return ((int)$int == 1) ? 'publikuj' : 'nie_publikuj' ;
}

/* vim: set expandtab: */

?>
