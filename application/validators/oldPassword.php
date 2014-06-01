<?php

function valid_oldPassword($value)
{
    if(empty($value)){
        return false;
    }
    
    $auth = Zend_Auth::getInstance();
    
    if(false == $auth->hasIdentity()){
        return false;
    }
    
    if($auth->getUser()->getPassword() != sha1($value)){
        return false;
    }

	return true;
}
 