<?php

class Model_Memo extends Zsamer_Db_Table_Row_Orm
{

    public function setQuestion($value) {
        $this->setData('question', $this->trim($value));
    }

    public function setAnswer($value) {
        $this->setData('answer', $this->trim($value));
    }

    protected function trim($value) {
        return trim(strtolower(strip_tags($value)));
    }
}