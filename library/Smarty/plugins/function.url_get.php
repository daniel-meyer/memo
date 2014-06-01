<?php

function smarty_function_url_get($params, &$smarty) {
       
    $get = (array)$_GET;
    
    foreach($params as $k=>$v){
        if($v == null){
            unset($get[$k]);
        }else{
            $get[$k] = $v;    
        }
    }
    
    $parts = array();
    
    foreach($get as $k=>$v){
        $parts[] = "$k=$v";
    }
    
    return Zend_Registry::get('view')->url() . '?' . join('&amp;', $parts);
    

}