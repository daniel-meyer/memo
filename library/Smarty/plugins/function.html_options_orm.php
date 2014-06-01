<?php

require_once('function.html_options.php');

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
function smarty_function_html_options_orm($params, &$smarty)
{
    require_once $smarty->_get_plugin_filepath('shared','escape_special_chars');
    
    $name = null;
    $values = null;
    $options = null;
    $selected = array();
    $output = null;
    
    $extra = '';
    
    foreach($params as $_key => $_val) {
        switch($_key) {
            case 'name':
                $$_key = (string)$_val;
                break;
            
            case 'options':
                $$_key = $_val;
                break;
            
            case 'column':
                $$_key = (string)$_val;
                break;    

            case 'selected':
                $$_key = array_map('strval', array_values((array)$_val));
                break;
                
            default:
                if(!is_array($_val)) {
                    $extra .= ' '.$_key.'="'.smarty_function_escape_special_chars($_val).'"';
                } else {
                    $smarty->trigger_error("html_options: extra attribute '$_key' cannot be an array", E_USER_NOTICE);
                }
                break;
        }
    }

    if (!isset($options) && !isset($column))
        return ''; /* raise error here? */

    $_html_result = '';

    if (isset($options)) {
        
        foreach ($options as $_item){
            $value_pack = array();
            foreach(explode(':', $column) as $c){
                $method = 'get' . ucfirst($c);
                $value_pack[] = $_item->$method();
            }

            $_html_result .= smarty_function_html_options_optoutput($_item->getId(), implode(' ', $value_pack) , $selected);
        }
    } 

    if(!empty($name)) {
        $_html_result = '<select name="' . $name . '"' . $extra . '>' . "\n" . $_html_result . '</select>' . "\n";
    }

    return $_html_result;

}



/* vim: set expandtab: */

?>
