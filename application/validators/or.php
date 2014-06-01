<?php

function valid_or($params)
{
	foreach($params as $value){
	   if(!empty($value))return true;
	}
    return false;
}