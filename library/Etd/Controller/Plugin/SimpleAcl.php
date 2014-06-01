<?php
class Etd_Controller_Plugin_SimpleAcl extends Zend_Controller_Plugin_Abstract
{
    protected $_auth;
    protected $_acl;
    
    protected $_noauth = array('module' => 'admin',
                               'controller' => 'auth',
                               'action' => 'index');


    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        
        $this->_auth = Zend_Auth::getInstance();
        $this->_acl = new Zend_Acl();
        
        Zend_Registry::set('acl', $this->_acl);

                
        $module = $request->getModuleName();
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        
        if (null == $this->_auth->hasIdentity() && $request->getModuleName()=='admin' && $request->getControllerName()!='auth') {
            $module = $this->_noauth['module'];
            $controller = $this->_noauth['controller'];
            $action = $this->_noauth['action'];
        
        }else {
            return true;
        }
        
        $acl_redirect = Zend_Registry::isRegistered('acl_redirect') ? Zend_Registry::get('acl_redirect') : 0; 
        if($acl_redirect>2){
            throw new Exception('Blad. Wystapilo zapetlone przekierowanie w pluginie Acl');
            return false;
        }
        Zend_Registry::set('acl_redirect', $acl_redirect+1);
        
        $request->setModuleName($module)
                ->setControllerName($controller)
                ->setActionName($action);
               
    }
  

}