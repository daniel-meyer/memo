<?php

function valid_childage($params)
{
  	$birthDate = $params[0];
  	$year = $params[1];
	$month = $params[2];
	$day = $params[3];
	
	$oDate = new DateTime;
    $oDate->setDate($year, $month, $day);
    
    $array = Etd_Date::explodeDiff($birthDate, $oDate);
	
    if($array[0] < 6){
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
    }*/
	if($array[0] > 16){
        return false;
    }

  	return true;
}