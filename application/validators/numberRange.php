<?php
function valid_numberRange($params)
{
    if(is_numeric($params[0]) && $params[0] >= $params[1] && $params[0] <= $params[2]){
        return true;
    }else{
        return false;
    }
}