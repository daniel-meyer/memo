<?php

/**
  * validator.usernotexists
  * parametr 2 opcjonalny
  */
 function valid_userNotExists($params)
 {
	if(!is_array($params)){
	   $value = $params;
       $value2 = '';
	}else{
	   $value = $params[0];
	   $value2 = $params[1];
	}

    $doctrine = Zend_Registry::get('doctrine');
    $em = $doctrine->getEntityManager();
    $user = $em->getRepository('Entity\User')->findOneBy(array('email'=>$value));
    
    if(null != $user && ($value)!= $value2){
        return false;
    }
    
	return true;
}
 