<?php
 
function valid_captcha($value)
{
    if(empty($value)){
        return false;
    }
    
    $captcha = Zend_Registry::get('Etd_Captcha');

	return $captcha->isValid($value);
}
 