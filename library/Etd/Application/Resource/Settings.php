<?php
 
class Etd_Application_Resource_Settings extends Zend_Application_Resource_ResourceAbstract
{
  /**   
   * Default registry key
   */
  const DEFAULT_REGISTRY_KEY = 'settings';
 

  protected $_settings = null; 
  
  /**
   * Inititalize settings resource
   *
   * @return settings   */
  public function init ()
  {
    return $this->getSettings();
  } 
  
  /**
   * Return settings instance
   *
   * @return settings   */
  public function getSettings ()
  {
    if (null === $this->_settings) {
        $options = $this->getOptions(); 
        
        if(false == $options['enable']){
            return false;
        }
        
        $this->_settings = Service::factory('Setting')->getAssoc();
        
        /// add to registry      
        $key = (isset($options['registry_key']) && !is_numeric($options['registry_key'])) ? $options['registry_key'] : self::DEFAULT_REGISTRY_KEY;
        Zend_Registry::set($key, $this->_settings);
        
        //add to view
        if($view = $this->getView()){
            $view->$key = $this->_settings;
        }
    }
    return $this->_settings;
  }
  
  public function getDbAdapter()
  {
        $bootstrap = $this->getBootstrap();
        
        if ($bootstrap->hasPluginResource('db')) {
            return $bootstrap->getPluginResource('db')->getDbAdapter();
        }
        
        return null;
   }
   public function getView()
  {
        $bootstrap = $this->getBootstrap();
        
        if ($bootstrap->hasPluginResource('view')) {
            return $bootstrap->getPluginResource('view')->getView();
        }
        
        return null;
   }
   
  
}