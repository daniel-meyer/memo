<?php
class Etd_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
    protected $_auth;
    protected $_acl;
    
    protected $_noauth = array('module' => 'default',
                               'controller' => 'auth',
                               'action' => 'index');

    protected $_noacl = array('module' => 'default',
                              'controller' => 'error',
                              'action' => 'privileges');

    protected $_noresource = array('module' => 'default',
                                   'controller' => 'error',
                                   'action' => 'page-not-found');

    

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $this->_auth = Zend_Auth::getInstance();
        $this->_acl = new Model_Service_Acl();
        
        Zend_Registry::set('acl', $this->_acl);

        $roles = array();
        $roles[] = $this->_acl->getDefaultRole();
        
            
        if ($this->_auth->hasIdentity()) {
            
            $user = Zend_Registry::get('user');
            
            if(null == $user){
                $this->_auth->clearIdentity();
            }else{
                //roles            
                foreach($user->getUserRoles() as $userRole){
                    $roles[] = $userRole->getRole()->getName();
                }
            }
            
            
        }
        
        $this->_acl->setUserRoles($roles);
        
        $module = $request->getModuleName();
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        
        $resource = $module.':'.$controller.':'.$action;
        
        if (null == $this->_acl->has($resource)) {
            
            $this->_acl->tryGenerateResource($request);
            
            $module = $this->_noresource['module'];
            $controller = $this->_noresource['controller'];
            $action = $this->_noresource['action'];
                
        }elseif (null == $this->_acl->isAllowedUrl($action, $controller, $module)) {
            if (null == $this->_auth->hasIdentity()) {
                //$module = $this->_noauth['module'];
                $controller = $this->_noauth['controller'];
                $action = $this->_noauth['action'];
            }else{
                $module = $this->_noacl['module'];
                $controller = $this->_noacl['controller'];
                $action = $this->_noacl['action'];
            }
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