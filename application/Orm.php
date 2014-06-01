<?php

class Orm
{
    public static $tableNamesExceptions = array(
        'categories' => 'Category',
    );
    
    
    
    public static function factory($entityName)
    {
    	$className = 'Model_DbTable_' . ucfirst($entityName);
        return new $className();
    }
    
    public static function table($tableName)
    {
    	if(isset(self::$tableNamesExceptions[$tableName])){
    	   $result = self::$tableNamesExceptions[$tableName];
    	}else{
    	   $result = str_replace('_', ' ', strtolower($tableName));
    		$result = preg_replace('/[^a-z0-9 ]/', '', $result);
    		$result = str_replace(' ', '', ucwords($result));
            
            if(substr($result, -1, 1) == 's'){
                $result = substr($result, 0, -1);
            }   
    	}
        
        $className = 'Model_DbTable_' . ucfirst($result);
        return new $className();
    }
    
    public static function clear(array $collection)
    {
    	$i=0;
        foreach($collection as $item){
    	   $item->delete();
           ++$i;
    	}
        return $i;
    }
}