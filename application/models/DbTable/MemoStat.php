<?php

class Model_DbTable_MemoStat extends Zsamer_Db_Table_Orm
{

    protected $_name = 'memo_stat';

    protected $_primary = 'id';

    protected $_referenceMap = array(
        'Memo' => array(
            'columns' => array('memo_id'),
            'refTableClass' => 'Model_DbTable_Memo',
            'refColumns' => array('id')
        )
    );

}

