<?php


function valid_onlyletters($value)
{
    if (!empty($value) && !preg_match("/^[A-Za-z]{1,}$/", $value)) {
		return false; 
    }
	
	return true;
}
 
