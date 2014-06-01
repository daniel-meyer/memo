<?php

class Model_Service_Acl  extends Zend_Acl
{
    protected $aResources = array();
    protected $aRoles = array();
    protected $aPermissions = array();
    protected $config;
    protected $userRoles;
    protected $cache = null;
    
    
    // module - controller - action
    protected $defaultResources = array(
        'default' => array(
            'index' => array('index'),
            'error' => array('error', 'privileges'),
            'page' => array('index'),  
            'auth' => array('index','login','password-reset','change-password', 'logout'),  
            'cache' => array('clear', 'clear-all'),  
            'test' => array('index'), 
        ),
        'admin' => array(
            //'index' => array('index'),
            'auth' => array('index'),
        )        
    );

    protected $defaultRole = 'guest';



    public function __construct()
    {        
        //get config
        $this->config = Zend_Registry::get('config')->etd->acl;
        
        $this->cache = Zend_Registry::get('cache');
        
        //get roles from DB
        $this->aRoles = $this->_getRoles();
          
        //get resources from DB
        $this->aResources = $this->_getResources();
        
        //get permissions from DB
        $this->aPermissions = $this->_getPermissions();
        
        

        //add guest
        $this->addRole(new Zend_Acl_Role($this->defaultRole));
        
        //add roles - from DB        
        $this->_addRoles($this->aRoles);
        
        //add default resources
        $this->_addDelaultResources($this->defaultResources);

        //add resources - from DB
        $this->_addResources($this->aResources);
        
        //add default permissions
        $this->_addDelaultPermissions($this->defaultResources);
        
        //add permissions - from DB 
        $this->_addPermissions($this->aPermissions);


        //var_dump($this->getResources());
        var_dump($this->aPermissions);

		return $this;
    }
    
    protected function _getRoles()
    {
        $cacheName = 'acl_roles';
        if( ($result = $this->cache->load($cacheName)) === false ) {     
            $result = $this->_getRolesFromDB();
            $this->cache->save($result, $cacheName);
        }
        return $result;
    }
    
    protected function _getResources()
    {
        $cacheName = 'acl_resources';
        if( ($result = $this->cache->load($cacheName)) === false ) {     
            $result = $this->_getResourcesFromDB();
            $this->cache->save($result, $cacheName);
        }
        return $result;
    }
    
    protected function _getPermissions()
    {
        $cacheName = 'acl_permissions';
        if( ($result = $this->cache->load($cacheName)) === false ) {     
            $result = $this->_getPermissionsFromDB();
            $this->cache->save($result, $cacheName);
        }
        return $result;
    }
    
    protected function _getRolesFromDB()
    {
        $roles = $this->getRolesEntities();
        $out = array();
        foreach($roles as $role){
            $out[] = $role->getName();
        }
        return $out;
    }
    
    protected function _getResourcesFromDB()
    {
        $select = Orm::factory('AclResourceAction')
            ->select()
                ->setIntegrityCheck(false)
                ->from(array('ra'=>'acl_resource_action'), array('action'))
                ->joinInner(array('rc'=>'acl_resource_controller'), 'rc.id=ra.resource_controller_id', array('module', 'controller'))
                ->group('ra.id');
        
        $result = Orm::factory('AclResourceAction')->fetchAll($select);
        $out = array();
        foreach($result as $item){
            $out[] = $item->getModule() . ':' . $item->getController() . ':' . $item->getAction();
        }
        return $out;        
    }
    
    
    protected function _getPermissionsFromDB()
    {    
        $select = Orm::factory('AclRolePermission')
            ->select()
                ->setIntegrityCheck(false)
                ->from(array('rp'=>'acl_role_permission'), null)
                ->joinInner(array('r'=>'role'), 'r.id=rp.Role_id', array('role'=>'name'))
                ->joinInner(array('ra'=>'acl_resource_action'), 'ra.id=rp.resource_action_id', array('action'))
                ->joinInner(array('rc'=>'acl_resource_controller'), 'rc.id=ra.resource_controller_id', array('module', 'controller'))
                ;
        
        $result = Orm::factory('AclRolePermission')->fetchAll($select);
        $out = array();
        foreach ($result as $item){
            if(!isset($out[ $item->getRole() ])){
                $out[ $item->getRole() ] = array();
            }
            $out[ $item->getRole() ][] = 
                $item->getModule() . ':' .$item->getController() . ':' .$item->getAction();
		}
   
        return $out;   
    }
    
    protected function _addRoles($aRoles)
    {
		foreach ($aRoles as $role){
		    if(null == $this->hasRole($role)){
                $this->addRole(new Zend_Acl_Role($role));
            }
		}
    }
    
