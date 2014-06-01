<?php

require_once 'Orm.php';
require_once 'Service.php';

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{    
    protected function _initConfig()
    {
        $config = new Zend_Config($this->getOptions(), true);
        Zend_Registry::set('config', $config);
        return $config;
    }

    public function _initSession()
    {
        if (isset($_POST['PHPSESSIONID'])) {
            Zend_Session::setId($_POST['PHPSESSIONID']);
            //Zend_Session::start();
        }
        
        $this->bootstrap('view');
        $session = $this->getPluginResource('session'); 
        $session->init(); 
        
        $etd_session = new Zend_Session_Namespace('etd_session');
        Zend_Registry::set('session', $etd_session);
        $view = $this->getResource('view');
        $view->session = $etd_session;
        return $etd_session;
    }
    
    protected function _initZFDebug()
    {
        $zfdebugConfig = $this->getOption('zfDebug');
        $session = Zend_Registry::get('session');
        
        if(isset($_GET['debug']) && $_GET['debug']==1){
            $session->debug = 1;
        }
        if(isset($_GET['debug']) && $_GET['debug']==0){
            $session->debug = 0;
        }
        if(isset($_GET['toolbox']) && $_GET['toolbox']==1){
            $session->toolbox = 1;
        }
        if(isset($_GET['toolbox']) && $_GET['toolbox']==0){
            $session->toolbox = 0;
        }       
        
        if ($zfdebugConfig && $zfdebugConfig['enable'] && !empty($session->debug))
        {
            $autoloader = Zend_Loader_Autoloader::getInstance();
            $autoloader->registerNamespace('ZFDebug');
            
            $options = array(
                'plugins' => array(
                    'Variables',
                    'Database',
                    'File' => array('base_path' => realpath(APPLICATION_PATH), 'library'=>array('Etd')),
                    'Memory', 
                    'Time', 
                    'Registry', 
                    'Exception'
                )
            );
            
            # Instantiate the database adapter and setup the plugin.
            if ($this->hasPluginResource('db')) {
                $this->bootstrap('db');
                $db = $this->getPluginResource('db')->getDbAdapter();
                $options['plugins']['Database']['adapter'] = $db;
            }
            
            # Setup the cache plugin
            if ($this->hasPluginResource('cache')) {
                $this->bootstrap('cache');
                $cache = $this->getPluginResource('cache')->getCache();
                if(null !=$cache){
                    $options['plugins']['Cache']['backend'] = $cache->getBackend();
                }
            }

            $this->bootstrap('frontController');
            $this->getResource('frontController')->registerPlugin(
                new ZFDebug_Controller_Plugin_Debug($options)
            );
        }
    }
    
    protected function _initAuth()
    {
        $this->bootstrap('session');
        $this->bootstrap('db');
        $this->bootstrap('view');
        
        $user = Service::factory('User')->getUser();
        
        Zend_Registry::set('user', $user);
        $view = $this->getResource('view');
        $view->user = $user;
        
        return Zend_Auth::getInstance();
    }
    
    protected function _initFlashMessenger()
    {
        /** @var $flashMessenger Zend_Controller_Action_Helper_FlashMessenger */
        $flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');
        if ($flashMessenger->hasMessages()) {
            $view = $this->getResource('view');
            $view->messages = $flashMessenger->getMessages();
        }
    }
    
    protected function _initRouter()
    {
        $this->bootstrap('db');
        $this->bootstrap('cache');
       
        $config = new Zend_Config_Ini(dirname(__FILE__) . '/configs/router.ini', 'production');
   
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();
   
        $router->addConfig($config, 'routes');

    
        // Returns the router resource to bootstrap resource registry
        return $router;
    
    }
}


