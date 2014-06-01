<?php
class Etd_Cache 
{
    private $object;
    private $cache;
    
    public function __construct($object) 
    {
        $manager = new Zend_Cache_Manager;
        
        try {
            $this->cache = $manager->getCache('etdCache');
            var_dump($manager->getCaches());
            $this->cache->setOptions(array('cached_entity' => $object));
            $this->object = $object;     
        } catch(Exception $e) {
            throw($e);
        }
    }

    public function __call($method, $args) 
    {
        $class = get_class($this->object);
        $class_methods = get_class_methods($class);
        
        if(in_array($method , $class_methods)) {
            $caller = array($this->cache, $method);
            return call_user_func_array($caller, $args);
        }
        
        throw new Exception( " Method " . $method . " does not exist in this class " . get_class($class ) . "." );
    }
}