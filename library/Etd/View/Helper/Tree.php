<?php

class Etd_View_Helper_Tree extends Zend_View_Helper_Abstract
{
    protected $lines;
    protected $childernLine;
    
    /**
     * Encode data as JSON, disable layouts, and set response header
     *
     * If $keepLayouts is true, does not disable layouts.
     *
     * @param  $dateFrom - string or DateTime object
     * @param  $dateTo - null, string or DateTime object
     * @return string|void
     */
    public function tree($data, $html)
    {
        $this->lines= explode("\n", $html);
        
        $this->childernLine = $this->_arraySearch($this->lines, '[children]');

        return $this->_makeTree($data);
    }
    
    protected function _makeTree($data)
    {
        $html = '';
        foreach($data as $item){

            $myLines = $this->_arrayBind($item['page']);
            
            if(count($item['children'])){
                $myLines[$this->childernLine] =  str_replace('[children]', $this->_makeTree($item['children']), $myLines[$this->childernLine]);
            }elseif($this->childernLine !== null){
                unset($myLines[$this->childernLine]);
            }
            
            $html .= join("\n", $myLines) . "\n\n";
        }
        
        return $html;
        
    }
    
    protected function _arrayBind($page)
    {
        $from = array(
            '[id]',
            '[level]',
            '[menu_title]',
            '[title]',
        );
        
        $to = array(
            $page->getId(),
            $page->getLevel(),
            $page->getMenuTitle(),
            $page->getTitle(),
        );
        
        $lines = array();
        foreach($this->lines as $k=>$v){
            $lines[$k] = str_replace($from, $to, $v);
        }
        return $lines;
    }
    
    protected function _arraySearch($array, $needle)
    {
        foreach($array as $k=>$v){
            if(strstr($v, $needle)){
                return $k;
            }
        }
        return null;
    }
    
   
    
    
}
