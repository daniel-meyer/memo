<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty plugin
 *
 * Type:     modifier<br>
 * Name:     nl2br<br>
 * Date:     Feb 26, 2003
 * Purpose:  convert \r\n, \r or \n to <<br>>
 * Input:<br>
 *         - contents = contents to replace
 *         - preceed_test = if true, includes preceeding break tags
 *           in replacement
 * Example:  {$text|nl2br}
 * @link http://smarty.php.net/manual/en/language.modifier.nl2br.php
 *          nl2br (Smarty online manual)
 * @version  1.0
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @return string
 */
function smarty_modifier_online($date)
{
    if(null == $date){
        return '---';
    }
    
    $czas_bezczynnosci = 30; //minut
    
    if($date->format('U') > time()-(60*$czas_bezczynnosci)){
        return 'on-line';
    }elseif(date('Ymd') == $date->format('Ymd')){
        return 'dzisiaj';
    }elseif(date('Ymd', strtotime('-1 day')) == $date->format('Ymd')){
        return 'wczoraj';
    }
    
    $arr = Etd_Date::explodeDiff($date);
    
    if($arr[0]){
        return $arr[0] .' '. Etd_Tool::nounNumer($arr[0], 'rok', ' lata', ' lat') . ' temu';
    }
    if($arr[1]){
        return $arr[1] .' '. Etd_Tool::nounNumer($arr[1], 'miesiąc', 'miesiące', 'miesięcy') . ' temu';
    }
    
    $tygodnie = floor($arr[2]/7);
    
    if($tygodnie){
        return $tygodnie .' '. Etd_Tool::nounNumer($tygodnie, 'tydzień', 'tygodnie', 'tygodni') . ' temu';
    }
    
    if($arr[0]){
        return $arr[2] .' '. Etd_Tool::nounNumer($arr[2], 'dzień', 'dni', 'dni') . ' temu';
    }

    
    return $arr[$sex];
}

/* vim: set expandtab: */

?>
