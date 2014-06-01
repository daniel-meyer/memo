<?php

class Model_Service_Setting
{
    public function getAssocFromDB()
    {
        $entities = Orm::factory('Setting')->fetchAll();
        
        $out = new stdClass;
        foreach($entities as $e){
            $out->{$e->getName()} = $e->getValue();
        }
        
        return $out;
    }
    
    public function getAssoc()
    {
        $cache = Zend_Registry::get('cache');
        $cacheName = 'Settings_getAssoc';
        if( ($result = $cache->load($cacheName)) === false ) {     
            $result = $this->getAssocFromDB();
            $cache->save($result, $cacheName, array( get_class(Orm::factory('Setting')) ));
        }
        return $result;
    }    
}        