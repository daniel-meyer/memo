<?php

function valid_isemail($email)
{
    $validator = new Zend_Validate_EmailAddress();

	return $validator->isValid($email);
}