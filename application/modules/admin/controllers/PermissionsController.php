<?php

class Admin_PermissionsController extends Etd_Controller_Action
{

    public function init()
    {
        parent::init();
        
    }

    public function indexAction()
    {
        // get roles
        $this->view->roles = $this->_em->getRepository('Entity\Role')->findAll();
        
        $this->view->cols = array(
            'ID' => '',
            'Rola' => '',
            'Operacje' => '',    
        );
    }

    public function editAction()
    {
        // get role
        $role = $this->_em->find('Entity\Role', $this->_getParam('id'));
        
        // go away if no role
        if(null == $role){
            $this->addMessage('Nie znaleziono pozycji', 'fail');
            $this->redirectToUrl(array('action'=>'index'));   
        }
        
        // get all resources
        $this->view->resources = $this->_em->getRepository('Entity\ResourceController')->findAll();
        
        // get role permission
        $permission_ids = array();
        foreach($role->getResourceActions() as $resource){
            $ra_id = $resource->getId();
            $permission_ids[$ra_id] = $ra_id;
        }
        
        // save
        if($this->_request->isPost()){
            $permissions = $this->_getParam('permissions');
            
            // delete old permissions
            foreach($role->getResourceActions() as $ra){
                $role->getResourceActions()->removeElement($ra);
            }
            
            // add new permissions
            foreach($permissions as $action_id){
                
                $ra = $this->_em->find('Entity\ResourceAction', $action_id);
                if(null != $ra){
                    $role->addResourceActions($ra);
                }
            }
        
            $this->_em->flush();
            
            $this->addMessage('Zapisano zmiany', 'succ');
            $this->redirectToUrl();
  
        }
        
        $this->view->permission_ids = $permission_ids;
        $this->view->role = $role;
    }


}
