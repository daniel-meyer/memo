<?php

function valid_isPesel($value)
{
    if(is_numeric($value) && strlen($value)==11){
        return true;
    }else{
        return false;
    }
}
/*
function valid_pesel($params)
{
    $pesel = $params[0];
    $sex = $params[1];
    
    $date = new DateTime;
    
    if(isset($params[4])){
        // data - osobno rok miesiac dzien
        $date->setDate($params[2], $params[3], $params[4]);
    }else{
        // strtotime
        $date = new DateTime($params[2]);
    }
    
}


function CheckPesel($pesel, $date, $sex)
{
    $weights = array(1,3,7,9,1,3,7,9,1,3);
    $Sum = 0;
    for($i = 0; $i < 10; $i++){
        $sum += $pesel[$i] * $weights[$i];
    }
    $sum = $sum % 10;
    $checkSum = (10 - $sum) % 10;
    if ($pesel[10] <> $checkSum){
        return false;
    }else{
        if ($pesel[9] % 2 == 1){
            $peselSex = 'm' ;
        }else{
            $peselSex = 'f';
        }    
        $yearEndStr = substr($pesel, 0, 2);
        $monthStr= substr($pesel, 2, 2);
        $dayStr = substr($pesel, 4,2);
        $day = intval($dayStr);
        $month = intval($monthStr);
        if ($day > 31) return false;
        else
        {
            $yearStartStr = '19';
            if ($month >= 80)
            {
                $yearStartStr = '18';
                $month = $month - 80;
            }
            elseif ($month >= 60)
            {
                $yearStartStr = '22';
                $month = $month - 60;
            }
            elseif ($month >= 40)
            {
                $yearStartStr = '21';
                $month = $month - 40;
            }
            elseif($month >= 20)
            {
                $yearStartStr = '20';
                $month = $month - 20;
            }
        }
        $yearStr = $yearStartStr.$yearEndStr;
        $year = intval($yearStr);
        if (($month < 1) or ($month > 12))
        return false;
        else
        {
            if ($month == 2){
                if ($day > 29) return false;
                elseif (($day == 29) and (($year % 4) <> 0) or ($yearEnd == '00')) return false;
            }
            elseif (($day == 31) and (($month == 4) or ($month == 6) or ($month == 9) or ($month == 11)))
                return false;
        }
    }
    
    //date
    $peselDate = new DateTime()->setDate($yearStr, $month, $day);
    if($date->format('Ymd') != $peselDate->format('Ymd')){
        return false;
    }
    
    //sex
    if($sex!= $peselSex){
        return false;
    }
    
    return true;
}*/