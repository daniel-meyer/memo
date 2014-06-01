<?php

class Model_DbTable_Role extends Zsamer_Db_Table_Orm
{

    protected $_name = 'role';

    protected $_primary = 'id';

    protected $_dependentTables = array(
        'Model_DbTable_UserRole',
        'Model_DbTable_UserRole'
        );


}

