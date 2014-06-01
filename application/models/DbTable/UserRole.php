<?php

class Model_DbTable_UserRole extends Zsamer_Db_Table_Orm
{

    protected $_name = 'user_role';

    protected $_primary = array(
        'user_id',
        'role_id'
        );

    protected $_referenceMap = array(
        'Role' => array(
            'columns' => array('Role_id'),
            'refTableClass' => 'Model_DbTable_Role',
            'refColumns' => array('id')
            ),
        'columns' => array('Role' => 'Role_id'),
        'refColumns' => array('Role' => 'id')
        );


}

