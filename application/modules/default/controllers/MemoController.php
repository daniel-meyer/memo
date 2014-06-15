<?php

class MemoController extends Etd_Controller_Action {

    function init() {
        parent::init();
    }

    public function indexAction() {
		$count = Orm::factory('Memo')->count(array("answer!=?" => ''));
		$offset = rand(0, floor($count/50)) * 50; 
		$this->view->memos = Orm::factory('Memo')->fetchAll("answer!=''", 'submit_date DESC', 50, $offset);
    }
	
    public function lastAction() {
		$this->view->memos = Orm::factory('Memo')->fetchAll("answer!=''", 'submit_date DESC', 50);
		$this->render('index');
    }
    public function sendAction() {
        /**
         * Wyslij odpowiedz json
         */
        $rq = $this->getRequest();
        if ($rq->isPost()) {


            if ($errors = $this->validForm()) {
                $data = $errors;
            } else {
                $form = Orm::factory('Memo')->create(array_map('strip_tags', $rq->getPost()));
                $form->setSubmitDate(new DateTime);
                $form->setActive(1);

                $form->save();
                /*
                $settings = Zend_Registry::get('settings');
                // generowanie maila
                $mail = new Etd_Mail('utf-8');
                $this->view->form = $form;
                $this->view->title = 'Formularz kontaktowy';
                $this->view->content = $this->getRequest()->getControllerName() . '/@send.tpl';
                $mail->setBodyHtml($this->view->render('../../default/views/@mail.tpl'));
                $mail->setFrom($settings->siteEmail, $settings->siteTitle);
                $mail->addTo($settings->siteEmail);
                $mail->setSubject($this->view->title);
                $mail->send();
                 */
                $data = array('success' => true);
            }

            $this->_helper->json($data);
        }
    }

    private function validForm() {
        $rq = $this->getRequest();
        
        $translate = Zend_Registry::get('Zend_Translate');

        $message = array(
            'question' => $translate->_('Please enter the question'),
            'ajax' => $translate->_('This is not ajax request'),
        );

        $vNotEmpty = new Zend_Validate_NotEmpty();
        if ($vNotEmpty->isValid($rq->getPost('question'))) {
            unset($message['question']);
        }
        
        if($rq->isXmlHttpRequest()){
            unset($message['ajax']);
        }
        

        return $message;
    }

}
