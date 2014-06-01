<?php

class Admin_UsersController extends Etd_Controller_Action
{

    public function init()
    {
        parent::init();
        
        $this->view->provinces = Service::factory('Province')->getAssoc();
        
    }

    public function indexAction()
    {
        
        //jesli użyto wyszykiwarki, zamień na zendowy link
        $this->prepareZendRequest();
        
        $cols = array(
            'ID' => 'id',
            'E-mail' => 'email',  
            'Imie' => 'firstname',  
            'Nazwisko'=>'lastname',  
            'Data rejestracji' =>'register_date',
            //'Role' => '',  
            //'Status'=>'o.active',
            '' => '',
        );
        
        $sort = $this->_getParam('sort');
        $by = $this->_getParam('by');
        
        // domyslne sortowanie
        if(!$sort || !in_array($sort, $cols)){
            $sort = 'id';
        }
        if(!$by || !in_array($by, array('asc', 'desc'))){
            $by = 'desc';
        }
        
        // query builder
        $select = Orm::factory('User')->select()->order($sort.' '.$by);
        
        // paginacja        
        $paginator = Zend_Paginator::factory($select);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1))
                  ->setItemCountPerPage(30)
                  ->setPageRange(10);
        
        //
        $this->view->paginator = $paginator;
        $this->view->cols = $cols;
        $this->view->sort = $sort;
        $this->view->by = $by;
    }
    
    public function addAction()
    {
        $id = (int)$this->_getParam('id');
        $rq = $this->getRequest();
        
        // save
        $validate = Etd_View_Smarty_Validate::getInstance();
        if($rq->isPost() && $validate->isValid()){
            
            $item = Orm::factory('User')->create();
            $item->populate($rq->getPost());
            $item->setRegisterDate(new DateTime);
            $item->setPassword(md5($rq->getPost('new_pass')));
            $item->save();
            
            $this->addMessage('Dodano nowego użytkownika', 'succ');
            $this->redirectToUrl(array('action'=>'index', 'id'=>null));
        }
        
    }
    
    public function editAction()
    {
        $id = (int)$this->_getParam('id');
        $rq = $this->getRequest();

        // pobierz osobe
        $item = $this->_getEntity($id);
        
        // save
        $validate = Etd_View_Smarty_Validate::getInstance();
        if($rq->isPost() && $validate->isValid()){
            
            $item->populate($rq->getPost());
            
            if($rq->getPost('change_pass')){
                $item->setPassword(md5($rq->getPost('new_pass')));
            }
            $item->save();
            
            $this->addMessage('Zapisano zmiany', 'succ');
            $this->redirectToUrl();
  
        }
        
        $this->view->item = $item;
    }
        
    protected function _getEntity($id)
    {
        // pobierz 
        $item = Orm::factory('User')->findById($id);
        
        // wyjdz, jesli nie znaleziono w bazie
        if(null == $item->getId()){
            $this->addMessage('Nie znaleziono użytkownika w bazie', 'fail');
            $this->redirectToUrl(array('action'=>'index', 'id'=>null));
            return null;   
        }
        return $item;
    }
    
    public function deleteAction()
    {
        $id = (int)$this->_getParam('id');
                
        // pobierz osobe
        $item = $this->_getEntity($id);
        $item->delete();
        
        $this->addMessage('Usunięto użytkownika z bazy', 'succ'); 
        $this->redirectToUrl(array('action'=>'index', 'id'=>null));
    }
    
}
