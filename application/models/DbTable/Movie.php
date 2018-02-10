<?php

class Model_DbTable_Movie extends Zsamer_Db_Table_Orm
{
    protected $_name = 'movie';
    protected $_primary = 'id';
    protected $_referenceMap = array(
        'User' => array(
            'columns' => array('user_id'),
            'refTableClass' => 'Model_DbTable_User',
            'refColumns' => array('id')
        )
    );

}

