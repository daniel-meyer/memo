<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {html_options} function plugin
 *
 * Type:     function<br>
 * Name:     html_options<br>
 * Input:<br>
 *           - name       (optional) - string default "select"
 *           - values     (required if no options supplied) - array
 *           - options    (required if no values supplied) - associative array
 *           - selected   (optional) - string default not set
 *           - output     (required if not options supplied) - array
 * Purpose:  Prints the list of <option> tags generated from
 *           the passed parameters
 * @link http://smarty.php.net/manual/en/language.function.html.options.php {html_image}
 *      (Smarty online manual)
 * @author Monte Ohrt <monte at ohrt dot com>
 * @param array
 * @param Smarty
 * @return string
 * @uses smarty_function_escape_special_chars()
 */
function smarty_function_html_options_kat($params, &$smarty)
{
    require_once $smarty->_get_plugin_filepath('shared','escape_special_chars');
 
    $name = null;
    $options = null;
    $selected = array();
    
    $extra = '';
    
    foreach($params as $_key => $_val) {
        switch($_key) {
            case 'name':
                $$_key = (string)$_val;
                break;
            
            case 'options':
                $$_key = (array)$_val;
                break;
                

            case 'selected':
                $$_key = array_map('strval', array_values((array)$_val));
                break;
                
            default:
                if(!is_array($_val)) {
                    $extra .= ' '.$_key.'="'.smarty_function_escape_special_chars($_val).'"';
                } else {
                    $smarty->trigger_error("html_options_kat: extra attribute '$_key' cannot be an array", E_USER_NOTICE);
                }
                break;
        }
    }

    if (!isset($options))
        return ''; /* raise error here? */

    $_html_result = '';
     	$tree = 0;
        foreach ($options as $_key=>$_val){

        	
        	$_html_result .= '<option value="'.$_val['id'].'"';
        	
        	if(in_array($_val['id'],$selected))$_html_result .= ' selected="selected"';
        	$tree=0;
        	if($_val['id_kat1'])++$tree;
        	if($_val['id_kat2'])++$tree;

        	switch($tree){
        		case 0:
	                $_html_result .= ' style="font-weight:bold;">&raquo;';
	                break;
	            case 1:
	                $_html_result .= '>&nbsp;&nbsp;+';
	                break;
	                
	            case 2:
	                $_html_result .= '>&nbsp;&nbsp;&nbsp;&nbsp;-';
	                break;
	            default:
                	$_html_result .= '>';
                break;    
	                
        	}
        	
        	
        	$_html_result .= '&nbsp;'.$_val['nazwa'].'</option>';

            //if(!empty($_val['dzieci'])) ++$tree;
        	//if(!empty($_val['koniec'])) --$tree;
        }
            
   

    if(!empty($name)) {
        $_html_result = '<select name="' . $name . '"' . $extra . '>' . "\n" . $_html_result . '</select>' . "\n";
    }

    return $_html_result;

}


