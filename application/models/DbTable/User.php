<?php

class Model_DbTable_User extends Zsamer_Db_Table_Orm
{

    protected $_name = 'user';

    protected $_primary = 'id';

    protected $_referenceMap = array('Province' => array(
            'columns' => array('province_id'),
            'refTableClass' => 'Model_DbTable_Province',
            'refColumns' => array('id')
            ));


}

