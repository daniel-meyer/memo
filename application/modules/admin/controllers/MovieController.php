<?php

class Admin_MovieController extends Etd_Controller_Action
{

    public function init()
    {
        parent::init();
    }

    public function indexAction()
    {
        
        //jesli użyto wyszykiwarki, zamień na zendowy link
        $this->prepareZendRequest();
        
        $cols = array(
            'ID' => 'id',
            'Movie' => 'movie',
            'Date' => 'submit_date',
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
        $select = Orm::factory('Movie')->select()->order($sort . ' ' . $by);

        if ($word = $this->_getParam('word')) $select->where('movie LIKE ? or date LIKE ?', '%' . $word . '%');

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
        $rq = $this->getRequest();

        // save
        $validate = Etd_View_Smarty_Validate::getInstance();
        if ($rq->isPost() && $validate->isValid()) {

            $entity = Orm::factory('Movie')->create();
            $entity->populate($rq->getPost());
            $entity->setUser(Service::factory('User')->getUser());
            $entity->save();

            $this->addMessage('Dodano nowy film', 'succ');
            $this->redirectToUrl(array('action' => 'index', 'id' => null));
        }
    }

    public function editAction()
    {
        $id = (int)$this->_getParam('id');
        $rq = $this->getRequest();

        // pobierz osobe
        $entity = $this->_getEntity($id);
        
        // save
        $validate = Etd_View_Smarty_Validate::getInstance();
        if($rq->isPost() && $validate->isValid()){
            
            $entity->populate($rq->getPost());
            $entity->save();
            
            $this->addMessage('Zapisano zmiany', 'succ');
            //$this->redirectToUrl();
            $this->redirectToUrl(array('action'=>'index', 'id'=>null));
  
        }

        $this->view->entity = $entity;
    }
        
    protected function _getEntity($id)
    {
        // pobierz 
        $entity = Orm::factory('Movie')->findById($id);
        
        // wyjdz, jesli nie znaleziono w bazie
        if(null == $entity->getId()){
            $this->addMessage('Nie znaleziono filmu w bazie', 'fail');
            $this->redirectToUrl(array('action'=>'index', 'id'=>null));
            return null;   
        }
        return $entity;
    }
    
    public function deleteAction()
    {
        $id = (int)$this->_getParam('id');
                
        // pobierz
        $entity = $this->_getEntity($id);
        $entity->delete();
        
        $this->addMessage('Usunięto film z bazy', 'succ');
        $this->redirectToUrl(array('action'=>'index', 'id'=>null));
    }
    
}
