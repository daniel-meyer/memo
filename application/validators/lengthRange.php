<?php
function valid_numberRange($params)
{
    if(strlen($params[0]) >= $params[1] && strlen($params[0]) <= $params[2]){
        return true;
    }else{
        return false;
    }
}