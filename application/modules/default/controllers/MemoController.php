<?php

class MemoController extends Etd_Controller_Action
{
    function init()
    {
        parent::init();
    }

    public function indexAction()
    {
        $select = Orm::factory('Memo')
            ->select()
            ->from('memo')
            ->setIntegrityCheck(false)
            ->joinLeft(array('s' => 'memo_stat'), 'memo.id=s.memo_id', null)
            ->where("answer != ''")
            ->where('s.id IS NULL OR ( s.next_exam < NOW() )')
            ->order(array('s.next_exam ASC', 'submit_date ASC'))
            ->limit($this->_settings->memoLimit);

        $this->view->memos = Orm::factory('Memo')->fetchAll($select);    }

    public function lastAction()
    {
        $select = Orm::factory('Memo')
            ->select()
            ->from('memo')
            ->setIntegrityCheck(false)
            ->joinLeft(array('s' => 'memo_stat'), 'memo.id=s.memo_id', null)
            ->where("answer != ''")
            ->where('s.id IS NULL')
            ->order('submit_date DESC')
            ->limit($this->_settings->memoLimit);

        $this->view->memos = Orm::factory('Memo')->fetchAll($select);
        $this->render('index');
    }



    public function sendAction()
    {
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
                // generowanie maila
                $mail = new Etd_Mail('utf-8');
                $this->view->form = $form;
                $this->view->title = 'Formularz kontaktowy';
                $this->view->content = $this->getRequest()->getControllerName() . '/@send.tpl';
                $mail->setBodyHtml($this->view->render('../../default/views/@mail.tpl'));
                $mail->setFrom($this->_settings->siteEmail, $this->_settings->siteTitle);
                $mail->addTo($this->_settings->siteEmail);
                $mail->setSubject($this->view->title);
                $mail->send();
                 */
                $data = array('success' => true);
            }

            $this->_helper->json($data);
        }
    }

    public function saveStatsAction()
    {
        $data = array('success' => false);
        $userId = 1;
        $rq = $this->getRequest();
        if (is_array($rq->getPost('answers') )) {
            foreach ($rq->getPost('answers') as $memoId => $grade) {
                $stat = Orm::factory('MemoStat')->findOneBy(array('memoId' => $memoId, 'userId' => $userId));
                if (!$stat) {
                    $stat = Orm::factory('MemoStat')->create(array('memoId' => $memoId, 'userId' => $userId, 'grades' => $grade));
                } else {
                    $stat->setGrades($stat->getGrades() . ',' . $grade);
                }

                $stat->setGrade($grade);

                $examDate = new DateTime;
                $examDate->modify($grade ? '+1 month' : '+1 day');
                $stat->setNextExam($examDate);
                $stat->save();
                $data = array('success' => true);
            }

        }
        $this->_helper->json($data);
    }

    private function validForm()
    {
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

        if ($rq->isXmlHttpRequest()) {
            unset($message['ajax']);
        }

        return $message;
    }
}
