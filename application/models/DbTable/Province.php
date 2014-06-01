<?php

class Model_DbTable_Province extends Zsamer_Db_Table_Orm
{

    protected $_name = 'province';

    protected $_primary = 'id';

    protected $_dependentTables = array('Model_DbTable_User');


}

