<?php

class Etd_View_Helper_FullAge extends Zend_View_Helper_Abstract
{
    /**
     * Encode data as JSON, disable layouts, and set response header
     *
     * If $keepLayouts is true, does not disable layouts.
     *
     * @param  $dateFrom - string or DateTime object
     * @param  $dateTo - null, string or DateTime object
     * @return string|void
     */
    public function fullAge($dateFrom, $dateTo=null)
    {
        $array = Etd_Date::explodeDiff($dateFrom, $dateTo);
        
        $out = '';
        $out .= $array[0].' '. Etd_Tool::nounNumer($array[0], 'rok', 'lata', 'lat') .', ';
        $out .= $array[1].' '. Etd_Tool::nounNumer($array[1], 'miesiąc', 'miesiące', 'miesięcy') .', ';
        $out .= $array[2].' '. Etd_Tool::nounNumer($array[2], 'dzień', 'dni', 'dni');
        
        
        return $out;
    }
    
   
    
    
}
