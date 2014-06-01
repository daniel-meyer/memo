<?php

class Etd_View_Helper_CalendarSelect extends Zend_View_Helper_Abstract
{
    /**
     * Generate calendar html for select
     *
     * @param  string $prefix
     * @param  string $startYear - strtotime format
     * @param  string $endYear - strtotime format
     * @param  string $selected_year
     * @param  string $selected_month
     * @param  string $selected_day
     * @return string|void
     */
    public function calendarSelect($prefix='', $startYear='1900-01-01', $endYear='now', $defaultDate='now', $selected_year=null, $selected_month=null, $selected_day=null)
    {
        $years = range(date('Y', strtotime($endYear)), date('Y', strtotime($startYear)));
        //die("$prefix='', $startYear='1900-01-01', $endYear='now', $selected_year=null, $selected_month=null, $selected_day=null");
        $days = range(1, 31);
        
        $locale = Zend_Registry::get('Zend_Locale');
        $lists = $locale->getTranslationList('months');
		$months = $lists['stand-alone']['wide'];
        
        if($defaultDate instanceof DateTime){
            $dDate = $defaultDate;
        }else{
            $dDate = new DateTime($defaultDate);
        }
        
        if(!$selected_year && !$selected_month && !$selected_day){
            $selected_year = $dDate->format('Y');
            $selected_month = $dDate->format('n'); 
            $selected_day = $dDate->format('j');
        }


        $sy = $this->view->formSelect($prefix.'year', $selected_year, array('id'=>$prefix.'select_year'), $this->_prepareSimpleArray($years));
        $sm = $this->view->formSelect($prefix.'month', $selected_month, array('id'=>$prefix.'select_month'), $months);
        $sd = $this->view->formSelect($prefix.'day', $selected_day, array('id'=>$prefix.'select_day'), $this->_prepareSimpleArray($days));
        
        
        return $sd.$sm.$sy;
    }
    
    protected function _prepareSimpleArray($array){
        $out = array();
        foreach($array as $val){
            $out[$val] = $val;
        }
        return $out;
        
    }
    
    
}
