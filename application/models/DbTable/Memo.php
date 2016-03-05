<?php

class Model_DbTable_Memo extends Zsamer_Db_Table_Orm
{

    protected $_name = 'memo';

    protected $_primary = 'id';

    protected $_dependentTables = array(
        'Model_DbTable_MemoStat'
    );
    
    protected $_referenceMap = array(
        'User' => array(
            'columns' => array('user_id'),
            'refTableClass' => 'Model_DbTable_User',
            'refColumns' => array('id')
        )
    );

    protected $_rowClass = 'Model_Memo';
}

