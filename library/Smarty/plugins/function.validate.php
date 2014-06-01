<?php
/*
* Smarty plugin
* -------------------------------------------------------------
* File:     function.validate.php
* Type:     function
* Name:     validate
* Purpose:  validate function from Validate.PHP library
* -------------------------------------------------------------
*/
function smarty_function_validate($params, &$smarty) {
	extract($params);
	
    $oValid = Etd_View_Smarty_Validate::getInstance();
    
    if (false == $oValid->isEnabledValidate()) {
		return;
    }
    
    // default
    if(!isset($important)){
        $important = true;
    }
    
    /** 
     *  Check if field has a failed flag 
     */
    $validationErrors = $oValid->getValidationErrors();
    if (false == empty($validationErrors[$check])) {
        echo $message;
        return;
    }

    /** 
     *  Write new serialized array containging check name
     */
    $validationArray = $oValid->getValidationData();
    if (!isset($validationArray[$check])) {
        $validationArray[$check] = array(
            'check' => $check,
            'important' => $important
        );    
        $oValid->setValidationData($validationArray);
    }
}
 
