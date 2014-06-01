<?php

function valid_isimage($name)
{
    if(!empty($_FILES[$name])){
        $ext = strtolower( substr(strrchr($_FILES[$name]['name'], '.'), 1));
        
        if(in_array($ext, array('jpg', 'jpeg'))){
            return true;
        }
    }  
    return false;
}
