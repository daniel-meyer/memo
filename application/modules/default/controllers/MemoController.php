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
            ->joinLeft(array('s' => 'memo_stat'), 'memo.id=s.memo_id', array('next_exam'))
            ->where("answer != ''")
            ->order(array('s.next_exam ASC', 'submit_date ASC'))
            ->limit($this->_settings->memoLimit);

        $listSelect = clone $select;
        $listSelect->where('s.id IS NULL OR ( s.next_exam < NOW() )');

        $this->view->memos = Orm::factory('Memo')->fetchAll($listSelect);
        if (count($this->view->memos) == 0) {
            $this->view->nextMemo = Orm::factory('Memo')->fetchRow($select->limit(1));
            $this->render('next');
        }
    }

    public function lastAction()
    {
        $select = Orm::factory('Memo')
            ->select()
            ->from('memo')
            ->setIntegrityCheck(false)
            ->joinLeft(array('s' => 'memo_stat'), 'memo.id=s.memo_id', null)
            ->where("answer != ''")
            ->order('submit_date DESC')
            ->limit($this->_settings->memoLimit);

        if (!$this->_getParam('all')) {
            $select->where('s.id IS NULL');
        }

        $this->view->memos = Orm::factory('Memo')->fetchAll($select);
        $this->render('index');
    }

    public function lastFailedAction()
    {
        $select = Orm::factory('Memo')
            ->select()
            ->from('memo')
            ->setIntegrityCheck(false)
            ->joinLeft(array('s' => 'memo_stat'), 'memo.id=s.memo_id', null)
            ->where("answer != ''")
            ->where('grades LIKE ?', '%0')
            ->order(array('s.next_exam ASC', 'submit_date ASC'))
            ->limit($this->_settings->memoLimit);

        $this->view->memos = Orm::factory('Memo')->fetchAll($select);
        $this->view->withoutSaving = true;
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
                $form = Orm::factory('Memo')->create();
                $form->setQuestion($rq->getPost('question'));
                $form->setAnswer($rq->getPost('answer'));
                $form->setSubmitDate(new DateTime);
                $form->setActive(1);
                $form->save();

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
        if (is_array($rq->getPost('answers'))) {
            foreach ($rq->getPost('answers') as $memoId => $grade) {
                $stat = Orm::factory('MemoStat')->findOneBy(array('memo_id' => $memoId, 'user_id' => $userId));
                if (!$stat) {
                    $stat = Orm::factory('MemoStat')->create(array('memo_id' => $memoId, 'user_id' => $userId, 'grades' => $grade));
                } else {
                    $stat->setGrades($stat->getGrades() . ',' . $grade);
                }
                $stat->setGrade($grade);
                $stat->setNextExam($this->getNextExamDate($stat->getGrades()));
                $stat->save();
                $data = array('success' => true);
            }
        }
        $this->_helper->json($data);
    }

    private function getNextExamDate($grades)
    {
        $date = new DateTime;
        if (substr($grades, -7) == '0,1,1,1') {
            $date->modify('+1 week');
        } elseif (substr($grades, -5) == '1,1,1') {
            $date->modify('+1 month');
        } elseif (substr($grades, -5) == '0,1,1') {
            $date->modify('+3 days');
        } elseif (substr($grades, -5) == '0,0,1') {
            $date->modify('+1 day');
        } elseif (substr($grades, -3) == '1,1') {
            $date->modify('+1 week');
        } elseif (substr($grades, -3) == '0,1') {
            $date->modify('+1 day');
        } elseif (substr($grades, -1) == '1') {
            $date->modify('+3 days');
        } else {
            $date->modify('+2 hours');
        }
        return $date;
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

        if (!array_key_exists('question', $message) && Orm::factory('Memo')->count(array('question' => trim(strtolower(strip_tags($rq->getPost('question'))))))) {
            $message['question'] = 'This question already exist in database';
        }

        return $message;
    }
}
