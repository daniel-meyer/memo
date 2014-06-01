<?php

class Service
{
    public static function factory($entityName)
    {
    	$className = 'Model_Service_' . ucfirst($entityName);
        return new $className();
    }
}