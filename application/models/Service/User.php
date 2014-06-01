<?php

class Model_Service_User
{
    public function getUser()
    {        
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            return Orm::factory('User')->findOneBy(array('email' => $auth->getIdentity()));
        }
        return null;
    }
   
}        