<?php
 
function valid_recaptcha($value)
{
    if(empty($_POST['recaptcha_challenge_field'])
    || empty($_POST['recaptcha_response_field'])){
        return false;
    }
    
    
    $recaptcha = Zend_Registry::get('recaptcha');
    
    $result = $recaptcha->verify(
        $_POST['recaptcha_challenge_field'],
        $_POST['recaptcha_response_field']
    );
    
    if (!$result->isValid()) {
        return false;
    }

	return true;
}
 