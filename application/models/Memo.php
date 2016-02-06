<?php

class Model_Memo extends Zsamer_Db_Table_Row_Orm
{
    public function setQuestion($value) {
        $this->question = trim(strtolower($value));
    }
}