<?php

/*
* validator.zipcode.php 
* 
*/
function valid_zipcode($value)
{
    if (!preg_match("/^[0-9]{2}-[0-9]{3}$/i", $value)) {
		return false; 
    }
	
	return true;
}
