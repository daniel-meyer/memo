<?php

function valid_isSeparator($value)
{
    if($value === '' && $value === null){
        return false;
    }else{
        return true;
    }
}