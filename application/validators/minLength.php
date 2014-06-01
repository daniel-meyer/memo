<?php

function valid_minLength($params)
{
    if (strlen($params[0])<$params[1] ) {
		return false; 
    }
	
	return true;
}