    protected function _addResources($aResources)
    {
		foreach ($aResources as $resource){            
            if(null == $this->has($resource)){
                $this->add(new Zend_Acl_Resource($resource));
            }
		} 
    }
    
    protected function _addDelaultResources(array $aDefaultResources)
    {
        foreach ($aDefaultResources as $module=>$controllers){
            foreach ($controllers as $controller=>$actions){
                foreach ($actions as $actions=>$action){ 
                    $this->add(new Zend_Acl_Resource($module.':'.$controller.':'.$action));
                }
            }    
		}
    }
    
    protected function _addPermissions(array $aPermissions)
    {
		foreach ($aPermissions as $role => $aResources){
            $this->allow($role, $aResources);    
		}
    }
       
    protected function _addDelaultPermissions(array $aDefaultResources)
    {
		foreach ($aDefaultResources as $module=>$controllers){
            foreach ($controllers as $controller=>$actions){
                foreach ($actions as $actions=>$action){
                    $aResources[] = $module.':'.$controller.':'.$action;
                }
            }
            $this->allow($this->defaultRole, $aResources);    
		}
    }
    
    public function getDefaultRole()
    {
        return $this->defaultRole;
    }
    
    public function getRolesEntities()
    {
        return Orm::factory('Role')->findAll();
    }
    
    public function tryGenerateResource($request)
    {
        //die("tryGenerateResource($module, $controller, $action)");
        if(false == $this->config->autoGenerateResources){
            return false;
        }
       
        $module = $request->getModuleName();
        $controller = $request->getControllerName();
        $action = $request->getActionName();

        if(false == $this->_actionExists($request) ){  
            //die('strona nie istnieje');
            return false;
        }
        $rc = Orm::factory('AclResourceController')->findOneBy(array('module'=>$module, 'controller'=>$controller));
        
        if( !$rc ){ //
            //generate controller resource
            $rc = Orm::factory('AclResourceController')->create() ;
            $rc->setModule($module);
            $rc->setController($controller);
            $rc->setComments('');
            
            $rc->save();
            
        }
        
        $ra = Orm::factory('AclResourceAction')->findOneBy(array('action'=>$action, 'resource_controller_id'=>$rc->getId()));
             
        if( !$ra ){
            //generate action resource
            $ra = Orm::factory('AclResourceAction')->create() ;
            $ra->setAction($action);
            $ra->setComments('');
            $ra->setAclResourceController($rc);
            
            $ra->save();
        }


        return true;
    }
    
    public function setUserRoles(array $roles)
    {
        $this->userRoles = $roles;
    }
        
    public function isAllowedUrl($action, $controller=null, $module=null)
    {
        $front = Zend_Controller_Front::getInstance();
        
        if(null == $controller){
            $controller = $front->getRequest()->getControllerName();
        }
        if(null == $module){
            $module = $front->getRequest()->getModuleName();
        }
        
        $resource = $module.':'.$controller.':'.$action;

        return $this->_checkAccess($resource);
    }
    
    public function userHasRole($roleName)
    {
        return in_array($roleName, $this->userRoles);
    }
    
    protected function _checkAccess($resource)
    {
        foreach($this->userRoles as $role){
            if ($this->isAllowed($role, $resource)) {
                return true;
            }    
        }
        return false;
    }  
    
    /**
    * Return whether a given request (module-controller-action) exists
    *
    * @param Zend_Controller_Request_Abstract $request Request to check
    * @return boolean Whether the action exists
    */
    protected function _actionExists($request) 
    {
        $dispatcher = Zend_Controller_Front::getInstance()->getDispatcher();
              
        // Check controller
        if (!$dispatcher->isDispatchable($request)) {
            return false;
        }
               
        // Check action
        $controllerClassName = $dispatcher->formatControllerName( $request->getControllerName() );
        $controllerClassFile = $controllerClassName . '.php';
        if ($request->getModuleName() != $dispatcher->getDefaultModule()) {
            $controllerClassName = ucfirst($request->getModuleName()) . '_' . $controllerClassName;
        }
        try {
            require_once 'Zend/Loader.php';
            Zend_Loader::loadFile($controllerClassFile, $dispatcher->getControllerDirectory($request->getModuleName()));
            $actionMethodName = $dispatcher->formatActionName($request->getActionName());
            if (@in_array($actionMethodName, get_class_methods($controllerClassName))) {
                return true;
            }
            return false;
        } catch(Exception $e) {
            return false;
        }
    } 
 
} 