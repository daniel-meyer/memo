<?php

class Model_Service_Province
{
    public function getAssocFromDB()
    {
        $entities = Orm::factory('Province')->fetchAll();
        
        $out = array();
        foreach($entities as $e){
            $out[ $e->getId() ] = $e->getName();
        }
        
        return $out;
    }
    public function getAssoc()
    {        
        $cache = Zend_Registry::get('cache');
        $cacheName = 'Provinces_getAssoc';
        if( ($result = $cache->load($cacheName)) === false ) {     
            $result = $this->getAssocFromDB();
            $cache->save($result, $cacheName);
        }
        return $result;
    }    
}        