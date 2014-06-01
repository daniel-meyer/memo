<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


function smarty_function_wykresy_poziome($params, &$smarty)
{
    if (!isset($params['labels'])) {
        $smarty->trigger_error("html_table: missing 'labels' parameter");
        return;
    }
    
    if (!isset($params['values'])) {
        $smarty->trigger_error("html_table: missing 'values' parameter");
        return;
    }
  $arr_n = $params['labels'];
  $arr_v = $params['values'];

  $d_width =  empty($params['width']) ? 200: (int)$params['width'];
  $is_link =  !empty($params['mode']);

 $color1 = "'#eeeeee'";
 $color2 = "'#ffffff'";
  //naglowki
  $out = '<table cellpadding="2" width="100%"><tr class="menu">
  <td class="lp">L.p.</td>';
  foreach($arr_n as $v)
    $out .= '<td>'.$v.'</td>';
  
  $out .= '</tr>';
  arsort($arr_v);
  $max = current($arr_v);
  if(!$max)$max = 1;
  $lp=1;
  foreach($arr_v as $k => $v){
  	$out .=  '<tr class="rows" align="left" onmouseover="this.style.background='.$color1.'" onmouseout="this.style.background='.$color2.'">';
  	$out .=  '<td class="lp">'.$lp.'</td>';
  	$out .=  '<td style="width:200px"><div style="height:11px;width:'.round($v/$max*($d_width-50)).'px;background-color:#ccc;float:left;margin-right:3px">&nbsp;</div>'.$v.'&nbsp;</td>';
  	if($is_link) $out .=  '<td><a href="http://'.$k.'" target="_blank">'.$k.'</a>&nbsp;</td>';
  	else $out .=  '<td>'.$k.'&nbsp;</td>';
  	$out .= '</tr>';
  	$lp++;
  }
  $out .= '</table>';
  return $out;

}


/* vim: set expandtab: */

?>
