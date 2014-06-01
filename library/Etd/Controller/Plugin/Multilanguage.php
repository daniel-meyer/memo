<?php
class Etd_Controller_Plugin_Multilanguage extends Zend_Controller_Plugin_Abstract{
    /*public function routeStartup (Zend_Controller_Request_Abstract $request)
    {
    }
 */
    public function routeShutdown (Zend_Controller_Request_Abstract $request)
    {
          $language =  $request->getParam("language");
          
          $locale = Zend_Registry::get('Zend_Locale');
          if(null == $language){ 
            $language = $locale->getLanguage();  
            $front = Zend_Controller_Front::getInstance();
            $router = $front->getRouter();
            $router->setGlobalParam('language', $language);
            $request->setParam('language', $language);
          }else{
            $locale->setLocale($language);
          }
          
          $translate = Zend_Registry::get('Zend_Translate');
          $translate->setLocale($locale);
              
          Zend_Controller_Router_Route::setDefaultTranslator($translate);
    }
}