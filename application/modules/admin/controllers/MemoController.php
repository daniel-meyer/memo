<?php

class Admin_MemoController extends Etd_Controller_Action
{
    const STATUS_KNOWN = 1;
    const STATUS_TO_LEARN = 2;
    const STATUS_IGNORED = 0;

    public function init()
    {
        parent::init();
    }

    public function indexAction()
    {
        
        //jesli użyto wyszykiwarki, zamień na zendowy link
        $this->prepareZendRequest();
        
        $cols = array(
            'ID' => 'e.id',
            'Question' => 'question',
            'Answer' => 'answer', 
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
        $select = Orm::factory('Memo')->select()->order($sort.' '.$by);

        
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
    
    public function exportToSupermemoAction()
    {
        $this->_helper->getHelper('Layout')->disableLayout();
        $this->_helper->getHelper('ViewRenderer')->setNoRender(true);
        
        $all = Orm::factory('Memo')->fetchAll(array('active=?'=>1));
        
        $out = '';
        
        foreach ($all as $item) {
            $out .= 'Q: ' . iconv("UTF-8", "WINDOWS-1250", $item->getQuestion()) . "\r\n";
            $out .= 'A: ' . iconv("UTF-8", "WINDOWS-1250", $item->getAnswer()) . "\r\n\r\n";
            
            $item->setActive(2);
            $item->save();
        }
        
        
        
        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename=supermemo-" . date('Y-m-d-G-i-s') . ".txt");
        echo $out;
    }
    
    public function exportQuestionsAction()
    {
        $this->_helper->getHelper('Layout')->disableLayout();
        $this->_helper->getHelper('ViewRenderer')->setNoRender(true);
        
        $all = Orm::factory('Memo')->fetchAll();
        $out = '';
        foreach ($all as $item) {
            $out .=  iconv("UTF-8", "WINDOWS-1250", $item->getQuestion()) . " ";
        }

        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename=questions-" . date('Y-m-d-G-i-s') . ".txt");
        echo $out;
    }
    
        
    public function ajaxActiveAction()
    {
        $this->_helper->getHelper('Layout')->disableLayout();
        $this->_helper->getHelper('ViewRenderer')->setNoRender(true);
        
        $id = (int)$this->_getParam('id');
        $status = (int)$this->_getParam('status');
        
        $entity = Orm::factory('Memo')->findById($id);
        if($entity){
            if($entity->getActive()){
                // nie publikuj
                $entity->setActive(0);
                echo <<< END
              <i class="admin-sprite" style="background-position: 0 -120px;"></i>  
END;
            }else{
                // publikuj
                $entity->setActive(1);
                echo <<< END
                <i class="admin-sprite" style="background-position: -20px -120px;"></i>  
END;
            }
            
            $entity->save();
        }
    }
    
    public function addAction()
    {
        $id = (int)$this->_getParam('id');
        $rq = $this->getRequest();
        
        // save
        $validate = Etd_View_Smarty_Validate::getInstance();
        if($rq->isPost() && $validate->isValid()){
            
            $entity = Orm::factory('Memo')->create();
            $entity->populate($rq->getPost());

            $entity->setSubmitDate(new DateTime);
            $entity->save();
            
            $this->addMessage('Dodano nowy artykuł', 'succ');
            $this->redirectToUrl(array('action'=>'index', 'id'=>null));
        }
        
    }
    
    public function importAction()
    {
        $rq = $this->getRequest();
        
        // save
        $validate = Etd_View_Smarty_Validate::getInstance();
        if($rq->isPost() && $validate->isValid()){
            $i = 0;
            
            $questions = explode($rq->getPost('separator'), $rq->getPost('content'));
            
            foreach($questions as $question){
                $question = trim($question);
                if(!$question)continue;
                $entity = Orm::factory('Memo')->create();
                $entity->setQuestion($question);
                
                $entity->setSubmitDate(new DateTime);
                $entity->save();
                $i++;
            }
            
            $this->addMessage('Zaimportowano ' . $i , 'succ');
            $this->redirectToUrl(array('action'=>'index', 'id'=>null));
        }
        
    }
    
    public function importSrtAction()
    {
        switch($this->getRequest()->getPost('submit')) {
            case 'load':
                $this->view->words = $this->getNewAnswersFromSrtFile();
                break;
            case 'save':
                $this->saveSrtAnswers();
        }
    }

    public function saveSrtAnswers()
    {
        $rq = $this->getRequest();

        $questions = $rq->getPost('question');
        $answers = $rq->getPost('answer');
        $statuses = $rq->getPost('status');
        $i = 0;
        if (is_array($questions) && is_array($answers) && is_array($statuses)){
            foreach($questions as $k => $question){
                $question = trim($question);
                $status = (int)$statuses[$k];
                $answer = trim($answers[$k]);
                if (!$question) continue;
                if ($status == self::STATUS_IGNORED) continue;

                $entity = Orm::factory('Memo')->create();
                $entity->setQuestion($question);
                if ($status == self::STATUS_TO_LEARN ) {
                    $entity->setAnswer($answer);
                    $entity->setActive(1);
                }
                $entity->setSubmitDate(new DateTime);
                $entity->save();
                $i++;
            }

            $this->addMessage('Zaimportowano ' . $i , 'succ');
            $this->redirectToUrl(array('action'=>'index', 'id'=>null));
        } else {
            $this->addMessage('Nie zaimportowano niczego ', 'warn');
        }

    }

    private function getNewAnswersFromSrtFile()
    {
        if (empty($_FILES['file'])) return array();
        $ignore = array('.', '"', ',', ':', ';', '?', '%', '!', '@', '#', '$', '^', '*', '(', ')', '[', ']', '{', '}', '-', '+', '=', '>', '<', 1,2,3,4,5,6,7,8,9,0);

        $all = Orm::factory('Memo')->fetchPairs('id', 'question');
        $words = array();
        $lines = file($_FILES['file']['tmp_name']);
        foreach ($lines as $line_num => $line) {
            $line = str_replace('  ', ' ', str_replace($ignore, '', strtolower($line)));

            $wordsLine = explode(' ', $line);
            $wordsLine = array_map('trim', $wordsLine);
            $wordsLine = $this->removeEmptyItems($wordsLine);
            if(empty($wordsLine))continue;
            $newWords = $this->removeIfIssetItem($wordsLine, $all);
            if(empty($newWords))continue;
            $newWords = array_combine($newWords, $newWords);
            $words = array_merge($words, $newWords);
        }
        return $words;
    }
    
    private function removeEmptyItems($array)
    {
        foreach($array as $k=>$v)
            if($v=trim($v) == '' || strlen($v)<3 || strstr($v, "'"))unset($array[$k]);
        return $array;
            
    }
    private function removeIfIssetItem($array, $resource)
    {
        foreach($array as $k=>$v)
            if(array_search($v, $resource))unset($array[$k]);
        return $array;
            
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
        $entity = Orm::factory('Memo')->findById($id);
        
        // wyjdz, jesli nie znaleziono w bazie
        if(null == $entity->getId()){
            $this->addMessage('Nie znaleziono atykułu w bazie', 'fail');
            $this->redirectToUrl(array('action'=>'index', 'id'=>null));
            return null;   
        }
        return $entity;
    }
    
    public function deleteAction()
    {
        $id = (int)$this->_getParam('id');
                
        // pobierz osobe
        $entity = $this->_getEntity($id);
        $entity->delete();
        
        $this->addMessage('Usunięto atykuł z bazy', 'succ'); 
        $this->redirectToUrl(array('action'=>'index', 'id'=>null));
    }
    
}
