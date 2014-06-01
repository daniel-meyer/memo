<?php

class Admin_SettingsController extends Etd_Controller_Action
{
    public function init()
    {
        parent::init();
        
        $this->view->tabs = array(
            1 => 'Ogólne',
            'Zaawansowane',
            'Metatagi',
            
        );
        
    }

    public function indexAction()
    {
        // get entities
        $entities = Orm::factory('Setting')->findAll();
        
        $rq = $this->getRequest();

        if($rq->isPost()){
            // save for all
            foreach($entities as $entity){
                $entity->setValue($rq->getPost($entity->getName()));
                $entity->save();
            }
            
            $this->addMessage('Zapisano zmiany', 'succ');
            $this->redirectToUrl();
        }
        
        $this->view->entities = $entities;
    }
    
    public function addAction()
    {        
        $rq = $this->getRequest();
        
        // save
        $validation = Etd_View_Smarty_Validate::getInstance();
        if($rq->isPost() && $validation->isValid()){
            
            $setting = Orm::factory('Setting')->create($rq->getPost());
            
            $setting->save();
            
            
            $this->addMessage('Zapisano zmiany', 'succ');
            $this->redirectToUrl();
  
        }

        
        $this->view->types = array(
            'input-text',
            'textarea',
            'fck-editor'
        );
    }


}
