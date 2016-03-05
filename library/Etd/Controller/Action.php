<?php

abstract class Etd_Controller_Action extends Zend_Controller_Action
{
    
    protected $_auth;
    protected $_acl;
    protected $_session;
    protected $_config;
    protected $_settings;
    protected $_user;
    protected $_locale;
    
    
    
    public function init()
    {
        parent::init();
        
        $this->_config = Zend_Registry::get('config');
        
        $this->_locale = Zend_Registry::get('Zend_Locale');
        $this->view->lang = $this->_locale->getLanguage();
        $this->view->langDefault = $this->_config->etd->language->default;
        
        
        $this->_auth = Zend_Auth::getInstance();
        $this->view->auth = $this->_auth;
        
        $this->_acl = Zend_Registry::isRegistered('acl') ? Zend_Registry::get('acl') : null;
        $this->view->acl = $this->_acl;
        
        $this->view->request = $this->getRequest();
        
        $this->_settings = Zend_Registry::get('settings');
        $this->_user = Zend_Registry::get('user');



        $this->_session = Zend_Registry::get('session');
        $this->view->headTitle()->setSeparator(' :: ');
        $this->view->headTitle()->set($this->_settings->siteTitle);
        $this->view->defaultUser = Orm::factory('User')->findById($this->_config->etd->user->default);
    }
    
    /**
     * redirectToUrl() - Generates an url and redirect
     *
     * @access public
     *
     * @param  array $urlOptions Options passed to the assemble method of the Route object.
     * @param  mixed $name The name of a Route to use. If null it will use the current Route
     * @param  bool $reset Whether or not to reset the route defaults with those provided
     * @return void
     */
    public function redirectToUrl(array $urlOptions = array(), $name = null, $reset = false, $encode = true){
        $url = $this->view->url($urlOptions, $name, $reset, $encode);
        $serverUrl = $this->view->serverUrl();
        $this->_redirect($serverUrl . $url);
    }

    /**
     * addMessage() - Add flashMessange
     *
     * @access public
     * 
     * @param String $message
     * @param String $type: succ, info, fail, warn 
     * @return void
     */
    public function addMessage($message, $type){
        $flashMessenger = $this->_helper->getHelper('FlashMessenger');
        
        if(!in_array($type, array('succ', 'info', 'fail', 'warn'))){
            $type = 'succ';
        }
        
        $flashMessenger->addMessage($type. ':'. $message);
    }
    

    /**
     * prepareZendRequest() - if request like index?id=1, redirect to page index/id/1
     *
     * @access public
     * 
     * @return void
     */
    public function prepareZendRequest(){
        if (!empty($_GET)) {
            $this->redirectToUrl($_GET);
        }
        return;
    }
    
    
    /**
     * Wyłącza wszelki rendering HTML.
     *
     * @return void
     */
    protected function setRAWMode()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
    }
}        