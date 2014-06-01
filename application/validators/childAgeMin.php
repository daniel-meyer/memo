<?php

function valid_childagemin($params)
{
  	$year = $params[0];
	$month = $params[1];
	$day = $params[2];
	
	$birthDate = new DateTime;
    $birthDate->setDate($year, $month, $day);
    
    $array = Etd_Date::explodeDiff($birthDate);

    if($array[0] < 5){
        return false;
    }
    /*
    if($array[0] == 6 && $array[1] <= 6){ 
        return false;
    }

    if($array[0] > 18){
        return false;
    }
    
    if($array[0] == 18 && $array[1] >= 5){
        return false;
    }
	if($array[0] > 16){
        return false;
    }*/

  	return true;
}