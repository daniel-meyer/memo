<?php

function valid_bloodPressure($params)
{
    if($params[0] < 10 || $params[0]>240){
        return false;
    }
    if($params[1] < 10 || $params[1]>240){
        return false;
    }
    return true;
}