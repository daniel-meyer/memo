<?php

class Model_Memo extends Zsamer_Db_Table_Row_Orm
{
    public $question;
    public $answer;

    public function setQuestion($value) {
        $this->question = $this->trim($value);
    }

    public function setAnswer($value) {
        $this->answer = $this->trim($value);
    }

    protected function trim($value) {
        return strip_tags(trim(strtolower($value)));
    }
}