<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


function smarty_function_wykresy_pionowe($params, &$smarty)
{
    
    if (!isset($params['values'])) {
        $smarty->trigger_error("html_table: missing 'values' parameter");
        return;
    }

  $arr = $params['values'];

  $d_width =  empty($params['width']) ? 20: (int)$params['width'];
  $max_length =  empty($params['height']) ? 200: (int)$params['height'];

 $color1 = "'#eeeeee'";
 $color2 = "'#ffffff'";
  $max = 1;
  $out = '<table cellpadding="2"><tr class="menu">';
  foreach($arr as $k => $v) {
    $out .= '<td>'.$k.'</td>';
    if($v > $max)$max = $v;
  }
  $out .= '</tr><tr>';
  
  foreach($arr as $k => $v) 
    if(empty($arr[$k]))
     $out .= '<td style="vertical-align:bottom;text-align:center"
    onmouseover="this.style.background='.$color1.'" onmouseout="this.style.background='.$color2.'"
    >0<div style="width:'.$d_width.'px;height:1px;background-color:#ccc;margin:auto">&nbsp;</div></td>';
    else
     $out .= '<td style="vertical-align:bottom;text-align:center"
    onmouseover="this.style.background='.$color1.'" onmouseout="this.style.background='.$color2.'"
    >'.$v.'<div style="width:'.$d_width.'px;height:'.round(($v/$max)*$max_length).'px;background-color:#ccc;margin:auto">&nbsp;</div>
     </td>';
    
$out .= '</tr></table>';
return $out;

}


/* vim: set expandtab: */

?>
