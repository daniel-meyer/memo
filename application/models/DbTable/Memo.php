<?php

class Model_DbTable_Memo extends Zsamer_Db_Table_Orm
{

    protected $_name = 'memo';

    protected $_primary = 'id';

    protected $_dependentTables = array(
        'Model_DbTable_MemoStat'
    );

}

